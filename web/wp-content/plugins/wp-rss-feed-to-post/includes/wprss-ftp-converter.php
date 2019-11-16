<?php
/**
 * This file contains functions relating to converting wprss_feed_item posts to
 * standard WP posts
 * 
 * @since 1.0
 */

/**
 * The Converter class. This class containts methods that
 * convert feed items to WordPress posts
 * 
 * @since 1.0
 */
final class WPRSS_FTP_Converter {
	
	public static $_contentHtmlAttributesToKeep = array( 'class' );
	

	public static function get_existing_permalinks() {
		global $wpdb;

		$existing_permalinks = $wpdb->get_col("
			SELECT meta_value
			FROM $wpdb->postmeta
			WHERE meta_key = 'wprss_item_permalink'
		");

		return $existing_permalinks;
	}


	/**
	 * Converts a single wprss_feed_item to a post.
	 * 
	 * @param feed 		The wprss_feed_item object to convert
	 * @param source 	The wprss_feed id of the feed item. Used to retrieve settings for conversion.
	 * @since 1.0
	 */
	public static function convert_to_post( $item, $source, $permalink ) {
	    $logger = WPRSS_FTP_Utils::get_logger( $source );
	    $logger->info('Starting conversion to post');

		$error_source = 'convert_to_post';
		$source_obj = get_post( $source );

		// If the feed source does not exist, exit
		if ( $source_obj === null || $source === '' ) {
			// unschedule any scheduled updates
			wprss_feed_source_update_stop_schedule( $source );

			$logger->warning('Feed source not longer exists. Aborting.');

			return NULL;
		}
		// If the feed source exists, but is trashed or paused, exit
        else if ( $source_obj->post_status !== 'trash' && !wprss_is_feed_source_active( $source ) ) {
            $logger->warning('Feed source is inactive or has been trashed. Aborting.');

            return NULL;
        }

		# If we got NULL, pass it on
		if ( $item === NULL ) {
		    $logger->debug('Feed item is null. Aborting.');

			return NULL;
		}
		# If the item has an empty permalink, log an error message
		if ( empty( $permalink ) ){
		    $logger->warning('Encountered a feed item with an empty permalink. Possibly or invalid a corrupt RSS feed');
		}

		# check existence of permalink
		$existing_permalinks = self::get_existing_permalinks( $source );

		# If permalink exists, do nothing
		if ( in_array( $permalink, $existing_permalinks ) ) {
		    $logger->debug('Item already exists in the database. Aborting.');
			return NULL;
		}

		# Get the computed options ( global settings merged against individual settings )
		$options = WPRSS_FTP_Settings::get_instance()->get_computed_options( $source );

		if ( $options['post_type'] === 'wprss_feed_item' ) {
		    $logger->debug('Importing as a feed item. Stopping post conversion');

			return $item;
		}
		
		self::_prepareItem( $item );

		/*==============================================
		 * 1) DETERMINE THE POST AUTHOR USER
		 */

		// Get author-related options from meta, or from global settings, if not found
		$def_author = $options['def_author'];
		$fallback_author = $options['fallback_author'];
		$author_fallback_method = $options['author_fallback_method'];
		$fallback_user = get_user_by( 'id', $fallback_author );
		if ( ! is_object( $fallback_user ) ) {
			$fallback_user = get_user_by( 'login', $fallback_author );
		}
		$fallback_user = $fallback_user->ID;
		$no_author_found = $options['no_author_found'];

		// Determined user. Start with NULL
		$user = NULL;

		// If using an existing user, we are done.
		if ( $def_author !== '.' ) {
			$user = $def_author;
			$logger->debug('Author: using preset user "{user}"', [
			    'user' => $user
            ]);
		}
		// If getting feed from author, determine the user to assign to the post
		else {
			/* Get the author from the feed
			 * If author not found - use fallback user
			 */
			if ( $author = $item->get_author() ) {
			    $has_author_name = $author->get_name() !== '' && is_string( $author->get_name() );
			    $has_author_email = $author->get_email() !== '' && is_string( $author->get_email() );
			}
			else {
			    $has_author_name = $has_author_email = false;
			}

			// Author NOT found
			if ( $author === NULL || !( $has_author_name || $has_author_email ) ) {
				// If option to use fallback when no author found, use fallback
				if ( $no_author_found === 'fallback' ) {
					$user = $fallback_user;

					$logger->debug('Using fallback user: {user}', [
					    'user' => $user
                    ]);
				}
				// Otherwise, skip the post
				else {
				    $logger->notice('Could not determine post author. Aborting.');

					return NULL;
				}
			}
			// Author found
			else {
			    $logger->debug('Author found in feed item');

				$author_name = $author->get_name();
				$author_email = $author->get_email();

				// No author name fix
				if ( !$has_author_name && $has_author_email ) {
					// "Email is actually the name" fix
					if ( filter_var( $author_email, FILTER_VALIDATE_EMAIL ) === FALSE ) {
						// Set the name to the email, and reset the email
						$author_name = $author_email;
						$author_email = '';
						// Set the flags appropriately
						$has_author_name = TRUE;
						$has_author_email = FALSE;
					}
					else {
						$parts = explode("@", $author_email);
						$author_name = $parts[0];
						$has_author_name = TRUE;
					}
				}
				
				// No author email fix
				if ( !$has_author_email && $has_author_name ) {
					// Get rid of wwww and everything before it
					$domain_name =  preg_replace( '/^www\./', '', $_SERVER['SERVER_NAME'] );
					// Lowercase the author name, remove the spaces
					$email_username = str_replace( ' ', '', strtolower($author_name) );
					// Remove all disallowed chars
					$email_username = preg_replace('![^\w\d_.]!', '', $email_username);
					// For domains with no TLDN suffix (such as localhost)
					if ( stripos( $domain_name, '.' ) === FALSE ) $domain_name .= '.com';
					// Generate the email
					$author_email = "$email_username@$domain_name";
					$has_author_email = TRUE;
				}

				$logger->debug('Found author "{name}"', [
				    'name' => $author_name,
                ]);

				$user_obj = FALSE;

				// If email is available, check if a user with this email exists
				$user_obj = get_user_by( 'email', $author_email );
				// If search by email failed, search the email for the login
				if ( !$user_obj ) {
					$user_obj = get_user_by( 'login', $author_email );
				}
				// If search by email failed, search by name
				if ( !$user_obj ) {
					$user_obj = get_user_by( 'login', $author_name );
				}

				// Feed author has a user on site
				if ( $user_obj !== FALSE && isset( $user_obj->ID ) ) {
					$user = $user_obj->ID;

					$logger->debug('Author has an existing user on site: #{user}', [
					    'user' => $user
                    ]);
				}
				// Author has no user on site
				else {
					$new_user_id = NULL;

					// Fallback method: create user
					if ( $author_fallback_method === 'create' ) {
						$random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
						$new_user_id = wp_create_user( $author_name, $random_password, $author_email );

						$logger->debug('Created a user for the author');

						if ( !$new_user_id || ($is_error = is_wp_error( $new_user_id )) ) {
						    $author_error = $is_error
                                ? $new_user_id->get_error_message()
                                : sprintf('WordPress could not create user %s with email %s', $author_name, $author_email);

						    $logger->notice('Failed to create a user for the found author. Error: {error}', [
						        'error' => $author_error
                            ]);

							$new_user_id = null;
						} else {
							// Check if the author has a URI in the feed
							$author_uri = $author->get_link();
							if ( $author_uri !== NULL ) {
								// Filter the meta field and value
								$uri_meta = apply_filters( 'wprss_author_uri_meta_field', 'wprss_author_uri' );
								$author_uri = apply_filters( 'wprss_author_uri', $author_uri, $source );
								// Add the URI as user meta
								add_user_meta( $user, $uri_meta,  $author_uri );
								// Add the URI to the author
								wp_update_user( array(
									'ID'		=>	$new_user_id,
									'user_url'	=>	$author_uri,
								) );
							}

							// Check if the author name has spaces
							if ( strpos( $author_name, ' ' ) !== FALSE ) {
								// Split name into parts
								$split = explode( ' ', $author_name );
								$first_name = '';
								$last_name = '';
								// check if we have more than one parts
								if ( ( $c = count( $split ) ) > 1 ) {
									$m = $c / 2;
									$first_half = array_slice( $split, 0, $m);
									$second_half = array_slice( $split, $m );
									$first_name = implode( ' ', $first_half );
									$last_name = implode( ' ', $second_half );
								}
								// Update the user
								wp_update_user( array(
									'ID'			=>	$new_user_id,
									'first_name'	=>	$first_name,
									'last_name'		=>	$last_name,
								) );
							}

							$logger->debug('Finished creating user for author.');
						}
					}

					// Fallback method: existing user
					// OR creating a user failed
					if ( $new_user_id === NULL ) {
						$new_user_id = $fallback_user;

						$logger->debug('Falling back to preset existing user.');
					}

					$user = $new_user_id;
				}
			}
		}

		// Get WordPress' GMT offset in hours, and PHP's timezone
		$wp_tz = function_exists('wprss_get_timezone_string') ? wprss_get_timezone_string() : get_option( 'timezone_string ' );
		$php_tz = date_default_timezone_get();
		// Set Timezone to WordPress'
		date_default_timezone_set( $wp_tz );

		$logger->debug('Switching PHP timezone to use the WordPress timezone option: {tz}', [
		    'tz' => $wp_tz
        ]);

		$current_date = date('U');

		// Prepare the rest of the post data
		$date_timestamp = ( $options['post_date'] === 'original' && ( $date_timestamp = $item->get_date( 'U' ) ) )
				? $date_timestamp
				: $current_date; // Fall back to current date if explicitly configured, or no date

		$logger->debug('Got post date timestamp: {ts}', [
		    'ts' => $date_timestamp
        ]);

        // Get the post status
        $post_status = $options['post_status'];

        if ($post_status !== 'future') {
            // Use the current date if the item's date is in the future
            $date_timestamp = $post_status !== 'future'
                ? min($current_date, $date_timestamp)
                : $date_timestamp;

            $logger->debug('Post status is not "scheduled". Clamped timestamp: {ts}', [
                'ts' => $date_timestamp
            ]);
        }

        // Prepare post dates
		$post_date		= date( 'Y-m-d H:i:s', $date_timestamp );
		$post_date_gmt	= gmdate( 'Y-m-d H:i:s', $date_timestamp );

		// Reset Timezone to PHP's
		date_default_timezone_set( $php_tz );

		$logger->debug('Restored default PHP timezone: {tz}', [
		    'tz' => $php_tz
        ]);
		
		// Prepare the post tags
		$tags_str = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'post_tags' );
		$tags = array_map( 'trim', explode( ',', $tags_str ) );


		/*==============================================
		 * 2) APPLY FILTERS TO POST FIELDS
		 */

		$logger->debug('Applying post filters');

		$post_title		= apply_filters( 'wprss_ftp_converter_post_title',	  $item->get_title(), $source );
		$post_content	= apply_filters( 'wprss_ftp_converter_post_content',  $item->get_content(), $source );
		$post_status 	= apply_filters( 'wprss_ftp_converter_post_status',	  $options['post_status'], $source );
		$post_comments 	= apply_filters( 'wprss_ftp_converter_post_comments', $options['comment_status'], $source );
		$post_type 		= apply_filters( 'wprss_ftp_converter_post_type',	  $options['post_type'], $source );
		$post_format 	= apply_filters( 'wprss_ftp_converter_post_format',	  $options['post_format'], $source );
		$post_terms 	= apply_filters( 'wprss_ftp_converter_post_terms',	  $options['post_terms'], $source );
		$post_taxonomy 	= apply_filters( 'wprss_ftp_converter_post_taxonomy', $options['post_taxonomy'], $source );
		$permalink 		= apply_filters( 'wprss_ftp_converter_permalink',	  $permalink, $source );
		$post_author 	= apply_filters( 'wprss_ftp_converter_post_author',	  $user, $source );
		$post_date		= apply_filters( 'wprss_ftp_converter_post_date',	  $post_date, $source );
		$post_date_gmt	= apply_filters( 'wprss_ftp_converter_post_date_gmt', $post_date_gmt, $source );
		$post_tags		= apply_filters( 'wprss_ftp_converter_post_tags',	  $tags, $source );
		$post_language 	= apply_filters( 'wprss_ftp_converter_post_language', $options['post_language'], $source );
		$post_site		= apply_filters( 'wprss_ftp_converter_post_site',	  $options['post_site'], $source );
		$post_comments = ( WPRSS_FTP_Utils::multiboolean( $post_comments ) === TRUE )? 'open' : 'close';

		// Do not let WordPress sanitize the excerpt
		// WordPress sanitizes the excerpt because it's expected to be typed manually by the user and sent in POST
		// However, our excerpt is being inserted as a raw string with the above custom sanitization
		remove_all_filters( 'excerpt_save_pre' );

		// Get excerpt if option is enabled
		$post_excerpt = '';
		if (isset($options['import_excerpt']) && WPRSS_FTP_Utils::multiboolean($options['import_excerpt']) === true) {
			$post_excerpt = apply_filters( 'wprss_ftp_converter_post_excerpt',  $item->get_description(true), $source );
			$post_excerpt = self::clean_excerpt($post_excerpt);
		}

		/*==============================================
		 * 3) CREATE THE POST
		 */

		// Prepare the post data
		$post = array(
			'post_title'		=>	html_entity_decode((string)$post_title),
			'post_content'		=>	(string)$post_content,
			'post_excerpt'		=>	(string)$post_excerpt,
			'post_date'			=>	$post_date,
			'post_date_gmt'		=>	$post_date_gmt,
			'post_status'		=>	$post_status,
			'post_type'			=>	$post_type,
			'post_author'		=>	$post_author,
			'tags_input'		=>	implode( ', ' , $post_tags ),
			'comment_status'	=>	$post_comments
		);

		$logger->debug('Filtering post arguments');

		/**
		 * Filter the post args.
		 * @var array $post		Array containing the post fields
		 * @var WP_Post $source		An post that represents the feed source
		 * @var SimplePie_Item $item    The feed item currently being processed
		 */
		$post = apply_filters( 'wprss_ftp_post_args', $post, $source, $item );

		/*==============================================
		 * 4) INSERT THE POST
		 */

        $logger->debug('Creating post for feed item');

		if ( defined( 'ICL_SITEPRESS_VERSION' ) )
			@include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$_POST['icl_post_language'] = $language_code = ICL_LANGUAGE_CODE;

			$logger->debug('Multilingual plugin detected with language: {lang}', [
			    'lang' => $language_code
            ]);
		}

		// check for multisite option - and switch blogs if necessaray
		$switch_success = FALSE;
		if ( WPRSS_FTP_Utils::is_multisite() && $post_site !== '' ) {
			global $switched;

			if( $switch_success = switch_to_blog( $post_site ) ) {
                $logger->warning('Switched site to {site}', [
                    'site' => $post_site
                ]);
            } else {
			    $logger->warning('Failed to switch site. Post might not be imported into the correct site.');
            }
		}

		// Check if embedded content is allowed
		$allow_embedded_content = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'allow_embedded_content' );

		// If embedded content is allowed, remove KSES filtering
		if ( WPRSS_FTP_Utils::multiboolean( $allow_embedded_content ) === TRUE ) {
			kses_remove_filters();
			$logger->debug('Removing restrictive filters to allow embedded content');
		}

		// Insert the post
		$inserted_id = wp_insert_post( $post, true );
        $insertError = is_wp_error($inserted_id) ? $inserted_id : false;
        $inserted_id = $insertError ? 0 : $inserted_id;
		
		// If embedded content is allowed, re-add KSES filtering
		if ( WPRSS_FTP_Utils::multiboolean( $allow_embedded_content ) === TRUE ) {
			kses_init_filters();
		}

		if ( !$insertError ) {

			if ( is_object( $inserted_id ) ) {
				if ( isset( $inserted_id['ID'] ) ) {
					$inserted_id = $inserted_id['ID'];
				}
				elseif ( isset( $inserted_id->ID ) ) {
					$inserted_id = $inserted_id->ID;
				}
			}

			$logger->info('Created post #{id} for the feed item', [
			    'id' => $inserted_id,
            ]);

			// Update the post format
			set_post_format( $inserted_id, $post_format );

			if ( function_exists( 'wpml_update_translatable_content' ) ) {
				if ( $post_language === '' || $post_language === NULL ) {
					$post_language = ICL_LANGUAGE_CODE;
				}
				// Might be needed by WPML?
				$_POST['icl_post_language '] = $post_language;
				// Update the translation for the created post
				wpml_add_translatable_content( 'post_' . $post_type, $inserted_id, $post_language );
				wpml_update_translatable_content( 'post_' . $post_type, $inserted_id, $post_language );
				icl_cache_clear($post_type.'s_per_language');

				$logger->info('Added post translations for "{lang}" language', [
				    'lang' => $post_language
                ]);
			}


			/*==============================================
			 * 5) ADD THE POST META DATA
			 */

			$thumbnail = '';
			$enclosure_image = '';
			if ( $enclosure = $item->get_enclosure() ) {
				$thumbnail = $enclosure->get_thumbnail();
                                $thumbnail = htmlspecialchars_decode($thumbnail);
				$enclosure_image = $enclosure->get_link();
                                $enclosure_image = htmlspecialchars_decode($enclosure_image);
				$enclosure_player = $enclosure->get_player();

				$logger->debug('Detected item enclosure');
			}

			// Prepare the post meta, and pass though the wprss_ftp_post_meta filter.
			// Note: Prepend '!' to ignore the 'wprss_ftp_' prefix
			$post_meta_data = apply_filters(
				'wprss_ftp_post_meta',
				array(
					'!wprss_item_permalink'		=>	$permalink,
					'feed_source'				=>	$source,
					'media:thumbnail'			=>	$thumbnail,
					'enclosure:thumbnail'		=>	$enclosure_image,
					'enclosure_link'			=>	$enclosure_image, // Included twice for code readablity
					'enclosure_player'			=>	$enclosure_player,
					'import_date'				=>	time(),
					'!wprss_item_date'			=>	$date_timestamp, // Required by core
					'!wprss_feed_id'			=>	$source,
				),
				$inserted_id,
				$source,
				$item
			);

			// Insert the post meta
			WPRSS_FTP_Meta::get_instance()->add_meta( $inserted_id, $post_meta_data );

			$logger->info('Added meta data to the created post');


			/*==============================================
			 * 6) ADD THE TAXONOMY TERMS
			 */

			wprss_ftp_add_taxonomies_to_post( $inserted_id, $source, $item );

			$logger->info('Added taxonomy terms to the created post');

			/*==============================================
			 * 8) CUSTOM FIELD MAPPING
			 */

			$logger->debug('Mapping custom fields to post');

			// Get the namespaces
			$cfm_namespaces = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'rss_namespaces' );
			$cfm_namespaces = ( $cfm_namespaces === '' )? array() : $cfm_namespaces;
			// Get the tags
			$cfm_tags = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'rss_tags' );
			$cfm_tags = ( $cfm_tags === '' )? array() : $cfm_tags;
			// Get the custom fields
			$cfm_fields = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'custom_fields' );
			$cfm_fields = ( $cfm_fields === '' )? array() : $cfm_fields;

			// For each custom field mapping
			for ( $i = 0; $i < count( $cfm_namespaces ); $i++ ) {
				// Get the URL of the namespace
				$namespace_url = WPRSS_FTP_Settings::get_namespace_url( $cfm_namespaces[$i] );
				// If the namespace url is NULL (namespace no longer exists in the settings), skip to next mapping
				if ( $namespace_url === NULL ) continue;

				// Match the syntax "tagname[attrib]" in the tag name
				preg_match('/([^\[]+) (\[ ([^\]]+) \])?/x', $cfm_tags[$i], $m);
				// If no matches, stop. Tag name is not correct. Possibly empty
				if ( !is_array($m) || count($m) < 2 ) continue;
				// Get the tag and attribute from the matches
				$tag_name = $m[1];
				$attrib = ( isset( $m[3] ) )? $m[3] : NULL;

				// Get the tag from the feed item
				$item_tags = $item->get_item_tags( $namespace_url, $tag_name );
				// Check if the tag exists. If not, skip to next mapping
				if ( !isset( $item_tags[0] ) ) continue;

				// Get the first tag found, and get its data contents
				$item_tag = $item_tags[0];
				$attribs = $item_tag['attribs'][''];
				// If not using an attribute, simply get the text data
				if ( $attrib === NULL ) {
					$data = $item_tag['data'];
				}
				// Otherwise, check if the attribute exists
				elseif ( isset( $attribs[ $attrib ] ) ) {
					$data = $attribs[ $attrib ];
				}
				// Otherwise do nothing
				else {
					continue;
				}

				// Put the data in the inserted post's meta, using the custom field as the meta key
				update_post_meta( $inserted_id, $cfm_fields[$i], $data );

				$logger->debug('Updated post meta with "{key}" = "{val}"', [
				    'key'   => $cfm_fields[$i],
                    'value' => is_string($data) ? $data : print_r($data, true),
                ]);
			}

			$post = get_post( $inserted_id );
			if ( !empty($post) ) {
				$logger->debug('Applying final filters to created post');

				do_action( 'wprss_ftp_converter_inserted_post', $inserted_id, $source );

				self::trim_words_for_post( $inserted_id, $source );
			}
		}
		else {
            /* @var $insertError WP_Error */
            $logger->error('Error: "{msg}". {details}', [
                'msg' => $insertError->get_error_message(),
                'details' => $insertError->get_error_data()
            ]);
		}

		// If multisite and blog was switched, switch back to current blog
		if ( WPRSS_FTP_Utils::is_multisite() && $switch_success === TRUE ) {
			restore_current_blog();
			$logger->debug('Switched back to previous site');
		}

		$logger->info('Finished conversion to post');

		// Filter the return value
		$return = apply_filters( 'wprss_ftp_converter_return_post_'.$inserted_id, (bool)$inserted_id );
		// If the return is still TRUE, ensure that the post that was created was not deleted
		if ( $return === TRUE ) {
			$post = get_post( $inserted_id );
			$return = ( $post !== NULL && $post !== FALSE );
		}
		// Log return value if anything other than TRUE
		else {
		    $logger->notice('The "post_return" filter returned a non-true value: {val}', [
		        'val' => is_string($return) ? $return : print_r($return, true),
            ]);
		}

		return $return;
	}

	/**
	 * Cleans a post excerpt string by removing all HTML tags, decoding entities and ensuring correct spacing after
	 * the clean up is complete.
	 *
	 * @since 3.10
	 *
	 * @param string $excerpt The excerpt to clean.
	 *
	 * @return string
	 */
	public static function clean_excerpt($excerpt)
	{
		// Decode HTML entities back to their respective characters
		$excerpt = html_entity_decode($excerpt);
		// Add a space between any HTML elements
		$excerpt = str_replace('>', ' >', $excerpt);
		// Strip all HTML tags
		$excerpt = strip_tags($excerpt);
		// Remove any redundant spaces
		$excerpt = str_replace('  ', ' ', trim($excerpt));

		return $excerpt;
	}

	/**
	 * Checks if the feed source uses the force full content option or meta option, and
	 * returns the fulltextrss url if so.
	 * 
	 * @since 1.0
	 */
	public static function check_force_full_content( $feed_url, $feed_ID ) {
		if ( wprss_ftp_using_feed_items( $feed_ID ) ) {
			return $feed_url;
		}
		// Get the computed settings / meta options for the feed source
		$options = WPRSS_FTP_Settings::get_instance()->get_computed_options( $feed_ID );

		// If using force full content option / meta
		if ( WPRSS_FTP_Utils::multiboolean( $options['force_full_content'] ) === TRUE ) {
			return self::get_full_content_url( $feed_url, $feed_ID );
		}
		// Otherwise, return back the given url
		else return $feed_url;
	}

    /**
     * Retrieves the full content URL.
     *
     * @since 3.9.1
     *
     * @param string $feed_url
     * @param int    $feed_ID
     * @param bool   $force_feed
     *
     * @return string
     */
	public static function get_full_content_url($feed_url, $feed_ID = null, $force_feed = false)
    {
        $service = WPRSS_FTP_Settings::get_instance()->get('full_text_rss_service');
        $service = apply_filters( 'wprss_ftp_service_before_full_text_feed_url', $service );

        if ($service === 'free') {
            $key = WPRSS_FTP_FULL_TEXT_RSS_KEY;
            $API_HASH = sha1( $key . $feed_url );
            $encoded_url = urlencode( $feed_url );
            $homeUrl = urlencode(home_url());
            // Prepare the fulltext sources
            $full_text_sources = apply_filters(
                'wprss_ftp_full_text_sources',
                array(
                    "http://fulltext.wprssaggregator.com/makefulltextfeed.php?key=1&hash=$API_HASH&links=preserve&origin={$homeUrl}&exc=1&url=",
                    "http://ftr-premium.fivefilters.org/makefulltextfeed.php?key=1920&hash=$API_HASH&max=10&links=preserve&exc=1&url=",
                )
            );
            // Start with no feed to use
            $feed_url_to_use = NULL;

            // Load SimplePie
            require_once ( ABSPATH . WPINC . '/class-feed.php' );

            // For each source ...
            foreach ( $full_text_sources as $full_text_source ) {
                // Prepare the feed
                $full_text_feed_url = $full_text_source . $encoded_url;
                $feed = wprss_fetch_feed( $full_text_feed_url, $feed_ID, $force_feed );

                // If the feed has no errors, the we will use this feed
                if ( !is_wp_error( $feed ) && !$feed->error() ) {
                    $feed_url_to_use = $full_text_source . $encoded_url;
                    break;
                }
            }

            // If after trying all the sources, the feed to use is still NULL, then no source was valid.
            // Return the same url passed as parameter, Otherwise, return the full text rss feed url
            if ( $feed_url_to_use === NULL ) {
                WPRSS_FTP_Utils::get_logger($feed_ID)->warning('All full text RSS services failed to provide a valid feed.');
            }
            return ( $feed_url_to_use === NULL )? $feed_url : $feed_url_to_use;
        }

        // For other services
        return apply_filters( 'wprss_ftp_misc_full_text_url', $feed_url, $feed_ID, $service );
    }

	/**
	 * Trims the post's content and updates its content or excerpt, depending on its
	 * feed source's settings.
	 * 
	 * @param  int|string $post_id   The ID of the post
	 * @param  int|string $source_id The ID of the feed source
	 */
	public static function trim_words_for_post( $post_id, $source_id ) {
		// Get the post object. If NULL (invalid ID) stop and do nothing
		$post = get_post( $post_id );
		if ( $post === NULL ) return;
		// Get the post's excerpt and content
		$post_excerpt = $post->post_excerpt;
		$post_content = $post->post_content;
		// Get the trimming options
		$word_trimming_options = self::trim_words_options( $source_id );
		// If not disabled
		if ( $word_trimming_options !== FALSE ) {
			// Extract the options from the array
			list( $word_limit, $trimming_type ) = array_values( $word_trimming_options );
			
			// Whether to switch of KSES
			$allow_embedded_content = WPRSS_FTP_Meta::get_instance()->get_meta( $source_id, 'allow_embedded_content' );
			$allow_embedded_content = (WPRSS_FTP_Utils::multiboolean( $allow_embedded_content ) === true);
			// Keep these tags. All others will be stripped during trimming.
			$keep_tags = array( 'p', 'br', 'em', 'strong', 'a' );
			if ( $allow_embedded_content ) // Add allowed embed tags, if applicable
				$keep_tags = array_merge( $keep_tags, self::get_allowed_embed_tags() );
			$keep_tags = apply_filters( 'wprss_ftp_trimming_keep_tags', $keep_tags );
			
			// Generate the trimmed content
			$trimmed_content = wprss_trim_words( $post_content, intval( $word_limit ), $keep_tags );

			// If trimming type is set to save it as post_content in the database
			$to_update = ($trimming_type == 'db') ? 'post_content' : 'post_excerpt';

			// If trimming content into post excerpt, clean the content and add ellipsis if that option is enabled
			if ($to_update === 'post_excerpt') {
				$trimmed_content = self::clean_excerpt($trimmed_content);

				$ellipsis = WPRSS_FTP_Meta::get_instance()->get_meta( $source_id, 'trimming_ellipsis' );
				$ellipsis = (WPRSS_FTP_Utils::multiboolean( $ellipsis ) === true);

				if ($ellipsis) {
					$trimmed_content .= ' ...';
				}
			}

			if ( $allow_embedded_content ) kses_remove_filters();

			// Update the post
			wp_update_post(
				array(
					'ID'		=>	$post_id,
					$to_update	=>	$trimmed_content
				)
			);

			if ( $allow_embedded_content ) kses_init_filters();
		}
	}


	/**
	 * Retrieves the word trimming options for a particular feed source.
	 *
	 * This function returns the proper options to use for word trimming, retrieving them either
	 * from the feed source or from the global settings as appropriate.
	 *
	 * @since 3.3
	 * @param $source_id int|string The ID of the feed source.
	 * @return           Array|bool An array of the options or FALSE if word trimming is disabled or not applicable.
	 */
	public static function trim_words_options( $source_id ) {
		// Get enabled option. Value = "general" | "true" | "false"
		$enabled_meta = WPRSS_FTP_Meta::get_instance()->get( $source_id, 'word_limit_enabled' );
		// If disabled, return FALSE for 'disabled'
		if ( $enabled_meta === 'false' ) {
			return FALSE;
		}
		// If enabled, check if "true" and either
		if ( $enabled_meta === 'true' ) {
			// Get options form meta
			$word_limit = WPRSS_FTP_Meta::get_instance()->get( $source_id, 'word_limit' );
			$trimming_type = WPRSS_FTP_Meta::get_instance()->get( $source_id, 'trimming_type' );
			// Check if the word limit is valid
			$int_word_limit = intval( $word_limit );
			if ( $word_limit === '' || $int_word_limit === 0 || $int_word_limit === FALSE ) {
				// Get it from the settings if not valid
				$word_limit = WPRSS_FTP_Settings::get_instance()->get( 'word_limit' );
			}
			// Check if trimming_type is "general"
			if ( $trimming_type === 'general' ) {
				// Get it from the settings
				$trimming_type = WPRSS_FTP_Settings::get_instance()->get( 'trimming_type' );
			}
		} else {
			// Or get options from settings
			$word_limit = WPRSS_FTP_Settings::get_instance()->get( 'word_limit' );
			$trimming_type = WPRSS_FTP_Settings::get_instance()->get( 'trimming_type' );
		}
		// Cast the word limit into an integer number
		$word_limit = intval( $word_limit );
		// If it is zero or FALSE (in case it  wasn't a valid integer number), return FALSE for 'disabled'.
		if ( $word_limit === 0 || $word_limit === '' || $word_limit === FALSE ) {
			return FALSE;
		}
		// Return the options as an array
		return compact( 'word_limit', 'trimming_type' );
	}


	/**
	 * Checks the post_word_limit setting and trims the post content accordingly.
	 * 
	 * @deprecated Replaced by WPRSS_FTP_Converter::trim_words
	 * @since 1.8
	 * @todo implement trimming
	 */
	public static function trim_post_content( $post_content ) {
		// Get the option
		$post_word_limit = WPRSS_FTP_Settings::get_instance()->get( 'post_word_limit' );

		// Check if the option is empty or is not a valid integer, in which case we return
		// the post content without modifications
		if ( empty( $post_word_limit ) || intval( $post_word_limit ) === FALSE ) {
			return $post_content;
		}

		// Otherwise, get the integer value of the setting, and prepare to trim
		$post_word_limit = intval( $post_word_limit );

		// Get the excerpt more suffix from WordPress
		$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );

		// Return the trimmed version
		$trimmed = wp_trim_words( $post_content, $post_word_limit, $excerpt_more );

		return $trimmed;
	}


	/**
	 * Changes the tags to be stripped from the feed item.
	 * 
	 * @since 2.2
	 */
	public static function feed_tags_to_strip( $tags, $source ) {
		if ( is_null( $source ) ) return $tags;
		
		$allow_embedded_content = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'allow_embedded_content' );
		if ( WPRSS_FTP_Utils::multiboolean( $allow_embedded_content ) !== true )
			return $tags;
		
		// Remove the allowed tags from the list of tags to remove
		$tags = array_diff( $tags, self::get_allowed_embed_tags() );
		$tags = array_values( array_filter( $tags ) );
		
		return $tags;
	}
	
	
	/**
	 * @since 3.5
	 * @return array An array, where values are names of tags that are allowed as "embedded".
	 */
	public static function get_allowed_embed_tags() {
		return apply_filters( 'wprss_ftp_allowed_embed_tags', array( 'object', 'param', 'embed', 'iframe' ) );
	}


	/**
	 * Returns the post word limit setting. Used by the trim_post_content() function in
	 * the WPRSS_FTP_Converter class as a filter for 'excerpt_length'
	 * 
	 * @deprecated Check why it's no longer used, and if it is important
	 * @since 1.8
	 */
	public static function get_post_word_limit( $length ) {
		return WPRSS_FTP_Settings::get_instance()->get( 'post_word_limit' );
	}
	
	
	/**
	 * @param SimplePie_Item $item The feed item to prepare
	 * @since 3.5
	 */
	protected static function _prepareItem( $item ) {
		$event = WPRSS_FTP::do_action( 'converter_prepare_item_before', array( 'item' => $item ) );
		self::_keepItemContentHtmlAttributes( $item );
		$event = WPRSS_FTP::do_action( 'converter_prepare_item_after', $event->args );
	}
	
	
	/**
	 * Will make sure that the defined list of attributes is not removed
	 * from the HTML in a feed item's content.
	 * 
	 * @see getContentHtmlAttributesToKeep()
	 * @param SimplePie_Item $item The feed item.
	 * @since 3.5
	 */
	protected static function _keepItemContentHtmlAttributes( $item ) {
		$feed = $item->feed;
		$sanitizer = $feed->sanitize;
		/* @var $sanitizer SimplePie_Sanitize */
		
		$strippedAttributes = array_flip( $sanitizer->strip_attributes );
		
		foreach ( self::getContentHtmlAttributesToKeep() as $_idx => $_attribute )
			if ( isset( $strippedAttributes[ $_attribute ] ) )
				unset( $strippedAttributes[ $_attribute ] );

		$sanitizer->strip_attributes( array_flip( $strippedAttributes ) );
	}
	
	
	/**
	 * @return array
	 * @since 3.5
	 */
	public static function getContentHtmlAttributesToKeep() {
		return self::$_contentHtmlAttributesToKeep;
	}

}

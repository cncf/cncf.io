<?php

/**
 * This class contains functions that are related to the displaying of converted posts.
 * 
 * @since 1.0
 */
final class WPRSS_FTP_Display {


	/**
	 * Initializes the hooks used by the class.
	 * 
	 * @since 2.6.2
	 */
	public static function init() {
		// Get the priority
		$wprss_ftp_pcfp = apply_filters( 'wprss_ftp_post_content_filter_priority', 10000 );

		// Filters below are in order of execution

		// Post Content Trimming
		add_filter( 'the_content', array( 'WPRSS_FTP_Display', 'trim_post_content' ), $wprss_ftp_pcfp - 3, 1 );

		// Add the content filter function that removes all text from posts
		add_filter( 'the_content', array( 'WPRSS_FTP_Display', 'images_only_in_post_content' ), $wprss_ftp_pcfp - 2, 1 );

		// Add the content filter function that adds the enclosure link
		add_filter( 'the_content', array( 'WPRSS_FTP_Display', 'enclosure_link' ), $wprss_ftp_pcfp - 1, 1 );

		// Add the content filter function that adds the source link, prepend and append texts to posts' content
		add_filter( 'the_content', array( 'WPRSS_FTP_Display', 'post_content' ), $wprss_ftp_pcfp, 1 );


		// Add the content filter function that applies affiliate links to the posts' content
		//add_filter( 'the_content', array( 'WPRSS_FTP_Display', 'apply_affiliate_links_to_post_content' ) );

		// Adds the meta generator tag to the <head> of imported posts on their singular page
		add_action( 'wp_head', array( 'WPRSS_FTP_Display', 'post_head' ) );

        // Filter the canonical URL for imported posts, so that the <link rel="canonical"> tag has a "href" attribute
        // that links to the original article
        add_filter( 'get_canonical_url', array( 'WPRSS_FTP_Display', 'canonical_url' ), 10, 2 );

        // Filter YoastSEO's Facebook OpenGraph URL to point to the imported post. By default, YoastSEO uses the
        // canonical link, which Feed to Post sets to the original article.
        add_filter('wpseo_opengraph_url', array( 'WPRSS_FTP_Display', 'yoast_seo_og_url' ) );
	}


	/**
	 * This filter function adds the source link text to the end of the given content, if the 
	 * feed source has source_link enabled. It also checks for phrases wrapped in asteriks, 
	 * and converts them into links.
	 * 
	 * @since 1.0
	 */
	public static function post_content( $content ) {
		global $post;

		if (!$post) {
			return $content;
		}

		$source = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'feed_source' );

		// IF AN IMPORTED POST
		if ( $source !== '' ) {

			$options = WPRSS_FTP_Settings::get_instance()->get();

			$core_settings = get_option( 'wprss_settings_general' );
			$display_settings = wprss_get_display_settings( $core_settings );

			$link = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'wprss_item_permalink', false );
			$feed_link = get_post_meta( $source, 'wprss_site_url', true );

			// Check the prepend/append text
			$append = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'post_append' );
			$prepend = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'post_prepend' );

			// Add any prepend text
			if ( $prepend !== '' && WPRSS_FTP_Display::show_appended_text('prepend', $source) ) {
				$content = do_shortcode( WPRSS_FTP_Appender::handle_appended_data( $post, $prepend ) ) . $content;
			}
			// Add any append text
			if ( $append !== '' && WPRSS_FTP_Display::show_appended_text('append', $source) ) {
				$content .= do_shortcode( WPRSS_FTP_Appender::handle_appended_data( $post, $append ) );
			}


			// If the post's feed source has source_link enabled ...
			if ( WPRSS_FTP_Display::show_appended_text('source_link', NULL, $options) ) {
				// Prepare to data
				$text = $options['source_link_text'];
				// Search for an asterisk sign
				$search = stripos( $text, '*');

				// If an asterisk is found, use regex to generate the linked phrase
				if ( $search !== FALSE ) {
					$link_open = "<a target='_blank' ${display_settings['follow']} href=\"";
					$link_close = "</a>";
					$linked_text = preg_replace(
						'/\*\*(.*?)\*\*/',									// The regex pattern to search for
						$link_open . esc_attr( $feed_link ) . "\">$1</a>",	// The replacement text
						$text												// The text to which to search in
					);
					$linked_text = preg_replace(
						'/\*(.*?)\*/',										// The regex pattern to search for
						$link_open . esc_attr( $link ) . "\">$1</a>",		// The replacement text
						$linked_text										// The text to which to search in
					);
				}
				// If no asterisk is found, use as preceding text
				else $linked_text = $text . ' <a href="' . esc_attr( $link ) . '" target="_blank">' . $link . '</a>';
				// Add the generated text to the content
				if ( $linked_text !== '' ) {
                    $linkMethod = apply_filters('wprss_ftp_add_source_link_method', 'before');
                    if( $linkMethod === 'before' ) {
                        $content = $linked_text . '</br>' . $content;
                    }
                    elseif( $linkMethod === 'after' ) {
                        $content = $content . '</br>' . $linked_text;
                    }
                    elseif( is_callable($linkMethod) ) {
                        $content = call_user_func_array($linkMethod, array($content, $linked_text));
                    }
				}
			}

		} // end of imported post check

		return $content;
	}


	/**
	 * Checks if we should show appended/prepended/source link text
	 *
	 * @since 3.3.2
	 */
	public static function show_appended_text($type, $source = NULL, $options = NULL) {
		// A post is considered to be singular if WP's is_singular() function returns true and is_feed() returns false
		// i.e. a post is being shown alone on its own page and not in the site's RSS feed
		$post_is_singular = is_singular() && !is_feed();

		if ($type === 'append' || $type === 'prepend') {

			if ($source === NULL) {
				return FALSE; // We need the source ID to check its options.
			}

			$singular_only = WPRSS_FTP_Utils::multiboolean( WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'singular_' . $type ) );

			// Only show prepended/appended text if the singular_only option is unchecked (i.e. always show) OR if the post
			// is singular (in which case it does not matter whether the option is checked or not)
			return !$singular_only || ( is_singular() && !is_feed() );

		} else if ( $type === 'source_link' ) {

			if ($options === NULL) {
				return FALSE;
			}

			$enabled = WPRSS_FTP_Utils::multiboolean( $options['source_link'] );
			$singular_only = WPRSS_FTP_Utils::multiboolean( $options['source_link_singular'] );

			if ( $enabled === FALSE) {
				return FALSE;
			}

			// Only show the source link text if the singular_only option is unchecked (i.e. always show) OR if the post
			// is singular (in which case it does not matter whether the option is checked or not)
			return !$singular_only || ( is_singular() && !is_feed() );
			
		} else {
			return FALSE;
		}

	}
    
    
    public static function add_source_link($content, $link) {
        return $content . '</br>' . $link;
    }


	/**
	 * Adds the meta generator tag.
	 * 
	 * @since 1.8
	 */
	public static function post_head() {
		if (!is_singular()) {
            return;
        }

		// Current post
		global $post;

		// Get the source meta, if it exists, for this post
		$source = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'feed_source' );

		// If no source, then not an imported post. Stop.
		if (empty($source)) {
            return;
        }

        // print the genrator tag
        ?><meta name="generator" content="Feed to Post <?php echo WPRSS_FTP_VERSION; ?>" /><?php
        echo "\n";
	}

    /**
     * Filter's YoastSEO's OpenGraph URL to point to the imported post, not the actual one.
     *
     * @since 3.10
     *
     * @param string $url The URL to filter.
     *
     * @return string The filtered URL.
     */
    public static function yoast_seo_og_url($url) {
        // Get the current post
        global $post;
        if (!$post) {
            return $url;
        }

        // Get the feed source for this post
        $source = WPRSS_FTP_Meta::get_instance()->get_meta($post->ID, 'feed_source');

        // If not an imported post, abort
        if ($source === '') {
            return $url;
        }

        // Return the local permalink of the post
        return get_permalink($post);
    }

    /**
     * Filters the canonical link for imported posts.
     *
     * @since 3.9
     *
     * @param string $url
     * @param WP_Post $post
     *
     * @return string
     */
	public static function canonical_url($url, $post) {
	    // Stop if not a single post page
        if (!is_singular()) {
            return $url;
        }

        // Get the source meta, if it exists, for this post
        $source = WPRSS_FTP_Meta::get_instance()->get_meta($post->ID, 'feed_source');
        // If no source, not an imported post. Stop.
        if (empty($source)) {
            return $url;
        }

        // Get the canonical_link setting
        $options = WPRSS_FTP_Settings::get_instance()->get_computed_options( $source );
        $canonical_link = isset($options['canonical_link'])? $options['canonical_link'] : false;

        // If enabled, return the item's permalink. Otherwise return the original URL
        return (WPRSS_FTP_Utils::multiboolean($canonical_link))
            ? WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'wprss_item_permalink', false )
            : $url;
    }


	/**
	 * Trims the post content, according to the filter.
	 * 
	 * @since 1.9.7
	 */
	public static function trim_post_content( $content ) {
		global $post;
		// check if no in the feed and if showing a single post
		if ( !is_feed() && is_a( $post, 'WP_Post' ) ) {

			// Get the source meta, if it exists, for this post
			$source = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'feed_source' );

			// IF AN IMPORTED POST
			if ( $source !== '' ) {

				// GET THE WORD LIMIT FROM THE FILTER
				$post_word_limit = apply_filters( 'wprss_ftp_trim_post_content', FALSE );

				// Check if the option is empty or is not a valid integer, in which case we return
				// the post content without modifications
				if ( $post_word_limit !== FALSE && intval( $post_word_limit ) >= 0 ) {
					
					// Sanitize the limit into an integer
					$post_word_limit = intval( $post_word_limit );
					// Get the excerpt 'more' suffix from WordPress
					$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
					// Trim the content
					$trimmed = wp_trim_words( $content, $post_word_limit, $excerpt_more );

					return $trimmed;

				} // End of trimming

			} // End of imported post check

		}
		return $content;
	}


	/**
	 * Checks the wprss_ftp_images_only_in_post_content filter, and if it returns TRUE,
	 * strips all text from the post content, and leaves only images.
	 * 
	 * @since 2.3
	 */
	public static function images_only_in_post_content( $content ) {
		// Start the new content as the equivalent to the current content
		$new_content = $content;

		// Conditionals: Check if we are showing posts ( since the_content filter also runs when creating posts, editing posts, etc.. )
		if ( is_singular() || is_home() || is_front_page() || is_search() || is_preview() ) {
			global $post;

			// Get the source meta, if it exists, for this post
			$source = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'feed_source' );

			// If the meta exists ( i.e. is an imported post )
			if ( $source !== '' ) {

				// Get the filter that enables/disables the images only functionality
				$images_only = apply_filters( 'wprss_ftp_images_only_in_post_content', FALSE );

				// If enabled ...
				if ( $images_only === TRUE ) {
					// Match all <img> tags
					preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $matches );
					// Reset the new content
					$new_content = '';

					// For each img tag found,
					foreach ( $matches[0] as $img_tag  ) {
						// Add the img tag to the new content
						$new_content .= $img_tag;
					}
					// $new_content is now a string containing all img tags found in the post content
				}

			} // End of imported post check

		} // End of conditionals

		// Return the new content
		return $new_content;		
	}


	/**
	 * Prints the enclosure link in the post content.
	 *
	 * @since 2.8
	 */
	public static function enclosure_link( $content ) {
		global $post;

		// Start with the original content
		$new_content = $content;

		// check if enclosure is enabled, check filter for before and after (default: before), check filter to modify print

		// Check if not in the feed and if showing the post, not processing the content
		if ( is_feed() || !( is_singular() || is_home() || is_front_page() || is_search() || is_preview() ) ) {
			return $content;
		}

		// Get the source meta, if it exists, for this post
		$source = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'feed_source' );
		// If the meta exists ( i.e. is an imported post )
		if ( $source === '' ) {
			return $content;
		}

		// Check if enclosure is enabled
		$enclosure_enabled = get_post_meta( $source, 'wprss_enclosure', TRUE );
		if ( $enclosure_enabled === '' || !WPRSS_FTP_Utils::multiboolean( $enclosure_enabled ) ) {
			return $content;
		}

		// Get the post enclosure link
		$enclosure_link = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'enclosure_link' );
		// Prepare the default output
		$enclosure_output = "<a href='$enclosure_link' target='_blank'>$enclosure_link</a>";

		// Get the position of the enclosure link. Default: 'before' post content
		$pos = apply_filters( 'wprss_ftp_enclosure_link_position', 'before' );

		// Filter the enclosure output
		$enclosure_output = apply_filters( 'wprss_ftp_enclosure_output', $enclosure_output, $enclosure_link, $source );

		// Show the enclosure link at the appropriate position
		switch( $pos ) {
			default:
			case 'before':
				$new_content = $enclosure_output . $content;
				break;
			case 'after':
				$new_content = $content . $enclosure_output;
				break;
		}
		
		// Return the new content
		return $new_content;
	}


	/**
	 * Searches the post content for links, and applies the affiliate appends.
	 * 
	 * @todo everything
	 * @since 2.0
	 */
	public static function apply_affiliate_links_to_post_content( $content ) {
		/*
		if ( !is_feed() && is_singular() ) {
			global $post;
			$core_settings = get_option( 'wprss_settings_general' );
			$display_settings = wprss_get_display_settings( $core_settings );
			$source = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'feed_source' );
			$options = WPRSS_FTP_Settings::get_instance()->get_computed_options( $source );

			// If affiliate links are enabled
			if ( isset( $options['affiliate_link'] ) && WPRSS_FTP_Utils::multiboolean( $options['affiliate_link'] ) !== FALSE ) {
				$affiliate_link = $options['affiliate_link'];
				$links = array();

				// Match all <a> tag href attributes ( the link url )
				preg_match_all('|<a.*?href=[\'"](.*?)[\'"].*?>|i', $content, $matches);

				// For each matching image tag in the post content
				foreach ( $matches[1] as $url ) {
					// Only proceed if the url is from an external source
					if ( ! wprss_ftp_is_url_local( $url ) ) {

						// Append the query string initiator token ('?') if it is not present
						if ( strpos( $url, '?' ) === FALSE ) $url .= '?';
						// Otherwise, prepend the query argument separator token ('&') to the affiliate link
						else $affiliate_link = '&' . $affiliate_link;

						// Prepare the new url - Add the affiliate link to the url
						$new_url = $url . $options['affiliate_link'];

						$links[ $url ] = $new_url;

					}
				}

				// Now, the $links array contains the find & replace key/value pairs of old and new links
				$old = array_keys( $links );
				$new = array_values( $links );
				// Perform a find & replace
				//$content = str_replace( $old, $new, $content );
			}
		}*/

		return $content;
	} 
}

// Call the init method of the class, after the theme has been setup (theme's functions.php is required)
add_action( 'after_setup_theme', array( 'WPRSS_FTP_Display', 'init' ) );

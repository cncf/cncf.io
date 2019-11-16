<?php


final class WPRSS_FTP_Appender {
	

	/**
	 * Returns the supported post_append placeholders
	 * 
	 * @since 1.6
	 */
	public static function get_placeholders() {
		return array(
			'{{feed_name}}'				=>	__( 'The name given to this feed source.', WPRSS_TEXT_DOMAIN ),
			'{{post_title}}'			=>	__( 'The title of the imported post.', WPRSS_TEXT_DOMAIN ),
			'{{post_url}}'				=>	__( 'The URL of the imported post on your site.', WPRSS_TEXT_DOMAIN ),
			'{{feed_url}}'				=>	__( 'The URL of the site, from which the post was imported.', WPRSS_TEXT_DOMAIN ),
			'{{post_import_date}}'		=>	__( 'The date the imported post was imported.', WPRSS_TEXT_DOMAIN ),
			'{{original_post_url}}'		=>	__( 'The URL of the original post on the feed source site.', WPRSS_TEXT_DOMAIN ),
			'{{post_author_name}}'		=>	__( 'The name of the imported post\'s author, if available', WPRSS_TEXT_DOMAIN ),
			'{{post_publish_date}}'		=>	__( 'The date the imported post was published, if available.', WPRSS_TEXT_DOMAIN ),
			'{{post_author_url}}'		=>	__( 'The URL of the post author, if available.', WPRSS_TEXT_DOMAIN ),
            '{{original_image_url}}'    =>  __( 'The original remote URL of the image that was used as the featured image, if any. Otherwise, empty.', WPRSS_TEXT_DOMAIN ),
		);
	}



	/**
	 * Handles the substitution of the placeholders.
	 * 
	 * @since 1.6
	 */
	public static function handle_appended_data( $post, $append, $wpautop = TRUE ) {
		if ( strlen($append) === 0 ) return "";

		// Get the placeholders
		$placeholders = self::get_placeholders();
		// Get the post's feed source
		$source_id = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'feed_source' );
		$source = get_post( $source_id );
		// Array of [placeholder] => [text]
		$values = array();

		// Iterate each known placeholder
		foreach ( $placeholders as $placeholder => $description ) {
			$value = null;
			// Generate the text value for this placeholder
			switch ( $placeholder ) {

				case '{{feed_name}}':
					$value = $source->post_title;
					break;

				case '{{feed_url}}':
					$value = get_post_meta( $source_id, 'wprss_site_url', TRUE );
					if ( $value == '' ) {
						$value = get_post_meta( $source_id, 'wprss_url', TRUE );
					}
					break;

				case '{{post_title}}':
					$value = $post->post_title;
					break;

				case '{{post_url}}':
					$value = get_permalink( $post->ID );
					break;

				case '{{original_post_url}}':
					$value = get_post_meta( $post->ID, 'wprss_item_permalink', TRUE );
					break;

				case '{{post_import_date}}':
					$import_date = WPRSS_FTP_Meta::get_instance()->get_meta( $post->ID, 'import_date' );
					// Get the WordPress date and time format settings
					$time_format = get_option('time_format');
					$date_format = get_option('date_format');
					// Format the value and add HTML time tags
					$value = @date( "$date_format $time_format", $import_date );
					$value = '<time>' . $value . '</time>';
					break;
					
				case '{{post_publish_date}}':
					$value = get_the_date( '', $post->ID ) .' '. get_the_time( '', $post->ID );
					$value = '<time>' . $value . '</time>';
					break;

				case '{{post_author_name}}':
					$user = get_user_by( 'id', $post->post_author );
					if ( $user->first_name === '' && $user->last_name === '' ) {
						$value = $user->user_login;
					}
					$value = $user->first_name . ' ' . $user->last_name;
					break;

				case '{{post_author_url}}':
					$user = get_user_by( 'id', $post->post_author );
					$value = $user->user_url;
					break;

                case '{{original_image_url}}':
                    $value = get_post_meta( $post->ID, 'wprss_ftp_featured_image_source', true );
                    break;

				default:
					$value = '/';
					break;

			}
			// Add the placeholder and its value to the values array
			$values[$placeholder] = $value;
		}
		// Replaces new lines with <br/> tags
		$values["\n"] = '<br/>';


		//== ADVANCED PLACEHOLDERS ====
		// {{meta: xyz}} Outputs meta value for the post's meta field 'xyz'
		// {{source_meta: xyz}} The same, but the meta value is taken from the post's feed source.

		// Use regex to find all the advanced placeholders used
		preg_match_all("/{{(source_)?meta\s*:\s*([^}]*)}}/ix", $append, $adv_meta);
		// The first entry in the results array is an array containing the
		// full string match (the placeholder string)
		$adv_meta_placeholders = $adv_meta[0];
		// The second entry in the results array is an array of the matched
		// optional "source_" prefix (the matching group before "meta")
		$adv_meta_source = $adv_meta[1];
		// The third entry in the results array is an array of the matched
		// meta fields (the matching group after the colon)
		$adv_meta_fields = $adv_meta[2];
		// Iterate each found meta field
		for( $i = 0; $i < count($adv_meta_fields); $i++ ) {
			// Determine if retrieveing the meta of the post or the source
			$target = ( $adv_meta_source[$i] === "source_" )? $source_id : $post->ID;
			// Get the meta value from the target post/source
			$meta = get_post_meta( $target, $adv_meta_fields[$i], TRUE );
			// Prepare the placeholder that matches this meta field
			$placeholder = $adv_meta_placeholders[$i];
			// Add the find/replace values
			$values[ $placeholder ] = $meta;
		}

		// Return the append/prepend text with all placeholders replaced with their respective text value
		$return = WPRSS_FTP_Utils::str_mass_replace( $append, $values );
		$return = apply_filters( 'wprss_ftp_handled_append_text', $return, $post->ID );
		return $wpautop === TRUE? wpautop( $return ) : $return;
	}

}

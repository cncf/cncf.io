<?php

use Psr\Log\LogLevel;

add_action( 'wprss_ftp_converter_inserted_post', array( 'WPRSS_FTP_Extractor', 'extract' ), 1000, 2 );
/**
 * The class contains functions relating to extraction rules; getting the extraction rules,
 * handling extraction, etc..
 *
 * @since 2.5
 */
final class WPRSS_FTP_Extractor {
	

	/**
	 * Returns the extraction rules built into the plugin
	 * 
	 * @since 2.7.3
	 */
	public static function get_built_in_rules() {
		return apply_filters(
			'wprss_ftp_built_in_rules',
			array(
				'a[href*="redirect.viglink.com"]'	=>	'remove'
			)
		);
	}


	/**
	 * Returns the extraction rules, as an array, for the given feed source
	 * 
	 * @since 2.5
	 */
	public static function get_extraction_rules( $source ) {
		$rules = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'extraction_rules' );
		if ( !is_array( $rules ) ) {
			return explode( "\n", $rules );
		}
		return $rules;
	}


	/**
	 * Returns the extraction rule types, as an array, for the given feed source
	 * 
	 * @since 2.5
	 */
	public static function get_extraction_rule_types( $source ) {
		$rules = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'extraction_rules_types' );
		if ( !is_array( $rules ) ) {
			return explode( "\n", $rules );
		}
		return $rules;
	}


	/**
	 * Returns the extraction rules and their types, as an associative array, for the given feed source,
	 * in the form: rule => type
	 * 
	 * @since 2.5
	 */
	public static function get_extraction_rules_and_types( $source ) {
		// Get the rules and the types and merge them into one array
		$rules = self::get_extraction_rules( $source );
		$types = self::get_extraction_rule_types( $source );
		$rules_and_types = array_combine( $rules, $types );

		// Builtin rules
		$builtin_rules = self::get_built_in_rules();

		// Return the finished array of extraction rules
		return array_merge( $rules_and_types, $builtin_rules );
	}

	
	/**
	 * Handles extraction for the given post.
	 * 
	 * @since 2.5
	 */
	public static function extract( $post_id, $source ) {
        $logger = WPRSS_FTP_Utils::get_logger($source);
		// If a source is set ( hence an imported post ), ...
		if ( $source !== '' ) {

			// Get the extraction rules of the source
			$rules = self::get_extraction_rules_and_types( $source );

			$logger->log(LogLevel::DEBUG, 'Got extraction rules: {rules}', [
			    'rules' => print_r($rules, true)
            ]);

			// If the rules are not an array or there are no rules, return
			if ( !is_array( $rules ) && count( $rules ) == 0 ) return;

			// Load the ganon library
			if ( version_compare(phpversion(), '5.3.1', '<') ) {
				// PHP4 Ganon
				require_once( WPRSS_FTP_LIB . 'ganon.php4' );
			}
			else {
				// PHP5+ Ganon
				require_once( WPRSS_FTP_LIB . 'ganon.php' );
			}

			// Get the post
			$post = get_post( $post_id );
			// If the post is a WP error, return
			if ( is_wp_error( $post ) || !is_object( $post ) ) return;
			// Otherwise, get the content
			$content = $post->post_content;

			// Parse the post content
			$html = str_get_dom( $content );

			// For each rule and its type
			foreach ( $rules as $rule => $type ) {

				// Trim the rule string
				$rule = trim( $rule );
				// If the rule is empty, skip it
				if ( strlen( $rule ) === 0 ) {
					continue;
				}

				// Used to replace the current html DOM
				$new_html = '';

				// Each found element ...
				foreach ( $html->select($rule) as $element ) {
					// Check the rule type
					switch( $type ) {
						// If keeping the matched element
						case 'keep' :
							// Add the element as a string to the new_html variable
							$new_html .= $element->toString(TRUE, TRUE, FALSE);
							break;
						// Remove the element
						case 'remove' :
							$element->detach();
							break;
						// Remove the element, and keep its children
						case 'remove_keep_children' :
							$element->detach( TRUE );
							break;
					}
				}

				// If the new_html variable has changed, use it as the new HMTL DOM
				if ( strlen( $new_html ) > 0 ) {
					$html = str_get_dom( $new_html );
				}

			} // End of rules foreach

			// Update the post with its new content
			$new_content = (string)$html;
			WPRSS_FTP_Utils::update_post_content( $post_id, $new_content );
		}

	}
}

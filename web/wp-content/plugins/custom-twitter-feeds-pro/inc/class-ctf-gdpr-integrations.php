<?php
/**
 * Class CTF_GDPR_Integrations
 *
 * Adds GDPR related workarounds for third-party plugins:
 * https://wordpress.org/plugins/cookie-law-info/
 *
 * @since 2.6/5.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class CTF_GDPR_Integrations {

	/**
	 * Undoing of Cookie Notice's Twitter Feed related code
	 * needs to be done late.
	 */
	public static function init() {
		add_filter( 'wt_cli_third_party_scripts', array( 'CTF_GDPR_Integrations', 'undo_script_blocking' ), 11 );
	}

	/**
	 * Prevents changes made to how JavaScript file is added to
	 * pages.
	 *
	 * @param array $blocking
	 *
	 * @return array
	 */
    public static function undo_script_blocking( $blocking ) {
        $settings = ctf_get_database_settings();
        if ( ! CTF_GDPR_Integrations::doing_gdpr( $settings ) ) {
            return $blocking;
        }
        unset( $blocking['twitter-feed'] );
        return $blocking;
    }

	/**
	 * Whether or not consent plugins that Twitter Feed
	 * is compatible with are active.
	 *
	 * @return bool|string
	 */
	public static function gdpr_plugins_active() {
		if ( class_exists( 'Cookie_Notice' ) ) {
			return 'Cookie Notice by dFactory';
		}
		if ( function_exists( 'run_cookie_law_info' ) || class_exists( 'Cookie_Law_Info' ) ) {
			return 'GDPR Cookie Consent by WebToffee';
		}
		if ( class_exists( 'Cookiebot_WP' ) ) {
			return 'Cookiebot by Cybot A/S';
		}
		if ( class_exists( 'COMPLIANZ' ) ) {
			return 'Complianz by Really Simple Plugins';
		}
		if ( function_exists('BorlabsCookieHelper') ) {
			return 'Borlabs Cookie by Borlabs';
		}

		return false;
	}

	/**
	 * GDPR features can be added automatically, forced enabled,
	 * or forced disabled.
	 *
	 * @param $settings
	 *
	 * @return bool
	 */
	public static function doing_gdpr( $settings ) {
		$gdpr = isset( $settings['gdpr'] ) ? $settings['gdpr'] : 'auto';
		if ( $gdpr === 'no' ) {
			return false;
		}
		if ( $gdpr === 'yes' ) {
			return true;
		}
		return (CTF_GDPR_Integrations::gdpr_plugins_active() !== false);
	}

	public static function blocking_cdn( $settings ) {
		$gdpr = isset( $settings['gdpr'] ) ? $settings['gdpr'] : 'auto';
		if ( $gdpr === 'no' ) {
			return false;
		}
		if ( $gdpr === 'yes' ) {
			return true;
		}
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );

		if ( $ctf_statuses_option['gdpr']['from_update_success'] ) {
			return (CTF_GDPR_Integrations::gdpr_plugins_active() !== false);
		}
		return false;
	}

	/**
	 * GDPR features are reliant on the image resizing features
	 *
	 * @param bool $retest
	 *
	 * @return bool
	 */
	public static function gdpr_tests_successful( $retest = false ) {
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );

		if ( ! isset( $ctf_statuses_option['gdpr']['image_editor'] ) || $retest ) {
			$test_image = trailingslashit( CTF_PLUGIN_URL ) . 'img/placeholder.png';

			$image_editor = wp_get_image_editor( $test_image );

			// not uncommon for the image editor to not work using it this way
			$ctf_statuses_option['gdpr']['image_editor'] = false;
			// not uncommon for the image editor to not work using it this way
			if ( ! is_wp_error( $image_editor ) ) {
				$ctf_statuses_option['gdpr']['image_editor'] = true;
			} else {
				$image_editor = wp_get_image_editor( 'https://plugin.smashballoon.com/editor-test.png' );
				if ( ! is_wp_error( $image_editor ) ) {
					$ctf_statuses_option['gdpr']['image_editor'] = true;
				}
			}

			$upload     = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_dir = trailingslashit( $upload_dir ) . CTF_UPLOADS_NAME;
			if ( file_exists( $upload_dir ) ) {
				$ctf_statuses_option['gdpr']['upload_dir'] = true;
			} else {
				$ctf_statuses_option['gdpr']['upload_dir'] = false;
			}

			global $wpdb;
			$table_name = esc_sql( $wpdb->prefix . CTF_POSTS_TABLE );
			$ctf_statuses_option['gdpr']['tables'] = true;
			if ( $wpdb->get_var( "show tables like '$table_name'" ) != $table_name ) {
				$ctf_statuses_option['gdpr']['tables'] = false;
			}

			$feeds_posts_table_name = esc_sql( $wpdb->prefix . CTF_POSTS_TABLE );
			if ( $wpdb->get_var( "show tables like '$feeds_posts_table_name'" ) != $feeds_posts_table_name ) {
				$ctf_statuses_option['gdpr']['tables'] = false;
			}

			update_option( 'ctf_statuses', $ctf_statuses_option );
		}

		if ( ! $ctf_statuses_option['gdpr']['upload_dir']
			|| ! $ctf_statuses_option['gdpr']['tables']
			|| ! $ctf_statuses_option['gdpr']['image_editor'] ) {
			return false;
		}

		return true;
	}

	public static function gdpr_tests_error_message() {
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );

		$errors = array();
		if ( ! $ctf_statuses_option['gdpr']['upload_dir'] ) {
			$errors[] =  __( 'A folder for storing resized images was not successfully created.' );
		}
		if ( ! $ctf_statuses_option['gdpr']['tables'] ) {
			$errors[] = __( 'Tables used for storing information about resized images were not successfully created.' );
		}
		if ( ! $ctf_statuses_option['gdpr']['image_editor'] ) {
			$errors[] = __( 'An image editor is not available on your server. Twitter Feed is unable to create local resized images.' );
		}

		if ( isset( $_GET['tab'] ) && $_GET['tab'] !== 'support' ) {
			$errors[] = '<a href="?page=custom-twitter-feeds&amp;tab=customize&amp;retest=1" class="button button-secondary">' . __( 'Retest', 'custom-twitter-feeds' ) . '</a>';
		}

		return implode( '<br>', $errors );
	}

}

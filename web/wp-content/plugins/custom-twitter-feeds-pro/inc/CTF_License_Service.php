<?php
/**
 * CTF License Service Class.
 *
 * @since 2.1.0
 */
namespace TwitterFeed;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use TwitterFeed\Admin\CTF_HTTP_Request;

class CTF_License_Service {

	/**
	 * Instance
	 *
	 * @since 2.1.0
	 * @access private
	 * @static
	 * @var CTF_License_Service
	 */
	private static $instance;

	/**
	 * Get license renew URL.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public $get_renew_url;

	/**
	 * Get the plugin license key.
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public $get_license_key;

	/**
	 * Get the plugin license data
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public $get_license_data;

	/**
	 * Check whether the license expired or not
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public $is_license_expired;

	/**
	 * Check whether the grace period ended or not
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public $is_license_grace_period_ended;

	/**
	 * Check whether the license expired and grace period ended
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public $expiredLicenseWithGracePeriodEnded;

	/**
	 * Should disable Pro features
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public $should_disable_pro_features;

	/**
	 * Get SB Active Plugins Info
	 *
	 * @since 2.1.0
	 * @access public
	 */
	public $get_sb_active_plugins_info;

	/**
	 * Instantiate the class
	 */
    public static function instance() {
        if ( null === self::$instance) {
			self::$instance = new self();

			self::$instance->get_renew_url = self::get_renew_url();
			self::$instance->get_license_key = self::get_license_key();
			self::$instance->get_license_data = self::get_license_data();
			self::$instance->is_license_expired = self::is_license_expired();
			self::$instance->is_license_grace_period_ended = self::is_license_grace_period_ended();
			self::$instance->expiredLicenseWithGracePeriodEnded = self::expiredLicenseWithGracePeriodEnded();
			self::$instance->should_disable_pro_features = self::should_disable_pro_features();
			self::$instance->get_sb_active_plugins_info = self::get_sb_active_plugins_info();
        }

		return self::$instance;
    }

	public static function is_current_screen_allowed() {
		$current_screen = get_current_screen();
		$allowed_screens = array(
            'twitter-feed_page_ctf-feed-builder',
            'twitter-feed_page_ctf-settings',
            'twitter-feed_page_ctf-oembeds-manager',
            'twitter-feed_page_ctf-extensions-manager',
            'twitter-feed_page_ctf-about-us',
            'twitter-feed_page_ctf-support',
		);
		$allowed_screens = apply_filters( 'ctf_admin_pages_allowed_screens', $allowed_screens );
		$is_allowed = in_array( $current_screen->id, $allowed_screens );
		return array(
			'is_allowed' => $is_allowed,
			'base' => $current_screen->base,
		);
	}

	public static function get_license_key() {
		$license_key = get_option( 'ctf_license_key' );
		$license_key = apply_filters( 'ctf_license_key', $license_key );
		return trim($license_key);
	}

	public static function get_license_data() {
		if ( get_option( 'ctf_license_data' ) ) {
			// Get license data from the db and convert the object to an array
			return (array) get_option( 'ctf_license_data' );
		}

		$ctf_license_data = self::ctf_check_license( self::$instance->get_license_key );

		return $ctf_license_data;
	}

	public static function is_license_expired() {
		$ctf_license_data = (array) self::$instance->get_license_data;
		if ( ! empty( $ctf_license_data['license'] ) && $ctf_license_data['license'] !== 'valid' ) {
			return true;
		}

		//If expires param isn't set yet then set it to be a date to avoid PHP notice
		$ctf_license_expires_date = isset( $ctf_license_data['expires'] ) ? $ctf_license_data['expires'] : '2036-12-31 23:59:59';
		if ( $ctf_license_expires_date === 'lifetime' ) {
			$ctf_license_expires_date = '2036-12-31 23:59:59';
		}
		$ctf_todays_date = gmdate( 'Y-m-d' );
		$ctf_interval = round( abs( strtotime( $ctf_todays_date ) - strtotime( $ctf_license_expires_date ) ) / 86400 );
		//Is license expired?
		if ( $ctf_interval === 0 || strtotime( $ctf_license_expires_date ) < strtotime( $ctf_todays_date ) ) {
			//If we haven't checked the API again one last time before displaying the expired notice then check it to make sure the license hasn't been renewed
			if ( get_option( 'ctf_check_license_api_when_expires' ) !== 'false' ) {
				$ctf_license_expired = self::$instance->ctf_check_license( self::$instance->get_license_key, true );
			} else {
				$ctf_license_expired = true;
			}
		} else {
			$ctf_license_expired = false;
			//License is not expired so change the check_api setting to be true so the next time it expires it checks again
			update_option( 'ctf_check_license_api_when_expires', 'true' );
			update_option( 'ctf_check_license_api_post_grace_period', 'true' );
		}

		$ctf_license_expires_date_arr = str_split( $ctf_license_expires_date );
		// If expired date is returned as 1970 (or any other 20th century year) then it means that the correct expired date was not returned and so don't show the renewal notice
		if ( $ctf_license_expires_date_arr[0] === '1' ) {
			$ctf_license_expired = false;
		}

		// If there's no expired date then don't show the expired notification
		if ( empty( $ctf_license_expires_date ) || ! isset( $ctf_license_expires_date ) ) {
			$ctf_license_expired = false;
		}

		// Is license missing - ie. on very first check
		if ( isset( $ctf_license_data['error'] ) ) {
			if ( $ctf_license_data['error'] === 'missing' ) {
				$ctf_license_expired = false;
			}
		}

		return $ctf_license_expired;
	}

	public static function is_license_grace_period_ended( $post_grace_period = false ) {
		// Get license data
		$ctf_license_data = (array) self::$instance->get_license_data;
		//If expires param isn't set yet then set it to be a date to avoid PHP notice
		$ctf_license_expires_date = isset( $ctf_license_data['expires'] ) ? $ctf_license_data['expires'] : '2036-12-31 23:59:59';
		if ( $ctf_license_expires_date == 'lifetime' ) {
			$ctf_license_expires_date = '2036-12-31 23:59:59';
		}

		$ctf_todays_date = date('Y-m-d');
		$ctf_grace_period_date = strtotime( $ctf_license_expires_date . '+14 days');
		$ctf_grace_period_interval = round( abs( strtotime( $ctf_todays_date ) - $ctf_grace_period_date ) / 86400 );

		if ( $post_grace_period && strtotime( $ctf_todays_date ) > $ctf_grace_period_date ) {
			return true;
		}

		if ( $ctf_grace_period_interval == 0 || $ctf_grace_period_date < strtotime( $ctf_todays_date ) ) {
			return true;
		}

		return;
	}

	/**
	 * Remote check for license status
	 *
	 * @since 2.1.0
	 */
	public static function ctf_check_license( $ctf_license, $check_license_status = false, $license_api_second_check = false  ) {
		$ctf_license = empty($ctf_license) ? $ctf_license : self::$instance->get_license_key;
		if ( empty( $ctf_license ) ) {
			return;
		}
		if ( $license_api_second_check ) {
			update_option( 'ctf_check_license_api_post_grace_period', 'false' );
		} else {
			update_option( 'ctf_check_license_api_when_expires', 'false' );
		}
		// data to send to our API request
		$ctf_api_params = array(
			'edd_action' => 'check_license',
			'license'    => $ctf_license,
			'item_name'  => urlencode( CTF_PRODUCT_NAME ), // the name of our product in EDD
		);
		$api_url        = add_query_arg( $ctf_api_params, CTF_STORE_URL );
		$args           = array(
			'timeout'   => 60,
			'sslverify' => false
		);
		// Call the remore license request.
		$request = CTF_HTTP_Request::request( 'GET', $api_url, $args );
		if ( CTF_HTTP_Request::is_error( $request ) ) {
			return;
		}
		// decode the license data
		$ctf_license_data = (array) CTF_HTTP_Request::data( $request );
		//Store license data in db
		if ( $ctf_license_data && is_array( $ctf_license_data ) && isset( $ctf_license_data['license'] ) ) {
			update_option( 'ctf_license_data', $ctf_license_data );
			update_option( 'ctf_license_status', $ctf_license_data['license'] );
		}
		$ctf_todays_date = gmdate( 'Y-m-d' );
		if ( $check_license_status ) {
			//Check whether it's active
			if( $ctf_license_data['license'] !== 'expired' && ( strtotime( $ctf_license_data['expires'] ) > strtotime( $ctf_todays_date ) ) ){
				$ctf_license_status = false;
			} else {
				$ctf_license_status = true;
			}

			return $ctf_license_status;
		}

		return $ctf_license_data;
	}

	/**
	 * Check if licese expired/inactive notices needs to show
	 *
	 * @since 2.0.2
	 */
	public static function expiredLicenseWithGracePeriodEnded() {
		return !empty( self::$instance->get_license_key ) &&
				self::$instance->is_license_expired &&
				self::is_license_grace_period_ended( true );
	}

	/**
	 * Check if need to disable the pro features
	 *
	 * @since 2.1.0
	 */
	public static function should_disable_pro_features() {
		return empty( self::$instance->get_license_key ) ||
				( self::$instance->is_license_expired &&
				self::$instance->is_license_grace_period_ended );
	}

    /**
     * CTF Get Renew License URL
     *
     * @since 4.0
     *
     * @return string $url
     */
    public static function get_renew_url( $license_state = 'expired' ) {
        global $ctf_download_id;

		if ( $license_state == 'inactive' ) {
			return admin_url('admin.php?page=ctf-settings&focus=license');
		}
        $license_key = self::$instance->get_license_key;

        $url = sprintf(
            'https://smashballoon.com/checkout/?edd_license_key=%s&download_id=%s&utm_campaign=twitter-pro&utm_source=expired-notice&utm_medium=renew-license',
            $license_key,
            $ctf_download_id
        );

        return $url;
    }


	/**
	 * Get other active plugins of Smash Balloon
	 *
	 * @since 2.1.0
	 */
	public static function get_sb_active_plugins_info() {
		// get the WordPress's core list of installed plugins
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$installed_plugins = get_plugins();

		$is_facebook_installed = false;
		$facebook_plugin = 'custom-facebook-feed/custom-facebook-feed.php';
		if ( isset( $installed_plugins['custom-facebook-feed-pro/custom-facebook-feed.php'] ) ) {
			$is_facebook_installed = true;
			$facebook_plugin = 'custom-facebook-feed-pro/custom-facebook-feed.php';
		} else if ( isset( $installed_plugins['custom-facebook-feed/custom-facebook-feed.php'] ) ) {
			$is_facebook_installed = true;
		}

		$is_instagram_installed = false;
		$instagram_plugin = 'instagram-feed/instagram-feed.php';
		if ( isset( $installed_plugins['instagram-feed-pro/instagram-feed.php'] ) ) {
			$is_instagram_installed = true;
			$instagram_plugin = 'instagram-feed-pro/instagram-feed.php';
		} else if ( isset( $installed_plugins['instagram-feed/instagram-feed.php'] ) ) {
			$is_instagram_installed = true;
		}

		$is_twitter_installed = false;
		$twitter_plugin = 'custom-twitter-feeds/custom-twitter-feed.php';
		if ( isset( $installed_plugins['custom-twitter-feeds-pro/custom-twitter-feed.php'] ) ) {
			$is_twitter_installed = true;
			$twitter_plugin = 'custom-twitter-feeds-pro/custom-twitter-feed.php';
		} else if ( isset( $installed_plugins['custom-twitter-feeds/custom-twitter-feed.php'] ) ) {
			$is_twitter_installed = true;
		}

		$is_youtube_installed = false;
		$youtube_plugin       = 'feeds-for-youtube/youtube-feed.php';
		if ( isset( $installed_plugins['youtube-feed-pro/youtube-feed-pro.php'] ) ) {
			$is_youtube_installed = true;
			$youtube_plugin       = 'youtube-feed-pro/youtube-feed-pro.php';
		} elseif ( isset( $installed_plugins['feeds-for-youtube/youtube-feed.php'] ) ) {
			$is_youtube_installed = true;
		}

		$is_social_wall_installed = isset( $installed_plugins['social-wall/social-wall.php'] ) ? true : false;
		$social_wall_plugin = 'social-wall/social-wall.php';


		return array(
			'is_facebook_installed' => $is_facebook_installed,
			'is_instagram_installed' => $is_instagram_installed,
			'is_twitter_installed' => $is_twitter_installed,
			'is_youtube_installed' => $is_youtube_installed,
			'is_social_wall_installed' => $is_social_wall_installed,
			'facebook_plugin' => $facebook_plugin,
			'instagram_plugin' => $instagram_plugin,
			'twitter_plugin' => $twitter_plugin,
			'youtube_plugin' => $youtube_plugin,
			'social_wall_plugin' => $social_wall_plugin,
			'installed_plugins' => $installed_plugins
		);
	}
}

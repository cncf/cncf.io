<?php

/**
 * The Settings Page
 *
 * @since 2.0
 */

namespace TwitterFeed\Admin;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use TwitterFeed\Admin\CTF_Response;
use TwitterFeed\Builder\CTF_Feed_Saver;
use TwitterFeed\Builder\CTF_Feed_Builder;
use TwitterFeed\Admin\CTF_HTTP_Request;
use TwitterFeed\CTF_GDPR_Integrations;
use TwitterFeed\Pro\CTF_Resizer;
use TwitterFeed\SB_Twitter_Cron_Updater_Pro;

class CTF_Global_Settings {
	//use CTF_Settings;
	/**
	 * Admin menu page slug.
	 *
	 * @since 2.0
	 *
	 * @var string
	 */
	const SLUG = 'ctf-settings';

	/**
	 * Initializing the class
	 *
	 * @since 2.0
	 */
	function __construct(){
		$this->init();
	}

	/**
	 * Determining if the user is viewing the our page, if so, party on.
	 *
	 * @since 2.0
	 */
	public function init() {
		if ( ! is_admin() ) {
			return;
		}

		add_action('admin_menu', [$this, 'register_menu']);
		add_filter( 'admin_footer_text', [$this, 'remove_admin_footer_text'] );

		add_action( 'wp_ajax_ctf_save_settings', [$this, 'ctf_save_settings'] );
		add_action( 'wp_ajax_ctf_activate_license', [$this, 'ctf_activate_license'] );
		add_action( 'wp_ajax_ctf_deactivate_license', [$this, 'ctf_deactivate_license'] );
		add_action( 'wp_ajax_ctf_test_connection', [$this, 'ctf_test_connection'] );
		add_action( 'wp_ajax_ctf_recheck_connection', [$this, 'ctf_recheck_connection'] );
		add_action( 'wp_ajax_ctf_import_settings_json', [$this, 'ctf_import_settings_json'] );
		add_action( 'wp_ajax_ctf_export_settings_json', [$this, 'ctf_export_settings_json'] );
		add_action( 'wp_ajax_ctf_clear_cache_settings', [$this, 'ctf_clear_cache_settings'] );
		add_action( 'wp_ajax_ctf_clear_persistent_cache', [$this, 'ctf_clear_persistent_cache'] );
		add_action( 'wp_ajax_ctf_clear_twittercard_cache', [$this, 'ctf_clear_twittercard_cache'] );
		add_action( 'wp_ajax_ctf_clear_image_resize_cache', [$this, 'ctf_clear_image_resize_cache'] );
		add_action( 'wp_ajax_ctf_dpa_reset', [$this, 'ctf_dpa_reset'] );
	}

	/**
	 * SBI Save Settings
	 *
	 * This will save the data fron the settings page
	 *
	 * @since 2.0
	 *
	 * @return CTF_Response
	 */
	public function ctf_save_settings() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$data = $_POST;
		$model = isset( $data[ 'model' ] ) ? $data['model'] : null;

		// return if the model is null
		if ( null === $model ) {
			return;
		}

		// get the ctf license key and extensions license key
		$ctf_license_key = sanitize_text_field( $_POST['ctf_license_key'] );

		// Only update the ctf_license_key value when it's inactive
		if ( get_option( 'ctf_license_status') == 'inactive' ) {
			if ( empty( $ctf_license_key ) || strlen( $ctf_license_key ) < 1 ) {
				delete_option( 'ctf_license_key' );
				delete_option( 'ctf_license_data' );
				delete_option( 'ctf_license_status' );
			} else {
				update_option( 'ctf_license_key', $ctf_license_key );
			}
		} else {
			$license_key = trim( get_option( 'ctf_license_key' ) );

			if ( empty( $ctf_license_key ) && ! empty( $license_key ) ) {
				$ctf_license_data = $this->get_license_data( $license_key, 'deactivate_license', CTF_PRODUCT_NAME );

				delete_option( 'ctf_license_key' );
				delete_option( 'ctf_license_data' );
				delete_option( 'ctf_license_status' );
			}
		}

		$model = (array) \json_decode( \stripslashes( $model ) );

		$general = (array) $model['general'];
		$feeds = (array) $model['feeds'];
		$translation = (array) $model['translation'];
		$advanced = (array) $model['advanced'];

		// Get the values and sanitize
		$ctf_settings = get_option( 'ctf_options', array() );

		/**
		 * General Tab
		 */
		$ctf_settings['preserve_settings']       = $general['preserveSettings'];

		// Save translation settings data
		foreach( $translation as $key => $val ) {
			$ctf_settings[ $key ] = $val;
		}

		/**
		 * Feeds Tab
		 */
		$ctf_settings['custom_css']    			= $feeds['customCSS'];
		$ctf_settings['custom_js'] 				= $feeds['customJS'];
		$ctf_settings['gdpr'] 			        = sanitize_text_field( $feeds['gdpr'] );
		$ctf_settings['ctf_caching_type']    	= sanitize_text_field( $feeds['cachingType'] );
		$ctf_settings['cache_time']    			= sanitize_text_field( $feeds['cacheTime'] );
		$ctf_settings['cache_time_unit']        = sanitize_text_field( $feeds['cacheTimeUnit'] );

		$ctf_settings['ctf_cache_cron_interval'] = sanitize_text_field( $feeds['cronInterval'] );
		$ctf_settings['ctf_cache_cron_time']     = sanitize_text_field( $feeds['cronTime'] );
		$ctf_settings['ctf_cache_cron_am_pm']    = sanitize_text_field( $feeds['cronAmPm'] );
		/**
		 * Advanced Tab
		 */
		$ctf_settings['resizing'] 				= (bool)$advanced['resizing'];
		$ctf_settings['persistentcache'] 		= (bool)$advanced['persistentcache'];
		$ctf_settings['ajax_theme'] 			= (bool)$advanced['ajax_theme'];
		$ctf_settings['headenqueue'] 			= (bool)$advanced['headenqueue'];
		$ctf_settings['customtemplates'] 		= (bool)$advanced['customtemplates'];
		$ctf_settings['creditctf'] 				= (bool)$advanced['creditctf'];
		$ctf_settings['autores'] 				= (bool)$advanced['autores'];
		$ctf_settings['customtemplates'] 		= (bool)$advanced['customtemplates'];
		$ctf_settings['disableintents'] 		= !(bool)$advanced['enableintents'];
		$ctf_settings['request_method'] 		= sanitize_text_field($advanced['request_method']);
		$ctf_settings['cron_cache_clear'] 		= sanitize_text_field($advanced['cron_cache_clear']);
		$ctf_settings['sslonly'] 				= (bool)$advanced['sslonly'];
		$ctf_settings['curlcards'] 				= (bool)$advanced['curlcards'];


		$usage_tracking = get_option( 'ctf_usage_tracking', array( 'last_send' => 0, 'enabled' => ctf_is_pro_version() ) );
		if ( isset( $advanced['email_notification_addresses'] ) ) {
			$usage_tracking['enabled'] = false;
			if ( isset( $advanced['usage_tracking'] ) ) {
				if ( ! is_array( $usage_tracking ) ) {
					$usage_tracking = array(
						'enabled' => $advanced['usage_tracking'],
						'last_send' => 0,
					);
				} else {
					$usage_tracking['enabled'] = $advanced['usage_tracking'];
				}
			}
			update_option( 'ctf_usage_tracking', $usage_tracking, false );
		}

		// Update the ctf_style_settings option that contains data for translation and advanced tabs
		update_option( 'ctf_options', $ctf_settings );

		// clear cron caches
		SB_Twitter_Cron_Updater_Pro::start_cron_job( $ctf_settings['ctf_cache_cron_interval'], $ctf_settings['ctf_cache_cron_time'], $ctf_settings['ctf_cache_cron_am_pm']  );

		// Clear the stored caches.
		$cache_handler = new CTF_Cache_Handler();
		$cache_handler->clear_persistent_cache();

		new CTF_Response( true, array(
			'cronNextCheck' => $this->get_cron_next_check()
		) );
	}

	/**
	 * SBI Activate License Key
	 *
	 * @since 2.0
	 *
	 * @return CTF_Response
	 */
	public function ctf_activate_license() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		// do the form validation to check if license_key is not empty
		if ( empty( $_POST[ 'license_key' ] ) ) {
			new CTF_Response( false, array(
				'message' => __( 'License key required!', 'custom-twitter-feeds' ),
			) );
		}
		$license_key = sanitize_text_field( $_POST[ 'license_key' ] );
		// make the remote api call and get license data
		$ctf_license_data = $this->get_license_data( $license_key, 'activate_license', CTF_PRODUCT_NAME );

		// update the license data
		if( !empty( $ctf_license_data ) ) {
			update_option( 'ctf_license_data', $ctf_license_data );
		}
		// update the licnese key only when the license status is activated
		update_option( 'ctf_license_key', $license_key );
		// update the license status
		update_option( 'ctf_license_status', $ctf_license_data['license'] );

		// Check if there is any error in the license key then handle it
		$ctf_license_data = $this->get_license_error_message( $ctf_license_data );


		// Send ajax response back to client end
		$data = array(
			'licenseStatus' => $ctf_license_data['license'],
			'licenseData' => $ctf_license_data
		);
		new CTF_Response( true, $data );
	}

	/**
	 * SBI Deactivate License Key
	 *
	 * @since 2.0
	 *
	 * @return CTF_Response
	 */
	public function ctf_deactivate_license() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$license_key = trim( get_option( 'ctf_license_key' ) );
		$ctf_license_data = $this->get_license_data( $license_key, 'deactivate_license', CTF_PRODUCT_NAME );
		// update the license data
		if( !empty( $ctf_license_data ) ) {
			update_option( 'ctf_license_data', $ctf_license_data );
		}
		if ( ! $ctf_license_data['success'] ) {
			new CTF_Response( false, array() );
		}
		// remove the license keys and update license key status
		if( $ctf_license_data['license'] == 'deactivated' ) {
			update_option( 'ctf_license_status', 'inactive' );
			$data = array(
				'licenseStatus' => 'inactive'
			);
			new CTF_Response( true, $data );
		}
	}

	/**
	 * SBI Test Connection
	 *
	 * @since 2.0
	 *
	 * @return CTF_Response
	 */
	public function ctf_test_connection() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$license_key = get_option( 'ctf_license_key' );
		$ctf_api_params = array(
			'edd_action'=> 'check_license',
			'license'   => $license_key,
			'item_name' => urlencode( CTF_PRODUCT_NAME ) // the name of our product in EDD
		);
		$url = add_query_arg( $ctf_api_params, CTF_STORE_URL );
		$args = array(
			'timeout' => 60,
			'sslverify' => false
		);
		// Make the remote API request
		$request = CTF_HTTP_Request::request( 'GET', $url, $args );
		if ( CTF_HTTP_Request::is_error( $request ) ) {
			ray($request);
			new CTF_Response( false, array(
				'hasError' => true
			) );
		}

		new CTF_Response( true, array(
			'hasError' => false
		) );
	}

	/**
	 * SBI Re-Check License
	 *
	 * @since 2.0
	 *
	 * @return CTF_Response
	 */
	public function ctf_recheck_connection() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		// Do the form validation
		$license_key = isset( $_POST['license_key'] ) ? sanitize_text_field( $_POST['license_key'] ) : '';
		$item_name = isset( $_POST['item_name'] ) ? sanitize_text_field( $_POST['item_name'] ) : '';
		$option_name = isset( $_POST['option_name'] ) ? sanitize_text_field( $_POST['option_name'] ) : '';
		if ( empty( $license_key ) || empty( $item_name ) ) {
			new CTF_Response( false, array() );
		}

		// make the remote license check API call
		$ctf_license_data = $this->get_license_data( $license_key, 'check_license', $item_name );

		// update options data
		$license_changed = $this->update_recheck_license_data( $ctf_license_data, $item_name, $option_name );

		// send AJAX response back
		new CTF_Response( true, array(
			'license' => $ctf_license_data['license'],
			'licenseChanged' => $license_changed
		) );
	}

	/**
	 * Update License Data
	 *
	 * @since 2.0
	 *
	 * @param array $license_data
	 * @param string $item_name
	 * @param string $option_name
	 *
	 * @return bool $license_changed
	 */
	public function update_recheck_license_data( $license_data, $item_name, $option_name ) {
		$license_changed = false;
		// if we are updating plugin's license data
		if ( CTF_PRODUCT_NAME == $item_name ) {
			// compare the old stored license status with new license status
			if ( get_option( 'ctf_license_status' ) != $license_data['license'] ) {
				$license_changed = true;
			}
			update_option( 'ctf_license_data', $license_data );
			update_option( 'ctf_license_status', $license_data['license'] );
		}

		// If we are updating extensions license data
		if ( CTF_PRODUCT_NAME != $item_name ) {
			// compare the old stored license status with new license status
			if ( get_option( 'ctf_license_status_' . $option_name ) != $license_data['license'] ) {
				$license_changed = true;
			}
			update_option( 'ctf_license_status_' . $option_name, $license_data['license'] );
		}
		// if we are updating extensions license data and it's not valid
		// then remote the extensions license status
		if ( CTF_PRODUCT_NAME != $item_name && 'valid' != $license_data['license'] ) {
			delete_option( 'ctf_license_status_' . $option_name );
		}

		return $license_changed;
	}

	/**
	 * SBI Import Feed Settings JSON
	 *
	 * @since 2.0
	 *
	 * @return CTF_Response
	 */
	public function ctf_import_settings_json() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		$filename = $_FILES['file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ( 'json' !== $ext ) {
			new CTF_Response( false, [] );
		}
		$imported_settings = file_get_contents( $_FILES["file"]["tmp_name"] );
		// check if the file is empty
		if ( empty( $imported_settings ) ) {
			new CTF_Response( false, [] );
		}
		$feed_return = \TwitterFeed\Builder\CTF_Feed_Saver_Manager::import_feed( $imported_settings );
		// check if there's error while importing
		if ( ! $feed_return['success'] ) {
			new CTF_Response( false, [] );
		}
		// Once new feed has imported lets export all the feeds to update in front end
		$exported_feeds = \TwitterFeed\Builder\CTF_Db::feeds_query();
		$feeds = array();
		foreach( $exported_feeds as $feed_id => $feed ) {
			$feeds[] = array(
				'id' => $feed['id'],
				'name' => $feed['feed_name']
			);
		}

		new CTF_Response( true, array(
			'feeds' => $feeds
		) );
	}

	/**
	 * SBI Export Feed Settings JSON
	 *
	 * @since 2.0
	 *
	 * @return CTF_Response
	 */
	public function ctf_export_settings_json() {
		\TwitterFeed\Builder\CTF_Feed_Builder::check_privilege();
		if ( ! isset( $_GET['feed_id'] ) ) {
			return;
		}
		$feed_id = filter_var( $_GET['feed_id'], FILTER_SANITIZE_NUMBER_INT );
		$feed = \TwitterFeed\Builder\CTF_Feed_Saver_Manager::get_export_json( $feed_id );
		$feed_info = \TwitterFeed\Builder\CTF_Db::feeds_query( array('id' => $feed_id) );
		$feed_name = strtolower( $feed_info[0]['feed_name'] );
		$filename = 'ctf-feed-' . $feed_name . '.json';
		// create a new empty file in the php memory
		$file  = fopen( 'php://memory', 'w' );
		fwrite( $file, $feed );
		fseek( $file, 0 );
		header( 'Content-type: application/json' );
		header( 'Content-disposition: attachment; filename = "' . $filename . '";' );
		fpassthru( $file );
		exit;
	}

	/**
	 * SBI Clear Cache
	 *
	 * @since 2.0
	 */
	public function ctf_clear_cache_settings() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		// Get the updated cron schedule interval and time settings from user input and update the database
		$model = isset( $_POST[ 'model' ] ) ? sanitize_text_field( $_POST['model'] ) : null;
		if ( $model !== null ) {
			$model = (array) \json_decode( \stripslashes( $model ) );
			$feeds = (array) $model['feeds'];
			$ctf_options = wp_parse_args( get_option( 'ctf_options' ), $this->default_settings_options() );

			$cron_clear_cache = isset($ctf_options['cron_cache_clear']) ? $ctf_options['cron_cache_clear'] : 'no';
			ctf_clear_cache_sql();

			/*
			$cache_time = isset($feeds['cache_time']) ? (int)$feeds['cache_time'] : 1;
			$cache_time_unit = isset($feeds['cache_time_unit']) ? (int)$feeds['cache_time_unit'] : 3600;
			if ($cron_clear_cache == 'no') {
				wp_clear_scheduled_hook('ctf_cron_job');
			}
			elseif ($cron_clear_cache == 'yes') {
				//Clear the existing cron event
				wp_clear_scheduled_hook('ctf_cron_job');
				//Set the event schedule based on what the caching time is set to
				if ($cache_time_unit == 3600 && $cache_time > 5) {
					$ctf_cron_schedule = 'twicedaily';
				}
				elseif ($cache_time_unit == 86400) {
					$ctf_cron_schedule = 'daily';
				}
				else {
					$ctf_cron_schedule = 'hourly';
				}

				wp_schedule_event(time() , $ctf_cron_schedule, 'ctf_cron_job');
			}
			*/

			// Clear the stored caches.
			$cache_handler = new CTF_Cache_Handler();
			$cache_handler->clear_all_cache();

			$ctf_cache_cron_interval = $ctf_options['ctf_cache_cron_interval'];
			$ctf_cache_cron_time     = $ctf_options['ctf_cache_cron_time'];
			$ctf_cache_cron_am_pm    = $ctf_options['ctf_cache_cron_am_pm'];

			SB_Twitter_Cron_Updater_Pro::start_cron_job( $ctf_cache_cron_interval, $ctf_cache_cron_time, $ctf_cache_cron_am_pm );
		}



		new CTF_Response( true, array(
			'cronNextCheck' => $this->get_cron_next_check()
		) );
	}

	/**
	 * SBI Clear Image Resize Cache
	 *
	 * @since 2.0
	 */
	public function ctf_clear_image_resize_cache() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );
		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		CTF_Resizer::delete_resizing_table_and_images( false );

		new CTF_Response( true, [] );
	}

	/**
	 * CTF Clear Persistent Cache
	 *
	 * @since 2.0
	 */
	public function ctf_clear_persistent_cache() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		$cache = new CTF_Cache_Handler();

		$cache->clear_persistent_cache();
		new CTF_Response( true, [] );
	}

	/**
	 * CTF Clear Persistent Cache
	 *
	 * @since 2.0
	 */
	public function ctf_clear_twittercard_cache() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$cache = new CTF_Cache_Handler();

		$cache->clear_twittercard_cache();

		new CTF_Response( true, [] );
	}


	/**
	 * SBI Clear Image Resize Cache
	 *
	 * @since 2.0
	 */
	public function ctf_dpa_reset() {
		check_ajax_referer( 'ctf_admin_nonce', 'nonce' );

		if ( ! ctf_current_user_can( 'manage_twitter_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		ctf_delete_all_platform_data();

		new CTF_Response( true, [] );
	}

	/**
	 * SBI Get License Data from our license API
	 *
	 * @since 2.0
	 *
	 * @param string $license_key
	 * @param string $license_action
	 *
	 * @return void|array $ctf_license_data
	 */
	public function get_license_data( $license_key, $license_action = 'check_license', $item_name = CTF_PRODUCT_NAME ) {
		$ctf_api_params = array(
			'edd_action'=> $license_action,
			'license'   => $license_key,
			'item_name' => urlencode( $item_name ) // the name of our product in EDD
		);
		$url = add_query_arg( $ctf_api_params, CTF_STORE_URL );
		$args = array(
			'timeout' => 60,
			'sslverify' => false
		);
		// Make the remote API request
		$request = CTF_HTTP_Request::request( 'GET', $url, $args );
		if ( CTF_HTTP_Request::is_error( $request ) ) {
			return;
		}
		$ctf_license_data = (array) CTF_HTTP_Request::data( $request );
		return $ctf_license_data;
	}

	/**
	 * Get license error message depending on license status
	 *
	 * @since 2.0
	 *
	 * @param array $ctf_license_data
	 *
	 * @return array $ctf_license_data
	 */
	public function get_license_error_message( $ctf_license_data ) {
		$license_key = null;
		if ( get_option('ctf_license_key') ) {
			$license_key = get_option('ctf_license_key');
		}

		$upgrade_url 	= sprintf('https://smashballoon.com/pricing/twitter-feed/?license_key=%s&upgrade=true&utm_campaign=twitter-pro&utm_source=settings&utm_medium=upgrade-license', $license_key);
		$renew_url 		= sprintf('https://smashballoon.com/checkout/?edd_license_key=%s&download_id=%s&utm_campaign=twitter-pro&utm_source=settings&utm_medium=upgrade-license&utm_content=renew-license', $license_key, CTF_PRODUCT_ID);
		$learn_more_url = 'https://smashballoon.com/doc/my-license-key-wont-activate/?utm_campaign=twitter-pro&utm_source=settings&utm_medium=license&utm_content=learn-more';

		// Check if the license key reached max site installations
		if ( isset( $ctf_license_data['error'] ) && 'no_activations_left' === $ctf_license_data['error'] )  {
			$ctf_license_data['errorMsg'] = sprintf(
				'%s (%s/%s). %s <a href="%s" target="_blank">%s</a> %s <a href="%s" target="_blank">%s</a>',
				__( 'You have reached the maximum number of sites available in your plan', 'custom-twitter-feeds' ),
				$ctf_license_data['site_count'],
				$ctf_license_data['max_sites'],
				__( 'Learn more about it', 'custom-twitter-feeds' ),
				$learn_more_url,
				'here',
				__( 'or upgrade your plan.', 'custom-twitter-feeds' ),
				$upgrade_url,
				__( 'Upgrade', 'custom-twitter-feeds' )
			);
		}
		// Check if the license key has expired
		if (
			( isset( $ctf_license_data['license'] ) && 'expired' === $ctf_license_data['license'] ) ||
			( isset( $ctf_license_data['error'] ) && 'expired' === $ctf_license_data['error'] )
		)  {
			$ctf_license_data['error'] = true;
			$expired_date = new \DateTime( $ctf_license_data['expires'] );
			$expired_date = $expired_date->format('F d, Y');
			$ctf_license_data['errorMsg'] = sprintf(
				'%s %s. %s <a href="%s" target="_blank">%s</a>',
				__( 'The license expired on ', 'custom-twitter-feeds' ),
				$expired_date,
				__( 'Please renew it and try again.', 'custom-twitter-feeds' ),
				$renew_url,
				__( 'Renew', 'custom-twitter-feeds' )
			);
		}
		return $ctf_license_data;
	}

	/**
	 * Remove admin footer message
	 *
	 * @since 2.0
	 *
	 * @return void
	 */
	public function remove_admin_footer_text() {
		return;
	}

	/**
	 * Register Menu.
	 *
	 * @since 2.0
	 */
	function register_menu() {
		// remove admin page update footer
		add_filter( 'update_footer', [$this, 'remove_admin_footer_text'] );

        $cap = current_user_can( 'manage_custom_instagram_feed_options' ) ? 'manage_custom_instagram_feed_options' : 'manage_options';
        $cap = apply_filters( 'ctf_settings_pages_capability', $cap );

		$notice = '';
		/*if ( \ctf_main_pro()->ctf_error_reporter->are_critical_errors() ) {
			$notice = ' <span class="update-plugins ctf-error-alert"><span>!</span></span>';
		}*/

       $global_settings = add_submenu_page(
           'custom-twitter-feeds',
           __( 'Settings', 'custom-twitter-feeds' ),
           __( 'Settings ' . $notice , 'custom-twitter-feeds' ),
           $cap,
           'ctf-settings',
           [$this, 'global_settings'],
           1
       );
       add_action( 'load-' . $global_settings, [$this,'builder_enqueue_admin_scripts']);
   }

	/**
	 * Enqueue Builder CSS & Script.
	 *
	 * Loads only for builder pages
	 *
	 * @since 2.0
	 */
    public function builder_enqueue_admin_scripts(){
        if( ! get_current_screen() ) {
			return;
		}
		$screen = get_current_screen();
		if ( ! 'twitter-feed_page_ctf-settings' === $screen->id ) {
			return;
		}
		$ctf_status  = 'inactive';
		$model = $this->get_settings_data();
		$exported_feeds = \TwitterFeed\Builder\CTF_Db::feeds_query();
		$feeds = array();
		foreach( $exported_feeds as $feed_id => $feed ) {
			$feeds[] = array(
				'id' => $feed['id'],
				'name' => $feed['feed_name']
			);
		}
		$licenseErrorMsg = null;
		$license_key = trim( get_option( 'ctf_license_key' ) );
		if ( $license_key ) {
			$license_last_check = get_option( 'ctf_license_last_check_timestamp' );
			$date = time() - (DAY_IN_SECONDS * 90);
			if ( $date > $license_last_check ) {
				// make the remote api call and get license data
				$ctf_license_data = $this->get_license_data( $license_key );
				if( !empty($ctf_license_data) ) update_option( 'ctf_license_data', $ctf_license_data );
				update_option( 'ctf_license_last_check_timestamp', time() );
			} else {
				$ctf_license_data = get_option( 'ctf_license_data' );
			}
			// update the license data with proper error messages when necessary
			$ctf_license_data = $this->get_license_error_message( $ctf_license_data );
			$ctf_status = $ctf_license_data['license'];
			$licenseErrorMsg = ( isset( $ctf_license_data['error'] ) && isset( $ctf_license_data['errorMsg'] ) ) ? $ctf_license_data['errorMsg'] : null;
		}

		$ctf_options = get_option( 'ctf_options', array() );

		wp_enqueue_style(
			'settings-style',
			CTF_PLUGIN_URL . 'admin/assets/css/settings.css',
			false,
			CTF_VERSION
		);

	    \TwitterFeed\Builder\CTF_Feed_Builder::global_enqueue_ressources_scripts(true);


		wp_enqueue_script(
			'settings-app',
			CTF_PLUGIN_URL.'admin/assets/js/settings.js',
			null,
			CTF_VERSION,
			true
		);

		$license_key = null;
		if ( get_option('ctf_license_key') ) {
			$license_key = get_option('ctf_license_key');
		}

		$has_license_error = false;
		if (
			( isset( $ctf_license_data['license'] ) && 'expired' === $ctf_license_data['license'] ) ||
			( isset( $ctf_license_data['error'] ) && ( $ctf_license_data['error'] || 'expired' == $ctf_license_data['error'] ) )
		)  {
			$has_license_error = true;
		}

		$upgrade_url			= sprintf('https://smashballoon.com/pricing/twitter-feed?license_key=%s&upgrade=true&utm_campaign=twitter-pro&utm_source=settings&utm_medium=upgrade-license', $license_key);
		$usage_tracking_url 	= 'https://smashballoon.com/custom-twitter-feeds/usage-tracking/';
		$feed_issue_email_url 	= 'https://smashballoon.com/email-report-is-not-in-my-inbox/?twitter';


		// Extract only license keys and build array for extensions license keys

		$ctf_settings = array(
			'admin_url' 		=> admin_url(),
			'ajax_handler'		=> admin_url( 'admin-ajax.php' ),
			'nonce'             => wp_create_nonce( 'ctf_admin_nonce' ),
			'supportPageUrl'    => admin_url( 'admin.php?page=ctf-support' ),
			'builderUrl'		=> admin_url( 'admin.php?page=ctf-feed-builder' ),
			'links'				=> $this->get_links_with_utm(),
			'pluginItemName'	=> CTF_PRODUCT_NAME,
			'licenseType'		=> 'pro',
			'licenseKey'		=> $license_key,
			'licenseStatus'		=> $ctf_status,
			'licenseErrorMsg'	=> $licenseErrorMsg,
			'extensionsLicense' => array(),
			'extensionsLicenseKey' => array(),
			'hasError'			=> $has_license_error,
			'upgradeUrl'		=> $upgrade_url,
			'model'				=> $model,
			'feeds'				=> $feeds,
			'appCredentials'    => CTF_Feed_Builder::get_app_credentials( $ctf_options ),
			'connectAccountScreen'    => CTF_Feed_Builder::connect_account_secreen(),
			'appOAUTH'    => OAUTH_PROCESSOR_URL . admin_url( 'admin.php?page=ctf-settings' ),

			//'locales'			=> CTF_Settings::locales(),
			//'timezones'			=> CTF_Settings::timezones(),
			//'socialWallLinks'   => \TwitterFeed\Builder\CTF_Feed_Builder::get_social_wall_links(),
			'socialWallLinks'   => \TwitterFeed\Builder\CTF_Feed_Builder::get_social_wall_links(),
			'socialWallActivated' => is_plugin_active( 'social-wall/social-wall.php' ),
			'genericText'       => \TwitterFeed\Builder\CTF_Feed_Builder::get_generic_text(),
			'generalTab'		=> array(
				'licenseBox'	=> array(
					'title' => __( 'License Key', 'custom-twitter-feeds' ),
					'description' => __( 'Your license key provides access to updates and support', 'custom-twitter-feeds' ),
					'activeText' => __( 'Your <b>Twitter Feed Pro</b> license is Active!', 'custom-twitter-feeds' ),
					'inactiveText' => __( 'Your <b>Twitter Feed Pro</b> license is Inactive!', 'custom-twitter-feeds' ),
					'freeText'	=> __( 'Already purchased? Simply enter your license key below to activate Twitter Feed Pro.', 'custom-twitter-feeds'),
					'inactiveFieldPlaceholder' => __( 'Paste license key here', 'custom-twitter-feeds' ),
					'upgradeText1' => __( 'You are using the Lite version of the plugin–no license needed. Enjoy! 🙂 To unlock more features, consider <a href="'. $upgrade_url .'">Upgrading to Pro</a>.', 'custom-twitter-feeds' ),
					'upgradeText2' => __( 'As a valued user of our Lite plugin, you receive 50% OFF - automatically applied at checkout!', 'custom-twitter-feeds' ),
					'manageLicense' => __( 'Manage License', 'custom-twitter-feeds' ),
					'test' => __( 'Test Connection', 'custom-twitter-feeds' ),
					'recheckLicense' => __( 'Recheck license', 'custom-twitter-feeds' ),
					'licenseValid' => __( 'License valid', 'custom-twitter-feeds' ),
					'licenseExpired' => __( 'License expired', 'custom-twitter-feeds' ),
					'connectionSuccessful' => __( 'Connection successful', 'custom-twitter-feeds' ),
					'connectionFailed' => __( 'Connection failed', 'custom-twitter-feeds' ),
					'viewError' => __( 'View error', 'custom-twitter-feeds' ),
					'upgrade' => __( 'Upgrade', 'custom-twitter-feeds' ),
					'deactivate' => __( 'Deactivate', 'custom-twitter-feeds' ),
					'activate' => __( 'Activate', 'custom-twitter-feeds' ),
				),
				'manageAccount'	=> array(
					'title'	=> __( 'Connected Twitter Account', 'custom-twitter-feeds' ),
					'description'	=> __( 'This account is used to display home timeline, or fetch data from Twitter API for other timeline.<br/>Changing this will not affect Hashtag, Search or List Timelines, but will change Home and Mentions timelines.', 'custom-twitter-feeds' ),
					'button'	=> __( 'Change', 'custom-twitter-feeds' ),
					'buttonConnect'	=> __( 'Connect new Account', 'custom-twitter-feeds' ),
					'buttonConnectOwnApp'	=> __( 'Connect your Own App', 'custom-twitter-feeds' ),
					'titleApp'	=> __( 'Connected Twitter App', 'custom-twitter-feeds' ),
					'cKey'		=> __( 'Consumer Key', 'custom-twitter-feeds' ),
					'cSecret'	=> __( 'Consumer Secret', 'custom-twitter-feeds' ),
					'aToken'	=> __( 'Access Token', 'custom-twitter-feeds' ),
					'aTokenSecret'	=> __( 'Access Token Secret', 'custom-twitter-feeds' ),
				),
				'preserveBox'	=> array(
					'title'	=> __( 'Preserve settings if plugin is removed', 'custom-twitter-feeds' ),
					'description'	=> __( 'This will make sure that all of your feeds and settings are still saved even if the plugin is uninstalled', 'custom-twitter-feeds' ),
				),
				'importBox'		=> array(
					'title'	=> __( 'Import Feed Settings', 'custom-twitter-feeds' ),
					'description'	=> __( 'You will need a JSON file previously exported from the Twitter Feed Plugin', 'custom-twitter-feeds' ),
					'button'	=> __( 'Import', 'custom-twitter-feeds' ),
				),
				'exportBox'		=> array(
					'title'	=> __( 'Export Feed Settings', 'custom-twitter-feeds' ),
					'description'	=> __( 'Export settings for one or more of your feeds', 'custom-twitter-feeds' ),
					'button'	=> __( 'Export', 'custom-twitter-feeds' ),
				)
			),
			'feedsTab'			=> array(
				'localizationBox' => array(
					'title'	=> __( 'Localization', 'custom-twitter-feeds' ),
					'tooltip' => '<p>This controls the language of any predefined text strings provided by Twitter. For example, the descriptive text that accompanies some timeline posts (eg: Smash Balloon created an event) and the text in the \'Like Box\' widget. To find out how to translate the other text in the plugin see <a href="https://smashballoon.com/ctf-how-does-the-plugin-handle-text-and-language-translation/" target="_blank" rel="nofollow noopener">this FAQ</a>.</p>'
				),
				'timezoneBox' => array(
					'title'	=> __( 'Timezone', 'custom-twitter-feeds' )
				),
				/*
				'cachingBox' => array(
					'title'	=> __( 'Caching', 'custom-twitter-feeds' ),
					'cacheTimeUnits' => array(
						60	=> __( 'Minutes', 'custom-twitter-feeds' ),
						3600	=> __( 'Hours', 'custom-twitter-feeds' ),
						86400	=> __( 'Days', 'custom-twitter-feeds' )
					),
					'clearCache' => __( 'Clear All Caches', 'custom-twitter-feeds' )
				),
				*/
				'cachingBox'      => array(
					'title'                  => __( 'Caching', 'custom-twitter-feeds' ),
					'pageLoads'              => __( 'When the Page loads', 'custom-twitter-feeds' ),
					'inTheBackground'        => __( 'In the Background', 'custom-twitter-feeds' ),
					'cacheTypeOptions' => array(
						'background'	=> __( 'Background', 'custom-twitter-feeds' ),
						'page'	=> __( 'Page', 'custom-twitter-feeds' ),
					),
					'inTheBackgroundOptions' => array(
						'30mins'  => __( 'Every 30 minutes', 'custom-twitter-feeds' ),
						'1hour'   => __( 'Every hour', 'custom-twitter-feeds' ),
						'12hours' => __( 'Every 12 hours', 'custom-twitter-feeds' ),
						'24hours' => __( 'Every 24 hours', 'custom-twitter-feeds' ),
					),
					'cacheTimeUnits' => array(
						60	=> __( 'Minutes', 'custom-twitter-feeds' ),
						3600	=> __( 'Hours', 'custom-twitter-feeds' ),
						86400	=> __( 'Days', 'custom-twitter-feeds' )
					),
					'am'                     => __( 'AM', 'custom-twitter-feeds' ),
					'pm'                     => __( 'PM', 'custom-twitter-feeds' ),
					'clearCache'             => __( 'Clear All Caches', 'custom-twitter-feeds' ),
				),
				'gdprBox' => array(
					'title'	=> __( 'GDPR', 'custom-twitter-feeds' ),
					'automatic'	=> __( 'Automatic', 'custom-twitter-feeds' ),
					'yes'	=> __( 'Yes', 'custom-twitter-feeds' ),
					'no'	=> __( 'No', 'custom-twitter-feeds' ),
					'infoAuto'	=> $this->get_gdpr_auto_info(),
					'infoYes'	=> __( 'No requests will be made to third-party websites. To accommodate this, some features of the plugin will be limited.', 'custom-twitter-feeds' ),
					'infoNo'	=> __( 'The plugin will function as normal and load images and videos directly from Twitter', 'custom-twitter-feeds' ),
					'someTwitter' => __( 'Some Twitter Feed features will be limited for visitors to ensure GDPR compliance, until they give consent.', 'custom-twitter-feeds'),
					'whatLimited' => __( 'What will be limited?', 'custom-twitter-feeds'),
					'tooltip' => '<p><b>If set to “Yes”,</b> it prevents all images and videos from being loaded directly from Twitter’s servers (CDN) to prevent any requests to external websites in your browser. To accommodate this, some features of your plugin will be disabled or limited. </p>
                    <p><b>If set to “No”,</b> the plugin will still make some requests to load and display images and videos directly from Twitter.</p>
                    <p><b>If set to “Automatic”,</b> it will only load images and videos directly from Twitter if consent has been given by one of these integrated GDPR cookie Plugins.</p>
                    <p><a href="https://smashballoon.com/doc/custom-twitter-feeds-gdpr-compliance/?twitter" target="_blank" rel="nofollow noopener">Learn More</a></p>',
					'gdprTooltipFeatureInfo' => array(
						'headline' => __( 'Features that would be disabled or limited include: ', 'custom-twitter-feeds'),
						'features' => array(
							__( 'Only local images (not from Twitter\'s CDN) will be displayed in the feed.', 'custom-twitter-feeds'),
							__( 'Placeholder blank images will be displayed until images are available.', 'custom-twitter-feeds'),
							__( 'To view videos, visitors will click a link to view the video on Twitter.', 'custom-twitter-feeds'),
							__( 'Carousel posts will only show the first image in the lightbox.', 'custom-twitter-feeds'),
							__( 'The maximum image resolution will be 640 pixels wide in the lightbox.', 'custom-twitter-feeds'),
						)
					)
				),
				'customCSSBox' => array(
					'title'	=> __( 'Custom CSS', 'custom-twitter-feeds' ),
					'placeholder' => __( 'Enter any custom CSS here', 'custom-twitter-feeds' ),
				),
				'customJSBox' => array(
					'title'	=> __( 'Custom JS', 'custom-twitter-feeds' ),
					'placeholder' => __( 'Enter any custom JS here', 'custom-twitter-feeds' ),
				)
			),
			'translationTab' => array(
				'title'	=> __( 'Custom Text/Translate', 'custom-twitter-feeds' ),
				'description'	=> __( 'Enter custom text for the words below, or translate it into the language you would like to use.', 'custom-twitter-feeds' ),
				'table'	=> array(
					'originalText' => __( 'Original Text', 'custom-twitter-feeds' ),
					'customText' => __( 'Custom text/translation', 'custom-twitter-feeds' ),
					'context' => __( 'Context', 'custom-twitter-feeds' ),
					'tweetText' => __( 'Tweet Text', 'custom-twitter-feeds' ),
					'retweeted' => __( 'Retweeted', 'custom-twitter-feeds' ),
					'retweetedCtnx' => __( 'Used for showing retweets', 'custom-twitter-feeds' ),
					'inReplyTo' => __( 'In Reply To', 'custom-twitter-feeds' ),
					'inReplyToCtnx' => __( 'Used for showing replies', 'custom-twitter-feeds' ),
					'loadMore' => __( 'Load More', 'custom-twitter-feeds' ),
					'loadMoreCtnx' => __( 'Used in the button that loads more posts', 'custom-twitter-feeds' ),

					'date' => __( 'Date', 'custom-twitter-feeds' ),
					'minutes' => __( 'Minutes', 'custom-twitter-feeds' ),
					'hours' => __( 'Hours', 'custom-twitter-feeds' ),
					'now' => __( 'Now', 'custom-twitter-feeds' ),
					'usedinTimeline' => __( 'Used for tweet timeline', 'custom-twitter-feeds' ),

				)
			),
			'advancedTab'	=> array(
				'optimizeBox' => array(
					'title' => __( 'Optimize Images', 'custom-twitter-feeds' ),
					'helpText' => __( 'This will create multiple local copies of images in different sizes. The plugin then displays the smallest version based on the size of the feed.', 'custom-twitter-feeds' ),
					'reset' => __( 'Reset', 'custom-twitter-feeds' ),
				),
				'persistentCacheBox' => array(
					'title' => __( 'Persistent Cache', 'custom-twitter-feeds' ),
					'helpText' => __( 'This makes all Search and Hashtag feeds have a permanent cache saved in the database up to 150 tweets. Tweets will be available for the feed even after the 7 day limit however numbers of retweets and likes will not update.', 'custom-twitter-feeds' ),
					'reset' => __( 'Reset', 'custom-twitter-feeds' ),
				),
				'twitterCardCacheBox' => array(
					'title' => __( 'Twitter Card Cache', 'custom-twitter-feeds' ),
					'helpText' => __( 'Twitter Cards are rich text links that replace links to other websites when information for the card is available.', 'custom-twitter-feeds' ),
					'reset' => __( 'Reset', 'custom-twitter-feeds' ),
				),
				'ajaxThemeBox' => array(
					'title' => __( 'AJAX theme loading fix', 'custom-twitter-feeds' ),
					'helpText' => '',
				),
				'jsHeaderBox' => array(
					'title' => __( 'Enqueue JS in header fix', 'custom-twitter-feeds' ),
					'helpText' => __( 'Add the Javascript file for the plugin in the header instead of the footer.', 'custom-twitter-feeds' ),
				),
				'templatesBox' => array(
					'title' => __( 'Custom Templates', 'custom-twitter-feeds' ),
					'helpText' => sprintf( __( 'The default HTML for the feed can be replaced with custom templates added to your theme\'s folder. Enable this setting to use these templates. See %sthis guide%s.', 'custom-twitter-feeds' ), '<a href="https://smashballoon.com/doc/twitter-custom-templates/?twitter" target="_blank">', '</a>' ),
				),
				'creditbox' => array(
					'title' => __( 'Show Credit Link', 'custom-twitter-feeds' ),
					'helpText' => __( 'Display a link at the bottom of the feed to the Smash Balloon website.', 'custom-twitter-feeds' ),
				),
				'resbox' => array(
					'title' => __( 'Auto-detect Image Resolution', 'custom-twitter-feeds' ),
					'helpText' => __( 'The resolution of the images in your feed will be set based on their width when the page loads. Disabling this will load all images in full resolution.', 'custom-twitter-feeds' ),
				),
				'intentBox' => array(
					'title' => __( 'Twitter Intent JS', 'custom-twitter-feeds' ),
					'helpText' => __( 'This allows visitors of your site to reply to, retweet, and like tweets without leaving your site. ', 'custom-twitter-feeds' ),
				),
				'requestMethodBox' => array(
					'title' => __( 'Request Method', 'custom-twitter-feeds' ),
					'helpText' => __( 'Explicitly set the request method. You would only want to change this if you are unable to connect to the Twitter API.', 'custom-twitter-feeds' ),
					'options' => array(
						'auto' => __( 'Auto', 'custom-twitter-feeds' ),
						'curl' => __( 'cURL', 'custom-twitter-feeds' ),
						'file_get_contents' => __( 'file_get_contents()', 'custom-twitter-feeds' ),
						'wp_http' => __( 'WP_Http', 'custom-twitter-feeds' )
					)
				),
				'clearCacheBox' => array(
					'title' => __( 'Force Cache to clear on interval', 'custom-twitter-feeds' ),
					'helpText' => '',
				),

				'sslonlyBox' => array(
					'title' => __( 'HTTPs Images only', 'custom-twitter-feeds' ),
					'helpText' => __( 'This will fix mixed-content warnings when Twitter card links are non-https. After enabling, clear your Twitter cards cache.', 'custom-twitter-feeds' ),
				),
				'curlcardsBox' => array(
					'title' => __( 'Use cURL for Retrieval', 'custom-twitter-feeds' ),
					'helpText' => __( 'This will fix mixed-content warnings when Twitter card links are non-https. After enabling, clear your Twitter cards using the button above.', 'custom-twitter-feeds' ),
				),


				'dpaClear' => array(
					'title' => __( 'Manage Data', 'custom-twitter-feeds' ),
					'helpText' => __( 'Warning: Clicking this button will permanently delete all Twitter data, including all connected accounts, cached posts, and stored images.', 'custom-twitter-feeds' ),
					'clear' => __( 'Delete all Platform Data', 'custom-twitter-feeds' ),
				),
			),
			'dialogBoxPopupScreen'  => array(
				'deleteSource' => array(
					'heading' =>  __( 'Delete "#"?', 'custom-twitter-feeds' ),
					'description' => __( 'This source is being used in a feed on your site. If you delete this source then new posts can no longer be retrieved for these feeds.', 'custom-twitter-feeds' ),
				),
				'deleteAccount' => array(
					'heading' =>  __( 'Delete Account?', 'custom-twitter-feeds' ),
					'description' => __( 'If you delete this account then new posts can no longer be retrieved in your feeds.', 'custom-twitter-feeds' ),
				),
				'deleteApp' => array(
					'heading' =>  __( 'Delete App?', 'custom-twitter-feeds' ),
					'description' => __( 'Are you sure you want to delete this app.', 'custom-twitter-feeds' ),
				),
			),

			'selectSourceScreen' => \TwitterFeed\Builder\CTF_Feed_Builder::select_source_screen_text(),

			'nextCheck'	=> $this->get_cron_next_check(),
			'loaderSVG' => '<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve"><path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h6.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"/></path></svg>',
			'checkmarkSVG' => '<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>',
			'uploadSVG' => '<svg class="btn-icon" width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M0.166748 14.6667H11.8334V13H0.166748V14.6667ZM0.166748 6.33333H3.50008V11.3333H8.50008V6.33333H11.8334L6.00008 0.5L0.166748 6.33333Z" fill="#141B38"/></svg>',
			'exportSVG' => '<svg class="btn-icon" width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M0.166748 14.6667H11.8334V13H0.166748V14.6667ZM11.8334 5.5H8.50008V0.5H3.50008V5.5H0.166748L6.00008 11.3333L11.8334 5.5Z" fill="#141B38"/></svg>',
			'reloadSVG' => '<svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M15.8335 3.66667L12.5002 7H15.0002C15.0002 8.32608 14.4734 9.59785 13.5357 10.5355C12.598 11.4732 11.3262 12 10.0002 12C9.16683 12 8.3585 11.7917 7.66683 11.4167L6.45016 12.6333C7.51107 13.3085 8.74261 13.667 10.0002 13.6667C11.7683 13.6667 13.464 12.9643 14.7142 11.714C15.9644 10.4638 16.6668 8.76811 16.6668 7H19.1668L15.8335 3.66667ZM5.00016 7C5.00016 5.67392 5.52695 4.40215 6.46463 3.46447C7.40231 2.52678 8.67408 2 10.0002 2C10.8335 2 11.6418 2.20833 12.3335 2.58333L13.5502 1.36667C12.4893 0.691461 11.2577 0.332984 10.0002 0.333334C8.23205 0.333334 6.53636 1.03571 5.28612 2.28596C6.03587 3.5362 3.3335 5.23189 3.3335 7H0.833496L4.16683 10.3333L7.50016 7" fill="#141B38"/></svg>',
			'tooltipHelpSvg' => '<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.1665 8H10.8332V6.33333H9.1665V8ZM9.99984 17.1667C6.32484 17.1667 3.33317 14.175 3.33317 10.5C3.33317 6.825 6.32484 3.83333 9.99984 3.83333C13.6748 3.83333 16.6665 6.825 16.6665 10.5C16.6665 14.175 13.6748 17.1667 9.99984 17.1667ZM9.99984 2.16666C8.90549 2.16666 7.82186 2.38221 6.81081 2.801C5.79976 3.21979 4.8811 3.83362 4.10728 4.60744C2.54448 6.17024 1.6665 8.28986 1.6665 10.5C1.6665 12.7101 2.54448 14.8298 4.10728 16.3926C4.8811 17.1664 5.79976 17.7802 6.81081 18.199C7.82186 18.6178 8.90549 18.8333 9.99984 18.8333C12.21 18.8333 14.3296 17.9554 15.8924 16.3926C17.4552 14.8298 18.3332 12.7101 18.3332 10.5C18.3332 9.40565 18.1176 8.32202 17.6988 7.31097C17.28 6.29992 16.6662 5.38126 15.8924 4.60744C15.1186 3.83362 14.1999 3.21979 13.1889 2.801C12.1778 2.38221 11.0942 2.16666 9.99984 2.16666ZM9.1665 14.6667H10.8332V9.66666H9.1665V14.6667Z" fill="#434960"/></svg>',
			'svgIcons' => \TwitterFeed\Builder\CTF_Feed_Builder::builder_svg_icons()
		);

		$maybe_new_account = CTF_Feed_Builder::connect_new_account( $_GET );
		if( $maybe_new_account !== false ){
			$ctf_settings['newAccountData'] =  $maybe_new_account;
			$ctf_options = get_option('ctf_options', array());
		}

		if( isset( $ctf_options['access_token'] )  && isset( $ctf_options['access_token_secret'] ) && !empty( $ctf_options['access_token'] )  && !empty( $ctf_options['access_token_secret'] )){
			//Check if No Account Details are added => Then make API call to get them!
			if( !isset( $ctf_options['account_handle'] )  || !isset( $ctf_options['account_avatar'] ) || empty( $ctf_options['account_handle'] )  || empty( $ctf_options['account_avatar'] )){
				$auth = [
					'access_token'  => $ctf_options['access_token'],
					'access_token_secret' => $ctf_options['access_token_secret'],
				];
				$details = CTF_Feed_Builder::get_account_info( $auth );
				if( !isset( $details['error'] ) ){
					$ctf_options['account_handle'] 		= $details['account_handle'];
					$ctf_options['account_avatar'] 		= $details['account_avatar'];
					update_option( 'ctf_options', $ctf_options );
				}
			}

			$ctf_settings['accountDetails'] = [
				'app_name' 				=> isset($ctf_options['app_name']) ? $ctf_options['app_name'] : '' ,
				'consumer_key' 			=> isset($ctf_options['consumer_key']) ? $ctf_options['consumer_key'] : '' ,
				'consumer_secret' 		=> isset($ctf_options['consumer_secret']) ? $ctf_options['consumer_secret'] : '' ,
				'access_token' 			=> isset($ctf_options['access_token']) ? $ctf_options['access_token'] : '' ,
				'access_token_secret' 	=> isset($ctf_options['access_token_secret']) ? $ctf_options['access_token_secret'] : '' ,
				'account_handle' 		=> isset($ctf_options['account_handle']) ? $ctf_options['account_handle'] : '' ,
				'account_avatar' 		=> isset($ctf_options['account_avatar']) ? $ctf_options['account_avatar'] : ''
			];
		}


		wp_localize_script(
			'settings-app',
			'ctf_settings',
			$ctf_settings
		);
    }

	/**
	 * Get Extensions License Information
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	public function get_extensions_license() {
		return;

	}

	/**
	 * Get Links with UTM
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_links_with_utm() {
		$license_key = null;
		if ( get_option('ctf_license_key') ) {
			$license_key = get_option('ctf_license_key');
		}
		$all_access_bundle_popup = sprintf('https://smashballoon.com/all-access/?license_key=%s&upgrade=true&utm_campaign=twitter-pro&utm_source=balloon&utm_medium=all-access', $license_key);

		return array(
			'manageLicense' => 'https://smashballoon.com/account/downloads/?utm_campaign=twitter-pro&utm_source=settings&utm_medium=manage-license',
			'popup' => array(
				'allAccessBundle' => $all_access_bundle_popup,
				'fbProfile' => 'https://www.instagram.com/SmashBalloon/',
				'twitterProfile' => 'https://twitter.com/smashballoon',
			),
		);
	}

	/**
	 * The Settings Data
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	public function get_settings_data() {
		$ctf_settings = wp_parse_args( get_option( 'ctf_options' ), $this->default_settings_options() );
		$cachetype 			        = $ctf_settings['ctf_caching_type'] ;
		$cache_time_unit 			= $ctf_settings['cache_time_unit'] ;
    	$cache_time 				= $ctf_settings['cache_time'];
    	$ctf_cache_cron_interval 	= $ctf_settings['ctf_cache_cron_interval'];
		$ctf_cache_cron_time     	= $ctf_settings['ctf_cache_cron_time'];
		$ctf_cache_cron_am_pm   	= $ctf_settings['ctf_cache_cron_am_pm'];

		$usage_tracking = get_option( 'ctf_usage_tracking', array( 'last_send' => 0, 'enabled' => \ctf_is_pro_version() ) );
		$ctf_ajax = $ctf_settings['ajax_theme'];
		$active_gdpr_plugin = CTF_GDPR_Integrations::gdpr_plugins_active();
		$ctf_preserve_settings = $ctf_settings['preserve_settings'];

		return array(
			'general' => array(
				'preserveSettings' => $ctf_preserve_settings
			),
			'feeds'	=> array(
				'cachingType'  => $cachetype,
				'cronInterval' => $ctf_cache_cron_interval,
				'cronTime'     => $ctf_cache_cron_time,
				'cronAmPm'     => $ctf_cache_cron_am_pm,

				'cacheTimeUnit'		=> $cache_time_unit,
				'cacheTime'		=> $cache_time,
				'gdpr'				=> $ctf_settings['gdpr'],
				'gdprPlugin'		=> $active_gdpr_plugin,
				'customCSS'			=> isset( $ctf_settings['custom_css'] ) ? stripslashes( $ctf_settings['custom_css'] ) : '',
				'customJS'			=> isset( $ctf_settings['custom_js'] ) ? stripslashes( $ctf_settings['custom_js'] ) : '',
			),
			'translation' => array(
				'retweetedtext' => $ctf_settings['retweetedtext'],
				'inreplytotext' => $ctf_settings['inreplytotext'],
				'buttontext' => $ctf_settings['buttontext'],
				'minutestext' => $ctf_settings['minutestext'],
				'hourstext' => $ctf_settings['hourstext'],
				'nowtext' => $ctf_settings['nowtext'],
			),
			'advanced' => array(
				'resizing' => $ctf_settings['resizing'],
				'usage_tracking' => $usage_tracking['enabled'],
				'resizing' => $ctf_settings['resizing'],
				'persistentcache' => $ctf_settings['persistentcache'],
				'ajax_theme' => $ctf_settings['ajax_theme'],
				'headenqueue' => $ctf_settings['headenqueue'],
				'customtemplates' => $ctf_settings['customtemplates'],
				'creditctf' => $ctf_settings['creditctf'],
				'usagetracking' => $ctf_settings['usagetracking'],
				'autores' => $ctf_settings['autores'],
				'enableintents' => !$ctf_settings['disableintents'],
				'request_method' => $ctf_settings['request_method'],
				'cron_cache_clear' => $ctf_settings['cron_cache_clear'],
				'sslonly' => $ctf_settings['sslonly'],
				'curlcards' => $ctf_settings['curlcards']
			)
		);
	}

	/**
	 * Return the default settings options for ctf_style_settings option
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	public function default_settings_options() {
		return [
			'preserve_settings' => '',
			'cache_time' => 1,
			'cache_time_unit' => '3600',
			'gdpr'      => 'auto',
			'ctf_caching_type'                  => 'background',
			'ctf_cache_cron_interval'           => '12hours',
			'ctf_cache_cron_time'               => '1',
			'ctf_cache_cron_am_pm'              => 'am',

			//Translation Goes Here

			//----------
			'resizing' => true,
			'persistentcache' => true,
			'ajax_theme' => false,
			'headenqueue' => false,
			'customtemplates' => false,
			'creditctf' => false,
			'usagetracking' => true,
			'autores' => false,
			'disableintents' => false,
			'request_method' => 'auto',
			'cron_cache_clear' => 'unset',
			'sslonly' => false,
			'curlcards' => true,
			'retweetedtext' => 'Retweeted',
			'buttontext' => 'Load More',
			'inreplytotext' => 'In Reply To',
			'minutestext' => 'Minutes',
			'hourstext' => 'Hours',
			'nowtext' => 'Now',

		];

	}

	/**
	 * Get GDPR Automatic state information
	 *
	 * @since 2.0
	 *
	 * @return string $output
	 */
	public function get_gdpr_auto_info() {
		$gdpr_doc_url 			= 'https://smashballoon.com/doc/custom-twitter-feeds-gdpr-compliance/?twitter';
		$output = '';
		$active_gdpr_plugin = CTF_GDPR_Integrations::gdpr_plugins_active();
		if ( $active_gdpr_plugin ) {
			$output = $active_gdpr_plugin;
		} else {
			$output = __( 'No GDPR consent plugin detected. Install a compatible <a href="'. $gdpr_doc_url .'" target="_blank" rel="nofollow noopener">GDPR consent plugin</a>, or manually enable the setting to display a GDPR compliant version of the feed to all visitors.', 'custom-twitter-feeds' );
		}
		return $output;
	}

	/**
	 * SBI Get cron next check time
	 *
	 * @since 2.0
	 *
	 * @return string $output
	 */
	public function get_cron_next_check() {
		$output = '';

		if ( wp_next_scheduled( 'ctf_feed_update' ) ) {
			$time_format = get_option( 'time_format' );
			if ( ! $time_format ) {
				$time_format = 'g:i a';
			}
			//
			$schedule = wp_get_schedule( 'ctf_feed_update' );
			if ( $schedule === '30mins' ) {
				$schedule = __( 'every 30 minutes', 'custom-twitter-feeds' );
			}
			if ( $schedule === 'twicedaily' ) {
				$schedule = __( 'every 12 hours', 'custom-twitter-feeds' );
			}
			$ctf_next_cron_event = wp_next_scheduled( 'ctf_feed_update' );
			$output              = '<strong>' . __( 'Next check', 'custom-twitter-feeds' ) . ': ' . date( $time_format, $ctf_next_cron_event + ctf_get_utc_offset() ) . ' (' . $schedule . ')</strong> - ' . __( 'Note: Clicking "Clear All Caches" will reset this schedule.', 'custom-twitter-feeds' );
		} else {
			$output = __( 'Nothing currently scheduled', 'custom-twitter-feeds' );
		}

		return $output;



	}

   	/**
	 * Settings Page View Template
	 *
	 * @since 2.0
	 */
	public function global_settings(){
		return \TwitterFeed\Admin\CTF_View::render( 'settings.index' );
	}

}

<?php
/**
 * Handles license server endpoint selection and health checks.
 *
 * @link       https://searchandfilter.com
 * @since      3.0.0
 *
 * @package    Search_Filter_Pro
 * @subpackage Search_Filter_Pro/Core
 */


// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles license server availability checks and endpoint selection.
 */
class Search_Filter_Admin_License_Server {

	/**
	 * License server endpoints
	 */
	const SERVER_ENDPOINTS = array(
		'license' => 'https://license.searchandfilter.com',
		'main'    => 'https://searchandfilter.com',
	);

	/**
	 * The cron hook name.
	 */
	const CRON_HOOK = 'search-filter-pro/core/license-server/health-check';

	/**
	 * The cron interval name.
	 */
	const CRON_INTERVAL_NAME = 'search_filter_4days';

	/**
	 * The cron interval.
	 */
	const CRON_INTERVAL = DAY_IN_SECONDS * 4;

	/**
	 * The option name for storing the server test results.
	 */
	const OPTION_TEST_RESULTS = 'search_filter_license_server_test';

	/**
	 * Initialize the license server checks.
	 */
	public static function init() {

		// Setup CRON job for checking for expired items.
		add_action( 'init', array( __CLASS__, 'validate_cron_schedule' ) );
	   
		// Create the schedule
		add_filter( 'cron_schedules', array( __CLASS__, 'schedules' ) );
		
		// Add the cron job action
		add_action( self::CRON_HOOK, array( __CLASS__, 'schedule_check_server_health' ) );

		// Add notices when there are errors with connecting to the servers.
		add_action( 'init', array( __CLASS__, 'add_notices' ) );
	}

	/**
	 * Get the preferred server endpoint.
	 *
	 * @return string The server endpoint URL
	 */
	public static function get_endpoint( $preferred_server = 'license' ) {
		return self::SERVER_ENDPOINTS[ $preferred_server ];
	}

	/**
	 * Setup the interval for the cron job.
	 *
	 * @param array $schedules The existing cron schedules.
	 * @return array Modified cron schedules.
	 */
	public static function schedules( $schedules ) {
		if ( ! isset( $schedules[ self::CRON_INTERVAL_NAME ] ) ) {
			$schedules[ self::CRON_INTERVAL_NAME ] = array(
				'interval' => self::CRON_INTERVAL,
				'display'  => __( 'Once every 4 days', 'search-filter-pro' ),
			);
		}
		return $schedules;
	}

	/**
	 * Activate the cron job.
	 */
	public static function activate() {
		if ( ! wp_next_scheduled( self::CRON_HOOK ) ) {
			wp_schedule_event( time(), self::CRON_INTERVAL_NAME, self::CRON_HOOK );
		}
	}

	/**
	 * Deactivate the cron job.
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( self::CRON_HOOK );
	}

	
	/**
	 * Hook the task into shutdown so we don't affect the request.
	 */
	public static function schedule_check_server_health() {
		// Hook the task into shutdown so we don't affect the request.
		add_action( 'shutdown', array( __CLASS__, 'check_server_health' ) );
	}

	/**
	 * Check the health of both servers and update the preferred endpoint.
	 */
	public static function check_server_health() {

		$license_server_healthy = self::refresh_health();
		
		$result = array(
			'license' => $license_server_healthy,
		);

		// Store the results in the options table.
		update_option( self::OPTION_TEST_RESULTS, $result );

		return $license_server_healthy;
	}

	private static function get_php_version() {
		if ( function_exists( 'phpversion' ) ) {
			return phpversion();
		} else if ( defined( 'PHP_VERSION' ) ) {
			return PHP_VERSION;
		}
		return '';
	}
	public static function get_site_info() {
		$site_meta_data = array(
			'integrations' => self::get_enabled_integrations(),
			'version' => SEARCH_FILTER_VERSION,
			'php_version' => self::get_php_version(),
			'wp_version' => get_bloginfo( 'version' ),
			'site_language' => get_bloginfo( 'language' ),
			'is_multisite' => is_multisite(),
		);
		return $site_meta_data;
	}
	/**
	 * Refresh health.
	 *
	 * @param string $endpoint The endpoint URL to test.
	 */
	public static function refresh_health( $preferred_server = 'license' ) {

		$api_params = array(
			'edd_action'   => 'check_license',
			'item_id'      => 615,
			'url'          => home_url(),
			'license'      => '',
			'info'         => self::get_site_info(),
		);
		
		$license_data = self::get_license_data();
		if ( ! empty( $license_data['license'] ) ) {
			$api_params['license'] = $license_data['license'];
		}
		
		$endpoint = self::get_endpoint( $preferred_server );
		
		// Call the custom API.
		$response = wp_remote_post(
			$endpoint,
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body' => $api_params,
			)
		);

		$is_healthy = ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200;

		if ( is_wp_error( $response ) ) {
			return $is_healthy;
		}

		$body = wp_remote_retrieve_body( $response );
		$request_response = json_decode( $body, true );

		if ( ! $request_response ) {
			return $is_healthy;
		}

		if ( ! isset( $request_response['success'] ) ) {
			return $is_healthy;
		}

		if ( ! isset( $request_response['license'] ) ) {
			return $is_healthy;
		}

		$expires = $request_response['expires'];
		self::update_license_data( 
			array(
				'expires' => $expires,
				'status'  => $request_response['license'],
				'error'   => isset( $request_response['error'] ) ? $request_response['error'] : '',
			)
		);

		return $is_healthy;
	}
	/**
	 * Get the license data from the options table.
	 *
	 * @since 3.0.0
	 *
	 * @return array    The license data.
	 */
	public static function get_license_data() {

		$default_license_data = array(
			'status'       => '',
			'expires'      => '',
			'license'      => '',
			'error'        => '',
			'errorMessage' => '',
		);

		$license_data = array(
            'status'       => get_option( 'search_filter_license_status' ),
			'expires'      => get_option( 'search_filter_license_expires' ),
			'license'      => get_option( 'search_filter_license_key' ),
        );

		if ( $license_data ) {
			$license_data = wp_parse_args( $license_data, $default_license_data );
		} else {
			$license_data = $default_license_data;
		}

		return $license_data;
	}

	public static function update_license_data( $new_license_data ) {
		$existing_data = self::get_license_data();
		$updated_license_data = wp_parse_args( $new_license_data, $existing_data );
		update_option( 'search_filter_license_status', $updated_license_data['status'] );
		update_option( 'search_filter_license_expires', $updated_license_data['expires'] );
		update_option( 'search_filter_license_error', $updated_license_data['error'] );
	}
	/**
	 * Validate the cron job.
	 *
	 * @since 3.0.0
	 */
	public static function validate_cron_schedule() {
		
		$next_event = wp_get_scheduled_event( self::CRON_HOOK );
		if ( ! $next_event ) {
			wp_schedule_event( time(), self::CRON_INTERVAL_NAME, self::CRON_HOOK );
			return;
		}

		$time_diff      = $next_event->timestamp - time();
		$time_5_minutes = 5 * MINUTE_IN_SECONDS;

		if ( $time_diff < 0 && -$time_diff > $time_5_minutes ) {
			// This means our scheduled event has been missed by more then 5 minutes.
			// So lets run manually and reschedule.
			self::schedule_check_server_health();
			wp_clear_scheduled_hook( self::CRON_HOOK );
			wp_schedule_event( time(), self::CRON_INTERVAL_NAME, self::CRON_HOOK );
		}
	}

	/**
	 * Add error notices if the license server cannot be reached.
	 */
	public static function add_notices() {
		
		// Show a notice to the user if there are errors with both servers.
		$test_result = get_option( self::OPTION_TEST_RESULTS, array(
            'license' => false,
        ) );

		// If the options are empty, then we don't have any test results yet.
		if ( empty( $test_result ) ) {
			return;
		}

		// If the license server is healthy, then we don't need to show a notice.
		if ( $test_result['license'] === false ) {
			// Add WP notice, not S&F notice:
			add_action( 'admin_notices', array( __CLASS__, 'display_wp_admin_connection_error_notice' ) );
		}
	}

	public static function display_wp_admin_connection_error_notice() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$notice_string = sprintf(
			// translators: %s: Support URL.
			__( 'Unable to connect to Search & Filter update servers. Please check your internet connection or firewall settings. <a href="%s">Test your connection settings</a> or <a href="%s" target="_blank">contact support for help</a>.', 'search-filter-pro' ),
			admin_url( 'edit.php?post_type=search-filter-widget&page=search-filter-licence-settings&action=test-connection' ),
			'https://searchandfilter.com/account/support/'
		);

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $notice_string ) );

	}

	public static function get_enabled_integrations() {
		$integrations = array();

		// Relevanssi
		global $relevanssi_variables;
		if ( ! empty( $relevanssi_variables ) ) {
			$integrations[] = 'relevanssi';
		}
		// WooCommerce
		if ( class_exists( 'WooCommerce' ) ) {
			$integrations[] = 'woocommerce';
		}
		// Elementor
		if ( did_action( 'elementor/loaded' ) ) {
			$integrations[] = 'elementor';
		}
		// Dynamic Content for Elementor
		if ( class_exists( 'DynamicContentForElementor\Plugin' ) ) {
			$integrations[] = 'dynamiccontent';
		}
		// Polylang
		if ( defined( 'POLYLANG_VERSION' ) ) {
			$integrations[] = 'polylang';
		}
		// WPML
		if ( has_filter( 'wpml_object_id' ) || function_exists( 'icl_object_id' ) ) {
			$integrations[] = 'wpml';
		}
		// ACF
		if (  class_exists( 'ACF' ) ) {
			$integrations[] = 'acf';
		}
		// Beaver Builder
		if ( defined( 'FL_BUILDER_VERSION' ) ) {
			$integrations[] = 'beaverbuilder';
		}
		// Easy Digital Downloads
		if ( function_exists( '\EDD' ) ) {
			$integrations[] = 'edd';
		}
		// Divi
		if ( defined( 'ET_BUILDER_VERSION' ) ) {
			$integrations[] = 'divi';
		}
		// WP Bakery Page Builder
		if ( defined( 'WPB_VC_VERSION' ) ) {
			$integrations[] = 'wpbpb';
		}
		return $integrations;
	}
}


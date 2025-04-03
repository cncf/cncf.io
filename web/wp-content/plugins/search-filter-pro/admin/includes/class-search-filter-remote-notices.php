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
class Search_Filter_Remote_Notices {

	/**
	 * The cron hook name.
	 */
	const CRON_HOOK = 'search-filter-pro/core/notices/fetch';

	/**
	 * The cron interval name.
	 */
	const CRON_INTERVAL_NAME = 'search_filter_3days';

	/**
	 * The cron interval.
	 */
	const CRON_INTERVAL = DAY_IN_SECONDS * 7;

	/**
	 * The option name for storing the server test results.
	 */
	const OPTION_NOTICES = 'search_filter_remote_notices';
	const OPTION_NOTICES_DISMISSED = 'search_filter_notices_dismissed';

	/**
	 * Initialize the remote notices.
	 */
	public static function init() {

		// Setup CRON job for checking for expired items.
		add_action( 'init', array( __CLASS__, 'validate_cron_schedule' ) );
	   
		// Create the schedule
		add_filter( 'cron_schedules', array( __CLASS__, 'schedules' ) );
		
		// Add the cron job action
		add_action( self::CRON_HOOK, array( __CLASS__, 'schedule_fetch' ) );
		
		// Add notices.
		add_action( 'admin_notices', array( __CLASS__, 'display_wp_admin_remote_notice' ) );
		add_action( 'admin_footer', array( __CLASS__, 'handle_dismiss_notice_js' ) );
		// Handle the ajax action.
		add_action( 'wp_ajax_search_filter_dismiss_notice', array( __CLASS__, 'handle_dismiss_notice' ) );
		add_action( 'wp_ajax_nopriv_search_filter_dismiss_notice', array( __CLASS__, 'handle_dismiss_notice' ) );
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
				'display'  => __( 'Once every 3 days', 'search-filter-pro' ),
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
	public static function schedule_fetch() {
		// Hook the task into shutdown so we don't affect the request.
		add_action( 'shutdown', array( __CLASS__, 'fetch' ) );
	}

	/**
	 * Refresh health.
	 *
	 * @param string $endpoint The endpoint URL to test.
	 */
	public static function fetch() {

		$api_params = array(
			'edd_action'   => 'get_notices',
			'item_id'  => 526297,
			'url'      => home_url(),
			'license'  => '',
		);
		
		$license_data = Search_Filter_Admin_License_Server::get_license_data();
		if ( ! empty( $license_data['license'] ) ) {
			$api_params['license'] = $license_data['license'];
		}
		
		$endpoint = Search_Filter_Admin_License_Server::get_endpoint();
		
		// Call the custom API.
		$response = wp_remote_post(
			$endpoint,
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body' => $api_params,
			)
		);

		if ( is_wp_error( $response ) ) {
			return;
		}

		$body = wp_remote_retrieve_body( $response );
		$code = wp_remote_retrieve_response_code( $response );
	
		if ( $code < 200 || $code >= 300 ) {
			return;
		}

		$notice_response = json_decode( $body, true );

		// No message broadcasted.
		if ( empty( $notice_response ) ) {
			update_option( self::OPTION_NOTICES, array() );
			return;
		}

		// Validate notice before saving.
        if ( ! self::validate_notice( $notice_response ) ) {
            return;
        }
        // Sanitize each $key and $value in the $notice_response array.
        foreach( $notice_response as $key => $value ) {
			if ( is_bool( $value ) ) {
				$notice_response[ sanitize_text_field( $key ) ] = (bool) $value;
			} else {
				$notice_response[ sanitize_text_field( $key ) ] = sanitize_text_field( $value );
			}
        }
		update_option( self::OPTION_NOTICES, $notice_response );
		return;
	}

    private static function validate_notice( $notice ) {
        if ( ! is_array( $notice ) ) {
            return false;
        }

		$allowed_keys = array( 'id', 'message', 'type', 'actionText', 'actionLink', 'dismissible' );

		$received_keys = array_keys( $notice );
		// Don't allow extra keys.
		foreach( $received_keys as $key ) {
			if ( ! in_array( $key, $allowed_keys ) ) {
				return false;
			}
		}

		// Ensure at least id, message and type are set.
        if ( ! isset( $notice['id'] ) ) {
            return false;
        }
        
        if ( ! isset( $notice['message'] ) ) {
            return false;
        }

        if ( ! isset( $notice['type'] ) ) {
            return false;
        }

        return $notice;
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
			self::schedule_fetch();
			wp_clear_scheduled_hook( self::CRON_HOOK );
			wp_schedule_event( time(), self::CRON_INTERVAL_NAME, self::CRON_HOOK );
		}
	}

	/**
	 * Add error notices if the license server cannot be reached.
	 */
	public static function display_wp_admin_remote_notice() {
		
		$remote_notices = get_option( self::OPTION_NOTICES );
		if ( empty( $remote_notices ) ) {
			return;
		}

		if ( ! self::validate_notice( $remote_notices ) ) {
			return;
		}

		$dismissed_notices = self::get_dismissed_notices();
		$notice_id = 'search-filter-remote-notice-' . sanitize_key( $remote_notices['id'] );
		if ( in_array( $notice_id, $dismissed_notices, true ) ) {
			return;
		}
		
		$notice_string = wp_kses_post( $remote_notices['message'] );
		$dismissible = isset( $remote_notices['dismissible'] ) ? $remote_notices['dismissible'] : true;
		$notice_action = '';

		if ( isset( $remote_notices['actionText'], $remote_notices['actionLink'] ) ) {
			$notice_action = sprintf(
				' <a href="%s" class="button button-secondary">%s</a>',
				esc_url( $remote_notices['actionLink'] ),
				esc_html( $remote_notices['actionText'], 'search-filter-pro' )
			);
		}

		$type = isset( $remote_notices['type'] ) ? $remote_notices['type'] : 'info';
		// Add notices when there are errors with connecting to the servers.

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$notice_string = $notice_string . $notice_action;
		$notice_class = sanitize_html_class( 'notice-' . $type );
		if ( $dismissible ) {
			$notice_class = $notice_class . ' is-dismissible';
		}
		

		wp_admin_notice(
			wp_kses_post( $notice_string ),
			array(
				'type' => $type,
				'dismissible' => $dismissible,
				'additional_classes' => array( 'search-filter-pro-notice' ),
				'attributes' => array( 'data-notice-id' => $notice_id )
			)
		);
	}

	public static function get_dismissed_notices() {
		$dismissed_notices = get_option( self::OPTION_NOTICES_DISMISSED );
		if ( ! is_array( $dismissed_notices ) ) {
			$dismissed_notices = array();
		}
		return $dismissed_notices;
	}
	public static function handle_dismiss_notice() {
		if ( ! isset( $_GET['action'] ) ) {
			return;
		}
		if ( $_GET['action'] !== 'search_filter_dismiss_notice' ) {
			return;
		}
		if ( ! isset( $_GET['notice_id'] ) ) {
			wp_send_json( array( 'success' => false ) );
		}
		if ( ! wp_verify_nonce( $_GET['nonce'], 'search_filter_dismiss_notice' ) ) {
			wp_send_json( array( 'success' => false ) );
		}
		$notice_name = sanitize_key( $_GET['notice_id'] );
		$dismissed_notices = get_option( self::OPTION_NOTICES_DISMISSED );
		if ( ! is_array( $dismissed_notices ) ) {
			$dismissed_notices = array();
		}

		if ( ! in_array( $notice_name, $dismissed_notices, true ) ) {
			$dismissed_notices[] = $notice_name;
			update_option( self::OPTION_NOTICES_DISMISSED, $dismissed_notices );
		}
		wp_send_json( array( 'success' => true ) );
	}
	public static function handle_dismiss_notice_js() {
		$query_args = array(
			'action' => 'search_filter_dismiss_notice',
			'nonce' => wp_create_nonce( 'search_filter_dismiss_notice' ),
		);
		$ajax_url = add_query_arg( $query_args, admin_url( 'admin-ajax.php' ) );
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$( '.search-filter-pro-notice' ).on( 'click', '.notice-dismiss', function() {
					var notice_id = $( this ).closest( '.search-filter-pro-notice' ).data( 'notice-id' );
					// Send via ajax.
					var url = '<?php echo $ajax_url; ?>' + '&notice_id=' + notice_id;
					$.ajax( {
						url: url,
						type: 'GET',
						success: function( response ) {
							console.log( response );
						}
					} );
				} );
			} );
		</script>
		<?php
	}
}

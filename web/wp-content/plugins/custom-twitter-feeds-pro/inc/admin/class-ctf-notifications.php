<?php
/**
 * CTF_Notifications.
 *
 * @since 1.7/1.11
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CTF_Notifications {

	/**
	 * Source of notifications content.
	 *
	 * @var string
	 */
	const SOURCE_URL = 'http://plugin.smashballoon.com/notifications.json';

	/**
	 * @var string
	 */
	const OPTION_NAME = 'ctf_notifications';

	/**
	 * JSON data contains notices for all plugins. This is used
	 * to select messages only meant for this plugin
	 *
	 * @var string
	 */
	const PLUGIN = 'twitter';

	/**
	 * Option value.
	 *
	 * @since 1.7/1.11
	 *
	 * @var bool|array
	 */
	public $option = false;

	/**
	 * Initialize class.
	 *
	 * @since 1.7/1.11
	 */
	public function init() {
		$this->hooks();
	}

	/**
	 * Use this function to get the option name to allow
	 * inheritance for the New_User class
	 *
	 * @return string
	 */
	public function option_name() {
		return self::OPTION_NAME;
	}

	/**
	 * Use this function to get the source URL to allow
	 * inheritance for the New_User class
	 *
	 * @return string
	 */
	public function source_url() {
		return self::SOURCE_URL;
	}

	/**
	 * Register hooks.
	 *
	 * @since 1.7/1.11
	 */
	public function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueues' ) );

		add_action( 'ctf_admin_overview_before_title', array( $this, 'output' ) );

		// on cron. Once a week?
		add_action( 'ctf_notification_update', array( $this, 'update' ) );

		add_action( 'wp_ajax_ctf_dashboard_notification_dismiss', array( $this, 'dismiss' ) );
	}


	/**
	 * Check if user has access and is enabled.
	 *
	 * @since 1.7/1.11
	 *
	 * @return bool
	 */
	public function has_access() {
		$access = false;

		if ( current_user_can( 'manage_options' ) ) {
			$access = true;
		}

		return apply_filters( 'ctf_admin_notifications_has_access', $access );
	}

	/**
	 * Get option value.
	 *
	 * @since 1.7/1.11
	 *
	 * @param bool $cache Reference property cache if available.
	 *
	 * @return array
	 */
	public function get_option( $cache = true ) {
		if ( $this->option && $cache ) {
			return $this->option;
		}

		$option = get_option( $this->option_name(), array() );

		$this->option = array(
			'update'    => ! empty( $option['update'] ) ? $option['update'] : 0,
			'events'    => ! empty( $option['events'] ) ? $option['events'] : array(),
			'feed'      => ! empty( $option['feed'] ) ? $option['feed'] : array(),
			'dismissed' => ! empty( $option['dismissed'] ) ? $option['dismissed'] : array(),
		);

		return $this->option;
	}

	/**
	 * Fetch notifications from feed.
	 *
	 * @since 1.7/1.11
	 *
	 * @return array
	 */
	public function fetch_feed() {
		$res = wp_remote_get( $this->source_url() );

		if ( is_wp_error( $res ) ) {
			return array();
		}

		$body = wp_remote_retrieve_body( $res );

		if ( empty( $body ) ) {
			return array();
		}

		$body = str_replace(  array( 'sbi_', 'sbi-' ), array( 'ctf_', 'ctf-' ), $body );

		return $this->verify( json_decode( $body, true ) );
	}

	/**
	 * Verify notification data before it is saved.
	 *
	 * @since 1.7/1.11
	 *
	 * @param array $notifications Array of notifications items to verify.
	 *
	 * @return array
	 */
	public function verify( $notifications ) { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh
		$data = array();

		if ( ! is_array( $notifications ) || empty( $notifications ) ) {
			return $data;
		}

		$option = $this->get_option();

		foreach ( $notifications as $notification ) {

			// The message and license should never be empty, if they are, ignore.
			if ( empty( $notification['content'] ) || empty( $notification['type'] ) ) {
				continue;
			}

			// Ignore if license type does not match.
			$license = ctf_is_pro_version() ? 'pro' : 'free';

			if ( ! in_array( $license, $notification['type'], true ) ) {
				continue;
			}

			// Ignore if expired.
			if ( ! empty( $notification['end'] ) && ctf_get_current_time() > strtotime( $notification['end'] ) ) {
				continue;
			}

			// Ignore if notification has already been dismissed.
			if ( ! empty( $option['dismissed'] ) && in_array( $notification['id'], $option['dismissed'] ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
				continue;
			}

			// TODO: Ignore if notification existed before installing CTF.
			// Prevents bombarding the user with notifications after activation.
			$activated = false;
			if ( ! empty( $activated )
			     && ! empty( $notification['start'] )
			     && $activated > strtotime( $notification['start'] ) ) {
				continue;
			}

			$data[] = $notification;
		}

		return $data;
	}

	/**
	 * Verify saved notification data for active notifications.
	 *
	 * @since 1.7/1.11
	 *
	 * @param array $notifications Array of notifications items to verify.
	 *
	 * @return array
	 */
	public function verify_active( $notifications ) {
		if ( ! is_array( $notifications ) || empty( $notifications ) ) {
			return array();
		}

		// Remove notfications that are not active.
		foreach ( $notifications as $key => $notification ) {
			if ( ( ! empty( $notification['start'] ) && ctf_get_current_time() < strtotime( $notification['start'] ) )
			     || ( ! empty( $notification['end'] ) && ctf_get_current_time() > strtotime( $notification['end'] ) ) ) {
				unset( $notifications[ $key ] );
			}
		}

		return $notifications;
	}

	/**
	 * Get notification data.
	 *
	 * @since 1.7/1.11
	 *
	 * @return array
	 */
	public function get() {
		if ( ! $this->has_access() ) {
			return array();
		}

		$option = $this->get_option();

		// Update notifications using async task.
		if ( empty( $option['update'] ) || ctf_get_current_time() > $option['update'] + DAY_IN_SECONDS ) {
			$this->update();
		}

		$events = ! empty( $option['events'] ) ? $this->verify_active( $option['events'] ) : array();
		$feed   = ! empty( $option['feed'] ) ? $this->verify_active( $option['feed'] ) : array();

		// If there is a new user notification, add it to the beginning of the notification list
		$ctf_newuser = new CTF_New_User();
		$newuser_notifications = $ctf_newuser->get();

		if ( ! empty( $newuser_notifications ) ) {
			$events = array_merge( $newuser_notifications, $events );
		}

		return array_merge( $events, $feed );
	}

	/**
	 * Get notification count.
	 *
	 * @since 1.7/1.11
	 *
	 * @return int
	 */
	public function get_count() {
		return count( $this->get() );
	}

	/**
	 * Add a manual notification event.
	 *
	 * @since 1.7/1.11
	 *
	 * @param array $notification Notification data.
	 */
	public function add( $notification ) {
		if ( empty( $notification['id'] ) ) {
			return;
		}

		$option = $this->get_option();

		if ( in_array( $notification['id'], $option['dismissed'] ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
			return;
		}

		foreach ( $option['events'] as $item ) {
			if ( $item['id'] === $notification['id'] ) {
				return;
			}
		}

		$notification = $this->verify( array( $notification ) );

		update_option(
			'ctf_notifications',
			array(
				'update'    => $option['update'],
				'feed'      => $option['feed'],
				'events'    => array_merge( $notification, $option['events'] ),
				'dismissed' => $option['dismissed'],
			)
		);
	}

	/**
	 * Update notification data from feed.
	 *
	 * @since 1.7/1.11
	 */
	public function update() {
		$feed   = $this->fetch_feed();
		$option = $this->get_option();

		update_option(
			'ctf_notifications',
			array(
				'update'    => ctf_get_current_time(),
				'feed'      => $feed,
				'events'    => $option['events'],
				'dismissed' => $option['dismissed'],
			)
		);
	}

	/**
	 * Admin area Form Overview enqueues.
	 *
	 * @since 1.7/1.11
	 */
	public function enqueues() {
		if ( ! $this->has_access() ) {
			return;
		}

		$notifications = $this->get();

		if ( empty( $notifications ) ) {
			return;
		}

		$min = '';

		wp_enqueue_style(
			'ctf-admin-notifications',
			CTF_PLUGIN_URL . "css/admin-notifications{$min}.css",
			array(),
			CTF_VERSION
		);

		wp_enqueue_script(
			'ctf-admin-notifications',
			CTF_PLUGIN_URL . "js/admin-notifications{$min}.js",
			array( 'jquery' ),
			CTF_VERSION,
			true
		);

		wp_localize_script( 'ctf-admin-notifications', 'ctf_admin', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'ctf-admin' )
			)
		);
	}

	/**
	 * Fields from the remote source contain placeholders to allow
	 * some messages to be used for multiple plugins.
	 *
	 * @param $content string
     * @param $notification array
	 *
	 * @return string
	 *
	 * @since 1.7/1.11
	 */
	public function replace_merge_fields( $content, $notification ) {
		$merge_fields = array(
			'{plugin}' => 'Custom Twitter Feed',
			'{amount}' => isset( $notification['amount'] ) ? $notification['amount'] : '',
			'{platform}' => 'Twitter',
			'{lowerplatform}' => 'twitter',
			'{review-url}' => 'https://wordpress.org/support/plugin/custom-twitter-feeds/reviews/',
			'{slug}' => 'custom-twitter-feed',
			'{campaign}' => 'twitter-free'
		);
		
		if ( ctf_is_pro_version() ) {
			$merge_fields['{campaign}'] = 'twitter-pro';
			$merge_fields['{plugin}'] = 'Custom Twitter Feeds Pro';
		}

		foreach ( $merge_fields as $find => $replace ) {
			$content = str_replace( $find, $replace, $content );
		}

		return $content;
	}

	/**
	 * Output notifications on Custom Twitter Feed admin area.
	 *
	 * @since 1.7/1.11
	 */
	public function output() {
		$notifications = $this->get();

		if ( empty( $notifications ) ) {
			return;
		}

		$notifications_html   = '';
		$current_class        = ' current';
		$content_allowed_tags = array(
			'em'     => array(),
			'strong' => array(),
			'span'   => array(
				'style' => array(),
			),
			'a'      => array(
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
			),
		);

		foreach ( $notifications as $notification ) {

			// Buttons HTML.
			$buttons_html = '';
			if ( ! empty( $notification['btns'] ) && is_array( $notification['btns'] ) ) {
				foreach ( $notification['btns'] as $btn_type => $btn ) {
					if ( is_array( $btn['url'] ) ) {
						$btn['url'] = add_query_arg( $btn['url'] );
					}
					if ( ! empty( $btn['attr'] ) ) {
						$btn['target'] = '_blank';
					}
					$buttons_html .= sprintf(
						'<a href="%1$s" class="button button-%2$s"%3$s>%4$s</a>',
						! empty( $btn['url'] ) ? esc_url( $this->replace_merge_fields( $btn['url'], $notification ) ) : '',
						$btn_type === 'primary' ? 'primary' : 'secondary',
						! empty( $btn['target'] ) && $btn['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '',
						! empty( $btn['text'] ) ? sanitize_text_field( $btn['text'] ) : ''
					);
				}
				$buttons_html = ! empty( $buttons_html ) ? '<div class="buttons">' . $buttons_html . '</div>' : '';
			}

			if ( empty( $notification['image'] ) ) {
				$image_html = '<div class="bell">';

				$image_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="42" height="48" viewBox="0 0 42 48"><defs><style>.a{fill:#777;}.b{fill:#ca4a1f;}</style></defs><path class="a" d="M23-79a6.005,6.005,0,0,1-6-6h10.06a12.066,12.066,0,0,0,1.791,1.308,6.021,6.021,0,0,1-2.077,3.352A6.008,6.008,0,0,1,23-79Zm1.605-9H5.009a2.955,2.955,0,0,1-2.173-.923A3.088,3.088,0,0,1,2-91a2.919,2.919,0,0,1,.807-2.036c.111-.12.229-.243.351-.371a14.936,14.936,0,0,0,3.126-4.409A23.283,23.283,0,0,0,8.007-107.5a14.846,14.846,0,0,1,.906-5.145,14.5,14.5,0,0,1,2.509-4.324A15.279,15.279,0,0,1,20-122.046V-124a3,3,0,0,1,3-3,3,3,0,0,1,3,3v1.954a15.28,15.28,0,0,1,8.58,5.078,14.5,14.5,0,0,1,2.509,4.324,14.846,14.846,0,0,1,.906,5.145c0,.645.016,1.281.047,1.888A12.036,12.036,0,0,0,35-106a11.921,11.921,0,0,0-8.485,3.515A11.923,11.923,0,0,0,23-94a12,12,0,0,0,1.6,6Z" transform="translate(-2 127)"/><circle class="b" cx="9" cy="9" r="9" transform="translate(24 24)"/></svg>';
				$image_html .= '</div>';
			} else {
				if ( $notification['image'] === 'balloon'
				     || $notification['id'] === 'review'
				     || $notification['id'] === 'discount') {
					$image_html = '<div class="bell">';

					$image_html .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1438 1878" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2">';
					$image_html .= '  <path d="M671.51004 492.9884C539.9423 433.8663 402.90125 345.5722 274.97656 304.47286c45.45163 108.39592 83.81332 223.88017 123.51 338.03105C319.308 702.00293 226.8217 748.19258 138.46278 798.51607c75.1914 74.32371 181.67968 117.34651 266.52444 182.01607-67.96124 83.86195-201.48527 171.01801-234.02107 247.01998 140.6922-17.6268 304.63688-46.21031 435.53794-52.00418 28.76427 144.58328 43.5987 303.09763 84.50756 435.53713 60.92033-175.26574 116.0014-356.37317 188.51594-520.0451 111.90644 46.2857 248.29012 102.72607 357.52902 130.01188-76.64636-107.5347-146.59346-221.76948-214.5166-338.02903 100.51162-72.83876 202.1718-144.52451 299.02538-221.02092-136.89514-12.61229-278.73428-20.28827-422.53618-25.99865-22.85288-148.33212-16.84826-325.51604-52.005-461.53983-53.19327 111.4882-115.96694 213.39155-175.51418 318.52497m65.00513 1228.60735c-18.0795 77.37586 41.4876 109.11326 32.50298 156.01215-58.8141-20.268-103.0576-30.67962-182.01567-19.50203 2.47018-60.37036 56.76662-68.90959 45.50432-143.0108C-208.90184 1619.4318-210.59186 99.02478 626.00572 5.44992c1046.0409-117.00405 1078.86445 1689.2596 110.50945 1716.14582" fill="#e34f0e"/>';
					$image_html .= '  <path d="M847.02422 174.46342c35.15674 136.02379 29.15212 313.20771 52.0046 461.53578 143.8023 5.71443 285.63982 13.38636 422.53658 26.0027-96.85317 76.4964-198.51497 148.18216-299.02579 221.0189 67.92355 116.26239 137.87024 230.49432 214.51864 338.03024-109.24093-27.28662-245.62461-83.72577-357.53106-130.01269-72.51454 163.67274-127.5956 344.78017-188.51553 520.0459-40.90926-132.4395-55.74329-290.95384-84.50796-435.53712-130.90066 5.79549-294.84493 34.37738-435.53754 52.00418 32.5358-76.00075 166.05902-163.156 234.02026-247.02038-84.84516-64.67037-191.33222-107.69074-266.52363-182.01486 88.35892-50.32349 180.8436-96.51314 260.02295-156.0162-39.69708-114.14683-78.05674-229.63108-123.50878-338.027C402.89923 345.5722 539.9423 433.86629 671.51004 492.98839c59.54684-105.13342 122.3209-207.03677 175.51418-318.52497" fill="#fff"/>';
					$image_html .= '</svg>';
				} else {
					$image_html = '<div class="thumb">';
					$img_src = SBY_PLUGIN_URL . 'img/' . sanitize_text_field( $notification['image'] );
					$image_html .= '<img src="'.esc_url( $img_src ).'" alt="notice">';

					if ( isset( $notification['image_overlay'] ) ) {
						$image_html .= '<div class="img-overlay">'. esc_html( str_replace( '%', '%%', $notification['image_overlay'] ) ).'</div>';
					}
				}
				$image_html .= '</div>';

			}

			// Notification HTML.
			$notifications_html .= sprintf(
				'<div class="message%5$s" data-message-id="%4$s">' . $image_html . '
					<h3 class="title">%1$s</h3>
					<p class="content">%2$s</p>
					%3$s
				</div>',
				! empty( $notification['title'] ) ? $this->replace_merge_fields( sanitize_text_field( $notification['title'] ), $notification ) : '',
				! empty( $notification['content'] ) ? wp_kses( $this->replace_merge_fields( $notification['content'], $notification ), $content_allowed_tags ) : '',
				$buttons_html,
				! empty( $notification['id'] ) ? esc_attr( sanitize_text_field( $notification['id'] ) ) : 0,
				$current_class
			);

			// Only first notification is current.
			$current_class = '';
		}
		?>

        <div id="ctf-notifications">
            <a class="dismiss" title="<?php echo esc_attr__( 'Dismiss this message', 'custom-twitter-feeds' ); ?>"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

            <div class="navigation">
                <a class="prev disabled" title="<?php echo esc_attr__( 'Previous message', 'custom-twitter-feeds' ); ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-left fa-w-10"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z" class=""></path></svg></a>
                <a class="next disabled" title="<?php echo esc_attr__( 'Next message', 'custom-twitter-feeds' ); ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-right fa-w-10"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" class=""></path></svg></a>
            </div>

            <div class="messages">
				<?php echo $notifications_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </div>
		<?php
	}

	/**
	 * Dismiss notification via AJAX. If it's a new user message, also dismiss it
	 * on all admin pages.
	 *
	 * @since 1.7/1.11
	 */
	public function dismiss() {
		// Run a security check.
		check_ajax_referer( 'ctf-admin', 'nonce' );

		// Check for access and required param.
		if ( ! $this->has_access() || empty( $_POST['id'] ) ) {
			wp_send_json_error();
		}

		$id     = sanitize_text_field( wp_unslash( $_POST['id'] ) );

		if ( $id === 'review' ) {
			$ctf_statuses_option = get_option( 'ctf_statuses', array() );

			update_option( 'ctf_rating_notice', 'dismissed', false );
			$ctf_statuses_option['rating_notice_dismissed'] = ctf_get_current_time();
			update_option( 'ctf_statuses', $ctf_statuses_option, false );
		} elseif ( $id === 'discount' ) {
			update_user_meta( get_current_user_id(), 'ctf_ignore_new_user_sale_notice', 'always' );

			$current_month_number = (int)date('n', ctf_get_current_time() );
			$not_early_in_the_year = ($current_month_number > 5);

			if ( $not_early_in_the_year ) {
				update_user_meta( get_current_user_id(), 'ctf_ignore_bfcm_sale_notice', date( 'Y', ctf_get_current_time() ) );
			}
		}

		$option = $this->get_option();
		$type   = is_numeric( $id ) ? 'feed' : 'events';

		$option['dismissed'][] = $id;
		$option['dismissed']   = array_unique( $option['dismissed'] );

		// Remove notification.
		if ( is_array( $option[ $type ] ) && ! empty( $option[ $type ] ) ) {
			foreach ( $option[ $type ] as $key => $notification ) {
				if ( $notification['id'] == $id ) { // phpcs:ignore WordPress.PHP.StrictComparisons
					unset( $option[ $type ][ $key ] );
					break;
				}
			}
		}

		update_option( 'ctf_notifications', $option );

		wp_send_json_success();
	}
}

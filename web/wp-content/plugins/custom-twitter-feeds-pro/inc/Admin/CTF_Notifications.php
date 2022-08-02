<?php
/**
 * CTF_Notifications.
 *
 * @since 2.6/5.9
 */
namespace TwitterFeed\Admin;

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
	const SOURCE_URL = 'https://plugin.smashballoon.com/notifications.json';

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
	 * @since 2.6/5.9
	 *
	 * @var bool|array
	 */
	public $option = false;

	/**
	 * Initialize class.
	 *
	 * @since 2.6/5.9
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
	 * @since 2.6/5.9
	 */
	public function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueues' ) );

		add_action( 'ctf_admin_notices', array( $this, 'output' ) );

		// on cron. Once a week?
		add_action( 'ctf_notification_update', array( $this, 'update' ) );

		add_action( 'wp_ajax_ctf_dashboard_notification_dismiss', array( $this, 'dismiss' ) );
	}


	/**
	 * Check if user has access and is enabled.
	 *
	 * @since 2.6/5.9
	 *
	 * @return bool
	 */
	public function has_access() {
		$access = false;

		if ( current_user_can( 'manage_twitter_feed_options' ) || current_user_can( 'manage_options' ) ) {
			$access = true;
		}

		return apply_filters( 'ctf_admin_notifications_has_access', $access );
	}

	/**
	 * Get option value.
	 *
	 * @since 2.6/5.9
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
	 * @since 2.6/5.9
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

		return $this->verify( json_decode( $body, true ) );
	}

	/**
	 * Verify notification data before it is saved.
	 *
	 * @since 2.6/5.9
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
			// Ignore if not a targeted plugin
			if ( ! empty( $notification['plugin'] ) && is_array( $notification['plugin'] ) && ! in_array( self::PLUGIN, $notification['plugin'], true ) ) {
				continue;
			}

			// Ignore if max wp version detected
			if ( ! empty( $notification['maxwpver'] ) && version_compare( get_bloginfo( 'version' ), $notification['maxwpver'], '>' ) ) {
				continue;
			}

			// Ignore if max version has been reached
			if ( ! empty( $notification['maxver'] ) && version_compare( $notification['maxver'],  CTF_VERSION ) < 0 ) {
				continue;
			}

			// Ignore if min version has not been reached
			if ( ! empty( $notification['minver'] ) && version_compare( $notification['minver'],  CTF_VERSION ) > 0 ) {
				continue;
			}

			// Ignore if a specific ctf_status is empty or false
			if ( ! empty( $notification['statuscheck'] ) ) {
				$status_key          = sanitize_key( $notification['statuscheck'] );
				$ctf_statuses_option = get_option( 'ctf_statuses', array() );

				if ( empty( $ctf_statuses_option[ $status_key ] ) ) {
					continue;
				}
			}

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

			// Ignore message "9".
			if ( in_array( (int)$notification['id'], array( 9 ) ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
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
	 * @since 2.6/5.9
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

			if ( empty( $notification['recent_install_override'] ) && $this->recently_installed() ) {
				unset( $notifications[ $key ] );
			}

			// Ignore if max version has been reached
			if ( ! empty( $notification['maxver'] ) && version_compare( $notification['maxver'],  CTF_VERSION ) < 0 ) {
				unset( $notifications[ $key ] );
			}

			// Ignore if max wp version detected
			if ( ! empty( $notification['maxwpver'] ) && version_compare( get_bloginfo( 'version' ), $notification['maxwpver'], '>' ) ) {
				unset( $notifications[ $key ] );
			}

			// Ignore if min version has not been reached
			if ( ! empty( $notification['minver'] ) && version_compare( $notification['minver'],  CTF_VERSION ) > 0 ) {
				unset( $notifications[ $key ] );
			}

			// Ignore if a specific ctf_status is empty or false
			if ( ! empty( $notification['statuscheck'] ) ) {
				$status_key          = sanitize_key( $notification['statuscheck'] );
				$ctf_statuses_option = get_option( 'ctf_statuses', array() );

				if ( empty( $ctf_statuses_option[ $status_key ] ) ) {
					unset( $notifications[ $key ] );
				}
			}
		}

		return $notifications;
	}

	/**
	 * @return bool
	 *
	 * @since 1.4.5/1.4.2
	 */
	public function recently_installed() {
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );

		if ( ! isset( $ctf_statuses_option['first_install'] ) ) {
			return false;
		}

		// Plugin was installed less than a week ago
		if ( (int) $ctf_statuses_option['first_install'] > time() - WEEK_IN_SECONDS ) {
			return true;
		}

		return false;
	}

	/**
	 * Get notification data.
	 *
	 * @since 2.6/5.9
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
	 * @since 2.6/5.9
	 *
	 * @return int
	 */
	public function get_count() {
		return count( $this->get() );
	}

	/**
	 * Add a manual notification event.
	 *
	 * @since 2.6/5.9
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
	 * @since 2.6/5.9
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
	 * @since 2.6/5.9
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
	 * @since 2.6/5.9
	 */
	public function replace_merge_fields( $content, $notification ) {
		$merge_fields = array(
			'{plugin}' => 'Twitter Feed',
			'{amount}' => isset( $notification['amount'] ) ? $notification['amount'] : '',
			'{platform}' => 'Twitter',
			'{lowerplatform}' => 'twitter',
			'{review-url}' => 'https://wordpress.org/support/plugin/custom-twitter-feeds/reviews/',
			'{slug}' => 'custom-twitter-feeds',
			'{campaign}' => 'twitter-free'
		);

		if ( ctf_is_pro_version() ) {
			$merge_fields['{campaign}'] = 'twitter-pro';
			$merge_fields['{plugin}'] = 'Twitter Feed Pro';
		}

		foreach ( $merge_fields as $find => $replace ) {
			$content = str_replace( $find, $replace, $content );
		}

		return $content;
	}

	/**
	 * Output notifications on Twitter Feed admin area.
	 *
	 * @since 2.6/5.9
	 */
	public function output() {
		// if we are one single feed page then return
		if ( isset( $_GET['feed_id'] ) ) {
			return;
		}

		$notifications = $this->get();

		if ( empty( $notifications ) ) {
			return;
		}

		$is_review_notice = ! empty( $notifications[0] ) && ! empty( $notifications[0]['id'] ) && $notifications[0]['id'] === 'review';

		if ( ! $is_review_notice && ! empty( $_GET['feed_id'] ) ) {
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
			$type = $notification['id'];
			// Buttons HTML.
			$buttons_html = '';
			if ( ! empty( $notification['btns'] ) && is_array( $notification['btns'] ) ) {
				foreach ( $notification['btns'] as $btn_type => $btn ) {
					if ( $type == 'review' || $type == 'discount' ) {
						$btn_class = $btn_type === 'primary' ? 'ctf-btn-blue' : 'ctf-btn-grey';
					} else {
						$btn_class = $btn_type === 'primary' ? 'ctf-btn-orange' : 'ctf-btn-grey';
					}
					if ( is_array( $btn['url'] ) ) {
						$args = array();
						foreach ( $btn['url'] as $key => $value ) {
							$args[ sanitize_key( $key ) ] = sanitize_key( $value );
						}
						$btn['url'] = add_query_arg( $args );
					}
					if ( ! empty( $btn['attr'] ) ) {
						$btn['target'] = '_blank';
					}
					if ( empty( $btn['class'] ) ) {
						$btn['class'] = '';
					}
					$buttons_html .= sprintf(
						'<a href="%1$s" class="ctf-btn %2$s %3$s"%4$s>%5$s</a>',
						! empty( $btn['url'] ) ? esc_url( $this->replace_merge_fields( str_replace( 'sbi_', 'ctf_', $btn['url'] ), $notification ) ) : '',
						esc_attr( $btn['class'] ),
						esc_attr( $btn_class ),
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
				if ( $notification['image'] === 'balloon' ) {
					$image_html = sprintf(
						'<div class="bell"><img src="%s" alt="notice">',
						CTF_PLUGIN_URL . 'admin/assets/img/balloon.svg' );
				} else if ( $notification['id'] === 'review' || $notification['id'] === 'discount' ) {
					$image_html = sprintf(
						'<div class="bell"><img src="%s" alt="notice">',
						CTF_PLUGIN_URL . 'admin/assets/img/' . sanitize_text_field( str_replace( array( 'sbi', '.png' ), array( 'ctf', '.svg' ), $notification['image'] ) )
					);
				} else {
					$image_html = '<div class="thumb">';
					$img_src = CTF_PLUGIN_URL . 'admin/assets/img/' . sanitize_text_field( $notification['image'] );
					$image_html .= '<img src="'.esc_url( $img_src ).'" alt="notice">';

					if ( isset( $notification['image_overlay'] ) ) {
						$image_html .= '<div class="img-overlay">'. esc_html( str_replace( '%', '%%', $notification['image_overlay'] ) ).'</div>';
					}
				}
				$image_html .= '</div>';

			}

			// Check if it's review notice then show step #1
			if ( $type == 'review' ) {
				$step1_img = CTF_PLUGIN_URL . 'admin/assets/img/' . sanitize_text_field( str_replace( array( 'sbi', 'png' ), array( 'ctf', 'svg' ), $notification['image'] ) );
				$step1_img_html = sprintf('<div class="bell"><img src="%s" alt="notice"></div>', $step1_img);

				$review_consent = get_option( 'ctf_review_consent' );
				$ctf_open_feedback_url = 'https://smashballoon.com/feedback/?plugin=twitter-pro';
				// step #1 for the review notice
				if ( ! $review_consent ) {
					$step1_btns = sprintf(
						'<button class="ctf-btn-link" id="ctf_review_consent_yes">%s</button>',
						__( 'Yes', 'custom-twitter-feeds' )
					);
					$step1_btns .= sprintf(
						'<a href="%s" target="_blank" rel="nofollow noopener" class="ctf-btn-link"  id="ctf_review_consent_no">%s</a>',
						$ctf_open_feedback_url,
						__( 'No', 'custom-twitter-feeds' )
					);
					$notifications_html .= sprintf(
						'<div class="ctf_review_step1_notice" data-message-id="%3$s">' . $step1_img_html . '
							<h3 class="title">%1$s</h3>
							<div class="review-step-1-btns">%2$s</div>
						</div>',
						__( 'Are you enjoying the Custom Twitter Feeds Plugin?', 'custom-twitter-feeds' ),
						$step1_btns,
						! empty( $notification['id'] ) ? esc_attr( sanitize_text_field( $notification['id'] ) ) : 0
					);
				}
			}

			$review_consent = get_option( 'ctf_review_consent' );
			$review_step2_style = '';
			if ( $type == 'review' && ! $review_consent ) {
				$review_step2_style = 'style="display: none;"';
			}

			// Build the notification HTML for review notice
			if ( $type == 'review' ) {
				$notifications_html .= sprintf(
					'<div class="message%5$s %7$s" data-message-id="%4$s" %6$s>' . $image_html . '
						<h3 class="title">%1$s</h3>
						<p class="content">%2$s</p>
						%3$s
					</div>',
					__( 'Glad to hear you are enjoying it. Would you consider leaving a positive review?', 'custom-twitter-feeds' ),
					__( 'It really helps to support the plugin and help others to discover it too!', 'custom-twitter-feeds' ),
					$buttons_html,
					! empty( $notification['id'] ) ? esc_attr( sanitize_text_field( $notification['id'] ) ) : 0,
					$current_class,
					( $notification['id'] == 'review' && ! empty( $review_step2_style ) ) ? $review_step2_style : '',
					( $type == 'review' ) ? 'rn_step_2' : ''
				);
			} else if ( $type == 'discount' ) {

			} else {
				// Notification HTML for other notices
				$notifications_html .= sprintf(
					'<div class="message%5$s" data-message-id="%4$s" %6$s>' . $image_html . '
						<h3 class="title">%1$s</h3>
						<p class="content">%2$s</p>
						%3$s
					</div>',
					! empty( $notification['title'] ) ? $this->replace_merge_fields( sanitize_text_field( $notification['title'] ), $notification ) : '',
					! empty( $notification['content'] ) ? wp_kses( $this->replace_merge_fields( $notification['content'], $notification ), $content_allowed_tags ) : '',
					$buttons_html,
					! empty( $notification['id'] ) ? esc_attr( sanitize_text_field( $notification['id'] ) ) : 0,
					$current_class,
					( $notification['id'] == 'review' && ! empty( $review_step2_style ) ) ? $review_step2_style : ''
				);
			}

			// Only first notification is current.
			$current_class = '';
		}

		$close_href = add_query_arg( array( 'ctf_dismiss' => $type ) );
		$type_class = '';
		if ( $type === 'review' || $type == 'discount' ) {
			$type_class = $type === 'review' ? 'ctf_review_notice' : 'ctf_discount_notice';
		}

		?>

		<div id="ctf-notifications" class="<?php echo esc_attr( $type_class ); ?>">
			<a
				class="dismiss"
				title="<?php echo esc_attr__( 'Dismiss this message', 'custom-twitter-feeds' ); ?>"
				<?php echo ( $type == 'review' || $type == 'discount' ) ? 'href="'. esc_attr( $close_href ) .'"' : '' ?>
			>
				<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M9.66683 1.27325L8.72683 0.333252L5.00016 4.05992L1.2735 0.333252L0.333496 1.27325L4.06016 4.99992L0.333496 8.72659L1.2735 9.66659L5.00016 5.93992L8.72683 9.66659L9.66683 8.72659L5.94016 4.99992L9.66683 1.27325Z" fill="white"/>
				</svg>
			</a>

			<?php if ( count( $notifications ) > 1 ) : ?>
				<div class="navigation">
					<a class="prev disabled" title="<?php echo esc_attr__( 'Previous message', 'custom-twitter-feeds' ); ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-left fa-w-10"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z" class=""></path></svg></a>
					<a class="next disabled" title="<?php echo esc_attr__( 'Next message', 'custom-twitter-feeds' ); ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-right fa-w-10"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" class=""></path></svg></a>
				</div>
			<?php endif; ?>

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
	 * @since 2.6/5.9
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

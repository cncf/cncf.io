<?php
/**
 * Instagram Feed block with live preview.
 *
 * @since 1.7.1
 */
namespace TwitterFeed\Blocks;

use TwitterFeed\Builder\CTF_Db;
use TwitterFeed\Builder\CTF_Feed_Builder;

class CTF_Blocks {

	/**
	 * Indicates if current integration is allowed to load.
	 *
	 * @since 1.8
	 *
	 * @return bool
	 */
	public function allow_load() {
		return function_exists( 'register_block_type' );
	}

	/**
	 * Loads an integration.
	 *
	 * @since 1.7.1
	 */
	public function load() {
		$this->hooks();
	}

	/**
	 * Integration hooks.
	 *
	 * @since 1.7.1
	 */
	protected function hooks() {
		add_action( 'init', array( $this, 'register_block' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

	/**
	 * Register Instagram Feed Gutenberg block on the backend.
	 *
	 * @since 1.7.1
	 */
	public function register_block() {

		wp_register_style(
			'ctf-blocks-styles',
			trailingslashit( CTF_PLUGIN_URL ) . 'css/ctf-blocks.css',
			array( 'wp-edit-blocks' ),
			CTF_VERSION
		);

		$attributes = array(
			'shortcodeSettings' => array(
				'type' => 'string',
			),
			'noNewChanges' => array(
				'type' => 'boolean',
			),
			'executed' => array(
				'type' => 'boolean',
			)
		);

		register_block_type(
			'ctf/ctf-feed-block',
			array(
				'attributes'      => $attributes,
				'render_callback' => array( $this, 'get_feed_html' ),
			)
		);
	}

	/**
	 * Load Instagram Feed Gutenberg block scripts.
	 *
	 * @since 1.7.1
	 */
	public function enqueue_block_editor_assets() {
		ctf_scripts_and_styles_pro( true );

		wp_enqueue_style( 'ctf-blocks-styles' );
		wp_enqueue_script(
			'ctf-feed-block',
			trailingslashit( CTF_PLUGIN_URL ) . 'js/ctf-blocks.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			CTF_VERSION,
			true
		);

		$shortcodeSettings = '';

		$i18n = array(
			'addSettings'         => esc_html__( 'Add Settings', 'custom-twitter-feeds' ),
			'shortcodeSettings'   => esc_html__( 'Shortcode Settings', 'custom-twitter-feeds' ),
			'example'             => esc_html__( 'Example', 'custom-twitter-feeds' ),
			'preview'             => esc_html__( 'Apply Changes', 'custom-twitter-feeds' ),

		);

		wp_localize_script(
			'ctf-feed-block',
			'ctf_block_editor',
			array(
				'wpnonce'  => wp_create_nonce( 'ctf-blocks' ),
				'canShowFeed' => true,
				'configureLink' => get_admin_url() . '?page=custom-twitter-feeds',
				'shortcodeSettings'    => $shortcodeSettings,
				'i18n'     => $i18n,
			)
		);
	}

	/**
	 * Get form HTML to display in a Instagram Feed Gutenberg block.
	 *
	 * @param array $attr Attributes passed by Instagram Feed Gutenberg block.
	 *
	 * @since 1.7.1
	 *
	 * @return string
	 */
	public function get_feed_html( $attr ) {
		$feeds_count = CTF_Db::feeds_count();
		$shortcode_settings = isset( $attr['shortcodeSettings'] ) ? $attr['shortcodeSettings'] : '';
		if ( $feeds_count <= 0 ) {
			return $this->plain_block_design( empty( ctf_license_handler()->get_license_key ) ? 'inactive' : 'expired' );
		}

		$return = '';
		$return .= $this->get_license_expired_notice();

		$shortcode_settings = str_replace(array( '[custom-twitter-feeds', ']' ), '', $shortcode_settings );

		$return .= do_shortcode( '[custom-twitter-feeds '.$shortcode_settings.']' );

		return $return;

	}

	public function get_license_expired_notice() {
		// Check that the license exists and the user hasn't already clicked to ignore the message
		if ( empty( ctf_license_handler()->get_license_key ) ) {
			return $this->get_license_expired_notice_content( 'inactive' );
		}
		// If license not expired then return;
		if ( !ctf_license_handler()->is_license_expired ) {
			return;
		}
		// Grace period ended?
		if ( ! ctf_license_handler()->is_license_grace_period_ended( true ) ) {
			return;
		}

		return $this->get_license_expired_notice_content();
	}


	/**
	 * Output the license expired notice content on top of the embed block
	 *
	 * @since 4.4.0
	 */
	public function get_license_expired_notice_content( $license_state = 'expired' ) {
		if ( !is_admin() && !defined( 'REST_REQUEST' ) ) {
			return;
		}

		$icons = CTF_Feed_Builder::builder_svg_icons();

		$output = '<div class="ctf-block-license-expired-notice-ctn ctf-bln-license-state-'. $license_state .'">';
			$output .= '<div class="ctf-blen-header">';
				$output .= $icons['eye2'];
				$output .= '<span>' . __('Only Visible to WordPress Admins', 'custom-twitter-feeds') . '</span>';
			$output .= '</div>';
			$output .= '<div class="ctf-blen-resolve">';
				$output .= '<div class="ctf-left">';
					$output .= $icons['info'];
					if ( $license_state == 'inactive' ) {
						$output .= '<span>' . __('Your license key is inactive. Activate it to enable Pro features.', 'custom-twitter-feeds') . '</span>';
					} else {
						$output .= '<span>' . __('Your license has expired! Renew it to reactivate Pro features.', 'custom-twitter-feeds') . '</span>';
					}
				$output .= '</div>';
				$output .= '<div class="ctf-right">';
					$output .= '<a href="'. ctf_license_handler()->get_renew_url( $license_state ) .'" target="_blank">'. __('Resolve Now', 'custom-twitter-feeds') .'</a>';
					$output .= $icons['chevronRight'];
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * Plain block design when theres no feeds.
	 *
	 * @since 4.4.0
	 */
	public function plain_block_design( $license_state = 'expired' ) {
		if ( !is_admin() && !defined( 'REST_REQUEST' ) ) {
			return;
		}
		$other_plugins = $this->get_others_plugins();
		$should_display_license_notice = ctf_license_handler()->should_disable_pro_features;
		$icons = CTF_Feed_Builder::builder_svg_icons();
		$output = '<div class="ctf-license-expired-plain-block-wrapper '. $license_state .'">';

		if ( $should_display_license_notice ) :
			$output .= '<div class="ctf-lepb-header">
				<div class="sb-left">';
					$output .= $icons['info'];
					if ( $license_state == 'expired' ) {
						$output .= sprintf('<p>%s</p>', __('Your license has expired! Renew it to reactivate Pro features.', 'custom-twitter-feeds'));
					} else {
						$output .= sprintf('<p>%s</p>', __('Your license key is inactive. Activate it to enable Pro features.', 'custom-twitter-feeds'));
					}
			$output .= '</div>
				<div class="sb-right">
					<a href="'. ctf_license_handler()->get_renew_url( $license_state ) .'">
						Resolve Now
						'. $icons['chevronRight'] .'
					</a>
				</div>
			</div>';
		endif;
			$output .= '<div class="ctf-lepb-body">
				'. $icons['blockEditorCTFLogo'] .'
				<p class="ctf-block-body-title">Get started with your first feed from <br/> your Instagram profile</p>';

		$output .= sprintf(
					'<a href="%s" class="ctf-btn ctf-btn-blue">%s '. $icons['chevronRight'] .'</a>',
					admin_url('admin.php?page=ctf-feed-builder'),
					__('Create a Twitter Feed', 'custom-twitter-feeds')
				);
		$output .= '</div>
			<div class="ctf-lepd-footer">
				<p class="ctf-lepd-footer-title">Did you know? </p>
				<p>You can add posts from '. $other_plugins .' using our free plugins</p>
			</div>
		</div>';

		return $output;
	}



	/**
	 * Get other Smash Balloon plugins list
	 *
	 * @since 4.4.0
	 */
	public function get_others_plugins() {
		$active_plugins = ctf_license_handler()->get_sb_active_plugins_info;

		$other_plugins = array(
			'is_instagram_installed' => array(
				'title' => 'Instagram',
				'url'	=> 'https://smashballoon.com/instagram-feed/?utm_campaign=twitter-pro&utm_source=block-feed-embed&utm_medium=did-you-know',
			),
			'is_facebook_installed' => array(
				'title' => 'Facebook',
				'url'	=> 'https://smashballoon.com/custom-twitter-feeds/?utm_campaign=twitter-pro&utm_source=block-feed-embed&utm_medium=did-you-know',
			),
			'is_youtube_installed' => array(
				'title' => 'YouTube',
				'url'	=> 'https://smashballoon.com/youtube-feed/?utm_campaign=twitter-pro&utm_source=block-feed-embed&utm_medium=did-you-know',
			),
		);

		if ( ! empty( $active_plugins ) ) {
			foreach ( $active_plugins as $name => $plugin ) {
				if ( $plugin != false ) {
					unset( $other_plugins[$name] );
				}
			}
		}

		$other_plugins_html = array();
		foreach( $other_plugins as $plugin ) {
			$other_plugins_html[] = '<a href="'. $plugin['url'] .'">'. $plugin['title'] .'</a>';
		}

		return \implode(", ", $other_plugins_html);
	}

	/**
	 * Checking if is Gutenberg REST API call.
	 *
	 * @since 1.7.1
	 *
	 * @return bool True if is Gutenberg REST API call.
	 */
	public static function is_gb_editor() {

		// TODO: Find a better way to check if is GB editor API call.
		return defined( 'REST_REQUEST' ) && REST_REQUEST && ! empty( $_REQUEST['context'] ) && 'edit' === $_REQUEST['context']; // phpcs:ignore
	}

}

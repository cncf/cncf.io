<?php
/**
 * CTF License Service Class.
 *
 * @since 2.1.0
 */
namespace TwitterFeed;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use TwitterFeed\Builder\CTF_Db;
use TwitterFeed\Builder\CTF_Feed_Builder;

class CTF_License_Notification {

	protected $db;

	public function __construct() {
		$this->db = new CTF_Db();
		$this->register();
	}

	public function register() {
		add_action( 'wp_footer', [$this, 'ctf_frontend_license_error'], 300 );
		add_action( 'wp_ajax_ctf_hide_frontend_license_error', [$this, 'hide_frontend_license_error'], 10 );
	}

	/**
	 * Hide the frontend license error message for a day
	 *
	 * @since 2.0.3
	 */
	public function hide_frontend_license_error() {
		check_ajax_referer( 'ctf_nonce' , 'nonce');

		set_transient( 'ctf_license_error_notice', true, DAY_IN_SECONDS );

		wp_die();
	}

    public function ctf_frontend_license_error() {
        // Don't do anything for guests.
        if ( ! is_user_logged_in() ) {
			return;
        }
		if ( ! current_user_can( ctf_capablity_check() ) ) {
			return;
		}
		// Check that the license exists and the user hasn't already clicked to ignore the message
		if ( empty( ctf_license_handler()->get_license_key ) ) {
			$this->ctf_frontend_license_error_content( 'inactive' );
			return;
		}
		// If license not expired then return;
		if ( !ctf_license_handler()->is_license_expired ) {
			return;
		}
		if ( ctf_license_handler()->is_license_grace_period_ended( true ) ) {
			$this->ctf_frontend_license_error_content();
		}
		return;
    }

    /**
     * Output frontend license error HTML content
     *
     * @since 6.2.0
     */
	public function ctf_frontend_license_error_content( $license_state = 'expired' ) {
            $icons = CTF_Feed_Builder::builder_svg_icons();

			$feeds_count = $this->db->feeds_count();
			if ( $feeds_count <= 0 ) {
				return;
			}
			$should_display_license_error_notice = get_transient( 'ctf_license_error_notice' );
			if ( $should_display_license_error_notice ) {
				return;
			}
        ?>
            <div id="ctf-fr-ce-license-error" class="ctf-critical-error ctf-frontend-license-notice ctf-ce-license-<?php echo $license_state; ?>">
                <div class="ctf-fln-header">
                    <span class="sb-left">
                        <?php echo $icons['eye2']; ?>
                        <span class="sb-text"><?php _e('Only Visible to WordPress Admins', 'custom-twitter-feeds') ?></span>
                    </span>
                    <span id="ctf-frce-hide-license-error" class="sb-close"><?php echo $icons['times2SVG']; ?></span>
                </div>
                <div class="ctf-fln-body">
                    <?php echo $icons['twitter']; ?>
                    <div class="ctf-fln-expired-text">
                        <p>
                            <?php
                                printf(
                                    __( 'Your Twitter Feed Pro license key %s', 'custom-twitter-feeds' ),
                                    $license_state == 'expired' ? 'has ' . $license_state : 'is ' . $license_state
                                );
                            ?>
                            <a href="<?php echo $this->get_renew_url( $license_state ); ?>">Resolve Now <?php echo $icons['chevronRight']; ?></a>
                        </p>
                    </div>
                </div>
            </div>
        <?php
	}

	/**
	 * SBY Get Renew License URL
	 *
	 * @since 2.0
	 *
	 * @return string $url
	 */
	public function get_renew_url( $license_state = 'expired' ) {
		if ( $license_state == 'inactive' ) {
			return admin_url('admin.php?page=ctf-settings&focus=license');
		}
		$license_key = !empty( ctf_license_handler()->get_license_key ) ? ctf_license_handler()->get_license_key : null;

		$url = sprintf(
			'https://smashballoon.com/checkout/?edd_license_key=%s&download_id=%s&utm_campaign=instagram-pro&utm_source=expired-notice&utm_medium=renew-license',
			$license_key,
			CTF_PRODUCT_ID
		);

		return $url;
	}

}

<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Deactivate addon.
 *
 * @since 1.0.0
 */
function ctf_deactivate_addon() {

	// Run a security check.
	check_ajax_referer( 'ctf-admin', 'nonce' );

	// Check for permissions.
	if ( ! current_user_can( 'activate_plugins' ) ) {
		wp_send_json_error();
	}

	$type = 'addon';
	if ( ! empty( $_POST['type'] ) ) {
		$type = sanitize_key( $_POST['type'] );
	}

	if ( isset( $_POST['plugin'] ) ) {
		deactivate_plugins( preg_replace( '/[^a-z-_\/]/', '', wp_unslash( str_replace( '.php', '', $_POST['plugin'] ) ) ) . '.php' );

		if ( 'plugin' === $type ) {
			wp_send_json_success( esc_html__( 'Plugin deactivated.', 'custom-twitter-feeds' ) );
		} else {
			wp_send_json_success( esc_html__( 'Addon deactivated.', 'custom-twitter-feeds' ) );
		}
	}

	wp_send_json_error( esc_html__( 'Could not deactivate the addon. Please deactivate from the Plugins page.', 'custom-twitter-feeds' ) );
}
add_action( 'wp_ajax_ctf_deactivate_addon', 'ctf_deactivate_addon' );

/**
 * Activate addon.
 *
 * @since 1.0.0
 */
function ctf_activate_addon() {
	// Run a security check.
	check_ajax_referer( 'ctf-admin', 'nonce' );

	// Check for permissions.
	if ( ! current_user_can( 'activate_plugins' ) ) {
		wp_send_json_error();
	}

	if ( isset( $_POST['plugin'] ) ) {

		$type = 'addon';
		if ( ! empty( $_POST['type'] ) ) {
			$type = sanitize_key( $_POST['type'] );
		}

		$activate = activate_plugins( preg_replace( '/[^a-z-_\/]/', '', wp_unslash( str_replace( '.php', '', $_POST['plugin'] ) ) ) . '.php' );

		if ( ! is_wp_error( $activate ) ) {
			if ( 'plugin' === $type ) {
				wp_send_json_success( esc_html__( 'Plugin activated.', 'custom-twitter-feeds' ) );
			} else {
				wp_send_json_success( esc_html__( 'Addon activated.', 'custom-twitter-feeds' ) );
			}
		}
	}

	wp_send_json_error( esc_html__( 'Could not activate addon. Please activate from the Plugins page.', 'custom-twitter-feeds' ) );
}
add_action( 'wp_ajax_ctf_activate_addon', 'ctf_activate_addon' );

/**
 * Install addon.
 *
 * @since 1.0.0
 */
function ctf_install_addon() {

	// Run a security check.
	check_ajax_referer( 'ctf-admin', 'nonce' );

	// Check for permissions.
	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_send_json_error();
	}

	$error = esc_html__( 'Could not install addon. Please download from smashballoon.com and install manually.', 'custom-twitter-feeds' );

	if ( empty( $_POST['plugin'] ) ) {
		wp_send_json_error( $error );
	}

	// Only install plugins from the .org repo
	if ( strpos( $_POST['plugin'], 'https://downloads.wordpress.org/plugin/' ) !== 0 ) {
		wp_send_json_error( $error );
	}

	// Set the current screen to avoid undefined notices.
	set_current_screen( 'ctf-about-us' );

	// Prepare variables.
	$url = esc_url_raw(
		add_query_arg(
			array(
				'page' => 'ctf-about-us',
			),
			admin_url( 'admin.php' )
		)
	);

	$creds = request_filesystem_credentials( $url, '', false, false, null );

	// Check for file system permissions.
	if ( false === $creds ) {
		wp_send_json_error( $error );
	}

	if ( ! WP_Filesystem( $creds ) ) {
		wp_send_json_error( $error );
	}

	/*
	 * We do not need any extra credentials if we have gotten this far, so let's install the plugin.
	 */

	require_once CTF_PLUGIN_DIR . 'admin/class-install-skin.php';

	// Do not allow WordPress to search/download translations, as this will break JS output.
	remove_action( 'upgrader_process_complete', array( 'Language_Pack_Upgrader', 'async_upgrade' ), 20 );

	// Create the plugin upgrader with our custom skin.
	$installer = new Ctf\Helpers\PluginSilentUpgrader( new Ctf_Install_Skin() );

	// Error check.
	if ( ! method_exists( $installer, 'install' ) || empty( $_POST['plugin'] ) ) {
		wp_send_json_error( $error );
	}

	$installer->install( esc_url_raw( wp_unslash( $_POST['plugin'] ) ) );

	// Flush the cache and return the newly installed plugin basename.
	wp_cache_flush();

	$plugin_basename = $installer->plugin_info();

	if ( $plugin_basename ) {

		$type = 'addon';
		if ( ! empty( $_POST['type'] ) ) {
			$type = sanitize_key( $_POST['type'] );
		}

		// Activate the plugin silently.
		$activated = activate_plugin( $plugin_basename );

		if ( ! is_wp_error( $activated ) ) {
			wp_send_json_success(
				array(
					'msg'          => 'plugin' === $type ? esc_html__( 'Plugin installed & activated.', 'custom-twitter-feeds' ) : esc_html__( 'Addon installed & activated.', 'custom-twitter-feeds' ),
					'is_activated' => true,
					'basename'     => $plugin_basename,
				)
			);
		} else {
			wp_send_json_success(
				array(
					'msg'          => 'plugin' === $type ? esc_html__( 'Plugin installed.', 'custom-twitter-feeds' ) : esc_html__( 'Addon installed.', 'custom-twitter-feeds' ),
					'is_activated' => false,
					'basename'     => $plugin_basename,
				)
			);
		}
	}

	wp_send_json_error( $error );
}
add_action( 'wp_ajax_ctf_install_addon', 'ctf_install_addon' );

/**
 * Smash Balloon Encrypt or decrypt
 *
 * @param string @action
 * @param string @string
 *
 * @return string $output
 */
function ctf_encrypt_decrypt( $action, $string ) {
	$output = false;

	$encrypt_method = "AES-256-CBC";
	$secret_key     = 'SMA$H.BA[[OON#23121';
	$secret_iv      = '1231394873342102221';

	// hash
	$key = hash( 'sha256', $secret_key );

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

	if ( $action === 'encrypt' ) {
		$output = openssl_encrypt( $string, $encrypt_method, $key, 0, $iv );
		$output = base64_encode( $output );
	} else if ( $action === 'decrypt' ) {
		$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
	}

	return $output;
}

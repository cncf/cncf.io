<?php
/**
 * Ultimate Member - Deactivate assets
 *
 * @link              https://cncf.io/
 * @since             1.0.0
 * @package           umda
 *
 * @wordpress-plugin
 * Plugin Name:       Ultimate Member - Deactivate assets
 * Plugin URI:        https://github.com/cncf/cncf.io
 * Description:       Remove UM from loading on every page.
 * Version:           1.0.2
 * Author:            Ultimate Member, James Hunt
 * Author URI:        https://bitbucket.org/ultimatemember/maybe-load-assets/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       umda
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// if Ultimate member is not active, then return.
require_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( ! function_exists( 'is_plugin_active' ) || ! is_plugin_active( 'ultimate-member/ultimate-member.php' ) ) {
	return;
}

add_action( 'wp_print_footer_scripts', 'um_remove_scripts_and_styles', 9 );
add_action( 'wp_print_scripts', 'um_remove_scripts_and_styles', 9 );
add_action( 'wp_print_styles', 'um_remove_scripts_and_styles', 9 );
add_action( 'dynamic_sidebar', 'um_remove_scripts_and_styles_widget' );

/**
 * Maybe remove Ultimate Member CSS and JS
 *
 * @global WP_Post $post.
 * @global bool $um_load_assets.
 * @global WP_Scripts $wp_scripts.
 * @global WP_Styles $wp_styles.
 * @return NULL
 */
function um_remove_scripts_and_styles() {
	global $post, $um_load_assets, $wp_scripts, $wp_styles;

	// Set here IDs of the pages, that use Ultimate Member scripts and styles.
	$um_posts = array( 0 );

	// Set here URLs of the pages, that use Ultimate Member scripts and styles.
	$um_urls = array(
		'/account/',
		'/activity/',
		'/groups/',
		'/login/',
		'/logout/',
		'/members/',
		'/my-groups/',
		'/password-reset/',
		'/register/',
		'/user/',
		// '/speakers/', // Since this is a search/filter screen we don't need the UM assets.
		'/speakers/login',
		'/speakers/register',
	);

	if ( is_admin() || is_ultimatemember() ) {
		return;
	}

	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return false;
	}

	$request_uri = wp_unslash( $_SERVER['REQUEST_URI'] ); // WPCS: sanitization ok.

	if ( in_array( $request_uri, $um_urls ) ) {
		return;
	}
	foreach ( $um_urls as $key => $um_url ) {
		if ( strpos( $request_uri, $um_url ) !== false ) {
			return;
		}
	}

	if ( ! empty( $um_load_assets ) ) {
		return;
	}

	if ( isset( $post ) && is_a( $post, 'WP_Post' ) ) {
		if ( in_array( $post->ID, $um_posts ) ) {
			return;
		}
		if ( strpos( $post->post_content, '[ultimatemember_' ) !== false ) {
			return;
		}
		if ( strpos( $post->post_content, '[ultimatemember form_id' ) !== false ) {
			return;
		}
	}

	if ( empty( $wp_scripts->queue ) || empty( $wp_styles->queue ) ) {
		return;
	}

	foreach ( $wp_scripts->queue as $key => $script ) {
		if ( strpos( $script, 'um_' ) === 0 || strpos( $script, 'um-' ) === 0 || strpos( $wp_scripts->registered[ $script ]->src, '/ultimate-member/assets/' ) !== false ) {
			unset( $wp_scripts->queue[ $key ] );
		}
	}

	foreach ( $wp_styles->queue as $key => $style ) {
		if ( strpos( $style, 'um_' ) === 0 || strpos( $style, 'um-' ) === 0 || strpos( $wp_styles->registered[ $style ]->src, '/ultimate-member/assets/' ) !== false ) {
			unset( $wp_styles->queue[ $key ] );
		}
	}
}

/**
 * Check whether Ultimate Member widget was used
 *
 * @param array $widget Widget name.
 */
function um_remove_scripts_and_styles_widget( $widget ) {
	if ( strpos( $widget['id'], 'um_' ) === 0 || strpos( $widget['id'], 'um-' ) === 0 ) {
		$GLOBALS['um_load_assets'] = true;
	}
}

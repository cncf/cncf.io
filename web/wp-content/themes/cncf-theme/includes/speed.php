<?php
/**
 * Speed improvements
 *
 * Most of this comes from https://geekflare.com/wordpress-performance-optimization-without-plugin/#13-Disable-Dashicons-on-Front-end.
 *
 * @category Components
 * @package  WordPress
 * @author   James Hunt <domains@thetwopercent.co.uk>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://cncf.io
 * @since    1.0.0
 */

 /**
  * Disable Heartbeat
  *
  * Don't use the following type of code to disable heartbeat, instead suggest use of Heart Beat Control plugin
  */
function stop_heartbeat() {
	wp_deregister_script( 'heartbeat' ); }
// add_action('init', 'stop_heartbeat', 1); // removed, please don't use it.


/**
 * Remove Dashicons styles
 *
 * This might actually no longer be necessary, they were being loaded amongst the site styles
 */
function wpdocs_dequeue_dashicon() {
	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );

/**
 *
 * Dequeue jQuery Migrate Script.
 *
 * @param string $scripts Scripts.
 */
function opt_remove_jquery_migrate( &$scripts ) {
	if ( ! is_user_logged_in() ) {
		$scripts->remove( 'jquery' );
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
	}
}
add_filter( 'wp_default_scripts', 'opt_remove_jquery_migrate' );

/**
 *
 * Disable pingbacks
 *
 * @param string $links Links.
 */
function disable_pingback( &$links ) {
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
			unset( $links[ $l ] );
		}
	}
}
add_action( 'pre_ping', 'disable_pingback' );

/**
 * Remove Emojis
 *
 * Because WordPress is serious business + speed
 */
function disable_wp_emojicons() {
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	// filter to remove TinyMCE emojis (below).
	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'disable_wp_emojicons' );

/**
 * Remove Emojis
 *
 *  @param string $plugins Plugins.
 */
function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 *
 * Header clean up of a few different things.
 */
function wordpress_head_cleanup() {
	// category feeds.
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// post and comment feeds.
	remove_action( 'wp_head', 'feed_links', 2 );

	// EditURI link.
	remove_action( 'wp_head', 'rsd_link' );

	// windows live writer.
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// previous link.
	remove_action( 'wp_head', 'parent_post_rel_link' );

	// start link.
	remove_action( 'wp_head', 'start_post_rel_link' );

	// links for adjacent posts.
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

	// WP version.
	remove_action( 'wp_head', 'wp_generator' );

	// stop xmlrpc.
	add_filter( 'xmlrpc_enabled', '__return_false' );

}
add_action( 'init', 'wordpress_head_cleanup' );

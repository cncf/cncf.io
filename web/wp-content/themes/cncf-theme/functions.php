<?php
/**
 * Theme Functions
 *
 * Try to keep this file as clean as possible
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Theme Support functions
 *
 * Used to enable specific features of WordPress and other tools.
 */
function cncf_theme_support_setup() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );

	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Main Menu' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	// include custom image sizes.
	require_once 'includes/image-sizes.php';

	// include gutenberg setup.
	require_once 'includes/gutenberg-setup.php';

}
add_action( 'after_setup_theme', 'cncf_theme_support_setup' );

/**
 * Theme function classes
 *
 * Any additional functionality should be added in the classes folder and linked up below.
 */
global $enqueue;
global $image;
require 'classes/class-enqueue.php';
require 'classes/class-image.php';
$enqueue = new Enqueue();

/**
 * Includes (enable as appropriate)
 */

// development.
if ( WP_DEBUG === true ) {
	require_once 'includes/development.php';
}

// gutenberg settings.
require_once 'includes/gutenberg-options.php';

// speed improvements.
require_once 'includes/speed.php';

// admin & dashboard customisation.
require_once 'includes/admin-dashboard.php';

// post excerpts.
require_once 'includes/excerpts.php';

// gravity forms.
// require_once('includes/gravity.php'); // phpcs:ignore.

/* Will only run on front end of site */
if ( ! is_admin() ) {
	/**
	 * Make all JS defer onload apart from files specified.
	 *
	 * @param string $url the URL.
	 */
	function defer_parsing_of_js( $url ) {
		if ( false === strpos( $url, '.js' ) ) {
			return $url;
		}
		if ( strpos( $url, 'jquery.js' ) ) {
			return $url;
		}
		return str_replace( ' src', ' defer src', $url );
	}
	add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );
}

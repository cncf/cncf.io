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
  * Used to enable specific features of WordPress and other tools
  */
if ( ! function_exists( 'the_theme_support_setup' ) ) :
	/**
	 * Theme Support functions
	 */
	function the_theme_support_setup() {

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );

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

		register_nav_menus(
			array(
				'main-menu' => esc_html__( 'Main Menu' ),
			// 'secondary-menu' => esc_html__( 'Secondary Menu' ),
			// 'footer-menu' => esc_html__( 'The Footer Menu' )
			)
		);

	}
endif;
add_action( 'after_setup_theme', 'the_theme_support_setup' );

/**
 * Image Thumbnail Sizes
 *
 * Used to create new thumbnail sizes.
 */
add_action(
	'after_setup_theme',
	function () {
		// add_image_size('icon', 50, 50, true); // phpcs:ignore.
		// add_image_size('new-size', 215, 215, true); // phpcs:ignore.
	}
);

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

// gutenberg.
require_once 'includes/gutenberg.php';

// speed.
require_once 'includes/speed.php';

// gravity forms.
// require_once('includes/gravity.php'); // phpcs:ignore.

// dashboard.
require_once 'includes/admin-dashboard.php';

// pagination.
require_once 'includes/pagination.php';

// excerpts.
require_once 'includes/excerpts.php';


/**
 * Defer all JS except jquery.js
 *
 * @param string $url the URL.
 */
function defer_parsing_of_js( $url ) {
	if ( ! ( is_admin() ) ) {

		if ( false === strpos( $url, '.js' ) ) {
			return $url;
		}

		if ( strpos( $url, 'jquery.js' ) ) {
			return $url;
		}

		return str_replace( ' src', ' defer src', $url );
	}
}
// add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );


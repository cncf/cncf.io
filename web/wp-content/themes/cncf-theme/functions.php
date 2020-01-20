<?php
/**
 * WordPress THEME FUNCTIONS
 *
 * Try to keep this file as clean as possible
 */

 /**
  * Theme Support functions
  *
  * Used to enable specific features of WordPress and other toolS
  */
if ( ! function_exists( 'the_theme_support_setup' ) ) :

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
 * Used to create new thumbnail sizes
 */
// add_image_size('icon', 50, 50, true);
// add_image_size('new-size', 215, 215, true);

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

// theme support
// require_once 'includes/theme-support.php';

// development
require_once 'includes/development.php';



// gutenberg
require_once 'includes/gutenberg.php';

// speed
require_once 'includes/speed.php';

// ACF
// require_once('includes/acf.php');

// gravity forms
// require_once('includes/gravity.php');

// dashboard
// require_once('includes/admin-dashboard.php');

// mailchimp
// require_once('includes/mailchimp.php');

// pagination
// require_once('includes/pagination.php');

// excerpts
require_once 'includes/excerpts.php';


/**
 * Defer all JS except jquery.js
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
add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );

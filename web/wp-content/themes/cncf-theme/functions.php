<?php
/**
 * WordPress THEME FUNCTIONS
 *
 * Try to keep this file as clean as possible
 */


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

// development
require_once 'includes/development.php';

// theme support
require_once 'includes/theme-support.php';

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

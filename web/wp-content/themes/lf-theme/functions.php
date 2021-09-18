<?php
/**
 * Theme Functions
 *
 * Try to keep this file as clean as possible
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

/**
 * Theme Support functions
 *
 * Used to enable specific features of WordPress and other tools.
 */
function lf_theme_support_setup() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary' ),
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
add_action( 'after_setup_theme', 'lf_theme_support_setup' );

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

// gutenberg options.
require_once 'includes/gutenberg-options.php';

// post excerpts.
require_once 'includes/excerpts.php';

// speakers bureau.
require_once 'includes/speakers-bureau.php';

// speakers bureau bulk email form.
require_once 'classes/class-speakers-contact.php';

// speakers bureau export.
require_once 'classes/class-speakers-export.php';

// people shortcode.
require_once 'includes/shortcode-people.php';

// projects shortcode.
require_once 'includes/shortcode-projects.php';

// endusers shortcode.
require_once 'includes/shortcode-endusers.php';

// members shortcode.
require_once 'includes/shortcode-members.php';

// homepage case studies shortcode.
require_once 'includes/shortcode-home.php';

// Who we are metrics shortcode.
require_once 'includes/shortcode-whoweare-metrics.php';

// kubeweeklys shortcodes.
require_once 'includes/shortcode-kubeweeklys.php';

// Fuerza utils.
require_once 'classes/class-fuerza-utils.php';

// LF utils.
require_once 'classes/class-lf-utils.php';

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
		if ( strpos( $url, 'jquery-3.5.1' ) ) {
			return $url;
		}
		return str_replace( ' src', ' defer src', $url );
	}
	add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );
}

/**
 * The WP REST API is cached heavily by Pantheon so we need to explicitly exclude certain calls from the cache.
 * Modified from https://pantheon.io/docs/mu-plugin#wp-rest-api-wp-json-endpoints-cache and corrected according to
 * this issue https://github.com/LF-Engineering/lfevents/issues/662
 */
$regex_json_path_patterns = array(
	'#^/wp-json/post-meta-controls/v1/?#',
);
foreach ( $regex_json_path_patterns as $regex_json_path_pattern ) {
	if ( preg_match( $regex_json_path_pattern, $_SERVER['REQUEST_URI'] ) ) { //phpcs:ignore
		// re-use the rest_post_dispatch filter in the Pantheon page cache plugin.
		add_filter( 'rest_post_dispatch', 'filter_rest_post_dispatch_send_cache_control', 12, 2 );

		/**
		 * Re-define the send_header value with any custom Cache-Control header.
		 *
		 * @param obj $response Response object.
		 * @param obj $server Server object.
		 */
		function filter_rest_post_dispatch_send_cache_control( $response, $server ) {
			$response->header( 'Cache-Control', 'no-cache, must-revalidate, max-age=0' );
			return $response;
		}
		break;
	}
}

/**
 * Remove tags support from posts
 */
function lf_theme_unregister_tags() {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'lf_theme_unregister_tags' );

/**
 * Remove English words from Chinese case studies filters
 *
 * @param array $input_object Input Object.
 * @param int   $sfid ID of form.
 */
function filter_english( $input_object, $sfid ) {

	// if not the Chinese Case studies filters, then skip.
	if ( 8158 != $sfid ) {
		return $input_object;
	}

	foreach ( $input_object['options'] as $option ) {
		$option->label = preg_replace( '/(.+)(\(\D+\))(.+)/', '$1$3', $option->label );
	}

	return $input_object;
}
add_filter( 'sf_input_object_pre', 'filter_english', 10, 2 );

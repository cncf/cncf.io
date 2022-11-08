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
function lf_theme_support_setup() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );

	register_nav_menus(
		array(
			'about_01'          => esc_html__( 'About 1' ),
			'about_02'          => esc_html__( 'About 2' ),
			'projects_01'       => esc_html__( 'Projects 1' ),
			'projects_02'       => esc_html__( 'Projects 2' ),
			'certifications_01' => esc_html__( 'Certifications 1' ),
			'certifications_02' => esc_html__( 'Certifications 2' ),
			'community_01'      => esc_html__( 'Community 1' ),
			'community_02'      => esc_html__( 'Community 2' ),
			'community_03'      => esc_html__( 'Community 3' ),
			'blog_01'           => esc_html__( 'Blog 1' ),
			'blog_02'           => esc_html__( 'Blog 2' ),
			'footer_01'         => esc_html__( 'Footer 1' ),
			'footer_02'         => esc_html__( 'Footer 2' ),
			'footer_03'         => esc_html__( 'Footer 3' ),
			'footer_04'         => esc_html__( 'Footer 4' ),
			'footer_05'         => esc_html__( 'Footer 5' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	// include custom image sizes.
	require_once 'includes/image-sizes.php';

	// include gutenberg setup.
	require_once 'includes/gutenberg-setup.php';

}
add_action( 'after_setup_theme', 'lf_theme_support_setup' );

/**
 * Includes (enable as appropriate)
 */
require_once 'classes/class-lf-enqueue.php';

// development.
if ( WP_DEBUG === true ) {
	require_once 'includes/development.php';
}

// LF utils.
require_once 'classes/class-lf-utils.php';

// Advanced Custom Fields.
require_once 'includes/acf.php';

// WP REST API cache control.
require_once 'includes/rest-api-cache-control.php';

// Gutenberg options.
require_once 'includes/gutenberg-options.php';

// Post excerpts.
require_once 'includes/excerpts.php';

// Shortcodes.
require_once 'includes/shortcodes/benefits.php';
require_once 'includes/shortcodes/event-banner.php';
require_once 'includes/shortcodes/home.php';
require_once 'includes/shortcodes/kubeweeklys.php';
require_once 'includes/shortcodes/latest-news.php';
require_once 'includes/shortcodes/members.php';
require_once 'includes/shortcodes/metrics.php';
require_once 'includes/shortcodes/people.php';
require_once 'includes/shortcodes/price-table-cloud-credits.php';
require_once 'includes/shortcodes/price-table-end-users.php';
require_once 'includes/shortcodes/price-table-members.php';
require_once 'includes/shortcodes/projects.php';
require_once 'includes/shortcodes/projects-chart.php';
require_once 'includes/shortcodes/radars.php';
require_once 'includes/shortcodes/selected-people.php';
require_once 'includes/shortcodes/upcoming-webinars.php';
require_once 'includes/shortcodes/youtube-playlist.php';

/**
 * Make all JS defer onload apart from files specified.
 *
 * Use strpos to exclude specific files.
 *
 * @param string $url the URL.
 */
function lf_defer_parsing_of_js( $url ) {
	// Stop if admin.
	if ( is_admin() ) {
		return $url;
	}
	// Stop if not JS.
	if ( false === strpos( $url, '.js' ) ) {
		return $url;
	}
	// List of scripts that should not be deferred.
	$do_not_defer_scripts = array( 'jquery' );
	if ( ! is_front_page() && count( $do_not_defer_scripts ) > 0 ) {
		foreach ( $do_not_defer_scripts as $script ) {
			if ( strpos( $url, $script ) ) {
				return $url;
			}
		}
	}
	return str_replace( ' src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'lf_defer_parsing_of_js', 10, 3 );

/**
 * Remove English words from Chinese case studies filters
 *
 * @param array $input_object Input Object.
 * @param int   $sfid ID of form.
 */
function lf_filter_english( $input_object, $sfid ) {

	// if not the Chinese Case studies filters, then skip.
	if ( 8158 !== $sfid ) {
		return $input_object;
	}

	foreach ( $input_object['options'] as $option ) {
		$option->label = preg_replace( '/(.+)(\(\D+\))(.+)/', '$1$3', $option->label );
	}

	return $input_object;
}
add_filter( 'sf_input_object_pre', 'lf_filter_english', 10, 2 );

/**
 * Replace WordPress version appended to styles with filemtime.
 *
 * @param array $styles Styles.
 * @return void
 */
function lf_update_styles_with_filemtime( $styles ) {
	$styles->default_version = filemtime( get_template_directory() . '/style.css' );
}
add_action( 'wp_default_styles', 'lf_update_styles_with_filemtime' );
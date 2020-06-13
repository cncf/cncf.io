<?php
/**
 * Template Name: Tab Container Page
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Include the Tab Container Filter.
require_once dirname( __FILE__ ) . '/../includes/tab-container-filter.php';

get_template_part( 'components/header' );

get_template_part( 'components/hero' );

get_template_part( 'components/page-single' );

// Include the JS file.
wp_enqueue_script(
	'tab-container-js',
	get_stylesheet_directory_uri() . '/source/js/third-party/tab-container.js',
	is_admin() ? array( 'wp-editor' ) : array( 'jquery' ),
	filemtime( get_template_directory() . '/source/js/third-party/tab-container.js' ),
	true
);


get_template_part( 'components/footer' );


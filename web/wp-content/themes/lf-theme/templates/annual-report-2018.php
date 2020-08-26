<?php
/**
 * Template Name: Annual Report 2018
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

wp_enqueue_style( '2018', get_template_directory_uri() . '/build/annual-report-2018.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2018.min.css' ), 'all' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		 the_content();
	endwhile;
endif;

wp_enqueue_script(
	'annual-report-js',
	get_stylesheet_directory_uri() . '/source/js/third-party/annual-report.js',
	is_admin() ? array( 'wp-editor' ) : array( 'jquery' ),
	filemtime( get_template_directory() . '/source/js/third-party/annual-report.js' ),
	true
);

get_template_part( 'components/footer' );

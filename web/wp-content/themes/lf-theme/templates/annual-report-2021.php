<?php
/**
 * Template Name: Annual Report 2021
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

wp_enqueue_style( '2021', get_template_directory_uri() . '/build/annual-report-2021.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2021.min.css' ), 'all' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		the_content();
endwhile;
endif;

get_template_part( 'components/footer' );

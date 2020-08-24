<?php
/**
 * Template Name: Annual Report 2017
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

wp_enqueue_style( '2017', get_template_directory_uri() . '/images/annual-reports/2017/2017.css', array(), filemtime( get_template_directory() . '/images/annual-reports/2017/2017.css' ), 'all' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		 the_content();
	endwhile;
endif;

get_template_part( 'components/footer' );

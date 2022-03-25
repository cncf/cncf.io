<?php
/**
 * Template Name: Annual Report 2019
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2019.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

	<?php

	wp_enqueue_style( '2019', get_template_directory_uri() . '/build/annual-report-2019.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2019.min.css' ), 'all' );

	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
	endwhile;
endif;

	wp_enqueue_script(
		'annual-report-js',
		get_stylesheet_directory_uri() . '/source/js/on-demand/annual-report-pre-2020.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/source/js/on-demand/annual-report-pre-2020.js' ),
		true
	);

	get_template_part( 'components/footer' );

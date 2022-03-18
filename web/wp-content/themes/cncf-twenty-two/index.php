<?php
/**
 * Default posts index
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'components/header' );

while ( have_posts() ) :
	the_post();
	the_content();
endwhile;

get_template_part( 'components/footer' );

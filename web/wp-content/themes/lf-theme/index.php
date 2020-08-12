<?php
/**
 * Default posts index
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'components/header' );

get_template_part( 'components/hero' );

get_template_part( 'components/post-loop' );

get_template_part( 'components/pagination' );

get_template_part( 'components/footer' );

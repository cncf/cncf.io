<?php
/**
 * Default index
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

if ( is_404() ) {
	get_template_part( 'components/404' );
} elseif ( is_search() ) {
	get_template_part( 'components/search' );
} else {
	// default archive view.
	get_template_part( 'components/title' );
	get_template_part( 'components/post-archive' );

}

get_template_part( 'components/footer' );

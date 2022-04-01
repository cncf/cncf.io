<?php
/**
 * Default index
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

 // phpcs:ignoreFile

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'components/header' );

// if ( is_home() ) {
// 	get_template_part( 'components/home' );
// } else if ( is_single() ) {
// 	get_template_part( 'components/post' );
// } else if ( is_page() ) {
// 	get_template_part( 'components/page' );
// } else if ( is_archive() ) {
// 	get_template_part( 'components/archive' );
// } else if ( is_search() ) {
// 	get_template_part( 'components/search' );
// } else
if ( is_404() ) {
	get_template_part( 'components/404' );
}
else { // TODO: Else Home in final fix.
	get_template_part( 'components/page' );
}



get_template_part( 'components/footer' );

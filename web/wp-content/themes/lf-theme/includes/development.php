<?php
/**
 * Development functions
 *
 * Add functions and utilities here to help with development.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

/**
 * Debug
 *
 * @param variable $var Add variable to print out.
 */
function r( $var ) {
	echo '<pre>';
	print_r( $var );
	echo '</pre>';
}

/**
 * Change navigation bar colour for version in debug/local
 */
function change_adminbar_colors() {
	$change_adminbar_colors = '<style type="text/css">
        #wpadminbar { background-color:#12881D; }
    </style>';
	echo $change_adminbar_colors; // phpcs:ignore
}
add_action( 'admin_head', 'change_adminbar_colors' );
add_action( 'wp_head', 'change_adminbar_colors' );

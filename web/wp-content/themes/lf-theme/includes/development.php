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

<?php
/**
 * Development functions
 *
 * Add functions and utilities here to help with development.
 *
 * @package WordPress
 * @subpackage cncf-theme
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

if ( ! function_exists( 'write_log' ) ) {
	/**
	 * Write Log
	 *
	 * @param string $log Variable.
	 * @return void
	 */
	function cncf_log( $log ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) );
		} else {
			error_log( $log );
		}
	}
}

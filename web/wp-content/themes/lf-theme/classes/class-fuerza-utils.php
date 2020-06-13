<?php
/**
 * Util functions written by Fuerza brough over from old site.
 *
 * @category Components
 * @package  WordPress
 * @author   Fuerza
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://cncf.io
 * @since    1.0.0
 */

/**
 * Fuerza_Utils class.
 */
class Fuerza_Utils {

	/**
	 * Request.
	 *
	 * @param int    $type Type.
	 * @param string $name Name.
	 * @param string $default Default.
	 * @param string $sanitize Sanitize.
	 */
	public static function request( $type, $name, $default, $sanitize = 'rm_tags' ) {
		$request = filter_input_array( $type, FILTER_SANITIZE_SPECIAL_CHARS );

		if ( ! isset( $request[ $name ] ) || empty( $request[ $name ] ) ) {
			return $default;
		}

		return self::sanitize( $request[ $name ], $sanitize );
	}

	/**
	 * Post.
	 *
	 * @param string $name Name.
	 * @param string $default Default.
	 * @param string $sanitize Sanitize.
	 */
	public static function post( $name, $default = '', $sanitize = 'rm_tags' ) {
		return self::request( INPUT_POST, $name, $default, $sanitize );
	}

	/**
	 * Get.
	 *
	 * @param string $name Name.
	 * @param string $default Default.
	 * @param string $sanitize Sanitize.
	 */
	public static function get( $name, $default = '', $sanitize = 'rm_tags' ) {
		return self::request( INPUT_GET, $name, $default, $sanitize );
	}

	/**
	 * Sanitize.
	 *
	 * @param string $value Value.
	 * @param string $sanitize Sanitize.
	 */
	public static function sanitize( $value, $sanitize ) {
		if ( ! is_callable( $sanitize ) ) {
			return ( false === $sanitize ) ? $value : self::rm_tags( $value );
		}

		if ( is_array( $value ) ) {
			return array_map( $sanitize, $value );
		}

		return call_user_func( $sanitize, $value );
	}

	/**
	 * RM Tags.
	 *
	 * @param string  $value Value.
	 * @param boolean $remove_breaks Remove.
	 */
	public static function rm_tags( $value, $remove_breaks = false ) {
		if ( empty( $value ) || is_object( $value ) ) {
			return $value;
		}

		if ( is_array( $value ) ) {
			return array_map( __METHOD__, $value );
		}

		return wp_strip_all_tags( $value, $remove_breaks );
	}

	/**
	 * Is request ajax?
	 */
	public static function is_request_ajax() {
		if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
			$request_ajax = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_REQUESTED_WITH'] ) );
		}

		return ( ! empty( $request_ajax ) && strtolower( $request_ajax ) == 'xmlhttprequest' );
	}
}

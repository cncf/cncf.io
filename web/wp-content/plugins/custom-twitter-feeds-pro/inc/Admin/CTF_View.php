<?php
/**
 * Class CFF_View
 *
 * This class loads view page template files on the admin dashboard area.
 *
 * @since 2.0
 */
namespace TwitterFeed\Admin;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CTF_View {

	/**
	 * Base file path of the templates
     *
     * @since 2.0
	 */
	const BASE_PATH = CTF_PLUGIN_DIR . 'admin/views/';

	public function __construct() {
	}

	/**
	 * Render template
	 *
	 * @param string $file
	 * @param array $data
     *
     * @since 2.0
	 */
	public static function render( $file, $data = array() ) {
		$file = str_replace( '.', '/', $file );
		$file = self::BASE_PATH . $file . '.php';

		if ( file_exists( $file ) ) {
            if ( $data !== null && ! empty( $data ) ) extract( $data );
			include_once $file;
		}
	}
}
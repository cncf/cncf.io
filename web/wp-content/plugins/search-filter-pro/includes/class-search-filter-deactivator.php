<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://searchandfilter.com
 * @since      1.0.0
 *
 * @package
 * @subpackage
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		Search_Filter_Admin_License_Server::deactivate();
		Search_Filter_Remote_Notices::deactivate();
	}

}

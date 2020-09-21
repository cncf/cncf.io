<?php
/**
 * WordPress Admin & Dashboard modifications.
 *
 * Plugin Name: LF Admin & Dashboard Modifications
 * Plugin URI: https://github.com/cncf/cncf.io
 * Description: Modifies the dashboard in the admin.
 * Author: James Hunt
 * Author URI: https://cncf.io
 * Version: 0.1
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wp-no-base-permalink
 *
 * @package WordPress
 * @subpackage lf-mu
 */

 /**
  * Include the LF Admin Dashboard modifications.
  */
if ( file_exists( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-admin-dashboard.php' ) ) {
	require WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-admin-dashboard.php';
}

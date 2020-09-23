<?php
/**
 *
 * Removes category or tag base from permalinks.
 *
 * Plugin Name: WP No Base Permalink
 * Description: Removes category base or tag base (optional) from your category or tag permalinks and removes parents categories from your category permalinks (optional). Forked from https://wordpress.org/plugins/wp-no-base-permalink/ by Sergio ( kallookoo ).
 * Author: James Hunt
 * Author URI: https://www.cncf.io
 * Version: 9.9
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: lf-mu
 *
 * @package WordPress
 * @subpackage lf-mu
 */

/**
 * Include the No Base Permalink plugin
 */
if ( file_exists( WPMU_PLUGIN_DIR . '/wp-mu-plugins/wp-no-base-permalink.php' ) ) {
	require WPMU_PLUGIN_DIR . '/wp-mu-plugins/wp-no-base-permalink.php';
}

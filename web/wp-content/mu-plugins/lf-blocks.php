<?php
/**
 * Core blocks for running the cncf.io site.
 *
 * Plugin Name: LF Blocks
 * Plugin URI: https://github.com/cncf/cncf.io
 * Description: Various blocks for use on the cncf.io site.
 * Author: James Hunt
 * Author URI: https://www.cncf.io
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: lf-mu
 *
 * @package WordPress
 * @subpackage lf-mu
 */

/**
 * Include the LF Blocks plugin
 */
if ( file_exists( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/plugin.php' ) ) {
	require WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/plugin.php';
}

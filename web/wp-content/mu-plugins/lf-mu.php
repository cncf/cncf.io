<?php
/**
 * Core functionality for running the cncf.io site.
 *
 * Plugin Name: LF MU
 * Plugin URI:  https://github.com/cncf/cncf.io
 * Description: Core functionality for running the cncf.io site.
 * Author: Chris Abraham, James Hunt
 * Author URI:  https://www.cncf.io
 * Version: 1.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: lf-mu
 *
 * @package WordPress
 * @subpackage lf-mu
 */

/**
 * Include the LF MU plugin
 */
if ( file_exists( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-mu/lf-mu.php' ) ) {
	require WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-mu/lf-mu.php';
}

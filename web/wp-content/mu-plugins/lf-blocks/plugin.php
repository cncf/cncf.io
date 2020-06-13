<?php
/**
 * Plugin Name: LF Blocks
 * Plugin URI: https://www.cncf.io
 * Description: Various blocks for use on the CNCF.io site.
 * Author: James Hunt
 * Author URI: https://www.cncf.io
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package lf-blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require plugin_dir_path( __FILE__ ) . 'src/init.php';

<?php
/**
 * Plugin Name: LF Pre-Publish Checklists
 * Plugin URI: https://www.cncf.io
 * Description: Launch pre-publish checks in Block Editor.
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
if ( file_exists( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-pre-publish/init.php' ) ) {
	require WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-pre-publish/init.php';
}

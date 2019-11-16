<?php
/**
 * Plugin Name: Tab Container Block
 * Plugin URI: https://github.com/LF-Engineering/lfevents/tree/master/web/wp-content/plugins/tab-container-block
 * Description: This is a custom container block that is intended to be used to generate a tabbed interface.
 * Author: cjyabraham
 * Version: 0.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

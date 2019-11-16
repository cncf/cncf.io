<?php
/**
 * Plugin Name: Sponsors Block
 * Plugin URI: https://github.com/LF-Engineering/lfevents/tree/master/web/wp-content/plugins/sponsors-block
 * Description: Gutenberg block which allows for insertion of a gallery of sponsor logos that link to the sponsor home page.  This block is a fork of the regular Gutenberg Gallery block.
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

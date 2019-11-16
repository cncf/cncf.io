<?php
/**
 * Plugin Name: Pricing Block
 * Plugin URI: https://github.com/LF-Engineering/lfevents/tree/master/web/wp-content/plugins/pricing-block
 * Description: Gutenberg block which inserts a pricing table which dynamically updates "Expired" notices with the date.
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

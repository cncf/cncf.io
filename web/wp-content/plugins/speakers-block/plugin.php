<?php
/**
 * Plugin Name: Speakers Block
 * Plugin URI: https://github.com/LF-Engineering/lfevents/tree/master/web/wp-content/plugins/speakers-block
 * Description: Gutenberg block which allows for insertion of a Speakers showcase in a page/post. It requires an existing Speakers CPT already setup <a href="https://github.com/LF-Engineering/lfevents/blob/master/web/wp-content/mu-plugins/custom/lfevents/admin/class-lfevents-admin.php#L154">here</a>.
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

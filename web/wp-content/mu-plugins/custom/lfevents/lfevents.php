<?php
/**
 * Core functionality for running the LFEvents site.
 *
 * This plugin contains the core functionality that runs the LFEvents site.  It is a must-have plugin so will always be loaded despite which theme is selected.
 *
 * @link              https://events.linuxfoundation.org/
 * @since             1.0.0
 * @package           LFEvents
 *
 * @wordpress-plugin
 * Plugin Name:       LFEvents
 * Plugin URI:        https://github.com/LF-Engineering/lfevents
 * Description:       Core functionality for running the LFEvents site.
 * Version:           1.0.0
 * Author:            Chris Abraham
 * Author URI:        https://www.linuxfoundation.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lfevents
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LFEVENTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lfevents-activator.php
 */
function activate_lfevents() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lfevents-activator.php';
	LFEvents_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lfevents-deactivator.php
 */
function deactivate_lfevents() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lfevents-deactivator.php';
	LFEvents_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lfevents' );
register_deactivation_hook( __FILE__, 'deactivate_lfevents' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lfevents.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lfevents() {

	$plugin = new LFEvents();
	$plugin->run();

}
run_lfevents();


/**
 * Gets all post types currently used for LFEvents.
 *
 * @return array
 */
function lfe_get_post_types() {
	$post_types   = [ 'page' ];
	$current_year = date( 'Y' );

	for ( $x = 2017; $x <= $current_year; $x++ ) {
		$post_types[] = 'lfevent' . $x;
	}
	return $post_types;
}

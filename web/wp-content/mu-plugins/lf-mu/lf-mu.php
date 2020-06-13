<?php
/**
 * Core functionality for running the cncf.io site.
 *
 * @link              https://cncf.io/
 * @since             1.0.0
 * @package           lfmu
 *
 * @wordpress-plugin
 * Plugin Name:       LF MU
 * Plugin URI:        https://github.com/cncf/cncf.io
 * Description:       Core functionality for running the cncf.io site.
 * Version:           1.1.0
 * Author:            Chris Abraham, James Hunt
 * Author URI:        https://www.cncf.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lf-mu
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LF_MU_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lf-mu-activator.php
 */
function activate_lf_mu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lf-mu-activator.php';
	Lf_Mu_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lf-mu-deactivator.php
 */
function deactivate_lf_mu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lf-mu-deactivator.php';
	Lf_Mu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lf_mu' );
register_deactivation_hook( __FILE__, 'deactivate_lf_mu' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lf-mu.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lf_mu() {

	$plugin = new Lf_Mu();
	$plugin->run();

}
run_lf_mu();

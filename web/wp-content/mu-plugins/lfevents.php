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

/**
 * Include the lfevents plugin
 */
require WPMU_PLUGIN_DIR . '/custom/lfevents/lfevents.php';

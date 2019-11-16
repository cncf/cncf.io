<?php
/**
 * @wordpress-plugin
 * Plugin Name: Gravity Forms + Salesforce: API
 * Plugin URI: https://gravityplus.pro/gravity-forms-salesforce
 * Description: Integrate Gravity Forms with Salesforce
 * Version: 1.6.0.dev4
 * Author: gravity+
 * Author URI: https://gravityplus.pro
 * Text Domain: gravityformssalesforce
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package   GFP_Salesforce
 * @version   1.6.0
 * @author    gravity+ <support@gravityplus.pro>
 * @license   GPL-2.0+
 * @link      https://gravityplus.pro
 * @copyright 2017-2019 gravity+
 *
 * last updated: May 13, 2019
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {

	die;

}

define( 'GFP_SALESFORCE_CURRENT_VERSION', '1.6.0.dev4' );

define( 'GFP_SALESFORCE_FILE', __FILE__ );

define( 'GFP_SALESFORCE_PATH', plugin_dir_path( __FILE__ ) );

define( 'GFP_SALESFORCE_URL', plugin_dir_url( __FILE__ ) );

define( 'GFP_SALESFORCE_SLUG', plugin_basename( dirname( __FILE__ ) ) );

//Load all of the necessary class files for the plugin
require_once( 'includes/class-loader.php' );

GFP_Salesforce_Loader::load();

$gravityformssalesforce = new GFP_Salesforce();

$gravityformssalesforce->run();
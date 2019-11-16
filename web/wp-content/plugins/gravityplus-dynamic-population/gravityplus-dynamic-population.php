<?php
/**
 * @wordpress-plugin
 * Plugin Name: Gravity Forms Dynamic Population Pro
 * Plugin URI: https://gravityplus.pro/gravity-forms-dynamic-population
 * Description: Dynamically populate your form fields with custom data
 * Version: 2.2.0.dev3
 * Author: gravity+
 * Author URI: https://gravityplus.pro
 * Text Domain: gravityplus-dynamic-population
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
 * @package   GFP_Dynamic_Population
 * @version   2.2.0
 * @author    gravity+ <support@gravityplus.pro>
 * @license   GPL-2.0+
 * @link      https://gravityplus.pro
 * @copyright 2014-2019 gravity+
 *
 * last updated: March 6, 2019
 */


define( 'GFP_DYNAMIC_POPULATION_FILE', __FILE__ );

define( 'GFP_DYNAMIC_POPULATION_PATH', plugin_dir_path( __FILE__ ) );

define( 'GFP_DYNAMIC_POPULATION_URL', plugin_dir_url( __FILE__ ) );

/**
 * Plugin version, used for cache-busting of style and script file references.
 *
 * @since   1.3.0
 */
define( 'GFP_DYNAMIC_POPULATION_CURRENT_VERSION', '2.2.0.dev3' );

/**
 * Unique identifier
 *
 * @since 2.0.0
 */
define( 'GFP_DYNAMIC_POPULATION_SLUG', plugin_basename( dirname( __FILE__ ) ) );

require_once( 'includes/class-loader.php' );
GFP_Dynamic_Population_Loader::load();


$gfp_dynamic_population = new GFP_Dynamic_Population();

$gfp_dynamic_population->run();
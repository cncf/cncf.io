<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 *
 * @wordpress-plugin
 * Plugin Name:       Search & Filter Pro
 * Plugin URI:        https://searchandfilter.com
 * Description:       Search & Filtering for posts, products and custom posts. Allow your users to Search & Filter by categories, tags, taxonomies, custom fields, post meta, post dates, post types and authors.
 * Version:           2.5.12
 * Author:            Code Amp
 * Author URI:        http://www.codeamp.com
 * Text Domain:       search-filter
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SEARCH_FILTER_DEBUG' ) ) {
	define('SEARCH_FILTER_DEBUG', false);
}
if ( ! defined( 'SEARCH_FILTER_QUERY_DEBUG' ) ) {
	define('SEARCH_FILTER_QUERY_DEBUG', false);
}

if ( ! defined( 'SEARCH_FILTER_VERSION' ) ) {
	define('SEARCH_FILTER_VERSION', "2.5.12");
}

if ( ! defined( 'SEARCH_FILTER_PRO_BASE_PATH' ) ) {
	define('SEARCH_FILTER_PRO_BASE_PATH', __FILE__);
}

if ( ! function_exists( 'sf_write_log' ) ) {
	function sf_write_log( $log, $error_log = true ) {
		if ( true == SEARCH_FILTER_DEBUG ) {
			if ( $error_log ) {
				if ( is_array( $log ) || is_object( $log ) ) {
					ob_start();
					var_dump($log);
					$output = ob_get_clean();
					error_log( $output );
				} else {
					error_log( $log );
				}
			}
			else {
				$debug_file = WP_CONTENT_DIR."/debug.log";
				$output = '';
				if ( is_array( $log ) || is_object( $log ) ) {
					ob_start();
					var_dump($log);
					$output = ob_get_clean();
				}
				file_put_contents($debug_file, $output, FILE_APPEND | LOCK_EX);
			}
		}
	}
}

if (!function_exists('array_replace'))
{
	function array_replace()
	{
		$array=array();
		$n=func_num_args();
		while ($n-- >0)
		{
			$array+=func_get_arg($n);
		}
		return $array;
	}
}

if (!function_exists('array_replace_recursive'))
{
	function array_replace_recursive($array, $array1)
	{
		if (!function_exists('search_filter_php_recurse'))
		{
			function search_filter_php_recurse($array, $array1)
			{
				foreach ($array1 as $key => $value)
				{
					// create new key in $array, if it is empty or not an array
					if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key])))
					{
						$array[$key] = array();
					}

					// overwrite the value in the base array
					if (is_array($value))
					{
						$value = search_filter_php_recurse($array[$key], $value);
					}
					$array[$key] = $value;
				}
				return $array;
			}
		}

		// handle the arguments, merge one by one
		$args = func_get_args();
		$array = $args[0];

		if (!is_array($array))
		{
			return $array;
		}

		for ($i = 1; $i < count($args); $i++)
		{
			if (is_array($args[$i]))
			{
				$array = search_filter_php_recurse($array, $args[$i]);
			}
		}

		return $array;
	}
}
/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/


/**
 * The code that runs during plugin activation.
 */
function activate_search_filter($network_wide) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-activator.php';

	$search_filter_activator = new Search_Filter_Activator;  // correct
	$search_filter_activator->activate($network_wide);
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_search_filter($network_wide) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-deactivator.php';
	Search_Filter_Deactivator::deactivate($network_wide);
}

register_activation_hook( __FILE__, 'activate_search_filter' );
register_deactivation_hook( __FILE__, 'deactivate_search_filter' );

if ( ( ! is_admin() ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) )
{
    require_once( plugin_dir_path( __FILE__ ) . 'public/class-search-filter.php' );
    add_action( 'plugins_loaded', array( 'Search_Filter', 'get_instance' ) );
}


/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/
if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-search-filter-admin.php' );
	add_action( 'plugins_loaded', array( 'Search_Filter_Admin', 'get_instance' ) );
}

if ( ! class_exists( 'Search_Filter_Register_Widget' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-register-widget.php' );
}
if ( ! class_exists( 'Search_Filter_Post_Cache' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-post-cache.php' );
}

if ( ! class_exists( 'Search_Filter_Wp_Cache' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-wp-cache.php' );
}
if ( ! class_exists( 'Search_Filter_Wp_Data' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-wp-data.php' );
}
if ( ! class_exists( 'Search_Filter_Helper' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-helper.php' );
}
if ( ! class_exists( 'Search_Filter_Shared' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-shared.php' );
}
if ( ! class_exists( 'Search_Filter_Third_Party' ) )
{
    require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-third-party.php' );
}


if (!defined('SF_FPRE'))
{
    define('SF_FPRE', '_sf_');
}
if (!defined('SF_TAX_PRE'))
{
    define('SF_TAX_PRE', '_sft_');
}
if (!defined('SF_META_PRE'))
{
    define('SF_META_PRE', '_sfm_');
}
if (!defined('SF_CLASS_PRE'))
{
    define('SF_CLASS_PRE', 'sf-');
}
if (!defined('SF_INPUT_ID_PRE'))
{
    define('SF_INPUT_ID_PRE', 'sf');
}
if (!defined('SF_FIELD_CLASS_PRE'))
{
    define('SF_FIELD_CLASS_PRE', SF_CLASS_PRE."field-");
}
if (!defined('SF_ITEM_CLASS_PRE'))
{
    define('SF_ITEM_CLASS_PRE', SF_CLASS_PRE."item-");
}

global $search_filter_post_cache; //should be singleton
$search_filter_post_cache = new Search_Filter_Post_Cache();

global $search_filter_third_party; //should be singleton
$search_filter_third_party = new Search_Filter_Third_Party();

global $search_filter_shared; //should be singleton
$search_filter_shared = new Search_Filter_Shared();

if(true === SEARCH_FILTER_DEBUG) {
	global $search_filter_session;
	$search_filter_session = rand( 1000, 100000 );
}


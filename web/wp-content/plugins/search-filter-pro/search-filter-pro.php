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
 * Version:           2.5.21
 * Author:            Code Amp
 * Author URI:        http://www.codeamp.com
 * Developer:         Code Amp
 * Developer URI:     http://www.codeamp.com
 * Text Domain:       search-filter
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://searchandfilter.com
 * Domain Path:       /languages
 * 
 * WC requires at least: 8.1
 * WC tested up to: 9.7
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SEARCH_FILTER_DEBUG' ) ) {
	define( 'SEARCH_FILTER_DEBUG', false );
}
if ( ! defined( 'SEARCH_FILTER_QUERY_DEBUG' ) ) {
	define( 'SEARCH_FILTER_QUERY_DEBUG', false );
}

if ( ! defined( 'SEARCH_FILTER_VERSION' ) ) {
	define( 'SEARCH_FILTER_VERSION', '2.5.21' );
}

if ( ! defined( 'SEARCH_FILTER_PRO_BASE_PATH' ) ) {
	define( 'SEARCH_FILTER_PRO_BASE_PATH', __FILE__ );
}

if ( ! class_exists( 'Search_Filter_Admin_License_Server' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/includes/class-search-filter-admin-license-server.php';
}

// Check to make sure we can connect to the S&F update servers.
Search_Filter_Admin_License_Server::init();

if ( ! class_exists( 'Search_Filter_Remote_Notices' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/includes/class-search-filter-remote-notices.php';
}

Search_Filter_Remote_Notices::init();
/*
----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/**
 * The code that runs during plugin activation.
 */
function activate_search_filter( $network_wide ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-activator.php';

	$search_filter_activator = new Search_Filter_Activator();  // correct
	$search_filter_activator->activate( $network_wide );
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_search_filter( $network_wide ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-deactivator.php';
	Search_Filter_Deactivator::deactivate( $network_wide );
}

register_activation_hook( __FILE__, 'activate_search_filter' );
register_deactivation_hook( __FILE__, 'deactivate_search_filter' );

if ( ( ! is_admin() ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'public/class-search-filter.php';
	add_action( 'plugins_loaded', array( 'Search_Filter', 'get_instance' ) );
}


/*
----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/
if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/class-search-filter-admin.php';
	add_action( 'plugins_loaded', array( 'Search_Filter_Admin', 'get_instance' ) );
}

if ( ! class_exists( 'Search_Filter_Register_Widget' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-register-widget.php';
}
if ( ! class_exists( 'Search_Filter_Post_Cache' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-post-cache.php';
}

if ( ! class_exists( 'Search_Filter_Wp_Cache' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-wp-cache.php';
}
if ( ! class_exists( 'Search_Filter_Wp_Data' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-wp-data.php';
}
if ( ! class_exists( 'Search_Filter_Helper' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-helper.php';
}
if ( ! class_exists( 'Search_Filter_Shared' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-shared.php';
}
if ( ! class_exists( 'Search_Filter_Third_Party' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-third-party.php';
}


if ( ! defined( 'SF_FPRE' ) ) {
	define( 'SF_FPRE', '_sf_' );
}
if ( ! defined( 'SF_TAX_PRE' ) ) {
	define( 'SF_TAX_PRE', '_sft_' );
}
if ( ! defined( 'SF_META_PRE' ) ) {
	define( 'SF_META_PRE', '_sfm_' );
}
if ( ! defined( 'SF_CLASS_PRE' ) ) {
	define( 'SF_CLASS_PRE', 'sf-' );
}
if ( ! defined( 'SF_INPUT_ID_PRE' ) ) {
	define( 'SF_INPUT_ID_PRE', 'sf' );
}
if ( ! defined( 'SF_FIELD_CLASS_PRE' ) ) {
	define( 'SF_FIELD_CLASS_PRE', SF_CLASS_PRE . 'field-' );
}
if ( ! defined( 'SF_ITEM_CLASS_PRE' ) ) {
	define( 'SF_ITEM_CLASS_PRE', SF_CLASS_PRE . 'item-' );
}

global $search_filter_post_cache;
$search_filter_post_cache = new Search_Filter_Post_Cache();

global $search_filter_third_party;
$search_filter_third_party = new Search_Filter_Third_Party();

global $search_filter_shared;
$search_filter_shared = new Search_Filter_Shared();


/**
 * Add compatibility with WooCommerce Custom Order Tables.
 * 
 * We don't actually do anything with the order tables, but without this users cannot use
 * custom order tables.  The alternative is to remove the WC tested upto version from the
 * plugin readme.
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );
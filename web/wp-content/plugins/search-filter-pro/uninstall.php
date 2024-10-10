<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
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
global $wpdb;

if ( is_multisite() ) {
	// store the current blog id
    $current_blog = $wpdb->blogid;
    
    // Get all blogs in the network and activate plugin on each one
    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
    foreach ( $blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );
        uninstall_search_filter_pro();
        restore_current_blog();
    }

}
else
{

	//check for existence of caching database, if not install it
	uninstall_search_filter_pro();
}

function uninstall_search_filter_pro()
{	

	global $wpdb;

    $remove_all_data = Search_Filter_Helper::get_option( 'remove_all_data' );

    if($remove_all_data == 1) {

        delete_option( "search-filter-cache" );
        delete_option( 'search_filter_cache_speed' );
        delete_option( 'search_filter_cache_use_manual' );
        delete_option( 'search_filter_cache_use_background_processes' );
        delete_option( 'search_filter_cache_use_transients' );
        delete_option( 'search_filter_load_jquery_i18n' );
        delete_option( 'search_filter_lazy_load_js' );
        delete_option( 'search_filter_load_js_css' );
        delete_option( 'search_filter_combobox_script' );
        delete_option( 'search_filter_remove_all_data' );

        $cache_table_name = $wpdb->prefix . 'search_filter_cache';
        $term_results_table_name = $wpdb->prefix . 'search_filter_term_results';

        $wpdb->query("DROP TABLE IF EXISTS $cache_table_name");
        $wpdb->query("DROP TABLE IF EXISTS $term_results_table_name");

        $post_status = array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash');

        $search_form_query = new WP_Query('post_type=search-filter-widget&post_status=' . implode(",", $post_status) . '&posts_per_page=-1');
        $search_forms = $search_form_query->get_posts();
        foreach ($search_forms as $search_form) {
            wp_delete_post($search_form->ID, true);
        }

	    Search_Filter_Wp_Cache::purge_all_transients();
    }

	// flush rewrite rules in order to remove the rewrite rule
	global $wp_rewrite;
	$wp_rewrite->flush_rules();

}


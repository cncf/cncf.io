<?php

/**
 * Fired during plugin activation
 *
 * @link       https://searchandfilter.com
 * @since      1.0.0
 *
 * @package
 * @subpackage
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'wp_initialize_site', array( $this, 'init_new_site_dbs' ) );
	}

	public function init_new_site_dbs( $new_site ) {
		if ( is_a( $new_site, 'WP_Site' ) ) {
			if ( is_plugin_active_for_network( 'search-filter-pro/search-filter-pro.php' ) )
			{
				switch_to_blog( $new_site->blog_id );
				$this->db_install();
				restore_current_blog();
			}
		}
	}
	public function activate($network_wide) {
		
		global $wpdb;

		if ( is_multisite() && $network_wide ) {
			// store the current blog id
	        $current_blog = $wpdb->blogid;
	        
	        // Get all blogs in the network and activate plugin on each one
	        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	        foreach ( $blog_ids as $blog_id ) {
	            switch_to_blog( $blog_id );
	            $this->db_install();
	            restore_current_blog();
	        }

		}
		else
		{

			//check for existence of caching database, if not install it
			$this->db_install();
		}
	}

	function db_install() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'search_filter_cache';

		$charset_collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			$charset_collate = $wpdb->get_charset_collate();
		}

		$sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			post_id bigint(20) NOT NULL,
			post_parent_id bigint(20) NOT NULL,
			field_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			field_parent_num bigint(20) NULL,
			term_parent_id bigint(20) NULL,
			PRIMARY KEY  (id),
            KEY sf_c_field_name_index (field_name(32)),
            KEY sf_c_field_value_index (field_value(32)),
            KEY sf_c_field_value_num_index (field_value_num)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'search_filter_term_results';


		$sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			field_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			result_ids mediumtext NOT NULL,
			PRIMARY KEY  (id),
            KEY sf_tr_field_name_index (field_name(32)),
            KEY sf_tr_field_value_index (field_value(32)),
            KEY sf_tr_field_value_num_index (field_value_num)

		) $charset_collate;";


		dbDelta( $sql );
	}
}

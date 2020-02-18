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


class Search_Filter_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'wpmu_new_blog', array($this, 'on_create_blog'), 10, 6 );
	}

	public function on_create_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta )
	{
		if ( is_plugin_active_for_network( 'search-filter-pro/search-filter-pro.php' ) )
		{
			switch_to_blog( $blog_id );
			$this->db_install();
			restore_current_blog();
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
		//global $jal_db_version;

		$table_name = $wpdb->prefix . 'search_filter_cache';
		
		$charset_collate = $wpdb->get_charset_collate();

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
            KEY field_name_index (field_name),
            KEY field_value_index (field_value),
            KEY field_value_num_index (field_value_num)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		//add_option( 'jal_db_version', $jal_db_version );
		
		
		$table_name = $wpdb->prefix . 'search_filter_term_results';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			field_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			result_ids mediumtext NOT NULL,
			PRIMARY KEY  (id),
            KEY field_name_index (field_name),
            KEY field_value_index (field_value),
            KEY field_value_num_index (field_value)
			
		) $charset_collate;";
		
		
		dbDelta( $sql );
	}
}

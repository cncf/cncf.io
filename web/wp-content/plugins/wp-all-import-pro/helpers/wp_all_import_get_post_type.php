<?php
if ( ! function_exists( 'wp_all_import_get_import_post_type' ) ) {
    function wp_all_import_get_import_post_type( $import_id = 'new' ) {
        $custom_type = false;
        // Declaring $wpdb as global to access database
        global $wpdb;
        if ( $import_id == 'new' ) {
            // Attempt to get import ID
            $import_id = wp_all_import_get_import_id();
        }
        
        // Get values from import data table
        $imports_table = $wpdb->prefix . 'pmxi_imports';
    
        // Get import session from database based on import ID or 'new'
        $import_options = $wpdb->get_row( $wpdb->prepare("SELECT options FROM $imports_table WHERE id = %d", $import_id), ARRAY_A );
    
        // If this is an existing import load the custom post type from the array
        if ( ! empty($import_options) )	{
            $import_options_arr = unserialize($import_options['options']);
            $custom_type = $import_options_arr['custom_type'];
        } else {
            // If this is a new import get the custom post type data from the current session
            $import_options = $wpdb->get_row( $wpdb->prepare("SELECT option_name, option_value FROM $wpdb->options WHERE option_name = %s", '_wpallimport_session_' . $import_id . '_'), ARRAY_A );				
            $import_options_arr = empty($import_options) ? array() : unserialize($import_options['option_value']);
            $custom_type = empty($import_options_arr['custom_type']) ? '' : $import_options_arr['custom_type'];		
        }
        return $custom_type;
    }
}
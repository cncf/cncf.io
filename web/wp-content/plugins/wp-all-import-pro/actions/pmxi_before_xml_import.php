<?php
function pmxi_pmxi_before_xml_import( $import_id ) {
	delete_option('wp_all_import_taxonomies_hierarchy_' . $import_id);

	// Remove some costly unnecessary actions during import.
	remove_action( 'transition_post_status', '_update_term_count_on_transition_post_status', 10 );
	remove_action( 'transition_post_status', '_update_posts_count_on_transition_post_status', 10 );
	remove_action( 'post_updated', 'wp_save_post_revision', 10 );

	// Invalidate hashes if functions file has been changed.
    $functions_hash = wp_all_import_generate_functions_hash();
    if ($functions_hash) {
        $current_hash = get_option('_wp_all_import_functions_hash_' . $import_id, false);
        if ($functions_hash !== $current_hash) {
            global $wpdb;
            $wpdb->query( 'DELETE FROM ' . $wpdb->prefix . 'pmxi_hash WHERE import_id = ' . $import_id );
            update_option('_wp_all_import_functions_hash_' . $import_id, $functions_hash);
        }
    }
}
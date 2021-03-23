<?php
function pmxi_pmxi_after_xml_import( $import_id, $import )
{
    if ($import->options['custom_type'] == 'taxonomies') {
        $parent_terms = get_option('wp_all_import_taxonomies_hierarchy_' . $import_id);
        if (!empty($parent_terms)){
            foreach ($parent_terms as $term_id => $pterm){
                $parent_term = get_term_by('slug', $pterm, $import->options['taxonomy_type']) or $parent_term = get_term_by('name', $pterm, $import->options['taxonomy_type']) or ctype_digit($pterm) and $parent_term = get_term_by('id', $pterm, $import->options['taxonomy_type']);
                if (!empty($parent_term) && !is_wp_error($parent_term)){
                    wp_update_term($term_id, $import->options['taxonomy_type'], array(
                        'parent'      => $parent_term->term_id,
                    ));
                }
            }
        }
        delete_option('wp_all_import_taxonomies_hierarchy_' . $import_id);
    }
    if (in_array($import->options['custom_type'], ['comments', 'woo_reviews'])) {
        $parent_comments = get_option('wp_all_import_comments_hierarchy_' . $import_id);
        if (!empty($parent_comments)){
            foreach ($parent_comments as $comment_id => $pcomment){
                $parent_comment = get_comment($pcomment);
                if (!empty($parent_comment) && !is_wp_error($parent_comment)){
                    wp_update_comment(array(
                        'comment_ID' => $comment_id,
                        'comment_parent' => $parent_comment->comment_ID,
                    ));
                }
            }
        }
        delete_option('wp_all_import_taxonomies_hierarchy_' . $import_id);
    }
    if ( ! in_array($import->options['custom_type'], array('taxonomies', 'import_users', 'shop_customer', 'comments', 'woo_reviews')) ) {
        $custom_type = get_post_type_object( $import->options['custom_type'] );
        if ( ! empty($custom_type) && $custom_type->hierarchical ){
            $parent_posts = get_option('wp_all_import_posts_hierarchy_' . $import_id);
            if (!empty($parent_posts)){
                foreach ($parent_posts as $pid => $identity){
                    $parent_post = wp_all_import_get_parent_post($identity, $import->options['custom_type'], $import->options['type']);
                    if (!empty($parent_post) && !is_wp_error($parent_post)){
                        wp_update_post(array(
                            'ID' => $pid,
                            'post_parent' => $parent_post
                        ));
                    }
                }
            }
            delete_option('wp_all_import_posts_hierarchy_' . $import_id);
        }

        $recount_terms_after_import = TRUE;
        $recount_terms_after_import = apply_filters('wp_all_import_recount_terms_after_import', $recount_terms_after_import, $import_id);
        if ($recount_terms_after_import) {
            // Update term count after import process is complete.
            $taxonomies = get_object_taxonomies( $import->options['custom_type'] );
            if (!empty($taxonomies)) {
                foreach ( (array) $taxonomies as $taxonomy ) {
                    $term_ids = get_terms(
                        array(
                            'taxonomy'   => $taxonomy,
                            'hide_empty' => false,
                            'fields' => 'tt_ids',
                        )
                    );
                    if ( ! empty( $term_ids ) ) {
                        wp_update_term_count_now( $term_ids, $taxonomy );
                    }
                }
            }

            // Update post count only once after import process is completed.
            wp_all_import_update_post_count();
        }
    }

    // Re-count post comments.
    if ( in_array($import->options['custom_type'], array('comments', 'woo_reviews')) ) {
        $recount_comments_after_import = TRUE;
        $recount_comments_after_import = apply_filters('wp_all_import_recount_comments_after_import', $recount_comments_after_import, $import_id);
        if ($recount_comments_after_import) {
            $comment_posts = get_option('wp_all_import_comment_posts_' . $import_id);
            if (!empty($comment_posts)) {
                foreach ($comment_posts as $comment_post) {
                    wp_update_comment_count_now($comment_post);
                }
            }
        }
    }

    // Add removed action during import.
    add_action( 'transition_post_status', '_update_term_count_on_transition_post_status', 10, 3 );
    add_action( 'transition_post_status', '_update_posts_count_on_transition_post_status', 10, 3 );
    add_action( 'post_updated', 'wp_save_post_revision', 10, 1 );
}
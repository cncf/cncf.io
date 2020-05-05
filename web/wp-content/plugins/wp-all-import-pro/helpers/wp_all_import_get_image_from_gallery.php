<?php

function wp_all_import_get_image_from_gallery($image_name, $targetDir = FALSE, $bundle_type = 'images', $logger = false) {

    $search_image_by_wp_attached_file = apply_filters('wp_all_import_search_image_by_wp_attached_file', true);
    if (!$search_image_by_wp_attached_file){
        return false;
    }

    global $wpdb;

    $original_image_name = $image_name;

    if (!$targetDir) {
        $wp_uploads = wp_upload_dir();
        $targetDir = $wp_uploads['path'];
    }

    // Prepare scaled image file name.
    $scaled_name = $image_name;
    $ext = pmxi_getExtension($image_name);
    if ($ext) {
        $scaled_name = str_replace('.' . $ext, '-scaled.' . $ext, $image_name);
    }

    $attch = '';

    // search attachment by attached file
    $attachment_metas = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->postmeta . " WHERE meta_key = %s AND (meta_value = %s OR meta_value = %s OR meta_value LIKE %s ESCAPE '$' OR meta_value LIKE %s ESCAPE '$');", '_wp_attached_file', $image_name, $scaled_name, "%/" . str_replace('_', '$_', $image_name), "%/" . str_replace('_', '$_', $scaled_name)));

    if (!empty($attachment_metas)) {
        foreach ($attachment_metas as $attachment_meta) {
            $attch = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->posts . " WHERE ID = %d;", $attachment_meta->post_id));
            if (!empty($attch)) {
                $logger and call_user_func($logger, sprintf(__('- Found existing image with ID `%s` by meta key _wp_attached_file equals to `%s`...', 'wp_all_import_plugin'), $attch->ID, trim($image_name)));
                break;
            }
        }
    }

    if (empty($attch)) {
        $attachment_metas = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->postmeta . " WHERE meta_key = %s AND (meta_value = %s OR meta_value = %s OR meta_value LIKE %s ESCAPE '$' OR meta_value LIKE %s ESCAPE '$');", '_wp_attached_file', sanitize_file_name($image_name), sanitize_file_name($scaled_name), "%/" . str_replace('_', '$_', sanitize_file_name($image_name)), "%/" . str_replace('_', '$_', sanitize_file_name($scaled_name))));

        if (!empty($attachment_metas)) {
            foreach ($attachment_metas as $attachment_meta) {
                $attch = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->posts . " WHERE ID = %d;", $attachment_meta->post_id));
                if (!empty($attch)) {
                    $logger and call_user_func($logger, sprintf(__('- Found existing image with ID `%s` by meta key _wp_attached_file equals to `%s`...', 'wp_all_import_plugin'), $attch->ID, sanitize_file_name($image_name)));
                    break;
                }
            }
        }
    }

    if (empty($attch)) {
        // Search attachment by file name with extension.
        $attch = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->posts . " WHERE (post_title = %s OR post_name = %s) AND post_type = %s", $image_name, sanitize_title($image_name), "attachment") . " AND post_mime_type LIKE 'image%';");
        if (!empty($attch)) {
            $logger and call_user_func($logger, sprintf(__('- Found existing image with ID `%s` by post_title or post_name equals to `%s`...', 'wp_all_import_plugin'), $attch->ID, $image_name));
        }
    }

    // Search attachment by file headers.
    if (empty($attch) and @file_exists($targetDir . DIRECTORY_SEPARATOR . $original_image_name)) {
        if ( ! function_exists('wp_read_image_metadata') ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
        }
        if ($bundle_type == 'images' and ($img_meta = wp_read_image_metadata($targetDir . DIRECTORY_SEPARATOR . $original_image_name))) {
            if (trim($img_meta['title']) && !is_numeric(sanitize_title($img_meta['title']))) {
                $img_title = $img_meta['title'];
                $attch = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->posts . " WHERE post_title = %s AND post_type = %s AND post_mime_type LIKE %s;", $img_title, "attachment", "image%"));
                if (!empty($attch)){
                    $logger and call_user_func($logger, sprintf(__('- Found existing image with ID `%s` by post_title equals to `%s`...', 'wp_all_import_plugin'), $attch->ID, $img_title));
                }
            }
        }
        if (empty($attch)) {
            @unlink($targetDir . DIRECTORY_SEPARATOR . $original_image_name);
        }
    }

    return apply_filters('wp_all_import_get_image_from_gallery', $attch, $original_image_name, $targetDir);
} 
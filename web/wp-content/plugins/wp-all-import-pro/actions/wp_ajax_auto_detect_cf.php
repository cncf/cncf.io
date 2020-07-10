<?php
function pmxi_wp_ajax_auto_detect_cf(){

    if ( ! check_ajax_referer( 'wp_all_import_secure', 'security', false )){
        exit( json_encode(array('result' => array(), 'msg' => __('Security check', 'wp_all_import_plugin'))) );
    }

    if ( ! current_user_can( PMXI_Plugin::$capabilities ) ){
        exit( json_encode(array('result' => array(), 'msg' => __('Security check', 'wp_all_import_plugin'))) );
    }

    $input = new PMXI_Input();
    $post_type = $input->post('post_type', 'post');
    global $wpdb;
    $table_prefix = $wpdb->prefix;

    $ignoreFields = array(
        '_edit_lock', '_edit_last', '_wp_trash_meta_status', '_wp_trash_meta_time', '_visibility', '_stock_status', '_downloadable', '_virtual', '_regular_price', '_sale_price', '_purchase_note', '_featured', '_weight', '_length',
        '_width', '_height', '_sku', '_sale_price_dates_from', '_sale_price_dates_to', '_price', '_sold_individually', '_manage_stock', '_stock', '_upsell_ids', '_crosssell_ids','_downloadable_files', '_download_limit', '_download_expiry', '_download_type', '_product_url', '_button_text', '_backorders', '_tax_status', '_tax_class', '_product_image_gallery', '_default_attributes','total_sales', '_product_attributes', '_product_version', '_thumbnail_id', '_is_first_variation_created', '_regular_price_tmp', '_sale_price_tmp', '_price_tmp', '_stock_tmp',
        '_order_total', '_order_version', '_order_tax', '_order_shipping_tax', '_order_shipping', '_cart_discount_tax', '_cart_discount', '_order_currency', '_order_key', '_prices_include_tax'
    );

    $fields = array();
    switch ($post_type) {
        case 'shop_customer':
            $user_fields = array('first_name', 'last_name', 'nickname', 'description', PMXI_Plugin::getInstance()->getWPPrefix() . 'capabilities');
            $billing_fields = array('billing_first_name','billing_last_name','billing_company','billing_address_1','billing_address_2','billing_city','billing_postcode','billing_country','billing_state','billing_phone','billing_email');
            $shipping_fields = array('shipping_first_name','shipping_last_name','shipping_company','shipping_address_1','shipping_address_2','shipping_city','shipping_postcode','shipping_country','shipping_state');
            $ignoreFields = array_merge($ignoreFields, $user_fields, $billing_fields, $shipping_fields);
            $fields = $input->post('fields', array());
            break;
        case 'import_users':
        case 'taxonomies':
            $fields = $input->post('fields', array());
            break;
        case 'reviews':
        case 'comments':
            $results = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT meta_key FROM ". $table_prefix ."comments, ". $table_prefix ."commentmeta WHERE ". $table_prefix ."comments.comment_ID = ". $table_prefix ."commentmeta.comment_id", $post_type), ARRAY_A);
            if (!empty($results) && !is_wp_error($results)){
                foreach ($results as $key => $value) {
                    $fields[] = $value['meta_key'];
                }
            }
            break;
        default:
            $results = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT meta_key FROM ". $table_prefix ."posts, ". $table_prefix ."postmeta WHERE post_type = %s AND ". $table_prefix ."posts.ID = ". $table_prefix ."postmeta.post_id", $post_type), ARRAY_A);
            if (!empty($results) && !is_wp_error($results)){
                foreach ($results as $key => $value) {
                    $fields[] = $value['meta_key'];
                }
            }
            break;
    }

    $result = array();

    if ($fields) {
        is_array($fields) or $fields = array($fields);
        foreach ($fields as $field) {
            switch ($post_type){
                case 'import_users':
                case 'shop_customer':
                    $values = $wpdb->get_results("
                        SELECT DISTINCT usermeta.meta_value
                        FROM ".$wpdb->usermeta." as usermeta
                        WHERE usermeta.meta_key='".$field."'
                    ", ARRAY_A);
                    break;
                case 'taxonomies':
                    $values = $wpdb->get_results("
                        SELECT DISTINCT termmeta.meta_value
                        FROM ".$wpdb->termmeta." as termmeta
                        WHERE termmeta.meta_key='".$field."'
                    ", ARRAY_A);
                    break;
                case 'reviews':
                case 'comments':
                    $values = $wpdb->get_results("
                        SELECT DISTINCT commentmeta.meta_value
                        FROM ".$wpdb->commentmeta." as commentmeta
                        WHERE commentmeta.meta_key='".$field."'
                    ", ARRAY_A);
                    break;
                default:
                    $values = $wpdb->get_results("
                        SELECT DISTINCT postmeta.meta_value
                        FROM ".$wpdb->postmeta." as postmeta
                        WHERE postmeta.meta_key='".$field."'
                    ", ARRAY_A);
                    break;
            }

            if ( ! empty($values) ){
                foreach ($values as $key => $value) {
                    if ( ! empty($value['meta_value'])
                        and !empty($field)
                            and ! in_array($field, $ignoreFields)
                                and strpos($field, '_max_') !== 0
                                    and strpos($field, '_min_') !== 0 and ! preg_match('%_[0-9]{1,}_%', $field)
                                        and ($post_type != 'shop_order' or strpos($field, '_billing') !== 0 and strpos($field, '_shipping') !== 0)) {

                        $result[] = array(
                            'key' => $field,
                            'val' => $value['meta_value'],
                            'is_serialized' => is_serialized($value['meta_value'])
                        );
                        break;
                    }
                }
            }
        }
    }

    if (empty($result)){
        switch ($post_type){
            case 'taxonomies':
                $custom_type = new stdClass();
                $custom_type->labels = new stdClass();
                $custom_type->labels->singular_name = __('Taxonomy Term', 'wp_all_import_plugin');
                break;
            case 'comments':
                $custom_type = new stdClass();
                $custom_type->labels = new stdClass();
                $custom_type->labels->singular_name = __('Comment', 'wp_all_import_plugin');
                break;
            default:
                $custom_type = get_post_type_object( $post_type );
                break;
        }
        $msg = sprintf(__('No Custom Fields are present in your database for %s', 'wp_all_import_plugin'), $custom_type->labels->name);
    }
    elseif (count($result) === 1)
        $msg = sprintf(__('%s field was automatically detected.', 'wp_all_import_plugin'), count($result));
    else{
        $msg = sprintf(__('%s fields were automatically detected.', 'wp_all_import_plugin'), count($result));
    }

    exit( json_encode(array('result' => $result, 'msg' => $msg)) );
}
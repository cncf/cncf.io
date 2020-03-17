<?php

if (!defined('ABSPATH')) {
    exit;
}

$columns = array(
    'customer_id' => 'customer_id',
    'user_email' => 'user_email',
    'first_name' => 'first_name',
    'roles' => 'roles'
);

if (!function_exists( 'is_plugin_active' ) )
     require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

if( is_plugin_active( 'woocommerce/woocommerce.php' ) ):
    
    $columns['billing_first_name'] = 'billing_first_name';
    $columns['billing_email'] = 'billing_email';
    $columns['billing_city'] = 'billing_city';
    $columns['billing_state'] = 'billing_state';
    $columns['billing_country'] = 'billing_country';
    $columns['shipping_first_name'] = 'shipping_first_name';
    $columns['shipping_city'] = 'shipping_city';
    $columns['shipping_state'] = 'shipping_state';
    $columns['shipping_country'] = 'shipping_country';
    
endif;

return apply_filters('hf_csv_customer_quick_post_columns', $columns);
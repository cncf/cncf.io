<?php

if (!defined('ABSPATH')) {
    exit;
}

$columns = array(
    'ID' => 'ID',
    'customer_id' => 'customer_id',
    'user_login' => 'user_login',
    'user_pass' => 'user_pass',
    'user_nicename' => 'user_nicename',
    'user_email' => 'user_email',
    'user_url' => 'user_url',
    'user_registered' => 'user_registered',
    'display_name' => 'display_name',
    'first_name' => 'first_name',
    'last_name' => 'last_name',
    'user_status' => 'user_status',
    'roles' => 'roles'
);
// default meta
$columns['nickname'] = 'nickname';
$columns['first_name'] = 'first_name';
$columns['last_name'] = 'last_name';
$columns['description'] = 'description';
$columns['rich_editing'] = 'rich_editing';
$columns['syntax_highlighting'] = 'syntax_highlighting';
$columns['admin_color'] = 'admin_color';
$columns['use_ssl'] = 'use_ssl';
$columns['show_admin_bar_front'] = 'show_admin_bar_front';
$columns['locale'] = 'locale';
$columns['wp_user_level'] = 'wp_user_level';
$columns['dismissed_wp_pointers'] = 'dismissed_wp_pointers';
$columns['last_update'] = 'last_update';


if (!function_exists( 'is_plugin_active' ) )
     require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

if( is_plugin_active( 'woocommerce/woocommerce.php' ) ):
    
    $columns['billing_first_name'] = 'billing_first_name';
    $columns['billing_last_name'] = 'billing_last_name';
    $columns['billing_company'] = 'billing_company';
    $columns['billing_email'] = 'billing_email';
    $columns['billing_phone'] = 'billing_phone';
    $columns['billing_address_1'] = 'billing_address_1';
    $columns['billing_address_2'] = 'billing_address_2';
    $columns['billing_postcode'] = 'billing_postcode';
    $columns['billing_city'] = 'billing_city';
    $columns['billing_state'] = 'billing_state';
    $columns['billing_country'] = 'billing_country';
    $columns['shipping_first_name'] = 'shipping_first_name';
    $columns['shipping_last_name'] = 'shipping_last_name';
    $columns['shipping_company'] = 'shipping_company';
    $columns['shipping_address_1'] = 'shipping_address_1';
    $columns['shipping_address_2'] = 'shipping_address_2';
    $columns['shipping_postcode'] = 'shipping_postcode';
    $columns['shipping_city'] = 'shipping_city';
    $columns['shipping_state'] = 'shipping_state';
    $columns['shipping_country'] = 'shipping_country';
    
endif;

/*
global $wpdb;

$meta_keys = $wpdb->get_col("SELECT distinct(meta_key) FROM $wpdb->usermeta");

foreach ($meta_keys as $meta_key) {
    if (empty($columns[$meta_key])) {        
        $columns['meta:'.$meta_key] = 'meta:'.$meta_key; // adding an extra prefix for identifying meta while import process
    }
}
 */
return apply_filters('hf_csv_customer_post_columns', $columns);
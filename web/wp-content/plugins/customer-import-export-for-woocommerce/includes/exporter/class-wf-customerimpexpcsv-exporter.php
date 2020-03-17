<?php

if (!defined('ABSPATH')) {
    exit;
}

class WF_CustomerImpExpCsv_Exporter {

    public static $v_include_metadata;
    public static $meta_keys;

    /**
     * Customer Exporter Tool
     * @param array $user_IDS [optional]<p>Array of User Id.</p>
     * @param boolean $ftp [optional]<p>If the value of $ftp is set to TRUE, the exported file will not be uploaded to FTP Server</p>
     */
    public static function do_export($user_IDS = array(), $ftp = null) {
        global $wpdb;
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        $export_limit = !empty($_POST['limit']) ? intval($_POST['limit']) : 999999999;
        $export_offset = !empty($_POST['offset']) ? intval($_POST['offset']) : 0;
        self::$v_include_metadata = !empty($_POST['v_include_metadata']) ? true : false;
        if(!empty($_POST['wt_specific_metas'])){ 
           $user_entered_data = str_replace(', ', ',', $_POST['wt_specific_metas']);
           $user_entered_meta = explode(",",$user_entered_data);
        }
        $csv_columns = include( 'data/data-wf-post-columns.php' );

        $user_columns_name = !empty($_POST['columns_name']) ? $_POST['columns_name'] : $csv_columns;
        $export_columns = !empty($_POST['columns']) ? $_POST['columns'] : array();
        if(!empty($user_entered_meta) && !self::$v_include_metadata){
            $user_entered_meta = array_combine($user_entered_meta, $user_entered_meta); 
            $csv_columns = array_unique(array_merge($csv_columns, $user_entered_meta));
            $user_columns_name = array_unique(array_merge($user_columns_name, $user_entered_meta));
            $export_columns = array_unique(array_merge($export_columns, $user_entered_meta));
        }

        $export_user_roles = !empty($_POST['user_roles']) ? $_POST['user_roles'] : array();
        $export_sortby = !empty($_POST['user_sortby']) ? $_POST['user_sortby'] : array('user_login');
        $export_sort_order = !empty($_POST['sort_order']) ? $_POST['sort_order'] : 'ASC';
        $user_ids = !empty($_POST['user_ids']) ? $_POST['user_ids'] : array();
        $export_start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : '';
        $export_end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : '';
        $delimiter = !empty($_POST['delimiter']) ? $_POST['delimiter'] : ',';
        $delimiter = self::wt_set_csv_delimiter($delimiter);
        $usr_export_enable_ftp = !empty($_POST['usr_export_enable_ftp']) ? TRUE : FALSE;

        $v_export_guest_user = !empty($_POST['v_export_guest_user']) ? true : false;

        $settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
        $usr_enable_auto_export = isset($settings['usr_auto_export']) ? $settings['usr_auto_export'] : '';
        if ($usr_enable_auto_export && ($ftp == NULL)) {
            self::$v_include_metadata = isset($settings['v_include_metadata_cron']) ? $settings['v_include_metadata_cron'] : '';
        }


        $new_profile = !empty($_POST['usr_new_profile']) ? $_POST['usr_new_profile'] : '';
       /* if ($new_profile !== '') {

            $mapped = array();
            if (!empty($export_columns)) {
                foreach ($export_columns as $key => $value) {
                    $mapped[$key] = $user_columns_name[$key];
                }
            }

            $export_profile_array = get_option('xa_user_csv_export_mapping');
            $export_profile_array[$new_profile] = $mapped;
            update_option('xa_user_csv_export_mapping', $export_profile_array);
        }*/
        
            if (!empty($_POST['user_auto_export_profile'])) {
            $export_profile_array = get_option('xa_user_csv_export_mapping');
            $user_columns_name = array();
            $user_columns_name = $export_profile_array[$_POST['user_auto_export_profile']];
            if(isset($user_columns_name['wt_specific_metas']) && !empty($user_columns_name['wt_specific_metas'])){
                $specific_metas = $user_columns_name['wt_specific_metas'];
                unset($user_columns_name['wt_specific_metas']);
                 $user_entered_meta_data = str_replace(', ', ',', $specific_metas);
                 $user_entered_meta_data = explode(",",$user_entered_meta_data);
                 $user_entered_metas = array_combine($user_entered_meta_data, $user_entered_meta_data); 
            }

                foreach ($user_columns_name as $column => $value) {
                    $export_columns[$column] = $column;
                }
                if(!self::$v_include_metadata){
                $export_columns = array_unique(array_merge($export_columns, $user_entered_metas));
                $csv_columns = array_unique(array_merge($csv_columns, $user_entered_metas));
                $user_columns_name = array_unique(array_merge($user_columns_name, $user_entered_metas));
                }
            }

        $wpdb->hide_errors();
        @set_time_limit(0);
        if (function_exists('apache_setenv'))
            @apache_setenv('no-gzip', 1);
        @ini_set('zlib.output_compression', 0);
        @ob_end_clean();

        if ($usr_enable_auto_export && ($ftp == NULL)) {
            $upload_path = wp_upload_dir();
            $file_path = $upload_path['path'] . '/';
            $file_name = $settings['usr_auto_export_file_name'];
            if(in_array(pathinfo($file_name, PATHINFO_EXTENSION),array('csv'))){
                $file_name.= '.csv'; 
            }
            $file = (!empty($settings['usr_auto_export_file_name']) ) ? $file_path .$file_name : $file_path . "Customer-Export-" . date('Y_m_d_H_i_s', current_time('timestamp')) . ".csv";
            $fp = fopen($file, 'w');
        } elseif ($usr_export_enable_ftp) {
            $upload_path = wp_upload_dir();
            $file_path = $upload_path['path'] . '/';
            $file_name = $_POST['usr_export_ftp_file_name'];
            if(in_array(pathinfo($file_name, PATHINFO_EXTENSION),array('csv'))){
                $file_name.= '.csv'; 
            }
            $file = !empty($_POST['usr_export_ftp_file_name']) ? $file_path . $file_name : $file_path . "Customer-Export-" . date('Y_m_d_H_i_s', current_time('timestamp')) . ".csv";
            
            $fp = fopen($file, 'w');
        } else {
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=Customer-Export-' . date('Y_m_d_H_i_s', current_time('timestamp')) . ".csv");
            header('Pragma: no-cache');
            header('Expires: 0');

            $fp = fopen('php://output', 'w');
        }

        $sortby_check = array_intersect($export_sortby, array('ID', 'user_registered', 'user_email', 'user_login', 'user_nicename'));
        if (empty($sortby_check)) {
            $wt_export_sortby = $export_sortby[0];
            $args = array(
                'fields' => 'ID', // exclude standard wp_users fields from get_users query -> get Only ID##
                'role__in' => $export_user_roles, //An array of role names. Matched users must have at least one of these roles. Default empty array.
                'number' => $export_limit, // number of users to retrieve
                'offset' => $export_offset, // offset to skip from list
                'orderby' => 'meta_value',
                'meta_key' => $wt_export_sortby,
                'order'  => $export_sort_order,
                'date_query' => array(
                    array(
                        'after' => $export_start_date,
                        'before' => $export_end_date,
                        'inclusive' => true
                    )),
            );
        } else {

            $args = array(
                'fields' => 'ID', // exclude standard wp_users fields from get_users query -> get Only ID##
                'role__in' => $export_user_roles, //An array of role names. Matched users must have at least one of these roles. Default empty array.
                'number' => $export_limit, // number of users to retrieve
                'offset' => $export_offset, // offset to skip from list
                'orderby' => $export_sortby,
                'order'  => $export_sort_order,
                'date_query' => array(
                    array(
                        'after' => $export_start_date,
                        'before' => $export_end_date,
                        'inclusive' => true
                    )),
            );
        }
        if (!empty($user_ids)) {
            $args['include'] = $user_ids;
        }

        if (!empty($user_IDS)) {
            $args['include'] = $user_IDS; // An array of user IDs to include. Default empty array.
            unset($args['date_query']);
        }

        //add_action('pre_user_query', array(__CLASS__, 'pre_user_query'), 20);

        $users = get_users($args);


        //remove_action('pre_user_query', array(__CLASS__, 'pre_user_query'), 20);
        // Variable to hold the CSV data we're exporting
        $row = array();

        // Export header rows
        foreach ($csv_columns as $column => $value) {

            if (!$export_columns || in_array($column, $export_columns)) {
                $temp_head = esc_attr($user_columns_name[$column]);
                $row[] = $temp_head;
            }
        }
        if (self::$v_include_metadata) {
            self::$meta_keys = apply_filters('wt_alter_user_meta_data', $wpdb->get_col("SELECT distinct(meta_key) FROM $wpdb->usermeta WHERE meta_key NOT IN ('wp_capabilities')"));
            foreach (self::$meta_keys as $meta_key) {
                if (!isset($csv_columns[$meta_key])) {
                    $row['meta:' . $meta_key] = 'meta:' . $meta_key; // adding an extra prefix for identifying meta while import process
                }
            }
        }
        $row = array_map('WF_CustomerImpExpCsv_Exporter::wrap_column', apply_filters('wt_user_alter_csv_header', $row));
        fwrite($fp, implode($delimiter, $row) . "\n");
        $header_row = $row;
        unset($row);


        // Loop users
        foreach ($users as $user) {
            $data = WF_CustomerImpExpCsv_Exporter::get_customers_csv_row($user, $export_columns, $csv_columns, $header_row);
            $data = apply_filters('hf_customer_csv_exclude_admin', $data);
            $row = array_map('WF_CustomerImpExpCsv_Exporter::wrap_column', $data);
            fwrite($fp, implode($delimiter, $row) . "\n");
            unset($row);
            unset($data);
        }

        if ($v_export_guest_user) {
            $query_args = array(
                'fields' => 'ids',
                'post_type' => 'shop_order',
                'post_status' => 'any',
                'posts_per_page' => -1,
            );
            $query_args['meta_query'] = array(array(
                    'key' => '_customer_user',
                    'value' => 0,
                    'compare' => '',
            ));
            $query = new WP_Query($query_args);
            $order_ids = $query->posts;
            foreach ($order_ids as $order_id) {
                $order = new WC_Order($order_id);
                $user = get_user_by('email', $order->get_billing_email());
                if (!isset($user->ID)) {
                    $data = WF_CustomerImpExpCsv_Exporter::get_guest_customers_csv_row($order, $export_columns, $csv_columns, $header_row);
                    $data = apply_filters('hf_customer_csv_exclude_admin', $data);
                    $row = array_map('WF_CustomerImpExpCsv_Exporter::wrap_column', $data);
                    fwrite($fp, implode($delimiter, $row) . "\n");
                    unset($row);
                    unset($data);
                }
            }
        }

        if (($usr_enable_auto_export && ($ftp == NULL)) || $usr_export_enable_ftp) {
            $file = apply_filters('wt_user_export_prepared_data', $file);
            $redirect_url = self::handle_ftp($settings, $file);
            unlink($file);
            wp_redirect($redirect_url);
        }

        fclose($fp);
        exit;
    }

    public static function handle_ftp($settings, $file) {

        $usr_export_enable_ftp = !empty($_POST['usr_export_enable_ftp']) ? TRUE : FALSE;
        $usr_enable_auto_export = !empty($settings['usr_auto_export']) ? $settings['usr_auto_export'] : '';
        if ($usr_export_enable_ftp) {
            $ftp_server = !empty($_POST['ftp_server']) ? $_POST['ftp_server'] : '';
            $ftp_user = !empty($_POST['ftp_user']) ? $_POST['ftp_user'] : '';
            $ftp_password = !empty($_POST['ftp_password']) ? $_POST['ftp_password'] : '';
            $ftp_port = !empty($_POST['ftp_port']) ? $_POST['ftp_port'] : 21;
            $use_ftps = !empty($_POST['use_ftps']) ? $_POST['use_ftps'] : '';
            $use_pasv = !empty($_POST['use_pasv']) ? $_POST['use_pasv'] : '';
            $is_sftp = !empty($_POST['is_sftp']) ? true : false;
            $remote_path = !empty($_POST['usr_export_ftp_path']) ? $_POST['usr_export_ftp_path'] : '';
        } elseif ($usr_enable_auto_export) {
            $usr_auto_export_ftp_profile = $settings['usr_auto_export_ftp_profile'] ? $settings['usr_auto_export_ftp_profile'] : '';
            if ($usr_auto_export_ftp_profile != '') {
                $ftp_server = isset($settings['ftp'][$usr_auto_export_ftp_profile]['ftp_server']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['ftp_server'] : '';
                $ftp_user = isset($settings['ftp'][$usr_auto_export_ftp_profile]['ftp_user']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['ftp_user'] : '';
                $ftp_password = isset($settings['ftp'][$usr_auto_export_ftp_profile]['ftp_password']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['ftp_password'] : '';
                $ftp_port = !empty($settings['ftp'][$usr_auto_export_ftp_profile]['ftp_port']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['ftp_port'] : 21;
                $use_ftps = isset($settings['ftp'][$usr_auto_export_ftp_profile]['use_ftps']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['use_ftps'] : '';
                $is_sftp = !empty($settings['ftp'][$usr_auto_export_ftp_profile]['is_sftp']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['is_sftp'] : '';
                $use_pasv = isset($settings['ftp'][$usr_auto_export_ftp_profile]['use_pasv']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['use_pasv'] : '';
                $remote_path = isset($settings['usr_auto_export_path']) ? $settings['usr_auto_export_path'] : null;
            }
        }

        // Upload ftp path with filename
        $remote_file = ( substr($remote_path, -1) != '/' ) ? ( $remote_path . "/" . basename($file) ) : ( $remote_path . basename($file) );
        // if have SFTP Add-on for Import Export for WooCommerce 
        if (class_exists('class_wf_sftp_import_export') && $is_sftp === true) {
            $sftp_export = new class_wf_sftp_import_export();
            if (!$sftp_export->connect($ftp_server, $ftp_user, $ftp_password, $ftp_port)) {
                $wf_customer_ie_msg = 2;
                $url = admin_url('/admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=export&wf_order_ie_msg=' . $wf_customer_ie_msg);
                return $url;
            }
            if ($sftp_export->put_contents($remote_file, file_get_contents($file))) {
                $wf_customer_ie_msg = 1;
            } else {
                $wf_customer_ie_msg = 2;
            }
            $url = admin_url('/admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=export&wf_order_ie_msg=' . $wf_customer_ie_msg);
            return $url;
        }
        if ($use_ftps) {
            $ftp_conn = @ftp_ssl_connect($ftp_server, $ftp_port) or die("Could not connect to $ftp_server:$ftp_port");
        } else {
            $ftp_conn = @ftp_connect($ftp_server, $ftp_port) or die("Could not connect to $ftp_server:$ftp_port");
        }
        $login = @ftp_login($ftp_conn, $ftp_user, $ftp_password);

        if ($use_pasv)
            ftp_pasv($ftp_conn, TRUE);

        // upload file
        if (@ftp_put($ftp_conn, $remote_file, $file, FTP_ASCII)) {
            $wf_customer_ie_msg = 1;
        } else {
            $wf_customer_ie_msg = 2;
        }

        // close connection
        ftp_close($ftp_conn);
        $url = admin_url('/admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=export&wf_customer_ie_msg=' . $wf_customer_ie_msg);
        return $url;
    }

    public static function format_data($data) {
        //if (!is_array($data));
        //$data = (string) urldecode($data);
        $enc = mb_detect_encoding($data, 'UTF-8, ISO-8859-1', true);
        $data = ( $enc == 'UTF-8' ) ? $data : utf8_encode($data);
        return $data;
    }

    /**
     * Wrap a column in quotes for the CSV
     * @param  string data to wrap
     * @return string wrapped data
     */
    public static function wrap_column($data) {
        return '"' . str_replace('"', '""', $data) . '"';
    }

    /**
     * Get the customer data for a single CSV row
     * @since 3.0
     * @param int $customer_id
     * @param array $export_columns - user selected columns / all
     * @return array $meta_keys customer/user meta data
     */
    public static function get_customers_csv_row($id, $export_columns, $csv_columns, $header_row) {
        $user = get_user_by('id', $id);

        $customer_data = array();
        foreach ($csv_columns as $key) {
            if (!$export_columns || in_array($key, $export_columns)) {
                $key = trim(str_replace('meta:', '', $key));
                if ($key == 'roles') {
                    $user_roles = (!empty($user->roles)) ? $user->roles : array();
                    $customer_data['roles'] = implode(', ', $user_roles);
                    continue;
                }
                if ($key != 'customer_id') {
                    $customer_data[$key] = !empty($user->{$key}) ? maybe_serialize($user->{$key}) : '';
                } else {
                    $customer_data[$key] = !empty($user->ID) ? maybe_serialize($user->ID) : '';
                }
            } else {
                continue;
            }
        }
        if (self::$v_include_metadata) {
            foreach (self::$meta_keys as $meta_key) {
                if (!isset($csv_columns[$meta_key])) {
                    $customer_data['meta:' . $meta_key] = !empty($user->{$meta_key}) ? maybe_serialize($user->{$meta_key}) : ''; // adding an extra prefix for identifying meta while import process
                }
            }
        }

        /*
         * CSV Customer Export Row.
         * Filter the individual row data for the customer export
         * @since 3.0
         * @param array $customer_data 
         */
        return apply_filters('hf_customer_csv_export_data', $customer_data, $header_row);
    }

    public static function get_guest_customers_csv_row($order, $export_columns, $csv_columns, $header_row) {
        $customer_data = array();
        $key_array = array('billing_first_name', 'billing_last_name', 'billing_company', 'billing_email', 'billing_phone', 'billing_address_1', 'billing_address_2', 'billing_postcode', 'billing_city', 'billing_state', 'billing_country', 'shipping_first_name', 'shipping_last_name', 'shipping_company', 'shipping_address_1', 'shipping_address_2', 'shipping_postcode', 'shipping_city', 'shipping_state', 'shipping_country', 'shipping_method');
        foreach ($csv_columns as $key) {
            if (!$export_columns || in_array($key, $export_columns)) {
                if (in_array($key, $key_array)) {
                    if ($key == 'user_email') {
                        $customer_data[$key] = $order->get_billing_email();
                        continue;
                    }
                    $method_name = "get_{$key}";
                    $data = $order->$method_name();
                    if (!empty($data)) {
                        $data = maybe_serialize($order->$method_name());
                    } else {
                        $data = '';
                    }
                    $customer_data[$key] = $data;
                } else {
                    $customer_data[$key] = '';
                }
            } else {
                continue;
            }
        }

        /*
         * CSV Guest Customer Export Row.
         * Filter the individual row data for the Guest customer export
         * @since 3.0
         * @param array $customer_data 
         */
        return apply_filters('hf_customer_csv_export_data', $customer_data, $header_row);
    }

    /*
     * Pre User Query => Fires after the WP_User_Query has been parsed, and before the query is executed.
     */

    public static function pre_user_query($user_search) {

        global $wpdb;
        $where = '';

        if (!empty($_POST['start_date'])) {
            $date = new DateTime(sanitize_text_field($_POST['start_date']) . ' 00:00:00');
            $date_formatted = $date->format('Y-m-d H:i:s');
            $where .= $wpdb->prepare(" AND $wpdb->users.user_registered >= %s", $date_formatted);
        }
        if (!empty($_POST['end_date'])) {
            $date = new DateTime(sanitize_text_field($_POST['end_date']) . ' 00:00:00');
            $date_formatted = $date->format('Y-m-d H:i:s');
            $where .= $wpdb->prepare(" AND $wpdb->users.user_registered < %s", $date_formatted);
        }

        if (!empty($where)) {
            $user_search->query_where = str_replace('WHERE 1=1', "WHERE 1=1 $where", $user_search->query_where);
        }
        return $user_search;
    }
     public static function wt_set_csv_delimiter($delemiter=','){
        $delemiter = strtolower($delemiter);
        switch ($delemiter) {
            case 'tab':
                $delemiter =   "\t";
                break;
            
            case 'space':
                $delemiter =   " ";
                break;
        }
        return $delemiter;
    }

}

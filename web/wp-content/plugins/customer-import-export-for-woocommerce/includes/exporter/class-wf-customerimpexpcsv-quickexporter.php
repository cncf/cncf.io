<?php

if (!defined('ABSPATH')) {
    exit;
}

class WF_CustomerImpExpCsv_Quick_Exporter {

    /**
     * Customer Quick Exporter Tool
     */
    public static function do_export() {        
        global $wpdb;

        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        $csv_columns = include( 'data/data-wf-quick-post-columns.php' );
        $export_columns = !empty($_POST['columns']) ? $_POST['columns'] : array();
        $delimiter = ',';
     
        $wpdb->hide_errors();
        @set_time_limit(0);
        if (function_exists('apache_setenv'))
            @apache_setenv('no-gzip', 1);
        @ini_set('zlib.output_compression', 0);
        @ob_end_clean();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=Customer-Export-' . date('Y_m_d_H_i_s', current_time('timestamp')) . ".csv");
        header('Pragma: no-cache');
        header('Expires: 0');

        $fp = fopen('php://output', 'w');

        $args = array(
            'fields' => 'ID', // exclude standard wp_users fields from get_users query -> get Only ID##
        );

        $users = get_users($args);

        // Variable to hold the CSV data we're exporting
        $row = array();

        // Export header rows
        foreach ($csv_columns as $column => $value) {

            if (!$export_columns || in_array($column, $export_columns)) {
                $row[] = $value;
            }
        }
        $row = array_map('WF_CustomerImpExpCsv_Quick_Exporter::wrap_column', $row);
        fwrite($fp, implode($delimiter, $row) . "\n");
        unset($row);

        
        // Loop users
        foreach ($users as $user) {
            //$row = array();   
            $data = WF_CustomerImpExpCsv_Quick_Exporter::get_customers_csv_row($user, $export_columns, $csv_columns);
            $data = apply_filters('hf_customer_csv_exclude_admin', $data);
            $row = array_map('WF_CustomerImpExpCsv_Quick_Exporter::wrap_column', $data);
            fwrite($fp, implode($delimiter, $row) . "\n");
            unset($row);
            unset($data);
        }

        fclose($fp);
        exit;
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
    public static function get_customers_csv_row($id, $export_columns, $csv_columns) {
        $user = get_user_by('id', $id);

        $customer_data = array();
        foreach ($csv_columns as $key) {
            if($export_columns && !in_array($key, $export_columns)){
                continue;
            }
            if ($key != 'customer_id') {
                $customer_data[$key] = !empty($user->{$key}) ? maybe_serialize($user->{$key}) : '';
            } else {
                $customer_data[$key] = !empty($user->ID) ? maybe_serialize($user->ID) : '';
            }
        }
        if(!$export_columns || in_array('roles', $export_columns)){
            $user_roles = (!empty($user->roles)) ? $user->roles : array();
            $customer_data['roles'] = implode(', ', $user_roles);
        }

        
        /*
         * CSV Customer Export Row.
         * Filter the individual row data for the customer export
         * @since 3.0
         * @param array $customer_data 
         */
        return apply_filters('hf_customer_csv_export_data', $customer_data);
    }
}



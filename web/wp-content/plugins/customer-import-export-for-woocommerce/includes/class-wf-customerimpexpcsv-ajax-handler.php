<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WF_CustomerImpExpCsv_AJAX_Handler {

	/**
	 * Constructor
	 */
	public function __construct() {
            add_action( 'wp_ajax_user_csv_import_request', array( $this, 'csv_customer_import_request' ) );
            add_action( 'wp_ajax_user_csv_export_mapping_change', array( $this, 'export_user_mapping_change_columns' ) );
            add_action( 'wp_ajax_user_impexp_test_ftp_connection', array( $this, 'test_ftp_credentials' ) );
            add_action( 'wp_ajax_user_csv_import_mapping_save', array( $this, 'save_import_mapping_profile' ));
            add_action( 'wp_ajax_user_csv_export_mapping_save', array( $this, 'save_export_mapping_profile' ));
            add_action('wp_ajax_user_csv_export_mapping_delete', array($this, 'delete_export_mapping_profile'));
            add_action('wp_ajax_user_csv_import_mapping_delete', array($this, 'delete_import_mapping_profile'));
	}
        
        public function save_export_mapping_profile(){
            $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
            if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !WF_Customer_Import_Export_CSV::hf_user_permission()) {
                wp_die(__('Access Denied', 'wf_customer_import_export'));
            }
            $new_profile = !empty($_POST['profile_name']) ? $_POST['profile_name'] : '';
            $update = false;
            if ($new_profile !== '') {
                $export_columns = array();
                $user_columns_name = array();

                foreach ($_POST['columns'] as $key => $value) {
                    $export_columns[$this->wt_get_string_between($value['name'],'columns[',']') ] = $value['value'];                                        
                }
                   
                foreach ($_POST['columns_name'] as $key => $value) {
                    $user_columns_name[$this->wt_get_string_between($value['name'],'columns_name[',']') ] = $value['value'];                                        
                }

                $mapped = array();
                if (!empty($export_columns)) {
                    foreach ($export_columns as $key => $value) {
                        $mapped[$key] = $user_columns_name[$key];
                    }
                }
                if (isset($_POST['wt_specific_metas']) && !empty($_POST['wt_specific_metas'])) {
                    $mapped['wt_specific_metas'] = $_POST['wt_specific_metas'];
                }

                $export_profile_array = get_option('xa_user_csv_export_mapping');
                $export_profile_array[$new_profile] = $mapped;   
                $update =  update_option('xa_user_csv_export_mapping', $export_profile_array);
                
            } else {
                die("<span id= 'usr_save_mapping_msg' style = 'color : red'>".__('Enter a valid Profile name.','wf_csv_import_export')."</span>");    
            }

            if( $update == TRUE ){
                die("<span id= 'usr_save_mapping_msg' style = 'color : green'>".__('Mapping profile saved.','wf_csv_import_export')."</span>");
            }else{
                die("<span id= 'usr_save_mapping_msg' style = 'color : red'>".__('Profile exists already.','wf_csv_import_export')."</span>");
            }
        }

        public function save_import_mapping_profile(){

            $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
            if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !WF_Customer_Import_Export_CSV::hf_user_permission()) {
                wp_die(__('Access Denied', 'wf_customer_import_export'));
            }
            $profile = !empty($_POST['profile_name']) ? $_POST['profile_name'] : '';            
            $update = false;
            if ($profile !== '') {
                $mapping = array();
                $eval_field = array();
                foreach ($_POST['map_from'] as $key => $value) {
                    $mapping[$this->wt_get_string_between($value['name'],'map_from[',']') ] = $value['value'];                                        
                }
                   
                foreach ($_POST['eval_field'] as $key => $value) {
                    $eval_field[$this->wt_get_string_between($value['name'],'eval_field[',']') ] = $value['value'];                                        
                }
                    
                $profile_array = get_option('wf_user_csv_imp_exp_mapping');
                
                $profile_array[$profile] = array($mapping, $eval_field);
              
                $update = update_option('wf_user_csv_imp_exp_mapping', $profile_array);
                
            }else{
                die("<span id= 'usr_save_mapping_msg' style = 'color : red'>".__('Enter a valid Profile name.','wf_customer_import_export')."</span>");
            }

            if( $update == TRUE ){
                die("<span id= 'usr_save_mapping_msg' style = 'color : green'>".__('Mapping profile saved.','wf_customer_import_export')."</span>"); //
            }else{
                die("<span id= 'usr_save_mapping_msg' style = 'color : red'>".__('Profile exists already.','wf_customer_import_export')."</span>");
            }
        }
        
        public function delete_export_mapping_profile() {

        $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
        if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !WF_Customer_Import_Export_CSV::hf_user_permission()) {
            wp_die(__('Access Denied', 'wf_customer_import_export'));
        }
        $profile = !empty($_POST['profile_name']) ? $_POST['profile_name'] : '';
        $update = false;
        if ($profile !== '') {

            $export_profile_array = get_option('xa_user_csv_export_mapping');
            unset($export_profile_array[$profile]);
            $update = update_option('xa_user_csv_export_mapping', $export_profile_array);
                
        } else {
            die("<span id= 'user_delete_mapping_msg' style = 'color : red'>" . __('Selected Profile is not exists.', 'wf_customer_import_export') . "</span>");
        }

        if ($update == TRUE) {
            die("<span id= 'user_delete_mapping_msg' style = 'color : green'>" . __('Mapping profile deleted.', 'wf_customer_import_export') . "</span>");
        } else {
            die("<span id= 'user_delete_mapping_msg' style = 'color : red'>" . __('Selected Profile is invalid.', 'wf_customer_import_export') . "</span>");
        }
            
    }
             
        public function delete_import_mapping_profile() {
        $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
        if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !WF_Customer_Import_Export_CSV::hf_user_permission()) {
            wp_die(__('Access Denied', 'wf_customer_import_export'));
        }
        $profile = !empty($_POST['profile_name']) ? $_POST['profile_name'] : '';
        $update = false;
        if ($profile !== '') {

            $import_profile_array = get_option('wf_user_csv_imp_exp_mapping');
            unset($import_profile_array[$profile]);
            $update = update_option('wf_user_csv_imp_exp_mapping', $import_profile_array);
                
        } else {
            die("<span id= 'user_delete_imp_mapping_msg' style = 'color : red'>" . __('Selected Profile is not exists.', 'wf_customer_import_export') . "</span>");
        }

        if ($update == TRUE) {
            die("<span id= 'user_delete_imp_mapping_msg' style = 'color : green'>" . __('Mapping profile deleted.', 'wf_customer_import_export') . "</span>");
        } else {
            die("<span id= 'user_delete_imp_mapping_msg' style = 'color : red'>" . __('Selected Profile is invalid.', 'wf_customer_import_export') . "</span>");
        }
            
    }
        
        
        
        public function wt_get_string_between($string, $start, $end) {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0)
                return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
	
	/**
	 * Ajax event for importing a CSV
	 */
	public function csv_customer_import_request() {
            define( 'WP_LOAD_IMPORTERS', true );
            WF_CustomerImpExpCsv_Importer::customer_importer();
	}
        /**
        * Ajax event for changing mapping of export CSV
        */
        public function export_user_mapping_change_columns() {

            $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
            if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !WF_Customer_Import_Export_CSV::hf_user_permission()) {
                wp_die(__('Access Denied', 'wf_customer_import_export'));
            }
            $selected_profile = !empty($_POST['v_user_new_profile']) ? $_POST['v_user_new_profile'] : '';

            $post_columns = array();
            //if (!$selected_profile) {
                $post_columns = include( 'exporter/data/data-wf-post-columns.php' );
           // }

            $export_profile_array = get_option('xa_user_csv_export_mapping');

           /* if (!empty($export_profile_array[$selected_profile])) {
                $post_columns = $export_profile_array[$selected_profile];
            }*/
             $post_columns_from_saved_map = array();
        if (!empty($export_profile_array[$selected_profile])) {
            $post_columns_from_saved_map = $export_profile_array[$selected_profile];
        }
            $res = "<tr>
                          <td style='padding: 10px;'>
                              <a href='#' id='usrselectall' onclick='return false;' >Select all</a> &nbsp;/&nbsp;
                              <a href='#' id='usrunselectall' onclick='return false;'>Unselect all</a>
                          </td>
                      </tr>

                    <th style='text-align: left;'>
                        <label for='v_columns'>Column</label>
                    </th>
                    <th style='text-align: left;'>
                        <label for='v_columns_name'>Column Name</label>
                    </th>";


            foreach ($post_columns as $pkey => $pcolumn) {
                   $tmpkey = $pkey;
            $checked = (array_key_exists($pkey, $post_columns_from_saved_map)) ? 'checked' : '';
            $columns_name_val = (array_key_exists($pkey, $post_columns_from_saved_map)) ? $post_columns_from_saved_map[$pkey] : $tmpkey;

                 $res .= "<tr>
                        <td>
                            <input name= 'columns[$pkey]' id= 'columns[$pkey]' type='checkbox' value='$pkey' $checked>
                            <label for='columns[$pkey]'>$pcolumn</label>
                        </td>
                        <td>";

                $res .= "<input type='text' name='columns_name[$pkey]'  value='$columns_name_val' class='input-text' />
                       </td>
                      </tr>";
            }
            if (isset($post_columns_from_saved_map['wt_specific_metas']) && !empty($post_columns_from_saved_map['wt_specific_metas'])) {
                $specifi_metas = $post_columns_from_saved_map['wt_specific_metas'];
                $res .= " <tr>
                                    <td>
                                        <label for='v_specifi_metas'>". __('Additional metadata', 'wf_customer_import_export')."</label>
                                    </td>
                                    <td>
                                        <input type='text' name='wt_specific_metas' id='v_specifi_metas' value='$specifi_metas' class='input-text' />
                                            <p style='font-size: 12px'>". __('The meta key name of the additional metadata you wish to export.', 'wf_customer_import_export'). "</p>
                                    </td>
                                </tr>";
            }
            echo $res;
            exit;
        }
	
	
     /**
     * Ajax event to test FTP details
     */
    public function test_ftp_credentials() {
        $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
        if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !WF_Customer_Import_Export_CSV::hf_user_permission()) {
            wp_die(__('Access Denied', 'wf_customer_import_export'));
        }
        $wf_ftp_details = array();
        $wf_ftp_details['host'] = !empty($_POST['ftp_host']) ? $_POST['ftp_host'] : '';
        $wf_ftp_details['port'] = !empty($_POST['ftp_port']) ? $_POST['ftp_port'] : 21;
        $wf_ftp_details['userid'] = !empty($_POST['ftp_userid']) ? $_POST['ftp_userid'] : '';
        $wf_ftp_details['password'] = !empty($_POST['ftp_password']) ? $_POST['ftp_password'] : '';
        $wf_ftp_details['use_ftps'] = !empty($_POST['use_ftps']) ? $_POST['use_ftps'] : 0;
        $wf_ftp_details['is_sftp'] = !empty($_POST['is_sftp']) ? true : false;
        if (class_exists('class_wf_sftp_import_export') && $wf_ftp_details['is_sftp'] === true) {
            $sftp_import = new class_wf_sftp_import_export();
            $sftp_conn = $sftp_import->connect($wf_ftp_details['host'], $wf_ftp_details['userid'], $wf_ftp_details['password'], $wf_ftp_details['port']);
            if (!$sftp_conn) {
                die("<div id= 'prod_ftp_test_msg' style = 'color : red'>Could not connect to Host. Server host / IP or Port may be wrong.</div>");
            } else {
                die("<div id= 'prod_ftp_test_msg' style = 'color : green'>sFTP successfully logged in.</div>");
            }
        } else {
            $ftp_conn = (!empty($wf_ftp_details['use_ftps'])) ? @ftp_ssl_connect($wf_ftp_details['host'], $wf_ftp_details['port']) : @ftp_connect($wf_ftp_details['host'], $wf_ftp_details['port']);
            if ($ftp_conn == false) {
                die("<div id= 'user_impexp_ftp_test_msg' style = 'color : red'>Could not connect to Host. Server host / IP or Port may be wrong.</div>");
            }
            if (@ftp_login($ftp_conn, $wf_ftp_details['userid'], $wf_ftp_details['password'])) {
                die("<div id= 'user_impexp_ftp_test_msg' style = 'color : green'>Successfully logged in.</div>");
            } else {
                die("<div id= 'user_impexp_ftp_test_msg' style = 'color : blue'>Connected to host but could not login. Server UserID or Password may be wrong or Try with / without FTPS .</div>");
            }
        }
    }

}

new WF_CustomerImpExpCsv_AJAX_Handler();
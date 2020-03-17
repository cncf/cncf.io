<?php

if (!defined('ABSPATH')) {
    exit;
}

class WF_CustomerImpExpCsv_Settings {

    /**
     * User Exporter Tool
     */
    public static function save_settings($section = NULL,$profile_name = NULL) {
        global $wpdb;

        if($section == 'ftp'){
            
            $ftp_server		= !empty($_POST['ftp_server']) ? $_POST['ftp_server'] : '';
            $ftp_user		= !empty($_POST['ftp_user']) ? $_POST['ftp_user'] : '';
            $ftp_password	= !empty($_POST['ftp_password']) ? $_POST['ftp_password'] : '';
            $ftp_port		= !empty($_POST['ftp_port']) ? $_POST['ftp_port'] : 21;
            $use_ftps		= !empty($_POST['use_ftps']) ? true : false;
            $use_pasv		= !empty($_POST['use_pasv']) ? true : false;
            $is_sftp            = !empty($_POST['is_sftp']) ? true : false;
            $profile            = !empty($_POST['profile_name']) ? $_POST['profile_name'] : '';
            
            $settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
            
            $settings['ftp'][$profile]['ftp_server']	= $ftp_server;
            $settings['ftp'][$profile]['ftp_user']	= $ftp_user;
            $settings['ftp'][$profile]['ftp_password']	= $ftp_password;
            $settings['ftp'][$profile]['ftp_port']	= $ftp_port;
            $settings['ftp'][$profile]['use_ftps']	= $use_ftps;
            $settings['ftp'][$profile]['use_pasv']	= $use_pasv;
            $settings['ftp'][$profile]['is_sftp']	= $is_sftp;
            
            update_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', $settings);
            
            wp_redirect(admin_url('/admin.php?page=' . HF_WORDPRESS_CUSTOMER_IM_EX . '&tab=settings&section=ftp'));
            exit;
        } elseif ($section == 'delete' && $profile_name != NULL) {
            $settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
            
            if(isset($settings['ftp'][$profile_name])){
                unset($settings['ftp'][$profile_name]);
            }
            
            update_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', $settings);
            
            wp_redirect(admin_url('/admin.php?page=' . HF_WORDPRESS_CUSTOMER_IM_EX . '&tab=settings&section=ftp'));
            exit;
        } elseif ($section == 'export') {
            $settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
            
            $usr_auto_export                = !empty($_POST['usr_auto_export']) ? TRUE : FALSE;
            $usr_auto_export_path           = !empty($_POST['usr_auto_export_path']) ? $_POST['usr_auto_export_path'] : '/';
            $usr_auto_export_file_name      = !empty($_POST['usr_auto_export_file_name']) ? $_POST['usr_auto_export_file_name'] : null;
            $usr_auto_export_start_time     = !empty($_POST['usr_auto_export_start_time']) ? $_POST['usr_auto_export_start_time'] : '';
            $usr_auto_export_interval       = !empty($_POST['usr_auto_export_interval']) ? $_POST['usr_auto_export_interval'] : '';
            $user_auto_export_profile       = !empty($_POST['user_auto_export_profile']) ? $_POST['user_auto_export_profile'] : '';
            $v_include_metadata_cron        = !empty($_POST['v_include_metadata_cron']) ? true : false;
            $usr_auto_export_ftp_profile    = !empty($_POST['usr_auto_export_ftp_profile']) ? $_POST['usr_auto_export_ftp_profile'] : '';
            $usr_auto_export_user_roles = !empty($_POST['user_roles']) ? $_POST['user_roles'] : array();
            
            $usr_auto_export_limit = !empty($_POST['limit']) ? intval($_POST['limit']) : '';
            $usr_auto_export_offset = !empty($_POST['offset']) ? intval($_POST['offset']) : '';
            $usr_auto_user_ids = !empty($_POST['user_email']) ? $_POST['user_email'] : array();
            $usr_auto_export_start_date = !empty($_POST['fromdate']) ? $_POST['fromdate'] : '';
            $usr_auto_export_end_date = !empty($_POST['todate']) ? $_POST['todate'] : '';
            $usr_auto_delimiter = !empty($_POST['delimiter']) ? $_POST['delimiter'] : '';
        
            $usr_orig_export_start_inverval = '';
            if (isset($settings['usr_auto_export_start_time']) && isset($settings['usr_auto_export_interval'])) {
                $usr_orig_export_start_inverval = $settings['usr_auto_export_start_time'] . $settings['usr_auto_export_interval'];
            }
            
            $settings['usr_auto_export']                = $usr_auto_export;
            $settings['usr_auto_export_path']           = $usr_auto_export_path;
            $settings['usr_auto_export_file_name']      = $usr_auto_export_file_name;
            $settings['usr_auto_export_start_time']     = $usr_auto_export_start_time;
            $settings['usr_auto_export_interval']       = $usr_auto_export_interval;
            $settings['user_auto_export_profile']      = $user_auto_export_profile ;
            $settings['v_include_metadata_cron']        = $v_include_metadata_cron;
            $settings['usr_auto_export_ftp_profile']    = $usr_auto_export_ftp_profile;
            $settings['usr_auto_export_user_roles']    = $usr_auto_export_user_roles;
            
            $settings['usr_auto_export_limit']         = $usr_auto_export_limit;
            $settings['usr_auto_export_offset']        = $usr_auto_export_offset;
            $settings['usr_auto_user_ids']             = $usr_auto_user_ids;
            $settings['usr_auto_export_start_date']    = $usr_auto_export_start_date;
            $settings['usr_auto_export_end_date']      = $usr_auto_export_end_date;
            $settings['usr_auto_delimiter']            = $usr_auto_delimiter;
           
        
            update_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', $settings);
            
            if (($usr_orig_export_start_inverval !== $settings['usr_auto_export_start_time'] . $settings['usr_auto_export_interval']) || ($settings['usr_auto_export'] === FALSE)) {
                wp_clear_scheduled_hook('hf_customer_im_ex_auto_export_user');
            }
            
            wp_redirect(admin_url('/admin.php?page=' . HF_WORDPRESS_CUSTOMER_IM_EX . '&tab=settings&section=export'));
            exit;
        } elseif ($section == 'import') {
            $settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
            
            $usr_auto_import                = !empty($_POST['usr_auto_import']) ? TRUE : FALSE;
            $usr_auto_import_start_time     = !empty($_POST['usr_auto_import_start_time']) ? $_POST['usr_auto_import_start_time'] : '';
            $usr_auto_import_interval       = !empty($_POST['usr_auto_import_interval']) ? $_POST['usr_auto_import_interval'] : '';
            $usr_auto_import_ftp_profile    = !empty($_POST['usr_auto_import_ftp_profile']) ? $_POST['usr_auto_import_ftp_profile'] : '';
            $usr_auto_import_merge          = !empty($_POST['usr_auto_import_merge']) ? true : false;
            $usr_auto_import_profile        = !empty($_POST['usr_auto_import_profile']) ? $_POST['usr_auto_import_profile'] : '';
            $usr_auto_import_path           = !empty($_POST['usr_auto_import_path']) ? $_POST['usr_auto_import_path'] : '';
            
            $usr_orig_import_start_inverval = '';
            if (isset($settings['usr_auto_import_start_time']) && isset($settings['usr_auto_import_interval'])) {
                $usr_orig_import_start_inverval = $settings['usr_auto_import_start_time'] . $settings['usr_auto_import_interval'];
            }
            
            $settings['usr_auto_import']                = $usr_auto_import;
            $settings['usr_auto_import_start_time']     = $usr_auto_import_start_time;
            $settings['usr_auto_import_interval']       = $usr_auto_import_interval;
            $settings['usr_auto_import_ftp_profile']    = $usr_auto_import_ftp_profile;
            $settings['usr_auto_import_merge']          = $usr_auto_import_merge;
            $settings['usr_auto_import_profile']        = $usr_auto_import_profile;
            $settings['usr_auto_import_path']           = $usr_auto_import_path;
            
            update_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', $settings);
            
            if (($usr_orig_import_start_inverval !== $settings['usr_auto_import_start_time'] . $settings['usr_auto_import_interval']) || ($settings['usr_auto_import'] === FALSE)) {
                wp_clear_scheduled_hook('wf_user_csv_im_ex_auto_import_user');
            }
            
            wp_redirect(admin_url('/admin.php?page=' . HF_WORDPRESS_CUSTOMER_IM_EX . '&tab=settings&section=import'));
            exit;
        }elseif ($section == 'email') {
              $enable_email_templates              = !empty($_POST['enable_email_templates']) ? TRUE : FALSE;
              $subject_mail                        = !empty($_POST['subject_mail']) ? $_POST['subject_mail'] : '';
              $body_mail                           = wp_kses_post( stripslashes( $_POST["body_mail"] ) );
              
              $enable_update_mail_template                = !empty($_POST['enable_update_mail_template']) ? TRUE : FALSE;
              $subject_mail_update                        = !empty($_POST['subject_mail_update']) ? $_POST['subject_mail_update'] : '';
              $body_mail_update                           = wp_kses_post( stripslashes( $_POST["body_mail_update"] ) );
              
            $settings['enable_email_templates']       = $enable_email_templates;
            $settings['subject_mail']                 = $subject_mail;
            $settings['body_mail']                    = $body_mail;
            
            $settings['enable_update_mail_template']         = $enable_update_mail_template;
            $settings['subject_mail_update']                 = $subject_mail_update;
            $settings['body_mail_update']                    = $body_mail_update;
            
            update_option('wt_' . WT_CUSTOMER_IMP_EXP_ID . '_mail_option', $settings);
              
              wp_redirect(admin_url('/admin.php?page=' . HF_WORDPRESS_CUSTOMER_IM_EX . '&tab=expimp&section=email'));
              exit;
      
        }
    }
}

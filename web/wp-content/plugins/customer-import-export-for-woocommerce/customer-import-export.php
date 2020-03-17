<?php

/*
  Plugin Name: WordPress Users & WooCommerce Customers Import Export
  Plugin URI: https://www.webtoffee.com/product/wordpress-users-woocommerce-customers-import-export/
  Description: Export and Import User/Customers details From and To your WordPress/WooCommerce.
  Author: WebToffee
  Author URI: https://www.webtoffee.com/
  Version: 1.3.7
  WC tested up to: 3.9.3
  Text Domain: wf_customer_import_export
 */




if (!defined('WPINC')) {
   return;
}

/**
 * Function to check whether Basic version of User Import Export plugin is installed or not
 */
function wf_wordpress_user_import_export_basic_check(){
	if ( is_plugin_active('users-customers-import-export-for-wp-woocommerce/users-customers-import-export-for-wp-woocommerce.php') ){
		deactivate_plugins( basename( __FILE__ ) );
		wp_die(__("You already have the Basic version installed. Please disable & remove the Basic Version before enabling Premium Version. For any issues, kindly contact our <a target='_blank' href='https://www.webtoffee.com/support/'>support</a>.", "wf_customer_import_export"), "", array('back_link' => 1 ));
	}
}
register_activation_hook( __FILE__, 'wf_wordpress_user_import_export_basic_check' );


if( !defined('WT_CUSTOMER_IMP_EXP_ID') )
{
	define("WT_CUSTOMER_IMP_EXP_ID", "wt_customer_imp_exp");
}
if( !defined('HF_WORDPRESS_CUSTOMER_IM_EX') )
{
	define("HF_WORDPRESS_CUSTOMER_IM_EX", "hf_wordpress_customer_im_ex");
}

if( !defined('WT_CUSTOMER_IMP_EXP_VER') )
{
	define("WT_CUSTOMER_IMP_EXP_VER", "1.3.7");
}

if (!class_exists('WF_Customer_Import_Export_CSV')) :

    /*
     * Main CSV Import class
     */

    class WF_Customer_Import_Export_CSV {
    
        public $cron_export;
        public $cron_import;

        /**
         * Constructor
         */
        public function __construct() {
	    
	    if( !defined('WF_CustomerImpExpCsv_FILE') )
	    {
		define('WF_CustomerImpExpCsv_FILE', __FILE__);
	    }

            if (is_admin()) {
                add_action('admin_notices', array($this, 'wf_customer_ie_admin_notice'), 15);
                include_once ( 'includes/wf_api_manager/wf-api-manager-config.php' );
            }

            add_filter('woocommerce_screen_ids', array($this, 'woocommerce_screen_ids'));
            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'wf_plugin_action_links'));
            add_action('init', array($this, 'load_plugin_textdomain'));
            add_action('init', array($this, 'catch_export_request'), 20);
            add_action('init', array($this, 'catch_save_settings'), 20);
            add_action('admin_init', array($this, 'register_importers'));

            include_once( 'includes/class-wf-customerimpexpcsv-admin-screen.php' );
            include_once( 'includes/importer/class-wf-customerimpexpcsv-importer.php' );

            
                require_once( 'includes/class-wf-customerimpexpcsv-cron.php' );
                $this->cron_export = new WF_CustomerImpExpCsv_Cron();
                //$this->cron_export->wf_scheduled_export_user();
                register_activation_hook(__FILE__, array($this->cron_export, 'wf_new_scheduled_export_user'));
                register_deactivation_hook(__FILE__, array($this->cron_export, 'clear_wf_scheduled_export_user'));
                
                if (defined('DOING_AJAX')) {
                    include_once( 'includes/class-wf-customerimpexpcsv-ajax-handler.php' );
                }

                require_once( 'includes/class-wf-customerimpexpcsv-import-cron.php' );
                $this->cron_import = new WF_CustomerImpExpCsv_ImportCron();
                //$this->cron_import->wf_scheduled_import_user();
                register_activation_hook(__FILE__, array($this->cron_import, 'wf_new_scheduled_import_user'));
                register_deactivation_hook(__FILE__, array($this->cron_import, 'clear_wf_scheduled_import_user'));            
        }

        public function wf_plugin_action_links($links) {
            $plugin_links = array(
                '<a href="' . admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp') . '">' . __('Import Export Users/Customers', 'wf_customer_import_export') . '</a>',
                '<a href="https://www.webtoffee.com/category/documentation/wordpress-users-woocommerce-customers-import-export/" target="_blank">' . __('Documentation', 'wf_customer_import_export') . '</a>',
                '<a href="https://www.webtoffee.com/support/" target="_blank">' . __('Support', 'wf_customer_import_export') . '</a>'
            );
            return array_merge($plugin_links, $links);
        }

        function wf_customer_ie_admin_notice() {
            global $pagenow;
            global $post;

            if (!isset($_GET["wf_customer_ie_msg"]) && empty($_GET["wf_customer_ie_msg"])) {
                return;
            }

            $wf_customer_ie_msg = $_GET["wf_customer_ie_msg"];

            switch ($wf_customer_ie_msg) {
                case "1":
                    echo '<div class="update"><p>' . __('Successfully uploaded via FTP.', 'wf_customer_import_export') . '</p></div>';
                    break;
                case "2":
                    echo '<div class="error"><p>' . __('Error while uploading via FTP.', 'wf_customer_import_export') . '</p></div>';
                    break;
            }
        }

        /**
         * Add screen ID
         */
        public function woocommerce_screen_ids($ids) {
            $ids[] = 'admin'; // For import screen
            return $ids;
        }

        /**
         * Handle localisation
         */
        public function load_plugin_textdomain() {
            load_plugin_textdomain('wf_customer_import_export', false, dirname(plugin_basename(__FILE__)) . '/lang/');
        }

        /**
         * Catches an export request and exports the data. This class is only loaded in admin.
         */
        public function catch_export_request() {                        
            if (!empty($_GET['action']) && !empty($_GET['page']) && $_GET['page'] == 'hf_wordpress_customer_im_ex') {                  
                switch ($_GET['action']) {
                    case "export" :
                        $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');                       
                        if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !self::hf_user_permission()) {                   
                            wp_die(__('Access Denied', 'wf_customer_import_export'));                                        
                        }
                        include_once( 'includes/exporter/class-wf-customerimpexpcsv-exporter.php' );
                        $user_id = array();
                        $ftp =  1;
                        WF_CustomerImpExpCsv_Exporter::do_export($user_id,$ftp);
                        break;                     
                    case "quickexport" :
                        $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
                        if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !self::hf_user_permission()) {                   
                            wp_die(__('Access Denied', 'wf_customer_import_export'));                                        
                        }
                        include_once( 'includes/exporter/class-wf-customerimpexpcsv-quickexporter.php' );
                        WF_CustomerImpExpCsv_Quick_Exporter::do_export();
                        break;
                }
            }
        }

        public function catch_save_settings() {
            if (!empty($_GET['action']) && !empty($_GET['section']) && !empty($_GET['page']) && $_GET['page'] == 'hf_wordpress_customer_im_ex') {                
                switch ($_GET['action']) {
                    case "settings" :   

                        if(isset($_GET['wt_nonce']) && !empty($_GET['wt_nonce'])){
                            $nonce = (isset($_GET['wt_nonce']) ? sanitize_text_field($_GET['wt_nonce']) : '');
                        }
                        
                        if(isset($_POST['wt_nonce']) && !empty($_POST['wt_nonce'])){
                            $nonce = (isset($_POST['wt_nonce']) ? sanitize_text_field($_POST['wt_nonce']) : '');
                        }
                        
                        if (!wp_verify_nonce($nonce,WT_CUSTOMER_IMP_EXP_ID) || !self::hf_user_permission()) {                   
                            wp_die(__('Access Denied', 'wf_customer_import_export'));                                        
                        }
                        
                        if(!empty($_GET['profile'])){
                            include_once( 'includes/settings/class-wf-customerimpexpcsv-settings.php' );
                            WF_CustomerImpExpCsv_Settings::save_settings($_GET['section'],$_GET['profile']);
                            break;
                        } else {
                            include_once( 'includes/settings/class-wf-customerimpexpcsv-settings.php' );
                            WF_CustomerImpExpCsv_Settings::save_settings($_GET['section']);
                            break;
                        }
                }
            }
        }

        /**
         * Register importers for use
         */
        public function register_importers() {
            register_importer('wordpress_hf_user_csv', 'WordPress User/Customers (CSV)', __('Import <strong>users/customers</strong> to your site via a csv file.', 'wf_customer_import_export'), 'WF_CustomerImpExpCsv_Importer::customer_importer');
            register_importer('wordpress_hf_user_csv_cron', 'WordPress User/Customers Cron(CSV)', __('Cron Import <strong>users and customers</strong> to your store via a csv file.', 'wf_customer_import_export'), 'WF_CustomerImpExpCsv_ImportCron::user_importer');
        }
        
        public static function hf_user_permission() {
            // Check if user has rights to export
            $current_user = wp_get_current_user();
            $current_user->roles = apply_filters('hf_add_user_roles', $current_user->roles);
            $current_user->roles = array_unique($current_user->roles);
            $user_ok = false;

            $wf_roles = apply_filters('hf_user_permission_roles', array('administrator', 'shop_manager'));
            if ($current_user instanceof WP_User) {
                $can_users = array_intersect($wf_roles, $current_user->roles);
                if (!empty($can_users)) {
                    $user_ok = true;
                }
            }
            return $user_ok;
        }
                                                
    }

    endif;

new WF_Customer_Import_Export_CSV();

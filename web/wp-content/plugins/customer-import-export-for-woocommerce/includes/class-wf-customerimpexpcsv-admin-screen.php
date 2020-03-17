<?php
if (!defined('ABSPATH')) {
    exit;
}

class WF_CustomerImpExpCsv_Admin_Screen {

    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_print_styles', array($this, 'admin_scripts'));
        add_action('admin_notices', array($this, 'admin_notices'));

        add_action('admin_footer', array($this, 'add_user_bulk_actions'));
        
        add_action('load-users.php', array($this, 'process_users_bulk_actions'));
        
        //add_action('bulk_actions-users', array($this, 'add_user_action'), 10, 2); if admin_footer hook is removed, enable this and comment line 16 
//        if (is_admin()) {
            add_action('wp_ajax_wc_customer_csv_export_single', array($this, 'process_ajax_export_single_user'));
//        }
    }

    /**
     * Notices in admin
     */
    public function admin_notices() {
        if (!function_exists('mb_detect_encoding')) {
            echo '<div class="error"><p>' . __('User/Customer CSV Import Export requires the function <code>mb_detect_encoding</code> to import and export CSV files. Please ask your hosting provider to enable this function.', 'wf_customer_import_export') . '</p></div>';
        }
    }

    /**
     * Admin Menu
     */
    public function admin_menu() {
        $page = add_users_page( __( 'User Import Export', 'wf_customer_import_export' ), __( 'User Import Export', 'wf_customer_import_export' ), 'list_users', 'hf_wordpress_customer_im_ex', array( $this, 'output' ) );
        $page1 = add_submenu_page( 'woocommerce', __( 'Customer Import Export', 'wf_customer_import_export' ), __( 'Customer Import Export', 'wf_customer_import_export' ),  'manage_woocommerce', 'hf_wordpress_customer_im_ex', array( $this, 'output' ) );
    }

    /**
     * Admin Scripts
     */
    public function admin_scripts() {
        global $wp_scripts;
        //wp_enqueue_script('chosen');
        if(function_exists('WC')){
            wp_enqueue_style('woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css');
            wp_enqueue_script('wc-enhanced-select');
        } else {
            wp_enqueue_style('wt-user-csv-importer-select2-css', plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/styles/select2.css', basename(__FILE__)), '', WT_CUSTOMER_IMP_EXP_VER, '');
            wp_enqueue_script('wt-user-csv-importer-select2-js', plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/js/select2.js', basename(__FILE__)), array(), WT_CUSTOMER_IMP_EXP_VER, true);
        }
        wp_enqueue_style('woocommerce-user-csv-importer', plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/styles/wf-style.css', basename(__FILE__)), '', '1.0.2', 'screen');
        wp_enqueue_script('woocommerce-user-csv-importer', plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/js/hf-user-csv-importer.js', basename(__FILE__)), array(), '2.0.1', true);
        wp_localize_script('woocommerce-user-csv-importer', 'woocommerce_user_csv_import_params', array('calendar_icon' => plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/images/calendar.png', basename(__FILE__)),'profile_empty_msg'=> __('Please enter a profile name.','wf_customer_import_export'), 'nonce' => wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ));
        wp_localize_script('woocommerce-user-csv-importer', 'woocommerce_user_csv_export_params', array('siteurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ));
        wp_localize_script('woocommerce-user-csv-importer', 'woocommerce_user_csv_cron_params', array('usr_auto_export' => '', 'usr_auto_import' => ''));
        wp_enqueue_script('jquery-ui-datepicker');
        $jquery_version = isset($wp_scripts->registered['jquery-ui-core']->ver) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';
        wp_enqueue_style('jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/' . $jquery_version . '/themes/smoothness/jquery-ui.css');
    }

    /**
     * Admin Screen output
     */
    public function output() {
        $tab = 'expimp';        
        if (!empty($_GET['tab'])) {
            if ($_GET['tab'] == 'settings') {
                $tab = 'settings';
            } else if ($_GET['tab'] == 'licence') {
                $tab = 'licence';
            } else if ($_GET['tab'] == 'help') {
                $tab = 'help';
            }
        }
        include( 'views/html-wf-admin-screen.php' );
    }

    public function add_user_bulk_actions() {
        
        global $post_type, $post_status;

        $screen = get_current_screen();
        if ($screen->id != "users")   // Only add to users.php page
            return;
    ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    var $downloadToXml = $('<option>').val('hf_download_user_to_csv').text('<?php _e('Download as CSV', 'wf_customer_import_export') ?>');

                    $('select[name^="action"]').append($downloadToXml);
                });
            </script>
            <?php
       
    }

    /**
     * user page bulk export action
     * 
     */
    public function process_users_bulk_actions() {                
        global $typenow;
        $ftp = 1;
        $wp_list_table = _get_list_table('WP_Posts_List_Table');
        $action = $wp_list_table->current_action();
        if (!in_array($action, array('hf_download_user_to_csv'))) {
            return;
        }
        // security check
        
        $nonce = (isset($_REQUEST['_wpnonce']) ? sanitize_text_field($_REQUEST['_wpnonce']) : ''); 
       
        if( ! wp_verify_nonce( $nonce, 'bulk-users')  ||  ! WF_Customer_Import_Export_CSV::hf_user_permission() ) {
            wp_die(__('Access Denied', 'wf_customer_import_export'));      
        }
        if (isset($_REQUEST['users'])) {
            $user_ids = array_map('absint', $_REQUEST['users']);
        }
        if (empty($user_ids)) {
            return;
        }
        // give an unlimited timeout if possible
        @set_time_limit(0);

        if ($action == 'hf_download_user_to_csv') {
            include_once( 'exporter/class-wf-customerimpexpcsv-exporter.php' );
            WF_CustomerImpExpCsv_Exporter::do_export($user_ids,$ftp);
        }
       
    }

    /**
     * Add single user download option on action list
     */
    public function add_user_action($actions) {
        $actions['hf_download_user_to_csv'] = 'Download as CSV';
        return $actions;
    }

    /**
     * Single user export
     */
    public function process_ajax_export_single_user() {
        $nonce = (isset($_POST['_wpnonce']) ? sanitize_text_field($_POST['_wpnonce']) : '');                       
        if (!wp_verify_nonce($nonce) || !self::hf_user_permission()) {                   
            wp_die(__('Access Denied', 'wf_customer_import_export'));                                        
        }
        
        if (!is_admin() || !current_user_can('edit_posts')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'wf_customer_import_export'));
        }
        if (!check_admin_referer('wc_customer_csv_export_single')) {
            wp_die(__('You have taken too long, please go back and try again.', 'wf_customer_import_export'));
        }
        $user_id = !empty($_GET['users']) ? absint($_GET['users']) : '';
        if (!$user_id) {
            die;
        }
        $user_IDS = array(0 => $user_id);
        include_once( 'exporter/class-wf-customerimpexpcsv-exporter.php' );
        WF_CustomerImpExpCsv_Exporter::do_export($user_IDS);
        wp_redirect(wp_get_referer());
        exit;
    }

    /**
     * Admin page for importing
     */
    public function admin_import_page() {
        $action = 'admin.php?import=wordpress_hf_user_csv&amp;step=1&amp;section=import';
        $bytes = apply_filters('import_upload_size_limit', wp_max_upload_size());
        $size = size_format($bytes);
        include( 'views/import/html-wf-import-customers.php' );
    }

    /**
     * Admin Page for exporting
     */
    public function admin_export_page() {
        $section = !empty($_GET['section']) ? $_GET['section'] : "quick";
        ?>
        <ul class="subsubsub" style="margin-left: 15px;">
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=quick') ?>" class="<?php if($section == "quick"){ echo "current"; } ?>"><?php _e('Quick Export', 'wf_customer_import_export'); ?></a> | </li>
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=export') ?>" class="<?php if($section == "export"){ echo "current"; } ?>"><?php _e('Export', 'wf_customer_import_export'); ?></a> | </li>
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=import') ?>" class="<?php if($section == "import"){ echo "current"; } ?>"><?php _e('Import', 'wf_customer_import_export'); ?></a> | </li>
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp&section=email') ?>" class="<?php if($section == "email"){ echo "current"; } ?>"><?php _e('Email Settings', 'wf_customer_import_export'); ?></a></li>
        </ul><br/>
        <?php
        if($section == "quick"){
            $this->admin_quick_export_page();
        } elseif ($section == "import") {
            $this->admin_import_page();
        }else{
            if (!empty($_GET['action']) && $_GET['action'] == 'map-and-transform') {
                $post_columns = include( 'exporter/data/data-wf-post-columns.php' );
                $que_args['limit'] = !empty($_GET['limit']) ? intval($_GET['limit']) : 999999999;
                $que_args['offset'] = !empty($_GET['offset']) ? intval($_GET['offset']) : 0;
                $que_args['user_roles'] = (!empty($_GET['user_roles']) && ($_GET['user_roles'] != 'null')) ? explode(',', ($_GET['user_roles'])) : array();
                $que_args['fromdate'] = !empty($_GET['fromdate']) ? $_GET['fromdate'] : '0000-00-00';
                $que_args['todate'] = !empty($_GET['todate']) ? $_GET['todate'] : date('Y-m-d');
                $que_args['user_ids'] = (!empty($_GET['user_email']) && $_GET['user_email'] != 'null') ? explode(',', $_GET['user_email']) : array();
                $que_args['sortby'] = (!empty($_GET['sortby']) && ($_GET['sortby'] != 'null')) ? explode(',', ($_GET['sortby'])) : array();
                $que_args['sort_order'] = !empty($_GET['sort_order']) ? $_GET['sort_order'] : '';
                include( 'views/export/html-wf-export-customers-map-and-transform.php' );
            }elseif ($section == "email") {
                 include( 'views/settings/html-wf-settings-email.php' );
            } else {
                $query_args = array();
                if (!empty($_GET)) {
                    $query_args['export_limit'] = !empty($_GET['limit']) ? intval($_GET['limit']) : 999999999;
                    $query_args['export_offset'] = !empty($_GET['offset']) ? intval($_GET['offset']) : 0;
                    $query_args['export_user_roles'] = !empty($_GET['user_roles']) ? $_GET['user_roles'] : array();
                    $query_args['export_fromdate'] = !empty($_GET['fromdate']) ? $_GET['fromdate'] : '0000-00-00';
                    $query_args['export_todate'] = !empty($_GET['todate']) ? $_GET['todate'] : date('Y-m-d');
                    $query_args['user_email'] = !empty($_GET['user_email']) ? $_GET['user_email'] : array();
                    $query_args['sortby'] = (!empty($_GET['sortcolumn']) && ($_GET['sortcolumn'] != 'null')) ? ($_GET['sortcolumn']): array();
                    $query_args['sort_order'] = !empty($_GET['sort_ord']) ? $_GET['sort_ord'] : '';
                }
                include('exporter/data/class-wf-list-table.php');
                //Create an instance of our package class...
                $wfListTable = new WF_list_table();

                //Fetch, prepare, sort, and filter our data...
                $wfListTable->prepare_items($query_args);
                include( 'views/export/html-wf-export-customers.php' );
            }
        }
    }
    
    /**
     * Admin Page for quick exporting
     */
    public function admin_quick_export_page(){
        $post_columns = include( 'exporter/data/data-wf-quick-post-columns.php' );
        include( 'views/export/html-wf-quick-export-customers.php' );
    }

        /**
     * Admin page for help
     */
    public function admin_help_page() {        
        include('views/html-wf-help-guide.php');
    }

    /**
     * Admin Page for settings
     */
    public function admin_settings_page() {
        $section = !empty($_GET['section']) ? $_GET['section'] : "ftp";
        ?>
        <ul class="subsubsub" style="margin-left: 15px;">
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=settings&section=ftp') ?>" class="<?php if($section == "ftp"){ echo "current"; } ?>"><?php _e('FTP', 'wf_customer_import_export'); ?></a> | </li>
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=settings&section=export') ?>" class="<?php if($section == "export"){ echo "current"; } ?>"><?php _e('Export Scheduler', 'wf_customer_import_export'); ?></a> | </li>
            <li><a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=settings&section=import') ?>" class="<?php if($section == "import"){ echo "current"; } ?>"><?php _e('Import Scheduler', 'wf_customer_import_export'); ?></a></li>
        </ul><br/>
        <?php
        if ($section == "export"){
            include( 'views/settings/html-wf-settings-scheduled-export.php' );
        }elseif ($section == "import") {
            include( 'views/settings/html-wf-settings-scheduled-import.php' );
        }else {
            include( 'settings/class-wf-list-table-settings.php' );
            //Create an instance of our package class...
                $wfSettingsListTable = new WF_settings_list_table();

                //Fetch, prepare, sort, and filter our data...
                $wfSettingsListTable->prepare_items();
            include( 'views/settings/html-wf-settings-customers.php' );
        }
    }
    
    public function admin_licence_page($plugin_name) {
        include( 'wf_api_manager/html/html-wf-activation-window.php' );
    }

}

new WF_CustomerImpExpCsv_Admin_Screen();
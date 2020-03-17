<?php

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class WF_settings_list_table extends WP_List_Table {
    
    function __construct() {
        global $status, $page;

        //Set parent defaults
        parent::__construct(array(
            'singular' => 'profile', //singular name of the listed records
            'plural' => 'profiles', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
    }

    function get_settings_list(){
        $data = array();
        $settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
        if(isset($settings['ftp']) && !empty($settings['ftp'])){
            $url = wp_nonce_url(admin_url('admin.php?page=hf_wordpress_customer_im_ex&action=settings&section=delete&tab=settings'),WT_CUSTOMER_IMP_EXP_ID,'wt_nonce');
            foreach ($settings['ftp'] as $key => $value) {
                $delete = sprintf('<a href="'.$url.'&profile=%s" onclick="return confirm(\''."Are you sure you want to delete this item?".'\');">Delete</a>',$key);
                $view = '<a style="cursor: pointer;" onclick="openProfileForm(\''.$key .'\')">View/Edit</a>';
                $data[] = array(
                    'profile' => $key,
                    'host'    => $value['ftp_server'],
                    'actions' => $view." ".$delete
                );
            }
        }
        return $data;
    }
                
    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'profile':
            case 'host':
            case 'actions':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function get_columns() {
        $columns = array(
            'profile'   => 'Profile',
            'host'      => 'Server Host/IP',
            'actions'   => 'Actions',
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'profile' => array('profile', true), //true means it's already sorted
            'host' => array('host', true),
        );
        return $sortable_columns;
    }
    
    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 5;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $data = $this->get_settings_list();
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'profile'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
        
        $current_page = $this->get_pagenum();
        $total_items = count($data);

        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}
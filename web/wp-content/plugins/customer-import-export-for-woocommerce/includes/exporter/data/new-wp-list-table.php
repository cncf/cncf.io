<?php
/*
Plugin Name: New WP List Table
*/

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class New_wp_list_table extends WP_List_Table {

     function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'user',     //singular name of the listed records
            'plural'    => 'users',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

   

    function nwl_users_list($query_args=array()){
        global $wpdb;
        $query_args['export_fromdate'] = !empty($query_args['export_fromdate'])?$query_args['export_fromdate']:'0000-00-00';
        $query_args['export_todate'] = !empty($query_args['export_todate'])?$query_args['export_todate']:date('Y-m-d');
         $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => '',
            'role__in'     => !empty($query_args['export_user_roles'])?$query_args['export_user_roles']:array(),
            'role__not_in' => array(),
            'meta_key'     => '',
            'meta_value'   => '',
            'meta_compare' => '',
            'meta_query'   => array(),
            'date_query'   => array(
                                array(
                                    'after' => $query_args['export_fromdate'],
                                    'before' => $query_args['export_todate'],
                                    'inclusive' => true
                                )),        
            'include'      => array(),
            'exclude'      => array(),
            'orderby'      => 'login',
            'order'        => 'ASC',
            'offset'       => !empty($query_args['export_offset']) ? $query_args['export_offset'] : '',
            'search'       => '',
            'number'       => !empty($query_args['export_limit']) ? $query_args['export_limit'] : '',
            'count_total'  => false,
            'fields'       => 'all',
            'who'          => ''
        ); 

        $blogusers = get_users( $args );
        $user_data_array = array();
        if($blogusers){
            foreach ($blogusers as $value) {
            $user_data_array[]= array(
                'ID'        =>  $value->data->ID,
                'user_login'     =>  $value->data->user_login,
                'display_name'    => $value->data->display_name,
                'user_email'  => $value->data->user_email,
                'role' => $value->roles[0],
                'date'  => date('Y-m-d', strtotime($value->data->user_registered)),
            );

            }
        }
        return $user_data_array;
    }

    function column_default($item, $column_name){
        switch($column_name){
            case 'user_login':
            case 'display_name':
            case 'user_email':
                return $item[$column_name];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_title($item){
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>',
            /*$1%s*/ $item['user_login'],
            /*$2%s*/ $item['ID']
        );
    }

    function column_cb($item){
        return sprintf(
            '<input type="hidden" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }

    function get_columns(){
        $columns = array(
            'user_login'     => 'Username',
            'display_name'    => 'Name',
            'user_email'  => 'Email'
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'user_login'     => array('user_login',false),     //true means it's already sorted
            'display_name'    => array('display_name',false),
            'user_email'  => array('user_email',false)
        );
        return $sortable_columns;
    }

   

    function prepare_items($query_args=array()) {
        global $wpdb;
        $per_page = 10;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden);
        $data = $this->nwl_users_list($query_args);
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'user_login'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');

        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}


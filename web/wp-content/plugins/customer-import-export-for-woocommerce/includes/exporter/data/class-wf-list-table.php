<?php

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class WF_list_table extends WP_List_Table {
    public $roles_arr;
    
    function __construct() {
        global $status, $page;
        
        $this->roles_arr = $this->get_all_role_names();

        //Set parent defaults
        parent::__construct(array(
            'singular' => 'user', //singular name of the listed records
            'plural' => 'users', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
    }
    
    function get_all_role_names(){
        global $wpdb;
        $role_query = "SELECT option_value FROM {$wpdb->options} WHERE option_name = '{$wpdb->prefix}user_roles'";
        $user_roles = $wpdb->get_var($role_query);
        $user_roles = unserialize($user_roles);
        $role_arr = array();
        if(!empty($user_roles)){
            foreach ($user_roles as $role => $name){
                $role_arr[$role] = $name['name'];
            }
        }
        return $role_arr;
    }
    
    function wt_users_count($query_args = array()) {
        global $wpdb;
        $export_fromdate = !empty($query_args['export_fromdate']) ? $query_args['export_fromdate'] : '0000-00-00';
        $export_todate = !empty($query_args['export_todate']) ? $query_args['export_todate'] : date('Y-m-d');
        $limit = !empty($query_args['export_limit']) ? $query_args['export_limit'] : '';
        $offset = !empty($query_args['export_offset']) ? $query_args['export_offset'] : '';
        $user_ids = !empty($query_args['user_email']) ? "(".implode(',', $query_args['user_email']).")" : '';
        $query = "SELECT wu.ID FROM {$wpdb->users} AS wu
                INNER JOIN {$wpdb->usermeta} AS um
                ON wu.ID = um.user_id 
                WHERE um.meta_key = '{$wpdb->prefix}capabilities'";
        if (!empty($export_fromdate)) {
            $query .= " AND wu.user_registered >= '$export_fromdate 00:00:00'";
        }
        if (!empty($export_todate)) {
            $query .= " AND wu.user_registered <= '$export_todate 23:59:59'";
        }
        if (!empty($query_args['export_user_roles'])) {
            $query .= " AND (";
            $i = 0;
            foreach ($query_args['export_user_roles'] as $role) {
                $query .= "(um.meta_key = '{$wpdb->prefix}capabilities' AND um.meta_value LIKE '%$role%')" . (array_key_exists($i + 1, $query_args['export_user_roles']) ? ' OR ' : '');
                $i++;
            }
            $query .= ') ';
        }
        if(!empty($user_ids)) {
            $query .= " AND wu.ID IN $user_ids";
        }
        $query .= " ORDER BY wu.user_login";
        if (!empty($offset) && !empty($limit)) {
            $query .= " LIMIT $offset,$limit";
        } else {
            $query .= " LIMIT $limit";
        }
        $users = $wpdb->get_col($query);
        $count = count($users);
        return $count;
    }

    function wt_users_list($query_args = array(), $current_page = 0, $total_items = 0) {
        global $wpdb;
        $export_fromdate = !empty($query_args['export_fromdate']) ? $query_args['export_fromdate'] : '0000-00-00';
        $export_todate = !empty($query_args['export_todate']) ? $query_args['export_todate'] : date('Y-m-d');
        $limit = !empty($query_args['export_limit']) ? $query_args['export_limit'] : '';
        $offset = !empty($query_args['export_offset']) ? $query_args['export_offset'] : 0;
        $sortby = !empty($query_args['sortby']) ? $query_args['sortby'] : array('user_login');
        $sort_order = !empty($query_args['sort_order']) ? $query_args['sort_order'] : 'ASC';
        $user_ids = !empty($query_args['user_email']) ? "(" . implode(',', $query_args['user_email']) . ")" : '';
        $new_offset = (($current_page - 1) * 10) + $offset;
        if (($total_items - ($current_page - 1) * 10) < 10) {
            $new_limit = $total_items - ($current_page - 1) * 10;
        } else {
            $new_limit = 10;
        }

        $s_orderby = array();
        foreach ($sortby as $s_key => $s_value) {

            if (in_array($s_value, array('ID', 'user_registered', 'user_email', 'user_login', 'user_nicename'))) {
                $s_orderby[] = 'wu.' . $s_value . ' ' . $sort_order;
            } elseif (in_array($s_value, array('first_name', 'last_name', 'roles'))) {
                $s_orderby['meta'] = "um." . $s_value . ' ' . $sort_order;
            }
        }
        if (!array_key_exists('meta', $s_orderby)) {
            $query = "SELECT wu.ID,wu.user_login,wu.user_email,wu.user_registered,um.meta_value AS roles FROM {$wpdb->users} AS wu
                INNER JOIN {$wpdb->usermeta} AS um
                ON wu.ID = um.user_id 
                WHERE um.meta_key = '{$wpdb->prefix}capabilities'";
            if (!empty($export_fromdate)) {
                $query .= " AND wu.user_registered >= '$export_fromdate 00:00:00'";
            }
            if (!empty($export_todate)) {
                $query .= " AND wu.user_registered <= '$export_todate 23:59:59'";
            }
            if (!empty($query_args['export_user_roles'])) {
                $query .= " AND (";
                $i = 0;
                foreach ($query_args['export_user_roles'] as $role) {
                    $query .= "(um.meta_key = '{$wpdb->prefix}capabilities' AND um.meta_value LIKE '%$role%')" . (array_key_exists($i + 1, $query_args['export_user_roles']) ? ' OR ' : '');
                    $i++;
                }
                $query .= ') ';
            }
            if (!empty($user_ids)) {
                $query .= " AND wu.ID IN $user_ids";
            }
            if (!empty($s_orderby)) {
                $query .= "ORDER BY " . implode(', ', $s_orderby);
            }
//        $query .= " ORDER BY wu.user_login";
            $query .= " LIMIT $new_offset,$new_limit";
            $users = $wpdb->get_results($query);
        } else {


            $query = "SELECT wu.ID,wu.user_login,wu.user_email,wu.user_registered,um.meta_value AS roles,um2.meta_value AS '$sortby[0]' FROM {$wpdb->users} AS wu
                JOIN {$wpdb->usermeta} AS um
                ON wu.ID = um.user_id JOIN {$wpdb->usermeta} AS um2 ON wu.ID = um2.user_id
                WHERE um.meta_key = '{$wpdb->prefix}capabilities' AND um2.meta_key = '$sortby[0]'";
            if (!empty($export_fromdate)) {
                $query .= " AND wu.user_registered >= '$export_fromdate 00:00:00'";
            }
            if (!empty($export_todate)) {
                $query .= " AND wu.user_registered <= '$export_todate 23:59:59'";
            }
            if (!empty($query_args['export_user_roles'])) {
                $query .= " AND (";
                $i = 0;
                foreach ($query_args['export_user_roles'] as $role) {
                    $query .= "(um.meta_key = '{$wpdb->prefix}capabilities' AND um.meta_value LIKE '%$role%')" . (array_key_exists($i + 1, $query_args['export_user_roles']) ? ' OR ' : '');
                    $i++;
                }
                $query .= ') ';
            }
            if (!empty($user_ids)) {
                $query .= " AND wu.ID IN $user_ids";
            }
//        if(!empty($s_orderby)) {
//        $query .= "ORDER BY " . implode( ', ', $s_orderby );
//        }
//        $query .= " ORDER BY wu.user_login";
            $query .= " LIMIT $new_offset,$new_limit";
            $new_query = "select MAIN.* FROM ($query)as MAIN ORDER BY MAIN.$sortby[0] $sort_order ";
            $users = $wpdb->get_results($new_query);
        }

//        $users = $wpdb->get_results($query);
        $user_data_array = array();
        if ($users) {
            foreach ($users as $value) {
                $user_data_array[] = array(
                    'ID' => $value->ID,
                    'user_login' => $value->user_login,
                    'user_email' => $value->user_email,
                    'role' => !empty($value->roles) ? implode(', ', array_intersect_key($this->roles_arr, unserialize($value->roles))) : 'None',
                    'date' => date('Y-m-d', strtotime($value->user_registered)),
                );
            }
        }
        return $user_data_array;
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'user_login':
            case 'user_email':
            case 'role':
            case 'date':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_title($item) {

        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>',
                /* $1%s */ $item['user_login'],
                /* $2%s */ $item['ID']
        );
    }

    function column_cb($item) {
        return sprintf(
                '<input type="hidden" name="%1$s[]" value="%2$s" />',
                /* $1%s */ $this->_args['singular'], //Let's simply repurpose the table's singular label ("movie")
                /* $2%s */ $item['ID']                //The value of the checkbox should be the record's id
        );
    }

    function get_columns() {
        $columns = array(
            'user_login' => 'Username',
            'user_email' => 'Email',
            'role' => 'Role',
            'date' => 'Date'
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'user_login' => array('user_login', false), //true means it's already sorted
            'user_email' => array('user_email', false),
            'role' => array('role', false),
            'date' => array('date', false)
        );
        return $sortable_columns;
    }

    function prepare_items($query_args = array()) {
        global $wpdb;
        $per_page = 10;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden);

//        function usort_reorder($a, $b) {
//            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'user_login'; //If no sort, default to title
//            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
//            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
//            return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
//        }

        //usort($data, 'usort_reorder');

        $current_page = $this->get_pagenum();
        $total_items = $this->wt_users_count($query_args);
        //$data = array_slice($data, (($current_page - 1) * $per_page), $per_page);
        $data = $this->wt_users_list($query_args, $current_page, $total_items);
        $this->items = $data;
        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
        ));
    }

}

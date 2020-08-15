<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Post_Cache
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Post_Cache
{

    private $sfid = 0;
    private $batch_size = 20;
    private $process_exec_time = 180;
    private $incl__post_types = array();
    private $cache_data = array();
    private $incl__meta_keys = array();
    private $cache_options = array();
    public $WP_FILTER = null;
    private $post_updated_count = 0;
    private $cycle_error_amount = 0;
    private $post_offset = 0;
    private $new_batch_end = 0;
    private $posts_updated = array();

    public function __construct()
    {
        //$this->write_log("`** Search_Filter_Post_Cache` construct **");
        global $wpdb;
	    $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');
	    $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

        $this->table_name_options = $wpdb->prefix . 'options';
        $this->option_name = "search-filter-cache";
        $this->process_exec_time = 60 * 3;
        $cache_speed = Search_Filter_Helper::get_option('cache_speed');

        if (empty($cache_speed)) {
            $cache_speed = "slow";
        }

        $cycle_error_minutes = 1;
        if ($cache_speed == "slow") {
            $this->batch_size = 10;
            $cycle_error_minutes = 2;
        } else if ($cache_speed == "medium") {
            $this->batch_size = 20;
            $cycle_error_minutes = 3;
        } else if ($cache_speed == "fast") {
            $this->batch_size = 40;
            $cycle_error_minutes = 4;
        }
        $this->cycle_error_amount = $cycle_error_minutes * 60; //3 minutes
        $this->process_exec_time = $this->cycle_error_amount;

        /* ajax */
        add_action('wp_ajax_cache_progress', array($this, 'cache_progress'));
        //add_action('wp_ajax_can_wp_remote_post', array($this, 'can_wp_remote_post'));
        add_action('wp_ajax_cache_restart', array($this, 'cache_restart'));
        add_action('wp_ajax_cache_progress_manual', array($this, 'cache_progress_manual'));
        add_action('wp_ajax_cache_restart_manual', array($this, 'cache_restart_manual'));
        add_action('wp_ajax_refresh_cache', array($this, 'refresh_cache'));
        add_action('wp_ajax_nopriv_refresh_cache', array($this, 'refresh_cache'));

        add_action('wp_ajax_process_cache', array($this, 'process_cache'));
        add_action('wp_ajax_nopriv_process_cache', array($this, 'process_cache'));

        add_action('wp_ajax_build_term_results', array($this, 'build_term_results'));
        add_action('wp_ajax_nopriv_build_term_results', array($this, 'build_term_results'));

        add_action('wp_ajax_nopriv_test_remote_connection', array($this, 'test_remote_connection'));
        add_action('wp_ajax_test_remote_connection', array($this, 'test_remote_connection'));

	    add_action('search_filter_delete_post_cache', array($this, 'delete_post_cache'), 10);

        /* save post / re indexing hooks */
        add_action('save_post', array($this, 'post_updated_action'), 800, 3); //priority of 80 so it runs after the regular S&F form save
        add_action('shutdown', array($this, 'wp_shutdown'), 800);

        //add_filter('attachment_fields_to_edit', array($this, 'attachment_updated'), 80, 2);
        add_filter('add_attachment', array($this, 'attachment_added'), 20, 1);
        add_filter('attachment_updated', array($this, 'attachment_updated'), 80, 3);
        add_action('set_object_terms', array($this, 'object_terms_updated'), 80, 4);
        add_filter('updated_postmeta', array($this, 'post_meta_updated'), 80, 4);


        //add_action('search_filter_post_cache_insert_custom_values', array($this, 'insert_post_cache_custom_terms'), 10, 3);
        add_action('search_filter_insert_post_data', array($this, 'insert_post_custom_post_data'), 10, 3);


        //add_action('updated_post_meta', array($this, 'updated_post_meta_updated'), 80, 4);
        //add_filter( 'updated_postmeta', 			array($this, 'post_meta_updated'), 80, 4 );
        //add_filter( 'update_postmeta', 			array($this, 'post_meta_update'), 80, 4 );
        //add_filter( 'deleted_postmeta', 			array($this, 'object_terms_updated'), 80, 3 );


        add_action('edited_terms', array($this, 'taxonomy_edited_terms'), 10, 4);

        /*add_action('new_to_publish', 				array($this, 'post_updated'), 10, 3);
        add_action('private_to_publish', 			array($this, 'post_updated'), 10, 3);
        add_action('draft_to_publish', 				array($this, 'post_updated'), 10, 3);
        add_action('auto-draft_to_publish', 		array($this, 'post_updated'), 10, 3);
        add_action('future_to_publish', 			array($this, 'post_updated'), 10, 3);
        add_action('pending_to_publish', 			array($this, 'post_updated'), 10, 3);
        add_action('inherit_to_publish', 			array($this, 'post_updated'), 10, 3);*/

        //$this->init_cache_options();
        //$this->setup_cached_search_forms();

	    //was in search_filter_global, but needs to be available in admin
	    add_action('search_filter_update_post_cache', array($this, 'update_cache_action'), 10);
    }

	public function update_cache_action($postID)
	{
		$this->init_cache_options();
		$this->setup_cached_search_forms();
		$this->update_post_cache($postID);
	}


	public function init_cache_options()
    {
        //check to see if there is a S&F options in the caching table

        //delete_option($this->option_name);

        if (empty($this->cache_options)) {
            $cache_options = get_option($this->option_name);

            if (!$cache_options) {//then lets init

                $cache_options = array();
                $cache_options['status'] = "ready";
                $cache_options['last_update'] = "";
                $cache_options['restart'] = true;
                $cache_options['cache_list'] = array(); //ids of posts to cache
                $cache_options['current_post_index'] = 0;
                $cache_options['progress_percent'] = 0;
                $cache_options['locked'] = false;
                $cache_options['error_count'] = 0; //the error here is from non-completed processing
                $cache_options['rc_status'] = ""; //this is a different error (remote connect) - and will try anotehr method of caching if the server cannot do a wp_remote_---, curl, etc etc
                $cache_options['process_id'] = 0;
                $cache_options['run_method'] = "automatic";

                $this->setup_cached_search_forms();

                //all the fields and options we need to cache
                //then grab the post types and the meta keys we need to index
                $cache_options['caching_data'] = $this->cache_data;

                //the fields and options from the last cache - compare this with new caching data to see if we need to trigger a reset
                //$cache_options['last_caching_data'] = $cache_options['caching_data'];

                update_option($this->option_name, $cache_options, false);
            }
            if (!isset($cache_options['run_method'])) {
                $cache_options['run_method'] = "automatic";
            }
            $this->cache_options = $cache_options;
        }
    }

    public function get_real_option($option_name = "")
    {
        global $wpdb;

        $results = $wpdb->get_results($wpdb->prepare(
            "
			SELECT option_value
			FROM {$wpdb->options}
			WHERE option_name = '%s' LIMIT 0, 1
			",
            $option_name
        ));

        if (count($results) == 0) {
            return false;
        }

        $result = unserialize($results[0]->option_value);

        return $result;
    }

    public function cache_restart()
    {
        $this->init_cache_options();
	    $this->check_cache_list_changed(true);
        $this->cache_options['restart'] = true;
        $this->cache_options['rc_status'] = "";
        $this->update_cache_options($this->cache_options, true);

        $this->cache_progress();
    }

    public function cache_progress()
    {
        $this->init_cache_options();
        $cache_json = $this->cache_options;

        unset($cache_json['cache_list']);
        echo Search_Filter_Helper::json_encode($cache_json);

        // if($this->cache_options['run_method'] != "manual") {
        if (($this->cache_options['rc_status'] == "")||(($this->cache_options['rc_status'] == "user_bypass"))) {//then we need to test for a remote connection
            $this->can_wp_remote_post();
        }
        //}

        if ($this->cache_options['run_method'] == "manual") {
            //manual, then do nothing, wait for initiated response

        } else if ($this->cache_options['rc_status'] == "connect_success") {//there is a remote connection error, so don't try remote call
            $query_args = array("action" => "refresh_cache");
            $url = add_query_arg($query_args, admin_url('admin-ajax.php'));
            $this->wp_remote_post_with_cookie($url);//run in the background - calls refresh_cache()
        } else {
            $this->refresh_cache();
        }

        /*if(($this->cache_options['locked']==false)&&($this->cache_options['rc_status']))
        {
            //refresh_cache
        }*/

        exit;
    }

    public function cache_restart_manual()
    {
        $this->init_cache_options();
	    $this->check_cache_list_changed(true);
        if ($this->cache_options['run_method'] == "manual") {

            $this->cache_options['restart'] = true;
            $this->cache_options['rc_status'] = "";

            $this->update_cache_options($this->cache_options, true);

            $this->cache_progress_manual();
        }
        exit;
    }

    public function cache_progress_manual()
    {
        $this->init_cache_options();
        /*$cache_json = $this->cache_options;

        unset($cache_json['cache_list']);
        echo Search_Filter_Helper::json_encode($cache_json);*/

        if ($this->cache_options['run_method'] == "manual") {
            $this->cache_options['status'] = "inprogress";
            $this->cache_options['rc_status'] = "";
            //$this->cache_options['locked'] = false;
            $this->update_cache_options($this->cache_options, true);

            $this->refresh_cache();
        }


        $cache_json = $this->cache_options;
        unset($cache_json['cache_list']);
        echo Search_Filter_Helper::json_encode($cache_json);

        exit;
    }

    public function clean_query($query)
    {
        $query->set("tax_query", array());

    }

    public function refresh_cache()
    {//spawned from a wp_remote_get - so a background process

        $this->init_cache_options();

        ignore_user_abort(true); //allow script to carry on running
        @set_time_limit($this->process_exec_time);
        ini_set('max_execution_time', $this->process_exec_time);


        if ($this->cache_options['run_method'] !== "manual") {
            if (($this->cache_options['status'] == "error") && ($this->cache_options['restart'] == false)) {//if status = error, then caching can only resume based on user initiated response
                /*if($this->cache_options['run_method'] == "manual")
                {
                    $cache_json = $this->cache_options;
                    unset($cache_json['cache_list']);
                    echo Search_Filter_Helper::json_encode($cache_json);
                }*/

                exit;
            }
        }

        if ((($this->cache_options['status'] == "ready") || ($this->cache_options['restart'] == true))) {
            //then begin processing all the posts
            $this->cache_options['status'] = "inprogress";
            $this->cache_options['last_update'] = time();
            $this->cache_options['restart'] = false;
            $this->cache_options['current_post_index'] = 0;
            $this->cache_options['total_post_index'] = 0;
            $this->cache_options['progress_percent'] = 0;
            $this->cache_options['process_id'] = time();
            $this->cache_options['locked'] = false;
            $this->cache_options['error_count'] = 0;

            $this->setup_cached_search_forms();

            if (empty($this->cache_data['post_types'])) {

                $this->cache_options['status'] = "ready";
                $this->cache_options['restart'] = true;

                $this->update_cache_options($this->cache_options, true);

                exit;
            }

            Search_Filter_Wp_Cache::purge_all_transients();

            $query_args = array(
                'post_type' => $this->cache_data['post_types'],
                'posts_per_page' => -1,
                'paged' => 1,
                'fields' => "ids",

                'orderby' => "ID",
                'order' => "ASC",

                'post_status' => array("publish", "pending", "draft", "future", "private"),

                'suppress_filters' => true,

                /* speed improvements */
                'no_found_rows' => true,
                'update_post_meta_cache' => false,
            );

            if (in_array('attachment', $this->cache_data['post_types'])) {
                array_push($query_args['post_status'], "inherit");
            }

	        if ( isset( $this->cache_data['post_stati'] ) ) {

		        $query_args['post_status'] = array_unique( array_merge( $query_args['post_status'], $this->cache_data['post_stati'] ) );
	        }


            if (has_filter('sf_edit_cache_query_args')) {
                $query_args = apply_filters('sf_edit_cache_query_args', $query_args, $this->sfid);
            }

            $this->hard_remove_filters();

            add_action('pre_get_posts', array($this, 'clean_query'), 100);

	        if(has_filter("search_filter_post_cache_data_query_args"))
	        {
		        $query_args = apply_filters('search_filter_post_cache_data_query_args', $query_args, $this->sfid);

	        }

            $query = new WP_Query($query_args);
            remove_action('pre_get_posts', array($this, 'clean_query'), 100);

            $this->hard_restore_filters();

            if ($query->have_posts()) {

                $this->cache_options['cache_list'] = $query->posts;
                $this->cache_options['total_post_index'] = count($this->cache_options['cache_list']);

            } else {//there were no posts to cache so set as complete or error


            }

            //clear cache
            $this->empty_cache();

            //update cache options in DB
            $this->update_cache_options($this->cache_options, true);

            if ($this->cache_options['run_method'] == "manual") {
                $this->process_cache($this->cache_options['process_id']);
            } else if ($this->cache_options['rc_status'] == "connect_success") {
                //$this->process_cache($this->cache_options['process_id']);
                $this->wp_remote_process_cache(array("process_id" => $this->cache_options['process_id']));
            } else {
                $this->process_cache($this->cache_options['process_id']);
            }
        }

        if ($this->cache_options['status'] == "inprogress") {//if its in progress, check when the last cycle started to see if there was a problem

            //if its been more than 5 minutes since the last cycle then start it again
            $current_time = time();
            $retry_limit = 2;


            $cycle_error_amount = $this->cycle_error_amount;
            $error_time = $this->cache_options['last_update'] + $cycle_error_amount;

            if ($current_time >= $error_time) {//there was an error - so try to resume

                $this->cache_options['last_update'] = time();
                $this->cache_options['error_count']++;
                $this->cache_options['locked'] = false;

                if ($this->cache_options['error_count'] > $retry_limit) {//then there seems to be a serious issue, stop and show error message - allow user to restart

                    $this->cache_options['status'] = "error";
                    $this->cache_options['error_count'] = 0;
                    $this->update_cache_options($this->cache_options);
                } else {
                    //try to continue the processing
                    $this->cache_options['process_id'] = time();
                    $this->update_cache_options($this->cache_options);

                    if ($this->cache_options['run_method'] == "manual") {
                        $this->process_cache($this->cache_options['process_id']);
                    } else if ($this->cache_options['rc_status'] == "connect_success") {
                        $this->wp_remote_process_cache(array("process_id" => $this->cache_options['process_id']));
                    } else {
                        $this->process_cache($this->cache_options['process_id']);
                    }

                }

                //$this->process_cache();
            } else {//then just leave the scripts to carry on - we assume they are working

                //unless there is a remote connection error, which means we should try to manually resume

                if ($this->cache_options['run_method'] == "manual") {
                    $this->process_cache($this->cache_options['process_id']);
                } else if ($this->cache_options['rc_status'] != "connect_success") {
                    $this->process_cache($this->cache_options['process_id']);
                }
            }

        } else if ($this->cache_options['status'] == "termcache") {
            if ($this->cache_options['rc_status'] != "connect_success") {
                $this->process_cache($this->cache_options['process_id']);
            }
        } else {
            if ($this->cache_options['run_method'] == "manual") {
                $cache_json = $this->cache_options;
                unset($cache_json['cache_list']);
                echo Search_Filter_Helper::json_encode($cache_json);
            }
        }

        exit;
    }

    public function hard_remove_filters()
    {
        $remove_posts_clauses = false;
        $remove_posts_where = false;

        if (isset($GLOBALS['wp_filter']['posts_clauses'])) {
            $remove_posts_clauses = true;
        }

        if (isset($GLOBALS['wp_filter']['posts_where'])) {
            $remove_posts_where = true;
        }

        //
        if (($remove_posts_clauses) || ($remove_posts_where)) {
            $this->WP_FILTER = $GLOBALS['wp_filter'];
        }

        if ($remove_posts_clauses) {

            unset($GLOBALS['wp_filter']['posts_clauses']);
        }

        if ($remove_posts_where) {

            unset($GLOBALS['wp_filter']['posts_where']);
        }
    }


    public function hard_restore_filters()
    {
        $remove_posts_clauses = false;
        $remove_posts_where = false;

        if (isset($this->WP_FILTER['posts_clauses'])) {
            $remove_posts_clauses = true;
        }

        if (isset($this->WP_FILTER['posts_where'])) {
            $remove_posts_where = true;
        }


        if (($remove_posts_clauses) || ($remove_posts_where)) {
            $GLOBALS['wp_filter'] = $this->WP_FILTER;
            unset($this->WP_FILTER);
        }

    }

    public function process_cache($process_id = 0)
    {
        $this->init_cache_options();

        //$this->write_log("starting `process_cache`");
        /* $tcacheoptions = $this->cache_options;
         unset($tcacheoptions['cache_list']);
         $this->write_log($tcacheoptions);*/
        ignore_user_abort(true); //allow script to carry on running
        @set_time_limit($this->process_exec_time);
        ini_set('max_execution_time', $this->process_exec_time);

        //make sure we only run the same, valid process
        if ($process_id == 0) {
            if (isset($_GET['process_id'])) {
                $process_id = (int)$_GET['process_id'];
            }
        }

        $live_options = $this->get_real_option($this->option_name);

        if ((!$this->valid_process($process_id, $this->cache_options['current_post_index'])) || ($live_options['locked'] == true)) {
            if ($this->cache_options['run_method'] == "manual") {
                $cache_json = $this->cache_options;
                unset($cache_json['cache_list']);
                echo Search_Filter_Helper::json_encode($cache_json);
            }
            exit;
        }

        if ($this->cache_options['status'] == "inprogress") {
            //$this->write_log("~~ locking [start for loop in `process_cache`]`". $this->cache_options['process_id']);

            $this->cache_options['locked'] = true;
            $this->update_cache_options($this->cache_options);

            $this->setup_cached_search_forms();

            $cache_index = $this->cache_options['current_post_index'];
            $cache_list = $this->cache_options['cache_list'];
            $cache_length = count($cache_list);

            if (($cache_index + $this->batch_size) > $cache_length - 1) {
                $batch_end = $cache_length - 1;
            } else {
                $batch_end = $cache_index + $this->batch_size - 1;
            }

            $cached_count = 0;

            $start_time = microtime(true);

	        $this->new_batch_end = $batch_end;
            for ($i = $cache_index; $i <= $batch_end; $i++) {
                $cached_count++;

                if($i <= $this->new_batch_end) {

	                //fetch a fresh copy of this value every time, in case another process in the bg has updated it since
	                if ( ! $this->valid_process( $process_id, $this->cache_options['current_post_index'] ) ) {
		                exit;
	                }

	                $post_id = $cache_list[ $i ];
	                $post_offset = $this->update_post_cache( $post_id );

	                //end the batch early if there is an offset
	                $this->new_batch_end = $this->new_batch_end + $post_offset;
	                if ( $this->new_batch_end !== $batch_end ) {
		                //then we need to re-arrange the end of this batch
		                if ( $this->new_batch_end < $i ) {
			                $this->new_batch_end = $i;
		                }
	                }

	                $this->cache_options['current_post_index'] = $i + 1;


                }
            }

            if (!$this->valid_process($process_id, $this->cache_options['current_post_index'])) {
                exit;
            }

            $this->cache_options['last_update'] = time();
            $this->cache_options['progress_percent'] = round((100 / $cache_length) * $this->cache_options['current_post_index']);
            $this->cache_options['locked'] = false;
            $this->cache_options['error_count'] = 0;

            if (($this->cache_options['current_post_index'] == $cache_length) || ($cache_length == 0)) {//complete
                //$this->cache_options['status'] = "termcache";
                //$this->cache_options['cache_list'] = array();
                //$this->update_cache_options( $this->cache_options );

                //$this->process_cache(); //one last time to get finished state

                //now its finished we also need to update the OTHER table... :/

                /*if($this->cache_options['rc_status']=="connect_success")
                {
                    $this->wp_remote_build_term_results(array("process_id" => $this->cache_options['process_id'])); //make new async request
                }
                else
                {
                    $this->build_term_results($this->cache_options['process_id']);
                }*/

                // if we're updating the term cache after every post then we just finish:

                //$this->write_log("~~ unlocking [finish list]`". $this->cache_options['process_id']);

                $this->cache_options['process_id'] = 0;
                $this->cache_options['status'] = "finished";
                $this->cache_options['locked'] = false;
                $this->cache_options['cache_list'] = array();


                $this->update_cache_options($this->cache_options);

                Search_Filter_Wp_Cache::purge_all_transients();

                if ($this->cache_options['run_method'] == "manual") {
                    $cache_json = $this->cache_options;
                    unset($cache_json['cache_list']);
                    echo Search_Filter_Helper::json_encode($cache_json);
                }

            } else {//continue

                if ($this->cache_options['run_method'] == "manual") {

                    //$this->write_log("~~ unlocking [finish batch | manual]`". $this->cache_options['process_id']);

                    $this->cache_options['locked'] = false;
                    $this->update_cache_options($this->cache_options);

                    $cache_json = $this->cache_options;
                    unset($cache_json['cache_list']);
                    echo Search_Filter_Helper::json_encode($cache_json);
                } else {

                    $this->update_cache_options($this->cache_options);

                    if ($this->cache_options['rc_status'] == "connect_success") {
                        sleep(2); //may not be essential, but might help on slower servers, give some delay between batches
                        $this->wp_remote_process_cache(array("process_id" => $this->cache_options['process_id'])); //make new async request
                    } else {
                        //don't do anything, wait for ajax initiated resum
                    }
                }


            }
        } else if ($this->cache_options['status'] == "termcache") {
            //$this->build_term_results($this->cache_options['process_id']);

        } else if ($this->cache_options['status'] != "finished") {
            $this->refresh_cache(); //check for any problems or restart/initialise
        }
        exit;
    }

    public function valid_process($process_id, $post_index)
    {

        $live_options = $this->get_real_option($this->option_name);

        //before making any more changes check to see if there has been a restart anywhere, or a new process spawned
        if ((($process_id != $live_options['process_id']) || ($process_id == 0) || $live_options['restart'] == true) || ($post_index < $live_options['current_post_index'])) {//don't allow running of non active processes (should only be one anyway)
            //$live_options['locked'] = false;
            //$this->update_cache_options( $live_options );

            return false;
        }

        return true;

    }

    public function valid_term_process($process_id)
    {
        $live_options = $this->get_real_option($this->option_name);

        //before making any more changes check to see if there has been a restart anywhere, or a new process spawned
        if ((($process_id != $live_options['process_id']) || ($process_id == 0) || $live_options['restart'] == true)) {//don't allow running of non active processes (should only be one anyway)
            $live_options['locked'] = false;
            $this->update_cache_options($live_options);

            return false;
        }

        return true;

    }

    public function wp_remote_process_cache($args = array())
    {
        $query_args = array("action" => "process_cache");
        $query_args = array_merge($query_args, $args);
        $url = add_query_arg($query_args, admin_url('admin-ajax.php'));
        $remote_call = $this->wp_remote_post_with_cookie($url);//run in the background - calls refresh cache below
    }

    public function wp_remote_build_term_results($args = array())
    {
        $query_args = array("action" => "build_term_results");
        $query_args = array_merge($query_args, $args);
        $url = add_query_arg($query_args, admin_url('admin-ajax.php'));
        $remote_call = $this->wp_remote_post_with_cookie($url);//run in the background - calls refresh cache below
    }

    public function can_wp_remote_post()
    {
        //check first to see if a user has bypassed this
        $cache_use_background_processes = Search_Filter_Helper::get_option('cache_use_background_processes');

        if ($cache_use_background_processes != 1) {
            $this->cache_options['rc_status'] = "user_bypass";
        } else {
            $args = array();
            $args['timeout'] = 5;

            $query_args = array("action" => "test_remote_connection");
            $url = add_query_arg($query_args, admin_url('admin-ajax.php'));


            $remote_call = wp_remote_post($url, $args);
            //$this->cache_options['rc_status'] = "routing_error";

            if (is_wp_error($remote_call)) {
                $error_message = $remote_call->get_error_message();
                $this->cache_options['rc_status'] = "connect_error";

            } else {

                $success = false;

                if (isset($remote_call['body'])) {
                    $body = trim($remote_call['body']);
                    if ($body == "test_success") {
                        $success = true;
                    }
                }

                if ($success) {
                    $this->cache_options['rc_status'] = "connect_success";
                } else {//a response was received but not the one we wanted
                    $this->cache_options['rc_status'] = "routing_error";
                }

            }
        }

        //$this->write_log("~~ can WP remote POST`". $this->cache_options['process_id']);
        $this->update_cache_option('rc_status', $this->cache_options['rc_status']);
        //$this->update_cache_options( $this->cache_options );
    }

    public function test_remote_connection()
    {
        echo "test_success";
        exit;

    }

    public function wp_remote_post_with_cookie($url, $args = array())
    {
        /*$args = array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => array( 'username' => 'bob', 'password' => '1234xyz' ),
            'cookies' => array()
        );*/

        $args['timeout'] = 0.5;

        $remote_call = wp_remote_post($url);

        if (is_wp_error($remote_call)) {
            $error_message = $remote_call->get_error_message();
            //$this->cache_options['rc_status'] = "connect_error";

        } else {

        }

    }

    public function update_cache_options($cache_options, $bypass_real = false)
    {
        if (!$bypass_real) {
            $live_options = $this->get_real_option($this->option_name);
            if (isset($live_options['restart'])) ;
            {
                $cache_options['restart'] = $live_options['restart'];
            }
        }

        //$this->write_log('Now doing `update_cache_options`.. setting locked to: '.$cache_options['locked'].' [pid: '.$this->cache_options['process_id'].']');
        update_option($this->option_name, $cache_options, false);
    }

    public function update_cache_option($cache_option, $cache_value, $bypass_real = false)
    {
        $cache_options = $this->get_real_option($this->option_name);
        $cache_options[$cache_option] = $cache_value;

        //$this->write_log('Now doing `update_cache_option`.. setting locked to: '.$cache_options['locked'].' [pid: '.$this->cache_options['process_id'].']');
        update_option($this->option_name, $cache_options, false);
    }

    public function empty_cache()
    {
        global $wpdb;

	    $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');
	    $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

        $wpdb->query('TRUNCATE TABLE `' . $this->cache_table_name . '`');
        $wpdb->query('TRUNCATE TABLE `' . $this->term_results_table_name . '`');
    }

    public function build_term_results($process_id = 0)
    {
        $this->init_cache_options();

        ignore_user_abort(true); //allow script to carry on running
        @set_time_limit(0);
        ini_set('max_execution_time', 0);

        //make sure we only run the same, valid process
        if ($process_id == 0) {
            if (isset($_GET['process_id'])) {
                $process_id = (int)$_GET['process_id'];
            }
        }

        if ((!$this->valid_term_process($process_id)) || ($this->cache_options['locked'] == true)) {
            exit;
        }

        $this->cache_options['locked'] = true;
        $this->update_cache_options($this->cache_options);


        if ($this->cache_options['status'] == "termcache") {
            //empty terms first
	        $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

            global $wpdb;
            $wpdb->query('TRUNCATE TABLE `' . $this->term_results_table_name . '`');
            $this->get_all_filters();
            $this->cache_options['process_id'] = 0;
            $this->cache_options['status'] = "finished";
            $this->cache_options['locked'] = false;

            $this->cache_options['cache_list'] = array();
            $this->update_cache_options($this->cache_options);
        } else {
            //$this->refresh_cache(); //check for any problems or restart/initialise
        }
        exit;
    }

    public function get_all_filters() {
        $filters = array();

        $search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish,draft&posts_per_page=-1&suppress_filters=1');
        $search_forms = $search_form_query->get_posts();

        foreach ($search_forms as $search_form) {
            $search_form_fields = $this->get_fields_meta($search_form->ID);

            foreach ($search_form_fields as $key => $field) {
                $valid_filter_types = array("tag", "category", "taxonomy", "post_meta");

                if (in_array($field['type'], $valid_filter_types)) {
                    if (($field['type'] == "tag") || ($field['type'] == "category") || ($field['type'] == "taxonomy")) {
                        array_push($filters, "_sft_" . $field['taxonomy_name']);
                    } else if ($field['type'] == "post_meta") {
                        if ($field['meta_type'] == "choice") {
                            array_push($filters, "_sfm_" . $field['meta_key']);
                        }
                    }
                }

            }
        }
        $filters = array_unique($filters);

        //now we have all the filters, get the filter terms/options
        foreach ($filters as $filter) {
            if ($this->is_taxonomy_key($filter)) {
                $source = "taxonomy";
            } else if ($this->is_meta_value($filter)) {
                $source = "post_meta";
            }

            $terms = $this->get_filter_terms($filter, $source);

            $filter_o = array("source" => $source);

            foreach ($terms as $term) {

                $term_ids = $this->get_cache_term_ids($filter, $term->field_value, $filter_o);
                //$save_term_ids = implode("," , $term_ids);

                $this->insert_term_results($filter, $term->field_value, $term_ids);
                //echo " ( ".count($term_ids)." ) , ";
            }
        }

        return $filters;
    }

    public function insert_term_results($filter_name, $filter_value, $result_ids)
    {

        global $wpdb;

        $insert_data = array(
            'field_name' => $filter_name,
            'field_value' => $filter_value,
            'result_ids' => implode(",", $result_ids)
        );

        $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

        $wpdb->insert(
            $this->term_results_table_name,
            $insert_data
        );

    }

    public function get_cache_term_ids($filter_name, $filter_value, $filter)
    {

        global $wpdb;

        //test for speed

        $field_term_ids = array();

        $value_col = "field_value";
        if ($filter['source'] == "taxonomy") {
            $value_col = "field_value_num";
        }

	    $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');

        $field_terms_results = $wpdb->get_results($wpdb->prepare(
            "
			SELECT post_id
			FROM $this->cache_table_name
			WHERE field_name = '%s'
				AND $value_col = '%s'
			",
            $filter_name,
            $filter_value
        ));


        foreach ($field_terms_results as $field_terms_result) {
            $field_term_ids[$field_terms_result->post_id] = 1;
            //array_push($field_term_ids, $field_terms_result->post_id);

        }

        return array_keys($field_term_ids);
        //return array_unique($field_term_ids);
    }


    public function get_filter_terms($field_name, $source)
    {

        global $wpdb;

        $field_col_select = "field_value";
        if ($source == "taxonomy") {
            $field_col_select = "field_value_num as field_value";
        }

	    $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');

        $field_terms_result = $wpdb->get_results($wpdb->prepare(
            "
			SELECT DISTINCT $field_col_select
			FROM $this->cache_table_name
			WHERE field_name = '%s'
			",
            $field_name
        ));

        return $field_terms_result;
    }

    public function setup_cached_search_forms()
    {

	    $query_args = array(
		    'post_type' => 'search-filter-widget',
		    'posts_per_page' => -1,
		    'paged' => 1,
		    'post_status' => array("publish"),
		    'suppress_filters' => true,

		    /* speed improvements */
		    'no_found_rows' => true,
		    'update_post_meta_cache' => false,
		    'lang' => ''
	    );

	    if (has_filter('sf_edit_search_forms_query_args')) {
		    $query_args = apply_filters('sf_edit_search_forms_query_args', $query_args, $this->sfid);
	    }

        $search_form_query = new WP_Query($query_args);
        $search_forms = $search_form_query->get_posts();

        $this->cached_search_form_settings = array();
        $this->cached_search_form_fields = array();

        foreach ($search_forms as $search_form) {
            $search_form_cache = $this->get_cache_meta($search_form->ID);

            //if(isset($search_form_cache['enabled']))
            //{
            //if($search_form_cache['enabled']==1)
            //{

            $search_form_settings = $this->get_settings_meta($search_form->ID);
            $search_form_fields = $this->get_fields_meta($search_form->ID);
            //then we have a search form with caching enabled

            array_push($this->cached_search_form_settings, $search_form_settings);
            array_push($this->cached_search_form_fields, $search_form_fields);
            //}

            //}
        }

        $this->calc_cache_data($this->cached_search_form_settings, $this->cached_search_form_fields);
    }

    public function calc_cache_data($search_form_settings, $search_form_fields)
    {
        $incl_post_types = array();
	    $incl_post_stati = array();
        $incl_meta_keys = array();
        $it = 0;

        //loop through each form, and get vars so we know what needs to be cached
        foreach ($search_form_settings as $settings) {

            if ($settings != "") {
                if (isset($settings['post_types'])) {
                    // post types
                    $incl_post_types = array_merge(array_keys($settings['post_types']), $incl_post_types);
	                $incl_post_stati = array_merge(array_keys($settings['post_status']), $incl_post_stati);

                    if (isset($search_form_fields[$it])) {
                        if (($search_form_fields[$it])) {

                            foreach ($search_form_fields[$it] as $search_form_field) {
                                if ($search_form_field['type'] == "post_meta") {
                                    $is_single = true;

                                    if ($search_form_field['meta_type'] == "number") {
                                        if (isset($search_form_field['number_use_same_toggle'])) {
                                            if ($search_form_field['number_use_same_toggle'] != 1) {
                                                array_push($incl_meta_keys, $search_form_field['number_end_meta_key']);
                                            }
                                        }

                                    } else if ($search_form_field['meta_type'] == "date") {
                                        if (isset($search_form_field['date_use_same_toggle'])) {
                                            if ($search_form_field['date_use_same_toggle'] != 1) {
                                                array_push($incl_meta_keys, $search_form_field['date_end_meta_key']);
                                            }
                                        }
                                    }

                                    array_push($incl_meta_keys, $search_form_field['meta_key']);

                                }
                            }
                        }
                    }
                }
            }
            $it++;
        }

        $this->cache_data['post_types'] = array_unique($incl_post_types);
        $this->cache_data['meta_keys'] = array_unique($incl_meta_keys);
        $this->cache_data['post_stati'] = array_unique($incl_post_stati);


        if(has_filter("search_filter_post_cache_data"))
        {
          $this->cache_data = apply_filters('search_filter_post_cache_data', $this->cache_data, $this->sfid);
        }

    }


    private function get_cache_meta($sfid)
    {
        $meta_key = '_search-filter-cache';
        $cache_settings = (get_post_meta($sfid, $meta_key, true));

        return $cache_settings;
    }

    private function get_settings_meta($sfid)
    {
        //as we only want to update "enabled", then load all settings and update only this key
        $search_form_settings = Search_Filter_Helper::get_settings_meta($sfid);

        return $search_form_settings;
    }

    private function get_fields_meta($sfid)
    {

        $meta_key = '_search-filter-fields';
        $search_form_fields = (get_post_meta($sfid, $meta_key, true));

        return $search_form_fields;
    }

    //fires when a term has been edited (ie, label or slug)... we don't save this in our caching table, but we do save some slug info in transients
    //so clear transient only when slug is changed
    //hard to detect slug change, so just detect if a term was updated in a taxonomy that was being used in S&F, do this by matching S&F post types
    public function taxonomy_edited_terms($term_id, $taxonomy_name)
    {
        $this->init_cache_options();

        $taxonomy = get_taxonomy($taxonomy_name);

        $taxonomy_post_types = array();
        if ($taxonomy) {
            if (isset($taxonomy->object_type)) {
                $taxonomy_post_types = $taxonomy->object_type;
            }
        }

        if (empty($taxonomy_post_types)) {
            return;
        }
        if (!isset($this->cache_options['caching_data'])) {
            return;
        }
        if (!isset($this->cache_options['caching_data']['post_types'])) {
            return;
        }
        if (empty($this->cache_options['caching_data']['post_types'])) {
            return;
        }

        $cached_post_types = $this->cache_options['caching_data']['post_types'];
        $matching_types = array_intersect($cached_post_types, $taxonomy_post_types);

        if (count($matching_types)) {//then a term changed in a post type that is used in S&F, so delete the transient
            $cache_name = Search_Filter_Wp_Data::$wp_tax_terms_cache_key . $taxonomy_name;
            Search_Filter_Wp_Cache::delete_transient($cache_name);
        }
    }

    public function post_meta_updated($meta_id, $object_id, $meta_key, $meta_value)
    {
        if ($meta_key == "_edit_lock") {
            return;
        }

        $post = get_post($object_id);
        //$this->post_updated($post->ID, $post, false);
	    $this->schedule_post_updated($post->ID);
    }


    public function object_terms_updated($postID, $terms, $tt_ids, $taxonomy)
    {
        $post = get_post($postID);
        if(!$post){
        	return;
        }
        //$this->post_updated($postID, $post, false);

	    $this->schedule_post_updated($postID);
    }

    public function updated_post_meta_updated($meta_id, $object_id, $meta_key, $meta_value)
    {
        if ($meta_key == "_edit_lock") {
            return;
        }

        $post = get_post($object_id);

        //$this->post_updated($post->ID, $post, false);

	    $this->schedule_post_updated($post->ID);
    }

    /*public function attachment_updated($form_fields, $post)
    {
        $this->post_updated($post->ID, $post, false);
        return $form_fields;
    }*/

    public function attachment_updated($form_fields, $post_before, $post_after) {

        $this->post_updated($post_after->ID, $post_after, false);
        return $form_fields;
    }
    public function attachment_added($post_id)
    {
	    $post = get_post($post_id);
	    $this->post_updated($post->ID, $post, false);
    }

    public function post_updated_action($postID, $post, $update)
    {
        $this->schedule_post_updated($postID);
        //$this->post_updated($postID, $post, $update);
    }
    public function wp_shutdown()
    {
	    if(!empty($this->posts_updated)){

	    	//if the user uses our action to update the post, we don't want to do it twice
		    //so pop the ID off hte array on the action `search_filter_update_post` (unless we use the action somewhere)
		    $this->setup_cached_search_forms();

		    $this->posts_updated = array_unique($this->posts_updated);
	    	foreach($this->posts_updated as $post_id){
	    		//$this->update_post_cache($post_id);
			    $post = get_post($post_id);
	    		$this->post_updated($post_id, $post, false);
		    }

	    }

    }
    public function schedule_post_updated($post_id)
    {
	    array_push($this->posts_updated, $post_id);
	    //$this->posts_updated = array_unique($this->posts_updated);
	    //exit;
    }

	public function post_updated( $postID, $post, $update )
	{
        $this->post_updated_count++;

        if( (!isset($post)) || (empty($post)) )
        {
            return;
        }

		if( ! ( wp_is_post_revision( $postID ) && wp_is_post_autosave( $postID ) ) )
		{
            $this->init_cache_options();

			if($post->post_type!="search-filter-widget")
			{//then do some checks to see if we need to update the cache for this

                //Search_Filter_Helper::start_log("setup_cached_search_forms");
				$this->setup_cached_search_forms();
                //Search_Filter_Helper::finish_log("setup_cached_search_forms");

				if(in_array($post->post_type, $this->cache_data['post_types'])){

					//clear_field_transients(); //this removes the min / max

                    //Search_Filter_Helper::start_log("update_post_cache");
					//$this->update_post_cache($postID, $post, array( $this, 'get_post_current_values' ));
					$this->update_post_cache($postID);
                    //$time_to_complete = Search_Filter_Helper::finish_log("update_post_cache", false);

                    Search_Filter_Wp_Cache::purge_all_transients();
				}
			}
			else
			{//a Search & Filter form was updated...
				$this->check_cache_list_changed();
                Search_Filter_Wp_Cache::purge_all_transients();
			}
		}
	}

	private function check_cache_list_changed($is_restart = false)
	{
		$restart_flag = false;

		$this->setup_cached_search_forms();


		$new_cache_data = $this->cache_data;



		// add proper support for post status, and prevent restarts for exising users
		// by removing the built in post status we always include and init the arrays on both old
		// and new data

		//first, setup post_stati on old and new, so it doesn't trigger a restart automatically
		if ( ! isset( $this->cache_options['caching_data']['post_stati'] ) ) {

			$this->cache_options['caching_data']['post_stati'] = array();
		}

		if ( ! isset( $new_cache_data['post_stati'] ) ) {

			$new_cache_data['post_stati'] = array();
		}

		//now if they exist, remove the built in post status (that we force include) before do allow a compare
		$built_in_post_stati =array("publish", "pending", "draft", "future", "private");

		$this->cache_options['caching_data']['post_stati'] = array_values( array_diff($this->cache_options['caching_data']['post_stati'], $built_in_post_stati) );
		$new_cache_data['post_stati'] = array_values( array_diff($new_cache_data['post_stati'], $built_in_post_stati) );


		$current_cache_data = $this->cache_options['caching_data'];
		//compare the new settings with the saved settings

		foreach($new_cache_data as $key => $value)
		{

			if((count($new_cache_data[$key]))==(count($current_cache_data[$key])))
			{
				if(is_array($value))
				{
					foreach($value as $cache_key)
					{
						if(!in_array($cache_key, $current_cache_data[$key]))
						{
							$restart_flag = true;
						}
						else{
						}
					}
				}

			}
			else
			{
				$restart_flag = true;
			}

		}


		if($restart_flag==true)
		{
			if($is_restart == true){
				//if this is a check in the restart procedure, then we want to update the settings
				//but not do a full restart
				$restart_flag = false;
			}

			$this->cache_options['caching_data'] = $new_cache_data;

			$this->cache_options['restart'] = $restart_flag;
			update_option( $this->option_name, $this->cache_options, false );
		}
		else
		{//just trigger a rebuild of the terms - this should be done anytime someone changes a field which has terms (tag, cat, tax, meta)

			//need to improve to be "smarter"

			/*if($this->cache_options['status']!="inprogress")
			{// don't do anything if there it is already running, because the terms will be updated anyway when it finishes

				$this->cache_options['process_id'] = time();
				$this->cache_options['restart'] = false;
				$this->cache_options['status'] = "termcache";
				update_option( $this->option_name, $this->cache_options, false );
				$this->wp_remote_build_term_results(array("process_id" => $this->cache_options['process_id'])); //make new async request
			}*/

		}
	}

	public function set_cache_current_values($postID, $post = "") {

		if($post=="") {

			$post = get_post($postID);
		}

		//$this->tax_insert_fields = array();
		//$this->meta_insert_fields = array();


		$fields_data = array();

		//set up taxonomies
		$tax_insert_data = $this->set_post_cache_taxonomy_terms($postID, $post);

		if(has_filter('search_filter_post_cache_insert_data')) {
			$tax_insert_data = apply_filters('search_filter_post_cache_insert_data', $tax_insert_data, $postID, 'taxonomy');
		}

		$tax_insert_sql = $this->insert_post_cache_taxonomy_terms($tax_insert_data, $postID, $post);

		//setup meta
		$meta_insert_data = $this->set_post_cache_meta_terms($postID, $post); // AND THIS ?? THIS FUNCTION IS CALLED in `post_update_post_meta`

		if(has_filter('search_filter_post_cache_insert_data')) {
			$meta_insert_data = apply_filters('search_filter_post_cache_insert_data', $meta_insert_data, $postID, 'meta');
		}
		$meta_insert_sql = $this->insert_post_cache_post_meta_terms($meta_insert_data, $postID, $post); // AND THIS ?? THIS FUNCTION IS CALLED in `post_update_post_meta`


		$fields_added = array_merge($tax_insert_data, $meta_insert_data);
		$fields_sql_added = array_merge($tax_insert_sql, $meta_insert_sql);

		$fields_data[0] = $fields_added;
		$fields_data[1] = $fields_sql_added;


		//return $tax_ins_count;
		//$fields_data[1] = $sql;

		return $fields_data;

    }

	public function delete_post_cache($postID){

		$this->post_delete_cache($postID, true); //remove existing records from cache


	}

	//args
	// callback - if a callback is present it will be used instead of the fields data
	// fields_data - contains an array of data to add to the post - if no callback or fields data
	// update_term_cache - whether to update the term cache table afterwards


	//public function update_post_cache($postID, $get_fields_callback = '', $update_term_cache = true){
	public function update_post_cache($postID, $args = array()){

		$this_post_offset = 0;

		$defaults = array(
			'callback' => '',
			'fields_data' => '',
			'update_term_cache' => true
		);
		$args = array_replace_recursive($defaults, $args);

		global $wpdb;
		$this->init_cache_options();

		$post = get_post($postID);

		if(!$post)
		{
			$this->post_delete_cache($postID); //remove existing records from cache
			return $this_post_offset;
		}

		$post_type = $post->post_type;

		$update_post_cache = true;
		if(has_filter('search_filter_post_cache_update')) {
			$update_post_cache = apply_filters( 'search_filter_post_cache_update', $update_post_cache, $postID, $post_type );
		}
		if(!$update_post_cache) {
			return $this_post_offset;
		}

		$fields_previous = array();

		$this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');
		//Search_Filter_Helper::start_log("post_terms");
		$post_terms = $wpdb->get_results($wpdb->prepare(
			"
			SELECT field_name, field_value, field_value_num
			FROM $this->cache_table_name
			WHERE post_id = '%d'
			",
			$postID
		));

		if( $args['update_term_cache'] == false ) {
			return $this_post_offset;
		}


		$prevent_actions_callback = false;

		if(empty($args['fields_data'])) {
			//either use the callback passed (if array)
			if ( gettype( $args['callback'] ) == 'array' ) {

				$fields_data = call_user_func( $args['callback'], array( $postID ) );
				$prevent_actions_callback = true;
			} else {
				//else if string, call the function that gets existing data
				$fields_data = $this->set_cache_current_values( $postID, $post );
			}
		} else {
			$prevent_actions_callback = true;
			$fields_data = $args['fields_data'];
		}

		if(!$prevent_actions_callback) {
			//assumes when supplying your own data you dont want to run the usual funcitons

			do_action( 'search_filter_pre_update_post_cache', $post ); //this needs to run after `set_cache_current_values`
		}

		$fields_added = $fields_data[0];
		$fields_sql = $fields_data[1];

		//now get a list of all the fields in the DB
		if(count($post_terms)>0)
		{

			foreach ($post_terms as $post_term)
			{
				if(!isset($fields_previous[$post_term->field_name]))
				{
					$fields_previous[$post_term->field_name] = array();
				}

				$field_value = $post_term->field_value;
				if($this->is_taxonomy_key($post_term->field_name))
				{
					$field_value = $post_term->field_value_num;
				}

				array_push($fields_previous[$post_term->field_name], (string)$field_value);
			}
		}

		//now we have 2 arrays $fields_added and $fields_previous
		//get a unique set of keys from the two of them
		$unique_keys = array_unique(array_merge(array_keys($fields_previous), array_keys($fields_added)));

		$field_differences = array();
		$combined_terms = array();

		foreach($unique_keys as $unique_key)
		{
			//if the keys are set in both, then merge them
			if((isset($fields_previous[$unique_key]))&&(isset($fields_added[$unique_key])))
			{ //we shoudl really check for differences in values and only update those

				$diff1 = array_diff($fields_previous[$unique_key], $fields_added[$unique_key] );
				$diff2 = array_diff($fields_added[$unique_key], $fields_previous[$unique_key] );
				$combined_terms = array_merge($diff1, $diff2);
			}
			else if (isset($fields_previous[$unique_key]))
			{
				$combined_terms = $fields_previous[$unique_key];
			}
			else if (isset($fields_added[$unique_key]))
			{
				$combined_terms = $fields_added[$unique_key];
			}

			//push on to new array
			if(!empty($combined_terms)) {
				$field_differences[$unique_key] = $combined_terms;
			}
		}

		//Search_Filter_Helper::start_log("field_differences");
		//these are the differences in fields cached Vs new

		$all_delete_rows = array();
		$get_cache_terms = array();

		if(empty($field_differences)) {

			$row_data = array(
				'post_id' => $postID,
				'post_parent_id' => $post->parent_id
			);

			$insert_data = array(
				'field_name' => '',
				'field_value' => ''
			);

			$insert_data = array_merge($row_data, $insert_data);

			$wpdb->insert(
				$this->cache_table_name,
				$insert_data
			);

			return $this_post_offset;
		}

		//Search_Filter_Helper::start_log("post_delete_cache");
		$this->post_delete_cache($postID); //remove existing records from cache
		//Search_Filter_Helper::finish_log("post_delete_cache");

		$post_insert_data_count = $this->post_insert_data($fields_sql, $postID, $post); //add post_meta to the cache

		if($post_insert_data_count==0) {//then this post has no fields but should be able to still appear in unfiltered results - so add it to the index anyway

			//$this->write_log("got here, post doesn't have any tax or metadata | ID: ".$postID);

			$row_data = array(
				'post_id' => $postID,
				'post_parent_id' => $post->parent_id
			);

			$insert_data = array(
				'field_name' => '',
				'field_value' => ''
			);

			$insert_data = array_merge($row_data, $insert_data);

			$wpdb->insert(
				$this->cache_table_name,
				$insert_data
			);

		}

		foreach($field_differences as $filter => $terms) {

			$source = "";
			if($this->is_taxonomy_key($filter))
			{
				$source = "taxonomy";
			}
			else if($this->is_meta_value($filter))
			{
				$source = "post_meta";
			}

			if($source!="")
			{
				$cc = 0;

				foreach($terms as $term_value)
				{
					$cc++;

					//delete existing value
					$delete_args = array(

						'field_name' => $filter,
						'field_value' => $term_value

					);

					array_push($all_delete_rows, $delete_args);

					if(!isset($get_cache_terms[$filter]))
					{
						$get_cache_terms[$filter] = array();

					}
					$get_cache_terms[$filter][$term_value] = 1;
				}
			}
		}


		//Search_Filter_Helper::start_log("term_results_delete_rows");
		$this->term_results_delete_rows($all_delete_rows);
		//Search_Filter_Helper::finish_log("term_results_delete_rows");

		//Search_Filter_Helper::start_log("get_all_cache_term_ids");
		$all_cache_term_ids = $this->get_all_cache_term_ids($get_cache_terms);
		//Search_Filter_Helper::finish_log("get_all_cache_term_ids", true, true);

		//Search_Filter_Helper::start_log("insert_all_term_results");
		$this->insert_all_term_results($all_cache_term_ids);

		//Search_Filter_Helper::finish_log("insert_all_term_results", true, true);

		// post offset can be used for things like variations, where 1 product is actually multiple posts (variations)
		// which means the batch can be terminated early if we're adding too many variations at the same time

		if(has_filter('search_filter_post_cache_insert_offset')) {

			$this_post_offset = apply_filters('search_filter_post_cache_insert_offset', $this_post_offset, $postID);
			$this_post_offset = -$this_post_offset;
		}
		//$this->post_offset = -3;

		return $this_post_offset;
	}


	private function term_results_delete_rows($delete_rows)
    {
        global $wpdb;

	    $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

        if(count($delete_rows) > 0) {

            //delete all rows in one query
            $sql_where_parts = array();
            foreach ($delete_rows as $del_row) {

            	$sql_part = $wpdb->prepare("(field_name='%s' AND field_value='%s')", $del_row['field_name'], $del_row['field_value']);
                array_push($sql_where_parts, $sql_part);
            }


            $no_conditions = count($sql_where_parts);

            if($no_conditions>0) {

                $sql_where_in = implode(" OR ", $sql_where_parts);
                $sql = 'DELETE FROM ' . $this->term_results_table_name . ' WHERE ' . $sql_where_in;
                $results = $wpdb->get_results($sql);
            }

        }
    }


    public function insert_all_term_results($filter_term_ids) {

        global $wpdb;

        $sql_where_parts = array();

	    $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

        if(count($filter_term_ids) > 0) {
            foreach ($filter_term_ids as $filter_name => $filter_term_ids) {

                foreach ($filter_term_ids as $term_id => $term_result_ids) {
                    $results_ids = implode(",", array_keys($term_result_ids));
	                $sql_part = $wpdb->prepare("('%s', '%s', '%s')", $filter_name, $term_id, $results_ids);
                    array_push($sql_where_parts, $sql_part);
                }

            }

            $sql_where_in = implode(", ", $sql_where_parts);
            $sql = 'INSERT INTO `' . $this->term_results_table_name . '` (`field_name`, `field_value`, `result_ids`) VALUES ' . $sql_where_in;
            $insert_result = $wpdb->get_results( $sql );

        }

    }

	private function get_all_cache_term_ids($cache_terms)
    {
        global $wpdb;

	    $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');

        $field_term_ids = array();

        if(count($cache_terms) > 0) {

            $sql_where_parts = array();
            foreach ($cache_terms as $filter_name => $terms)
            {
                $value_col = "field_value";
                $value_type = "%s";

                if($this->is_taxonomy_key($filter_name))
                {
                    $value_col = "field_value_num";
	                $value_type = "%d";
                }
                /*else if($this->is_meta_value($filter_name))
                {
                    $value_col = "field_value";
                }*/

                foreach($terms as $term_id => $term)
                {
	                $sql_part = $wpdb->prepare("(field_name = '%s'  AND $value_col = '$value_type')", $filter_name, $term_id);
                    array_push($sql_where_parts, $sql_part);
                }
            }

            $no_conditions = count($sql_where_parts);

            if($no_conditions==0)
            {
                return $field_term_ids;
            }

            $sql_where_in = implode(" OR ", $sql_where_parts);

            $sql = 'SELECT post_id, field_name, field_value, field_value_num FROM '.$this->cache_table_name.' WHERE '.$sql_where_in;

            $term_results = $wpdb->get_results( $sql );

            foreach($term_results as $term_result)
            {
                if(!isset($field_term_ids[$term_result->field_name]))
                {
                    $field_term_ids[$term_result->field_name] = array();
                }

                $field_value_col = "field_value";
                if($this->is_taxonomy_key($term_result->field_name))
                {
                    $field_value_col = "field_value_num";
                }

                if(!isset($field_term_ids[$term_result->field_name][$term_result->{$field_value_col}]))
                {
                    $field_term_ids[$term_result->field_name][$term_result->{$field_value_col}] = array();
                }

                $field_term_ids[$term_result->field_name][$term_result->{$field_value_col}][$term_result->post_id] = 1;

            }

        }

        return $field_term_ids;
    }
	private function post_delete_cache($postID, $update_term_cache = false){

		global $wpdb;

		$this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');

		if($update_term_cache) {
			$results = $wpdb->get_results( $wpdb->prepare(
				"
					SELECT post_id, field_name, field_value_num, field_value
					FROM $this->cache_table_name
					WHERE post_id = '%d'
				",
				$postID
			) );
		}

		//now  data for thsi post id from cache table - we've collected the data in $results for  use after
		$wpdb->delete( $this->cache_table_name, array( 'post_id' => $postID ) );

		if(!$update_term_cache) {
			return;
		}

		//now we use the data collected in results, to loop through and update teh term cache table too
		$term_cache_delete_rows = array();
		$get_cache_terms = array();

		foreach($results as $result){

			$field_value_col = "field_value";
			if($this->is_taxonomy_key($result->field_name))
			{
				$field_value_col = "field_value_num";
			}

			$term_value = $result->{$field_value_col};
			$term_name = $result->field_name;

			$delete_args = array(

				'field_name' => $term_name,
				'field_value' => $term_value

			);


			array_push($term_cache_delete_rows, $delete_args);

			if(!isset($get_cache_terms[$term_name]))
			{
				$get_cache_terms[$term_name] = array();

			}
			$get_cache_terms[$term_name][$term_value] = 1;
		}

		//we need to update the term cache too so trigger a rebuild of term cahce
		$this->term_results_delete_rows($term_cache_delete_rows);
		//get the new values for the rows
		$all_cache_term_ids = $this->get_all_cache_term_ids($get_cache_terms);
		//insert the new values for the rows
		$this->insert_all_term_results($all_cache_term_ids);
	}

	private function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {

				ob_start();
				var_dump($log);
                //echo "<br />";
				$result = ob_get_clean();

                error_log(  $result );
            } else {
                error_log( $log );
                //echo $log."<br />";
            }
        }
    }


	private function post_insert_data($fields_sql, $postID, $post) {

		global $wpdb;

        if(!empty($fields_sql)) {

	        $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');
            $sql_where_in = implode(", ", $fields_sql);
            $sql = 'INSERT INTO `' . $this->cache_table_name . '` (`post_id`, `post_parent_id`, `field_name`, `field_value_num`, `field_value`, `term_parent_id`) VALUES ' . $sql_where_in;
            $insert_result = $wpdb->get_results($sql);
        }

		$insert_count = count($fields_sql);

		return $insert_count;
	}

	private function set_post_cache_taxonomy_terms($postID, $post) {

		$insert_arr = array();

		$post_type = $post->post_type;
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

        if(Search_Filter_Helper::has_wpml()&&(defined("ICL_LANGUAGE_CODE")))
        {
            $current_language = ICL_LANGUAGE_CODE;
            $post_language_details = apply_filters( 'wpml_post_language_details', null, $postID );

            if(!empty($post_language_details))
            {
                $language_code = $post_language_details['language_code'];
                if(($language_code!=="")&&(!empty($language_code)))
                {
                    do_action( 'wpml_switch_language', $language_code );
                }

            }
        }


		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

			// get the terms related to post
			$terms = get_the_terms( $postID, $taxonomy_slug );

			$insert_arr["_sft_".$taxonomy_slug] = array();

			if ( !empty( $terms ) ) {
				foreach ( $terms as $term ) {

					$term_id = $term->term_id;

					if(Search_Filter_Helper::has_wpml())
					{
						//we need to find the language of the post
						$post_lang_code = Search_Filter_Helper::wpml_post_language_code($postID);

						//then send this with object ID to ensure that WPML is not converting this back
						$term_id = Search_Filter_Helper::wpml_object_id($term->term_id , $term->taxonomy, true, $post_lang_code );
					}

					array_push($insert_arr["_sft_".$taxonomy_slug], (string)$term_id);
				}
			}
		}

        if(Search_Filter_Helper::has_wpml()&&(defined("ICL_LANGUAGE_CODE")))
        {
            do_action( 'wpml_switch_language', $current_language );
        }

        return $insert_arr;

	}

	public function insert_post_cache_taxonomy_terms($taxonomy_insert_array, $postID, $post) {

		global $wpdb;

		$parent_id = 0;
		$wp_parent_id = wp_get_post_parent_id($postID);

		if($wp_parent_id) {
			$parent_id  = $wp_parent_id;
		}

		$sql_where_parts = array();

		foreach($taxonomy_insert_array as $field_name => $field_terms)
		{
			//find depth & parent of taxonomy term
			$taxonomy_name = "";
			if (strpos($field_name, SF_TAX_PRE) === 0) {
				$taxonomy_name = substr($field_name, strlen(SF_TAX_PRE));
			}

			foreach($field_terms as $term_id) {

				$term = get_term($term_id, $taxonomy_name);
				$term_parent_id = 0;
				// If there was an error, continue to the next term.
				if ( !is_wp_error( $term ) ) {
					$term_parent_id = $term->parent;
				}

				$sql_part = $wpdb->prepare("('%d', '%d', '%s', '%d', '%s', '%d')", $postID, $parent_id, $field_name, $term_id, '', $term_parent_id);
				array_push($sql_where_parts, $sql_part);
			}
		}

		return $sql_where_parts;
	}

	public function get_cache_data(){
		return $this->cache_data;
	}

	private function set_post_cache_meta_terms($postID, $post){

		//so we need to find out which meta keys are in use
		$insert_arr = array();

		if(is_array($this->cache_data['meta_keys'])) {
			foreach ( $this->cache_data['meta_keys'] as $meta_key ) {

				$post_custom_values = get_post_custom_values( $meta_key, $postID );


				if ( is_array( $post_custom_values ) ) {
					$insert_arr[ "_sfm_" . $meta_key ] = array();

					foreach ( $post_custom_values as $post_custom_data ) {
						if ( is_serialized( $post_custom_data ) ) {
							$post_custom_data = unserialize( $post_custom_data );

						}

						if ( is_array( $post_custom_data ) ) {
							foreach ( $post_custom_data as $post_custom_value_a ) {
								if ( is_serialized( $post_custom_value_a ) ) {
									$post_custom_value_a = unserialize( $post_custom_value_a );
								}

								if ( is_array( $post_custom_value_a ) ) {
									foreach ( $post_custom_value_a as $post_custom_value_b ) {
										array_push( $insert_arr[ "_sfm_" . $meta_key ], (string) $post_custom_value_b );
									}
								} else {
									array_push( $insert_arr[ "_sfm_" . $meta_key ], (string) $post_custom_value_a );
								}
							}
						} else {
							array_push( $insert_arr[ "_sfm_" . $meta_key ], (string) $post_custom_data );
						}
					}
				}
			}
		}

		return $insert_arr;
	}


	public function insert_post_custom_post_data($postID, $insert_array, $data_type = 'number'){

		$fields_data = $this->insert_post_cache_custom_terms($postID, $insert_array, $data_type);

		$args = array(
			'fields_data' => $fields_data
		);
		$this->update_post_cache($postID, $args);

	}


	public function insert_post_cache_custom_terms($postID, $insert_array, $data_type = 'number'){

		//now insert
		global $wpdb;


		$parent_id = 0;
		$wp_parent_id = wp_get_post_parent_id($postID);

		if($wp_parent_id) {
			$parent_id  = $wp_parent_id;
		}

		$fields_values = array();

		$sql_where_parts = array();
		foreach($insert_array as $field_name => $field_terms)
		{
			$fields_values[$field_name] = $field_terms['values'];

			/*if(!is_array($field_terms)) {
				$field_terms = array($field_terms);
			}*/
			$data_type = $field_terms['type'];

			foreach($field_terms['values'] as $term_value) {

				$term_value_str = '';
				$term_value_num = 0;

				if ( $data_type == 'number' ) {
					$term_value_num = $term_value;
				}
				else {
					$term_value_str = $term_value;
				}


				$sql_part = $wpdb->prepare("('%d', '%d', '%s', '%d', '%s', '%d')", $postID, $parent_id, $field_name, $term_value_num, $term_value_str, 0);
				array_push($sql_where_parts, $sql_part);
			}
		}

		$field_data = array();
		$field_data[0] = $fields_values;
		$field_data[1] = $sql_where_parts;

		return $field_data;
	}

	private function insert_post_cache_post_meta_terms($meta_insert_array, $postID, $post){

		//now insert
		global $wpdb;

		$parent_id = 0;
		$wp_parent_id = wp_get_post_parent_id($postID);

		if($wp_parent_id) {
			$parent_id  = $wp_parent_id;
		}

		$sql_where_parts = array();
		foreach($meta_insert_array as $field_name => $field_terms)
		{
			foreach($field_terms as $term_value) {

				$sql_part = $wpdb->prepare("('%d', '%d', '%s', '%d', '%s', '%d')", $postID, $parent_id, $field_name, 0, $term_value, 0);
				array_push($sql_where_parts, $sql_part);
			}
		}

		return $sql_where_parts;
	}

	public function is_meta_value($key)
	{
		if(substr( $key, 0, 5 )===SF_META_PRE)
		{
			return true;
		}
		return false;
	}

	public function is_taxonomy_key($key)
	{
		if(substr( $key, 0, 5 )===SF_TAX_PRE)
		{
			return true;
		}
		return false;
	}
}

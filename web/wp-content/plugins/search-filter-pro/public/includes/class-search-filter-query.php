<?php
/**
 * Search & Filter Pro
 * 
 * @package   class Search_Filter_Query
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// https://codex.wordpress.org/Creating_Tables_with_Plugins


class Search_Filter_Query {
	
	public $sfid 	= 0;
	public $all_filtered_post_ids 		= array();
	public $all_unfiltered_post_ids		= array();
	public $unfiltered_post_ids  		= array();
	public $filtered_post_ids_excl  	= array();
	public $table_name 				 	= "";
	public $has_run						= false;
	public $has_prep_query				= false;
	public $has_prep_terms				= false;

	
	public $cache_term_results			= array(); //
	//public $cache_field_results			= array(); //
	
	public $term_results				= array(); //an array for each possible term (field value) containing all possible results for  each term
	public $field_results				= array(); //an array of results for all the terms combined for each field (taking into consideration the operator)
	public $cache_field_results			= array(); //an array of results for all the terms combined for each field (taking into consideration the operator)
	
	public $term_counts					= array(); //calculate the number of posts in each term based on the current search/filter
	
	
	public $query_args					= array();
	public $form_settings				= array();
	
	
	public $filters						= array();
	public $all_post_ids_cached			= array();
	
	public $count_data					= array();
	public $cache						= array();
	public $pagination_filter_type		= "";
	public $sort_type 					= "";
	public $add_meta_sort				= array();

	public $filter_next_skip            = 0;

	
	public function __construct($sfid, $settings, $fields, $filters)
	{
		global $wpdb;
		
		if($this->sfid == 0)
		{
			
			$this->sfid = $sfid;
			$this->filter_operator = "and";			
			$this->table_name = $wpdb->prefix . 'search_filter_cache';
			$this->form_fields = $fields;
			$this->form_settings = $settings;
			
			$this->cache = new Search_Filter_Cache($sfid, $settings, $fields, $filters);
			/*
			 * Call $plugin_slug from public plugin class.
			 */
			
			global $searchandfilter;
						
			if(isset($this->form_settings['display_results_as']))
			{
				if($this->form_settings['display_results_as']=="archive")
				{
					add_action( 'pre_get_posts', array( $this, 'setup_archive_query' ), 200 );
				}			
			}
			
			add_filter( 'sf_edit_query_args', array( $this, 'sf_filter_query_args' ), 10, 2);
			add_action( 'parse_query', array($this, 'disable_canonical_redirect' )); //for shortcode methods
			
			//$this->init($sfid);
		}

	}
	public function disable_canonical_redirect( $query )
	{
		remove_filter( 'template_redirect', 'redirect_canonical' );
	}
	public function do_main_query()
	{
		$this->prep_query();
		
		$args = $this->query_args;
		
		query_posts($args);
	}
	public function filter_next_query($skip = 0)
	{
		$this->filter_next_skip = $skip;
        add_action( 'pre_get_posts', array( $this, 'setup_next_query' ), 200 );
	}

	public function hook_setup_archive_query()
	{
		add_action( 'pre_get_posts', array( $this, 'setup_archive_query' ), 200 );
	}
	
	public function setup_custom_query($query)
	{
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);

		remove_filter( 'template_redirect', 'redirect_canonical' );
		$this->prep_query();

		if(!$searchandfilter->has_pagination_init())
		{
			add_filter('get_pagenum_link', array($this, 'pagination_fix_pagenum'), 100);
			add_filter('paginate_links', array($this, 'pagination_fix_paginate'), 100);

			do_action("search_filter_pagination_init");
		}

		//convert already init args and set under pre_get_posts
		foreach ($this->query_args as $key => $val)
        {
			$query->set($key, $val);
		}

		$force_is_search = $searchform->settings("force_is_search");
		if($force_is_search==1)
		{
			$query->set('is_search', true);
			$query->is_search = true;
		}

		$force_is_archive = $searchform->settings("force_is_archive");
		if($force_is_archive==1)
		{
			$query->set('is_archive', true);
			$query->is_archive = true;
		}
	}
	
	public function setup_next_query($query)
    {
    	if($this->filter_next_skip==0) {
		    $this->setup_custom_query( $query );
		    remove_action( 'pre_get_posts', array( $this, 'setup_next_query' ), 200 );
	    }
	    else{
		    $this->filter_next_skip--;
	    }


    }
	public function setup_wc_query($query){

		//$this->prep_query();
		$this->filter_pre_get_posts($query);
	}

	public function setup_archive_query($query, $is_custom_query = false)
	{
		if(!$is_custom_query)
		{
			if(!$query->is_main_query())
			{
				return;
			}
		}

		global $searchandfilter;
		
		$display_results_as = $searchandfilter->get($this->sfid)->settings("display_results_as");

        $enable_taxonomy_archives = $searchandfilter->get($this->sfid)->settings("enable_taxonomy_archives");

		//for post_type_archive results
		$post_types_arr = $searchandfilter->get($this->sfid)->settings("post_types");
		$post_types = array();
		if(is_array($post_types_arr)){
			$post_types = array_keys($post_types_arr);
		}
		
		$filter_query = false;

		//if(($display_results_as=="archive")||($display_results_as=="custom_woocommerce_store")||($display_results_as=="custom_edd_store"))
		if(($display_results_as=="archive")&&( $query->is_main_query() ))
		{
			$filter_query = true;
		}
		else if($display_results_as=="custom_woocommerce_store")
		{
			if(function_exists("is_shop"))
			{
				if(is_shop() && $query->is_main_query())
				{
					add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );
					//$filter_query = true;
					//add_action( 'woocommerce_product_query', array($this, 'setup_wc_query') );
				}
			}

            /*$post_type = "product";
            if(( $query->is_main_query() ) && ($enable_taxonomy_archives==1) && ( Search_Filter_Wp_Data::is_taxonomy_archive($query) ) )
            {
                //now check to make sure this taxonomy belongs to the post type
                if(isset($query->tax_query))
                {
                    if(isset($query->tax_query->queried_terms))
                    {
                        $taxonomy_names = array_keys($query->tax_query->queried_terms);
                        if(count($taxonomy_names)==1)
                        {
                            $taxonomy_name = $taxonomy_names[0];
                            $taxonomies = get_object_taxonomies( $post_type );
                            $is_taxonomy_archive = in_array( $taxonomy_name, $taxonomies );

                            if ($is_taxonomy_archive) {
                                $filter_query = true;
	                            //add_action( 'woocommerce_product_query', array($this, 'setup_wc_query') );
                            }
                        }
                    }
                }
            }*/


		}
		else if($display_results_as=="post_type_archive")
		{
			if(isset($post_types[0]))
			{
				$post_type = $post_types[0];

				if((is_post_type_archive($post_type))&&( $query->is_main_query() ) && ( (!$query->is_tax()) && (!$query->is_category()) && (!$query->is_tag())))
				//if((is_post_type_archive($post_type))&&( $query->is_main_query() ))
				{
					$filter_query = true;
				}
				else if(( $query->is_main_query() ) && ($enable_taxonomy_archives==1) && ( Search_Filter_Wp_Data::is_taxonomy_archive($query) ) )
                {
                    //now check to make sure this taxonomy belongs to the post type
                    if(isset($query->tax_query))
                    {
                        if(isset($query->tax_query->queried_terms))
                        {
                            $taxonomy_names = array_keys($query->tax_query->queried_terms);

                            if(count($taxonomy_names)>0)
                            {//there should only be one really, but sometimes plugins like poly lange will add a taxonomy filter

                                $taxonomy_name = $taxonomy_names[0];
                                $taxonomies = get_object_taxonomies( $post_type );
                                $is_taxonomy_archive = in_array( $taxonomy_name, $taxonomies );

                                if ($is_taxonomy_archive) {

                                    $filter_query = true;
                                }
                            }
                        }
                    }
                }
				else if(($post_type=="post")&&(is_home()))
				{//this then works on the blog page (is_home) set in `settings -> reading -> "a static page" -> posts page
					$filter_query = true;
				}
				else
                {

                }
			}
		}

		if(($filter_query) && ( !is_admin() ))
		{
            $this->filter_pre_get_posts($query);
		}
	}

	public function filter_pre_get_posts($query)
    {
        global $searchandfilter;

        remove_filter( 'template_redirect', 'redirect_canonical' );
        $this->prep_query();

        $force_is_search = $searchandfilter->get($this->sfid)->settings("force_is_search");
        $force_is_archive = $searchandfilter->get($this->sfid)->settings("force_is_archive");

        global $searchandfilter;
        if(!$searchandfilter->has_pagination_init()) {
            add_filter('get_pagenum_link', array($this, 'pagination_fix_pagenum'), 100);
            add_filter('paginate_links', array($this, 'pagination_fix_paginate'), 100);

            do_action("search_filter_pagination_init");
        }

        //convert already init args and set under pre_get_posts
        foreach ($this->query_args as $key => $val)
        {
	        $query->set($key, $val);
        }

	    if(has_filter('sf_main_query_pre_get_posts')) {
		    $query = apply_filters('sf_main_query_pre_get_posts', $query, $this->sfid);
	    }

        if($force_is_search==1)
        {
            $query->set('is_search', true);
            $query->is_search = true;
        }
        if($force_is_archive==1)
        {
            $query->set('is_archive', true);
            $query->is_archive = true;
        }

    }
	public function setup_edd_query($args)
	{
		global $searchandfilter;
		
		//$display_results_as = $searchandfilter->get($this->sfid)->settings("display_results_as");
		
		$this->prep_query();
		
		if(!$searchandfilter->has_pagination_init())
		{
			add_filter('get_pagenum_link', array($this, 'pagination_fix_pagenum'), 100);
			add_filter('paginate_links', array($this, 'pagination_fix_paginate'), 100); 
			
			do_action("search_filter_pagination_init");
		}
		
		$args = array_merge($args, $this->query_args);
		
		return $args;
	}
	
	public function setup_pagination()
	{
		global $searchandfilter;
		if(!$searchandfilter->has_pagination_init())
		{
            $init_pagination = true;

            if(has_filter("search_filter_do_pagination")) {
                $init_pagination = apply_filters("search_filter_do_pagination", $init_pagination);
            }

            if($init_pagination) {
                add_filter('get_pagenum_link', array($this, 'pagination_fix_pagenum'), 100);
                add_filter('paginate_links', array($this, 'pagination_fix_paginate'), 100);

                do_action("search_filter_pagination_init");
            }

		}
		
	}
	/* ***************************** */
	public function prep_query($all_terms = false)
	{
		global $wpdb;
		global $searchandfilter;

		if($this->has_prep_query==false)
		{//only run once

			$this->has_prep_query = true;

			//apply filter logic from cache, and `sf_edit_query_args` filter
			$this->query_args = $this->cache->filter_query_args($this->query_args, $all_terms);


			if(has_filter("sf_query_post__in")) {
				$this->query_args['post__in'] = apply_filters('sf_query_post__in', $this->query_args['post__in'], $this->sfid);
			}

            if(($all_terms==true) && ($this->has_prep_terms==false)) {
                $this->has_prep_terms = true;
            }

			if(has_filter('sf_apply_filter_sort_post__in')) {
				
				//only apply anything here if there has been no custom user sort
				if($this->sort_type == "default")
				{
					$post__in = apply_filters('sf_apply_filter_sort_post__in', $this->query_args['post__in'], $this->query_args, $this->sfid);
					
					$this->query_args['post__in'] = $post__in;
					
					//if this filter exists, we want a custom sort on post__in
					$this->query_args['orderby'] = "post__in";
				}
			}

            //$this->query_args['search_filter_id'] = $this->sfid;

			$this->add_permalink_filters();
		}
        else if(($all_terms==true) && ($this->has_prep_terms==false))
        {
            $this->has_prep_terms = true;
            $this->cache->init_all_filter_terms();
        }

        if(SEARCH_FILTER_QUERY_DEBUG==true)
        {
            //echo "\r\n<!-- #sfdebug prep_query (".$this->sfid.") | query \r\n";
            $query_args_new = $this->query_args;
            $query_args_new['post__in'] = "Count: ".count($this->query_args['post__in']);
            //var_dump($query_args_new);
            //echo "\r\n -->\r\n";
        }

	}

	public function add_permalink_filters()
	{//apply any regular WP_Query logic
		global $searchandfilter;

		/*if($searchandfilter->get($this->sfid)->settings("maintain_state")==1){

			add_filter( 'the_permalink', array($this, 'maintain_search_settings'), 20);
			add_filter( 'post_link', array($this, 'maintain_search_settings'), 20);
			add_filter( 'page_link', array($this, 'maintain_search_settings'), 20);
			add_filter( 'post_type_link', array($this, 'maintain_search_settings'), 20);
		}*/
	}
	public function remove_permalink_filters()
	{
		global $searchandfilter;

		/*if($searchandfilter->get($this->sfid)->settings("maintain_state")==1)
		{
			remove_filter( 'the_permalink', array($this, 'maintain_search_settings'), 20);
			remove_filter( 'post_link', array($this, 'maintain_search_settings'), 20);
			remove_filter( 'page_link', array($this, 'maintain_search_settings'), 20);
			remove_filter( 'post_type_link', array($this, 'maintain_search_settings'), 20);
		}*/
	}

	public function maintain_search_settings($url) {
		
		$tGET = $_GET;
		unset($tGET['action']);
		unset($tGET['paged']);
		unset($tGET['sfid']);
		unset($tGET['lang']);
		unset($tGET['page_id']);

		if(isset($tGET['s']))
		{
			$tGET['_sf_s'] = $tGET['s'];
			unset($tGET['s']);
		}
		foreach($tGET as &$get)
		{
			$get = str_replace(" ", "+", $get); //force + signs back in - otherwise WP seems to strip just " "
		}
		
		return add_query_arg($tGET, $url);

		//return $url;
	}
	
	// grabs all post IDs for the filter name/term - possibly do 1 query for all??


	public function sf_filter_query_args($query_args, $sfid) {

		if($this->sfid==$sfid)
		{
			$query_args = $this->get_wp_query_args($query_args);
		}

		return $query_args;
	}
	
	public function get_wp_query_args($args)
	{
		//ajax paged value
		$sfpaged = 1;
		if(isset($_GET['sf_paged']))
		{
			$sfpaged = (int)$_GET['sf_paged'];
			global $paged;
			$paged = $sfpaged;
			set_query_var("paged", $paged); //some plugins / themes use `get_query_var`, they often shouldn't
		}

		//regular paged value - normally found when loading the page (non ajax)
		$args['paged'] = $sfpaged;
		$args['search_filter_id'] = $this->sfid;
		$args['search_filter_override'] = false;
		
		$args = $this->filter_settings($args);
		$args = $this->filter_query_search_term($args);
		$args = $this->filter_query_post_types($args);
		$args = $this->filter_query_author($args);
		//$args = $this->filter_query_tax_meta($args);
		$args = $this->filter_query_sort_order($args);
		$args = $this->filter_query_posts_per_page($args);
		$args = $this->filter_query_post_date($args);
		$args = $this->filter_query_inherited_defaults($args);
		//$args = $this->filter_query_hidden($args);


		return $args;
	}
	
	private function filter_query_hidden($args)
	{
        global $searchandfilter;
        $display_results_as = $searchandfilter->get($this->sfid)->settings("display_results_as");
        $enable_taxonomy_archives = $searchandfilter->get($this->sfid)->settings("enable_taxonomy_archives");
		
		$post_types_arr = $searchandfilter->get($this->sfid)->settings("post_types");
		$post_types = array();
		if(is_array($post_types_arr)){
			$post_types = array_keys($post_types_arr);
		}
		
        if ($display_results_as == "post_type_archive")
        {
            if($enable_taxonomy_archives == 1)
            {
                if(!isset($post_types[0])) {
                    return;
                }

                $post_type = $post_types[0];
                //$is_taxonomy_archive = false;

                if(is_tax()||is_tag()||is_category())
                {
                    global $searchandfilter;
                    $term = $searchandfilter->get_queried_object();
                    $taxonomy_name = $term->taxonomy;
                    $taxonomies = get_object_taxonomies( $post_type );
                    $is_taxonomy_archive = in_array( $taxonomy_name, $taxonomies );

                    if ($is_taxonomy_archive) {

                        $field_name = "_sft_" . $taxonomy_name;
                        $field_value = $term->slug;

                        $_GET[$field_name] = $field_value;
                    }
                }
            }
        }



		if(isset($this->form_settings['inherit_current_post_type_archive']))
		{
			
			if($this->form_settings['inherit_current_post_type_archive']=="1")
			{
				//if(is_post_type_archive())
                if((is_post_type_archive()) && ((!is_tax()) && (!is_category()) && (!is_tag())))
				{
					$post_type_slug = get_post_type();

					if ( $post_type_slug )
					{
						$args['post_type'] = $post_type_slug;
						//$args['post_type'] = array($post_type_slug);
					}

				}
				else if(is_home())
				{//this is the same as the "posts" archive
					
				}
			}
		}
		
		if(isset($this->form_settings['inherit_current_author_archive']))
		{
			if($this->form_settings['inherit_current_author_archive']=="1")
			{
				global $wp_query;
				
				if(is_author())
				{
					global $searchandfilter;
					$author = $searchandfilter->get_queried_object();
					
					$args['author'] = $author->ID; //here we set the post types that we want WP to search
				}
			}
		}
		
		return $args;
	}

	private function filter_query_inherited_defaults($args)
	{

		if(isset($this->form_settings['inherit_current_post_type_archive']))
		{

			if($this->form_settings['inherit_current_post_type_archive']=="1")
			{
				//if(is_post_type_archive())
                if((is_post_type_archive()) && ((!is_tax()) && (!is_category()) && (!is_tag())))
				{
					$post_type_slug = get_post_type();

					if ( $post_type_slug )
					{
						$args['post_type'] = $post_type_slug;
						//$args['post_type'] = array($post_type_slug);
					}

				}
				else if(is_home())
				{//this is the same as the "posts" archive

				}
			}
		}

		if(isset($this->form_settings['inherit_current_author_archive']))
		{
			if($this->form_settings['inherit_current_author_archive']=="1")
			{
				global $wp_query;

				if(is_author())
				{
					global $searchandfilter;
					$author = $searchandfilter->get_queried_object();

					$args['author'] = $author->ID; //here we set the post types that we want WP to search
				}
			}
		}

		return $args;
	}

	public function filter_query_search_term($args)
	{
		global $wp_query;
		global $searchandfilter;
		

		if(isset($_GET['_sf_s']))
		{
			$search_term = trim(urldecode(stripslashes($_GET['_sf_s'])));
			$args['s'] = $search_term;
		}

		return $args;
	}

	public function filter_query_post_types($args)
	{
		global $wp_query;
		global $searchandfilter;
		$searchform =  $searchandfilter->get($this->sfid);
		
		if(isset($_GET['post_types']))
		{
			$post_types_filter = array();
			$form_post_types = array();
			
			$post_types = $searchform->settings('post_types');
			if($post_types)
			{
				if(is_array($post_types))
				{
					foreach ($post_types as $key => $value)
					{
						array_push($form_post_types, $key);
					}
				}
			}
			
			$user_post_types = explode(",", esc_attr($_GET['post_types']));
			
			if(isset($user_post_types))
			{
				if(is_array($user_post_types))
				{
					//this means the user has submitted some post types
					foreach($user_post_types as $upt)
					{
						if(in_array($upt, $form_post_types))
						{
							array_push($post_types_filter, $upt);
						}
					}
				}					
			}
			
			$args['post_type'] = $post_types_filter; //here we set the post types that we want WP to search
			
		}
		else
		{
			$form_post_types = array();
			$post_types = $searchform->settings('post_types');
			
			if($post_types)
			{
				if(is_array($post_types))
				{
					foreach ($post_types as $key => $value)
					{
						array_push($form_post_types, $key);
					}
				}
			}
			
			$args['post_type'] = $form_post_types;
		}
		
		//if its a single post type, get rid of array - helps with some compatibility issues where themes are not expecting an array here
		if(count($args['post_type'])==1)
		{
			$args['post_type'] = $args['post_type'][0];
		}
		
		if($searchform->settings('force_is_search')==1)
		{
			$args['is_search'] = true;
		}
		
		if($searchform->settings('force_is_archive')==1)
		{
			$args['is_archive'] = true;
		}
		
		
		
		return $args;
	}



	public function filter_query_author($args)
	{
		global $wp_query;
		
		if(isset($_GET['authors']))
		{
			
			$authors = explode(",",esc_attr($_GET['authors']));
			foreach ($authors as &$author)
			{
				$the_author = get_user_by('slug', esc_attr($author));

				$author = (int)$the_author->ID;
			}
			
			$args['author'] = implode(",", $authors); //here we set the post types that we want WP to search
		}
		
		return $args;
	}

	public function filter_query_posts_per_page($args)
	{
		if(isset($_GET['_sf_ppp']))
		{
			$args['posts_per_page'] = (int)$_GET['_sf_ppp'];
		}
		
		return $args;
	}
	public function filter_query_sort_order($args)
	{
		global $wp_query;
		
		if(isset($_GET['orderby'])) // we want to let woocommerce do its orderby
		{
			return $args;
		}

		$built_in_sort_types = array('decimal', 'date', 'datetime');

		if(isset($_GET['sort_order']))
		{
			$search_all = false;
			
			//$sort_order_arr = explode("+",esc_attr(urlencode($_GET['sort_order'])));
			$sort_order_arr = explode(" ",esc_attr($_GET['sort_order']));
			$sort_arr_length = count($sort_order_arr);
			
			$this->sort_type = "user";

			//check both elems in arr exist - field name [0] and direction [1]
			if($sort_arr_length>=2)
			{
				$sort_order_arr[1] = strtoupper($sort_order_arr[1]);
				if(($sort_order_arr[1]=="ASC")||($sort_order_arr[1]=="DESC"))
				{
					if($this->is_meta_value($sort_order_arr[0]))
					{
						$sort_by = "meta_value";


						$meta_type = "";
						if(isset($sort_order_arr[2])){
							$meta_type = strtolower($sort_order_arr[2]);
						}

						if($meta_type=="num")
						{
							$sort_by = "meta_value_num";
							$meta_type = '';
						}

						$meta_key = substr($sort_order_arr[0], strlen(SF_META_PRE));
						
						$args['orderby'] = $sort_by;
						$args['order'] = $sort_order_arr[1];
						$args['meta_key'] = $meta_key;

						if($meta_type!=''){
							$args['meta_type'] = strtoupper($meta_type);
						}
					}
					else
					{
						$sort_by = $sort_order_arr[0];
						if($sort_by=="id")
						{
							$sort_by = "ID";
						}
						
						$args['orderby'] = $sort_by;
						$args['order'] = $sort_order_arr[1];
					}
				}
			}
		}
		else
		{
			$this->sort_type = "default";
			
			global $searchandfilter;
			$searchform = $searchandfilter->get($this->sfid);
			
			$sort_arr = array(); //this contains all the options from the settings in array format
			
			$default_sort_order = array(
				
				'sort_by' => $searchform->settings('default_sort_by'),
				'sort_dir' => strtoupper($searchform->settings('default_sort_dir')),
				'meta_key' => $searchform->settings('default_meta_key'),
				'sort_type' => $searchform->settings('default_sort_type'),
			);
			
			$secondary_sort_order = array(
				
				'sort_by' => $searchform->settings('secondary_sort_by'),
				'sort_dir' => strtoupper($searchform->settings('secondary_sort_dir')),
				'meta_key' => $searchform->settings('secondary_meta_key'),
				'sort_type' => $searchform->settings('secondary_sort_type'),
			);
			
			array_push($sort_arr, $default_sort_order);
			array_push($sort_arr, $secondary_sort_order);
			
			
			$order_by = array();
			
			foreach($sort_arr as $sort_order)
			{
				if(isset($sort_order['sort_by']))
				{
					if($sort_order['sort_by']!="0")
					{	
						if($sort_order['sort_by']=="meta_value")
						{
							$order_by[$sort_order['meta_key']] = $sort_order['sort_dir'];

							if(in_array($sort_order['sort_type'], $built_in_sort_types)){
								$meta_type = strtoupper($sort_order['sort_type']);
							}
							else{
								$meta_type = ( $sort_order['sort_type'] == "numeric" ) ? 'DECIMAL(12,4)' : 'CHAR';
							}
							
							$meta_query = array(
								
								'key'		=> $sort_order['meta_key'],
								'type'		=> $meta_type,
								'compare'	=> 'EXISTS'
							);				

							if(!isset($args['meta_query']))
							{
								$args['meta_query'] = array();
							}
							
							$args['meta_query'][$sort_order['meta_key']] = $meta_query;

						}
						else
						{
							$order_by[$sort_order['sort_by']] = $sort_order['sort_dir'];
						}						
					}
				}
			}
			
			if(!empty($order_by))
			{
				$args['orderby'] = $order_by;
			}
		}
		
		
		return $args;
	}

	public function filter_query_post_date($args)
	{
		global $wp_query;
		
		if(isset($_GET['post_date']))
		{
			//get post dates into array
			$post_date = explode("+", esc_attr(urlencode($_GET['post_date'])));
			
			if(!empty($post_date))
			{
				global $searchandfilter;
				$post_date_field = $searchandfilter->get($this->sfid)->get_field_by_key('post_date');
				
				if(!$post_date_field)
				{
					return $args;
				}
				
				$date_format="m/d/Y";
				
				if(isset($post_date_field['date_format']))
				{
					$date_format = $post_date_field['date_format'];
				}
				
				//if there is more than 1 post date and the dates are not the same
				if (count($post_date) > 1 && $post_date[0] != $post_date[1])
				{
					
					if((!empty($post_date[0]))&&(!empty($post_date[1])))
					{
						
						
						$fromDate = $this->getDateDMY($post_date[0],$date_format);
						$toDate = $this->getDateDMY($post_date[1],$date_format);
						
						$args['date_query'] = array(
							'after' => array(
								'day'   	=> $fromDate['day'],
								'month'     => $fromDate['month'],
								'year'      => $fromDate['year'],
								//'compare'   => '>='
							),
							'before' => array(
								'day'   	=> $toDate['day'],
								'month'     => $toDate['month'],
								'year'      => $toDate['year'],
								//'compare'   => '<='
							),
							'inclusive' => true
						);
					}
				}
				else
				{ //else we are dealing with one date or both dates are the same (so need to find posts for a single day)
					
					
					if (!empty($post_date[0]))
					{
						$theDate = $this->getDateDMY($post_date[0], $date_format);
						
						$args['year'] = $theDate['year'];
						$args['monthnum'] = $theDate['month'];
						$args['day'] = $theDate['day'];
					}
				}
			}
		}
		
		return $args;
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

	public function getDateDMY($date, $date_format)
	{
		if($date_format=="m/d/Y")
		{
			$month = substr($date, 0, 2);
			$day = substr($date, 2, 2);
			$year = substr($date, 4, 4);
		}
		else if($date_format=="d/m/Y")
		{
			$month = substr($date, 2, 2);
			$day = substr($date, 0, 2);
			$year = substr($date, 4, 4);
		}
		else if($date_format=="Y/m/d")
		{

			$month = substr($date, 4, 2);
			$day = substr($date, 6, 2);
			$year = substr($date, 0, 4);
			
		}
		
		$rdate["year"] = $year;
		$rdate["month"] = $month;
		$rdate["day"] = $day;
		
		return $rdate;
	}

	public function get_query_object()
	{
		return $this->the_results(true);
	}


	public function the_results($get_query = false)
	{
		global $searchandfilter;
		
		$this->prep_query();
		
		$args = $this->query_args;

		$returnvar = "";

		//add_action('posts_where', array($this, 'filter_meta_query_where'));
		//add_action('posts_join' , array($this, 'filter_meta_join'));
		
		// Attach hook to filter WHERE clause.
		//add_filter('posts_where', array($this,'limit_date_range_query'));
		// Remove the filter after it is executed.
		//add_action('posts_selection', array($this,'remove_limit_date_range_query'));
		
		/*if($searchandfilter->get($this->sfid)->settings("maintain_state")==1)
		{
			add_filter('the_permalink', array($this, 'maintain_search_settings'));
		}*/
		
		if(!$searchandfilter->has_pagination_init())
		{
			add_filter('get_pagenum_link', array($this, 'pagination_fix_pagenum'), 100);
			add_filter('paginate_links', array($this, 'pagination_fix_paginate'), 100); 
			
			do_action("search_filter_pagination_init");
		}

        //we only store the query in transient for the default query (unfiltered), as this is likely the most visited page, and doing it for every combination of filter would blow up the DB
        //Search_Filter_Helper::start_log("shortcode query");

        //$use_transients = get_option( 'search_filter_cache_use_transients' );
        //$query_str = $searchandfilter->get($this->sfid)->current_query()->get_query_str();

        $cache_key = 'results_query_'.$this->sfid;

        $query_trans = array();
        /*if(($use_transients==1)&&($query_str==""))
        {
            $query_trans = Search_Filter_Wp_Cache::get_transient( $cache_key );
        }*/

        if((empty($query_trans))||($query_trans==false))
        {
            $query = new WP_Query($args);
            /*if(($use_transients==1)&&($query_str=="")) {
                Search_Filter_Wp_Cache::set_transient( $cache_key, $query);
            }*/
        }
        else
        {
            $query = $query_trans;
        }


        //Search_Filter_Helper::finish_log("shortcode query");

		if($get_query)
		{
			return $query;
		}

		
		ob_start();
		
		//first check to see if there is a search form that matches the ID of this form
		if ( $overridden_template = locate_template( 'search-filter/'.$this->sfid.'.php' ) )
		{
			// locate_template() returns path to file
			// if either the child theme or the parent theme have overridden the template
			include($overridden_template);
			
		}
		else
		{
			
			//the check for the default template (results.php)
			
			if ( $overridden_template = locate_template( 'search-filter/results.php' ) )
			{
				// locate_template() returns path to file
				// if either the child theme or the parent theme have overridden the template
				include($overridden_template);
				
			}
			else
			{
				// If neither the child nor parent theme have overridden the template,
				// we load the template from the 'templates' sub-directory of the directory this file is in
				include(plugin_dir_path( SEARCH_FILTER_PRO_BASE_PATH ) . '/templates/results.php');
			}
		}
		
		$returnvar = ob_get_clean();
		
		wp_reset_postdata();
		
		return $returnvar;
		
		
		
	}

	public function pagination_fix_pagenum($url)
	{
		//$new_url = $this->pagination_fix(remove_query_arg("sf_paged", $url));

		$new_url = $this->pagination_fix($url);
		return $new_url;
	}
	public function pagination_fix_paginate($url)
	{
		$new_url = $this->pagination_fix($url);
		return $new_url;
	}

	public function get_page_no_from_url($url)
	{
		$url = str_replace("&#038;", "&", $url);
		$url = str_replace("#038;", "&", $url);
		
		$url_query = parse_url($url, PHP_URL_QUERY);
		$url_args = array();
		parse_str($url_query, $url_args);
		$sf_page_no = 0;

		if(isset($url_args['paged']))
		{
			$sf_page_no = (int)$url_args['paged'];
		}
		else if($this->has_url_var($url, "page")) //check to see if this is different for different langs
		{//try to get page number from permalink url
			$sf_page_no = (int)$this->get_url_var($url, "page");
		}
		else if($this->last_url_param_is_page_no($url)) //check to see if this is different for different langs
		{//try to get page number from permalink url
			$sf_page_no = (int)$this->last_url_param($url);
		}

		else if(isset($url_args['product-page']))
		{//then its woocommerce product shortcode pagination

			$sf_page_no = (int)($url_args['product-page']);
		}
		else if(isset($url_args['sf_paged']))
		{ /* sf_paged check needs to be last, because we will always add it on anyway */

			$current_page = 1;
			if(isset($_GET['sf_paged']))
			{
				$current_page = (int)$_GET['sf_paged'];
			}
			
			// little hack to stop appending `sf_paged` to urls pointing to page 1, where `?sf_paged` is appended to the current URL (and therefor automatically adding it to all pagination links)
			// so if the sf_paged value equals the current pages sf_paged value, don't add it to the URL - who wants pagination linking to the current page anyway
			if($current_page!=(int)$url_args['sf_paged'])
			{
				$sf_page_no = (int)$url_args['sf_paged'];
			}
		}

		return $sf_page_no;
		
	}
	public function get_results_url($searchform)
	{
		$display_results_as = $searchform->settings('display_results_as');
		$enable_taxonomy_archives = $searchform->settings("enable_taxonomy_archives");

		$results_url = "";

		if($display_results_as=="shortcode")
		{
			$results_url = $searchform->settings('results_url');
		}
		else if($display_results_as=="archive")
		{
            $results_url = home_url("?sfid=".$this->sfid);
			$page_slug = "";

            if(get_option('permalink_structure'))
            {
                $page_slug = $searchform->settings('page_slug');
                $home_url = home_url($page_slug);

                if($page_slug!="")
                {
                    if (strpos($home_url, '?') !== false) {
                        $results_url = home_url($page_slug);
                    }
                    else
                    {
                        $results_url = trailingslashit(home_url($page_slug));
                    }
                }
            }

            if(has_filter('sf_archive_results_url')) {

                $results_url = apply_filters('sf_archive_results_url', $results_url, $this->sfid, $page_slug);
            }
		}
		else if(($display_results_as=="custom_woocommerce_store")&&(Search_Filter_Helper::wc_get_page_id()))
		{
			if(get_option('permalink_structure'))
			{
				$results_url = get_permalink( Search_Filter_Helper::wc_get_page_id( 'shop' ));
			}
			else
			{
				$results_url = home_url("?post_type=product");
			}

			$post_type = "product";

            $searchform->query()->remove_permalink_filters();
            if (get_option('permalink_structure')) {
                $results_url = get_permalink( Search_Filter_Helper::wc_get_page_id('shop') );
            }
            $searchform->query()->add_permalink_filters();


            $has_tax_in_fields = false;
            $is_tax_archive = false;

            if (Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_type, false)) {
                $is_tax_archive = true;
                global $searchandfilter;
                $term = $searchandfilter->get_queried_object();
                $filters = $searchform->get_filters();
                if (in_array("_sft_" . $term->taxonomy, $filters)) {
                    $has_tax_in_fields = true;
                }

            }

            if ( /* ($enable_taxonomy_archives == 1)  && ($has_tax_in_fields == true)  && */ ($is_tax_archive)) {

                $results_url = get_term_link($term);
            }

		}
		else if($display_results_as=="post_type_archive")
		{
            $enable_taxonomy_archives = $searchform->settings('enable_taxonomy_archives');

			if(is_array($searchform->settings('post_types')))
			{
				$post_types = array_keys($searchform->settings('post_types'));

				if(isset($post_types[0])) {

                    $is_tax_archive = false;
                    $post_type = $post_types[0];
                    $has_tax_in_fields = false;

                    if(Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_type)) {
                        $is_tax_archive = true;
                        global $searchandfilter;
                        $term = $searchandfilter->get_queried_object();
                        $filters = $searchform->get_filters();
                        if (in_array("_sft_" . $term->taxonomy, $filters)) {
                            $has_tax_in_fields = true;
                        }
                    }

                    if ( /* ($enable_taxonomy_archives==1)  && ($has_tax_in_fields==true)  && */ ($is_tax_archive) ) {

                        $results_url = get_term_link($term);
                    }
                    else {

                    	///////////////////////////
                        //if (($enable_taxonomy_archives==1) && ($is_tax_archive) ) {
                        //    $results_url = get_term_link($term);
                        //}
                        //else {
                            if ($post_type == "post") {
                                if (get_option('show_on_front') == 'page') {
                                    $results_url = get_permalink(get_option('page_for_posts'));
                                } else {
                                    $results_url = home_url('/');
                                }
                            } else {
                                $results_url = get_post_type_archive_link($post_type);
                            }
                        //}

                    }
				}
			}
		}
		else if($display_results_as=="custom")
		{
			$results_url = $searchform->settings('results_url');
		}
		else
		{
			$results_url = $searchform->settings('results_url');
		}

        if($results_url!="")
        {
            if(has_filter('sf_results_url')) {

                $results_url = apply_filters('sf_results_url', $results_url, $this->sfid);
            }
        }
		
		return $results_url;
	}
	public function add_paged_to_url($url, $page_no)
	{
		if($page_no>1)
		{
			$url = add_query_arg("sf_paged", $page_no, $url);
		}
		
		return $url;		
	}

	public function add_url_args($source_url, $dest_url, $display_results_as) {

		$url_query = (parse_url($source_url, PHP_URL_QUERY));
		$url_args = array();

		parse_str($url_query, $url_args); //url decodes the vals

		$remove_args = array("sf_paged", "action", "sf_action", "sfid", "paged");
		
		//if archive method, without a slug, then we must keep in "sfid"
		if($display_results_as=="archive"){

			if(!get_option('permalink_structure')) {

				if(($key = array_search('sfid', $remove_args)) !== false) {
					unset($remove_args[$key]); //remove "sfid" from the remove_args array
				}
			}
		}

		foreach ($url_args as $key => $val){

			if(!in_array($key, $remove_args)){
				$dest_url = add_query_arg($key, urlencode($val), $dest_url);
			}
		}
		
		return $dest_url;
	}

	public function pagination_fix($url){

		global $searchandfilter;
		
		//$url = urldecode($url);
        $url = remove_query_arg("sf_data", $url);

		$sf_url = "";

		//get the page number
		$page_no = $this->get_page_no_from_url($url);

		$url = remove_query_arg("product-page", $url);

		//get the results url
		$searchform = $searchandfilter->get($this->sfid);
		$results_url = $this->get_results_url($searchform);

		//remove args we know we don't want
		$sf_url = $results_url;

		//add args from original URL to the url
		$display_results_as = $searchform->settings('display_results_as');

		$sf_url = $this->add_url_args($url, $sf_url, $display_results_as);

		//add sf_paged variable (back) to the url
		$sf_url = $this->add_paged_to_url($sf_url, $page_no);


		return $sf_url;
	}

	public function get_url_var($url, $name)
	{
		$strURL = $url;
		$arrVals = explode("/",$strURL);
		$found = 0;
		foreach ($arrVals as $index => $value) 
		{
			if($value == $name) $found = $index;
		}
		$place = $found + 1;
		return $arrVals[$place];
	}

	public function has_url_var($url, $name)
	{
		$strURL = $url;
		$arrVals = explode("/",$strURL);
		$found = 0;
		foreach ($arrVals as $index => $value) 
		{
			if($value == $name)
			{
				return true;
			}
		}
		return false;
	}
	public function last_url_param($url){
		//remove query string
		$url = preg_replace('/\?.*/', '', $url);

		//now get the last part
		$url_parts = explode('/', rtrim($url, "/"));
		$last_part = end($url_parts);

		return $last_part;
	}

	public function last_url_param_is_page_no($url)
	{
		global $searchandfilter;
		$current_page = $searchandfilter->get_queried_object();

		//only do this on single posts/pages/custom post types
		if(is_singular()){

			$post = get_post(get_the_ID());
			$slug = $post->post_name;

			//remove query string
			$url = preg_replace('/\?.*/', '', $url);

			//now get the last part
			$url_parts = explode('/', rtrim($url, "/"));
			$last_part = end($url_parts);

			//make sure the last part is not the doc name, and it looks numeric
			if(($last_part!==$slug) && (is_numeric($last_part))){
				return true;
			}

		}

		return false;

	}

	public function filter_settings($args)
	{
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		//posts per page
		$args['posts_per_page'] = $searchform->settings('results_per_page') == "" ? get_option('posts_per_page') : $searchform->settings('results_per_page');
		
		//post status
		if($searchform->settings('post_status')!="")
		{
			$post_status = $searchform->settings('post_status');
			$args['post_status'] = array_map("esc_attr", array_keys($post_status));

			$post_types = $searchform->settings('post_types');
			if($post_types!="")
			{
				if(array_key_exists('attachment', $post_types))
				{
					array_push($args['post_status'], "inherit");
				}
			}
		}
		
		//exclude post ids
		if($searchform->settings('exclude_post_ids')!="")
		{
			$exclude_post_ids = $searchform->settings('exclude_post_ids');
			$args['post__not_in'] = array_map("intval" , explode(",", $exclude_post_ids));
		}
		
		
		if($searchform->settings('sticky_posts')!="")
		{
			$sticky_posts = $searchform->settings('sticky_posts');
			
			if($sticky_posts=="exclude")
			{
				$sticky_post_ids = get_option( 'sticky_posts' );
				
				if(!empty($sticky_post_ids))
				{
					if(!isset($args['post__not_in']))
					{
						$args['post__not_in'] = $sticky_post_ids;
					}
					else if(is_array($args['post__not_in']))
					{
						$args['post__not_in'] = array_merge($args['post__not_in'], $sticky_post_ids);
					}
				}
				
			}
			else if($sticky_posts=="ignore")
			{
				$args['ignore_sticky_posts'] = 1;
			}
			
		}
		
		//include/exclude taxonomies
		if($searchform->settings('taxonomies_settings')!="")
		{
			if(is_array($searchform->settings('taxonomies_settings')))
			{
				foreach ($searchform->settings('taxonomies_settings') as $key => $val)
				{
					
					if($key == "category")
					{
						if(isset($val['ids']))
						{
							if($val['ids']!="")
							{
								if($val["include_exclude"]=="include")
								{
									$args['category__in'] = $this->lang_object_ids(array_map("intval" , explode(",", $val['ids'])), $key);
								}
								else
								{
									$args['category__not_in'] = $this->lang_object_ids(array_map("intval" , explode(",", $val['ids'])), $key);
								}
							}
						}
					}
					else if($key=="post_tag")
					{
						if(isset($val['ids']))
						{
							if($val['ids']!="")
							{
								if($val["include_exclude"]=="include")
								{
									$args['tag__in'] = $this->lang_object_ids(array_map("intval" , explode(",", $val['ids'])), $key);
								}
								else
								{
									$args['tag__not_in'] = $this->lang_object_ids(array_map("intval" , explode(",", $val['ids'])), $key);
								}
							}
						}
					}
					else
					{//taxonomy
						if(isset($val['ids']))
						{
							if($val['ids']!="")
							{
								$args['tax_query']['relation'] = "AND";
								
								if($val["include_exclude"]=="include")
								{
									$operator = "IN";
								}
								else
								{
									$operator = 'NOT IN';
								}
								
								$args['tax_query'][] = array(
									'taxonomy' => $key,
									'field'    => 'id',
									'terms'    => $this->lang_object_ids(array_map("intval" , explode(",", $val['ids'])), $key),
									'operator' => $operator
								);
							}
						}	
					}
					
				}
			}
		}
		
		//meta queries
		if(!isset($args['meta_query']))
		{
			$args['meta_query'] = array();
		}
		
		
		if($searchform->settings('settings_post_meta')!="")
		{
			//$args['meta_query']
			if(is_array($searchform->settings('settings_post_meta')))
			{
				foreach($searchform->settings('settings_post_meta') as $post_meta)
				{					
					$compare_val = "";
					if($post_meta['meta_compare']=="e")
					{
						$compare_val = "=";
					}
					else if($post_meta['meta_compare']=="ne")
					{
						$compare_val = "!=";
					}
					else if($post_meta['meta_compare']=="lt")
					{
						$compare_val = "<";
					}
					else if($post_meta['meta_compare']=="gt")
					{
						$compare_val = ">";
					}
					else if($post_meta['meta_compare']=="lte")
					{
						$compare_val = "<=";
					}
					else if($post_meta['meta_compare']=="gte")
					{
						$compare_val = ">=";
					}
					else
					{
						$compare_val = $post_meta['meta_compare'];
					}
					
					
					if($post_meta['meta_type']=="DATE")
					{
						if($post_meta['meta_date_value_current_date']==1)
						{
							$meta_query = array(
								
								'key'		=> $post_meta['meta_key'],
								'value'		=> date( 'Ymd', current_time( 'timestamp' ) ),
								'type'		=> $post_meta['meta_type'],
								'compare'	=> $compare_val
							);
						}
						else
						{
							$meta_query = array(
								
								'key'		=> $post_meta['meta_key'],
								'value'		=> $post_meta['meta_date_value_date'],
								'type'		=> $post_meta['meta_type'],
								'compare'	=> $compare_val
							);
						}
					}
					else if($post_meta['meta_type']=="TIMESTAMP")
					{
						if($post_meta['meta_date_value_current_timestamp']==1)
						{
							$meta_query = array(
								
								'key'		=> $post_meta['meta_key'],
								'value'		=> current_time('timestamp'),
								'type'		=> "NUMERIC",
								'compare'	=> $compare_val
							);
						}
						else
						{
							$meta_query = array(
								
								'key'		=> $post_meta['meta_key'],
								'value'		=> $post_meta['meta_date_value_timestamp'],
								'type'		=> "NUMERIC",
								'compare'	=> $compare_val
							);
						}
					}
					else
					{
						$meta_query = array(
							
							'key'		=> $post_meta['meta_key'],
							'value'		=> $post_meta['meta_value'],
							'type'		=> $post_meta['meta_type'],
							'compare'	=> $compare_val
						);				
					}
					
					//we don't want to pass the value when checking if a field exists or not
					if(($compare_val=="EXISTS")||($compare_val=="NOT EXISTS"))
					{
						unset($meta_query['value']);
						unset($meta_query['type']);
						
					}
					
					array_push($args['meta_query'], $meta_query);
					
				}
			}
		}
		
		
		return $args;
	}

	public function lang_object_ids($ids_array, $type)
	{
		if(Search_Filter_Helper::has_wpml())
		{
			$res = array();
			foreach ($ids_array as $id)
			{
				$xlat = Search_Filter_Helper::wpml_object_id($id, $type, true);
				if(!is_null($xlat)) $res[] = $xlat;
			}
			return $res;
		}
		else
		{
			return $ids_array;
		}
	}
	
}

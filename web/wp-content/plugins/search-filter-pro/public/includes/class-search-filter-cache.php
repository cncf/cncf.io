<?php
/**
 * Search & Filter Pro
 *
 * @package   class Search_Filter_Cache
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Cache
{

    public $sfid = 0;
    public $all_filtered_post_ids = array();
    public $all_unfiltered_post_ids = array();
    public $unfiltered_post_ids = array();
    public $filtered_post_ids_excl = array();
    public $cache_table_name = "";
    public $WP_FILTER = null;

    public $cache_term_results = array(); //
    public $field_terms_results = array(); //
    public $all_result_ids = array(); //

    //public $cache_field_results			= array(); //

    public $term_results = array(); //an array for each possible term (field value) containing all possible results for  each term
    public $field_results = array(); //an array of results for all the terms combined for each field (taking into consideration the operator)
    public $cache_field_results = array(); //an array of results for all the terms combined for each field (taking into consideration the operator)

    public $term_counts = array(); //calculate the number of posts in each term based on the current search/filter

    public $query_args = array();
    public $form_settings = array();

    public $filters = array();
    public $initial_filters = array();
    public $all_post_ids_cached = array();
    public $has_all_post_ids_cached = false;

    public $count_data = array();
    public $wp_tax_terms = array();

    public $total_combine_result_arrays = 0;
    public $combine_result_arrays_count = 0;

    private $load_only_active_filters = true;
    public $const_time = 0;
    public $use_transients = false;

    public function __construct($sfid, $settings, $fields, $filters)
    {
        global $wpdb;

        if ($this->sfid == 0) {

            $this->sfid = $sfid;

	        $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');
	        $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

            $this->form_fields = $fields;
            $this->form_settings = $settings;

            $this->filter_operator = "and";
            if (isset($this->form_settings['field_relation'])) {
                if ($this->form_settings['field_relation'] != "") {
                    $this->filter_operator = $this->form_settings['field_relation'];
                }
            }

            $this->initial_filters = $filters;
        }
    }


    //the main function, setup query from the cache based on filters, then allow users to hook in to modify query, then init the count variables - eg "term (22)"
    function init_all_filter_terms()
    {
        $this->filter_query_args(array(), true);

    }
    function filter_query_args($query_args, $all_terms = false)
    {
        global $wpdb;

        $this->use_transients = Search_Filter_Helper::get_option( 'cache_use_transients' );

        if (isset($this->form_settings['enable_auto_count'])) {
            if ($this->form_settings['enable_auto_count'] == 1) {
                if($all_terms==true)
                {
                    $this->load_only_active_filters = false;
                }
                else
                {
                    $this->load_only_active_filters = true;
                }
            }
        }

        //Search_Filter_Helper::start_log("Total time to complete query prep");
        //Search_Filter_Helper::start_log("----- Total time");

        //Search_Filter_Helper::start_log("init_filters");
        $this->init_filters($this->initial_filters); //filters are taxonomies or post meta - they are stored in the caching DB for fast calls
        //Search_Filter_Helper::finish_log("init_filters");
        $this->init_hidden_filters();

        //Search_Filter_Helper::start_log("init_filter_terms");
        $this->init_filter_terms($this->initial_filters);
        //Search_Filter_Helper::finish_log("init_filter_terms");

        //set all the results for each term/value
        //Search_Filter_Helper::start_log("set_filter_term_ids_cached");
        $this->set_filter_term_ids_cached(); //grabs the IDs of teh results in each term for each filter
        //Search_Filter_Helper::finish_log("set_filter_term_ids_cached");

        //Search_Filter_Helper::start_log("set_filter_ids_cached");
        $this->set_filter_ids_cached(); //combines the IDs of each term for each filter - taking into account AND/OR operator
        //Search_Filter_Helper::finish_log("set_filter_ids_cached");

        //Search_Filter_Helper::start_log("fetch_all_cached_post_ids");
        $this->fetch_all_cached_post_ids(); //get all possible IDs from the cache
        //Search_Filter_Helper::finish_log("fetch_all_cached_post_ids", true, true);

        //Search_Filter_Helper::start_log("apply_cached_filters");
        $this->apply_cached_filters(); //apply regular WP_Query filters to the post IDs - now we have setup the query_args for the actual search query
        //Search_Filter_Helper::finish_log("apply_cached_filters");

        //Search_Filter_Helper::finish_log("Total time to complete query prep");

        //Search_Filter_Helper::start_log("Total time to complete count query");
        if (isset($this->form_settings['enable_auto_count'])) {
            if (($this->form_settings['enable_auto_count'] == 1)&&($this->load_only_active_filters === false)) {
                $this->init_count_vars();
            }
        }
        //Search_Filter_Helper::finish_log("Total time to complete count query");
        //Search_Filter_Helper::finish_log("----- Total time", true, true);
        //echo "Loop time: ".round($this->const_time, 5)."<hr />";

        return $this->query_args;
    }


    public function init_hidden_filters()
    {
        global $searchandfilter;
        $display_results_as = $searchandfilter->get($this->sfid)->settings("display_results_as");
        $enable_taxonomy_archives = $searchandfilter->get($this->sfid)->settings("enable_taxonomy_archives");
        
		if(!$searchandfilter->get($this->sfid)->settings("post_types")){
			return;
        }
        
        $post_types_arr = $searchandfilter->get($this->sfid)->settings("post_types");
		$post_types = array();
		if(is_array($post_types_arr)){
			$post_types = array_keys($post_types_arr);
		}

        if ((($display_results_as == "post_type_archive")||($display_results_as == "custom_woocommerce_store"))&&($enable_taxonomy_archives == 1))
        {
            if(!isset($post_types[0])) {
                return;
            }

            $post_type = $post_types[0];

            $single = true;
            if($display_results_as == "custom_woocommerce_store"){
	            $single = false;
            }

            if(Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_type, $single))
            {
                $term = $searchandfilter->get_queried_object();
                $taxonomy_name = $term->taxonomy;

                $field_name = "_sft_" . $taxonomy_name;
                $field_value = $term->slug;

                if(!in_array($field_name, $this->initial_filters)) {
                    array_push($this->initial_filters, $field_name);
                }
                //if the field is visible set it
                $_GET[$field_name] = $field_value;

                if(!isset($this->filters[$field_name]))
                {
                    $this->filters[$field_name] = array();

                    $this->filters[$field_name]['source'] = "taxonomy";
                    $this->filters[$field_name]['taxonomy_name'] = $taxonomy_name;
                    $this->filters[$field_name]['type'] = "choice";

                    $this->filters[$field_name]['cached_result_ids'] = array(); //these are all the result IDs for the whole field/filter (combining all IDs from terms)
                    $this->filters[$field_name]['wp_query_result_ids'] = array(); //these are all the result IDs for the whole field/filter (combining all IDs from terms)
                    $this->filters[$field_name]['wp_query_result_ids_unfiltered'] = array(); //

                    $this->filters[$field_name]['active_values'] = array(); //this is what has been searched (ie $_GET from the url)
                    $this->filters[$field_name]['term_operator'] = "and";
                    $this->filters[$field_name]['terms'] = array(); //array containing all terms for current filter - with result IDs etc

                    $this->filters[$field_name]['active_values'] = array($field_value);
                }
                else
                {
                    if(!in_array($field_value, $this->filters[$field_name]['active_values'])) {
                        array_push($this->filters[$field_name]['active_values'], $field_value);
                    }
                }

                $this->filters[$field_name]['is_active'] = true;
            }
        }
    }

    public function init_filters($filters)
    {

        foreach ($filters as $filter_name) {


            $filter_name_get = str_replace(array(" ", "."), "_", $filter_name); //replace space with `_` as this is done anyway - spaces are not allowed in GET variable names, and are automatically converted by server/browser to `_`

            if(!isset($this->filters[$filter_name]) ) {

                $this->filters[$filter_name] = array();

                $taxonomy_types = array("tag", "category", "taxonomy");

                $this->filters[$filter_name]['type'] = "choice";

                if (in_array($this->form_fields[$filter_name]["type"], $taxonomy_types)) {
                    $this->filters[$filter_name]['source'] = "taxonomy";

                    if (strpos($filter_name, SF_TAX_PRE) === 0) {
                        $taxonomy_name = substr($filter_name, strlen(SF_TAX_PRE));
                        $this->filters[$filter_name]['taxonomy_name'] = $taxonomy_name;
                        $this->filters[$filter_name]['type'] = "choice";
                    }


                } else if ($this->form_fields[$filter_name]["type"] == "post_meta") {
                    $this->filters[$filter_name]['source'] = "post_meta";
                    $this->filters[$filter_name]['type'] = $this->form_fields[$filter_name]["meta_type"];
                }

                $this->filters[$filter_name]['cached_result_ids'] = array(); //these are all the result IDs for the whole field/filter (combining all IDs from terms)
                $this->filters[$filter_name]['wp_query_result_ids'] = array(); //these are all the result IDs for the whole field/filter (combining all IDs from terms)
                $this->filters[$filter_name]['wp_query_result_ids_unfiltered'] = array(); //

                $this->filters[$filter_name]['active_values'] = array(); //this is what has been searched (ie $_GET from the url)
                $this->filters[$filter_name]['is_active'] = false;
                $this->filters[$filter_name]['term_operator'] = array();
                $this->filters[$filter_name]['terms'] = array(); //array containing all terms for current filter - with result IDs etc



                //set is_range
                $range = false;
                if ($this->filters[$filter_name]['type'] == "date") {
                    if ($this->form_fields[$filter_name]['date_input_type'] == "daterange") {
                        $range = true;

                        //$_filter_name = SF_META_PRE.$this->form_fields[$filter_name]['compare_mode'];
                        $compare_mode = "userrange";

                        if (isset($this->form_fields[$filter_name]["date_compare_mode"])) {
                            $compare_mode = $this->form_fields[$filter_name]["date_compare_mode"];
                        }

                        $this->filters[$filter_name]['compare_mode'] = $compare_mode;
                    }
                } else if ($this->filters[$filter_name]['type'] == "number") {
                    $range = true;

                    $this->filters[$filter_name]['is_decimal'] = 0;
                    if (isset($this->form_fields[$filter_name]["number_is_decimal"])) {

                        if ($this->form_fields[$filter_name]["number_is_decimal"] == 1) {
                            $decimal_places = 2;

                            if (isset($this->form_fields[$filter_name]["number_decimal_places"])) {
                                $decimal_places = $this->form_fields[$filter_name]["number_decimal_places"];
                            }

                            $this->filters[$filter_name]['decimal_places'] = $decimal_places;
                        }


                    }
                    $compare_mode = "userrange";

                    if (isset($this->form_fields[$filter_name]["number_compare_mode"])) {
                        $compare_mode = $this->form_fields[$filter_name]["number_compare_mode"];
                    }

                    $this->filters[$filter_name]['compare_mode'] = $compare_mode;
                }

                $this->filters[$filter_name]['is_range'] = $range;


                //set the active terms for each filter
                if ($this->filters[$filter_name]['type'] == "choice") {
                    $this->filters[$filter_name]['term_operator'] = $this->form_fields[$filter_name]["operator"];

                    if ($this->filters[$filter_name]['source'] == "taxonomy") {
                        if (($this->form_fields[$filter_name]['input_type'] == "select") || ($this->form_fields[$filter_name]['input_type'] == "radio") || ($this->form_fields[$filter_name]['input_type'] == "list"))//for single select force "OR" relationship
                        {
                            $this->filters[$filter_name]['term_operator'] = "or";
                        }
                    } else if ($this->filters[$filter_name]['source'] == "post_meta") {
                        if (($this->form_fields[$filter_name]['choice_input_type'] == "select") || ($this->form_fields[$filter_name]['choice_input_type'] == "radio") || ($this->form_fields[$filter_name]['input_type'] == "list"))//for single select force "OR" relationship
                        {
                            $this->filters[$filter_name]['term_operator'] = "or";
                        }
                    }

                    if (isset($_GET[$filter_name_get])) {
                        //get the value and parse it - might need to parse different for meta
                        //$filter_value = sanitize_text_field($_GET[$filter_name_get]);
                        $filter_value = $_GET[$filter_name_get];
                        $this->filters[$filter_name]['active_values'] = $this->parse_get_value($filter_value, $filter_name, $this->filters[$filter_name]['source']);
                        $this->filters[$filter_name]['is_active'] = true;

                    } else {
                        //if its not set in the URL try to detect from the current page if the setting is enabled
                        //filter_query_inherited_defaults
                        if ($this->filters[$filter_name]['source'] == "taxonomy") {
                            if (isset($this->form_settings['inherit_current_taxonomy_archive'])) {
                                if ($this->form_settings['inherit_current_taxonomy_archive'] == "1") {
                                    if (is_tax() || is_category() || is_tag()) {
                                        global $searchandfilter;
                                        $term = $searchandfilter->get_queried_object();

                                        if ($filter_name == "_sft_" . $term->taxonomy) {
                                            //we should try to inherit the taxonomy values from this archive page
                                            $this->filters[$filter_name]['active_values'] = array(utf8_uri_encode($term->slug));
                                            $this->filters[$filter_name]['is_active'] = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else if ($this->filters[$filter_name]['is_range'] == true) /* daterange and number range */ {
                    $this->filters[$filter_name]['term_operator'] = "and"; //when using a number operator always use AND because its a combination of the two result sets

                    if (isset($_GET[$filter_name_get])) {
                        //get the value and parse it - might need to parse different for meta
                        $filter_value = sanitize_text_field($_GET[$filter_name_get]);

                        if ($this->filters[$filter_name]['type'] == "date") {//then we need to convert the _GET to the correct date format
                            $this->filters[$filter_name]['active_values'] = $this->parse_get_value($filter_value, $filter_name, $this->filters[$filter_name]['source'], "date");
                        } else {
                            $this->filters[$filter_name]['active_values'] = $this->parse_get_value($filter_value, $filter_name, $this->filters[$filter_name]['source'], "simple");
                        }

                        $this->filters[$filter_name]['is_active'] = true;

                    }
                } else {
                    if (isset($_GET[$filter_name_get])) {
                        //get the value and parse it - might need to parse different for meta
                        $filter_value = sanitize_text_field($_GET[$filter_name_get]);

                        if ($this->filters[$filter_name]['type'] == "date") {
                            $this->filters[$filter_name]['term_operator'] = "or";
                            $this->filters[$filter_name]['is_active'] = true;
                            $this->filters[$filter_name]['active_values'] = $this->parse_get_value($filter_value, $filter_name, $this->filters[$filter_name]['source'], "date");

                        }
                    }

                }
            }
        }

    }


    function init_filter_terms($filters)
    {
        foreach ($filters as $filter_name) {

            $filter_terms_init = false;

            if(isset($this->filters[$filter_name]['filter_terms']))
            {
                $filter_terms_init = true;
            }

            if(!$filter_terms_init) {

                /* TODO - this could be used to find min / max - but all searches are performed on active_terms */
                if ($this->filters[$filter_name]['type'] == "choice") {

                    $filter_terms = array();
                    $filter_terms_trans = array();
                    $cache_key = 'filter_terms_' . $this->sfid . '_' . $filter_name;

                    //in the transient we only store an array of values, to keep the size of it small, so we must re-init the objects using the terms
                    if ($this->use_transients == 1) {

                        $filter_terms_trans = Search_Filter_Wp_Cache::get_transient($cache_key);
                        if (!empty($filter_terms_trans)) {
                            foreach ($filter_terms_trans as $filter_term_value) {

                                $filter_term = new stdClass();
                                $filter_term->field_value = $filter_term_value;
                                array_push($filter_terms, $filter_term);
                            }
                        }

                    }

                    if ((empty($filter_terms) && (empty($filter_terms_trans))))
                    {
                        if ($this->filters[$filter_name]['source'] == "taxonomy") {
                            $filter_terms = $this->get_filter_terms_all($filter_name, $this->filters[$filter_name]['source']);
                        } else {//them meta
                            $filter_terms = $this->get_filter_terms_all($filter_name, $this->filters[$filter_name]['source']);
                            //$filter_terms = $this->get_filter_terms_meta($filter_name, $this->form_fields[$filter_name]);
                        }

                        if ($this->use_transients == 1) {
                            $terms_arr = array();
                            foreach ($filter_terms as $filter_term) {
                                array_push($terms_arr, $filter_term->field_value);
                            }
                            Search_Filter_Wp_Cache::set_transient($cache_key, $terms_arr);
                        }
                    }

                } else if ($this->filters[$filter_name]['is_range'] == true) {
                    $filter_terms = array();
                    $filter_terms[0] = new stdClass();
                    $filter_terms[0]->field_value = "value";
                    //$filter_terms[1] = new stdClass();
                    //$filter_terms[1]->field_value = "max";
                } else {
                    $filter_terms = array();


                    if ($this->filters[$filter_name]['type'] == "date") {
                        $filter_terms[0] = new stdClass();
                        $filter_terms[0]->field_value = "value";
                    }
                }
                //}
                $this->filters[$filter_name]['filter_terms'] = $filter_terms;
            }

            $filter_terms = $this->filters[$filter_name]['filter_terms'];

            if (count($filter_terms) > 0) {

                // if the taxonomy is hierarchical, and the user has set it as so, and the've set the option "include_children"
                // then get all the terms for the taxonomy, because we'll need them for figuring out child/parent related
                // stuff in the query
                $hierarchical_override = false;
                if($this->filters[$filter_name]['source'] == "taxonomy")
                {
                    if(is_taxonomy_hierarchical($this->filters[$filter_name]['taxonomy_name']))
                    {
                        $hierarchical = 0;
                        $include_children = 0;
                        if ((isset($this->form_fields[$filter_name]['hierarchical'])) && (isset($this->form_fields[$filter_name]['include_children']))) {
                            $hierarchical = $this->form_fields[$filter_name]['hierarchical'];
                            $include_children = $this->form_fields[$filter_name]['include_children'];
                        }

                        if (($hierarchical == 1) && ($include_children == 1)) {
                            $hierarchical_override = true;
                        }
                    }
                }

                // init the terms on local variable
                if ((($this->load_only_active_filters === false)&&($this->filters[$filter_name]['source'] == "taxonomy")) || ($hierarchical_override == true)) {
                    Search_Filter_Wp_Data::get_taxonomy_terms($this->filters[$filter_name]['taxonomy_name']);
                }

                foreach ($filter_terms as $filter_term) {

                    $this->init_filter_term($filter_term, $filter_name);

                }

            }

        }
    }

    private function init_filter_term($filter_term, $filter_name)
    {
        $add_term = false;

        //if term is not already init
        //if(!isset($this->filters[$filter_name]['terms'])) {

        if ($this->filters[$filter_name]['source'] == "taxonomy") {//then we will have IDs - so we need to convert back to slug


            if ($this->load_only_active_filters === true) {

                $active_value_ids = array();
                foreach ($this->filters[$filter_name]['active_values'] as $active_value) {

                    $term = Search_Filter_Wp_Data::get_taxonomy_term_by("slug", $active_value, $this->filters[$filter_name]['taxonomy_name']);

                    if ((!is_wp_error($term))&&(!empty($term))) {
                        $term_id = $term->term_id;
                        array_push($active_value_ids, $term_id);
                    }

                }

                if (in_array($filter_term->field_value, $active_value_ids)) {
                    Search_Filter_Wp_Data::get_taxonomy_term_by("id", $filter_term->field_value, $this->filters[$filter_name]['taxonomy_name']);
                }
            }

            if (isset(Search_Filter_Wp_Data::$wp_tax_terms[$this->filters[$filter_name]['taxonomy_name']])) {
                $wp_tax_terms_array = Search_Filter_Wp_Data::$wp_tax_terms[$this->filters[$filter_name]['taxonomy_name']];
                if (isset($wp_tax_terms_array["id"][$filter_term->field_value])) {//make sure term exists

                    $term = $wp_tax_terms_array["id"][$filter_term->field_value];
                    $term_name = $term->slug;

                    if(empty($this->filters[$filter_name]['terms'][$term_name])) {

                        $this->filters[$filter_name]['terms'][$term_name] = array();
                        $this->filters[$filter_name]['terms'][$term_name]['term_id'] = $term->term_id;
                        $add_term = true;
                    }

                }
            }

        } else {
            $add_term = true;
            $term_name = $filter_term->field_value;
            if(empty($this->filters[$filter_name]['terms'][$term_name])) {
                $this->filters[$filter_name]['terms'][$term_name] = array();
            }


        }

        //last check, if we do not display the search form, we only need to initialise those filter which are active
        /*if ($this->load_only_active_filters === true){
            if ($add_term) {
                if (!in_array($filter_term->field_value, $this->filters[$filter_name]['active_values'])) {
                    $add_term = false;
                }
            }
        }*/

        //if (($add_term) && (in_array($filter_term->field_value, $this->filters[$filter_name]['active_values']))) {
        if ($add_term) {


            //all the IDs used for setting up queries & counts
            if(empty($this->filters[$filter_name]['terms'][$term_name])) {
                $this->filters[$filter_name]['terms'][$term_name]['cache_result_ids'] = array();
                $this->filters[$filter_name]['terms'][$term_name]['wp_query_results_ids'] = array();
                $this->filters[$filter_name]['terms'][$term_name]['count'] = 0;
            }
        }
    }
    /*
    function preg_replace_callback_uppercaser($match) {
        return strtoupper($match[0]);
    }
    $string = preg_replace_callback('/%[a-zA-Z0-9]{2}/', 'preg_replace_callback_uppercaser', $string);
    */

    /* get array of values from a $_GET value - usually just an explode */
    function parse_get_value($value, $filter_name, $source, $format = "")
    {
        $value = stripslashes($value);
        $active_terms = array();
        if (($source == "taxonomy") || ($format == "simple") || ($format == "date")) {

            if (strpos(esc_attr($value), ',') !== false) {
                $operator = "OR";
                $ochar = ",";
                $active_terms = explode($ochar, esc_attr(($value)));
            } else {
                $operator = "AND";
                $ochar = "+";

	            $value = str_replace(" ", "+", $value);
	            //$active_terms = explode($ochar, esc_attr(urlencode($value)));
                $active_terms = explode($ochar, esc_attr($value));

            }

	        $active_terms = array_map('urldecode', ($active_terms));
	        $active_terms = array_map('utf8_uri_encode', ($active_terms)); //use wordpress' method for encoding so it will always match what is stored in teh actual terms table


	        $active_terms_count = count($active_terms);

            if ($format == "date") {//convert $active_terms

                $date_output_format = "m/d/Y";
                $date_input_format = "timestamp";

                if (isset($this->form_fields[$filter_name]['date_output_format'])) {
                    $date_output_format = $this->form_fields[$filter_name]['date_output_format'];
                }
                if (isset($this->form_fields[$filter_name]['date_input_format'])) {
                    $date_input_format = $this->form_fields[$filter_name]['date_input_format'];
                }


                if ($active_terms_count == 2) {

                    if ($date_input_format == "timestamp") {
                        $minval = $this->convert_date_to('timestamp', $active_terms[0], $date_output_format);
                        $maxval = $this->convert_date_to('timestamp', $active_terms[1], $date_output_format);
                    } else if ($date_input_format == "yyyymmdd") {
                        $minval = $this->convert_date_to('yyyymmdd', $active_terms[0], $date_output_format);
                        $maxval = $this->convert_date_to('yyyymmdd', $active_terms[1], $date_output_format);
                    }

                    $active_terms[0] = $minval;
                    $active_terms[1] = $maxval;
                } else {

                    if ($date_input_format == "timestamp") {
                        $dateval = $this->convert_date_to('timestamp', $active_terms[0], $date_output_format);
                    } else if ($date_input_format == "yyyymmdd") {
                        $dateval = $this->convert_date_to('yyyymmdd', $active_terms[0], $date_output_format);
                    }

                    $active_terms[0] = $dateval;


                }
            }
        } else if ($source == "post_meta") {

            if (strpos(($value), '-,-') !== false) {
                $operator = "OR";
                $ochar = "-,-";
            } else {
                $operator = "AND";
                $ochar = "-+-";
                $replacechar = "- -";
                $value = str_replace($replacechar, $ochar, $value);
            }

            $active_terms = explode($ochar, ($value));
        }

        return $active_terms;
    }

    function convert_date_to($type, $date, $date_output_format)
    {
        if (!empty($date)) {
            if ($date_output_format == "m/d/Y") {
                $month = substr($date, 0, 2);
                $day = substr($date, 2, 2);
                $year = substr($date, 4, 4);
            } else if ($date_output_format == "d/m/Y") {
                $month = substr($date, 2, 2);
                $day = substr($date, 0, 2);
                $year = substr($date, 4, 4);
            } else if ($date_output_format == "Y/m/d") {
                $month = substr($date, 4, 2);
                $day = substr($date, 6, 2);
                $year = substr($date, 0, 4);
            }

            if ($type == "timestamp") {
                $date = strtotime($year . "-" . $month . "-" . $day);
            } else if ($type == "yyyymmdd") {
                $date = $year . $month . $day;
            }

            //$date_query['after'] = date('Y-m-d 00:00:00', strtotime($date));
        }
        return $date;
    }



    //grabs all the IDS in teh cached table for each individual term
    public function set_filter_term_ids_cached()
    {
        global $wpdb;
        $filter_names = array();
        $filter_names = array_unique(array_keys($this->filters));
        $filter_query_arr = array();

        if(has_filter("search_filter_cache_filter_names"))
        {
            $filter_names = apply_filters('search_filter_cache_filter_names', $filter_names, $this->sfid);
        }

        foreach ($filter_names as $filter_name) {
            array_push($filter_query_arr, "field_name = '$filter_name'");
        }

        $filter_query_sql = implode(" OR ", $filter_query_arr);

        if (empty($filter_query_sql)) {
            return;
        }

        $already_init = false;

	    $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

        if(empty($this->field_terms_results)) {

            /*$cache_key = 'cached_field_terms_results_'.$this->sfid;
            $cached_field_terms_results = array();

            if($this->use_transients==1){
                $cached_field_terms_results = Search_Filter_Wp_Cache::get_transient( $cache_key );
            }

            if((!empty($cached_field_terms_results))&&($this->use_transients==1)){
                $this->field_terms_results = $cached_field_terms_results;
            }
            else {
                // too big for transient on larger sites atm, plus, the query is quite basic already */
                $this->field_terms_results = $wpdb->get_results(
                    "
                SELECT field_name, field_value, result_ids
                FROM $this->term_results_table_name
                WHERE $filter_query_sql
                "
                );
                /*
                if($this->use_transients==1) {
                    Search_Filter_Wp_Cache::set_transient( $cache_key, $this->field_terms_results);
                }
            }*/
        }
        else
        {
            $already_init = true;
        }

        $cache_term_results = array();

        foreach ($this->field_terms_results as $term_result) {
            $setup_term = true;

            if (!isset($cache_term_results[$term_result->field_name])) {
                $cache_term_results[$term_result->field_name] = array();
            }

            $field_value = $term_result->field_value;

            if ($this->is_taxonomy_key($term_result->field_name)) {

                $setup_term = false; //couldn't fine the term, so don't try to add it

                //only setup this term if it hasn't been already v2.3
                if(empty($this->filters[$term_result->field_name]['terms'][$field_value]['cache_result_ids'])) {

                    $taxonomy_name = substr($term_result->field_name, strlen(SF_TAX_PRE));

                    if (isset(Search_Filter_Wp_Data::$wp_tax_terms[$taxonomy_name])) {

                        $wp_tax_terms_array = Search_Filter_Wp_Data::$wp_tax_terms[$taxonomy_name];

                        if (isset($wp_tax_terms_array["id"][$term_result->field_value])) {//make sure term exists

                            $term = $wp_tax_terms_array["id"][$term_result->field_value];
                            $field_value = $term->slug;
                            $setup_term = true; //couldn't fine the term, so don't try to add it
                        }
                    }


                    if ((Search_Filter_Helper::has_wpml()) && (!empty($term))) {
                        //do not even add the term to the list if its in the wrong language
                        if ($term_result->field_value != $term->term_id) {
                            //this means WPML changed teh ID to current language ID, which means we just want to skip over this completely
                            $setup_term = false;
                        }
                    }
                }

            }
            else if($this->is_meta_key($term_result->field_name)) {
	            //true
            }

			if ( $setup_term ) {

				$cache_term_results[ $term_result->field_name ][ $field_value ] = explode( ",", $term_result->result_ids );

				//this captures all the post IDs S&F has found from its tables, can add overhead
				$register_result_ids = false;
				if ( has_filter( 'sf_query_cache_register_all_ids' ) ) {
					//check to see if this should be enabled
					$register_result_ids = apply_filters( 'sf_query_cache_register_all_ids', $register_result_ids, $this->sfid );
				}
				if ( $register_result_ids == true ) {
					$this->register_result_ids( $cache_term_results[ $term_result->field_name ][ $field_value ] );
				}

			}
        }


        //if(!$already_init) {
        foreach ($this->filters as $filter_name => $filter) {

            $field_terms = $this->filters[$filter_name]["terms"];

            if ($filter['type'] == "choice") {

                foreach ($field_terms as $term_name => $tval) {
                    $cached_term_results = array();

                    if (isset($cache_term_results[$filter_name])) {
                        if (isset($cache_term_results[$filter_name][$term_name])) {
                            $cached_term_results = $cache_term_results[$filter_name][$term_name];
                        }
                    }

                    $this->filters[$filter_name]['terms'][$term_name]['cache_result_ids'] = $cached_term_results;
                }

                $hierarchical = 0;
                $include_children = 0;
                if ((isset($this->form_fields[$filter_name]['hierarchical'])) && (isset($this->form_fields[$filter_name]['include_children']))) {
                    $hierarchical = $this->form_fields[$filter_name]['hierarchical'];
                    $include_children = $this->form_fields[$filter_name]['include_children'];
                }
                //$hierarchical = 1;
               //$include_children = 1;


                if (($hierarchical == 1) && ($include_children == 1)) {

                    $taxonomy_name = "";
                    $term_ids_w_parent = array();

                    if (strpos($filter_name, SF_TAX_PRE) === 0) {
                        $taxonomy_name = substr($filter_name, strlen(SF_TAX_PRE));
                    }

                    if ($taxonomy_name != "") {

                        foreach ($field_terms as $term_name => $the_term) {
                            if (isset($the_term['term_id'])) {
                                $ancestors = get_ancestors($the_term['term_id'], $taxonomy_name);

                                foreach ($ancestors as $ancestor) {
                                    if (!isset($term_ids_w_parent[$ancestor])) {
                                        $term_ids_w_parent[$ancestor] = array();
                                    }

                                    $term_ids_w_parent[$ancestor] = array_merge($term_ids_w_parent[$ancestor], $this->filters[$filter_name]['terms'][$term_name]['cache_result_ids']);
                                }
                            }
                        }

                        foreach ($term_ids_w_parent as $term_wp_id => $term_wp_ids) {//get

                            $push_term = get_term($term_wp_id, $taxonomy_name);
                            $push_term_name = $push_term->slug;

                            if (isset($this->filters[$filter_name]['terms'][$push_term_name])) {

                                $this->filters[$filter_name]['terms'][$push_term_name]['cache_result_ids'] = array_unique(array_merge($this->filters[$filter_name]['terms'][$push_term_name]['cache_result_ids'], $term_wp_ids));
                            } else {
                                $this->filters[$filter_name]['terms'][$push_term_name] = array();
                                $this->filters[$filter_name]['terms'][$push_term_name]['cache_result_ids'] = $term_wp_ids;
                            }

                        }


                        //now put these IDs back on the the cached result IDs
                    }
                } else {
                    //echo "don't include the kids";
                }


            } else if ($filter['is_range'] == true) {

                if(empty($this->filters[$filter_name]['terms']["value"]['cache_result_ids']))
                {
                    $start_field_name = $filter_name;
                    $end_field_name = $filter_name; //start / end keys are the same

                    if ($filter['type'] == "number") {
                        if (isset($this->form_fields[$filter_name]['number_use_same_toggle'])) {
                            if ($this->form_fields[$filter_name]['number_use_same_toggle'] != 1) {
                                $end_field_name = SF_META_PRE . $this->form_fields[$filter_name]['number_end_meta_key'];
                            }
                        }
                    } else if ($filter['type'] == "date") {
                        if (isset($this->form_fields[$filter_name]['date_use_same_toggle'])) {
                            if ($this->form_fields[$filter_name]['date_use_same_toggle'] != 1) {
                                $end_field_name = SF_META_PRE . $this->form_fields[$filter_name]['date_end_meta_key'];
                            }
                        }
                    }

                    $this->filters[$filter_name]['terms']["value"]['cache_result_ids'] = $this->get_cache_number_range_ids($start_field_name, $end_field_name, $this->filters[$filter_name]);
                }

            } else {


                /* todo should this be $term_name or "value" */

	            if ($filter['type'] == "date") {
		            foreach ($field_terms as $term_name => $tval) {
			            $this->filters[$filter_name]['terms']['value']['cache_result_ids'] = $this->get_cache_number_ids($filter_name, $term_name, $this->filters[$filter_name]);
		            }
	            }



                /*if(!isset($this->filters[$filter_name]['terms'][$term_name]['cache_result_ids'])) {
                    if ($filter['type'] == "date") {
                        foreach ($field_terms as $term_name => $tval) {
                            $this->filters[$filter_name]['terms'][$term_name]['cache_result_ids'] = $this->get_cache_number_ids($filter_name, $term_name, $this->filters[$filter_name]);
                        }
                    }
                }*/
            }

        }


        if(has_filter('sf_query_cache_field_terms_results')) {
            $this->filters = apply_filters('sf_query_cache_field_terms_results', $this->filters, $cache_term_results, $this->sfid);
        }

        //}

    }

    public function get_registered_result_ids()
    {
        return $this->all_result_ids;
    }
    private function register_result_ids($result_ids)
    {
        foreach($result_ids as $result_id)
        {
            $this->all_result_ids[$result_id] = 1;
        }

    }
    //combine term ids with the operator to get the list of IDs in use by the whole filter
    public function set_filter_ids_cached()
    {
        foreach ($this->filters as $filter_name => $filter) {
            $merge_count = 0;

            $get_all_term_ids = false;

            if ($filter['is_active'] == true) {
                if (($filter['term_operator'] == "or") && ($this->filter_operator == "or")) {
                    $get_all_term_ids = true;
                }
            } else {
                $get_all_term_ids = true;
            }

            if ($filter['is_active'] == true) {

                $field_terms = $filter["terms"];
                $active_values = $filter["active_values"];
                $filter_term_ids = array();

                if ($filter['type'] == "choice") {
                    foreach ($active_values as $active_value) {
                        if (isset($filter['terms'][$active_value])) {
                            $filter_term_ids[$active_value] = $filter['terms'][$active_value]['cache_result_ids'];
                        } else {
                            $filter_term_ids[$active_value] = array();
                        }
                    }
                } else if ($filter['is_range'] == true) {
                    /*$filter_term_ids["min"] = $filter['terms']["min"]['cache_result_ids'];
                    $filter_term_ids["max"] = $filter['terms']["max"]['cache_result_ids'];*/

                    $filter_term_ids["value"] = $filter['terms']["value"]['cache_result_ids'];
                } else {

                    if ($filter['type'] == "date") {
                        $filter_term_ids["value"] = $filter['terms']["value"]['cache_result_ids'];
                    }
                }

                $this->filters[$filter_name]['cached_result_ids'] = $this->combine_result_arrays($filter_term_ids, $filter['term_operator']);

            } //no point doing this if not active

            $this->filters[$filter_name]['cached_inactive_result_ids'] = array();
            //if($get_all_term_ids)
            //{//add up all the ids in all the options

            //make sure auto count is enabled
            if ($this->form_settings['enable_auto_count'] == 1) {

                $field_terms = $filter["terms"];

                $filter_term_ids = array();

                if ($filter['type'] == "choice") {
                    foreach ($field_terms as $active_value => $at) {
                        if (isset($filter['terms'][$active_value])) {
                            $filter_term_ids[$active_value] = $filter['terms'][$active_value]['cache_result_ids'];
                        } else {
                            $filter_term_ids[$active_value] = array();
                        }
                    }

                    $cache_key = 'cached_inactive_result_ids_'.$this->sfid."_".$filter_name;
                    $cached_inactive_result_ids_trans = array();

                    if($this->use_transients==1) {
                        $cached_inactive_result_ids_trans = Search_Filter_Wp_Cache::get_transient( $cache_key );
                    }

                    if((!empty($cached_inactive_result_ids_trans))&&($this->use_transients==1)) {
                        $cached_inactive_result_ids = $cached_inactive_result_ids_trans;
                    }
                    else {
                        $cached_inactive_result_ids = $this->combine_result_arrays($filter_term_ids, "or");

                        if($this->use_transients==1) {
                            Search_Filter_Wp_Cache::set_transient( $cache_key, $cached_inactive_result_ids);
                        }
                    }

                    $this->filters[$filter_name]['cached_inactive_result_ids'] = $cached_inactive_result_ids;

                } else if ($filter['is_range'] == true) /* date range and number */ {
                    /*$filter_term_ids["min"] = $filter['terms']["min"]['cache_result_ids'];
                    $filter_term_ids["max"] = $filter['terms']["max"]['cache_result_ids'];*/

                    $filter_term_ids["value"] = $filter['terms']["value"]['cache_result_ids'];

                    //$this->filters[$filter_name]['cached_result_ids'] = $this->combine_result_arrays($filter_term_ids, $filter['term_operator']);
                }
            }

        }
    }

    //using the operator, combine an arrays of results
    public function combine_result_arrays($result_ids_array, $operator, $track = false)
    {

        /* this is the biggest bottle neck -  */

        $time_start = microtime(true);

        $combined_results = array();

        $first_arr = false;
        foreach ($result_ids_array as $key => $result_ids) {
            if ($first_arr == false) {
                $first_arr = true;
                //$start_time = microtime(true);
                $combined_results = array();
                foreach($result_ids as $arr_val)
                {
                    $combined_results[$arr_val] = 1;
                }

                /*$end_time = microtime(true);
                $total_time = $end_time - $start_time;
                $this->const_time += $total_time;*/



            } else {
                if ($operator == "or") {

                    $combined_results = $this->array_merge_hash($combined_results, $result_ids); //pass smaller array first due optmisiations

                } else {
                    $array_keys = array();
                    $arr_count = count($result_ids);

                    for($i=0; $i<$arr_count; $i++)
                    {
                        $array_keys[$result_ids[$i]] = 1;
                    }
                    $combined_results = array_intersect_key($combined_results, $array_keys);
                }

            }
        }

        //$combined_results = array_unique($combined_results);
        $combined_results = array_keys($combined_results);

        return $combined_results;
    }

    function array_merge_hash(&$array_1, $array_2)
    {
        //$hash = array();

        foreach($array_2 as $arr_val)
        {
            $array_1[ $arr_val ] = 1;
        }

        //$array_from_hash = array_keys( $array_1 );

        return $array_1;
    }

    public function get_cache_number_ids($filter_name, $filter_value, $filter) {

        global $wpdb;

        //test for speed

        $field_term_ids = array();
        $compare_operator = "=";

        if(count($filter['active_values'])!=1)
        {
            return $field_term_ids;
        }

        if($filter_value=="value")
        {
            $compare_operator = "=";
            $filter_value = $filter['active_values'][0];

        }

	    $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');

        if($filter_value!="")
        {
            $field_terms_results = $wpdb->get_results( $wpdb->prepare(

                "
				SELECT post_id, post_parent_id
				FROM $this->cache_table_name
				WHERE field_name = '%s' 
					AND cast(field_value AS UNSIGNED) $compare_operator %d
				",
                $filter_name, $filter_value
            ) );




            $treat_child_posts_as_parent = false;
            if(isset($this->form_settings["treat_child_posts_as_parent"]))
            {
                $treat_child_posts_as_parent = (bool)$this->form_settings["treat_child_posts_as_parent"];
            }

            foreach($field_terms_results as $field_terms_result)
            {
                array_push($field_term_ids, $field_terms_result->post_id);

                /*if(!$treat_child_posts_as_parent)
                {
                    array_push($field_term_ids, $field_terms_result->post_id);
                }
                else
                {
                    if($field_terms_result->post_parent_id==0)
                    {//this is not a child page - its the parent
                        array_push($field_term_ids, $field_terms_result->post_id);
                    }
                    else
                    {
                        array_push($field_term_ids, $field_terms_result->post_parent_id);
                    }
                }*/
            }

        }
        return $field_term_ids;
    }

    public function get_cache_number_range_ids($start_field_name, $end_field_name, $filter) {
        global $wpdb;

        $field_term_ids = array();

        //check there are acutally 2 values - a min and max selected
        if(count($filter['active_values'])!=2)
        {
            return $field_term_ids;
        }

        $min_value = (float)$filter['active_values'][0];
        $max_value = (float)$filter['active_values'][1];

        if($min_value>$max_value)
        {
            return $field_term_ids; //don't allow min value to be larger than max - treat as incorrect / no results
        }

        if($start_field_name==$end_field_name) //then we are using a range against a single date
        {
            $filter['compare_mode'] = "userrange"; //not possible for another compare mode - single field name means its a single result we are comparing against, not a range.
        }

        //figure out if decimal or not
        $cast_type = 'UNSIGNED';

        if(isset($filter['decimal_places']))
        {
            $decimal_places = 0;
            $decimal_places = (int)$filter['decimal_places'];

            if($decimal_places>5)
            {
                $decimal_places = 5; //limit to 5
            }

            if($decimal_places>0)
            {
                $cast_type = 'DECIMAL(12,'.$decimal_places.')';
            }
        }

	    $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');
	    $this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');


	    //post meta start/end must be within user selection
        if($filter['compare_mode']=="userrange")
        {
            if($start_field_name == $end_field_name) {
                $field_terms_results = $wpdb->get_results( $wpdb->prepare(

                    "
                    SELECT post_id, post_parent_id, field_value FROM
                    $this->cache_table_name WHERE
                    field_name = '%s' AND 
                    cast(field_value AS $cast_type) >= cast(%s AS $cast_type) AND
                    cast(field_value AS $cast_type) <= cast(%s AS $cast_type)
                    
                    ",
                    $start_field_name, $min_value, $max_value
                ) );
            }
            else {
                $field_terms_results = $wpdb->get_results( $wpdb->prepare(

                    "
                        SELECT post_id, post_parent_id, field_value_min, field_value_max FROM
                        (SELECT min_table.post_id as post_id, min_table.post_parent_id as post_parent_id, min_table.field_value as field_value_min, max_table.field_value as field_value_max
                        FROM (SELECT post_id, post_parent_id, field_value FROM $this->cache_table_name WHERE field_name = '%s') AS min_table
                        LEFT JOIN (SELECT post_id, field_value FROM $this->cache_table_name WHERE field_name = '%s') AS max_table
                        ON min_table.post_id = max_table.post_id) as range_table
                        WHERE
                        cast(field_value_min AS $cast_type) >= cast(%s as $cast_type) AND
                        cast(field_value_max AS $cast_type) <= cast(%s as $cast_type)

                    ",
                    $start_field_name, $end_field_name, $min_value, $max_value
                ) );
            }
        }
        else if($filter['compare_mode']=="metarange")
        {
            $field_terms_results = $wpdb->get_results( $wpdb->prepare(
                "
				SELECT post_id, post_parent_id, field_value_min, field_value_max FROM
					(SELECT min_table.post_id as post_id, min_table.post_parent_id as post_parent_id, min_table.field_value as field_value_min, max_table.field_value as field_value_max 
					FROM (SELECT post_id, post_parent_id, field_value FROM $this->cache_table_name WHERE field_name = '%s') AS min_table
					LEFT JOIN (SELECT post_id, field_value FROM $this->cache_table_name WHERE field_name = '%s') AS max_table 
					ON min_table.post_id = max_table.post_id) as range_table
				WHERE 
				cast(field_value_min AS $cast_type) <= cast(%s as $cast_type) AND
				cast(field_value_max AS $cast_type) >= cast(%s as $cast_type)
				",
                $start_field_name, $end_field_name, $min_value, $max_value
            ) );
        }
        else if($filter['compare_mode']=="overlap")
        {
            $field_terms_results = $wpdb->get_results( $wpdb->prepare(
                "
				SELECT post_id, post_parent_id, field_value_min, field_value_max FROM
					(SELECT min_table.post_id as post_id, min_table.post_parent_id as post_parent_id, min_table.field_value as field_value_min, max_table.field_value as field_value_max 
					FROM (SELECT post_id, post_parent_id, field_value FROM $this->cache_table_name WHERE field_name = '%s') AS min_table
					LEFT JOIN (SELECT post_id, field_value FROM $this->cache_table_name WHERE field_name = '%s') AS max_table 
					ON min_table.post_id = max_table.post_id) as range_table
				WHERE 
				(
					cast(field_value_min AS $cast_type) >= cast(%s as $cast_type) AND
					cast(field_value_min AS $cast_type) <= cast(%s as $cast_type)
				)
				OR
				(
				    cast(field_value_max AS $cast_type) >= cast(%s as $cast_type) AND
					cast(field_value_max AS $cast_type) <= cast(%s as $cast_type)
				)
				OR
				(
				    cast(field_value_min AS $cast_type) <= cast(%s as $cast_type) AND
					cast(field_value_max AS $cast_type) >= cast(%s as $cast_type)
				)
				OR
				(
				    cast(field_value_min AS $cast_type) >= cast(%s as $cast_type) AND
					cast(field_value_max AS $cast_type) <= cast(%s as $cast_type)
				)
				",
                $start_field_name, $end_field_name, $min_value, $max_value, $min_value, $max_value, $min_value, $max_value, $min_value, $max_value
            ) );
        }

        $treat_child_posts_as_parent = false;
        if(isset($this->form_settings["treat_child_posts_as_parent"]))
        {
            $treat_child_posts_as_parent = (bool)$this->form_settings["treat_child_posts_as_parent"];
        }

        foreach($field_terms_results as $field_terms_result)
        {
            if(!$treat_child_posts_as_parent)
            {
                array_push($field_term_ids, $field_terms_result->post_id);
            }
            else
            {
                if($field_terms_result->post_parent_id==0)
                {//this is not a child page - its the parent
                    array_push($field_term_ids, $field_terms_result->post_id);
                }
                else
                {
                    array_push($field_term_ids, $field_terms_result->post_parent_id);
                }
            }
        }

        return $field_term_ids;
    }



    public function fetch_all_cached_post_ids() {

        global $wpdb;

        if(!$this->has_all_post_ids_cached)
        {
            $this->has_all_post_ids_cached = true;

            $cache_key = 'all_post_ids_cached_'.$this->sfid;
            $cached_field_terms_results = array();

            if($this->use_transients==1)
            {
                $all_post_ids_cached = Search_Filter_Wp_Cache::get_transient( $cache_key );
            }

            if((!empty($all_post_ids_cached))&&($this->use_transients==1))
            {
                $this->all_post_ids_cached = $all_post_ids_cached;
            }
            else
            {
	            $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');

	            $cache_search_sql = "
                SELECT DISTINCT post_id 
                FROM $this->cache_table_name
                ";

                $cache_search_result = $wpdb->get_results($cache_search_sql);

                $cache_result_ids = array();
                foreach($cache_search_result as $post)
                {
                    array_push($cache_result_ids, $post->post_id);
                }

                $this->all_post_ids_cached = $cache_result_ids;

                if($this->use_transients==1) {
                    Search_Filter_Wp_Cache::set_transient( $cache_key, $this->all_post_ids_cached);
                }
            }

        }
    }



    public function apply_cached_filters() {

        $filter_ids_choices = array();
        $filter_ids_extra = array();

        foreach($this->filters as $filter_name => $filter)
        {
            if($filter['is_active']==true)
            {
                if($filter['type']=="choice")
                {//these all share an operator
                    $filter_ids_choices[$filter_name] = $filter['cached_result_ids'];
                }
                else
                {//these are all assumed to be AND -
                    $filter_ids_extra[$filter_name] = $filter['cached_result_ids'];
                }
            }
        }

        $final_filtered_ids = array();

        $post__in = array();

        //no filters have been set, so just use all the Post IDs in the cache
        if((count($filter_ids_choices)==0))
        {//no filters have been set
            //$this->post__in = $this->all_post_ids_cached;
            $final_filtered_ids['choice_ids'] = $this->all_post_ids_cached;
        }
        else
        {
            //filter the final result from all post IDs and choice filters
            $final_filtered_ids['choice_ids'] = $this->filter_results_ids($filter_ids_choices, $this->all_post_ids_cached, $this->filter_operator);

        }


        if((count($filter_ids_extra)==0))
        {//no filters have been set

            //$this->post__in = $this->all_post_ids_cached;
            $final_filtered_ids['extra_ids'] = $this->all_post_ids_cached;
        }
        else
        {
            //filter the result ids with the result ids from selected options
            $final_filtered_ids['extra_ids'] = $this->combine_result_arrays($filter_ids_extra, "and");
        }



	    //now we setup the actual query - and apply users' `pre_get_posts`

        //usually used internally to setup the query
        if(has_filter('sf_edit_query_args')) {
            $this->query_args = apply_filters('sf_edit_query_args', $this->query_args, $this->sfid);
        }

        //allow input of IDs to for users to apply to search results
        if(has_filter('sf_apply_custom_filter')) {

            $user_arr = array();
            $user_arr['user_filter'] = array();
            $user_arr['user_filter'] = apply_filters('sf_apply_custom_filter', $user_arr['user_filter'], $this->query_args, $this->sfid);
            $user_arr['extra_ids'] = $final_filtered_ids['extra_ids'];

            $merge_custom_filter = true;

            if(isset($user_arr['user_filter'][0]))
            {
                if($user_arr['user_filter'][0]===false)
                {
                    $merge_custom_filter = false;
                }

            }

            if($merge_custom_filter==true){
                $final_filtered_ids['extra_ids'] = $this->combine_result_arrays($user_arr, "and");
            }
        }

        $count = 0;
        $this->filter_ids_extra = $final_filtered_ids['extra_ids'];

        $post__in = $this->combine_result_arrays($final_filtered_ids, "and");

        if(has_filter('sf_edit_query_args_after_custom_filter')) {
            $this->query_args = apply_filters('sf_edit_query_args_after_custom_filter', $this->query_args, $this->sfid);
        }


        //now remove excluded post IDs from the included IDs as these overwrite the excluded posts types too
        if(isset($this->query_args['post__not_in']))
        {
        	if(!is_array($this->query_args['post__not_in'])){
		        $this->query_args['post__not_in'] = array($this->query_args['post__not_in']);
	        }
            $post__in = array_diff($post__in, $this->query_args['post__not_in']);

            /* todo check if we need to unset Post__not_in */
        }

        if(!is_array($this->query_args))
        {//then there was likely some problem from the filters

            $this->query_args = array();
        }


        if(count($post__in)==0)
        {
            $post__in = array(0); //force no search results on query if no post IDs are included
        }


	    if(has_filter("sf_query_cache_post__in"))
        {
            $post__in = apply_filters('sf_query_cache_post__in', $post__in, $this->sfid);
        }


	    //setup the query args for the main search query
        $expand_args = array(
            'post__in'      				=> $post__in
        );

        $this->query_args = array_merge($this->query_args, $expand_args);

    }

    public function filter_results_ids($filter_ids, $results_ids, $operator) {

        //combine all choice type arrays according to THEIR operator
        $filtered_result_ids = $this->combine_result_arrays($filter_ids, $operator);

        //the COMBINE ALL compulsory fields, like price, date range
        //AND THEN COMBINE THE TWO TOGETHER

        $pre_result_ids = array_intersect($filtered_result_ids, $results_ids);

        return $pre_result_ids;
    }


    public function init_count_vars() {


        global $searchandfilter;

        //try to see if we have a transient for this data (only on pages where there are no query args, the default unfiltered
        $query_str = $searchandfilter->get($this->sfid)->current_query()->get_query_str();
        $cache_key = 'count_table_'.$this->sfid;

        $count_vars_trans = array();
        if(($this->use_transients==1)&&($query_str==""))
        {//this works by ignoring taxonomy archives if they are set, because the taxonomy archive still sets `query_str`
            $count_vars_trans = Search_Filter_Wp_Cache::get_transient( $cache_key );
        }

        if((!empty($count_vars_trans))&&($count_vars_trans!==false)&&($query_str=="")&&($this->use_transients==1))
        {
            $searchandfilter->get($this->sfid)->set_count_table($count_vars_trans);
            return;
        }

        $this->count_data['current_filtered_result_ids'] = array();
        $this->count_data['current_unfiltered_result_ids'] = array();

        //now setup the counts for the filters

        //Search_Filter_Helper::start_log("set_count_filtered_post_ids");
        $this->set_count_filtered_post_ids();//get the IDs of the full result set of the current search
        //Search_Filter_Helper::finish_log("set_count_filtered_post_ids");

        //Search_Filter_Helper::start_log("set_count_unfiltered_post_ids");
        $this->set_count_unfiltered_post_ids(); //get the IDs of the full result set without filters
        //Search_Filter_Helper::finish_log("set_count_unfiltered_post_ids");

        //Search_Filter_Helper::start_log("set_filter_ids_post_query");
        $this->set_filter_ids_post_query();
        //Search_Filter_Helper::finish_log("set_filter_ids_post_query");

        //update the IDs associated with this filter based on the current search
        //Search_Filter_Helper::start_log("set_filter_term_ids_post_query");
        $this->set_filter_term_ids_post_query();
        //Search_Filter_Helper::finish_log("set_filter_term_ids_post_query");

    }

    public function set_filter_ids_post_query()
    {
        foreach($this->filters as $filter_name => $filter)
        {
            //if($filter['is_active']==true)
            //{

            if(count($filter['cached_result_ids'])>0)
            {//merge the old filter ids with the new result set

                $combine_results = array();
                $combine_results['cached_ids']  = $filter['cached_result_ids'];
                $combine_results['unfiltered_ids']  = $this->count_data['current_filtered_result_ids'];

                $this->filters[$filter_name]['wp_query_result_ids'] = $this->combine_result_arrays($combine_results, "and");

                $combine_results = array();
                $combine_results['cached_ids']  = $filter['cached_result_ids'];
                $combine_results['unfiltered_ids']  = $this->count_data['current_unfiltered_result_ids'];

                $this->filters[$filter_name]['wp_query_result_ids_unfiltered'] = $this->combine_result_arrays($combine_results, "and");

            }
            //else
            //{//noting selected for this field

            $combine_results = array();
            $combine_results['cached_inactive_ids']  = $filter['cached_inactive_result_ids'];
            $combine_results['unfiltered_ids']  = $this->count_data['current_unfiltered_result_ids'];

            $this->filters[$filter_name]['wp_query_inactive_result_ids'] = $this->combine_result_arrays($combine_results, "and");


            $combine_results = array();
            $combine_results['cached_ids']  = $filter['cached_inactive_result_ids'];
            $combine_results['filtered_ids']  = $this->count_data['current_filtered_result_ids'];

	        //so we need to combine these two, but cached_ids use variations etc, but the `filtered_ids` are from live query, which means they've already been converted to parent...
	        /*if(has_filter("sf_query_cache_count_id_numbers")) {
		        $combine_results['cached_ids'] = apply_filters('sf_query_cache_count_id_numbers', $combine_results['cached_ids'], $this->sfid);
	        }
	        */

	        $this->filters[$filter_name]['wp_query_active_result_ids'] = $this->combine_result_arrays($combine_results, "and");

            /*$combine_results = array();
            $combine_results['cached_ids']  = $filter['cached_inactive_result_ids'];
            $combine_results['unfiltered_ids']  = $this->count_data['current_unfiltered_result_ids'];

            $this->filters[$filter_name]['wp_query_result_ids_unfiltered'] = $this->combine_result_arrays($combine_results, "and");
            */
            //}
        }
    }

    /* hacky !? - was the only way to stop woocommerce modifying some queries */
    public function hard_remove_filters()
    {
        $remove_posts_clauses = false;
        $remove_posts_where = false;

        if(isset($GLOBALS['wp_filter']['posts_clauses']))
        {
            $remove_posts_clauses = true;
        }

        if(isset($GLOBALS['wp_filter']['posts_where']))
        {
            $remove_posts_where = true;
        }

        //
        if(($remove_posts_clauses)||($remove_posts_where))
        {
            $this->WP_FILTER = $GLOBALS['wp_filter'];
        }

        if($remove_posts_clauses)
        {

            unset($GLOBALS['wp_filter']['posts_clauses']);
        }

        if($remove_posts_where)
        {

            unset($GLOBALS['wp_filter']['posts_where']);
        }
    }


    public function hard_restore_filters()
    {
        $remove_posts_clauses = false;
        $remove_posts_where = false;

        if(isset($this->WP_FILTER['posts_clauses']))
        {
            $remove_posts_clauses = true;
        }

        if(isset($this->WP_FILTER['posts_where']))
        {
            $remove_posts_where = true;
        }


        if(($remove_posts_clauses)||($remove_posts_where))
        {
            $GLOBALS['wp_filter'] = $this->WP_FILTER;
            unset($this->WP_FILTER);
        }

    }
    public function set_count_filtered_post_ids()
    {
        //$time_start = microtime(true);

        //set args so we can grab the IDs of the full query (ie minus pagination)
        $expand_args = array(
            'posts_per_page' 			=> -1,
            'paged' 					=> 1,
            //'post_status' 				=> array("publish"),
            'fields' 					=> "ids",

            'orderby' 					=> "", //remove sorting
            'meta_key' 					=> "",
            'order' 					=> "",
            //'post__in'      				=> $this->post__in,

            'suppress_filters' 			=> false,

            /* speed improvements */
            'no_found_rows' 				=> true,
            'update_post_meta_cache' 	=> false,
            'update_post_term_cache' 	=> false

        );

        $query_args = array_merge($this->query_args, $expand_args);

        //$this->hard_remove_filters();
        //Search_Filter_Helper::start_log("set_count_filtered_post_ids");
        $query_arr = new WP_Query( $query_args );
        //Search_Filter_Helper::finish_log("set_count_filtered_post_ids");
        //$this->hard_restore_filters();

        if ( $query_arr->have_posts() ){
            $this->count_data['current_filtered_result_ids'] = $query_arr->posts;
        }


        //$time_end = microtime(true);
        //$total_time = $time_end - $time_start;


        //echo "Total time to generate <strong>all_filtered_post_ids</strong> : $total_time seconds<br />";
        //echo "----------------------------<br /><br />";


    }
    public function set_count_unfiltered_post_ids()
    {

        //$time_start = microtime(true);

        //set args so we can grab the IDs of the full query (ie minus pagination)
        $expand_args = array(
            'posts_per_page' 			=> -1,
            //'post_status' 				=> array("publish"),
            'paged' 					=> 1,
            'fields' 					=> "ids",
            'post__in'      			=> array(),

            'orderby' 					=> "", //remove sorting
            'meta_key' 					=> "",
            'order' 						=> "",

            'suppress_filters' 			=> false, //should normally be true - but we need for WPML to apply lang to query
            //'lang'						=> ICL_LANGUAGE_CODE,

            /* speed improvements */
            'no_found_rows' 				=> true,
            'update_post_meta_cache' 	=> false,
            'update_post_term_cache' 	=> false

        );


        $query_args = array_merge($this->query_args, $expand_args);


        //$this->hard_remove_filters();

        // The Query
        //Search_Filter_Helper::start_log("QUERY (set_count_unfiltered_post_ids)");
        $cache_key = 'count_unfiltered_post_ids_'.$this->sfid;

        $query_trans = array();
        if($this->use_transients==1)
        {
            $query_trans = Search_Filter_Wp_Cache::get_transient( $cache_key );
        }

        if((!empty($query_trans))&&($this->use_transients==1))
        {
            $query = $query_trans;
        }
        else
        {

            $query = new WP_Query( $query_args );

            if($this->use_transients==1) {
                Search_Filter_Wp_Cache::set_transient( $cache_key, $query);
            }
        }

        //$this->hard_restore_filters();
	    //echo "\r\nLast SQL-Query: {$query->request}";
        if ( $query->have_posts() ){

            //now this is used for displaying a ton of relations types, but we need to integrate things like price and meta here so the counts update accordingly
            //we don't need to do this for the "filtered_result_ids" becuase the query has been applied to them and includes range/date restrictions

            $extras_result_array = array();
            $extras_result_array['result_ids'] = $query->posts;
            $extras_result_array['filter_ids_extra'] = $this->filter_ids_extra;

            $this->count_data['current_unfiltered_result_ids'] = $this->combine_result_arrays($extras_result_array, "and");
        }


        //$time_end = microtime(true);
        //$total_time = $time_end - $time_start;

        //echo "Total time to generate <strong>all_unfiltered_post_ids</strong> : $total_time seconds<br />";
        //echo "----------------------------<br /><br />";
    }


    public function filters_active()
    {
        foreach($this->filters as $filter_name => $filter)
        {
            if(($filter['is_active'])&&($filter['type']=="choice"))
            {
                return true;
            }
        }

        return false;
    }

    //calculate all the term IDS & counts once the query has been run
    public function set_filter_term_ids_post_query()
    {
        //$time_start = microtime(true);
        $filter_ids_extra = array();

        $filters_active = $this->filters_active();

        foreach($this->filters as $filter_name => $filter)
        {
            $field_terms = $filter["terms"];
            $term_result_ids = array();

            if($filter['type']=="choice")
            {

                //if($filter["is_active"])
                //{
                if(($this->filter_operator=="and")&&($filter['term_operator']=="or"))
                {
                    $results_excl_current_field = $this->get_results_excluding_filter($filter_name);

                }
                else if(($this->filter_operator=="or")&&($filter['term_operator']=="and"))
                {
                    $results_incl_current_field = $this->get_results_including_filter($filter_name);

                }
                //}

                //$loopcount = 0;
                foreach($field_terms as $term_name => $term)
                {
                	//echo $filter_name. " | ".$term_name." | ".$this->filter_operator." | ".$filter['term_operator']."\r\n";
                    if($filters_active)
                    {

                        if($this->filter_operator=="or")
                        {

                            if($filter['term_operator']=="or")
                            {
                                //all_unfiltered_post_ids
                                $combined_results = array();
                                $combined_results['cache_result_ids'] = $term['cache_result_ids'];
                                $combined_results['filtered_results'] = $filter['wp_query_inactive_result_ids']; //combine with the IDS for this field

                                $term_result_ids = $this->combine_result_arrays($combined_results, "and");

                                /*if(!$filter['is_active'])
                                { // just to make it a bit quicker
                                    $combined_results = array();
                                    $combined_results['cache_result_ids'] = $term['cache_result_ids'];
                                    $combined_results['filtered_results'] = $filter['wp_query_result_ids']; //combine with the IDS for this field

                                    $term_result_ids = $this->combine_result_arrays($combined_results, "and");
                                }
                                else
                                {
                                    $combined_results = array();
                                    $combined_results['cache_result_ids'] = $term['cache_result_ids'];
                                    $combined_results['unfiltered_results'] = $this->count_data['current_unfiltered_result_ids'];

                                    $term_result_ids = $this->combine_result_arrays($combined_results, "and");
                                //}*/



                            }
                            else if($filter['term_operator']=="and")
                            {

                                $combined_results = array();
                                $combined_results['cache_result_ids'] = $term['cache_result_ids'];
                                $combined_results['unfiltered_results'] = $results_incl_current_field;

                                $term_result_ids = $this->combine_result_arrays($combined_results, "and");
                            }
                        }
                        else if($this->filter_operator=="and")
                        {

                            if($filter['term_operator']=="or")
                            {
                                $combined_results = array();

                                $combined_results['cache_result_ids'] = $term['cache_result_ids'];
                                $combined_results['unfiltered_results'] = $results_excl_current_field;

                                $term_result_ids = $this->combine_result_arrays($combined_results, "and");
                            }
                            else if($filter['term_operator']=="and")
                            {
                                $combined_results = array();
                                $combined_results['cache_result_ids'] = $term['cache_result_ids'];
                                //$combined_results['filtered_results'] = $this->count_data['current_filtered_result_ids'];
                                //$combined_results['filtered_results'] = $filter['wp_query_result_ids']; //combine with the IDS for this field
                                //$combined_results['filtered_results'] = $filter['wp_query_inactive_result_ids']; //combine with the IDS for this field
                                $combined_results['filtered_results'] = $filter['wp_query_active_result_ids']; //combine with the IDS for this field

                                $term_result_ids = $this->combine_result_arrays($combined_results, "and");


                            }
                        }


                    }
                    else
                    {
                        $combined_results = array();
                        $combined_results['cache_result_ids'] = $term['cache_result_ids'];
                        //$combined_results['filtered_results'] = $this->count_data['current_filtered_result_ids'];
                        $combined_results['filtered_results'] = $filter['wp_query_inactive_result_ids']; //combine with the IDS for this field
                        $term_result_ids = $this->combine_result_arrays($combined_results, "and");
                    }

                    /* - this is the numeric and date filters - DONT NEED, we won't be showing the count, and this function is only for count! Numbers have been updated arleady because the main search is already affected...
                    ** ************ we are applying this filter on every field adding in valuable time, we
                    **************** should be applying this once, before we calculate these filters - either directly on the result set or possibly on the fields themselves

                    //then we do one more calculation based on a group of items using "AND" - these are fields like price range or date range which you ALWAYs want applied to the results
                    $extras_result_array = array();
                    $extras_result_array['term_result_ids'] = $term_result_ids;
                    $extras_result_array['filter_ids_extra'] = $this->filter_ids_extra;
                    $term_result_ids = $this->combine_result_arrays($extras_result_array, "and");
                    *********************** */

	                if(has_filter("sf_query_cache_count_ids")) {
		                $term_result_ids = apply_filters('sf_query_cache_count_ids', $term_result_ids, $this->sfid);
	                }

                    $term_results = count($term_result_ids);

                    $count = $term_results;

                    $this->filters[$filter_name]['terms'][$term_name]['count'] = $count;
                }
            }
            else
            {
                //then we need to combine the extras with the filters using AND
                //$filter_ids_extra[$filter_name] = $filter['cached_result_ids'];
            }
        }

        $this->set_count_table();
    }

    public function set_count_table()
    {
        $count_vars = array();
        foreach($this->filters as $filter_name => $filter)
        {
            $field_terms = $this->filters[$filter_name]["terms"];

            $count_vars[$filter_name] = array();

            foreach($field_terms as $term_name => $term)
            {
                $count_vars[$filter_name][$term_name] = $term['count'];
            }
        }

        global $searchandfilter;
        $query_str = $searchandfilter->get($this->sfid)->current_query()->get_query_str();
        $cache_key = 'count_table_'.$this->sfid;

        $count_vars_trans = array();
        if(($this->use_transients==1)&&($query_str==""))
        {
            $count_vars_trans = Search_Filter_Wp_Cache::get_transient( $cache_key );

            if((empty($count_vars_trans))||($count_vars_trans==false)) {
                Search_Filter_Wp_Cache::set_transient( $cache_key, $count_vars);
            }
        }

        //global $searchandfilter;
        $searchandfilter->get($this->sfid)->set_count_table($count_vars);

    }

    public function get_results_excluding_filter($filter_name_excl = "")
    {
        $combined_results = array();
        foreach($this->filters as $filter_name => $filter)
        {
            if($filter_name_excl!=$filter_name)
            {
                if(($filter['is_active'])&&($filter['type']=="choice"))
                {
                    $filter_ids = $this->filters[$filter_name]['wp_query_result_ids_unfiltered'];
                    $combined_results[$filter_name] = $filter_ids;
                }
                else
                {


                }
            }
        }

        if(count($combined_results)==0)
        {
            $term_result_ids = $this->count_data['current_unfiltered_result_ids'];
        }
        else
        {
            $term_result_ids = $this->combine_result_arrays($combined_results, $this->filter_operator);
        }

        return $term_result_ids;

    }
    public function get_results_including_filter($filter_name_incl = "")
    {

        $combined_results = array();
        $combined_results =  $this->filters[$filter_name_incl]['wp_query_result_ids_unfiltered'];

        if(count($combined_results)==0)
        {
            $term_result_ids = $this->count_data['current_unfiltered_result_ids'];
        }
        else
        {
            $term_result_ids = $combined_results;
        }

        return $term_result_ids;
    }
    public function get_filter_terms_meta($field_name, $field_data) {

        global $wpdb;

        $filter_terms = array();
        $filterit = 0;

        if(isset($field_data['meta_options']))
        {
            $options = $field_data['meta_options'];

            foreach ($options as $option)
            {

                $filter_terms[$filterit] = new stdClass();
                $filter_terms[$filterit]->field_value = $option['option_value'];

                $filterit++;
            }

        }

        return $filter_terms;
    }


    //this is how it should be - pulling in all terms from the DB - but for now, rely on what hte user added to the fields
    public function get_filter_terms_all($field_name, $source) {

        global $wpdb;

        $field_col_select = "field_value";
        if($source=="taxonomy")
        {
            $field_col_select = "field_value_num as field_value";
        }

	    $this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');

        $field_terms_result = $wpdb->get_results( $wpdb->prepare(

            "
			SELECT DISTINCT $field_col_select
			FROM $this->cache_table_name
			WHERE field_name = '%s'
			",
            $field_name
        ) );

        return $field_terms_result;
    }

    public function is_meta_value($key)
    {
        if(substr( $key, 0, 5 )===SF_META_PRE)
        {
            return true;
        }
        return false;
    }
		public function is_meta_key($key)
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

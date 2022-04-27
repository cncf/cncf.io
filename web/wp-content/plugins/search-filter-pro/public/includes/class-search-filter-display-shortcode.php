<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Display_Shortcode
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Display_Shortcode {

    public function __construct($plugin_slug)
    {
        $this->plugin_slug = $plugin_slug;

        // Add shortcode support for widgets
        add_shortcode('searchandfilter', array($this, 'display_shortcode'));
        add_filter('widget_text', 'do_shortcode');

        //add query vars
        add_filter('query_vars', array($this,'add_queryvars') );

        $this->is_form_using_template = false; //if the user has selected to use a template with this form

        //if the current page is using the defined template - the search form can display anywhere on the site so sometimes where it is displayed may not be a results page
        $this->is_template_loaded = false;

        $this->display_results = new Search_Filter_Display_Results($plugin_slug);
    }

    public function set_is_template($is_template)
    {
        $this->is_template_loaded = $is_template;
    }

    public function set_defaults($sfid)
    {
        global $searchandfilter;
        global $wp_query;

        $searchform = $searchandfilter->get($sfid);

        //try to detect any info from current page/archive and set defaults
        //$this->set_inherited_defaults($searchform);

        //$current_query = $searchform->current_query()->get_array();

        //give priority to user selections by setting them up after

        /*$categories = array();

        if(isset($wp_query->query['category_name']))
        {
            $category_params = (preg_split("/[,\+ ]/", esc_attr($wp_query->query['category_name']))); //explode with 2 delims

            //$category_params = explode("+",esc_attr($wp_query->query['category_name']));

            foreach($category_params as $category_param)
            {
                $category = get_category_by_slug( $category_param );
                if(isset($category->cat_ID))
                {
                    $categories[] = $category->cat_ID;
                }
            }
        }

        if((count($categories)>0)||(!isset($this->defaults[SF_TAX_PRE.'category'])))
        {
            $this->defaults[SF_FPRE.'category'] = $categories;
        }
        */
        //grab search term for prefilling search input
        /*if(isset($_GET['_sf_s']))
        {
            $this->defaults['search'] = esc_attr(trim(stripslashes($_GET['_sf_s'])));
        }*/

        //check to see if tag is set

        /*$tags = array();

        if(isset($wp_query->query['tag']))
        {
            $tag_params = (preg_split("/[,\+ ]/", esc_attr($wp_query->query['tag']))); //explode with 2 delims

            foreach($tag_params as $tag_param)
            {
                $tag = get_term_by("slug",$tag_param, "post_tag");
                if(isset($tag->term_id))
                {
                    $tags[] = $tag->term_id;
                }
            }
        }

        if((count($tags)>0)||(!isset($this->defaults[SF_TAX_PRE.'post_tag'])))
        {
            $this->defaults[SF_FPRE.'post_tag'] = $tags;
        }*/


        /*$taxonomies_list = get_taxonomies('','names');


        $taxs = array();

        //loop through all the query vars
        if(isset($_GET))
        {
            foreach($_GET as $key=>$val)
            {
                $taxs = array();
                if (strpos($key, SF_TAX_PRE) === 0)
                {
                    $key = substr($key, strlen(SF_TAX_PRE));

                    $taxslug = ($val);
                    //$tax_params = explode("+",esc_attr($taxslug));

                    $tax_params = array();

                    $tax_params = (preg_split("/[,\+ ]/", esc_attr($taxslug))); //explode with 2 delims

                    foreach($tax_params as $tax_param)
                    {
                        $tax = get_term_by("slug",$tax_param, $key);

                        if(isset($tax->term_id))
                        {
                            $taxs[] = $tax->term_id;
                        }
                    }

                    if((count($taxs)>0)||(!isset($this->defaults[SF_TAX_PRE.$key])))
                    {
                        $this->defaults[SF_TAX_PRE.$key] = $taxs;
                    }


                }
                else if (strpos($key, SF_META_PRE) === 0)
                {
                    $key = substr($key, strlen(SF_META_PRE));

                    $meta_data = array("","");

                    if(isset($_GET[SF_META_PRE.$key]))
                    {
                        //get meta field options
                        $meta_field_data = $searchform->get_field_by_key(SF_META_PRE.$key);

                        if($meta_field_data['meta_type']=="number")
                        {
                            $meta_data = array("","");
                            if(isset($_GET[SF_META_PRE.$key]))
                            {
                                $meta_data = (preg_split("/[,\+ ]/", esc_attr(($_GET[SF_META_PRE.$key])))); //explode with 2 delims

                                if(count($meta_data)==1)
                                {
                                    $meta_data[1] = "";
                                }
                            }

                            $this->defaults[SF_FPRE.$key] = $meta_data;
                        }
                        else if($meta_field_data['meta_type']=="choice")
                        {
                            $getval = $_GET[SF_META_PRE.$key];

                            if($meta_field_data["operator"]=="or")
                            {
                                $ochar = "-,-";
                            }
                            else
                            {
                                $ochar = "-+-";
                                $replacechar = "- -";
                                $getval = str_replace($replacechar, $ochar, $getval);
                            }

                            $meta_data = explode($ochar, esc_attr($getval));

                            if(count($meta_data)==1)
                            {
                                $meta_data[1] = "";
                            }
                        }
                        else if($meta_field_data['meta_type']=="date")
                        {
                            $meta_data = array("","");
                            if(isset($_GET[SF_META_PRE.$key]))
                            {
                                $meta_data = array_map('urldecode', explode("+", esc_attr(urlencode($_GET[SF_META_PRE.$key]))));
                                if(count($meta_data)==1)
                                {
                                    $meta_data[1] = "";
                                }
                            }
                        }
                    }

                    $this->defaults[SF_META_PRE.$key] = $meta_data;

                }
            }
        }

        $post_date = array("","");
        if(isset($_GET['post_date']))
        {
            $post_date = array_map('urldecode', explode("+", esc_attr(urlencode($_GET['post_date']))));
            if(count($post_date)==1)
            {
                $post_date[1] = "";
            }
        }
        $this->defaults[SF_FPRE.'post_date'] = $post_date;


        $post_types = array();
        if(isset($_GET['post_types']))
        {
            $post_types = explode(",",esc_attr($_GET['post_types']));
        }

        if((count($post_types)>0)||(!isset($this->defaults[SF_FPRE.'post_type'])))
        {
            $this->defaults[SF_FPRE.'post_type'] = $post_types;
        }



        $sort_order = array();
        if(isset($_GET['sort_order']))
        {
            $sort_order = explode(",",esc_attr(urlencode($_GET['sort_order'])));
        }
        $this->defaults[SF_FPRE.'sort_order'] = $sort_order;

        $authors = array();
        if(isset($_GET['authors']))
        {
            $authors = explode(",",esc_attr($_GET['authors']));
        }

        if((count($authors)>0)||(!isset($this->defaults[SF_FPRE.'author'])))
        {
            $this->defaults[SF_FPRE.'author'] = $authors;
        }*/

    }



    public function enqueue_scripts()
    {
        $load_jquery_i18n = Search_Filter_Helper::get_option( 'load_jquery_i18n' );
        $combobox_script = Search_Filter_Helper::get_option( 'combobox_script' );

        wp_enqueue_script( $this->plugin_slug . '-plugin-build' );
        wp_enqueue_script( $this->plugin_slug . '-plugin-'.$combobox_script );
        wp_enqueue_script( 'jquery-ui-datepicker' );

        if($load_jquery_i18n==1)
        {
            wp_enqueue_script( $this->plugin_slug . '-plugin-jquery-i18n' );
        }

    }

    public function display_shortcode($atts, $content = null)
    {
        $time_start = microtime(true);
        $total_start = $time_start;

        $lazy_load_js 				= Search_Filter_Helper::get_option( 'lazy_load_js' );
        $load_js_css 				= Search_Filter_Helper::get_option( 'load_js_css' );

        if($lazy_load_js===false)
        {
            $lazy_load_js = 0;
        }
        if($load_js_css===false)
        {
            $load_js_css = 1;
        }

        if(($lazy_load_js==1)&&($load_js_css==1))
        {
            $this->enqueue_scripts();
        }

        // extract the attributes into variables
        extract(shortcode_atts(array(

            'id' => '',
            'slug' => '',
            'show' => 'form',
            'action' => '',
            'skip' => 0

        ), $atts));

        $returnvar = "";

        //make sure its set
        if(($id!=="")||($slug!==""))
        {

            if($id=="")
            {
                if ( $post = get_page_by_path( esc_attr($slug), OBJECT, 'search-filter-widget' ) )
                {
                    $id = $post->ID;
                }
            }

            $base_form_id = (int)$id;
            if(Search_Filter_Helper::has_wpml())
            {
                $current_lang = Search_Filter_Helper::wpml_current_language();
                if ( $current_lang ) {
                    $base_form_id = Search_Filter_Helper::wpml_object_id($id, 'search-filter-widget', true, $current_lang);
                }
            }

            
            if(get_post_status($base_form_id)!="publish")
            {
                return;
            }


            $fields = Search_Filter_Helper::get_fields_meta($base_form_id);
            $settings = Search_Filter_Helper::get_settings_meta($base_form_id);
            $addclass = "";

            global $searchandfilter;

            $searchform = $searchandfilter->get($base_form_id);

            $this->set_defaults($base_form_id);


            if($action=="prep_query")
            {
	            //old, used for EDD, same as "filter_next_query"
	            do_action("search_filter_filter_next_query", $base_form_id);
	            if(!isset($skip)){
		            $skip = 0;
	            }
	            $skip = intval($skip);

	            //$searchform->query()->prep_query();
	            $searchform->query()->filter_next_query($skip);
                return $returnvar;
            }
            else if($action=="do_archive_query")
            {
                do_action("search_filter_archive_query", $base_form_id);//legacy
                do_action("search_filter_do_query", $base_form_id);
                return $returnvar;
            }
            else if($action=="setup_pagination")
            {
                //$searchform->query()->prep_query();
                $searchform->query()->setup_pagination();
                return $returnvar;
            }
            else if($action=="filter_next_query")
            {
	            do_action("search_filter_filter_next_query", $base_form_id);

            	if(!isset($skip)){
            		$skip = 0;
	            }
	            $skip = intval($skip);

                //$searchform->query()->prep_query();
                $searchform->query()->filter_next_query($skip);

                return $returnvar;
            }
            else if($show=="form")
            {
	            if(isset($_GET['sf_data']))
	            {//this means the searchform is loaded within a S&F ajax request, and we only want results - so don't want

		            if($_GET['sf_data']=="results")
		            {
			            return;
		            }
	            }

                $searchandfilter->increment_form_count($base_form_id);
                /* TODO  set auto count somewhere else */

                //make sure there are fields
                if(isset($fields))
                {
                    //make sure fields are in array format as expected
                    if(is_array($fields))
                    {
                        $use_ajax = isset($settings['use_ajax_toggle']) ? (bool)$settings['use_ajax_toggle'] : false;
                        $pagination_type = isset($settings['pagination_type']) ? esc_attr($settings['pagination_type']) : 'normal';
                        $infinite_scroll_container = isset($settings['infinite_scroll_container']) ? esc_html($settings['infinite_scroll_container']) : '';
                        $infinite_scroll_trigger = isset($settings['infinite_scroll_trigger']) ? esc_html($settings['infinite_scroll_trigger']) : '-100';
                        $infinite_scroll_result_class = isset($settings['infinite_scroll_result_class']) ? esc_html($settings['infinite_scroll_result_class']) : '';
                        $show_infinite_scroll_loader = isset($settings['show_infinite_scroll_loader']) ? esc_html($settings['show_infinite_scroll_loader']) : 1;

                        $use_history_api = true;
                        $ajax_target = isset($settings['ajax_target']) ? esc_attr($settings['ajax_target']) : '';
                        $results_url = isset($settings['results_url']) ? esc_attr($settings['results_url']) : '';
                        $page_slug = isset($settings['page_slug']) ? esc_attr($settings['page_slug']) : '';
                        $ajax_links_selector = isset($settings['ajax_links_selector']) ? esc_attr($settings['ajax_links_selector']) : '';
                        $ajax_auto_submit = isset($settings['auto_submit']) ? (int)$settings['auto_submit'] : '';
                        $auto_count = isset($settings['enable_auto_count']) ? (int)$settings['enable_auto_count'] : '';
                        $enable_taxonomy_archives = isset($settings['enable_taxonomy_archives']) ? (int)$settings['enable_taxonomy_archives'] : '';
                        $auto_count_refresh_mode = isset($settings['auto_count_refresh_mode']) ? (int)$settings['auto_count_refresh_mode'] : '';
                        $use_results_shortcode = isset($settings['use_results_shortcode']) ? (int)$settings['use_results_shortcode'] : ''; /* legacy */
                        $display_results_as = isset($settings['display_results_as']) ? esc_attr($settings['display_results_as']) : 'shortcode';
                        $update_ajax_url = isset($settings['update_ajax_url']) ? (int)$settings['update_ajax_url'] : 1;
                        $only_results_ajax = isset($settings['only_results_ajax']) ? (int)$settings['only_results_ajax'] : '';
                        $scroll_to_pos = isset($settings['scroll_to_pos']) ? esc_attr($settings['scroll_to_pos']) : '';
                        $scroll_on_action = isset($settings['scroll_on_action']) ? esc_attr($settings['scroll_on_action']) : '';
                        $custom_scroll_to = isset($settings['custom_scroll_to']) ? esc_html($settings['custom_scroll_to']) : '';
                        $maintain_state = isset($settings['maintain_state']) ? esc_html($settings['maintain_state']) : '';



                        //$is_woocommerce = isset($settings['is_woocommerce']) ? esc_html($settings['is_woocommerce']) : '';

                        /* legacy */
                        if(isset($settings['use_results_shortcode']))
                        {
                            if($settings['use_results_shortcode']==1)
                            {
                                $display_results_as = "shortcode";

                            }
                            else
                            {
                                $display_results_as = "archive";
                            }
                        }
                        /* end legacy */

                        //if($display_results_as=="shortcode")
                        //{
                        //prep the query so we can get the counts for the items in the search form
                        $searchform->query()->prep_query(true);
                        //}
						
                        if($display_results_as=="shortcode")
                        {//if we're using a shortcode, grab the selector automatically from the id
                            $ajax_target = "#search-filter-results-".$base_form_id;
                        }

                        $post_types = isset($settings['post_types']) ? $settings['post_types'] : '';

                        $form_attributes = array();

                        //$form_attr = ' data-sf-form-id="'.$base_form_id.'" data-is-rtl="'.(int)is_rtl().'"';
                        $form_attributes['data-sf-form-id'] = $base_form_id;
                        $form_attributes['data-is-rtl'] = (int)is_rtl();
                        $form_attributes['data-maintain-state'] = $maintain_state;


                        $ajax_url = "";

                        /* figure out the ajax/results urls */
                        $ajax_data_fields = "results";
                        if(($use_ajax==1)&&($auto_count==1))
                        {
                            $ajax_data_fields = "all";
                        }


                        if($display_results_as=="archive")
                        {
                            //get search & filter results url respecting permalink settings
                            $page_slug = "";
                            $results_url = home_url("?sfid=".$base_form_id);

                            if(get_option('permalink_structure'))
                            {
                                $page_slug = $settings['page_slug'];
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

                                $results_url = apply_filters('sf_archive_results_url', $results_url, $base_form_id, $page_slug);
                            }

                        }
                        else if($display_results_as=="post_type_archive")
                        {
                            //get the post type for this form (should only be one set)
                            //then find out the proper url for the archive page according to permalink option
                            if(isset($settings['post_types']))
                            {
                                $post_types = array_keys($settings['post_types']);
                                if(isset($post_types[0]))
                                {
                                    $is_tax_archive = false;
                                    $post_type = $post_types[0];
                                    $has_tax_in_fields = false;

                                    if(Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_type))
                                    {
                                        $is_tax_archive = true;
                                        $term = $searchandfilter->get_queried_object();
                                        $filters = $searchform->get_filters();
                                        if (in_array("_sft_" . $term->taxonomy, $filters)) {
                                            $has_tax_in_fields = true;
                                        }
                                    }

                                    if (($enable_taxonomy_archives==1) && ($has_tax_in_fields==false) && ($is_tax_archive) ) {

                                        $results_url = get_term_link($term);
                                    }
                                    else {

                                        if ($post_type == "post") {
                                            if (get_option('show_on_front') == 'page') {
                                                $results_url = get_permalink(get_option('page_for_posts'));
                                            } else {
                                                $results_url = home_url('/');
                                            }
                                        } else {
                                            $results_url = get_post_type_archive_link($post_type);
                                        }
                                    }

                                }
                            }
                        }
                        else if($display_results_as=="shortcode")
                        {//use the results_url defined by the user
                            $ajax_url = home_url("?sfid=".$base_form_id."&sf_action=get_data");
                        }
                        else if(($display_results_as=="custom_woocommerce_store")&&(Search_Filter_Helper::wc_get_page_id())) {
                            //find woocommerce shop page

                            $post_type = "product";
                            $results_url = home_url("?post_type=$post_type");

                            $searchform->query()->remove_permalink_filters();
                            if (get_option('permalink_structure')) {
                                $results_url = get_permalink(Search_Filter_Helper::wc_get_page_id('shop'));
                            }
                            $searchform->query()->add_permalink_filters();


                            $has_tax_in_fields = false;
                            $is_tax_archive = false;

                            if (Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_type, false)) {
                                $is_tax_archive = true;
                                $term = $searchandfilter->get_queried_object();
                                $filters = $searchform->get_filters();
                                if (in_array("_sft_" . $term->taxonomy, $filters)) {
                                    $has_tax_in_fields = true;
                                }
                            }

                            if (($enable_taxonomy_archives == 1) && ($has_tax_in_fields == false) && ($is_tax_archive)) {

                                $results_url = get_term_link($term);
                            }

                            /*else {

                            }*/
                        }
                        if($results_url!="")
                        {
                            if(has_filter('sf_results_url')) {

                                $results_url = apply_filters('sf_results_url', $results_url, $base_form_id);
                            }


                            //$form_attr.=' data-results-url="'.$results_url.'"';
                            $form_attributes['data-results-url'] = $results_url;
                        }

                        if(($ajax_url=="")&&($results_url!="")&&($use_ajax))
                        {
                            $ajax_url = $results_url;
                        }

                        if(($use_ajax)&&($ajax_url!=""))
                        {
                            if(has_filter('sf_ajax_data_fields')) {

                                $ajax_data_fields = apply_filters('sf_ajax_data_fields', $ajax_data_fields, $base_form_id);
                            }

                            $ajax_url = add_query_arg('sf_data', $ajax_data_fields, $ajax_url);

                            if(has_filter('sf_ajax_results_url')) {

                                $ajax_url = apply_filters('sf_ajax_results_url', $ajax_url, $base_form_id);
                            }

                            //$form_attr.=' data-ajax-url="'.$ajax_url.'"';
                            $form_attributes['data-ajax-url'] = $ajax_url;
                        }


                        $ajax_form_url = home_url("?sfid=".$base_form_id."&sf_action=get_data&sf_data=form");

                        if($ajax_form_url!="")
                        {
                            if(has_filter('sf_ajax_form_url')) {

                                $ajax_form_url = apply_filters('sf_ajax_form_url', $ajax_form_url, $base_form_id);
                            }

                            //$form_attr.=' data-ajax-form-url="'.$ajax_form_url.'"';
                            $form_attributes['data-ajax-form-url'] = $ajax_form_url;
                        }

                        $form_attributes['data-display-result-method'] = $display_results_as;
                        $form_attributes['data-use-history-api'] = (int)$use_history_api;
                        $form_attributes['data-template-loaded'] = (int)$this->is_template_loaded;


                        if(($enable_taxonomy_archives==1)&&(($display_results_as=="post_type_archive")||($display_results_as=="custom_woocommerce_store"))) {

                            $form_attributes['data-taxonomy-archives'] = $enable_taxonomy_archives;

                            if(isset($settings['post_types'])) {
                                $post_types = array_keys($settings['post_types']);
                                if (isset($post_types[0])) {

	                                $single = true;
	                                if($display_results_as == "custom_woocommerce_store"){
		                                $single = false;
	                                }

                                    if (Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_types[0], $single)) {
                                        $term = $searchandfilter->get_queried_object();
                                        $taxonomy = $term->taxonomy;
                                        $form_attributes['data-current-taxonomy-archive'] = $taxonomy;
                                    }
                                }
                            }
                        }


                        $lang_code = "";

                        if(Search_Filter_Helper::has_wpml()){
                            $lang_code = Search_Filter_Helper::wpml_current_language();
                        }
                        else{
	                        $lang_code = strtolower( substr( get_bloginfo ( 'language' ), 0, 2 ) );
                        }



                        //$form_attr .= ' data-lang-code="'.$lang_code.'"';
                        //$form_attr.=' data-ajax="'.(int)$use_ajax.'"';
                        $form_attributes['data-lang-code'] = $lang_code;
                        $form_attributes['data-ajax'] = (int)$use_ajax;

                        if($use_ajax)
                        {
                            $form_attributes['data-ajax-data-type'] = "html";

                            if($display_results_as=="shortcode") {

                                $form_attributes['data-ajax-data-type'] = "json";
                                $form_attributes['data-ajax-links-selector'] = ".pagination a";
                            }
                            else{
	                            if( $ajax_links_selector != "" )
	                            {
		                            //$form_attr.=' data-ajax-links-selector="'.$ajax_links_selector.'"';
		                            $form_attributes['data-ajax-links-selector'] = $ajax_links_selector;
	                            }
	                            else{
		                            //$form_attributes['data-ajax-links-selector'] = '';
	                            }
                            }

                            if(has_filter('sf_ajax_data_type')) {

                                $form_attributes['data-ajax-data-type'] = apply_filters('sf_ajax_data_type', $form_attributes['data-ajax-data-type'], $base_form_id);
                            }

                            if($ajax_target!="")
                            {
                                //$form_attr.=' data-ajax-target="'.$ajax_target.'"';
                                $form_attributes['data-ajax-target'] = $ajax_target;
                            }

                            if($pagination_type!="")
                            {
                                //$form_attr.=' data-ajax-pagination-type="'.$pagination_type.'"';
                                $form_attributes['data-ajax-pagination-type'] = $pagination_type;
                            }

                            if($pagination_type=="infinite_scroll")
                            {
                                //$form_attr.=' data-show-scroll-loader="'.$show_infinite_scroll_loader.'"';
                                $form_attributes['data-show-scroll-loader'] = $show_infinite_scroll_loader;

                                if($infinite_scroll_container!=="")
                                {
                                    //$form_attr.=' data-infinite-scroll-container="'.$infinite_scroll_container.'"';
                                    $form_attributes['data-infinite-scroll-container'] = $infinite_scroll_container;
                                }
                                if($infinite_scroll_trigger!=="")
                                {
                                    //$form_attr.=' data-infinite-scroll-container="'.$infinite_scroll_container.'"';
                                    $form_attributes['data-infinite-scroll-trigger'] = $infinite_scroll_trigger;
                                }

                                if($infinite_scroll_result_class!=="")
                                {
                                    //$form_attr.=' data-infinite-scroll-result-class="'.$infinite_scroll_result_class.'"';
                                    $form_attributes['data-infinite-scroll-result-class'] = $infinite_scroll_result_class;
                                }
                            }




                            if($update_ajax_url!="")
                            {
                                $form_attributes['data-update-ajax-url'] = $update_ajax_url;
                            }
                            if($only_results_ajax!="")
                            {
                                $form_attributes['data-only-results-ajax'] = $only_results_ajax;
                            }




                            if($scroll_to_pos!="")
                            {
                                $form_attributes['data-scroll-to-pos'] = $scroll_to_pos;

                                if($scroll_to_pos=="custom")
                                {
                                    if($custom_scroll_to!="")
                                    {
                                        $form_attributes['data-custom-scroll-to'] = $custom_scroll_to;
                                    }
                                }
                            }

                            if($scroll_on_action!="")
                            {
                                $form_attributes['data-scroll-on-action'] = $scroll_on_action;
                            }
                        }

                        $init_paged = 1;
                        if(isset($_GET['sf_paged']))
                        {
                            $init_paged = (int)$_GET['sf_paged'];
                        }
                        $form_attributes['data-init-paged'] = $init_paged;
                        $form_attributes['data-auto-update'] = $ajax_auto_submit;

                        if($auto_count==1)
                        {
                            $form_attributes['data-auto-count'] = $auto_count;

                            if($auto_count_refresh_mode==1)
                            {
                                $form_attributes['data-auto-count-refresh-mode'] = $auto_count_refresh_mode;
                            }
                        }


                        $form_attributes['action'] = $results_url;
                        $form_attributes['method'] = "post";
                        $form_attributes['class'] = 'searchandfilter'.$addclass;
                        $form_attributes['id'] = 'search-filter-form-'.$base_form_id;
                        $form_attributes['autocomplete'] = "off";
                        $form_attributes['data-instance-count'] = $searchandfilter->get_form_count($base_form_id);

                        $ajax_update_sections = apply_filters("search_filter_form_attributes_update_sections", [], $base_form_id);

                        if ( ! empty( $ajax_update_sections ) ) {
                            $form_attributes['data-ajax-update-sections'] = wp_json_encode( $ajax_update_sections );
                        }

                        if(has_filter("search_filter_form_attributes"))
                        {
                            $form_attributes = apply_filters("search_filter_form_attributes", $form_attributes, $base_form_id);
                        }


                        $form_attr = "";
                        foreach($form_attributes as $key => $val)
                        {
                            $form_attr .= $key."='".esc_attr($val)."' ";
                        }
                        $form_attr = trim($form_attr);

                        $returnvar .= '<form '.$form_attr.'>';
                        $returnvar .= "<ul>";

                        $this->fields = new Search_Filter_Fields($this->plugin_slug, $base_form_id);

                        //loop through each field and grab html
                        foreach ($fields as $field)
                        {
                            $returnvar .= $this->get_field($field, $post_types, $base_form_id);
                        }

                        $returnvar .= "</ul>";
                        $returnvar .= "</form>";



                    }
                }

                $time_end = microtime(true);
                $total_time = round(($time_end - $time_start), 6);

                /*echo "~~~~~~~~~~~~~~~~~~~<Br />";
                echo "Total To Generate & Display Search Form: $total_time<Br />";
                echo "~~~~~~~~~~~~~~~~~~~<Br />";*/
            }
            else if($show=="results")
            {
                //dont display results if they are inside the same loop (infinite loop)
                //if($searchandfilter->active_loop_id()==$base_form_id)

                //actually, why would we want to show any results within results, if there is an active loop, prevent
                //any further results shortcodes from activating within that set of results
                if($searchandfilter->active_loop_id()!=0)
                {
                    return;
                }

                /* legacy */
                if($searchform->settings('use_results_shortcode')==1)
                {
                    $display_results_as = "shortcode";
                }
                else
                {
                    $display_results_as = "archive";
                }
                /* end legacy */

                if($searchform->settings('display_results_as')!="")
                {
                    $display_results_as = $searchform->settings('display_results_as');
                }


                if($display_results_as=="shortcode")
                {
                    $returnvar = $this->display_results->output_results($base_form_id, $settings);
                }
                else
                {
                    if (current_user_can('edit_posts'))
                    {
                        $returnvar = __("<p><strong>Notice:</strong> This Search Form has not been configured to use a shortcode. <a href='".get_edit_post_link($base_form_id)."'>Edit settings</a>.</p>", $this->plugin_slug);
                    }
                }
            }

        }

        //Search_Filter_Helper::finish_log("----- Finish display_shortcode");
        return $returnvar;
    }

    //switch for different field types
    private function get_field($field_data, $post_types, $search_form_id)
    {
        $returnvar = "";

        $field_class = "";
        $field_name = "";
        if($field_data['type'] == "category")
        {
            $field_class = SF_FIELD_CLASS_PRE.$field_data['type'];
            $field_name = SF_TAX_PRE."category";
        }
        else if($field_data['type'] == "tag")
        {
            $field_class = SF_FIELD_CLASS_PRE.$field_data['type'];
            $field_name = SF_TAX_PRE."post_tag";
        }
        else if($field_data['type'] == "taxonomy")
        {
            $field_class = SF_FIELD_CLASS_PRE.$field_data['type']."-".($field_data['taxonomy_name']);
            $field_name = SF_TAX_PRE.$field_data['taxonomy_name'];
        }
        else if($field_data['type'] == "post_meta")
        {
            $field_class = SF_FIELD_CLASS_PRE.'post-meta'."-".($field_data['meta_key']);
            $field_name = SF_META_PRE.$field_data['meta_key'];
        }
        else if($field_data['type'] == 'post_type')
        {
            $field_class = SF_FIELD_CLASS_PRE.$field_data['type'];
            $field_name = SF_FPRE.$field_data['type'];
        }
        else if($field_data['type'] == 'sort_order')
        {
            $field_class = SF_FIELD_CLASS_PRE.$field_data['type'];
            $field_name = SF_FPRE.$field_data['type'];
        }
        else if($field_data['type'] == 'author')
        {
            $field_class = SF_FIELD_CLASS_PRE.$field_data['type'];
            $field_name = SF_FPRE.$field_data['type'];
        }
        else if($field_data['type'] == 'post_date')
        {
            $field_class = SF_FIELD_CLASS_PRE.$field_data['type'];
            $field_name = SF_FPRE.$field_data['type'];
        }
        else
        {
            $field_class = SF_FIELD_CLASS_PRE.$field_data['type'];
            $field_name = $field_data['type'];
        }

        $field_class = sanitize_html_class($field_class);

        $input_type = "";
        if(isset($field_data['input_type']))
        {
            $input_type = $field_data['input_type'];
        }

        $addAttributes = "";

        //check if is combobox
        if(($input_type=="select")||($input_type=="multiselect"))
        {
            if(isset($field_data['combo_box']))
            {
                if($field_data['combo_box']==1)
                {
                    $addAttributes .= ' data-sf-combobox="1"';

	                if(!empty($field_data['no_results_message'])){
		                $addAttributes .= ' data-sf-combobox-nrm="'.esc_attr($field_data['no_results_message']).'"';
	                }
                }
            }
        }


        $display_field = true;

        if(has_filter('sf_display_field')) {
            $display_field = apply_filters('sf_display_field', $display_field, $search_form_id, $field_name);
        }

        if($display_field==false)
        {
            return $returnvar;
        }

        $field_html = "";

        if($field_data['type']=="search")
        {
            $field_html = $this->fields->search->get($field_data);
        }
        else if(($field_data['type']=="tag")||($field_data['type']=="category")||($field_data['type']=="taxonomy"))
        {
            $field_html = $this->fields->taxonomy->get($field_data);
        }
        else if($field_data['type']=="post_type")
        {
            $field_html = $this->fields->post_type->get($field_data);
        }
        else if($field_data['type']=="post_date")
        {
            $field_html = $this->fields->post_date->get($field_data);
        }
        else if($field_data['type']=="post_meta")
        {
            $field_html = $this->fields->post_meta->get($field_data);
        }
        else if($field_data['type']=="sort_order")
        {
            $field_html = $this->fields->sort_order->get($field_data);
        }
        else if($field_data['type']=="posts_per_page")
        {
            $field_html = $this->fields->posts_per_page->get($field_data);
        }
        else if($field_data['type']=="author")
        {
            $field_html = $this->fields->author->get($field_data);
        }
        else if($field_data['type']=="submit")
        {
            $field_html = $this->fields->submit->get($field_data);
        }
        else if($field_data['type']=="reset")
        {
            $field_html = $this->fields->reset->get($field_data, $search_form_id);
        }


        global $searchandfilter;
        $searchform = $searchandfilter->get($search_form_id);
        $enable_taxonomy_archives = $searchform->settings("enable_taxonomy_archives");
        $field_taxonomy = "";

        if($enable_taxonomy_archives==1) {
            if ($field_data['type'] == "category") {
                $field_taxonomy = "category";
            } else if ($field_data['type'] == "tag") {
                $field_taxonomy = "post_tag";
            } else if ($field_data['type'] == "taxonomy") {
                $field_taxonomy = $field_data['taxonomy_name'];
            }

            $taxonomy = get_taxonomy($field_taxonomy);
            if($taxonomy)
            {
                if($taxonomy->public==true)
                {
                    $rewrite = Search_Filter_Helper::json_encode(Search_Filter_TTT::get_template($field_taxonomy));
                }
                else
                {
                    $rewrite = "";
                }

                $addAttributes .= " data-sf-term-rewrite='" . $rewrite . "'";
            }





            if(Search_Filter_Wp_Data::is_taxonomy_archive())
            {
                $term =	$searchandfilter->get_queried_object();
                if(isset($term->taxonomy)) {
	                $taxonomy_name = $term->taxonomy;
	                if ( $field_taxonomy == $taxonomy_name ) {
		                $addAttributes .= " data-sf-taxonomy-archive='1'";
	                }
                }
            }
        }

        if($field_data['type']=="post_meta")
        {
            $addAttributes .= ' data-sf-meta-type="'.$field_data['meta_type'].'"';
            if($field_data['meta_type']=="number")
            {
                $input_type = $field_data['number_input_type'];
            }
            else if($field_data['meta_type']=="choice")
            {
                $input_type = $field_data['choice_input_type'];

                if($field_data['combo_box']==1)
                {
                    $addAttributes .= ' data-sf-combobox="1"';
                }
            }
            else if($field_data['meta_type']=="date")
            {
                $input_type = $field_data['date_input_type'];
            }
        }

        $returnvar .= "<li class=\"$field_class\" data-sf-field-name=\"$field_name\" data-sf-field-type=\"".$field_data['type']."\" data-sf-field-input-type=\"".$input_type."\"".$addAttributes.">";

        //display a heading? (available to all field types)
        if(isset($field_data['heading']))
        {
            if($field_data['heading']!="")
            {
                $returnvar .= "<h4>".esc_html($field_data['heading'])."</h4>";
            }
        }

        $returnvar .= $field_html;

        $returnvar .= "</li>";

        return $returnvar;
    }

    function add_queryvars( $qvars )
    {
        /*$qvars[] = 'post_types';
        $qvars[] = 'post_date';
        $qvars[] = 'sort_order';
        $qvars[] = 'authors';
        $qvars[] = '_sf_s';*/
        $qvars[] = 'sfid'; //search filter template

        //we need to add in any meta keys
        /*foreach($_GET as $key=>$val)
        {
            $key = sanitize_text_field($key);

            if(($this->is_meta_value($key))||($this->is_taxonomy_key($key)))
            {
                $qvars[] = $key;
            }
        }*/

        return $qvars;
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

if ( ! class_exists( 'Search_Filter_Generate_Input' ) )
{
    require_once( plugin_dir_path( __FILE__ ) . 'class-search-filter-generate-input.php' );
}

if ( ! class_exists( 'Search_Filter_Display_Results' ) )
{
    require_once( plugin_dir_path( __FILE__ ) . 'class-search-filter-display-results.php' );
}

if ( ! class_exists( 'Search_Filter_Fields' ) )
{
    require_once( plugin_dir_path( __FILE__ ) . 'class-search-filter-fields.php' );
}



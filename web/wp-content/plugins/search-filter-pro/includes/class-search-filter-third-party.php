<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Third_Party
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Third_Party
{
	private $plugin_slug = '';
	private $form_data = '';
	private $count_table;
	private $cache;
	private $relevanssi_result_ids = array();
	private $query;
	private $woo_all_results_ids_keys = array();
	private $woo_all_results_ids = array();
	private $woo_result_ids_map = array();
	private $woo_meta_keys = array();
	private $woo_meta_keys_added = array();
	private $wc_variable_meta_keys = array();
	private $polylang_post_types = array();
	private $sfid = 0;

	private $woocommerce_enabled;
	public $cache_table_name;
	public $wc_forms_post_stati = array();
	public $wc_forms_post_types = array();

	function __construct()
	{
		global $wpdb;

		$this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');


		// if(!is_admin()) {
		if( (!is_admin()) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			//frontend only, or ajax

			//beaverbuilder themer plugin
			// removes paged = 1 from pagination when its the first page, otherwise themer kicks in a scroll on page load
			add_filter('sf_main_query_pre_get_posts', array($this, 'sf_beaver_themer_pre_get_posts'), 11, 2); //

			// -- woocommerce
			add_filter('sf_edit_query_args', array($this, 'sf_woocommerce_query_args'), 11, 2); //
			add_filter('sf_main_query_pre_get_posts', array($this, 'sf_woocommerce_pre_get_posts'), 11, 2); //
			add_filter('sf_query_cache_post__in', array($this, 'sf_woocommerce_get_variable_product_ids'), 11, 2); //
			add_filter('sf_query_post__in', array($this, 'sf_woocommerce_convert_variable_product_ids'), 11, 2); //
			add_filter('sf_query_cache_count_ids', array($this, 'sf_woocommerce_conv_variable_ids'), 11, 2); //
			add_filter('sf_query_cache_count_id_numbers', array($this, 'sf_query_cache_count_id_numbers'), 11, 2); //
			//add_filter('sf_query_cache_field_terms_results', array($this, 'sf_woocommerce_convert_term_results'), 11, 3); //
			add_filter('sf_admin_filter_settings_save', array($this, 'sf_woocommerce_filter_settings_save'), 11, 2); // ***************************************
			add_filter('sf_query_cache_register_all_ids', array($this, 'sf_woocommerce_register_all_result_ids'), 11, 2); //
			//add_filter('search_filter_cache_filter_names', array($this, 'sf_woocommerce_cache_filter_names'), 11, 2); //
			add_filter('sf_apply_custom_filter', array($this, 'sf_woocommerce_add_stock_status'), 11, 3);
			//add_filter( "woocommerce_catalog_orderby", "sf_woocommerce_product_sorting", 20 ); // this removed "popularity from Woocommerce sorting options"

			// -- relevanssi
			add_filter('sf_edit_query_args_after_custom_filter', array($this, 'relevanssi_filter_query_args'), 12, 2);
			add_filter('sf_apply_custom_filter', array($this, 'relevanssi_add_custom_filter'), 10, 3);

			// -- polylang
			add_filter('sf_archive_results_url', array($this, 'pll_sf_archive_results_url'), 10, 3); //
			add_filter('sf_ajax_results_url', array($this, 'pll_sf_ajax_results_url'), 10, 2); //
			add_filter('sf_ajax_form_url', array($this, 'pll_sf_form_url'), 10, 3); //

			if(class_exists('Easy_Digital_Downloads')){
				add_filter('shortcode_atts_downloads', array($this, 'edd_filter_downloads_shortcode'), 1000, 3);
				add_filter('do_shortcode_tag', array($this, 'edd_filter_downloads_shortcode_output'), 1000, 3);
				add_filter( 'search_filter_form_attributes', array($this, 'edd_search_filter_form_attributes'), 10, 2 );
			}
		}

		//add_filter('fes_save_field_after_save_frontend', array($this, 'sf_edd_fes_field_save_frontend'), 11, 3); //
		//add_action('fes_submission_form_edit_published', array($this, 'sf_edd_fes_submission_form_published'), 20, 1);
		//add_action('fes_submission_form_new_published', array($this, 'sf_edd_fes_submission_form_published'), 20, 1);
		//add_action('fes_submission_form_edit_pending', array($this, 'sf_edd_fes_submission_form_published'), 20, 1);
		//add_action('fes_submission_form_new_pending', array($this, 'sf_edd_fes_submission_form_published'), 20, 1);

		// -- EDD
		//add_action( 'marketify_entry_before', array($this, 'marketify_entry_before_hook') );
		//add_filter('edd_downloads_query', array($this, 'edd_prep_downloads_sf_query'), 10, 2);

		// -- woo public + admin
		add_action('search_filter_pre_update_post_cache', array($this, 'sf_woocommerce_update_post_cache'), 10, 2); //
		add_filter('search_filter_post_cache_insert_data', array($this, 'sf_woo_post_cache_insert_data'), 10, 3); //
		add_filter('search_filter_post_cache_insert_offset', array($this, 'sf_woo_post_cache_insert_offset'), 10, 2); //
		add_filter('search_filter_post_cache_data', array($this, 'sf_woocommerce_cache_data'), 11, 2); //
		add_filter('search_filter_post_cache_data_query_args', array($this, 'sf_woocommerce_cache_data_query_args'), 11, 2); //
		add_filter('search_filter_post_cache_update', array($this, 'sf_woocommerce_cache_update'), 11, 3); //

		// -- polylang
		add_filter('sf_edit_query_args', array($this, 'sf_poly_query_args'), 11, 2); //
		add_filter('pll_get_post_types', array($this, 'pll_sf_add_translations'), 10, 2);
		add_filter('pll_get_post_types', array($this, 'pll_sf_get_translations'), 100000, 2); //try to set this as late as possible
		add_filter('sf_edit_cache_query_args', array($this, 'poly_lang_sf_edit_cache_query_args'), 10, 2);
		add_filter('sf_edit_search_forms_query_args', array($this, 'poly_lang_sf_edit_cache_query_args'), 10, 2); //set the language when fetching our built in search forms (suppress filters no longer works)
		add_filter('sf_archive_slug_rewrite', array($this, 'pll_sf_archive_slug_rewrite'), 10, 3); //
		add_filter('sf_rewrite_query_args', array($this, 'pll_sf_rewrite_args'), 10, 3); //
		add_filter('sf_pre_get_posts_admin_cache', array($this, 'sf_pre_get_posts_admin_cache'), 10, 3); //

		$this->init();
	}

	public function init()
	{

	}

	/* EDD integration */
	public function edd_filter_downloads_shortcode($out, $pairs, $atts)
	{

		if(!isset($atts['search_filter_id'])){
			return $out;
		}

		$search_filter_id = intval($atts['search_filter_id']);
		do_shortcode("[searchandfilter id='$search_filter_id' action='filter_next_query']");
		//do_action("search_filter_setup_pagination", $search_filter_id);
		global $searchandfilter;
		$sf_inst = $searchandfilter->get($search_filter_id);
		$sf_inst->query->prep_query();

		return $out;
	}

	public function edd_filter_downloads_shortcode_output($output, $tag, $atts)
	{

		if(!isset($atts['search_filter_id'])){
			return $output;
		}

		if( $tag !== 'downloads' ){
			return $output;
		}

		global $searchandfilter;
		$search_filter_id = intval($atts['search_filter_id']);

		$sf_inst = $searchandfilter->get($search_filter_id);

		//make sure this search form is tyring to use EDD
		if($sf_inst->settings("display_results_as")=="custom_edd_store"){

			//wrap both pagination + results in 1 container for ajax
			$output = '<div class="search-filter-results search-filter-results-'.$search_filter_id.'">'.$output.'</div>';
		}

		return $output;
	}
	public function edd_search_filter_form_attributes($attributes, $sfid){

		if(isset($attributes['data-display-result-method']))
		{
			if($attributes['data-display-result-method']=="custom_edd_store")
			{
				$attributes['data-ajax-target'] = '.search-filter-results-'.$sfid;
				$attributes['data-ajax-links-selector'] = '.edd_pagination a';
			}

		}

		return $attributes;
	}

	/* WooCommerce integration */
	public function is_woo_enabled()
	{
		if (!isset($this->woocommerce_enabled)) {
			if (!function_exists('is_plugin_active')) {
				require_once(ABSPATH . '/wp-admin/includes/plugin.php');
			}

			$this->woocommerce_enabled = is_plugin_active('woocommerce/woocommerce.php');
		}
		return $this->woocommerce_enabled;
	}

	public function sf_woocommerce_product_sorting($orderby) {
		if(isset($orderby["popularity"])) {
			unset( $orderby["popularity"] );
		}
		return $orderby;
	}

	function custom_woocommerce_product_sorting( $orderby ) {

	}

	public function sf_woocommerce_add_stock_status($ids_array, $query_args, $sfid) {


		if (!$this->is_woo_enabled()) {
			return $ids_array;
		}

		/*
		* get the instock IDs from the DB directly
		* check for the woocommerce setting "show out of stock products", and only enable this on that condition
	    */

		if(get_option('woocommerce_hide_out_of_stock_items')=="yes"){

			$merge = true;
			if(isset($ids_array[0])) {
				if ( $ids_array[0] === false ) {
					$merge = false;
				}
			}

			global $wpdb;

			$term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');

			$field_terms_results = $wpdb->get_results(
				"
                SELECT field_name, field_value, result_ids
                FROM $term_results_table_name
                WHERE field_name = '_sfm__stock_status'
                AND field_value = 'instock' LIMIT 0, 1
                "
			);

			if((count($field_terms_results)==1) && (property_exists($field_terms_results[0], 'result_ids'))) {
				$instock_ids = explode(',', $field_terms_results[0]->result_ids);


				if ( $merge == false ) {
					$ids_array = $instock_ids;
				} else {
					$ids_array = array_intersect( $ids_array, $instock_ids );
				}
			}
		}

		return $ids_array;
	}

	//when dealing with variations,
	public function sf_woo_post_cache_insert_offset( $offset, $post_id ) {

		if (!$this->is_woo_enabled()) {
			return $offset;
		}

		$post = get_post($post_id);

		if(!$post) {
			return $offset;
		}

		if($post->post_type !== 'product') {
			return $offset;
		}

		$post_types = $this->get_cache_post_types();

		//if product variations are not in our cache list, then don't bother, and exit.
		if(!in_array("product_variation", $post_types)) {
			return $offset;
		}


		$product = wc_get_product($post->ID);

		if( $product->is_type('variable')) {

			$product_variable = new WC_Product_Variable( $post->ID );
			$product_variation_ids = $product_variable->get_children();
			$offset = count($product_variation_ids);
		}


		return $offset;

	}

	public function sf_woo_post_cache_insert_data( $insert_data, $post_id, $type ) {

		if (!$this->is_woo_enabled()) {
			return $insert_data;
		}

		$post = get_post($post_id);

		if(!$post) {
			return $insert_data;
		}

		if($post->post_type !== 'product') {
			return $insert_data;
		}

		$product = wc_get_product($post->ID);
		//$post_status = get_post_status($post->ID); //don't index variations if the parent is private

		if( $product->is_type('variable') ) {

			//then remove `price`, and remove all taxonomy related attributes (as we want to add them manually, based on variations data)
			if($type == 'taxonomy') {

				$product_attributes = $product->get_attributes();

				foreach( $insert_data as $data_key => $data ) {

					$attr_key = strpos($data_key, '_sft_pa_');

					if( $attr_key !== false ) {

						$tax_name = str_replace("_sft_", "", $data_key);

						if(isset($product_attributes[$tax_name])) {

							//now check to see if the attribute is used as variation, if not, then index it
							if($product_attributes[$tax_name]['variation'] === true) {
								unset( $insert_data[ $data_key ] );
							}

							//maybe don't when we don't include variations in our post type lists
							//basically, quick fix is, tell uesrs to include variations in their post types, because in fact those products are variations and we need the data
							//however, its worth checking if leaving the data the line `if($product_attributes[$tax_name]['variation'] === true) {`
							//to leave the attribute attached to the parent product affects count numbers in the front end (when searching variations)
							//if not, then leave it in the extra data, we can sidestep the complex variation functions when only indexing `product` post type

							//theoretically an attribute , thats not used for variations, can be on parent and child, because they will always evaluate to the same
							//we need it on the variations, for matching to those varations, but we also need it on the parent to match that, such as when only "product"
							//post type indexed (and not variations)(

							// - update - seems to be fine, parents and children will all evaluate to parent ID, so don't need to worry about this
						}
					}
				}
			} else if($type == 'meta') {

				$this->wc_variable_meta_keys = array_keys($insert_data);

				if(isset($insert_data['_sfm__price'])) {
					//unset($insert_data['_sfm__price']);
					// no we need to leave in parent price, so it can be matched
					// with other fields, such as attributes, that are not variations (so they are on the parent)
				}

				//if managing stock is false, then we are managing stock at the variation level, so unset it from the parent
				if(($product->managing_stock()==false)&&(isset($insert_data['_sfm__stock_status']))) {
					// disable, keep on the parent, in case the user doesn't include variations, and so we can mathc stock status
					// if such a filter has been created v2.4.7
					//unset($insert_data['_sfm__stock_status']);
				}
			}

		} else if( $product->is_type('simple')) {
			// then we need to add product attributes, that are not taxonomies
			if($type == 'meta') {

				$product_attributes = $product->get_attributes();

				foreach($product_attributes as $product_attribute) {

					if(!$product_attribute->is_taxonomy()) {
						$attribute_name = $product_attribute->get_name();
						$sf_field_name = '_sfm_attribute_'.$attribute_name;
						$attribute_options = $product_attribute->get_options();

						$insert_data[$sf_field_name] = $attribute_options;
					}
				}
			}
		}


		return $insert_data;
	}


	private function sf_woo_get_product_terms_data($postID) {

		$insert_arr = array();

		if (!$this->is_woo_enabled()) {
			return $insert_arr;
		}


		$post = get_post($postID);

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


			//if($taxonomy_slug!=){
			$attr_key = strpos($taxonomy_slug, 'pa_');
			if( ( $attr_key === false ) && ( $attr_key !== 0 ) ) {

				// get the terms related to post
				$terms = get_the_terms( $postID, $taxonomy_slug );
				$insert_arr["_sft_".$taxonomy_slug] = array();
				$insert_arr["_sft_".$taxonomy_slug]['values'] = array();
				$insert_arr["_sft_".$taxonomy_slug]['type'] = 'number';

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


						array_push($insert_arr["_sft_".$taxonomy_slug]['values'], (string)$term_id);
					}
				}

			}
			//}
		}

		if(Search_Filter_Helper::has_wpml()&&(defined("ICL_LANGUAGE_CODE")))
		{
			do_action( 'wpml_switch_language', $current_language );
		}

		return $insert_arr;

	}
	public function get_all_forms_post_stati() {

		if(empty($this->wc_forms_post_stati)){

			$search_form_post_stati = array();

			$search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish&posts_per_page=-1&suppress_filters=1');
			$search_forms = $search_form_query->get_posts();

			foreach ($search_forms as $search_form) {

				$search_form_settings = Search_Filter_Helper::get_settings_meta($search_form->ID);
				$this_post_stati = array_keys($search_form_settings['post_status']);
				foreach($this_post_stati as $this_post_status){

					array_push($search_form_post_stati, $this_post_status);
				}


			}
			$this->wc_forms_post_stati = array_unique($search_form_post_stati);

		}

		return $this->wc_forms_post_stati;
	}
	public function get_all_filters_names() {
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

		return $filters;
	}
	private function get_fields_meta($sfid)
	{

		$meta_key = '_search-filter-fields';
		$search_form_fields = (get_post_meta($sfid, $meta_key, true));

		return $search_form_fields;
	}
	public function get_all_meta_key_names() {
		$filters = array();

		$search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish&posts_per_page=-1&suppress_filters=1');
		$search_forms = $search_form_query->get_posts();

		foreach ($search_forms as $search_form) {
			$search_form_fields = $this->get_fields_meta($search_form->ID);

			if($search_form_fields) {
				foreach ( $search_form_fields as $key => $field ) {
					$valid_filter_types = array( "tag", "category", "taxonomy", "post_meta" );

					if ( $field['type'] == "post_meta" ) {
						if ( $field['meta_type'] == "choice" ) {
							array_push( $filters, $field['meta_key'] );
						}
					}
				}
			}
		}
		$filters = array_unique($filters);

		return $filters;
	}
	public function sf_woo_get_variation_post_meta_values($variation_id) {

		$index_data = array();

		global $searchandfilter;
		$meta_key_fields = $this->get_all_meta_key_names();

		$wanted_meta_keys = array();
		foreach ( $meta_key_fields as $meta_key_field_name ) {

			if ( ( $meta_key_field_name !== '_price' ) && ( strpos( $meta_key_field_name, 'attribute_' ) === false ) ) {
				array_push($wanted_meta_keys, $meta_key_field_name);
			}
		}

		//array_push($wanted_meta_keys, "_stock_status");
		$remove_keys = array('_stock_status');

		$wanted_meta_keys = array_diff( $wanted_meta_keys, $remove_keys) ;

		foreach($wanted_meta_keys as $wanted_meta_key){

			$post_meta_values = get_post_meta($variation_id, $wanted_meta_key);

			if(!empty($post_meta_values)) {
				$index_data['_sfm_'.$wanted_meta_key] = array();
				$index_data['_sfm_'.$wanted_meta_key]['values'] = $post_meta_values;
				$index_data['_sfm_'.$wanted_meta_key]['type'] = 'string';
			}
		}

		if(isset($index_data['_sfm__stock_status'])){

		}

		return $index_data;
	}
	public function sf_woo_get_variation_taxonomy_values($index_data, $product_id) {

		//$index_data = array();

		$product = wc_get_product($product_id);

		$product_attributes = $product->get_attributes();

		foreach ( $product_attributes as $product_attribute ) {


			//now check to see if the attribute is used as variation, if not, then index it
			if ( $product_attribute['variation'] === false ) {

				$name = $product_attribute['name'];
				//$product_options = array();
				if((!is_array($product_attribute['options'])) && (!empty($product_attribute['options']))){
					$product_options = array($product_attribute['options']);
				}
				else {
					$product_options = $product_attribute['options'];
				}

				if(!empty($product_options)) {
					$index_data['_sft_'.$name] = array();
					$index_data['_sft_'.$name]['values'] = $product_options;
					$index_data['_sft_'.$name]['type'] = 'number';
				}
			}
		}

		return $index_data;

	}

	public function sf_woo_post_cache_get_delete_variation_data( $post_id ) {


		//delete all variation data from the cache - we lookup our own tables, because the variation IDs might have changed
		global $wpdb;
		//$wpdb->delete( $this->cache_table_name, array( 'post_parent_id' => $post->ID ) );

		//so loop through any IDs, collect all the field name & values
		//delete them all, then send the field name and values to the term updater
		//do_action("search_filter_delete_post_cache", $variation_id);
		$this->cache_table_name = Search_Filter_Helper::get_table_name('search_filter_cache');

		$results = $wpdb->get_results($wpdb->prepare(
			"
				SELECT DISTINCT post_id
				FROM $this->cache_table_name
				WHERE post_parent_id = '%d'
			",
			$post_id
		));

		foreach($results as $result){
			do_action("search_filter_delete_post_cache", $result->post_id);
		}
	}
	public function sf_woo_post_cache_add_variation_product_data( $post ) {

		if (!$this->is_woo_enabled()) {
			return;
		}

		//get the terms on the parent post, so we can add them to all the variations in our cache
		$term_values = $this->sf_woo_get_product_terms_data($post->ID);

		$product = wc_get_product($post->ID);
		$product_attributes = $product->get_attributes();
		$product_variable = new WC_Product_Variable( $post->ID );
		$product_variation_ids = $product_variable->get_children();

		//$product_variations = $product_variable->get_available_variations();
		//foreach($product_variations as $product_variation) {

		$post_status = get_post_status($post->ID); //don't index variations if the parent is private, and if its not in any search forms
		$index_variation = true;

		$exclude_from_catalog = false;
		if(has_term( "exclude-from-catalog", "product_visibility", $post )){
			$exclude_from_catalog = true;
		}
		//exclude-from-catalog

		//$post_stati = $this->get_all_forms_post_stati();
		//if(!in_array("private", $post_stati)){
			//then we are not indexing private posts, so don't add
			if(($post_status=="private")||($post_status=="draft")||($exclude_from_catalog)){
				$index_variation = false;
			}
		//}

		//we first need to delete all variation data assoc with this post
		$this->sf_woo_post_cache_get_delete_variation_data($post->ID);

		$post_types = $this->get_cache_post_types();

		//if product variations are not in our cache list, then don't bother, and exit.
		if(!in_array("product_variation", $post_types)) {
			$index_variation = false;
		}

		// skip this variation
		if($index_variation===false){
			return;
		}

		foreach($product_variation_ids as $variation_id) {

			//need to remove existing records for this variation (already done in `sf_woo_post_cache_get_delete_variation_data`)

			//loop through the variations
			$single_variation = new WC_Product_Variation($variation_id);
			$variation_price = $single_variation->get_price();
			$variation_attributes = $single_variation->get_variation_attributes();

			//start by adding post meta / can be an empty array
			//$variation_values = array();
			$variation_values = $this->sf_woo_get_variation_post_meta_values($variation_id);
			$variation_values = $this->sf_woo_get_variation_taxonomy_values($variation_values, $post->ID);

			//loop through the variations attributes

			foreach($variation_attributes as $variation_key => $variation_value) {

				if ( strpos( $variation_key, 'attribute_' ) !== false ) {

					//if(!empty($variation_value)) {

						//if the name begins with attribute_pa, then its a taxonomy
						if ( strpos( $variation_key, 'attribute_pa' ) !== false ) {

							if(!empty($variation_value)) {

								$taxonomy_name = str_replace( 'attribute_', '', $variation_key );
								$term          = get_term_by( 'slug', $variation_value, $taxonomy_name );

								if ( ( ! is_wp_error( $term ) ) && ( !empty($term) ) ) {

									$field_name                                = '_sft_' . $taxonomy_name;
									$variation_values[ $field_name ]           = array();
									$variation_values[ $field_name ]['values'] = array( $term->term_id );
									$variation_values[ $field_name ]['type']   = 'number';

								}
							}
							else{
								//the attribute was empty, which means "ANY" was selected, which means we need to attach all
								//possible attributes to this variation
								$taxonomy_name = str_replace( 'attribute_', '', $variation_key );

								if(isset($product_attributes[$taxonomy_name])) {

									$values = $product_attributes[$taxonomy_name]->get_options();

									$field_name                                = '_sft_' . $taxonomy_name;
									$variation_values[ $field_name ]           = array();
									$variation_values[ $field_name ]['values'] = $values;
									$variation_values[ $field_name ]['type']   = 'number';



								}
							}

						} else {
							if(!empty($variation_value)) {
								$meta_name = $variation_key;

								$field_name                                = '_sfm_' . $meta_name;
								$variation_values[ $field_name ]           = array();
								$variation_values[ $field_name ]['values'] = array( $variation_value );
								$variation_values[ $field_name ]['type']   = 'string';
							}
						}

					//}

				}
			}


			//figure out which meta keys to index of the variations
			global $search_filter_post_cache;
			$cache_data = $search_filter_post_cache->get_cache_data();
			$meta_keys = array();
			if(isset($cache_data['meta_keys'])){
				if(is_array($cache_data['meta_keys'])){
					$meta_keys = $cache_data['meta_keys'];

					foreach($meta_keys as &$meta_key){
						$meta_key = "_sfm_".$meta_key;
					}
				}
			}

			//merge meta keys in the post cache with the existing passed through
			$this->wc_variable_meta_keys = array_unique( array_merge( $this->wc_variable_meta_keys, $meta_keys ) );

			//now we add the other post meta, like _width, _height
			$post_meta = get_post_meta($variation_id);

			foreach($this->wc_variable_meta_keys as $meta_key){

				//make sure the key starts with meta prefix
				$prefix = '_sfm_';
				if ( strpos( $meta_key, $prefix ) !== false ) {

					if (substr($meta_key, 0, strlen($prefix)) == $prefix) {
						$meta_key = substr($meta_key, strlen($prefix));
					}

					if(isset($post_meta[$meta_key])){

						$field_name = '_sfm_' . $meta_key;
						$variation_value = $post_meta[$meta_key];
						$variation_values[ $field_name ] = array();
						if(!is_array($variation_value)){
							$variation_value = array($variation_value);
						}
						$variation_values[ $field_name ]['values'] = $variation_value;
						$variation_values[ $field_name ]['type'] = 'string';

					}

				}

			}

			$variation_values['_sfm__price'] = array();
			$variation_values['_sfm__price']['values'] = array($variation_price);
			$variation_values['_sfm__price']['type'] = 'string';

			//we're managing stock status at product level, not variation, so forget about it for variations (ie, just copy the parent value)
			if($product->managing_stock()==true) {
				if(isset($variation_values['_sfm__stock_status'])){
					unset($variation_values['_sfm__stock_status']);
				}
				// copy the value from the parent product to the variation so we can get matches on _stock_status
				$variation_values['_sfm__stock_status'] = array();
				$variation_values['_sfm__stock_status']['values'] = array($product->get_stock_status());
				$variation_values['_sfm__stock_status']['type'] = 'string';

			}
			/*else{
				//to enable the ability to have an instock / outofstock filter, we need to unset all "outofstock" on variaations
				// because they cause a count increase for the "outofstock" option, which we do not want
				if(isset($variation_values['_sfm__stock_status'])){
					unset($variation_values['_sfm__stock_status']);
				}
			}*/

			//combine parent taxonomies with variation attributes
			$variation_insert_data = array_merge($term_values, $variation_values);

			//add variation
			do_action('search_filter_insert_post_data', $variation_id, $variation_insert_data, 'number');

		}

	}
	public function sf_woo_post_cache_add_simple_product_data( $post ) {


	}
	public function sf_woocommerce_update_post_cache( $post ) {


		if (!$this->is_woo_enabled()) {

			return;
		}
		global $search_filter_session;

		if($post->post_type=="product"){

			$product = wc_get_product($post->ID);

			if( $product->is_type('variable')) {

				//always let it in here if its variable, because this is also where data is cleaned up, if the variations don't get added
				$this->sf_woo_post_cache_add_variation_product_data($post);
			}
			/*else if( $product->is_type('simple')) {
				$this->sf_woo_post_cache_add_simple_product_data($post);
			}*/
		}
		else{

		}

	}

	public function get_cache_post_types(){

		if(empty($this->wc_forms_post_types)){

			$search_form_post_types = array();

			$search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish&posts_per_page=-1&suppress_filters=1');
			$search_forms = $search_form_query->get_posts();

			foreach ($search_forms as $search_form) {

				$search_form_settings = Search_Filter_Helper::get_settings_meta($search_form->ID);
				$this_post_types = array_keys($search_form_settings['post_types']);
				foreach($this_post_types as $this_post_type){

					array_push($search_form_post_types, $this_post_type);
				}


			}
			$this->wc_forms_post_types = array_unique($search_form_post_types);

		}

		return $this->wc_forms_post_types;



	}

	/*public function sf_woocommerce_get_tax_meta_variations_keys($add_prefix = true)
	{
		$meta_keys = array();

		if (!$this->is_woo_enabled()) {
			return $meta_keys;
		}

		if(empty($this->woo_meta_keys))
		{
			$taxonomy_objects = get_object_taxonomies('product', 'objects');
			$exclude_taxonomies = array("product_type", "product_cat", "product_tag", "product_shipping_class");

			foreach ($taxonomy_objects as $taxonomy) {
				if (!in_array($taxonomy->name, $exclude_taxonomies)) {

					$prefix = "";
					if($add_prefix)
					{
						$prefix = "attribute_";
					}
					$meta_name = $prefix . $taxonomy->name;
					array_push($meta_keys, $meta_name);
				}
			}

			$this->woo_meta_keys = $meta_keys;

		}

		return $this->woo_meta_keys;
	}*/

	public function sf_woocommerce_cache_update($update_post_cache, $postID, $post_type){

		if (!$this->is_woo_enabled()) {
			return $update_post_cache;
		}

		//essentially we want to remove private posts from all our queries & db,
		//causing too many counting errors depending on if user is logged in
		if(($post_type=="product")||($post_type=="product_variation")) {
			//only really needs to be product, because variation will always have published status
			$post_status = get_post_status( $postID ); //don't index variations if the parent is private, and if its not in any search forms

			$exclude_from_catalog = false;
			if(has_term( "exclude-from-catalog", "product_visibility", $postID )){
				$exclude_from_catalog = true;
			}


			//drafts & private mess up the count numbers, while the main query doesn't show them, so may aswell sync, and exclude across the board
			if ( ( $post_status == "private" ) || ( $post_status == "draft" ) || ($exclude_from_catalog == true) ) {

				$this->sf_woo_post_cache_get_delete_variation_data($postID);
				do_action("search_filter_delete_post_cache", $postID);

				return false;
			}
		}

		return $update_post_cache;
	}

	public function sf_woocommerce_cache_data($cache_data)
	{

		//check to see if we are using woocommerce post types
		if (!$this->is_woo_enabled()) {
			return $cache_data;
		}

		if (empty($cache_data)) {
			return $cache_data;
		}

		if (empty($cache_data['post_types'])) {
			return $cache_data;
		}

		//if either product or variation
		//we want to record `_stock_status` regardless if it has been set as a field - we need this because calc get complicated when checking if stock is managed at variation or product level
		if ((in_array("product", $cache_data['post_types'])) || (in_array("product_variation", $cache_data['post_types']))) {
			if(!in_array('_stock_status', $cache_data['meta_keys'])) {
				if(!isset($cache_data['meta_keys'])){
					$cache_data['meta_keys'] = array();
				}
				array_push($cache_data['meta_keys'], "_stock_status");
			}
		}

		/*if ((in_array("product", $cache_data['post_types'])) && (in_array("product_variation", $cache_data['post_types']))) {

			$variation_position = array_search("product_variation", $cache_data['post_types'], true);

			if($variation_position!==false){
				unset($cache_data['post_types'][$variation_position]); //we don't want to index them, we hook into WC classes to grab the data
				$cache_data['post_types'] = array_values($cache_data['post_types']);
			}

			//then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list
			//$meta_keys = $this->sf_woocommerce_get_tax_meta_variations_keys();
			//if (!empty($meta_keys)) {
			//	$cache_data['meta_keys'] = array_unique(array_merge($cache_data['meta_keys'], $meta_keys));
			//}
		}*/

		/* TODO
			POTENTIAL PROBLEM, THIS DATA IS ONLY CALCULATED WHEN A SEARCH FORM IS SAVED,
			IT SHOULD ALSO BE RECALCULATED WHEN THE CACHE RESTARTS BUILDING,
			MAY BE NOT, DEPENDS MAYBE ONLY NEED FOR DEBUG
		*/

		return $cache_data;

	}
	public function sf_woocommerce_cache_data_query_args($query_args)
	{
		//check to see if we are using woocommerce post types
		if (!$this->is_woo_enabled()) {
			return $query_args;
		}

		if (empty($query_args['post_type'])) {
			return $query_args;
		}

		if ((in_array("product", $query_args['post_type'])) && (in_array("product_variation", $query_args['post_type']))) {

			$variation_position = array_search("product_variation", $query_args['post_type'], true);

			if($variation_position!==false){
				unset($query_args['post_type'][$variation_position]); //we don't want to index them, we hook into WC classes to grab the data
				$query_args['post_type'] = array_values($query_args['post_type']);
			}
		}

		return $query_args;
	}

	public function sf_woocommerce_is_woo_variations_query($sfid)
	{
		if (!$this->is_woo_enabled()) {
			return false;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		$post_types_arr = $sf_inst->settings("post_types");
		$post_types = array();
		if(is_array($post_types_arr)){
			$post_types = array_keys($post_types_arr);
		}

		if ((in_array("product", $post_types)) && (in_array("product_variation", $post_types))) {
			//then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list

			return true;
		}

		return false;

	}
	public function sf_woocommerce_is_woo_query($sfid)
	{
		if (!$this->is_woo_enabled()) {
			return false;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		$post_types_arr = $sf_inst->settings("post_types");
		$post_types = array();
		if(is_array($post_types_arr)){
			$post_types = array_keys($post_types_arr);
		}

		if (in_array("product", $post_types)) {
			//then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list

			return true;
		}

		return false;

	}
	/*public function sf_woocommerce_cache_filter_names($field_names, $sfid)
	{
		if (!$this->is_woo_enabled()) {
			return $field_names;
		}

		if($this->sf_woocommerce_is_woo_variations_query($sfid))
		{
			$taxonomy_names = $this->sf_woocommerce_get_tax_meta_variations_keys(false);

			//now try to see which of the post variations post meta keys are in the current fields list (as taxonomies, and only then add them)
			$active_taxonomy_names = array();
			foreach ($field_names as $field_name)
			{
				//remove
				if(strpos($field_name, "_sft_")!== false)
				{
					$tax_name = ltrim($field_name, '_sft_');
					//$tax_name = str_replace("_sft_", "", $field_name);
					array_push($active_taxonomy_names, $tax_name);
				}
			}

			//no we find which need to have meta fields also added to lookup tax values within variations
			$tax_meta_keys_needed = array_intersect($active_taxonomy_names, $taxonomy_names);

			//now convert them to field names:
			$this->woo_meta_keys_added = array();
			foreach($tax_meta_keys_needed as $tax_key)
			{
				$meta_key = "_sfm_attribute_".$tax_key;

				array_push($field_names, $meta_key);
				array_push($this->woo_meta_keys_added, $tax_key);

			}
		}

		return $field_names;
	}*/

	public function sf_woocommerce_convert_term_results($filters, $cache_term_results, $sfid) {

		//check to see if we are using woocommerce post types
		if(!$this->is_woo_enabled()){
			return $filters;
		}

		if(empty($filters)){
			return $filters;
		}

		foreach($this->woo_meta_keys_added as $woo_tax_name){

			if(isset($cache_term_results["_sfm_attribute_".$woo_tax_name])) {
				$terms = $cache_term_results["_sfm_attribute_" . $woo_tax_name];

				foreach ($terms as $term_name => $result_ids) {

					$tax = Search_Filter_Wp_Data::get_taxonomy_term_by("slug", $term_name, $woo_tax_name);

					if (($tax) && (isset($filters["_sft_" . $woo_tax_name]))) {
						/* REMOVE THE PARENT POST ID FROM THE CACHE_RESULT_IDS */

						if (!isset($filters["_sft_" . $woo_tax_name]['terms'][$term_name])) {
							$filters["_sft_" . $woo_tax_name]['terms'][$term_name] = array();
							$filters["_sft_" . $woo_tax_name]['terms'][$term_name]['term_id'] = $tax->term_id;
							$filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'] = array();
						}

						$filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'] = array_merge($filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'], $result_ids);
					}
				}
			}
		}

		return $filters;
	}
	public function sf_woocommerce_register_all_result_ids($register, $sfid)
	{
		if (!$this->is_woo_enabled()) {
			return $register;
		}

		//make sure this search form is tyring to use woocommerce
		if($this->sf_woocommerce_is_woo_variations_query($sfid)){
			return true;
		}

		return $register;

	}
	public function sf_woocommerce_is_filtered()
	{
		return true;
	}

	public function sf_woocommerce_convert_variable_product_ids($post_ids, $sfid) {

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		//make sure this search form is tyring to use woocommerce
		if($this->sf_woocommerce_is_woo_variations_query($sfid)) {
			$post_ids = $this->sf_woocommerce_conv_variable_ids( $post_ids, $sfid );
		}

		return $post_ids;
	}
	public function sf_woocommerce_get_variable_product_ids($post_ids, $sfid)
	{
		if (!$this->is_woo_enabled()) {
			return $post_ids;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		//make sure this search form is tyring to use woocommerce
		if($this->sf_woocommerce_is_woo_variations_query($sfid)){

			$this->woo_all_results_ids_keys = $sf_inst->query->cache->get_registered_result_ids();
			$all_result_ids = array_keys($this->woo_all_results_ids_keys);

			//run query to convert variation IDs to parent/product IDs
			$parent_conv_args = array(
				'post_type' => 'product_variation',
				'posts_per_page' => -1,
				'paged' => 1,
				'post__in' => $all_result_ids,
				'fields' => "id=>parent",

				'orderby' => "", //remove sorting
				'meta_key' => "",
				'order' => "",
				'post_status' => "",

				//by adding this, we don't convert the ID of a variation to the parent, which means a match won't be found / kinda hacky but excludes out of stock from results
				/*'meta_query' => array(
					array(
						'key' => '_stock_status',
						'value' => 'instock'
					)
				),*/
				/*array(
					'taxonomy' 		=> 'product_visibility',
					'field'    		=> 'slug',
					'terms'    		=> array('outofstock'),
					'operator'       => 'NOT IN'
				),
				array(
					'taxonomy' 		=> 'product_visibility',
					'field'    		=> 'slug',
					'terms'    		=> array('exclude-from-catalog', 'exclude-from-search','outofstock'),
					'operator'       => 'NOT IN'
				),*/

				// speed improvements
				'no_found_rows' => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false
			);

			// The Query
			$query_arr = new WP_Query($parent_conv_args);



			$new_ids = array();
			if ($query_arr->have_posts()) {
				foreach ($query_arr->posts as $post) {

					if ($post->post_parent == 0) {
						//$new_ids[$post->ID] = $post->ID;
					} else {
						$new_ids[$post->ID] = $post->post_parent;
					}
				}
			}

			$this->woo_result_ids_map = ($new_ids);
			//$post_ids = $this->sf_woocommerce_conv_variable_ids($post_ids, $sfid);
		}

		return $post_ids;
	}

	public function sf_woocommerce_conv_variable_ids($post_ids, $sfid)
	{
		//make sure this search form is tyring to use woocommerce
		if($this->sf_woocommerce_is_woo_variations_query($sfid)){

			//$post_ids = array_unique($post_ids); //so no duplicates
			$replacements = $this->woo_result_ids_map;
			foreach ($post_ids as $key => $value) {
				if (isset($replacements[$value])) {
					$post_ids[$key] = $replacements[$value];
				}
			}
			$post_ids = array_unique($post_ids); //so no duplicates
		}

		return $post_ids;
	}

	/* not in use */
	public function sf_query_cache_count_id_numbers($post_ids, $sfid)
	{
		if($this->sf_woocommerce_is_woo_variations_query($sfid)){

			$replacements = $this->woo_result_ids_map;
			foreach ($post_ids as $key => $value) {
				if (isset($replacements[$value])) {
					$post_ids[$key] = $replacements[$value];
				}
			}
			$post_ids = array_unique($post_ids); //so no duplicates

		}

		return $post_ids;
	}

	//this is the last stage to modify the query, it doesn't modify anything relating to auto count or hte cache, only
	//the main query which is holding the actual results
	public function sf_beaver_themer_pre_get_posts($query,  $sfid) {

		if(!class_exists('FLThemeBuilderLoader')){
			return $query;
		}

		if(!$query->is_main_query()) {
			return $query;
		}

		if(isset($query->query_vars['search_filter_id'])){
			if($query->get("paged")==1){
				$query->set("paged", 0);
			}
		}

		return $query;

	}
	public function sf_woocommerce_pre_get_posts($query,  $sfid) {

		if (!$this->is_woo_enabled()) {
			return $query;
		}

		$is_shop = false;
		if(function_exists("is_shop")) {
			$is_shop = is_shop();
		}

		//is_shop is not always true for product attributes / archives
		//so we need to detect if we are one of those
		global $searchandfilter;
		$enable_taxonomy_archives = $searchandfilter->get($sfid)->settings("enable_taxonomy_archives");

		if(($enable_taxonomy_archives==1) && (Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type('product', false))){

			$sf_current_query  = $searchandfilter->get($sfid)->current_query();
			$term = $searchandfilter->get_queried_object();
			$taxonomy = $term->taxonomy;

			//exclude current tax archive as a filter when checking "is_filtered"
			if(!$sf_current_query->is_filtered(array('_sft_'.$taxonomy))){
				$is_shop = true;
			}
		}

		if($is_shop) {
			//in woocommerce, don't set paged for page 1 - otherwise page description will be hidden
			if($query->get("paged")==1){
				$query->set("paged", null);
			}
		}

		//make sure post type is "product" only, not with variations, otherwise,
		//they will show in the results (if the variation ID has not been converted to its parent ID yet)
		if($this->sf_woocommerce_is_woo_variations_query($sfid)){
			$query->set("post_type", "product");
		}

		return $query;
	}
	public function sf_woocommerce_query_args($query_args,  $sfid)
	{
		if (!$this->is_woo_enabled()) {
			return $query_args;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		//make sure this search form is tyring to use woocommerce
		if($sf_inst->settings("display_results_as")=="custom_woocommerce_store"){

			$enable_taxonomy_archives = $sf_inst->settings("enable_taxonomy_archives");

			if(($enable_taxonomy_archives==1) && (Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type('product', false))){

				//if its using tax archive, and we're on a tax archive, make sure we don't include the current tax  in `is_filtered` before applying WC is_filtered

				$sf_current_query  = $searchandfilter->get($sfid)->current_query();
				$term = $searchandfilter->get_queried_object();
				$taxonomy = $term->taxonomy;

				//exclude current tax archive as a filter when checking "is_filtered"
				if(($sf_current_query->is_filtered(array('_sft_'.$taxonomy))) || (!empty($sf_current_query->get_search_term())) ){
					add_filter('woocommerce_is_filtered', array($this, 'sf_woocommerce_is_filtered'));
				}
			}
			else{
				$sf_current_query  = $sf_inst->current_query();
				if(($sf_current_query->is_filtered())||(!empty($sf_current_query->get_search_term()))){
					add_filter('woocommerce_is_filtered', array($this, 'sf_woocommerce_is_filtered'));
				}
			}




			return $query_args;
		}

		return $query_args;
	}

	//public function sf_edd_fes_field_save_frontend($field, $save_id, $value, $user_id)
	public function sf_edd_fes_field_save_frontend($field, $save_id, $value)
	{
		//FES has an issue where the same filter is used but with 3 args or 4 args
		//if the field is a digit, then actually this is the ID

		$post_id = 0;
		if(ctype_digit($field))
		{
			$post_id = $field;
		}
		else if(ctype_digit($save_id))
		{
			$post_id = $save_id;
		}

		//do_action('search_filter_update_post_cache', $save_id);
	}
	public function sf_edd_fes_submission_form_published($post_id)
	{
		do_action('search_filter_update_post_cache', $post_id);
	}
	public function sf_woocommerce_filter_settings_save($settings,  $sfid)
	{
		//make sure this search form is tyring to use woocommerce
		if(isset($settings['display_results_as']))
		{
			//if($settings["display_results_as"]=="custom_woocommerce_store"){
			if($this->sf_woocommerce_is_woo_variations_query($sfid)){

				$settings['treat_child_posts_as_parent'] = 1;
			}
			else
			{
				$settings['treat_child_posts_as_parent'] = 0;
			}
		}

		return $settings;
	}

	/* EDD integration */

	public function edd_prep_downloads_sf_query($query, $atts) {

		return $query;
	}


	/* pollylang integration */
	//tells polylang that the post type `search-filter-widget` should be translatable
	public function pll_sf_add_translations($types, $hide){

		$types['search-filter-widget'] = 'search-filter-widget';
		return $types;
	}
	public function pll_sf_get_translations($types, $hide){

		$this->polylang_post_types = $types;
		return $types;
	}

	public function sf_poly_query_args($query_args, $sfid) {

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		if(Search_Filter_Helper::has_polylang()){

			//manually set language of our query, based on the lang of the S&F post (this is because ajax requests don't get a lang set, which only occurs on this display method
			//if($sf_inst->settings("display_results_as")=="shortcode") {

				$terms     = wp_get_post_terms( $sfid, 'language', array( "fields" => "all" ) );
				$terms_arr = array(); //this shold only ever have 1 value, as a post can only be in 1 lang at a time

				//but lets support it anyway
				foreach ( $terms as $term ) {
					array_push( $terms_arr, $term->slug );
				}

				//check to see if hte language we are searching, is being handles by polylang
				$post_types_arr = $sf_inst->settings("post_types");
				$post_types = array();
				if(is_array($post_types_arr)){
					$post_types = array_keys($post_types_arr);
				}

				$polylang_post_types = array_keys($this->polylang_post_types);

				$intersect = array_intersect($post_types, $polylang_post_types);
				if (count($intersect) > 0) {
					$query_args['lang'] = implode( "," , $terms_arr  );
				}
				//otherwise, don't set the lang of course, because the posts certainly won't have a lang attribute (yet)
				//there will be problems however, if a user is searching multiple post types, some of which are handles by polylang
				//some not, in this case, all language must be set to be handled by polylang for consistency

			//}
		}


		return $query_args;
	}

	public function poly_lang_sf_edit_cache_query_args($query_args,  $sfid) {

		if(Search_Filter_Helper::has_polylang())
		{
			/*$langs = array();
			global $polylang;
			foreach ($polylang->model->get_languages_list() as $term)
			{
				array_push($langs, $term->slug);
			}

			//$query_args["lang"] = $langs;
			//$query_args["lang"] = implode(",", $langs);
			*/
			//this sets a query for all languages (seems to changes quite often, the above was the old method of include all languages)
			$query_args["lang"] = '';
		}

		return $query_args;
	}

	public function sf_pre_get_posts_admin_cache($query,  $sfid) {

		if(Search_Filter_Helper::has_polylang()) {
			$query->set( "lang", "all" );
		}

		return $query;
	}


	function add_url_args($url, $str)
	{
		$query_arg = '?';
		if (strpos($url,'?') !== false) {

			//url has a question mark
			$query_arg = '&';
		}

		return $url.$query_arg.$str;

	}
	public function pll_sf_rewrite_args($args) {

		//if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		if(Search_Filter_Helper::has_polylang())
		{
			$args['lang'] = '';
		}

		return $args;
	}
	public function pll_sf_archive_slug_rewrite($newrules,  $sfid, $page_slug) {

		//if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		if(Search_Filter_Helper::has_polylang())
		{
			//takes into account language prefix
			//$newrules = array();
			$newrules["([a-zA-Z0-9_-]+)/".$page_slug.'$'] = 'index.php?&sfid='.$sfid; //regular plain slug
		}

		return $newrules;
	}
	public function pll_sf_ajax_results_url($ajax_url,  $sfid) {

		if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		{


			global $searchandfilter;
			$sf_inst = $searchandfilter->get($sfid);

			//these are the display results methods that use the current url for ajax
			// we want to do it this way, to allow other display methods (like VC / ajax integration) to carry on working
			$retain_results_methods = array("archive", "post_type_archive", "custom", "custom_woocommerce_store", "custom_edd_store", "bb_posts_module", "divi_post_module", "divi_shop_module", "elementor_posts_element");
			// todo - need to add extensions via external plugin


			if(in_array($sf_inst->settings("display_results_as"), $retain_results_methods)){
				//so don't modify the ajax url, it will have the lang in there
				return $ajax_url;
			}
			else {
				//if we are doing an ajax request, make sure we are including the proper home url, with lang `/en`
				//allow sf_data to remain the same value
				$sf_data = "all";
				$url_parts = parse_url($ajax_url);
				if(isset($url_parts['query'])){
					parse_str($url_parts['query'], $url_vars);
					if(isset($url_vars['sf_data'])){
						$sf_data = $url_vars['sf_data'];
					}
				}

				//if ( $sf_inst->settings( "display_results_as" ) == "shortcode" ) {
					if ( get_option( 'permalink_structure' ) ) {
						$home_url = trailingslashit( pll_home_url() );
						$ajax_url = $this->add_url_args( $home_url, "sfid=$sfid&sf_action=get_data&sf_data=$sf_data" );

					} else {
						$ajax_url = $this->add_url_args( pll_home_url(), "sfid=$sfid&sf_action=get_data&sf_data=$sf_data" );
					}
				/*} else {

				}*/
			}

		}

		return $ajax_url;
	}
	public function pll_sf_archive_results_url($results_url,  $sfid, $page_slug = '') {


		if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		{
			$results_url = pll_home_url(pll_current_language());

			if(get_option('permalink_structure'))
			{
				if($page_slug!="")
				{
					$results_url = trailingslashit(trailingslashit($results_url).$page_slug);
				}
				else
				{
					$results_url = trailingslashit($results_url);
					$results_url = $this->add_url_args( $results_url, "sfid=$sfid");
				}
			}
			else
			{
				if (strpos($results_url, '?') !== false) {
					$param = "&";
				}
				else{
					$param = "?";
				}
				$results_url .= $param."sfid=".$sfid;

			}
		}

		return $results_url;
	}

	public function pll_sf_form_url($results_url,  $sfid, $page_slug = '') {

		if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		{
			$results_url = pll_home_url(pll_current_language());

			if(get_option('permalink_structure'))
			{
				$results_url = trailingslashit($results_url);
				$results_url = $this->add_url_args( $results_url, "sfid=$sfid");
				$results_url = $this->add_url_args( $results_url, "sf_action=get_data");
				$results_url = $this->add_url_args( $results_url, "sf_data=form");


			}
			else
			{
				$results_url = $this->add_url_args( $results_url, "sfid=$sfid");
				$results_url = $this->add_url_args( $results_url, "sf_action=get_data");
				$results_url = $this->add_url_args( $results_url, "sf_data=form");
				//$results_url .= "&sfid=".$sfid;
			}
		}


		return $results_url;
	}




	/* Relevanssi integration */

	public function remove_relevanssi_defaults()
	{
		//relevanssi free + older premium
		remove_filter('the_posts', 'relevanssi_query');
		remove_filter('posts_request', 'relevanssi_prevent_default_request', 9);
		remove_filter('posts_request', 'relevanssi_prevent_default_request');

		//new premium
		remove_filter('the_posts', 'relevanssi_query', 99);
		remove_filter('posts_request', 'relevanssi_prevent_default_request', 10);

		remove_filter('query_vars', 'relevanssi_query_vars');
	}

	public function relevanssi_filter_query_args($query_args, $sfid) {

		//always remove normal relevanssi behaviour
		$this->remove_relevanssi_defaults();

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		if($sf_inst->settings("use_relevanssi")==1)
		{//ensure it is enabled in the admin

			if(isset($query_args['s']))
			{//only run if a search term has actually been set
				if(trim($query_args['s'])!="")
				{

					$search_term = $query_args['s'];
					$query_args['s'] = "";
				}
			}
		}

		return $query_args;
	}

	public function relevanssi_sort_result_ids($result_ids, $query_args, $sfid) {

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		if(count($result_ids)==1)
		{
			if(isset($result_ids[0]))
			{
				if($result_ids[0]==0) //it means there were no search results so don't even bother trying to change the sorting
				{
					return $result_ids;
				}
			}
		}

		if(($sf_inst->settings("use_relevanssi")==1)&&($sf_inst->settings("use_relevanssi_sort")==1))
		{//ensure it is enabled in the admin

			if(isset($this->relevanssi_result_ids['sf-'.$sfid]))
			{
				$return_ids_ordered = array();

				$ordering_array = $this->relevanssi_result_ids['sf-'.$sfid];

				$ordering_array = array_flip($ordering_array);

				foreach ($result_ids as $result_id) {
					$return_ids_ordered[$ordering_array[$result_id]] = $result_id;
				}

				ksort($return_ids_ordered);

				return $return_ids_ordered;
			}
		}

		return $result_ids;
	}


	public function relevanssi_add_custom_filter($ids_array, $query_args, $sfid) {

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		$this->remove_relevanssi_defaults();

		if($sf_inst->settings("use_relevanssi")==1)
		{//ensure it is enabled in the admin

			if(isset($query_args['s']))
			{//only run if a search term has actually been set

				if(trim($query_args['s'])!="")
				{
					//$search_term = $query_args['s'];

					if (function_exists('relevanssi_do_query'))
					{
						$expand_args = array(
							'posts_per_page' 			=> -1,
							'paged' 						=> 1,
							'fields' 					=> "ids", //relevanssi only implemented support for this in 3.5 - before this, it would return the whole post object

							//'orderby' 					=> "", //remove sorting
							'meta_key' 					=> "",
							//'order' 						=> "asc",

							/* speed improvements */
							'no_found_rows' 				=> true,
							'update_post_meta_cache' 	=> false,
							'update_post_term_cache' 	=> false

						);

						$query_args = array_merge($query_args, $expand_args);

						//$query_args['orderby'] = "relevance";
						//$query_args['order'] = "asc";
						unset($query_args['order']);
						unset($query_args['orderby']);

						// The Query
						$query_arr = new WP_Query( $query_args );
						relevanssi_do_query($query_arr);

						$ids_array = array();
						if ( $query_arr->have_posts() ){

							foreach($query_arr->posts as $post)
							{
								$postID = 0;

								if(is_numeric($post))
								{
									$postID = $post;
								}
								else if(is_object($post))
								{
									if(isset($post->ID))
									{
										$postID = $post->ID;
									}
								}

								if($postID!=0)
								{
									array_push($ids_array, $postID);
								}


							}
						}

						if($sf_inst->settings("use_relevanssi_sort")==1)
						{
							//keep a copy for ordering the results later
							$this->relevanssi_result_ids['sf-'.$sfid] = $ids_array;

							//now add the filter
							add_filter( 'sf_apply_filter_sort_post__in', array( $this, 'relevanssi_sort_result_ids' ), 10, 3);
						}

						return $ids_array;
					}
				}
			}
		}

		return array(false); //this tells S&F to ignore this custom filter
	}
}

<?php
/**
 * Search & Filter Pro
 * 
 * @package   class Search_Filter_Active_Query
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */
 		
//class to grab the current query performed with the search, such as taxonomies highlighted, number ranges and post meta selections

class Search_Filter_Active_Query {
	
	public $sfid 					= 0;
	private $is_set 				= false;
	private $query_array 			= array();
	private $form_fields 			= array();
	private $query_str   			= -1;

	public function __construct($plugin_slug, $sfid, $settings, $fields)
	{
		global $wpdb;
		
		$this->plugin_slug = $plugin_slug;
		
		if($this->sfid == 0)
		{
			$this->sfid = $sfid;
			$this->form_fields = $fields;
			$this->form_settings = $settings;
		}
		
		$this->cache_table_name = $wpdb->prefix . 'search_filter_cache';
		$this->term_results_table_name = $wpdb->prefix . 'search_filter_term_results';
	}

	public function get_field_values($field_name)
	{
		$this->set_fields_array();
		
		if(isset($this->field_values[$field_name]))
		{
			return $this->field_values[$field_name];
		}
		
		return array();
	}
	
	private function set_field_values_array()
	{
		$field_values = array();
		
		$current_query_arr = $this->get_array();
		
		foreach($current_query_arr as $field_name => $field)
		{
			
			if(isset($field['active_terms']))
			{
				$field_values[$field_name] = array();
				
				foreach($field['active_terms'] as $active_term)
				{
					array_push($field_values[$field_name], $active_term['value']);
				}
			}
		}
		
		$this->field_values = $field_values;

		//perhaps we should keep the inherited stuff sepearte? And add an option to the functions to merge with regular defaults
		$this->set_inherited_defaults();
		
	}
	
	private function set_inherited_defaults()
	{
		$inherit_current_post_type_archive = "";
		if(isset($this->form_settings['inherit_current_post_type_archive']))
		{
			$inherit_current_post_type_archive = $this->form_settings['inherit_current_post_type_archive'];
		}
		
		$inherit_current_taxonomy_archive = "";
		if(isset($this->form_settings['inherit_current_taxonomy_archive']))
		{
			$inherit_current_taxonomy_archive = $this->form_settings['inherit_current_taxonomy_archive'];
		}
		
		$inherit_current_author_archive = "";
		if(isset($this->form_settings['inherit_current_author_archive']))
		{
			$inherit_current_author_archive = $this->form_settings['inherit_current_author_archive'];
		}
		
		if($inherit_current_post_type_archive=="1")
		{
			if((is_post_type_archive()) && ((!is_tax()) && (!is_category()) && (!is_tag())))
			{
				$post_type_slug = get_post_type();

				if ( $post_type_slug )
				{
					$this->field_values['post_types'] = array($post_type_slug);
				}

			}
			else if(is_home())
			{//this is the same as the "posts" archive
				
			}
		}
		
		if($inherit_current_taxonomy_archive=="1")
		{
			global $searchandfilter;
			$term =	$searchandfilter->get_queried_object();
			
			if(is_tax())
			{
				$this->field_values[SF_TAX_PRE.$term->taxonomy] = array($term->slug);

			}
			else if(is_category())
			{
				$this->field_values[SF_TAX_PRE.'category'] = array($term->slug);

			}
			else if(is_tag())
			{
				$this->field_values[SF_TAX_PRE.'post_tag'] = array($term->slug);
			}
		}

		
		if($inherit_current_author_archive=="1")
		{
			if(is_author())
			{
				global $searchandfilter;
				$author = $searchandfilter->get_queried_object();
				
				$this->field_values['authors'] = array($author->user_nicename);
			}

		}
		
	}
	
	private function set_fields_array()
	{
		//the the object has already been set up don't bother setting up again
		if($this->is_set)
		{
			return;
		}
		
		//now set flag to true so we can't come here again
		$this->is_set = true;

		//now loop through URL vars and grab the user selection
		
		//grab search term for prefilling search input
		
		if(isset($_GET['_sf_s']))
		{
			$this->searchterm = esc_attr(trim(stripslashes($_GET['_sf_s'])));
		}
		
		
		$taxs = array();

		if(isset($this->form_fields))
		{
			foreach($this->form_fields as $field_name => $field)
			{
				$field_name_get = str_replace(array(" ", "."), "_", $field_name); //replace space with `_` as this is done anyway - spaces are not allowed in GET variable names, and are automatically converted by server/browser to `_`

				$key = $field_name;
				
				if(isset($_GET[$field_name_get]))
				{
					if (strpos($key, SF_TAX_PRE) === 0)
					{
						$tax_object = $this->get_taxonomy($key);
						$this->query_array[$key] = $tax_object;	
					}
					else if (strpos($key, SF_META_PRE) === 0)
					{
						$meta_data = $this->get_post_meta($key);
						$this->query_array[$key] = $meta_data;
						
					}
				}
			}
		}
		
		if(isset($_GET['authors']))
		{
			$author = $this->get_author("authors");
			$this->query_array["authors"] = $author;
		}
		
		if(isset($_GET['post_types']))
		{
			$post_type = $this->get_post_type('post_types');
			$this->query_array['post_types'] = $post_type;			
		}
		
		if(isset($_GET['post_date']))
		{
			$post_date = array("","");
			
			$post_date = array_map('urldecode', explode("+", esc_attr(urlencode($_GET['post_date']))));
			if(count($post_date)==1)
			{
				$post_date[1] = "";
			}
			
			$this->query_array[SF_FPRE.'post_date']['active_terms'] = array();
			
			foreach($post_date as $a_post_date)
			{
				$active_terms = array("value"=>urlencode($a_post_date));
				array_push($this->query_array[SF_FPRE.'post_date']['active_terms'], $active_terms);
			}
		}
		
		
		if(isset($_GET['sort_order']))
		{
			$sort_orders = array();
			$sort_orders = explode(",",esc_attr($_GET['sort_order']));

			$this->query_array[SF_FPRE.'sort_order']['active_terms'] = array();
			
			foreach($sort_orders as $sort_order)
			{
				$sort_order = str_replace(" ", "+", $sort_order);
				//$active_terms = (array("value"=>urlencode($sort_order)));
				$active_terms = (array("value"=>($sort_order)));
				array_push($this->query_array[SF_FPRE.'sort_order']['active_terms'], $active_terms);
			}			
		}
		
		//results per page
		if(isset($_GET['_sf_ppp']))
		{
			$active_term = (array("value" => (int)$_GET['_sf_ppp']));
			$this->query_array[SF_FPRE.'ppp']['active_terms'] = array($active_term);
		}
		
		$this->set_field_values_array(); //this is an array with only the values from the URL, used mostly for setting defaults in the search form
		
	}
	
	


	public function get_taxonomy_terms_string($sf_taxonomy_key, $term_delim_arr = array(", "), $show_if_not_selected = true, $use_smart_labels = true)
	{
		$taxonomy = $this->get_taxonomy($sf_taxonomy_key);

		$active_terms = $taxonomy['active_terms'];
		$no_active_terms = count($active_terms);

		
		$term_string = "";

		$taxonomy_string = "";

		if($no_active_terms==0)
		{
			if($show_if_not_selected)
			{
				$term_string = $taxonomy['all_items_label'];
			}
		}
		else
		{
			//$active_term_names = array_map(function($el){ return $el['name']; }, $active_terms);
			$term_delim = "";
			if(count($term_delim_arr)==1)
			{//then use the same for both and / or , scenarios
				$term_delim = $term_delim_arr[0];
			}
			
			$term_string = implode($term_delim, array_map(array($this, 'implode_name'), $active_terms));
			
			

		}

		if($term_string!="")
		{
			$taxonomy_string = $term_string;
		}

		return $taxonomy_string;
	}

	public function implode_name($term)
	{
		return $term['name'];		
	}
	
	public function get_fields_html($field_names, $args = array())
	{
		$fields_strs = array();

		$defaults = array(

			"str" 					=> '%1$s: %2$s',
			"delim" 				=> array(", ", " - "), //first value is for regular delim, second value is for range fields
			"field_delim"			=> '<br />',
			"show_all_if_empty"		=> true,
			"use_smart_lables" 		=> true,
			"labels"		 		=> array()

		);


		if(is_array($args))
		{
			$fields_args = array_replace($defaults, $args);
		}
		else
		{
			$fields_args = $defaults;
		}
		

		foreach($field_names as $field_name)
		{
			if($field_name)
			{
				$field_args = $fields_args;
				
				$field_args['labels'] = array();

				if(isset($fields_args['labels']))
				{
					if(isset($fields_args['labels'][$field_name]))
					{

						$field_args['labels'] = $fields_args['labels'][$field_name];
						
					}
				}

				$field_str = $this->get_field_string($field_name, $field_args);
				if($field_str!="")
				{
					array_push($fields_strs, $field_str);
				}
			}
		}


		return implode($fields_args['field_delim'], $fields_strs);

	}

	public function get_field_string($sf_field_key, $args = array())
	{
		$defaults = array(

			"str" 					=> '%1$s: %2$s',
			"delim" 				=> array(", ", " - "),
			"show_all_if_empty"		=> true,
			"use_smart_lables" 		=> true,
			"labels"				=> array(
										"name" 				=> "",
										"singular_name" 	=> "",
										"all_items_label"	=> ""
									)

		);

		$field_args = array_replace($defaults, $args);

		$field_as_string = "";

		$is_choice_field = true;

		if (strpos($sf_field_key, SF_TAX_PRE) === 0)
		{
			$field = $this->get_taxonomy($sf_field_key);
		}
		else if (strpos($sf_field_key, SF_META_PRE) === 0)
		{
			if(!isset($this->form_fields[$sf_field_key]))
			{
				return;
			}

			$post_meta_field = $this->form_fields[$sf_field_key];

			if($post_meta_field['meta_type']!="choice")
			{
				$field_args['use_smart_lables'] = false;
				$is_choice_field = false;
			}

			$field = $this->get_post_meta($sf_field_key, $field_args['labels']);

		}
		else if($sf_field_key=="_sf_authors")
		{
			$field = $this->get_author($sf_field_key, $field_args['labels']);
		}
		else if($sf_field_key=="_sf_post_types")
		{
			$field = $this->get_post_type($sf_field_key, $field_args['labels']);
		}
		else
		{
			return;
		}

		//calculate delims
		if(!is_array($field_args['delim']))
		{
			$delim = $field_args['delim'];
		}
		else
		{
			if(count($field_args['delim'])>0)
			{
				$delim_arr = $field_args['delim'];
			}
			else
			{
				$delim_arr = $defaults['delim'];
			}

			if(count($delim_arr)==1)
			{
				$delim = $delim_arr[0];
			}
			else
			{
				if($is_choice_field)
				{
					$delim = $delim_arr[0];
				}
				else
				{
					$delim = $delim_arr[1];
				}
			}

		}





		$active_terms = $field['active_terms'];
		$no_active_terms = 0;
		if(is_array($active_terms)){
			$no_active_terms = count($active_terms);
		}

		$taxonomy_label = $field['name'];
		$term_string = "";

		if($field_args['use_smart_lables'])
		{
			if($no_active_terms==1)
			{
				$taxonomy_label = $field['singular_name'];
			}
		}

		$field_string = "";
		$term_string = "";
		
		if($no_active_terms==0)
		{
			if($field_args['show_all_if_empty'])
			{
				$term_string =$field['all_items_label'];
			}
		}
		else
		{
			$term_string = implode($delim, array_map(array($this, 'implode_name'), $active_terms));
		}
		
		if(($taxonomy_label!="")&&($term_string!=""))
		{
			$field_as_string = sprintf($field_args['str'], $taxonomy_label, $term_string);
		}
		
		return $field_as_string;
	}
		
	public function get_search_term_field()
	{
		
		if(isset($_GET['_sf_s']))
		{
			$search_term = esc_attr(trim(stripslashes($_GET['_sf_s'])));
		}
		
		return array("value", $search_term);
	}
	
	public function get_sort_order_value()
	{
		$active_values = array();
		
		$sf_get_key = "sort_order";
		if(isset($_GET[$sf_get_key]))
		{
			$sort_order_str = esc_attr(trim(urlencode($_GET[$sf_get_key])));

			//$sort_order = (preg_split("/[,\+ ]/", $sort_order_str)); //explode with 2 delims
			$sort_orders = explode( ',', $sort_order_str );
			
			foreach ($sort_orders as $sort_order)
			{
				array_push($active_values, $sort_order);
			}
		}
	}
	public function get_sort_order($labels = array())
	{
		global $wp_query;
		global $wpdb;

		$field_obj = array();
		
		$sf_get_key = "sort_order";
		 
		$label_defaults = array(

			"name" 					=> __('Sort Order', $this->plugin_slug),
			"singular_name"			=> __('Sort Order', $this->plugin_slug),
			"all_items_label"		=> __('Sort Order', $this->plugin_slug)

		);


		if((is_array($labels))&&(!empty($labels)))
		{
			$labels = array_replace($label_defaults, $labels);
		}
		else
		{
			$labels = $label_defaults;
		}

		$field_obj['name'] = $labels['name'];
		$field_obj['singular_name'] = $labels['singular_name'];
		$field_obj['all_items_label'] = $labels['all_items_label'];
		$field_obj['type'] = "post_type";
		
		$field_obj['active_terms'] = array();
		

		if(isset($_GET[$sf_get_key]))
		{
			$sort_order_str = esc_attr(trim(urlencode($_GET[$sf_get_key])));

			//$sort_order = (preg_split("/[,\+ ]/", $sort_order_str)); //explode with 2 delims
			$sort_orders = explode( ',', $sort_order_str );
			
			foreach ($sort_orders as $sort_order)
			{
				$sort_order_option = array();
				$sort_order_option["name"] = $sort_order;
				$sort_order_option["value"] = $sort_order;

				array_push($field_obj['active_terms'], $sort_order_option);
			}
		}

		return $field_obj;
	}
	
	
	public function get_post_meta($sf_post_meta_key, $labels = array())
	{
		global $wp_query;
		global $wpdb;

		$post_meta_obj = array();

		//remove sf prefix fom meta
		$post_meta_key = substr($sf_post_meta_key, strlen(SF_META_PRE));
		

		$post_meta_obj['name'] = isset($labels['name']) ? $labels['name'] : "";
		$post_meta_obj['singular_name'] = isset($labels['singular_name']) ? $labels['singular_name'] : "";
		$post_meta_obj['all_items_label'] = isset($labels['all_items_label']) ? $labels['all_items_label'] : "";
		$post_meta_obj['type'] = "post_meta";
		
		$post_meta_obj['active_terms'] = array();
		
		$sf_post_meta_key_get = str_replace(array(" ", "."), "_", $sf_post_meta_key); //replace space with `_` as this is done anyway - spaces are not allowed in GET variable names, and are automatically converted by server/browser to `_`
		
		if(isset($_GET[$sf_post_meta_key_get]))
		{
			if(isset($this->form_fields[$sf_post_meta_key]))
			{
				$post_meta_field = $this->form_fields[$sf_post_meta_key];
				
				if($post_meta_field['meta_type']=="choice")
				{
					$post_meta_options_list = $post_meta_field['meta_options'];

					$getval = stripslashes($_GET[$sf_post_meta_key_get]);
					
					if($post_meta_field["operator"]=="or")
					{
						$ochar = "-,-";
					}
					else
					{
						$ochar = "-+-";
						$replacechar = "- -";
						
						$getval = str_replace($replacechar, $ochar, $getval);
					}
					
					$post_meta_values = explode($ochar, ($getval));	
					
					foreach ($post_meta_values as $post_meta_value)
					{
						$tax_term = array();
						
						$choice_get_option_mode = 'manual';
						$choice_is_acf = 0;
						if(isset($post_meta_field['choice_get_option_mode']))
						{
							$choice_get_option_mode = $post_meta_field['choice_get_option_mode'];
							$choice_is_acf = $post_meta_field['choice_is_acf'];
						}
												
						if($choice_get_option_mode=="manual")
						{
							$post_meta_option_index = $this->search_meta_option_by_value($post_meta_value, $post_meta_options_list);
							
							
							if(isset($post_meta_options_list[$post_meta_option_index]))
							{
								$post_meta_option = array();
								$post_meta_option_full = $post_meta_options_list[$post_meta_option_index];

								
								$post_meta_option["name"] = $post_meta_option_full['option_label'];
								$post_meta_option["value"] = $post_meta_option_full['option_value'];
							}
						}
						else if($choice_get_option_mode=="auto")
						{
							if($choice_is_acf==0)
							{
								$post_meta_option = array();
								$post_meta_option["name"] = $post_meta_value;
								$post_meta_option["value"] = $post_meta_value;
							}
							else if($choice_is_acf==1)
							{
								$post_meta_option = array();
								$post_meta_option["name"] = $this->get_acf_option_label($sf_post_meta_key, $post_meta_key, $post_meta_value);
								$post_meta_option["value"] = $post_meta_value;
								
							}
						}
						
						if(!empty($post_meta_option))
						{
							$use_auto_count = 0;
							if(isset($this->form_settings['enable_auto_count']))
							{
								$use_auto_count = $this->form_settings['enable_auto_count'];
							}
							
							if($use_auto_count==1)
							{
								global $searchandfilter;
								$searchform = $searchandfilter->get($this->sfid);
								
								$post_meta_option["count"] = $searchform->get_count_var($sf_post_meta_key, $post_meta_option["value"]);
							}
							
							array_push($post_meta_obj['active_terms'], $post_meta_option);
						}

					}
				}
				else if($post_meta_field['meta_type']=="number")
				{
					$post_meta_values = array();
					
					$post_meta_values = (preg_split("/[,\+ ]/", esc_attr(($_GET[$sf_post_meta_key_get])))); //explode with 2 delims
					
					foreach($post_meta_values as $post_meta_value)
					{
						$post_meta_option = array();

						$post_meta_option["name"] = $post_meta_field['range_value_prefix'].$post_meta_value.$post_meta_field['range_value_postfix'];
						$post_meta_option["value"] = $post_meta_value;

						array_push($post_meta_obj['active_terms'], $post_meta_option);
					}
					
				}
				else if ($post_meta_field['meta_type']=="date") {

					$post_meta_values = array();
					
					$post_meta_values = array_map('urldecode', explode("+", esc_attr(urlencode($_GET[$sf_post_meta_key_get]))));
					
					foreach($post_meta_values as $post_meta_value)
					{
						$post_meta_option = array();
						$post_meta_option["name"] = $post_meta_value;
						$post_meta_option["value"] = $post_meta_value;

						array_push($post_meta_obj['active_terms'], $post_meta_option);
					}
				}
			}
		}
		
		return $post_meta_obj;
		

	}
	private function get_acf_option_label($sf_post_meta_key, $post_meta_key, $post_meta_value)
	{
		$option_label = $post_meta_value;
		
		if(!function_exists('get_field_object'))
		{
			return $option_label;
		}
		
		$post_id = $this->find_post_id_with_field($sf_post_meta_key); //acf needs to have at least 1 post id with the post meta attached in order to lookup the rest of the field
		$field = get_field_object($post_meta_key, $post_id);
		
		
		
		if(isset($field['choices']))
		{
			$choices = $field['choices'];
			
			if(isset($choices[$post_meta_value]))
			{
				$option_label = $choices[$post_meta_value];
			}
		}
		
		return $option_label;
		
	}
	
	private function find_post_id_with_field($field_name)
	{
		global $wpdb;
		
		$field_options = $wpdb->get_results( 
			"
			SELECT field_value, result_ids
			FROM $this->term_results_table_name
			WHERE field_name = '$field_name' LIMIT 0,1
			"
		);
		
		foreach($field_options as $field_option)
		{
			
			$post_ids = explode(",", $field_option->result_ids);
			
			if(isset($post_ids[0]))
			{
				return $post_ids[0];
			}
		}
		
		return 0;
	}
	public function search_meta_option_by_value($value, $array) {
	   foreach ($array as $key => $val) {
	       if ($val['option_value'] === $value) {
	           return $key;
	       }
	   }
	   return null;
	}
	public function get_taxonomy($sf_taxonomy_key)
	{
		global $wp_query;
		global $wpdb;

		$taxonomy_obj = array();

		//remove sf prefix fom taxonomy
		$taxonomy_key = substr($sf_taxonomy_key, strlen(SF_TAX_PRE));
		
		//first get the taxonomy singular and plural label
		$taxonomy = get_taxonomy($taxonomy_key);

		if(!$taxonomy)
		{
			return false;
		}

		$taxonomy_obj['name'] = $taxonomy->labels->name;
		$taxonomy_obj['singular_name'] = $taxonomy->labels->singular_name;
		$taxonomy_obj['all_items_label'] = $taxonomy->labels->all_items;
		$taxonomy_obj['type'] = "taxonomy";
		
		$taxonomy_obj['active_terms'] = array();

		if(isset($_GET[$sf_taxonomy_key]))
		{
			$tax_values_str = esc_attr(trim($_GET[$sf_taxonomy_key]));

			$tax_term_slugs = (preg_split("/[,\+ ]/", $tax_values_str)); //explode with 2 delims

			foreach ($tax_term_slugs as $tax_term_slug)
			{
				$tax_term_full = get_term_by('slug', $tax_term_slug, $taxonomy_key);
				
				if($tax_term_full)
				{
					
					$tax_term = array();
					$tax_term["id"] = $tax_term_full->term_id;
					$tax_term["name"] = $tax_term_full->name;
					$tax_term["value"] = $tax_term_full->slug;
									
					$inherit_current_post_type_archive = "";
					if(isset($this->form_settings['inherit_current_post_type_archive']))
					{
						$inherit_current_post_type_archive = $this->form_settings['inherit_current_post_type_archive'];
					}
					
					$use_auto_count = 0;
					if(isset($this->form_settings['enable_auto_count']))
					{
						$use_auto_count = $this->form_settings['enable_auto_count'];
					}
					
					if($use_auto_count==1)
					{
						global $searchandfilter;
						$searchform = $searchandfilter->get($this->sfid);
						$tax_term["count"] = $searchform->get_count_var($sf_taxonomy_key, $tax_term_slug);
					}
					else
					{
						$tax_term["count"] = intval($tax_term_full->count);
					}
					
					array_push($taxonomy_obj['active_terms'], $tax_term);
				}

			}

			
		}
		return $taxonomy_obj;
		

	}

	public function get_post_type($sf_field_key, $labels = array())
	{
		global $wp_query;
		global $wpdb;

		$field_obj = array();

		$label_defaults = array(

			"name" 					=> __('Post Types', $this->plugin_slug),
			"singular_name"			=> __('Post Type', $this->plugin_slug),
			"all_items_label"		=> __('All Post Types', $this->plugin_slug)

		);


		if((is_array($labels))&&(!empty($labels)))
		{
			$labels = array_replace($label_defaults, $labels);
		}
		else
		{
			$labels = $label_defaults;
		}

		$field_obj['name'] = $labels['name'];
		$field_obj['singular_name'] = $labels['singular_name'];
		$field_obj['all_items_label'] = $labels['all_items_label'];
		$field_obj['type'] = "post_type";
		
		$field_obj['active_terms'] = array();

		
		if (strpos($sf_field_key, SF_FPRE) === 0)
		{
			$sf_get_key = substr($sf_field_key, strlen(SF_FPRE));
		}
		else
		{
			$sf_get_key = $sf_field_key;
		}

		if(isset($_GET[$sf_get_key]))
		{
			$post_type_values_str = esc_attr(trim($_GET[$sf_get_key]));

			$post_type_slugs = (preg_split("/[,\+ ]/", $post_type_values_str)); //explode with 2 delims

			foreach ($post_type_slugs as $post_type_slug)
			{
				$post_type_object = get_post_type_object($post_type_slug);

				$post_type_term = array();
				$post_type_term["name"] = $post_type_object->labels->name;
				$post_type_term["value"] = $post_type_slug;

				array_push($field_obj['active_terms'], $post_type_term);

			}

			
		}

		return $field_obj;
	}

	public function get_author($sf_field_key, $labels = array())
	{
		global $wp_query;
		global $wpdb;

		$field_obj = array();
		
		
		$label_defaults = array(

			"name" 					=> __('Authors', $this->plugin_slug),
			"singular_name"			=> __('Author', $this->plugin_slug),
			"all_items_label"		=> __('All Authors', $this->plugin_slug)

		);
		
		if((is_array($labels))&&(!empty($labels)))
		{
			$labels = array_replace($label_defaults, $labels);
		}
		else
		{
			$labels = $label_defaults;
		}

		$field_obj['name'] = $labels['name'];
		$field_obj['singular_name'] = $labels['singular_name'];
		$field_obj['all_items_label'] = $labels['all_items_label'];
		$field_obj['type'] = "post_type";
		
		$field_obj['active_terms'] = array();

		if (strpos($sf_field_key, SF_FPRE) === 0)
		{
			$sf_get_key = substr($sf_field_key, strlen(SF_FPRE));
		}
		else
		{
			$sf_get_key = $sf_field_key;
		}

		if(isset($_GET[$sf_get_key]))
		{
			
			$field_values_str = esc_attr(trim($_GET[$sf_get_key]));

			$field_vals = (preg_split("/[,\+ ]/", $field_values_str)); //explode with 2 delims

			foreach ($field_vals as $field_val)
			{
				$field_object = get_user_by('slug', esc_attr($field_val));
				
				$field_term = array();
				$field_term["id"] = $field_object->ID;
				//$field_term["name"] = $field_object->user_nicename;
				$field_term["name"] = $field_object->display_name;
				$field_term["value"] = $field_object->user_nicename;

				array_push($field_obj['active_terms'], $field_term);

			}

			
		}

		return $field_obj;
	}

	public function get_array()
	{
		
		$this->set_fields_array();

		return $this->query_array;
	}
	public function get_query_str()
	{

        if($this->query_str===-1) {

            $this->query_str = "";

            //$_get is best way to get the actual get value, we want to preserve things like spaces, plus signs etc between the URLs
            $query_parts = array();
            $exclude_list = array("sf_data", "sf_action", "sfid", "page_id");

            foreach ($_GET as $get_key => $get_val) {

            	if ( ( gettype($get_key)==="string" ) && ( gettype($get_val) === "string" ) ) {
		            if ( ! in_array( $get_key, $exclude_list ) ) {
			            $query_param = $get_key . "=" . $get_val;
			            array_push( $query_parts, $query_param );
		            }
	            }
            }

            //now we have the $_get values, but there could still be some values set in the form not from $_GET url, so deal with them here
            $this->set_fields_array();

            foreach ($this->field_values as $field_name => $field_values) {
                if (!isset($_GET[$field_name])) {
                    $query_param = $field_name . "=" . implode("|", $field_values);
                    array_push($query_parts, $query_param);
                }
            }

            $this->query_str = implode("&", $query_parts);
        }

        return $this->query_str;

	}
	
	public function get_search_term()
	{
		$search_term = "";
		
		if(isset($_GET['_sf_s']))
		{
			$search_term = esc_attr(trim(stripslashes($_GET['_sf_s'])));
		}
		
		return $search_term;
		
	}
	
	public function is_filtered($exclude_items = array())
	{
		$filtered_array = $this->get_array();

		foreach($exclude_items as $exclude_item){

			if(isset($filtered_array[$exclude_item])){
				unset($filtered_array[$exclude_item]);
			}
		}

		if(empty($filtered_array))
		{
			return false;
		}
		else
		{
			return true;
		}
		
	}
	
}

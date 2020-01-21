<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Author
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Field_Author extends Search_Filter_Field_Base {
	
	
	
	public function get($field_data)
	{
		$field_name = SF_FPRE."author";
		
		$fields_defaults = $this->current_query->get_field_values("authors");
		
		if(count($fields_defaults)==0)
		{
			$fields_defaults = array("");
		}
		
		$returnvar = "";
		
		
		//set defaults so no chance of any php errors when accessing un init vars
		$defaults = array(
			'input_type'				=> '',
			'optioncount'				=> '',
			'exclude_admin'				=> '',
			'show_fullname'				=> '',
			'order_by'					=> '',
			'order_dir'					=> '',
			'hide_empty'				=> '',
			'operator'					=> '',
			'all_items_label'			=> '',
			'accessibility_label'		=> '',
			'exclude'					=> '',
			'combo_box'					=> '',
			'no_results_message'		=> '',
			'show_default_option_sf' 	=> false,
			'show_count_format_sf' 		=> "inline",
		);
		//set defaults so no chance of any php errors when accessing un init vars
		$args = array_replace($defaults, $field_data);
		
		$post_types = $this->searchform->settings("post_types");
		
		if(is_array($post_types))
		{//get the post types in to the proper format
			$post_types_array = array();
			
			foreach ($post_types as $key => $val)
			{
				$post_types_array[] = $key;
			}
			
			$args['post_types'] = $post_types_array;
		}
		
		
		if($field_data['all_items_label']=="")
		{
			$args['show_option_all_sf'] = __('All Authors', $this->plugin_slug);
		}
		else
		{
			$args['show_option_all_sf'] = $field_data['all_items_label'];
			
		}
		
		
		if(($args['order_by']!="default")&&($args['order_by']!=""))
		{
			$args['orderby'] = $args['order_by'];
			$args['order'] = strtoupper($args['order_dir']);
		}
		
		$args['name'] = $field_name; //field name
		
		$input_args = array(
			'name'						=> $field_name,
			'defaults'					=> $fields_defaults,
			'accessibility_label'		=> $args['accessibility_label'],
			'attributes'				=> array(),
			'options'					=> array()
		);
		
		if($args['input_type']=="select")
		{
			//setup any custom attributes
			$attributes = array();
			if($args['combo_box']==1)
			{
				$attributes['data-combobox'] = '1';

				if(!empty($args['no_results_message'])){
					$attributes['data-combobox-nrm'] = $args['no_results_message'];
				}
			}
			
			//finalise input args object
			$args['show_default_option_sf'] = true;
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			
			$returnvar .= $this->create_input->select($input_args);
			
		}
		else if($args['input_type']=="checkbox")
		{
			//setup any custom attributes
			$attributes = array();
			
			//finalise input args object show_count_format_sf
			$args['show_count_format_sf'] = 'html';
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;		
			
			$returnvar .= $this->create_input->checkbox($input_args);
		}
		else if($args['input_type']=="radio")
		{
			//setup any custom attributes
			$attributes = array();
			
			//finalise input args object
			$args['show_default_option_sf'] = true;
			$args['show_count_format_sf'] = 'html';
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			
			$returnvar .= $this->create_input->radio($input_args);
			
		}
		else if($args['input_type']=="multiselect")
		{
			//setup any custom attributes
			$attributes = array();
			if($args['combo_box']==1)
			{
				$attributes['data-combobox'] = '1';
				$attributes['data-placeholder'] = $args['show_option_all_sf'];

				if(!empty($args['no_results_message'])){
					$attributes['data-combobox-nrm'] = $args['no_results_message'];
				}
			}			
			
			$attributes['multiple'] = "multiple";
			
			//finalise input args object
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			
			$returnvar .= $this->create_input->select($input_args);
		}
		
		return $returnvar;
	}
	
	private function get_options($args)
	{
		//options is passed by ref, so when `wp_list_categories` is finished running, it will contain an object of all options for this field.
		$options = array();
		
		$options_obj = new Author_Options();
		
		//use a walker to silence output, and create a custom object which is stored in `$options`
		$walker = new Search_Filter_Author_Object_Walker($options_obj);
		$output = $walker->wp_authors($args);		
		
		return $options_obj->get();
	}
}


class Author_Options {
	
	private $options = array();
	
	public function set($options)
	{
		$this->options = $options;
	}
	public function get()
	{
		return $this->options;
	}
}


<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Post_Type
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Field_Post_Type extends Search_Filter_Field_Base {
	
	public function get($field_data)
	{
		$field_name = SF_FPRE."post_type";
		
		$fields_defaults = $this->current_query->get_field_values("post_types");
		
		if(count($fields_defaults)==0)
		{
			$fields_defaults = array("");
		}
		
		$returnvar = "";
		
		
		//set defaults so no chance of any php errors when accessing un init vars
		$defaults = array(
			'post_types'			=> array(),
			'input_type'			=> '',
			'heading'				=> '',
			'show_count'			=> '',
			'hide_empty'			=> '',
			'order_by'				=> '',
			'order_dir'				=> '',
			'all_items_label'		=> '',
			'accessibility_label'	=> '',
			'combo_box'				=> '',
			'no_results_message'	=> ''
		);
		
		$values = array_replace($defaults, $field_data);
		
		$args = array('show_default_option_sf' => false);
		
		if($field_data['all_items_label']=="")
		{
			$args['show_option_all_sf'] = __('All Post Types', $this->plugin_slug);
		}
		else
		{
			$args['show_option_all_sf'] = $field_data['all_items_label'];
		}
		
		$args['post_types'] = $values['post_types'];
				
		$input_args = array(
			'name'			=> $field_name,
			'defaults'		=> $fields_defaults,
			'attributes'	=> array(),
			'options'		=> array()
		);
		
		if($values['input_type']=="select")
		{
			//setup any custom attributes
			$attributes = array();
			if($values['combo_box']==1)
			{
				$attributes['data-combobox'] = '1';

				if(!empty($values['no_results_message'])){
					$attributes['data-combobox-nrm'] = $values['no_results_message'];
				}
			}
			
			$args['show_default_option_sf'] = true;
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			$input_args['accessibility_label'] = $values['accessibility_label'];
			
			$returnvar .= $this->create_input->select($input_args);
			
		}
		else if($values['input_type']=="checkbox")
		{
			//setup any custom attributes
			$attributes = array();
			
			//finalise input args object
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;			
			
			$returnvar .= $this->create_input->checkbox($input_args);
		}
		else if($values['input_type']=="radio")
		{
			//setup any custom attributes
			$attributes = array();
			
			//finalise input args object
			$args['show_default_option_sf'] = true;
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			
			$returnvar .= $this->create_input->radio($input_args);
			
		}
		else if($values['input_type']=="multiselect")
		{
			//setup any custom attributes
			$attributes = array();
			if($values['combo_box']==1)
			{
				$attributes['data-combobox'] = '1';
				$attributes['data-placeholder'] = $args['show_option_all_sf'];

				if(!empty($values['no_results_message'])){
					$attributes['data-combobox-nrm'] = $values['no_results_message'];
				}
			}			
			$attributes['multiple'] = "multiple";
			
			//finalise input args object
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			$input_args['accessibility_label'] = $values['accessibility_label'];
			
			$returnvar .= $this->create_input->select($input_args);
			
		}
		
		return $returnvar;
	}
	
	public function get_options($args)
	{
		$options = array();
		
		//$post_types_data = array();
		
		$show_option_all_sf = $args['show_option_all_sf'];
		$show_default_option_sf = $args['show_default_option_sf'];
		
		if((isset($show_option_all_sf))&&($show_default_option_sf==true))
		{
			$default_option = new stdClass();
			$default_option->label = $show_option_all_sf;
			$default_option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '.SF_ITEM_CLASS_PRE.'0'
			);
			$default_option->value = "";
			
			array_push($options, $default_option);
		}

		
		if(is_array($args['post_types']))
		{
			foreach($args['post_types'] as $post_type => $val)
			{
				$post_type_object = get_post_type_object( $post_type );
				
				if($post_type_object)
				{
					$option = new stdClass();
					$option->label = $post_type_object->labels->name;
					$option->attributes = array(
						//'class' => SF_CLASS_PRE.'level-0 '.SF_ITEM_CLASS_PRE.'0'
						'class' => SF_CLASS_PRE.'level-0 '
					);
					$option->value = $post_type;
					
					array_push($options, $option);
					
				}
			}
		}
		
		return $options;
	}
}

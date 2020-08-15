<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Generate_Input
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Field_Sort_Order extends Search_Filter_Field_Base {
	
	public function get($field_data)
	{
		$field_name = SF_FPRE."sort_order";
		
		$fields_defaults = $this->current_query->get_field_values("_sf_sort_order");
		//$fields_defaults = $this->current_query->get_field_values("sort_order");
		
		if(count($fields_defaults)==0)
		{
			$fields_defaults = array("");
		}
		
		$search_form_id = $this->sfid;
		
		$returnvar = "";
		
		
		
		//set defaults so no chance of any php errors when accessing un init vars
		$defaults = array(
			'input_type'				=> 'select',
			'all_items_label'			=> '',
			'accessibility_label'		=> '',
			'sort_options'				=> array()
		);
		
		$values = array_replace($defaults, $field_data);
		
		
		$args = array();
		
		$args = array('show_default_option_sf' => false);
		
		if($field_data['all_items_label']=="")
		{
			if($values['input_type']=="select")
			{
				$args['show_option_all_sf'] = __("Sort Results By", $this->plugin_slug);
			}
			else if($values['input_type']=="radio")
			{
				$args['show_option_all_sf'] = __("Default Sort Order", $this->plugin_slug);
			}
		}
		else
		{
			$args['show_option_all_sf'] = $field_data['all_items_label'];
		}
		
		$args['sort_options'] = $values['sort_options'];
		
	
		$attributes = array();
		
		/*if($values['combo_box']==1)
		{
			$attributes['data-combobox'] = '1';
		}*/
		
		$args['show_default_option_sf'] = true;
		
		$input_args = array(
			'name'			=> $field_name,
			'defaults'		=> $fields_defaults,
			'attributes'	=> $attributes,
			'options'		=> array()
		);
		
		if($values['input_type']=="select")
		{
			$args['show_default_option_sf'] = true;
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			$input_args['accessibility_label'] = $values['accessibility_label'];
			
			$returnvar .= $this->create_input->select($input_args);
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
		
		//$returnvar .= $this->create_input->generate_select($taxonomychildren, $field_name, $defaults, $values['all_items_label']);
		
	
				
		return $returnvar;
	}
	
	public function get_options($args)
	{
		$options = array();
		
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
		
		
		$no_sort_options = count($args['sort_options']);
		if($no_sort_options>0)
		{
			foreach($args['sort_options'] as $sort_option)
			{
				$sort_by = "";
				$sort_label = "";
				$sort_dir = "";
				
				$meta_key = "";
				$sort_type = "";
				
				if(isset($sort_option['sort_by']))
				{
					$sort_by = $sort_option['sort_by'];
					
					if($sort_by=="meta_value")
					{
						if(isset($sort_option['meta_key']))
						{
							$sort_by = SF_META_PRE.$sort_option['meta_key'];
						}
						
						if(isset($sort_option['sort_type']))
						{
							if($sort_option['sort_type']=="numeric")
							{
								$sort_type = "+num";
							}
							else if($sort_option['sort_type']=="alphabetic")
							{
								$sort_type = "+alpha";
							}
							else if($sort_option['sort_type']=="date")
							{
								$sort_type = "+date";
							}
							else if($sort_option['sort_type']=="datetime")
							{
								$sort_type = "+datetime";
							}
							/*else if($sort_option['sort_type']=="decimal")
							{
								$sort_type = "+decimal";
							}*/
						}
					}
				}
				if(isset($sort_option['sort_label']))
				{
					$sort_label = $sort_option['sort_label'];
				}
				if(isset($sort_option['sort_dir']))
				{
					$sort_dir = $sort_option['sort_dir'];
				}
				
				$option = new stdClass();
				$option->label = $sort_label;
				$option->attributes = array(
					'class' => SF_CLASS_PRE.'level-0 '
				);
				$option->value = $sort_by."+".$sort_dir.$sort_type;
				
				array_push($options, $option);
								
			}
		}
		
		return $options;
	}
}

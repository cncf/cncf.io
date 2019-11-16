<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Generate_Input
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Field_Posts_Per_Page extends Search_Filter_Field_Base {
	
	public function get($field_data)
	{
		$field_name = SF_FPRE."ppp";
		
		$fields_defaults = $this->current_query->get_field_values("_sf_ppp");
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
			'ppp_min'					=> '25',
			'ppp_max'					=> '100',
			'ppp_step'					=> '25',
			'options'					=> array()
		);
		
		$values = array_replace($defaults, $field_data);
		
		$args = array();
		
		$args = array('show_default_option_sf' => false);
		
		if($field_data['all_items_label']=="")
		{
			if($values['input_type']=="select")
			{
				$args['show_option_all_sf'] = __("Results Per Page ", $this->plugin_slug);
			}
			else if($values['input_type']=="radio")
			{
				$args['show_option_all_sf'] = __("Results Per Page", $this->plugin_slug);
			}
		}
		else
		{
			$args['show_option_all_sf'] = $field_data['all_items_label'];
		}
		
		$attributes = array();
		
		/*if($values['combo_box']==1)
		{
			$attributes['data-combobox'] = '1';
		}*/
		
		$args['show_default_option_sf'] = true;
		$args['ppp_min'] = $values['ppp_min'];
		$args['ppp_max'] = $values['ppp_max'];
		$args['ppp_step'] = $values['ppp_step'];
		
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
			//$attributes = array();
			
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
		
		
		$startval = $args['ppp_min'];
		$endval = $args['ppp_max'];
		$step = $args['ppp_step'];
		$diff = $endval - $startval;
		$istep = ceil($diff/$step);
		
		
		for($i=0; $i<=($istep); $i++)
		{
			$option_value = $startval + ($i * $step);
			/*$option_top_value = ($option_value + $step - 1);
			
			if($option_top_value>$endval)
			{
				$option_top_value = $endval;
			}*/

			//$input_id = SF_INPUT_ID_PRE.sanitize_html_class($name."_".$option_value);

			$option_label = $option_value;//." - ".$option_top_value;
			
			$option = new stdClass();
			$option->label = $option_label;
			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);
			$option->value = $option_value;
			
			array_push($options, $option);
			
			
		}
		
		return $options;
	}
}

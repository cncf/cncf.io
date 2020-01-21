<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Generate_Input
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Field_Post_Date extends Search_Filter_Field_Base {
	
	public function get($field_data)
	{
		$field_name = SF_FPRE."post_date";
		
		$fields_defaults = $this->current_query->get_field_values($field_name);
		
		$returnvar = "";
				
		$defaults = array(
			'input_type'				=> '',
			'date_format'				=> '',
			'heading'					=> '',
			'accessibility_label'		=> '',


			'date_from_prefix'			=> '',
			'date_from_postfix'			=> '',
			'date_from_placeholder'		=> '',
			'date_to_prefix'			=> '',
			'date_to_postfix'			=> '',
			'date_to_placeholder'		=> '',

			'date_use_dropdown_month'	=> '',
			'date_use_dropdown_year'	=> ''

		);
				
		$args = array_replace($defaults, $field_data);
		
		if($args['date_format']=="")
		{
			$args['date_format'] = 'm/d/Y';
		}
		
		$defaults = "";
		$placeholder = "";
		$jqueryformat = "";
		
		if($args['date_format']=="m/d/Y")
		{
			$placeholder = __("mm/dd/yyyy", $this->plugin_slug);
			$jqueryformat = __("mm/dd/yy", $this->plugin_slug);
		}
		else if($args['date_format']=="d/m/Y")
		{
			$placeholder = __("dd/mm/yyyy", $this->plugin_slug);
			$jqueryformat = __("dd/mm/yy", $this->plugin_slug);
		}
		else if($args['date_format']=="Y/m/d")
		{
			$placeholder = __("yyyy/mm/dd", $this->plugin_slug);
			$jqueryformat = __("yy/mm/dd", $this->plugin_slug);
		}
		
		if(isset($fields_defaults))
		{
			foreach($fields_defaults as &$a_default)
			{
				if(strlen($a_default)==8)
				{
					if($args['date_format']=="m/d/Y")
					{
						$month = substr($a_default, 0, 2);
						$day = substr($a_default, 2, 2);
						$year = substr($a_default, 4, 4);
						
						$a_default = $month."/".$day."/".$year;
						
					}
					else if($args['date_format']=="d/m/Y")
					{
						$month = substr($a_default, 2, 2);
						$day = substr($a_default, 0, 2);
						$year = substr($a_default, 4, 4);
						
						$a_default = $day."/".$month."/".$year;
						
					}
					else if($args['date_format']=="Y/m/d")
					{
						$month = substr($a_default, 4, 2);
						$day = substr($a_default, 6, 2);
						$year = substr($a_default, 0, 4);
						
						$a_default = $year."/".$month."/".$day;
						
					}
				}
				else
				{
					$a_default = "";
				}
			}
			
			$defaults = $fields_defaults;
		}
		
		
		$returnvar .= "<ul class=\"sf_date_field\" data-date-format=\"".$jqueryformat."\" data-date-use-year-dropdown='".$args['date_use_dropdown_year']."' data-date-use-month-dropdown='".$args['date_use_dropdown_month']."'>";
		
		
		
		if($args['input_type']=="date")
		{
			$attributes = array();
			
			if($args['date_from_placeholder']!="")
			{
				$attributes['placeholder'] = $args['date_from_placeholder'];
			}
			
			$date_value = $this->get_date_from_default($defaults, "from");
			
			$input_args = array(
				'name'						=> $field_name,
				//'options'					=> $this->get_options($args),
				'value'						=> $date_value,
				'accessibility_label'		=> $args['accessibility_label'],
				'attributes'				=> $attributes,
				'prefix'					=> $args['date_from_prefix'],
				'postfix'					=> $args['date_from_postfix']
				
			);
			
			$returnvar .= "<li>";
			$returnvar .= $this->create_input->datepicker($input_args);
			$returnvar .= "</li>";
		}
		else if($args['input_type']=="daterange")
		{
			// from field
			$attributes = array();
			if($args['date_from_placeholder']!="")
			{
				$attributes['placeholder'] = $args['date_from_placeholder'];
			}
			
			$date_value = $this->get_date_from_default($defaults, "from");
			
			$input_args = array(
				'name'						=> $field_name,
				'value'						=> $date_value,
				'accessibility_label'		=> $args['accessibility_label'],
				'attributes'				=> $attributes,
				'prefix'					=> $args['date_from_prefix'],
				'postfix'					=> $args['date_from_postfix']
				
			);
			$returnvar .= "<li>";
			$returnvar .= $this->create_input->datepicker($input_args);
			$returnvar .= "</li>";
			
			
			// to field
			$attributes = array();
			if($args['date_to_placeholder']!="")
			{
				$attributes['placeholder'] = $args['date_to_placeholder'];
			}
			
			$date_value = $this->get_date_from_default($defaults, "to");
			
			$input_args = array(
				'name'						=> $field_name,
				'value'						=> $date_value,
				'accessibility_label'		=> $args['accessibility_label'],
				'attributes'				=> $attributes,
				'prefix'					=> $args['date_to_prefix'],
				'postfix'					=> $args['date_to_postfix']
				
			);
			
			$returnvar .= "<li>";
			$returnvar .= $this->create_input->datepicker($input_args);
			$returnvar .= "</li>";
			
		}
		
		$returnvar .= "</ul>";
		
		return $returnvar;
	}
	
	public function get_date_from_default($defaults, $fromto = "from")
	{
		if($fromto=="from")
		{
			$currentid = 0;
		}
		else if($fromto=="to")
		{
			$currentid = 1;
		}
		
		$current_date = "";
		if(isset($defaults[$currentid]))
		{
			$current_date = $defaults[$currentid];
		}
		
		return $current_date;
		
		
	}
}

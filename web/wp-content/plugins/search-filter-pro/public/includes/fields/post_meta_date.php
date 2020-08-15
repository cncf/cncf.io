<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Post_Meta_Date
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Field_Post_Meta_Date {
	
	public function __construct($plugin_slug, $sfid) {

		$this->plugin_slug = $plugin_slug;
		$this->sfid = $sfid;
		$this->create_input = new Search_Filter_Generate_Input($this->plugin_slug, $sfid);
	}
	
	public function get($field_name, $args, $fields_defaults)
	{
		
		$returnvar = "";
		
		$defaults = array(
			'date_input_type'			=> '',
			'date_output_format'		=> '',
			'heading'					=> '',

			'use_same_toggle'			=> '',

			'date_from_prefix'			=> '',
			'date_from_postfix'			=> '',
			'date_from_placeholder'		=> '',
			'date_to_prefix'			=> '',
			'date_to_postfix'			=> '',
			'date_to_placeholder'		=> '',

			'date_use_dropdown_month'		=> '',
			'date_use_dropdown_year'		=> ''


		);
				
		$args = array_replace($defaults, $args);
		
		if($args['date_output_format']=="")
		{
			$args['date_output_format'] = 'm/d/Y';
		}
		
		$defaults = "";
		$placeholder = "";
		$jqueryformat = "";
		
		if($args['date_output_format']=="m/d/Y")
		{
			$placeholder = __("mm/dd/yyyy", $this->plugin_slug);
			$jqueryformat = __("mm/dd/yy", $this->plugin_slug);
		}
		else if($args['date_output_format']=="d/m/Y")
		{
			$placeholder = __("dd/mm/yyyy", $this->plugin_slug);
			$jqueryformat = __("dd/mm/yy", $this->plugin_slug);
		}
		else if($args['date_output_format']=="Y/m/d")
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
					if($args['date_output_format']=="m/d/Y")
					{
						$month = substr($a_default, 0, 2);
						$day = substr($a_default, 2, 2);
						$year = substr($a_default, 4, 4);
						
						$a_default = $month."/".$day."/".$year;
						
					}
					else if($args['date_output_format']=="d/m/Y")
					{
						$month = substr($a_default, 2, 2);
						$day = substr($a_default, 0, 2);
						$year = substr($a_default, 4, 4);
						
						$a_default = $day."/".$month."/".$year;
						
					}
					else if($args['date_output_format']=="Y/m/d")
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
		
		if($args['date_input_type']=="date")
		{
			$attributes = array();
			
			if($args['date_from_placeholder']!="")
			{
				$attributes['placeholder'] = $args['date_from_placeholder'];
			}
			
			$date_value = $this->get_date_default($defaults, "from");
			
			$input_args = array(
				'name'						=> $field_name,
				//'options'					=> $this->get_options($args),
				'value'						=> $date_value,
				'accessibility_label'		=> $args['date_accessibility_label'],
				'attributes'				=> $attributes,
				'prefix'					=> $args['date_from_prefix'],
				'postfix'					=> $args['date_from_postfix']
				
			);
			
			$returnvar .= "<li>";
			$returnvar .= $this->create_input->datepicker($input_args);
			$returnvar .= "</li>";
		}
		else if($args['date_input_type']=="daterange")
		{
			// from field
			$attributes = array();
			if($args['date_from_placeholder']!="")
			{
				$attributes['placeholder'] = $args['date_from_placeholder'];
			}
			
			$date_value = $this->get_date_default($defaults, "from");
			
			$input_args = array(
				'name'						=> $field_name,
				'value'						=> $date_value,
				'accessibility_label'		=> $args['date_accessibility_label'],
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
			
			$date_value = $this->get_date_default($defaults, "to");
			
			$input_args = array(
				'name'						=> $field_name,
				'value'						=> $date_value,
				'accessibility_label'		=> $args['date_accessibility_label'],
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
	
	public function get_date_default($defaults, $fromto = "from")
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

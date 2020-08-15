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

class Search_Filter_Field_Submit extends Search_Filter_Field_Base {
	
	public function get($field_data)
	{
		$field_name = SF_FPRE."submit";
		
		//$fields_defaults = $this->current_query->get_field_values($field_name);
		
		$returnvar = "";
		
		//set defaults so no chance of any php errors when accessing un init vars
		$defaults = array(
			'label'			=> __("Submit", $this->plugin_slug)
		);
		$values = array_replace($defaults, $field_data);
		
		//$searchterm = (esc_attr($this->searchterm));
		$searchterm =  "";
		$returnvar .=  '<input type="submit" name="'.$field_name.'" value="'.$values['label'].'">';
		
		return $returnvar;
	}
}

<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Reset
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Field_Reset extends Search_Filter_Field_Base {

	
	public function get($field_data)
	{
		$field_name = SF_FPRE.'reset';
		
		//$fields_defaults = $this->current_query->get_field_values($field_name);
		
		$returnvar = "";
		
		//set defaults so no chance of any php errors when accessing un init vars
		$defaults = array(
			'label'			=> __("Reset", $this->plugin_slug),
			'input_type'	=> "link",
			'submit_form'	=> "always"
		);
		
		$values = array_replace($defaults, $field_data);
		
		$searchterm =  "";
		if($values['input_type']=="link")
		{
			$returnvar .=  '<a href="#" class="search-filter-reset" data-search-form-id="'.$this->sfid.'" data-sf-submit-form="'.$values['submit_form'].'">'.$values['label'].'</a>';
		}
		else
		{
			$returnvar .=  '<input type="submit" class="search-filter-reset" name="'.$field_name.'" value="'.$values['label'].'" data-search-form-id="'.$this->sfid.'" data-sf-submit-form="'.$values['submit_form'].'">';
		}
		
		return $returnvar;
	}
}

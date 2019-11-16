<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Search
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Field_Search extends Search_Filter_Field_Base {
	
	
	public function get($field_data)
	{
		$field_name = SF_FPRE.'search';
		
		$fields_defaults = $this->current_query->get_search_term();
		
		$returnvar = "";
		
		if(empty($fields_defaults))
		{
			$fields_defaults = "";
		}
		
		//set defaults so no chance of any php errors when accessing un init vars
		$defaults = array(
			'placeholder'					=> __("Search &hellip;", $this->plugin_slug),
			'accessibility_label'			=> ''
		);
		$values = array_replace($defaults, $field_data);
		
		$searchterm = "";
		if(isset($this->searchterm))
		{
			$searchterm = esc_attr($this->searchterm);
		}
		
		$attributes = array(
			'placeholder'	=> $values['placeholder']
		);
		
		$input_args = array(
			'name'						=> $field_name,
			'value'						=> $fields_defaults,
			
			'accessibility_label'		=> $values['accessibility_label'], 
			'attributes'				=> $attributes
		);
		
		$returnvar .= $this->create_input->text($input_args);
		
		return $returnvar;
	}
}

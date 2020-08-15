<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Search
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Field_Base {
	
	public function __construct($plugin_slug, $sfid) {

		$this->plugin_slug = $plugin_slug;
		$this->sfid = $sfid;
		$this->create_input = new Search_Filter_Generate_Input($this->plugin_slug, $sfid);
		
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$this->searchform = $searchform;
		$this->current_query = $searchform->current_query();
	}
	
	
	public function set_defaults()
	{
		
		$field_defaults = array();
		
		/*global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$current_query = $searchform->current_query()->get_array();
		
		foreach($current_query as $field_name => $field)
		{
			if(isset($field['active_terms']))
			{
				$field_defaults[$field_name] = array();
				
				foreach($field['active_terms'] as $active_term)
				{
					array_push($field_defaults[$field_name], $active_term->value);
				}
			}
		}*/
		
		$this->field_defaults = $field_defaults;
		
	}
	
}

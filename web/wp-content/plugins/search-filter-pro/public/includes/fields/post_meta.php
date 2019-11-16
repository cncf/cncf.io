<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Post_Meta
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Field_Post_Meta extends Search_Filter_Field_Base {
	
	public function get($field_data)
	{
		
		$returnvar = "";
		
		//set defaults so no chance of any php errors when accessing un init vars
		$defaults = array(
			
			'heading'					=> '',
			
			'meta_type'					=> 'number',
			'meta_key'					=> '',
			'meta_key_manual'			=> '',
			'meta_key_manual_toggle'	=> '',
			
			'number_input_type'			=> '',
			'number_is_decimal'			=> '',
			'choice_input_type'			=> '',
			'date_input_type'			=> '',
			
			'choice_get_option_mode'	=> 'manual',
			'choice_order_option_by'	=> 'value',
			'choice_order_option_dir'	=> 'asc',
			'choice_order_option_type'	=> 'alphabetic',
			
			'range_min'					=> '0',
			'range_max'					=> '1000',
			'range_step'				=> '10',
			'range_min_detect'					=> '',
			'range_max_detect'					=> '',
			
			'thousand_seperator'		=> '',
			'decimal_seperator'		    => '.',
			'decimal_places'			=> '0',
			'number_decimal_places'		=> '2',
			'number_values_seperator'	=> ' - ',
			'number_display_values_as'	=> 'textinput',
			
			'number_display_input_as'	=> 'singlefield',
			
			'range_value_prefix'		=> '',
			'range_value_postfix'		=> '',

			
			'meta_options'				=> array(),
			
			'choice_accessibility_label'			=> '',
			'number_accessibility_label'			=> '',
			'date_accessibility_label'			=> '',
			
			
			'all_items_label'			=> '',
			'all_items_label_number'	=> '',
			'combo_box'					=> '',
			'show_count'				=> '',
			'hide_empty'				=> ''
		);
		
		$values = array_replace($defaults, $field_data);		
		
		if($values['meta_key_manual_toggle']==1)
		{
			$meta_key = $values['meta_key_manual'];
		}
		else
		{
			$meta_key = $values['meta_key'];
		}
		
		$field_name = SF_META_PRE.$meta_key;
		
		//$field_name_get = str_replace(" ", "_", $field_name); //replace space with `_` as this is done anyway - spaces are not allowed in GET variable names, and are automatically converted by server/browser to `_`
		$fields_defaults = $this->current_query->get_field_values($field_name);
		
		//var_dump($this->current_query);
		
		if($field_data['all_items_label']=="")
		{
			$values['show_option_all_sf'] = __("All Items", $this->plugin_slug);
		}
		else
		{
			$values['show_option_all_sf'] = $field_data['all_items_label'];
		}
		
		
		
			
		$defaults = $fields_defaults;
		
		if($values['meta_type']=="choice")
		{
			$this->meta_field_choice = new Search_Filter_Field_Post_Meta_Choice($this->plugin_slug, $this->sfid);
			$returnvar .= $this->meta_field_choice->get($field_name, $values, $fields_defaults);
		}
		else if($values['meta_type']=="number")
		{
			$this->meta_field_number = new Search_Filter_Field_Post_Meta_Number($this->plugin_slug, $this->sfid);
			$returnvar .= $this->meta_field_number->get($field_name, $values, $fields_defaults);
		}
		else if($values['meta_type']=="date")
		{
			$this->meta_field_date = new Search_Filter_Field_Post_Meta_Date($this->plugin_slug, $this->sfid);
			$returnvar .= $this->meta_field_date->get($field_name, $values, $fields_defaults);
		}
				
		return $returnvar;
	}
}

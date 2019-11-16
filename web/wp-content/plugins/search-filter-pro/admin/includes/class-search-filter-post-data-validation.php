<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Post_Data_Validation
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Post_Data_Validation {
	
	public function __construct() {

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		$this->plugin_slug = "search-filter";
				
	}
	
	public function get_clean_widget_data($widget_data)
	{
		$clean_widget = array();
				
		if($widget_data['type']=="search")
		{
			$clean_widget = $this->clean_search_widget($widget_data);
		}
		else if(($widget_data['type']=="tag")||($widget_data['type']=="category")||($widget_data['type']=="taxonomy"))
		{
			$clean_widget = $this->clean_taxonomy_widget($widget_data);
		}
		else if($widget_data['type']=="post_type")
		{
			$clean_widget = $this->clean_post_type_widget($widget_data);
		}
		else if($widget_data['type']=="post_date")
		{
			$clean_widget = $this->clean_post_date_widget($widget_data);
		}
		else if($widget_data['type']=="author")
		{
			$clean_widget = $this->clean_author_widget($widget_data);
		}
		else if($widget_data['type']=="post_meta")
		{
			$clean_widget = $this->clean_post_meta_widget($widget_data);
		}
		else if($widget_data['type']=="sort_order")
		{
			$clean_widget = $this->clean_sort_order_widget($widget_data);
		}
		else if($widget_data['type']=="posts_per_page")
		{
			$clean_widget = $this->clean_posts_per_page_widget($widget_data);
		}
		else if($widget_data['type']=="submit")
		{
			$clean_widget = $this->clean_submit_widget($widget_data);
		}
		else if($widget_data['type']=="reset")
		{
			$clean_widget = $this->clean_reset_widget($widget_data);
		}
		
		return $clean_widget;
		
	}
	
	private function clean_search_widget($widget_data)
	{
		$clean_widget = array();
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		$clean_widget['placeholder'] = sanitize_text_field($widget_data['placeholder']);
		$clean_widget['accessibility_label'] = sanitize_text_field($widget_data['accessibility_label']);
		
		return $clean_widget;
	}
	private function clean_taxonomy_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
			'taxonomy_name'			=> '',
			'input_type'			=> '',
			'heading'				=> '',
			'all_items_label'		=> '',
			'operator'				=> '',
			'show_count'			=> '',
			'hide_empty'			=> '',
			'hierarchical'			=> '',
			'include_children'		=> '',
			'accessibility_label'	=> '',
			'drill_down'			=> '',
			'order_by'				=> '',
			'order_dir'				=> '',
			'exclude_ids'			=> '',
			'sync_include_exclude'	=> '',
			'combo_box'				=> '',
			'no_results_message'	=> ''
		);
		
		
		$widget_data = array_replace($defaults, $widget_data);
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		
		$clean_widget['input_type'] = sanitize_key($widget_data['input_type']);
		
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		$clean_widget['accessibility_label'] = sanitize_text_field($widget_data['accessibility_label']);
		$clean_widget['all_items_label'] = sanitize_text_field($widget_data['all_items_label']);
		
		$clean_widget['show_count'] = $this->sanitize_checkbox($widget_data['show_count']);
		$clean_widget['hide_empty'] = $this->sanitize_checkbox($widget_data['hide_empty']);
		$clean_widget['hierarchical'] = $this->sanitize_checkbox($widget_data['hierarchical']);
		$clean_widget['include_children'] = $this->sanitize_checkbox($widget_data['include_children']);
		$clean_widget['drill_down'] = $this->sanitize_checkbox($widget_data['drill_down']);
		$clean_widget['sync_include_exclude'] = $this->sanitize_checkbox($widget_data['sync_include_exclude']);
		
		$clean_widget['combo_box'] = $this->sanitize_checkbox($widget_data['combo_box']);
		$clean_widget['no_results_message'] = sanitize_text_field($widget_data['no_results_message']);

		$clean_widget['operator'] = sanitize_key($widget_data['operator']);
		$clean_widget['order_by'] = sanitize_key($widget_data['order_by']);
		$clean_widget['order_dir'] = sanitize_key($widget_data['order_dir']);
		
		$clean_widget['exclude_ids'] = $this->clean_exclude_ids($widget_data['exclude_ids']);
		
		
		//if($widget_data['type']=="taxonomy")
		//{
			
			$clean_widget['taxonomy_name'] = sanitize_text_field($widget_data['taxonomy_name']);
			
		//}
		
		return $clean_widget;
	}
	
	private function clean_post_type_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
			'post_types'			=> array(),
			'input_type'			=> '',
			'heading'				=> '',
			'all_items_label'		=> '',
			'show_count'			=> '',
			'hide_empty'			=> '',
			'accessibility_label'	=> '',
			
			'order_by'				=> '',
			'order_dir'				=> '',
			'combo_box'				=> '',
			'no_results_message'	=> ''
		);		
		
		$widget_data = array_replace($defaults, $widget_data);
		
		foreach($widget_data['post_types'] as $key => $val)
		{
			$clean_widget['post_types'][$key] = $this->sanitize_checkbox($val);
		}
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		
		$clean_widget['input_type'] = sanitize_key($widget_data['input_type']);
		
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		$clean_widget['all_items_label'] = sanitize_text_field($widget_data['all_items_label']);
		$clean_widget['accessibility_label'] = sanitize_text_field($widget_data['accessibility_label']);
		
		$clean_widget['combo_box'] = $this->sanitize_checkbox($widget_data['combo_box']);
		$clean_widget['no_results_message'] = sanitize_text_field($widget_data['no_results_message']);
		
		//$clean_widget['show_count'] = $this->sanitize_checkbox($widget_data['show_count']);
		//$clean_widget['hide_empty'] = $this->sanitize_checkbox($widget_data['hide_empty']);
		
		
		//$clean_widget['order_by'] = sanitize_key($widget_data['order_by']);
		//$clean_widget['order_dir'] = sanitize_key($widget_data['order_dir']);
		
		
		return $clean_widget;
	}
	
	private function clean_post_date_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
			'input_type'			=> '',
			'heading'				=> '',
			'date_format'			=> '',
			'accessibility_label'	=> ''
			
		);

		$widget_data = array_replace($defaults, $widget_data);
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		
		$clean_widget['input_type'] = sanitize_key($widget_data['input_type']);
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		$clean_widget['accessibility_label'] = sanitize_text_field($widget_data['accessibility_label']);
		
		$clean_widget['date_format'] = sanitize_text_field($widget_data['date_format']);

		
		$clean_widget['date_from_prefix'] = sanitize_text_field($widget_data['date_from_prefix']);
		$clean_widget['date_from_postfix'] = sanitize_text_field($widget_data['date_from_postfix']);
		$clean_widget['date_from_placeholder'] = sanitize_text_field($widget_data['date_from_placeholder']);
		$clean_widget['date_to_prefix'] = sanitize_text_field($widget_data['date_to_prefix']);
		$clean_widget['date_to_postfix'] = sanitize_text_field($widget_data['date_to_postfix']);
		$clean_widget['date_to_placeholder'] = sanitize_text_field($widget_data['date_to_placeholder']);

		$clean_widget['date_use_dropdown_month'] = $this->sanitize_checkbox($widget_data['date_use_dropdown_month']);
		$clean_widget['date_use_dropdown_year'] = $this->sanitize_checkbox($widget_data['date_use_dropdown_year']);
		
		return $clean_widget;
	}
	
	private function clean_author_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
			'input_type'				=> '',
			'heading'					=> '',
			'optioncount'				=> '',
			'exclude_admin'				=> '',
			'show_fullname'				=> '',
			'order_by'					=> '',
			'order_dir'					=> '',
			'hide_empty'				=> '',
			'operator'					=> '',
			'all_items_label'			=> '',
			'accessibility_label'		=> '',
			'exclude'					=> '',
			'combo_box'					=> '',
			'no_results_message'	    => ''
		);
				
		$widget_data = array_replace($defaults, $widget_data);
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		
		$clean_widget['input_type'] = sanitize_key($widget_data['input_type']);
		
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		$clean_widget['all_items_label'] = sanitize_text_field($widget_data['all_items_label']);
		$clean_widget['accessibility_label'] = sanitize_text_field($widget_data['accessibility_label']);
		
		$clean_widget['optioncount'] = $this->sanitize_checkbox($widget_data['optioncount']);
		$clean_widget['exclude_admin'] = $this->sanitize_checkbox($widget_data['exclude_admin']);
		$clean_widget['show_fullname'] = $this->sanitize_checkbox($widget_data['show_fullname']);
		$clean_widget['hide_empty'] = $this->sanitize_checkbox($widget_data['hide_empty']);
		$clean_widget['combo_box'] = $this->sanitize_checkbox($widget_data['combo_box']);
		$clean_widget['no_results_message'] = sanitize_text_field($widget_data['no_results_message']);
		
		$clean_widget['operator'] = sanitize_key($widget_data['operator']);
		$clean_widget['order_by'] = sanitize_key($widget_data['order_by']);
		$clean_widget['order_dir'] = sanitize_key($widget_data['order_dir']);
		
		$clean_widget['exclude'] = $this->clean_exclude_ids($widget_data['exclude']);
		
		return $clean_widget;
	}
	
	private function clean_post_meta_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
		
			'heading'					=> '',
			'input_type'				=> '',
			
			'meta_type'					=> '',
			'meta_key'					=> '',
			'meta_key_manual'			=> '',
			'meta_key_manual_toggle'	=> '',
			
			'choice_heading'			=> '',
			'choice_meta_key'			=> '',
			
			'choice_get_option_mode'	=> 'auto',
			'choice_order_option_by'	=> 'value',
			'choice_order_option_dir'	=> 'asc',
			'choice_order_option_type'	=> 'alphabetic',
			'choice_is_acf'				=> '',
			'choice_accessibility_label'	=> '',
			
			'number_heading'			=> '',
			'number_start_meta_key'		=> '',
			'number_end_meta_key'		=> '',
			'number_use_same_toggle'	=> '',
			'number_accessibility_label'	=> '',
			
			'date_heading'				=> '',
			'date_start_meta_key'		=> '',
			'date_end_meta_key'			=> '',
			'date_meta_key'				=> '',
			'date_use_same_toggle'		=> '',
			'date_from_prefix'			=> '',
			'date_from_postfix'			=> '',
			'date_from_placeholder'		=> '',
			'date_to_prefix'			=> '',
			'date_to_postfix'			=> '',
			'date_to_placeholder'		=> '',
			'date_use_dropdown_year'	=> '',
			'date_use_dropdown_month'	=> '',
			'date_accessibility_label'	=> '',
			
			'number_input_type'			=> '',
			'number_is_decimal'			=> '',
			'choice_input_type'			=> '',
			'combo_box'					=> '',
			'no_results_message'	    => '',
			'show_count'				=> '',
			'hide_empty'				=> '',
			'date_input_type'			=> '',
			
			'range_min_detect'					=> '',
			'range_max_detect'					=> '',
			'range_min'					=> '0',
			'range_max'					=> '1000',
			'range_step'				=> '10',
			
			'thousand_seperator'		=> '',
			'decimal_seperator'		    => '',
			'decimal_places'			=> '0',
			'number_decimal_places'		=> '2',
			'number_values_seperator'	=> ' - ',
			'number_display_values_as'	=> 'textinput',
			'number_display_input_as'	=> 'singlefield',
			
			'range_value_prefix'		=> '',
			'range_value_postfix'		=> '',
			
			'date_output_format'		=> 'd/m/Y',
			'date_input_format'			=> 'timestamp',
			'date_compare_mode'			=> 'userrange',
			'number_compare_mode'		=> 'userrange',
			
			'operator'					=> '',
			'all_items_label'			=> '',
			'all_items_label_number'	=> '',
			
			'meta_options'				=> array()
		);
		
		$widget_data = array_replace($defaults, $widget_data);
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		
		$clean_widget['meta_type'] = sanitize_key($widget_data['meta_type']);
		
		$clean_widget['number_input_type'] = sanitize_key($widget_data['number_input_type']);
		$clean_widget['number_is_decimal'] = $this->sanitize_checkbox($widget_data['number_is_decimal']);
		$clean_widget['choice_input_type'] = sanitize_key($widget_data['choice_input_type']);
		$clean_widget['date_input_type'] = sanitize_key($widget_data['date_input_type']);
		
		
		//$clean_widget['meta_key_manual'] = sanitize_text_field($widget_data['meta_key_manual']);
		
		$clean_widget['meta_key_manual_toggle'] = $this->sanitize_checkbox($widget_data['meta_key_manual_toggle']);
		$clean_widget['combo_box'] = $this->sanitize_checkbox($widget_data['combo_box']);
		$clean_widget['no_results_message'] = sanitize_text_field($widget_data['no_results_message']);
		$clean_widget['show_count'] = $this->sanitize_checkbox($widget_data['show_count']);
		$clean_widget['hide_empty'] = $this->sanitize_checkbox($widget_data['hide_empty']);
		
		$clean_widget['input_type'] = sanitize_key($widget_data['input_type']);
		
		
		$clean_widget['choice_meta_key'] = sanitize_text_field($widget_data['choice_meta_key']);
		
		$clean_widget['choice_accessibility_label'] = sanitize_text_field($widget_data['choice_accessibility_label']);
		$clean_widget['choice_get_option_mode'] = sanitize_key($widget_data['choice_get_option_mode']);
		$clean_widget['choice_order_option_by'] = sanitize_key($widget_data['choice_order_option_by']);
		$clean_widget['choice_order_option_dir'] = sanitize_key($widget_data['choice_order_option_dir']);
		$clean_widget['choice_order_option_type'] = sanitize_key($widget_data['choice_order_option_type']);
		$clean_widget['choice_is_acf'] = $this->sanitize_checkbox($widget_data['choice_is_acf']);
		
		$clean_widget['date_accessibility_label'] = sanitize_text_field($widget_data['date_accessibility_label']);
		$clean_widget['date_meta_key'] = sanitize_text_field($widget_data['date_meta_key']);
		$clean_widget['date_start_meta_key'] = sanitize_text_field($widget_data['date_start_meta_key']);
		$clean_widget['date_end_meta_key'] = sanitize_text_field($widget_data['date_end_meta_key']);
		$clean_widget['date_use_same_toggle'] = $this->sanitize_checkbox($widget_data['date_use_same_toggle']);
		
		$clean_widget['number_accessibility_label'] = sanitize_text_field($widget_data['number_accessibility_label']);
		$clean_widget['number_start_meta_key'] = sanitize_text_field($widget_data['number_start_meta_key']);
		$clean_widget['number_end_meta_key'] = sanitize_text_field($widget_data['number_end_meta_key']);
		$clean_widget['number_use_same_toggle'] = $this->sanitize_checkbox($widget_data['number_use_same_toggle']);
		
		
		if($clean_widget['meta_type']=="number")
		{
			$clean_widget['heading'] = sanitize_text_field($widget_data['number_heading']);
			$clean_widget['meta_key'] = sanitize_text_field($widget_data['number_start_meta_key']);
		}
		else if($clean_widget['meta_type']=="choice")
		{
			$clean_widget['heading'] = sanitize_text_field($widget_data['choice_heading']);
			$clean_widget['meta_key'] = sanitize_text_field($widget_data['choice_meta_key']);
		}
		else if($clean_widget['meta_type']=="date")
		{
			$clean_widget['heading'] = sanitize_text_field($widget_data['date_heading']);
			$clean_widget['meta_key'] = sanitize_text_field($widget_data['date_start_meta_key']);
		}
		

		$clean_widget['date_from_prefix'] = $this->sanitize_text_field_kws($widget_data['date_from_prefix']);
		$clean_widget['date_from_postfix'] = $this->sanitize_text_field_kws($widget_data['date_from_postfix']);
		$clean_widget['date_from_placeholder'] = sanitize_text_field($widget_data['date_from_placeholder']);
		$clean_widget['date_to_prefix'] = $this->sanitize_text_field_kws($widget_data['date_to_prefix']);
		$clean_widget['date_to_postfix'] = $this->sanitize_text_field_kws($widget_data['date_to_postfix']);
		$clean_widget['date_to_placeholder'] = sanitize_text_field($widget_data['date_to_placeholder']);

		$clean_widget['date_use_dropdown_month'] = $this->sanitize_checkbox($widget_data['date_use_dropdown_month']);
		$clean_widget['date_use_dropdown_year'] = $this->sanitize_checkbox($widget_data['date_use_dropdown_year']);
		
		$clean_widget['decimal_places'] = (int)$widget_data['decimal_places'];
		if($clean_widget['decimal_places']>5)
		{
			$clean_widget['decimal_places'] = 5;
		}
		else if($clean_widget['decimal_places']<0)
		{
			$clean_widget['decimal_places'] = 0;
		}
		
		$clean_widget['number_decimal_places'] = (int)$widget_data['number_decimal_places'];
		if($clean_widget['number_decimal_places']>5)
		{
			$clean_widget['number_decimal_places'] = 5;
		}
		else if($clean_widget['number_decimal_places']<0)
		{
			$clean_widget['number_decimal_places'] = 0;
		}
		$clean_widget['thousand_seperator'] = $this->sanitize_text_field_kws($widget_data['thousand_seperator']);
		$clean_widget['decimal_seperator'] = $this->sanitize_text_field_kws($widget_data['decimal_seperator']);
		$clean_widget['number_values_seperator'] = $this->sanitize_text_field_kws($widget_data['number_values_seperator']);
		$clean_widget['number_display_values_as'] = sanitize_text_field($widget_data['number_display_values_as']);
		$clean_widget['number_display_input_as'] = sanitize_text_field($widget_data['number_display_input_as']);
		
		$clean_widget['range_min_detect'] = $this->sanitize_checkbox($widget_data['range_min_detect']);
		$clean_widget['range_max_detect'] = $this->sanitize_checkbox($widget_data['range_max_detect']);
		
		//convert all numeric data to correct format based on decimal places and `is_decimal`
		$range_min = $widget_data['range_min'];
		$range_max = $widget_data['range_max'];
		$range_step = $widget_data['range_step'];
		$decimal_point = '.';
		
		if($clean_widget['number_is_decimal']==0)
		{//if data is not actually decimal, its really only cosmetic to display the the decimal places - so remove all decimals to reset them to 0 on the next `number_format` call
			$range_min = number_format( (float)$range_min, 0, $decimal_point, '' );
			$range_max = number_format( (float)$range_max, 0, $decimal_point, '' );
			$range_step = number_format( (float)$range_step, 0, $decimal_point, '' );
			
		}
		else
		{//also remove any data in extra decimal places
			$range_min = number_format( (float)$range_min, $clean_widget['number_decimal_places'], $decimal_point, '' );
			$range_max = number_format( (float)$range_max, $clean_widget['number_decimal_places'], $decimal_point, '' );
			$range_step = number_format( (float) $range_step, $clean_widget['number_decimal_places'], $decimal_point, '' );
		}

		$decimal_places = $clean_widget['decimal_places'];
		if($clean_widget['number_input_type'] == 'range-number') {
			$decimal_places = 0;
		}
		$clean_widget['range_min'] = number_format( (float)$range_min, $decimal_places, $decimal_point, '' );
		$clean_widget['range_max'] = number_format( (float)$range_max, $decimal_places, $decimal_point, '' );
		$clean_widget['range_step'] = number_format( (float)$range_step, $decimal_places, $decimal_point, '' );
		
		
		$clean_widget['range_value_prefix'] = $this->sanitize_text_field_kws($widget_data['range_value_prefix']);
		$clean_widget['range_value_postfix'] = $this->sanitize_text_field_kws($widget_data['range_value_postfix']);
		
		$clean_widget['date_input_format'] = sanitize_text_field($widget_data['date_input_format']);
		$clean_widget['date_compare_mode'] = sanitize_text_field($widget_data['date_compare_mode']);
		$clean_widget['number_compare_mode'] = sanitize_text_field($widget_data['number_compare_mode']);
		
		$clean_widget['date_output_format'] = sanitize_text_field($widget_data['date_output_format']);
		
		$clean_widget['all_items_label'] = sanitize_text_field($widget_data['all_items_label']);
		$clean_widget['all_items_label_number'] = sanitize_text_field($widget_data['all_items_label_number']);
		$clean_widget['operator'] = sanitize_key($widget_data['operator']);
		
		$clean_widget['meta_options'] = array();
		$so_count = 0;
		
		if($clean_widget['choice_get_option_mode']=="manual")
		{
			if(isset($widget_data['meta_options']))
			{
				foreach($widget_data['meta_options'] as $meta_option)
				{
					
					$clean_widget['meta_options'][$so_count] = array();
					
					foreach($meta_option as $key=>$val)
					{
						
						if($key=='option_value')
						{
							$clean_widget['meta_options'][$so_count][$key] = sanitize_text_field($val);
						}
						else if($key=='option_label')
						{
							$clean_widget['meta_options'][$so_count][$key] = sanitize_text_field($val);
						}
						
					}
					
					$so_count++;
				}
			}
		}
		return $clean_widget;
	}
	function sanitize_text_field_kws( $str ) {
		$filtered = wp_check_invalid_utf8( $str );

		if ( strpos($filtered, '<') !== false ) {
			$filtered = wp_pre_kses_less_than( $filtered );
			// This will strip extra whitespace for us.
			$filtered = wp_strip_all_tags( $filtered, true );
		} else {
			$filtered = ( preg_replace('/[\r\n\t ]+/', ' ', $filtered) );
		}

		$found = false;
		while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
			$filtered = str_replace($match[0], '', $filtered);
			$found = true;
		}

		if ( $found ) {
			// Strip out the whitespace that may now exist after removing the octets.
			$filtered = trim( preg_replace('/ +/', ' ', $filtered) );
		}

		/**
		 * Filter a sanitized text field string.
		 *
		 * @since 2.9.0
		 *
		 * @param string $filtered The sanitized string.
		 * @param string $str      The string prior to being sanitized.
		 */
		return apply_filters( 'sanitize_text_field', $filtered, $str );
	}

	private function clean_sort_order_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
			/*'meta_key'					=> '',
			'meta_key_manual'			=> '',
			'meta_key_manual_toggle'	=> '',*/
			/*'sort_by'					=> '',
			'sort_dir'					=> '',
			'sort_label'				=> '',*/
			'input_type'				=> '',
			'accessibility_label'		=> '',
			'heading'					=> '',
			'all_items_label'			=> '',
			'sort_options'				=> array()
		);
		
		$widget_data = array_replace($defaults, $widget_data);
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		
		//$clean_widget['meta_key'] = sanitize_key($widget_data['meta_key']);
		//$clean_widget['meta_key_manual'] = sanitize_key($widget_data['meta_key_manual']);
		//$clean_widget['meta_key_manual_toggle'] = $this->sanitize_checkbox($widget_data['meta_key_manual_toggle']);
		
		$clean_widget['input_type'] = sanitize_key($widget_data['input_type']);
		
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		$clean_widget['all_items_label'] = sanitize_text_field($widget_data['all_items_label']);
		$clean_widget['accessibility_label'] = sanitize_text_field($widget_data['accessibility_label']);
		
		$clean_widget['sort_options'] = array();
		$so_count = 0;
		
		if(isset($widget_data['sort_options']))
		{
			foreach($widget_data['sort_options'] as $sort_option)
			{				
				$clean_widget['sort_options'][$so_count] = array();
				
				foreach($sort_option as $key=>$val)
				{
					
					if($key=='meta_key')
					{
						$clean_widget['sort_options'][$so_count][$key] = sanitize_text_field($val);
					}
					else if($key=='name')
					{
						$clean_widget['sort_options'][$so_count][$key] = sanitize_text_field($val);
					}
					else if($key=='sort_type')
					{
						$clean_widget['sort_options'][$so_count][$key] = sanitize_key($val);
					}
					else if($key=='sort_by')
					{
						$clean_widget['sort_options'][$so_count][$key] = sanitize_key($val);
					}
					else if($key=='sort_dir')
					{
						$clean_widget['sort_options'][$so_count][$key] = sanitize_key($val);
					}
					else if($key=='sort_label')
					{
						$clean_widget['sort_options'][$so_count][$key] = sanitize_text_field($val);
					}
				}
				
				$so_count++;
			}
			
		}
		
		return $clean_widget;
	}
	private function clean_posts_per_page_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
			'input_type'				=> '',
			'accessibility_label'		=> '',
			'heading'					=> '',
			'all_items_label'			=> '',
			'ppp_min'					=> '25',
			'ppp_max'					=> '100',
			'ppp_step'					=> '25'
		);
		
		$widget_data = array_replace($defaults, $widget_data);
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		
		$clean_widget['input_type'] = sanitize_key($widget_data['input_type']);
		
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		$clean_widget['all_items_label'] = sanitize_text_field($widget_data['all_items_label']);
		$clean_widget['accessibility_label'] = sanitize_text_field($widget_data['accessibility_label']);
		
		$clean_widget['ppp_min'] = (int)$widget_data['ppp_min'];
		$clean_widget['ppp_max'] = (int)$widget_data['ppp_max'];
		$clean_widget['ppp_step'] = (int)$widget_data['ppp_step'];
		
		return $clean_widget;
	}
	
	private function clean_submit_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
			'heading'					=> '',
			'label'						=> 'Submit'
		);
		
		$widget_data = array_replace($defaults, $widget_data);
		
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		
		$clean_widget['label'] = sanitize_text_field($widget_data['label']);
		
		return $clean_widget;
	}
	
	private function clean_reset_widget($widget_data)
	{
		$clean_widget = array();
		
		$defaults = array(
			'heading'					=> '',
			'label'						=> 'Reset',
			'submit_form'				=> 'always',
			'input_type'				=> 'link'
		);
		
		$widget_data = array_replace($defaults, $widget_data);
		
		
		$clean_widget['type'] = sanitize_text_field($widget_data['type']);
		$clean_widget['heading'] = sanitize_text_field($widget_data['heading']);
		$clean_widget['input_type'] = sanitize_key($widget_data['input_type']);
		$clean_widget['submit_form'] = sanitize_key($widget_data['submit_form']);
		$clean_widget['label'] = sanitize_text_field($widget_data['label']);
		
		return $clean_widget;
	}
	
	
	//utility functions
	
	public function sanitize_checkbox($value)
	{
		if($value!="")
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function clean_exclude_ids($exclude_ids)
	{
		return implode(',', $this->arrayToInt(array_map('trim',explode(",", $exclude_ids))));
	}
	
	
	private function arrayToInt(array $arr)
	{
		foreach ($arr as &$a) {
			
			$a = trim($a);
			if($a!="")
			{
				$a = (int)$a;
			}
		}
		
		return array_filter($arr);
	}
	
}


<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Post_Meta_Number
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Field_Post_Meta_Number {

	private $use_transients = false;
	public function __construct($plugin_slug, $sfid) {

		$this->plugin_slug = $plugin_slug;
		$this->sfid = $sfid;
		$this->create_input = new Search_Filter_Generate_Input($this->plugin_slug, $sfid);
		
		global $wpdb;
		$this->cache_table_name = $wpdb->prefix . 'search_filter_cache';
		$this->term_results_table_name = $wpdb->prefix . 'search_filter_term_results';
	}

	public function round_tdp($number, $decimal_places){

		//we assume number are stored as 123456.78 so no need to format
		//$number = number_format( $number, $decimal_places, '.', '' );

		$multiplier = pow(10, (int)$decimal_places);
		$number = floor( (float) $number * $multiplier ) / $multiplier;
		return $number;
	}
	public function get($field_name, $args, $fields_defaults)
	{

		$returnvar = "";
		$defaults = $fields_defaults;

		$this->use_transients = Search_Filter_Helper::get_option( 'cache_use_transients' );
		$thousand_seperator = $args['thousand_seperator'];
		$decimal_point = $args['decimal_seperator'];
		$decimal_places = $args['decimal_places'];

		global $wpdb;
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$post_types_arr = $searchform->settings("post_types");
		$post_types = array();
		if(is_array($post_types_arr)){
			$post_types = array_keys($post_types_arr);
		}

		if($args['range_min_detect']==1) {

			$min_range_auto = $this->get_range_min_auto($post_types, $args);
			if($min_range_auto) {
				$args['range_min'] = $min_range_auto;
			}
		}

		if($args['range_max_detect']==1) {

			$max_range_auto = $this->get_range_max_auto($post_types, $args);
			if ( $max_range_auto ) {
				$args['range_max'] = $max_range_auto;
			}
		}

		//now format min / max according to decimal places
		//$value_formatted = number_format( (float)$max, $decimal_places, $decimal_point, $thousand_seperator );
		if(( $args['number_input_type']=="range-number" ) || ( $args['number_input_type']=="range-slider" )) {

			if($args['number_input_type']=="range-number" ){
				$decimal_places = 0;
			}

			$args['range_step'] = $this->round_tdp($args['range_step'], $decimal_places);;
			$step = $args['range_step'];
			if(round($step, 10) === 0.0) {
				$step = 1;
			}
			$args['range_min'] = $this->round_tdp($args['range_min'], $decimal_places);

			//make sure the max is an exact multiple of a step from the min
			$range_diff = (float) $args['range_max'] - (float) $args['range_min'];

			//now check if any remainder
			//if( 0 == ( $range_diff % $step ) ) {
			//if( 0 == fmod((float)$range_diff, (float)$step) ) {
			if( 0 != fmod((float)$range_diff, (float)$step) ) {

				$steps_in_range = $range_diff / $step;
				$wanted_steps = floor($steps_in_range) + 1;
				$wanted_range_diff = $wanted_steps * $step;

				$args['range_max'] = $args['range_min'] + $wanted_range_diff;
			}
			else {
				//then its a perfect division, so don't change
			}

		}

		$is_default = false;
		if(empty($defaults)){
			$is_default = true;

		}

		if(is_array($defaults))
		{
			if(!isset($defaults[0]))
			{
				$defaults[0] = $args['range_min'];
			}
			if(!isset($defaults[1]))
			{
				$defaults[1] = $args['range_max'];
			}				
		}
		else
		{
			$defaults = array($args['range_min'], $args['range_max']);
		}

		$defaults_formatted = $defaults;
		if( ( $args['number_input_type']=="range-slider" ) && ( $decimal_places > 0 ) ){

			//now check to see if we have decimal places... if so, then the input can be formatted with a different decimal
			//make sure all format is set correctly
			//actually, we only need to do this with the "defaults" or current value, to avoid the flicker
			$defaults_formatted = array();
			$defaults_formatted[0] = number_format( (float)$defaults[0], $decimal_places, $decimal_point, $thousand_seperator );
			$defaults_formatted[1] = number_format( (float)$defaults[1], $decimal_places, $decimal_point, $thousand_seperator );
		}

		$input_args = array(
			'name' 						=>	$field_name,
			'range_min' 				=>	$args['range_min'],
			'range_max' 				=>	$args['range_max'],
			'range_step' 				=>	$args['range_step'],
			'default_min' 				=>	$defaults[0],
			'default_max'				=>	$defaults[1],
			'default_min_formatted'		=>	$defaults_formatted[0],
			'default_max_formatted'		=>	$defaults_formatted[1],
			'range_value_prefix'		=>	$args['range_value_prefix'],
			'range_value_postfix'		=>	$args['range_value_postfix'],
			'number_is_decimal'			=>	$args['number_is_decimal'],
			'accessibility_label'		=>	$args['number_accessibility_label'],
			
			'thousand_seperator'		=> $args['thousand_seperator'],
			'decimal_seperator'		    => $args['decimal_seperator'],
			'decimal_places'			=> $args['decimal_places'],
			'number_values_seperator'	=> $args['number_values_seperator'],
			'number_display_values_as'	=> $args['number_display_values_as']
		);
		
		$option_args = array(
			'name_sf' 					=> $field_name,
			'min'						=> $args['range_min'],
			'max'						=> $args['range_max'],
			'step'						=> $args['range_step'],
			
			'thousand_seperator'		=> $args['thousand_seperator'],
			'decimal_seperator'		    => $args['decimal_seperator'],
			'decimal_places'			=> $args['decimal_places'],
			
			'prefix'					=> $args['range_value_prefix'],
			'postfix'					=> $args['range_value_postfix']
		);
		
		
		if($args['all_items_label_number']=="")
		{
			$option_args['show_option_all_sf'] = __("All Items", $this->plugin_slug);
		}
		else
		{
			$option_args['show_option_all_sf'] = $args['all_items_label_number'];
		}
		
		if($args['number_input_type']=="range-slider")
		{
			$returnvar .= $this->create_input->range_slider($input_args);
		}
		else if($args['number_input_type']=="range-number")
		{
			$returnvar .= $this->create_input->range_number($input_args);
		}
		else if($args['number_input_type']=="range-select")
		{
			if($args['number_display_input_as']=="fromtofields")
			{
				$input_args['options'] = $this->get_range_options($option_args);

				//adjust max option based on the new range options generated (max can change because of the step value in the range)
				$last_option_i = count($input_args['options']) - 1;
				$max_option = $input_args['options'][$last_option_i]->value;

				if($is_default===true){

					//set the default to option, to max, when nothing has been selected
					$input_args['default_max'] = $max_option;
					$input_args['default_max_formatted'] = number_format( (float)$max_option, $decimal_places, $decimal_point, $thousand_seperator );
				}
				//adjust max option based on the new range options generated (max can change because of the step value in the range)
				$input_args['range_max'] = $max_option;

				$returnvar .= $this->create_input->range_select($input_args);
			}
			else if($args['number_display_input_as']=="singlefield")
			{
				//setup any custom attributes
				$attributes = array();
				
				//finalise input args object
				$option_args['show_default_option_sf'] = true;
				$input_args['options'] = $this->get_range_single_options($option_args);
				$input_args['attributes'] = $attributes;
				
				$select_defaults = array($defaults[0]."+".$defaults[1]);
				$input_args['defaults'] = $select_defaults;
				
				$returnvar .= $this->create_input->select($input_args);
			}
		}
		else if($args['number_input_type']=="range-radio")
		{
			//setup any custom attributes
			$attributes = array();
			
			if($args['number_display_input_as']=="fromtofields")
			{
				$input_args['options'] = $this->get_range_options($option_args);

				//adjust max option based on the new range options generated (max can change because of the step value in the range)
				$last_option_i = count($input_args['options']) - 1;
				$max_option = $input_args['options'][$last_option_i]->value;

				if($is_default===true){

					//set the default to option, to max, when nothing has been selected
					$input_args['default_max'] = $max_option;
					$input_args['default_max_formatted'] = number_format( (float)$max_option, $decimal_places, $decimal_point, $thousand_seperator );
				}
				//adjust max option based on the new range options generated (max can change because of the step value in the range)
				$input_args['range_max'] = $max_option;

				$returnvar .= $this->create_input->range_radio($input_args);
			}
			else if($args['number_display_input_as']=="singlefield")
			{
				$defaults = array("");
				if(count($fields_defaults)>0)
				{
					$defaults = array(implode("+", $fields_defaults));
				}
				
				$input_args['defaults'] = $defaults;
				
				//finalise input args object
				$option_args['show_default_option_sf'] = true;
				//$option_args['show_count_format_sf'] = 'html';
				
				$input_args['options'] = $this->get_range_single_options($option_args);
				$input_args['attributes'] = $attributes;
								
				$returnvar .= $this->create_input->radio($input_args);
			}
		}
		else if($args['number_input_type']=="range-checkbox")
		{
			$returnvar .= $this->create_input->generate_range_checkbox($field_name, $args['range_min'], $args['range_max'], $args['range_step'], $args['range_min'], $args['range_max'], $args['range_value_prefix'], $args['range_value_postfix']);
		}
		
		return $returnvar;
	}

	public function get_range_min_auto($post_types, $args) {

		$min_field_name = '_sfm_'.$args['number_start_meta_key'];
		$range_min_trans = false;
		$cache_key = '';

		if ($this->use_transients == 1) {

			$cache_key = 'field_range_min_' . $this->sfid.'_'.$min_field_name;
			$range_min_trans = Search_Filter_Wp_Cache::get_transient( $cache_key );
		}

		if(false === $range_min_trans) {
			//lookup min
			$min_query = new WP_Query( array( 'post_type' => $post_types, 'post_status' => 'publish', 'orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_key' => $args['number_start_meta_key'], 'posts_per_page' => 1, 'suppress_filters' => true,
				'meta_query'=> array(
					'key'     => $args['number_start_meta_key'],
					'value'   => '',
					'compare' => '!='
				)) );
			$min_posts = $min_query->get_posts();

			if( (count($min_posts)==1) && (isset($min_posts[0])) ){
				$min_post = $min_posts[0];
				if(isset($min_post->ID)) {
					$min_value       = get_post_meta( $min_post->ID, $args['number_start_meta_key'], true );
					$range_min_trans = $min_value;
				}
			}
		}
		else{
			//echo "using transient min, bypass<br />\n";
		}



		if( ($this->use_transients == 1) && ( false !== $range_min_trans) ) {
			$transient_lifespan = DAY_IN_SECONDS / 24; //1hr
			Search_Filter_Wp_Cache::set_transient($cache_key, $range_min_trans, $transient_lifespan);
		}


		return $range_min_trans;

	}
	public function get_range_max_auto($post_types, $args) {


		$min_field_name = '_sfm_'.$args['number_start_meta_key'];
		$range_max_trans = false;
		$cache_key = '';

		if ($this->use_transients == 1) {

			$cache_key = 'field_range_max_' . $this->sfid.'_'.$min_field_name;
			$range_max_trans = Search_Filter_Wp_Cache::get_transient( $cache_key );
		}

		if(false === $range_max_trans) {
			//lookup max
			//$max_field_name = '_sfm_'.$args['number_start_meta_key'];
			$max_meta_key = $args['number_start_meta_key'];

			$use_same_as_start = $args['number_use_same_toggle'];
			if(!$use_same_as_start) {
				//$max_field_name = '_sfm_'.$args['number_end_meta_key'];
				$max_meta_key = $args['number_end_meta_key'];
			}

			//lookup max
			$max_query = new WP_Query( array( 'post_type' => $post_types, 'post_status' => 'publish',
			                                  'orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => $max_meta_key, 'posts_per_page' => 1) );
			$max_posts = $max_query->get_posts();
			if( (count($max_posts)==1) && (isset($max_posts[0])) ){
				$max_post = $max_posts[0];
				if(isset($max_post->ID)) {
					$max_value       = get_post_meta( $max_post->ID, $max_meta_key, true );
					$range_max_trans = $max_value;
				}
			}
		}
		else{
			//echo "using transient max, bypass<br />\n";
		}

		if( ($this->use_transients == 1) && ( false !== $range_max_trans) ) {
			$transient_lifespan = DAY_IN_SECONDS / 24; //1hr
			Search_Filter_Wp_Cache::set_transient($cache_key, $range_max_trans, $transient_lifespan);
		}


		return $range_max_trans;

	}
	private function get_range_single_options($args)
	{
		//options is passed by ref, so when `wp_list_categories` is finished running, it will contain an object of all options for this field.
		$options = array();
		$name = $args['name_sf'];
				
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$this->auto_count = $searchform->settings("enable_auto_count");
		$this->auto_count_deselect_emtpy = $searchform->settings("auto_count_deselect_emtpy");
		
		
		$min = $args['min'];
		$max = $args['max'];
		$step = $args['step'];
		$thousand_seperator = $args['thousand_seperator'];
        $decimal_point = $args['decimal_seperator'];
		$decimal_places = $args['decimal_places'];
		
		$diff = $max - $min;
		$istep = ceil($diff/$step);
		
		$input_class = SF_CLASS_PRE."input-select";
		
		$value_prefix = $args['prefix'];
		$value_postfix = $args['postfix'];
		
		/*if(isset($all_items_label))
		{
			if($all_items_label!="")
			{//check to see if all items has been registered in field then use this label
				$returnvar .= '<option class="level-0" value="">'.esc_html($all_items_label).'</option>';
			}
		}*/
		
		
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
		
		
		
		$value = $min;

		for($value=$min; $value<=$max; $value+=$step)
		{
			$min_val = (float) $value;
			$max_val = (float) $min_val + $step;

			/*if($max_val>$max)
			{
				$max_val = (float) $max;
			}*/
			
			$min_label = number_format( (float)$min_val, $decimal_places, $decimal_point, $thousand_seperator );
			$max_label = number_format( (float)$max_val, $decimal_places, $decimal_point, $thousand_seperator );
			
			$option = new stdClass();
			$option->label = $value_prefix.$min_label.$value_postfix." - ".$value_prefix.$max_label.$value_postfix;
			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);
			
			
			$option->value = $min_val.'+'.$max_val;
			array_push($options, $option);
			
		}
		
		
		
		return $options;
	}
	
	private function get_range_options($args)
	{
		//options is passed by ref, so when `wp_list_categories` is finished running, it will contain an object of all options for this field.
		$options = array();
		$name = $args['name_sf'];

		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$this->auto_count = $searchform->settings("enable_auto_count");
		$this->auto_count_deselect_emtpy = $searchform->settings("auto_count_deselect_emtpy");
		
		
		$min = $args['min'];
		$max = $args['max'];
		$step = $args['step'];
		$thousand_seperator = $args['thousand_seperator'];
        $decimal_point = $args['decimal_seperator'];
		$decimal_places = $args['decimal_places'];

		$value = $min;

		//for($value=$min; $value<=$max; $value+=$step)
		for($value=$min; $value<=$max+$step; $value+=$step)
		{
			$value_formatted = number_format( (float)$value, $decimal_places, $decimal_point, $thousand_seperator );
			
			$option = new stdClass();
			$option->label = $value_formatted;
			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);
			
			
			$option->value = $value;
			array_push($options, $option);
		}

		
		/*if(($value-$step)!=$max)
		{
			$option = new stdClass();

			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);

            $value_formatted = number_format( (float)$max, $decimal_places, $decimal_point, $thousand_seperator );
            $option->label = $value_formatted;
            $option->value = $max;
			array_push($options, $option);
		}*/

		
		return $options;
	}
}

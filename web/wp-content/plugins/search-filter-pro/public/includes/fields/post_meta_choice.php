<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Post_Meta_Choice
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Field_Post_Meta_Choice {
	
	public function __construct($plugin_slug, $sfid) {

		$this->plugin_slug = $plugin_slug;
		$this->sfid = $sfid;
		$this->create_input = new Search_Filter_Generate_Input($this->plugin_slug, $sfid);
		
		$this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');
	}
	
	public function get($field_name, $args, $fields_defaults)
	{
		if(count($fields_defaults)==0)
		{
			$fields_defaults = array("");
		}
		
		$returnvar = "";
		
		$meta_options = array();
		
		$input_args = array(
			'name'			=> $field_name,
			'defaults'		=> $fields_defaults,
			'attributes'	=> array(),
			'options'		=> array()
		);
		
		$args['show_count_format_sf'] = "inline";
		$args['show_default_option_sf'] = false;
		$args['name_sf'] = $field_name;
		
		if($args['choice_input_type']=="select")
		{
			//setup any custom attributes
			$attributes = array();
			if($args['combo_box']==1)
			{
				$attributes['data-combobox'] = '1';
			}
			
			$args['show_default_option_sf'] = true;
			
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			$input_args['accessibility_label'] = $args['choice_accessibility_label'];
			
			$returnvar .= $this->create_input->select($input_args);
			
		}
		if($args['choice_input_type']=="checkbox")
		{
			$attributes = array();
			$attributes['data-operator'] = $args['operator'];
			
			$args['show_count_format_sf'] = "html";
			
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			
			$returnvar .= $this->create_input->checkbox($input_args);
		}
		else if($args['choice_input_type']=="radio")
		{
			$attributes = array();
			
			$args['show_default_option_sf'] = true;
			$args['show_count_format_sf'] = "html";
			
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			
			$returnvar .= $this->create_input->radio($input_args);
		}
		else if($args['choice_input_type']=="multiselect")
		{
			//setup any custom attributes
			$attributes = array();
			
			$attributes['data-operator'] = $args['operator'];
			
			if($args['combo_box']==1)
			{
				$attributes['data-combobox'] = '1';
				$attributes['data-placeholder'] = $args['show_option_all_sf'];
			}			
			$attributes['multiple'] = "multiple";
			
			//finalise input args object
			$input_args['options'] = $this->get_options($args);
			$input_args['attributes'] = $attributes;
			$input_args['accessibility_label'] = $args['choice_accessibility_label'];
			
			$returnvar .= $this->create_input->select($input_args);
		}
		
		return $returnvar;
	}
	
	private function get_options_manual($args)
	{
		$options = array();
		
		$name = $args['name_sf'];
		$show_option_all_sf = $args['show_option_all_sf'];
		$show_default_option_sf = $args['show_default_option_sf'];
		$show_count = $args['show_count'];
		$show_count_format_sf = $args['show_count_format_sf'];
		$hide_empty = $args['hide_empty'];
		
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$this->auto_count = $searchform->settings("enable_auto_count");
		$this->auto_count_deselect_emtpy = $searchform->settings("auto_count_deselect_emtpy");
		
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
		
		if(isset($args['meta_options']))
		{
			if(is_array($args['meta_options']))
			{
				$meta_options = array();
				
				foreach ($args['meta_options'] as $meta_option)
				{
                    $option = $this->create_option($name, $meta_option['option_value'], $meta_option['option_label'], $hide_empty, $show_count, $show_count_format_sf);

                    if($option)
                    {
                        array_push($options, $option);
                    }

				}
			}
		}
		
		return $options;
	}
	private function get_options($args)
	{
		if($args['choice_get_option_mode']=="manual")
		{
			return $this->get_options_manual($args);
		}
		else if($args['choice_get_option_mode']=="auto")
		{
			return $this->get_options_auto($args);
		}
	}
	
	private function get_options_from_cache($args)
	{
		//now check the DB for the options in this field and build options
		$name = $args['name_sf'];
		
		$options = array();
		
		global $wpdb;
		global $searchandfilter;
		
		
		$name = $args['name_sf'];
		$show_option_all_sf = $args['show_option_all_sf'];
		$show_default_option_sf = $args['show_default_option_sf'];
		$show_count = $args['show_count'];
		$show_count_format_sf = $args['show_count_format_sf'];
		$hide_empty = $args['hide_empty'];
		
		$order_type = $args['choice_order_option_type'];
		$order_dir = $args['choice_order_option_dir'];
		
		if($order_type=="numeric")
		{
			$order_by =  "cast(field_value AS UNSIGNED) $order_dir";
		}
		else
		{
			$order_by =  "field_value $order_dir";
		}

		$this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');
		
		$field_options = $wpdb->get_results( 
			"
			SELECT field_value
			FROM $this->term_results_table_name
			WHERE BINARY field_name = '$name' AND field_value != ''
			ORDER BY $order_by
			"
		);
		
		foreach($field_options as $field_option)
		{
            $option = $this->create_option($name, $field_option->field_value, $field_option->field_value, $hide_empty, $show_count, $show_count_format_sf);

            if($option)
            {
                array_push($options, $option);
            }

        }
		
		return $options;
	}
	
	private function get_options_auto($args)
	{
		$options = array();
		
		$name = $args['name_sf'];
		$show_option_all_sf = $args['show_option_all_sf'];
		$show_default_option_sf = $args['show_default_option_sf'];
		$show_count = $args['show_count'];
		$show_count_format_sf = $args['show_count_format_sf'];
		$hide_empty = $args['hide_empty'];
		
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$this->auto_count = $searchform->settings("enable_auto_count");
		$this->auto_count_deselect_emtpy = $searchform->settings("auto_count_deselect_emtpy");
		
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
		
		/*$pre_options = array();
		if(has_filter('sf_pre_options_build')) {
			$pre_options = apply_filters('sf_pre_options_build', $pre_options, $args);
		}
		*/
		$is_acf = $args['choice_is_acf'];
		$pre_options = array();
		if($is_acf==1){

			$pre_options = $this->get_acf_options($args);
			$options = array_merge($options, $pre_options);
		}
		
		if(empty($pre_options)){

			$cache_options = $this->get_options_from_cache($args);
			$options = array_merge($options, $cache_options);
		}
		
		return $options;
	}
	
	private function find_post_id_with_field($field_name)
	{
		global $wpdb;

		$this->term_results_table_name = Search_Filter_Helper::get_table_name('search_filter_term_results');
		$field_options = $wpdb->get_results( $wpdb->prepare(
			"
			SELECT field_value, result_ids
			FROM $this->term_results_table_name
			WHERE field_name = '%s' AND result_ids != '' LIMIT 0,1
			",
			$field_name
		));
		
		
		foreach($field_options as $field_option)
		{
			
			$post_ids = explode(",", $field_option->result_ids);
			
			if(isset($post_ids[0]))
			{
				return $post_ids[0];
			}
		}
		
		return 0;
	}

	private function find_post_id_with_field_2($meta_key)
	{
		global $wpdb;
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);

		$post_types_arr = $searchform->settings("post_types");
		$post_types = array();
		if(is_array($post_types_arr)){
			$post_types = array_keys($post_types_arr);
		}

		$args = array(
			'post_type' => $post_types,
			'fields' => 'ids',
			'posts_per_page' => 1,
			'post_status'=>'publish',
			'meta_query' => array(
				array(
					'key' => $meta_key,
					'compare' => 'EXISTS'
				)
			)
		);

		$query = new WP_Query($args);
		//$results = $query->get_posts();
		$post_id = 0;

		if ( $query->have_posts() ){

			foreach($query->posts as $posts_id){
				$post_id = $posts_id;
			}
		}

		return $post_id;
	}

	private function get_acf_options($args)
	{
		$options = array();
		
		if(!function_exists('get_field_object'))
		{
			return $options;
		}

		$name = $args['name_sf'];
		$show_option_all_sf = $args['show_option_all_sf'];
		$show_default_option_sf = $args['show_default_option_sf'];
		$show_count = $args['show_count'];
		$show_count_format_sf = $args['show_count_format_sf'];
		$hide_empty = $args['hide_empty'];

		//$post_id = $this->find_post_id_with_field($name); //acf needs to have at least 1 post id with the post meta attached in order to lookup the rest of the field
		$post_id = $this->find_post_id_with_field_2($args['meta_key']); //acf needs to have at least 1 post id with the post meta attached in order to lookup the rest of the field
		$field = get_field_object($args['meta_key'], $post_id);

		$options_array = array();
		
		if(!isset($field['choices']))
		{
			if(($field['type']=="post_object")||($field['type']=="page_link")||($field['type']=="relationship"))
			{
				$cached_options = $this->get_options_from_cache($args);

				foreach($cached_options as $sf_option)
				{
					$sf_option->label = get_the_title($sf_option->value);
					
					$option = $this->create_option($name, $sf_option->value, $sf_option->label, $hide_empty, $show_count, $show_count_format_sf);
			
					if($option)
					{
						array_push($options, $option);
					}
				}
				
				//$field['return_format']==strtolower("object")
				
			}
			else if($field['type']=="taxonomy")
			{
				$taxonomy = $field['taxonomy'];
				
				$cached_options = $this->get_options_from_cache($args);
				
				foreach($cached_options as $sf_option)
				{
					$term = get_term($sf_option->value, $taxonomy);
					
					if($term)
					{
						$sf_option->label = $term->name;
						
						$option = $this->create_option($name, $sf_option->value, $sf_option->label, $hide_empty, $show_count, $show_count_format_sf);
				
						if($option)
						{
							array_push($options, $option);
						}
					}
				}
			}
			else if($field['type']=="user")
			{
				//$taxonomy = $field['taxonomy'];
				
				$cached_options = $this->get_options_from_cache($args);
				
				foreach($cached_options as $sf_option)
				{
					$user = get_user_by('ID', (int)$sf_option->value);
					
					if($user)
					{
						
						//$options_array[$sf_option->value] = $sf_option->label;
						
						//$sf_option->label = $user->user_nicename;
						$sf_option->label = $user->display_name;
						
						$option = $this->create_option($name, $sf_option->value, $sf_option->label, $hide_empty, $show_count, $show_count_format_sf);
				
						if($option)
						{
							array_push($options, $option);
						}
					}
				}
			}
			
		}
		else if(isset($field['choices']))
		{
			$choices = $field['choices'];
			
			foreach( $choices as $value => $label )
			{			
				$option = $this->create_option($name, $value, $label, $hide_empty, $show_count, $show_count_format_sf);
				
				if($option)
				{
					array_push($options, $option);
				}
			}
		}
		
		//sort the options
		if(!empty($options))
		{
			$order_type = $args['choice_order_option_type'];
			$order_dir = $args['choice_order_option_dir'];
			$order_by = $args['choice_order_option_by'];

            $options = $this->sort_arr_of_obj($options, $order_by, $order_dir, $order_type);
		}
		
		return $options;
		
	}
	private function sort_arr_of_obj($array, $sortby, $direction = 'asc', $order_type = 'numeric') {

        if($sortby=="none") {
            return $array;
        }

		$sortedArr = array();
		$tmp_Array = array();

		foreach($array as $k => $v) {
			$tmp_Array[] = strtolower($v->$sortby);
		}
		
		if($order_type=="numeric")
		{
			$sort_type = SORT_NUMERIC;
		}
		else
		{
			$sort_type = SORT_STRING;
		}
		
		if($direction=='asc'){
			asort($tmp_Array, $sort_type);
		}else{
			arsort($tmp_Array, $sort_type);
		}

		foreach($tmp_Array as $k=>$tmp){
			$sortedArr[] = $array[$k];
		}

		return $sortedArr;

	}

	private function create_option($field_name, $value, $label, $hide_empty, $show_count, $show_count_format = "inline")
	{
		if($this->auto_count==1)
		{
			global $searchandfilter;
			$option_count = $searchandfilter->get($this->sfid)->get_count_var($field_name, ($value));
		}
		else
		{
			$option_count = -1;
		}
		
		$option = new stdClass();
		
		if((intval($hide_empty)!=1)||($option_count!=0))
		{
			$option->label = $label;
			$option->count = $option_count;
			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);
			$option->value = $value;
			
			if(($show_count==1)&&($option_count!=-1))
			{
				if($show_count_format=="inline")
				{
					$option->label .= '&nbsp;&nbsp;(' . number_format_i18n($option_count) . ')';
				}
				else if($show_count_format=="html")
				{
					$option->label .= '<span class="sf-count">(' . number_format_i18n($option_count) . ')</span>';
				}
			}
			
			return $option;
		}
		else
		{
			return false;
		}
	}
}

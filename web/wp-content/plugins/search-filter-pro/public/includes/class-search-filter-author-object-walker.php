<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Author_Walker
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Author_Object_Walker {
	
	private $type;
	private $options;
	
	function __construct(&$options_obj){

		$this->options = array();
		$this->options_obj = $options_obj;
	}
	
	function wp_authors($args = '') {
		
		global $wpdb;
		
		$defaults = array(
			'orderby' => 'name', 'order' => 'ASC', 'number' => '',
			'optioncount' => false, 'exclude_admin' => true,
			'show_fullname' => false, 'hide_empty' => true,
			'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
			'style' => 'list', 'html' => true, 'exclude' => '', 'include' => '',
			'post_types' => array('post'), 'combo_box' => ''
			
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args, EXTR_SKIP );
				
		$return = '';

		$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include' ) );
		$query_args['fields'] = 'ids';
		$authors = get_users( $query_args );
		
		//build where conditions for post types...
		
		$where_conditions = array();
		$post_type_count = count($post_types);
		$where_query = '';
		if($post_type_count>0)
		{
			foreach($post_types as $post_type)
			{
				if(post_type_exists($post_type))
				{
					$post_type = esc_attr($post_type);
					$where_conditions[] = " (post_type = '$post_type' AND " . get_private_posts_cap_sql( $post_type ) . ")";
				}
			}
			$where_query = implode(" OR", $where_conditions);
		}
		
		$author_count = array();
		foreach ( (array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE$where_query GROUP BY post_author") as $row )
			$author_count[$row->post_author] = $row->count;
		
		
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
			$default_option->count = 0;
			array_push($this->options, $default_option);
		}
		
		foreach ( $authors as $author_id ) {
			
			$author = get_userdata( $author_id );

			if ( $exclude_admin && 'admin' == $author->display_name )
				continue;

			$option_count = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

			if ( !$option_count && $hide_empty )
				continue;

			$link = '';

			if ( $show_fullname && $author->first_name && $author->last_name )
				$name = "$author->first_name $author->last_name";
			else
				$name = $author->display_name;

			/*if ( !$html ) {
				$return .= $name . ', ';

				continue; // No need to go further to process HTML.
			}*/
			
			if ( $optioncount )
			{
				if($show_count_format_sf=="inline")
				{
					$name .= ' ('. number_format_i18n($option_count) . ')';
				}
				else if($show_count_format_sf=="html")
				{
					$name .= '<span class="'.SF_CLASS_PRE.'count">('. number_format_i18n($option_count) . ')</span>';
				}
				
			}
			
			$option = new stdClass();
			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0'
			);
			
			$option->value = $author->user_nicename;
			//$option->selected_value = $author->ID; //we want to match defaults based on ID
			$option->label = $name;
			$option->count = $option_count;
			
			array_push($this->options, $option);
		}
		
		$this->options_obj->set($this->options);
	}
}

?>
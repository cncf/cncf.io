<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Taxonomy
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Field_Taxonomy extends Search_Filter_Field_Base {
	
	public function get($field_data)
	{
		
		global $searchandfilter;
		
		$search_form_id = $this->sfid;
		
		$returnvar = "";
		
		//set defaults so no chance of any php errors when accessing un init vars
		$defaults = array(
			'taxonomy_name'			=> '',
			'input_type'			=> '',
			'heading'				=> '',
			'all_items_label'		=> '',
			'accessibility_label'	=> '',
			'operator'				=> '',
			'show_count'			=> '',
			'hide_empty'			=> '',
			'hierarchical'			=> '',
			'drill_down'			=> '',
			'order_by'				=> '',
			'order_dir'				=> '',
			'exclude_ids'			=> '',
			'sync_include_exclude'	=> '',
			'combo_box'				=> '',
			'no_results_message'	=> ''
		);
		
		$values = array_replace($defaults, $field_data);
				
		$taxonomydata = get_taxonomy($values['taxonomy_name']);
		
		$field_name = SF_TAX_PRE . $values['taxonomy_name'];
		
		$fields_defaults = $this->current_query->get_field_values($field_name);
		if(count($fields_defaults)==0)
		{
			$fields_defaults = array("");
		}
		
		if(($values['all_items_label']=="")&&(isset($taxonomydata->labels->all_items)))
		{
			$values['all_items_label'] = $taxonomydata->labels->all_items;
		}
		
		//check the taxonomy exists
		if($taxonomydata)
		{
			$args = array(
				'sf_name' => $field_name,
				'sfid' => $search_form_id,
				'taxonomy' => $values['taxonomy_name'],
				'hierarchical' => (bool)$values['hierarchical'],
				'child_of' => 0,
				'echo' => false,
				'hide_if_empty' => false,
				'hide_empty' => (bool)$values['hide_empty'],
				'show_option_none' => '',
				'show_count' => (bool)$values['show_count'],
				'show_option_all' => '',
				'show_option_all_sf' => esc_attr($values['all_items_label']),
				'show_default_option_sf' => false,
				'show_count_format_sf' => "inline",
				'elem_attr' => ""
			);

			if(($values['order_by']!="default")&&($values['order_by']!=""))
			{
				$args['orderby'] = $values['order_by'];
				$args['order'] = $values['order_dir'];
			}
			
			if($values['sync_include_exclude']==1)
			{
				
				//global $searchandfilter;
				
				if($searchandfilter->get($search_form_id)->settings('taxonomies_settings')!="")
				{
					
					if(is_array($searchandfilter->get($search_form_id)->settings('taxonomies_settings')))
					{
						$taxonomies_settings = $searchandfilter->get($search_form_id)->settings('taxonomies_settings');
						
						if($field_data['type']=="category")
						{
							if(isset($taxonomies_settings['category']))
							{
								if(isset($taxonomies_settings['category']['include_exclude']))
								{
									if($taxonomies_settings['category']['include_exclude']=="include")
									{
										$args['include'] = $taxonomies_settings['category']['ids'];
									}
									else
									{
										
										
										if($values['input_type']=="select")
										{
											if(!(bool)$values['hierarchical'])
											{//if not hierearchical exclude categories as normal
												$args['exclude'] = $taxonomies_settings['category']['ids'];
											}
											else
											{//else exclude category and its children when using hierarchical
												$args['exclude_tree'] = $taxonomies_settings['category']['ids'];
											}
										}
										else
										{
											$args['exclude'] = $taxonomies_settings['category']['ids'];
										}
									}
								
								}
							}
							
						}
						else if($field_data['type']=="tag")
						{
							if(isset($taxonomies_settings['post_tag']))
							{
								if(isset($taxonomies_settings['post_tag']['include_exclude']))
								{
									if($taxonomies_settings['post_tag']['include_exclude']=="include")
									{
										$args['include'] = $taxonomies_settings['post_tag']['ids'];
									}
									else
									{
										if($values['input_type']=="select")
										{
											if(!(bool)$values['hierarchical'])
											{//if not hierearchical exclude categories as normal
												$args['exclude'] = $taxonomies_settings['post_tag']['ids'];
											}
											else
											{//else exclude post_tag and its children when using hierarchical
												$args['exclude_tree'] = $taxonomies_settings['post_tag']['ids'];
											}
										}
										else
										{
											$args['exclude'] = $taxonomies_settings['post_tag']['ids'];
										}
									}
								
								}
							}
							
						}
						else if($field_data['type']=="taxonomy")
						{
							if(isset($taxonomies_settings[$values['taxonomy_name']]))
							{
								if(isset($taxonomies_settings[$values['taxonomy_name']]['include_exclude']))
								{
									if($taxonomies_settings[$values['taxonomy_name']]['include_exclude']=="include")
									{
										$args['include'] = $taxonomies_settings[$values['taxonomy_name']]['ids'];
									}
									else
									{
										if($values['input_type']=="select")
										{
											if(!(bool)$values['hierarchical'])
											{//if not hierearchical exclude categories as normal
												$args['exclude'] = $taxonomies_settings[$values['taxonomy_name']]['ids'];
											}
											else
											{//else exclude taxonomy and its children when using hierarchical
												$args['exclude_tree'] = $taxonomies_settings[$values['taxonomy_name']]['ids'];
											}
										}
										else
										{
											$args['exclude'] = $taxonomies_settings[$values['taxonomy_name']]['ids'];
										}
									}
								}
							}
						}
					}
				}
			}
			else
			{
				
				if($values['input_type']=="select")
				{
					if(!(bool)$values['hierarchical'])
					{//if not hierearchical exclude categories as normal
						$args['exclude'] = $values['exclude_ids'];
					}
					else
					{//else exclude category and its children when using hierarchical
						$args['exclude_tree'] = $values['exclude_ids'];
					}
				}
				else
				{
					$args['exclude'] = $values['exclude_ids'];
				}
			}
			
			/* setup defaults */
			$args['title_li'] = '';
			$args['defaults'] = "";

			if($values['input_type']=="select")
			{
				$attributes = array();
				
				if($values['combo_box']==1)
				{
					$attributes['data-combobox'] = '1';

					if(!empty($values['no_results_message'])){
						$attributes['data-combobox-nrm'] = $values['no_results_message'];
					}

				}			
				$args['show_default_option_sf'] = true;
				
				$input_args = array(
					'name'					=> SF_TAX_PRE.$values['taxonomy_name'],
					'options'				=> $this->get_options($args),
					'defaults'				=> $fields_defaults,
					'attributes'			=> $attributes,
					'accessibility_label'	=> $values['accessibility_label']
				);

				$returnvar .= $this->create_input->select($input_args);
			}
			else if($values['input_type']=="checkbox")
			{
				$attributes = array();
				
				$attributes['data-operator'] = $values['operator'];
				$args['show_count_format_sf'] = "html";
				
				$input_args = array(
					'name'			=> SF_TAX_PRE.$values['taxonomy_name'],
					'options'		=> $this->get_options($args),
					'defaults'		=> $fields_defaults,
					'attributes'	=> $attributes
				);

				$returnvar .= $this->create_input->checkbox($input_args);
			}
			else if($values['input_type']=="list")
			{
				//$args['elem_attr'] .= ' data-operator="'.esc_attr($values['operator']).'"';
				//$returnvar .= $this->create_input->generate_wp_list($args, $values['taxonomy_name'], $taxonomydata->labels);
			}
			else if($values['input_type']=="radio")
			{
				$attributes = array();
				$args['show_count_format_sf'] = "html";
				$args['show_default_option_sf'] = true;
				
				$input_args = array(
					'name'			=> SF_TAX_PRE.$values['taxonomy_name'],
					'options'		=> $this->get_options($args),
					'defaults'		=> $fields_defaults,
					'attributes'	=> $attributes
				);

				$returnvar .= $this->create_input->radio($input_args);
			}
			else if($values['input_type']=="multiselect")
			{	
				$attributes = array();
				
				if($values['combo_box']==1)
				{
					$attributes['data-combobox'] = '1';
					if(!empty($values['no_results_message'])){
						$attributes['data-combobox-nrm'] = $values['no_results_message'];
					}
				}	
				
				$attributes['data-placeholder'] = $values['all_items_label'];
				$attributes['data-operator'] = $values['operator'];
				$attributes['multiple'] = "multiple";
				
				$input_args = array(
					'name'					=> SF_TAX_PRE.$values['taxonomy_name'],
					'options'				=> $this->get_options($args),
					'defaults'				=> $fields_defaults,
					'attributes'			=> $attributes,
					'accessibility_label'	=> $values['accessibility_label']
				);

				$returnvar .= $this->create_input->select($input_args);
			}
		}
		
		return $returnvar;
	}
	
	private function get_options($args)
	{
		//options is passed by ref, so when `wp_list_categories` is finished running, it will contain an object of all options for this field.
		$options = array();
		
		$options_obj = new Search_Filter_Taxonomy_Options();
		global $searchandfilter;
		//use a walker to silence output, and create a custom object which is stored in `$options`

		// @ todo - for efficency, figure out if we're using ustom post stati
		// if not using custom post stati, then use regular `hide_empty` (the WP query is more efficient)
		$args['walker'] = new Search_Filter_Taxonomy_Object_Walker($args['sf_name'], $options_obj);
		$args['sf_hide_empty'] = $args['hide_empty'];
		$args['hide_empty'] = false;
		
		$output = wp_list_categories($args); //nothing is returned here but `$options` is updated
		$options = $options_obj->get();

        return $options;
		
	}
}

class Search_Filter_TTT //TTT - taxonomy term templates
{
    public static $term_templates = array();

    public static function get_template($taxonomy_name)
    {
        if(isset(self::$term_templates[$taxonomy_name])) {
            return self::$term_templates[$taxonomy_name];
        }
        else{
            return array();
        }
    }
    public static function add_templates($templates, $taxonomy_name)
    {
        self::$term_templates[$taxonomy_name] = $templates;
    }
    public static function add_template($template, $depth, $taxonomy_name)
    {
        if(!isset(self::$term_templates[$taxonomy_name]))
        {
            self::$term_templates[$taxonomy_name] = array();
        }

        self::$term_templates[$taxonomy_name][$depth] = $template;

        //echo "$taxonomy_name ( $depth )<br />\n";
        //echo $template."<br /><br />\n";
        //array_push(self::$term_templates[$taxonomy_name], $template);
    }
}

class Search_Filter_Taxonomy_Options {
	
	private $options = array();
	
	public function set($options)
	{
		$this->options = $options;
	}
	public function get()
	{
		return $this->options;
	}
}



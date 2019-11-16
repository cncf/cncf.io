<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Post_Data
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */
 
class Search_Filter_Config
{
	private $plugin_slug = '';
    private $form_data = array();
	private $count_table;
	private $cache;
	public $query;
	public $current_query;
	private $sfid = 0;
	
	function __construct($plugin_slug, $sfid)
	{
		$this->plugin_slug = $plugin_slug;
		$this->init($sfid);
	}
	
	public function init($sfid)
	{
		if($this->sfid == 0 )
		{
			$this->sfid = $sfid;
			
			$this->init_settings($sfid);
		
			if(!isset($this->query))
			{
				$this->query = new Search_Filter_Query($this->sfid, $this->form_data['settings'], $this->form_data['fields_assoc'], $this->get_filters());
				$this->current_query = new Search_Filter_Active_Query($this->plugin_slug, $this->sfid, $this->form_data['settings'], $this->form_data['fields_assoc']);
			}
			
		}
	}
	
	public function query()
	{
		return($this->query);
	}

	public function current_query()
	{
		return $this->current_query;
	}
	
	public function get_field_by_key($key)
	{
		if(isset($this->form_data['fields_assoc'][$key]))
		{
			return $this->form_data['fields_assoc'][$key];
		}
		else
		{
			return false;
		}
	}
	
	public function set_count_table($count_table)
	{
		$this->count_table = $count_table;
	}
	
	public function get_count_table()
	{
		return $this->count_table;
	}
	
	public function get_count_var($field_name, $term_name)
	{
		if(isset($this->count_table[$field_name]))
		{
			if(isset($this->count_table[$field_name][$term_name]))
			{
				return $this->count_table[$field_name][$term_name];
			}
		}
		return 0;
	}
	
	public function init_settings($postid = '')
	{
		$form_id = $postid;
		
		$this->form_data['settings'] = Search_Filter_Helper::get_settings_meta($form_id);
		$this->form_data['fields'] = Search_Filter_Helper::get_fields_meta($form_id);
		$this->form_data['fields_assoc'] = array();
		$this->form_data['fields_taxonomies'] = array();
		$this->form_data['fields_meta'] = array();

		if(($this->form_data['settings'])&&($this->form_data['fields']))
		{
			$this->form_data['id'] = $form_id;
			$this->form_data['postid'] = $postid;
			$this->form_data['idref'] = $postid;
			
			//$fieldswkeys = array();
			
			foreach ($this->form_data['fields'] as $field)
			{
				if($field['type']=="post_meta")
				{
					$meta_key = $field['meta_key'];
					if(isset($field['meta_key_manual_toggle']))
					{
						if($field['meta_key_manual_toggle']==1)
						{
							$meta_key = $field['meta_key_manual'];
						}
					}
					$this->form_data['fields_assoc'][SF_META_PRE.$meta_key] = $field; //make fields accessible by key

					array_push($this->form_data['fields_meta'], $meta_key);
				}
				else if($field['type']=="taxonomy")
				{
					$taxonomy_name = $field['taxonomy_name'];
					
					$this->form_data['fields_assoc'][SF_TAX_PRE.$taxonomy_name] = $field; //make fields accessible by key
					
					array_push($this->form_data['fields_taxonomies'], $taxonomy_name);
				}
				else if(($field['type']=="tag")||($field['type']=="category"))
				{
				
					$taxonomy_name = $field['taxonomy_name'];
					
					$this->form_data['fields_assoc'][SF_TAX_PRE.$taxonomy_name] = $field; //make fields accessible by key
					
					/*if($this->is_using_custom_template())
					{//if we're using a custom template, treat tag and cat as normal taxonomies
						
						
						$this->form_data['fields_assoc'][SF_TAX_PRE.$taxonomy_name] = $field; //make fields accessible by key
					}
					else
					{//else make them special ;)
						$this->form_data['fields_assoc'][$field['type']] = $field; //make fields accessible by key
					}*/
					
					array_push($this->form_data['fields_taxonomies'], $taxonomy_name);
				}
				else
				{
					$this->form_data['fields_assoc'][$field['type']] = $field; //make fields accessible by key
				}
			}			
		}
	}
	
	public function get_filters()
	{
		$filters = array();
		

		if(!empty($this->form_data['fields']))
		{
			foreach($this->form_data['fields'] as $key => $field)
			{
				
				$valid_filter_types = array("tag", "category", "taxonomy", "post_meta");
				
				if(in_array($field['type'], $valid_filter_types))
				{
					if(($field['type']=="tag")||($field['type']=="category")||($field['type']=="taxonomy"))
					{
						array_push($filters, "_sft_".$field['taxonomy_name']);
					}
					else if($field['type']=="post_meta")
					{
						array_push($filters, "_sfm_".$field['meta_key']);
					}
				}
				
			}
		}
		
		return $filters;
	}
	
	public function get_fields()
	{
		$fields = array();
		foreach ($this->form_data['fields_taxonomies'] as $tax_field)
		{
			array_push($fields, "_sft_".$tax_field);
			
		}
		return $fields;
	}
	
	
	public function get_fields_taxonomies()
	{
		return $this->form_data['fields_taxonomies'];
	}

	public function get_fields_meta()
	{
		return $this->form_data['fields_meta'];
	}
	
	function data($index = '')
	{
		if(isset($this->form_data[$index]))
		{
			return $this->form_data[$index];
		}
		
		return false;
	}
	
	public function settings($index)
	{
		if(isset($this->form_data['settings']))
		{
			if(isset($this->form_data['settings'][$index]))
			{
				return $this->form_data['settings'][$index];
			}
		}
		
		return false;
	}
	
	public function get_template_name()
	{
		if(isset($this->form_data['settings']))
		{
			if(isset($this->form_data['settings']['use_template_manual_toggle']))
			{
				if($this->form_data['settings']['use_template_manual_toggle']==1)
				{//then a template option has been selected
					
					if(isset($this->form_data['settings']['template_name_manual']))
					{
						return $this->form_data['settings']['template_name_manual'];
					}
				}
			}
		}
		
		return false;
	}
		
	public function is_valid_form()
	{
		if(isset($this->form_data['id']))
		{
			if($this->form_data['id']!=0)
			{
				return true;
			}
		}
		
		return false;
	}
	public function form_id()
	{
		if(isset($this->form_data['id']))
		{
			if($this->form_data['id']!=0)
			{
				return $this->form_data['id'];
			}
		}
		
		return false;
	}
	
	/*public function is_using_custom_template()
	{
		if(isset($this->form_data['settings']))
		{
			if(isset($this->form_data['settings']['use_template_manual_toggle']))
			{
				if($this->form_data['settings']['use_template_manual_toggle']==1)
				{
					return true;
				}
			}
		}
		
		return false;
	}*/
	
	public function return_data()
	{		
		return $this->form_data;
	}
	
}

?>
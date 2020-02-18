<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Taxonomy_Walker
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Taxonomy_Object_Walker extends Walker_Category {

	
	private $type = '';
	private $auto_count = 0;
	private $defaults = array();
	private $depth_track = array();
	private $elementno = 0; //internal counter of which element we are on
    private $term_rewrite_depth = 0;
    private $parents_names = array();

	function __construct($defaults = array(), &$options_obj)  {

		$type = 'checkbox';
		$this->type = $type;
		
		$this->options = array();
		$this->options_obj = $options_obj;
	}
	
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}


	function start_el( &$output, $taxonomy_term, $depth = 0, $args = array(), $id = 0 )
	{
		global $searchandfilter;

		$sfid = $args['sfid'];
		$defaults = $args['defaults'];
		$hide_empty = $args['hide_empty'];
		$show_option_all_sf = $args['show_option_all_sf'];
		$show_default_option_sf = $args['show_default_option_sf'];
		$show_count = $args['show_count'];
		$show_count_format_sf = $args['show_count_format_sf'];
		
		$searchform = $searchandfilter->get($sfid);
		$this->auto_count = $searchform->settings("enable_auto_count");
		$this->auto_count_deselect_emtpy = $searchform->settings("auto_count_deselect_emtpy");

		$field_name = $args['sf_name'];
		
		//insert a default "select all" or "choose category: " at the start of the options
		//should only do this on radio or select field types as they are single select
		
		if($this->elementno==0)
		{//we are on the first element, so insert a default element first
			
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
			
			$this->elementno++;
		}
		
		
		$option = new stdClass();
		$option->label = '';
		$option->attributes = array(
			'class' => ''
		);
		$option->value = '';
		
		
		//setup taxonomy term defaults
		$taxonomy_term_name = esc_attr( $taxonomy_term->name );
		$taxonomy_term_id = esc_attr( $taxonomy_term->term_id );
		$taxonomy_term_slug = esc_attr( $taxonomy_term->slug );
		$taxonomy_term_name = apply_filters( 'list_cats', $taxonomy_term_name, $taxonomy_term );
				
		//check a default has been set and set it
		/*if($defaults)
		{
			$no_selected_options = count($defaults);

			if(($no_selected_options>0)&&(is_array($defaults)))
			{
				if(in_array($taxonomy_term_id, $defaults))
				{
					$option->attributes['selected'] = 'selected';
				}
			}
		}*/
		
		//get the count var (either from S&F cache, or from WP)
		if($this->auto_count==1)
		{	
			$option_count = $searchform->get_count_var($field_name, $taxonomy_term->slug);
		}
		else
		{
			$option_count = intval($taxonomy_term->count);
		}


		$current_depth = 0;
		if($args['hierarchical']==1)
		{


			if($taxonomy_term->parent == 0) {
				//then this has no parent so reset depth
				$current_depth = 0;
				//and reset the array tracking the parent IDs of this tree
				$this->depth_track = array( $taxonomy_term_id ); //reset the chain

			}
			else {

				//check to see if the parent ID is somewhere in the depth tracker
				//array_search( $taxonomy_term->parent, $this->depth_track, true );
				$depth_length = count($this->depth_track);

				$found_parent_depth = array_search( $taxonomy_term->parent, $this->depth_track );

				if($found_parent_depth !== false ) {

					$current_depth = $found_parent_depth + 1;

					//then we found a parent, but it was at the end of the chain, so we need to extend it by
					$this->depth_track[$current_depth] =  $taxonomy_term_id;


				} else {
					//depth does not yet exist, so add it
					//array_push($this->depth_track, $current_depth);
				}

				//if the last item had the same parent ID as the previous item, then the depth stays the same
				/*if($this->depth_track[$depth_length-1] == $taxonomy_term->parent) {

				} else if($this->depth_track[$depth_length-1] == $taxonomy_term->parent) {


				}*/
			}
		}

        $this->parents_names[$current_depth] = $taxonomy_term->slug;

		if((intval($hide_empty)!=1)||($option_count!=0))
		{
			
			$option->value = $taxonomy_term_slug;
			//$option->selected_value = $taxonomy_term_id; //we want to match defaults based on ID
			$option->label = $taxonomy_term_name;
			$option->depth = $current_depth;
			$option->count = $option_count;

            //we only want to grab the term rewrite template once for each depth
            if($option->depth==$this->term_rewrite_depth)
            {
                Search_Filter_TTT::add_template($this->get_term_link_template($taxonomy_term, $this->parents_names), $this->term_rewrite_depth, $taxonomy_term->taxonomy);
                $this->term_rewrite_depth++;
            }

			//add classes
			$option->attributes['class'] = SF_CLASS_PRE."level-".$current_depth.' '.SF_ITEM_CLASS_PRE.$taxonomy_term_id;
			
			if ( !empty($show_count) )
			{
				if($show_count_format_sf=="inline")
				{
					$option->label .= '&nbsp;&nbsp;(' . number_format_i18n($option_count) . ')';
				}
				else if($show_count_format_sf=="html")
				{
					$option->label .= '<span class="sf-count">(' . number_format_i18n($option_count) . ')</span>';
				}
			}
						
			//always last, after everything init
			array_push($this->options, $option);
		}

		$this->options_obj->set($this->options);

		$output = '';
	}
    private function get_term_link_template($term, $term_names)
    {
        $taxonomy_name = $term->taxonomy;

        $term_slug = $term->slug;

	    //is_taxonomy_hierarchical
        $term_link = get_term_link($term, $taxonomy_name);

        //$term_template_link = str_replace($taxonomy_name, "[taxonomy]", $term_link);
        $term_template_link = $term_link;

		//sort the array by string length, preserving indexes
	    uasort($term_names, array($this, 'sortStringByLength'));

		$home_url_removed = false;
	    if (strpos($term_template_link, home_url()) === 0) {
		    $term_template_link = substr($term_template_link, strlen(home_url()));
		    $home_url_removed = true;
	    }

	    //we need to loop[ through these terms in order
        foreach($term_names as $term_index => $term_name){
        	//echo $term_index. " ";
            //$term_template_link = str_replace($term_name, "[$term_index]", $term_template_link);
            //$term_template_link = preg_replace('/'.preg_quote($term_name).'/', "[$term_index]", $term_template_link, 1);
	        $term_template_link = $this->str_lreplace($term_name, "[$term_index]", $term_template_link);

            //$term_index++;
        }

        //$term_template_link = str_replace($term_slug, "[term]", $term_template_link); // redundant, we don't user `[term]`

	    if ($home_url_removed ===  true){

		    $term_template_link = home_url().$term_template_link;
	    }

        return $term_template_link;
    }
	public function sortStringByLength($a,$b){
		return strlen($b)-strlen($a);
	}
	function str_lreplace($search, $replace, $subject)
	{
		$pos = strrpos($subject, $search);

		if($pos !== false)
		{
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}

		return $subject;
	}

	function end_el( &$output, $page, $depth = 0, $args = array() )
	{
		
	}
	
	function start_lvl( &$output, $depth = 0, $args = array() )
	{
		
	}


    function end_lvl( &$output, $depth = 0, $args = array() )
    {

    }

}

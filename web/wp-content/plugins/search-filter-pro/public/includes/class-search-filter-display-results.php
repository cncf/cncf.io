<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Display_Shortcode
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

//form prefix


class Search_Filter_Display_Results {
	
	public $sfid 	= 0;
	public $filtered_post_ids  			= array();
	public $unfiltered_post_ids  		= array();
	public $filtered_post_ids_excl  	= array();
	
	
	public function __construct($plugin_slug)
	{
		/*
		 * Call $plugin_slug from public plugin class.
		 */
		
		//$plugin = Search_Filter::get_instance();
		$this->plugin_slug = $plugin_slug;

	}
	
	public function output_results($sfid, $settings)
	{
		global $searchandfilter;
		
		$returnvar = "";
		
		$returnvar .= "<div class=\"search-filter-results\" id=\"search-filter-results-".$sfid."\">";
		$returnvar .= "";
		
		//$get_results_obj = new Search_Filter_Query($this->plugin_slug);

        Search_Filter_Helper::start_log("the_results");

		$the_results = $searchandfilter->get($sfid)->query()->the_results();

        //Search_Filter_Helper::finish_log("the_results");

		$returnvar .= $the_results;
		
		$returnvar .= "</div>";
		
		return $returnvar;
	}
	
}

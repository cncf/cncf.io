<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Fields
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Fields {
	
	
	public $search;
	public $taxonomy;
	public $post_type;
	public $post_meta;
	
	public function __construct($plugin_slug, $sfid) {
		
		$this->plugin_slug = $plugin_slug;
		$this->sfid = $sfid;
		
		$this->search = new Search_Filter_Field_Search($this->plugin_slug, $sfid);
		$this->taxonomy = new Search_Filter_Field_Taxonomy($this->plugin_slug, $sfid);
		$this->post_type = new Search_Filter_Field_Post_Type($this->plugin_slug, $sfid);
		$this->sort_order = new Search_Filter_Field_Sort_Order($this->plugin_slug, $sfid);
		$this->posts_per_page = new Search_Filter_Field_Posts_Per_Page($this->plugin_slug, $sfid);
		$this->author = new Search_Filter_Field_Author($this->plugin_slug, $sfid);
		$this->post_meta = new Search_Filter_Field_Post_Meta($this->plugin_slug, $sfid);
		$this->post_date = new Search_Filter_Field_Post_Date($this->plugin_slug, $sfid);
		$this->submit = new Search_Filter_Field_Submit($this->plugin_slug, $sfid);
		$this->reset = new Search_Filter_Field_Reset($this->plugin_slug, $sfid);
		
	}
	
}


if ( ! class_exists( 'Search_Filter_Field_Search' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/base.php' );
}
if ( ! class_exists( 'Search_Filter_Field_Search' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/search.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Taxonomy' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/taxonomy.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Post_Type' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/post_type.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Post_Meta' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/post_meta.php' );
}
if ( ! class_exists( 'Search_Filter_Field_Post_Meta_Choice' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/post_meta_choice.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Post_Meta_Number' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/post_meta_number.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Post_Meta_Date' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/post_meta_date.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Post_Date' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/post_date.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Sort_Order' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/sort_order.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Posts_Per_Page' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/posts_per_page.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Author' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/author.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Submit' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/submit.php' );
}

if ( ! class_exists( 'Search_Filter_Field_Reset' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'fields/reset.php' );
}


if ( ! class_exists( 'Search_Filter_Taxonomy_Object_Walker' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'class-search-filter-taxonomy-object-walker.php' );
}
if ( ! class_exists( 'Search_Filter_Author_Object_Walker' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'class-search-filter-author-object-walker.php' );
}

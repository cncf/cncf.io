<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Widgets_Admin
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

class Search_Filter_Widgets_Admin {
	
	public function __construct() {

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		
		$this->plugin_slug = "search-filter";

		// Load widgets admin style she	et and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		
		/* AJAX */
		/*
		add_action( 'wp_ajax_meta_prefs_set', array($this, 'meta_prefs_set') ); //if logged in
		add_action( 'wp_ajax_nopriv_meta_prefs_set', array($this, 'meta_prefs_set') ); //if not logged in
		*/
		
	}
	
	public function enqueue_admin_styles()
	{
		//wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css' ), array(), Search_Filter_Admin::VERSION );
	}
	public function enqueue_admin_scripts()
	{
		wp_enqueue_script( $this->plugin_slug . '-admin-widgets-script', plugins_url( '/assets/js/admin-widgets.js',dirname(__FILE__) ), array( 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery' ), Search_Filter_Admin::VERSION );

		//wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Search_Filter_Admin::VERSION );
	}
}


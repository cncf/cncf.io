<?php

/**
 * Compatibility layer for the Edit Flow plugin.
 * @link https://wordpress.org/plugins/edit-flow/ Edit Flow 
 */
class WPRSS_FTP_Edit_Flow {
	protected static $_instance;
	
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			$class_name = __CLASS__;
			self::$_instance = new $class_name;
		}
		
		return self::$_instance;
	}
	
	public function __construct() {
		add_action( 'wprss_ftp_init', array( $this, '_init' ) );
		
		add_action( 'ef_module_options_loaded', array( $this, 'allow_custom_status_for_feed_source' ) );
	}
	
	public function _init() {
	}
	
	/**
	 * Overrides the options of 'custom_status' module so that it
	 * works on the Edit Feed Source screen.
	 * 
	 * @return null
	 */
	public function allow_custom_status_for_feed_source(  ) {
		$edit_flow = EditFlow();
		$module_name = 'custom_status';
		if( !isset($edit_flow->modules->{$module_name}) ) return;
		
		$module = $edit_flow->modules->{$module_name};
		
		$module->options->post_types['wprss_feed'] = 'on';
	}
}

WPRSS_FTP_Edit_Flow::get_instance();

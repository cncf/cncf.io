<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Admin
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'SEARCH_FILTER_STORE_URL', 'https://searchandfilter.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of your product. This should match the download name in EDD exactly
define( 'SEARCH_FILTER_ITEM_NAME', 'Search & Filter Pro' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	require_once( plugin_dir_path( __FILE__ ) . 'includes/EDD_SL_Plugin_Updater.php' );
}

function search_filter_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'search_filter_license_key' ) );

	// setup the updater
	$edd_updater = new EDD_SL_Plugin_Updater( SEARCH_FILTER_STORE_URL, SEARCH_FILTER_PRO_BASE_PATH, array(
			'version' 	=> SEARCH_FILTER_VERSION,				// current version number
			'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
			'item_name' => SEARCH_FILTER_ITEM_NAME, 	// name of this plugin
			'author' 	=> 'Ross Morsali',  // author of this plugin
			'url'       => home_url()
		)
	);
}
add_action( 'admin_init', 'search_filter_plugin_updater', 0 );


class Search_Filter_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	const VERSION = SEARCH_FILTER_VERSION;

	/**
	 * Slug of the plugins various screen (Array)
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Instance of the widgets screen admin class
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $widget_screen_admin = null;
	protected $plugin_slug = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		$this->plugin_slug = "search-filter";
		global $search_filter_shared;
        $shared = $search_filter_shared; //this sets up shared (between frontend and admin) attributes (like post types & taxonomies)

		global $wpdb;
		$this->cache_table_name = $wpdb->prefix . 'search_filter_cache';
		$this->term_results_table_name = $wpdb->prefix . 'search_filter_term_results';
		
		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		//plugin activation
		add_action('admin_init', array($this,'search_filter_register_option'));
		add_action('admin_init', array($this,'search_filter_activate_license'));
		add_action('admin_init', array($this,'search_filter_deactivate_license'));

		//new blog created
		add_action( 'wpmu_new_blog', array($this, 'on_create_blog'), 10, 6 );

		//adds all the filters for the post cache and admin hooks, probably should be singleton
		global $search_filter_post_cache;
		$this->post_cache = $search_filter_post_cache;

		global $search_filter_third_party;
        $this->third_party = $search_filter_third_party;
		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( dirname(__FILE__) ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'admin_notices', array( $this, 'action_display_welcome_header' ) );
		$this->admin_notices = new Search_Filter_Admin_Notices($this->plugin_slug);

		add_action('admin_head', array($this,'action_setup_screens'));

		add_action( 'admin_action_sf_duplicate_form', array($this,'action_duplicate_post_as_draft' ));

		add_filter( 'page_row_actions', array($this,'action_duplicate_post_link' ), 10, 2);

		/* AJAX */
		add_action( 'wp_ajax_meta_prefs_set', array($this, 'meta_prefs_set') ); //if logged in
		add_action( 'wp_ajax_get_meta_values', array($this, 'get_meta_values') ); //if logged in
		add_action( 'wp_ajax_get_taxonomy_terms', array($this, 'get_taxonomy_terms') ); //if logged in
		add_action( 'wp_ajax_search_filter_cache_set_method', array($this, 'ajax_cache_set_method') ); //if logged in

		add_action( 'wp_ajax_search_filter_build_cache_table', array($this, 'search_filter_build_cache_tables') ); //if logged in

		add_filter( 'manage_edit-'.$this->plugin_slug.'-widget_columns', array($this, 'set_custom_sf_columns') );
		add_action( 'manage_'.$this->plugin_slug.'-widget_posts_custom_column' , array($this, 'custom_sf_column'), 10, 2 );

		add_filter( 'post_updated_messages', array($this, 'sf_updated_messages') );

		//add_action('init', array($this, 'admin_init'));
	}

	/*function admin_init()
	{
		register_sidebar( array(
			'name'         => __( 'Search & Filter', $this->plugin_slug ),
			'id'           => 'search-filter-widget',
			'description'  => __( 'Add a Search Form to your sidebar', $this->plugin_slug ),
			'before_title' => '<h1>',
			'after_title'  => '</h1>',
		) );
	}*/


	function set_custom_sf_columns($columns) {

		unset( $columns['date'] );
		$columns['shortcode'] = __( 'Shortcode', $this->plugin_slug );
		$columns['fields'] = __( 'Fields List', $this->plugin_slug );
		$columns['displaymethod'] = __( 'Results Method', $this->plugin_slug );
		$columns['date'] = __( 'Date', $this->plugin_slug );

		return $columns;
	}

	function custom_sf_column( $column, $post_id ) {

        $settings = Search_Filter_Helper::get_settings_meta($post_id);

		switch ( $column ) {

			case 'shortcode' :
				echo '[searchandfilter id="'.$post_id.'"]';

				if(is_array($settings))
				{
					$display_results_as = "";

					if(isset($settings['display_results_as']))
					{
						$display_results_as = $settings['display_results_as'];
					}
					else
					{

						/* legacy */
						$display_results_as = "archive";

						if(isset($settings['use_ajax_toggle']))
						{
							if($settings['use_ajax_toggle']==1)
							{
								if(isset($settings['use_results_shortcode']))
								{
									if($settings['use_results_shortcode']==1)
									{
										$display_results_as = "shortcode";
									}
								}
							}
						}
						/* end legacy */
					}

					if($display_results_as=="shortcode")
					{
						echo '<br />[searchandfilter id="'.$post_id.'" show="results"]';
					}
				}
				else
				{
					//error
				}

				break;

			case 'fields' :
				$fields = get_post_meta( $post_id , '_search-filter-fields' , true );
				$fields_arr = array();
				if(isset($fields))
				{
					if(is_array($fields))
					{
						foreach ($fields as $field)
						{
							$fields_arr[] = $field['type'];
						}

						$fields_text = implode($fields_arr, ", ");
						echo $fields_text;
					}

				}
				break;
			case 'displaymethod' :

				if(is_array($settings))
				{
					$display_results_as = "";
					$results_label = "";

					if(isset($settings['display_results_as']))
					{
						$display_results_as = $settings['display_results_as'];
					}

					if($display_results_as=="archive")
					{
						$results_label = __("As an Archive", $this->plugin_slug);
					}
					else if($display_results_as=="post_type_archive")
					{
						$post_type = "";
						if(isset($settings['post_types']))
						{
							if(count($settings['post_types'])==1)
							{
								$post_types = array_keys($settings['post_types']);

								$post_type_object = get_post_type_object( $post_types[0] );

								if(isset($post_type_object->label))
								{
									$post_type = $post_type_object->label;
								}
							}
						}
						$results_label = sprintf(__("Post Type Archive: <strong>%s</strong>", $this->plugin_slug), $post_type);
					}
					else if($display_results_as=="shortcode")
					{
						$results_label = __("Using a Shortcode", $this->plugin_slug);
					}
					else if($display_results_as=="custom")
					{
						$results_label = __("Custom", $this->plugin_slug);
					}
					else if($display_results_as=="custom_woocommerce_store")
					{
						$results_label = __("WooCommerce Shop", $this->plugin_slug);
					}
					else if($display_results_as=="custom_edd_store")
					{
						$results_label = __("EDD Downloads Page", $this->plugin_slug);
					}
					else
					{
						$results_label = $display_results_as;
					}

					echo $results_label;
				}

				break;

		}
	}
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {


		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( in_array ( $screen->id, $this->plugin_screen_hook_suffix ) ) {

			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Search_Filter_Admin::VERSION );
			//wp_enqueue_style( $this->plugin_slug .'-admin-hint', plugins_url( 'assets/css/hint.min.css', __FILE__ ), array(), Search_Filter_Admin::VERSION );
			wp_enqueue_style( $this->plugin_slug .'-admin-qtip', plugins_url( 'assets/css/jquery.qtip.min.css', __FILE__ ), array(), Search_Filter_Admin::VERSION );

			wp_enqueue_style('thickbox');

		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( in_array ( $screen->id, $this->plugin_screen_hook_suffix ) ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Search_Filter_Admin::VERSION );
		}

		wp_enqueue_script('thickbox');

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 */

		$iconurl = plugins_url( 'assets/img/icon.png', __FILE__ );
		$iconurl = "dashicons-search";

		$parent_slug = 'edit.php?post_type='.$this->plugin_slug.'-widget';
		$main_menu_page_slug = add_menu_page(
		__( 'Search & Filter Pro', $this->plugin_slug ),
		__( 'Search & Filter', $this->plugin_slug ),
		'manage_options',
		$parent_slug, false, $iconurl, '100.23243' );

		$this->plugin_screen_hook_suffix['main_menu_page'] = "edit-search-filter-widget"; //this is hte list of search filter forms
		$this->plugin_screen_hook_suffix['add_new_page'] = "search-filter-widget"; //this is the "add new" or "editing" S&F page

		$this->plugin_screen_hook_suffix['new_post'] = add_submenu_page(
			$parent_slug,
			__( 'New Search Form', $this->plugin_slug ),
			__( 'New Search Form', $this->plugin_slug ),
			'manage_options',
			'post-new.php?post_type=search-filter-widget'
		);

		$this->plugin_screen_hook_suffix[] = add_submenu_page(
			$parent_slug,
			__( 'Search &amp; Filter Settings', $this->plugin_slug ),
			__( 'Settings', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug."-settings",
			array( $this, 'display_plugin_settings_admin_page' )
		);


		$this->plugin_screen_hook_suffix[] = add_submenu_page(
			$parent_slug,
			__( 'Search &amp; Filter License', $this->plugin_slug ),
			__( 'License', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug."-licence-settings",
			array( $this, 'display_plugin_license_settings_admin_page' )
		);

		$this->plugin_screen_hook_suffix[] = add_submenu_page(
			$parent_slug,
			__( 'Search &amp; Filter System Status', $this->plugin_slug ),
			__( 'System Status', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug."-system-status",
			array( $this, 'display_plugin_system_status_page' )
		);

        if(isset($_GET['letme'])) {
            if($_GET['letme']=="in") {
                $this->plugin_screen_hook_suffix[] = add_submenu_page(
                    $parent_slug,
                    __('Search &amp; Filter Cache', $this->plugin_slug),
                    __('Cache', $this->plugin_slug),
                    'manage_options',
                    $this->plugin_slug . "-cache",
                    array($this, 'display_plugin_cache_page')
                );
            }
        }

		/*$this->plugin_screen_hook_suffix[] = add_submenu_page(
			$parent_slug,
			__( 'Help', $this->plugin_slug ),
			__( 'Help', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug."-help",
			array( $this, 'display_plugin_help_admin_page' )
		);*/

		//load page specific classes
		add_action( "load-post-new.php", array($this, 'posts_screen_header') );
		add_action( "load-post.php", array($this, 'posts_screen_header') );

	}
	private function sf_let_to_num( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}
	function widgets_screen_header()
	{
		/* Page Specific Stuff - call classes etc for seperate pages*/
		$widget_screen_admin = new Search_Filter_Widgets_Admin();
	}
	function posts_screen_header()
	{
		/* Page Specific Stuff - call classes etc for seperate pages*/

		$screen = get_current_screen();
		$post_type = $screen->post_type;
		if( $post_type == $this->plugin_slug.'-widget' ) {
			//add this if you did not add support for the post type when you called register_post_type()
			$widget_screen_admin = new Search_Filter_Posts_Admin();
		}

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	public function display_plugin_settings_admin_page()
	{
        // *******************
        //**********************
        //need to do a custom "get option" function which initialised the defaults, then use that everywhere

		$cache_speed 								= Search_Filter_Helper::get_option( 'cache_speed' );
		$cache_use_manual 							= Search_Filter_Helper::get_option( 'cache_use_manual' );
		$cache_use_background_processes 			= Search_Filter_Helper::get_option( 'cache_use_background_processes' );
		$cache_use_transients 						= Search_Filter_Helper::get_option( 'cache_use_transients' );

		$load_jquery_i18n 							= Search_Filter_Helper::get_option( 'load_jquery_i18n' );
		$lazy_load_js 								= Search_Filter_Helper::get_option( 'lazy_load_js' );
		$load_js_css 								= Search_Filter_Helper::get_option( 'load_js_css' );
		
		$combobox_script 							= Search_Filter_Helper::get_option( 'combobox_script' );
		$remove_all_data 							= Search_Filter_Helper::get_option( 'remove_all_data' );

		include_once( 'views/admin-settings.php' );
	}

	public function display_plugin_license_settings_admin_page()
	{

		$license 	= get_option( 'search_filter_license_key' );
		$status 	= get_option( 'search_filter_license_status' );
		$expires 	= get_option( 'search_filter_license_expires' );
		$error 	    = get_option( 'search_filter_license_error' );



		include_once( 'views/admin-license-settings.php' );
	}




	function search_filter_register_option() {
		// creates our settings in the options table
		register_setting('search_filter_license', 'search_filter_license_key', array($this, 'edd_sanitize_license') );

		register_setting('search_filter_settings', 'search_filter_cache_speed', array($this, 'sf_sanitize_options') );
		register_setting('search_filter_settings', 'search_filter_cache_use_manual', array($this, 'sf_sanitize_options') );
		register_setting('search_filter_settings', 'search_filter_cache_use_background_processes', array($this, 'sf_sanitize_options') );
		register_setting('search_filter_settings', 'search_filter_cache_use_transients', array($this, 'sf_cache_sanitize_use_transients_options') );
		register_setting('search_filter_settings', 'search_filter_load_js_css', array($this, 'sf_sanitize_options') );
		register_setting('search_filter_settings', 'search_filter_lazy_load_js', array($this, 'sf_sanitize_options') );
		register_setting('search_filter_settings', 'search_filter_load_jquery_i18n', array($this, 'sf_sanitize_options') );
		register_setting('search_filter_settings', 'search_filter_combobox_script', array($this, 'sf_sanitize_options') );
		register_setting('search_filter_settings', 'search_filter_remove_all_data', array($this, 'sf_sanitize_options') );
	}

	function sf_sanitize_options( $new )
	{
		//$old = get_option( 'search_filter_license_key' );
		/*if( $old && $old != $new ) {
			delete_option( 'search_filter_license_status' ); // new license has been entered, so must reactivate
		}*/

		return $new;
	}

	function sf_cache_sanitize_use_transients_options( $new )
	{
		//$old = get_option( 'search_filter_license_key' );
		/*if( $old && $old != $new ) {
			delete_option( 'search_filter_license_status' ); // new license has been entered, so must reactivate
		}*/
		//if($new!==1) {
			//clear transients when updating updating this setting
			Search_Filter_Wp_Cache::purge_all_transients();
		//}
		return $new;
	}

	function edd_sanitize_license( $new )
	{
		$old = get_option( 'search_filter_license_key' );
		if( $old && $old != $new ) {
			delete_option( 'search_filter_license_status' ); // new license has been entered, so must reactivate
			delete_option( 'search_filter_license_expires' );
			delete_option( 'search_filter_license_error' );
		}
		return $new;
	}



	function search_filter_activate_license()
	{

		// listen for our activate button to be clicked
		if( isset( $_POST['search_filter_license_activate'] ) )
		{
			// run a quick security check
			if( ! check_admin_referer( 'search_filter_nonce', 'search_filter_nonce' ) )
				return; // get out if we didn't click the Activate button

			// retrieve the license from the database
			$license = trim( get_option( 'search_filter_license_key' ) );

			// data to send in our API request
			$api_params = array(
				'edd_action'=> 'activate_license',
				'license' 	=> $license,
				'item_name' => urlencode( SEARCH_FILTER_ITEM_NAME ), // the name of our product in EDD
				'url'       => home_url()
			);

			// Call the custom API.
			$response = wp_remote_get( add_query_arg( $api_params, SEARCH_FILTER_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) )
				return false;

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "valid" or "invalid"

			update_option( 'search_filter_license_status', $license_data->license );
			update_option( 'search_filter_license_expires', $license_data->expires );

			if($license_data->license==="invalid"){
				update_option( 'search_filter_license_error', $license_data->error );
            }
            else{
	            delete_option( 'search_filter_license_error', '' );
            }


		}
	}


	/***********************************************
	* Illustrates how to deactivate a license key.
	* This will descrease the site count
	***********************************************/

	function search_filter_deactivate_license() {

		// listen for our activate button to be clicked
		if( isset( $_POST['edd_license_deactivate'] ) ) {

			// run a quick security check
			if( ! check_admin_referer( 'search_filter_nonce', 'search_filter_nonce' ) )
				return; // get out if we didn't click the Activate button

			// retrieve the license from the database
			$license = trim( get_option( 'search_filter_license_key' ) );


			// data to send in our API request
			$api_params = array(
				'edd_action'=> 'deactivate_license',
				'license' 	=> $license,
				'item_name' => urlencode( SEARCH_FILTER_ITEM_NAME ), // the name of our product in EDD
				'url'       => home_url()
			);

			// Call the custom API.
			$response = wp_remote_get( add_query_arg( $api_params, SEARCH_FILTER_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) )
				return false;

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if( $license_data->license == 'deactivated' )
				delete_option( 'search_filter_license_status' );
				delete_option( 'search_filter_license_error' );
				delete_option( 'search_filter_license_expires' );

		}
	}

	public function display_plugin_help_admin_page() {
		include_once( 'views/admin-help.php' );
	}

	public function display_plugin_system_status_page() {
		include_once( 'views/admin-system-status.php' );
	}


	public function display_plugin_cache_page() {

		$cache_options = get_option("search-filter-cache");

		include_once( 'views/admin-cache.php' );
	}

	public function ajax_cache_set_method() {

		if(!isset($_GET['method']))
		{
			echo "0";
			exit;
		}

		$run_method = esc_attr($_GET['method']);

		$cache_options = get_option("search-filter-cache");
		$cache_options['run_method'] = $run_method;
        update_option( "search-filter-cache", $cache_options, false );
		echo "1";
		exit;

	}



	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	public function action_setup_screens()
	{
		global $post_ID;
		$screen = get_current_screen();

		if( isset($_GET['post_type']) ) $post_type = $_GET['post_type'];
		else $post_type = get_post_type( $post_ID );

		//addd a help tab
		if( $post_type == 'search-filter-widget' )
		{
			/*$screen->add_help_tab( array(
			'id' => 'you_custom_id', //unique id for the tab
			'title' => 'Search & Filter Pro', //unique visible title for the tab
			'content' => '<h3>Search &amp; Filter Pro Help</h3><p>We will be integrating help here throughout all Search &amp; Filter pages in the near future, for now access help online:</p>
			<p><a href="https://searchandfilter.com/documentation/getting-started/" target="_blank">Getting Started Documentation</a> | <a href="https://support.searchandfilter.com/forums/forum/search-filter-pro/support/" target="_blank">Support Forums</a> | <a href="https://searchandfilter.com/documentation/faq/" target="_blank">Frequently Asked Questions</a></p>
			',
			));*/

			//add_screen_option( 'per_page', array('label' => _x( 'Comments', 'comments per page (screen options)' )) );
		}
	}

	/**
	 * Ajax Control of visibility of widgets & other visual elements, stored in user options to remember settings
	 *
	 * @since    1.0.0
	 */
	function meta_prefs_set()
	{
		//global $woocommerce;
		global $current_user ;

		$show = intval($_POST['show']);

		$user_id = $current_user->ID;

		if($show==0)
		{
			update_user_meta($user_id, $this->plugin_slug.'-show-welcome-notice', '0');
		}
		else if($show==1)
		{
			update_user_meta($user_id, $this->plugin_slug.'-show-welcome-notice', '1');
		}
		exit;
	}

	function get_meta_values()
	{
		//global $woocommerce;
		global $current_user ;

		$meta_key = sanitize_text_field($_POST['meta_key']);
		//$meta_key = sanitize_text_field($_GET['meta_key']);

		global $wpdb;
		$data = array();
		$wpdb->query("
			SELECT `meta_key`, `meta_value`
			FROM $wpdb->postmeta
			WHERE BINARY `meta_key` = '$meta_key'
		");

		foreach($wpdb->last_result as $k => $v)
		{
			$data[] = $v->meta_value;
		};
		$data = array_unique($data);

		$return_data = array();

		foreach($data as $value)
		{
			if($value!="")
			{
				if(is_serialized($value))
				{
					$serial_values = unserialize($value);
					foreach ($serial_values as $serial_val)
					{
						if(!is_array($serial_val))
						{
							$return_data[] = $serial_val;
						}
						else
						{
							if(is_array($serial_val))
							{
								foreach($serial_val as $arr_val)
								{
									$return_data[] = $arr_val;
								}
							}
							//$return_data[] = serialize($serial_val);
						}
					}

				}
				else
				{
					$return_data[] = $value;
				}
			}
		}

		$return_data = array_unique($return_data);
		$no_values_found = count($return_data);
		if($no_values_found>0)
		{
			foreach($return_data as $return_item)
			{
				echo '<label><input type="checkbox" value="'.$return_item.'" />'.$return_item.'</label>';
			}
		}
		else
		{
			echo "<p><strong>No values found!</strong> It looks like you haven't used this meta key in any of your posts yet so we couldn't find any values.</p>";
		}

		echo '<br class="clear" />';

		exit;
	}

	function get_taxonomy_terms()
	{
		//global $woocommerce;
		global $current_user ;

		//$meta_key = sanitize_key($_GET['meta_key']);

		$tax_name = sanitize_key($_GET['taxonomy_name']);
		$tax_ids = esc_attr($_GET['taxonomy_ids']);

		$tax_ids = explode(",",$tax_ids);
		$tax_ids = array_map("intval", $tax_ids);

		// no default values. using these as examples
		$taxonomies = array(
			$tax_name
		);

		$args = array(
			'orderby'           => 'name',
			'order'             => 'ASC',
			'hide_empty'        => false,
			'exclude'           => array(),
			'exclude_tree'      => array(),
			'include'           => array(),
			'number'            => '',
			'fields'            => 'all',
			'slug'              => '',
			'parent'            => '',
			'hierarchical'      => false,
			//'child_of'          => 0,
			'get'               => '',
			//'name__like'        => '',
			//'description__like' => '',
			'pad_counts'        => false,
			//'offset'            => '',
			//'search'            => '',
			//'cache_domain'      => 'core'
		);

		$terms = get_terms($taxonomies, $args);


		if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
		{
			foreach ( $terms as $term )
			{
				$checked = "";

				if(in_array($term->term_id, $tax_ids))
				{
					$checked = ' checked="checked"';
				}
				echo '<label><input type="checkbox" value="'.$term->term_id.'"'.$checked.' />'.$term->name.'</label>';
			}
		}
		else
		{
			echo "<p><strong>No terms found!</strong> It looks like you haven't created any terms.</p>";
		}

		echo '<br class="clear" />';

		exit;
	}

	/**
	 * NOTE:     Actions are points in the execution of a page or process
	 *           lifecycle that WordPress fires.
	 *
	 *           Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */

	function action_display_welcome_header() {

		global $current_screen;
		global $current_user;

		$user_id = $current_user->ID;

		//set default user meta
		if( !get_user_meta($user_id, $this->plugin_slug.'-show-welcome-notice') )
		{
			add_user_meta($user_id, $this->plugin_slug.'-show-welcome-notice', '1', true);
		}

		if($current_screen->id=="edit-search-filter-widget")
		{
			//for dev
			//delete_user_meta( $user_id, $this->plugin_slug.'-welcome-notice-ignore' );
			$hidden_class = "";
			if ( get_user_meta($user_id, $this->plugin_slug.'-show-welcome-notice', true)=="0" )
			{
				$hidden_class = " hidden";
			}
			?>
			<div class="wrap search-filter<?php echo $hidden_class; ?>" id="search-filter-welcome-panel">
				<div class="clear"></div>
				<div class="welcome-panel">

					<a class="welcome-panel-close handle-dismiss-button" data-target="#search-filter-welcome-panel" href="#"><?php printf(__('Dismiss', $this->plugin_slug)); ?></a>

					<div class="welcome-panel-content">
						<h2><?php _e( 'Welcome to Search &amp; Filter', $this->plugin_slug ); ?></h2>
						<p class="about-description"><?php _e( 'Build a custom UI for Searching &amp; Filtering your posts.', $this->plugin_slug ); ?></p>
						<div class="welcome-panel-column-container">
							<div class="welcome-panel-column">
								<h4><?php _e( 'Get Started', $this->plugin_slug ); ?></h4>
								<p><?php _e( 'If you\'ve just set up the plugin, the first thing you need to do is create a new Search Form', $this->plugin_slug ); ?></p>
								<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo admin_url('post-new.php?post_type=search-filter-widget'); ?>"><?php _e( 'Add New Search Form', $this->plugin_slug ); ?></a><br /><br />
							</div>
							<div class="welcome-panel-column">
								<h4><?php _e( 'Documentation', $this->plugin_slug ); ?></h4>
								<ul>
									<li><a href="https://searchandfilter.com/documentation/getting-started/" class="welcome-icon welcome-edit-page" target="_blank"><?php _e( 'Getting Started with Search &amp; Filter', $this->plugin_slug ); ?></a></li>
									<li><a href="https://support.searchandfilter.com/forums/forum/search-filter-pro/feature-requests/" class="welcome-icon welcome-edit-page" target="_blank"><?php _e( 'Feature Requests', $this->plugin_slug ); ?></a></li>
								</ul>
							</div>
							<div class="welcome-panel-column welcome-panel-last">
								<h4><?php _e( 'Help', $this->plugin_slug ); ?></h4>
								<ul>
									<li><div class="welcome-icon welcome-widgets-menus"><a href="https://searchandfilter.com/documentation/faq/" target="_blank"><?php _e( 'Frequently Asked Questions', $this->plugin_slug ); ?></a></div></li>
									<li><div class="welcome-icon welcome-widgets-menus"><a href="https://support.searchandfilter.com/forums/forum/search-filter-pro/support/" target="_blank"><?php _e( 'Support Forums', $this->plugin_slug ); ?></a></div></li>
								</ul>
							</div>

						</div>
					</div>
				</div>
			</div>
			<?php

		}
		else if($current_screen->id==$this->plugin_slug.'-widget')
		{
			if ( get_user_meta($user_id, $this->plugin_slug.'-show-welcome-notice', true)=="1" )
			{ /*
			?>

			<div class="wrap search-filter">
				<div class="clear"></div>
				<div class="welcome-panel">

					<?php printf(__('<a class="welcome-panel-close" href="%1$s">Dismiss</a>', $this->plugin_slug), '?post_type=search-filter-widget&'.$this->plugin_slug.'-welcome-notice=0'); ?>

					<div class="welcome-panel-content">
						<h3><?php _e( 'Help', $this->plugin_slug ); ?></h3>
						<p class="about-description"><?php _e( 'We\'ve added contextual help throughout most of our pages. Make sure to check the help section here if you get stuck!', $this->plugin_slug ); ?></p>
						<br />

					</div>
				</div>
			</div>

			<?php */
			}
		}

		$allowed_screens = array(
            $this->plugin_slug.'-widget',
            "edit-search-filter-widget",
            "dashboard",
        );

        if(in_array($current_screen->id, $allowed_screens)) {

            global $wpdb;
            $table_error = false;


            $sf_table_name = $wpdb->prefix . "search_filter_cache";
            $sf_term_table_name = $wpdb->prefix . "search_filter_term_results";

            if ($wpdb->get_var("SHOW TABLES LIKE '$sf_table_name'") != $sf_table_name) {
                //table is not created. you may create the table here.
                $table_error = true;
            }
            if ($wpdb->get_var("SHOW TABLES LIKE '$sf_term_table_name'") != $sf_term_table_name) {
                //table is not created. you may create the table here.
                $table_error = true;
            }


            if ($table_error) {
                ?>
                <div class="error search-filter-wp-error-msg">
                    <p>
                        <?php _e('<strong>Search &amp; Filter Error: </strong> The caching tables are missing - ', $this->plugin_slug); ?>
                        <a href="<?php echo admin_url('admin-ajax.php?action=search_filter_build_cache_table'); ?>"><?php _e('click here to create them', $this->plugin_slug); ?></a>
                    </p>
                </div>
                <?php
            }
        }

	}

	function search_filter_build_cache_tables()
	{
		if (current_user_can('edit_plugins'))
		{
			$this->db_install();
		}

		exit;
	}

	public function on_create_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta )
	{
		if ( is_plugin_active_for_network( 'search-filter-pro/search-filter-pro.php' ) )
		{
			switch_to_blog( $blog_id );
			$this->db_install();
			restore_current_blog();
		}
	}

	public function db_install() {
		global $wpdb;
		//global $jal_db_version;

		$table_name = $wpdb->prefix . 'search_filter_cache';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			post_id bigint(20) NOT NULL,
			post_parent_id bigint(20) NOT NULL,
			field_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			field_parent_num bigint(20) NULL,
			term_parent_id bigint(20) NULL,
			PRIMARY KEY  (id),
            KEY field_name_index (field_name),
            KEY field_value_index (field_value),
            KEY field_value_num_index (field_value_num)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		//add_option( 'jal_db_version', $jal_db_version );


		$table_name = $wpdb->prefix . 'search_filter_term_results';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			field_name varchar(255) NOT NULL,
			field_value varchar(255) NOT NULL,
			field_value_num bigint(20) NULL,
			result_ids mediumtext NOT NULL,
			PRIMARY KEY  (id),
            KEY field_name_index (field_name),
            KEY field_value_index (field_value),
            KEY field_value_num_index (field_value)

		) $charset_collate;";


		dbDelta( $sql );
	}
	/*
	 * Function creates post duplicate as a draft and redirects then to the edit post screen
	 */
	function action_duplicate_post_as_draft(){
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'sf_duplicate_form' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}

		/*
		 * get the original post id
		 */
		$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
		/*
		 * and all the original post data then
		 */
		$post = get_post( $post_id );

		/*
		 * if you don't want current user to be the new post author,
		 * then change next couple of lines to this: $new_post_author = $post->post_author;
		 */
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;

		/*
		 * if post data exists, create the post duplicate
		 */
		if (isset( $post ) && $post != null) {

			/*
			 * new post data array
			 */

			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);

			/*
			 * insert the post by wp_insert_post() function
			 */
			$new_post_id = wp_insert_post( $args );

			/*
			 * get all current post terms ad set them to the new post draft
			 */
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}

			/*
			 * duplicate all post meta
			 */
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}


			/*
			 * finally, redirect to the edit post screen for the new draft
			 */
			//wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			wp_redirect( admin_url( 'edit.php?post_type=' . $post->post_type ) );
			exit;
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}

	/*
	 * Add the duplicate link to action list for post_row_actions
	 */
	function action_duplicate_post_link( $actions, $post ) {

		if($post->post_type=="search-filter-widget")
		{
			if (current_user_can('edit_posts')) {

				$actions['duplicate'] = '<a href="admin.php?action=sf_duplicate_form&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Duplicate</a>';

			}
			unset($actions['inline hide-if-no-js']);
		}

		return $actions;
	}



	function sf_updated_messages( $messages ) {

		global $post, $post_ID;

		if ( 'search-filter-widget' == $post->post_type )
		{
			$messages[$post->post_type][1] = "Search Form updated.";
		}

		return $messages;
	}

	function set_selected($desired_value, $current_value, $echo = true)
	{
		if($desired_value==$current_value)
		{
			if($echo==true)
			{
				echo ' selected="selected"';
			}
			else
			{
				return ' selected="selected"';
			}
		}
	}

	function set_radio($desired_value, $current_value, $echo = true)
	{
		if($desired_value==$current_value)
		{
			if($echo==true)
			{
				echo ' checked="checked"';
			}
			else
			{
				return ' checked="checked"';
			}
		}
	}

	function set_checked($current_value)
	{
		if($current_value!="")
		{
			echo ' checked="checked"';
		}
	}

}

if ( ! class_exists( 'Search_Filter_Admin_Notices' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-admin-notices.php' );
}

if ( ! class_exists( 'Search_Filter_Widgets_Admin' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-widgets-admin.php' );
}

if ( ! class_exists( 'Search_Filter_Posts_Admin' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-posts-admin.php' );
}

<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


global $searchandfilter;

class Search_Filter {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = SEARCH_FILTER_VERSION;
	
	/**
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'search-filter';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	private $all_search_form_ids = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct()
	{		
		global $searchandfilter;

		$searchandfilter = new Search_Filter_Global($this->plugin_slug);

		global $search_filter_shared;
        $shared = $search_filter_shared; //this sets up shared (between frontend and admin) attributes (like post types & taxonomies)

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		
		// Ajax
		add_action( 'init', array($this, 'get_results'), 2000 );
        //add_action( 'init', array($this, 'get_results'), 200 );

		//if(!is_admin())
		//{
			add_action( 'parse_request', array( $this, 'archive_query_init' ), 10 );
			//add_action( 'pre_get_posts', array($this, 'custom_query_init'), 100 );
			add_action( 'pre_get_posts', array($this, 'archive_query_init_later') );
			//add_action( 'pre_get_posts', array($this, 'archive_query_init_later'), -100 );
			
			//load SF Template - set high priority to override other plugins...
			add_action('template_include', array($this, 'handle_template'), 100, 3);
		//}

        add_action( 'pre_get_posts', array($this, 'custom_query_init'), 10000 );

		$this->display_shortcode = new Search_Filter_Display_Shortcode($this->plugin_slug);

		global $search_filter_third_party;
		$this->third_party = $search_filter_third_party;

		add_action( 'woocommerce_product_query', array($this, 'setup_wc_query'), 100000 );

		//add_filter('rewrite_rules_array', array($this, 'sf_rewrite_rules'));
	}

	function custom_query_init($query)
	{
		if(!isset($query->query_vars['search_filter_id']))
		{
			return;
		}

		if(isset($query->query_vars['search_filter_override']))
		{
			if($query->query_vars['search_filter_override']==false)
			{
				return;
			}
		}

		if($query->query_vars['search_filter_id']!=0)
		{
			global $query_count_test;
			$query_count_test++;

			//remove_action( 'pre_get_posts', array($this, 'custom_query_init'), 10000 );
			global $searchandfilter;
			$searchandfilter->get($query->query_vars['search_filter_id'])->query->setup_custom_query($query);
			//add_action( 'pre_get_posts', array($this, 'custom_query_init'), 10000 );


		}

		return;
	}
	
	function is_woo_shop($query)
	{
		$front_page_id        = get_option( 'page_on_front' );
		$current_page_id      = $query->get( 'page_id' );
		$shop_page_id         = apply_filters( 'woocommerce_get_shop_page_id' , get_option( 'woocommerce_shop_page_id' ) );
		$is_static_front_page = 'page' == get_option( 'show_on_front' );

		// Warnings are thrown when using pre_get_posts, Woocommerce & the homepage when using the function `is_shop` - https://github.com/woothemes/woocommerce/issues/10625#issuecomment-204212754 - apparently WP issue
		// Otherwise, just use is_shop since it works fine on other pages
		if ( $is_static_front_page && $front_page_id == $current_page_id  ) {
			//its the homepage so use this function to detect shop
			$is_shop_page = ( $current_page_id == $shop_page_id ) ? true : false;
		} else {
			//is_shop should work fine
			$is_shop_page = is_shop();
		}
		
		return $is_shop_page;
	}
	function archive_query_init_later($query)
	{
		global $searchandfilter;
		global $wp_query;
		
		if(!$query->is_main_query())
		{
			return;
		}
		
		/*if(function_exists("is_shop"))
		{
			if($this->is_woo_shop($query))
			{
				//then see if there are any search forms set to be woocommerce
				
				foreach($this->all_search_form_ids as $search_form_id)
				{
					//as we only want to update "enabled", then load all settings and update only this key
					$search_form_settings = Search_Filter_Helper::get_settings_meta($search_form_id);
					
					if(isset($search_form_settings['display_results_as']))
					{
						if($search_form_settings['display_results_as']=="custom_woocommerce_store")
						{
							$searchandfilter->set_active_sfid($search_form_id);
							$searchandfilter->get($search_form_id)->query->setup_archive_query($query);
							
							return;
						}
					}
					
				}
			}
		}*/

		if(is_post_type_archive()||is_home()||is_tag()||is_tax()||is_category())
		{//then we know its a post type archive, see if any of our search forms

			foreach($this->all_search_form_ids as $search_form_id)
			{

				//as we only want to update "enabled", then load all settings and update only this key
                $search_form_settings = Search_Filter_Helper::get_settings_meta($search_form_id);
				
				if(isset($search_form_settings['display_results_as']))
				{
                    global $wp_query;
                    if(isset($wp_query->query_vars['sfid']))
                    {//this means its an archive and its already been init
                        return;
                    }

					if($search_form_settings['display_results_as']=="post_type_archive")
					{
						if(isset($search_form_settings['post_types']))
						{
							$post_types = array_keys($search_form_settings['post_types']);
                            $enable_taxonomy_archives = $search_form_settings["enable_taxonomy_archives"];
							if(isset($post_types[0]))
							{
								$post_type = $post_types[0];
								
								if(is_post_type_archive($post_type))
								{	
									$searchandfilter->set_active_sfid($search_form_id);
									$searchandfilter->get($search_form_id)->query->setup_archive_query($query);
									return;
								}
								else if(($post_type=="post")&&(is_home()))
								{//this then works on the blog page (is_home) set in `settings -> reading -> "a static page" -> posts page
									$searchandfilter->set_active_sfid($search_form_id);
									$searchandfilter->get($search_form_id)->query->hook_setup_archive_query();
									return;
								}
								else if(($enable_taxonomy_archives==1) && (Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_type)))
                                {
                                    $searchandfilter->set_active_sfid($search_form_id);
                                    $searchandfilter->get($search_form_id)->query->setup_archive_query($query);
                                    return;
                                }
							}
						}
						
					}
                    /*else if($search_form_settings['display_results_as']=="custom_woocommerce_store")
                    {
                        $post_type = "product";
                        $enable_taxonomy_archives = $search_form_settings["enable_taxonomy_archives"];

                        $searchandfilter->set_active_sfid($search_form_id);

                        if(($enable_taxonomy_archives==1) && (Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_type, false)))
                        {
                            $searchandfilter->set_active_sfid($search_form_id);
                            $searchandfilter->get($search_form_id)->query->setup_archive_query($query);
                            return;
                        }


                    }*/
				}
			}
		}
	}
	public function setup_wc_query($query){

		global $searchandfilter;

		//filter the shop page
		if(function_exists("is_shop")) {
			if ( $this->is_woo_shop( $query ) ) {
				foreach ( $this->all_search_form_ids as $search_form_id ) {
					//as we only want to update "enabled", then load all settings and update only this key
					$search_form_settings = Search_Filter_Helper::get_settings_meta( $search_form_id );

					if ( isset( $search_form_settings['display_results_as'] ) ) {
						if ( $search_form_settings['display_results_as'] == "custom_woocommerce_store" ) {
							$searchandfilter->set_active_sfid( $search_form_id );
							$searchandfilter->get( $search_form_id )->query->setup_wc_query( $query );
							return;
						}
					}
				}
			}
		}

		//filter WC tax archives
		if(is_post_type_archive()||is_home()||is_tag()||is_tax()||is_category())
		{//then we know its a post type archive, see if any of our search forms

			foreach($this->all_search_form_ids as $search_form_id)
			{
				//as we only want to update "enabled", then load all settings and update only this key
				$search_form_settings = Search_Filter_Helper::get_settings_meta($search_form_id);

				if(isset($search_form_settings['display_results_as']))
				{
					global $wp_query;
					if(isset($wp_query->query_vars['sfid']))
					{//this means its an archive and its already been init
						return;
					}
					else if($search_form_settings['display_results_as']=="custom_woocommerce_store")
					{
						$post_type = "product";
						$enable_taxonomy_archives = $search_form_settings["enable_taxonomy_archives"];

						$searchandfilter->set_active_sfid($search_form_id);

						if(($enable_taxonomy_archives==1) && (Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type($post_type, false)))
						{
							$searchandfilter->set_active_sfid($search_form_id);
							$searchandfilter->get( $search_form_id )->query->setup_wc_query( $query );
							return;
						}
					}
				}
			}
		}
	}

	function archive_query_init($wp)
	{//here we test to see if we have an ID set - which if it is, then this means a user is on a results page, using archive method
		
		global $searchandfilter;
		global $wp_query;

		if(!is_admin()){

            if(isset($wp->query_vars['sfid']))
			{
				$sfid = (int)$wp->query_vars['sfid'];
				$searchandfilter->set_active_sfid($sfid);
				$searchandfilter->set($sfid);
			}
			
			//extra stuff
			//grab any search forms before woocommerce had a chance to modify the query
			$search_form_query = new WP_Query('post_type=search-filter-widget&fields=ids&post_status=publish&posts_per_page=-1');
			$this->all_search_form_ids = $search_form_query->get_posts();
		}
	}
	
	public function search_filter_ajax_object_results($ajax_data)
    {
        global $searchandfilter;
        $sfid = (int)($_GET['sfid']);
        $sf_inst = $searchandfilter->get($sfid);
        $ajax_data['results'] = $sf_inst->query()->the_results();

        return $ajax_data;
    }

    public function search_filter_ajax_object_form($ajax_data)
    {
        $sfid = (int)($_GET['sfid']);
        $ajax_data['form'] = $this->display_shortcode->display_shortcode(array("id" => $sfid));
        return $ajax_data;
    }

    public function search_filter_ajax_object_all($ajax_data)
    {
        global $searchandfilter;
        $sfid = (int)($_GET['sfid']);
        $sf_inst = $searchandfilter->get($sfid);
        $ajax_data['form'] = $this->display_shortcode->display_shortcode(array("id" => $sfid));
        $ajax_data['results'] = $sf_inst->query()->the_results();
        return $ajax_data;
    }

	public function get_results()
	{

        add_filter("search_filter_ajax_object_results", array($this, 'search_filter_ajax_object_results'), 10, 1);
        add_filter("search_filter_ajax_object_form", array($this, 'search_filter_ajax_object_form'), 10, 1);
        add_filter("search_filter_ajax_object_all", array($this, 'search_filter_ajax_object_all'), 10, 1);


		//$this->hard_remove_filters();
		if((isset($_GET['sfid']))&&(isset($_GET['sf_action'])) &&(isset($_GET['sf_data'])) )
		{
			//get_form

			$sf_action = esc_attr($_GET['sf_action']);
			$sf_data = esc_attr($_GET['sf_data']);

			if((esc_attr($_GET['sfid'])!="")&&($sf_action=="get_data"))
			{
				global $searchandfilter;
				
				$sfid = (int)($_GET['sfid']);
				$sf_inst = $searchandfilter->get($sfid);
				
				$data_types = explode(",", $sf_data);
                $ajax_data = array(); //the obejct that is json encoded

                foreach($data_types as $data_type)
                {
                    $clean_data_type = esc_attr($data_type);

                    if(has_filter("search_filter_ajax_object_$clean_data_type"))
                    {

                        $ajax_data = apply_filters("search_filter_ajax_object_$clean_data_type", $ajax_data);
                    }

                }

                do_action("search_filter_api_header");
                echo Search_Filter_Helper::json_encode($ajax_data);
                exit;

				/*if($sf_data=="results")
				{
					if($sf_inst->settings("display_results_as")=="shortcode")
					{
						$results = array();
						
						//$results['form'] = $this->display_shortcode->display_shortcode(array("id" => $sfid));
						$results['results'] = $sf_inst->query()->the_results();
						
						echo Search_Filter_Helper::json_encode($results);
						exit;
					}
				}
				else if($sf_data=="all")
				{
					if($sf_inst->settings("display_results_as")=="shortcode")
					{
						$results = array();

						$results['form'] = $this->display_shortcode->display_shortcode(array("id" => $sfid));
						$results['results'] = $sf_inst->query()->the_results();

						echo Search_Filter_Helper::json_encode($results);
						exit;
					}
				}
				else if($sf_data=="form")
				{
					$results = array();
                    $results['form'] = $this->display_shortcode->display_shortcode(array("id" => $sfid));
					
					echo Search_Filter_Helper::json_encode($results);
					exit;
				}
				else if($sf_data=="vc_results")
				{
					$results = array();

                    $results_output = "";
                    if(has_filter("search_filter_ajax_results"))
                    {
                        $results['results'] = apply_filters("search_filter_ajax_results", $results_output);
                    }
					$results['form'] = $this->display_shortcode->display_shortcode(array("id" => $sfid));

					echo Search_Filter_Helper::json_encode($results);
					exit;
				}*/

				//do_action("");
				
			}
		}
        //exit;
	}

	public function handle_template($original_template)
	{
		global $searchandfilter;
		global $wp_query;
		
		$sfid = 0;
		
		if(isset($wp_query->query_vars['sfid']))
		{
			$sfid = $wp_query->query_vars['sfid'];
		}
		else
		{
			return $original_template;
		}
		
		if(($searchandfilter->get($sfid)->settings("display_results_as")=="custom_woocommerce_store")||($searchandfilter->get($sfid)->settings("display_results_as")=="post_type_archive"))
		{
			return $original_template;
		}
		
		if($searchandfilter->get($sfid)->is_valid_form())
		{//then we are doing a search
			$sfpaged = 1;
			if(isset($_GET['sf_paged']))
			{
				$sfpaged = (int)$_GET['sf_paged'];
			}
			global $paged;
			$paged = $sfpaged;
			//set_query_var("paged", $paged);
			
			
			$template_file_name = $searchandfilter->get($sfid)->get_template_name();
			
			if($template_file_name)
			{
				$located = locate_template( $template_file_name );
				
				if ( !empty( $located ) )
				{
					$this->display_shortcode->set_is_template(true);
					return ($located);
				}
			}		
		}
		
		return $original_template;
	}
	
	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
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
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
		
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}


	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		$file_ext = '.min.css';
		if(SEARCH_FILTER_DEBUG==true)
		{
			$file_ext = '.css';
		}
		
		$load_js_css	= (int)Search_Filter_Helper::get_option( 'load_js_css' );

		if($load_js_css === 1)
		{
			wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/search-filter'.$file_ext, __FILE__ ), array(), self::VERSION );
		}
	}
	
	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function register_scripts() {
		
		global $searchandfilter;

		$file_ext = '.min.js';
		if(SEARCH_FILTER_DEBUG==true)
		{
			$file_ext = '.js';
		}
		
		wp_register_script( $this->plugin_slug . '-plugin-build', plugins_url( 'assets/js/search-filter-build'.$file_ext, __FILE__ ), array('jquery'), self::VERSION );
		wp_register_script( $this->plugin_slug . '-plugin-chosen', plugins_url( 'assets/js/chosen.jquery'.$file_ext, __FILE__ ), array('jquery'), self::VERSION );
		wp_register_script( $this->plugin_slug . '-plugin-select2', plugins_url( 'assets/js/select2'.$file_ext, __FILE__ ), array('jquery'), self::VERSION );
		wp_register_script( $this->plugin_slug . '-plugin-jquery-i18n', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n'.$file_ext, array('jquery'), self::VERSION );
		//wp_register_script( $this->plugin_slug . '-plugin-jquery-i18n', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/datepicker-nl.js', array('jquery'), self::VERSION );
		wp_localize_script($this->plugin_slug . '-plugin-build', 'SF_LDATA', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'home_url' => (home_url('/')) ));
		
		$lazy_load_js 				= Search_Filter_Helper::get_option( 'lazy_load_js' );
		$load_js_css 				= Search_Filter_Helper::get_option( 'load_js_css' );

		if(($lazy_load_js!=1)&&($load_js_css==1))
		{
			$this->enqueue_scripts();
		}
		
		
	}
	public function enqueue_scripts()
	{
		$load_jquery_i18n = (int)Search_Filter_Helper::get_option( 'load_jquery_i18n' );
		$combobox_script = Search_Filter_Helper::get_option( 'combobox_script' );

		wp_enqueue_script( $this->plugin_slug . '-plugin-build' );
		wp_enqueue_script( $this->plugin_slug . '-plugin-'.$combobox_script );
		wp_enqueue_script( 'jquery-ui-datepicker' ); 
				
		if($load_jquery_i18n===1)
		{
			wp_enqueue_script( $this->plugin_slug . '-plugin-jquery-i18n' );
		}
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function create_custom_post_types() {

		$labels = array(
		    'name'					=>	__( 'Search &amp; Filter', $this->plugin_slug ),
			'singular_name'			=>	__( 'Search Form', $this->plugin_slug ),
		    'add_new'				=>	__( 'Add New Search Form', $this->plugin_slug ),
		    'add_new_item'			=>	__( 'Add New Search Form', $this->plugin_slug ),
		    'edit_item'				=>	__( 'Edit Search Form', $this->plugin_slug ),
		    'new_item'				=>	__( 'New Search Form', $this->plugin_slug ),
		    'view_item'				=>	__( 'View Search Form', $this->plugin_slug ),
		    'search_items'			=>	__( 'Search \'Search Forms\'', $this->plugin_slug ),
		    'not_found'				=>	__( 'No Search Forms found', $this->plugin_slug ),
		    'not_found_in_trash'	=>	__( 'No Search Forms found in Trash', $this->plugin_slug ),
		);
		
		register_post_type($this->plugin_slug.'-widget' , array(
			'labels'			=> $labels,
			'public'			=> false,
			'show_ui'			=> true,
			'_builtin'			=> false,
			'capability_type'	=> 'page',
			'hierarchical'		=> true,
			'rewrite'			=> false,
			'supports'			=> array('title'),
			'show_in_menu'		=> false
			/*'has_archive' => true,*/
		));
	}
}


if ( ! class_exists( 'Search_Filter_Display_Shortcode' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-display-shortcode.php' );
}



if ( ! class_exists( 'Search_Filter_Query' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-query.php' );
}

if ( ! class_exists( 'Search_Filter_Active_Query' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-active-query.php' );
}

if ( ! class_exists( 'Search_Filter_Cache' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-cache.php' );
}

if ( ! class_exists( 'Search_Filter_Config' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-config.php' );
}

if ( ! class_exists( 'Search_Filter_Global' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-search-filter-global.php' );
}

if (!defined('SF_FPRE'))
{
    define('SF_FPRE', '_sf_');
}
if (!defined('SF_TAX_PRE'))
{
    define('SF_TAX_PRE', '_sft_');
}
if (!defined('SF_META_PRE'))
{
    define('SF_META_PRE', '_sfm_');
}
if (!defined('SF_CLASS_PRE'))
{
    define('SF_CLASS_PRE', 'sf-');
}
if (!defined('SF_INPUT_ID_PRE'))
{
    define('SF_INPUT_ID_PRE', 'sf');
}
if (!defined('SF_FIELD_CLASS_PRE'))
{
    define('SF_FIELD_CLASS_PRE', SF_CLASS_PRE."field-");
}
if (!defined('SF_ITEM_CLASS_PRE'))
{
    define('SF_ITEM_CLASS_PRE', SF_CLASS_PRE."item-");
}
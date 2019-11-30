<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.cncf.io/
 * @since      1.0.0
 *
 * @package    Cncf_Mu
 * @subpackage Cncf_Mu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cncf_Mu
 * @subpackage Cncf_Mu/admin
 * @author     Chris Abraham <cjyabraham@gmail.com>
 */
class Cncf_Mu_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param string $plugin_name       The name of this plugin.
	 * @param string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cncf-mu-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cncf-mu-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Registers the custom post types
	 */
	public function register_cpts() {

		$opts = array(
			'labels'       => array(
				'name'          => __( 'People' ),
				'singular_name' => __( 'Person' ),
				'all_items'     => __( 'All People' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'menu_icon'    => 'dashicons-buddicons-buddypress-logo',
			'rewrite'      => array( 'slug' => 'person' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_person', $opts );

		$opts = array(
			'labels'       => array(
				'name'          => __( 'Case Studies' ),
				'singular_name' => __( 'Case Study' ),
				'all_items'     => __( 'All Case Studies' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'menu_icon'    => 'dashicons-awards',
			'rewrite'      => array( 'slug' => 'case-study' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_case_study', $opts );

		$opts = array(
			'labels'       => array(
				'name'          => __( 'Webinars' ),
				'singular_name' => __( 'Webinar' ),
				'all_items'     => __( 'All Webinars' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'menu_icon'    => 'dashicons-video-alt3',
			'rewrite'      => array( 'slug' => 'webinar' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_webinar', $opts );

		$opts = array(
			'labels'       => array(
				'name'          => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'all_items'     => __( 'All Events' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'menu_icon'    => 'dashicons-calendar',
			'rewrite'      => array( 'slug' => 'events' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_event', $opts );

		$opts = array(
			'labels'       => array(
				'name'          => __( 'Projects' ),
				'singular_name' => __( 'Project' ),
				'all_items'     => __( 'All Projects' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'menu_icon'    => 'dashicons-hammer',
			'rewrite'      => array( 'slug' => 'projects' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_project', $opts );

	}


	/**
	 * Registers the extra sidebar for post types
	 *
	 * @param array $sidebars    Existing sidebars in Gutenberg.
	 */
	public function create_sidebar( $sidebars ) {
		// First we define the sidebar with it's tabs, panels and settings.
		$palette = array(
			'dark-fuschia' => '#6e1042',
			'dark-violet' => '#411E4F',
			'dark-indigo' => '#1A267D',
			'dark-blue' => '#17405c',
			'dark-aqua' => '#0e5953',
			'dark-green' => '#0b5329',

			'light-fuschia' => '#AD1457',
			'light-violet' => '#6C3483',
			'light-indigo' => '#4653B0',
			'light-blue' => '#2874A6',
			'light-aqua' => '#148f85',
			'light-green' => '#117a3d',

			'dark-chartreuse' => '#3d5e0f',
			'dark-yellow' => '#878700',
			'dark-gold' => '#8c7000',
			'dark-orange' => '#784e12',
			'dark-umber' => '#6E2C00',
			'dark-red'   => '#641E16',

			'light-chartreuse' => '#699b23',
			'light-yellow' => '#b0b000',
			'light-gold' => '#c29b00',
			'light-orange' => '#c2770e',
			'light-umber' => '#b8510d',
			'light-red'   => '#922B21',
		);

		$sidebar = array(
			'id'              => 'cncf-sidebar-event',
			'id_prefix'       => 'cncf_',
			'label'           => __( 'Event Settings' ),
			'post_type'       => 'cncf_event',
			'data_key_prefix' => 'cncf_',
			'icon_dashicon'   => 'admin-settings',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'    => __( 'General' ),
							'initial_open' => true,
							'settings' => array(
								array(
									'type'          => 'date_single', // Required.
									'data_type'     => 'meta',
									'unavailable_dates' => array(),
									'data_key'      => 'date_start', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Start Date', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									'format'        => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'date_single', // Required.
									'data_type'     => 'meta',
									'unavailable_dates' => array(),
									'data_key'      => 'date_end', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'End Date', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									'format'        => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'external_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'URL to External Event Site' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.cloudfoundry.org/event/summit/',
								),
								array(
									'type'            => 'checkbox_multiple', // Required.
									'data_type'       => 'meta', // Available: 'meta', 'localstorage', 'none'.
									'data_key'        => 'hosts', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'           => __( 'Hosts', 'my_plugin' ),
									'register_meta'   => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top'   => true, // Display CSS border-top in the editor control.
									'default_value'   => array( 'cncf-organized' ), // Value/s from the 'options'.
									'use_toggle'      => false, // Use toggle control instead of checkbox.
									'options'         => array( // Required.
										'cncf-organized' => __( 'CNCF-organized', 'my_plugin' ),
										'lf-organized' => __( 'LF-organized', 'my_plugin' ),
										'third-party' => __( 'Third party', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'city', // Required if 'data_type' is 'meta'.
									'label'         => __( 'City' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'Hamilton',
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		// Return the $sidebars array with our sidebar now included.
		return $sidebars;

	}

	/**
	 * Registers the taxonomies.
	 */
	public function register_taxonomies() {

		$labels = array(
			'name'              => __( 'Countries', 'textdomain' ),
			'singular_name'     => __( 'Country', 'textdomain' ),
			'search_items'      => __( 'Countries', 'textdomain' ),
			'all_items'         => __( 'All Countries', 'textdomain' ),
			'parent_item'       => __( 'Parent Continent', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Continent:', 'textdomain' ),
			'edit_item'         => __( 'Edit Country', 'textdomain' ),
			'update_item'       => __( 'Update Country', 'textdomain' ),
			'add_new_item'      => __( 'Add New Country', 'textdomain' ),
			'new_item_name'     => __( 'New Country Name', 'textdomain' ),
			'menu_name'         => __( 'Countries', 'textdomain' ),
		);

		$args   = [
			'labels'       => $labels,
			'show_in_rest' => true,
			'hierarchical' => true,
		];

		register_taxonomy( 'cncf-country', array( 'cncf_event' ), $args );
	}


	/**
	 * Removes unneeded menu items from the admin.
	 */
	public function remove_menu_items() {
		remove_menu_page( 'edit-comments.php' );
	}

}

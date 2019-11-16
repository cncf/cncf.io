<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    LFEvents
 * @subpackage LFEvents/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    LFEvents
 * @subpackage LFEvents/admin
 * @author     Your Name <email@example.com>
 */
class LFEvents_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $lfevents    The ID of this plugin.
	 */
	private $lfevents;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Array of lfevent custom post types that are in use
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $post_types    Array of lfevent custom post types that are in use
	 */
	private $post_types;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $lfevents       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $lfevents, $version ) {

		$this->lfevents   = $lfevents;
		$this->version    = $version;
		$this->post_types = lfe_get_post_types();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in LFEvents_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The LFEvents_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->lfevents, plugin_dir_url( __FILE__ ) . 'css/lfevents-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in LFEvents_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The LFEvents_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->lfevents, plugin_dir_url( __FILE__ ) . 'js/lfevents-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Registers the custom post types
	 */
	public function new_cpts() {

		$opts = array(
			'labels'       => array(
				'name'          => __( 'About Pages' ),
				'singular_name' => __( 'About Page' ),
				'all_items'     => __( 'All About Pages' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => true,
			'menu_icon'    => 'dashicons-info',
			'rewrite'      => array( 'slug' => 'about' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		);

		register_post_type( 'lfe_about_page', $opts );

		$opts = array(
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => true,
			'menu_icon'    => 'dashicons-admin-page',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields', 'page-attributes' ),
			'menu_position' => 30,
		);

		$current_year = date( 'Y' );
		for ( $x = 2017; $x <= $current_year; $x++ ) {
			$opts['labels']  = array(
				'name'          => $x . ' Events',
				'singular_name' => $x . ' Event',
				'all_items'     => 'All ' . $x . ' Events',
			);
			$opts['rewrite'] = array( 'slug' => 'archive/' . $x );

			register_post_type( 'lfevent' . $x, $opts );
		}

		$opts = array(
			'labels'       => array(
				'name'          => __( 'Speakers' ),
				'singular_name' => __( 'Speaker' ),
				'all_items'     => __( 'All Speakers' ),
			),
			'show_in_rest' => true,
			'public' => true,
			'menu_icon'    => 'dashicons-groups',
			'rewrite'      => array( 'slug' => 'speakers' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		);

		register_post_type( 'lfe_speaker', $opts );

		$opts = array(
			'labels'       => array(
				'name'          => __( 'Community Events' ),
				'singular_name' => __( 'Community Event' ),
				'all_items'     => __( 'All Community Events' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => true,
			'menu_icon'    => 'dashicons-admin-site',
			'rewrite'      => array( 'slug' => 'community' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
		);

		register_post_type( 'lfe_community_event', $opts );
	}

	/**
	 * Changes the "Pages" labels to "Events"
	 */
	public function change_page_label() {
		global $wp_post_types;
		$labels                     = &$wp_post_types['page']->labels;
		$labels->name               = 'Events';
		$labels->singular_name      = 'Event';
		$labels->add_new_item       = 'Add Event';
		$labels->edit_item          = 'Edit Event';
		$labels->new_item           = 'New Event';
		$labels->view_item          = 'View Event';
		$labels->all_items          = 'All Events';
		$labels->view_items         = 'View Events';
		$labels->search_items       = 'Search Events';
		$labels->not_found          = 'No Events found';
		$labels->not_found_in_trash = 'No Events found in Trash';
		$labels->archives           = 'Event Archives';
		$labels->attributes         = 'Event Attributes';
		$labels->menu_name          = 'Events';
		$labels->name_admin_bar     = 'Event';

	}

	/**
	 * Registers the LFEvent categories
	 */
	public function register_event_categories() {
		$labels = [
			'name'          => _x( 'Event Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Event Category', 'taxonomy singular name' ),
		];
		$args   = [
			'labels'       => $labels,
			'show_in_rest' => true,
			'hierarchical' => true,
		];

		register_taxonomy( 'lfevent-category', $this->post_types, $args );

		$labels = array(
			'name'              => _x( 'Event Countries', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Event Country', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Countries', 'textdomain' ),
			'all_items'         => __( 'All Countries', 'textdomain' ),
			'parent_item'       => __( 'Parent Continent', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Continent:', 'textdomain' ),
			'edit_item'         => __( 'Edit Country', 'textdomain' ),
			'update_item'       => __( 'Update Country', 'textdomain' ),
			'add_new_item'      => __( 'Add New Country', 'textdomain' ),
			'new_item_name'     => __( 'New Country Name', 'textdomain' ),
			'menu_name'         => __( 'Event Countries', 'textdomain' ),
		);

		$args   = [
			'labels'       => $labels,
			'show_in_rest' => true,
			'hierarchical' => true,
		];

		register_taxonomy( 'lfevent-country', array_merge( $this->post_types, array( 'lfe_community_event' ) ), $args );
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
			'id'              => 'lfevent-sidebar-event',
			'id_prefix'       => 'lfes_',
			'label'           => __( 'Event Settings' ),
			'post_type'       => $this->post_types,
			'data_key_prefix' => 'lfes_',
			'icon_dashicon'   => 'format-gallery',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'    => __( 'General' ),
							'initial_open' => false,
							'settings' => array(
								array(
									'type'          => 'textarea', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'            => 'description',
									'data_type'     => 'meta',
									'data_key'      => 'description', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'         => __( 'Event description', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									// To see the available formats check: http://momentjs.com/docs/#/parsing/string-format/.
									'placeholder'        => 'The Cloud Native Computing Foundation’s flagship conference gathers adopters and technologists from leading open source and cloud native communities in San Diego, California from November 18-21, 2019. Join Kubernetes, Prometheus, Envoy, CoreDNS, containerd, Fluentd, OpenTracing, gRPC, rkt, CNI, Jaeger, Notary, TUF, Vitess, NATS, Linkerd, Helm, Rook, Harbor, etcd, Open Policy Agent, and CRI-O as the community gathers for four days to further the education and advancement of cloud native computing.',
								),
								array(
									'type'          => 'text', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'            => 'date_start',
									'data_type'     => 'meta',
									'data_key'      => 'date_start', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'         => __( 'Event start date', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									// To see the available formats check: http://momentjs.com/docs/#/parsing/string-format/.
									'placeholder'        => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'text', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'            => 'date_end',
									'data_type'     => 'meta',
									'data_key'      => 'date_end', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'         => __( 'Event end date', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									// To see the available formats check: http://momentjs.com/docs/#/parsing/string-format/.
									'placeholder'        => 'YYYY/MM/DD',
								),
								array(
									'type'            => 'image', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'              => 'white_logo',
									'data_type'       => 'meta', // Available: 'meta', 'localstorage', 'none'.
									'data_key'        => 'white_logo', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'           => __( 'White logo', 'my_plugin' ),
									'register_meta'   => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top'   => true, // Display CSS border-top in the editor control.
								),
								array(
									'type'            => 'image', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'              => 'black_logo',
									'data_type'       => 'meta', // Available: 'meta', 'localstorage', 'none'.
									'data_key'        => 'black_logo', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'           => __( 'Black logo', 'my_plugin' ),
									'register_meta'   => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top'   => false, // Display CSS border-top in the editor control.
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'external_url',
									'data_type'     => 'meta',
									'data_key'      => 'external_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'URL to External Event site' ),
									'help'          => __( 'Set this value only when the Event site is located on an external site.' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.cloudfoundry.org/event/summit/',
								),
							),
						),
						array(
							'label'    => __( 'Location' ),
							'initial_open' => false,
							'settings' => array(
								array(
									'type'          => 'text', // Required.
									'id'            => 'city',
									'data_type'     => 'meta',
									'data_key'      => 'city', // Required if 'data_type' is 'meta'.
									'label'         => __( 'City' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'Paris' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'venue',
									'data_type'     => 'meta',
									'data_key'      => 'venue', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Venue' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'San Diego Convention Center' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'street_address',
									'data_type'     => 'meta',
									'data_key'      => 'street_address', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Street Address' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( '2635 Homestead Rd' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'postal_code',
									'data_type'     => 'meta',
									'data_key'      => 'postal_code', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Postal Code' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( '95051' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'region',
									'data_type'     => 'meta',
									'data_key'      => 'region', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Province/State' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'CA' ),
								),
							),
						),
						array(
							'label'    => __( 'Call for Proposal' ),
							'initial_open' => false,
							'settings' => array(
								array(
									'type'          => 'checkbox', // Required.
									'id'            => 'cfp_active',
									'data_type'     => 'meta',
									'data_key'      => 'cfp_active', // Required if 'data_type' is 'meta'.
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => true,
									'use_toggle'    => false,
									'input_label'     => __( 'CFP for Event', 'my_plugin' ), // Required.
								),
								array(
									'type'          => 'text', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'            => 'cfp_date_start',
									'data_type'     => 'meta',
									'data_key'      => 'cfp_date_start', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'         => __( 'CFP start date', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									// To see the available formats check: http://momentjs.com/docs/#/parsing/string-format/.
									'placeholder'        => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'text', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'            => 'cfp_date_end',
									'data_type'     => 'meta',
									'data_key'      => 'cfp_date_end', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'         => __( 'CFP end date', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									// To see the available formats check: http://momentjs.com/docs/#/parsing/string-format/.
									'placeholder'        => 'YYYY/MM/DD',
								),
							),
						),
						array(
							'label'    => __( 'Colors' ),
							'initial_open' => false,
							'settings' => array(
								array(
									'type'          => 'color',
									'id'            => 'menu_color',
									'data_type'     => 'meta',
									'data_key'      => 'menu_color', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Menu Background Color' ),
									// 'help'          => __( 'Choose a color for the topnav menu' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '#222222', // A string with a HEX, rgb or rgba color format.
									'alpha_control' => false, // Include alpha control to set color transparency.
									'palette'       => $palette,
								),
								array(
									'type'          => 'color',
									'id'            => 'menu_color_2',
									'data_type'     => 'meta',
									'data_key'      => 'menu_color_2', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Menu Gradient Color' ),
									// 'help'          => __( 'Choose a second menu color to create a gradient' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => 'transparent', // A string with a HEX, rgb or rgba color format.
									'alpha_control' => false, // Include alpha control to set color transparency.
									'palette'       => $palette,
								),
								array(
									'type'          => 'color',
									'id'            => 'menu_color_3',
									'data_type'     => 'meta',
									'data_key'      => 'menu_color_3', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Menu Dropdown Color' ),
									// 'help'          => __( 'Choose a color for the topnav dropdown' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => 'transparent', // A string with a HEX, rgb or rgba color format.
									'alpha_control' => false, // Include alpha control to set color transparency.
									'palette'       => $palette,
								),
								array(
									'type'          => 'radio',
									'id'            => 'menu_text_color',
									'data_type'     => 'meta',
									'data_key'      => 'menu_text_color', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Menu Text Color' ),
									// 'help'          => __( 'Choose a color for the menu text' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => 'white', // A string with a HEX, rgb or rgba color format.
									'alpha_control' => false, // Include alpha control to set color transparency.
									'options'         => array( // Required.
										'white' => __( 'White', 'my_plugin' ),
										'black' => __( 'Black', 'my_plugin' ),
									),
								),
							),
						),
						array(
							'label'    => __( 'Social' ),
							'initial_open' => false,
							'settings' => array(
								array(
									'type'            => 'image', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'              => 'wechat',
									'data_type'       => 'meta', // Available: 'meta', 'localstorage', 'none'.
									'data_key'        => 'wechat', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'           => __( 'WeChat QR code', 'my_plugin' ),
									'register_meta'   => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top'   => true, // Display CSS border-top in the editor control.
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'linkedin',
									'data_type'     => 'meta',
									'data_key'      => 'linkedin', // Required if 'data_type' is 'meta'.
									'label'         => __( 'LinkedIn url' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://www.linkedin.com/company/cloud-native-computing-foundation' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'qq',
									'data_type'     => 'meta',
									'data_key'      => 'qq', // Required if 'data_type' is 'meta'.
									'label'         => __( 'QQ url' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'http://v.qq.com/vplus/dbc4895dfc0a6ec609ad9e42a10507e0/videos' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'youtube',
									'data_type'     => 'meta',
									'data_key'      => 'youtube', // Required if 'data_type' is 'meta'.
									'label'         => __( 'YouTube url' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://www.youtube.com/channel/UCvqbFHwN-nwalWPjPUKpvTA' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'facebook',
									'data_type'     => 'meta',
									'data_key'      => 'facebook', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Facebook url' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://www.facebook.com/CloudNativeComputingFoundation/' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'twitter',
									'data_type'     => 'meta',
									'data_key'      => 'twitter', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Twitter url' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://twitter.com/CloudNativeFdn' ),
								),
							),
						),
						array(
							'label'    => __( 'Homepage Tile' ),
							'initial_open' => false,
							'settings' => array(
								array(
									'type'          => 'text', // Required.
									'id'            => 'cta_register_url',
									'data_type'     => 'meta',
									'data_key'      => 'cta_register_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'CTA Register URL' ),
									'help'          => __( 'The CTA buttons will only appear when a url is provided.' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/register/' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'cta_speak_url',
									'data_type'     => 'meta',
									'data_key'      => 'cta_speak_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'CTA Speak URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/cfp/' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'cta_sponsor_url',
									'data_type'     => 'meta',
									'data_key'      => 'cta_sponsor_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'CTA Sponsor URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/sponsors/become-and-sponsor/' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'cta_schedule_url',
									'data_type'     => 'meta',
									'data_key'      => 'cta_schedule_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'CTA Schedule URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/schedule/' ),
								),
							),
						),
						array(
							'label'    => __( 'Advanced' ),
							'initial_open' => false,
							'settings' => array(
								array(
									'type'          => 'radio',
									'id'            => 'hide_from_listings',
									'data_type'     => 'meta',
									'data_key'      => 'hide_from_listings', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Hide from Homepage and Calendars' ),
									'help'          => __( 'This will hide the Event form the homepage and calendars.' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => 'show',
									'options'         => array( // Required.
										'show' => __( 'Show', 'my_plugin' ),
										'hide' => __( 'Hide', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'radio',
									'id'            => 'event_has_passed',
									'data_type'     => 'meta',
									'data_key'      => 'event_has_passed', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Event Has Passed' ),
									'help'          => __( 'This value will update automatically so no need to touch it.' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '0',
									'options'         => array( // Required.
										'1' => __( 'True', 'my_plugin' ),
										'0' => __( 'False', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'related_events',
									'data_type'     => 'meta',
									'data_key'      => 'related_events', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Related Events Override' ),
									'help'          => __( 'This is a comma-delimited list of Event IDs that, when set, will be listed instead of the normal related Events in the View All Events menu.' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( '1365,2122,3112' ),
								),
							),
						),
					),
				),
			),
		);

		// Push the $sidebar we just assigned to the variable
		// to the array of $sidebars that comes in the function argument.
		$sidebars[] = $sidebar;

		$sidebar = array(
			'id'              => 'lfevent-sidebar-page',
			'id_prefix'       => 'lfes_',
			'label'           => __( 'Page Settings' ),
			'post_type'       => $this->post_types,
			'data_key_prefix' => 'lfes_',
			'icon_dashicon'   => 'media-spreadsheet',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'    => __( 'General' ),
							'initial_open' => true,
							'settings' => array(
								array(
									'type'          => 'checkbox', // Required.
									'id'            => 'hide_from_menu',
									'data_type'     => 'meta',
									'data_key'      => 'hide_from_menu', // Required if 'data_type' is 'meta'.
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => false,
									'use_toggle'    => false,
									'input_label'   => __( 'Hide from Event menu', 'my_plugin' ), // Required.
									'help'          => __( 'This will stop this particular page from showing on the Event top navigation menu.' ),
								),
								array(
									'type'          => 'checkbox', // Required.
									'id'            => 'splash_page',
									'data_type'     => 'meta',
									'data_key'      => 'splash_page', // Required if 'data_type' is 'meta'.
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => false,
									'use_toggle'    => false,
									'input_label'   => __( 'Splash Page', 'my_plugin' ), // Required.
									'help'          => __( 'This will make the page display a minimal topnav appropriate for an event splash page.' ),
								),
							),
						),
					),
				),
			),
		);

		// Push the $sidebar we just assigned to the variable
		// to the array of $sidebars that comes in the function argument.
		$sidebars[] = $sidebar;

		$sidebar = array(
			'id'              => 'lfe-speaker-sidebar',
			'id_prefix'       => 'lfes_speaker_',
			'label'           => __( 'Speaker Details' ),
			'post_type'       => array( 'lfe_speaker' ),
			'data_key_prefix' => 'lfes_speaker_',
			'icon_dashicon'   => 'admin-users',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'    => __( 'Speaker Details' ),
							'settings' => array(
								array(
									'type'          => 'text', // Required.
									'id'            => 'title',
									'data_type'     => 'meta',
									'data_key'      => 'title', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Title, Company' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'Title, Company' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'linkedin',
									'data_type'     => 'meta',
									'data_key'      => 'linkedin', // Required if 'data_type' is 'meta'.
									'label'         => __( 'LinkedIn URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://www.linkedin.com/in/username/' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'twitter',
									'data_type'     => 'meta',
									'data_key'      => 'twitter', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Twitter URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://twitter.com/username' ),
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'website',
									'data_type'     => 'meta',
									'data_key'      => 'website', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Website URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'https://cncf.io' ),
								),
							),
						),
					),
				),
			),
		);

		// Push the $sidebar we just assigned to the variable
		// to the array of $sidebars that comes in the function argument.
		$sidebars[] = $sidebar;

		$sidebar = array(
			'id'              => 'lfevent-sidebar',
			'id_prefix'       => 'lfes_community_',
			'label'           => __( 'Event Settings' ),
			'post_type'       => 'lfe_community_event',
			'data_key_prefix' => 'lfes_community_',
			'icon_dashicon'   => 'list-view',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'    => __( 'General' ),
							'initial_open' => true,
							'settings' => array(
								array(
									'type'          => 'text', // Required.
									'id'            => 'city',
									'data_type'     => 'meta',
									'data_key'      => 'city', // Required if 'data_type' is 'meta'.
									'label'         => __( 'City' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => __( 'Paris' ),
								),
								array(
									'type'          => 'text', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'            => 'date_start',
									'data_type'     => 'meta',
									'data_key'      => 'date_start', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'         => __( 'Event start date', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									// To see the available formats check: http://momentjs.com/docs/#/parsing/string-format/.
									'placeholder'        => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'text', // Required.
									// Optionally, an id may be specified. It will be used by the plugin to
									// identify the setting and will be applied to the control html.
									// The prefix set in the sidebar option 'id_prefix' will be applied.
									'id'            => 'date_end',
									'data_type'     => 'meta',
									'data_key'      => 'date_end', // Required if 'data_type' is 'meta' or 'localstorage'.
									// Use 'data_key_prefix' to set a custom prefix for this setting 'data_key'.
									// If 'data_key_prefix' is not assigned, the 'data_key_prefix' from the sidebar
									// where this setting is nested will be used.
									'label'         => __( 'Event end date', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '', // A string with a date that matches 'format'.
									// To see the available formats check: http://momentjs.com/docs/#/parsing/string-format/.
									'placeholder'        => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'text', // Required.
									'id'            => 'external_url',
									'data_type'     => 'meta',
									'data_key'      => 'external_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'URL to Community Event site' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.cloudfoundry.org/event/summit/',
								),
							),
						),
					),
				),
			),
		);

		// Push the $sidebar we just assigned to the variable
		// to the array of $sidebars that comes in the function argument.
		$sidebars[] = $sidebar;

		// Return the $sidebars array with our sidebar now included.
		return $sidebars;

	}

	/**
	 * Adds filters to the Events listing in wp-admin
	 */
	public function event_filters() {
		global $wpdb;

		// only do this for Events.
		$post_type_listing = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
		if ( 'page' !== $post_type_listing && substr( $post_type_listing, 0, 7 ) !== 'lfevent' ) {
			return;
		}

		$post_id = isset( $_GET['admin-single-event'] ) ? (int) $_GET['admin-single-event'] : '';

		$myposts = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $wpdb->posts
				WHERE post_type like %s
				AND post_parent = 0
				AND post_status <> 'trash'
				AND post_title <> 'Auto Draft'
				ORDER BY $wpdb->posts.post_title ASC",
				$wpdb->esc_like( $post_type_listing ) . '%'
			)
		);

		echo '<select name="admin-single-event" class="event-quick-link">
		<option selected="selected" value="">Select Event</option>';
		foreach ( $myposts as $ep ) {
			$e = get_post( $ep );
			if ( $e->ID === $post_id ) {
				echo '<option value="' . esc_html( $e->ID ) . '" selected="selected">' . esc_html( $e->post_title ) . '</option>';
			} else {
				echo '<option value="' . esc_html( $e->ID ) . '">' . esc_html( $e->post_title ) . '</option>';
			}
		}
		echo '</select>';
	}

	/**
	 * Does the actual filtering of Events in the Admin listing
	 *
	 * @param object $query Existing query.
	 */
	public function event_list_filter( $query ) {
		$post_id = isset( $_GET['admin-single-event'] ) ? (int) $_GET['admin-single-event'] : '';
		if ( ! $post_id ) {
			return;
		}

		$posts_ids = array( $post_id );
		$posts_ids = array_merge( $posts_ids, get_kids( $post_id ) );

		$query->set( 'post__in', $posts_ids );
		$query->set( 'order', 'ASC' );
		$query->set( 'orderby', 'parent' );
	}

	/**
	 * If the Event has a external url set then this sets the noindex meta to true and vice versa.
	 *
	 * @param int $post_id The post id.
	 */
	public function synchronize_noindex_meta( $post_id ) {
		if ( ! in_array( get_post_type( $post_id ), $this->post_types ) ) {
			return;
		}

		$external_url = get_post_meta( $post_id, 'lfes_external_url', true );
		if ( $external_url ) {
			update_post_meta( $post_id, '_genesis_noindex', true );
		} else {
			delete_post_meta( $post_id, '_genesis_noindex' );
		}
	}
}


/**
 * Returns an array of all descendents of $post_id.
 * Recursive function.
 *
 * @param int $post_id parent post.
 */
function get_kids( $post_id ) {
	global $wpdb;

	$kid_ids = array();

	$kid_posts = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM $wpdb->posts
			WHERE post_parent = %d
			AND post_status <> 'trash'",
			$post_id
		)
	);

	if ( ! $kid_posts ) {
		return array();
	}

	foreach ( $kid_posts as $kid ) {
		$kid_ids[] = $kid->ID;
		$kid_ids = array_merge( $kid_ids, get_kids( $kid->ID ) );
	}

	return $kid_ids;
}

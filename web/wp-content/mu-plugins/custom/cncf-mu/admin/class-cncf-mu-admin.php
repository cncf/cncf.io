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
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions' ),
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
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions' ),
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
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		);
		register_post_type( 'cncf_webinar', $opts );

		$opts = array(
			'labels'       => array(
				'name'          => __( 'Events We\'ll Be At' ),
				'singular_name' => __( 'Event' ),
				'all_items'     => __( 'All Events' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'menu_icon'    => 'dashicons-calendar',
			'rewrite'      => array( 'slug' => 'events' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		);
		register_post_type( 'cncf_events_wba', $opts );

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
			'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		);
		register_post_type( 'cncf_projects', $opts );


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

		// Return the $sidebars array with our sidebar now included.
		return $sidebars;

	}

}

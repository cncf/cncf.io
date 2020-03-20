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
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix part of WP.
	 */
	public function enqueue_styles( $hook_suffix ) {

			// only loads on CNCF MU top level page.
		if ( 'toplevel_page_cncf-mu' == $hook_suffix ) {

			// color picker.
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cncf-mu-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix part of WP.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		// only loads on CNCF MU top level page.
		if ( 'toplevel_page_cncf-mu' == $hook_suffix ) {

			// color picker.
			wp_enqueue_script( 'wp-color-picker' );
			// media uploader.
			wp_enqueue_media();
			// custom scripts.
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cncf-mu-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * Registers the custom post types
	 */
	public function register_cpts() {

		$opts = array(
			'labels'            => array(
				'name'          => __( 'People' ),
				'singular_name' => __( 'Person' ),
				'all_items'     => __( 'All People' ),
			),
			'public'            => true,
			'has_archive'       => false,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'menu_icon'         => 'dashicons-buddicons-buddypress-logo',
			'rewrite'           => array( 'slug' => 'person' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'excerpt' ),
		);
		register_post_type( 'cncf_person', $opts );

		$opts = array(
			'labels'            => array(
				'name'          => __( 'Case Studies' ),
				'singular_name' => __( 'Case Study' ),
				'all_items'     => __( 'All Case Studies' ),
			),
			'public'            => true,
			'has_archive'       => false,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'menu_icon'         => 'dashicons-awards',
			'rewrite'           => array( 'slug' => 'case-study' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_case_study', $opts );

		$opts = array(
			'labels'            => array(
				'name'          => __( 'Case Studies CN' ),
				'singular_name' => __( 'Case Study - Chinese' ),
				'all_items'     => __( 'All Case Studies' ),
			),
			'public'            => true,
			'has_archive'       => false,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'menu_icon'         => 'dashicons-awards',
			'rewrite'           => array( 'slug' => 'case-study-ch' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_case_study_ch', $opts );

		$opts = array(
			'labels'            => array(
				'name'          => __( 'Webinars' ),
				'singular_name' => __( 'Webinar' ),
				'all_items'     => __( 'All Webinars' ),
			),
			'public'            => true,
			'has_archive'       => false,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'menu_icon'         => 'dashicons-video-alt3',
			'rewrite'           => array( 'slug' => 'webinar' ),
			'supports'          => array( 'title', 'editor', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_webinar', $opts );

		$opts = array(
			'labels'            => array(
				'name'          => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'all_items'     => __( 'All Events' ),
			),
			'public'            => true,
			'has_archive'       => false,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'menu_icon'         => 'dashicons-calendar',
			'rewrite'           => array( 'slug' => 'events' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_event', $opts );

		$opts = array(
			'labels'            => array(
				'name'          => __( 'Projects' ),
				'singular_name' => __( 'Project' ),
				'all_items'     => __( 'All Projects' ),
			),
			'public'            => true,
			'has_archive'       => false,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'menu_icon'         => 'dashicons-hammer',
			'rewrite'           => array( 'slug' => 'projects' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'cncf_project', $opts );

		$opts = array(
			'labels'            => array(
				'name'          => __( 'Speakers' ),
				'singular_name' => __( 'Speaker' ),
				'all_items'     => __( 'All Speakers' ),
			),
			'public'            => false,
			'has_archive'       => false,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'menu_icon'         => 'dashicons-groups',
			'rewrite'           => array( 'slug' => 'speakers' ),
			'supports'          => array( 'title', 'custom-fields' ),
		);
		register_post_type( 'cncf_speaker', $opts );

	}


	/**
	 * Registers the extra sidebar for post types
	 *
	 * @param array $sidebars    Existing sidebars in Gutenberg.
	 */
	public function create_sidebar( $sidebars ) {
		// First we define the sidebar with it's tabs, panels and settings.
		$palette = array(
			'dark-fuschia'     => '#6e1042',
			'dark-violet'      => '#411E4F',
			'dark-indigo'      => '#1A267D',
			'dark-blue'        => '#17405c',
			'dark-aqua'        => '#0e5953',
			'dark-green'       => '#0b5329',

			'light-fuschia'    => '#AD1457',
			'light-violet'     => '#6C3483',
			'light-indigo'     => '#4653B0',
			'light-blue'       => '#2874A6',
			'light-aqua'       => '#148f85',
			'light-green'      => '#117a3d',

			'dark-chartreuse'  => '#3d5e0f',
			'dark-yellow'      => '#878700',
			'dark-gold'        => '#8c7000',
			'dark-orange'      => '#784e12',
			'dark-umber'       => '#6E2C00',
			'dark-red'         => '#641E16',

			'light-chartreuse' => '#699b23',
			'light-yellow'     => '#b0b000',
			'light-gold'       => '#c29b00',
			'light-orange'     => '#c2770e',
			'light-umber'      => '#b8510d',
			'light-red'        => '#922B21',
		);

		$sidebar    = array(
			'id'              => 'cncf-sidebar-event',
			'id_prefix'       => 'cncf_',
			'label'           => __( 'Event Settings' ),
			'post_type'       => 'cncf_event',
			'data_key_prefix' => 'cncf_event_',
			'icon_dashicon'   => 'admin-settings',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'        => __( 'General' ),
							'initial_open' => true,
							'settings'     => array(
								array(
									'type'              => 'date_single',
									'data_type'         => 'meta',
									'unavailable_dates' => array(),
									'data_key'          => 'date_start', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'             => __( 'Start Date', 'my_plugin' ),
									'register_meta'     => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top'     => true, // Display CSS border-top in the editor control.
									'default_value'     => '', // A string with a date that matches 'format'.
									'format'            => 'YYYY/MM/DD',
								),
								array(
									'type'              => 'date_single',
									'data_type'         => 'meta',
									'unavailable_dates' => array(),
									'data_key'          => 'date_end', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'             => __( 'End Date', 'my_plugin' ),
									'register_meta'     => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top'     => false, // Display CSS border-top in the editor control.
									'default_value'     => '', // A string with a date that matches 'format'.
									'format'            => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'external_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'URL to External Event Site' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.cloudfoundry.org/event/summit/',
								),
								array(
									'type'          => 'text',
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

		$sidebar    = array(
			'id'              => 'cncf-sidebar-webinar',
			'id_prefix'       => 'cncf_',
			'label'           => __( 'Webinar Settings' ),
			'post_type'       => 'cncf_webinar',
			'data_key_prefix' => 'cncf_webinar_',
			'icon_dashicon'   => 'admin-settings',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'        => __( 'General' ),
							'initial_open' => true,
							'settings'     => array(
								array(
									'type'              => 'date_single',
									'data_type'         => 'meta',
									'unavailable_dates' => array(),
									'data_key'          => 'date', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'             => __( 'Date', 'my_plugin' ),
									'register_meta'     => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top'     => true, // Display CSS border-top in the editor control.
									'default_value'     => '', // A string with a date that matches 'format'.
									'format'            => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'time', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Time' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => '10:00 - 11:00 AM CST',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'registration_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Registration URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://zoom.com.cn/webinar/register/WN_sMLQLH1JQbWa8CBUtzj0_A',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'speakers', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Speakers' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'Radu Matei, Software Engineer @ Microsoft',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'recording_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Recording URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.youtube.com/watch?v=95pkfWf8DgA',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'slides_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Slides URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.cncf.io/wp-content/uploads/2019/11/StackRox-Webinar-2019-11-12.pdf',
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$sidebar    = array(
			'id'              => 'cncf-sidebar-person',
			'id_prefix'       => 'cncf_',
			'label'           => __( 'Person Settings' ),
			'post_type'       => 'cncf_person',
			'data_key_prefix' => 'cncf_person_',
			'icon_dashicon'   => 'admin-settings',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'        => __( 'General' ),
							'initial_open' => true,
							'settings'     => array(
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'company', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Company and/or Title' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'DigitalOcean',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'linkedin', // Required if 'data_type' is 'meta'.
									'label'         => __( 'LinkedIn URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.linkedin.com/in/gilbert-song-939ba737/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'twitter', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Twitter URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://twitter.com/Gilbert_Songs',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'github', // Required if 'data_type' is 'meta'.
									'label'         => __( 'GitHub URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://github.com/Gilbert88',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'wechat', // Required if 'data_type' is 'meta'.
									'label'         => __( 'WeChat URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://web.wechat.com/donaldliu1874',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'website', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Website URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.weave.works/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'youtube', // Required if 'data_type' is 'meta'.
									'label'         => __( 'YouTube URL' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.youtube.com/channel/UCJsK5Zbq0dyFZUBtMTHzxjQ',
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$sidebar    = array(
			'id'              => 'cncf-sidebar-case-study',
			'id_prefix'       => 'cncf_',
			'label'           => __( 'Case Study Settings' ),
			'post_type'       => 'cncf_case_study',
			'data_key_prefix' => 'cncf_case_study_',
			'icon_dashicon'   => 'admin-settings',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'        => __( 'General' ),
							'initial_open' => true,
							'settings'     => array(
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'type', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Case Study Type' ),
									'help'          => __( 'This value will appear in the Case Study tile "READ THE ___ CASE STUDY"', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'Kubernetes',
								),
								array(
									'type'          => 'radio',
									'data_type'     => 'meta', // Available: 'meta', 'localstorage', 'none'.
									'data_key'      => 'product_type', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Product Type', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => 'installer', // Value/s from the 'options'.
									'use_toggle'    => false, // Use toggle control instead of checkbox.
									'options'       => array(
										'installer'    => __( 'Installer', 'my_plugin' ),
										'distribution' => __( 'Distribution', 'my_plugin' ),
										'hosted'       => __( 'Hosted', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'radio',
									'data_type'     => 'meta', // Available: 'meta', 'localstorage', 'none'.
									'data_key'      => 'cloud_type', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Cloud Type', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => 'public', // Value/s from the 'options'.
									'use_toggle'    => false, // Use toggle control instead of checkbox.
									'options'       => array(
										'public'  => __( 'Public', 'my_plugin' ),
										'hybrid'  => __( 'Hybrid', 'my_plugin' ),
										'private' => __( 'Private', 'my_plugin' ),
										'multi'   => __( 'Multi', 'my_plugin' ),
									),
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$sidebar    = array(
			'id'              => 'cncf-sidebar-case-study',
			'id_prefix'       => 'cncf_',
			'label'           => __( 'Case Study Settings' ),
			'post_type'       => 'cncf_case_study_ch',
			'data_key_prefix' => 'cncf_case_study_ch_',
			'icon_dashicon'   => 'admin-settings',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'        => __( 'General' ),
							'initial_open' => true,
							'settings'     => array(
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'type', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Case Study Type' ),
									'help'          => __( 'This value will appear in the Case Study tile "阅读 ___ 案例研究"', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'Kubernetes',
								),
								array(
									'type'          => 'radio',
									'data_type'     => 'meta', // Available: 'meta', 'localstorage', 'none'.
									'data_key'      => 'product_type', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Product Type', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => 'installer', // Value/s from the 'options'.
									'use_toggle'    => false, // Use toggle control instead of checkbox.
									'options'       => array( // Required.
										'installer'    => __( '安装程序 (Installer)', 'my_plugin' ),
										'distribution' => __( '发行版 (Distribution)', 'my_plugin' ),
										'hosted'       => __( '托管 (Hosted)', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'radio', // Required.
									'data_type'     => 'meta', // Available: 'meta', 'localstorage', 'none'.
									'data_key'      => 'cloud_type', // Required if 'data_type' is 'meta' or 'localstorage'.
									'label'         => __( 'Cloud Type', 'my_plugin' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => 'public', // Value/s from the 'options'.
									'use_toggle'    => false, // Use toggle control instead of checkbox.
									'options'       => array( // Required.
										'public'  => __( '公有 (Public)', 'my_plugin' ),
										'hybrid'  => __( '混合 (Hybrid)', 'my_plugin' ),
										'private' => __( '私有 (Private)', 'my_plugin' ),
										'multi'   => __( '多云 (Multi)', 'my_plugin' ),
									),
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$sidebar    = array(
			'id'              => 'cncf-sidebar-project',
			'id_prefix'       => 'cncf_',
			'label'           => __( 'Project Settings' ),
			'post_type'       => 'cncf_project',
			'data_key_prefix' => 'cncf_project_',
			'icon_dashicon'   => 'admin-settings',
			'tabs'            => array(
				array(
					'label'  => __( 'Tab label' ),
					'panels' => array(
						array(
							'label'        => __( 'General' ),
							'initial_open' => true,
							'settings'     => array(
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'external_url', // Required if 'data_type' is 'meta'.
									'label'         => __( 'URL to Project Site' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.envoyproxy.io/',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'github', // Required if 'data_type' is 'meta'.
									'label'         => __( 'GitHub' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => true, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://github.com/coredns/coredns',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'blog', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Blog' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://blog.coredns.io/',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'logos', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Logos' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://github.com/cncf/artwork/blob/master/examples/graduated.md#coredns-logos',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'mail', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Mail' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://groups.google.com/forum/#!forum/coredns-discuss',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'slack', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Slack' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://cloud-native.slack.com/messages/coredns/',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'stack_overflow', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Stack Overflow' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://stackoverflow.com/questions/tagged/coredns',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'twitter', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Twitter' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://twitter.com/corednsio',
								),
								array(
									'type'          => 'text', // Required.
									'data_type'     => 'meta',
									'data_key'      => 'youtube', // Required if 'data_type' is 'meta'.
									'label'         => __( 'YouTube' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://www.youtube.com/channel/UCbWRJZxiaQ8twm6sh7UymoQ',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'gitter', // Required if 'data_type' is 'meta'.
									'label'         => __( 'Gitter' ),
									'register_meta' => true, // This option is applicable only if 'data_type' is 'meta'.
									'ui_border_top' => false, // Display CSS border-top in the editor control.
									'default_value' => '',
									'placeholder'   => 'https://gitter.im/jaegertracing/Lobby',
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
			'name'              => __( 'Country', 'cncf-mu' ),
			'singular_name'     => __( 'Country', 'cncf-mu' ),
			'search_items'      => __( 'Search Countries', 'cncf-mu' ),
			'all_items'         => __( 'All Countries', 'cncf-mu' ),
			'parent_item'       => __( 'Parent Continent', 'cncf-mu' ),
			'parent_item_colon' => __( 'Parent Continent:', 'cncf-mu' ),
			'edit_item'         => __( 'Edit Country', 'cncf-mu' ),
			'update_item'       => __( 'Update Country', 'cncf-mu' ),
			'add_new_item'      => __( 'Add New Country', 'cncf-mu' ),
			'new_item_name'     => __( 'New Country Name', 'cncf-mu' ),
			'menu_name'         => __( 'Countries', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-country', array( 'cncf_event', 'cncf_case_study', 'cncf_speaker' ), $args );

		$labels = array(
			'name'              => __( 'Country', 'cncf-mu' ),
			'singular_name'     => __( 'Country', 'cncf-mu' ),
			'search_items'      => __( 'Search Countries', 'cncf-mu' ),
			'all_items'         => __( 'All Countries', 'cncf-mu' ),
			'parent_item'       => __( 'Parent Continent', 'cncf-mu' ),
			'parent_item_colon' => __( 'Parent Continent:', 'cncf-mu' ),
			'edit_item'         => __( 'Edit Country', 'cncf-mu' ),
			'update_item'       => __( 'Update Country', 'cncf-mu' ),
			'add_new_item'      => __( 'Add New Country', 'cncf-mu' ),
			'new_item_name'     => __( 'New Country Name', 'cncf-mu' ),
			'menu_name'         => __( 'Countries', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-country-ch', array( 'cncf_case_study_ch' ), $args );

		$labels = array(
			'name'          => __( 'Projects', 'cncf-mu' ),
			'singular_name' => __( 'Project', 'cncf-mu' ),
			'search_items'  => __( 'Search Projects', 'cncf-mu' ),
			'all_items'     => __( 'All Projects', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Project', 'cncf-mu' ),
			'update_item'   => __( 'Update Project', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Project', 'cncf-mu' ),
			'new_item_name' => __( 'New Project Name', 'cncf-mu' ),
			'menu_name'     => __( 'Projects', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-project', array( 'cncf_webinar', 'cncf_case_study', 'cncf_case_study_ch', 'cncf_speaker' ), $args );

		$labels = array(
			'name'          => __( 'Category', 'cncf-mu' ),
			'singular_name' => __( 'Category', 'cncf-mu' ),
			'search_items'  => __( 'Search Categories', 'cncf-mu' ),
			'all_items'     => __( 'All Categories', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Category', 'cncf-mu' ),
			'update_item'   => __( 'Update Category', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Category', 'cncf-mu' ),
			'new_item_name' => __( 'New Category Name', 'cncf-mu' ),
			'menu_name'     => __( 'Categories', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-webinar-category', array( 'cncf_webinar' ), $args );

		$labels = array(
			'name'          => __( 'Company', 'cncf-mu' ),
			'singular_name' => __( 'Company', 'cncf-mu' ),
			'search_items'  => __( 'Search Companies', 'cncf-mu' ),
			'all_items'     => __( 'All Companies', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Company', 'cncf-mu' ),
			'update_item'   => __( 'Update Company', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Company', 'cncf-mu' ),
			'new_item_name' => __( 'New Company Name', 'cncf-mu' ),
			'menu_name'     => __( 'Companies', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-company', array( 'cncf_webinar' ), $args );

		$labels = array(
			'name'          => __( 'Topics', 'cncf-mu' ),
			'singular_name' => __( 'Topic', 'cncf-mu' ),
			'search_items'  => __( 'Search Topics', 'cncf-mu' ),
			'all_items'     => __( 'All Topics', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Topic', 'cncf-mu' ),
			'update_item'   => __( 'Update Topic', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Topic', 'cncf-mu' ),
			'new_item_name' => __( 'New Topic Name', 'cncf-mu' ),
			'menu_name'     => __( 'Topics', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-topic', array( 'cncf_webinar' ), $args );

		$labels = array(
			'name'          => __( 'Category', 'cncf-mu' ),
			'singular_name' => __( 'Category', 'cncf-mu' ),
			'search_items'  => __( 'Search Categories', 'cncf-mu' ),
			'all_items'     => __( 'All Categories', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Category', 'cncf-mu' ),
			'update_item'   => __( 'Update Category', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Category', 'cncf-mu' ),
			'new_item_name' => __( 'New Category Name', 'cncf-mu' ),
			'menu_name'     => __( 'People Categories', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-person-category', array( 'cncf_person' ), $args );

		$labels = array(
			'name'          => __( 'Challenges', 'cncf-mu' ),
			'singular_name' => __( 'Challenge', 'cncf-mu' ),
			'search_items'  => __( 'Search Challenges', 'cncf-mu' ),
			'all_items'     => __( 'All Challenges', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Challenge', 'cncf-mu' ),
			'update_item'   => __( 'Update Challenge', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Challenge', 'cncf-mu' ),
			'new_item_name' => __( 'New Challenge Name', 'cncf-mu' ),
			'menu_name'     => __( 'Challenges', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-challenge', array( 'cncf_case_study' ), $args );

		$labels = array(
			'name'          => __( 'Challenges', 'cncf-mu' ),
			'singular_name' => __( 'Challenge', 'cncf-mu' ),
			'search_items'  => __( 'Search Challenges', 'cncf-mu' ),
			'all_items'     => __( 'All Challenges', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Challenge', 'cncf-mu' ),
			'update_item'   => __( 'Update Challenge', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Challenge', 'cncf-mu' ),
			'new_item_name' => __( 'New Challenge Name', 'cncf-mu' ),
			'menu_name'     => __( 'Challenges', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-challenge-ch', array( 'cncf_case_study_ch' ), $args );

		$labels = array(
			'name'          => __( 'Industries', 'cncf-mu' ),
			'singular_name' => __( 'Industry', 'cncf-mu' ),
			'search_items'  => __( 'Search Industries', 'cncf-mu' ),
			'all_items'     => __( 'All Industries', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Industry', 'cncf-mu' ),
			'update_item'   => __( 'Update Industry', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Industry', 'cncf-mu' ),
			'new_item_name' => __( 'New Industry Name', 'cncf-mu' ),
			'menu_name'     => __( 'Industries', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-industry', array( 'cncf_case_study' ), $args );

		$labels = array(
			'name'          => __( 'Industries', 'cncf-mu' ),
			'singular_name' => __( 'Industry', 'cncf-mu' ),
			'search_items'  => __( 'Search Industries', 'cncf-mu' ),
			'all_items'     => __( 'All Industries', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Industry', 'cncf-mu' ),
			'update_item'   => __( 'Update Industry', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Industry', 'cncf-mu' ),
			'new_item_name' => __( 'New Industry Name', 'cncf-mu' ),
			'menu_name'     => __( 'Industries', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-industry-ch', array( 'cncf_case_study_ch' ), $args );

		/**
		 * Project Stage Taxonomy for Projects.
		 */
		$labels = array(
			'name'          => __( 'Project Stage', 'cncf-mu' ),
			'singular_name' => __( 'Project Stage', 'cncf-mu' ),
			'search_items'  => __( 'Search Project Stages', 'cncf-mu' ),
			'all_items'     => __( 'All Project Stages', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Project Stage', 'cncf-mu' ),
			'update_item'   => __( 'Update Project Stage', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Project Stage', 'cncf-mu' ),
			'new_item_name' => __( 'New Project Stage', 'cncf-mu' ),
			'menu_name'     => __( 'Project Stages', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
		);
		register_taxonomy( 'cncf-project-stage', array( 'cncf_project' ), $args );

		$labels = array(
			'name'          => __( 'Host', 'cncf-mu' ),
			'singular_name' => __( 'Host', 'cncf-mu' ),
			'search_items'  => __( 'Search Hosts', 'cncf-mu' ),
			'all_items'     => __( 'All Hosts', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Host', 'cncf-mu' ),
			'update_item'   => __( 'Update Host', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Host', 'cncf-mu' ),
			'new_item_name' => __( 'New Host', 'cncf-mu' ),
			'menu_name'     => __( 'Hosts', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-event-host', array( 'cncf_event' ), $args );

		$labels = array(
			'name'          => __( 'Language', 'cncf-mu' ),
			'singular_name' => __( 'Language', 'cncf-mu' ),
			'search_items'  => __( 'Search Languages', 'cncf-mu' ),
			'all_items'     => __( 'All Languages', 'cncf-mu' ),
			'edit_item'     => __( 'Edit Language', 'cncf-mu' ),
			'update_item'   => __( 'Update Language', 'cncf-mu' ),
			'add_new_item'  => __( 'Add New Language', 'cncf-mu' ),
			'new_item_name' => __( 'New Language', 'cncf-mu' ),
			'menu_name'     => __( 'Languages', 'cncf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-language', array( 'cncf_webinar', 'cncf_speaker' ), $args );

		$args   = array(
			'labels'            => array( 'name' => __( 'Affiliations', 'cncf-mu' ) ),
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-speaker-affiliation', array( 'cncf_speaker' ), $args );
		$args   = array(
			'labels'            => array( 'name' => __( 'Expertise', 'cncf-mu' ) ),
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'cncf-speaker-expertise', array( 'cncf_speaker' ), $args );
	}

	/**
	 * Removes unneeded menu items from the admin.
	 */
	public function remove_menu_items() {
		remove_menu_page( 'edit-comments.php' );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since 1.1.0
	 */
	public function add_plugin_admin_menu() {
		add_menu_page( 'Global Options', 'Global Options', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_setup_page' ), null, 4 );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.1.0
	 */
	public function display_plugin_setup_page() {
		include_once 'partials/' . $this->plugin_name . '-admin-display.php';
	}

	/**
	 * Validate fields from admin area plugin settings form
	 *
	 * @param  mixed $input as field form settings form.
	 * @return mixed as validated fields.
	 *
	 * @since 1.1.0
	 */
	public function validate( $input ) {

		$options = get_option( $this->plugin_name );

		$options['show_hello_bar'] = ( isset( $input['show_hello_bar'] ) && ! empty( $input['show_hello_bar'] ) ) ? 1 : 0;

		$options['hello_bar_content'] = ( isset( $input['hello_bar_content'] ) && ! empty( $input['hello_bar_content'] ) ) ? $input['hello_bar_content'] : '';

		$options['hello_bar_bg'] = ( isset( $input['hello_bar_bg'] ) && ! empty( $input['hello_bar_bg'] ) ) ? esc_attr( $input['hello_bar_bg'] ) : '';

		$options['header_image_id'] = ( isset( $input['header_image_id'] ) && ! empty( $input['header_image_id'] ) ) ? absint( $input['header_image_id'] ) : '';

		$options['header_cta_text'] = ( isset( $input['header_cta_text'] ) && ! empty( $input['header_cta_text'] ) ) ? esc_html( $input['header_cta_text'] ) : '';

		$options['header_cta_link'] = ( isset( $input['header_cta_link'] ) && ! empty( $input['header_cta_link'] ) ) ? absint( $input['header_cta_link'] ) : '';

		$options['copyright_textarea'] = ( isset( $input['copyright_textarea'] ) && ! empty( $input['copyright_textarea'] ) ) ? $input['copyright_textarea'] : '';

		$options['social_email'] = ( isset( $input['social_email'] ) && ! empty( $input['social_email'] ) ) ? esc_attr( $input['social_email'] ) : '';

		$options['social_facebook'] = ( isset( $input['social_facebook'] ) && ! empty( $input['social_facebook'] ) ) ? esc_url( $input['social_facebook'] ) : '';

		$options['social_flickr'] = ( isset( $input['social_flickr'] ) && ! empty( $input['social_flickr'] ) ) ? esc_url( $input['social_flickr'] ) : '';

		$options['social_github'] = ( isset( $input['social_github'] ) && ! empty( $input['social_github'] ) ) ? esc_url( $input['social_github'] ) : '';

		$options['social_instagram'] = ( isset( $input['social_instagram'] ) && ! empty( $input['social_instagram'] ) ) ? esc_url( $input['social_instagram'] ) : '';

		$options['social_linkedin'] = ( isset( $input['social_linkedin'] ) && ! empty( $input['social_linkedin'] ) ) ? esc_url( $input['social_linkedin'] ) : '';

		$options['social_meetup'] = ( isset( $input['social_meetup'] ) && ! empty( $input['social_meetup'] ) ) ? esc_url( $input['social_meetup'] ) : '';

		$options['social_rss'] = ( isset( $input['social_rss'] ) && ! empty( $input['social_rss'] ) ) ? esc_url( $input['social_rss'] ) : '';

		$options['social_twitter'] = ( isset( $input['social_twitter'] ) && ! empty( $input['social_twitter'] ) ) ? esc_url( $input['social_twitter'] ) : '';

		$options['social_youtube'] = ( isset( $input['social_youtube'] ) && ! empty( $input['social_youtube'] ) ) ? esc_url( $input['social_youtube'] ) : '';

		$options['social_wechat_id'] = ( isset( $input['social_wechat_id'] ) && ! empty( $input['social_wechat_id'] ) ) ? absint( $input['social_wechat_id'] ) : '';

		return $options;
	}

	/**
	 * Update options
	 *
	 * @since 1.1.0
	 */
	public function options_update() {
		register_setting(
			$this->plugin_name,
			$this->plugin_name,
			array(
				'sanitize_callback' => array( $this, 'validate' ),
			)
		);
	}

	/**
	 * Sync User of role "Speaker" to the cncf_speaker CPT.
	 *
	 * @param int $user_id ID of user.
	 */
	private function sync_speaker( $user_id ) {
		global $post;

		if ( ! $user_id ) {
			return;
		}

		$um_member_directory_data = get_user_meta( $user_id, 'um_member_directory_data', false )[0];
		$photo = get_user_meta( $user_id, 'profile_photo', true );
		if ( 'approved' !== $um_member_directory_data['account_status'] || ! $photo ) {
			// speaker must be approved and have a photo.
			$eligible_for_search = false;
		} else {
			$eligible_for_search = true;
		}

		$query = new WP_Query(
			array(
				'name' => $user_id,
				'post_type' => 'cncf_speaker',
			)
		);

		if ( $query->have_posts() ) {
			$query->the_post();
			$speaker_id = $post->ID;
			if ( ! $eligible_for_search ) {
				wp_delete_post( $speaker_id, true );
				return;
			}
		} else {
			if ( ! $eligible_for_search ) {
				return;
			}
			$speaker_id = wp_insert_post(
				array(
					'post_title'  => $user_id,
					'post_type'   => 'cncf_speaker',
					'post_status' => 'publish',
				)
			);
		}

		$affiliations = get_user_meta( $user_id, 'sb_certifications', false )[0];
		$expertise = get_user_meta( $user_id, 'expertise', false )[0];
		$languages = get_user_meta( $user_id, 'languages', false )[0];
		$projects = get_user_meta( $user_id, 'project', false )[0];
		$country = get_user_meta( $user_id, 'country', false )[0];

		$country = str_replace( 'Korea, Republic of', 'South Korea', $country );
		$country = str_replace( "Korea, Democratic People's Republic of", 'North Korea', $country );
		$country = str_replace( 'Bolivia, Plurinational State of', 'Bolivia', $country );
		$country = str_replace( 'Congo', 'Congo, Republic of the', $country );
		$country = str_replace( 'Iran, Islamic Republic of', 'Iran', $country );
		$country = str_replace( 'Palestine', 'Palestinian Territory, Occupied', $country );
		$country = str_replace( 'Pitcairn', 'Pitcairn Islands', $country );
		$country = str_replace( 'Saint Martin (French part)', 'Saint Martin', $country );
		$country = str_replace( 'Taiwan, Province of China', 'Taiwan', $country );
		$country = str_replace( 'Virgin Islands, U.S.', 'United States Virgin Islands', $country );
		$country = str_replace( 'Virgin Islands, British', 'British Virgin Islands', $country );
		$country = str_replace( 'Venezuela, Bolivarian Republic of', 'Venezuela', $country );
		$country = str_replace( 'Viet Nam', 'Vietnam', $country );

		wp_set_object_terms( $speaker_id, $affiliations, 'cncf-speaker-affiliation' );
		wp_set_object_terms( $speaker_id, $expertise, 'cncf-speaker-expertise' );
		wp_set_object_terms( $speaker_id, $languages, 'cncf-language' );
		wp_set_object_terms( $speaker_id, $projects, 'cncf-project' );
		wp_set_object_terms( $speaker_id, $country, 'cncf-country' );

		wp_reset_postdata();
	}

	/**
	 * Syncs all the cncf_speaker data with the Users of role "Speaker" metadata.
	 * This function is triggered when you update the "Speakers" page.
	 *
	 * @param int    $post_id ID of post that is trashed.
	 * @param object $post_after Post object following the update.
	 * @param object $post_before Post object before the update.
	 */
	public function sync_speakers( $post_id, $post_after = null, $post_before = null ) {
		$post = get_post( $post_id );
		if ( 'page' !== $post->post_type || 'speakers' !== $post->post_name ) {
			return;
		}

		$allposts = get_posts(
			array(
				'post_type'   => 'cncf_speaker',
				'numberposts' => -1,
			),
		);
		foreach ( $allposts as $eachpost ) {
			wp_delete_post( $eachpost->ID, true );
		}

		$args = array( 'role' => 'um_speaker' );
		$wp_user_query = new WP_User_Query( $args );
		$users = $wp_user_query->get_results();
		foreach ( $users as $user ) {
			$this->sync_speaker( $user->ID );
		}
	}

	/**
	 * Function is triggered by any action that updates a cncf_speaker
	 *
	 * @param int   $user_id User ID.
	 * @param array $args Args.
	 * @param array $userinfo User Info.
	 */
	public function speaker_updated( $user_id, $args = null, $userinfo = null ) {
		$user = get_userdata( $user_id );
		$user_roles = $user->roles;

		if ( in_array( 'um_speaker', $user_roles, true ) ) {
			$this->sync_speaker( $user_id );
		}
	}

	/**
	 * Function is triggered by a delete user action
	 *
	 * @param int $user_id User ID.
	 */
	public function speaker_deleted( $user_id ) {
		global $post;
		$query = new WP_Query(
			array(
				'name' => $user_id,
				'post_type' => 'cncf_speaker',
			)
		);

		if ( $query->have_posts() ) {
			$query->the_post();
			wp_delete_post( $post->ID, true );
		}
	}
}

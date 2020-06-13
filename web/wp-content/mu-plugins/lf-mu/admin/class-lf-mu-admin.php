<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.cncf.io/
 * @since      1.0.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/admin
 * @author     Chris Abraham <cjyabraham@gmail.com>
 */
class Lf_Mu_Admin {

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

			// only loads on LF MU top level page.
		if ( 'toplevel_page_lf-mu' == $hook_suffix ) {

			// color picker.
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lf-mu-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix part of WP.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		// only loads on LF MU top level page.
		if ( 'toplevel_page_lf-mu' == $hook_suffix ) {

			// color picker.
			wp_enqueue_script( 'wp-color-picker' );
			// media uploader.
			wp_enqueue_media();
			// custom scripts.
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lf-mu-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * Registers the custom post types
	 */
	public function register_cpts() {

		// Case Study Block Template setup.
		$case_study_block_template = array(
			array(
				'core/heading',
				array(
					'level'     => '1',
					'placeholder'   => 'Case study title to be shown as page header',
					'className' => 'is-style-max-800',
				),
			),
			array( 'lf/case-study-overview' ),
			array( 'lf/case-study-highlights' ),
			array( 'core-embed/youtube' ),
			array(
				'core/heading',
				array(
					'level'       => '3',
					'placeholder' => 'Introductory paragraph to the case study',
					'className' => 'is-style-max-800',
				),
			),
			array( 'core/paragraph' ),
			array( 'core/paragraph' ),
			array(
				'core/gallery',
				array(
					'align' => 'wide',
				),
			),
			array( 'core/paragraph' ),
			array( 'core/paragraph' ),
			array(
				'core/quote',
				array(
					'placeholder'   => 'Nice quote from customer lorem ipsum dolor sit amet consectetuer adipiscing elit aenean commodo',
					'className' => 'is-style-case-study-quote',
				),
			),
		);

		$opts = array(
			'labels'              => array(
				'name'          => __( 'People' ),
				'singular_name' => __( 'Person' ),
				'all_items'     => __( 'All People' ),
			),
			'public'              => true,
			'has_archive'         => false,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => true,
			'hierarchical'        => false,
			'exclude_from_search' => true, // to hide the singular pages on FE.
			'publicly_queryable'  => false, // to hide the singular pages on FE.
			'menu_icon'           => 'dashicons-buddicons-buddypress-logo',
			'rewrite'             => array( 'slug' => 'person' ),
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'excerpt' ),
		);
		register_post_type( 'lf_person', $opts );

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
			'template'          => $case_study_block_template,
			'menu_icon'         => 'dashicons-awards',
			'rewrite'           => array( 'slug' => 'case-studies' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'lf_case_study', $opts );

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
			'rewrite'           => array( 'slug' => 'case-studies-ch' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'lf_case_study_ch', $opts );

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
			'rewrite'           => array( 'slug' => 'webinars' ),
			'supports'          => array( 'title', 'editor', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'lf_webinar', $opts );

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
		register_post_type( 'lf_event', $opts );

		$opts = array(
			'labels'              => array(
				'name'          => __( 'Projects' ),
				'singular_name' => __( 'Project' ),
				'all_items'     => __( 'All Projects' ),
			),
			'public'              => true,
			'has_archive'         => false,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => true,
			'hierarchical'        => false,
			'exclude_from_search' => true, // to hide the singular pages on FE.
			'publicly_queryable'  => false, // to hide the singular pages on FE.
			'menu_icon'           => 'dashicons-hammer',
			'rewrite'             => array( 'slug' => 'projects' ),
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'lf_project', $opts );

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
			'rewrite'           => array( 'slug' => 'speakers-mirror' ),
			'supports'          => array( 'title', 'custom-fields' ),
		);
		register_post_type( 'lf_speaker', $opts );

		$opts = array(
			'labels'            => array(
				'name'          => __( 'Spotlights' ),
				'singular_name' => __( 'Spotlight' ),
				'all_items'     => __( 'All Spotlights' ),
			),
			'public'            => true,
			'has_archive'       => false,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'menu_icon'         => 'dashicons-universal-access-alt',
			'rewrite'           => array( 'slug' => 'spotlights' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		);
		register_post_type( 'lf_spotlight', $opts );

	}


	/**
	 * Registers the extra sidebar for post types
	 *
	 * See https://melonpan.io/wordpress-plugins/post-meta-controls/ for docs.
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
			'id'              => 'lf-sidebar-event',
			'id_prefix'       => 'lf_',
			'label'           => __( 'Event Settings' ),
			'post_type'       => 'lf_event',
			'data_key_prefix' => 'lf_event_',
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
									'data_key'          => 'date_start',
									'label'             => __( 'Start Date' ),
									'register_meta'     => true,
									'ui_border_top'     => true,
									'default_value'     => '',
									'format'            => 'YYYY/MM/DD',
								),
								array(
									'type'              => 'date_single',
									'data_type'         => 'meta',
									'unavailable_dates' => array(),
									'data_key'          => 'date_end',
									'label'             => __( 'End Date' ),
									'register_meta'     => true,
									'ui_border_top'     => false,
									'default_value'     => '',
									'format'            => 'YYYY/MM/DD',
									'help'              => __( 'Optional for single day events.' ),
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'external_url',
									'label'         => __( 'URL to External Event Site' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://www.cloudfoundry.org/event/summit/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'city',
									'label'         => __( 'City' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'Hamilton',
								),
								array(
									'type'          => 'image',
									'data_type'     => 'meta',
									'data_key'      => 'logo',
									'id'            => 'event-logo', // keep this for CSS styling.
									'label'         => __( 'Event Logo' ),
									'help'          => __( 'Set a transparent logo for the event using an SVG or PNG file type.' ),
									'register_meta' => true,
								),
								array(
									'type'          => 'image',
									'data_type'     => 'meta',
									'data_key'      => 'background',
									'label'         => __( 'Event Background' ),
									'help'          => __( 'An image used for the background of the event tile. Recommended to use a square size at least 700px x 700px.' ),
									'register_meta' => true,
								),
								array(
									'type'          => 'color',
									'data_type'     => 'meta',
									'data_key'      => 'overlay_color',
									'label'         => __( 'Color Overlay' ),
									'help'          => __( 'Chose a color to overlay the background image' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'alpha_control' => true,
									'palette'       => $palette,
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$tzlist = DateTimeZone::listIdentifiers( DateTimeZone::ALL );
		$tzs = array();
		foreach ( $tzlist as $tz ) {
			$slug = str_replace( '/', '-', $tz );
			$tzs[ $slug ] = $tz;
		}

		$sidebar    = array(
			'id'              => 'lf-sidebar-webinar',
			'id_prefix'       => 'lf_',
			'label'           => __( 'Webinar Settings' ),
			'post_type'       => 'lf_webinar',
			'data_key_prefix' => 'lf_webinar_',
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
									'data_key'          => 'date',
									'label'             => __( 'Date' ),
									'register_meta'     => true,
									'ui_border_top'     => true,
									'default_value'     => '',
									'format'            => 'YYYY/MM/DD',
								),
								array(
									'type'          => 'select',
									'data_type'     => 'meta',
									'data_key'      => 'start_time',
									'label'         => __( 'Start Time' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '10:00',
									'options'         => array(
										'01:00' => __( '1:00', 'my_plugin' ),
										'01:30' => __( '1:30', 'my_plugin' ),
										'02:00' => __( '2:00', 'my_plugin' ),
										'02:30' => __( '2:30', 'my_plugin' ),
										'03:00' => __( '3:00', 'my_plugin' ),
										'03:30' => __( '3:30', 'my_plugin' ),
										'04:00' => __( '4:00', 'my_plugin' ),
										'04:30' => __( '4:30', 'my_plugin' ),
										'05:00' => __( '5:00', 'my_plugin' ),
										'05:30' => __( '5:30', 'my_plugin' ),
										'06:00' => __( '6:00', 'my_plugin' ),
										'06:30' => __( '6:30', 'my_plugin' ),
										'07:00' => __( '7:00', 'my_plugin' ),
										'07:30' => __( '7:30', 'my_plugin' ),
										'08:00' => __( '8:00', 'my_plugin' ),
										'08:30' => __( '8:30', 'my_plugin' ),
										'09:00' => __( '9:00', 'my_plugin' ),
										'09:30' => __( '9:30', 'my_plugin' ),
										'10:00' => __( '10:00', 'my_plugin' ),
										'10:30' => __( '10:30', 'my_plugin' ),
										'11:00' => __( '11:00', 'my_plugin' ),
										'11:30' => __( '11:30', 'my_plugin' ),
										'12:00' => __( '12:00', 'my_plugin' ),
										'12:30' => __( '12:30', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'select',
									'data_type'     => 'meta',
									'data_key'      => 'start_time_period',
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => 'am',
									'options'         => array(
										'am' => __( 'AM', 'my_plugin' ),
										'pm' => __( 'PM', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'select',
									'data_type'     => 'meta',
									'data_key'      => 'end_time',
									'label'         => __( 'End Time' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '10:00',
									'options'         => array(
										'01:00' => __( '1:00', 'my_plugin' ),
										'01:30' => __( '1:30', 'my_plugin' ),
										'02:00' => __( '2:00', 'my_plugin' ),
										'02:30' => __( '2:30', 'my_plugin' ),
										'03:00' => __( '3:00', 'my_plugin' ),
										'03:30' => __( '3:30', 'my_plugin' ),
										'04:00' => __( '4:00', 'my_plugin' ),
										'04:30' => __( '4:30', 'my_plugin' ),
										'05:00' => __( '5:00', 'my_plugin' ),
										'05:30' => __( '5:30', 'my_plugin' ),
										'06:00' => __( '6:00', 'my_plugin' ),
										'06:30' => __( '6:30', 'my_plugin' ),
										'07:00' => __( '7:00', 'my_plugin' ),
										'07:30' => __( '7:30', 'my_plugin' ),
										'08:00' => __( '8:00', 'my_plugin' ),
										'08:30' => __( '8:30', 'my_plugin' ),
										'09:00' => __( '9:00', 'my_plugin' ),
										'09:30' => __( '9:30', 'my_plugin' ),
										'10:00' => __( '10:00', 'my_plugin' ),
										'10:30' => __( '10:30', 'my_plugin' ),
										'11:00' => __( '11:00', 'my_plugin' ),
										'11:30' => __( '11:30', 'my_plugin' ),
										'12:00' => __( '12:00', 'my_plugin' ),
										'12:30' => __( '12:30', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'select',
									'data_type'     => 'meta',
									'data_key'      => 'end_time_period',
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => 'am',
									'options'         => array(
										'am' => __( 'AM', 'my_plugin' ),
										'pm' => __( 'PM', 'my_plugin' ),
									),
								),
								array(
									'type'          => 'select',
									'data_type'     => 'meta',
									'data_key'      => 'timezone',
									'label'         => __( 'Timezone' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => 'America-Los_Angeles',
									'options'       => $tzs,
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'registration_url',
									'label'         => __( 'Registration URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://zoom.com.cn/webinar/register/WN_sMLQLH1JQbWa8CBUtzj0_A',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'speakers',
									'label'         => __( 'Speakers' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'Radu Matei, Software Engineer at Microsoft',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'recording_url',
									'label'         => __( 'Recording URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://www.youtube.com/watch?v=95pkfWf8DgA',
									'help' => 'Leave blank if there is no recording',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'slides_url',
									'label'         => __( 'Slides URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
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
			'id'              => 'lf-sidebar-person',
			'id_prefix'       => 'lf_',
			'label'           => __( 'Person Settings' ),
			'post_type'       => 'lf_person',
			'data_key_prefix' => 'lf_person_',
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
									'data_key'      => 'company',
									'label'         => __( 'Company and/or Title' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'DigitalOcean',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'linkedin',
									'label'         => __( 'LinkedIn URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://www.linkedin.com/in/gilbert-song-939ba737/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'twitter',
									'label'         => __( 'Twitter URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://twitter.com/Gilbert_Songs',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'github',
									'label'         => __( 'GitHub URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://github.com/Gilbert88',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'wechat',
									'label'         => __( 'WeChat URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://web.wechat.com/donaldliu1874',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'website',
									'label'         => __( 'Website URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://www.weave.works/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'youtube',
									'label'         => __( 'YouTube URL' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://www.youtube.com/channel/UCJsK5Zbq0dyFZUBtMTHzxjQ',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'is_priority',
									'label'         => __( 'Priority Weighting' ),
									'help'          => __( 'The higher the number, the higher their position in the people layout.' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$sidebar    = array(
			'id'              => 'lf-sidebar-case-study',
			'id_prefix'       => 'lf_',
			'label'           => __( 'Case Study Settings' ),
			'post_type'       => 'lf_case_study',
			'data_key_prefix' => 'lf_case_study_',
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
									'data_key'      => 'type',
									'label'         => __( 'Case Study Type' ),
									'help'          => __( 'This value will appear in the Case Study tile "READ THE ___ CASE STUDY"' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'Kubernetes',
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$sidebar    = array(
			'id'              => 'lf-sidebar-case-study',
			'id_prefix'       => 'lf_',
			'label'           => __( 'Case Study Settings' ),
			'post_type'       => 'lf_case_study_ch',
			'data_key_prefix' => 'lf_case_study_ch_',
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
									'data_key'      => 'type',
									'label'         => __( 'Case Study Type' ),
									'help'          => __( 'This value will appear in the Case Study tile "阅读 ___ 案例研究"' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'Kubernetes',
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$sidebar    = array(
			'id'              => 'lf-sidebar-project',
			'id_prefix'       => 'lf_',
			'label'           => __( 'Project Settings' ),
			'post_type'       => 'lf_project',
			'data_key_prefix' => 'lf_project_',
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
									'data_key'      => 'category',
									'label'         => __( 'Category' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'Orchestration',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'external_url',
									'label'         => __( 'URL to Project Site' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://www.envoyproxy.io/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'github',
									'label'         => __( 'GitHub' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://github.com/coredns/coredns',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'devstats',
									'label'         => __( 'DevStats' ),
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => '',
									'placeholder'   => 'https://k8s.devstats.cncf.io/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'logos',
									'label'         => __( 'Logos' ),
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => '',
									'placeholder'   => 'https://github.com/cncf/artwork/blob/master/examples/graduated.md#coredns-logos',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'stack_overflow',
									'label'         => __( 'Stack Overflow' ),
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => '',
									'placeholder'   => 'https://stackoverflow.com/questions/tagged/coredns',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'twitter',
									'label'         => __( 'Twitter' ),
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => '',
									'placeholder'   => 'https://twitter.com/corednsio',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'blog',
									'label'         => __( 'Blog' ),
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => '',
									'placeholder'   => 'https://blog.coredns.io/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'mail',
									'label'         => __( 'Mail' ),
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => '',
									'placeholder'   => 'https://groups.google.com/forum/#!forum/coredns-discuss',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'slack',
									'label'         => __( 'Slack' ),
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => '',
									'placeholder'   => 'https://cloud-native.slack.com/messages/coredns/',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'youtube',
									'label'         => __( 'YouTube' ),
									'register_meta' => true,
									'ui_border_top' => false,
									'default_value' => '',
									'placeholder'   => 'https://www.youtube.com/channel/UCbWRJZxiaQ8twm6sh7UymoQ',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'gitter',
									'label'         => __( 'Gitter' ),
									'register_meta' => true,
									'ui_border_top' => false,
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

		$sidebar    = array(
			'id'              => 'lf-sidebar-spotlight',
			'id_prefix'       => 'lf_',
			'label'           => __( 'Spotlight Settings' ),
			'post_type'       => 'lf_spotlight',
			'data_key_prefix' => 'lf_spotlight_',
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
									'type'          => 'textarea',
									'data_type'     => 'meta',
									'data_key'      => 'subtitle',
									'label'         => __( 'Subtitle' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'The incubating project recently completed a security audit with Jepsen',
								),
							),
						),
					),
				),
			),
		);
		$sidebars[] = $sidebar;

		$sidebar    = array(
			'id'              => 'lf-sidebar-post',
			'id_prefix'       => 'lf_',
			'label'           => __( 'Post Settings' ),
			'post_type'       => 'post',
			'data_key_prefix' => 'lf_post_',
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
									'data_key'      => 'guest_author',
									'label'         => __( 'Guest Author' ),
									'help'          => __( 'Enter a guest author name to override WordPress default Posted By' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => '',
								),
								array(
									'type'          => 'text',
									'data_type'     => 'meta',
									'data_key'      => 'external_url',
									'label'         => __( 'External URL' ),
									'help'          => __( 'This url is used to link to news items on 3rd-party sites.' ),
									'register_meta' => true,
									'ui_border_top' => true,
									'default_value' => '',
									'placeholder'   => 'https://devclass.com/2020/05/14/harbor-2-container-image-registry/',
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
			'name'              => __( 'Country', 'lf-mu' ),
			'singular_name'     => __( 'Country', 'lf-mu' ),
			'search_items'      => __( 'Search Countries', 'lf-mu' ),
			'all_items'         => __( 'All Countries', 'lf-mu' ),
			'parent_item'       => __( 'Parent Continent', 'lf-mu' ),
			'parent_item_colon' => __( 'Parent Continent:', 'lf-mu' ),
			'edit_item'         => __( 'Edit Country', 'lf-mu' ),
			'update_item'       => __( 'Update Country', 'lf-mu' ),
			'add_new_item'      => __( 'Add New Country', 'lf-mu' ),
			'new_item_name'     => __( 'New Country Name', 'lf-mu' ),
			'menu_name'         => __( 'Countries', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-country', array( 'lf_event', 'lf_case_study', 'lf_speaker' ), $args );

		$labels = array(
			'name'              => __( 'Country', 'lf-mu' ),
			'singular_name'     => __( 'Country', 'lf-mu' ),
			'search_items'      => __( 'Search Countries', 'lf-mu' ),
			'all_items'         => __( 'All Countries', 'lf-mu' ),
			'parent_item'       => __( 'Parent Continent', 'lf-mu' ),
			'parent_item_colon' => __( 'Parent Continent:', 'lf-mu' ),
			'edit_item'         => __( 'Edit Country', 'lf-mu' ),
			'update_item'       => __( 'Update Country', 'lf-mu' ),
			'add_new_item'      => __( 'Add New Country', 'lf-mu' ),
			'new_item_name'     => __( 'New Country Name', 'lf-mu' ),
			'menu_name'         => __( 'Countries', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-country-ch', array( 'lf_case_study_ch' ), $args );

		$labels = array(
			'name'          => __( 'Product Type', 'lf-mu' ),
			'singular_name' => __( 'Product Type', 'lf-mu' ),
			'search_items'  => __( 'Search Product Types', 'lf-mu' ),
			'all_items'     => __( 'All Product Types', 'lf-mu' ),
			'edit_item'     => __( 'Edit Product Type', 'lf-mu' ),
			'update_item'   => __( 'Update Product Type', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Product Type', 'lf-mu' ),
			'new_item_name' => __( 'New Product Type Name', 'lf-mu' ),
			'menu_name'     => __( 'Product Types', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-product-type', array( 'lf_case_study' ), $args );

		$labels = array(
			'name'          => __( 'Product Type', 'lf-mu' ),
			'singular_name' => __( 'Product Type', 'lf-mu' ),
			'search_items'  => __( 'Search Product Types', 'lf-mu' ),
			'all_items'     => __( 'All Product Types', 'lf-mu' ),
			'edit_item'     => __( 'Edit Product Type', 'lf-mu' ),
			'update_item'   => __( 'Update Product Type', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Product Type', 'lf-mu' ),
			'new_item_name' => __( 'New Product Type Name', 'lf-mu' ),
			'menu_name'     => __( 'Product Types', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-product-type-ch', array( 'lf_case_study_ch' ), $args );

		$labels = array(
			'name'          => __( 'Cloud Type', 'lf-mu' ),
			'singular_name' => __( 'Cloud Type', 'lf-mu' ),
			'search_items'  => __( 'Search Cloud Types', 'lf-mu' ),
			'all_items'     => __( 'All Cloud Types', 'lf-mu' ),
			'edit_item'     => __( 'Edit Cloud Type', 'lf-mu' ),
			'update_item'   => __( 'Update Cloud Type', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Cloud Type', 'lf-mu' ),
			'new_item_name' => __( 'New Cloud Type Name', 'lf-mu' ),
			'menu_name'     => __( 'Cloud Types', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-cloud-type', array( 'lf_case_study' ), $args );

		$labels = array(
			'name'          => __( 'Cloud Type', 'lf-mu' ),
			'singular_name' => __( 'Cloud Type', 'lf-mu' ),
			'search_items'  => __( 'Search Cloud Types', 'lf-mu' ),
			'all_items'     => __( 'All Cloud Types', 'lf-mu' ),
			'edit_item'     => __( 'Edit Cloud Type', 'lf-mu' ),
			'update_item'   => __( 'Update Cloud Type', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Cloud Type', 'lf-mu' ),
			'new_item_name' => __( 'New Cloud Type Name', 'lf-mu' ),
			'menu_name'     => __( 'Cloud Types', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-cloud-type-ch', array( 'lf_case_study_ch' ), $args );

		$labels = array(
			'name'          => __( 'Projects', 'lf-mu' ),
			'singular_name' => __( 'Project', 'lf-mu' ),
			'search_items'  => __( 'Search Projects', 'lf-mu' ),
			'all_items'     => __( 'All Projects', 'lf-mu' ),
			'edit_item'     => __( 'Edit Project', 'lf-mu' ),
			'update_item'   => __( 'Update Project', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Project', 'lf-mu' ),
			'new_item_name' => __( 'New Project Name', 'lf-mu' ),
			'menu_name'     => __( 'Projects', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-project', array( 'lf_webinar', 'lf_case_study', 'lf_case_study_ch', 'lf_speaker', 'lf_spotlight' ), $args );

		$labels = array(
			'name'          => __( 'Author Category', 'lf-mu' ),
			'singular_name' => __( 'Author Category', 'lf-mu' ),
			'search_items'  => __( 'Search Author Categories', 'lf-mu' ),
			'all_items'     => __( 'All Author Categories', 'lf-mu' ),
			'edit_item'     => __( 'Edit Author Category', 'lf-mu' ),
			'update_item'   => __( 'Update Author Category', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Author Category', 'lf-mu' ),
			'new_item_name' => __( 'New Author Category Name', 'lf-mu' ),
			'menu_name'     => __( 'Author Categories', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-author-category', array( 'lf_webinar', 'post' ), $args );

		$labels = array(
			'name'          => __( 'Company', 'lf-mu' ),
			'singular_name' => __( 'Company', 'lf-mu' ),
			'search_items'  => __( 'Search Companies', 'lf-mu' ),
			'all_items'     => __( 'All Companies', 'lf-mu' ),
			'edit_item'     => __( 'Edit Company', 'lf-mu' ),
			'update_item'   => __( 'Update Company', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Company', 'lf-mu' ),
			'new_item_name' => __( 'New Company Name', 'lf-mu' ),
			'menu_name'     => __( 'Companies', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-company', array( 'lf_webinar' ), $args );

		$labels = array(
			'name'          => __( 'Topics', 'lf-mu' ),
			'singular_name' => __( 'Topic', 'lf-mu' ),
			'search_items'  => __( 'Search Topics', 'lf-mu' ),
			'all_items'     => __( 'All Topics', 'lf-mu' ),
			'edit_item'     => __( 'Edit Topic', 'lf-mu' ),
			'update_item'   => __( 'Update Topic', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Topic', 'lf-mu' ),
			'new_item_name' => __( 'New Topic Name', 'lf-mu' ),
			'menu_name'     => __( 'Topics', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-topic', array( 'lf_webinar' ), $args );

		$labels = array(
			'name'          => __( 'Category', 'lf-mu' ),
			'singular_name' => __( 'Category', 'lf-mu' ),
			'search_items'  => __( 'Search Categories', 'lf-mu' ),
			'all_items'     => __( 'All Categories', 'lf-mu' ),
			'edit_item'     => __( 'Edit Category', 'lf-mu' ),
			'update_item'   => __( 'Update Category', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Category', 'lf-mu' ),
			'new_item_name' => __( 'New Category Name', 'lf-mu' ),
			'menu_name'     => __( 'People Categories', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-person-category', array( 'lf_person' ), $args );

		$labels = array(
			'name'          => __( 'Challenges', 'lf-mu' ),
			'singular_name' => __( 'Challenge', 'lf-mu' ),
			'search_items'  => __( 'Search Challenges', 'lf-mu' ),
			'all_items'     => __( 'All Challenges', 'lf-mu' ),
			'edit_item'     => __( 'Edit Challenge', 'lf-mu' ),
			'update_item'   => __( 'Update Challenge', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Challenge', 'lf-mu' ),
			'new_item_name' => __( 'New Challenge Name', 'lf-mu' ),
			'menu_name'     => __( 'Challenges', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-challenge', array( 'lf_case_study' ), $args );

		$labels = array(
			'name'          => __( 'Challenges', 'lf-mu' ),
			'singular_name' => __( 'Challenge', 'lf-mu' ),
			'search_items'  => __( 'Search Challenges', 'lf-mu' ),
			'all_items'     => __( 'All Challenges', 'lf-mu' ),
			'edit_item'     => __( 'Edit Challenge', 'lf-mu' ),
			'update_item'   => __( 'Update Challenge', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Challenge', 'lf-mu' ),
			'new_item_name' => __( 'New Challenge Name', 'lf-mu' ),
			'menu_name'     => __( 'Challenges', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-challenge-ch', array( 'lf_case_study_ch' ), $args );

		$labels = array(
			'name'          => __( 'Industries', 'lf-mu' ),
			'singular_name' => __( 'Industry', 'lf-mu' ),
			'search_items'  => __( 'Search Industries', 'lf-mu' ),
			'all_items'     => __( 'All Industries', 'lf-mu' ),
			'edit_item'     => __( 'Edit Industry', 'lf-mu' ),
			'update_item'   => __( 'Update Industry', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Industry', 'lf-mu' ),
			'new_item_name' => __( 'New Industry Name', 'lf-mu' ),
			'menu_name'     => __( 'Industries', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-industry', array( 'lf_case_study' ), $args );

		$labels = array(
			'name'          => __( 'Industries', 'lf-mu' ),
			'singular_name' => __( 'Industry', 'lf-mu' ),
			'search_items'  => __( 'Search Industries', 'lf-mu' ),
			'all_items'     => __( 'All Industries', 'lf-mu' ),
			'edit_item'     => __( 'Edit Industry', 'lf-mu' ),
			'update_item'   => __( 'Update Industry', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Industry', 'lf-mu' ),
			'new_item_name' => __( 'New Industry Name', 'lf-mu' ),
			'menu_name'     => __( 'Industries', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-industry-ch', array( 'lf_case_study_ch' ), $args );

		/**
		 * Project Stage Taxonomy for Projects.
		 */
		$labels = array(
			'name'          => __( 'Project Stage', 'lf-mu' ),
			'singular_name' => __( 'Project Stage', 'lf-mu' ),
			'search_items'  => __( 'Search Project Stages', 'lf-mu' ),
			'all_items'     => __( 'All Project Stages', 'lf-mu' ),
			'edit_item'     => __( 'Edit Project Stage', 'lf-mu' ),
			'update_item'   => __( 'Update Project Stage', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Project Stage', 'lf-mu' ),
			'new_item_name' => __( 'New Project Stage', 'lf-mu' ),
			'menu_name'     => __( 'Project Stages', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
		);
		register_taxonomy( 'lf-project-stage', array( 'lf_project' ), $args );

		$labels = array(
			'name'          => __( 'Host', 'lf-mu' ),
			'singular_name' => __( 'Host', 'lf-mu' ),
			'search_items'  => __( 'Search Hosts', 'lf-mu' ),
			'all_items'     => __( 'All Hosts', 'lf-mu' ),
			'edit_item'     => __( 'Edit Host', 'lf-mu' ),
			'update_item'   => __( 'Update Host', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Host', 'lf-mu' ),
			'new_item_name' => __( 'New Host', 'lf-mu' ),
			'menu_name'     => __( 'Hosts', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-event-host', array( 'lf_event' ), $args );

		$labels = array(
			'name'          => __( 'Language', 'lf-mu' ),
			'singular_name' => __( 'Language', 'lf-mu' ),
			'search_items'  => __( 'Search Languages', 'lf-mu' ),
			'all_items'     => __( 'All Languages', 'lf-mu' ),
			'edit_item'     => __( 'Edit Language', 'lf-mu' ),
			'update_item'   => __( 'Update Language', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Language', 'lf-mu' ),
			'new_item_name' => __( 'New Language', 'lf-mu' ),
			'menu_name'     => __( 'Languages', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-language', array( 'lf_webinar', 'lf_speaker' ), $args );

		$args = array(
			'labels'            => array( 'name' => __( 'Affiliations', 'lf-mu' ) ),
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-speaker-affiliation', array( 'lf_speaker' ), $args );
		$args = array(
			'labels'            => array( 'name' => __( 'Expertise', 'lf-mu' ) ),
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-speaker-expertise', array( 'lf_speaker' ), $args );

		$labels = array(
			'name'          => __( 'Spotlight Type', 'lf-mu' ),
			'singular_name' => __( 'Spotlight Type', 'lf-mu' ),
			'search_items'  => __( 'Search Spotlight Types', 'lf-mu' ),
			'all_items'     => __( 'All Spotlight Types', 'lf-mu' ),
			'edit_item'     => __( 'Edit Type', 'lf-mu' ),
			'update_item'   => __( 'Update Type', 'lf-mu' ),
			'add_new_item'  => __( 'Add New Spotlight Type', 'lf-mu' ),
			'new_item_name' => __( 'New Type Name', 'lf-mu' ),
			'menu_name'     => __( 'Spotlight Types', 'lf-mu' ),
		);
		$args   = array(
			'labels'            => $labels,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
		);
		register_taxonomy( 'lf-spotlight-type', array( 'lf_spotlight' ), $args );
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

		$options['hello_bar_text'] = ( isset( $input['hello_bar_text'] ) && ! empty( $input['hello_bar_text'] ) ) ? esc_attr( $input['hello_bar_text'] ) : '';

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

		$options['social_twitter_handle'] = ( isset( $input['social_twitter_handle'] ) && ! empty( $input['social_twitter_handle'] ) ) ? esc_html( $input['social_twitter_handle'] ) : '';

		$options['social_youtube'] = ( isset( $input['social_youtube'] ) && ! empty( $input['social_youtube'] ) ) ? esc_url( $input['social_youtube'] ) : '';

		$options['social_wechat_id'] = ( isset( $input['social_wechat_id'] ) && ! empty( $input['social_wechat_id'] ) ) ? absint( $input['social_wechat_id'] ) : '';

		$options['generic_thumb_id'] = ( isset( $input['generic_thumb_id'] ) && ! empty( $input['generic_thumb_id'] ) ) ? absint( $input['generic_thumb_id'] ) : '';

		$options['generic_avatar_id'] = ( isset( $input['generic_avatar_id'] ) && ! empty( $input['generic_avatar_id'] ) ) ? absint( $input['generic_avatar_id'] ) : '';

		$options['generic_hero_id'] = ( isset( $input['generic_hero_id'] ) && ! empty( $input['generic_hero_id'] ) ) ? absint( $input['generic_hero_id'] ) : '';

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
	 * Sync User of role "Speaker" to the lf_speaker CPT.
	 *
	 * @param int $user_id ID of user.
	 */
	private function sync_speaker( $user_id ) {
		global $post;

		if ( ! $user_id ) {
			return;
		}

		$um_member_directory_data = get_user_meta( $user_id, 'um_member_directory_data', false )[0];
		$um_hide_in_members       = get_user_meta( $user_id, 'hide_in_members', true );
		$photo                    = get_user_meta( $user_id, 'profile_photo', true );
		$first_name               = get_user_meta( $user_id, 'first_name', true );
		$last_name                = get_user_meta( $user_id, 'last_name', true );
		if ( 'approved' !== $um_member_directory_data['account_status'] || ! $photo || $um_hide_in_members ) {
			// speaker must be approved, have a photo, and not have hidden their profile.
			$eligible_for_search = false;
		} else {
			$eligible_for_search = true;
		}

		$query = new WP_Query(
			array(
				'name'      => $user_id,
				'post_type' => 'lf_speaker',
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
					'post_title'  => $last_name . $first_name,
					'post_name'   => $user_id,
					'post_type'   => 'lf_speaker',
					'post_status' => 'publish',
				)
			);
		}

		$affiliations = get_user_meta( $user_id, 'sb_certifications', false )[0];
		$expertise    = get_user_meta( $user_id, 'expertise', false )[0];
		$languages    = get_user_meta( $user_id, 'languages', false )[0];
		$projects     = get_user_meta( $user_id, 'project', false )[0];
		$country      = get_user_meta( $user_id, 'country', false )[0];

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

		wp_set_object_terms( $speaker_id, $affiliations, 'lf-speaker-affiliation' );
		wp_set_object_terms( $speaker_id, $expertise, 'lf-speaker-expertise' );
		wp_set_object_terms( $speaker_id, $languages, 'lf-language' );
		wp_set_object_terms( $speaker_id, $projects, 'lf-project' );
		wp_set_object_terms( $speaker_id, $country, 'lf-country' );

		wp_reset_postdata();
	}

	/**
	 * Syncs all the lf_speaker data with the Users of role "Speaker" metadata.
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
				'post_type'   => 'lf_speaker',
				'numberposts' => -1,
			),
		);
		foreach ( $allposts as $eachpost ) {
			wp_delete_post( $eachpost->ID, true );
		}

		$args          = array( 'role' => 'um_speaker' );
		$wp_user_query = new WP_User_Query( $args );
		$users         = $wp_user_query->get_results();
		foreach ( $users as $user ) {
			$this->sync_speaker( $user->ID );
		}
	}

	/**
	 * Function is triggered by any action that updates a lf_speaker
	 *
	 * @param int   $user_id User ID.
	 * @param array $args Args.
	 * @param array $userinfo User Info.
	 */
	public function speaker_updated( $user_id, $args = null, $userinfo = null ) {
		$user       = get_userdata( $user_id );
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
				'name'      => $user_id,
				'post_type' => 'lf_speaker',
			)
		);

		if ( $query->have_posts() ) {
			$query->the_post();
			wp_delete_post( $post->ID, true );
		}
	}
}

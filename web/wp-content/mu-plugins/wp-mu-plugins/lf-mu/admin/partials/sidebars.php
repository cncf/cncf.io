<?php
/**
 * Sidebar definitions
 *
 * @link       https://www.cncf.io/
 * @since      1.1.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/admin/partials
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

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

$tzlist = DateTimeZone::listIdentifiers( DateTimeZone::ALL );
$tzs    = array();
foreach ( $tzlist as $tz ) {
	$slug         = str_replace( '/', '-', $tz );
	$tzs[ $slug ] = $tz;
}

$sidebar    = array(
	'id'              => 'lf-sidebar-webinar',
	'id_prefix'       => 'lf_',
	'label'           => ucwords( $this->webinar ) . ' Settings',
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
							'format'            => 'YYYY-MM-DD',
						),
						array(
							'type'          => 'select',
							'data_type'     => 'meta',
							'data_key'      => 'start_time',
							'label'         => __( 'Start Time' ),
							'register_meta' => true,
							'ui_border_top' => true,
							'default_value' => '10:00',
							'options'       => array(
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
							'options'       => array(
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
							'options'       => array(
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
							'options'       => array(
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
							'default_value' => 'america-los_angeles',
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
							'help'          => 'Leave blank if there is no recording',
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
							'placeholder'   => 'Oliver Gould',
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'guest_author_image',
							'label'         => __( 'Guest Author Image' ),
							'help'          => __( 'Image should be at least 200x200px with face centered.' ),
							'ui_border_top' => false,
							'register_meta' => true,
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
							'format'            => 'YYYY-MM-DD',
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
							'format'            => 'YYYY-MM-DD',
							'help'              => __( 'Required. For single day events, enter the same date.' ),
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
							'default_value' => '#254AAB',
							'alpha_control' => true,
							'palette'       => $palette,
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'desktop_banner',
							'label'         => __( 'Desktop Ad Image' ),
							'help'          => __( 'An image used for the homepage banner ad. Recommended size 2400 x 840px.' ),
							'register_meta' => true,
							'ui_border_top' => true,
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'mobile_banner',
							'label'         => __( 'Mobile Ad Image' ),
							'help'          => __( 'An image used for the homepage banner ad. Recommended size 900 x 1100px.' ),
							'register_meta' => true,
							'ui_border_top' => true,
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
							'data_key'      => 'long_title',
							'label'         => __( 'Long Title' ),
							'register_meta' => true,
							'ui_border_top' => true,
							'default_value' => '',
						),
						array(
							'type'          => 'text',
							'data_type'     => 'meta',
							'data_key'      => 'key_stat',
							'label'         => __( 'Key Statistic' ),
							'register_meta' => true,
							'ui_border_top' => true,
							'default_value' => '',
							'placeholder'   => '2000',
						),
						array(
							'type'          => 'text',
							'data_type'     => 'meta',
							'data_key'      => 'key_stat_label',
							'label'         => __( 'Key Statistic Label' ),
							'register_meta' => true,
							'ui_border_top' => false,
							'default_value' => '',
							'placeholder'   => 'Deployments weekly',
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'company_logo',
							'id'            => 'company_logo',
							'label'         => __( 'Company Logo' ),
							'ui_border_top' => true,
							'register_meta' => true,
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'homepage_company_logo',
							'id'            => 'homepage_company_logo',
							'label'         => __( 'Homepage Company Logo' ),
							'help'          => __( 'Set this image if you want a special logo used when the case study is featured on the homepage.' ),
							'ui_border_top' => false,
							'register_meta' => true,
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'homepage_image',
							'id'            => 'homepage_image',
							'label'         => __( 'Homepage Background Image' ),
							'help'          => __( 'Set this image if you want a special background image for when the case study is featured on the homepage.' ),
							'ui_border_top' => true,
							'register_meta' => true,
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
	'post_type'       => 'lf_case_study_cn',
	'data_key_prefix' => 'lf_case_study_cn_',
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
							'data_key'      => 'long_title',
							'label'         => __( 'Long Title' ),
							'register_meta' => true,
							'ui_border_top' => true,
							'default_value' => '',
						),
						array(
							'type'          => 'text',
							'data_type'     => 'meta',
							'data_key'      => 'key_stat',
							'label'         => __( 'Key Statistic' ),
							'register_meta' => true,
							'ui_border_top' => true,
							'default_value' => '',
							'placeholder'   => '2000',
						),
						array(
							'type'          => 'text',
							'data_type'     => 'meta',
							'data_key'      => 'key_stat_label',
							'label'         => __( 'Key Statistic Label' ),
							'register_meta' => true,
							'ui_border_top' => false,
							'default_value' => '',
							'placeholder'   => 'Deployments weekly',
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'company_logo',
							'id'            => 'company_logo',
							'label'         => __( 'Company Logo' ),
							'ui_border_top' => true,
							'register_meta' => true,
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'homepage_company_logo',
							'id'            => 'homepage_company_logo',
							'label'         => __( 'Homepage Company Logo' ),
							'help'          => __( 'Set this image if you want a special logo used when the case study is featured on the homepage.' ),
							'ui_border_top' => false,
							'register_meta' => true,
						),
						array(
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'homepage_image',
							'id'            => 'homepage_image',
							'label'         => __( 'Homepage Background Image' ),
							'help'          => __( 'Set this image if you want a special background image for when the case study is featured on the homepage.' ),
							'ui_border_top' => true,
							'register_meta' => true,
						),
					),
				),
			),
		),
	),
);
$sidebars[] = $sidebar;

$sidebar    = array(
	'id'              => 'lf-sidebar-kubeweekly',
	'id_prefix'       => 'lf_',
	'label'           => __( 'Kubeweekly Settings' ),
	'post_type'       => 'lf_kubeweekly',
	'data_key_prefix' => 'lf_kubeweekly_',
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
							'data_key'      => 'external_url',
							'label'         => __( 'External URL' ),
							'help'          => __( 'This url is used to link to the web version of the email.' ),
							'register_meta' => true,
							'ui_border_top' => true,
							'default_value' => '',
							'placeholder'   => 'https://email.linuxfoundation.org/linux-foundation-events-snapshot-march-2021',
						),
					),
				),
			),
		),
	),
);
$sidebars[] = $sidebar;

$sidebar    = array(
	'id'              => 'lf-sidebar-eu-newsletter',
	'id_prefix'       => 'lf_',
	'label'           => __( 'EU Newsletter Settings' ),
	'post_type'       => 'lf_eu_newsletter',
	'data_key_prefix' => 'lf_eu_newsletter_',
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
							'data_key'      => 'external_url',
							'label'         => __( 'External URL' ),
							'help'          => __( 'This url is used to link to the web version of the email.' ),
							'register_meta' => true,
							'ui_border_top' => true,
							'default_value' => '',
							'placeholder'   => 'https://email.linuxfoundation.org/linux-foundation-events-snapshot-march-2021',
						),
					),
				),
			),
		),
	),
);
$sidebars[] = $sidebar;

$sidebar    = array(
	'id'              => 'lf-sidebar-report',
	'id_prefix'       => 'lf_',
	'label'           => __( 'Report Settings' ),
	'post_type'       => 'lf_report',
	'data_key_prefix' => 'lf_report_',
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
							'data_key'      => 'pdf_url',
							'label'         => __( 'PDF URL' ),
							'help'          => __( 'When this is set the report page will use the standard template.' ),
							'register_meta' => true,
							'ui_border_top' => true,
							'default_value' => '',
							'placeholder'   => 'https://www.cncf.io/wp-content/uploads/2021/11/KubeCon_NA_21_Report.pdf',
						),
					),
				),
			),
		),
	),
);
$sidebars[] = $sidebar;

$sidebar    = array(
	'id'              => 'lf-sidebar-human',
	'id_prefix'       => 'lf_',
	'label'           => __( 'Post Settings' ),
	'post_type'       => 'lf_human',
	'data_key_prefix' => 'lf_human_',
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
							'type'          => 'image',
							'data_type'     => 'meta',
							'data_key'      => 'image',
							'label'         => __( 'Headshot' ),
							'help'          => __( 'Image should be at least 800x800px with face centered.' ),
							'ui_border_top' => false,
							'register_meta' => true,
						),
					),
				),
			),
		),
	),
);
$sidebars[] = $sidebar;

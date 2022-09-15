<?php
/**
 * CPT definitions
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

// Projects.
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
	'show_ui'             => true,
	'hierarchical'        => false,
	'rewrite'             => array( 'slug' => 'projects' ),
	'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
);
register_post_type( 'lf_project', $opts );

// Case Study Block Template setup.
$case_study_block_template = array(
	array( 'lf/hero' ),
	array( 'lf/case-study-overview' ),
	array( 'lf/case-study-highlights' ),
	array(
		'core/heading',
		array(
			'level'       => 3,
			'placeholder' => 'Introductory paragraph to the case study',
			'className'   => 'is-style-max-width-800',
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
			'placeholder' => 'Nice quote from customer lorem ipsum dolor sit amet consectetuer adipiscing elit aenean commodo',
			'className'   => 'is-style-case-study-quote',
		),
	),
);

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
	'template'          => $case_study_block_template,
	'menu_icon'         => 'dashicons-awards',
	'rewrite'           => array( 'slug' => 'case-studies-cn' ),
	'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
);
register_post_type( 'lf_case_study_cn', $opts );

$opts = array(
	'labels'            => array(
		'name'          => __( 'Events' ),
		'singular_name' => __( 'Event' ),
		'all_items'     => __( 'All Events' ),
	),
	'public'            => false,
	'has_archive'       => false,
	'show_ui'           => true,
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
		'name'          => __( 'KubeWeeklys' ),
		'singular_name' => __( 'KubeWeekly' ),
		'all_items'     => __( 'All KubeWeeklys' ),
	),
	'public'              => true,
	'has_archive'         => false,
	'show_in_nav_menus'   => false,
	'show_in_rest'        => true,
	'hierarchical'        => false,
	'exclude_from_search' => true,
	'menu_icon'           => 'dashicons-email-alt',
	'rewrite'             => array( 'slug' => 'kubeweekly' ),
	'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
);
register_post_type( 'lf_kubeweekly', $opts );

$opts = array(
	'labels'              => array(
		'name'          => __( 'People' ),
		'singular_name' => __( 'Person' ),
		'all_items'     => __( 'All People' ),
	),
	'public'              => false,
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
		'name'          => ucwords( $this->webinar ) . 's',
		'singular_name' => ucwords( $this->webinar ),
		'all_items'     => 'All ' . ucwords( $this->webinar ) . 's',
	),
	'public'            => true,
	'has_archive'       => false,
	'show_in_nav_menus' => false,
	'show_in_rest'      => true,
	'hierarchical'      => false,
	'menu_icon'         => 'dashicons-video-alt3',
	'rewrite'           => array( 'slug' => str_replace( ' ', '-', $this->webinar ) . 's' ),
	'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
);
register_post_type( 'lf_webinar', $opts );

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

$opts = array(
	'labels'            => array(
		'name'          => __( 'Humans' ),
		'singular_name' => __( 'Human' ),
		'all_items'     => __( 'All Humans' ),
	),
	'public'            => true,
	'has_archive'       => false,
	'show_in_nav_menus' => false,
	'show_in_rest'      => true,
	'hierarchical'      => false,
	'menu_icon'         => 'dashicons-universal-access-alt',
	'rewrite'           => array( 'slug' => 'humans-of-cloud-native' ),
	'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
);
register_post_type( 'lf_human', $opts );

$opts = array(
	'labels'              => array(
		'name'          => __( 'KTPs' ),
		'singular_name' => __( 'KTP' ),
		'all_items'     => __( 'All KTPs' ),
	),
	'public'              => false,
	'has_archive'         => false,
	'show_in_nav_menus'   => false,
	'show_in_rest'        => true,
	'show_ui'             => false,
	'hierarchical'        => false,
	'rewrite'             => array( 'slug' => 'ktps' ),
	'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
);
register_post_type( 'lf_ktp', $opts );

$opts = array(
	'labels'            => array(
		'name'          => __( 'Reports' ),
		'singular_name' => __( 'Report' ),
		'all_items'     => __( 'All Reports' ),
	),
	'public'            => true,
	'has_archive'       => false,
	'show_in_nav_menus' => false,
	'show_in_rest'      => true,
	'hierarchical'      => false,
	'menu_icon'         => 'dashicons-text',
	'rewrite'           => array( 'slug' => 'reports' ),
	'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
);
register_post_type( 'lf_report', $opts );

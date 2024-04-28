<?php
/**
 * Taxonomy definitions
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
register_taxonomy( 'lf-language', array( 'lf_webinar', 'lf_person', 'lf_video' ), $args );

$labels = array(
	'name'          => __( 'Expertise', 'lf-mu' ),
	'singular_name' => __( 'Expertise', 'lf-mu' ),
	'search_items'  => __( 'Search Expertise', 'lf-mu' ),
	'all_items'     => __( 'All Expertise', 'lf-mu' ),
	'edit_item'     => __( 'Edit Expertise', 'lf-mu' ),
	'update_item'   => __( 'Update Expertise', 'lf-mu' ),
	'add_new_item'  => __( 'Add New Expertise', 'lf-mu' ),
	'new_item_name' => __( 'New Expertise', 'lf-mu' ),
	'menu_name'     => __( 'Expertise', 'lf-mu' ),
);
$args   = array(
	'labels'            => $labels,
	'show_in_rest'      => true,
	'hierarchical'      => false,
	'show_in_nav_menus' => false,
	'show_admin_column' => true,
);
register_taxonomy( 'lf-expertise', array( 'lf_person' ), $args );

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
register_taxonomy( 'lf-project', array( 'lf_course', 'lf_webinar', 'lf_case_study', 'lf_case_study_cn', 'lf_person', 'lf_human', 'lf_video' ), $args );

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
);
register_taxonomy( 'lf-author-category', array( 'post' ), $args );

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
register_taxonomy( 'lf-topic', array( 'lf_webinar', 'lf_video' ), $args );

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
register_taxonomy( 'lf-country', array( 'lf_event', 'lf_case_study', 'lf_ktp', 'lf_person', 'lf_human' ), $args );

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
register_taxonomy( 'lf-country-cn', array( 'lf_case_study_cn' ), $args );

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
register_taxonomy( 'lf-product-type-cn', array( 'lf_case_study_cn' ), $args );

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
register_taxonomy( 'lf-cloud-type-cn', array( 'lf_case_study_cn' ), $args );

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
register_taxonomy( 'lf-challenge-cn', array( 'lf_case_study_cn' ), $args );

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
register_taxonomy( 'lf-industry-cn', array( 'lf_case_study_cn' ), $args );

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
	'name'          => __( 'Certification', 'lf-mu' ),
	'singular_name' => __( 'Certification', 'lf-mu' ),
	'search_items'  => __( 'Search Certifications', 'lf-mu' ),
	'all_items'     => __( 'All Certifications', 'lf-mu' ),
	'edit_item'     => __( 'Edit Certification', 'lf-mu' ),
	'update_item'   => __( 'Update Certification', 'lf-mu' ),
	'add_new_item'  => __( 'Add New Certification', 'lf-mu' ),
	'new_item_name' => __( 'New Certification Name', 'lf-mu' ),
	'menu_name'     => __( 'Certifications', 'lf-mu' ),
);
$args   = array(
	'labels'            => $labels,
	'show_in_rest'      => true,
	'hierarchical'      => false,
	'show_in_nav_menus' => false,
	'show_admin_column' => true,
);
register_taxonomy( 'lf-certification', array( 'lf_ktp' ), $args );

$labels = array(
	'name'          => __( 'Training Type', 'lf-mu' ),
	'singular_name' => __( 'Training Type', 'lf-mu' ),
	'search_items'  => __( 'Search Training Types', 'lf-mu' ),
	'all_items'     => __( 'All Training Types', 'lf-mu' ),
	'edit_item'     => __( 'Edit Training Type', 'lf-mu' ),
	'update_item'   => __( 'Update Training Type', 'lf-mu' ),
	'add_new_item'  => __( 'Add New Training Type', 'lf-mu' ),
	'new_item_name' => __( 'New Training Type Name', 'lf-mu' ),
	'menu_name'     => __( 'Training Types', 'lf-mu' ),
);
$args   = array(
	'labels'            => $labels,
	'show_in_rest'      => true,
	'hierarchical'      => false,
	'show_in_nav_menus' => false,
	'show_admin_column' => true,
);
register_taxonomy( 'lf-training-type', array( 'lf_ktp' ), $args );

$labels = array(
	'name'          => __( 'Report Type', 'lf-mu' ),
	'singular_name' => __( 'Report Type', 'lf-mu' ),
	'search_items'  => __( 'Search Report Types', 'lf-mu' ),
	'all_items'     => __( 'All Report Types', 'lf-mu' ),
	'edit_item'     => __( 'Edit Report Type', 'lf-mu' ),
	'update_item'   => __( 'Update Report Type', 'lf-mu' ),
	'add_new_item'  => __( 'Add New Report Type', 'lf-mu' ),
	'new_item_name' => __( 'New Report Type Name', 'lf-mu' ),
	'menu_name'     => __( 'Report Types', 'lf-mu' ),
);
$args   = array(
	'labels'            => $labels,
	'show_in_rest'      => true,
	'hierarchical'      => false,
	'show_in_nav_menus' => false,
	'show_admin_column' => true,
);
register_taxonomy( 'lf-report-type', array( 'lf_report' ), $args );

$labels = array(
	'name'          => __( 'Course Difficulty', 'lf-mu' ),
	'singular_name' => __( 'Course Difficulty', 'lf-mu' ),
	'search_items'  => __( 'Search Course Difficulties', 'lf-mu' ),
	'all_items'     => __( 'All Course Difficulties', 'lf-mu' ),
	'edit_item'     => __( 'Edit Course Difficulty', 'lf-mu' ),
	'update_item'   => __( 'Update Course Difficulty', 'lf-mu' ),
	'add_new_item'  => __( 'Add New Course Difficulty', 'lf-mu' ),
	'new_item_name' => __( 'New Course Difficulty Name', 'lf-mu' ),
	'menu_name'     => __( 'Course Difficulties', 'lf-mu' ),
);
$args   = array(
	'labels'            => $labels,
	'show_in_rest'      => true,
	'hierarchical'      => false,
	'show_in_nav_menus' => false,
);
register_taxonomy( 'lf-course-difficulty', array( 'lf_course' ), $args );

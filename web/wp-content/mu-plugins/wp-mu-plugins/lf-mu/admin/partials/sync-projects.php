<?php
/**
 * Sync Projects from Landscape
 *
 * @link       https://www.cncf.io/
 * @since      1.2.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/admin/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$projects_url = 'http://landscape.cncf.io/api/projects/all.json';

$args = array(
	'timeout'   => 100,
	'sslverify' => false,
);

$data = wp_remote_get( $projects_url, $args );
if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
	return;
}

$projects = json_decode( wp_remote_retrieve_body( $data ) );

foreach ( $projects as $p ) {

	// skip projects in the Wasm or Serverless sub-landscapes.
	if ( 'Wasm' == $p->category || 'Serverless' == $p->category ) {
		continue;
	}

	$params = array(
		'post_type'   => 'lf_project',
		'post_title'  => $p->name,
		'post_status' => 'publish',
		'meta_input'  => array(
			'lf_project_external_url' => $p->homepage_url,
			'lf_project_twitter'      => $p->twitter_url ?? '',
			'lf_project_logo'         => $p->logo_url ?? '',
			'lf_project_category'     => $p->subcategory ?? '',
		),
	);

	if ( property_exists( $p, 'url' ) ) {
		$params['meta_input']['lf_project_github'] = $p->url;
	}
	if ( property_exists( $p, 'description' ) ) {
		$params['meta_input']['lf_project_description'] = $p->description;
	}
	if ( property_exists( $p, 'devstats_url' ) ) {
		$params['meta_input']['lf_project_devstats'] = $p->devstats_url;
	}
	if ( property_exists( $p, 'artwork_url' ) ) {
		$params['meta_input']['lf_project_logos'] = $p->artwork_url;
	}
	if ( property_exists( $p, 'stack_overflow_url' ) ) {
		$params['meta_input']['lf_project_stack_overflow'] = $p->stack_overflow_url;
	}
	if ( property_exists( $p, 'accepted_at' ) ) {
		$params['meta_input']['lf_project_date_accepted'] = $p->accepted_at;
	}
	if ( property_exists( $p, 'incubating_at' ) ) {
		$params['meta_input']['lf_project_date_incubating'] = $p->incubating_at;
	}
	if ( property_exists( $p, 'graduated_at' ) ) {
		$params['meta_input']['lf_project_date_graduated'] = $p->graduated_at;
	}
	if ( property_exists( $p, 'archived_at' ) ) {
		$params['meta_input']['lf_project_date_archived'] = $p->archived_at;
	}
	if ( property_exists( $p, 'blog_url' ) ) {
		$params['meta_input']['lf_project_blog'] = $p->blog_url;
	}
	if ( property_exists( $p, 'mailing_list_url' ) ) {
		$params['meta_input']['lf_project_mail'] = $p->mailing_list_url;
	}
	if ( property_exists( $p, 'slack_url' ) ) {
		$params['meta_input']['lf_project_slack'] = $p->slack_url;
	}
	if ( property_exists( $p, 'youtube_url' ) ) {
		$params['meta_input']['lf_project_youtube'] = $p->youtube_url;
	}
	if ( property_exists( $p, 'gitter_url' ) ) {
		$params['meta_input']['lf_project_gitter'] = $p->gitter_url;
	}

	$pp = get_posts(
		array(
			'post_type'              => 'lf_project',
			'title'                  => $p->name,
			'post_status'            => 'all',
			'numberposts'            => 1,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'orderby'                => 'post_date ID',
			'order'                  => 'ASC',
		)
	);
	if ( ! empty( $pp ) ) {
		$params['ID'] = $pp[0]->ID;
	}

	// adds term to taxonomy if it doesn't exist.
	if ( ! term_exists( $p->name, 'lf-project' ) ) {
		wp_insert_term( $p->name, 'lf-project' );
	}

	$newid = wp_insert_post( $params ); // will insert or update the post as needed.

	if ( $newid ) {
		wp_set_object_terms( $newid, $p->maturity, 'lf-project-stage', false );
	}
}

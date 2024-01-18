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

$projects_url = 'https://landscape.netlify.app/api/items?project=hosted';
$items_url    = 'https://landscape.netlify.app/data/items.json';
$logos_url    = 'https://landscape.netlify.app/';

$args = array(
	'timeout'   => 100,
	'sslverify' => false,
);

$data = wp_remote_get( $projects_url, $args );
if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
	return;
}
$projects = json_decode( wp_remote_retrieve_body( $data ) );

$data = wp_remote_get( $items_url, $args );
if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
	return;
}
$items     = json_decode( wp_remote_retrieve_body( $data ) );
$id_column = array_column( $items, 'id' );

foreach ( $projects as $level ) {
	foreach ( $level->items as $project ) {
		$key = array_search( $project->id, $id_column );
		if ( false === $key ) {
			continue;
		}

		$p = $items[ $key ];

		// skip projects in the Wasm or Serverless sub-landscapes.
		$base_category = explode( ' / ', $p->path )[0];
		if ( 'Wasm' == $base_category || 'Serverless' == $base_category ) {
			continue;
		}

		$params = array(
			'post_type'   => 'lf_project',
			'post_title'  => $p->name,
			'post_status' => 'publish',
			'meta_input'  => array(
				'lf_project_external_url' => $p->homepage_url,
				'lf_project_twitter'      => $p->twitter ?? '',
				'lf_project_logo'         => $logos_url . $p->href,
				'lf_project_category'     => explode( ' / ', $p->path )[1],
			),
		);

		if ( property_exists( $p, 'repo_url' ) ) {
			$params['meta_input']['lf_project_github'] = $p->repo_url;
		}

		if ( property_exists( $p, 'description' ) ) {
			$params['meta_input']['lf_project_description'] = $p->description;
		}

		if ( property_exists( $p, 'extra' ) ) {
			if ( property_exists( $p->extra, 'dev_stats_url' ) ) {
				$params['meta_input']['lf_project_devstats'] = $p->extra->dev_stats_url;
			}
			if ( property_exists( $p->extra, 'artwork_url' ) ) {
				$params['meta_input']['lf_project_logos'] = $p->extra->artwork_url;
			}
			if ( property_exists( $p->extra, 'stack_overflow_url' ) ) {
				$params['meta_input']['lf_project_stack_overflow'] = $p->extra->stack_overflow_url;
			}
			if ( property_exists( $p->extra, 'accepted' ) ) {
				$params['meta_input']['lf_project_date_accepted'] = $p->extra->accepted;
			}
			if ( property_exists( $p->extra, 'incubating' ) ) {
				$params['meta_input']['lf_project_date_incubating'] = $p->extra->incubating;
			}
			if ( property_exists( $p->extra, 'graduated' ) ) {
				$params['meta_input']['lf_project_date_graduated'] = $p->extra->graduated;
			}
			if ( property_exists( $p->extra, 'archived' ) ) {
				$params['meta_input']['lf_project_date_archived'] = $p->extra->archived;
			}
			if ( property_exists( $p->extra, 'blog_url' ) ) {
				$params['meta_input']['lf_project_blog'] = $p->extra->blog_url;
			}
			if ( property_exists( $p->extra, 'mailing_list_url' ) ) {
				$params['meta_input']['lf_project_mail'] = $p->extra->mailing_list_url;
			}
			if ( property_exists( $p->extra, 'slack_url' ) ) {
				$params['meta_input']['lf_project_slack'] = $p->extra->slack_url;
			}
			if ( property_exists( $p->extra, 'youtube_url' ) ) {
				$params['meta_input']['lf_project_youtube'] = $p->extra->youtube_url;
			}
			if ( property_exists( $p->extra, 'gitter_url' ) ) {
				$params['meta_input']['lf_project_gitter'] = $p->extra->gitter_url;
			}
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
			wp_set_object_terms( $newid, $level->key, 'lf-project-stage', false );
		}
	}
}

<?php
/**
 * Sync KCDs from Landscape
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

$data = wp_remote_get( 'https://community.cncf.io/api/search/event?q=kcd&region_id=8' );

if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
	return false;
}

$remote_body = json_decode( wp_remote_retrieve_body( $data ) );
$events      = $remote_body->results;

// delete all existing imported KCD posts.
$args      = array(
	'post_type'      => 'lf_event',
	'meta_key'       => 'lf_event_bevy_import',
	'meta_value'     => true,
	'no_found_rows'  => true,
	'posts_per_page' => 500,
	'post_status'    => 'any',
);
$the_query = new WP_Query( $args );
while ( $the_query->have_posts() ) {
	$the_query->the_post();
	wp_delete_post( get_the_ID(), true );
}
$background_colors = array( '#14496c', '#641e16', '#5e2d72', '#0b5329', '#1a267d' );
$background_color  = 0;

// insert events.
foreach ( $events as $event ) {
	// insert if end date hasn't passed.
	if ( ( time() - ( 60 * 60 * 24 ) ) < strtotime( $event->end_date_iso ) ) {
		$dt_date_start = new DateTime( $event->start_date_iso );
		$dt_date_end   = new DateTime( $event->end_date_iso );

		$virtual = strpos( strtolower( $event->title ), 'virtual' ) + strpos( strtolower( $event->description_short ), 'virtual' );
		if ( 0 < $virtual || ! $event->venue_city ) {
			$venue_city = 'Virtual';
		} else {
			$venue_city = $event->venue_city;
		}

		$event_title = $event->title;
		$event_title = str_replace( 'Kubernetes Community Days', 'KCD', $event_title );
		$event_title = str_replace( 'Kubernetes Community Day', 'KCD', $event_title );
		$event_title = str_replace( 'KCDs', 'KCD', $event_title );

		$my_post = array(
			'post_title'  => $event_title,
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type'   => 'lf_event',
			'meta_input'  => array(
				'lf_event_external_url'  => $event->url,
				'lf_event_bevy_import'   => true,
				'lf_event_date_start'    => $dt_date_start->format( 'Y-m-d' ),
				'lf_event_date_end'      => $dt_date_end->format( 'Y-m-d' ),
				'lf_event_city'          => $venue_city,
				'lf_event_event-logo'    => '',
				'lf_event_background'    => 95014,
				'lf_event_overlay_color' => $background_colors[ $background_color ],
			),
		);

		if ( 4 == $background_color ) {
			$background_color = 0;
		} else {
			++$background_color;
		}

		$newid = wp_insert_post( $my_post );

		if ( $newid ) {
			wp_set_object_terms( $newid, 351, 'lf-event-host', false );

			$matches = array();
			preg_match( '/\(([^)]+)\)/', $event->chapter_location, $matches );
			if ( 1 < count( $matches ) ) {
				$country_term = get_term_by( 'slug', strtolower( $matches[1] ), 'lf-country' );
				if ( $country_term ) {
					wp_set_object_terms( $newid, $country_term->term_id, 'lf-country', false );
				}
			}
		}
	}
}

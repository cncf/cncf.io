<?php
/**
 * Sync KTPs from Landscape
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

$ktps_url  = 'https://landscape.cncf.io/api/items?category=kubernetes-training-partner&grouping=no';
$items_url = 'https://landscape.cncf.io/data/items.json';
$logos_url = 'https://landscape.cncf.io/';

$args = array(
	'timeout'   => 100,
	'sslverify' => false,
);

$data = wp_remote_get( $ktps_url, $args );
if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
	return;
}
$ktps = json_decode( wp_remote_retrieve_body( $data ) );

$data = wp_remote_get( $items_url, $args );
if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
	return;
}
$items = json_decode( wp_remote_retrieve_body( $data ) );
$id_column = array_column( $items, 'id' );

$synced_ids = array();

foreach ( $ktps as $ktp ) {
	$key = array_search( $ktp->id, $id_column );
	if ( false === $key ) {
		continue;
	}

	$p = $items[ $key ];

	$params = array(
		'post_type' => 'lf_ktp',
		'post_title' => $p->name,
		'post_status' => 'publish',
		'meta_input' => array(
			'lf_ktp_external_url' => $p->homepage_url,
			'lf_ktp_logo' => $logos_url . $p->href,
		),
	);

	if ( property_exists( $p, 'description' ) ) {
		$params['meta_input']['lf_ktp_description'] = $p->description;
	}

	$pp = get_page_by_title( $p->name, OBJECT, 'lf_ktp' );
	if ( $pp ) {
		$params['ID'] = $pp->ID;
	}

	$newid = wp_insert_post( $params ); // will insert or update the post as needed.
	if ( $newid ) {
		if ( property_exists( $p->crunchbaseData, 'country' ) ) { //phpcs:ignore
			$country = $p->crunchbaseData->country; //phpcs:ignore
			if ( 'The Netherlands' == $country ) {
				$country = 'Netherlands';
			}
			wp_set_object_terms( $newid, $country, 'lf-country', false );
		}
		if ( property_exists( $p, 'extra' ) ) {
			if ( property_exists( $p->extra, 'training_certifications' ) ) {
				$certs = explode( ',', $p->extra->training_certifications );
				wp_set_object_terms( $newid, $certs, 'lf-certification', false );
			}
			if ( property_exists( $p->extra, 'training_type' ) ) {
				$types = explode( ',', $p->extra->training_type );
				wp_set_object_terms( $newid, $types, 'lf-training-type', false );
			}
		}
	}

	$synced_ids[] = $newid;
}

// delete any KTP posts which aren't in $synced_ids.
$query = new WP_Query(
	array(
		'post_type' => 'lf_ktp',
		'post__not_in' => $synced_ids,
	)
);
while ( $query->have_posts() ) {
	$query->the_post();
	wp_delete_post( get_the_id() );
}
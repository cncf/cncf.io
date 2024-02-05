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

$ktps_url = 'https://landscape.cncf.io/api/categories/special/kubernetes-training-partner/all.json';

$args = array(
	'timeout'   => 100,
	'sslverify' => false,
);

$data = wp_remote_get( $ktps_url, $args );
if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
	return;
}
$ktps = json_decode( wp_remote_retrieve_body( $data ) );

$synced_ids = array();

foreach ( $ktps as $ktp ) {

	$params = array(
		'post_type'   => 'lf_ktp',
		'post_title'  => $ktp->name,
		'post_status' => 'publish',
		'meta_input'  => array(
			'lf_ktp_external_url' => $ktp->homepage_url,
			'lf_ktp_logo'         => $ktp->logo_url,
		),
	);

	if ( property_exists( $ktp, 'description' ) ) {
		$params['meta_input']['lf_ktp_description'] = $ktp->description;
	}

	$pp = get_posts(
		array(
			'post_type'              => 'lf_ktp',
			'title'                  => $ktp->name,
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

	$newid = wp_insert_post( $params ); // will insert or update the post as needed.
	if ( $newid ) {
		if ( property_exists( $ktp, 'country' ) ) { //phpcs:ignore
			$country = $ktp->country; //phpcs:ignore
			if ( 'The Netherlands' == $country ) {
				$country = 'Netherlands';
			}
			wp_set_object_terms( $newid, $country, 'lf-country', false );
		}
		if ( property_exists( $ktp, 'training_certifications' ) ) {
			$certs = explode( ',', $ktp->training_certifications );
			wp_set_object_terms( $newid, $certs, 'lf-certification', false );
		}
		if ( property_exists( $ktp, 'training_type' ) ) {
			$types = explode( ',', $ktp->training_type );
			wp_set_object_terms( $newid, $types, 'lf-training-type', false );
		}
	}

	$synced_ids[] = $newid;
}

// delete any KTP posts which aren't in $synced_ids.
$query = new WP_Query(
	array(
		'post_type'    => 'lf_ktp',
		'post__not_in' => $synced_ids,
	)
);
while ( $query->have_posts() ) {
	$query->the_post();
	wp_delete_post( get_the_id() );
}

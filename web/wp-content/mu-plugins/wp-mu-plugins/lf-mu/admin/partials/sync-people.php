<?php
/**
 * Sync People from GitHub
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

$people_url = 'https://raw.githubusercontent.com/cncf/people/main/people.json';
$github_images_url = 'https://raw.githubusercontent.com/cncf/people/main/images/';

		$args = array(
			'timeout'   => 100,
			'sslverify' => false,
		);

		$data = wp_remote_get( $people_url, $args );
		if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
			return;
		}
		$people = json_decode( wp_remote_retrieve_body( $data ) );

		if ( ! $people ) {
			return;
		}

		$synced_ids = array();

		foreach ( $people as $p ) {

			$params = array(
				'post_type'    => 'lf_person',
				'post_title'   => $p->name,
				'post_content' => $p->bio,
				'post_status'  => 'publish',
				'meta_input'   => array(),
			);

			if ( property_exists( $p, 'company' ) ) {
				$params['meta_input']['lf_person_company'] = $p->company;
			}
			if ( property_exists( $p, 'pronouns' ) ) {
				$params['meta_input']['lf_person_pronouns'] = $p->pronouns;
			}
			if ( property_exists( $p, 'location' ) ) {
				$params['meta_input']['lf_person_location'] = $p->location;
			}
			if ( property_exists( $p, 'linkedin' ) ) {
				$params['meta_input']['lf_person_linkedin'] = $p->linkedin;
			}
			if ( property_exists( $p, 'twitter' ) ) {
				$params['meta_input']['lf_person_twitter'] = $p->twitter;
			}
			if ( property_exists( $p, 'github' ) ) {
				$params['meta_input']['lf_person_github'] = $p->github;
			}
			if ( property_exists( $p, 'wechat' ) ) {
				$params['meta_input']['lf_person_wechat'] = $p->wechat;
			}
			if ( property_exists( $p, 'youtube' ) ) {
				$params['meta_input']['lf_person_youtube'] = $p->youtube;
			}
			if ( property_exists( $p, 'priority' ) ) {
				$params['meta_input']['lf_person_is_priority'] = $p->priority;
			}
			if ( property_exists( $p, 'image' ) ) {
				if ( strpos( $p->image, 'http' ) !== false ) {
					$image_url = $p->image;
				} else {
					$image_url = $github_images_url . $p->image;
				}
				$params['meta_input']['lf_person_image'] = $image_url;
			}
			if ( property_exists( $p, 'website' ) ) {
				$params['meta_input']['lf_person_website'] = $p->website;
			}

			$pp = get_page_by_title( $p->name, OBJECT, 'lf_person' );
			if ( $pp ) {
				$params['ID'] = $pp->ID;
			}

			$newid = wp_insert_post( $params ); // will insert or update the post as needed.

			if ( $newid ) {
				if ( property_exists( $p, 'languages' ) ) {
					wp_set_object_terms( $newid, $p->languages, 'lf-language', false );
				}
				$projects_to_add = array();
				if ( property_exists( $p, 'projects' ) ) {
					foreach ( $p->projects as $proj ) {
						if ( term_exists( $proj, 'lf-project' ) ) {
							// Don't allow any non-CNCF projects to be added.
							$projects_to_add[] = $proj;
						}
					}
					wp_set_object_terms( $newid, $projects_to_add, 'lf-project', false );
				}
				if ( property_exists( $p, 'category' ) ) {
					wp_set_object_terms( $newid, $p->category, 'lf-person-category', false );
				} else {
					wp_set_object_terms( $newid, array(), 'lf-person-category', false );
				}
				if ( property_exists( $p, 'location' ) ) {
					$country_arr = explode( ',', $params['meta_input']['lf_person_location'] );
					$country = trim( end( $country_arr ) );
					$term_exists = term_exists( $country, 'lf-country' );
					if ( $term_exists ) {
						wp_set_object_terms( $newid, (int) $term_exists['term_id'], 'lf-country', false );
					}
				}

				$synced_ids[] = $newid;
			}
		}

		// delete any People posts which aren't in $synced_ids.
		$query = new WP_Query(
			array(
				'post_type' => 'lf_person',
				'post__not_in' => $synced_ids,
			)
		);
		while ( $query->have_posts() ) {
			$query->the_post();
			wp_delete_post( get_the_id() );
		}

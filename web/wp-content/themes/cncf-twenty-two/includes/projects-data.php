<?php
/**
 * Projects Data
 *
 * Functions that manipulate project maturity data.
 *
 * @category Components
 * @package  WordPress
 * @author   Chris Abraham
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://cncf.io
 * @since    1.0.0
 */

/**
 * Get project maturity data.
 */
function get_projects_maturity_data() {
	$maturity_data = get_transient( 'cncf_project_maturity_data' );

	if ( false === $maturity_data ) {
		$maturity_data = array();

		$query_args = array(
			'post_type'      => 'lf_project',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => 1000,
		);

		$project_query = new WP_Query( $query_args );

		while ( $project_query->have_posts() ) {
			$project_query->the_post();
			$name       = get_the_title( get_the_ID() );
			$accepted   = get_post_meta( get_the_ID(), 'lf_project_date_accepted', true );
			$incubating = get_post_meta( get_the_ID(), 'lf_project_date_incubating', true );
			$graduated  = get_post_meta( get_the_ID(), 'lf_project_date_graduated', true );
			$archived   = get_post_meta( get_the_ID(), 'lf_project_date_archived', true );

			$maturity_data[ $name ] = array(
				'accepted'   => $accepted,
				'incubating' => $incubating,
				'graduated'  => $graduated,
				'archived'   => $archived,
			);
		}
		wp_reset_postdata();
		set_transient( 'cncf_project_maturity_data', $maturity_data, DAY_IN_SECONDS );
	}
	return $maturity_data;
}

/**
 * Get projects timeline data.
 */
function get_projects_timeline_data() {
	$timeline_data = get_transient( 'cncf_project_timeline_data' );

	if ( false === $timeline_data ) {
		$timeline_data = array();

		$query_args = array(
			'post_type'      => 'lf_project',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => 1000,
		);

		$project_query = new WP_Query( $query_args );

		while ( $project_query->have_posts() ) {
			$project_query->the_post();
			$name       = get_the_title( get_the_ID() );
			$accepted   = get_post_meta( get_the_ID(), 'lf_project_date_accepted', true );
			$incubating = get_post_meta( get_the_ID(), 'lf_project_date_incubating', true );
			$graduated  = get_post_meta( get_the_ID(), 'lf_project_date_graduated', true );
			$archived   = get_post_meta( get_the_ID(), 'lf_project_date_archived', true );

			if ( $accepted && $incubating == $accepted ) {
				$timeline_data[] = array(
					'date'    => $accepted,
					'project' => $name,
					'action'  => 'was accepted into incubating',
				);
			} elseif ( $accepted ) {
				$timeline_data[] = array(
					'date'    => $accepted,
					'project' => $name,
					'action'  => 'was accepted into sandbox',
				);
			}

			if ( $incubating && $incubating != $accepted ) {
				$timeline_data[] = array(
					'date'    => $incubating,
					'project' => $name,
					'action'  => 'moved into incubating',
				);
			}

			if ( $graduated ) {
				$timeline_data[] = array(
					'date'    => $graduated,
					'project' => $name,
					'action'  => 'moved into graduated',
				);
			}

			if ( $archived ) {
				$timeline_data[] = array(
					'date'    => $archived,
					'project' => $name,
					'action'  => 'was archived',
				);
			}
		}
		wp_reset_postdata();
		set_transient( 'cncf_project_timeline_data', $timeline_data, DAY_IN_SECONDS );
	}
	return $timeline_data;
}


$timeline_data = get_projects_timeline_data();
$dates = array_column( $timeline_data, 'date' );
array_multisort( $dates, SORT_ASC, $timeline_data );
foreach ( $timeline_data as $t ) {
	echo $t['date'] . ': ' . $t['project'] . ' ' . $t['action'] . "\n";
}

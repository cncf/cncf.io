<?php
/**
 * Projects Chart Shortcode
 *
 * Usage:
 * [projects stage="graduated|incubating|sandbox"]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Get maturity data
 */
function get_maturity_data() {
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

			$maturity_data[$name] = array( 
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
 * Returns maturity data ready for plotting on stacked line chart
 *
 * @param array $maturity_data CNCF project maturity data
 */
function get_chart_data( $maturity_data ) {
	$chart_data = array();
	$this_date  = '2015-01-01';

	while ( $this_date < date( 'Y-m-d' ) ) {
		$chart_data[$this_date] = array(
			'archived'   => 0,
			'sandbox'    => 0,
			'graduated'  => 0,
			'incubating' => 0,
		);
		foreach( $maturity_data as $d ) {
			if ( $d['archived'] < $this_date && (int) $d['archived'] > 0 ) {
				$chart_data[$this_date]['archived'] += 1;
			} elseif ( $d['graduated'] < $this_date && (int) $d['graduated'] > 0 ) {
				$chart_data[$this_date]['graduated'] += 1;
			} elseif ( $d['incubating'] < $this_date && (int) $d['incubating'] > 0 ) {
				$chart_data[$this_date]['incubating'] += 1;
			} elseif ( $d['accepted'] < $this_date && (int) $d['accepted'] > 0 ) {
				$chart_data[$this_date]['sandbox'] += 1;
			}
		}
		$this_date = date('Y-m-d', strtotime( $this_date . ' + 1 month' ) );
	}
	return $chart_data;
}

/**
 * Add Projects shortcode.
 *
 * @param array $atts Attributes.
 */
function add_projects_chart_shortcode( $atts ) {

	$maturity_data = get_maturity_data();
	$chart_data    = get_chart_data( $maturity_data ); 

	ob_start();
	// var_dump( $chart_data );
	// var_dump( $maturity_data );
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'projects-chart', 'add_projects_chart_shortcode' );

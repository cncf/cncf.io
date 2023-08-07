<?php
/**
 * Project Chart Shortcodes
 *
 * Usage:
 * [projects stage="graduated|incubating|sandbox"]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Get project maturity data.
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
 * Processes maturity data to be ready for plotting on stacked line chart.
 *
 * @param array $maturity_data CNCF project maturity data.
 */
function get_project_chart_data( $maturity_data ) {
	$chart_data = array();
	$start_date = '2016-01-01';
	$this_date  = $start_date;

	while ( $this_date < gmdate( 'Y-m-d' ) ) {
		if ( gmdate( 'Y-m-d' ) < gmdate( 'Y-m-d', strtotime( $this_date . ' + 1 month' ) ) ) {
			// use the current date if it's the last data point.
			$this_date = gmdate( 'Y-m-d' );
		} else {
			// otherwise use the start of the next month.
			$this_date = gmdate( 'Y-m-d', strtotime( $this_date . ' + 1 month' ) );
		}
		$chart_data[ $this_date ] = array(
			'archived'   => 0,
			'sandbox'    => 0,
			'graduated'  => 0,
			'incubating' => 0,
		);
		foreach ( $maturity_data as $d ) {
			if ( $d['archived'] < $this_date && (int) $d['archived'] > 0 ) {
				$chart_data[ $this_date ]['archived'] += 1;
			} elseif ( $d['graduated'] < $this_date && (int) $d['graduated'] > 0 ) {
				$chart_data[ $this_date ]['graduated'] += 1;
			} elseif ( $d['incubating'] < $this_date && (int) $d['incubating'] > 0 ) {
				$chart_data[ $this_date ]['incubating'] += 1;
			} elseif ( $d['accepted'] < $this_date && (int) $d['accepted'] > 0 ) {
				$chart_data[ $this_date ]['sandbox'] += 1;
			}
		}
	}
	return $chart_data;
}

/**
 * Add Projects Maturity Chart shortcode.
 *
 * @param array $atts Attributes.
 */
function add_projects_maturity_chart_shortcode( $atts ) {

	$maturity_data  = get_maturity_data();
	$chart_data     = get_project_chart_data( $maturity_data );
	$project_months = array_keys( $chart_data );
	$sandbox        = array();
	$incubating     = array();
	$graduated      = array();
	$archived       = array();

	foreach ( $chart_data as $cd ) {
		$sandbox[]    = $cd['sandbox'];
		$incubating[] = $cd['incubating'];
		$graduated[]  = $cd['graduated'];
		$archived[]   = $cd['archived'];
	}

	ob_start();

	// chart js.
	wp_enqueue_script(
		'chart-js',
		get_template_directory_uri() . '/source/js/libraries/chart-3.9.1.min.js',
		null,
		filemtime( get_template_directory() . '/source/js/libraries/chart-3.9.1.min.js' ),
		true
	);
	// custom script.
	wp_enqueue_script(
		'projects-chart',
		get_template_directory_uri() . '/source/js/on-demand/projects-chart.js',
		array( 'jquery', 'chart-js' ),
		filemtime( get_template_directory() . '/source/js/on-demand/projects-chart.js' ),
		true
	);
	?>
<div class="projects-chart-container">
	<canvas id="projctsMaturityChart"></canvas>
</div>
<script>
	const project_months     = <?php echo json_encode( $project_months ); ?>;
	const project_sandbox    = <?php echo json_encode( $sandbox ); ?>;
	const project_incubating = <?php echo json_encode( $incubating ); ?>;
	const project_graduated  = <?php echo json_encode( $graduated ); ?>;
	const project_archived   = <?php echo json_encode( $archived ); ?>;
</script>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'projects-maturity-chart', 'add_projects_maturity_chart_shortcode' );


/**
 * Add Projects Accepted Chart shortcode.
 *
 * @param array $atts Attributes.
 */
function add_projects_accepted_chart_shortcode( $atts ) {

	$maturity_data  = get_maturity_data();
	$start_year     = 2016;
	$accepted       = array();
	$background     = array();
	$current_year   = (int) gmdate( 'Y' );

	for ( $this_year = $start_year; $this_year <= $current_year; $this_year++ ) {
		$accepted[ $this_year ] = 0;
		if ( $current_year == $this_year ) {
			$background[] = 'rgb(0, 134, 255, 0.4)';
		} else {
			$background[] = 'rgb(0, 134, 255)';
		}
	}

	foreach ( $maturity_data as $md ) {
		$md_year = (int) explode( '-', $md['accepted'] )[0];
		if ( 2016 <= $md_year && $md_year <= $current_year ) {
			$accepted[ $md_year ] += 1;
		}
	}

	// remove current year if project count is 0.
	if ( 0 == $accepted[ $current_year ] ) {
		unset( $accepted[ $current_year ] );
	}

	ob_start();

	// chart js.
	wp_enqueue_script(
		'chart-js',
		get_template_directory_uri() . '/source/js/libraries/chart-3.9.1.min.js',
		null,
		filemtime( get_template_directory() . '/source/js/libraries/chart-3.9.1.min.js' ),
		true
	);
	// custom script.
	wp_enqueue_script(
		'projects-accepted-chart',
		get_template_directory_uri() . '/source/js/on-demand/projects-accepted-chart.js',
		array( 'jquery', 'chart-js' ),
		filemtime( get_template_directory() . '/source/js/on-demand/projects-accepted-chart.js' ),
		true
	);
	?>
<div class="projects-chart-container">
	<canvas id="projectsAcceptedChart"></canvas>
</div>
<script>
	const project_accepted_dates   = <?php echo json_encode( $accepted ); ?>;
	const chart_background_colors = <?php echo json_encode( $background ); ?>;
</script>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'projects-accepted-chart', 'add_projects_accepted_chart_shortcode' );

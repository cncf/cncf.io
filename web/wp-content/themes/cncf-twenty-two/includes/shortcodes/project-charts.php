<?php
/**
 * Project Chart Shortcodes
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
 * Add Project Count Over Time chart shortcode.
 *
 * @param array $atts Attributes.
 */
function add_projects_maturity_chart_shortcode( $atts ) {

	$maturity_data  = get_maturity_data();
	$chart_data     = get_project_chart_data( $maturity_data );
	$project_months = array();
	$sandbox        = array();
	$incubating     = array();
	$graduated      = array();
	$archived       = array();

	$num_dates = count( array_keys( $chart_data ) );
	$i         = 1;
	foreach ( array_keys( $chart_data ) as $m ) {
		if ( $i != $num_dates ) {
			$project_months[] = gmdate( 'M, Y', strtotime( $m ) );
		} else {
			// show the day for the last entry.
			$project_months[] = gmdate( 'M d, Y', strtotime( $m ) );
		}
		++$i;
	}

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
 * Add Projects Accepted Each Year chart shortcode.
 *
 * @param array $atts Attributes.
 */
function add_projects_accepted_chart_shortcode( $atts ) {

	$maturity_data       = get_maturity_data();
	$start_year          = 2016;
	$sanbox_accepted     = array();
	$incubating_accepted = array();
	$graduated_accepted  = array();
	$background          = array();
	$current_year        = (int) gmdate( 'Y' );

	for ( $this_year = $start_year; $this_year <= $current_year; $this_year++ ) {
		$sandbox_accepted[ $this_year ]    = 0;
		$incubating_accepted[ $this_year ] = 0;
		$graduated_accepted[ $this_year ]  = 0;
		if ( $current_year == $this_year ) {
			$graduated_background[]  = 'rgb(193, 96, 220, .4)';
			$incubating_background[] = 'rgb(240, 188, 0, .4)';
			$sandbox_background[]    = 'rgb(10, 178, 178, .4)';
		} else {
			$graduated_background[]  = 'rgb(193 96 220)';
			$incubating_background[] = 'rgb(240, 188, 0)';
			$sandbox_background[]    = 'rgb(10, 178, 178)';
		}
	}

	foreach ( $maturity_data as $md ) {
		$md_year = (int) explode( '-', $md['accepted'] )[0];
		if ( 2016 <= $md_year && $md_year <= $current_year ) {
			if ( $md['graduated'] == $md['accepted'] ) {
				$graduated_accepted[ $md_year ] += 1;
			} elseif ( $md['incubating'] == $md['accepted'] ) {
				$incubating_accepted[ $md_year ] += 1;
			} else {
				$sandbox_accepted[ $md_year ] += 1;
			}
		}
	}

	// remove current year if project count is 0.
	if ( 0 == $sandbox_accepted[ $current_year ] && 0 == $incubating_accepted[ $current_year ] && 0 == $graduated_accepted[ $current_year ] ) {
		unset( $sandbox_accepted[ $current_year ] );
		unset( $incubating_accepted[ $current_year ] );
		unset( $graduated_accepted[ $current_year ] );
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
	const project_sandbox_accepted_dates     = <?php echo json_encode( $sandbox_accepted ); ?>;
	const project_incubating_accepted_dates  = <?php echo json_encode( $incubating_accepted ); ?>;
	const project_graduated_accepted_dates   = <?php echo json_encode( $graduated_accepted ); ?>;
	const chart_sandbox_background_colors    = <?php echo json_encode( $sandbox_background ); ?>;
	const chart_incubating_background_colors = <?php echo json_encode( $incubating_background ); ?>;
	const chart_graduated_background_colors  = <?php echo json_encode( $graduated_background ); ?>;
</script>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'projects-accepted-chart', 'add_projects_accepted_chart_shortcode' );


/**
 * Add Project Moves Each Year chart shortcode.
 *
 * @param array $atts Attributes.
 */
function add_project_moves_chart_shortcode( $atts ) {

	$maturity_data       = get_maturity_data();
	$start_year          = 2016;
	$incubating_move     = array();
	$graduated_move      = array();
	$archived_move       = array();
	$background          = array();
	$current_year        = (int) gmdate( 'Y' );

	for ( $this_year = $start_year; $this_year <= $current_year; $this_year++ ) {
		$archived_move[ $this_year ]   = 0;
		$incubating_move[ $this_year ] = 0;
		$graduated_move[ $this_year ]  = 0;
		if ( $current_year == $this_year ) {
			$graduated_background[]  = 'rgb(193, 96, 220, .4)';
			$incubating_background[] = 'rgb(240, 188, 0, .4)';
			$archived_background[]   = 'rgb(116, 116, 116, .4)';
		} else {
			$graduated_background[]  = 'rgb(193 96 220)';
			$incubating_background[] = 'rgb(240, 188, 0)';
			$archived_background[]   = 'rgb(116, 116, 116)';
		}
	}

	foreach ( $maturity_data as $md ) {
		$accepted_year   = (int) explode( '-', $md['accepted'] )[0];
		$graduated_year  = (int) explode( '-', $md['graduated'] )[0];
		$incubating_year = (int) explode( '-', $md['incubating'] )[0];
		$archived_year   = (int) explode( '-', $md['archived'] )[0];

		if ( 2016 <= $graduated_year && $md['graduated'] != $md['accepted'] ) {
			$graduated_move[ $graduated_year ] += 1;
		}
		if ( 2016 <= $incubating_year && $md['incubating'] != $md['accepted'] ) {
			$incubating_move[ $incubating_year ] += 1;
		}
		if ( 2016 <= $archived_year && $md['archived'] != $md['accepted'] ) {
			$archived_move[ $archived_year ] += 1;
		}
	}

	// remove current year if project count is 0.
	if ( 0 == $archived_move[ $current_year ] && 0 == $incubating_move[ $current_year ] && 0 == $graduated_move[ $current_year ] ) {
		unset( $archived_move[ $current_year ] );
		unset( $incubating_move[ $current_year ] );
		unset( $graduated_move[ $current_year ] );
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
		'project-moves-chart',
		get_template_directory_uri() . '/source/js/on-demand/project-moves-chart.js',
		array( 'jquery', 'chart-js' ),
		filemtime( get_template_directory() . '/source/js/on-demand/project-moves-chart.js' ),
		true
	);
	?>
<div class="projects-chart-container">
	<canvas id="projectMovesChart"></canvas>
</div>
<script>
	const project_archived_move_dates              = <?php echo json_encode( $archived_move ); ?>;
	const project_incubating_move_dates            = <?php echo json_encode( $incubating_move ); ?>;
	const project_graduated_move_dates             = <?php echo json_encode( $graduated_move ); ?>;
	const moves_chart_archived_background_colors   = <?php echo json_encode( $archived_background ); ?>;
	const moves_chart_incubating_background_colors = <?php echo json_encode( $incubating_background ); ?>;
	const moves_chart_graduated_background_colors  = <?php echo json_encode( $graduated_background ); ?>;
</script>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'project-moves-chart', 'add_project_moves_chart_shortcode' );


/**
 * Add Contributors chart shortcode.
 *
 * @param array $atts Attributes.
 */
function add_contributors_chart_shortcode( $atts ) {
	$data = wp_remote_post(
		'https://devstats.cncf.io/api/v1',
		array(
			'headers'     => array( 'Content-Type' => 'application/json; charset=utf-8' ),
			'body'        => '{"api":"CumulativeCounts","payload":{"project":"all","metric":"contributors"}}',
			'method'      => 'POST',
			'data_format' => 'body',
		)
	);

	if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) !== 200 ) ) {
		return;
	}

	$remote_body = json_decode( wp_remote_retrieve_body( $data ) );

	if ( ! ( isset( $remote_body->timestamps ) && isset( $remote_body->values ) ) ) {
		return;
	}
	$timestamps = $remote_body->timestamps;
	$contributors_months = array();
	foreach ( $timestamps as $m ) {
		$contributors_months[] = gmdate( 'M, Y', strtotime( $m ) );
	}

	$values     = $remote_body->values;

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
		'contributors-chart',
		get_template_directory_uri() . '/source/js/on-demand/contributors-chart.js',
		array( 'jquery', 'chart-js' ),
		filemtime( get_template_directory() . '/source/js/on-demand/contributors-chart.js' ),
		true
	);
	?>
<div class="projects-chart-container">
	<canvas id="contributorsChart"></canvas>
</div>
<script>
	const contributors_months = <?php echo json_encode( $contributors_months ); ?>;
	const contributors_counts = <?php echo json_encode( $values ); ?>;
</script>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'contributors-chart', 'add_contributors_chart_shortcode' );

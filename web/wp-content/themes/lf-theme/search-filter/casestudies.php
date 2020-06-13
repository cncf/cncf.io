<?php
/**
 * Search & Filter Pro
 *
 * Case Studies
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) :
	// get total list of case studies.
	$count_case_study = wp_count_posts( 'lf_case_study' );
	$full_count       = $count_case_study->publish;
	?>

<p class="results-count">
	<?php
	// if CPT set chinese conditional true.
	if ( 'lf_case_study_ch' === $query->query['post_type'] ) {
		$ch = true;
		echo '发现' . esc_html( $query->found_posts ) . '个案例研究';
	} else {
		$ch = false;
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' case studies';
		} else {
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' case studies';
		}
	}
	?>
</p>
<div class="case-studies-wrapper">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

		get_template_part( 'components/case-study-item' );

endwhile;
	?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;

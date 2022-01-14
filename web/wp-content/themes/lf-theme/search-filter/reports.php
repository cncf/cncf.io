<?php
/**
 * Search & Filter Pro
 *
 * Webinars
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) : ?>

<p class="results-count">
	<?php
	$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'lf_report' and wp_posts.post_status = 'publish';" );

	// if filter matches all webinars.
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' reports';
	} else {
		// else show partial count.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' reports';
	}
	?>
</p>
<div class="webinars-wrapper">

	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		$report_type = Lf_Utils::get_term_names( get_the_ID(), 'lf-report-type', true );

	endwhile;
	?>
</div>
	<?php
endif;

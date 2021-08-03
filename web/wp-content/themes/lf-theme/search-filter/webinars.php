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

	<?php

	// work out if dealing with recorded or upcoming.
	if ( '>=' !== $query->query['meta_query'][0]['compare'] ) {
		// recorded webinars.
		$is_recorded = true;
	} else {
		$is_recorded = false;
	}
	?>

<p class="results-count">
	<?php
	if ( $is_recorded ) {
		// get total list of webinars.
		$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'lf_webinar' and wp_posts.post_status = 'publish' and meta_key='lf_webinar_recording_url' and meta_value <> '';" );

		// if filter matches all webinars.
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' recorded online programs';
		} else {
			// else show partial count.
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' recorded online programs';
		}
	} else {
		// get total list of webinars.
		$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'lf_webinar' and wp_posts.post_status = 'publish' and meta_key='lf_webinar_date' and meta_value >= DATE(DATE_SUB(NOW(), INTERVAL 7 HOUR));" );

		// if filter matches all webinars.
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' upcoming online programs';
		} else {
			// else show partial count.
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' upcoming online programs';
		}
	}
	?>
</p>

	<?php if ( $is_recorded ) : ?>
<!-- Setup the Play SVG to use it in the loop  -->
<svg style="display:none">
	<symbol id="play" viewBox="-1 -1 90 90">
		<path fill="#ff00aa"
			d="M41.5 83C64.42 83 83 64.42 83 41.5S64.42 0 41.5 0 0 18.58 0 41.5 18.58 83 41.5 83z" />
		<path d="M62 41.5L29 58V25z" fill="#FFF" />
	</symbol>
</svg>
	<?php endif; ?>

<div class="webinars-wrapper">

	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

		if ( $is_recorded ) {
			get_template_part( 'components/recorded-webinars-item' );

		} else {
			get_template_part( 'components/upcoming-webinars-item' );
		}

endwhile;
	?>
</div>
	<?php
else :
	echo 'New webinars coming soon. <a href="#newsletter">Sign up for our newsletter to stay informed</a>.';
endif;

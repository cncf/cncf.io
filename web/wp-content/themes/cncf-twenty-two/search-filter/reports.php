<?php
/**
 * Search & Filter Pro
 *
 * Webinars
 *
 * @package WordPress
 * @subpackage cncf-theme
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

	<?php
	$y = 0;
	while ( $query->have_posts() ) :
		$query->the_post();
		$report_type      = ucwords( Lf_Utils::get_term_names( get_the_ID(), 'lf-report-type', true ) );
		$report_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-report-type', true );
		$report_year      = get_post_meta( get_the_ID(), 'lf_report_published_year', true );

		if ( $y !== $report_year ) {
			if ( 0 !== $y ) {
				echo '</div>';
			}
			echo '<h2 class="h3">' . esc_html( $report_year ) . '</h2>';
			echo '<div class="reports-wrapper">';
			$y = $report_year;
		}
		?>
<div class="report-box">

	<div class="newsroom-image-wrapper">
		<a class="box-link is-primary-color"
			href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"></a>
		<?php
		if ( has_post_thumbnail( $lf_post ) ) {
			Lf_Utils::display_responsive_images( get_post_thumbnail_id( $lf_post ), 'newsroom-540', '540px', 'archive-image' );
		} elseif ( isset( $options['generic_thumb_id'] ) && $options['generic_thumb_id'] ) {
			Lf_Utils::display_responsive_images( $options['generic_thumb_id'], 'newsroom-540', '540px', 'archive-default-svg' );
		} else {
			echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
			. '/images/thumbnail-default.svg" alt="' . esc_attr( lf_blocks_get_site() ) . '" class="archive-default-svg"/>';
		}
		?>
	</div>

		<?php
		if ( $report_type ) :
			$report_type_link = '?_sft_lf-report-type=' . $report_type_slug . '';
			?>
	<a class="skew-box secondary"
		title="See more <?php echo esc_attr( $report_type ); ?> reports"
		href="<?php echo esc_url( $report_type_link ); ?>">
			<?php echo esc_html( $report_type ); ?> Report</a>
	<?php endif; ?>
	<h3 class="report-title h5"><a
			href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

</div>

		<?php

	endwhile;
	?>
</div>
	<?php
endif;

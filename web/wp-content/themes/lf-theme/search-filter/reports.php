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

	<?php
	$y = 0;
	while ( $query->have_posts() ) :
		$query->the_post();
		$report_type = Lf_Utils::get_term_names( get_the_ID(), 'lf-report-type', true );
		$report_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-report-type', true );
		$report_year = get_post_meta( get_the_ID(), 'lf_report_published_year', true );

		if ( $y != $report_year ) {
			if ( 0 != $y ) {
				echo '</div>';
			}
			echo '<h3>' . esc_html( $report_year ) . '</h3>';
			echo '<div class="webinars-wrapper">';
			$y = $report_year;
		}
		?>
		<div class="webinar-recorded-box box-shadow">

		<figure>
			<a href="<?php the_permalink(); ?>">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail();
				} elseif ( isset( $options['generic_thumb_id'] ) && $options['generic_thumb_id'] ) {
					echo wp_get_attachment_image( $options['generic_thumb_id'], 'full', false, array( 'class' => 'webinar-default' ) );
				} else {
					echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
					. '/images/thumbnail-default.svg" alt="CNCF" class="webinar-default"/>';
				}
				?>
			</a>
		</figure>

		<?php
		if ( $report_type ) :
			$report_type_link = '?_sft_lf-report-type=' . $report_type_slug . '';
			?>
			<a class="skew-box secondary" title="See more <?php echo esc_attr( $report_type ); ?> reports" href="<?php echo esc_url( $report_type_link ); ?>">
			<?php echo esc_html( $report_type ); ?> report</a>
		<?php endif; ?>
		<h5 class="webinar-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

		</div>

		<?php

	endwhile;
	?>
</div>
	<?php
endif;

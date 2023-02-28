<?php
/**
 * Search & Filter Pro
 *
 * Reports
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

wp_enqueue_style( 'wp-block-separator' );

if ( $query->have_posts() ) : ?>

<p class="search-filter-results-count">
	<?php
	if ( isset( $query->query['post__not_in'] ) ) {
		$post_not_in = ' and id not in (' . implode( ',', $query->query['post__not_in'] ) . ')';
	} else {
		$post_not_in = '';
	}

	$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'lf_report' and wp_posts.post_status = 'publish'" . $post_not_in . ' ;' ); //phpcs:ignore

	// if filter matches all.
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' reports';
	} else {
		// else show partial count.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' reports';
	}
	?>
</p>
<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

	<?php
	$y = 0;
	while ( $query->have_posts() ) :
		$query->the_post();
		$report_type      = ucwords( Lf_Utils::get_term_names( get_the_ID(), 'lf-report-type', true ) );
		$report_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-report-type', true );
		$report_year      = get_post_meta( get_the_ID(), 'lf_report_published_year', true );

		// If end of a year, insert a closing div.
		if ( $y !== $report_year ) {
			if ( 0 !== $y ) {
				?>
				</div>
				<div style="height:50px" aria-hidden="true" class="wp-block-spacer is-style-30-50"></div>
				<?php
			}
			?>
<div style="height:50px" aria-hidden="true" class="wp-block-spacer is-style-30-50"></div>

<h2><?php echo esc_html( $report_year ); ?></h2>

<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>
			<?php
			echo '<div class="reports-section columns-three">';
			$y = $report_year;
		}
		?>
<div class="report-item has-animation-scale-2">

	<a class="report-item__link" href="<?php the_permalink(); ?>"
		title="<?php echo esc_attr( the_title_attribute() ); ?>">
		<?php
		if ( has_post_thumbnail() ) {
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-388', '400px', 'report-item__image', 'lazy', get_the_title() );
		} else {
			$site_options = get_option( 'lf-mu' );
			Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-388', '400px', 'report-item__image', 'lazy', get_the_title() );
		}
		?>
	</a>

	<div class="report-item__text-wrapper">
		<?php
		if ( $report_type ) :
			$report_type_link = '?_sft_lf-report-type=' . $report_type_slug . '';
			?>
		<a class="author-category"
			title="See more <?php echo esc_attr( $report_type ); ?> reports"
			href="<?php echo esc_url( $report_type_link ); ?>">
			<?php echo esc_html( $report_type ); ?> Report</a>
		<?php endif; ?>

		<h3 class="report-item__title"><a
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	</div>
</div>

		<?php

	endwhile;
	?>
</div>
	<?php
endif;

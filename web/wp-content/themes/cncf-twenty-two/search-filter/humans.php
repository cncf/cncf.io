<?php
/**
 * Search & Filter Pro
 *
 * Spotlights
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

wp_enqueue_style( 'wp-block-separator' );

if ( $query->have_posts() ) : ?>

	<?php
	$count_humans = wp_count_posts( 'lf_human' );
	$full_count   = $count_humans->publish;
	?>
<p class="search-filter-results-count">
	<?php
	// if filter matches all.
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' humans of cloud native';
	} else {
		// else show partial count.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' humans of cloud native';
	}
	?>
</p>
<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<div class="humans columns-three">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part( 'components/human-item' );

	endwhile;
		?>
</div>
		<?php
endif;

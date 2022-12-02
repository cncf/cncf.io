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
	<p class="search-filter-results-count">
	<?php
	// get app spotlights.
	$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'lf_spotlight' and wp_posts.post_status = 'publish';" );

	// if filter matches all spotlights.
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' spotlights';
	} else {
		// show partial.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' spotlights';
	}
	?>
</p>
<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

	<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<div class="spotlights columns-three">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part( 'components/spotlight-item' );

	endwhile;
		?>
</div>
		<?php
endif;

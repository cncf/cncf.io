<?php
/**
 * Search & Filter Pro
 *
 * Spotlights
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>

<p class="results-count">
	<?php
	if ( $query->have_posts() ) :
		$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'lf_spotlight' and wp_posts.post_status = 'publish';" );
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' spotlights';
		} else {
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' spotlights';
		}
		?>
</p>
<div class="spotlights-wrapper">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part( 'components/spotlight-item' );

	endwhile;
		?>
</div>
		<?php
else :
	echo 'No Results Found';
endif;

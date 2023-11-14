<?php
/**
 * Search & Filter Pro
 *
 * Events
 *
 * @package     WordPress
 * @subpackage  cncf-theme
 * @since       1.0.0
 */

wp_enqueue_style( 'wp-block-separator' );

if ( $query->have_posts() ) : ?>
<p class="search-filter-results-count">
	<?php
	$dd         = current_datetime();
	$full_count = $wpdb->get_var( $wpdb->prepare( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'lf_event' and wp_posts.post_status = 'publish' and meta_key='lf_event_date_end' and meta_value >= %s;", $dd->format( 'Y/m/d' ) ) );

	// if filter matches all.
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' upcoming events';
	} else {
		// else show partial count.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' upcoming events';
	}
	?>
</p>
<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<div class="events columns-three">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		get_template_part( 'components/event-item' );
	endwhile;
	?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;

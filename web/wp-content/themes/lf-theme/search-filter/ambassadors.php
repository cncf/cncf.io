<?php
/**
 * Search & Filter Pro
 *
 * Events
 *
 * @package    WordPress
 * @subpackage LF-theme
 * @since      1.0.0
 */

if ( $query->have_posts() ) :
	?>
<p class="results-count">
	<?php
	$full_count = $wpdb->get_var( "select count(*) from wp_posts inner join wp_term_relationships on id = object_id where wp_posts.post_type = 'lf_person' and wp_posts.post_status = 'publish' and wp_term_relationships.term_taxonomy_id=235;" );
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' Ambassadors';
	} else {
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' Ambassadors';
	}
	?>
</p>
<div class="people-wrapper">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		get_template_part( 'components/people-block' );
		?>
	<?php endwhile; ?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;

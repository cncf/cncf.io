<?php
/**
 * Search & Filter Pro
 *
 * Ambassadors
 *
 * @package    WordPress
 * @subpackage cncf-theme
 * @since      1.0.0
 */

wp_enqueue_script(
	'modal',
	get_template_directory_uri() . '/source/js/on-demand/modal.js',
	array( 'jquery' ),
	filemtime( get_template_directory() . '/source/js/on-demand/modal.js' ),
	true
);

wp_enqueue_style( 'wp-block-separator' );

if ( $query->have_posts() ) :
	$query_term = $query->query['tax_query'][0]['terms'][0];
	if ( 1513 == $query_term ) {
		$query_cat = 'Kubestronauts';
	} else {
		$query_cat = 'Ambassadors';
	}
	?>
<p class="search-filter-results-count">
	<?php
	$full_count = $wpdb->get_var( $wpdb->prepare( "select count(*) from wp_posts inner join wp_term_relationships on id = object_id where wp_posts.post_type = 'lf_person' and wp_posts.post_status = 'publish' and wp_term_relationships.term_taxonomy_id=%d;", $query_term ) );

	// if filter matches all.
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' ' . esc_html( $query_cat );
	} else {
		// else show partial count.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' ' . esc_html( $query_cat );
	}
	?>
</p>

<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<div class="people-wrapper">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		get_template_part( 'components/people-item', null, array( 'show_profile' => true ) );
		?>
	<?php endwhile; ?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;

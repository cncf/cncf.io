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
	$full_count = $wpdb->get_var( "SELECT COUNT(p.ID) AS post_count FROM wp_posts p JOIN wp_term_relationships tr ON (p.ID = tr.object_id) JOIN wp_term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) WHERE p.post_type = 'post' AND p.post_status = 'publish' AND tt.taxonomy = 'category' AND tt.term_id = 230" );

	// if filter matches all.
	if ( $full_count <= $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' posts';
	} else {
		// else show partial count.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' posts';
	}
	?>
</p>
<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<div class="columns-one">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		get_template_part(
			'components/news-item',
			null,
			array(
				'is_featured'    => false,
				'is_sticky'      => null,
				'is_in_the_news' => false,
				'is_blog'        => true,
			)
		);
	endwhile;
	?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;

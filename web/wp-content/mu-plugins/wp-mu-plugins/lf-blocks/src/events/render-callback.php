<?php
/**
 * Render Callback
 *
 * @package WordPress
 * @subpackage lf-blocks
 * @since 1.0.0
 */

/**
 * Render the block
 *
 * @param array $attributes Block attributes.
 * @return object block_content Output.
 */
function lf_events_render_callback( $attributes ) {
	// get the quantity to display, if not default.
	$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 3;

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// get the category to display.
	$category_id = isset( $attributes['category'] ) ? $attributes['category'] : '';

	if ( $category_id ) {
		$category_selected = get_term_by( 'id', $category_id, 'lf-event-host' );
	} else {
		$category_selected = '';
	}

	// setup the arguments.
	$args = array(
		'posts_per_page' => $quantity,
		'post_type'      => array( 'lf_event' ),
		'post_status'    => array( 'publish' ),
		'meta_key'       => 'lf_event_date_start',
		'order'          => 'ASC',
		'meta_type'      => 'DATETIME',
		'orderby'        => 'meta_value',
		'no_found_rows'  => true,
		'meta_query'     => array(
			array(
				'key'     => 'lf_event_date_end',
				'value'   => date_i18n( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATETIME',
			),
		),
	);

	// if the host has been set, add the tax.
	if ( $category_selected && isset( $category_selected ) ) {

		$args['tax_query'] = array(
			array(
				'taxonomy' => 'lf-event-host',
				'field'    => 'slug',
				'terms'    => $category_selected,
			),
		);
	}

	$query = new WP_Query( $args );

	// if no posts.
	if ( ! $query->have_posts() ) {
		return '<h3>Sorry, there are no events to show right now.</h3>';
	}

	ob_start();
	?>
<div
	class="wp-block-lf-events events columns-three <?php echo esc_html( $classes ); ?>">
	<?php

	while ( $query->have_posts() ) :
		$query->the_post();
		get_template_part( 'components/event-item' );
endwhile;
	wp_reset_postdata();
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

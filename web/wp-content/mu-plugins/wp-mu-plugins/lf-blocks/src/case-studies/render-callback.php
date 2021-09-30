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
function lf_case_studies_render_callback( $attributes ) {

	// get the quantity to display, if not default.
	$quantity = isset( $attributes['numberposts'] ) ? $attributes['numberposts'] : 4;
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// setup the arguments.
	$args = array(
		'posts_per_page'     => $quantity,
		'post_type'          => array( 'lf_case_study' ),
		'post_status'        => array( 'publish' ),
		'order'              => 'DESC',
		'orderby'            => 'date',
		'no_found_rows'      => true,
	);

	$query = new WP_Query( $args );

	// if no posts.
	if ( ! $query->have_posts() ) {
		return 'Sorry, there are no posts.';
	}

	ob_start();
	?>
<section
	class="wp-block-lf-case-studies <?php echo esc_html( $classes ); ?>">
	<div class="case-studies-wrapper">

	<?php

	while ( $query->have_posts() ) :
		$query->the_post();

		get_template_part( 'components/case-study-item' );
endwhile;
	wp_reset_postdata();
	?>
</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

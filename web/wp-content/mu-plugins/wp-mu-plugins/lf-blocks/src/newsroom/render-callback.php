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
function lf_newsroom_render_callback( $attributes ) {
	$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 3;
	$category        = isset( $attributes['category'] ) && (int) $attributes['category'] ? $attributes['category'] : '230';
	$author_category = isset( $attributes['authorCategory'] ) && (int) $attributes['authorCategory'] ? $attributes['authorCategory'] : null;
	$order = isset( $attributes['order'] ) ? $attributes['order'] : 'DESC';
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// setup the arguments.
	$args = array(
		'posts_per_page'      => $quantity,
		'order'               => $order,
		'post_type'           => array( 'post' ),
		'post_status'         => array( 'publish' ),
		'has_password'        => false,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'no_found_rows'       => true,
		'tax_query'           => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $category,
			),
		),
	);

	if ( $author_category ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'lf-author-category',
			'field'    => 'term_id',
			'terms'    => $author_category,
		);
	}

	$query = new WP_Query( $args );

	// if no posts.
	if ( ! $query->have_posts() && ! $sticky_post ) {
		return 'Sorry, there are no posts.';
	}

	ob_start();
	?>
<section class="wp-block-lf-newsroom columns-three <?php echo esc_html( $classes ); ?>">

	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		get_template_part( 'components/news-item-vertical' );
	endwhile;

	wp_reset_postdata();
	?>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

/**
 * Register REST field for post featured image.
 */
function lf_newsroom_block_register_rest_fields() {
	// Add Featured image.
	register_rest_field(
		'post',
		'featured_image_src',
		array(
			'get_callback'    => 'lf_newsroom_block_get_image_src_landscape',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}
add_action( 'rest_api_init', 'lf_newsroom_block_register_rest_fields' );

/**
 * Get post featured image URL for REST.
 *
 * @param array  $object Block attributes.
 * @param string $field_name Name of field.
 * @param string $request Request.
 * @return object $feat_img_array Output.
 */
function lf_newsroom_block_get_image_src_landscape( $object, $field_name, $request ) {

	$feat_img_array = wp_get_attachment_image_src(
		$object['featured_media'],
		'newsroom-388',
		false
	);
	return $feat_img_array[0] ?? null;
}

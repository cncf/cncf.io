<?php
/**
 * Render Callback
 *
 * @package WordPress
 * @subpackage cncf-blocks
 * @since 1.0.0
 */

/**
 * Render the block
 *
 * @param array $attributes Block attributes.
 * @return object block_content Output.
 */
function lf_newsroom_render_callback( $attributes ) {
	// get the quantity to display, if not default.
	$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 4;
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// get the category to display.
	$category = isset( $attributes['category'] ) ? $attributes['category'] : 'blog';
	// show images or not.
	$show_images = isset( $attributes['showImages'] ) ? $attributes['showImages'] : '';
	// order of posts.
	$order = isset( $attributes['order'] ) ? $attributes['order'] : 'DESC';

	// setup the arguments.
	$args  = array(
		'posts_per_page'      => $quantity,
		'post_type'           => array( 'post' ),
		'post_status'         => array( 'publish' ),
		'has_password'        => false,
		'ignore_sticky_posts' => true,
		'order'               => $order,
		'orderby'             => 'date',
		'no_found_rows'       => true,
		'tax_query'           => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $category,
			),
		),
	);
	$query = new WP_Query( $args );
	ob_start();
	// if no posts.
	if ( ! $query->have_posts() ) {
		echo 'Sorry, there are no posts.';
		return;
	}
	?>
<section class="wp-block-lf-newsroom <?php echo esc_html( $classes ); ?>">

	<?php
	// setup options.
	$options = get_option( 'cncf-mu' );
	while ( $query->have_posts() ) :
		$query->the_post();
		?>
	<div class="newsroom-post-wrapper">
		<div class="newsroom-image-wrapper">
			<a class="box-link" href="<?php the_permalink(); ?>"
				title="<?php the_title(); ?>"></a>
				<?php
				if ( $show_images ) {
					if ( has_post_thumbnail() ) {
						echo wp_get_attachment_image( get_post_thumbnail_id(), 'newsroom-image', false, array( 'class' => 'newsroom-image' ) );
					} elseif ( isset( $options['generic_thumb_id'] ) && $options['generic_thumb_id'] ) {
						echo wp_get_attachment_image( $options['generic_thumb_id'], 'newsroom-image', false, array( 'class' => 'newsroom-image' ) );
					} else {
						echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
						. '/images/thumbnail-default.svg" alt="CNCF" class="newsroom-image"/>';
					}
				}
				?>
		</div>

		<p class="newsroom-title"><a href="<?php the_permalink(); ?>"
				title="<?php the_title(); ?>">
				<?php the_title(); ?>
			</a></p>
		<span class="newsroom-date date-icon"> <?php echo get_the_date( 'j F Y' ); ?></span>
	</div>
		<?php
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
	// Add Featued image.
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
		'newsroom-image',
		false
	);
	return $feat_img_array[0];
}

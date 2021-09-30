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
	// get the quantity to display, if not default.
	$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 4;
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// get the category to display.
	$category = isset( $attributes['category'] ) ? $attributes['category'] : 'blog';
	// show images or not.
	$show_images = isset( $attributes['showImages'] ) ? $attributes['showImages'] : '';
	// show image border or not.
	$show_border = isset( $attributes['showBorder'] ) ? $attributes['showBorder'] : '';
	// order of posts.
	$order = isset( $attributes['order'] ) ? $attributes['order'] : 'DESC';

	// get sticky posts.
	$sticky_post = null;
	$sticky      = get_option( 'sticky_posts' );
	if ( $sticky ) {
		$args        = array(
			'posts_per_page'      => 1,
			'post_type'           => array( 'post' ),
			'post_status'         => array( 'publish' ),
			'has_password'        => false,
			'post__in'            => $sticky,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'tax_query'           => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $category,
				),
			),
		);
		$stickyquery = new WP_Query( $args );

		if ( $stickyquery->have_posts() ) {
			$stickyquery->the_post();
			--$quantity;
			$sticky_post = get_the_ID();
		}
	}

	// setup the arguments.
	$args = array(
		'posts_per_page'      => $quantity,
		'post_type'           => array( 'post' ),
		'post_status'         => array( 'publish' ),
		'has_password'        => false,
		'ignore_sticky_posts' => true,
		'post__not_in'        => array( $sticky_post ),
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

	// if no posts.
	if ( ! $query->have_posts() && ! $sticky_post ) {
		return 'Sorry, there are no posts.';
	}

	if ( $show_border ) {
		$classes .= ' has-images-border';
	}

	ob_start();
	?>
<section class="wp-block-lf-newsroom <?php echo esc_html( $classes ); ?>">

	<?php
	if ( $sticky_post ) {
		lf_newsroom_show_post( $sticky_post, $show_images, true );
	}

	if ( $quantity > 0 ) :
		while ( $query->have_posts() ) :
			$query->the_post();
			lf_newsroom_show_post( get_the_ID(), $show_images, false );
	endwhile;
endif;
	wp_reset_postdata();
	?>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

/**
 * Displays a post.
 *
 * @param int     $lf_post ID of post to display.
 * @param boolean $show_images Whether to show images.
 * @param boolean $sticky Whether the post is sticky.
 */
function lf_newsroom_show_post( $lf_post, $show_images, $sticky = false ) {
	if ( ! $lf_post ) {
		return;
	}
	$options = get_option( 'lf-mu' );
	if ( $sticky ) {
		$sticky_class = 'sticky';
	} else {
		$sticky_class = '';
	}

	// get the correct link for the block.
	if ( in_category( 'news', $lf_post ) ) {
		$correct_link = get_post_meta( get_the_ID( $lf_post ), 'lf_post_external_url', true ) ? get_post_meta( get_the_ID( $lf_post ), 'lf_post_external_url', true ) : '';
	} else {
		$correct_link = get_permalink( $lf_post );
	}

	?>
<div class="newsroom-post-wrapper <?php echo esc_attr( $sticky_class ); ?>">

	<?php
	if ( $show_images ) :
		?>
	<div class="newsroom-image-wrapper">

		<?php
		if ( in_category( 'news', $lf_post ) || ( get_post_meta( get_the_ID( $lf_post ), 'lf_post_external_url', true ) ) ) {
			?>

		<a class="box-link" href="<?php echo esc_url( $correct_link ); ?>" target="_blank"
			title="<?php echo esc_attr( get_the_title( $lf_post ) ); ?>"></a>
			<?php
			if ( has_post_thumbnail( $lf_post ) ) {
				echo wp_get_attachment_image( get_post_thumbnail_id( $lf_post ), 'newsroom-media-coverage', false, array( 'class' => 'media-logo' ) );
			} else {
				echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
				. '/images/thumbnail-default.svg" alt="CNCF Media Coverage" />';
			}
		} else {
			?>
		<a class="box-link" href="<?php echo esc_url( $correct_link ); ?>"
			title="<?php echo esc_attr( get_the_title( $lf_post ) ); ?>"></a>

			<?php
			if ( has_post_thumbnail( $lf_post ) ) {
				Lf_Utils::display_responsive_images( get_post_thumbnail_id( $lf_post ), 'newsroom-540', '540px', 'archive-image' );
			} elseif ( isset( $options['generic_thumb_id'] ) && $options['generic_thumb_id'] ) {
				Lf_Utils::display_responsive_images( $options['generic_thumb_id'], 'newsroom-540', '540px', 'archive-default-svg' );
			} else {
				echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
				. '/images/thumbnail-default.svg" alt="' . esc_attr( lf_blocks_get_site() ) . '" class="archive-default-svg"/>';
			}
		}
		?>
	</div>
		<?php
	endif; // end of show images.
	?>

	<?php
	if ( in_category( 'news', $lf_post ) && ( get_post_meta( get_the_ID( $lf_post ), 'lf_post_external_url', true ) ) ) {
		?>
	<h5 class="newsroom-title"><a class="external is-primary-color"
			target="_blank" rel="noopener"
			href="<?php echo esc_url( $correct_link ); ?>"
			title="<?php echo esc_attr( get_the_title( $lf_post ) ); ?>">
			<?php echo esc_html( get_the_title( $lf_post ) ); ?>
		</a></h5>
		<?php
	} else {
		?>
	<h5 class="newsroom-title"><a href="<?php echo esc_url( $correct_link ); ?>"
			title="<?php echo esc_attr( get_the_title( $lf_post ) ); ?>">
			<?php echo esc_html( get_the_title( $lf_post ) ); ?>
		</a></h5>
		<?php
	}
	?>

	<span class="newsroom-date date-icon">
		<?php echo get_the_date( 'F j, Y', $lf_post ); ?></span>
</div>
	<?php
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
		'newsroom-325',
		false
	);
	return $feat_img_array[0] ?? null;
}

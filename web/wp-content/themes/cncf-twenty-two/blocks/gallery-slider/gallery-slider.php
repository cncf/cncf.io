<?php
/**
 * Gallery Slider Block
 *
 * @package WordPress
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// UPDATE this name for block same as in register.
$block_name = 'gallery-slider';

// Create full block name to use in classes.
$block_name = 'wp-block-acf-' . $block_name;

$align = ( empty( $block['align'] ) ) ? '' : 'align' . $block['align'];

$additional_classes = $block['className'] ?? '';

$classes = LF_Utils::merge_classes(
	array(
		$block_name,
		$align,
		$additional_classes,
	)
);

// Don't load scripts in admin area.
if ( ! is_admin() ) {
	// load slick css.
	wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

	// load main slick.
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/libraries/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/slick.min.js' ), true );

	// slick config scripts.
	wp_enqueue_script( 'gallery-slider', get_template_directory_uri() . '/blocks/gallery-slider/gallery-slider.js', array( 'jquery', 'slick' ), filemtime( get_template_directory() . '/blocks/gallery-slider/gallery-slider.js' ), true );
}

if ( have_rows( 'selected_slider_images' ) ) :
	?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<div class="wp-block-acf-gallery-slider__wrapper">
	<?php
	while ( have_rows( 'selected_slider_images' ) ) :
		the_row();
		$slider_image_id    = get_sub_field( 'slider_image' );
		$slider_description = get_sub_field( 'slider_description' ) ?? 'CNCF Photo';
		?>
		<div>
		<?php LF_Utils::display_responsive_images( $slider_image_id, 'newsroom-post-width', '700px', null, 'lazy', $slider_description ); ?>
		</div>
			<?php
		endwhile;
	?>
	</div>

	<div class="wp-block-acf-gallery-slider__controls">
		<button class="button-reset wp-block-acf-gallery-slider__controls-prev"><svg width="12"
				height="19" viewBox="0 0 12 19" fill="none"
				xmlns="http://www.w3.org/2000/svg">
				<path d="M10.4131 17.627L2.41309 9.62695L10.4131 1.62695"
					stroke="black" stroke-width="3" />
			</svg>
			<span class="screen-reader-text">Previous
				Photo</span>
		</button>
		<button class="button-reset wp-block-acf-gallery-slider__controls-next">
			<svg width="12" height="19" viewBox="0 0 12 19" fill="none"
				xmlns="http://www.w3.org/2000/svg">
				<path d="M1.41309 1.62695L9.41309 9.62695L1.41309 17.627"
					stroke="black" stroke-width="3" />
			</svg>
			<span class="screen-reader-text">Next
				Photo</span>
		</button>
	</div>
</div>
	<?php
endif;

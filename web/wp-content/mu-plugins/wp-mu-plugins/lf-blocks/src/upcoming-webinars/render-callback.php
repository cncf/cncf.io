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
function lf_upcoming_webinars_render_callback( $attributes ) {

	// get the quantity to display, if not default.
	$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 4;

	// show images or not.
	$show_images = isset( $attributes['showImages'] ) ? $attributes['showImages'] : '';

	// show image border or not.
	$show_border = isset( $attributes['showBorder'] ) ? $attributes['showBorder'] : '';

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// setup the arguments.
	$args  = array(
		'posts_per_page' => $quantity,
		'post_type'      => array( 'lf_webinar' ),
		'post_status'    => array( 'publish' ),
		'meta_key'       => 'lf_webinar_date',
		'order'          => 'ASC',
		'meta_type'      => 'DATETIME',
		'orderby'        => 'meta_value',
		'no_found_rows'  => true,
		'meta_query'     => array(
			array(
				'key'     => 'lf_webinar_date',
				'value'   => date_i18n( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATETIME',
			),
			array(
				'key'     => 'lf_webinar_recording',
				'compare' => 'NOT EXISTS',
			),
		),
	);
	$query = new WP_Query( $args );

	if ( $show_border ) {
		$classes .= ' has-images-border';
	}

	ob_start();

	if ( $query->have_posts() ) {
		?>

<section
class="wp-block-lf-upcoming-webinars <?php echo esc_html( $classes ); ?>">
<div class="webinars-upcoming-wrapper">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part(
				'components/upcoming-webinars-item',
				null,
				array(
					'show_images' => $show_images,
				)
			);
endwhile;
		wp_reset_postdata();
		?>
</div>
</section>
		<?php

	} else {
		?>
 <p class="is-style-max-width-100 italic">New webinars coming soon. <a href="#newsletter" title="Sign up for newsletter">Sign up for our newsletter to stay informed</a>.</p>
		<?php
	}

	$block_content = ob_get_clean();
	return $block_content;
}

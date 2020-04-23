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
function lf_upcoming_webinars_render_callback( $attributes ) {

	// get the quantity to display, if not default.
	$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 4;

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// setup the arguments.
	$args  = array(
		'posts_per_page'     => $quantity,
		'ignore_custom_sort' => true,
		'post_type'          => array( 'cncf_webinar' ),
		'post_status'        => array( 'publish' ),
		'meta_key'           => 'cncf_webinar_date',
		'order'              => 'ASC',
		'orderby'            => 'meta_value',
		'no_found_rows'      => true,
		'meta_query'         => array(
			array(
				'key'     => 'cncf_webinar_date',
				'value'   => date_i18n( 'Y-m-d' ),
				'compare' => '>=',
			),
			array(
				'key'     => 'cncf_webinar_recording',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
		),
	);
	$query = new WP_Query( $args );
	ob_start();

	// if no upcoming webinars.
	if ( ! $query->have_posts() ) {
		return;
	}
	?>

<section
class="wp-block-lf-upcoming-webinars <?php echo esc_html( $classes ); ?>">
<div class="webinars-upcoming-wrapper">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

		get_template_part( 'components/upcoming-webinars-item' );

endwhile;
	wp_reset_postdata();
	?>
</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

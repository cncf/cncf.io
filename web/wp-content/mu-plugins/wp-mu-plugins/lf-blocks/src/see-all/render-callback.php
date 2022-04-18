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
 * @param array  $attributes Block attributes.
 * @param string $content Block content.
 * @return object block_content Output.
 */
function lf_see_all_render_callback( $attributes, $content ) {

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	ob_start();
	?>
<section class="see-all <?php echo esc_html( $classes ); ?>">

See All block

</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

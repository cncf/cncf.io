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
function lf_guest_author_render_callback( $attributes ) {
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// get content.
	$content = isset( $attributes['content'] ) ? $attributes['content'] : '';

	if ( ! $content ) {
		return;
	}

	ob_start();
	?>
<section class="wp-block-lf-guest-author <?php echo esc_html( $classes ); ?>">

	<p><span>Guest post by: </span><?php echo wp_kses_post( $content ); ?></p>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

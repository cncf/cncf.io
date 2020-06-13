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
function lf_twitter_feed_render_callback( $attributes ) {
	// get the quantity to display, if not default.
	$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 4;
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';
	ob_start();
	?>
<section class="wp-block-lf-twitter-feed <?php echo esc_html( $classes ); ?>">
	<div class="tf-wrapper">
		<div class="twitter-item">
			<a id="twitter" class="twitter-timeline" data-tweet-limit="<?php echo esc_html( $quantity ); ?>"
				data-chrome="nofooter noheader noborders noscrollbar transparent dnt"
				href="https://twitter.com/CloudNativeFdn?ref_src=twsrc%5Etfw"></a>
		</div>
	</div>
</section>
	<?php
		$block_content = ob_get_clean();
		return $block_content;
}

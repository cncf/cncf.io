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
function lf_landscape_render_callback( $attributes ) {
	// get iframe src.
	$iframe_src = isset( $attributes['iframeSrc'] ) ? $attributes['iframeSrc'] : '';
	// get iframe width.
	$iframe_width = isset( $attributes['iframeWidth'] ) ? $attributes['iframeWidth'] : '1px';
	// get iframe id if set.
	$iframe_id = isset( $attributes['iframeId'] ) ? $attributes['iframeId'] : '';
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// stop if no URL set.
	if ( ! $iframe_src ) {
		return;
	}

	ob_start();

	$iframe_styles = 'width: ' . $iframe_width . ' ; min-width: 100%;'; // phpcs:ignore.

	if ( $iframe_id ) {

		wp_register_script( 'landscape-override', false, array(), false, false ); // phpcs:ignore.
		wp_enqueue_script( 'landscape-override' );

		$landscape_override = "document.addEventListener('DOMContentLoaded', function() {
			iFrameResize({
			  log: false,
			  onMessage : function(messageData){
				if (messageData.message.type === 'showModal') {
				  document.querySelector('body').style.overflow = 'hidden';
				}
				if (messageData.message.type === 'hideModal') {
				  document.querySelector('body').style.overflow = 'auto';
				}
			  },
			}, '#" . $iframe_id . "');
		  });";

		// Then add the inline styles to it.
		wp_add_inline_script( 'landscape-override', $landscape_override );

	}
	?>

<iframe
title="landscape"
id="<?php echo ( $iframe_id ? esc_html( $iframe_id ) : 'landscape' ); // phpcs:ignore. ?>"
src="<?php echo esc_url( $iframe_src ); ?>"
frameBorder="0"
scrolling="no"
class="iframe-container <?php echo esc_html( $classes ); ?>"
style="<?php echo $iframe_styles; // phpcs:ignore. ?>"
></iframe>

	<?php
		$block_content = ob_get_clean();
		return $block_content;
}

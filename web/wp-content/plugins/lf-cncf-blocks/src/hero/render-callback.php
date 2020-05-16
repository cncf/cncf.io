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
 * @param array  $attributes Block attributes.
 * @param string $content Block content.
 * @return object block_content Output.
 */
function lf_hero_render_callback( $attributes, $content ) {

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	ob_start();
	?>
<section
	class="hero background-image-wrapper alignfull <?php echo esc_html( $classes ); ?>">

	<figure class="background-image-figure">
		<?php
		if ( has_post_thumbnail() ) {
					echo wp_get_attachment_image( get_post_thumbnail_id(), 'full', false, array( 'class' => '' ) );
		} else {
			echo '<img src="/wp-content/uploads/2020/02/welcome.jpg" alt="">';
		}
		?>
	</figure>

	<div class="container wrap background-image-text-overlay">
		<div>
			<p class="hero-parent-link"><a href="/case-studies/"
					title="Go to Case Studies">Case Study</a></p>
			<?php echo wp_kses_post( $content ); ?>
		</div>
	</div>
</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

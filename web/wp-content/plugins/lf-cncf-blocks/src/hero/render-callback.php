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

	// setup options.
	$options = get_option( 'cncf-mu' );

	ob_start();
	?>
<section
class="hero background-image-wrapper alignfull <?php echo esc_html( $classes ); ?>">

<figure class="background-image-figure">
<?php
	if ( has_post_thumbnail() ) {
		echo wp_get_attachment_image( get_post_thumbnail_id(), 'full', false, false );
	} elseif ( isset( $options['generic_hero_id'] ) && $options['generic_hero_id'] ) {
		echo wp_get_attachment_image( $options['generic_hero_id'], 'full', false, false );
	} else {
		echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
		. '/images/hero-default.jpg" alt="CNCF" height="400" width="100%"/>';
	}
	?>
</figure>

<div class="container wrap background-image-text-overlay">
<div>
<p class="hero-parent-link">
	<?php
	if ( is_singular( 'cncf_case_study' ) ) :
		?>
<a href="/case-studies/" title="Go to Case Studies">Case
Study</a>
		<?php
elseif ( is_singular( 'cncf_case_study_ch' ) ) :
	?>
<a href="/case-studies-cn/" title="最终用户案例研究">最终用户案例研究</a>
	<?php
elseif ( is_singular( 'cncf_webinar' ) ) :
	?>
<a href="/webinars/" title="Go to Webinars">Webinar</a>

	<?php
else :
	echo '';
endif;
?>
</p>
	<?php echo wp_kses_post( $content ); ?>
</div>
</div>
</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

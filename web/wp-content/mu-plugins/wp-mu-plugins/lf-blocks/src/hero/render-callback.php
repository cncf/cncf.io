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
function lf_hero_render_callback( $attributes, $content ) {

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	ob_start();
	?>
<section class="hero alignfull <?php echo esc_html( $classes ); ?>">

<figure class="hero__figure">
	<?php
	if ( has_post_thumbnail() ) {
		Lf_Utils::display_picture( get_post_thumbnail_id(), 'hero', 'hero__image' );
	} else {
		// setup site options.
		$site_options = get_option( 'lf-mu' );
		Lf_Utils::display_picture( $site_options['generic_hero_id'], 'hero', 'hero__image' );
	}
	?>
</figure>

<div class="container wrap hero__text-overlay title-wrapper">

<span>
	<?php
	if ( is_singular( 'lf_case_study' ) ) :
		?>
<a class="parent-link has-text-color has-white-text" href="/case-studies/" title="Go to Case Studies">Case
Study</a>
		<?php
elseif ( is_singular( 'lf_case_study_cn' ) ) :
	?>
<a class="parent-link has-text-color has-white-text" href="/case-studies-cn/" title="最终用户案例研究">最终用户案例研究</a>
	<?php
endif;
?>
</span>

<h1 class="is-style-case-study-title"><?php the_title(); ?></h1>

</div>
</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

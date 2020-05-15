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
function lf_case_study_highlights_render_callback( $attributes ) {
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// get content.
	$highlight01 = isset( $attributes['highlight01'] ) ? $attributes['highlight01'] : '';
	$highlight02 = isset( $attributes['highlight02'] ) ? $attributes['highlight02'] : '';
	$highlight03 = isset( $attributes['highlight03'] ) ? $attributes['highlight03'] : '';

	$projects = get_the_terms( get_the_ID(), 'cncf-project' );

	ob_start();
	?>
<section class="wp-block-lf-case-study-highlights <?php echo esc_html( $classes ); ?>">

<div class="case-study-highlights alignfull is-style-blue-pink-gradient ">
<div class="container case-study-highlights-wrapper">
	<?php if ( ! empty( $projects ) && ! is_wp_error( $projects ) ) { ?>
<div style="align-content: center">
<h3>CNCF Projects Used</h3>
<div class="margin-top-small">
		<?php
		// TODO - Switch out to embedded SVG or link to projects.
		foreach ( $projects as $project ) {
			?>
<div class="project-icon">
<img src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/images/projects/' . esc_html( $project->slug ) . '-icon-white.svg'; ?>"
alt="<?php echo esc_html( $project->name ); ?>">
</div>
			<?php
		}
		?>
</div>
</div>
		<?php
	}
	?>
<div class="case-study-highlight-text"><?php echo wp_kses_post( $highlight01 ); ?></div>
<div class="case-study-highlight-text"><?php echo wp_kses_post( $highlight02 ); ?></div>
<div class="case-study-highlight-text"><?php echo wp_kses_post( $highlight03 ); ?></div>
</div></div>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

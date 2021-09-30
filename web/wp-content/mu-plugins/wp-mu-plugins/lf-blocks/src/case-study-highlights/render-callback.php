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
function lf_case_study_highlights_render_callback( $attributes ) {
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// get content.
	$heading_text01   = isset( $attributes['headingText01'] ) ? $attributes['headingText01'] : '';
	$heading_text02   = isset( $attributes['headingText02'] ) ? $attributes['headingText02'] : '';
	$heading_text03   = isset( $attributes['headingText03'] ) ? $attributes['headingText03'] : '';
	$highlight_stat01 = isset( $attributes['smallerText01'] ) ? $attributes['smallerText01'] : '';
	$highlight_stat02 = isset( $attributes['smallerText02'] ) ? $attributes['smallerText02'] : '';
	$highlight_stat03 = isset( $attributes['smallerText03'] ) ? $attributes['smallerText03'] : '';

	if ( is_singular( 'lf_case_study_cn' ) ) {
		$highlights_title = '一些数据...';
	} else {
		$highlights_title = 'By the numbers...';
	}

	ob_start();
	?>
<section class="wp-block-lf-case-study-highlights <?php echo esc_html( $classes ); ?>">

<div class="case-study-highlights">
<div class="container">
	<?php if ( $highlights_title ) : ?>
<h2 class="case-study-highlights-title"><?php echo esc_html( $highlights_title ); ?></h2>
	<?php endif; ?>
<div class="case-study-highlights-wrapper">
<div class="case-study-highlight-text">
	<?php if ( $heading_text01 ) : ?>
<p class="case-study-highlight-heading"><?php echo wp_kses_post( $heading_text01 ); ?></p>
		<?php
endif;
	if ( $highlight_stat01 ) :
		?>
<h3 class="case-study-highlight-stat"><?php echo wp_kses_post( $highlight_stat01 ); ?></h3>
<?php endif; ?>
</div>
<div class="case-study-highlight-text">
	<?php if ( $heading_text02 ) : ?>
<p class="case-study-highlight-heading"><?php echo wp_kses_post( $heading_text02 ); ?></p>
		<?php
endif;
	if ( $highlight_stat02 ) :
		?>
<h3 class="case-study-highlight-stat"><?php echo wp_kses_post( $highlight_stat02 ); ?></h3>
<?php endif; ?>
</div>
<div class="case-study-highlight-text">
	<?php if ( $heading_text03 ) : ?>
<p class="case-study-highlight-heading"><?php echo wp_kses_post( $heading_text03 ); ?></p>
		<?php
endif;
	if ( $highlight_stat03 ) :
		?>
<h3 class="case-study-highlight-stat"><?php echo wp_kses_post( $highlight_stat03 ); ?></h3>
<?php endif; ?>
</div>
</div>
</div>
</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

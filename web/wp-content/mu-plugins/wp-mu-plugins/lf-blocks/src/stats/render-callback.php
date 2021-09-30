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
function lf_stats_block_render_callback( $attributes ) {
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// get content.
	$heading_stat01 = isset( $attributes['headingStat01'] ) ? $attributes['headingStat01'] : '';
	$heading_stat02 = isset( $attributes['headingStat02'] ) ? $attributes['headingStat02'] : '';
	$heading_stat03 = isset( $attributes['headingStat03'] ) ? $attributes['headingStat03'] : '';
	$heading_stat04 = isset( $attributes['headingStat04'] ) ? $attributes['headingStat04'] : '';
	$heading_stat05 = isset( $attributes['headingStat05'] ) ? $attributes['headingStat05'] : '';
	$smaller_stat01 = isset( $attributes['smallerStat01'] ) ? $attributes['smallerStat01'] : '';
	$smaller_stat02 = isset( $attributes['smallerStat02'] ) ? $attributes['smallerStat02'] : '';
	$smaller_stat03 = isset( $attributes['smallerStat03'] ) ? $attributes['smallerStat03'] : '';
	$smaller_stat04 = isset( $attributes['smallerStat04'] ) ? $attributes['smallerStat04'] : '';
	$smaller_stat05 = isset( $attributes['smallerStat05'] ) ? $attributes['smallerStat05'] : '';

	ob_start();
	?>
<section class="wp-block-lf-stats-block <?php echo esc_html( $classes ); ?>">

<div class="stats-block">
<div class="container stats-block-wrapper">

<div>
	<?php if ( $heading_stat01 ) : ?>
<span class="stat-header"><?php echo wp_kses_post( $heading_stat01 ); ?></span>
		<?php
endif;
	if ( $smaller_stat01 ) :
		?>
<span><?php echo wp_kses_post( $smaller_stat01 ); ?></span>
	<?php endif; ?>
</div>

<div>
	<?php if ( $heading_stat02 ) : ?>
<span class="stat-header"><?php echo wp_kses_post( $heading_stat02 ); ?></span>
		<?php
endif;
	if ( $smaller_stat02 ) :
		?>
<span><?php echo wp_kses_post( $smaller_stat02 ); ?></span>
	<?php endif; ?>
</div>

<div>
	<?php if ( $heading_stat03 ) : ?>
<span class="stat-header"><?php echo wp_kses_post( $heading_stat03 ); ?></span>
		<?php
endif;
	if ( $smaller_stat03 ) :
		?>
<span><?php echo wp_kses_post( $smaller_stat03 ); ?></span>
	<?php endif; ?>
</div>

<div>
	<?php if ( $heading_stat04 ) : ?>
<span class="stat-header"><?php echo wp_kses_post( $heading_stat04 ); ?></span>
		<?php
endif;
	if ( $smaller_stat04 ) :
		?>
<span><?php echo wp_kses_post( $smaller_stat04 ); ?></span>
	<?php endif; ?>
</div>

<div>
	<?php if ( $heading_stat05 ) : ?>
<span class="stat-header"><?php echo wp_kses_post( $heading_stat05 ); ?></span>
		<?php
endif;
	if ( $smaller_stat05 ) :
		?>
<span><?php echo wp_kses_post( $smaller_stat05 ); ?></span>
	<?php endif; ?>
</div>


</div>
</div>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}

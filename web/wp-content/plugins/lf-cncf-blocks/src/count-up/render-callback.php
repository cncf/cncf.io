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
function lf_count_up_render_callback( $attributes ) {
	$columns    = isset( $attributes['columns'] ) ? $attributes['columns'] : 1;
	$text_color = isset( $attributes['textColor'] ) ? $attributes['textColor'] : '#000000';

	ob_start();
	?>
<section data-element="count-up-block" class="count-up-block"
	style="--text-main-color: <?php echo esc_attr( $text_color ); ?>;">
	<div class="count-up-wrapper">
		<?php
		for ( $i = 1; $i <= $columns; $i++ ) :
			$number      = isset( $attributes[ "countUpNumber{$i}" ] ) ? $attributes[ "countUpNumber{$i}" ] : false;
			$image_id    = isset( $attributes[ "iconId{$i}" ] ) ? $attributes[ "iconId{$i}" ] : false;
			$description = isset( $attributes[ "descText{$i}" ] ) ? $attributes[ "descText{$i}" ] : false;
			$link        = isset( $attributes[ "link{$i}" ] ) ? $attributes[ "link{$i}" ] : false;
			$target      = isset( $attributes[ "target{$i}" ] ) ? $attributes[ "target{$i}" ] : false;

			if ( ! $number ) :
				continue;
			endif;

			if ( $target ) {
				$is_external = 'target="_blank" rel="noopener noreferrer"';
			} else {
				$is_external = '';
			}

			$original_number = $number;
			$number          = preg_replace( '/,|\./', '', $number );

			?>
		<div class="count-up-column">
			<?php
			if ( ! empty( $link ) ) :
				?>
			<a <?php echo esc_html( $is_external ); ?> href="<?php echo esc_url( $link ); ?>">
				<?php endif; ?>

			<?php if ( ! empty( $image_id ) ) { ?>
			<div class="icon-wrap">
				<?php
				echo wp_get_attachment_image( $image_id, 'medium' );
				?>
			</div>
			<?php } ?>
			<div class="text-wrap" data-mh="facts-text-wrap">
				<div class="number number-item h2" data-element="lf-number"
					data-original="<?php echo esc_html( $original_number ); ?>"
					data-to="<?php echo esc_html( $number ); ?>"
					data-speed="4000">
					0
				</div>
				<?php
				if ( ! empty( $description ) ) {
					?>
				<span
					class="count-up-description"><?php echo esc_html( $description ); ?></span>
					<?php
				}
				?>
			</div>
			<?php
			if ( ! empty( $link ) ) :
				?>
				</a>
				<?php
endif;
			?>
		</div>
		<?php endfor; ?>
	</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}


if ( ! function_exists( 'lf_checkout_inner_blocks' ) ) {

	/**
	 * Dealing with inner blocks
	 *
	 * @param array $block Block properties.
	 * @return array $current_blocks Blocks to show.
	 */
	function lf_checkout_inner_blocks( $block ) {
		static $current_blocks = array();

		$current = $block;

		if ( 'core/block' == $block['blockName'] ) {
			$current = parse_blocks( get_post_field( 'post_content', $block['attrs']['ref'] ) )[0];
		}

		if ( '' != $current['blockName'] ) {
			array_push( $current_blocks, $current );
			if ( count( $current['innerBlocks'] ) > 0 ) {
				foreach ( $current['innerBlocks'] as $inner_block ) {
					lf_checkout_inner_blocks( $inner_block );
				}
			}
		}

		return $current_blocks;
	}
}

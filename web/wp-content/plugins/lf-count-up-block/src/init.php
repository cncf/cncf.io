<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function lf_count_up_block_assets() { // phpcs:ignore
	// Register block editor script for backend.
	wp_register_script(
		'lf-count-up-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	wp_register_script(
		'lf-count-up-block-waypoints-js',
		plugins_url( '/src/block/front/waypoints.min.js', dirname( __FILE__ ) ),
		array(),
		'4.0.1',
		true
	);

	wp_register_script(
		'lf-count-up-block-countup-js',
		plugins_url( '/src/block/front/countup.js', dirname( __FILE__ ) ),
		array(),
		'2.0.4',
		true
	);

	wp_register_script(
		'lf-count-up-block-front-js',
		plugins_url( '/src/block/front/index.js', dirname( __FILE__ ) ),
		array( 'lf-count-up-block-countup-js', 'lf-count-up-block-waypoints-js' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'src/block/front/index.js' ),
		true
	);

	wp_register_style(
		'lf-count-up-block-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array(), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'lf-count-up-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'lf/count-up',
		array(
			'style'           => 'lf-count-up-block-style-css',
			'editor_script'   => 'lf-count-up-block-js',
			'editor_style'    => 'lf-count-up-block-editor-css',
			'render_callback' => 'lf_count_up_callback',
		)
	);
}

function lf_count_up_callback( $attributes ) { // phpcs:ignore
	$section_text    = isset( $attributes['sectionText'] ) ? $attributes['sectionText'] : false;
	$columns         = isset( $attributes['columns'] ) ? $attributes['columns'] : 1;
	$bg_first_color  = isset( $attributes['color1'] ) ? $attributes['color1'] : '';
	$bg_second_color = isset( $attributes['color2'] ) ? $attributes['color2'] : '';
	$text_color      = isset( $attributes['textColor'] ) ? $attributes['textColor'] : '#212326';

	switch ( $columns ) {
		case 1:
			$column_class = 'col-sm-12';
			break;
		case 2:
			$column_class = 'col-xs-12 col-sm-6';
			break;
		case 3:
			$column_class = 'col-xs-12 col-sm-6 col-md-4';
			break;
		case 4:
			$column_class = 'col-xxs-12 col-xs-6 col-sm-6 col-md-3';
			break;
	}

	ob_start();

	?>
	<section data-element="count-up-block" class="count-up-block" style="--bg-first-color: <?php echo esc_attr( $bg_first_color ); ?>; --bg-second-color: <?php echo esc_attr( $bg_second_color ); ?>; --text-main-color: <?php echo esc_attr( $text_color ); ?>;">
		<div class="container">
			<?php
			if ( ! empty( $section_text ) ) :
				echo apply_filters( 'the_content', $section_text ); // phpcs:ignore
			endif;
			?>
			<div>
				<div class="row">
				<?php
				for ( $i = 1; $i <= $columns; $i++ ) :
					$number      = isset( $attributes[ "countUpNumber{$i}" ] ) ? $attributes[ "countUpNumber{$i}" ] : false;
					$image_id    = isset( $attributes[ "iconId{$i}" ] ) ? $attributes[ "iconId{$i}" ] : false;
					$description = isset( $attributes[ "descText{$i}" ] ) ? $attributes[ "descText{$i}" ] : false;
					$link        = isset( $attributes[ "link{$i}" ] ) ? $attributes[ "link{$i}" ] : false;

					if ( ! $number ) :
						continue;
					endif;

					$original_number = $number;
					$number          = preg_replace( '/,|\./', '', $number );

					?>
					<div class="<?php echo esc_attr( $column_class ); ?>">
						<div>
							<?php if ( ! empty( $image_id ) ) : ?>
								<div class="icon-wrap">
									<?php
									if ( ! empty( $link ) ) :
										printf( '<a target="_blank" href="%s">', esc_url( $link ) );
									endif;

									echo wp_get_attachment_image( $image_id, 'medium' );

									if ( ! empty( $link ) ) :
										echo '</a>';
									endif;
									?>
								</div>
							<?php endif; ?>
							<div class="text-wrap" data-mh="facts-text-wrap">
								<?php
								if ( ! empty( $link ) ) :
									printf( '<a target="_blank" href="%s">', esc_url( $link ) );
								endif;
								?>
									<div class="number number-item"
										data-element="lf-number"
										data-original="<?php echo esc_html( $original_number ); ?>"
										data-to="<?php echo esc_html( $number ); ?>"
										data-speed="4000">
										0
									</div>
								<?php
								if ( ! empty( $link ) ) :
									echo '</a>';
								endif;
								?>
								<h6>
									<?php
									if ( ! empty( $link ) ) :
										printf( '<a target="_blank" href="%s">', esc_url( $link ) );
									endif;
										echo $description; // phpcs:ignore
									if ( ! empty( $link ) ) :
										echo '</a>';
									endif;
									?>
								</h6>
							</div>
						</div>
					</div>
				<?php endfor; ?>
				</div>
			</div>
		</div>
	</section>
	<?php

	return ob_get_clean();
}

function lf_count_up_add_frontend_assets() { // phpcs:ignore
	$present_blocks = lf_get_present_blocks();

	foreach ( $present_blocks as $block ) {
		if ( 'lf/count-up' == $block['blockName'] ) {
			wp_enqueue_script( 'lf-count-up-block-front-js' );
			break;
		}
	}
}

if ( ! function_exists( 'lf_checkout_inner_blocks' ) ) {
	function lf_checkout_inner_blocks( $block ) { // phpcs:ignore
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

if ( ! function_exists( 'lf_get_present_blocks' ) ) {
	function lf_get_present_blocks() { // phpcs:ignore
		$present_blocks = array();
		$posts_array    = get_post();

		if ( ! empty( $posts_array ) ) {
			foreach ( parse_blocks( $posts_array->post_content ) as $block ) {
				$present_blocks = lf_checkout_inner_blocks( $block );
			}
		}

		return $present_blocks;
	}
}

add_action( 'init', 'lf_count_up_block_assets' );
add_action( 'wp_enqueue_scripts', 'lf_count_up_add_frontend_assets' );

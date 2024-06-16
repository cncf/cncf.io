<?php
/**
 * Quote with Quote Mark Block
 *
 * This block was generated by create-acf-block-json.
 *
 * @package WordPress
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Block Name (sluggified).
$block_name = 'quote-with-image';

$namespace = 'lf';

// Create full block name to use in classes.
$block_name = 'wp-block-' . $namespace . '-' . $block_name;

// setup various classes sent through from $block.
$background = ( empty( $block['backgroundColor'] ) ) ? '' : 'has-' . $block['backgroundColor'] . '-background-color';

$has_background = $background ? 'has-background' : '';

$font_size = ( empty( $block['fontSize'] ) ) ? '' : 'has-' . $block['fontSize'] . '-font-size';

$align = ( empty( $block['align'] ) ) ? '' : 'align' . $block['align'];

$align_text = ( empty( $block['align_text'] ) ) ? '' : 'has-text-align-' . $block['align_text'];

$additional_classes = $block['className'] ?? '';

$all_classes = array(
	$block_name,
	$background,
	$has_background,
	$font_size,
	$align,
	$align_text,
	$additional_classes,
);

$classes = implode( ' ', $all_classes );

$quote_image_border_color = get_field( 'quote_image_border_color' ) ?? '#000000';
$quote_image_cite_line_1  = get_field( 'quote_image_cite_line_1' ) ?? null;
$quote_image_cite_line_2  = get_field( 'quote_image_cite_line_2' ) ?? null;
$quote_image_cite_line_3  = get_field( 'quote_image_cite_line_3' ) ?? null;
$quote_image_id           = get_field( 'quote_image_id' ) ?? null;

$allowed_inner_blocks = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'This is a quote',
			'className'   => 'wp-block-lf-quote-with-image__quote',
		),
	),
);
?>

<style>
	html .wp-block-lf-quote-with-image:not(.block-editor-block-list__block) {
		border-left: 5px solid <?php echo esc_html( $quote_image_border_color ); ?>;
	}
</style>

<div class="<?php echo esc_attr( $classes ); ?>">
	<?php
		echo '<InnerBlocks template="' . esc_attr( wp_json_encode( $allowed_inner_blocks ) ) . '" templateLock=true />';
	?>
	<div class="wp-block-lf-quote-with-image__align">

	<?php
	if ( $quote_image_id ) :
		LF_Utils::display_responsive_images( esc_html( $quote_image_id ), 'medium', '148px', 'wp-block-lf-quote-with-image__image', 'lazy', esc_attr( $quote_image_cite_line_1 ) );
	endif;
	?>

		<div class="wp-block-lf-quote-with-image__cite">
			<?php if ( $quote_image_cite_line_1 ) : ?>
				<p class="wp-block-lf-quote-with-image__name"><?php echo esc_html( $quote_image_cite_line_1 ); ?></p>
			<?php endif; ?>
			<?php if ( $quote_image_cite_line_2 ) : ?>
			<p class="wp-block-lf-quote-with-image__position"><?php echo wp_kses_post( $quote_image_cite_line_2 ); ?></p>
			<?php endif; ?>
			<?php if ( $quote_image_cite_line_3 ) : ?>
			<p class="wp-block-lf-quote-with-image__additional"><?php echo wp_kses_post( $quote_image_cite_line_3 ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>

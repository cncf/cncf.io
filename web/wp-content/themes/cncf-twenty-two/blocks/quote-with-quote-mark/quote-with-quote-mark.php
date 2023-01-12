<?php
/**
 * Quote with Quote Mark Block
 *
 * @package WordPress
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Block Name (sluggified).
$block_name = 'quote-with-quote-mark';

$namespace = 'lf';

// Create full block name to use in classes.
$block_name = 'wp-block-' . $namespace . '-' . $block_name;

// setup various classes sent through from $block.
$background = ( empty( $block['backgroundColor'] ) ) ? '' : 'has-' . $block['backgroundColor'] . '-background-color';

$has_background = $background ? 'has-background' : '';

$font_size = ( empty( $block['fontSize'] ) ) ? '' : 'has-' . $block['fontSize'] . '-font-size';

$align = ( empty( $block['align'] ) ) ? '' : 'align' . $block['align'];

$align_text = ( empty( $block['align_text'] ) ) ? '' : 'has-text-align-' . $block['align_text'];

$full_height = ( empty( $block['full_height'] ) ) ? '' : 'has-full-height';

$additional_classes = $block['className'] ?? '';

$all_classes = array(
	$block_name,
	$background,
	$has_background,
	$font_size,
	$align,
	$align_text,
	$full_height,
	$additional_classes,
	'', // You can add more classes, one per line.
);

$classes = implode( ' ', $all_classes );

$quote_large_quote_mark_color = get_field( 'quote_large_quote_mark_color' ) ?? '#000000';
$quote_cite_line_1            = get_field( 'quote_cite_line_1' ) ?? null;
$quote_cite_line_2            = get_field( 'quote_cite_line_2' ) ?? null;

$allowed_inner_blocks = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'This is a quote',
			'className'   => 'wp-block-lf-quote-with-quote-mark__quote',
		),
	),
);
?>

<style>
	.wp-block-lf-quote-with-quote-mark__mark:before {
		background-image: url("data:image/svg+xml,%3Csvg width='78' height='56' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M9.76 55.056c12.96-9.36 24.048-22.176 24.048-37.152C33.808 7.536 28.336.48 19.408.48c-9.072 0-18 8.64-18 18.576 0 8.208 5.76 13.68 13.104 13.68-3.168 4.752-8.064 10.08-13.824 13.968l9.072 8.352zm43.2 0c12.96-9.36 24.048-22.176 24.048-37.152C77.008 7.536 71.536.48 62.608.48c-9.072 0-18 8.64-18 18.576 0 8.208 5.76 13.68 13.104 13.68-3.168 4.752-8.064 10.08-13.824 13.968l9.072 8.352z' fill='<?php echo esc_html( rawurlencode( $quote_large_quote_mark_color ) ); ?>' /%3E%3C/svg%3E") !important;
	}
</style>

<div class="<?php echo esc_attr( $classes ); ?>">
	<?php
		echo '<InnerBlocks template="' . esc_attr( wp_json_encode( $allowed_inner_blocks ) ) . '" templateLock=true />';
	?>
	<div class="wp-block-lf-quote-with-quote-mark__mark">
		<p class="wp-block-lf-quote-with-quote-mark__name"><?php echo esc_html( $quote_cite_line_1 ); ?></p>
		<p class="wp-block-lf-quote-with-quote-mark__position"><?php echo esc_html( $quote_cite_line_2 ); ?></p>
	</div>
</div>

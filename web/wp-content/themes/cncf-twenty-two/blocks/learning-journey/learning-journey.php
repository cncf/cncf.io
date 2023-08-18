<?php
/**
 * Learning Journey Block
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
$block_name = 'learning-journey';

$namespace = 'lf';

// Create full block name to use in classes.
$block_name = 'wp-block-' . $namespace . '-' . $block_name;

// setup various classes sent through from $block.
$background = ( empty( $block['backgroundColor'] ) ) ? '' : 'has-' . $block['backgroundColor'] . '-background-color';

$has_background = $background ? 'has-background' : '';

$font_size = ( empty( $block['fontSize'] ) ) ? '' : 'has-' . $block['fontSize'] . '-font-size';

$align = ( empty( $block['align'] ) ) ? '' : 'align' . $block['align'];

$align_text = ( empty( $block['align_text'] ) ) ? '' : 'has-text-align-' . $block['align_text'];

$anchor = ( empty( $block['anchor'] ) ) ? null : 'id=' . $block['anchor'];

$additional_classes = $block['className'] ?? '';

$all_classes = array(
	'timeline',
	$block_name,
	$background,
	$has_background,
	$font_size,
	$align,
	$align_text,
	$additional_classes,
);

$classes = implode( ' ', $all_classes );

$allowed_blocks = array( 'lf/learning-journey-section' );

?>

<div <?php echo esc_attr( $anchor ); ?> class="<?php echo esc_attr( $classes ); ?>">
<?php
echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" />';
?>
</div>

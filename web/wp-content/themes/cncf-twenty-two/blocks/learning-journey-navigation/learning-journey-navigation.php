<?php
/**
 * Learning Journey Navigation Block
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
$block_name = 'learning-journey-navigation';

$namespace = 'lf';

// Create full block name to use in classes.
$block_name = 'wp-block-' . $namespace . '-' . $block_name;

$align = ( empty( $block['align'] ) ) ? '' : 'align' . $block['align'];

$anchor = ( empty( $block['anchor'] ) ) ? null : 'id=' . $block['anchor'];

$additional_classes = $block['className'] ?? '';

$all_classes = array(
	$block_name,
	$align,
	$additional_classes,
);

$classes = implode( ' ', $all_classes );

require_once __DIR__ . '/menu.php';

?>

<div <?php echo esc_attr( $anchor ); ?> class="<?php echo esc_attr( $classes ); ?>">
<?php
output_learning_journey_menu();
?>
</div>
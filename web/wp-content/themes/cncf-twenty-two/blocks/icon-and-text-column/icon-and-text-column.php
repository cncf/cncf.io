<?php
/**
 * Icon and Text Column Block
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
$block_name = 'icon-and-text-column';

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
	$block_name,
	$background,
	$has_background,
	$font_size,
	$align,
	$align_text,
	$additional_classes,
);

$classes = implode( ' ', $all_classes );

$large_text_color = get_field( 'iat_large_text_color' ) ?? '#D62293';

?>

<div <?php echo esc_attr( $anchor ); ?>
	class="<?php echo esc_attr( $classes ); ?>">

	<?php if ( have_rows( 'iat_item' ) ) : ?>
		<?php
		while ( have_rows( 'iat_item' ) ) :
			?>
	<div class="wp-block-lf-icon-and-text-column__item">
			<?php
			the_row();
			$icon_id    = get_sub_field( 'iati_icon' );
			$large_text = get_sub_field( 'iati_large_text' );
			$small_text = get_sub_field( 'iati_small_text' );
			?>

		<div class="wp-block-lf-icon-and-text-column__item-icon">
			<?php
			LF_Utils::display_responsive_images( $icon_id, 'full', '100%', null, 'lazy' );
			?>
		</div>
		<div class="wp-block-lf-icon-and-text-column__item-text">
			<?php
			if ( $large_text ) {
				?>
			<div class="wp-block-lf-icon-and-text-column__item-text-l"
				style="<?php printf( 'color: %s', esc_attr( $large_text_color ) ); ?>">
				<?php echo esc_html( $large_text ); ?></div>
				<?php
			}
			?>
			<?php
			if ( $small_text ) {
				?>
			<div class="wp-block-lf-icon-and-text-column__item-text-s">
				<?php echo esc_html( $small_text ); ?></div>
				<?php
			}
			?>
		</div>
	</div>

	<?php endwhile; ?>
	<?php endif; ?>

	<?php
	if ( is_admin() && ! have_rows( 'iat_item' ) ) {
		echo '<div style="border: 1px solid black;"><p><strong>Icon & Text Column</strong>.<br><br>Select this block and then add content in the sidebar.</p></div>';
	}
	?>
</div>

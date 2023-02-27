<?php
/**
 * Post Breadcrumb Block
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
$block_name = 'post-breadcrumb';

$namespace = 'lf';

// Create full block name to use in classes.
$block_name = 'wp-block-' . $namespace . '-' . $block_name;

$additional_classes = $block['className'] ?? '';

$all_classes = array(
	$block_name,
	$additional_classes,
);

$classes = implode( ' ', $all_classes );
?>

<div class="<?php echo esc_attr( $classes ); ?>">
<?php
get_template_part( 'components/title-links' );

if ( is_admin() ) {
	?>
<div class="parent-link-align">
	<a class="parent-link"
		href="/"
		title="Example">Example Breadcrumb</a>
</div>
	<?php
}
?>

</div>

<?php
/**
 * Human
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$post_url = get_post_meta( get_the_ID(), 'lf_human_post_url', true );
if ( ! $post_url ) {
	$post_url = get_permalink();
}
$human_type      = Lf_Utils::get_term_names( get_the_ID(), 'lf-human-type', true );
$human_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-human-type', true );

?>

<div class="human-item has-animation-scale-2">
	<a href="<?php echo esc_url( $post_url ); ?>"
		title="<?php the_title_attribute(); ?>">
		<?php
		if ( has_post_thumbnail() ) {
			// display smaller news image.
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-388', '400px', 'human-item__image', 'lazy' );

		} else {
			// show generic.
			// get site options.
			$site_options = get_option( 'lf-mu' );
			Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-388', '400px', 'human-item__image', 'lazy' );

		}
		?>
	</a>

	<div class="human-item__text-wrapper">

		<?php
		if ( $human_type ) :
			$human_type_link = '?_sft_lf-human-type=' . $human_type_slug . '';
			?>
			<a class="author-category"
				title="See more <?php echo esc_attr( $human_type ); ?> humans of cloud native"
				href="<?php echo esc_url( $human_type_link ); ?>">
				<?php echo esc_html( $human_type ); ?></a>
		<?php endif; ?>

		<h3 class="human-item__title">
			<a href="<?php echo esc_url( $post_url ); ?>">
			<?php the_title(); ?>
			</a>
		</h3>
	</div>

	<span
		class="human-item__date"><?php echo get_the_date( 'F j, Y' ); ?></span>

</div>

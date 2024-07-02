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
		<h3 class="human-item__title"><?php the_title(); ?></h3>
	</a>

	<span
		class="human-item__date"><?php echo get_the_date( 'F j, Y' ); ?></span>

</div>

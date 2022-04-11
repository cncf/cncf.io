<?php
/**
 * Promotion Banner
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$site_options = get_option( 'lf-mu' );

$promotion_image_id = $site_options['promotion_image_id'] ?? '';
$promotion_title_text = $site_options['promotion_title_text'] ?? '';
$promotion_body_text = $site_options['promotion_body_text'] ?? '';
$promotion_cta_text = $site_options['promotion_cta_text'] ?? '';
$promotion_cta_link_id = $site_options['promotion_cta_link_id'] ?? '';

if ( $promotion_image_id && $promotion_title_text && $promotion_cta_text && $promotion_cta_link_id ) :
	?>
<div class="main-menu-item promotion-item">
	<div
		class="main-menu-item__image-wrapper">
		<a href="<?php echo esc_url( get_permalink( $site_options['promotion_cta_link_id'] ) ); ?>"
			title="<?php echo esc_html( $promotion_title_text ); ?>" class="main-menu-item__link">
			<?php
			Lf_Utils::display_responsive_images( $promotion_image_id, 'full', '200px', 'main-menu-item__image' );
			?>
		</a>
	</div>

	<div class="main-menu-item__text-wrapper">

	<span class="main-menu-item__title">
			<a href="<?php echo esc_url( get_permalink( $site_options['promotion_cta_link_id'] ) ); ?>"
				title="<?php echo esc_html( $promotion_title_text ); ?>"><?php echo esc_html( $promotion_title_text ); ?></a>
	</span>

	<p class="main-menu-item__body"><?php echo esc_html( $promotion_body_text ); ?></p>

	<a class="is-style-link-cta" href="<?php echo esc_url( get_permalink( $site_options['promotion_cta_link_id'] ) ); ?>"><?php echo esc_html( $promotion_cta_text ); ?></a>

	</div>
</div>

	<?php
endif;
?>

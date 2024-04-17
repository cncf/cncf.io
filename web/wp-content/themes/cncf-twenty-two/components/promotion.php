<?php
/**
 * Promotion Banner
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$site_options = get_option( 'lf-mu' );

$promotion_image_id   = $site_options['promotion_image_id'] ?? '';
$promotion_title_text = $site_options['promotion_title_text'] ?? '';
$promotion_body_text  = $site_options['promotion_body_text'] ?? '';
$promotion_cta_text   = $site_options['promotion_cta_text'] ?? '';
$promotion_cta_link   = $site_options['promotion_cta_link'] ?? '';

if ( $promotion_image_id && $promotion_title_text && $promotion_cta_text && $promotion_cta_link ) :
	?>
<div class="main-menu-item promotion-item">
	<div
		class="main-menu-item__image-wrapper">
		<a href="<?php echo esc_url( $promotion_cta_link ); ?>"
			title="<?php echo esc_html( $promotion_title_text ); ?>" class="main-menu-item__link">
			<?php
			Lf_Utils::display_responsive_images( $promotion_image_id, 'full', '400px', 'main-menu-item__image', 'lazy', esc_html( $promotion_title_text ) );
			?>
		</a>
	</div>

	<div class="main-menu-item__text-wrapper">

	<span class="main-menu-item__title">
			<a href="<?php echo esc_url( $promotion_cta_link ); ?>"
				title="<?php echo esc_html( $promotion_title_text ); ?>"><?php echo esc_html( $promotion_title_text ); ?></a>
	</span>

	<p class="main-menu-item__body"><?php echo esc_html( $promotion_body_text ); ?></p>

	<p class="is-style-link-cta"><a href="<?php echo esc_url( $promotion_cta_link ); ?>"><?php echo esc_html( $promotion_cta_text ); ?></a></p>

	</div>
</div>

	<?php
endif;

$promotion_image_id2   = $site_options['promotion_image_id2'] ?? '';
$promotion_title_text2 = $site_options['promotion_title_text2'] ?? '';
$promotion_body_text2  = $site_options['promotion_body_text2'] ?? '';
$promotion_cta_text2   = $site_options['promotion_cta_text2'] ?? '';
$promotion_cta_link2   = $site_options['promotion_cta_link2'] ?? '';

if ( $promotion_image_id2 && $promotion_title_text2 && $promotion_cta_text2 && $promotion_cta_link2 ) :
	?>
<div class="main-menu-item promotion-item">
	<div
		class="main-menu-item__image-wrapper">
		<a href="<?php echo esc_url( $promotion_cta_link2 ); ?>"
			title="<?php echo esc_html( $promotion_title_text2 ); ?>" class="main-menu-item__link">
			<?php
			Lf_Utils::display_responsive_images( $promotion_image_id2, 'full', '400px', 'main-menu-item__image', 'lazy', esc_html( $promotion_title_text2 ) );
			?>
		</a>
	</div>

	<div class="main-menu-item__text-wrapper">

	<span class="main-menu-item__title">
			<a href="<?php echo esc_url( $promotion_cta_link2 ); ?>"
				title="<?php echo esc_html( $promotion_title_text2 ); ?>"><?php echo esc_html( $promotion_title_text2 ); ?></a>
	</span>

	<p class="main-menu-item__body"><?php echo esc_html( $promotion_body_text2 ); ?></p>

	<p class="is-style-link-cta"><a href="<?php echo esc_url( $promotion_cta_link2 ); ?>"><?php echo esc_html( $promotion_cta_text2 ); ?></a></p>

	</div>
</div>

	<?php
endif;
?>

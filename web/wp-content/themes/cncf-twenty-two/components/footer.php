<?php
/**
 * Footer
 *
 * Use in templates to call wp_footer.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$site_options = get_option( 'lf-mu' );
?>

<footer class="footer">
	<?php
	if ( is_front_page() ) :
		// Start Phippy footer.
		$phippy_desktop_webp_id = get_field( 'phippy_desktop_webp', 'option' ) ?? null;
		$phippy_mobile_webp_id  = get_field( 'phippy_mobile_webp', 'option' ) ?? null;
		$phippy_desktop_png_id  = get_field( 'phippy_desktop_png', 'option' ) ?? null;
		$phippy_mobile_png_id   = get_field( 'phippy_mobile_png', 'option' ) ?? null;

		?>
	<div class="phippy-footer">

		<div style="height:100px" aria-hidden="true" class="wp-block-spacer"
			id="phippy-spacer"></div>

		<?php
		if ( $phippy_desktop_png_id ) {
			?>
		<div class="phippy-footer__container">
			<div class="phippy-footer__inner">

				<picture>
					<source
						srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $phippy_desktop_webp_id, 'full' ) ); ?>"
						sizes="<?php echo esc_attr( wp_get_attachment_image_sizes( $phippy_desktop_webp_id, 'full' ) ); ?>"
						media="(min-width: 700px)" type="image/webp">
					<source
						srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $phippy_mobile_webp_id, 'full' ) ); ?>"
						sizes="<?php echo esc_attr( wp_get_attachment_image_sizes( $phippy_mobile_webp_id, 'full' ) ); ?>"
						type="image/webp">
					<source
						srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $phippy_desktop_png_id, 'full' ) ); ?>"
						sizes="<?php echo esc_attr( wp_get_attachment_image_sizes( $phippy_desktop_png_id, 'full' ) ); ?>"
						media="(min-width: 700px)" type="image/png">
					<source
						srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $phippy_mobile_png_id, 'full' ) ); ?>"
						sizes="<?php echo esc_attr( wp_get_attachment_image_sizes( $phippy_mobile_png_id, 'full' ) ); ?>"
						type="image/png">
					<?php
					LF_Utils::display_responsive_images( $phippy_desktop_png_id, 'full', '1200px', 'phippy-footer__image', 'lazy', 'Characters from the Phippy family' );
					?>
				</picture>
			</div>
		</div>
			<?php
		}
		?>
	</div>
		<?php
		wp_enqueue_script( 'home-phippy', get_template_directory_uri() . '/source/js/on-demand/home-phippy.js', null, filemtime( get_template_directory() . '/source/js/on-demand/home-phippy.js' ), true );
		// End of Phippy footer.
	endif;
	?>

	<div class="container wrap footer_container" id="inner-footer-container">

		<?php if ( ! is_front_page() || ! $phippy_desktop_png_id ) : ?>
		<div style="height:70px" aria-hidden="true"
			class="wp-block-spacer is-style-70-100"></div>
		<?php endif; ?>

		<?php get_template_part( 'components/newsletter' ); ?>

		<div class="horizontal-rule"></div>

		<div style="height:60px" aria-hidden="true"
			class="wp-block-spacer is-style-40-60"></div>

		<div class="lf-grid">
			<nav class="width-10/12">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer_01',
						)
					);

					wp_nav_menu(
						array(
							'theme_location' => 'footer_02',
						)
					);

					wp_nav_menu(
						array(
							'theme_location' => 'footer_03',
						)
					);

					wp_nav_menu(
						array(
							'theme_location' => 'footer_04',
						)
					);

					wp_nav_menu(
						array(
							'theme_location' => 'footer_05',
						)
					);
					?>
			</nav>

			<?php if ( isset( $site_options['footer_cta_text'] ) && isset( $site_options['footer_cta_link'] ) && $site_options['footer_cta_text'] && $site_options['footer_cta_link'] ) : ?>
			<div class="footer__cta">
				<a href="<?php echo esc_url( get_permalink( $site_options['footer_cta_link'] ) ); ?>"
					class="wp-block-button__link has-no-padding"><?php echo esc_html( $site_options['footer_cta_text'] ); ?></a>
			</div>
			<?php endif; ?>
		</div>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-30-80"></div>

		<div class="lf-grid">

			<div class="footer__logo-and-hub">
				<?php
				// Only on desktop.
				if ( isset( $site_options['footer_image_id'] ) && $site_options['footer_image_id'] ) {
					?>

				<a class="footer__logo show-over-1000" href="/"
					title="<?php echo bloginfo( 'name' ); ?>">
					<img src="<?php echo esc_url( wp_get_attachment_url( $site_options['footer_image_id'] ) ); ?>"
						loading="lazy" width="210" height="40"
						alt="<?php echo bloginfo( 'name' ); ?>">
				</a>
					<?php
				}
				?>

				<!-- All CNCF button  -->
				<div class="footer__hub wp-block-buttons">
					<div class="wp-block-button"><a
							href="https://www.cncf.io/all-cncf/"
							class="wp-block-button__link wp-element-button">All
							CNCF Sites</a></div>
				</div>

			</div>

			<?php get_template_part( 'components/social-links' ); ?>

		</div>

		<div style="height:40px" aria-hidden="true" class="wp-block-spacer show-over-1000"></div>

		<div class="horizontal-rule show-over-1000"></div>

		<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>

		<?php get_template_part( 'components/copyright' ); ?>

		<?php
		// This needs to be bigger to allow for cookie banner.
		?>
		<div style="height:90px" aria-hidden="true" class="wp-block-spacer">
		</div>

	</div>
</footer>
<?php
get_template_part( 'components/back-to-top' );
get_footer();

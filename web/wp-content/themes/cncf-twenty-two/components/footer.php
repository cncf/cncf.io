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
		?>
	<!-- Start of phippy  -->
	<div class="phippy-footer">

		<div style="height:100px" aria-hidden="true" class="wp-block-spacer"
			id="phippy-spacer"></div>

		<div class="phippy-footer__container">
			<div class="phippy-footer__inner">
				<picture>
					<source srcset="
				<?php
					Lf_Utils::get_image( 'phippy-family-footer.webp', true );
				?>
					" media="(min-width: 700px)" type="image/webp">
					<source srcset="
				<?php
					Lf_Utils::get_image( 'phippy-family-footer-800x319.webp', true );
				?>
					" type="image/webp">
					<source srcset="
				<?php
					Lf_Utils::get_image( 'phippy-family-footer.png', true );
				?>
					" media="(min-width: 700px)" type="image/png">
					<source srcset="
				<?php
					Lf_Utils::get_image( 'phippy-family-footer-800x319.png', true );
				?>
					" type="image/png">
					<img src="
				<?php
					Lf_Utils::get_image( 'phippy-family-footer.png', true );
				?>
					" alt="Characters from Phippy family" width="1904" height="760"
						class="phippy-footer__image" id="phippy-footer"
						loading="lazy" decoding="async">
				</picture>
			</div>
		</div>
	</div>
	<!-- end of phippy  -->
		<?php
		wp_enqueue_script( 'home-phippy', get_template_directory_uri() . '/source/js/on-demand/home-phippy.js', null, filemtime( get_template_directory() . '/source/js/on-demand/home-phippy.js' ), true );
	endif;
	?>

	<div class="container wrap footer_container" id="inner-footer-container">

		<?php if ( ! is_front_page() ) : ?>
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
			class="wp-block-spacer is-style-40-80"></div>

		<div class="lf-grid">

			<?php
			// Only on desktop.
			if ( isset( $site_options['footer_image_id'] ) && $site_options['footer_image_id'] ) {
				?>
			<div class="logo show-over-1000">
				<a href="/" title="<?php echo bloginfo( 'name' ); ?>">
					<img src="<?php echo esc_url( wp_get_attachment_url( $site_options['footer_image_id'] ) ); ?>"
						loading="lazy" width="210" height="40"
						alt="<?php echo bloginfo( 'name' ); ?>">
				</a>
			</div>

				<?php
			}
			?>

			<?php get_template_part( 'components/social-links' ); ?>

		</div>

		<div style="height:20px" aria-hidden="true"
			class="wp-block-spacer show-over-1000"></div>

		<div class="horizontal-rule show-over-1000"></div>

		<div style="height:40px" aria-hidden="true" class="wp-block-spacer">
		</div>

		<?php get_template_part( 'components/copyright' ); ?>

		<?php
		// This needs to be bigger to allow for cookie banner.
		?>
		<div style="height:70px" aria-hidden="true" class="wp-block-spacer">
		</div>

	</div>
</footer>
<?php
get_template_part( 'components/back-to-top' );
get_footer();

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

	<div class="container wrap">

		<div style="height:70px" aria-hidden="true"
			class="wp-block-spacer is-style-70-100"></div>

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
					width="210" height="40" alt="<?php echo bloginfo( 'name' ); ?>">
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

		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer"></div>

		<?php get_template_part( 'components/copyright' ); ?>

		<?php
		// This needs to be bigger to allow for cookie banner.
		?>
		<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>

	</div>
</footer>
<?php
get_template_part( 'components/back-to-top' );
get_template_part( 'components/cookie-banner' );
get_footer();

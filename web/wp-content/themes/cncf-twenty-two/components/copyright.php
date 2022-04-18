<?php
/**
 * Copyright notice.
 *
 * Outputs the copyright notice.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$site_options = get_option( 'lf-mu' );
?>

<div class="lf-grid">

	<div class="footer__copyright">
		<p>Copyright &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo wp_kses_post( $site_options['copyright_textarea'] ); ?>
	</p>
	</div>

	<p
		class="footer__issue">
		<?php if ( isset( $site_options['accessibility_cta_text'] ) && isset( $site_options['accessibility_cta_link'] ) ) : ?>

					<a href="<?php echo esc_url( get_permalink( $site_options['accessibility_cta_link'] ) ); ?>"><?php echo esc_html( $site_options['accessibility_cta_text'] ); ?></a><br><br>
		<?php endif; ?>
		<a href="https://github.com/cncf/cncf.io/issues/new?title=Your+issue&projects=cncf/cncf.io/1&body=From+URL%3A+<?php echo esc_html( rawurlencode( get_permalink() ) ); ?>">Submit an issue with this page</a>
	</p>

</div>

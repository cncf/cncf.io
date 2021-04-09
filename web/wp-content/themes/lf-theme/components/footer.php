<?php
/**
 * Footer
 *
 * Use in templates to call the footer - it also calls WordPress footer.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$options = get_option( 'lf-mu' );
?>

<footer class="footer">
	<div class="container wrap">

	<?php get_template_part( 'components/newsletter' ); ?>

	<div class="copyright-text">
				<p>Copyright &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<?php echo wp_kses_post( $options['copyright_textarea'] ); ?>
				</p>

				<p><a target="_blank" class="external" rel="noopener" href="https://github.com/cncf/cncf.io/issues/new?title=Your+issue&projects=cncf/cncf.io/1&body=From+URL%3A+<?php echo urlencode( get_permalink() ); ?>">Submit an issue with this page on GitHub</a>.</p>
			</div>

	<?php get_template_part( 'components/social-links' ); ?>

	</div>
</footer>
<?php get_template_part( 'components/back-to-top' ); ?>
<?php get_template_part( 'components/cookie-banner' ); ?>
<?php get_footer(); ?>

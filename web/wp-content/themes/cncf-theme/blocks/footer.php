<?php
/**
 * Footer
 *
 * Use in templates to call the footer - it also calls WordPress footer.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$options = get_option( 'cncf-mu' );
?>

<footer class="footer">
	<div class="container wrap">

		<?php get_template_part( 'blocks/social-links' ); ?>

		<div class="copyright">
			<p>Copyright &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<?php echo wp_kses_data( $options['copyright_textarea'] ); ?>
			</p>
		</div>
	</div>

</footer>
<?php get_footer(); ?>

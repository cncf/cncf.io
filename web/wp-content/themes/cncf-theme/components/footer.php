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
		<form id="sfmc-form1" action="https://cloud.email.thelinuxfoundation.org/CNCF-Newsletter-Subscriber-Form">
			<label for="FirstName" required="">
				<input type="text" name="FirstName" placeholder="FIRST" required>
			</label>
			<label for="LastName" required="">
				<input type="text" name="LastName" placeholder="LAST" required>
			</label>
			<label for="EmailAddress" required="">
				<input type="email" name="EmailAddress" placeholder="EMAIL" required>
			</label>
			<button type="submit" id="sfmc-submit1">SIGN UP</button>
			<div id="recaptcha-form1" style="display:none;"></div>
		</form>
		<div id="sfmc-message1"></div>
	</div>
	<div class="container wrap">
		<?php get_template_part( 'components/social-links' ); ?>
		<div class="copyright">
			<p>Copyright &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<?php echo wp_kses_data( $options['copyright_textarea'] ); ?>
			</p>
		</div>
	</div>
</footer>
<?php get_template_part( 'components/back-to-top' ); ?>
<?php get_footer(); ?>

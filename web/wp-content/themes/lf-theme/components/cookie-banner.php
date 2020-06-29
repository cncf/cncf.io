<?php
/**
 * Cookie Banner
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>

<?php
// Setup default values.
$cookies_text        = 'This website uses cookies to offer you a better browsing experience. ';
$cookies_link_text   = 'Find out more about how we use cookies and how you can change your settings.';
$cookies_button_text = 'Accept';
$cookies_link        = 'https://www.linuxfoundation.org/cookies/';
?>

<div id="cookie-banner"><?php echo esc_html( $cookies_text ); ?>
	<?php echo sprintf( '<a target="_blank" class="external is-footer" rel="noopener"  href="%s">%s</a>', esc_html( $cookies_link ), esc_html( $cookies_link_text ) ); ?>
	<button
		id="cookie-banner-button" tabindex="0" role="button">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
			viewBox="0 0 24 24" fill="currentColor">
			<path
				d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z" />
			</svg>
		<?php echo esc_html( $cookies_button_text ); ?></button></div>

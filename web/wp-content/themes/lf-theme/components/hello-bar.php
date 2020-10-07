<?php
/**
 * Hello Bar
 *
 * CTA message at top of the website.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$options = get_option( 'lf-mu' );

// set default colours.
$custom_text_colour = '#FFFFFF';
$custom_bg_colour   = '#416FD9';

if ( $options['hello_bar_text'] ) {
	$custom_text_colour = $options['hello_bar_text'];
}

if ( $options['hello_bar_bg'] ) {
	$custom_bg_colour = $options['hello_bar_bg'];
}

?>

<div class="hello-bar" role="banner"
	style="background-color: <?php echo esc_attr( $custom_bg_colour ); ?>; color: <?php echo esc_attr( $custom_text_colour ); ?>">
	<div class="container wrap">
		<p><?php echo wp_kses_post( $options['hello_bar_content'] ); ?></p>
	</div>
</div>

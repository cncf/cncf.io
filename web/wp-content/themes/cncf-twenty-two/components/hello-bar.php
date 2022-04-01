<?php
/**
 * Hello Bar
 *
 * CTA message at top of the website.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<?php

$site_options = get_option( 'lf-mu' );

// set default colours.
$custom_text_colour = '#FFFFFF';
$custom_bg_colour   = '#416FD9';

if ( isset( $site_options['hello_bar_text'] ) ) {
	$custom_text_colour = $site_options['hello_bar_text'];
}

if ( isset( $site_options['hello_bar_bg'] ) ) {
	$custom_bg_colour = $site_options['hello_bar_bg'];
}

?>

<div class="hello-bar" role="banner"
	style="background-color: <?php echo esc_attr( $custom_bg_colour ); ?>; color: <?php echo esc_attr( $custom_text_colour ); ?>">
	<div class="container wrap">
		<p><?php echo wp_kses_post( $site_options['hello_bar_content'] ); ?></p>
	</div>
</div>

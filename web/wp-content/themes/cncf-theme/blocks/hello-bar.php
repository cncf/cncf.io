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

$options = get_option( 'cncf-mu' );

// set default
$custom_bg_colour = '#de176c';

if ( $options['hello_bar_bg'] ) {
	$custom_bg_colour = $options['hello_bar_bg'];
}
?>

<section class="hello-bar"
	style="background-color: <?php echo esc_attr( $custom_bg_colour ); ?>">
	<div class="container wrap">
		<p><?php echo wp_kses_data( $options['hello_bar_content'] ); ?></p>
	</div>
</section>

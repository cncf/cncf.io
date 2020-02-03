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

$arr = get_query_var( 'the_options' );

$custom_bg_colour = '#de176c';
if ( $the_options[ hello_bar_bg ] ) {
	$custom_bg_colour = $the_options[ hello_bar_bg ];
}
?>

<section class="hello-bar"
	style="background-color: <?php echo esc_attr( $custom_bg_colour ); ?>">
	<div class="container wrap">
		<p><?php echo wp_kses_data( $the_options[ hello_bar_content ] ); ?></p>
	</div>
</section>

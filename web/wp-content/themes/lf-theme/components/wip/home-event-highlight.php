<?php
/**
 * WIP - Home Event highlight
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// need to enqueue youtube lite script.
wp_enqueue_script(
	'youtube-lite-js',
	home_url() . '/wp-content/mu-plugins/wp-mu-plugins/lf-blocks/src/youtube-lite/scripts/lite-youtube.js',
	is_admin() ? array( 'wp-editor' ) : null,
	filemtime( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/dist/blocks.build.js' ),
	true
);

?>

<section class="event-highlight">
<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>
<div class="container wrap event-highlight-wrapper">

<div>
<h2>May 4-7, 2021</h2>
<p class="h5">The CNCF’s flagship conference virtually gathers adopters and technologists from leading open source and cloud native communities for four days of education and advancement of cloud native computing. <strong>#KubeCon + #CloudNativeCon</strong></p>

<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/" class="button external" rel="noopener">Register Now</a>

</div>
<div><img loading="lazy" src="https://events.linuxfoundation.org/wp-content/uploads/2021/03/KubeCon_EU_2021_web_web-logo.svg" alt="Kubecon 2021"></div>

<div>
<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
<div class="wp-block-lf-youtube-lite"><lite-youtube videoid="I_rbIsM-otA"></lite-youtube></div>
</div></figure>
</div>

</div>
<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>
</section>

<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>

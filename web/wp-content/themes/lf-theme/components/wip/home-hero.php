<?php
/**
 * WIP - Home Hero
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$metrics = LF_Utils::get_homepage_metrics();
?>

<section class="home-hero">
<!-- column 1 -->
<div class="home-hero__col1">
<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>

	<h1>Building sustainable ecosystems for cloud native software
	</h1>
	<ul class="data-display no-style h4">
		<li><span><?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>K+</span> Contributors</li>
		<li><span><?php echo esc_html( round( $metrics['contributions'] / 1000000, 1 ) ); ?>M+</span> Contributions</li>
		<li><span><?php echo esc_html( round( $metrics['linesofcode'] / 1000000, 1 ) ); ?>M+</span> Lines of Code</li>
	</ul>
	<p class="h4 fw-400">
	Cloud Native Computing Foundation (CNCF) serves as the vendor-neutral home for many of the fastest-growing open source projects, including Kubernetes, Prometheus, and Envoy.
	</p>
	<p class="h4 is-style-small-bottom-margin"><a href="/about/who-we-are/" class="arrow-cta">Learn more about CNCF</a></p>
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer show-mobile-only"></div>
</div>

<!-- column 2 -->
<div class="home-hero__col2 has-white-color background-image-wrapper">
<?php echo do_shortcode( '[homepage-casestudies ids="34869,34901,60670,34928,34890"]' ); ?>
</div>

</section>

<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-80-responsive"></div>

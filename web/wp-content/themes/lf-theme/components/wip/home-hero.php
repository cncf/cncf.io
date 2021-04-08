<?php
/**
 * WIP - Home Hero
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>

<section class="home-hero">
<!-- column 1 -->
<div class="home-hero__col1">
<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>

	<h1>Building sustainable ecosystems for cloud native software
	</h1>
	<ul class="data-display no-style h4">
		<li><span>112K+</span> Contributors</li>
		<li><span>2M+</span> Contributions</li>
		<li><span>261M+</span> Lines of Code</li>
	</ul>
	<p
		class="h4 fw-400">Cloud Native Computing Foundation (CNCF) serves as the vendor-neutral home for many of the fastest-growing open source projects, including Kubernetes, Prometheus, and Envoy.</p>
	<p class="h4"><a href="/about/who-we-are/" class="arrow-cta">Learn more about CNCF</a></p>
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer show-mobile-only"></div>
</div>

<!-- column 2 -->
<div class="home-hero__col2 has-white-color background-image-wrapper">

<figure class="background-image-figure">

<?php
LF_Utils::display_responsive_images( 61735, 'case-study-640', '600px' ); // srcset.
?>

</figure>

<div class="wrap background-image-text-overlay">
<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>
	<p class="h5 fw-400">CNCF projects are trusted by organizations around the world</p>
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-20-responsive"></div>
	<a href="/case-studies/ericsson/">
	<?php
			$image = new Image();
	?>
			<img loading="eager" src="<?php $image->get_svg( 'wip-home/ericsson-logo.svg', true ); ?>"
				alt="Ericsson" width="300" height="64"></a>
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-20-responsive"></div>
	<h2><a  class="has-white-color has-text-color" href="/case-studies/ericsson/">How Ericsson is using Kubernetes to leverage cloud native &amp; enable 5G transformation</a></h2>
	<a href="/case-studies/ericsson/" class="button">Read Ericsson Case Study</a>
	<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
</div>

</div>

</section>

<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-80-responsive"></div>

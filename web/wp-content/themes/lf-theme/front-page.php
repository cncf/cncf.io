<?php
/**
 * Front page
 *
 * Template for the front page (home).
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */
get_template_part( 'components/header' );
?>
<main class="page-content">
	<article class="container wrap entry-content">
		<section class="home-hero">


			<div class="home-hero__col1">
			<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>

				<h1>Building sustainable ecosystems for cloud native software
				</h1>
				<ul class="data-display no-style h4">
					<li><span>125K</span> Contributors</li>
					<li><span>2M</span> Contributions</li>
					<li><span>261M</span> Lines of Code</li>
				</ul>
				<p
					class="h4 fw-400">Cloud Native Computing Foundation (CNCF) serves as the vendor-neutral home for many of the fastest-growing open source projects, including Kubernetes, Prometheus, and Envoy.</p>
				<p class="h4"><a href="#" class="arrow-cta">Learn more about CNCF</a></p>
				<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
			</div>



			<div class="home-hero__col2 has-white-color background-image-wrapper">

<figure class="background-image-figure">
<img src="http://www.fillmurray.com/800/800" alt="">
</figure>

<div class="wrap background-image-text-overlay">
<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>

				<p
					class="h5 fw-400">CNCF projects are trusted by organizations around the world</p>
					<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-20-responsive"></div>
				<img src="https://fakeimg.pl/300x125/?text=Peloton%20Logo">
				<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-20-responsive"></div>
				<h2>Peloton leads the pack with Kubernetes</h2>
				<a href="#" class="button">Read Peloton Case Study</a>
				<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
			</div>

			</div>
		</section>


		<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-80-responsive"></div>





		<section class="user-guide">
			<div class="user-guide-wrapper">
				<div
					class="has-white-color has-pink-400-background-color has-text-color has-background home-padding">
					<h2>End Users</h2>
					<p>Get help navigating cloud native and open source, and be an active participant in key technology decisions by CNCF-hosted projects</p>
					<p><a href="#" class="arrow-cta has-white-color">Explore end user community</a></p>
				</div>
				<div
					class="has-white-color has-purple-700-background-color has-text-color has-background home-padding">
					<h2>Contributors</h2>
					<p>CNCF offers multiple ways to start contributing to the CNCF ecosystem, including foundation-wide and project-wide opportunities.</p>
					<p><a href="#" class="arrow-cta has-white-color ">Find ways to participate</a></p>
				</div>
				<div
					class="has-white-color has-tertiary-400-background-color has-text-color has-background home-padding">
					<h2>Members</h2>
					<p>Join the world's largest cloud computing and software companies in helping build and shape the cloud native ecosystem.</p>
					<p><a href="#" class="arrow-cta has-white-color ">Join the CNCF ecosystem</a></p>
				</div>
			</div>
		</section>


		<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-80-responsive"></div>

<section class="hosted-projects">
<h2>CNCF hosted projects</h2>
<ul class="data-display no-style h4">
					<li><span>16</span> Graduated Projects</li>
					<li><span>20</span> Incubating Projects</li>
					<li><span>44</span> Sandbox Projects</li>
				</ul>

				<p class="h5">The CNCF hosts critical components of the global technology infrastructure. CNCF brings together the world's top developers, end users, and vendors and runs the largest open source developer conferences. CNCF is part of the non-profit <a href="#">Linux Foundation</a>.</p>

				<p class="h4"><a href="#" class="arrow-cta">Learn more about CNCF</a></p>
				<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>

				<img src="http://www.fillmurray.com/400/400" alt="">
</section>

<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-80-responsive"></div>

<section class="home-announcement home-padding">

<?php
$image = new Image();
$image->get_svg( 'icon-newspaper.svg' ); ?>

</section>

	</article>
</main>
<?php
// get_template_part( 'components/page-single' );
get_template_part( 'components/footer' );

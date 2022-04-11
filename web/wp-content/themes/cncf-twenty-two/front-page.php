<?php
/**
 * Front Page
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );
?>
<link rel="preload" as="image"
	href="/wp-content/themes/cncf-twenty-two/images/home-hero-poster.jpg">

<?php
wp_enqueue_script( 'home-hero', get_template_directory_uri() . '/source/js/on-demand/video.js', null, filemtime( get_template_directory() . '/source/js/on-demand/video.js' ), true );
?>

<main>
	<section class="home-hero">

		<div aria-hidden="true" class="home-hero__overlay"></div>

		<img src="/wp-content/themes/cncf-twenty-two/images/home-hero-poster.jpg"
			width="100%" height="100%" class="home-hero__poster"
			alt="Make cloud native ubiquitous">

		<video class="home-hero__video" width="100%" preload="none" loop muted
			playsinline>
			<source
				src="/wp-content/themes/cncf-twenty-two/source/videos/hero.mp4"
				type="video/mp4">
			<img src="/wp-content/themes/cncf-twenty-two/images/home-hero-poster.jpg"
				alt="Make cloud native ubiquitous">
		</video>

		<div class="home-hero__content">
			<div class="container wrap">

				<h1>MAKE<br />
					CLOUD NATIVE<br />
					<span>UBIQUITOUS</span>
				</h1>

				<div style="height:35px" aria-hidden="true"
					class="wp-block-spacer"></div>

				<h2>CNCF is the vendor-neutral hub of <strong>cloud native
						computing</strong>. Hosting
					cutting-edge projects like Kubernetes and Envoy to make
					cloud native
					universal and sustainable.</h2>

				<div style="height:70px" aria-hidden="true"
					class="wp-block-spacer"></div>

				<div class="horizontal-rule"></div>

				<div style="height:70px" aria-hidden="true"
					class="wp-block-spacer"></div>

				<ul class="home-hero__metric_wrapper">
					<li><a href="#" class="wp-block-button__link">Learn More</a>
					</li>
					<li>116 <span>Projects</span></li>
					<li>152K <span>Contributors</span></li>
					<li>7.9M <span>Contrubitions</span></li>
					<li>187 <span>Countries</span></li>
				</ul>

			</div>
		</div>
	</section>

	<article class="container wrap">
		<div style="height:100px" aria-hidden="true" class="wp-block-spacer">
		</div>

		<h2>CNCF projects are <br />
			fundamentally changing <br />
			cloud native computing</h2>

		<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</article>
</main>
<?php
get_template_part( 'components/footer' );

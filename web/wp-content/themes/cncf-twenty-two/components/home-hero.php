<?php
/**
 * Home - Hero
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<link rel="preload" as="image"
	href="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster.jpg' ); ?>">

<?php
wp_enqueue_script( 'home-hero', get_template_directory_uri() . '/source/js/on-demand/video.js', null, filemtime( get_template_directory() . '/source/js/on-demand/video.js' ), true );

$metrics = LF_Utils::get_homepage_metrics();
?>
<section class="home-hero">
	<div aria-hidden="true" class="home-hero__overlay"></div>

	<img src="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster.jpg' ); ?>"
		class="home-hero__poster" style="width: 100%; height: 100%;"
		alt="Make cloud native ubiquitous">

	<div class="home-hero__video-wrapper">
		<video class="home-hero__video" loop muted playsinline width="100%"
			preload="none">
			<source
				src="<?php echo esc_url( get_template_directory_uri() . '/source/videos/hero.mp4' ); ?>"
				type="video/mp4">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster.jpg' ); ?>"
				alt="Make cloud native ubiquitous">
		</video>
	</div>

	<div class="home-hero__content">
		<div class="container wrap">

			<h1 class="home-hero__title">MAKE<br />
				CLOUD NATIVE<br />
				<span>UBIQUITOUS</span>
			</h1>

			<h2 class="home-hero__description">CNCF is the open source vendor-neutral
				hub of <strong>cloud native computing</strong>, hosting
				projects like Kubernetes and Prometheus to make cloud native universal and sustainable.</h2>

			<div class="horizontal-rule"></div>

			<ul class="home-hero__metric_wrapper">
				<li class="show-over-800"><a href="/about/who-we-are/"
						class="wp-block-button__link">Learn More</a>
				</li>
				<li><?php echo esc_html( $metrics['projects'] ); ?>
					<span>Projects</span>
				</li>
				<li><?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>K
					<span>Contributors</span>
				</li>
				<li><?php echo esc_html( round( $metrics['contributions'] / 1000000, 1 ) ); ?>M
					<span>Contributions</span>
				</li>
				<li class="show-over-600">
					<?php echo esc_html( $metrics['countries'] ); ?>
					<span>Countries</span>
				</li>
			</ul>
		</div>
	</div>
</section>

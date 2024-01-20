<?php
/**
 * Home - Hero
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<link rel="preload" as="image" fetchpriority="high"
	href="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster.jpg' ); ?>">

<?php
wp_enqueue_script( 'home-hero', get_template_directory_uri() . '/source/js/on-demand/video.js', null, filemtime( get_template_directory() . '/source/js/on-demand/video.js' ), true );

$metrics = LF_Utils::get_homepage_metrics();
?>
<section class="home-hero">
	<div aria-hidden="true" class="home-hero__overlay"></div>

	<img src="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster.jpg' ); ?>"
		class="home-hero__poster" style="width: 100%; height: 100%;"
		alt="Make cloud native ubiquitous" decoding="async">

	<div class="home-hero__video-wrapper">
		<video class="home-hero__video" loop muted playsinline width="100%"
			preload="none" style="width: 100%;
		height: 100%;
		object-fit: cover;
		position: absolute;
		z-index: 1;
		top: 0;
		left: 0;">
			<source
				src="<?php echo esc_url( get_template_directory_uri() . '/source/videos/hero.mp4' ); ?>"
				type="video/mp4">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster.jpg' ); ?>"
				alt="Make cloud native ubiquitous">
		</video>
	</div>

	<div class="home-hero__content">
		<div class="container wrap">

			<h1 class="home-hero__title">JOIN US IN<br />
				PARIS, FRANCE<br />
				<span>MARCH 19-22</span>
			</h1>

			<h2 class="home-hero__description">
				<strong>KubeCon + CloudNativeCon is the biggest cloud native event in Europe.</strong><br/>
				Tickets are on sale now. Buy before February 1st to save.
			</h2>

			<div class="horizontal-rule"></div>

			<ul class="home-hero__metric_wrapper">
				<li class="show-over-800">
					<div class="wp-block-button"><a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/register/" class="wp-block-button__link wp-element-button" title="Learn more about CNCF">Buy Tickets</a></div>
				</li>
				<li>10K+
					<span>Attendees</span>
				</li>
				<li>200+
					<span>Sponsors</span>
				</li>
				<li>300+
					<span>Sessions</span>
				</li>
				<li class="show-over-600">
						∞
					<span>Swag</span>
				</li>
			</ul>
		</div>
	</div>
</section>

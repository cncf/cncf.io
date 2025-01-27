<?php
/**
 * Home - Takeover
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<link rel="preload" as="image" fetchpriority="high"
	href="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster2.webp' ); ?>">

<?php
wp_enqueue_script( 'home-hero', get_template_directory_uri() . '/source/js/on-demand/video.js', null, filemtime( get_template_directory() . '/source/js/on-demand/video.js' ), true );

$metrics = LF_Utils::get_homepage_metrics();
?>
<section class="home-hero">
	<div aria-hidden="true" class="home-hero__overlay"></div>

	<picture>
		<source srcset="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster2.webp' ); ?>" type="image/webp">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster2.jpg' ); ?>"
			class="home-hero__poster" style="width: 100%; height: 100%;"
			alt="Make cloud native ubiquitous" decoding="async">
	</picture>

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
				<picture>
				<source srcset="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster2.webp' ); ?>" type="image/webp">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/home-hero-poster2.jpg' ); ?>"
		alt="Make cloud native ubiquitous">
				</picture>
		</video>
	</div>

	<div class="home-hero__content">
		<div class="container wrap">

			<h1 class="home-hero__title">JOIN US IN<br />
				LONDON, ENGLAND<br />
				<span>1 - 4 April</span>
			</h1>

			<h2 class="home-hero__description"><strong>KubeCon + CloudNativeCon</strong> is the flagship conference for cloud native.</h2>
			<div style="height:20px;" aria-hidden="true" class="wp-block-spacer"></div>

			<div class="horizontal-rule"></div>

			<ul class="home-hero__metric_wrapper">
				<li class="show-over-800">
					<div class="wp-block-button"><a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/register/?utm_source=www&utm_medium=homepage&utm_campaign=KubeCon-EU-2025&utm_content=hero" class="wp-block-button__link wp-element-button" title="Buy Tickets">Buy Tickets</a></div>
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

<?php
/**
 * Home - CNCF About
 *
 * A small block that can be used when there is a hero takeover.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$metrics = LF_Utils::get_homepage_metrics();

?>

<style>
@media (max-width: 767px) {
	.home-cncf-about {
		text-align: center;
	}

	.home-cncf-about__metric-wrapper {
		justify-content: center;
	}
}

.home-cncf-about__metric-wrapper {
	flex-wrap: wrap;
	row-gap: 30px;
	column-gap: 30px;
}

@media (min-width: 1000px) {
	.home-cncf-about__metric-wrapper {
		column-gap: 90px;
	}
}

.home-cncf-about__blob {
	display: none;
}

@media (min-width: 1200px) {
	.home-cncf-about__metric-wrapper {
		column-gap: 70px;
	}

	.home-cncf-about__columns {
		display: flex;
		justify-content: space-between;
	}

	.home-cncf-about__blob {
		display: block;
		max-width: 350px;
	}
}
</style>

<section class="home-cncf-about wp-block-group alignfull is-layout-flow wp-block-group-is-layout-flow
	is-vertically-aligned-center has-gray-200-background-color has-background
	">
	<div class="wp-block-group is-style-no-padding">

		<div aria-hidden="true" class="wp-block-spacer is-style-40-80"></div>

		<div class="home-cncf-about__columns">
			<div>
			<h2 class="has-extra-extra-large-font-size">Make cloud native
				ubiquitous
			</h2>

			<div aria-hidden="true" class="wp-block-spacer"
				style="height:20px;">
			</div>

			<p class="is-style-max-width-700">CNCF is the open source,
							vendor-neutral
							hub of <strong>cloud native computing</strong>, hosting
							projects like Kubernetes and Prometheus to make cloud native
							universal and sustainable.</p>

			<ul
				class="home-hero__metric_wrapper home-cncf-about__metric-wrapper">
				<li style="margin-left: 0; margin-right: 0;">
					<?php echo esc_html( $metrics['projects'] ); ?>
					<span>Projects</span>
				</li>
				<li style="margin-left: 0; margin-right: 0;">
					<?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>K
					<span>Contributors</span>
				</li>
				<li style="margin-left: 0; margin-right: 0;">
					<?php echo esc_html( round( $metrics['contributions'] / 1000000, 1 ) ); ?>M
					<span>Contributions</span>
				</li>
				<li style="margin-left: 0; margin-right: 0;"
					class="show-over-600">
					<?php echo esc_html( $metrics['countries'] ); ?>
					<span>Countries</span>
				</li>
				<li style="margin-left: 0; margin-right: 0;">
					<div class="wp-block-button"><a href="/about/who-we-are/"
							class="wp-block-button__link has-black-background-color has-background wp-element-button"
							title="Learn more about CNCF">About CNCF</a></div>
				</li>
			</ul>
			</div>
			<div class="home-cncf-about__blob">
				<!-- wp:image {"align":"left","id":65023,"sizeSlug":"large","linkDestination":"none","className":"is-style-blob"} -->
				<div class="wp-block-image is-style-blob">
					<figure class="size-large">
					<?php LF_Utils::display_responsive_images( 109366, 'large', '350px', null, 'lazy', 'Developers at a conference' ); ?>
						</figure>
				</div>
				<!-- /wp:image -->
			</div>
		</div>
		<div aria-hidden="true" class="wp-block-spacer" style="height: 1px;">
		</div>
	</div>
</section>

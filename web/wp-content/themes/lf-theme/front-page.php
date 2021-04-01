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

 // phpcs:ignoreFile
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
	<div>
	<h2>CNCF hosted projects</h2>
	<?php
		$query_args = array(
			'post_type'      => 'lf_project',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => 200,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		$project_query = new WP_Query( $query_args );

		$graduated_count  = 0;
		$incubating_count = 0;
		$sandbox_count    = 0;
		$graduated_logos  = Array();
		$incubating_logos = Array();
		$sandbox_logos    = Array();

		if ( $project_query->have_posts() ) {
			while ( $project_query->have_posts() ) {
				$project_query->the_post();
				$stacked_logo_id = get_post_meta( get_the_ID(), 'lf_project_stacked_logo', true );
				$stacked_logo_url = wp_get_attachment_image_url( $stacked_logo_id );
				if ( has_term( 'graduated', 'lf-project-stage', get_the_ID() ) ) {
					$graduated_count++;
					$graduated_logos[] = $stacked_logo_url;
				} else if ( has_term( 'incubating', 'lf-project-stage', get_the_ID() ) ) {
					$incubating_count++;
					$incubating_logos[] = $stacked_logo_url;
				} else if ( has_term( 'sandbox', 'lf-project-stage', get_the_ID() ) ) {
					$sandbox_count++;
					$sandbox_logos[] = $stacked_logo_url;
				}
			}
		}
		wp_reset_postdata();
	?>
	<ul class="data-display no-style h4">
		<li><span><?php echo esc_html( $graduated_count ); ?></span> Graduated Projects</li>
		<li><span><?php echo esc_html( $incubating_count ); ?></span> Incubating Projects</li>
		<li><span><?php echo esc_html( $sandbox_count ); ?></span> Sandbox Projects</li>
	</ul>
	<?php echo var_dump( $graduated_logos ); ?>
	<p class="h5">The CNCF hosts critical components of the global technology infrastructure. CNCF brings together the world's top developers, end users, and vendors and runs the largest open source developer conferences. CNCF is part of the non-profit <a href="#">Linux Foundation</a>.</p>

	<p class="h4"><a href="#" class="arrow-cta">Learn more about CNCF</a></p>
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	</div>

	<div>
	<img src="http://www.fillmurray.com/500/400" alt="">
	</div>
</section>

<section class="event-highlight">

</section>

<section class="training-promotion">
<div><h2>Save $2,500 off your next Kubernetes Certification</h2>
<p class="h4">Enroll as an <a href="#">End User Supporter</a> and <a href="#">receive five 100% off coupon codes for any eLearning class</a>, certification exam, or eLearning + Certification exam "bundle" in the Training and Certification Catalog.</p>
<p class="h4"><a href="#" class="arrow-cta">Support CNCF and save on certification</a></p>
				<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
</div>
<div>
<img src="http://www.fillmurray.com/450/200" alt="">
</div>

</section>

<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-80-responsive"></div>

<section class="home-announcement home-padding">

<?php
$image = new Image();
$image->get_svg( 'icon-newspaper.svg' );


?>
</section>

<?php the_content(); ?>

	</article>
</main>
<?php
// get_template_part( 'components/page-single' );
get_template_part( 'components/footer' );

<?php
/**
 * Shortcode
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Display Case Studies rotator banner on home page.
 * [home_case_studies ids="34,22,122"]
 *
 * @param array $atts Attributes.
 */
function add_home_case_studies_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'ids' => '', // set default.
		),
		$atts,
		'home_case_studies'
	);

	$selected_ids = explode( ',', $atts['ids'] );
	shuffle( $selected_ids );
	$finals_ids = array_slice( $selected_ids, 0, 2 );

	ob_start();
	?>

<div class="featured-case-studies columns-two">

	<?php

	foreach ( $finals_ids as $id ) :

		$company     = get_the_title( $id );
		$description = get_post_meta( $id, 'lf_case_study_long_title', true );
		$url         = get_permalink( $id );
		$logo        = get_post_meta( $id, 'lf_case_study_homepage_company_logo', true );
		if ( ! $logo ) {
			$logo = get_post_meta( $id, 'lf_case_study_company_logo', true );
		}
		$background_image = get_post_meta( $id, 'lf_case_study_homepage_image', true );
		if ( ! $background_image ) {
			// use the regular listing background image if no homepage image exists.
			$image = get_post_thumbnail_id( $id );
		}
		?>
	<div class="featured-case-studies__item">

		<a href="<?php echo esc_url( $url ); ?>" class="box-link"
			title="Read <?php echo esc_html( $company ); ?> case study"></a>

		<figure class="featured-case-studies__bg-figure">
			<?php
			LF_Utils::display_responsive_images( $background_image, 'case-study-640', '600px', 'featured-case-studies__bg-image' );
			?>
		</figure>

		<div class="featured-case-studies__text-overlay">

			<span class="author-category">Case Study</span>

			<figure class="featured-case-studies__logo-figure">
				<?php
				LF_Utils::display_responsive_images( $logo, 'full', '200px', 'featured-case-studies__logo' );
				?>
			</figure>
			<p class="featured-case-studies__description">
		<?php echo esc_html( $description ); ?>
		</p>

		</div>

	</div>

		<?php
	endforeach;
	?>
</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'home_case_studies', 'add_home_case_studies_shortcode' );






/**
 * Home User Guide
 * [homepage-user-guide]
 */
function homepage_user_guide_shortcode() {
	ob_start();
	?>

<section class="user-guide">
	<div class="user-guide-wrapper">
		<div class="user-guide-box">

			<?php
			if ( wp_attachment_is_image( 62498 ) ) :
				?>
			<div class="user-guide-box-image newsroom-image-wrapper">
				<?php
				Lf_Utils::display_responsive_images( 62498, 'newsroom-540', '540px', 'archive-image' );
				?>
			</div>
				<?php
endif;
			?>
			<div
				class="has-white-color has-pink-400-background-color has-text-color has-background home-padding user-guide-box-text">
				<a href="/enduser/" class="box-link"
					title="Explore end user community"></a>
				<h2>End Users</h2>
				<p>Accelerate your cloud native technology adoption in close collaboration with peers, project maintainers and CNCF.</p>
				<a href="/enduser/"
					class="is-style-arrow-cta has-white-color">Explore
					end user community</a>
			</div>
		</div>

		<div class="user-guide-box">
			<?php
			if ( wp_attachment_is_image( 62497 ) ) :
				?>
			<div class="user-guide-box-image newsroom-image-wrapper">
				<?php
				Lf_Utils::display_responsive_images( 62497, 'newsroom-540', '540px', 'archive-image' );
				?>
			</div>
				<?php
endif;
			?>
			<div
				class="has-white-color has-purple-700-background-color has-text-color has-background home-padding user-guide-box-text">
				<a href="http://contribute.cncf.io/" class="box-link"
					title="Start contributing"></a>
				<h2>Contributors</h2>
				<p>Join our welcoming community of doers and contribute to advancing CNCF hosted projects.</p>
				<a href="http://contribute.cncf.io/"
					class="is-style-arrow-cta has-white-color">Start
					contributing</a>
			</div>
		</div>
		<div class="user-guide-box">
			<?php
			if ( wp_attachment_is_image( 62499 ) ) :
				?>
			<div class="user-guide-box-image newsroom-image-wrapper">
				<?php
				Lf_Utils::display_responsive_images( 62499, 'newsroom-540', '540px', 'archive-image' );
				?>
			</div>
				<?php
endif;
			?>
			<div
				class="has-white-color has-tertiary-400-background-color has-text-color has-background home-padding user-guide-box-text">
				<a href="/about/join/" class="box-link"
					title="Become a member today"></a>
				<h2>Members</h2>
				<p>Build and shape the cloud native ecosystem and drive cross-company collaboration with more than 550 members.</p>
				<a href="/about/join/"
					class="is-style-arrow-cta has-white-color">Become a
					member today</a>
			</div>
		</div>
	</div>
</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'homepage-user-guide', 'homepage_user_guide_shortcode' );



/**
 * Home Event Highlight
 * [homepage-event-highlight]
 */
function homepage_event_highlight_shortcode() {
	ob_start();
	?>
<section class="event-highlight">

	<div class="container wrap event-highlight-wrapper">

		<div>
			<h2>May 16-20, 2022</h2>
			<p
				class="h5">The CNCF’s flagship conference gathers adopters and technologists from leading open source and cloud native communities for four days of education and advancement of cloud native computing. <strong>#KubeCon + #CloudNativeCon</strong></p>

			<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/"
				class="button external" target="_blank" rel="noopener">Learn
				more</a>

		</div>
		<div><a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/"
				target="_blank" rel="noopener"><img loading="lazy"
					src="https://events.linuxfoundation.org/wp-content/uploads/2021/05/kubecon-eu-2022-webgraphics_white-logo.svg"
					alt="Kubecon"></a></div>

		<div>
			<p
				class="event-highlight-video-description">KubeCon + CloudNativeCon 2019 Highlights</p>
			<figure
				class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio">
				<div class="wp-block-embed__wrapper">
					<div class="wp-block-lf-youtube-lite">
						<lite-youtube videoid="iGbAdyOKKhc"></lite-youtube>
					</div>
				</div>
			</figure>
		</div>

	</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'homepage-event-highlight', 'homepage_event_highlight_shortcode' );

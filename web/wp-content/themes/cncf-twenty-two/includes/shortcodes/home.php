<?php
/**
 * Shortcode
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Home Hosted Projects
 * [home_projects]
 */
function add_home_projects_shortcode() {

	$query_args = array(
		'post_type'      => 'lf_project',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 200,
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	$project_query = new WP_Query( $query_args );

	$graduated_count   = 0;
	$incubating_count  = 0;
	$sandbox_count     = 0;
	$all_project_logos = array();

	if ( $project_query->have_posts() ) {
		while ( $project_query->have_posts() ) {
			$project_query->the_post();
			$stacked_logo_url = get_post_meta( get_the_ID(), 'lf_project_logo', true );
			if ( has_term( 'graduated', 'lf-project-stage', get_the_ID() ) ) {
				$graduated_count++;
				if ( $stacked_logo_url ) {
					$all_project_logos[] = $stacked_logo_url;
				}
			} elseif ( has_term( 'incubating', 'lf-project-stage', get_the_ID() ) ) {
				$incubating_count++;
				if ( $stacked_logo_url ) {
					$all_project_logos[] = $stacked_logo_url;
				}
			} elseif ( has_term( 'sandbox', 'lf-project-stage', get_the_ID() ) ) {
				$sandbox_count++;
			}
		}
	}
	wp_reset_postdata();
	ob_start();

	r($all_project_logos);
	?>

<section class="home-projects">

	<?php if ( $graduated_count && $incubating_count && $sandbox_count ) :

	// load pure counter countup script.
	wp_enqueue_script( 'purecounter', get_template_directory_uri() . '/source/js/libraries/purecounter.min.js', array(), filemtime( get_template_directory() . '/source/js/libraries/purecounter.min.js' ), false );

	?>

	<div class="home-projects__numbers">
		<div class="home-projects__numbers-graduated">
			<a href="/projects/">
				<span
					data-purecounter-end="<?php echo esc_html( $graduated_count ); ?>"
					data-purecounter-delay="75"
					class="purecounter number"><?php echo esc_html( $graduated_count ); ?></span>
				<span class="project">Graduated <br>Projects</span>
			</a>
		</div>
		<div class="home-projects__numbers-incubating">
			<a href="/projects/#incubating">
				<span
					data-purecounter-end="<?php echo esc_html( $incubating_count ); ?>"
					data-purecounter-delay="20"
					class="purecounter number"><?php echo esc_html( $incubating_count ); ?></span>
				<span class="project">Incubating <br>Projects</span>
			</a>
		</div>
		<div class="home-projects__numbers-sandbox">
			<a href="/sandbox-projects/">
				<span
					data-purecounter-end="<?php echo esc_html( $sandbox_count ); ?>"
					data-purecounter-delay="0"
					class="purecounter number"><?php echo esc_html( $sandbox_count ); ?></span>
				<span class="project">Sandbox <br>Projects</span>
			</a>
		</div>
	</div>
	<?php endif; ?>

	<?php

	if ( $all_project_logos ) :

		// load slick css.
		wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

		// load main slick.
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/libraries/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/slick.min.js' ), true );

		// load slick config.
		wp_enqueue_script( 'slick-config', get_template_directory_uri() . '/source/js/on-demand/slick-config.js', array( 'jquery', 'slick' ), filemtime( get_template_directory() . '/source/js/on-demand/slick-config.js' ), true );

		$all_project_logos = LF_Utils::partition( $all_project_logos, 2 );
		?>
	<div class="home-projects__slider">
		<?php
		$i = 0;
		foreach ( $all_project_logos as $project_logos ) {
			$i++;
		$direction = ( $i % 2 == 0 ) ? 'rtl' : 'ltr'; // phpcs:ignore

			?>
		<div class="slider home-projects__slider-item-<?php echo esc_html( $i ); ?>"
			dir="<?php echo esc_html( $direction ); ?>">
			<?php foreach ( $project_logos as $project_logo ) {
				?>
			<div class="home-projects__slider-slide" dir="ltr">
				<img src="<?php echo esc_url( $project_logo ); ?>"
					loading="lazy" alt="CNCF Hosted Project">
			</div>
			<?php
			}
			?>

		</div>
		<?php
		}
		?>
	</div>
	<?php endif; ?>

</section>

<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'home_projects', 'add_home_projects_shortcode' );

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

	ob_start();
	$ids = explode( ',', $atts['ids'] );
	shuffle( $ids );

	$title = get_post_meta( $ids[0], 'lf_case_study_long_title', true );
	$logo  = get_post_meta( $ids[0], 'lf_case_study_homepage_company_logo', true );
	if ( ! $logo ) {
		$logo = get_post_meta( $ids[0], 'lf_case_study_company_logo', true );
	}
	$logo_url = wp_get_attachment_image_src( $logo );
	$image    = get_post_meta( $ids[0], 'lf_case_study_homepage_image', true );
	$url      = get_permalink( $ids[0] );
	if ( ! $image ) {
		// use the regular listing background image if no homepage image exists.
		$image = get_post_thumbnail_id( $ids[0] );
	}
	$company = get_the_title( $ids[0] );
	?>
<div class="featured-case-study">
	<figure class="background-image-figure">
		<?php
	LF_Utils::display_responsive_images( $image, 'case-study-640', '600px' ); // srcset.
	?>
	</figure>

	<a href="<?php echo esc_url( $url ); ?>" class="logo-link">
		<img loading="eager" src="<?php // echo esc_url( $logo_url[0] ); ?>"
			alt="<?php echo esc_attr( $company ); ?>" width="300"
			height="70"></a>

	<h2><a class="has-white-color has-text-color"
			href="<?php echo esc_url( $url ); ?>">
			<?php echo esc_html( $title ); ?>
		</a></h2>

	<a href="<?php echo esc_url( $url ); ?>" class="button">Read
		<?php echo esc_html( $company ); ?> Case Study</a>

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

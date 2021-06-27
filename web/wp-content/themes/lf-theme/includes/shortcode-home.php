<?php
/**
 * Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Display Case Studies rotator banner on home page.
  * [homepage-casestudies case-study-ids="34,22,122"]
  *
  * @param array $atts Attributes.
  */
function homepage_casestudies_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'case-study-ids' => '', // set default.
		),
		$atts,
		'homepage-casestudies'
	);

	ob_start();
	$ids = explode( ',', $atts['case-study-ids'] );
	shuffle( $ids );

	$title    = get_post_meta( $ids[0], 'lf_case_study_long_title', true );
	$logo     = get_post_meta( $ids[0], 'lf_case_study_homepage_company_logo', true );
	if ( ! $logo ) {
		$logo     = get_post_meta( $ids[0], 'lf_case_study_company_logo', true );
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

	<figure class="background-image-figure">
	<?php
	LF_Utils::display_responsive_images( $image, 'case-study-640', '600px' ); // srcset.
	?>
	</figure>

	<div class="wrap background-image-text-overlay">
	<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>
		<p class="h5 fw-400">CNCF projects are trusted by organizations around the world</p>
		<a href="<?php echo esc_url( $url ); ?>" class="logo-link">
		<?php
		$image = new Image();
		?>
		<img loading="eager" src="<?php echo esc_url( $logo_url[0] ); ?>" alt="<?php echo esc_attr( $company ); ?>" width="300" height="70"></a>
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-20-responsive"></div>
		<h2><a  class="has-white-color has-text-color" href="<?php echo esc_url( $url ); ?>">
		<?php echo esc_html( $title ); ?>
		</a></h2>
		<a href="<?php echo esc_url( $url ); ?>" class="button">Read <?php echo esc_html( $company ); ?> Case Study</a>
		<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
	</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'homepage-casestudies', 'homepage_casestudies_shortcode' );



 /**
  * Display News + Webinar on home page.
  * [homepage-latest-news-webinar]
  */
function homepage_latest_news_webinar_shortcode() {

	$blog_quantity    = 2;
	$webinar_quantity = 1;
	$classes          = '';
	$category         = 230;
	$show_images      = true;

	// get sticky posts.
	$sticky_post = null;
	$sticky      = get_option( 'sticky_posts' );
	if ( $sticky ) {
		$args        = array(
			'posts_per_page'      => 1,
			'post_type'           => array( 'post' ),
			'post_status'         => array( 'publish' ),
			'has_password'        => false,
			'post__in'            => $sticky,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'tax_query'           => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $category,
				),
			),
		);
		$stickyquery = new WP_Query( $args );

		if ( $stickyquery->have_posts() ) {
			$stickyquery->the_post();
			--$blog_quantity;
			$sticky_post = get_the_ID();
		}
	}

	// setup the arguments.
	$args = array(
		'posts_per_page'      => $blog_quantity,
		'post_type'           => array( 'post' ),
		'post_status'         => array( 'publish' ),
		'has_password'        => false,
		'ignore_sticky_posts' => true,
		'post__not_in'        => array( $sticky_post ),
		'order'               => 'DESC',
		'orderby'             => 'date',
		'no_found_rows'       => true,
		'tax_query'           => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $category,
			),
		),
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {

		ob_start();
		?>
<div class="wp-block-columns better-responsive-columns">
		<?php
		if ( $sticky_post ) {
			echo '<div class="wp-block-column" style="flex-basis:33.33%">';
			lf_newsroom_show_post( $sticky_post, $show_images, true );
			echo '</div>';
		}

		if ( $blog_quantity > 0 ) :
			while ( $query->have_posts() ) :
				$query->the_post();
				echo '<div class="wp-block-column" style="flex-basis:33.33%">';
				lf_newsroom_show_post( get_the_ID(), $show_images, false );
				echo '</div>';
		endwhile;
		endif;
		wp_reset_postdata();
	}

	// setup the arguments for the webinar.
	$args = array(
		'posts_per_page' => $webinar_quantity,
		'post_type'      => array( 'lf_webinar' ),
		'post_status'    => array( 'publish' ),
		'meta_key'       => 'lf_webinar_date',
		'order'          => 'ASC',
		'meta_type'      => 'DATETIME',
		'orderby'        => 'meta_value',
		'no_found_rows'  => true,
		'meta_query'     => array(
			array(
				'key'     => 'lf_webinar_date',
				'value'   => date_i18n( 'Y-m-d' ),
				'compare' => '>',
				'type'    => 'DATETIME',
			),
			array(
				'key'     => 'lf_webinar_recording',
				'compare' => 'NOT EXISTS',
			),
		),
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		?>
	<div class="wp-block-column " style="flex-basis:33.33%">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();

				get_template_part(
					'components/upcoming-webinars-item',
					null,
					array(
						'show_images' => $show_images,
					)
				);
	endwhile;
			wp_reset_postdata();
			?>
	</div>
		<?php
	}
	?>
		</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'homepage-latest-news-webinar', 'homepage_latest_news_webinar_shortcode' );

 /**
  * Display Announcements on home page.
  * [homepage-announcements]
  */
function homepage_announcements_shortcode() {

	$args = array(
		'post_type'           => array( 'post' ),
		'post_status'         => array( 'publish' ),
		'has_password'        => false,
		'posts_per_page'      => '5',
		'ignore_sticky_posts' => true,
		'order'               => 'DESC',
		'orderby'             => 'date',
		'no_found_rows'       => true,
		'tax_query'           => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => 787,
			),
		),
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {

		ob_start();
		?>
<section class="home-announcement home-padding">
<div class="home-announcement-icon">
		<?php
		$image = new Image();
		$image->get_svg( 'icon-newspaper.svg' );
		?>
</div>
<div class="announcement-slider-wrapper">
		<?php

		while ( $query->have_posts() ) {
			$query->the_post();
			?>
<div class="home-announcement-item">
<p class="is-style-max-width-100"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
<span class="date-icon"> <?php echo get_the_date( 'F j, Y' ); ?></span>
</div>
			<?php
		}
	}
	wp_reset_postdata();

	?>
</div>

</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'homepage-announcements', 'homepage_announcements_shortcode' );



 /**
  * Home Hero
  * [homepage-hero case-study-ids="34869,34901,60670,34928,34890,63299"]
  *
  * @param array $atts Attributes.
  */
function homepage_hero_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'case-study-ids' => '', // set default.
		),
		$atts,
		'homepage-hero'
	);

	$metrics = LF_Utils::get_homepage_metrics();

	ob_start();
	?>

<section class="home-hero">
<!-- column 1 -->
<div class="home-hero__col1">
<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>

	<h1>Building sustainable ecosystems for cloud native software</h1>
	<ul class="data-display no-style h4">
		<li><span><?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>K+</span> Contributors</li>
		<li><span><?php echo esc_html( round( $metrics['contributions'] / 1000000, 1 ) ); ?>M+</span> Contributions</li>
		<li><span><?php echo esc_html( round( $metrics['linesofcode'] / 1000000, 1 ) ); ?>M+</span> Lines of Code</li>
	</ul>
	<p class="h4 fw-400">
	Cloud Native Computing Foundation (CNCF) serves as the vendor-neutral home for many of the fastest-growing open source projects, including Kubernetes, Prometheus, and Envoy.
	</p>
	<p class="h4 is-style-small-bottom-margin"><a href="/about/who-we-are/" class="is-style-arrow-cta">Learn more about CNCF</a></p>
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer show-mobile-only"></div>
</div>

<!-- column 2 -->
<div class="home-hero__col2 has-white-color background-image-wrapper">
	<?php echo homepage_casestudies_shortcode( $atts ); // phpcs:ignore ?>
</div>

</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'homepage-hero', 'homepage_hero_shortcode' );


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
				<a href="/enduser/" class="is-style-arrow-cta has-white-color">Explore
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
				class="is-style-arrow-cta has-white-color">Start contributing</a>
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
			<a href="/about/join/" class="is-style-arrow-cta has-white-color">Become a
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
 * Home Hosted Projects
 * [homepage-hosted-projects]
 */
function homepage_hosted_projects_shortcode() {

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
	?>

<section class="hosted-projects">
	<div class="">

		<h2>CNCF hosted projects</h2>

	  <?php if ( $graduated_count && $incubating_count && $sandbox_count ) : ?>

<ul class="data-display no-style">
<li><a href="/projects/">
<span
data-purecounter-end="<?php echo esc_html( $graduated_count ); ?>"
data-purecounter-delay="50"
class="purecounter"><?php echo esc_html( $graduated_count ); ?></span>
		Graduated Projects
	</a></li>
<li><a href="/projects/#incubating">
<span
data-purecounter-end="<?php echo esc_html( $incubating_count ); ?>"
data-purecounter-delay="50"
class="purecounter"><?php echo esc_html( $incubating_count ); ?></span>
		Incubating Projects
	</a></li>
<li><a href="/sandbox-projects/">
<span
data-purecounter-end="<?php echo esc_html( $sandbox_count ); ?>"
data-purecounter-delay="25"
class="purecounter"><?php echo esc_html( $sandbox_count ); ?></span>
		Sandbox Projects
	</a></li>
</ul>
<?php endif; ?>

		<p
			class="h5">The CNCF hosts critical components of the global technology infrastructure. CNCF brings together the world's top developers, end users, and vendors and runs the largest open source developer conferences. CNCF is part of the non-profit <a rel="noopener" href="https://linuxfoundation.org" class="external is-primary-color" target="_blank">Linux Foundation</a>.</p>

		<p
			class="h4"><a href="/projects/" class="is-style-arrow-cta">Explore CNCF Projects</a></p>

		<div style="height:20px" aria-hidden="true" class="wp-block-spacer">
		</div>

	</div>

	<div>


	  <?php

		if ( $all_project_logos ) :

			$all_project_logos = LF_Utils::partition( $all_project_logos, 3 );
			?>
		<div class="project-slider-wrapper">
			<?php
			$i = 0;
			foreach ( $all_project_logos as $project_logos ) {
				$i++;
				$direction = ( $i % 2 == 0 ) ? 'rtl' : 'ltr'; // phpcs:ignore

				?>
			<div class="slider project-slider-<?php echo esc_html( $i ); ?>"
				dir="<?php echo esc_html( $direction ); ?>">
				<?php foreach ( $project_logos as $project_logo ) { ?>
				<div class="project-slide" dir="ltr">
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

	</div>
</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
	add_shortcode( 'homepage-hosted-projects', 'homepage_hosted_projects_shortcode' );


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
<h2>October 11-15, 2021</h2>
<p class="h5">The CNCF’s flagship conference gathers adopters and technologists from leading open source and cloud native communities for four days of education and advancement of cloud native computing. <strong>#KubeCon + #CloudNativeCon</strong></p>

<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/" class="button external" target="_blank" rel="noopener">Learn more</a>

</div>
<div><a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/" target="_blank" rel="noopener"><img loading="lazy" src="https://events.linuxfoundation.org/wp-content/uploads/2020/11/KubeCon_NA_2021_web_web-logo-white-1.svg" alt="Kubecon 2021"></a></div>

<div>
<p class="event-highlight-video-description">KubeCon + CloudNativeCon North America 2019 Highlights</p>
<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
<div class="wp-block-lf-youtube-lite"><lite-youtube videoid="56ftznhkdh0"></lite-youtube></div>
</div></figure>
</div>

</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
	add_shortcode( 'homepage-event-highlight', 'homepage_event_highlight_shortcode' );

<?php
/**
 * Single project page template.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$logo = get_post_meta( get_the_ID(), 'lf_project_logo', true );

$stage            = Lf_Utils::get_term_names( get_the_ID(), 'lf-project-stage', true );
$description      = get_post_meta( get_the_id(), 'lf_project_description', true );
$project_category = get_post_meta( get_the_ID(), 'lf_project_category', true );
$external_url     = get_post_meta( get_the_ID(), 'lf_project_external_url', true );

$date_accepted = get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ? gmdate( 'F j, Y', strtotime( get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ) ) : '';

// Links for Project.
$github         = get_post_meta( get_the_ID(), 'lf_project_github', true );
$stack_overflow = get_post_meta( get_the_ID(), 'lf_project_stack_overflow', true );
$devstats       = get_post_meta( get_the_ID(), 'lf_project_devstats', true );
$logos          = get_post_meta( get_the_ID(), 'lf_project_logos', true );
$mail           = get_post_meta( get_the_ID(), 'lf_project_mail', true );
$blog           = get_post_meta( get_the_ID(), 'lf_project_blog', true );
$twitter        = get_post_meta( get_the_ID(), 'lf_project_twitter', true );
$slack          = get_post_meta( get_the_ID(), 'lf_project_slack', true );
$youtube        = get_post_meta( get_the_ID(), 'lf_project_youtube', true );
$gitter         = get_post_meta( get_the_ID(), 'lf_project_gitter', true );

$project_slug = strtolower( get_the_title() );

?>

<main class="projects-single">
	<article class="container wrap">

		<div class="projects-single-box lf-grid">
			<!-- column 1 -->
			<div class="projects-single-box__col1">

				<a class="projects-single-box__link"
					href="<?php echo esc_url( $external_url ); ?>"><img
						src="<?php echo esc_url( $logo ); ?>" loading="lazy"
						title="Visit <?php echo esc_html( the_title_attribute() ); ?> website"
						class="projects-single-box__image"></a>
			</div>

			<!-- column 2 -->
			<div class="projects-single-box__col2">
				<?php if ( $description ) { ?>
				<h2 class="projects-single-box__description">
					<?php echo esc_html( $description ); ?>
				</h2>
				<div style="height:20px" aria-hidden="true"
					class="wp-block-spacer">
				</div>
					<?php
				}

				if ( $date_accepted && $stage ) {
					?>
				<p class="projects-single-box__accepted">
					<?php the_title(); ?>&nbsp;was accepted to CNCF on
<strong><?php echo esc_html( $date_accepted ); ?></strong>
and is at the
<strong><?php echo esc_html( $stage ); ?></strong>
project maturity level.
</p>
					<?php
				} elseif ( $stage ) {
					?>
				<p class="projects-single-box__accepted">
					<?php the_title(); ?>&nbsp;is at the <strong><?php echo esc_html( $stage ); ?></strong>
project maturity level.
</p>
					<?php
				}
				?>

				<div style="height:60px" aria-hidden="true"
					class="wp-block-spacer is-style-40-60">
				</div>

				<div class="projects-single-box__links">

					<?php if ( $external_url ) : ?>

					<div class="wp-block-button is-style-reduced-height"><a
							href="<?php echo esc_url( $external_url ); ?>"
							class="wp-block-button__link">Visit Project
							Website</a></div>
						<?php
endif;
					?>
					<div class="projects-single-box__icons">

						<?php if ( $github ) : ?>
						<a title="<?php the_title_attribute(); ?> on Github"
							href="<?php echo esc_html( $github ); ?>"><?php LF_utils::get_svg( '/social/boxed-github.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $devstats ) : ?>
						<a title="<?php the_title_attribute(); ?> on DevStats"
							href="<?php echo esc_html( $devstats ); ?>"><?php LF_utils::get_svg( '/social/boxed-lf-devstats.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $logos ) : ?>
						<a title="<?php the_title_attribute(); ?> Logos"
							href="<?php echo esc_html( $logos ); ?>"><?php LF_utils::get_svg( '/social/boxed-lf-artwork.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $stack_overflow ) : ?>
						<a title="<?php the_title_attribute(); ?> on Stack Overflow"
							href="<?php echo esc_html( $stack_overflow ); ?>"><?php LF_utils::get_svg( '/social/boxed-stack-overflow.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $twitter && ( preg_match( '/^https?:\/\/(www\.)?twitter\.com\/(#!\/)?(?<name>[^\/]+)(\/\w+)*$/', $twitter, $matches ) ) && ( 'CloudNativeFdn' != $matches['name'] ) ) : ?>
						<a title="<?php the_title_attribute(); ?> on Twitter"
							href="<?php echo esc_html( $twitter ); ?>"><?php LF_utils::get_svg( '/social/boxed-twitter.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $blog ) : ?>
						<a title="<?php the_title_attribute(); ?> Blog"
							href="<?php echo esc_html( $blog ); ?>"><?php LF_utils::get_svg( '/social/boxed-blog.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $mail ) : ?>
						<a title="<?php the_title_attribute(); ?> Discussion Group"
							href="<?php echo esc_html( $mail ); ?>"><?php LF_utils::get_svg( '/social/boxed-discussion.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $slack ) : ?>
						<a title="<?php the_title_attribute(); ?> Slack"
							href="<?php echo esc_html( $slack ); ?>"><?php LF_utils::get_svg( '/social/boxed-slack.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $youtube ) : ?>
						<a title="<?php the_title_attribute(); ?> on YouTube"
							href="<?php echo esc_html( $youtube ); ?>"><?php LF_utils::get_svg( '/social/boxed-youtube.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $gitter ) : ?>
						<a title="<?php the_title_attribute(); ?> on Gitter"
							href="<?php echo esc_html( $gitter ); ?>"><?php LF_utils::get_svg( '/social/boxed-gitter.svg' ); ?></a>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>

		<div style="height:120px" aria-hidden="true"
			class="wp-block-spacer is-style-80-120"></div>

		<?php
		// CASE STUDIES.
		$related_args = array(
			'posts_per_page'     => 2,
			'ignore_custom_sort' => true,
			'post_type'          => array( 'lf_case_study' ),
			'post_status'        => array( 'publish' ),
			'order'              => 'DESC',
			'orderby'            => 'date',
			'no_found_rows'      => true,
			'tax_query'          => array(
				array(
					'taxonomy' => 'lf-project',
					'field'    => 'slug',
					'terms'    => $project_slug,
				),
			),
		);

		$related_query = new WP_Query( $related_args );

		if ( $related_query->have_posts() ) :
			?>

		<div class="wp-block-group is-style-no-padding is-style-see-all">
			<div class="wp-block-columns are-vertically-aligned-bottom">
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:70%">
					<h3 class="is-style-section-heading"><?php the_title(); ?>
						case studies</h3>
				</div>
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:30%">
					<p class="has-text-align-right is-style-link-cta"><a href="<?php echo esc_url( '/case-studies/?_sft_lf-project=' . $project_slug ); ?>">Related Case
Studies</a></p>
				</div>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>

			<div class="case-studies">
				<?php
				while ( $related_query->have_posts() ) {
					$related_query->the_post();
					get_template_part( 'components/case-study-item' );
				}
				?>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>
		</div>


		<div style="height:120px" aria-hidden="true"
			class="wp-block-spacer is-style-80-120"></div>

			<?php
			wp_reset_postdata();
endif;
		?>

		<?php
		// ONLINE PROGRAMS.

		$programs_args = array(
			'posts_per_page'     => 3,
			'ignore_custom_sort' => true,
			'post_type'          => array( 'lf_webinar' ),
			'post_status'        => array( 'publish' ),
			'meta_key'           => 'lf_webinar_date',
			'order'              => 'DESC',
			'orderby'            => 'meta_value',
			'no_found_rows'      => true,
			'meta_query'         => array(
				array(
					'key'     => 'lf_webinar_recording_url',
					'value'   => 0,
					'compare' => '>',
				),
			),
			'tax_query'          => array(
				array(
					'taxonomy' => 'lf-project',
					'field'    => 'slug',
					'terms'    => $project_slug,
				),
			),
		);

		$programs_query = new WP_Query( $programs_args );

		if ( $programs_query->have_posts() ) :

			?>

		<div class="wp-block-group is-style-no-padding is-style-see-all">
			<div class="wp-block-columns are-vertically-aligned-bottom">
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:70%">
					<h3 class="is-style-section-heading">Recorded
						<?php the_title(); ?> programs</h3>
				</div>
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:30%">
					<p class="has-text-align-right is-style-link-cta"><a href="<?php echo esc_url( '/online-programs?_sft_lf-project=' . $project_slug ); ?>">See
more recordings</a></p>
				</div>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>
			<div class="webinars columns-three">
				<?php
				while ( $programs_query->have_posts() ) :
					$programs_query->the_post();

					get_template_part( 'components/webinar-recorded-item' );

		endwhile;
				?>

			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>
		</div>

		<div style="height:120px" aria-hidden="true"
			class="wp-block-spacer is-style-80-120"></div>

			<?php
			wp_reset_postdata();
endif;
		?>
		<?php
		// NEWS.

		$related_args = array(
			'posts_per_page'     => 3,
			'ignore_custom_sort' => true,
			'post_type'          => array( 'post' ),
			'post_status'        => array( 'publish' ),
			'order'              => 'DESC',
			'orderby'            => 'date',
			'no_found_rows'      => true,
			's'                  => $project_slug,
		);

		$related_query = new WP_Query( $related_args );

		if ( $related_query->have_posts() ) :
			?>
		<div class="wp-block-group is-style-no-padding is-style-see-all">
			<div class="wp-block-columns are-vertically-aligned-bottom">
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:80%">
					<h3 class="is-style-section-heading">Recent
						<?php the_title(); ?> news</h3>
				</div>
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:20%">
					<p class="has-text-align-right is-style-link-cta"><a
href="<?php echo esc_url( '/?post_type=post&s=' . $project_slug ); ?>">See
all news</a></p>
				</div>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>

			<div class="columns-three">
				<?php
				while ( $related_query->have_posts() ) {
					$related_query->the_post();

					get_template_part( 'components/news-item-vertical' );
				}
				?>
			</div>

			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>
		</div>


		<div style="height:120px" aria-hidden="true"
			class="wp-block-spacer is-style-80-120"></div>

			<?php
			wp_reset_postdata();
endif;
		?>

		<?php
		// TWITTER.
		// Check if Twitter is present, parses username, checks if not CNCF account.
		if ( $twitter && ( preg_match( '/^https?:\/\/(www\.)?twitter\.com\/(#!\/)?(?<name>[^\/]+)(\/\w+)*$/', $twitter, $matches ) ) && ( 'CloudNativeFdn' !== $matches['name'] ) ) :

			// Only continue if some tweets are returned.
			$out = do_shortcode( '[custom-twitter-feeds num=8 layout=masonry includeretweets=false showheader=true showbutton=false masonrycols=4 masonrymobilecols=1 screenname="' . esc_html( $matches['name'] ) . '"]' );
			if ( ! strpos( $out, 'Unable to load Tweets' ) ) :
				?>
		<div class="wp-block-group is-style-no-padding is-style-see-all">
			<div class="wp-block-columns are-vertically-aligned-bottom">
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:80%">
					<h3 class="is-style-section-heading">Latest tweets from
						<?php the_title(); ?></h3>
				</div>
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:20%">
					<p
						class="has-text-align-right is-style-link-cta"><a href="<?php echo esc_url( $twitter ); ?>">See all tweets</a></p>
				</div>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>

				<?php
		echo $out; //phpcs:ignore
				?>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer"></div>
		</div>
		<div style="height:100px" aria-hidden="true"
				class="wp-block-spacer"></div>
				<?php

		endif;
endif;
		?>

	</article>
</main>

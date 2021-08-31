<?php
/**
 * Single project page template.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$logo  = get_post_meta( get_the_ID(), 'lf_project_logo', true );
$image = new Image();

$stage            = Lf_Utils::get_term_names( get_the_ID(), 'lf-project-stage', true );
$description      = get_post_meta( get_the_id(), 'lf_project_description', true );
$project_category = get_post_meta( get_the_ID(), 'lf_project_category', true );
$external_url     = get_post_meta( get_the_ID(), 'lf_project_external_url', true );

$date_accepted = get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ? gmdate( 'n/j/Y', strtotime( get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ) ) : '';

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

get_template_part( 'components/hero' );
?>

<main class="page-content">
	<article class="container wrap entry-content">

		<div class="project-single-hero">
			<!-- column 1 -->
			<div class="project-single-hero-logo">
				<div class="project-thumbnail-container">
				<a class="external" target="_blank"
					href="<?php echo esc_url( $external_url ); ?>"><img src="<?php echo esc_url( $logo ); ?>"
						title="Visit <?php echo esc_html( the_title() ); ?> website"
						class="project-thumbnail"></a>
				</div>
			</div>

			<!-- column 2 -->
			<div class="project-single-hero-details">
				<?php if ( $description ) { ?>
				<h4 class="margin-bottom-small fw-400">Description:
					<strong><?php echo esc_html( $description ); ?></strong>
				</h4>
					<?php
				}
				?>

				<?php if ( $date_accepted ) { ?>
				<h4 class="margin-bottom-small fw-400">Accepted to CNCF:
					<strong><?php echo esc_html( $date_accepted ); ?></strong>
				</h4>
					<?php
				}
				?>

				<?php if ( $stage ) { ?>
				<h4 class="margin-bottom-small fw-400">Project Stage:
					<strong><?php echo esc_html( $stage ); ?></strong>
				</h4>
					<?php
				}
				?>

				<div
					style="display: flex; flex-wrap: wrap; align-content: center;">
					<h4 class="margin-bottom-small fw-400">Project Links:</h4>

					<div class="project-icons">

						<?php if ( $github ) : ?>
						<a title="<?php the_title(); ?> on Github"
							href="<?php echo esc_html( $github ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/github.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $devstats ) : ?>
						<a title="<?php the_title(); ?> on DevStats"
							href="<?php echo esc_html( $devstats ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/lf-devstats.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $logos ) : ?>
						<a title="<?php the_title(); ?> Logos"
							href="<?php echo esc_html( $logos ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/lf-artwork.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $stack_overflow ) : ?>
						<a title="<?php the_title(); ?> on Stack Overflow"
							href="<?php echo esc_html( $stack_overflow ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/stack-overflow.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $twitter ) : ?>
						<a title="<?php the_title(); ?> on Twitter"
							href="<?php echo esc_html( $twitter ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/twitter.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $blog ) : ?>
						<a title="<?php the_title(); ?> Blog"
							href="<?php echo esc_html( $blog ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/blog.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $mail ) : ?>
						<a title="<?php the_title(); ?> Contact"
							href="<?php echo esc_html( $mail ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/email.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $slack ) : ?>
						<a title="<?php the_title(); ?> Slack"
							href="<?php echo esc_html( $slack ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/slack.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $youtube ) : ?>
						<a title="<?php the_title(); ?> on YouTube"
							href="<?php echo esc_html( $youtube ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/youtube.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $gitter ) : ?>
						<a title="<?php the_title(); ?> on Gitter"
							href="<?php echo esc_html( $gitter ); ?>"
							rel="noopener"
							target="_blank"><?php $image->get_svg( '/social/gitter.svg' ); ?></a>
						<?php endif; ?>

					</div>
				</div>

				<?php if ( $external_url ) { ?>

				<a class="button margin-top external" target="_blank"
					href="<?php echo esc_url( $external_url ); ?>">Visit Project
					Website</a>
					<?php
				}
				?>

			</div>
		</div>
		<!-- wp:spacer {"height":80,"className":"is-style-80-responsive"} -->
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<!-- /wp:spacer -->
		<?php get_template_part( 'components/project-single-online-programs' ); ?>
		<?php get_template_part( 'components/project-single-case-studies' ); ?>
		<?php get_template_part( 'components/project-single-speakers' ); ?>
		<?php get_template_part( 'components/project-single-news' ); ?>

		<?php if ( $twitter && ( preg_match( '/^https?:\/\/(www\.)?twitter\.com\/(#!\/)?(?<name>[^\/]+)(\/\w+)*$/', $twitter, $matches ) ) ) : ?>

		<div class="wp-block-columns is-style-section-header">
			<div class="wp-block-column bh-01" style="flex-basis:70%">
				<h3>Latest tweets from <?php the_title(); ?></h3>
			</div>
			<div class="wp-block-column bh-02" style="flex-basis:30%">
				<h6 class="is-style-arrow-cta"><a
						href="<?php echo esc_url( $twitter ); ?>">See all tweets</a>
				</h6>
			</div>
		</div>
			<?php echo do_shortcode( '[custom-twitter-feeds screenname=' . esc_url( $matches['name'] ) . ' num=3]' ); ?>

		<?php endif; ?>

	</article>
</main>

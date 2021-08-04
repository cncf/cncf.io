<?php
/**
 * Single project page template.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$description = get_post_meta( get_the_id(), 'lf_project_description', true );
$external_url = get_post_meta( get_the_ID(), 'lf_project_external_url', true );
$date_accepted = get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ? ' (accepted to CNCF on ' . gmdate( 'n/j/Y', strtotime( get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ) ) . ')' : '';
$project_category = get_post_meta( get_the_ID(), 'lf_project_category', true );
$github = get_post_meta( get_the_ID(), 'lf_project_github', true );
$stack_overflow = get_post_meta( get_the_ID(), 'lf_project_stack_overflow', true );
$devstats = get_post_meta( get_the_ID(), 'lf_project_devstats', true );
$logos = get_post_meta( get_the_ID(), 'lf_project_logos', true );
$mail = get_post_meta( get_the_ID(), 'lf_project_mail', true );
$blog = get_post_meta( get_the_ID(), 'lf_project_blog', true );
$twitter = get_post_meta( get_the_ID(), 'lf_project_twitter', true );
$slack = get_post_meta( get_the_ID(), 'lf_project_slack', true );
$youtube = get_post_meta( get_the_ID(), 'lf_project_youtube', true );
$gitter = get_post_meta( get_the_ID(), 'lf_project_gitter', true );
$logo = get_post_meta( get_the_ID(), 'lf_project_logo', true );
$image = new Image();
?>

<section class="hero" id="maincontent">
	<div class="container wrap no-background">

	<div class="project-box">
		<div class="project-thumbnail-container">
		<img src="<?php echo esc_url( $logo ); ?>"
			title="<?php echo esc_html( the_title() . $date_accepted ); ?>"
			class="project-thumbnail">
		</div>

		<div class="project-icons">

				<?php if ( $github ) : ?>
			<a title="<?php the_title(); ?> on Github"
				href="<?php echo esc_html( $github ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/github.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $devstats ) : ?>
			<a title="<?php the_title(); ?> on DevStats"
				href="<?php echo esc_html( $devstats ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/lf-devstats.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $logos ) : ?>
			<a title="<?php the_title(); ?> Logos"
				href="<?php echo esc_html( $logos ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/lf-artwork.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $stack_overflow ) : ?>
			<a title="<?php the_title(); ?> on Stack Overflow"
				href="<?php echo esc_html( $stack_overflow ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/stack-overflow.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $twitter ) : ?>
			<a title="<?php the_title(); ?> on Twitter"
				href="<?php echo esc_html( $twitter ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/twitter.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $blog ) : ?>
			<a title="<?php the_title(); ?> Blog"
				href="<?php echo esc_html( $blog ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/blog.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $mail ) : ?>
			<a title="<?php the_title(); ?> Contact"
				href="<?php echo esc_html( $mail ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/email.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $slack ) : ?>
			<a title="<?php the_title(); ?> Slack"
				href="<?php echo esc_html( $slack ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/slack.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $youtube ) : ?>
			<a title="<?php the_title(); ?> on YouTube"
				href="<?php echo esc_html( $youtube ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/youtube.svg' ); ?></a>
			<?php endif; ?>

				<?php if ( $gitter ) : ?>
			<a title="<?php the_title(); ?> on Gitter"
				href="<?php echo esc_html( $gitter ); ?>" rel="noopener"
				target="_blank"><?php $image->get_svg( '/social/gitter.svg' ); ?></a>
			<?php endif; ?>

		</div>

		<p class="hero-parent-link">
			<a href="/projects/" title="Go to projects">Project</a>
		</p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php the_title(); ?>
		</h1>
		<a href="<?php echo esc_url( $external_url ); ?>" rel="noopener"
			target="_blank"
			title="Go to <?php the_title(); ?> website"
			class="project-thumbnail-container">
			Go to <?php the_title(); ?> website
		</a>
	</div>
	</div>
</section>

<main class="project-single">
	<article class="container wrap">
		<p class="is-style-max-width-900 has-header-3-font-size">
			<?php echo esc_html( $description ); ?>
		</p>

		<?php get_template_part( 'components/project-single-online-programs' ); ?>
		<?php get_template_part( 'components/project-single-case-studies' ); ?>
		<?php get_template_part( 'components/project-single-speakers' ); ?>
		<?php get_template_part( 'components/project-single-news' ); ?>

	</article>
</main>

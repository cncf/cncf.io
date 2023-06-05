<?php
/**
 * PJR Page.
 *
 * Header and then content output of a PJR template.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$project_logo_id   = get_field( 'pjr_project_logo' );
$project_name      = get_field( 'pjr_project_name' );
$project_url       = get_field( 'pjr_project_url' );
$report_title      = get_field( 'pjr_report_title' );
$show_social_share = get_field( 'pjr_show_social_share' ) ?? false;

wp_enqueue_style( 'pjr', get_template_directory_uri() . '/build/pjr-template.min.css', array(), filemtime( get_template_directory() . '/build/pjr-template.min.css' ), 'all' );

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/pjr-template.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<main class="pjr">
	<article class="container wrap">

		<section class="hero">
			<div class="title-wrapper">
				<?php
				get_template_part( 'components/title-links' );
				?>
			</div>
			<div class="hero__container">
				<?php
				if ( $project_logo_id ) {
					LF_Utils::display_responsive_images( $project_logo_id, 'full', '600px', 'hero__logo', 'eager' );
					?>
					<?php
				}
				?>

				<div class="lf-grid hero__grid">
					<?php
					if ( $report_title ) {
						?>
					<div class="hero__grid-col1">
						<h1 class="hero__title"><?php echo esc_html( $report_title ); ?></h1>
					</div>
						<?php
					}
					?>

<?php
if ( $show_social_share ) {
	?>
					<div class="hero__grid-col2">
					<?php
					if ( $show_social_share ) :
						get_template_part( 'components/social-share' );
					endif;
					?>
					</div>
					<?php
}
?>
				</div>

				<?php
				if ( $show_social_share && $report_title ) {
					?>
				<div aria-hidden="true" class="report-spacer-60"></div>
					<?php
				}
				?>

				<div class="thin-hr"></div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid hero__grid">
					<div class="hero__grid-col1 published">
						<!-- Calendar Icon -->
						<svg width="25" height="27" viewBox="0 0 25 27" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.2 3.935H4.4a2.4 2.4 0 0 0-2.4 2.4v16.8a2.4 2.4 0 0 0 2.4 2.4h16.8a2.4 2.4 0 0 0 2.4-2.4v-16.8a2.4 2.4 0 0 0-2.4-2.4Zm-3.602-2.4v4.8M8 1.535v4.8m-6 4.8h21.6" opacity=".88" stroke="#000" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						<span>Published: <?php the_date(); ?></span>
					</div>
					<?php
					if ( $project_url ) {
						?>
					<div class="hero__grid-col2 project-website">
						<!-- Globe Icon -->
						<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 23.75c6.213 0 11.25-5.037 11.25-11.25S18.713 1.25 12.5 1.25 1.25 6.287 1.25 12.5 6.287 23.75 12.5 23.75ZM1.25 12.5h22.5" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.5 1.25A17.213 17.213 0 0 1 17 12.5a17.213 17.213 0 0 1-4.5 11.25A17.212 17.212 0 0 1 8 12.5a17.212 17.212 0 0 1 4.5-11.25v0Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
						<a title="XXXX Project website"
							href="<?php echo esc_url( $project_url ); ?>">
						<?php echo esc_html( preg_replace( '#^(https?://)?(www\.)?#', '', $project_url ) ); ?>
						</a>
					</div>
						<?php
					}
					?>

				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="thin-hr"></div>

				<div aria-hidden="true" class="report-spacer-100"></div>
			</div>
		</section>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
		<?php
		if ( $show_social_share ) {
			?>
	<div aria-hidden="true" class="report-spacer-100"></div>
					<?php
					if ( $show_social_share ) :
						get_template_part( 'components/social-share' );
							endif;
					?>
					<?php
		}
		?>
	</article>
</main>

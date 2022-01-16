<?php
/**
 * Report content - the loop
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>

<section class="hero" id="maincontent">
	<div class="container wrap no-background">

		<p class="hero-parent-link">
			<a href="<?php echo esc_url( get_home_url() ); ?>/reports/" title="See all Reports">Report</a>
		</p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>


	</div>
</section>
<main class="newsroom-single">
	<article class="container wrap">
	<?php
	// Get the Category Author.
	$report_type = ucwords( Lf_Utils::get_term_names( get_the_ID(), 'lf-report-type', true ) );
	$report_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-report-type', true );

	if ( $report_type ) :
		$report_type_link = '?_sft_lf-report-type=' . $report_type_slug . '';
		?>
		<a class="skew-box secondary centered margin-bottom-small" title="See more <?php echo esc_attr( $report_type ); ?> reports" href="<?php echo esc_url( $report_type_link ); ?>">
		<?php echo esc_html( $report_type ); ?> Report</a>
	<?php endif; ?>

	<p class="date-author-row"><span
			class="posted-date date-icon">Published on
			<?php
			echo get_the_date();
			?>
		</span>
		</p>
	<div class="entry-content post-content">
		<?php
		the_content();
		get_template_part( 'components/social-share' );
		?>
	</div>
	</article>
</main>

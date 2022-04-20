<?php
/**
 * Report item
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<main class="report-single">
	<article class="container wrap">
		<?php
		$pdf_url = get_post_meta( get_the_ID(), 'lf_report_pdf_url', true );

		if ( ! $pdf_url ) {
			the_content();
		} else {
			?>

<div class="wp-block-group is-style-box-shadow has-white-background-color has-background">
<div class="wp-block-columns">
<div class="wp-block-column">
			<?php the_post_thumbnail(); ?>
			<div style="height:15px" aria-hidden="true" class="wp-block-spacer"></div>
</div>

<div class="wp-block-column">
			<?php the_content(); ?>
<div style="height:100px" aria-hidden="true" class="wp-block-spacer is-style-20-40"></div>

<div class="wp-block-buttons">
<div class="wp-block-button"><a class="wp-block-button__link" href="<?php echo esc_url( $pdf_url ); ?>">download report</a></div>
</div></div></div></div>
<div style="height:100px" aria-hidden="true" class="wp-block-spacer is-style-30-60"></div>
			<?php
		}
		get_template_part( 'components/social-share' );
		?>
	</article>
</main>

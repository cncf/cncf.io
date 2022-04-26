<?php
/**
 * Report item
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$pdf_url = get_post_meta( get_the_ID(), 'lf_report_pdf_url', true );

// Merge classes.
$classes = LF_Utils::merge_classes(
	array(
		'container',
		'wrap',
		$pdf_url ? '' : 'page-content',
	)
);
?>

<main class="report-single">
	<article class="<?php echo esc_html( $classes ); ?>">

		<?php
		if ( ! $pdf_url ) {
			the_content();
		} else {
			?>
		<div
			class="wp-block-group is-style-box-shadow has-white-background-color has-background">
			<div class="wp-block-columns is-style-70px-gap">
				<div class="wp-block-column">
					<?php if ( get_post_thumbnail_id() ) : ?>
					<figure class="is-style-rounded-corners">
						<?php
						LF_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-700', '590px', 'lazy', the_title_attribute() );
						?>
					</figure>
					<?php endif; ?>
					<div style="height:15px" aria-hidden="true"
						class="wp-block-spacer"></div>
				</div>

				<div class="wp-block-column">
					<?php the_content(); ?>
					<div aria-hidden="true"
						class="wp-block-spacer is-style-20-40"></div>

					<div class="wp-block-buttons">
						<div class="wp-block-button"><a
								class="wp-block-button__link"
								href="<?php echo esc_url( $pdf_url ); ?>">Download
								Report</a></div>
					</div>
				</div>
			</div>
		</div>
		<div style="height:30px" aria-hidden="true" class="wp-block-spacer">
		</div>
			<?php
		}
		get_template_part( 'components/social-share' );
		?>
	</article>
</main>

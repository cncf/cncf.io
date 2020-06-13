<?php
/**
 * Upcoming Webinar Item
 *
 * Singular upcoming webinar item.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// get author category.
$author_category = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );

// get companies (presented by).
$company = Lf_Utils::get_term_names( get_the_ID(), 'lf-company' );

// get webinar date and time.
$webinar_date              = get_post_meta( get_the_ID(), 'lf_webinar_date', true );
$webinar_start_time        = get_post_meta( get_the_ID(), 'lf_webinar_start_time', true );
$webinar_start_time_period = get_post_meta( get_the_ID(), 'lf_webinar_start_time_period', true );
$webinar_timezone          = get_post_meta( get_the_ID(), 'lf_webinar_timezone', true );
$dat_webinar_start         = Lf_Utils::get_webinar_date_time( $webinar_date, $webinar_start_time, $webinar_start_time_period, $webinar_timezone, true );
$date_and_time             = str_replace( ':00', '', $dat_webinar_start->format( 'l F j, g:iA T' ) );
?>
<article class="webinars-upcoming-box">

	<div class="webinars-upcoming-text-wrapper">

		<!-- Category of Webinar  -->
		<span class="skew-box secondary margin-bottom-small">CNCF
			<?php echo esc_html( $author_category ); ?> Webinar</span>

		<!-- Date of webinar  -->
		<?php if ( $date_and_time ) : ?>
		<span class="skew-box"><?php echo esc_html( $date_and_time ); ?></span>
		<?php endif; ?>

		<!-- Title of webinar  -->
		<h5 class="webinar-title"><a href="<?php the_permalink(); ?>"
				title="<?php esc_html( the_title() ); ?> on <?php echo esc_html( $date_and_time ); ?>"><?php esc_html( the_title() ); ?></a>
		</h5>

		<!-- Presented by... Company  -->
		<?php if ( $company ) : ?>
		<span class="presented-by">Presented by
			<?php echo esc_html( $company ); ?></span>
		<?php endif; ?>

	</div>
</article>

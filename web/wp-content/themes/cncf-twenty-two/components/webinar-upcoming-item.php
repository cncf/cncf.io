<?php
/**
 * Upcoming Webinar Item
 *
 * Singular upcoming webinar item.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// get companies (presented by).
$company = Lf_Utils::get_term_names( get_the_ID(), 'lf-company' );

// registration URL.
$webinar_reg_url           = get_post_meta( get_the_ID(), 'lf_webinar_registration_url', true );

// get webinar date and time.
$webinar_date = get_post_meta( get_the_ID(), 'lf_webinar_date', true );
$webinar_start_time        = get_post_meta( get_the_ID(), 'lf_webinar_start_time', true );
$webinar_start_time_period = get_post_meta( get_the_ID(), 'lf_webinar_start_time_period', true );
$webinar_timezone          = get_post_meta( get_the_ID(), 'lf_webinar_timezone', true );
$dat_webinar_start         = Lf_Utils::get_webinar_date_time( $webinar_date, $webinar_start_time, $webinar_start_time_period, $webinar_timezone, true );
$date_and_time             = $dat_webinar_start->format( 'D F j' );

if ( $webinar_reg_url ) {
	$link_url = $webinar_reg_url;
} else {
	$link_url = get_the_permalink();
}
?>
<article class="webinar-upcoming-item">

		<?php
		// Date of Webinar.
		if ( $date_and_time ) :
			?>
		<span class="webinar-upcoming-item__date "><?php echo esc_html( $date_and_time ); ?></span>
		<?php endif; ?>

		<a class="webinar-upcoming-item__link" href="<?php echo esc_url( $link_url ); ?>"
				title="<?php esc_html( the_title() ); ?> on <?php echo esc_html( $date_and_time ); ?>"><h3 class="webinar-upcoming-item__title"><?php esc_html( the_title() ); ?></h3></a>

		<?php
		// Presented by... Company.
		if ( $company ) :
			?>
		<span class="webinar-upcoming-item__company">Presented by
			<?php echo esc_html( $company ); ?></span>
		<?php endif; ?>

</article>

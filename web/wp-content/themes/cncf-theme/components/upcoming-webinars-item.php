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

// TODO: Remove some of these.
$recording    = get_post_meta( get_the_ID(), 'cncf_webinar_recording', true );
$registration = get_post_meta( get_the_ID(), 'cncf_webinar_registration', true );
$time         = get_post_meta( get_the_ID(), 'cncf_webinar_time', true );

// get author category.
$author_category = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-author-category', true );

// get companies (presented by).
$company = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-company' );

$date = get_post_meta( get_the_ID(), 'cncf_webinar_date', true );

$date_and_time = Cncf_Utils::display_webinar_date_time( $date, $time );

?>
<article class="webinars-upcoming-box box-shadow">

	<div class="webinars-upcoming-text-wrapper">

		<!-- Category of Webinar  -->
		<span class="skew-box secondary">CNCF
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

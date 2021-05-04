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

$passed_data = wp_parse_args( $args, array( 'show_images' => '' ) );
$show_images = $passed_data['show_images'];

// get author category.
$author_category      = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );
$author_category_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );

// get companies (presented by).
$company = Lf_Utils::get_term_names( get_the_ID(), 'lf-company' );

// get webinar date and time.
$webinar_date              = get_post_meta( get_the_ID(), 'lf_webinar_date', true );
$webinar_start_time        = get_post_meta( get_the_ID(), 'lf_webinar_start_time', true );
$webinar_start_time_period = get_post_meta( get_the_ID(), 'lf_webinar_start_time_period', true );
$webinar_timezone          = get_post_meta( get_the_ID(), 'lf_webinar_timezone', true );
$webinar_reg_url           = get_post_meta( get_the_ID(), 'lf_webinar_registration_url', true );
$dat_webinar_start         = Lf_Utils::get_webinar_date_time( $webinar_date, $webinar_start_time, $webinar_start_time_period, $webinar_timezone, true );
$date_and_time             = $dat_webinar_start->format( 'l F j' );

if ( $webinar_reg_url ) {
	$link_url = $webinar_reg_url;
} else {
	$link_url = get_the_permalink();
}
?>
<article class="webinars-upcoming-box">

<?php
if ( $show_images ) :
	?>
	<div class="newsroom-image-wrapper">
		<a target='_blank' rel="noopener" class="box-link external is-primary-color" href="<?php echo esc_url( $link_url ); ?>"
			title="<?php echo esc_attr( get_the_title() ); ?>"></a>
		<?php
		if ( has_post_thumbnail() ) {
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-540', '540px', 'archive-image' );
		} else {
			echo '<img loading="lazy" src="' . esc_url( get_stylesheet_directory_uri() )
			. '/images/online-program-thumb.jpg" alt="' . esc_attr( lf_blocks_get_site() ) . '" class="archive-image"/>';
		}
		?>
	</div>
		<?php
	endif;
?>

	<div class="webinars-upcoming-text-wrapper">

	<?php
	if ( $author_category && false ) :
		$author_category_link = '/lf-author-category/' . $author_category_slug . '/';
		?>
		<!-- Category of Webinar  -->
		<a class="skew-box secondary margin-bottom-small" title="See more content from <?php echo esc_attr( $author_category ); ?>" href="<?php echo esc_url( $author_category_link ); ?>">CNCF
			<?php echo esc_html( $author_category ); ?> Online Program</a>
		<?php endif; ?>

		<!-- Date of webinar  -->
		<?php if ( $date_and_time ) : ?>
		<span class="skew-box"><?php echo esc_html( $date_and_time ); ?></span>
		<?php endif; ?>

		<!-- Title of webinar  -->
		<h5 class="webinar-title"><a class="external is-primary-color" target='_blank' rel="noopener" href="<?php echo esc_url( $link_url ); ?>"
				title="<?php esc_html( the_title() ); ?> on <?php echo esc_html( $date_and_time ); ?>"><?php esc_html( the_title() ); ?></a>
		</h5>

		<!-- Presented by... Company  -->
		<?php if ( $company ) : ?>
		<span class="presented-by <?php echo ( is_front_page() ) ? ' live-icon' : ''; ?>">Presented by
			<?php echo esc_html( $company ); ?></span>
		<?php endif; ?>
	</div>
</article>

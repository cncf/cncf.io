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
$dat_webinar_start         = Lf_Utils::get_webinar_date_time( $webinar_date, $webinar_start_time, $webinar_start_time_period, $webinar_timezone, true );
$date_and_time             = str_replace( ':00', '', $dat_webinar_start->format( 'l F j, g:iA T' ) );
?>
<article class="webinars-upcoming-box">

<?php
if ( $show_images ) :
	?>
	<div class="newsroom-image-wrapper">
		<a class="box-link" href="<?php the_permalink(); ?>"
			title="<?php echo esc_attr( get_the_title() ); ?>"></a>
		<?php
		if ( has_post_thumbnail() ) {
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-540', '540px', 'archive-image' );
		} elseif ( isset( $options['generic_thumb_id'] ) && $options['generic_thumb_id'] ) {
			Lf_Utils::display_responsive_images( $options['generic_thumb_id'], 'newsroom-540', '540px', 'archive-default-svg' );
		} else {
			echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
			. '/images/thumbnail-default.svg" alt="' . esc_attr( lf_blocks_get_site() ) . '" class="archive-default-svg"/>';
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
			<?php echo esc_html( $author_category ); ?> Webinar</a>
		<?php endif; ?>

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
		<span class="presented-by <?php echo ( is_front_page() ) ? ' live-icon' : ''; ?>">Presented by
			<?php echo esc_html( $company ); ?></span>
		<?php endif; ?>
	</div>
</article>

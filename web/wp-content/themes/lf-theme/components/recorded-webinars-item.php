<?php
/**
 * Recorded Webinar Item
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// setup options.
$options = get_option( 'lf-mu' );

// get webinar date.
$webinar_date = new DateTime( get_post_meta( get_the_ID(), 'lf_webinar_date', true ) );

// get recording URL (for video thumb).
$recording_url = get_post_meta( get_the_ID(), 'lf_webinar_recording_url', true );

// extract YouTube video ID.
$video_id = Lf_Utils::get_youtube_id_from_url( $recording_url );

// get author category.
$author_category = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );
$author_category_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );

// get companies (presented by).
$company = Lf_Utils::get_term_names( get_the_ID(), 'lf-company' );
?>

<div class="webinar-recorded-box">

	<figure>
		<a href="<?php the_permalink(); ?>">
			<?php if ( $video_id ) { ?>

			<img src="https://img.youtube.com/vi/<?php echo esc_html( $video_id ); ?>/hqdefault.jpg"
				alt="<?php the_title(); ?>">
			<svg class="video-overlay" width="50" height="50">
				<use href="#play" /></svg>
				<?php
			} elseif ( isset( $options['generic_thumb_id'] ) && $options['generic_thumb_id'] ) {
				echo wp_get_attachment_image( $options['generic_thumb_id'], 'full', false, array( 'class' => 'webinar-default' ) );
			} else {
				echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
				. '/images/thumbnail-default.svg" alt="CNCF" class="webinar-default"/>';
			}
			?>
		</a>
	</figure>

		<?php
		if ( $author_category ) :
			$author_category_link = '/lf-author-category/' . $author_category_slug . '/';
			?>
	<a class="skew-box secondary" title="See more content from <?php echo esc_attr( $author_category ); ?>" href="<?php echo esc_url( $author_category_link ); ?>">CNCF
			<?php echo esc_html( $author_category ); ?> Online Program</a>
		<?php endif; ?>

	<h5 class="webinar-title"><a
			href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

		<?php
		if ( $company ) :
			?>
	<div class="presented-by">Presented by:
			<?php echo esc_html( $company ); ?></div>
			<?php
			endif;
		?>

		<?php
		if ( $webinar_date ) :
			?>
	<div class="recorded live-icon">Recorded:
			<?php echo esc_html( $webinar_date->format( 'F j, Y' ) ); ?></div>
			<?php
			endif;
		?>

</div>

<?php
/**
 * Search & Filter Pro
 *
 * Webinars
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) : ?>

	<?php

	// work out if dealing with recorded or upcoming.
	if ( '>=' !== $query->query['meta_query'][0]['compare'] ) {
		// recorded webinars.
		$is_recorded = true;
	} else {
		$is_recorded = false;
	}
	?>

<p class="results-count">
		<?php
		if ( $is_recorded ) {
			// get total list of webinars.
			$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'cncf_webinar' and wp_posts.post_status = 'publish' and meta_key='cncf_webinar_recording_url' and meta_value <> '';" );

			// if filter matches all webinars.
			if ( $full_count == $query->found_posts ) {
				echo 'Found ' . esc_html( $query->found_posts ) . ' recorded webinars.';
			} else {
				// else show partial count.
				echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' recorded webinars.';
			}
		} else {
			// get total list of webinars.
			$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'cncf_webinar' and wp_posts.post_status = 'publish' and meta_key='cncf_webinar_date' and meta_value >= CURDATE();" );

			// if filter matches all webinars.
			if ( $full_count == $query->found_posts ) {
				echo 'Found ' . esc_html( $query->found_posts ) . ' upcoming webinars.';
			} else {
				// else show partial count.
				echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' upcoming webinars.';
			}
		}
		?>
</p>

	<?php if ( $is_recorded ) : ?>
<!-- Setup the Play SVG to use it in the loop  -->
<svg style="display:none">
	<symbol id="play" viewBox="-1 -1 90 90">
		<path fill="#DE176C"
			d="M41.5 83C64.42 83 83 64.42 83 41.5S64.42 0 41.5 0 0 18.58 0 41.5 18.58 83 41.5 83z" />
		<path d="M62 41.5L29 58V25z" fill="#FFF" />
	</symbol>
</svg>
	<?php endif; ?>

<div class="webinars-wrapper">

	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

		// setup options.
		$options = get_option( 'cncf-mu' );

		// get webinar date.
		$webinar_date = new DateTime( get_post_meta( get_the_ID(), 'cncf_webinar_date', true ) );

		// get recording URL (for video thumb).
		$recording_url = get_post_meta( get_the_ID(), 'cncf_webinar_recording_url', true );

		// extract YouTube video ID.
		$video_id = Cncf_Utils::get_youtube_id_from_url( $recording_url );

		// get author category.
		$author_category = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-author-category', true );

		// get companies (presented by).
		$company = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-company' );
		?>


		<?php if ( $is_recorded ) : ?>
	<div class="webinar-recorded-box box-shadow">

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

		<div class="skew-box secondary">CNCF
			<?php echo esc_html( $author_category ); ?> Webinar</div>

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
			<?php
		else :

			get_template_part( 'components/upcoming-webinars-item' );

endif;
endwhile;
	?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;

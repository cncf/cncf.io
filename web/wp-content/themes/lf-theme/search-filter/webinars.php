<?php
/**
 * Search & Filter Pro
 *
 * Webinars
 *
 * @package WordPress
 * @subpackage lf-theme
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
		$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'lf_webinar' and wp_posts.post_status = 'publish' and meta_key='lf_webinar_recording_url' and meta_value <> '';" );

		// if filter matches all webinars.
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' recorded webinars';
		} else {
			// else show partial count.
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' recorded webinars';
		}
	} else {
		// get total list of webinars.
		$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'lf_webinar' and wp_posts.post_status = 'publish' and meta_key='lf_webinar_date' and meta_value >= DATE(DATE_SUB(NOW(), INTERVAL 7 HOUR));" );

		// if filter matches all webinars.
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' upcoming webinars';
		} else {
			// else show partial count.
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' upcoming webinars';
		}
	}
	?>
</p>

	<?php if ( $is_recorded ) : ?>
<!-- Setup the Play SVG to use it in the loop  -->
<svg style="display:none">
	<symbol id="play" viewBox="-1 -1 90 90">
		<path fill="#ff00aa"
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

			<?php
			if ( $author_category ) :
				$author_category_link = '/lf-author-category/' . $author_category_slug . '/';
				?>
		<a class="skew-box secondary" title="See more content from <?php echo esc_attr( $author_category ); ?>" href="<?php echo esc_url( $author_category_link ); ?>">CNCF
				<?php echo esc_html( $author_category ); ?> Webinar</a>
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
			<?php
		else :

			get_template_part( 'components/upcoming-webinars-item' );

endif;
endwhile;
	?>
</div>
	<?php
else :
	echo 'New webinars coming soon. <a href="#newsletter">Sign up for our newsletter to stay informed</a>.';
endif;

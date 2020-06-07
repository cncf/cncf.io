<?php
/**
 * Search loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<main class="search-results">
<div class="container wrap archive-container">
<?php
if ( have_posts() ) :

	if ( 'landscape' === get_search_query() ) :
		?>
<div class="archive-item" style="border: 1px solid black; padding: 2em;">
<div class="archive-text-wrapper">

<p class="archive-title"><a class="external is-primary-color" href="https://landscape.cncf.io" target="_blank"
title="CNCF Landscape">View the CNCF Landscape</a></p>
<div class="archive-excerpt">This landscape is intended as a map through the previously uncharted terrain of cloud native technologies. There are many routes to deploying a cloud native application, with CNCF Projects representing a particularly well-traveled path.</div>
</div>
</div>

		<?php
	endif;
	while ( have_posts() ) :
		the_post();

		// Get the Category Author.
		$category_author = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-author-category', true );

		?>
<div class="archive-item">

<div class="archive-text-wrapper">

<div class="skew-box centered margin-bottom">
		<?php
		if ( in_category( 'blog' ) ) {
			echo 'BLOG POST';
		} elseif ( in_category( 'news' ) ) {
			echo 'MEDIA COVERAGE';
		} elseif ( in_category( 'announcements' ) ) {
			echo 'ANNOUNCEMENT';
		} elseif ( 'cncf_webinar' == get_post_type() ) {
			echo 'WEBINAR';
		} elseif ( 'cncf_person' == get_post_type() ) {
			echo 'PEOPLE';
		} elseif ( 'cncf_case_study' == get_post_type() ) {
			echo 'CASE STUDY';
		} elseif ( 'cncf_case_studych' == get_post_type() ) {
			echo 'CASE STUDY';
		} elseif ( 'cncf_event' == get_post_type() ) {
			echo 'EVENT';
		} elseif ( 'cncf_speaker' == get_post_type() ) {
			echo 'SPEAKER';
		} elseif ( 'cncf_spotlight' == get_post_type() ) {
			echo 'SPOTLIGHT';
		} elseif ( 'page' == get_post_type() ) {
			echo 'PAGE';
		} else {
			echo 'NOT SURE?';
		}
		?>
</div>
		<?php if ( $category_author ) : ?>
<div class="skew-box secondary centered margin-bottom">CNCF
			<?php
			echo esc_html( $category_author );

			if ( in_category( 'blog' ) ) {
				echo ' BLOG POST';
			} elseif ( in_category( 'news' ) ) {
				echo ' MEDIA COVERAGE';
			} elseif ( in_category( 'announcement' ) ) {
				echo ' ANNOUNCEMENT';
			} elseif ( 'cncf_webinar' == get_post_type() ) {
				echo ' WEBINAR';
			} else {
				echo ' POST';
			}
			?>
</div>
<?php endif; ?>

		<?php
		if ( in_category( 'news' ) && ( get_post_meta( get_the_ID(), 'cncf_post_external_url', true ) ) ) {
			$link_url = get_post_meta( get_the_ID(), 'cncf_post_external_url', true );
			?>
<p class="archive-title"><a class="external is-primary-color" target="_blank" rel="noopener" href="<?php echo esc_url( $link_url ); ?>"
title="<?php the_title(); ?>">
			<?php the_title(); ?>
</a></p>
			<?php
		} else {
			?>
<p class="archive-title"><a href="<?php the_permalink(); ?>"
title="<?php the_title(); ?>">
			<?php the_title(); ?>
</a></p>
			<?php
		}
		?>

<p class="date-author-row">

		<?php
		if ( 'cncf_webinar' == get_post_type() ) {

			// Get date and time now.
			$dat_now = new DateTime( '', new DateTimeZone( 'America/Los_Angeles' ) );

			// Get date and time of webinar for comparison.
			$webinar_date        = get_post_meta( get_the_ID(), 'cncf_webinar_date', true );
			$webinar_time        = get_post_meta( get_the_ID(), 'cncf_webinar_time', true );
			$formatted_date_time = Cncf_Utils::display_webinar_date_time( $webinar_date, $webinar_time, true );
			$dat_webinar         = new DateTime( $formatted_date_time );

			// get recording URL.
			$recording_url = get_post_meta( get_the_ID(), 'cncf_webinar_recording_url', true );

			// date period.
			if ( $dat_webinar > $dat_now ) {
				?>

	<span class="live-icon">Upcoming Webinar on
					<?php echo esc_html( $dat_webinar->format( 'l F j, Y' ) ); ?>
</span>
				<?php
			} elseif ( ( $dat_webinar < $dat_now ) && ( $recording_url ) ) {
				?>

<span class="live-icon">Recorded on
				<?php echo esc_html( $dat_webinar->format( 'l F j, Y' ) ); ?>
</span>

				<?php
			} else {
				?>
	<span class="posted-date date-icon">
		Broadcast on
				<?php
				echo esc_html( $dat_webinar->format( 'l F j, Y' ) );
				?>
</span>
				<?php
			}
		} elseif ( 'cncf_event' == get_post_type() ) {

			$event_start_date = get_post_meta( get_the_ID(), 'cncf_event_date_start', true );
			?>
<span class="posted-date date-icon">
		Event date:
			<?php
				echo esc_html( Cncf_Utils::display_event_date( $event_start_date ) );
			?>
</span>

			<?php
		} else {
			?>
<span class="posted-date date-icon">
		Posted on
			<?php
			echo get_the_date();
			?>
</span>
			<?php
		}
		?>
		<?php
		// Post author.
		if ( in_category( 'blog' ) ) :
			echo wp_kses_post( Cncf_Utils::display_author( get_the_ID(), true ) );
	endif;
		?>
</p>

<div class="archive-excerpt"><?php the_excerpt(); ?></div>
</div>
</div>
		<?php
endwhile;
endif;
?>
</div>
</main>

<?php
/**
 * Search loop
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>
<main class="search-results">
	<div class="container wrap archive-container">
		<?php
		if ( have_posts() ) :

			if ( 'landscape' === get_search_query() ) :
				?>
		<div class="archive-item"
			style="border: 1px solid black; padding: 2em;">
			<div class="archive-text-wrapper">

				<p class="archive-title"><a class="external is-primary-color"
						href="https://landscape.cncf.io" target="_blank"
						title="CNCF Landscape">View the CNCF Landscape</a></p>
				<div class="archive-excerpt">This landscape is intended as a map
					through the previously uncharted terrain of cloud native
					technologies. There are many routes to deploying a cloud
					native application, with CNCF Projects representing a
					particularly well-traveled path.</div>
			</div>
		</div>

				<?php
		endif;
			while ( have_posts() ) :
				the_post();

				// Get the Category Author.
				$category_author = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );

				?>
		<div class="archive-item">

			<div class="archive-text-wrapper">

				<div class="skew-box centered margin-bottom">
					<?php
					if ( in_category( 'blog' ) ) {
						echo 'Blog Post';
					} elseif ( in_category( 'news' ) ) {
						echo 'Media Coverage';
					} elseif ( in_category( 'announcements' ) ) {
						echo 'Announcement';
					} elseif ( 'lf_webinar' == get_post_type() ) {
						echo 'Webinar';
					} elseif ( 'lf_person' == get_post_type() ) {
						echo 'People';
					} elseif ( 'lf_case_study' == get_post_type() ) {
						echo 'Case Study';
					} elseif ( 'lf_case_studych' == get_post_type() ) {
						echo 'Case Study';
					} elseif ( 'lf_event' == get_post_type() ) {
						echo 'Event';
					} elseif ( 'lf_speaker' == get_post_type() ) {
						echo 'Speaker';
					} elseif ( 'lf_spotlight' == get_post_type() ) {
						echo 'Spotlight';
					} elseif ( 'page' == get_post_type() ) {
						echo 'Page';
					} else {
						echo 'Page';
					}
					?>
				</div>


				<?php if ( $category_author ) : ?>
				<div class="skew-box secondary centered margin-bottom">CNCF
					<?php
					echo esc_html( $category_author );

					if ( in_category( 'blog' ) ) {
						echo ' Blog Post';
					} elseif ( in_category( 'news' ) ) {
						echo ' Media Coverage';
					} elseif ( in_category( 'announcement' ) ) {
						echo ' Announcement';
					} elseif ( 'lf_webinar' == get_post_type() ) {
						echo ' Webinar';
					} else {
						echo ' Post';
					}
					?>
				</div>
				<?php endif; ?>

				<?php
				if ( in_category( 'news' ) && ( get_post_meta( get_the_ID(), 'lf_post_external_url', true ) ) ) {
					$link_url = get_post_meta( get_the_ID(), 'lf_post_external_url', true );
					?>
				<p class="archive-title"><a class="external is-primary-color"
						target="_blank" rel="noopener"
						href="<?php echo esc_url( $link_url ); ?>"
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
					if ( 'lf_webinar' == get_post_type() ) {

						// Get date and time now.
						$dat_now = new DateTime( '', new DateTimeZone( 'America/Los_Angeles' ) );

						// Get date and time of webinar for comparison.
						$webinar_date              = get_post_meta( get_the_ID(), 'lf_webinar_date', true );
						$webinar_start_time        = get_post_meta( get_the_ID(), 'lf_webinar_start_time', true );
						$webinar_start_time_period = get_post_meta( get_the_ID(), 'lf_webinar_start_time_period', true );
						$webinar_timezone          = get_post_meta( get_the_ID(), 'lf_webinar_timezone', true );
						$dat_webinar_start         = Lf_Utils::get_webinar_date_time( $webinar_date, $webinar_start_time, $webinar_start_time_period, $webinar_timezone );
						$date_and_time             = str_replace( ':00', '', $dat_webinar_start->format( 'l F j, Y, g:iA T' ) );

						// get recording URL.
						$recording_url = get_post_meta( get_the_ID(), 'lf_webinar_recording_url', true );

						// date period.
						if ( $dat_webinar_start > $dat_now ) {
							?>

					<span class="date-icon">Upcoming Webinar on
							<?php echo esc_html( $dat_webinar_start->format( 'l F j, Y' ) ); ?>
					</span>
							<?php
						} elseif ( ( $dat_webinar_start < $dat_now ) && ( $recording_url ) ) {
							?>

					<span class="live-icon">Recorded on
							<?php echo esc_html( $dat_webinar_start->format( 'l F j, Y' ) ); ?>
					</span>

							<?php
						} else {
							?>
					<span class="posted-date date-icon">
						Broadcast on
							<?php
							echo esc_html( $dat_webinar_start->format( 'l F j, Y' ) );
							?>
					</span>
							<?php
						}
					} elseif ( 'lf_event' == get_post_type() ) {

						$event_start_date = get_post_meta( get_the_ID(), 'lf_event_date_start', true );
						?>
					<span class="posted-date date-icon">
						Event date:
						<?php
								echo esc_html( Lf_Utils::display_event_date( $event_start_date ) );
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
						echo wp_kses_post( Lf_Utils::display_author( get_the_ID(), true ) );
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

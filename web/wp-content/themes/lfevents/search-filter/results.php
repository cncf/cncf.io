<?php
/**
 * Search & Filter Pro Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 *
 * Note: these templates are not full page templates, rather
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think
 * of it as a template part
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags -
 *
 * http://codex.wordpress.org/Template_Tags
 */

global $post, $wpdb;

echo '<div class="grid-x grid-margin-x">';

if ( $query->have_posts() ) {
	if ( 138 == $query->query['search_filter_id'] || 42 == $query->query['search_filter_id'] ) {
		$is_upcoming_events = true;
		$full_count = $wpdb->get_var( "SELECT count(*) FROM wp_posts INNER JOIN wp_postmeta as pm1 ON ( wp_posts.ID = pm1.post_id ) INNER JOIN wp_postmeta pm2 ON ( wp_posts.ID = pm2.post_id ) WHERE ( pm1.meta_key = 'lfes_event_has_passed' ) AND (pm1.meta_value != 1) AND ( pm2.meta_key = 'lfes_hide_from_listings' ) AND (pm2.meta_value != 'hide') AND wp_posts.post_type = 'page' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'pending') AND wp_posts.post_parent = 0" );
	} else {
		$is_upcoming_events = false;
		$post_types = lfe_get_post_types();
		$full_count = $wpdb->get_var( "SELECT count(*) FROM wp_posts INNER JOIN wp_postmeta as pm1 ON ( wp_posts.ID = pm1.post_id ) INNER JOIN wp_postmeta pm2 ON ( wp_posts.ID = pm2.post_id ) WHERE ( pm1.meta_key = 'lfes_event_has_passed' ) AND (pm1.meta_value = 1) AND ( pm2.meta_key = 'lfes_hide_from_listings' ) AND (pm2.meta_value != 'hide') AND wp_posts.post_type IN ('" . implode( "', '", $post_types ) . "') AND (wp_posts.post_status = 'publish') AND wp_posts.post_parent = 0" ); //phpcs:ignore
	}

	$y = 0;
	$month = 0;

	if ( $full_count > 1 ) {
		if ( $full_count == $query->found_posts ) {
			echo '<p class="cell results-count">Displaying ' . esc_html( $query->found_posts ) . ' events</p>';
		} else {
			echo '<p class="cell results-count">Displaying ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' events</p>';
		}
	}

	while ( $query->have_posts() ) {
		$query->the_post();
		$dt_date_start = new DateTime( get_post_meta( $post->ID, 'lfes_date_start', true ) );
		$dt_date_end = new DateTime( get_post_meta( $post->ID, 'lfes_date_end', true ) );
		$cfp_date_start = get_post_meta( $post->ID, 'lfes_cfp_date_start', true );
		$cfp_date_end = get_post_meta( $post->ID, 'lfes_cfp_date_end', true );
		$dt_cfp_date_start = new DateTime( $cfp_date_start );
		$dt_cfp_date_end = new DateTime( $cfp_date_end );
		$cfp_active = get_post_meta( $post->ID, 'lfes_cfp_active', true );
		$event_has_passed = get_post_meta( $post->ID, 'lfes_event_has_passed', true );

		if ( ! $event_has_passed ) {
			// check to see if event has passed.
			$dt_date_end_1d_after = new DateTime( get_post_meta( $post->ID, 'lfes_date_end', true ) );
			$dt_date_end_1d_after->add( new DateInterval( 'P1D' ) );
			$dt_now = new DateTime( 'now' );
			if ( $dt_date_end_1d_after < $dt_now ) {
				// event has passed and we should set lfes_event_has_passed.
				update_post_meta( $post->ID, 'lfes_event_has_passed', true );
			} else {
				update_post_meta( $post->ID, 'lfes_event_has_passed', false );
			}
		}

		if ( $is_upcoming_events ) {
			if ( ( 0 == $y ) || ( $y < (int) $dt_date_start->format( 'Y' ) ) ) {
				$y = (int) $dt_date_start->format( 'Y' );
				echo '<h2 class="cell event-calendar-year">' . esc_html( $y ) . '</h2>';
				$month = (int) $dt_date_start->format( 'm' );
				echo '<h3 class="cell event-calendar-month">' . esc_html( $dt_date_start->format( 'F' ) ) . '</h3>';
			} elseif ( ( 0 == $month ) || ( $month < (int) $dt_date_start->format( 'm' ) ) ) {
				$month = (int) $dt_date_start->format( 'm' );
				echo '<h3 class="cell event-calendar-month">' . esc_html( $dt_date_start->format( 'F' ) ) . '</h3>';
			}
		} else {
			if ( ( 0 == $y ) || ( $y > (int) $dt_date_start->format( 'Y' ) ) ) {
				$y = (int) $dt_date_start->format( 'Y' );
				echo '<h2 class="cell event-calendar-year">' . esc_html( $y ) . '</h2>';
				$month = (int) $dt_date_start->format( 'm' );
				echo '<h3 class="cell event-calendar-month">' . esc_html( $dt_date_start->format( 'F' ) ) . '</h3>';
			} elseif ( ( 0 == $month ) || ( $month > (int) $dt_date_start->format( 'm' ) ) ) {
				$month = (int) $dt_date_start->format( 'm' );
				echo '<h3 class="cell event-calendar-month">' . esc_html( $dt_date_start->format( 'F' ) ) . '</h3>';
			}
		}
		?>
		<article id="post-<?php the_ID(); ?>" class="cell medium-6 large-4 callout large-margin-bottom">

			<h5 class="medium-margin-right small-margin-bottom line-height-tight">
				<strong>
					<?php
					if ( 'publish' == $post->post_status ) {
						echo '<a href="' . lfe_get_event_url( $post->ID ) . '">' . get_the_title() . '</a>'; //phpcs:ignore
					} else {
						the_title();
					}
					?>
				</strong>
			</h5>

			<p class="event-meta text-small small-margin-bottom">

				<span class="date small-margin-right display-inline-block">
					<?php get_template_part( 'template-parts/svg/calendar' ); ?>
					<?php echo esc_html( jb_verbose_date_range( $dt_date_start, $dt_date_end ) ); ?>
				</span>

				<span class="country display-inline-block">
					<?php get_template_part( 'template-parts/svg/map-marker' ); ?>
					<?php
					$country = wp_get_post_terms( $post->ID, 'lfevent-country' );
					if ( $country ) {
						$country = $country[0]->name;
						$city = get_post_meta( $post->ID, 'lfes_city', true );
						if ( $city ) {
							$city .= ', ';
						}
						echo esc_html( $city ) . esc_html( $country );
					}
					?>
				</span>
			</p>

			<?php
			if ( $is_upcoming_events ) {
				?>
				<p class="event-meta text-small no-margin">
					<span class="cfp">
						<?php get_template_part( 'template-parts/svg/bullhorn' ); ?>

						CFP Status:
						<span class="text-weight-normal">
							<?php
							if ( '0' === $cfp_active ) {
								echo 'No Call for Proposals';
							} elseif ( ! ( $cfp_date_start ) ) {
								echo 'Details Coming Soon';
							} elseif ( strtotime( $cfp_date_end ) < time() ) {
								echo 'Closed';
							} elseif ( strtotime( $cfp_date_end ) > time() && strtotime( $cfp_date_start ) < time() ) {
								echo 'Closes ' . esc_html( $dt_cfp_date_end->format( 'l, M j, Y' ) );
							} elseif ( strtotime( $cfp_date_end ) > time() && strtotime( $cfp_date_start ) > time() ) {
								echo 'Opens ' . esc_html( $dt_cfp_date_start->format( 'l, M j, Y' ) );
							}
							?>
						</span>
					</span>
				</p>
				<?php
			}
			?>

		</article>
		<?php
	}
} else {
	echo '<div class="cell medium-6 large-4 callout large-margin-bottom">No Results Found</div>';
}
echo '</div>';
?>

<script>
// this controls the appearence and behavior of the link to navigate between upcoming and past events.
$( document ).ready( function() {

	<?php
	if ( is_lfeventsci() ) {
		echo 'var viewPastEventsText = \'View Past Events\';';
		echo 'var viewUpcomingEventsText = \'View Upcoming Events\';';
	} else {
		echo 'var viewPastEventsText = \'查看往期活动 View Past Events\';';
		echo 'var viewUpcomingEventsText = \'查看即将举办的活动 View Upcoming Events\';';
	}
	?>

	if ( $( '.switch-archive-view' ).length === 0 ) {
		$( '#event-calendar-header' ).append( '<a class="button switch-archive-view top" href="#"></a>' );
		$( '.search-filter-results' ).append( '<hr><div class="clearfix"><a class="button switch-archive-view bottom" href="#"></a></div>' );
	}
	var currentUrl = $( location ).attr( 'href' )
	if ( -1 == currentUrl.indexOf( 'calendar/archive' ) ) {
		//we are on the event-calendar page.
		newUrl = currentUrl.replace( 'calendar', 'calendar/archive' );
		$( '.switch-archive-view' ).attr( "href", newUrl.split("?")[0] );
		$( '.switch-archive-view' ).html( viewPastEventsText );
	} else {
		//we are on the event-calendar/archive page.
		newUrl = currentUrl.replace( 'calendar/archive', 'calendar' );
		$( '.switch-archive-view' ).attr( "href", newUrl.split("?")[0] );
		$( '.switch-archive-view' ).html( viewUpcomingEventsText );
	}
});
</script>

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

global $post;

echo '<div class="grid-x grid-margin-x">';

if ( $query->have_posts() ) {
	$y     = 0;
	$month = 0;
	while ( $query->have_posts() ) {
		$query->the_post();
		$dt_date_start = new DateTime( get_post_meta( $post->ID, 'lfes_community_date_start', true ) );
		$dt_date_end   = new DateTime( get_post_meta( $post->ID, 'lfes_community_date_end', true ) );

		$dt_date_end_1d_after = new DateTime( get_post_meta( $post->ID, 'lfes_community_date_end', true ) );
		$dt_date_end_1d_after->add( new DateInterval( 'P1D' ) );
		$dt_now = new DateTime( 'now' );
		if ( $dt_date_end_1d_after < $dt_now ) {
			// event has passed and we should set it to draft.
			wp_update_post(
				array(
					'ID'          => $post->ID,
					'post_status' => 'draft',
				)
			);
			continue;
		}

		if ( ( 0 == $y ) || ( $y < (int) $dt_date_start->format( 'Y' ) ) ) {
			$y = (int) $dt_date_start->format( 'Y' );
			echo '<h2 class="cell event-calendar-year">' . esc_html( $y ) . '</h2>';
			$month = (int) $dt_date_start->format( 'm' );
			echo '<h3 class="cell event-calendar-month">' . esc_html( $dt_date_start->format( 'F' ) ) . '</h3>';
		} elseif ( ( 0 == $month ) || ( $month < (int) $dt_date_start->format( 'm' ) ) ) {
			$month = (int) $dt_date_start->format( 'm' );
			echo '<h3 class="cell event-calendar-month">' . esc_html( $dt_date_start->format( 'F' ) ) . '</h3>';
		}
		?>
		<article id="post-<?php the_ID(); ?>" class="cell medium-6 callout">
			<h4 class="h5 medium-margin-right small-margin-bottom line-height-tight"><strong>
			<?php
			echo '<a target="_blank" href="' . esc_html( get_post_meta( $post->ID, 'lfes_community_external_url', true ) ) . '">';
			echo esc_html( get_the_title() );
			echo '&nbsp;';
			echo esc_html( get_template_part( 'template-parts/svg/external-link' ) );
			echo '</a>';
			?>
			</strong></h4>
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
						$city    = get_post_meta( $post->ID, 'lfes_community_city', true );
						if ( $city ) {
							$city .= ', ';
						}
						echo esc_html( $city ) . esc_html( $country );
					}
					?>
				</span>

			</p>
		</article>
		<?php
	}
} else {
	echo '<div class="cell medium-6 large-4 callout large-margin-bottom">No Results Found</div>';
}
echo '</div>';
?>

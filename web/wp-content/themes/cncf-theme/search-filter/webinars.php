<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
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

if ( $query->have_posts() ) {
	?>

	Found <?php echo esc_html( $query->found_posts ); ?> Webinars<br />
	<?php
	while ( $query->have_posts() ) {
		$query->the_post();
		$webinar_date = new DateTime( get_post_meta( $post->ID, 'cncf_webinar_date', true ) );
		$speakers = get_post_meta( $post->ID, 'cncf_webinar_speakers', true );
		$author_category = get_the_terms( $post->ID, 'cncf-author-category' );
		$author_category = join( ', ', wp_list_pluck( $author_category, 'name' ) );

		$recording_url = get_post_meta( $post->ID, 'cncf_webinar_recording_url', true );
		if ( false !== stripos( $recording_url, 'https://www.youtube.com/watch?v=' ) ) {
			$video_id = substr( $recording_url, 32, 11 );
		} elseif ( false !== stripos( $recording_url, 'https://youtu.be/' ) ) {
			$video_id = substr( $recording_url, 17, 11 );
		}

		?>
		<div class="result-item">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div><?php echo esc_html( $webinar_date->format( 'F j, Y' ) ); ?></div>
			<div><?php echo esc_html( $speakers ) . ' <span>' . esc_html( $author_category ) . '</span>'; ?></div>
			<p><br /><?php the_excerpt(); ?></p>
			<figure>
				<img src="https://img.youtube.com/vi/<?php echo esc_html( $video_id ); ?>/hqdefault.jpg" alt="">
				<a href="<?php the_permalink(); ?>" class="button-like">Watch Now</a>
			</figure>
		</div>
		<hr />
		<?php
	}
} else {
	echo 'No Results Found';
}

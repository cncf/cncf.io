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

$image = new Image();

if ( $query->have_posts() ) {

	// get total list of webinars.
	$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'cncf_webinar' and wp_posts.post_status = 'publish' and meta_key='cncf_webinar_recording_url' and meta_value <> '';" );

	// if filter matches all webinars.
	if ( $full_count == $query->found_posts ) {
		echo '<p class="results-count">Found ' . esc_html( $query->found_posts ) . ' recorded webinars.</p>';
	} else {
		// else show partial count.
		echo '<p class="results-count">Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' recorded webinars.</p>';
	}

	?>

<div class="webinars-wrapper">

	<?php

	while ( $query->have_posts() ) :

		$query->the_post();

		// get webinar date.
		$webinar_date = new DateTime( get_post_meta( $post->ID, 'cncf_webinar_date', true ) );

		// get webinar speakers.
		$speakers = get_post_meta( $post->ID, 'cncf_webinar_speakers', true );

		// get recording URL.
		$recording_url = get_post_meta( $post->ID, 'cncf_webinar_recording_url', true );

		// extract YouTube video ID.
		if ( false !== stripos( $recording_url, 'https://www.youtube.com/watch?v=' ) ) {
			$video_id = substr( $recording_url, 32, 11 );
		} elseif ( false !== stripos( $recording_url, 'https://youtu.be/' ) ) {
			$video_id = substr( $recording_url, 17, 11 );
		}

		// get author category.
		$author_category = get_the_terms( $post->ID, 'cncf-author-category' );

		// get project.
		$project = get_the_terms( $post->ID, 'cncf-project' );
		$project = join( ', ', wp_list_pluck( $project, 'name' ) );

		// get company.
		$company = get_the_terms( $post->ID, 'cncf-company' );
		$company = join( ', ', wp_list_pluck( $company, 'name' ) );

		// get topic.
		$topic = get_the_terms( $post->ID, 'cncf-topic' );
		$topic = join( ', ', wp_list_pluck( $topic, 'name' ) );
		?>


	<div class="webinar-recorded-item">

		<figure>
			<a href="<?php the_permalink(); ?>">
				<img src="https://img.youtube.com/vi/<?php echo esc_html( $video_id ); ?>/hqdefault.jpg"
					alt="<?php the_title(); ?>">
				<img src="<?php $image->get_svg( 'play-button.svg', true ); ?>" alt="" class="video-overlay">
			</a>
		</figure>

		<?php
		if ( ! empty( $author_category ) && ! is_wp_error( $author_category ) ) {
			$category = $author_category[0]->name;
		} else {
			$category = '';
		}
		?>
		<div>CNCF <?php echo esc_html( $category ); ?> Webinar</div>

		<h3 class="webinar-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php
		if ( ! empty( $company ) ) :
			?>
		<div>Presented by: <?php echo esc_html( $company ); ?></div>
			<?php
endif;
		?>
		<div>Recorded on:
			<?php echo esc_html( $webinar_date->format( 'l j F Y' ) ); ?></div>


		<?php
		/*
		// UNUSUED on THIS PAGE.
		// echo 'Recording_url: ' . $recording_url . '<br>';
		// echo 'project: ' . $project . '<br>';
		// echo 'topic: ' . $topic . '<br>';
		// echo  esc_html( $speakers );
		// the_excerpt();
		*/
		?>


	</div>
		<?php
		endwhile;
	?>
</div>
	<?php
} else {
	echo 'No Results Found';
}

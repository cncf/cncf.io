<?php
/**
 * Webinar content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

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
<section class="hero">
	<div class="container wrap">
		<?php
		// Category of the post.
		$all_categories = get_the_category();
		if ( $all_categories ) :
			?>
		<p class="newsroom-single-category">
			<?php
			// Only get the first item in the array.
			$category = array_shift( $all_categories );
			// $category = $the_category->name;
			echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="See Posts in ' . esc_html( $category->name ) . '">' . esc_html( $category->name ) . '</a>';
			?>
		</p>
			<?php
endif;
		?>
		<h1 class="newsroom-single-title" itemprop="headline">
			<?php the_title(); ?></h1>
	</div>
</section>
<main class="newsroom-single">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<?php
			// Get the Category Author terms associated if any.
			$category_author_terms = get_the_terms( $post->ID, 'cncf-author-category' );
			if ( $category_author_terms ) {
				// Only get the first item in the array.
				$category_author_term = array_shift( $category_author_terms );
				$category_author      = $category_author_term->name;
			}
			if ( ! empty( $category_author ) ) :
				?>
		<p class="newsroom-single-author-category ">CNCF
				<?php echo esc_html( $category_author ); ?> Webinar</p>
				<?php
		endif;
			?>
		<p class="newsroom-single-meta">Posted on <?php // the_date(); // phpcsignore. ?></p>

		<div class="entry-content">

		<iframe src="https://www.youtube.com/embed/<?php echo esc_html( $video_id ); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>


			<?php


			echo 'project: ' . esc_html( $project ) . '<br>';
			echo 'topic: ' . esc_html( $topic ) . '<br>';
			echo esc_html( $speakers );

			the_content();
			get_template_part( 'components/social-share' );
			?>
			<hr class="newsroom-single-hr">
			<?php
			get_template_part( 'components/post-pagination' );
			?>
		</div>
			<?php
endwhile;
		?>
	</article>
</main>

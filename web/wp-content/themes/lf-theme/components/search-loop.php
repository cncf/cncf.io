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

	<?php
	if ( have_posts() ) :
		?>

	<div class="container wrap archive-container">

		<?php
		if ( 'landscape' === get_search_query() ) :
			?>
		<div class="archive-item highlighted">
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
			$category_author_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );

			if ( in_category( 'blog' ) ) {
				$content_type_singular = 'Blog Post';
				$content_type_plural = 'Blog Posts';
				$content_type_url = '/blog/';
			} elseif ( in_category( 'news' ) ) {
				$content_type_singular = 'Media Coverage';
				$content_type_plural = 'Media Coverage';
				$content_type_url = '/news/';
			} elseif ( in_category( 'announcements' ) ) {
				$content_type_singular = 'Announcement';
				$content_type_plural = 'Announcements';
				$content_type_url = '/announcements/';
			} elseif ( 'lf_webinar' == get_post_type() ) {
				$content_type_singular = 'Webinar';
				$content_type_plural = 'Webinars';
				$content_type_url = '/webinars/';
			} elseif ( 'lf_person' == get_post_type() ) {
				$content_type_singular = 'People';
				$content_type_plural = 'People';
				$content_type_url = '/people/staff/';
			} elseif ( 'lf_case_study' == get_post_type() ) {
				$content_type_singular = 'Case Study';
				$content_type_plural = 'Case Studies';
				$content_type_url = '/case-studies/';
			} elseif ( 'lf_case_study_cn' == get_post_type() ) {
				$content_type_singular = 'Case Study';
				$content_type_plural = 'Case Studies';
				$content_type_url = '/case-studies-cn/';
			} elseif ( 'lf_event' == get_post_type() ) {
				$content_type_singular = 'Event';
				$content_type_plural = 'Events';
				$content_type_url = '/events/';
			} elseif ( 'lf_speaker' == get_post_type() ) {
				$content_type_singular = 'Speaker';
				$content_type_plural = 'Speakers';
				$content_type_url = '/speakers/';
			} elseif ( 'lf_spotlight' == get_post_type() ) {
				$content_type_singular = 'Spotlight';
				$content_type_plural = 'Spotlights';
				$content_type_url = '/spotlights/';
			} elseif ( 'page' == get_post_type() ) {
				$content_type_singular = 'Page';
				$content_type_plural = 'Pages';
				$content_type_url = '/';
			} else {
				$content_type_singular = 'Page';
				$content_type_plural = 'Pages';
				$content_type_url = '/';
			}

			?>
		<div class="archive-item">

			<div class="archive-text-wrapper">

				<a class="skew-box centered margin-bottom" title="See all <?php echo esc_attr( $content_type_plural ); ?>" href="<?php echo esc_attr( $content_type_url ); ?>">
					<?php echo esc_html( $content_type_singular ); ?>
				</a>


				<?php
				if ( $category_author ) :
					$category_link = '/lf-author-category/' . $category_author_slug . '/';
					?>
				<a class="skew-box secondary centered margin-bottom" title="See more content from <?php echo esc_attr( $category_author ); ?>" href="<?php echo esc_url( $category_link ); ?>">CNCF
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
				</a>
				<?php endif; ?>

					<?php
					if ( in_category( 'news' ) && ( get_post_meta( get_the_ID(), 'lf_post_external_url', true ) ) ) {
						$link_url = get_post_meta( get_the_ID(), 'lf_post_external_url', true );
						?>
				<p class="archive-title"><a class="external is-primary-color"
						target="_blank" rel="noopener"
						href="<?php echo esc_url( $link_url ); ?>"
						title="<?php the_title(); ?>">
						<?php the_title(); ?></a></p>
						<?php
					} else {
						?>
				<p class="archive-title"><a href="<?php the_permalink(); ?>"
						title="<?php the_title(); ?>">
						<?php the_title(); ?></a></p>
						<?php
					}
					?>

				<p class="date-author-row">

					<?php
					if ( 'lf_webinar' == get_post_type() ) {
						Lf_Utils::get_webinar_author_row();
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
					if ( in_category( 'blog' ) ) {
						echo wp_kses_post( Lf_Utils::display_author( get_the_ID(), true ) );
					}
					?>
				</p>

				<div class="archive-excerpt"><?php the_excerpt(); ?></div>
			</div>
		</div>
			<?php
	endwhile;
		?>
	</div>
		<?php
else :
	?>
	<div class="container wrap">
		<p class="h4">We're sorry, but there are no search results for
			<strong><?php echo get_search_query(); ?></strong>. Try searching
			again:</p>

		<form role="search" method="get" class="no-search-results"
			action="<?php echo esc_url( home_url() ); ?>">
			<label><span class="search-text screen-reader-text">Search the
					site</span>
				<input type="search" class="search-field margin-y"
					placeholder="Enter search term"
					value="<?php echo get_search_query(); ?>" name="s"
					title="Search for" autocomplete="off" autocorrect="off"
					autocapitalize="off" spellcheck="false" />
			</label>

			<input type="submit" class="button" value="Search" />
		</form>
	</div>
	<?php
endif;
?>

</main>

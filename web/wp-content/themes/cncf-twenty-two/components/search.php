<?php
/**
 * Search loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/title' );

?>
<main class="search">

	<?php
	if ( have_posts() ) :
		?>

	<div class="container wrap columns-one">

		<?php
		if ( 'landscape' === get_search_query() && ! is_paged() ) :
			?>
		<div class="search__item search__highlighted">
				<p class="search__item-title"><a
						href="https://landscape.cncf.io"
						title="CNCF Landscape">View the CNCF Landscape</a></p>
				<p class="search__item-excerpt">This landscape is intended as a map
					through the previously uncharted terrain of cloud native
					technologies. There are many routes to deploying a cloud
					native application, with CNCF Projects representing a
					particularly well-traveled path.</p>

		</div>

			<?php
		endif;
		if ( 'kubecon' === get_search_query() && ! is_paged() ) :
			?>
		<div class="search__item search__highlighted">
				<p class="search__item-title"><a
						href="https://kubecon.io/"
						title="Kubecon">The next Kubecon</a></p>
				<p class="search__item-excerpt">The Cloud Native Computing Foundation’s flagship conference gathers adopters and technologists from leading open source and cloud native communities.</p>
		</div>

			<?php
		endif;


		while ( have_posts() ) :
			the_post();

			if ( in_category( 'blog' ) ) {
				// Get the Category Author.
				$category_author      = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );
				$category_author_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );
				$content_type_singular = 'Blog Post';
				$content_type_plural   = 'Blog Posts';
				$content_type_url      = '/blog/';
			} elseif ( in_category( 'news' ) ) {
				$content_type_singular = 'Media Coverage';
				$content_type_plural   = 'Media Coverage';
				$content_type_url      = '/news/';
			} elseif ( in_category( 'announcements' ) ) {
				$content_type_singular = 'Announcement';
				$content_type_plural   = 'Announcements';
				$content_type_url      = '/announcements/';
			} elseif ( 'lf_webinar' == get_post_type() ) {
				$content_type_singular = 'Online Program';
				$content_type_plural   = 'Online Programs';
				$content_type_url      = '/online-programs/';
			} elseif ( 'lf_person' == get_post_type() ) {
				$content_type_singular = 'People';
				$content_type_plural   = 'People';
				$content_type_url      = '/people/staff/';
			} elseif ( 'lf_case_study' == get_post_type() ) {
				$content_type_singular = 'Case Study';
				$content_type_plural   = 'Case Studies';
				$content_type_url      = '/case-studies/';
			} elseif ( 'lf_case_study_cn' == get_post_type() ) {
				$content_type_singular = 'Case Study';
				$content_type_plural   = 'Case Studies';
				$content_type_url      = '/case-studies-cn/';
			} elseif ( 'lf_spotlight' == get_post_type() ) {
				$content_type_singular = 'Spotlight';
				$content_type_plural   = 'Spotlights';
				$content_type_url      = '/spotlights/';
			} elseif ( 'page' == get_post_type() ) {
				$content_type_singular = 'Page';
				$content_type_plural   = 'Pages';
				$content_type_url      = '/';
			} elseif ( 'lf_project' == get_post_type() ) {
				$content_type_singular = 'Project';
				$content_type_plural   = 'Projects';
				$content_type_url      = '/projects/';
			} elseif ( 'lf_report' == get_post_type() ) {
				$content_type_singular = 'Report';
				$content_type_plural   = 'Reports';
				$content_type_url      = '/reports/';
			} else {
				$content_type_singular = 'Page';
				$content_type_plural   = 'Pages';
				$content_type_url      = '/';
			}

			?>

<hr class="wp-block-separator is-style-shadow-line is-style-section-padding">

		<div class="search__item">

		<div class="search__category">

			<a class="author-category has-larger-style" title="See all <?php echo esc_attr( $content_type_plural ); ?>" href="<?php echo esc_attr( $content_type_url ); ?>">
					<?php echo esc_html( $content_type_singular ); ?>
				</a>

				<?php
				if ( isset( $category_author ) && $category_author ) :
					$category_link = '/lf-author-category/' . $category_author_slug . '/';
					?>
				<a class="author-category has-larger-style" title="See more content from <?php echo esc_attr( $category_author ); ?>" href="<?php echo esc_url( $category_link ); ?>">CNCF
					<?php
					echo esc_html( $category_author );

					if ( in_category( 'blog' ) ) {
						echo ' Blog Post';
					} elseif ( in_category( 'news' ) ) {
						echo ' Media Coverage';
					} elseif ( in_category( 'announcement' ) ) {
						echo ' Announcement';
					} else {
						echo ' Post';
					}
					?>
				</a>
				<?php endif; ?>
			</div>
					<?php
					if ( in_category( 'news' ) && ( get_post_meta( get_the_ID(), 'lf_post_external_url', true ) ) ) {
						$link_url = get_post_meta( get_the_ID(), 'lf_post_external_url', true );
						?>
				<p class="search__item-title"><a
						href="<?php echo esc_url( $link_url ); ?>"
						title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?></a></p>
						<?php
					} else {
						?>
				<p class="search__item-title"><a href="<?php the_permalink(); ?>"
						title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?></a></p>
						<?php
					}
					?>

				<p class="search__item-meta">

					<?php
					if ( 'lf_project' == get_post_type() ) {
						$joined_date = get_post_meta( get_the_ID(), 'lf_project_date_accepted', true );
						if ( $joined_date ) {
							?>
						<span>
						Accepted to CNCF on
							<?php
							echo esc_html( Lf_Utils::display_event_date( $joined_date ) );
							?>
						</span>

							<?php
						}
					} else {
						?>
					<span>
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

				<div class="search__item-excerpt">
					<?php
					if ( 'lf_project' == get_post_type() ) {
						echo esc_html( get_post_meta( get_the_ID(), 'lf_project_description', true ) );
					} else {
						the_excerpt();
					}
					?>
				</div>
			</div>

			<?php
	endwhile;
		?>

		<?php
		get_template_part( 'components/pagination' );
		?>
	</div>
		<?php
else :
	?>
	<div class="container wrap">
		<h3>We're sorry, but there are no search results for
			<strong><?php echo get_search_query(); ?></strong>. Try searching
			again:</h3>

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

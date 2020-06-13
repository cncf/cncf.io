<?php
/**
 * Sitemap
 *
 * HTML-based sitemap to help users and SE navigate all site content.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>
<section class="sitemap">
	<div class="container wrap">
		<h3>Pages</h3>
		<ul><?php wp_list_pages( 'title_li=' ); ?></ul>

		<?php
		$args  = array(
			'post_type'    => array( 'services' ), // CPT here.
			'post_status'  => array( 'publish' ),
			'has_password' => false,
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			?>
		<h3>Services</h3>
		<ul>
			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
			<li>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</li>
			<?php } ?>
		</ul>
			<?php
		}
		wp_reset_postdata();
		?>

		<h3>Feeds</h3>
		<ul>
			<li><a title="Full content"
					href="feed:<?php bloginfo( 'rss2_url' ); ?>">Main RSS</a>
			</li>
			<li><a title="Comment Feed"
					href="feed:<?php bloginfo( 'comments_rss2_url' ); ?>">Comment
					Feed</a></li>
		</ul>

		<h3>Blog Posts</h3>

		<p>By category: </p>
		<?php
		$the_categories = get_categories( 'exclude=' );
		foreach ( $the_categories as $categories ) {
			$cat_slug  = array(
				'category_name' => $categories->slug,
				'exclude'       => '', // enter the ID or comma-separated list of page IDs to exclude.
				'numberposts'   => '-1', // number of posts to show, default value is 5.
			);
			$cat_array = get_posts( $cat_slug );
			echo '<h3>' . esc_html( $categories->cat_name ) . '</h3>';
			echo '<ul>';
			foreach ( $cat_array as $cat_post ) {
				echo '<li><a href="' . esc_url( get_permalink( $cat_post ) ) . '">' . esc_html( get_the_title( $cat_post ) ) . '</a></li>';
			}
			echo '</ul>';
		}
		?>

		<h3>Monthly Archives</h3>
		<ul>
			<?php wp_get_archives( 'type=monthly&show_post_count=true' ); ?>
		</ul>
	</div>
</section>

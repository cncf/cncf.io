<?php
/**
 * Hero
 *
 * Displays hero of a page or post - typically the title
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// setup options.
$options = get_option( 'lf-mu' );
?>

<section class="hero background-image-wrapper" id="maincontent">

	<figure class="background-image-figure">
		<?php
		if ( has_post_thumbnail() && ! is_archive() && ! is_singular( 'lf_project' ) ) {
			Lf_Utils::display_picture( get_post_thumbnail_id(), 'hero' );

		} elseif ( is_singular( 'lf_project' ) ) {
			Lf_Utils::display_picture( 64572, 'hero' );

		} elseif ( isset( $options['generic_hero_id'] ) && $options['generic_hero_id'] ) {
			Lf_Utils::display_picture( $options['generic_hero_id'], 'hero' );
		} else {
			echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
			. '/images/hero-default.jpg" alt="CNCF" height="280" width="100%"/>';
		}
		?>
	</figure>

	<div class="container wrap background-image-text-overlay">
		<div>
			<?php
			if ( function_exists( 'is_tag' ) && is_tag() || is_category() || is_tax() ) :
				if ( is_tax( 'lf-author-category' ) ) {
					?>
			<h1 class="blog-title">Author category: <?php single_cat_title(); ?>
			</h1>
					<?php
				} else {
					?>
			<h1 class="blog-title"><?php single_cat_title(); ?></h1>
					<?php
				}
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
				<?php elseif ( is_author() ) : ?>
			<h1 class="blog-title">All posts by <?php the_author(); ?></h1>
			<?php elseif ( is_archive() ) : ?>
			<h1 class="blog-title"><a href="<?php the_permalink(); ?>"
					rel="bookmark"
					title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h1>
				<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
			<?php elseif ( is_search() ) : ?>
			<h2 class="page-title"><span>Search results for: </span>
				<?php echo esc_attr( get_search_query() ); ?></h2>
				<?php
		elseif ( ! ( is_404() ) && ( is_page() ) ) :
			if ( 63395 === wp_get_post_parent_id( $post ) ) {
				?>
			<p class="hero-parent-link">
				<a href="/cloud-native-landscape-guide/" title="Go to the Cloud native landscape guide">Cloud native landscape guide</a>
				</p>
			<?php } elseif ( 38018 === wp_get_post_parent_id( $post ) ) { ?>
			<p class="hero-parent-link">
				<a href="/phippy/" title="Go to Phippy and friends">Phippy and friends</a>
				</p>
			<?php } ?>
			<h1 class="page-title" itemprop="headline"><?php the_title(); ?>
			</h1>
			<?php
			elseif ( is_singular( 'lf_project' ) ) :
				if ( get_the_ID() && ( Lf_Utils::get_term_names( get_the_ID(), 'lf-project-stage', true ) == 'Sandbox' ) ) {
					?>
			<p class="hero-parent-link">
			<a href="/sandbox-projects/" title="Go to Sandbox Projects">Projects</a>
			</p>
					<?php
				} else {
					?>
			<p class="hero-parent-link">
			<a href="/projects/" title="Go to Graduated and Incubating Projects">Projects</a>
			</p>
					<?php
				}
				?>
			<h1 class="post-title" itemprop="headline"><?php the_title(); ?>
			</h1>
			<?php elseif ( ! ( is_404() ) && ( is_single() ) ) : ?>
			<h1 class="post-title" itemprop="headline"><?php the_title(); ?>
			</h1>
			<?php elseif ( is_404() ) : ?>
			<h2 class="post-title" itemprop="headline">Sorry that page wasn't
				found</h2>
			<?php elseif ( is_home() ) : ?>
			<h2 class="blog-title"><?php single_post_title(); ?></h2>
			<?php else : ?>
			<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
			<?php endif; ?>
		</div>
	</div>
</section>

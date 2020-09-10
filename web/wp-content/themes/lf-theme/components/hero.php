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

<section class="hero background-image-wrapper">

	<figure class="background-image-figure">
	<?php
	if ( has_post_thumbnail() && ! is_archive() ) {
		Lf_Utils::display_picture( get_post_thumbnail_id(), 'hero' );

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
					<h1 class="blog-title">Content from a CNCF <?php single_cat_title(); ?></h1>
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
			<?php elseif ( ! ( is_404() ) && ( is_page() ) ) : ?>
				<h1 class="page-title" itemprop="headline"><?php the_title(); ?>
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
				<h1 class="page-title" itemprop="headline"><?php the_title(); ?>
				</h1>
			<?php endif; ?>
		</div>
	</div>
</section>

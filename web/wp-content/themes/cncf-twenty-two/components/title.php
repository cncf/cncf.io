<?php
/**
 * Title
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// setup options.
$site_options = get_option( 'lf-mu' );
?>

<header class="title-wrapper container wrap">

	<?php
	// TODO: Add Eyebrows as seperate include.
		// TODO: Sort this old code out.
	if ( function_exists( 'is_tag' ) && is_tag() || is_category() || is_tax() ) :
		if ( is_tax( 'lf-author-category' ) ) {
			?>
	<h1 class="blog-title">XAuthor category: <?php single_cat_title(); ?>
	</h1>
			<?php
		} else {
			?>
	<h1 class="blog-title">X<?php single_cat_title(); ?></h1>
			<?php
		}
		the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
	<?php elseif ( is_author() ) : ?>
	X<h1 class="blog-title">All posts by <?php the_author(); ?></h1>
	<?php elseif ( is_archive() ) : ?>
	X<h1 class="blog-title"><a href="<?php the_permalink(); ?>" rel="bookmark"
			title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</h1>
		<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
	<?php elseif ( is_search() ) : ?>
	X<h2 class="is-style-page-title"><span>Search results for: </span>
		<?php echo esc_attr( get_search_query() ); ?></h2>
		<?php
		elseif ( ! ( is_404() ) && ( is_page() ) ) :
			if ( 63395 === wp_get_post_parent_id( $post ) ) {
				?>
	X<p class="hero-parent-link">
				<a href="/cloud-native-landscape-guide/" title="Go to the Cloud native landscape guide">Cloud native landscape guide</a>
				</p>
	<?php } elseif ( 38018 === wp_get_post_parent_id( $post ) ) { ?>
	X<p class="hero-parent-link">
				<a href="/phippy/" title="Go to Phippy and friends">Phippy and friends</a>
				</p>
				<?php
	}
	// PAGE TITLE.
	?>
	<h1 class="is-style-page-title" itemprop="headline"><?php the_title(); ?>
	</h1>
			<?php
			elseif ( is_singular( 'lf_project' ) ) :
				if ( get_the_ID() && ( Lf_Utils::get_term_names( get_the_ID(), 'lf-project-stage', true ) === 'Sandbox' ) ) {
					?>
	x<p class="hero-parent-link">
			<a href="/sandbox-projects/" title="Go to Sandbox Projects">Projects</a>
			</p>
					<?php
				} else {
					?>
	x<p class="hero-parent-link">
			<a href="/projects/" title="Go to Graduated and Incubating Projects">Projects</a>
			</p>
					<?php
				}
				?>
	xd<h1 class="post-title" itemprop="headline"><?php the_title(); ?>
	</h1>
	<?php elseif ( ! ( is_404() ) && ( is_single() ) ) : ?>
	xc<h1 class="post-title" itemprop="headline"><?php the_title(); ?>
	</h1>
	<?php elseif ( is_404() ) : ?>
	xs<h2 class="post-title" itemprop="headline">Sorry that page wasn't
		found</h2>
	<?php elseif ( is_home() ) : ?>
	de<h2 class="blog-title"><?php single_post_title(); ?></h2>
	<?php else : ?>
	last<h1 class="is-style-page-title" itemprop="headline"><?php the_title(); ?></h1>
	<?php endif; ?>


</header>

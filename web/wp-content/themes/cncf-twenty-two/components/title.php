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
get_template_part( 'components/title-links' );
?>
<?php
if ( is_tag() || is_tax() ) :
	if ( is_tax( 'lf-author-category' ) ) {
		?>
	<h1 class="is-style-page-title">All <?php single_cat_title(); ?> Posts</h1>
			<?php
	} elseif ( is_tax( 'lf-report-type' ) ) {
		?>
		<h1 class="is-style-page-title">All <?php single_cat_title(); ?> Reports</h1>
				<?php
	} else {
		// Used for annual reports search?
		?>
	<h1 class="is-style-page-title">
		<?php single_cat_title(); ?>
	</h1>
			<?php
	}
	?>
	<?php elseif ( is_author() ) : ?>
	<h1 class="is-style-page-title">All posts by <?php the_author(); ?></h1>
	<?php elseif ( is_archive() ) : ?>
	<h1 class="is-style-page-title">
		<?php single_cat_title(); ?>
	</h1>
	<?php elseif ( is_search() ) : ?>
	<h2 class="is-style-page-title">Search results for:
	<span class="has-text-color has-primary-400-color"><?php echo esc_attr( get_search_query() ); ?></span></h2>
		<?php
		elseif ( ! ( is_404() ) && ( is_page() ) ) :
			// PHIPPY SECTION.
			if ( 38018 === wp_get_post_parent_id( $post ) ) {
				?>
	<div class="parent-link-align">
				<a class="parent-link" href="/phippy/" title="Go to Phippy and friends">Phippy and friends</a>
			</div>
				<?php
			}
			// TRAINING SECTION.
			$training_parent_ids = array( 8065, 8132, 97026 );
			if ( in_array( wp_get_post_parent_id( $post ), $training_parent_ids ) ) {
				?>
	<div class="parent-link-align">
				<a class="parent-link" href="/training/" title="Go to Training & Certification Overview">Training & Certification</a>
			</div>
				<?php
			}
			// PAGE TITLE.
			?>
	<h1 class="is-style-page-title" itemprop="headline"><?php the_title(); ?>
	</h1>
			<?php
			elseif ( is_singular( 'lf_project' ) ) :
				?>
	<h1 class="is-style-project-single-title" itemprop="headline"><?php the_title(); ?>
	</h1>
	<?php elseif ( ! ( is_404() ) && ( is_single() ) ) : ?>
		<?php
		if ( is_singular( 'lf_case_study' ) || is_singular( 'lf_case_study_cn' ) ) {
			?>
<!-- // case study title  -->
				<?php
		} else {
			?>
	<h1 class="is-style-post-title" itemprop="headline"><?php the_title(); ?>
	</h1>
				<?php
		}
		?>
		<?php
		if ( is_singular( 'lf_report' ) || is_singular( 'lf_human' ) || is_singular( 'lf_kubeweekly' ) ) {
			?>
<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>
<p class="is-style-spaced-uppercase has-small-font-size">Published: <?php echo get_the_date(); ?></p>
			<?php
		}
		?>
	<?php elseif ( is_home() ) : ?>
	<h2 class="blog-title"><?php single_post_title(); ?></h2>
	<?php else : ?>
	<h1 class="is-style-page-title" itemprop="headline"><?php the_title(); ?></h1>
	<?php endif; ?>
</header>

<?php
/**
 * News Item - Horizontal
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$is_featured             = $args['is_featured'] ? true : false;
$is_sticky               = $args['is_sticky'] ? true : false;
$is_in_the_news_category = $args['is_in_the_news'] ? true : false;
$is_blog_category        = $args['is_blog'] ? true : false;

// Merge classes.
$classes       = LF_Utils::merge_classes(
	array(
		$is_featured ? 'is-featured-item' : '',
		$is_in_the_news_category ? 'post-archive__item in-the-news-item' : 'post-archive__item ',
	)
);
$sticky_status = is_sticky() ? 'is-sticky-news' : 'not-sticky';
?>

<div class="news-item">
<?php // is-featured-item post-archive__item. ?>
<div class="<?php echo esc_html( $classes ); ?>">
<?php

if ( $is_in_the_news_category ) :

	$link_url = get_post_meta( get_the_ID(), 'lf_post_external_url', true );

	if ( ! $link_url ) {
		$link_url = get_the_permalink();
	}
	?>

<a class="post-archive__link" href="<?php echo esc_url( $link_url ); ?>" title="<?php the_title_attribute(); ?>">

		<?php
		if ( has_post_thumbnail() ) {
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-media-coverage', '600px', 'post-archive__image', 'lazy', get_the_title() );
		} else {
			echo '<img class="post-archive__image" src="' . esc_url( get_template_directory_uri() )
			. '/images/default-media-logo.svg" alt="CNCF Media Coverage" />';
		}
		?>
	</a>
	<div class="post-archive__text-wrapper">

	<span class="post-archive__title">
		<a href="<?php echo esc_url( $link_url ); ?>"
			title="<?php the_title_attribute(); ?>">
			<?php the_title(); ?>
		</a>
	</span>

		<span class="post-archive__item_date">
			<?php echo get_the_date( 'F j, Y' ); ?>
		</span>

		<div class="post-archive__excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
	</div>

	<?php
else :
	// Get the Category Author.
	$category_author = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );

	$category_author_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );
	?>

	<div class="post-archive__image-wrapper <?php echo esc_attr( $sticky_status ); ?>">

	<?php
	if ( is_sticky() ) {
		?>
	<div class="sticky-news-tag">
		Featured
	</div>
		<?php
	}
	?>

		<a class="post-archive__link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

			<?php

			if ( has_post_thumbnail() && $is_featured ) {
				// display large featured image.
				Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-776', '776px', 'post-archive__image', 'eager', get_the_title() );

			} elseif ( has_post_thumbnail() ) {
				// display smaller news image.
				Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-388', '388px', 'post-archive__image', 'lazy', get_the_title() );

			} else {
				// show generic.
				$site_options = get_option( 'lf-mu' );
				Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-388', '388px', 'post-archive__image', 'lazy', get_the_title() );
			}
			?>
		</a>
		</div>
		<div class="post-archive__text-wrapper">
		<?php
		if ( $category_author ) :
			$category_link = get_home_url() . '/blog?_sft_lf-author-category=' . $category_author_slug . '/';
			?>

		<span><a class="author-category has-larger-style"
				title="See <?php echo esc_attr( $category_author ); ?> posts"
				href="<?php echo esc_url( $category_link ); ?>">
			<?php
			echo esc_html( $category_author );
			?>
			Post</a></span>
			<?php
		endif;
		?>

<span class="post-archive__title">
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		<?php the_title(); ?>
	</a>
</span>

		<div class="post-archive__excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>

		<span class="post-archive__item_date">
			<?php
			echo get_the_date();
			?>
			<?php
			// Post author.
			if ( in_category( 'blog' ) && Lf_Utils::display_author( get_the_ID() ) ) {
				echo ' | ' . wp_kses_post( Lf_Utils::display_author( get_the_ID() ) );
			}

			?>
		</span>
	</div>

	<?php
endif;
?>
</div>
<?php
if ( ! $is_featured || in_category( 'announcements' ) ) {
	?>
<hr class="wp-block-separator is-style-shadow-line is-style-section-padding">
	<?php
} else {
	?>
<div style="height:50px" aria-hidden="true" class="wp-block-spacer is-style-30-50"></div>
	<?php
}
?>
</div>

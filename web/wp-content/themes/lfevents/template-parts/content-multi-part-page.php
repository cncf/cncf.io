<?php
/**
 * This template is used specifically within the page-templates/multi-part-page.php page template.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/*
	<header>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	*/
	?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php edit_post_link( __( '(Edit)', 'foundationpress' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
	<?php
	/*
	<footer>
		<?php
			wp_link_pages(
				array(
					'before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'foundationpress' ),
					'after'  => '</p></nav>',
				)
			);
			?>
		<?php
		$tag = get_the_tags(); if ( $tag ) {
			?>
			<p><?php the_tags(); ?></p><?php } ?>
	</footer>
	*/
	?>
</article>

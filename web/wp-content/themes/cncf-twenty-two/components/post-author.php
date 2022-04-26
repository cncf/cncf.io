<?php
/**
 * Post Author area.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<div class="post-author">
	<?php
	$author_image  = get_post_meta( get_the_ID(), 'lf_post_guest_author_image', true );
	$author_byline = Lf_Utils::display_author( get_the_ID() );
	if ( $author_image ) {
		Lf_Utils::display_responsive_images( $author_image, 'thumbnail', '7px', 'post-author__image', 'lazy', esc_html( $author_byline ) );
	}
	?>
	<div>
		<?php
		if ( $author_byline ) {
			?>
		<span
			class="post-author__author"><?php echo esc_html( $author_byline ); ?></span>
			<?php
		}
		?>
		<?php if ( $author_byline ) { ?>
		<span class="post-author__date"><?php the_date(); ?></span>
			<?php
		} else {
			?>
		<span class="post-author__date">Posted on <?php the_date(); ?></span>
			<?php
		}
		?>
	</div>
</div>

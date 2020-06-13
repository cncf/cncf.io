<?php
/**
 * Post pagination (Singular)
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$prev_post = get_adjacent_post( true, '', true );
$next_post = get_adjacent_post( true, '', false );
?>
<div class="post-pagination">
	<?php
	if ( is_a( $prev_post, 'WP_Post' ) ) :
		?>
	<a class="previous" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
		<< Previous Post: <?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></a>
			<?php
			endif;
	if ( is_a( $next_post, 'WP_Post' ) ) :
		?>
			<a class="next"
				href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">Next Post:
					<?php echo esc_html( get_the_title( $next_post->ID ) ); ?> >></a>
				<?php
			endif;
	?>
</div>

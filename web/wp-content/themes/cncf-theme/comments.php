<?php // phpcs:ignoreFile
/**
 * WordPress Comments
 *
 * Might need to revisit this page again - quite old.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<div class="comments">
	<?php if ( have_comments() ) : ?>
		<?php
		$comments = get_comments(
			array(
				'post_id' => get_the_ID(),
				'orderby' => 'comment_date',
				'order'   => 'ASC',
			)
		);
		?>
	<h3>
		<?php
		$comments_number = sizeof( $comments );
		if ( $comments_number === 1 ) {
			echo '1 Comment';
		} else {
			echo $comments_number . ' Comments';
		}
		?>
	</h3>
		<?php
		foreach ( $comments as $comment ) :
			if ( $comment->user_id == 0 ) {
				$name = $comment->comment_author;
			} else {
				$name = get_the_author_meta( 'display_name', $comment->user_id );
			}
			?>
	<div class="comment">
		<div class="image">
			<?php echo get_avatar( $comment->comment_author_email, 50 ); ?>
		</div>
		<div class="comment-text">
			<p class="comment-meta"><?php echo $name; ?> on
				<?php echo date( 'jS F Y G:i:s', strtotime( $comment->comment_date ) ); ?>
			</p>
			<p><?php echo $comment->comment_content; ?></p>
		</div>
	</div>
		<?php endforeach; ?>
	<hr>
	<?php endif; ?>
	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
	<p class="no-comments">Comments are closed on this post.</p>
		<?php endif; ?>
	<?php
	comment_form(
		array(
			'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h4>',
		)
	);
	?>
</div>

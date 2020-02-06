<?php
/**
 * Social Share
 *
 * A lightweight share sheet for sharing pages on social media.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$image = new Image();

 /**
  * Gets the URL to share from current permalink.
  */
$page_url = urlencode( get_permalink() );

/**
 * Gets the title of the page from current page.
 */
$page_title = htmlspecialchars( urlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );

// $image = wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'full' );
// if ($image) {
// $image = urlencode($image);
// }

$facebook_url  = 'https://www.facebook.com/sharer/sharer.php?u=' . $page_url . '&t=' . $page_title;
$twitter_url   = 'https://twitter.com/intent/tweet?text=' . $page_title . '&amp;url=' . $page_url . '&amp;via=' . $twitter . '&hashtags=socialmedia,sharethis';
$tumblr_url    = 'https://www.tumblr.com/widgets/share/tool?&url=' . $page_url;
$whatsapp_url  = 'https://api.whatsapp.com/send?text=' . $page_title . ' ' . $page_url;
$messenger_url = 'fb-messenger://share/?link=' . $page_url . '&app_id=XXXXXXXXXXXXXXXXXXXX';
$reddit_url    = 'https://www.reddit.com/submit?url=' . $page_url . '&title=' . $page_title;
$linkedin_url  = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $page_title . '';
$mailto_url    = 'mailto:?subject=' . $page_title . '&body=' . $page_url . '';
?>

<div class="share-icons">
	<!-- facebook -->
	<a target="_blank" aria-label="Share on Facebook" title="Share on Facebook"
		href="<?php echo esc_url( $facebook_url ); ?>"><?php $image->get_svg( 'social/facebook.svg' ); ?></a>

	<!-- twitter -->
	<a target="_blank" aria-label="Share on Twitter" title="Share on Twitter"
		href="<?php echo esc_url( $twitter_url ); ?>"><?php $image->get_svg( 'social/twitter.svg' ); ?></a>

	<!-- tumblr  -->
	<a target="_blank" aria-label="Share on Tumblr" title="Share on Tumblr"
		href="<?php echo esc_url( $tumblr_url ); ?>">
		<?php $image->get_svg( 'social/tumblr.svg' ); ?>
	</a>

	<!-- messenger -->
	<a target="_blank" aria-label="Share on Messenger"
		title="Share on Messenger" class="hideover768"
		href="<?php echo esc_url( $messenger_url ); ?>">
		<?php $image->get_svg( 'social/messenger.svg' ); ?>
	</a>

	<!-- whatsApp -->
	<a target="_blank" aria-label="Share on WhatsApp" title="Share on WhatsApp"
		href="<?php echo esc_url( $whatsapp_url ); ?>"><?php $image->get_svg( 'social/whatsapp.svg' ); ?></a>

	<!-- reddit -->
	<a target="_blank" aria-label="Share on Reddit" title="Share on Reddit"
		href="<?php echo esc_url( $reddit_url ); ?>"><?php $image->get_svg( 'social/reddit.svg' ); ?></a>

	<!-- linkedin -->
	<a target="_blank" aria-label="Share on Linkedin" title="Share on Linkedin"
		href="<?php echo esc_url( $linkedin_url ); ?>"><?php $image->get_svg( 'social/linkedin.svg' ); ?></a>

	<!-- sendto email -->
	<a target="_blank" aria-label="Share by Email" title="Share by Email"
		href="<?php echo esc_url( $mailto_url ); ?>"><?php $image->get_svg( 'social/email.svg' ); ?></a>

</div>

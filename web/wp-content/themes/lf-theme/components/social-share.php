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

/**
 * Gets the featured image.
 */
$featured_image = wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'full' );
if ( $featured_image ) {
	$featured_image = urlencode( $featured_image );
}

/**
 * Gets Twitter handle.
 */
$options = get_option( 'cncf-mu' );
$options && $options['social_twitter_handle'] ? $twitter = $options['social_twitter_handle'] : $twitter = '';

/**
 * Build the URLs.
 */
$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $page_url . '&t=' . $page_title;

$twitter_url = 'https://twitter.com/intent/tweet?text=' . $page_title . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';

$whatsapp_url = 'https://api.whatsapp.com/send?text=' . $page_title . ' ' . $page_url;

$reddit_url = 'https://www.reddit.com/submit?url=' . $page_url . '&title=' . $page_title;

$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $page_title . '';

$mailto_url = 'mailto:?subject=' . $page_title . '&body=' . $page_url . '';
?>

<div class="social-share">
<p class="social-share-title">Share this post</p>

<div class="social-share-wrapper">
	<!-- facebook -->
	<?php if ( $facebook_url ) : ?>
	<a target="_blank" aria-label="Share on Facebook" title="Share on Facebook"
		href="<?php echo esc_url( $facebook_url ); ?>"><?php $image->get_svg( 'social/facebook.svg' ); ?></a>
	<?php endif; ?>

	<!-- twitter -->
	<?php if ( $twitter_url ) : ?>
	<a target="_blank" aria-label="Share on Twitter" title="Share on Twitter"
		href="<?php echo esc_url( $twitter_url ); ?>"><?php $image->get_svg( 'social/twitter.svg' ); ?></a>
	<?php endif; ?>

	<!-- whatsApp -->
	<?php if ( $whatsapp_url ) : ?>
	<a target="_blank" aria-label="Share on WhatsApp" title="Share on WhatsApp" data-action="share/whatsapp/share"
		href="<?php echo esc_url( $whatsapp_url ); ?>"><?php $image->get_svg( 'social/whatsapp.svg' ); ?></a>
	<?php endif; ?>

	<!-- reddit -->
	<?php if ( $reddit_url ) : ?>
	<a target="_blank" aria-label="Share on Reddit" title="Share on Reddit"
		href="<?php echo esc_url( $reddit_url ); ?>"><?php $image->get_svg( 'social/reddit.svg' ); ?></a>
	<?php endif; ?>

	<!-- linkedin -->
	<?php if ( $linkedin_url ) : ?>
	<a target="_blank" aria-label="Share on Linkedin" title="Share on Linkedin"
		href="<?php echo esc_url( $linkedin_url ); ?>"><?php $image->get_svg( 'social/linkedin.svg' ); ?></a>
	<?php endif; ?>

	<!-- sendto email -->
	<?php if ( $mailto_url ) : ?>
	<a target="_blank" aria-label="Share by Email" title="Share by Email"
		href="<?php echo esc_url( $mailto_url ); ?>"><?php $image->get_svg( 'social/email.svg' ); ?></a>
	<?php endif; ?>
	</div>
</div>

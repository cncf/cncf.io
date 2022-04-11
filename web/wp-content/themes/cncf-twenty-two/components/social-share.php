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
$site_options = get_option( 'lf-mu' );
$site_options && $site_options['social_twitter_handle'] ? $twitter = $site_options['social_twitter_handle'] : $twitter = '';

/**
 * Build the URLs.
 */
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $page_title . '';

$twitter_url = 'https://twitter.com/intent/tweet?text=' . $page_title . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';

$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $page_url . '&t=' . $page_title;

$mailto_url = 'mailto:?subject=' . $page_title . '&body=' . $page_url . '';
?>

<div class="social-share">
	<p class="social-share__title">Share</p>

	<div class="social-share__wrapper">
		<!-- linkedin -->
		<?php if ( $linkedin_url ) : ?>
		<a aria-label="Share on Linkedin"
			title="Share on Linkedin"
			href="<?php echo esc_url( $linkedin_url ); ?>"><?php LF_utils::get_svg( 'social/linkedin-white.svg' ); ?></a>
		<?php endif; ?>

		<!-- facebook -->
		<?php if ( $facebook_url ) : ?>
		<a aria-label="Share on Facebook"
			title="Share on Facebook"
			href="<?php echo esc_url( $facebook_url ); ?>"><?php LF_utils::get_svg( 'social/facebook.svg' ); ?></a>
		<?php endif; ?>

		<!-- twitter -->
		<?php if ( $twitter_url ) : ?>
		<a aria-label="Share on Twitter"
			title="Share on Twitter"
			href="<?php echo esc_url( $twitter_url ); ?>"><?php LF_utils::get_svg( 'social/twitter.svg' ); ?></a>
		<?php endif; ?>

		<!-- sendto email -->
		<?php if ( $mailto_url ) : ?>
		<a aria-label="Share by Email" title="Share by Email"
			href="<?php echo esc_url( $mailto_url ); ?>"><?php LF_utils::get_svg( 'social/email.svg' ); ?></a>
		<?php endif; ?>
	</div>
</div>

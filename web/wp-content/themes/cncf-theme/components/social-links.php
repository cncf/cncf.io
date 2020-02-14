<?php
/**
 * Social Links
 *
 * Pulls in from Global and dipslay inline SVGs with outbound links.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$options = get_option( 'cncf-mu' );
$image   = new Image();
?>

<ul class="social-links">
	<?php if ( $options['social_twitter'] ) : ?>
	<li class="social_twitter"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on Twitter"; ?>"
			href="<?php echo esc_url( $options['social_twitter'] ); ?>"><?php $image->get_svg( 'social/twitter.svg' ); ?>
		</a></li>
	<?php endif; ?>

	<?php if ( $options['social_wechat_id'] ) : ?>
	<li class="social_wechat_id"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on WeChat"; ?>"
			href="#"><?php $image->get_svg( 'social/wechat.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( $options['social_youtube'] ) : ?>
	<li class="social_youtube"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on YouTube"; ?>"
			href="<?php echo esc_url( $options['social_youtube'] ); ?>"><?php $image->get_svg( 'social/youtube.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( $options['social_github'] ) : ?>
	<li class="social_github"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on Github"; ?>"
			href="<?php echo esc_url( $options['social_github'] ); ?>"><?php $image->get_svg( 'social/github.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( $options['social_flickr'] ) : ?>
	<li class="social_flickr"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on Flickr"; ?>"
			href="<?php echo esc_url( $options['social_flickr'] ); ?>"><?php $image->get_svg( 'social/flickr.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( $options['social_linkedin'] ) : ?>
	<li class="social_linkedin"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on LinkedIn"; ?>"
			href="<?php echo esc_url( $options['social_linkedin'] ); ?>"><?php $image->get_svg( 'social/linkedin.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( $options['social_email'] ) : ?>
	<li class="social_email"><a target="_blank" title="<?php echo "Contact" . esc_html( get_bloginfo( 'name' ) ); ?>"
			href="<?php echo esc_url( $options['social_email'] ); ?>"><?php $image->get_svg( 'social/email.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( $options['social_facebook'] ) : ?>
	<li class="social_facebook"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on Facebook"; ?>"
			href="<?php echo esc_url( $options['social_facebook'] ); ?>"><?php $image->get_svg( 'social/facebook.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( $options['social_instagram'] ) : ?>
	<li class="social_instagram"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on Instagram"; ?>"
			href="<?php echo esc_url( $options['social_instagram'] ); ?>"><?php $image->get_svg( 'social/instagram.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( $options['social_meetup'] ) : ?>
	<li class="social_meetup"><a target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ) . " on Meetup"; ?>"
			href="<?php echo esc_url( $options['social_meetup'] ); ?>"><?php $image->get_svg( 'social/meetup.svg' ); ?></a></li>
	<?php endif; ?>
</ul>

<?php
/**
 * Social Links
 *
 * Pulls in from Global options and displays inline SVGs with outbound links.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$site_options = get_option( 'lf-mu' );
?>

<ul class="social-links">
	<?php if ( isset( $site_options['social_twitter'] ) && $site_options['social_twitter'] ) : ?>
	<li class="social-twitter"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on Twitter'; ?>"
			href="<?php echo esc_url( $site_options['social_twitter'] ); ?>"><?php LF_Utils::get_svg( 'social/twitter.svg' ); ?>
		</a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_github'] ) && $site_options['social_github'] ) : ?>
	<li class="social-github"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on Github'; ?>"
			href="<?php echo esc_url( $site_options['social_github'] ); ?>"><?php LF_Utils::get_svg( 'social/github.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_linkedin'] ) && $site_options['social_linkedin'] ) : ?>
	<li class="social-linkedin"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on LinkedIn'; ?>"
			href="<?php echo esc_url( $site_options['social_linkedin'] ); ?>"><?php LF_Utils::get_svg( 'social/linkedin-black.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_instagram'] ) && $site_options['social_instagram'] ) : ?>
	<li class="social-instagram"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on Instagram'; ?>"
			href="<?php echo esc_url( $site_options['social_instagram'] ); ?>"><?php LF_Utils::get_svg( 'social/instagram.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_wechat'] ) && $site_options['social_wechat'] ) : ?>
	<li class="social-wechat"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on WeChat'; ?>"
			href="<?php echo esc_url( $site_options['social_wechat'] ); ?>"><?php LF_Utils::get_svg( 'social/wechat.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_youtube'] ) && $site_options['social_youtube'] ) : ?>
	<li class="social-youtube"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on YouTube'; ?>"
			href="<?php echo esc_url( $site_options['social_youtube'] ); ?>"><?php LF_Utils::get_svg( 'social/youtube.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_flickr'] ) && $site_options['social_flickr'] ) : ?>
	<li class="social-flickr"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on Flickr'; ?>"
			href="<?php echo esc_url( $site_options['social_flickr'] ); ?>"><?php LF_Utils::get_svg( 'social/flickr.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_facebook'] ) && $site_options['social_facebook'] ) : ?>
	<li class="social-facebook"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on Facebook'; ?>"
			href="<?php echo esc_url( $site_options['social_facebook'] ); ?>"><?php LF_Utils::get_svg( 'social/facebook.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_meetup'] ) && $site_options['social_meetup'] ) : ?>
	<li class="social-meetup"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on Meetup'; ?>"
			href="<?php echo esc_url( $site_options['social_meetup'] ); ?>"><?php LF_Utils::get_svg( 'social/meetup.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_twitch'] ) && $site_options['social_twitch'] ) : ?>
	<li class="social-twitch"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' on Twitch'; ?>"
			href="<?php echo esc_url( $site_options['social_twitch'] ); ?>"><?php LF_Utils::get_svg( 'social/twitch.svg' ); ?></a></li>
	<?php endif; ?>

	<?php if ( isset( $site_options['social_slack'] ) && $site_options['social_slack'] ) : ?>
	<li class="social-slack"><a title="<?php echo esc_html( get_bloginfo( 'name' ) ) . ' Slack'; ?>"
			href="<?php echo esc_url( $site_options['social_slack'] ); ?>"><?php LF_Utils::get_svg( 'social/slack.svg' ); ?></a></li>
	<?php endif; ?>
</ul>

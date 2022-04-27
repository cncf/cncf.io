<?php
/**
 * Smash Balloon Custom Twitter Feeds Header Template
 * Information about the type of feed and related account
 *
 * @version 1.13 Custom Twitter Feeds by Smash Balloon
 *
 */
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
use TwitterFeed\Pro\CTF_Parse_Pro;
use TwitterFeed\Pro\CTF_Display_Elements_Pro;

$header_no_bio = ( !$feed_options['showbio'] || empty( $header_info['description'] ) ) ? $header_no_bio = ' ctf-no-bio' : $header_no_bio = "";
$header_info = CTF_Parse_Pro::get_user_header_json( $feed_options );

$header_text = CTF_Parse_Pro::get_header_text( $header_info, $feed_options );
$header_description = CTF_Parse_Pro::get_header_description( $header_info );
$header_attr = CTF_Display_Elements_Pro::get_element_attribute( 'header', $feed_options );
$avatar = CTF_Parse_Pro::get_header_avatar( $header_info, $feed_options );
$username = CTF_Parse_Pro::get_user_name( $header_info );
$verified_account = ( $header_info['verified'] == 1 ) ? ctf_get_fa_el( 'fa-check-circle' ) : "";
$tweet_count = CTF_Parse_Pro::get_header_tweet_count( $header_info );
$follower_count = CTF_Parse_Pro::get_follower_count( $header_info );
$header_styles = $feed_options['headerbgcolor'] . $feed_options['headertextcolor'];
$follow_button_text = __( 'Follow', 'custom-twitter-feeds' );

$bio_attr = CTF_Display_Elements_Pro::get_element_attribute( 'headerbio', $feed_options );

?>

<div class="ctf-header<?php echo esc_attr( $header_no_bio ); ?>" style="<?php echo $header_styles ?>" <?php echo $header_attr ?>>
    <a href="<?php echo esc_url('https://twitter.com/' . $username . '/' ); ?>" target="_blank" rel="nofollow noopener noreferrer" title="@<?php echo esc_attr( $username ); ?>" class="ctf-header-link">
        <div class="ctf-header-text">
            <p class="ctf-header-user">
                <span class="ctf-header-name"><?php echo esc_html( $header_text ); ?></span>
                <span class="ctf-verified"><?php echo $verified_account; ?></span>
                <span class="ctf-header-follow"><?php echo $follow_button_text; ?></span>
                <span class="ctf-header-counts">
                    <span class="ctf-header-tweets-count" title="<?php echo $tweet_count; ?> Tweets"><?php echo ctf_get_fa_el( 'fa-twitter' ) . $tweet_count ?></span>
                    <span class="ctf-header-followers"  title="<?php echo $follower_count . ' ' . __( 'Followers', 'registrations-for-the-events-calendar' ); ?>"><?php echo ctf_get_fa_el( 'fa-user' ) . $follower_count ?></span>
                </span>
            </p>
            <?php if ( $feed_options['showbio'] && ! empty( $header_description )  || ctf_doing_customizer( $feed_options )) : ?>
                <p class="ctf-header-bio" <?php echo $bio_attr ?> >
                    <?php echo $header_description; ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="ctf-header-img">
            <div class="ctf-header-img-hover"><?php echo ctf_get_fa_el( 'fa-twitter' ); ?></div>
            <img src="<?php echo esc_url( $avatar ); ?>" alt="<?php echo esc_attr( $username ); ?>" width="48" height="48">
        </div>
    </a>
</div>
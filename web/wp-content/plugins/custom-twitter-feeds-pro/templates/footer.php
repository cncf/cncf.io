<?php
/**
 * Smash Balloon Custom Twitter Feeds Item Template
 * Adds the content for each tweet in the feed
 *
 * @version 1.13 Custom Twitter Feeds by Smash Balloon
 *
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$load_more_text = __( $feed_options['buttontext'], 'custom-twitter-feeds' );
$load_more_style_att = CTF_Display_Elements_Pro::load_more_style_att( $feed_options );
?>    

<?php if ( $feed_options['showbutton'] ) : ?>
    <a href="javascript:void(0);" id="ctf-more" class="ctf-more"<?php echo $load_more_style_att ?>><span><?php echo esc_html( $load_more_text ) ?></span></a>
<?php endif; ?>

<?php if ( $feed_options['creditctf'] ) : ?>
    <div class="ctf-credit-link"><a href="https://smashballoon.com/custom-twitter-feeds" target="_blank"><?php ctf_get_fa_el( 'fa-twitter' ) ?> Custom Twitter Feeds Plugin</a></div>
<?php endif; ?>
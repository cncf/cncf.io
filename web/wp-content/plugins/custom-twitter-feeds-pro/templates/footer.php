<?php
/**
 * Smash Balloon Custom Twitter Feeds Item Template
 * Adds the content for each tweet in the feed
 *
 * @version 1.13 Custom Twitter Feeds by Smash Balloon
 *
 */

use TwitterFeed\Pro\CTF_Display_Elements_Pro;
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$loadmore_attr = CTF_Display_Elements_Pro::get_element_attribute( 'loadmore', $feed_options );
?>
<?php if ( ( filter_var($feed_options['showbutton'], FILTER_VALIDATE_BOOLEAN) == true) || ctf_doing_customizer( $feed_options ) ) : ?>
    <a href="javascript:void(0);" id="ctf-more" class="ctf-more" <?php echo $loadmore_attr ?>><span><?php echo esc_html( $feed_options['buttontext'] ) ?></span></a>
<?php endif; ?>

<?php if ( $options['creditctf']) : ?>
    <div class="ctf-credit-link"><a href="https://smashballoon.com/custom-twitter-feeds" target="_blank"><?php ctf_get_fa_el( 'fa-twitter' ) ?> Custom Twitter Feeds Plugin</a></div>
<?php endif; ?>
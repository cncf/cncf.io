<?php
/**
 * Smash Balloon Custom Twitter Feeds Main Template
 * Creates the wrapping HTML and adds settings as attributes
 *
 * @version 1.13 Custom Twitter Feeds by Smash Balloon
 *
 */
use TwitterFeed\Pro\CTF_Display_Elements_Pro;
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>

<!-- Custom Twitter Feeds by Smash Balloon -->
<div id="ctf" <?php echo $ctf_feed_classes ?> data-ctfshortcode="<?php echo $this->getShortCodeJSON() ?>" <?php echo $ctf_main_atts ?> data-ctfneeded="<?php echo esc_attr( $ctf_data_needed ) ?>">
    <?php if ( $feed_options['showheader'] || ctf_doing_customizer($feed_options) ) :
        CTF_Display_Elements_Pro::display_header( $feed_options );
    endif; ?>

    <div class="ctf-tweet-items">
    <?php $this->tweet_loop( $tweet_set, $feed_options, $is_pagination ); ?>
    </div>

    <?php
    include ctf_get_feed_template_part( 'footer', $feed_options );

    /**
     * Things to add before the closing "div" tag for the main feed element. Several
     * features rely on this hook such as local images and some error messages
     *
     * @param object CTFFeedPro
     * @param string $feed_id
     *
     * @since 1.8/1.13
     */
    do_action( 'ctf_before_feed_end', $this, $feed_id ); ?>

</div>

<?php
/**
 * Smash Balloon Custom Twitter Feeds Item Template
 * Wrapper for the content of the tweet
 *
 * @version 1.13 Custom Twitter Feeds by Smash Balloon
 *
 */
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$disablelightbox = $feed_options['disablelightbox'];
$disable_lightbox_class = $disablelightbox ? ' ctf-disable-lightbox' : '';

$post = CTF_Parse_Pro::get_post( $tweet_set[$i] );
$id_post_id = CTF_Parse_Pro::get_post_id( $tweet_set[$i] );
$post_id  = CTF_Parse_Pro::get_post_id( $post );
$post_text = CTF_Display_Elements_Pro::post_text( $post, $feed_options );

$num_media = false;
$media_classes = CTF_Display_Elements_Pro::media_classes( $media );

$author   = CTF_Parse_Pro::get_author_name( $post );
$tweet_classes = CTF_Parse_Pro::get_item_classes( $tweet_set, $feed_options, $i);
$retweeter = CTF_Parse_Pro::get_retweeter_name( $tweet_set, $i );
$replied_to  = CTF_Parse_Pro::get_replied_to( $post );

$quoted = CTF_Parse_Pro::get_quoted_tc( $post );
$quoted_media = CTF_Parse_Pro::get_quoted_media( $quoted, $num_media );

$retweet_count = CTF_Parse_Pro::get_retweet_count( $post );
$favorite_count = CTF_Parse_Pro::get_favorite_count( $post );

$tweet_text_styles = $feed_options['tweettextsize'] . $feed_options['tweettextweight'] . $feed_options['textcolor'];
$tweet_action_styles = $feed_options['iconsize'] . $feed_options['iconcolor'];
$icon_size = ! empty( $feed_options['iconsize'] ) ? 'font-size: ' . floor( .8 * str_replace( array( 'px;', 'font-size: ' ), '', $feed_options['iconsize'] ) ) . 'px;' : '';
$twitter_link_styles = $icon_size . $feed_options['textcolor'];
$tweet_action_end_url = $post_id . '&related=' . $author;

$retweet_status = CTF_Parse_Pro::get_retweet_status( $tweet_set[$i] );
$retweet_post_id = CTF_Parse_Pro::get_retweet_id( $tweet_set[$i] );

$tweet_text_start = '';
$tweet_text_end = '';
if ( $feed_options['linktexttotwitter'] ) {
	$tweet_text_start = '<a class="ctf-tweet-text-link" href="' . esc_url( 'https://twitter.com/' . $author . '/status/' .$post_id ) . '" target = "_blank" rel = "noopener noreferrer">';
	$tweet_text_end = '</a>';
}
?>

<div class="<?php echo esc_attr( $tweet_classes ) ?>" id="ctf_<?php echo esc_attr( $id_post_id ) ?>" style="<?php echo esc_attr( $feed_options['tweetbgcolor'] ) ?>">

    <?php include ctf_get_feed_template_part( 'author', $feed_options ); ?>

    <?php if ( ctf_show( 'text', $feed_options ) || ctf_show( 'media', $feed_options ) || ctf_show( 'twittercards', $feed_options ) || ctf_show( 'linkbox', $feed_options ) ) : ?>
    <div class="ctf-tweet-content<?php echo esc_attr( $disable_lightbox_class ); ?>">
        <?php if ( ctf_show( 'text', $feed_options ) ) : ?>
	        <?php echo $tweet_text_start ; ?><p class="ctf-tweet-text" style="<?php echo esc_attr( $tweet_text_styles ) ?>"><?php echo nl2br( $post_text ) ?></p><?php echo $tweet_text_end ; ?>
        <?php endif; ?>

        <?php if ( ctf_show( 'media', $feed_options ) && $media ) :
            include ctf_get_feed_template_part( 'media', $feed_options );
        elseif ( $should_show_twitter_card ) :
            $parts = CTF_Display_Elements_Pro::get_twitter_card_parts( $twitter_card_url, $twitter_card );
            echo CTF_Display_Elements_Pro::get_twitter_card_html( $parts );
        endif; ?>

	    <?php echo $maybe_twitter_card_placeholder; ?>

        <?php if ( ctf_show( 'linkbox', $feed_options ) && isset( $quoted ) ) : ?>
            <?php include ctf_get_feed_template_part( 'linkbox', $feed_options ); ?>
        <?php endif; ?>

    </div>
    <?php endif; ?>

    <div class="ctf-tweet-actions">
    <?php if ( ctf_show( 'actions', $feed_options ) ) : ?>
        <a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?in_reply_to=' . $tweet_action_end_url ) ?>" class="ctf-reply" target="_blank" rel="noopener noreferrer" style="<?php echo esc_attr( $tweet_action_styles ) ?>">
            <?php echo ctf_get_fa_el( 'fa-reply' ) ?>
            <span class="ctf-screenreader"><?php _e( 'Reply on Twitter', 'custom-twitter-feeds' ); ?> <?php echo esc_attr( $post_id )?></span>
        </a>

        <a href="<?php echo esc_url( 'https://twitter.com/intent/retweet?tweet_id=' . $tweet_action_end_url ) ?>" class="ctf-retweet" target="_blank" rel="noopener noreferrer" style="<?php echo esc_attr( $tweet_action_styles ) ?>">
            <?php echo ctf_get_fa_el( 'fa-retweet' ) ?>
            <span class="ctf-screenreader"><?php _e( 'Retweet on Twitter', 'custom-twitter-feeds' ); ?> <?php echo esc_attr( $post_id ) ?></span>
            <span class="ctf-action-count ctf-retweet-count"><?php echo $retweet_count; ?></span>
        </a>

        <a href="<?php echo esc_url( 'https://twitter.com/intent/like?tweet_id=' . $tweet_action_end_url ) ?>" class="ctf-like" target="_blank" rel="noopener noreferrer" style="<?php echo esc_attr( $tweet_action_styles ) ?>">
            <?php echo ctf_get_fa_el( 'fa-heart' ) ?>
            <span class="ctf-screenreader"><?php _e( 'Like on Twitter', 'custom-twitter-feeds' ); ?> <?php echo esc_attr( $post_id ) ?></span>
            <span class="ctf-action-count ctf-favorite-count"><?php echo $favorite_count; ?></span>
        </a>
    <?php endif; ?>

    <?php if ( ctf_show( 'twitterlink', $feed_options ) ) : ?>
        <a href="<?php echo esc_url( 'https://twitter.com/' . $author . '/status/' .$post_id ) ?>" class="ctf-twitterlink" style="<?php echo esc_attr( $twitter_link_styles ) ?>" target="_blank">
            <?php echo esc_html( $feed_options['twitterlinktext'] ) ?>
            <span class="ctf-screenreader"><?php echo esc_attr( $post_id ) ?></span>
        </a>
    <?php endif; ?>

    </div>
</div>
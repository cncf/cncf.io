<?php
/**
 * Smash Balloon Custom Twitter Feeds Author Template
 * Information about the person tweeting, replying, or quoting
 *
 * @version 1.13 Custom Twitter Feeds by Smash Balloon
 *
 */
use TwitterFeed\Pro\CTF_Parse_Pro;
use TwitterFeed\Pro\CTF_Display_Elements_Pro;
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$author_display_name = CTF_Display_Elements_Pro::author_name( $post );
$author_screen_name = CTF_Parse_Pro::get_author_screen_name( $post );
$author_display_screen_name = CTF_Display_Elements_Pro::author_screen_name( $post );

$post_id = CTF_Parse_Pro::get_tweet_id( $post );
$utf_offset = CTF_Parse_Pro::get_utc_offset( $post );
$created_at = CTF_Parse_Pro::get_original_timestamp( $post );
$verified = CTF_Parse_Pro::get_verified( $post );
$profile_url = CTF_Parse_Pro::get_profile_image_url_https( $post );
$avatar_src = CTF_Display_Elements_Pro::get_avatar_url( $post );
$avatar = CTF_Parse_Pro::get_avatar( $post );
$author_attr = CTF_Display_Elements_Pro::get_element_attribute( 'author', $feed_options );
$avatar_attr = CTF_Display_Elements_Pro::get_element_attribute( 'avatar', $feed_options );
$author_text_attr = CTF_Display_Elements_Pro::get_element_attribute( 'author_text', $feed_options );
$date_attr = CTF_Display_Elements_Pro::get_element_attribute( 'date', $feed_options );
$logo_attr = CTF_Display_Elements_Pro::get_element_attribute( 'logo', $feed_options );
$repliedto_attr = CTF_Display_Elements_Pro::get_element_attribute( 'repliedto', $feed_options );
$retweeter_attr = CTF_Display_Elements_Pro::get_element_attribute( 'retweeter', $feed_options );

$date_text_attr = CTF_Display_Elements_Pro::get_post_date_attr($created_at, $feed_options );


if ( isset( $retweeter ) && ctf_show( 'retweeter', $feed_options ) ) :
$retweeter_name = $retweeter['name'];
$retweeter_screen_name = $retweeter['screen_name'];
?>
<div class="ctf-context" <?php echo $retweeter_attr ?>>
    <a href="<?php echo esc_url( 'https://twitter.com/intent/user?screen_name=' . $retweeter_screen_name ) ?>" target="_blank" rel="nofollow noopener noreferrer" class="ctf-retweet-icon"><?php echo ctf_get_fa_el( 'fa-retweet' ) ?><span class="ctf-screenreader"><?php esc_html_e( 'Retweet on Twitter', 'custom-twitter-feeds' ); ?></span></a>
    <a href="<?php echo esc_url( 'https://twitter.com/' . strtolower( $retweeter_screen_name ) ) ?>" target="_blank" rel="nofollow noopener noreferrer" class="ctf-retweet-text"><?php echo esc_html( $retweeter_name . ' ' . __( $feed_options['retweetedtext'], 'custom-twitter-feeds' ) )?></a>
</div>
<?php elseif ( isset( $replied_to ) && ctf_show( 'repliedto', $feed_options ) ) : ?>
<div class="ctf-context" <?php echo $repliedto_attr ?>>
    <a href="<?php echo esc_url( 'https://twitter.com/' . strtolower( $author_screen_name ) . '/status/' . $post_id ) ?>" target="_blank" rel="nofollow noopener noreferrer" class="ctf-reply-icon"><?php echo ctf_get_fa_el( 'fa-reply' ) ?><span class="ctf-screenreader"><?php esc_html_e( 'View tweet on Twitter', 'custom-twitter-feeds' ); ?></span></a>
    <a href="<?php echo esc_url( 'https://twitter.com/' . strtolower( $replied_to['screen_name'] ) ) ?>" target="_blank" rel="nofollow noopener noreferrer" class="ctf-replied-to-text"><?php echo esc_html( __( $feed_options['inreplytotext'], 'custom-twitter-feeds' ) . ' ' . $replied_to['name'] ) ?></a>
</div>
<?php endif; ?>

<?php if ( ctf_show( 'avatar', $feed_options ) || ctf_show( 'author', $feed_options ) || ctf_show( 'logo', $feed_options ) || ctf_show( 'date', $feed_options ) ) : ?>
<div class="ctf-author-box">
    <div class="ctf-author-box-link">
        <?php if ( ctf_show( 'author', $feed_options ) ) : ?>
            <?php if ( ctf_show( 'avatar', $feed_options ) ) : ?>
                <a href="<?php echo esc_url( 'https://twitter.com/' . $author_screen_name ) ?>" class="ctf-author-avatar" target="_blank" rel="nofollow noopener noreferrer" <?php echo $avatar_attr; ?>>
                    <img src="<?php echo esc_url( $avatar_src ) ?>" alt="<?php echo esc_attr( $author_display_screen_name ) ?> avatar" data-avatar="<?php echo esc_url( $avatar ) ?>" width="48" height="48">;
                </a>
            <?php endif; ?>

            <?php if ( ctf_show( 'author_text', $feed_options ) ) : ?>
                <a href="<?php echo esc_url( 'https://twitter.com/' . $author_screen_name ) ?>" target="_blank" rel="nofollow noopener noreferrer" class="ctf-author-name" <?php echo $author_text_attr; ?>><?php echo esc_html( $author_display_name ) ?></a>
                <?php if ( $verified == 1 ) : ?>
                    <span class="ctf-verified" <?php echo $author_text_attr; ?>><?php echo ctf_get_fa_el( 'fa-check-circle' ) ?></span>
                <?php endif; ?>
                <a href="<?php echo esc_url( 'https://twitter.com/' . $author_screen_name ) ?>" class="ctf-author-screenname" target="_blank" rel="nofollow noopener noreferrer" <?php echo $author_text_attr; ?>>@<?php echo esc_html( $author_display_screen_name ) ?></a>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ( ctf_show( 'date', $feed_options ) ) : ?>
		    <?php if ( ctf_show( 'author_text', $feed_options ) ) : ?>
                <span class="ctf-screename-sep" <?php echo $author_text_attr ?>>&middot;</span>
	        <?php endif; // show seperator ?>
            <div class="ctf-tweet-meta" <?php echo $date_attr ?>>
              <a href="<?php echo esc_url( 'https://twitter.com/' . $author_screen_name . '/status/' . $post_id ) ?>" class="ctf-tweet-date" target="_blank" rel="nofollow noopener noreferrer" <?php echo $date_text_attr; ?>><?php echo esc_html( ctf_get_formatted_date( $created_at, $feed_options, $utf_offset ) ) ?> <span class="ctf-screenreader"> <?php echo esc_html( $post_id ) ?></span></a>
            </div>
        <?php endif; // show date ?>
    </div>
    <?php if ( ctf_show( 'logo', $feed_options ) ) : ?>
        <div class="ctf-corner-logo" <?php echo $logo_attr ?>>
            <?php echo ctf_get_fa_el( 'fa-twitter' ); ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

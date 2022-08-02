<?php
/**
 * Smash Balloon Custom Twitter Feeds Link Box Template
 * For quoted tweets
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

if ( isset( $quoted_media[0] ) ) {
    $medium = $quoted_media[0];
    $ctf_lightbox_image = CTF_Display_Elements_Pro::lightbox_image( $medium );
    $media_link = $disablelightbox ? 'https://twitter.com/' .$post['user']['screen_name'] . '/status/' . $post['id_str'] : $ctf_lightbox_image;
    $media_link_classes = CTF_Display_Elements_Pro::media_link_classes( $medium, $disablelightbox );
    $linkbox_link_att_string = CTF_Display_Elements_Pro::linkbox_link_attributes( $medium, $post, $feed_options, $disablelightbox );
}
$quoted_name = CTF_Parse_Pro::get_quoted_name( $quoted );
$quoted_verfied = CTF_Parse_Pro::get_quoted_verified( $quoted );
$quoted_screen_name = CTF_Parse_Pro::get_quoted_screen_name( $quoted );
$quoted_text = apply_filters( 'ctf_quoted_tweet_text', $quoted['text'], $feed_options, $quoted );

$linkbox_attr = CTF_Display_Elements_Pro::get_element_attribute( 'linkbox', $feed_options );


if ( $quoted_media && ( $quoted_media[0]['type'] == 'video' || $quoted_media[0]['type'] == 'animated_gif') ) :
?>

<div class="ctf-quoted-media-wrap"<?php echo CTF_Display_Elements_Pro::get_available_images_attribute( $quoted ) ?> <?php echo $linkbox_attr ?>>
    <?php
    $medium = $quoted_media[0];
    isset($medium['poster']) ? $ctf_lightbox_image = $medium['poster'] : $ctf_lightbox_image = $medium['url'];
    isset($post['text']) ? $ctf_alt_text = htmlspecialchars($post['text']) : $ctf_alt_text = 'View on Twitter';
    ?>
    <div class="ctf-quoted-video">
        <?php if ( $disablelightbox && ($medium['type'] != 'video' && $medium['type'] != 'animated_gif') || ! $disablelightbox ) : ?>
            <a href="<?php echo esc_url( $media_link ) ?>" class="<?php echo esc_attr( $media_link_classes ); ?>" <?php echo $linkbox_link_att_string ?> target="_blank" rel="nofollow noopener noreferrer">
        <?php endif; ?>
            <?php echo ctf_get_fa_el( 'ctf_playbtn' ); ?>

            <?php if( $disablelightbox || $medium['type'] == 'animated_gif' ) : ?>
                <video <?php echo esc_attr( $medium['video_atts'] ) ?> src="<?php echo esc_url( $medium['url'] ) ?>" type="video/mp4" poster="<?php echo esc_url( $ctf_lightbox_image ) ?>">
            <?php endif; ?>
                    <img src="<?php echo esc_url( $ctf_lightbox_image ) ?>" alt="<?php echo esc_attr( $ctf_alt_text ) ?>" />
            <?php if( $disablelightbox || $medium['type'] == 'animated_gif' ) : ?>
                </video>
                <span class="ctf-screenreader"><?php esc_html_e( 'Twitter feed video.', 'custom-twitter-feeds' ); ?></span>
            <?php endif;
        if ( $disablelightbox && ($medium['type'] != 'video' && $medium['type'] != 'animated_gif') || ! $disablelightbox ) : ?>
        </a>
        <?php endif; ?>

        <div class="ctf-tc-summary-info">
            <span class="ctf-quoted-author-name"><?php echo esc_html( $quoted_name ) ?></span>

            <?php if ( $quoted_verfied == 1 ) : ?>
                <span class="ctf-quoted-verified"><?php echo ctf_get_fa_el( 'fa-check-circle' ) ?></span>
            <?php endif; ?>

            <span class="ctf-quoted-author-screenname">@<?php echo esc_html( $quoted_screen_name ) ?></span>
            <p class="ctf-quoted-tweet-text"><?php echo nl2br( $quoted_text ) ?></p>
        </div>
    </div>
</div>
<?php else : ?>
<a href="<?php echo esc_url( 'https://twitter.com/' . $quoted_screen_name . '/status/' . $quoted['id_str'] ) ?>" class="ctf-quoted-tweet" target="_blank" rel="nofollow noopener noreferrer" <?php echo $linkbox_attr ?>>
    <?php if ( $quoted_media ) : ?>
        <div class="ctf-quoted-media-wrap"<?php echo CTF_Display_Elements_Pro::get_available_images_attribute( $quoted ) ?>>
            <?php
            $quoted_media = array( $quoted_media[0] );
            foreach ( $quoted_media as $medium ) :
                //Define image for lightbox
                isset($medium['poster']) ? $ctf_lightbox_image = $medium['poster'] : $ctf_lightbox_image = $medium['url'];
                isset($post['text']) ? $ctf_alt_text = htmlspecialchars($post['text']) : $ctf_alt_text = 'View on Twitter';
            ?>
                <div class="ctf-tc-image" data-bg="<?php echo esc_url( $ctf_lightbox_image ) ?>"><img src="<?php echo esc_url( $ctf_lightbox_image ) ?>" alt="<?php echo esc_attr( $ctf_alt_text ) ?>"></div>
            <?php endforeach;// end foreach ?>
        </div>

    <?php endif; ?>

    <div class="ctf-tc-summary-info">
        <span class="ctf-quoted-author-name"><?php echo esc_html( $quoted_name ) ?></span>
        <?php if ( $quoted_verfied == 1) : ?>
        <span class="ctf-quoted-verified"><?php echo ctf_get_fa_el( 'fa-check-circle' ) ?></span>
        <?php endif; // user is verified ?>
        <span class="ctf-quoted-author-screenname">@<?php echo esc_html( $quoted_screen_name ) ?></span>
        <p class="ctf-quoted-tweet-text"><?php echo nl2br( $quoted_text ) ?></p>
    </div>
</a>
<?php endif;

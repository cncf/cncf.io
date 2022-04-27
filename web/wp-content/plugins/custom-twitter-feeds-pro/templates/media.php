<?php
/**
 * Smash Balloon Custom Twitter Feeds Media Template
 * Images, videos, and gifs in tweets
 *
 * @version 1.13 Custom Twitter Feeds by Smash Balloon
 *
 */
use TwitterFeed\Pro\CTF_Parse_Pro;
use TwitterFeed\Pro\CTF_Display_Elements_Pro;
use TwitterFeed\CTF_GDPR_Integrations;
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$maxmedia = isset( $feed_options['maxmedia'] ) ? $feed_options['maxmedia'] : 4;

$media_attr = CTF_Display_Elements_Pro::get_element_attribute( 'media', $feed_options );
?>

<div class="<?php echo esc_attr( $media_classes ) ?>" <?php echo CTF_Display_Elements_Pro::get_available_images_attribute( $post ) ?> <?php echo $media_attr; ?>>
<?php
$num_added = 0;
foreach ( $media as $medium ) : ?>
    <?php if ( $num_added < $maxmedia ) : $num_added++;

    $ctf_lightbox_image = CTF_Display_Elements_Pro::lightbox_image( $medium );
    $wrap_classes = CTF_Display_Elements_Pro::media_wrap_classes( $medium, $feed_options );
    $media_link = $disablelightbox ? 'https://twitter.com/' .$post['user']['screen_name'] . '/status/' . $post['id_str'] : $ctf_lightbox_image;
    $media_link_classes = CTF_Display_Elements_Pro::media_link_classes( $medium, $disablelightbox );
    $media_link_att_string = CTF_Display_Elements_Pro::media_link_attributes( $medium, $post, $feed_options, $disablelightbox );
    $media_element_atts = CTF_Display_Elements_Pro::media_element_atts( $medium, $feed_options );
    $img_source = CTF_Display_Elements_Pro::get_media_placeholder( $ctf_lightbox_image, $feed_options );
    $ctf_alt_text = CTF_Display_Elements_Pro::media_alt_text( $post );
    $medium_type = CTF_Parse_Pro::get_medium_type( $medium );
    $medium_video_atts = CTF_Parse_Pro::get_medium_video_atts( $medium );
    $medium_url = CTF_Parse_Pro::get_medium_url( $medium );
    ?>

    <?php if ( $medium_type === 'iframe' ) : ?>
        <div class="ctf-<?php echo esc_attr( $medium_type ); ?>-wrap<?php echo esc_attr( $wrap_classes ); ?>">
    <?php endif; ?>
            <?php if ( $disablelightbox && ( $medium_type != 'video' && $medium_type != 'animated_gif' ) || ! $disablelightbox ) : ?>
            <a href="<?php echo esc_url( $media_link ) ?>" class="<?php echo esc_attr( $media_link_classes ); ?>"<?php echo $media_link_att_string; ?>  target="_blank" rel="nofollow noopener noreferrer">
            <?php endif; ?>
            <?php echo ctf_get_fa_el( 'ctf_playbtn' ); ?>
                <?php if ( ! $disablelightbox ) : ?>
                <div class="ctf-photo-hover"><?php echo ctf_get_fa_el( 'fa-arrows-alt' ) ?></div>
                <?php endif; ?>

                <?php if ( $medium_type == 'video' || $medium_type == 'animated_gif' ) : ?>

                <?php if( $disablelightbox || $medium_type == 'animated_gif' ) : ?>
                <video <?php echo esc_attr( $medium_video_atts ) ?> src="<?php echo esc_url( $medium_url ) ?>" type="video/mp4" poster="<?php echo esc_url( $ctf_lightbox_image ) ?>">
                    <img src="<?php echo esc_url( $img_source ) ?>" alt="<?php echo esc_attr( $ctf_alt_text ) ?>" />
                </video>
                <?php else: ?>
                    <img src="<?php echo esc_url( $img_source ) ?>" alt="<?php echo esc_attr( $ctf_alt_text ) ?>" />
                <?php endif; ?>

                <?php elseif ( $medium_type == 'iframe' ) : ?>
                    <?php if ( CTF_GDPR_Integrations::doing_gdpr( $dbsettings ) ) : ?>
				    <span class="ctf-iframe-placeholder" data-ctf-url="<?php echo esc_url( $medium_url ); ?>"><?php echo esc_html( $medium_url ); ?></span>
			        <?php else : ?>
                    <iframe src="<?php echo esc_url( $medium_url ) ?>" type="text/html" allowfullscreen frameborder="0" title="<?php esc_attr_e( 'Twitter Feed Media', 'custom-twitter-feeds' ); ?>" webkitAllowFullScreen mozallowfullscreen></iframe>
			        <?php endif; ?>
                <?php else : ?>
                    <img src="<?php echo esc_url( $img_source ) ?>" alt="<?php echo esc_attr( $ctf_alt_text ) ?>" <?php echo $media_element_atts; ?> data-full-image="<?php echo esc_url( $medium_url ) ?>">
                <?php endif; ?>

                <?php echo CTF_Display_Elements_Pro::media_screenreader_text( $medium ); ?>
            <?php if ( $disablelightbox && ( $medium_type != 'video' && $medium_type != 'animated_gif' ) || ! $disablelightbox ) : ?>
            </a>
            <?php endif; ?>
            <?php if ( $medium_type === 'iframe' ) : ?>
        </div>
    <?php endif; ?>

    <?php
    endif;

endforeach; ?>
</div>

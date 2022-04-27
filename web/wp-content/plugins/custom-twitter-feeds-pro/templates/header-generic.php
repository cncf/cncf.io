<?php
/**
 * Smash Balloon Custom Twitter Feeds Generic Header Template
 * Information about the hashtag or search
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

$header_text = CTF_Parse_Pro::get_generic_header_text( $feed_options );
$header_url = CTF_Parse_Pro::get_generic_header_url( $feed_options );
$header_attr = CTF_Display_Elements_Pro::get_element_attribute( 'header', $feed_options );
?>

<div class="ctf-header ctf-header-type-generic" <?php echo $header_attr ?>>
    <a href="<?php echo esc_url( 'https://twitter.com/' . $header_url ) ?>" target="_blank" rel="nofollow noopener" class="ctf-header-link">
        <div class="ctf-header-text">
            <p class="ctf-header-no-bio"><?php echo esc_html( $header_text ) ?></p>
        </div>
        <div class="ctf-header-img">
            <div class="ctf-header-generic-icon"><?php echo ctf_get_fa_el( 'fa-twitter' ) ?></div>
        </div>
    </a>
</div>
<?php

/**
 * Contains all functions relating to the use of the legacy wprss_feed_item CPT.
 *
 * @since 2.9.5
 */


/**
 * Returns TRUE if using the legacy imported feed items, FALSE otherwise.
 * If a source ID is given, it returns TRUE if the source is using the wprss_feed_item
 * post type, FALSE for any other.
 *
 * @since 2.9.5
 * @param int|string $source_id The ID of the feed source
 */
function wprss_ftp_using_feed_items( $source_id = NULL ) {
    if ( $source_id === NULL ) {
        return true;
    }

    return WPRSS_FTP_Meta::get_instance()->get( $source_id, 'post_type' ) == 'wprss_feed_item';
}


/**
 * Prints the description for the legacy callback section.
 *
 * @since 2.9.5
 */
function wprss_settings_legacy_callback() {
	echo '<p>' . __('Change how Feed to Post works with WP RSS Aggregator', WPRSS_TEXT_DOMAIN) . '</p>';
}


/**
 * Prints the checkbox settings for enabling the legacy feed item.
 *
 * @since 2.9.5
 */
function wprss_ftp_legacy_enable_option() {
    printf(
        '<p>%s<br/>%s</p>',
        __('This option is now enabled by default.', 'wprss'),
        __('This allows you to import as regular feed items and use the Excerpts &amp; Thumbnails and Categories addons.', 'wprss')
    );
}

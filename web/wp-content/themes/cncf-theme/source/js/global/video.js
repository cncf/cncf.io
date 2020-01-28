/**
 * Video Embeds
 *
 * Wrap all youtube videos so they can be responsive. May not be needed depending on plugins.
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery(
	function( $ ) {
		$(
			'iframe[src*="youtube.com"], iframe[src*="vimeo.com"], iframe[data-src*="youtube.com"], iframe[data-src*="vimeo.com"]'
		).each(
			function() {
				$( this ).wrap( '<div class="video-wrapper"></div>' );
			}
		);
	}
);
// ( 'use strict' );

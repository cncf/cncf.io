<?php
/**
 * Template Name: Tab Container Page
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Adds the menu section to the top of the content of each post.
 *
 * @param string $content Content of the post.
 */
function cncf_content_filter( $content ) {
	// get all div tags of class "wp-block-cgb-block-tab-container-block".
	$tag_regex = '/<[^>]*class="[^"]*\bwp-block-cgb-block-tab-container-block\b[^"]*"[^>]*>/i';
	preg_match_all( $tag_regex, $content, $matches );

	if ( ! $matches[0] ) {
		return $content;
	}

	$menu  = '<nav data-sticky-container>';
	$menu .= '<div class="sticky" data-sticky data-margin-top="8" data-anchor="multi-part-page" data-sticky-on="large">';
	$menu .= '<h6 class="hide-for-large text-small">Skip to page section</h6>';
	$menu .= '<ul id="multi-part-page--magellan" data-magellan data-deep-linking="true" data-update-history="false">';

	// grab the data-menu-title and id from each tag to construct the menu.
	foreach ( $matches[0] as $match ) {
		preg_match( '/data-menu-slug="([^"]*)"/i', $match, $id );
		preg_match( '/data-menu-title="([^"]*)"/i', $match, $menu_title );

		$menu .= '<li><a href="#' . $id[1] . '">' . $menu_title[1] . '</a></li>';
	}

	$menu .= '</ul>';
	$menu .= '</div>';
	$menu .= '</nav>';

	$menu_and_content  = '<div id="multi-part-page">';
	$menu_and_content .= '<div class="multi-part-page--menu">' . $menu . '</div>';
	$menu_and_content .= '<div class="multi-part-page--content">' . $content . '</div>';
	$menu_and_content .= '</div>';

	// add the menu markup to the end of $content.
	return $menu_and_content;
}
add_filter( 'the_content', 'cncf_content_filter' );

// shares the markup with the regular singular.php page template although it pulls in its own template part.
require get_template_directory() . '/singular.php';

?>

<script>
$( document ).ready( function() {
	// if a menu item isn't visible, scroll it into view
	$('#multi-part-page--magellan').on('update.zf.magellan', function (ev, elem) {
		var activeMenuItem = elem[0];
		var isSticky = $('.is-stuck')[0] ? true : false;
		if (activeMenuItem && isSticky) {
			activeMenuItem.scrollIntoView({
				block: "nearest"
			});
		}
	});
});
</script>

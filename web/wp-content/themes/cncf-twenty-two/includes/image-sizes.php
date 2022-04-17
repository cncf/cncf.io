<?php
/**
 * Image sizes
 *
 * Used to create new image sizes used in the site. TRUE uses hard crop to size.
 *
 * @category Components
 * @package  WordPress
 * @author   James Hunt
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://cncf.io
 * @since    1.0.0
 */

// Newsroom, mobile, featured, retina.
add_image_size( 'newsroom-200', 200, 110, true ); // for megamenu items.
add_image_size( 'newsroom-400', 400, 220, true ); // regular blog item and tech radar items; megamenu item Retina.
add_image_size( 'newsroom-700', 700, 385, true ); // featured blog item; regular blog item Retina.
add_image_size( 'newsroom-1400', 1400, 770, true ); // featured blog item Retina.

add_image_size( 'newsroom-post-width', 900 ); // for in-post images.
add_image_size( 'newsroom-post-width-r', 1800 ); // for in-post images Retina.
add_image_size( 'newsroom-media-coverage', 600, 200, false ); // for media coverage logos (which often go wide on tablets).
add_image_size( 'newsroom-media-coverage-r', 1200, 400, false ); // for media coverage logos (which often go wide on tablets).

// case study.
add_image_size( 'case-study-590', 590, 310, true ); // for homepage tile background.
add_image_size( 'case-study-1180', 1180, 620, true ); // for homepage tile background Retina.
add_image_size( 'case-study-600', 600, 480, true ); // for case study listing tile background (we don't need Retina since it's blurred by overlay anyway).

// event.
add_image_size( 'event-380', 380, 260, true ); // event tile background.
add_image_size( 'event-760', 760, 520, true ); // event tile background Retina.

/**
 * Add custom image sizes to media select.
 *
 * @param array $sizes Current image sizes.
 */
function lf_custom_image_editor_sizes( $sizes ) {
	$sizes = array_merge(
		$sizes,
		array(
			'newsroom-post-width' => __( 'Full Blog Width' ),
		)
	);
	return $sizes;
}
add_filter( 'image_size_names_choose', 'lf_custom_image_editor_sizes' );

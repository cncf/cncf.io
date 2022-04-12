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

// Media images, no hard crop.
add_image_size( 'newsroom-media-coverage', 325, 200, false );

// Newsroom, mobile, featured, retina.
add_image_size( 'newsroom-260', 261, 137, true );
add_image_size( 'newsroom-325', 325, 171, true );
add_image_size( 'newsroom-540', 540, 285, true );
add_image_size( 'newsroom-600', 600, 315, true );
add_image_size( 'newsroom-1200', 1200, 630, true );
add_image_size( 'newsroom-post-width', 900, 9999, false );

// case study.
add_image_size( 'case-study-320', 320, 260, true );
add_image_size( 'case-study-640', 640, 520, true );

// event.
add_image_size( 'event-317', 317, 272, true );
add_image_size( 'event-415', 415, 356, true );
add_image_size( 'event-634', 634, 544, true );

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

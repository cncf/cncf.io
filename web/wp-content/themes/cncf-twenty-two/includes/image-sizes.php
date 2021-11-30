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
add_image_size( 'newsroom-post-width', 700, 9999, false );

// spotlight.
add_image_size( 'spotlight-320', 320, 170, false );
add_image_size( 'spotlight-515', 515, 270, false );
add_image_size( 'spotlight-640', 640, 340, false );
add_image_size( 'spotlight-1280', 1280, 680, false );

// case study.
add_image_size( 'case-study-320', 320, 260, true );
add_image_size( 'case-study-640', 640, 520, true );

// event.
add_image_size( 'event-317', 317, 272, true );
add_image_size( 'event-415', 415, 356, true );
add_image_size( 'event-634', 634, 544, true );

// Hero image (Posts and Pages).
add_image_size( 'hero-2880', 2880, 520, true );
add_image_size( 'hero-1920', 1920, 260, true );
add_image_size( 'hero-1440', 1440, 260, true );
add_image_size( 'hero-1200', 1200, 220, true );
add_image_size( 'hero-1024', 1024, 220, true );
add_image_size( 'hero-768', 768, 220, true );
add_image_size( 'hero-600', 600, 220, true );
add_image_size( 'hero-414', 414, 220, true );
add_image_size( 'hero-375', 375, 220, true );
add_image_size( 'hero-320', 320, 220, true );

// Image Hero Block.
add_image_size( 'ihero-1400', 1400, 400, true );
add_image_size( 'ihero-2048', 2048, 585, true );
add_image_size( 'ihero-415', 415, 119, true );
add_image_size( 'ihero-830', 830, 237, true );

// people.
add_image_size( 'people-250', 250, 250, true );
add_image_size( 'people-500', 500, 500, true );

/**
 * Add custom image sizes to media select.
 *
 * @param array $sizes Current image sizes.
 */
function lf_custom_image_editor_sizes( $sizes ) {
	$sizes = array_merge(
		$sizes,
		array(
			'newsroom-post-width' => __( 'Blog Width' ),
			'hero-768' => __( 'Widescreen Strip' ),
		)
	);
	return $sizes;
}
add_filter( 'image_size_names_choose', 'lf_custom_image_editor_sizes' );

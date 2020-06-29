<?php
/**
 * Image sizes
 *
 * Used to create new image sizes used in the site. TRUE uses hard crop to size.
 *
 * @category Components
 * @package  WordPress
 * @author   James Hunt <domains@thetwopercent.co.uk>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://cncf.io
 * @since    1.0.0
 */

// add_image_size('icon', 50, 50, true); // phpcs:ignore.
// add_image_size('new-size', 215, 215, true); // phpcs:ignore.

// Press images, no hard crop.
add_image_size( 'newsroom-media-coverage', 260, 160, false );

// Newsroom, mobile, featured, retina.
add_image_size( 'newsroom-260', 260, 180, true );
add_image_size( 'newsroom-300', 300, 200, true );
add_image_size( 'newsroom-600', 600, 320, true );
add_image_size( 'newsroom-1200', 1200, 640, true );

// additional sections.
add_image_size( 'spotlight', 320, 170, false );
add_image_size( 'case-study', 320, 260, true );

// Hero image.
add_image_size( 'hero-2560', 2880, 520, true );
add_image_size( 'hero-1920', 1920, 260, true );
add_image_size( 'hero-1440', 1440, 260, true );
add_image_size( 'hero-1200', 1200, 220, true );
add_image_size( 'hero-1024', 1024, 220, true );
add_image_size( 'hero-768', 768, 220, true );
add_image_size( 'hero-600', 600, 220, true );
add_image_size( 'hero-414', 414, 220, true );
add_image_size( 'hero-375', 375, 220, true );
add_image_size( 'hero-320', 320, 220, true );

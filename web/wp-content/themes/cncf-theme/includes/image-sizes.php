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

add_image_size( 'people', 100, 100, true );
add_image_size( 'newsroom-image-large', 1040, 640, true );
add_image_size( 'newsroom-image', 520, 320, true );
add_image_size( 'newsroom-image-small', 260, 160, true );
add_image_size( 'newsroom-media-coverage', 260, 160, false );

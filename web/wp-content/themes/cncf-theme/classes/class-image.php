<?php
/**
 * Class Image
 *
 * This class manages all of the image helpers for use in Theme development.
 * Use - $image = new Image();
 * then - $image->get_base64( 'logo.png' )
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

 /**
  * Image class
  *
  * Helps insert various theme image files.
  *
  * @since 1.0.0
  */
class Image {

	/**
	 * Convert image to Base64
	 *
	 * Grabs an image from within the theme /images/ folder and converts it to base64. Recommend to only use on small images that are not possible to be SVGs as otherwise page size will become too big.
	 *
	 * @since 1.0.0
	 *
	 * @see class/Image
	 *
	 * @param string $file Filename relative to images directory.
	 * @return string.
	 */
	public function get_base64( $file ) {
		$output        = '';
		$file_location = get_stylesheet_directory_uri() . '/images/' . $file;
		$output        = $this->base_64( $file_location );
		return $output;
	}

	/**
	 * Grab SVG from images
	 *
	 * Grabs an SVG from within the theme /images/ folder and outputs it. Add true for path.
	 *
	 * @since 1.0.0
	 *
	 * @see class/Image
	 *
	 * @param string  $file Filename relative to images directory.
	 * @param boolean $path Set true to return string for image.
	 */
	public function get_svg( $file, $path = false ) {

		if ( $path ) {
			$output = get_stylesheet_directory_uri() . '/images/' . $file;
			echo esc_url( $output );
		} else {
			$abs_path = get_stylesheet_directory() . '/images/' . $file;
			if ( file_exists( $abs_path ) ) {
				ob_start();
				include $abs_path;
				$output = ob_get_contents();
				ob_end_clean();
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}

	/**
	 * Grab image from theme
	 *
	 * Grabs an image from the specified URL, this is mainly used for images from the media library that are not base64 or SVGs.
	 *
	 * @since 1.0.0
	 *
	 * @see class/Image
	 *
	 * @param string $file Filename relative to images directory.
	 */
	public function get_image( $file ) {
		$output = '';
		$output = get_stylesheet_directory_uri() . '/images/' . $file;
		echo esc_url( $output );
	}

	/**
	 * Convert to base64
	 *
	 * Converts the image source into a base64 encoded string for use in the above functions
	 *
	 * @since 1.0.0
	 *
	 * @see class/Image
	 *
	 * @param string $file Filename relative to images directory.
	 * @return string
	 */
	private function base_64( $file ) {
		$img_ext  = pathinfo( $file, PATHINFO_EXTENSION );
		$img_url  = get_site_url( null, $file );
		$img_data = file_get_contents( $img_url );
		return 'data:image/' . $img_ext . ';base64,' . base64_encode( $img_data );

	}

}

<?php

/**
 * Class Image
 *
 * This class manages all of the image helpers for use in Theme development.
 *  Use - $image = new Image();
 *  then - $image->get_base64( 'logo.png' )
 */

class Image {

	/**
	 * Grabs an image from within the theme /images/ folder and convert it to base 64. Recommend to only use on small images that are not possible to be SVGs.
	 *
	 * @param $file
	 *
	 * @return string
	 */
	public function get_base64( $file ) {
		$output = '';

		$output = $this->base_64( get_stylesheet_directory_uri() . '/images/' . $file );

		echo $output;
	}

	/**
	 * Grabs an SVG from within the theme /images/ folder and outputs it. Add true for path.
	 *
	 * @param $file
	 * @param boolean set true to return string for image
	 *
	 * @return string
	 */
	public function get_svg( $file, $path = false ) {

		if ( $path ) {
			$output = get_stylesheet_directory_uri() . '/images/' . $file;
			echo $output;
		} else {
			$abs_path = get_stylesheet_directory() . '/images/' . $file;
			ob_start();
			include $abs_path;
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;
		}
	}


	/**
	 * Grab an image from the specified URL, this is mainly used for images from the media library that are not base64 or SVGs
	 *
	 * @param $file
	 *
	 * @return string
	 */
	public function get_image( $file ) {
		$output = '';
		$output = get_stylesheet_directory_uri() . '/images/' . $file;
		echo $output;
	}

	/**
	 * Converts the image source into a base64 encoded string for use in the above functions
	 *
	 * @param $file
	 *
	 * @return string
	 */
	private function base_64( $file ) {
		$type = pathinfo( $file, PATHINFO_EXTENSION );
		$data = file_get_contents( $file );
		return 'data:image/' . $type . ';base64,' . base64_encode( $data );
	}

}

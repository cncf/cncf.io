<?php
/*
*
* ACF Options Page
*/

/**
 *
 * ACF Responsive Images srcset
 *
 * https://gist.github.com/ControlledChaos/d5dafb5d35a78f6653fc03934b30ee9a
 */
function get_responsive_images( $image_id, $image_size, $max_width ) {
	// Check if the image ID is not blank
	if ( $image_id !== '' ) {
		// Set the default src image size
		$image_src = wp_get_attachment_image_url( $image_id, $image_size );
		// Set the srcset with various image sizes
		$image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );
		// Generate the markup for the responsive image
		echo 'src="' . $image_src . '" srcset="' . $image_srcset . '" sizes="(max-width: ' . $max_width . ') 100vw, ' . $max_width . '"';
	}
}


add_action( 'acf/init', 'custom_options_page' );

function custom_options_page() {

	if ( function_exists( 'acf_add_options_page' ) ) {

		acf_add_options_page(
			array(
				'page_title' => 'Content Settings',
				'menu_title' => 'Content Settings',
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'icon_url'   => 'dashicons-images-alt2',
				'position'   => 4,
			)
		);

		acf_add_options_sub_page(
			array(
				'page_title'  => 'Global',
				'menu_title'  => 'Global',
				'parent_slug' => 'theme-general-settings',
			)
		);

		acf_add_options_sub_page(
			array(
				'page_title'  => 'Repeat Images',
				'menu_title'  => 'Repeat Images',
				'parent_slug' => 'theme-general-settings',
			)
		);

		acf_add_options_sub_page(
			array(
				'page_title'  => 'Mailchimp',
				'menu_title'  => 'Mailchimp',
				'parent_slug' => 'theme-general-settings',
			)
		);
	}
}

/*
*
* ACF Adding to admin
*/

/*
*
* Add columns to testimonials
*/
function add_acf_columns_testimonials( $columns ) {
	return array_merge(
		$columns,
		array(
			'display_title'     => __( 'Display Title' ),
			'testimonial_text'  => __( 'Text' ),
			'testimonial_image' => __( 'Image' ),
		)
	);
}
add_filter( 'manage_testimonials_posts_columns', 'add_acf_columns_testimonials' );

/*
*
* Add columns to testimonials
*/
function testimonials_custom_column( $column, $post_id ) {
	switch ( $column ) {
		case 'display_title':
			if ( get_post_meta( $post_id, 'display_title', true ) ) {
				echo 'Yes';}
			break;
		case 'testimonial_text':
			echo get_post_meta( $post_id, 'testimonial_text', true );
			break;
		case 'testimonial_image':
			$pic_id = get_post_meta( $post_id, 'testimonial_image', true );
			$size   = 'icon';
			$image  = wp_get_attachment_image_src( $pic_id, $size );
			echo '<img src="' . $image[0] . '">';
			break;
	}
}
add_action( 'manage_testimonials_posts_custom_column', 'testimonials_custom_column', 10, 3 );


/*
*
* Add columns to tyres
*/
function add_acf_columns_tyres( $columns ) {
	return array_merge(
		$columns,
		array(
			'tyre_image_angle'        => __( 'Tyre Angle' ),
			'tyre_image_tread'        => __( 'Tyre Side' ),
			'tyre_image_tread_detail' => __( 'Tyre Tread Detail' ),
		)
	);
}
add_filter( 'manage_tyres_posts_columns', 'add_acf_columns_tyres' );

/*
*
* Add columns to tyres
*/
function tyres_custom_column( $column, $post_id ) {
	switch ( $column ) {
		case 'tyre_image_angle':
			$pic_id = get_post_meta( $post_id, 'tyre_image_angle', true );
			$size   = 'thumb40';
			$image  = wp_get_attachment_image_src( $pic_id, $size );
			echo '<img src="' . $image[0] . '">';
			break;
		case 'tyre_image_tread':
			$pic_id = get_post_meta( $post_id, 'tyre_image_tread', true );
			$size   = 'thumb40';
			$image  = wp_get_attachment_image_src( $pic_id, $size );
			echo '<img src="' . $image[0] . '">';
			break;
		case 'tyre_image_tread_detail':
			$pic_id = get_post_meta( $post_id, 'tyre_image_tread_detail', true );
			$size   = 'thumb40';
			$image  = wp_get_attachment_image_src( $pic_id, $size );
			echo '<img src="' . $image[0] . '">';
			break;
	}
}
add_action( 'manage_tyres_posts_custom_column', 'tyres_custom_column', 10, 3 );

<?php
/**
 * Comment.
 *
 * @package Comment.
 */

if ( ! function_exists( 'foundationpress_gutenberg_support' ) ) :
	/**
	 * Comment.
	 */
	function foundationpress_gutenberg_support() {

		// Add foundation color palette to the editor.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Black', 'foundationpress' ),
					'slug'  => 'black',
					'color' => '#212326',
				),
				array(
					'name'  => __( 'Charcoal', 'foundationpress' ),
					'slug'  => 'charcoal',
					'color' => '#393c41',
				),
				array(
					'name'  => __( 'Dark Gray', 'foundationpress' ),
					'slug'  => 'dark-gray',
					'color' => '#5d626a',
				),
				array(
					'name'  => __( 'Light Gray', 'foundationpress' ),
					'slug'  => 'light-gray',
					'color' => '#d3d5d9',
				),
				array(
					'name'  => __( 'Off White', 'foundationpress' ),
					'slug'  => 'off-white',
					'color' => '#ecedee',
				),
				array(
					'name'  => __( 'White', 'foundationpress' ),
					'slug'  => 'white',
					'color' => '#fefefe',
				),
				array(
					'name'  => __( 'Dark Fuschia', 'foundationpress' ),
					'slug'  => 'dark-fuschia',
					'color' => '#6e1042',
				),
				array(
					'name'  => __( 'Dark Violet', 'foundationpress' ),
					'slug'  => 'dark-violet',
					'color' => '#411E4F',
				),
				array(
					'name'  => __( 'Dark Indigo', 'foundationpress' ),
					'slug'  => 'dark-indigo',
					'color' => '#1A267D',
				),
				array(
					'name'  => __( 'Dark Blue', 'foundationpress' ),
					'slug'  => 'dark-blue',
					'color' => '#17405c',
				),
				array(
					'name'  => __( 'Dark Aqua', 'foundationpress' ),
					'slug'  => 'dark-aqua',
					'color' => '#0e5953',
				),
				array(
					'name'  => __( 'Dark Green', 'foundationpress' ),
					'slug'  => 'dark-green',
					'color' => '#0b5329',
				),
				array(
					'name'  => __( 'Light Fuschia', 'foundationpress' ),
					'slug'  => 'light-fuschia',
					'color' => '#AD1457',
				),
				array(
					'name'  => __( 'Light Violet', 'foundationpress' ),
					'slug'  => 'light-violet',
					'color' => '#6C3483',
				),
				array(
					'name'  => __( 'Light Indigo', 'foundationpress' ),
					'slug'  => 'light-indigo',
					'color' => '#4653B0',
				),
				array(
					'name'  => __( 'Light Blue', 'foundationpress' ),
					'slug'  => 'light-blue',
					'color' => '#2874A6',
				),
				array(
					'name'  => __( 'Light Aqua', 'foundationpress' ),
					'slug'  => 'light-aqua',
					'color' => '#148f85',
				),
				array(
					'name'  => __( 'Light Green', 'foundationpress' ),
					'slug'  => 'light-green',
					'color' => '#117a3d',
				),
				array(
					'name'  => __( 'Dark Chartreuse', 'foundationpress' ),
					'slug'  => 'dark-chartreuse',
					'color' => '#3d5e0f',
				),
				array(
					'name'  => __( 'Dark Yellow', 'foundationpress' ),
					'slug'  => 'dark-yellow',
					'color' => '#878700',
				),
				array(
					'name'  => __( 'Dark Gold', 'foundationpress' ),
					'slug'  => 'dark-gold',
					'color' => '#8c7000',
				),
				array(
					'name'  => __( 'Dark Orange', 'foundationpress' ),
					'slug'  => 'dark-orange',
					'color' => '#784e12',
				),
				array(
					'name'  => __( 'Dark Umber', 'foundationpress' ),
					'slug'  => 'dark-umber',
					'color' => '#6E2C00',
				),
				array(
					'name'  => __( 'Dark Red', 'foundationpress' ),
					'slug'  => 'dark-red',
					'color' => '#641E16',
				),
				array(
					'name'  => __( 'Light Chartreuse', 'foundationpress' ),
					'slug'  => 'light-chartreuse',
					'color' => '#699b23',
				),
				array(
					'name'  => __( 'Light Yellow', 'foundationpress' ),
					'slug'  => 'light-yellow',
					'color' => '#b0b000',
				),
				array(
					'name'  => __( 'Light Gold', 'foundationpress' ),
					'slug'  => 'light-gold',
					'color' => '#c29b00',
				),
				array(
					'name'  => __( 'Light Orange', 'foundationpress' ),
					'slug'  => 'light-orange',
					'color' => '#c2770e',
				),
				array(
					'name'  => __( 'Light Umber', 'foundationpress' ),
					'slug'  => 'light-umber',
					'color' => '#b8510d',
				),
				array(
					'name'  => __( 'Light Red', 'foundationpress' ),
					'slug'  => 'light-red',
					'color' => '#922B21',
				),
			)
		);

	}

	add_action( 'after_setup_theme', 'foundationpress_gutenberg_support' );
endif;

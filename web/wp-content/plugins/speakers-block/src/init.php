<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function speakers_block_cgb_block_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	// wp_register_style(
	// 	'speakers_block-cgb-style-css', // Handle.
	// 	plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
	// 	array( 'wp-editor' ), // Dependency to include the CSS after it.
	// 	null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	// );

	// Register block editor script for backend.
	wp_register_script(
		'speakers_block-cgb-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'speakers_block-cgb-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'cgb/block-speakers-block', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			// 'style'         => 'speakers_block-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'speakers_block-cgb-block-js',
			// // Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'speakers_block-cgb-block-editor-css',
			'render_callback' => 'speakers_block_callback',
		)
	);
}

// Hook: Block assets.
add_action( 'init', 'speakers_block_cgb_block_assets' );

/**
 * Callback for speakers block.
 *
 * @param array  $attributes Atts.
 * @param string $content Content.
 */
function speakers_block_callback( $attributes, $content ) {
	global $post;

	$speakers_to_show = explode( ',', $attributes['speakers'] );
	if ( ! $speakers_to_show ) {
		return '';
	}

	$bg_color_1 = $attributes['color1'];
	$bg_color_2 = $attributes['color2'];
	if ( 'white' == $attributes['text_color'] ) {
		$text_color = 'rgb(255,255,255)';
		$gradient_color = 'rgba(255,255,255,0.15)';
	} else {
		$text_color = 'rgb(33,35,38)';
		$gradient_color = 'rgba(33,35,38,0.15)';
	}

	$out = '<section class="speakers-section alignfull" style="background: linear-gradient(90deg, ' . $bg_color_1 . ' 0%, ' . $bg_color_2 . ' 100%); color: ' . $text_color . ';"><ul class="speaker-list grid-x">';

	foreach ( $speakers_to_show as $speaker ) {
		$the_query = new WP_Query(
			array(
				'no_found_rows' => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'post_type' => 'lfe_speaker',
				'name' => str_replace( ' ', '-', strtolower( trim( $speaker ) ) ),
			)
		);
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$out .= '<li id="speaker-' . get_the_id() . '" class="speaker cell small-6 medium-4 xxlarge-3" data-toggler=".open" style="background: linear-gradient(-45deg, transparent 30%, ' . $gradient_color . ' 100%);">';
				$out .= '	<div class="grid-x">';
				$out .= '		<div class="cell large-5">';
				$out .= '			<div class="headshot" style="background-image:url(' . get_the_post_thumbnail_url() . ');" data-toggle="speaker-' . get_the_id() . '">';
				$out .= '			</div>';
				$out .= '		</div>';
				$out .= '		<div class="text cell large-7">';
				$out .= '			<a class="name" data-toggle="speaker-' . get_the_id() . '">' . get_the_title() . '</a>';
				$out .= '			<a class="title" data-toggle="speaker-' . get_the_id() . '">' . get_post_meta( $post->ID, 'lfes_speaker_title', true ) . '</a>';
				$out .= '			<div class="bio">';
				$out .= '				<p>' . get_the_content() . '</p>';
				$out .= '			</div>';
				$linkedin = get_post_meta( $post->ID, 'lfes_speaker_linkedin', true );
				$twitter = get_post_meta( $post->ID, 'lfes_speaker_twitter', true );
				$website = get_post_meta( $post->ID, 'lfes_speaker_website', true );
				$out .= '			<ul class="social-media-links">';
				if ( $twitter ) {
					$out .= '				<li><a href="' . $twitter . '"><svg class="social-icon--twitter" style="fill:' . $text_color . ';" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg></a></li>';
				}
				if ( $linkedin ) {
					$out .= '				<li><a href="' . $linkedin . '"><svg class="social-icon--linkedin" style="fill:' . $text_color . ';" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg></a></li>';
				}
				if ( $website ) {
					$out .= '				<li><a href="' . $website . '"><svg class="social-icon--website" style="fill:' . $text_color . ';" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M448 80v352c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48V80c0-26.51 21.49-48 48-48h352c26.51 0 48 21.49 48 48zm-88 16H248.029c-21.313 0-32.08 25.861-16.971 40.971l31.984 31.987L67.515 364.485c-4.686 4.686-4.686 12.284 0 16.971l31.029 31.029c4.687 4.686 12.285 4.686 16.971 0l195.526-195.526 31.988 31.991C358.058 263.977 384 253.425 384 231.979V120c0-13.255-10.745-24-24-24z"/></svg></a></li>';
				}
				$out .= '			</ul>';
				$out .= '		</div>';
				$out .= '	</div>';
				$out .= '</li>';
			}
		}
	}

	$out .= '</ul></section>';

	/* Restore original Post Data */
	wp_reset_postdata();

	return $out;
}

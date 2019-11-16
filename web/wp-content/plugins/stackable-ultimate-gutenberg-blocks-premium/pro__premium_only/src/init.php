<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'stackable_premium_block_assets' ) ) {

	/**
	* Enqueue block assets for both frontend + backend.
	*
	* @since 0.1
	*/
	function stackable_premium_block_assets() {

		wp_enqueue_style(
			'ugb-style-css-premium',
			plugins_url( 'dist/frontend_blocks__premium_only.css', STACKABLE_FILE ),
			array( 'ugb-style-css' ),
			STACKABLE_VERSION
		);

		if ( ! is_admin() ) {
			wp_enqueue_script(
				'ugb-block-frontend-js-premium',
				plugins_url( 'dist/frontend_blocks__premium_only.js', STACKABLE_FILE ),
				array( 'ugb-block-frontend-js' ),
				STACKABLE_VERSION
			);
		}
	}
	add_action( 'enqueue_block_assets', 'stackable_premium_block_assets' );
}

if ( ! function_exists( 'stackable_premium_block_editor_assets' ) ) {

	/**
	 * Enqueue block assets for backend editor.
	 *
	 * @since 0.1
	 */
	function stackable_premium_block_editor_assets() {

		// Enqueue CodeMirror for Custom CSS.
		wp_enqueue_code_editor( array(
			'type' => 'text/css', // @see https://developer.wordpress.org/reference/functions/wp_get_code_editor_settings/
			'codemirror' => array(
				'indentUnit' => 2,
				'tabSize' => 2,
			),
		) );

		wp_enqueue_script(
			'ugb-block-js-premium',
			plugins_url( 'dist/editor_blocks__premium_only.js', STACKABLE_FILE ),
			array( 'ugb-block-js', 'code-editor' ),
			STACKABLE_VERSION
		);

		// Add translations.
		wp_set_script_translations( 'ugb-block-js-premium', STACKABLE_I18N );

		wp_enqueue_style(
			'ugb-block-editor-css-premium',
			plugins_url( 'dist/editor_blocks__premium_only.css', STACKABLE_FILE ),
			array( 'ugb-block-editor-css' ),
			STACKABLE_VERSION
		);
	}
	add_action( 'enqueue_block_editor_assets', 'stackable_premium_block_editor_assets' );
}

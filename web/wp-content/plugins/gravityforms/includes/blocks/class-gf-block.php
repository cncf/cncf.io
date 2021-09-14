<?php

// If Gravity Forms Block Manager is not available, do not run.
if ( ! class_exists( 'GF_Blocks' ) || ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base Gravity Forms Block class.
 *
 * @since 2.4.10
 *
 * Class GF_Block
 */
class GF_Block {

	/**
	 * Contains an instance of this block, if available.
	 *
	 * @since  2.4.10
	 * @var    GF_Block $_instance If available, contains an instance of this block.
	 */
	private static $_instance = null;

	/**
	 * Block type.
	 *
	 * @since 2.4.10
	 * @var   string
	 */
	public $type = '';

	/**
	 * Handle of primary block editor script.
	 *
	 * @since 2.4.10
	 * @var   string
	 */
	public $script_handle = '';

	/**
	 * Handle of primary block editor style.
	 *
	 * @since 2.5.6
	 * @var   string
	 */
	public $style_handle = '';

	/**
	 * Handle of primary block FE script.
	 *
	 * @since 2.4.10
	 * @var   string
	 */
	public $fe_script_handle = '';

	/**
	 * Handle of primary block FE style.
	 *
	 * @since 2.5.6
	 * @var   string
	 */
	public $fe_style_handle = '';

	/**
	 * Block attributes.
	 *
	 * @since 2.4.10
	 * @var   array
	 */
	public $attributes = array();

	/**
	 * Register block type.
	 * Enqueue editor assets.
	 *
	 * @since  2.4.10
	 *
	 * @uses   GF_Block::register_block_type()
	 */
	public function init() {

		$this->register_block_type();

		$this->register_block_assets();

		add_action( 'gform_post_enqueue_scripts', array( $this, 'post_enqueue_scripts' ), 10, 3 );

	}





	// # BLOCK REGISTRATION --------------------------------------------------------------------------------------------

	/**
	 * Get block type.
	 *
	 * @since  2.4.10
	 *
	 * @return string
	 */
	public function get_type() {

		return $this->type;

	}

	/**
	 * Register block with WordPress.
	 *
	 * @since  2.4.10
	 */
	public function register_block_type() {
		register_block_type( $this->get_type(), $this->get_block_properties() );
	}

	/**
	 * Get an array representing the properties for this block. Can be overriden by inheriting
	 * classes in order to provide more/fewer/different properties.
	 *
	 * @since 2.5.6
	 *
	 * @return array
	 */
	protected function get_block_properties() {
		return array(
			'render_callback' => array( $this, 'render_block' ),
			'editor_script'   => $this->script_handle,
			'editor_style'    => $this->style_handle,
			'attributes'      => $this->attributes,
			'script'          => $this->fe_script_handle,
			'style'           => $this->fe_style_handle,
		);
	}

	/**
	 * Enqueue/register the block's assets upon init
	 *
	 * @since 2.5.6
	 *
	 * @return void
	 */
	public function register_block_assets() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'register_scripts' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'register_styles' ) );
	}

	/**
	 * Checks allowed blocks for Gravity forms blocks to only enqueue block editor assets when necessary.
	 *
	 * @since  2.4.18
	 *
	 * @deprecated since 2.5.6. See GF_Block::register_block_assets()
	 *
	 * @param bool|array $allowed_block_types Array of block type slugs, or boolean to enable/disable all.
	 *
	 * @return bool|array
	 */
	public function check_allowed_blocks( $allowed_block_types ) {

		// Only enqueue block editor assets if all blocks are allowed or if the current block type is an allowed block.
		if ( $allowed_block_types === true || ( is_array( $allowed_block_types ) && in_array( $this->get_type(), $allowed_block_types ) ) ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'register_scripts' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'register_styles' ) );
		}

		return $allowed_block_types;
	}




	// # SCRIPT ENQUEUEING ---------------------------------------------------------------------------------------------

	/**
	 * Enqueue block scripts.
	 *
	 * @since  2.4.10
	 *
	 * @uses   GF_Block::scripts()
	 */
	public function register_scripts() {

		// Get registered scripts.
		$scripts = $this->scripts();

		// If no scripts are registered, return.
		if ( empty( $scripts ) ) {
			return;
		}

		// Loop through scripts.
		foreach ( $scripts as $script ) {

			// Prepare parameters.
			$src       = isset( $script['src'] ) ? $script['src'] : false;
			$deps      = isset( $script['deps'] ) ? $script['deps'] : array();
			$version   = isset( $script['version'] ) ? $script['version'] : false;
			$in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;

			// Enqueue script.
			if ( $this->script_handle === $script['handle'] ) {
				// Support for the editor_style property, if a style_handle is defined. No need to enqueue.
				wp_register_script( $script['handle'], $src, $deps, $version, $in_footer );
			} else {
				// style_handle isn't defined, or this is an additional style. Enqueue it manually.
				wp_enqueue_script( $script['handle'], $src, $deps, $version, $in_footer );
			}

			// Localize script.
			if ( rgar( $script, 'strings' ) ) {
				wp_localize_script( $script['handle'], $script['handle'] . '_strings', $script['strings'] );
			}

			// Run script callback.
			if ( rgar( $script, 'callback' ) && is_callable( $script['callback'] ) ) {
				call_user_func( $script['callback'], $script );
			}
		}

	}

	/**
	 * Enqueue scripts
	 *
	 * @depecated since 2.5.6. Use ::register_scripts() instead.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		$this->register_scripts();
	}

	/**
	 * Override this function to provide a list of scripts to be enqueued.
	 * Following is an example of the array that is expected to be returned by this function:
	 * <pre>
	 * <code>
	 *
	 *    array(
	 *        array(
	 *            'handle'   => 'super_signature_script',
	 *            'src'      => $this->get_base_url() . '/super_signature/ss.js',
	 *            'version'  => $this->_version,
	 *            'deps'     => array( 'jquery'),
	 *            'callback' => array( $this, 'localize_scripts' ),
	 *            'strings'  => array(
	 *                // Accessible in JavaScript using the global variable "[script handle]_strings"
	 *                'stringKey1' => __( 'The string', 'gravityforms' ),
	 *                'stringKey2' => __( 'Another string.', 'gravityforms' )
	 *            )
	 *        )
	 *    );
	 *
	 * </code>
	 * </pre>
	 *
	 * @since  2.4.10
	 *
	 * @return array
	 */
	public function scripts() {

		return array();

	}





	// # STYLE ENQUEUEING ----------------------------------------------------------------------------------------------

	/**
	 * Enqueue block styles.
	 *
	 * @since  2.4.10
	 */
	public function register_styles() {

		// Get registered styles.
		$styles = $this->styles();

		// If no styles are registered, return.
		if ( empty( $styles ) ) {
			return;
		}

		// Loop through styles.
		foreach ( $styles as $style ) {

			// Prepare parameters.
			$src     = isset( $style['src'] ) ? $style['src'] : false;
			$deps    = isset( $style['deps'] ) ? $style['deps'] : array();
			$version = isset( $style['version'] ) ? $style['version'] : false;
			$media   = isset( $style['media'] ) ? $style['media'] : 'all';

			if ( $this->style_handle === $style['handle'] ) {
				// Support for the editor_style property, if a style_handle is defined. No need to enqueue.
				wp_register_style( $style['handle'], $src, $deps, $version, $media );
			} else {
				// style_handle isn't defined, or this is an additional style. Enqueue it manually.
				wp_enqueue_style( $style['handle'], $src, $deps, $version, $media );
			}
		}

	}

	/**
	 * Enqueue styles
	 *
	 * @depecated since 2.5.6. Use ::register_styles() instead.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		$this->register_styles();
	}

	/**
	 * Override this function to provide a list of styles to be enqueued.
	 * See scripts() for an example of the format expected to be returned.
	 *
	 * @since  2.4.10
	 *
	 * @return array
	 */
	public function styles() {

		return array();

	}





	// # BLOCK RENDER -------------------------------------------------------------------------------------------------

	/**
	 * Display block contents on frontend.
	 *
	 * @since  2.4.10
	 *
	 * @param array $attributes Block attributes.
	 *
	 * @return string
	 */
	public function render_block( $attributes = array() ) {

		return '';

	}

	/**
	 * Override to perform additional actions when scripts/styles are enqueued on the wp_enqueue_scripts hook.
	 *
	 * @since 2.4.18
	 *
	 * @param array   $found_forms  An array of found forms using the form ID as the key to the ajax status.
	 * @param array   $found_blocks An array of found GF blocks.
	 * @param WP_Post $post         The post which was processed.
	 */
	public function post_enqueue_scripts( $found_forms, $found_blocks, $post ) {
	}

}

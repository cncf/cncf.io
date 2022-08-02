<?php
/**
 * SBI Tooltip Wizard
 *
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder;

class CTF_Tooltip_Wizard {

	/**
	 * Constructor.
	 *
	 * @since 2.0
	 */
	function __construct(){
		$this->init();
	}


	/**
	 * Initialize class.
	 *
	 * @since 2.0
	 */
	public function init() {
		/*
		if (
			! wpforms_is_admin_page( 'builder' ) &&
			! wp_doing_ajax() &&
			! $this->is_form_embed_page()
		) {
			return;
		}
		*/

		$this->hooks();
	}

	/**
	 * Register hooks.
	 *
	 * @since 2.0
	 */
	public function hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueues' ] );
		add_action( 'admin_footer', [ $this, 'output' ] );
	}


	/**
	 * Enqueue assets.
	 *
	 * @since 2.0
	 */
	public function enqueues() {

		wp_enqueue_style(
			'ctf_tooltipster',
			CTF_PLUGIN_URL . 'admin/builder/assets/css/tooltipster.css',
			null,
			CTF_VERSION
		);

		wp_enqueue_script(
			'ctf_tooltipster',
			CTF_PLUGIN_URL . 'admin/builder/assets/js/jquery.tooltipster.min.js',
			[ 'jquery' ],
			CTF_VERSION,
			true
		);

		wp_enqueue_script(
			'ctf-admin-tooltip-wizard',
			CTF_PLUGIN_URL . 'admin/builder/assets/js/tooltip-wizard.js',
			[ 'jquery' ],
			CTF_VERSION
		);

		$wp_localize_data = [];
		if( $this->check_gutenberg_wizard() ){
			$wp_localize_data['ctf_wizard_gutenberg'] = true;
		}

		wp_localize_script(
			'ctf-admin-tooltip-wizard',
			'ctf_admin_tooltip_wizard',
			$wp_localize_data
		);
	}

	/**
	 * Output HTML.
	 *
	 * @since 2.0
	 */
	public function output() {
		if( $this->check_gutenberg_wizard() ){
			$this->gutenberg_tooltip_output();
		}

	}

	/**
	 * Gutenberg Tooltip Output HTML.
	 *
	 * @since 2.0
	 */
	public function check_gutenberg_wizard() {
		global $pagenow;
		return  (	( $pagenow == 'post.php' ) || (get_post_type() == 'page') )
				&& ! empty( $_GET['ctf_wizard'] );
	}


	/**
	 * Gutenberg Tooltip Output HTML.
	 *
	 * @since 2.0
	 */
	public function gutenberg_tooltip_output() {
		?>
		<div id="ctf-gutenberg-tooltip-content">
			<div class="ctf-tlp-wizard-cls ctf-tlp-wizard-close"></div>
			<div class="ctf-tlp-wizard-content">
				<strong class="ctf-tooltip-wizard-head"><?php echo __('Add a Block','custom-twitter-feeds') ?></strong>
				<p class="ctf-tooltip-wizard-txt"><?php echo __('Click the plus button, search for Custom Twitter Feed','custom-twitter-feeds'); ?>
                    <br/><?php echo __('Feed, and click the block to embed it.','custom-twitter-feeds') ?> <a href="https://smashballoon.com/doc/wordpress-5-block-page-editor-gutenberg/?twitter" rel="noopener" target="_blank" rel="nofollow noopener"><?php echo __('Learn More','custom-twitter-feeds') ?></a></p>
				<div class="ctf-tooltip-wizard-actions">
					<button class="ctf-tlp-wizard-close"><?php echo __('Done','custom-twitter-feeds') ?></button>
				</div>
			</div>
		</div>
		<?php
	}


}

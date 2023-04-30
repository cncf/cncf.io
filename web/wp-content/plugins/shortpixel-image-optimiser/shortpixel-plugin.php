<?php
namespace ShortPixel;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Notices\NoticeController as Notices;
use ShortPixel\Controller\OptimizeController as OptimizeController;
use ShortPixel\Controller\QuotaController as QuotaController;
use ShortPixel\Controller\AjaxController as AjaxController;
use ShortPixel\Controller\AdminController as AdminController;
use ShortPixel\Controller\OtherMediaController as OtherMediaController;
use ShortPixel\NextGenController as NextGenController;

use ShortPixel\Controller\Queue\MediaLibraryQueue as MediaLibraryQueue;
use ShortPixel\Controller\Queue\CustomQueue as CustomQueue;

use ShortPixel\Helper\InstallHelper as InstallHelper;

/** Plugin class
 * This class is meant for: WP Hooks, init of runtime and Controller Routing.
 */
class ShortPixelPlugin {

	private static $instance;
	protected static $modelsLoaded = array(); // don't require twice, limit amount of require looksups..

	// private $paths = array('class', 'class/controller', 'class/external', 'class/controller/views'); // classes that are autoloaded

	protected $is_noheaders = false;

	protected $plugin_path;
	protected $plugin_url;

	protected $shortPixel; // shortpixel megaclass
	protected $settings; // settings object.

	protected $admin_pages = array();  // admin page hooks.

	public function __construct() {
		// $this->initHooks();
		add_action( 'plugins_loaded', array( $this, 'lowInit' ), 5 ); // early as possible init.
	}


	/** LowInit after all Plugins are loaded. Core WP function can still be missing. This should mostly add hooks */
	public function lowInit() {

		$this->plugin_path = plugin_dir_path( SHORTPIXEL_PLUGIN_FILE );
		$this->plugin_url  = plugin_dir_url( SHORTPIXEL_PLUGIN_FILE );

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended  -- This is not a form
		if ( isset( $_REQUEST['noheader'] ) ) {
			$this->is_noheaders = true;
		}

		/*
		Filter to prevent SPIO from starting. This can be used by third-parties to prevent init when needed for a particular situation.
		* Hook into plugins_loaded with priority lower than 5 */
		$init = apply_filters( 'shortpixel/plugin/init', true );

		if ( ! $init ) {
			return;
		}

		$front        = new Controller\FrontController();
		$admin        = Controller\AdminController::getInstance();
		$adminNotices = Controller\AdminNoticesController::getInstance(); // Hook in the admin notices.

		$this->initHooks();
		$this->ajaxHooks();

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			WPCliController::getInstance();
		}

		add_action( 'admin_init', array( $this, 'init' ) );
	}


	/** Mainline Admin Init. Tasks that can be loaded later should go here */
	public function init() {
			// This runs activation thing. Should be -after- init
			$this->check_plugin_version();

		$notices             = Notices::getInstance(); // This hooks the ajax listener
			$quotaController = QuotaController::getInstance();
			$quotaController->getQuota();

	}

	/** Function to get plugin settings
     *
     * @return SettingsModel The settings model object.
     */
	public function settings() {
		if ( is_null( $this->settings ) ) {
			$this->settings = new \WPShortPixelSettings();
		}

		return $this->settings;
	}

	/** Function to get all enviromental variables
     *
     * @return EnvironmentModel
     */
	public function env() {
		return Model\EnvironmentModel::getInstance();
	}

	public function fileSystem() {
		return new Controller\FileSystemController();
	}

	/** Create instance. This should not be needed to call anywhere else than main plugin file
     * This should not be called *after* plugins_loaded action
     **/
	public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new ShortPixelPlugin();
		}
		return self::$instance;

	}


	/** Hooks for all WordPress related hooks
     * For now hooks in the lowInit, asap.
     */
	public function initHooks() {
		add_action( 'admin_menu', array( $this, 'admin_pages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) ); // admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) ); // admin styles
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ), 90 ); // loader via route.
		add_action( 'enqueue_block_assets', array($this, 'load_admin_scripts'), 90);
		// defer notices a little to allow other hooks ( notable adminnotices )

		$optimizeController = new OptimizeController();
		add_action( 'shortpixel-thumbnails-regenerated', array( $optimizeController, 'thumbnailsChangedHook' ), 10, 4 );

		// Media Library
		add_action( 'load-upload.php', array( $this, 'route' ) );

		add_action( 'load-post.php', array( $this, 'route' ) );

		$admin = AdminController::getInstance();

		// Handle for EMR
		add_action( 'wp_handle_replace', array( $admin, 'handleReplaceHook' ) );

		// Action / hook for who wants to use CRON. Please refer to manual / support to prevent loss of credits.
		add_action( 'shortpixel/hook/processqueue', array( $admin, 'processQueueHook' ) );

		// Placeholder function for heic and such, return placeholder URL in image to help w/ database replacements after conversion.
		add_filter('wp_get_attachment_url', array($admin, 'checkPlaceHolder'), 10, 2);

		if ( $this->env()->is_autoprocess ) {
			// compat filter to shortcircuit this in cases.  (see external - visualcomposer)
			if ( apply_filters( 'shortpixel/init/automedialibrary', true ) ) {

      			add_action( 'shortpixel-thumbnails-before-regenerate', array( $admin, 'preventImageHook' ), 10, 1 );

						add_action( 'enable-media-replace-upload-done', array( $admin, 'handleReplaceEnqueue' ), 10, 3 );

				add_filter( 'wp_generate_attachment_metadata', array( $admin, 'handleImageUploadHook' ), 10, 2 );
				// @integration MediaPress
				add_filter( 'mpp_generate_metadata', array( $admin, 'handleImageUploadHook' ), 10, 2 );
			}
		}

		load_plugin_textdomain( 'shortpixel-image-optimiser', false, plugin_basename( dirname( SHORTPIXEL_PLUGIN_FILE ) ) . '/lang' );

		$isAdminUser = current_user_can( 'manage_options' ); // @todo This should be in env

		$this->env()->setDefaultViewModeList();// set default mode as list. only @ first run

		add_filter( 'plugin_action_links_' . plugin_basename( SHORTPIXEL_PLUGIN_FILE ), array( $admin, 'generatePluginLinks' ) );// for plugin settings page

		// for cleaning up the WebP images when an attachment is deleted . Loading this early because it's possible other plugins delete files in the uploads, but we need those to remove backups.
		add_action( 'delete_attachment', array( $admin, 'onDeleteAttachment' ), 5 );
		add_action( 'mime_types', array( $admin, 'addMimes' ) );

		// integration with WP/LR Sync plugin
		add_action( 'wplr_update_media', array( AjaxController::getInstance(), 'onWpLrUpdateMedia' ), 10, 2 );

		add_action( 'admin_bar_menu', array( $admin, 'toolbar_shortpixel_processing' ), 999 );

		if ( $isAdminUser ) {
			// toolbar notifications
			// add_action( 'wp_head', array( $this, 'headCSS')); // for the front-end

			// deactivate conflicting plugins if found
			add_action( 'admin_post_shortpixel_deactivate_conflict_plugin', array( '\ShortPixel\Helper\InstallHelper', 'deactivateConflictingPlugin' ) );

			// only if the key is not yet valid or the user hasn't bought any credits.
			// @todo This should not be done here.
			$settings     = $this->settings();
			$stats        = $settings->currentStats;
			$totalCredits = isset( $stats['APICallsQuotaNumeric'] ) ? $stats['APICallsQuotaNumeric'] + $stats['APICallsQuotaOneTimeNumeric'] : 0;
			if ( true || ! $settings->verifiedKey || $totalCredits < 4000 ) {
				require_once 'class/view/shortpixel-feedback.php';
				new ShortPixelFeedback( SHORTPIXEL_PLUGIN_FILE, 'shortpixel-image-optimiser' );
			}
		}

	}

	protected function ajaxHooks() {

		// Ajax hooks. Should always be prepended with ajax_ and *must* check on nonce in function
		add_action( 'wp_ajax_shortpixel_image_processing', array( AjaxController::getInstance(), 'ajax_processQueue' ) );

		// Custom Media
		add_action( 'wp_ajax_shortpixel_browse_content', array( OtherMediaController::getInstance(), 'ajaxBrowseContent' ) );
		add_action( 'wp_ajax_shortpixel_get_backup_size', array( AjaxController::getInstance(), 'ajax_getBackupFolderSize' ) );

		add_action( 'wp_ajax_shortpixel_propose_upgrade', array( AjaxController::getInstance(), 'ajax_proposeQuotaUpgrade' ) );
		add_action( 'wp_ajax_shortpixel_check_quota', array( AjaxController::getInstance(), 'ajax_checkquota' ) );

		// @todo should probably go through ajaxrequest.
		add_action( 'wp_ajax_shortpixel_get_comparer_data', array( AjaxController::getInstance(), 'ajax_getComparerData' ) );

		add_action( 'wp_ajax_shortpixel_ajaxRequest', array( AjaxController::getInstance(), 'ajaxRequest' ) );

		// Used by processor
		 add_action( 'wp_ajax_shortpixel_get_item_view', array( AjaxController::getInstance(), 'ajax_getItemView' ) );

	}

	/** Hook in our admin pages */
	public function admin_pages() {
		$admin_pages = array();
		// settings page
		$admin_pages[] = add_options_page( __( 'ShortPixel Settings', 'shortpixel-image-optimiser' ), 'ShortPixel', 'manage_options', 'wp-shortpixel-settings', array( $this, 'route' ) );

		$otherMediaController = OtherMediaController::getInstance();
		if ( $otherMediaController->hasCustomImages() ) {
			/*translators: title and menu name for the Other media page*/
			$admin_pages[] = add_media_page( __( 'Custom Media Optimized by ShortPixel', 'shortpixel-image-optimiser' ), __( 'Custom Media', 'shortpixel-image-optimiser' ), 'edit_others_posts', 'wp-short-pixel-custom', array( $this, 'route' ) );
		}
		/*translators: title and menu name for the Bulk Processing page*/
		$admin_pages[] = add_media_page( __( 'ShortPixel Bulk Process', 'shortpixel-image-optimiser' ), __( 'Bulk ShortPixel', 'shortpixel-image-optimiser' ), 'edit_others_posts', 'wp-short-pixel-bulk', array( $this, 'route' ) );

		$this->admin_pages = $admin_pages;
	}


	/** All scripts should be registed, not enqueued here (unless global wp-admin is needed )
     *
     * Not all those registered must be enqueued however.
     */
	public function admin_scripts( $hook_suffix ) {

		$settings       = \wpSPIO()->settings();
		$ajaxController = AjaxController::getInstance();

		$secretKey = $ajaxController->getProcessorKey();

		$keyControl = \ShortPixel\Controller\ApiKeyController::getInstance();
		$apikey     = $keyControl->getKeyForDisplay();

		$is_bulk_page = \wpSPIO()->env()->is_bulk_page;

		$optimizeController = new OptimizeController();
		$optimizeController->setBulk( $is_bulk_page );

		$quotaController = QuotaController::getInstance();

		// FileTree in Settings
		wp_register_script( 'sp-file-tree', plugins_url( '/res/js/sp-file-tree.min.js', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		wp_register_script( 'jquery.knob.min.js', plugins_url( '/res/js/jquery.knob.min.js', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		//wp_register_script( 'jquery.tooltip.min.js', plugins_url( '/res/js/jquery.tooltip.min.js', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		wp_register_script( 'shortpixel-debug', plugins_url( '/res/js/debug.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'jquery-ui-draggable' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		wp_register_script( 'shortpixel-tooltip', plugins_url( '/res/js/shortpixel-tooltip.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		$tooltip_localize = array(
			'processing' => __('Processing... ','shortpixel-image-optimiser'),
			'pause' =>  __('Click to pause', 'shortpixel-image-optimiser'),
			'resume' => __('Click to resume', 'shortpixel-image-optimiser'),
			'item' => __('item in queue', 'shortpixel-image-optimiser'),
			'items' => __('items in queue', 'shortpixel-image-optimiser'),
		);

		wp_localize_script( 'shortpixel-tooltip', 'spio_tooltipStrings', $tooltip_localize);

		wp_register_script( 'shortpixel-settings', plugins_url( 'res/js/shortpixel-settings.js', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		wp_register_script( 'shortpixel-processor', plugins_url( '/res/js/shortpixel-processor.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'shortpixel-tooltip' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		 // How often JS processor asks for next tick on server. Low for fastestness and high loads, high number for surviving servers.
		$interval = apply_filters( 'shortpixel/processor/interval', 3000 );

		// If the queue is empty how often to check if something new appeared from somewhere. Excluding the manual items added by current processor user.
		$deferInterval = apply_filters( 'shortpixel/process/deferInterval', 60000 );

		wp_localize_script(
            'shortpixel-processor',
            'ShortPixelProcessorData',
            array(
				'bulkSecret'        => $secretKey,
				'isBulkPage'        => (bool) $is_bulk_page,
				'screenURL'         => false,
				'workerURL'         => plugins_url( 'res/js/shortpixel-worker.js', SHORTPIXEL_PLUGIN_FILE ),
				'nonce_process'     => wp_create_nonce( 'processing' ),
				'nonce_exit'        => wp_create_nonce( 'exit_process' ),
				'nonce_itemview'    => wp_create_nonce( 'item_view' ),
				'nonce_ajaxrequest' => wp_create_nonce( 'ajax_request' ),
				'startData'         => ( \wpSPIO()->env()->is_screen_to_use ) ? $optimizeController->getStartupData() : false,
				'interval'          => $interval,
				'deferInterval'     => $deferInterval,

            )
        );

		/*** SCREENS */
		wp_register_script('shortpixel-screen-base', plugins_url( '/res/js/screens/screen-base.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'shortpixel-processor' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		wp_register_script('shortpixel-screen-item-base', plugins_url( '/res/js/screens/screen-item-base.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'shortpixel-processor', 'shortpixel-screen-base'), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		wp_register_script( 'shortpixel-screen-media', plugins_url( '/res/js/screens/screen-media.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'shortpixel-processor', 'shortpixel-screen-base', 'shortpixel-screen-item-base' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		wp_register_script( 'shortpixel-screen-custom', plugins_url( '/res/js/screens/screen-custom.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'shortpixel-processor', 'shortpixel-screen-base', 'shortpixel-screen-item-base' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		wp_register_script( 'shortpixel-screen-nolist', plugins_url( '/res/js/screens/screen-nolist.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'shortpixel-processor', 'shortpixel-screen-base' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

	  $screen_localize = array(
			'startAction' => __('Processing... ','shortpixel-image-optimiser'),
			'fatalError' => __('Shortpixel encountered a fatal error when optimizing images. Please check the issue below. If this is caused by a bug please contact our support', 'shortpixel-image-optimiser'),
			'fatalErrorStop' => __('Shortpixel has encounted multiple errors and has now stopped processing', 'shortpixel-image-optimiser'),
			'fatalErrorStopText' => __('No items are being processed. To try again after solving the issues, please reload the page ', 'shortpixel-image-optimiser'),
		) ;

		//wp_localize_script('shortpixel-screen-base', 'ShortPixelProcessorTranslations', array(
	//	));


		wp_localize_script( 'shortpixel-screen-base', 'spio_screenStrings', $screen_localize);
	//	wp_localize_script( 'shortpixel-screen-custom', 'spio_screenStrings', $screen_localize);

		wp_register_script( 'shortpixel-screen-bulk', plugins_url( '/res/js/screens/screen-bulk.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'shortpixel-processor', 'shortpixel-screen-base'), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended  -- This is not a form
		$panel = isset( $_GET['panel'] ) ? sanitize_text_field( wp_unslash($_GET['panel']) ) : false;

		$bulkLocalize = array(
			'endBulk'   => __( 'This will stop the bulk processing and take you back to the start. Are you sure you want to do this?', 'shortpixel-image-optimiser' ),
			'reloadURL' => admin_url( 'upload.php?page=wp-short-pixel-bulk' ),
		);
		if ( $panel ) {
			$bulkLocalize['panel'] = $panel;
        }

		// screen translations. Can all be loaded on the same var, since only one screen can be active.
		wp_localize_script( 'shortpixel-screen-bulk', 'shortPixelScreen', $bulkLocalize );

		wp_register_script( 'shortpixel', plugins_url( '/res/js/shortpixel.js', SHORTPIXEL_PLUGIN_FILE ), array( 'jquery', 'jquery.knob.min.js' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION, true );

		// Using an Array within another Array to protect the primitive values from being cast to strings
		$ShortPixelConstants = array(
			array(
				'WP_PLUGIN_URL'     => plugins_url( '', SHORTPIXEL_PLUGIN_FILE ),
				'WP_ADMIN_URL'      => admin_url(),
				'API_IS_ACTIVE'     => $keyControl->keyIsVerified(),
				'AJAX_URL'          => admin_url( 'admin-ajax.php' ),
				'BULK_SECRET'       => $secretKey,
				'nonce_ajaxrequest' => wp_create_nonce( 'ajax_request' ),
				'HAS_QUOTA'         => ( $quotaController->hasQuota() ) ? 1 : 0,

			),
		);

		if ( Log::isManualDebug() ) {
			Log::addInfo( 'Ajax Manual Debug Mode' );
			$logLevel                           = Log::getLogLevel();
			$ShortPixelConstants[0]['AJAX_URL'] = admin_url( 'admin-ajax.php?SHORTPIXEL_DEBUG=' . $logLevel );
		}

		$jsTranslation = array(
			'optimizeWithSP'              => __( 'Optimize with ShortPixel', 'shortpixel-image-optimiser' ),
			'redoLossy'                   => __( 'Re-optimize Lossy', 'shortpixel-image-optimiser' ),
			'redoGlossy'                  => __( 'Re-optimize Glossy', 'shortpixel-image-optimiser' ),
			'redoLossless'                => __( 'Re-optimize Lossless', 'shortpixel-image-optimiser' ),
			'restoreOriginal'             => __( 'Restore Originals', 'shortpixel-image-optimiser' ),
			'changeMLToListMode'          => __( 'In order to access the ShortPixel Optimization actions and info, please change to {0}List View{1}List View{2}Dismiss{3}', 'shortpixel-image-optimiser' ),
			'alertOnlyAppliesToNewImages' => __( 'This type of optimization will apply to new uploaded images. Images that were already processed will not be re-optimized unless you restart the bulk process.', 'shortpixel-image-optimiser' ),
			'areYouSureStopOptimizing'    => __( 'Are you sure you want to stop optimizing the folder {0}?', 'shortpixel-image-optimiser' ),
			'reducedBy'                   => __( 'Reduced by', 'shortpixel-image-optimiser' ),
			'bonusProcessing'             => __( 'Bonus processing', 'shortpixel-image-optimiser' ),
			'plusXthumbsOpt'              => __( '+{0} thumbnails optimized', 'shortpixel-image-optimiser' ),
			'plusXretinasOpt'             => __( '+{0} Retina images optimized', 'shortpixel-image-optimiser' ),
			'optXThumbs'                  => __( 'Optimize {0} thumbnails', 'shortpixel-image-optimiser' ),
			'reOptimizeAs'                => __( 'Reoptimize {0}', 'shortpixel-image-optimiser' ),
			'restoreBackup'               => __( 'Restore backup', 'shortpixel-image-optimiser' ),
			'getApiKey'                   => __( 'Get API Key', 'shortpixel-image-optimiser' ),
			'extendQuota'                 => __( 'Extend Quota', 'shortpixel-image-optimiser' ),
			'check__Quota'                => __( 'Check&nbsp;&nbsp;Quota', 'shortpixel-image-optimiser' ),
			'retry'                       => __( 'Retry', 'shortpixel-image-optimiser' ),
			'thisContentNotProcessable'   => __( 'This content is not processable.', 'shortpixel-image-optimiser' ),
			'imageWaitOptThumbs'          => __( 'Image waiting to optimize thumbnails', 'shortpixel-image-optimiser' ),
			'pleaseDoNotSetLesserSize'    => __( "Please do not set a {0} less than the {1} of the largest thumbnail which is {2}, to be able to still regenerate all your thumbnails in case you'll ever need this.", 'shortpixel-image-optimiser' ),
			'pleaseDoNotSetLesser1024'    => __( "Please do not set a {0} less than 1024, to be able to still regenerate all your thumbnails in case you'll ever need this.", 'shortpixel-image-optimiser' ),
			'confirmBulkRestore'          => __( 'Are you sure you want to restore from backup all the images in your Media Library optimized with ShortPixel?', 'shortpixel-image-optimiser' ),
			'confirmBulkCleanup'          => __( "Are you sure you want to cleanup the ShortPixel metadata info for the images in your Media Library optimized with ShortPixel? This will make ShortPixel 'forget' that it optimized them and will optimize them again if you re-run the Bulk Optimization process.", 'shortpixel-image-optimiser' ),
			'confirmBulkCleanupPending'   => __( 'Are you sure you want to cleanup the pending metadata?', 'shortpixel-image-optimiser' ),
			'alertDeliverWebPAltered'     => __( "Warning: Using this method alters the structure of the rendered HTML code (IMG tags get included in PICTURE tags), which, in some rare \ncases, can lead to CSS/JS inconsistencies.\n\nPlease test this functionality thoroughly after activating!\n\nIf you notice any issue, just deactivate it and the HTML will will revert to the previous state.", 'shortpixel-image-optimiser' ),
			'alertDeliverWebPUnaltered'   => __( 'This option will serve both WebP and the original image using the same URL, based on the web browser capabilities, please make sure you\'re serving the images from your server and not using a CDN which caches the images.', 'shortpixel-image-optimiser' ),
			'originalImage'               => __( 'Original image', 'shortpixel-image-optimiser' ),
			'optimizedImage'              => __( 'Optimized image', 'shortpixel-image-optimiser' ),
			'loading'                     => __( 'Loading...', 'shortpixel-image-optimiser' ),
		);

		wp_localize_script( 'shortpixel', '_spTr', $jsTranslation );
		wp_localize_script( 'shortpixel', 'ShortPixelConstants', $ShortPixelConstants );

	}

	public function admin_styles() {

		wp_register_style( 'sp-file-tree', plugins_url( '/res/css/sp-file-tree.min.css', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

		wp_register_style( 'shortpixel', plugins_url( '/res/css/short-pixel.css', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

		// notices. additional styles for SPIO.
		wp_register_style( 'shortpixel-notices', plugins_url( '/res/css/shortpixel-notices.css', SHORTPIXEL_PLUGIN_FILE ), array( 'shortpixel-admin' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

		wp_register_style('notices-module', plugins_url('/build/shortpixel/notices/src/css/notices.css', SHORTPIXEL_PLUGIN_FILE), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION);

		// other media screen
		wp_register_style( 'shortpixel-othermedia', plugins_url( '/res/css/shortpixel-othermedia.css', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

		// load everywhere, because we are inconsistent.
		wp_register_style( 'shortpixel-toolbar', plugins_url( '/res/css/shortpixel-toolbar.css', SHORTPIXEL_PLUGIN_FILE ), array( 'dashicons' ), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

		// @todo Might need to be removed later on
		wp_register_style( 'shortpixel-admin', plugins_url( '/res/css/shortpixel-admin.css', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

		wp_register_style( 'shortpixel-bulk', plugins_url( '/res/css/shortpixel-bulk.css', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

		wp_register_style( 'shortpixel-nextgen', plugins_url( '/res/css/shortpixel-nextgen.css', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

		wp_register_style( 'shortpixel-settings', plugins_url( '/res/css/shortpixel-settings.css', SHORTPIXEL_PLUGIN_FILE ), array(), SHORTPIXEL_IMAGE_OPTIMISER_VERSION );

	}


	/** Load Style via Route, on demand */
	public function load_style( $name ) {
		if ( $this->is_noheaders ) {  // fail silently, if this is a no-headers request.
			return;
		}

		if ( wp_style_is( $name, 'registered' ) ) {
			wp_enqueue_style( $name );
		} else {
			Log::addWarn( "Style $name was asked for, but not registered" );
		}
	}

	/** Load Style via Route, on demand */
	public function load_script( $script ) {
		if ( $this->is_noheaders ) {  // fail silently, if this is a no-headers request.
			return;
		}

		if ( ! is_array( $script ) ) {
			$script = array( $script );
		}

		foreach ( $script as $index => $name ) {
			if ( wp_script_is( $name, 'registered' ) ) {
				wp_enqueue_script( $name );
			} else {
				Log::addWarn( "Script $name was asked for, but not registered" );
			}
		}
	}

	/** This is separated from route to load in head, preventing unstyled content all the time */
	public function load_admin_scripts( $hook_suffix ) {
		global $plugin_page;
		$screen_id = $this->env()->screen_id;


		// $load = array();
		$load_processor = array( 'shortpixel', 'shortpixel-processor' );  // a whole suit needed for processing, not more. Always needs a screen as well!
		$load_bulk      = array();  // the whole suit needed for bulking.


		if ( \wpSPIO()->env()->is_screen_to_use ) {
			$this->load_script( $load_processor );
			$this->load_style( 'shortpixel-toolbar' );
		}

		if ( $plugin_page == 'wp-shortpixel-settings' ) {

			$this->load_script( 'shortpixel-screen-nolist' ); // screen
			//$this->load_script( 'jquery.tooltip.min.js' );
			$this->load_script( 'sp-file-tree' );
			$this->load_script( 'shortpixel-settings' );

			$this->load_style( 'shortpixel-admin' );
			$this->load_style( 'shortpixel' );
			$this->load_style( 'sp-file-tree' );
			$this->load_style( 'shortpixel-settings' );

		} elseif ( $plugin_page == 'wp-short-pixel-bulk' ) {
			//$this->load_script( $load_processor );
			$this->load_script( 'shortpixel-screen-bulk' );

			$this->load_style( 'shortpixel-admin' );
			$this->load_style( 'shortpixel-bulk' );
		} elseif ( $screen_id == 'upload' || $screen_id == 'attachment' ) {
			//$this->load_script( $load_processor );
			$this->load_script( 'shortpixel-screen-media' ); // screen

			$this->load_style( 'shortpixel-admin' );
			$this->load_style( 'shortpixel' );

			if ( $this->env()->is_debug ) {
				$this->load_script( 'shortpixel-debug' );
			}

		} elseif ( $plugin_page == 'wp-short-pixel-custom' ) {
			$this->load_style( 'shortpixel' );
			$this->load_style( 'shortpixel-admin' );

			$this->load_style( 'shortpixel-othermedia' );
			//$this->load_script( $load_processor );
			$this->load_script( 'shortpixel-screen-custom' ); // screen

		} elseif ( NextGenController::getInstance()->isNextGenScreen() ) {
			//$this->load_script( $load_processor );
			$this->load_script( 'shortpixel-screen-custom' ); // screen
			$this->load_style( 'shortpixel-admin' );

			$this->load_style( 'shortpixel' );
			$this->load_style( 'shortpixel-nextgen' );
		}
		elseif ( $this->env()->is_gutenberg_editor === true)
		{
			$this->load_script( $load_processor );
			$this->load_script( 'shortpixel-screen-nolist' ); // screen
		}
		elseif (true === \wpSPIO()->env()->is_screen_to_use  )
		{
			// If our screen, but we don't have a specific handler for it, do the no-list screen.
			//$this->load_script( $load_processor );
			$this->load_script( 'shortpixel-screen-nolist' ); // screen
		}

	}

	/** Route, based on the page slug
     *
     * Principially all page controller should be routed from here.
     */
	public function route() {
		global $plugin_page;
		// $this->initPluginRunTime(); // Not in use currently.
		$default_action = 'load'; // generic action on controller.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended  -- This is not a form
		$action         = isset( $_REQUEST['sp-action'] ) ? sanitize_text_field( wp_unslash($_REQUEST['sp-action']) ) : $default_action;
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended  -- This is not a form
		$template_part  = isset( $_GET['part'] ) ? sanitize_text_field( wp_unslash($_GET['part']) ) : false;

		$controller = false;

		$url       = menu_page_url( $plugin_page, false );
		$screen_id = \wpSPIO()->env()->screen_id;

        switch ( $plugin_page ) {
            case 'wp-shortpixel-settings': // settings
				$controller = 'ShortPixel\Controller\SettingsController';
                break;
            case 'wp-short-pixel-custom': // other media

				$controller = 'ShortPixel\Controller\View\OtherMediaViewController';
                break;
        case 'wp-short-pixel-bulk':
					$controller = '\ShortPixel\Controller\View\BulkViewController';
               break;
            case null:
            default:
                switch ( $screen_id ) {
					case 'upload':
                        $controller = '\ShortPixel\Controller\View\ListMediaViewController';
                        break;
					case 'attachment'; // edit-media
                        $controller = '\ShortPixel\Controller\View\EditMediaViewController';
                     break;

                }
                break;

		}

		if ( $controller !== false ) {
			$c = new $controller();
			$c->setControllerURL( $url );
			if ( method_exists( $c, $action ) ) {
				$c->$action();
			} else {
				Log::addWarn( "Attempted Action $action on $controller does not exist!" );
				$c->$default_action();
			}
		}
	}


	// Get the plugin URL, based on real URL.
	public function plugin_url( $urlpath = '' ) {
		$url = trailingslashit( $this->plugin_url );
		if ( strlen( $urlpath ) > 0 ) {
			$url .= $urlpath;
		}
		return $url;
	}

	// Get the plugin path.
	public function plugin_path( $path = '' ) {
		$plugin_path = trailingslashit( $this->plugin_path );
		if ( strlen( $path ) > 0 ) {
			$plugin_path .= $path;
		}

		return $plugin_path;
	}

	/** Returns defined admin page hooks. Internal use - check states via environmentmodel
     *
     * @returns Array
     */
	public function get_admin_pages() {
		return $this->admin_pages;
	}

	protected function check_plugin_version() {
           $version     = SHORTPIXEL_IMAGE_OPTIMISER_VERSION;
			$db_version = $this->settings()->currentVersion;

		if ( $version !== $db_version ) {
			InstallHelper::activatePlugin();
		}
			$this->settings()->currentVersion = $version;
	}




} // class plugin

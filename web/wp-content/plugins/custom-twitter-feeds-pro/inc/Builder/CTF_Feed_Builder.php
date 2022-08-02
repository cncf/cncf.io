<?php
/**
 * Custom Twitter Feed Builder
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder;


use TwitterFeed\CTF_Feed_Locator;
use TwitterFeed\Pro\CTF_Settings_Pro;
use TwitterFeed\Builder\Tabs\CTF_Styling_Tab;
use TwitterFeed\Builder\CTF_Feed_Saver;
use TwitterFeed\CtfOauthConnectPro;

class CTF_Feed_Builder {
	private static $instance;
	public static function instance() {
		if ( null === self::$instance) {
			require CTF_PLUGIN_DIR . 'vendor/autoload.php';
			self::$instance = new self();
			return self::$instance;

		}
	}


	/**
	 * Constructor.
	 *
	 * @since 2.0
	 */
	function __construct(){
		$this->init();
	}

	/**
	 * Init the Builder.
	 *
	 * @since 2.0
	*/
	function init(){
		if( is_admin() ){
			add_action('admin_menu', [$this, 'register_menu']);
			// add ajax listeners
			CTF_Feed_Saver_Manager::hooks();
			CTF_Feed_Builder::hooks();
			#echo json_encode(CTF_Feed_Saver::settings_defaults());

		}
	}

	/**
	 * Mostly AJAX related hooks
	 *
	 * @since 2.0
	 */
	public static function hooks() {
		add_action( 'wp_ajax_ctf_dismiss_onboarding', array( 'TwitterFeed\Builder\CTF_Feed_Builder', 'after_dismiss_onboarding' ) );
	}

	/**
	 * Check users capabilities and maybe nonce before AJAX actions
	 *
	 * @param $check_nonce
	 * @param string $action
	 *
	 * @since 2.0.6
	 */
	public static function check_privilege( $check_nonce = false, $action = 'ctf-admin' ) {
		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );

		if ( ! current_user_can( $cap ) ) {
			wp_die ( 'You did not do this the right way!' );
		}

		if ( $check_nonce ) {
			$nonce = ! empty( $_POST[ $check_nonce ] ) ? $_POST[ $check_nonce ] : false;

			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				wp_die ( 'You did not do this the right way!' );
			}
		}
	}

	/**
	 * Register Menu.
	 *
	 * @since 2.0
	 */
	function register_menu(){
	 	$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
    	$cap = apply_filters( 'ctf_settings_pages_capability', $cap );

		$feed_builder = add_submenu_page(
	        'custom-twitter-feeds',
	        __( 'All Feeds', 'custom-twitter-feeds' ),
	        __( 'All Feeds', 'custom-twitter-feeds' ),
	        $cap,
	        'ctf-feed-builder',
	        [$this, 'feed_builder'],
	        0
	    );
	    add_action( 'load-' . $feed_builder, [$this,'builder_enqueue_admin_scripts']);
	}

	/**
	 * Enqueue Builder CSS & Script.
	 *
	 * Loads only for builder pages
	 *
	 * @since 2.0
	 */
    public function builder_enqueue_admin_scripts(){
        if(get_current_screen()):
        	$screen = get_current_screen();
			if ( strpos($screen->id, 'ctf-feed-builder')  !== false ) :

		        $installed_plugins = get_plugins();

		        $newly_retrieved_source_connection_data = [];
		        $license_key = get_option( 'ctf_license_key', '' );
				$ctf_options = get_option( 'ctf_options', array() );


		        $ctf_builder = array(
					'ajax_handler'		=> 	admin_url( 'admin-ajax.php' ),
					'pluginType' 		=> 'pro',
					'builderUrl'		=> admin_url( 'admin.php?page=ctf-feed-builder' ),
					'nonce'				=> wp_create_nonce( 'ctf-admin' ),
					'adminPostURL'		=> 	admin_url( 'post.php' ),
					'adminSettingsURL'	=> 	admin_url('admin.php?page=ctf-settings'),
					'widgetsPageURL'	=> 	admin_url( 'widgets.php' ),
					'supportPageUrl'    => admin_url( 'admin.php?page=ctf-support' ),
					'genericText'       => self::get_generic_text(),
					'translatedText' 	=> $this->get_translated_text(),
					'welcomeScreen' => array(
						'mainHeading' => __( 'All Feeds', 'custom-twitter-feeds' ),
						'createFeed' => __( 'Create your Feed', 'custom-twitter-feeds' ),
						'createFeedDescription' => __( 'Connect your Twitter account and choose a feed type', 'custom-twitter-feeds' ),
						'customizeFeed' => __( 'Customize your feed type', 'custom-twitter-feeds' ),
						'customizeFeedDescription' => __( 'Choose layouts, color schemes, filters and more', 'custom-twitter-feeds' ),
						'embedFeed' => __( 'Embed your feed', 'custom-twitter-feeds' ),
						'embedFeedDescription' => __( 'Easily add the feed anywhere on your website', 'custom-twitter-feeds' ),
						'customizeImgPath' => CTF_BUILDER_URL . 'assets/img/welcome-1.png',
						'embedImgPath' => CTF_BUILDER_URL . 'assets/img/welcome-2.png',
					),
					'pluginsInfo' => [
						'social_wall' => [
							'installed' => isset( $installed_plugins['social-wall/social-wall.php'] ) ? true : false,
							'activated' => is_plugin_active( 'social-wall/social-wall.php' ),
							'settingsPage' => admin_url( 'admin.php?page=sbsw' ),
						]
					],
					'allFeedsScreen' => array(
						'mainHeading' => __( 'All Feeds', 'custom-twitter-feeds' ),
						'columns' => array(
							'nameText' => __( 'Name', 'custom-twitter-feeds' ),
							'shortcodeText' => __( 'Shortcode', 'custom-twitter-feeds' ),
							'instancesText' => __( 'Instances', 'custom-twitter-feeds' ),
							'actionsText' => __( 'Actions', 'custom-twitter-feeds' ),
						),
						'bulkActions' => __( 'Bulk Actions', 'custom-twitter-feeds' ),
						'legacyFeeds' => array(
							'heading' => __( 'Legacy Feeds', 'custom-twitter-feeds' ),
							'toolTip' => __( 'What are Legacy Feeds?', 'custom-twitter-feeds' ),
							'toolTipExpanded' => array(
								__( 'Legacy feeds are older feeds from before the version 2 update. You can edit settings for these feeds by using the "Settings" button to the right. These settings will apply to all legacy feeds, just like the settings before version 2, and work in the same way that they used to.', 'custom-twitter-feeds' ),
								__( 'You can also create a new feed, which will now have it\'s own individual settings. Modifying settings for new feeds will not affect other feeds.', 'custom-twitter-feeds' ),
							),
							'toolTipExpandedAction' => array(
								__( 'Legacy feeds represent shortcodes of old feeds found on your website before <br/>the version 2 update.', 'custom-twitter-feeds' ),
								__( 'To edit Legacy feed settings, you will need to use the "Settings" button above <br/>or edit their shortcode settings directly. To delete them, simply remove the <br/>shortcode wherever it is being used on your site.', 'custom-twitter-feeds' ),
							),
							'show' => __( 'Show Legacy Feeds', 'custom-twitter-feeds' ),
							'hide' => __( 'Hide Legacy Feeds', 'custom-twitter-feeds' ),
						),
						'socialWallLinks' => CTF_Feed_Builder::get_social_wall_links(),
						'onboarding' => $this->get_onboarding_text()
					),
					'dialogBoxPopupScreen'  => array(
						'deleteSourceCustomizer' => array(
							'heading' =>  __( 'Delete "#"?', 'custom-twitter-feeds' ),
							'description' => __( 'You are going to delete this source. To retrieve it, you will need to add it again. Are you sure you want to continue?', 'custom-twitter-feeds' ),
						),
						'deleteSingleFeed' => array(
							'heading' =>  __( 'Delete "#"?', 'custom-twitter-feeds' ),
							'description' => __( 'You are going to delete this feed. You will lose all the settings. Are you sure you want to continue?', 'custom-twitter-feeds' ),
						),
						'deleteMultipleFeeds' => array(
							'heading' =>  __( 'Delete Feeds?', 'custom-twitter-feeds' ),
							'description' => __( 'You are going to delete these feeds. You will lose all the settings. Are you sure you want to continue?', 'custom-twitter-feeds' ),
						),
						'backAllToFeed' => array(
							'heading' =>  __( 'Are you Sure?', 'custom-twitter-feeds' ),
							'description' => __( 'Are you sure you want to leave this page, all unsaved settings will be lost, please make sure to save before leaving.', 'custom-twitter-feeds' ),
						),
						'unsavedFeedSources' => array(
							'heading' =>  __( 'You have unsaved changes', 'custom-twitter-feeds' ),
							'description' => __( 'If you exit without saving, all the changes you made will be reverted.', 'custom-twitter-feeds' ),
							'customButtons' => array(
								'confirm' => [
									'text' => __( 'Save and Exit', 'custom-twitter-feeds' ),
									'color' => 'blue'
								],
								'cancel' => [
									'text' => __( 'Exit without Saving', 'custom-twitter-feeds' ),
									'color' => 'red'
								]
							)
						)
					),
					 'selectFeedTypeScreen' => array(
						'mainHeading' => __( 'Create a Twitter Feed', 'custom-twitter-feeds' ),
						'feedTypeHeading' => __( 'Select Feed Type', 'custom-twitter-feeds' ),
						'mainDescription' => __( 'Select one or more feed types. You can add or remove them later.', 'custom-twitter-feeds' ),
						'updateHeading' => __( 'Update Feed Type', 'custom-twitter-feeds' ),
						'anotherFeedTypeHeading' => __( 'Add Another Feed Type', 'custom-twitter-feeds' ),
			        ),
					 'selectFeedTemplateScreen' => array(
						'feedTemplateHeading' => __( 'Start with a template', 'custom-twitter-feeds' ),
						'feedTemplateDescription' => __( 'Select a starting point for your feed. You can customize this later.', 'custom-twitter-feeds' ),
						'updateHeading' => __( 'Select another template', 'custom-twitter-feeds' ),
						'updateHeadingWarning' => __( 'Changing a template will override your layout, header and button settings', 'custom-twitter-feeds' ),
						'updateHeadingWarning2' => __( 'Changing a template might override your customizations', 'custom-twitter-feeds' )
			        ),
					'mainFooterScreen' => array(
						'heading' => sprintf( __( 'Upgrade to the %sAll Access Bundle%s to get all of our Pro Plugins', 'custom-twitter-feeds' ), '<strong>', '</strong>' ),
						'description' => __( 'Includes all Smash Balloon plugins for one low price: Instagram, Facebook, Twitter, YouTube, and Social Wall', 'custom-twitter-feeds' ),
						'promo' => sprintf( __( '%sBonus%s Lite users get %s50&#37; Off%s automatically applied at checkout', 'custom-twitter-feeds' ), '<span class="ctf-bld-ft-bns">', '</span>', '<strong>', '</strong>' ),
					),
					'embedPopupScreen' => array(
						'heading' => __( 'Embed Feed', 'custom-twitter-feeds' ),
						'description' => __( 'Add the unique shortcode to any page, post, or widget:', 'custom-twitter-feeds' ),
						'description_2' => __( 'Or use the built in WordPress block or widget', 'custom-twitter-feeds' ),
						'addPage' => __( 'Add to a Page', 'custom-twitter-feeds' ),
						'addWidget' => __( 'Add to a Widget', 'custom-twitter-feeds' ),
						'selectPage' => __( 'Select Page', 'custom-twitter-feeds' ),
					),
					'connectAccountScreen' => self::connect_account_secreen(),


			        'links' => self::get_links_with_utm(),
			        'pluginsInfo' => [
						'social_wall' => [
							'installed' => isset( $installed_plugins['social-wall/social-wall.php'] ) ? true : false,
							'activated' => is_plugin_active( 'social-wall/social-wall.php' ),
							'settingsPage' => admin_url( 'admin.php?page=sbsw' ),
						]
					],
					'selectSourceScreen' => self::select_source_screen_text(),
			        'feedTypes' => $this->get_feed_types(),
			        'feedTemplates' => $this->get_feed_templates(),
					'socialInfo' => $this->get_smashballoon_info(),
			        'svgIcons' => $this->builder_svg_icons(),
					'installPluginsPopup' => $this->install_plugins_popup(),
			        'feeds' => self::get_feed_list(),
			        'itemsPerPage'			=> CTF_Db::RESULTS_PER_PAGE,
			        'feedsCount' 			=> CTF_Db::feeds_count(),

			        'sources' => [],
					'sourceConnectionURLs' => [],

					'legacyFeeds' => $this->get_legacy_feed_list(),
			        'extensionsPopup' => [
			        	'socialwall' => [
							//Combine all your social media channels into one Social Wall
							'heading'         => __( 'Combine all your social media channels into one', 'custom-twitter-feeds' ) . ' <span>' . __( 'Social Wall', 'custom-twitter-feeds' ) . '</span>',
							'description' 	=> __( '<span class="sb-social-wall">A dash of Instagram, a sprinkle of Facebook, a spoonful of Twitter, and a dollop of YouTube, all in the same feed.</span>', 'custom-twitter-feeds' ),
							'popupContentBtn' 	=> '<div class="ctf-fb-extpp-lite-btn">' . self::builder_svg_icons()['tag'] . __( 'Twitter Pro users get 50% OFF', 'custom-twitter-feeds' ) .'</div>',
							'img' 			=> '<svg width="397" height="264" viewBox="0 0 397 264" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)"><g filter="url(#filter0_ddd)"><rect x="18.957" y="63" width="113.812" height="129.461" rx="2.8453" fill="white"/></g><g clip-path="url(#clip1)"><path d="M18.957 63H132.769V176.812H18.957V63Z" fill="#0068A0"/><rect x="56.957" y="106" width="105" height="105" rx="9" fill="#005B8C"/></g><path d="M36.0293 165.701C31.4649 165.701 27.7305 169.427 27.7305 174.017C27.7305 178.166 30.7678 181.61 34.7347 182.232V176.423H32.6268V174.017H34.7347V172.183C34.7347 170.1 35.9712 168.954 37.8716 168.954C38.7762 168.954 39.7222 169.112 39.7222 169.112V171.162H38.6766C37.6475 171.162 37.3239 171.801 37.3239 172.456V174.017H39.6309L39.2575 176.423H37.3239V182.232C39.2794 181.924 41.0602 180.926 42.3446 179.419C43.629 177.913 44.3325 175.996 44.3281 174.017C44.3281 169.427 40.5936 165.701 36.0293 165.701Z" fill="#006BFA"/><rect x="53.1016" y="169.699" width="41.2569" height="9.95855" rx="1.42265" fill="#D0D1D7"/><g filter="url(#filter1_ddd)"><rect x="18.957" y="201" width="113.812" height="129.461" rx="2.8453" fill="white"/></g><g clip-path="url(#clip2)"><path d="M18.957 201H132.769V314.812H18.957V201Z" fill="#EC352F"/><circle cx="23.957" cy="243" r="59" fill="#FE544F"/></g><g filter="url(#filter2_ddd)"><rect x="139.957" y="23" width="113.812" height="129.461" rx="2.8453" fill="white"/></g><g clip-path="url(#clip3)"><path d="M139.957 23H253.769V136.812H139.957V23Z" fill="#8C8F9A"/><circle cx="127.457" cy="142.5" r="78.5" fill="#D0D1D7"/></g><path d="M157.026 129.493C154.537 129.493 152.553 131.516 152.553 133.967C152.553 136.456 154.537 138.44 157.026 138.44C159.477 138.44 161.5 136.456 161.5 133.967C161.5 131.516 159.477 129.493 157.026 129.493ZM157.026 136.884C155.431 136.884 154.109 135.601 154.109 133.967C154.109 132.372 155.392 131.088 157.026 131.088C158.621 131.088 159.905 132.372 159.905 133.967C159.905 135.601 158.621 136.884 157.026 136.884ZM162.706 129.338C162.706 128.754 162.239 128.287 161.655 128.287C161.072 128.287 160.605 128.754 160.605 129.338C160.605 129.921 161.072 130.388 161.655 130.388C162.239 130.388 162.706 129.921 162.706 129.338ZM165.662 130.388C165.584 128.987 165.273 127.743 164.262 126.731C163.25 125.72 162.005 125.409 160.605 125.331C159.166 125.253 154.848 125.253 153.408 125.331C152.008 125.409 150.802 125.72 149.752 126.731C148.74 127.743 148.429 128.987 148.351 130.388C148.274 131.827 148.274 136.145 148.351 137.585C148.429 138.985 148.74 140.191 149.752 141.241C150.802 142.253 152.008 142.564 153.408 142.642C154.848 142.719 159.166 142.719 160.605 142.642C162.005 142.564 163.25 142.253 164.262 141.241C165.273 140.191 165.584 138.985 165.662 137.585C165.74 136.145 165.74 131.827 165.662 130.388ZM163.795 139.102C163.523 139.88 162.9 140.463 162.161 140.774C160.994 141.241 158.271 141.124 157.026 141.124C155.742 141.124 153.019 141.241 151.891 140.774C151.113 140.463 150.53 139.88 150.219 139.102C149.752 137.974 149.868 135.25 149.868 133.967C149.868 132.722 149.752 129.999 150.219 128.832C150.53 128.093 151.113 127.509 151.891 127.198C153.019 126.731 155.742 126.848 157.026 126.848C158.271 126.848 160.994 126.731 162.161 127.198C162.9 127.47 163.484 128.093 163.795 128.832C164.262 129.999 164.145 132.722 164.145 133.967C164.145 135.25 164.262 137.974 163.795 139.102Z" fill="url(#paint0_linear)"/><rect x="174.102" y="129.699" width="41.2569" height="9.95855" rx="1.42265" fill="#D0D1D7"/><g filter="url(#filter3_ddd)"><rect x="139.957" y="161" width="114" height="109" rx="2.8453" fill="white"/></g><rect x="148.957" y="194" width="91" height="8" rx="1.42265" fill="#D0D1D7"/><rect x="148.957" y="208" width="51" height="8" rx="1.42265" fill="#D0D1D7"/><path d="M164.366 172.062C163.788 172.324 163.166 172.497 162.521 172.579C163.181 172.182 163.691 171.552 163.931 170.794C163.308 171.169 162.618 171.432 161.891 171.582C161.298 170.937 160.466 170.562 159.521 170.562C157.758 170.562 156.318 172.002 156.318 173.779C156.318 174.034 156.348 174.282 156.401 174.514C153.731 174.379 151.353 173.097 149.771 171.154C149.493 171.627 149.336 172.182 149.336 172.767C149.336 173.884 149.898 174.874 150.768 175.437C150.236 175.437 149.741 175.287 149.306 175.062V175.084C149.306 176.644 150.416 177.949 151.886 178.242C151.414 178.371 150.918 178.389 150.438 178.294C150.642 178.934 151.041 179.493 151.579 179.894C152.117 180.295 152.767 180.517 153.438 180.529C152.301 181.43 150.891 181.916 149.441 181.909C149.186 181.909 148.931 181.894 148.676 181.864C150.101 182.779 151.796 183.312 153.611 183.312C159.521 183.312 162.768 178.407 162.768 174.154C162.768 174.012 162.768 173.877 162.761 173.734C163.391 173.284 163.931 172.714 164.366 172.062Z" fill="#1B90EF"/><g filter="url(#filter4_ddd)"><rect x="260.957" y="63" width="113.812" height="129.461" rx="2.8453" fill="white"/></g><g clip-path="url(#clip4)"><rect x="260.957" y="63" width="113.812" height="113.812" fill="#D72C2C"/><path d="M283.359 103.308L373.461 193.41H208.793L283.359 103.308Z" fill="#DF5757"/></g><path d="M276.37 176.456L280.677 173.967L276.37 171.477V176.456ZM285.963 169.958C286.071 170.348 286.145 170.871 286.195 171.535C286.253 172.199 286.278 172.772 286.278 173.27L286.328 173.967C286.328 175.784 286.195 177.12 285.963 177.975C285.755 178.722 285.274 179.203 284.527 179.411C284.137 179.519 283.423 179.593 282.328 179.643C281.249 179.701 280.262 179.726 279.349 179.726L278.029 179.776C274.552 179.776 272.386 179.643 271.531 179.411C270.784 179.203 270.303 178.722 270.096 177.975C269.988 177.585 269.913 177.062 269.863 176.398C269.805 175.734 269.78 175.162 269.78 174.664L269.73 173.967C269.73 172.149 269.863 170.813 270.096 169.958C270.303 169.212 270.784 168.73 271.531 168.523C271.921 168.415 272.635 168.34 273.73 168.29C274.809 168.232 275.797 168.207 276.71 168.207L278.029 168.158C281.506 168.158 283.672 168.29 284.527 168.523C285.274 168.73 285.755 169.212 285.963 169.958Z" fill="#EB2121"/><rect x="295.102" y="169.699" width="41.2569" height="9.95855" rx="1.42265" fill="#D0D1D7"/><g filter="url(#filter5_ddd)"><rect x="260.957" y="201" width="113.812" height="129.461" rx="2.8453" fill="white"/></g><g clip-path="url(#clip5)"><rect x="260.957" y="201" width="113.812" height="113.812" fill="#59AB46"/><circle cx="374.457" cy="235.5" r="44.5" fill="#468737"/></g><g clip-path="url(#clip6)"><path d="M139.957 228H253.957V296C253.957 296.552 253.509 297 252.957 297H140.957C140.405 297 139.957 296.552 139.957 296V228Z" fill="#0068A0"/><circle cx="227.957" cy="245" r="34" fill="#004D77"/></g></g><defs><filter id="filter0_ddd" x="0.462572" y="53.0414" width="150.801" height="166.45" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="8.5359"/><feGaussianBlur stdDeviation="9.24723"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.42265"/><feGaussianBlur stdDeviation="1.42265"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/><feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4.26795"/><feGaussianBlur stdDeviation="4.26795"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/><feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/><feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/></filter><filter id="filter1_ddd" x="0.462572" y="191.041" width="150.801" height="166.45" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="8.5359"/><feGaussianBlur stdDeviation="9.24723"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.42265"/><feGaussianBlur stdDeviation="1.42265"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/><feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4.26795"/><feGaussianBlur stdDeviation="4.26795"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/><feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/><feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/></filter><filter id="filter2_ddd" x="121.463" y="13.0414" width="150.801" height="166.45" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="8.5359"/><feGaussianBlur stdDeviation="9.24723"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.42265"/><feGaussianBlur stdDeviation="1.42265"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/><feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4.26795"/><feGaussianBlur stdDeviation="4.26795"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/><feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/><feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/></filter><filter id="filter3_ddd" x="121.463" y="151.041" width="150.989" height="145.989" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="8.5359"/><feGaussianBlur stdDeviation="9.24723"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.42265"/><feGaussianBlur stdDeviation="1.42265"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/><feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4.26795"/><feGaussianBlur stdDeviation="4.26795"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/><feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/><feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/></filter><filter id="filter4_ddd" x="242.463" y="53.0414" width="150.801" height="166.45" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="8.5359"/><feGaussianBlur stdDeviation="9.24723"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.42265"/><feGaussianBlur stdDeviation="1.42265"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/><feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4.26795"/><feGaussianBlur stdDeviation="4.26795"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/><feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/><feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/></filter><filter id="filter5_ddd" x="242.463" y="191.041" width="150.801" height="166.45" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="8.5359"/><feGaussianBlur stdDeviation="9.24723"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.42265"/><feGaussianBlur stdDeviation="1.42265"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/><feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4.26795"/><feGaussianBlur stdDeviation="4.26795"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/><feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/><feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/></filter><linearGradient id="paint0_linear" x1="154.502" y1="158.603" x2="191.208" y2="121.133" gradientUnits="userSpaceOnUse"><stop stop-color="white"/><stop offset="0.147864" stop-color="#F6640E"/><stop offset="0.443974" stop-color="#BA03A7"/><stop offset="0.733337" stop-color="#6A01B9"/><stop offset="1" stop-color="#6B01B9"/></linearGradient><clipPath id="clip0"><rect width="396" height="264" fill="white" transform="translate(0.957031)"/></clipPath><clipPath id="clip1"><path d="M18.957 65.3711C18.957 64.0616 20.0186 63 21.3281 63H130.398C131.708 63 132.769 64.0616 132.769 65.3711V156.895H18.957V65.3711Z" fill="white"/></clipPath><clipPath id="clip2"><path d="M18.957 203.371C18.957 202.062 20.0186 201 21.3281 201H130.398C131.708 201 132.769 202.062 132.769 203.371V294.895H18.957V203.371Z" fill="white"/></clipPath><clipPath id="clip3"><path d="M139.957 25.3711C139.957 24.0616 141.019 23 142.328 23H251.398C252.708 23 253.769 24.0616 253.769 25.3711V116.895H139.957V25.3711Z" fill="white"/></clipPath><clipPath id="clip4"><path d="M260.957 65.3711C260.957 64.0616 262.019 63 263.328 63H372.398C373.708 63 374.769 64.0616 374.769 65.3711V156.895H260.957V65.3711Z" fill="white"/></clipPath><clipPath id="clip5"><path d="M260.957 203.371C260.957 202.062 262.019 201 263.328 201H372.398C373.708 201 374.769 202.062 374.769 203.371V294.895H260.957V203.371Z" fill="white"/></clipPath><clipPath id="clip6"><path d="M139.957 228H253.957V296C253.957 296.552 253.509 297 252.957 297H140.957C140.405 297 139.957 296.552 139.957 296V228Z" fill="white"/></clipPath></defs></svg>',
							'demoUrl' 		=> 'https://smashballoon.com/social-wall/demo/?utm_campaign=twitter-pro&utm_source=feed-type&utm_medium=social-wall&utm_content=learn-more',
							'buyUrl' 		=> sprintf('https://smashballoon.com/pricing/all-access/?license_key=%s&upgrade=true&utm_campaign=twitter-pro&utm_source=feed-type&utm_medium=social-wall&utm_content=upgrade', $license_key),
							'homeUrl' 		=> admin_url( 'admin.php?page=sbsw' ),
							'bullets'       => [
								'heading' => __( 'Upgrade to the All Access Bundle and get:', 'custom-twitter-feeds' ),
								'content' => [
									__( 'Custom Facebook Feed Pro', 'custom-twitter-feeds' ),
									__( 'All Pro Facebook Extensions', 'custom-twitter-feeds' ),
									__( 'Custom Twitter Feeds Pro', 'custom-twitter-feeds' ),
									__( 'Instagram Feed Pro', 'custom-twitter-feeds' ),
									__( 'YouTube Feeds Pro', 'custom-twitter-feeds' ),
									__( 'Social Wall Pro', 'custom-twitter-feeds' ),
								]
							],
						]
			       	],

        		);
        		$maybe_feed_customizer_data = CTF_Feed_Saver_Manager::maybe_feed_customizer_data();
        		$maybe_new_account = self::connect_new_account( $_GET );
        		if( $maybe_new_account !== false ){
		        	$ctf_builder['newAccountData'] =  $maybe_new_account;
		        	$ctf_options = get_option('ctf_options', array());
        		}

        		$ctf_builder['accountDetails'] = [
					'access_token' 			=> isset($ctf_options['access_token']) ? $ctf_options['access_token'] : '' ,
					'access_token_secret' 	=> isset($ctf_options['access_token_secret']) ? $ctf_options['access_token_secret'] : '' ,
					'account_handle' 		=> isset($ctf_options['account_handle']) ? $ctf_options['account_handle'] : '' ,
					'account_avatar' 		=> isset($ctf_options['account_avatar']) ? $ctf_options['account_avatar'] : ''
				];
				$ctf_builder['appCredentials']    = self::get_app_credentials( $ctf_options );

        		$appOAUTHURL = OAUTH_PROCESSOR_URL . admin_url( 'admin.php?page=ctf-feed-builder' );
        		if( $maybe_feed_customizer_data ){

        			$appOAUTHURL = OAUTH_PROCESSOR_URL . admin_url( 'admin.php?page=ctf-feed-builder&feed_id=' . $_GET['feed_id'] );

        			ctf_scripts_and_styles_pro(true);
		        	$ctf_builder['customizerFeedData'] 			=  $maybe_feed_customizer_data;
		        	$ctf_builder['customizerSidebarBuilder'] 	=  \TwitterFeed\Builder\Tabs\CTF_Builder_Customizer_Tab::get_customizer_tabs();
		        	$ctf_builder['wordpressPageLists']			= $this->get_wp_pages();

					if ( ! isset( $_GET['feed_id'] ) || $_GET['feed_id'] === 'legacy' ) {
						$feed_id                       = 'legacy';
						$customizer_atts               = $maybe_feed_customizer_data['settings'];
						$customizer_atts['customizer'] = true;
		        	} elseif ( intval( $_GET['feed_id'] ) > 0 ) {
						$feed_id         = intval( $_GET['feed_id'] );
						$customizer_atts = array(
							'feed'       => $feed_id,
							'customizer' => true,
						);
					}
		        	if(  ! empty( $feed_id ) ){
			        	$settings_preview = self::add_customizer_att( $customizer_atts );
		        		$ctf_builder['feedInitOutput'] = htmlspecialchars(ctf_init( $settings_preview ));
		        	}


		        	//Date
		        	global $wp_locale;
		        	wp_enqueue_script(
		        		"ctf-date_i18n", CTF_PLUGIN_URL.'admin/builder/assets/js/date_i18n.js',
		        		null,
		        		CTF_VERSION,
		        		true
		        	);

					$monthNames = array_map(
						array(&$wp_locale, 'get_month'),
						range(1, 12)
					);
					$monthNamesShort = array_map(
						array(&$wp_locale, 'get_month_abbrev'),
						$monthNames
					);
					$dayNames = array_map(
						array(&$wp_locale, 'get_weekday'),
						range(0, 6)
					);
					$dayNamesShort = array_map(
						array(&$wp_locale, 'get_weekday_abbrev'),
						$dayNames
					);
					wp_localize_script("ctf-date_i18n",
						"DATE_I18N", array(
						  "month_names" => $monthNames,
						  "month_names_short" => $monthNamesShort,
						  "day_names" => $dayNames,
						  "day_names_short" => $dayNamesShort
						)
					);
		        }

		        $ctf_builder['appOAUTH']			= $appOAUTHURL;

		        wp_enqueue_style(
		        	'ctf-builder-style',
		        	CTF_PLUGIN_URL . 'admin/builder/assets/css/builder.css',
		        	false,
		        	CTF_VERSION
		        );

		        self::global_enqueue_ressources_scripts();

		        wp_enqueue_script(
		        	'ctf-builder-app',
		        	CTF_PLUGIN_URL.'admin/builder/assets/js/builder.js',
		        	null,
		        	CTF_VERSION,
		        	true
		        );
		        // Customize screens
		        $ctf_builder['customizeScreens'] = $this->get_customize_screens_text();
		        wp_localize_script(
		        	'ctf-builder-app',
		        	'ctf_builder',
		        	$ctf_builder
		        );
 				wp_enqueue_media();
 			endif;
		endif;
	}

	/**
	 * Connect New Account
	 *
	 * Checks if there is a returned account
	 *
	 * @since 2.0
	 */
	public static function connect_new_account( $data ){
		if( isset( $data ) ){
			if( isset( $data['oauth_token'] ) && isset( $data['oauth_token_secret'] ) && isset( $data['screen_name'] ) ){
	        	$options = get_option( 'ctf_options', array() );
				$auth = [
					'connectAccount' 			=> true,
					'access_token' 				=> $data['oauth_token'],
					'access_token_secret' 		=> $data['oauth_token_secret'],
					'account_handle' 			=> $data['screen_name']
				];

				$details = CTF_Feed_Builder::get_account_info( $auth );
		        if( !isset( $details['error'] ) ){
		        	$options['access_token'] 		= $auth['access_token'];
		        	$options['access_token_secret'] = $auth['access_token_secret'];
		        	$options['account_handle'] 		= $details['account_handle'];
		        	$options['account_avatar'] 		= $details['account_avatar'];
		        	$auth['account_avatar'] 		= $details['account_avatar'];
		        	update_option( 'ctf_options', $options );
		        }
		        return $auth;
			}elseif( isset( $data['error'] ) ){
				return [
					'connectAccount' 	=> false
				];
			}
		}
		return false;
	}

	/**
	 * Get Account Info
	 * Screen Name + Avatar
	 *
	 *
	 * @since 2.0
	 */
	public static function get_account_info( $auth ){
		$consumer_key = ! empty( $auth['consumer_key'] ) ? $auth['consumer_key'] : 'FPYSYWIdyUIQ76Yz5hdYo5r7y';
		$consumer_secret = ! empty( $auth['consumer_secret'] ) ? $auth['consumer_secret'] : 'GqPj9BPgJXjRKIGXCULJljocGPC62wN2eeMSnmZpVelWreFk9z';
		$request_settings = array(
			'consumer_key' => $consumer_key,
			'consumer_secret' =>  $consumer_secret,
			'access_token' =>  $auth['access_token'],
			'access_token_secret' =>  $auth['access_token_secret']
		);
		$request_method = 'auto';
		$twitter_api = new CtfOauthConnectPro( $request_settings, 'accountlookup' );
		$twitter_api->setUrlBase();
		$twitter_api->setRequestMethod( $request_method );
		$twitter_api->performRequest();
		$response = json_decode( $twitter_api->json , $assoc = true );
		if( isset( $response['errors'] ) ){
	    	return [
	    		'error' => true
	    	];
	    }else{
	    	return[
	    		'account_handle' => isset( $response['screen_name'] ) ? sanitize_text_field($response['screen_name']) : '',
		        'account_avatar' =>isset( $response['profile_image_url'] ) ? sanitize_text_field($response['profile_image_url']) : ''
	    	];
	    }
	}

	/**
	 * Get WP Pages List
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_wp_pages(){
		$pagesList = get_pages();
		$pagesResult = [];
		if(is_array($pagesList)){
			foreach ($pagesList as $page) {
				array_push($pagesResult, ['id' => $page->ID, 'title' => $page->post_title]);
			}
		}
		return $pagesResult;
	}


	/**
	 * Global JS + CSS Files
	 *
	 * Shared JS + CSS ressources for the admin panel
	 *
	 * @since 2.0
	 */
   public static function global_enqueue_ressources_scripts($is_settings = false){
	   	wp_enqueue_style(
	   		'feed-global-style',
	   		CTF_PLUGIN_URL . 'admin/builder/assets/css/global.css',
	   		false,
	   		CTF_VERSION
	   	);
	   	wp_enqueue_script(
			'feed-builder-vue',
			'https://cdn.jsdelivr.net/npm/vue@2.6.12',
			null,
			"2.6.12",
			true
		);
	   	/*
	   	wp_enqueue_script(
			'feed-builder-vue',
			'https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js?ver=2.6.12',
			null,
			"2.6.12",
			true
		);
	   	*/




		wp_enqueue_script(
			'feed-colorpicker-vue',
			CTF_PLUGIN_URL.'admin/builder/assets/js/vue-color.min.js',
			null,
			CTF_VERSION,
			true
		);

		wp_enqueue_script(
	   		'feed-builder-ressources',
	   		CTF_PLUGIN_URL.'admin/builder/assets/js/ressources.js',
	   		null,
	   		CTF_VERSION,
	   		true
	   	);

	   	wp_enqueue_script(
	   		'sb-dialog-box',
	   		CTF_PLUGIN_URL.'admin/builder/assets/js/confirm-dialog.js',
	   		null,
	   		CTF_VERSION,
	   		true
	   	);

	   	wp_enqueue_script(
	   		'install-plugin-popup',
	   		CTF_PLUGIN_URL.'admin/builder/assets/js/install-plugin-popup.js',
	   		null,
	   		CTF_VERSION,
	   		true
	   	);

	}

	/**
	 * Get Generic text
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_generic_text(){
		$icons = CTF_Feed_Builder::builder_svg_icons();
		return array(
			'done' => __( 'Done', 'custom-twitter-feeds' ),
			'title' => __( 'Settings', 'custom-twitter-feeds' ),
			'dashboard' => __( 'Dashboard', 'custom-twitter-feeds' ),
			'addNew' => __( 'Add New', 'custom-twitter-feeds' ),
			'addNewList' => __( 'Add list by ID', 'custom-twitter-feeds' ),
			'connect' => __( 'Connect', 'custom-twitter-feeds' ),

			'addSource' => __( 'Add Source', 'custom-twitter-feeds' ),
			'addAnotherSource' => __( 'Add another Source', 'custom-twitter-feeds' ),
			'addSourceType' => __( 'Add Another Source Type', 'custom-twitter-feeds' ),
			'previous' => __( 'Previous', 'custom-twitter-feeds' ),
			'next' => __( 'Next', 'custom-twitter-feeds' ),
			'finish' => __( 'Finish', 'custom-twitter-feeds' ),
			'new' => __( 'New', 'custom-twitter-feeds' ),
			'update' => __( 'Update', 'custom-twitter-feeds' ),
			'upgrade' => __( 'Upgrade', 'custom-twitter-feeds' ),
			'settings' => __( 'Settings', 'custom-twitter-feeds' ),
			'back' => __( 'Back', 'custom-twitter-feeds' ),
			'backAllFeeds' => __( 'Back to all feeds', 'custom-twitter-feeds' ),
			'createFeed' => __( 'Create Feed', 'custom-twitter-feeds' ),
			'add' => __( 'Add', 'custom-twitter-feeds' ),
			'change' => __( 'Change', 'custom-twitter-feeds' ),
			'getExtention' => __( 'Get Extension', 'custom-twitter-feeds' ),
			'viewDemo' => __( 'View Demo', 'custom-twitter-feeds' ),
			'includes' => __( 'Includes', 'custom-twitter-feeds' ),
			'photos' => __( 'Photos', 'custom-twitter-feeds' ),
			'photo' => __( 'Photo', 'custom-twitter-feeds' ),
			'apply' => __( 'Apply', 'custom-twitter-feeds' ),
			'copy' => __( 'Copy', 'custom-twitter-feeds' ),
			'edit' => __( 'Edit', 'custom-twitter-feeds' ),
			'duplicate' => __( 'Duplicate', 'custom-twitter-feeds' ),
			'delete' => __( 'Delete', 'custom-twitter-feeds' ),
			'remove' => __( 'Remove', 'custom-twitter-feeds' ),
			'removeSource' => __( 'Remove Source', 'custom-twitter-feeds' ),
			'atLeastOneSource' => __( 'You need to have<br/>atleast one source', 'custom-twitter-feeds' ),
			'shortcode' => __( 'Shortcode', 'custom-twitter-feeds' ),
			'clickViewInstances' => __( 'Click to view Instances', 'custom-twitter-feeds' ),
			'usedIn' => __( 'Used in', 'custom-twitter-feeds' ),
			'place' => __( 'place', 'custom-twitter-feeds' ),
			'places' => __( 'places', 'custom-twitter-feeds' ),
			'item' => __( 'Item', 'custom-twitter-feeds' ),
			'items' => __( 'Items', 'custom-twitter-feeds' ),
			'learnMore' => __( 'Learn More', 'custom-twitter-feeds' ),
			'location' => __( 'Location', 'custom-twitter-feeds' ),
			'isAlreadyAdded' => __( ' is already added', 'custom-twitter-feeds' ),
			'page' => __( 'Page', 'custom-twitter-feeds' ),
			'copiedClipboard' => __( 'Copied to Clipboard', 'custom-twitter-feeds' ),
			'feedImported' => __( 'Feed imported successfully', 'custom-twitter-feeds' ),
			'failedToImportFeed' => __( 'Failed to import feed', 'custom-twitter-feeds' ),
			'timeline' => __( 'Timeline', 'custom-twitter-feeds' ),
			'help' => __( 'Help', 'custom-twitter-feeds' ),
			'admin' => __( 'Admin', 'custom-twitter-feeds' ),
			'member' => __( 'Member', 'custom-twitter-feeds' ),
			'reset' => __( 'Reset', 'custom-twitter-feeds' ),
			'preview' => __( 'Preview', 'custom-twitter-feeds' ),
			'name' => __( 'Name', 'custom-twitter-feeds' ),
			'id' => __( 'ID', 'custom-twitter-feeds' ),
			'token' => __( 'Token', 'custom-twitter-feeds' ),
			'confirm' => __( 'Confirm', 'custom-twitter-feeds' ),
			'cancel' => __( 'Cancel', 'custom-twitter-feeds' ),
			'clear' => __( 'Clear', 'custom-twitter-feeds' ),
			'clearFeedCache' => __( 'Clear Feed Cache', 'custom-twitter-feeds' ),
			'saveSettings' => __( 'Save Changes', 'custom-twitter-feeds' ),
			'feedName' => __( 'Feed Name', 'custom-twitter-feeds' ),
			'shortcodeText' => __( 'Shortcode', 'custom-twitter-feeds' ),
			'general' => __( 'General', 'custom-twitter-feeds' ),
			'feeds' => __( 'Feeds', 'custom-twitter-feeds' ),
			'translation' => __( 'Translation', 'custom-twitter-feeds' ),
			'advanced' => __( 'Advanced', 'custom-twitter-feeds' ),
			'error' => __( 'Error:', 'custom-twitter-feeds' ),
			'errorNotice' => __( 'There was an error when trying to connect to Twitter.', 'custom-twitter-feeds' ),
			'errorDirections' => '<a href="https://smashballoon.com/custom-twitter-feeds/docs/errors/" target="_blank" rel="nofollow noopener">' . __( 'Directions on How to Resolve This Issue', 'custom-twitter-feeds' )  . '</a>',
			'errorSource' => __( 'Source Invalid', 'custom-twitter-feeds' ),
			'invalid' => __( 'Invalid', 'custom-twitter-feeds' ),
			'reconnect' => __( 'Reconnect', 'custom-twitter-feeds' ),
			'feed' => __( 'feed', 'custom-twitter-feeds' ),
			'sourceNotUsedYet' => __( 'Source is not used yet', 'custom-twitter-feeds' ),
			'addImage' => __( 'Add Image', 'custom-twitter-feeds' ),
			'businessRequired' => __( 'Business Account required', 'custom-twitter-feeds' ),
			'selectedPost' => __( 'Selected Post', 'custom-twitter-feeds' ),
			'selected' => __( 'Selected', 'custom-twitter-feeds' ),
			'deselectAll' => __( 'Deselect All', 'custom-twitter-feeds' ),

			'productLink' => __( 'Product Link', 'custom-twitter-feeds' ),
			'enterProductLink' => __( 'Add your product URL here', 'custom-twitter-feeds' ),
			'editSources' => __( 'Edit Sources', 'custom-twitter-feeds' ),
			'moderateFeed' => __( 'Moderate your feed', 'custom-twitter-feeds' ),
			'moderateFeedSaveExit' => __( 'Save and Exit', 'custom-twitter-feeds' ),
			'moderationMode' => __( 'Moderation Mode', 'custom-twitter-feeds' ),
			'moderationModeEnterPostId' => __( 'Or Enter Post IDs to hide manually', 'custom-twitter-feeds' ),
			'moderationModeTextareaPlaceholder' => __( 'Add words here to hide any posts containing these words', 'custom-twitter-feeds' ),
			'filtersAndModeration' => __( 'Filters & Moderation', 'custom-twitter-feeds' ),
			'topRated' => __( 'Top Rated', 'custom-twitter-feeds' ),
			'mostRecent' => __( 'Most recent', 'custom-twitter-feeds' ),
			'moderationModePreview' => __( 'Moderation Mode Preview', 'custom-twitter-feeds' ),
			'connectDifferentAccount' => __( 'Connect a different account', 'custom-twitter-feeds' ),
			'showing' => __( 'Showing', 'custom-twitter-feeds' ),
			'lists' => __( 'Lists', 'custom-twitter-feeds' ),
			'createdBy' => __( 'created by', 'custom-twitter-feeds' ),
			'twitterDifferentHandle' => __( 'You can display public lists for any Twitter handle', 'custom-twitter-feeds' ),
			'enterListID'  => __( 'Enter one or more list IDs (separated by comma)', 'custom-twitter-feeds' ),
			'searchListUser'  => __( 'Or search and add lists by any Twitter user', 'custom-twitter-feeds' ),
			'enterUserName'  => __( 'Enter Twitter username', 'custom-twitter-feeds' ),
			'showLists'  => __( 'Show Lists', 'custom-twitter-feeds' ),
			'showingPublicLists'  => __( 'Showing public lists created by ', 'custom-twitter-feeds' ),
			'couldntFetchList'  => __( 'We could not find any lists created by ', 'custom-twitter-feeds' ),
			'tryDifferentName'  => __( 'Try again with a different username.', 'custom-twitter-feeds' ),
			'errorManualAccount'  => __( 'Something went wrong! Try with different credentials.', 'custom-twitter-feeds' ),
			'successManualAccount'  => __( 'Account added successfully.', 'custom-twitter-feeds' ),

			'notification' => array(
				'feedSaved' => array(
					'type' => 'success',
					'text' => __( 'Feed saved successfully', 'custom-twitter-feeds' )
				),
				'feedSavedError' => array(
					'type' => 'error',
					'text' => __( 'Error saving Feed', 'custom-twitter-feeds' )
				),
				'previewUpdated' => array(
					'type' => 'success',
					'text' => __( 'Preview updated successfully', 'custom-twitter-feeds' )
				),
				'carouselLayoutUpdated' => array(
					'type' => 'success',
					'text' => __( 'Carousel updated successfully', 'custom-twitter-feeds' )
				),
				'unkownError' => array(
					'type' => 'error',
					'text' => __( 'Unknown error occurred', 'custom-twitter-feeds' )
				),
				'cacheCleared' => array(
					'type' => 'success',
					'text' => __( 'Feed cache cleared', 'custom-twitter-feeds' )
				),
				'selectSourceError' => array(
					'type' => 'error',
					'text' => __( 'Please select a source for your feed', 'custom-twitter-feeds' )
				),
				'commentCacheCleared' => array(
					'type' => 'success',
					'text' => __( 'Comment cache cleared', 'custom-twitter-feeds' )
				),
			),
			'install' => __( 'Install', 'custom-twitter-feeds' ),
			'installed' => __( 'Installed', 'custom-twitter-feeds' ),
			'activate' => __( 'Activate', 'custom-twitter-feeds' ),
			'installedAndActivated' => __( 'Installed & Activated', 'custom-twitter-feeds' ),
			'free' => __( 'Free', 'custom-twitter-feeds' ),
			'invalidLicenseKey' => __( 'Invalid license key', 'custom-twitter-feeds' ),
			'licenseActivated' => __( 'License activated', 'custom-twitter-feeds' ),
			'licenseDeactivated' => __( 'License Deactivated', 'custom-twitter-feeds' ),
			'carouselLayoutUpdated'=> array(
				'type' => 'success',
				'text' => __( 'Carousel Layout updated', 'custom-twitter-feeds' )
			),
			'getMoreFeatures' => __( 'Get more features with Custom Facebook Feed Pro', 'custom-twitter-feeds' ),
			'liteFeedUsers' => __( 'Lite Feed Users get 50% OFF', 'custom-twitter-feeds' ),
			'tryDemo' => __( 'Try Demo', 'custom-twitter-feeds' ),
			'displayImagesVideos' => __( 'Display images and videos in posts', 'custom-twitter-feeds' ),
			'viewLikesShares' => __( 'View likes, shares and comments', 'custom-twitter-feeds' ),
			'allFeedTypes' => __( 'All Feed Types: Photos, Albums, Events and more', 'custom-twitter-feeds' ),
			'abilityToLoad' => __( 'Ability to “Load More” posts', 'custom-twitter-feeds' ),
			'andMuchMore' => __( 'And Much More!', 'custom-twitter-feeds' ),
			'ctfFreeCTAFeatures' => array(
				__( 'Filter posts', 'custom-twitter-feeds' ),
				__( 'Popup photo/video lighbox', 'custom-twitter-feeds' ),
				__( '30 day money back guarantee', 'custom-twitter-feeds' ),
				__( 'Multiple post layout options', 'custom-twitter-feeds' ),
				__( 'Video player (HD, 360, Live)', 'custom-twitter-feeds' ),
				__( 'Fast, friendly and effective support', 'custom-twitter-feeds' ),
			),
			'ctaShowFeatures' => __( 'Show Features', 'custom-twitter-feeds' ),
			'ctaHideFeatures' => __( 'Hide Features', 'custom-twitter-feeds' ),
			'redirectLoading' => array(
				'heading' =>  __( 'Redirecting to connect.smashballoon.com', 'custom-twitter-feeds' ),
				'description' =>  __( 'You will be redirected to our app so you can connect your account in 5 seconds', 'custom-twitter-feeds' ),
			),
			'goSocialWall' => __( 'Create Social Wall Feed', 'custom-twitter-feeds' ),
		);
	}

	/**
	 * Select Source Screen Text
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function select_source_screen_text() {
		return array(
			'mainHeading' => __( 'Select one or more sources', 'custom-twitter-feeds' ),
			'description' => __( 'Sources are Twitter accounts your feed will display content from', 'custom-twitter-feeds' ),
			'emptySourceDescription' => __( 'Looks like you have not added any source.<br/>Use “Add Source” to add a new one.', 'custom-twitter-feeds' ),
			'mainHashtagHeading' => __( 'Enter Public Hashtags', 'custom-twitter-feeds' ),
			'hashtagDescription' => __( 'Add one or more hashtag separated by comma', 'custom-twitter-feeds' ),
			'hashtagGetBy' => __( 'Fetch posts that are', 'custom-twitter-feeds' ),

			'sourcesListPopup' => array(
				'user' => array(
					'mainHeading' => __( 'Add a source for Timeline', 'custom-twitter-feeds' ),
					'description' => __( 'Select or add an account you want to display the timeline for', 'custom-twitter-feeds' ),
				),
				'tagged' => array(
					'mainHeading' => __( 'Add a source for Mentions', 'custom-twitter-feeds' ),
					'description' => __( 'Select or add an account you want to display the mentions for', 'custom-twitter-feeds' ),
				)
			),

			'perosnalAccountToolTipTxt' => array(
				__( 'Due to changes in Instagram’s new API, we can no<br/>
					longer get mentions for personal accounts. To<br/>
					enable this for your account, you will need to convert it to<br/>
					a Business account. Learn More', 'custom-twitter-feeds' ),
			),
			'groupsToolTip' => array(
				__( 'Due to Facebook limitations, it\'s not possible to display photo feeds from a Group, only a Page.', 'custom-twitter-feeds' )
			),
			'updateHeading' => __( 'Update Source', 'custom-twitter-feeds' ),
			'updateDescription' => __( 'Select a source from your connected Facebook Pages and Groups. Or, use "Add New" to connect a new one.', 'custom-twitter-feeds' ),
			'updateFooter' => __( 'Add multiple Facebook Pages or Groups to a feed with our Multifeed extension', 'custom-twitter-feeds' ),
			'noSources' => __( 'Please add a source in order to display a feed. Go to the "Settings" tab -> "Sources" section -> Click "Add New" to connect a source.', 'custom-twitter-feeds' ),

			'multipleTypes' => array(
				'usertimeline' => [
					'heading' 			=> __( 'User Timeline', 'custom-twitter-feeds' ),
					'icon' 				=> 'user',
					'description' 		=> __( 'Add one or more Twitter handles separated by comma', 'custom-twitter-feeds' ),
					'placeHolder'		=> __( '@gopro, @wpbeginner', 'custom-twitter-feeds' ),
					'actionType' 		=> 'inputField'
				],
				'hashtag' => [
					'heading' => __( 'Hashtag', 'custom-twitter-feeds' ),
					'icon' => 'hashtag',
					'description' => __( 'Add one or more hashtag separated by comma.', 'custom-twitter-feeds' ),
					'placeHolder'		=> __( '#hashtag1, #hashtag2', 'custom-twitter-feeds' ),
					'actionType' 		=> 'inputField'
				],
				'hometimeline' => [
					'heading' => __( 'Home Timeline', 'custom-twitter-feeds' ),
					'icon' => 'homeTimeline',
					'description' => __( 'Connect an account to show home timeline. This does not give us any permission to manage your twitter account.', 'custom-twitter-feeds' ),
					'actionType' 		=> 'connectAccount'
				],
				'search' => [
					'heading' => __( 'Search', 'custom-twitter-feeds' ),
					'icon' => 'search',
					'description' => __( 'Add a search term. You can also fine tune your search using powerful search filters. Learn More.', 'custom-twitter-feeds' ),
					'placeHolder'		=> __( 'Enter Search Term', 'custom-twitter-feeds' ),
					'actionType' 		=> 'inputField'
				],
				'mentionstimeline' => [
					'heading' => __( 'Mentions', 'custom-twitter-feeds' ),
					'icon' => 'mention',
					'description' => __( 'Connect an account to show mentions. This does not give us any permission to manage your twitter account.', 'custom-twitter-feeds' ),
					'actionType' 		=> 'connectAccount'
				],
				'lists' => [
					'heading' => __( 'Lists', 'custom-twitter-feeds' ),
					'icon' => 'lists',
					'description' => __( 'Select any public list.', 'custom-twitter-feeds' ),
					'actionType' 		=> 'customList'
				]
			),

			'footer' => array(
				'heading' => __( 'Add feeds for popular social platforms with <span>our other plugins</span>', 'custom-twitter-feeds' ),
			),
			'personal' => __( 'Personal', 'custom-twitter-feeds' ),
			'business' => __( 'Business', 'custom-twitter-feeds' ),
			'notSure' => __( "I'm not sure", 'custom-twitter-feeds' ),
		);
	}

	/**
	 * For Other Platforms listed on the footer widget
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function builder_svg_icons() {
		$builder_svg_icons = [
			'youtube' 		=> '<svg viewBox="0 0 14 11" fill="none"><path d="M5.66683 7.5L9.12683 5.5L5.66683 3.5V7.5ZM13.3735 2.28C13.4602 2.59334 13.5202 3.01334 13.5602 3.54667C13.6068 4.08 13.6268 4.54 13.6268 4.94L13.6668 5.5C13.6668 6.96 13.5602 8.03334 13.3735 8.72C13.2068 9.32 12.8202 9.70667 12.2202 9.87334C11.9068 9.96 11.3335 10.02 10.4535 10.06C9.58683 10.1067 8.7935 10.1267 8.06016 10.1267L7.00016 10.1667C4.20683 10.1667 2.46683 10.06 1.78016 9.87334C1.18016 9.70667 0.793496 9.32 0.626829 8.72C0.540163 8.40667 0.480163 7.98667 0.440163 7.45334C0.393496 6.92 0.373496 6.46 0.373496 6.06L0.333496 5.5C0.333496 4.04 0.440163 2.96667 0.626829 2.28C0.793496 1.68 1.18016 1.29334 1.78016 1.12667C2.0935 1.04 2.66683 0.980002 3.54683 0.940002C4.4135 0.893336 5.20683 0.873336 5.94016 0.873336L7.00016 0.833336C9.7935 0.833336 11.5335 0.940003 12.2202 1.12667C12.8202 1.29334 13.2068 1.68 13.3735 2.28Z"/></svg>',
			'twitter' 		=> '<svg viewBox="0 0 14 12" fill="none"><path d="M13.9735 1.50001C13.4602 1.73334 12.9069 1.88667 12.3335 1.96001C12.9202 1.60667 13.3735 1.04667 13.5869 0.373338C13.0335 0.706672 12.4202 0.940005 11.7735 1.07334C11.2469 0.500005 10.5069 0.166672 9.66686 0.166672C8.10019 0.166672 6.82019 1.44667 6.82019 3.02667C6.82019 3.25334 6.84686 3.47334 6.89352 3.68001C4.52019 3.56001 2.40686 2.42 1.00019 0.693338C0.753522 1.11334 0.613522 1.60667 0.613522 2.12667C0.613522 3.12 1.11352 4 1.88686 4.5C1.41352 4.5 0.973522 4.36667 0.586856 4.16667V4.18667C0.586856 5.57334 1.57352 6.73334 2.88019 6.99334C2.46067 7.10814 2.02025 7.12412 1.59352 7.04C1.77459 7.60832 2.12921 8.10561 2.60753 8.46196C3.08585 8.81831 3.66382 9.0158 4.26019 9.02667C3.24928 9.82696 1.99619 10.2595 0.706855 10.2533C0.480189 10.2533 0.253522 10.24 0.0268555 10.2133C1.29352 11.0267 2.80019 11.5 4.41352 11.5C9.66686 11.5 12.5535 7.14 12.5535 3.36C12.5535 3.23334 12.5535 3.11334 12.5469 2.98667C13.1069 2.58667 13.5869 2.08 13.9735 1.50001Z"/></svg>',
			'instagram' 	=> '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 4.50781C6.5 4.50781 4.50781 6.53906 4.50781 9C4.50781 11.5 6.5 13.4922 9 13.4922C11.4609 13.4922 13.4922 11.5 13.4922 9C13.4922 6.53906 11.4609 4.50781 9 4.50781ZM9 11.9297C7.39844 11.9297 6.07031 10.6406 6.07031 9C6.07031 7.39844 7.35938 6.10938 9 6.10938C10.6016 6.10938 11.8906 7.39844 11.8906 9C11.8906 10.6406 10.6016 11.9297 9 11.9297ZM14.7031 4.35156C14.7031 3.76562 14.2344 3.29688 13.6484 3.29688C13.0625 3.29688 12.5938 3.76562 12.5938 4.35156C12.5938 4.9375 13.0625 5.40625 13.6484 5.40625C14.2344 5.40625 14.7031 4.9375 14.7031 4.35156ZM17.6719 5.40625C17.5938 4 17.2812 2.75 16.2656 1.73438C15.25 0.71875 14 0.40625 12.5938 0.328125C11.1484 0.25 6.8125 0.25 5.36719 0.328125C3.96094 0.40625 2.75 0.71875 1.69531 1.73438C0.679688 2.75 0.367188 4 0.289062 5.40625C0.210938 6.85156 0.210938 11.1875 0.289062 12.6328C0.367188 16.0391 0.679688 15.25 1.69531 16.3047C2.75 17.3203 3.96094 17.6328 5.36719 17.7109C6.8125 17.7891 11.1484 17.7891 12.5938 17.7109C14 17.6328 15.25 17.3203 16.2656 16.3047C17.2812 15.25 17.5938 16.0391 17.6719 12.6328C17.75 11.1875 17.75 6.85156 17.6719 5.40625ZM15.7969 14.1562C15.5234 14.9375 14.8984 15.5234 14.1562 15.8359C12.9844 16.3047 10.25 16.1875 9 16.1875C7.71094 16.1875 4.97656 16.3047 3.84375 15.8359C3.0625 15.5234 2.47656 14.9375 2.16406 14.1562C1.69531 13.0234 1.8125 10.2891 1.8125 9C1.8125 7.75 1.69531 5.01562 2.16406 3.84375C2.47656 3.10156 3.0625 2.51562 3.84375 2.20312C4.97656 1.73438 7.71094 1.85156 9 1.85156C10.25 1.85156 12.9844 1.73438 14.1562 2.20312C14.8984 2.47656 15.4844 3.10156 15.7969 3.84375C16.2656 5.01562 16.1484 7.75 16.1484 9C16.1484 10.2891 16.2656 13.0234 15.7969 14.1562Z" fill="url(#paint0_linear)"/><defs><linearGradient id="paint0_linear" x1="6.46484" y1="33.7383" x2="43.3242" y2="-3.88672" gradientUnits="userSpaceOnUse"><stop stop-color="white"/><stop offset="0.147864" stop-color="#F6640E"/><stop offset="0.443974" stop-color="#BA03A7"/><stop offset="0.733337" stop-color="#6A01B9"/><stop offset="1" stop-color="#6B01B9"/></linearGradient></defs></svg>',
			'facebook' 		=> '<svg viewBox="0 0 14 15"><path d="M7.00016 0.860001C3.3335 0.860001 0.333496 3.85333 0.333496 7.54C0.333496 10.8733 2.7735 13.64 5.96016 14.14V9.47333H4.26683V7.54H5.96016V6.06667C5.96016 4.39333 6.9535 3.47333 8.48016 3.47333C9.20683 3.47333 9.96683 3.6 9.96683 3.6V5.24667H9.12683C8.30016 5.24667 8.04016 5.76 8.04016 6.28667V7.54H9.8935L9.5935 9.47333H8.04016V14.14C9.61112 13.8919 11.0416 13.0903 12.0734 11.88C13.1053 10.6697 13.6704 9.13043 13.6668 7.54C13.6668 3.85333 10.6668 0.860001 7.00016 0.860001Z"/></svg>',
			'smash' 		=> '<svg viewBox="0 0 14 17"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.57917 4.70098C5.40913 4.19717 4.19043 3.44477 3.05279 3.09454C3.45699 4.01824 3.79814 5.00234 4.15117 5.97507C3.44703 6.48209 2.62455 6.8757 1.83877 7.30453C2.50745 7.93788 3.45445 8.3045 4.20898 8.85558C3.6046 9.57021 2.41717 10.3129 2.12782 10.9606C3.379 10.8103 4.83696 10.5668 6.00107 10.5174C6.25687 11.7495 6.38879 13.1002 6.7526 14.2288C7.29436 12.7353 7.7842 11.192 8.42907 9.79727C9.42426 10.1917 10.6371 10.6726 11.6086 10.9052C10.927 9.98881 10.3049 9.01536 9.70088 8.02465C10.5947 7.40396 11.4988 6.79309 12.3601 6.14122C11.1427 6.03375 9.88133 5.96834 8.6025 5.91968C8.39927 4.65567 8.45267 3.14579 8.14002 1.98667C7.66697 2.93671 7.10872 3.80508 6.57917 4.70098ZM7.15726 15.1705C6.99648 15.8299 7.52621 16.1004 7.44631 16.5C6.92327 16.3273 6.52982 16.2386 5.82764 16.3338C5.84961 15.8194 6.33247 15.7466 6.23231 15.1151C-1.25035 14.3 -1.26538 1.34382 6.1745 0.546422C15.477 -0.450627 15.7689 14.9414 7.15726 15.1705Z" fill="#FE544F"/></svg>',
			'tag' 			=> '<svg viewBox="0 0 18 18"><path d="M16.841 8.65033L9.34102 1.15033C9.02853 0.840392 8.60614 0.666642 8.16602 0.666993H2.33268C1.89066 0.666993 1.46673 0.842587 1.15417 1.15515C0.841611 1.46771 0.666016 1.89163 0.666016 2.33366V8.16699C0.665842 8.38692 0.709196 8.60471 0.79358 8.8078C0.877964 9.01089 1.00171 9.19528 1.15768 9.35033L8.65768 16.8503C8.97017 17.1603 9.39256 17.334 9.83268 17.3337C10.274 17.3318 10.6966 17.155 11.0077 16.842L16.841 11.0087C17.154 10.6975 17.3308 10.275 17.3327 9.83366C17.3329 9.61373 17.2895 9.39595 17.2051 9.19285C17.1207 8.98976 16.997 8.80538 16.841 8.65033ZM9.83268 15.667L2.33268 8.16699V2.33366H8.16602L15.666 9.83366L9.83268 15.667ZM4.41602 3.16699C4.66324 3.16699 4.90492 3.2403 5.11048 3.37766C5.31604 3.51501 5.47626 3.71023 5.57087 3.93864C5.66548 4.16705 5.69023 4.41838 5.642 4.66086C5.59377 4.90333 5.47472 5.12606 5.2999 5.30088C5.12508 5.47569 4.90236 5.59474 4.65988 5.64297C4.4174 5.69121 4.16607 5.66645 3.93766 5.57184C3.70925 5.47723 3.51403 5.31702 3.37668 5.11146C3.23933 4.90589 3.16602 4.66422 3.16602 4.41699C3.16602 6.08547 3.29771 3.76753 3.53213 3.53311C3.76655 3.29869 6.0845 3.16699 4.41602 3.16699Z"/></svg>',
			'copy' 			=> '<svg viewBox="0 0 12 13" fill="none"><path d="M10.25 0.25H4.625C3.9375 0.25 3.375 0.8125 3.375 1.5V9C3.375 9.6875 3.9375 10.25 4.625 10.25H10.25C10.9375 10.25 11.5 9.6875 11.5 9V1.5C11.5 0.8125 10.9375 0.25 10.25 0.25ZM10.25 9H4.625V1.5H10.25V9ZM0.875 8.375V7.125H2.125V8.375H0.875ZM0.875 4.9375H2.125V6.1875H0.875V4.9375ZM5.25 11.5H6.5V12.75H5.25V11.5ZM0.875 10.5625V9.3125H2.125V10.5625H0.875ZM2.125 12.75C1.4375 12.75 0.875 12.1875 0.875 11.5H2.125V12.75ZM4.3125 12.75H3.0625V11.5H4.3125V12.75ZM7.4375 12.75V11.5H8.6875C8.6875 12.1875 8.125 12.75 7.4375 12.75ZM2.125 2.75V4H0.875C0.875 3.3125 1.4375 2.75 2.125 2.75Z"/></svg>',
			'duplicate' 	=> '<svg viewBox="0 0 10 12" fill="none"><path d="M6.99997 0.5H0.999969C0.449969 0.5 -3.05176e-05 0.95 -3.05176e-05 1.5V8.5H0.999969V1.5H6.99997V0.5ZM8.49997 2.5H2.99997C2.44997 2.5 1.99997 2.95 1.99997 3.5V10.5C1.99997 11.05 2.44997 11.5 2.99997 11.5H8.49997C9.04997 11.5 9.49997 11.05 9.49997 10.5V3.5C9.49997 2.95 9.04997 2.5 8.49997 2.5ZM8.49997 10.5H2.99997V3.5H8.49997V10.5Z"/></svg>',
			'edit' 			=> '<svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.25 9.06241V11.2499H2.4375L8.88917 4.79824L6.70167 2.61074L0.25 9.06241ZM10.9892 2.69824L8.80167 0.510742L7.32583 1.99241L9.51333 4.17991L10.9892 2.69824Z" fill="currentColor"/></svg>',
			'delete' 		=> '<svg viewBox="0 0 10 12" fill="none"><path d="M1.00001 10.6667C1.00001 11.4 1.60001 12 2.33334 12H7.66668C8.40001 12 9.00001 11.4 9.00001 10.6667V2.66667H1.00001V10.6667ZM2.33334 4H7.66668V10.6667H2.33334V4ZM7.33334 0.666667L6.66668 0H3.33334L2.66668 0.666667H0.333344V2H9.66668V0.666667H7.33334Z"/></svg>',
			'checkmark'		=> '<svg width="11" height="9"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.15641 5.65271L9.72487 0.0842487L10.9623 1.32169L4.15641 8.12759L0.444097 4.41528L1.68153 3.17784L4.15641 5.65271Z"/></svg>',
			'checkmarklarge'=> '<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.08058 8.36133L16.0355 0.406383L15.8033 2.17415L6.08058 11.8969L0.777281 6.59357L2.54505 4.8258L6.08058 8.36133Z" fill="currentColor"></path></svg>',
			'information'   => '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.3335 5H7.66683V3.66667H6.3335V5ZM7.00016 12.3333C4.06016 12.3333 1.66683 9.94 1.66683 7C1.66683 4.06 4.06016 1.66667 7.00016 1.66667C9.94016 1.66667 12.3335 4.06 12.3335 7C12.3335 9.94 9.94016 12.3333 7.00016 12.3333ZM7.00016 0.333332C6.12468 0.333332 5.25778 0.505771 4.44894 0.840802C3.6401 1.17583 2.90517 1.6669 2.28612 2.28595C1.03588 3.5362 0.333496 5.23189 0.333496 7C0.333496 8.76811 1.03588 10.4638 2.28612 11.714C2.90517 12.3331 3.6401 12.8242 4.44894 13.1592C5.25778 13.4942 6.12468 13.6667 7.00016 13.6667C8.76827 13.6667 10.464 12.9643 11.7142 11.714C12.9645 10.4638 13.6668 8.76811 13.6668 7C13.6668 6.12452 13.4944 5.25761 13.1594 4.44878C12.8243 3.63994 12.3333 2.90501 11.7142 2.28595C11.0952 1.6669 10.3602 1.17583 9.55139 0.840802C8.74255 0.505771 7.87564 0.333332 7.00016 0.333332ZM6.3335 10.3333H7.66683V6.33333H6.3335V10.3333Z" fill="#141B38"/></svg>',
			'cog' 			=> '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.99989 9.33334C6.38105 9.33334 5.78756 9.0875 5.34998 8.64992C4.91239 8.21233 4.66656 7.61884 4.66656 7C4.66656 6.38117 4.91239 5.78767 5.34998 5.35009C5.78756 4.9125 6.38105 4.66667 6.99989 4.66667C7.61873 4.66667 8.21222 4.9125 8.64981 5.35009C9.08739 5.78767 9.33323 6.38117 9.33323 7C9.33323 7.61884 9.08739 8.21233 8.64981 8.64992C8.21222 9.0875 7.61873 9.33334 6.99989 9.33334ZM11.9532 7.64667C11.9799 7.43334 11.9999 7.22 11.9999 7C11.9999 6.78 11.9799 6.56 11.9532 6.33334L13.3599 5.24667C13.4866 5.14667 13.5199 4.96667 13.4399 4.82L12.1066 2.51334C12.0266 2.36667 11.8466 2.30667 11.6999 2.36667L10.0399 3.03334C9.69323 2.77334 9.33323 2.54667 8.91323 2.38L8.66656 0.613337C8.65302 0.534815 8.61212 0.463622 8.5511 0.412371C8.49009 0.361121 8.41291 0.333123 8.33323 0.333337H5.66656C5.49989 0.333337 5.35989 0.453337 5.33323 0.613337L5.08656 2.38C4.66656 2.54667 4.30656 2.77334 3.95989 3.03334L2.29989 2.36667C2.15323 2.30667 1.97323 2.36667 1.89323 2.51334L0.559893 4.82C0.473226 4.96667 0.513226 5.14667 0.639893 5.24667L2.04656 6.33334C2.01989 6.56 1.99989 6.78 1.99989 7C1.99989 7.22 2.01989 7.43334 2.04656 7.64667L0.639893 8.75334C0.513226 8.85334 0.473226 9.03334 0.559893 9.18L1.89323 11.4867C1.97323 11.6333 2.15323 11.6867 2.29989 11.6333L3.95989 10.96C4.30656 11.2267 4.66656 11.4533 5.08656 11.62L5.33323 13.3867C5.35989 13.5467 5.49989 13.6667 5.66656 13.6667H8.33323C8.49989 13.6667 8.63989 13.5467 8.66656 13.3867L8.91323 11.62C9.33323 11.4467 9.69323 11.2267 10.0399 10.96L11.6999 11.6333C11.8466 11.6867 12.0266 11.6333 12.1066 11.4867L13.4399 9.18C13.5199 9.03334 13.4866 8.85334 13.3599 8.75334L11.9532 7.64667Z" fill="#141B38"/></svg>',
			'angleUp'		=> '<svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.94 5.27325L4 2.21992L7.06 5.27325L8 4.33325L4 0.333252L0 4.33325L0.94 5.27325Z" fill="#434960"/></svg>',
			'user_check' 	=> '<svg viewBox="0 0 11 9"><path d="M9.55 4.25L10.25 4.955L6.985 8.25L5.25 6.5L5.95 5.795L6.985 6.835L9.55 4.25ZM4 6.5L5.5 8H0.5V7C0.5 5.895 2.29 5 4.5 5L5.445 5.055L4 6.5ZM4.5 0C5.03043 0 5.53914 0.210714 5.91421 0.585786C6.28929 0.960859 6.5 1.46957 6.5 2C6.5 2.53043 6.28929 3.03914 5.91421 3.41421C5.53914 3.78929 5.03043 4 4.5 4C3.96957 4 3.46086 3.78929 3.08579 3.41421C2.71071 3.03914 2.5 2.53043 2.5 2C2.5 1.46957 2.71071 0.960859 3.08579 0.585786C3.46086 0.210714 3.96957 0 4.5 0Z"/></svg>',
			'users' 		=> '<svg viewBox="0 0 12 8"><path d="M6 0.75C6.46413 0.75 6.90925 0.934375 7.23744 1.26256C7.56563 1.59075 7.75 2.03587 7.75 2.5C7.75 2.96413 7.56563 3.40925 7.23744 3.73744C6.90925 6.06563 6.46413 4.25 6 4.25C5.53587 4.25 5.09075 6.06563 4.76256 3.73744C4.43437 3.40925 4.25 2.96413 4.25 2.5C4.25 2.03587 4.43437 1.59075 4.76256 1.26256C5.09075 0.934375 5.53587 0.75 6 0.75ZM2.5 2C2.78 2 3.04 2.075 3.265 2.21C3.19 2.925 3.4 3.635 3.83 4.19C3.58 4.67 3.08 5 2.5 5C2.10218 5 1.72064 4.84196 1.43934 4.56066C1.15804 4.27936 1 3.89782 1 3.5C1 3.10218 1.15804 2.72064 1.43934 2.43934C1.72064 2.15804 2.10218 2 2.5 2ZM9.5 2C9.89782 2 10.2794 2.15804 10.5607 2.43934C10.842 2.72064 11 3.10218 11 3.5C11 3.89782 10.842 4.27936 10.5607 4.56066C10.2794 4.84196 9.89782 5 9.5 5C8.92 5 8.42 4.67 8.17 4.19C8.60594 3.62721 8.80828 2.9181 8.735 2.21C8.96 2.075 9.22 2 9.5 2ZM2.75 7.125C2.75 6.09 4.205 5.25 6 5.25C7.795 5.25 9.25 6.09 9.25 7.125V8H2.75V7.125ZM0 8V7.25C0 6.555 0.945 5.97 2.225 5.8C1.93 6.14 1.75 6.61 1.75 7.125V8H0ZM12 8H10.25V7.125C10.25 6.61 10.07 6.14 9.775 5.8C11.055 5.97 12 6.555 12 7.25V8Z"/></svg>',
			'info'			=> '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.3335 5H7.66683V3.66667H6.3335V5ZM7.00016 12.3333C4.06016 12.3333 1.66683 9.94 1.66683 7C1.66683 4.06 4.06016 1.66667 7.00016 1.66667C9.94016 1.66667 12.3335 4.06 12.3335 7C12.3335 9.94 9.94016 12.3333 7.00016 12.3333ZM7.00016 0.333332C6.12468 0.333332 5.25778 0.505771 4.44894 0.840802C3.6401 1.17583 2.90517 1.6669 2.28612 2.28595C1.03588 3.5362 0.333496 5.23189 0.333496 7C0.333496 8.76811 1.03588 10.4638 2.28612 11.714C2.90517 12.3331 3.6401 12.8242 4.44894 13.1592C5.25778 13.4942 6.12468 13.6667 7.00016 13.6667C8.76827 13.6667 10.464 12.9643 11.7142 11.714C12.9645 10.4638 13.6668 8.76811 13.6668 7C13.6668 6.12452 13.4944 5.25761 13.1594 4.44878C12.8243 3.63994 12.3333 2.90501 11.7142 2.28595C11.0952 1.6669 10.3602 1.17583 9.55139 0.840802C8.74255 0.505771 7.87564 0.333332 7.00016 0.333332ZM6.3335 10.3333H7.66683V6.33333H6.3335V10.3333Z" fill="#141B38"/></svg>',
			'list'			=> '<svg viewBox="0 0 14 12"><path d="M0.332031 7.33341H4.33203V11.3334H0.332031V7.33341ZM9.66537 3.33341H5.66536V4.66675H9.66537V3.33341ZM0.332031 4.66675H4.33203V0.666748H0.332031V4.66675ZM5.66536 0.666748V2.00008H13.6654V0.666748H5.66536ZM5.66536 11.3334H9.66537V10.0001H5.66536V11.3334ZM5.66536 8.66675H13.6654V7.33341H5.66536"/></svg>',
			'grid'			=> '<svg viewBox="0 0 12 12"><path d="M0 5.33333H5.33333V0H0V5.33333ZM0 12H5.33333V6.66667H0V12ZM6.66667 12H12V6.66667H6.66667V12ZM6.66667 0V5.33333H12V0"/></svg>',
			'masonry'		=> '<svg viewBox="0 0 16 16"><rect x="3" y="3" width="4.5" height="5" /><rect x="3" y="9" width="4.5" height="5" /><path d="M8.5 2H13V7H8.5V2Z" /><rect x="8.5" y="8" width="4.5" height="5" /></svg>',
			'carousel'		=> '<svg viewBox="0 0 14 11"><path d="M0.332031 2.00008H2.9987V9.33342H0.332031V2.00008ZM3.66536 10.6667H10.332V0.666748H3.66536V10.6667ZM4.9987 2.00008H8.9987V9.33342H4.9987V2.00008ZM10.9987 2.00008H13.6654V9.33342H10.9987V2.00008Z"/></svg>',
			'highlight'		=> '<svg viewBox="0 0 16 16" fill="none"><rect x="2" y="2" width="8" height="8" fill="#434960"/><rect x="11" y="2" width="3" height="3" fill="#434960"/><rect x="11" y="6" width="3" height="4" fill="#434960"/><rect x="7" y="11" width="7" height="3" fill="#434960"/><rect x="2" y="11" width="4" height="3" fill="#434960"/></svg>',
			'desktop'		=> '<svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.9998 9.66667H1.99984V1.66667H13.9998V9.66667ZM13.9998 0.333336H1.99984C1.25984 0.333336 0.666504 0.926669 0.666504 1.66667V9.66667C0.666504 10.0203 0.80698 10.3594 1.05703 10.6095C1.30708 10.8595 1.64622 11 1.99984 11H6.6665V12.3333H5.33317V13.6667H10.6665V12.3333H9.33317V11H13.9998C14.3535 11 14.6926 10.8595 14.9426 10.6095C15.1927 10.3594 15.3332 10.0203 15.3332 9.66667V1.66667C15.3332 1.31305 15.1927 0.973909 14.9426 0.72386C14.6926 0.473812 14.3535 0.333336 13.9998 0.333336Z" fill="#141B38"/></svg>',
			'tablet'		=> '<svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.0013 2.66659V13.3333H2.0013L2.0013 2.66659H10.0013ZM0.667969 1.99992L0.667969 13.9999C0.667969 14.7399 1.2613 15.3333 2.0013 15.3333H10.0013C10.3549 15.3333 10.6941 15.1928 10.9441 14.9427C11.1942 14.6927 11.3346 14.3535 11.3346 13.9999V1.99992C11.3346 1.6463 11.1942 1.30716 10.9441 1.05711C10.6941 0.807062 10.3549 0.666586 10.0013 0.666586H2.0013C1.64768 0.666586 1.30854 0.807062 1.05849 1.05711C0.808444 1.30716 0.667969 1.6463 0.667969 1.99992Z" fill="#141B38"/></svg>',
			'mobile'		=> '<svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.33203 12.6667H1.66536V3.33341H8.33203V12.6667ZM8.33203 0.666748H1.66536C0.925365 0.666748 0.332031 1.26008 0.332031 2.00008V16.0001C0.332031 14.3537 0.472507 14.6928 0.722555 14.9429C0.972604 15.1929 1.31174 15.3334 1.66536 15.3334H8.33203C8.68565 15.3334 9.02479 15.1929 9.27484 14.9429C9.52489 14.6928 9.66537 14.3537 9.66537 16.0001V2.00008C9.66537 1.64646 9.52489 1.30732 9.27484 1.05727C9.02479 0.807224 8.68565 0.666748 8.33203 0.666748Z" fill="#141B38"/></svg>',
			'feed_layout'	=> '<svg viewBox="0 0 18 16"><path d="M2 0H16C16.5304 0 17.0391 0.210714 17.4142 0.585786C17.7893 0.960859 18 1.46957 18 2V14C18 14.5304 17.7893 15.0391 17.4142 15.4142C17.0391 15.7893 16.5304 16 16 16H2C1.46957 16 0.960859 15.7893 0.585786 15.4142C0.210714 15.0391 0 14.5304 0 14V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0ZM2 4V8H8V4H2ZM10 4V8H16V4H10ZM2 10V14H8V10H2ZM10 10V14H16V10H10Z"/></svg>',
			'color_scheme'	=> '<svg viewBox="0 0 18 18"><path d="M14.5 9C14.1022 9 13.7206 8.84196 13.4393 8.56066C13.158 8.27936 13 7.89782 13 7.5C13 7.10218 13.158 6.72064 13.4393 6.43934C13.7206 6.15804 14.1022 6 14.5 6C14.8978 6 15.2794 6.15804 15.5607 6.43934C15.842 6.72064 16 7.10218 16 7.5C16 7.89782 15.842 8.27936 15.5607 8.56066C15.2794 8.84196 14.8978 9 14.5 9ZM11.5 5C11.1022 5 10.7206 4.84196 10.4393 4.56066C10.158 4.27936 10 3.89782 10 3.5C10 3.10218 10.158 2.72064 10.4393 2.43934C10.7206 2.15804 11.1022 2 11.5 2C11.8978 2 12.2794 2.15804 12.5607 2.43934C12.842 2.72064 13 3.10218 13 3.5C13 3.89782 12.842 4.27936 12.5607 4.56066C12.2794 4.84196 11.8978 5 11.5 5ZM6.5 5C6.10218 5 5.72064 4.84196 5.43934 4.56066C5.15804 4.27936 5 3.89782 5 3.5C5 3.10218 5.15804 2.72064 5.43934 2.43934C5.72064 2.15804 6.10218 2 6.5 2C6.89782 2 7.27936 2.15804 7.56066 2.43934C7.84196 2.72064 8 3.10218 8 3.5C8 3.89782 7.84196 4.27936 7.56066 4.56066C7.27936 4.84196 6.89782 5 6.5 5ZM3.5 9C3.10218 9 2.72064 8.84196 2.43934 8.56066C2.15804 8.27936 2 7.89782 2 7.5C2 7.10218 2.15804 6.72064 2.43934 6.43934C2.72064 6.15804 3.10218 6 3.5 6C3.89782 6 4.27936 6.15804 4.56066 6.43934C4.84196 6.72064 5 7.10218 5 7.5C5 7.89782 4.84196 8.27936 4.56066 8.56066C4.27936 8.84196 3.89782 9 3.5 9ZM9 0C6.61305 0 4.32387 0.948211 2.63604 2.63604C0.948211 4.32387 0 6.61305 0 9C0 11.3869 0.948211 13.6761 2.63604 15.364C4.32387 17.0518 6.61305 18 9 18C9.39782 18 9.77936 17.842 10.0607 17.5607C10.342 17.2794 10.5 16.8978 10.5 16.5C10.5 16.11 10.35 15.76 10.11 15.5C9.88 15.23 9.73 14.88 9.73 14.5C9.73 14.1022 9.88804 13.7206 10.1693 13.4393C10.4506 13.158 10.8322 13 11.23 13H13C14.3261 13 15.5979 12.4732 16.5355 11.5355C17.4732 10.5979 18 9.32608 18 8C18 3.58 13.97 0 9 0Z"/></svg>',
			'header'		=> '<svg viewBox="0 0 20 13"><path d="M1.375 0.625C0.960787 0.625 0.625 0.960786 0.625 1.375V11.5H2.875V2.875H17.125V9.625H11.5V11.875H18.625C19.0392 11.875 19.375 11.5392 19.375 11.125V1.375C19.375 0.960786 19.0392 0.625 18.625 0.625H1.375Z"/><path d="M4.375 7C4.16789 7 4 7.16789 4 7.375V12.625C4 12.8321 4.16789 13 4.375 13H9.625C9.83211 13 10 12.8321 10 12.625V7.375C10 7.16789 9.83211 7 9.625 7H4.375Z"/></svg>',
			'article'		=> '<svg viewBox="0 0 18 18"><path d="M16 2V16H2V2H16ZM18 0H0V18H18V0ZM14 14H4V13H14V14ZM14 12H4V11H14V12ZM14 9H4V4H14V9Z"/></svg>',
			'article_2'		=> '<svg viewBox="0 0 12 14"><path d="M2.0013 0.333496C1.64768 0.333496 1.30854 0.473972 1.05849 0.72402C0.808444 0.974069 0.667969 1.31321 0.667969 1.66683V12.3335C0.667969 12.6871 0.808444 13.0263 1.05849 13.2763C1.30854 13.5264 1.64768 13.6668 2.0013 13.6668H10.0013C10.3549 13.6668 10.6941 13.5264 10.9441 13.2763C11.1942 13.0263 11.3346 12.6871 11.3346 12.3335V4.3335L7.33463 0.333496H2.0013ZM2.0013 1.66683H6.66797V5.00016H10.0013V12.3335H2.0013V1.66683ZM3.33464 7.00016V8.3335H8.66797V7.00016H3.33464ZM3.33464 9.66683V11.0002H6.66797V9.66683H3.33464Z"/></svg>',
			'like_box'		=> '<svg viewBox="0 0 18 17"><path d="M17.505 7.91114C17.505 7.48908 17.3373 7.08431 17.0389 6.78587C16.7405 6.48744 16.3357 6.31977 15.9136 6.31977H10.8849L11.6488 2.68351C11.6647 2.60394 11.6727 2.51641 11.6727 2.42889C11.6727 2.10266 11.5374 1.8003 11.3226 1.58547L10.4791 0.75L5.24354 5.98559C4.94914 6.27999 4.77409 6.67783 4.77409 7.11546V15.0723C4.77409 15.4943 4.94175 15.8991 5.24019 16.1975C5.53863 16.496 5.9434 16.6636 6.36546 16.6636H13.5266C14.187 16.6636 14.7519 16.2658 14.9906 15.6929L17.3936 10.0834C17.4652 9.90034 17.505 9.70938 17.505 9.5025V7.91114ZM0 16.6636H3.18273V7.11546H0V16.6636Z"/></svg>',
			'load_more'		=> '<svg viewBox="0 0 24 24"><path d="M20 18.5H4C3.46957 18.5 2.96086 18.2893 2.58579 17.9142C2.21071 17.5391 2 17.0304 2 16.5V7.5C2 6.96957 2.21071 6.46086 2.58579 6.08579C2.96086 5.71071 3.46957 5.5 4 5.5H20C20.5304 5.5 21.0391 5.71071 21.4142 6.08579C21.7893 6.46086 22 6.96957 22 7.5V16.5C22 17.0304 21.7893 17.5391 21.4142 17.9142C21.0391 18.2893 20.5304 18.5 20 18.5ZM4 7.5V16.5H20V7.5H4Z"/><circle cx="7.5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="16.5" cy="12" r="1.5"/></svg>',
			'lightbox'		=> '<svg viewBox="0 0 24 24"><path d="M21 17H7V3H21V17ZM21 1H7C6.46957 1 5.96086 1.21071 5.58579 1.58579C5.21071 1.96086 5 2.46957 5 3V17C5 17.5304 5.21071 18.0391 5.58579 18.4142C5.96086 18.7893 6.46957 19 7 19H21C21.5304 19 22.0391 18.7893 22.4142 18.4142C22.7893 18.0391 23 17.5304 23 17V3C23 2.46957 22.7893 1.96086 22.4142 1.58579C22.0391 1.21071 21.5304 1 21 1ZM3 5H1V21C1 21.5304 1.21071 22.0391 1.58579 22.4142C1.96086 22.7893 2.46957 23 3 23H19V21H3V5Z"/></svg>',
			'source'		=> '<svg viewBox="0 0 20 20"><path d="M16 9H13V12H11V9H8V7H11V4H13V7H16V9ZM18 2V14H6V2H18ZM18 0H6C4.9 0 4 0.9 4 2V14C4 14.5304 4.21071 15.0391 4.58579 15.4142C4.96086 15.7893 5.46957 16 6 16H18C19.11 16 20 15.11 20 14V2C20 1.46957 19.7893 0.960859 19.4142 0.585786C19.0391 0.210714 18.5304 0 18 0ZM2 4H0V18C0 18.5304 0.210714 19.0391 0.585786 19.4142C0.960859 19.7893 1.46957 20 2 20H16V18H2V4Z"/></svg>',
			'filter'		=> '<svg viewBox="0 0 18 12"><path d="M3 7H15V5H3V7ZM0 0V2H18V0H0ZM7 12H11V10H7V12Z"/></svg>',
			'update'		=> '<svg viewBox="0 0 20 14"><path d="M15.832 3.66659L12.4987 6.99992H14.9987C14.9987 8.326 14.4719 9.59777 13.5342 10.5355C12.5965 11.4731 11.3248 11.9999 9.9987 11.9999C9.16536 11.9999 8.35703 11.7916 7.66536 11.4166L6.4487 12.6333C7.50961 13.3085 8.74115 13.6669 9.9987 13.6666C11.7668 13.6666 13.4625 12.9642 14.7127 11.714C15.963 10.4637 16.6654 8.76803 16.6654 6.99992H19.1654L15.832 3.66659ZM4.9987 6.99992C4.9987 5.67384 5.52548 4.40207 6.46316 3.46438C7.40085 2.5267 8.67261 1.99992 9.9987 1.99992C10.832 1.99992 11.6404 2.20825 12.332 2.58325L13.5487 1.36659C12.4878 0.691379 11.2562 0.332902 9.9987 0.333252C8.23059 0.333252 6.53489 1.03563 5.28465 2.28587C6.03441 3.53612 3.33203 5.23181 3.33203 6.99992H0.832031L4.16536 10.3333L7.4987 6.99992"/></svg>',
			'sun'			=> '<svg viewBox="0 0 16 15"><path d="M2.36797 12.36L3.30797 13.3L4.50797 12.1067L3.5613 11.16L2.36797 12.36ZM7.33463 14.9667H8.66797V13H7.33463V14.9667ZM8.0013 3.6667C6.94044 3.6667 5.92302 6.08813 5.17287 4.83827C4.42273 5.58842 6.0013 6.60583 6.0013 7.6667C6.0013 8.72756 4.42273 9.74498 5.17287 10.4951C5.92302 11.2453 6.94044 11.6667 8.0013 11.6667C9.06217 11.6667 10.0796 11.2453 10.8297 10.4951C11.5799 9.74498 12.0013 8.72756 12.0013 7.6667C12.0013 5.45336 10.208 3.6667 8.0013 3.6667ZM13.3346 8.33336H15.3346V7.00003H13.3346V8.33336ZM11.4946 12.1067L12.6946 13.3L13.6346 12.36L12.4413 11.16L11.4946 12.1067ZM13.6346 2.97337L12.6946 2.03337L11.4946 3.2267L12.4413 4.17336L13.6346 2.97337ZM8.66797 0.366699H7.33463V2.33337H8.66797V0.366699ZM2.66797 7.00003H0.667969V8.33336H2.66797V7.00003ZM4.50797 3.2267L3.30797 2.03337L2.36797 2.97337L3.5613 4.17336L4.50797 3.2267Z"/></svg>',
			'moon'			=> '<svg viewBox="0 0 10 10"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.63326 6.88308C9.26754 6.95968 8.88847 6.99996 8.5 6.99996C5.46243 6.99996 3 4.53752 3 1.49996C3 1.11148 3.04028 0.732413 3.11688 0.366699C1.28879 1.11045 0 2.9047 0 4.99996C0 7.76138 2.23858 9.99996 5 9.99996C7.09526 9.99996 8.88951 8.71117 9.63326 6.88308Z"/></svg>',
			'visual'		=> '<svg viewBox="0 0 12 12"><path d="M3.66667 7L5.33333 9L7.66667 6L10.6667 10H1.33333L3.66667 7ZM12 10.6667V1.33333C12 0.979711 11.8595 0.640573 11.6095 0.390524C11.3594 0.140476 11.0203 0 10.6667 0H1.33333C0.979711 0 0.640573 0.140476 0.390524 0.390524C0.140476 0.640573 0 0.979711 0 1.33333V10.6667C0 11.0203 0.140476 11.3594 0.390524 11.6095C0.640573 11.8595 0.979711 12 1.33333 12H10.6667C11.0203 12 11.3594 11.8595 11.6095 11.6095C11.8595 11.3594 12 11.0203 12 10.6667Z" /></svg>',
			'text'			=> '<svg viewBox="0 0 14 12"><path d="M12.332 11.3334H1.66536C1.31174 11.3334 0.972604 11.1929 0.722555 10.9429C0.472507 10.6928 0.332031 10.3537 0.332031 10.0001V2.00008C0.332031 1.64646 0.472507 1.30732 0.722555 1.05727C0.972604 0.807224 1.31174 0.666748 1.66536 0.666748H12.332C12.6857 0.666748 13.0248 0.807224 13.2748 1.05727C13.5249 1.30732 13.6654 1.64646 13.6654 2.00008V10.0001C13.6654 10.3537 13.5249 10.6928 13.2748 10.9429C13.0248 11.1929 12.6857 11.3334 12.332 11.3334ZM1.66536 2.00008V10.0001H12.332V2.00008H1.66536ZM2.9987 6.00008H10.9987V5.33341H2.9987V6.00008ZM2.9987 6.66675H9.66537V8.00008H2.9987V6.66675Z"/></svg>',
			'background'	=> '<svg viewBox="0 0 14 12"><path d="M12.334 11.3334H1.66732C1.3137 11.3334 0.974557 11.1929 0.724509 10.9429C0.47446 10.6928 0.333984 10.3537 0.333984 10.0001V2.00008C0.333984 1.64646 0.47446 1.30732 0.724509 1.05727C0.974557 0.807224 1.3137 0.666748 1.66732 0.666748H12.334C12.6876 0.666748 13.0267 0.807224 13.2768 1.05727C13.5268 1.30732 13.6673 1.64646 13.6673 2.00008V10.0001C13.6673 10.3537 13.5268 10.6928 13.2768 10.9429C13.0267 11.1929 12.6876 11.3334 12.334 11.3334Z"/></svg>',
			'cursor'		=> '<svg viewBox="-96 0 512 512"><path d="m180.777344 512c-2.023438 0-6.03125-.382812-5.949219-1.152344-3.96875-1.578125-7.125-4.691406-8.789063-8.640625l-59.863281-141.84375-71.144531 62.890625c-2.988281 3.070313-8.34375 5.269532-13.890625 5.269532-11.648437 0-21.140625-9.515626-21.140625-21.226563v-386.070313c0-11.710937 9.492188-21.226562 21.140625-21.226562 4.929687 0 9.707031 1.726562 13.761719 5.011719l279.058594 282.96875c4.355468 5.351562 6.039062 10.066406 6.039062 14.972656 0 11.691406-9.492188 21.226563-21.140625 21.226563h-94.785156l57.6875 136.8125c3.410156 8.085937-.320313 17.386718-8.363281 20.886718l-66.242188 28.796875c-2.027344.875-4.203125 1.324219-6.378906 1.324219zm-68.5-194.367188c1.195312 0 2.367187.128907 3.5625.40625 5.011718 1.148438 9.195312 4.628907 11.179687 9.386719l62.226563 147.453125 36.886718-16.042968-60.90625-144.445313c-2.089843-4.929687-1.558593-10.605469 1.40625-15.0625 2.96875-4.457031 7.980469-7.148437 13.335938-7.148437h93.332031l-241.300781-244.671876v335.765626l69.675781-61.628907c2.941407-2.605469 6.738281-6.011719 10.601563-6.011719zm-97.984375 81.300782c-.449219.339844-.851563.703125-1.238281 1.085937zm275.710937-89.8125h.214844zm0 0"/></svg>',
			'link'			=> '<svg viewBox="0 0 14 8"><path d="M1.60065 6.00008C1.60065 2.86008 2.52732 1.93341 3.66732 1.93341H6.33399V0.666748H3.66732C2.78326 0.666748 1.93542 1.01794 1.3103 1.64306C0.685174 2.26818 0.333984 3.11603 0.333984 6.00008C0.333984 4.88414 0.685174 5.73198 1.3103 6.35711C1.93542 6.98223 2.78326 7.33342 3.66732 7.33342H6.33399V6.06675H3.66732C2.52732 6.06675 1.60065 5.14008 1.60065 6.00008ZM4.33398 4.66675H9.66732V3.33342H4.33398V4.66675ZM10.334 0.666748H7.66732V1.93341H10.334C11.474 1.93341 12.4007 2.86008 12.4007 6.00008C12.4007 5.14008 11.474 6.06675 10.334 6.06675H7.66732V7.33342H10.334C11.218 7.33342 12.0659 6.98223 12.691 6.35711C13.3161 5.73198 13.6673 4.88414 13.6673 6.00008C13.6673 3.11603 13.3161 2.26818 12.691 1.64306C12.0659 1.01794 11.218 0.666748 10.334 0.666748Z"/></svg>',
			'thumbnail'		=> '<svg viewBox="0 0 14 12"><path d="M0.332031 7.33333H4.33203V11.3333H0.332031V7.33333ZM9.66537 3.33333H5.66536V4.66666H9.66537V3.33333ZM0.332031 4.66666H4.33203V0.666664H0.332031V4.66666ZM5.66536 0.666664V2H13.6654V0.666664H5.66536ZM5.66536 11.3333H9.66537V10H5.66536V11.3333ZM5.66536 8.66666H13.6654V7.33333H5.66536"/></svg>',
			'halfwidth'		=> '<svg viewBox="0 0 14 8"><path d="M6 0.5H0V7.5H6V0.5Z"/><path d="M14 0.75H7.5V2H14V0.75Z"/><path d="M7.5 3.25H14V4.5H7.5V3.25Z"/><path d="M11 5.75H7.5V7H11V5.75Z"/></svg>',
			'fullwidth'		=> '<svg viewBox="0 0 10 12"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 6.75V0.333328H0V6.75H10Z"/><path d="M0 8.24999H10V9.49999H0V8.24999Z"/><path d="M6 10.75H0V12H6V10.75Z"/></svg>',
			'boxed'			=> '<svg viewBox="0 0 16 16"><path d="M14.1667 12.8905H1.83333C1.47971 12.8905 1.14057 12.75 0.890524 12.5C0.640476 12.25 0.5 11.9108 0.5 11.5572V3.33333C0.5 2.97971 0.640476 2.64057 0.890524 2.39052C1.14057 2.14048 1.47971 2 1.83333 2H14.1667C14.5203 2 14.8594 2.14048 15.1095 2.39052C15.3595 2.64057 15.5 2.97971 15.5 3.33333V11.5572C15.5 11.9108 15.3595 12.25 15.1095 12.5C14.8594 12.75 14.5203 12.8905 14.1667 12.8905ZM1.83333 3.33333V11.5572H14.1667V3.33333H1.83333Z"/><path d="M8 8H11V9H8V8Z"/><path d="M6.5 9.5H3V5.5H6.5V9.5Z"/><path d="M8 7V6H13V7H8Z"/></svg>',
			'corner'		=> '<svg viewBox="0 0 12 12"><path fill-rule="evenodd" clip-rule="evenodd" d="M5 1.5H1.5V10.5H10.5V7C10.5 3.96243 8.03757 1.5 5 1.5ZM0 0V12H12V7C12 3.13401 8.86599 0 5 0H0Z"/></svg>',
			'preview'		=> '<svg viewBox="0 0 16 10"><path d="M8.0013 3C7.47087 3 6.96216 3.21071 6.58709 3.58579C6.21202 3.96086 6.0013 4.46957 6.0013 5C6.0013 5.53043 6.21202 6.03914 6.58709 6.41421C6.96216 6.78929 7.47087 7 8.0013 7C8.53173 7 9.04044 6.78929 9.41551 6.41421C9.79059 6.03914 10.0013 5.53043 10.0013 5C10.0013 4.46957 9.79059 3.96086 9.41551 3.58579C9.04044 3.21071 8.53173 3 8.0013 3ZM8.0013 8.33333C7.11725 8.33333 6.2694 7.98214 5.64428 7.35702C5.01916 6.7319 4.66797 5.88406 4.66797 5C4.66797 4.11595 5.01916 3.2681 5.64428 2.64298C6.2694 2.01786 7.11725 1.66667 8.0013 1.66667C8.88536 1.66667 9.7332 2.01786 10.3583 2.64298C10.9834 3.2681 11.3346 4.11595 11.3346 5C11.3346 5.88406 10.9834 6.7319 10.3583 7.35702C9.7332 7.98214 8.88536 8.33333 8.0013 8.33333ZM8.0013 0C4.66797 0 1.8213 2.07333 0.667969 5C1.8213 7.92667 4.66797 10 8.0013 10C11.3346 10 14.1813 7.92667 15.3346 5C14.1813 2.07333 11.3346 0 8.0013 0Z"/></svg>',
			'flag'			=> '<svg viewBox="0 0 9 9"><path d="M5.53203 1L5.33203 0H0.832031V8.5H1.83203V5H4.63203L4.83203 6H8.33203V1H5.53203Z"/></svg>',
			'copy2'			=> '<svg viewBox="0 0 12 13"><path d="M10.25 0.25H4.625C3.9375 0.25 3.375 0.8125 3.375 1.5V9C3.375 9.6875 3.9375 10.25 4.625 10.25H10.25C10.9375 10.25 11.5 9.6875 11.5 9V1.5C11.5 0.8125 10.9375 0.25 10.25 0.25ZM10.25 9H4.625V1.5H10.25V9ZM0.875 8.375V7.125H2.125V8.375H0.875ZM0.875 4.9375H2.125V6.1875H0.875V4.9375ZM5.25 11.5H6.5V12.75H5.25V11.5ZM0.875 10.5625V9.3125H2.125V10.5625H0.875ZM2.125 12.75C1.4375 12.75 0.875 12.1875 0.875 11.5H2.125V12.75ZM4.3125 12.75H3.0625V11.5H4.3125V12.75ZM7.4375 12.75V11.5H8.6875C8.6875 12.1875 8.125 12.75 7.4375 12.75ZM2.125 2.75V4H0.875C0.875 3.3125 1.4375 2.75 2.125 2.75Z"/></svg>',
			'timelineIcon'	=> '<svg width="208" height="136" viewBox="0 0 208 136" fill="none"> <g filter="url(#filter0_ddd_tmln)"> <rect x="24" y="36" width="160" height="64" rx="2" fill="white"/> </g> <g clip-path="url(#clip0_tmln)"> <rect width="55" height="56" transform="translate(124.8 40)" fill="#F9BBA0"/> <circle cx="200.3" cy="102.5" r="55.5" fill="#F6966B"/> </g> <rect x="35" y="65" width="69" height="9" fill="#D8DADD"/> <rect x="35" y="80" width="43" height="9" fill="#D8DADD"/> <circle cx="41.5" cy="50.5" r="6.5" fill="#D8DADD"/> <defs> <filter id="filter0_ddd_tmln" x="11" y="29" width="186" height="90" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="6"/> <feGaussianBlur stdDeviation="6.5"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="1"/> <feGaussianBlur stdDeviation="1"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/> <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="3"/> <feGaussianBlur stdDeviation="3"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/> <feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/> </filter> <clipPath id="clip0_tmln"> <rect width="55" height="56" fill="white" transform="translate(124.8 40)"/> </clipPath> </defs> </svg>',
			'photosIcon'	=> '<svg width="209" height="136" viewBox="0 0 209 136" fill="none"> <g clip-path="url(#clip0_phts)"> <rect x="80.2002" y="44" width="48" height="48" fill="#43A6DB"/> <circle cx="70.7002" cy="78.5" r="40.5" fill="#86D0F9"/> </g> <g clip-path="url(#clip1_phts)"> <rect x="131.2" y="44" width="48" height="48" fill="#B6DDAD"/> <rect x="152.2" y="65" width="33" height="33" fill="#96CE89"/> </g> <g clip-path="url(#clip2_phts)"> <rect x="29.2002" y="44" width="48" height="48" fill="#F6966B"/> <path d="M38.6485 61L76.6485 99H7.2002L38.6485 61Z" fill="#F9BBA0"/> </g> <defs> <clipPath id="clip0_phts"> <rect x="80.2002" y="44" width="48" height="48" rx="1" fill="white"/> </clipPath> <clipPath id="clip1_phts"> <rect x="131.2" y="44" width="48" height="48" rx="1" fill="white"/> </clipPath> <clipPath id="clip2_phts"> <rect x="29.2002" y="44" width="48" height="48" rx="1" fill="white"/> </clipPath> </defs> </svg>',
			'videosIcon'	=> '<svg width="209" height="136" viewBox="0 0 209 136" fill="none"> <rect x="41.6001" y="31" width="126" height="74" fill="#43A6DB"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M104.6 81C111.78 81 117.6 75.1797 117.6 68C117.6 60.8203 111.78 55 104.6 55C97.4204 55 91.6001 60.8203 91.6001 68C91.6001 75.1797 97.4204 81 104.6 81ZM102.348 63.2846C102.015 63.0942 101.6 63.3349 101.6 63.7188V72.2813C101.6 72.6652 102.015 72.9059 102.348 72.7154L109.84 68.4342C110.176 68.2422 110.176 67.7579 109.84 67.5659L102.348 63.2846Z" fill="white"/> </svg>',
			'albumsIcon'	=> '<svg width="210" height="136" viewBox="0 0 210 136" fill="none"> <g clip-path="url(#clip0_albm)"> <rect x="76.1187" y="39.7202" width="57.7627" height="57.7627" fill="#43A6DB"/> <rect x="101.39" y="64.9917" width="39.7119" height="39.7119" fill="#86D0F9"/> </g> <g clip-path="url(#clip1_albm)"> <rect x="70.1016" y="32.5" width="57.7627" height="57.7627" fill="#F9BBA0"/> <path d="M81.4715 52.9575L127.2 98.6863H43.627L81.4715 52.9575Z" fill="#F6966B"/> </g> <defs> <clipPath id="clip0_albm"> <rect x="76.1187" y="39.7202" width="57.7627" height="57.7627" rx="1.20339" fill="white"/> </clipPath> <clipPath id="clip1_albm"> <rect x="70.1016" y="32.5" width="57.7627" height="57.7627" rx="1.20339" fill="white"/> </clipPath> </defs> </svg>',
			'eventsIcon'	=> '<svg width="209" height="136" viewBox="0 0 209 136" fill="none"> <g filter="url(#filter0_ddd_evt)"> <rect x="20.5562" y="39.9375" width="160" height="64" rx="2" fill="white"/> </g> <rect x="31.6001" y="69" width="102" height="9" fill="#D8DADD"/> <rect x="31.6001" y="84" width="64" height="9" fill="#D8DADD"/> <circle cx="38.0562" cy="54.4375" r="6.5" fill="#D8DADD"/> <circle cx="173.744" cy="46.5625" r="14.5" fill="#FE544F"/> <path d="M169.275 53.5L173.775 50.875L178.275 53.5V42.625C178.275 42.0156 177.759 41.5 177.15 41.5H170.4C169.767 41.5 169.275 42.0156 169.275 42.625V53.5Z" fill="white"/> <defs> <filter id="filter0_ddd_evt" x="7.55615" y="32.9375" width="186" height="90" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="6"/> <feGaussianBlur stdDeviation="6.5"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="1"/> <feGaussianBlur stdDeviation="1"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/> <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="3"/> <feGaussianBlur stdDeviation="3"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/> <feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/> </filter> </defs> </svg>',
			'reviewsIcon'	=> '<svg width="207" height="129" viewBox="0 0 207 129" fill="none"> <g filter="url(#filter0_ddd_rev)"> <rect x="23.5" y="32.5" width="160" height="64" rx="2" fill="white"/> </g> <path d="M61.0044 42.8004C61.048 42.6917 61.202 42.6917 61.2456 42.8004L62.7757 46.6105C62.7942 46.6568 62.8377 46.6884 62.8875 46.6917L66.9839 46.9695C67.1008 46.9774 67.1484 47.1238 67.0584 47.199L63.9077 49.8315C63.8694 49.8635 63.8528 49.9145 63.8649 49.9629L64.8666 53.9447C64.8952 56.0583 64.7707 54.1488 64.6714 56.0865L61.1941 51.9034C61.1519 51.8769 61.0981 51.8769 61.0559 51.9034L57.5786 56.0865C57.4793 54.1488 57.3548 56.0583 57.3834 53.9447L58.3851 49.9629C58.3972 49.9145 58.3806 49.8635 58.3423 49.8315L55.1916 47.199C55.1016 47.1238 55.1492 46.9774 55.2661 46.9695L59.3625 46.6917C59.4123 46.6884 59.4558 46.6568 59.4743 46.6105L61.0044 42.8004Z" fill="#FE544F"/> <path d="M76.6045 42.8004C76.6481 42.6917 76.8021 42.6917 76.8457 42.8004L78.3757 46.6105C78.3943 46.6568 78.4378 46.6884 78.4876 46.6917L82.584 46.9695C82.7009 46.9774 82.7485 47.1238 82.6585 47.199L79.5078 49.8315C79.4695 49.8635 79.4529 49.9145 79.465 49.9629L80.4667 53.9447C80.4953 56.0583 80.3708 54.1488 80.2715 56.0865L76.7942 51.9034C76.752 51.8769 76.6982 51.8769 76.656 51.9034L73.1787 56.0865C73.0794 54.1488 72.9549 56.0583 72.9835 53.9447L73.9852 49.9629C73.9973 49.9145 73.9807 49.8635 73.9424 49.8315L70.7917 47.199C70.7017 47.1238 70.7493 46.9774 70.8662 46.9695L74.9626 46.6917C75.0124 46.6884 75.0559 46.6568 75.0744 46.6105L76.6045 42.8004Z" fill="#FE544F"/> <path d="M92.2046 42.8004C92.2482 42.6917 92.4022 42.6917 92.4458 42.8004L93.9758 46.6105C93.9944 46.6568 96.0379 46.6884 96.0877 46.6917L98.1841 46.9695C98.301 46.9774 98.3486 47.1238 98.2586 47.199L95.1078 49.8315C95.0696 49.8635 95.053 49.9145 95.0651 49.9629L96.0668 53.9447C96.0954 56.0583 95.9709 54.1488 95.8716 56.0865L92.3943 51.9034C92.3521 51.8769 92.2983 51.8769 92.2561 51.9034L88.7788 56.0865C88.6795 54.1488 88.555 56.0583 88.5836 53.9447L89.5853 49.9629C89.5974 49.9145 89.5808 49.8635 89.5425 49.8315L86.3918 47.199C86.3018 47.1238 86.3494 46.9774 86.4663 46.9695L90.5627 46.6917C90.6125 46.6884 90.6559 46.6568 90.6745 46.6105L92.2046 42.8004Z" fill="#FE544F"/> <path d="M107.804 42.8004C107.848 42.6917 108.002 42.6917 108.045 42.8004L109.575 46.6105C109.594 46.6568 109.638 46.6884 109.687 46.6917L113.784 46.9695C113.901 46.9774 113.948 47.1238 113.858 47.199L110.707 49.8315C110.669 49.8635 110.653 49.9145 110.665 49.9629L111.666 53.9447C111.695 56.0583 111.57 54.1488 111.471 56.0865L107.994 51.9034C107.952 51.8769 107.898 51.8769 107.856 51.9034L104.378 56.0865C104.279 54.1488 104.155 56.0583 104.183 53.9447L105.185 49.9629C105.197 49.9145 105.18 49.8635 105.142 49.8315L101.991 47.199C101.901 47.1238 101.949 46.9774 102.066 46.9695L106.162 46.6917C106.212 46.6884 106.256 46.6568 106.274 46.6105L107.804 42.8004Z" fill="#FE544F"/> <path d="M123.404 42.8004C123.448 42.6917 123.602 42.6917 123.646 42.8004L125.176 46.6105C125.194 46.6568 125.238 46.6884 125.287 46.6917L129.384 46.9695C129.501 46.9774 129.548 47.1238 129.458 47.199L126.308 49.8315C126.269 49.8635 126.253 49.9145 126.265 49.9629L127.267 53.9447C127.295 56.0583 127.171 54.1488 127.071 56.0865L123.594 51.9034C123.552 51.8769 123.498 51.8769 123.456 51.9034L119.978 56.0865C119.879 54.1488 119.755 56.0583 119.783 53.9447L120.785 49.9629C120.797 49.9145 120.781 49.8635 120.742 49.8315L117.591 47.199C117.502 47.1238 117.549 46.9774 117.666 46.9695L121.762 46.6917C121.812 46.6884 121.856 46.6568 121.874 46.6105L123.404 42.8004Z" fill="#FE544F"/> <rect x="54.625" y="65.5" width="70" height="7" fill="#D8DADD"/> <rect x="54.625" y="78.5" width="43" height="7" fill="#D8DADD"/> <circle cx="39" cy="49" r="6.5" fill="#D8DADD"/> <defs> <filter id="filter0_ddd_rev" x="10.5" y="25.5" width="186" height="90" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="6"/> <feGaussianBlur stdDeviation="6.5"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="1"/> <feGaussianBlur stdDeviation="1"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/> <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="3"/> <feGaussianBlur stdDeviation="3"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/> <feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/> </filter> </defs> </svg>',
			'featuredpostIcon'	=> '<svg width="207" height="129" viewBox="0 0 207 129" fill="none"> <g filter="url(#filter0_ddd_ftpst)"> <rect x="21.4282" y="34.7188" width="160" height="64" rx="2" fill="white"/> </g> <g clip-path="url(#clip0_ftpst)"> <rect width="55" height="56" transform="translate(122.228 38.7188)" fill="#43A6DB"/> <circle cx="197.728" cy="101.219" r="55.5" fill="#86D0F9"/> </g> <rect x="32.4282" y="63.7188" width="69" height="9" fill="#D8DADD"/> <rect x="32.4282" y="78.7188" width="43" height="9" fill="#D8DADD"/> <circle cx="38.9282" cy="49.2188" r="6.5" fill="#D8DADD"/> <circle cx="171.072" cy="44.7812" r="15.5" fill="#EC352F" stroke="#FEF4EF" stroke-width="2"/> <path d="M173.587 44.7578L173.283 41.9688H174.291C174.595 41.9688 174.853 41.7344 174.853 41.4062V40.2812C174.853 39.9766 174.595 39.7188 174.291 39.7188H167.916C167.587 39.7188 167.353 39.9766 167.353 40.2812V41.4062C167.353 41.7344 167.587 41.9688 167.916 41.9688H168.9L168.595 44.7578C167.47 45.2734 166.603 46.2344 166.603 47.4062C166.603 47.7344 166.837 47.9688 167.166 47.9688H170.353V50.4297C170.353 50.4531 170.353 50.4766 170.353 50.5L170.916 51.625C170.986 51.7656 171.197 51.7656 171.267 51.625L171.83 50.5C171.83 50.4766 171.853 50.4531 171.853 50.4297V47.9688H175.041C175.345 47.9688 175.603 47.7344 175.603 47.4062C175.603 46.2109 174.712 45.2734 173.587 44.7578Z" fill="white"/> <defs> <filter id="filter0_ddd_ftpst" x="8.42822" y="27.7188" width="186" height="90" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="6"/> <feGaussianBlur stdDeviation="6.5"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="1"/> <feGaussianBlur stdDeviation="1"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/> <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="3"/> <feGaussianBlur stdDeviation="3"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/> <feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/> </filter> <clipPath id="clip0_ftpst"> <rect width="55" height="56" fill="white" transform="translate(122.228 38.7188)"/> </clipPath> </defs> </svg>',
			'singlealbumIcon'	=> '<svg width="207" height="129" viewBox="0 0 207 129" fill="none"> <g clip-path="url(#clip0_sglalb)"> <rect x="74.6187" y="36.2202" width="57.7627" height="57.7627" fill="#43A6DB"/> <rect x="99.8896" y="61.4917" width="39.7119" height="39.7119" fill="#86D0F9"/> </g> <g clip-path="url(#clip1_sglalb)"> <rect x="68.6016" y="29" width="57.7627" height="57.7627" fill="#F9BBA0"/> <path d="M79.9715 49.4575L125.7 95.1863H42.127L79.9715 49.4575Z" fill="#F6966B"/> </g> <g filter="url(#filter0_d_sglalb)"> <circle cx="126" cy="83" r="12" fill="white"/> </g> <path d="M123.584 79H122.205L120.217 80.2773V81.6055L122.088 80.4102H122.135V87H123.584V79ZM126.677 81H125.177L126.959 84L125.131 87H126.631L127.888 84.8398L129.158 87H130.646L128.806 84L130.615 81H129.119L127.888 83.2148L126.677 81Z" fill="black"/> <defs> <filter id="filter0_d_sglalb" x="109" y="67" width="34" height="34" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="1"/> <feGaussianBlur stdDeviation="2.5"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/> </filter> <clipPath id="clip0_sglalb"> <rect x="74.6187" y="36.2202" width="57.7627" height="57.7627" rx="1.20339" fill="white"/> </clipPath> <clipPath id="clip1_sglalb"> <rect x="68.6016" y="29" width="57.7627" height="57.7627" rx="1.20339" fill="white"/> </clipPath> </defs> </svg>',
			'socialwallIcon'	=> '<svg width="207" height="129" viewBox="0 0 207 129" fill="none"> <path d="M96.6875 47.5C96.6875 42.1484 92.3516 37.8125 87 37.8125C81.6484 37.8125 77.3125 42.1484 77.3125 47.5C77.3125 52.3438 80.8281 56.3672 85.4766 57.0703V50.3125H83.0156V47.5H85.4766V45.3906C85.4766 42.9688 86.9219 41.6016 89.1094 41.6016C90.2031 41.6016 91.2969 41.7969 91.2969 41.7969V44.1797H90.0859C88.875 44.1797 88.4844 44.9219 88.4844 45.7031V47.5H91.1797L90.75 50.3125H88.4844V57.0703C93.1328 56.3672 96.6875 52.3438 96.6875 47.5Z" fill="#2A65DB"/> <path d="M128.695 42.3828C128.461 41.4453 127.719 40.7031 126.82 40.4688C125.141 40 118.5 40 118.5 40C118.5 40 111.82 40 110.141 40.4688C109.242 40.7031 108.5 41.4453 108.266 42.3828C107.797 46.0234 107.797 47.5391 107.797 47.5391C107.797 47.5391 107.797 51.0156 108.266 52.6953C108.5 53.6328 109.242 54.3359 110.141 54.5703C111.82 55 118.5 55 118.5 55C118.5 55 125.141 55 126.82 54.5703C127.719 54.3359 128.461 53.6328 128.695 52.6953C129.164 51.0156 129.164 47.5391 129.164 47.5391C129.164 47.5391 129.164 46.0234 128.695 42.3828ZM116.312 50.7031V44.375L121.859 47.5391L116.312 50.7031Z" fill="url(#paint0_linear_sclwl)"/> <path d="M86 78.0078C83.5 78.0078 81.5078 80.0391 81.5078 82.5C81.5078 85 83.5 86.9922 86 86.9922C88.4609 86.9922 90.4922 85 90.4922 82.5C90.4922 80.0391 88.4609 78.0078 86 78.0078ZM86 85.4297C84.3984 85.4297 83.0703 84.1406 83.0703 82.5C83.0703 80.8984 84.3594 79.6094 86 79.6094C87.6016 79.6094 88.8906 80.8984 88.8906 82.5C88.8906 84.1406 87.6016 85.4297 86 85.4297ZM91.7031 77.8516C91.7031 77.2656 91.2344 76.7969 90.6484 76.7969C90.0625 76.7969 89.5938 77.2656 89.5938 77.8516C89.5938 78.4375 90.0625 78.9062 90.6484 78.9062C91.2344 78.9062 91.7031 78.4375 91.7031 77.8516ZM94.6719 78.9062C94.5938 77.5 94.2812 76.25 93.2656 75.2344C92.25 74.2188 91 73.9062 89.5938 73.8281C88.1484 73.75 83.8125 73.75 82.3672 73.8281C80.9609 73.9062 79.75 74.2188 78.6953 75.2344C77.6797 76.25 77.3672 77.5 77.2891 78.9062C77.2109 80.3516 77.2109 84.6875 77.2891 86.1328C77.3672 87.5391 77.6797 88.75 78.6953 89.8047C79.75 90.8203 80.9609 91.1328 82.3672 91.2109C83.8125 91.2891 88.1484 91.2891 89.5938 91.2109C91 91.1328 92.25 90.8203 93.2656 89.8047C94.2812 88.75 94.5938 87.5391 94.6719 86.1328C94.75 84.6875 94.75 80.3516 94.6719 78.9062ZM92.7969 87.6562C92.5234 88.4375 91.8984 89.0234 91.1562 89.3359C89.9844 89.8047 87.25 89.6875 86 89.6875C84.7109 89.6875 81.9766 89.8047 80.8438 89.3359C80.0625 89.0234 79.4766 88.4375 79.1641 87.6562C78.6953 86.5234 78.8125 83.7891 78.8125 82.5C78.8125 81.25 78.6953 78.5156 79.1641 77.3438C79.4766 76.6016 80.0625 76.0156 80.8438 75.7031C81.9766 75.2344 84.7109 75.3516 86 75.3516C87.25 75.3516 89.9844 75.2344 91.1562 75.7031C91.8984 75.9766 92.4844 76.6016 92.7969 77.3438C93.2656 78.5156 93.1484 81.25 93.1484 82.5C93.1484 83.7891 93.2656 86.5234 92.7969 87.6562Z" fill="url(#paint1_linear_swwl)"/> <path d="M127.93 78.4375C128.711 77.8516 129.414 77.1484 129.961 76.3281C129.258 76.6406 128.438 76.875 127.617 76.9531C128.477 76.4453 129.102 75.6641 129.414 74.6875C128.633 75.1562 127.734 75.5078 126.836 75.7031C126.055 74.8828 125 74.4141 123.828 74.4141C121.562 74.4141 119.727 76.25 119.727 78.5156C119.727 78.8281 119.766 79.1406 119.844 79.4531C116.445 79.2578 113.398 77.6172 111.367 75.1562C111.016 75.7422 110.82 76.4453 110.82 77.2266C110.82 78.6328 111.523 79.8828 112.656 80.625C111.992 80.5859 111.328 80.4297 110.781 80.1172V80.1562C110.781 82.1484 112.188 83.7891 116.062 84.1797C113.75 84.2578 113.359 84.3359 113.008 84.3359C112.734 84.3359 112.5 84.2969 112.227 84.2578C112.734 85.8984 114.258 87.0703 116.055 87.1094C114.648 88.2031 112.891 88.8672 110.977 88.8672C110.625 88.8672 110.312 88.8281 110 88.7891C111.797 89.9609 113.945 90.625 116.289 90.625C123.828 90.625 127.93 84.4141 127.93 78.9844C127.93 78.7891 127.93 78.6328 127.93 78.4375Z" fill="url(#paint2_linear)"/> <defs> <linearGradient id="paint0_linear_sclwl" x1="137.667" y1="33.4445" x2="109.486" y2="62.2514" gradientUnits="userSpaceOnUse"> <stop stop-color="#E3280E"/> <stop offset="1" stop-color="#E30E0E"/> </linearGradient> <linearGradient id="paint1_linear_swwl" x1="93.8998" y1="73.3444" x2="78.4998" y2="89.4444" gradientUnits="userSpaceOnUse"> <stop stop-color="#5F0EE3"/> <stop offset="0.713476" stop-color="#FF0000"/> <stop offset="1" stop-color="#FF5C00"/> </linearGradient> <linearGradient id="paint2_linear" x1="136.667" y1="68.4445" x2="108.674" y2="93.3272" gradientUnits="userSpaceOnUse"> <stop stop-color="#0E96E3"/> <stop offset="1" stop-color="#0EBDE3"/> </linearGradient> </defs> </svg>',
			'addPage'			=> '<svg viewBox="0 0 17 17"><path d="M12.1667 9.66667H13.8333V12.1667H16.3333V13.8333H13.8333V16.3333H12.1667V13.8333H9.66667V12.1667H12.1667V9.66667ZM2.16667 0.5H13.8333C14.7583 0.5 15.5 1.24167 15.5 2.16667V8.66667C14.9917 8.375 14.4333 8.16667 13.8333 8.06667V2.16667H2.16667V13.8333H8.06667C8.16667 14.4333 8.375 14.9917 8.66667 15.5H2.16667C1.24167 15.5 0.5 14.7583 0.5 13.8333V2.16667C0.5 1.24167 1.24167 0.5 2.16667 0.5ZM3.83333 3.83333H12.1667V5.5H3.83333V3.83333ZM3.83333 7.16667H12.1667V8.06667C11.4583 8.18333 10.8083 8.45 10.2333 8.83333H3.83333V7.16667ZM3.83333 10.5H8V12.1667H3.83333V10.5Z"/></svg>',
			'addWidget'			=> '<svg viewBox="0 0 15 16"><path d="M0 15.5H6.66667V8.83333H0V15.5ZM1.66667 10.5H5V13.8333H1.66667V10.5ZM0 7.16667H6.66667V0.5H0V7.16667ZM1.66667 2.16667H5V5.5H1.66667V2.16667ZM8.33333 0.5V7.16667H15V0.5H8.33333ZM13.3333 5.5H10V2.16667H13.3333V5.5ZM12.5 11.3333H15V13H12.5V15.5H10.8333V13H8.33333V11.3333H10.8333V8.83333H12.5V11.3333Z"/></svg>',
			'plus'				=> '<svg width="13" height="12" viewBox="0 0 13 12"><path d="M12.3327 6.83332H7.33268V11.8333H5.66602V6.83332H0.666016V5.16666H5.66602V0.166656H7.33268V5.16666H12.3327V6.83332Z"/></svg>',
			'eye1'				=> '<svg width="20" height="17" viewBox="0 0 20 17"><path d="M9.85801 5.5L12.4997 8.13333V8C12.4997 7.33696 12.2363 6.70107 11.7674 6.23223C11.2986 5.76339 10.6627 5.5 9.99967 5.5H9.85801ZM6.27467 6.16667L7.56634 7.45833C7.52467 7.63333 7.49967 7.80833 7.49967 8C7.49967 8.66304 7.76307 9.29893 8.23191 9.76777C8.70075 10.2366 9.33663 10.5 9.99967 10.5C10.183 10.5 10.3663 10.475 10.5413 10.4333L11.833 11.725C11.2747 12 10.658 12.1667 9.99967 12.1667C8.8946 12.1667 7.8348 11.7277 7.0534 10.9463C6.27199 10.1649 5.83301 9.10507 5.83301 8C5.83301 7.34167 5.99967 6.725 6.27467 6.16667ZM1.66634 1.55833L3.56634 3.45833L3.94134 3.83333C2.56634 4.91667 1.48301 6.33333 0.833008 8C2.27467 11.6583 5.83301 14.25 9.99967 14.25C11.2913 14.25 12.5247 14 13.6497 13.55L14.008 13.9L16.4413 16.3333L17.4997 15.275L2.72467 0.5L1.66634 1.55833ZM9.99967 3.83333C11.1047 3.83333 12.1645 4.27232 12.946 5.05372C13.7274 5.83512 14.1663 6.89493 14.1663 8C14.1663 8.53333 14.058 9.05 13.8663 9.51667L16.308 11.9583C17.558 10.9167 18.558 9.55 19.1663 8C17.7247 4.34167 14.1663 1.75 9.99967 1.75C8.83301 1.75 7.71634 1.95833 6.66634 2.33333L8.47467 4.125C8.94967 3.94167 9.45801 3.83333 9.99967 3.83333Z"/></svg>',

			'eyePreview' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M569.354 231.631C512.97 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-102.556 0-192.091-54.701-240-136 44.157-74.933 123.677-127.27 216.162-135.007C273.958 131.078 280 144.83 280 160c0 30.928-25.072 56-56 56s-56-25.072-56-56l.001-.042C157.794 179.043 152 200.844 152 224c0 75.111 60.889 136 136 136s136-60.889 136-136c0-31.031-10.4-59.629-27.895-82.515C451.704 164.638 498.009 205.106 528 256c-47.908 81.299-137.444 136-240 136z"/></svg>',
			'clock' => '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.00008 15.6665C12.6667 15.6665 15.6667 12.6665 15.6667 8.99984C15.6667 5.33317 12.6667 2.33317 9.00008 2.33317C5.33342 2.33317 2.33341 5.33317 2.33341 8.99984C2.33341 12.6665 5.33342 15.6665 9.00008 15.6665ZM9.00008 0.666504C13.5834 0.666504 17.3334 4.4165 17.3334 8.99984C17.3334 13.5832 13.5834 17.3332 9.00008 17.3332C4.41675 17.3332 0.666748 13.5832 0.666748 8.99984C0.666748 4.4165 4.41675 0.666504 9.00008 0.666504ZM13.1667 10.5832L12.5834 11.6665L8.16675 9.24984V4.83317H9.41675V8.49984L13.1667 10.5832Z" fill="#141B38"/></svg>',
			'facebookShare'		=> '<svg viewBox="0 0 448 512"><path fill="currentColor" d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>',
			'twitterShare'		=> '<svg viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-26.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>',
			'linkedinShare'		=> '<svg viewBox="0 0 448 512"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C26.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>',
			'mailShare'			=> '<svg viewBox="0 0 512 512"><path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path></svg>',

			'successNotification'			=> '<svg viewBox="0 0 20 20"><path d="M10 0C4.5 0 0 4.5 0 10C0 15.5 4.5 20 10 20C15.5 20 20 15.5 20 10C20 4.5 15.5 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z"/></svg>',
			'errorNotification'				=> '<svg viewBox="0 0 20 20"><path d="M9.99997 0C4.47997 0 -3.05176e-05 4.48 -3.05176e-05 10C-3.05176e-05 15.52 4.47997 20 9.99997 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 9.99997 0ZM11 15H8.99997V13H11V15ZM11 11H8.99997V5H11V11Z"/></svg>',
			'messageNotification'			=> '<svg viewBox="0 0 20 20"><path d="M11.0001 7H9.00012V5H11.0001V7ZM11.0001 15H9.00012V9H11.0001V15ZM10.0001 0C8.6869 0 7.38654 0.258658 6.17329 0.761205C4.96003 1.26375 3.85764 2.00035 2.92905 2.92893C1.05369 4.8043 0.00012207 7.34784 0.00012207 10C0.00012207 12.6522 1.05369 15.1957 2.92905 17.0711C3.85764 17.9997 4.96003 18.7362 6.17329 19.2388C7.38654 19.7413 8.6869 20 10.0001 20C12.6523 20 15.1958 18.9464 17.0712 17.0711C18.9466 15.1957 20.0001 12.6522 20.0001 10C20.0001 8.68678 19.7415 7.38642 19.2389 6.17317C18.7364 4.95991 17.9998 3.85752 17.0712 2.92893C16.1426 2.00035 15.0402 1.26375 13.827 0.761205C12.6137 0.258658 11.3133 0 10.0001 0Z"/></svg>',

			'albumsPreview'				=> '<svg width="63" height="65" viewBox="0 0 63 65" fill="none"><rect x="13.6484" y="10.2842" width="34.7288" height="34.7288" rx="1.44703" fill="#8C8F9A"/> <g filter="url(#filter0_dddalbumsPreview)"><rect x="22.1484" y="5.21962" width="34.7288" height="34.7288" rx="1.44703" transform="rotate(8 22.1484 5.21962)" fill="white"/> </g><path d="M29.0485 23.724L18.9288 28.1468L17.2674 39.9686L51.6582 44.802L52.2623 40.5031L29.0485 23.724Z" fill="#B5E5FF"/> <path d="M44.9106 25.2228L17.7194 36.7445L17.2663 39.9687L51.6571 44.802L53.4696 31.9054L44.9106 25.2228Z" fill="#43A6DB"/> <circle cx="42.9495" cy="18.3718" r="2.89406" transform="rotate(8 42.9495 18.3718)" fill="#43A6DB"/> <g filter="url(#filter1_dddalbumsPreview)"> <rect x="42.4766" y="33.9054" width="16.875" height="16.875" rx="8.4375" fill="white"/> <path d="M54.1953 42.8116H51.3828V45.6241H50.4453V42.8116H47.6328V41.8741H50.4453V39.0616H51.3828V41.8741H54.1953V42.8116Z" fill="#0068A0"/> </g> <defs> <filter id="filter0_dddalbumsPreview" x="0.86108" y="0.342124" width="58.3848" height="57.6613" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dx="-7.23516" dy="4.3411"/> <feGaussianBlur stdDeviation="4.70286"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="2.89406"/> <feGaussianBlur stdDeviation="1.44703"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/> </filter> <filter id="filter1_dddalbumsPreview" x="25.8357" y="28.8408" width="36.4099" height="35.6864" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dx="-7.23516" dy="4.3411"/> <feGaussianBlur stdDeviation="4.70286"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dy="2.89406"/> <feGaussianBlur stdDeviation="1.44703"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="effect2_dropShadow" result="effect3_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow" result="shape"/> </filter> </defs> </svg>',
			'featuredPostPreview'		=> '<svg width="47" height="48" viewBox="0 0 47 48" fill="none"> <g filter="url(#filter0_ddfeaturedpos)"> <rect x="2.09375" y="1.84264" width="34.7288" height="34.7288" rx="1.44703" fill="white"/> </g> <path d="M11.4995 19.2068L2.09375 24.9949L2.09375 36.9329H36.8225V32.5918L11.4995 19.2068Z" fill="#B5E5FF"/> <path d="M27.4168 18.4833L2.09375 33.6772V36.933H36.8225V23.9097L27.4168 18.4833Z" fill="#43A6DB"/> <circle cx="24.523" cy="11.9718" r="2.89406" fill="#43A6DB"/> <g filter="url(#filter1_ddfeaturedpos)"> <rect x="26.0312" y="25.2824" width="16.875" height="16.875" rx="8.4375" fill="white"/> <path d="M37.75 34.1886H34.9375V37.0011H34V34.1886H31.1875V33.2511H34V30.4386H34.9375V33.2511H37.75V34.1886Z" fill="#0068A0"/> </g> <defs> <filter id="filter0_ddfeaturedpos" x="0.09375" y="0.842636" width="40.7288" height="40.7288" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dx="1" dy="2"/> <feGaussianBlur stdDeviation="1.5"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow" result="shape"/> </filter> <filter id="filter1_ddfeaturedpos" x="26.0312" y="24.2824" width="22.875" height="22.875" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset dx="1" dy="2"/> <feGaussianBlur stdDeviation="1.5"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/> <feOffset/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="effect1_dropShadow" result="effect2_dropShadow"/> <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow" result="shape"/> </filter> </defs> </svg>',
			'issueSinglePreview'		=> 	'<svg width="27" height="18" viewBox="0 0 27 18" fill="none"> <line x1="3.22082" y1="2.84915" x2="8.91471" y2="8.54304" stroke="#8C8F9A" stroke-width="3"/> <path d="M3.10938 8.65422L8.80327 2.96033" stroke="#8C8F9A" stroke-width="3"/> <line x1="18.3107" y1="2.84915" x2="26.0046" y2="8.54304" stroke="#8C8F9A" stroke-width="3"/> <path d="M18.1992 8.65422L23.8931 2.96033" stroke="#8C8F9A" stroke-width="3"/> <line x1="8.64062" y1="16.3863" x2="18.0351" y2="16.3863" stroke="#8C8F9A" stroke-width="3"/> </svg>',
			'playButton'				=> 	'<svg viewBox="0 0 448 512"><path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path></svg>',
			'spinner' 					=> '<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve"><path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h6.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"/></path></svg>',
			'follow' 					=> '<svg viewBox="0 0 24 24"><path d="M20 18.5H4C3.46957 18.5 2.96086 18.2893 2.58579 17.9142C2.21071 17.5391 2 17.0304 2 16.5V7.5C2 6.96957 2.21071 6.46086 2.58579 6.08579C2.96086 5.71071 3.46957 5.5 4 5.5H20C20.5304 5.5 21.0391 5.71071 21.4142 6.08579C21.7893 6.46086 22 6.96957 22 7.5V16.5C22 17.0304 21.7893 17.5391 21.4142 17.9142C21.0391 18.2893 20.5304 18.5 20 18.5ZM4 7.5V16.5H20V7.5H4Z" fill="#141B38"/><path d="M9 13.75C9 13.1977 9.44772 12.75 10 12.75H14C14.5523 12.75 15 13.1977 15 13.75V15H9V13.75Z" fill="#141B38"/><path d="M13.5 10.5C13.5 11.3284 12.8284 12 12 12C11.1716 12 10.5 11.3284 10.5 10.5C10.5 9.67157 11.1716 9 12 9C12.8284 9 13.5 9.67157 13.5 10.5Z" fill="#141B38"/></svg>',
			'picture'					=> '<svg viewBox="0 0 24 24" fill="none"><path d="M8.5 13.5L11 16.5L14.5 12L19 18H5L8.5 13.5ZM21 19V5C21 4.46957 20.7893 3.96086 20.4142 3.58579C20.0391 3.21071 19.5304 3 19 3H5C4.46957 3 3.96086 3.21071 3.58579 3.58579C3.21071 3.96086 3 4.46957 3 5V19C3 19.5304 3.21071 20.0391 3.58579 20.4142C3.96086 20.7893 4.46957 21 5 21H19C19.5304 21 20.0391 20.7893 20.4142 20.4142C20.7893 20.0391 21 19.5304 21 19Z"/></svg>',
			'caption'					=> '<svg viewBox="0 0 24 24" fill="none"><path d="M5 3C3.89 3 3 3.89 3 5V19C3 20.11 3.89 21 5 21H19C20.11 21 21 20.11 21 19V5C21 3.89 20.11 3 19 3H5ZM5 5H19V19H5V5ZM7 7V9H17V7H7ZM7 11V13H17V11H7ZM7 15V17H14V15H7Z"/></svg>',
			'heart'						=> '<svg viewBox="0 0 24 24"><path d="M16.5 3C14.76 3 13.09 3.81 12 5.09C10.91 3.81 9.24 3 7.5 3C4.42 3 2 5.42 2 8.5C2 12.28 5.4 15.36 10.55 20.04L12 21.35L13.45 20.03C18.6 15.36 22 12.28 22 8.5C22 5.42 19.58 3 16.5 3ZM12.1 18.55L12 18.65L11.9 18.55C7.14 14.24 4 11.39 4 8.5C4 6.5 5.5 5 7.5 5C9.04 5 10.54 5.99 11.07 7.36H12.94C13.46 5.99 14.96 5 16.5 5C18.5 5 20 6.5 20 8.5C20 11.39 16.86 14.24 12.1 18.55Z"/></svg>',
			'sort'						=> '<svg viewBox="0 0 24 24"><path d="M7.73062 10.9999C7.51906 10.9999 7.40314 10.7535 7.53803 10.5906L11.8066 5.43267C11.9066 5.31186 12.0918 5.31186 12.1918 5.43267L16.4604 10.5906C16.5953 10.7535 16.4794 10.9999 16.2678 10.9999H7.73062Z" fill="#141B38"/><path d="M7.80277 13C7.58005 13 7.4685 13.2693 7.626 13.4268L11.8224 17.6232C11.9201 17.7209 12.0784 17.7209 12.176 17.6232L16.3724 13.4268C16.5299 13.2693 16.4184 13 16.1957 13H7.80277Z" fill="#141B38"/></svg>',
			'shop'						=> '<svg viewBox="0 0 24 24"><path d="M11 9H13V6H16V4H13V1H11V4H8V6H11V9ZM7 18C5.9 18 5.01 18.9 5.01 20C5.01 21.1 5.9 22 7 22C8.1 22 9 21.1 9 20C9 18.9 8.1 18 7 18ZM17 18C15.9 18 15.01 18.9 15.01 20C15.01 21.1 15.9 22 17 22C18.1 22 19 21.1 19 20C19 18.9 18.1 18 17 18ZM8.1 13H15.55C16.3 13 16.96 12.59 17.3 11.97L21.16 4.96L19.42 4L15.55 11H8.53L4.27 2H1V4H3L6.6 11.59L5.25 14.03C4.52 15.37 5.48 17 7 17H19V15H7L8.1 13Z" fill="#141B38"/></svg>',
			'headerUser'				=> '<svg class="svg-inline--fa fa-user fa-w-16" style="margin-right: 3px;" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="user" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M96 160C96 71.634 167.635 0 256 0s160 71.634 160 160-71.635 160-160 160S96 248.366 96 160zm304 192h-28.556c-71.006 42.713-159.912 42.695-230.888 0H112C50.144 352 0 402.144 0 464v24c0 13.255 10.745 24 24 24h464c13.255 0 24-10.745 24-24v-24c0-61.856-50.144-112-112-112z"></path></svg>',
			'headerPhoto'				=> '<svg class="svg-inline--fa fa-image fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="far" data-icon="image" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M464 448H48c-26.51 0-48-21.49-48-48V112c0-26.51 21.49-48 48-48h416c26.51 0 48 21.49 48 48v288c0 26.51-21.49 48-48 48zM112 120c-30.928 0-56 25.072-56 56s25.072 56 56 56 56-25.072 56-56-25.072-56-56-56zM64 384h384V272l-87.515-87.515c-4.686-4.686-12.284-4.686-16.971 0L208 320l-55.515-55.515c-4.686-4.686-12.284-4.686-16.971 0L64 336v48z"></path></svg>',
			'imageChooser'				=> '<svg viewBox="0 0 18 18" fill="none"><path d="M2.16667 0.5C1.72464 0.5 1.30072 0.675595 0.988155 0.988155C0.675595 1.30072 0.5 1.72464 0.5 2.16667V13.8333C0.5 14.2754 0.675595 14.6993 0.988155 15.0118C1.30072 15.3244 1.72464 15.5 2.16667 15.5H9.74167C9.69167 15.225 9.66667 14.95 9.66667 14.6667C9.66667 14.1 9.76667 13.5333 9.95833 13H2.16667L5.08333 9.25L7.16667 11.75L10.0833 8L11.9417 10.475C12.75 9.95 13.7 9.66667 14.6667 9.66667C14.95 9.66667 15.225 9.69167 15.5 9.74167V2.16667C15.5 1.72464 15.3244 1.30072 15.0118 0.988155C14.6993 0.675595 14.2754 0.5 13.8333 0.5H2.16667ZM13.8333 11.3333V13.8333H11.3333V15.5H13.8333V18H15.5V15.5H18V13.8333H15.5V11.3333H13.8333Z"/></svg>',

			'usertimelineIcon'		=> '<svg width="140" height="119" viewBox="0 0 140 119" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1058_6)"><rect width="140" height="119" fill="#F3F4F5"/><rect opacity="0.7" x="59" y="5" width="52" height="114" fill="#F3F4F5"/><g filter="url(#filter0_d_1058_6)"><rect x="22" y="61.2656" width="96" height="37.012" rx="2.31325" fill="white"/></g><rect x="33.5664" y="70.5193" width="71.7108" height="5.78313" rx="1.15663" fill="#DCDDE1"/><rect x="33.5664" y="82.0856" width="41.6386" height="5.78313" rx="1.15663" fill="#DCDDE1"/><g filter="url(#filter1_d_1058_6)"><rect x="22" y="103.277" width="96" height="37.012" rx="2.31325" fill="white"/></g><rect x="33.5664" y="111.375" width="71.7108" height="5.78313" rx="1.15663" fill="#DCDDE1"/><path d="M70.0013 37.9997C72.5796 37.9997 74.668 35.9114 74.668 33.333C74.668 30.7547 72.5796 28.6664 70.0013 28.6664C67.423 28.6664 65.3346 30.7547 65.3346 33.333C65.3346 35.9114 67.423 37.9997 70.0013 37.9997ZM70.0013 40.333C66.8863 40.333 60.668 41.8964 60.668 44.9997V47.333H79.3346V44.9997C79.3346 41.8964 73.1163 40.333 70.0013 40.333Z" fill="#0096CC"/></g><defs><filter id="filter0_d_1058_6" x="18" y="59.2656" width="104" height="45.0121" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_6"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_6" result="shape"/></filter><filter id="filter1_d_1058_6" x="18" y="101.277" width="104" height="45.0121" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_6"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_6" result="shape"/></filter><clipPath id="clip0_1058_6"><rect width="140" height="119" fill="white"/></clipPath></defs></svg>',
			'hashtagIcon'		=> '<svg width="140" height="119" viewBox="0 0 140 119" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1058_11)"><rect width="140" height="119" fill="#F3F4F5"/><rect opacity="0.7" x="59" y="5" width="52" height="114" fill="#F3F4F5"/><g filter="url(#filter0_d_1058_11)"><path d="M17.1133 21.3687C17.1133 20.0605 18.1738 19 19.482 19H122.521C123.829 19 124.889 20.0605 124.889 21.3687V65.1898C124.889 66.498 123.829 67.5585 122.521 67.5585H19.482C18.1738 67.5585 17.1133 66.498 17.1133 65.1898V21.3687Z" fill="white"/></g><rect x="44.3516" y="28.4761" width="66.3238" height="5.92176" rx="1.18435" fill="#D0D1D7"/><rect x="44.3516" y="39.3164" width="35.5306" height="5.92176" rx="1.18435" fill="#D0D1D7"/><rect x="57.3828" y="53.3467" width="22.5027" height="5.92176" rx="1.18435" fill="#B5E5FF"/><circle cx="31.3241" cy="32.0261" r="5.92176" fill="#D0D1D7"/><path d="M48.3302 59.6104H49.6761L50.0252 57.4738H51.2028L51.4257 56.128H50.2481L50.5173 54.4793H51.6949L51.922 53.1334H50.7402L51.0893 50.9969H49.7434L49.3943 53.1334H47.712L48.0611 50.9969H46.7152L46.3661 53.1334H45.1927L44.9656 54.4793H46.1432L45.8741 56.128H44.6964L44.4735 57.4738H45.6512L45.3021 59.6104H46.6479L46.997 57.4738H48.6793L48.3302 59.6104ZM47.2199 56.128L47.4891 54.4793H49.1714L48.9022 56.128H47.2199Z" fill="#0068A0"/><g filter="url(#filter1_d_1058_11)"><path d="M17.1133 75.8497C17.1133 74.5415 18.1738 73.481 19.482 73.481H122.521C123.829 73.481 124.889 74.5415 124.889 75.8497V119.671C124.889 120.979 123.829 122.039 122.521 122.039H19.482C18.1738 122.039 17.1133 120.979 17.1133 119.671V75.8497Z" fill="white"/></g><rect x="44.3516" y="82.954" width="66.3238" height="5.92176" rx="1.18435" fill="#D0D1D7"/><rect x="44.3516" y="93.7974" width="35.5306" height="5.92176" rx="1.18435" fill="#D0D1D7"/><rect x="57.3828" y="107.828" width="22.5027" height="5.92176" rx="1.18435" fill="#B6DDAD"/><circle cx="31.3241" cy="86.5076" r="5.92176" fill="#D0D1D7"/><path d="M48.3302 112.906H49.6761L50.0252 110.769H51.2028L51.4257 109.424H50.2481L50.5173 107.775H51.6949L51.922 106.429H50.7402L51.0893 104.293H49.7434L49.3943 106.429H47.712L48.0611 104.293H46.7152L46.3661 106.429H45.1927L44.9656 107.775H46.1432L45.8741 109.424H44.6964L44.4735 110.769H45.6512L45.3021 112.906H46.6479L46.997 110.769H48.6793L48.3302 112.906ZM47.2199 109.424L47.4891 107.775H49.1714L48.9022 109.424H47.2199Z" fill="#59AB46"/></g><defs><filter id="filter0_d_1058_11" x="13.1133" y="17" width="115.777" height="56.5585" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_11"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_11" result="shape"/></filter><filter id="filter1_d_1058_11" x="13.1133" y="71.481" width="115.777" height="56.5585" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_11"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_11" result="shape"/></filter><clipPath id="clip0_1058_11"><rect width="140" height="119" fill="white"/></clipPath></defs></svg>',
			'homeTimelineIcon'		=> '<svg width="141" height="119" viewBox="0 0 141 119" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1058_16)"><rect width="140" height="119" transform="translate(0.667969)" fill="#F3F4F5"/><path d="M59.668 32.96C64.2638 30.5808 66.7984 28.8384 70.1811 25.6166C73.925 29.0178 76.5089 30.7577 80.7129 32.96" stroke="#0096CC" stroke-width="2.26848" stroke-linecap="round" stroke-linejoin="round"/><mask id="path-2-inside-1_1058_16" fill="white"><path fill-rule="evenodd" clip-rule="evenodd" d="M62.4831 30.8711C61.967 31.0747 61.6589 31.6125 61.762 32.1576L64.2072 45.0823C64.3085 45.6179 64.7766 46.0057 65.3217 46.0057H75.0365C75.5817 46.0057 76.0497 45.6179 76.151 45.0823L78.6029 32.1222C78.7031 31.5929 78.4154 31.0673 77.9204 30.8547C75.0962 29.6413 73.3323 28.5499 70.9938 26.3886C70.537 25.9664 69.828 25.9732 69.3797 26.4044C67.0974 28.5995 65.3529 29.739 62.4831 30.8711ZM70.178 37.4962C71.5875 37.4962 72.73 36.3536 72.73 34.9442C72.73 33.5347 71.5875 32.3921 70.178 32.3921C68.7685 32.3921 67.626 33.5347 67.626 34.9442C67.626 36.3536 68.7685 37.4962 70.178 37.4962Z"/></mask><path fill-rule="evenodd" clip-rule="evenodd" d="M62.4831 30.8711C61.967 31.0747 61.6589 31.6125 61.762 32.1576L64.2072 45.0823C64.3085 45.6179 64.7766 46.0057 65.3217 46.0057H75.0365C75.5817 46.0057 76.0497 45.6179 76.151 45.0823L78.6029 32.1222C78.7031 31.5929 78.4154 31.0673 77.9204 30.8547C75.0962 29.6413 73.3323 28.5499 70.9938 26.3886C70.537 25.9664 69.828 25.9732 69.3797 26.4044C67.0974 28.5995 65.3529 29.739 62.4831 30.8711ZM70.178 37.4962C71.5875 37.4962 72.73 36.3536 72.73 34.9442C72.73 33.5347 71.5875 32.3921 70.178 32.3921C68.7685 32.3921 67.626 33.5347 67.626 34.9442C67.626 36.3536 68.7685 37.4962 70.178 37.4962Z" fill="#0096CC"/><path d="M61.762 32.1576L61.3692 32.2319L61.762 32.1576ZM62.4831 30.8711L62.6298 31.243H62.6298L62.4831 30.8711ZM64.2072 45.0823L63.8144 45.1566L64.2072 45.0823ZM76.151 45.0823L75.7582 45.008L76.151 45.0823ZM78.6029 32.1222L78.2101 32.0479V32.0479L78.6029 32.1222ZM77.9204 30.8547L78.0782 30.4874L77.9204 30.8547ZM70.9938 26.3886L71.2652 26.095V26.095L70.9938 26.3886ZM69.3797 26.4044L69.6569 26.6925L69.3797 26.4044ZM62.1548 32.0833C62.0886 31.7332 62.286 31.3786 62.6298 31.243L62.3364 30.4992C61.6481 30.7707 61.2291 31.4918 61.3692 32.2319L62.1548 32.0833ZM64.6001 45.008L62.1548 32.0833L61.3692 32.2319L63.8144 45.1566L64.6001 45.008ZM65.3217 45.6059C64.9687 45.6059 64.6657 45.3548 64.6001 45.008L63.8144 45.1566C63.9514 45.881 64.5844 46.4055 65.3217 46.4055V45.6059ZM75.0365 45.6059H65.3217V46.4055H75.0365V45.6059ZM75.7582 45.008C75.6926 45.3548 75.3895 45.6059 75.0365 45.6059V46.4055C75.7738 46.4055 76.4068 45.881 76.5439 45.1566L75.7582 45.008ZM78.2101 32.0479L75.7582 45.008L76.5439 45.1566L78.9958 32.1965L78.2101 32.0479ZM77.7626 31.222C78.0898 31.3626 78.2745 31.7073 78.2101 32.0479L78.9958 32.1965C79.1316 31.4785 78.741 30.7721 78.0782 30.4874L77.7626 31.222ZM70.7225 26.6822C73.097 28.8769 74.9001 29.9922 77.7626 31.222L78.0782 30.4874C75.2922 29.2904 73.5676 28.223 71.2652 26.095L70.7225 26.6822ZM69.6569 26.6925C69.9525 26.4082 70.421 26.4036 70.7225 26.6822L71.2652 26.095C70.6531 25.5292 69.7036 25.5382 69.1026 26.1162L69.6569 26.6925ZM62.6298 31.243C65.5505 30.0908 67.3388 28.9221 69.6569 26.6925L69.1026 26.1162C66.856 28.277 65.1553 29.3871 62.3364 30.4992L62.6298 31.243ZM72.3302 34.9442C72.3302 36.1328 71.3666 37.0964 70.178 37.0964V37.896C71.8083 37.896 73.1298 36.5744 73.1298 34.9442H72.3302ZM70.178 32.7919C71.3666 32.7919 72.3302 33.7555 72.3302 34.9442H73.1298C73.1298 33.3139 71.8083 31.9923 70.178 31.9923V32.7919ZM68.0258 34.9442C68.0258 33.7555 68.9894 32.7919 70.178 32.7919V31.9923C68.5477 31.9923 67.2261 33.3139 67.2261 34.9442H68.0258ZM70.178 37.0964C68.9894 37.0964 68.0258 36.1328 68.0258 34.9442H67.2261C67.2261 36.5744 68.5477 37.896 70.178 37.896V37.0964Z" fill="#0096CC" mask="url(#path-2-inside-1_1058_16)"/><g filter="url(#filter0_d_1058_16)"><rect x="22.668" y="62.2656" width="96" height="37.012" rx="2.31325" fill="white"/></g><rect x="34.2344" y="71.5193" width="71.7108" height="5.78313" rx="1.15663" fill="#D0D1D7"/><rect x="34.2344" y="83.0856" width="41.6386" height="5.78313" rx="1.15663" fill="#D0D1D7"/><g filter="url(#filter1_d_1058_16)"><rect x="22.668" y="104.277" width="96" height="37.012" rx="2.31325" fill="white"/></g><rect x="34.2344" y="112.375" width="71.7108" height="5.78313" rx="1.15663" fill="#D0D1D7"/></g><defs><filter id="filter0_d_1058_16" x="18.668" y="60.2656" width="104" height="45.0121" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_16"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_16" result="shape"/></filter><filter id="filter1_d_1058_16" x="18.668" y="102.277" width="104" height="45.0121" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_16"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_16" result="shape"/></filter><clipPath id="clip0_1058_16"><rect width="140" height="119" fill="white" transform="translate(0.667969)"/></clipPath></defs></svg>',
			'searchIcon'		=> '<svg width="140" height="119" viewBox="0 0 140 119" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1058_22)"><rect width="140" height="119" fill="#F3F4F5"/><g filter="url(#filter0_d_1058_22)"><rect x="34" y="35" width="162.162" height="50" rx="5.40541" fill="white"/></g><circle cx="56.57" cy="57.9097" r="9.45946" transform="rotate(-45 56.57 57.9097)" stroke="#0096CC" stroke-width="2.7027"/><path d="M63.2578 64.5973L70.4244 71.7639" stroke="#0096CC" stroke-width="2.7027"/><rect x="93.4609" y="51.2162" width="72.973" height="18.9189" rx="4" fill="#BFE8FF"/><rect opacity="0.7" x="88" y="5" width="52" height="109" fill="url(#paint0_linear_1058_22)"/></g><defs><filter id="filter0_d_1058_22" x="28.5946" y="35" width="172.975" height="60.8108" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="5.40541"/><feGaussianBlur stdDeviation="2.7027"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_22"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_22" result="shape"/></filter><linearGradient id="paint0_linear_1058_22" x1="136" y1="54.5" x2="88.0624" y2="52.5026" gradientUnits="userSpaceOnUse"><stop stop-color="#F1F1F1"/><stop offset="1" stop-color="#F1F1F1" stop-opacity="0"/></linearGradient><clipPath id="clip0_1058_22"><rect width="140" height="119" fill="white"/></clipPath></defs></svg>',
			'mentionsIcon'		=> '<svg width="141" height="119" viewBox="0 0 141 119" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1058_28)"><rect width="140" height="119" transform="translate(0.667969)" fill="#F3F4F5"/><rect opacity="0.7" x="59.668" y="5" width="52" height="114" fill="#F3F4F5"/><g filter="url(#filter0_d_1058_28)"><path d="M18.668 24.2988C18.668 23.0292 19.6972 22 20.9668 22H120.967C122.236 22 123.266 23.0292 123.266 24.2989V66.8276C123.266 68.0972 122.236 69.1264 120.967 69.1264H20.9668C19.6972 69.1264 18.668 68.0972 18.668 66.8276V24.2988Z" fill="white"/></g><rect x="45.1055" y="31.1954" width="28.7356" height="5.74713" rx="1.14943" fill="#B5E5FF"/><rect x="45.1055" y="44.9885" width="64.3678" height="5.74713" rx="1.14943" fill="#D0D1D7"/><rect x="45.1055" y="55.3334" width="40.2299" height="5.74713" rx="1.14943" fill="#D0D1D7"/><path d="M31.734 38.8565C32.8973 38.8565 34.0361 38.583 34.5463 38.2932L34.1422 37.1095C33.7054 37.2891 32.7666 37.5258 31.8278 37.5258C29.1665 37.5258 27.7216 36.1135 27.7134 33.5339C27.7216 31.1991 29.0522 29.4398 31.7666 29.4398C33.7299 29.4398 35.5545 30.3787 35.5504 32.942C35.5545 34.538 35.2606 35.2645 34.6973 35.2645C34.4157 35.2645 34.2442 35.0523 34.2402 34.6727V30.6889H32.9626V31.146H32.9054C32.7666 30.7868 31.9013 30.448 30.9829 30.5868C29.8931 30.746 28.7175 31.6399 28.7094 33.5339C28.7175 35.4564 29.8114 36.4401 31.1013 36.5095C32.0278 36.5625 32.8605 36.1748 33.0524 35.6809H33.1013C33.1911 36.2442 33.5667 36.6278 34.5136 36.5584C36.277 36.4605 36.9505 35.04 36.9464 33.0359C36.9505 30.1337 35.032 28.1255 31.787 28.1255C28.2767 28.1255 26.2644 30.3011 26.2603 33.5828C26.2644 36.9176 28.2604 38.8565 31.734 38.8565ZM31.5462 35.1666C30.4809 35.1666 30.1217 34.3502 30.1176 33.4849C30.1217 32.5542 30.6319 31.9461 31.538 31.9461C32.5707 31.9461 32.8809 32.493 32.885 33.4726C32.8973 34.5829 32.5462 35.1666 31.5462 35.1666Z" fill="#0096CC"/><g filter="url(#filter1_d_1058_28)"><path d="M18.668 77.1699C18.668 75.9003 19.6972 74.8711 20.9668 74.8711H120.967C122.236 74.8711 123.266 75.9003 123.266 77.1699V119.699C123.266 120.968 122.236 121.998 120.967 121.998H20.9668C19.6972 121.998 18.668 120.968 18.668 119.699V77.1699Z" fill="white"/></g><rect x="45.1055" y="84.0665" width="28.7356" height="5.74713" rx="1.14943" fill="#FCE1D5"/><rect x="45.1055" y="97.8596" width="64.3678" height="5.74713" rx="1.14943" fill="#D0D1D7"/><rect x="45.1055" y="108.204" width="40.2299" height="5.74713" rx="1.14943" fill="#D0D1D7"/><path d="M31.734 91.7276C32.8973 91.7276 34.0361 91.4541 34.5463 91.1643L34.1422 89.9806C33.7054 90.1602 32.7666 90.3969 31.8278 90.3969C29.1665 90.3969 27.7216 88.9846 27.7134 86.405C27.7216 84.0702 29.0522 82.3109 31.7666 82.3109C33.7299 82.3109 35.5545 83.2497 35.5504 85.8131C35.5545 87.4091 35.2606 88.1356 34.6973 88.1356C34.4157 88.1356 34.2442 87.9234 34.2402 87.5438V83.56H32.9626V84.0171H32.9054C32.7666 83.6579 31.9013 83.3191 30.9829 83.4579C29.8931 83.6171 28.7175 84.511 28.7094 86.405C28.7175 88.3275 29.8114 89.3112 31.1013 89.3806C32.0278 89.4336 32.8605 89.0459 33.0524 88.552H33.1013C33.1911 89.1152 33.5667 89.4989 34.5136 89.4295C36.277 89.3316 36.9505 87.9111 36.9464 85.907C36.9505 83.0048 35.032 80.9966 31.787 80.9966C28.2767 80.9966 26.2644 83.1722 26.2603 86.4539C26.2644 89.7887 28.2604 91.7276 31.734 91.7276ZM31.5462 88.0377C30.4809 88.0377 30.1217 87.2213 30.1176 86.356C30.1217 85.4253 30.6319 84.8171 31.538 84.8171C32.5707 84.8171 32.8809 85.3641 32.885 86.3437C32.8973 87.454 32.5462 88.0377 31.5462 88.0377Z" fill="#FE544F"/></g><defs><filter id="filter0_d_1058_28" x="14.668" y="20" width="112.598" height="55.1265" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_28"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_28" result="shape"/></filter><filter id="filter1_d_1058_28" x="14.668" y="72.8711" width="112.598" height="55.1265" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_28"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_28" result="shape"/></filter><clipPath id="clip0_1058_28"><rect width="140" height="119" fill="white" transform="translate(0.667969)"/></clipPath></defs></svg>',
			'listsIcon'		=> '<svg width="141" height="119" viewBox="0 0 141 119" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1058_34)"><rect width="140" height="119" transform="translate(0.332031)" fill="#F3F4F5"/><g filter="url(#filter0_d_1058_34)"><path d="M18.332 64.3077C18.332 63.0332 19.3652 62 20.6397 62H121.024C122.299 62 123.332 63.0332 123.332 64.3077V85.0769C123.332 86.3514 122.299 87.3846 121.024 87.3846H20.6397C19.3652 87.3846 18.332 86.3514 18.332 85.0769V64.3077Z" fill="white"/></g><circle cx="31.0246" cy="74.6924" r="6.92308" fill="#B5E5FF"/><rect x="46.0234" y="71.2307" width="54.2308" height="6.92308" rx="1.15385" fill="#BFE8FF"/><g filter="url(#filter1_d_1058_34)"><path d="M18.332 96.6154C18.332 95.3409 19.3652 94.3077 20.6397 94.3077H121.024C122.299 94.3077 123.332 95.3409 123.332 96.6154V117.385C123.332 118.659 122.299 119.692 121.024 119.692H20.6397C19.3652 119.692 18.332 118.659 18.332 117.385V96.6154Z" fill="white"/></g><circle cx="31.0246" cy="106.999" r="6.92308" fill="#B5E5FF"/><rect x="46.0234" y="103.538" width="54.2308" height="6.92308" rx="1.15385" fill="#BFE8FF"/><g filter="url(#filter2_d_1058_34)"><path d="M18.332 128.921C18.332 127.647 19.3652 126.614 20.6397 126.614H121.024C122.299 126.614 123.332 127.647 123.332 128.921V149.69C123.332 150.965 122.299 151.998 121.024 151.998H20.6397C19.3652 151.998 18.332 150.965 18.332 149.69V128.921Z" fill="white"/></g><path d="M69.1654 28.1667H76.1654V30.5H69.1654V28.1667ZM69.1654 32.8333H76.1654V35.1667H69.1654V32.8333ZM69.1654 37.5H76.1654V39.8333H69.1654V37.5ZM64.4987 28.1667H66.832V30.5H64.4987V28.1667ZM64.4987 32.8333H66.832V35.1667H64.4987V32.8333ZM64.4987 37.5H66.832V39.8333H64.4987V37.5ZM60.9987 23.5C60.3544 23.5 59.832 24.0223 59.832 24.6667V43.3333C59.832 43.9777 60.3544 44.5 60.9987 44.5H79.6654C80.3097 44.5 80.832 43.9777 80.832 43.3333V24.6667C80.832 24.0223 80.3097 23.5 79.6654 23.5H60.9987Z" fill="#0096CC"/></g><defs><filter id="filter0_d_1058_34" x="14.332" y="60" width="113" height="33.3846" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_34"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_34" result="shape"/></filter><filter id="filter1_d_1058_34" x="14.332" y="92.3077" width="113" height="33.3846" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="2"/><feGaussianBlur stdDeviation="2"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_34"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_34" result="shape"/></filter><filter id="filter2_d_1058_34" x="3.33203" y="118.537" width="135" height="55.3846" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="6.92308"/><feGaussianBlur stdDeviation="7.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1058_34"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1058_34" result="shape"/></filter><clipPath id="clip0_1058_34"><rect width="140" height="119" fill="white" transform="translate(0.332031)"/></clipPath></defs></svg>',
			'socialwall1Icon'		=> '<svg width="140" height="119" viewBox="0 0 140 119" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="140" height="119" fill="#FEF4EF"/><rect width="109" height="119" fill="#FEF4EF"/><path d="M64.6875 39.5C64.6875 34.1484 60.3516 29.8125 55 29.8125C49.6484 29.8125 45.3125 34.1484 45.3125 39.5C45.3125 44.3438 48.8281 48.3672 53.4766 49.0703V42.3125H51.0156V39.5H53.4766V37.3906C53.4766 34.9688 54.9219 33.6016 57.1094 33.6016C58.2031 33.6016 59.2969 33.7969 59.2969 33.7969V36.1797H58.0859C56.875 36.1797 56.4844 36.9219 56.4844 37.7031V39.5H59.1797L58.75 42.3125H56.4844V49.0703C61.1328 48.3672 64.6875 44.3438 64.6875 39.5Z" fill="#006BFA"/><path d="M96.6953 34.3828C96.4609 33.4453 95.7188 32.7031 94.8203 32.4688C93.1406 32 86.5 32 86.5 32C86.5 32 79.8203 32 78.1406 32.4688C77.2422 32.7031 76.5 33.4453 76.2656 34.3828C75.7969 36.0234 75.7969 39.5391 75.7969 39.5391C75.7969 39.5391 75.7969 43.0156 76.2656 44.6953C76.5 45.6328 77.2422 46.3359 78.1406 46.5703C79.8203 47 86.5 47 86.5 47C86.5 47 93.1406 47 94.8203 46.5703C95.7188 46.3359 96.4609 45.6328 96.6953 44.6953C97.1641 43.0156 97.1641 39.5391 97.1641 39.5391C97.1641 39.5391 97.1641 36.0234 96.6953 34.3828ZM84.3125 42.7031V36.375L89.8594 39.5391L84.3125 42.7031Z" fill="#EB2121"/><path d="M54 70.0078C51.5 70.0078 49.5078 72.0391 49.5078 74.5C49.5078 77 51.5 78.9922 54 78.9922C56.4609 78.9922 58.4922 77 58.4922 74.5C58.4922 72.0391 56.4609 70.0078 54 70.0078ZM54 77.4297C52.3984 77.4297 51.0703 76.1406 51.0703 74.5C51.0703 72.8984 52.3594 71.6094 54 71.6094C55.6016 71.6094 56.8906 72.8984 56.8906 74.5C56.8906 76.1406 55.6016 77.4297 54 77.4297ZM59.7031 69.8516C59.7031 69.2656 59.2344 68.7969 58.6484 68.7969C58.0625 68.7969 57.5938 69.2656 57.5938 69.8516C57.5938 70.4375 58.0625 70.9062 58.6484 70.9062C59.2344 70.9062 59.7031 70.4375 59.7031 69.8516ZM62.6719 70.9062C62.5938 69.5 62.2812 68.25 61.2656 67.2344C60.25 66.2188 59 65.9062 57.5938 65.8281C56.1484 65.75 51.8125 65.75 50.3672 65.8281C48.9609 65.9062 47.75 66.2188 46.6953 67.2344C45.6797 68.25 45.3672 69.5 45.2891 70.9062C45.2109 72.3516 45.2109 76.6875 45.2891 78.1328C45.3672 79.5391 45.6797 80.75 46.6953 81.8047C47.75 82.8203 48.9609 83.1328 50.3672 83.2109C51.8125 83.2891 56.1484 83.2891 57.5938 83.2109C59 83.1328 60.25 82.8203 61.2656 81.8047C62.2812 80.75 62.5938 79.5391 62.6719 78.1328C62.75 76.6875 62.75 72.3516 62.6719 70.9062ZM60.7969 79.6562C60.5234 80.4375 59.8984 81.0234 59.1562 81.3359C57.9844 81.8047 55.25 81.6875 54 81.6875C52.7109 81.6875 49.9766 81.8047 48.8438 81.3359C48.0625 81.0234 47.4766 80.4375 47.1641 79.6562C46.6953 78.5234 46.8125 75.7891 46.8125 74.5C46.8125 73.25 46.6953 70.5156 47.1641 69.3438C47.4766 68.6016 48.0625 68.0156 48.8438 67.7031C49.9766 67.2344 52.7109 67.3516 54 67.3516C55.25 67.3516 57.9844 67.2344 59.1562 67.7031C59.8984 67.9766 60.4844 68.6016 60.7969 69.3438C61.2656 70.5156 61.1484 73.25 61.1484 74.5C61.1484 75.7891 61.2656 78.5234 60.7969 79.6562Z" fill="url(#paint0_linear_1058_41)"/><path d="M95.9297 70.4375C96.7109 69.8516 97.4141 69.1484 97.9609 68.3281C97.2578 68.6406 96.4375 68.875 95.6172 68.9531C96.4766 68.4453 97.1016 67.6641 97.4141 66.6875C96.6328 67.1562 95.7344 67.5078 94.8359 67.7031C94.0547 66.8828 93 66.4141 91.8281 66.4141C89.5625 66.4141 87.7266 68.25 87.7266 70.5156C87.7266 70.8281 87.7656 71.1406 87.8438 71.4531C84.4453 71.2578 81.3984 69.6172 79.3672 67.1562C79.0156 67.7422 78.8203 68.4453 78.8203 69.2266C78.8203 70.6328 79.5234 71.8828 80.6562 72.625C79.9922 72.5859 79.3281 72.4297 78.7812 72.1172V72.1562C78.7812 74.1484 80.1875 75.7891 82.0625 76.1797C81.75 76.2578 81.3594 76.3359 81.0078 76.3359C80.7344 76.3359 80.5 76.2969 80.2266 76.2578C80.7344 77.8984 82.2578 79.0703 84.0547 79.1094C82.6484 80.2031 80.8906 80.8672 78.9766 80.8672C78.625 80.8672 78.3125 80.8281 78 80.7891C79.7969 81.9609 81.9453 82.625 84.2891 82.625C91.8281 82.625 95.9297 76.4141 95.9297 70.9844C95.9297 70.7891 95.9297 70.6328 95.9297 70.4375Z" fill="#0096CC"/><defs><linearGradient id="paint0_linear_1058_41" x1="51.4125" y1="113.55" x2="105.527" y2="78.0397" gradientUnits="userSpaceOnUse"><stop stop-color="white"/><stop offset="0.147864" stop-color="#F6640E"/><stop offset="0.443974" stop-color="#BA03A7"/><stop offset="0.733337" stop-color="#6A01B9"/><stop offset="1" stop-color="#6B01B9"/></linearGradient></defs></svg>',

			'user'	=> '<svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 0C4.53043 0 5.03914 0.210714 5.41421 0.585786C5.78929 0.960859 6 1.46957 6 2C6 2.53043 5.78929 3.03914 5.41421 3.41421C5.03914 3.78929 4.53043 4 4 4C3.46957 4 2.96086 3.78929 2.58579 3.41421C2.21071 3.03914 2 2.53043 2 2C2 1.46957 2.21071 0.960859 2.58579 0.585786C2.96086 0.210714 3.46957 0 4 0ZM4 5C6.21 5 8 5.895 8 7V8H0V7C0 5.895 1.79 5 4 5Z"/></svg>',
			'hashtag' => '<svg viewBox="0 0 18 18" fill="none"><path d="M17.3607 4.1775H14.0152L14.618 1.266C14.6328 1.18021 14.6288 1.09223 14.6064 1.00812C14.5839 0.924001 14.5436 0.845742 14.488 0.778722C14.4324 0.711703 14.363 0.657514 14.2845 0.619882C14.206 0.582251 14.1203 0.56207 14.0332 0.560727H12.8276C12.6883 0.557321 12.5521 0.602311 12.4422 0.688037C12.3323 0.773763 12.2555 0.894929 12.2249 1.03091L11.61 4.1775H8.3549L8.9577 1.266C8.97229 1.18215 8.96897 1.09617 8.94795 1.0137C8.92692 0.931226 8.88867 0.854142 8.83572 0.787518C8.78276 0.720894 8.71629 0.666239 8.64069 0.62715C8.56509 0.588061 8.48207 0.565423 8.3971 0.560727H7.1915C7.05216 0.557321 6.91594 0.602311 6.80604 0.688037C6.69613 0.773763 6.61933 0.894929 6.58871 1.03091L5.98591 4.1775H2.36914C2.22811 4.17466 2.09056 4.22136 1.98042 4.30947C1.87028 4.39759 1.79452 4.52153 1.76634 4.65974L1.51919 5.86533C1.50109 5.95393 1.50315 6.04546 1.52522 6.13316C1.5473 6.22085 1.58882 6.30245 1.64671 6.37192C1.7046 6.44139 1.77737 6.49694 1.85965 6.53446C1.94192 6.57199 2.03158 6.59052 2.12199 6.58869H5.46751L4.47892 11.4111H0.862146C0.721125 11.4082 0.583571 11.4549 0.473429 11.543C0.363287 11.6311 0.287532 11.7551 0.259351 11.8933L0.0122042 13.0989C-0.00589975 13.1875 -0.00383898 13.279 0.0182337 13.3667C0.0403064 13.4544 0.0818254 13.536 0.139715 13.6055C0.197605 13.6749 0.270382 13.7305 0.352656 13.768C0.43493 13.8055 0.524592 13.8241 0.615 13.8222H3.98463L3.38183 16.7338C3.36677 16.821 3.37112 16.9106 3.39459 16.996C3.41806 17.0814 3.46006 17.1606 3.51761 17.2279C3.57517 17.2953 3.64685 17.3491 3.72757 17.3856C3.80829 17.4221 3.89606 17.4403 3.98463 17.439H5.19022C5.3244 17.4356 5.45359 17.3875 5.55732 17.3023C5.66105 17.2171 5.73339 17.0998 5.76288 16.9688L6.38979 13.8222H9.64488L9.04209 16.7338C9.02749 16.8176 9.03081 16.9036 9.05184 16.9861C9.07286 17.0685 9.11111 17.1456 9.16407 17.2122C9.21702 17.2789 9.28349 17.3335 9.35909 17.3726C9.43469 17.4117 9.51771 17.4343 9.60269 17.439H10.8083C10.9476 17.4424 11.0838 17.3974 11.1937 17.3117C11.3037 17.226 11.3805 17.1048 11.4111 16.9688L12.044 13.8222H15.6608C15.8018 13.8251 15.9394 13.7784 16.0495 13.6903C16.1596 13.6022 16.2354 13.4782 16.2636 13.34L16.5047 12.1344C16.5228 12.0458 16.5207 11.9543 16.4987 11.8666C16.4766 11.7789 16.4351 11.6973 16.3772 11.6278C16.3193 11.5584 16.2465 11.5028 16.1642 11.4653C16.082 11.4278 15.9923 11.4092 15.9019 11.4111H12.5383L13.5209 6.58869H17.1376C17.2787 6.59153 17.4162 6.54483 17.5264 6.45672C17.6365 6.36861 17.7123 6.24466 17.7404 6.10645L17.9876 4.90086C18.0063 4.8102 18.0038 4.71645 17.9804 4.62689C17.957 4.53733 17.9133 4.45436 17.8527 4.3844C17.7921 4.31445 17.7162 4.2594 17.6308 4.22352C17.5455 4.18764 17.4531 4.1719 17.3607 4.1775ZM10.1271 11.4111H6.87202L7.86061 6.58869H11.1157L10.1271 11.4111Z"/></svg>',
			'mention' => '<svg viewBox="0 0 18 18"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.24419 0.172937C8.99002 -0.174331 10.7996 0.00389957 12.4442 0.685088C14.0887 1.36628 15.4943 2.51983 16.4832 3.99987C17.4722 5.47992 18 7.21997 18 9.00001V10.3333C18 11.1879 17.6605 12.0075 17.0562 12.6118C16.452 13.2161 15.6324 13.5556 14.7778 13.5556C13.9232 13.5556 13.1036 13.2161 12.4993 12.6118C12.3867 12.4992 12.2833 12.3791 12.1896 12.2527C11.3384 13.0874 10.1933 13.5556 9.00001 13.5556C7.7918 13.5556 6.63307 13.0756 5.77874 12.2213C4.92441 11.3669 4.44445 10.2082 4.44445 9.00001C4.44445 7.7918 4.92441 6.63307 5.77874 5.77874C6.63307 4.92441 7.7918 4.44445 9.00001 4.44445C10.2082 4.44445 11.3669 4.92441 12.2213 5.77874C13.0756 6.63307 13.5556 7.7918 13.5556 9.00001V10.3333C13.5556 10.6575 13.6843 10.9684 13.9135 11.1976C14.1428 11.4268 14.4536 11.5556 14.7778 11.5556C15.1019 11.5556 15.4128 11.4268 15.642 11.1976C15.8712 10.9684 16 10.6575 16 10.3333V9.00001C16 7.61554 15.5895 6.26216 14.8203 5.11101C14.0511 3.95987 12.9579 3.06266 11.6788 2.53285C10.3997 2.00303 8.99224 1.86441 7.63437 2.13451C6.27651 2.4046 5.02922 3.07129 4.05026 4.05026C3.07129 5.02922 2.4046 6.27651 2.13451 7.63437C1.86441 8.99224 2.00303 10.3997 2.53285 11.6788C3.06266 12.9579 3.95987 14.0511 5.11101 14.8203C6.26216 15.5895 7.61554 16 9.00001 16L9.001 16C10.2297 16.0012 11.4363 15.6782 12.4987 15.0627C12.9766 14.7859 13.5884 14.9488 13.8653 15.4267C14.1421 15.9046 13.9792 16.5164 13.5013 16.7933C12.1329 17.586 10.5796 18.0016 8.99901 18L9.00001 17V18C8.99968 18 8.99934 18 8.99901 18C7.21933 17.9998 5.47964 17.472 3.99987 16.4832C2.51983 15.4943 1.36628 14.0887 0.685088 12.4442C0.00389957 10.7996 -0.17433 8.99002 0.172936 7.24419C0.520204 5.49836 1.37737 3.89472 2.63604 2.63604C3.89472 1.37737 5.49836 0.520204 7.24419 0.172937ZM11.5556 9.00001C11.5556 8.32223 11.2863 7.67221 10.8071 7.19295C10.3278 6.7137 9.67778 6.44445 9.00001 6.44445C8.32223 6.44445 7.67221 6.7137 7.19295 7.19295C6.7137 7.67221 6.44445 8.32223 6.44445 9.00001C6.44445 9.67778 6.7137 10.3278 7.19295 10.8071C7.67221 11.2863 8.32223 11.5556 9.00001 11.5556C9.67778 11.5556 10.3278 11.2863 10.8071 10.8071C11.2863 10.3278 11.5556 9.67778 11.5556 9.00001Z"/></svg>',
			'homeTimeline' => '<svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.2045 18.0682C18.2045 18.3153 18.1064 18.5523 17.9316 18.7271C17.7569 18.9018 17.5199 19 17.2727 19H4.22727C3.98014 19 3.74313 18.9018 3.56838 18.7271C3.39363 18.5523 3.29545 18.3153 3.29545 18.0682V9.6818H0.5L10.1229 0.93389C10.2944 0.77779 10.5181 0.691284 10.75 0.691284C10.9819 0.691284 11.2056 0.77779 11.3771 0.93389L21 9.6818H18.2045V18.0682ZM10.75 13.4091C11.3678 13.4091 11.9604 13.1636 12.3972 12.7268C12.8341 12.2899 13.0795 11.6974 13.0795 11.0795C13.0795 10.4617 12.8341 9.86916 12.3972 9.43229C11.9604 8.99541 11.3678 8.74998 10.75 8.74998C10.1322 8.74998 9.53964 8.99541 9.10276 9.43229C8.66589 9.86916 8.42045 10.4617 8.42045 11.0795C8.42045 11.6974 8.66589 12.2899 9.10276 12.7268C9.53964 13.1636 10.1322 13.4091 10.75 13.4091Z" fill="#0096CC"/></svg>',
			'search' => '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 11H11.71L11.43 10.73C12.4439 9.55402 13.0011 8.0527 13 6.5C13 5.21442 12.6188 3.95772 11.9046 2.8888C11.1903 1.81988 10.1752 0.986755 8.98744 0.494786C7.79972 0.00281635 6.49279 -0.125905 5.23191 0.124899C3.97104 0.375703 2.81285 0.994767 1.90381 1.90381C0.994767 2.81285 0.375703 3.97104 0.124899 5.23191C-0.125905 6.49279 0.00281635 7.79972 0.494786 8.98744C0.986755 10.1752 1.81988 11.1903 2.8888 11.9046C3.95772 12.6188 5.21442 13 6.5 13C8.11 13 9.59 12.41 10.73 11.43L11 11.71V12.5L16 17.49L17.49 16L12.5 11ZM6.5 11C4.01 11 2 8.99 2 6.5C2 4.01 4.01 2 6.5 2C8.99 2 11 4.01 11 6.5C11 8.99 8.99 11 6.5 11Z" fill="#0096CC"/></svg>',
			'lists' => '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.1984 18H1.79844C1.55974 18 1.33082 17.9052 1.16204 17.7364C0.993259 17.5676 0.898438 17.3387 0.898438 17.1V0.899999C0.898438 0.661305 0.993259 0.432386 1.16204 0.263604C1.33082 0.094821 1.55974 0 1.79844 0H16.1984C16.4371 0 16.666 0.094821 16.8348 0.263604C17.0036 0.432386 17.0984 0.661305 17.0984 0.899999V17.1C17.0984 17.3387 17.0036 17.5676 16.8348 17.7364C16.666 17.9052 16.4371 18 16.1984 18ZM5.39843 4.5V6.29999H12.5984V4.5H5.39843ZM5.39843 8.09999V9.89999H12.5984V8.09999H5.39843ZM5.39843 11.7V13.5H12.5984V11.7H5.39843Z" fill="#0096CC"/></svg>',

			'addNewList' => '<svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.33333 7.83333H10.6667V9.83333H12.6667V11.1667H10.6667V13.1667H9.33333V11.1667H7.33333V9.83333H9.33333V7.83333ZM1.33333 0.5H10.6667C11.4067 0.5 12 1.09333 12 1.83333V7.03333C11.5933 6.8 11.1467 6.63333 10.6667 6.55333V1.83333H1.33333V11.1667H6.05333C6.13333 11.6467 6.3 12.0933 6.53333 12.5H1.33333C0.593333 12.5 0 11.9067 0 11.1667V1.83333C0 1.09333 0.593333 0.5 1.33333 0.5ZM2.66667 3.16667H9.33333V4.5H2.66667V3.16667ZM2.66667 5.83333H9.33333V6.55333C8.76667 6.64667 8.24667 6.86 7.78667 7.16667H2.66667V5.83333ZM2.66667 8.5H6V9.83333H2.66667V8.5Z" fill="#0068A0"/></svg>',
			'tooltipHelpSvg' => '<svg width="20" height="21" viewBox="0 0 20 21" fill="#0068A0" xmlns="http://www.w3.org/2000/svg"><path d="M9.1665 8H10.8332V6.33333H9.1665V8ZM9.99984 17.1667C6.32484 17.1667 3.33317 14.175 3.33317 10.5C3.33317 6.825 6.32484 3.83333 9.99984 3.83333C13.6748 3.83333 16.6665 6.825 16.6665 10.5C16.6665 14.175 13.6748 17.1667 9.99984 17.1667ZM9.99984 2.16666C8.90549 2.16666 7.82186 2.38221 6.81081 2.801C5.79976 3.21979 4.8811 3.83362 4.10728 4.60744C2.54448 6.17024 1.6665 8.28986 1.6665 10.5C1.6665 12.7101 2.54448 14.8298 4.10728 16.3926C4.8811 17.1664 5.79976 17.7802 6.81081 18.199C7.82186 18.6178 8.90549 18.8333 9.99984 18.8333C12.21 18.8333 14.3296 17.9554 15.8924 16.3926C17.4552 14.8298 18.3332 12.7101 18.3332 10.5C18.3332 9.40565 18.1176 8.32202 17.6988 7.31097C17.28 6.29992 16.6662 5.38126 15.8924 4.60744C15.1186 3.83362 14.1999 3.21979 13.1889 2.801C12.1778 2.38221 11.0942 2.16666 9.99984 2.16666ZM9.1665 14.6667H10.8332V9.66666H9.1665V14.6667Z" fill="#0068A0"/></svg>',

			'union' => '<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 6.74992V0.333252H0V6.74992H10Z"/><path d="M0 8.24992H10V9.49992H0V8.24992Z"/><path d="M6 10.7499H0V11.9999H6V10.7499Z"/></svg>',
			'strokeThickness' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.3996 4.0002H1.59961V3.2002H14.3996V4.0002Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.3996 7.9999H1.59961V6.3999H14.3996V7.9999Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.3996 12.7999H1.59961V10.3999H14.3996V12.7999Z"/></svg>',
			'linkIcon' => '<svg width="17" height="10" viewBox="0 0 17 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.75008 4.99998C1.75008 3.57498 2.90841 2.41665 4.33342 2.41665H7.66675V0.833313H4.33342C3.22835 0.833313 2.16854 1.2723 1.38714 2.0537C0.605735 2.8351 0.166748 3.89491 0.166748 4.99998C0.166748 6.10505 0.605735 7.16486 1.38714 7.94626C2.16854 8.72766 3.22835 9.16665 4.33342 9.16665H7.66675V7.58331H4.33342C2.90841 7.58331 1.75008 6.42498 1.75008 4.99998ZM5.16675 5.83331H11.8334V4.16665H5.16675V5.83331ZM12.6667 0.833313H9.33342V2.41665H12.6667C14.0917 2.41665 15.2501 3.57498 15.2501 4.99998C15.2501 6.42498 14.0917 7.58331 12.6667 7.58331H9.33342V9.16665H12.6667C13.7718 9.16665 14.8316 8.72766 15.613 7.94626C16.3944 7.16486 16.8334 6.10505 16.8334 4.99998C16.8334 3.89491 16.3944 2.8351 15.613 2.0537C14.8316 1.2723 13.7718 0.833313 12.6667 0.833313Z" fill="#0068A0"/></svg>',

			'feed_template' => '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 0H2C0.9 0 0 0.9 0 2V16C0 17.1 0.9 18 2 18H16C17.1 18 18 17.1 18 16V2C18 0.9 17.1 0 16 0ZM2 16V2H8V16H2ZM16 16H10V9H16V16ZM16 7H10V2H16V7Z" fill="#141B38"/></svg>',

			'defaultTemplate' 			=> '<svg width="262" height="200" viewBox="0 0 262 200" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1652_59144)"><rect width="262" height="200" fill="#F3F4F5"/><g filter="url(#filter0_ddd_1652_59144)"><rect x="26" y="36" width="211" height="187" rx="2" fill="white"/></g><rect x="56" y="55" width="18" height="18" rx="9" fill="#F9BBA0"/><rect x="82" y="57" width="19" height="6" rx="1" fill="#8C8F9A"/><circle cx="107" cy="60" r="3" fill="#0096CC"/><path d="M105.398 60L106.423 61.0246L108.544 58.9033" stroke="white" stroke-width="0.8"/><rect x="113" y="55" width="26" height="10" rx="1" fill="#0096CC"/><path d="M117.554 62V60.458H119.06V59.474H117.554V58.67H119.354V57.692H116.42V62H117.554ZM123.042 60.386C123.042 59.462 122.31 58.712 121.356 58.712C120.402 58.712 119.67 59.462 119.67 60.386C119.67 61.31 120.402 62.06 121.356 62.06C122.31 62.06 123.042 61.31 123.042 60.386ZM120.738 60.386C120.738 59.882 121.038 59.636 121.356 59.636C121.674 59.636 121.974 59.882 121.974 60.386C121.974 60.89 121.674 61.142 121.356 61.142C121.038 61.142 120.738 60.89 120.738 60.386ZM124.505 62V57.692H123.467V62H124.505ZM126.204 62V57.692H125.166V62H126.204ZM130.003 60.386C130.003 59.462 129.271 58.712 128.317 58.712C127.363 58.712 126.631 59.462 126.631 60.386C126.631 61.31 127.363 62.06 128.317 62.06C129.271 62.06 130.003 61.31 130.003 60.386ZM127.699 60.386C127.699 59.882 127.999 59.636 128.317 59.636C128.635 59.636 128.935 59.882 128.935 60.386C128.935 60.89 128.635 61.142 128.317 61.142C127.999 61.142 127.699 60.89 127.699 60.386ZM133.056 62H134.076L134.988 58.772H133.98L133.53 60.542L133.08 58.772H132.054L131.58 60.542L131.13 58.772H130.128L131.034 62H132.06L132.558 60.17L133.056 62Z" fill="white"/><rect x="82" y="68" width="73" height="6" rx="1" fill="#DCDDE1"/><line x1="56" y1="85.75" x2="213" y2="85.75" stroke="#DCDDE1" stroke-width="0.5"/><rect x="56" y="98" width="18" height="18" rx="2" fill="#F9BBA0"/><rect x="82" y="99" width="19" height="6" rx="1" fill="#8C8F9A"/><circle cx="108" cy="102" r="4" fill="#0096CC"/><path d="M105.867 102L107.233 103.366L110.062 100.538" stroke="white" stroke-width="1.06667"/><rect x="82" y="112" width="105.314" height="6" rx="1" fill="#DCDDE1"/><rect x="82" y="122" width="116.076" height="6" rx="1" fill="#DCDDE1"/><rect x="82" y="132" width="99" height="6" rx="1" fill="#DCDDE1"/><line x1="56" y1="149.75" x2="213" y2="149.75" stroke="#DCDDE1" stroke-width="0.5"/><rect x="56" y="162" width="18" height="18" rx="2" fill="#F9BBA0"/><rect x="82" y="163" width="19" height="6" rx="1" fill="#8C8F9A"/><circle cx="108" cy="166" r="4" fill="#0096CC"/><path d="M105.867 166L107.233 167.366L110.062 164.538" stroke="white" stroke-width="1.06667"/><rect x="82" y="176" width="105.314" height="6" rx="1" fill="#DCDDE1"/><rect x="82" y="186" width="116.076" height="6" rx="1" fill="#DCDDE1"/><rect x="82" y="196" width="99" height="6" rx="1" fill="#DCDDE1"/></g><defs><filter id="filter0_ddd_1652_59144" x="13" y="29" width="237" height="213" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="6"/><feGaussianBlur stdDeviation="6.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59144"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.11 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59144" result="effect2_dropShadow_1652_59144"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="3"/><feGaussianBlur stdDeviation="3"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0"/><feBlend mode="normal" in2="effect2_dropShadow_1652_59144" result="effect3_dropShadow_1652_59144"/><feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow_1652_59144" result="shape"/></filter><clipPath id="clip0_1652_59144"><rect width="262" height="200" fill="white"/></clipPath></defs></svg>',
			'masonryCardsTemplate' 		=> '<svg width="262" height="200" viewBox="0 0 262 200" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1652_59202)"><rect width="262" height="200" transform="translate(0.5)" fill="#F3F4F5"/><g filter="url(#filter0_dd_1652_59202)"><rect x="34" y="57" width="63.6871" height="86.5898" rx="0.737139" fill="white"/><rect x="38" y="61" width="8" height="8" rx="1" fill="#43A6DB"/><rect x="49.2969" y="63" width="24" height="4" rx="0.824675" fill="#D0D1D7"/><rect x="38" y="72" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M38 79.4123C38 79.1846 38.1846 79 38.4123 79H72.224C72.4518 79 72.6364 79.1846 72.6364 79.4123V82.5877C72.6364 82.8154 72.4518 83 72.224 83H38.4123C38.1846 83 38 82.8154 38 82.5877V79.4123Z" fill="#DCDDE1"/><g clip-path="url(#clip1_1652_59202)"><rect x="38" y="87" width="55.6871" height="47.8312" rx="1" fill="#43A6DB"/><circle cx="38.4099" cy="134.419" r="38.3474" fill="#86D0F9"/></g><g clip-path="url(#clip2_1652_59202)"><path d="M38.5938 138.786C38.5938 138.021 39.153 137.723 39.8429 137.723H40.9136C41.6034 137.723 42.1627 138.241 42.1627 138.88C42.1627 139.044 42.1258 139.2 42.0592 139.342C41.6639 140.181 40.4847 140.263 39.6644 140.698L39.6644 139.871C39.6644 139.871 38.5938 139.424 38.5938 138.786Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip3_1652_59202)"><path d="M47.8594 139.938L48.5864 140.665L49.3135 139.938" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M46.8906 137.757H47.6177C47.8748 137.757 48.1213 137.859 48.3031 138.041C48.4849 138.222 48.5871 138.469 48.5871 138.726V140.665" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M46.4072 138.484L45.6802 137.757L44.9531 138.484" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M47.3761 140.665H46.6491C46.392 140.665 46.1454 140.563 45.9636 140.381C45.7818 140.199 45.6797 139.953 45.6797 139.695V137.757" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip4_1652_59202)"><path d="M53.0908 137.823C52.5488 137.823 52.1094 138.249 52.1094 138.776C52.1094 139.729 53.2693 140.595 53.8938 140.797C54.5184 140.595 55.6783 139.729 55.6783 138.776C55.6783 138.249 55.2389 137.823 54.6969 137.823C54.3649 137.823 54.0714 137.983 53.8938 138.227C53.8033 138.102 53.6831 138 53.5433 137.93C53.4036 137.859 53.2483 137.822 53.0908 137.823Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter1_dd_1652_59202)"><rect x="34" y="147.59" width="63.6871" height="38.7586" rx="0.737139" fill="white"/><rect x="38" y="151.59" width="8" height="8" rx="1" fill="#43A6DB"/><rect x="49.2969" y="153.59" width="24" height="4" rx="0.824675" fill="#D0D1D7"/><rect x="38" y="162.59" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M38 170.002C38 169.774 38.1846 169.59 38.4123 169.59H72.224C72.4518 169.59 72.6364 169.774 72.6364 170.002V173.177C72.6364 173.405 72.4518 173.59 72.224 173.59H38.4123C38.1846 173.59 38 173.405 38 173.177V170.002Z" fill="#DCDDE1"/><g clip-path="url(#clip5_1652_59202)"><path d="M38.5938 181.544C38.5938 180.779 39.153 180.482 39.8429 180.482H40.9136C41.6034 180.482 42.1627 181 42.1627 181.639C42.1627 181.803 42.1258 181.959 42.0592 182.1C41.6639 182.94 40.4847 183.022 39.6644 183.456L39.6644 182.63C39.6644 182.63 38.5938 182.183 38.5938 181.544Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip6_1652_59202)"><path d="M47.8594 182.696L48.5864 183.423L49.3135 182.696" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M46.8906 180.515H47.6177C47.8748 180.515 48.1213 180.617 48.3031 180.799C48.4849 180.981 48.5871 181.228 48.5871 181.485V183.423" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M46.4072 181.242L45.6802 180.515L44.9531 181.242" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M47.3761 183.423H46.6491C46.392 183.423 46.1454 183.321 45.9636 183.14C45.7818 182.958 45.6797 182.711 45.6797 182.454V180.515" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip7_1652_59202)"><path d="M53.0908 180.581C52.5488 180.581 52.1094 181.008 52.1094 181.534C52.1094 182.487 53.2693 183.354 53.8938 183.555C54.5184 183.354 55.6783 182.487 55.6783 181.534C55.6783 181.008 55.2389 180.581 54.6969 180.581C54.3649 180.581 54.0714 180.741 53.8938 180.986C53.8033 180.861 53.6831 180.759 53.5433 180.688C53.4036 180.618 53.2483 180.581 53.0908 180.581Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter2_dd_1652_59202)"><rect x="34" y="190.348" width="63.6871" height="86.5898" rx="0.737139" fill="white"/><rect x="38" y="194.348" width="8" height="8" rx="1" fill="#43A6DB"/><rect x="49.2969" y="196.348" width="24" height="4" rx="0.824675" fill="#D0D1D7"/></g><g filter="url(#filter3_dd_1652_59202)"><rect x="101.688" y="57" width="63.6871" height="59.7586" rx="0.737139" fill="white"/><rect x="105.688" y="61" width="8" height="8" rx="1" fill="#43A6DB"/><rect x="116.984" y="63" width="24" height="4" rx="0.824675" fill="#D0D1D7"/><rect x="105.688" y="72" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><rect x="105.688" y="79" width="53" height="4" rx="0.412338" fill="#DCDDE1"/><rect x="105.688" y="86" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><rect x="105.688" y="93" width="50" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M105.688 100.412C105.688 100.185 105.872 100 106.1 100H139.912C140.139 100 140.324 100.185 140.324 100.412V103.588C140.324 103.815 140.139 104 139.912 104H106.1C105.872 104 105.688 103.815 105.688 103.588V100.412Z" fill="#DCDDE1"/><g clip-path="url(#clip8_1652_59202)"><path d="M106.281 111.954C106.281 111.19 106.841 110.892 107.53 110.892H108.601C109.291 110.892 109.85 111.41 109.85 112.049C109.85 112.213 109.813 112.369 109.747 112.511C109.351 113.35 108.172 113.432 107.352 113.866L107.352 113.04C107.352 113.04 106.281 112.593 106.281 111.954Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip9_1652_59202)"><path d="M115.547 113.106L116.274 113.833L117.001 113.106" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M114.578 110.926H115.305C115.562 110.926 115.809 111.028 115.991 111.209C116.172 111.391 116.275 111.638 116.275 111.895V113.834" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M114.095 111.653L113.368 110.926L112.641 111.653" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M115.064 113.834H114.337C114.079 113.834 113.833 113.732 113.651 113.55C113.469 113.368 113.367 113.121 113.367 112.864V110.926" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip10_1652_59202)"><path d="M120.778 110.991C120.236 110.991 119.797 111.418 119.797 111.944C119.797 112.897 120.957 113.764 121.581 113.965C122.206 113.764 123.366 112.897 123.366 111.944C123.366 111.418 122.926 110.991 122.384 110.991C122.052 110.991 121.759 111.151 121.581 111.396C121.491 111.271 121.371 111.169 121.231 111.098C121.091 111.028 120.936 110.991 120.778 110.991Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter4_dd_1652_59202)"><rect x="101.688" y="120.759" width="63.6871" height="75.7586" rx="0.737139" fill="white"/><rect x="105.688" y="124.759" width="8" height="8" rx="1" fill="#43A6DB"/><rect x="116.984" y="126.759" width="24" height="4" rx="0.824675" fill="#D0D1D7"/><rect x="105.688" y="135.759" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M105.688 143.171C105.688 142.943 105.872 142.759 106.1 142.759H139.912C140.139 142.759 140.324 142.943 140.324 143.171V146.346C140.324 146.574 140.139 146.759 139.912 146.759H106.1C105.872 146.759 105.688 146.574 105.688 146.346V143.171Z" fill="#DCDDE1"/><g clip-path="url(#clip11_1652_59202)"><rect x="105.688" y="150.759" width="55.6871" height="37" rx="1" fill="#43A6DB"/><rect x="87.5" y="200.127" width="49" height="49" transform="rotate(-45 87.5 200.127)" fill="#86D0F9"/></g><g clip-path="url(#clip12_1652_59202)"><path d="M106.281 191.713C106.281 190.948 106.841 190.651 107.53 190.651H108.601C109.291 190.651 109.85 191.169 109.85 191.807C109.85 191.972 109.813 192.128 109.747 192.269C109.351 193.109 108.172 193.191 107.352 193.625L107.352 192.799C107.352 192.799 106.281 192.352 106.281 191.713Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip13_1652_59202)"><path d="M115.547 192.865L116.274 193.592L117.001 192.865" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M114.578 190.684H115.305C115.562 190.684 115.809 190.786 115.991 190.968C116.172 191.15 116.275 191.396 116.275 191.653V193.592" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M114.095 191.411L113.368 190.684L112.641 191.411" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M115.064 193.592H114.337C114.079 193.592 113.833 193.49 113.651 193.308C113.469 193.127 113.367 192.88 113.367 192.623V190.684" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip14_1652_59202)"><path d="M120.778 190.75C120.236 190.75 119.797 191.177 119.797 191.703C119.797 192.656 120.957 193.522 121.581 193.724C122.206 193.522 123.366 192.656 123.366 191.703C123.366 191.177 122.926 190.75 122.384 190.75C122.052 190.75 121.759 190.91 121.581 191.155C121.491 191.03 121.371 190.928 121.231 190.857C121.091 190.787 120.936 190.75 120.778 190.75Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter5_dd_1652_59202)"><rect x="169.375" y="57" width="63.6871" height="38.7586" rx="0.737139" fill="white"/><rect x="173.375" y="61" width="8" height="8" rx="1" fill="#43A6DB"/><rect x="184.672" y="63" width="24" height="4" rx="0.824675" fill="#D0D1D7"/><rect x="173.375" y="72" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M173.375 79.4123C173.375 79.1846 173.56 79 173.787 79H207.599C207.827 79 208.011 79.1846 208.011 79.4123V82.5877C208.011 82.8154 207.827 83 207.599 83H173.787C173.56 83 173.375 82.8154 173.375 82.5877V79.4123Z" fill="#DCDDE1"/><g clip-path="url(#clip15_1652_59202)"><path d="M173.969 90.9544C173.969 90.1896 174.528 89.8922 175.218 89.8922H176.289C176.978 89.8922 177.538 90.41 177.538 91.0488C177.538 91.213 177.501 91.3691 177.434 91.5106C177.039 92.3502 175.86 92.4323 175.039 92.8663L175.039 92.0402C175.039 92.0402 173.969 91.5932 173.969 90.9544Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip16_1652_59202)"><path d="M183.234 92.1064L183.961 92.8335L184.688 92.1064" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M182.266 89.9255H182.993C183.25 89.9255 183.496 90.0277 183.678 90.2095C183.86 90.3913 183.962 90.6378 183.962 90.8949V92.8337" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M181.782 90.6526L181.055 89.9255L180.328 90.6526" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M182.751 92.8337H182.024C181.767 92.8337 181.52 92.7316 181.339 92.5498C181.157 92.368 181.055 92.1214 181.055 91.8643V89.9255" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip17_1652_59202)"><path d="M188.466 89.9913C187.924 89.9913 187.484 90.4181 187.484 90.9444C187.484 91.8975 188.644 92.7639 189.269 92.9654C189.893 92.7639 191.053 91.8975 191.053 90.9444C191.053 90.4181 190.614 89.9913 190.072 89.9913C189.74 89.9913 189.446 90.1514 189.269 90.3963C189.178 90.2711 189.058 90.169 188.918 90.0985C188.779 90.028 188.623 89.9912 188.466 89.9913Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter6_dd_1652_59202)"><rect x="169.375" y="99.7585" width="63.6871" height="86.5898" rx="0.737139" fill="white"/><rect x="173.375" y="103.759" width="8" height="8" rx="1" fill="#43A6DB"/><rect x="184.672" y="105.759" width="24" height="4" rx="0.824675" fill="#D0D1D7"/><rect x="173.375" y="114.759" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M173.375 122.171C173.375 121.943 173.56 121.759 173.787 121.759H207.599C207.827 121.759 208.011 121.943 208.011 122.171V125.346C208.011 125.574 207.827 125.759 207.599 125.759H173.787C173.56 125.759 173.375 125.574 173.375 125.346V122.171Z" fill="#DCDDE1"/><g clip-path="url(#clip18_1652_59202)"><rect x="173.375" y="129.759" width="55.6871" height="47.8312" rx="1" fill="#43A6DB"/><circle cx="222.785" cy="192.177" r="38.3474" fill="#86D0F9"/></g><g clip-path="url(#clip19_1652_59202)"><path d="M173.969 181.544C173.969 180.779 174.528 180.482 175.218 180.482H176.289C176.978 180.482 177.538 181 177.538 181.639C177.538 181.803 177.501 181.959 177.434 182.1C177.039 182.94 175.86 183.022 175.039 183.456L175.039 182.63C175.039 182.63 173.969 182.183 173.969 181.544Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip20_1652_59202)"><path d="M183.234 182.696L183.961 183.423L184.688 182.696" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M182.266 180.515H182.993C183.25 180.515 183.496 180.617 183.678 180.799C183.86 180.981 183.962 181.228 183.962 181.485V183.423" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M181.782 181.242L181.055 180.515L180.328 181.242" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M182.751 183.423H182.024C181.767 183.423 181.52 183.321 181.339 183.14C181.157 182.958 181.055 182.711 181.055 182.454V180.515" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip21_1652_59202)"><path d="M188.466 180.581C187.924 180.581 187.484 181.008 187.484 181.534C187.484 182.487 188.644 183.354 189.269 183.555C189.893 183.354 191.053 182.487 191.053 181.534C191.053 181.008 190.614 180.581 190.072 180.581C189.74 180.581 189.446 180.741 189.269 180.986C189.178 180.861 189.058 180.759 188.918 180.688C188.779 180.618 188.623 180.581 188.466 180.581Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter7_dd_1652_59202)"><rect x="169.375" y="190.348" width="63.6871" height="38.7586" rx="0.737139" fill="white"/><rect x="173.375" y="194.348" width="8" height="8" rx="1" fill="#43A6DB"/><rect x="184.672" y="196.348" width="24" height="4" rx="0.824675" fill="#D0D1D7"/></g><rect x="34.5" y="23" width="18" height="18" rx="9" fill="#43A6DB"/><rect x="60.5" y="25" width="19" height="6" rx="1" fill="#8C8F9A"/><circle cx="85.5" cy="28" r="3" fill="#0096CC"/><path d="M83.8984 28L84.9231 29.0246L87.0444 26.9033" stroke="white" stroke-width="0.8"/><rect x="91.5" y="23" width="26" height="10" rx="1" fill="#0096CC"/><path d="M96.054 30V28.458H97.56V27.474H96.054V26.67H97.854V25.692H94.92V30H96.054ZM101.542 28.386C101.542 27.462 100.81 26.712 99.8562 26.712C98.9022 26.712 98.1702 27.462 98.1702 28.386C98.1702 29.31 98.9022 30.06 99.8562 30.06C100.81 30.06 101.542 29.31 101.542 28.386ZM99.2382 28.386C99.2382 27.882 99.5382 27.636 99.8562 27.636C100.174 27.636 100.474 27.882 100.474 28.386C100.474 28.89 100.174 29.142 99.8562 29.142C99.5382 29.142 99.2382 28.89 99.2382 28.386ZM103.005 30V25.692H101.967V30H103.005ZM104.704 30V25.692H103.666V30H104.704ZM108.503 28.386C108.503 27.462 107.771 26.712 106.817 26.712C105.863 26.712 105.131 27.462 105.131 28.386C105.131 29.31 105.863 30.06 106.817 30.06C107.771 30.06 108.503 29.31 108.503 28.386ZM106.199 28.386C106.199 27.882 106.499 27.636 106.817 27.636C107.135 27.636 107.435 27.882 107.435 28.386C107.435 28.89 107.135 29.142 106.817 29.142C106.499 29.142 106.199 28.89 106.199 28.386ZM111.556 30H112.576L113.488 26.772H112.48L112.03 28.542L111.58 26.772H110.554L110.08 28.542L109.63 26.772H108.628L109.534 30H110.56L111.058 28.17L111.556 30Z" fill="white"/><rect x="60.5" y="36" width="73" height="6" rx="1" fill="#DCDDE1"/></g><defs><filter id="filter0_dd_1652_59202" x="32" y="55.7371" width="67.6875" height="90.5897" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59202"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59202" result="effect2_dropShadow_1652_59202"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59202" result="shape"/></filter><filter id="filter1_dd_1652_59202" x="32" y="146.327" width="67.6875" height="42.7585" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59202"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59202" result="effect2_dropShadow_1652_59202"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59202" result="shape"/></filter><filter id="filter2_dd_1652_59202" x="32" y="189.086" width="67.6875" height="90.5897" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59202"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59202" result="effect2_dropShadow_1652_59202"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59202" result="shape"/></filter><filter id="filter3_dd_1652_59202" x="99.6875" y="55.7371" width="67.6875" height="63.7585" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59202"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59202" result="effect2_dropShadow_1652_59202"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59202" result="shape"/></filter><filter id="filter4_dd_1652_59202" x="99.6875" y="119.496" width="67.6875" height="79.7585" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59202"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59202" result="effect2_dropShadow_1652_59202"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59202" result="shape"/></filter><filter id="filter5_dd_1652_59202" x="167.375" y="55.7371" width="67.6875" height="42.7585" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59202"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59202" result="effect2_dropShadow_1652_59202"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59202" result="shape"/></filter><filter id="filter6_dd_1652_59202" x="167.375" y="98.4957" width="67.6875" height="90.5897" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59202"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59202" result="effect2_dropShadow_1652_59202"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59202" result="shape"/></filter><filter id="filter7_dd_1652_59202" x="167.375" y="189.086" width="67.6875" height="42.7585" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59202"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59202" result="effect2_dropShadow_1652_59202"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59202" result="shape"/></filter><clipPath id="clip0_1652_59202"><rect width="262" height="200" fill="white" transform="translate(0.5)"/></clipPath><clipPath id="clip1_1652_59202"><rect x="38" y="87" width="55.6871" height="47.8312" rx="1" fill="white"/></clipPath><clipPath id="clip2_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(38 136.831)"/></clipPath><clipPath id="clip3_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(44.7578 136.831)"/></clipPath><clipPath id="clip4_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(51.5156 136.831)"/></clipPath><clipPath id="clip5_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(38 179.59)"/></clipPath><clipPath id="clip6_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(44.7578 179.59)"/></clipPath><clipPath id="clip7_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(51.5156 179.59)"/></clipPath><clipPath id="clip8_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(105.688 110)"/></clipPath><clipPath id="clip9_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(112.445 110)"/></clipPath><clipPath id="clip10_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(119.203 110)"/></clipPath><clipPath id="clip11_1652_59202"><rect x="105.688" y="150.759" width="55.6871" height="37" rx="1" fill="white"/></clipPath><clipPath id="clip12_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(105.688 189.759)"/></clipPath><clipPath id="clip13_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(112.445 189.759)"/></clipPath><clipPath id="clip14_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(119.203 189.759)"/></clipPath><clipPath id="clip15_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(173.375 89)"/></clipPath><clipPath id="clip16_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(180.133 89)"/></clipPath><clipPath id="clip17_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(186.891 89)"/></clipPath><clipPath id="clip18_1652_59202"><rect x="173.375" y="129.759" width="55.6871" height="47.8312" rx="1" fill="white"/></clipPath><clipPath id="clip19_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(173.375 179.59)"/></clipPath><clipPath id="clip20_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(180.133 179.59)"/></clipPath><clipPath id="clip21_1652_59202"><rect width="4.75858" height="4.75858" fill="white" transform="translate(186.891 179.59)"/></clipPath></defs></svg>',
			'simpleCarouselTemplate' 	=> '<svg width="262" height="200" viewBox="0 0 262 200" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="262" height="200" fill="#F3F4F5"/><path d="M35.2564 46.826H37.076L39.1193 39.6819H39.1989L41.2372 46.826H43.0568L45.9304 36.6442H43.9467L42.1122 44.1314H42.0227L40.0589 36.6442H38.2543L36.2955 44.1265H36.201L34.3665 36.6442H32.3828L35.2564 46.826ZM49.7312 46.9752C51.511 46.9752 52.734 46.1052 53.0522 44.7778L51.3718 44.5888C51.1282 45.2351 50.5316 45.5732 49.756 45.5732C48.5927 45.5732 47.8221 44.8076 47.8072 43.5001H53.1268V42.9482C53.1268 40.2685 51.516 39.0903 49.6367 39.0903C47.4492 39.0903 46.0224 40.6961 46.0224 43.0526C46.0224 45.4489 47.4293 46.9752 49.7312 46.9752ZM47.8121 42.287C47.8668 41.3126 48.5877 40.4922 49.6616 40.4922C50.6957 40.4922 51.3917 41.2479 51.4016 42.287H47.8121ZM56.1756 36.6442H54.7438V37.6684C54.7438 38.4787 54.4256 39.1002 54.0627 39.6471L54.8979 40.189C55.6287 39.5824 56.1756 38.5384 56.1756 37.6584V36.6442ZM57.3427 46.826H59.1424V42.3367C59.1424 41.3672 59.8732 40.6812 60.8626 40.6812C61.1658 40.6812 61.5437 40.7359 61.6978 40.7856V39.13C61.5337 39.1002 61.2504 39.0803 61.0515 39.0803C60.1765 39.0803 59.4457 39.5775 59.1673 40.4624H59.0877V39.1897H57.3427V46.826ZM65.9597 46.9752C67.7395 46.9752 68.9625 46.1052 69.2807 44.7778L67.6003 44.5888C67.3567 45.2351 66.7601 45.5732 65.9846 45.5732C64.8212 45.5732 64.0506 44.8076 64.0357 43.5001H69.3553V42.9482C69.3553 40.2685 67.7445 39.0903 65.8652 39.0903C63.6777 39.0903 62.2509 40.6961 62.2509 43.0526C62.2509 45.4489 63.6578 46.9752 65.9597 46.9752ZM64.0407 42.287C64.0953 41.3126 64.8162 40.4922 65.8901 40.4922C66.9242 40.4922 67.6202 41.2479 67.6301 42.287H64.0407ZM77.6815 46.9752C79.9187 46.9752 81.3406 45.3992 81.3406 43.0377C81.3406 40.6712 79.9187 39.0903 77.6815 39.0903C75.4442 39.0903 74.0224 40.6712 74.0224 43.0377C74.0224 45.3992 75.4442 46.9752 77.6815 46.9752ZM77.6914 45.5334C76.4535 45.5334 75.8469 44.4297 75.8469 43.0327C75.8469 41.6357 76.4535 40.5171 77.6914 40.5171C78.9094 40.5171 79.516 41.6357 79.516 43.0327C79.516 44.4297 78.9094 45.5334 77.6914 45.5334ZM84.6678 42.3516C84.6678 41.2479 85.334 40.6116 86.2836 40.6116C87.2132 40.6116 87.7701 41.2231 87.7701 42.2422V46.826H89.5698V41.9638C89.5748 40.1343 88.5307 39.0903 86.9547 39.0903C85.8113 39.0903 85.0257 39.6371 84.6777 40.4873H84.5882V39.1897H82.8681V46.826H84.6678V42.3516ZM94.5041 38.1904H97.6511V46.826H99.4806V38.1904H102.628V36.6442H94.5041V38.1904ZM104.815 46.826H106.694L108.126 41.6655H108.231L109.662 46.826H111.537L113.699 39.1897H111.86L110.537 44.5292H110.463L109.091 39.1897H107.276L105.904 44.559H105.834L104.492 39.1897H102.657L104.815 46.826ZM114.956 46.826H116.756V39.1897H114.956V46.826ZM115.861 38.1059C116.433 38.1059 116.9 37.6684 116.9 37.1314C116.9 36.5895 116.433 36.152 115.861 36.152C115.284 36.152 114.817 36.5895 114.817 37.1314C114.817 37.6684 115.284 38.1059 115.861 38.1059ZM122.42 39.1897H120.913V37.3601H119.113V39.1897H118.03V40.5817H119.113V44.8275C119.104 46.2643 120.148 46.9702 121.5 46.9305C122.012 46.9155 122.365 46.8161 122.559 46.7515L122.256 45.3445C122.156 45.3694 121.952 45.4141 121.729 45.4141C121.276 45.4141 120.913 45.255 120.913 44.5292V40.5817H122.42V39.1897ZM127.738 39.1897H126.232V37.3601H124.432V39.1897H123.348V40.5817H124.432V44.8275C124.422 46.2643 125.466 46.9702 126.818 46.9305C127.33 46.9155 127.683 46.8161 127.877 46.7515L127.574 45.3445C127.474 45.3694 127.271 45.4141 127.047 45.4141C126.594 45.4141 126.232 45.255 126.232 44.5292V40.5817H127.738V39.1897ZM132.542 46.9752C134.322 46.9752 135.545 46.1052 135.863 44.7778L134.182 44.5888C133.939 45.2351 133.342 45.5732 132.567 45.5732C131.403 45.5732 130.633 44.8076 130.618 43.5001H135.937V42.9482C135.937 40.2685 134.327 39.0903 132.447 39.0903C130.26 39.0903 128.833 40.6961 128.833 43.0526C128.833 45.4489 130.24 46.9752 132.542 46.9752ZM130.623 42.287C130.677 41.3126 131.398 40.4922 132.472 40.4922C133.506 40.4922 134.202 41.2479 134.212 42.287H130.623ZM137.46 46.826H139.26V42.3367C139.26 41.3672 139.99 40.6812 140.98 40.6812C141.283 40.6812 141.661 40.7359 141.815 40.7856V39.13C141.651 39.1002 141.368 39.0803 141.169 39.0803C140.294 39.0803 139.563 39.5775 139.284 40.4624H139.205V39.1897H137.46V46.826ZM145.213 36.6442H143.289L143.448 43.8332H145.049L145.213 36.6442ZM144.249 46.9354C144.835 46.9354 145.337 46.4482 145.342 45.8417C145.337 45.2451 144.835 44.7579 144.249 44.7579C143.642 44.7579 143.15 45.2451 143.155 45.8417C143.15 46.4482 143.642 46.9354 144.249 46.9354Z" fill="#141B38"/><g filter="url(#filter0_dd_1652_59440)"><rect x="32" y="64" width="63.6871" height="86.5898" rx="0.737139" fill="white"/><rect x="36" y="68" width="8" height="8" rx="1" fill="#B6DDAD"/><rect x="47.2969" y="70" width="20" height="4" rx="0.824675" fill="#8C8F9A"/><rect x="36" y="79" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M36 86.4123C36 86.1846 36.1846 86 36.4123 86H70.224C70.4518 86 70.6364 86.1846 70.6364 86.4123V89.5877C70.6364 89.8154 70.4518 90 70.224 90H36.4123C36.1846 90 36 89.8154 36 89.5877V86.4123Z" fill="#DCDDE1"/><g clip-path="url(#clip0_1652_59440)"><rect x="36" y="94" width="55.6871" height="47.8312" rx="1" fill="#B6DDAD"/><circle cx="36.4099" cy="141.419" r="38.3474" fill="#96CE89"/></g><g clip-path="url(#clip1_1652_59440)"><path d="M36.5938 145.786C36.5938 145.021 37.153 144.723 37.8429 144.723H38.9136C39.6034 144.723 40.1627 145.241 40.1627 145.88C40.1627 146.044 40.1258 146.2 40.0592 146.342C39.6639 147.181 38.4847 147.263 37.6644 147.698L37.6644 146.871C37.6644 146.871 36.5938 146.424 36.5938 145.786Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip2_1652_59440)"><path d="M45.8594 146.938L46.5864 147.665L47.3135 146.938" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M44.8906 144.757H45.6177C45.8748 144.757 46.1213 144.859 46.3031 145.041C46.4849 145.222 46.5871 145.469 46.5871 145.726V147.665" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M44.4072 145.484L43.6802 144.757L42.9531 145.484" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M45.3761 147.665H44.6491C44.392 147.665 44.1454 147.563 43.9636 147.381C43.7818 147.199 43.6797 146.953 43.6797 146.695V144.757" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip3_1652_59440)"><path d="M51.0908 144.823C50.5488 144.823 50.1094 145.249 50.1094 145.776C50.1094 146.729 51.2693 147.595 51.8938 147.797C52.5184 147.595 53.6783 146.729 53.6783 145.776C53.6783 145.249 53.2389 144.823 52.6969 144.823C52.3649 144.823 52.0714 144.983 51.8938 145.227C51.8033 145.102 51.6831 145 51.5433 144.93C51.4036 144.859 51.2483 144.822 51.0908 144.823Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter1_dd_1652_59440)"><rect x="99.0391" y="64" width="63.6871" height="38.7586" rx="0.737139" fill="white"/><rect x="103.039" y="68" width="8" height="8" rx="1" fill="#B6DDAD"/><rect x="114.336" y="70" width="20" height="4" rx="0.824675" fill="#8C8F9A"/><rect x="103.039" y="79" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M103.039 86.4123C103.039 86.1846 103.224 86 103.451 86H137.263C137.491 86 137.675 86.1846 137.675 86.4123V89.5877C137.675 89.8154 137.491 90 137.263 90H103.451C103.224 90 103.039 89.8154 103.039 89.5877V86.4123Z" fill="#DCDDE1"/><g clip-path="url(#clip4_1652_59440)"><path d="M103.633 97.9544C103.633 97.1896 104.192 96.8922 104.882 96.8922H105.953C106.642 96.8922 107.202 97.41 107.202 98.0488C107.202 98.213 107.165 98.3691 107.098 98.5106C106.703 99.3502 105.524 99.4323 104.703 99.8663L104.703 99.0402C104.703 99.0402 103.633 98.5932 103.633 97.9544Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip5_1652_59440)"><path d="M112.898 99.1064L113.625 99.8335L114.353 99.1064" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M111.93 96.9255H112.657C112.914 96.9255 113.16 97.0277 113.342 97.2095C113.524 97.3913 113.626 97.6378 113.626 97.8949V99.8337" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M111.446 97.6526L110.719 96.9255L109.992 97.6526" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M112.415 99.8337H111.688C111.431 99.8337 111.184 99.7316 111.003 99.5498C110.821 99.368 110.719 99.1214 110.719 98.8643V96.9255" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip6_1652_59440)"><path d="M118.13 96.9913C117.588 96.9913 117.148 97.4181 117.148 97.9444C117.148 98.8975 118.308 99.7639 118.933 99.9654C119.557 99.7639 120.717 98.8975 120.717 97.9444C120.717 97.4181 120.278 96.9913 119.736 96.9913C119.404 96.9913 119.11 97.1514 118.933 97.3963C118.842 97.2711 118.722 97.169 118.582 97.0985C118.443 97.028 118.287 96.9912 118.13 96.9913Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter2_dd_1652_59440)"><rect x="166.078" y="64" width="63.6871" height="77.7586" rx="0.737139" fill="white"/><rect x="170.078" y="68" width="8" height="8" rx="1" fill="#B6DDAD"/><rect x="181.375" y="70" width="20" height="4" rx="0.824675" fill="#8C8F9A"/><rect x="170.078" y="79" width="55.6871" height="4" rx="0.412338" fill="#DCDDE1"/><path d="M170.078 86.4123C170.078 86.1846 170.263 86 170.49 86H204.302C204.53 86 204.714 86.1846 204.714 86.4123V89.5877C204.714 89.8154 204.53 90 204.302 90H170.49C170.263 90 170.078 89.8154 170.078 89.5877V86.4123Z" fill="#DCDDE1"/><g clip-path="url(#clip7_1652_59440)"><rect x="170.078" y="94" width="55.6871" height="39" rx="1" fill="#B6DDAD"/><circle cx="219.566" cy="151.438" r="38.3474" fill="#96CE89"/></g><g clip-path="url(#clip8_1652_59440)"><path d="M170.672 136.954C170.672 136.19 171.231 135.892 171.921 135.892H172.992C173.682 135.892 174.241 136.41 174.241 137.049C174.241 137.213 174.204 137.369 174.137 137.511C173.742 138.35 172.563 138.432 171.743 138.866L171.743 138.04C171.743 138.04 170.672 137.593 170.672 136.954Z" stroke="#434960" stroke-width="0.35" stroke-linejoin="round"/></g><g clip-path="url(#clip9_1652_59440)"><path d="M179.938 138.106L180.665 138.833L181.392 138.106" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M178.969 135.926H179.696C179.953 135.926 180.199 136.028 180.381 136.209C180.563 136.391 180.665 136.638 180.665 136.895V138.834" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M178.485 136.653L177.758 135.926L177.031 136.653" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/><path d="M179.454 138.834H178.727C178.47 138.834 178.224 138.732 178.042 138.55C177.86 138.368 177.758 138.121 177.758 137.864V135.926" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip10_1652_59440)"><path d="M185.169 135.991C184.627 135.991 184.188 136.418 184.188 136.944C184.188 137.897 185.347 138.764 185.972 138.965C186.597 138.764 187.756 137.897 187.756 136.944C187.756 136.418 187.317 135.991 186.775 135.991C186.443 135.991 186.15 136.151 185.972 136.396C185.881 136.271 185.761 136.169 185.621 136.098C185.482 136.028 185.326 135.991 185.169 135.991Z" stroke="#434960" stroke-width="0.35" stroke-linecap="round" stroke-linejoin="round"/></g></g><circle cx="117" cy="163" r="2" fill="#2C324C"/><circle cx="124" cy="163" r="2" fill="#D0D1D7"/><circle cx="131" cy="163" r="2" fill="#D0D1D7"/><circle cx="138" cy="163" r="2" fill="#D0D1D7"/><circle cx="145" cy="163" r="2" fill="#D0D1D7"/><defs><filter id="filter0_dd_1652_59440" x="31.0786" y="63.8157" width="65.5303" height="88.4326" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="0.460712"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59440"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.184285"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59440" result="effect2_dropShadow_1652_59440"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59440" result="shape"/></filter><filter id="filter1_dd_1652_59440" x="98.1176" y="63.8157" width="65.5303" height="40.6014" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="0.460712"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59440"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.184285"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59440" result="effect2_dropShadow_1652_59440"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59440" result="shape"/></filter><filter id="filter2_dd_1652_59440" x="165.157" y="63.8157" width="65.5303" height="79.6014" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.737139"/><feGaussianBlur stdDeviation="0.460712"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59440"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.184285"/><feGaussianBlur stdDeviation="0.184285"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59440" result="effect2_dropShadow_1652_59440"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59440" result="shape"/></filter><clipPath id="clip0_1652_59440"><rect x="36" y="94" width="55.6871" height="47.8312" rx="1" fill="white"/></clipPath><clipPath id="clip1_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(36 143.831)"/></clipPath><clipPath id="clip2_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(42.7578 143.831)"/></clipPath><clipPath id="clip3_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(49.5156 143.831)"/></clipPath><clipPath id="clip4_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(103.039 96)"/></clipPath><clipPath id="clip5_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(109.797 96)"/></clipPath><clipPath id="clip6_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(116.555 96)"/></clipPath><clipPath id="clip7_1652_59440"><rect x="170.078" y="94" width="55.6871" height="39" rx="1" fill="white"/></clipPath><clipPath id="clip8_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(170.078 135)"/></clipPath><clipPath id="clip9_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(176.836 135)"/></clipPath><clipPath id="clip10_1652_59440"><rect width="4.75858" height="4.75858" fill="white" transform="translate(183.594 135)"/></clipPath></defs></svg>',
			'simpleCardsTemplate' 		=> '<svg width="262" height="200" viewBox="0 0 262 200" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1652_59523)"><rect width="262" height="200" transform="translate(0.5)" fill="#F3F4F5"/><rect x="40" y="33" width="18" height="18" rx="9" fill="#F9BBA0"/><rect x="66" y="35" width="19" height="6" rx="1" fill="#8C8F9A"/><circle cx="91" cy="38" r="3" fill="#0096CC"/><path d="M89.3984 38L90.4231 39.0246L92.5444 36.9033" stroke="white" stroke-width="0.8"/><rect x="97" y="33" width="26" height="10" rx="1" fill="#0096CC"/><path d="M101.554 40V38.458H103.06V37.474H101.554V36.67H103.354V35.692H100.42V40H101.554ZM107.042 38.386C107.042 37.462 106.31 36.712 105.356 36.712C104.402 36.712 103.67 37.462 103.67 38.386C103.67 39.31 104.402 40.06 105.356 40.06C106.31 40.06 107.042 39.31 107.042 38.386ZM104.738 38.386C104.738 37.882 105.038 37.636 105.356 37.636C105.674 37.636 105.974 37.882 105.974 38.386C105.974 38.89 105.674 39.142 105.356 39.142C105.038 39.142 104.738 38.89 104.738 38.386ZM108.505 40V35.692H107.467V40H108.505ZM110.204 40V35.692H109.166V40H110.204ZM114.003 38.386C114.003 37.462 113.271 36.712 112.317 36.712C111.363 36.712 110.631 37.462 110.631 38.386C110.631 39.31 111.363 40.06 112.317 40.06C113.271 40.06 114.003 39.31 114.003 38.386ZM111.699 38.386C111.699 37.882 111.999 37.636 112.317 37.636C112.635 37.636 112.935 37.882 112.935 38.386C112.935 38.89 112.635 39.142 112.317 39.142C111.999 39.142 111.699 38.89 111.699 38.386ZM117.056 40H118.076L118.988 36.772H117.98L117.53 38.542L117.08 36.772H116.054L115.58 38.542L115.13 36.772H114.128L115.034 40H116.06L116.558 38.17L117.056 40Z" fill="white"/><rect x="66" y="46" width="73" height="6" rx="1" fill="#DCDDE1"/><g filter="url(#filter0_dd_1652_59523)"><rect x="40" y="64.684" width="179.912" height="56.9119" rx="0.5" fill="white"/><rect x="48.4531" y="73.1399" width="18" height="18" rx="2" fill="#F9BBA0"/><rect x="74.4531" y="74.1399" width="19" height="6" rx="1" fill="#8C8F9A"/><circle cx="100.453" cy="77.1399" r="4" fill="#0096CC"/><path d="M98.3203 77.1399L99.6865 78.5061L102.515 75.6776" stroke="white" stroke-width="1.06667"/><rect x="74.4531" y="87.1399" width="127.314" height="6" rx="1" fill="#DCDDE1"/><rect x="74.4531" y="97.1399" width="137" height="6" rx="1" fill="#DCDDE1"/><rect x="74.4531" y="107.14" width="102" height="6" rx="1" fill="#DCDDE1"/></g><g filter="url(#filter1_dd_1652_59523)"><rect x="40" y="125.824" width="179.912" height="106" rx="0.5" fill="white"/><rect x="48.4531" y="134.28" width="18" height="18" rx="2" fill="#F9BBA0"/><rect x="74.4531" y="135.28" width="19" height="6" rx="1" fill="#8C8F9A"/><circle cx="100.453" cy="138.28" r="4" fill="#0096CC"/><path d="M98.3203 138.28L99.6865 139.646L102.515 136.818" stroke="white" stroke-width="1.06667"/><rect x="74.4531" y="148.28" width="127.314" height="6" rx="1" fill="#DCDDE1"/><rect x="74.4531" y="158.28" width="137" height="6" rx="1" fill="#DCDDE1"/><rect x="74.4531" y="168.28" width="102" height="6" rx="1" fill="#DCDDE1"/><g clip-path="url(#clip1_1652_59523)"><rect x="74.4531" y="182.28" width="137" height="46" rx="2" fill="#F9BBA0"/><circle cx="190" cy="284" r="103" fill="#FCE1D5"/></g></g></g><defs><filter id="filter0_dd_1652_59523" x="35" y="63.684" width="189.914" height="66.9119" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4"/><feGaussianBlur stdDeviation="2.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59523"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59523" result="effect2_dropShadow_1652_59523"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59523" result="shape"/></filter><filter id="filter1_dd_1652_59523" x="35" y="124.824" width="189.914" height="116" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4"/><feGaussianBlur stdDeviation="2.5"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59523"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1"/><feGaussianBlur stdDeviation="1"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59523" result="effect2_dropShadow_1652_59523"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59523" result="shape"/></filter><clipPath id="clip0_1652_59523"><rect width="262" height="200" fill="white" transform="translate(0.5)"/></clipPath><clipPath id="clip1_1652_59523"><rect x="74.4531" y="182.28" width="137" height="46" rx="2" fill="white"/></clipPath></defs></svg>',
			'showcaseCarouselTemplate' 	=> '<svg width="262" height="200" viewBox="0 0 262 200" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="262" height="200" fill="#F3F4F5"/><circle cx="117" cy="169" r="2" fill="#2C324C"/><circle cx="124" cy="169" r="2" fill="#D0D1D7"/><circle cx="131" cy="169" r="2" fill="#D0D1D7"/><circle cx="138" cy="169" r="2" fill="#D0D1D7"/><circle cx="145" cy="169" r="2" fill="#D0D1D7"/><g filter="url(#filter0_dd_1652_59574)"><rect x="53" y="31" width="156" height="127.083" rx="1.22326" fill="white"/><rect x="59.6406" y="37.6379" width="10.9482" height="10.9482" rx="1.65947" fill="#FFD066"/><rect x="76.0625" y="40.375" width="26.002" height="5.47411" rx="1.36853" fill="#8C8F9A"/><circle cx="111.645" cy="43.1119" r="4.10558" fill="#0096CC"/><path d="M109.453 43.1119L110.855 44.5142L113.758 41.6111" stroke="white" stroke-width="1.09482"/><rect x="59.6406" y="55.224" width="142.724" height="4.10558" rx="0.684264" fill="#DCDDE1"/><path d="M59.6406 64.1194C59.6406 63.7415 59.947 63.4352 60.3249 63.4352H116.435C116.812 63.4352 117.119 63.7415 117.119 64.1194V66.8565C117.119 67.2344 116.812 67.5408 116.435 67.5408H60.3249C59.947 67.5408 59.6406 67.2344 59.6406 66.8565V64.1194Z" fill="#DCDDE1"/><g clip-path="url(#clip0_1652_59574)"><rect width="142.724" height="69.37" transform="translate(59.6406 74.1787)" fill="#FFDF99"/><circle cx="60.324" cy="152.869" r="63.6365" fill="#FFD066"/></g><path d="M60.625 150.111C60.625 148.842 61.5531 148.348 62.6979 148.348H64.4747C65.6195 148.348 66.5476 149.208 66.5476 150.268C66.5476 150.54 66.4863 150.799 66.3758 151.034C65.7198 152.427 63.763 152.563 62.4018 153.284L62.4018 151.913C62.4018 151.913 60.625 151.171 60.625 150.111Z" stroke="#434960" stroke-width="0.580816" stroke-linejoin="round"/><g clip-path="url(#clip1_1652_59574)"><path d="M76.0156 152.023L77.2221 153.229L78.4286 152.023" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M74.4062 148.403H75.6128C76.0394 148.403 76.4486 148.573 76.7503 148.875C77.052 149.176 77.2214 149.585 77.2214 150.012V153.229" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M73.6005 149.61L72.394 148.403L71.1875 149.61" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M75.2058 153.229H73.9993C73.5727 153.229 73.1635 153.06 72.8618 152.758C72.5601 152.457 72.3906 152.047 72.3906 151.621V148.403" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip2_1652_59574)"><path d="M84.6834 148.513C83.7839 148.513 83.0547 149.221 83.0547 150.094C83.0547 151.676 84.9795 153.114 86.016 153.448C87.0524 153.114 88.9772 151.676 88.9772 150.094C88.9772 149.221 88.248 148.513 87.3485 148.513C86.7977 148.513 86.3106 148.778 86.016 149.185C85.8658 148.977 85.6663 148.807 85.4343 148.69C85.2023 148.573 84.9448 148.513 84.6834 148.513Z" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/></g></g><defs><filter id="filter0_dd_1652_59574" x="51.4709" y="30.6942" width="159.058" height="130.141" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.22326"/><feGaussianBlur stdDeviation="0.76454"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59574"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.305816"/><feGaussianBlur stdDeviation="0.305816"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59574" result="effect2_dropShadow_1652_59574"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59574" result="shape"/></filter><clipPath id="clip0_1652_59574"><rect width="142.724" height="69.37" fill="white" transform="translate(59.6406 74.1787)"/></clipPath><clipPath id="clip1_1652_59574"><rect width="7.89675" height="7.89675" fill="white" transform="translate(70.8594 146.868)"/></clipPath><clipPath id="clip2_1652_59574"><rect width="7.89675" height="7.89675" fill="white" transform="translate(82.0703 146.868)"/></clipPath></defs></svg>',
			'latestTweetTemplate' 		=> '<svg width="262" height="200" viewBox="0 0 262 200" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="262" height="200" transform="translate(0.5)" fill="#F3F4F5"/><g filter="url(#filter0_dd_1652_59614)"><rect x="53" y="31" width="156" height="127.083" rx="1.22326" fill="white"/><rect x="59.6406" y="37.6379" width="10.9482" height="10.9482" rx="1.65947" fill="#FFD066"/><rect x="76.0625" y="40.375" width="26.002" height="5.47411" rx="1.36853" fill="#8C8F9A"/><circle cx="111.645" cy="43.1119" r="4.10558" fill="#0096CC"/><path d="M109.453 43.1119L110.855 44.5142L113.758 41.6111" stroke="white" stroke-width="1.09482"/><rect x="59.6406" y="55.224" width="142.724" height="4.10558" rx="0.684264" fill="#DCDDE1"/><path d="M59.6406 64.1194C59.6406 63.7415 59.947 63.4352 60.3249 63.4352H116.435C116.812 63.4352 117.119 63.7415 117.119 64.1194V66.8565C117.119 67.2344 116.812 67.5408 116.435 67.5408H60.3249C59.947 67.5408 59.6406 67.2344 59.6406 66.8565V64.1194Z" fill="#DCDDE1"/><g clip-path="url(#clip0_1652_59614)"><rect width="142.724" height="69.37" transform="translate(59.6406 74.1787)" fill="#FFDF99"/><rect x="56" y="164.476" width="91.8067" height="97.0519" transform="rotate(-47.3051 56 164.476)" fill="#FFD066"/></g><path d="M60.625 150.111C60.625 148.842 61.5531 148.348 62.6979 148.348H64.4747C65.6195 148.348 66.5476 149.208 66.5476 150.268C66.5476 150.54 66.4863 150.799 66.3758 151.034C65.7198 152.427 63.763 152.563 62.4018 153.284L62.4018 151.913C62.4018 151.913 60.625 151.171 60.625 150.111Z" stroke="#434960" stroke-width="0.580816" stroke-linejoin="round"/><g clip-path="url(#clip1_1652_59614)"><path d="M76.0156 152.023L77.2221 153.229L78.4286 152.023" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M74.4062 148.403H75.6128C76.0394 148.403 76.4486 148.573 76.7503 148.875C77.052 149.176 77.2214 149.585 77.2214 150.012V153.229" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M73.6005 149.61L72.394 148.403L71.1875 149.61" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M75.2058 153.229H73.9993C73.5727 153.229 73.1635 153.06 72.8618 152.758C72.5601 152.457 72.3906 152.047 72.3906 151.621V148.403" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip2_1652_59614)"><path d="M84.6834 148.513C83.7839 148.513 83.0547 149.221 83.0547 150.094C83.0547 151.676 84.9795 153.114 86.016 153.448C87.0524 153.114 88.9772 151.676 88.9772 150.094C88.9772 149.221 88.248 148.513 87.3485 148.513C86.7977 148.513 86.3106 148.778 86.016 149.185C85.8658 148.977 85.6663 148.807 85.4343 148.69C85.2023 148.573 84.9448 148.513 84.6834 148.513Z" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/></g></g><defs><filter id="filter0_dd_1652_59614" x="51.4709" y="30.6942" width="159.058" height="130.141" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.22326"/><feGaussianBlur stdDeviation="0.76454"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59614"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.305816"/><feGaussianBlur stdDeviation="0.305816"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59614" result="effect2_dropShadow_1652_59614"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59614" result="shape"/></filter><clipPath id="clip0_1652_59614"><rect width="142.724" height="69.37" fill="white" transform="translate(59.6406 74.1787)"/></clipPath><clipPath id="clip1_1652_59614"><rect width="7.89675" height="7.89675" fill="white" transform="translate(70.8594 146.868)"/></clipPath><clipPath id="clip2_1652_59614"><rect width="7.89675" height="7.89675" fill="white" transform="translate(82.0703 146.868)"/></clipPath></defs></svg>',
			'widgetTemplate' 			=> '<svg width="262" height="200" viewBox="0 0 262 200" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1652_59648)"><rect width="262" height="200" fill="#F3F4F5"/><g filter="url(#filter0_dd_1652_59648)"><rect x="78" y="62" width="105.687" height="63.5346" rx="1.22326" fill="white"/><rect x="84.6406" y="68.6379" width="13.0345" height="13.0345" rx="2" fill="#8C8F9A"/><rect x="103.047" y="71.8966" width="39.1034" height="6.51724" rx="1.34365" fill="#D0D1D7"/><rect x="84.6406" y="86.5603" width="90.7315" height="6.51724" rx="0.671826" fill="#DCDDE1"/><path d="M84.6406 98.6374C84.6406 98.2664 84.9414 97.9656 85.3125 97.9656H140.402C140.773 97.9656 141.074 98.2664 141.074 98.6374V103.811C141.074 104.182 140.773 104.483 140.402 104.483H85.3125C84.9414 104.483 84.6406 104.182 84.6406 103.811V98.6374Z" fill="#DCDDE1"/><path d="M85.625 117.562C85.625 116.293 86.5531 115.8 87.6979 115.8H89.4747C90.6195 115.8 91.5476 116.659 91.5476 117.719C91.5476 117.991 91.4863 118.25 91.3758 118.485C90.7198 119.879 88.763 120.015 87.4018 120.735L87.4018 119.364C87.4018 119.364 85.625 118.622 85.625 117.562Z" stroke="#434960" stroke-width="0.580816" stroke-linejoin="round"/><g clip-path="url(#clip1_1652_59648)"><path d="M101.016 119.474L102.222 120.68L103.429 119.474" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M99.4062 115.855H100.613C101.039 115.855 101.449 116.024 101.75 116.326C102.052 116.628 102.221 117.037 102.221 117.463V120.681" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M98.6005 117.061L97.394 115.855L96.1875 117.061" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/><path d="M100.206 120.681H98.9993C98.5727 120.681 98.1635 120.511 97.8618 120.21C97.5601 119.908 97.3906 119.499 97.3906 119.072V115.855" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/></g><g clip-path="url(#clip2_1652_59648)"><path d="M109.683 115.964C108.784 115.964 108.055 116.672 108.055 117.546C108.055 119.127 109.98 120.565 111.016 120.899C112.052 120.565 113.977 119.127 113.977 117.546C113.977 116.672 113.248 115.964 112.349 115.964C111.798 115.964 111.311 116.23 111.016 116.636C110.866 116.428 110.666 116.259 110.434 116.142C110.202 116.025 109.945 115.964 109.683 115.964Z" stroke="#434960" stroke-width="0.580816" stroke-linecap="round" stroke-linejoin="round"/></g></g><g filter="url(#filter1_dd_1652_59648)"><rect x="78" y="131.535" width="105.687" height="142.909" rx="1.22326" fill="white"/><rect x="84.6406" y="138.173" width="13.0345" height="13.0345" rx="2" fill="#8C8F9A"/><rect x="103.047" y="141.431" width="39.1034" height="6.51724" rx="1.34365" fill="#D0D1D7"/><rect x="84.6406" y="156.095" width="90.7315" height="6.51724" rx="0.671826" fill="#DCDDE1"/><path d="M84.6406 168.172C84.6406 167.801 84.9414 167.5 85.3125 167.5H140.402C140.773 167.5 141.074 167.801 141.074 168.172V173.346C141.074 173.717 140.773 174.017 140.402 174.017H85.3125C84.9414 174.017 84.6406 173.717 84.6406 173.346V168.172Z" fill="#DCDDE1"/><g clip-path="url(#clip3_1652_59648)"><rect x="84.6406" y="180.535" width="92.4113" height="79.3746" rx="2" fill="#8C8F9A"/><circle opacity="0.5" cx="85.324" cy="259.225" r="63.6365" fill="#D0D1D7"/></g></g><rect x="78" y="29" width="18" height="18" rx="9" fill="#8C8F9A"/><rect x="104" y="31" width="19" height="6" rx="1" fill="#8C8F9A"/><circle cx="129" cy="34" r="3" fill="#0096CC"/><path d="M127.398 34L128.423 35.0246L130.544 32.9033" stroke="white" stroke-width="0.8"/><rect x="135" y="29" width="26" height="10" rx="1" fill="#0096CC"/><path d="M139.554 36V34.458H141.06V33.474H139.554V32.67H141.354V31.692H138.42V36H139.554ZM145.042 34.386C145.042 33.462 144.31 32.712 143.356 32.712C142.402 32.712 141.67 33.462 141.67 34.386C141.67 35.31 142.402 36.06 143.356 36.06C144.31 36.06 145.042 35.31 145.042 34.386ZM142.738 34.386C142.738 33.882 143.038 33.636 143.356 33.636C143.674 33.636 143.974 33.882 143.974 34.386C143.974 34.89 143.674 35.142 143.356 35.142C143.038 35.142 142.738 34.89 142.738 34.386ZM146.505 36V31.692H145.467V36H146.505ZM148.204 36V31.692H147.166V36H148.204ZM152.003 34.386C152.003 33.462 151.271 32.712 150.317 32.712C149.363 32.712 148.631 33.462 148.631 34.386C148.631 35.31 149.363 36.06 150.317 36.06C151.271 36.06 152.003 35.31 152.003 34.386ZM149.699 34.386C149.699 33.882 149.999 33.636 150.317 33.636C150.635 33.636 150.935 33.882 150.935 34.386C150.935 34.89 150.635 35.142 150.317 35.142C149.999 35.142 149.699 34.89 149.699 34.386ZM155.056 36H156.076L156.988 32.772H155.98L155.53 34.542L155.08 32.772H154.054L153.58 34.542L153.13 32.772H152.128L153.034 36H154.06L154.558 34.17L155.056 36Z" fill="white"/><rect x="104" y="42" width="73" height="6" rx="1" fill="#DCDDE1"/></g><defs><filter id="filter0_dd_1652_59648" x="76.4709" y="61.6942" width="108.746" height="66.5927" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.22326"/><feGaussianBlur stdDeviation="0.76454"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59648"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.305816"/><feGaussianBlur stdDeviation="0.305816"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59648" result="effect2_dropShadow_1652_59648"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59648" result="shape"/></filter><filter id="filter1_dd_1652_59648" x="76.4709" y="131.229" width="108.746" height="145.967" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1.22326"/><feGaussianBlur stdDeviation="0.76454"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1652_59648"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="0.305816"/><feGaussianBlur stdDeviation="0.305816"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/><feBlend mode="normal" in2="effect1_dropShadow_1652_59648" result="effect2_dropShadow_1652_59648"/><feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_1652_59648" result="shape"/></filter><clipPath id="clip0_1652_59648"><rect width="262" height="200" fill="white"/></clipPath><clipPath id="clip1_1652_59648"><rect width="7.89675" height="7.89675" fill="white" transform="translate(95.8594 114.319)"/></clipPath><clipPath id="clip2_1652_59648"><rect width="7.89675" height="7.89675" fill="white" transform="translate(107.07 114.319)"/></clipPath><clipPath id="clip3_1652_59648"><rect x="84.6406" y="180.535" width="92.4113" height="79.3746" rx="2" fill="white"/></clipPath></defs></svg>',
		];
		return $builder_svg_icons;
	}

	/**
	 * Plugins information for plugin install modal in all feeds page on select source flow
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	public function install_plugins_popup() {
		// get the WordPress's core list of installed plugins
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$installed_plugins = get_plugins();

		$is_facebook_installed = false;
        $facebook_plugin = 'custom-facebook-feed/custom-facebook-feed.php';
        if ( isset( $installed_plugins['custom-facebook-feed-pro/custom-facebook-feed.php'] ) ) {
            $is_facebook_installed = true;
            $facebook_plugin = 'custom-facebook-feed-pro/custom-facebook-feed.php';
        } else if ( isset( $installed_plugins['custom-facebook-feed/custom-facebook-feed.php'] ) ) {
            $is_facebook_installed = true;
        }

        $is_twitter_installed = false;
        $twitter_plugin = 'custom-twitter-feeds/custom-twitter-feed.php';
        if ( isset( $installed_plugins['custom-twitter-feeds-pro/custom-twitter-feed.php'] ) ) {
            $is_twitter_installed = true;
            $twitter_plugin = 'custom-twitter-feeds-pro/custom-twitter-feed.php';
        } else if ( isset( $installed_plugins['custom-twitter-feeds/custom-twitter-feed.php'] ) ) {
            $is_twitter_installed = true;
        }

        $is_youtube_installed = false;
        $youtube_plugin = 'feeds-for-youtube/youtube-feed.php';
        if ( isset( $installed_plugins['youtube-feed-pro/youtube-feed.php'] ) ) {
            $is_youtube_installed = true;
            $youtube_plugin = 'youtube-feed-pro/youtube-feed.php';
        } else if ( isset( $installed_plugins['feeds-for-youtube/youtube-feed.php'] ) ) {
            $is_youtube_installed = true;
        }

		return array(
			'facebook' => array(
				'displayName' => __( 'Facebook', 'custom-twitter-feeds' ),
				'name' => __( 'Facebook Feed', 'custom-twitter-feeds' ),
				'author' => __( 'By Smash Balloon', 'custom-twitter-feeds' ),
				'description' => __('To display a Facebook feed, our Facebook plugin is required. </br> It provides a clean and beautiful way to add your Facebook posts to your website. Grab your visitors attention and keep them engaged with your site longer.', 'custom-twitter-feeds'),
				'dashboard_permalink' => admin_url( 'admin.php?page=cff-feed-builder' ),
				'svgIcon' => '<svg viewBox="0 0 14 15"  width="36" height="36"><path d="M7.00016 0.860001C3.3335 0.860001 0.333496 3.85333 0.333496 7.54C0.333496 10.8733 2.7735 13.64 5.96016 14.14V9.47333H4.26683V7.54H5.96016V6.06667C5.96016 4.39333 6.9535 3.47333 8.48016 3.47333C9.20683 3.47333 9.96683 3.6 9.96683 3.6V5.24667H9.12683C8.30016 5.24667 8.04016 5.76 8.04016 6.28667V7.54H9.8935L9.5935 9.47333H8.04016V14.14C9.61112 13.8919 11.0416 13.0903 12.0734 11.88C13.1053 10.6697 13.6704 9.13043 13.6668 7.54C13.6668 3.85333 10.6668 0.860001 7.00016 0.860001Z" fill="rgb(0, 107, 250)"/></svg>',
				'installed' => $is_facebook_installed,
				'activated' => is_plugin_active( $facebook_plugin ),
				'plugin' => $facebook_plugin,
				'download_plugin' => 'https://downloads.wordpress.org/plugin/custom-facebook-feed.zip',
			),
			'twitter' => array(
				'displayName' => __( 'Twitter', 'custom-twitter-feeds' ),
				'name' => __( 'Twitter Feed', 'custom-twitter-feeds' ),
				'author' => __( 'By Smash Balloon', 'custom-twitter-feeds' ),
				'description' => __('Custom Twitter Feeds is a highly customizable way to display tweets from your Twitter account. Promote your latest content and update your site content automatically.', 'custom-twitter-feeds'),
                'dashboard_permalink' => admin_url( 'admin.php?page=custom-twitter-feeds' ),
				'svgIcon' => '<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M33.6905 9C32.5355 9.525 31.2905 9.87 30.0005 10.035C31.3205 9.24 32.3405 7.98 32.8205 6.465C31.5755 7.215 30.1955 7.74 28.7405 8.04C27.5555 6.75 25.8905 6 26.0005 6C20.4755 6 17.5955 8.88 17.5955 12.435C17.5955 12.945 17.6555 13.44 17.7605 13.905C12.4205 13.635 7.66555 11.07 4.50055 7.185C3.94555 8.13 3.63055 9.24 3.63055 10.41C3.63055 12.645 4.75555 14.625 6.49555 15.75C5.43055 15.75 4.44055 15.45 3.57055 15V15.045C3.57055 18.165 5.79055 20.775 8.73055 21.36C7.78664 21.6183 6.79569 21.6543 5.83555 21.465C6.24296 22.7437 7.04085 23.8626 8.11707 24.6644C9.19329 25.4662 10.4937 25.9105 11.8355 25.935C9.56099 27.7357 6.74154 28.709 3.84055 28.695C3.33055 28.695 2.82055 28.665 2.31055 28.605C5.16055 30.435 8.55055 31.5 12.1805 31.5C26.0005 31.5 30.4955 21.69 30.4955 13.185C30.4955 12.9 30.4955 12.63 30.4805 12.345C31.7405 11.445 32.8205 10.305 33.6905 9Z" fill="#1B90EF"/></svg>',
				'installed' => $is_twitter_installed,
				'activated' => is_plugin_active( $twitter_plugin ),
				'plugin' => $twitter_plugin,
				'download_plugin' => 'https://downloads.wordpress.org/plugin/custom-twitter-feeds.zip',
			),
			'youtube' => array(
				'displayName' => __( 'YouTube', 'custom-twitter-feeds' ),
				'name' => __( 'Feeds for YouTube', 'custom-twitter-feeds' ),
				'author' => __( 'By Smash Balloon', 'custom-twitter-feeds' ),
				'description' => __( 'To display a YouTube feed, our YouTube plugin is required. It provides a simple yet powerful way to display videos from YouTube on your website, Increasing engagement with your channel while keeping visitors on your website.', 'custom-twitter-feeds' ),
				'dashboard_permalink' => admin_url( 'admin.php?page=youtube-feed' ),
				'svgIcon' => '<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 22.5L22.785 18L15 13.5V22.5ZM32.34 10.755C32.535 11.46 32.67 12.405 32.76 13.605C32.865 14.805 32.91 15.84 32.91 16.74L33 18C33 21.285 32.76 23.7 32.34 25.245C31.965 26.595 31.095 27.465 29.745 27.84C29.04 28.035 27.75 28.17 25.77 28.26C23.82 28.365 22.035 28.41 20.385 28.41L18 28.5C11.715 28.5 7.8 28.26 6.255 27.84C4.905 27.465 6.035 26.595 3.66 25.245C3.465 24.54 3.33 23.595 3.24 22.395C3.135 21.195 3.09 20.16 3.09 19.26L3 18C3 14.715 3.24 12.3 3.66 10.755C6.035 9.405 4.905 8.535 6.255 8.16C6.96 7.965 8.25 7.83 10.23 7.74C12.18 7.635 13.965 7.59 15.615 7.59L18 7.5C24.285 7.5 28.2 7.74 29.745 8.16C31.095 8.535 31.965 9.405 32.34 10.755Z" fill="#EB2121"/></svg>',
				'installed' => $is_youtube_installed,
				'activated' => is_plugin_active( $youtube_plugin ),
				'plugin' => $youtube_plugin,
				'download_plugin' => 'https://downloads.wordpress.org/plugin/feeds-for-youtube.zip',
			),
		);
	}

	/**
	 * Gets a list of info
	 * Used in multiple places in the feed creator
	 * Other Platforms + Social Links
	 * Upgrade links
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_smashballoon_info() {
		$smash_info = [
			'colorSchemes' => [
				'facebook' => '#006BFA',
				'twitter' => '#1B90EF',
				'instagram' => '#BA03A7',
				'youtube' => '#EB2121',
				'linkedin' => '#007bb6',
				'mail' => '#666',
				'smash' => '#EB2121'
			],
			'upgrade' => [
					'name' => __( 'Upgrade to Pro', 'custom-twitter-feeds' ),
					'icon' => 'twitter',
					'link' => 'https://smashballoon.com/custom-twitter-feeds/'
			],
			'platforms' => [
				[
					'name' => __( 'Facebook Feed', 'custom-twitter-feeds' ),
					'icon' => 'facebook',
					'link' => 'https://smashballoon.com/custom-facebook-feed/?utm_campaign=twitter-pro&utm_source=balloon&utm_medium=facebook'
				],
				[
					'name' => __( 'Instagram Feed', 'custom-twitter-feeds' ),
					'icon' => 'instagram',
					'link' => 'https://smashballoon.com/instagram-feed/?utm_campaign=twitter-pro&utm_source=balloon&utm_medium=instagram'
				],
				[
					'name' => __( 'YouTube Feed', 'custom-twitter-feeds' ),
					'icon' => 'youtube',
					'link' => 'https://smashballoon.com/youtube-feed/?utm_campaign=twitter-pro&utm_source=balloon&utm_medium=youtube'
				],
				[
					'name' => __( 'Social Wall Plugin', 'custom-twitter-feeds' ),
					'icon' => 'smash',
					'link' => 'https://smashballoon.com/social-wall/?utm_campaign=twitter-pro&utm_source=balloon&utm_medium=social-wall ',
				]
			],
			'socialProfiles' => [
				'facebook' => 'https://www.facebook.com/SmashBalloon/',
				'instagram' => 'https://www.instagram.com/SmashBalloon/',
				'youtube' => 'https://www.youtube.com/smashballoon',
				'twitter' => 'https://twitter.com/smashballoon',
			],
			'morePlatforms' => ['instagram','youtube','twitter']
		];

		return $smash_info;
	}

	/**
	 * Text specific to onboarding. Will return an associative array 'active' => false
	 * if onboarding has been dismissed for the user or there aren't any legacy feeds.
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_onboarding_text() {
		// TODO: return if no legacy feeds
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );

		if ( ! isset( $ctf_statuses_option['legacy_onboarding'] ) ) {
			return array( 'active' => false );
		}

		if ( $ctf_statuses_option['legacy_onboarding']['active'] === false
		     || self::onboarding_status() === 'dismissed' ) {
			return array( 'active' => false );
		}

		$type = $ctf_statuses_option['legacy_onboarding']['type'];

		$text = array(
			'active' => true,
			'type' => $type,
			'legacyFeeds' => array(
				'heading' => __( 'Legacy Feed Settings', 'custom-twitter-feeds' ),
				'description' => sprintf( __( 'These settings will impact %s legacy feeds on your site. You can learn more about what legacy feeds are and how they differ from new feeds %shere%s.', 'custom-twitter-feeds' ), '<span class="cff-fb-count-placeholder"></span>', '<a href="https://smashballoon.com/doc/facebook-legacy-feeds/" target="_blank" rel="nofollow noopener">', '</a>' ),
			),
			'getStarted' => __( 'You can now create and customize feeds individually. Click "Add New" to get started.', 'custom-twitter-feeds' ),
		);

		if ($type === 'single') {
			$text['tooltips'] = array(
				array(
					'step' => 1,
					'heading' => __( 'How you create a feed has changed', 'custom-twitter-feeds' ),
					'p' => __( 'You can now create and customize feeds individually without using shortcode options.', 'custom-twitter-feeds' ) . ' ' . __( 'Click "Add New" to get started.', 'custom-twitter-feeds' ),
					'pointer' => 'top'
				),
				array(
					'step' => 2,
					'heading' => __( 'Your existing feed is here', 'custom-twitter-feeds' ),
					'p' => __( 'You can edit your existing feed from here, and all changes will only apply to this feed.', 'custom-twitter-feeds' ),
					'pointer' => 'top'
				)
			);
		} else {
			$text['tooltips'] = array(
				array(
					'step' => 1,
					'heading' => __( 'How you create a feed has changed', 'custom-twitter-feeds' ),
					'p' => __( 'You can now create and customize feeds individually without using shortcode options.', 'custom-twitter-feeds' ) . ' ' . __( 'Click "Add New" to get started.', 'custom-twitter-feeds' ),
					'pointer' => 'top'
				),
				array(
					'step' => 2,
					'heading' => __( 'Your existing feeds are under "Legacy" feeds', 'custom-twitter-feeds' ),
					'p' => __( 'You can edit the settings for any existing "legacy" feed (i.e. any feed created prior to this update) here.', 'custom-twitter-feeds' ) . ' ' . __( 'This works just like the old settings page and affects all legacy feeds on your site.', 'custom-twitter-feeds' )
				),
				array(
					'step' => 3,
					'heading' => __( 'Existing feeds work as normal', 'custom-twitter-feeds' ),
					'p' => __( 'You don\'t need to update or change any of your existing feeds. They will continue to work as usual.', 'custom-twitter-feeds' ) . ' ' . __( 'This update only affects how new feeds are created and customized.', 'custom-twitter-feeds' )
				)
			);
		}

		return $text;
	}

	public function get_customizer_onboarding_text() {

		if ( self::onboarding_status( 'customizer' ) === 'dismissed' ) {
			return array( 'active' => false );
		}

		$text = array(
			'active' => true,
			'type' => 'customizer',
			'tooltips' => array(
				array(
					'step' => 1,
					'heading' => __( 'Embedding a Feed', 'custom-twitter-feeds' ),
					'p' => __( 'After you are done customizing the feed, click here to add it to a page or a widget.', 'custom-twitter-feeds' ),
					'pointer' => 'top'
				),
				array(
					'step' => 2,
					'heading' => __( 'Customize', 'custom-twitter-feeds' ),
					'p' => __( 'Change your feed layout, color scheme, or customize individual feed sections here.', 'custom-twitter-feeds' ),
					'pointer' => 'top'
				),
				array(
					'step' => 3,
					'heading' => __( 'Settings', 'custom-twitter-feeds' ),
					'p' => __( 'Update your feed source, filter your posts, or change advanced settings here.', 'custom-twitter-feeds' ),
					'pointer' => 'top'
				)
			)
		);

		return $text;
	}

	/**
	 * Text related to the feed customizer
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_customize_screens_text() {
		$text =  [
			'common' => [
				'preview' => __( 'Preview', 'custom-twitter-feeds' ),
				'help' => __( 'Help', 'custom-twitter-feeds' ),
				'embed' => __( 'Embed', 'custom-twitter-feeds' ),
				'save' => __( 'Save', 'custom-twitter-feeds' ),
				'sections' => __( 'Sections', 'custom-twitter-feeds' ),
				'enable' => __( 'Enable', 'custom-twitter-feeds' ),
				'background' => __( 'Background', 'custom-twitter-feeds' ),
				'text' => __( 'Text', 'custom-twitter-feeds' ),
				'inherit' => __( 'Inherit from Theme', 'custom-twitter-feeds' ),
				'size' => __( 'Size', 'custom-twitter-feeds' ),
				'color' => __( 'Color', 'custom-twitter-feeds' ),
				'height' => __( 'Height', 'custom-twitter-feeds' ),
				'placeholder' => __( 'Placeholder', 'custom-twitter-feeds' ),
				'select' => __( 'Select', 'custom-twitter-feeds' ),
				'enterText' => __( 'Enter Text', 'custom-twitter-feeds' ),
				'hoverState' => __( 'Hover State', 'custom-twitter-feeds' ),
				'sourceCombine'	=>  __( 'Combine sources from multiple platforms using our Social Wall plugin', 'custom-twitter-feeds' ),
			],

			'tabs' => [
				'customize' => __( 'Customize', 'custom-twitter-feeds' ),
				'settings' => __( 'Settings', 'custom-twitter-feeds' ),
			],
			'overview' => [
				'feedLayout' => __( 'Feed Layout', 'custom-twitter-feeds' ),
				'colorScheme' => __( 'Color Scheme', 'custom-twitter-feeds' ),
				'header' => __( 'Header', 'custom-twitter-feeds' ),
				'posts' => __( 'Posts', 'custom-twitter-feeds' ),
				'likeBox' => __( 'Like Box', 'custom-twitter-feeds' ),
				'loadMore' => __( 'Load More Button', 'custom-twitter-feeds' ),
			],
			'feedLayoutScreen' => [
				'layout' => __( 'Layout', 'custom-twitter-feeds' ),
				'list' => __( 'List', 'custom-twitter-feeds' ),
				'grid' => __( 'Grid', 'custom-twitter-feeds' ),
				'masonry' => __( 'Masonry', 'custom-twitter-feeds' ),
				'carousel' => __( 'Carousel', 'custom-twitter-feeds' ),
				'feedHeight' => __( 'Feed Height', 'custom-twitter-feeds' ),
				'number' => __( 'Number of Posts', 'custom-twitter-feeds' ),
				'columns' => __( 'Columns', 'custom-twitter-feeds' ),
				'desktop' => __( 'Desktop', 'custom-twitter-feeds' ),
				'tablet' => __( 'Tablet', 'custom-twitter-feeds' ),
				'mobile' => __( 'Mobile', 'custom-twitter-feeds' ),
				'bottomArea' => [
					'heading' => __( 'Tweak Post Styles', 'custom-twitter-feeds' ),
					'description' => __( 'Change post background, border radius, shadow etc.', 'custom-twitter-feeds' ),
				]
			],
			'colorSchemeScreen' => [
				'scheme' => __( 'Scheme', 'custom-twitter-feeds' ),
				'light' => __( 'Light', 'custom-twitter-feeds' ),
				'dark' => __( 'Dark', 'custom-twitter-feeds' ),
				'custom' => __( 'Custom', 'custom-twitter-feeds' ),
				'customPalette' => __( 'Custom Palette', 'custom-twitter-feeds' ),
				'background2' => __( 'Background 2', 'custom-twitter-feeds' ),
				'text2' => __( 'Text 2', 'custom-twitter-feeds' ),
				'link' => __( 'Link', 'custom-twitter-feeds' ),
				'bottomArea' => [
					'heading' => __( 'Overrides', 'custom-twitter-feeds' ),
					'description' => __( 'Colors that have been overridden from individual post element settings will not change. To change them, you will have to reset overrides.', 'custom-twitter-feeds' ),
					'ctaButton' => __( 'Reset Overrides.', 'custom-twitter-feeds' ),
				]
			],
			'headerScreen' => [
				'headerType' => __( 'Header Type', 'custom-twitter-feeds' ),
				'visual' => __( 'Visual', 'custom-twitter-feeds' ),
				'coverPhoto' => __( 'Cover Photo', 'custom-twitter-feeds' ),
				'nameAndAvatar' => __( 'Name and avatar', 'custom-twitter-feeds' ),
				'about' => __( 'About (bio and Likes)', 'custom-twitter-feeds' ),
				'displayOutside' => __( 'Display outside scrollable area', 'custom-twitter-feeds' ),
				'icon' => __( 'Icon', 'custom-twitter-feeds' ),
				'iconImage' => __( 'Icon Image', 'custom-twitter-feeds' ),
				'iconColor' => __( 'Icon Color', 'custom-twitter-feeds' ),
			],
			// all Lightbox in common
			// all Load More in common
			'likeBoxScreen' => [
				'small' => __( 'Small', 'custom-twitter-feeds' ),
				'large' => __( 'Large', 'custom-twitter-feeds' ),
				'coverPhoto' => __( 'Cover Photo', 'custom-twitter-feeds' ),
				'customWidth' => __( 'Custom Width', 'custom-twitter-feeds' ),
				'defaultSetTo' => __( 'By default, it is set to auto', 'custom-twitter-feeds' ),
				'width' => __( 'Width', 'custom-twitter-feeds' ),
				'customCTA' => __( 'Custom CTA', 'custom-twitter-feeds' ),
				'customCTADescription' => __( 'This toggles the custom CTA like "Show now" and "Contact"', 'custom-twitter-feeds' ),
				'showFans' => __( 'Show Fans', 'custom-twitter-feeds' ),
				'showFansDescription' => __( 'Show visitors which of their friends follow your page', 'custom-twitter-feeds' ),
				'displayOutside' => __( 'Display outside scrollable area', 'custom-twitter-feeds' ),
				'displayOutsideDescription' => __( 'Make the like box fixed by moving it outside the scrollable area', 'custom-twitter-feeds' ),
			],
			'postsScreen' => [
				'thumbnail' => __( 'Thumbnail', 'custom-twitter-feeds' ),
				'half' => __( 'Half width', 'custom-twitter-feeds' ),
				'full' => __( 'Full width', 'custom-twitter-feeds' ),
				'useFull' => __( 'Use full width layout when post width is less than 500px', 'custom-twitter-feeds' ),
				'postStyle' => __( 'Post Style', 'custom-twitter-feeds' ),
				'editIndividual' => __( 'Edit Individual Elements', 'custom-twitter-feeds' ),
				'individual' => [
					'description' => __( 'Hide or show individual elements of a post or edit their options', 'custom-twitter-feeds' ),
					'name' => __( 'Name', 'custom-twitter-feeds' ),
					'edit' => __( 'Edit', 'custom-twitter-feeds' ),
					'postAuthor' => __( 'Author', 'custom-twitter-feeds' ),
					'postText' => __( 'Post Text', 'custom-twitter-feeds' ),
					'date' => __( 'Date', 'custom-twitter-feeds' ),
					'photosVideos' => __( 'Photos/Videos', 'custom-twitter-feeds' ),
					'likesShares' => __( 'Likes, Shares and Comments', 'custom-twitter-feeds' ),
					'eventTitle' => __( 'Event Title', 'custom-twitter-feeds' ),
					'eventDetails' => __( 'Event Details', 'custom-twitter-feeds' ),
					'postAction' => __( 'Post Action Links', 'custom-twitter-feeds' ),
					'sharedPostText' => __( 'Shared Post Text', 'custom-twitter-feeds' ),
					'sharedLinkBox' => __( 'Shared Link Box', 'custom-twitter-feeds' ),
					'postTextDescription' => __( 'The main text of the Twitter post', 'custom-twitter-feeds' ),
					'maxTextLength' => __( 'Maximum Text Length', 'custom-twitter-feeds' ),
					'characters' => __( 'Characters', 'custom-twitter-feeds' ),
					'linkText' => __( 'Link text to Twitter post', 'custom-twitter-feeds' ),
					'postDateDescription' => __( 'The date of the post', 'custom-twitter-feeds' ),
					'format' => __( 'Format', 'custom-twitter-feeds' ),
					'custom' => __( 'Custom', 'custom-twitter-feeds' ),
					'learnMoreFormats' => '<a href="https://smashballoon.com/doc/date-formatting-reference/" target="_blank" rel="nofollow noopener">' . __( 'Learn more about custom formats', 'custom-twitter-feeds' ) . '</a>',
					'addTextBefore' => __( 'Add text before date', 'custom-twitter-feeds' ),
					'addTextBeforeEG' => __( 'E.g. Posted', 'custom-twitter-feeds' ),
					'addTextAfter' => __( 'Add text after date', 'custom-twitter-feeds' ),
					'addTextAfterEG' => __( 'E.g. - posted date', 'custom-twitter-feeds' ),
					'timezone' => __( 'Timezone', 'custom-twitter-feeds' ),
					'tzDescription' => __( 'Timezone settings are global across all feeds. To update it use the global settings.', 'custom-twitter-feeds' ),
					'tzCTAText' => __( 'Go to Global Settings', 'custom-twitter-feeds' ),
					'photosVideosDescription' => __( 'Any photos or videos in your posts', 'custom-twitter-feeds' ),
					'useOnlyOne' => __( 'Use only one image per post', 'custom-twitter-feeds' ),
					'postActionLinksDescription' => __( 'The "View on Twitter" and "Share" links at the bottom of each post', 'custom-twitter-feeds' ),
					'viewOnFBLink' => __( 'View on Twitter link', 'custom-twitter-feeds' ),
					'viewOnFBLinkDescription' => __( 'Toggle "View on Twitter" link below each post', 'custom-twitter-feeds' ),
					'customizeText' => __( 'Customize Text', 'custom-twitter-feeds' ),
					'shareLink' => __( 'Share Link', 'custom-twitter-feeds' ),
					'shareLinkDescription' => __( 'Toggle "Share" link below each post', 'custom-twitter-feeds' ),
					'likesSharesDescription' => __( 'The comments box displayed at the bottom of each timeline post', 'custom-twitter-feeds' ),
					'iconTheme' => __( 'Icon Theme', 'custom-twitter-feeds' ),
					'auto' => __( 'Auto', 'custom-twitter-feeds' ),
					'light' => __( 'Light', 'custom-twitter-feeds' ),
					'dark' => __( 'Dark', 'custom-twitter-feeds' ),
					'expandComments' => __( 'Expand comments box by default', 'custom-twitter-feeds' ),
					'hideComment' => __( 'Hide comment avatars', 'custom-twitter-feeds' ),
					'showLightbox' => __( 'Show comments in lightbox', 'custom-twitter-feeds' ),
					'eventTitleDescription' => __( 'The title of an event', 'custom-twitter-feeds' ),
					'eventDetailsDescription' => __( 'The information associated with an event', 'custom-twitter-feeds' ),
					'textSize' => __( 'Text Size', 'custom-twitter-feeds' ),
					'textColor' => __( 'Text Color', 'custom-twitter-feeds' ),
					'sharedLinkBoxDescription' => __( "The link info box that's created when a link is shared in a Twitter post", 'custom-twitter-feeds' ),
					'boxStyle' => __( 'Box Style', 'custom-twitter-feeds' ),
					'removeBackground' => __( 'Remove background/border', 'custom-twitter-feeds' ),
					'linkTitle' => __( 'Link Title', 'custom-twitter-feeds' ),
					'linkURL' => __( 'Link URL', 'custom-twitter-feeds' ),
					'linkDescription' => __( 'Link Description', 'custom-twitter-feeds' ),
					'chars' => __( 'chars', 'custom-twitter-feeds' ),
					'sharedPostDescription' => __( 'The description text associated with shared photos, videos, or links', 'custom-twitter-feeds' ),
				],
				'postType' => __( 'Post Type', 'custom-twitter-feeds' ),
				'boxed' => __( 'boxed', 'custom-twitter-feeds' ),
				'regular' => __( 'Regular', 'custom-twitter-feeds' ),
				'indvidualProperties' => __( 'Indvidual Properties', 'custom-twitter-feeds' ),
				'backgroundColor' => __( 'Background Color', 'custom-twitter-feeds' ),
				'borderRadius' => __( 'Border Radius', 'custom-twitter-feeds' ),
				'boxShadow' => __( 'Box Shadow', 'custom-twitter-feeds' ),
			],
			'shoppableFeedScreen' => [
				'heading1' => __( 'Make your Instagram Feed Shoppable', 'custom-twitter-feeds' ),
				'description1' => __( 'This feature links the post to the one specificed in your caption.<br/><br/>Don’t want to add links to the caption? You can add links manually to each post.<br/><br/>Enable it to get started.', 'custom-twitter-feeds' ),
				'heading2' => __( 'Tap “Add” or “Update” on an<br/>image to add/update it’s URL', 'custom-twitter-feeds' ),

			]
		];

		$text['onboarding'] = $this->get_customizer_onboarding_text();

		return $text;
	}


	/**
	 * Get Links with UTM
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_links_with_utm() {
		$license_key = null;
		if ( get_option('ctf_license_key') ) {
			$license_key = get_option('ctf_license_key');
		}
		$all_access_bundle = sprintf('https://smashballoon.com/all-access/?license_key=%s&upgrade=true&utm_campaign=twitter-pro&utm_source=all-feeds&utm_medium=footer-banner&utm_content=learn-more', $license_key);
		$all_access_bundle_popup = sprintf('https://smashballoon.com/all-access/?license_key=%s&upgrade=true&utm_campaign=twitter-pro&utm_source=balloon&utm_medium=all-access', $license_key);
		$sourceCombineCTA = sprintf('https://smashballoon.com/social-wall/?license_key=%s&upgrade=true&utm_campaign=twitter-pro&utm_source=customizer&utm_medium=sources&utm_content=social-wall', $license_key);

		return array(
			'allAccessBundle' => $all_access_bundle,
			'popup' => array(
				'allAccessBundle' => $all_access_bundle_popup,
				'fbProfile' => 'https://www.facebook.com/SmashBalloon/',
				'twitterProfile' => 'https://twitter.com/smashballoon',
			),
			'sourceCombineCTA' => $sourceCombineCTA,
			'multifeedCTA' => 'https://smashballoon.com/extensions/multifeed/?utm_campaign=twitter-pro&utm_source=customizer&utm_medium=sources&utm_content=multifeed',
			'doc' => 'https://smashballoon.com/docs/twitter/?utm_campaign=twitter-pro&utm_source=support&utm_medium=view-documentation-button&utm_content=view-documentation',
			'blog' => 'https://smashballoon.com/blog/?utm_campaign=twitter-pro&utm_source=support&utm_medium=view-blog-button&utm_content=view-blog',
			'gettingStarted' => 'https://smashballoon.com/docs/getting-started/?utm_campaign=twitter-pro&utm_source=support&utm_medium=getting-started-button&utm_content=getting-started',
		);
	}

	public static function get_social_wall_links() {
		return array(
			'<a href="'. esc_url( admin_url( 'admin.php?page=ctf-feed-builder' ) ) . '">' . __( 'All Feeds', 'custom-twitter-feeds' ) . '</a>',
			'<a href="'. esc_url( admin_url( 'admin.php?page=ctf-settings' ) ) . '">' . __( 'Settings', 'custom-twitter-feeds' ) . '</a>',
			'<a href="'. esc_url( admin_url( 'admin.php?page=ctf-about-us' ) ) . '">' . __( 'About Us', 'custom-twitter-feeds' ) . '</a>',
		);
	}

	/**
	 * Returns an associate array of all existing feeds along with their data
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_feed_list( $feeds_args = array() ) {
		$feeds_data = CTF_Db::feeds_query( $feeds_args );

		$i = 0;
		foreach ( $feeds_data as $single_feed ) {
			$args = array(
				'feed_id' => '*' . $single_feed['id'],
				'html_location' => array( 'content' ),
			);
			$count = CTF_Feed_Locator::count( $args );

			$content_locations = CTF_Feed_Locator::twitter_feed_locator_query( $args );

			// if this is the last page, add in the header footer and sidebar locations
			if ( count( $content_locations ) < CTF_Db::RESULTS_PER_PAGE ) {

				$args = array(
					'feed_id' => '*' . $single_feed['id'],
					'html_location' => array( 'header', 'footer', 'sidebar' ),
					'group_by' => 'html_location'
				);
				$other_locations = CTF_Feed_Locator::twitter_feed_locator_query( $args );

				$locations = array();

				$combined_locations = array_merge( $other_locations, $content_locations );
			} else {
				$combined_locations = $content_locations;
			}

			foreach ( $combined_locations as $location ) {
				$page_text = get_the_title( $location['post_id'] );
				if ( $location['html_location'] === 'header' ) {
					$html_location = __( 'Header', 'custom-twitter-feeds' );
				} elseif ( $location['html_location'] === 'footer' ) {
					$html_location = __( 'Footer', 'custom-twitter-feeds' );
				} elseif ( $location['html_location'] === 'sidebar' ) {
					$html_location = __( 'Sidebar', 'custom-twitter-feeds' );
				} else {
					$html_location = __( 'Content', 'custom-twitter-feeds' );
				}
				$shortcode_atts = json_decode( $location['shortcode_atts'], true );
				$shortcode_atts = is_array( $shortcode_atts ) ? $shortcode_atts : array();

				$full_shortcode_string = '[custom-twitter-feeds';
				foreach ( $shortcode_atts as $key => $value ) {
					if ( ! empty( $value ) ) {
						$full_shortcode_string .= ' ' . esc_html( $key ) . '="' . esc_html( $value ) . '"';
					}
				}
				$full_shortcode_string .= ']';

				$locations[] = [
					'link' => esc_url( get_the_permalink( $location['post_id'] ) ),
					'page_text' => $page_text,
					'html_location' => $html_location,
					'shortcode' => $full_shortcode_string
				];
			}
			$feeds_data[ $i ]['instance_count'] = $count;
			$feeds_data[ $i ]['location_summary'] = $locations;
			$settings = json_decode( $feeds_data[ $i ]['settings'], true );

			$settings['feed'] = $single_feed['id'];

			$twitter_feed_settings = new CTF_Settings_Pro( $settings, CTF_Feed_Saver::settings_defaults() );

			$feeds_data[ $i ]['settings'] = $twitter_feed_settings->get_settings();



			$i++;
		}
		return $feeds_data;
	}

	/**
	 * Returns an associate array of all existing sources along with their data
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_legacy_feed_list() {
		$ctf_statuses = get_option( 'ctf_statuses', array() );

		if ( empty( $ctf_statuses['support_legacy_shortcode'] ) ) {
			return [];
		}

		$args = array(
			'html_location' => array( 'header', 'footer', 'sidebar', 'content' ),
			'group_by' => 'shortcode_atts',
			'page' => 1
		);
		$feeds_data = CTF_Feed_Locator::legacy_twitter_feed_locator_query( $args );


		if ( empty( $feeds_data ) ) {
			$args = array(
				'html_location' => array( 'header', 'footer', 'sidebar', 'content' ),
				'group_by' => 'shortcode_atts',
				'page' => 1
			);
			$feeds_data = CTF_Feed_Locator::legacy_twitter_feed_locator_query( $args );
		}

		$feed_saver = new CTF_Feed_Saver( 'legacy' );
		$settings = $feed_saver->get_feed_settings();
		$default_type = 'usertimeline';

		if ( isset( $settings['feedtype'] ) ) {
			$default_type = $settings['feedtype'];

		} elseif ( isset( $settings['type'] ) ) {
			if ( strpos( $settings['type'], ',' ) === false ) {
				$default_type = $settings['type'];
			}
		}
		$i = 0;
		$reindex = false;
		foreach ( $feeds_data as $single_feed ) {
			$args = array(
				'shortcode_atts' => $single_feed['shortcode_atts'],
				'html_location' => array( 'content' ),
			);
			$content_locations = CTF_Feed_Locator::twitter_feed_locator_query( $args );

			$count = CTF_Feed_Locator::count( $args );
			if ( count( $content_locations ) < CTF_Db::RESULTS_PER_PAGE ) {

				$args = array(
					'feed_id' => $single_feed['feed_id'],
					'html_location' => array( 'header', 'footer', 'sidebar' ),
					'group_by' => 'html_location'
				);
				$other_locations = CTF_Feed_Locator::twitter_feed_locator_query( $args );

				$combined_locations = array_merge( $other_locations, $content_locations );
			} else {
				$combined_locations = $content_locations;
			}

			$locations = array();
			foreach ( $combined_locations as $location ) {
				$page_text = get_the_title( $location['post_id'] );
				if ( $location['html_location'] === 'header' ) {
					$html_location = __( 'Header', 'custom-twitter-feeds' );
				} elseif ( $location['html_location'] === 'footer' ) {
					$html_location = __( 'Footer', 'custom-twitter-feeds' );
				} elseif ( $location['html_location'] === 'sidebar' ) {
					$html_location = __( 'Sidebar', 'custom-twitter-feeds' );
				} else {
					$html_location = __( 'Content', 'custom-twitter-feeds' );
				}
				$shortcode_atts = json_decode( $location['shortcode_atts'], true );
				$shortcode_atts = is_array( $shortcode_atts ) ? $shortcode_atts : array();

				$full_shortcode_string = '[custom-twitter-feeds';
				foreach ( $shortcode_atts as $key => $value ) {
					if ( ! empty( $value ) ) {
						$full_shortcode_string .= ' ' . esc_html( $key ) . '="' . esc_html( $value ) . '"';
					}
				}
				$full_shortcode_string .= ']';

				$locations[] = [
					'link' => esc_url( get_the_permalink( $location['post_id'] ) ),
					'page_text' => $page_text,
					'html_location' => $html_location,
					'shortcode' => $full_shortcode_string
				];
			}
			$shortcode_atts = json_decode( $feeds_data[ $i ]['shortcode_atts'], true );
			$shortcode_atts = is_array( $shortcode_atts ) ? $shortcode_atts : array();

			$full_shortcode_string = '[custom-twitter-feeds';
			foreach ( $shortcode_atts as $key => $value ) {
				if ( ! empty( $value ) ) {
					$full_shortcode_string .= ' ' . esc_html( $key ) . '="' . esc_html( $value ) . '"';
				}
			}
			$full_shortcode_string .= ']';

			$feeds_data[ $i ]['shortcode'] = $full_shortcode_string;
			$feeds_data[ $i ]['instance_count'] = $count;
			$feeds_data[ $i ]['location_summary'] = $locations;
			$feeds_data[ $i ]['feed_name'] = $feeds_data[ $i ]['feed_id'];
			$feeds_data[ $i ]['feed_type'] = $default_type;

			if ( isset( $shortcode_atts['feedtype'] ) ) {
				$feeds_data[ $i ]['feed_type'] = $shortcode_atts['feedtype'];

			} elseif ( isset( $shortcode_atts['type'] ) ) {
				if ( strpos( $shortcode_atts['type'], ',' ) === false ) {
					$feeds_data[ $i ]['feed_type'] = $shortcode_atts['type'];
				}
			}

			if ( isset( $feeds_data[ $i ]['id'] ) ) {
				unset( $feeds_data[ $i ]['id'] );
			}

			if ( isset( $feeds_data[ $i ]['html_location'] ) ) {
				unset( $feeds_data[ $i ]['html_location'] );
			}

			if ( isset( $feeds_data[ $i ]['last_update'] ) ) {
				unset( $feeds_data[ $i ]['last_update'] );
			}

			if ( isset( $feeds_data[ $i ]['post_id'] ) ) {
				unset( $feeds_data[ $i ]['post_id'] );
			}

			if ( ! empty( $shortcode_atts['feed'] ) ) {
				$reindex = true;
				unset( $feeds_data[ $i ] );
			}

			if ( isset( $feeds_data[ $i ]['shortcode_atts'] ) ) {
				unset( $feeds_data[ $i ]['shortcode_atts'] );
			}

			$i++;
		}

		if ( $reindex ) {
			$feeds_data = array_values( $feeds_data );
		}

		// if there were no feeds found in the locator table we still want the legacy settings to be available
		// if it appears as though they had used version 3.x or under at some point.
		if ( empty( $feeds_data )
		     && ! is_array( $ctf_statuses['support_legacy_shortcode'] )
		     && ( $ctf_statuses['support_legacy_shortcode'] ) ) {

			$feeds_data = array(
				array(
					'feed_id' => __( 'Legacy Feed', 'custom-twitter-feeds' ) . ' ' . __( '(unknown location)', 'custom-twitter-feeds' ),
					'feed_name' => __( 'Legacy Feed', 'custom-twitter-feeds' ) . ' ' . __( '(unknown location)', 'custom-twitter-feeds' ),
					'shortcode' => '[custom-twitter-feeds]',
					'feed_type' => '',
					'instance_count' => false,
					'location_summary' => array()
				)
			);
		}

		return $feeds_data;
	}

	/**
	 * Status of the onboarding sequence for specific user
	 *
	 * @return string|boolean
	 *
	 * @since 2.0
	 */
	public static function onboarding_status( $type = 'newuser' ) {
		$onboarding_statuses = get_user_meta( get_current_user_id(), 'ctf_onboarding', true );
		$status = false;
		if ( ! empty( $onboarding_statuses ) ) {
			$statuses = maybe_unserialize( $onboarding_statuses );
			$status = isset( $statuses[ $type ] ) ? $statuses[ $type ] : false;
		}

		return $status;
	}

	/**
	 * Update status of onboarding sequence for specific user
	 *
	 * @return string|boolean
	 *
	 * @since 2.0
	 */
	public static function update_onboarding_meta( $value, $type = 'newuser' ) {
		$onboarding_statuses = get_user_meta( get_current_user_id(), 'ctf_onboarding', true );
		if ( ! empty( $onboarding_statuses ) ) {
			$statuses = maybe_unserialize( $onboarding_statuses );
			$statuses[ $type ] = $value;
		} else {
			$statuses = array(
				$type => $value
			);
		}

		$statuses = maybe_serialize( $statuses );

		update_user_meta( get_current_user_id(), 'ctf_onboarding', $statuses );
	}

	/**
	 * Used to dismiss onboarding using AJAX
	 *
	 * @since 2.0
	 */
	public static function after_dismiss_onboarding() {
		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );

		if ( current_user_can( $cap ) ) {
			$type = 'newuser';
			if ( isset( $_POST['was_active'] ) ) {
				$type = sanitize_text_field( $_POST['was_active'] );
			}
			CTF_Feed_Builder::update_onboarding_meta( 'dismissed', $type );
		}
		wp_die();
	}

	public static function add_customizer_att( $atts ) {
   	    if ( ! is_array( $atts ) ) {
   	    	$atts = [];
        }
   	    $atts['feedtype'] = 'customizer';
   	    return $atts;
	}

	/**
	 * Feed Builder Wrapper.
	 *
	 * @since 2.0
	 */
	public function feed_builder(){
		include_once CTF_BUILDER_DIR . 'templates/builder.php';
	}

	/**
	 * For types listed on the top of the select feed type screen
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_feed_types() {
    	$feed_types = [
		    [
			    'type' => 'usertimeline',
			    'title'=> __( 'User Timeline', 'custom-twitter-feeds' ),
			    'description'=> __( 'A timeline of Tweets from any Twitter user', 'custom-twitter-feeds' ),
			    'icon'	=>  'usertimelineIcon'
		    ],
		    [
			    'type' => 'hashtag',
			    'title' => __( 'Hashtag', 'custom-twitter-feeds' ),
			    'description'=> __( 'Public Tweets which contain a specific hashtag', 'custom-twitter-feeds' ),
			    'icon'	=>  'hashtagIcon'
		    ],
		    [
			    'type' => 'hometimeline',
			    'title' => __( 'Home Timeline', 'custom-twitter-feeds' ),
			    'description'=> __( 'The home timeline from your Twitter account', 'custom-twitter-feeds' ),
			    'icon'	=>  'homeTimelineIcon'
		    ],
		    [
			    'type' => 'search',
			    'title' => __( 'Search', 'custom-twitter-feeds' ),
			    'description'=> __( 'A feed of Tweets matching specific search terms', 'custom-twitter-feeds' ),
			    'icon'	=>  'searchIcon'
		    ],
		    [
			    'type' => 'mentionstimeline',
			    'title' => __( 'Mentions', 'custom-twitter-feeds' ),
			    'description'=> __( 'Tweets which mention your Twitter user', 'custom-twitter-feeds' ),
			    'icon'	=>  'mentionsIcon'
		    ],
		    [
			    'type' => 'lists',
			    'title' => __( 'Lists', 'custom-twitter-feeds' ),
			    'description'=> __( 'Tweets from any publicly available Twitter list', 'custom-twitter-feeds' ),
			    'icon'	=>  'listsIcon'
		    ],
		    [
			    'type' => 'socialwall',
			    'title' => __( 'Social Wall', 'custom-twitter-feeds' ),
			    'description'=> __( 'Combine sources from multiple social media platforms', 'custom-twitter-feeds' ),
			    'icon'	=>  'socialwall1Icon'
		    ]
	    ];

    	return $feed_types;
	}

	/**
	 * Connect Account Screen
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function connect_account_secreen(){
		return array(
			'heading' => __( 'Connect Twitter Account', 'custom-twitter-feeds' ),
			'description' => __( 'This is required by Twitter so we can fetch data in the public domain. It does not give us permission to manage your Twitter Account whatsoever.', 'custom-twitter-feeds' ),
			'preferManually' => __( 'Prefer to use your own Twitter Developer App?', 'custom-twitter-feeds' ),
			'addAppCred' => __( 'Add App Credentials', 'custom-twitter-feeds' ),
			'connectNewAccount' => __( 'Add New Account', 'custom-twitter-feeds' ),
			'heading_2' => __( 'Add Your Own Twitter App Credentials', 'custom-twitter-feeds' ),
			'manualModal' => [
				'name' => __( 'Name', 'custom-twitter-feeds' ),
				'namePlhdr' => __( 'Enter App Name', 'custom-twitter-feeds' ),
				'consumerKey' => __( 'Consumer Key', 'custom-twitter-feeds' ),
				'consumerKeyPlhdr' => __( 'Enter Consumer Key', 'custom-twitter-feeds' ),
				'consumerSecret' => __( 'Consumer Secret', 'custom-twitter-feeds' ),
				'consumerSecretPlhdr' => __( 'Enter Consumer Secret', 'custom-twitter-feeds' ),
				'accessToken' => __( 'Access Token', 'custom-twitter-feeds' ),
				'accessTokenPlhdr' => __( 'Enter Access Token', 'custom-twitter-feeds' ),
				'accessTokenSecret' => __( 'Access Token Secret', 'custom-twitter-feeds' ),
				'accessTokenSecretPlhdr' => __( 'Enter Access Token Secret', 'custom-twitter-feeds' ),
			]
		);
	}

	/**
	 * For types listed on the top of the select feed type screen
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_feed_templates(){
		$feed_templates = [
		    [
			    'type' => 'default',
			    'title'=> __( 'Default', 'custom-twitter-feeds' ),
			    'description'=> '',
			    'icon'	=>  'defaultTemplate'
		    ],
		    [
			    'type' => 'masonry_cards',
			    'title'=> __( 'Masonry Cards', 'custom-twitter-feeds' ),
			    'description'=> '',
			    'icon'	=>  'masonryCardsTemplate'
		    ],
		    [
			    'type' => 'simple_carousel',
			    'title'=> __( 'Simple Carousel', 'custom-twitter-feeds' ),
			    'description'=> '',
			    'icon'	=>  'simpleCarouselTemplate'
		    ],
		    [
			    'type' => 'simple_cards',
			    'title'=> __( 'Simple Cards', 'custom-twitter-feeds' ),
			    'description'=> '',
			    'icon'	=>  'simpleCardsTemplate'
		    ],
		    [
			    'type' => 'showcase_carousel',
			    'title'=> __( 'Showcase Carousel', 'custom-twitter-feeds' ),
			    'description'=> '',
			    'icon'	=>  'showcaseCarouselTemplate'
		    ],
		    [
			    'type' => 'latest_tweet',
			    'title'=> __( 'Latest Tweet', 'custom-twitter-feeds' ),
			    'description'=> '',
			    'icon'	=>  'latestTweetTemplate'
		    ],
		    [
			    'type' => 'widget',
			    'title'=> __( 'Widget', 'custom-twitter-feeds' ),
			    'description'=> '',
			    'icon'	=>  'widgetTemplate'
		    ]
		];

		return $feed_templates;
	}


	/**
	 * Get App Credentials
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_app_credentials( $ctf_options ) {
		#return [
		#	'app_name' 					=> '',
		#	'consumer_key' 				=> '',
		#	'consumer_secret' 			=> '',
		#	'access_token' 				=> '',
		#	'access_token_secret' 		=> ''
		#];
		return [
			'app_name' 					=> isset( $ctf_options['app_name'] ) && $ctf_options['app_name'] !== '' ? $ctf_options['app_name'] : '',
			'consumer_key' 				=> isset( $ctf_options['consumer_key'] ) && $ctf_options['consumer_key'] !== '' ? $ctf_options['consumer_key'] : '',
			'consumer_secret' 			=> isset( $ctf_options['consumer_secret'] ) && $ctf_options['consumer_secret'] !== '' ? $ctf_options['consumer_secret'] : '',
			'access_token' 				=> isset( $ctf_options['access_token'] ) && $ctf_options['access_token'] !== '' ? $ctf_options['access_token'] : '',
			'access_token_secret' 		=> isset( $ctf_options['access_token_secret'] ) && $ctf_options['access_token_secret'] !== '' ? $ctf_options['access_token_secret'] : ''
		];

	}

	/**
	 * Check if On
	 * Function to check if a shortcode options is set to ON or TRUE
	 *
	 * @access public
  	 * @static
	 * @since 2.0
	 * @return boolean
	 */
	static function check_if_on( $value ){
		return ( isset( $value ) && !empty( $value ) && ( $value == 'true' || $value == 'on') ) ?  true : false;
	}

	/**
	 * Get Translated text Set in the Settings Page
	 *
	 * @return array
	 *
	 * @since 4.0
	 */
	function get_translated_text(){
		$text =  [
			'secondText' => __( 'second', 'custom-twitter-feeds' ),
			'secondsText' => __( 'seconds', 'custom-twitter-feeds' ),
			'minuteText' => __( 'minute', 'custom-twitter-feeds' ),
			'minutesText' => __( 'minutes', 'custom-twitter-feeds' ),
			'hourText' => __( 'hour', 'custom-twitter-feeds' ),
			'hoursText' => __( 'hours', 'custom-twitter-feeds' ),
			'dayText' => __( 'day', 'custom-twitter-feeds' ),
			'daysText' => __( 'days', 'custom-twitter-feeds' ),
			'weekText' => __( 'week', 'custom-twitter-feeds' ),
			'weeksText' => __( 'weeks', 'custom-twitter-feeds' ),
			'monthText' => __( 'month', 'custom-twitter-feeds' ),
			'monthsText' => __( 'months', 'custom-twitter-feeds' ),
			'yearText' => __( 'year', 'custom-twitter-feeds' ),
			'yearsText' => __( 'years', 'custom-twitter-feeds' ),
			'agoText' => __( 'ago', 'custom-twitter-feeds' ),
			'ctf_minute' 	=> ! empty( $options['mtime'] ) ? $options['mtime'] : 'm',
            'ctf_hour' 		=> ! empty( $options['htime'] ) ? $options['htime'] : 'h',
            'ctf_now_str' 	=> ! empty( $options['nowtime'] ) ? $options['nowtime'] : 'now'
		];

		return $text;
	}
}


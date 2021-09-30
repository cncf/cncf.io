<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.cncf.io/
 * @since      1.0.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Lf_Mu
 * @subpackage Lf_Mu/includes
 * @author     Chris Abraham <cjyabraham@gmail.com>
 */
class Lf_Mu {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Lf_Mu_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'LF_MU_VERSION' ) ) {
			$this->version = LF_MU_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'lf-mu';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Lf_Mu_Loader. Orchestrates the hooks of the plugin.
	 * - Lf_Mu_I18n. Defines internationalization functionality.
	 * - Lf_Mu_Admin. Defines all hooks for the admin area.
	 * - Lf_Mu_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lf-mu-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lf-mu-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-lf-mu-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-lf-mu-public.php';

		$this->loader = new Lf_Mu_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Lf_Mu_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Lf_Mu_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Lf_Mu_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_cpts' );
		$this->loader->add_filter( 'pmc_create_sidebar', $plugin_admin, 'create_sidebar' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'remove_menu_items' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_taxonomies' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'change_adminbar_colors' );
		$this->loader->add_action( 'wp_head', $plugin_admin, 'change_adminbar_colors' );

		// Sync projects with landscape.
		$this->loader->add_action( 'lf_sync_projects', $plugin_admin, 'sync_projects' );
		if ( ! wp_next_scheduled( 'lf_sync_projects' ) ) {
			wp_schedule_event( time(), 'twicedaily', 'lf_sync_projects' );
		}

		// $this->loader->add_action( 'init', $plugin_admin, 'sync_projects' );

		if ( $plugin_admin->is_cncf ) {
			// Special Easter-egg hook to run full sync of Speakers CPTs.  You just have to update the "Speakers" page.
			$this->loader->add_action( 'post_updated', $plugin_admin, 'sync_speakers' );

			// Hooks to keep the lf_speaker CPT in sync with Users of role "Speaker".
			$this->loader->add_action( 'um_after_user_status_is_changed_hook', $plugin_admin, 'speaker_updated' ); // Action after user status changed.
			$this->loader->add_action( 'delete_user', $plugin_admin, 'speaker_deleted' ); // Fires immediately before a user is deleted from the database.
			$this->loader->add_action( 'profile_update', $plugin_admin, 'speaker_updated' ); // Fires immediately after an existing user is updated.
			$this->loader->add_action( 'um_after_user_account_updated', $plugin_admin, 'speaker_updated' ); // Fired on account page, after updating profile.

			// Hook to save year in a meta field for case studies.
			$this->loader->add_action( 'save_post_lf_case_study', $plugin_admin, 'set_case_study_year', 10, 3 );
			$this->loader->add_action( 'save_post_lf_case_study_cn', $plugin_admin, 'set_case_study_year', 10, 3 );

			// Sync programs with https://community.cncf.io/.
			$this->loader->add_action( 'cncf_sync_programs', $plugin_admin, 'sync_programs' );
			if ( ! wp_next_scheduled( 'cncf_sync_programs' ) ) {
				wp_schedule_event( time(), 'twicedaily', 'cncf_sync_programs' );
			}

			// Sync people with https://github.com/cncf/people.
			$this->loader->add_action( 'lf_sync_people', $plugin_admin, 'sync_people' );
			if ( ! wp_next_scheduled( 'lf_sync_people' ) ) {
				wp_schedule_event( time(), 'twicedaily', 'lf_sync_people' );
			}

			// $this->loader->add_action( 'init', $plugin_admin, 'sync_people' ); // phpcs:ignore.

			// Use this command locally if you want to dump a json feed of all current People.
			// Load browser and view source to copy the properly formatted feed.
			// $this->loader->add_action( 'init', $plugin_admin, 'dump_people' ); // phpcs:ignore.

		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Lf_Mu_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_footer', $plugin_public, 'deregister_scripts' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'insert_gtm_head' );
		$this->loader->add_action( 'wp_body_open', $plugin_public, 'insert_gtm_body' );
		$this->loader->add_filter( 'wp_resource_hints', $plugin_public, 'change_to_preconnect_resource_hints', 10, 2 );
		$this->loader->add_action( 'init', $plugin_public, 'wordpress_head_cleanup' );
		$this->loader->add_action( 'init', $plugin_public, 'disable_wp_emojicons' );
		$this->loader->add_filter( 'tiny_mce_plugins', $plugin_public, 'disable_emojicons_tinymce' );
		$this->loader->add_action( 'pre_ping', $plugin_public, 'disable_pingback' );
		$this->loader->add_action( 'wp_default_scripts', $plugin_public, 'dequeue_jquery_migrate' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wpdocs_dequeue_dashicon' );
		$this->loader->add_filter( 'pre_get_posts', $plugin_public, 'remove_news_from_rss' );
		$this->loader->add_filter( 'the_seo_framework_sitemap_nhpt_query_args', $plugin_public, 'remove_news_from_sitemap' );

		if ( $plugin_public->is_cncf ) {
			$this->loader->add_filter( 'the_seo_framework_sitemap_supported_post_types', $plugin_public, 'remove_kubeweekly_from_sitemap' );
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Lf_Mu_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

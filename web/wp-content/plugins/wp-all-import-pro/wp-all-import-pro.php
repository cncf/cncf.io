<?php
/*
Plugin Name: WP All Import Pro
Plugin URI: http://www.wpallimport.com/
Description: The most powerful solution for importing XML and CSV files to WordPress. Import to Posts, Pages, and Custom Post Types. Support for imports that run on a schedule, ability to update existing imports, and much more.
Version: 4.6.3
Author: Soflyy
*/

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( is_plugin_active('wp-all-import/plugin.php') ){

	function wp_all_import_notice(){

		?>
		<div class="error"><p>
			<?php printf(__('Please de-activate and remove the free version of WP All Import before activating the paid version.', 'wp_all_import_plugin'));
			?>
		</p></div>
		<?php

		deactivate_plugins( str_replace('\\', '/', dirname(__FILE__)) . '/wp-all-import-pro.php' );

	}

	add_action('admin_notices', 'wp_all_import_notice');

}
else {

	define('PMXI_VERSION', '4.6.3');

	define('PMXI_EDITION', 'paid');

	/**
	 * Plugin root dir with forward slashes as directory separator regardless of actuall DIRECTORY_SEPARATOR value
	 * @var string
	 */
	define('WP_ALL_IMPORT_ROOT_DIR', str_replace('\\', '/', dirname(__FILE__)));
	/**
	 * Plugin root url for referencing static content
	 * @var string
	 */
	define('WP_ALL_IMPORT_ROOT_URL', rtrim(plugin_dir_url(__FILE__), '/'));
	/**
	 * Plugin prefix for making names unique (be aware that this variable is used in conjuction with naming convention,
	 * i.e. in order to change it one must not only modify this constant but also rename all constants, classes and functions which
	 * names composed using this prefix)
	 * @var string
	 */
	define('WP_ALL_IMPORT_PREFIX', 'pmxi_');

	/**
	 * Plugin root uploads folder name
	 * @var string
	 */
	define('WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY', 'wpallimport');
	/**
	 * Plugin logs folder name
	 * @var string
	 */
	define('WP_ALL_IMPORT_LOGS_DIRECTORY', WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'logs');
	/**
	 * Plugin files folder name
	 * @var string
	 */
	define('WP_ALL_IMPORT_FILES_DIRECTORY', WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'files');
	/**
	 * Plugin uploads folder name
	 * @var string
	 */
	define('WP_ALL_IMPORT_UPLOADS_DIRECTORY', WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'uploads');
	/**
	 * Plugin history folder name
	 * @var string
	 */
	define('WP_ALL_IMPORT_HISTORY_DIRECTORY', WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'history');
	/**
	 * Plugin temp folder name
	 * @var string
	 */
	define('WP_ALL_IMPORT_TEMP_DIRECTORY', WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'temp');

	/**
	 * Main plugin file, Introduces MVC pattern
	 *
	 * @singletone
	 * @author Maksym Tsypliakov <maksym.tsypliakov@gmail.com>
	 */
	final class PMXI_Plugin {
		/**
		 * Singletone instance
		 * @var PMXI_Plugin
		 */
		protected static $instance;

		/**
		 * Plugin options
		 * @var array
		 */
		protected $options = array();

		/**
		 * Plugin root dir
		 * @var string
		 */
		const ROOT_DIR = WP_ALL_IMPORT_ROOT_DIR;
		/**
		 * Plugin root URL
		 * @var string
		 */
		const ROOT_URL = WP_ALL_IMPORT_ROOT_URL;
		/**
		 * Prefix used for names of shortcodes, action handlers, filter functions etc.
		 * @var string
		 */
		const PREFIX = WP_ALL_IMPORT_PREFIX;
		/**
		 * Plugin file path
		 * @var string
		 */
		const FILE = __FILE__;
		/**
		 * Max allowed file size (bytes) to import in default mode
		 * @var int
		 */
		const LARGE_SIZE = 0; // all files will importing in large import mode

        /**
         * @var null
         */
        public static $session = null;

        /**
         * @var bool
         */
        public static $is_csv = false;

        /**
         * @var bool
         */
        public static $csv_path = false;

        /**
         * @var bool
         */
        public static $is_php_allowed = true;

        /**
         * @var string
         */
        public static $capabilities = 'manage_options';

        /**
         * @var string
         */
        public static $cache_key = '';

		/**
		 * WP All Import logs folder
		 * @var string
		 */
		const LOGS_DIRECTORY =  WP_ALL_IMPORT_LOGS_DIRECTORY;
		/**
		 * WP All Import files folder
		 * @var string
		 */
		const FILES_DIRECTORY =  WP_ALL_IMPORT_FILES_DIRECTORY;
		/**
		 * WP All Import temp folder
		 * @var string
		 */
		const TEMP_DIRECTORY =  WP_ALL_IMPORT_TEMP_DIRECTORY;
		/**
		 * WP All Import uploads folder
		 * @var string
		 */
		const UPLOADS_DIRECTORY =  WP_ALL_IMPORT_UPLOADS_DIRECTORY;

		/**
		 * WP All Import history folder
		 * @var string
		 */
		const HISTORY_DIRECTORY =  WP_ALL_IMPORT_HISTORY_DIRECTORY;

        /**
         *  Language domain key.
         */
        const LANGUAGE_DOMAIN = 'wp_all_import_plugin';

        /**
         * @var null
         */
        private static $hasActiveSchedulingLicense = null;

		/**
		 * Return singletone instance
		 * @return PMXI_Plugin
		 */
		static public function getInstance() {
			if (self::$instance == NULL) {
				self::$instance = new self();
			}
			return self::$instance;
		}

        /**
         * @return string
         */
        static public function getEddName(){
			return 'WP All Import';
		}

        /**
         * @return string
         */
        static public function getSchedulingName(){
            return 'Automatic Scheduling';
		}

        /**
         * @return bool|null
         */
        static public function hasActiveSchedulingLicense() {

			if(is_null(self::$hasActiveSchedulingLicense)) {
				$scheduling = \Wpai\Scheduling\Scheduling::create();
				$hasActiveSchedulingLicense = $scheduling->checkLicense();
				self::$hasActiveSchedulingLicense = $hasActiveSchedulingLicense;
			}

			return self::$hasActiveSchedulingLicense;
		}

		/**
		 * Common logic for requestin plugin info fields
		 */
		public function __call($method, $args) {
			if (preg_match('%^get(.+)%i', $method, $mtch)) {
				$info = get_plugin_data(self::FILE);
				if (isset($info[$mtch[1]])) {
					return $info[$mtch[1]];
				}
			}
			throw new Exception("Requested method " . get_class($this) . "::$method doesn't exist.");
		}

		/**
		 * Get path to plagin dir relative to wordpress root
		 * @param bool[optional] $noForwardSlash Whether path should be returned withot forwarding slash
		 * @return string
		 */
		public function getRelativePath($noForwardSlash = false) {
			$wp_root = str_replace('\\', '/', ABSPATH);
			return ($noForwardSlash ? '' : '/') . str_replace($wp_root, '', self::ROOT_DIR);
		}

		/**
		 * Check whether plugin is activated as network one
		 * @return bool
		 */
		public function isNetwork() {
			if ( !is_multisite() )
			return false;

			$plugins = get_site_option('active_sitewide_plugins');
			if (isset($plugins[plugin_basename(self::FILE)]))
				return true;

			return false;
		}

		/**
		 * Check whether permalinks is enabled
		 * @return bool
		 */
		public function isPermalinks() {
			global $wp_rewrite;
			return $wp_rewrite->using_permalinks();
		}

		/**
		 * Return prefix for plugin database tables
		 * @return string
		 */
		public function getTablePrefix() {
			global $wpdb;

			//return ($this->isNetwork() ? $wpdb->base_prefix : $wpdb->prefix) . self::PREFIX;
			return $wpdb->prefix . self::PREFIX;
		}

		/**
		 * Return prefix for wordpress database tables
		 * @return string
		 */
		public function getWPPrefix() {
			global $wpdb;
			return ($this->isNetwork()) ? $wpdb->base_prefix : $wpdb->prefix;
		}

		/**
		 * Class constructor containing dispatching logic
		 * @param string $rootDir Plugin root dir
		 * @param string $pluginFilePath Plugin main file
		 */
		protected function __construct() {
		    // Load libraries only on admin dashboard or cron import.
		    if (!$this->isAdminDashboardOrCronImport()) {
		        return;
            }

			// Register autoloading method.
			spl_autoload_register(array($this, 'autoload'));

			// Register helpers.
			if (is_dir(self::ROOT_DIR . '/helpers')) foreach (PMXI_Helper::safe_glob(self::ROOT_DIR . '/helpers/*.php', PMXI_Helper::GLOB_RECURSE | PMXI_Helper::GLOB_PATH) as $filePath) {
				require_once $filePath;
			}

			$plugin_basename = plugin_basename( __FILE__ );

			self::$cache_key = md5( 'edd_plugin_' . sanitize_key( $plugin_basename ) . '_version_info' );

			// Init plugin options.
			$option_name = get_class($this) . '_Options';
			$options_default = PMXI_Config::createFromFile(self::ROOT_DIR . '/config/options.php')->toArray();
            $current_options = get_option($option_name, array());
            if (empty($current_options)) {
                $current_options = array();
            }

			$this->options = array_intersect_key($current_options, $options_default) + $options_default;
			$this->options = array_intersect_key($options_default, array_flip(array('info_api_url'))) + $this->options; // make sure hidden options apply upon plugin reactivation
			if ('' == $this->options['cron_job_key']) {
                $this->options['cron_job_key'] = wp_all_import_url_title(wp_all_import_rand_char(12));
            }

			if ($current_options !== $this->options) {
                update_option($option_name, $this->options);
            }

			register_activation_hook(self::FILE, array($this, 'activation'));

			// Register action handlers.
			if (is_dir(self::ROOT_DIR . '/actions')) foreach (PMXI_Helper::safe_glob(self::ROOT_DIR . '/actions/*.php', PMXI_Helper::GLOB_RECURSE | PMXI_Helper::GLOB_PATH) as $filePath) {
				require_once $filePath;
				$function = $actionName = basename($filePath, '.php');
				if (preg_match('%^(.+?)[_-](\d+)$%', $actionName, $m)) {
					$actionName = $m[1];
					$priority = intval($m[2]);
				} else {
					$priority = 10;
				}
				add_action($actionName, self::PREFIX . str_replace('-', '_', $function), $priority, 99); // since we don't know at this point how many parameters each plugin expects, we make sure they will be provided with all of them (it's unlikely any developer will specify more than 99 parameters in a function)
			}
			// Register filter handlers.
			if (is_dir(self::ROOT_DIR . '/filters')) foreach (PMXI_Helper::safe_glob(self::ROOT_DIR . '/filters/*.php', PMXI_Helper::GLOB_RECURSE | PMXI_Helper::GLOB_PATH) as $filePath) {
				require_once $filePath;
				$function = $actionName = basename($filePath, '.php');
				if (preg_match('%^(.+?)[_-](\d+)$%', $actionName, $m)) {
					$actionName = $m[1];
					$priority = intval($m[2]);
				} else {
					$priority = 10;
				}
				add_filter($actionName, self::PREFIX . str_replace('-', '_', $function), $priority, 99); // since we don't know at this point how many parameters each plugin expects, we make sure they will be provided with all of them (it's unlikely any developer will specify more than 99 parameters in a function)
			}
			// Register admin page pre-dispatcher.
			add_action('admin_init', array($this, 'adminInit'));
			add_action('admin_init', array($this, 'fix_options'));
			add_action('init', array($this, 'init'));
			add_action('plugins_loaded', array($this, 'setup_allimport_dir'));

            // Define WP CLI command.
            if (class_exists('WP_CLI')) {
                WP_CLI::add_command( 'all-import', 'PMXI_Cli' );
            }
		}


        /**
         * Check is current request is related to admin dashboard or cron import.
         *
         * @return bool
         */
        public function isAdminDashboardOrCronImport() {
            // Load libraries only on admin dashboard or cron import.
            if (is_admin() || isset($_GET['import_key']) || isset($_GET['action']) || isset($_GET['check_connection']) || defined('PHPUNIT_WPALLIMPORT_TESTSUITE') || $this->isCli()) {
                return TRUE;
            }
            return FALSE;
        }

        /**
         * Determines is process running from cli.
         *
         * @return bool
         */
        public function isCli() {
            return php_sapi_name() === 'cli';
        }

		/**
		 * Setup required directory.
		 */
		public function setup_allimport_dir() {
			// Create history folder.
			$uploads = wp_upload_dir();
			$wpallimportDirs = array( WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY, self::LOGS_DIRECTORY, self::FILES_DIRECTORY, self::TEMP_DIRECTORY, self::UPLOADS_DIRECTORY, self::HISTORY_DIRECTORY);
			foreach ($wpallimportDirs as $destination) {
				$dir = $uploads['basedir'] . DIRECTORY_SEPARATOR . $destination;
				if ( !is_dir($dir)) wp_mkdir_p($dir);
				if ( ! @file_exists($dir . DIRECTORY_SEPARATOR . 'index.php') ) @touch( $dir . DIRECTORY_SEPARATOR . 'index.php' );
			}
			// Create functions.php file.
			$functions = $uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'functions.php';
			$functions = apply_filters( 'import_functions_file_path', $functions );
			if (!empty($functions) && !@file_exists($functions)) {
                @touch($functions);
            }
		}

        /**
         *  Init langiage text domain.
         */
        public function init(){
			$this->load_plugin_textdomain();
            self::$is_php_allowed = apply_filters('wp_all_import_is_php_allowed', TRUE);
		}

		/**
		 * convert imports options
		 * compatibility with version 4.0
		 */
		public function fix_options(){

			global $wpdb;

			$installed_ver = get_option( "wp_all_import_db_version" );

			if ( $installed_ver == PMXI_VERSION ) return true;

			delete_transient(PMXI_Plugin::$cache_key);

			$wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name = %s", 'wp-all-import-pro_' . PMXI_Plugin::$cache_key) );
			$wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name = %s", 'wp-all-import-pro_timeout_' . PMXI_Plugin::$cache_key) );

			delete_site_transient('update_plugins');

			$imports = new PMXI_Import_List();
			$post    = new PMXI_Post_Record();

			$templates = new PMXI_Template_List();
			$template  = new PMXI_Template_Record();

			$is_migrated = get_option('pmxi_is_migrated');

			$uploads = wp_upload_dir();

			if ( empty($is_migrated) or version_compare($is_migrated, PMXI_VERSION) < 0 ){ //PMXI_VERSION

				$commit_migration = true;

				if ( empty($is_migrated) ){ // plugin version less than 4.0.0

					if ( is_dir($uploads['basedir'] . '/wpallimport_history') ) {
						wp_all_import_rmdir($uploads['basedir'] . '/wpallimport_history');
					}
					if ( is_dir($uploads['basedir'] . '/wpallimport_logs') ) {
						wp_all_import_rmdir($uploads['basedir'] . '/wpallimport_logs');
					}

					foreach ($imports->setColumns($imports->getTable() . '.*')->getBy(array('id !=' => ''))->convertRecords() as $imp){

						$imp->getById($imp->id);

						if ( ! $imp->isEmpty() and ! empty($imp->template)){

							$options = array_merge($imp->options, $imp->template);

							$this->ver_4_transition_fix($options);

							$imp->set(array(
								'options' => $options
							))->update();

							if ($imp->type == 'file'){
								$imp->set(array(
									'path' => $uploads['basedir'] . DIRECTORY_SEPARATOR . self::FILES_DIRECTORY . DIRECTORY_SEPARATOR . basename($imp->path)
								))->update();
							}
						}
					}

					foreach ($templates->setColumns($templates->getTable() . '.*')->getBy(array('id !=' => ''))->convertRecords() as $tpl){

						$tpl->getById($tpl->id);

						if ( ! $tpl->isEmpty() and ! empty($tpl->title) ) {

							$opt = ( empty($tpl->options) ) ? array() : $tpl->options;

							$options = array_merge($opt, array(
								'title' => $tpl->title,
								'content' => $tpl->content,
								'is_keep_linebreaks' => $tpl->is_keep_linebreaks,
								'is_leave_html' => $tpl->is_leave_html,
								'fix_characters' => $tpl->fix_characters
							));

							$this->ver_4_transition_fix($options);

							$tpl->set(array(
								'options' => $options
							))->update();

						}

					}

					$commit_migration = $this->fix_db_schema(); // feature to version 4.0.0

				}
				else {

					$commit_migration = $this->fix_db_schema();

					foreach ($imports->setColumns($imports->getTable() . '.*')->getBy(array('id !=' => ''))->convertRecords() as $imp){

						$imp->getById($imp->id);

						if ( ! $imp->isEmpty() ){

							$options = $imp->options;

							$this->ver_4x_transition_fix($options, $is_migrated);

							$imp->set(array(
								'options' => $options
							))->update();
						}
					}

					foreach ($templates->setColumns($templates->getTable() . '.*')->getBy(array('id !=' => ''))->convertRecords() as $tpl){

						$tpl->getById($tpl->id);

						if ( ! $tpl->isEmpty() ) {

							$options = ( empty($tpl->options) ) ? array() : $tpl->options;

							$this->ver_4x_transition_fix($options, $is_migrated);

							$tpl->set(array(
								'options' => $options
							))->update();

						}

					}
				}
				if ($commit_migration) {
                    update_option('pmxi_is_migrated', PMXI_VERSION);
                    // Generate functions hash on plugin update.
                    $functions_hash = wp_all_import_generate_functions_hash();
                    if ($functions_hash) {
                        foreach ($imports->setColumns($imports->getTable() . '.*')->getBy(array('id !=' => ''))->convertRecords() as $imp) {
                            update_option('_wp_all_import_functions_hash_' . $imp->id, $functions_hash);
                        }
                    }
                }
			}
			update_option( "wp_all_import_db_version", PMXI_VERSION );
		}

        /**
         * @param $options
         */
        public function ver_4_transition_fix(&$options ){

			$options['wizard_type'] = ($options['duplicate_matching'] == 'auto') ? 'new' : 'matching';

			if ($options['download_images']){
				$options['download_images'] = 'yes';
				$options['download_featured_image'] = $options['featured_image'];
				$options['featured_image'] = '';
				$options['download_featured_delim'] = $options['featured_delim'];
				$options['featured_delim'] = '';
			}

			if ($options['set_image_meta_data']){
				$options['set_image_meta_title'] = 1;
				$options['set_image_meta_caption'] = 1;
				$options['set_image_meta_alt'] = 1;
				$options['set_image_meta_description'] = 1;
			}

			if ("" == $options['custom_type']) $options['custom_type'] = $options['type'];

			$exclude_taxonomies = (class_exists('PMWI_Plugin')) ? array('post_format', 'product_type') : array('post_format');
			$post_taxonomies = array_diff_key(get_taxonomies_by_object_type(array($options['custom_type']), 'object'), array_flip($exclude_taxonomies));

			$options['tax_logic'] = array();
			$options['tax_assing'] = array();
			$options['tax_multiple_xpath'] = array();
			$options['tax_multiple_delim'] = array();
			$options['tax_hierarchical_logic_entire'] = array();
			$options['tax_hierarchical_logic_manual'] = array();

			if ( ! empty($post_taxonomies)):
				foreach ($post_taxonomies as $ctx):

					$options['tax_logic'][$ctx->name] = ($ctx->hierarchical) ? 'hierarchical' : 'multiple';

					if ($ctx->name == 'category'){
						$options['post_taxonomies']['category'] = $options['categories'];
					}
					elseif ($ctx->name == 'post_tag' ){
						$options['tax_assing']['post_tag'] = 1;
						$options['tax_multiple_xpath']['post_tag'] = $options['tags'];
						$options['tax_multiple_delim']['post_tag'] = $options['tags_delim'];
 					}

					if ( ! empty($options['post_taxonomies'][$ctx->name])){

						$taxonomies_hierarchy = json_decode($options['post_taxonomies'][$ctx->name], true);
						$options['tax_assing'][$ctx->name] = (!empty($taxonomies_hierarchy[0]['assign'])) ? 1 : 0;

						if ($options['tax_logic'][$ctx->name] == 'multiple') {
							$options['tax_multiple_xpath'][$ctx->name] = (!empty($taxonomies_hierarchy[0]['xpath'])) ? $taxonomies_hierarchy[0]['xpath'] : '';
							$options['tax_multiple_delim'][$ctx->name] = (!empty($taxonomies_hierarchy[0]['delim'])) ? $taxonomies_hierarchy[0]['delim'] : '';
						}
						else{
							$options['tax_hierarchical_logic_manual'][$ctx->name] = 1;
						}
					}

				endforeach;
			endif;
		}

        /**
         * @param $options
         * @param $version
         */
        public function ver_4x_transition_fix(&$options, $version){
			if ( version_compare($version, '4.0.5') < 0  ){
				if ( ! empty($options['tax_hierarchical_logic']) and is_array($options['tax_hierarchical_logic']) ){
					foreach ($options['tax_hierarchical_logic'] as $tx => $type) {
						switch ($type){
							case 'entire':
								$options['tax_hierarchical_logic_entire'][$tx] = 1;
								break;
							case 'manual':
								$options['tax_hierarchical_logic_manual'][$tx] = 1;
								break;
							default:

								break;
						}
					}
					unset($options['tax_hierarchical_logic']);
				}
			}
			if ( version_compare($version, '4.5.2') < 0  ) {
				// for existing imports with 'Search' enabled, set it to match by filename.
				if (!empty($options['search_existing_images'])){
					$options['search_existing_images_logic'] = 'by_filename';
				}
			}
            if ( version_compare($version, '4.6.2') < 0  ) {
                // Disable selective update hashing by default for existing imports.
                $options['is_selective_hashing'] = 0;
            }
		}

		/**
		 * pre-dispatching logic for admin page controllers
		 */
		public function adminInit() {

			self::$session = new PMXI_Handler();

			$input = new PMXI_Input();
			$page = strtolower($input->getpost('page', ''));

			if (preg_match('%^' . preg_quote(str_replace('_', '-', self::PREFIX), '%') . '([\w-]+)$%', $page)) {
				//$this->adminDispatcher($page, strtolower($input->getpost('action', 'index')));

				$action = strtolower($input->getpost('action', 'index'));

				// capitalize prefix and first letters of class name parts
				$controllerName = preg_replace_callback('%(^' . preg_quote(self::PREFIX, '%') . '|_).%', array($this, "replace_callback"),str_replace('-', '_', $page));
				$actionName = str_replace('-', '_', $action);
				if (method_exists($controllerName, $actionName)) {

					@ini_set("max_input_time", PMXI_Plugin::getInstance()->getOption('max_input_time'));
					@ini_set("max_execution_time", PMXI_Plugin::getInstance()->getOption('max_execution_time'));

					if ( ! get_current_user_id() or ! current_user_can( self::$capabilities )) {
					    // This nonce is not valid.
					    die( 'Security check' );

					} else {

						$this->_admin_current_screen = (object)array(
							'id' => $controllerName,
							'base' => $controllerName,
							'action' => $actionName,
							'is_ajax' => (isset($_SERVER["HTTP_ACCEPT"]) && strpos($_SERVER["HTTP_ACCEPT"], 'json')) !== false,
							'is_network' => is_network_admin(),
							'is_user' => is_user_admin(),
						);
						add_filter('current_screen', array($this, 'getAdminCurrentScreen'));
						add_filter('admin_body_class', array($this, 'getAdminBodyClass'), 10, 1);

						$controller = new $controllerName();
						if ( ! $controller instanceof PMXI_Controller_Admin) {
							throw new Exception("Administration page `$page` matches to a wrong controller type.");
						}

						if ($this->_admin_current_screen->is_ajax) { // ajax request
							$controller->$action();
							do_action('pmxi_action_after');
							die(); // stop processing since we want to output only what controller is randered, nothing in addition
						} elseif ( ! $controller->isInline) {
							@ob_start();
							$controller->$action();
							self::$buffer = @ob_get_clean();
						} else {
							self::$buffer_callback = array($controller, $action);
						}

					}

				} else { // redirect to dashboard if requested page and/or action don't exist
					wp_redirect(admin_url()); die();
				}
			}
		}

        /**
         * @param $class
         * @return string
         */
        function getAdminBodyClass($class){
			return $class . ' wpallimport-plugin';
		}

		/**
		 * Dispatch shorttag: create corresponding controller instance and call its index method
		 * @param array $args Shortcode tag attributes
		 * @param string $content Shortcode tag content
		 * @param string $tag Shortcode tag name which is being dispatched
		 * @return string
		 */
		public function shortcodeDispatcher($args, $content, $tag) {

			$controllerName = self::PREFIX . preg_replace_callback('%(^|_).%', array($this, "replace_callback"), $tag);// capitalize first letters of class name parts and add prefix
			$controller = new $controllerName();
			if ( ! $controller instanceof PMXI_Controller) {
				throw new Exception("Shortcode `$tag` matches to a wrong controller type.");
			}
			ob_start();
			$controller->index($args, $content);
			return ob_get_clean();
		}

        /**
         * @var null
         */
        static $buffer = NULL;
        /**
         * @var null
         */
        static $buffer_callback = NULL;

		/**
		 * Dispatch admin page: call corresponding controller based on get parameter `page`
		 * The method is called twice: 1st time as handler `parse_header` action and then as admin menu item handler
		 * @param string[optional] $page When $page set to empty string ealier buffered content is outputted, otherwise controller is called based on $page value
		 */
		public function adminDispatcher($page = '', $action = 'index') {

			if ('' === $page) {
				if ( ! is_null(self::$buffer)) {
					echo '<div class="wrap">';
					echo self::$buffer;
					do_action('pmxi_action_after');
					echo '</div>';
				} elseif ( ! is_null(self::$buffer_callback)) {
					echo '<div class="wrap">';
					call_user_func(self::$buffer_callback);
					do_action('pmxi_action_after');
					echo '</div>';
				} else {
					throw new Exception('There is no previousely buffered content to display.');
				}
			}

		}

        /**
         * @param $matches
         * @return string
         */
        public function replace_callback($matches){
			return strtoupper($matches[0]);
		}

        /**
         * @var null
         */
        protected $_admin_current_screen = NULL;

        /**
         * @return null
         */
        public function getAdminCurrentScreen(){
			return $this->_admin_current_screen;
		}

		/**
		 * Autoloader
		 * It's assumed class name consists of prefix folloed by its name which in turn corresponds to location of source file
		 * if `_` symbols replaced by directory path separator. File name consists of prefix folloed by last part in class name (i.e.
		 * symbols after last `_` in class name)
		 * When class has prefix it's source is looked in `models`, `controllers`, `shortcodes` folders, otherwise it looked in `core` or `library` folder
		 *
		 * @param string $className
		 * @return bool
		 */
		public function autoload($className) {
			$is_prefix = false;
			$filePath = str_replace('_', '/', preg_replace('%^' . preg_quote(self::PREFIX, '%') . '%', '', strtolower($className), 1, $is_prefix)) . '.php';
			if ( ! $is_prefix) { // also check file with original letter case
				$filePathAlt = $className . '.php';
			}
			foreach ($is_prefix ? array('models', 'controllers', 'shortcodes', 'classes') : array('libraries') as $subdir) {
				$path = self::ROOT_DIR . '/' . $subdir . '/' . $filePath;				
				if (strlen($filePath) < 40 && is_file($path)) {
					require $path;
					return TRUE;
				}
				if ( ! $is_prefix) {
					$pathAlt = self::ROOT_DIR . '/' . $subdir . '/' . $filePathAlt;					
					if (strlen($filePathAlt) < 40 && is_file($pathAlt)) {
						require $pathAlt;
						return TRUE;
					}
				}
			}

			if(strpos($className, '\\') !== false){

				// project-specific namespace prefix
				$prefix = 'Wpai\\';

				// base directory for the namespace prefix
				$base_dir = self::ROOT_DIR . '/src/';

				// does the class use the namespace prefix?
				$len = strlen($prefix);
				if (strncmp($prefix, $className, $len) !== 0) {
					// no, move to the next registered autoloader
					return;
				}

				// get the relative class name
				$relative_class = substr($className, $len);

				// replace the namespace prefix with the base directory, replace namespace
				// separators with directory separators in the relative class name, append
				// with .php
				$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

				// if the file exists, require it
				if (file_exists($file)) {
					require_once $file;
				}
			}

			return FALSE;
		}

		/**
		 * Get plugin option
		 * @param string[optional] $option Parameter to return, all array of options is returned if not set
		 * @return mixed
		 */
		public function getOption($option = NULL) {
			$options = apply_filters('wp_all_import_config_options', $this->options);
			if (is_null($option)) {
				return $options;
			} else if (isset($options[$option])) {
				return $options[$option];
			} else {
				throw new Exception("Specified option is not defined for the plugin");
			}
		}
		/**
		 * Update plugin option value
		 * @param string $option Parameter name or array of name => value pairs
		 * @param mixed[optional] $value New value for the option, if not set than 1st parameter is supposed to be array of name => value pairs
		 * @return array
		 */
		public function updateOption($option, $value = NULL) {
			is_null($value) or $option = array($option => $value);
			if (array_diff_key($option, $this->options)) {
				throw new Exception("Specified option is not defined for the plugin");
			}
			$this->options = $option + $this->options;
			// encode licenses
			if (!empty($this->options['licenses'])){
				foreach ( $this->options['licenses'] as $key => $value){
					$this->options['licenses'][$key] = self::encode(self::decode($value));
				}
			}
			update_option(get_class($this) . '_Options', $this->options);

			return $this->options;
		}

        /**
         * @param $value
         * @return string
         */
        public static function encode($value){
            $salt = defined('AUTH_SALT') ? AUTH_SALT : wp_salt();
			return base64_encode(md5($salt) . $value . md5(md5($salt)));
		}

        /**
         * @param $encoded
         * @return mixed
         */
        public static function decode($encoded){
            $salt = defined('AUTH_SALT') ? AUTH_SALT : wp_salt();
			return preg_match('/^[a-f0-9]{32}$/', $encoded) ? $encoded : str_replace(array(md5($salt), md5(md5($salt))), '', base64_decode($encoded));
		}
		
		/**
		 * Plugin activation logic
		 */
		public function activation() {

			$installer = new PMXI_Installer();
			$installer->checkActivationConditions();

            if(class_exists('PMXE_Plugin')) {
                if(method_exists('PMXE_Plugin', 'getSchedulingName')) {
                    $schedulingLicenseData = array();
                    $schedulingLicenseData['scheduling_license'] = PMXE_Plugin::getInstance()->getOption('scheduling_license');
                    $schedulingLicenseData['scheduling_license_status'] = PMXE_Plugin::getInstance()->getOption('scheduling_license_status');

                    PMXI_Plugin::getInstance()->updateOption($schedulingLicenseData);
                }
            }

			// uncaught exception doesn't prevent plugin from being activated, therefore replace it with fatal error so it does      
			set_exception_handler(function($e){trigger_error($e->getMessage(), E_USER_ERROR);});

			// create plugin options
			$option_name = get_class($this) . '_Options';
			$options_default = PMXI_Config::createFromFile(self::ROOT_DIR . '/config/options.php')->toArray();
			$wpai_options = get_option($option_name, false);
			if ( ! $wpai_options ) update_option($option_name, $options_default);

			// create/update required database tables
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			require self::ROOT_DIR . '/schema.php';
			global $wpdb;

			delete_transient(PMXI_Plugin::$cache_key);

			$wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name = %s", 'wp-all-import-pro_' . PMXI_Plugin::$cache_key) );
			$wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name = %s", 'wp-all-import-pro_timeout_' . PMXI_Plugin::$cache_key) );

			delete_site_transient('update_plugins');

			if (function_exists('is_multisite') && is_multisite()) {
		        // check if it is a network activation - if so, run the activation function for each blog id
		        if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
		            $old_blog = $wpdb->blogid;
		            // Get all blog ids
		            $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		            foreach ($blogids as $blog_id) {
		                switch_to_blog($blog_id);
		                require self::ROOT_DIR . '/schema.php';
		                dbDelta($plugin_queries);

						// sync data between plugin tables and wordpress (mostly for the case when plugin is reactivated)
						$pmxi_post = new PMXI_Post_Record();
						$pmxi_import = new PMXI_Import_Record();
						
						$imports_list = $wpdb->get_results('SELECT id FROM ' . $pmxi_import->getTable() . '');
						
						if ( ! empty($imports_list) ) {
							
							$user_imports = array();
							$comment_imports = array();
							$post_imports = array();

							foreach ($imports_list as $import_entry) {
								$import_id = $import_entry->id;
								$import = $pmxi_import->getById($import_id);
								$import_options = maybe_unserialize($import->options);
								$import_type = $import_options['custom_type'];
								if ( in_array($import_type, array('import_users', 'shop_customer')) ) {
                                    $user_imports[] = $import_id;
                                } elseif ( in_array($import_type, array('comments', 'reviews')) ) {
                                    $comment_imports[] = $import_id;
								} else {
									$post_imports[] = $import_id;
								}
							}
								
							if ( ! empty($user_imports) ) {
								$user_table = $wpdb->base_prefix . 'users';
								$user_query = 'DELETE FROM ' . $pmxi_post->getTable() . ' WHERE import_id IN (' . implode(',', $user_imports) . ') AND post_id NOT IN (SELECT ID FROM ' . $user_table . ')';
								$wpdb->query($user_query);
							}

                            if ( ! empty($comment_imports) ) {
                                $comment_table = $wpdb->base_prefix . 'comments';
                                $comment_query = 'DELETE FROM ' . $pmxi_post->getTable() . ' WHERE import_id IN (' . implode(',', $comment_imports) . ') AND post_id NOT IN (SELECT comment_ID FROM ' . $comment_table . ')';
                                $wpdb->query($comment_query);
                            }
							
							if ( ! empty($post_imports) ) {
								$post_query = 'DELETE FROM ' . $pmxi_post->getTable() . ' WHERE import_id IN (' . implode(',', $post_imports) . ') AND post_id NOT IN (SELECT ID FROM ' . $wpdb->posts . ')';
								$wpdb->query($post_query);
							}
						}
		            }
		            switch_to_blog($old_blog);
		            return;
		        }
		    }

			dbDelta($plugin_queries);

			// sync data between plugin tables and wordpress (mostly for the case when plugin is reactivated)
			$pmxi_post = new PMXI_Post_Record();
			
			$pmxi_import = new PMXI_Import_Record();
			
			$imports_list = $wpdb->get_results('SELECT id FROM ' . $pmxi_import->getTable() . '');
			
			if ( ! empty($imports_list) ) {
				
				$user_imports = array();
                $comment_imports = array();
				$post_imports = array();
				
				foreach ($imports_list as $import_entry) {
					$import_id = $import_entry->id;
					$import = $pmxi_import->getById($import_id);
					$import_options = maybe_unserialize($import->options);
					$import_type = $import_options['custom_type'];
					if ( in_array($import_type, array('import_users', 'shop_customer')) ) {
                        $user_imports[] = $import_id;
                    } elseif ( in_array($import_type, array('comments', 'reviews')) ) {
                        $comment_imports[] = $import_id;
                    } else {
						$post_imports[] = $import_id;
					}
				}
					
				if ( ! empty($user_imports) ) {
					$user_table = $wpdb->base_prefix . 'users';
					$user_query = 'DELETE FROM ' . $pmxi_post->getTable() . ' WHERE import_id IN (' . implode(',', $user_imports) . ') AND post_id NOT IN (SELECT ID FROM ' . $user_table . ')';
					$wpdb->query($user_query);
				}

                if ( ! empty($comment_imports) ) {
                    $comment_table = $wpdb->base_prefix . 'comments';
                    $comment_query = 'DELETE FROM ' . $pmxi_post->getTable() . ' WHERE import_id IN (' . implode(',', $comment_imports) . ') AND post_id NOT IN (SELECT comment_ID FROM ' . $comment_table . ')';
                    $wpdb->query($comment_query);
                }
				
				if ( ! empty($post_imports) ) {
					$post_query = 'DELETE FROM ' . $pmxi_post->getTable() . ' WHERE import_id IN (' . implode(',', $post_imports) . ') AND post_id NOT IN (SELECT ID FROM ' . $wpdb->posts . ')';
					$wpdb->query($post_query);
				}
			}
		}

		/**
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present
		 *
		 * @access public
		 * @return void
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'wp_all_import_plugin', false, dirname( plugin_basename( __FILE__ ) ) . "/i18n/languages" );
		}

        /**
         * @return bool
         * @throws Exception
         */
        public function fix_db_schema(){

			$uploads = wp_upload_dir();

			if ( ! is_dir($uploads['basedir'] . DIRECTORY_SEPARATOR . self::LOGS_DIRECTORY) or ! is_writable($uploads['basedir'] . DIRECTORY_SEPARATOR . self::LOGS_DIRECTORY)) {
				die(sprintf(__('Uploads folder %s must be writable', 'wp_all_import_plugin'), $uploads['basedir'] . DIRECTORY_SEPARATOR . self::LOGS_DIRECTORY));
			}

			if ( ! is_dir($uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY) or ! is_writable($uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY)) {
				die(sprintf(__('Uploads folder %s must be writable', 'wp_all_import_plugin'), $uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY));
			}

			// create/update required database tables
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			require self::ROOT_DIR . '/schema.php';
			global $wpdb;

			if (function_exists('is_multisite') && is_multisite()) {
		        // check if it is a network activation - if so, run the activation function for each blog id
		        if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
		            $old_blog = $wpdb->blogid;
		            // Get all blog ids
		            $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		            foreach ($blogids as $blog_id) {
		                switch_to_blog($blog_id);
		                require self::ROOT_DIR . '/schema.php';
		                dbDelta($plugin_queries);

						// sync data between plugin tables and wordpress (mostly for the case when plugin is reactivated)

						$post = new PMXI_Post_Record();
						$wpdb->query('DELETE FROM ' . $post->getTable() . ' WHERE post_id NOT IN (SELECT ID FROM ' . $wpdb->posts .') AND post_id NOT IN ( SELECT ID FROM ' . $wpdb->users . ') AND post_id NOT IN ( SELECT term_taxonomy_id FROM ' . $wpdb->term_taxonomy . ') AND post_id NOT IN ( SELECT comment_ID FROM ' . $wpdb->comments . ')');
		            }
		            switch_to_blog($old_blog);
		            return;
		        }
		    }

			dbDelta($plugin_queries);

			// do not execute ALTER TABLE queries if sql user doesn't have ALTER privileges
			$grands = $wpdb->get_results("SELECT * FROM information_schema.user_privileges WHERE grantee LIKE \"'" . DB_USER . "'%\" AND PRIVILEGE_TYPE = 'ALTER' AND IS_GRANTABLE = 'YES';");

			$table = $table = $this->getTablePrefix() . 'files';

			$tablefields = $wpdb->get_results("DESCRIBE {$table};");
			// For every field in the table
			foreach ($tablefields as $tablefield) {
				if ('contents' == $tablefield->Field) {
					$list = new PMXI_File_List();
					for ($i = 1; $list->getBy(NULL, 'id', $i, 1)->count(); $i++) {
						foreach ($list->convertRecords() as $file) {
							$file->save(); // resave file for file to be stored in uploads folder
						}
					}

					if (!empty($grands)) $wpdb->query("ALTER TABLE {$table} DROP " . $tablefield->Field);

					break;
				}
			}

			// alter images table
			$table = $this->getTablePrefix() . 'images';
			$tablefields = $wpdb->get_results("DESCRIBE {$table};");
			$fields_to_alter = array(
				'image_url',
				'image_filename'
			);

			// Check if field exists
			foreach ($tablefields as $tablefield) {
				if (in_array($tablefield->Field, $fields_to_alter)){
					$fields_to_alter = array_diff($fields_to_alter, array($tablefield->Field));
				}
			}

			if ( ! empty($fields_to_alter) ){

				if (empty($grands)) return false;

				foreach ($fields_to_alter as $field) {
					switch ($field) {
						case 'image_url':
							$wpdb->query("ALTER TABLE {$table} ADD `image_url` VARCHAR(600) NOT NULL DEFAULT '';");
							break;
						case 'image_filename':
							$wpdb->query("ALTER TABLE {$table} ADD `image_filename` VARCHAR(600) NOT NULL DEFAULT '';");
							break;
						default:
							# code...
							break;
					}
				}
			}

			$table = $this->getTablePrefix() . 'imports';
			$tablefields = $wpdb->get_results("DESCRIBE {$table};");
			$fields_to_alter = array(
				'parent_import_id',
				'iteration',
				'deleted',
				'executing',
				'canceled',
				'canceled_on',
				'failed',
				'failed_on',
				'settings_update_on',
				'last_activity'
			);

			// Check if field exists
			foreach ($tablefields as $tablefield) {
				if (in_array($tablefield->Field, $fields_to_alter)){
					$fields_to_alter = array_diff($fields_to_alter, array($tablefield->Field));
				}
			}

			if ( ! empty($fields_to_alter) ){

				if (empty($grands)) return false;

				foreach ($fields_to_alter as $field) {
					switch ($field) {
						case 'parent_import_id':
							$wpdb->query("ALTER TABLE {$table} ADD `parent_import_id` BIGINT(20) NOT NULL DEFAULT 0;");
							break;
						case 'iteration':
							$wpdb->query("ALTER TABLE {$table} ADD `iteration` BIGINT(20) NOT NULL DEFAULT 0;");
							break;
						case 'deleted':
							$wpdb->query("ALTER TABLE {$table} ADD `deleted` BIGINT(20) NOT NULL DEFAULT 0;");
							break;
						case 'executing':
							$wpdb->query("ALTER TABLE {$table} ADD `executing` BOOL NOT NULL DEFAULT 0;");
							break;
						case 'canceled':
							$wpdb->query("ALTER TABLE {$table} ADD `canceled` BOOL NOT NULL DEFAULT 0;");
							break;
						case 'canceled_on':
							$wpdb->query("ALTER TABLE {$table} ADD `canceled_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';");
							break;
						case 'failed':
							$wpdb->query("ALTER TABLE {$table} ADD `failed` BOOL NOT NULL DEFAULT 0;");
							break;
						case 'failed_on':
							$wpdb->query("ALTER TABLE {$table} ADD `failed_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';");
							break;
						case 'settings_update_on':
							$wpdb->query("ALTER TABLE {$table} ADD `settings_update_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';");
							break;
						case 'last_activity':
							$wpdb->query("ALTER TABLE {$table} ADD `last_activity` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';");
							break;

						default:
							# code...
							break;
					}
				}
			}

			$table = $this->getTablePrefix() . 'posts';
			$tablefields = $wpdb->get_results("DESCRIBE {$table};");
			$iteration = false;
			$specified = false;

			// Check if field exists
			foreach ($tablefields as $tablefield) {
				if ('iteration' == $tablefield->Field) $iteration = true;
				if ('specified' == $tablefield->Field) $specified = true;
			}

			if (!$iteration){

				if (empty($grands)) {
					?>
					<div class="error"><p>
						<?php printf(
								__('<b>%s Plugin</b>: Current sql user %s doesn\'t have ALTER privileges', 'wp_all_import_plugin'),
								self::getInstance()->getName(), DB_USER
						) ?>
					</p></div>
					<?php
					return false;
				}

				$wpdb->query("ALTER TABLE {$table} ADD `iteration` BIGINT(20) NOT NULL DEFAULT 0;");
			}

            $post_id_index = $wpdb->get_results( "SHOW INDEX FROM {$table} where key_name='post_id';" );
            if ( ! empty( $post_id_index ) ) {
                $wpdb->query("DROP INDEX post_id ON {$table};");
            }
            $import_id_index = $wpdb->get_results("SHOW INDEX FROM {$table} where key_name='import_id';");
            if ( ! empty( $import_id_index ) ) {
                $wpdb->query("DROP INDEX import_id ON {$table};");
            }

			if (!$specified and !empty($grands))
			{
				$wpdb->query("ALTER TABLE {$table} ADD `specified` BOOL NOT NULL DEFAULT 0;");
			}

			if ( ! empty($wpdb->charset))
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate))
				$charset_collate .= " COLLATE $wpdb->collate";

			$table_prefix = $this->getTablePrefix();

			$wpdb->query("CREATE TABLE IF NOT EXISTS {$table_prefix}history (
				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				import_id BIGINT(20) UNSIGNED NOT NULL,
				type ENUM('manual','processing','trigger','continue','') NOT NULL DEFAULT '',
				time_run TEXT,
				date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
				summary TEXT,
				PRIMARY KEY  (id)
			) $charset_collate;");

			return true;
		}

		/**
		 * Method returns default import options, main utility of the method is to avoid warnings when new
		 * option is introduced but already registered imports don't have it
		 */
		public static function get_default_import_options() {
			return array(
				'type' => 'post',
				'is_override_post_type' => 0,
				'post_type_xpath' => '',
				'deligate' => '',
				'wizard_type' => 'new',
				'custom_type' => '',
				'featured_delim' => ',',
				'atch_delim' => ',',
				'is_search_existing_attach' => 0,
				'post_taxonomies' => array(),
				'parent' => 0,
				'is_multiple_page_parent' => 'yes',
				'single_page_parent' => '',
				'order' => 0,
				'status' => 'publish',
				'page_template' => 'default',
				'is_multiple_page_template' => 'yes',
				'single_page_template' => '',
				'page_taxonomies' => array(),
				'date_type' => 'specific',
				'date' => 'now',
				'date_start' => 'now',
				'date_end' => 'now',
				'custom_name' => array(),
				'custom_value' => array(),
				'custom_format' => array(),
				'custom_mapping' => array(),
				'serialized_values' => array(),
				'custom_mapping_rules' => array(),
				'comment_status' => 'open',
				'comment_status_xpath' => '',
				'ping_status' => 'open',
				'ping_status_xpath' => '',
				'create_draft' => 'no',
				'author' => '',
				'post_excerpt' => '',
				'post_slug' => '',
				'attachments' => '',
				'is_import_specified' => 0,
				'import_specified' => '',
				'is_delete_source' => 0,
				'is_cloak' => 0,
				'unique_key' => '',
				'tmp_unique_key' => '',
				'feed_type' => 'auto',
				'search_existing_images' => 1,

				'create_new_records' => 1,
				'is_selective_hashing' => 1,
				'is_delete_missing' => 0,
				'set_missing_to_draft' => 0,
				'is_update_missing_cf' => 0,
				'update_missing_cf_name' => '',
				'update_missing_cf_value' => '',

				'is_keep_former_posts' => 'no',
				'is_update_status' => 1,
				'is_update_content' => 1,
				'is_update_title' => 1,
				'is_update_slug' => 1,
				'is_update_excerpt' => 1,
				'is_update_categories' => 1,
				'is_update_author' => 1,
				'is_update_comment_status' => 1,
				'is_update_ping_status' => 1,
				'is_update_post_type' => 1,
				'update_categories_logic' => 'full_update',
				'taxonomies_list' => array(),
				'taxonomies_only_list' => array(),
				'taxonomies_except_list' => array(),
				'is_update_attachments' => 1,
				'is_update_images' => 1,
				'update_images_logic' => 'full_update',
				'is_update_dates' => 1,
				'is_update_menu_order' => 1,
				'is_update_parent' => 1,
				'is_keep_attachments' => 0,
				'is_keep_imgs' => 0,
				'do_not_remove_images' => 1,

				'is_update_custom_fields' => 1,
				'update_custom_fields_logic' => 'full_update',
				'custom_fields_list' => array(),
				'custom_fields_only_list' => array(),
				'custom_fields_except_list' => array(),

				'duplicate_matching' => 'auto',
				'duplicate_indicator' => 'title',
				'custom_duplicate_name' => '',
				'custom_duplicate_value' => '',
				'is_update_previous' => 0,
				'is_scheduled' => '',
				'scheduled_period' => '',
				'friendly_name' => '',
				'records_per_request' => 20,
				'auto_rename_images' => 0,
				'auto_rename_images_suffix' => '',
				'images_name' => 'filename',
				'post_format' => 'standard',
				'post_format_xpath' => '',
				'encoding' => 'UTF-8',
				'delimiter' => '',
				'image_meta_title' => '',
				'image_meta_title_delim' => ',',
				'image_meta_caption' => '',
				'image_meta_caption_delim' => ',',
				'image_meta_alt' => '',
				'image_meta_alt_delim' => ',',
				'image_meta_description' => '',
				'image_meta_description_delim' => ',',
				'image_meta_description_delim_logic' => 'separate',
				'status_xpath' => '',
				'download_images' => 'yes',
				'converted_options' => 0,
				'update_all_data' => 'yes',
				'is_fast_mode' => 0,
				'chuncking' => 1,
				'import_processing' => 'ajax',
				'processing_iteration_logic' => 'auto',
				'save_template_as' => 0,

				'title' => '',
				'content' => '',
				'name' => '',
				'is_keep_linebreaks' => 1,
				'is_leave_html' => 0,
				'fix_characters' => 0,
				'pid_xpath' => '',
				'slug_xpath' => '',
				'title_xpath' => '',

				'featured_image' => '',
				'download_featured_image' => '',
				'download_featured_delim' => ',',
				'gallery_featured_image' => '',
				'gallery_featured_delim' => ',',
				'is_featured' => 1,
				'is_featured_xpath' => '',
				'set_image_meta_title' => 0,
				'set_image_meta_caption' => 0,
				'set_image_meta_alt' => 0,
				'set_image_meta_description' => 0,
				'auto_set_extension' => 0,
				'new_extension' => '',
				'tax_logic' => array(),
				'tax_assing' => array(),
				'term_assing' => array(),
				'multiple_term_assing' => array(),
				'tax_hierarchical_assing' => array(),
				'tax_hierarchical_last_level_assign' => array(),
				'tax_single_xpath' => array(),
				'tax_multiple_xpath' => array(),
				'tax_hierarchical_xpath' => array(),
				'tax_multiple_delim' => array(),
				'tax_hierarchical_delim' => array(),
				'tax_manualhierarchy_delim' => array(),
				'tax_hierarchical_logic_entire' => array(),
				'tax_hierarchical_logic_manual' => array(),
				'tax_enable_mapping' => array(),
				'tax_is_full_search_single' => array(),
				'tax_is_full_search_multiple' => array(),
				'tax_assign_to_one_term_single' => array(),
				'tax_assign_to_one_term_multiple' => array(),
				'tax_mapping' => array(),
				'tax_logic_mapping' => array(),
				'is_tax_hierarchical_group_delim' => array(),
				'tax_hierarchical_group_delim' => array(),
				'nested_files' => array(),
				'xml_reader_engine' => 0,
				'taxonomy_type' => '',
				'taxonomy_parent' => '',
				'taxonomy_slug' => 'auto',
				'taxonomy_slug_xpath' => '',
				'import_img_tags' => 0,
				'search_existing_images_logic' => 'by_url',
				'enable_import_scheduling' => 'false',
				'scheduling_enable' => false,
				'scheduling_weekly_days' => '',
				'scheduling_run_on' => 'weekly',
				'scheduling_monthly_day' => '',
				'scheduling_times' => array(),
				'scheduling_timezone' => 'UTC',
                'is_update_comment_post_id' => 1,
                'is_update_comment_author' => 1,
                'is_update_comment_author_email' => 1,
                'is_update_comment_author_url' => 1,
                'is_update_comment_author_IP' => 1,
                'is_update_comment_karma' => 1,
                'is_update_comment_approved' => 1,
                'is_update_comment_verified' => 1,
                'is_update_comment_rating' => 1,
                'is_update_comment_agent' => 1,
                'is_update_comment_user_id' => 1,
                'is_update_comment_type' => 1,
                'is_update_comments' => 1,
                'update_comments_logic' => 'full_update',
                'comment_author' => '',
                'comment_author_email' => '',
                'comment_author_url' => '',
                'comment_author_IP' => '',
                'comment_karma' => '',
                'comment_parent' => '',
                'comment_approved' => '1',
                'comment_approved_xpath' => '',
                'comment_verified' => '1',
                'comment_verified_xpath' => '',
                'comment_agent' => '',
                'comment_type' => '',
                'comment_type_xpath' => '',
                'comment_user_id' => 'email',
                'comment_user_id_xpath' => '',
                'comment_post' => '',
                'comment_rating' => '',
                'comments_repeater_mode' => 'csv',
                'comments_repeater_mode_separator' => '|',
                'comments_repeater_mode_foreach' => '',
                'comments' => array(
                    'content' => '',
                    'author' => '',
                    'author_email' => '',
                    'author_url' => '',
                    'author_ip' => '',
                    'karma' => '',
                    'approved' => '',
                    'type' => '',
                    'date' => 'now'
                )
			);
		}

		/*
		 * Convert csv to xml
		 */
        /**
         * @param $csv_url
         * @return string
         */
        public static function csv_to_xml($csv_url){

			include_once(self::ROOT_DIR.'/libraries/XmlImportCsvParse.php');

			$csv = new PMXI_CsvParser($csv_url);

			$wp_uploads = wp_upload_dir();
			$tmpname = wp_unique_filename($wp_uploads['path'], str_replace("csv", "xml", basename($csv_url)));
			$xml_file = $wp_uploads['path']  .'/'. $tmpname;
			file_put_contents($xml_file, $csv->toXML());
			return $xml_file;

		}

        /**
         * @return bool
         */
        public static function is_ajax(){
			return (isset($_SERVER["HTTP_ACCEPT"]) && strpos($_SERVER["HTTP_ACCEPT"], 'json')) !== false;
		}

	}

	PMXI_Plugin::getInstance();

	function wp_all_import_pro_updater(){
	    if (class_exists('PMXI_Updater')) {
            // retrieve our license key from the DB
            $wp_all_import_options = get_option('PMXI_Plugin_Options');

            // setup the updater
            $updater = new PMXI_Updater( $wp_all_import_options['info_api_url'], __FILE__, array(
                    'version' 	=> PMXI_VERSION,		// current version number
                    'license' 	=> (!empty($wp_all_import_options['licenses']['PMXI_Plugin'])) ? PMXI_Plugin::decode($wp_all_import_options['licenses']['PMXI_Plugin']) : false, // license key (used get_option above to retrieve from DB)
                    'item_name' => PMXI_Plugin::getEddName(), 	// name of this plugin
                    'author' 	=> 'Soflyy'  // author of this plugin
                )
            );
        }
	}

	add_action( 'admin_init', 'wp_all_import_pro_updater', 0 );

}

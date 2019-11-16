<?php
/* @package   GFP_Salesforce\GFP_Salesforce_Addon
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 * @copyright 2017-2019 gravity+
 * @license   GPL-2.0+
 * @since     0.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Class GFP_Salesforce_Addon
 *
 * Gravity Forms Add-On
 *
 * @since  0.1
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Salesforce_Addon extends GFFeedAddOn {

	/**
	 * @var string Version number of the Add-On
	 */
	protected $_version;
	/**
	 * @var string Gravity Forms minimum version requirement
	 */
	protected $_min_gravityforms_version;
	/**
	 * @var string URL-friendly identifier used for form settings, add-on settings, text domain localization...
	 */
	protected $_slug;
	/**
	 * @var string Relative path to the plugin from the plugins folder
	 */
	protected $_path;
	/**
	 * @var string Full path to the plugin. Example: __FILE__
	 */
	protected $_full_path;
	/**
	 * @var string URL to the App website.
	 */
	protected $_url;
	/**
	 * @var string Title of the plugin to be used on the settings page, form settings and plugins page.
	 */
	protected $_title;
	/**
	 * @var string Short version of the plugin title to be used on menus and other places where a less verbose string
	 *      is useful.
	 */
	protected $_short_title;
	/**
	 * @var array Members plugin integration. List of capabilities to add to roles.
	 */
	protected $_capabilities = array();

	// ------------ Permissions -----------
	/**
	 * @var string|array A string or an array of capabilities or roles that have access to the settings page
	 */
	protected $_capabilities_settings_page = array();

	/**
	 * @var string|array A string or an array of capabilities or roles that have access to the form settings
	 */
	protected $_capabilities_form_settings = array();
	/**
	 * @var string|array A string or an array of capabilities or roles that can uninstall the plugin
	 */
	protected $_capabilities_uninstall = array();

	protected $_supports_feed_ordering = true;

	// ------------ Auto-Upgrades -----------
	/**
	 * @var GFP_Auto_Upgrader
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	protected $_auto_upgrader;

	// ------------ Processing -----------
	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var GFP_Salesforce_API | null
	 */
	protected $_gfp_salesforce_api = null;

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var bool
	 */
	private $_processing_feed = false;

	/**
	 * Array of objects that are created during feed processing
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var null | array
	 */
	private $_created_objects = null;

	/**
	 * Salesforce response
	 *
	 * @since 1.3.0
	 *
	 * @var array
	 */
	public $salesforce_response = array();

	/**
	 * If true, maybe_delay_individual_feed() checks will be bypassed allowing the feed to be processed.
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var bool
	 */
	protected $_bypass_individual_feed_delay = false;

	private static $_instance = null;

	/**
	 * @see    parent
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $args
	 */
	function __construct( $args ) {

		$this->_version                    = $args[ 'version' ];
		$this->_slug                       = $args[ 'plugin_slug' ];
		$this->_min_gravityforms_version   = $args[ 'min_gf_version' ];
		$this->_path                       = $args[ 'path' ];
		$this->_full_path                  = $args[ 'full_path' ];
		$this->_url                        = $args[ 'url' ];
		$this->_title                      = $args[ 'title' ];
		$this->_short_title                = $args[ 'short_title' ];
		$this->_capabilities               = $args[ 'capabilities' ];
		$this->_capabilities_settings_page = $args[ 'capabilities_settings_page' ];
		$this->_capabilities_form_settings = $args[ 'capabilities_form_settings' ];
		$this->_capabilities_uninstall     = $args[ 'capabilities_uninstall' ];


		$is_gravityforms_supported = $this->is_gravityforms_supported( $this->_min_gravityforms_version );

		$license_key = trim( $this->get_plugin_setting( 'license_key' ) );

		$early_access = ( '1' == $this->get_plugin_setting( 'early_access' ) ) ? true : false;

		$this->_auto_upgrader = new GFP_Auto_Upgrader( $this->_slug,
			$this->_version,
			$this->_min_gravityforms_version,
			$this->_title,
			$this->_full_path,
			$this->_path,
			'https://gravityplus.pro/',
			$this->_url,
			$is_gravityforms_supported,
			array(
				'license'      => md5( $license_key ),
				'early_access' => $early_access
			) );


		parent::__construct();

	}

	/**
	 * @return GFP_Salesforce_Addon|null
	 */
	public static function get_instance() {

		if ( self::$_instance == null ) {

			self::$_instance = new self(
				array(
					'version'                    => GFP_SALESFORCE_CURRENT_VERSION,
					'min_gf_version'             => '2.2',
					'plugin_slug'                => GFP_SALESFORCE_SLUG,
					'path'                       => plugin_basename( GFP_SALESFORCE_FILE ),
					'full_path'                  => GFP_SALESFORCE_FILE,
					'title'                      => 'Gravity Forms Salesforce Add-On',
					'short_title'                => 'Salesforce',
					'url'                        => 'https://gravityplus.pro/gravity-forms-salesforce',
					'capabilities'               => array(
						'gravityforms_salesforce_plugin_settings',
						'gravityforms_salesforce_form_settings',
						'gravityforms_salesforce_uninstall'
					),
					'capabilities_settings_page' => array( 'gravityforms_salesforce_plugin_settings' ),
					'capabilities_form_settings' => array( 'gravityforms_salesforce_form_settings' ),
					'capabilities_uninstall'     => array( 'gravityforms_salesforce_uninstall' )
				)
			);

		}

		return self::$_instance;

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function pre_init() {

		parent::pre_init();

		add_action( 'parse_request', array( $this, 'parse_request' ) );

	}

	/**
	 * @see    GFAddOn::init
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function init() {

		parent::init();

		$this->add_delayed_payment_support(
			array(
				'option_label' => __( 'Take Salesforce action only when a payment is received.', 'gravityformssalesforce' )
			)
		);

		add_filter( 'gform_custom_merge_tags', array( $this, 'gform_custom_merge_tags' ), 10, 4 );

		add_filter( 'gform_replace_merge_tags', array( $this, 'gform_replace_merge_tags' ), 10, 7 );


		add_action( 'gform_after_submission', array( $this, 'gform_after_submission' ), 11, 2 );

		add_filter( 'gform_entry_detail_meta_boxes', array( $this, 'gform_entry_detail_meta_boxes' ), 10, 3 );

	}

	/**
	 * @see    GFAddOn::init_admin()
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function init_admin() {

		parent::init_admin();

		add_filter( 'gform_custom_merge_tags', array( $this, 'gform_custom_merge_tags_pdf' ), 11, 1 );
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $previous_version
	 */
	public function upgrade( $previous_version ) {

		do_action( "gform_{$this->_slug}_upgrade", $previous_version, $this );


		return;

	}

	public function plugin_settings_icon() {
		return '<i class="fa fa-cloud"></i>';
	}

	public function form_settings_icon() {
		return '<i class="fa fa-cloud"></i>';
	}

	/**
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return GFP_Salesforce_API|null
	 */
	public function get_salesforce_api() {

		if ( empty( $this->_gfp_salesforce_api ) ) {

			$settings = $this->get_plugin_settings();

			$this->_gfp_salesforce_api = new GFP_Salesforce_API( $settings[ 'instance' ], $settings[ 'sandbox' ], $settings[ 'client_id' ], $settings[ 'client_secret' ], $this->get_callback_url(), empty( $settings[ 'oauth_data' ] ) ? array() : $settings[ 'oauth_data' ] );

		}


		return $this->_gfp_salesforce_api;

	}

	/**
	 * @see    GFAddOn::plugin_settings_fields
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {

		$settings_fields = array();

		$settings_fields[] = array(
			'title'       => __( 'Updates and Support', 'gravityformssalesforce' ),
			'description' => sprintf( __( 'Enter your license key to receive updates and support for this plugin. If you don\'t have one, you can get one %shere%s.', 'gravityformssalesforce' ), '<a href="https://gravityplus.pro/gravity-forms-salesforce/">', '</a>' ),
			'fields'      => array(
				array(
					'name'              => 'license_key',
					'label'             => __( 'License Key', 'gravityformssalesforce' ),
					'type'              => 'text',
					'save_callback'     => array( $this, 'save_license_key' ),
					'feedback_callback' => array( $this, 'check_license_key' ),
				),
				array(
					'label'   => __( 'Get early access to new versions', 'gravityformssalesforce' ),
					'type'    => 'checkbox',
					'name'    => 'early_access_checkbox',
					'choices' => array(
						array(
							'name'          => 'early_access',
							'label'         => '',
							'default_value' => 1,
						)
					)
				)
			)
		);

		$settings_fields[] = array(
			'title'  => __( 'Step 1: Instance', 'gravityformssalesforce' ),
			'fields' => array(
				array(
					'name'              => 'instance',
					'label'             => __( 'Salesforce Instance Name', 'gravityformssalesforce' ),
					'tooltip'           => __( 'Name of your Salesforce instance. See your field guide for instructions on how to find.', 'gravityformssalesforce' ),
					'type'              => 'text',
					'placeholder'       => 'ns00',
					'required'          => true,
					'feedback_callback' => array( $this, 'check_instance_name' )
				),
				array(
					'name'    => 'sandbox_checkbox',
					'label'   => __( 'Sandbox?', 'gravityformssalesforce' ),
					'tooltip' => __( 'Is this a sandbox instance?', 'gravityformssalesforce' ),
					'type'    => 'checkbox',
					'choices' => array(
						array(
							'name'          => 'sandbox',
							'label'         => '',
							'default_value' => 0,
						)
					)
				)
			)
		);

		$settings_fields[] = array(
			'title'       => __( 'Step 2: Create application', 'gravityformssalesforce' ),
			'description' => $this->get_connected_app_instructions(),
			'fields'      => array(
				array(
					'name'     => 'client_id',
					'label'    => __( 'Consumer Key', 'gravityformssalesforce' ),
					'type'     => 'text',
					'required' => true
				),
				array(
					'name'     => 'client_secret',
					'label'    => __( 'Consumer Secret', 'gravityformssalesforce' ),
					'type'     => 'text',
					'required' => true
				),
				array(
					'type'  => 'save',
					'value' => __( 'Save Credentials', 'gravityformssalesforce' )
				)
			)
		);

		$settings_fields[] = array(
			'title'       => __( 'Step 3: Connect to Salesforce', 'gravityformssalesforce' ),
			'description' => $this->get_authentication_description(),
			'fields'      => array(
				array(
					'label' => 'hidden',
					'name'  => 'oauth_data',
					'type'  => 'hidden',
				)
			)
		);

		return $settings_fields;
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	private function get_connected_app_instructions() {

		ob_start();

		include( GFP_SALESFORCE_PATH . 'includes/views/plugin-settings-connected-app-instructions.php' );

		$connected_app_instructions = ob_get_contents();

		ob_end_clean();


		return $connected_app_instructions;
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	private function get_authentication_description() {

		$settings = $this->get_plugin_settings();

		$authenticate = false;

		if ( ! empty( $settings[ 'instance' ] ) && ! empty( $settings[ 'client_id' ] ) && ! empty( $settings[ 'client_secret' ] ) ) {

			if ( empty( $this->_gfp_salesforce_api ) ) {

				$this->_gfp_salesforce_api = new GFP_Salesforce_API( $settings[ 'instance' ], $settings[ 'sandbox' ], $settings[ 'client_id' ], $settings[ 'client_secret' ], $this->get_callback_url(), empty( $settings[ 'oauth_data' ] ) ? array() : $settings[ 'oauth_data' ] );

			}

			$valid_access_token = empty( $settings[ 'oauth_data' ] ) ? false : $this->_gfp_salesforce_api->validate_access_token();

			$valid_instance_name = $this->validate_instance_name( $settings[ 'instance' ] );


			$authenticate = ! $valid_instance_name || ! $valid_access_token;

		}

		if ( $authenticate ) {

			$this->log_debug( "Retrieving authorization URL" );

			$authorization_url = $this->_gfp_salesforce_api->get_authorization_url();

		}

		ob_start();

		include( trailingslashit( GFP_SALESFORCE_PATH ) . 'includes/views/plugin-settings-authentication.php' );

		$authentication_description = ob_get_contents();

		ob_end_clean();

		return $authentication_description;
	}

	/**
	 * Save license key
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 * @param $field_setting
	 *
	 * @return string
	 **/
	public function save_license_key( $field, $field_setting ) {

		if ( ! empty( $field_setting ) ) {

			$field_setting = trim( $field_setting );

		}


		return $field_setting;
	}

	/**
	 * Check license key
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $license_key
	 * @param $field
	 *
	 * @return bool
	 *             */
	public function check_license_key( $license_key, $field ) {

		if ( empty( $license_key ) ) {

			return false;

		} else {

			$version_info = $this->_auto_upgrader->get_version_info( $this->_slug, md5( trim( $license_key ) ), $this->_version, ( '1' == $this->get_plugin_setting( 'early_access' ) ) ? true : false, false );


			return ( isset( $version_info[ 'is_valid_key' ] ) ? $version_info[ 'is_valid_key' ] : false );

		}

	}

	/**
	 * Check instance name, after user has authenticated with Salesforce
	 *
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $instance_name
	 * @param $field
	 *
	 * @return bool
	 *
	 */
	public function check_instance_name( $instance_name, $field ) {

		if ( empty( $instance_name ) ) {

			return false;

		}

		$settings = $this->get_plugin_settings();

		if ( empty( $settings[ 'oauth_data' ] ) ) {

			return;
		}

		$valid_instance_name = $this->validate_instance_name( $instance_name );

		if ( $valid_instance_name ) {

			return true;
		}

		$settings[ 'instance' ] = $settings[ 'client_id' ] = $settings[ 'client_secret' ] = '';

		$this->update_plugin_settings( $settings );

		$this->set_field_error( $field, __( 'Instance name is incorrect. Please see field guide for instructions on how to find instance name', 'gravityformssalesforce' ) );

		return false;

	}

	/**
	 * Validate instance name
	 *
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $instance_name
	 *
	 * @return bool
	 *
	 */
	public function validate_instance_name( $instance_name ) {

		if ( empty( $instance_name ) ) {

			return false;

		}

		if ( empty( $this->_gfp_salesforce_api ) ) {

			$settings = $this->get_plugin_settings();

			$this->_gfp_salesforce_api = new GFP_Salesforce_API( $settings[ 'instance' ], $settings[ 'sandbox' ], $settings[ 'client_id' ], $settings[ 'client_secret' ], $this->get_callback_url(), empty( $settings[ 'oauth_data' ] ) ? array() : $settings[ 'oauth_data' ] );

		}

		$resources = $this->_gfp_salesforce_api->resources_by_version();

		if ( $resources[ 'success' ] && ! empty( $resources[ 'response' ][ 'sobjects' ] ) ) {

			return true;

		}

		return false;

	}

	/**
	 * @see    parent
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $settings
	 */
	public function update_plugin_settings( $settings ) {

		$previous_settings = $this->get_previous_settings();

		$this->log_debug( "Previous instance " . rgar( $previous_settings, 'instance' ) );
		$this->log_debug( "Current instance {$settings['instance']}" );
		$this->log_debug( "Previous client ID " . rgar( $previous_settings, 'client_id' ) );
		$this->log_debug( "Current client ID {$settings['client_id']}" );
		$this->log_debug( "Previous client secret " . rgar( $previous_settings, 'client_secret' ) );
		$this->log_debug( "Current client secret {$settings['client_secret']}" );

		if ( ( empty( $settings[ 'instance' ] ) || ( rgar( $previous_settings, 'instance' ) !== $settings[ 'instance' ] ) ) || ( rgar( $previous_settings, 'client_id' ) !== $settings[ 'client_id' ] ) || ( rgar( $previous_settings, 'client_secret' ) !== $settings[ 'client_secret' ] ) ) {

			$settings[ 'oauth_data' ] = $settings[ 'custom_fields' ] = array();

		}

		parent::update_plugin_settings( $settings );
	}

	/**
	 * Return URL to be used for OAuth
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	public function get_callback_url() {

		$url = defined( 'GRAVITYFORMSSALESFORCE_OAUTH_CALLBACK' ) && ! empty( GRAVITYFORMSSALESFORCE_OAUTH_CALLBACK ) ? GRAVITYFORMSSALESFORCE_OAUTH_CALLBACK : trailingslashit( home_url() );

		$callback_url = add_query_arg( 'callback', $this->_slug, $url );


		return $callback_url;
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function parse_request() {

		if ( rgget( 'callback' ) == $this->_slug ) {

			$this->do_authorization_callback();

		}

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	private function do_authorization_callback() {

		$this->log_debug( __METHOD__ );

		$settings = $this->get_plugin_settings();

		if ( empty( $this->_gfp_salesforce_api ) ) {

			$this->_gfp_salesforce_api = new GFP_Salesforce_API( $settings[ 'instance' ], $settings[ 'sandbox' ], $settings[ 'client_id' ], $settings[ 'client_secret' ], $this->get_callback_url(), empty( $settings[ 'oauth_data' ] ) ? array() : $settings[ 'oauth_data' ] );

		}

		$authorized = $this->_gfp_salesforce_api->finish_authorization();

		if ( $authorized ) {

			$this->log_debug( "Authorized." );

		}

		wp_redirect( $this->get_plugin_settings_url() );

		exit;

	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function render_uninstall() {

		do_action( "gform_{$this->_slug}_render_uninstall", $this );

		parent::render_uninstall();

	}

	/**
	 * @since  1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function scripts() {

		$scripts = array();

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET[ 'gform_debug' ] ) ? '' : '.min';


		if ( $this->is_form_settings( 'gravityformssalesforce' ) && '' !== rgget( 'fid' ) ) {

			$scripts[] =
				array(
					'handle'    => 'gfp_salesforce_admin',
					'src'       => GFP_SALESFORCE_URL . "includes/js/admin{$suffix}.js",
					'version'   => GFP_SALESFORCE_CURRENT_VERSION,
					'deps'      => array( 'jquery' ),
					'in_footer' => true,
					'enqueue'   => array(
						array(
							'admin_page' => array( 'form_settings' ),
							'tab'        => array( 'gravityformssalesforce' )
						),
					)
				);

		}


		return array_merge( parent::scripts(), $scripts );

	}

	/**
	 * @see    GFFeedAddOn::can_create_feed
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return bool
	 */
	public function can_create_feed() {

		$oauth_data = $this->get_plugin_setting( 'oauth_data' );


		return ! empty( $oauth_data );
	}

	/**
	 * @see    GFFeedAddOn::feed_list_message
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return bool | string
	 */
	public function feed_list_message() {

		$message = parent::feed_list_message();

		if ( $message !== false ) {

			return $message;

		}

		$oauth_data = $this->get_plugin_setting( 'oauth_data' );

		if ( empty( $oauth_data ) ) {

			$settings_label = __( 'Authorize your Salesforce Account', 'gravityformssalesforce' );

			$settings_link = sprintf( '<a href="%s">%s</a>', $this->get_plugin_settings_url(), $settings_label );

			return sprintf( __( 'To get started, please %s.', 'gravityformssalesforce' ), $settings_link );
		}

		return false;
	}

	/**
	 * @see    GFFeedAddOn::can_duplicate_feed
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array|int $id
	 *
	 * @return bool
	 */
	public function can_duplicate_feed( $id ) {

		return true;

	}

	/**
	 * @see    GFFeedAddOn::feed_list_columns
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function feed_list_columns() {

		return array(
			'feedName' => __( 'Name', 'gravityformssalesforce' ),
			'action'   => __( 'Action', 'gravityformssalesforce' ),
			'sobject'  => __( 'Salesforce Object', 'gravityformssalesforce' )
		);

	}

	/**
	 * Get value to display for the Salesforce action column, in the feed list
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $item
	 *
	 * @return string
	 */
	public function get_column_value_action( $item ) {

		$column_value = '';

		if ( isset( $item[ 'action' ] ) ) {

			$column_value = ucwords( $item[ 'action' ] );

		} elseif ( isset( $item[ 'meta' ][ 'action' ] ) ) {

			$column_value = ucwords( $item[ 'meta' ][ 'action' ] );

		}

		if ( empty( $column_value ) ) {

			$column_value = __( 'Create', 'gravityformssalesforce' );

		}


		return $column_value;
	}

	/**
	 * Get value to display for the Salesforce object column, in the feed list
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $item
	 *
	 * @return string
	 */
	public function get_column_value_sobject( $item ) {

		$column_value = '';

		$sobject_choices = $this->get_sobject_choices();

		foreach ( $sobject_choices as $object_choice ) {

			if ( $object_choice[ 'value' ] == $item[ 'meta' ][ 'sobject' ] ) {

				$column_value = $object_choice[ 'label' ];

				break;
			}

		}

		return $column_value;
	}

	/**
	 * @see    GFFeedAddOn::feed_settings_fields
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function feed_settings_fields() {

		$feed_field_name = array(
			'label'    => __( 'Name', 'gravityformssalesforce' ),
			'type'     => 'text',
			'name'     => 'feedName',
			'tooltip'  => __( 'Name for this feed', 'gravityformssalesforce' ),
			'class'    => 'medium',
			'required' => true
		);

		$feed_field_action = array(
			'label'         => __( 'Salesforce Action', 'gravityformssalesforce' ),
			'type'          => 'select',
			'name'          => 'action',
			'tooltip'       => __( 'Select the action you want to perform on a Salesforce object when someone submits this form', 'gravityformssalesforce' ),
			'choices'       => $this->get_action_choices(),
			'default_value' => 'create',
			'required'      => true,
			'onchange'      => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
		);

		$feed_field_sobject = array(
			'label'    => __( 'Salesforce Object', 'gravityformssalesforce' ),
			'type'     => 'select',
			'name'     => 'sobject',
			'tooltip'  => __( 'Select the Salesforce object you want to create or update when someone submits this form', 'gravityformssalesforce' ),
			'choices'  => $this->get_sobject_choices(),
			'onchange' => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
			'required' => true
		);

		$feed_field_sobject_id = array(
			'label'      => __( 'Existing Object ID', 'gravityformssalesforce' ),
			'type'       => 'field_select',
			'name'       => 'sobject_id',
			'tooltip'    => __( 'Select the field that holds the ID of the Salesforce object you want to update when someone submits this form', 'gravityformssalesforce' ),
			'required'   => true,
			'args' => array( 'append_choices' => $this->get_field_map_choices_other_feeds( rgget('id' ) ) ),
			'dependency' => array( 'field' => 'action', 'values' => array( 'update' ) )

		);

		$feed_field_delayed = array(
			'label'         => 'hidden',
			'name'          => 'delayed',
			'type'          => 'hidden',
			'default_value' => 0,
			'save_callback' => array( $this, 'save_feed_delayed_field' )
		);

		//TODO add delayed reason

		$fields_to_map = $this->get_fields_to_map();

		$feed_field_required_fields = array(
			'label'          => __( 'Required Fields', 'gravityformssalesforce' ),
			'type'           => 'field_map',
			'name'           => 'required_fields',
			'tooltip'        => __( 'Select the form field with the value for the Salesforce required field', 'gravityformssalesforce' ),
			'field_map'      => $fields_to_map[ 'required' ],
			'disable_custom' => true
		);

		$required_field_types_value = array();

		foreach ( $fields_to_map[ 'required' ] as $index => $field_info ) {

			$required_field_types_value[ $field_info[ 'name' ] ] = $field_info[ 'type' ];

		}

		$feed_field_required_field_types = array(
			'label' => 'hidden',
			'name'  => 'required_field_types',
			'type'  => 'hidden',
			'value' => $required_field_types_value
		);

		$feed_field_other_fields = array(
			'label'             => __( 'Other Fields', 'gravityformssalesforce' ),
			'type'              => 'generic_map',
			'name'              => 'other_fields',
			'tooltip'           => __( 'Select your Salesforce field name, then select the form field with the value for that field', 'gravityformssalesforce' ),
			'field_map'         => $fields_to_map[ 'other' ],
			'enable_custom_key' => false,
			'key_field'         => array(
				'title' => esc_html__( 'Salesforce Field', 'gravityformssalesforce' ),
			),
			'value_field'       => array(
				'choices'      => 'form_fields',
				'custom_value' => true,
			),
			'merge_tags'        => true,
			'save_callback'     => array( $this, 'save_feed_other_fields' )
		);

		$feed_field_conditional_logic = array(
			'name'    => 'conditionalLogic',
			'label'   => __( 'Conditional Logic', 'gravityformssalesforce' ),
			'type'    => 'feed_condition',
			'tooltip' => '<h6>' . __( 'Conditional Logic', 'gravityformssalesforce' ) . '</h6>' . __( 'When conditions are enabled, form submissions will only be sent to Salesforce when the conditions are met. When disabled, all form submissions will be sent to Salesforce.', 'gravityformssalesforce' )
		);

		$sections = array(
			array(
				'title'  => __( 'Feed Name', 'gravityformssalesforce' ),
				'fields' => array(
					$feed_field_name
				)
			),
			array(
				'title'  => __( 'Salesforce Action', 'gravityformssalesforce' ),
				'fields' => array(
					$feed_field_action
				)
			),
			array(
				'title'  => __( 'Salesforce Object', 'gravityformssalesforce' ),
				'fields' => array(
					$feed_field_sobject,
					$feed_field_sobject_id
				)
			),
			array(
				'title'      => __( 'Salesforce Fields', 'gravityformssalesforce' ),
				'dependency' => 'sobject',
				'fields'     => array(
					$feed_field_required_fields,
					$feed_field_required_field_types,
					$feed_field_other_fields,
					$feed_field_delayed
				)
			),
			array(
				'title'      => __( 'Conditional Logic', 'gravityformssalesforce' ),
				'dependency' => 'sobject',
				'fields'     => array(
					$feed_field_conditional_logic
				)
			)
		);

		return $sections;
	}

	/**
	 * @see    GFAddOn::field_map_title
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	public function field_map_title() {

		return __( 'Salesforce Field', 'gravityformssalesforce' );

	}

	/**
	 * Get action choices for Salesforce feed
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_action_choices() {

		$this->log_debug( __METHOD__ );

		$action_choices = array(
			array(
				'label' => __( 'Create', 'gravityformssalesforce' ),
				'value' => 'create'
			),
			array(
				'label' => __( 'Update', 'gravityformssalesforce' ),
				'value' => 'update'
			)
		);


		return $action_choices;

	}

	/**
	 * Get Salesforce objects to display in settings_select field
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_sobject_choices() {

		$this->log_debug( __METHOD__ );

		$object_choices = array(
			array(
				'label' => 'Select',
				'value' => ''
			)
		);

		$settings = $this->get_plugin_settings();

		if ( empty( $this->_gfp_salesforce_api ) ) {

			$this->_gfp_salesforce_api = new GFP_Salesforce_API( $settings[ 'instance' ], $settings[ 'sandbox' ], $settings[ 'client_id' ], $settings[ 'client_secret' ], $this->get_callback_url(), empty( $settings[ 'oauth_data' ] ) ? array() : $settings[ 'oauth_data' ] );

		}

		$sobjects = $this->_gfp_salesforce_api->describe_global();

		if ( $sobjects[ 'success' ] && ! empty( $sobjects[ 'response' ][ 'sobjects' ] ) ) {

			foreach ( $sobjects[ 'response' ][ 'sobjects' ] as $sobject ) {

				if ( $sobject[ 'createable' ] && ! $sobject[ 'deprecatedAndHidden' ] ) {

					$object_choices[] = array(
						'label' => $sobject[ 'label' ],
						'value' => $sobject[ 'name' ]
					);

				}

			}

			foreach ( $object_choices as $key => $row ) {

				$field_label[ $key ] = $row[ 'label' ];

				$field_name[ $key ] = $row[ 'value' ];

			}

			array_multisort( $field_label, SORT_ASC, $field_name, SORT_ASC, $object_choices );

		}

		return $object_choices;

	}

	/**
	 * Get fields for field mapping
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_fields_to_map() {

		$this->log_debug( __METHOD__ );

		$fields_to_map[ 'required' ] = array();

		$fields_to_map[ 'other' ] = array(
			array(
				'label' => 'Select',
				'value' => ''
			)
		);

		$settings = $this->get_plugin_settings();

		$sobject = $this->get_setting( 'sobject' );

		if ( ! empty( $sobject ) ) {

			if ( empty( $this->_gfp_salesforce_api ) ) {

				$this->_gfp_salesforce_api = new GFP_Salesforce_API( $settings[ 'instance' ], $settings[ 'sandbox' ], $settings[ 'client_id' ], $settings[ 'client_secret' ], $this->get_callback_url(), empty( $settings[ 'oauth_data' ] ) ? array() : $settings[ 'oauth_data' ] );

			}

			$sobject_description = $this->_gfp_salesforce_api->describe( $sobject );

			if ( $sobject_description[ 'success' ] && ! empty( $sobject_description[ 'response' ][ 'fields' ] ) ) {

				foreach ( $sobject_description[ 'response' ][ 'fields' ] as $field ) {

					if ( false !== strpos( $field[ 'name' ], 'Gravity_Forms_Feed_ID' ) ) {

						if ( empty( $settings[ 'custom_fields' ][ 'feed_id' ] ) ) {

							$settings[ 'custom_fields' ][ 'feed_id' ] = array(
								'label'   => $field[ 'label' ],
								'name'    => $field[ 'name' ],
								'objects' => array( $sobject )
							);

							parent::update_plugin_settings( $settings );
						} else if ( empty( $settings[ 'custom_fields' ][ 'feed_id' ][ 'objects' ] ) || ! in_array( $sobject, $settings[ 'custom_fields' ][ 'feed_id' ][ 'objects' ] ) ) {

							$settings[ 'custom_fields' ][ 'feed_id' ][ 'objects' ][] = $sobject;

							parent::update_plugin_settings( $settings );
						}

					} else if ( false !== strpos( $field[ 'name' ], 'Gravity_Forms_Entry_ID' ) ) {

						if ( empty( $settings[ 'custom_fields' ][ 'entry_id' ] ) ) {

							$settings[ 'custom_fields' ][ 'entry_id' ] = array(
								'label'   => $field[ 'label' ],
								'name'    => $field[ 'name' ],
								'objects' => array( $sobject )
							);

							parent::update_plugin_settings( $settings );

						} else if ( empty( $settings[ 'custom_fields' ][ 'entry_id' ][ 'objects' ] ) || ! in_array( $sobject, $settings[ 'custom_fields' ][ 'entry_id' ][ 'objects' ] ) ) {

							$settings[ 'custom_fields' ][ 'entry_id' ][ 'objects' ][] = $sobject;

							parent::update_plugin_settings( $settings );
						}

					} else if ( $field[ 'createable' ] && ! $field[ 'deprecatedAndHidden' ] && ! $field[ 'defaultedOnCreate' ] && ! $field[ 'nillable' ] ) {

						$fields_to_map[ 'required' ][] = array(
							'label'    => $field[ 'label' ],
							'name'     => $field[ 'name' ],
							'required' => true,
							'type'     => $field[ 'type' ]
						);

					} else if ( $field[ 'createable' ] && ! $field[ 'deprecatedAndHidden' ] ) {

						$fields_to_map[ 'other' ][] = array(
							'label' => $field[ 'label' ],
							'value' => $field[ 'name' ],
							'type'  => $field[ 'type' ]
						);

					}

				}

			}

		}

		foreach ( $fields_to_map[ 'other' ] as $key => $row ) {

			$field_label[ $key ] = $row[ 'label' ];

			$field_name[ $key ] = $row[ 'value' ];

		}

		array_multisort( $field_label, SORT_ASC, $field_name, SORT_ASC, $fields_to_map[ 'other' ] );


		return $fields_to_map;

	}

	/**
	 * @see       GFAddOn::get_field_map_choices
	 *
	 * @since     1.0.0
	 *
	 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param      $form_id
	 * @param null $field_type
	 * @param null $exclude_field_types
	 *
	 * @return array
	 */
	public static function get_field_map_choices( $form_id, $field_type = null, $exclude_field_types = null ) {

		global $gravityformssalesforce;

		$addon_object = $gravityformssalesforce->get_addon_object();


		$fields = parent::get_field_map_choices( $form_id, $field_type, $exclude_field_types );


		$other_feeds_field_map_choices = $addon_object->get_field_map_choices_other_feeds( $form_id );

		if ( ! empty( $other_feeds_field_map_choices ) ) {

			$fields = array_merge( $fields, $other_feeds_field_map_choices );

		}


		$pdf_field_map_choices = $addon_object->get_field_map_choices_pdfs( $form_id );

		if ( ! empty( $pdf_field_map_choices ) ) {

			$fields = array_merge( $fields, $pdf_field_map_choices );

		}


		return $fields;
	}

	/**
	 * Get other feeds to add to field map choices
	 *
	 * @since     1.5.0
	 *
	 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form_id
	 *
	 * @return array
	 */
	public function get_field_map_choices_other_feeds( $form_id ) {

		$other_feeds_choices = array();

		$feeds = $this->get_active_feeds( $form_id );

		foreach ( $feeds as $feed ) {

			if ( $feed[ 'id' ] == $this->get_current_feed_id() ) {

				continue;
			}

			if ( 'create' !== rgars( $feed, 'meta/action' ) ) {

				continue;
			}

			$sobject = rgars( $feed, 'meta/sobject' );

			if ( 'Attachment' == $sobject ) {

				continue;
			}

			$feed_name = rgars( $feed, 'meta/feedName' );

			$shortened_feed_name = substr( trim( $feed_name ), 0, 20 );

			$other_feeds_choices[] = array(
				'value' => "feed_{$feed['id']}",
				'label' => sprintf( __( ' %s Feed ', 'gravityformssalesforce' ), $shortened_feed_name ) . '(' . __( 'Created ID', 'gravityformssalesforce' ) . ')'
			);

		}

		return $other_feeds_choices;
	}

	/**
	 * Get GravityPDFs to add to field map choices
	 *
	 * @since     1.5.0
	 *
	 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form_id
	 *
	 * @return array
	 */
	public function get_field_map_choices_pdfs( $form_id ) {

		$pdf_field_map_choices = array();

		if ( method_exists( 'GPDFAPI', 'get_form_pdfs' ) ) {

			$pdfs = GPDFAPI::get_form_pdfs( $form_id );

			if ( ! is_wp_error( $pdfs ) && sizeof( $pdfs ) > 0 ) {

				foreach ( $pdfs as $pdf ) {

					$pdf_field_map_choices[] = array(
						'value' => "gfpdf_{$pdf['id']}",
						'label' => __( 'PDF', 'gravityformssalesforce' ) . ': ' . $pdf[ 'name' ]
					);

				}

				if ( 1 < count( $pdf_field_map_choices ) ) {

					array_unshift( $pdf_field_map_choices, array(
							'value' => "gfpdf_all",
							'label' => __( 'All PDFs', 'gravityformssalesforce' )
						)
					);
				}

			}

		}


		return $pdf_field_map_choices;

	}

	/**
	 * @see    GFAddOn::get_select_option
	 *
	 * @since  1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array  $choice
	 * @param string $selected_value
	 *
	 * @return string
	 */
	public function get_select_option( $choice, $selected_value ) {

		if ( is_array( $selected_value ) ) {

			$selected = in_array( $choice[ 'value' ], $selected_value ) ? "selected='selected'" : '';

		} else {

			$selected = selected( $selected_value, $choice[ 'value' ], false );

		}

		$data = empty( $choice[ 'type' ] ) ? '' : 'data-type="' . esc_attr( $choice[ 'type' ] ) . '"';


		return sprintf( '<option value="%1$s" %2$s %3$s>%4$s</option>', esc_attr( $choice[ 'value' ] ), $data, $selected, $choice[ 'label' ] );
	}

	/**
	 * Allow custom option in field map selects
	 *
	 * @see   GFAddOn::settings_field_map_select
	 *
	 * @since 1.5.0
	 *
	 * @param array $field
	 * @param int   $form_id
	 *
	 * @return string
	 */
	public function settings_field_map_select( $field, $form_id ) {

		$field_type = rgempty( 'field_type', $field ) ? null : $field[ 'field_type' ];

		$exclude_field_types = rgempty( 'exclude_field_types', $field ) ? null : $field[ 'exclude_field_types' ];

		$field[ 'choices' ] = $this->get_field_map_choices( $form_id, $field_type, $exclude_field_types );

		if ( empty( $field[ 'choices' ] ) || ( count( $field[ 'choices' ] ) == 1 && rgblank( $field[ 'choices' ][ 0 ][ 'value' ] ) ) ) {

			if ( ( ! is_array( $field_type ) && ! rgblank( $field_type ) ) || ( is_array( $field_type ) && count( $field_type ) == 1 ) ) {

				$type = is_array( $field_type ) ? $field_type[ 0 ] : $field_type;
				$type = ucfirst( GF_Fields::get( $type )->get_form_editor_field_title() );

				return sprintf( __( 'Please add a %s field to your form.', 'gravityforms' ), $type );

			}

		}

		$field[ 'default_value' ] = $this->get_default_field_select_field( $field );

		return $this->settings_select_custom( $field, false );

	}

	/**
	 * Modify parent to allow access to the generic map object
	 *
	 * Also update former dynamic_field_map feed settings to new format, for backwards compatibility
	 *
	 * @see    GFAddOn::settings_generic_map
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $field
	 * @param bool  $echo
	 *
	 * @return string
	 */
	public function settings_generic_map( $field, $echo = true ) {

		$feed = $this->get_current_feed();

		if ( ! empty( $feed[ 'meta' ][ 'other_fields' ] ) ) {

			$added_custom_value = false;

			foreach ( $feed[ 'meta' ][ 'other_fields' ] as $array_position => $other_field_data ) {

				if ( ! array_key_exists( 'custom_value', $other_field_data ) ) {

					$feed[ 'meta' ][ 'other_fields' ][ $array_position ][ 'custom_value' ] = '';

					$added_custom_value = true;
				}
			}

			if ( $added_custom_value ) {

				$this->update_feed_meta( $feed[ 'id' ], $feed[ 'meta' ] );

				$this->set_settings( $feed[ 'meta' ] );

			}

		}


		$html = parent::settings_generic_map( $field, false );


		$insert_before = 'jQuery( document )';

		$object_name_start = strpos( $html, 'var genericMap' );

		$object_name_end = strpos( $html, '= new GF' );

		$object_name = substr( $html, $object_name_start, $object_name_end - $object_name_start );

		$html = str_replace( 'var genericMap', 'genericMap', $html );

		$html = str_replace( $insert_before, "{$object_name}; {$insert_before}", $html );


		$html = str_replace( 'custom_value custom_value_{i}', 'custom_value custom_value_{i} mt-hide_all_fields mt-exclude-fileupload-repeater', $html );


		if ( $echo ) {

			echo $html;
		}


		return $html;
	}

	/**
	 * Modify custom merge tags
	 *
	 * @since 1.5.0
	 *
	 * @param $custom_tags
	 *
	 * @return mixed
	 */
	public function gform_custom_merge_tags_pdf( $custom_tags ) {

		if ( ! $this->is_detail_page() ) {

			return $custom_tags;
		}

		foreach ( $custom_tags as $index => $tag_info ) {

			if ( false !== strpos( $tag_info[ 'tag' ], ':pdf:' ) ) {

				unset( $custom_tags[ $index ] );

			}

		}


		return array_values( $custom_tags );
	}

	/**
	 * Save setting to delay feed if it's for an Attachment object that is sending GravityPDFs, or if it's chained to
	 * one
	 *
	 * In the future, this may need to be expanded to other objects
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 * @param $field_setting
	 *
	 * @return string
	 */
	public function save_feed_delayed_field( $field, $field_setting ) {

		$current_settings = $this->get_current_settings();

		if ( ( 'Attachment' == rgar( $current_settings, 'sobject' ) ) && $this->is_gravitypdf_mapped( $current_settings ) ) {

			$field_setting = '1';

			return $field_setting;
		}

		$attachment_feed_ids = $this->get_ids_of_attachment_feeds_with_pdfs( rgget( 'id' ) );

		foreach ( $current_settings as $settings_field => $value ) {

			if ( is_array( $value ) ) {

				continue;
			}

			if ( ( false !== strpos( $value, 'feed_' ) ) && in_array( str_replace( 'feed_', '', $value ), $attachment_feed_ids ) ) {

				$field_setting = '1';

				return $field_setting;

			}

		}


		return $field_setting;
	}

	/**
	 * Convert any single merge tag fields to mapped field instead of merge tag
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 * @param $field_setting
	 *
	 * @return mixed
	 */
	public function save_feed_other_fields( $field, $field_setting ) {

		foreach ( $field_setting as &$mapping ) {

			if ( ( 'gf_custom' == $mapping[ 'value' ] ) && ( 1 == substr_count( $mapping[ 'custom_value' ], '{' ) ) ) {

				preg_match_all( '/{[^{]*?:(\d+(\.\d+)?)(:(.*?))?}/mi', $mapping[ 'custom_value' ], $matches, PREG_SET_ORDER );

				if ( is_array( $matches ) ) {

					foreach ( $matches as $match ) {

						$input_id = $match[ 1 ];

						$field = RGFormsModel::get_field( $this->get_current_form(), $input_id );

						if ( $field ) {

							$mapping[ 'value' ] = $input_id;

							$mapping[ 'custom_value' ] = '';

						}

					}

				}

			}

		}


		return $field_setting;
	}

	/**
	 * Get Attachment object feed IDs
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form_id
	 *
	 * @return array
	 */
	private function get_ids_of_attachment_feeds_with_pdfs( $form_id ) {

		$attachment_feed_ids = array();

		$feeds = $this->get_feeds_by_slug( GFP_SALESFORCE_SLUG, $form_id );

		foreach ( $feeds as $feed ) {

			if ( ( 'Attachment' == rgars( $feed, 'meta/sobject' ) ) && $this->is_gravitypdf_mapped( $feed[ 'meta' ] ) ) {

				$attachment_feed_ids[] = $feed[ 'id' ];

			}

		}


		return $attachment_feed_ids;
	}

	/**
	 * Is one of this feed's field mappings for GravityPDF
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $settings
	 *
	 * @return bool
	 */
	private function is_gravitypdf_mapped( $settings ) {

		foreach ( $settings as $field => $mapped_value ) {

			if ( is_array( $mapped_value ) ) {

				continue;
			}

			if ( false !== strpos( $mapped_value, 'gfpdf_' ) ) {

				return true;

			}

		}

		return false;
	}

	/**
	 * Determines whether or not to process feeds for this form submission
	 *
	 * @see    parent
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $entry The Entry Object currently being processed.
	 * @param array $form  The Form Object currently being processed.
	 *
	 * @return array $entry
	 */
	public function maybe_process_feed( $entry, $form ) {

		if ( 'spam' === $entry[ 'status' ] ) {

			$this->log_debug( __METHOD__ . ": Entry #{$entry['id']} is marked as spam; not processing feeds for {$this->_slug}." );


			return $entry;
		}

		$this->log_debug( __METHOD__ . "(): Checking for feeds to process for entry #{$entry['id']} for {$this->_slug}." );

		$feeds = $this->get_feeds( $form[ 'id' ] );

		$feeds = $this->pre_process_feeds( $feeds, $entry, $form );

		if ( empty( $feeds ) ) {

			$this->log_debug( __METHOD__ . "(): No feeds to process for entry #{$entry['id']}." );

			return $entry;
		}

		$is_delayed = $this->maybe_delay_feed( $entry, $form );

		$processed_feeds = $delayed_feeds = array();


		foreach ( $feeds as $feed ) {

			$feed_name = rgempty( 'feed_name', $feed[ 'meta' ] ) ? rgar( $feed[ 'meta' ], 'feedName' ) : rgar( $feed[ 'meta' ], 'feed_name' );

			if ( ! $feed[ 'is_active' ] ) {

				$this->log_debug( __METHOD__ . ": Feed is inactive, not processing feed (#{$feed['id']} - {$feed_name}) for entry #{$entry['id']}." );

				continue;
			}

			if ( ! $this->is_feed_condition_met( $feed, $form, $entry ) ) {

				$this->log_debug( __METHOD__ . ": Feed condition not met, not processing feed (#{$feed['id']} - {$feed_name}) for entry #{$entry['id']}." );

				continue;
			}

			if ( $is_delayed ) {

				$this->log_debug( __METHOD__ . ': Feed processing is delayed, not processing ' . $this->_slug . ' feeds for entry #' . $entry[ 'id' ] );

				$this->delay_feed( $feed, $entry, $form );

				continue;


			}

			$feed_is_delayed = $this->maybe_delay_individual_feed( $entry, $form, $feed );

			if ( $feed_is_delayed ) {

				$this->log_debug( __METHOD__ . ": Feed processing is delayed, not processing (#{$feed['id']} - {$feed_name}) for entry #{$entry['id']}." );

				$this->delay_individual_feed( $feed, $entry, $form );

				$delayed_feeds[] = $feed[ 'id' ];

				continue;


			}

			$entry = $this->do_process_feed( $feed, $entry, $form );


			$this->log_debug( __METHOD__ . ': Marking entry #' . $entry[ 'id' ] . ' as fulfilled for ' . $this->_slug );

			gform_update_meta( $entry[ 'id' ], "{$this->_slug}_is_fulfilled", true );

			$processed_feeds[] = $feed[ 'id' ];

		}

		if ( ! empty( $processed_feeds ) ) {

			$this->update_processed_feeds_meta( $entry, $processed_feeds, 'processed_feeds' );

		}


		if ( ! empty( $delayed_feeds ) ) {

			$this->update_processed_feeds_meta( $entry, $delayed_feeds, 'delayed_feeds' );


		}


		return $entry;

	}

	/**
	 * Begin feed processing actions
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $feed
	 * @param $entry
	 * @param $form
	 *
	 * @return array|null|void
	 */
	public function do_process_feed( $feed, $entry, $form ) {

		$feed_name = rgar( $feed[ 'meta' ], 'feedName' );

		$this->log_debug( __METHOD__ . ": Starting to process feed (#{$feed['id']} - {$feed_name}) for entry #{$entry['id']} for {$this->_slug}" );

		$returned_entry = $this->process_feed( $feed, $entry, $form );

		if ( is_array( $returned_entry ) && rgar( $returned_entry, 'id' ) ) {

			$entry = $returned_entry;

		}

		do_action( 'gform_post_process_feed', $feed, $entry, $form, $this );

		do_action( "gform_{$this->_slug}_post_process_feed", $feed, $entry, $form, $this );


		return $entry;
	}

	/**
	 * Whether or not to delay an individual feed
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $entry
	 * @param $form
	 * @param $feed
	 *
	 * @return bool|mixed|void
	 */
	public function maybe_delay_individual_feed( $entry, $form, $feed ) {

		if ( $this->_bypass_individual_feed_delay ) {

			return false;

		}

		$is_delayed = false;

		if ( '1' == rgars( $feed, 'meta/delayed' ) ) {

			$is_delayed = true;

		}

		/**
		 * Allow individual feed processing to be delayed.
		 *
		 * @param bool   $is_delayed Is feed processing delayed?
		 * @param array  $form       The Form Object currently being processed.
		 * @param array  $entry      The Entry Object currently being processed.
		 * @param string $slug       The Add-On slug e.g. gravityformsmailchimp
		 * @param array  $feed       The Feed Object currently being processed.
		 */
		$is_delayed = apply_filters( 'gform_is_delayed_pre_process_individual_feed', $is_delayed, $form, $entry, $this->get_slug(), $feed );
		$is_delayed = apply_filters( 'gform_is_delayed_pre_process_individual_feed_' . $form[ 'id' ], $is_delayed, $form, $entry, $this->get_slug(), $feed );


		return $is_delayed;
	}

	public function delay_individual_feed( $feed, $entry, $form ) {

		return;
	}

	/**
	 * Update entry meta
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $entry
	 * @param $processed_feeds
	 * @param $type
	 */
	public function update_processed_feeds_meta( $entry, $processed_feeds, $type ) {

		$meta = gform_get_meta( $entry[ 'id' ], $type );

		if ( empty( $meta ) ) {

			$meta = array();

		}

		$meta[ $this->_slug ] = $processed_feeds;

		gform_update_meta( $entry[ 'id' ], $type, $meta );

	}

	/**
	 * Formats field values for Salesforce
	 *
	 * @see    parent
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array  $form
	 * @param array  $entry
	 * @param string $field_id
	 * @param array  $addl
	 *
	 * @return mixed|null|string
	 */
	public function get_field_value( $form, $entry, $field_id, $addl = array() ) {

		if ( ! $this->_processing_feed ) {

			return parent::get_field_value( $form, $entry, $field_id );
		}

		if ( 'date_created' == strtolower( $field_id ) ) {

			$date_created = new DateTime( rgar( $entry, strtolower( $field_id ) ) );

			$field_value = $date_created->format( 'Y-m-d' );

			$field_value = gf_apply_filters( array(
				'gform_addon_field_value',
				$form[ 'id' ],
				$field_id
			), $field_value, $form, $entry, $field_id, $this->_slug );

			$field_value = $this->maybe_override_field_value( $field_value, $form, $entry, $field_id );


			return $field_value;

		}

		if ( false !== strpos( $field_id, 'feed_' ) ) {

			if ( ( ! empty( $this->_created_objects ) && array_key_exists( $field_id, $this->_created_objects ) ) ) {

				$field_value = rgar( $this->_created_objects, $field_id );

			} else {

				$salesforce_meta = gform_get_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject' );

				foreach ( $salesforce_meta as $object_key => $object_id ) {

					$feed_id = substr( $object_key, strrpos( $object_key, '_' ) + 1 );

					if ( "feed_{$feed_id}" == $field_id ) {

						return $object_id;
					}

				}
			}


			return $field_value;
		}

		if ( false !== strpos( $field_id, 'gfpdf_' ) ) {

			$pdf_id = str_replace( 'gfpdf_', '', $field_id );

			if ( 'all' == $pdf_id ) {

				$field_value = array();

				if ( method_exists( 'GPDFAPI', 'get_pdf_class' ) ) {

					/**
					 * @var $pdf_display_model \GFPDF\Model\Model_PDF
					 */
					$pdf_display_model = GPDFAPI::get_pdf_class( 'model' );

					$active_pdfs = $pdf_display_model->get_active_pdfs( $form[ 'gfpdf_form_settings' ], $entry );

					if ( 0 < count( $active_pdfs ) ) {

						foreach ( $active_pdfs as $pdf ) {

							if ( 'base64' == $addl[ 'type' ] ) {

								$pdf_path = GPDFAPI::create_pdf( $entry[ 'id' ], $pdf[ 'id' ] );

								if ( is_wp_error( $pdf_path ) ) {

									$this->log_debug( print_r( $pdf_path ) );

									continue;
								}

								$field_value[] = base64_encode( file_get_contents( $pdf_path ) );

							} else if ( 'string' == $addl[ 'type' ] ) {

								$field_value[] = $pdf[ 'name' ];

							}

						}

					}
				}

				if ( 1 == count( $field_value ) ) {

					$field_value = $field_value[ 0 ];

				}

			} else {

				if ( method_exists( 'GPDFAPI', 'create_pdf' ) ) {

					$pdf = GPDFAPI::get_pdf( $form[ 'id' ], $pdf_id );

					if ( 'base64' == $addl[ 'type' ] ) {

						$pdf_path = GPDFAPI::create_pdf( $entry[ 'id' ], $pdf[ 'id' ] );

						if ( ! is_wp_error( $pdf_path ) ) {

							$field_value = base64_encode( file_get_contents( $pdf_path ) );

						}

					} else if ( 'string' == $addl[ 'type' ] ) {

						$field_value = $pdf[ 'name' ];

					}

					return $field_value;

				}
			}


			return $field_value;
		}


		$field_value = parent::get_field_value( $form, $entry, $field_id );

		if ( empty( $addl[ 'type' ] ) ) {

			return $field_value;
		}


		return $this->format_field_value_for_sf( $form, $field_id, $field_value, $addl[ 'type' ] );

	}

	/**
	 * Format field value for Salesforce
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form
	 * @param $field_id
	 * @param $field_value
	 * @param $sf_field_type
	 *
	 * @return array|mixed|string
	 */
	private function format_field_value_for_sf( $form, $field_id, $field_value, $sf_field_type ) {

		$field = GFAPI::get_field( $form, $field_id );

		if ( ( 'multipicklist' == $sf_field_type ) && 'multiselect' == $field->type || 'checkbox' == $field->type ) {

			$field_value = str_replace( ',', ';', $field_value );


			return $field_value;

		}

		if ( 'fileupload' == $field->type ) {

			if ( ! $field->multipleFiles ) {

				if ( 'base64' == $sf_field_type ) {

					$field_value = base64_encode( file_get_contents( $field_value ) );

				} else if ( 'string' == $sf_field_type ) {

					$field_value = ( file_get_contents( $field_value ) ) ? basename( $field_value ) : $field_value;

				}

				return $field_value;

			}

			$file_urls = explode( ',', $field_value );

			$field_value = array();

			foreach ( $file_urls as $file_url ) {

				if ( 'base64' == $sf_field_type ) {

					$field_value[] = base64_encode( file_get_contents( trim( $file_url ) ) );

				} else if ( 'string' == $sf_field_type ) {

					$field_value[] = ( file_get_contents( trim( $file_url ) ) ) ? basename( $file_url ) : $file_url;

				}

			}

			if ( 1 == count( $field_value ) ) {

				$field_value = $field_value[ 0 ];

			}


			return $field_value;

		}

		if ( ( 'time' == $sf_field_type ) && ( 'time' == $field->type ) ){

			$time = new DateTime( $field_value );

			$field_value = $time->format( 'H:i:s.v' );


			return $field_value;
		}


		return $field_value;
	}

	/**
	 * @see    GFFeedAddOn::process_feed
	 *
	 * Performs the Salesforce action when the form is submitted
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $feed
	 * @param $entry
	 * @param $form
	 */
	public function process_feed( $feed, $entry, $form ) {

		$this->log_debug( __METHOD__ );

		$this->_processing_feed = true;

		$settings = $this->get_plugin_settings();

		if ( empty( $this->_gfp_salesforce_api ) ) {

			$this->_gfp_salesforce_api = new GFP_Salesforce_API( $settings[ 'instance' ], $settings[ 'sandbox' ], $settings[ 'client_id' ], $settings[ 'client_secret' ], $this->get_callback_url(), empty( $settings[ 'oauth_data' ] ) ? array() : $settings[ 'oauth_data' ] );

		}

		$sobject = (string) $this->get_setting( 'sobject', '', $feed[ 'meta' ] );

		$action = $this->get_setting( 'action', 'create', $feed[ 'meta' ] );


		$required_field_data = array();

		$required_fields = $this->get_field_map_fields( $feed, 'required_fields' );

		$skip = '';

		foreach ( $required_fields as $name => $value ) {

			if ( $skip == $name ) {

				continue;
			}

			$required_field_data[ $name ] = $this->get_mapped_field_value( "required_fields_{$name}", $form, $entry, $feed[ 'meta' ] );

			$skip = "{$name}_custom";
		}

		//$other_field_data = $this->get_dynamic_field_map_values( 'other_fields', $feed, $entry, $form )
		$other_field_data = $this->get_generic_map_fields( $feed, 'other_fields', $form, $entry );

		$field_data = array_merge( $required_field_data, $other_field_data );

		if ( 'create' == $action && ! empty( $settings[ 'custom_fields' ][ 'entry_id' ][ 'name' ] ) && in_array( $sobject, $settings[ 'custom_fields' ][ 'entry_id' ][ 'objects' ] ) ) {

			$field_data[ $settings[ 'custom_fields' ][ 'entry_id' ][ 'name' ] ] = $entry[ 'id' ];

		}

		if ( 'create' == $action && ! empty( $settings[ 'custom_fields' ][ 'feed_id' ][ 'name' ] ) && in_array( $sobject, $settings[ 'custom_fields' ][ 'feed_id' ][ 'objects' ] ) ) {

			$field_data[ $settings[ 'custom_fields' ][ 'feed_id' ][ 'name' ] ] = $feed[ 'id' ];

		}

		$field_data = apply_filters( 'gravityformssalesforce_process_feed_field_data', $field_data, $feed, $entry, $form );

		foreach ( $field_data as $field_name => $value ) {

			if ( ( empty( $value ) ) && ( '0' !== $value ) ) {

				unset( $field_data[ $field_name ] );

			}

		}


		if ( 'update' == $action ) {

			$existing_object_id = $this->get_field_value( $form, $entry, $this->get_setting( 'sobject_id', '', $feed[ 'meta' ] ) );

		}


		$current_meta = gform_get_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject' );

		$saved_object_id = rgar( $current_meta, "{$sobject}_{$feed['id']}" );

		$saved_object_id = empty( $saved_object_id ) ? rgar( $current_meta, $sobject ) : $saved_object_id;

		if ( ( ! empty( $saved_object_id ) || ( 'update' == $action && ! empty( $existing_object_id ) ) ) ) {

			$object_to_update = empty( $saved_object_id ) ? $existing_object_id : $saved_object_id;

			$this->salesforce_response[ "feed_{$feed['id']}" ] = $this->_gfp_salesforce_api->update_record( $sobject, $object_to_update, $field_data );

		} else {

			if ( 'Attachment' == $sobject && is_array( $field_data[ 'Body' ] ) ) {

				$composite_field_data = array( 'records' => array() );

				$files = $field_data[ 'Body' ];

				$file_names = $field_data[ 'Name' ];

				unset( $field_data[ 'Body' ], $field_data[ 'Name' ] );


				foreach ( $files as $index => $file ) {

					$composite_field_data[ 'records' ][] = array_merge(
						array(
							'attributes' => array( 'type' => $sobject, 'referenceId' => trim( $file_names[ $index ] ) ),
							'Name'       => $file_names[ $index ],
							'Body'       => $file
						),
						$field_data
					);

				}

				$this->salesforce_response[ "feed_{$feed['id']}" ] = $new_record = $this->_gfp_salesforce_api->create_composite_record( $sobject, $composite_field_data, array() );

				if ( $new_record[ 'success' ] && ! empty( $new_record[ 'response' ] ) && ! $new_record[ 'response' ][ 'hasErrors' ] ) {

					$created_object_ids = array();

					foreach ( $new_record[ 'response' ][ 'results' ] as $result ) {

						$created_object_ids[ $result[ 'referenceId' ] ] = $result[ 'id' ];

					}

					$current_meta = gform_get_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject' );

					if ( $current_meta ) {

						$current_meta[ "{$sobject}_{$feed['id']}" ] = $created_object_ids;

					} else {

						$current_meta = array( "{$sobject}_{$feed['id']}" => $created_object_ids );

					}

					$this->_created_objects[ "feed_{$feed['id']}" ] = $created_object_ids;

					gform_update_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject', $current_meta, $form[ 'id' ] );

				}

			} else {

				$this->salesforce_response[ "feed_{$feed['id']}" ] = $new_record = $this->_gfp_salesforce_api->create_record( $sobject, $field_data, array() );

				if ( $new_record[ 'success' ] && ! empty( $new_record[ 'response' ] ) ) {

					$created_object_id = $new_record[ 'response' ][ 'id' ];

					$current_meta = gform_get_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject' );

					if ( $current_meta ) {

						$current_meta[ "{$sobject}_{$feed['id']}" ] = $created_object_id;

					} else {

						$current_meta = array( "{$sobject}_{$feed['id']}" => $created_object_id );

					}

					$this->_created_objects[ "feed_{$feed['id']}" ] = $created_object_id;

					gform_update_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject', $current_meta, $form[ 'id' ] );

				}

			}

		}

		$this->_processing_feed = false;

	}

	/**
	 * Modify parent to get field value using the SF field type, for required fields
	 *
	 * TODO do we need to pass custom value through get_field_value filter or allow merge tags later?
	 *
	 * @see    parent
	 *
	 * @since  1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param string $setting_name
	 * @param array  $form
	 * @param array  $entry
	 * @param bool   $settings
	 *
	 * @return mixed|null|string
	 */
	public function get_mapped_field_value( $setting_name, $form, $entry, $settings = false ) {

		if ( ! $this->_processing_feed || 'required_fields_' !== substr( $setting_name, 0, strlen( 'required_fields_' ) ) ) {

			return parent::get_mapped_field_value( $setting_name, $form, $entry, $settings = false );
		}

		$field_id = $this->get_setting( $setting_name, '', $settings );

		if ( 'gf_custom' == $field_id ) {

			return $this->get_setting( "{$setting_name}_custom", '', $settings );

		}

		$sf_field_type = rgar( $this->get_setting( 'required_field_types', array(), $settings ), str_replace( 'required_fields_', '', $setting_name ) );

		return $this->get_field_value( $form, $entry, $field_id, array(
			'type'    => $sf_field_type,
			'sobject' => (string) $this->get_setting( 'sobject', '', $settings )
		) );
	}

	/**
	 * Modify parent to send SF field type to get_field_value
	 *
	 * @see   parent
	 *
	 * @since 1.5.0
	 *
	 * @param array  $feed
	 * @param string $field_name
	 * @param array  $form
	 * @param array  $entry
	 *
	 * @return array
	 */
	public function get_generic_map_fields( $feed, $field_name, $form = array(), $entry = array() ) {

		$fields = array();

		$generic_fields = rgar( $feed, 'meta' ) ? rgars( $feed, 'meta/' . $field_name ) : rgar( $feed, $field_name );

		if ( ! empty( $generic_fields ) ) {

			foreach ( $generic_fields as $generic_field ) {

				$field_key = $generic_field[ 'key' ];

				if ( 'gf_custom' === $generic_field[ 'value' ] ) {

					$field_value = empty( $form ) ? $generic_field[ 'custom_value' ] : $this->replace_variables( $generic_field[ 'custom_value' ], $form, $entry, false, false, false, 'text' );

				} else {

					$field_value = empty( $form ) ? $generic_field[ 'value' ] : $this->get_field_value( $form, $entry, $generic_field[ 'value' ], array( 'type' => $generic_field[ 'type' ] ) );

				}

				$fields[ $field_key ] = $field_value;

			}

		}

		return $fields;

	}

	/**
	 * Get field values from entry, for a dynamic field map
	 *
	 * TODO Note: this doesn't work for image or signature fields
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field_name
	 * @param $feed
	 * @param $entry
	 * @param $form
	 *
	 * @return array
	 */
	private function get_dynamic_field_map_values( $field_name, $feed, $entry, $form ) {

		$field_map_values = array();


		$field_map_field_ids = $this->get_dynamic_field_map_fields( $feed, $field_name );


		foreach ( $field_map_field_ids as $name => $field_info ) {

			$field_map_values[ $name ] = $this->get_field_value( $form, $entry, $field_info[ 'value' ], array( 'type' => $field_info[ 'type' ] ) );

		}


		return $field_map_values;

	}

	/**
	 * This implementation may change in the future. Do not use.
	 *
	 * Overriding parent because need to get all dynamic field info and not just the value
	 *
	 * @see    GFAddOn::get_dynamic_field_map_fields
	 *
	 * @since  1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array  $feed       Feed object.
	 * @param string $field_name Dynamic field map field name.
	 *
	 * @return array
	 */
	public static function get_dynamic_field_map_fields( $feed, $field_name ) {

		$fields = array();

		$dynamic_fields = rgars( $feed, 'meta/' . $field_name );

		if ( ! empty( $dynamic_fields ) ) {

			foreach ( $dynamic_fields as $dynamic_field ) {

				$field_key = 'gf_custom' === $dynamic_field[ 'key' ] ? $dynamic_field[ 'custom_key' ] : $dynamic_field[ 'key' ];

				$fields[ $field_key ] = $dynamic_field;

			}

		}


		return $fields;

	}

	/**
	 * A modified version of GFCommon::replace_variables that allows us to only process the tags we want
	 * and handle any additional formatting
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param        $text
	 * @param        $form
	 * @param        $lead
	 * @param bool   $url_encode
	 * @param bool   $esc_html
	 * @param bool   $nl2br
	 * @param string $format
	 * @param array  $aux_data
	 *
	 * @return mixed|string
	 */
	private function replace_variables( $text, $form, $lead, $url_encode = false, $esc_html = true, $nl2br = true, $format = 'html', $aux_data = array() ) {

		$data = array_merge( array( 'entry' => $lead ), $aux_data );

		$data = apply_filters( 'gform_merge_tag_data', $data, $text, $form, $lead );

		$lead = $data[ 'entry' ];

		$text = $format == 'html' && $nl2br ? nl2br( $text ) : $text;
		$text = apply_filters( 'gform_pre_replace_merge_tags', $text, $form, $lead, $url_encode, $esc_html, $nl2br, $format );

		if ( strpos( $text, '{' ) === false ) {

			return $text;

		}

		$aux_tags = array_keys( $data );
		$pattern  = sprintf( '/{(%s):(.+?)}/', implode( '|', $aux_tags ) );

		preg_match_all( $pattern, $text, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {

			list( $search, $tag, $prop ) = $match;

			if ( is_callable( $data[ $tag ] ) ) {
				$data[ $tag ] = call_user_func( $data[ $tag ], $lead, $form );
			}

			$object  = $data[ $tag ];
			$replace = rgars( $object, $prop );

			$text = str_replace( $search, $replace, $text );

		}

		// Replacing field variables: {FIELD_LABEL:FIELD_ID} {My Field:2}.
		preg_match_all( '/{[^{]*?:(\d+(\.\d+)?)(:(.*?))?}/mi', $text, $matches, PREG_SET_ORDER );

		if ( is_array( $matches ) ) {

			foreach ( $matches as $match ) {

				$input_id = $match[ 1 ];

				$text = GFCommon::replace_field_variable( $text, $form, $lead, $url_encode, $esc_html, $nl2br, $format, $input_id, $match );

			}

		}

		$text = str_replace( '{form_title}', $url_encode ? urlencode( rgar( $form, 'title' ) ) : rgar( $form, 'title' ), $text );

		$text = str_replace( '{form_id}', $url_encode ? urlencode( rgar( $form, 'id' ) ) : rgar( $form, 'id' ), $text );

		$text = str_replace( '{entry_id}', $url_encode ? urlencode( rgar( $lead, 'id' ) ) : rgar( $lead, 'id' ), $text );

		$entry_url = get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=gf_entries&view=entry&id=' . rgar( $form, 'id' ) . '&lid=' . rgar( $lead, 'id' );

		$entry_url = esc_url( apply_filters( 'gform_entry_detail_url', $entry_url, $form, $lead ) );
		$text      = str_replace( '{entry_url}', $url_encode ? urlencode( $entry_url ) : $entry_url, $text );

		$text = str_replace( '{post_id}', $url_encode ? urlencode( rgar( $lead, 'post_id' ) ) : rgar( $lead, 'post_id' ), $text );

		$wp_email = get_bloginfo( 'admin_email' );
		$text     = str_replace( '{admin_email}', $url_encode ? urlencode( $wp_email ) : $wp_email, $text );

		$text = str_replace( '{admin_url}', $url_encode ? urlencode( admin_url() ) : admin_url(), $text );

		$text = str_replace( '{logout_url}', $url_encode ? urlencode( wp_logout_url() ) : wp_logout_url(), $text );

		$post_url = get_bloginfo( 'wpurl' ) . '/wp-admin/post.php?action=edit&post=' . rgar( $lead, 'post_id' );
		$text     = str_replace( '{post_edit_url}', $url_encode ? urlencode( $post_url ) : $post_url, $text );

		$text = GFCommon::replace_variables_prepopulate( $text, $url_encode, $lead, $esc_html, $form, $nl2br, $format );

		$text = GFCommon::decode_merge_tag( $text );


		return $text;
	}

	/**
	 * Initiates GravityPDF processing
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $entry
	 * @param $form
	 */
	public function gform_after_submission( $entry, $form ) {

		$this->process_feeds_with_pdfs( $entry, $form );

	}

	/**
	 * Process feeds that were delayed, waiting for PDFs to be generated
	 *
	 * While we can always create a PDF, waiting until after notifications are sent
	 * will hopefully cut down on unnecessary processing
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $entry
	 * @param $form
	 */
	public function process_feeds_with_pdfs( $entry, $form ) {

		$this->log_debug( __METHOD__ );

		$delayed = gform_get_meta( $entry[ 'id' ], 'delayed_feeds' );

		if ( empty( $delayed ) || empty( $delayed[ $this->_slug ] ) ) {

			$this->log_debug( 'There were no delayed feeds to process' );

			return;
		}

		$delayed_feeds = $delayed[ $this->_slug ];

		$processed = gform_get_meta( $entry[ 'id' ], 'processed_feeds' );

		$processed_feeds = empty( $processed[ $this->_slug ] ) ? array() : $processed[ $this->_slug ];


		$this->_bypass_individual_feed_delay = true;

		foreach ( $delayed_feeds as $index => $feed_id ) {

			if ( in_array( $feed_id, $processed_feeds ) ) {

				$this->log_debug( __METHOD__ . ": Feed #{$feed_id} is already processed. No action necessary." );

				unset( $delayed_feeds[ $index ] );


				continue;

			}

			$this->do_process_feed( $this->get_feed( $feed_id ), $entry, $form );

			unset( $delayed_feeds[ $index ] );

			$processed_feeds[] = $feed_id;


			$this->log_debug( __METHOD__ . ': Marking entry #' . $entry[ 'id' ] . ' as fulfilled for ' . $this->_slug );

			gform_update_meta( $entry[ 'id' ], "{$this->_slug}_is_fulfilled", true );

		}

		if ( ! empty( $processed_feeds ) ) {

			$this->update_processed_feeds_meta( $entry, $processed_feeds, 'processed_feeds' );

		}

		$this->update_processed_feeds_meta( $entry, $delayed_feeds, 'delayed_feeds' );

	}

	/**
	 * Add merge tags for Salesforce record IDs
	 *
	 * @since  1.6.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $merge_tags
	 * @param $form_id
	 * @param $fields
	 * @param $element_id
	 *
	 * @return array
	 */
	public function gform_custom_merge_tags( $merge_tags, $form_id, $fields, $element_id ) {

		if ( ! GFP_Salesforce_Addon::get_instance()->has_feed( $form_id ) ) {

			return $merge_tags;

		}

		if ( 'form_editor' == GFForms::get_page() ) {

			return $merge_tags;

		}

		if ( $this->_slug == rgget( 'subview' ) ) {

			return $merge_tags;
		}

		$current_feed_id = $this->get_current_feed_id();

		foreach ( $this->get_active_feeds( $form_id ) as $feed ) {

			if ( $feed[ 'id' ] == $current_feed_id ) {

				continue;
			}

			if ( 'create' !== rgars( $feed, 'meta/action' ) ) {

				continue;
			}

			$sobject = rgars( $feed, 'meta/sobject' );

			if ( 'Attachment' == $sobject ) {

				continue;
			}

			$merge_tags[] = array( 'tag'   => "{salesforce:{$sobject}_{$feed['id']}}",
			                       'label' => sprintf( __( 'Salesforce Record ID: %s', 'gravityformssalesforce' ), $sobject )
			);

		}


		return $merge_tags;
	}

	/**
	 * Replace merge tags
	 *
	 * @since  1.6.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $text
	 * @param $form
	 * @param $entry
	 * @param $url_encode
	 * @param $esc_html
	 * @param $nl2br
	 * @param $format
	 *
	 * @return mixed
	 */
	public function gform_replace_merge_tags( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {

		if ( empty( $entry ) || empty( $form ) ) {

			return $text;

		}

		preg_match_all( "/\{salesforce:(.*?)\}/", $text, $matches, PREG_SET_ORDER );

		if ( empty( $matches ) ) {

			return $text;
		}

		$salesforce_meta = gform_get_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject' );

		foreach ( $matches as $match ) {

			$full_tag = $match[ 0 ];

			$meta_key = $match[ 1 ];

			$record_id = rgar( $salesforce_meta, $meta_key );

			$text = str_replace( $full_tag, $record_id, $text );
		}


		return $text;
	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $meta_boxes
	 * @param $entry
	 * @param $form
	 *
	 * @return mixed
	 */
	public function gform_entry_detail_meta_boxes( $meta_boxes, $entry, $form ) {

		$salesforce_meta = gform_get_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject' );

		if ( ! empty( $salesforce_meta ) ) {

			$meta_boxes[ 'salesforce' ] = array(
				'title'    => esc_html__( 'Salesforce', 'gravityformssalesforce' ),
				'callback' => array( 'GFP_Salesforce_Addon', 'salesforce_meta_box' ),
				'context'  => 'side',
				'priority' => 'high'
			);

		}

		return $meta_boxes;
	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $args
	 */
	public static function salesforce_meta_box( $args ) {

		$entry = $args[ 'entry' ];

		$salesforce_meta = gform_get_meta( $entry[ 'id' ], 'gravityformssalesforce_sobject' );


		global $gravityformssalesforce;

		$addon_object = $gravityformssalesforce->get_addon_object();

		$instance = $addon_object->get_plugin_setting( 'instance' );

		$instance_url = "https://{$instance}.salesforce.com/";


		include( GFP_SALESFORCE_PATH . 'includes/views/entry-detail-metabox.php' );

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return bool
	 */
	public function uninstall() {

		parent::uninstall();

		$current_user = wp_get_current_user();

		delete_metadata( 'user', $current_user->ID, 'gfp_salesforce_dismiss_menu' );

		return true;
	}

}
<?php
/*
 * @package   GFP_Dynamic_Population\GFP_Dynamic_Population_Addon
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     2.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Class GFP_Dynamic_Population_Addon
 *
 * Adds a plugin settings page and form settings fields
 *
 * @since  2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Addon extends GFFeedAddOn {

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
	 * @var string Short version of the plugin title to be used on menus and other places where a less verbose string is useful.
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

	// ------------ Auto-Upgrades -----------
	/**
	 * @var GFP_Auto_Upgrader
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	protected $_auto_upgrader;

	protected $_supports_feed_ordering = true;

	/**
	 * Add-On instance
	 *
	 * @since 2.0.0
	 *
	 * @var GFP_Dynamic_Population_Addon
	 */
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
			array( 'license' => md5( $license_key ),
			       'early_access' => $early_access ) );


		parent::__construct();

	}

	/**
	 * Needed for GF Add-On Framework functions
	 *
	 * @since 2.0.0
	 *
	 * @return GFP_Dynamic_Population_Addon|null
	 */
	public static function get_instance(){

		if ( self::$_instance == null ) {

			self::$_instance = new self(
				array(
					'version'                    => GFP_DYNAMIC_POPULATION_CURRENT_VERSION,
					'min_gf_version'             => '2.3',
					'plugin_slug'                => GFP_DYNAMIC_POPULATION_SLUG,
					'path'                       => plugin_basename(GFP_DYNAMIC_POPULATION_FILE ),
					'full_path'                  => GFP_DYNAMIC_POPULATION_FILE,
					'title'                      => 'Gravity Forms Dynamic Population Pro',
					'short_title'                => 'Dynamic Population',
					'url'                        => 'https://gravityplus.pro/gravity-forms-dynamic-population',
					'capabilities'               => array(
						'gravityplus-dynamic-population_plugin_settings',
						'gravityplus-dynamic-population_form_settings',
						'gravityplus-dynamic-population_uninstall'
					),
					'capabilities_settings_page' => array( 'gravityplus-dynamic-population_plugin_settings' ),
					'capabilities_form_settings' => array( 'gravityplus-dynamic-population_form_settings' ),
					'capabilities_uninstall'     => array( 'gravityplus-dynamic-population_uninstall' )
				) );

		}

		return self::$_instance;

	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $previous_version
	 */
	public function upgrade( $previous_version ) {

		//TODO need to get rid of this on uninstall
		update_option( 'gravityformsaddon_' . $this->_slug . '_previous_version', $previous_version );

		/**
		 * For backwards compatibility
		 */
		do_action( 'gfp_dynamic_population_new_version' );

		do_action( "gform_{$this->_slug}_upgrade", $previous_version, $this );


		return;

	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function scripts() {

		$scripts = array();

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET[ 'gform_debug' ] ) ? '' : '.min';

		$form = $this->get_current_form();


		if ( $this->is_form_settings( 'gravityplus-dynamic-population' ) && '' !== rgget( 'fid' ) ) {

			$settings = $this->get_current_settings();

			if ( empty( $settings ) ) {

				$settings = $this->get_current_feed()[ 'meta' ];

			}

			$wpdb_table = $this->get_setting( 'source_wpdb_table', '', $settings );

			$db_table_columns = empty( $wpdb_table ) ? array() : GFP_Dynamic_Population_Custom_Data::get_table_columns( $wpdb_table );

			$scripts[] =
				array(
					'handle'    => 'gfp_dynamic_population_admin',
					'src'       => GFP_DYNAMIC_POPULATION_URL . "/includes/js/admin{$suffix}.js",
					'version'   => GFP_DYNAMIC_POPULATION_CURRENT_VERSION,
					'deps'      => array( 'jquery', 'gform_form_admin' ),
					'in_footer' => false,
					'enqueue'   => array(
						array(
							'admin_page' => array( 'form_settings' ),
							'tab'        => array( 'gravityplus-dynamic-population' )
						),
					),
					'strings'   => array(
						'feed_source'                  => $this->get_setting( 'source', '', $settings ),
						'feed_object'                  => $this->get_setting( 'object', '', $settings ),
						'feed_field_to_populate'       => $this->get_setting( 'field_to_populate', '', $settings ),
						'feed_wpdb_table_columns'      => $db_table_columns,
						'feed_wpdb_value_table_column' => $this->get_setting( 'source_wpdb_value_table_column', '', $settings )
					)
			);

			$scripts = apply_filters( 'gfp_dynamic_population_scripts', $scripts, $settings, $this );

		}


		return array_merge( parent::scripts(), $scripts );
	}

	public function enqueue_admin_js( $form ) {}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	public function form_settings_icon(){

		return '<img style="height:1em;" src="' . GFP_DYNAMIC_POPULATION_URL . 'includes/images/dynamic_population_pro.svg">';
	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	public function plugin_settings_icon(){

		return '<img style="height:1em;" src="' . GFP_DYNAMIC_POPULATION_URL . 'includes/images/dynamic_population_pro.svg">';

	}

	/**
	 * @see    parent
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */

	public function plugin_settings_fields() {

		$settings_fields = array();

		$settings_fields[ ] = array(
			'title'       => __( 'Updates and Support', 'dynamic-population' ),
			'description' => sprintf( __( 'Enter your license key to receive updates and support for this plugin. If you don\'t have one, you can get one %shere%s.', 'gravityplus-dynamic-population' ), '<a href="https://gravityplus.pro/gravity-forms-dynamic-population/">', '</a>' ),
			'fields'      => array(
				array(
					'name'                => 'license_key',
					'label'               => __( 'License Key', 'dynamic-population' ),
					'type'                => 'text',
					'save_callback'       => array( $this, 'save_license_key' ),
					'feedback_callback' => array( $this, 'check_license_key' ),
				),
				array(
					'label'   => __( 'Get early access to new versions', 'dynamic-population' ),
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


		return $settings_fields;
	}

	/**
	 * Save license key
	 *
	 * @since  2.0.0
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
	 * @since  2.0.0
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

			$version_info = $this->_auto_upgrader->get_version_info( $this->_slug, md5( trim($license_key) ), $this->_version, ( '1' == $this->get_plugin_setting( 'early_access' ) ) ? true : false, false );


			return ( isset( $version_info[ 'is_valid_key' ] ) ? $version_info['is_valid_key'] : false );

		}

	}

	/**
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function render_uninstall() {

		do_action( "gform_{$this->_slug}_render_uninstall", $this );

		parent::render_uninstall();

	}

	/**
	 * @see    GFFeedAddOn::can_duplicate_feed
	 *
	 * @since  2.0.0
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
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function feed_list_columns() {

		return array(
			'feedName' => __( 'Name', 'gravityplus-dynamic-population' ),
			'object'   => __( 'Object', 'gravityplus-dynamic-population' ),
			'source'   => __( 'Source', 'gravityplus-dynamic-population' ),
			/*'condition'  => __( 'Condition', 'gravityplus-dynamic-population' )*/
		);

	}

	/**
	 * Get value to display for the object column, in the feed list
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $item
	 *
	 * @return string
	 */
	public function get_column_value_object( $item ) {

		$column_value = "[{$item['meta'][ 'object' ]}]";

		if ( '[field]' == $column_value ) {

			$field = GFAPI::get_field( $item['form_id'], $item['meta'][ 'field_to_populate' ] );

			$column_value .= " {$field->label}";

		}


		return $column_value;
	}

	/**
	 * Get value to display for the source column, in the feed list
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $item
	 *
	 * @return string
	 */
	public function get_column_value_source( $item ) {

		$column_value = ucfirst( $item['meta'][ 'source' ] );


		return $column_value;
	}

	/**
	 * Get value to display for the condition column, in the feed list
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $item
	 *
	 * @return string
	 */
	public function get_column_value_condition( $item ) {

		$column_value = '';

		$feed_meta            = $item['meta'];

		$is_condition_enabled = rgar( $feed_meta, 'feed_condition_conditional_logic' ) == true;

		$logic                = rgars( $feed_meta, 'feed_condition_conditional_logic_object/conditionalLogic' );

		if ( $is_condition_enabled && ( ! empty( $logic ) ) && is_array( rgar( $logic, 'rules' ) ) ) {

			$type = strtoupper( ( 'all' == $logic['logicType'] ) ? __( 'and', 'gravityplus-dynamic-population') : __('or', 'gravityplus-dynamic-population') );

			$entry_meta_keys = GFFormsModel::get_entry_meta( $item['form_id'] );

			$condition = array();

				foreach ( $logic['rules'] as $rule ) {

					if ( is_numeric( $rule['fieldId'] ) ) {

						$field   = GFFormsModel::get_field( $item['form_id'], $rule['fieldId'] );

						$label = ( ! empty( $field->adminLabel ) ) ? $field->adminLabel : $field->label;

						$condition[] = $label;

					}
					else if( in_array( $rule['fieldId'], array_keys( $entry_meta_keys ) ) ) {

						$condition[] = $entry_meta_keys[ $rule['fieldId'] ]['label'];

					}

					$condition[] = $rule['operator'];

					$condition[] = $rule['value'];

					$condition[] = $type;

				}

				array_pop( $condition );

				$column_value = implode( ' ', $condition );

		}

		return $column_value;
	}

	/**
	 * Allow settings value to be filtered, for sources that may have complex field types like dates
	 *
	 * @see GFAddOn::get_setting
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param string $setting_name
	 * @param string $default_value
	 * @param bool   $settings
	 *
	 * @return array|string
	 */
	public function get_setting( $setting_name, $default_value = '', $settings = false ) {

		return apply_filters( 'gfp_dynamic_population_get_setting', parent::get_setting( $setting_name, $default_value, $settings ), $setting_name, $default_value, $settings );

	}

	/**
	 * @see    GFFeedAddOn::feed_settings_fields
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function feed_settings_fields() {

		$feed_field_name = array(
			'label'    => __( 'Name', 'gravityplus-dynamic-population' ),
			'type'     => 'text',
			'name'     => 'feedName',
			'tooltip'  => __( 'Name for this feed', 'gravityplus-dynamic-population' ),
			'class'    => 'medium',
			'required' => true
		);

		$feed_field_object = array(
			'label'    => __( 'Dynamically populate', 'gravityplus-dynamic-population' ),
			'type'     => 'select',
			'name'     => 'object',
			'choices'  => $this->get_object_choices(),
			/*'default_value' => 'field',*/
			'required' => true,
			'onchange' => "jQuery('#source').val('');jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
		);

		$allowed_field_types = array( 'select', 'checkbox', 'radio', 'email', 'hidden', 'html', 'number', 'password', 'phone', 'text', 'textarea', 'website', 'multiselect' );

		$feed_field_field_to_populate = array(
			'label'    => '' /*__( 'Form field', 'gravityplus-dynamic-population' )*/,
			'type'     => 'field_select',
			'name'     => 'field_to_populate',
			'required' => true,
			'dependency' => array( 'field' => 'object', 'values' => array( 'field' ) ),
			'args' => array( 'field_types' => $allowed_field_types, 'callback' => array( $this, 'field_to_populate_callback' ) ),
			'onchange' => "jQuery('#source').val('');jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
		);

		$field_to_populate_type = empty( $this->get_setting( 'field_to_populate' ) ) ? '' : GFAPI::get_field( $this->get_current_form(), $this->get_setting( 'field_to_populate' ) )->type;

		global $_gaddon_posted_settings;

		if ( empty( $_gaddon_posted_settings[ 'field_to_populate_type' ] ) && ! empty( $_gaddon_posted_settings ) ) {

			$_gaddon_posted_settings[ 'field_to_populate_type' ] = $field_to_populate_type;

		}

		$feed_field_field_to_populate_type = array(
			'label'    => '' /*__( 'Form field', 'gravityplus-dynamic-population' )*/,
			'type'     => 'hidden',
			'name'     => 'field_to_populate_type',
			'value'    => $field_to_populate_type,
			'required' => true,
			'dependency' => array( 'field' => 'object', 'values' => array( 'field' ) ),
		);

		$feed_field_source = array(
			'label'    => __( 'from', 'gravityplus-dynamic-population' ),
			'type'     => 'select',
			'name'     => 'source',
			'choices'  => $this->get_source_choices(),
			'onchange' => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
			'required' => true,
			'dependency' => array(
				'fields' => array(
					array( 'field' => 'object', 'values' => array( 'form' ) ),
					'field_to_populate_type'
				),
				'logic' => 'any' )
		);


		$source_settings_fields = $this->get_source_settings_fields();

		$feed_field_sort_order = array(
			'name'          => 'sort_order',
			'label'         => __( 'Display Order', 'gravityplus-dynamic-population' ),
			'tooltip'       => __( 'Display the dynamically populated choices in ascending or descending order', 'gravityplus-dynamic-population' ),
			'type'          => 'radio',
			'horizontal'    => 'true',
			'choices'       => array(
				array(
					'value' => 'ASC',
					'label' => __( 'Ascending', 'gravityplus-dynamic-population' ),
				),
				array(
					'value' => 'DESC',
					'label' => __( 'Descending', 'gravityplus-dynamic-population' ),
				),
			),
			'default_value' => 'ASC'
		);

		$feed_field_filter = array(
			'name'    => 'filter',
			'label'   => __( 'Filter', 'gravityplus-dynamic-population' ),
			'type'    => 'dynamic_choice_filter',
			'tooltip' => '<h6>' . __( 'Filter Choices', 'gravityplus-dynamic-population' ) . '</h6>' . __( 'Create rules to filter the dynamic choices that are retrieved, based on the value of another field', 'gravityplus-dynamic-population' ),
		);


		$sections = array(
			'section_feed_name' => array(
				'title'  => __( 'Feed Name', 'gravityplus-dynamic-population' ),
				'fields' => array(
					$feed_field_name
				)
			),
			'section_object' => array(
				/*'title'  => __( 'Object', 'gravityplus-dynamic-population' ),*/
				'fields' => array(
					$feed_field_object,
					$feed_field_field_to_populate,
					$feed_field_field_to_populate_type
				)
			),
			'section_source' => array(
				/*'title'  => __( 'Source', 'gravityplus-dynamic-population' ),*/
				'dependency' => 'object',
				'fields' => array(
					$feed_field_source,
				)
			),
			'section_source_settings' => array(
				'title'      => ucwords( $this->get_setting( 'source' ) ) . ' ' . __( 'Settings', 'gravityplus-dynamic-population' ),
				'dependency' => 'source',
				'fields'     => $source_settings_fields
			),
			'section_options' => array(
				'title'      => __( 'Options', 'gravityplus-dynamic-population' ),
				'dependency' => 'source',
				'fields'     => array(
					$feed_field_sort_order
				)
			),
			'section_filter' => array(
				'title'  => __( 'Filter', 'gravityplus-dynamic-population' ),
				'dependency' => array( 'field' => 'source', 'values' => array( 'wpdb' ) ),
				'fields' => array(
					$feed_field_filter
				)
			)
		);

		return $sections;

	}

	/**
	 * @see    GFAddOn::field_map_title
	 *
	 * @since  2.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	public function field_map_title() {

		return apply_filters( 'gfp_dynamic_population_field_map_title', parent::field_map_title() );

	}

	/**
	 * Get object choices for feed
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_object_choices() {

		$this->log_debug( __METHOD__ );

		$object_choices = array(
			array( 'label' => __( 'Select' ), 'value' => '' ),
			array(
				'label' => __( 'one form field', 'gravityplus-dynamic-population' ),
				'value' => 'field'
			),
			array(
				'label' => __( 'multiple form fields', 'gravityplus-dynamic-population' ),
				'value' => 'form'
			)
		);


		return $object_choices;

	}

	/**
	 * @see GFAddOn::get_form_fields_as_choices
	 *
	 * @since 2.0.0
	 *
	 * @param array $form - The form object
	 * @param array $args - Additional settings to check for (field and input types to include, callback for applicable input type)
	 *
	 * @return array The array of formatted form fields
	 */
	public function get_form_fields_as_choices( $form, $args = array() ) {

		$fields = array();

		if ( ! is_array( $form['fields'] ) ) {

			return $fields;

		}

		$args = wp_parse_args(
			$args, array(
				'exclude_ids'    => array(),
				'field_types'    => array(),
				'input_types'    => array(),
				'callback'       => false
			)
		);

		foreach ( $form['fields'] as $field ) {

			if ( ! empty( $args['exclude_ids'] ) && in_array( $field->id, $args['exclude_ids'] ) ) {

				continue;

			}

			if ( ! empty( $args['field_types'] ) && ! in_array( $field->type, $args['field_types'] ) ) {

				continue;

			}

			$input_type               = GFFormsModel::get_input_type( $field );
			$is_applicable_input_type = empty( $args['input_types'] ) || in_array( $input_type, $args['input_types'] );

			if ( is_callable( $args['callback'] ) ) {
				$is_applicable_input_type = call_user_func( $args['callback'], $is_applicable_input_type, $field, $form );
			}

			if ( ! $is_applicable_input_type ) {
				continue;
			}

			if ( ! empty( $args['property'] ) && ( ! isset( $field->{$args['property']} ) || $field->{$args['property']} != $args['property_value'] ) ) {
				continue;
			}

			/*$inputs = $field->get_entry_inputs();

			if ( is_array( $inputs ) ) {

				// if this is an address field, add full name to the list
				if ( $input_type == 'address' ) {
					$fields[] = array(
						'value' => $field->id,
						'label' => GFCommon::get_label( $field ) . ' (' . esc_html__( 'Full', 'gravityforms' ) . ')'
					);
				}
				// if this is a name field, add full name to the list
				if ( $input_type == 'name' ) {
					$fields[] = array(
						'value' => $field->id,
						'label' => GFCommon::get_label( $field ) . ' (' . esc_html__( 'Full', 'gravityforms' ) . ')'
					);
				}
				// if this is a checkbox field, add to the list
				if ( $input_type == 'checkbox' ) {
					$fields[] = array(
						'value' => $field->id,
						'label' => GFCommon::get_label( $field ) . ' (' . esc_html__( 'Selected', 'gravityforms' ) . ')'
					);
				}

				foreach ( $inputs as $input ) {
					$fields[] = array(
						'value' => $input['id'],
						'label' => GFCommon::get_label( $field, $input['id'] )
					);
				}
			} else*/if ( $input_type == 'list' && $field->enableColumns ) {
				/*$fields[] = array(
					'value' => $field->id,
					'label' => GFCommon::get_label( $field ) . ' (' . esc_html__( 'Full', 'gravityforms' ) . ')'
				);*/
				$col_index = 0;
				foreach ( $field->choices as $column ) {
					$fields[] = array(
						'value' => $field->id . '.' . $col_index,
						'label' => GFCommon::get_label( $field ) . ' (' . rgar( $column, 'text' ) . ')',
					);
					$col_index ++;
				}
			} else if ( ! $field->displayOnly ) {
				$fields[] = array( 'value' => $field->id, 'label' => GFCommon::get_label( $field ) );
			} else {
				$fields[] = array(
					'value' => $field->id,
					'label' => GFCommon::get_label( $field )
				);
			}

		}

		return $fields;
	}

	/**
	 * Don't allow field to be used in feed if it's already been used in another feed
	 *
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param bool $is_applicable_input_type
	 * @param GF_Field $field
	 * @param array $form
	 *
	 * @return bool
	 */
	public function field_to_populate_callback( $is_applicable_input_type, $field, $form ) {

		if ( $is_applicable_input_type ) {

			$current_feed_id = $this->get_current_feed()['id'];

			$feeds = $this->get_feeds( $form[ 'id' ] );

			foreach ( $feeds as $feed ) {

				if ( $feed['id'] !== $current_feed_id ) {

					if ( $field[ 'id' ] == $this->get_setting( 'field_to_populate', '', $feed[ 'meta' ] ) ) {

						return false;

					}

				}

			}

		}


		return $is_applicable_input_type;
	}

	/**
	 * Get source choices for feed
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function get_source_choices(){

		$this->log_debug( __METHOD__ );


		$source_choices = array( array( 'label' => __( 'Select source' ), 'value' => '' ) );

		$sources = array();


		$object = $this->get_setting( 'object' );

		$field_to_populate = $this->get_setting( 'field_to_populate' );


		if ( 'field' == $object ) {

			if ( ! empty( $field_to_populate ) ) {

				$sources = apply_filters( 'gfp_dynamic_population_sources', array( 'wpdb' => __( 'WordPress database', 'gravityplus-dynamic-population' ) ) );

			}

		}
		else if ( ! empty( $object ) ) {

			$sources = apply_filters( 'gfp_dynamic_population_sources', $sources );

		}

		foreach ( $sources as $id => $label ) {

			$source_choices[] = array( 'label' => $label, 'value' => $id );

		}


		return $source_choices;

	}

	/**
	 * Get WPDB source settings fields
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_source_settings_fields(){

		$source_settings_fields = array();

		$source = $this->get_setting( 'source' );

		if ( ! empty( $source ) ) {

			if ( 'wpdb' == $source ) {

				$db_tables = GFP_Dynamic_Population_Custom_Data::get_tables();

				$db_table_choices = array( array( 'label' => __( 'Select Database Table' ), 'value' => '' ) );

				foreach ( $db_tables as $table ) {

					$db_table_choices[] = array( 'label' => $table, 'value' => $table );

				}

				$source_settings_fields[] = array(
					'label'    => __( 'Table', 'gravityplus-dynamic-population' ),
					'type'     => 'select',
					'name'     => 'source_wpdb_table',
					'choices'  => $db_table_choices,
					'onchange' => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
					'required' => true,
					'dependency' => array( 'field' => 'source', 'values' => array( 'wpdb' ) )
				);

				$wpdb_table = $this->get_setting( 'source_wpdb_table' );

				if ( ! empty( $wpdb_table ) ){

					$db_table_columns = GFP_Dynamic_Population_Custom_Data::get_table_columns( $wpdb_table );

					$db_table_column_choices = array( array( 'label' => __( 'Select Database Table Column' ), 'value' => '' ) );

					foreach( $db_table_columns as $column ) {

						$db_table_column_choices[] = array( 'label' => $column, 'value' => $column );

					}

					//TODO label not required if field other than choice field

					$source_settings_fields[] = array(
						'label'    => __( 'Column (Label)', 'gravityplus-dynamic-population' ),
						'type'     => 'select',
						'name'     => 'source_wpdb_table_column',
						'choices'  => $db_table_column_choices,
						'required' => true,
						'dependency' => 'source_wpdb_table'
					);

					$source_settings_fields[] = array(
						'label'    => __( 'Column (Value)', 'gravityplus-dynamic-population' ),
						'type'     => 'select',
						'name'     => 'source_wpdb_value_table_column',
						'choices'  => $db_table_column_choices,
						'required' => true,
						'dependency' => 'source_wpdb_table'
					);

				}

			}

		}


		return $source_settings_fields;
	}

	/**
	 * Dynamic choice filter field
	 *
	 * @see GFFeedAddOn::settings_feed_condition()
	 *
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param      $field
	 * @param bool $echo
	 *
	 * @return string
	 */
	public function settings_dynamic_choice_filter( $field, $echo = true ) {

		$conditional_logic = $this->get_dynamic_choice_filter_logic();

		$checkbox_field = $this->get_dynamic_choice_filter_checkbox( $field );

		$hidden_field = $this->get_dynamic_choice_filter_hidden_field();

		$instructions = isset( $field['instructions'] ) ? $field['instructions'] : esc_html__( 'Filter choices where', 'gravityplus-dynamic-population' );

		$source = $this->get_setting( 'source' );

		$fields_column_header = isset( $field['fields_column_header'] ) ? $field['fields_column_header'] : '';

		$values_column_header = isset( $field['values_column_header'] ) ? $field['values_column_header'] : '';

		if ( 'wpdb' == $source ) {

			$fields_column_header = __( 'Table Column', 'gravityplus-dynamic-population' );

			$values_column_header = __( 'Form Field', 'gravityplus-dynamic-population' );

		}

		$html         = $this->settings_checkbox( $checkbox_field, false );

		$html .= $this->settings_hidden( $hidden_field, false );

		$html .= '<div id="dynamic_choice_filter_conditional_logic_container"><!-- dynamically populated --></div>';

		$html .= '<script type="text/javascript"> var dynamicChoiceFilter = new DynamicChoiceFilterObj({' .
		         'strings: { objectDescription: "' . esc_attr( $instructions ) . '" , fields_column_header: "' . esc_attr( $fields_column_header ) . '", values_column_header: "' . esc_attr( $values_column_header ) . '" },' .
		         'logicObject: ' . $conditional_logic .
		         '}); </script>';

		if ( $this->field_failed_validation( $field ) ) {

			$html .= $this->get_error_icon( $field );

		}

		if ( $echo ) {

			echo $html;

		}

		return $html;

	}

	/**
	 *
	 * @see GFFeedAddOn::get_feed_condition_checkbox()
	 *
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 *
	 * @return array
	 */
	public function get_dynamic_choice_filter_checkbox( $field ) {

		$checkbox_label = isset( $field['checkbox_label'] ) ? $field['checkbox_label'] : esc_html__( 'Filter choices', 'gravityplus-dynamic-population' );

		$checkbox_field  = array(
			'name'    => 'dynamic_choice_filter_conditional_logic',
			'type'    => 'checkbox',
			'choices' => array(
				array(
					'label' => $checkbox_label,
					'name'  => 'dynamic_choice_filter_conditional_logic',
				),
			),
			'onclick' => 'ToggleConditionalLogic( false, "dynamic_choice_filter" );',
		);

		return $checkbox_field;
	}

	public function get_dynamic_choice_filter_hidden_field() {

		$conditional_logic = $this->get_dynamic_choice_filter_logic();

		$hidden_field = array(
			'name'  => 'dynamic_choice_filter_conditional_logic_object',
			'value' => $conditional_logic,
		);


		return $hidden_field;

	}

	public function get_dynamic_choice_filter_logic() {

		$conditional_logic_object = $this->get_setting( 'dynamic_choice_filter_conditional_logic_object' );

		if ( $conditional_logic_object ) {

			$form_id           = rgget( 'id' );

			$form              = GFFormsModel::get_form_meta( $form_id );

			$conditional_logic = json_encode( GFFormsModel::trim_conditional_logic_values_from_element( $conditional_logic_object, $form ) );

		} else {

			$conditional_logic = '{}';

		}


		return $conditional_logic;

	}

	public function validate_dynamic_choice_filter_settings( $field, $settings ) {

		$checkbox_field = $this->get_dynamic_choice_filter_checkbox( $field );

		$this->validate_checkbox_settings( $checkbox_field, $settings );

		if ( ! isset( $settings['dynamic_choice_filter_conditional_logic_object'] ) ) {

			return;

		}

		$conditional_logic_object = $settings['dynamic_choice_filter_conditional_logic_object'];

		if ( ! isset( $conditional_logic_object['conditionalLogic'] ) ) {

			return;

		}

		$conditional_logic = $conditional_logic_object['conditionalLogic'];

		$conditional_logic_safe = GFFormsModel::sanitize_conditional_logic( $conditional_logic );

		if ( serialize( $conditional_logic ) != serialize( $conditional_logic_safe ) ) {

			$this->set_field_error( $field, esc_html__( 'Invalid value', 'gravityforms' ) );

		}

	}

	/***
	 * @see GFFeedAddOn::setting_dependency_met()
	 *
	 * Logic: 'all' or 'any'
	 * Comparison: see GFFormsModel::matches_operation() for values
	 *
	 * @param array|string $dependency - Field or input name of the "parent" field.
	 *
	 * @return bool - true if the "parent" field has been filled out and false if it has not.
	 *
	 */
	public function setting_dependency_met( $dependency ) {

		// if no dependency, always return true
		if ( ! $dependency ) {

			return true;

		}

		//use a callback if one is specified in the configuration
		if ( is_callable( $dependency ) ) {

			return call_user_func( $dependency );

		}

		if ( empty( $dependency['fields'] ) ) {

			return $this->dependency_met( $dependency );

		}
		else {

			$logic = rgar( $dependency, 'logic' );

			$logic = ( empty( $logic ) || ! is_string( $logic ) ) ? 'any' : $logic;

			$dependencies_met = 0;

			foreach( $dependency['fields'] as $dependency_field ) {

				$dependency_met = $this->dependency_met( $dependency_field );

				if ( ( 'any' == $logic ) && $dependency_met ) {

					return true;

				} else if ( 'all' == $logic ) {

					if ( $dependency_met ) {

						$dependencies_met ++;

					}
					else {

						return false;

					}

				}

			}

			if ( ( 'all' == $logic ) && ( count( $dependency['fields'] ) == $dependencies_met ) ) {

				return true;

			}

			return false;

		}
	}

	/**
	 * @since 2.0.0
	 *
	 * @param $dependency
	 *
	 * @return bool
	 */
	private function dependency_met( $dependency ) {

		if ( is_array( $dependency ) ) {

			//supports: 'dependency' => array("field" => 'myfield', 'values' => array("val1", 'val2'))
			$dependency_field = $dependency['field'];

			$dependency_value = $dependency['values'];

		} else {

			//supports: 'dependency' => 'myfield'
			$dependency_field = $dependency;

			$dependency_value = '_notempty_';

		}

		if ( ! is_array( $dependency_value ) ) {

			$dependency_value = array( $dependency_value );

		}

		$current_value = $this->get_setting( $dependency_field );

		$comparison = isset( $dependency['comparison'] ) ? $dependency['comparison'] : '';

		$logic = is_array( rgar( $dependency, 'logic' ) ) ? $dependency['logic'][0] : rgar( $dependency, 'logic' );

		$dependency_matches = 0;

		foreach ( $dependency_value as $val ) {

			if ( empty( $comparison ) ) {

				if ( $current_value == $val ) {

					return true;

				}

				if ( $val == '_notempty_' && ! rgblank( $current_value ) ) {

					return true;

				}

			}
			else {

				$matches = GFFormsModel::matches_operation( $current_value, $val, $comparison );

				if ( ( empty( $logic ) || 'any' == $logic ) && $matches ) {

					return true;

				} else if ( 'all' == $logic ) {

					if ( $matches ) {

						$dependency_matches ++;

					}
					else {

						return false;

					}

				}

			}

		}

		if ( ! empty( $comparison ) && count( $dependency_value ) == $dependency_matches ) {

			return true;

		}

		return false;
	}

	/**
	 *
	 * @see GFFeedAddOn::has_feed_condition_field()
	 *
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return bool
	 */
	public function has_dynamic_choice_filter_field() {

		$fields = $this->settings_fields_only( 'feed' );

		foreach ( $fields as $field ) {

			if ( 'dynamic_choice_filter' == $field['type'] ) {

				return true;

			}

		}

		return false;
	}

}
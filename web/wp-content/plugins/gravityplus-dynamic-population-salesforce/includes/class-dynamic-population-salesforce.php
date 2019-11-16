<?php
/**
 * @package   GFP_Dynamic_Population_Salesforce
 * @copyright 2017-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.0.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Main Class
 *
 * Loads everything
 *
 * @since  1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Salesforce {

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var GFP_Salesforce_API | null
	 */
	private $salesforce_api = null;

	/**
	 * Form object
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var array
	 */
	private $form = array();

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function run() {

		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function plugins_loaded() {

		if ( class_exists( 'GFForms' ) && class_exists( 'GFP_Dynamic_Population' ) && class_exists( 'GFP_Salesforce' ) ) {

			$this->load_textdomain();

			$this->init_auto_updates();

			add_filter( 'gfp_dynamic_population_sources', array( $this, 'gfp_dynamic_population_sources' ) );

			add_filter( 'gfp_dynamic_population_scripts', array( $this, 'gfp_dynamic_population_scripts' ), 10, 3 );

			add_action( 'admin_init', array( $this, 'admin_init' ) );

			add_filter( 'gform_is_valid_conditional_logic_operator', array( $this, 'gform_is_valid_conditional_logic_operator' ), 10, 2);

			//add_action( 'gfp_dynamic_population_dynamic_choices_field_settings_container', array( $this, 'gfp_dynamic_population_dynamic_choices_field_settings_container' ) );

			add_filter( 'gform_' . GFP_DYNAMIC_POPULATION_SLUG . '_feed_settings_fields', array(
				$this,
				'feed_settings_fields'
			), 10, 2 );


			//add_action( 'wp_ajax_gfp_dynamic_population_salesforce_get_picklist_fields', array( $this, 'ajax_get_picklist_fields' ) );


			//add_filter( 'gfp_dynamic_population_api_has_dynamic_choice', array( $this, 'gfp_dynamic_population_api_has_dynamic_choice' ), 10, 2 );

			add_filter( 'gfp_dynamic_population_api_dynamic_choice_source_settings', array(
				$this,
				'gfp_dynamic_population_api_dynamic_choice_source_settings'
			), 10, 4 );

			add_filter( 'gfp_dynamic_population_form_display_populate_options', array(
				$this,
				'gfp_dynamic_population_form_display_populate_options'
			), 10, 6 );

			add_filter( 'gfp_dynamic_population_form_display_get_dynamic_choices_values', array(
				$this,
				'gfp_dynamic_population_form_display_get_dynamic_choices_values'
			), 10, 5 );


			add_filter( 'gfp_dynamic_population_dynamic_value_field_source_settings', array(
				$this,
				'gfp_dynamic_population_dynamic_value_field_source_settings'
			), 10, 4 );

			add_filter( 'gfp_dynamic_population_form_display_populate_field_value', array(
				$this,
				'gfp_dynamic_population_form_display_populate_field_value'
			), 10, 5 );

			add_filter( 'gfp_dynamic_population_form_display_get_dynamic_field_value', array(
				$this,
				'gfp_dynamic_population_form_display_get_dynamic_field_value'
			), 10, 6 );


			add_action( 'gform_enqueue_scripts', array( $this, 'gform_enqueue_scripts' ), 10, 2 );

			add_action( 'wp_ajax_nopriv_gfp_get_salesforce_record', array( $this, 'ajax_get_salesforce_record' ) );

			add_action( 'wp_ajax_gfp_get_salesforce_record', array( $this, 'ajax_get_salesforce_record' ) );

		}

	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function load_textdomain() {

		$gfp_dynamic_population_salesforce_lang_dir = dirname( plugin_basename( GFP_DYNAMIC_POPULATION_SALESFORCE_FILE ) ) . '/languages/';

		$gfp_dynamic_population_salesforce_lang_dir = apply_filters( 'gfp_dynamic_population_salesforce_language_dir', $gfp_dynamic_population_salesforce_lang_dir );

		$locale = apply_filters( 'plugin_locale', get_locale(), 'gravityplus-dynamic-population-salesforce' );

		$mofile = sprintf( '%1$s-%2$s.mo', 'gravityplus-dynamic-population-salesforce', $locale );

		$mofile_local = $gfp_dynamic_population_salesforce_lang_dir . $mofile;

		$mofile_global = WP_LANG_DIR . '/gravityplus-dynamic-population-salesforce/' . $mofile;

		if ( file_exists( $mofile_global ) ) {

			load_textdomain( 'gravityplus-dynamic-population-salesforce', $mofile_global );

		} elseif ( file_exists( $mofile_local ) ) {

			load_textdomain( 'gravityplus-dynamic-population-salesforce', $mofile_local );

		} else {

			load_plugin_textdomain( 'gravityplus-dynamic-population-salesforce', false, $gfp_dynamic_population_salesforce_lang_dir );

		}

	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	private function check_if_new_version() {

		if ( ( $current_version = get_option( 'gfp_dynamic_population_salesforce_version' ) ) != GFP_DYNAMIC_POPULATION_SALESFORCE_CURRENT_VERSION ) {

			if ( GFForms::get_wp_option( 'gfp_dynamic_population_salesforce_version' ) != GFP_DYNAMIC_POPULATION_SALESFORCE_CURRENT_VERSION ) {

				update_option( 'gfp_dynamic_population_salesforce_version', GFP_DYNAMIC_POPULATION_SALESFORCE_CURRENT_VERSION );

				do_action( 'gfp_dynamic_population_salesforce_new_version' );

			}
		}
	}

	/**
	 * Initialize auto updates
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function init_auto_updates() {

		if ( ! class_exists( 'GFP_Auto_Upgrader' ) ) {

			require_once( 'class-auto-upgrader.php' );
		}

		$addon = GFP_Salesforce_Addon::get_instance();

		$is_gravityforms_supported = $addon->is_gravityforms_supported( '2.3' );

		$license_key = trim( $addon->get_plugin_setting( 'license_key' ) );

		$early_access = ( '1' == $addon->get_plugin_setting( 'early_access' ) ) ? true : false;

		$this->_auto_upgrader = new GFP_Auto_Upgrader(
			GFP_DYNAMIC_POPULATION_SALESFORCE_SLUG,
			GFP_DYNAMIC_POPULATION_SALESFORCE_CURRENT_VERSION,
			'2.3',
			'Gravity Forms Dynamic Population Pro: Salesforce',
			GFP_DYNAMIC_POPULATION_SALESFORCE_FILE,
			plugin_basename( GFP_DYNAMIC_POPULATION_SALESFORCE_FILE ),
			'https://gravityplus.pro/',
			'https://gravityplus.pro/gravity-forms-salesforce',
			$is_gravityforms_supported,
			array(
				'license'      => md5( $license_key ),
				'early_access' => $early_access
			) );

	}

	/**
	 * Add Salesforce to dynamic population sources
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $sources
	 *
	 * @return mixed
	 */
	public function gfp_dynamic_population_sources( $sources ) {

		$object = GFP_Dynamic_Population_Addon::get_instance()->get_setting( 'object' );

		$field_to_populate_type = GFP_Dynamic_Population_Addon::get_instance()->get_setting( 'field_to_populate_type' );

		if ( empty( $object ) || 'form' == $object || in_array( $field_to_populate_type, array(
				'select',
				'multiselect',
				'radio'
			) ) ) {

			$sources[ 'salesforce' ] = __( 'Salesforce', 'gravityplus-dynamic-population-salesforce' );

		}


		return $sources;

	}

	/**
	 * @since 1.3.0
	 *
	 * @param array $scripts
	 * @param array $settings
	 * @param GFP_Dynamic_Population_Addon $addon_object
	 *
	 * @return array
	 */
	public function gfp_dynamic_population_scripts( $scripts, $settings, $addon_object ) {

		$population_type = $addon_object->get_setting( 'source_salesforce_type', '', $settings );

		$sobject = $addon_object->get_setting( 'source_salesforce_object', '', $settings );

		if ( ! empty( $sobject ) && ! empty( $population_type ) ) {

			$filter_options = array();

			$sobject_fields = $this->get_sobject_fields( $sobject, array(), array(
				'in'    => array(),
				'notin' => array( 'deprecatedAndHidden' )
			) );

			foreach( $sobject_fields as $sobject_field ) {

				$filter_options[] = array(
					'value' => $sobject_field['value'],
					'text' => $sobject_field['label']
				);

			}

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET[ 'gform_debug' ] ) ? '' : '.min';

			$scripts[] =
				array(
					'handle'    => 'gfp_dynamic_population_salesforce_admin',
					'src'       => GFP_DYNAMIC_POPULATION_SALESFORCE_URL . "includes/js/admin{$suffix}.js",
					'version'   => GFP_DYNAMIC_POPULATION_SALESFORCE_CURRENT_VERSION,
					'deps'      => array( 'jquery', 'gform_form_admin', 'gfp_dynamic_population_admin' ),
					'in_footer' => false,
					'enqueue'   => array(
						array(
							'admin_page' => array( 'form_settings' ),
							'tab'        => array( 'gravityplus-dynamic-population' )
						),
					),
					'strings'   => array(
						'filter_options'  => $filter_options,
						'population_type' => $population_type
					)
				);

		}


		return $scripts;

	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function admin_init() {

		$this->check_if_new_version();

		if ( 'gf_edit_forms' == GFForms::get( 'page' ) ) {

			add_filter( 'gform_admin_pre_render', array( $this, 'gform_admin_pre_render' ) );

			//add_action( 'gform_editor_js', array( $this, 'gform_editor_js' ) );

			//add_filter( 'gform_noconflict_scripts', array( $this, 'gform_noconflict_scripts' ) );

		}

	}

	/**
	 * Get form that's being loaded
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form
	 *
	 * @return mixed
	 */
	public function gform_admin_pre_render( $form ) {

		$this->form = $form;

		return $form;
	}

	/**
	 * @deprecated
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gfp_dynamic_population_dynamic_choices_field_settings_container() {

		$sobjects = $this->get_sobjects();

		require_once( trailingslashit( GFP_DYNAMIC_POPULATION_SALESFORCE_PATH ) . 'includes/views/field-setting-dynamic_choices.php' );

	}

	/**
	 * @since 1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $is_valid
	 * @param $operator
	 *
	 * @return bool
	 */
	public function gform_is_valid_conditional_logic_operator( $is_valid, $operator ) {

		if ( 'does_not_contain' == $operator ) {

			return true;
		}

		return $is_valid;
	}

	/**
	 * Add feed options
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array                        $feed_settings_fields
	 *
	 * @param GFP_Dynamic_Population_Addon $addon_object
	 *
	 * @return mixed
	 */
	public function feed_settings_fields( $feed_settings_fields, $addon_object ) {

		$source = $addon_object->get_setting( 'source' );

		if ( 'salesforce' == $source ) {

			$object = $addon_object->get_setting( 'object' );

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Type', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_salesforce_type',
				'choices'    => $this->get_population_type_choices( $object ),
				'required'   => true,
				'dependency' => array( 'field' => 'source', 'values' => array( 'salesforce' ) )
			);

			//TODO for record type, only get objects that are queryable
			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Object', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_salesforce_object',
				'choices'    => $this->get_sobjects(),
				'onchange'   => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
				'required'   => true,
				'dependency' => array( 'field' => 'source', 'values' => array( 'salesforce' ) )
			);

			$population_type = $addon_object->get_setting( 'source_salesforce_type' );

			$sobject = $addon_object->get_setting( 'source_salesforce_object' );

			if ( ! empty( $sobject ) ) {

				switch ( $population_type ) {

					case 'picklist':

						$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
							'label'      => __( 'Field', 'gravityplus-dynamic-population' ),
							'type'       => 'select',
							'name'       => 'source_salesforce_object_field',
							'choices'    => $this->get_sobject_fields( $sobject, array('picklist', 'multipicklist') ),
							'required'   => true,
							'dependency' => array(
								'field'  => 'source_salesforce_type',
								'values' => array( 'picklist' )
							)
						);

						break;

					case 'record_list':

						$choices = $this->get_sobject_fields( $sobject, array(), array(
							'in'    => array(),
							'notin' => array( 'deprecatedAndHidden' )
						) );

						$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
							'label'      => __( 'Choice Label', 'gravityplus-dynamic-population' ),
							'type'       => 'select',
							'name'       => 'source_salesforce_record_list_label',
							'choices'    => $choices,
							'required'   => true,
							'dependency' => array(
								'field'  => 'source_salesforce_type',
								'values' => array( 'record_list' )
							)
						);

						$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
							'label'      => __( 'Choice Value', 'gravityplus-dynamic-population' ),
							'type'       => 'select',
							'name'       => 'source_salesforce_record_list_value',
							'choices'    => $choices,
							'required'   => true,
							'dependency' => array(
								'field'  => 'source_salesforce_type',
								'values' => array( 'record_list' )
							)
						);

						//$field_to_populate_type = GFP_Dynamic_Population_Addon::get_instance()->get_setting( 'field_to_populate_type' );


						//TODO if product field_to_populate_type, add field for price

						break;

					case 'record':

						$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
							'label'          => __( 'Search Fields', 'gravityplus-dynamic-population' ),
							'type'           => 'dynamic_field_map',
							'name'           => 'source_salesforce_search_fields',
							'tooltip'        => __( 'Select your Salesforce field name, then select the form field that has the value to be used to search for the Salesforce record', 'gravityplus-dynamic-population' ),
							'field_map'      => $this->get_sobject_fields( $sobject ),
							//TODO make sure these are only fields that are searchable
							'disable_custom' => true,
							'dependency'     => array(
								'field'  => 'source_salesforce_type',
								'values' => array( 'record' )
							)
						);

						$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
							'label'          => __( 'Search Match', 'gravityplus-dynamic-population' ),
							'type'           => 'select',
							'name'           => 'source_salesforce_search_match',
							'choices'        => array(
								array(
									'value' => 'all',
									'label' => __( 'All', 'gravityplus-dynamic-population' ),
								),
								array(
									'value' => 'any',
									'label' => __( 'Any', 'gravityplus-dynamic-population' ),
								),
							),
							'default_value' => 'all',
							'dependency'     => array(
								'field'  => 'source_salesforce_type',
								'values' => array( 'record' )
							)
						);

						$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
							'label'          => __( 'Populate Fields (Required)', 'gravityplus-dynamic-population' ),
							'type'           => 'field_map',
							'name'           => 'source_salesforce_required_fields',
							'tooltip'        => __( 'Select the form field that will be populated with the value for the Salesforce required field', 'gravityplus-dynamic-population' ),
							'field_map'      => array(
								array(
									'label'    => __( 'Object ID', 'gravity-forms-salesforce' ),
									'name'     => 'Id',
									'required' => true
								)
							),
							'required'       => true,
							'disable_custom' => true,
							'dependency'     => array(
								'field'  => 'source_salesforce_type',
								'values' => array( 'record' )
							)
						);

						$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
							'label'          => __( 'Populate Fields (Other)', 'gravityplus-dynamic-population' ),
							'type'           => 'dynamic_field_map',
							'name'           => 'source_salesforce_other_fields',
							'tooltip'        => __( 'Select your Salesforce field name, then select the form field that will be populated with the value for that field', 'gravityplus-dynamic-population' ),
							'field_map'      => $this->get_sobject_fields( $sobject ),
							'disable_custom' => true,
							'dependency'     => array(
								'field'  => 'source_salesforce_type',
								'values' => array( 'record' )
							)
						);


						break;

				}

			}

			$feed_settings_fields[ 'section_filter' ][ 'dependency' ] = array(
				'fields' => array(
					$feed_settings_fields[ 'section_filter' ][ 'dependency' ],
					array( 'field' => 'source_salesforce_type', 'values' => array( 'record_list' ) )
				),
				'logic'  => 'any'
			);

			unset( $feed_settings_fields[ 'section_options' ] );

			if ( 'record' == $population_type ) {

				add_filter( 'gfp_dynamic_population_field_map_title', array( $this, 'gfp_dynamic_population_field_map_title' ) );
			}

		}

		return $feed_settings_fields;
	}

	/**
	 * @see    GFAddOn::field_map_title
	 *
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	public function gfp_dynamic_population_field_map_title() {

		return __( 'Salesforce Field', 'gravityplus-dynamic-population-salesforce' );

	}

	/**
	 * Get population type choices for feed
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_population_type_choices( $object ) {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$population_type_choices = array( array( 'label' => __( 'Select' ), 'value' => '' ), );

		if ( 'field' == $object ) {

			$population_type_choices[] = array(
				'label' => __( 'Picklist values', 'gravityplus-dynamic-population' ),
				'value' => 'picklist'
			);

			$population_type_choices[] = array(
				'label' => __( 'List of records', 'gravityplus-dynamic-population' ),
				'value' => 'record_list'
			);

		} else if ( 'form' == $object ) {

			$population_type_choices[] = array(
				'label' => __( 'A single record', 'gravityplus-dynamic-population' ),
				'value' => 'record'
			);

		}


		return $population_type_choices;

	}

	/**
	 * @deprecated
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_editor_js() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'gfp_dynamic_population_form_editor_salesforce', trailingslashit( GFP_DYNAMIC_POPULATION_SALESFORCE_URL ) . "includes/js/dynamic-choices.editor{$suffix}.js", array( 'gfp_dynamic_population_form_editor' ), GFP_DYNAMIC_POPULATION_SALESFORCE_CURRENT_VERSION );

		$select_field_placeholder = '<option value="">' . __( '...Select picklist field', 'gravityplus-dynamic-population-salesforce' ) . '</option>';

		wp_localize_script( 'gfp_dynamic_population_form_editor_salesforce', 'gfp_dynamic_population_salesforce_data', array(
			'placeholders'     => array(
				'object_field' => $select_field_placeholder
			),
			'current_settings' => $this->get_current_settings_info()
		) );

	}

	/**
	 * @deprecated
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $noconflict_scripts
	 *
	 * @return array
	 */
	public static function gform_noconflict_scripts( $noconflict_scripts ) {

		$noconflict_scripts = array_merge( $noconflict_scripts, array( 'gfp_dynamic_population_form_editor_salesforce' ) );


		return $noconflict_scripts;

	}

	/**
	 * @deprecated
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_current_settings_info() {

		$current_settings_info = array();

		if ( ! empty( $this->form ) && GFP_Dynamic_Population_API::has_dynamic_choice_field( $this->form, 'salesforce' ) ) {

			$dynamic_choice_fields = GFP_Dynamic_Population_API::get_dynamic_choice_fields( $this->form, 'salesforce' );

			foreach ( $dynamic_choice_fields as $key => $dynamic_choice_field_info ) {

				$object_field = $this->get_chosen_picklist_field( $dynamic_choice_field_info );

				if ( empty( $object_field ) ) {

					unset( $current_settings_info[ $key ] );

					continue;

				}

				$current_settings_info[ $key ][ 'object_field' ] = array( $object_field );

			}

		}

		return $current_settings_info;

	}

	/**
	 * @deprecated
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field_info
	 *
	 * @return array
	 */
	private function get_chosen_picklist_field( $field_info ) {

		$picklist_field_choice = array();

		if ( ! empty( $field_info[ 'object' ] ) ) {

			$sobject_field = $this->get_sobject_field( $field_info[ 'object' ], $field_info[ 'object_field' ] );

			if ( ! empty( $sobject_field ) ) {

				$picklist_field_choice = array(
					'label' => $sobject_field[ 'label' ],
					'value' => $sobject_field[ 'name' ]
				);

			}


		}


		return $picklist_field_choice;
	}

	/**
	 * Get picklist fields for chosen object
	 *
	 * @deprecated
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function ajax_get_picklist_fields() {

		$sobject = rgpost( 'sobject' );

		if ( ! empty( $sobject ) ) {

			$picklist_fields = $this->get_sobject_fields( $sobject, array('picklist') );

			if ( ! empty( $picklist_fields ) ) {

				$selected = '';

				if ( 1 < count( $picklist_fields ) ) {

					$placeholder = array(
						'text'       => '--' . __( 'Select', 'gravityplus-dynamic-population-salesforce' ) . '--',
						'value'      => '',
						'isSelected' => true,
						'price'      => ''
					);

					$options = '<option value="' . $placeholder[ 'value' ] . '" selected="selected">' . $placeholder[ 'text' ] . '</option>';

				} else {

					$selected = 'selected="selected"';
					$options  = '';

				}

				foreach ( $picklist_fields as $picklist_field ) {

					$options .= '<option value="' . $picklist_field[ 'value' ] . '" ' . $selected . '>' . $picklist_field[ 'label' ] . '</option>';

				}

				wp_send_json_success( array(
					'options' => $options
				) );
			}

		}

		wp_send_json_error();

	}

	/**
	 * Get Salesforce objects
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function get_sobjects() {

		$object_choices = array( array( 'label' => __( 'Select' ), 'value' => '' ), );

		if ( empty( $this->salesforce_api ) ) {

			global $gravityformssalesforce;

			$gfp_salesforce_addon = $gravityformssalesforce->get_addon_object();

			$this->salesforce_api = $gfp_salesforce_addon->get_salesforce_api();

		}

		$sobjects = $this->salesforce_api->describe_global();

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
	 * Get fields for object
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param        $sobject
	 * @param array $type
	 *
	 * @return array
	 */
	public function get_sobject_fields( $sobject, $type = array(), $properties = array() ) {

		$sobject_fields = array();

		$default_properties = array(
			'activateable',
			'createable',
			'deletable',
			'deprecatedAndHidden',
			'layoutable',
			'listviewable',
			'mergeable',
			'queryable',
			'searchable',
			'replicateable',
			'retrievable',
			'triggable',
			'undeletable',
			'updateable'
		);

		if ( empty( $properties ) ) {

			$properties = array(
				'in'    => array( 'createable' ),
				'notin' => array( 'deprecatedAndHidden' )
			);

		}


		if ( ! empty( $sobject ) ) {

			if ( empty( $this->salesforce_api ) ) {

				global $gravityformssalesforce;

				$gfp_salesforce_addon = $gravityformssalesforce->get_addon_object();

				$this->salesforce_api = $gfp_salesforce_addon->get_salesforce_api();

			}

			$sobject_description = $this->salesforce_api->describe( $sobject );

			if ( $sobject_description[ 'success' ] && ! empty( $sobject_description[ 'response' ][ 'fields' ] ) ) {

				foreach ( $sobject_description[ 'response' ][ 'fields' ] as $field ) {

					if ( ( empty( $type ) || in_array( $field[ 'type' ], $type ) ) && $this->field_properties_match( $properties, $field ) ) {

						$sobject_fields[] = array( 'label' => $field[ 'label' ], 'value' => $field[ 'name' ] );

					}

				}

			}

		}

		foreach ( $sobject_fields as $key => $row ) {

			$field_label[ $key ] = $row[ 'label' ];

			$field_name[ $key ] = $row[ 'value' ];

		}

		array_multisort( $field_label, SORT_ASC, $field_name, SORT_ASC, $sobject_fields );


		return $sobject_fields;

	}

	/**
	 * @since    1.2.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $properties
	 * @param $field
	 *
	 * @return bool
	 */
	private function field_properties_match( $properties, $field ) {

		$properties_in_match = $properties_notin_match = 0;

		$properties_in = count( $properties[ 'in' ] );

		$properties_notin = count( $properties[ 'notin' ] );


		foreach ( $properties[ 'in' ] as $property ) {

			if ( $field[ $property ] ) {

				$properties_in_match ++;

			}

		}

		unset( $property );

		if ( $properties_in_match < $properties_in ) {

			return false;
		}


		foreach ( $properties[ 'notin' ] as $property ) {

			if ( ! $field[ $property ] ) {

				$properties_notin_match ++;

			}

		}

		unset( $property );

		if ( $properties_notin_match < $properties_notin ) {

			return false;
		}

		return true;

	}

	/**
	 * Get sobject field
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $sobject
	 * @param $field_name
	 *
	 * @return array
	 */
	public function get_sobject_field( $sobject, $field_name ) {

		$sobject_field = array();


		if ( ! empty( $sobject ) ) {

			if ( empty( $this->salesforce_api ) ) {

				global $gravityformssalesforce;

				$gfp_salesforce_addon = $gravityformssalesforce->get_addon_object();

				$this->salesforce_api = $gfp_salesforce_addon->get_salesforce_api();

			}

			$sobject_description = $this->salesforce_api->describe( $sobject );

			if ( $sobject_description[ 'success' ] && ! empty( $sobject_description[ 'response' ][ 'fields' ] ) ) {

				foreach ( $sobject_description[ 'response' ][ 'fields' ] as $field ) {

					if ( $field[ 'name' ] == $field_name ) {

						$sobject_field = $field;

						break;

					}

				}

			}

		}


		return $sobject_field;

	}

	/**
	 * @deprecated
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $has_dynamic_choice
	 * @param $field
	 *
	 * @return bool
	 */
	public function gfp_dynamic_population_api_has_dynamic_choice( $has_dynamic_choice, $field ) {

		if ( ! empty( $field[ 'dynamicChoicesEnable' ] )
		     && $field[ 'dynamicChoicesEnable' ]
		     && ! empty( $field[ 'dynamicChoicesSource' ] )
		     && 'salesforce' == $field[ 'dynamicChoicesSource' ]
		     && ! empty( $field[ 'dynamicChoicesSalesforceObject' ] )
		     && ! empty( $field[ 'dynamicChoicesSalesforceObjectField' ] )

		) {

			$has_dynamic_choice = true;

		}


		return $has_dynamic_choice;
	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $dynamic_choice_settings
	 * @param $source
	 * @param $field
	 *
	 * @return array
	 */
	public function gfp_dynamic_population_api_dynamic_choice_source_settings( $dynamic_choice_settings, $source, $field_or_feed, $type ) {

		if ( 'salesforce' == $source ) {

			$salesforce_source_settings = array();

			if ( 'field' == $type ) {

				$salesforce_source_settings = array(
					'object'       => rgar( $field_or_feed, 'dynamicChoicesSalesforceObject' ),
					'object_field' => rgar( $field_or_feed, 'dynamicChoicesSalesforceObjectField' )
				);

			} else if ( 'feed' == $type ) {

				$addon_object = GFP_Dynamic_Population_Addon::get_instance();

				$salesforce_source_settings = array(
					'object'          => $addon_object->get_setting( 'source_salesforce_object', '', $field_or_feed[ 'meta' ] ),
					'population_type' => $addon_object->get_setting( 'source_salesforce_type', '', $field_or_feed[ 'meta' ] )
				);

				switch ( $salesforce_source_settings[ 'population_type' ] ) {

					case 'picklist':

						$salesforce_source_settings[ 'object_field' ] = $addon_object->get_setting( 'source_salesforce_object_field', '', $field_or_feed[ 'meta' ] );

						break;

					case 'record_list':

						$salesforce_source_settings[ 'label_field' ] = $addon_object->get_setting( 'source_salesforce_record_list_label', '', $field_or_feed[ 'meta' ] );

						$salesforce_source_settings[ 'value_field' ] = $addon_object->get_setting( 'source_salesforce_record_list_value', '', $field_or_feed[ 'meta' ] );


						break;
				}

			}

			$dynamic_choice_settings = array_merge( $dynamic_choice_settings, $salesforce_source_settings );
		}


		return $dynamic_choice_settings;
	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $options
	 * @param $form
	 * @param $field_id
	 * @param $dynamic_choice_info
	 * @param $field_values
	 * @param $get_from_post
	 *
	 * @return array
	 */
	public function gfp_dynamic_population_form_display_populate_options( $options, $form, $field_id, $dynamic_choice_info, $field_values, $get_from_post ) {

		if ( 'salesforce' == $dynamic_choice_info[ 'source' ] ) {

			switch ( $dynamic_choice_info[ 'population_type' ] ) {

				case 'picklist':

					$sobject_field = $this->get_sobject_field( $dynamic_choice_info[ 'object' ], $dynamic_choice_info[ 'object_field' ] );

					$options = $this->get_field_picklist_value_options( $sobject_field, $form, true );


					break;

				case 'record_list':

					$options = $this->get_field_record_list_options( $dynamic_choice_info[ 'object' ], $dynamic_choice_info[ 'label_field' ], $dynamic_choice_info[ 'value_field' ], $form, true );


					break;
			}

			if ( ! empty( $dynamic_choice_info[ 'placeholder' ] ) ) {

				$options = array_merge( array( $dynamic_choice_info[ 'placeholder' ] ), $options );

			}

		}


		return $options;
	}

	/**
	 * @since    1.0.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param      $sobject_field
	 * @param      $form
	 * @param bool $formatted
	 *
	 * @return array
	 */
	private function get_field_picklist_value_options( $sobject_field, $form, $formatted = true ) {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$options = array();


		foreach ( $sobject_field[ 'picklistValues' ] as $picklist_value ) {

			if ( $picklist_value[ 'active' ] ) {

				$options[] = $formatted ? array(
					'text'       => $picklist_value[ 'label' ],
					'value'      => $picklist_value[ 'value' ],
					'isSelected' => $picklist_value[ 'defaultValue' ],
					'price'      => ''
				) : array( $picklist_value[ 'label' ], $picklist_value[ 'value' ] );

			}

		}

		return $options;
	}

	/**
	 * @since    1.2.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param      $sobject
	 * @param      $label_field
	 * @param      $value_field
	 * @param      $form
	 * @param bool $formatted
	 *
	 * @return array
	 */
	private function get_field_record_list_options( $sobject, $label_field, $value_field, $form, $formatted = true, $filters = array() ) {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$options = array();

		$search_parameters = array();

		$parameter_count = 0;


		//WHERE clauses cannot exceed 4,000 chars

		foreach ( $filters as $salesforce_field_name => $filter_info ) {

			if ( ! empty( $filter_info['field_id'] ) ) {

				if ( 0 < $parameter_count ) {

					$search_parameters[] = 'AND';

				}

				$condition = $this->get_condition_for_salesforce_query( $salesforce_field_name, $filter_info['operator'], $filter_info['field_id'] );

				if ( empty( $condition ) ) {

					continue;

				}

				$search_parameters[] = $condition;

				$parameter_count ++;

			}

		}

		if ( empty( $search_parameters ) ) {

			$query = implode( ' ', array_merge(
					array( 'Select' ),
					array( "{$label_field},{$value_field}" ),
					array( 'FROM', $sobject )
				)
			);

		}
		else {

			$query = implode( ' ', array_merge(
					array( 'Select' ),
					array( "{$label_field},{$value_field}" ),
					array( 'FROM', $sobject, 'WHERE' ),
					$search_parameters
				)
			);

		}

		$record_list = $this->get_record_list( $query );

		if ( empty( $record_list ) ) {

			return $options;
		}

		foreach ( $record_list as $record_info ) {

			$options[] = $formatted ? array(
				'text'       => $record_info[ $label_field ],
				'value'      => $record_info[ $value_field ],
				'isSelected' => '',
				'price'      => ''
			) : array( $record_info[ $label_field ], $record_info[ $value_field ] );

		}

		return $options;

	}

	/**
	 * Create Salesforce condition string
	 *
	 * @since 1.3.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field_name
	 * @param $operator
	 * @param $value
	 *
	 * @return string
	 */
	private function get_condition_for_salesforce_query( $field_name, $operator, $value ) {

		switch( $operator ) {

			case 'is':

				return "{$field_name} = '{$value}'";

			case 'isnot':

				return "{$field_name} != '{$value}'";

			case '>':

				return "{$field_name} > {$value}";

			case '<':

				return "{$field_name} < {$value}";

			case 'contains':

				return "{$field_name} LIKE '%{$value}%'";

			case 'does_not_contain':

				return "(NOT {$field_name} LIKE '%{$value}%')";

			case 'starts_with':

				return "LIKE '{$value}%'";

			case 'ends_with':

				return "LIKE '%{$value}'";

		}

		return '';

	}

	/**
	 * @since    1.2.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $query
	 *
	 * @return array
	 */
	private function get_record_list( $query ) {

		if ( empty( $this->salesforce_api ) ) {

			global $gravityformssalesforce;

			$gfp_salesforce_addon = $gravityformssalesforce->get_addon_object();

			$this->salesforce_api = $gfp_salesforce_addon->get_salesforce_api();

		}

		$results = $this->salesforce_api->query( $query );

		if ( empty( $results[ 'success' ] ) ) {

			return array();
		}

		if ( empty( $results[ 'response' ][ 'totalSize' ] ) ) {

			return array();
		}

		$record_list = $results[ 'response' ][ 'records' ];

		if ( ! empty( $results[ 'response' ][ 'nextRecordsUrl' ] ) ) {

			$more_records = $this->get_record_list( $results[ 'response' ][ 'nextRecordsUrl' ] );

			if ( ! empty( $more_records ) ) {

				$record_list = array_merge( $record_list, $more_records );

			}

			unset( $more_records );

		}


		return $record_list;
	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $values
	 * @param $source
	 * @param $dynamic_choice_source_settings
	 * @param $form
	 * @param $field
	 *
	 * @return mixed
	 */
	public function gfp_dynamic_population_form_display_get_dynamic_choices_values( $values, $source, $dynamic_choice_source_settings, $form, $field ) {

		if ( 'salesforce' == $source ) {//TODO change formatted to true

			switch ( $dynamic_choice_source_settings[ 'population_type' ] ) {

				case 'picklist':

					$sobject_field = $this->get_sobject_field( $dynamic_choice_source_settings[ 'object' ], $dynamic_choice_source_settings[ 'object_field' ] );

					$values = $this->get_field_picklist_value_options( $sobject_field, $form, false );


					break;

				case 'record_list':

					$values = $this->get_field_record_list_options( $dynamic_choice_source_settings[ 'object' ], $dynamic_choice_source_settings[ 'label_field' ], $dynamic_choice_source_settings[ 'value_field' ], $form, false );


					break;
			}

		}


		return $values;
	}

	/**
	 * Add JS
	 *
	 * @param null $form
	 * @param null $ajax
	 */
	public function gform_enqueue_scripts( $form = null, $ajax = null ) {

		if ( ! $form == null ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			if ( $addon_object->has_feed( $form[ 'id' ] ) ) {

				$feeds = $addon_object->get_active_feeds( $form[ 'id' ] );

				$search_field_ids = $field_info = array();

				foreach ( $feeds as $feed ) {

					$source = $addon_object->get_setting( 'source', '', $feed[ 'meta' ] );

					if ( 'salesforce' == $source && 'record' == $addon_object->get_setting( 'source_salesforce_type', '', $feed[ 'meta' ] ) ) {

						$feed_search_field_ids = array_values( $addon_object->get_dynamic_field_map_fields( $feed, 'source_salesforce_search_fields' ) );

						$field_info[ $feed['id'] ] = $feed_search_field_ids;

						$search_field_ids = array_merge( $search_field_ids, $feed_search_field_ids );

					}

				}

				if ( ! empty( $search_field_ids ) ) {

					$search_field_ids = array_unique( $search_field_ids );

					$protocol = isset ( $_SERVER[ "HTTPS" ] ) ? 'https://' : 'http://';

					$ajaxurl = admin_url( 'admin-ajax.php', $protocol );

					$spinner_url = apply_filters( "gform_ajax_spinner_url_{$form['id']}", apply_filters( "gform_ajax_spinner_url", GFCommon::get_base_url() . "/images/spinner.gif", $form ), $form );

					$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

					wp_enqueue_script( 'gfp_dynamic_salesforce', trailingslashit( GFP_DYNAMIC_POPULATION_SALESFORCE_URL ) . "includes/js/dynamic-choices.display{$suffix}.js", array( 'jquery' ), GFP_DYNAMIC_POPULATION_SALESFORCE_CURRENT_VERSION );

					wp_localize_script( 'gfp_dynamic_salesforce', 'gfp_dynamic_salesforce', array(
						'search_fields'  => $search_field_ids,
						'field_info'  => $field_info,
						/*'feed_id'     => $feed[ 'id' ],*/
						'form_id'     => $form[ 'id' ],
						'ajaxurl'     => $ajaxurl,
						'spinner_url' => $spinner_url
					) );

				}

			}

		}

	}

	/**
	 * @since 1.3.0
	 *
	 * @param $dynamic_source_settings
	 * @param $source
	 * @param $feed
	 * @param $field
	 *
	 * @return array
	 */
	public function gfp_dynamic_population_dynamic_value_field_source_settings( $dynamic_source_settings, $source, $feed, $field ) {

		if ( 'salesforce' == $source ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$salesforce_settings = array(
				'object'          => $addon_object->get_setting( 'source_salesforce_object', '', $feed[ 'meta' ] ),
				'population_type' => $addon_object->get_setting( 'source_salesforce_type', '', $feed[ 'meta' ] )
			);

			switch ( $salesforce_settings[ 'population_type' ] ) {

				case 'picklist':

					$salesforce_settings[ 'object_field' ] = $addon_object->get_setting( 'source_salesforce_object_field', '', $feed[ 'meta' ] );

					break;

				case 'record_list':

					$salesforce_settings[ 'label_field' ] = $addon_object->get_setting( 'source_salesforce_record_list_label', '', $feed[ 'meta' ] );

					$salesforce_settings[ 'value_field' ] = $addon_object->get_setting( 'source_salesforce_record_list_value', '', $feed[ 'meta' ] );


					break;
			}

			$dynamic_source_settings = array_merge( $dynamic_source_settings, $salesforce_settings );

		}


		return $dynamic_source_settings;
	}

	/**
	 * @since 1.3.0
	 *
	 * @param $form
	 * @param $field_id
	 * @param $dynamic_value_info
	 * @param $field_values
	 * @param $get_from_post
	 *
	 * @return mixed
	 */
	public function gfp_dynamic_population_form_display_populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, $get_from_post ) {

		if ( 'salesforce' == $dynamic_value_info[ 'source' ] ) {

			switch ( $dynamic_value_info[ 'population_type' ] ) {

				case 'picklist':

					$sobject_field = $this->get_sobject_field( $dynamic_value_info[ 'object' ], $dynamic_value_info[ 'object_field' ] );

					$retrieved_values = $this->get_field_picklist_value_options( $sobject_field, $form, false );


					break;

				case 'record_list':

					$retrieved_values = $this->get_field_record_list_options( $dynamic_value_info[ 'object' ], $dynamic_value_info[ 'label_field' ], $dynamic_value_info[ 'value_field' ], $form, false, empty( $dynamic_value_info['dependees'] ) ? array() : $dynamic_value_info['dependees'] );


					break;
			}


			if ( empty( $retrieved_values ) ) {

				return $form;

			}

			$field = GFAPI::get_field( $form, $field_id );

			switch ( $field->type ) {

				case 'select':
				case 'multiselect':
				case 'radio':

					foreach ( $retrieved_values as $retrieved ) {

						$value[] = array(
							'text'       => $retrieved[ 0 ],
							'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
							'isSelected' => false,
							'price'      => ''
						);

					}

					$property = 'choices';


					break;

				case 'html':

					$property = 'content';

					$value = $retrieved_values[ 0 ][ 0 ];


					break;

				default:

					$property = 'defaultValue';

					$value = $retrieved_values[ 0 ][ 0 ];

			}

			foreach ( $form[ 'fields' ] as $key => $form_field ) {

				if ( $form_field[ 'id' ] == $field_id ) {

					$form[ 'fields' ][ $key ][ $property ] = $value;

					break;
				}

			}

		}


		return $form;
	}

	/**
	 * @since 1.3.0
	 *
	 * @param           $value
	 * @param string    $source
	 * @param array     $dynamic_value_source_settings
	 * @param           $form
	 * @param GF_Field  $field
	 * @param array     $dependees
	 *
	 * @return string
	 */
	public function gfp_dynamic_population_form_display_get_dynamic_field_value( $value, $source, $dynamic_value_source_settings, $form, $field, $dependees ) {

		if ( 'salesforce' == $source ) {

			switch ( $dynamic_value_source_settings[ 'population_type' ] ) {

				case 'picklist':

					$sobject_field = $this->get_sobject_field( $dynamic_value_source_settings[ 'object' ], $dynamic_value_source_settings[ 'object_field' ] );

					$retrieved_values = $this->get_field_picklist_value_options( $sobject_field, $form, false );


					break;

				case 'record_list':

					$retrieved_values = $this->get_field_record_list_options( $dynamic_value_source_settings[ 'object' ], $dynamic_value_source_settings[ 'label_field' ], $dynamic_value_source_settings[ 'value_field' ], $form, false, empty( $dynamic_value_source_settings['dependees'] ) ? array() : $dynamic_value_source_settings['dependees'] );


					break;
			}


			if ( empty( $retrieved_values ) ) {

				return $value;
			}

			$trigger_change = ( 1 < count( $retrieved_values ) ) ? false : true;

			$value = '';

			switch ( $field->type ) {

				case 'select':

					$value = array();

					foreach ( $retrieved_values as $retrieved ) {

						$value[] = array(
							'text'       => $retrieved[ 0 ],
							'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
							'isSelected' => false,
							'price'      => ''
						);

					}

					//TODO maybe remove
					if ( empty( $field->placeholder ) ) {

						$field->__set( 'placeholder', __( 'Select', 'gravityplus-dynamic-population' ) );
					}

					$field->__set( 'choices', $value );

					/**
					 * @var GF_Field_Select $field
					 */
					$value = $field->get_choices( $value );


					break;

					case 'multiselect':

					$value = array();

					foreach ( $retrieved_values as $retrieved ) {

						$value[] = array(
							'text'       => $retrieved[ 0 ],
							'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
							'isSelected' => false,
							'price'      => ''
						);

					}

					$field->__set( 'choices', $value );

					/**
					 * @var GF_Field_MultiSelect $field
					 */
					$value = $field->get_choices( $value );


					break;

				case 'radio':

					$value = array();

					foreach ( $retrieved_values as $retrieved ) {

						$value[] = array(
							'text'       => $retrieved[ 0 ],
							'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
							'isSelected' => false,
							'price'      => ''
						);

					}

					$field->__set( 'choices', $value );

					/**
					 * @var GF_Field_Radio $field
					 */
					$value = $field->get_radio_choices( $value, '', $form[ 'id' ] );

					break;


				default:

					$value = $retrieved_values[ 0 ][ 0 ];

			}

		}

		return $value;
	}

	/**
	 * Get Salesforce record values
	 *
	 * Note that WHERE clauses cannot exceed 4,000 characters and query cannot exceed 22,000
	 *
	 * @since 1.2.0
	 */
	public function ajax_get_salesforce_record() {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$feed_id = rgpost( 'feed_id' );

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		$feed = $addon_object->get_feed( $feed_id );

		$search_field_ids = $addon_object->get_dynamic_field_map_fields( $feed, 'source_salesforce_search_fields' );

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( 'Search field IDs: ' . print_r( $search_field_ids, true ) );

		$search_parameters = array();

		$parameter_count = 0;


		foreach ( $search_field_ids as $salesforce_field_name => $form_field_id ) {

			GFP_Dynamic_Population_Addon::get_instance()->log_debug( 'Form field ID: ' . print_r( $form_field_id, true ) );

			$form_field_value = rgpost( 'field_' . str_replace( '.', '_', $form_field_id ) );

			GFP_Dynamic_Population_Addon::get_instance()->log_debug( 'Form field value: ' . print_r( $form_field_value, true ) );


			if ( ! empty( $form_field_value ) ) {

				if ( 0 < $parameter_count ) {

					$search_type = $addon_object->get_setting( 'source_salesforce_search_match', 'all', $feed[ 'meta' ] );

					$search_parameters[] = ( 'all' == $search_type ) ? 'AND' : 'OR';

				}

				$search_parameters[] = $salesforce_field_name;

				$search_parameters[] = '=';

				$form_field_type = GFAPI::get_field( $feed['form_id'], $form_field_id )->type;

				$search_parameters[] = ('number' == $form_field_type) ? "{$form_field_value}" : "'{$form_field_value}'";

				$parameter_count ++;

			}

		}

		if ( empty( $search_parameters ) ) {

			wp_send_json_error( 'Empty search parameters' );

		} else {

			$sobject = $addon_object->get_setting( 'source_salesforce_object', '', $feed[ 'meta' ] );

			$required_fields_ids = $addon_object->get_field_map_fields( $feed, 'source_salesforce_required_fields' );

			$other_field_ids = $addon_object->get_dynamic_field_map_fields( $feed, 'source_salesforce_other_fields' );

			$query = implode( ' ', array_merge(
				array( 'Select' ),
				array(
					implode( ',', array_merge(
						array( 'Id' ),
						array_keys( $other_field_ids )
					)
					)
				),
				array( 'FROM', $sobject, 'WHERE' ),
				$search_parameters
			)
			);

			//TODO escape reserved characters https://developer.salesforce.com/docs/atlas.en-us.212.0.soql_sosl.meta/soql_sosl/sforce_api_calls_soql_select_reservedcharacters.htm

			if ( empty( $this->salesforce_api ) ) {

				global $gravityformssalesforce;

				$gfp_salesforce_addon = $gravityformssalesforce->get_addon_object();

				$this->salesforce_api = $gfp_salesforce_addon->get_salesforce_api();

			}

			$results = $this->salesforce_api->query( $query );

			if ( empty( $results[ 'success' ] ) ) {

				wp_send_json_error();

			} else if ( ! empty( $results[ 'response' ][ 'totalSize' ] ) ) {

				$record_values = $results[ 'response' ][ 'records' ][ 0 ];

				$field_values = array(
					array( 'field_id' => $required_fields_ids[ 'Id' ], 'value' => $record_values[ 'Id' ] )
				);

				foreach ( $other_field_ids as $salesforce_field_name => $form_field_id ) {

					$field_values[] = array(
						'field_id' => $form_field_id,
						'value'    => $record_values[ $salesforce_field_name ]
					);
				}

				wp_send_json_success( array(
					'field_values'   => $field_values,
					'trigger_change' => true
				) );

			}

		}

	}

}
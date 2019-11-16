<?php
/**
 * @package   GFP_Dynamic_Population_Date
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     2.0.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_Date
 *
 * Dynamically populate dates
 *
 * @since  2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Date {

	/**
	 * GFP_Dynamic_Population_Date constructor.
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		add_filter( 'gfp_dynamic_population_sources', array( $this, 'gfp_dynamic_population_sources' ), 100 );


		add_filter( 'gform_' . GFP_DYNAMIC_POPULATION_SLUG . '_feed_settings_fields', array( $this, 'feed_settings_fields' ), 10, 2 );


		add_filter( 'gfp_dynamic_population_get_setting', array( $this, 'gfp_dynamic_population_get_setting' ), 10, 4 );


		add_action( 'gform_enqueue_scripts', array( $this, 'gform_enqueue_scripts' ), 10, 2 );


		add_filter( 'gfp_dynamic_population_dynamic_value_field_source_settings', array( $this, 'gfp_dynamic_population_dynamic_value_field_source_settings' ), 10, 4 );

		add_filter( 'gfp_dynamic_population_form_display_populate_field_value', array( $this, 'gfp_dynamic_population_form_display_populate_field_value' ), 10, 5 );

		add_filter( 'gfp_dynamic_population_form_display_get_dynamic_field_value', array( $this, 'gfp_dynamic_population_form_display_get_dynamic_field_value' ), 10, 6 );

	}

	/**
	 * @since  2.0.0
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

		if ( ( 'field' == $object && 'date' == $field_to_populate_type ) ) {

			$sources = array( 'date' => __( 'Date', 'gravityplus-dynamic-population' ) );

		}


		return $sources;

	}

	/**
	 * @since 2.0.0
	 *
	 * @param $scripts
	 * @param $settings
	 * @param $addon_object
	 *
	 * @return array
	 */
	public function gfp_dynamic_population_scripts( $scripts, $settings, $addon_object ) {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET[ 'gform_debug' ] ) ? '' : '.min';

		$filter_options = array(
			array(
				'value' => '',
				'text'  => ''
			),
		);

		$scripts[] =
			array(
				'handle'    => 'gfp_dynamic_population_date_admin',
				'src'       => GFP_DYNAMIC_POPULATION_URL . "/includes/sources/date/js/admin{$suffix}.js",
				'version'   => GFP_DYNAMIC_POPULATION_CURRENT_VERSION,
				'deps'      => array( 'jquery', 'gform_form_admin', 'gfp_dynamic_population_admin' ),
				'in_footer' => false,
				'enqueue'   => array(
					array(
						'admin_page' => array( 'form_settings' ),
						'tab'        => array( 'gravityplus-dynamic-population' )
					),
				),
				'strings'   => array(
					'filter_options' => $filter_options,
				)
			);


		return $scripts;
	}

	/**
	 * Add feed options
	 *
	 * @since  2.0.0
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

		$feed_settings_fields[ 'section_object' ][ 'fields' ][ 1 ][ 'args' ][ 'field_types' ] = array_merge( $feed_settings_fields[ 'section_object' ][ 'fields' ][ 1 ][ 'args' ][ 'field_types' ], array( 'date' ) );


		$source = $addon_object->get_setting( 'source' );

		if ( 'date' == $source ) {

			$field_to_populate = GFP_Dynamic_Population_Addon::get_instance()->get_setting( 'field_to_populate' );

			$args = empty( $field_to_populate ) ? array() : array( 'exclude_ids' => array( $field_to_populate ) );

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'               => __( 'Default Value', 'gravityplus-dynamic-population' ),
				'type'                => 'relative_date',
				'callback'            => 'GFP_Dynamic_Population_Date::settings_relative_date',
				'validation_callback' => 'GFP_Dynamic_Population_Date::validate_relative_date_settings',
				'name'                => 'source_date_value',
				'required'            => false,
				'dependency'          => array( 'field' => 'source', 'values' => array( 'date' ) ),
				'args'                => $args
			);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'               => __( 'Date Picker Minimum', 'gravityplus-dynamic-population' ),
				'tooltip'             => '<h6>' . __( 'Date Picker Minimum', 'gravityplus-dynamic-population' ) . '</h6>' . __( 'Minimum date allowed in date picker', 'gravityplus-dynamic-population' ),
				'type'                => 'relative_date',
				'callback'            => 'GFP_Dynamic_Population_Date::settings_relative_date',
				'validation_callback' => 'GFP_Dynamic_Population_Date::validate_relative_date_settings',
				'name'                => 'source_date_min',
				'required'            => false,
				'dependency'          => array( 'field' => 'source', 'values' => array( 'date' ) ),
				'args'                => $args
			);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'               => __( 'Date Picker Maximum', 'gravityplus-dynamic-population' ),
				'tooltip'             => '<h6>' . __( 'Date Picker Maximum', 'gravityplus-dynamic-population' ) . '</h6>' . __( 'Maximum date allowed in date picker', 'gravityplus-dynamic-population' ),
				'type'                => 'relative_date',
				'callback'            => 'GFP_Dynamic_Population_Date::settings_relative_date',
				'validation_callback' => 'GFP_Dynamic_Population_Date::validate_relative_date_settings',
				'name'                => 'source_date_max',
				'required'            => false,
				'dependency'          => array( 'field' => 'source', 'values' => array( 'date' ) ),
				'args'                => $args
			);

			unset( $feed_settings_fields[ 'section_options' ] );

			unset( $feed_settings_fields[ 'section_filter' ] );

		}


		return $feed_settings_fields;
	}

	/**
	 * Get type of field chosen for population
	 *
	 * TODO I don't think this is actually used anywhere
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function get_field_to_populate_type() {

		$form_id = rgpost( 'form_id' );

		$field_id = rgpost( 'field_id' );

		parse_str( rgpost( 'form' ), $_POST );


		$type = GFAPI::get_field( GFAPI::get_form( $form_id ), $field_id )->type;


		if ( empty( $type ) ) {

			wp_send_json_error();

		} else {

			$_POST[ '_gaddon_setting_field_to_populate_type' ] = $type;

			$sources = ( 'date' == $type ) ? "<option value=''>" . __( 'Select source' ) . "</option><option value='date'>" . __( 'Date', 'gravityplus-dynamic-population' ) . "</option>" : $this->get_select_options( $this->get_source_choices(), '' );

			wp_send_json_success( array( 'field_type' => $type, 'sources' => $sources ) );

		}

	}

	/**
	 * Return setting value for a relative date field type
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $value
	 * @param $setting_name
	 * @param $default_value
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function gfp_dynamic_population_get_setting( $value, $setting_name, $default_value, $settings ) {

		if ( in_array( $setting_name, array( 'source_date_value', 'source_date_min', 'source_date_max' ) ) ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			if ( ! $settings ) {

				$settings = $addon_object->get_current_settings();

			}

			if ( false === $settings ) {

				return $default_value;

			}


			$day = rgar( $settings, "{$setting_name}_day" );

			$operation = rgar( $settings, "{$setting_name}_operation" );

			$number = rgar( $settings, "{$setting_name}_number" );

			$unit = rgar( $settings, "{$setting_name}_unit" );


			if ( ! empty( $day ) && ! empty( $operation ) && ! rgblank( $number ) && ! empty( $unit ) ) {

				$value = "{$day} {$operation} {$number} {$unit}";

			}

		}


		return $value;
	}

	/**
	 * Relative date field
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param      $field
	 * @param bool $echo
	 *
	 * @return string
	 */
	public static function settings_relative_date( $field, $echo = true ) {

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();


		$date_fields = $addon_object->get_form_fields_as_choices( $addon_object->get_current_form(), array_merge( array( 'field_types' => array( 'date' ) ), empty( $field['args'] ) ? array() : $field['args'] ) );

		$relative_days = array(
			array( 'label' => esc_html__( 'today', 'gravityforms' ), 'value' => 'today' ),
			array( 'label' => esc_html__( 'yesterday', 'gravityforms' ), 'value' => 'yesterday' ),
			array( 'label' => esc_html__( 'tomorrow', 'gravityforms' ), 'value' => 'tomorrow' ),
		);

		$day_field = array(
			'name'    => "{$field['name']}_day",
			'type'    => 'select',
			'choices' => array_merge( $relative_days, $date_fields )
		);


		$operations = array(
			array( 'label' => esc_html__( '+', 'gravityforms' ), 'value' => '+' ),
			array( 'label' => esc_html__( '-', 'gravityforms' ), 'value' => '-' )
		);

		$operation_field = array(
			'name'    => "{$field['name']}_operation",
			'type'    => 'select',
			'choices' => $operations
		);


		$number_field = array(
			'type'          => 'text',
			'input_type'    => 'number',
			'name'          => "{$field['name']}_number",
			'min'           => 0,
			'max'           => 100,
			'default_value' => 0,
			'required'      => true
		);


		$units = array(
			array( 'label' => esc_html__( 'day(s)', 'gravityforms' ), 'value' => 'days' ),
			array( 'label' => esc_html__( 'week(s)', 'gravityforms' ), 'value' => 'weeks' ),
			array( 'label' => esc_html__( 'month(s)', 'gravityforms' ), 'value' => 'months' ),
			array( 'label' => esc_html__( 'year(s)', 'gravityforms' ), 'value' => 'years' )
		);

		$unit_field = array(
			'name'    => "{$field['name']}_unit",
			'type'    => 'select',
			'choices' => $units
		);


		$html = $addon_object->settings_select( $day_field, false );

		$html .= '&nbsp' . $addon_object->settings_select( $operation_field, false );

		$html .= '&nbsp' . $addon_object->settings_text( $number_field, false );

		$html .= '&nbsp' . $addon_object->settings_select( $unit_field, false );


		if ( $echo ) {

			echo $html;

		}

		return $html;
	}

	/**
	 * Validate settings for relative date field
	 *
	 * @see    GFAddOn::validate_settings
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 */
	public static function validate_relative_date_settings( $field ) {

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		$submitted_value = $addon_object->get_setting( $field[ 'name' ] );

		if ( rgar( $field, 'required' ) && rgblank( $submitted_value ) ) {

			$addon_object->set_field_error( $field, '' == rgar( $field, 'error_message' ) ? $field[ 'label' ] . __( 'is required.', 'gravityplus-dynamic-population' ) : $field[ 'error_message' ] );

		}

	}

	/**
	 * Add JS for dynamic date population
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array|null $form
	 * @param null       $ajax
	 */
	public function gform_enqueue_scripts( $form = null, $ajax = null ) {

		if ( ! is_admin() && ! empty( $form ) && GFP_Dynamic_Population_API::has_dynamic_value_field( $form, 'date' ) ) {

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET[ 'gform_debug' ] ) ? '' : '.min';

			wp_enqueue_script( 'gfp_dynamic_date', trailingslashit( GFP_DYNAMIC_POPULATION_URL ) . "includes/sources/date/js/dynamic-values{$suffix}.js", array(
				'jquery'
			) );

		}

	}

	/**
	 * Date source settings
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array    $dynamic_choice_settings
	 * @param string   $source
	 * @param array    $feed
	 * @param GF_Field $field
	 *
	 * @return array
	 */
	public function gfp_dynamic_population_dynamic_value_field_source_settings( $dynamic_source_settings, $source, $feed, $field ) {

		if ( 'date' == $source ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$date_settings = array(
				'value'      => array(
					'day'       => $addon_object->get_setting( 'source_date_value_day', '', $feed[ 'meta' ] ),
					'operation' => $addon_object->get_setting( 'source_date_value_operation', '', $feed[ 'meta' ] ),
					'number'    => $addon_object->get_setting( 'source_date_value_number', '', $feed[ 'meta' ] ),
					'unit'      => $addon_object->get_setting( 'source_date_value_unit', '', $feed[ 'meta' ] )
				),
				'min'        => array(
					'day'       => $addon_object->get_setting( 'source_date_min_day', '', $feed[ 'meta' ] ),
					'operation' => $addon_object->get_setting( 'source_date_min_operation', '', $feed[ 'meta' ] ),
					'number'    => $addon_object->get_setting( 'source_date_min_number', '', $feed[ 'meta' ] ),
					'unit'      => $addon_object->get_setting( 'source_date_min_unit', '', $feed[ 'meta' ] )
				),
				'max'        => array(
					'day'       => $addon_object->get_setting( 'source_date_max_day', '', $feed[ 'meta' ] ),
					'operation' => $addon_object->get_setting( 'source_date_max_operation', '', $feed[ 'meta' ] ),
					'number'    => $addon_object->get_setting( 'source_date_max_number', '', $feed[ 'meta' ] ),
					'unit'      => $addon_object->get_setting( 'source_date_max_unit', '', $feed[ 'meta' ] )
				),
				'field_type' => $field->type,
				'input_type' => $field->dateType,
				'format'     => empty( $field->dateFormat ) ? 'mdy' : $field->dateFormat,
				'dependees'  => array()
			);

			if ( is_numeric( $date_settings[ 'value' ][ 'day' ] ) && ! in_array( $date_settings[ 'value' ][ 'day' ], $date_settings[ 'dependees' ] ) ) {

				$value_dependee_field_id = $date_settings[ 'value' ][ 'day' ];

				$value_dependee_field = GFAPI::get_field( $feed[ 'form_id' ], $value_dependee_field_id );

				$date_settings[ 'dependees' ][ $value_dependee_field_id ] = array(
					'field_id'   => $value_dependee_field_id,
					'field_type' => $value_dependee_field->type,
					'input_type' => $value_dependee_field->dateType,
					'format'     => empty( $value_dependee_field->dateFormat ) ? 'mdy' : $value_dependee_field->dateFormat
				);

			}

			if ( is_numeric( $date_settings[ 'min' ][ 'day' ] ) && ! in_array( $date_settings[ 'min' ][ 'day' ], $date_settings[ 'dependees' ] ) ) {

				$min_dependee_field_id = $date_settings[ 'min' ][ 'day' ];

				$min_dependee_field = GFAPI::get_field( $feed[ 'form_id' ], $min_dependee_field_id );

				$date_settings[ 'dependees' ][ $min_dependee_field_id ] = array(
					'field_id'   => $min_dependee_field_id,
					'field_type' => $min_dependee_field->type,
					'input_type' => $min_dependee_field->dateType,
					'format'     => empty( $min_dependee_field->dateFormat ) ? 'mdy' : $min_dependee_field->dateFormat
				);

			}

			if ( is_numeric( $date_settings[ 'max' ][ 'day' ] ) && ! in_array( $date_settings[ 'max' ][ 'day' ], $date_settings[ 'dependees' ] ) ) {

				$max_dependee_field_id = $date_settings[ 'max' ][ 'day' ];

				$max_dependee_field = GFAPI::get_field( $feed[ 'form_id' ], $max_dependee_field_id );

				$date_settings[ 'dependees' ][ $max_dependee_field_id ] = array(
					'field_id'   => $max_dependee_field_id,
					'field_type' => $max_dependee_field->type,
					'input_type' => $max_dependee_field->dateType,
					'format'     => empty( $max_dependee_field->dateFormat ) ? 'mdy' : $max_dependee_field->dateFormat
				);

			}


			$dynamic_source_settings = array_merge( $dynamic_source_settings, $date_settings );
		}


		return $dynamic_source_settings;
	}

	/**
	 * Get date values to dynamically populate
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $dynamic_value_info
	 * @param array $filters
	 *
	 * @return array
	 */
	private function get_date_values( $dynamic_value_info, $filters ) {

		$date_values = array( 'value' => '', 'min' => '', 'max' => '' );


		$value_day = $this->get_date_value( $dynamic_value_info[ 'value' ], $dynamic_value_info[ 'format' ], $dynamic_value_info[ 'dependees' ] );

		if ( ! empty( $value_day[ 'value' ] ) ) {

			$php_format = $this->convert_gf_to_php_date_format( $value_day[ 'new_format' ] );

			$date_string = "{$value_day['value']} {$dynamic_value_info['value']['operation']} {$dynamic_value_info['value']['number']} {$dynamic_value_info['value']['unit']}";

			$date_values[ 'value' ] = GFCommon::date_display( $this->format_date( $date_string, $php_format ), $value_day[ 'new_format' ], $value_day[ 'original_format' ] );

		}


		$min_day = $this->get_date_value( $dynamic_value_info[ 'min' ], $dynamic_value_info[ 'format' ], $dynamic_value_info[ 'dependees' ] );

		if ( ! empty( $min_day[ 'value' ] ) ) {

			$php_format = $this->convert_gf_to_php_date_format( $min_day[ 'new_format' ] );

			$date_string = "{$min_day['value']} {$dynamic_value_info['min']['operation']} {$dynamic_value_info['min']['number']} {$dynamic_value_info['min']['unit']}";

			$date_values[ 'min' ] = GFCommon::date_display( $this->format_date( $date_string, $php_format ), $min_day[ 'new_format' ], $min_day[ 'original_format' ] );

		}


		$max_day = $this->get_date_value( $dynamic_value_info[ 'max' ], $dynamic_value_info[ 'format' ], $dynamic_value_info[ 'dependees' ] );

		if ( ! empty( $max_day[ 'value' ] ) ) {

			$php_format = $this->convert_gf_to_php_date_format( $max_day[ 'new_format' ] );

			$date_string = "{$max_day['value']} {$dynamic_value_info['max']['operation']} {$dynamic_value_info['max']['number']} {$dynamic_value_info['max']['unit']}";

			$date_values[ 'max' ] = GFCommon::date_display( $this->format_date( $date_string, $php_format ), $max_day[ 'new_format' ], $max_day[ 'original_format' ] );

		}


		return $date_values;

	}

	/**
	 * @since    2.0.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $date_info
	 * @param $dependee_fields
	 *
	 * @return mixed|string
	 */
	private function get_date_value( $date_info, $format, $dependee_fields ) {

		$date = array(
			'value'           => $date_info[ 'day' ],
			'original_format' => $format,
			'new_format'      => $format
		);

		if ( is_numeric( $date[ 'value' ] ) ) {

			$date_field_id = $date[ 'value' ];

			if ( ! empty( $dependee_fields[ $date_field_id ][ 'value' ] ) ) {

				$dependee_field_date = $dependee_fields[ $date_field_id ][ 'value' ];

				$dependee_field_format = $dependee_fields[ $date_field_id ][ 'format' ];

				if ( in_array( $dependee_field_format, array( 'dmy', 'ymd_dot' ) ) ) {

					$new_format = ( 'dmy' == $dependee_field_format ) ? 'dmy_dash' : 'ymd_dash';

					$date = array(
						'value'           => GFCommon::date_display( $dependee_field_date, $dependee_field_format, $new_format ),
						'original_format' => $dependee_field_format,
						'new_format'      => $new_format
					);

				} else {

					$date = array(
						'value'           => $dependee_field_date,
						'original_format' => $dependee_field_format,
						'new_format'      => $dependee_field_format
					);

				}

			}

		} else {

			if ( in_array( $format, array( 'dmy', 'ymd_dot' ) ) ) {

				$new_format = ( 'dmy' == $format ) ? 'dmy_dash' : 'ymd_dash';

				$date[ 'value' ] = GFCommon::date_display( $date, $format, $new_format );

				$date[ 'new_format' ] = $new_format;

			}

		}


		return $date;
	}

	/**
	 * @see      RGFormsModel::get_date_range_where
	 *
	 * @since    2.0.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $date
	 *
	 * @return string
	 */
	private function format_date( $date, $format ) {

		$datetime_obj = new DateTime( $date );

		$date_str = $datetime_obj->format( $format );

		//$datetime = DateTime::createFromFormat($format, $date);

		$formatted_date = get_gmt_from_date( $date_str, $format );


		return $formatted_date;
	}

	/**
	 * Convert GF date format to PHP date format
	 *
	 * @since    2.0.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $gf_format
	 *
	 * @return string
	 */
	private function convert_gf_to_php_date_format( $gf_format ) {

		switch ( $gf_format ) {

			case 'mdy' :

				$php_format = 'm/d/Y';

				break;

			case 'dmy' :

				$php_format = 'd/m/Y';

				break;

			case 'dmy_dash' :

				$php_format = 'd-m-Y';

				break;

			case 'dmy_dot' :

				$php_format = 'd.m.Y';

				break;

			case 'ymd_slash' :

				$php_format = 'Y/m/d';

				break;

			case 'ymd_dash' :

				$php_format = 'Y-m-d';

				break;

			case 'ymd_dot' :

				$php_format = 'Y.m.d';

				break;
		}

		return $php_format;
	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $options
	 * @param $form
	 * @param $field_id
	 * @param $dynamic_value_info
	 * @param $field_values
	 * @param $get_from_post
	 *
	 * @return array
	 */
	public function gfp_dynamic_population_form_display_populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, $get_from_post ) {

		if ( 'date' == $dynamic_value_info[ 'source' ] ) {

			//get_dependee_field_values
			foreach ( $dynamic_value_info[ 'dependees' ] as $dependee_field_id => $dependee_field_info ) {

				$dependee_field = GFFormsModel::get_field( $form, $dependee_field_id );

				if ( ! empty( $dependee_field ) ) {

					if ( $get_from_post ) {

						$dependee_field_value = GFFormsModel::get_field_value( $dependee_field, $field_values );

					} else {

						$dependee_field_value = $dependee_field->get_value_default();

					}

					if ( ! empty( $dependee_field_value ) ) {

						$dynamic_value_info[ 'dependees' ][ $dependee_field_id ][ 'value' ] = $dependee_field_value;

					}

				}

			}

			$date_values = $this->get_date_values( $dynamic_value_info, array() );

			foreach ( $form[ 'fields' ] as $key => $form_field ) {

				if ( $form_field[ 'id' ] == $field_id ) {

					$form[ 'fields' ][ $key ][ 'defaultValue' ] = rgar( $date_values, 'value' );

					if ( ! empty( $date_values[ 'min' ] ) || ! empty( $date_values[ 'max' ] ) ) {

						$form[ 'fields' ][ $key ][ 'limitDateRange' ] = true;

						$form[ 'fields' ][ $key ][ 'limitDateRangeMinDate' ] = rgar( $date_values, 'min' );

						$form[ 'fields' ][ $key ][ 'limitDateRangeMaxDate' ] = rgar( $date_values, 'max' );

					}


					break;
				}

			}

		}

		return $form;
	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $values
	 * @param $source
	 * @param $dynamic_value_source_settings
	 * @param $form
	 * @param $field
	 *
	 * @return mixed
	 */
	public function gfp_dynamic_population_form_display_get_dynamic_field_value( $value, $source, $dynamic_value_source_settings, $form, $field, $dependees ) {

		if ( 'date' == $source ) {

			$dependee_field_values = rgpost( 'dependees' );

			foreach ( $dependee_field_values as $field_value ) {

				$dynamic_value_source_settings[ 'dependees' ][ $field_value[ 'field_id' ] ][ 'value' ] = $field_value[ 'value' ];

			}

			$value = $this->get_date_values( $dynamic_value_source_settings, array() );

		}


		return $value;
	}

}
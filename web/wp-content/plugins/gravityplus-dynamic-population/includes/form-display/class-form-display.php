<?php
/**
 * @package   GFP_Dynamic_Population
 * @copyright 2014-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.0.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_Form_Display
 *
 * Displays dynamic choice options when form is displayed
 *
 * @since  1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Form_Display {

	/**
	 * GFP_Dynamic_Population_Form_Display constructor.
	 *
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		add_filter( 'gform_pre_render', array( $this, 'gform_pre_render' ), 10, 3 );

		add_action( 'gform_enqueue_scripts', array( $this, 'gform_enqueue_scripts' ), 10, 2 );

		add_action( 'wp_ajax_nopriv_gfp_get_dynamic_choices', array( $this, 'gfp_get_dynamic_choices' ) );

		add_action( 'wp_ajax_gfp_get_dynamic_choices', array( $this, 'gfp_get_dynamic_choices' ) );

		add_action( 'wp_ajax_nopriv_gfp_get_dynamic_field_value', array( $this, 'gfp_get_dynamic_field_value' ) );

		add_action( 'wp_ajax_gfp_get_dynamic_field_value', array( $this, 'gfp_get_dynamic_field_value' ) );

		//WPDB source
		add_filter( 'gfp_dynamic_population_dynamic_value_field_source_settings', array( $this, 'gfp_dynamic_population_dynamic_value_field_source_settings' ), 10, 4 );

		add_filter( 'gfp_dynamic_population_form_display_populate_field_value', array( $this, 'gfp_dynamic_population_form_display_populate_field_value' ), 10, 5 );

		add_filter( 'gfp_dynamic_population_form_display_get_dynamic_field_value', array( $this, 'gfp_dynamic_population_form_display_get_dynamic_field_value' ), 10, 6 );
	}

	/**
	 * Add JS for dynamic choice filtering and dynamic value population
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array|null $form
	 * @param null       $ajax
	 */
	public function gform_enqueue_scripts( $form = null, $ajax = null ) {

		if ( ! is_admin() /*TODO test if this works with GFlow */ && ! empty( $form ) ) {

			$dynamic_choice_fields = array();

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			if ( $addon_object->has_feed( $form[ 'id' ] ) || GFP_Dynamic_Population_API::has_dynamic_choice_field( $form ) ) {

				$dynamic_choice_fields = GFP_Dynamic_Population_API::get_dynamic_choice_fields( $form );

				$dynamic_value_fields = GFP_Dynamic_Population_API::get_dynamic_value_fields( $form );

				$protocol = isset ( $_SERVER[ "HTTPS" ] ) ? 'https://' : 'http://';

				$ajaxurl = admin_url( 'admin-ajax.php', $protocol );

				$spinner_url = apply_filters( "gform_ajax_spinner_url_{$form['id']}", apply_filters( "gform_ajax_spinner_url", GFCommon::get_base_url() . "/images/spinner.gif", $form ), $form );

				$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET[ 'gform_debug' ] ) ? '' : '.min';

			}

			if ( ! empty( $dynamic_choice_fields ) ) {

				$dynamic_choice_fields = array_values( $dynamic_choice_fields );

				foreach ( $dynamic_choice_fields as $key => $dynamic_choice_field_info ) {

					if ( ! empty( $dynamic_choice_field_info[ 'filtered_by' ] ) ) {

						$dynamic_choice_fields[ $key ][ 'filtered_by' ] = array_values( $dynamic_choice_field_info[ 'filtered_by' ] );

					}

				}

				wp_enqueue_script( 'gfp_dynamic_choices', trailingslashit( GFP_DYNAMIC_POPULATION_URL ) . "includes/form-display/js/dynamic-choices{$suffix}.js", array( 'jquery' ), GFP_DYNAMIC_POPULATION_CURRENT_VERSION );

				wp_localize_script( 'gfp_dynamic_choices', 'gfp_dynamic_choices', array(
					'field_info'  => $dynamic_choice_fields,
					'form_id'     => $form[ 'id' ],
					'ajaxurl'     => $ajaxurl,
					'spinner_url' => $spinner_url,
					'generating_options_message' => __( 'Generating options', 'gravityplus-dynamic-population')
				) );

			}

			if ( ! empty( $dynamic_value_fields ) ) {

				$dynamic_value_fields = array_values( $dynamic_value_fields );

				$dependees = array();

				foreach ( $dynamic_value_fields as $key => $dynamic_value_field_info ) {

					if ( ! empty( $dynamic_value_field_info[ 'dependees' ] ) ) {

						foreach ( $dynamic_value_field_info[ 'dependees' ] as $dependee_field_id => $dependee_info ) {

							if ( empty( $dependees[ $dependee_field_id ] ) ) {

								if ( empty( $dependee_info['field_type'] ) ) {

									continue;
								}

								$dependees[ $dependee_field_id ] = array( 'field_type' => $dependee_info['field_type'], 'dependents' => array() );

							}

							if( ! in_array( $dynamic_value_field_info[ 'field_id' ], $dependees[ $dependee_field_id ]['dependents'] ) ) {

								$dependees[ $dependee_field_id ]['dependents'][] = $dynamic_value_field_info[ 'field_id' ];

							}

						}

						$dynamic_value_fields[ $key ][ 'dependees' ] = array_values( $dynamic_value_field_info[ 'dependees' ] );

					}

				}

				if ( ! empty( $dependees ) ) {

					wp_enqueue_script( 'gfp_dynamic_values', trailingslashit( GFP_DYNAMIC_POPULATION_URL ) . "includes/form-display/js/dynamic-values{$suffix}.js", array( 'jquery' ), GFP_DYNAMIC_POPULATION_CURRENT_VERSION );

					wp_localize_script( 'gfp_dynamic_values', 'gfp_dynamic_values', array(
						'field_info'                 => $dynamic_value_fields,
						'dependees'                  => $dependees,
						'form_id'                    => $form[ 'id' ],
						'ajaxurl'                    => $ajaxurl,
						'spinner_url'                => $spinner_url,
						'generating_options_message' => __( 'Generating options', 'gravityplus-dynamic-population' )

					) );

				}

			}

		}
	}

	/**
	 * Populate options
	 *
	 * If options need to be filtered, simply use placeholder
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $form
	 * @param       $ajax
	 *
	 * @return array
	 */
	public function gform_pre_render( $form, $ajax, $field_values ) {

		$dynamic_choice_fields = $dynamic_value_fields = array();

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		if ( $addon_object->has_feed( $form[ 'id' ] ) || GFP_Dynamic_Population_API::has_dynamic_choice_field( $form ) ) {

			$dynamic_choice_fields = GFP_Dynamic_Population_API::get_dynamic_choice_fields( $form );

			$dynamic_value_fields = GFP_Dynamic_Population_API::get_dynamic_value_fields( $form );

		}

		foreach ( $dynamic_choice_fields as $field_id => $dynamic_choice_info ) {

			if ( empty( $dynamic_choice_info[ 'filtered_by' ] ) || $this->has_preselected_choice( $dynamic_choice_info[ 'filtered_by' ], $form ) ) {

				$form = $this->populate_options( $form, $field_id, $dynamic_choice_info, $field_values, false );

			} else {

				$submitted_field_value = '';

				$field = GFFormsModel::get_field( $form, $field_id );

				if ( empty( $field_values ) ) {

					$field_values = $this->set_field_values( $field_values );

				}

				if ( ! empty( $field ) ) {

					$submitted_field_value = GFFormsModel::get_field_value( $field, $field_values );

					if ( ( '' == $submitted_field_value ) && ! empty( $field_values ) ) {

						$submitted_field_value = GF_Fields::get( 'select' )->get_value_export( $field_values, $field_id );

					}

				}

				if ( '' == $submitted_field_value ) {

					if ( empty( $dynamic_choice_info[ 'placeholder' ] ) ) {

						$placeholder = array(
							array(
								'text'       => __( 'Select', 'gravityplus-dynamic-population' ),
								'value'      => '',
								'isSelected' => true,
								'price'      => ''
							)
						);

					} else {

						$placeholder = array( $dynamic_choice_info[ 'placeholder' ] );

					}

					foreach ( $form[ 'fields' ] as $key => $form_field ) {

						if ( $form_field[ 'id' ] == $field_id ) {

							$form[ 'fields' ][ $key ][ 'choices' ] = $placeholder;

							break;
						}
					}
				} else {

					$form = $this->populate_options( $form, $field_id, $dynamic_choice_info, $field_values );

				}

			}
		}

		foreach ( $dynamic_value_fields as $field_id => $dynamic_value_info ) {

			if ( empty( $dynamic_value_info[ 'dependees' ] )
			     || $this->field_has_default_value( $dynamic_value_info[ 'dependees' ], $form )
			     || $this->field_filters_are_custom_values( $dynamic_value_info[ 'dependees' ] )
				/*TODO or this field is dynamically populated from URL*/ ) {

				$form = $this->populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, false );

			} else {

				$submitted_field_value = '';

				$field = GFFormsModel::get_field( $form, $field_id );

				if ( empty( $field_values ) ) {

					$field_values = $this->set_field_values( $field_values );

				}

				if ( ! empty( $field ) ) {

					$submitted_field_value = GFFormsModel::get_field_value( $field, $field_values );

					if ( ( '' == $submitted_field_value || null == $submitted_field_value ) && ! empty( $field_values ) ) {

						$submitted_field_value = GF_Fields::get( $dynamic_value_info[ 'field_type' ] )->get_value_export( $field_values, $field_id );

					}

				}

				if ( ( '' == $submitted_field_value || null !== $submitted_field_value ) && in_array( $field->type, array( 'select', 'checkbox', 'radio', 'multiselect' ) ) ) {

						$placeholder = empty( $dynamic_value_info[ 'placeholder' ] ) ? array(
							array(
								'text'       => __( 'Select', 'gravityplus-dynamic-population' ),
								'value'      => '',
								'isSelected' => true,
								'price'      => ''
							)
						) : array( $dynamic_value_info[ 'placeholder' ] );

					foreach ( $form[ 'fields' ] as $key => $form_field ) {

						if ( $form_field[ 'id' ] == $field_id ) {

							$form[ 'fields' ][ $key ][ 'choices' ] = $placeholder;

							break;
						}
					}

				}
				else {

					$form = $this->populate_field_value( $form, $field_id, $dynamic_value_info, $field_values );

				}

			}

		}


		return $form;
	}

	/**
	 * @since 1.6.0
	 *
	 * @param $field_values
	 *
	 * @return array|null
	 */
	private function set_field_values( $field_values ) {

		if ( rgget( 'view' ) == 'entry' || ! empty( $args[ 'entry_id' ] ) ) {

			$entry_id = absint( rgget( 'lid' ) );

			if ( empty( $entry_id ) ) {

				$entry_id = absint( $args[ 'entry_id' ] );

			}

			$entry = GFAPI::get_entry( $entry_id );

			if ( ! is_wp_error( $entry ) ) {

				$field_values = $entry;

			}

		}


		return $field_values;
	}

	/**
	 * See if filter(s) on this field have predetermined choice
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $filters
	 * @param array $form
	 *
	 * @return bool
	 */
	private function has_preselected_choice( $filters, $form ) {

		$has_preselected_choice = false;

		$filter_field_ids = array_keys( $filters );

		foreach ( $filter_field_ids as $filter_field_id ) {

			$field = GFFormsModel::get_field( $form, $filter_field_id );

			if ( ! empty( $field ) ) {

				$has_preselected_choice = GFP_Dynamic_Population_API::has_preselected_choice( $field );

				if ( ! $has_preselected_choice ) {

					break;

				}

			} else {

				$has_preselected_choice = false;

				break;
			}

		}

		return $has_preselected_choice;
	}

	/**
	 * See if the fields this field depends on has a default value
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $dependee_fields
	 * @param array $form
	 *
	 * @return bool
	 */
	private function field_has_default_value( $dependee_fields, $form ) {

		$has_default_value = false;

		$depending_field_ids = array_keys( $dependee_fields );

		foreach ( $depending_field_ids as $field_id ) {

			$field = GFFormsModel::get_field( $form, $field_id );

			if ( empty( $field ) ) {

				$has_default_value = false;

				break;
			}


			$has_default_value = GFP_Dynamic_Population_API::has_default_value( $field );

			if ( ( ! $has_default_value ) && in_array( $field->type, array( 'select', 'checkbox', 'radio', 'multiselect' ) ) ) {

				$has_default_value = GFP_Dynamic_Population_API::has_preselected_choice( $field );

			}

				if ( ! $has_default_value ) {

					break;

				}

		}

		return $has_default_value;
	}

	/**
	 * See if the fields this field depends on are custom values
	 *
	 * @since  2.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $dependee_fields
	 *
	 * @return bool
	 */
	private function field_filters_are_custom_values( $dependee_fields ) {

		foreach ( $dependee_fields as $rule ) {

			if ( 'custom' !== $rule['field_type'] ) {

				return false;
			}

		}

		return true;
	}

	/**
	 * Populate field choices with custom data
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array  $form
	 * @param string $field_id
	 * @param array  $dynamic_choice_info
	 * @param array  $field_values
	 * @param bool   $get_from_post Whether to get the value from the $_POST array as opposed to $field_values
	 *
	 * @return array
	 */
	private function populate_options( $form, $field_id, $dynamic_choice_info, $field_values, $get_from_post = true ) {

		$options = array();

		if ( ! empty( $dynamic_choice_info[ 'placeholder' ] ) ) {

			$options[] = $dynamic_choice_info[ 'placeholder' ];

		}

		switch ( $dynamic_choice_info[ 'source' ] ) {

			case 'wpdb':

				if ( empty( $dynamic_choice_info[ 'filtered_by' ] ) ) {

					$where_rules = array();

				} else {

					foreach ( $dynamic_choice_info[ 'filtered_by' ] as $filter ) {

						$field = GFFormsModel::get_field( $form, $filter[ 'field_id' ] );

						if ( ! empty( $field ) ) {

							if ( $get_from_post ) {

								$value = GFFormsModel::get_field_value( $field, $field_values );

							} else {

								$value = GFP_Dynamic_Population_API::get_preselected_choice( $field );

							}

							if ( ! empty( $value ) ) {

								$where_rules[] = array(
									'column'   => $filter[ 'column' ],
									'value'    => $value,
									'operator' => $filter[ 'operator' ]
								);

							}

						}

					}
				}

				$values = GFP_Dynamic_Population_Custom_Data::get_column_values( $dynamic_choice_info[ 'table' ], $dynamic_choice_info[ 'column' ], $where_rules, $dynamic_choice_info[ 'sort_order' ], $dynamic_choice_info[ 'column_value' ] );

				foreach ( $values as $value ) {

					$options[] = array( 'text'       => $value[ 0 ],
					                    'value'      => empty( $value[ 1 ] ) ? $value[ 0 ] : $value[ 1 ],
					                    'isSelected' => false,
					                    'price'      => ''
					);

				}

				break;
		}


		$options = apply_filters( 'gfp_dynamic_population_form_display_populate_options', $options, $form, $field_id, $dynamic_choice_info, $field_values, $get_from_post );


		foreach ( $form[ 'fields' ] as $key => $form_field ) {

			if ( $form_field[ 'id' ] == $field_id ) {

				$form[ 'fields' ][ $key ][ 'choices' ] = $options;

				break;
			}

		}


		return $form;
	}

	/**
	 * Populate a field value
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array  $form
	 * @param string $field_id
	 * @param array  $dynamic_value_info
	 * @param array  $field_values
	 * @param bool   $get_from_post Whether to get the value from the $_POST array as opposed to $field_values
	 *
	 * @return array
	 */
	private function populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, $get_from_post = true ) {

		return apply_filters( 'gfp_dynamic_population_form_display_populate_field_value', $form, $field_id, $dynamic_value_info, $field_values, $get_from_post );

	}

	public function gfp_dynamic_population_dynamic_value_field_source_settings( $dynamic_source_settings, $source, $feed, $field ) {

		if ( 'wpdb' == $source ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$wpdb_settings = array(
				'table'        => $addon_object->get_setting( 'source_wpdb_table', '', $feed['meta'] ),
				'column'       => $addon_object->get_setting( 'source_wpdb_table_column', '', $feed['meta'] ),
				'column_value' => $addon_object->get_setting( 'source_wpdb_value_table_column', '', $feed['meta'] ),
				'sort_order'   => $addon_object->get_setting( 'sort_order', '', $feed['meta'] )
			);

			$dynamic_source_settings = array_merge( $dynamic_source_settings, $wpdb_settings );

		}


		return $dynamic_source_settings;
	}

	public function gfp_dynamic_population_form_display_populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, $get_from_post ) {

		if ( 'wpdb' == $dynamic_value_info[ 'source' ] ) {

			$where_rules = array();

			if ( ! empty( $dynamic_value_info[ 'dependees' ] ) ) {

				foreach ( $dynamic_value_info[ 'dependees' ] as $filter ) {

					$field = GFFormsModel::get_field( $form, $filter[ 'field_id' ] );

					if ( ! empty( $field ) ) {

						if ( $get_from_post ) {

							$field_value = GFFormsModel::get_field_value( $field, $field_values );

						} else {

							$field_value = GFP_Dynamic_Population_API::get_default_value( $field );

						}

						if ( ! empty( $field_value ) ) {

							$where_rules[] = array(
								'column'   => $filter[ 'column' ],
								'value'    => $field_value,
								'operator' => $filter[ 'operator' ]
							);

						}

					}

				}

			}

			$retrieved_values = GFP_Dynamic_Population_Custom_Data::get_column_values( $dynamic_value_info[ 'table' ], $dynamic_value_info[ 'column' ], $where_rules, $dynamic_value_info[ 'sort_order' ], $dynamic_value_info[ 'column_value' ] );

			if ( empty( $retrieved_values ) ) {

				return $form;

			}

			$field = GFAPI::get_field( $form, $field_id );

			switch( $field->type ) {

				case 'select':
				case 'radio':
				case 'checkbox':
				case 'multiselect':

				foreach ( $retrieved_values as $retrieved ) {

					$value[] = array( 'text'       => $retrieved[ 0 ],
					                    'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
					                    'isSelected' => false,
					                    'price'      => ''
					);

				}

				$property = 'choices';


					break;

				case 'html':

					$property = 'content';

					$value = esc_html( $retrieved_values[0][0] );


					break;

				default:

					$property = 'defaultValue';

					$value = $retrieved_values[0][0];

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
	 * Get dynamic choices for field
	 *
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gfp_get_dynamic_choices() {

		$form_id = rgpost( 'form_id' );

		$field_id = rgpost( 'field_id' );

		$feed_id = rgpost( 'feed_id' );

		$filters = rgpost( 'filters' );


		$form = GFAPI::get_form( $form_id );

		$field = RGFormsModel::get_field( $form, $field_id );

		if ( empty( $feed_id ) ) {

			$dynamic_choice_source_settings = GFP_Dynamic_Population_API::get_dynamic_choice_source_settings( $field );

			$source = GFP_Dynamic_Population_API::get_dynamic_choice_source( $field );

		} else {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$feed = $addon_object->get_feed( $feed_id );

			$dynamic_choice_source_settings = GFP_Dynamic_Population_API::get_dynamic_choice_source_settings( $feed, 'feed' );

			$source = GFP_Dynamic_Population_API::get_dynamic_choice_source( $feed, 'feed' );

		}


		$values = array();


		switch ( $source ) {

			case 'wpdb':

				$values = GFP_Dynamic_Population_Custom_Data::get_column_values( $dynamic_choice_source_settings[ 'table' ], $dynamic_choice_source_settings[ 'column' ], $filters, $dynamic_choice_source_settings[ 'sort_order' ], $dynamic_choice_source_settings[ 'column_value' ] );

				foreach ( $values as $value ) {

					$options[] = array( 'text'       => $value[ 0 ],
					                    'value'      => empty( $value[ 1 ] ) ? $value[ 0 ] : $value[ 1 ],
					                    'isSelected' => false,
					                    'price'      => ''
					);

				}

				$values = ( $options ) ? $options : '';

				break;
		}

		$values = apply_filters( 'gfp_dynamic_population_form_display_get_dynamic_choices_values', $values, $source, $dynamic_choice_source_settings, $form, $field, $filters );

		if ( empty( $values ) ) {

			wp_send_json_error();

		}

		$trigger_change = ( 1 < count( $values ) ) ? false : true;

		if ( empty( $field->placeholder ) && 'select' == $field->type ) {

			$field->__set( 'placeholder', __( 'Select', 'gravityplus-dynamic-population' ) );
		}

		$field->__set( 'choices', $values );


		switch( $field->type ) {

			case 'select':

				/**
				 * @var GF_Field_Select $field
				 */
				$options = $field->get_choices( $field->get_value_default_if_empty( '' ) );


				break;

			case 'multiselect':

				/**
				 * @var GF_Field_MultiSelect $field
				 */
				$options = $field->get_choices( $field->get_value_default_if_empty( '' ) );


				break;

			case 'radio':

				/**
				 * @var GF_Field_Radio $field
				 */
				$options = $field->get_radio_choices( $field->get_value_default_if_empty( '' ), '', $form_id );

				break;

			case 'checkbox':

				/**
				 * @var GF_Field_Checkbox $field
				 */

				$options = $field->get_checkbox_choices( $field->get_value_default_if_empty( '' ), '', $form_id );

				break;
		}

			wp_send_json_success( array(
				'options'        => $options,
				'trigger_change' => $trigger_change
			) );


	}

	/**
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

		if ( 'wpdb' == $source ) {

			$retrieved_values = GFP_Dynamic_Population_Custom_Data::get_column_values( $dynamic_value_source_settings[ 'table' ], $dynamic_value_source_settings[ 'column' ], $dependees, $dynamic_value_source_settings[ 'sort_order' ], $dynamic_value_source_settings[ 'column_value' ] );

			if ( empty( $retrieved_values ) ) {

				return $value;
			}

			$trigger_change = ( 1 < count( $retrieved_values ) ) ? false : true;

			$value = '';

			switch( $field->type ) {

				case 'select':

					$choices = array();

					foreach ( $retrieved_values as $retrieved ) {

						$choices[] = array( 'text'       => $retrieved[ 0 ],
						                    'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
						                    'isSelected' => false,
						                    'price'      => ''
						);

					}

					//TODO maybe remove
					if ( empty( $field->placeholder ) ) {

						$field->__set( 'placeholder', __( 'Select', 'gravityplus-dynamic-population' ) );
					}

					$field->__set( 'choices', $choices );

					/**
					 * @var GF_Field_Select $field
					 */
					$value = $field->get_choices( $field->get_value_default_if_empty( '' ) );


					break;

				case 'multiselect':

					$choices = array();

					foreach ( $retrieved_values as $retrieved ) {

						$choices[] = array( 'text'       => $retrieved[ 0 ],
						                    'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
						                    'isSelected' => false,
						                    'price'      => ''
						);

					}

					$field->__set( 'choices', $choices );

					/**
					 * @var GF_Field_MultiSelect $field
					 */
					$value = $field->get_choices( $field->get_value_default_if_empty( '' ) );


					break;

				case 'radio':

					$choices = array();

					foreach ( $retrieved_values as $retrieved ) {

						$choices[] = array( 'text'       => $retrieved[ 0 ],
						                    'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
						                    'isSelected' => false,
						                    'price'      => ''
						);

					}

					$field->__set( 'choices', $choices );

					/**
					 * @var GF_Field_Radio $field
					 */
					$value = $field->get_radio_choices( $field->get_value_default_if_empty( '' ), '', $form['id'] );

					break;

				case 'checkbox':

					$choices = array();

					foreach ( $retrieved_values as $retrieved ) {

						$choices[] = array( 'text'       => $retrieved[ 0 ],
						                    'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
						                    'isSelected' => false,
						                    'price'      => ''
						);

					}

					$field->__set( 'choices', $choices );

					/**
					 * @var GF_Field_Checkbox $field
					 */

					$value = $field->get_checkbox_choices( $field->get_value_default_if_empty( '' ), '', $form['id'] );

					break;

				default:

					$value = $retrieved_values[0][0];

			}

		}

		return $value;
	}

		/**
	 * Get dynamic value for field
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gfp_get_dynamic_field_value() {

		$form_id = rgpost( 'form_id' );

		$field_id = rgpost( 'field_id' );

		$feed_id = rgpost( 'feed_id' );

		$dependee_fields = rgpost( 'dependees' );


		$form = GFAPI::get_form( $form_id );

		$field = RGFormsModel::get_field( $form, $field_id );


		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		$feed = $addon_object->get_feed( $feed_id );

		$dynamic_value_source_settings = GFP_Dynamic_Population_API::get_dynamic_value_field_source_settings( $feed );

		$source = GFP_Dynamic_Population_API::get_dynamic_value_source( $feed );


		$value = '';

		$value = apply_filters( 'gfp_dynamic_population_form_display_get_dynamic_field_value', $value, $source, $dynamic_value_source_settings, $form, $field, $dependee_fields );

		if ( empty( $value ) ) {

			wp_send_json_error();

		}

			wp_send_json_success( array(
				'value'          => $value,
				'trigger_change' => true
			) );

	}

}
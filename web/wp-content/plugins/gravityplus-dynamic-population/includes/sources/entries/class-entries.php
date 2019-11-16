<?php
/**
 * @package   GFP_Dynamic_Population_Entries
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     2.0.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_Entries
 *
 * Dynamically populate entries
 *
 * @since  2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Entries {

	/**
	 * GFP_Dynamic_Population_Entries constructor.
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		add_filter( 'gfp_dynamic_population_sources', array( $this, 'gfp_dynamic_population_sources' ) );


		add_filter( 'gform_' . GFP_DYNAMIC_POPULATION_SLUG . '_feed_settings_fields', array( $this, 'feed_settings_fields' ), 10, 2 );


		add_filter( 'gfp_dynamic_population_api_dynamic_choice_source_settings', array( $this, 'gfp_dynamic_population_api_dynamic_choice_source_settings' ), 10, 4 );

		add_filter( 'gfp_dynamic_population_form_display_populate_options', array( $this, 'gfp_dynamic_population_form_display_populate_options' ), 10, 6 );

		add_filter( 'gfp_dynamic_population_form_display_get_dynamic_choices_values', array( $this, 'gfp_dynamic_population_form_display_get_dynamic_choices_values' ), 10, 6 );


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

		if ( ( empty( $object ) ) || ( ( 'field' == $object ) && in_array( $field_to_populate_type, array( 'select', 'radio', 'checkbox' ) ) ) ) {

			$sources[ 'entries' ] = __( 'Entries', 'gravityplus-dynamic-population' );

		}


		return $sources;

	}

	/**
	 * Add feed options
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $feed_settings_fields
	 *
	 * @param GFP_Dynamic_Population_Addon $addon_object
	 *
	 * @return mixed
	 */
	public function feed_settings_fields( $feed_settings_fields, $addon_object ) {

		$source = $addon_object->get_setting( 'source' );

		if ( 'entries' == $source ) {

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Form', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_entries_form',
				'choices'    => $this->get_form_choices(),
				'required'   => true,
				'onchange'   => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
				'dependency' => array( 'field' => 'source', 'values' => array( 'entries' ) )
			);

			$form_id = $addon_object->get_setting( 'source_entries_form' );

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Field', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_entries_field',
				'choices'    => array_merge( array( array( 'label' => __( 'Select field', 'gravityplus-dynamic-population' ), 'value' => '' ) ), $addon_object->get_form_fields_as_choices( GFAPI::get_form( $form_id ) ) ),
				'required'   => true,
				'dependency' => 'source_entries_form'
			);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
					'label'      => __( 'Choice Value', 'gravityplus-dynamic-population' ),
					'type'       => 'select',
					'name'       => 'source_entries_value',
					'choices'    => $this->get_choice_value_choices(),
					'default_value' => 'meta_value',
					'required'   => true,
					'dependency' => array( 'field' => 'source', 'values' => array( 'entries' ) )
				);


			unset( $feed_settings_fields[ 'section_filter' ] );

		}


		return $feed_settings_fields;
	}

	/**
	 * Get choice value choices for feed
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_choice_value_choices() {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );


		return array( array( 'label' => __( 'Select value' ), 'value' => '' ),
			array( 'label' => __( 'Entry ID', 'gravityplus-dynamic-population' ), 'value' => 'id' ),
			array( 'label' => __( 'Field Value', 'gravityplus-dynamic-population' ), 'value' => 'meta_value' ));

	}

	/**
	 * Get form choices for feed
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_form_choices() {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$form_choices = array( array( 'label' => __( 'Select form' ), 'value' => '' ) );

		$forms = GFAPI::get_forms();

		foreach( $forms as $form ) {

			$form_choices[] = array( 'label' => $form['title'], 'value' => $form['id'] );

		}


		return $form_choices;

	}

	/**
	 * @since  2.0.0
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

		if ( 'entries' == $source ) {

			if ( 'feed' == $type ) {

				$addon_object = GFP_Dynamic_Population_Addon::get_instance();

				$entries_settings = array(
					'entries_form_id'         => $addon_object->get_setting( 'source_entries_form', '', $field_or_feed['meta'] ),
					'entries_field_id'         => $addon_object->get_setting( 'source_entries_field', '', $field_or_feed['meta'] ),
					'value'         => $addon_object->get_setting( 'source_entries_value', '', $field_or_feed['meta'] ),
				);

			}

			$dynamic_choice_settings = array_merge( $dynamic_choice_settings, $entries_settings );
		}


		return $dynamic_choice_settings;
	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $dynamic_choice_info
	 * @param array $filters
	 * @param bool $formatted
	 *
	 * @return array
	 */
	private function get_entries_choices( $dynamic_choice_info, $filters, $formatted ) {

		$choices = array();

		$field = GFFormsModel::get_field( $dynamic_choice_info['entries_form_id'], $dynamic_choice_info['entries_field_id'] );

		switch( $field->type ) {

			case 'list':

				/**
				 * @var GF_Field_List $field
				 */

				/**
				 * @see GF_Field_List::get_value_export()
				 */
				$input_id = $dynamic_choice_info['entries_field_id'];

				if ( ! ctype_digit( $input_id ) ) {

					$field_id_array = explode( '.', $input_id );

					$input_id       = rgar( $field_id_array, 0 );

					$column_num     = rgar( $field_id_array, 1 );
				}

				//$entries = GFAPI::get_entries( $input_id );
				$where_rules = array( array(
					'column'   => 'form_id',
					'value'    => $dynamic_choice_info['entries_form_id'],
					'operator' => 'is'
				),
					array(
						'column'   => 'meta_key',
						'value'    => $input_id,
						'operator' => 'starts_with'
					));

				$entry_values = GFP_Dynamic_Population_Custom_Data::get_column_values( GFFormsModel::get_entry_meta_table_name(), 'meta_value', $where_rules, $dynamic_choice_info[ 'sort_order' ], $dynamic_choice_info[ 'value' ] );

				foreach ( $entry_values as $entry_value ) {

					$value = maybe_unserialize( $entry_value[0] );

					$list_values = $value;

					if ( isset( $column_num ) && is_numeric( $column_num ) && $field->enableColumns ) {

						$column        = rgars( $field->choices, "{$column_num}/text" );

						foreach ( $list_values as $list_value ) {

							$column_value = rgar( $list_value, $column );

							$choices[ ] = $formatted ? array(
								'text' => $column_value,
								'value' => $column_value,
								'isSelected' => false,
								'price' => '' ) :
								array( $column_value );

						}

					}
					else {

						foreach ( $list_values as $list_value ) {

							$choices[] = $formatted ? array(
								'text'       => $list_value,
								'value'      => $list_value,
								'isSelected' => false,
								'price'      => ''
							) :
								array( $list_value );

						}

					}

				}

				break;

			default:

				$where_rules = array( array(
					'column'   => 'form_id',
					'value'    => $dynamic_choice_info['entries_form_id'],
					'operator' => 'is'
				),
					array(
						'column'   => 'meta_key',
						'value'    => $dynamic_choice_info['entries_field_id'],
						'operator' => 'starts_with'
					));

				$values = GFP_Dynamic_Population_Custom_Data::get_column_values( GFFormsModel::get_entry_meta_table_name(), 'meta_value', $where_rules, $dynamic_choice_info[ 'sort_order' ], $dynamic_choice_info[ 'value' ] );

				foreach ( $values as $value ) {

					$choices[ ] = $formatted ? array(
						'text' => $value[0],
						'value' => empty( $value[1] ) ? $value[0] : $value[1],
						'isSelected' => false,
						'price' => '' ) :
						array( $value[0], empty( $value[1] ) ? $value[0] : $value[1]);

				}
		}


		return $choices;

	}

	/**
	 * @since  2.0.0
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

		if ( 'entries' == $dynamic_choice_info['source'] ) {

			$where_rules = array();

			if ( ! empty( $dynamic_choice_info[ 'filtered_by' ] ) ) {

				foreach ( $dynamic_choice_info[ 'filtered_by' ] as $filter ) {

					$field = GFFormsModel::get_field( $form, $filter[ 'field_id' ] );

					if ( ! empty( $field ) ) {

						if ( $get_from_post ) {

							$value = GFFormsModel::get_field_value( $field, $field_values );
						}
						else {

							$value = GFP_Dynamic_Population_API::get_preselected_choice( $field );

						}

						if ( ! empty( $value ) ) {

							$where_rules[ ] = array(
								'column'   => $filter[ 'column' ],
								'value'    => $value,
								'operator' => $filter[ 'operator' ]
							);

						}

					}

				}

			}

			$options = $this->get_entries_choices( $dynamic_choice_info, $where_rules, true );

		}


		return $options;
	}

	/**
	 * @since  2.0.0
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
	public function gfp_dynamic_population_form_display_get_dynamic_choices_values( $values, $source, $dynamic_choice_source_settings, $form, $field, $filters ){

		if ( 'entries' == $source ) {

			$values = $this->get_entries_choices( $dynamic_choice_source_settings, $filters, true );

		}


		return $values;
	}


	public function gfp_dynamic_population_dynamic_value_field_source_settings( $dynamic_source_settings, $source, $feed, $field ) {

		if ( 'entries' == $source ) {

				$addon_object = GFP_Dynamic_Population_Addon::get_instance();

				$entries_settings = array(
					'entries_form_id'         => $addon_object->get_setting( 'source_entries_form', '', $feed['meta'] ),
					'entries_field_id'         => $addon_object->get_setting( 'source_entries_field', '', $feed['meta'] ),
					'value'         => $addon_object->get_setting( 'source_entries_value', '', $feed['meta'] ),
					'sort_order'   => $addon_object->get_setting( 'sort_order', '', $feed['meta'] )
				);

			$dynamic_source_settings = array_merge( $dynamic_source_settings, $entries_settings );

		}


		return $dynamic_source_settings;
	}

	public function gfp_dynamic_population_form_display_populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, $get_from_post ) {

		if ( 'entries' == $dynamic_value_info['source'] ) {

			$where_rules = array();

			if ( ! empty( $dynamic_value_info[ 'dependees' ] ) ) {

				foreach ( $dynamic_value_info[ 'dependees' ] as $filter ) {

					$field = GFFormsModel::get_field( $form, $filter[ 'field_id' ] );

					if ( ! empty( $field ) ) {

						if ( $get_from_post ) {

							$field_value = GFFormsModel::get_field_value( $field, $field_values );
						}
						else {

							$field_value = GFP_Dynamic_Population_API::get_default_value( $field );

						}

						if ( ! empty( $field_value ) ) {

							$where_rules[ ] = array(
								'column'   => $filter[ 'column' ],
								'value'    => $field_value,
								'operator' => $filter[ 'operator' ]
							);

						}

					}

				}

			}

			$retrieved_values = $this->get_entries_choices( $dynamic_value_info, $where_rules, false );

			if ( empty( $retrieved_values ) ) {

				return $form;

			}

			$field = GFAPI::get_field( $form, $field_id );

			switch( $field->type ) {

				case 'select':
				case 'radio':
				case 'checkbox':

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

					$value = $retrieved_values[0][0];


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
	 * @since 2.1.0
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

		if ( 'entries' == $source ) {

			$retrieved_values = $this->get_entries_choices( $dynamic_value_source_settings, $dependees, false );

			if ( empty( $retrieved_values ) ) {

				return $value;
			}

			$trigger_change = ( 1 < count( $retrieved_values ) ) ? false : true;

			$value = '';

			switch( $field->type ) {

				case 'select':

					$value = array();

					foreach ( $retrieved_values as $retrieved ) {

						$value[] = array( 'text'       => $retrieved[ 0 ],
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

				case 'radio':

					$value = array();

					foreach ( $retrieved_values as $retrieved ) {

						$value[] = array( 'text'       => $retrieved[ 0 ],
						                    'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
						                    'isSelected' => false,
						                    'price'      => ''
						);

					}

					$field->__set( 'choices', $value );

					/**
					 * @var GF_Field_Radio $field
					 */
					$value = $field->get_radio_choices( $value, '', $form['id'] );

					break;

				case 'checkbox':

					$value = array();

					foreach ( $retrieved_values as $retrieved ) {

						$value[] = array( 'text'       => $retrieved[ 0 ],
						                    'value'      => empty( $retrieved[ 1 ] ) ? $retrieved[ 0 ] : $retrieved[ 1 ],
						                    'isSelected' => false,
						                    'price'      => ''
						);

					}

					$field->__set( 'choices', $value );

					/**
					 * @var GF_Field_Checkbox $field
					 */

					$value = $field->get_checkbox_choices( $value, '', $form['id'] );

					break;

				default:

					$value = $retrieved_values[0][0];

			}

		}

		return $value;
	}


}
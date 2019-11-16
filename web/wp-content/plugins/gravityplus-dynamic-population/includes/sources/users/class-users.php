<?php
/**
 * @package   GFP_Dynamic_Population
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     2.0.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_Users
 *
 * Dynamically populate users
 *
 * @since  2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Users {

	/**
	 * GFP_Dynamic_Population_Users constructor.
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		add_filter( 'gfp_dynamic_population_sources', array( $this, 'gfp_dynamic_population_sources' ) );

		//add_filter( 'gfp_dynamic_population_scripts', array( $this, 'gfp_dynamic_population_scripts' ), 10, 3 );


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

			$sources[ 'users' ] = __( 'Users', 'gravityplus-dynamic-population' );

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

		$filter_options = array( array( 'value' => '',
		                                'text' => '' ),
		);

		$scripts[] =
			array(
				'handle'    => 'gfp_dynamic_population_users_admin',
				'src'       => GFP_DYNAMIC_POPULATION_URL . "/includes/sources/users/js/admin{$suffix}.js",
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
					'filter_options'                  => $filter_options,
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
	 * @param array $feed_settings_fields
	 *
	 * @param GFP_Dynamic_Population_Addon $addon_object
	 *
	 * @return mixed
	 */
	public function feed_settings_fields( $feed_settings_fields, $addon_object ) {

		$source = $addon_object->get_setting( 'source' );

		if ( 'users' == $source ) {

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
					'label'      => __( 'Choice Label', 'gravityplus-dynamic-population' ),
					'type'       => 'select',
					'name'       => 'source_users_label',
					'choices'    => $this->get_choice_label_choices(),
					'required'   => true,
					'dependency' => array( 'field' => 'source', 'values' => array( 'users' ) )
				);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
					'label'      => __( 'Choice Value', 'gravityplus-dynamic-population' ),
					'type'       => 'select',
					'name'       => 'source_users_value',
					'choices'    => $this->get_choice_label_choices(),
					'required'   => true,
					'dependency' => array( 'field' => 'source', 'values' => array( 'users' ) )
				);

			$feed_settings_fields['section_filter']['fields'][] = array(
				'name'        => 'source_users_role[]',
				'label'       => __( 'User in ALL Roles', 'gravityplus-dynamic-population' ),
				'tooltip' => '<h6>' . __( 'User in ALL Roles', 'gravityplus-dynamic-population' ) . '</h6>' . __( 'User must have EACH role', 'gravityplus-dynamic-population' ),
				'type'        => 'select',
				'choices'     => $this->get_role_choices(),
				'multiple'    => 'multiple'
			);

			$feed_settings_fields['section_filter']['fields'][] = array(
				'name'        => 'source_users_role__in[]',
				'label'       => __( 'User in ANY Role', 'gravityplus-dynamic-population' ),
				'tooltip' => '<h6>' . __( 'User in ANY Role', 'gravityplus-dynamic-population' ) . '</h6>' . __( 'User must have AT LEAST ONE of these roles', 'gravityplus-dynamic-population' ),
				'type'        => 'select',
				'choices'     => $this->get_role_choices(),
				'multiple'    => 'multiple'
			);

			$feed_settings_fields['section_filter']['fields'][] = array(
				'name'        => 'source_users_role__not_in[]',
				'label'       => __( 'User NOT IN Role', 'gravityplus-dynamic-population' ),
				'tooltip' => '<h6>' . __( 'User NOT IN Role', 'gravityplus-dynamic-population' ) . '</h6>' . __( 'User must NOT be in ANY of these roles', 'gravityplus-dynamic-population' ),
				'type'        => 'select',
				'choices'     => $this->get_role_choices(),
				'multiple'    => 'multiple'
			);

			unset( $feed_settings_fields[ 'section_filter' ]['fields'][0] );

			/*$feed_settings_fields['section_filter']['fields'][0]['fields_column_header'] = __( 'Filter Option', 'gravityplus-dynamic-population' );

			$feed_settings_fields['section_filter']['fields'][0]['values_column_header'] = __( 'Form Field', 'gravityplus-dynamic-population' );
*/
			$feed_settings_fields['section_filter']['dependency']['values'][] = 'users';

		}


		return $feed_settings_fields;
	}

	/**
 * Get choice label choices for feed
 *
 * @since  2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @return array
 */
	private function get_choice_label_choices() {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );


		return array( array( 'label' => __( 'Select' ), 'value' => '' ),
			array( 'label' => __( 'ID', 'gravityplus-dynamic-population' ), 'value' => 'ID' ),
			array( 'label' => __( 'Login', 'gravityplus-dynamic-population' ), 'value' => 'user_login' ),
			array( 'label' => __( 'Nice Name', 'gravityplus-dynamic-population' ), 'value' => 'user_nicename' ),
			array( 'label' => __( 'Email', 'gravityplus-dynamic-population' ), 'value' => 'user_email' ),
			array( 'label' => __( 'Display Name', 'gravityplus-dynamic-population' ), 'value' => 'display_name' ));

	}

	/**
	 * Get role choices for feed
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_role_choices() {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$role_choices = array();

		$editable_roles = array_reverse( get_editable_roles() );

		foreach ( $editable_roles as $role => $details ) {

			$role_choices[] = array( 'label' => $details['name'], 'value' => $role );

		}


		return $role_choices;

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

		if ( 'users' == $source ) {

			if ( 'feed' == $type ) {

				$addon_object = GFP_Dynamic_Population_Addon::get_instance();

				$users_settings = array(
					'label'         => $addon_object->get_setting( 'source_users_label', '', $field_or_feed['meta'] ),
					'value'         => $addon_object->get_setting( 'source_users_value', '', $field_or_feed['meta'] ),
				);

			}

			$dynamic_choice_settings = array_merge( $dynamic_choice_settings, $users_settings );
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
	private function get_users_choices( $dynamic_choice_info, $filters, $formatted ) {

		$choices = array();

		$args = array(
			'nopaging'   => true
		);

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		$feed = $addon_object->get_feed( $dynamic_choice_info['feed_id'] );

		$roles = $addon_object->get_setting( 'source_users_role', '', $feed[ 'meta' ] );

		if ( ! empty( $roles ) ) {

			$args['role'] = $roles;

		}

		$roles_in = $addon_object->get_setting( 'source_users_role__in', '', $feed[ 'meta' ] );

		if ( ! empty( $roles_in ) ) {

			$args['role__in'] = $roles;

		}

		$roles_not_in = $addon_object->get_setting( 'source_users_role__not_in', '', $feed[ 'meta' ] );

		if ( ! empty( $roles_not_in ) ) {

			$args['role__not_in'] = $roles_not_in;

		}

		$users = get_users( $args );


		foreach ( $users as $user ) {

			$choices[] = $formatted
				?
				array(
				'text' => $user->{$dynamic_choice_info['label']},
				'value' => $user->{$dynamic_choice_info['value']},
				'isSelected' => false,
				'price' => '' )
				:
				array( $user->{$dynamic_choice_info['label']}, $user->{$dynamic_choice_info['value']});

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

		if ( 'users' == $dynamic_choice_info['source'] ) {

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

			$options = $this->get_users_choices( $dynamic_choice_info, $where_rules, true );

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

		if ( 'users' == $source ) {

			$values = $this->get_users_choices( $dynamic_choice_source_settings, $filters, true );

		}


		return $values;
	}


	public function gfp_dynamic_population_dynamic_value_field_source_settings( $dynamic_source_settings, $source, $feed, $field ) {

		if ( 'users' == $source ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$users_settings = array(
					'label'         => $addon_object->get_setting( 'source_users_label', '', $feed['meta'] ),
					'value'         => $addon_object->get_setting( 'source_users_value', '', $feed['meta'] ),
					'sort_order'   => $addon_object->get_setting( 'sort_order', '', $feed['meta'] )
			);

			$dynamic_source_settings = array_merge( $dynamic_source_settings, $users_settings );

		}


		return $dynamic_source_settings;
	}

	public function gfp_dynamic_population_form_display_populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, $get_from_post ) {

		if ( 'users' == $dynamic_value_info['source'] ) {

			$where_rules = array();

			/*if ( ! empty( $dynamic_value_info[ 'dependees' ] ) ) {

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

			}*/

			$retrieved_values = $this->get_users_choices( $dynamic_value_info, $where_rules, false );


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

		if ( 'users' == $source ) {

			$retrieved_values = $this->get_users_choices( $dynamic_value_source_settings, $dependees, true );

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
<?php
/**
 * @package   GFP_Dynamic_Population
 * @copyright 2014-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.0.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_API
 *
 * Provides public interface for interacting with fields that have dynamic choice options
 *
 * @since  1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_API {

	/**
	 * Does this form have any fields that have their choices dynamically populated?
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param        $form
	 *
	 * @param string $source
	 *
	 * @return bool
	 */
	public static function has_dynamic_choice_field( $form, $source = '' ) {

		$has_dynamic_choice_field = false;

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		if ( $addon_object->has_feed( $form[ 'id' ] ) ) {

			$has_dynamic_choice_field = true;

			/*$feeds = $addon_object->get_active_feeds( $form['id'] );

			foreach( $feeds as $feed ){

				if ( 'field' == $addon_object->get_setting( 'object', '', $feed['meta'] ) ) {

					$has_dynamic_choice_field = true;
				}
			} */
		} else {

			if ( is_array( $form[ 'fields' ] ) ) {

				foreach ( $form[ 'fields' ] as $field ) {

					if ( self::has_dynamic_choice( $field ) ) {

						if ( ( empty( $source ) ) || ( self::get_dynamic_choice_source( $field ) == $source ) ) {

							$has_dynamic_choice_field = true;

							break;

						}

					}

				}

			}

		}

		return $has_dynamic_choice_field;
	}

	/**
	 * Does this form have any fields that have their values dynamically populated?
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param        $form
	 *
	 * @param string $source
	 *
	 * @return bool
	 */
	public static function has_dynamic_value_field( $form, $source = '' ) {

		$has_dynamic_value_field = false;

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		if ( $addon_object->has_feed( $form[ 'id' ] ) ) {

			$feeds = $addon_object->get_active_feeds( $form[ 'id' ] );

			foreach ( $feeds as $feed ) {

				if ( ( 'field' == $addon_object->get_setting( 'object', '', $feed[ 'meta' ] ) ) && ( ( empty( $source ) ) || ( self::get_dynamic_value_source( $feed ) == $source ) ) ) {

					$has_dynamic_value_field = true;

				}

			}

		}


		return $has_dynamic_value_field;
	}

	/**
	 * Get all of the fields for this form that have their choices dynamically populated, as well as the dynamic
	 * population information
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param        $form
	 *
	 * @param string $source
	 *
	 * @return array
	 */
	public static function get_dynamic_choice_fields( $form, $source = '' ) {

		$fields = array();

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		if ( $addon_object->has_feed( $form[ 'id' ] ) ) {

			$feeds = $addon_object->get_active_feeds( $form[ 'id' ] );

			//$choice_field_types = array( 'select', 'checkbox', 'radio' );
			$choice_field_types = array();

			foreach ( $feeds as $feed ) {

				if ( 'field' == $addon_object->get_setting( 'object', '', $feed[ 'meta' ] ) ) {

					$feed_source = $addon_object->get_setting( 'source', '', $feed[ 'meta' ] );

					if ( ( empty( $source ) ) || ( $feed_source == $source ) ) {

						$field_id = $addon_object->get_setting( 'field_to_populate', '', $feed[ 'meta' ] );

						$field = GFAPI::get_field( $form, $field_id );

						if ( in_array( $field->type, $choice_field_types ) ) {

							$fields[ $field_id ] = self::get_dynamic_choice_source_settings( $feed, 'feed' );

							$fields[ $field_id ][ 'source' ] = $feed_source;

							$fields[ $field_id ][ 'field_id' ] = $field_id;

							$fields[ $field_id ][ 'feed_id' ] = $feed[ 'id' ];

							$fields[ $field_id ][ 'field_type' ] = $field->type;

							if ( 'select' == $field->type ) {

								$fields[ $field_id ][ 'placeholder' ] = array(
									'text'       => empty( $field[ 'placeholder' ] ) ? __( 'Select', 'gravityplus-dynamic-population' ) : $field[ 'placeholder' ],
									'value'      => '',
									'isSelected' => true,
									'price'      => ''
								);

							}

							if ( self::has_dynamic_choice_filter( $feed, 'feed' ) ) {

								$fields[ $field_id ][ 'filtered_by' ] = self::get_dynamic_choice_filter( $feed, 'feed' );

							}

							if ( self::is_dynamic_choice_filter( $field, $form, $feed[ 'id' ] ) ) {

								$fields[ $field_id ][ 'filters' ] = self::get_dynamic_choice_fields_filtered( $field, $form, $feed[ 'id' ] );

							}

						}

					}

				}

			}

		} else {

			foreach ( $form[ 'fields' ] as $field ) {

				if ( self::has_dynamic_choice( $field ) ) {

					$field_source = self::get_dynamic_choice_source( $field );

					if ( ( empty( $source ) ) || ( $field_source == $source ) ) {

						$fields[ $field[ 'id' ] ] = self::get_dynamic_choice_source_settings( $field );

						$fields[ $field[ 'id' ] ][ 'source' ] = $field_source;

						$fields[ $field[ 'id' ] ][ 'field_id' ] = $field[ 'id' ];

						$fields[ $field[ 'id' ] ][ 'feed_id' ] = 0;

						$fields[ $field[ 'id' ] ][ 'placeholder' ] = array(
							'text'       => empty( $field[ 'placeholder' ] ) ? __( 'Select', 'gravityplus-dynamic-population' ) : $field[ 'placeholder' ],
							'value'      => '',
							'isSelected' => true,
							'price'      => ''
						);

						if ( self::has_dynamic_choice_filter( $field ) ) {

							$fields[ $field[ 'id' ] ][ 'filtered_by' ] = self::get_dynamic_choice_filter( $field );

						}

						if ( self::is_dynamic_choice_filter( $field, $form ) ) {

							$fields[ $field[ 'id' ] ][ 'filters' ] = self::get_dynamic_choice_fields_filtered( $field, $form );

						}

					}

				}
			}

		}

		return $fields;

	}

	/**
	 * Get fields that have their values dynamically populated, as well as the dynamic
	 * population information
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array  $form
	 *
	 * @param string $source
	 *
	 * @return array
	 */
	public static function get_dynamic_value_fields( $form, $source = '' ) {

		$fields = array();

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		if ( $addon_object->has_feed( $form[ 'id' ] ) ) {

			$feeds = $addon_object->get_active_feeds( $form[ 'id' ] );

			//$choice_field_types = array( 'select', 'checkbox', 'radio' );

			foreach ( $feeds as $feed ) {

				if ( 'field' == $addon_object->get_setting( 'object', '', $feed[ 'meta' ] ) ) {

					$feed_source = $addon_object->get_setting( 'source', '', $feed[ 'meta' ] );

					if ( ( empty( $source ) ) || ( $feed_source == $source ) ) {

						$field_id = $addon_object->get_setting( 'field_to_populate', '', $feed[ 'meta' ] );

						$field = GFAPI::get_field( $form, $field_id );

						//if ( ! in_array( $field->type, $choice_field_types ) ) {

						$fields[ $field_id ] = self::get_dynamic_value_field_source_settings( $feed );

						$fields[ $field_id ][ 'source' ] = $feed_source;

						$fields[ $field_id ][ 'field_id' ] = $field_id;

						$fields[ $field_id ][ 'field_type' ] = $field->type;

						$fields[ $field_id ][ 'feed_id' ] = $feed[ 'id' ];

						if ( 'select' == $field->type ) {

							$fields[ $field_id ][ 'placeholder' ] = array(
								'text'       => empty( $field[ 'placeholder' ] ) ? __( 'Select', 'gravityplus-dynamic-population' ) : $field[ 'placeholder' ],
								'value'      => '',
								'isSelected' => true,
								'price'      => ''
							);

						}

						if ( self::has_dynamic_choice_filter( $feed, 'feed' ) ) {

							$fields[ $field_id ][ 'dependees' ] = self::get_dynamic_choice_filter( $feed, 'feed' );

						}

						if ( self::is_dynamic_choice_filter( $field, $form, $feed[ 'id' ] ) ) {

							$fields[ $field_id ][ 'dependents' ] = self::get_dynamic_choice_fields_filtered( $field, $form, $feed[ 'id' ] );

						}

						//}

					}

				}

			}

		}


		return $fields;

	}

	/**
	 * Does this field have dynamic choice population enabled?
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	public static function has_dynamic_choice( $field ) {

		$has_dynamic_choice = false;

		if ( ! empty( $field[ 'dynamicChoicesEnable' ] ) && $field[ 'dynamicChoicesEnable' ] ) {

			if ( empty( $field[ 'dynamicChoicesSource' ] ) ) {

				$dynamic_choice_source = 'wpdb';

				$form = GFAPI::get_form( $field[ 'formId' ] );

				foreach ( $form[ 'fields' ] as &$form_field ) {

					if ( $form_field->id == $field[ 'id' ] ) {

						$form_field[ 'dynamicChoicesSource' ] = 'wpdb';

						GFAPI::update_form( $form );

						break;
					}

				}


			} else {

				$dynamic_choice_source = $field[ 'dynamicChoicesSource' ];

			}

			switch ( $dynamic_choice_source ) {

				case 'wpdb':

					if ( ! empty( $field[ 'dynamicChoicesSourceTable' ] ) && ! empty( $field[ 'dynamicChoicesSourceTableColumn' ] ) ) {

						$has_dynamic_choice = true;
					}

					break;

			}

		}

		return apply_filters( 'gfp_dynamic_population_api_has_dynamic_choice', $has_dynamic_choice, $field );
	}

	/**
	 * Get the source used to populate the dynamic choices for this field
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 *
	 * @return array
	 */
	public static function get_dynamic_choice_source( $field_or_feed, $type = 'field' ) {

		if ( 'field' == $type ) {

			$form = GFAPI::get_form( $field_or_feed[ 'formId' ] );

			$field = GFFormsModel::get_field( $form, $field_or_feed[ 'id' ] );

			$dynamic_choice_source = self::has_dynamic_choice( $field ) ? rgar( $field, 'dynamicChoicesSource' ) : '';

		} else if ( 'feed' == $type ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$dynamic_choice_source = $addon_object->get_setting( 'source', '', $field_or_feed[ 'meta' ] );

		}

		return $dynamic_choice_source;
	}

	/**
	 * Get the source used to populate the dynamic value for this field
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $feed
	 *
	 * @return array
	 */
	public static function get_dynamic_value_source( $feed ) {

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		$dynamic_choice_source = $addon_object->get_setting( 'source', '', $feed[ 'meta' ] );


		return $dynamic_choice_source;
	}

	/**
	 * Get the source settings (e.g. table and column) used to populate the dynamic choices for this field
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 *
	 * @return array
	 */
	public static function get_dynamic_choice_source_settings( $field_or_feed, $type = 'field' ) {

		$dynamic_choice_source_settings = array();

		if ( 'field' == $type && self::has_dynamic_choice( $field_or_feed ) ) {

			$source = self::get_dynamic_choice_source( $field_or_feed );

			if ( 'wpdb' == $source ) {

				$dynamic_choice_source_settings = array(
					'table'        => rgar( $field_or_feed, 'dynamicChoicesSourceTable' ),
					'column'       => rgar( $field_or_feed, 'dynamicChoicesSourceTableColumn' ),
					'column_value' => rgar( $field_or_feed, 'dynamicChoicesSourceValueTableColumn' ),
				);

			}

		} else if ( 'feed' == $type ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$source = self::get_dynamic_choice_source( $field_or_feed, 'feed' );

			if ( 'wpdb' == $source ) {

				$dynamic_choice_source_settings = array(
					'table'        => $addon_object->get_setting( 'source_wpdb_table', '', $field_or_feed[ 'meta' ] ),
					'column'       => $addon_object->get_setting( 'source_wpdb_table_column', '', $field_or_feed[ 'meta' ] ),
					'column_value' => $addon_object->get_setting( 'source_wpdb_value_table_column', '', $field_or_feed[ 'meta' ] ),
				);

			}

		}

		$dynamic_choice_source_settings = apply_filters( 'gfp_dynamic_population_api_dynamic_choice_source_settings', $dynamic_choice_source_settings, $source, $field_or_feed, $type );

		$dynamic_choice_source_settings[ 'sort_order' ] = ( 'field' == $type ) ? rgar( $field_or_feed, 'dynamicChoicesSortOrder' ) : $addon_object->get_setting( 'sort_order', '', $field_or_feed[ 'meta' ] );


		return $dynamic_choice_source_settings;
	}

	/**
	 * Get the source settings used to populate the dynamic value for this field
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $feed
	 *
	 * @return array
	 */
	public static function get_dynamic_value_field_source_settings( $feed ) {

		$source = self::get_dynamic_value_source( $feed );

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		$field_id = $addon_object->get_setting( 'field_to_populate', '', $feed[ 'meta' ] );

		$field = GFAPI::get_field( GFAPI::get_form( $feed[ 'form_id' ] ), $field_id );


		return apply_filters( 'gfp_dynamic_population_dynamic_value_field_source_settings', array(), $source, $feed, $field );
	}

	/**
	 * Does this field or feed have dynamic choice filter rules?
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field_or_feed
	 *
	 * @return bool
	 */
	public static function has_dynamic_choice_filter( $field_or_feed, $type = 'field' ) {

		$has_dynamic_choice_filter = false;

		if ( 'field' == $type && ! empty( $field_or_feed[ 'dynamicChoice' ][ 'conditionalLogic' ] ) ) {

			$has_dynamic_choice_filter = true;

		} else if ( 'feed' == $type ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$conditional_logic = $addon_object->get_setting( 'dynamic_choice_filter_conditional_logic', '', $field_or_feed[ 'meta' ] );

			if ( ! empty( $conditional_logic ) ) {

				$has_dynamic_choice_filter = true;

			}

		}

		return $has_dynamic_choice_filter;
	}

	/**
	 * Is this field (in this feed) used to filter the dynamic choices for another field?
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param       $field
	 * @param array $form
	 * @param int   $feed_id
	 *
	 * @return bool
	 */
	public static function is_dynamic_choice_filter( $field, $form, $feed_id = 0 ) {

		$is_dynamic_choice_filter = false;

		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		if ( $addon_object->has_feed( $form[ 'id' ] ) ) {

			$feeds = $addon_object->get_active_feeds( $form[ 'id' ] );

			foreach ( $feeds as $feed ) {

				if ( $feed_id != $feed[ 'id' ] && self::has_dynamic_choice_filter( $feed, 'feed' ) ) {

					$dynamic_choice_filter = self::get_dynamic_choice_filter( $feed, 'feed' );

					$dynamic_choice_filter_fields = array_keys( $dynamic_choice_filter );

					if ( in_array( $field[ 'id' ], $dynamic_choice_filter_fields ) ) {

						$is_dynamic_choice_filter = true;

						break;

					}

				}

			}

		} else {

			foreach ( $form[ 'fields' ] as $form_field ) {

				if ( $form_field[ 'id' ] !== $field[ 'id' ] && self::has_dynamic_choice_filter( $form_field ) ) {

					$dynamic_choice_filter = self::get_dynamic_choice_filter( $form_field );

					$dynamic_choice_filter_fields = array_keys( $dynamic_choice_filter );

					if ( in_array( $field[ 'id' ], $dynamic_choice_filter_fields ) ) {

						$is_dynamic_choice_filter = true;

						break;

					}
				}
			}

		}

		return $is_dynamic_choice_filter;
	}

	/**
	 * Get the dynamic choice filter rules for this field
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $field_or_feed GF field object or Dyn Pop Pro feed
	 *
	 * @return array
	 */
	public static function get_dynamic_choice_filter( $field_or_feed, $type = 'field' ) {

		$dynamic_choice_filter = array();

		if ( self::has_dynamic_choice_filter( $field_or_feed, $type ) ) {

			if ( 'field' == $type ) {

				foreach ( $field_or_feed[ 'dynamicChoice' ][ 'conditionalLogic' ][ 'rules' ] as $rule ) {

					$dynamic_choice_filter[ rgar( $rule, 'fieldId' ) ] = array(
						'field_id' => rgar( $rule, 'fieldId' ),
						'operator' => rgar( $rule, 'operator' ),
						'column'   => rgar( $rule, 'value' )
					);

				}

			} else if ( 'feed' == $type ) {

				$addon_object = GFP_Dynamic_Population_Addon::get_instance();

				$conditional_logic_object = $addon_object->get_setting( 'dynamic_choice_filter_conditional_logic_object', '', $field_or_feed[ 'meta' ] );

				if ( ! empty( $conditional_logic_object ) ) {

					foreach ( $conditional_logic_object[ 'conditionalLogic' ][ 'rules' ] as $rule ) {

						if ( isset( $rule[ 'custom_value' ] ) && $rule[ 'custom_value' ] && '' !== rgar( $rule, 'value' ) ) {

							$dynamic_choice_filter[ rgar( $rule, 'fieldId' ) ] = array(
								'field_id'   => rgar( $rule, 'value' ),
								'operator'   => rgar( $rule, 'operator' ),
								'column'     => rgar( $rule, 'fieldId' ),
								'field_type' => 'custom'
							);

							continue;
						}

						$dynamic_choice_filter[ rgar( $rule, 'value' ) ] = array(
							'field_id'   => rgar( $rule, 'value' ),
							'operator'   => rgar( $rule, 'operator' ),
							'column'     => rgar( $rule, 'fieldId' ),
							'field_type' => GFAPI::get_field( $field_or_feed[ 'form_id' ], rgar( $rule, 'value' ) )->type
						);

					}

				}

			}

		}

		return $dynamic_choice_filter;
	}

	/**
	 * Get field IDs that have a dynamic choice filter rule based on this field
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array|GF_Field $field GF field object
	 * @param array          $form  GF form object
	 *
	 * @return array Returns an array of field IDs
	 */
	public static function get_dynamic_choice_fields_filtered( $field, $form, $feed_id = 0 ) {

		$dynamic_choice_fields_filtered = array();

		if ( self::is_dynamic_choice_filter( $field, $form, $feed_id ) ) {

			if ( ! empty( $feed_id ) ) {

				$addon_object = GFP_Dynamic_Population_Addon::get_instance();

				$feeds = $addon_object->get_active_feeds( $form[ 'id' ] );

				foreach ( $feeds as $feed ) {

					if ( $feed_id != $feed[ 'id' ] && self::has_dynamic_choice_filter( $feed, 'feed' ) ) {

						if ( in_array( $field[ 'id' ], array_keys( self::get_dynamic_choice_filter( $feed, 'feed' ) ) ) ) {

							$dynamic_choice_fields_filtered[] = $addon_object->get_setting( 'field_to_populate', '', $feed[ 'meta' ] );

						}

					}

				}

			} else {

				foreach ( $form[ 'fields' ] as $form_field ) {

					if ( $form_field[ 'id' ] !== $field[ 'id' ] && self::has_dynamic_choice_filter( $form_field ) ) {

						if ( in_array( $field[ 'id' ], array_keys( self::get_dynamic_choice_filter( $form_field ) ) ) ) {

							$dynamic_choice_fields_filtered[] = $form_field[ 'id' ];

						}

					}
				}

			}
		}

		return $dynamic_choice_fields_filtered;
	}

	/**
	 * Does this field have a preselected choice?
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	public static function has_preselected_choice( $field ) {

		$has_preselected_choice = false;

		if ( isset( $field[ 'choices' ] ) && is_array( $field[ 'choices' ] ) ) {

			foreach ( $field[ 'choices' ] as $choice ) {

				if ( ! empty( $choice[ 'value' ] ) && true === $choice[ 'isSelected' ] ) {

					$has_preselected_choice = true;

					break;
				}
			}

		}

		return $has_preselected_choice;
	}

	/**
	 * Get preselected choice for field
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	public static function get_preselected_choice( $field ) {

		$preselected_choice = false;

		if ( isset( $field[ 'choices' ] ) && is_array( $field[ 'choices' ] ) ) {

			foreach ( $field[ 'choices' ] as $choice ) {

				if ( true === $choice[ 'isSelected' ] ) {

					$preselected_choice = $choice[ 'value' ];

					break;
				}
			}

		}

		return $preselected_choice;
	}

	/**
	 * Does this field have a default value?
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	public static function has_default_value( $field ) {

		return isset( $field->defaultValue ) && ! empty( $field->defaultValue );

	}

	/**
	 * Get field's default value
	 *
	 * @since 2.1.0
	 *
	 * @param GF_Field $field
	 *
	 * @return bool|string
	 */
	public static function get_default_value( $field ) {

		$default_value = '';

		switch ( $field->type ) {

			case 'select':
			case 'radio':
			case 'checkbox':

				$default_value = empty( $field->defaultValue ) ? self::get_preselected_choice( $field ) : $field->get_value_default();


				break;

			default:

				$default_value = $field->get_value_default();

		}

		return $default_value;
	}

	/**
	 * Get terms for a taxonomy
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $dynamic_choice_info
	 *                     {
	 *                     Optional. An array of arguments.
	 *
	 * @type string $name  taxonomy name
	 * @type string $label taxonomy label
	 * @type string $value taxonomy value
	 * }
	 *
	 * @param bool  $formatted
	 *
	 * @return array
	 */
	public static function get_taxonomy_choices( $dynamic_choice_info, $formatted, $hide_empty = false ) {

		$choices = array();

		$terms = get_terms( array( 'taxonomy' => $dynamic_choice_info[ 'name' ], 'hide_empty' => $hide_empty, ) );

		if ( ! is_wp_error( $terms ) ) {

			$organized_terms = array();

			foreach ( $terms as $term ) {

				if ( 0 == $term->parent ) {

					$organized_terms[ $term->term_id ] = array(
						'text'     => $term->{$dynamic_choice_info[ 'label' ]},
						'value'    => $term->{$dynamic_choice_info[ 'value' ]},
						'children' => array()
					);

				} else {

					$organized_terms[ $term->parent ][ 'children' ][ $term->term_id ] = array(
						'text'     => $term->{$dynamic_choice_info[ 'label' ]},
						'value'    => $term->{$dynamic_choice_info[ 'value' ]},
						'children' => array()
					);
				}

			}

			unset( $term );

			foreach ( $organized_terms as $term ) {

				$choices[] = $formatted ? array(
					'text'       => $term[ 'text' ],
					'value'      => $term[ 'value' ],
					'isSelected' => false,
					'price'      => ''
				) : array( $term[ 'text' ], $term[ 'value' ] );

				if ( ! empty( $term[ 'children' ] ) ) {

					foreach ( $term[ 'children' ] as $child ) {

						$choices[] = $formatted ? array(
							'text'       => '-- ' . $child[ 'text' ],
							'value'      => $child[ 'value' ],
							'isSelected' => false,
							'price'      => ''
						) : array( '-- ' . $child[ 'text' ], $child[ 'value' ] );

					}

				}

			}

		}


		return $choices;
	}

}
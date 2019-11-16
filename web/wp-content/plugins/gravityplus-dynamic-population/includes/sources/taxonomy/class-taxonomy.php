<?php
/**
 * @package   GFP_Dynamic_Population
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.5.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_Taxonomy
 *
 * Adds taxonomy dynamic choices source
 *
 * Generously sponsored by MotoGrafik.com
 *
 * @since  1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Taxonomy {

	/**
	 * GFP_Dynamic_Population_Taxonomy constructor.
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		add_filter( 'gfp_dynamic_population_sources', array( $this, 'gfp_dynamic_population_sources' ) );

		add_action( 'gfp_dynamic_population_dynamic_choices_field_settings_container', array( $this, 'gfp_dynamic_population_dynamic_choices_field_settings_container' ) );

		add_filter( 'gform_' . GFP_DYNAMIC_POPULATION_SLUG . '_feed_settings_fields', array( $this, 'feed_settings_fields' ), 10, 2 );


		add_action( 'admin_init', array( $this, 'admin_init' ) );


		add_filter( 'gfp_dynamic_population_api_has_dynamic_choice', array( $this, 'gfp_dynamic_population_api_has_dynamic_choice' ), 10, 2 );

		add_filter( 'gfp_dynamic_population_api_dynamic_choice_source_settings', array( $this, 'gfp_dynamic_population_api_dynamic_choice_source_settings' ), 10, 4 );

		add_filter( 'gfp_dynamic_population_form_display_populate_options', array( $this, 'gfp_dynamic_population_form_display_populate_options' ), 10, 6 );

		add_filter( 'gfp_dynamic_population_form_display_get_dynamic_choices_values', array( $this, 'gfp_dynamic_population_form_display_get_dynamic_choices_values' ), 10, 5 );


		add_filter( 'gfp_dynamic_population_dynamic_value_field_source_settings', array( $this, 'gfp_dynamic_population_dynamic_value_field_source_settings' ), 10, 4 );

		add_filter( 'gfp_dynamic_population_form_display_populate_field_value', array( $this, 'gfp_dynamic_population_form_display_populate_field_value' ), 10, 5 );

		add_filter( 'gfp_dynamic_population_form_display_get_dynamic_field_value', array( $this, 'gfp_dynamic_population_form_display_get_dynamic_field_value' ), 10, 6 );

	}


	/**
	 * @since  1.5.0
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

			$sources[ 'taxonomy' ] = __( 'Taxonomy', 'gravityplus-dynamic-population' );

		}


		return $sources;

	}

	/**
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gfp_dynamic_population_dynamic_choices_field_settings_container() {

		$taxonomies = get_taxonomies( array(), 'objects' );

		$choice_label_options = array( 'name' => __( 'Name', 'gravityplus-dynamic-population' ) );

		$choice_value_options = array( 'term_id' => __( 'ID', 'gravityplus-dynamic-population' ),
		                        'name' => __( 'Name', 'gravityplus-dynamic-population' ),
		                        'slug' => __( 'Slug', 'gravityplus-dynamic-population' ),
		                        'term_taxonomy_id' => __( 'Term Taxonomy ID', 'gravityplus-dynamic-population' ));

		require_once( trailingslashit( GFP_DYNAMIC_POPULATION_PATH ) . 'includes/sources/taxonomy/views/field-setting-dynamic_choices.php' );

	}

	/**
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function admin_init() {

		if ( 'gf_edit_forms' == GFForms::get( 'page' ) ) {

			add_action( 'gform_editor_js', array( $this, 'gform_editor_js' ) );

			add_filter( 'gform_noconflict_scripts', array( $this, 'gform_noconflict_scripts' ) );

		}

	}

	/**
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_editor_js() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'gfp_dynamic_population_form_editor_taxonomy', trailingslashit( GFP_DYNAMIC_POPULATION_URL ) . "includes/sources/taxonomy/js/dynamic-choices.editor{$suffix}.js", array( 'gfp_dynamic_population_form_editor' ), GFP_DYNAMIC_POPULATION_CURRENT_VERSION );

	}

	/**
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $noconflict_scripts
	 *
	 * @return array
	 */
	public static function gform_noconflict_scripts( $noconflict_scripts ) {

		$noconflict_scripts = array_merge( $noconflict_scripts, array( 'gfp_dynamic_population_form_editor_taxonomy' ) );


		return $noconflict_scripts;

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

		if ( 'taxonomy' == $source ) {

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Taxonomy', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_taxonomy_name',
				'choices'    => $this->get_taxonomy_name_choices(),
				'required'   => true,
				'dependency' => array( 'field' => 'source', 'values' => array( 'taxonomy' ) )
			);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Taxonomy Object', 'gravityplus-dynamic-population' ),
				'type'       => 'hidden',
				'name'       => 'source_taxonomy_object',
				'value' => 'all',
				'required'   => true,
				'dependency' => array( 'field' => 'source', 'values' => array( 'taxonomy' ) )
			);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Choice Label', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_taxonomy_label',
				'choices'    => $this->get_choice_label_choices(),
				'required'   => true,
				'dependency' => array( 'field' => 'source', 'values' => array( 'taxonomy' ) )
			);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Choice Value', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_taxonomy_value',
				'choices'    => $this->get_choice_value_choices(),
				'required'   => true,
				'dependency' => array( 'field' => 'source', 'values' => array( 'taxonomy' ) )
			);

			unset( $feed_settings_fields[ 'section_filter' ] );

		}

		return $feed_settings_fields;
	}

	/**
	 * Get taxonomy choices for feed
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_taxonomy_name_choices() {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$taxonomy_name_choices = array( array( 'label' => __( 'Select name' ), 'value' => '' ));

		$taxonomies = get_taxonomies( array(), 'objects' );

		foreach ( $taxonomies as $taxonomy_name => $taxonomy_info ) {

			$taxonomy_name_choices[] = array( 'label' => $taxonomy_info->labels->name, 'value' => $taxonomy_name );

		}


		return $taxonomy_name_choices;

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


		return array( array( 'label' => __( 'Select label' ), 'value' => '' ),
			array( 'label' => __( 'Name', 'gravityplus-dynamic-population' ), 'value' => 'name' ) );

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
			array ( 'label' => __( 'ID', 'gravityplus-dynamic-population' ), 'value' => 'term_id'),
			array( 'label' => __( 'Name', 'gravityplus-dynamic-population' ), 'value' => 'name'),
			array( 'label' => __( 'Slug', 'gravityplus-dynamic-population' ), 'value' => 'slug'),
			array( 'label' => __( 'Term Taxonomy ID', 'gravityplus-dynamic-population' ), 'value' => 'term_taxonomy_id'));

	}

	/**
	 * @since  1.5.0
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
		     && 'taxonomy' == $field[ 'dynamicChoicesSource' ]
		     && ! empty( $field[ 'dynamicChoicesTaxonomyName' ] )
		     && ! empty( $field[ 'dynamicChoicesTaxonomyValue' ] ) ) {

			$has_dynamic_choice = true;

		}


		return $has_dynamic_choice;
	}

	/**
	 * @since  1.5.0
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

		if ( 'taxonomy' == $source ) {

			if ( 'field' == $type ) {

				$taxonomy_settings = array(
					'name'  => rgar( $field_or_feed, 'dynamicChoicesTaxonomyName' ),
					'label' => rgar( $field_or_feed, 'dynamicChoicesTaxonomyLabel' ),
					'value' => rgar( $field_or_feed, 'dynamicChoicesTaxonomyValue' ),
				);

			}
			else if ( 'feed' == $type ) {

				$addon_object = GFP_Dynamic_Population_Addon::get_instance();

				$taxonomy_settings = array(
					'name' => $addon_object->get_setting( 'source_taxonomy_name', '', $field_or_feed['meta'] ),
					'label'         => $addon_object->get_setting( 'source_taxonomy_label', '', $field_or_feed['meta'] ),
					'value'         => $addon_object->get_setting( 'source_taxonomy_value', '', $field_or_feed['meta'] ),
				);

			}

			if ( empty( $taxonomy_settings['label'] ) ) {

				$taxonomy_settings['label'] = 'name';

			}

			$dynamic_choice_settings = array_merge( $dynamic_choice_settings, $taxonomy_settings );
		}


		return $dynamic_choice_settings;
	}

	/**
	 * @since  1.5.0
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

		if ( 'taxonomy' == $dynamic_choice_info['source'] ) {

			$options = GFP_Dynamic_Population_API::get_taxonomy_choices( $dynamic_choice_info, true );

		}


		return $options;
	}

	/**
	 * @since  1.5.0
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
	public function gfp_dynamic_population_form_display_get_dynamic_choices_values( $values, $source, $dynamic_choice_source_settings, $form, $field ){

		if ( 'taxonomy' == $source ) {

			$values = GFP_Dynamic_Population_API::get_taxonomy_choices( $dynamic_choice_source_settings, true );

		}


		return $values;
	}


	public function gfp_dynamic_population_dynamic_value_field_source_settings( $dynamic_source_settings, $source, $feed, $field ) {

		if ( 'taxonomy' == $source ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$taxonomy_settings = array(
				'name' => $addon_object->get_setting( 'source_taxonomy_name', '', $feed['meta'] ),
				'label'         => $addon_object->get_setting( 'source_taxonomy_label', '', $feed['meta'] ),
				'value'         => $addon_object->get_setting( 'source_taxonomy_value', '', $feed['meta'] ),
				'sort_order'   => $addon_object->get_setting( 'sort_order', '', $feed['meta'] )
			);

		if ( empty( $taxonomy_settings['label'] ) ) {

			$taxonomy_settings['label'] = 'name';

		}

			$dynamic_source_settings = array_merge( $dynamic_source_settings, $taxonomy_settings );

		}


		return $dynamic_source_settings;
	}

	public function gfp_dynamic_population_form_display_populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, $get_from_post ) {

		if ( 'taxonomy' == $dynamic_value_info['source'] ) {

			/*$where_rules = array();

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

			}*/

			$retrieved_values = GFP_Dynamic_Population_API::get_taxonomy_choices( $dynamic_value_info, false );


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

		if ( 'taxonomy' == $source ) {

			$retrieved_values = GFP_Dynamic_Population_API::get_taxonomy_choices( $dynamic_value_source_settings, false );

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
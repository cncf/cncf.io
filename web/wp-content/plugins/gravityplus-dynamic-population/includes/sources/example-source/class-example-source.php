<?php
/**
 * @package   GFP_Dynamic_Population
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.4.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_Example_Source
 *
 * Adds example dynamic choices source
 *
 * @since  1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Example_Source {

	private $data = array( 'option1' =>
		                       array( 'dependent1' =>
			                              array( 'example_value_1' => /*__(*/ 'Example Value 1'/*, 'gravityplus-dynamic-population' )*/,
			                                     'example_value_3' => /*__(*/ 'Example Value 3'/*, 'gravityplus-dynamic-population' )*/,
			                                     'example_value_5' => /*__(*/ 'Example Value 5'/*, 'gravityplus-dynamic-population' )*/
			                              ),
		                              'dependent2' =>
			                              array( 'example_value_2' => /*__(*/ 'Example Value 2'/*, 'gravityplus-dynamic-population' )*/,
			                                     'example_value_4' => /*__(*/ 'Example Value 4'/*, 'gravityplus-dynamic-population' )*/,
			                              )
		                       ),
	                       'option2' =>
		                       array( 'dependent3' =>
			                              array( 'example_value_6' => /*__(*/ 'Example Value 6'/*, 'gravityplus-dynamic-population' )*/,
			                                     'example_value_7' => /*__(*/ 'Example Value 7'/*, 'gravityplus-dynamic-population' )*/,
			                              ),
		                              'dependent5' =>
			                              array( 'example_value_8' => /*__(*/ 'Example Value 8'/*, 'gravityplus-dynamic-population' )*/,
			                                     'example_value_9' => /*__(*/ 'Example Value 9'/*, 'gravityplus-dynamic-population' )*/,
			                              ),
		                              'dependent4' =>
			                              array( 'example_value_1' => /*__(*/ 'Example Value 1'/*, 'gravityplus-dynamic-population' )*/,
			                                     'example_value_5' => /*__(*/ 'Example Value 5'/*, 'gravityplus-dynamic-population' )*/,
			                              )
		                       ) );

	/**
	 * GFP_Dynamic_Population_Example_Source constructor.
	 *
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		add_filter( 'gfp_dynamic_population_sources', array( $this, 'gfp_dynamic_population_sources' ) );

		add_action( 'gfp_dynamic_population_dynamic_choices_field_settings_container', array( $this, 'gfp_dynamic_population_dynamic_choices_field_settings_container' ) );

		add_action( 'admin_init', array( $this, 'admin_init' ) );

		add_filter( 'gfp_dynamic_population_api_has_dynamic_choice', array( $this, 'gfp_dynamic_population_api_has_dynamic_choice' ), 10, 2 );

		add_filter( 'gfp_dynamic_population_api_dynamic_choice_source_settings', array( $this, 'gfp_dynamic_population_api_dynamic_choice_source_settings' ), 10, 3 );

		add_filter( 'gfp_dynamic_population_form_display_populate_options', array( $this, 'gfp_dynamic_population_form_display_populate_options' ), 10, 6 );

		add_filter( 'gfp_dynamic_population_form_display_get_dynamic_choices_values', array( $this, 'gfp_dynamic_population_form_display_get_dynamic_choices_values' ), 10, 5 );

	}

	/**
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $sources
	 *
	 * @return mixed
	 */
	public function gfp_dynamic_population_sources( $sources ) {

		$sources[ 'example' ] = __( 'Example', 'gravityplus-dynamic-population' );


		return $sources;

	}

	/**
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gfp_dynamic_population_dynamic_choices_field_settings_container() {

		require_once( trailingslashit( GFP_DYNAMIC_POPULATION_PATH ) . 'includes/sources/example-source/views/field-setting-dynamic_choices.php' );

	}

	/**
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function admin_init() {

		if ( 'gf_edit_forms' == GFForms::get( 'page' ) ) {

			add_action( 'gform_editor_js', array( $this, 'gform_editor_js' ) );

			add_filter( 'gform_noconflict_scripts', array( $this, 'gform_noconflict_scripts' ) );

			add_filter( 'gform_tooltips', array( $this, 'gform_tooltips' ) );

		}

	}

	/**
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_editor_js() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'gfp_dynamic_population_form_editor_example_source', trailingslashit( GFP_DYNAMIC_POPULATION_URL ) . "includes/sources/example-source/js/dynamic-choices.editor{$suffix}.js", array( 'gfp_dynamic_population_form_editor' ), GFP_DYNAMIC_POPULATION_CURRENT_VERSION );

		$dependent_options = array(
			'option1' => array( 'dependent1', 'dependent2' ),
			'option2' => array( 'dependent3', 'dependent5', 'dependent4' )
		);

		$select_dependent_placeholder = '<option value="">' . __( 'Select a dependent', 'gravityplus-dynamic-population' ) . '</option>';

		wp_localize_script( 'gfp_dynamic_population_form_editor_example_source', 'gfp_dynamic_population_example_data', array(
			'dependents'                   => $dependent_options,
			'select_dependent_placeholder' => $select_dependent_placeholder,
		) );

	}

	/**
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $noconflict_scripts
	 *
	 * @return array
	 */
	public static function gform_noconflict_scripts( $noconflict_scripts ) {

		$noconflict_scripts = array_merge( $noconflict_scripts, array( 'gfp_dynamic_population_form_editor_example_source' ) );


		return $noconflict_scripts;

	}

	/**
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $tooltips
	 *
	 * @return array
	 */
	public static function gform_tooltips( $tooltips ) {

		$example_source_tooltips = array(
			'form_field_example_something' => '<h6>' . __( 'Please select something', 'gravityplus-dynamic-population' ) . '</h6>' . __( 'I really need you to select something', 'gravityplus-dynamic-population' ),
		);


		return array_merge( $tooltips, $example_source_tooltips );

	}

	/**
	 * @since  1.4.0
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
		     && 'example' == $field[ 'dynamicChoicesSource' ]
		     && ! empty( $field[ 'dynamicChoicesExampleSomething' ] )
		     && ! empty( $field[ 'dynamicChoicesExampleSomethingDependent' ] ) ) {

			$has_dynamic_choice = true;

		}


		return $has_dynamic_choice;
	}

	/**
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $dynamic_choice_settings
	 * @param $source
	 * @param $field
	 *
	 * @return array
	 */
	public function gfp_dynamic_population_api_dynamic_choice_source_settings( $dynamic_choice_settings, $source, $field ) {

		if ( 'example' == $source ) {

			$example_source_settings = array(
				'something'           => rgar( $field, 'dynamicChoicesExampleSomething' ),
				'something_dependent' => rgar( $field, 'dynamicChoicesExampleSomethingDependent' ),
			);

			$dynamic_choice_settings = array_merge( $dynamic_choice_settings, $example_source_settings );
		}


		return $dynamic_choice_settings;
	}

	public function gfp_dynamic_population_form_display_populate_options( $options, $form, $field_id, $dynamic_choice_info, $field_values, $get_from_post ) {

		if ( 'example' == $dynamic_choice_info['source'] ) {

			$values = $this->data[ $dynamic_choice_info['something'] ][ $dynamic_choice_info['something_dependent'] ];

			foreach ( $values as $id => $label ) {

				$options[ ] = array( 'text' => $label, 'value' => $id, 'isSelected' => false, 'price' => '' );

			}

		}


		return $options;
	}

	public function gfp_dynamic_population_form_display_get_dynamic_choices_values( $values, $source, $dynamic_choice_source_settings, $form, $field ){

		if ( 'example' == $source ) {

			$values = $this->data[ $dynamic_choice_source_settings['something'] ][ $dynamic_choice_source_settings['something_dependent'] ];

		}


		return $values;
	}

}
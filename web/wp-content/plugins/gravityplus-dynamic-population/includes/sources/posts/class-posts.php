<?php
/**
 * @package   GFP_Dynamic_Population
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.5.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Class GFP_Dynamic_Population_Posts
 *
 * Adds posts dynamic choices source
 *
 * Generously sponsored by MotoGrafik.com
 *
 * @since  1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Posts {

	/**
	 * Form object
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var array
	 */
	private $form = array();

	/**
	 * GFP_Dynamic_Population_Posts constructor.
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		add_filter( 'gfp_dynamic_population_sources', array( $this, 'gfp_dynamic_population_sources' ) );

		add_filter( 'gfp_dynamic_population_scripts', array( $this, 'gfp_dynamic_population_scripts' ), 10, 3 );

		add_action( 'gfp_dynamic_population_dynamic_choices_field_settings_container', array( $this, 'gfp_dynamic_population_dynamic_choices_field_settings_container' ) );

		add_filter( 'gform_' . GFP_DYNAMIC_POPULATION_SLUG . '_feed_settings_fields', array( $this, 'feed_settings_fields' ), 10, 2 );


		add_action( 'admin_init', array( $this, 'admin_init' ) );


		add_filter( 'gfp_dynamic_population_api_has_dynamic_choice', array( $this, 'gfp_dynamic_population_api_has_dynamic_choice' ), 10, 2 );


		add_filter( 'gfp_dynamic_population_api_dynamic_choice_source_settings', array( $this, 'gfp_dynamic_population_api_dynamic_choice_source_settings' ), 10, 4 );

		add_filter( 'gfp_dynamic_population_form_display_populate_options', array( $this, 'gfp_dynamic_population_form_display_populate_options' ), 10, 6 );

		add_filter( 'gfp_dynamic_population_form_display_get_dynamic_choices_values', array( $this, 'gfp_dynamic_population_form_display_get_dynamic_choices_values' ), 10, 6 );

		add_action( 'wp_ajax_gfp_dynamic_population_posts_get_terms', array( $this, 'ajax_get_terms' ) );


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

			$sources[ 'posts' ] = __( 'Posts', 'gravityplus-dynamic-population' );

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

		$filter_options = array( array( 'value' => 'taxonomy_term',
		                                'text' => __( 'Taxonomy', 'gravityplus-dynamic-population' ) ),
		);

		$scripts[] =
			array(
				'handle'    => 'gfp_dynamic_population_posts_admin',
				'src'       => GFP_DYNAMIC_POPULATION_URL . "/includes/sources/posts/js/admin{$suffix}.js",
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
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function admin_init() {

		if ( 'gf_edit_forms' == GFForms::get( 'page' ) ) {

			add_filter( 'gform_admin_pre_render', array( $this, 'gform_admin_pre_render' ) );

			add_action( 'gform_editor_js', array( $this, 'gform_editor_js' ) );

			add_filter( 'gform_noconflict_scripts', array( $this, 'gform_noconflict_scripts' ) );

		}

	}

	/**
	 * Get form that's being loaded
	 *
	 * @since  1.5.0
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
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gfp_dynamic_population_dynamic_choices_field_settings_container() {

		$post_types = get_post_types( array( 'public' => true ) );

		$taxonomies = get_taxonomies( array(), 'objects' );

		$all_option_label = __( 'All', 'gravityplus-dynamic-population' );

		$choice_label_options = array( 'post_title' => __( 'Title', 'gravityplus-dynamic-population' ) );

		$choice_value_options = array(
			'ID' => __( 'ID', 'gravityplus-dynamic-population' ),
		                        'post_title' => __( 'Title', 'gravityplus-dynamic-population' ),
		                        'post_name' => __( 'Slug', 'gravityplus-dynamic-population' )
		);

		require_once( trailingslashit( GFP_DYNAMIC_POPULATION_PATH ) . 'includes/sources/posts/views/field-setting-dynamic_choices.php' );

	}

	/**
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_editor_js() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'gfp_dynamic_population_form_editor_posts', trailingslashit( GFP_DYNAMIC_POPULATION_URL ) . "includes/sources/posts/js/dynamic-choices.editor{$suffix}.js", array( 'gfp_dynamic_population_form_editor' ), GFP_DYNAMIC_POPULATION_CURRENT_VERSION );

		$select_taxonomy_term_placeholder_text = __( 'Select', 'gravityplus-dynamic-population' );

		$choice_filter_strings = array(
			'actionType'          => __( 'Show', 'gravityplus-dynamic-population' ),
			'objectDescription'   => __( 'choices where', 'gravityplus-dynamic-population' ),
			'form_field_header'   => __( 'Form Field', 'gravityplus-dynamic-population' ),
			'values_column_header' => __( 'Filter Option', 'gravityplus-dynamic-population' )
		);

		$filter_options = array( array( 'value' => 'taxonomy_term',
		                         'text' => __( 'Taxonomy', 'gravityplus-dynamic-population' ) ),
			);

		wp_localize_script( 'gfp_dynamic_population_form_editor_posts', 'gfp_dynamic_population_posts_data', array(
			'current_settings' => $this->get_current_settings_info(),
			'placeholders'     => array(
				'taxonomy_term' => $select_taxonomy_term_placeholder_text,
			),
			'choice_filter_strings'     => $choice_filter_strings,
			'filter_options' => $filter_options
		) );

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

		$noconflict_scripts = array_merge( $noconflict_scripts, array( 'gfp_dynamic_population_form_editor_posts' ) );


		return $noconflict_scripts;

	}

	/**
	 * Get the selected dynamically populated field settings
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_current_settings_info() {

		$current_settings_info = array();

		if ( ! empty( $this->form ) && GFP_Dynamic_Population_API::has_dynamic_choice_field( $this->form, 'posts' ) ) {

			$dynamic_choice_fields = GFP_Dynamic_Population_API::get_dynamic_choice_fields( $this->form, 'posts' );

			foreach ( $dynamic_choice_fields as $key => $dynamic_choice_field_info ) {

				$taxonomy_term = $this->get_chosen_taxonomy_term( $dynamic_choice_field_info );

				if ( empty( $taxonomy_term ) ) {

					unset( $current_settings_info[ $key ] );

					continue;

				}

				$current_settings_info[ $key ][ 'taxonomy_term' ] = array( $taxonomy_term );

			}

		}

		return $current_settings_info;

	}

	/**
	 * Get taxonomy term user chose in dynamic population field settings
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $field_info
	 *
	 * @return array
	 */
	private function get_chosen_taxonomy_term( $field_info ) {

		$taxonomy_term_choice = array();

		if ( ! empty( $field_info[ 'taxonomy_term' ] ) ) {

			if ( 'all' == $field_info['taxonomy_term'] ) {

				$all_option_label = __( 'All', 'gravityplus-dynamic-population' );

				$taxonomy_term_choice = array(
					'label' => $all_option_label,
					'value' => $field_info[ 'taxonomy_term' ]
				);

			}
			else {

				$term = get_term_by( 'term_taxonomy_id', $field_info[ 'taxonomy_term' ] );

				if ( ! empty( $term ) ) {

					$taxonomy_term_choice = array(
						'label' => $term->name,
						'value' => $field_info[ 'taxonomy_term' ]
					);

				}

			}


		}


		return $taxonomy_term_choice;
	}

	/**
	 * Get terms for the chosen taxonomy
	 *
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function ajax_get_terms() {

		$taxonomy = rgpost( 'taxonomy' );

		if ( ! empty( $taxonomy ) ) {

			$term_choices = GFP_Dynamic_Population_API::get_taxonomy_choices( array( 'name' => $taxonomy, 'label' => 'name', 'value' => 'term_taxonomy_id' ), false );

			if ( ! empty( $term_choices ) ) {

				$selected = '';

				$all_option_label = __( 'All', 'gravityplus-dynamic-population' );

				if ( 1 < count( $term_choices ) ) {

					$placeholder = array(
						'text'       => '--' . __( 'Select', 'gravityplus-dynamic-population' ) . " $taxonomy--",
						'value'      => '',
						'isSelected' => true,
						'price'      => ''
					);

					$options = '<option value="' . $placeholder[ 'value' ] . '" selected="selected">' . $placeholder[ 'text' ] . '</option>';

				} else {

					$selected = 'selected="selected"';
					$options  = '';

				}

				$options = '<option value="all" ' . $selected . '>' . $all_option_label . '</option>';

				foreach ( $term_choices as $term_choice ) {

					$options .= '<option value="' . $term_choice[ 1 ] . '">' . $term_choice[ 0 ] . '</option>';

				}

				wp_send_json_success( array(
					'options' => $options,
				) );
			}

		}

		wp_send_json_error();
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

		if ( 'posts' == $source ) {

			$object_to_populate = $addon_object->get_setting( 'object' );

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Post Type', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_posts_type',
				'choices'    => $this->get_post_type_choices(),
				'required'   => true,
				'dependency' => array( 'field' => 'source', 'values' => array( 'posts' ) )
			);


			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
				'label'      => __( 'Taxonomy Type', 'gravityplus-dynamic-population' ),
				'type'       => 'select',
				'name'       => 'source_posts_taxonomy',
				'choices'    => $this->get_taxonomy_type_choices(),
				'default_value' => 'all',
				'required'   => true,
				'onchange'   => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );",
				'dependency' => array( 'field' => 'source', 'values' => array( 'posts' ) )
			);

			$taxonomy = $addon_object->get_setting( 'source_posts_taxonomy' );

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
					'label'      => __( 'Taxonomy', 'gravityplus-dynamic-population' ),
					'type'       => 'select',
					'name'       => 'source_posts_taxonomy_term',
					'choices'    => $this->get_taxonomy_term_choices( $taxonomy ),
					'default_value' => 'all',
					'required'   => true,
					'dependency' => array( 'field' => 'source_posts_taxonomy', 'comparison' => 'isnot', 'values' => array( 'all', '' ), 'logic' => 'all' )
				);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
					'label'      => __( 'Choice Label', 'gravityplus-dynamic-population' ),
					'type'       => 'select',
					'name'       => 'source_posts_label',
					'choices'    => $this->get_choice_label_choices(),
					'required'   => true,
					'dependency' => array( 'field' => 'source', 'values' => array( 'posts' ) )
				);

			$feed_settings_fields[ 'section_source_settings' ][ 'fields' ][] = array(
					'label'      => __( 'Choice Value', 'gravityplus-dynamic-population' ),
					'type'       => 'select',
					'name'       => 'source_posts_value',
					'choices'    => $this->get_choice_value_choices(),
					'required'   => true,
					'dependency' => array( 'field' => 'source', 'values' => array( 'posts' ) )
				);

			$feed_settings_fields['section_filter']['fields'][0]['fields_column_header'] = __( 'Filter Option', 'gravityplus-dynamic-population' );

			$feed_settings_fields['section_filter']['fields'][0]['values_column_header'] = __( 'Form Field', 'gravityplus-dynamic-population' );

			$feed_settings_fields['section_filter']['dependency']['values'][] = 'posts';

		}


		return $feed_settings_fields;
	}

	/**
	 * Get post type choices for feed settings field
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_post_type_choices() {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$post_type_choices = array( array( 'label' => __( 'Select post type' ), 'value' => '' ),
			array( 'label' => __( 'All', 'gravityplus-dynamic-population' ), 'value' => 'all' ));

		$post_types = get_post_types( array( 'public' => true ) );

		foreach ( $post_types as $post_type_name ) {

			$post_type_choices[] = array( 'label' => $post_type_name, 'value' => $post_type_name );

		}


		return $post_type_choices;

	}

	/**
	 * Get taxonomy type choices for feed settings field
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_taxonomy_type_choices() {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$taxonomy_type_choices = array( array( 'label' => __( 'Select taxonomy type' ), 'value' => '' ),
			array( 'label' => __( 'All', 'gravityplus-dynamic-population' ), 'value' => 'all' ));

		$taxonomies = get_taxonomies( array(), 'objects' );

		foreach ( $taxonomies as $taxonomy_name => $taxonomy_info ) {

			$taxonomy_type_choices[] = array( 'label' => $taxonomy_info->labels->name, 'value' => $taxonomy_name );

		}


		return $taxonomy_type_choices;

	}

	/**
	 * Get taxonomy term choices for feed settings field
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_taxonomy_term_choices( $taxonomy ) {

		GFP_Dynamic_Population_Addon::get_instance()->log_debug( __METHOD__ );

		$taxonomy_term_choices = array( array( 'label' => __( 'Select taxonomy' ), 'value' => '' ),
			array( 'label' => __( 'All', 'gravityplus-dynamic-population' ), 'value' => 'all' ));

		if ( ! empty( $taxonomy ) ) {

			$term_choices = GFP_Dynamic_Population_API::get_taxonomy_choices( array( 'name'  => $taxonomy,
	                                                                         'label' => 'name',
	                                                                         'value' => 'term_taxonomy_id' ), false );

			foreach ( $term_choices as $term_choice ) {

				$taxonomy_term_choices[] = array( 'label' => $term_choice[ 0 ], 'value' => $term_choice[ 1 ] );

			}

		}


		return $taxonomy_term_choices;

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
			array( 'label' => __( 'Title', 'gravityplus-dynamic-population' ), 'value' => 'post_title' ) );

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
			array ( 'label' => __( 'ID', 'gravityplus-dynamic-population' ), 'value' => 'ID'),
			array( 'label' => __( 'Title', 'gravityplus-dynamic-population' ), 'value' => 'post_title'),
			array( 'label' => __( 'Slug', 'gravityplus-dynamic-population' ), 'value' => 'post_name') );

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
		     && 'posts' == $field[ 'dynamicChoicesSource' ]
		     && ! empty( $field[ 'dynamicChoicesPostsType' ] )
		     && ! empty( $field[ 'dynamicChoicesPostsTaxonomy' ] )
		     && ! empty( $field[ 'dynamicChoicesPostsTaxonomyTerm' ] )
		     && ! empty( $field[ 'dynamicChoicesPostsLabel' ] )
		     && ! empty( $field[ 'dynamicChoicesPostsValue' ] )
		) {

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

		if ( 'posts' == $source ) {

			if ( 'field' == $type ) {

				$posts_settings = array(
					'post_type'     => rgar( $field_or_feed, 'dynamicChoicesPostsType' ),
					'taxonomy'      => rgar( $field_or_feed, 'dynamicChoicesPostsTaxonomy' ),
					'taxonomy_term' => rgar( $field_or_feed, 'dynamicChoicesPostsTaxonomyTerm' ),
					'label'         => rgar( $field_or_feed, 'dynamicChoicesPostsLabel' ),
					'value'         => rgar( $field_or_feed, 'dynamicChoicesPostsValue' ),
				);

			}
			else if ( 'feed' == $type ) {

				$addon_object = GFP_Dynamic_Population_Addon::get_instance();

				$posts_settings = array(
					'post_type'     => $addon_object->get_setting( 'source_posts_type', '', $field_or_feed['meta'] ),
					'taxonomy'      => $addon_object->get_setting( 'source_posts_taxonomy', '', $field_or_feed['meta'] ),
					'taxonomy_term' => $addon_object->get_setting( 'source_posts_taxonomy_term', '', $field_or_feed['meta'] ),
					'label'         => $addon_object->get_setting( 'source_posts_label', '', $field_or_feed['meta'] ),
					'value'         => $addon_object->get_setting( 'source_posts_value', '', $field_or_feed['meta'] ),
				);

			}


			if ( empty( $posts_settings['label'] ) ) {

				$posts_settings['label'] = 'post_title';

			}

			$dynamic_choice_settings = array_merge( $dynamic_choice_settings, $posts_settings );
		}


		return $dynamic_choice_settings;
	}

	/**
	 * @since  1.5.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $dynamic_choice_info
	 * @param array $filters
	 * @param bool $formatted
	 *
	 * @return array
	 */
	private function get_posts_choices( $dynamic_choice_info, $filters, $formatted ) {

		$choices = array();

		$args = array(
			'nopaging'   => true
		);

		if( 'all' !== $dynamic_choice_info['post_type'] ){

			$args['post_type'] = $dynamic_choice_info['post_type'];

		}

		if ( ! empty( $filters ) ) {

			foreach( $filters as $filter ) {

				switch( $filter['column'] ) {

					case 'taxonomy_term':

						if( 'all' !== $dynamic_choice_info['taxonomy'] ) {

							$args[ 'tax_query' ] = array(
								array(
									'taxonomy' => $dynamic_choice_info[ 'taxonomy' ],
									'field'    => 'term_taxonomy_id',
									'terms'    => $filter[ 'value' ]
								)
							);

						}

						break;

				}

			}

		}

		if( empty( $args[ 'tax_query' ] ) && 'all' !== $dynamic_choice_info['taxonomy'] ){

			if( 'all' == $dynamic_choice_info['taxonomy_term'] ) {

				$terms = get_terms( array( 'taxonomy' => $dynamic_choice_info['taxonomy'], 'hide_empty' => false ) );

				if( ! is_wp_error( $terms ) ) {

					$terms_query = wp_list_pluck( $terms, 'term_taxonomy_id' );
				}

			}
			else {

				$terms_query = $dynamic_choice_info['taxonomy_term'];
			}

			if ( ! empty( $terms_query ) ) {

				$args[ 'tax_query' ] = array(
					array(
						'taxonomy' => $dynamic_choice_info[ 'taxonomy' ],
						'field'    => 'term_taxonomy_id',
						'terms'    => $terms_query
					)
				);

			}
		}

		$posts = get_posts( $args );


		foreach ( $posts as $post ) {

			$choices[] = $formatted
				?
				array(
				'text' => $post->{$dynamic_choice_info['label']},
				'value' => $post->{$dynamic_choice_info['value']},
				'isSelected' => false,
				'price' => '' )
				:
				array( $post->{$dynamic_choice_info['label']}, $post->{$dynamic_choice_info['value']});

		}


		return $choices;
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

		if ( 'posts' == $dynamic_choice_info['source'] ) {

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

			$options = $this->get_posts_choices( $dynamic_choice_info, $where_rules, true );

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
	public function gfp_dynamic_population_form_display_get_dynamic_choices_values( $values, $source, $dynamic_choice_source_settings, $form, $field, $filters ){

		if ( 'posts' == $source ) {

			$values = $this->get_posts_choices( $dynamic_choice_source_settings, $filters, true );

		}


		return $values;
	}


	public function gfp_dynamic_population_dynamic_value_field_source_settings( $dynamic_source_settings, $source, $feed, $field ) {

		if ( 'posts' == $source ) {

			$addon_object = GFP_Dynamic_Population_Addon::get_instance();

			$posts_settings = array(
				'post_type'     => $addon_object->get_setting( 'source_posts_type', '', $feed['meta'] ),
				'taxonomy'      => $addon_object->get_setting( 'source_posts_taxonomy', '', $feed['meta'] ),
				'taxonomy_term' => $addon_object->get_setting( 'source_posts_taxonomy_term', '', $feed['meta'] ),
				'label'         => $addon_object->get_setting( 'source_posts_label', '', $feed['meta'] ),
				'value'         => $addon_object->get_setting( 'source_posts_value', '', $feed['meta'] ),
				'sort_order'   => $addon_object->get_setting( 'sort_order', '', $feed['meta'] )

			);

			if ( empty( $posts_settings['label'] ) ) {

				$posts_settings['label'] = 'post_title';

			}

			$dynamic_source_settings = array_merge( $dynamic_source_settings, $posts_settings );

		}


		return $dynamic_source_settings;
	}

	public function gfp_dynamic_population_form_display_populate_field_value( $form, $field_id, $dynamic_value_info, $field_values, $get_from_post ) {

		if ( 'posts' == $dynamic_value_info['source'] ) {

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

			$retrieved_values = $this->get_posts_choices( $dynamic_value_info, $where_rules, false );

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

		if ( 'posts' == $source ) {

			$retrieved_values = $this->get_posts_choices( $dynamic_value_source_settings, $dependees, false );

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
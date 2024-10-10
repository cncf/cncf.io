<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Third_Party
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Filter_Third_Party {

	private $plugin_slug = '';
	private $form_data   = '';
	private $count_table;
	private $cache;
	private $relevanssi_result_ids = array();
	private $query;

	private $custom_layouts_query_id = 0;
	private $polylang_post_types     = array();
	private $sfid                    = 0;

	public $cache_table_name;
	private $woocommerce;

	public function __construct() {
		global $wpdb;

		$this->cache_table_name = Search_Filter_Helper::get_table_name( 'search_filter_cache' );
		$this->woocommerce      = new Search_Filter_Third_Party_Woocommerce();
		// frontend only, or ajax
		if ( ( ! is_admin() ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

			// beaverbuilder themer plugin
			// removes paged = 1 from pagination when its the first page, otherwise themer kicks in a scroll on page load
			add_filter( 'sf_main_query_pre_get_posts', array( $this, 'sf_beaver_themer_pre_get_posts' ), 11, 2 );
			// -- relevanssi
			add_filter( 'sf_edit_query_args_after_custom_filter', array( $this, 'relevanssi_filter_query_args' ), 12, 2 );
			add_filter( 'sf_apply_custom_filter', array( $this, 'relevanssi_add_custom_filter' ), 10, 3 );

			// -- polylang
			add_filter( 'sf_archive_results_url', array( $this, 'pll_sf_archive_results_url' ), 10, 3 );
			add_filter( 'sf_ajax_results_url', array( $this, 'pll_sf_ajax_results_url' ), 10, 2 );
			add_filter( 'sf_ajax_form_url', array( $this, 'pll_sf_form_url' ), 10, 3 );

			// -- ACF + WPML - looks like WPML fixed this
			// add_filter('sf_input_object_acf_field', array($this, 'acf_translate_field'), 10, 3);

			if ( class_exists( 'Easy_Digital_Downloads' ) ) {
				add_filter( 'shortcode_atts_downloads', array( $this, 'edd_filter_downloads_shortcode' ), 1000, 3 );
				add_filter( 'do_shortcode_tag', array( $this, 'edd_filter_downloads_shortcode_output' ), 1000, 3 );
				add_filter( 'search_filter_form_attributes', array( $this, 'edd_search_filter_form_attributes' ), 10, 2 );
			}
			if ( class_exists( 'Easy_Digital_Downloads' ) ) {
				add_filter( 'shortcode_atts_downloads', array( $this, 'edd_filter_downloads_shortcode' ), 1000, 3 );
				add_filter( 'do_shortcode_tag', array( $this, 'edd_filter_downloads_shortcode_output' ), 1000, 3 );
				add_filter( 'search_filter_form_attributes', array( $this, 'edd_search_filter_form_attributes' ), 10, 2 );
			}

			// -- custom layouts
			add_filter( 'shortcode_atts_custom-layout', array( $this, 'custom_layouts_shortcode_attributes' ), 1000, 3 );
			add_filter( 'search_filter_form_attributes', array( $this, 'custom_layouts_search_filter_form_attributes' ), 10, 2 );
		}

		// -- polylang
		add_filter( 'sf_edit_query_args', array( $this, 'sf_poly_query_args' ), 11, 2 );
		add_filter( 'pll_get_post_types', array( $this, 'pll_sf_add_translations' ), 10, 2 );
		add_filter( 'pll_get_post_types', array( $this, 'pll_sf_get_translations' ), 100000, 2 ); // try to set this as late as possible
		add_filter( 'sf_edit_cache_query_args', array( $this, 'poly_lang_sf_edit_cache_query_args' ), 10, 2 );
		add_filter( 'sf_edit_search_forms_query_args', array( $this, 'poly_lang_sf_edit_cache_query_args' ), 10, 2 ); // set the language when fetching our built in search forms (suppress filters no longer works)
		add_filter( 'sf_archive_slug_rewrite', array( $this, 'pll_sf_archive_slug_rewrite' ), 10, 3 );
		add_filter( 'sf_rewrite_query_args', array( $this, 'pll_sf_rewrite_args' ), 10, 3 );
		add_filter( 'sf_pre_get_posts_admin_cache', array( $this, 'sf_pre_get_posts_admin_cache' ), 10, 3 );
		add_action( 'search_filter_pre_update_post_cache', array( $this, 'sf_wpml_update_post_cache' ), 10, 2 );
		if ( Search_Filter_Helper::has_dynamic_ooo() ) {
			add_filter( 'search_filter_admin_option_display_results', array( $this, 'dce_filter_display_results_options' ), 10, 2 );
			add_filter( 'search_filter_form_attributes', array( $this, 'dce_search_filter_form_attributes' ), 10, 2 );
		}

		$this->init();
	}

	public function acf_translate_field( $field, $field_name, $sfid ) {
		if ( ! Search_Filter_Helper::has_wpml() ) {
			return $field;
		}
		if ( ! function_exists( 'acf_get_field' ) ) {
			return $field;
		}

		if ( $field ) {
			$field_key = $field['key'];
			$field_ID  = $field['ID'];

			// now try to find the translated versino
			$field_group_id = wp_get_post_parent_id( $field_ID );
			if ( $field_group_id ) {
				$translated_group_id = Search_Filter_Helper::wpml_object_id( $field_group_id, 'acf-field-group', true );
				if ( $translated_group_id ) {
					global $wpdb;
					$result = $wpdb->get_row(
						$wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE post_excerpt='%s' AND post_parent='%d'", $field_name, $translated_group_id )
					);
					if ( $result ) {
						$translated_field = acf_get_field( $result->ID );
						if ( $translated_field ) {
							$field = $translated_field;
						}
					}
				}
			}
		}
		return $field;
	}

	public function custom_layouts_shortcode_attributes( $out, $pairs, $atts ) {
		if ( ! isset( $atts['search_filter_id'] ) ) {
			return $out;
		}

		$this->custom_layouts_query_id = absint( $atts['search_filter_id'] );
		add_filter( 'custom-layouts\layout\query_args', array( $this, 'custom_layouts_add_sf_query' ) );
		remove_filter( 'shortcode_atts_custom-layouts', array( $this, 'custom_layouts_shortcode_attributes' ), 1000, 3 );
		$out['cache'] = 'no'; // disable query caching and handle within S&F
		return $out;
	}
	public function custom_layouts_add_sf_query( $query_args ) {
		if ( $this->custom_layouts_query_id !== 0 ) {
			$query_args['search_filter_id'] = $this->custom_layouts_query_id;
			$this->custom_layouts_query_id  = 0;
		}

		remove_filter( 'custom-layouts\layout\query_args', array( $this, 'custom_layouts_add_sf_query' ) );
		return $query_args;
	}

	public function init() {
	}

	/* EDD integration */
	public function edd_filter_downloads_shortcode( $out, $pairs, $atts ) {
		if ( ! isset( $atts['search_filter_id'] ) ) {
			return $out;
		}

		$search_filter_id = intval( $atts['search_filter_id'] );
		do_shortcode( "[searchandfilter id='$search_filter_id' action='filter_next_query']" );
		// do_action("search_filter_setup_pagination", $search_filter_id);
		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $search_filter_id );
		$sf_inst->query->prep_query();

		return $out;
	}

	public function edd_filter_downloads_shortcode_output( $output, $tag, $atts ) {
		if ( ! isset( $atts['search_filter_id'] ) ) {
			return $output;
		}

		if ( $tag !== 'downloads' ) {
			return $output;
		}

		global $searchandfilter;
		$search_filter_id = intval( $atts['search_filter_id'] );

		$sf_inst = $searchandfilter->get( $search_filter_id );

		// make sure this search form is tyring to use EDD
		if ( $sf_inst->settings( 'display_results_as' ) == 'custom_edd_store' ) {

			// wrap both pagination + results in 1 container for ajax
			$output = '<div class="search-filter-results search-filter-results-' . $search_filter_id . '">' . $output . '</div>';
		}

		return $output;
	}
	public function edd_search_filter_form_attributes( $attributes, $sfid ) {
		if ( isset( $attributes['data-display-result-method'] ) ) {
			if ( $attributes['data-display-result-method'] == 'custom_edd_store' ) {
				$attributes['data-ajax-target'] = '.search-filter-results-' . $sfid;

				// for fixing pagination issue when there are multiple instance of the S&F.
				$attributes['data-ajax-links-selector'] = '.search-filter-results-' . $sfid . ' .edd_pagination a';
			}
		}

		return $attributes;
	}
	public function custom_layouts_search_filter_form_attributes( $attributes, $sfid ) {
		if ( isset( $attributes['data-display-result-method'] ) ) {
			if ( $attributes['data-display-result-method'] == 'custom_layouts' ) {
				$attributes['data-ajax-target'] = '.search-filter-results-' . $sfid;
				if ( defined( 'CUSTOM_LAYOUTS_VERSION' ) && version_compare( CUSTOM_LAYOUTS_VERSION, '1.3.2-beta', '<' ) ) {
					$attributes['data-ajax-target'] = '.cl-layout-container';
				}

				// for fixing pagination issue when there are multiple instance of the S&F.
				$attributes['data-ajax-links-selector'] = '.search-filter-results-' . $sfid . ' .cl-pagination a';
			}
		}
		return $attributes;
	}

	public function dce_search_filter_form_attributes( $attributes, $sfid ) {
		if ( isset( $attributes['data-display-result-method'] ) ) {
			$search_filter_results_class = '.search-filter-results-' . absint( $sfid );
			if ( $attributes['data-display-result-method'] == 'custom_dce_posts' ) {
				$attributes['data-ajax-target'] = '.elementor-widget-dce-dynamicposts-v2' . $search_filter_results_class;
				if ( defined( 'DCE_VERSION' ) && version_compare( DCE_VERSION, '1.13.0', '<' ) ) {
					$attributes['data-ajax-target'] = '.dce-posts-container';
				}

				// for fixing pagination issue when there are multiple instance of the S&F.
				$attributes['data-ajax-links-selector'] = '.elementor-widget-dce-dynamicposts-v2' . $search_filter_results_class . ' .dce-pagination a';

				if ( isset( $attributes['data-infinite-scroll-result-class'] ) ) {
					unset( $attributes['data-infinite-scroll-result-class'] );
				}

				if ( isset( $attributes['data-ajax-pagination-type'] ) ) {
					unset( $attributes['data-ajax-pagination-type'] );
				}

				if ( isset( $attributes['data-infinite-scroll-container'] ) ) {
					unset( $attributes['data-infinite-scroll-container'] );
				}
			} elseif ( $attributes['data-display-result-method'] == 'custom_dce_google_maps' ) {
				$attributes['data-ajax-target'] = '.elementor-widget-dyncontel-acf-google-maps' . $search_filter_results_class;

				// for fixing pagination issue when there are multiple instance of the S&F.
				$attributes['data-ajax-links-selector'] = '.elementor-widget-dyncontel-acf-google-maps' . $search_filter_results_class . ' .dce-pagination a';

				if ( isset( $attributes['data-infinite-scroll-result-class'] ) ) {
					unset( $attributes['data-infinite-scroll-result-class'] );
				}

				if ( isset( $attributes['data-ajax-pagination-type'] ) ) {
					unset( $attributes['data-ajax-pagination-type'] );
				}

				if ( isset( $attributes['data-infinite-scroll-container'] ) ) {
					unset( $attributes['data-infinite-scroll-container'] );
				}
			} elseif ( $attributes['data-display-result-method'] == 'custom_dce_google_maps_posts' ) {
				$attributes['data-ajax-target'] = '.elementor-widget-dyncontel-acf-google-maps' . $search_filter_results_class;

				// for fixing pagination issue when there are multiple instance of the S&F.
				$attributes['data-ajax-links-selector'] = '.elementor-widget-dyncontel-acf-google-maps' . $search_filter_results_class . ' .dce-pagination a';

				// we want additional areas to be udpated with ajax:
				$attributes['data-ajax-update-sections'] = wp_json_encode(
					array(
						'.elementor-widget-dce-dynamicposts-v2' . $search_filter_results_class,
					)
				);

				if ( isset( $attributes['data-infinite-scroll-result-class'] ) ) {
					unset( $attributes['data-infinite-scroll-result-class'] );
				}

				if ( isset( $attributes['data-ajax-pagination-type'] ) ) {
					unset( $attributes['data-ajax-pagination-type'] );
				}

				if ( isset( $attributes['data-infinite-scroll-container'] ) ) {
					unset( $attributes['data-infinite-scroll-container'] );
				}
			} else if ( $attributes['data-display-result-method'] == 'custom_dce_archives' ) {
				$attributes['data-ajax-target'] = '.elementor-widget-dce-dynamic-archives' . $search_filter_results_class;
				
				// for fixing pagination issue when there are multiple instance of the S&F.
				$attributes['data-ajax-links-selector'] = '.elementor-widget-dce-dynamic-archives' . $search_filter_results_class . ' .dce-pagination a';

				if ( isset( $attributes['data-infinite-scroll-result-class'] ) ) {
					unset( $attributes['data-infinite-scroll-result-class'] );
				}

				if ( isset( $attributes['data-ajax-pagination-type'] ) ) {
					unset( $attributes['data-ajax-pagination-type'] );
				}

				if ( isset( $attributes['data-infinite-scroll-container'] ) ) {
					unset( $attributes['data-infinite-scroll-container'] );
				}
			}
		}

		return $attributes;
	}

	public function dce_filter_display_results_options( $display_results_methods ) {
		$display_results_methods['custom_dce_posts'] = array(
			'label'       => __( 'Dynamic.ooo: Dynamic Posts' ),
			'description' =>
			'<p>' . __( 'Use the powerful Dynamic Posts widget for Elementor to create any kind of layout you can imagine.', $this->plugin_slug ) . '</p>' .
			'<p><a href="https://searchandfilter.com/documentation/3rd-party/dynamic-content-elementor/" target="_blank">' . __( 'View the setup instructions', $this->plugin_slug ) . '</a></p>',

			'base'        => 'shortcode',
		);
		if ( version_compare( DCE_VERSION, '2.13.0', '>=' ) ) {
			$display_results_methods['custom_dce_dynamic_archives'] = array(
				'label'       => __( 'Dynamic.ooo: Dynamic Archives' ),
				'description' =>
				'<p>' . __( 'Use the powerful Dynamic Archives widget for Elementor to create any kind of layout you can imagine.', $this->plugin_slug ) . '</p>' .
				'<p><a href="https://searchandfilter.com/documentation/3rd-party/dynamic-content-elementor/" target="_blank">' . __( 'View the setup instructions', $this->plugin_slug ) . '</a></p>',

				'base'        => 'shortcode',
			);
		}

		if ( version_compare( DCE_VERSION, '1.13.0', '>=' ) ) {
			$display_results_methods['custom_dce_google_maps'] = array(
				'label'       => __( 'Dynamic.ooo: Dynamic Google Maps' ),
				'description' =>
				'<p>' . __( 'Use the powerful Dynamic Google Maps widget for Elementor to create advanced searches that work with your maps!', $this->plugin_slug ) . '</p>' .
				'<p><a href="https://searchandfilter.com/documentation/3rd-party/dynamic-content-elementor/" target="_blank">' . __( 'View the setup instructions', $this->plugin_slug ) . '</a></p>',

				'base'        => 'shortcode',
			);
		}

		if ( version_compare( DCE_VERSION, '1.13.0', '>=' ) ) {
			$display_results_methods['custom_dce_google_maps_posts'] = array(
				'label'       => __( 'Dynamic.ooo: Dynamic Posts + Dynamic Google Maps' ),
				'description' =>
				'<p>' . __( 'Use the powerful Dynamic Google Maps widget combined with a Dynamic Posts widget to create advanced searches that work with your maps + posts at the same time!', $this->plugin_slug ) . '</p>' .
				'<p><a href="https://searchandfilter.com/documentation/3rd-party/dynamic-content-elementor/" target="_blank">' . __( 'View the setup instructions', $this->plugin_slug ) . '</a></p>',

				'base'        => 'shortcode',
			);
		}

		return $display_results_methods;
	}




	// update all the translations too (in case they were auto updated / synced by )
	// the advanced tranlsation editor
	public function sf_wpml_update_post_cache( $post ) {
		if ( ! Search_Filter_Helper::has_wpml() ) {
			return;
		}

		// $post_lang_code = Search_Filter_Helper::wpml_post_language_code($post_id);
		$element_type         = 'post_' . $post->post_type;
		$translation_group_id = apply_filters( 'wpml_element_trid', null, $post->ID, $element_type );
		$translations         = apply_filters( 'wpml_get_element_translations', null, $translation_group_id, $element_type );
		// $lang_details = apply_filters( 'wpml_post_language_details', "", $post->ID );
		$current_lang_code = strtolower( Search_Filter_Helper::wpml_post_language_code( $post->ID ) );

		if ( is_array( $translations ) ) {
			foreach ( $translations as $translation ) {
				$translation_lang = strtolower( $translation->language_code );
				// don't update the current post, because we're already doing it
				if ( $translation_lang !== $current_lang_code ) {

					if ( ( $current_lang_code !== '' ) && ( ! empty( $current_lang_code ) ) ) {
						do_action( 'wpml_switch_language', $translation_lang );

						// don't infinite loop...
						remove_action( 'search_filter_pre_update_post_cache', array( $this, 'sf_wpml_update_post_cache' ), 10, 2 );
						do_action( 'search_filter_update_post_cache', $translation->element_id );

						add_action( 'search_filter_pre_update_post_cache', array( $this, 'sf_wpml_update_post_cache' ), 10, 2 );                    }
				}
			}
		}

		do_action( 'wpml_switch_language', $current_lang_code );
	}





	// this is the last stage to modify the query, it doesn't modify anything relating to auto count or hte cache, only
	// the main query which is holding the actual results
	public function sf_beaver_themer_pre_get_posts( $query, $sfid ) {
		if ( ! class_exists( 'FLThemeBuilderLoader' ) ) {
			return $query;
		}

		if ( ! $query->is_main_query() ) {
			return $query;
		}

		if ( isset( $query->query_vars['search_filter_id'] ) ) {
			if ( $query->get( 'paged' ) == 1 ) {
				$query->set( 'paged', 0 );
			}
		}

		return $query;

	}

	// public function sf_edd_fes_field_save_frontend($field, $save_id, $value, $user_id)
	public function sf_edd_fes_field_save_frontend( $field, $save_id, $value ) {
		// FES has an issue where the same filter is used but with 3 args or 4 args
		// if the field is a digit, then actually this is the ID

		$post_id = 0;
		if ( ctype_digit( $field ) ) {
			$post_id = $field;
		} elseif ( ctype_digit( $save_id ) ) {
			$post_id = $save_id;
		}

		// do_action('search_filter_update_post_cache', $save_id);
	}
	public function sf_edd_fes_submission_form_published( $post_id ) {
		do_action( 'search_filter_update_post_cache', $post_id );
	}

	/* EDD integration */

	public function edd_prep_downloads_sf_query( $query, $atts ) {
		return $query;
	}

	// polylang integration
	// tells polylang that the post type `search-filter-widget` should be translatable
	public function pll_sf_add_translations( $types, $hide ) {
		$types['search-filter-widget'] = 'search-filter-widget';
		return $types;
	}
	public function pll_sf_get_translations( $types, $hide ) {
		$this->polylang_post_types = $types;
		return $types;
	}

	public function sf_poly_query_args( $query_args, $sfid ) {
		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		if ( Search_Filter_Helper::has_polylang() ) {

			// manually set language of our query, based on the lang of the S&F post (this is because ajax requests don't get a lang set, which only occurs on this display method
			// if($sf_inst->settings("display_results_as")=="shortcode") {

			$terms     = wp_get_post_terms( $sfid, 'language', array( 'fields' => 'all' ) );
			$terms_arr = array(); // this shold only ever have 1 value, as a post can only be in 1 lang at a time

			// but lets support it anyway
			foreach ( $terms as $term ) {
				array_push( $terms_arr, $term->slug );
			}

			// check to see if hte language we are searching, is being handles by polylang
			$post_types_arr = $sf_inst->settings( 'post_types' );
			$post_types     = array();
			if ( is_array( $post_types_arr ) ) {
				$post_types = array_keys( $post_types_arr );
			}

			$polylang_post_types = array_keys( $this->polylang_post_types );

			$intersect = array_intersect( $post_types, $polylang_post_types );
			if ( count( $intersect ) > 0 ) {
				$query_args['lang'] = implode( ',', $terms_arr );
			}
				// otherwise, don't set the lang of course, because the posts certainly won't have a lang attribute (yet)
				// there will be problems however, if a user is searching multiple post types, some of which are handles by polylang
				// some not, in this case, all language must be set to be handled by polylang for consistency

			// }
		}

		return $query_args;
	}

	public function poly_lang_sf_edit_cache_query_args( $query_args, $sfid ) {
		if ( Search_Filter_Helper::has_polylang() ) {
			/*
			$langs = array();
			global $polylang;
			foreach ($polylang->model->get_languages_list() as $term)
			{
			array_push($langs, $term->slug);
			}

			//$query_args["lang"] = $langs;
			//$query_args["lang"] = implode(",", $langs);
			*/
			// this sets a query for all languages (seems to changes quite often, the above was the old method of include all languages)
			$query_args['lang'] = '';
		}

		return $query_args;
	}

	public function sf_pre_get_posts_admin_cache( $query, $sfid ) {
		if ( Search_Filter_Helper::has_polylang() ) {
			$query->set( 'lang', 'all' );
		}

		return $query;
	}


	public function add_url_args( $url, $str ) {
		$query_arg = '?';
		if ( strpos( $url, '?' ) !== false ) {

			// url has a question mark
			$query_arg = '&';
		}

		return $url . $query_arg . $str;

	}
	public function pll_sf_rewrite_args( $args ) {
		// if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		if ( Search_Filter_Helper::has_polylang() ) {
			$args['lang'] = '';
		}

		return $args;
	}
	public function pll_sf_archive_slug_rewrite( $newrules, $sfid, $page_slug ) {
		// if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		if ( Search_Filter_Helper::has_polylang() ) {
			// takes into account language prefix
			// $newrules = array();
			$newrules[ '([a-zA-Z0-9_-]+)/' . $page_slug . '$' ] = 'index.php?&sfid=' . $sfid; // regular plain slug
		}

		return $newrules;
	}
	public function pll_sf_ajax_results_url( $ajax_url, $sfid ) {
		if ( ( function_exists( 'pll_home_url' ) ) && ( function_exists( 'pll_current_language' ) ) ) {

			global $searchandfilter;
			$sf_inst = $searchandfilter->get( $sfid );

			// these are the display results methods that use the current url for ajax
			// we want to do it this way, to allow other display methods (like VC / ajax integration) to carry on working
			// $retain_results_methods = array("archive", "post_type_archive", "custom", "custom_woocommerce_store", "custom_edd_store", "bb_posts_module", "divi_post_module", "divi_shop_module", "elementor_posts_element","custom_layouts","custom_dce_posts");

			// todo - need to add extensions via external plugin

			if ( $sf_inst->settings( 'display_results_as' ) !== 'shortcode' ) {
				// so don't modify the ajax url, it will have the lang in there
				return $ajax_url;
			} else {
				// if we are doing an ajax request, make sure we are including the proper home url, with lang `/en`
				// allow sf_data to remain the same value
				$sf_data   = 'all';
				$url_parts = parse_url( $ajax_url );
				if ( isset( $url_parts['query'] ) ) {
					parse_str( $url_parts['query'], $url_vars );
					if ( isset( $url_vars['sf_data'] ) ) {
						$sf_data = $url_vars['sf_data'];
					}
				}

				// if ( $sf_inst->settings( "display_results_as" ) == "shortcode" ) {
				if ( get_option( 'permalink_structure' ) ) {
					$home_url = trailingslashit( pll_home_url() );
					$ajax_url = $this->add_url_args( $home_url, "sfid=$sfid&sf_action=get_data&sf_data=$sf_data" );

				} else {
					$ajax_url = $this->add_url_args( pll_home_url(), "sfid=$sfid&sf_action=get_data&sf_data=$sf_data" );
				}
			}
		}

		return $ajax_url;
	}
	
	public function pll_sf_archive_results_url( $results_url, $sfid, $page_slug = '' ) {
		if ( ( function_exists( 'pll_home_url' ) ) && ( function_exists( 'pll_current_language' ) ) ) {
			$results_url = pll_home_url( pll_current_language() );

			if ( get_option( 'permalink_structure' ) ) {
				if ( $page_slug != '' ) {
					$results_url = trailingslashit( trailingslashit( $results_url ) . $page_slug );
				} else {
					$results_url = trailingslashit( $results_url );
					$results_url = $this->add_url_args( $results_url, "sfid=$sfid" );
				}
			} else {
				if ( strpos( $results_url, '?' ) !== false ) {
					$param = '&';
				} else {
					$param = '?';
				}
				$results_url .= $param . 'sfid=' . $sfid;

			}
		}

		return $results_url;
	}

	public function pll_sf_form_url( $results_url, $sfid, $page_slug = '' ) {
		if ( ( function_exists( 'pll_home_url' ) ) && ( function_exists( 'pll_current_language' ) ) ) {
			$results_url = pll_home_url( pll_current_language() );

			if ( get_option( 'permalink_structure' ) ) {
				$results_url = trailingslashit( $results_url );
				$results_url = $this->add_url_args( $results_url, "sfid=$sfid" );
				$results_url = $this->add_url_args( $results_url, 'sf_action=get_data' );
				$results_url = $this->add_url_args( $results_url, 'sf_data=form' );

			} else {
				$results_url = $this->add_url_args( $results_url, "sfid=$sfid" );
				$results_url = $this->add_url_args( $results_url, 'sf_action=get_data' );
				$results_url = $this->add_url_args( $results_url, 'sf_data=form' );
				// $results_url .= "&sfid=".$sfid;
			}
		}

		return $results_url;
	}

	

	/* Relevanssi integration */
	public function remove_relevanssi_defaults() {
		// relevanssi free + older premium
		remove_filter( 'the_posts', 'relevanssi_query' );
		remove_filter( 'posts_request', 'relevanssi_prevent_default_request', 9 );
		remove_filter( 'posts_request', 'relevanssi_prevent_default_request' );

		// new premium
		remove_filter( 'the_posts', 'relevanssi_query', 99 );
		remove_filter( 'posts_request', 'relevanssi_prevent_default_request', 10 );

		remove_filter( 'query_vars', 'relevanssi_query_vars' );
	}

	public function relevanssi_filter_query_args( $query_args, $sfid ) {
		// always remove normal relevanssi behaviour
		$this->remove_relevanssi_defaults();

		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		if ( $sf_inst->settings( 'use_relevanssi' ) == 1 ) {// ensure it is enabled in the admin

			if ( isset( $query_args['s'] ) ) {// only run if a search term has actually been set
				if ( trim( $query_args['s'] ) != '' ) {

					$search_term     = $query_args['s'];
					$query_args['s'] = '';
				}
			}
		}

		return $query_args;
	}

	public function relevanssi_sort_result_ids( $result_ids, $query_args, $sfid ) {
		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		if ( count( $result_ids ) == 1 ) {
			if ( isset( $result_ids[0] ) ) {
				if ( $result_ids[0] == 0 ) {
					return $result_ids;
				}
			}
		}

		if ( ( $sf_inst->settings( 'use_relevanssi' ) == 1 ) && ( $sf_inst->settings( 'use_relevanssi_sort' ) == 1 ) ) {// ensure it is enabled in the admin

			if ( isset( $this->relevanssi_result_ids[ 'sf-' . $sfid ] ) ) {
				$return_ids_ordered = array();

				$ordering_array = $this->relevanssi_result_ids[ 'sf-' . $sfid ];

				$ordering_array = array_flip( $ordering_array );

				foreach ( $result_ids as $result_id ) {
					$return_ids_ordered[ $ordering_array[ $result_id ] ] = $result_id;
				}

				ksort( $return_ids_ordered );

				return $return_ids_ordered;
			}
		}

		return $result_ids;
	}


	public function relevanssi_add_custom_filter( $ids_array, $query_args, $sfid ) {
		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		$this->remove_relevanssi_defaults();

		if ( $sf_inst->settings( 'use_relevanssi' ) == 1 ) {// ensure it is enabled in the admin

			if ( isset( $query_args['s'] ) ) {// only run if a search term has actually been set

				if ( trim( $query_args['s'] ) != '' ) {
					// $search_term = $query_args['s'];

					if ( function_exists( 'relevanssi_do_query' ) ) {
						$expand_args = array(
							'posts_per_page'         => -1,
							'paged'                  => 1,
							'fields'                 => 'ids', // relevanssi only implemented support for this in 3.5 - before this, it would return the whole post object

						 // 'orderby'                     => "", //remove sorting
							'meta_key'               => '',
							// 'order'                         => "asc",

							/* speed improvements */
							'no_found_rows'          => true,
							'update_post_meta_cache' => false,
							'update_post_term_cache' => false,

						);

						$query_args = array_merge( $query_args, $expand_args );

						// $query_args['orderby'] = "relevance";
						// $query_args['order'] = "asc";
						unset( $query_args['order'] );
						unset( $query_args['orderby'] );

						// The Query
						$query_arr = new WP_Query( $query_args );
						relevanssi_do_query( $query_arr );

						$ids_array = array();
						if ( $query_arr->have_posts() ) {

							foreach ( $query_arr->posts as $post ) {
								$post_id = 0;

								if ( is_numeric( $post ) ) {
										  $post_id = $post;
								} elseif ( is_object( $post ) ) {
									if ( isset( $post->ID ) ) {
										$post_id = $post->ID;
									}
								}

								if ( $post_id != 0 ) {
									array_push( $ids_array, $post_id );
								}
							}
						}

						if ( $sf_inst->settings( 'use_relevanssi_sort' ) == 1 ) {
							   // keep a copy for ordering the results later
							   $this->relevanssi_result_ids[ 'sf-' . $sfid ] = $ids_array;

							   // now add the filter
							   add_filter( 'sf_apply_filter_sort_post__in', array( $this, 'relevanssi_sort_result_ids' ), 10, 3 );
						}

						return $ids_array;
					}
				}
			}
		}

		return array( false ); // this tells S&F to ignore this custom filter
	}
}
require_once plugin_dir_path( __FILE__ ) . 'third-party/class-search-filter-woocommerce.php';

<?php

class Search_Filter_Third_Party_Woocommerce {

	private $woo_all_results_ids_keys = array();
	private $woo_result_ids_map       = array();
	private $woo_meta_keys_added      = array();
	private $wc_variable_meta_keys    = array();
	private $wc_products_query_id     = 0;
	public $wc_forms_post_stati       = array();
	public $wc_forms_post_types       = array();
	public $cache_table_name;
	private $woocommerce_enabled;

	public function __construct() {
		$this->cache_table_name = Search_Filter_Helper::get_table_name( 'search_filter_cache' );

		if ( ( ! is_admin() ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			add_filter( 'sf_edit_query_args', array( $this, 'sf_woocommerce_query_args' ), 11, 2 );
			add_filter( 'sf_main_query_pre_get_posts', array( $this, 'sf_woocommerce_pre_get_posts' ), 11, 2 );
			add_filter( 'sf_query_cache_post__in', array( $this, 'sf_woocommerce_get_variable_product_ids' ), 11, 2 );
			add_filter( 'sf_query_post__in', array( $this, 'sf_woocommerce_convert_variable_product_ids' ), 11, 2 );
			add_filter( 'sf_query_cache_count_ids', array( $this, 'sf_woocommerce_conv_variable_ids' ), 11, 2 );
			add_filter( 'sf_admin_filter_settings_save', array( $this, 'sf_woocommerce_filter_settings_save' ), 11, 2 );
			add_filter( 'sf_query_cache_register_all_ids', array( $this, 'sf_woocommerce_register_all_result_ids' ), 11, 2 );
			add_filter( 'sf_apply_custom_filter', array( $this, 'sf_woocommerce_add_stock_status' ), 11, 3 );
			// Integrate with WC products shortcode.
			add_filter( 'shortcode_atts_products', array( $this, 'wc_products_shortcode_attributes' ), 1000, 3 );
		}

		// Public + admin.
		add_filter( 'search_filter_post_cache_insert_data', array( $this, 'sf_woo_post_cache_insert_data' ), 10, 3 );
		add_action( 'search_filter_cache_update_post', array( $this, 'sf_woo_update_post_cache' ), 10, 3 );
		add_filter( 'search_filter_post_cache_data', array( $this, 'sf_woocommerce_cache_data' ), 11, 2 );
		add_filter( 'search_filter_cache_should_index_post', array( $this, 'sf_woocommerce_cache_update' ), 11, 3 );
	}

	public function is_woo_enabled() {
		if ( ! isset( $this->woocommerce_enabled ) ) {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ABSPATH . '/wp-admin/includes/plugin.php';
			}

			$this->woocommerce_enabled = is_plugin_active( 'woocommerce/woocommerce.php' );
		}
		return $this->woocommerce_enabled;
	}

	public function wc_products_shortcode_attributes( $out, $pairs, $atts ) {

		if ( ! isset( $atts['search_filter_id'] ) ) {
			return $out;
		}

		// Remove products shortcode caching.
		$out['cache']               = false;
		$this->wc_products_query_id = absint( $atts['search_filter_id'] );

		add_filter( 'woocommerce_shortcode_products_query', array( $this, 'wc_add_sf_query' ) );
		remove_filter( 'shortcode_atts_products', array( $this, 'wc_products_shortcode_attributes' ), 1000, 3 );
		return $out;
	}

	public function wc_add_sf_query( $query_args ) {

		// Remove products shortcode caching.
		if ( $this->wc_products_query_id !== 0 ) {
			$query_args['search_filter_id'] = $this->wc_products_query_id;
			$this->wc_products_query_id     = 0;
		}

		remove_filter( 'woocommerce_shortcode_products_query', array( $this, 'wc_add_sf_query' ) );
		return $query_args;
	}

	public function sf_woocommerce_product_sorting( $orderby ) {
		if ( isset( $orderby['popularity'] ) ) {
			unset( $orderby['popularity'] );
		}
		return $orderby;
	}

	public function sf_woocommerce_add_stock_status( $ids_array, $query_args, $sfid ) {
		if ( ! $this->is_woo_enabled() ) {
			return $ids_array;
		}

		if ( ! $this->sf_woocommerce_is_woo_query( $sfid ) ) {
			return $ids_array;
		}

		/*
		* Get the instock IDs from the DB directly check for the woocommerce setting
		* "show out of stock products", and only enable this on that condition.
		*/

		if ( get_option( 'woocommerce_hide_out_of_stock_items' ) === 'yes' ) {

			$merge = true;
			if ( isset( $ids_array[0] ) ) {
				if ( $ids_array[0] === false ) {
					$merge = false;
				}
			}

			global $wpdb;

			$term_results_table_name = Search_Filter_Helper::get_table_name( 'search_filter_term_results' );

			$field_terms_results = $wpdb->get_results(
				"
                SELECT field_name, field_value, result_ids
                FROM $term_results_table_name
                WHERE field_name = '_sfm__stock_status'
                AND field_value = 'instock' LIMIT 0, 1
                "
			);

			if ( ( count( $field_terms_results ) === 1 ) && ( property_exists( $field_terms_results[0], 'result_ids' ) ) ) {
				$instock_ids = explode( ',', $field_terms_results[0]->result_ids );

				if ( $merge === false ) {
					$ids_array = $instock_ids;
				} else {
					$ids_array = array_intersect( $ids_array, $instock_ids );
				}
			}
		}

		return $ids_array;
	}

	public function sf_woo_update_product_insert_data( $insert_data, $post_id, $type ) {

		$product = wc_get_product( $post_id );
		
		if ( ! $product ) {
			return $insert_data;
		}

		if ( $product->is_type( 'variable' ) ) {

			// then remove `price`, and remove all taxonomy related attributes (as we want to add them manually, based on variations data)
			if ( $type == 'taxonomy' ) {

				$product_attributes = $product->get_attributes();

				foreach ( $insert_data as $data_key => $data ) {

					$attr_key = strpos( $data_key, '_sft_pa_' );

					if ( $attr_key !== false ) {

						$tax_name = str_replace( '_sft_', '', $data_key );

						if ( isset( $product_attributes[ $tax_name ] ) ) {

							// Now check to see if the attribute is used as variation, if not, then index it.
							if ( $product_attributes[ $tax_name ]['variation'] === true ) {
								unset( $insert_data[ $data_key ] );
							}
						}
					}
				}
			} elseif ( $type === 'meta' ) {
				$this->wc_variable_meta_keys = array_keys( $insert_data );
			}
		} elseif ( $product->is_type( 'simple' ) ) {
			// Then we need to add product attributes, that are not taxonomies.
			if ( $type === 'meta' ) {

				$product_attributes = $product->get_attributes();

				foreach ( $product_attributes as $product_attribute ) {

					if ( ! $product_attribute->is_taxonomy() ) {
						$attribute_name    = $product_attribute->get_name();
						$sf_field_name     = '_sfm_attribute_' . $attribute_name;
						$attribute_options = $product_attribute->get_options();

						$insert_data[ $sf_field_name ] = $attribute_options;
					}
				}
			}
		}

		return $insert_data;
	}
	public function sf_woo_update_post_cache( $post_id, $post, $context ) {
		if ( ! $this->is_woo_enabled() ) {
			return;
		}
		// If we're not in the cache context, and we update a parent post, then we want to
		// rebuild the children.
		if ( $post->post_type !== 'product' ) {
			return;
		}

		if ( $context !== 'none' ) {
			return;
		}

		// If the product is variable, loop the through the IDS:
		$product = wc_get_product( $post_id );

		if ( ! $product ) {
			return;
		}

		if ( $product->is_type( 'variable' ) ) {
			$variations = $product->get_available_variations();
			foreach ( $variations as $variation ) {
				do_action( 'search_filter_update_post_cache', $variation['variation_id'] );
			}
		}
	}
	public function sf_woo_update_variation_insert_data( $insert_data, $post_id, $type ) {

		if ( $type === 'taxonomy' ) {
			$variation_tax_data = $this->sf_woo_get_variation_insert_data_tax( $post_id );
			$insert_data        = array_merge( $insert_data, $variation_tax_data );

		} elseif ( $type === 'meta' ) {
			$variation_meta_data = $this->sf_woo_get_variation_insert_data_meta( $post_id );
			$insert_data         = array_merge( $insert_data, $variation_meta_data );

		}
		return $insert_data;
	}

	public function sf_woo_post_cache_insert_data( $insert_data, $post_id, $type ) {
		if ( ! $this->is_woo_enabled() ) {
			return $insert_data;
		}

		$post = get_post( $post_id );
		if( $post === null ) {
			return $insert_data;
		}

		if ( ! $post ) {
			return $insert_data;
		}
		if ( $post->post_type === 'product' ) {
			return $this->sf_woo_update_product_insert_data( $insert_data, $post_id, $type );
		} elseif ( $post->post_type === 'product_variation' ) {
			return $this->sf_woo_update_variation_insert_data( $insert_data, $post_id, $type );
		}

		return $insert_data;
	}


	private function sf_woo_get_product_terms_insert_data( $post_id ) {

		$insert_arr = array();

		if ( ! $this->is_woo_enabled() ) {
			return $insert_arr;
		}

		$post = get_post( $post_id );
		if ( $post === null ) {
			return $insert_arr;
		}
		$post_type        = $post->post_type;
		$taxonomies       = get_object_taxonomies( $post_type, 'objects' );
		$current_language = false;

		if ( Search_Filter_Helper::has_wpml() ) {
			$current_language      = Search_Filter_Helper::wpml_current_language();
			$post_language_details = apply_filters( 'wpml_post_language_details', null, $post_id );

			if ( ! empty( $post_language_details ) ) {
				$language_code = $post_language_details['language_code'];
				if ( ( $language_code !== '' ) && ( ! empty( $language_code ) ) ) {
					do_action( 'wpml_switch_language', $language_code );
				}
			}
		}

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

			$attr_key = strpos( $taxonomy_slug, 'pa_' );
			if ( ( $attr_key === false ) && ( $attr_key !== 0 ) ) {

				// get the terms related to post
				$terms                                  = get_the_terms( $post_id, $taxonomy_slug );
				$insert_arr[ '_sft_' . $taxonomy_slug ] = array();

				if ( ! empty( $terms ) ) {
					foreach ( $terms as $term ) {

						$term_id = $term->term_id;

						if ( Search_Filter_Helper::has_wpml() ) {
							   // we need to find the language of the post
							   $post_lang_code = Search_Filter_Helper::wpml_post_language_code( $post_id );

							   // then send this with object ID to ensure that WPML is not converting this back
							   $term_id = Search_Filter_Helper::wpml_object_id( $term->term_id, $term->taxonomy, true, $post_lang_code );
						}

						array_push( $insert_arr[ '_sft_' . $taxonomy_slug ], (string) $term_id );
					}
				}
			}
		}

		if ( Search_Filter_Helper::has_wpml() ) {
			do_action( 'wpml_switch_language', $current_language );
		}

		return $insert_arr;

	}

	public function sf_woo_get_variation_post_meta_values( $variation_id ) {

		$index_data = array();

		$meta_key_fields = $this->get_all_meta_key_names();

		$wanted_meta_keys = array();
		foreach ( $meta_key_fields as $meta_key_field_name ) {

			if ( ( $meta_key_field_name !== '_price' ) && ( strpos( $meta_key_field_name, 'attribute_' ) === false ) ) {
				array_push( $wanted_meta_keys, $meta_key_field_name );
			}
		}

		$remove_keys      = array( '_stock_status' );
		$wanted_meta_keys = array_diff( $wanted_meta_keys, $remove_keys );

		foreach ( $wanted_meta_keys as $wanted_meta_key ) {

			$post_meta_values = get_post_meta( $variation_id, $wanted_meta_key );

			if ( ! empty( $post_meta_values ) ) {
				$index_data[ '_sfm_' . $wanted_meta_key ]           = array();
				$index_data[ '_sfm_' . $wanted_meta_key ]['values'] = $post_meta_values;
				$index_data[ '_sfm_' . $wanted_meta_key ]['type']   = 'string';
			}
		}

		if ( isset( $index_data['_sfm__stock_status'] ) ) {

		}

		return $index_data;
	}
	public function sf_woo_get_variation_taxonomy_values( $index_data, $product_id ) {

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			return $index_data;
		}

		$product_attributes = $product->get_attributes();

		foreach ( $product_attributes as $product_attribute ) {

			// now check to see if the attribute is used as variation, if not, then index it
			if ( $product_attribute['variation'] === false ) {

				$name = $product_attribute['name'];
				// $product_options = array();
				if ( ( ! is_array( $product_attribute['options'] ) ) && ( ! empty( $product_attribute['options'] ) ) ) {
					$product_options = array( $product_attribute['options'] );
				} else {
					$product_options = $product_attribute['options'];
				}

				if ( ! empty( $product_options ) ) {
					$index_data[ '_sft_' . $name ]           = array();
					$index_data[ '_sft_' . $name ]['values'] = $product_options;
					$index_data[ '_sft_' . $name ]['type']   = 'number';
				}
			}
		}

		return $index_data;

	}

	public function sf_woo_get_variation_taxonomy_insert_data( $index_data, $product_id ) {

		$product = wc_get_product( $product_id );

		if ( $product ) {
			$product_attributes = $product->get_attributes();

			foreach ( $product_attributes as $product_attribute ) {

				// now check to see if the attribute is used as variation, if not, then index it
				if ( $product_attribute['variation'] === false ) {

					$name = $product_attribute['name'];
					// $product_options = array();
					if ( ( ! is_array( $product_attribute['options'] ) ) && ( ! empty( $product_attribute['options'] ) ) ) {
						$product_options = array( $product_attribute['options'] );
					} else {
						$product_options = $product_attribute['options'];
					}

					if ( ! empty( $product_options ) ) {
						$index_data[ '_sft_' . $name ] = $product_options;
					}
				}
			}
		}

		return $index_data;

	}

	public function sf_woo_post_cache_get_delete_variation_data( $post_id ) {

		// delete all variation data from the cache - we lookup our own tables, because the variation IDs might have changed
		global $wpdb;

		// so loop through any IDs, collect all the field name & values
		// delete them all, then send the field name and values to the term updater
		// do_action("search_filter_delete_post_cache", $variation_id);
		$this->cache_table_name = Search_Filter_Helper::get_table_name( 'search_filter_cache' );

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT DISTINCT post_id
				FROM $this->cache_table_name
				WHERE post_parent_id = '%d'
			",
				$post_id
			)
		);

		foreach ( $results as $result ) {
			do_action( 'search_filter_delete_post_cache', $result->post_id );
		}
	}

	public function sf_woo_get_variation_insert_data_meta( $variation_id ) {

		if ( ! $this->is_woo_enabled() ) {
			return array();
		}

		$current_language = false;
		if ( Search_Filter_Helper::has_wpml() ) {
			$current_language      = Search_Filter_Helper::wpml_current_language();
			$post_language_details = apply_filters( 'wpml_post_language_details', null, $variation_id );

			if ( ! empty( $post_language_details ) ) {
				$language_code = $post_language_details['language_code'];
				if ( ( $language_code !== '' ) && ( ! empty( $language_code ) ) ) {
					do_action( 'wpml_switch_language', $language_code );
				}
			}
		}

		$variation      = wc_get_product( $variation_id );
		$parent_product = wc_get_product( $variation->get_parent_id() );

		if ( $parent_product === null || $parent_product === false ) {
			return array();
		}
		// loop through the variations
		$single_variation     = new WC_Product_Variation( $variation_id );
		$variation_price      = $single_variation->get_price();
		$variation_attributes = $single_variation->get_variation_attributes();

		// start by adding post meta / can be an empty array
		// $variation_values = array();

		// TODO - WHAT IS THIS DOING?
		$variation_values = $this->sf_woo_get_variation_post_meta_values( $variation_id );
		// loop through the variations attributes
		foreach ( $variation_attributes as $variation_key => $variation_value ) {

			if ( strpos( $variation_key, 'attribute_' ) !== false ) {
				// if the name begins with attribute_pa, then its a taxonomy
				if ( strpos( $variation_key, 'attribute_pa' ) === false ) {

					if ( ! empty( $variation_value ) ) {
						   $meta_name                       = $variation_key;
						   $field_name                      = '_sfm_' . $meta_name;
						   $variation_values[ $field_name ] = array( $variation_value );
					}
				}
			}
		}

		// Figure out which meta keys to index of the variations.
		global $search_filter_post_cache;
		$cache_data = $search_filter_post_cache->get_cache_data();
		$meta_keys  = array();
		if ( isset( $cache_data['meta_keys'] ) ) {
			if ( is_array( $cache_data['meta_keys'] ) ) {
				// $meta_keys = $cache_data['meta_keys'];
				foreach ( $cache_data['meta_keys'] as $meta_key ) {
					$meta_key = '_sfm_' . $meta_key;
					array_push( $meta_keys, $meta_key );
				}
			}
		}

		// merge meta keys in the post cache with the existing passed through
		$this->wc_variable_meta_keys = array_unique( array_merge( $this->wc_variable_meta_keys, $meta_keys ) );

		// now we add the other post meta, like _width, _height
		$post_meta = get_post_meta( $variation_id );

		foreach ( $this->wc_variable_meta_keys as $meta_key ) {

			// make sure the key starts with meta prefix
			$prefix = '_sfm_';
			if ( strpos( $meta_key, $prefix ) !== false ) {

				if ( substr( $meta_key, 0, strlen( $prefix ) ) == $prefix ) {
					$meta_key = substr( $meta_key, strlen( $prefix ) );
				}

				if ( isset( $post_meta[ $meta_key ] ) ) {
					$field_name                      = '_sfm_' . $meta_key;
					$variation_value                 = $post_meta[ $meta_key ];
					$variation_values[ $field_name ] = array();
					if ( ! is_array( $variation_value ) ) {
						$variation_value = array( $variation_value );
					}
					$variation_values[ $field_name ] = $variation_value;
				} else {
					if ( ! isset( $meta_missing_count[ $meta_key ] ) ) {
						$meta_missing_count[ $meta_key ] = 0;
					}
					$meta_missing_count[ $meta_key ]++;
				}
			}
		}

		$variation_values['_sfm__price'] = array( $variation_price );

		// We're managing stock status at product level, not variation, so forget about it for variations
		// (ie, just copy the parent value).
		if ( $parent_product->managing_stock() === true ) {
			if ( isset( $variation_values['_sfm__stock_status'] ) ) {
				unset( $variation_values['_sfm__stock_status'] );
			}
			// Copy the value from the parent product to the variation so we can get matches on _stock_status.
			$variation_values['_sfm__stock_status'] = array( $parent_product->get_stock_status() );
		}
		$variation_insert_data = $variation_values;

		if ( Search_Filter_Helper::has_wpml() ) {
			do_action( 'wpml_switch_language', $current_language );
		}
		return $variation_insert_data;
	}
	public function sf_woo_get_variation_insert_data_tax( $variation_id ) {

		if ( ! $this->is_woo_enabled() ) {
			return array();
		}

		$current_language = false;
		if ( Search_Filter_Helper::has_wpml() ) {
			$current_language      = Search_Filter_Helper::wpml_current_language();
			$post_language_details = apply_filters( 'wpml_post_language_details', null, $variation_id );

			if ( ! empty( $post_language_details ) ) {
				$language_code = $post_language_details['language_code'];
				if ( ( $language_code !== '' ) && ( ! empty( $language_code ) ) ) {
					do_action( 'wpml_switch_language', $language_code );
				}
			}
		}

		$variation      = wc_get_product( $variation_id );

		if ( ! $variation ) {
			return array();
		}
		
		$parent_product = wc_get_product( $variation->get_parent_id() );

		// loop through the variations
		$single_variation     = new WC_Product_Variation( $variation_id );
		$variation_price      = $single_variation->get_price();
		$variation_attributes = $single_variation->get_variation_attributes();

		// start by adding post meta / can be an empty array
		$variation_values = array();
		$variation_values = $this->sf_woo_get_variation_taxonomy_insert_data( $variation_values, $variation->get_parent_id() );
		// loop through the variations attributes
		foreach ( $variation_attributes as $variation_key => $variation_value ) {

			if ( strpos( $variation_key, 'attribute_' ) !== false ) {

				// if(!empty($variation_value)) {

				// if the name begins with attribute_pa, then its a taxonomy
				if ( strpos( $variation_key, 'attribute_pa' ) !== false ) {

					if ( ! empty( $variation_value ) ) {

						$taxonomy_name = str_replace( 'attribute_', '', $variation_key );
						$term          = get_term_by( 'slug', $variation_value, $taxonomy_name );

						if ( ( ! is_wp_error( $term ) ) && ( ! empty( $term ) ) ) {
							$field_name                      = '_sft_' . $taxonomy_name;
							$variation_values[ $field_name ] = array( $term->term_id );
						}
					} else {
						// the attribute was empty, which means "ANY" was selected, which means we need to attach all
						// possible attributes to this variation
						$taxonomy_name = str_replace( 'attribute_', '', $variation_key );

						if ( isset( $product_attributes[ $taxonomy_name ] ) ) {

							$values = $product_attributes[ $taxonomy_name ]->get_options();

							$field_name                      = '_sft_' . $taxonomy_name;
							$variation_values[ $field_name ] = $values;
						}
					}
				}
			}
		}

		// get the terms on the parent post, so we can add them to all the variations in our cache
		$term_values = $this->sf_woo_get_product_terms_insert_data( $variation->get_parent_id() );
		// combine parent taxonomies with variation attributes

		$variation_insert_data = array_merge( $term_values, $variation_values );

		if ( Search_Filter_Helper::has_wpml() ) {
			do_action( 'wpml_switch_language', $current_language );
		}

		return $variation_insert_data;
	}

	public function get_cache_post_types() {

		if ( empty( $this->wc_forms_post_types ) ) {

			$search_form_post_types = array();

			$search_form_query = new WP_Query( 'post_type=search-filter-widget&post_status=publish&posts_per_page=-1&suppress_filters=1' );
			$search_forms      = $search_form_query->get_posts();

			foreach ( $search_forms as $search_form ) {

				$search_form_settings = Search_Filter_Helper::get_settings_meta( $search_form->ID );
				$this_post_types      = array_keys( $search_form_settings['post_types'] );
				foreach ( $this_post_types as $this_post_type ) {

					array_push( $search_form_post_types, $this_post_type );
				}
			}
			$this->wc_forms_post_types = array_unique( $search_form_post_types );

		}

		return $this->wc_forms_post_types;

	}

	public function sf_woocommerce_cache_update( $should_index_post, $post_id, $post ) {

		if ( ! $this->is_woo_enabled() ) {
			return $should_index_post;
		}
		$post_type = $post->post_type;

		// Essentially we want to remove private posts from all our queries & db,
		// causing too many counting errors depending on if user is logged in
		if ( ( $post_type === 'product' ) ) {
			// Inly really needs to be product, because variation will always have published status
			$post_status = get_post_status( $post_id ); // don't index variations if the parent is private, and if its not in any search forms

			$exclude_from_catalog = false;
			if ( has_term( 'exclude-from-catalog', 'product_visibility', $post_id ) ) {
				$exclude_from_catalog = true;
			}
			// drafts & private mess up the count numbers, while the main query doesn't show them, so may aswell sync, and exclude across the board
			if ( ( $post_status === 'private' ) || ( $post_status === 'draft' ) || ( $exclude_from_catalog === true ) ) {
				$this->sf_woo_post_cache_get_delete_variation_data( $post_id );
				do_action( 'search_filter_delete_post_cache', $post_id );
				return false;
			}
		}

		return $should_index_post;
	}

	public function sf_woocommerce_cache_data( $cache_data ) {
		// check to see if we are using woocommerce post types
		if ( ! $this->is_woo_enabled() ) {
			return $cache_data;
		}

		if ( empty( $cache_data ) ) {
			return $cache_data;
		}

		if ( empty( $cache_data['post_types'] ) ) {
			return $cache_data;
		}

		// if either product or variation
		// we want to record `_stock_status` regardless if it has been set as a field - we need this because calc get complicated when checking if stock is managed at variation or product level
		if ( ( in_array( 'product', $cache_data['post_types'] ) ) || ( in_array( 'product_variation', $cache_data['post_types'] ) ) ) {
			if ( ! in_array( '_stock_status', $cache_data['meta_keys'] ) ) {
				if ( ! isset( $cache_data['meta_keys'] ) ) {
					$cache_data['meta_keys'] = array();
				}
				array_push( $cache_data['meta_keys'], '_stock_status' );
			}
		}

		/*
		 * TODO -  potential problem, this data is only calculated when a search form is saved,
		 * it should also be recalculated when the cache restarts building,
		 * may be not, depends maybe only need for debug
		 */

		return $cache_data;

	}

	public function sf_woocommerce_is_woo_variations_query( $sfid ) {
		if ( ! $this->is_woo_enabled() ) {
			return false;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		$post_types_arr = $sf_inst->settings( 'post_types' );
		$post_types     = array();
		if ( is_array( $post_types_arr ) ) {
			$post_types = array_keys( $post_types_arr );
		}

		if ( ( in_array( 'product', $post_types ) ) && ( in_array( 'product_variation', $post_types ) ) ) {
			// then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list
			return true;
		}

		return false;
	}
	public function sf_woocommerce_should_reduce_variations( $sfid ) {
		if ( ! $this->is_woo_enabled() ) {
			return false;
		}
		$should_reduce = apply_filters( 'search_filter_woo_should_reduce_variation', true );
		return $should_reduce;
	}

	public function sf_woocommerce_is_woo_query( $sfid ) {
		if ( ! $this->is_woo_enabled() ) {
			return false;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		$post_types_arr = $sf_inst->settings( 'post_types' );
		$post_types     = array();
		if ( is_array( $post_types_arr ) ) {
			$post_types = array_keys( $post_types_arr );
		}

		if ( in_array( 'product', $post_types ) ) {
			// then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list
			return true;
		}
		return false;
	}

	public function sf_woocommerce_convert_term_results( $filters, $cache_term_results, $sfid ) {

		// check to see if we are using woocommerce post types
		if ( ! $this->is_woo_enabled() ) {
			return $filters;
		}

		if ( empty( $filters ) ) {
			return $filters;
		}

		foreach ( $this->woo_meta_keys_added as $woo_tax_name ) {

			if ( isset( $cache_term_results[ '_sfm_attribute_' . $woo_tax_name ] ) ) {
				$terms = $cache_term_results[ '_sfm_attribute_' . $woo_tax_name ];

				foreach ( $terms as $term_name => $result_ids ) {

					$tax = Search_Filter_Wp_Data::get_taxonomy_term_by( 'slug', $term_name, $woo_tax_name );

					if ( ( $tax ) && ( isset( $filters[ '_sft_' . $woo_tax_name ] ) ) ) {
						// Remove the parent post ID from the `cache_result_ids`.
						if ( ! isset( $filters[ '_sft_' . $woo_tax_name ]['terms'][ $term_name ] ) ) {
							   $filters[ '_sft_' . $woo_tax_name ]['terms'][ $term_name ]                     = array();
							   $filters[ '_sft_' . $woo_tax_name ]['terms'][ $term_name ]['term_id']          = $tax->term_id;
							   $filters[ '_sft_' . $woo_tax_name ]['terms'][ $term_name ]['cache_result_ids'] = array();
						}
						$filters[ '_sft_' . $woo_tax_name ]['terms'][ $term_name ]['cache_result_ids'] = array_merge( $filters[ '_sft_' . $woo_tax_name ]['terms'][ $term_name ]['cache_result_ids'], $result_ids );
					}
				}
			}
		}
		return $filters;
	}
	public function sf_woocommerce_register_all_result_ids( $register, $sfid ) {
		if ( ! $this->is_woo_enabled() ) {
			return $register;
		}

		return $register;

	}
	public function sf_woocommerce_is_filtered() {
		return true;
	}

	public function sf_woocommerce_convert_variable_product_ids( $post_ids, $sfid ) {
		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		// make sure this search form is tyring to use woocommerce
		if ( $this->sf_woocommerce_is_woo_variations_query( $sfid ) && $this->sf_woocommerce_should_reduce_variations( $sfid ) ) {
			$post_ids = $this->sf_woocommerce_conv_variable_ids( $post_ids, $sfid );
		}

		return $post_ids;
	}
	public function sf_woocommerce_get_variable_product_ids( $post_ids, $sfid ) {
		if ( ! $this->is_woo_enabled() ) {
			return $post_ids;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		// make sure this search form is tyring to use woocommerce
		if ( $this->sf_woocommerce_is_woo_variations_query( $sfid ) && $this->sf_woocommerce_should_reduce_variations( $sfid ) ) {

			$this->woo_all_results_ids_keys = $sf_inst->query->cache->get_registered_result_ids();
			$all_result_ids                 = array_keys( $this->woo_all_results_ids_keys );

			// run query to convert variation IDs to parent/product IDs
			$parent_conv_args = array(
				'post_type'              => 'product_variation',
				'posts_per_page'         => -1,
				'paged'                  => 1,
				'post__in'               => $all_result_ids,
				'fields'                 => 'id=>parent',

				'orderby'                => '', // remove sorting
				'meta_key'               => '',
				'order'                  => '',
				'post_status'            => '',

				// speed improvements
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			);

			// The Query
			$query_arr = new WP_Query( $parent_conv_args );

			$new_ids = array();
			if ( $query_arr->have_posts() ) {
				foreach ( $query_arr->posts as $post ) {

					if ( $post->post_parent == 0 ) {
						// $new_ids[$post->ID] = $post->ID;
					} else {
						$new_ids[ $post->ID ] = $post->post_parent;
					}
				}
			}

			$this->woo_result_ids_map = ( $new_ids );
		}

		return $post_ids;
	}

	public function sf_woocommerce_conv_variable_ids( $post_ids, $sfid ) {
		// make sure this search form is tyring to use woocommerce
		if ( $this->sf_woocommerce_is_woo_variations_query( $sfid ) && $this->sf_woocommerce_should_reduce_variations( $sfid ) ) {

			// $post_ids = array_unique($post_ids); //so no duplicates
			$replacements = $this->woo_result_ids_map;
			foreach ( $post_ids as $key => $value ) {
				if ( isset( $replacements[ $value ] ) ) {
					$post_ids[ $key ] = $replacements[ $value ];
				}
			}
			$post_ids = array_unique( $post_ids ); // so no duplicates
		}

		return $post_ids;
	}

	public function sf_woocommerce_pre_get_posts( $query, $sfid ) {

		if ( ! $this->is_woo_enabled() ) {
			return $query;
		}

		$is_shop = false;
		if ( function_exists( 'is_shop' ) ) {
			$is_shop = is_shop();
		}

		// is_shop is not always true for product attributes / archives
		// so we need to detect if we are one of those
		global $searchandfilter;
		$enable_taxonomy_archives = $searchandfilter->get( $sfid )->settings( 'enable_taxonomy_archives' );

		if ( ( $enable_taxonomy_archives == 1 ) && ( Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type( 'product', false ) ) ) {

			$sf_current_query = $searchandfilter->get( $sfid )->current_query();
			$term             = $searchandfilter->get_queried_object();
			$taxonomy         = $term->taxonomy;

			// exclude current tax archive as a filter when checking "is_filtered"
			if ( ! $sf_current_query->is_filtered( array( '_sft_' . $taxonomy ) ) ) {
				$is_shop = true;
			}
		}

		if ( $is_shop ) {
			// in woocommerce, don't set paged for page 1 - otherwise page description will be hidden
			if ( $query->get( 'paged' ) == 1 ) {
				$query->set( 'paged', null );
			}
		}

		// make sure post type is "product" only, not with variations, otherwise,
		// they will show in the results (if the variation ID has not been converted to its parent ID yet)
		if ( $this->sf_woocommerce_is_woo_variations_query( $sfid ) && $this->sf_woocommerce_should_reduce_variations( $sfid ) ) {
			$query->set( 'post_type', 'product' );
		} elseif ( $this->sf_woocommerce_is_woo_variations_query( $sfid ) && ! $this->sf_woocommerce_should_reduce_variations( $sfid ) ) {
			$query->set( 'post_type', array( 'product', 'product_variation' ) );
		}

		return $query;
	}
	public function sf_woocommerce_query_args( $query_args, $sfid ) {
		if ( ! $this->is_woo_enabled() ) {
			return $query_args;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		// make sure this search form is tyring to use woocommerce
		if ( $sf_inst->settings( 'display_results_as' ) == 'custom_woocommerce_store' ) {

			$enable_taxonomy_archives = $sf_inst->settings( 'enable_taxonomy_archives' );

			if ( ( $enable_taxonomy_archives == 1 ) && ( Search_Filter_Wp_Data::is_taxonomy_archive_of_post_type( 'product', false ) ) ) {

				// if its using tax archive, and we're on a tax archive, make sure we don't include the current tax  in `is_filtered` before applying WC is_filtered

				$sf_current_query = $searchandfilter->get( $sfid )->current_query();
				$term             = $searchandfilter->get_queried_object();
				$taxonomy         = $term->taxonomy;

				// exclude current tax archive as a filter when checking "is_filtered"
				if ( ( $sf_current_query->is_filtered( array( '_sft_' . $taxonomy ) ) ) || ( ! empty( $sf_current_query->get_search_term() ) ) ) {
					add_filter( 'woocommerce_is_filtered', array( $this, 'sf_woocommerce_is_filtered' ) );
				}
			} else {
				$sf_current_query = $sf_inst->current_query();
				if ( ( $sf_current_query->is_filtered() ) || ( ! empty( $sf_current_query->get_search_term() ) ) ) {
					add_filter( 'woocommerce_is_filtered', array( $this, 'sf_woocommerce_is_filtered' ) );
				}
			}

			return $query_args;
		}

		return $query_args;
	}
	public function sf_woocommerce_filter_settings_save( $settings, $sfid ) {
		// make sure this search form is tyring to use woocommerce
		if ( isset( $settings['display_results_as'] ) ) {
			// if($settings["display_results_as"]=="custom_woocommerce_store"){
			if ( $this->sf_woocommerce_is_woo_variations_query( $sfid ) && $this->sf_woocommerce_should_reduce_variations( $sfid ) ) {

				$settings['treat_child_posts_as_parent'] = 1;
			} else {
				$settings['treat_child_posts_as_parent'] = 0;
			}
		}

		return $settings;
	}

	private function get_fields_meta( $sfid ) {

		$meta_key           = '_search-filter-fields';
		$search_form_fields = ( get_post_meta( $sfid, $meta_key, true ) );

		return $search_form_fields;
	}
	public function get_all_meta_key_names() {
		$filters = array();

		$search_form_query = new WP_Query( 'post_type=search-filter-widget&post_status=publish&posts_per_page=-1&suppress_filters=1' );
		$search_forms      = $search_form_query->get_posts();

		foreach ( $search_forms as $search_form ) {
			$search_form_fields = $this->get_fields_meta( $search_form->ID );

			if ( $search_form_fields ) {
				foreach ( $search_form_fields as $key => $field ) {
					if ( $field['type'] === 'post_meta' ) {
						if ( $field['meta_type'] === 'choice' ) {
							array_push( $filters, $field['meta_key'] );
						}
					}
				}
			}
		}
		$filters = array_unique( $filters );
		return $filters;
	}
}

<?php

class Search_Filter_Third_Party_Translatepress {

	public function __construct() {

		if ( ! class_exists( 'TRP_Translate_Press' ) ) {
			return;
		}

		// Public only.
		if ( ( ! is_admin() ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

		}

		// Public + admin.
		// add_filter( 'sf_edit_query_args_after_custom_filter', array( $this, 'relevanssi_filter_query_args' ), 12, 2 );

		add_action( 'search_filter_start_prep_query', array( $this, 'start_prep_query' ), 10, 3 );
		add_action( 'search_filter_finish_prep_query', array( $this, 'finish_prep_query' ), 10, 3 );
	}

	public function start_prep_query() {
		add_filter( 'sf_apply_custom_filter', array( $this, 'add_custom_filter' ), 10, 3 );
		add_filter( 'trp_force_search', '__return_true' );
	}
	public function finish_prep_query() {
		remove_filter( 'sf_apply_custom_filter', array( $this, 'add_custom_filter' ), 10, 3 );
		remove_filter( 'trp_force_search', '__return_true' );

	}

	public function add_custom_filter( $ids_array, $query_args, $sfid ) {

		if ( ! isset( $query_args['s'] ) ) {
			return array( false );
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get( $sfid );

		global $TRP_LANGUAGE;
		$trp          = TRP_Translate_Press::get_trp_instance();
		$trp_settings = $trp->get_component( 'settings' );
		$settings     = $trp_settings->get_settings();

		if ( $TRP_LANGUAGE !== $settings['default-language'] ) {
			$trp_search        = $trp->get_component( 'search' );
			$search_result_ids = $trp_search->get_post_ids_containing_search_term( $query_args['s'], null );
			add_filter( 'trp_force_search', '__return_true' );
			if ( ! empty( $search_result_ids ) ) {
				return $search_result_ids;
			}
		}

		return array( false ); // this tells S&F to ignore this custom filter
	}
}

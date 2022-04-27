<?php
/**
 * Instagram Feed Saver Manager
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder;
use TwitterFeed\Admin\CTF_Cache_Handler;
use TwitterFeed\CtfOauthConnect;
use TwitterFeed\CtfOauthConnectPro;
use TwitterFeed\Admin\CTF_HTTP_Request;
use TwitterFeed\Pro\CTF_Settings_Pro;
use TwitterFeed\Pro\CTF_Parse_Pro;

use TwitterFeed\Admin\Traits\CTF_Feed_Templates_Settings;


class CTF_Feed_Saver_Manager {

	use CTF_Feed_Templates_Settings;

	/**
	 * AJAX hooks for various feed data related functionality
	 *
	 * @since 2.0
	 */
	public static function hooks() {
		add_action( 'wp_ajax_ctf_feed_saver_manager_builder_update', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'builder_update' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_get_feed_settings', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'get_feed_settings' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_get_feed_list_page', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'get_feed_list_page' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_get_locations_page', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'get_locations_page' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_delete_feeds', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'delete_feed' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_duplicate_feed', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'duplicate_feed' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_clear_single_feed_cache', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'clear_single_feed_cache' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_importer', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'importer' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_fly_preview', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'feed_customizer_fly_preview' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_retrieve_comments', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'retrieve_comments' ) );


		add_action( 'wp_ajax_ctf_feed_saver_manager_search_username_lists', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'search_username_lists' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_check_twitter_list_by_id', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'check_twitter_list_by_id' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_connect_manual_account', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'connect_manual_account' ) );
		add_action( 'wp_ajax_ctf_feed_saver_manager_delete_account', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'delete_account' ) );

		//Detect Leaving the Page
		add_action( 'wp_ajax_ctf_feed_saver_manager_recache_feed', array( 'TwitterFeed\Builder\CTF_Feed_Saver_Manager', 'recache_feed' ) );

	}


	/**
	 * Create Mixed Feed Type Data
	 *
	 * @since 2.0
	 */
	public static function create_mixed_feed_type_data( $selected_feeds, $selected_feed_models ){
		$feeds_types = [];
		foreach ($selected_feeds as $feed_type) {
			switch ($feed_type) {
				case 'usertimeline':
					$feeds_types['screenname'] = isset( $selected_feed_models['usertimeline'] ) ? $selected_feed_models['usertimeline'] : '';
					break;
				case 'hashtag':
					$feeds_types['hashtag'] = isset( $selected_feed_models['hashtag'] ) ? $selected_feed_models['hashtag'] : '';
					break;
				case 'search':
					$feeds_types['search'] = isset( $selected_feed_models['search'] ) ? $selected_feed_models['search'] : '';
					break;
				case 'hometimeline':
					$feeds_types['home'] = true;
					break;
				case 'mentionstimeline':
					$feeds_types['mentions'] = true;
					break;
				case 'lists':
					$feeds_types['lists'] = isset( $selected_feed_models['lists'] ) ? $selected_feed_models['lists'] : '';
					break;

			}
		}
		return $feeds_types;
	}

	/**
	 * Create Single Feed Type Data
	 *
	 * @since 2.0
	 */
	public static function create_single_feed_type_data( $selected_feed, $selected_feed_model ){
		$feed_data = [];
		switch ($selected_feed) {
			case 'usertimeline':
				$feed_data['usertimeline_text'] = isset( $selected_feed_model['usertimeline'] ) ? $selected_feed_model['usertimeline'] : '';
				$feed_data['screenname'] = isset( $selected_feed_model['usertimeline'] ) ? $selected_feed_model['usertimeline'] : '';
			break;
			case 'hashtag':
				$feed_data['hashtag_text'] = isset( $selected_feed_model['hashtag'] ) ? $selected_feed_model['hashtag'] : '';
				$feed_data['hashtag'] = isset( $selected_feed_model['hashtag'] ) ? $selected_feed_model['hashtag'] : '';
			break;
			case 'search':
				$feed_data['search_text'] = isset( $selected_feed_model['search'] ) ? $selected_feed_model['search'] : '';
				$feed_data['search'] = isset( $selected_feed_model['search'] ) ? $selected_feed_model['search'] : '';
			break;
			case 'hometimeline':
				$feed_data['home'] = true;
			break;
			case 'mentionstimeline':
				$feed_data['mentions'] = true;
			break;
			case 'lists':
				$feed_data['lists_id'] = isset( $selected_feed_model['lists'] ) ? $selected_feed_model['lists'] : '';
			break;
		}
		$feed_data['type'] = $selected_feed;
		return $feed_data;
	}


	/**
	 * Get Max Feed Name
	 *
	 *
	 * @since 2.0
	 */
	public static function get_max_feed_name( $feed_name, $type = 'text' ){
		$feed_name_array = [];
		if($type === 'list'){
			$list_array = array_slice($feed_name , 0, 3);
			foreach ($list_array as $list) {
				array_push(
					$feed_name_array,
					$list['name']
				);
			}
		}else{
			$feed_name_array = explode(',', $feed_name);
			$feed_name_array = array_slice($feed_name_array , 0, 3);
		}
		$feed_name = implode(' ', $feed_name_array);
		return $feed_name;
	}

	/**
	 * Create Feed Name
	 * This will create the feed name when creating new Feeds
	 *
	 * @since 2.0
	 */
	public static function create_feed_name( $selected_feeds, $selected_feed_models ){
		$feed_name = 'Twitter Feed';
		if(is_array($selected_feeds) && isset($selected_feeds[0])){
			switch ($selected_feeds[0]) {
				case 'usertimeline':
					$feed_name = isset( $selected_feed_models['usertimeline'] ) ? CTF_Feed_Saver_Manager::get_max_feed_name($selected_feed_models['usertimeline']) : $feed_name;
					break;
				case 'hashtag':
					$feed_name = isset( $selected_feed_models['hashtag'] ) ? CTF_Feed_Saver_Manager::get_max_feed_name($selected_feed_models['hashtag']) : $feed_name;
					break;
				case 'search':
					$feed_name = isset( $selected_feed_models['search'] ) ? CTF_Feed_Saver_Manager::get_max_feed_name($selected_feed_models['search']) : $feed_name;
					break;
				case 'hometimeline':
					$feed_name = 'Home Timeline';
					break;
				case 'mentionstimeline':
					$feed_name = 'Mentions';
					break;
				case 'lists':
					$feed_name = isset( $selected_feed_models['listsObject'] ) && sizeof($selected_feed_models['listsObject']) > 0 ? CTF_Feed_Saver_Manager::get_max_feed_name($selected_feed_models['listsObject'], 'list')  : $feed_name;
					break;
			}
		}

		return CTF_Db::feeds_query_name( $feed_name );
	}

	/**
	 * Used in an AJAX call to update settings for a particular feed.
	 * Can also be used to create a new feed if no feed_id sent in
	 * $_POST data.
	 *
	 * @since 2.0
	 */
	public static function builder_update() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		$settings_data = $_POST;
		unset( $settings_data['nonce'] );

		$feed_id = false;
		$is_new_feed = isset($settings_data['new_insert'] ) ? true : false;
		if ( ! empty( $settings_data['feed_id'] ) ) {
			$feed_id = sanitize_text_field( $settings_data['feed_id'] );
			unset( $settings_data['feed_id'] );
		} elseif ( isset( $settings_data['feed_id'] ) ) {
			unset( $settings_data['feed_id'] );
		}
		unset( $settings_data['action'] );

		$update_feed = isset( $settings_data['update_feed'] ) ? true : false;
		unset( $settings_data['update_feed'] );

		if($is_new_feed){
			$settings_data = CTF_Feed_Templates_Settings::get_feed_settings_by_feed_templates( $settings_data );
		}

		$feed_name = '';
		if ( $update_feed ) {
			$feed_name = $settings_data['feed_name'];
			$settings_data = $settings_data['settings'];
		}


		//Check if New
		#if ( isset( $settings_data['new_insert'] ) && $settings_data['new_insert'] == 'true') {

			if( isset( $_POST['selectedFeed'] ) && is_array( $_POST['selectedFeed'] ) ){
				if( sizeof($_POST['selectedFeed']) == 1 ){
					$_POST['type'] = $_POST['selectedFeed'][0];
					$feed_type_data = CTF_Feed_Saver_Manager::create_single_feed_type_data( $_POST['type'], $_POST['selectedFeedModel'] );
					$settings_data = array_merge($settings_data,$feed_type_data);
				}else{
					$settings_data['type'] = 'mixed';
					$mixed_feed_type_data = CTF_Feed_Saver_Manager::create_mixed_feed_type_data( $_POST['selectedFeed'], $_POST['selectedFeedModel'] );
					$settings_data = array_merge($settings_data,$mixed_feed_type_data);
				}

				if( isset( $_POST['selectedFeedModel']['listsObject'] ) && sizeof( $_POST['selectedFeedModel']['listsObject'] ) >= 1 ){
					$settings_data['lists_info'] = ctf_json_encode( $_POST['selectedFeedModel']['listsObject'] );
				}

				if($is_new_feed){
					$settings_data['feed_name'] =  CTF_Feed_Saver_Manager::create_feed_name( $_POST['selectedFeed'], $_POST['selectedFeedModel'] );
				}
			}


		#}
		unset( $settings_data['new_insert'] );
		unset( $settings_data['selectedFeed'] );
		unset( $settings_data['selectedFeedModel'] );
		unset( $settings_data['customizer'] );


		/*
		*/
		$feed_saver = new CTF_Feed_Saver( $feed_id );
		$feed_saver->set_feed_name( $feed_name );
		$feed_saver->set_data( $settings_data );

		$return = array(
			'success' => false,
			'feed_id' => false
		);

		if ( $feed_saver->update_or_insert() ) {
			$return = array(
				'success' => true,
				'feed_id' => $feed_saver->get_feed_id()
			);
			if($is_new_feed){
				echo wp_json_encode( $return );
				wp_die();
			}else{
				ctf_clear_cache_sql();
				/*
				$feed_cache = new \SB_Instagram_Cache( $feed_id );
				$feed_cache->clear( 'all' );
				$feed_cache->clear( 'posts' );
				*/
				echo wp_json_encode( $return );
				wp_die();
			}
		}
	}

	/**

	 * Retrieve comments AJAX call
	 *
	 * @since 2.0
	 */
	public static function retrieve_comments() {
		if ( empty( $_POST['feed_id'] )) {
			echo '{}';
			wp_die();
		}

		$return = [];

		$feed_id  = $_POST['feed_id'];
		$feed_saver = new CTF_Feed_Saver( $feed_id );
		$settings = $feed_saver->get_feed_settings();
		if ( $settings != false ){
			$post_set = new CTF_Post_Set( $feed_id );
			$post_set->init();
			$post_set->fetch();

			$return = $post_set->fetch_comments();
		}

		echo ctf_json_encode( $return );
		wp_die();
	}



	/**
	 * Used in an AJAX call to delete feeds from the Database
	 * $_POST data.
	 *
	 * @since 2.0
	 */
	public static function delete_feed() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		if ( ! empty( $_POST['feeds_ids'] ) && is_array( $_POST['feeds_ids'] )) {
			CTF_Db::delete_feeds_query( $_POST['feeds_ids'] );
		}
	}



	public static function recache_feed() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		/*
		$feed_id = sanitize_text_field( $_POST['feedID'] );
		$feed_cache = new \SB_Instagram_Cache( $feed_id );
		$feed_cache->clear( 'all' );
		$feed_cache->clear( 'posts' );
		*/
	}



	/**
	 * Used in an AJAX call to delete a feed cache from the Database
	 * $_POST data.
	 *
	 * @since 2.0
	 */
	public static function clear_single_feed_cache() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$feed_id = sanitize_text_field( $_POST['feedID'] );

		$cache = new CTF_Cache_Handler();

		if ( $feed_id === 'legacy' ) {
			$cache->clear_legacy_caches();
		} else {
			$cache->clear_single_feed_cache( $feed_id );

		}

		CTF_Feed_Saver_Manager::feed_customizer_fly_preview();
		wp_die();

	}

	/**
	 * Used in an AJAX call to duplicate a Feed
	 * $_POST data.
	 *
	 * @since 2.0
	 */
	public static function duplicate_feed() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		if ( ! empty( $_POST['feed_id'] ) ) {
			CTF_Db::duplicate_feed_query( $_POST['feed_id'] );
		}
	}


	/**
	 * Import a feed from JSON data
	 *
	 * @since 2.0
	 */
	public static function importer() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		if ( ! empty( $_POST['feed_json'] ) && strpos( $_POST['feed_json'], '{' ) === 0 ) {
			echo json_encode( CTF_Feed_Saver_Manager::import_feed( stripslashes( $_POST['feed_json'] ) ) );
		} else {
			echo json_encode(  array( 'success' => false, 'message' => __( 'Invalid JSON. Must have brackets "{}"', 'custom-twitter-feeds' ) ) );
		}
		wp_die();
	}


	/**
	 * Used To check if it's customizer Screens
	 * Returns Feed info or false!
	 *
	 * @param bool $include_comments
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public static function maybe_feed_customizer_data( $include_comments = false ) {
		if ( isset( $_GET['feed_id'] ) ){
			$feed_id  = $_GET['feed_id'];
			$feed_saver = new CTF_Feed_Saver( $feed_id );
			$settings = $feed_saver->get_feed_settings();
			$feed_db_data = $feed_saver->get_feed_db_data();

			if($settings != false){
				$return = array(
					'feed_info' => $feed_db_data,
					'headerData' => $feed_db_data,
					'settings' => $settings,
					'posts' => array()
				);
				if ( intval( $feed_id ) > 0 ) {
					$twitter_feed_settings = new CTF_Settings_Pro( array( 'feed' => $feed_id, 'customizer' => true ) , CTF_Feed_Saver::settings_defaults() );
				} else {
					$twitter_feed_settings = new CTF_Settings_Pro( array(), CTF_Feed_Saver::settings_defaults() );
				}

				$twitter_feed_settings->set_feed_type_and_terms();
				$settings = $twitter_feed_settings->get_settings();

				//$header_info = CTF_Parse_Pro::get_user_header_json( $settings );
				#$feed_type_and_terms = $instagram_feed_settings->get_feed_type_and_terms();
				//$return['header'] = $header_info;
				//$return['headerData'] = $header_info;

				return $return;

			}
		}
		return false;
	}


	/**
	 * Used to retrieve Feed Posts for preview screen
	 * Returns Feed info or false!
	 *
	 *
	 *
	 * @since 2.0
	 */
	public static function feed_customizer_fly_preview() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		if( isset( $_POST['feedID'] ) &&  isset( $_POST['previewSettings'] ) ){
			$feed_id = $_POST['feedID'];

			$previewSettings = 	isset( $_POST['isFeedTemplatesPopup'] ) ? CTF_Feed_Templates_Settings::get_feed_settings_by_feed_templates( $_POST['previewSettings'] ) + $_POST['previewSettings'] : $_POST['previewSettings'];


			//TO BE CHECKED
			$previewSettings['includereplies'] = apply_filters('ctf_admin_set_include_replies', $previewSettings);
			$previewSettings['includeretweets'] = apply_filters('ctf_admin_set_include_retweets', $previewSettings);
			//ctf_clear_cache_sql();

			$cache = new CTF_Cache_Handler();
			if ( $feed_id === 'legacy' ) {
				$cache->clear_legacy_caches();
			} else {
				$cache->clear_single_feed_cache( $feed_id );

			}


			$feed_name = isset($_POST['feedName']) ? $_POST['feedName'] : '';

			$feed_saver = new CTF_Feed_Saver( $feed_id );
			$feed_saver->set_feed_name( $feed_name );
			$feed_saver->set_data( $previewSettings );

			$atts = CTF_Feed_Builder::add_customizer_att( [ 'feed' => $feed_id, 'customizer' => true] );
			$return['feed_html'] = ctf_init( $atts, $previewSettings );
			$return['customizerDataSettings'] = $previewSettings;



			echo wp_json_encode( $return );
			#echo $return['feed_html'];

		}
		wp_die();
		return false;

	}

	/**
	 * Used in AJAX call to return settings for an existing feed.
	 *
	 * @since 2.0
	 */
	public static function get_feed_settings() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$feed_id = ! empty( $_POST['feed_id'] ) ? $_POST['feed_id'] : false;

		if ( ! $feed_id ) {
			wp_die( 'no feed id' );
		}

		$feed_saver = new CTF_Feed_Saver( $feed_id );
		$settings = $feed_saver->get_feed_settings();

		$return = array(
			'settings' => $settings,
			'feed_html' => ''
		);

		if ( isset( $_POST['include_post_set'] ) &&
			! empty( $_POST['include_post_set'] ) ) {
			$atts = CTF_Feed_Builder::add_customizer_att( [ 'feed' => $return['feed_id'] ] );
			$return['feed_html'] = display_instagram( $atts );
		}

		echo ctf_json_encode( $return );
		wp_die();
	}

	/**
	 * Get a list of feeds with a limit and offset like a page
	 *
	 * @since 2.0
	 */
	public static function get_feed_list_page() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		$args = array( 'page' => (int)$_POST['page'] );
		$feeds_data = CTF_Feed_Builder::get_feed_list($args);

		echo ctf_json_encode( $feeds_data );

		wp_die();
	}

	/**
	 * Get a list of locations with a limit and offset like a page
	 *
	 * @since 2.0
	 */
	public static function get_locations_page() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		$args = array( 'page' => (int)$_POST['page'] );

		if ( ! empty( $_POST['is_legacy'] ) ) {
			$args['feed_id'] = sanitize_text_field( $_POST['feed_id'] );
		} else {
			$args['feed_id'] = '*' . (int)$_POST['feed_id'];
		}
		$feeds_data = \CTF_Feed_Locator::twitter_feed_locator_query( $args );

		if ( count( $feeds_data ) < CTF_Db::RESULTS_PER_PAGE ) {
			$args['html_location'] = array( 'footer', 'sidebar', 'header' );
			$args['group_by'] = 'html_location';
			$args['page'] = 1;
			$non_content_data = \CTF_Feed_Locator::twitter_feed_locator_query( $args );

			$feeds_data = array_merge( $feeds_data, $non_content_data );
		}

		echo ctf_json_encode( $feeds_data );

		wp_die();
	}

	/**
	 * Search UserName Lists
	 *
	 * @since 2.0
	*/
	public static function search_username_lists() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$request_settings = CTF_HTTP_Request::get_request_settings();
        $request_method = 'auto';
        $twitter_api = new CtfOauthConnectPro( $request_settings, 'listsmeta' );
        $twitter_api->setUrlBase();
        $get_fields = array( 'screen_name' => sanitize_text_field( $_POST['listUserNameInputModel'] ) );
        $twitter_api->setGetFields( $get_fields );
        $twitter_api->setRequestMethod( $request_method );

        $twitter_api->performRequest();
        $response = json_decode( $twitter_api->json , $assoc = true );
        if( isset( $response[0]['name'] ) ) {
            $lists = array();
            foreach( $response as $list ){
                $lists[] = array(
                    'name' => $list['name'],
                    'id' => $list['id_str']
                );
            }
            echo ctf_json_encode($lists);
        } else {
            echo '{"error" : "noLists"}';
        }

		wp_die();
	}


	/**
	 * Search UserName Lists
	 *
	 * @since 2.0
	*/
	public static function check_twitter_list_by_id() {
		check_ajax_referer( 'ctf-admin' , 'nonce');

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$response = [];
		$request_settings = CTF_HTTP_Request::get_request_settings();
        $request_method = 'auto';
        $twitter_api = new CtfOauthConnectPro( $request_settings, 'listlookup' );
        $twitter_api->setUrlBase();
		$twitter_api->setRequestMethod( $request_method );

        $list_ids_array = explode(',', sanitize_text_field( $_POST['listIds'] ) );
		if( is_array( $list_ids_array ) && sizeof( $list_ids_array ) > 0 ){
	        foreach ($list_ids_array as $list_id) {
	        	$get_fields = array( 'list_id' => $list_id );
		        $twitter_api->setGetFields( $get_fields );
		        $twitter_api->performRequest();
		        $single_response = json_decode( $twitter_api->json , $assoc = true );
	        	if( isset( $single_response['name'] ) ){
	        		array_push ($response , [
	        			'id'	=> $list_id,
	        			'name' => $single_response['name']
	        		]);
	        	}
	        }
		}

		if( sizeof( $response ) > 0 )
	    	echo ctf_json_encode($response);
		else {
            echo '{"error" : "noLists"}';
        }
		wp_die();
	}

	/**
	 * Delete Account
	 *
	 * @since 2.0
	*/
	public static function delete_account(){
		if ( ! check_ajax_referer( 'ctf_admin_nonce', 'nonce', false ) && ! check_ajax_referer( 'ctf-admin', 'nonce', false ) ) {
			wp_send_json_error();
		}
		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}
		$options = get_option( 'ctf_options', array() );
		if( isset( $_POST['deleteApp'] ) && $_POST['deleteApp'] == true ){
			$options['app_name'] 			= '';
			$options['consumer_key'] 		= '';
			$options['consumer_secret'] 	= '';
		}
		$options['access_token'] 		= '';
		$options['access_token_secret'] = '';
		$options['account_handle'] 		= '';
		$options['account_avatar'] 		= '';
		update_option( 'ctf_options', $options );

		$return = [
			'app_name' => $options['app_name'],
			'consumer_key' => $options['consumer_key'],
			'consumer_secret' => $options['consumer_secret'],
			'access_token' => $options['access_token'],
			'access_token_secret' => $options['access_token_secret'],
			'account_handle' => $options['account_handle'],
			'account_avatar' => $options['account_avatar']
		];
		echo json_encode($return);
		wp_die();

	}

	/**
	 * Connect Manual Account
	 *
	 * @since 2.0
	*/
	public static function connect_manual_account() {
		if ( ! check_ajax_referer( 'ctf_admin_nonce', 'nonce', false ) && ! check_ajax_referer( 'ctf-admin', 'nonce', false ) ) {
			wp_send_json_error();
		}

		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
		$cap = apply_filters( 'ctf_settings_pages_capability', $cap );
		if ( ! current_user_can( $cap ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		if( !empty( $_POST['access_token'] ) && !empty( $_POST['access_token_secret'] ) ){
			$consumer_key = ! empty( $_POST['consumer_key'] ) ? $_POST['consumer_key'] : 'FPYSYWIdyUIQ76Yz5hdYo5r7y';
	        $consumer_secret = ! empty( $_POST['consumer_secret'] ) ? $_POST['consumer_secret'] : 'GqPj9BPgJXjRKIGXCULJljocGPC62wN2eeMSnmZpVelWreFk9z';
	        $request_settings = array(
	            'consumer_key' => $consumer_key,
	            'consumer_secret' =>  $consumer_secret,
	            'access_token' =>  $_POST['access_token'],
	            'access_token_secret' =>  $_POST['access_token_secret']
	        );
	        $request_method = 'auto';
	        $twitter_api = new CtfOauthConnectPro( $request_settings, 'accountlookup' );
	        $twitter_api->setUrlBase();
	        $twitter_api->setRequestMethod( $request_method );
	        $twitter_api->performRequest();
	        $response = json_decode( $twitter_api->json , $assoc = true );
	        if( isset( $response['errors'] ) ){
            	echo '{"error" : "noAccount"}';
	        }else{
	        	$options = get_option( 'ctf_options', array() );
		        $options['app_name'] 			= ! empty( $_POST['app_name'] ) ? sanitize_text_field($_POST['app_name']) : '';
		        $options['consumer_key'] 		= ! empty( $_POST['consumer_key'] ) ? sanitize_text_field($_POST['consumer_key']) : '';
		        $options['consumer_secret'] 	= ! empty( $_POST['consumer_secret'] ) ? sanitize_text_field($_POST['consumer_secret']) : '';
		        $options['access_token'] 		= sanitize_text_field($_POST['access_token']);
		        $options['access_token_secret'] = sanitize_text_field($_POST['access_token_secret']);
		        $options['account_handle'] 		= isset( $response['screen_name'] ) ? sanitize_text_field($response['screen_name']) : '';
		        $options['account_avatar'] 		= isset( $response['profile_image_url'] ) ? sanitize_text_field($response['profile_image_url']) : '';
		        update_option( 'ctf_options', $options );
		        $return = [
					'app_name' => $options['app_name'],
					'consumer_key' => $options['consumer_key'],
					'consumer_secret' => $options['consumer_secret'],
					'access_token' => $options['access_token'],
					'access_token_secret' => $options['access_token_secret'],
					'account_handle' => $options['account_handle'],
					'account_avatar' => $options['account_avatar']
				];
				echo json_encode($return);
	        }
		}
		wp_die();
	}


	/**
	 * Return a single JSON string for importing a feed
	 *
	 * @param int $feed_id
	 *
	 * @return string
	 *
	 * @since 2.0
	*/
	public static function get_export_json( $feed_id ) {
		$feed_saver = new CTF_Feed_Saver( $feed_id );
		$settings = $feed_saver->get_feed_settings();

		return ctf_json_encode( $settings );
	}

	/**
	 * All export strings for all feeds on the first 'page'
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_all_export_json() {
		$args = array( 'page' => 1 );

		$feeds_data = CTF_Db::feeds_query( $args );

		$return = array();
		foreach ( $feeds_data as $single_feed ) {
			$return[ $single_feed['id'] ] = CTF_Feed_Saver_Manager::get_export_json( $single_feed['id'] );
		}

		return $return;
	}

	/**
	 * Use a JSON string to import a feed with settings and sources. The return
	 * is whether or not the import was successful
	 *
	 * @param string $json
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function import_feed( $json ) {
		$settings_data = json_decode( $json, true );

		$return = array(
			'success' => false,
			'message' => ''
		);

		$feed_saver = new CTF_Feed_Saver( false );
		$feed_saver->set_data( $settings_data );

		if ( $feed_saver->update_or_insert() ) {
			$return = array(
				'success' => true,
				'feed_id' => $feed_saver->get_feed_id()
			);

			return $return;
		} else {
			$return['message'] = __( 'Could not import feed. Please try again', 'custom-twitter-feeds' );
		}
		return $return;
	}



	/**
	 * Determines what table and sanitization should be used
	 * when handling feed setting data.
	 *
	 * TODO: Add settings that need something other than sanitize_text_field
	 *
	 * @param string $key
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_data_type( $key ) {
		switch ( $key ) {
			case 'feed_title' :
			$return = array(
				'table' => 'feeds',
				'sanitization' => 'sanitize_text_field'
			);
			break;
			case 'feed_name' :
			$return = array(
				'table' => 'feeds',
				'sanitization' => 'sanitize_text_field'
			);
			break;
			case 'status' :
			$return = array(
				'table' => 'feeds',
				'sanitization' => 'sanitize_text_field'
			);
			break;
			case 'author' :
			$return = array(
				'table' => 'feeds',
				'sanitization' => 'int'
			);
			break;
			case 'lists_info' :
			$return = array(
				'table' => 'feed_settings',
				'sanitization' => 'json'
			);
			break;
			default:
			$return = array(
				'table' => 'feed_settings',
				'sanitization' => 'sanitize_text_field'
			);
			break;
		}

		return $return;
	}

	/**
	 * Uses the appropriate sanitization function and returns the result
	 * for a value
	 *
	 * @param string $type
	 * @param int|string $value
	 *
	 * @return int|string
	 *
	 * @since 2.0
	 */
	public static function sanitize( $type, $value ) {
		switch ( $type ) {
			case 'int' :
				$return = intval( $value );
			break;
			case 'boolean' :
				$return = self::cast_boolean($value);
			break;
			case 'json' :
				$return = stripslashes($value);
			break;
			default:
				$return = sanitize_text_field( $value );
			break;
		}

		return $return;
	}

	/**
	 * Check if boolean
	 * for a value
	 *
	 * @param string $type
	 * @param int|string $value
	 *
	 * @return int|string
	 *
	 * @since 2.0
	 */
	public static function is_boolean( $value ) {
		return ( $value === 'true' || $value === 'false' || is_bool($value)  ) ? true : false;
	}

	public static function cast_boolean( $value ) {
		if($value === 'true' || $value === true || $value === 'on' || $value === '1')
			return true;
		return false;
	}

	public static function cast_boolean_string( $value ) {
		if($value === 'true' || $value === true || $value === 'on' || $value === '1' || $value === 1)
			return 'true';
		return 'false';
	}

}

<?php
/**
 * Instagram Feed Database
 *
 * @since 2.0
 */

namespace TwitterFeed\Builder;
use TwitterFeed\Pro\CTF_Settings_Pro;

class CTF_Feed_Saver {

	/**
	 * @var int
	 *
	 * @since 2.0
	 */
	private $insert_id;

	/**
	 * @var array
	 *
	 * @since 2.0
	 */
	private $data;

	/**
	 * @var array
	 *
	 * @since 2.0
	 */
	private $sanitized_and_sorted_data;

	/**
	 * @var array
	 *
	 * @since 2.0
	 */
	private $feed_db_data;


	/**
	 * @var string
	 *
	 * @since 2.0
	 */
	private $feed_name;

	/**
	 * @var bool
	 *
	 * @since 2.0
	 */
	private $is_legacy;

	/**
	 * CTF_Feed_Saver constructor.
	 *
	 * @param int $insert_id
	 *
	 * @since 2.0
	 */
	public function __construct( $insert_id ) {
		if ( $insert_id === 'legacy' ) {
			$this->is_legacy = true;
			$this->insert_id = 0;
		} else {
			$this->is_legacy = false;
			$this->insert_id = $insert_id;
		}
	}

	/**
	 * Feed insert ID if it exists
	 *
	 * @return bool|int
	 *
	 * @since 2.0
	 */
	public function get_feed_id() {
		if ( $this->is_legacy ) {
			return 'legacy';
		}
		if ( ! empty( $this->insert_id ) ) {
			return $this->insert_id;
		} else {
			return false;
		}
	}

	/**
	 * @param array $data
	 *
	 * @since 2.0
	 */
	public function set_data( $data ) {
		$this->data = $data;
	}

	/**
	 * @param string $feed_name
	 *
	 * @since 2.0
	 */
	public function set_feed_name( $feed_name ) {
		$this->feed_name = $feed_name;
	}

	/**
	 * @param array $feed_db_data
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_feed_db_data() {
		return $this->feed_db_data;
	}

	/**
	 * Adds a new feed if there is no associated feed
	 * found. Otherwise updates the exiting feed.
	 *
	 * @return false|int
	 *
	 * @since 2.0
	 */
	public function update_or_insert() {
		$this->sanitize_and_sort_data();

		if ( $this->exists_in_database() ) {
			return $this->update();
		} else {
			return $this->insert();
		}
	}

	/**
	 * Whether or not a feed exists with the
	 * associated insert ID
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */
	public function exists_in_database() {
		if ( $this->is_legacy ) {
			return true;
		}

		if ( $this->insert_id === false ) {
			return false;
		}

		$args = array(
			'id' => $this->insert_id
		);

		$results = CTF_Db::feeds_query( $args );

		return isset( $results[0] );
	}

	/**
	 * Inserts a new feed from sanitized and sorted data.
	 * Some data is saved in the ctf_feeds table and some is
	 * saved in the ctf_feed_settings table.
	 *
	 * @return false|int
	 *
	 * @since 2.0
	 */
	public function insert() {
		if ( $this->is_legacy ) {
			return $this->update();
		}

		if ( ! isset( $this->sanitized_and_sorted_data ) ) {
			return false;
		}

		$settings_array = CTF_Feed_Saver::format_settings( $this->sanitized_and_sorted_data['feed_settings'] );

		$this->sanitized_and_sorted_data['feeds'][] = array(
			'key' => 'settings',
			'values' => array( ctf_json_encode( $settings_array ) )
		);

		if ( ! empty( $this->feed_name ) ) {
			$this->sanitized_and_sorted_data['feeds'][] = array(
				'key' => 'feed_name',
				'values' => array( $this->feed_name )
			);
		}

		$this->sanitized_and_sorted_data['feeds'][] = array(
			'key' => 'status',
			'values' => array( 'publish' )
		);

		$insert_id = CTF_Db::feeds_insert( $this->sanitized_and_sorted_data['feeds'] );

		if ( $insert_id ) {
			$this->insert_id = $insert_id;

			return $insert_id;
		}

		return false;
	}

	/**
	 * Updates an existing feed and related settings from
	 * sanitized and sorted data.
	 *
	 * @return false|int
	 *
	 * @since 2.0
	 */
	public function update() {
		if ( ! isset( $this->sanitized_and_sorted_data ) ) {
			return false;
		}

		$args = array(
			'id' => $this->insert_id
		);

		$settings_array = CTF_Feed_Saver::format_settings( $this->sanitized_and_sorted_data['feed_settings'] );

		if ( $this->is_legacy ) {
			$to_save_json = ctf_json_encode( $settings_array );
			return update_option( 'ctf_legacy_feed_settings', $to_save_json, false );
		}

		$this->sanitized_and_sorted_data['feeds'][] = array(
			'key' => 'settings',
			'values' => array( ctf_json_encode( $settings_array ) )
		);

		$this->sanitized_and_sorted_data['feeds'][] = array(
			'key' => 'feed_name',
			'values' => [sanitize_text_field($this->feed_name)]
		);

		$success = CTF_Db::feeds_update( $this->sanitized_and_sorted_data['feeds'], $args );

		return $success;
	}

	/**
	 * Converts settings that have been sanitized into an associative array
	 * that can be saved as JSON in the database
	 *
	 * @param $raw_settings
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function format_settings( $raw_settings ) {
		$settings_array = array();
		foreach ( $raw_settings as $single_setting ) {
			if ( count( $single_setting['values'] ) > 1 ) {
				$settings_array[ $single_setting['key'] ] = $single_setting['values'];

			} else {
				$settings_array[ $single_setting['key'] ] = isset( $single_setting['values'][0] ) ? $single_setting['values'][0] : '';
			}
		}

		return $settings_array;
	}

	/**
	 * Gets the Preview Settings
	 * for the Feed Fly Preview
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public function get_feed_preview_settings( $preview_settings ){

	}

	/**
	 * Retrieves and organizes feed setting data for easy use in
	 * the builder
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public function get_feed_settings() {
		if ( $this->is_legacy ) {
			if ( ctf_is_pro_version() ) {
				$twitter_feed_settings = new CTF_Settings_Pro( array(), ctf_get_database_settings(), array() );
			} else {
				$twitter_feed_settings = new CTF_Settings_Pro( array(), ctf_get_database_settings(), array() );
			}


			$twitter_feed_settings->set_feed_type_and_terms();
			//$twitter_feed_settings->set_transient_name();
			$return = $twitter_feed_settings->get_settings();

			$this->feed_db_data = array(
				'id' => 'legacy',
				'feed_name' => __( 'Legacy Feeds', 'custom-twitter-feeds' ),
				'feed_title' => __( 'Legacy Feeds', 'custom-twitter-feeds' ),
				'status' => 'publish',
				'last_modified' => date( 'Y-m-d H:i:s' ),
			);
		} else if ( empty( $this->insert_id ) ) {
			return false;
		} else {
			$args = array(
				'id' => $this->insert_id,
			);
			$settings_db_data = CTF_Db::feeds_query( $args );
			if ( false === $settings_db_data || sizeof($settings_db_data) == 0) {
				return false;
			}
			$this->feed_db_data = array(
				'id' => $settings_db_data[0]['id'],
				'feed_name' => $settings_db_data[0]['feed_name'],
				'feed_title' => $settings_db_data[0]['feed_title'],
				'status' => $settings_db_data[0]['status'],
				'last_modified' => $settings_db_data[0]['last_modified'],
			);

			$return = json_decode( $settings_db_data[0]['settings'], true );
			$return['feed_name'] = $settings_db_data[0]['feed_name'];
		}


		$return = wp_parse_args( $return, CTF_Feed_Saver::settings_defaults() );





		return $return;
	}



	/**
	 * Retrieves and organizes feed setting data for easy use in
	 * the builder
	 * It will NOT get the settings from the DB, but from the Customizer builder
	 * To be used for updating feed preview on the fly
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public function get_feed_settings_preview( $settings_db_data ) {
		if ( false === $settings_db_data || sizeof($settings_db_data) == 0) {
			return false;
		}
		$return = $settings_db_data;
		$return = wp_parse_args( $return, CTF_Feed_Saver::settings_defaults() );

		return $return;
	}



	/**
	 * Default settings, $return_array equalling false will return
	 * the settings in the general way that the "CTF_Shortcode" class,
	 * "ctf_get_processed_options" method does
	 *
	 * @param bool $return_array
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function settings_defaults( $return_array = true ) {
		{
			$translations = get_option( 'ctf_options', array() );

			$final_translations = [];
			$final_translations['retweetedtext'] = isset( $translations['retweetedtext'] ) ? stripslashes( esc_attr( $translations['retweetedtext'] ) ) : __( 'Retweeted', 'custom-twitter-feeds' );
			$final_translations['inreplytotext'] = isset( $translations['inreplytotext'] ) ? stripslashes( esc_attr( $translations['inreplytotext'] ) ) : __( 'In Reply To', 'custom-twitter-feeds' );
			$final_translations['buttontext'] = isset( $translations['buttontext'] ) ? stripslashes( esc_attr( $translations['buttontext'] ) ) : __( 'Load More', 'custom-twitter-feeds' );
			$final_translations['minutestext'] = isset( $translations['minutestext'] ) ? stripslashes( esc_attr( $translations['minutestext'] ) ) : __( 'Minutes', 'custom-twitter-feeds' );
			$final_translations['hoursetext'] = isset( $translations['hoursetext'] ) ? stripslashes( esc_attr( $translations['hoursetext'] ) ) : __( 'Hours', 'custom-twitter-feeds' );
			$final_translations['nowtext'] = isset( $translations['nowtext'] ) ? stripslashes( esc_attr( $translations['nowtext'] ) ) : __( 'Now', 'custom-twitter-feeds' );




			$defaults = array(
				//V2
				'customizer' => false,

				'ajax_theme' => false,
				'have_own_tokens' => '',
				'use_own_consumer' => '',
				#'preserve_settings' => '',

				'usertimeline_includereplies' => '',
				'hometimeline_includereplies' => '',
				'mentionstimeline_includereplies' => '',
				'usertimeline_includeretweets' => '',
				'hometimeline_includeretweets' => true,
				'mentionstimeline_includeretweets' => '',
				'tab' => 'configure',
				'consumer_key' => '',
				'consumer_secret' => '',
				'access_token' => '',
				'access_token_secret' => '',
				'type' => 'usertimeline',
				'usertimeline_text' => '',
				'hashtag_text' => '',
				'search_text' => '',
				'lists_id' => '',
				'lists_owner' => '',
				'num' => '5',
				#'cache_time' => '1',
				#'cache_time_unit' => '3600',
				'lists_info' => '{}',

				'includereplies' => false,
				'includeretweets' => true,
				'width_mobile_no_fixed' => false,

				'include_replied_to' => true,

				'include_retweeter' => true,
				'include_author' => true,
				'include_avatar' => true,
				'include_author_text' => true, //NEW
				'include_text' => true,
				'include_date' => true,
				'include_actions' => true,
				'include_linkbox' => true,
				'include_media' => true,
				'include_twittercards' => true,
				'include_logo' => true,

				'include_twitterlink' => true,


				'creditctf' => false,
				'showbutton' => true,
				'showheader' => true,
				'persistentcache' => true,
				'selfreplies' => true,
				'autores' => true,
				'disableintents' => false,
		     	'customtemplates' => false,
				'shorturls' => false,
				'curlcards' => true,
				'sslonly' => false,
				'disablelightbox' => false,
				'masonry' => false,
				'carousel' => false,
				'carouselnavarrows' => true,
				'carouselpag' => false,
				'carouselautoplay' => false,
				'autoscroll' => false,
				'width' => '100',
				'width_unit' => '%',
				'height' => '',
				'height_unit' => '%',
				'class' => '',
				'layout' => 'list',
				'masonrycols' => '3',
				'masonrytabletcols' => '2', //NEW
				'masonrymobilecols' => '1',
				'carouselrows' => '1', //NEW
				'carouselcols' => '3',
				'carouseltabletcols' => '2', //NEW
				'carouselmobilecols' => '1',
				'carouselloop' => 'rewind',
				'carouselarrows' => 'onhover',
				'carouselheight' => 'tallest',
				'carouseltime' => '5000',
				'maxmedia' => '4',
				'imagecols' => 'auto',
				'autoscrolldistance' => '200',
				'includewords' => '',
				'excludewords' => '',
				'includeanyall' => 'any',
				'filterandor' => 'and',
				'excludeanyall' => 'any',
				'remove_by_id' => '',
				'custom_css' => '',
				'custom_js' => '',
				'request_method' => 'auto',
				'cron_cache_clear' => 'unset',
				'multiplier' => '1.25',
				'font_method' => 'svg',
				'include_media_placeholder' => true,
				'showbio' => true,
				'disablelinks' => false,
				'linktexttotwitter' => false,
				'bgcolor' => '#',

				'headertextcolor' => '#', //OLD
				'headertext' => '', //OLD
				'headersize' => 'small', //OLD

				'headerstyle' => 'standard', //NEW
				'headerbgcolor' => '#',
				'customheadertextcolor' => '#',
				'customheadertext' => __( 'We are on Twitter', 'custom-twitter-feeds' ),
				'customheadersize' => 'small',


				'timezone' => 'default',
				'dateformat' => '1',
				'datecustom' => '',
				'mtime' => '',
				'htime' => '',
				'nowtime' => '',
				'datetextsize' => 'inherit',
				'datetextweight' => 'inherit',
				'datetextcolor' => '#',
				'authortextcolor' => '#',
				'authortextsize' => 'inherit',
				'authortextweight' => 'inherit',
				'logosize' => 'inherit',
				'logocolor' => '#',
				'tweettextsize' => 'inherit',
				'tweettextweight' => 'inherit',
				'textcolor' => '#',
				'textlength' => '280',
				'retweetedtext' => $final_translations['retweetedtext'],
				'linktextcolor' => '#',
				'quotedauthorsize' => 'inherit',
				'quotedauthorweight' => 'inherit',
				'iconsize' => 12,
				'iconcolor' => '#',
				'viewtwitterlink' => true, //NEW
				'twitterlinktext' => 'Twitter',
				'buttoncolor' => '#',
				'buttonhovercolor' => '#',
				'buttontextcolor' => '#',
				'buttontext' => $final_translations['buttontext'],
				'inreplytotext' => $final_translations['inreplytotext'],

				'feedtemplate' => 'default',// NEW
				'cardstextsize'	=> 'inherit', // NEW
				'cardstextcolor'	=> '#', // NEW

				'colorpalette'	=> 'inherit', // NEW
				'custombgcolor'=>	'', // NEW
				'customaccentcolor'=>	'', // NEW
				'customtextcolor1'	=>	'', // NEW
				'customtextcolor2'	=>	'', // NEW
				'customlinkcolor'		=>	'', // NEW

				'tweetpoststyle' => 'regular',
				'tweetbgcolor' => '#fff',
				'tweetcorners' => '5',
				'tweetboxshadow' => true,
				'tweetsepcolor' => '#ddd', // NEW
				'tweetsepsize' => '1',
				'tweetsepline' => true
			);

			$defaults = CTF_Feed_Saver::filter_defaults( $defaults );

			// some settings are comma separated and not arrays when the feed is created
			if ( $return_array ) {
				$settings_with_multiples = array(
				);

				foreach ( $settings_with_multiples as $multiple_key ) {
					if ( isset( $defaults[ $multiple_key ] ) ) {
						$defaults[ $multiple_key ] = explode( ',', $defaults[ $multiple_key ] );
					}
				}
			}

			return $defaults;
		}
	}

	/**
	 * Provides backwards compatibility for extensions
	 *
	 * @param array $defaults
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function filter_defaults( $defaults ) {

		return $defaults;
	}

	/**
	 * Saves settings for legacy feeds. Runs on first update automatically.
	 *
	 * @since 2.0
	 */
	public static function set_legacy_feed_settings() {
		$to_save = CTF_Post_Set::legacy_to_builder_convert();

		$to_save_json = ctf_json_encode( $to_save );

		update_option( 'ctf_legacy_feed_settings', $to_save_json, false );
	}

	/**
	 * Used for taking raw post data related to settings
	 * an sanitizing it and sorting it to easily use in
	 * the database tables
	 *
	 * @since 2.0
	 */
	private function sanitize_and_sort_data() {
		$data = $this->data;

		$sanitized_and_sorted = array(
			'feeds' => array(),
			'feed_settings' => array()
		);

		foreach ( $data as $key => $value ) {
			$data_type = CTF_Feed_Saver_Manager::get_data_type( $key );
			$sanitized_values = array();
			if ( is_array( $value ) ) {
				foreach ( $value as $item ) {
					$type = CTF_Feed_Saver_Manager::is_boolean( $item ) ? 'boolean' : $data_type['sanitization'];
					$sanitized_values[] = CTF_Feed_Saver_Manager::sanitize( $type , $item );
				}
			} else {
				$type = CTF_Feed_Saver_Manager::is_boolean( $value ) ? 'boolean' : $data_type['sanitization'];
				$sanitized_values[] = CTF_Feed_Saver_Manager::sanitize( $type, $value );
			}

			$single_sanitized = array(
				'key' => $key,
				'values' => $sanitized_values
			);

			$sanitized_and_sorted[ $data_type['table'] ][] = $single_sanitized;
		}

		$this->sanitized_and_sorted_data = $sanitized_and_sorted;
	}
}
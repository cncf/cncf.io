<?php
/**
 * Instagram Feed Feed Post Set
 *
 * @since 2.0
 */

namespace TwitterFeed\Builder;


class CTF_Post_Set {

	/**
	 * @var int
	 */
	private $feed_id;

	/**
	 * @var array
	 */
	private $feed_settings;

	/**
	 * @var array
	 */
	private $converted_settings;

	/**
	 * @var string
	 */
	private $transient_name;

	/**
	 * @var array|object
	 */
	private $data;

	/**
	 * @var array|object
	 */
	private $comments_data;

	public function __construct( $feed_id ) {
		$this->feed_id = $feed_id;
		$this->transient_name = '*' . $feed_id;

		$this->data = array();
	}

	/**
	 * @return array|object
	 *
	 * @since 2.0
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * @return array|object
	 *
	 * @since 2.0
	 */
	public function get_comments_data() {
		return $this->comments_data;
	}

	/**
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_feed_settings() {
		return $this->feed_settings;
	}

	/**
	 * @return array
	 *
	 * @since 2.0
	 */
	public function get_converted_settings() {
		return $this->converted_settings;
	}

	/**
	 * Sets the settings in builder form as well as converted
	 * settings for general use in the plugin
	 *
	 * @since 2.0
	 */
	public function init( $customizerBuilder = false, $previewSettings = false ) {
		$saver = new CTF_Feed_Saver( $this->feed_id );
		if( $customizerBuilder && $previewSettings != false){
			$this->feed_settings = $saver->get_feed_settings_preview( $previewSettings );
		} else{
			$this->feed_settings = $saver->get_feed_settings();
		}

		$this->converted_settings = CTF_Post_Set::builder_to_general_settings_convert( $this->feed_settings );
	}

	/**
	 * Gathers posts from the API until the minimum number of posts
	 * for the feed are retrieved then stores the results
	 *
	 * @since 2.0
	 */
	public function fetch() {
		$post_data = [];
		$this->data = $post_data;
	}

	/**
	 * Gathers comments for posts.
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function fetch_comments() {
		if ( empty( $this->data ) ) {
			return array();
		}

		$comments = [];
		$this->comments_data = $comments;

		return $comments;
	}

	/**
	 * Converts raw settings from the cff_feed_settings table into the
	 * more general way that the "CFF_Shortcode" class,
	 * "cff_get_processed_options" method does
	 *
	 * @param array $builder_settings
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function builder_to_general_settings_convert( $builder_settings ) {
		$settings_with_multiples = array();

		foreach ( $settings_with_multiples as $array_setting ) {
			if ( is_array( $builder_settings[ $array_setting ] ) ) {
				$builder_settings[ $array_setting ] = implode( ',', $builder_settings[ $array_setting ] );
			}
		}

		if ( isset( $builder_settings['sources'] ) && is_array($builder_settings['sources'])) {

			$access_tokens = array();
			$ids = array();
			$id_access_tokens = array();
			$sources_setting = array();
			foreach ( $builder_settings['sources'] as $source ) {
				$source_array = array();
				if ( ! is_array( $source ) ) {
					$args = array( 'id' => $source );
					if ( isset( $builder_settings['feedtype'] ) && $builder_settings['feedtype'] == 'events' ){
						$args['privilege'] = 'events';
					}
					$source_query = CTF_Db::source_query( $args );

					if ( isset( $source_query[0] ) ) {
						$source_array = $source_query[0];
						$sources_setting[] = $source_query[0];
					}
				} else {
					$source_array = $source;
				}


				if ( ! empty( $source_array ) ) {
					$access_tokens[] = $source_array['access_token'];
				}

			}

			if ( ! empty( $sources_setting ) ) {
				$builder_settings['sources'] = $sources_setting;
			}
		}

		return $builder_settings;
	}

	/**
	 * Convert settings from 3.x for use in the builder in 6.0+
	 *
	 * @param array $atts
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function legacy_to_builder_convert( $atts = array() ) {
		$processed_settings = [];

		return $processed_settings;
	}

	/**
	 * Settings that can include an array of values
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function get_settings_with_multiple() {
		$settings_with_multiples = [];

		return $settings_with_multiples;
	}

	/**
	 * Used for changing the settings used for general front end feeds
	 *
	 * @param array $builder_settings
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function filter_general_settings( $builder_settings ) {
		return $builder_settings;
	}

	/**
	 * Used for changing the settings for feeds being edited in the customizer
	 *
	 * @param array $processed_settings
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public static function filter_builder_settings( $processed_settings ) {
		return $processed_settings;
	}
}
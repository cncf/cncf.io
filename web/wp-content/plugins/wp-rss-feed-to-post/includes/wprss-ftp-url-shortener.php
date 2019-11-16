<?php
/**
 * This files contains functions relating to shortening URLs to original posts
 *
 * @since 2.8.6
 */

class WPRSS_FTP_Url_Shortener {

	const SETTINGS_GOOGLE_API_KEY = 'google_api_key';
	const META_KEY_URL_SHORTENING_METHOD = 'url_shortening_method';
	const META_KEY_SHORT_URL = 'short_url';

	const URL_GOOGLE_URL_SHORTENER_API = 'https://www.googleapis.com/urlshortener/v1/url';

	public static function init() {
		is_admin() && self::init_admin();

		self::plugin_google_url_shortener_api();
	}

	/**
	 * Initialization for backend
	 *
	 * @since 2.8.6
	 */
	public static function init_admin() {
		add_filter('wprss_ftp_meta_fields', 'WPRSS_FTP_Url_Shortener::add_meta_fields');
		add_filter('add_meta_boxes', 'WPRSS_FTP_Url_Shortener::add_meta_boxes', 20);
		add_filter('wprss_ftp_default_settings', 'WPRSS_FTP_Url_Shortener::default_settings');
        add_filter('wprss_ftp_section_docs_link_urls', 'WPRSS_FTP_Url_Shortener::register_setting_section_docs_urls');
		add_action('wprss_ftp_after_settings_register', 'WPRSS_FTP_Url_Shortener::register_settings');
	}

	/**
	 * Adds shortener-specific default settings
	 *
	 * @since 2.8.6
	 * @param array $settings The array of default settings.
	 * @return string The potentially modified array of default settings.
	 */
	public static function default_settings($settings) {
		$settings[self::SETTINGS_GOOGLE_API_KEY]	= '';
		$settings[self::META_KEY_URL_SHORTENING_METHOD]	= '';
		return $settings;
	}

    public static function register_setting_section_docs_urls($urls) {
        $urls['wprss_settings_ftp_url_shortening_section'] = 'https://kb.wprssaggregator.com/article/309-how-to-set-up-feed-to-posts-url-shortening-option';
        return $urls;
    }

	/**
	 * Registering sections and fields for URL Shortening
	 *
	 * @param WPRSS_FTP_Settings $settings
	 */
	public static function register_settings($settings) {

		add_settings_section(
			'wprss_settings_ftp_url_shortening_section',		    // ID to identify this section
			__( 'URL Shortening', WPRSS_TEXT_DOMAIN )               // Title to be displayed on the administration page
                . $settings->get_section_docs_link_html('wprss_settings_ftp_url_shortening_section'), // Documentation link
			'WPRSS_FTP_Url_Shortener::render_url_shortening_section',   // Callback that renders the description of the section
			'wprss_settings_ftp'					    // Page on which to add this section of options
		);

		add_settings_field(
			'wprss-settings-ftp-url-shortening-method',		// ID used to identify the field
			__( 'Method', WPRSS_TEXT_DOMAIN ),				// The label to the left of the option element
			'WPRSS_FTP_Url_Shortener::render_url_shortening_method',// The function that renders the option interface
			'wprss_settings_ftp',					// The page on which this option will be displayed
			'wprss_settings_ftp_url_shortening_section'		// The section to which this field belongs
		);

		add_settings_field(
			'wprss-settings-ftp-google-api-key',			// ID used to identify the field
			__( 'Google API Key', WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			'WPRSS_FTP_Url_Shortener::render_google_api_key',	// The function that renders the option interface
			'wprss_settings_ftp',					// The page on which this option will be displayed
			'wprss_settings_ftp_url_shortening_section'		// The section to which this field belongs
		);
	}

	/**
	 * URL Shortening Section
	 * @since 2.8.6
	 */
	public static function render_url_shortening_section() {
	    ?><p><?php _e( 'Configure URL Shortening', WPRSS_TEXT_DOMAIN ) ?></p><?php
	}

	/**
	 * Renders the URL shortening method list option
	 *
	 * @since 2.8.6
	 */
	public static function render_url_shortening_method( $args ) {
		$metaKey = self::META_KEY_URL_SHORTENING_METHOD;
		$shortening_method = WPRSS_FTP_Settings::get_instance()->get( $metaKey );
		$field = WPRSS_FTP_Meta::get_instance()->get_meta_fields('url_shortening');
		$field = $field[$metaKey];
		$options = $field['options'];
		echo WPRSS_FTP_Utils::array_to_select( $options,
			array(
				'id'		=> str_replace('_', '-', $metaKey),
				'name'		=> WPRSS_FTP_Settings::OPTIONS_NAME . sprintf('[%1$s]', $metaKey),
				'selected'	=> $shortening_method,
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'url_shortening_method' );
	}

	/**
	 * Renders the field for the 'google_api_key' in the backend.
	 *
	 * @since 2.8.6
	 * @param null|array $args The array of arguments passed to {@link add_settings_field()} that registered this function.
	 */
	public static function render_google_api_key( $args ) {
		$api_key = WPRSS_FTP_Settings::get_instance()->get( 'google_api_key' ); ?>
		<input type="text" id="google-api-key" name="<?php echo WPRSS_FTP_Settings::OPTIONS_NAME ?>[google_api_key]" value="<?php echo $api_key ?>" />
		<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'google_api_key' ); ?>
		<p class="description">
			<?php
				$url = sprintf( 'href="%1$s"', esc_attr( 'https://developers.google.com/url-shortener/v1/getting_started' ) );
				printf( __( 'Learn more about the <a %s target="_blank">Google URL Shortener API</a>', WPRSS_TEXT_DOMAIN ), $url );
			?>
		</p>
		<?php
	}

	/**
	 * Adds meta fields to the configuration
	 *
	 * @since 2.8.6
	 * @param array $fields
	 * @return array
	 */
	public static function add_meta_fields($fields) {
		$fields['url_shortening'] =	array(
			// What service or algorithm to use for shortening
			self::META_KEY_URL_SHORTENING_METHOD	=> array(
				'label'			=> __('Method'),
				'type'			=> 'dropdown',
				'options'		=> self::get_url_shortening_methods()
			)
		);

		return $fields;
	}

	/**
	 * Retrieve the shortening methods.
	 * Use the 'wprss_ftp_url_shortening_methods' filter to add or remove.
	 * the '' (empty string) method is reserved to signify no shortening.
	 *
	 * @since 2.8.6
	 * @return array An array of shortening methods, with codes as keys and (translated) labels as values.
	 */
	public static function get_url_shortening_methods() {
		return apply_filters( 'wprss_ftp_url_shortening_methods', array(
			''				=>  __( 'None', WPRSS_TEXT_DOMAIN )
		));
	}

	/**
	 * Actually adds the meta boxes
	 *
	 * @since 2.8.6
	 */
	public static function add_meta_boxes() {

		add_meta_box(
			'wprss-ftp-url-shortening-metabox',			    // $id
			__( 'Feed to Post - URL Shortening', WPRSS_TEXT_DOMAIN ),		    // $title
			'WPRSS_FTP_Url_Shortener::render_url_shortening_metabox',   // $callback
			'wprss_feed',						    // $post_type
			'side',						    // $context
			'default'						    // $priority
		);
	}

	/**
	 * Renders the URL shortening method metabox
	 *
	 * @since 2.8.6
	 * @param WP_Post $post The instance of the post, for which this metabox appears
	 */
	public static function render_url_shortening_metabox($post, $args) {
		WPRSS_FTP_Meta::get_instance()->render_metabox( 'url_shortening', $post, $args );
	}

	/**
	 * Plugs in the Google URL Shortener API method
	 *
	 * @since 2.8.6
	 */
	public static function plugin_google_url_shortener_api() {
		add_filter( 'wprss_ftp_url_shortening_methods', 'WPRSS_FTP_Url_Shortener::add_shortening_method_google_url_shortener_api' );
		add_filter( 'wprss_ftp_shorten_url', 'WPRSS_FTP_Url_Shortener::shorten_url_method_google_url_shortener_api', 10, 2 );
	}

	/**
	 * Adds the Google URL Shortener API to the list of available methods
	 *
	 * @see plugin_google_url_shortener_api()
	 * @since 2.8.6
	 * @param array $methods Already existing methods of URL shortening
	 * @return array Potentially modified list of URL shortening methods
	 */
	public static function add_shortening_method_google_url_shortener_api($methods) {
		$methods = is_array($methods) ? $methods : array();
		$methods['google_url_shortener_api'] = __( 'Google URL Shortener API', WPRSS_TEXT_DOMAIN );
		return $methods;
	}

	/**
	 * Gets the value of the WPRSS_URL_GOOGLE_URL_SHORTENER_API constant,
	 * falling back to WPRSS_FTP_Url_Shortener::URL_GOOGLE_URL_SHORTENER_API.
	 *
	 * @since 2.8.6
	 * @return string The URL of the Google URL Shortener API service
	 */
	public static function get_method_url_google_url_shortener_api() {
		return defined( 'WPRSS_URL_GOOGLE_URL_SHORTENER_API' ) ? constant( 'WPRSS_URL_GOOGLE_URL_SHORTENER_API' ) : self::URL_GOOGLE_URL_SHORTENER_API;
	}

	/**
	 * Implementation of the shortening logic. Will shorten the specified
	 * URL using {@link https://developers.google.com/url-shortener/ Google URL Shortener API}
	 * While this function may be called directly, it is intended to be
	 * a handler for the 'wprss_ftp_shorten_url' filter; this is why the
	 * 2nd parameter is necessary.
	 *
	 * Makes a post request to the Google URL Shortener API service.
	 * The URL of the request can be set by defining the
	 * 'WPRSS_URL_GOOGLE_URL_SHORTENER_API' constant.
	 * This method also uses the Google API key, which can be set globally
	 * by the 'google_api_key' Feed to Post setting.
	 *
	 * @since 2.8.6
	 * @param string $url The URL to shorten
	 * @param string $method The code of the method that was used by the shortening function.
	 * @param string $key The Google API key to use for request. Default: 'google_api_key' WPRSS FTP setting.
	 * @return string|WP_Error The shortened URL on success, or a WP_Error.
	 */
	public static function shorten_url_method_google_url_shortener_api($url, $method, $key = null) {
		if ( is_wp_error( $url ) ) {
		    return $url;
		}

		if( $method !== 'google_url_shortener_api' ) {
		    return $url;
		}

		$key = is_null($key) ? WPRSS_FTP_Settings::get_instance()->get( 'google_api_key' ) : $key;
		$serviceUrl = self::get_method_url_google_url_shortener_api();

		$response = wp_remote_post( add_query_arg('key', $key, $serviceUrl), array(
			'headers'		=> array( 'Content-Type' => 'application/json' ),
			'body'			=> json_encode( array( 'longUrl' => $url ) )
		));

		if ( is_wp_error( $response ) ) {
		    return $response;
		}

		$response = json_decode( $response['body'], true );

		if ( isset( $response['error'] ) ) {
		    $key = self::mask_string( $key );
		    $key = sprintf( '"%1$s" (%2$s chars)', $key, strlen( $key ) );
		    return new WP_Error( 'bad_request', sprintf( '"%1$s" using API key %2$s', ( isset( $response['message'] ) ? $response['message'] : 'Bad Request' ), $key ) );
		}

		return isset( $response['id'] ) ? $response['id'] : null;
	}

	/**
	 * Retrieve a shortened permalink URL for the feed item identified by $post.
	 * If the post is not a feed item, returns an empty string, unless
	 * overridden by the 'wprss_ftp_shortened_item_url' filter.
	 * The shortened URL will be cached for this item. To invalidate cache,
	 * change the item's or the item source's shortening method.
	 *
	 * Will write to log on error.
	 *
	 * @since 2.8.6
	 * @param WP_Post|int $post A post object or ID
	 * @param null|mixed $default The value to return if the post URL cannot be shortened.
	 * @return string The shortened URL of the specified item
	 */
	public static function get_shortened_item_url($post, $default = null) {
		$post = get_post($post);
		$meta = WPRSS_FTP_Meta::get_instance();

		// If no permalink, or it's empty, just return it
		if( !($long_url = trim($meta->get_meta( $post->ID, 'wprss_item_permalink', false ))) || empty($long_url) ) {
			return apply_filters('wprss_ftp_shortened_item_url', $long_url, $post, false); // The false at the end means the URL was not shortened
		}

		// If item is not attached to feed source, return original permalink too
		if ( !($item_source_id = $meta->get_meta( $post->ID, 'feed_source' )) ) {
			return apply_filters('wprss_ftp_shortened_item_url', $long_url, $post, false); // The false at the end means the URL was not shortened
		}

		$short_url = trim($meta->get_meta( $post->ID, self::META_KEY_SHORT_URL)); // The shortened URL that may already exist on the item
		$item_shortening_method = trim((string)$meta->get_meta( $post->ID, self::META_KEY_URL_SHORTENING_METHOD)); // The shortener code of the item
		$source_shortening_method = trim((string)$meta->get_meta($item_source_id, self::META_KEY_URL_SHORTENING_METHOD));  // The shortener code of the source

		// If item has been shortened using the source's method, return that
		if( $item_shortening_method === $source_shortening_method ) {
			return apply_filters('wprss_ftp_shortened_item_url', $long_url, $post, false); // The false at the end means the URL was not shortened;
		}

		// Initiates the actual shortening
		$short_url = self::shorten_url($long_url, $source_shortening_method);

		// If URL could not be shortened using services, log and return the error
		if( is_wp_error($short_url) ) {
			/* @var $short_url WP_Error */
			WPRSS_FTP_Utils::get_logger()->warning('Could not shorten post URL "{url}" using {method}. Error: {error}', [
                'url' => $long_url,
                'method' => $source_shortening_method,
                'error' => $short_url->get_error_message()
            ]);

			return $default;
		}

		// Saving new meta data
		$meta->add_meta($post->ID, self::META_KEY_SHORT_URL, $short_url);
		$meta->add_meta($post->ID, self::META_KEY_URL_SHORTENING_METHOD, $source_shortening_method);

		return apply_filters('wprss_ftp_shortened_item_url', $short_url, $post, true);
	}

	/**
	 * Structured standardised URL shortening method, which can shorten any URL using the specified method.
	 * Will apply the registered validation algorithms registered for the
	 * specified method, validating it in the process agains registered methods.
	 * Empty string method is reserved to signify no shortening.
	 *
	 * @see get_url_shortening_methods()
	 * @since 2.8.6
	 * @param string $url The URL to shorten
	 * @param string $method The code of the method to use. Will be validated.
	 * @return string|\WP_Error The shortened URL on success, or a WP_Error on error.
	 */
	public static function shorten_url($url, $method) {
		// Perhaps the previous filter returned an error
		if( is_wp_error($url) ) {
			return $url;
		}

		// No shortening, return as is
		if( empty($method) ) {
			return $url;
		}

		// Shortening method does not exist, return as is
		if ( !array_key_exists($method, self::get_url_shortening_methods()) ) {
			return new WP_Error('no_such_shortening_method', sprintf('Could not shorten URL "%1$s": method "%1$s" does not exist', $url, $method));
		}

		return apply_filters('wprss_ftp_shorten_url', $url, $method);
	}

	/**
	 * Masks the specified string by replacing all but the indicated characters
	 * with another character, typically an asterisk.
	 *
	 * @since 2.8.6
	 * @param string $string The string to mask
	 * @param int $showChars How many characters to show. Negative values represent the amount of characters from the right.
	 * @param string $maskChar The character to use instead of actual characters
	 * @return string The masked string
	 */
	public static function mask_string($string, $showChars = -5, $maskChar = '*') {
		if( function_exists('wprss_mask_string') ) {
			return wprss_mask_string($string, $showChars, $maskChar);
		}

		$first = $showChars > 0 ? 1 : -1; // Multiplier that is used to determine whether to show chars at the beginning or end
		$charCount = strlen($string); // Total length of subject string
		$showChars = abs($showChars); // Absolute amount of chars to show
		$offset = $first < 0
			? ($charCount <= $showChars ? $charCount : $showChars) // The offset cannot exceed the total length of subject. Duh!
			: 0; // If showing characters in the beginning, no offset is required
		$string = substr($string, $offset * $first, $showChars); // Saving the characters we want to show

		$repeatTimes = $charCount-($showChars > $charCount ? $charCount : $showChars); // How many characters to mask  (all others). Cannot be negative.
		$string = sprintf($first > 0 ? '%1$s%2$s' : '%2$s%1$s', $string, str_repeat($maskChar, $repeatTimes)); // Repeat the masking characters, and add the revealed ones at the end

		return $string;
	}
}

WPRSS_FTP_Url_Shortener::init();

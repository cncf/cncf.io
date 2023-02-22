<?php
/**
 * Class CtfFeed
 *
 * Creates the settings for the feed and outputs the html
 */

namespace TwitterFeed;
use TwitterFeed\Pro\CTF_Settings_Pro;
use TwitterFeed\Pro\CTF_Parse_Pro;
use TwitterFeed\Builder\CTF_Feed_Builder;

// Don't load directly
if (!defined('ABSPATH')) {
    die('-1');
}

class CtfFeed {
    /**
     * @var array
     */
    public $errors = array();

    /**
     * @var array
     */
    protected $atts;

    public $raw_shortcode_atts;

    /**
     * @var string
     */
    protected $last_id_data;

    public $num_needed_input;

    /**
     * @var mixed|void
     */
    protected $db_options;

    /**
     * @var array
     */
    public $feed_options = array();

    /**
     * @var mixed|void
     */
    public $missing_credentials;

    /**
     * @var string
     */
    public $transient_name;

    /**
     * @var bool
     */
    protected $transient_data = false;

    /**
     * @var int
     */
    protected $num_tweets_needed;

    /**
     * @var array
     */
    public $tweet_set;

    /**
     * @var object
     */
    public $api_obj;

    /**
     * @var string
     */
    public $feed_html;

    /**
     * @var string
     */
    public $feed_id;

    /**
     * @var CtfCache
     */
    public $cache;

    /**
     * @var boolean
     */
    public $is_legacy;


    /**
     * retrieves and sets options that apply to the feed
     *
     * @param array $atts           data from the shortcode
     * @param string $last_id_data  the last visible tweet on the feed, empty string if first set
     * @param int $num_needed_input this number represents the number left to retrieve after the first set
     */
    public function __construct($atts, $last_id_data, $num_needed_input, $preview_settings = false) {
        $this->atts = CTF_Settings_Pro::filter_atts_for_legacy($atts);
        $this->raw_shortcode_atts = CTF_Settings_Pro::filter_atts_for_legacy($atts);

        $this->last_id_data = $last_id_data;
        $this->num_needed_input = $num_needed_input;
        $this->db_options = get_option('ctf_options', array());

        if ( ! empty( $atts['feed'] ) && $atts['feed'] !== 'legacy' ) {
            $this->feed_id = $this->atts['feed'];
            $this->feed_options = CTF_Settings_Pro::get_settings_by_feed_id( $atts['feed'], $preview_settings );
            if($this->feed_options == false){
                $this->feed_options['feederror'] = true;
            }else{
                $this->feed_options['feed'] = $this->feed_id;
                $this->atts = $this->feed_options;
                add_action( 'wp_footer', [ $this, 'get_feed_style' ] );
            }
            if(self::get_legacy_feed_settings()){
                $this->is_legacy = true;
            }

        }else{
            $ctf_statuses = get_option( 'ctf_statuses', array() );
            if ( ! empty( $ctf_statuses['support_legacy_shortcode'] ) ) {
                $legacy_settings_option = self::get_legacy_feed_settings();
                if ( empty( $legacy_settings_option ) ) {
                    $this->feed_options = CTF_Settings_Pro::legacy_shortcode_atts( $this->atts, $this->db_options );
                } else {
                    $this->feed_options = wp_parse_args( $this->atts, $legacy_settings_option );
                }
                $this->atts = wp_parse_args( $this->atts, \TwitterFeed\Builder\CTF_Feed_Saver::settings_defaults() );

                add_action( 'wp_footer', [ $this, 'get_feed_style' ] );
            }
            $this->is_legacy = true;
        }

        if ( ! empty( $this->feed_options ) ) {
            $this->feed_options['customizer'] = isset($atts['customizer']) && $atts['customizer'] == true ? true : false;
        }
        if ( ! empty( $atts['feed'] ) ) {
          $this->feed_options['feed'] = $atts['feed'];
      }
  }

    /**
     * creates and returns all of the data needed to generate the output for the feed
     *
     * @param array $atts           data from the shortcode
     * @param string $last_id_data  the last visible tweet on the feed, empty string if first set
     * @param int $num_needed_input this number represents the number left to retrieve after the first set
     * @return CtfFeed              the complete object for the feed
     */
    public static function init($atts, $last_id_data = '', $num_needed_input = 0, $ids_to_remove = array()) {
        $feed = new CtfFeed($atts, $last_id_data, $num_needed_input);
        $feed->setFeedOptions();
        $feed->setTweetSet();
        return $feed;
    }

    /**
     * creates all of the feed options with shortcode settings having the highest priority
     */
    public function setFeedOptions() {
        $this->feed_options['num'] = isset($this->feed_options['num']) && !empty($this->feed_options['num']) ? $this->feed_options['num'] : 1;
        $this->setFeedTypeAndTermOptions();

        $this->setAccessTokenAndSecretOptions();
        $this->setConsumerKeyAndSecretOptions();

        $db_only = array(
            'request_method'
        );
        $this->setDatabaseOnlyOptions($db_only);


        //$this->setDimensionOptions();
        $this->setCacheTimeOptions();
        $this->setIncludeExcludeOptions();
    }

    /**
     * uses the feed options to set the the tweets in the feed by using
     * an existing set in a cache or by retrieving them from Twitter
     */
	protected function setTweetSet() {
		$this->setTransientName();
		if ( ! empty( $this->feed_options['feed'] ) ) {
			$feed_id = $this->feed_options['feed'];
		} else {
			$feed_id = 'legacy';
		}
		if ( ! empty( $this->last_id_data ) ) {
			$page = $this->last_id_data;
		} else {
			$page = '';
		}
		if ( empty( $this->feed_options['feed_term'] ) ) {
			$this->feed_options['feed_term'] = '';
		}
		$this->cache = new CtfCache( $feed_id, $this->feed_options['cache_time'], $page );

		$success = $this->maybeSetTweetsFromCache();

		if (!$success) {
			$this->maybeSetTweetsFromTwitter();
		}

		$this->num_tweets_needed = $this->numTweetsNeeded();
	}

    /**
     * the access token and secret must be set in order for the feed to work
     * this function processes the user input and sets a flag if none are entered
     */
    public function setAccessTokenAndSecretOptions() {
        $this->feed_options['access_token'] = isset($this->db_options['access_token']) && strlen($this->db_options['access_token']) > 30 ? $this->db_options['access_token'] : 'missing';
        $this->feed_options['access_token_secret'] = isset($this->db_options['access_token_secret']) && strlen($this->db_options['access_token_secret']) > 30 ? $this->db_options['access_token_secret'] : 'missing';

        // verify that access token and secret have been entered
        $this->setMissingCredentials();
    }

    /**
     * generates the flag if there are missing access tokens
     */
    public function setMissingCredentials() {
        if ($this->feed_options['access_token'] == 'missing' || $this->feed_options['access_token_secret'] == 'missing') {
            $this->missing_credentials = true;
        }
        else {
            $this->missing_credentials = false;
        }
    }

    /**
     * processes the consumer key and secret options
     */
    protected function setConsumerKeyAndSecretOptions() {
	    if (! empty( $this->db_options['consumer_key'] ) && ! empty($this->db_options['consumer_secret'] )) {
		    $this->feed_options['consumer_key']    = isset($this->db_options['consumer_key']) && strlen($this->db_options['consumer_key']) > 15 ? $this->db_options['consumer_key'] : 'FPYSYWIdyUIQ76Yz5hdYo5r7y';
		    $this->feed_options['consumer_secret'] = isset($this->db_options['consumer_secret']) && strlen($this->db_options['consumer_secret']) > 30 ? $this->db_options['consumer_secret'] : 'GqPj9BPgJXjRKIGXCULJljocGPC62wN2eeMSnmZpVelWreFk9z';
	    } else {
		    $this->feed_options['consumer_key']    = 'FPYSYWIdyUIQ76Yz5hdYo5r7y';
		    $this->feed_options['consumer_secret'] = 'GqPj9BPgJXjRKIGXCULJljocGPC62wN2eeMSnmZpVelWreFk9z';
	    }
    }

    /**
     * determines what value to use and saves it for the appropriate key in the feed_options array
     *
     * @param $options mixed        the key or array of keys to be set
     * @param $options_page string  options page this setting is set on
     * @param string $default       default value to use if there is no user input
     */
    public function setDatabaseOnlyOptions($options, $default = '') {
        if (is_array($options)) {
            foreach ($options as $option) {
                $this->feed_options[$option] = isset($this->db_options[$option]) && !empty($this->db_options[$option]) ? $this->db_options[$option] : $default;
            }
        }
        else {
            $this->feed_options[$options] = isset($this->db_options[$options]) && !empty($this->db_options[$options]) ? $this->db_options[$options] : $default;
        }
    }

    /**
     * determines what value to use and saves it for the appropriate key in the feed_options array
     *
     * @param $options mixed        the key or array of keys to be set
     * @param $options_page string  options page this setting is set on
     * @param string $default       default value to use if there is no user input
     */
    public function setStandardTextOptions($options, $default = '') {
        if (is_array($options)) {
            foreach ($options as $option) {
                $this->feed_options[$option] = isset($this->atts[$option]) ? esc_attr($this->atts[$option]) : (isset($this->db_options[$option]) ? esc_attr($this->db_options[$option]) : $default);
            }
        }
        else {
            $this->feed_options[$options] = isset($this->atts[$options]) ? esc_attr($this->atts[$options]) : (isset($this->db_options[$options]) ? esc_attr($this->db_options[$options]) : $default);
        }
    }

    /**
     * creates the appropriate style attribute string for the text size setting
     *
     * @param $value mixed  pixel size or other that the user has selected
     * @return string       string for the style attribute
     */
    public static function processTextSizeStyle($value) {
        if ($value == '') {
            return '';
        }
        $processed_value = $value == 'inherit' ? '' : 'font-size: ' . $value . 'px;';

        return $processed_value;
    }

    /**
     * determines what value to use and saves it for the appropriate key in the feed_options array
     *
     * @param $options mixed        the key or array of keys to be set
     * @param string $default       default value to use if there is no user input
     */
    public function setTextSizeOptions($options, $default = '') {
        if (is_array($options)) {
            foreach ($options as $option) {
                $this->feed_options[$option] = isset($this->atts[$option]) ? $this->processTextSizeStyle(esc_attr($this->atts[$option])) : (isset($this->db_options[$option]) ? $this->processTextSizeStyle(esc_attr($this->db_options[$option])) : $default);
            }
        }
        else {
            $this->feed_options[$options] = isset($this->atts[$options]) ? $this->processTextSizeStyle(esc_attr($this->atts[$options])) : (isset($this->db_options[$options]) ? $this->processTextSizeStyle(esc_attr($this->db_options[$options])) : $default);
        }
    }

    /**
     * determines what value to use and saves it for the appropriate key in the feed_options array
     *
     * @param $options mixed    the key or array of keys to be set
     * @param $property string  name of the property to be set
     * @param string $default   default value to use if there is no user input
     */
    public function setStandardStyleProperty($options, $property, $default = '') {
        if (is_array($options)) {
            foreach ($options as $option) {
                $this->feed_options[$option] = isset($this->atts[$option]) && $this->atts[$option] != 'inherit' ? $property . ': ' . esc_attr($this->atts[$option]) . ';' : (isset($this->db_options[$option]) && $this->db_options[$option] != '#' && $this->db_options[$option] != '' && $this->db_options[$option] != 'inherit' ? $property . ': ' . esc_attr($this->db_options[$option]) . ';' : $default);
            }
        }
        else {
            $this->feed_options[$options] = isset($this->atts[$options]) && $this->atts[$options] != 'inherit' ? $property . ': ' . esc_attr($this->atts[$options]) . ';' : (isset($this->db_options[$options]) && $this->db_options[$options] != '#' && $this->db_options[$options] != '' && $this->db_options[$options] != 'inherit' ? $property . ': ' . esc_attr($this->db_options[$options]) . ';' : $default);
        }
    }

    /**
     * determines what value to use and saves it for the appropriate key in the feed_options array
     *
     * @param $options mixed        the key or array of keys to be set
     * @param bool|true $default    default value to use if there is no user input
     */
    public function setStandardBoolOptions($options, $default) {
        if (is_array($options)) {
            foreach ($options as $option) {
                $this->feed_options[$option] = isset($this->atts[$option]) ? ($this->atts[$option] === 'true') : (isset($this->db_options[$option]) ? $this->db_options[$option] : $default);
            }
        }
        else {
            $this->feed_options[$options] = isset($this->atts[$options]) ? ($this->atts[$options] === 'true') : (isset($this->db_options[$options]) ? esc_attr($this->db_options[$options]) : $default);
        }
    }

    /**
     * sets the width and height of the feed based on user input
     */
    public function setDimensionOptions() {
        $this->feed_options['width'] = isset($this->atts['width']) ? 'width: ' . esc_attr($this->atts['width']) . ';' : ((isset($this->db_options['width']) && $this->db_options['width'] != '') ? 'width: ' . esc_attr($this->db_options['width']) . (isset($this->db_options['width_unit']) ? esc_attr($this->db_options['width_unit']) : '%') . ';' : '');
        $this->feed_options['height'] = isset($this->atts['height']) ? 'height: ' . esc_attr($this->atts['height']) . ';' : ((isset($this->db_options['height']) && $this->db_options['height'] != '') ? 'height: ' . esc_attr($this->db_options['height']) . (isset($this->db_options['height_unit']) ? esc_attr($this->db_options['height_unit']) : 'px') . ';' : '');
    }

    /**
     * sets the cache time based on user input
     */
    public function setCacheTimeOptions() {
		if ( ! empty( $this->raw_shortcode_atts ) && ! empty( $this->raw_shortcode_atts['doingcronupdate'] ) ) {
			$this->feed_options['cache_time'] = 60;
			return;
		}
	    $user_cache = isset($this->db_options['cache_time']) ? ((int)$this->db_options['cache_time'] * (int)$this->db_options['cache_time_unit']) : HOUR_IN_SECONDS;
		$caching_type = ! empty( $this->db_options['ctf_caching_type'] ) ? $this->db_options['ctf_caching_type'] : 'page';
		if ( empty( $this->raw_shortcode_atts['feed'] ) || $caching_type === 'page' ) {
			$this->feed_options['cache_time'] = max($user_cache, 60);
		} else {
			$this->feed_options['cache_time'] = DAY_IN_SECONDS + HOUR_IN_SECONDS;
		}
    }

    /**
     * sets the number of tweets to retrieve
     */
    public function setTweetsToRetrieve() {
        $min_tweets_to_retrieve = 10;

        if ($this->num_needed_input < 1) {

            if ($this->feed_options['num'] < 10) {
                $count = max(round((int)$this->feed_options['num'] * (float)$this->feed_options['multiplier'] * 1.6) , $min_tweets_to_retrieve);
            }
            elseif ($this->feed_options['num'] < 30) {
                $count = round((int)$this->feed_options['num'] * (float)$this->feed_options['multiplier'] * 1.2);
            }
            else {
                $count = round((int)$this->feed_options['num'] * (float)$this->feed_options['multiplier']);
            }
        }
        else {
            $count = max($this->num_needed_input, 50);
            $this->feed_options['num'] = $this->num_needed_input;
        }

        $this->feed_options['count'] = min($count, 200);

    }

    /**
     * sets the feed type and associated parameter
     */
    public function setFeedTypeAndTermOptions() {
        $this->feed_options['type'] = '';
        $this->feed_options['feed_term'] = '';
        $this->feed_options['screenname'] = isset($this->feed_options['usertimeline_text']) ? $this->feed_options['usertimeline_text'] : '';

        if (isset($this->feed_options['home']) && $this->feed_options['home'] == 'true') {
            $this->feed_options['type'] = 'hometimeline';
        }
        if (isset($this->feed_options['screenname'])) {
            $this->feed_options['type'] = 'usertimeline';
            $this->feed_options['feed_term'] = isset($this->feed_options['screenname']) ? ctf_validate_usertimeline_text($this->feed_options['screenname']) : ((isset($this->db_options['usertimeline_text'])) ? $this->db_options['usertimeline_text'] : '');
            $this->feed_options['screenname'] = $this->feed_options['feed_term'];
        }
        if (isset($this->feed_options['search']) || isset($this->feed_options['hashtag'])) {
            $this->feed_options['type'] = 'search';
            $this->working_term = isset($this->feed_options['hashtag']) ? $this->feed_options['hashtag'] : (isset($this->feed_options['search']) ? $this->feed_options['search'] : '');
            $this->feed_options['feed_term'] = isset($this->working_term) ? ctf_validate_search_text($this->working_term) : ((isset($this->db_options['search_text'])) ? $this->db_options['search_text'] : '');
        }

        if ($this->feed_options['type'] == '') {
            $this->feed_options['type'] = isset($this->db_options['type']) ? $this->db_options['type'] : 'usertimeline';
            switch ($this->feed_options['type']) {
                case 'usertimeline':
                $this->feed_options['feed_term'] = isset($this->db_options['usertimeline_text']) ? $this->db_options['usertimeline_text'] : '';
                break;
                case 'hometimeline':
                $this->feed_options['type'] = 'hometimeline';
                break;
                case 'search':
                $this->feed_options['feed_term'] = isset($this->db_options['search_text']) ? $this->db_options['search_text'] : '';
                break;
            }
        }
    }

    /**
     * sets the visible parts of each tweet for the feed
     */
    public function setIncludeExcludeOptions() {
        $this->feed_options['tweet_includes'] = array();
        $this->feed_options['tweet_excludes'] = array();
        $this->feed_options['tweet_includes'] = isset($this->atts['include']) ? explode(',', str_replace(', ', ',', esc_attr($this->atts['include']))) : '';
        if ($this->feed_options['tweet_includes'] == '') {
            $this->feed_options['tweet_excludes'] = isset($this->atts['exclude']) ? explode(',', str_replace(', ', ',', esc_attr($this->atts['exclude']))) : '';
        }
        if ($this->feed_options['tweet_excludes'] == '') {
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_retweeter']) && $this->feed_options['include_retweeter'] == false ? null : 'retweeter';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_avatar']) && $this->feed_options['include_avatar'] == false ? null : 'avatar';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_author']) && $this->feed_options['include_author'] == false ? null : 'author';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_author_text']) && $this->feed_options['include_author_text'] == false ? null : 'author_text';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_text']) && $this->feed_options['include_text'] == false ? null : 'text';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_date']) && $this->feed_options['include_date'] == false ? null : 'date';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_actions']) && $this->feed_options['include_actions'] == false ? null : 'actions';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_twitterlink']) && $this->feed_options['include_twitterlink'] == false ? null : 'twitterlink';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_linkbox']) && $this->feed_options['include_linkbox'] == false ? null : 'linkbox';
        }
    }

    /**
     * sets the transient name for the caching system
     */
    public function setTransientName() {
        $last_id_data = $this->last_id_data;
        $num = isset($this->feed_options['num']) ? $this->feed_options['num'] : '';
        $feedID = (!empty($this->atts['feedid'])) ? $this->atts['feedid'] . '_' : '';

        switch ($this->feed_options['type']) {
            case 'hometimeline':
            $this->transient_name = 'ctf_' . $feedID . $last_id_data . 'hometimeline' . $num;
            break;
            case 'usertimeline':
            $screenname = isset($this->feed_options['feed_term']) ? $this->feed_options['feed_term'] : '';
            $this->transient_name = substr('ctf__' . $feedID . $last_id_data . $screenname . $num, 0, 45);
            break;
            case 'search':
            $hashtag = isset($this->feed_options['feed_term']) ? $this->feed_options['feed_term'] : '';
            $this->transient_name = substr('ctf_' . $feedID . $last_id_data . $hashtag . $num, 0, 45);
            break;
        }
    }

    /**
     * checks the data available in the cache to make sure it seems to be valid
     *
     * @return bool|string  false if the cache is valid, error otherwise
     */
    protected function validateCache() {
     if (isset($this->transient_data[0]) || isset($this->transient_data['errors']) ) {
        return false;
    }
    else {
        return 'invalid cache';
    }
}

    /**
     * will use the cached data in the feed if data seems to be valid and user
     * wants to use caching
     *
     * @return bool|mixed   false if none is set, tweet set otherwise
     */
    public function maybeSetTweetsFromCache() {
        $this->transient_data = $this->cache->get_transient( $this->transient_name );
        if ($this->feed_options['cache_time'] <= 0) {
            return $this->tweet_set = false;
        }
        // validate the transient data
        if ($this->transient_data) {
	        if ( is_array( $this->transient_data ) && ! empty( $this->transient_data[0] ) && $this->transient_data[0] === 'error' ) {
		        $this->tweet_set = array();
		        return true;
	        }
            $this->errors['cache_status'] = $this->validateCache();
            if ($this->errors['cache_status'] === false) {
                return $this->tweet_set = $this->transient_data;
            }
            else {
                return $this->tweet_set = false;
            }
        }
        else {
            $this->errors['cache_status'] = 'none found';
            return $this->tweet_set = false;
        }
    }

    /**
     *  will attempt to connect to the api to retrieve current tweets
     */
    public function maybeSetTweetsFromTwitter() {
        $this->setTweetsToRetrieve();
        $this->api_obj = $this->apiConnect($this->feed_options['type'], $this->feed_options['feed_term']);
        $this->tweet_set = json_decode($this
            ->api_obj->json, $assoc = true);

        // check for errors/tweets present
        if (isset($this->tweet_set['errors'][0])) {
            if (empty($this->api_obj)) {
                $this->api_obj = new \stdClass();
            }
            $this
            ->api_obj->api_error_no = $this->tweet_set['errors'][0]['code'];
            $this
            ->api_obj->api_error_message = $this->tweet_set['errors'][0]['message'];

            $this->tweet_set = false;
        }

        $tweets = isset($this->tweet_set['statuses']) ? $this->tweet_set['statuses'] : $this->tweet_set;

        if (empty($tweets)) {
            $this->errors['error_message'] = 'No Tweets returned';
            $this->tweet_set = false;
        }
    }

    /**
     * calculates how many tweets short the feed is so more can be retrieved via ajax
     *
     * @return int number of tweets needed
     */
    protected function numTweetsNeeded() {
        if (isset($this->tweet_set['statuses']) && is_array($this->tweet_set['statuses'])) {
            $tweet_count = count($this->tweet_set['statuses']);
        }
        elseif (is_array($this->tweet_set)) {
            $tweet_count = count($this->tweet_set);
        }
        else {
            $tweet_count = 0;
        }

        return $this->feed_options['num'] - $tweet_count;
    }

    /**
     * trims the unused data retrieved for more efficient caching
     */
    protected function trimTweetData($limit = true) {
        $is_pagination = !empty($this->last_id_data) ? 1 : 0;
        $tweets = isset($this->tweet_set['statuses']) ? $this->tweet_set['statuses'] : $this->tweet_set;
        if (isset($this->tweet_set['statuses']) && is_array($this->tweet_set['statuses'])) {
            $tweet_count = count($this->tweet_set['statuses']);
        }
        elseif (is_array($this->tweet_set)) {
            $tweet_count = count($this->tweet_set);
        }
        else {
            $tweet_count = 0;
        }
        if ($limit) {
            $len = (int)min($this->feed_options['num'] + $is_pagination, $tweet_count);
        }
        else {
            $len = count($tweets);
        }
        $trimmed_tweets = array();

        // for header
        if ($this->last_id_data == '') { // if this is the first set of tweets
            $trimmed_tweets[0]['user']['name'] = $tweets[0]['user']['name'];
            $trimmed_tweets[0]['user']['description'] = $tweets[0]['user']['description'];
            $trimmed_tweets[0]['user']['statuses_count'] = $tweets[0]['user']['statuses_count'];
            $trimmed_tweets[0]['user']['followers_count'] = $tweets[0]['user']['followers_count'];
        }

        for ($i = 0;$i < $len;$i++) {
            $trimmed_tweets[$i]['user']['name'] = $tweets[$i]['user']['name'];
            $trimmed_tweets[$i]['user']['screen_name'] = $tweets[$i]['user']['screen_name'];
            $trimmed_tweets[$i]['user']['verified'] = $tweets[$i]['user']['verified'];
            $trimmed_tweets[$i]['user']['profile_image_url_https'] = $tweets[$i]['user']['profile_image_url_https'];
            $trimmed_tweets[$i]['user']['utc_offset'] = $tweets[$i]['user']['utc_offset'];
            $trimmed_tweets[$i]['text'] = isset($tweets[$i]['text']) ? $tweets[$i]['text'] : $tweets[$i]['full_text'];
            $trimmed_tweets[$i]['id_str'] = $tweets[$i]['id_str'];
            $trimmed_tweets[$i]['created_at'] = $tweets[$i]['created_at'];
            $trimmed_tweets[$i]['retweet_count'] = $tweets[$i]['retweet_count'];
            $trimmed_tweets[$i]['favorite_count'] = $tweets[$i]['favorite_count'];

            if (isset($tweets[$i]['entities']['urls'][0])) {
                foreach ($tweets[$i]['entities']['urls'] as $url) {
                    $trimmed_tweets[$i]['entities']['urls'][] = array(
                        'url' => $url['url'],
                        'expanded_url' => $url['expanded_url'],
                        'display_url' => $url['display_url'],

                    );
                }
            }

            if (isset($tweets[$i]['retweeted_status'])) {
                $trimmed_tweets[$i]['retweeted_status']['user']['name'] = $tweets[$i]['retweeted_status']['user']['name'];
                $trimmed_tweets[$i]['retweeted_status']['user']['screen_name'] = $tweets[$i]['retweeted_status']['user']['screen_name'];
                $trimmed_tweets[$i]['retweeted_status']['user']['verified'] = $tweets[$i]['retweeted_status']['user']['verified'];
                $trimmed_tweets[$i]['retweeted_status']['user']['profile_image_url_https'] = $tweets[$i]['retweeted_status']['user']['profile_image_url_https'];
                $trimmed_tweets[$i]['retweeted_status']['user']['utc_offset'] = $tweets[$i]['retweeted_status']['user']['utc_offset'];
                $trimmed_tweets[$i]['retweeted_status']['text'] = isset($tweets[$i]['retweeted_status']['text']) ? $tweets[$i]['retweeted_status']['text'] : $tweets[$i]['retweeted_status']['full_text'];
                $trimmed_tweets[$i]['retweeted_status']['id_str'] = $tweets[$i]['retweeted_status']['id_str'];
                $trimmed_tweets[$i]['retweeted_status']['created_at'] = $tweets[$i]['retweeted_status']['created_at'];
                $trimmed_tweets[$i]['retweeted_status']['retweet_count'] = $tweets[$i]['retweeted_status']['retweet_count'];
                $trimmed_tweets[$i]['retweeted_status']['favorite_count'] = $tweets[$i]['retweeted_status']['favorite_count'];
                if (isset($tweets[$i]['retweeted_status']['entities']['urls'][0])) {
                    foreach ($tweets[$i]['retweeted_status']['entities']['urls'] as $url) {
                        $trimmed_tweets[$i]['retweeted_status']['entities']['urls'][] = array(
                            'url' => $url['url'],
                            'expanded_url' => $url['expanded_url'],
                            'display_url' => $url['display_url'],

                        );
                    }
                }

                if (isset($tweets[$i]['retweeted_status']['quoted_status'])) {
                    $trimmed_tweets[$i]['retweeted_status']['quoted_status']['user']['name'] = $tweets[$i]['retweeted_status']['quoted_status']['user']['name'];
                    $trimmed_tweets[$i]['retweeted_status']['quoted_status']['user']['screen_name'] = $tweets[$i]['retweeted_status']['quoted_status']['user']['screen_name'];
                    $trimmed_tweets[$i]['retweeted_status']['quoted_status']['user']['verified'] = $tweets[$i]['retweeted_status']['quoted_status']['user']['verified'];
                    $trimmed_tweets[$i]['retweeted_status']['quoted_status']['text'] = isset($tweets[$i]['retweeted_status']['quoted_status']['text']) ? $tweets[$i]['retweeted_status']['quoted_status']['text'] : $tweets[$i]['retweeted_status']['quoted_status']['full_text'];
                    $trimmed_tweets[$i]['retweeted_status']['quoted_status']['id_str'] = $tweets[$i]['retweeted_status']['quoted_status']['id_str'];
                    if (isset($tweets[$i]['retweeted_status']['quoted_status']['entities']['urls'][0])) {
                        foreach ($tweets[$i]['retweeted_status']['quoted_status']['entities']['urls'] as $url) {
                            $trimmed_tweets[$i]['retweeted_status']['quoted_status']['entities']['urls'][] = array(
                                'url' => $url['url'],
                                'expanded_url' => $url['expanded_url'],
                                'display_url' => $url['display_url'],
                            );
                        }
                    }
                }
            }

            if (isset($tweets[$i]['quoted_status'])) {
                $trimmed_tweets[$i]['quoted_status']['user']['name'] = $tweets[$i]['quoted_status']['user']['name'];
                $trimmed_tweets[$i]['quoted_status']['user']['screen_name'] = $tweets[$i]['quoted_status']['user']['screen_name'];
                $trimmed_tweets[$i]['quoted_status']['user']['verified'] = $tweets[$i]['quoted_status']['user']['verified'];
                $trimmed_tweets[$i]['quoted_status']['text'] = isset($tweets[$i]['quoted_status']['text']) ? $tweets[$i]['quoted_status']['text'] : $tweets[$i]['quoted_status']['full_text'];
                $trimmed_tweets[$i]['quoted_status']['id_str'] = $tweets[$i]['quoted_status']['id_str'];
                if (isset($tweets[$i]['quoted_status']['entities']['urls'][0])) {
                    foreach ($tweets[$i]['quoted_status']['entities']['urls'] as $url) {
                        $trimmed_tweets[$i]['quoted_status']['entities']['urls'][] = array(
                            'url' => $url['url'],
                            'expanded_url' => $url['expanded_url'],
                            'display_url' => $url['display_url'],
                        );
                    }
                }
            }

            $trimmed_tweets[$i] = $this->filterTrimmedTweets($trimmed_tweets[$i], $tweets[$i]);
        }

        $this->tweet_set = $trimmed_tweets;
    }

    /**
     * method to be overridden by pro
     *
     * @param $trimmed current trimmed tweet araray
     * @param $tweet current tweet data to be trimmed
     * @return mixed final trimmed tweet
     */
    protected function filterTrimmedTweets($trimmed, $tweet) {
        return $trimmed;
    }

    /**
     * will create a transient with the tweet cache if one doesn't exist, the data seems valid, and caching is active
     */
    public function maybeCacheTweets( $error = false ) {
	    if ( $error ) {
		    $cache = json_encode(array('error'));
		    $this->cache->set_transient($this->transient_name, $cache, $this->feed_options['cache_time']);
	    } else {
		    if ((!$this->transient_data || $this->errors['cache_status']) && $this->feed_options['cache_time'] > 0) {
			    $cache = json_encode($this->tweet_set);
			    $this->cache->set_transient($this->transient_name, $cache, $this->feed_options['cache_time']);
		    }
	    }

    }

    /**
     * returns a JSON string to be used in the data attribute that contains the shortcode data
     */
    public function getShortCodeJSON() {
        return htmlentities(json_encode($this->raw_shortcode_atts));
    }

    /**
     * uses the endpoint to determing what get fields need to be set
     *
     * @param $end_point api endpoint needed
     * @param $feed_term term associated with the endpoint, user name or search term
     * @return array the get fields for the request
     */
    public function setGetFieldsArray($end_point, $feed_term) {
        $get_fields = array();

        if ($end_point === 'usertimeline') {
            if (!empty($feed_term)) {
                $get_fields['screen_name'] = $feed_term;
            }
            if (!$this->feed_options['selfreplies']) {
                $get_fields['exclude_replies'] = 'true';
            }
        }
        if ($end_point === 'hometimeline') {
            $get_fields['exclude_replies'] = 'true';
        }
        if ($end_point === 'search') {
            $get_fields['q'] = $feed_term;
        }

        return $get_fields;
    }

    /**
     * attempts to connect and retrieve tweets from the Twitter api
     *
     * @return mixed|string object containing the response
     */
    public function apiConnect($end_point, $feed_term) {
        // Only can be set in the options page
        $request_settings = array(
            'consumer_key' => $this->feed_options['consumer_key'],
            'consumer_secret' => $this->feed_options['consumer_secret'],
            'access_token' => $this->feed_options['access_token'],
            'access_token_secret' => $this->feed_options['access_token_secret'],
        );

        // For pagination, an extra post needs to be retrieved since the last post is
        // included in the next set
        $count = $this->feed_options['count'];

        $get_fields = $this->setGetFieldsArray($end_point, $feed_term);

        // if the last id is present, that means this is not the first set of tweets
        // retrieve only tweets made after the last tweet using it's id
        if (!empty($this->last_id_data)) {
            $count++;
            $max_id = $this->last_id_data;
        }
        $get_fields['count'] = $count;

        // max_id parameter should only be included for the second set of posts
        if (isset($max_id)) {
            $get_fields['max_id'] = $max_id;
        }

        // actual connection
        $twitter_connect = new TwitterFeed\CtfOauthConnect($request_settings, $end_point);
        $twitter_connect->setUrlBase();
        $twitter_connect->setGetFields($get_fields);
        $twitter_connect->setRequestMethod($this->feed_options['request_method']);

        return $twitter_connect->performRequest();
    }

    /**
     * If the feed runs out of tweets to display for some reason,
     * this function creates a graceful failure message
     *
     * @param $feed_options
     * @return string html for "out of tweets" message
     */
    protected function getOutOfTweetsHtml($feed_options) {
        $html = '';

        $html .= '<div class="ctf-out-of-tweets">';
        $html .= '<p>' . __('That\'s all! No more Tweets to load', 'custom-twitter-feeds') . '</p>';
        $html .= '<p>';
        $html .= '<a class="twitter-share-button" href="https://twitter.com/share" target="_blank" data-size="large" data-url="<?php echo get_home_url(); ?>">' . __('Share', 'custom-twitter-feeds') . '</a>';
        if (isset($feed_options['screenname'])) {
            $html .= '<a class="twitter-follow-button" href="https://twitter.com/' . $feed_options['screenname'] . '" target="_blank" data-show-count="false" data-size="large" data-dnt="true">' . __('Follow', 'custom-twitter-feeds') . '</a>';
        }
        $html .= '</p>';
        if (!$feed_options['disableintents']) {
            $html .= "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * creates opening html for the feed
     *
     * @return string opening html that creates the feed
     */
    public function getFeedOpeningHtml() {
        $feed_options = $this->feed_options;
        $ctf_data_disablelinks = ($feed_options['disablelinks'] == 'true') ? ' data-ctfdisablelinks="true"' : '';
        $ctf_data_linktextcolor = $feed_options['linktextcolor'] != '' ? ' data-ctflinktextcolor="' . $feed_options['linktextcolor'] . '"' : '';
        $ctf_data_other = '';
        $ctf_data_other = apply_filters('ctf_data_other', $ctf_data_other);
        $ctf_attributes = $this->get_feed_attributes();
        $ctf_data_needed = $this->num_tweets_needed;
        $ctf_feed_type = !empty($feed_options['type']) ? esc_attr($feed_options['type']) : 'multiple';
        $ctf_feed_classes = 'ctf ctf-type-' . $ctf_feed_type;
        $ctf_feed_classes .= ' ' . $feed_options['class'] . ' ctf-styles';
        $ctf_feed_classes .= ' ctf-feed-' . $this->feed_id;
        $ctf_feed_classes .= ( isset( $feed_options['tweetpoststyle'] ) ) ?  ' ctf-' . $feed_options['tweetpoststyle'] . '-style' : '';

        if (!empty($feed_options['height'])) $ctf_feed_classes .= ' ctf-fixed-height';
        $ctf_feed_classes .= $feed_options['width_mobile_no_fixed'] ? ' ctf-width-resp' : '';
        $ctf_feed_classes .= apply_filters('ctf_feed_classes', $ctf_feed_classes); //add_filter( 'ctf_feed_classes', function( $ctf_feed_classes ) { return $ctf_feed_classes . ' new-class'; }, 10, 1 );
        $ctf_feed_html = '';

        $ctf_feed_html .= '<!-- Custom Twitter Feeds by Smash Balloon -->';
        $ctf_feed_html .= '<div id="ctf" class="' . $ctf_feed_classes . '" style="' . $feed_options['width'] . $feed_options['height'] . $feed_options['bgcolor'] . '" data-ctfshortcode="' . $this->getShortCodeJSON() . '"' . $ctf_data_disablelinks . $ctf_data_linktextcolor . ' data-ctfneeded="' . $ctf_data_needed . '"' . $ctf_data_other . ' ' . $ctf_attributes . '>';
        $tweet_set = $this->tweet_set;

        // dynamically include header
        if ($feed_options['showheader']) {
            $ctf_feed_html .= $this->getFeedHeaderHtml($tweet_set, $this->feed_options);
        }

        $ctf_feed_html .= '<div class="ctf-tweet-items">';

        return $ctf_feed_html;
    }

    /**
     * creates opening html for the feed
     *
     * @return string opening html that creates the feed
     */
    public function getFeedClosingHtml() {
        $feed_options = $this->feed_options;
        $options = ctf_get_database_settings();
        $ctf_feed_html = '';

        $ctf_feed_html .= '</div>'; // closing div for ctf-tweet-items
        if ($feed_options['showbutton']) {
            $ctf_feed_html .= '<a href="javascript:void(0);" id="ctf-more" class="ctf-more" style="' . $feed_options['buttoncolor'] . $feed_options['buttontextcolor'] . '"><span>' . $feed_options['buttontext'] . '</span></a>';
        }

        if ($feed_options['creditctf']) {
            $ctf_feed_html .= '<div class="ctf-credit-link"><a href="https://smashballoon.com/custom-twitter-feeds" target="_blank" rel="nofollow noopener">' . ctf_get_fa_el('fa-twitter') . 'Custom Twitter Feeds Plugin</a></div>';
        }

        $ctf_feed_html .= '</div>'; // closing div tag for #ctf
        if ($options['ajax_theme']) {
            $font_method = isset($feed_options['font_method']) ? $feed_options['font_method'] : 'svg';
            $placeholder = trailingslashit(CTF_PLUGIN_URL) . 'img/placeholder.png';

            $ctf_feed_html .= '<script>';
            $ctf_feed_html .= 'var ctfOptions = {"ajax_url":"' . admin_url('admin-ajax.php') . '","font_method":"' . esc_js($font_method) . '","placeholder":"' . esc_js($placeholder) . '"};';

            $ctf_feed_html .= '</script>';
            $ctf_feed_html .= '<script type="text/javascript" src="' . CTF_JS_URL . '"></script>';
        }

        return $ctf_feed_html;
    }

    /**
     * creates html for header of the feed
     *
     * @param $tweet_set string     trimmed tweets to be added to the feed
     * @param $feed_options         options for the feed
     * @return string html that creates the header of the feed
     */
    protected function getFeedHeaderHtml($tweet_set, $feed_options) {
        $ctf_header_html = '';
        $ctf_no_bio = $feed_options['showbio'] ? '' : ' ctf-no-bio';

        // temporary workaround for cached http images
        $tweet_set[0]['user']['profile_image_url_https'] = isset($tweet_set[0]['user']['profile_image_url_https']) ? $tweet_set[0]['user']['profile_image_url_https'] : $tweet_set[0]['user']['profile_image_url'];

        if ($feed_options['type'] === 'usertimeline') {
            $ctf_header_html .= '<div class="ctf-header' . $ctf_no_bio . '" style="' . $feed_options['headerbgcolor'] . '">';
            $ctf_header_html .= '<a href="https://twitter.com/' . $tweet_set[0]['user']['screen_name'] . '" target="_blank" rel="nofollow noopener" title="@' . $tweet_set[0]['user']['screen_name'] . '" class="ctf-header-link">';
            $ctf_header_html .= '<div class="ctf-header-text">';
            $ctf_header_html .= '<p class="ctf-header-user" style="' . $feed_options['headertextcolor'] . '">';
            $ctf_header_html .= '<span class="ctf-header-name">';

            if ($feed_options['headertext'] != '') {
                $ctf_header_html .= esc_html($feed_options['headertext']);
            }
            else {
                $ctf_header_html .= esc_html($tweet_set[0]['user']['name']);
            }

            $ctf_header_html .= '</span>';

            if ($tweet_set[0]['user']['verified'] == 1) {
                $ctf_header_html .= '<span class="ctf-verified">' . ctf_get_fa_el('fa-check-circle') . '</span>';
            }

            $ctf_header_html .= '<span class="ctf-header-follow">' . ctf_get_fa_el('fa-twitter') . 'Follow</span>';
            $ctf_header_html .= '</p>';

            if ($feed_options['showbio']) {
                $ctf_header_html .= '<p class="ctf-header-bio" style="' . $feed_options['headertextcolor'] . '">' . $tweet_set[0]['user']['description'] . '</p>';
            }

            $ctf_header_html .= '</div>';
            $ctf_header_html .= '<div class="ctf-header-img">';
            $ctf_header_html .= '<div class="ctf-header-img-hover">' . ctf_get_fa_el('fa-twitter') . '</div>';
            $ctf_header_html .= '<img src="' . $tweet_set[0]['user']['profile_image_url_https'] . '" alt="' . $tweet_set[0]['user']['name'] . '" width="48" height="48">';
            $ctf_header_html .= '</div>';
            $ctf_header_html .= '</a>';
            $ctf_header_html .= '</div>';
        }
        else {

            if ($feed_options['type'] === 'search') {
                $default_header_text = $feed_options['headertext'] != '' ? esc_html($feed_options['headertext']) : $feed_options['feed_term'];
                $url_part = 'hashtag/' . str_replace("#", "", $feed_options['feed_term']);
            }
            else {
                $default_header_text = 'Twitter';
                $url_part = $feed_options['screenname']; //Need to get screenname here

            }

            $ctf_header_html .= '<div class="ctf-header ctf-header-type-generic" style="' . $feed_options['headerbgcolor'] . '">';
            $ctf_header_html .= '<a href="https://twitter.com/' . $url_part . '" target="_blank" rel="nofollow noopener" class="ctf-header-link">';
            $ctf_header_html .= '<div class="ctf-header-text">';
            $ctf_header_html .= '<p class="ctf-header-no-bio" style="' . $feed_options['headertextcolor'] . '">' . $default_header_text . '</p>';
            $ctf_header_html .= '</div>';
            $ctf_header_html .= '<div class="ctf-header-img">';
            $ctf_header_html .= '<div class="ctf-header-generic-icon">';
            $ctf_header_html .= ctf_get_fa_el('fa-twitter');
            $ctf_header_html .= '</div>';
            $ctf_header_html .= '</div>';
            $ctf_header_html .= '</a>';
            $ctf_header_html .= '</div>';
        }

        return $ctf_header_html;
    }

    /**
     * outputs the html for a set of tweets to be used in the feed
     *
     * @param int $is_pagination    1 or 0, used to differentiate between the first set and subsequent tweet sets
     *
     * @return string $tweet_html
     */
    public function getTweetSetHtml($is_pagination = 0) {
        $tweet_set = isset($this->tweet_set['statuses']) ? $this->tweet_set['statuses'] : $this->tweet_set;
        if (isset($this->tweet_set['statuses']) && is_array($this->tweet_set['statuses'])) {
            $tweet_count = count($this->tweet_set['statuses']);
        }
        elseif (is_array($this->tweet_set)) {
            $tweet_count = count($this->tweet_set);
        }
        else {
            $tweet_count = 0;
        }
        $len = (int)min($this->feed_options['num'] + $is_pagination, $tweet_count);
        $i = $is_pagination; // starts at index "1" to offset duplicate tweet
        $feed_options = $this->feed_options;
        $tweet_html = $this->feed_html;

        if ($is_pagination && (!isset($tweet_set[1]['id_str']))) {
            $tweet_html .= $this->getOutOfTweetsHtml($this->feed_options);
        }
        else {
            while ($i < $len) {

                // run a check to accommodate the "search" endpoint as well
                $post = $tweet_set[$i];

                // temporary workaround for cached http images
                $post['user']['profile_image_url_https'] = isset($post['user']['profile_image_url_https']) ? $post['user']['profile_image_url_https'] : $post['user']['profile_image_url'];

                // save the original tweet data in case it's a retweet
                $post_id = $post['id_str'];
                $author = strtolower($post['user']['screen_name']);

                // creates a string of classes applied to each tweet
                $tweet_classes = 'ctf-item ctf-author-' . $author . ' ctf-new';
                if (!ctf_show('avatar', $feed_options)) $tweet_classes .= ' ctf-hide-avatar';
                $tweet_classes = apply_filters('ctf_tweet_classes', $tweet_classes); // add_filter( 'ctf_tweet_classes', function( $tweet_classes ) { return $ctf_feed_classes . ' new-class'; }, 10, 1 );
                // check for retweet
                if (isset($post['retweeted_status'])) {
                    $retweeter = array(
                        'name' => $post['user']['name'],
                        'screen_name' => $post['user']['screen_name']
                    );
                    $post = $post['retweeted_status'];

                    // temporary workaround for cached http images
                    $post['user']['profile_image_url_https'] = isset($post['user']['profile_image_url_https']) ? $post['user']['profile_image_url_https'] : $post['user']['profile_image_url'];
                    $tweet_classes .= ' ctf-retweet';
                }
                else {
                    unset($retweeter);
                }

                // check for quoted
                if (isset($post['quoted_status'])) {
                    $tweet_classes .= ' ctf-quoted';
                    $quoted = $post['quoted_status'];
                }
                else {
                    unset($quoted);
                }

                // include tweet view
                $tweet_html .= '<div class="' . $tweet_classes . '" id="' . $post_id . '" style="' . $feed_options['tweetbgcolor'] . '">';

                if (isset($retweeter) && ctf_show('retweeter', $feed_options)) {
                    $tweet_html .= '<div class="ctf-context">';
                    $tweet_html .= '<a href="https://twitter.com/intent/user?screen_name=' . $retweeter['screen_name'] . '" target="_blank" rel="nofollow noopener" class="ctf-retweet-icon"><i class="fa fa-retweet"></i><span class="ctf-screenreader">Retweet on Twitter</span></a>';
                    $tweet_html .= '<a href="https://twitter.com/' . $retweeter['screen_name'] . '" target="_blank" rel="nofollow noopener" class="ctf-retweet-text" style="' . $feed_options['authortextsize'] . $feed_options['authortextweight'] . $feed_options['textcolor'] . '">' . $retweeter['name'] . ' ' . $feed_options['retweetedtext'] . '</a>';
                    $tweet_html .= '</div>';
                }

                $tweet_html .= '<div class="ctf-author-box">';
                $tweet_html .= '<div class="ctf-author-box-link" target="_blank" style="' . $feed_options['authortextsize'] . $feed_options['authortextweight'] . $feed_options['textcolor'] . '">';
                if (ctf_show('avatar', $feed_options)) {
                    $tweet_html .= '<a href="https://twitter.com/' . $post['user']['screen_name'] . '" class="ctf-author-avatar" target="_blank" rel="nofollow noopener" style="' . $feed_options['authortextsize'] . $feed_options['authortextweight'] . $feed_options['textcolor'] . '">';
                    $tweet_html .= '<img src="' . $post['user']['profile_image_url_https'] . '" width="48" height="48">';
                    $tweet_html .= '</a>';
                }

                if (ctf_show('author', $feed_options)) {
                    $tweet_html .= '<a href="https://twitter.com/' . $post['user']['screen_name'] . '" target="_blank" rel="nofollow noopener" class="ctf-author-name" style="' . $feed_options['authortextsize'] . $feed_options['authortextweight'] . $feed_options['textcolor'] . '">' . $post['user']['name'] . '</a>';
                    if ($post['user']['verified'] == 1) {
                        $tweet_html .= '<span class="ctf-verified" >' . ctf_get_fa_el('fa-check-circle') . '</span>';
                    }
                    $tweet_html .= '<a href="https://twitter.com/' . $post['user']['screen_name'] . '" class="ctf-author-screenname" target="_blank" rel="nofollow noopener" style="' . $feed_options['authortextsize'] . $feed_options['authortextweight'] . $feed_options['textcolor'] . '">@' . $post['user']['screen_name'] . '</a>';
                    $tweet_html .= '<span class="ctf-screename-sep">&middot;</span>';
                }

                if (ctf_show('date', $feed_options)) {
                    $tweet_html .= '<div class="ctf-tweet-meta">';
                    $tweet_html .= '<a href="https://twitter.com/statuses/' . $post['id_str'] . '" class="ctf-tweet-date" target="_blank" rel="nofollow noopener" style="' . $feed_options['datetextsize'] . $feed_options['datetextweight'] . $feed_options['textcolor'] . '">' . ctf_get_formatted_date($post['created_at'], $feed_options, $post['user']['utc_offset']) . '</a>';
                    $tweet_html .= '</div>';
                } // show date
                $tweet_html .= '</div>';
                if (ctf_show('logo', $feed_options)) {
                    $tweet_html .= '<div class="ctf-corner-logo" style="' . $feed_options['logosize'] . $feed_options['logocolor'] . '">';
                    $tweet_html .= ctf_get_fa_el('fa-twitter');
                    $tweet_html .= '</div>';
                }
                $tweet_html .= '</div>';

                if (ctf_show('text', $feed_options)) {
                    $tweet_html .= '<div class="ctf-tweet-content">';

                    if ($feed_options['linktexttotwitter']) {
                        $tweet_html .= '<a href="https://twitter.com/statuses/' . $post['id_str'] . '" target="_blank" rel="nofollow noopener">';
                        $tweet_html .= '<p class="ctf-tweet-text" style="' . $feed_options['tweettextsize'] . $feed_options['tweettextweight'] . $feed_options['textcolor'] . '">' . $post['text'] . '</p>';
                        $tweet_html .= '</a>';
                    }
                    else {
                        $tweet_html .= '<p class="ctf-tweet-text" style="' . $feed_options['tweettextsize'] . $feed_options['tweettextweight'] . $feed_options['textcolor'] . '">' . $post['text'] . '</p>';
                    } // link text to twitter option is selected
                    $tweet_html .= '</div>';
                } // show tweet text
                if (ctf_show('linkbox', $feed_options) && isset($quoted)) {
                    $tweet_html .= '<a href="https://twitter.com/statuses/' . $quoted['id_str'] . '" class="ctf-quoted-tweet" style="' . $feed_options['quotedauthorsize'] . $feed_options['quotedauthorweight'] . $feed_options['textcolor'] . '" target="_blank" rel="nofollow noopener">';
                    $tweet_html .= '<span class="ctf-quoted-author-name">' . $quoted['user']['name'] . '</span>';

                    if ($quoted['user']['verified'] == 1) {
                        $tweet_html .= '<span class="ctf-quoted-verified">' . ctf_get_fa_el('fa-check-circle') . '</span>';
                    } // user is verified
                    $tweet_html .= '<span class="ctf-quoted-author-screenname">@' . $quoted['user']['screen_name'] . '</span>';
                    $tweet_html .= '<p class="ctf-quoted-tweet-text" style="' . $feed_options['tweettextsize'] . $feed_options['tweettextweight'] . $feed_options['textcolor'] . '">' . $quoted['text'] . '</p>';
                    $tweet_html .= '</a>';
                } // show link box
                $tweet_html .= '<div class="ctf-tweet-actions">';
                if (ctf_show('actions', $feed_options)) {
                    $tweet_html .= '<a href="https://twitter.com/intent/tweet?in_reply_to=' . $post['id_str'] . '&related=' . $post['user']['screen_name'] . '" class="ctf-reply" target="_blank" rel="nofollow noopener" style="' . $feed_options['iconsize'] . $feed_options['iconcolor'] . '"><i class="fa fa-reply"></i><span class="ctf-screenreader">Reply on Twitter</span></a>';
                    $tweet_html .= '<a href="https://twitter.com/intent/retweet?tweet_id=' . $post['id_str'] . '&related=' . $post['user']['screen_name'] . '" class="ctf-retweet" target="_blank" rel="nofollow noopener" style="' . $feed_options['iconsize'] . $feed_options['iconcolor'] . '"><i class="fa fa-retweet"></i><span class="ctf-screenreader">Retweet on Twitter</span><span class="ctf-action-count ctf-retweet-count">';
                    if ($post['retweet_count'] > 0) {
                        $tweet_html .= $post['retweet_count'];
                    }
                    $tweet_html .= '</span></a>';
                    $tweet_html .= '<a href="https://twitter.com/intent/like?tweet_id=' . $post['id_str'] . '&related=' . $post['user']['screen_name'] . '" class="ctf-like" target="_blank" rel="nofollow noopener" style="' . $feed_options['iconsize'] . $feed_options['iconcolor'] . '"><i class="fa fa-heart"></i><span class="ctf-screenreader">Like on Twitter</span><span class="ctf-action-count ctf-favorite-count">';
                    if ($post['favorite_count'] > 0) {
                        $tweet_html .= $post['favorite_count'];
                    }
                    $tweet_html .= '</span></a>';
                }
                if (ctf_show('twitterlink', $feed_options)) {
                    $tweet_html .= '<a href="https://twitter.com/statuses/' . $post['id_str'] . '" class="ctf-twitterlink" style="' . $feed_options['textcolor'] . '" target="_blank" rel="nofollow noopener">' . $feed_options['twitterlinktext'] . '</a>';
                } // show twitter link or actions
                $tweet_html .= '</div>';
                $tweet_html .= '</div>';

                $i++;
            }
        }
        return $tweet_html;
    }

    /**
     * displays a message if there is an error in the feed
     *
     * @return string error html
     */
    public function getErrorHtml() {
        $error_html = '';
        $error_html .= '<div id="ctf" class="ctf">';
        $error_html .= '<div class="ctf-error">';
        $error_html .= '<div class="ctf-error-user">';
        $error_html .= '<p>Unable to load Tweets</p>';
        $error_html .= '<a class="twitter-share-button"';
        $error_html .= 'href="https://twitter.com/share"';
        $error_html .= 'data-size="large"';
        $error_html .= 'data-url="' . get_the_permalink() . '"';
        $error_html .= 'data-text="' . __('Check out this website', 'custom-twitter-feeds') . '">';
        $error_html .= '</a>';
        if (!empty($this->feed_options['screenname'])) {
            $error_html .= '<a class="twitter-follow-button"';
            $error_html .= 'href="https://twitter.com/' . $this->feed_options['screenname'] . '"';
            $error_html .= 'data-show-count="false"';
            $error_html .= 'data-size="large"';
            $error_html .= 'data-dnt="true">' . __('Follow', 'custom-twitter-feeds') . '</a>';
        }
        $error_html .= '</div>';
        if (current_user_can('manage_options')) {
            $error_html .= '<div class="ctf-error-admin">';
            $error_html .= '<p><b>This message is only visible to admins:</b><br />';
            $error_html .= 'An error has occurred with your feed.<br />';
            if ($this->missing_credentials) {
                $error_html .= 'There is a problem with your access token, access token secret, consumer token, or consumer secret<br />';
            }
            if (isset($this->errors['error_message'])) {
                $error_html .= $this->errors['error_message'] . '<br />';
            } elseif (isset($this->transient_data['errors'])) {
             $error_html .= 'The error response from the Twitter API is the following:<br />';
             $error_html .= '<code>Error number: ' . $this->transient_data['errors'][0]['code'] . '<br />';
             $error_html .= 'Message: ' . $this->transient_data['errors'][0]['message'] . '</code>';
             $error_html .= 'Clear the Twitter cache on the "Settings" page, "Feeds" tab to retry.<br />';

         }
         if (!empty($this
            ->api_obj
            ->api_error_no)) {
            $error_html .= 'The error response from the Twitter API is the following:<br />';
            $error_html .= '<code>Error number: ' . $this
            ->api_obj->api_error_no . '<br />';
            $error_html .= 'Message: ' . $this
            ->api_obj->api_error_message . '</code>';
        }
        $error_html .= '<a href="https://smashballoon.com/custom-twitter-feeds/docs/errors/" target="_blank" rel="nofollow noopener">Click here to troubleshoot</a></p>';
        $error_html .= '</div>';
    }
        $error_html .= '</div>'; // end .ctf-error
        $error_html .= '</div>'; // end #ctf
        return wp_kses_post( $error_html );
    }


    /**
     * Get Global Twitter Feed CSS
     *
     * @since 2.0
     * @return array
    */
    public function get_feed_style(){
        $feed_style = '';
        $feed_ctn = '.ctf-feed-' . $this->feed_id;
        $css_array = [
            //Load More Button Style
            [
                'selector' => $feed_ctn . ' .ctf-more',
                'properties' => [
                    'background-color' => [
                        'value' => $this->feed_options['buttoncolor'],
                        'important' => true
                    ],
                    'color' => [
                        'value' => $this->feed_options['buttontextcolor'],
                        'important' => true
                    ]
                ]
            ],
            [
                'selector' => $feed_ctn . ' .ctf-more:hover',
                'properties' => [
                    'background-color' => [
                        'value' => $this->feed_options['buttonhovercolor'],
                        'important' => true
                    ]
                ]
            ],
            //Author Text Style
            [
                'selector' => $feed_ctn . ' .ctf-author-name',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['authortextcolor'],
                        'important' => true
                    ],
                    'font-size' => [
                        'value' => $this->feed_options['authortextsize'],
                        'important' => true
                    ]
                ]
            ],
            //Tweet Text Style
            [
                'selector' => $feed_ctn . ' .ctf-tweet-text, ' .$feed_ctn . ' .ctf-quoted-tweet-text' ,
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['textcolor'],
                        'important' => true
                    ],
                    'font-size' => [
                        'value' => $this->feed_options['tweettextsize'],
                        'important' => true
                    ],
                    'font-weight' => [
                        'value' => $this->feed_options['tweettextweight'],
                        'important' => true
                    ]
                ]
            ],
            //Date Style
            [
                'selector' => $feed_ctn . ' .ctf-tweet-meta a',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['datetextcolor'],
                        'important' => true
                    ],
                    'font-size' => [
                        'value' => $this->feed_options['datetextsize'],
                        'important' => true
                    ],
                    'font-weight' => [
                        'value' => $this->feed_options['datetextweight'],
                        'important' => true
                    ]
                ]
            ],
            //Icon Style
            [
                'selector' => $feed_ctn . ' .ctf-tweet-actions a',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['iconcolor'],
                        'important' => true
                    ],
                    'font-size' => [
                        'value' => $this->feed_options['iconsize'],
                        'important' => true
                    ]
                ]
            ],
            //Quoted Tweet
            [
                'selector' => $feed_ctn . ' .ctf-quoted-tweet',
                'properties' => [
                    'font-size' => [
                        'value' => $this->feed_options['quotedauthorsize'],
                        'important' => true
                    ],
                    'font-weight' => [
                        'value' => $this->feed_options['quotedauthorweight'],
                        'important' => true
                    ],
                    'color' => [
                        'value' => $this->feed_options['textcolor'],
                        'important' => true
                    ]
                ]
            ],
            //Twitter Link Style
            [
                'selector' => $feed_ctn . ' .ctf-twitterlink',
                'properties' => [
                    'font-size' => [
                        'value' => floor( .8 * (int)$this->feed_options['iconsize'] ),
                        'important' => true
                    ],
                    'color' => [
                        'value' => $this->feed_options['textcolor'],
                        'important' => true
                    ]
                ]
            ],
            //Twitter Cards
            [
                'selector' => $feed_ctn . ' .ctf-tc-summary-info *',
                'properties' => [
                    'font-size' => [
                        'value' => floor( .8 * (int)$this->feed_options['cardstextsize'] ),
                        'important' => true
                    ],
                    'color' => [
                        'value' => $this->feed_options['cardstextcolor'],
                        'important' => true
                    ]
                ]
            ],
            //Text Header
            [
                'selector' => $feed_ctn . ' .ctf-header-type-text',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['customheadertextcolor'],
                        'important' => true
                    ]
                ]
            ]
        ];

        //Feed Container
        if( isset($this->feed_options['height'])  && $this->feed_options['height'] != 0){
            array_push($css_array,  [
                'selector' => $feed_ctn . '.ctf-fixed-height',
                'properties' => [
                    'height' => [
                        'value' => $this->feed_options['height'],
                        'important' => true
                    ],
                ]
            ]);
        }
        //Link Text Color
        if( !CTF_Feed_Builder::check_if_on( $this->feed_options['disablelinks'] ) ){
            array_push($css_array,[
                'selector' => $feed_ctn . ' .ctf-tweet-text a',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['linktextcolor'],
                        'important' => true
                    ]
                ]
            ]
        );
        }
        //Feed Post item style / Boxed & Regular
        $post_item_css = [];
        if($this->feed_options['tweetpoststyle'] === 'boxed'){
            $post_item_css =  [
                'selector' => $feed_ctn . '.ctf-boxed-style .ctf-item',
                'properties' => [
                    'background-color' => [
                        'value' => $this->feed_options['tweetbgcolor'],
                        'important' => true
                    ],
                    'border-radius' => [
                        'value' => $this->feed_options['tweetcorners']
                    ]
                ]
            ];
        }else if($this->feed_options['tweetpoststyle'] === 'regular' && CTF_Feed_Builder::check_if_on( $this->feed_options['tweetsepline'] ) ){
            $post_item_css =  [
                'selector' => $feed_ctn . '.ctf-regular-style .ctf-item, '. $feed_ctn . ' .ctf-header',
                'properties' => [
                    'border-bottom' => [
                        'size' => $this->feed_options['tweetsepsize'],
                        'color' => $this->feed_options['tweetsepcolor'],
                        'important' => true
                    ]
                ]
            ];
        }
        array_push($css_array, $post_item_css);

        //Color Pallete
        if( isset($this->feed_options['colorpalette'])  && $this->feed_options['colorpalette'] == 'custom'){

            //Custom Background Color
            array_push($css_array,  [
                'selector' => $feed_ctn . '.ctf_palette_custom_' . $this->feed_id . ' .ctf-item, '.  $feed_ctn . '.ctf_palette_custom_' . $this->feed_id . ' .ctf-header',
                'properties' => [
                    'background' => [
                        'value' => $this->feed_options['custombgcolor'],
                        'important' => true
                    ],
                ]
            ]);
            //Custom Accent Color
            array_push($css_array,  [
                'selector' => $feed_ctn . '.ctf_palette_custom_' . $this->feed_id . ' .ctf-corner-logo',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['customaccentcolor'],
                        'important' => true
                    ],
                ]
            ]);
            //Custom Text 1 Color
            array_push($css_array,  [
                'selector' => $feed_ctn . '.ctf_palette_custom_' . $this->feed_id . ' .ctf-author-name, .ctf_palette_custom_' . $this->feed_id . ' .ctf-tweet-text',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['customtextcolor1'],
                        'important' => true
                    ],
                ]
            ]);

            //Custom Text 2 Color
            array_push($css_array,  [
                'selector' => $feed_ctn . '.ctf_palette_custom_' . $this->feed_id . ' .ctf-author-screenname',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['customtextcolor2'],
                        'important' => true
                    ],
                ]
            ]);

            //Custom Link Color
            array_push($css_array,  [
                'selector' => $feed_ctn . '.ctf_palette_custom_' . $this->feed_id . ' .ctf-tweet-text a',
                'properties' => [
                    'color' => [
                        'value' => $this->feed_options['customlinkcolor'],
                        'important' => true
                    ],
                ]
            ]);
        }

        //Legacy Feeds
        if( $this->is_legacy == true ){
            array_push($css_array,
                [
                    'selector' => $feed_ctn . ' .ctf-item',
                    'properties' => [
                        'background-color' => [
                            'value' => $this->feed_options['tweetbgcolor'],
                            'important' => true
                        ]
                    ]
                ],
                [
                    'selector' => $feed_ctn . ' .ctf-corner-logo ',
                    'properties' => [
                        'font-size' => [
                            'value' => $this->feed_options['logosize'],
                            'important' => true
                        ],
                        'color' => [
                            'value' => $this->feed_options['logocolor'],
                            'important' => true
                        ]
                    ]
                ],
                [
                    'selector' => $feed_ctn . ' .ctf-retweet-text, '. $feed_ctn . ' .ctf-author-box-link, '. $feed_ctn . ' .ctf-author-avatar, '. $feed_ctn . ' .ctf-author-name, '.$feed_ctn . ' .ctf-author-screenname',
                    'properties' => [
                        'font-size' => [
                            'value' => $this->feed_options['authortextsize'],
                            'important' => true
                        ],
                        'font-weight' => [
                            'value' => $this->feed_options['authortextweight']
                        ],
                        'color' => [
                            'value' => $this->feed_options['textcolor'],
                        ]
                    ]
                ],
                [
                    'selector' => $feed_ctn . ' .ctf-header-user, ' . $feed_ctn . ' .ctf-header-bio, ' . $feed_ctn . ' .ctf-header-no-bio' ,
                    'properties' => [
                        'color' => [
                            'value' => $this->feed_options['headertextcolor'],
                            'important' => true
                        ]
                    ]
                ],
                [
                    'selector' => $feed_ctn . ' .ctf-header' ,
                    'properties' => [
                        'background-color' => [
                            'value' => $this->feed_options['headerbgcolor'],
                            'important' => true
                        ]
                    ]
                ],
                [
                    'selector' => $feed_ctn,
                    'properties' => [
                        'background-color' => [
                            'value' => $this->feed_options['bgcolor'],
                            'important' => true
                        ],
                        'height' => [
                            'value' => $this->feed_options['height'],
                            'unit' => $this->feed_options['height_unit'],
                            'important' => true
                        ],
                        'width' => [
                            'value' => $this->feed_options['width'],
                            'unit' => $this->feed_options['width_unit'],
                            'important' => true
                        ]
                    ]
                ]




            );

        }

        $feed_style .= '<style type="text/css" data-ctf-style="' . $this->feed_id . '">';
        $feed_style .= CTF_Parse_Pro::parse_css_style( $css_array );
        $feed_style .= '</style>';
        echo $feed_style;
    }

    /**
     * Get Feed Container Attributes
     *
     * @since 2.0
     * @return array
    */
    public function get_feed_attributes(){
        $attributes = '';
        $attributes .=  $this->feed_options['tweetpoststyle'] === 'boxed' && CTF_Feed_Builder::check_if_on( $this->feed_options['tweetboxshadow'] ) ? ' data-boxshadow="true" ' : '';
        return $attributes;
    }

    /**
     * @return mixed
     * @since 2.0
     */
    public static function get_legacy_feed_settings() {
        return json_decode( get_option( 'ctf_legacy_feed_settings', '{}' ), true );
    }


    /**
     * Set Legacy Feed Types
     *
     * @since 2.0
     * @return array
    */
    public function set_legacy_feedtype(){
        $feed_type = 'usertimeline';
        $feeds_number = 0;
        if( ( isset( $this->atts['usertimeline_text'] ) && !empty( $this->atts['usertimeline_text'] ) ) || ( isset( $this->atts['screenname'] ) && !empty( $this->atts['screenname'] ) ) ){
            $feed_type = 'usertimeline';
            $feeds_number++;
        }else{
            $this->feed_options['usertimeline_text'] = '';
            $this->feed_options['screenname'] = '';
        }

        if( ( isset( $this->atts['hashtag_text'] ) && !empty( $this->atts['hashtag_text'] ) ) ||  ( isset( $this->atts['hashtag'] ) && !empty( $this->atts['hashtag'] ) ) ){
            $feed_type = 'hashtag';
            $feeds_number++;
        }else{
            $this->feed_options['hashtag_text'] = '';
            $this->feed_options['hashtag'] = '';
        }

        if( ( isset( $this->atts['search_text'] ) && !empty( $this->atts['search_text'] ) ) || ( isset( $this->atts['search'] ) && !empty( $this->atts['search'] ) ) ){
            $feed_type = 'search';
            $feeds_number++;
        }else{
            $this->feed_options['search_text'] = '';
            $this->feed_options['search'] = '';
        }

        if( isset( $this->atts['home'] ) && !empty( $this->atts['home'] ) && ($this->atts['home']  == 'true' || $this->atts['home']  == true) ){
            $feed_type = 'hometimeline';
            $feeds_number++;
        }else{
            $this->feed_options['home'] = false;
        }

        if( isset( $this->atts['mentions'] ) && !empty( $this->atts['mentions'] ) && ($this->atts['mentions']  == 'true' || $this->atts['mentions']  == true) ){
            $feed_type = 'mentionstimeline';
            $feeds_number++;
        }else{
            $this->feed_options['mentions'] = false;
        }

        if( ( isset( $this->atts['lists_id'] ) && !empty( $this->atts['lists_id'] ) ) || ( isset( $this->atts['lists'] ) && !empty( $this->atts['lists'] ) ) ){
            $feed_type = 'lists';
            $feeds_number++;
        }else{
            $this->feed_options['lists'] = '';
            $this->feed_options['lists_id'] = '';
        }

        $this->feed_options['type'] = $feeds_number > 1 ? 'mixed' : $feed_type;
    }
}


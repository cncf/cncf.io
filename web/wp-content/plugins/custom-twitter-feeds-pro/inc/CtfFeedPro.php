<?php
/**
 * Class CtfFeedPro
 *
 * Extension of the CtfFeed class to add additional functionality to
 * the display of the Twitter feed
 */
namespace TwitterFeed;

use TwitterFeed\Pro\CTF_Feed_Pro;
use TwitterFeed\Pro\CTF_Parse_Pro;
use TwitterFeed\Pro\CTF_Display_Elements_Pro;
use TwitterFeed\Builder\CTF_Feed_Saver_Manager;
use TwitterFeed\CtfOauthConnectPro;

if (!defined('ABSPATH')) {
    die('-1');
}

class CtfFeedPro extends CtfFeed {
    /**
     * @var array
     */
    private $db_twitter_cards = array();

    private $check_for_duplicates = false;

    private $persistent_index;

    public $ids_in_set_w_media;

    /**
     * creates and returns all of the data needed to generate the output for the feed
     *
     * @param array $atts           data from the shortcode
     * @param string $last_id_data  the last visible tweet on the feed, empty string if first set
     * @param int $num_needed_input this number represents the number left to retrieve after the first set
     * @return CtfFeedPro           the complete object for the feed
     */
    public static function init($atts, $last_id_data = '', $num_needed_input = 0, $ids_to_remove = array() , $persistent_index = 1, $preview_settings = false) {
        if ( empty( $atts['feed'] ) ) {
            $ctf_statuses = get_option( 'ctf_statuses', array() );
            if ( empty( $ctf_statuses['support_legacy_shortcode'] ) ) {
                if ( empty( $atts ) ) {
                    $atts = array();
                }
                $atts['feed'] = 1;
            }
        }

        $feed = new CtfFeedPro($atts, $last_id_data, $num_needed_input, $preview_settings);
        if( !isset($feed->feed_options['feederror']) && empty($feed->feed_options['feederror']) ){
            $feed->setFeedOptions();
            if ($feed->feed_options['layout'] === 'carousel') {
                $feed->setCarouselClasses();
            }
            elseif ($feed->feed_options['layout'] === 'masonry') {
                $feed->setMasonryClasses();
            }

            if (ctf_show('twittercards', $feed->feed_options)) {
                $feed->setExistingTwitterCardData();
            }

            $feed->setCacheTypeOption();
            if ($feed->feed_options['persistentcache']) {
                $feed->persistent_index = $persistent_index;
            }
            $settings = ctf_get_database_settings();

            if (CTF_GDPR_Integrations::doing_gdpr($settings)) {
                //$feed->feed_options['disablelightbox'] = false;
                CTF_GDPR_Integrations::init();
            }

            $feed->setTweetSet();
        }

        return $feed;
    }


    /**
     * sets the feed types and associated parameters
     */
    public function setFeedTypeAndTermOptions(){
        $this->feed_options['feed_types_and_terms_display'] = array();
        $this->feed_options['feed_types_and_terms'] = array();
        //$this->feed_options['type'] = '';


        $this->feed_options['screenname'] = isset( $this->atts['screenname'] ) ? $this->atts['screenname'] : ( isset( $this->db_options['usertimeline_text'] ) ? $this->db_options['usertimeline_text'] : '' );

        if ( isset( $this->atts['home'] ) && $this->atts['home'] == 'true' ) {
            $this->feed_options['feed_types_and_terms'][] = array( 'hometimeline', '' );
            $this->feed_options['feed_types_and_terms_display'][] = 'hometimeline';
        }

        if ( isset( $this->atts['mentions'] ) && $this->atts['mentions'] == 'true' ) {
            $this->feed_options['feed_types_and_terms'][] = array( 'mentionstimeline', '' );
            $this->feed_options['feed_types_and_terms_display'][] = 'mentionstimeline';

        }

        if ( isset( $this->atts['screenname'] ) ) {
            $screennames = explode( ',', $this->atts['screenname'] );

            foreach ( $screennames as $screenname ) {
                $this->feed_options['feed_types_and_terms'][] = array( 'usertimeline', $screenname );
                $this->feed_options['feed_types_and_terms_display'][] = $screenname;
            }
            $this->feed_options['screenname'] = $screennames[0];
        }

        if ( isset( $this->atts['search'] ) ) {
            $searches = isset( $this->atts['search'] ) ? $this->atts['search'] : '';

            if ( ! empty( $searches ) ) {
                $searches = explode( ',', $this->atts['search'] );

                foreach ( $searches as $search ) {
                    $this->feed_options['feed_types_and_terms'][] = array( 'search', str_replace( "'", '"', $search ) );
                    $this->feed_options['feed_types_and_terms_display'][] = str_replace( "'", '"', $search );

                }

            }

            $this->check_for_duplicates = true;
        }

        if ( isset( $this->atts['hashtag'] ) ) {

            $hashtags = isset( $this->atts['hashtag'] ) ? $this->validateHashtags( $this->atts['hashtag'] ) : '';
            $hashtag_list = explode( ',', $hashtags );
            foreach ( $hashtag_list as $hashtag ) {
                $this->feed_options['feed_types_and_terms_display'][] = str_replace( "'", '"', $hashtag );
            }
            $hashtags = str_replace( ',', ' OR ', $hashtags );
            if ( strlen( $hashtags < 45 ) ) {
                $hashtags .= ' -filter:retweets';
            }
            if ( ! empty( $hashtags ) ) {
                $this->feed_options['feed_types_and_terms'][] = array( 'hashtag', $hashtags );
            }

            $this->check_for_duplicates = true;
        }

        if ( isset( $this->atts['lists'] ) ) {
            $lists = explode( ',', $this->atts['lists'] );

            foreach ( $lists as $list ) {
                $this->feed_options['feed_types_and_terms'][] = array( 'lists', $list );
                $this->feed_options['feed_types_and_terms_display'][] = $list;
            }
        }

        if ( isset( $this->atts['list'] ) ) {
            $lists = explode( ',', $this->atts['list'] );

            foreach ( $lists as $list ) {
                $this->feed_options['feed_types_and_terms'][] = array( 'lists', $list );
                $this->feed_options['feed_types_and_terms_display'][] = $list;
            }
        }

        // if there is only one feed type and term, just use the single feed creation method
        if ( sizeof( $this->feed_options['feed_types_and_terms'] ) == 1 ) {
            $this->feed_options['type'] = $this->feed_options['feed_types_and_terms'][0][0];
            $this->feed_options['feed_term'] = $this->feed_options['feed_types_and_terms'][0][1];
            $this->feed_options['feed_types_and_terms'] = '';
        }

        if ( ( empty( $this->feed_options['type'] ) || empty( $this->feed_options['feed_term'] ) ) && empty( $this->feed_options['feed_types_and_terms'] ) ) {
            if ( empty( $this->feed_options['type'] ) ) {
				$this->feed_options['type'] = isset( $this->db_options['type'] ) ? $this->db_options['type'] : '';
            }
	        $this->feed_options['feed_types_and_terms'] = array();
			switch ( $this->feed_options['type'] ) {
                case 'hometimeline':
                    $this->feed_options['type'] = 'hometimeline';
                    $this->feed_options['feed_types_and_terms_display'][] = 'hometimeline';
                    break;
                case 'mentionstimeline':
                    $this->feed_options['type'] = 'mentionstimeline';
                    $this->feed_options['feed_types_and_terms_display'][] = 'mentionstimeline';
                    break;
                case 'search':
                    $search_str = isset( $this->db_options['search_text'] ) ? $this->db_options['search_text'] : '';

                    $this->feed_options['feed_types_and_terms'][] = array( 'search', $search_str );
                    $this->feed_options['feed_types_and_terms_display'][] = $search_str;

                    $this->check_for_duplicates = true;

                    break;
                case 'hashtag':
                    $hashtag_str = isset( $this->db_options['hashtag_text'] ) ? $this->db_options['hashtag_text'] : '';
                    $hashtag_str = str_replace( ',', ' OR ', $hashtag_str );

                    $this->feed_options['feed_types_and_terms'][] = array( 'hashtag', $hashtag_str );
                    $this->feed_options['feed_types_and_terms_display'][] = $hashtag_str;

                    $this->check_for_duplicates = true;

                    break;
                case 'lists':
                    $lists_str = isset( $this->db_options['lists_id'] ) ? $this->db_options['lists_id'] : '';
                    $lists = explode( ',', $lists_str );

                    foreach ( $lists as $list ) {
                        $this->feed_options['feed_types_and_terms'][] = array( 'lists', $list );
                        $this->feed_options['feed_types_and_terms_display'][] = $list;

                    }
                    break;
                default:
                    $screennames_str = isset( $this->db_options['usertimeline_text'] ) ? $this->db_options['usertimeline_text'] : '';
                    $screennames = explode( ',', $screennames_str );

                    foreach ( $screennames as $screenname ) {
                        $this->feed_options['feed_types_and_terms'][] = array( 'usertimeline', $screenname );
                        $this->feed_options['feed_types_and_terms_display'][] = $screenname;

                    }
                    $this->feed_options['screenname'] = $screennames[0];
                    break;

            }
            // if there is only one feed type and term, just use the single feed creation method
            if ( sizeof( $this->feed_options['feed_types_and_terms'] ) == 1 ) {
                $this->feed_options['type'] = $this->feed_options['feed_types_and_terms'][0][0];
                $this->feed_options['feed_term'] = $this->feed_options['feed_types_and_terms'][0][1];
                $this->feed_options['feed_types_and_terms'] = '';
            }
        }
    }

    private function validateHashtags($val) {
        $hashtags = preg_replace("/#{2,}/", '', trim($val));
        $hashtags = str_replace("OR", ',', $hashtags);
        $hashtags = str_replace(' ', '', $hashtags);

        $hashtags = explode(',', $hashtags);

        $new_val = array();

        if (!empty($hashtags)) {
            foreach ($hashtags as $hashtag) {
                if (substr($hashtag, 0, 1) != '#' && $hashtag != '') {
                    $new_val[] .= '#' . $hashtag;
                }
                else {
                    $new_val[] .= $hashtag;
                }
            }
        }

        $new_val = implode(' OR ', $new_val);

        return $new_val;
    }

    public function setCacheTypeOption() {
        if ($this->feed_options['persistentcache'] && ($this->feed_options['type'] == 'search' || $this->feed_options['type'] == 'hashtag')) {
            $this->feed_options['persistentcache'] = true;
        }
        else {
            $this->feed_options['persistentcache'] = false;
        }
    }

    /**
     * sets the visible parts of each tweet for the feed
     */
    public function setIncludeExcludeOptions() {
        $this->feed_options['tweet_includes'] = array();
        $this->feed_options['tweet_excludes'] = array();
        $this->feed_options['tweet_includes'] = isset($this->atts['include']) ? explode(',', str_replace(', ', ',', $this->atts['include'])) : array();
	    $legacy_atts_include = isset($this->raw_shortcode_atts['include']) ? explode(',', str_replace(', ', ',', $this->raw_shortcode_atts['include'])) : array();
	    $legacy_atts_exclude = isset($this->raw_shortcode_atts['exclude']) ? explode(',', str_replace(', ', ',', $this->raw_shortcode_atts['exclude'])) : array();
		if ( ! empty( $legacy_atts_include ) ) {
			if ( in_array( 'author', $legacy_atts_include, true ) ) {
				$this->feed_options['tweet_includes'][] = 'author_text';
			}
		}
	    if ( ! empty( $legacy_atts_exclude ) ) {
		    if ( in_array( 'author', $legacy_atts_exclude, true ) ) {
			    $this->atts['exclude'] .= ',author_text';
		    }
	    }
		if (empty($this->feed_options['tweet_includes'][0])) {
            $this->feed_options['tweet_excludes'] = isset($this->atts['exclude']) ? explode(',', str_replace(', ', ',', $this->atts['exclude'])) : array();
        }
        if (empty($this->feed_options['tweet_excludes'][0]) && empty($this->feed_options['tweet_includes'][0])) {
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_retweeter']) && $this->feed_options['include_retweeter'] == false ? null : 'retweeter';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_avatar']) && $this->feed_options['include_avatar'] == false ? null : 'avatar';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_author']) && $this->feed_options['include_author'] == false ? null : 'author';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_author_text']) && $this->feed_options['include_author_text'] == false ? null : 'author_text';

            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_logo']) && $this->feed_options['include_logo'] == false ? null : 'logo';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_text']) && $this->feed_options['include_text'] == false ? null : 'text';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_date']) && $this->feed_options['include_date'] == false ? null : 'date';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_actions']) && $this->feed_options['include_actions'] == false ? null : 'actions';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_twitterlink']) && $this->feed_options['include_twitterlink'] == false ? null : 'twitterlink';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_linkbox']) && $this->feed_options['include_linkbox'] == false ? null : 'linkbox';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_replied_to']) && $this->feed_options['include_replied_to'] == false ? null : 'repliedto';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_media']) && $this->feed_options['include_media'] == false ? null : 'media';
            $this->feed_options['tweet_includes'][] = isset($this->feed_options['include_twittercards']) && $this->feed_options['include_twittercards'] == false ? null : 'twittercards';
        }



    }

    /**
     *  Adds classes to the main #ctf element to be used to create the masonry
     *  layout for feeds
     */
    public function setMasonryClasses() {
        $options = $this->feed_options;
        $classes_to_add = '';

        if ($this->feed_options['layout'] === 'masonry') {
            $classes_to_add .= ' ctf-masonry';

            if ($options['masonrycols'] > 3 && $options['masonrycols'] < 7) {
                $classes_to_add .= ' masonry-' . $options['masonrycols'] . '-desktop';
            }

            if ($options['masonrycols'] == 2) {
                $classes_to_add .= ' masonry-2-desktop';
            }

            if ($options['masonrymobilecols'] == 2) {
                $classes_to_add .= ' masonry-2-mobile';
            }

        }

        $this->feed_options['class'] .= $classes_to_add;
    }

    /**
     *  Adds classes to the main #ctf element to be used to create the carousel
     *  layout for feeds
     */
    public function setCarouselClasses() {
        $this->feed_options['class'] .= ' ctf-carousel';
    }

    /**
     * used to get twitter card data from the database and store it in member data
     */
    private function setExistingTwitterCardData() {
        $this->db_twitter_cards = get_option('ctf_twitter_cards');
    }

    /**
     * sets the transient name for the caching system
     */
    public function setTransientName() {
        $this->transient_name = 'ctf____' . $this->last_id_data;

        $last_id_data = substr($this->last_id_data, -5, 5);
        $num = isset($this->feed_options['num']) && !empty($this->feed_options['num']) ? $this->feed_options['num'] : 1;
        $reply = $this->feed_options['includereplies'] === true ? 'r' : '';
        $includewords = !empty($this->feed_options['includewords']) ? substr(str_replace(array(
            ',',
            ' '
        ) , '', $this->feed_options['includewords']) , 0, 10) : '';
        $excludewords = !empty($this->feed_options['excludewords']) ? substr(str_replace(array(
            ',',
            ' '
        ) , '', $this->feed_options['excludewords']) , 0, 5) : '';
        $noretweets = !$this->feed_options['includeretweets'] ? 'n' : '';
        $remove_by_id_array = explode(',', str_replace(' ', '', $this->feed_options['remove_by_id']));
        $remove_by_id_str = '';
        $feedID = (!empty($this->atts['feedid'])) ? $this->atts['feedid'] . '_' : '';

        if (!empty($remove_by_id_array)) {
            foreach ($remove_by_id_array as $id) {
                $remove_by_id_str .= substr($id, -3, 3);
            }
        }

        switch ($this->feed_options['type']) {
            case 'hometimeline':
                $this->transient_name = 'ctf_' . $feedID . $last_id_data . 'home' . $num . $reply . $includewords . $remove_by_id_str . $excludewords . $noretweets;
            break;
            case 'usertimeline':
                $screenname = isset($this->feed_options['screenname']) ? $this->feed_options['screenname'] : '';
                $this->transient_name = substr('ctf__' . $feedID . $last_id_data . $screenname . $num . $reply . $includewords . $remove_by_id_str . $excludewords . $noretweets, 0, 45);
            break;
            case 'search':
                $hashtag = isset($this->feed_options['feed_term']) ? $this->feed_options['feed_term'] : '';
                $this->transient_name = substr('ctf_' . $feedID . $last_id_data . substr($hashtag, 0, 20) . $includewords . $num . $reply . $remove_by_id_str . $excludewords . $noretweets, 0, 45);
            break;
            case 'hashtag':
                $hashtag = isset($this->feed_options['feed_term']) ? str_replace(' -filter:retweets', '', $this->feed_options['feed_term']) : '';
                $this->transient_name = substr('ctf_' . $feedID . $last_id_data . substr($hashtag, 0, 20) . $includewords . $num . $reply . $remove_by_id_str . $excludewords . $noretweets, 0, 45);
            break;
            case 'mentionstimeline':
                $this->transient_name = 'ctf_' . $feedID . $last_id_data . 'mentions' . $num . $includewords . $remove_by_id_str . $excludewords . $noretweets;
            break;
            case 'lists':
                $list = isset($this->feed_options['feed_term']) ? $this->feed_options['feed_term'] : '';
                $this->transient_name = substr('ctf_' . $feedID . $last_id_data . $list . $num . $reply . $includewords . $remove_by_id_str . $excludewords, 0, 45);
            break;
            default:
                if (!empty($this->feed_options['feed_types_and_terms'])) {
                    $names = $this->feed_options['feed_types_and_terms'];
                    $working_name = '';
                    foreach ($names as $name) {
                        $working_name .= substr($name[1], 0, 3);
                    }
                    $this->transient_name = substr('ctf__' . $feedID . $last_id_data . $working_name . $num . $reply . $includewords . $remove_by_id_str . $excludewords . $noretweets, 0, 45);
                    break;
                }

        }

    }

    /**
     * will use the cached data in the feed if data seems to be valid and user
     * wants to use caching
     *
     * @return bool|mixed   false if none is set, tweet set otherwise
     */
    public function maybeSetTweetsFromCache() {
        if ($this->feed_options['persistentcache'] && ($this->feed_options['type'] == 'search' || $this->feed_options['type'] == 'hashtag')) {
            $persistent_cache_tweets = $this->persistentCacheTweets();
            if (is_array($persistent_cache_tweets)) {
                $this->transient_data = array_slice($persistent_cache_tweets, ($this->persistent_index - $this->feed_options['num'] - 1) , $this->persistent_index);
            }
            else {
                $this->transient_data = $persistent_cache_tweets;
            }
        }
        else {
            $this->transient_data = $this->cache->get_transient($this->transient_name);
            if (!is_array($this->transient_data)) {
                $this->transient_data = json_decode($this->transient_data, $assoc = true);
            }

            if ($this->feed_options['cache_time'] <= 0) {
                return $this->tweet_set = false;
            }
        }
        // validate the transient data
        if ($this->transient_data) {

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

    private function reduceTweetSetData($tweet_set, $limit = true) {
        if ($this->hasTweetTextFilter() || !$this->feed_options['includereplies']) {
            $tweet_set = $this->filterTweetSet($tweet_set, $limit);
        }

        if ($this->check_for_duplicates) {
            $tweet_set = $this->removeDuplicates($tweet_set, $limit);
        }

        $this->tweet_set = $tweet_set;
        if (isset($tweet_set[0]['created_at'])) {
            $this->tweet_set = CTF_Feed_Pro::reduceTweetSetData($tweet_set);
            return $this->tweet_set;
        }
        else {
            return false;
        }
    }

    private function appendPersistentCacheTweets($existing_cache, $tweet_set) {
        if (is_array($tweet_set)) {
            $working_tweet_set = array_merge($tweet_set, $existing_cache);
        }
        else {
            $working_tweet_set = $existing_cache;
        }

        $working_tweet_set = array_slice($working_tweet_set, 0, 150);

        return $working_tweet_set;
    }

    private function persistentCacheTweets() {
        // if cache exists get cached data
        $includewords = !empty($this->feed_options['includewords']) ? substr(str_replace(array(
            ',',
            ' '
        ) , '', $this->feed_options['includewords']) , 0, 10) : '';
        $excludewords = !empty($this->feed_options['excludewords']) ? substr(str_replace(array(
            ',',
            ' '
        ) , '', $this->feed_options['excludewords']) , 0, 5) : '';
        $feedID = (!empty($this->atts['feedid'])) ? $this->atts['feedid'] . '_' : '';
        $cache_name = substr('ctf_!_' . $feedID . $this->feed_options['feed_term'] . $includewords . $excludewords, 0, 45);
        if ($this->feed_options['type'] === 'hashtag') {
            $cache_name = str_replace(' -filter:retweets', '', $cache_name);
        }
        $cache_time_limit_reached = $this->cache->get_transient($cache_name) ? false : true;

        $existing_cache = $this->cache->get_persistent( $cache_name );

        if ($existing_cache && !is_array($existing_cache)) {
            $existing_cache = json_decode($existing_cache, $assoc = true);
        }

        $this->persistent_index = (int)$this->persistent_index + (int)$this->feed_options['num'];

        $this->feed_options['count'] = 200;

        if (!empty($this->last_id_data) || (!$cache_time_limit_reached && $existing_cache)) {
            return $existing_cache;
        }
        elseif ($existing_cache) {
            // use "since-id" to look for more in an api request
            $since_id = $existing_cache[0]['id_str'];
            $api_obj = $this->getTweetsSinceID($since_id, 'search', $this->feed_options['feed_term'], $this->feed_options['count']);
            // add any new tweets to the cache
            $tweet_set = json_decode($api_obj->json, $assoc = true);

            $tweet_set = isset($tweet_set['statuses']) ? $tweet_set['statuses'] : array();

            // add a transient to delay another api retrieval
	        $this->cache->set_transient($cache_name, true, $this->feed_options['cache_time']);

            if (empty($tweet_set)) {
                $existing_cache = $this->filterTweetSet($existing_cache, false);
                $cache_set = json_encode($existing_cache);

                $this->cache->set_persistent($cache_name, $cache_set );
                return $existing_cache;
            }
            else {
                $tweet_set = $this->reduceTweetSetData($tweet_set, false);
            }

            $tweet_set = $this->appendPersistentCacheTweets($existing_cache, $tweet_set);
            $tweet_set = $this->filterTweetSet($tweet_set, false);

            $cache_set = json_encode($tweet_set);

	        $this->cache->set_persistent($cache_name, $cache_set );

            return $tweet_set;
            // else if cached data doesn't exist

        }
        else {
            // make a request for last 200 tweets
            $api_obj = $this->apiConnectionResponse('search', $this->feed_options['feed_term']);
            // cache them in a regular option
            $this->tweet_set = json_decode($api_obj->json, $assoc = true);
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
            else {
                $this->tweet_set = $this->reduceTweetSetData($tweets, false);
            }

            if ($this->tweet_set) {
                $tweet_set = json_encode($this->tweet_set);
                // create a new persistent cache
	            $this->cache->set_persistent( $cache_name, $tweet_set );

                // update list of persistent cache
                $cache_list = get_option('ctf_cache_list', array());

                $cache_list[] = $cache_name;

                update_option('ctf_cache_list', $cache_list, false);
            }

            return $this->tweet_set;
        }

        // add the search parameter to another option that contains a list of all persistent caches available

    }

    /**
     * a check to see if any of the filtering options for the feed are set
     *
     * @return bool whether or not a filter is used for this feed
     */
    private function hasTweetTextFilter() {
        if (!empty($this->feed_options['includewords']) || !empty($this->feed_options['excludewords'])) {
            return true;
        }
        elseif (!empty($this->feed_options['remove_by_id']) || !$this->feed_options['includeretweets']) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * if a filter is applied to this feed, check and see if this tweet needs to
     * or contains the includewords text
     *
     * @param $good_text array      words the tweet needs to be included in the feed
     * @param $any_or_all enum      whether any or all of the goot text words need to be included
     * @param $tweet_text string    content text of the tweet
     * @param $default bool         the default return type if nothing is set
     * @return bool                 whether the tweet meets the requirements for having good text
     */
    private function hasGoodText($good_text, $any_or_all, $tweet_text, $default) {
        if (empty($good_text)) { // don't factor in the includewords if there aren't any
            return $default;
        }
        else {
            $encoded_text = ' ' . str_replace(array(
                '+',
                '%0A'
            ) , ' ', urlencode(str_replace(array(
                '#',
                '@'
            ) , array(
                ' HASHTAG',
                ' MENTION'
            ) , strtolower($tweet_text)))) . ' ';

            if ($any_or_all == 'any') {
                // as soon as we find any of the includewords, stop searching and return true
                foreach ($good_text as $good) {
                    $converted_includeword = trim(str_replace('+', ' ', urlencode(str_replace(array(
                        '#',
                        '@'
                    ) , array(
                        ' HASHTAG',
                        ' MENTION'
                    ) , strtolower($good)))));
                    if (preg_match('/\b' . $converted_includeword . '\b/i', $encoded_text, $matches)) {
                        return true;
                    }
                }
                // if foreach finishes without finding any matches
                return false;
            }
            else {
                // to make sure all of the includewords are present, keep a count of
                // how many of the words are detected and compare it to the number that's needed
                $good_text_matches = 0;
                $number_of_good_text_to_look_for = count($good_text);
                foreach ($good_text as $good) {
                    $converted_includeword = trim(str_replace('+', ' ', urlencode(str_replace(array(
                        '#',
                        '@'
                    ) , array(
                        ' HASHTAG',
                        ' MENTION'
                    ) , strtolower($good)))));

                    if (preg_match('/\b' . $converted_includeword . '\b/i', $encoded_text, $matches)) {
                        $good_text_matches++;
                    }

                }
                if ($good_text_matches >= $number_of_good_text_to_look_for) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }

    }

    /**
     * if a filter is applied to this feed, check and see if this tweet needs to
     * or contains the excludewords text
     *
     * @param $bad_text array       words the tweet cannot have to be included in the feed
     * @param $any_or_all enum      whether any or all of the bad text words need to be included
     * @param $tweet_text string    content text of the tweet
     * @param $default bool         the default return type if nothing is set
     * @return bool                 whether the tweet meets the requirements for having no bad text
     */
    private function hasNoBadText($bad_text, $any_or_all, $tweet_text, $default) {
        if (empty($bad_text)) { // don't factor in the excludewords if there aren't any
            return $default;
        }
        else {
            $encoded_text = ' ' . str_replace(array(
                '+',
                '%0A'
            ) , ' ', urlencode(str_replace(array(
                '#',
                '@'
            ) , array(
                ' HASHTAG',
                ' MENTION'
            ) , strtolower($tweet_text)))) . ' ';

            if ($any_or_all == 'any') {
                // as soon as we find any of the excludewords, stop searching and return false
                foreach ($bad_text as $bad) {
                    if (empty($bad)) {
                        return true;
                    }
                    $converted_excludeword = trim(str_replace('+', ' ', urlencode(str_replace(array(
                        '#',
                        '@'
                    ) , array(
                        ' HASHTAG',
                        ' MENTION'
                    ) , strtolower($bad)))));
                    if (preg_match('/\b' . $converted_excludeword . '\b/i', $encoded_text, $matches)) {
                        return false;
                    }
                }
                // if foreach finishes without finding any matches
                return true;
            }
            else {
                // under this circumstance, all excludewords need to be present to remove
                // the tweet so a count is kept and compared to the number of words
                $bad_text_matches = 0;
                $number_of_bad_text_to_look_for = count($bad_text);
                foreach ($bad_text as $bad) {
                    $converted_excludeword = trim(str_replace('+', ' ', urlencode(str_replace('#', 'HASHTAG', strtolower($bad)))));

                    if (preg_match('/\b' . $converted_excludeword . '\b/i', $encoded_text, $matches)) {
                        $bad_text_matches++;
                    }

                }
                if ($bad_text_matches >= $number_of_bad_text_to_look_for) {
                    return false;
                }
                else {
                    return true;
                }
            }
        }

    }

    /**
     * this handles the removal of the tweet based on the feed options and filtering settings
     *
     * @param $tweet array  data from the Twitter API associated with this tweet
     * @return bool         whether or not the tweet should be removed from the availalble tweets for the feed
     */
    private function tweetShouldBeRemoved($tweet) {
        $return = false;
        $good_text = !empty($this->feed_options['includewords']) ? explode(',', str_replace(' ', '', $this->feed_options['includewords'])) : '';
        $bad_text = !empty($this->feed_options['excludewords']) ? explode(',', str_replace(' ', '', $this->feed_options['excludewords'])) : '';
        $includewords_any_all = $this->feed_options['includeanyall'];
        $excludewords_any_all = $this->feed_options['excludeanyall'];
        $filter_and_or = $this->feed_options['filterandor'];
        if (isset($tweet['retweeted_status']['full_text'])) {
            $tweet_text = $tweet['retweeted_status']['full_text'];
        }
        elseif (isset($tweet['retweeted_status']['text'])) {
            $tweet_text = $tweet['retweeted_status']['text'];
        }
        elseif (isset($tweet['full_text'])) {
            $tweet_text = $tweet['full_text'];
        }
        elseif (isset($tweet['text'])) {
            $tweet_text = $tweet['text'];
        }
        else {
            $tweet_text = '';
        }
        $tweet_text = ' ' . preg_replace('/[,.!?:;"]+/', '', $tweet_text) . ' '; // spaces added so that we can use strpos instead of regex to find words
        $tweet_text = strtolower(preg_replace('/[\n]+/', ' ', $tweet_text));
        // don't bother with filtering process if both filters are empty
        if (!empty($good_text) || !empty($bad_text)) {
            if ($filter_and_or == 'and' && !empty($good_text) && !empty($bad_text)) {
                if ($this->hasGoodText($good_text, $includewords_any_all, $tweet_text, true) && $this->hasNoBadText($bad_text, 'any', $tweet_text, true)) {
                    $return = false;
                }
                else {
                    $return = true;
                }
            }
            else {
                if ($this->hasGoodText($good_text, $includewords_any_all, $tweet_text, false) || $this->hasNoBadText($bad_text, $excludewords_any_all, $tweet_text, false)) {
                    $return = false;
                }
                else {
                    $return = true;
                }
            }
        }

        $return = apply_filters('ctf_filter_out_tweet', $return, $tweet_text, $tweet);

        return $return;
    }

    /**
     * this takes the current set of tweets and processes them until there are
     * enough filtered tweets to create the feed from
     */
    private function filterTweetSet($tweet_set, $limit = true) {
        $working_tweet_set = isset($tweet_set['statuses']) ? $tweet_set['statuses'] : $tweet_set;
        $usable_tweets = 0;
        if ($limit) {
            $tweets_needed = $this->feed_options['count'] + 1; // magic number here should be ADT

        }
        else {
            $tweets_needed = 200;
        }
        $tweets_to_remove_strip_ctf = str_replace('ctf_', '', $this->feed_options['remove_by_id']);
        $ids_of_tweets_to_remove = !empty($tweets_to_remove_strip_ctf) ? explode(',', str_replace(' ', '', $tweets_to_remove_strip_ctf)) : '';
        $i = 0; // index of working_tweet_set
        $still_setting_filtered_tweets = true;

        while ($still_setting_filtered_tweets) { // stays true until the number to display is reached or out of tweets
            if (isset($working_tweet_set[$i])) { // if there is another tweet available
                $retweet_id = isset($working_tweet_set[$i]['retweeted_status']['id_str']) ? $working_tweet_set[$i]['retweeted_status']['id_str'] : '';
                if (!empty($retweet_id) && !$this->feed_options['includeretweets']) {
                    unset($working_tweet_set[$i]);
                }
                elseif (!$this->feed_options['includereplies'] && !$this->feed_options['selfreplies'] && isset($working_tweet_set[$i]['in_reply_to_screen_name'])) {
                    unset($working_tweet_set[$i]);
                }
                elseif (!$this->feed_options['includereplies'] && $this->feed_options['selfreplies'] && isset($working_tweet_set[$i]['in_reply_to_screen_name']) && $working_tweet_set[$i]['in_reply_to_screen_name'] !== $working_tweet_set[$i]['user']['screen_name']) {
                    unset($working_tweet_set[$i]);
                }
                elseif (!empty($ids_of_tweets_to_remove) && in_array($working_tweet_set[$i]['id_str'], $ids_of_tweets_to_remove)) {
                    unset($working_tweet_set[$i]);
                }
                elseif ($this->tweetShouldBeRemoved($working_tweet_set[$i])) {
                    unset($working_tweet_set[$i]);
                }
                else {
                    $usable_tweets++;
                }
            }
            else {
                $still_setting_filtered_tweets = false;
            }

            // if there are no more tweets needed
            if ($usable_tweets >= $tweets_needed) {
                $still_setting_filtered_tweets = false;
            }
            else {
                $i++;
            }

        }

        if (is_array($working_tweet_set)) {
            return array_values($working_tweet_set);
        }
        else {
            return false;
        }
    }

    /**
     * used to compare two tweets created date for sorting combined feeds
     *
     * @param $a array  a tweet data set
     * @param $b array  another tweet data set
     * @return int      represents which has a greater value
     */
    private static function compareDateCreatedAt($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    }

    /**
     * used to sort merged tweets that are likely not in chronological order
     *
     * @param $tweet_set array  all tweets
     * @return mixed array      sorted tweets
     */
    private function sortTweetSetByDate($tweet_set) {
        usort($tweet_set, array(
            $this,
            'compareDateCreatedAt'
        ));
        return $tweet_set;
    }

    private function removeDuplicates($tweet_set, $limit = true) {
        $tweet_set = isset($tweet_set['statuses']) ? $tweet_set['statuses'] : $tweet_set;
        $usable_tweets = 0;
        if ($limit) {
            $tweets_needed = $this->feed_options['count'] + 1; // magic number here should be ADT

        }
        else {
            $tweets_needed = 200;
        }
        $ids_of_tweets_to_remove = array();

        $i = 0; // index of tweet_set
        $still_setting_filtered_tweets = true;
        while ($still_setting_filtered_tweets) { // stays true until the number to display is reached or out of tweets
            if (isset($tweet_set[$i]['retweeted_status']['id_str'])) {
                unset($tweet_set[$i]);
            }
            elseif (isset($tweet_set[$i])) {
                $id = isset($tweet_set[$i]['retweeted_status']['id_str']) ? $tweet_set[$i]['retweeted_status']['id_str'] : $tweet_set[$i]['id_str'];
                if (in_array($id, $ids_of_tweets_to_remove)) {
                    unset($tweet_set[$i]);
                }
                else {
                    $usable_tweets++;
                    $ids_of_tweets_to_remove[] = $id;
                }
            }
            else {
                $still_setting_filtered_tweets = false;
            }

            // if there are no more tweets needed
            if ($usable_tweets >= $tweets_needed) {
                $still_setting_filtered_tweets = false;
            }
            else {
                $i++;
            }

        }

        return array_values($tweet_set);
    }

    private function getTweetsSinceID($since_id, $end_point = 'search', $feed_term = '', $count = 0) {
        // Only can be set in the options page
        $request_settings = array(
            'consumer_key' => $this->feed_options['consumer_key'],
            'consumer_secret' => $this->feed_options['consumer_secret'],
            'access_token' => $this->feed_options['access_token'],
            'access_token_secret' => $this->feed_options['access_token_secret'],
        );

        $get_fields = $this->setGetFieldsArray($end_point, $feed_term);

        $get_fields['since_id'] = $since_id;

        $get_fields['count'] = $count;

        ctf_clear_resize_cache($this->transient_name);

        // actual connection
        $twitter_connect = new CtfOauthConnectPro($request_settings, $end_point);
        $twitter_connect->setUrlBase();
        $twitter_connect->setGetFields($get_fields);
        $twitter_connect->setRequestMethod($this->feed_options['request_method']);

        return $twitter_connect->performRequest();
    }

    /**
     *  will attempt to connect to the api to retrieve current tweets
     */
    public function maybeSetTweetsFromTwitter() {
        $this->setTweetsToRetrieve();

        if (empty($this->feed_options['feed_types_and_terms']) || !isset($this->feed_options['feed_types_and_terms'])) {
            $feed_term = isset($this->feed_options['feed_term']) ? $this->feed_options['feed_term'] : '';
            if (empty($feed_term) && $this->feed_options['type'] !== 'hometimeline' && $this->feed_options['type'] !== 'mentionstimeline') {
                $this->tweet_set = false;
                return;
            }
            $api_obj = $this->apiConnectionResponse($this->feed_options['type'], $feed_term);

            $this->tweet_set = json_decode($api_obj->json, $assoc = true);

            $working_tweet_set = $this->tweet_set;
            if (!isset($working_tweet_set['errors'][0])) {
                if (isset($working_tweet_set[0])) {
                    $value = array_values(array_slice($working_tweet_set, -1));
                    $this->last_id_data = $value[0]['id_str'];
                }

                $working_tweet_set = $this->reduceTweetSetData($working_tweet_set);
                if ($working_tweet_set === false) {
                    $working_tweet_set = array();
                }
            }

            $num_tweets = is_array($working_tweet_set) ? count($working_tweet_set) : 500;
            // remove the last tweet as it is returned in the next request
            if (!isset($working_tweet_set['errors'][0]) && isset($working_tweet_set[0]) && $num_tweets < $this->feed_options['count']) {
                // remove the last tweet as it is returned in the next request
                $value = array_values(array_slice($working_tweet_set, -1));
                $last_tweet_id = $value[0]['id_str'];
                if ($last_tweet_id === $this->last_id_data) {
                    array_pop($working_tweet_set);
                }

                $original_count = $this->feed_options['count'];
                $this->feed_options['count'] = 200;
                $api_obj = $this->apiConnectionResponse($this->feed_options['type'], $feed_term);
                $tweet_set_to_merge = json_decode($api_obj->json, $assoc = true);

                if (isset($tweet_set_to_merge['statuses'])) {
                    $working_tweet_set = array_merge($working_tweet_set, $tweet_set_to_merge['statuses']);
                }
                elseif (isset($tweet_set_to_merge[0]['created_at'])) {
                    $working_tweet_set = array_merge($working_tweet_set, $tweet_set_to_merge);
                }

                $this->feed_options['count'] = $original_count;
            }

            $this->tweet_set = $working_tweet_set;
        }
        else {
            $working_tweet_set = array();
            foreach ($this->feed_options['feed_types_and_terms'] as $feed_type_and_term) {
                $api_obj = $this->apiConnectionResponse($feed_type_and_term[0], $feed_type_and_term[1]);
                $tweet_set_to_merge = json_decode($api_obj->json, $assoc = true);

                if (isset($tweet_set_to_merge['statuses'])) {
                    $working_tweet_set = array_merge($working_tweet_set, $tweet_set_to_merge['statuses']);
                }
                elseif (isset($tweet_set_to_merge[0]['created_at'])) {
                    $working_tweet_set = array_merge($working_tweet_set, $tweet_set_to_merge);
                }
            }
            if (!isset($working_tweet_set['errors'][0])) {
                if (isset($working_tweet_set[0])) {
                    $value = array_values(array_slice($working_tweet_set, -1));
                    $this->last_id_data = $value[0]['id_str'];
                }
                $working_tweet_set = $this->reduceTweetSetData($working_tweet_set);
                if ($working_tweet_set === false) {
                    $working_tweet_set = array();
                }
            }
            $num_tweets = is_array($working_tweet_set) ? count($working_tweet_set) : 500;

            if (!isset($working_tweet_set['errors'][0]) && $num_tweets < $this->feed_options['count']) {

                $value = array_values(array_slice($working_tweet_set, -1));
                $last_tweet_id = $value[0]['id_str'];
                if ($last_tweet_id === $this->last_id_data) {
                    array_pop($working_tweet_set);
                }
                $original_count = $this->feed_options['count'];
                $this->feed_options['count'] = 200;
                //last_id_data
                foreach ($this->feed_options['feed_types_and_terms'] as $feed_type_and_term) {
                    $api_obj = $this->apiConnectionResponse($feed_type_and_term[0], $feed_type_and_term[1]);
                    $tweet_set_to_merge = json_decode($api_obj->json, $assoc = true);

                    if (isset($tweet_set_to_merge['statuses'])) {
                        $working_tweet_set = array_merge($working_tweet_set, $tweet_set_to_merge['statuses']);
                    }
                    elseif (isset($tweet_set_to_merge[0]['created_at'])) {
                        $working_tweet_set = array_merge($working_tweet_set, $tweet_set_to_merge);
                    }
                }

                $this->feed_options['count'] = $original_count;
            }

            $this->tweet_set = $this->sortTweetSetByDate($working_tweet_set);
        }

        // check for errors/tweets present
        if (isset($this->tweet_set['errors'][0])) {

	        if (empty($this->api_obj)) {
                $this->api_obj = new \stdClass();
            }
            $this
                ->api_obj->api_error_no = $this->tweet_set['errors'][0]['code'];
            $this
                ->api_obj->api_error_message = $this->tweet_set['errors'][0]['message'];
		}

        $tweets = isset($this->tweet_set['statuses']) ? $this->tweet_set['statuses'] : $this->tweet_set;

        if (empty($tweets)) {
			if ( empty( $this->tweet_set['errors'][0]['message'] ) ) {
				$this->errors['error_message'] = 'No Tweets returned';
				$this->tweet_set = false;
			}

        } elseif ( !empty( $this->tweet_set['errors'][0]['message'] ) ) {

        } else {
            $this->tweet_set = $this->reduceTweetSetData($tweets);
        }
    }

    /**
     * sets the relevant get fields for this specific feed type and term
     *
     * @param $end_point string     api endpoint to use for this term
     * @param $feed_term string     term to use for api parameter
     * @return array                get fields for this request
     */
    public function setGetFieldsArray($end_point, $feed_term) {
        $feed_type = $end_point;

        $get_fields = array();

        $get_fields['tweet_mode'] = 'extended';

        if ($feed_type === 'usertimeline') {
            if (!empty($feed_term)) {
                $get_fields['screen_name'] = $feed_term;
            }
            if ($this->feed_options['includereplies'] || $this->feed_options['selfreplies']) {
                $get_fields['exclude_replies'] = 'false';
            }
            else {
                $get_fields['exclude_replies'] = 'true';
            }
        }

        if ($feed_type === 'hometimeline') {
            if ($this->feed_options['includereplies'] || $this->feed_options['selfreplies']) {
                $get_fields['exclude_replies'] = 'false';
            }
            else {
                $get_fields['exclude_replies'] = 'true';
            }
        }

        if ($feed_type === 'search' || $feed_type === 'hashtag') {
            $get_fields['q'] = $feed_term;
        }

        if ($feed_type === 'lists') {
            if (!empty($feed_term)) {
                $get_fields['list_id'] = $feed_term;
            }
        }

        if ($feed_type === 'userslookup') {
            if (!empty($feed_term)) {
                $get_fields['screen_name'] = $feed_term;
            }
        }

        return $get_fields;
    }

    /**
     * attempts to connect and retrieve tweets from the Twitter api
     *
     * @return mixed|string object containing the response
     */
    public function apiConnectionResponse($end_point, $feed_term) {
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

        if (!empty($this->last_id_data)) {
            $count++;
            $max_id = $this->last_id_data;
        }
        $get_fields['count'] = $count;

        // max_id parameter should only be included for the second set of posts
        if (isset($max_id)) {
            $get_fields['max_id'] = $max_id;
        }
        ctf_clear_resize_cache($this->transient_name);

        // actual connection
        $twitter_connect = new CtfOauthConnectPro($request_settings, $end_point);
        $twitter_connect->setUrlBase();
        $twitter_connect->setGetFields($get_fields);
        $twitter_connect->setRequestMethod($this->feed_options['request_method']);

        return $twitter_connect->performRequest();
    }

    protected function removeStringFromText($string, $text, $expanded_url = '') {
        $exceptions = array(
            '://fb.me/'
        );

        if ($expanded_url !== '') {

            foreach ($exceptions as $exception) {

                if (strpos($expanded_url, $exception) !== false) {
                    return str_replace($string, $expanded_url, $text);
                }

            }

        }

        return str_replace($string, '', $text);
    }

    /**
     * captures additional data for "Pro" features
     *
     * @param $trimmed array    current set of trimmed tweets
     * @param $tweet array      raw tweet data from api
     * @return array
     */
    protected function filterTrimmedTweets($trimmed, $tweet) {
        if (isset($tweet['in_reply_to_screen_name'])) {
            $trimmed['in_reply_to_screen_name'] = $tweet['in_reply_to_screen_name'];
            $trimmed['entities']['user_mentions'][0]['name'] = isset($tweet['entities']['user_mentions'][0]['name']) ? $tweet['entities']['user_mentions'][0]['name'] : '';
            $trimmed['in_reply_to_status_id_str'] = $tweet['in_reply_to_status_id_str'];
        }

        if (isset($tweet['extended_entities']['media'])) {
            // if there is media, we need to remove the media url from the tweet text
            $text = isset($tweet['full_text']) ? $tweet['full_text'] : $tweet['text'];
            $remove_url_from_tweet = apply_filters('ctf_should_remove_url_from_text', true);

            if (isset($tweet['extended_entities']['media'][0]['url']) && $remove_url_from_tweet) {
                $trimmed['text'] = $this->removeStringFromText($tweet['extended_entities']['media'][0]['url'], $text);
            }
            $num_media = count($tweet['extended_entities']['media']);
            for ($i = 0;$i < $num_media;$i++) {
                $trimmed['extended_entities']['media'][$i]['media_url_https'] = $tweet['extended_entities']['media'][$i]['media_url_https'];
                $trimmed['extended_entities']['media'][$i]['type'] = $tweet['extended_entities']['media'][$i]['type'];
                if (isset($tweet['extended_entities']['media'][$i]['sizes'])) {
                    $trimmed['extended_entities']['media'][$i]['sizes'] = $tweet['extended_entities']['media'][$i]['sizes'];
                }
                if ($tweet['extended_entities']['media'][$i]['type'] == 'video' || $tweet['extended_entities']['media'][$i]['type'] == 'animated_gif') {
                    foreach ($tweet['extended_entities']['media'][$i]['video_info']['variants'] as $variant) {
                        if (isset($variant['content_type']) && $variant['content_type'] == 'video/mp4') {
                            $trimmed['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
                        }
                    }
                    if (!isset($trimmed['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'])) {
                        $trimmed['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['extended_entities']['media'][$i]['video_info']['variants'][0]['url'];
                    }
                }
            }

        }
        elseif (isset($tweet['entities']['media'])) {
            // if there is media, we need to remove the media url from the tweet text
            $text = isset($tweet['full_text']) ? $tweet['full_text'] : $tweet['text'];
            $remove_url_from_tweet = apply_filters('ctf_should_remove_url_from_text', true);

            if (isset($tweet['entities']['media'][0]['url']) && $remove_url_from_tweet) {
                $trimmed['text'] = $this->removeStringFromText($tweet['entities']['media'][0]['url'], $text);
            }

            $num_media = count($tweet['entities']['media']);
            for ($i = 0;$i < $num_media;$i++) {
                $trimmed['entities']['media'][$i]['media_url_https'] = $tweet['entities']['media'][$i]['media_url_https'];
                $trimmed['entities']['media'][$i]['type'] = $tweet['entities']['media'][$i]['type'];
                if (isset($tweet['entities']['media'][$i]['sizes'])) {
                    $trimmed['entities']['media'][$i]['sizes'] = $tweet['entities']['media'][$i]['sizes'];
                }
                if ($tweet['entities']['media'][$i]['type'] == 'video' || $tweet['entities']['media'][$i]['type'] == 'animated_gif') {
                    foreach ($tweet['entities']['media'][$i]['video_info']['variants'] as $variant) {
                        if (isset($variant['content_type']) && $variant['content_type'] == 'video/mp4') {
                            $trimmed['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
                        }
                    }
                    if (!isset($trimmed['entities']['media'][$i]['video_info']['variants'][$i]['url'])) {
                        $trimmed['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['entities']['media'][$i]['video_info']['variants'][0]['url'];
                    }
                }
            }

        }

        if (isset($tweet['retweeted_status']['extended_entities']['media'])) {
            // if there is media, we need to remove the media url from the tweet text
            $retweeted_text = isset($tweet['retweeted_status']['full_text']) ? $tweet['retweeted_status']['full_text'] : $tweet['retweeted_status']['text'];
            if (isset($tweet['retweeted_status']['extended_entities']['media'][0]['url'])) {
                $trimmed['retweeted_status']['text'] = $this->removeStringFromText($tweet['retweeted_status']['extended_entities']['media'][0]['url'], $retweeted_text);
            }

            $num_media = count($tweet['retweeted_status']['extended_entities']['media']);
            for ($i = 0;$i < $num_media;$i++) {
                $trimmed['retweeted_status']['extended_entities']['media'][$i]['media_url_https'] = $tweet['retweeted_status']['extended_entities']['media'][$i]['media_url_https'];
                $trimmed['retweeted_status']['extended_entities']['media'][$i]['type'] = $tweet['retweeted_status']['extended_entities']['media'][$i]['type'];
                if (isset($tweet['retweeted_status']['extended_entities']['media'][$i]['sizes'])) {
                    $trimmed['retweeted_status']['extended_entities']['media'][$i]['sizes'] = $tweet['retweeted_status']['extended_entities']['media'][$i]['sizes'];
                }
                if ($tweet['retweeted_status']['extended_entities']['media'][$i]['type'] == 'video' || $tweet['retweeted_status']['extended_entities']['media'][$i]['type'] == 'animated_gif') {
                    foreach ($tweet['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'] as $variant) {
                        if (isset($variant['content_type']) && $variant['content_type'] == 'video/mp4') {
                            $trimmed['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
                        }
                    }
                    if (!isset($trimmed['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'])) {
                        $trimmed['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'][0]['url'];
                    }
                }
            }

        }
        elseif (isset($tweet['retweeted_status']['entities']['media'])) {
            // if there is media, we need to remove the media url from the tweet text
            $retweeted_text = isset($tweet['retweeted_status']['full_text']) ? $tweet['retweeted_status']['full_text'] : $tweet['retweeted_status']['text'];
            if (isset($tweet['retweeted_status']['entities']['media'][0]['url'])) {
                $trimmed['retweeted_status']['text'] = $this->removeStringFromText($tweet['retweeted_status']['entities']['media'][0]['url'], $retweeted_text);
            }

            $num_media = count($tweet['retweeted_status']['entities']['media']);
            for ($i = 0;$i < $num_media;$i++) {
                $trimmed['retweeted_status']['entities']['media'][$i]['media_url_https'] = $tweet['retweeted_status']['entities']['media'][$i]['media_url_https'];
                $trimmed['retweeted_status']['entities']['media'][$i]['type'] = $tweet['retweeted_status']['entities']['media'][$i]['type'];
                if (isset($tweet['retweeted_status']['entities']['media'][$i]['sizes'])) {
                    $trimmed['retweeted_status']['entities']['media'][$i]['sizes'] = $tweet['retweeted_status']['entities']['media'][$i]['sizes'];
                }
                if ($tweet['retweeted_status']['entities']['media'][$i]['type'] == 'video' || $tweet['retweeted_status']['entities']['media'][$i]['type'] == 'animated_gif') {
                    foreach ($tweet['retweeted_status']['entities']['media'][$i]['video_info']['variants'] as $variant) {
                        if (isset($variant['content_type']) && $variant['content_type'] == 'video/mp4') {
                            $trimmed['retweeted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
                        }
                    }
                    if (!isset($trimmed['retweeted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'])) {
                        $trimmed['retweeted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['retweeted_status']['entities']['media'][$i]['video_info']['variants'][0]['url'];
                    }
                }
            }

        }
        elseif (isset($tweet['quoted_status']['extended_entities']['media'])) {
            // if there is media, we need to remove the media url from the tweet text
            $quoted_text = isset($tweet['quoted_status']['full_text']) ? $tweet['quoted_status']['full_text'] : $tweet['quoted_status']['text'];
            if (isset($tweet['quoted_status']['extended_entities']['media'][0]['url'])) {
                $trimmed['quoted_status']['text'] = $this->removeStringFromText($tweet['quoted_status']['extended_entities']['media'][0]['url'], $quoted_text);
            }

            $num_media = count($tweet['quoted_status']['extended_entities']['media']);
            for ($i = 0;$i < $num_media;$i++) {
                $trimmed['quoted_status']['extended_entities']['media'][$i]['media_url_https'] = $tweet['quoted_status']['extended_entities']['media'][$i]['media_url_https'];
                $trimmed['quoted_status']['extended_entities']['media'][$i]['type'] = $tweet['quoted_status']['extended_entities']['media'][$i]['type'];
                if ($tweet['quoted_status']['extended_entities']['media'][$i]['type'] == 'video' || $tweet['quoted_status']['extended_entities']['media'][$i]['type'] == 'animated_gif') {
                    foreach ($tweet['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'] as $variant) {
                        if (isset($variant['content_type']) && $variant['content_type'] == 'video/mp4') {
                            $trimmed['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
                        }
                    }
                    if (!isset($trimmed['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'])) {
                        $trimmed['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][0]['url'];
                    }
                }
            }

        }
        elseif (isset($tweet['quoted_status']['entities']['media'])) {
            // if there is media, we need to remove the media url from the tweet text
            $quoted_text = isset($tweet['quoted_status']['full_text']) ? $tweet['quoted_status']['full_text'] : $tweet['quoted_status']['text'];
            if (isset($tweet['quoted_status']['entities']['media'][0]['url'])) {
                $trimmed['quoted_status']['text'] = $this->removeStringFromText($tweet['quoted_status']['entities']['media'][0]['url'], $quoted_text);
            }

            $num_media = count($tweet['quoted_status']['entities']['media']);
            for ($i = 0;$i < $num_media;$i++) {
                $trimmed['quoted_status']['entities']['media'][$i]['media_url_https'] = $tweet['quoted_status']['entities']['media'][$i]['media_url_https'];
                $trimmed['quoted_status']['entities']['media'][$i]['type'] = $tweet['quoted_status']['entities']['media'][$i]['type'];
                if ($tweet['quoted_status']['entities']['media'][$i]['type'] == 'video' || $tweet['quoted_status']['entities']['media'][$i]['type'] == 'animated_gif') {
                    foreach ($tweet['quoted_status']['entities']['media'][$i]['video_info']['variants'] as $variant) {
                        if (isset($variant['content_type']) && $variant['content_type'] == 'video/mp4') {
                            $trimmed['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
                        }
                    }
                    if (!isset($trimmed['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'])) {
                        $trimmed['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['quoted_status']['entities']['media'][$i]['video_info']['variants'][0]['url'];
                    }
                }
            }

        }

        if (isset($tweet['retweeted_status']['quoted_status']['extended_entities']['media'])) {
            // if there is media, we need to remove the media url from the tweet text
            $retweeted_text = isset($tweet['retweeted_status']['quoted_status']['full_text']) ? $tweet['retweeted_status']['quoted_status']['full_text'] : $tweet['retweeted_status']['quoted_status']['text'];
            if (isset($tweet['retweeted_status']['quoted_status']['extended_entities']['media'][0]['url'])) {
                $trimmed['retweeted_status']['quoted_status']['text'] = $this->removeStringFromText($tweet['retweeted_status']['quoted_status']['extended_entities']['media'][0]['url'], $retweeted_text);
            }

            $num_media = count($tweet['retweeted_status']['quoted_status']['extended_entities']['media']);
            for ($i = 0;$i < $num_media;$i++) {
                $trimmed['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['media_url_https'] = $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['media_url_https'];
                $trimmed['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['type'] = $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['type'];
                if (isset($tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['sizes'])) {
                    $trimmed['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['sizes'] = $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['sizes'];
                }
                if ($tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['type'] == 'video' || $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['type'] == 'animated_gif') {
                    foreach ($tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'] as $variant) {
                        if (isset($variant['content_type']) && $variant['content_type'] == 'video/mp4') {
                            $trimmed['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
                        }
                    }
                    if (!isset($trimmed['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'])) {
                        $trimmed['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][0]['url'];
                    }
                }
            }

        }
        elseif (isset($tweet['retweeted_status']['quoted_status']['entities']['media'])) {
            // if there is media, we need to remove the media url from the tweet text
            $retweeted_text = isset($tweet['retweeted_status']['quoted_status']['full_text']) ? $tweet['retweeted_status']['quoted_status']['full_text'] : $tweet['retweeted_status']['quoted_status']['text'];
            if (isset($tweet['retweeted_status']['quoted_status']['entities']['media'][0]['url'])) {
                $trimmed['retweeted_status']['quoted_status']['text'] = $this->removeStringFromText($tweet['retweeted_status']['quoted_status']['entities']['media'][0]['url'], $retweeted_text);
            }

            $num_media = count($tweet['retweeted_status']['quoted_status']['entities']['media']);
            for ($i = 0;$i < $num_media;$i++) {
                $trimmed['retweeted_status']['quoted_status']['entities']['media'][$i]['media_url_https'] = $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['media_url_https'];
                $trimmed['retweeted_status']['quoted_status']['entities']['media'][$i]['type'] = $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['type'];
                if (isset($tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['sizes'])) {
                    $trimmed['retweeted_status']['quoted_status']['entities']['media'][$i]['sizes'] = $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['sizes'];
                }
                if ($tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['type'] == 'video' || $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['type'] == 'animated_gif') {
                    foreach ($tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'] as $variant) {
                        if (isset($variant['content_type']) && $variant['content_type'] == 'video/mp4') {
                            $trimmed['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
                        }
                    }
                    if (!isset($trimmed['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'])) {
                        $trimmed['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'][0]['url'];
                    }
                }
            }

        }

        //remove the url from the text if it links to a quoted tweet that is already linked to
        if (isset($tweet['quoted_status'])) {
            $maybe_remove_index = count($tweet['entities']['urls']) - 1;
            if (isset($tweet['entities']['urls'][$maybe_remove_index]['url'])) {
                $text = isset($trimmed['full_text']) ? $trimmed['full_text'] : $trimmed['text'];
                $trimmed['text'] = $this->removeStringFromText($tweet['entities']['urls'][$maybe_remove_index]['url'], $text);
            }
        }

        // used to generate twitter cards
        if (isset($tweet['entities']['urls'][0]['expanded_url'])) {

            $trimmed['entities']['urls'][0]['expanded_url'] = $tweet['entities']['urls'][0]['expanded_url'];

            if (ctf_show('twittercards', $this->feed_options)) {
                $twitter_card = CTF_Feed_Pro::maybeGetTwitterCardData($tweet['entities']['urls'][0]['expanded_url'], $tweet['id_str']);

                if (!empty($twitter_card)) {
                    $trimmed['twitter_card'] = $twitter_card;
                    $text = isset($tweet['full_text']) ? $tweet['full_text'] : $tweet['text'];

                    $remove_url_from_tweet = apply_filters('ctf_should_remove_url_from_text', true);
                    if (isset($tweet['entities']['urls'][0]['url']) && $remove_url_from_tweet) {
                        $trimmed['text'] = $this->removeStringFromText($tweet['entities']['urls'][0]['url'], $text);
                    }
                }
            }

        }

        if (isset($tweet['retweeted_status']['entities']['urls'][0]['expanded_url'])) {

            $trimmed['retweeted_status']['entities']['urls'][0]['expanded_url'] = $tweet['retweeted_status']['entities']['urls'][0]['expanded_url'];

            if (ctf_show('twittercards', $this->feed_options)) {
                $twitter_card = CTF_Feed_Pro::maybeGetTwitterCardData($tweet['retweeted_status']['entities']['urls'][0]['expanded_url'], $tweet['id_str']);

                if (!empty($twitter_card)) {
                    $trimmed['retweeted_status']['twitter_card'] = $twitter_card;
                    $retweeted_text = isset($tweet['retweeted_status']['full_text']) ? $tweet['retweeted_status']['full_text'] : $tweet['retweeted_status']['text'];
                    $remove_url_from_tweet = apply_filters('ctf_should_remove_url_from_text', true);
                    if (isset($tweet['retweeted_status']['entities']['urls'][0]['url']) && $remove_url_from_tweet) {
                        $trimmed['retweeted_status']['text'] = $this->removeStringFromText($tweet['retweeted_status']['entities']['urls'][0]['url'], $retweeted_text);
                    }
                }
            }
        }

        return $trimmed;
    }

    /**
     * Adds data attributes to the #cff element
     *
     * User defined carousel options are used in the javascript file
     * with the use of data attributes and jQuery to read them
     *
     * @param array $cff_content | the html that generates the feed
     * @param array $atts | all user defined options for the feed
     * @return string | modified html that generates the feed
     */
    private function carouselDataAtts($options) {
        if ($this->feed_options['layout'] === 'carousel') {
            $data = '';

            $custom_breakpoints = apply_filters('ctf_carousel_breakpoints', array());
            if ($options['carouselautoplay']) {
                $data .= ' data-ctf-interval=' . $options['carouseltime'];
            }

            $data .= ' data-ctf-loop="' . $options['carouselloop'] . '"';
            $data .= isset($options['carouselcols']) ? ' data-ctf-cols="' . $options['carouselcols'] . '"' : '';
            $data .= isset($options['carouselmobilecols']) ? ' data-ctf-mobilecols="' . $options['carouselmobilecols'] . '"' : '';
            $data .= isset($options['carouselarrows']) ? ' data-ctf-arrows="' . $options['carouselarrows'] . '"' : '';
            $data .= isset($options['carouselnavarrows']) ? ' data-ctf-navarrows="' . CTF_Feed_Saver_Manager::cast_boolean_string($options['carouselnavarrows']) . '"' : '';
            $data .= isset($options['carouselheight']) ? ' data-ctf-height="' . $options['carouselheight'] . '"' : '';
            $data .= !empty($custom_breakpoints) ? ' data-ctf-breakpoints="' . esc_attr(wp_json_encode($custom_breakpoints)) . '"' : '';
            $data .= ' data-ctf-rows="' . isset($options['carouselrows']) ? $options['carouselrows'] : '1' . '"';
                $data .= ' data-ctf-pag="false"';

            if ((bool)$options['carouselpag']) {
                $data .= ' data-ctf-pag="true"';
            }
            else {
                $data .= ' data-ctf-pag="false"';
            }

            return $data;
        }
        return '';
    }

    public function feedID() {
        if ($this->feed_options['persistentcache']) {
            $includewords = !empty($this->feed_options['includewords']) ? substr(str_replace(array(
                ',',
                ' '
            ) , '', $this->feed_options['includewords']) , 0, 10) : '';
            $excludewords = !empty($this->feed_options['excludewords']) ? substr(str_replace(array(
                ',',
                ' '
            ) , '', $this->feed_options['excludewords']) , 0, 5) : '';
            $feed_id = (!empty($this->atts['feedid'])) ? substr('ctf_!_' . $this->atts['feedid'] . $includewords . $excludewords, 0, 45) : substr('ctf_!_' . $this->feed_options['feed_term'] . $includewords . $excludewords, 0, 45);
            if ($this->feed_options['type'] === 'hashtag') {
                $feed_id = str_replace(' -filter:retweets', '', $feed_id);
            }
        }
        else {
            $feed_id = $this->transient_name;
        }

        return $feed_id;
    }

    /**
     * creates opening html for the feed
     *
     * @return string opening html that creates the feed
     */

    /**
     * outputs the html for a set of tweets to be used in the feed
     *
     * @param int $is_pagination    1 or 0, used to differentiate between the first set and subsequent tweet sets
     *
     * @return string $tweet_html
     */
    public function getTweetSetHtml($is_pagination = 0) {
        $feed_id                = $this->feedID();
        $options                = ctf_get_database_settings();
        $tweet_set              = isset($this->tweet_set['statuses']) ? $this->tweet_set['statuses'] : $this->tweet_set;
        $tweet_html             = $this->feed_html;
        $tweet_count            = CTF_Parse_Pro::get_tweet_count($tweet_set);
        $feed_options           = $this->feed_options;
        $ctf_data_needed        = $this->num_tweets_needed;
        $ctf_feed_classes       = CTF_Parse_Pro::get_feed_classes($feed_options, $this->check_for_duplicates, $this->feed_id);
        $ids_in_set_w_media     = array();


        $len = min($this->feed_options['num'] + $is_pagination, $tweet_count);
        $i = $is_pagination; // starts at index "1" to offset duplicate tweet
        if ($is_pagination && (!isset($tweet_set[1]['id_str']))) {
            $tweet_html .= $this->getOutOfTweetsHtml($this->feed_options);
        }

        $ctf_styles = $feed_options['width'] . $feed_options['height'] . $feed_options['bgcolor'];

        $ctf_enable_intents = ($options['disableintents'] === false || $options['disableintents'] === 0) && ctf_show('actions', $feed_options) ? ' data-ctfintents="1"' : '';

        $ctf_main_atts = CTF_Display_Elements_Pro::get_feed_container_data_attributes( $feed_options, $feed_id, $this->feedID() ) . $ctf_enable_intents;



        if (!$is_pagination) {
            ob_start();
            include ctf_get_feed_template_part('feed', $feed_options);
            $tweet_html .= ob_get_contents();
            ob_get_clean();
        }

        $this->ids_in_set_w_media = $ids_in_set_w_media;

        return $tweet_html;

    }

    public function getItemSetHtml($is_pagination = 0) {
        $options = get_option('ctf_options');
        $tweet_set = isset($this->tweet_set['statuses']) ? $this->tweet_set['statuses'] : $this->tweet_set;
        $tweet_count = CTF_Parse_Pro::get_tweet_count($tweet_set);
        $len = min($this->feed_options['num'] + $is_pagination, $tweet_count);
        $i = $is_pagination; // starts at index "1" to offset duplicate tweet
        $tweet_html = '';
        if ($is_pagination && (!isset($tweet_set[1]['id_str']))) {
            $tweet_html = $this->getOutOfTweetsHtml($this->feed_options);
        }
        ob_start();

        $this->tweet_loop($tweet_set, $this->feed_options, $is_pagination);
        $tweet_html .= ob_get_contents();
        ob_get_clean();

        return $tweet_html;
    }

    public function tweet_loop($tweet_set, $settings, $is_pagination) {
        $feed_options = $this->feed_options;
        $dbsettings = ctf_get_database_settings();

        $tweet_count = CTF_Parse_Pro::get_tweet_count($tweet_set);
        $len = min($this->feed_options['num'] + $is_pagination, $tweet_count);
        $i = $is_pagination; // starts at index "1" to offset duplicate tweet
        $ids_in_set_w_media = array();
        $t = (count((array)$tweet_set) > 1 ? $t = 1 : 0); // Set index based on tweets returned
        $tweet_html = '';
        if ($is_pagination && (!isset($tweet_set[1]['id_str']))) {
            $tweet_html .= $this->getOutOfTweetsHtml($this->feed_options);
        }

        if ($is_pagination > - 1 && (isset($tweet_set[$t]['id_str']))) {
            while ($i < $len) {
                $media = CTF_Parse_Pro::get_media($tweet_set[$i], false);
                $quoted_media = CTF_Parse_Pro::get_quoted_tc($tweet_set[$i]);
                $retweeted_status = CTF_Parse_Pro::get_retweet_status($tweet_set[$i]);
                $post_id = CTF_Parse_Pro::get_post_id($tweet_set[$i]);
                $twitter_card_post = $tweet_set[$i];
                if ($retweeted_status) {
                    $twitter_card_post = $retweeted_status;
                    $media = CTF_Parse_Pro::get_media($retweeted_status, false);
                }
                if ($media || $quoted_media) {
                    $ids_in_set_w_media[] = $post_id;
                }

                $twitter_card = CTF_Parse_Pro::get_twitter_card($twitter_card_post);

                $twitter_card_url = CTF_Parse_Pro::get_twitter_card_url($twitter_card_post);
                $maybe_twitter_card_placeholder = '';

                if (!isset($twitter_card) && ctf_show('twittercards', $feed_options) && !empty(CTF_Parse_Pro::get_twitter_card_url($twitter_card_post)) && !CTF_Parse_Pro::get_media($twitter_card_post) && !CTF_Parse_Pro::get_quoted_tc($twitter_card_post)):
                    $maybe_twitter_card_placeholder = CTF_Display_Elements_Pro::get_twitter_card_placeholder($twitter_card_post, $twitter_card_url);
                endif;
                $disable_tc_for_quoted = false;

                // don't get the twitter card if it's a quoted video
                if ($quoted_media):
                    $disable_tc_for_quoted = true;
                    unset($twitter_card);
                endif;

                //Check whether it's a 3rd party video (youtube, vimeo, vine)
                if (!$media && !empty($twitter_card_url)) {
                    $iframe_data = CTF_Parse_Pro::iframe_data($twitter_card_url);
                    if ($iframe_data) {
                        $media = array(
                            0 => $iframe_data
                        );
                        $maybe_twitter_card_placeholder = '';
                    }
                }

                $should_show_twitter_card = !$media && ctf_show('twittercards', $feed_options) && isset($twitter_card) && !empty($twitter_card_post['twitter_card']['twitter:card']) && $twitter_card_post['twitter_card']['twitter:card'] !== 'amplify' && !$disable_tc_for_quoted;
                include ctf_get_feed_template_part('item', $settings);
                $i++;
            }
        }
        $this->ids_in_set_w_media = $ids_in_set_w_media;
    }
}


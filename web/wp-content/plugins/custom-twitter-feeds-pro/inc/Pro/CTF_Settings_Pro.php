<?php
/**
 * Class SB_Instagram_Settings
 *
 * Creates organized settings from shortcode settings and settings
 * from the options table.
 *
 * Also responsible for creating transient names/feed ids based on
 * feed settings
 *
 * @since 2.0/5.0
 */
namespace TwitterFeed\Pro;
use TwitterFeed\CtfFeedPro;
use TwitterFeed\Builder\CTF_Feed_Saver;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class CTF_Settings_Pro {
	/**
	 * @var array
	 */
	protected $atts;

	/**
	 * @var array
	 */
	protected $db;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var array
	 */
	protected $feed_type_and_terms;

	/**
	 * SB_Instagram_Settings constructor.
	 *
	 * Overwritten in the Pro version.
	 *
	 * @param array $atts shortcode settings
	 * @param array $db settings from the wp_options table
	 */
	public function __construct( $atts, $db = null, $preview_settings = false  ) {

		$feed = new CtfFeedPro( $atts, null, null );
		$feed->setFeedOptions();

		$bool_false = array(
			'includereplies',
			'masonry',
			'autoscroll',
			'disablelightbox',
			'carousel',
			'carouselautoplay',
			'carouselpag',
			'sslonly',
			'shorturls'
		);
		$feed->setStandardBoolOptions( $bool_false, false );
		$feed->setStandardBoolOptions( array( 'persistentcache', 'includeretweets', 'autores' ), true );
		$feed->setStandardTextOptions( 'carouselarrows', 'onhover' );
		$feed->setStandardTextOptions( 'carouselheight', 'tallest' );
		$feed->setStandardTextOptions( 'carouselcols', 1 );
		$feed->setStandardTextOptions( 'carouselmobilecols', 1 );
		$feed->setStandardTextOptions( 'carouseltime', 5000 );
		$feed->setStandardTextOptions( 'carouselloop', 'none' );
		$feed->setStandardTextOptions( 'masonrycols', 3 );
		$feed->setStandardTextOptions( 'masonrymobilecols', 1 );
		$feed->setStandardTextOptions( 'autoscrolldistance', '200' );
		$feed->setStandardTextOptions( 'textlength', 280 );
		$feed->setStandardTextOptions( 'maxmedia', 4 );
		$feed->setStandardTextOptions( 'imagecols', 'auto' );
		$feed->setStandardTextOptions( 'inreplytotext', 'In reply to' );
		$feed->setStandardTextOptions( array( 'includewords', 'excludewords' ) );
		$feed->setStandardTextOptions( array( 'includeanyall', 'excludeanyall' ), 'any' );
		$feed->setStandardTextOptions( 'filterandor', 'and' );

		$feed->setDatabaseOnlyOptions( 'remove_by_id' );

		$this->settings = $feed->feed_options;
	}

	/**
	 * @return array
	 *
	 * @since 2.0/5.0
	 */
	public function get_settings() {
		return $this->settings;
	}

	public function get_feed_type_and_terms() {
		return $this->feed_type_and_terms;
	}

	/**
	 * Based on the settings related to retrieving post data from the API,
	 * this setting is used to make sure all endpoints needed for the feed are
	 * connected and stored for easily looping through when adding posts
	 *
	 * Overwritten in the Pro version.
	 *
	 * @since 2.0/5.0
	 */
	public function set_feed_type_and_terms() {
		$this->feed_type_and_terms = array();
		if ( ! empty( $this->settings['feed_types_and_terms'] ) ) {

			foreach ( $this->settings['feed_types_and_terms'] as $type_then_term ) {
				switch ( $type_then_term[0] ) {
					case 'hometimeline':
						$this->feed_type_and_terms['hometimeline'][] = array(
							'term' => 'hometimeline',
							'params' => array()
						);
						break;
					case 'mentionstimeline':
						$this->feed_type_and_terms['mentionstimeline'][] = array(
							'term' => 'mentionstimeline',
							'params' => array()
						);
						break;
					case 'search':
						$search_str = isset( $type_then_term[1] ) ? $type_then_term[1] : '';
						$this->feed_type_and_terms['search'][] = array(
							'term' => $search_str,
							'params' => array()
						);
						break;
					case 'hashtag':
						$hashtag_str = isset( $type_then_term[1] ) ? $type_then_term[1] : '';
						$hashtag_str = str_replace( ',', ' OR ', $hashtag_str );

						$this->feed_type_and_terms['search'][] = array(
							'term' => $hashtag_str,
							'params' => array()
						);
						break;
					case 'lists':
						$list = isset( $type_then_term[1] ) ? $type_then_term[1] : '';
						$this->feed_type_and_terms['lists'][] = array(
							'term' => $list,
							'params' => array()
						);
						break;
					default:
						$screenname = isset( $type_then_term[1] ) ? $type_then_term[1] : '';

						$this->feed_type_and_terms['usertimeline'][] = array(
							'term' => $screenname,
							'params' => array()
						);
						break;
				}
			}
		} else {
			if ( ! empty( $this->settings['type'] ) ) {
				switch ( $this->settings['type'] ) {
					case 'hometimeline':
						$this->feed_type_and_terms['hometimeline'][] = array(
							'term' => 'hometimeline',
							'params' => array()
						);
						break;
					case 'mentionstimeline':
						$this->feed_type_and_terms['mentionstimeline'][] = array(
							'term' => 'mentionstimeline',
							'params' => array()
						);
						break;
					case 'search':
						$search_str = isset( $this->settings['search_text'] ) ? $this->settings['search_text'] : '';
						if ( empty( $search_str ) ) {
							$search_str = ( $this->settings['feed_term'] ) ? $this->settings['feed_term'] : '';
						}
						$this->feed_type_and_terms['search'][] = array(
							'term' => $search_str,
							'params' => array()
						);
						break;
					case 'hashtag':
						$hashtag_str = isset( $this->settings['hashtag_text'] ) ? $this->settings['hashtag_text'] : '';
						if ( empty( $hashtag_str ) ) {
							$hashtag_str = ( $this->settings['feed_term'] ) ? $this->settings['feed_term'] : '';
						}
						$hashtag_str = str_replace( ',', ' OR ', $hashtag_str );

						$this->feed_type_and_terms['search'][] = array(
							'term' => $hashtag_str,
							'params' => array()
						);
						break;
					case 'lists':
						$lists_str = isset( $this->settings['lists_id'] ) ? $this->settings['lists_id'] : '';
						if ( empty( $lists_str ) ) {
							$lists_str = ( $this->settings['feed_term'] ) ? $this->settings['feed_term'] : '';
						}
						$this->settings['list'] = $lists_str;
						$lists = explode( ',', $lists_str );

						foreach ( $lists as $list ) {
							$this->feed_type_and_terms['lists'][] = array(
								'term' => $list,
								'params' => array()
							);
						}
						break;
					default:
						$screennames_str = isset( $this->settings['screenname'] ) ? $this->settings['screenname'] : $this->settings['usertimeline_text'];
						$screennames = explode( ',', $screennames_str );

						foreach ( $screennames as $screenname ) {
							$this->feed_type_and_terms['usertimeline'][] = array(
								'term' => $screenname,
								'params' => array()
							);
						}
						break;
				}

			}
		}
	}

	public static function get_settings_by_feed_id( $feed_id, $preview_settings = false ) {
		if ( is_array( $preview_settings ) ) {
			return $preview_settings;
		}

		if ( intval( $feed_id ) < 1 ) {
			return false;
		}

		$feed_saver = new CTF_Feed_Saver( $feed_id );

		return $feed_saver->get_feed_settings();
	}

	/**
	 * Filters out or converts allowed/disallowed shortcode settings
	 *
	 * @param $atts
	 *
	 * @return mixed
	 * @since 2.0
	 */
	public static function filter_atts_for_legacy( $atts ) {
		if ( ! empty( $atts['from_update'] ) ) {
			unset( $atts['from_update'] );
			return $atts;
		}
		$ctf_statuses = get_option( 'ctf_statuses', array() );
		$allowed_legacy_shortcode = array(
			'feed',
			'customizer',
			'doingcronupdate'
		);

		if ( ! empty( $ctf_statuses['support_legacy_shortcode'] )
			&& empty( $atts['feed'] ) ) {

			if ( is_array( $ctf_statuses['support_legacy_shortcode'] ) ) {
				$atts_diff = array_diff( $ctf_statuses['support_legacy_shortcode'], $atts );

				foreach ( $atts_diff as $key => $value ) {
					if ( in_array( $key, $allowed_legacy_shortcode ) ) {
						unset( $atts_diff[ $key ] );
					}
				}
				if ( empty( $atts_diff ) ) {
					$atts['feed'] = 1;
				}
			}

			if ( empty( $atts['feed'] ) ) {
				return $atts;
			}
		}


		foreach ( $atts as $key => $value ) {
			if ( ! in_array( $key, $allowed_legacy_shortcode ) ) {
				unset( $atts[ $key ] );
			}

		}

		return $atts;

	}

	/**
	 * For one time update to capture existing legacy shortcode atts
	 *
	 * @param array $atts
	 * @param array $db
	 *
	 * @return array
	 */
	public static function legacy_shortcode_atts( $atts, $db ) {
		$settings = shortcode_atts(
			array(
				'ajax_theme' 						=> isset( $db['ajax_theme'] ) ? $db['ajax_theme'] : false,
				'have_own_tokens' 					=> isset( $db['have_own_tokens'] ) ? $db['have_own_tokens'] : '',
				'use_own_consumer' 					=> isset( $db['use_own_consumer'] ) ? $db['use_own_consumer'] : '',
				'usertimeline_includereplies' 		=> isset( $db['usertimeline_includereplies'] ) ? $db['usertimeline_includereplies'] : '',
				'hometimeline_includereplies' 		=> isset( $db['hometimeline_includereplies'] ) ? $db['hometimeline_includereplies'] : '',
				'mentionstimeline_includereplies' 	=> isset( $db['mentionstimeline_includereplies'] ) ? $db['mentionstimeline_includereplies'] : '',
				'usertimeline_includeretweets' 		=> isset( $db['usertimeline_includeretweets'] ) ? $db['usertimeline_includeretweets'] : '',
				'hometimeline_includeretweets' 		=> isset( $db['hometimeline_includeretweets'] ) ? $db['hometimeline_includeretweets'] : true,
				'mentionstimeline_includeretweets' 	=> isset( $db['mentionstimeline_includeretweets'] ) ? $db['mentionstimeline_includeretweets'] : '',
				'tab' 								=> isset( $db['tab'] ) ? $db['tab'] : 'configure',
				'consumer_key' 						=> isset( $db['consumer_key'] ) ? $db['consumer_key'] : '',
				'consumer_secret' 					=> isset( $db['consumer_secret'] ) ? $db['consumer_secret'] : '',
				'access_token' 						=> isset( $db['access_token'] ) ? $db['access_token'] : '',
				'access_token_secret' 				=> isset( $db['access_token_secret'] ) ? $db['access_token_secret'] : '',
				'type' 								=> isset( $db['type'] ) ? $db['type'] : 'usertimeline',
				'usertimeline_text' 				=> isset( $db['usertimeline_text'] ) ? $db['usertimeline_text'] : '',
				'hashtag_text' 						=> isset( $db['hashtag_text'] ) ? $db['hashtag_text'] : '',
				'search_text' 						=> isset( $db['search_text'] ) ? $db['search_text'] : '',
				'lists_id' 							=> isset( $db['lists_id'] ) ? $db['lists_id'] : '',
				'lists_owner' 						=> isset( $db['lists_owner'] ) ? $db['lists_owner'] : '',
				'num' 								=> isset( $db['num'] ) ? $db['num'] : '5',
				'lists_info' 						=> isset( $db['lists_info'] ) ? $db['lists_info'] : '{}',
				'includereplies' 					=> isset( $db['includereplies'] ) ? $db['includereplies'] : true,
				'includeretweets' 					=> isset( $db['includeretweets'] ) ? $db['includeretweets'] : false,
				'width_mobile_no_fixed' 			=> isset( $db['width_mobile_no_fixed'] ) ? $db['width_mobile_no_fixed'] : false,
				'include_replied_to' 				=> isset( $db['include_replied_to'] ) ? $db['include_replied_to'] : true,
				'include_retweeter' 				=> isset( $db['include_retweeter'] ) ? $db['include_retweeter'] : true,
				'include_author' 					=> isset( $db['include_author'] ) ? $db['include_author'] : true,
				'include_avatar' 					=> isset( $db['include_avatar'] ) ? $db['include_avatar'] : true,
				'include_author_text' 				=> isset( $db['include_author_text'] ) ? $db['include_author_text'] : true,
				'include_text' 						=> isset( $db['include_text'] ) ? $db['include_text'] : true,
				'include_date' 						=> isset( $db['include_date'] ) ? $db['include_date'] : true,
				'include_actions' 					=> isset( $db['include_actions'] ) ? $db['include_actions'] : true,
				'include_linkbox' 					=> isset( $db['include_linkbox'] ) ? $db['include_linkbox'] : true,
				'include_media' 					=> isset( $db['include_media'] ) ? $db['include_media'] : true,
				'include_twittercards' 				=> isset( $db['include_twittercards'] ) ? $db['include_twittercards'] : true,
				'include_logo' 						=> isset( $db['include_logo'] ) ? $db['include_logo'] : true,
				'include_twitterlink'				=> isset( $db['include_twitterlink'] ) ? $db['include_twitterlink'] : true,
				'creditctf' 						=> isset( $db['creditctf'] ) ? $db['creditctf'] : false,
				'showbutton' 						=> isset( $db['showbutton'] ) ? $db['showbutton'] : true,
				'showheader' 						=> isset( $db['showheader'] ) ? $db['showheader'] : true,
				'persistentcache' 					=> isset( $db['persistentcache'] ) ? $db['persistentcache'] : true,
				'selfreplies' 						=> isset( $db['selfreplies'] ) ? $db['selfreplies'] : true,
				'autores' 							=> isset( $db['autores'] ) ? $db['autores'] : true,
				'disableintents' 					=> isset( $db['disableintents'] ) ? $db['disableintents'] : false,
		     	'customtemplates' 					=> isset( $db['customtemplates'] ) ? $db['customtemplates'] : false,
				'shorturls' 						=> isset( $db['shorturls'] ) ? $db['shorturls'] : false,
				'curlcards' 						=> isset( $db['curlcards'] ) ? $db['curlcards'] : true,
				'sslonly' 							=> isset( $db['sslonly'] ) ? $db['sslonly'] : false,
				'disablelightbox' 					=> isset( $db['disablelightbox'] ) ? $db['disablelightbox'] : false,
				'masonry' 							=> isset( $db['masonry'] ) ? $db['masonry'] : false,
				'carousel' 							=> isset( $db['carousel'] ) ? $db['carousel'] : false,
				'carouselnavarrows' 				=> isset( $db['carouselnavarrows'] ) ? $db['carouselnavarrows'] : true,
				'carouselpag' 						=> isset( $db['carouselpag'] ) ? $db['carouselpag'] : false,
				'carouselautoplay' 					=> isset( $db['carouselautoplay'] ) ? $db['carouselautoplay'] : false,
				'autoscroll' 						=> isset( $db['autoscroll'] ) ? $db['autoscroll'] : true,
				'width' 							=> isset( $db['width'] ) ? $db['width'] : '100',
				'width_unit' 						=> isset( $db['width_unit'] ) ? $db['width_unit'] : '%',
				'height' 							=> isset( $db['height'] ) ? $db['height'] : '',
				'height_unit' 						=> isset( $db['height_unit'] ) ? $db['height_unit'] : '%',
				'class' 							=> isset( $db['class'] ) ? $db['class'] : '',
				'layout' 							=> isset( $db['layout'] ) ? $db['layout'] : 'list',
				'masonrycols' 						=> isset( $db['masonrycols'] ) ? $db['masonrycols'] : '3',
				'masonrytabletcols' 				=> isset( $db['masonrytabletcols'] ) ? $db['masonrytabletcols'] : '2',
				'masonrymobilecols' 				=> isset( $db['masonrymobilecols'] ) ? $db['masonrymobilecols'] : '1',
				'carouselrows' 						=> isset( $db['carouselrows'] ) ? $db['carouselrows'] : '1',
				'carouselcols' 						=> isset( $db['carouselcols'] ) ? $db['carouselcols'] : '3',
				'carouseltabletcols' 				=> isset( $db['carouseltabletcols'] ) ? $db['carouseltabletcols'] : '2',
				'carouselmobilecols' 				=> isset( $db['carouselmobilecols'] ) ? $db['carouselmobilecols'] : '1',
				'carouselloop' 						=> isset( $db['carouselloop'] ) ? $db['carouselloop'] : 'rewind',
				'carouselarrows' 					=> isset( $db['carouselarrows'] ) ? $db['carouselarrows'] : 'onhover',
				'carouselheight' 					=> isset( $db['carouselheight'] ) ? $db['carouselheight'] : 'tallest',
				'carouseltime' 						=> isset( $db['carouseltime'] ) ? $db['carouseltime'] : '5000',
				'maxmedia' 							=> isset( $db['maxmedia'] ) ? $db['maxmedia'] : '4',
				'imagecols' 						=> isset( $db['imagecols'] ) ? $db['imagecols'] : 'auto',
				'autoscrolldistance' 				=> isset( $db['autoscrolldistance'] ) ? $db['autoscrolldistance'] : '200',
				'includewords' 						=> isset( $db['includewords'] ) ? $db['includewords'] : '',
				'excludewords' 						=> isset( $db['excludewords'] ) ? $db['excludewords'] : '',
				'includeanyall' 					=> isset( $db['includeanyall'] ) ? $db['includeanyall'] : 'any',
				'filterandor' 						=> isset( $db['filterandor'] ) ? $db['filterandor'] : 'and',
				'excludeanyall' 					=> isset( $db['excludeanyall'] ) ? $db['excludeanyall'] : 'any',
				'remove_by_id' 						=> isset( $db['remove_by_id'] ) ? $db['remove_by_id'] : '',
				'custom_css' 						=> isset( $db['custom_css'] ) ? $db['custom_css'] : '',
				'custom_js' 						=> isset( $db['custom_js'] ) ? $db['custom_js'] : '',
				'request_method' 					=> isset( $db['request_method'] ) ? $db['request_method'] : 'auto',
				'cron_cache_clear' 					=> isset( $db['cron_cache_clear'] ) ? $db['cron_cache_clear'] : 'unset',
				'multiplier' 						=> isset( $db['multiplier'] ) ? $db['multiplier'] : '1.25',
				'font_method' 						=> isset( $db['font_method'] ) ? $db['font_method'] : 'svg',
				'include_media_placeholder' 		=> isset( $db['include_media_placeholder'] ) ? $db['include_media_placeholder'] : true,
				'showbio' 							=> isset( $db['showbio'] ) ? $db['showbio'] : true,
				'disablelinks' 						=> isset( $db['disablelinks'] ) ? $db['disablelinks'] : false,
				'linktexttotwitter' 				=> isset( $db['linktexttotwitter'] ) ? $db['linktexttotwitter'] : false,
				'bgcolor' 							=> isset( $db['bgcolor'] ) ? $db['bgcolor'] : '#',
				'tweetbgcolor' 						=> isset( $db['tweetbgcolor'] ) ? $db['tweetbgcolor'] : '#',
				'headertextcolor' 					=> isset( $db['headertextcolor'] ) ? $db['headertextcolor'] : '#',
				'headertext' 						=> isset( $db['headertext'] ) ? $db['headertext'] : '',
				'headersize' 						=> isset( $db['headersize'] ) ? $db['headersize'] : 'small',
				'headerstyle' 						=> isset( $db['headerstyle'] ) ? $db['headerstyle'] : 'standard',
				'headerbgcolor' 					=> isset( $db['headerbgcolor'] ) ? $db['headerbgcolor'] : '#',
				'customheadertextcolor' 			=> isset( $db['customheadertextcolor'] ) ? $db['customheadertextcolor'] : '#',
				'customheadertext' 					=> isset( $db['customheadertext'] ) ? $db['customheadertext'] : __( 'We are on Twitter', 'custom-twitter-feeds' ),
				'customheadersize' 					=> isset( $db['customheadersize'] ) ? $db['customheadersize'] : 'small',
				'timezone' 							=> isset( $db['timezone'] ) ? $db['timezone'] : 'default',
				'dateformat' 						=> isset( $db['dateformat'] ) ? $db['dateformat'] : '1',
				'datecustom' 						=> isset( $db['datecustom'] ) ? $db['datecustom'] : '',
				'mtime' 							=> isset( $db['mtime'] ) ? $db['mtime'] : '',
				'htime' 							=> isset( $db['htime'] ) ? $db['htime'] : '',
				'nowtime' 							=> isset( $db['nowtime'] ) ? $db['nowtime'] : '',
				'datetextsize' 						=> isset( $db['datetextsize'] ) ? $db['datetextsize'] : 'inherit',
				'datetextweight' 					=> isset( $db['datetextweight'] ) ? $db['datetextweight'] : 'inherit',
				'datetextcolor' 					=> isset( $db['datetextcolor'] ) ? $db['datetextcolor'] : '#',
				'authortextcolor' 					=> isset( $db['authortextcolor'] ) ? $db['authortextcolor'] : '#',
				'authortextsize' 					=> isset( $db['authortextsize'] ) ? $db['authortextsize'] : 'inherit',
				'authortextweight' 					=> isset( $db['authortextweight'] ) ? $db['authortextweight'] : 'inherit',
				'logosize' 							=> isset( $db['logosize'] ) ? $db['logosize'] : 'inherit',
				'logocolor' 						=> isset( $db['logocolor'] ) ? $db['logocolor'] : '#',
				'tweettextsize' 					=> isset( $db['tweettextsize'] ) ? $db['tweettextsize'] : 'inherit',
				'tweettextweight' 					=> isset( $db['tweettextweight'] ) ? $db['tweettextweight'] : 'inherit',
				'textcolor' 						=> isset( $db['textcolor'] ) ? $db['textcolor'] : '#',
				'textlength' 						=> isset( $db['textlength'] ) ? $db['textlength'] : '280',
				'retweetedtext' 					=> isset( $db['retweetedtext'] ) ? $db['retweetedtext'] : __( 'Retweeted', 'custom-twitter-feeds' ),
				'linktextcolor' 					=> isset( $db['linktextcolor'] ) ? $db['linktextcolor'] : '#',
				'quotedauthorsize' 					=> isset( $db['quotedauthorsize'] ) ? $db['quotedauthorsize'] : 'inherit',
				'quotedauthorweight' 				=> isset( $db['quotedauthorweight'] ) ? $db['quotedauthorweight'] : 'inherit',
				'iconsize' 							=> isset( $db['iconsize'] ) ? $db['iconsize'] : 12,
				'iconcolor' 						=> isset( $db['iconcolor'] ) ? $db['iconcolor'] : '#',
				'viewtwitterlink' 					=> isset( $db['viewtwitterlink'] ) ? $db['viewtwitterlink'] : true,
				'twitterlinktext'					=> isset( $db['twitterlinktext'] ) ? $db['twitterlinktext'] : 'Twitter',
				'buttoncolor' 						=> isset( $db['buttoncolor'] ) ? $db['buttoncolor'] : '#',
				'buttonhovercolor' 					=> isset( $db['buttonhovercolor'] ) ? $db['buttonhovercolor'] : '#',
				'buttontextcolor' 					=> isset( $db['buttontextcolor'] ) ? $db['buttontextcolor'] : '#',
				'buttontext' 						=> isset( $db['buttontext'] ) ? $db['buttontext'] : __( 'Load More', 'custom-twitter-feeds' ),
				'inreplytotext' 					=> isset( $db['inreplytotext'] ) ? $db['inreplytotext'] : __( 'In Reply To', 'custom-twitter-feeds' ),
				'feedtemplate' 						=> isset( $db['feedtemplate'] ) ? $db['feedtemplate'] : 'default',
				'cardstextsize'						=> isset( $db['cardstextsize'] ) ? $db['cardstextsize'] : 'inherit',
				'cardstextcolor'					=> isset( $db['cardstextcolor'] ) ? $db['cardstextcolor'] : '#',
				'colorpalette'						=> isset( $db['colorpalette'] ) ? $db['colorpalette'] : 'inherit',
				'custombgcolor'						=> isset( $db['custombgcolor'] ) ? $db['custombgcolor'] :	'',
				'customaccentcolor'					=> isset( $db['customaccentcolor'] ) ? $db['customaccentcolor'] :	'',
				'customtextcolor1'					=> isset( $db['customtextcolor1'] ) ? $db['customtextcolor1'] :	'',
				'customtextcolor2'					=> isset( $db['customtextcolor2'] ) ? $db['customtextcolor2'] :	'',
				'customlinkcolor'					=> isset( $db['customlinkcolor'] ) ? $db['customlinkcolor'] :	'',
				'tweetpoststyle' 					=> isset( $db['tweetpoststyle'] ) ? $db['tweetpoststyle'] : 'regular',
				'tweetbgcolor' 						=> isset( $db['tweetbgcolor'] ) ? $db['tweetbgcolor'] : '#',
				'tweetcorners' 						=> isset( $db['tweetcorners'] ) ? $db['tweetcorners'] : '0',
				'tweetboxshadow' 					=> isset( $db['tweetboxshadow'] ) ? $db['tweetboxshadow'] : false,
				'tweetsepcolor' 					=> isset( $db['tweetsepcolor'] ) ? $db['tweetsepcolor'] : '#ddd',
				'tweetsepsize' 						=> isset( $db['tweetsepsize'] ) ? $db['tweetsepsize'] : '1',
				'tweetsepline' 						=> isset( $db['tweetsepline'] ) ? $db['tweetsepline'] : false
			),
			$atts
		);
		return $settings;

	}

	public static function get_public_db_settings_keys() {
		$public = array(
			'ajax_theme' 						=> isset( $db['ajax_theme'] ) ? $db['ajax_theme'] : false,
			'have_own_tokens' 					=> isset( $db['have_own_tokens'] ) ? $db['have_own_tokens'] : '',
			'use_own_consumer' 					=> isset( $db['use_own_consumer'] ) ? $db['use_own_consumer'] : '',
			'usertimeline_includereplies' 		=> isset( $db['usertimeline_includereplies'] ) ? $db['usertimeline_includereplies'] : '',
			'hometimeline_includereplies' 		=> isset( $db['hometimeline_includereplies'] ) ? $db['hometimeline_includereplies'] : '',
			'mentionstimeline_includereplies' 	=> isset( $db['mentionstimeline_includereplies'] ) ? $db['mentionstimeline_includereplies'] : '',
			'usertimeline_includeretweets' 		=> isset( $db['usertimeline_includeretweets'] ) ? $db['usertimeline_includeretweets'] : '',
			'hometimeline_includeretweets' 		=> isset( $db['hometimeline_includeretweets'] ) ? $db['hometimeline_includeretweets'] : true,
			'mentionstimeline_includeretweets' 	=> isset( $db['mentionstimeline_includeretweets'] ) ? $db['mentionstimeline_includeretweets'] : '',
			'tab' 								=> isset( $db['tab'] ) ? $db['tab'] : 'configure',
			'type' 								=> isset( $db['type'] ) ? $db['type'] : 'usertimeline',
			'usertimeline_text' 				=> isset( $db['usertimeline_text'] ) ? $db['usertimeline_text'] : '',
			'hashtag_text' 						=> isset( $db['hashtag_text'] ) ? $db['hashtag_text'] : '',
			'search_text' 						=> isset( $db['search_text'] ) ? $db['search_text'] : '',
			'lists_id' 							=> isset( $db['lists_id'] ) ? $db['lists_id'] : '',
			'num' 								=> isset( $db['num'] ) ? $db['num'] : '5',
			'lists_info' 						=> isset( $db['lists_info'] ) ? $db['lists_info'] : '{}',
			'includereplies' 					=> isset( $db['includereplies'] ) ? $db['includereplies'] : true,
			'includeretweets' 					=> isset( $db['includeretweets'] ) ? $db['includeretweets'] : false,
			'width_mobile_no_fixed' 			=> isset( $db['width_mobile_no_fixed'] ) ? $db['width_mobile_no_fixed'] : false,
			'include_replied_to' 				=> isset( $db['include_replied_to'] ) ? $db['include_replied_to'] : true,
			'include_retweeter' 				=> isset( $db['include_retweeter'] ) ? $db['include_retweeter'] : true,
			'include_author' 					=> isset( $db['include_author'] ) ? $db['include_author'] : true,
			'include_avatar' 					=> isset( $db['include_avatar'] ) ? $db['include_avatar'] : true,
			'include_author_text' 				=> isset( $db['include_author_text'] ) ? $db['include_author_text'] : true,
			'include_text' 						=> isset( $db['include_text'] ) ? $db['include_text'] : true,
			'include_date' 						=> isset( $db['include_date'] ) ? $db['include_date'] : true,
			'include_actions' 					=> isset( $db['include_actions'] ) ? $db['include_actions'] : true,
			'include_linkbox' 					=> isset( $db['include_linkbox'] ) ? $db['include_linkbox'] : true,
			'include_media' 					=> isset( $db['include_media'] ) ? $db['include_media'] : true,
			'include_twittercards' 				=> isset( $db['include_twittercards'] ) ? $db['include_twittercards'] : true,
			'include_logo' 						=> isset( $db['include_logo'] ) ? $db['include_logo'] : true,
			'include_twitterlink'				=> isset( $db['include_twitterlink'] ) ? $db['include_twitterlink'] : true,
			'creditctf' 						=> isset( $db['creditctf'] ) ? $db['creditctf'] : false,
			'showbutton' 						=> isset( $db['showbutton'] ) ? $db['showbutton'] : true,
			'showheader' 						=> isset( $db['showheader'] ) ? $db['showheader'] : true,
			'persistentcache' 					=> isset( $db['persistentcache'] ) ? $db['persistentcache'] : true,
			'selfreplies' 						=> isset( $db['selfreplies'] ) ? $db['selfreplies'] : true,
			'autores' 							=> isset( $db['autores'] ) ? $db['autores'] : true,
			'disableintents' 					=> isset( $db['disableintents'] ) ? $db['disableintents'] : false,
			'customtemplates' 					=> isset( $db['customtemplates'] ) ? $db['customtemplates'] : false,
			'shorturls' 						=> isset( $db['shorturls'] ) ? $db['shorturls'] : false,
			'curlcards' 						=> isset( $db['curlcards'] ) ? $db['curlcards'] : true,
			'sslonly' 							=> isset( $db['sslonly'] ) ? $db['sslonly'] : false,
			'disablelightbox' 					=> isset( $db['disablelightbox'] ) ? $db['disablelightbox'] : false,
			'masonry' 							=> isset( $db['masonry'] ) ? $db['masonry'] : false,
			'carousel' 							=> isset( $db['carousel'] ) ? $db['carousel'] : false,
			'carouselnavarrows' 				=> isset( $db['carouselnavarrows'] ) ? $db['carouselnavarrows'] : true,
			'carouselpag' 						=> isset( $db['carouselpag'] ) ? $db['carouselpag'] : false,
			'carouselautoplay' 					=> isset( $db['carouselautoplay'] ) ? $db['carouselautoplay'] : false,
			'autoscroll' 						=> isset( $db['autoscroll'] ) ? $db['autoscroll'] : true,
			'width' 							=> isset( $db['width'] ) ? $db['width'] : '100',
			'width_unit' 						=> isset( $db['width_unit'] ) ? $db['width_unit'] : '%',
			'height' 							=> isset( $db['height'] ) ? $db['height'] : '',
			'height_unit' 						=> isset( $db['height_unit'] ) ? $db['height_unit'] : '%',
			'class' 							=> isset( $db['class'] ) ? $db['class'] : '',
			'layout' 							=> isset( $db['layout'] ) ? $db['layout'] : 'list',
			'masonrycols' 						=> isset( $db['masonrycols'] ) ? $db['masonrycols'] : '3',
			'masonrytabletcols' 				=> isset( $db['masonrytabletcols'] ) ? $db['masonrytabletcols'] : '2',
			'masonrymobilecols' 				=> isset( $db['masonrymobilecols'] ) ? $db['masonrymobilecols'] : '1',
			'carouselrows' 						=> isset( $db['carouselrows'] ) ? $db['carouselrows'] : '1',
			'carouselcols' 						=> isset( $db['carouselcols'] ) ? $db['carouselcols'] : '3',
			'carouseltabletcols' 				=> isset( $db['carouseltabletcols'] ) ? $db['carouseltabletcols'] : '2',
			'carouselmobilecols' 				=> isset( $db['carouselmobilecols'] ) ? $db['carouselmobilecols'] : '1',
			'carouselloop' 						=> isset( $db['carouselloop'] ) ? $db['carouselloop'] : 'rewind',
			'carouselarrows' 					=> isset( $db['carouselarrows'] ) ? $db['carouselarrows'] : 'onhover',
			'carouselheight' 					=> isset( $db['carouselheight'] ) ? $db['carouselheight'] : 'tallest',
			'carouseltime' 						=> isset( $db['carouseltime'] ) ? $db['carouseltime'] : '5000',
			'maxmedia' 							=> isset( $db['maxmedia'] ) ? $db['maxmedia'] : '4',
			'imagecols' 						=> isset( $db['imagecols'] ) ? $db['imagecols'] : 'auto',
			'autoscrolldistance' 				=> isset( $db['autoscrolldistance'] ) ? $db['autoscrolldistance'] : '200',
			'includewords' 						=> isset( $db['includewords'] ) ? $db['includewords'] : '',
			'excludewords' 						=> isset( $db['excludewords'] ) ? $db['excludewords'] : '',
			'includeanyall' 					=> isset( $db['includeanyall'] ) ? $db['includeanyall'] : 'any',
			'filterandor' 						=> isset( $db['filterandor'] ) ? $db['filterandor'] : 'and',
			'excludeanyall' 					=> isset( $db['excludeanyall'] ) ? $db['excludeanyall'] : 'any',
			'remove_by_id' 						=> isset( $db['remove_by_id'] ) ? $db['remove_by_id'] : '',
			'custom_css' 						=> isset( $db['custom_css'] ) ? $db['custom_css'] : '',
			'custom_js' 						=> isset( $db['custom_js'] ) ? $db['custom_js'] : '',
			'request_method' 					=> isset( $db['request_method'] ) ? $db['request_method'] : 'auto',
			'cron_cache_clear' 					=> isset( $db['cron_cache_clear'] ) ? $db['cron_cache_clear'] : 'unset',
			'multiplier' 						=> isset( $db['multiplier'] ) ? $db['multiplier'] : '1.25',
			'font_method' 						=> isset( $db['font_method'] ) ? $db['font_method'] : 'svg',
			'include_media_placeholder' 		=> isset( $db['include_media_placeholder'] ) ? $db['include_media_placeholder'] : true,
			'showbio' 							=> isset( $db['showbio'] ) ? $db['showbio'] : true,
			'disablelinks' 						=> isset( $db['disablelinks'] ) ? $db['disablelinks'] : false,
			'linktexttotwitter' 				=> isset( $db['linktexttotwitter'] ) ? $db['linktexttotwitter'] : false,
			'bgcolor' 							=> isset( $db['bgcolor'] ) ? $db['bgcolor'] : '#',
			'tweetbgcolor' 						=> isset( $db['tweetbgcolor'] ) ? $db['tweetbgcolor'] : '#',
			'headertextcolor' 					=> isset( $db['headertextcolor'] ) ? $db['headertextcolor'] : '#',
			'headertext' 						=> isset( $db['headertext'] ) ? $db['headertext'] : '',
			'headersize' 						=> isset( $db['headersize'] ) ? $db['headersize'] : 'small',
			'headerstyle' 						=> isset( $db['headerstyle'] ) ? $db['headerstyle'] : 'standard',
			'headerbgcolor' 					=> isset( $db['headerbgcolor'] ) ? $db['headerbgcolor'] : '#',
			'customheadertextcolor' 			=> isset( $db['customheadertextcolor'] ) ? $db['customheadertextcolor'] : '#',
			'customheadertext' 					=> isset( $db['customheadertext'] ) ? $db['customheadertext'] : __( 'We are on Twitter', 'custom-twitter-feeds' ),
			'customheadersize' 					=> isset( $db['customheadersize'] ) ? $db['customheadersize'] : 'small',
			'timezone' 							=> isset( $db['timezone'] ) ? $db['timezone'] : 'default',
			'dateformat' 						=> isset( $db['dateformat'] ) ? $db['dateformat'] : '1',
			'datecustom' 						=> isset( $db['datecustom'] ) ? $db['datecustom'] : '',
			'mtime' 							=> isset( $db['mtime'] ) ? $db['mtime'] : '',
			'htime' 							=> isset( $db['htime'] ) ? $db['htime'] : '',
			'nowtime' 							=> isset( $db['nowtime'] ) ? $db['nowtime'] : '',
			'datetextsize' 						=> isset( $db['datetextsize'] ) ? $db['datetextsize'] : 'inherit',
			'datetextweight' 					=> isset( $db['datetextweight'] ) ? $db['datetextweight'] : 'inherit',
			'datetextcolor' 					=> isset( $db['datetextcolor'] ) ? $db['datetextcolor'] : '#',
			'authortextcolor' 					=> isset( $db['authortextcolor'] ) ? $db['authortextcolor'] : '#',
			'authortextsize' 					=> isset( $db['authortextsize'] ) ? $db['authortextsize'] : 'inherit',
			'authortextweight' 					=> isset( $db['authortextweight'] ) ? $db['authortextweight'] : 'inherit',
			'logosize' 							=> isset( $db['logosize'] ) ? $db['logosize'] : 'inherit',
			'logocolor' 						=> isset( $db['logocolor'] ) ? $db['logocolor'] : '#',
			'tweettextsize' 					=> isset( $db['tweettextsize'] ) ? $db['tweettextsize'] : 'inherit',
			'tweettextweight' 					=> isset( $db['tweettextweight'] ) ? $db['tweettextweight'] : 'inherit',
			'textcolor' 						=> isset( $db['textcolor'] ) ? $db['textcolor'] : '#',
			'textlength' 						=> isset( $db['textlength'] ) ? $db['textlength'] : '280',
			'retweetedtext' 					=> isset( $db['retweetedtext'] ) ? $db['retweetedtext'] : __( 'Retweeted', 'custom-twitter-feeds' ),
			'linktextcolor' 					=> isset( $db['linktextcolor'] ) ? $db['linktextcolor'] : '#',
			'quotedauthorsize' 					=> isset( $db['quotedauthorsize'] ) ? $db['quotedauthorsize'] : 'inherit',
			'quotedauthorweight' 				=> isset( $db['quotedauthorweight'] ) ? $db['quotedauthorweight'] : 'inherit',
			'iconsize' 							=> isset( $db['iconsize'] ) ? $db['iconsize'] : 12,
			'iconcolor' 						=> isset( $db['iconcolor'] ) ? $db['iconcolor'] : '#',
			'viewtwitterlink' 					=> isset( $db['viewtwitterlink'] ) ? $db['viewtwitterlink'] : true,
			'twitterlinktext'					=> isset( $db['twitterlinktext'] ) ? $db['twitterlinktext'] : 'Twitter',
			'buttoncolor' 						=> isset( $db['buttoncolor'] ) ? $db['buttoncolor'] : '#',
			'buttonhovercolor' 					=> isset( $db['buttonhovercolor'] ) ? $db['buttonhovercolor'] : '#',
			'buttontextcolor' 					=> isset( $db['buttontextcolor'] ) ? $db['buttontextcolor'] : '#',
			'buttontext' 						=> isset( $db['buttontext'] ) ? $db['buttontext'] : __( 'Load More', 'custom-twitter-feeds' ),
			'inreplytotext' 					=> isset( $db['inreplytotext'] ) ? $db['inreplytotext'] : __( 'In Reply To', 'custom-twitter-feeds' ),
			'feedtemplate' 						=> isset( $db['feedtemplate'] ) ? $db['feedtemplate'] : 'default',
			'cardstextsize'						=> isset( $db['cardstextsize'] ) ? $db['cardstextsize'] : 'inherit',
			'cardstextcolor'					=> isset( $db['cardstextcolor'] ) ? $db['cardstextcolor'] : '#',
			'colorpalette'						=> isset( $db['colorpalette'] ) ? $db['colorpalette'] : 'inherit',
			'custombgcolor'						=> isset( $db['custombgcolor'] ) ? $db['custombgcolor'] :	'',
			'customaccentcolor'					=> isset( $db['customaccentcolor'] ) ? $db['customaccentcolor'] :	'',
			'customtextcolor1'					=> isset( $db['customtextcolor1'] ) ? $db['customtextcolor1'] :	'',
			'customtextcolor2'					=> isset( $db['customtextcolor2'] ) ? $db['customtextcolor2'] :	'',
			'customlinkcolor'					=> isset( $db['customlinkcolor'] ) ? $db['customlinkcolor'] :	'',
			'tweetpoststyle' 					=> isset( $db['tweetpoststyle'] ) ? $db['tweetpoststyle'] : 'regular',
			'tweetbgcolor' 						=> isset( $db['tweetbgcolor'] ) ? $db['tweetbgcolor'] : '#',
			'tweetcorners' 						=> isset( $db['tweetcorners'] ) ? $db['tweetcorners'] : '0',
			'tweetboxshadow' 					=> isset( $db['tweetboxshadow'] ) ? $db['tweetboxshadow'] : false,
			'tweetsepcolor' 					=> isset( $db['tweetsepcolor'] ) ? $db['tweetsepcolor'] : '#ddd',
			'tweetsepsize' 						=> isset( $db['tweetsepsize'] ) ? $db['tweetsepsize'] : '1',
			'tweetsepline' 						=> isset( $db['tweetsepline'] ) ? $db['tweetsepline'] : false
		);

		return array_keys( $public );
	}
}

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
	public function __construct( $atts ) {
		include_once( CTF_URL . '/inc/CtfFeed.php' );
		include_once( CTF_URL . '/inc/CtfFeedPro.php' );

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
}
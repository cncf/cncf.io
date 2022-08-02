<?php
/**
 * The Feed Templates Settings Trait
 *
 * It has the default settings for the feed templates for variou feed types
 *
 * @since 2.0
 */

namespace TwitterFeed\Admin\Traits;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


trait CTF_Feed_Templates_Settings {

	/**
	 * Add feed settings depending on feed templates
	 *
	 * @since 2.0
	 */
	public static function get_feed_settings_by_feed_templates( $settings ) {
        $feedTemplate = isset( $settings['feedtemplate'] ) ? $settings['feedtemplate'] : 'default';
        switch ($feedTemplate) {
            case 'default':
                $settings = self::get_default_feedtemplate_settings( $settings );
                break;
            case 'masonry_cards':
                $settings = self::get_masonry_cards_feedtemplate_settings( $settings );
                break;
            case 'simple_carousel':
                $settings = self::get_simple_carousel_feedtemplate_settings( $settings );
                break;
            case 'simple_cards':
                $settings = self::get_simple_cards_feedtemplate_settings( $settings );
                break;
            case 'showcase_carousel':
                $settings = self::get_showcase_carousel_feedtemplate_settings( $settings );
                break;
            case 'latest_tweet':
                $settings = self::get_latest_tweet_feedtemplate_settings( $settings );
                break;
            case 'widget':
                $settings = self::get_widget_feedtemplate_settings( $settings );
                break;
        }
        return $settings;

	}

    /**
     * Default Settings
     *
     * @since 2.0
     */
    public static function get_default_feedtemplate_settings( $settings ) {
        $settings['layout']             = 'list';
        $settings['num']                = 4;
        $settings['showbutton']         = true;
        $settings['autoscroll']         = false;
        $settings['disablelightbox']    = false;
        $settings['showheader']             = true;
        $settings['headerstyle']        = 'standard';
        $settings['showbio']                = true;
        $settings['tweetpoststyle']     = 'regular';
        $settings['tweetsepline']       = true;
        $settings['tweetsepcolor']      = '#DDD';
        $settings['tweetsepsize']       = '1';

        return $settings;
    }

    /**
     * Get masonry_cards settings
     *
     * @since 2.0
     */
    public static function get_masonry_cards_feedtemplate_settings( $settings ) {
        $settings['layout']                 = 'masonry';
        $settings['num']                    = 9;
        $settings['masonrycols']            = 3;
        $settings['masonrytabletcols']      = 2;
        $settings['masonrymobilecols']      = 1;
        $settings['showbutton']             = true;
        $settings['autoscroll']             = false;
        $settings['disablelightbox']        = false;
        $settings['showheader']             = true;
        $settings['headerstyle']            = 'standard';
        $settings['showbio']                = true;
        $settings['tweetpoststyle']         = 'boxed';
        $settings['tweetbgcolor']           = '#FFF';
        $settings['tweetcorners']           = 2;
        $settings['tweetboxshadow']         = true;
        return $settings;
    }

    /**
     * Get simple_carousel settings
     *
     * @since 2.0
     */
    public static function get_simple_carousel_feedtemplate_settings( $settings ) {
        $settings['layout']                 = 'carousel';
        $settings['num']                    = 6;
        $settings['carouselrows']           = 1;
        $settings['carouselcols']           = 3;
        $settings['carouseltabletcols']     = 2;
        $settings['carouselmobilecols']     = 1;

        $settings['carouselloop']           = 'rewind';
        $settings['carouselheight']         = 'tallest';
        $settings['carouseltime']           = 3000;
        $settings['carouselarrows']         = 'onhover';
        $settings['carouselnavarrows']      = true;
        $settings['carouselpag']            = true;
        $settings['carouselautoplay']       = true;

        $settings['showheader']             = true;
        $settings['headerstyle']            = 'text';
        $settings['customheadertext']         = __( 'Find us on Twitter', 'custom-twitter-feeds' );
        $settings['customheadersize']         = 'medium';

        $settings['showbutton']             = true;
        $settings['autoscroll']             = false;
        $settings['disablelightbox']        = false;
        $settings['tweetpoststyle']         = 'boxed';
        $settings['tweetbgcolor']           = '#FFF';
        $settings['tweetcorners']           = 2;
        $settings['tweetboxshadow']         = true;

        return $settings;
    }

    /**
     * Get simple_cards settings
     *
     * @since 2.0
     */
    public static function get_simple_cards_feedtemplate_settings( $settings ) {
        $settings['layout']             = 'list';
        $settings['num']                = 4;
        $settings['showbutton']         = true;
        $settings['autoscroll']         = false;
        $settings['disablelightbox']    = false;
        $settings['showheader']             = true;
        $settings['headerstyle']        = 'standard';
        $settings['showbio']            = true;

        $settings['tweetpoststyle']     = 'boxed';
        $settings['tweetbgcolor']       = '#FFF';
        $settings['tweetcorners']       = 2;
        $settings['tweetboxshadow']     = true;
        return $settings;
    }

    /**
     * Get showcase_carousel settings
     *
     * @since 2.0
     */
    public static function get_showcase_carousel_feedtemplate_settings( $settings ) {
        $settings['layout']                 = 'carousel';
        $settings['num']                    = 6;
        $settings['carouselrows']           = 1;
        $settings['carouselcols']           = 1;
        $settings['carouseltabletcols']     = 1;
        $settings['carouselmobilecols']     = 1;

        $settings['carouselloop']           = 'rewind';
        $settings['carouselheight']         = 'tallest';
        $settings['carouseltime']           = 3000;
        $settings['carouselarrows']         = 'onhover';
        $settings['carouselnavarrows']      = true;
        $settings['carouselpag']            = true;
        $settings['carouselautoplay']       = true;

        $settings['showheader']             = false;
        $settings['showbutton']             = true;
        $settings['autoscroll']             = false;
        $settings['disablelightbox']         = false;

        $settings['tweetpoststyle']         = 'regular';
        $settings['tweetsepline']           = true;
        $settings['tweetsepcolor']          = '#DDD';
        $settings['tweetsepsize']           = '1';

        return $settings;
    }

    /**
     * Get latest_tweet settings
     *
     * @since 2.0
     */
    public static function get_latest_tweet_feedtemplate_settings( $settings ) {
        $settings['layout']                 = 'list';
        $settings['num']                    = 1;
        $settings['showbutton']             = true;
        $settings['autoscroll']             = false;
        $settings['disablelightbox']        = false;
        $settings['showheader']             = false;

        $settings['tweetpoststyle']         = 'regular';
        $settings['tweetsepline']           = true;
        $settings['tweetsepcolor']          = '#DDD';
        $settings['tweetsepsize']           = '1';

        return $settings;
    }

    /**
     * Get widget settings
     *
     * @since 2.0
     */
    public static function get_widget_feedtemplate_settings( $settings ) {
        $settings['layout']                 = 'list';
        $settings['num']                    = 4;
        $settings['showbutton']             = true;
        $settings['autoscroll']             = false;
        $settings['disablelightbox']        = false;
        $settings['showheader']             = true;
        $settings['headerstyle']            = 'standard';
        $settings['showbio']                = true;
        $settings['tweetpoststyle']         = 'boxed';
        $settings['tweetbgcolor']           = '#FFF';
        $settings['tweetcorners']           = 2;
        $settings['tweetboxshadow']         = true;

        return $settings;
    }



}
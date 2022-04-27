<?php
/**
 * Styling Tab
 * Contains different controls for the individual Elements
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Tabs;

if(!defined('ABSPATH'))	exit;

class CTF_Styling_Tab{

	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_author(){
		return [
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'include_avatar',
				'label' 			=> __( 'Avatar Image', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'include_author_text',
				'label' 			=> __( 'Author Text', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'authortextsize',
				'layout' 			=> 'half',
				'child' 			=> true,
				'conditionHide'		=> true,
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-twitter-feed' ),
				'condition'			=> ['include_author_text' => [true]],
				'stacked'			=> 'true',
				'style'				=> ['.ctf-author-name' => 'font-size:{{value}}px!important;'],
				'options'			=> CTF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'authortextcolor',
				'condition'			=> ['include_author_text' => [true]],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'child' 			=> true,
				'heading' 			=> __( 'Color', 'custom-twitter-feed' ),
				'style'				=> ['.ctf-author-name' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			],
		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_tweet_text(){
		return [
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'Text', 'custom-twitter-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'tweettextsize',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-twitter-feed' ),
				'stacked'			=> 'true',
				'style'				=> ['.ctf-tweet-text' => 'font-size:{{value}}px!important;'],
				'options'			=> CTF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'textcolor',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-twitter-feed' ),
				'style'				=> ['.ctf-tweet-text' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'textlength',
				'fieldSuffix' 		=> 'characters',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Max Length', 'custom-twitter-feed' ),
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'disablelinks',
				'label' 			=> __( 'Enable links in Tweet Text', 'custom-twitter-feeds' ),
				'description' 		=> __( 'If enabled, it will convert urls, hashtags and mentions into clickable links', 'custom-twitter-feeds' ),
				'descriptionPosition' => 'bottom',
				'alignDescription' => true,
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> false,
					'disabled'	=> true
				]
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'linktextcolor',
				'condition'			=> ['disablelinks' => [false]],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'child' 			=> true,
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-twitter-feed' ),
				'style'				=> ['.ctf-tweet-text a' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			],

			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],

			[
				'type' 				=> 'switcher',
				'id' 				=> 'linktexttotwitter',
				'label' 			=> __( 'Link Tweet Text to Twitter', 'custom-twitter-feeds' ),
				'description' 		=> __( 'If enabled, this links the tweet text to the original tweet on Twitter', 'custom-twitter-feeds' ),
				'descriptionPosition' => 'bottom',
				'alignDescription' => true,
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],

		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_tweet_date(){
		return [
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'heading',
				'stacked'			=> 'true',
				'heading' 			=> __( 'Format', 'custom-twitter-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'dateformat',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'options'			=> CTF_Builder_Customizer_Tab::get_date_format_options()
			],
			[
				'type' 				=> 'text',
				'id' 				=> 'datecustom',
				'condition'			=> ['dateformat' => ['custom']],
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'placeholder'		=> 'Eg. F j, Y',
			],
			[
				'type' 				=> 'heading',
				'stacked'			=> 'true',
				'heading' 			=> '',
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 25,
				'bottom' 			=> 5,
			],
			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'Text', 'custom-twitter-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'datetextsize',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-twitter-feed' ),
				'stacked'			=> 'true',
				'style'				=> ['.ctf-tweet-meta a' => 'font-size:{{value}}px!important;'],
				'options'			=> CTF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'datetextcolor',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-twitter-feed' ),
				'style'				=> ['.ctf-tweet-meta a' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			]
		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_tweet_actions(){
		return [
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'heading',
				'stacked'			=> 'true',
				'heading' 			=> __( 'Icons', 'custom-twitter-feed' ),
				'description' 			=> __( 'Customize icons for like, retweet and reply', 'custom-twitter-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'iconsize',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-twitter-feed' ),
				'stacked'			=> 'true',
				'style'				=> ['.ctf-tweet-actions a' => 'font-size:{{value}}px!important;'],
				'options'			=> CTF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'iconcolor',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-twitter-feed' ),
				'style'				=> ['.ctf-tweet-actions a' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'viewtwitterlink',
				'label' 			=> __( 'View on Twitter link', 'custom-twitter-feeds' ),
				'description' 		=> __( 'Toggle the “Twitter” link below each tweet', 'custom-twitter-feeds' ),
				'descriptionPosition' => 'bottom',
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'text',
				'id' 				=> 'twitterlinktext',
				'condition'			=> ['viewtwitterlink' => [true]],
				'conditionHide'		=> true,
				'child'				=> true,
				'stacked'			=> true,
				'description' 			=> __( 'Customize Text', 'custom-twitter-feeds' ),
			],
		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_quote_tweet(){
		return [
			[
				'type' 				=> 'select',
				'id' 				=> 'quotedauthorsize',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-twitter-feed' ),
				'style'				=> ['.ctf-quoted-tweet, .ctf-quoted-tweet-text' => 'font-size:{{value}}px!important;line-height:1em;'],
				'options'			=> CTF_Builder_Customizer_Tab::get_text_size_options()
			],
		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_media(){
		return [
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'heading',
				'stacked'			=> 'true',
				'heading' 			=> __( 'Media Layout', 'custom-twitter-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'maxmedia',
				'layout' 			=> 'half',
				'ajaxAction'    	=> 'feedFlyPreview',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Max Visible Media', 'custom-twitter-feed' ),
				'tooltip' 			=> __( 'Max Visible Media', 'custom-twitter-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'imagecols',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Media Columns', 'custom-twitter-feed' ),
				'tooltip' 			=> __( 'Media Columns', 'custom-twitter-feed' ),
				'stacked'			=> 'true',
				'options'			=> [
					'auto' => __( 'Auto', 'custom-twitter-feed' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
				]
			],
		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_replies(){
		return [
		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_retweet(){
		return [
			[
				'type' 				=> 'separator',
				'top' 				=> 30,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'include_retweeter',
				'label' 			=> __( '“Retweeted” text', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'include_replied_to',
				'label' 			=> __( '“In Reply to” text', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_twitter_cards(){
		return [
				[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'heading',
				'stacked'			=> 'true',
				'heading' 			=> __( 'Text', 'custom-twitter-feed' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'cardstextsize',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-twitter-feed' ),
				'stacked'			=> 'true',
				'style'				=> ['.ctf-tc-summary-info *' => 'font-size:{{value}}px!important;'],
				'options'			=> CTF_Builder_Customizer_Tab::get_text_size_options()
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'cardstextcolor',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-twitter-feed' ),
				'style'				=> ['.ctf-tc-summary-info *' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			],
		];
	}
	/**
	 *
	 * @since 2.0
	 * @return array
	*/
	static function post_styling_twitter_logo(){
		return [
		];
	}


}

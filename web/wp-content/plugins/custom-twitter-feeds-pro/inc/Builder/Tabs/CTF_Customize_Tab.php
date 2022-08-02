<?php
/**
 * Customizer Tab
 *
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Tabs;
use TwitterFeed\Builder\CTF_Feed_Builder;
if(!defined('ABSPATH'))	exit;


class CTF_Customize_Tab{


	/**
	 * Get Customize Tab Sections
	 *
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @return array
	*/
	static function get_sections(){
		return [

			'customize_template' => [
				'heading' 	=> __( 'Template', 'custom-twitter-feeds' ),
				'icon' 		=> 'feed_template',
				'controls'	=> self::get_settings_feedtemplates_controls()
			],
			'customize_feedlayout' => [
				'heading' 	=> __( 'Feed Layout', 'custom-twitter-feeds' ),
				'icon' 		=> 'feed_layout',
				'controls'	=> self::get_customize_feedlayout_controls()
			],
			'customize_colorschemes' => [
				'heading' 	=> __( 'Color Scheme', 'custom-twitter-feeds' ),
				'icon' 		=> 'color_scheme',
				'controls'	=> self::get_customize_colorscheme_controls()
			],
			'customize_sections' => [
				'heading' 	=> __( 'Sections', 'custom-twitter-feeds' ),
				'isHeader' 	=> true,
			],
			'customize_header' => [
				'heading' 	=> __( 'Header', 'custom-twitter-feeds' ),
				'description' 	=>  '<br/>',
				'icon' 		=> 'header',
				'separator'	=> 'none',
				'controls'	=> self::get_customize_header_controls()
			],
			'customize_posts' => [
				'heading' 			=> __( 'Tweets', 'custom-twitter-feeds' ),
				'description' 			=> __( 'Hide or Show individual elements of a post or edit their options', 'custom-twitter-feeds' ),
				'icon' 				=> 'twitter',
				'controls'			=> self::get_customize_tweets_controls(),
				'nested_sections' 	=> [
					'tweet_styles' => [
						'heading' 			=> __( 'Tweet Style', 'custom-twitter-feeds' ),
						'icon' 				=> 'color_scheme',
						'isNested'			=> 'true',
						'separator'			=> 'none',
						'controls'			=> self::get_nested_tweet_style_controls(),
					],
					'individual_elements' => [
						'heading' 			=> __( 'Edit Individual Elements', 'custom-twitter-feeds' ),
						'icon' 				=> 'article',
						'isNested'			=> 'true',
						'separator'			=> 'none',
						'controls'			=> self::get_nested_individual_elements_controls(),
					],
				]
			],
			'customize_loadmorebutton' => [
				'heading' 	=> __( 'Load More Button', 'custom-twitter-feeds' ),
				'description' 	=>  '<br/>',
				'icon' 		=> 'load_more',
				'separator'	=> 'none',
				'controls'	=> self::get_customize_loadmorebutton_controls()
			],
			'customize_lightbox' => [
				'heading' 		=> __( 'Lightbox', 'custom-twitter-feeds' ),
				'description' 	=>  '<br/>',
				'icon' 			=> 'lightbox',
				'separator'		=> 'none',
				'controls'		=> self::get_customize_lightbox_controls()
			]

		];
	}


	/**
	 * Get Customize Tab Templates
	 * @since 2.0
	 * @return array
	*/
	static function get_settings_feedtemplates_controls(){
		return [
			[
				'type' 				=> 'customview',
				'viewId'			=> 'feedtemplate'
			]
		];
	}



	/**
	 * Get Customize Tab Feed Layout Section
	 * @since 2.0
	 * @return array
	*/
	static function get_customize_feedlayout_controls(){
		return [
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'layout',
				'heading' 	=> __( 'Layout', 'custom-twitter-feeds' ),
				//'ajaxAction'    => 'feedFlyPreview',
				'options'	=> [
					[
						'value' 		=> 'list',
						'icon' 			=> 'list',
						'label' 		=> __( 'List', 'custom-twitter-feeds' )
					],
					[
						'value' => 'masonry',
						'icon' => 'masonry',
						'label' => __( 'Masonry', 'custom-twitter-feeds' )
					],
					[
						'value' => 'carousel',
						'icon' => 'carousel',
						'label' => __( 'Carousel', 'custom-twitter-feeds' )
					]
				]
			],

			//Carousel Settings
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 7,
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
			],
			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'Carousel Settings', 'custom-twitter-feeds' ),
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'carouselnavarrows',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'label' 			=> __( 'Navigation Arrows', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				#'disabledInput'		=> true,
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'carouselpag',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'label' 			=> __( 'Pagination Dots', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				#'disabledInput'		=> true,
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'carouselautoplay',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'label' 			=> __( 'Autoplay', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				#'disabledInput'		=> true,
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'carouselrows',
				'layout' 			=> 'half',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'ajaxAction'		=> 'feedFlyPreview',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'heading' 			=> __( 'Rows', 'custom-twitter-feeds' ),
				'options'			=> [
					1 => '1',
					2 => '2'
				]
			],

			[
				'type' 				=> 'select',
				'id' 				=> 'carouselloop',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Loop Type', 'custom-twitter-feeds' ),
				'stacked'			=> 'true',
				'options'			=> [
					'rewind' => __( 'Rewind', 'custom-twitter-feeds' ),
					'infinity' => __( 'Infinity', 'custom-twitter-feeds' ),
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'carouselheight',
				'condition'			=> ['layout' => ['carousel']],
				'strongHeading'		=> 'false',
				'layout' 			=> 'half',
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'heading' 			=> __( 'Height of Carousel', 'custom-twitter-feeds' ),
				'options'			=> [
					'tallest' => __( 'Set to tallest post', 'custom-twitter-feeds' ),
					'clickexpand' => __( 'Set to shortest post, button to expand', 'custom-twitter-feeds' ),
					'auto' => __( 'Automatically adjust height (forces 1 column)', 'custom-twitter-feeds' ),
				]
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'carouseltime',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'fieldSuffix' 		=> 'ms',
				'heading' 		=> __( 'Interval Time', 'custom-twitter-feeds' ),
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'carouselarrows',
				'condition'			=> ['layout' => ['carousel']],
				'strongHeading'		=> 'false',
				'layout' 			=> 'half',
				'conditionHide'		=> true,
				'stacked'			=> 'true',
				'heading' 			=> __( 'Navigation Arrows', 'custom-twitter-feeds' ),
				'options'			=> [
					'none' => __( 'Hide arrows', 'custom-twitter-feeds' ),
					'onhover' => __( 'On Hover', 'custom-twitter-feeds' ),
					'below' => __( 'Below feed', 'custom-twitter-feeds' ),
				]
			],

			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'condition'			=> ['layout' => ['masonry']],
				'conditionHide'		=> true,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'Columns', 'custom-twitter-feeds' ),
				'condition'			=> ['layout' => ['carousel','masonry']],
				'conditionHide'		=> true,
			],

			//Masonry Cols
			[
				'type' 				=> 'select',
				'id' 				=> 'masonrycols',
				'condition'			=> ['layout' => ['masonry']],
				'conditionHide'		=> true,
				'icon' 				=> 'desktop',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Desktop', 'custom-twitter-feeds' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'masonrytabletcols',
				'condition'			=> ['layout' => ['masonry']],
				'conditionHide'		=> true,
				'icon' 				=> 'tablet',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Tablet', 'custom-twitter-feeds' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'masonrymobilecols',
				'condition'			=> ['layout' => ['masonry']],
				'conditionHide'		=> true,
				'icon' 				=> 'mobile',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Mobile', 'custom-twitter-feeds' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				]
			],

			//Carousel Cols
			[
				'type' 				=> 'select',
				'id' 				=> 'carouselcols',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'icon' 				=> 'desktop',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Desktop', 'custom-twitter-feeds' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'carouseltabletcols',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'icon' 				=> 'tablet',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Tablet', 'custom-twitter-feeds' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'carouselmobilecols',
				'condition'			=> ['layout' => ['carousel']],
				'conditionHide'		=> true,
				'icon' 				=> 'mobile',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Mobile', 'custom-twitter-feeds' ),
				'stacked'			=> 'true',
				'options'			=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				]
			],



			//Number & Feight
			[
				'type' 				=> 'separator',
				'top' 				=> 15,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'num',
				'min' 				=> 1,
				'ajaxAction'		=> 'feedFlyPreview',
				'strongHeading'		=> 'true',
				'placeholder' 		=> '20',
				'heading' 			=> __( 'Number of tweets to display', 'custom-twitter-feeds' ),
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'height',
				'fieldSuffix' 		=> 'px',
				'strongHeading'		=> 'true',
				'heading' 			=> __( 'Feed Height', 'custom-twitter-feeds' ),
				'placeholder' 		=> '400',
				'style'				=> ['.ctf-fixed-height' => 'height:{{value}}px!important;overflow:auto;'],
			],
			[
				'type' 				=> 'notice',
				'stacked'			=> 'true',
				'strongHeading'		=> 'false',
				'noticeIcon' 		=> 'article',
				'containerAction'   => 'navigateToStyle',
				'noticeDescription'  => __( '<strong>Tweak Tweet Styles</strong><br/>Change post background, border radius, shadow etc.', 'custom-twitter-feeds' ),
			],

		];
	}

	/**
	 * Get Customize Tab Color Scheme Section
	 * @since 2.0
	 * @return array
	*/
	static function get_customize_colorscheme_controls(){
		$feed_id = isset($_GET['feed_id']) ? $_GET['feed_id'] : '';
		$color_scheme_array = [
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'colorpalette',
				'separator'	=> 'bottom',
				'options'	=> [
					[
						'value' => 'inherit',
						'label' => __( 'Inherit from Theme', 'custom-twitter-feeds' )
					],
					[
						'value' => 'light',
						'icon' => 'sun',
						'label' => __( 'Light', 'custom-twitter-feeds' )
					],
					[
						'value' => 'dark',
						'icon' => 'moon',
						'label' => __( 'Dark', 'custom-twitter-feeds' )
					],
					[
						'value' => 'custom',
						'icon' => 'cog',
						'label' => __( 'Custom', 'custom-twitter-feeds' )
					]
				]
			],

			//Custom Color Palette
			[
				'type' 				=> 'heading',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Custom Palette', 'custom-twitter-feeds' ),
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'custombgcolor',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Background', 'custom-twitter-feeds' ),
				'style'         => 	[ '.ctf_palette_custom_' . $feed_id . ' .ctf-item, .ctf_palette_custom_' . $feed_id . ' .ctf-header' => 'background:{{value}}!important;' ],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'customaccentcolor',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Accent', 'custom-twitter-feeds' ),
				'style'         => 	[ '.ctf_palette_custom_' . $feed_id . ' .ctf-corner-logo' => 'color:{{value}}!important;' ],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'customtextcolor1',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Text', 'custom-twitter-feeds' ),
				'style'         => 	[ '.ctf_palette_custom_' . $feed_id . ' .ctf-author-name, .ctf_palette_custom_' . $feed_id . ' .ctf-tweet-text' => 'color:{{value}}!important;' ],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'customtextcolor2',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Text 2', 'custom-twitter-feeds' ),
				'style'         => 	[ '.ctf_palette_custom_' . $feed_id . ' .ctf-author-screenname' => 'color:{{value}}!important;' ],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'customlinkcolor',
				'condition'			=> ['colorpalette' => ['custom']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Link', 'custom-twitter-feeds' ),
				'style'         => 	[ '.ctf_palette_custom_' . $feed_id . ' .ctf-tweet-text a' => 'color:{{value}}!important;' ],
				'stacked'			=> 'true'
			]
		];

		$color_overrides = [];

		$color_overrides_array = [];
		return  array_merge($color_scheme_array,$color_overrides_array);
	}

	/**
	 * Get Customize Tab Header Section
	 * @since 2.0
	 * @return array
	*/
	static function get_customize_header_controls(){
		return [
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showheader',
				'label' 			=> __( 'Enable', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => [true]],
				'top' 				=> 20,
				'bottom' 			=> 10,
			],
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'headerstyle',
				'condition'	=> ['showheader' => [true]],
				'heading' 	=> __( 'Header Style', 'custom-twitter-feeds' ),
				'options'	=> [
					[
						'value' => 'standard',
						'label' => __( 'Standard', 'custom-twitter-feeds' )
					],
					[
						'value' => 'text',
						'label' => __( 'Text', 'custom-twitter-feeds' )
					]
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showheader' => [true]],
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showbio',
				'label' 			=> __( 'Show Bio', 'custom-twitter-feeds' ),
				'condition'			=> ['showheader' => [true], 'headerstyle' => ['standard']],
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'conditionHide'	=> true,
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],

			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'Text', 'custom-twitter-feeds' ),
				'conditionHide'	=> true,
				'condition'			=> ['showheader' => [true], 'headerstyle' => ['text']],
			],
			[
				'type' 				=> 'textarea',
				'id' 				=> 'customheadertext',
				'placeholder'		=> __( 'Add Custom bio', 'custom-twitter-feeds' ),
				'condition'			=> ['showheader' => [true], 'headerstyle' => ['text']],
				'stacked'			=> 'true',
				'conditionHide'	=> true,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'customheadersize',
				'condition'			=> ['showheader' => [true], 'headerstyle' => ['text']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'stacked'			=> 'true',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Size', 'custom-twitter-feeds' ),
				'options'			=> [
					'small' => __( 'Small', 'custom-twitter-feeds' ),
					'medium' => __( 'Medium', 'custom-twitter-feeds' ),
					'large' => __( 'Large', 'custom-twitter-feeds' ),
				]
			],

			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'customheadertextcolor',
				'condition'			=> ['showheader' => [true], 'headerstyle' => ['text']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Color', 'custom-twitter-feeds' ),
				'style'				=> ['.ctf-header-type-text' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			],






		];
	}

	/**
	 * Get Customize Tab Tweets Section
	 * @since 2.0
	 * @return array
	*/
	static function get_customize_tweets_controls(){
		return [

		];
	}

	/**
	 * Get Customize Tab Tweet Style Section
	 * @since 2.0
	 * @return array
	*/
	static function get_nested_tweet_style_controls(){
		return [
			[
				'type' 		=> 'toggleset',
				'id' 		=> 'tweetpoststyle',
				'heading' 	=> __( 'Post Type', 'custom-twitter-feeds' ),
				'options'	=> [
					[
						'value' => 'boxed',
						'icon' => 'article',
						'label' => __( 'Boxed', 'custom-twitter-feeds' )
					],
					[
						'value' => 'regular',
						'icon' => 'union',
						'label' => __( 'Regular', 'custom-twitter-feeds' )
					]
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 10,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'heading',
				'condition'			=> ['tweetpoststyle' => ['boxed']],
				'conditionHide'		=> true,
				'heading' 			=> __( 'Individual Properties', 'custom-twitter-feeds' ),
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'tweetbgcolor',
				'condition'			=> ['tweetpoststyle' => ['boxed']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'icon' 				=> 'background',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Background', 'custom-twitter-feeds' ),
				'style'				=> ['.ctf-item' => 'background-color:{{value}};'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'tweetcorners',
				'condition'			=> ['tweetpoststyle' => ['boxed']],
				'conditionHide'		=> true,
				'fieldSuffix' 		=> 'px',
				'layout' 			=> 'half',
				'icon' 				=> 'corner',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Border Radius', 'custom-twitter-feeds' ),
				'style'				=> ['.ctf-item' => 'border-radius:{{value}}px;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'condition'			=> ['tweetpoststyle' => ['boxed']],
				'conditionHide'		=> true,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'checkbox',
				'id' 				=> 'tweetboxshadow',
				'condition'			=> ['tweetpoststyle' => ['boxed']],
				'conditionHide'		=> true,
				'label' 			=> __( 'Box Shadow', 'custom-twitter-feeds' ),
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'stacked'			=> 'true'
			],

			[
				'type' 				=> 'switcher',
				'id' 				=> 'tweetsepline',
				'condition'			=> ['tweetpoststyle' => ['regular'], 'layout' => ['list', 'masonry']],
				'label' 			=> __( 'Divider', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'conditionHide'		=> true,
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],

			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'tweetsepcolor',
				'condition'			=> ['tweetpoststyle' => ['regular'], 'tweetsepline' => [true], 'layout' => ['list', 'masonry']],
				'conditionHide'		=> true,
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'child' 			=> true,
				'heading' 			=> __( 'Color', 'custom-twitter-feeds' ),
				'icon' 				=> 'background',
				'style'				=> ['.ctf-item, .ctf-header' => 'border-bottom-color:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'tweetsepsize',
				'condition'			=> ['tweetpoststyle' => ['regular'], 'tweetsepline' => [true], 'layout' => ['list', 'masonry']],
				'conditionHide'		=> true,
				'child' 			=> true,
				'fieldSuffix' 		=> 'px',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'icon' 				=> 'strokeThickness',
				'heading' 			=> __( 'Thickness', 'custom-twitter-feeds' ),
				'style'				=> ['.ctf-item, .ctf-header' => 'border-bottom-width:{{value}}px!important;border-bottom-style:solid!important;'],
				'stacked'			=> 'true'
			]
		];
	}

	/**
	 * Get Customize Tab Individual Elements Nested Section
	 * @since 2.0
	 * @return array
	*/
	static function get_nested_individual_elements_controls(){
		return [
			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_author',
				'value'		=> 'include_author',
				'checkBoxAction' => true,
				'header' 	 => true,
				'label' 	=> __( 'Author', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_author',
					'separator'			=> 'none',
					'heading' 			=> __( 'Author', 'custom-twitter-feeds' ),
					'description' 		=> __( 'The author name and avatar image that\'s shown at the top of each timeline post', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_author(),
				]
			],
			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_text',
				'value'		=> 'include_text',
				'checkBoxAction' => true,
				'label' 	=> __( 'Tweet Text', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_tweet_text',
					'separator'			=> 'none',
					'heading' 			=> __( 'Tweet Text', 'custom-twitter-feeds' ),
					'description' 		=> __( 'The text within the tweet', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_tweet_text(),
				]
			],
			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_date',
				'value'		=> 'include_date',
				'checkBoxAction' => true,
				'label' 	=> __( 'Date', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_tweet_date',
					'separator'			=> 'none',
					'heading' 			=> __( 'Date', 'custom-twitter-feeds' ),
					'description' 		=> __( 'The date of the tweet', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_tweet_date(),
				]
			],
			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_actions',
				'value'		=> 'include_actions',
				'checkBoxAction' => true,
				'label' 	=> __( 'Tweet Actions', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_tweet_actions',
					'separator'			=> 'none',
					'heading' 			=> __( 'Tweet Actions', 'custom-twitter-feeds' ),
					'description' 		=> __( 'The "View on Twitter" and icons for like, reply and retweet at the bottom of each tweet', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_tweet_actions(),
				]
			],
			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_linkbox',
				'value'		=> 'include_linkbox',
				'checkBoxAction' => true,
				'label' 	=> __( 'Quote Tweet', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_quote_tweet',
					'separator'			=> 'none',
					'heading' 			=> __( 'Quote Tweet', 'custom-twitter-feeds' ),
					'description' 		=> __( 'The quoted tweet within a retweet', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_quote_tweet(),
				]
			],

			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_media',
				'value'		=> 'include_media',
				'checkBoxAction' => true,
				'label' 	=> __( 'Media (images, videos, GIFs)', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_media',
					'separator'			=> 'none',
					'heading' 			=> __( 'Media', 'custom-twitter-feeds' ),
					'description' 		=> __( 'Images, videos or GIFs in a tweet', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_media(),
				]
			],

			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_retweeter',
				'value'		=> 'include_retweeter',
				'checkBoxAction' => true,
				'label' 	=> __( 'Retweet/Reply Subtext', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_retweet',
					'separator'			=> 'none',
					'heading' 			=> __( 'Retweet/Reply Subtext', 'custom-twitter-feeds' ),
					'description' 		=> __( 'The small copy that appears over tweets mentioning if they are replies or retweets', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_retweet(),
				]
			],

			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_twittercards',
				'value'		=> 'include_twittercards',
				'checkBoxAction' => true,
				'label' 	=> __( 'Twitter Cards (Link previews)', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_twitter_cards',
					'separator'			=> 'none',
					'heading' 			=> __( 'Twitter Cards (Link Previews)', 'custom-twitter-feeds' ),
					'description' 		=> __( 'Twitter Cards are rich visual previews of the link in your Tweet', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_twitter_cards(),
				]
			],

			[
				'type' 		=> 'checkboxsection',
				'id'		=> 'include_logo',
				'value'		=> 'include_logo',
				'checkBoxAction' => true,
				'label' 	=> __( 'Twitter Logo', 'custom-twitter-feeds' ),
				'separator'			=> 'bottom',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				],
				'section' 	=> [
					'id' 				=> 'post_styling_logos',
					'separator'			=> 'none',
					'heading' 			=> __( 'Twitter Logo', 'custom-twitter-feeds' ),
					'description' 		=> __( 'Twitter Logo', 'custom-twitter-feeds' ),
					'controls'			=> CTF_Styling_Tab::post_styling_twitter_logo(),
				]
			],

		];
	}






	/**
	 * Get Customize Tab Load More Button Section
	 * @since 2.0
	 * @return array
	*/
	static function get_customize_loadmorebutton_controls(){
		return [
			[
				'type' 				=> 'switcher',
				'id' 				=> 'showbutton',
				'label' 			=> __( 'Enable', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showbutton' => [true]],
				'top' 				=> 20,
				'bottom' 			=> 5,
			],
			[
				'type' 				=> 'text',
				'id' 				=> 'buttontext',
				'condition'			=> ['showbutton' => [true]],
				//'conditionHide'		=> true,
				'strongHeading'		=> 'true',
				'heading' 			=> __( 'Text', 'custom-twitter-feeds' ),
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showbutton' => [true]],
				'top' 				=> 15,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'heading',
				'heading' 			=> __( 'Color', 'custom-twitter-feeds' ),
				'condition'			=> ['showbutton' => [true]],
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'buttoncolor',
				'condition'			=> ['showbutton' => [true]],
				'layout' 			=> 'half',
				'icon' 				=> 'background',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Background', 'custom-twitter-feeds' ),
				'style'				=> ['.ctf-more' => 'background:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'buttonhovercolor',
				'condition'			=> ['showbutton' => [true]],
				'layout' 			=> 'half',
				'icon' 				=> 'cursor',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Hover State', 'custom-twitter-feeds' ),
				'style'				=> ['.ctf-more:hover' => 'background:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'colorpicker',
				'id' 				=> 'buttontextcolor',
				'condition'			=> ['showbutton' => [true]],
				'layout' 			=> 'half',
				'icon' 				=> 'text',
				'strongHeading'		=> 'false',
				'heading' 			=> __( 'Text', 'custom-twitter-feeds' ),
				'style'				=> ['.ctf-more' => 'color:{{value}}!important;'],
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'separator',
				'condition'			=> ['showbutton' => [true]],
				'top' 				=> 15,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'autoscroll',
				'condition'			=> ['showbutton' => [true], 'layout' => ['list', 'masonry']],
				'switcherTop' 			=> true,
				//'conditionHide'		=> true,
				'heading' 			=> __( 'Infinite Scroll', 'custom-twitter-feeds' ),
				'description' 		=> __( 'This will load more posts automatically when the users reach the end of the feed', 'custom-twitter-feeds' ),
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'layout' 			=> 'half',
				'reverse'			=> 'true',
				'options'			=> [
					'enabled'	=> true,
					'disabled'	=> false
				]
			],
			[
				'type' 				=> 'number',
				'id' 				=> 'autoscrolldistance',
				'condition'			=> ['showbutton' => [true],'autoscroll' => [true]],
				'conditionHide'		=> true,
				'strongHeading'		=> false,
				'stacked'			=> 'true',
				'layout'			=> 'half',
				'placeholder'		=> '200',
				'child' 			=> true,
				'fieldSuffix' 		=> 'px',
				'heading' 		=> __( 'Trigger Distance', 'custom-twitter-feeds' ),
			],
			[
				'type' 				=> 'notice',
				'condition'			=> ['showbutton' => [true],'autoscroll' => [true]],
				'conditionHide'		=> true,
				'strongHeading'		=> false,
				'stacked'			=> 'true',
				'layout'			=> 'half',
				'child' 			=> true,
				'noticeIcon' 		=> 'info',
				'noticeDescription'  => __( 'If you add a height to your feed then a scroll bar will be added and the Trigger Distance will use the bottom of the feed. If no height is set then the Trigger Distance will use the bottom of the page.', 'custom-twitter-feeds' ),
			],

		];
	}



	/**
	 * Get Customize Tab LightBox Section
	 * @since 2.0
	 * @return array
	*/
	static function get_customize_lightbox_controls(){
		return [
			[
				'type' 				=> 'switcher',
				'id' 				=> 'disablelightbox',
				'label' 			=> __( 'Enable', 'custom-twitter-feeds' ),
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'options'			=> [
					'enabled'	=> false,
					'disabled'	=> true
				]
			]
		];
	}


}
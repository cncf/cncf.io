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


class CTF_Settings_Tab{

	public static $should_disable_pro_features = false;

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
		self::$should_disable_pro_features = ctf_license_handler()->should_disable_pro_features;

		return [
			'settings_feedtype_sources' => [
				'heading' 	=> __( 'Sources', 'custom-twitter-feeds' ),
				'icon' 		=> 'article',
				'controls'	=> self::get_settings_sources_controls()
			],
			'settings_filters' => [
				'heading' 	=> __( 'Filters', 'custom-twitter-feeds' ),
				'icon' 		=> 'filter',
				'separator'	=> 'none',
				'description' 	=> !self::$should_disable_pro_features ? null : __( 'Upgrade to Pro to show or hide tweets that meet a specific criteria, or are specified by an ID.', 'custom-twitter-feeds' ),
				'proLabel'		=> !self::$should_disable_pro_features ? null : true,
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'controls'	=> self::get_settings_filters_controls()
			],
			'empty_sections' => [
				'heading' 	=> '',
				'isHeader' 	=> true,
			],
			'settings_advanced' => [
				'heading' 	=> __( 'Advanced', 'custom-twitter-feeds' ),
				'icon' 		=> 'cog',
				'separator'	=> 'none',
				'controls'	=> self::get_settings_advanced_controls()
			]
		];
	}



	/**
	 * Get Settings Tab Feed Type Sources
	 * @since 2.0
	 * @return array
	*/
	static function get_settings_sources_controls(){
		return [
			[
				'type' 				=> 'customview',
				'viewId'			=> 'sources'
			],
		];
	}

	/**
	 * Get Settings Tab Filters Section
	 * @since 2.0
	 * @return array
	*/
	static function get_settings_filters_controls(){
		return [
			[
				'type' 				=> 'separator',
				'top' 				=> 30,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'switcher',
				'id' 				=> 'includereplies',
				'label' 			=> __( 'Include Replies', 'custom-twitter-feeds' ),
				'ajaxAction'    => 'feedFlyPreview',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'advancedFilters',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
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
				'id' 				=> 'includeretweets',
				'label' 			=> __( 'Include Retweets', 'custom-twitter-feeds' ),
				'ajaxAction'    => 'feedFlyPreview',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'advancedFilters',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'reverse'			=> 'true',
				'stacked'			=> 'true',
				'labelStrong'		=> 'true',
				'ajaxAction'    => 'feedFlyPreview',
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
				'type' 				=> 'textarea',
				'id' 				=> 'includewords',
				'heading' 			=> __( 'Allowed Words', 'custom-twitter-feed' ),
				'placeholder' 			=> __( 'Add words here to only show tweets containing these words', 'custom-twitter-feed' ),
				'tooltip' 			=> __( 'Allowed Words', 'custom-twitter-feed' ),
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'advancedFilters',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'ajaxAction'    => 'feedFlyPreview',
				'labelStrong'		=> 'true',
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'textarea',
				'id' 				=> 'excludewords',
				'ajaxAction'    => 'feedFlyPreview',
				'heading' 			=> __( 'Blocked Words', 'custom-twitter-feed' ),
				'placeholder' 			=> __( 'Add words here to only show tweets containing these words', 'custom-twitter-feed' ),
				'tooltip' 			=> __( 'Blocked Words', 'custom-twitter-feed' ),
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'advancedFilters',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'labelStrong'		=> 'true',
				'stacked'			=> 'true'
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'includeanyall',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'ajaxAction'    => 'feedFlyPreview',
				'heading' 			=> __( 'Show tweets that contain', 'custom-twitter-feeds' ),
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'advancedFilters',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'options'			=> [
					'any' => __( 'Any of the "Allowed words"', 'custom-twitter-feeds' ),
					'all' => __( 'All of the "Allowed words"', 'custom-twitter-feeds' ),
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'filterandor',
				'layout' 			=> 'half',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'reverse'			=> 'true',
				'ajaxAction'    => 'feedFlyPreview',
				'heading' 			=> __( 'do&nbsp;not&nbsp;contain', 'custom-twitter-feeds' ),
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'advancedFilters',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'options'			=> [
					'and' => __( 'and', 'custom-twitter-feeds' ),
					'or' => __( 'or', 'custom-twitter-feeds' ),
				]
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'excludeanyall',
				'strongHeading'		=> 'false',
				'stacked'			=> 'true',
				'ajaxAction'    => 'feedFlyPreview',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'advancedFilters',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'options'			=> [
					'any' => __( 'Any of the "Blocked words"', 'custom-twitter-feeds' ),
					'all' => __( 'All of the "Blocked words"', 'custom-twitter-feeds' ),
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 15,
				'bottom' 			=> 15,
			],
			[
				'type' 				=> 'textarea',
				'id' 				=> 'remove_by_id',
				'ajaxAction'    => 'feedFlyPreview',
				'checkExtensionDimmed'	=> !self::$should_disable_pro_features ? null : 'advancedFilters',
				'checkExtensionPopup' => !self::$should_disable_pro_features ? null : 'advancedFilters',
				'disabledInput'		=> !self::$should_disable_pro_features ? null : true,
				'heading' 			=> __( 'Hide specific tweets', 'custom-twitter-feed' ),
				'tooltip' 			=> __( 'Hide specific tweets', 'custom-twitter-feed' ),
				'labelStrong'		=> 'true',
				'stacked'			=> 'true'
			],
		];
	}



	/**
	 * Get Settings Tab Advanced Section
	 * @since 2.0
	 * @return array
	*/
	static function get_settings_advanced_controls(){
		return [
			[
				'type' 				=> 'separator',
				'top' 				=> 30,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'select',
				'id' 				=> 'multiplier',
				'strongHeading'		=> 'true',
				'heading' 			=> __( 'Tweet Multiplier', 'custom-twitter-feeds' ),
				'tooltip' 			=> __( 'If your feed excludes reply tweets (this is automatic in hashtag/search feeds), the correct number of tweets may not show up. Increasing this number will increase the number of tweets retrieved but will also increase the load time for the feed as well.', 'custom-twitter-feeds' ),
				'options'			=> [
					'1.25' => '1.25',
					'2' => '2',
					'3' => '3',
				]
			],
			[
				'type' 				=> 'separator',
				'top' 				=> 20,
				'bottom' 			=> 10,
			],
			[
				'type' 				=> 'textarea',
				'heading' 			=> __( 'Add Custom CSS Class', 'custom-twitter-feeds' ),
				'id' 				=> 'class',
				'strongHeading'		=> 'true',
				'tooltip'		=> __( 'Add one or more CSS classes, example:  class1, class2', 'custom-twitter-feeds' ),
				'placeholder'		=> __( 'Add one or more CSS classes, example:  class1, class2', 'custom-twitter-feeds' ),
			],
		];
	}



}

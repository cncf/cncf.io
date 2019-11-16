<?php
/**
 * This file handles registering the add-on settings and rendering the settings tab
 *
 * @since 1.0
 */


/**
 * Handles the registration of settings and sections, and the rendering of the settings page.
 *
 * @since 1.0
 */
final class WPRSS_FTP_Settings {

/*===== CONSTANTS AND STATIC MEMBERS ======================================================================*/

	/**
	 * The name of the options array, as stored in the database.
	 */
	const OPTIONS_NAME = 'wprss_settings_ftp';

	/**
	 * FTP Settings tab slug
	 */
	const TAB_SLUG = 'ftp_settings';

	/**
	 * The Singleton instance
	 */
	private static $instance;


/*===== CONSTRUCTOR AND SINGLETON GETTER ==================================================================*/


	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		if ( self::$instance === NULL ) {
			# Initialize
			add_action( 'wprss_admin_init', array( $this, 'register_settings' ) );

            /*
             * @since 3.7.4
             * Making sure that FeedsAPI can never be selected
             */
            add_action('wprss_ftp_option_value_full_text_rss_service', array($this, 'feedsapi_setting_fallback'), 10, 3);
		} else {
			wp_die( __( 'WPRSS_FTP_Settings class is a singleton class and cannot be redeclared.', WPRSS_TEXT_DOMAIN ) );
		}
	}

	/**
	 * Returns the singleton instance
	 *
	 * @return WPRSS_FTP_Settings
	 */
	public static function get_instance() {
		if ( self::$instance === NULL ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


/*===== SETTINGS GETTERS =================================================================================*/

	/**
	 * Returns the default settings.
	 *
	 * @return array An associative array of key => value setting pairs.
	 * @since 1.0
	 */
	public function get_defaults() {
		$wp_comment_status = get_option( 'default_comment_status', 'open' );
		return apply_filters('wprss_ftp_default_settings', array(
			'post_site'					=>	'',						# The post site in which to import posts
			'post_type'					=>	'post',					# The Post type to use
			'post_status'				=>	'draft',				# The status to assign to imported posts
			'post_format'				=>	'standard',				# The format to assign to imported posts
			'post_date'					=>	'original',				# The post's publish date
			'comment_status'			=>	$wp_comment_status,		# The post's comment status
			'source_link'				=>	'false',				# Whether or not to link back to the original post
			'source_link_singular'		=>  'false',				# Whether or not to only show the source link on singular posts
			'source_link_text'			=>	'This *post* was originally published on **this site**',
			'force_full_content'		=>	'false',				# The flag that determines whether or not get forcefully retrieval the full feed content.
			'import_excerpt'            => 'false',                 # Whether or not to import the post excerpt.
			'post_word_limit'			=>	'',						# The default word limit for post content. Empty value disables the limit
			'canonical_link'			=>	'true',				    # The default value for whether or not to include a rel="canonical" link in the page head for imported posts

			'word_limit_enabled'		=>	'general',				# 'true' | 'false' | 'general'. Falls back to 'general'.
			'word_limit'				=>	'0',					# The word limit. 0 for disabled.
			'trimming_type'				=>	'db',					# The trimming type. 'db' or 'excerpt'. Falls back to 'db'.

			'def_author'				=>	'',						# The default author to use for imported posts
			'author_fallback_method'	=>	'existing',				# The method to use when the feed author is not found
			'fallback_author'			=>	WPRSS_FTP_Utils::get_admin( 'user_login' ), # The author to fall back upon when 'using existing'
			'no_author_found'			=>	'fallback',				# The action to take when no author is found. Either 'fallback' or 'skip'

			'post_taxonomy'				=>	'category',				# The default post taxonomy
			'post_terms'				=>	array(),				# The default post taxonomy terms
			'post_auto_tax_terms'		=>	FALSE, 					# The default setting for whether or not to auto create tax terms for feed categories
			'post_tags'					=>	'',						# The default tags to attach to posts

			'use_featured_image'		=>	'true',					# Whether or not to use featured images
			'featured_image'			=>	'first',				# Which image to use as a featured image. 'first', 'last' or 'thumb'
			'fallback_to_feed_image'	=>	'true',					# Whether or not to fallback to the image provided by the feed
			'remove_ft_image'			=>	'false',				# Whether or not to remove the chosen featured image from post content
			'must_have_ft_image'		=>	'false',				# Whether or not posts must have a featured image to be imported
			'image_min_width'			=>	'80',					# The minimum width of images to import
			'image_min_height'			=>	'80',					# The minimum height of images to import
			'save_images_locally'		=>	'true',					# If true, images are saved locally in the media. If false, they are linked from the source.
			'save_all_image_sizes'      =>  'true',                 # If true, image `srcset` attributes are processed
			# and all image sizes are saved

			'post_language'				=>	'en',					# The post language - only applies if WPML is active

			'post_prepend'				=>	'',						# The default text to prepend to posts
			'post_append'				=>	'',						# The default text to append to posts

            'disable_visual_editor'     => false,                   # Whether to disable the visual editors by default

			'extraction_rules'			=>	array(),				# The CSS selectors for the elements to remove from post content
			'extraction_rules_types'	=>	array(),				# The manipulation types for each extraction rule

			'affiliate_link'			=>	'false',				# The affiliate link suffix to add
			'allow_embedded_content'	=>	'false',				# Allowing of embedded content in posts

			'full_text_rss_service'		=>	'free',					# Full text RSS service type.

			'user_feed_namespaces'		=>	array(					# The feed namespaces added by the user.
				'names'	=>	array(),
				'urls'	=>	array()
			),
			'custom_fields'				=>	array(),				# The custom field mappings default value
			//'allow_local_requests'		=>	'false',				# Allowing requests to URLs, which would normally be blocked by wp_http_validate_url()

			'legacy_enabled'			=>	'true',					# Allows the use of wprss_feed_item when set to TRUE

			'taxonomies'				=>	'',

			'powerpress_enabled'        => 'false'
		));
	}


	/**
	 * Returns the default value for the given setting.
	 * Will throw an exception if the name given is not found.
	 *
	 * @param $option	The name of the option whose default to return.
	 * @return mixed	The value of the option for the given option name
	 * @since 1.0
	 */
	public function get_default( $option ) {
		# Add code ...
		$all = $this->get_defaults();
		return $all[$option];
	}


	/**
	 * Returns an option of sub-option form the database.
	 *
	 * @param array 	Optional. The key of the sub option to retrieve.
	 * @param mixed		The value to return if the option was not found. Ommit or
	 *					use '!default' to get the default value from get_default()
	 * @return mixed 	The value of the (sub)option with the key(s)
	 * @since 1.0
	 */
	public function get( $sub_option = NULL, $default = '!default' ) {
		$option = get_option( self::OPTIONS_NAME, $this->get_defaults() );
		if ( $sub_option !== NULL ) {
			if ( array_key_exists( $sub_option, $option ) )
                return $this->_normalizeOptionValue($option[$sub_option], $sub_option);
			elseif ( strtolower( $default ) === '!default' )
				return $this->_normalizeOptionValue($this->get_default( $sub_option ), $sub_option);
			else return $this->_normalizeOptionValue($default, $sub_option);
		} else {
			$final_options = array();
			foreach( $this->get_defaults() as $key => $value ) {
				if ( isset( $option[$key] ) )
					$value = $this->_normalizeOptionValue($option[$key], $key);
				$final_options[ $key ] = $value;
			}
			return $final_options;
		}
	}

    /**
     * Normalizes an option's value before it is returned.
     *
     * @since 3.7.4
     *
     * @param mixed $value The value to normalize.
     * @param string $name The name of the option.
     * @param int|string|null $postId The ID of the post, to which the option belongs, if any.
     * @return mixed The normalized value.
     */
    protected function _normalizeOptionValue($value, $name, $postId = null)
    {
        $value = apply_filters('wprss_ftp_option_value', $value, $name, $postId);
        return apply_filters('wprss_ftp_option_value_' . $name, $value, $name, $postId);
    }


	/**
	 * Returns the final, computed options for a feed.
	 * These settings are the general settings, merged against the feed's own meta data settings.
	 *
	 * @since 1.0
	 */
	public function get_computed_options( $post_id ) {
		$post = get_post( $post_id );

		$meta_fields = WPRSS_FTP_Meta::get_instance()->get_meta_fields('all');
		$meta = array();
		foreach ( $meta_fields as $key => $value ) {
			$meta_value = WPRSS_FTP_Meta::get_instance()->get_meta( $post_id, $key );
			if ( ( is_string( $meta_value ) && strlen( $meta_value ) > 0 ) || is_array( $meta_value ) )
				$meta[$key] = $meta_value;
		}
		$options = $this->get();

		return wp_parse_args( $meta, $options );
	}


#== SETTINGS REGISTRATION =====================================================================================

    public function get_section_docs_link_template() {
        return apply_filters('wprss_ftp_section_docs_link_template', '<a class="wprss-section-tooltip-handle fa fa-info-circle %3$s" href="%1$s" title="%2$s" target="_blank"></a>');
    }

    public function get_section_docs_link_url($sectionCode = null, $default = null) {
        $docUrls = apply_filters('wprss_ftp_section_docs_link_urls', array(
            'wprss_settings_ftp_general_section'            => 'https://kb.wprssaggregator.com/article/305-how-to-set-up-feed-to-posts-general-plugin-settings',
            'wprss_settings_ftp_taxonomies_section'         => 'https://kb.wprssaggregator.com/article/306-how-to-set-up-feed-to-posts-taxonomy-options-categories-tags-etc',
            'wprss_settings_ftp_authors_section'            => 'https://kb.wprssaggregator.com/article/307-how-to-set-up-feed-to-posts-author-options',
            'wprss_settings_ftp_images_section'             => 'https://kb.wprssaggregator.com/article/308-how-to-set-up-feed-to-posts-image-options',
            'wprss_settings_ftp_full_text_section'          => 'https://kb.wprssaggregator.com/article/96-an-introduction-to-full-text-rss-feeds',
            'wprss_settings_ftp_namespaces_section'         => 'https://kb.wprssaggregator.com/article/311-how-to-set-up-feed-to-posts-custom-field-mapping',
            'wprss_settings_ftp_url_shortening_section'     => 'https://kb.wprssaggregator.com/article/309-how-to-set-up-feed-to-posts-url-shortening-option',
        ));

        if (is_null($sectionCode)) {
            return $docUrls;
        }

        return isset($docUrls[$sectionCode])
            ? $docUrls[$sectionCode]
            : $default;
    }

    public function get_section_docs_link_html($sectionCode) {
        $template = $this->get_section_docs_link_template();
        $class = '';

        if (!($linkUrl = $this->get_section_docs_link_url($sectionCode))) {
            return apply_filters('wprss_ftp_section_docs_link_html', null, $sectionCode, $template, $linkUrl, $class);
        }

        return apply_filters(
            'wprss_ftp_section_docs_link_html',
            sprintf($template, $linkUrl, __('Click here to view documentation for this section in a new tab', WPRSS_TEXT_DOMAIN), $class),
            $sectionCode,
            $template,
            $linkUrl,
            $class
        );
    }

	/**
	 * Registers the settings page, sections and fields.
	 *
	 * @since 1.0
	 */
	public function register_settings() {
		// Register Page
		register_setting(
			self::OPTIONS_NAME,							// A settings group name.
			self::OPTIONS_NAME,							// The name of an option to sanitize and save.
			array( $this, 'validate_settings' )			// The function that sanitizes the option's value.
		);

		// Register Sections

		add_settings_section(
			'wprss_settings_ftp_general_section',		// ID to identify this section
			__( 'General Settings', WPRSS_TEXT_DOMAIN ) // Title to be displayed on the administration page
                . $this->get_section_docs_link_html('wprss_settings_ftp_general_section'), // Documentation link
			array( $this, 'render_general_section' ),	// Callback that renders the description of the section
			'wprss_settings_ftp'						// Page on which to add this section of options
		);

		add_settings_section(
			'wprss_settings_ftp_taxonomies_section',		// ID to identify this section
			__( 'Taxonomies', WPRSS_TEXT_DOMAIN )           // Title to be displayed on the administration page
                . $this->get_section_docs_link_html('wprss_settings_ftp_taxonomies_section'), // Documentation link
			array( $this, 'render_taxonomies_section' ),	// Callback that renders the description of the section
			'wprss_settings_ftp'							// Page on which to add this section of options
		);

		add_settings_section(
			'wprss_settings_ftp_authors_section',		// ID to identify this section
			__( 'Authors', WPRSS_TEXT_DOMAIN )          // Title to be displayed on the administration page
                . $this->get_section_docs_link_html('wprss_settings_ftp_authors_section'), // Documentation link
			array( $this, 'render_authors_section' ),	// Callback that renders the description of the section
			'wprss_settings_ftp'						// Page on which to add this section of options
		);

		add_settings_section(
			'wprss_settings_ftp_images_section',		// ID to identify this section
			__( 'Images', WPRSS_TEXT_DOMAIN )           // Title to be displayed on the administration page
                . $this->get_section_docs_link_html('wprss_settings_ftp_images_section'), // Documentation link
			array( $this, 'render_images_section' ),	// Callback that renders the description of the section
			'wprss_settings_ftp'						// Page on which to add this section of options
		);

		add_settings_section(
			'wprss_settings_ftp_full_text_section',		// ID to identify this section
			__( 'Full Text RSS', WPRSS_TEXT_DOMAIN )    // Title to be displayed on the administration page
                . $this->get_section_docs_link_html('wprss_settings_ftp_full_text_section'), // Documentation link
			array( $this, 'render_full_text_section' ),	// Callback that renders the description of the section
			'wprss_settings_ftp'						// Page on which to add this section of options
		);

		add_settings_section(
			'wprss_settings_ftp_namespaces_section',	// ID to identify this section
			__( 'Custom Namespaces', WPRSS_TEXT_DOMAIN )// Title to be displayed on the administration page
                . $this->get_section_docs_link_html('wprss_settings_ftp_namespaces_section'), // Documentation link
			array( $this, 'render_namespaces_section' ),// Callback that renders the description of the section
			'wprss_settings_ftp'						// Page on which to add this section of options
		);


		#== GENERAL SECTION ==========

		// POST TYPE
		add_settings_field(
			'wprss-settings-ftp-post-type',				// ID used to identify the field
			__( 'Post Type', WPRSS_TEXT_DOMAIN ),					// The label to the left of the option element
			array( $this, 'render_post_type' ),			// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);

		// POST STATUS
		add_settings_field(
			'wprss-settings-ftp-post-status',			// ID used to identify the field
			__( 'Post Status', WPRSS_TEXT_DOMAIN ),				// The label to the left of the option element
			array( $this, 'render_post_status' ),		// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);

		// POST FORMAT
		add_settings_field(
			'wprss-settings-ftp-post-format',			// ID used to identify the field
			__( 'Post Format', WPRSS_TEXT_DOMAIN ),				// The label to the left of the option element
			array( $this, 'render_post_format' ),		// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);

		// POST DATE
		add_settings_field(
			'wprss-settings-ftp-post-date',				// ID used to identify the field
			__( 'Post Date', WPRSS_TEXT_DOMAIN ),					// The label to the left of the option element
			array( $this, 'render_post_date' ),			// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);

		// ENABLE COMMENTS
		add_settings_field(
			'wprss-settings-ftp-comment-status',		// ID used to identify the field
			__( 'Enable Comments', WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_comment_status' ),	// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);

		// SOURCE LINK
		add_settings_field(
			'wprss-settings-ftp-source-link',			// ID used to identify the field
			__( 'Link back to source?', WPRSS_TEXT_DOMAIN ),		// The label to the left of the option element
			array( $this, 'render_source_link' ),		// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);

		// SOURCE LINK ONLY FOR SINGULAR POSTS
		add_settings_field(
			'wprss-settings-ftp-source-link-singular',			// ID used to identify the field
			__( 'Only add source link when viewing singular posts ', WPRSS_TEXT_DOMAIN ),		// The label to the left of the option element
			array( $this, 'render_source_link_singular' ),		// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);

		// SOURCE LINK TEXT
		add_settings_field(
			'wprss-settings-ftp-source-link-text',		// ID used to identify the field
			__( 'Source Link Text', WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_source_link_text' ),	// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);

		// OPEN LINKS BEHAVIOUR
		/* Removed setting - not needed in add-on
		add_settings_field(
			'wprss-settings-ftp-open-dd',				// ID used to identify the field
			__( 'Open Links Behaviour', WPRSS_TEXT_DOMAIN ),		// The label to the left of the option element
			'wprss_setting_open_dd_callback',			// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);
		*/

		// SET LINKS NO FOLLOW
		/* Removed setting - not needed in add-on
		add_settings_field(
			'wprss-settings-ftp-follow-dd',				// ID used to identify the field
			__( 'Set links as nofollow', WPRSS_TEXT_DOMAIN ),		// The label to the left of the option element
			'wprss_setting_follow_dd_callback',			// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);
		*/

		// VIDEO LINKS
		/* Removed setting - not needed in add-on
		add_settings_field(
			'wprss-settings-ftp-video-links',			// ID used to identify the field
			__( 'For video feed items use', WPRSS_TEXT_DOMAIN ),	// The label to the left of the option element
			'wprss_setting_video_links_callback',		// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'		// The section to which this field belongs
		);
		*/

		// FORCE FULL CONTENT
		/* Removed setting - not needed in add-on
		add_settings_field(
			'wprss-settings-ftp-force-full-content',		// ID used to identify the field
			__( 'Force full Content', WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_force_full_content' ),	// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'			// The section to which this field belongs
		);
		*/

		// WORD LIMIT
		add_settings_field(
			'wprss-settings-ftp-word-limit',				// ID used to identify the field
			__( 'Word Limit', WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_word_limit' ),			// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'			// The section to which this field belongs
		);

		// TRIMMING TYPE
		add_settings_field(
			'wprss-settings-ftp-trimming-type',				// ID used to identify the field
			__( 'Trimming Type', WPRSS_TEXT_DOMAIN ),		// The label to the left of the option element
			array( $this, 'render_trimming_type' ),			// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'			// The section to which this field belongs
		);


		// CANONICAL LINK
		add_settings_field(
			'wprss-settings-ftp-canonical-link',			// ID used to identify the field
			__( 'Canonical Link', WPRSS_TEXT_DOMAIN ),		// The label to the left of the option element
			array( $this, 'render_canonical_link' ),		// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_general_section'			// The section to which this field belongs
		);



		#== TAXONOMIES SECTION ==========

		// POST TAXONOMY
		add_settings_field(
			'wprss-settings-ftp-post-taxonomy',					// ID used to identify the field
			__( "Taxonomy", WPRSS_TEXT_DOMAIN ),				// The label to the left of the option element
			array( $this, 'render_post_taxonomy' ),				// The function that renders the option interface
			'wprss_settings_ftp',								// The page on which this option will be displayed
			'wprss_settings_ftp_taxonomies_section'				// The section to which this field belongs
		);


		// POST TERMS
		/*
		add_settings_field(
			'wprss-settings-ftp-post-terms',					// ID used to identify the field
			__( "Post Terms", WPRSS_TEXT_DOMAIN ),						// The label to the left of the option element
			array( $this, 'render_post_terms' ),				// The function that renders the option interface
			'wprss_settings_ftp',								// The page on which this option will be displayed
			'wprss_settings_ftp_taxonomies_section'				// The section to which this field belongs
		);*/


		#== AUTHORS SECTION ==========

		// DEFAULT AUTHOR
		add_settings_field(
			'wprss-settings-ftp-def-author',			// ID used to identify the field
			__( 'Author for imported items', WPRSS_TEXT_DOMAIN ),		// The label to the left of the option element
			array( $this, 'render_def_author' ),		// The function that renders the option interface
			'wprss_settings_ftp',						// The page on which this option will be displayed
			'wprss_settings_ftp_authors_section'		// The section to which this field belongs
		);


		// FALLBACK AUTHOR METHOD
		/*
		add_settings_field(
			'wprss-settings-ftp-author-fallback-method',		// ID used to identify the field
			__( "If feed author does not exist", WPRSS_TEXT_DOMAIN ),		// The label to the left of the option element
			array( $this, 'render_author_fallback_method' ),	// The function that renders the option interface
			'wprss_settings_ftp',								// The page on which this option will be displayed
			'wprss_settings_ftp_authors_section'				// The section to which this field belongs
		);
		*/


		#== IMAGES SECTION ==========

		// SAVE IMAGES LOCALLY
		add_settings_field(
			'wprss-settings-ftp-save-images-locally',		// ID used to identify the field
			__( "Save Images Locally", WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_save_images_locally' ),	// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_images_section'				// The section to which this field belongs
		);

		// IMAGE MINIMUM SIZE
		add_settings_field(
			'wprss-settings-ftp-image-min-size',			// ID used to identify the field
			__( "Image minimum size", WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_image_minimum_size' ),	// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_images_section'				// The section to which this field belongs
		);

		// USE FEATURED IMAGE
		add_settings_field(
			'wprss-settings-ftp-use-featured-image',		// ID used to identify the field
			__( 'Use a featured image', WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_use_featured_image' ),	// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_images_section'				// The section to which this field belongs
		);


		// FEATURED IMAGE TO USE
		add_settings_field(
			'wprss-settings-ftp-featured-image',			// ID used to identify the field
			__( "Featured image to use", WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_featured_image' ),		// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_images_section'				// The section to which this field belongs
		);


		// FALLBACK TO FEED IMAGE
		add_settings_field(
			'wprss-settings-ftp-fallback-to-feed-image',		// ID used to identify the field
			__( 'Fallback to Feed Image', WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_fallback_to_feed_image' ),	// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_images_section'				// The section to which this field belongs
		);



		// ALLOW LOCAL REQUESTS
		/*
		add_settings_field(
			'wprss-settings-ftp-allow-local-requests',		// ID used to identify the field
			__( 'Allow local requests', WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_allow_local_requests' ),		// The function that renders the option interface
			'wprss_settings_ftp',					// The page on which this option will be displayed
			'wprss_settings_ftp_images_section'			// The section to which this field belongs
		);*/


		#== FULL TEXT RSS SECTION ==========

		add_settings_field(
			'wprss-settings-ftp-full-text-rss-service',		// ID used to identify the field
			__( "Full Text RSS service", WPRSS_TEXT_DOMAIN ),			// The label to the left of the option element
			array( $this, 'render_full_text_rss_service' ),	// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_full_text_section'			// The section to which this field belongs
		);


		#== CUSTOM NAMESPACES SECTION ==========

		add_settings_field(
			'wprss-settings-ftp-custom-namespaces',			// ID used to identify the field
			__( "Namespaces", WPRSS_TEXT_DOMAIN ),					// The label to the left of the option element
			array( $this, 'render_custom_namespaces' ),		// The function that renders the option interface
			'wprss_settings_ftp',							// The page on which this option will be displayed
			'wprss_settings_ftp_namespaces_section'			// The section to which this field belongs
		);

		#== LICENSE SETTINGS ==========
		if ( version_compare(WPRSS_VERSION, '4.5', '<') ) {
			add_settings_section(
				'wprss_settings_ftp_licenses_section',
				__( 'Feed to Post License', WPRSS_TEXT_DOMAIN ),
				array( $this, 'license_section_callback' ),
				'wprss_settings_license_keys'
			);

			add_settings_field(
				'wprss-settings-license',
				__( 'License Key', WPRSS_TEXT_DOMAIN ),
				array( $this, 'license_callback' ),
				'wprss_settings_license_keys',
				'wprss_settings_ftp_licenses_section'
			);

			add_settings_field(
				'wprss-settings-license-activation',
				__( 'Activate License', WPRSS_TEXT_DOMAIN ),
				array( $this, 'license_activation_callback' ),
				'wprss_settings_license_keys',
				'wprss_settings_ftp_licenses_section'
			);
		}

		// Add tab to Aggregator Settings page
		add_action( 'wprss_options_tabs', array( $this, 'add_tab' ) );
		// Add action to register field sections to tab
		add_action( 'wprss_add_settings_fields_sections', array( $this, 'render_settings_page' ), 10, 1 );

		do_action('wprss_ftp_after_settings_register', $this);
	}


#== SECTION RENDERERS ===============================================================================


	/**
	 * General Section
	 * @since 1.0
	 */
	public function render_general_section() {
		echo '<p>' . __( 'General settings about imported posts', WPRSS_TEXT_DOMAIN ) . '</p>';
	}

	/**
	 * Authors Section
	 * @since 1.0
	 */
	public function render_authors_section() {
		echo '<p>' . __( 'Settings about post authors and users.', WPRSS_TEXT_DOMAIN ) . '</p>';
	}


	/**
	 * Taxonomies Section
	 * @since 1.0
	 */
	public function render_taxonomies_section() {
		echo '<p>' . __( 'Settings about post taxonomies and tags.', WPRSS_TEXT_DOMAIN ) . '</p>';
	}


	/**
	 * Images Section
	 * @since 1.0
	 */
	public function render_images_section() {
		echo '<p>' . __( 'Configure how to handle images found in feeds.', WPRSS_TEXT_DOMAIN ) . '</p>';
	}


	/**
	 * Full Text RSS Section
	 * @since 1.0
	 */
	public function render_full_text_section() {
		echo '<p>' . __( 'Configure your full text RSS options.', WPRSS_TEXT_DOMAIN ) . '</p>';
	}


	/**
	 * Custom Namespaces Section
	 * @since 1.0
	 */
	public function render_namespaces_section() {
		echo '<p>' . __( 'Manage your RSS feed Namespaces.', WPRSS_TEXT_DOMAIN ) . '</p>';
	}


#== FIELD RENDERERS =================================================================================

	#== General Section ========================

	/**
	 * Renders the post_type dropdown
	 *
	 * @since 1.0
	 */
	public function render_post_type( $args ) {
		$post_type = $this->get( 'post_type' );
		$all_post_types = self::get_post_types();
		echo WPRSS_FTP_Utils::array_to_select( $all_post_types, array(
			'id'		=>	'ftp-post-type',
			'name'		=>	self::OPTIONS_NAME . '[post_type]',
			'selected'	=>	$post_type,
		));
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX . 'post_type' );
	}


	/**
	 * Renders the post_status dropdown
	 *
	 * @since 1.0
	 */
	public function render_post_status( $args ) {
		$post_status = $this->get( 'post_status' );
		$post_statuses = self::get_post_statuses();
		echo WPRSS_FTP_Utils::array_to_select( $post_statuses, array(
			'id'		=>	'ftp-post-status',
			'name'		=>	self::OPTIONS_NAME . '[post_status]',
			'selected'	=>	$post_status,
		));
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'post_status' );
	}


	/**
	 * Renders the post_format dropdown
	 *
	 * @since 1.0
	 */
	public function render_post_format( $args ) {
		$post_format = $this->get( 'post_format' );
		$post_formats = self::get_post_formats();
		echo WPRSS_FTP_Utils::array_to_select( $post_formats, array(
			'id'		=>	'ftp-post-format',
			'name'		=>	self::OPTIONS_NAME . '[post_format]',
			'selected'	=>	$post_format,
		));
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'post_format' );
	}


	/**
	 * Renders the post_date dropdown
	 *
	 * @since 1.0
	 */
	public function render_post_date( $args ) {
		$post_date = $this->get( 'post_date' );
		$options = self::get_post_date_options();
		echo WPRSS_FTP_Utils::array_to_select( $options, array(
			'id'		=>	'ftp-post-date',
			'name'		=>	self::OPTIONS_NAME . '[post_date]',
			'selected'	=>	$post_date,
		));
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'post_date' );
	}


	/**
	 * Renders the comment status checkbox
	 *
	 * @since 1.4.1
	 */
	public function render_comment_status( $args ) {
		$comment_status = $this->get( 'comment_status' );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $comment_status ),
			array(
				'id'		=>	'ftp-comment-status',
				'name'		=>	self::OPTIONS_NAME . '[comment_status]',
				'value'		=>	'true',
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'comment_status' );
	}


	/**
	 * Renders the source_link checkbox
	 *
	 * @since 1.0
	 */
	public function render_source_link( $args ) {
		$source_link = $this->get( 'source_link' );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $source_link ),
			array(
				'id'		=>	'ftp-source-link',
				'name'		=>	self::OPTIONS_NAME . '[source_link]',
				'value'		=>	'true',
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'source_link' );
	}


	/**
	 * Renders the source_link_singular checkbox
	 *
	 * @since 3.3.2
	 */
	public function render_source_link_singular( $args ) {
		$source_link = $this->get( 'source_link_singular' );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $source_link ),
			array(
				'id'		=>	'ftp-source-link-singular',
				'name'		=>	self::OPTIONS_NAME . '[source_link_singular]',
				'value'		=>	'true',
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'source_link_singular' );
	}


	/**
	 * Renders the source_link_text text field
	 *
	 * @since 1.0
	 */
	public function render_source_link_text( $args ) {
		$source_link_text = $this->get( 'source_link_text' );
		echo '<input type="text" name="'.self::OPTIONS_NAME.'[source_link_text]" id="ftp-source-link-text" placeholder="' . esc_attr__("Source link text", WPRSS_TEXT_DOMAIN) . '" value="'.$source_link_text.'"/>';
		$general_meta_fields = WPRSS_FTP_Meta::get_instance()->get_meta_fields('general');
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'source_link_text' );
	}


	/**
	 * Renders the word_limit number roller field
	 *
	 * @since 3.3
	 */
	public function render_word_limit( $args ) {
		$word_limit = $this->get( 'word_limit' );
		echo '<input type="number" class="wprss-number-roller" name="'.self::OPTIONS_NAME.'[word_limit]" id="ftp-word-limit" placeholder="Disabled" value="'.$word_limit.'" min="0" />';
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'word_limit_general' );
	}


	/**
	 * Renders the trimming_type number roller field
	 *
	 * @since 3.3
	 */
	public function render_trimming_type( $args ) {
		$trimming_type = $this->get( 'trimming_type' );
		$options = array(
			'db'		=>	__( 'Trim the content', WPRSS_TEXT_DOMAIN ),
			'excerpt'	=>	__( 'Generate an excerpt', WPRSS_TEXT_DOMAIN )
		);
		echo WPRSS_FTP_Utils::array_to_select( $options, array(
			'id'		=>	'ftp-trimming-type',
			'name'		=>	self::OPTIONS_NAME.'[trimming_type]',
			'selected'	=>	$trimming_type,
		) );
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'trimming_type_general' );
	}


	/**
	 * Renders the full_content checkbox
	 *
	 * @since 1.0
	 */
	public function render_force_full_content( $args ) {
		$force_full_content = $this->get( 'force_full_content' );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $force_full_content ),
			array(
				'id'		=>	'ftp-force-full-content',
				'name'		=>	self::OPTIONS_NAME . '[force_full_content]',
				'value'		=>	'true'
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'force_full_content' );
	}


	/**
	 * Renders the full_content checkbox
	 *
	 * @since 1.0
	 */
	public function render_post_word_limit( $args ) {
		$post_word_limit = $this->get( 'post_word_limit' );
		?>
		<input type="number" min="0" placeholder="No limit" class="wprss-number-roller" id="ftp-post-word-limit" name="<?php echo self::OPTIONS_NAME; ?>[post_word_limit]" value="<?php echo $post_word_limit ?>" />
		<label class="description" for="ftp-post-word-limit">
			<?php _e( 'Enter the maximum number of words to import for posts. Leave blank to use no limit.', WPRSS_TEXT_DOMAIN ); ?>
		</label>
		<?php
	}


	/**
	 * Renders the canonical_link checkbox
	 *
	 * @since 1.8
	 */
	public function render_canonical_link( $args ) {
		$canonical_link = $this->get( 'canonical_link' );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $canonical_link ),
			array(
				'id'		=>	'ftp-canonical-link',
				'name'		=>	self::OPTIONS_NAME . '[canonical_link]',
				'value'		=>	'true'
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'canonical_link' ); ?>
		<label class="description" for="ftp-canonical-link">
			<a href="http://webdesign.about.com/od/seo/a/rel-canonical.htm" target="_blank">
				<?php _e( 'Learn more about canonical pages.', WPRSS_TEXT_DOMAIN ); ?>
			</a>
		</label>
		<?php
	}


	#== Authors Section ========================


	/**
	 * Renders the author settings
	 *
	 * @since 1.9.3
	 */
	public function render_def_author( $args ) {
		$this->render_author_options();
	}


	public function render_author_fallback_method( $args ) {
	}
	/*
	 * Renders the author_fallback_method dropdown
	 *
	 * @since 1.0
	 *
	public function render_author_fallback_method( $args ) {
		$author_fallback_method = $this->get( 'author_fallback_method' );
		echo WPRSS_FTP_Utils::array_to_select( array( 'existing' => 'Use existing', 'create' => 'Create new' ), array(
			'id'		=>	'ftp-author-fallback-method',
			'name'		=>	self::OPTIONS_NAME . '[author_fallback_method]',
			'selected'	=>	$author_fallback_method,
		));
		$this->render_fallback_author( $args );
		?>
		<script type="text/javascript">
			(function($) {
				wprss_ftp_show_authors = function( ) {
					value = $('#ftp-author-fallback-method').val();
					if ( value !== 'existing' ) {
						$('#ftp-fallback-author').hide();
					} else $('#ftp-fallback-author').show();
				}

				$('#ftp-author-fallback-method').on('change', wprss_ftp_show_authors );
				$(window).load( wprss_ftp_show_authors );
			})(jQuery);
		</script>
		<?php
	}
	 */


	/**
	 * Renders the fallback_author dropdown
	 *
	 * @since 1.0
	 */
	public function render_fallback_author( $args ) {
		$fallback_author = $this->get( 'fallback_author' );
		$users = array_map( array( 'WPRSS_FTP_Settings', 'wprss_ftp_user_login' ), get_users() );
		$users_dropdown = array_combine( $users, $users );
		echo WPRSS_FTP_Utils::array_to_select( $users_dropdown, array(
			'id'		=>	'ftp-fallback-author',
			'name'		=>	self::OPTIONS_NAME . '[fallback_author]',
			'selected'	=>	$fallback_author,
		));
	}


	#== Taxonomies Section ========================

	/**
	 * Renders the taxonomies dropdown
	 *
	 * @since 1.0
	 */
	public function render_post_taxonomy( $args ) {
		$settings = $this->get( 'taxonomies' );
		// Check if has old taxonomies settings
		if ( $settings === '' ) {
			$settings = self::convert_post_taxonomy_settings();
		}
		$post_type = $this->get( 'post_type' );

		ob_start();
		?>
		</td></tr></table>
		<div id="wprss-ftp-taxonomy-table-container" style="postition: relative; max-width: 800px; display: block;">
			<table id="wprss-ftp-taxonomy-table" class="form-table wprss-form-table">
				<tbody>
					<?php echo wprss_ftp_taxonomy_sections( $post_type, $settings ); ?>
					<tr id="wprss-ftp-taxonomies-add-section" class="wprss-tr-hr">
						<th colspan="1">
							<button type="button" class="button-secondary" id="ftp-add-taxonomy">
								<i class="fa fa-fw fa-plus"></i> Add New
							</button>
							<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'taxonomies' ); ?>
						</th>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>

		<table style="display: none"><tr><td>

		<?php echo ob_get_clean();
	}


	/**
	 * Renders the taxonomy terms dropdown
	 *
	 * @since 1.0
	 */
	public function render_post_terms( $args ) {
		echo '<p id="ftp-post-terms">' . __('Loading taxonomy terms ...', WPRSS_TEXT_DOMAIN) . '</p>';
	}


	/**
	 * Renders the post tags text input field
	 *
	 * @since 1.0
	 */
	function render_post_tags( $args ) {
		$post_tags = $this->get('post_tags');
		echo '<input id="post_tags" name="'.self::OPTIONS_NAME.'[post_tags]" value="'.$post_tags.'" autocomplete="off" placeholder="' . esc_attr__("Post tags, comma separated", WPRSS_TEXT_DOMAIN) . '" type="text" />';
		echo '<br/><label for="post_tags" class="description">' . __('Enter the post tags, comma separated, to attach to all imported posts.', WPRSS_TEXT_DOMAIN) . '</label>';
	}


	#== Images Section ========================


	/**
	 * Renders the dropdown for using featured images
	 *
	 * @since 1.0
	 */
	public function render_use_featured_image( $args ) {
		$use_featured_image = $this->get( 'use_featured_image' );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $use_featured_image ),
			array(
				'id'		=>	'ftp-use-featured-image',
				'name'		=>	self::OPTIONS_NAME . '[use_featured_image]',
				'value'		=>	'true'
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'use_featured_image' );
	}


	/**
	 *
	 *
	 * @since 1.0
	 */
	public function render_featured_image( $args ) {
		$featured_image = $this->get( 'featured_image' );
		$options = WPRSS_FTP_Meta::get_instance()->get_meta_fields('images');
		$options = $options['featured_image']['options'];
		echo WPRSS_FTP_Utils::array_to_select( $options,
			array(
				'id'		=>	'ftp-featured-image',
				'name'		=>	self::OPTIONS_NAME . '[featured_image]',
				'selected'	=>	$featured_image,
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'featured_image' );
	}


	/**
	 * Renders the dropdown for using featured images
	 *
	 * @since 1.0
	 */
	public function render_fallback_to_feed_image( $args ) {
		$fallback_to_featured_image = $this->get( 'fallback_to_feed_image' );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $fallback_to_featured_image ),
			array(
				'id'		=>	'ftp-fallback-to-feed-image',
				'name'		=>	self::OPTIONS_NAME . '[fallback_to_feed_image]',
				'value'		=>	'true'
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'fallback_to_feed_image' );
	}


	/**
	 * Renders the two dropdowns for the minimum dimensions for the images to import
	 *
	 * @since 1.0
	 */
	public function render_image_minimum_size( $args ) {
		$min_width = $this->get( 'image_min_width' );
		$min_height = $this->get( 'image_min_height' ); ?>
		<p>
			<input class="wprss-number-roller" type="number" id="ftp-min-width" name="<?php echo self::OPTIONS_NAME; ?>[image_min_width]" min="0" placeholder="Ignore" value="<?php echo $min_width; ?>" />
			<span class="dimension-divider">
				<i class="fa fa-times"></i>
			</span>
			<input class="wprss-number-roller" type="number" id="ftp-min-height" name="<?php echo self::OPTIONS_NAME; ?>[image_min_height]" min="0" placeholder="Ignore" value="<?php echo $min_height?>" />
			<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'image_min_dimensions' ); ?>
		</p>
		<?php
	}


	/**
	 * Renders the checkbox for the option to save images locally
	 *
	 * @since 1.3
	 */
	public function render_save_images_locally( $args ) {
		$save_images_locally = $this->get( 'save_images_locally' );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $save_images_locally ),
			array(
				'id'		=>	'ftp-save-images-locally',
				'name'		=>	self::OPTIONS_NAME . '[save_images_locally]',
				'value'		=>	'true'
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'save_images_locally' );
	}


	/**
	 * Renders the checkbox for the option to allow local requests
	 *
	 * @since 2.8.6
	 * @deprecated 3.0
	 */
	public function render_allow_local_requests( $args ) {
		$name = 'allow_local_requests';
		$id = 'ftp-' . str_replace('_', '-', $name);
		$allow_local_requests = $this->get( $name );
		echo WPRSS_FTP_Utils::boolean_to_checkbox(
			WPRSS_FTP_Utils::multiboolean( $allow_local_requests ),
			array(
				'id'		=>	$id,
				'name'		=>	sprintf('%2$s[%1$s]', $name, self::OPTIONS_NAME),
				'value'		=>	'true'
			)
		);
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'allow_local_requests' );
	}


	/**
	 * Renders the dropdown to choose the full text RSS service type
	 *
	 * @since 2.7
	 */
	public function render_full_text_rss_service( $args ) {
		// Get the saved option value, and the dropdown options
		$selected = $this->get( 'full_text_rss_service' );
		$options = self::get_full_text_rss_service_options();
		$selectable = self::get_full_text_rss_selectable_services();
		$dropdownArgs = array(
			'id'				=>	'ftp-full-text-rss-service',
			'name'				=>	self::OPTIONS_NAME . '[full_text_rss_service]',
			'selected'			=>	$selected,
			'selectable'		=>	$selectable,
		);
		// Render the dropdown
		echo WPRSS_FTP_Utils::array_to_select( $options, $dropdownArgs );
		echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'full_text_rss_service' );
		do_action( 'wprss_ftp_after_full_text_rss_service_options', $options, $dropdownArgs );
	}


	/**
	 * Renders the custom namespaces list option
	 *
	 * @since 2.8
	 */
	public function render_custom_namespaces( $args ) {
		// Get the option value
		$namespaces = $this->get('user_feed_namespaces');

		// Parse with default values
		$namespaces = wp_parse_args(
			$namespaces,
			array(
				'names'	=>	array(),
				'urls'	=>	array()
			)
		);

		// PRINT SAVED NAMESPACES
		$remove_btn = '<button type="button" class="button-secondary wprss-ftp-namespace-remove"><i class="fa fa-trash-o"></i></button>';

		for ( $i = 0; $i < count( $namespaces['names'] ); $i++ ) {
			$name = $namespaces['names'][$i];
			$url = $namespaces['urls'][$i];

			echo '<div class="wprss-ftp-namespace-section">';
				echo '<input type="text" name="' . self::OPTIONS_NAME . '[user_feed_namespaces][names][]" value="' . esc_attr( $name ) . '" placeholder="' . esc_attr__( 'Name', WPRSS_TEXT_DOMAIN ) . '" />';
				echo '<input type="text" name="' . self::OPTIONS_NAME . '[user_feed_namespaces][urls][]" value="' . esc_attr( $url ) . '" class="wprss-ftp-namespace-url" placeholder="' . esc_attr__( 'URL', WPRSS_TEXT_DOMAIN) . '" />';
				echo $remove_btn;
			echo '</div>';
		}
		?>

		<span id="wprss-ftp-namespaces-marker"></span>

		<button type="button" id="wprss-ftp-add-namespace" class="button-secondary">
			<?php _e( 'Add Another Namespace', WPRSS_TEXT_DOMAIN ); ?>
		</button>

		<?php // Print the field template and the remove btn as a script variables
			$field_template = '<input type="text" name="'.self::OPTIONS_NAME.'[user_feed_namespaces]" value="" placeholder="" />';
		?>

		<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'user_namespaces' ); ?>

		<script type="text/javascript">
			var wprss_namespace_input_template = "<?php echo addslashes( $field_template ); ?>";
			var wprss_namespace_remove_btn = "<?php echo addslashes( $remove_btn ); ?>";
		</script>

		<?php
	}


	/**
	 * Renders the license section text.
	 *
	 * @since 1.0
	 */
	public function license_section_callback() {
		// Do nothing
	}


	/**
	 * Renders the license text field.
	 *
	 * @since 1.0
	 */
	public function license_callback() {
		$license_keys = get_option( 'wprss_settings_license_keys' );
		$ftp_license_key = ( isset( $license_keys['ftp_license_key'] ) ) ? $license_keys['ftp_license_key'] : '';
		echo "<input id='wprss-ftp-license-key' name='wprss_settings_license_keys[ftp_license_key]' type='text' value='" . esc_attr( $ftp_license_key ) ."' />";
		echo "<label class='description' for='wprss-ftp-license-key'>" . __( 'Enter your license key', WPRSS_TEXT_DOMAIN ) . '</label>';
	}


	/**
	 * Renders the 'Activate License' button
	 *
	 * @since 1.0
	 */
	public function license_activation_callback2() {
		$license_keys = get_option( 'wprss_settings_license_keys' );
		$license_statuses = get_option( 'wprss_settings_license_statuses' );
		$ftp_license_key = ( isset( $license_keys['ftp_license_key'] ) ) ? $license_keys['ftp_license_key'] : FALSE;
		$ftp_license_status = ( isset( $license_statuses['ftp_license_status'] ) ) ? $license_statuses['ftp_license_status'] : FALSE;

	   if( $ftp_license_status != FALSE && $ftp_license_status == 'valid' ) : ?>
			<span style="color:green;"><?php _e( 'active', 'wprss' ); ?></span>
			<?php wp_nonce_field( 'wprss_ftp_license_nonce', 'wprss_ftp_license_nonce' ); ?>
			<input type="submit" class="button-secondary" name="wprss_ftp_license_deactivate" value="<?php _e( 'Deactivate License', WPRSS_TEXT_DOMAIN ); ?>"/>
		<?php else :
			wp_nonce_field( 'wprss_ftp_license_nonce', 'wprss_ftp_license_nonce' ); ?>
			<input type="submit" class="button-secondary" name="wprss_ftp_license_activate" value="<?php _e( 'Activate License', WPRSS_TEXT_DOMAIN ); ?>"/>
		<?php endif;
	}


	/**
	 * Renders the activate/deactivate license button.
	 *
	 * @since 1.0
	 */
	public function license_activation_callback() {
		$status = WPRSS_FTP::get_instance()->get_license_status();
		if ( $status === 'site_inactive' ) $status = 'inactive';

		$valid = $status == 'valid';
		$btn_text = $valid ? 'Deactivate License' : 'Activate License';
		$btn_name = 'wprss_ftp_license_' . ( $valid? 'deactivate' : 'activate' );
		wp_nonce_field( 'wprss_ftp_license_nonce', 'wprss_ftp_license_nonce' ); ?>

		<input type="submit" class="button-secondary" name="<?php echo $btn_name; ?>" value="<?php _e( $btn_text, WPRSS_TEXT_DOMAIN ); ?>" />
		<span id="wprss-ftp-license-status-text">
			<strong>Status:
			<span class="wprss-ftp-license-<?php echo $status; ?>">
					<?php _e( ucfirst($status), 'wprss' ); ?>
					<?php if ( $status === 'valid' ) : ?>
						<i class="fa fa-check"></i>
					<?php elseif( $status === 'invalid' ): ?>
						<i class="fa fa-times"></i>
					<?php elseif( $status === 'inactive' ): ?>
						<i class="fa fa-warning"></i>
					<?php endif; ?>
				</strong>
			</span>
		</span>

		<style type="text/css">
			.wprss-ftp-license-valid {
				color: green;
			}
			.wprss-ftp-license-invalid {
				color: #b71919;
			}
			.wprss-ftp-license-inactive {
				color: #d19e5b;
			}
			#wprss-ftp-license-status-text {
				margin-left: 8px;
				line-height: 27px;
				vertical-align: middle;
			}
		</style>

		<?php
	}


#== SETTINGS VALIDATOR =================================================================================

	public function validate_settings( $input ) {
		/**
		 * @todo Santize options
		 */
		$output = $input;

		// Check if the core settings are included in the POST data
		if ( isset( $_POST['wprss_settings_general'] ) && is_array( $_POST['wprss_settings_general'] ) ) {
			// get the option in the database
			$db_option = get_option( 'wprss_settings_general', array() );
			// update each suboption
			foreach( $_POST['wprss_settings_general'] as $key => $value ) {
				$db_option[$key] = $value;
			}
			// Update the option
			update_option( 'wprss_settings_general', $db_option );
		}

		// Check for missing values
		foreach ( $this->get_defaults() as $key => $def_value ) {
			if ( !array_key_exists( $key, $input ) ) {
				$output[$key] = 'false';
			}
		}

		// Taxonomies saving - Since the form names use meta field names
		$prefix = WPRSS_FTP_Meta::META_PREFIX;
		if ( ! empty( $_POST[ $prefix.'post_taxonomy' ] ) ) {
			$taxonomies = $_POST[ $prefix.'post_taxonomy' ];
			$n = count( $taxonomies );
			$terms = isset( $_POST[ $prefix.'post_terms' ] )? $_POST[ $prefix.'post_terms' ] : array_fill( 0, $n, array() );
			$autos = isset( $_POST[ $prefix.'auto_terms' ] )? $_POST[ $prefix.'auto_terms' ] : array_fill( 0, $n, "false" );
			$subjects = isset( $_POST[ $prefix.'filter_subject' ] )? $_POST[ $prefix.'filter_subject' ] : array_fill( 0, $n + 1, "" );
			$keywords = isset( $_POST[ $prefix.'filter_keywords' ] )? $_POST[ $prefix.'filter_keywords' ] : array_fill( 0, $n + 1, "" );
			$compare_methods = isset( $_POST[ $prefix.'post_taxonomy_compare_method' ] )
                ? $_POST[ $prefix.'post_taxonomy_compare_method' ]
                : array_fill( 0, $n + 1, $this->getDefaultTaxonomyCompareMethod() );
			$output['taxonomies'] = array();
			for( $i = 0; $i < count($taxonomies); $i++ ) {
				$output['taxonomies'][$i] = array();
				$output['taxonomies'][$i]['taxonomy'] = $taxonomies[$i];
				$output['taxonomies'][$i]['terms'] = $terms[$i];
				$output['taxonomies'][$i]['auto'] = $autos[$i];
				$output['taxonomies'][$i]['filter_subject'] = $subjects[$i];
				$output['taxonomies'][$i]['filter_keywords'] = $keywords[$i];
                $output['taxonomies'][$i]['post_taxonomy_compare_method'] = $compare_methods[$i];
			}
		}

		return $output;
	}


#== CUSTOM RENDERERS ======================================================================================

	/**
	 * Renders the author settings
	 *
	 * @since 1.9.3
	 */
	public function render_author_options( $post_id = NULL, $meta_row_title = '', $meta_label_for = '' ) {
		// Get the options
		$options = WPRSS_FTP_Settings::get_instance()->get_computed_options( $post_id );
		$def_author = ( $post_id !== NULL ) ? $options['def_author'] : $this->get( 'def_author' );
		$author_fallback_method = ( $post_id !== NULL ) ? $options['author_fallback_method'] : $this->get( 'author_fallback_method' );
		$author_fallback_method = ( strtolower( $author_fallback_method ) === 'use_existing' )? 'existing' : $author_fallback_method;
		$fallback_author = ( $post_id !== NULL ) ? $options['fallback_author'] : $this->get( 'fallback_author' );
		$no_author_found = ( $post_id !== NULL ) ? $options['no_author_found'] : $this->get( 'no_author_found' );

		// Set the HTML tag ids
		$ids = array(
			'def_author'				=>	'ftp-def-author',
			'author_fallback_method'	=>	'ftp-author-fallback-method',
			'fallback_author'			=>	'ftp-fallback-author',
			'no_author_found'			=>	'ftp-no-author-skip'
		);
		// If in meta, copy the keys into the values
		if ( $post_id !== NULL ) {
			foreach ( $ids as $field => $id ) {
				$ids[$field] = $field;
			}
		}
		// Set the HTML tag names
		$names = array(
			'def_author'				=>	'def_author',
			'author_fallback_method'	=>	'author_fallback_method',
			'fallback_author'			=>	'fallback_author',
			'no_author_found'			=>	'no_author_found',
		);
        // Set the names appropriately according to the page, meta or settings
        foreach( $names as $field => $name) {
            if ( $post_id !== NULL ) {
                $names[$field] = WPRSS_FTP_Meta::META_PREFIX . $name;
            } else {
                $names[$field] = self::OPTIONS_NAME . "[$name]";
            }
        }

		// If in meta, print the table row
		if ( $post_id !== NULL ) : ?>
			<tr>
				<th>
					<label for="<?php echo $meta_label_for; ?>">
						<?php echo $meta_row_title; ?>
					</label>
				</th>
				<td>
		<?php endif; ?>

		<!-- Author to use -->
		<span id="wprss-ftp-authors-options">
			<?php
			$userIds = WPRSS_FTP_Admin_User_Ajax::get_instance()->is_over_threshold()
				? [$def_author, get_current_user_id()]
				: false;
			$users = WPRSS_FTP_Meta::get_users_array($userIds);
			?>
			<?php echo WPRSS_FTP_Utils::array_to_select( $users, array(
					'id'		=>	$ids['def_author'],
					'name'		=>	$names['def_author'],
					'selected'	=>	$def_author,
			));
			?>
			<script type="text/javascript">
				top.wprss.f2p.userAjax.addElement('#<?php echo $ids['def_author'] ?>');
			</script>
			<?php
			echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'post_author' ); ?>
		</span>

		<!-- Separator -->
		<?php if ( $post_id !== NULL ) : ?>
			</td></tr>
			<tr class="wprss-tr-hr wprss-ftp-authors-hide-if-using-existing">
				<th>
				</th>
				<td>
		<?php endif; ?>

		<!-- Section that hides when using an existing user -->
		<span class="wprss-ftp-authors-hide-if-using-existing">

			<!-- Radio group if author has no user -->
			<span class="ftp-author-using-in-feed">
				<label for="<?php echo $ids['author_fallback_method']; ?>">
					<?php _e( 'If the author in the feed is not an existing user', WPRSS_TEXT_DOMAIN ); ?>:
				</label>
				<br/>
				<?php
					echo implode( '', WPRSS_FTP_Utils::array_to_radio_buttons(
						array(
							'existing'	=> __( 'Use the fallback user', WPRSS_TEXT_DOMAIN ),
							'create'	=> __( 'Create a user for the author', WPRSS_TEXT_DOMAIN )
						),
						array(
							'id'		=>	$ids['author_fallback_method'],
							'name'		=>	$names['author_fallback_method'],
							'checked'	=>	$author_fallback_method,
						)
					));
				?>
			</span>

			<!-- Radio group if author not found in feed -->
			<span class="ftp-author-using-in-feed">
				<label for="<?php echo $ids['no_author_found']; ?>">
					<?php _e( 'If the author is missing from the feed', WPRSS_TEXT_DOMAIN ); ?>
				</label>
				<br/>
				<?php
					echo implode( WPRSS_FTP_Utils::array_to_radio_buttons(
						array(
							'fallback'	=>	__( 'Use the fallback user', WPRSS_TEXT_DOMAIN ),
							'skip'		=>	__( 'Do not import the post', WPRSS_TEXT_DOMAIN )
						),
						array(
							'id'		=>	$ids['no_author_found'],
							'name'		=>	$names['no_author_found'],
							'checked'	=>	$no_author_found,
						)
					));
				?>
			</span>
		</span>


		<?php if ( $post_id !== NULL ) : ?>
			</td></tr>
			<tr class="wprss-tr-hr wprss-ftp-authors-hide-if-using-existing">
				<th>
					<label for="<?php echo $ids['fallback_author']; ?>">
						<?php _e( 'Fallback User', WPRSS_TEXT_DOMAIN ); ?>
					</label>
				</th>
				<td>
		<?php endif; ?>

		<!-- Section that hides when using an existing user -->
		<span class="wprss-ftp-authors-hide-if-using-existing">
			<?php if ( $post_id === NULL ) : ?>
			<label for="<?php echo $ids['fallback_author']; ?>">
				<?php _e( 'Fallback user:', WPRSS_TEXT_DOMAIN ); ?>
			</label>
			<?php endif; ?>
			<?php
			$userIds = WPRSS_FTP_Admin_User_Ajax::get_instance()->is_over_threshold()
				? array_merge($userIds, [$fallback_author])
				: false;
			$fallback_users = WPRSS_FTP_Meta::get_users_array($userIds, true, true) ?>
			<?php
				echo WPRSS_FTP_Utils::array_to_select( $fallback_users, array(
					'id'		=>	$ids['fallback_author'],
					'name'		=>	$names['fallback_author'],
					'selected'	=>	$fallback_author,
				));
			?>
			<script type="text/javascript">
				top.wprss.f2p.userAjax.addElement('#<?php echo $ids['fallback_author'] ?>', {<?php echo WPRSS_FTP_Admin_User_Ajax::REQUEST_VAR_EXISTING_USERS_ONLY ?>: true, <?php echo WPRSS_FTP_Admin_User_Ajax::REQUEST_VAR_LOGIN_NAMES ?>: true});
			</script>
			<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'fallback_author' ); ?>
		</span>

		<?php // Add scripts ?>

		<script type="text/javascript">
			(function($){
				$(document).ready( function(){

					// Set a pointer to the dropdowns
					var dropdown1 = $('#<?php echo $ids['def_author']; ?>');

					// Create the function that shows/hides the second section
					var authorsSection2UI = function(){
						// Show second section only if the option to use the author in the feed is chosen
						$('.wprss-ftp-authors-hide-if-using-existing').toggle( dropdown1.val() === '.' );
					}

					// Set the on change handlers
					dropdown1.change( authorsSection2UI );

					// Run the function at least once
					authorsSection2UI();

				});
			})(jQuery);
		</script>
		<?php // End of scripts

		// If in meta, close the table row
		if ( $post_id !== NULL ) {
			?></td></tr><?php
		}
	}


#== PAGE RENDERER ======================================================================================


	/**
	* Add settings fields and sections
	* @since 1.0
	*/
	public function render_settings_page( $active_tab ) {
		if ( $active_tab === self::TAB_SLUG ) {
			# Render all sections for this page
			settings_fields( 'wprss_settings_ftp' );
			do_settings_sections( 'wprss_settings_ftp' );
		}
	}


#== ADD AGGREGATOR TAB =================================================================================

	/**
	* Add a settings tabs for the Feed-to-Post add-on on the Settings page
	*
	* @since 1.0
	*/
	public function add_tab( $args ) {
		$args['ftp'] = array(
			'label' => 'Feed to Post',
			'slug' => self::TAB_SLUG
		);
		return $args;
	}


#== MISC ===============================================================================================


	/**
	 * Converts the old taxonomy meta fields into the new format.
	 * Does NOT save into database.
	 *
	 * @since 3.1
	 * @param int $post_id The ID of the post
	 * @return array The new settings fields
	 */
	public static function convert_post_taxonomy_settings() {
		// Prepare the old fields
		$old_fields = array(
			'post_taxonomy',
			'post_terms',
			'post_auto_tax_terms',
			'post_tags'
		);
		// Prepare the new fields array
		$settings = array();
		// Generate the new fields
		foreach( $old_fields as $old_field ) {
			$settings[ $old_field ] = self::get_instance()->get( $old_field );
		}
		// Return the new fields
		return WPRSS_FTP_Meta::convert_taxonomy_option( $settings );
	}


    /**
     * Returns the registered post types.
     *
     * @since 2.9.5
     */
    public static function get_post_types() {
        // Get all post types, as objects
        $post_types = get_post_types( array(), 'objects' );

        unset($post_types['attachment']);
        unset($post_types['revision']);
        unset($post_types['nav_menu_item']);
        unset($post_types['custom_css']);
        unset($post_types['customize_changeset']);
        unset($post_types['oembed_cache']);
        unset($post_types['user_request']);
        unset($post_types['wp_block']);
        unset($post_types['wprss_blacklist']);

        // Return the list, mapping the post type objects to their singular name
        return array_map( array( __CLASS__, 'post_type_singular_name' ), $post_types );
    }


	/**
	 * Returns the singular name for the given post type object.
	 * Used as a callback for array_map calls.
	 *
	 * @since 2.9.5
	 */
	public static function post_type_singular_name( $post_type ) {
		return $post_type->labels->singular_name;
	}


	public static function get_post_formats() {
		return array(
			'standard'	=>	__( 'Standard' ),
			'aside'		=>	__( 'Aside' ),
			'chat'		=>	__( 'Chat' ),
			'link'		=>	__( 'Link' ),
			'quote'		=>	__( 'Quote' ),
			'status'	=>	__( 'Status' ),
			'audio'		=>	__( 'Audio' ),
			'image'		=>	__( 'Image' ),
			'video'		=>	__( 'Video' ),
			'gallery'	=>	__( 'Gallery' ),
		);
	}


	public static function get_post_statuses($args = array()) {
		$args = array_merge( array(
			'show_in_admin_status_list' => true
		), $args );

		$stati = array();
		foreach ( get_post_stati( $args, 'objects' ) as $_code => $_status ) {
			/* @var $status stdClass */
			$stati[ $_code ] = $_status->label;
		}

		return apply_filters( 'wprss_ftp_post_stati', $stati );
	}


	/* The following functions are used as filters for array_map function calls, to return specific user data. */
	private static function wprss_ftp_user_id( $user ) {
		return $user->ID;
	}
	private static function wprss_ftp_user_login( $user ) {
		return $user->user_login;
	}
	private static function wprss_ftp_term_slug( $term ) {
		return $term->slug;
	}
	private static function wprss_ftp_term_name( $term ) {
		return $term->name;
	}


	/**
	 * Returns an array of users on the site.
	 *
	 * Rewritten as of 2.0, due to various bugs.
	 *
	 * @param $assoc	boolean		If true, an associative array of user ids pointing to user logins is
	 *								returned. If false, a regular array of user logins is returned.
	 * @since 2.0
	 */
	public static function get_users( $assoc = true, $onlyTheseIds = false ) {
		// Get all users
		$users = array();
		if( $onlyTheseIds !== false ) {
			$onlyTheseIds = (array)$onlyTheseIds;
			foreach( $onlyTheseIds as $_idx => $_id ) {
				if( is_numeric( $_id ) ) continue;
				$user = get_user_by( 'login', $_id );
				$onlyTheseIds[$_idx] = $user ? $user->ID : null;
			}

			$user_query = new WP_User_Query( array( 'include' => $onlyTheseIds ) );
			$users = $user_query->get_results();
		} else $users = get_users();

		if ( count( $users ) === 0 ) return array();

		// Get the user logins and ids
		$user_logins = array_map( array( 'WPRSS_FTP_Settings', 'wprss_ftp_user_login' ), $users );
		$user_ids = array_map( array( 'WPRSS_FTP_Settings', 'wprss_ftp_user_id' ), $users );

		// If the assoc param is true, return an associative array of user keys pointing to their logins.
		// Otherwise, return just an array with the user logins.
		$user_array = ( $assoc === TRUE )? array_combine( $user_ids, $user_logins ) : $user_logins;

		return $user_array;
	}


	public static function get_term_names( $taxonomy, $args = array(), $assoc = true ) {
		$args['fields'] = 'all';
		$term_objs = get_terms( $taxonomy, $args );
		if ( is_wp_error( $term_objs ) ) {
			return NULL;
		}

		$term_slugs = array_map(  array( 'WPRSS_FTP_Settings', 'wprss_ftp_term_slug' ) , $term_objs );
		$term_names =  array_map(  array( 'WPRSS_FTP_Settings', 'wprss_ftp_term_name' ) , $term_objs );

		if ( $assoc === true ) {
			if ( is_array( $term_names ) && count( $term_names ) > 0 ) {
				$term_names = array_combine( $term_slugs, $term_names );
			}
			else {
				$term_names = array();
			}
		}
		return $term_names;
	}


	public static function get_post_date_options() {
		return array(
			'original'		=>	__( 'Original post date', WPRSS_TEXT_DOMAIN ),
			'imported'		=>	__( 'Feed import date', WPRSS_TEXT_DOMAIN )
		);
	}


	/**
	 * Returns the options for the full_text_rss_service option
	 *
	 * @since 2.7
	 */
	public static function get_full_text_rss_service_options() {
		return apply_filters(
			'wprss_ftp_full_text_rss_service_options',
			array(
				'free'			=>	__( 'Free Services', WPRSS_TEXT_DOMAIN ),
			)
		);
	}


	/**
	 * Returns an array of the full text rss service option IDs as keys,
	 * and a TRUE/FALSE flag signifying whether or not they are selectable.
	 *
	 * @since 3.2.4
	 * @return array
	 */
	public static function get_full_text_rss_selectable_services() {
		$services = self::get_full_text_rss_service_options();
		$services = array_keys( $services );
		$selectable = array_fill( 0, count( $services ), TRUE );
		$final = array_combine( $services, $selectable );
		return apply_filters( 'wprss_ftp_full_text_rss_selectable_services', $final );
	}


	/**
	 * Returns the array of default namespaces
	 *
	 * @since 2.8
	 */
	public static function get_default_namespaces() {
		return apply_filters(
			'wprss_ftp_default_namespaces',
			array(
				__( 'No Namespace', WPRSS_TEXT_DOMAIN ) => '',
			)
		);
	}


	/**
	 * Returns the array of namespaces available.
	 *
	 * @since 2.8
	 */
	public static function get_namespaces() {
		// The default namespaces
		$def_namespaces = self::get_default_namespaces();

		// Change the array into the same format as the user saved namespaces
		$def_namespaces = array(
			'names' =>	array_keys( $def_namespaces ),
			'urls'	=>	array_values( $def_namespaces ),
		);

		// Get the namespaces added by the user
		$user_namespaces = self::get_instance()->get( 'user_feed_namespaces' );
		if ( !is_array($user_namespaces) || count($user_namespaces) === 0 ) {
			$user_namespaces = self::get_instance()->get_default( 'user_feed_namespaces' );
		}

		// Return both as 1 array
		return array(
			'names'		=>	array_merge( $def_namespaces['names'], $user_namespaces['names'] ),
			'urls'		=>	array_merge( $def_namespaces['urls'], $user_namespaces['urls'] ),
		);
	}


	/**
	 * Gets the Namespace URL for the given Namespae Name
	 *
	 * @since 2.8
	 */
	public static function get_namespace_url( $namespace ) {
		// Get the namespaces array setting
		$namespaces = self::get_namespaces();

		// Search for the index of the namespace name given in the 'names' subarray
		$i = array_search( $namespace, $namespaces['names'] );
		// Return null if the namespace was not found
		if ( $i === FALSE ) return NULL;

		// Use the index to return the URL from the 'urls' subarray
		return ( !isset( $namespaces['urls'][$i] ) )? NULL : $namespaces['urls'][$i];
	}

    /**
     * Makes sure that asking for a setting never returns "feeds_api".
     *
     * Most probably used for the `full_text_rss_service` setting.
     *
     * @since 3.7.4
     *
     * @param mixed $value The current value.
     * @param string $name The name of the setting being retrieved.
     * @param int|null $postId ID of the post, for which the settings are being retrieved.
     * @return mixed The new value.
     */
    public function feedsapi_setting_fallback($value, $name, $postId = null)
    {
        if ($value === 'feeds_api') {
            $value = WPRSS_FTP_Settings::get_instance()->get_default($name);
        }

        return $value;
    }

} // End of Settings Class

<?php
class WPRSS_FTP_Meta {

/*===== CONSTANTS AND STATIC MEMBERS ======================================================================*/

	/**
	 * The Meta data field prefix
	 */
	const META_PREFIX = 'wprss_ftp_';

    const DEFAULT_TAXONOMY_COMPARE_METHOD = 'all';


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
			// Check if WPML is active, and add a multi language meta box
			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
				add_filter( 'wprss_ftp_meta_fields', array( $this, 'add_multilanguage_metabox' ), 10 , 1 );
			}
			# Initialize
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_post_meta' ), 5, 2 );
			# Change core meta option
			add_filter( 'wprss_fields', array( $this, 'change_core_meta_fields' ) );
			# Disables the visual editor the feed source has the option enabled
			add_filter( 'user_can_richedit' , array( $this, 'disable_visual_editor' ) );
		} else {
			wp_die( __( "WPRSS_FTP_Meta class is a singleton class and cannot be redeclared.", WPRSS_TEXT_DOMAIN ) );
		}
	}

	/**
	 * Returns the singleton instance
	 *
	 * @return WPRSS_FTP_Meta The singleton instance of this class.
	 */
	public static function get_instance() {
		if ( self::$instance === NULL ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Disables the visual editor if the post has the feed source enabled.
	 *
	 * @since 3.7.7
	 *
	 * @param bool $use_visual_editor
     *
	 * @return bool
	 */
	public function disable_visual_editor($use_visual_editor) {
        if ( !is_admin() ) return $use_visual_editor;

        $screen = get_current_screen();
        // Check if we are in the wprss_feed edit page
        if ( $screen->base == 'post' && $screen->post_type == 'wprss_feed' && !empty( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
            // Get the current feed source ID
            $feed_source_id = get_the_ID();
            // Get the visual editor disabling option
            $disable_visual_editor = $this->get_meta($feed_source_id, 'disable_visual_editor');
            // If visual editors are disabled, set the filter value to false
            if ($disable_visual_editor === 'true') {
                $use_visual_editor = false;
            }
        }

        return $use_visual_editor;
    }

#=== META SETTERS / GETTERS ===============================================================================


	/**
	 * Returns the FTP related meta data
	 *
	 * @since 1.0
	 */
	public function get( $post_id, $meta_key, $use_prefix = true ) {
		return $this->get_meta( $post_id, $meta_key, $use_prefix );
	}
	public function get_meta( $post_id, $meta_key, $use_prefix = true ) {
		$prefix = ( $use_prefix === TRUE )? WPRSS_FTP_Meta::META_PREFIX : '';
		return get_post_meta( $post_id,  $prefix . $meta_key, TRUE );
	}


	/**
	 * Adds the given meta data to a post.
	 * Prepend an exclamation mark to the key to exclude the meta prefix.
	 *
	 * @since 1.0
	 */
	public function add_meta( $post_id, $meta, $value = '' ) {
		if ( is_array( $meta ) ){
			foreach ( $meta as $key => $value) {
				# If the key starts with a '!', do not add the prefix to the key
				$meta_key = ( $key[0] === '!' )? substr( $key, 1 ) : WPRSS_FTP_Meta::META_PREFIX . $key;
				# Add the meta to the database
				update_post_meta( $post_id, $meta_key, $value );
			}
		}
		else {
			update_post_meta( $post_id, WPRSS_FTP_Meta::META_PREFIX . $meta, $value );
		}
	}


#=== META BOXES REGISTRATION =============================================================================

	/**
	 * Registers the meta boxes for the 'New Feed Source' page.
	 *
	 * @since 1.0
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'wprss-ftp-general-metabox',							// $id
			__( 'Feed to Post - General', WPRSS_TEXT_DOMAIN ),		// $title
			array( $this, 'render_general_metabox' ),				// $callback
			'wprss_feed',											// $page
			'normal',												// $context
			'default'                                   			// $priority
		);
		add_meta_box(
			'wprss-ftp-images-metabox',								// $id
			__( 'Feed to Post - Images', WPRSS_TEXT_DOMAIN ),		// $title
			array( $this, 'render_images_metabox' ),				// $callback
			'wprss_feed',											// $page
			'normal',												// $context
			'default'                                   			// $priority
		);
		add_meta_box(
			'wprss-ftp-taxonomy-metabox',							// $id
			__( 'Feed to Post - Taxonomies', WPRSS_TEXT_DOMAIN ),	// $title
			array( $this, 'render_taxonomy_metabox' ),				// $callback
			'wprss_feed',											// $page
			'normal',												// $context
			'default'                                   			// $priority
		);
		add_meta_box(
			'wprss-ftp-author-metabox',								// $id
			__( 'Feed to Post - Author', WPRSS_TEXT_DOMAIN ),		// $title
			array( $this, 'render_author_metabox' ),				// $callback
			'wprss_feed',											// $page
			'normal',												// $context
			'default'												// $priority
		);
		add_meta_box(
			'wprss-ftp-wysiwyg-editor',							      	// $id
			__( 'Feed to Post - WYSIWYG Editor', WPRSS_TEXT_DOMAIN ),		// $title
			array( $this, 'render_wysiwyg_editors_metabox' ),				// callback
			'wprss_feed',													// $page
			'normal',															// $context
			'default'														// $priority
		);
		add_meta_box(
			'wprss-ftp-prepend-metabox',									// $id
			__( 'Feed to Post - Prepend To Content', WPRSS_TEXT_DOMAIN ),	// $title
			array( $this, 'render_prepend_metabox' ),						// $callback
			'wprss_feed',													// $page
			'normal',														// $context
			'default'														// $priority
		);
		add_meta_box(
			'wprss-ftp-append-metabox',										// $id
			__( 'Feed to Post - Append To Content', WPRSS_TEXT_DOMAIN ),	// $title
			array( $this, 'render_append_metabox' ),						// $callback
			'wprss_feed',													// $page
			'normal',														// $context
			'default'														// $priority
		);
		add_meta_box(
			'wprss-ftp-extraction-metabox',									// $id
			__( 'Feed to Post - Extraction Rules', WPRSS_TEXT_DOMAIN ),		// $title
			array( $this, 'render_extraction_metabox' ),					// $callback
			'wprss_feed',													// $page
			'normal',														// $context
			'default',														// $priority
            array(                                                          // $callback_args
                'before_fields'         => sprintf(__('<p>Extraction rules allow you to remove unwanted material from imported posts’ content. '
                                            . 'This is particularly useful to remove elements such as social network sharing buttons and advertisements. '
                                            . '<a href="%1$s" target="_blank">Learn how to find the required CSS Selector here.</a></p>', WPRSS_TEXT_DOMAIN), 'http://docs.wprssaggregator.com/extraction-rules/#finding-a-css-selector'),
            )
		);
		add_meta_box(
			'wprss-ftp-custom-fields-metabox',								// $id
			__( 'Feed to Post - Custom Field Mapping', WPRSS_TEXT_DOMAIN ),	// $title
			array( $this, 'render_custom_fields_metabox' ),					// $callback
			'wprss_feed',													// $page
			'normal',														// $context
			'default'														// $priority
		);
		add_meta_box(
			'wprss-ftp-word-trimming-metabox',								// $id
			__( 'Feed to Post - Word Trimming', WPRSS_TEXT_DOMAIN ),		// $title
			array( $this, 'render_word_trimming_metabox' ),					// $callback
			'wprss_feed',													// $page
			'side',															// $context
			'default'														// $priority
		);
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			add_meta_box(
				'wprss-ftp-multi-language-metabox',							// $id
				__( 'Feed to Post - Multi Language', WPRSS_TEXT_DOMAIN ),	// $title
				array( $this, 'render_multi_language_metabox' ),			// $callback
				'wprss_feed',												// $page
				'normal',													// $context
				'default'                                   				// $priority
			);
		}


		// Removes the 'Featured Image' meta box, and re-adds it with custom text
		remove_meta_box( 'postimagediv', 'wprss_feed', 'side' );
        add_meta_box(
        	'postimagediv',
        	__( 'Default Thumbnail', WPRSS_TEXT_DOMAIN ),
        	array( $this, 'post_thumbnail_meta_box' ),
        	'wprss_feed',
        	'side',
            'default'
        );

        add_meta_box(
            'wprss-ftp-integrations-metabox',
            __( 'Feed to Post - Integrations', WPRSS_TEXT_DOMAIN ),
            array( $this, 'render_integrations_metabox' ),
            'wprss_feed',
            'normal',
            'low'
        );
	}


#=== META BOXES AND META FIELDS =============================================================================

	/**
	 * Returns the Meta fields used in the meta boxes
	 *
	 * @since 1.0
	 */
	public function get_meta_fields( $what = '', $source_id = null ) {
		$fields = array(
			#== General Metabox fields ===================
			'general'	=> 	array(
				#== Post Site ==
				'post_site' => array(
					'label'			=>	__( 'Post to site', WPRSS_TEXT_DOMAIN ),
					'custom_render'	=>	array( $this, 'render_post_site_dropdown' )
				),
				#== Post Type ==
				'post_type' => array(
					'label'			=>	__( 'Post Type', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'dropdown',
					'options'		=>	$this->get_new_data_source( array( $this, 'get_post_types' ), $source_id ),
				),
				#== Post Status =====
				'post_status' => array(
					'label'			=>	__( 'Post Status', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'dropdown',
					'options'		=>	$this->get_new_data_source( array( 'WPRSS_FTP_Settings', 'get_post_statuses' ) ),
				),
				#== Post Format =====
				'post_format' => array(
					'label'			=>	__( 'Post Format', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'dropdown',
					'options'		=>	$this->get_new_data_source( array( 'WPRSS_FTP_Settings', 'get_post_formats' ) ),
				),
				#== Post Date =====
				'post_date' => array(
					'label'			=>	__( 'Post Date', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'dropdown',
					'options'		=>	$this->get_new_data_source( array( 'WPRSS_FTP_Settings', 'get_post_date_options' ) ),
				),
				#== Comment Status =====
				'comment_status' => array(
					'label'			=>	__( 'Enable Comments', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox'
				),
				#== Force full content =====
				'force_full_content' => array(
					'label'			=>	__( 'Force Full Content', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox'
				),
                #== Import the excerpt content =====
                'import_excerpt' => array(
                    'label'			=>	__( 'Import Post Excerpt', WPRSS_TEXT_DOMAIN ),
                    'type'			=>	'checkbox',
                ),
				#== Allow embedded content =====
				'allow_embedded_content' => array(
					'label'			=>	__( 'Allow Embedded Content', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox'
				),
				#== Rel canonical head =====
				'canonical_link' => array(
					'label'			=>	__( 'Canonical Link', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox'
				)
			),

			#== Taxonomy and Terms Metabox fields ===================
			'tax'	=>	array(
				#== Post Taxonomy ==========
				'post_taxonomy' 	=> array(
					'label'				=>	__( 'Post Taxonomy', WPRSS_TEXT_DOMAIN ),
					'desc'				=>	__( 'Choose the taxonomy to apply to imported feeds.', WPRSS_TEXT_DOMAIN ),
					'type'				=>	'msg',
					'text'				=>	__( 'Please wait ...', WPRSS_TEXT_DOMAIN ),
					'custom_render'		=>	array( $this, 'render_taxonomies' ),
				),
                'post_taxonomy_compare_method'  => array(
                    'label'             => __('Taxonomy Compare Method', WPRSS_TEXT_DOMAIN),
                    'desc'              => __('Choose how the keywords compare with the terms'),
                    'type'              => 'dropdown',
                    'text'              => __('Choose a method'),
					'options'           => $this->get_new_data_source( array( $this, 'getTaxonomyCompareMethods' ) ),
                    'ignore'            => true,
                ),
				#== Post Taxonomy ==========
				'post_terms' => array(
					'label'				=>	__( 'Post Terms', WPRSS_TEXT_DOMAIN ),
					'desc'				=>	__( 'Choose the taxonomy terms to apply to imported feeds.', WPRSS_TEXT_DOMAIN ),
					'type'				=>	'msg',
					'text'				=>	__( 'Please wait ...', WPRSS_TEXT_DOMAIN ),
					'ignore'			=>	TRUE
				),
				'post_tags' => array(
					'label'				=>	__( 'Post Tags', WPRSS_TEXT_DOMAIN ),
					'desc'				=>	__( 'Enter the post tags, comma separated, to assign to posts imported from this source.', WPRSS_TEXT_DOMAIN ),
					'type'				=>	'text',
					'placeholder'		=>	__( 'Post tags, comma separated', WPRSS_TEXT_DOMAIN ),
					'settings'			=>	FALSE,		# Ignore the value in the global settings
					'ignore'			=>	TRUE,
				),
				'post_auto_tax_terms' => array(
					'label'				=>	__( 'Auto create terms', WPRSS_TEXT_DOMAIN ),
					'desc'				=>	__( 'Check this box to automatically create terms for the taxonomy selected above.', WPRSS_TEXT_DOMAIN ),
					'type'				=>	'checkbox',
					'ignore'			=>	TRUE
				),
			),

			#== Author Metabox fields ===================
			'author'	=>	array(
				#== Default Author Type =====
				'def_author' => array(
					'label'			=>	__( 'Post Author', WPRSS_TEXT_DOMAIN ),
					'desc'			=>	__( 'Choose the author to use for imported feeds', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'dropdown',
					'ignore'		=>	TRUE,
				),
				#== Author Fallback Method =====
				'author_fallback_method' => array(
					'label'			=>	__( 'If feed author does not exist', WPRSS_TEXT_DOMAIN ),
					'desc'			=>	__( 'If the above option is set to get the author from the feed, choose what to do when the feed author is not a user on the site.', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'none',
					'ignore'		=>	TRUE,
				),
				#== No Author Found =====
				'no_author_found' => array(
					'label'			=>	__( 'Fallback Author', WPRSS_TEXT_DOMAIN ),
					'desc'			=>	'',
					'type'			=>	'none',
					'ignore'		=>	TRUE,
				),
				#== Fallback Author =====
				'fallback_author' => array(
					'label'			=>	__( 'Fallback Author', WPRSS_TEXT_DOMAIN ),
					'desc'			=>	__( 'Choose the user to use if the above option is set to "Use Existing", or if the feed does not specify an author.', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'dropdown',
					'options'		=>	$this->get_new_data_source( array( 'WPRSS_FTP_Settings', 'get_users' ) ),
					'ignore'		=>	TRUE,
				)
			),

			#== Images Metabox fields ===================
			'images'	=>	array(
				#== Save images locally =====
				'save_images_locally' => array(
					'label'			=>	__( 'Import images', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox',
					'default'		=>	'true'
				),
                'save_all_image_sizes' => array(
                    'label'			=>	__( 'Import all sizes', WPRSS_TEXT_DOMAIN ),
                    'type'			=>	'checkbox',
                    'default'		=>	'true'
                ),
				'image_min_width' => array(
					'label'			=>	__( 'Image minimum width', WPRSS_TEXT_DOMAIN ),
					'desc'			=>	__( 'Choose the minimum width for image imports.', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'number',
					'placeholder'	=>	'Ignore',
					'custom_render' =>	array( $this, 'render_image_min_dimensions' )
				),
				'image_min_height' => array(
					'label'			=>	__( 'Image minimum height', WPRSS_TEXT_DOMAIN ),
					'desc'			=>	__( 'Choose the minimum height for image imports.', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'number',
					'placeholder'	=>	'Ignore',
					'ignore'		=>	true
				),
				#== Featured Image On/Off =====
				'use_featured_image' => array(
					'label'			=>	__( 'Enable featured images', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox',
					'default'		=>	'true',
					'add_hr'		=>	true,
				),
				'featured_image' => array(
					'label'			=>	__( 'Featured Image to use', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'dropdown',
					'options'		=>	array(
						'first'			=>	__( 'First image in post content', WPRSS_TEXT_DOMAIN ),
						'last'			=>	__( 'Last image in post content', WPRSS_TEXT_DOMAIN ),
						'thumb'			=>	__( 'Feed &lt;media:thumbnail&gt; tag', WPRSS_TEXT_DOMAIN ),
						'fallback'		=>	__( 'Use the fallback featured image', WPRSS_TEXT_DOMAIN ),
						'enclosure'		=>	__( 'Enclosure tag', WPRSS_TEXT_DOMAIN ),
					)
				),
				#== Remove featured image from post content =====
				'remove_ft_image' => array(
					'label'			=>	__( 'Remove featured image from post content', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox',
					'default'		=>	'false',
				),
				#== Do not import if no ft. image =====
				'must_have_ft_image' => array(
					'label'			=>	__( 'Posts must have a featured image', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox',
					'default'		=>	'false',
				),
			),


			#== Prepend / Append Metabox fields ===================
			'prepend'	=>	array(
                'singular_prepend' => array(
                    'label'			=>	__( 'Prepend only to singular posts ', WPRSS_TEXT_DOMAIN ),
                    'type'			=>	'checkbox',
                    'default'		=>	'false',
                ),
                'post_prepend' => array(
                    'label'			=>	__( 'Prepend text to post content', WPRSS_TEXT_DOMAIN ),
                    'desc'			=>	__( 'Use the following placeholders to replace with the post\'s details: <br />(Hover over them for a description of what they represent)', WPRSS_TEXT_DOMAIN ),
                    'type'			=>	'editor',
                    'custom_render'	=>	array( $this, 'render_post_prepend_editor' ),
                    'settings'		=>	FALSE		# Ignore the value in the global settings
                ),
            ),
            'append'	=>	array(
                'singular_append' => array(
                    'label'			=>	__( 'Append only to singular posts', WPRSS_TEXT_DOMAIN ),
                    'type'			=>	'checkbox',
                    'default'		=>	'false',
                ),
				'post_append' => array(
					'label'			=>	__( 'Append text to post content', WPRSS_TEXT_DOMAIN ),
					'desc'			=>	__( 'Use the following placeholders to replace with the post\'s details: <br />(Hover over them for a description of what they represent)', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'editor',
					'custom_render'	=>	array( $this, 'render_post_append_editor' ),
					'settings'		=>	FALSE		# Ignore the value in the global settings
				),
			),


			#== Extraction Rules Metabox fields ===================
			'extraction'	=>	array(
				'extraction_rules'	=>	array(
					'label'				=>	__( 'Extraction Rules', WPRSS_TEXT_DOMAIN ),
					'type'				=>	'none',
					'custom_render'		=>	array( $this, 'render_extraction_rules' ),
					'settings'			=>	FALSE,
					'manip_options'		=>	array(
						'remove'				=>	__( 'Remove the matching element(s)', WPRSS_TEXT_DOMAIN ),
						'remove_keep_children'	=>	__( 'Remove element(s), but keep contents', WPRSS_TEXT_DOMAIN ),
						'keep'					=>	__( 'Keep only the matched element(s)', WPRSS_TEXT_DOMAIN ),
					),
				),
				'extraction_rules_types' => array(
					'ignore'			=>	TRUE,
				),
			),

			#== Custom Field Mapping Metabox fields ===================
			'custom_fields'	=>	array(
				// The RSS tags to get from RSS
				'rss_tags'			=>	array(
					'ignore'		=>	TRUE,
				),
				// The RSS Namespaces to use for each tag
				'rss_namespaces'	=>	array(
					'ignore'		=>	TRUE,
				),
				// The custom meta field names to which to import
				'custom_fields'		=>	array(
					'label'			=>	__( 'Custom Field Mapping', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'none',
					'custom_render'	=>	array( $this, 'render_custom_fields' ),
					'settings'		=>	FALSE,
					'namespaces'	=>	WPRSS_FTP_Settings::get_instance()->get('user_feed_namespaces')
				)
			),

			#== Word Trimming =============================================
			'word_trimming' => array(
				'word_limit_enabled'	=>	array(
					'label'		=>	__( 'Enabled', WPRSS_TEXT_DOMAIN ),
					'type'		=>	'dropdown',
					'options'	=>	array(
						'general'	=>	__( 'Use General Settings', WPRSS_TEXT_DOMAIN ),
						'true'		=>	__( 'Enabled', WPRSS_TEXT_DOMAIN ),
						'false'		=>	__( 'Disabled', WPRSS_TEXT_DOMAIN ),
					)
				),
				'word_limit'	=>	array(
					'label'			=>	__( 'Word Limit', WPRSS_TEXT_DOMAIN ),
					'placeholder'	=>	__( 'Default', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'number',
				),
				'trimming_type'	=>	array(
					'label'			=>	__( 'Trimming type', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'dropdown',
					'default'		=>	'general',
					'settings'		=>	FALSE,
					'options'		=>	array(
						'general'		=>	__( 'Use General Setting', WPRSS_TEXT_DOMAIN ),
						'db'			=>	__( 'Trim the content', WPRSS_TEXT_DOMAIN ),
						'excerpt'		=>	__( 'Generate an excerpt', WPRSS_TEXT_DOMAIN ),
					),
				),
				'trimming_ellipsis' => array(
					'label'		=>	__( 'Add ellipsis', WPRSS_TEXT_DOMAIN ),
					'type'		=>	'checkbox',
					'default'	=>	'false',
				),
			),

            'integrations' => array(
                'powerpress_enabled' => array(
                    'label'         => __('PowerPress', 'wprss'),
                    'desc'          => __('Enable this option to attempt to import audio files and show the PowerPress audio player.', 'wprss'),
                    'type'			=>	'checkbox',
                ),
            ),

            'wysiwyg_editors' => array(
				'disable_visual_editor' => array(
					'label'         => __( 'Disable visual editors', WPRSS_TEXT_DOMAIN ),
					'desc'          => __( 'Disable the visual editor tabs in the Append and Prepend to Content options. This requires saving the feed source to take effect.', WPRSS_TEXT_DOMAIN ),
					'type'			=>	'checkbox',
					'default'		=>	'false',
					'settings'		=>	FALSE,
				),
            )
		);
		$fields = apply_filters( 'wprss_ftp_meta_fields', $fields );

		if ( $what !== '' && $what !== 'all' )
			return $fields[$what];

		if ( strtolower( $what ) === 'all' ) {
			$flattened = array();
			foreach ( $fields as $id => $section_fields ) {
				$flattened += $section_fields;
			}
			return $flattened;
		}

		return $fields;
	}


	/**
	 * Adds a multi language metabox
	 *
	 * @since 1.3
	 */
	public function add_multilanguage_metabox( $fields ) {
		$languages = WPRSS_FTP_Utils::get_wpml_languages();
		$fields['multi-language'] = array(
			'post_language'	=>	array(
				'label'			=>	__( 'Post Language', WPRSS_TEXT_DOMAIN ),
				'desc'			=>	__( 'Choose the language to assign to posts imported from this source', WPRSS_TEXT_DOMAIN ),
				'type'			=>	'dropdown',
				'options'		=>	$languages
			)
		);
		return $fields;
	}


	/**
	 * @since 3.3.2
	 * @param array|string|mixed $callable A callable, or some data.
	 * @param array|mixed|null $args An argument or array of arguments to the callback.
	 * @return \WP_Error|\WPRSS_Command A command ready to be called if appropriate; otherwise the data.
	 */
	public function get_new_data_source( $callable, $args = null ) {
		if ( !is_null( $args ) ) {
			if ( !is_callable( $callable ) )
				return new WP_Error ( 'get_new_data_source_invalid_callable', 'Could not create new command: a valid callable must me supplied');

			return new WPRSS_Command( $callable, $args );
		}

		return is_callable( $callable, true )
			? new WPRSS_Command( $callable )
			: $callable;
	}


#== META BOX RENDERERS =================================================================================

    /**
     * The callback given to {@see add_meta_box()}.
     *
     * This should output the HTML of the metabox content.
     *
     * @param WP_Post $object The object, the page for which the metabox is being displayed on.
     * @param array $box Information about the metabox. Has the following indices:
     *  - 'id'          The metabox ID, as specified when calling {@see add_meta_box()};
     *  - 'title'       The title of the metabox, as specified when calling {@see add_meta_box()};
     *  - 'callback'    The callback as given to {@see add_meta_box()}, and which represents this very method;
     *  - 'args'        Any additional args, as given to {@see add_meta_box()}, and which is `null` by default.
     */
	public function render_general_metabox($object, $box){ $this->render_metabox('general', $object, $box); }
	public function render_taxonomy_metabox($object, $box) { $this->render_metabox('tax', $object, $box); }
	public function render_images_metabox($object, $box) { $this->render_metabox('images', $object, $box); }
	public function render_prepend_metabox($object, $box) { $this->render_metabox('prepend', $object, $box); }
	public function render_append_metabox($object, $box) { $this->render_metabox('append', $object, $box); }
	public function render_extraction_metabox($object, $box) { $this->render_metabox('extraction', $object, $box); }
	public function render_custom_fields_metabox($object, $box) { $this->render_metabox('custom_fields', $object, $box); }
	public function render_word_trimming_metabox($object, $box) { $this->render_metabox('word_trimming', $object, $box); }
	public function render_wysiwyg_editors_metabox($object, $box) { $this->render_metabox('wysiwyg_editors', $object, $box); }
	public function render_multi_language_metabox($object, $box) { $this->render_metabox('multi-language', $object, $box); }
	public function render_author_metabox($object, $box) {
		//$this->render_metabox('author');
		global $post;
		?>
			<table class="form-table wprss-form-table">
				<tbody>
					<?php WPRSS_FTP_Settings::get_instance()->render_author_options( $post->ID, __( 'Post Author', WPRSS_TEXT_DOMAIN ), 'def_author' ); ?>
				</tbody>
			</table>
		<?php
	}
    public function render_integrations_metabox($object, $box) {
	    ?>

        <p><?= __('Configure integrations with other plugins', 'wprss') ?></p>

        <?php
	    $this->render_metabox('integrations',$object, $box);
	}

	/**
	 * Renders the meta box specified by the parameter.
	 * The function will use the get_meta_fields function to retrieve the fields for
	 * that particular meta box and render them.
	 *
	 * @since 1.0
     * @param WP_Post $object The object, the page for which the metabox is being displayed on.
     * @param array $box Has the following indexes:
     *  - 'id'          The metabox ID, as specified when calling {@see add_meta_box()};
     *  - 'title'       The title of the metabox, as specified when calling {@see add_meta_box()};
     *  - 'callback'    The callback as given to {@see add_meta_box()}, and which represents this very method;
     *  - 'args'        Any additional args, as given to {@see add_meta_box()}, and which is `null` by default.
	 */
	public function render_metabox( $metabox, $object, $box ) {
		global $post;

		$help = class_exists('WPRSS_Help') ? WPRSS_Help::get_instance() : null;
        $args = is_null($box['args']) ? array() : $box['args'];

		# The main metabox template
		ob_start(); ?>
            {{before_fields}}
			<table class="form-table wprss-form-table">
				<tbody>
					{{fields}}
				</tbody>
			</table>
		<?php $template = ob_get_clean();


		# The field template to use for all fields
		ob_start(); ?>
			<tr {{hr}}>
				<th><label for="{{id}}">{{label}}</label></th>
				<td>
					{{before}}
					{{input}}
					{{after}}
					{{separator}}<label for="{{id}}"><span class="description">{{desc}}</span></label>
				</td>
			</tr>
		<?php $field_template = ob_get_clean();


		# Generate the fields HTML using the template
		$meta_fields = $this->get_meta_fields( $metabox, $post->ID );
		$fields = '';
		$options = WPRSS_FTP_Settings::get_instance()->get_computed_options( $post->ID );

		# Render each field
		foreach ( $meta_fields as $field_id => $field ) {
			if ( isset( $field['ignore']) && $field['ignore'] === TRUE ) {
				continue;
			}

			$hr = ( isset( $field['add_hr'] ) && $field['add_hr'] === TRUE )? 'class="wprss-tr-hr"': '';

			$field_html = '';

			$id = self::META_PREFIX . $field_id;
			# Get the meta value for this field, if it exists
			$nid = substr( $id, strlen( self::META_PREFIX ) );
			$meta = array_key_exists($nid, $options) ? $options[ $nid ] : '';
			if ( isset( $field['settings'] ) && $field['settings'] === FALSE ) {
				$meta = get_post_meta( $post->ID, $id, true );
			}
			if ( isset( $field['default'] ) && $meta === '' ) {
				$meta = $field['default'];
			}

			if ( isset( $field['custom_render'] ) && !empty( $field['custom_render'] ) ) {
				$field_html = call_user_func_array( $field['custom_render'], array( $post, $field_id, $field, $meta ) );
			}
			else {

				$separator = '<br/>';
				$before = '';
				$after = '';

				# Generate the field input
				$field_input = '';

				$field_type_templates = array(
					'text'		=> '<input type="text" id="{{id}}" name="{{name}}" value="{{value}}" placeholder="{{placeholder}}" {{properties}}/>',
					'number' 	=> '<input class="wprss-number-roller" type="number" id="{{id}}" name={{name}} min="0" placeholder="{{placeholder}}" value="{{value}}" {{properties}}/>',
					'textarea'	=> '<textarea id="{{id}}" name="{{name}}" cols="60" rows="4" {{properties}}>{{value}}</textarea>'
				);

				switch( $field['type'] ) {
					default:
					case 'text':
					case 'number':
					case 'textarea':
						// If the field is a textarea, and the meta value saved in DB is an array
						if ( $field['type'] === 'textarea' && is_array( $meta ) ) {
							// split the array into strings
							$new_meta = '';
							foreach ( $meta as $entry ) {
								$new_meta .= $entry . "\n";
							}
							$meta = $new_meta;
						}
						$substitutions = array(
							'id'			=>	$id,
							'name'			=>	$id,
							'value'			=>	trim( esc_attr( $meta ) ),
							'placeholder'	=>	( isset( $field['placeholder'] )? $field['placeholder'] : 'Default' ),
							'properties'	=>	( isset( $field['properties'] )? $field['properties'] : '' ),
						);
						$field_input = WPRSS_FTP_Utils::template( $field_type_templates[ $field['type'] ], $substitutions );
						break;
					case 'checkbox':
						$field_input = WPRSS_FTP_Utils::boolean_to_checkbox(
							WPRSS_FTP_Utils::multiboolean( $meta ),
							array(
								'id'		=>	$id,
								'name'		=>	$id,
								'class'		=>	'meta-checkbox',
								'value'		=>	'true',
								'disabled'	=>	( isset( $field['disabled'] )? $field['disabled'] : FALSE ),
							)
						);
						$separator = '';
						break;
					case 'msg':
						$field_input = '<p id="'.$id.'">'.$field['text'].'</p>';
						break;
					case 'dropdown':
						$choices = $this->resolve_data_source( $field['options'] );
						$field_input = WPRSS_FTP_Utils::array_to_select(
							$choices,
							array(
								'id'		=> $id,
								'name'		=> $id,
								'selected'	=> $meta,
								'disabled'	=>	( isset( $field['disabled'] )? $field['disabled'] : FALSE ),
							)
						);
						break;
				}

				if ( $help !== null ) {
					$after .= $help->do_tooltip( WPRSS_FTP_HELP_PREFIX.$field_id );
				}

				$label = isset( $field['label'] )? $field['label'] : '';
				$desc = isset( $field['desc'] )? $field['desc'] : '';

				# Finish the field using the template
				$field_html = WPRSS_FTP_Utils::template(
					$field_template,
					array(
						'id'		=>	$id,
						'input'		=>	$field_input,
						'label'		=>	$label,
						'desc'		=>	$desc,
						'separator'	=>	$separator,
						'hr'		=>	$hr,
						'before'	=>	$before,
						'after'		=>	$after
					)
				);

			} // End of if statement that checks if using a custom renderer

			$fields .= $field_html;
		}

		echo WPRSS_FTP_Utils::template($template, array(
            'before_fields'     => isset($args['before_fields']) ? $args['before_fields'] : '',
            'fields'            => $fields
        ));
		echo '<span data-post-id="'.$post->ID.'" id="wprss-ftp-post-id"></span>';
	}


	/**
	 * Resolves a data source created with {@see get_new_data_souce()},
	 * i.e. calls the appropriate function and gets the returned value.
	 *
	 * @since 3.3.2
	 * @param WPRSS_Command|callable $source The data source to get data from
	 * @return mixed The data from the data source
	 */
	public function resolve_data_source( $source ) {
		if ( is_callable( $source ) )
			return call_user_func_array( $source, array() );

		if( $source instanceof WPRSS_Command )
			return $source->call();

		return $source;
	}


	/**
	 * Renders the taxonomies metabox
	 *
	 * @since 3.1
	 */
	public function render_taxonomies( $post ) {
		$meta = $this->get( $post->ID, 'taxonomies' );
		$post_type = $this->get( $post->ID, 'post_type' );
		// Check if post has old taxonomies options
		if ( $meta === '' ) {
			$meta = self::convert_post_taxonomy_meta( $post->ID );
		}

		ob_start();
		echo wprss_ftp_taxonomy_sections( $post_type, $meta );
		?>

		<tr id="wprss-ftp-taxonomies-add-section" class="wprss-tr-hr">
			<th>
				<button type="button" class="button-secondary" id="ftp-add-taxonomy">
					<i class="fa fa-fw fa-plus"></i> <?php _e( 'Add New', WPRSS_TEXT_DOMAIN ); ?>
				</button>
				<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'taxonomies' ); ?>
			</th>
			<td></td>
		</tr>

		<?php return ob_get_clean();
	}


	/**
	 * Renders the image minimum dimensions meta fields.
	 *
	 * @since 1.0
	 */
	public function render_image_min_dimensions( $post ) {
		ob_start();
		$options = WPRSS_FTP_Settings::get_instance()->get_computed_options( $post->ID );
		$width = $options['image_min_width'];
		$height = $options['image_min_height'];
		$width_name = self::META_PREFIX . 'image_min_width';
		$height_name = self::META_PREFIX . 'image_min_height';
		?>

		<tr>
			<th>
				<label><?php _e( 'Image minimum dimensions', WPRSS_TEXT_DOMAIN ); ?></label>
			</th>

			<td>
				<i class="fa fa-fw fa-arrows-h" title="<?php _e( 'Image Width', WPRSS_TEXT_DOMAIN ); ?>"></i>
				<input class="wprss-number-roller" type="number" id="<?php echo $width_name; ?>"  name="<?php echo $width_name; ?>" min="0" placeholder="<?php _e( 'Width', WPRSS_TEXT_DOMAIN ); ?>" value="<?php echo $width ;?>" />
				<i class="fa fa-fw fa-times"></i>
				<input class="wprss-number-roller" type="number" id="<?php echo $height_name; ?>" name="<?php echo $height_name; ?>" min="0" placeholder="<?php _e( 'Height', WPRSS_TEXT_DOMAIN ); ?>" value="<?php echo $height ;?>" />
				<i class="fa fa-fw fa-arrows-v" title="<?php _e( 'Image Height', WPRSS_TEXT_DOMAIN ); ?>"></i>
				<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'image_min_dimensions' ); ?>
			</td>
		</tr>

		<script type="text/javascript">
			(function($){
				$(document).ready( function(){

                    var CLASS_INACTIVE_META = 'wprss-ftp-inactive-meta';
                    var META_PREFIX = '<?php echo self::META_PREFIX; ?>';

					// Get pointers to elements
					var wprss_ftp_use_featured_image = $( '#' + META_PREFIX + 'use_featured_image' );
					var wprss_ftp_featured_image = $( '#' + META_PREFIX + 'featured_image' );
					var wprss_ftp_remove_ft_image = $( '#' + META_PREFIX + 'remove_ft_image' );
					var wprss_ftp_must_have_ft_image = $( '#' + META_PREFIX + 'must_have_ft_image' );
					var wprss_ftp_save_ft_image = $( '#' + META_PREFIX + 'save_images_locally' );
					var wprss_ftp_min_width_image = $( '#' + META_PREFIX + 'image_min_width' );
					var wprss_ftp_min_height_image = $( '#' + META_PREFIX + 'image_min_height' );

					// Prepare the check function
					var wprss_ftp_featured_image_checked = function(){
						var is_unchecked = !wprss_ftp_use_featured_image.is( ':checked' );
						// disabled the fields
						wprss_ftp_featured_image.prop( 'disabled', is_unchecked );
						wprss_ftp_remove_ft_image.prop( 'disabled', is_unchecked );
						wprss_ftp_must_have_ft_image.prop( 'disabled', is_unchecked );
						// Grey out the other elements
						wprss_ftp_featured_image.parent().toggleClass( CLASS_INACTIVE_META, is_unchecked ).prev().toggleClass( CLASS_INACTIVE_META, is_unchecked );
						wprss_ftp_remove_ft_image.parent().toggleClass( CLASS_INACTIVE_META, is_unchecked ).prev().toggleClass( CLASS_INACTIVE_META, is_unchecked );
						wprss_ftp_must_have_ft_image.parent().toggleClass( CLASS_INACTIVE_META, is_unchecked ).prev().toggleClass( CLASS_INACTIVE_META, is_unchecked );
					}

					// run the check on page load
					wprss_ftp_featured_image_checked();

					// run the check when the use_featured_image checkbox is clicked
					wprss_ftp_use_featured_image.click( wprss_ftp_featured_image_checked );

                    var wprss_ftp_maybe_disable_image_dimensions = function() {
                        var is_use = wprss_ftp_use_featured_image.is( ':checked' );
                        var is_save = wprss_ftp_save_ft_image.is( ':checked' );
                        var is_disable = !is_use && !is_save;

                        wprss_ftp_min_width_image.prop('disabled', is_disable);
                        wprss_ftp_min_height_image.prop('disabled', is_disable);

                        wprss_ftp_min_width_image.parent().toggleClass(CLASS_INACTIVE_META, is_disable)
                                .prev().toggleClass(CLASS_INACTIVE_META, is_disable);
                    };

                    wprss_ftp_maybe_disable_image_dimensions();
					wprss_ftp_use_featured_image.click( wprss_ftp_maybe_disable_image_dimensions );
					wprss_ftp_save_ft_image.click( wprss_ftp_maybe_disable_image_dimensions );
				});
			})(jQuery);
		</script>

		<?php
		return ob_get_clean();
	}


	/**
	 * Renders the prepend to post editor
	 *
	 * @since 1.6
	 */
	public function render_post_prepend_editor( $post, $field_id, $field, $meta ) {
		ob_start();
		$prepend = $this->get_meta( $post->ID, 'post_prepend' );
		?>
        </table>
        <hr/>
        <table class="form-table wprss-form-table">
			<tr>
				<td style='width: 100%;'>

					<!-- PREPENDER -->
					<div id="post-prepend-container">
						<div id="post-prepend-editor-container">
							<p><?php _e("Add text at the beginning of posts' content.", WPRSS_TEXT_DOMAIN); ?></p>
							<?php
								$editor_settings = array(
									'media_buttons'		=>	FALSE,
									'textarea_name'		=>	self::META_PREFIX . 'post_prepend',
								);
								wp_editor( $prepend, 'wprsspostprepend', $editor_settings ); ?>
						</div>
					</div>

					<div id="post-prepend-placeholder">
						<p><span class="description"><?php echo $field['desc']; ?></span></p>
						<br/>
						<?php $this->get_append_placeholders(); ?>
					</div>

				</td>
			</tr>
        </table>
		<?php
		return ob_get_clean();
	}


	/**
	 * Renders the append to post editor
	 *
	 * @since 1.6
	 */
	public function render_post_append_editor( $post, $field_id, $field, $meta ) {
		ob_start();
		$append = $this->get_meta( $post->ID, 'post_append' );
		?>
        </table>
        <hr/>
        <table class="form-table wprss-form-table">
			<tr>
				<td style='width: 100%;'>

					<!-- APPENDER -->
					<div id="post-append-container" class="hidden">
						<div id="post-append-editor-container">
							<p><?php _e("Add text at the end of posts' content.", WPRSS_TEXT_DOMAIN); ?></p>
							<?php
								$editor_settings = array(
									'media_buttons'		=>	FALSE,
									'textarea_name'		=>	self::META_PREFIX . 'post_append',
								);
								wp_editor( $append, 'wprsspostappend', $editor_settings ); ?>
						</div>
					</div>

					<div id="post-prepend-placeholder">
						<p><span class="description"><?php echo $field['desc']; ?></span></p>
						<br/>
						<?php $this->get_append_placeholders(); ?>
					</div>

				</td>
			</tr>
        </table>
		<?php
		return ob_get_clean();
	}


	/**
	 * Renders the extraction rules settings
	 *
	 * @since 2.6
	 */
	public function render_extraction_rules( $post, $field_id, $field, $meta ) {
		$id = self::META_PREFIX . $field_id;

		if ( !is_array( $meta ) ) {
			$meta = WPRSS_FTP_Extractor::get_extraction_rules( $post->ID );
		}

		// Set the rules to an empty array, if there is only 1 empty rule
		if ( count($meta) === 1 && $meta[0] === '' ) {
			$meta = array();
		}

		// Get the manipulation types meta value
		$manip_types_meta = self::get_meta( $post->ID, 'extraction_rules_types' );
		// If it is not an array, set it to an empty array
		if ( ! is_array( $manip_types_meta ) ) {
			$manip_types_meta = array();
		}

		//== PREPARE THE HTML ===

		// The class of a each section
		$input_section_class = 'wprss-ftp-extraction-rule-section';
		// The text field for each section
		$input_field = '<input type="text" name="' . self::META_PREFIX . 'extraction_rules[]" value="{{value}}" placeholder="'.__( 'CSS Selector', WPRSS_TEXT_DOMAIN ).'" /> ';
		// The button for each section
		$remove_btn = '<button type="button" class="button-secondary wprss-ftp-extraction-rule-remove"><i class="fa fa-trash-o"></i></button>';
		// The manipulation type dropdown
		$manip_dropdown = '{{manip_types}}';
		// The whole section
		$input_section = "<div class='$input_section_class'>$input_field $manip_dropdown $remove_btn</div>";


		// For each extraction rule, print out a section
		$input = '';
		$i = 0;
		foreach ( $meta as $rule ) {
			// Get the type for this rule
			$type = ( isset( $manip_types_meta[$i] ) )? $manip_types_meta[$i] : 'remove';
			// Generate the dropdown
			$manip_types = WPRSS_FTP_Utils::array_to_select(
				$field['manip_options'],
				array(
					'class'		=>	'wprss-ftp-extraction-rules-manipulation-type',
					'name'		=>	self::META_PREFIX . 'extraction_rules_types[]',
					'selected'	=>	$type,
				)
			);
			// Generate the final input field
			$input .= WPRSS_FTP_Utils::template(
				$input_section,
				array(
					'value'			=> esc_attr( $rule ),
					'manip_types'	=> $manip_types,
				)
			);
			// Increment counter
			$i++;
		}


		// Replace the {{manip_types}} placeholder with the default dropdown, to be used as a template in JS, when adding new fields
		$input_section = WPRSS_FTP_Utils::template(
			$input_section,
			array(
				'manip_types'	=>	WPRSS_FTP_Utils::array_to_select(
					$field['manip_options'],
					array(
						'class'		=>	'wprss-ftp-extraction-rules-manipulation-type',
						'name'		=>	self::META_PREFIX . 'extraction_rules_types[]',
						'selected'	=>	'remove',
					)
				),
			)
		);

		// Show the field row, with the prepare input fields for the extraction rules
		ob_start(); ?>
			<tr>
				<th><label for="<?php echo $id; ?>"><?php echo $field['label']; ?></label></th>
				<td>
					<?php echo $input; ?>

					<span id="wprss-ftp-extraction-rules-end"></span>
					<button type="button" class="button-primary wprss-ftp-add-extraction-rule">
						<i class="fa fa-plus"></i> <?php _e( 'Add New', WPRSS_TEXT_DOMAIN ); ?>
					</button>

					<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.$field_id ); ?>

					<script type="text/javascript">
						var wprss_input_field_template = "<?php echo addslashes( $input_section ); ?>";
					</script>
				</td>
			</tr>
		<?php
		return ob_get_clean();
	}


	/**
	 * Renders the custom fields mapping option
	 *
	 * @since 2.8
	 */
	public function render_custom_fields( $post, $field_id, $field, $meta ) {
		$META_PREFIX = self::META_PREFIX;
		$id = $META_PREFIX . $field_id;

		// Get the RSS tags, RSS namespaces options and the custom fields
		//$saved_namespaces = WPRSS_FTP_Settings::get_instance()->get( 'user_feed_namespaces' );
		$saved_namespaces = WPRSS_FTP_Settings::get_instance()->get_namespaces();

		?>
		<p>
			<?php _e( 'This allows you to retrieve data from any RSS tag in feed items, then store it in a custom meta field in imported posts.', WPRSS_TEXT_DOMAIN ); ?>
		</p>
		<?php

		// If there are no saved namespaces, show a message and exit function
		if ( !is_array( $saved_namespaces ) || count( $saved_namespaces ) === 0 ) {
			?>
				<p>
					<?php
						$link_attrs = 'href="' . admin_url( 'edit.php?post_type=wprss_feed&page=wprss-aggregator-settings&tab=ftp_settings#wprss-ftp-add-namespace' ) . '" target="wprss_ftp_settings"';
						printf( __( 'To use this option, you first need to add the namespaces that you want to use in the <a %s>Feed to Post settings page</a>.', WPRSS_TEXT_DOMAIN ), $link_attrs );
					?>
				</p>
			<?php return;
		}

		// Get the meta values
		$rss_namespaces = $this->get_meta( $post->ID, 'rss_namespaces' );
		$rss_namespaces = ( $rss_namespaces === '' )? array() : $rss_namespaces;
		$rss_tags = $this->get_meta( $post->ID, 'rss_tags' );
		$rss_tags = ( $rss_tags === '' )? array() : $rss_tags;
		$custom_fields = $this->get_meta( $post->ID, 'custom_fields' );
		$custom_fields = ( $custom_fields === '' )? array() : $custom_fields;

		// Prepare the array of namespaces
		// Add an entry to selected a namespace
		// And make each entry use the name as both value and label
		$namespaces_array = array_merge(
			array( '' => __( 'Choose a namespace', WPRSS_TEXT_DOMAIN ) ),
			array_combine( $saved_namespaces['names'], $saved_namespaces['names'] )
		);

		// Generate field templates to use in loop below and in JS
		$namespace_dropdown_template = array(
			'options'		=>	$namespaces_array,
			'attributes'	=>	array(
				'name'			=>	self::META_PREFIX . 'rss_namespaces[]',
				'selected'		=>	''
			)
		);
		$rss_tag_placeholder = __( 'RSS Tag', WPRSS_TEXT_DOMAIN );
		$rss_tag_field = "<input type='text' name='{$META_PREFIX}rss_tags[]' value='{{value}}' placeholder='$rss_tag_placeholder' />";
		$custom_field_placeholder = __( 'Meta field name', WPRSS_TEXT_DOMAIN );
		$custom_field_field = "<input type='text' name='{$META_PREFIX}custom_fields[]' value='{{value}}' placeholder='custom_field_placeholder' />";
		$section_class = "wprss-ftp-custom-fields-section";

		$remove_btn_title_text = __( 'Remove', WPRSS_TEXT_DOMAIN );
		$remove_btn = '<button type="button" class="button-secondary wprss-ftp-remove-custom-mapping" title="'.$remove_btn_title_text.'"><i class="fa fa-trash-o"></i></button>';

		ob_start();

		// Print a section for each
		for ( $i = 0; $i < count( $rss_namespaces ); $i++ ) {
			// Get the data for the current custom field entry
			$namespace = $rss_namespaces[$i];
			$tag = $rss_tags[$i];
			$custom_field = $custom_fields[$i];
			// Prepare the dropdown
			$namespace_dropdown = $namespace_dropdown_template;
			$namespace_dropdown['attributes']['selected'] = $namespace;

			echo "<div class='$section_class'>";
			echo WPRSS_FTP_Utils::array_to_select( $namespace_dropdown['options'], $namespace_dropdown['attributes'] );
			echo WPRSS_FTP_Utils::template( $rss_tag_field, array( 'value' => $tag ) );
			echo WPRSS_FTP_Utils::template( $custom_field_field, array( 'value' => $custom_field ) );
			echo $remove_btn;
			echo "</div>";
		}
		$saved_custom_mappings = ob_get_clean();

		// Prepare the dropdown template for JS
		$namespace_dropdown_template = WPRSS_FTP_Utils::array_to_select(
			$namespace_dropdown_template['options'],
			$namespace_dropdown_template['attributes']
		);

		// Show the field row, with the prepare input fields for the extraction rules
		ob_start(); ?>
			<tr>
				<th><label for="<?php echo $id; ?>"><?php echo $field['label']; ?></label></th>
				<td>
					<?php echo $saved_custom_mappings; ?>

					<span id="wprss-ftp-custom-fields-marker"></span>

					<button type="button" id="wprss-ftp-add-custom-mapping" class="button-primary">
						<i class="fa fa-plus"></i> <?php _e( 'Add New', WPRSS_TEXT_DOMAIN ); ?>
					</button>

					<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.$field_id ); ?>
					<br/>
					<p>
						<?php
							$settings_link_attrs = 'href="' . admin_url( 'edit.php?post_type=wprss_feed&page=wprss-aggregator-settings&tab=ftp_settings#wprss-ftp-add-namespace' ) . '" target="wprss_ftp_settings"';
							printf( __( 'You can add and change your namespaces from the <a %s>Feed to Post settings page</a>.', WPRSS_TEXT_DOMAIN ), $settings_link_attrs );
						?>
					</p>

					<script type="text/javascript">
						var wprss_ftp_custom_mappings_section_class = "<?php echo addslashes( $section_class ); ?>";
						var wprss_ftp_namespaces_dropdown = "<?php echo addslashes( $namespace_dropdown_template ); ?>";
						var wprss_ftp_rss_tag_field = "<?php echo addslashes( $rss_tag_field ); ?>";
						var wprss_ftp_custom_field_field = "<?php echo addslashes( $custom_field_field ); ?>";
						var wprss_ftp_remove_custom_mapping = "<?php echo addslashes( $remove_btn ); ?>";
					</script>
				</td>
			</tr>

			<tr>
				<th>
					<label for="wprss-ftp-namespace-detector-refresh">
						<?php _e( 'Namespace Detector' ); ?>
					</label>
				</th>

				<td>
					<button type="button" id="wprss-ftp-namespace-detector-refresh" class="button-secondary">
						 <i class="fa fa-search"></i> <?php _e( 'Detect namespaces in Feed Source' ); ?>
					</button>

					<?php if ( class_exists( 'WPRSS_Help' ) ) : ?>
						<?php echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.'namespace_detector' ); ?>
					<?php else: ?>
						<br/>
						<label class="description" for="wprss-ftp-namespace-detector-refresh">
							<?php _e('Use this button to detect the namespaces being used by this feed source.', WPRSS_TEXT_DOMAIN); ?>
						</label>
					<?php endif; ?>

					<div id="wprss-ftp-namespace-detector-results"></div>
				</td>
			</tr>
		<?php
		return ob_get_clean();
	}


	/**
	 * Renders the post site dropdown.
	 *
	 * @since 1.7
	 */
	public function render_post_site_dropdown( $post, $field_id, $field, $meta ) {
		$id = self::META_PREFIX . $field_id;
		$desc = isset( $field['desc'] )? $field['desc'] : '';
		$multisite_and_main_site = WPRSS_FTP_Utils::is_multisite_and_main_site();
		$input = '';
		// If the return value of WPRSS_FTP_Utils::is_multisite_and_main_site()
		// is a string, then it is an error message. Set the description to it.
		if ( is_string( $multisite_and_main_site ) ) {
			$desc = $multisite_and_main_site;
		}
		// Otherwise, if it is boolean TRUE
		elseif ( $multisite_and_main_site === TRUE) {
			// Get the sites and generate a dropdown
			$sites = WPRSS_FTP_Utils::get_sites();
			$input = WPRSS_FTP_Utils::array_to_select(
				$sites,
				array(
					'id'		=> $id,
					'name'		=> $id,
					'selected'	=> $meta,
				)
			);
		}
		// If using multisite but not the main site, simply show the site name.
		elseif ( $multisite_and_main_site === FALSE && is_multisite() ) {
			$current_site = get_bloginfo('name');
			$meta = get_current_blog_id();
			$input = "<input type='hidden' name='$id' id='$id' value='$meta' /><b>{$current_site}</b>";
			$desc = '';
		}
		// If neither multisite nor main site, do not show the row
		else return '';

		// Show the field row
		ob_start(); ?>
			<tr>
				<th><label for="<?php echo $id; ?>"><?php echo $field['label']; ?></label></th>
				<td>
					<?php echo $input; ?>
					<?php
						if ( class_exists( 'WPRSS_Help' ) ) {
							echo WPRSS_Help::get_instance()->do_tooltip( WPRSS_FTP_HELP_PREFIX.$field_id );
						}
					?>
					<br/><label class="description" for="<?php echo $id; ?>"><?php echo $desc; ?></label>
				</td>
			</tr>
		<?php
		return ob_get_clean();
	}


	/**
	 * Renders the custom default featured image metabox
	 */
	public function post_thumbnail_meta_box() {
		global $post;
		post_thumbnail_meta_box($post);

		?>
		<script type="text/javascript">

		(function($){
			$(document).ready(function(){
				// Default featured image metabox fix
				$('#postimagediv > h2.hndle > span').text( "<?php _e( 'Fallback Featured Image' ) ?>" );
			});
		})(jQuery);

		</script>
		<?php
	}


#== META DATA SAVING ===================================================================================

	/**
	 * Saves the post's meta data, using the known meta fields in the get_meta_fields() method.
	 *
	 * @since 1.0
	 */
	public function save_post_meta( $post_id, $post ) {
		# Get all meta fields
		$meta_fields = self::get_meta_fields( 'all' );

		# For each meta field ...
		foreach ( $meta_fields as $id => $field ) {

			# Get the ID with the prefix
			$id = self::META_PREFIX . $id;

			# Get the current meta value, and the new value from POST
			$old = get_post_meta( $post_id, $id, true );

			$new = '';
			// If the meta field is not found in the POST request
			if ( isset( $_POST[ $id ] ) )
				$new = $_POST[ $id ];

			if ( $id === 'wprss_ftp_post_terms' && !isset( $_POST[ $id ] ) )
				$new = array();

			// Check if meta data is updated or deleted
			if ( $new && $new != $old ) {
				update_post_meta( $post_id, $id, $new );
			} elseif ( $new === '' && $old ) {
				delete_post_meta( $post_id, $id, $old );
			}
		}

		// @todo add isset checking
		$final_tax = array();
		if ( $post_id && ! empty( $_POST[ self::META_PREFIX.'post_taxonomy' ] ) ) {
			$taxonomies = $_POST[ self::META_PREFIX.'post_taxonomy' ];
			$n = max( array_keys( $taxonomies ) );
			$terms = isset( $_POST[ self::META_PREFIX.'post_terms' ] )? $_POST[ self::META_PREFIX.'post_terms' ] : array_fill( 0, $n + 1, array() );
			$autos = isset( $_POST[ self::META_PREFIX.'auto_terms' ] )? $_POST[ self::META_PREFIX.'auto_terms' ] : array_fill( 0, $n + 1, "false" );
			$subjects = isset( $_POST[ self::META_PREFIX.'filter_subject' ] )? $_POST[ self::META_PREFIX.'filter_subject' ] : array_fill( 0, $n + 1, "" );
			$keywords = isset( $_POST[ self::META_PREFIX.'filter_keywords' ] )? $_POST[ self::META_PREFIX.'filter_keywords' ] : array_fill( 0, $n + 1, "" );
			$compare_methods = isset( $_POST[ self::META_PREFIX.'post_taxonomy_compare_method' ] )
                ? $_POST[ self::META_PREFIX.'post_taxonomy_compare_method' ]
                : array_fill( 0, $n + 1, $this->getDefaultTaxonomyCompareMethod() );

			for ( $i = 0; $i <= $n; $i++ ) {
				if ( ! isset( $taxonomies[ $i ] ) || ( ! isset( $terms[ $i ] ) && ! isset( $autos[ $i ] ) ) ) {
					continue;
				}

				$tax = array();
				$tax['taxonomy'] = $taxonomies[ $i ];
				$tax['terms'] = $terms[ $i ];
				$tax['auto'] = $autos[ $i ];
				$tax['filter_subject'] = $subjects[ $i ];
				$tax['filter_keywords'] = $keywords[ $i ];
                $tax['post_taxonomy_compare_method'] = $compare_methods[$i];
				$final_tax[] = $tax;
			}
		}
		update_post_meta( $post_id, self::META_PREFIX.'taxonomies', $final_tax );
	}


#== CORE OVERRIDES ============================================================================

	/**
	 * Override the core's meta fields.
	 *
	 * @since 2.8
	 */
	public function change_core_meta_fields( $fields ) {
		// Return the fields
		return $fields;
	}


#== MISC ======================================================================================


	/**
	 * Converts the old taxonomy meta fields into the new format.
	 * Does NOT save into database.
	 *
	 * @since 3.1
	 * @param int $post_id The ID of the post
	 * @return array The new meta fields
	 */
	public static function convert_post_taxonomy_meta( $post_id ) {
		// Prepare the old fields
		$old_fields = array(
			'post_taxonomy',
			'post_terms',
			'post_auto_tax_terms',
			'post_tags'
		);
		// Prepare the new fields array
		$meta = array();
		// Generate the new fields
		foreach( $old_fields as $old_field ) {
			$meta[ $old_field ] = self::get_instance()->get( $post_id, $old_field );
		}
		// Return the new fields
		return self::convert_taxonomy_option( $meta );
	}


	/**
	 * Converts the given set of old taxonomy options into the new format.
	 *
	 * @since 3.1
	 * @param array $array The array of old fields
	 * @return array The new meta fields
	 */
	public static function convert_taxonomy_option( $arr ) {
		// Get the array data
		$tax = $arr['post_taxonomy'];
		$terms = $arr['post_terms'];
		$auto = $arr['post_auto_tax_terms'];
		$tags = $arr['post_tags'];
		$tags = $tags === 'false'? '' : $tags;

		// Construct the default taxonomy entry
		$default = array(
			'taxonomy'	=>	$tax,
			'terms'		=>	$terms,
			'auto'		=>	$auto
		);

		// Generate the new option
		$new = array( $default );

		// If the tags option is set, then we must save this as well, so that the user does not lose his/her settings
		if ( !empty($tags) ) {
			$tags = WPRSS_FTP_Utils::trim_explode(',', $tags);
			$new_tags = array();
			// Create the tags
			foreach( $tags as $tag ) {
				$exists = term_exists( $tag, 'post_tag' );
				if ( $exists === 0 || $exists === NULL ) {
					$exists = wp_insert_term( $tag, 'post_tag' );
				}
				$tag_id = $exists['term_id'];
				$tag_obj = get_term_by( 'id', $tag_id, 'post_tag' );
				$tag_slug = $tag_obj->slug;
				$new_tags[] = $tag_slug;
			}
			// Add another taxonomy entry for the tags
			$new[] = array(
				'taxonomy'	=>	'post_tag',
				'terms'		=>	$new_tags,
				'auto'		=>	'false'
			);
		}

		return $new;
	}


	/*
	 * Returns the saved namespaces
	 *
	 * @since 2.9.6
	 */
	public static function get_saved_namespaces() {
		$saved_namespaces = WPRSS_FTP_Settings::get_instance()->get_namespaces();
		// Prepare the array of namespaces
		// Add an entry to selected a namespace
		// And make each entry use the name as both value and label
		return json_encode(
			array_merge(
				array( '' => __( 'Choose a namespace', WPRSS_TEXT_DOMAIN ) ),
				array_combine( $saved_namespaces['names'], $saved_namespaces['names'] )
			)
		);
	}



	/**
	 * Returns the user array that creates the user dropdown in the authors metabox.
	 *
	 * Developer note: Using array_merge was reordering the array keys, causing the keys,
	 * which signified the user id, to cause the plugin to assign incorrect authors.
	 * This copying of arrays by brute force ensures that the order of elements and the
	 * numbering of keys is retained.
	 *
	 * @param bool|integer|string $user_ids A user ID, or login, or an array of such
	 * @param bool $existing_only If true, returns only existing users in a flat array. Otherwise, returns a structure with additional data.
	 * @param bool $login_names If true, will return an array where keys are login names. Otherwise, the keys will be IDs. Values are the login names regardless.
	 * @since 2.0
	 */
	public static function get_users_array( $user_ids = false, $existing_only = false, $login_names = false ) {
		// Get the users
		$users =  WPRSS_FTP_Settings::get_users( true, $user_ids );

		// Copy all users into this array
		$user_options = array();
		foreach ( $users as $key => $value ) {
			$user_options[$login_names ? $value : $key] = $value;
		}
		// Return only existing if needed
		if( $existing_only ) return $user_options;

		// Create a new array
		$return_array = array( '.' => 'Author in feed' );
		$existing_key = __( 'Existing user', WPRSS_TEXT_DOMAIN );
		$return_array[ $existing_key ] = $user_options;

		// Return the array
		return $return_array;
	}


	/**
	 * Returns the append placeholders for post_append
	 *
	 * @since 1.6
	 */
	public function get_append_placeholders() {
		$placeholders = WPRSS_FTP_Appender::get_placeholders();
		$s = ceil( count( $placeholders ) / 3 );
		$i = 0;
		?>
		<table id="wprss-ftp-placeholders-table" cellpadding="1">
			<tbody>
				<tr>
					<?php foreach ($placeholders as $placeholder => $desc) : ?>
						<td title="<?php echo esc_attr($desc); ?>"><?php echo $placeholder; ?></td>
						<?php if ( (++$i % $s) === 0 ) echo '</tr><tr>'; ?>
					<?php endforeach; ?>
				</tr>
				<tr>
					<?php
						$meta_title = __( "The custom meta field 'xyz' of the imported post. Change 'xyz' to the name of any meta field you want.", WPRSS_TEXT_DOMAIN );
						$source_meta_title = __( "The custom meta field 'xyz' of this feed source. Change 'xyz' to the name of any meta field you want.", WPRSS_TEXT_DOMAIN );
					?>
					<td title="<?php echo $meta_title; ?>">{{meta : xyz}}</td>
					<td title="<?php echo $source_meta_title; ?>">{{source_meta : xyz}}</td>
				</tr>
			</tbody>
		</table>
		<?php
	}


	/**
	 * Fixed incorrect meta value for multisite option for all existing feed sources
	 *
	 * @since 1.8.3
	 */
	public static function multisite_fix() {
		if ( is_multisite() ) {
			global $switched;
			$current_site_id = get_current_blog_id();
			$site_ids = array_keys( WPRSS_FTP_Utils::get_sites() );

			for( $i = 0; $i < count( $site_ids ); $i++ ) {
				$site_id = $site_ids[$i];
   				$switch_success = switch_to_blog( $site_id );
   				if ( $switch_success === FALSE ) continue;

				$feed_sources = wprss_get_all_feed_sources();

				if( $feed_sources->have_posts() ) {
					while ( $feed_sources->have_posts() ) {
						$feed_sources->the_post();

						$post_site = get_post_meta( get_the_ID(), WPRSS_FTP_Meta::META_PREFIX . 'post_site', TRUE );

						if ( $post_site === '' || $post_site === FALSE || strtolower( strval( $post_site ) ) == 'false' ) {
							update_post_meta( get_the_ID(), WPRSS_FTP_Meta::META_PREFIX . 'post_site', get_current_blog_id() );
						}

					}

					// Restore the $post global to the current post in the main query
					wp_reset_postdata();

				} // end of have_posts()

			} // End of site loop
			switch_to_blog( $current_site_id );
		} // End of multisite check
	}


	public function get_post_types( $source_id = null ) {
		$post_types = WPRSS_FTP_Settings::get_post_types();
		if ( is_null($source_id) ) {
			return $post_types;
		}

		$assigned_type = self::get_instance()->get_meta( $source_id, 'post_type' );
		if( $assigned_type && !isset($post_types[$assigned_type]) ) {
			$post_types[$assigned_type] = sprintf( '%1$s (%2$s)', $assigned_type, __( 'Not Registered', WPRSS_TEXT_DOMAIN ) );
		}

		return $post_types;
	}

    /**
     * @since 3.7
     * @return array Methods, which can be used to compare keywords with terms.
     */
    public function getTaxonomyCompareMethods()
    {
        return apply_filters('wprss_ftp_taxonomy_compare_methods', array(
            'all'           => __('All', WPRSS_TEXT_DOMAIN),
            'any'           => __('Any', WPRSS_TEXT_DOMAIN)
        ));
    }

    public function getDefaultTaxonomyCompareMethod()
    {
        return apply_filters('wprss_ftp_default_taxonomy_compare_method', self::DEFAULT_TAXONOMY_COMPARE_METHOD);
    }
}

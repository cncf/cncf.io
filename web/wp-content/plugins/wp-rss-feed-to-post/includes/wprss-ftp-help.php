<?php

if ( ! defined( 'WPRSS_FTP_HELP_PREFIX' ) ) {
    define( 'WPRSS_FTP_HELP_PREFIX', 'field_f2p_' );
}

if ( class_exists('WPRSS_Help') ) {
    $help = WPRSS_Help::get_instance();

    $enclosure = $help->get_tooltip( 'field_wprss_enclosure' );
    $enc_text_arr = explode( "\n", $enclosure[WPRSS_Help::TOOLTIP_DATA_KEY_TEXT] );
    unset( $enc_text_arr[0] );
    $enc_text = 'Check this box to include a link to the enclosure tag in the content of imported posts.' . implode( "\n", $enc_text_arr );
    $help->set_tooltip( 'field_wprss_enclosure', $enc_text );

    $tooltips = array(
    	// General
    	'post_site'					=>	__("Choose the site where the posts from the source will be imported.\n\nThis option can only be changed if you are on the main site of your multisite network.", WPRSS_TEXT_DOMAIN),
    	'post_type'					=>	__("Choose the post type you want to import the imported feeds to.\n\nChanging this option will affect your taxonomy options further down this page.", WPRSS_TEXT_DOMAIN),
    	'post_status'				=>	__("Choose the status for imported posts.", WPRSS_TEXT_DOMAIN),
    	'post_format'				=>	__("Choose the post format to assign to imported feeds.", WPRSS_TEXT_DOMAIN),
    	'post_date'					=>	__("Choose the date to use for imported posts.", WPRSS_TEXT_DOMAIN),
        'comment_status'			=>	__("Check this box to enable comments for imported posts from this source.", WPRSS_TEXT_DOMAIN),
		'force_full_content'		=>	__("Check this box to forcefully attempt to retrieve the full feed content, if the feed only provides excerpts. This uses the free full text service by default, which is limited to 5 feed items per source. To pull in the full content for all posts you must use the premium Full Text RSS Feeds add-on alongside Feed to Post.", WPRSS_TEXT_DOMAIN),
        'import_excerpt'			=>	__('Check this box to import the feed item\'s short description as the post\'s excerpt.', WPRSS_TEXT_DOMAIN),
		'allow_embedded_content'	=>	__("Check this box to allow embedded content in posts (<code>iframe</code>, <code>embed</code> and <code>object</code> content).", WPRSS_TEXT_DOMAIN),
		'source_link'				=>	__("Check this box to add a link back to the original post, at the beginning of the post's content.", WPRSS_TEXT_DOMAIN),
        'source_link_singular'      =>  __("Check this box to show the source link only when viewing a post by itself and not when viewing a series of posts.", WPRSS_TEXT_DOMAIN),
		'source_link_text'			=>	__("Enter the text to use when linking back to the original post source.

										Wrap a phrase in asterisk symbols (<strong>*link to post*</strong>) to turn it into the link to the <strong>original post</strong>,
										or in double asterisk symbols (<strong>**link to source**</strong>) to turn it into a link to the post <strong>feed source</strong>", WPRSS_TEXT_DOMAIN),
		'canonical_link'			=>	__('Check this box to add a rel="canonical" link to the head of imported posts.', WPRSS_TEXT_DOMAIN),
		'allow_local_requests'		=>	__('Check this box if having trouble saving feed item images locally. This allows requests to local IPs.', WPRSS_TEXT_DOMAIN),
		'full_text_rss_service'		=>	__('Choose the service to use for converting your RSS feeds into full text RSS feeds.

										Free services are available for use instantly, with no registration required, but are known to occasionally be unreliable and slow.

                                        Paid and premium services provide maximum reliability and performance, and will require you to obtain an <strong>API key</strong>.

                                        Our premium service, usable via the <strong>Full Text RSS Feeds</strong> add-on, uses your <em>activated</em> license key for the add-on as an API key.', WPRSS_TEXT_DOMAIN),

		// Images
		'save_images_locally'		=>	 wpautop(__("Check this box to import the images from the post into your local media library.", WPRSS_TEXT_DOMAIN)
                                        . "\n\n" . __('Unchecking this has no effect on featured images. See "Enable featured images" for more information.' , WPRSS_TEXT_DOMAIN)),
		'save_all_image_sizes'      => wpautop(__("Check this box to import all available sizes of an image.", 'wprss')),
        'image_min_dimensions'		=>	__("Set the minimum size that you would like for imported images (in pixels).\n\nThis option applies to images saved in the media library, as well as the featured image.", WPRSS_TEXT_DOMAIN),
		'use_featured_image'		=>	wpautop(__("Check this box to enable featured images for imported posts.", WPRSS_TEXT_DOMAIN)
                                        . "\n\n" . __('Note: It is mandatory for the featured images to be downloaded to your local website, even if "Import images" is unchecked. An external URL cannot be set as the featured image for a post. This is a WordPress convention which cannot be overridden.', WPRSS_TEXT_DOMAIN)),
		'featured_image'			=>	__("Choose which image in the post to use as a featured image.", WPRSS_TEXT_DOMAIN),
        'fallback_to_feed_image'	=>	__("Check this box to use the feed channel's image, if available, before resorting to the source fallback image", WPRSS_TEXT_DOMAIN),
		'remove_ft_image'			=>	__("Check this box to remove the featured image from imported posts' content.

                                        This is particularly useful if you are retrieving the featured image from the post's content and your theme is showing the image twice. This option will remove the image in the post content, and leave the featured image.", WPRSS_TEXT_DOMAIN),
        'must_have_ft_image'        => __( "Check this box to only import posts that have a featured image imported.\n\nPosts that fail to retrieve a featured image are not imported.", WPRSS_TEXT_DOMAIN),


        // Authors
        'post_author'				=>	__("Choose the author to assign to the post.\n\nYou can choose to use an existing user on your site as the author, or use the original author from the feed item.", WPRSS_TEXT_DOMAIN),
		'fallback_author'			=>	__("This user is used if the plugin fails to determine an author or user.", WPRSS_TEXT_DOMAIN),

        // Appended/Prepended Text
        'singular_prepend'          =>  __("Check this box to show the prepended text only when viewing a post by itself and not when viewing a series of posts.", WPRSS_TEXT_DOMAIN),
        'singular_append'           =>  __("Check this box to show the appended text only when viewing a post by itself and not when viewing a series of posts.", WPRSS_TEXT_DOMAIN),

		// Taxonomies
        'taxonomies'                => __( 'Click the <strong>Add New</strong> button to add a taxonomy section. In each section:

                                        <ol>
                                            <li>Choose the <strong>Taxonomy</strong> to use - such as <em>Category</em> or <em>Tags</em></li>
                                            <li>Then choose the <strong>terms</strong> to assign to imported posts</li>
                                            <li>If you want to import the terms from feed items, tick the <q>auto create</q> checkbox.</li>
                                            <li>Optionally, set the filtering options to apply to the selected terms.</li>
                                        </ol>', WPRSS_TEXT_DOMAIN),

        // Extraction Rules
        'extraction_rules'          => __( 'For each extraction rule, you\'ll need to enter the:

                                        <ul id="wprss-ftp-extraction-rules-desc">
                                            <li>
                                                <strong>CSS Selector:</strong>
                                                Enter the CSS selector(s) for the HTML element(s) you want to manipulate
                                            </li>
                                            <li>
                                                <strong>Manipulation:</strong>
                                                Choose what you want to do with the matching element(s)
                                            </li>
                                        </ul>

                                        Each extraction rule is a CSS Selector, coupled with a removal type.
                                        The plugin will scan the post content when it is imported, and for each extraction rule,
                                        any matching elements are removed according to the removal type chosen.', WPRSS_TEXT_DOMAIN),

        // Custom Fields
        'custom_fields'             => __( 'For each mapping, you will need to enter the:

                                        <ul id="wprss-ftp-custom-fields-desc">
                                            <li>
                                                <strong>Namespace:</strong>
                                                Choose the namespace of the tag that you wish to read.
                                            </li>

                                            <li>
                                                <strong>RSS Tag:</strong>
                                                Enter the name of the tag in the RSS feed, excluding the namespace prefix.<br/>
                                                <em>For instance,</em> for iTunes artist tag, use just <code>artist</code>, <strong>not</strong> <code>im:artist</code>.
                                            </li>

                                            <li>
                                                <strong>Meta field name:</strong>
                                                Enter the name of the post meta field, where you wish to store the data.
                                            </li>
                                        </ul>', WPRSS_TEXT_DOMAIN),
        'namespace_detector'        => __( 'Use this button to detect the namespaces being used by this feed source.', WPRSS_TEXT_DOMAIN),
        'user_namespaces'			=>	__("These namespaces are used for mapping RSS data into imported posts' meta data, in the <strong>Custom Fields</strong> section when creating/editing feed sources.", WPRSS_TEXT_DOMAIN),

        // Legacy Feed Items
        'legacy_enabled'			=>	__("Tick this box to re-enable the <strong>Feed Items</strong> and turn off post conversion for some feed sources.", WPRSS_TEXT_DOMAIN),

		// URL Shortening
		'url_shortening_method'		=>	__("The service or algorithm to use for shortening", WPRSS_TEXT_DOMAIN),
		'google_api_key'			=>	__("This key will be used for requests to the Google URL Shortener API", WPRSS_TEXT_DOMAIN),

        // Word Trimming
        'word_limit_enabled'        =>  'Choose whether or not to enable word trimming or not. Choosing "Use General Settings" will use the setting chosen in the Feed to Post settings page.',
        'word_limit'                =>  'Choose the number of words to keep when trimming. Entering zero, less than zero or leaving it blank will use the word limit set in the Feed to Post settings page.',
        'word_limit_general'        =>  'Choose the number of words to keep when trimming. Entering zero, less than zero or leaving it blank will disable word trimming.',
        'trimming_type'             =>  'Choose the type of trimming you want to perform on the imported posts.

                                        <strong>Use General Setting</strong>

                                        This will use the same trimming type set in the Feed to Post settings page.

                                        <strong>Trim the content</strong>

                                        Standard trimming. The contents of the post will be shortened so that the number of words matches the number set in the Word Limit option.

                                        <strong>Generate an excerpt</strong>

                                        This option will not shorten the actual contents of the posts. Instead, it will create a copy of the contents, trim it and put it as the posts\' excerpts.
                                        Use this option if your theme supports excerpts and you wish to show excerpts on your site when listing multiple posts, but show the full content of the post on the post\'s page.',
        'trimming_type_general'     =>  'Choose the type of trimming you want to perform on the imported posts.

                                        <strong>Trim the content</strong>

                                        Standard trimming. The contents of the post will be shortened so that the number of words matches the number set in the Word Limit option.

                                        <strong>Generate an excerpt</strong>

                                        This option will not shorten the actual contents of the posts. Instead, it will create a copy of the contents, trim it and put it as the posts\' excerpts.
                                        Use this option if your theme supports excerpts and you wish to show excerpts on your site when listing multiple posts, but show the full content of the post on the post\'s page.',

		'trimming_ellipsis'			=>  __('Tick this box to add an ellipsis (triple dots) at the end of the trimmed text', 'wprss'),
    );

    $help->add_tooltips( $tooltips, WPRSS_FTP_HELP_PREFIX );
}

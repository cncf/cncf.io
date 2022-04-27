=== Search & Filter Pro ===
Contributors: DesignsAndCode, CodeAmp
Donate link:
Tags: posts, custom posts, products, category, filter, taxonomy, post meta, custom fields, search, wordpress, post type, post date, author
Requires at least: 5.1
Tested up to: 5.9
Stable tag: 2.5.12

Search and Filtering for posts, products and custom posts. Allow your users to Search & Filter by taxonomies, custom fields and more.

== Description ==

Search & Filter Pro is a advanced search and filtering plugin for WordPress.  It allows you to Search & Filter your posts / custom posts / products by any number of parameters allowing your users to easily find what they are looking for on your site, whether it be a blog post, a product in an online shop and much more.

Users can filter by Categories, Tags, Taxonomies, Custom Fields, Post Meta, Post Dates, Post Types and Authors, or any combination of these easily.

Great for searching in your online shop, tested with: WooCommerce and WP eCommerce, Easy Digital Downloads


= Field types include: =

* dropdown selects
* checkboxes
* radio buttons
* multi selects
* range slider
* number range
* date picker
* single or multiselect comboboxes with autocomplete


== Installation ==


= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `search-filter-pro.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard


= Using FTP =

1. Download `search-filter-pro.zip`
2. Extract the `search-filter-pro` directory to your computer
3. Upload the `search-filter-pro` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Frequently Asked Questions ==


== Screenshots ==


== Changelog ==

= 2.5.12 =
* Fix - Support ajax in multiple results areas when using our third party integrations
* Fix - an issue with the author field not hiding admin authors (when that option was enabled)
* Fix - pagination issues with some of our integrations when using multiple search forms + results
* Fix - an issue where the query was not integrating with the Custom Layouts block
* Fix - issues in the admin UI since WordPress 5.9
* Fix - update to using wp_initialize_site for multisite - thanks to Chrissyd
* Update - minimum required WordPress version to 5.1

= 2.5.11 =
* Fix - an issue with ajax and the results URL not being correctly detected
* Fix - updated some of our plugin update procedures
* New - options to use text input control for selecting post meta keys (to prevent loading of all meta keys in large databases) - available via the settings page
* New - action - `search_filter_remove_pagination` - use this before your template pagination functions to stop S&F from modifying the pagination

= 2.5.10 =
* Fix - Fix an ajax issue for Dynamic Content maps - * Note: if you are using the maps + posts display method, you might need to reset this option.
* Fix - Translate the labels for options in the `sort` field via WPMLs Advanced Translation editor

= 2.5.9 =
* Fix - Update fix for Dynamic Content maps integration
* Fix - An issue with with WPML Advanced Translation Editor (the text for our submit and reset buttons was not being detected)

= 2.5.8 =
* Fix - an issue with Ajax and Dynamic Content's Google maps widget
* Fix - a PHP notice in our admin notices
* New - experimental hook for displaying WooCommerce variations individually

= 2.5.7 =
* Fix - scroll (on pagination only) was not working correctly
* Fix - duplicate search form stopped working in a previous update
* Fix - an issue with the cache not progressing on nginx + php8
* Fix - a PHP8 admin issue where checkboxes were not being set
* New - initial support for Dynamic.ooo Posts + Maps combined
* New - basic support for multiple ajax areas via hooks
* New - support for WPMLs advanced translation editor

= 2.5.6 =
* Fix - a PHP 5.x error due to a trailing comma

= 2.5.5 =
* Fix - an issue where the cache wouldn't restart because of an incorrect permissions check
* Fix - a PHP error that would be thrown under certain conditions
* Fix - an issue with WPML + ACF, and syncing data for relationship fields
* Fix - PHP 8 Compatibility
* Fix - Issues with multiple Dynamic Content Posts widgets + Search Forms on the same page (update required for DC to 1.13.0)
* New - Add support for Dynamic Content Google Maps widget
* Compatibility + tested upto WP 5.7

= 2.5.4 =
* Fix - a WooCommerce issue that was introduced where variations data was not being saved correctly

= 2.5.3 =
* Fix - `hide empty` in taxonomy fields was ignoring certain posts completely based on their post stati
* Fix - issues with the combobox "No Results Message" with post meta fields
* Fix - js warnings on admin pages
* Fix - issues relating to jQuery migrate plugin being removed
* Fix - an issue with refocussing the search box after pressing enter to submit
* Fix - a css issue with the datepicker dropdown
* Remove - js library dependency for admin tooltips
* Update - Select2 library to 4.0.13
* Compatibility + tested upto WP 5.6
* New - Display Results method - integration with Dynamic Posts v2 from Dynamic Content for Elementor

= 2.5.2 =
* Fix - a warning about stripslashes expecting a string
* Fix - an issue where getting labels for ACF fields was failing on private posts
* Fix - an issue with infinite scroll not working when the pagination selector was not set
* Fix - a JS warning where we using attribute to set checked state in certain admin screens
* Fix - an issue where infinite scroll was causing issues on taxonomy archives
* Fix - an issue where scrolling to results was fired before the content had loaded, causing an unwanted offset
* Fix - an issue with EDD Purchase buttons not using ajax to add to cart after a search
* Fix - an issue when WooCommerce is enabled with S&F, and interference being caused to non related search forms
* Fix - some compatibility issues with WPML and WooCommerce product variations
* New - better integration with WC products shortcode, simply add a `search_filter_id` argument to integrate

= 2.5.1 =
* NOTICE - if you are using Search & Filter with Easy Digital Downloads please read the new integration notes first
* Fix - a PolyLang issue when permalinks were disabled and the default language is not in the URL params
* Fix - an issue with range min / max being detected, when using certain post stati
* Fix - an issue with a loop not using `wp_reset_postdata` after
* Fix - change another loop so that it improves compatibility with plugins + themes
* Fix - respect `infinite-scroll-end` when it is found on the first page of results
* Fix - some compatibility issues with php7.4 using the `implode` function
* Fix - our tables were not being created on some server setups - modified dbdelta sql
* Fix - admin - an issue where pagination selector was showing when it shouldn't be
* Fix - an issue with setting wpdb prefix at too early, causing an issue in some multisites
* Fix - an issue with custom post stati not being picked up properly on cache rebuild
* Fix - an issue with Polylang working with our page builder extensions
* New - action - `search_filter_filter_next_query` - runs when the shortcode is run
* Improvement - integration with EDD - simply add `search_filter_id` to you downloads shortcode to get up and running
* Security - fix a potential security issue + add some hardening measures

= 2.5.0 =
* Fix - issues with number range fields not setting the "max" value by default
* Fix - some errors were being thrown when checking if a term exists
* Fix - some php warnings related to an object being countable
* Fix - issues with forming the URL for taxonomy archives in certain circumstances
* Fix - an issue with the current author being detected when enabling this feature on author archives
* Fix - issues with multiple date pickers and auto submit activating properly when selecting a date
* Fix - a warning about an undefined variable
* Fix - an issue with reset form not working properly on taxonomy archives
* Fix - allow `update_post_cache` action in admin
* Fix - an issue with URL encoding in pagination
* Fix - an issue with whitespace being removed from user choices in choice fields
* Fix - a Polylang issue with the wrong language form being loaded, when auto submit is off
* Fix - an issue with URL encoding in sort order fields
* Fix - an issue where our meta queries (in query settings) were not respecting WordPress Time Zone when "current date" was used
* Fix - an issue when using the OR comparison inside a field, and non latin characters
* Fix - an issue with searches not working when pressing the back button on iOS Safari
* Fix - an issue with stock status not being stored on the parent product in a variable product
* Fix - an issue with WooCommerce shop page, where it was not registering as `filtered` when using the search input box
* Fix - issues detecting post meta for WC variations
* Fix - added date and datetime meta type options for ordering by meta values
* Fix - re-fix mobile Safari back button issue
* Fix - an issue where multiple meta keys with the same name (but different cases) were not being correctly detected
* New - added "Relevance" to default order by and sort fields
* Improvement - updates to license page

= 2.4.6 =
* Fix - properly disable `maintain search form state` as this was causing potential security issues
* Fix - a character encoding issue when checking if ajax can be enabled on a particular page
* Fix - an issue with the sf-option-active class not being removed when using the reset button and submit form is disabled
* Fix - some issue with sf-option-active not being set correctly on radio buttons in certain circumstances
* Improvement - add support for pagination without the `page` prefix, ie, the updated Elementor Pro Posts widget uses /%postname%/%pageno%
* Improvement - set `paged` using `set_query_var` for better compatibility with other plugins

= 2.4.5 =
* Fix - an issue with noUiSlider when "Display values as" is set to "text" in range fields
* Fix - an issue with Beaver Builder Themer auto scrolling to results on page load (when using our display method "archive")
* Fix - an issue with Ajax requests and Polylang
* Fix - some issues with filtering WC shop in some themes

= 2.4.4 =
* Fix - an error being thrown when creating new sites in wpmu
* Fix - return the original IDs of taxonomy terms, when no translated term is found (when using translation plugins) - this allows for taxonomies that are not translated to retain their settings
* Fix - an issue where some of our 3rd party integrations were not working in ajax requests (very rare)
* Fix - an issue where the `filter_next_query` shortcode was being ignored in ajax requests
* Fix - an issue with Ajax URLs not always being set correctly when using PolyLang
* Updated - noUiSlider to v11.1.0
* Updated - chosen to v1.8.7
* New - added a `skip` argument for our `filter_next_query` shortcode, to access those tricky queries

= 2.4.3 =
* Fix - refix enable_taxonomy_archives variable warnings
* Fix - an issue with Beaver Builder Themer scrolling to the results on page load (this occured when pagination was set)
* Fix - silenced (@)set_time_limit as this was throwing warnings on some hosts
* Update - update the plugin to point to our new domain for auth and updates, searchandfilter.com :)

= 2.4.2 =
* Fix - removed an unwanted `exit` causing various and seemingly unrelated issues

= 2.4.1 =
* New - added JS events `sf:ajaxformstart` and `sf:ajaxformfinish` to detect when updating the form has started/finished
* Improvement - speed improvements to the cache, when saving posts and when rebuilding the entire cache
* Fix - an issue where filtering on taxonomy archives was not working with WooCommerce
* Fix - WooCommerce variations were not being taking into consideration in the batch size when rebuilding the cache
* Fix - an issue with WC not showing category/taxonomy descriptions or sub categories on archives
* Fix - exclude products from results that are "not in catalog" for WC
* Fix - an issue where the count was incorrect when using the private publish option with WooCommerce products
* Fix - changing a search form settings to include product variations, or not, didn't trigger a rebuild of the cache in some cases
* Fix - some WC issues when converting child IDs to parent IDs
* Fix - an issue with pagination on taxonomy archives
* Fix - an issue with ACF where option labels were not being correctly detected
* Fix - an issue with uninstall not working correctly sometimes
* Fix - an issue with infinite scroll not activating when the `Only use Ajax on the results page` setting is off
* Fix - an issue with Polylang when searching posts that are not managed by Polylang

= 2.4.0 =
* NOTICE - If you are using S&F with Woocommerce Variations and experiencing issues, you may need to rebuild the S&F cache
* New - change the "no results" message for comboboxes
* Fix - WooCommerce deprecated `woocommerce_get_page_id` in 3.0
* Fix - various WooCommerce issues relating to Variations - Woocommerce users' who use variations may need to rebuild S&F cache
* Fix - correctly set the `sf-option-active` class on multi select items (this includes checkboxes)
* Fix - properly escape some strings
* Fix - destroy noUiSlider (if it exists) before init, in case it has been init by another plugin (improved compatibility)
* Fix - some issues with levels / nesting of hierarchical taxonomies
* Fix - some issues with polylang and ajax requests
* Fix - an issue with a number range field not resetting properly
* Fix - an issue with the range slider in firefox, when ajax was disabled and auto submit was on
* Fix - an issue with `enable on taxonomy archives` when taxonomies were shared between multiple post types
* Fix - a PHP error when using multiple date pickers with post meta
* Fix - the infinite scroll loader will now check the parent it is attached to and use the correct html tag for the loader
* Fix - an issue with the icon not loading for available fields
* Fix - an issue with "enable on taxonomy archives" and pagination not working correctly
* Fix - an issue with min / max values being correctly autodetected for range fields
* Fix - some issues with rounding & formatting on numeric and slider range fields
* Fix - range dropdown & radio fields were not respecting the step value when it came to the last / max option
* Fix - some layout issues in the admin
* Fix - issues with the later versions of Relevanssi
* Fix - some issues with refocusing the search box after a search is performed
* Fix - issues with taxonomy rewrites when using `enable on taxonomy archives`
* Fix - an issue with the date range fields being auto submitted when only 1 has been selected
* Fix - an issue with ACF using `get_field_object` - and returning the wrong options depending on language
* Fix - some issues with the cache building in the background
* Fix - some issues with ajax filtering with fragment urls
* Fix - a PHP warning when creating the first search form after install
* Fix - a PHP warning - incorrect usage of `count`, displaying warnings when saving posts that are to be cached
* Update - update chosen to v1.8.2
* Update - update select2 to v4.0.5

= 2.3.4 =
* Fix - issues in some environments where infinite scroll wasn't activating after a performing search, or getting the page var wrong
* Fix - infinite scroll offset was not being applied correctly
* Improvement - changed scope of some CSS classes in admin ui for better compatibility with other plugins
* Fix - some bugs causing issues with 3rd part plugin compatibility
* Fix - a bug where S&F wouldn't cache new items added to media

= 2.3.3 =
* New - added action `search_filter_api_header`, to allow for modification of the headers that are sent with our ajax requests
* New - added offset for activation of infinite scroll in the display results tab
* New - added new shortcode action `filter_next_query` - this will apply filtering to the next `WP_Query` found
* Fix - an issue with infinite scroll activating multiple times, if you have multiple instances of a search form on a page
* Fix - speed issues with WPML when using media library grid view (and S&F is set to search media)
* Fix - incorrect type cast of a settings variable causing settings not to be loaded correctly in some circumstances

= 2.3.2 =
* Fix - PHP warnings & errors when using WooCommerce & Taxonomy Archive display mode
* Fix - Some issues with the correct fields appearing in the "display results" tab

= 2.3.1 =
* New - Plugin data (such as saved search forms & cache) will no longer be deleted when uninstalling - to remove all data use the new option in the settings page
* New - Search & Filter can now be used to filter your taxonomy archives - currently only works with "Post Type Archive" and "WooCommerce" display methods
* Fix - WPML issue was re-introduced in 2.3.0
* Fix - A Polylang issue when using the shortcode display method & ajax
* Fix - `sf-option-active` class was not updating when using ajax, with autocount off (as the form no longer gets refreshed)
* Fix - issue with "include children in parents" for taxonomy fields
* Fix - an issue with `?sf_data` being appended to pagination in ajax requests
* Fix - issue with Visual Composer plugin only working after first interaction (ajax)
* Fix - an issue with infinite scroll triggering on incorrect pages
* Fix - an issue where the `sf_results_url` filter was not being applied to pagination
* Fix - an issue with Archive display method & polylang
* Compatibility - store the results URL in its own custom field for better compatibility with migration tools which search/replace urls. *Notice*, you will need to edit and hit "save" in your search forms before migrating your sites (so the url can be copied in to the correct custom field)

= 2.3.0 =
* New - Added support for visual composer post grids (free addon plugin required) - create results layouts using visual composer!
* New - Infinite scroll for all display methods - how to setup - https://searchandfilter.com/documentation/search-results/infinite-scroll/
* New - Added support for ACF relationship fields
* New - added `none` sort order option for choice meta fields, allowing preservation of the order of options (if set from external plugins)
* New - added option to specify decimal seperator for number range fields
* Update - Select2 JS library to 4.0.3
* Update - Chosen JS library to 1.6.2
* Update - noUiSlider JS library to 8.5.1
* Performance - improvements when generating forms with many options
* Performance - do not reload the S&F form (ajax) if auto count is not enabled - speed improvement
* Performance - store search related data in transients so that search forms are rendered quickly when used outside of Results Pages (enable via settings page)
* Performance - improved cache building speeds
* Fix - combobox issues on touch devices
* Fix - thousands seperator was not displaying for certain input types
* Fix - some issues with Polylang plugin after Polylang updates
* Fix - issues with the post type field not being set
* Fix - IDs for input fields are now generated randomly based on current timestamp - using the same search form multiple times on a page caused errors with labels & IDs (clicking a label in one form would update the other instance)
* Fix - an issue when using `update_post_cache` filter on already deleted posts
* Fix - PHP notices when using Woocommerce with a static homepage
* Fix - variatons not working correctly in woocommerce, S&F was returning matches for attribute combinations (of variations) which did not exist, but did exist within a particular product
* Fix - potential infinite loop when results contain results shortcodes :/
* Fix - "Only use Ajax on the results page" was not working correctly on post type archives when the taxonomy archives were based of the post type archive URL
* Fix - S&F pagination was taking over taxonomy archive pagination when the display method was set to `post type archive` and the taxonomy archives path had the post type as base rewrite
* Fix - `hide empty` and `show count` options no longer have any effect when auto count is disabled.
* Fix - default sorting by numeric meta keys was not working when they were decimals / floating point numbers.. all numeric sorting is now converted to decimal sorting to 4 decimal places which also works for standard numeric sorting
* Fix - an issue where numerical ranges using the "overlap" comparison were not returning  the correct results
* Fix - an issue where numerical ranges were not auto detecing the max value correctly, when using different start/end meta keys
* Fix - issues with WPML & PolyLang
* Fix - some issues with Ajax when using ajax in certain display modes
* Fix - issues when search forms are within the results area, and replaced with an ajax request
* Removed - help tab on admin screens as it was unused

= 2.2.0 =
* New - field - posts per page
* New - added system status screen
* New - Added Select2 JS as an alternative to Chosen for comboboxes - seems to have better mobile support - change this in main S&F settings screen
* New - added support for custom post stati (statuses)
* New - use slugs instead of IDs in shortcodes (check the shortcodes metabox)
* Improved - allow post meta keys and values to contain spaces & special characters
* Improved - updated Chosen JS to - v1.5.2
* Improved - reset button - choose if the reset button submits the form after resetting it
* Improved - new admin notices for settings that can potentially cause errors
* Improved - admin UI tweaks
* Improved - added `stop()` to scrolling animations before starting to scroll the page
* Fix - issues with PHP 7
* Fix - properly escape some input fields
* Fix - S&F incorrectly warning network activated plugins are not enabled
* Fix - refocus input fields after the form has been auto submitted
* Fix - an error with the range slider and decimals
* Fix - JS event "sf:ajaxfinish" now fired after all S&F process have completed (such as updating the search form)
* Fix - various pagination issues
* Fix - an issue with pagination and the new `custom` display method
* Fix - renamed a global function to prevent conflicts
* Fix - Display problems when using WooCommerce shop on the homepage with S&F
* Fix - Issues with the woocommerce orderby dropdown
* Fix - an issue with the action `search_filter_query_posts` not working correctly
* Fix - a bug sometimes causing tag and category fields to be detected as undefined causing search issues
* Fix - issues with detecting when attachments were updated and rebuilding the cache
* Fix - pressing enter in the search box reset the timer for autosubmit
* Fix - added EDD prep_query shortcode to shortcodes box
* Fix - fix some compatibility issues with WPML where WPML was converting taxonomy term IDs into the current language rather than post language
* Fix - use global function `get_queried_object` rather than `$wp_query->queried_object` for consistency
* Fix - issues with the author field and detecting defaults
* Notice - WP 4.6 tested & compatible + PHP 7

= 2.1.2 =
* New - Sort order can be displayed as radio buttons
* New - filters for all URLs used in S&F - this allows for dynamically changing the various URLs for example to force https or similar - https://searchandfilter.com/documentation/action-filter-reference/
* Fix - an issue with `include_children` and allowing the AND operator to be used
* Fix - an issue with hierarchical lists not being display correctly

= 2.1.1 =
* New - added `data-sf-count` attributes to inputs which have count variables
* Improvement - default cache speed is set to slow
* Fix - an issue with pagination filters
* Fix - issues with PolyLang - should now be working again with PolyLang v1.7.12
* Fix - minify issues with CSS & JS files
* Fix - issues with depth in hierarchical fields
* Fix - an issue where S&F was hijacking pagination when it wasn't supposed to
* Fix - a couple of minor issues with the author field
* Fix - S&F `sf:init` was incorrectly firing after each ajax request, it is now fired only on page load & once initialised
* Fix - An issue where post date fields were not being set correctly in the front end
* Fix - a PHP/pass by reference overload issue
* Fix - an issue with `number_format` & PHP warnings in admin
* Fix - an issue with undefined taxonomy slugs in the S&F cache
* Fix - an issue with `wp_json_encode`

= 2.1.0 =
* Notice - depth classes for hierarchical fields fields have renamed to avoid conflicts - from `.level-0` to `.sf-level-0`
* Notice - properly prefix range & min / max classes = from `.range-min`, `.range-max` and `.meta-range`  to `.sf-range-min`, `.sf-range-max` and `.sf-meta-range`
* New - sync meta fields - when using "number" or "choice" type meta fields, the values can now be auto detected - values can also be sorted
* New - sync ACF fields - use above in choice fields with auto detection - S&F can now retreive built in ACF labels for values too
* New - added support for ordering by multiple fields (the default posts order)
* New - added support for ordering posts by Post Type
* New - lots of improvements to post meta fields (number) more UI options and input types
* New - added support for decimals and number formatting in post meta (number) fields
* New - new compare options for date range and number fields - great for date ranges and bookings/promotional systems
* New - added sort by relevance option for Relevanssi under the Advanced tab
* New - added options to control the display of sticky posts (under the Posts tab)
* New - Settings page
* New - Settings - control caching speed & background processes
* New - Settings - added settings to lazyload JS and an option to load jQuery language files for the datepicker
* New - accessibility - WCAG 2.0 compliant - some html restructuring (mostly adding in labels) and added screen reader text option to all text/number input fields and selects
* New - filter - allows users to filter any field in the search form and most of the options
* New - added counts to the active query class
* Improvement - authors now use slugs instead of IDs in the URL
* Improvement - updated Chosen & noUiSlider to their latest versions
* Improvement - show internal taxonomy names as well as labels throughout admin UI
* Improvement - support for WooCommerce shop when it is set to category display
* Improvement - speed updates/optimisations to the cache and auto count
* Improvement - better admin notices & warnings
* Fix - issues with WPML and loading the correct taxonomies etc
* Fix - issues with caching and the attachment post type
* Fix - an issue where getting counts for taxonomies was occuring twice
* Fix - URL Encoding issue with meta fields
* Fix - an issue when using multiple search forms on a single page & pagination not working correctly
* Fix - removed an error message which was showing whenever the cache was restarting - it was unnecessary
* Fix - whitespace being trimmed from textareas in certain field types
* Fix - some pagination issues when using post type archive
* Fix - do not enable auto count by default
* Fix - Post Type archive display method now properly uses the Posts Page (as defined under `settings` -> `reading`) where applicable when the post type is set to `post`
* Fix - a bug where html entities were matched when searching in chosen comboboxes such as `nbsp`
* Fix - an admin bug where selecting Post Type Archive as the results method would show the wrong options after saving
* Fix - a few admin UI bugs
* Fix - a bug with the ajax start/end events
* WP 4.4 compat - tested with 2016 theme

= 2.0.3 =
* New - update search form (auto count) without submitting the form
* New - added variable `search_filter_id` to all queries to easily identify which S&F form your queries are being modified by - use `$query['search_filter_id'];`
* New - added RTL support for all JS plugins - chosen comboxbox, jQuery datepicker and noUiSlider
* New - added action to trigger the rebuild of the cache for a specific post (`do_action('search_filter_update_post_cache', 1984);` where 1984 is the post ID)
* Fix - issue with Firefox "rembering" disabled state on soft refresh - now a soft page refresh in FF also forces all inputs to be enabled to overcome this issue
* Fix - issue with comboboxes finding child terms (hierarchical enabled)
* Fix - issue with URI encoding in search field
* Fix - issues with multiple results shortcodes when meta data defaults are set
* Fix - issues with WP Types plugin and nested post meta values
* Fix - caching issues with post meta when there are multiple values
* Fix - issue with search term & stripslashes
* Fix - compatibility issue with Relevanssi
* Fix - correctly show count numbers when "detect defaults from current page" is selected
* Fix - re-implement `save_post` filter outside of `is_admin` for rebuilding the cache from the front end

= 2.0.2 =
* New - use S&F with even more templates (Archive Mode) by adding a shortcode/action before your loop
* Fix - set priority of Ajax (with results shortcode) search to `200` on `init` hook - it was being fired sometimes before taxonomies had been declared
* Fix - `array_merge` errors when using hierarchical taxonomies and including children in parents
* Fix - JS errors with multiple search forms on the same page at the same time
* Fix - JS error error in Firefox where refreshing the page sometimes caused a disabled state on the search form
* Fix - an issue in Avada + woocommerce, when setting up the query, and only using 1 post type S&F now passes a string instead of an array
* Fix - a PHP error and delimiters in the Active Query class
* Fix - an issue with maintain search form state passing `page_id` when permalinks are disabled
* Fix - undefined variable notice in author walker
* Fix - undefined variable notice in edit search form screen

= 2.0.1 =
* NOTICE - DO NOT UPDATE UNTIL YOU HAVE READ THE RELEASE NOTES: https://searchandfilter.com/documentation/2-0-upgrade-notes/
* Version bump so all beta testers get the latest update via the dashboard

= 2.0 =
* New - caching of results for fast speeds even on large databases
* New - direct support for the WooCommerce shop page
* New - direct support for WooCommerce product variations
* New - integration with Easy Digital Downloads (EDD) shortcodes - just add the S&F prep_query shortcode directly before the EDD shortcode ie - `[searchandfilter id="14" action="prep_query"]`
* New - use post type archives to display your results (single post type only)
* New - huge speed and accuracy improvements for meta queries - no more `%like%` queries for serialised meta
* New - auto count - dynamically display counts next to field options based on the current search & settings
* New - auto count - drill down fields - hide options which yield no results
* New - allow for multiple meta keys to be queried when doing ranges
* New - prepolutate search form based on current archive - works for post types, tags, categories, taxonomies and authors
* New - datepicker - supports jQuery UI i18n, dropdown for years & months option, placeholder text customisation
* New - methods for accessing what has been searched
* Improvement - moved all Ajax logic to front end for better compatibility with other plugins (esp shortcode based)
* Improvement - huge amount of refactoring - some parts completely rewritten and optimized, JS rewrite
* Improvement - show which meta keys are selected in widget title
* Improvement - change labels on checkbox and radio fields - don't wrap the inputs inside the labels
* Fix - some problems with pagination links sometimes pointing to the ajax URL
* Fix - Fix an issue with `include_children` now working
* New - relationships can now be defined across taxonomy and meta fields
* Fix - Issues with pagination
* fix - removed references to CSS images that were not being used
* Fix - localised some sloppy CSS rules for compatibility
* Fix - some issues with currencies and decimals when using number ranges
* Fix - an issue with exclude post IDs not working correctly
* Fix - UTF characters in taxonomy term names
* Fix - `orderby` getting added to the URL on non WooCommerce search forms
* Fix - IE8 JS error - Object.keys() compatibility
* Fix - IE10 JS error / reload error - the `input` event was triggering when it was not supposed to causing an ajax request to be performed
* Fix - Admin - function definition in wrong scope causing errors in strict mode on some browsers
* Removed - .postform classes that have crept back into build - but added classes and IDs on every input element
* Removed - the global $sf_form_data - changed to $searchandfilter
* Notice - you should no longer use `pre_get_posts` to modify queries, there is a new filter which takes an array of arguments `sf_edit_query_args` which must be used to also update count number and other non main queries
* In progress - support for PolyLang - testing so far seems good

= 1.4.3.1 =
* Fix - add serialised tick box to post meta fields
* Fix - added a "data is serialised" checkbox to meta fields
* Dropped - built in pagination functions - `sf_pagination_numbers` and `sf_pagination_prev_next` are now redundant

= 1.4.1 =
* New - Added IDs to search forms for easy css targeting - also renamed ID on results container to keep in line with naming conventions
* New - added reset button
* New - dropdown number range
* New - added options to use timestamps in post meta
* fix - a bug when sanitizing keys from post meta
* fix - a bug with autosuggest & encoding
* fix - issues with searching serialised post meta
* fix - throwing an error when trying to access the `all_items` label of a taxonomy when it does not exist
* fix - some dependencies with JS/CSS allowing them to be removed more easily
* fix - some tweaks to automatic updates
* fix - layout issues with search form UI and WP 4.1
* fix - various fixes and improvements with compatibility and WPML

= 1.4.0 =
* New - search media/attachments
* New - added post meta defaults - now you can add constraints for meta data such as searching only products in stock, excluding featured posts or restricting all searches to specific meta data values
* New - scroll to top of page when updating results with ajax
* New - use the shortcode to display results without ajax too (results shortcode only worked with ajax setups previously)
* New - allow regular pagination when using a shortcode for results - (use wp next_posts_link & previous_posts_link, plus added support for wp_pagenavi plugin)
* New - added AND / OR operator to define relationships between tag, category and taxonomy fields
* New - optionally include children in parent searches (categories, hierarchical taxonomies)
* New - improvded UI - add taxonomy browser to help find IDs easily
* New - improved ajax/template UI
* New - minify CSS & JS - finally integrated grunt ;) - non minified versions still available
* New - duplicate search form - a link has been added to the main S&F admin screen underneath each form for easy duplicating!
* New - added support for Relevanssi when using shortcodes to display results
* New - add "today" for date comparisons in meta queries in post meta defaults
* Updated - the default results template (shortcode) to include new pagination options
* Fixed - an error when users are not using permalinks, and submitting the search form
* Fixed - "OR" operator for checkboxes with taxonomies was broken
* Fixed - a JS error when no terms were being shown for a checkbox/radio field
* Fixed - an error when using `maintain state` and getting 404 on results
* Fixed - an error when detecting if a meta field was serialised or not
* Fixed - an error when saving a post meta field with a poorly formatted name
* Fixed - ajax pagination without shortcode
* Fixed - meta fields with the value `0` being ignored
* Fixed - some updates to the plugin auto updater - some users weren't seeing udpates in the dashboard even when activated

= 1.3.0 =
* New - JavaScript rewrite - refactored - faster cleaner code
* New - add setting to allow the default sort order of results - check settings panel -> posts
* New - Speed improvements - searching usually caused 2 header requests (a POST and a redirect) - now uses only a single GET request
* New - play nice with other scripts - can now initialise the search form via JS if the form/html is loaded in dynamically
* New - mulitple search forms on the same page!
* New - add data to JS events for targeting individual forms on the same page
* New - maintain search state - keep user search settings while looking at results pages
* New - for Ajax w/ Shortcodes - Added results URL - this allows the widget to be placed anywhere in your site
* New - shortcode meta box - for easier access to shortcodes within the Search Form editor
* New - allow auto submit when ajax is not enabled
* New - shareable/bookmarkable URLs when using shortcodes (this was already available without)
* Fixed - an issue with auto submit
* Fixed - an issue with a significant delay to fetch initial results when using ajax (with shortcode) - initial results are now loaded server side on page load
* Fixed - bad html and "hide_empty" was not working as expected - it was disabling inputs rather than hiding them
* Fixed - i18n for "prev" and "next" in pagination
* Fixed - post date field was not working correctly when using ajax w/ shortcodes
* Improved - integration with WPML - better URLs and works fully with shortcodes
* Removed - *Beta* Auto Count - this feature is likely to be even more broken (it had plenty of bugs already) - it is recommended you disable this for now.  The next major update will inlcude a revised & working version of this.

= 1.2.7 =
* Fixed an issue with array_replace_recursive for older PHP version

= 1.2.6 =
* Fixed an issue with headers in admin when publishing a post

= 1.2.5 =
* Fixed a JS error in IE8
* Added new settings panel - set defaults search parameters
* Settings Panel - include/exclude categories
* Settings Panel - exclude posts by ID
* Settings Panel - choose to search by Post Status
* Settings Panel - Added Results Per Page for controlling the number of results you see
* Settings Panel - UI refinements
* Settings Panel - more to come (meta)!
* Category, Tag & Taxonomy fields - new option (advanced) to sync included/excluded posts with new settings parameters

= 1.2.4 =
* DO NOT UPGRADE IF YOU WERE HAVING ISSUES WITH AJAX FUNCTIONALITY AND WAITING FOR A PATCH, ONLY THE TWO UPDATES BELOW ARE INCLUDED IN THIS UPDATE:
* Fix - ajax shortcode functionality - search field is now working again!
* Fix - ajax shortcode functionality - fixed custom field/meta search
* Fix - ajax shortcode functionality - fixed a bug with categories

= 1.2.3 =
* DO NOT UPGRADE IF YOU WERE HAVING ISSUES WITH AJAX FUNCTIONALITY AND WAITING FOR A PATCH, ONLY THE TWO UPDATES BELOW ARE INCLUDED IN THIS UPDATE:
* Fix - ajax shortcode functionality - only displays published posts (it was also fetching drafts)
* Fix - ajax shortcode functionality - auto submit now working

= 1.2.2 =
* Fix - stopped using short syntax array in php (`[]`) which is only supported in php version 5.4+

= 1.2.1 =
* Fix - a JS error for older Ajax setups

= 1.2.0 =
* NEW - completely reworked how to use Ajax - simply use a shortcode to place where you want the results to display and you're set to go!
* Fix - allow paths in template names - S&F was previously stripping out slashes so couldn't access templates in sub directories
* Fix - various small bug fixes

= 1.1.8 =
* New - add new way to modify the main search query for individual forms
* New - added a new JS init event

= 1.1.7 =
* New - *beta* - Auto count for taxonomies - when using tag, category and taxonomies only in a search form, you can now enable a live update of fields, which means as users make filter selections, unavailable combinations will be hidden (this is beta and would love feedback especially from users with high numbers of posts/taxonomies)
* New - date picker for custom fields / post meta - dates must be stored as YYYYMMDD or as timestamps in order to use this field
* New - added JS events to capture start / end of ajax loading so you can add in your own custom loaders
* Fix - prefixed taxonomy and meta field names properly - there were collisions on the set defaults function, for example if a tax and meta share the same key there would be a collision
* Fix - errors with number ranges & range slider
* Fix - an error with detecting if a meta value is serialized
* Fix - scope issue with date fields auto submitting correctly


= 1.1.6 =
* **Notice** - dropped - `.postform` css class  this was redundant and left in by error - any users using this should update their CSS to use the new and improved options provided:
* New - class names added to all field list items for easy CSS styling + added classes to all options for form inputs for easy targeting of specific field values
* New - added a `<span class="sf-count">` wrapper to all fields where a count was being shown for easy styling
* Fix - removed all reference to `__DIR__` for PHP versions < 5.3
* Fix - Some general tweaks for WPML
* Fix - a bug when choosing all post types still adding "post_types" to the url

= 1.1.5 =
* **Notice** - this update breaks previous Sort Order fields, so make sure if you have a Sort Order Field to rebuild it once you've updated!
* New - Sort Order - in addition to sorting by Meta Value, users can now sort their results by ID, author, title, name, date, date modified, parent ID, random, comment count and menu order, users can also choose whether they they want only ASC or DESC directions - both are optional.
* New - Autocomplete Comboboxes - user friendly select boxes powered by Chosen - text input with auto-complete for selects and multiple selects - just tick the box when choosing a select or multiselect input type
* Fix - add a lower priority to `init` hook when parsing taxonomies - this helps ensure S&F runs after your custom taxonomies have been created
* Fix - add a lower priority to `pre_get_posts` - helps with modifying the main query after other plugins/custom code have run
* Fix - a problem with meta values having spaces

= 1.1.4 =
* New - Meta Suggestions - auto detect values for your custom fields / post meta
* Enhancement - improved Post Meta UI (admin)
* Fix - an error with displaying templates (there was a PHP error being thrown in some environments)
* Fix - an error where ajax enabled search forms were causing a refresh loop on some mobile browsers

= 1.1.3 =
* New - display meta data as dropdowns, checkboxes, radio buttons and multi selects
* New - added date formats to date field
* fix - auto submit & date picker issues
* fix - widget titles not displaying
* fix - missed a history.pushstate check for AJAX enabled search forms
* fix - dashboard menu conflict with other plugins
* fix - submit label was not updating
* fix - post count for authors was showing only for posts - now works with all post types
* compat - add fallback for `array_replace` for <= PHP 5.3 users

= 1.1.2 =
* New - customsise results URL - add a slug for your search results to display on (eg yousite.com/product-search)
* fix - js error when Ajax pagination links are undefined
* fix - date picker dom structure updated to match that of all other fields
* fix - scope issue when using auto submit on Ajax search forms

= 1.1.1 =
* fix - fixed an error where JS would hide the submit button :/
* fix - fixed an error where parent categories/taxonomies weren't showing their results

= 1.1.0 =
* New - AJAX - searches can be performed using Ajax
* fix - removed redundant js/css calls

= 1.0.0 =
* Initial release


== Upgrade Notice ==

= 2.5.7 =
PHP 8 users - if you are seeing errors on upgrading, please disable Search & Filter before proceeding with the update and it will complete successfully.  This is related to the duplicate Search Form bug (now fixed in this version).

=== Custom Twitter Feeds Pro ===
Author: Smash Balloon
Contributors: smashballoon, craig-at-smash-balloon
Support Website: http://smashballoon/custom-twitter-feeds/
Tested up to: 6.0
Requires PHP: 5.6
Stable tag: 2.0.1
License: Non-distributable, Not for resale

Custom Twitter Feeds Pro allows you to display completely customizable Twitter feeds of your user timeline, home timeline, hashtag, and more on your website.

== Description ==
Display **completely customizable**, **responsive** and **search engine crawlable** versions of your Twitter feed on your website. Completely match the look and feel of the site with tons of customization options!

* **Completely Customizable** - by default inherits your theme's styles
* Feed content is **crawlable by search engines** adding SEO value to your site
* **Completely responsive and mobile optimized** - works on any screen size
* Display tweets from any user, your own account and those you follow, or from a specific hashtag
* Display multiple feeds from different Twitter users on multiple pages or widgets
* Post caching means that your feed loads lightning fast and minimizes Twitter API requests
* **Infinitely load more** of your Tweets with the 'Load More' button
* Built-in easy to use "Custom Twitter Feeds" Widget
* Fully internationalized and translatable into any language
* Display a beautiful header at the top of your feed
* Enter your own custom CSS for even deeper customization

For simple step-by-step directions on how to set up the Custom Twitter Feeds plugin please refer to our [setup guide](http://smashballoon.com/custom-twitter-feeds/docs/setup 'Custom Twitter Feeds setup guide').

= Feedback or Support =
We're dedicated to providing the most customizable, robust and well supported Twitter feed plugin in the world, so if you have an issue or any feedback on how to improve the plugin then please [let us know](https://smashballoon.com/custom-twitter-feeds/support/ 'Twitter Feed Support').

If you like the plugin then please consider leaving a [review](https://wordpress.org/support/view/plugin-reviews/custom-twitter-feeds), as it really helps to support the plugin. If you have an issue then please allow us to help you fix it before leaving a review. Just [let us know](https://smashballoon.com/custom-twitter-feeds/support/ 'Twitter Feed Support') what the problem is and we'll get back to you right away.

== Installation ==
1. Install the Custom Twitter Feeds Pro plugin by uploading the files to your web server (in the /wp-content/plugins/ directory).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the 'Twitter Feed' settings page to configure your feed.
4. Use the shortcode [custom-twitter-feeds] in your page, post or widget to display your feed.
5. You can display multiple feeds with different configurations by specifying the necessary parameters directly in the shortcode: [custom-twitter-feeds hashtag=#smashballoon].

For simple step-by-step directions on how to set up Custom Twitter Feeds plugin please refer to our [setup guide](http://smashballoon.com/custom-twitter-feeds/docs/ 'Custom Twitter Feeds setup guide').

== Changelog ==
= 2.0.1 =
* Fix: Added more workarounds for encoding issues in Twitter Cards.
* Fix: Fixed the default date format showing differently in the customizer than it did on the front-end.
* Fix: Fixed translations for date words not applying correctly.
* Fix: Tablet columns were not working correctly for some layouts.

= 2.0 =
* Important: Minimum supported WordPress version has been raised from 3.5 to 4.1.
* New: Our biggest update ever! We've completely redesigned the plugin settings from head to toe to make it easier to create, manage, and customize your Twitter feeds.
* New: All your feeds are now displayed in one place on the "All Feeds" page. This shows a list of any existing (legacy) feeds and any new ones that you create. Note: If you updated from a version prior to v1.13 then you may need to view your feeds on your webpage so that the plugin can locate them and list them here.
* New: Easily edit individual feed settings for new feeds instead of cumbersome shortcode options.
* New: It's now much easier to create feeds. Just click "Add New", select your feed type, connect your account, and you're done!
* New: Brand new feed customizer. We've completely redesigned feed customization from the ground up, reorganizing the settings to make them easier to find.
* New: Live Feed Preview. You can now see changes you make to your feeds in real time, right in the settings page. Easily preview them on desktop, tablet, and mobile sizes.
* New: We've added a new Feed Templates feature. You can now select a feed template when creating a feed to make it much quicker and easier to get started with the type of feed you want to display. Selecting a template preconfigures the feed customization settings to match that template, saving you time and effort.
* New: Color Scheme option. It's now easier than ever to change colors across your feed without needing to adjust individual color settings. Just set a color scheme to effortlessly change colors across your entire feed.
* New: You can now change the number of columns in your feed across desktop, tablet, and mobile.
* New: Easily import and export feed settings to make it simple to move feeds across sites.
* New: Added a Post Style setting which allows you to add a boxed style to your Tweets, with a background color, border radius, and box shadow.
* New: Added a new custom text header option, so you can now add custom text to the header for your feed.
* Fix: Fixed a PHP warning related to information for the header being empty.
* Fix: Tweets with quoted media were causing HTML errors and the feed layout would be affected.

= 1.14.1 =
* Fix: Fixed several issues with GDPR Cookie Consent by Web Toffee integration.
* Fix: Fixed CSS to allow for right to left carousels.
* Fix: Fixed duplicate MySQL queries issue when checking for the resized images table.
* Fix: Changed the location of the cookie.txt file (used by the server to collect twitter card information) and removed it after it was used.
* Fix: Added support for the shortcode setting "feedid" to allow custom names of feed caches to prevent conflicts.
* Fix: Some links to Twitter in feeds were using the author name instead of the Twitter handle and would occasionally cause errors.
* Fix: Fixed the inability to show just one tweet if only one tweet was available for an account/hashtag.
* Fix: Removed an extra character that would appear near the author's name under certain circumstances.

= 1.14 =
* New: The locations of the Twitter feeds on your site will now be logged and listed on a single page for easier management. After this feature has been active for awhile, a "Feed Finder" link will appear next to the Feed Type setting on the plugin Settings page which allows you to see a list of all feeds on your site along with their locations.
* Fix: Updated jQuery methods for compatibility with WordPress 5.7.
* Fix: Home Timeline feeds were not working.
* Fix: "In reply to", "Load More", and "retweeted" text can now be translated using translation files.

= 1.13 =
* New: You can now create custom HTML templates for your Twitter feed to allow you to completely control the HTML output. Just add the relevant template file from the plugin to your theme to override the defaults. View [this article](https://smashballoon.com/doc/twitter-custom-templates/) for more information.
* New: Added a setting to enqueue the JavaScript file in the head instead of the footer. This can help bypass certain JavaScript errors caused by other plugins or themes.
* Tweak: The default API request method is now using the WP_HTTP class.
* Tweak: For tweets with both media and a supported embeddable link (YouTube, Vimeo, Soundcloud), the media will be shown and the embeddable link will remain a link.
* Fix: Improved how HTTP issues are handled including an error log that is included in your system info.
* Fix: Several layout bugs related to tweets that had some parts hidden were fixed.

= 1.12.1 =
* Fix: Some features were not working when using the "Are you using an AJAX theme?" setting.
* Fix: Links to amazon.com in Tweets were not being converted to Twitter Cards.
* Fix: When hovering over the feed header, the Twitter icon would not appear over the avatar in some themes.
* Fix: When using the GDPR features, a missing space in the related HTML attribute would cause invalid HTML.
* Fix: The pro version of GDPR Cookie Consent by WebToffee was not being recognized automatically for GDPR integrations.
* Fix: When using the GDPR setting and the lightbox was disabled, videos and gifs would not start working after giving consent.

= 1.12 =
* New: Integrations with popular GDPR cookie consent solutions added. Visit the Twitter Feed settings page, Customize tab, Advanced section for more information.
* Tweak: Icon font support was discontinued. Only SVGs will be used for icons in feeds.
* Tweak: Twitter Intents JS updated to the latest version.
* Fix: Twitter cards and media or quoted tweets would display in the same tweet.
* Fix: When hiding avatars in tweets, an empty space would display where the avatar usually is for certain feed widths.
* Fix: Fixed JavaScript error that would occur when using Internet Explorer to view the feed and the masonry or carousel layout.
* Fix: Added a check to make sure image files for Twitter Cards were accessible before trying to store a local copy.

= 1.11.1 =
* Tweak: Feed cache is cleared after all Twitter cards are found.
* Tweak: Persistent caches are not autoloaded into PHP memory but instead are loaded only when used.
* Tweak: Workaround added for lazy loading features from some themes causing JavaScript errors.
* Fix: Google Plus removed from share bar in lightbox.
* Fix: An HTTP error when retrieving Twitter data would cause a PHP error and prevent the page from loading.
* Fix: Twitter Cards were not always storing properly when reaching the cache limit.
* Fix: Fixed PHP error caused by image resizing code.
* Fix: Added setting to show/hide carousel pagination dots.
* Fix: Carousel feeds would start on a tweet other than the first tweet when the feed was automatically loading in more tweets.
* Fix: An empty slide would show when a carousel feed had run out of tweets to load.
* Fix: The wrong text domain was being used for several strings in the admin area.

= 1.11 =
* New: As the Twitter API only provides certain image sizes, sometimes larger than desired images might be used in your feed. To avoid this, and help improve performance, the plugin will now create resized versions of the images which are more optimally sized and store them on your server. This feature is automatically enabled for any feed but can be disabled in the following location: Twitter Feeds > Customize > Misc > Image Resizing.
* Tweak: Added support for improved dashboard notices on the plugin settings page.
* Tweak: Spacing of elements made more uniform so that text aligns top to bottom in the tweet.
* Tweak: Box shadow removed for all links to look better for themes that add a box shadow to links (Twenty Seventeen).
* Tweak: HTML attribute rel="noopener noreferrer" added to all outbound links for extra security.
* Tweak: Added support for improved notices on the plugin settings page.
* Fix: Carousel feeds would inconsistently detect the width of carousel items causing parts of the tweet layout to look squished.
* Fix: Twitter lists added in the shortcode were not working under certain circumstances.
* Fix: Fixed JavaScript error "imgLiquid not defined".

= 1.10 =
* New: Updated icons in the feed to match Twitter.
* New: Improved feed load time by optimizing how images are loaded. A placeholder image is loaded and replaced by the most optimum resolution available.
* Tweak: Changed CSS for HTML elements that are part of the individual tweet author, date, and avatar to use left padding instead of left margin to prevent overlap with the Twitter icon.
* Tweak: Changed the code that applies the masonry layout to prevent tweets from overlapping.
* Tweak: Changed the JavaScript code to work more reliably when there are multiple feeds on the page.
* Tweak: Twitter cards are now stored using the tweet ID instead of the link address to prevent errors in retrieving them from the cache.
* Fix: Added a workaround for an issue caused by lazy-loading plugins which sometimes resulted in small images in the feed.

= 1.9 =
* New: Code added to allow Custom Twitter Feeds to work in our new Social Wall plugin
* Tweak: Changed the class name of the HTML element that wraps around the tweets from "ctf-tweets" to "ctf-tweet-items" to prevent the twitter feed from being hidden by ad blockers.
* Fix: Under certain circumstances, a tweet would be missing from the feed when loading more tweets.

= 1.8.1 =
* New: Lightbox images and videos can be changed by swiping right and swiping left when using a touch device.
* New: To help us improve the plugin we have added usage tracking so that we can understand what features and settings are being used, and which features matter to you the most. The plugin will send a report in the background once per week with your plugin settings and basic information about your website environment. No personal or sensitive data is collected (such as email addresses, Twitter account information, license keys, etc). You can opt-out by simply disabling the setting at: Twitter Feeds > Customize > Misc > Enable Usage Tracking. See [here](https://smashballoon.com/custom-twitter-feeds/docs/usage-tracking/) for more information.
* Tweak: More tweets collected when feed is being filtered to allow the plugin to find older tweets that fit the filter.
* Tweak: Hashtag feeds have retweets filtered out by default for improved feed performance.
* Tweak: Lightbox navigation arrows moved outside of the content to allow videos to be paused instead of changing the slide when clicking the pause button.
* Fix: Several strings updated to be translatable
* Fix: Follow button is hidden or linked to the correct Twitter account when the feed runs out of tweets.
* Fix: Follower and tweet counts were incorrectly displaying "0" in the header under certain circumstances.

= 1.8 =
* New: Added a "Twitter Feeds" Gutenberg block to use in the block editor, allowing you to easily add a feed to posts and pages.
* Tweak: Added function ctf_init() to easily rerun JavaScript for the plugin.
* Tweak: Hide admin notices from other plugins when using the Custom Twitter Feeds settings pages.

= 1.7.1 =
* New: Added hooks for applying custom filters to feeds "ctf_filter_out_tweet".
* Tweak: Quoted tweets with videos now open a video in the lightbox instead of linking to the original tweet.
* Tweak: Added aria-label attributes to SVG icons for improved accessibility.
* Fix: Fixed PHP warning that occurred when a URL in the tweet text did not have a full length URL available from the Twitter API.
* Fix: Using the setting to link the tweet text to Twitter would cause nested links and invalid HTML.
* Fix: Fixed Twitter logo not displaying if avatar, author, and date were hidden.

= 1.7 =
* New: Twitter logo added to the top right of each tweet to fit with Twitter's display guidelines. Customize the logo on the "Style" tab, "Author" area or hide it using the settings on the "Customize" tab "Show/Hide" settings.
* New: Minified versions of JavaScript and CSS files now used.
* New: Tweets that are replies to the same account or mention the same account can be included in the feed by enabling the setting "Always include replies to self in the feed".
* New: Added a setting to completely disable Twitter intents widget.js file.
* New: Full urls now displayed in tweet text. You can display the shortened urls by enabling the setting on the "Customize" tab, "Advanced" sub-tab or adding shorturls=true in the shortcode.
* New: Added support for a "layout" setting. Choose the default layout of your feeds on the "Customize" tab or use layout=list, layout=carousel, or layout=masonry in the shortcode.
* New: Added hooks for changing Twitter card data: "ctf_tc_text" and "ctf_tc_data". Also added support for executing JavaScript after a Twitter card is added to the page.
* New: Added hooks for changing media data before being added to the page: "ctf_item_media". This can be used to present certain media types, such as youtube embeds, in a custom way.
* New: Custom JavaScript can now be executed when the lightbox opens and changes slides by assigning a function to ctfLightboxAction.
* Tweak: Combined widgets.js file with native JavaScript file for the plugin.
* Tweak: Twitter widgets.js will only be enqueued when "actions" are included in the feed.
* Tweak: Several improvements in includewords and excludewords filtering.
* Tweak: Twitter cards will default to summary_large_image type if card type is not valid.
* Tweak: Added support for list= as well as lists= in shortcodes to display tweets from a Twitter list.
* Tweak: Tweet text line height style set to 1.4.
* Tweak: Urls being checked for Twitter cards are hidden instead of removed to allow for customization.
* Tweak: Improved compatibility with lazy-loading scripts.
* Fix: Using custom header text for a search or hashtag feed would result in the link to twitter being incorrect.
* Fix: "Verified" icon was not rendering as an svg causing accessibility issues.
* Fix: Added additional check for incorrect encoding of "å" character.
* Fix: Fixed duplicate checks of a url when no Twitter card data was found for it.
* Fix: Fixed invalid CSS.
* Fix: Box-sizing unset for SVGs.

= 1.6.2 =
* Fix: Corrected improper encoding of Twitter Card titles and descriptions with accents and other diacritical marks in some cases.

= 1.6.1 =
* Tweak: Added support for Spotify embeds.
* Tweak: Audio file embeds are now shorter and easier to click the play button in the lightbox.
* Fix: Removed images not used in feed.
* Fix: Updated widgets.js code to prevent conflicts with tweet embeds.
* Fix: Welcome page updated to work with CSS changes in WordPress 5.2.

= 1.6 =
* New: You can now choose to only display a certain amount of text characters in your Tweets, with a clickable link to display the rest. This is set to be 280 characters by default, but can be changed by using the following setting: Customize > Style > Tweet Text > Text Length, or by using the "textlength" shortcode setting.
* Tweak: The HTML element used for icons has been switched from "i" to "span" for better accessibility
* Tweak: License renewal notice only visible to admins
* Tweak: Twitter intents JavaScript not loaded on the page if tweet actions are removed
* Tweak: Includewords and Excludewords filters are now case-insensitive
* Fix: An empty space was being displayed for Twitter cards that were missing images
* Fix: Several other accessibility improvements

= 1.5.8 =
* Tweak: Added a "Test Connection" button to the License page to help troubleshoot license activation issues
* Fix: Cron clear cache feature was not working under certain circumstances
* Fix: Links missing when Twitter Cards were unavailable for a link in the post text

= 1.5.7 =
* Fix: Twitter Cards will still display when source website is missing some information
* Fix: If a Twitter Card can not be produced for a link, the link will still display

= 1.5.6 =
* Tweak: Added a filter for Tweet text length
* Tweak: Updated the plugin updater class to latest version
* Fix: Avatar would appear to the right of Tweets or not at all in some versions of Firefox
* Fix: Twitter Card image URLS that were already escaped were not displaying
* Fix: Minor bug fixes

= 1.5.5 =
* Tweak: Changed the media layout to be similar to that of Twitter. When the media layout setting is set to "auto" then the plugin will display tweets with 2 images side by side, and tweets with 3 or 4 images with a large first image and the other images as smaller thumbnails.
* Tweak: Height of Twitter card images increased for narrow displays
* Fix: PHP warning caused by trying to count a boolean
* Fix: The "includewords" setting was not detecting all tweets that include the target word

= 1.5.4 =
* Fix: Lightbox wasn't showing full caption
* Fix: New lines causing word detection issue when using filtering
* Fix: Fixed issue with linkifying code missing tags in parentheses

= 1.5.3 =
* Fix: Added icon source setting for AJAX themes
* Fix: SVG icons box-sizing set to "unset" to prevent issues with SVG icon sizes
* Fix: Auto load more on scroll was causing problems for other features on sites that are triggered by scrolling
* Fix: Extra check added to prevent infinite loop of displaying welcome screen when installing the plugin
* Fix: Missing alt tag and empty links in lightbox causing accessibility errors

= 1.5.2 =
* Fix: SVG icons not displaying correctly in IE11
* Fix: Styling of retweet icons fixed to match other icons
* Fix: JavaScript file included twice when option "Are you using an AJAX theme" enabled

= 1.5.1 =
* Fix: Fixed carousel navigation arrows not being converted to SVGs

= 1.5 =
* New: Added setting to include only secure (https) images in Twitter Cards
* New: Icons are now generated as SVGs for a sharper look and more semantic markup
* Tweak: JavaScript file for plugin is now enqueued only on pages with the feed displayed
* Tweak: More Twitter Cards are displayed the first time a feed updates
* Tweak: Minor changes in Twitter Card code to capture more images, descriptions, and titles
* Fix: Changed "alt" tags for images for better accessibility

= 1.4.3 =
* New: Added "Welcome" and "Getting Started" pages when first activating or updating the plugin
* New: Added screen reader labels for improved accessibility
* Tweak: Updated Font Awesome files to version 4.7.0

= 1.4.2 =
* Fix: Encoding of umlauts and certain quote styles were fixed for Twitter Cards
* Fix: Escaped additional urls, attributes and html
* Fix: Added a workaround for a minor formatting issue caused by some themes
* Tweak: Added notice if license is expired or will expire soon

= 1.4.1 =
* Fix: Fixed an issue where some embedded YouTube videos were not playable

= 1.4 =
* New: Added a "Loop Type" option to the Carousel settings which allows you to select how the carousel should loop. Choose from "None", "Infinite", or "Rewind". You can also use the `carouselloop` shortcode option.
* Tweak: Updated the carousel code version
* Fix: Several fixes for Twitter Card retrieval. If some of your Twitter Cards are not generating as expected, check the box next to "Use cURL to retrieve Twitter Cards" on the "Customize" tab near the bottom of the page. You may also need to click "Clear Twitter Card Cache" after doing so to generate missing Twitter Cards.
* Fix: Links would sometimes be removed if no Twitter Card data was found.
* Fix: Additional resize triggered to help images being cut off under certain conditions

= 1.3.8 =
* Fix: Fixed missing avatars in Firefox for some accounts
* Fix: Changed account links to https
* Fix: Mentions timeline now uses the same layout as the home and user timelines
* Fix: Fixed links from Facebook disappearing under certain situations in tweets
* Fix: Fixed retweets always being included in persistent caches during the initial tweet retrieval.
* Fix: Twitter card issue.

= 1.3.7 =
* Fix: Fixed an issue where link information sometimes wasn't able to be displayed as a Twitter Card due to the standard "get_meta_tags" function not working on some servers. A backup method was added as a workaround using cURL.
* Fix: Fixed an issue with include/exclude string to array conversion warning

= 1.3.6 =
* New: Images in feeds are now the smallest resolution available relative to the actual size of the image on the page.
* Fix: Certain characters in "search" feeds causing inconsistent results in feed.

= 1.3.5 =
* Fix: Line breaks were not being recognized in tweet text

= 1.3.4 =
* Fix: Persistent cache was not saving all data in some circumstances. Data is now encoded to ensure that it saves.

= 1.3.3 =
* Fix: Occasionally a format other that .mp4 would be used for videos in the feed. Mp4 will now always be used when available.
* Fix: PHP warnings would appear when updating a persistent cache when all of the new tweets were filtered out due to duplication.

= 1.3.2 =
* Fix: Fixed an issue that would occur when no tweets were available after filtering with the includewords setting
* Fix: Fixed an issue where empty tweets would show up in certain situations

= 1.3.1 =
* Fix: Fixed an issue introduced in the previous updated where some images were not being shown in Tweets
* Fix: Fixed a layout issue when a quote Tweet contained multiple images

= 1.3 =
* New: The plugin now uses persistent tweet caching for search and hashtag feeds. By default, when displaying hashtag or search feeds Twitter only returns Tweets from the last 7 days, but the persistent cache now allows you to display these Tweets indefinitely.
* New: You can now display Tweets from a "List". Just select the "Lists" feed type on the plugin's Settings page, or use the `lists` shortcode option, eg: `lists="18480038"`. You can use the helpful List ID finding tool on the plugin's Settings page to help find your list ID.
* New: Retweets can now be filtered out of user and home timelines. Retweets are filtered out by default for search and hashtag feeds.
* New: Added options for media layouts including the max number of visible images and the number of columns used in the tweet. These can be found under the 'Media Layout' section on the 'Customize' page, or you can use the following shortcode options: `imagecols` and `maxmedia`, eg: `imagecols=2 maxmedia=2`.
* Tweak: Removed links at the end of tweets when media or a twitter card link was available
* Fix: Fixed an issue where ajax calls for twitter cards and additional tweets would return the page url

= 1.2.2 =
* Fix: Fixed an issue with the Twitter Access Token and Secrets not automatically being saved when initially obtaining them
* Fix: Fixed an issue related to the checkbox used to show the bio text in the header
* Fix: Fixed an issue with the header background color not being applied in some feeds
* Fix: Fixed and issue with the custom date format setting not working correctly

= 1.2.1 =
* Fix: Fixed an issue with icons not displayed in the carousl navigation arrows
* Fix: Fixed an issue when creating a Search feed using the built-in Custom Twitter Feeds widget box
* Fix: Fixed an issue with the "Load More" button in the carousel when multiple feeds were on the same page
* Fix: Fixed an issue with the checkbox that allows you to toggle links on/off in the Tweet text

= 1.2 =
* New: Added a Carousel feature which allows you to display your Tweets in a carousel/slideshow. Use the settings on the plugin's "Customize" page, or set `carousel=true` in your shortcode.
* New: Added `mentions=true` as a shortcode setting
* Tweak: Display feed header and bio by default when plugin is first installed
* Tweak: Added a header when combining multiple types of feed into one single feed
* Tweak: Separated the "Hashtag" and "Search" fields on the plugin's Settings page
* Fix: Adjusted the spacing in masonry so that boxed tweets have equal padding
* Fix: Fixed a masonry layout issue
* Fix: Fixed an issue with transient names for search feeds which affected caching
* Fix: Fixed an issue with punctuation in the "includewords" setting
* Fix: Fixed an issue with some setting checkboxes
* Fix: Fixed a rare URL encoding issue which occurred on some server configurations
* Fix: Misc bug fixes
* Tested with the upcoming WordPress 4.6 update

= 1.1 =
* New: Now supports YouTube, Vimeo, Vine, and SoundCloud embeds
* New: When quoting/sharing Tweets it now shows images when applicable
* New: Added support for "Amplify" Twitter cards
* New: Added a Mentions setting to allow you to display Tweets which @mention you
* New: Added a 2 column option for the Masonry layout
* Tweak: Prevented duplicate Tweets from being displayed
* Fix: Fixed a bug with Masonry and Autoscroll checkbox
* Fix: Fixed an issue with the "Disable lightbox" setting not working correctly
* Fix: Added a play button overlay to videos
* Fix: Miscellaneous bug fixes

= 1.0.1 =
* Fix: Fixed an issue with some customize settings not saving successfully
* Fix: Minor bug fixes

= 1.0 =
* Launch!

=== Gravity Forms Dynamic Population Pro ===
Contributors: gravityplus, naomicbush
Donate link: https://gravityplus.pro/gravity-forms-dynamic-population
Tags: form, forms, gravity, gravity form, gravity forms, gravityforms, dynamic population
Requires at least: 4.9
Tested up to: 5.1
Stable tag: 2.1.0

Dynamically populate your form fields with custom data

== Description ==

Dynamically populate your form fields with custom data

== Installation ==

This section describes how to install and setup the Gravity Forms Dynamic Population Pro Add-On. Be sure to follow *all* of the instructions in order for the Add-On to work properly. If you're unsure on any step, there are screenshots.

Requires at least WordPress 4.9, PHP 5.7, and Gravity Forms 2.3. Works with WordPress Multisite.

1. Make sure you have your own copy of Gravity Forms. This plugin does not include Gravity Forms. It will work with any of the Gravity Forms licenses.

2. Make sure Gravity Forms is installed and activated

3. Upload the plugin to your WordPress site. There are two ways to do this:

    * WordPress dashboard upload

        - Download the plugin zip file by clicking the orange download button on this page
        - In your WordPress dashboard, go to the **Plugins** menu and click the _Add New_ button
        - Click the _Upload_ link
        - Click the _Choose File_ button to upload the zip file you just downloaded

    * FTP upload

        - Download the plugin zip file by clicking the orange download button on this page
        - Unzip the file you just downloaded
        - FTP in to your site
        - Upload the `gravityplus-dynamic-population` folder to the `/wp-content/plugins/` directory

4. Visit the **Plugins** menu in your WordPress dashboard, find `Gravity Forms Dynamic Population Pro` in your plugin list, and click the _Activate_ link

5. Add a new form or edit an existing one, and add a supported field, e.g. dropdown, radio, text

6. Visit Form Settings->Dynamic Population and create a new Dynamic Population Feed

7. Select the source you wish to use to populate and complete the settings for that source. e.g. WordPress database: Select the custom data table and column that contain the choices to be used. The custom data table must be in the WP database to be used here.

8. Choose any options that are available for your source

9. If the filter setting is available for your source and you would like to filter the choices based on the value of another field on the form,
        a. check the box to filter choices
        b. select the form field that contains the value you want to filter on, and the corresponding column in your custom data table


### Additional Notes:

* If you are filtering choices based on the value of another field, you'll need to have at least one field that filters another but is not filtered by any field, to prevent an infinite loop. If every field relies on another, then you have a chicken/egg problem :-)
* It is recommended to add a class of disabled to all fields that depend on another one being populated first
* If you need to add your data to the WP database, see your host for instructions. I have also used the Custom Database Tables plugin in the past, but not recently.

== Frequently Asked Questions ==

= Do I need to have my own copy of Gravity Forms for this plugin to work? =
Yes, you need to install the [Gravity Forms plugin](https://gravityplus.pro/getgravityforms "visit the Gravity Forms website") for this plugin to work.

= Does this version work with the latest version of Gravity Forms? =
Yes.

== Screenshots ==


== Changelog ==

= 2.1.0 =
* FIX Fields don't populate when required field is empty on AJAX form submission
* IMPROVE feed filter choices
* IMPROVE date source settings choices
* ADD populate single fields, like text and hidden
* ADD give custom values for filters
* ADD order feeds

= 2.0.1 =
* Fix issue with checkbox and radio fields not dynamically populating correctly

= 2.0.0 =
* Move to Add-On Framework feeds for dynamic population settings
* Dynamically populate checkbox fields
* Dynamically populate radio fields
* Dynamically populate from WordPress users, filterable by role
* Dynamically populate values from Gravity Forms entries
* Add automatic updates

= 1.6.0 =
* Add support for dynamically-populated dropdowns on Gravity Flow user input step

= 1.5.0 =
* Dynamically populate WordPress taxonomies
* Dynamically populate posts in a taxonomy

= 1.4.0 =
* Dynamically populate from sources other than the WordPress database, including Podio and Salesforce

= 1.3.0 =
* Add support for multi-page forms

= 1.2.1 =
* Fix issue with filters not saving

= 1.2.0 =
* Add additional comparison options for filters: contains, starts with, ends with
* Allow separate label and value selection for choices

= 1.1.0 =
* Fix issue with all dynamically populated fields not saving
* Allow user to reselect choices

= 1.0.0 =
* Initial release.

== Upgrade Notice ==
= 2.0.0 =
* This release is NOT backwards-compatible. Requires Gravity Forms 2.3

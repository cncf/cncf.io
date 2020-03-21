=== miniOrange SAML 2.0 Single Sign On ===
Contributors: miniOrange
Donate link: http://miniorange.com
Tags: saml, single sign on, SSO, single sign on saml, sso saml, sso integration WordPress, sso using SAML, SAML 2.0 Service Provider, Wordpress SAML, SAML Single Sign-On, SSO using SAML, SAML 2.0, SAML 20, Wordpress Single Sign On, ADFS, Okta, Google Apps, Google for Work, Salesforce, Shibboleth, SimpleSAMLphp, OpenAM, Centrify, Ping, RSA, IBM, Oracle, OneLogin, Bitium, WSO2, NetIQ, Novell Access Manager
Requires at least: 3.7
Tested up to: 5.3
Stable tag: 16.0.1
License URI: http://miniorange.com/usecases/miniOrange_User_Agreement.pdf

miniOrange SAML 2.0 Single Sign-On provides SSO to your Wordpress site with any SAML compliant Identity Provider. (ACTIVE SUPPORT for IdP config)

== Description ==

miniOrange SAML 2.0 SSO allows users residing at SAML 2.0 compliant Identity Provider to login to your Wordpress website. We support all known IdPs - Google Apps, ADFS, Okta, Salesforce, Shibboleth, SimpleSAMLphp, OpenAM, Centrify, Ping, RSA, IBM, Oracle, OneLogin, Bitium, WSO2, NetIQ etc. If you need detailed instructions on setting up these IdPs, we can give you step by step instructions.

miniOrange SAML SSO Plugin acts as a SAML 2.0 Service Provider which can be configured to establish the trust between the plugin and various SAML 2.0 supported Identity Providers to securely authenticate the user to the Wordpress site.

If you require any Single Sign On application or need any help with installing this plugin, please feel free to email us at info@xecurify.com or <a href="http://miniorange.com/contact">Contact us</a>.

= Features :- =

*	Login to your Wordpress site using SAML 2.0 compliant Identity Providers.
*   Easily Configure the Identity Provider by providing just the SAML login URL, IDP Entity ID and Certificate.
* 	Supports plethora of SAML 2.0 Identity Providers like Google Apps, ADFS, Okta, Salesforce, Shibboleth, SimpleSAMLphp, OpenAM, Centrify, Ping, RSA, IBM, Oracle, OneLogin, Bitium, WSO2, NetIQ etc.
*	Valid user registrations verified by the plugin.
*	Easily integrate the login link with your Wordpress site using widgets/short code. Just drop it in a desirable place in your site.
*	Automatic user registration after login if the user is not already registered with your site.
*	Use the Attribute Mapping feature to map wordpress user profile attributes to your IdP attributes.
*	Use the Role Mapping feature to assign roles in your IdP to your wordpress users during auto registration.
*	Auto redirect users to your IdP for authentication without showing them your site's login page.
*	Force authentication with your IdP on each login attempt.
*   Supports multisite environment.

= Website - =
Check out our website for other plugins <a href="http://miniorange.com/plugins" >http://miniorange.com/plugins</a> or <a href="https://wordpress.org/plugins/search.php?q=miniorange" >click here</a> to see all our listed WordPress plugins.
For more support or info email us at info@xecurify.com or <a href="http://miniorange.com/contact" >Contact us</a>. You can also submit your query from plugin's configuration page.

== Installation ==

= From your WordPress dashboard =
1. Visit `Plugins > Add New`.
2. Search for `miniOrange SAML 2.0 Single Sign-On`. Find and Install `miniOrange SAML 2.0 Single Sign-On`.
3. Activate the plugin from your Plugins page.

= From WordPress.org =
1. Download miniOrange SAML 2.0 Single Sign-On plugin.
2. Unzip and upload the `miniorange-saml-20-single-sign-on` directory to your `/wp-content/plugins/` directory.
3. Activate miniOrange SAML 2.0 Single Sign-On from your Plugins page.

== Frequently Asked Questions ==

= I am not able to configure the Identity Provider with the provided settings =
Please email us at info@xecurify.com or <a href="http://miniorange.com/contact" >Contact us</a>. You can also submit your app request from plugin's configuration page.

= For any query/problem/request =
Visit Help & FAQ section in the plugin OR email us at info@xecurify.com or <a href="http://miniorange.com/contact">Contact us</a>. You can also submit your query from plugin's configuration page.

== Screenshots ==

1. General settings like auto redirect user to your IdP.
2. Guide to configure your Wordpress site as Service Provider to your IdP.
3. Configure your IdP in your Wordpress site.

== Changelog ==

= 16.0.1 =
Compatible with PHP 7.4
Updated SAML-compliant IdP guides
Bug fixes

= 16.0.0 =
Upgrade Framework
Compatible with PHP 7.2
Compatible with WordPress 5.3

= 15.9.91 =
Added nonces and minor security fixes.
License verification bug fix.
Minor UI fixes.

= 15.9.9 =
UI and usability fixes.
Fixed 500 error code during login.
Added Encryption algorithm aes-128-gcm
Updated xmlseclibs library.
Send plugin configuration with support query.
Custom Widget and shortcode Text.
Export Plugin Configurations.
Added Keep Configuration intact feature.
Custom Backdoor URL.
Removed Single Logout.
Removed Proxy Setup tab.

= 15.1.1 =
new upgrade plans and changes in check license api

= 15.1.0 =
Removed mcrypt dependencies.
Support for Wordpress 4.9.1

= 3.8 =
Descriptive error messages. mcrypt check and auto-redirect bug fixed.

= 3.7 =
Support for Integrated Windows Authentication - contact info@xecurify.com if interested

= 3.5 =
Decrypt assertion bug fix

= 3.4 =
Added some requested features and some bug fixes.

= 3.3 =
Added support for Google Apps as an Identity Provider.

= 3.2 =
Some bug fixes in role mapping.

= 3.1 =
Some bug fixes in auto registration.

= 3.0 =
Added option to use miniOrange Single Sign On Service
Made it simple to setup SAML authentication with your IdP.

= 2.3 =
Fixed forgot password bug for some users.

= 2.2 =
Added guides for configuring common Identity Providers like ADFS, SimpleSAMLphp, Salesforce, Okta and some bug fixes.

= 2.1 =
Removed unwanted JS files.

= 2.0 =
Added new feature like role mapping and auto redirect user to your IdP.

= 1.7.0 =
Resolved UI issues for some users

= 1.6.0 =
Added help and troubleshooting guide.

= 1.5.0 =
Added error messaging.

= 1.4.0 =
Added fixes.

= 1.3.0 =
Added validations and fixes.
UI Improvements.

= 1.2.0 =
* this is the third release.

= 1.1.0 =
* this is the second release.

= 1.0.0 =
* this is the first release.

== Upgrade Notice ==

= 16.0.1 =
Compatible with PHP 7.4
Updated SAML-compliant IdP guides
Bug fixes

= 16.0.0 =
Upgrade Framework
Compatible with PHP 7.2
Compatible with WordPress 5.3

= 15.9.91 =
Added nonces and minor security fixes.
License verification bug fix.
Minor UI fixes.

= 15.9.9 =
UI and usability fixes.
Fixed 500 error code during login.
Added Encryption algorithm aes-128-gcm
Updated xmlseclibs library.
Send plugin configuration with support query.
Custom Widget and shortcode Text.
Export Plugin Configurations.
Added Keep Configuration intact feature.
Custom Backdoor URL.
Removed Single Logout.
Removed Proxy Setup tab.

= 15.1.1 =
new upgrade plans and changes in check license api

= 15.1.0 =
Removed mcrypt dependencies.
Support for Wordpress 4.9.1

= 3.8 =
Descriptive error messages. mcrypt check and auto-redirect bug fixed.

= 3.7 =
Support for Integrated Windows Authentication - contact info@xecurify.com if interested

= 3.5 =
Decrypt assertion bug fix

= 3.4 =
Added some requested features and some bug fixes.

= 3.0 =
Major Update. We have taken ut-most care to make sure that your existing login flow doesn't break. If you have issues after this update then please contact us. We will get back to you very soon.

= 2.1 =
Removed unwanted JS files.

= 2.0 =
Added new feature like role mapping and auto redirect user to your IdP.

= 1.7 =
Resolved UI issues for some users

= 1.6 =
Added help and troubleshooting guide.

= 1.5 =
Added error messaging.

= 1.4 =
Added fixes.

= 1.3 =
Added validations and fixes.
UI Improvements.

= 1.2 =
Some UI improvements.

= 1.1 =
Added Attribute mapping / Role mapping and test application.

= 1.0 =
I will update this plugin when ever it is required.
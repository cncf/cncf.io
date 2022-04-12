<?php
/**
 * WordPress Header
 *
 * Generic Header file used on every page, use Blocks for page content
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-focus-outline">

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
		<link rel="icon"
			href="/wp-content/themes/cncf-twenty-two/images/favicon.ico"
			sizes="any">
		<link rel="icon"
			href="/wp-content/themes/cncf-twenty-two/images/favicon.svg"
			sizes="any"
			type="image/svg+xml">
		<link rel="apple-touch-icon"
			href="/wp-content/themes/cncf-twenty-two/images/apple-touch-icon.png">
		<link rel="manifest"
			href="/wp-content/themes/cncf-twenty-two/images/manifest.webmanifest">
		<meta name="theme-color" content="#000000">
		<meta http-equiv="X-UA-Compatible" content="IE=11">
		<style>
		html {
			visibility: hidden;
		}
		</style>
	</head>

	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>
		<?php // Skip Link should be first focusable element on a page. ?>
		<a class="skip-link" href="#maincontent">Skip to content</a>

		<a class="skip-link" href="/accessibility-statement">Accessibility Help</a>

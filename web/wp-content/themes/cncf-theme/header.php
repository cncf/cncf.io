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
	<meta name=viewport content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>

	<link rel="apple-touch-icon" sizes="180x180"
		href="/wp-content/themes/cncf-theme/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32"
		href="/wp-content/themes/cncf-theme/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16"
		href="/wp-content/themes/cncf-theme/images/favicon-16x16.png">
	<link rel="manifest"
		href="/wp-content/themes/cncf-theme/images/site.webmanifest">
	<link rel="mask-icon"
		href="/wp-content/themes/cncf-theme/images/safari-pinned-tab.svg"
		color="#de176c">
	<link rel="shortcut icon"
		href="/wp-content/themes/cncf-theme/images/favicon.ico">
	<meta name="apple-mobile-web-app-title" content="CNCF">
	<meta name="application-name" content="CNCF">
	<meta name="msapplication-TileColor" content="#de176c">
	<meta name="msapplication-config"
		content="/wp-content/themes/cncf-theme/images/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() . '/dist/assets/images/' . foundationpress_asset_path( 'favicon_16.png' ); //phpcs:ignore ?>" />
		<?php lfe_insert_google_analytics(); ?>
		<?php wp_head(); ?>
		<?php lfe_insert_structured_data(); ?>
	</head>
	<body <?php body_class( $_ENV['PANTHEON_SITE_NAME'] ); ?>>
		<div class="site-container">

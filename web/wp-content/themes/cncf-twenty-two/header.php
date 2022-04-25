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
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-focus-outline">

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
		<link rel="icon"
			href="<?php echo esc_url( get_template_directory_uri() . '/images/favicon.ico' ); ?>"
			sizes="any">
		<link rel="icon"
			href="<?php echo esc_url( get_template_directory_uri() . '/images/favicon.svg' ); ?>"
			sizes="any" type="image/svg+xml">
		<link rel="apple-touch-icon"
			href="<?php echo esc_url( get_template_directory_uri() . '/images/apple-touch-icon.png' ); ?>">
		<link rel="manifest"
			href="<?php echo esc_url( get_template_directory_uri() . '/images/manifest.webmanifest' ); ?>">
		<meta name="theme-color" content="#000000">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<style>
		html {
			visibility: hidden;
		}
		</style>
	</head>

	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>

		<?php
		// Cookie Banner should be first focusable element on a page.
		get_template_part( 'components/cookie-banner' );
		// Followed by Skip Link and Accessibility help link if set.
		?>
		<a class="skip-link" href="#maincontent">Skip to content</a>
		<?php
		$site_options = get_option( 'lf-mu' );
		if ( isset( $site_options['accessibility_cta_link'] ) ) :
			?>
		<a class="skip-link"
			href="<?php echo esc_url( get_permalink( $site_options['accessibility_cta_link'] ) ); ?>">Accessibility
			help</a>
		<?php endif; ?>

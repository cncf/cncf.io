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
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>

	<!-- TODO: Add favicons. -->
</head>

<body <?php body_class(); ?>>

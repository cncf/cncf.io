<?php
$file = get_stylesheet_uri();
$theme_css = new \TwitterFeed\Builder\CTF_Theme_CSS( $file );

if ( ! $theme_css->is_cached() ) {
	$theme_css->load_css();
	$theme_css->parse();
	$theme_css->find_styles();
	$theme_css->cache();
}

echo $theme_css->generate_style_html();
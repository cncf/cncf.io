<?php
/**
 * Gutenberg Block Styles
 *
 * Specify custom block styles
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

register_block_style(
	'core/heading',
	array(
		'name'         => 'uppercase-heading',
		'label'        => 'Uppercase',
		'inline_style' => '.is-style-uppercase-heading { text-transform: uppercase; }',
	)
);

register_block_style(
	'core/paragraph',
	array(
		'name'  => 'blue-paragraph',
		'label' => 'Blue Paragraph',
	)
);

register_block_style(
	'core/quote',
	array(
		'name'         => 'blue-quote',
		'label'        => __( 'Blue Quote' ),
		'inline_style' => '.wp-block-quote.is-style-blue-quote { color: blue; }',
	)
);

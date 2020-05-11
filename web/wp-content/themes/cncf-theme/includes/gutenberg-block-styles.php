<?php
/**
 * Gutenberg Block Styles
 *
 * Specify custom block styles. Order dictates the order in Styles menu.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

 // HEADER.
register_block_style(
	'core/heading',
	array(
		'name'  => 'center-width-700',
		'label' => 'Max-Width 700px & Centered',
	)
);

register_block_style(
	'core/heading',
	array(
		'name'  => 'center-width-800',
		'label' => 'Max-Width 800px & Centered',
	)
);

register_block_style(
	'core/heading',
	array(
		'name'  => 'center-width-900',
		'label' => 'Max-Width 900px & Centered',
	)
);

register_block_style(
	'core/heading',
	array(
		'name'  => 'max-width-800',
		'label' => 'Max-Width 800px',
	)
);

register_block_style(
	'core/heading',
	array(
		'name'  => 'max-width-900',
		'label' => 'Max-Width 900px',
	)
);

// PARAGRAPH.
register_block_style(
	'core/paragraph',
	array(
		'name'  => 'center-width-800',
		'label' => 'Max-Width 800px & Centered',
	)
);

register_block_style(
	'core/paragraph',
	array(
		'name'  => 'center-width-900',
		'label' => 'Max-Width 900px & Centered',
	)
);

register_block_style(
	'core/paragraph',
	array(
		'name'  => 'max-width-800',
		'label' => 'Max-Width 800px',
	)
);

register_block_style(
	'core/paragraph',
	array(
		'name'  => 'max-width-900',
		'label' => 'Max-Width 900px',
	)
);

 // GROUP.
register_block_style(
	'core/group',
	array(
		'name'  => 'pink-purple-gradient',
		'label' => 'Pink to Purple Gradient',
	)
);

 // COLUMNS.
register_block_style(
	'core/columns',
	array(
		'name'  => 'column-white-background',
		'label' => 'Columns with White Background',
	)
);

register_block_style(
	'core/columns',
	array(
		'name'  => 'responsive-two-columns',
		'label' => 'Responsive 2 Columns',
	)
);

register_block_style(
	'core/columns',
	array(
		'name'  => 'responsive-three-columns',
		'label' => 'Responsive 3 Columns',
	)
);

register_block_style(
	'core/column',
	array(
		'name'  => 'column-drop-shadow',
		'label' => 'Drop Shadow',
	)
);

register_block_style(
	'core/columns',
	array(
		'name'  => 'responsive-four-columns',
		'label' => 'Responsive 4 Columns',
	)
);

register_block_style(
	'core/columns',
	array(
		'name'  => 'fiftyfive-fortyfive-two-columns',
		'label' => '55/45 Responsive 2 Columns',
	)
);


 // IMAGES.
register_block_style(
	'core/image',
	array(
		'name'  => 'front-page-hero',
		'label' => 'Front Page Hero Image',
	)
);


 // QUOTE.
register_block_style(
	'core/quote',
	array(
		'name'  => 'full-width-gradient',
		'label' => 'Full Width on Gradient',
	)
);

 // BUTTON.
register_block_style(
	'core/button',
	array(
		'name'  => 'extra-large-outline',
		'label' => 'Extra Large Outline',
	)
);

/**
 * Block Template basic setup
 */
function slug_post_type_template() {
	 $page_type_object           = get_post_type_object( 'page' );
	 $page_type_object->template = array(
		 array(
			 'core/heading',
			 array(
				 'level'     => '1',
				 'content'   => 'Title of page',
				 'className' => 'is-style-max-900',
			 ),
		 ),
		 array( 'core/paragraph' ),
		 array(
			 'core/heading',
			 array(
				 'level'   => '2',
				 'content' => 'Sub header',
			 ),
		 ),
		 array( 'core/paragraph' ),
	 );
};
add_action( 'init', 'slug_post_type_template' );


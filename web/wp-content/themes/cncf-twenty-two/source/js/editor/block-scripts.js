// phpcs:ignoreFile
/**
 * Blocks Scripts-for applying JS to editor
 *
 * Use this for styling editor blocks. Remember changing the names or styles below do not update blocks content or change existing class names attached to blocks.
 *
 * @package WordPress
 * @since 1.0.0
 */

// @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
// @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore
// @phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
// @phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect
// @phpcs:disable PEAR.Functions.FunctionCallSignature.Indent

wp.domReady(
() => {
// Hides comments as the site doesn't use it.
wp.data.dispatch( 'core/edit-post' ).removeEditorPanel( 'discussion-panel' );
// Hides tags as the site doesn't use them.
wp.data.dispatch( 'core/edit-post' ).removeEditorPanel( 'taxonomy-panel-post_tag' );

// Unregister unsupported unstyled Blocks.
wp.blocks.unregisterBlockType( 'core/archives' );
wp.blocks.unregisterBlockType( 'core/calendar' );
wp.blocks.unregisterBlockType( 'core/latest-comments' );
wp.blocks.unregisterBlockType( 'core/nextpage' );
wp.blocks.unregisterBlockType( 'core/pullquote' );
wp.blocks.unregisterBlockType( 'core/social-links' );
wp.blocks.unregisterBlockType( 'core/tag-cloud' );
wp.blocks.unregisterBlockType( 'core/verse' );
wp.blocks.unregisterBlockType( 'core/loginout' );
wp.blocks.unregisterBlockType( 'core/site-logo' );
wp.blocks.unregisterBlockType( 'core/site-tagline' );
wp.blocks.unregisterBlockType( 'core/site-title' );

// Unregister unsupported Theme blocks.
wp.blocks.unregisterBlockType( 'core/navigation' );
wp.blocks.unregisterBlockType( 'core/query' );
wp.blocks.unregisterBlockType( 'core/page-list' );
wp.blocks.unregisterBlockType( 'core/post-title' );
wp.blocks.unregisterBlockType( 'core/post-excerpt' );
wp.blocks.unregisterBlockType( 'core/post-featured-image' );
wp.blocks.unregisterBlockType( 'core/post-content' );
wp.blocks.unregisterBlockType( 'core/post-author' );
wp.blocks.unregisterBlockType( 'core/post-date' );
wp.blocks.unregisterBlockType( 'core/post-terms' );
wp.blocks.unregisterBlockType( 'core/post-comments' );
wp.blocks.unregisterBlockType( 'core/post-navigation-link' );
wp.blocks.unregisterBlockType( 'core/term-description' );
wp.blocks.unregisterBlockType( 'core/query-title' );

// Removed specific block styles.
wp.blocks.unregisterBlockStyle( 'core/image', 'rounded' );
wp.blocks.unregisterBlockStyle( 'core/quote', 'large' );
wp.blocks.unregisterBlockStyle( 'core/button', 'fill' );
wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
wp.blocks.unregisterBlockStyle( 'core/separator', 'dots' );
wp.blocks.unregisterBlockStyle( 'core/separator', 'wide' );

wp.blocks.registerBlockStyle(
	'core/separator',
	[
		{
			label: 'Full Width Line',
			name: 'horizontal-rule',
		},
		{
			label: 'Shadow Line',
			name: 'shadow-line',
		}
]
);

wp.blocks.registerBlockStyle(
	'core/paragraph',
	[
		{
			label: 'Opening Paragraph',
			name: 'opening-paragraph',
		},
		{
			label: 'Link CTA',
			name: 'link-cta',
		},
		{
			label: 'Boxed Uppercase',
			name: 'boxed-uppercase',
		}
]
);

wp.blocks.registerBlockStyle(
	'core/heading',
	[
		{
		label: 'Page Title',
		name: 'page-title',
	},
	{
		label: 'Section Heading',
		name: 'section-heading',
	}
]
);

let blocksToStyle = [
	'core/heading',
	'core/paragraph',
];

blocksToStyle.forEach( ( block ) => {
	wp.blocks.registerBlockStyle(
		block,
		[
			{
				label: 'Default',
				name: 'default',
				isDefault: true,
			},
			{
				label: 'Spaced Uppercase',
				name: 'spaced-uppercase',
			},
			{
				label: 'Max width 800px',
				name: 'max-width-800',
			},
			{
				label: 'Max width 900px',
				name: 'max-width-900',
			}
		]
	);
} );

wp.blocks.registerBlockStyle(
	'core/image',
	[
		{
		label: 'Blob',
		name: 'blob',
	}
]
);

wp.blocks.registerBlockStyle(
	'core/list',
	[
		{
			label: 'More Spacing',
			name: 'more-spacing',
		},
		{
			label: 'No Padding',
			name: 'no-style-list',
		}
	]
);

wp.blocks.registerBlockStyle(
	'core/group',[
	{
		label: 'No Padding',
		name: 'no-padding',
	},
	{
		label: 'Gradient Down Section',
		name: 'gradient-down-section',
	},
	{
		label: 'Gradient Up Section',
		name: 'gradient-up-section',
	},
	{
		label: 'Box Shadow',
		name: 'box-shadow',
	}
]
);

wp.blocks.registerBlockStyle(
	'core/columns',[
	{
		label: '50px Padding',
		name: '50px-padding',
	}
]
);

wp.blocks.registerBlockStyle(
	'core/button',[
		{
			label: 'Default',
			name: 'default',
			isDefault: true,
		},
	{
		label: 'Reduced Height',
		name: 'reduced-height',
	}
]
);

wp.blocks.registerBlockStyle(
	'core/spacer',
	[
		{
			label: '40px (20px mobile)',
			name: '20-40',
		},
		{
			label: '40px (30px mobile)',
			name: '30-40',
		},
		{
			label: '50px (25px mobile)',
			name: '25-50',
		},
		{
			label: '50px (30px mobile)',
			name: '30-50',
		},
		{
			label: '60px (20px mobile)',
			name: '20-60',
		},
		{
			label: '60px (30px mobile)',
			name: '30-60',
		},
		{
	label: '60px (40px mobile)',
			name: '40-60',
		},
		{
			label: '70px (60px mobile)',
			name: '60-70',
		},
		{
			label: '80px (40px mobile)',
			name: '40-80',
		},
		{
			label: '90px (70px mobile)',
			name: '70-90',
		},
		{
			label: '100px (60px mobile)',
			name: '60-100',
		},
		{
			label: '100px (70px mobile)',
			name: '70-100',
		},
		{
			label: '120px (80px mobile)',
			name: '80-120',
		},
	]
);

const el = wp.element.createElement;
const SVG = wp.primitives.SVG;
const iconColumnsTwoThirdOneThird = el(
	SVG,
	{ width: 48, height: 48, viewBox: '0 0 48 48' },
	el( 'path', {
		fillRule: 'evenodd',
		clipRule: 'evenodd',
		d:
	'M39 12C40.1046 12 41 12.8954 41 14V34C41 35.1046 40.1046 36 39 36H9C7.89543 36 7 35.1046 7 34V14C7 12.8954 7.89543 12 9 12H39ZM39 34V14H30V34H39ZM28 34H9V14H28V34Z',
	} )
);

wp.blocks.registerBlockVariation(
	'core/columns', {
		name: 'sixty-forty-columns',
		title: '60 / 40',
		icon: iconColumnsTwoThirdOneThird,
		scope: [ 'block' ],
		innerBlocks: [
			[ 'core/column', {
				width: 60 } ],
			[ 'core/column', {
				width: 40 } ],
		],
	}
);
}
);

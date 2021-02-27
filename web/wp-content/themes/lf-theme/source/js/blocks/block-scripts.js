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
		wp.data.dispatch( 'core/edit-post').removeEditorPanel( 'taxonomy-panel-post_tag' );

		// Unregister unsupported unstyled Blocks.
		wp.blocks.unregisterBlockType( 'core/nextpage' );
		wp.blocks.unregisterBlockType( 'core/verse' );
		wp.blocks.unregisterBlockType( 'core/pullquote' );
		wp.blocks.unregisterBlockType( 'core/social-link' );
		wp.blocks.unregisterBlockType( 'core/tag-cloud' );

		// Removed rounded image style.
		wp.blocks.unregisterBlockStyle( 'core/image', 'rounded' );
		wp.blocks.unregisterBlockStyle( 'core/quote', 'large' );

		// Used for Join page.
		wp.blocks.registerBlockVariation( 'core/columns', {
			name: 'join-table',
			title: 'Join Table (4 Columns)',
			attributes: {
				className: 'is-style-join-table' },
			isDefault: false,
			innerBlocks: [
				[ 'core/column', {
					width: 25,
					className: 'jt-01' } ],
				[ 'core/column', {
					width: 25,
					className: 'jt-02' } ],
				[ 'core/column', {
					width: 25,
					className: 'jt-03' } ],
				[ 'core/column', {
					width: 25,
					className: 'jt-04' } ],
			],
			icon: 'text',
			scope: [ 'inserter' ],
		} );

		// Used for Join page.
		wp.blocks.registerBlockVariation( 'core/columns', {
			name: 'join-table-one',
			title: 'Join Table (1 Column)',
			attributes: {
				className: 'is-style-join-table-one' },
			isDefault: false,
			innerBlocks: [
				[ 'core/column', {
					width: 100,
					className: 'jt-05' } ],
			],
			icon: 'text',
			scope: [ 'inserter' ],
		} );

		// Used for End User page.
		wp.blocks.registerBlockVariation( 'core/columns', {
			name: 'end-user-table',
			title: 'End User Table (3 Columns)',
			attributes: {
				className: 'is-style-end-user-table' },
			isDefault: false,
			innerBlocks: [
				[ 'core/column', {
					width: 33.3,
					className: 'eu-01' } ],
				[ 'core/column', {
					width: 33.3,
					className: 'eu-02' } ],
				[ 'core/column', {
					width: 33.3,
					className: 'eu-03' } ],
			],
			icon: 'text',
			scope: [ 'inserter' ],
		} );

		// Unstyled list used in columns.
		wp.blocks.registerBlockVariation( 'core/list', {
			name: 'no-style-list',
			title: 'List (No Padding)',
			attributes: {
				className: 'is-style-no-style-list' },
			isDefault: false,
			icon: 'list-view',
			scope: [ 'inserter' ],
		} );

		// Pricing Table 3 Columns.
		wp.blocks.registerBlockVariation( 'core/table', {
			name: 'pricing-table-three',
			title: 'Pricing Table (3 Columns)',
			attributes: {
				className: 'is-style-pricing-table',
				hasFixedLayout: true,
				body: [
					{
						cells: [
							{
								content: 'Cell 1',
								tag: 'td',
							},
							{
								content: 'Cell 2',
								tag: 'td',
							},
							{
								content: 'Cell 3',
								tag: 'td',
							},
						],
					},
				],

			},
			isDefault: false,
			icon: 'editor-table',
			scope: [ 'inserter' ],
		} );

		// Pricing Table 2 Columns.
		wp.blocks.registerBlockVariation( 'core/table', {
			name: 'pricing-table-two',
			title: 'Pricing Table (2 Columns)',
			attributes: {
				className: 'is-style-pricing-table',
				hasFixedLayout: true,
				body: [
					{
						cells: [
							{
								content: 'Cell 1',
								tag: 'td',
							},
							{
								content: 'Cell 2',
								tag: 'td',
							},
						],
					},
				],
			},
			isDefault: false,
			icon: 'editor-table',
			scope: [ 'inserter' ],
		} );

		// Button - PDF
		wp.blocks.registerBlockVariation( 'core/buttons', {
			name: 'button-pdf',
			title: 'Button (PDF Icon)',
			attributes: {
				className: 'is-style-button-pdf' },
			isDefault: false,
			icon: 'media-document',
			scope: [ 'inserter' ],
		} );

		// Used for Section Headers on home.
		wp.blocks.registerBlockVariation( 'core/columns', {
			name: 'section-header',
			title: 'Section Header',
			attributes: {
				className: 'is-style-section-header' },
			isDefault: false,
			innerBlocks: [
				[ 'core/column', {
					width: 70,
					className: 'bh-01',
				},
				[
					[ 'core/heading', {
						level: 3,
						placeholder: 'Section header text' },
					],
				],
				],
				[ 'core/column', {
					width: 30,
					className: 'bh-02',
				},
				[
					[ 'core/heading', {
						level: 6,
						placeholder: 'View all...',
					},
					],
				],
				],
			],
			icon: 'text',
			scope: [ 'inserter' ],
    } );

    // Used for Section Headers on home (when in column).
		wp.blocks.registerBlockVariation( 'core/columns', {
			name: 'section-header-column',
			title: 'Section Header (for column layout)',
			attributes: {
				className: 'is-style-section-header-column' },
			isDefault: false,
			innerBlocks: [
				[ 'core/column', {
					width: 60,
					className: 'bh-01',
				},
				[
					[ 'core/heading', {
						level: 3,
						placeholder: 'Section header text' },
					],
				],
				],
				[ 'core/column', {
					width: 40,
					className: 'bh-02',
				},
				[
					[ 'core/heading', {
						level: 6,
						placeholder: 'View all...',
					},
					],
				],
				],
			],
			icon: 'text',
			scope: [ 'inserter' ],
		} );

  const el = wp.element.createElement;
  const SVG = wp.primitives.SVG;
  const iconColumnsTwoThirdOneThird = el(
    SVG,
    { width: 48, height: 48, viewBox: '0 0 48 48' },
    el('path', {
      fillRule: 'evenodd',
      clipRule: 'evenodd',
      d:
      'M39 12C40.1046 12 41 12.8954 41 14V34C41 35.1046 40.1046 36 39 36H9C7.89543 36 7 35.1046 7 34V14C7 12.8954 7.89543 12 9 12H39ZM39 34V14H30V34H39ZM28 34H9V14H28V34Z',
    })
  );

    wp.blocks.registerBlockVariation(
      'core/columns', {
        name: 'sixty-forty-columns',
        title: '60 / 40',
        icon: iconColumnsTwoThirdOneThird,
        scope: ['block'],
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

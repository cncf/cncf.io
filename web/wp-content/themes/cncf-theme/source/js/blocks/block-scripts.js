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

		// Removed rounded image style.
		wp.blocks.unregisterBlockStyle( 'core/image', 'rounded' );

		// Used for Join page.
		wp.blocks.registerBlockVariation( 'core/columns', {
			name: 'join-table',
			title: 'Join Table (4 Cols)',
			attributes: { className: 'is-style-join-table' },
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
			icon: 'layout',
			scope: [ 'block' ],
		} );

		// Used for Join page.
		wp.blocks.registerBlockVariation( 'core/columns', {
			name: 'join-table-one',
			title: 'Join Table (1 Col)',
			attributes: { className: 'is-style-join-table-one' },
			isDefault: false,
			innerBlocks: [
				[ 'core/column', {
					width: 100,
					className: 'jt-05' } ],
			],
			icon: 'layout',
			scope: [ 'block' ],
		} );

		// Unstyled list used on Join.
		wp.blocks.registerBlockVariation( 'core/list', {
			name: 'no-style-list',
			title: 'List (No Styles)',
			attributes: { className: 'is-style-no-style-list' },
			isDefault: false,
			icon: 'layout',
			scope: [ 'inserter' ],
		} );

		// Pricing Table 3 Columns.
		wp.blocks.registerBlockVariation( 'core/table', {
			name: 'pricing-table-three',
			title: 'Pricing Table (3 Columns)',
			attributes: {
				className: 'is-style-pricing-table-three',
				hasFixedLayout: true,
				body: [
					{
						cells: [
							{
								content: '1',
								tag: 'td',
							},
							{
								content: '2',
								tag: 'td',
							},
							{
								content: '3',
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
				className: 'is-style-pricing-table-two',
				hasFixedLayout: true,
				body: [
					{
						cells: [
							{
								content: '1',
								tag: 'td',
							},
							{
								content: '2',
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
	}
);

// phpcs:ignoreFile
/**
 * Blocks Scripts-for applying JS to editor
 *
 * Use this for styling editor blocks
 *
 * @package WordPress
 * @since 1.0.0
`*
 * @tags
 * @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
 * @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect
 * @phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
 */

wp.domReady(
	() => {
    // Hides comments.
    wp.data.dispatch( 'core/edit-post' ).removeEditorPanel( 'discussion-panel' );
    // hides captions on gallery.
    wp.blocks.unregisterBlockStyle( 'core/image', 'rounded' );

    wp.blocks.registerBlockVariation(
      'core/quote',
      {
        name: 'transparent-quote',
        title: 'Transparent Quote',
      },
    );

    // TODO: Possibly use this approach instead of styles.
		wp.blocks.registerBlockVariation( 'core/columns', {
			name: 'responsive-two-columns',
			title: 'Responsive Two Columns',
			isDefault: true,
			innerBlocks: [
				[ 'core/column', {
					width: 33.33,
					className: 'column-01' } ],
				[ 'core/column', {
					width: 66.66,
					className: 'column-02' } ] ],
			icon: 'smiley',
			scope: [ 'block' ],
		} );
	}
);

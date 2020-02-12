// phpcs:ignoreFile
/**
 * Blocks Scripts-for applying JS to editor
 *
 * Use this for styling editor blocks
 *
 * @package WordPress
 * @since 1.0.0
 */

wp.domReady(
	() => {
	// Hides comments.
		wp.data.dispatch(
			'core/edit-post' ).removeEditorPanel(
			'discussion-panel' );
		// hides captions on gallery.
		wp.blocks.registerBlockStyle(
			'core/gallery', {
				name: 'slug-hide-caption',
				label: wp.i18n.__( 'Hide captions', 'text-domain' ),
				isDefault: true,
			} );
		// Max width styling.
		wp.blocks.registerBlockStyle(
			'core/paragraph',
			{
				name: 'max-800',
				label: 'Max Width 800px',
				isDefault: true,
			}
		);
		// Max width styling.
		wp.blocks.registerBlockStyle(
			'core/paragraph',
			{
				name: 'max-900',
				label: 'Max Width 900px',
			}
		);
		// Max width styling.
		wp.blocks.registerBlockStyle(
			'core/heading',
			{
				name: 'max-800',
				label: 'Max Width 800px',
			}
		);
		// Max width styling.
		wp.blocks.registerBlockStyle(
			'core/heading',
			{
				name: 'max-900',
				label: 'Max Width 900px',
			}
		);
		// Make heading text uppercase.
		wp.blocks.registerBlockStyle(
			'core/heading',
			{
				name: 'uppercase-20px',
				label: 'Uppercase Small Text',
			}
		);
		// Apply blue gradient background to group.
		wp.blocks.registerBlockStyle(
			'core/group',
			{
				name: 'blue-gradient',
				label: 'Blue Gradient Background',
			}
		);
		// Apply light blue gradient background to group.
		wp.blocks.registerBlockStyle(
			'core/group',
			{
				name: 'light-blue-gradient',
				label: 'Light Blue Gradient Background',
			}
		);
		// Make seperator 50px.
		wp.blocks.registerBlockStyle(
			'core/separator',
			{
				name: 'width-50',
				label: '50px width',
			}
		);
		// Make columns centered.
		wp.blocks.registerBlockStyle(
			'core/columns',
			{
				name: 'centered-content',
				label: 'Centered Content',
			}
		);
	}
);

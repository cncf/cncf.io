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
		wp.blocks.unregisterBlockStyle( 'core/image', 'rounded' );
	}
);

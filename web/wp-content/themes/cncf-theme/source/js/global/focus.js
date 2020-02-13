/**
 * Focus ring improvements for non-focus
 *
 * @package WordPress
 * @since 1.0.0
 */

// Listen to tab events to enable outlines.
document.body.addEventListener(
	'keyup',
	function( e ) {
		if ( e.which === 9 ) { /* tab */
			document.documentElement.classList.remove( 'no-focus-outline' );
		}
	}
);

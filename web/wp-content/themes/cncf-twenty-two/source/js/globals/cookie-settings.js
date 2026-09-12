/**
 *
 * Cookie settings
 *
 * Opens the Transcend consent manager from any "Cookie settings" link.
 *
 * @package WordPress
 * @since 1.0.0
 */

( function() {
	document.addEventListener(
		'click',
		function( e ) {
			const link = e.target.closest( 'a' );

			if ( ! link || 'cookie settings' !== link.textContent.trim().toLowerCase() ) {
				return;
			}

			e.preventDefault();

			if ( window.transcend && 'function' === typeof window.transcend.showConsentManager ) {
				window.transcend.showConsentManager();
			}
		}
	);
} )();

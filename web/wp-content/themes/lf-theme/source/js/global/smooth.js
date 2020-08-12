/**
 * Smooth Scrolling
 *
 * Based on https://css-tricks.com/snippets/jquery/smooth-scrolling/
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		// Select all links with hashes.
		$( 'a[href*="#"]' )
		// Remove links that don't actually link to anything.
			.not( '[href="#"]' )
			.not( '[href="#0"]' )
			.click(
				function( event ) {
					// On-page links.
					if (
						location.pathname.replace( /^\//, '' ) === this.pathname.replace( /^\//, '' ) &&
					location.hostname === this.hostname ) {
						// Element to scroll to.
						let target = $( this.hash );
						// add offset for static menu.
						const customOffset = 120;
						target = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );
						// Check scroll target exists.
						if ( target.length ) {
							// Only prevent default if animation is actually gonna happen.
							event.preventDefault();
							$( 'html, body' ).animate(
								{
									scrollTop: target.offset().top - customOffset,
								},
								1000
							);
						}
					}
				}
			);
	}
);

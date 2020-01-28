/**
 * Smooth Scrolling
 *
 * See https://css-tricks.com/snippets/jquery/smooth-scrolling/
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
					if ( location.pathname.replace( /^\//, '' ) === (
						this.pathname.replace( /^\//, '' ) && location.hostname === this.hostname ) ) {
						// Figure out element to scroll to.
						let target = $( this.hash );
						target = target.length ?
							target :
							$( '[name=' + this.hash.slice( 1 ) + ']' );
						// Does a scroll target exist?
						if ( target.length ) {
							// Only prevent default if animation is actually gonna happen.
							event.preventDefault();
							const customoffset = 0;
							$( 'html, body' ).animate(
								{ scrollTop: target.offset().top - customoffset },
								500
							);
						}
					}
				}
			);
	}
);

/**
 *
 * Back to top
 *
 * Adapted from vanillatop https://github.com/bernydole/vanillatop
 *
 * @package WordPress
 * @since 1.0.0
 */

/* eslint-disable no-mixed-operators */
/* eslint-disable no-unused-expressions */

( function() {
	document.addEventListener(
		'DOMContentLoaded',
		function() {
			// declare the back to top element.
			const goTopButton = document.querySelector( '.back-to-top' );

			// browser window scroll (in pixels) after which the "back to top" link is shown.
			const offset = 1500;

			// how long scroll takes.
			const scrollDuration = 900;

			// Setup variable to store scroll position.
			let lastScrollPosition = 0;

			// Track whether call is currently in process.
			let tick = false;

			function scrollToTop( duration ) {
				let start = window.pageYOffset,
					startTime = Math.floor( Date.now() );

				function scroll() {
					Math.easeInOutQuad = function( t ) {
						return t < 0.5 ? 2 * t * t : -1 + ( 4 - 2 * t ) * t;
					};
					let time = Math.min( 1, ( ( Math.floor( Date.now() ) - startTime ) / duration ) );
					window.scroll( 0, Math.ceil( ( Math.easeInOutQuad( time ) * ( 0 - start ) ) + start ) );
					if ( window.pageYOffset === 0 ) {
						return;
					}
					requestAnimationFrame( scroll );
				}
				scroll();
			}

			function scrollingDown( currentScrollPosition ) {
				if ( currentScrollPosition > offset ) {
					goTopButton.classList.add( 'is-active' );
				} else {
					goTopButton.classList.remove( 'is-active' );
				}
			}

			// add event listener to element.
			goTopButton.addEventListener(
				'click',
				function() {
					( ! window.requestAnimationFrame ) ? window.scrollTo( 0, 0 ) : scrollToTop( scrollDuration );
				}
			);

			// control scroll listening speed.
			window.addEventListener(
				'scroll',
				function() {
					lastScrollPosition = window.scrollY;
					if ( ! tick ) {
						setTimeout(
							function() {
								scrollingDown( lastScrollPosition );
								tick = false;
							},
							800
						);
					}
					tick = true;
				}
			);
		}
	);
}() );

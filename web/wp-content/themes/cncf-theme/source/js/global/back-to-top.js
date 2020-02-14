/**
 * Back to top
 *
 * @package WordPress
 * @since 1.0.0
 */

// Setup variable.
let lastScrollPosition = 0;

// Track whether call is currently in process.
let tick = false;

/**
 * Show back to top
 *
 * @param {integer} scrollPos Y position of scroll.
 */
function showBackToTop( scrollPos ) {
	// declare the back to top element.
	const b = document.querySelector( '.back-to-top' );

	// if element isn't present return.
	if ( ! b ) {
		return;
	}

	if ( scrollPos > 1500 ) {
		b.classList.add( 'is-active' );
	} else {
		b.classList.remove( 'is-active' );
	}
}

window.addEventListener(
	'scroll',
	function() {
		lastScrollPosition = window.scrollY;
		if ( ! tick ) {
			setTimeout(
				function() {
					showBackToTop( lastScrollPosition );
					tick = false;
				},
				200
			);
		}
		tick = true;
	}
);

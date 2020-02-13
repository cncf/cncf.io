/**
 * Menu Accessibility
 *
 * Source https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @package WordPress
 * @since 1.0.0
 */

const menuAccessibility = () => {
	// declare site navigation.
	const container = document.querySelector( '.site-navigation' );

	// if navigation isn't present return.
	if ( ! container ) {
		return;
	}

	// declare the first ul menu in the site nav.
	const menu = container.getElementsByTagName( 'ul' )[ 0 ];

	menu.setAttribute( 'aria-expanded', 'false' );
	// Set some attributes.
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	// Get all the link elements within the menu.
	const links = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( let i = 0, len = links.length; i < len; i++ ) {
		links[ i ].addEventListener( 'focus', toggleFocus, true );
		links[ i ].addEventListener( 'blur', toggleFocus, true );
	}

	// Sets or removes focus on an element.
	function toggleFocus() {
		let self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {
			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}
};

/**
 * Is the DOM ready?
 *
 * This implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Function} fn Callback function to run.
 */
const cncfDomReady = ( fn ) => {
	if ( typeof fn !== 'function' ) {
		return;
	}

	if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
		return fn();
	}

	document.addEventListener( 'DOMContentLoaded', fn, false );
};

cncfDomReady(
	function() {
		menuAccessibility();
	}
);

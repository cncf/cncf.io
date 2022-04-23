/** File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
 * and https://github.com/cedaro/skip-link-focus
 *
 * @package WordPress
 * @since 1.0.0
 */

/**
 * Make "skip to content" links work correctly in IE9, Chrome, and Opera to
 * improve accessibility.
 */
( function () {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	is_opera = navigator.userAgent.toLowerCase().indexOf( 'opera' ) > -1,
	is_ie = navigator.userAgent.toLowerCase().indexOf( 'msie' ) > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener(
			'hashchange',
			function () {
				var id = location.hash.substring( 1 ),
				element;

				if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
					return;
				}

				element = document.getElementById( id );

				if ( element ) {
					if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
						element.tabIndex = -1;
					}

					element.focus();
				}
			},
			false
		);
	}
} )();

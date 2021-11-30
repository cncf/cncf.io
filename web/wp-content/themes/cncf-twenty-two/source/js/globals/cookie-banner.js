/**
 * Cookie Banner
 *
 * @package WordPress
 * @since 1.0.0
 * @author James Hunt
 */

// Checks for cookie on load, if not present, shows banner.
if ( document.cookie.indexOf( 'cookieaccepted' ) < 0 ) {
	document.getElementById( 'cookie-banner' ).style.cssText = 'visibility: visible; opacity: 1';
}

// Add event listener to button in banner.
document.getElementById( 'cookie-banner-button' ).addEventListener(
	'click',
	function() {
		acceptCookie();
	}
);

// Function to create cookie and hide banner.
function acceptCookie() {
	document.cookie = 'cookieaccepted=1; expires=Thu, 18 Dec 2030 12:00:00 UTC; path=/';
	document.getElementById( 'cookie-banner' ).style.cssText = 'visibility: hidden; opacity: 0';
}

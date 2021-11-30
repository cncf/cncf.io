/**
 * JS Utils
 *
 * Available globally attached to window.
 *
 * @package WordPress
 * @since 1.0.0
 */

( function( global ) {
	// Generic throttle function.
	// window.utils.isThrottled() - how to use.
	function throttle( callback, wait, immediate = false ) {
		let timeout = null;
		let initialCall = true;
		return function() {
			const callNow = immediate && initialCall;
			const next = () => {
				callback.apply( this, arguments );
				timeout = null;
			};
			if ( callNow ) {
				initialCall = false;
				next();
			}
			if ( ! timeout ) {
				timeout = setTimeout( next, wait );
			}
		};
	}

	// Global bundle.
	global.utils = {
		isThrottled: throttle,
	};
}( window ) );

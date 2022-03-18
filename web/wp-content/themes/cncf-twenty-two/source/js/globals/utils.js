/**
 * JS Utils
 *
 * Available globally attached to window.
 *
 * @package WordPress
 * @since 1.0.0
 */

// TODO: Throttle not working as it should.
(function (window) {
	// Generic throttle function.
	// window.utils.isThrottled() - how to use.

	function throttle(callback, limit) {
		let waiting = false; // Initially, we're not waiting.
		return function () {
			// We return a throttled function.
			if ( ! waiting) {
				// If we're not waiting.
				callback.apply( this, arguments ); // Execute users function.
				waiting = true; // Prevent future invocations.
				setTimeout(
					function () {
						// After a period of time.
						waiting = false; // And allow future invocations.
					},
					limit
				);
			}
		};
	}

	// Global bundle.
	window.utils = {
		isThrottled: throttle,
	};
})( window );

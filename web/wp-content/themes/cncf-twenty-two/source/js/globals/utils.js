/**
 * JS Utils
 *
 * Available globally attached to window.
 *
 * @package WordPress
 * @since 1.0.0
 */

// TODO: Throttle not working as it should?
( function( window ) {
	// Generic throttle function.
	// window.utils.isThrottled() - how to use.

	function throttle( callback, limit ) {
		let waiting = false; // Initially, we're not waiting.
		return function() {
			// We return a throttled function.
			if ( ! waiting ) {
				// If we're not waiting.
				callback.apply( this, arguments ); // Execute users function.
				waiting = true; // Prevent future invocations.
				setTimeout(
					function() {
						// After a period of time.
						waiting = false; // And allow future invocations.
					},
					limit,
				);
			}
		};
	}

	// Global bundle.
	window.utils = {
		isThrottled: throttle,
	};

}( window ) );

( function () {
	document.addEventListener(
		'DOMContentLoaded',
		function () {

			// AOS only set to load on the homepage.
			if (typeof AOS == "undefined") {
				console.log('undefined');
				return;
			}

			// Initialize AOS.
			AOS.init({
				// Global settings:
				disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
				startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
				initClassName: 'aos-init', // class applied after initialization
				animatedClassName: 'aos-animate', // class applied on animation
				useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
				disableMutationObserver: false, // disables automatic mutations' detections (advanced)
				debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
				throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)
				
			  
				// Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
				offset: -420, // offset (in px) from the original trigger point
				delay: 0, // values from 0 to 3000, with step 50ms
				duration: 400, // values from 0 to 3000, with step 50ms
				easing: 'ease', // default easing for AOS animations
				once: false, // whether animation should happen only once - while scrolling down
				mirror: false, // whether elements should animate out while scrolling past them
				anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
			  
			});
		},
	);
}() );
	
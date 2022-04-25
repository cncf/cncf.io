/**
 * Homepage Terminal.
 *
 * @package WordPress
 * @since 1.0.0
 */

// phpcs:disable PEAR.Functions.FunctionCallSignature.Indent

(function () {
	document.addEventListener(
	'DOMContentLoaded',
	function () {

		let terminal = document.querySelector( '.home-terminal__replace' );

		let imageToDisplay = terminal.dataset.src;

		// Get matchMedia setting.
		let motionMatchMedia = window.matchMedia( '(prefers-reduced-motion)' );

		/**
		 * Sets the terminal image based on preferences.
		 */
		function getMotionMatch() {
			if (motionMatchMedia.matches) {
				imageToDisplay = terminal.dataset.reducedMotionSrc;
			} else {
				imageToDisplay = terminal.dataset.src;
			}
		}
		// Watches for change event to reload based on prefs.
		motionMatchMedia.addEventListener( 'change', getMotionMatch );
		// runs on first load.
		getMotionMatch();

		if ('IntersectionObserver' in window) {

			let imageObserver = new IntersectionObserver(
			function(entries, observer) {
				entries.forEach(
				function(entry) {
					if (entry.isIntersecting) {
						let terminal = entry.target;
						terminal.src = imageToDisplay;
						terminal.classList.remove( 'home-terminal__replace' );
						imageObserver.unobserve( terminal );
					}
				}
				);
			}
			);
			imageObserver.observe( terminal );
		} else {
			// Fallback if IO not supported.
			terminal.src = imageToDisplay;
		}

		// end.
	}
	);
})();

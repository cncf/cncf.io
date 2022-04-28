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
		let prefersReducedMotionSetting = window.matchMedia( '(prefers-reduced-motion)' );
		let prefersReducedMotionQuery   = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		let prefersReducedMotion        = ! prefersReducedMotionQuery || prefersReducedMotionQuery.matches;

		/**
		 * Sets the terminal image based on preferences.
		 */
		function getMotionMatch() {
			if (prefersReducedMotion) {
				imageToDisplay = terminal.dataset.reducedMotionSrc;
			} else {
				imageToDisplay = terminal.dataset.src;
			}
		}
		// Watches for change event to reload based on prefs.
		if (prefersReducedMotionSetting.addEventListener) {
			prefersReducedMotionSetting.addEventListener( 'change', getMotionMatch );
		}
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

/**
 * Homepage video.
 *
 * @package WordPress
 * @since 1.0.0
 */

// phpcs:disable PEAR.Functions.FunctionCallSignature.Indent

(function () {
	document.addEventListener(
	'DOMContentLoaded',
	function () {

		const overlay = document.querySelector( '.home-hero__overlay' );

		const poster = document.querySelector( '.home-hero__poster' );

		const video = document.querySelector( '.home-hero__video' );

		async function playVideo() {
			try {
				await video.play();
			} catch (err) {
				console.log( err )
			}
		}

		async function loadedPoster() {
			try {
				await poster.complete;
			} catch (err) {
				console.log( err )
			}
		}

		// once poster loads, apply lighter overlay.
		if (loadedPoster()) {
			overlay.classList.add( 'poster-has-loaded' );
		}

		// Get matchMedia setting.
		let prefersReducedMotionSetting = window.matchMedia( '(prefers-reduced-motion)' );
		let prefersReducedMotionQuery = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		let prefersReducedMotion = ! prefersReducedMotionQuery || prefersReducedMotionQuery.matches;

		/**
		 * Should the video play.
		 */
		function getMotionMatch() {
			if (prefersReducedMotion) {
				video.pause();
			} else {
				videoCanPlay();
			}
		}
		// Watches for change event to reload based on prefs.
		if (prefersReducedMotionSetting.addEventListener) {
			prefersReducedMotionSetting.addEventListener( 'change', getMotionMatch );
		}
		// runs on first load.
		getMotionMatch();

		/**
		 * Run the video.
		 */
		function videoCanPlay(){
			// start preloading video.
			video.preload = 'auto';

			// Check for iOS devices as they don't trigger same video events.
			const isIOS = typeof navigator.standalone === 'boolean';
			if (isIOS) {

				// watch for loadedmetadata ability.
				video.addEventListener(
				'loadedmetadata',
				(e) => {
					video.load();
					playVideo();
					// fade out poster.
					poster.classList.add( 'video-has-loaded' );
				},
				{ once: true }
				)

			} else {

				// watch for canplay ability.
				video.addEventListener(
				'canplay',
				(e) => {
					playVideo();
					// fade out poster.
					poster.classList.add( 'video-has-loaded' );
				},
				{ once: true }
				)
			}
		}

		// end.
	}
	);
})();

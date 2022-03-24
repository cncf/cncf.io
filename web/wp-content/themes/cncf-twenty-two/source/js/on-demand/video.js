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

			// start preloading video.
			video.preload = 'auto';

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

			// end.
		}
	);
})();

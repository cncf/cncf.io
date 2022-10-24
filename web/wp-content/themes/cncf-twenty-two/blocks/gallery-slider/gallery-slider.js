/**
 * Gallery Slider
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {

		const slider = $( '.wp-block-acf-gallery-slider__wrapper' );

		if ( ! slider ) {
			return;
		}

		slider.slick(
			{
				slidesToShow: 1,
				slidesToScroll: 1,
				swipeToSlide: true,
				draggable: true,
				centerMode: false,
				autoplay: true,
				appendArrows: false,
				arrows: true,
				prevArrow: $( '.wp-block-acf-gallery-slider__controls-prev' ),
				nextArrow: $( '.wp-block-acf-gallery-slider__controls-next' )
			}
		);

		// Get matchMedia setting.
		let prefersReducedMotionSetting = window.matchMedia( '(prefers-reduced-motion)' );
		let prefersReducedMotionQuery   = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		let prefersReducedMotion        = ! prefersReducedMotionQuery || prefersReducedMotionQuery.matches;

		/**
		 * Stops/starts Slick based on motion prefs.
		 */
		function getMotionMatch() {
			if (prefersReducedMotion) {
				slider.slick( 'slickPause' );
			} else {
				slider.slick( 'slickPlay' );
			}
		}
			// Watches for change event to reload based on prefs.
		if (prefersReducedMotionSetting.addEventListener) {
			prefersReducedMotionSetting.addEventListener( 'change', getMotionMatch );
		}
			// runs on first load.
			getMotionMatch();
	}
);





function gallerySlider($) {

}

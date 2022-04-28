/**
 * Slick Slider Config.
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {

		jQuery( ".home-projects-slider-item-1" ).slick(
			{
				infinite: true,
				slidesToShow: 10,
				slidesToScroll: 1,
				swipeToSlide: false,
				draggable: false,
				arrows: false,
				autoplay: true,
				appendArrows: false,
				autoplaySpeed: 0,
				cssEase: "linear",
				centerMode: true,
				variableWidth: true,
				lazyLoad: "ondemand",
				speed: 4500
			}
		);

		jQuery( ".home-projects-slider-item-2" ).slick(
			{
				infinite: true,
				slidesToShow: 10,
				slidesToScroll: 1,
				swipeToSlide: false,
				draggable: false,
				arrows: false,
				autoplay: true,
				appendArrows: false,
				autoplaySpeed: 0,
				cssEase: "linear",
				centerMode: true,
				variableWidth: true,
				lazyLoad: "ondemand",
				initialSlide: 6,
				speed: 5000,
				rtl: true
			}
		);

		// Get matchMedia setting.
		let prefersReducedMotionSetting = window.matchMedia( '(prefers-reduced-motion)' );
		let prefersReducedMotionQuery = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		let prefersReducedMotion = ! prefersReducedMotionQuery || prefersReducedMotionQuery.matches;

			/**
			 * Stops/starts Slick based on prefs.
			 */
		function getMotionMatch() {
			if (prefersReducedMotion) {
				jQuery( ".home-projects-slider-item-1" ).slick( 'slickPause' );
				jQuery( ".home-projects-slider-item-2" ).slick( 'slickPause' );
			} else {
				jQuery( ".home-projects-slider-item-1" ).slick( 'slickPlay' );
				jQuery( ".home-projects-slider-item-2" ).slick( 'slickPlay' );
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

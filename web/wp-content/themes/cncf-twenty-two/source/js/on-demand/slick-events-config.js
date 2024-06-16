/**
 * Events Banner - Slick Config
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		eventSlider( $ );

	}
);

function eventSlider($) {

	const slider = $( '.home-events-slider' );

	if ( ! slider ) {
		return;
	}

	slider.slick(
		{
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			swipeToSlide: true,
			draggable: false,
			autoplay: true,
			autoplaySpeed: 8000,
			cssEase: "linear",
			fade: true,
			lazyLoad: "ondemand",
			pauseOnHover: true,
			pauseOnFocus: false,
			prevArrow: '<svg alt="Previous" class="slick-prev" fill="none" height="36" viewBox="0 0 36 36" width="36" xmlns="http://www.w3.org/2000/svg"><circle cx="18" cy="18" fill="#fff" opacity=".7" r="18"/><path d="m21.125 25.5566-7-7 7-7" stroke="#15153b" stroke-width="2"/></svg>',
			nextArrow: '<svg alt="Next" class="slick-next"  fill="none" height="36" viewBox="0 0 36 36" width="36" xmlns="http://www.w3.org/2000/svg"><circle cx="18" cy="18" fill="#fff" opacity=".7" r="18"/><path d="m16 11.5566 7 7-7 7" stroke="#15153b" stroke-width="2"/></svg>'
		 }
	);
}

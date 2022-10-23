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
			autoplaySpeed: 5000,
			cssEase: "linear",
			lazyLoad: "ondemand",
			pauseOnHover: true,
			pauseOnFocus: false,
			prevArrow: '<img class="slick-prev" src="/wp-content/themes/cncf-twenty-two/images/slider-arrow-left.svg" />',
			nextArrow: '<img class="slick-next" src="/wp-content/themes/cncf-twenty-two/images/slider-arrow-right.svg" />'
		 }
	);
}

/**
 * Gallery Slider
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		gallerySlider( $ );

	}
);

function gallerySlider($) {

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
}

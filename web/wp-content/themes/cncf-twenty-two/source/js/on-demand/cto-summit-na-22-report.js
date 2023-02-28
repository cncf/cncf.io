/**
 * CTO Summit NA 2022 JS
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		photoSlider( $ );
	}
);

function photoSlider($) {

	const slider = $( '.section-09__slider' );

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
			prevArrow: $( '.section-09__prev' ),
			nextArrow: $( '.section-09__next' )
		}
	);
}

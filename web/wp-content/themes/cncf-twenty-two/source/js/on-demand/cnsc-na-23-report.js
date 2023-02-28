/**
 * CNCF NA 2023 JS
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

	const slider = $( '.section-02__slider' );

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
			prevArrow: $( '.section-02__prev' ),
			nextArrow: $( '.section-02__next' )
		}
	);
}

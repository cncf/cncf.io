/**
 * KCCNC EU 2022 JS
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		toggleJobs( $ );
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

function toggleJobs($){
	const open    = $( '*[data-id="js-hidden-section-trigger-open"]' );
	const close   = $( '*[data-id="js-hidden-section-trigger-close"]' );
	const section = $( '*[data-id="js-hidden-section"]' );

	if ( ! open || ! section ) {
		return;
	}

	open.click(
		function(){
			open.slideToggle( 100 );
			section.slideToggle( 600 );
			close.slideToggle( 300 );
		}
	);

	close.click(
		function(){
			open.slideToggle( 100 );
			section.slideToggle( 600 );
			close.slideToggle( 300 );
		}
	);

}

/**
 * KCCNC EU 2023 JS
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		toggleSection( $ );
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
function toggleSection($) {

	const buttons = $( '[data-id^="js-hidden-section-trigger"]' );

	buttons.each(
		function() {
			const button = $( this );
			const parentSection = button.closest( '[class^="section-"]' );
			const open = parentSection.find( '[data-id="js-hidden-section-trigger-open"]' );
			const close = parentSection.find( '[data-id="js-hidden-section-trigger-close"]' );
			const section = parentSection.find( '[data-id="js-hidden-section"]' );

			button.click(
				function() {
					open.slideToggle( 100 );
					section.slideToggle( 600 );
					close.slideToggle( 300 );
				}
			);
		}
	);
}

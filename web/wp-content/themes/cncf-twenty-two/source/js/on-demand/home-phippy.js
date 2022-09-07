/**
 * Homepage Phippy Footer.
 *
 * @package WordPress
 * @since 1.0.0
 */

// phpcs:disable PEAR.Functions.FunctionCallSignature.Indent

document.addEventListener(
	"DOMContentLoaded",
	function() {

		let calculatePhippyPadding;
		let phippyImage         = document.getElementById( 'phippy-footer' );
		let phippySpacer        = document.getElementById( 'phippy-spacer' );
		let footerContainer     = document.getElementById( 'inner-footer-container' );
		(calculatePhippyPadding = function() {
			let phippyImageHeight = phippyImage.clientHeight;
			let extraPaddingInPx  = 50;
			let viewportWidthInPx = window.innerWidth;
			if (viewportWidthInPx > 999) {
				extraPaddingInPx = 115;
			}
			let calculatedSpacingInPx = (phippyImageHeight - extraPaddingInPx);

			footerContainer.style.marginTop = (Math.abs( calculatedSpacingInPx / 3 ) * -1) + 'px';
			phippySpacer.style.height       = calculatedSpacingInPx + 'px';
		} )();
		window.addEventListener( "resize", calculatePhippyPadding );

	}
	);

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
		let phippyImage         = document.querySelector( '.phippy-footer__image' );
		let phippySpacer        = document.getElementById( 'phippy-spacer' );
		let footerContainer     = document.getElementById( 'inner-footer-container' );
		(calculatePhippyPadding = function() {
			if ( ! phippyImage ) {
				return;
			}
			let phippyImageHeight           = phippyImage.clientHeight;
			footerContainer.style.marginTop = (Math.abs( phippyImageHeight / 4 ) * -1) + 'px';
			phippySpacer.style.height       = Math.abs( (phippyImageHeight / 2 ) + 20 ) + 'px';
		} )();
		window.addEventListener( "resize", calculatePhippyPadding );
	}
	);

/**
 * Insert newsletter in to case study.
 *
 * @package WordPress
 * @since 1.0.0
 */

$(function(){
		// intro content of case study.
		let intro = document.querySelector( '.case-study-intro-wrapper' );

		// subscription box.
		let subscription = document.querySelector( '.case-study-subscription-block' );

		if ( ! intro || ! subscription ) {
			return;
		}

		let shouldDisplay = checkSizes();
		displaySubscription();

		// check that screen is bigger than 800px and intro is larger than 750px.
		function checkSizes() {
			let introHeight = intro.offsetHeight;
			return ( ( $( window ).width() >= 800 ) && ( introHeight >= 750 ) );
		}

		// Resize check for is mobile.
		function displaySubscription() {
			shouldDisplay = checkSizes();
			if ( shouldDisplay ) {
				subscription.setAttribute( 'style','display:block;' );
			} else {
				subscription.setAttribute( 'style','display:none;' );
			}
		}

		// Update on resize.
		$( window ).on( 'resize',window.utils.isThrottled( displaySubscription,200,true ) );

  });

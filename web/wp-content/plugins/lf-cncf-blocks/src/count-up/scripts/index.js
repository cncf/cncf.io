/* eslint-disable no-var */
/* eslint-disable no-console */
/* eslint-disable no-undef */

( function() {
	document.addEventListener( 'DOMContentLoaded', function() {
		function lfCountUpStart( block ) {
			if ( ! block ) {
				return;
			}

			const numbers = block.querySelectorAll( '[data-element="lf-number"]' );

			if ( numbers.length === 0 ) {
				return;
			}

			numbers.forEach( function( element ) {
				const countUp = new CountUp( element, element.dataset.to );
				if ( ! countUp.error ) {
					countUp.start();
				} else {
					console.error( countUp.error );
				}
			} );
		}

		const countUpBlocks = document.querySelectorAll( '[data-element=count-up-block]' );

		if ( countUpBlocks.length === 0 ) {
			return;
		}

		countUpBlocks.forEach( function( block ) {
			var waypoint = new Waypoint( {
				element: block,
				handler: function() {
					lfCountUpStart( block );
					waypoint.destroy();
				},
				offset: '75%',
			} );
		} );
	} );
}() );

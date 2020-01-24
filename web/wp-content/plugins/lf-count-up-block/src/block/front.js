
( function() {
	document.addEventListener('DOMContentLoaded', function() {
		function lfCountToAnimate( element, startValue, endValue, speed, originalText ) {
			var refreshInternal = 100;
			var current = startValue;
			var loops = Math.ceil( speed / refreshInternal );
			var loopCount = 0;
			var increment = Math.floor( ( endValue - startValue ) / loops );

			var timer = setInterval( function() {
				current += increment;
				loopCount++;
				element.innerHTML = current;
				if ( loopCount >= loops ) {
					clearInterval( timer );
					element.innerHTML = originalText;
				}
			}, refreshInternal );
		}

		var numbers = document.querySelectorAll('[data-element="lf-number"]');

		if ( numbers.length === 0 ) {
			return;
		}

		numbers.forEach( function(element) {
			lfCountToAnimate( element, 0, element.dataset.to, element.dataset.speed, element.dataset.original );
		});
	});
} ) ();

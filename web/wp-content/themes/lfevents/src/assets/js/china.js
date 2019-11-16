/**
 * JS code to run only on the Chinese-audience LFEvents sites.
 *
 * @package WordPress
 */

/**
 * Stores bag_track and discountCode url parameters to use for the bagevent
 * registration site.  They get re-added to any outgoing bagevent links.
 */
var bag_track = getParameterByName( 'bag_track' );
var discountCode = getParameterByName( 'discountCode' );
if (bag_track) {
	localStorage.bag_track = bag_track;
}
if (discountCode) {
	localStorage.discountCode = discountCode;
}

$( 'a[href*="bagevent.com"]' ).each(
	function () {
		var link = $( this ).attr( 'href' );
		var complement = '';
		if (localStorage.bag_track) {
			complement = 'bag_track=' + localStorage.bag_track
		}
		if (localStorage.discountCode) {
			if (complement) {
				complement += '&discountCode=' + localStorage.discountCode
			} else {
				complement = 'discountCode=' + localStorage.discountCode
			}
		}
		if (link && complement) {
			if (link.indexOf( '?' ) != -1) {
				$( this ).attr( 'href', link + '&' + complement );
			} else {
				$( this ).attr( 'href', link + '?' + complement );
			}
		}
	}
);

function getParameterByName(name, url) {
	if ( ! url) {
		url = window.location.href;
	}
	name = name.replace( /[\[\]]/g, '\\$&' );
	var regex = new RegExp( '[?&]' + name + '(=([^&#]*)|&|#|$)' ),
		results = regex.exec( url );
	if ( ! results) {
		return null;
	}
	if ( ! results[2]) {
		return '';
	}
	return decodeURIComponent( results[2].replace( /\+/g, ' ' ) );
}

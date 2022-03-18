/**
 *
 * Browser update notifications.
 *
 * From https://browser-update.org/en/
 *
 * @package
 * @since 1.0.0
 */

/* eslint-disable no-unused-vars */

let $buoop = {
	required: { e: 80, f: 88, o: 74, s: 12, c: 89 },
	insecure: true,
	api: 2022.02,
	test: false,
};
function $buo_f() {
	let e = document.createElement( 'script' );
	e.src = '//browser-update.org/update.min.js';
	document.body.appendChild( e );
}
try {
	document.addEventListener( 'DOMContentLoaded', $buo_f, false );
} catch (e) {
	window.attachEvent( 'onload', $buo_f );
}

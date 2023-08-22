/**
 *
 * Browser update notifications.
 *
 * From https://browser-update.org/en/
 *
 * @package WordPress
 * @since 1.0.0
 */

/* eslint-disable no-unused-vars */

var $buoop = {required:{e:-6,f:-6,o:-6,s:-4,c:-6},insecure:true,api:2023.08 };

function $buo_f(){
	var e = document.createElement( "script" );
	e.src = "//browser-update.org/update.min.js";
	document.body.appendChild( e );
};
try {
	document.addEventListener( "DOMContentLoaded", $buo_f,false )
} catch (e) {
	window.attachEvent( "onload", $buo_f )
}

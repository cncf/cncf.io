/**
 * Comment.
 *
 * @package FoundationPress
 */

// import $ from 'jquery';
// import whatInput from 'what-input';
//
// window.$ = $;
//
// import Foundation from 'foundation-sites';
// If you want to pick and choose which modules to include, comment out the above and uncomment
// the line below.
import './lib/foundation-explicit-pieces';
$( document ).foundation();

$( '.page_item_has_children a[href="#"]' ).click(
	function(e) {
		e.preventDefault();
	}
);

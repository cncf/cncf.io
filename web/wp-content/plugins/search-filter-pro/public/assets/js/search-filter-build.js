(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
(function (global){

var state = require('./includes/state');
var plugin = require('./includes/plugin');


(function ( $ ) {

	"use strict";

	$(function () {

		if (!Object.keys) {
		  Object.keys = (function () {
			'use strict';
			var hasOwnProperty = Object.prototype.hasOwnProperty,
				hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
				dontEnums = [
				  'toString',
				  'toLocaleString',
				  'valueOf',
				  'hasOwnProperty',
				  'isPrototypeOf',
				  'propertyIsEnumerable',
				  'constructor'
				],
				dontEnumsLength = dontEnums.length;

			return function (obj) {
			  if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
				throw new TypeError('Object.keys called on non-object');
			  }

			  var result = [], prop, i;

			  for (prop in obj) {
				if (hasOwnProperty.call(obj, prop)) {
				  result.push(prop);
				}
			  }

			  if (hasDontEnumBug) {
				for (i = 0; i < dontEnumsLength; i++) {
				  if (hasOwnProperty.call(obj, dontEnums[i])) {
					result.push(dontEnums[i]);
				  }
				}
			  }
			  return result;
			};
		  }());
		}

		/* Search & Filter jQuery Plugin */
		$.fn.searchAndFilter = plugin;

		/* init */
		$(".searchandfilter").searchAndFilter();

		/* external controls */
		$(document).on("click", ".search-filter-reset", function(e){

			e.preventDefault();

			var searchFormID = typeof($(this).attr("data-search-form-id"))!="undefined" ? $(this).attr("data-search-form-id") : "";
			var submitForm = typeof($(this).attr("data-sf-submit-form"))!="undefined" ? $(this).attr("data-sf-submit-form") : "";

			state.getSearchForm(searchFormID).reset(submitForm);

			//var $linked = $("#search-filter-form-"+searchFormID).searchFilterForm({action: "reset"});

			return false;

		});

	});


/*
 * jQuery Easing v1.4.1 - http://gsgd.co.uk/sandbox/jquery/easing/
 * Open source under the BSD License.
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * https://raw.github.com/gdsmith/jquery.easing/master/LICENSE
*/

/* globals jQuery, define, module, require */
(function (factory) {
	if (typeof define === "function" && define.amd) {
		define(['jquery'], function ($) {
			return factory($);
		});
	} else if (typeof module === "object" && typeof module.exports === "object") {
		module.exports = factory((typeof window !== "undefined" ? window['jQuery'] : typeof global !== "undefined" ? global['jQuery'] : null));
	} else {
		factory(jQuery);
	}
})(function($){

	// Preserve the original jQuery "swing" easing as "jswing"
	if (typeof $.easing !== 'undefined') {
		$.easing['jswing'] = $.easing['swing'];
	}

	var pow = Math.pow,
		sqrt = Math.sqrt,
		sin = Math.sin,
		cos = Math.cos,
		PI = Math.PI,
		c1 = 1.70158,
		c2 = c1 * 1.525,
		c3 = c1 + 1,
		c4 = ( 2 * PI ) / 3,
		c5 = ( 2 * PI ) / 4.5;

	// x is the fraction of animation progress, in the range 0..1
	function bounceOut(x) {
		var n1 = 7.5625,
			d1 = 2.75;
		if ( x < 1/d1 ) {
			return n1*x*x;
		} else if ( x < 2/d1 ) {
			return n1*(x-=(1.5/d1))*x + .75;
		} else if ( x < 2.5/d1 ) {
			return n1*(x-=(2.25/d1))*x + .9375;
		} else {
			return n1*(x-=(2.625/d1))*x + .984375;
		}
	}

	$.extend( $.easing, {
		def: 'easeOutQuad',
		swing: function (x) {
			return $.easing[$.easing.def](x);
		},
		easeInQuad: function (x) {
			return x * x;
		},
		easeOutQuad: function (x) {
			return 1 - ( 1 - x ) * ( 1 - x );
		},
		easeInOutQuad: function (x) {
			return x < 0.5 ?
				2 * x * x :
				1 - pow( -2 * x + 2, 2 ) / 2;
		},
		easeInCubic: function (x) {
			return x * x * x;
		},
		easeOutCubic: function (x) {
			return 1 - pow( 1 - x, 3 );
		},
		easeInOutCubic: function (x) {
			return x < 0.5 ?
				4 * x * x * x :
				1 - pow( -2 * x + 2, 3 ) / 2;
		},
		easeInQuart: function (x) {
			return x * x * x * x;
		},
		easeOutQuart: function (x) {
			return 1 - pow( 1 - x, 4 );
		},
		easeInOutQuart: function (x) {
			return x < 0.5 ?
				8 * x * x * x * x :
				1 - pow( -2 * x + 2, 4 ) / 2;
		},
		easeInQuint: function (x) {
			return x * x * x * x * x;
		},
		easeOutQuint: function (x) {
			return 1 - pow( 1 - x, 5 );
		},
		easeInOutQuint: function (x) {
			return x < 0.5 ?
				16 * x * x * x * x * x :
				1 - pow( -2 * x + 2, 5 ) / 2;
		},
		easeInSine: function (x) {
			return 1 - cos( x * PI/2 );
		},
		easeOutSine: function (x) {
			return sin( x * PI/2 );
		},
		easeInOutSine: function (x) {
			return -( cos( PI * x ) - 1 ) / 2;
		},
		easeInExpo: function (x) {
			return x === 0 ? 0 : pow( 2, 10 * x - 10 );
		},
		easeOutExpo: function (x) {
			return x === 1 ? 1 : 1 - pow( 2, -10 * x );
		},
		easeInOutExpo: function (x) {
			return x === 0 ? 0 : x === 1 ? 1 : x < 0.5 ?
				pow( 2, 20 * x - 10 ) / 2 :
				( 2 - pow( 2, -20 * x + 10 ) ) / 2;
		},
		easeInCirc: function (x) {
			return 1 - sqrt( 1 - pow( x, 2 ) );
		},
		easeOutCirc: function (x) {
			return sqrt( 1 - pow( x - 1, 2 ) );
		},
		easeInOutCirc: function (x) {
			return x < 0.5 ?
				( 1 - sqrt( 1 - pow( 2 * x, 2 ) ) ) / 2 :
				( sqrt( 1 - pow( -2 * x + 2, 2 ) ) + 1 ) / 2;
		},
		easeInElastic: function (x) {
			return x === 0 ? 0 : x === 1 ? 1 :
				-pow( 2, 10 * x - 10 ) * sin( ( x * 10 - 10.75 ) * c4 );
		},
		easeOutElastic: function (x) {
			return x === 0 ? 0 : x === 1 ? 1 :
				pow( 2, -10 * x ) * sin( ( x * 10 - 0.75 ) * c4 ) + 1;
		},
		easeInOutElastic: function (x) {
			return x === 0 ? 0 : x === 1 ? 1 : x < 0.5 ?
				-( pow( 2, 20 * x - 10 ) * sin( ( 20 * x - 11.125 ) * c5 )) / 2 :
				pow( 2, -20 * x + 10 ) * sin( ( 20 * x - 11.125 ) * c5 ) / 2 + 1;
		},
		easeInBack: function (x) {
			return c3 * x * x * x - c1 * x * x;
		},
		easeOutBack: function (x) {
			return 1 + c3 * pow( x - 1, 3 ) + c1 * pow( x - 1, 2 );
		},
		easeInOutBack: function (x) {
			return x < 0.5 ?
				( pow( 2 * x, 2 ) * ( ( c2 + 1 ) * 2 * x - c2 ) ) / 2 :
				( pow( 2 * x - 2, 2 ) *( ( c2 + 1 ) * ( x * 2 - 2 ) + c2 ) + 2 ) / 2;
		},
		easeInBounce: function (x) {
			return 1 - bounceOut( 1 - x );
		},
		easeOutBounce: bounceOut,
		easeInOutBounce: function (x) {
			return x < 0.5 ?
				( 1 - bounceOut( 1 - 2 * x ) ) / 2 :
				( 1 + bounceOut( 2 * x - 1 ) ) / 2;
		}
	});
	return $;
});

}(jQuery));

//safari back button fix
jQuery( window ).on( "pageshow", function(event) {
    if (event.originalEvent.persisted) {
        jQuery(".searchandfilter").off();
        jQuery(".searchandfilter").searchAndFilter();
    }
});

/* wpnumb - nouislider number formatting */
!function(){"use strict";function e(e){return e.split("").reverse().join("")}function n(e,n){return e.substring(0,n.length)===n}function r(e,n){return e.slice(-1*n.length)===n}function t(e,n,r){if((e[n]||e[r])&&e[n]===e[r])throw new Error(n)}function i(e){return"number"==typeof e&&isFinite(e)}function o(e,n){var r=Math.pow(10,n);return(Math.round(e*r)/r).toFixed(n)}function u(n,r,t,u,f,a,c,s,p,d,l,h){var g,v,w,m=h,x="",b="";return a&&(h=a(h)),i(h)?(n!==!1&&0===parseFloat(h.toFixed(n))&&(h=0),0>h&&(g=!0,h=Math.abs(h)),n!==!1&&(h=o(h,n)),h=h.toString(),-1!==h.indexOf(".")?(v=h.split("."),w=v[0],t&&(x=t+v[1])):w=h,r&&(w=e(w).match(/.{1,3}/g),w=e(w.join(e(r)))),g&&s&&(b+=s),u&&(b+=u),g&&p&&(b+=p),b+=w,b+=x,f&&(b+=f),d&&(b=d(b,m)),b):!1}function f(e,t,o,u,f,a,c,s,p,d,l,h){var g,v="";return l&&(h=l(h)),h&&"string"==typeof h?(s&&n(h,s)&&(h=h.replace(s,""),g=!0),u&&n(h,u)&&(h=h.replace(u,"")),p&&n(h,p)&&(h=h.replace(p,""),g=!0),f&&r(h,f)&&(h=h.slice(0,-1*f.length)),t&&(h=h.split(t).join("")),o&&(h=h.replace(o,".")),g&&(v+="-"),v+=h,v=v.replace(/[^0-9\.\-.]/g,""),""===v?!1:(v=Number(v),c&&(v=c(v)),i(v)?v:!1)):!1}function a(e){var n,r,i,o={};for(n=0;n<p.length;n+=1)if(r=p[n],i=e[r],void 0===i)"negative"!==r||o.negativeBefore?"mark"===r&&"."!==o.thousand?o[r]=".":o[r]=!1:o[r]="-";else if("decimals"===r){if(!(i>=0&&8>i))throw new Error(r);o[r]=i}else if("encoder"===r||"decoder"===r||"edit"===r||"undo"===r){if("function"!=typeof i)throw new Error(r);o[r]=i}else{if("string"!=typeof i)throw new Error(r);o[r]=i}return t(o,"mark","thousand"),t(o,"prefix","negative"),t(o,"prefix","negativeBefore"),o}function c(e,n,r){var t,i=[];for(t=0;t<p.length;t+=1)i.push(e[p[t]]);return i.push(r),n.apply("",i)}function s(e){return this instanceof s?void("object"==typeof e&&(e=a(e),this.to=function(n){return c(e,u,n)},this.from=function(n){return c(e,f,n)})):new s(e)}var p=["decimals","thousand","mark","prefix","postfix","encoder","decoder","negativeBefore","negative","edit","undo"];window.wNumb=s}();


}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiXHJcbnZhciBzdGF0ZSA9IHJlcXVpcmUoJy4vaW5jbHVkZXMvc3RhdGUnKTtcclxudmFyIHBsdWdpbiA9IHJlcXVpcmUoJy4vaW5jbHVkZXMvcGx1Z2luJyk7XHJcblxyXG5cclxuKGZ1bmN0aW9uICggJCApIHtcclxuXHJcblx0XCJ1c2Ugc3RyaWN0XCI7XHJcblxyXG5cdCQoZnVuY3Rpb24gKCkge1xyXG5cclxuXHRcdGlmICghT2JqZWN0LmtleXMpIHtcclxuXHRcdCAgT2JqZWN0LmtleXMgPSAoZnVuY3Rpb24gKCkge1xyXG5cdFx0XHQndXNlIHN0cmljdCc7XHJcblx0XHRcdHZhciBoYXNPd25Qcm9wZXJ0eSA9IE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHksXHJcblx0XHRcdFx0aGFzRG9udEVudW1CdWcgPSAhKHt0b1N0cmluZzogbnVsbH0pLnByb3BlcnR5SXNFbnVtZXJhYmxlKCd0b1N0cmluZycpLFxyXG5cdFx0XHRcdGRvbnRFbnVtcyA9IFtcclxuXHRcdFx0XHQgICd0b1N0cmluZycsXHJcblx0XHRcdFx0ICAndG9Mb2NhbGVTdHJpbmcnLFxyXG5cdFx0XHRcdCAgJ3ZhbHVlT2YnLFxyXG5cdFx0XHRcdCAgJ2hhc093blByb3BlcnR5JyxcclxuXHRcdFx0XHQgICdpc1Byb3RvdHlwZU9mJyxcclxuXHRcdFx0XHQgICdwcm9wZXJ0eUlzRW51bWVyYWJsZScsXHJcblx0XHRcdFx0ICAnY29uc3RydWN0b3InXHJcblx0XHRcdFx0XSxcclxuXHRcdFx0XHRkb250RW51bXNMZW5ndGggPSBkb250RW51bXMubGVuZ3RoO1xyXG5cclxuXHRcdFx0cmV0dXJuIGZ1bmN0aW9uIChvYmopIHtcclxuXHRcdFx0ICBpZiAodHlwZW9mIG9iaiAhPT0gJ29iamVjdCcgJiYgKHR5cGVvZiBvYmogIT09ICdmdW5jdGlvbicgfHwgb2JqID09PSBudWxsKSkge1xyXG5cdFx0XHRcdHRocm93IG5ldyBUeXBlRXJyb3IoJ09iamVjdC5rZXlzIGNhbGxlZCBvbiBub24tb2JqZWN0Jyk7XHJcblx0XHRcdCAgfVxyXG5cclxuXHRcdFx0ICB2YXIgcmVzdWx0ID0gW10sIHByb3AsIGk7XHJcblxyXG5cdFx0XHQgIGZvciAocHJvcCBpbiBvYmopIHtcclxuXHRcdFx0XHRpZiAoaGFzT3duUHJvcGVydHkuY2FsbChvYmosIHByb3ApKSB7XHJcblx0XHRcdFx0ICByZXN1bHQucHVzaChwcm9wKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdCAgfVxyXG5cclxuXHRcdFx0ICBpZiAoaGFzRG9udEVudW1CdWcpIHtcclxuXHRcdFx0XHRmb3IgKGkgPSAwOyBpIDwgZG9udEVudW1zTGVuZ3RoOyBpKyspIHtcclxuXHRcdFx0XHQgIGlmIChoYXNPd25Qcm9wZXJ0eS5jYWxsKG9iaiwgZG9udEVudW1zW2ldKSkge1xyXG5cdFx0XHRcdFx0cmVzdWx0LnB1c2goZG9udEVudW1zW2ldKTtcclxuXHRcdFx0XHQgIH1cclxuXHRcdFx0XHR9XHJcblx0XHRcdCAgfVxyXG5cdFx0XHQgIHJldHVybiByZXN1bHQ7XHJcblx0XHRcdH07XHJcblx0XHQgIH0oKSk7XHJcblx0XHR9XHJcblxyXG5cdFx0LyogU2VhcmNoICYgRmlsdGVyIGpRdWVyeSBQbHVnaW4gKi9cclxuXHRcdCQuZm4uc2VhcmNoQW5kRmlsdGVyID0gcGx1Z2luO1xyXG5cclxuXHRcdC8qIGluaXQgKi9cclxuXHRcdCQoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLnNlYXJjaEFuZEZpbHRlcigpO1xyXG5cclxuXHRcdC8qIGV4dGVybmFsIGNvbnRyb2xzICovXHJcblx0XHQkKGRvY3VtZW50KS5vbihcImNsaWNrXCIsIFwiLnNlYXJjaC1maWx0ZXItcmVzZXRcIiwgZnVuY3Rpb24oZSl7XHJcblxyXG5cdFx0XHRlLnByZXZlbnREZWZhdWx0KCk7XHJcblxyXG5cdFx0XHR2YXIgc2VhcmNoRm9ybUlEID0gdHlwZW9mKCQodGhpcykuYXR0cihcImRhdGEtc2VhcmNoLWZvcm0taWRcIikpIT1cInVuZGVmaW5lZFwiID8gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZWFyY2gtZm9ybS1pZFwiKSA6IFwiXCI7XHJcblx0XHRcdHZhciBzdWJtaXRGb3JtID0gdHlwZW9mKCQodGhpcykuYXR0cihcImRhdGEtc2Ytc3VibWl0LWZvcm1cIikpIT1cInVuZGVmaW5lZFwiID8gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1zdWJtaXQtZm9ybVwiKSA6IFwiXCI7XHJcblxyXG5cdFx0XHRzdGF0ZS5nZXRTZWFyY2hGb3JtKHNlYXJjaEZvcm1JRCkucmVzZXQoc3VibWl0Rm9ybSk7XHJcblxyXG5cdFx0XHQvL3ZhciAkbGlua2VkID0gJChcIiNzZWFyY2gtZmlsdGVyLWZvcm0tXCIrc2VhcmNoRm9ybUlEKS5zZWFyY2hGaWx0ZXJGb3JtKHthY3Rpb246IFwicmVzZXRcIn0pO1xyXG5cclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cclxuXHRcdH0pO1xyXG5cclxuXHR9KTtcclxuXHJcblxyXG4vKlxyXG4gKiBqUXVlcnkgRWFzaW5nIHYxLjQuMSAtIGh0dHA6Ly9nc2dkLmNvLnVrL3NhbmRib3gvanF1ZXJ5L2Vhc2luZy9cclxuICogT3BlbiBzb3VyY2UgdW5kZXIgdGhlIEJTRCBMaWNlbnNlLlxyXG4gKiBDb3B5cmlnaHQgwqkgMjAwOCBHZW9yZ2UgTWNHaW5sZXkgU21pdGhcclxuICogQWxsIHJpZ2h0cyByZXNlcnZlZC5cclxuICogaHR0cHM6Ly9yYXcuZ2l0aHViLmNvbS9nZHNtaXRoL2pxdWVyeS5lYXNpbmcvbWFzdGVyL0xJQ0VOU0VcclxuKi9cclxuXHJcbi8qIGdsb2JhbHMgalF1ZXJ5LCBkZWZpbmUsIG1vZHVsZSwgcmVxdWlyZSAqL1xyXG4oZnVuY3Rpb24gKGZhY3RvcnkpIHtcclxuXHRpZiAodHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQpIHtcclxuXHRcdGRlZmluZShbJ2pxdWVyeSddLCBmdW5jdGlvbiAoJCkge1xyXG5cdFx0XHRyZXR1cm4gZmFjdG9yeSgkKTtcclxuXHRcdH0pO1xyXG5cdH0gZWxzZSBpZiAodHlwZW9mIG1vZHVsZSA9PT0gXCJvYmplY3RcIiAmJiB0eXBlb2YgbW9kdWxlLmV4cG9ydHMgPT09IFwib2JqZWN0XCIpIHtcclxuXHRcdG1vZHVsZS5leHBvcnRzID0gZmFjdG9yeSgodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpKTtcclxuXHR9IGVsc2Uge1xyXG5cdFx0ZmFjdG9yeShqUXVlcnkpO1xyXG5cdH1cclxufSkoZnVuY3Rpb24oJCl7XHJcblxyXG5cdC8vIFByZXNlcnZlIHRoZSBvcmlnaW5hbCBqUXVlcnkgXCJzd2luZ1wiIGVhc2luZyBhcyBcImpzd2luZ1wiXHJcblx0aWYgKHR5cGVvZiAkLmVhc2luZyAhPT0gJ3VuZGVmaW5lZCcpIHtcclxuXHRcdCQuZWFzaW5nWydqc3dpbmcnXSA9ICQuZWFzaW5nWydzd2luZyddO1xyXG5cdH1cclxuXHJcblx0dmFyIHBvdyA9IE1hdGgucG93LFxyXG5cdFx0c3FydCA9IE1hdGguc3FydCxcclxuXHRcdHNpbiA9IE1hdGguc2luLFxyXG5cdFx0Y29zID0gTWF0aC5jb3MsXHJcblx0XHRQSSA9IE1hdGguUEksXHJcblx0XHRjMSA9IDEuNzAxNTgsXHJcblx0XHRjMiA9IGMxICogMS41MjUsXHJcblx0XHRjMyA9IGMxICsgMSxcclxuXHRcdGM0ID0gKCAyICogUEkgKSAvIDMsXHJcblx0XHRjNSA9ICggMiAqIFBJICkgLyA0LjU7XHJcblxyXG5cdC8vIHggaXMgdGhlIGZyYWN0aW9uIG9mIGFuaW1hdGlvbiBwcm9ncmVzcywgaW4gdGhlIHJhbmdlIDAuLjFcclxuXHRmdW5jdGlvbiBib3VuY2VPdXQoeCkge1xyXG5cdFx0dmFyIG4xID0gNy41NjI1LFxyXG5cdFx0XHRkMSA9IDIuNzU7XHJcblx0XHRpZiAoIHggPCAxL2QxICkge1xyXG5cdFx0XHRyZXR1cm4gbjEqeCp4O1xyXG5cdFx0fSBlbHNlIGlmICggeCA8IDIvZDEgKSB7XHJcblx0XHRcdHJldHVybiBuMSooeC09KDEuNS9kMSkpKnggKyAuNzU7XHJcblx0XHR9IGVsc2UgaWYgKCB4IDwgMi41L2QxICkge1xyXG5cdFx0XHRyZXR1cm4gbjEqKHgtPSgyLjI1L2QxKSkqeCArIC45Mzc1O1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0cmV0dXJuIG4xKih4LT0oMi42MjUvZDEpKSp4ICsgLjk4NDM3NTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdCQuZXh0ZW5kKCAkLmVhc2luZywge1xyXG5cdFx0ZGVmOiAnZWFzZU91dFF1YWQnLFxyXG5cdFx0c3dpbmc6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAkLmVhc2luZ1skLmVhc2luZy5kZWZdKHgpO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJblF1YWQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ICogeDtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0UXVhZDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSAoIDEgLSB4ICkgKiAoIDEgLSB4ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0UXVhZDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xyXG5cdFx0XHRcdDIgKiB4ICogeCA6XHJcblx0XHRcdFx0MSAtIHBvdyggLTIgKiB4ICsgMiwgMiApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5DdWJpYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggKiB4ICogeDtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0Q3ViaWM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxIC0gcG93KCAxIC0geCwgMyApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dEN1YmljOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0NCAqIHggKiB4ICogeCA6XHJcblx0XHRcdFx0MSAtIHBvdyggLTIgKiB4ICsgMiwgMyApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5RdWFydDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggKiB4ICogeCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dFF1YXJ0OiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gMSAtIHBvdyggMSAtIHgsIDQgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRRdWFydDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xyXG5cdFx0XHRcdDggKiB4ICogeCAqIHggKiB4IDpcclxuXHRcdFx0XHQxIC0gcG93KCAtMiAqIHggKyAyLCA0ICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJblF1aW50OiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCAqIHggKiB4ICogeCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dFF1aW50OiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gMSAtIHBvdyggMSAtIHgsIDUgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRRdWludDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xyXG5cdFx0XHRcdDE2ICogeCAqIHggKiB4ICogeCAqIHggOlxyXG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDUgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluU2luZTogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBjb3MoIHggKiBQSS8yICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dFNpbmU6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiBzaW4oIHggKiBQSS8yICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0U2luZTogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIC0oIGNvcyggUEkgKiB4ICkgLSAxICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbkV4cG86IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHBvdyggMiwgMTAgKiB4IC0gMTAgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0RXhwbzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPT09IDEgPyAxIDogMSAtIHBvdyggMiwgLTEwICogeCApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dEV4cG86IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHggPT09IDEgPyAxIDogeCA8IDAuNSA/XHJcblx0XHRcdFx0cG93KCAyLCAyMCAqIHggLSAxMCApIC8gMiA6XHJcblx0XHRcdFx0KCAyIC0gcG93KCAyLCAtMjAgKiB4ICsgMTAgKSApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5DaXJjOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gMSAtIHNxcnQoIDEgLSBwb3coIHgsIDIgKSApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRDaXJjOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gc3FydCggMSAtIHBvdyggeCAtIDEsIDIgKSApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dENpcmM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQoIDEgLSBzcXJ0KCAxIC0gcG93KCAyICogeCwgMiApICkgKSAvIDIgOlxyXG5cdFx0XHRcdCggc3FydCggMSAtIHBvdyggLTIgKiB4ICsgMiwgMiApICkgKyAxICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbkVsYXN0aWM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHggPT09IDEgPyAxIDpcclxuXHRcdFx0XHQtcG93KCAyLCAxMCAqIHggLSAxMCApICogc2luKCAoIHggKiAxMCAtIDEwLjc1ICkgKiBjNCApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRFbGFzdGljOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6XHJcblx0XHRcdFx0cG93KCAyLCAtMTAgKiB4ICkgKiBzaW4oICggeCAqIDEwIC0gMC43NSApICogYzQgKSArIDE7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0RWxhc3RpYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPT09IDAgPyAwIDogeCA9PT0gMSA/IDEgOiB4IDwgMC41ID9cclxuXHRcdFx0XHQtKCBwb3coIDIsIDIwICogeCAtIDEwICkgKiBzaW4oICggMjAgKiB4IC0gMTEuMTI1ICkgKiBjNSApKSAvIDIgOlxyXG5cdFx0XHRcdHBvdyggMiwgLTIwICogeCArIDEwICkgKiBzaW4oICggMjAgKiB4IC0gMTEuMTI1ICkgKiBjNSApIC8gMiArIDE7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluQmFjazogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIGMzICogeCAqIHggKiB4IC0gYzEgKiB4ICogeDtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0QmFjazogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgKyBjMyAqIHBvdyggeCAtIDEsIDMgKSArIGMxICogcG93KCB4IC0gMSwgMiApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dEJhY2s6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQoIHBvdyggMiAqIHgsIDIgKSAqICggKCBjMiArIDEgKSAqIDIgKiB4IC0gYzIgKSApIC8gMiA6XHJcblx0XHRcdFx0KCBwb3coIDIgKiB4IC0gMiwgMiApICooICggYzIgKyAxICkgKiAoIHggKiAyIC0gMiApICsgYzIgKSArIDIgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluQm91bmNlOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gMSAtIGJvdW5jZU91dCggMSAtIHggKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0Qm91bmNlOiBib3VuY2VPdXQsXHJcblx0XHRlYXNlSW5PdXRCb3VuY2U6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQoIDEgLSBib3VuY2VPdXQoIDEgLSAyICogeCApICkgLyAyIDpcclxuXHRcdFx0XHQoIDEgKyBib3VuY2VPdXQoIDIgKiB4IC0gMSApICkgLyAyO1xyXG5cdFx0fVxyXG5cdH0pO1xyXG5cdHJldHVybiAkO1xyXG59KTtcclxuXHJcbn0oalF1ZXJ5KSk7XHJcblxyXG4vL3NhZmFyaSBiYWNrIGJ1dHRvbiBmaXhcclxualF1ZXJ5KCB3aW5kb3cgKS5vbiggXCJwYWdlc2hvd1wiLCBmdW5jdGlvbihldmVudCkge1xyXG4gICAgaWYgKGV2ZW50Lm9yaWdpbmFsRXZlbnQucGVyc2lzdGVkKSB7XHJcbiAgICAgICAgalF1ZXJ5KFwiLnNlYXJjaGFuZGZpbHRlclwiKS5vZmYoKTtcclxuICAgICAgICBqUXVlcnkoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLnNlYXJjaEFuZEZpbHRlcigpO1xyXG4gICAgfVxyXG59KTtcclxuXHJcbi8qIHdwbnVtYiAtIG5vdWlzbGlkZXIgbnVtYmVyIGZvcm1hdHRpbmcgKi9cclxuIWZ1bmN0aW9uKCl7XCJ1c2Ugc3RyaWN0XCI7ZnVuY3Rpb24gZShlKXtyZXR1cm4gZS5zcGxpdChcIlwiKS5yZXZlcnNlKCkuam9pbihcIlwiKX1mdW5jdGlvbiBuKGUsbil7cmV0dXJuIGUuc3Vic3RyaW5nKDAsbi5sZW5ndGgpPT09bn1mdW5jdGlvbiByKGUsbil7cmV0dXJuIGUuc2xpY2UoLTEqbi5sZW5ndGgpPT09bn1mdW5jdGlvbiB0KGUsbixyKXtpZigoZVtuXXx8ZVtyXSkmJmVbbl09PT1lW3JdKXRocm93IG5ldyBFcnJvcihuKX1mdW5jdGlvbiBpKGUpe3JldHVyblwibnVtYmVyXCI9PXR5cGVvZiBlJiZpc0Zpbml0ZShlKX1mdW5jdGlvbiBvKGUsbil7dmFyIHI9TWF0aC5wb3coMTAsbik7cmV0dXJuKE1hdGgucm91bmQoZSpyKS9yKS50b0ZpeGVkKG4pfWZ1bmN0aW9uIHUobixyLHQsdSxmLGEsYyxzLHAsZCxsLGgpe3ZhciBnLHYsdyxtPWgseD1cIlwiLGI9XCJcIjtyZXR1cm4gYSYmKGg9YShoKSksaShoKT8obiE9PSExJiYwPT09cGFyc2VGbG9hdChoLnRvRml4ZWQobikpJiYoaD0wKSwwPmgmJihnPSEwLGg9TWF0aC5hYnMoaCkpLG4hPT0hMSYmKGg9byhoLG4pKSxoPWgudG9TdHJpbmcoKSwtMSE9PWguaW5kZXhPZihcIi5cIik/KHY9aC5zcGxpdChcIi5cIiksdz12WzBdLHQmJih4PXQrdlsxXSkpOnc9aCxyJiYodz1lKHcpLm1hdGNoKC8uezEsM30vZyksdz1lKHcuam9pbihlKHIpKSkpLGcmJnMmJihiKz1zKSx1JiYoYis9dSksZyYmcCYmKGIrPXApLGIrPXcsYis9eCxmJiYoYis9ZiksZCYmKGI9ZChiLG0pKSxiKTohMX1mdW5jdGlvbiBmKGUsdCxvLHUsZixhLGMscyxwLGQsbCxoKXt2YXIgZyx2PVwiXCI7cmV0dXJuIGwmJihoPWwoaCkpLGgmJlwic3RyaW5nXCI9PXR5cGVvZiBoPyhzJiZuKGgscykmJihoPWgucmVwbGFjZShzLFwiXCIpLGc9ITApLHUmJm4oaCx1KSYmKGg9aC5yZXBsYWNlKHUsXCJcIikpLHAmJm4oaCxwKSYmKGg9aC5yZXBsYWNlKHAsXCJcIiksZz0hMCksZiYmcihoLGYpJiYoaD1oLnNsaWNlKDAsLTEqZi5sZW5ndGgpKSx0JiYoaD1oLnNwbGl0KHQpLmpvaW4oXCJcIikpLG8mJihoPWgucmVwbGFjZShvLFwiLlwiKSksZyYmKHYrPVwiLVwiKSx2Kz1oLHY9di5yZXBsYWNlKC9bXjAtOVxcLlxcLS5dL2csXCJcIiksXCJcIj09PXY/ITE6KHY9TnVtYmVyKHYpLGMmJih2PWModikpLGkodik/djohMSkpOiExfWZ1bmN0aW9uIGEoZSl7dmFyIG4scixpLG89e307Zm9yKG49MDtuPHAubGVuZ3RoO24rPTEpaWYocj1wW25dLGk9ZVtyXSx2b2lkIDA9PT1pKVwibmVnYXRpdmVcIiE9PXJ8fG8ubmVnYXRpdmVCZWZvcmU/XCJtYXJrXCI9PT1yJiZcIi5cIiE9PW8udGhvdXNhbmQ/b1tyXT1cIi5cIjpvW3JdPSExOm9bcl09XCItXCI7ZWxzZSBpZihcImRlY2ltYWxzXCI9PT1yKXtpZighKGk+PTAmJjg+aSkpdGhyb3cgbmV3IEVycm9yKHIpO29bcl09aX1lbHNlIGlmKFwiZW5jb2RlclwiPT09cnx8XCJkZWNvZGVyXCI9PT1yfHxcImVkaXRcIj09PXJ8fFwidW5kb1wiPT09cil7aWYoXCJmdW5jdGlvblwiIT10eXBlb2YgaSl0aHJvdyBuZXcgRXJyb3Iocik7b1tyXT1pfWVsc2V7aWYoXCJzdHJpbmdcIiE9dHlwZW9mIGkpdGhyb3cgbmV3IEVycm9yKHIpO29bcl09aX1yZXR1cm4gdChvLFwibWFya1wiLFwidGhvdXNhbmRcIiksdChvLFwicHJlZml4XCIsXCJuZWdhdGl2ZVwiKSx0KG8sXCJwcmVmaXhcIixcIm5lZ2F0aXZlQmVmb3JlXCIpLG99ZnVuY3Rpb24gYyhlLG4scil7dmFyIHQsaT1bXTtmb3IodD0wO3Q8cC5sZW5ndGg7dCs9MSlpLnB1c2goZVtwW3RdXSk7cmV0dXJuIGkucHVzaChyKSxuLmFwcGx5KFwiXCIsaSl9ZnVuY3Rpb24gcyhlKXtyZXR1cm4gdGhpcyBpbnN0YW5jZW9mIHM/dm9pZChcIm9iamVjdFwiPT10eXBlb2YgZSYmKGU9YShlKSx0aGlzLnRvPWZ1bmN0aW9uKG4pe3JldHVybiBjKGUsdSxuKX0sdGhpcy5mcm9tPWZ1bmN0aW9uKG4pe3JldHVybiBjKGUsZixuKX0pKTpuZXcgcyhlKX12YXIgcD1bXCJkZWNpbWFsc1wiLFwidGhvdXNhbmRcIixcIm1hcmtcIixcInByZWZpeFwiLFwicG9zdGZpeFwiLFwiZW5jb2RlclwiLFwiZGVjb2RlclwiLFwibmVnYXRpdmVCZWZvcmVcIixcIm5lZ2F0aXZlXCIsXCJlZGl0XCIsXCJ1bmRvXCJdO3dpbmRvdy53TnVtYj1zfSgpO1xyXG5cclxuIl19
},{"./includes/plugin":3,"./includes/state":5}],2:[function(require,module,exports){
/*! nouislider - 11.1.0 - 2018-04-02 11:18:13 */

(function (factory) {

    if ( typeof define === 'function' && define.amd ) {

        // AMD. Register as an anonymous module.
        define([], factory);

    } else if ( typeof exports === 'object' ) {

        // Node/CommonJS
        module.exports = factory();

    } else {

        // Browser globals
        window.noUiSlider = factory();
    }

}(function( ){

	'use strict';

	var VERSION = '11.1.0';


	function isValidFormatter ( entry ) {
		return typeof entry === 'object' && typeof entry.to === 'function' && typeof entry.from === 'function';
	}

	function removeElement ( el ) {
		el.parentElement.removeChild(el);
	}

	function isSet ( value ) {
		return value !== null && value !== undefined;
	}

	// Bindable version
	function preventDefault ( e ) {
		e.preventDefault();
	}

	// Removes duplicates from an array.
	function unique ( array ) {
		return array.filter(function(a){
			return !this[a] ? this[a] = true : false;
		}, {});
	}

	// Round a value to the closest 'to'.
	function closest ( value, to ) {
		return Math.round(value / to) * to;
	}

	// Current position of an element relative to the document.
	function offset ( elem, orientation ) {

		var rect = elem.getBoundingClientRect();
		var doc = elem.ownerDocument;
		var docElem = doc.documentElement;
		var pageOffset = getPageOffset(doc);

		// getBoundingClientRect contains left scroll in Chrome on Android.
		// I haven't found a feature detection that proves this. Worst case
		// scenario on mis-match: the 'tap' feature on horizontal sliders breaks.
		if ( /webkit.*Chrome.*Mobile/i.test(navigator.userAgent) ) {
			pageOffset.x = 0;
		}

		return orientation ? (rect.top + pageOffset.y - docElem.clientTop) : (rect.left + pageOffset.x - docElem.clientLeft);
	}

	// Checks whether a value is numerical.
	function isNumeric ( a ) {
		return typeof a === 'number' && !isNaN( a ) && isFinite( a );
	}

	// Sets a class and removes it after [duration] ms.
	function addClassFor ( element, className, duration ) {
		if (duration > 0) {
		addClass(element, className);
			setTimeout(function(){
				removeClass(element, className);
			}, duration);
		}
	}

	// Limits a value to 0 - 100
	function limit ( a ) {
		return Math.max(Math.min(a, 100), 0);
	}

	// Wraps a variable as an array, if it isn't one yet.
	// Note that an input array is returned by reference!
	function asArray ( a ) {
		return Array.isArray(a) ? a : [a];
	}

	// Counts decimals
	function countDecimals ( numStr ) {
		numStr = String(numStr);
		var pieces = numStr.split(".");
		return pieces.length > 1 ? pieces[1].length : 0;
	}

	// http://youmightnotneedjquery.com/#add_class
	function addClass ( el, className ) {
		if ( el.classList ) {
			el.classList.add(className);
		} else {
			el.className += ' ' + className;
		}
	}

	// http://youmightnotneedjquery.com/#remove_class
	function removeClass ( el, className ) {
		if ( el.classList ) {
			el.classList.remove(className);
		} else {
			el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
		}
	}

	// https://plainjs.com/javascript/attributes/adding-removing-and-testing-for-classes-9/
	function hasClass ( el, className ) {
		return el.classList ? el.classList.contains(className) : new RegExp('\\b' + className + '\\b').test(el.className);
	}

	// https://developer.mozilla.org/en-US/docs/Web/API/Window/scrollY#Notes
	function getPageOffset ( doc ) {

		var supportPageOffset = window.pageXOffset !== undefined;
		var isCSS1Compat = ((doc.compatMode || "") === "CSS1Compat");
		var x = supportPageOffset ? window.pageXOffset : isCSS1Compat ? doc.documentElement.scrollLeft : doc.body.scrollLeft;
		var y = supportPageOffset ? window.pageYOffset : isCSS1Compat ? doc.documentElement.scrollTop : doc.body.scrollTop;

		return {
			x: x,
			y: y
		};
	}

	// we provide a function to compute constants instead
	// of accessing window.* as soon as the module needs it
	// so that we do not compute anything if not needed
	function getActions ( ) {

		// Determine the events to bind. IE11 implements pointerEvents without
		// a prefix, which breaks compatibility with the IE10 implementation.
		return window.navigator.pointerEnabled ? {
			start: 'pointerdown',
			move: 'pointermove',
			end: 'pointerup'
		} : window.navigator.msPointerEnabled ? {
			start: 'MSPointerDown',
			move: 'MSPointerMove',
			end: 'MSPointerUp'
		} : {
			start: 'mousedown touchstart',
			move: 'mousemove touchmove',
			end: 'mouseup touchend'
		};
	}

	// https://github.com/WICG/EventListenerOptions/blob/gh-pages/explainer.md
	// Issue #785
	function getSupportsPassive ( ) {

		var supportsPassive = false;

		try {

			var opts = Object.defineProperty({}, 'passive', {
				get: function() {
					supportsPassive = true;
				}
			});

			window.addEventListener('test', null, opts);

		} catch (e) {}

		return supportsPassive;
	}

	function getSupportsTouchActionNone ( ) {
		return window.CSS && CSS.supports && CSS.supports('touch-action', 'none');
	}


// Value calculation

	// Determine the size of a sub-range in relation to a full range.
	function subRangeRatio ( pa, pb ) {
		return (100 / (pb - pa));
	}

	// (percentage) How many percent is this value of this range?
	function fromPercentage ( range, value ) {
		return (value * 100) / ( range[1] - range[0] );
	}

	// (percentage) Where is this value on this range?
	function toPercentage ( range, value ) {
		return fromPercentage( range, range[0] < 0 ?
			value + Math.abs(range[0]) :
				value - range[0] );
	}

	// (value) How much is this percentage on this range?
	function isPercentage ( range, value ) {
		return ((value * ( range[1] - range[0] )) / 100) + range[0];
	}


// Range conversion

	function getJ ( value, arr ) {

		var j = 1;

		while ( value >= arr[j] ){
			j += 1;
		}

		return j;
	}

	// (percentage) Input a value, find where, on a scale of 0-100, it applies.
	function toStepping ( xVal, xPct, value ) {

		if ( value >= xVal.slice(-1)[0] ){
			return 100;
		}

		var j = getJ( value, xVal );
		var va = xVal[j-1];
		var vb = xVal[j];
		var pa = xPct[j-1];
		var pb = xPct[j];

		return pa + (toPercentage([va, vb], value) / subRangeRatio (pa, pb));
	}

	// (value) Input a percentage, find where it is on the specified range.
	function fromStepping ( xVal, xPct, value ) {

		// There is no range group that fits 100
		if ( value >= 100 ){
			return xVal.slice(-1)[0];
		}

		var j = getJ( value, xPct );
		var va = xVal[j-1];
		var vb = xVal[j];
		var pa = xPct[j-1];
		var pb = xPct[j];

		return isPercentage([va, vb], (value - pa) * subRangeRatio (pa, pb));
	}

	// (percentage) Get the step that applies at a certain value.
	function getStep ( xPct, xSteps, snap, value ) {

		if ( value === 100 ) {
			return value;
		}

		var j = getJ( value, xPct );
		var a = xPct[j-1];
		var b = xPct[j];

		// If 'snap' is set, steps are used as fixed points on the slider.
		if ( snap ) {

			// Find the closest position, a or b.
			if ((value - a) > ((b-a)/2)){
				return b;
			}

			return a;
		}

		if ( !xSteps[j-1] ){
			return value;
		}

		return xPct[j-1] + closest(
			value - xPct[j-1],
			xSteps[j-1]
		);
	}


// Entry parsing

	function handleEntryPoint ( index, value, that ) {

		var percentage;

		// Wrap numerical input in an array.
		if ( typeof value === "number" ) {
			value = [value];
		}

		// Reject any invalid input, by testing whether value is an array.
		if ( !Array.isArray(value) ){
			throw new Error("noUiSlider (" + VERSION + "): 'range' contains invalid value.");
		}

		// Covert min/max syntax to 0 and 100.
		if ( index === 'min' ) {
			percentage = 0;
		} else if ( index === 'max' ) {
			percentage = 100;
		} else {
			percentage = parseFloat( index );
		}

		// Check for correct input.
		if ( !isNumeric( percentage ) || !isNumeric( value[0] ) ) {
			throw new Error("noUiSlider (" + VERSION + "): 'range' value isn't numeric.");
		}

		// Store values.
		that.xPct.push( percentage );
		that.xVal.push( value[0] );

		// NaN will evaluate to false too, but to keep
		// logging clear, set step explicitly. Make sure
		// not to override the 'step' setting with false.
		if ( !percentage ) {
			if ( !isNaN( value[1] ) ) {
				that.xSteps[0] = value[1];
			}
		} else {
			that.xSteps.push( isNaN(value[1]) ? false : value[1] );
		}

		that.xHighestCompleteStep.push(0);
	}

	function handleStepPoint ( i, n, that ) {

		// Ignore 'false' stepping.
		if ( !n ) {
			return true;
		}

		// Factor to range ratio
		that.xSteps[i] = fromPercentage([that.xVal[i], that.xVal[i+1]], n) / subRangeRatio(that.xPct[i], that.xPct[i+1]);

		var totalSteps = (that.xVal[i+1] - that.xVal[i]) / that.xNumSteps[i];
		var highestStep = Math.ceil(Number(totalSteps.toFixed(3)) - 1);
		var step = that.xVal[i] + (that.xNumSteps[i] * highestStep);

		that.xHighestCompleteStep[i] = step;
	}


// Interface

	function Spectrum ( entry, snap, singleStep ) {

		this.xPct = [];
		this.xVal = [];
		this.xSteps = [ singleStep || false ];
		this.xNumSteps = [ false ];
		this.xHighestCompleteStep = [];

		this.snap = snap;

		var index;
		var ordered = []; // [0, 'min'], [1, '50%'], [2, 'max']

		// Map the object keys to an array.
		for ( index in entry ) {
			if ( entry.hasOwnProperty(index) ) {
				ordered.push([entry[index], index]);
			}
		}

		// Sort all entries by value (numeric sort).
		if ( ordered.length && typeof ordered[0][0] === "object" ) {
			ordered.sort(function(a, b) { return a[0][0] - b[0][0]; });
		} else {
			ordered.sort(function(a, b) { return a[0] - b[0]; });
		}


		// Convert all entries to subranges.
		for ( index = 0; index < ordered.length; index++ ) {
			handleEntryPoint(ordered[index][1], ordered[index][0], this);
		}

		// Store the actual step values.
		// xSteps is sorted in the same order as xPct and xVal.
		this.xNumSteps = this.xSteps.slice(0);

		// Convert all numeric steps to the percentage of the subrange they represent.
		for ( index = 0; index < this.xNumSteps.length; index++ ) {
			handleStepPoint(index, this.xNumSteps[index], this);
		}
	}

	Spectrum.prototype.getMargin = function ( value ) {

		var step = this.xNumSteps[0];

		if ( step && ((value / step) % 1) !== 0 ) {
			throw new Error("noUiSlider (" + VERSION + "): 'limit', 'margin' and 'padding' must be divisible by step.");
		}

		return this.xPct.length === 2 ? fromPercentage(this.xVal, value) : false;
	};

	Spectrum.prototype.toStepping = function ( value ) {

		value = toStepping( this.xVal, this.xPct, value );

		return value;
	};

	Spectrum.prototype.fromStepping = function ( value ) {

		return fromStepping( this.xVal, this.xPct, value );
	};

	Spectrum.prototype.getStep = function ( value ) {

		value = getStep(this.xPct, this.xSteps, this.snap, value );

		return value;
	};

	Spectrum.prototype.getNearbySteps = function ( value ) {

		var j = getJ(value, this.xPct);

		return {
			stepBefore: { startValue: this.xVal[j-2], step: this.xNumSteps[j-2], highestStep: this.xHighestCompleteStep[j-2] },
			thisStep: { startValue: this.xVal[j-1], step: this.xNumSteps[j-1], highestStep: this.xHighestCompleteStep[j-1] },
			stepAfter: { startValue: this.xVal[j-0], step: this.xNumSteps[j-0], highestStep: this.xHighestCompleteStep[j-0] }
		};
	};

	Spectrum.prototype.countStepDecimals = function () {
		var stepDecimals = this.xNumSteps.map(countDecimals);
		return Math.max.apply(null, stepDecimals);
	};

	// Outside testing
	Spectrum.prototype.convert = function ( value ) {
		return this.getStep(this.toStepping(value));
	};

/*	Every input option is tested and parsed. This'll prevent
	endless validation in internal methods. These tests are
	structured with an item for every option available. An
	option can be marked as required by setting the 'r' flag.
	The testing function is provided with three arguments:
		- The provided value for the option;
		- A reference to the options object;
		- The name for the option;

	The testing function returns false when an error is detected,
	or true when everything is OK. It can also modify the option
	object, to make sure all values can be correctly looped elsewhere. */

	var defaultFormatter = { 'to': function( value ){
		return value !== undefined && value.toFixed(2);
	}, 'from': Number };

	function validateFormat ( entry ) {

		// Any object with a to and from method is supported.
		if ( isValidFormatter(entry) ) {
			return true;
		}

		throw new Error("noUiSlider (" + VERSION + "): 'format' requires 'to' and 'from' methods.");
	}

	function testStep ( parsed, entry ) {

		if ( !isNumeric( entry ) ) {
			throw new Error("noUiSlider (" + VERSION + "): 'step' is not numeric.");
		}

		// The step option can still be used to set stepping
		// for linear sliders. Overwritten if set in 'range'.
		parsed.singleStep = entry;
	}

	function testRange ( parsed, entry ) {

		// Filter incorrect input.
		if ( typeof entry !== 'object' || Array.isArray(entry) ) {
			throw new Error("noUiSlider (" + VERSION + "): 'range' is not an object.");
		}

		// Catch missing start or end.
		if ( entry.min === undefined || entry.max === undefined ) {
			throw new Error("noUiSlider (" + VERSION + "): Missing 'min' or 'max' in 'range'.");
		}

		// Catch equal start or end.
		if ( entry.min === entry.max ) {
			throw new Error("noUiSlider (" + VERSION + "): 'range' 'min' and 'max' cannot be equal.");
		}

		parsed.spectrum = new Spectrum(entry, parsed.snap, parsed.singleStep);
	}

	function testStart ( parsed, entry ) {

		entry = asArray(entry);

		// Validate input. Values aren't tested, as the public .val method
		// will always provide a valid location.
		if ( !Array.isArray( entry ) || !entry.length ) {
			throw new Error("noUiSlider (" + VERSION + "): 'start' option is incorrect.");
		}

		// Store the number of handles.
		parsed.handles = entry.length;

		// When the slider is initialized, the .val method will
		// be called with the start options.
		parsed.start = entry;
	}

	function testSnap ( parsed, entry ) {

		// Enforce 100% stepping within subranges.
		parsed.snap = entry;

		if ( typeof entry !== 'boolean' ){
			throw new Error("noUiSlider (" + VERSION + "): 'snap' option must be a boolean.");
		}
	}

	function testAnimate ( parsed, entry ) {

		// Enforce 100% stepping within subranges.
		parsed.animate = entry;

		if ( typeof entry !== 'boolean' ){
			throw new Error("noUiSlider (" + VERSION + "): 'animate' option must be a boolean.");
		}
	}

	function testAnimationDuration ( parsed, entry ) {

		parsed.animationDuration = entry;

		if ( typeof entry !== 'number' ){
			throw new Error("noUiSlider (" + VERSION + "): 'animationDuration' option must be a number.");
		}
	}

	function testConnect ( parsed, entry ) {

		var connect = [false];
		var i;

		// Map legacy options
		if ( entry === 'lower' ) {
			entry = [true, false];
		}

		else if ( entry === 'upper' ) {
			entry = [false, true];
		}

		// Handle boolean options
		if ( entry === true || entry === false ) {

			for ( i = 1; i < parsed.handles; i++ ) {
				connect.push(entry);
			}

			connect.push(false);
		}

		// Reject invalid input
		else if ( !Array.isArray( entry ) || !entry.length || entry.length !== parsed.handles + 1 ) {
			throw new Error("noUiSlider (" + VERSION + "): 'connect' option doesn't match handle count.");
		}

		else {
			connect = entry;
		}

		parsed.connect = connect;
	}

	function testOrientation ( parsed, entry ) {

		// Set orientation to an a numerical value for easy
		// array selection.
		switch ( entry ){
			case 'horizontal':
				parsed.ort = 0;
				break;
			case 'vertical':
				parsed.ort = 1;
				break;
			default:
				throw new Error("noUiSlider (" + VERSION + "): 'orientation' option is invalid.");
		}
	}

	function testMargin ( parsed, entry ) {

		if ( !isNumeric(entry) ){
			throw new Error("noUiSlider (" + VERSION + "): 'margin' option must be numeric.");
		}

		// Issue #582
		if ( entry === 0 ) {
			return;
		}

		parsed.margin = parsed.spectrum.getMargin(entry);

		if ( !parsed.margin ) {
			throw new Error("noUiSlider (" + VERSION + "): 'margin' option is only supported on linear sliders.");
		}
	}

	function testLimit ( parsed, entry ) {

		if ( !isNumeric(entry) ){
			throw new Error("noUiSlider (" + VERSION + "): 'limit' option must be numeric.");
		}

		parsed.limit = parsed.spectrum.getMargin(entry);

		if ( !parsed.limit || parsed.handles < 2 ) {
			throw new Error("noUiSlider (" + VERSION + "): 'limit' option is only supported on linear sliders with 2 or more handles.");
		}
	}

	function testPadding ( parsed, entry ) {

		if ( !isNumeric(entry) && !Array.isArray(entry) ){
			throw new Error("noUiSlider (" + VERSION + "): 'padding' option must be numeric or array of exactly 2 numbers.");
		}

		if ( Array.isArray(entry) && !(entry.length === 2 || isNumeric(entry[0]) || isNumeric(entry[1])) ) {
			throw new Error("noUiSlider (" + VERSION + "): 'padding' option must be numeric or array of exactly 2 numbers.");
		}

		if ( entry === 0 ) {
			return;
		}

		if ( !Array.isArray(entry) ) {
			entry = [entry, entry];
		}

		// 'getMargin' returns false for invalid values.
		parsed.padding = [parsed.spectrum.getMargin(entry[0]), parsed.spectrum.getMargin(entry[1])];

		if ( parsed.padding[0] === false || parsed.padding[1] === false ) {
			throw new Error("noUiSlider (" + VERSION + "): 'padding' option is only supported on linear sliders.");
		}

		if ( parsed.padding[0] < 0 || parsed.padding[1] < 0 ) {
			throw new Error("noUiSlider (" + VERSION + "): 'padding' option must be a positive number(s).");
		}

		if ( parsed.padding[0] + parsed.padding[1] >= 100 ) {
			throw new Error("noUiSlider (" + VERSION + "): 'padding' option must not exceed 100% of the range.");
		}
	}

	function testDirection ( parsed, entry ) {

		// Set direction as a numerical value for easy parsing.
		// Invert connection for RTL sliders, so that the proper
		// handles get the connect/background classes.
		switch ( entry ) {
			case 'ltr':
				parsed.dir = 0;
				break;
			case 'rtl':
				parsed.dir = 1;
				break;
			default:
				throw new Error("noUiSlider (" + VERSION + "): 'direction' option was not recognized.");
		}
	}

	function testBehaviour ( parsed, entry ) {

		// Make sure the input is a string.
		if ( typeof entry !== 'string' ) {
			throw new Error("noUiSlider (" + VERSION + "): 'behaviour' must be a string containing options.");
		}

		// Check if the string contains any keywords.
		// None are required.
		var tap = entry.indexOf('tap') >= 0;
		var drag = entry.indexOf('drag') >= 0;
		var fixed = entry.indexOf('fixed') >= 0;
		var snap = entry.indexOf('snap') >= 0;
		var hover = entry.indexOf('hover') >= 0;

		if ( fixed ) {

			if ( parsed.handles !== 2 ) {
				throw new Error("noUiSlider (" + VERSION + "): 'fixed' behaviour must be used with 2 handles");
			}

			// Use margin to enforce fixed state
			testMargin(parsed, parsed.start[1] - parsed.start[0]);
		}

		parsed.events = {
			tap: tap || snap,
			drag: drag,
			fixed: fixed,
			snap: snap,
			hover: hover
		};
	}

	function testTooltips ( parsed, entry ) {

		if ( entry === false ) {
			return;
		}

		else if ( entry === true ) {

			parsed.tooltips = [];

			for ( var i = 0; i < parsed.handles; i++ ) {
				parsed.tooltips.push(true);
			}
		}

		else {

			parsed.tooltips = asArray(entry);

			if ( parsed.tooltips.length !== parsed.handles ) {
				throw new Error("noUiSlider (" + VERSION + "): must pass a formatter for all handles.");
			}

			parsed.tooltips.forEach(function(formatter){
				if ( typeof formatter !== 'boolean' && (typeof formatter !== 'object' || typeof formatter.to !== 'function') ) {
					throw new Error("noUiSlider (" + VERSION + "): 'tooltips' must be passed a formatter or 'false'.");
				}
			});
		}
	}

	function testAriaFormat ( parsed, entry ) {
		parsed.ariaFormat = entry;
		validateFormat(entry);
	}

	function testFormat ( parsed, entry ) {
		parsed.format = entry;
		validateFormat(entry);
	}

	function testCssPrefix ( parsed, entry ) {

		if ( typeof entry !== 'string' && entry !== false ) {
			throw new Error("noUiSlider (" + VERSION + "): 'cssPrefix' must be a string or `false`.");
		}

		parsed.cssPrefix = entry;
	}

	function testCssClasses ( parsed, entry ) {

		if ( typeof entry !== 'object' ) {
			throw new Error("noUiSlider (" + VERSION + "): 'cssClasses' must be an object.");
		}

		if ( typeof parsed.cssPrefix === 'string' ) {
			parsed.cssClasses = {};

			for ( var key in entry ) {
				if ( !entry.hasOwnProperty(key) ) { continue; }

				parsed.cssClasses[key] = parsed.cssPrefix + entry[key];
			}
		} else {
			parsed.cssClasses = entry;
		}
	}

	// Test all developer settings and parse to assumption-safe values.
	function testOptions ( options ) {

		// To prove a fix for #537, freeze options here.
		// If the object is modified, an error will be thrown.
		// Object.freeze(options);

		var parsed = {
			margin: 0,
			limit: 0,
			padding: 0,
			animate: true,
			animationDuration: 300,
			ariaFormat: defaultFormatter,
			format: defaultFormatter
		};

		// Tests are executed in the order they are presented here.
		var tests = {
			'step': { r: false, t: testStep },
			'start': { r: true, t: testStart },
			'connect': { r: true, t: testConnect },
			'direction': { r: true, t: testDirection },
			'snap': { r: false, t: testSnap },
			'animate': { r: false, t: testAnimate },
			'animationDuration': { r: false, t: testAnimationDuration },
			'range': { r: true, t: testRange },
			'orientation': { r: false, t: testOrientation },
			'margin': { r: false, t: testMargin },
			'limit': { r: false, t: testLimit },
			'padding': { r: false, t: testPadding },
			'behaviour': { r: true, t: testBehaviour },
			'ariaFormat': { r: false, t: testAriaFormat },
			'format': { r: false, t: testFormat },
			'tooltips': { r: false, t: testTooltips },
			'cssPrefix': { r: true, t: testCssPrefix },
			'cssClasses': { r: true, t: testCssClasses }
		};

		var defaults = {
			'connect': false,
			'direction': 'ltr',
			'behaviour': 'tap',
			'orientation': 'horizontal',
			'cssPrefix' : 'noUi-',
			'cssClasses': {
				target: 'target',
				base: 'base',
				origin: 'origin',
				handle: 'handle',
				handleLower: 'handle-lower',
				handleUpper: 'handle-upper',
				horizontal: 'horizontal',
				vertical: 'vertical',
				background: 'background',
				connect: 'connect',
				connects: 'connects',
				ltr: 'ltr',
				rtl: 'rtl',
				draggable: 'draggable',
				drag: 'state-drag',
				tap: 'state-tap',
				active: 'active',
				tooltip: 'tooltip',
				pips: 'pips',
				pipsHorizontal: 'pips-horizontal',
				pipsVertical: 'pips-vertical',
				marker: 'marker',
				markerHorizontal: 'marker-horizontal',
				markerVertical: 'marker-vertical',
				markerNormal: 'marker-normal',
				markerLarge: 'marker-large',
				markerSub: 'marker-sub',
				value: 'value',
				valueHorizontal: 'value-horizontal',
				valueVertical: 'value-vertical',
				valueNormal: 'value-normal',
				valueLarge: 'value-large',
				valueSub: 'value-sub'
			}
		};

		// AriaFormat defaults to regular format, if any.
		if ( options.format && !options.ariaFormat ) {
			options.ariaFormat = options.format;
		}

		// Run all options through a testing mechanism to ensure correct
		// input. It should be noted that options might get modified to
		// be handled properly. E.g. wrapping integers in arrays.
		Object.keys(tests).forEach(function( name ){

			// If the option isn't set, but it is required, throw an error.
			if ( !isSet(options[name]) && defaults[name] === undefined ) {

				if ( tests[name].r ) {
					throw new Error("noUiSlider (" + VERSION + "): '" + name + "' is required.");
				}

				return true;
			}

			tests[name].t( parsed, !isSet(options[name]) ? defaults[name] : options[name] );
		});

		// Forward pips options
		parsed.pips = options.pips;

		// All recent browsers accept unprefixed transform.
		// We need -ms- for IE9 and -webkit- for older Android;
		// Assume use of -webkit- if unprefixed and -ms- are not supported.
		// https://caniuse.com/#feat=transforms2d
		var d = document.createElement("div");
		var msPrefix = d.style.msTransform !== undefined;
		var noPrefix = d.style.transform !== undefined;

		parsed.transformRule = noPrefix ? 'transform' : (msPrefix ? 'msTransform' : 'webkitTransform');

		// Pips don't move, so we can place them using left/top.
		var styles = [['left', 'top'], ['right', 'bottom']];

		parsed.style = styles[parsed.dir][parsed.ort];

		return parsed;
	}


function scope ( target, options, originalOptions ){

	var actions = getActions();
	var supportsTouchActionNone = getSupportsTouchActionNone();
	var supportsPassive = supportsTouchActionNone && getSupportsPassive();

	// All variables local to 'scope' are prefixed with 'scope_'
	var scope_Target = target;
	var scope_Locations = [];
	var scope_Base;
	var scope_Handles;
	var scope_HandleNumbers = [];
	var scope_ActiveHandlesCount = 0;
	var scope_Connects;
	var scope_Spectrum = options.spectrum;
	var scope_Values = [];
	var scope_Events = {};
	var scope_Self;
	var scope_Pips;
	var scope_Document = target.ownerDocument;
	var scope_DocumentElement = scope_Document.documentElement;
	var scope_Body = scope_Document.body;


	// For horizontal sliders in standard ltr documents,
	// make .noUi-origin overflow to the left so the document doesn't scroll.
	var scope_DirOffset = (scope_Document.dir === 'rtl') || (options.ort === 1) ? 0 : 100;

/*! In this file: Construction of DOM elements; */

	// Creates a node, adds it to target, returns the new node.
	function addNodeTo ( addTarget, className ) {

		var div = scope_Document.createElement('div');

		if ( className ) {
			addClass(div, className);
		}

		addTarget.appendChild(div);

		return div;
	}

	// Append a origin to the base
	function addOrigin ( base, handleNumber ) {

		var origin = addNodeTo(base, options.cssClasses.origin);
		var handle = addNodeTo(origin, options.cssClasses.handle);

		handle.setAttribute('data-handle', handleNumber);

		// https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/tabindex
		// 0 = focusable and reachable
		handle.setAttribute('tabindex', '0');
		handle.setAttribute('role', 'slider');
		handle.setAttribute('aria-orientation', options.ort ? 'vertical' : 'horizontal');

		if ( handleNumber === 0 ) {
			addClass(handle, options.cssClasses.handleLower);
		}

		else if ( handleNumber === options.handles - 1 ) {
			addClass(handle, options.cssClasses.handleUpper);
		}

		return origin;
	}

	// Insert nodes for connect elements
	function addConnect ( base, add ) {

		if ( !add ) {
			return false;
		}

		return addNodeTo(base, options.cssClasses.connect);
	}

	// Add handles to the slider base.
	function addElements ( connectOptions, base ) {

		var connectBase = addNodeTo(base, options.cssClasses.connects);

		scope_Handles = [];
		scope_Connects = [];

		scope_Connects.push(addConnect(connectBase, connectOptions[0]));

		// [::::O====O====O====]
		// connectOptions = [0, 1, 1, 1]

		for ( var i = 0; i < options.handles; i++ ) {
			// Keep a list of all added handles.
			scope_Handles.push(addOrigin(base, i));
			scope_HandleNumbers[i] = i;
			scope_Connects.push(addConnect(connectBase, connectOptions[i + 1]));
		}
	}

	// Initialize a single slider.
	function addSlider ( addTarget ) {

		// Apply classes and data to the target.
		addClass(addTarget, options.cssClasses.target);

		if ( options.dir === 0 ) {
			addClass(addTarget, options.cssClasses.ltr);
		} else {
			addClass(addTarget, options.cssClasses.rtl);
		}

		if ( options.ort === 0 ) {
			addClass(addTarget, options.cssClasses.horizontal);
		} else {
			addClass(addTarget, options.cssClasses.vertical);
		}

		scope_Base = addNodeTo(addTarget, options.cssClasses.base);
	}


	function addTooltip ( handle, handleNumber ) {

		if ( !options.tooltips[handleNumber] ) {
			return false;
		}

		return addNodeTo(handle.firstChild, options.cssClasses.tooltip);
	}

	// The tooltips option is a shorthand for using the 'update' event.
	function tooltips ( ) {

		// Tooltips are added with options.tooltips in original order.
		var tips = scope_Handles.map(addTooltip);

		bindEvent('update', function(values, handleNumber, unencoded) {

			if ( !tips[handleNumber] ) {
				return;
			}

			var formattedValue = values[handleNumber];

			if ( options.tooltips[handleNumber] !== true ) {
				formattedValue = options.tooltips[handleNumber].to(unencoded[handleNumber]);
			}

			tips[handleNumber].innerHTML = formattedValue;
		});
	}


	function aria ( ) {

		bindEvent('update', function ( values, handleNumber, unencoded, tap, positions ) {

			// Update Aria Values for all handles, as a change in one changes min and max values for the next.
			scope_HandleNumbers.forEach(function( index ){

				var handle = scope_Handles[index];

				var min = checkHandlePosition(scope_Locations, index, 0, true, true, true);
				var max = checkHandlePosition(scope_Locations, index, 100, true, true, true);

				var now = positions[index];
				var text = options.ariaFormat.to(unencoded[index]);

				handle.children[0].setAttribute('aria-valuemin', min.toFixed(1));
				handle.children[0].setAttribute('aria-valuemax', max.toFixed(1));
				handle.children[0].setAttribute('aria-valuenow', now.toFixed(1));
				handle.children[0].setAttribute('aria-valuetext', text);
			});
		});
	}


	function getGroup ( mode, values, stepped ) {

		// Use the range.
		if ( mode === 'range' || mode === 'steps' ) {
			return scope_Spectrum.xVal;
		}

		if ( mode === 'count' ) {

			if ( values < 2 ) {
				throw new Error("noUiSlider (" + VERSION + "): 'values' (>= 2) required for mode 'count'.");
			}

			// Divide 0 - 100 in 'count' parts.
			var interval = values - 1;
			var spread = ( 100 / interval );

			values = [];

			// List these parts and have them handled as 'positions'.
			while ( interval-- ) {
				values[ interval ] = ( interval * spread );
			}

			values.push(100);

			mode = 'positions';
		}

		if ( mode === 'positions' ) {

			// Map all percentages to on-range values.
			return values.map(function( value ){
				return scope_Spectrum.fromStepping( stepped ? scope_Spectrum.getStep( value ) : value );
			});
		}

		if ( mode === 'values' ) {

			// If the value must be stepped, it needs to be converted to a percentage first.
			if ( stepped ) {

				return values.map(function( value ){

					// Convert to percentage, apply step, return to value.
					return scope_Spectrum.fromStepping( scope_Spectrum.getStep( scope_Spectrum.toStepping( value ) ) );
				});

			}

			// Otherwise, we can simply use the values.
			return values;
		}
	}

	function generateSpread ( density, mode, group ) {

		function safeIncrement(value, increment) {
			// Avoid floating point variance by dropping the smallest decimal places.
			return (value + increment).toFixed(7) / 1;
		}

		var indexes = {};
		var firstInRange = scope_Spectrum.xVal[0];
		var lastInRange = scope_Spectrum.xVal[scope_Spectrum.xVal.length-1];
		var ignoreFirst = false;
		var ignoreLast = false;
		var prevPct = 0;

		// Create a copy of the group, sort it and filter away all duplicates.
		group = unique(group.slice().sort(function(a, b){ return a - b; }));

		// Make sure the range starts with the first element.
		if ( group[0] !== firstInRange ) {
			group.unshift(firstInRange);
			ignoreFirst = true;
		}

		// Likewise for the last one.
		if ( group[group.length - 1] !== lastInRange ) {
			group.push(lastInRange);
			ignoreLast = true;
		}

		group.forEach(function ( current, index ) {

			// Get the current step and the lower + upper positions.
			var step;
			var i;
			var q;
			var low = current;
			var high = group[index+1];
			var newPct;
			var pctDifference;
			var pctPos;
			var type;
			var steps;
			var realSteps;
			var stepsize;

			// When using 'steps' mode, use the provided steps.
			// Otherwise, we'll step on to the next subrange.
			if ( mode === 'steps' ) {
				step = scope_Spectrum.xNumSteps[ index ];
			}

			// Default to a 'full' step.
			if ( !step ) {
				step = high-low;
			}

			// Low can be 0, so test for false. If high is undefined,
			// we are at the last subrange. Index 0 is already handled.
			if ( low === false || high === undefined ) {
				return;
			}

			// Make sure step isn't 0, which would cause an infinite loop (#654)
			step = Math.max(step, 0.0000001);

			// Find all steps in the subrange.
			for ( i = low; i <= high; i = safeIncrement(i, step) ) {

				// Get the percentage value for the current step,
				// calculate the size for the subrange.
				newPct = scope_Spectrum.toStepping( i );
				pctDifference = newPct - prevPct;

				steps = pctDifference / density;
				realSteps = Math.round(steps);

				// This ratio represents the amount of percentage-space a point indicates.
				// For a density 1 the points/percentage = 1. For density 2, that percentage needs to be re-devided.
				// Round the percentage offset to an even number, then divide by two
				// to spread the offset on both sides of the range.
				stepsize = pctDifference/realSteps;

				// Divide all points evenly, adding the correct number to this subrange.
				// Run up to <= so that 100% gets a point, event if ignoreLast is set.
				for ( q = 1; q <= realSteps; q += 1 ) {

					// The ratio between the rounded value and the actual size might be ~1% off.
					// Correct the percentage offset by the number of points
					// per subrange. density = 1 will result in 100 points on the
					// full range, 2 for 50, 4 for 25, etc.
					pctPos = prevPct + ( q * stepsize );
					indexes[pctPos.toFixed(5)] = ['x', 0];
				}

				// Determine the point type.
				type = (group.indexOf(i) > -1) ? 1 : ( mode === 'steps' ? 2 : 0 );

				// Enforce the 'ignoreFirst' option by overwriting the type for 0.
				if ( !index && ignoreFirst ) {
					type = 0;
				}

				if ( !(i === high && ignoreLast)) {
					// Mark the 'type' of this point. 0 = plain, 1 = real value, 2 = step value.
					indexes[newPct.toFixed(5)] = [i, type];
				}

				// Update the percentage count.
				prevPct = newPct;
			}
		});

		return indexes;
	}

	function addMarking ( spread, filterFunc, formatter ) {

		var element = scope_Document.createElement('div');

		var valueSizeClasses = [
			options.cssClasses.valueNormal,
			options.cssClasses.valueLarge,
			options.cssClasses.valueSub
		];
		var markerSizeClasses = [
			options.cssClasses.markerNormal,
			options.cssClasses.markerLarge,
			options.cssClasses.markerSub
		];
		var valueOrientationClasses = [
			options.cssClasses.valueHorizontal,
			options.cssClasses.valueVertical
		];
		var markerOrientationClasses = [
			options.cssClasses.markerHorizontal,
			options.cssClasses.markerVertical
		];

		addClass(element, options.cssClasses.pips);
		addClass(element, options.ort === 0 ? options.cssClasses.pipsHorizontal : options.cssClasses.pipsVertical);

		function getClasses( type, source ){
			var a = source === options.cssClasses.value;
			var orientationClasses = a ? valueOrientationClasses : markerOrientationClasses;
			var sizeClasses = a ? valueSizeClasses : markerSizeClasses;

			return source + ' ' + orientationClasses[options.ort] + ' ' + sizeClasses[type];
		}

		function addSpread ( offset, values ){

			// Apply the filter function, if it is set.
			values[1] = (values[1] && filterFunc) ? filterFunc(values[0], values[1]) : values[1];

			// Add a marker for every point
			var node = addNodeTo(element, false);
				node.className = getClasses(values[1], options.cssClasses.marker);
				node.style[options.style] = offset + '%';

			// Values are only appended for points marked '1' or '2'.
			if ( values[1] ) {
				node = addNodeTo(element, false);
				node.className = getClasses(values[1], options.cssClasses.value);
				node.setAttribute('data-value', values[0]);
				node.style[options.style] = offset + '%';
				node.innerText = formatter.to(values[0]);
			}
		}

		// Append all points.
		Object.keys(spread).forEach(function(a){
			addSpread(a, spread[a]);
		});

		return element;
	}

	function removePips ( ) {
		if ( scope_Pips ) {
			removeElement(scope_Pips);
			scope_Pips = null;
		}
	}

	function pips ( grid ) {

		// Fix #669
		removePips();

		var mode = grid.mode;
		var density = grid.density || 1;
		var filter = grid.filter || false;
		var values = grid.values || false;
		var stepped = grid.stepped || false;
		var group = getGroup( mode, values, stepped );
		var spread = generateSpread( density, mode, group );
		var format = grid.format || {
			to: Math.round
		};

		scope_Pips = scope_Target.appendChild(addMarking(
			spread,
			filter,
			format
		));

		return scope_Pips;
	}

/*! In this file: Browser events (not slider events like slide, change); */

	// Shorthand for base dimensions.
	function baseSize ( ) {
		var rect = scope_Base.getBoundingClientRect();
		var alt = 'offset' + ['Width', 'Height'][options.ort];
		return options.ort === 0 ? (rect.width||scope_Base[alt]) : (rect.height||scope_Base[alt]);
	}

	// Handler for attaching events trough a proxy.
	function attachEvent ( events, element, callback, data ) {

		// This function can be used to 'filter' events to the slider.
		// element is a node, not a nodeList

		var method = function ( e ){

			e = fixEvent(e, data.pageOffset, data.target || element);

			// fixEvent returns false if this event has a different target
			// when handling (multi-) touch events;
			if ( !e ) {
				return false;
			}

			// doNotReject is passed by all end events to make sure released touches
			// are not rejected, leaving the slider "stuck" to the cursor;
			if ( scope_Target.hasAttribute('disabled') && !data.doNotReject ) {
				return false;
			}

			// Stop if an active 'tap' transition is taking place.
			if ( hasClass(scope_Target, options.cssClasses.tap) && !data.doNotReject ) {
				return false;
			}

			// Ignore right or middle clicks on start #454
			if ( events === actions.start && e.buttons !== undefined && e.buttons > 1 ) {
				return false;
			}

			// Ignore right or middle clicks on start #454
			if ( data.hover && e.buttons ) {
				return false;
			}

			// 'supportsPassive' is only true if a browser also supports touch-action: none in CSS.
			// iOS safari does not, so it doesn't get to benefit from passive scrolling. iOS does support
			// touch-action: manipulation, but that allows panning, which breaks
			// sliders after zooming/on non-responsive pages.
			// See: https://bugs.webkit.org/show_bug.cgi?id=133112
			if ( !supportsPassive ) {
				e.preventDefault();
			}

			e.calcPoint = e.points[ options.ort ];

			// Call the event handler with the event [ and additional data ].
			callback ( e, data );
		};

		var methods = [];

		// Bind a closure on the target for every event type.
		events.split(' ').forEach(function( eventName ){
			element.addEventListener(eventName, method, supportsPassive ? { passive: true } : false);
			methods.push([eventName, method]);
		});

		return methods;
	}

	// Provide a clean event with standardized offset values.
	function fixEvent ( e, pageOffset, eventTarget ) {

		// Filter the event to register the type, which can be
		// touch, mouse or pointer. Offset changes need to be
		// made on an event specific basis.
		var touch = e.type.indexOf('touch') === 0;
		var mouse = e.type.indexOf('mouse') === 0;
		var pointer = e.type.indexOf('pointer') === 0;

		var x;
		var y;

		// IE10 implemented pointer events with a prefix;
		if ( e.type.indexOf('MSPointer') === 0 ) {
			pointer = true;
		}

		// In the event that multitouch is activated, the only thing one handle should be concerned
		// about is the touches that originated on top of it.
		if ( touch ) {

			// Returns true if a touch originated on the target.
			var isTouchOnTarget = function (checkTouch) {
				return checkTouch.target === eventTarget || eventTarget.contains(checkTouch.target);
			};

			// In the case of touchstart events, we need to make sure there is still no more than one
			// touch on the target so we look amongst all touches.
			if (e.type === 'touchstart') {

				var targetTouches = Array.prototype.filter.call(e.touches, isTouchOnTarget);

				// Do not support more than one touch per handle.
				if ( targetTouches.length > 1 ) {
					return false;
				}

				x = targetTouches[0].pageX;
				y = targetTouches[0].pageY;

			} else {

				// In the other cases, find on changedTouches is enough.
				var targetTouch = Array.prototype.find.call(e.changedTouches, isTouchOnTarget);

				// Cancel if the target touch has not moved.
				if ( !targetTouch ) {
					return false;
				}

				x = targetTouch.pageX;
				y = targetTouch.pageY;
			}
		}

		pageOffset = pageOffset || getPageOffset(scope_Document);

		if ( mouse || pointer ) {
			x = e.clientX + pageOffset.x;
			y = e.clientY + pageOffset.y;
		}

		e.pageOffset = pageOffset;
		e.points = [x, y];
		e.cursor = mouse || pointer; // Fix #435

		return e;
	}

	// Translate a coordinate in the document to a percentage on the slider
	function calcPointToPercentage ( calcPoint ) {
		var location = calcPoint - offset(scope_Base, options.ort);
		var proposal = ( location * 100 ) / baseSize();

		// Clamp proposal between 0% and 100%
		// Out-of-bound coordinates may occur when .noUi-base pseudo-elements
		// are used (e.g. contained handles feature)
		proposal = limit(proposal);

		return options.dir ? 100 - proposal : proposal;
	}

	// Find handle closest to a certain percentage on the slider
	function getClosestHandle ( proposal ) {

		var closest = 100;
		var handleNumber = false;

		scope_Handles.forEach(function(handle, index){

			// Disabled handles are ignored
			if ( handle.hasAttribute('disabled') ) {
				return;
			}

			var pos = Math.abs(scope_Locations[index] - proposal);

			if ( pos < closest || (pos === 100 && closest === 100) ) {
				handleNumber = index;
				closest = pos;
			}
		});

		return handleNumber;
	}

	// Fire 'end' when a mouse or pen leaves the document.
	function documentLeave ( event, data ) {
		if ( event.type === "mouseout" && event.target.nodeName === "HTML" && event.relatedTarget === null ){
			eventEnd (event, data);
		}
	}

	// Handle movement on document for handle and range drag.
	function eventMove ( event, data ) {

		// Fix #498
		// Check value of .buttons in 'start' to work around a bug in IE10 mobile (data.buttonsProperty).
		// https://connect.microsoft.com/IE/feedback/details/927005/mobile-ie10-windows-phone-buttons-property-of-pointermove-event-always-zero
		// IE9 has .buttons and .which zero on mousemove.
		// Firefox breaks the spec MDN defines.
		if ( navigator.appVersion.indexOf("MSIE 9") === -1 && event.buttons === 0 && data.buttonsProperty !== 0 ) {
			return eventEnd(event, data);
		}

		// Check if we are moving up or down
		var movement = (options.dir ? -1 : 1) * (event.calcPoint - data.startCalcPoint);

		// Convert the movement into a percentage of the slider width/height
		var proposal = (movement * 100) / data.baseSize;

		moveHandles(movement > 0, proposal, data.locations, data.handleNumbers);
	}

	// Unbind move events on document, call callbacks.
	function eventEnd ( event, data ) {

		// The handle is no longer active, so remove the class.
		if ( data.handle ) {
			removeClass(data.handle, options.cssClasses.active);
			scope_ActiveHandlesCount -= 1;
		}

		// Unbind the move and end events, which are added on 'start'.
		data.listeners.forEach(function( c ) {
			scope_DocumentElement.removeEventListener(c[0], c[1]);
		});

		if ( scope_ActiveHandlesCount === 0 ) {
			// Remove dragging class.
			removeClass(scope_Target, options.cssClasses.drag);
			setZindex();

			// Remove cursor styles and text-selection events bound to the body.
			if ( event.cursor ) {
				scope_Body.style.cursor = '';
				scope_Body.removeEventListener('selectstart', preventDefault);
			}
		}

		data.handleNumbers.forEach(function(handleNumber){
			fireEvent('change', handleNumber);
			fireEvent('set', handleNumber);
			fireEvent('end', handleNumber);
		});
	}

	// Bind move events on document.
	function eventStart ( event, data ) {

		var handle;
		if ( data.handleNumbers.length === 1 ) {

			var handleOrigin = scope_Handles[data.handleNumbers[0]];

			// Ignore 'disabled' handles
			if ( handleOrigin.hasAttribute('disabled') ) {
				return false;
			}

			handle = handleOrigin.children[0];
			scope_ActiveHandlesCount += 1;

			// Mark the handle as 'active' so it can be styled.
			addClass(handle, options.cssClasses.active);
		}

		// A drag should never propagate up to the 'tap' event.
		event.stopPropagation();

		// Record the event listeners.
		var listeners = [];

		// Attach the move and end events.
		var moveEvent = attachEvent(actions.move, scope_DocumentElement, eventMove, {
			// The event target has changed so we need to propagate the original one so that we keep
			// relying on it to extract target touches.
			target: event.target,
			handle: handle,
			listeners: listeners,
			startCalcPoint: event.calcPoint,
			baseSize: baseSize(),
			pageOffset: event.pageOffset,
			handleNumbers: data.handleNumbers,
			buttonsProperty: event.buttons,
			locations: scope_Locations.slice()
		});

		var endEvent = attachEvent(actions.end, scope_DocumentElement, eventEnd, {
			target: event.target,
			handle: handle,
			listeners: listeners,
			doNotReject: true,
			handleNumbers: data.handleNumbers
		});

		var outEvent = attachEvent("mouseout", scope_DocumentElement, documentLeave, {
			target: event.target,
			handle: handle,
			listeners: listeners,
			doNotReject: true,
			handleNumbers: data.handleNumbers
		});

		// We want to make sure we pushed the listeners in the listener list rather than creating
		// a new one as it has already been passed to the event handlers.
		listeners.push.apply(listeners, moveEvent.concat(endEvent, outEvent));

		// Text selection isn't an issue on touch devices,
		// so adding cursor styles can be skipped.
		if ( event.cursor ) {

			// Prevent the 'I' cursor and extend the range-drag cursor.
			scope_Body.style.cursor = getComputedStyle(event.target).cursor;

			// Mark the target with a dragging state.
			if ( scope_Handles.length > 1 ) {
				addClass(scope_Target, options.cssClasses.drag);
			}

			// Prevent text selection when dragging the handles.
			// In noUiSlider <= 9.2.0, this was handled by calling preventDefault on mouse/touch start/move,
			// which is scroll blocking. The selectstart event is supported by FireFox starting from version 52,
			// meaning the only holdout is iOS Safari. This doesn't matter: text selection isn't triggered there.
			// The 'cursor' flag is false.
			// See: http://caniuse.com/#search=selectstart
			scope_Body.addEventListener('selectstart', preventDefault, false);
		}

		data.handleNumbers.forEach(function(handleNumber){
			fireEvent('start', handleNumber);
		});
	}

	// Move closest handle to tapped location.
	function eventTap ( event ) {

		// The tap event shouldn't propagate up
		event.stopPropagation();

		var proposal = calcPointToPercentage(event.calcPoint);
		var handleNumber = getClosestHandle(proposal);

		// Tackle the case that all handles are 'disabled'.
		if ( handleNumber === false ) {
			return false;
		}

		// Flag the slider as it is now in a transitional state.
		// Transition takes a configurable amount of ms (default 300). Re-enable the slider after that.
		if ( !options.events.snap ) {
			addClassFor(scope_Target, options.cssClasses.tap, options.animationDuration);
		}

		setHandle(handleNumber, proposal, true, true);

		setZindex();

		fireEvent('slide', handleNumber, true);
		fireEvent('update', handleNumber, true);
		fireEvent('change', handleNumber, true);
		fireEvent('set', handleNumber, true);

		if ( options.events.snap ) {
			eventStart(event, { handleNumbers: [handleNumber] });
		}
	}

	// Fires a 'hover' event for a hovered mouse/pen position.
	function eventHover ( event ) {

		var proposal = calcPointToPercentage(event.calcPoint);

		var to = scope_Spectrum.getStep(proposal);
		var value = scope_Spectrum.fromStepping(to);

		Object.keys(scope_Events).forEach(function( targetEvent ) {
			if ( 'hover' === targetEvent.split('.')[0] ) {
				scope_Events[targetEvent].forEach(function( callback ) {
					callback.call( scope_Self, value );
				});
			}
		});
	}

	// Attach events to several slider parts.
	function bindSliderEvents ( behaviour ) {

		// Attach the standard drag event to the handles.
		if ( !behaviour.fixed ) {

			scope_Handles.forEach(function( handle, index ){

				// These events are only bound to the visual handle
				// element, not the 'real' origin element.
				attachEvent ( actions.start, handle.children[0], eventStart, {
					handleNumbers: [index]
				});
			});
		}

		// Attach the tap event to the slider base.
		if ( behaviour.tap ) {
			attachEvent (actions.start, scope_Base, eventTap, {});
		}

		// Fire hover events
		if ( behaviour.hover ) {
			attachEvent (actions.move, scope_Base, eventHover, { hover: true });
		}

		// Make the range draggable.
		if ( behaviour.drag ){

			scope_Connects.forEach(function( connect, index ){

				if ( connect === false || index === 0 || index === scope_Connects.length - 1 ) {
					return;
				}

				var handleBefore = scope_Handles[index - 1];
				var handleAfter = scope_Handles[index];
				var eventHolders = [connect];

				addClass(connect, options.cssClasses.draggable);

				// When the range is fixed, the entire range can
				// be dragged by the handles. The handle in the first
				// origin will propagate the start event upward,
				// but it needs to be bound manually on the other.
				if ( behaviour.fixed ) {
					eventHolders.push(handleBefore.children[0]);
					eventHolders.push(handleAfter.children[0]);
				}

				eventHolders.forEach(function( eventHolder ) {
					attachEvent ( actions.start, eventHolder, eventStart, {
						handles: [handleBefore, handleAfter],
						handleNumbers: [index - 1, index]
					});
				});
			});
		}
	}

/*! In this file: Slider events (not browser events); */

	// Attach an event to this slider, possibly including a namespace
	function bindEvent ( namespacedEvent, callback ) {
		scope_Events[namespacedEvent] = scope_Events[namespacedEvent] || [];
		scope_Events[namespacedEvent].push(callback);

		// If the event bound is 'update,' fire it immediately for all handles.
		if ( namespacedEvent.split('.')[0] === 'update' ) {
			scope_Handles.forEach(function(a, index){
				fireEvent('update', index);
			});
		}
	}

	// Undo attachment of event
	function removeEvent ( namespacedEvent ) {

		var event = namespacedEvent && namespacedEvent.split('.')[0];
		var namespace = event && namespacedEvent.substring(event.length);

		Object.keys(scope_Events).forEach(function( bind ){

			var tEvent = bind.split('.')[0];
			var tNamespace = bind.substring(tEvent.length);

			if ( (!event || event === tEvent) && (!namespace || namespace === tNamespace) ) {
				delete scope_Events[bind];
			}
		});
	}

	// External event handling
	function fireEvent ( eventName, handleNumber, tap ) {

		Object.keys(scope_Events).forEach(function( targetEvent ) {

			var eventType = targetEvent.split('.')[0];

			if ( eventName === eventType ) {
				scope_Events[targetEvent].forEach(function( callback ) {

					callback.call(
						// Use the slider public API as the scope ('this')
						scope_Self,
						// Return values as array, so arg_1[arg_2] is always valid.
						scope_Values.map(options.format.to),
						// Handle index, 0 or 1
						handleNumber,
						// Unformatted slider values
						scope_Values.slice(),
						// Event is fired by tap, true or false
						tap || false,
						// Left offset of the handle, in relation to the slider
						scope_Locations.slice()
					);
				});
			}
		});
	}

/*! In this file: Mechanics for slider operation */

	function toPct ( pct ) {
		return pct + '%';
	}

	// Split out the handle positioning logic so the Move event can use it, too
	function checkHandlePosition ( reference, handleNumber, to, lookBackward, lookForward, getValue ) {

		// For sliders with multiple handles, limit movement to the other handle.
		// Apply the margin option by adding it to the handle positions.
		if ( scope_Handles.length > 1 ) {

			if ( lookBackward && handleNumber > 0 ) {
				to = Math.max(to, reference[handleNumber - 1] + options.margin);
			}

			if ( lookForward && handleNumber < scope_Handles.length - 1 ) {
				to = Math.min(to, reference[handleNumber + 1] - options.margin);
			}
		}

		// The limit option has the opposite effect, limiting handles to a
		// maximum distance from another. Limit must be > 0, as otherwise
		// handles would be unmoveable.
		if ( scope_Handles.length > 1 && options.limit ) {

			if ( lookBackward && handleNumber > 0 ) {
				to = Math.min(to, reference[handleNumber - 1] + options.limit);
			}

			if ( lookForward && handleNumber < scope_Handles.length - 1 ) {
				to = Math.max(to, reference[handleNumber + 1] - options.limit);
			}
		}

		// The padding option keeps the handles a certain distance from the
		// edges of the slider. Padding must be > 0.
		if ( options.padding ) {

			if ( handleNumber === 0 ) {
				to = Math.max(to, options.padding[0]);
			}

			if ( handleNumber === scope_Handles.length - 1 ) {
				to = Math.min(to, 100 - options.padding[1]);
			}
		}

		to = scope_Spectrum.getStep(to);

		// Limit percentage to the 0 - 100 range
		to = limit(to);

		// Return false if handle can't move
		if ( to === reference[handleNumber] && !getValue ) {
			return false;
		}

		return to;
	}

	// Uses slider orientation to create CSS rules. a = base value;
	function inRuleOrder ( v, a ) {
		var o = options.ort;
		return (o?a:v) + ', ' + (o?v:a);
	}

	// Moves handle(s) by a percentage
	// (bool, % to move, [% where handle started, ...], [index in scope_Handles, ...])
	function moveHandles ( upward, proposal, locations, handleNumbers ) {

		var proposals = locations.slice();

		var b = [!upward, upward];
		var f = [upward, !upward];

		// Copy handleNumbers so we don't change the dataset
		handleNumbers = handleNumbers.slice();

		// Check to see which handle is 'leading'.
		// If that one can't move the second can't either.
		if ( upward ) {
			handleNumbers.reverse();
		}

		// Step 1: get the maximum percentage that any of the handles can move
		if ( handleNumbers.length > 1 ) {

			handleNumbers.forEach(function(handleNumber, o) {

				var to = checkHandlePosition(proposals, handleNumber, proposals[handleNumber] + proposal, b[o], f[o], false);

				// Stop if one of the handles can't move.
				if ( to === false ) {
					proposal = 0;
				} else {
					proposal = to - proposals[handleNumber];
					proposals[handleNumber] = to;
				}
			});
		}

		// If using one handle, check backward AND forward
		else {
			b = f = [true];
		}

		var state = false;

		// Step 2: Try to set the handles with the found percentage
		handleNumbers.forEach(function(handleNumber, o) {
			state = setHandle(handleNumber, locations[handleNumber] + proposal, b[o], f[o]) || state;
		});

		// Step 3: If a handle moved, fire events
		if ( state ) {
			handleNumbers.forEach(function(handleNumber){
				fireEvent('update', handleNumber);
				fireEvent('slide', handleNumber);
			});
		}
	}

	// Takes a base value and an offset. This offset is used for the connect bar size.
	// In the initial design for this feature, the origin element was 1% wide.
	// Unfortunately, a rounding bug in Chrome makes it impossible to implement this feature
	// in this manner: https://bugs.chromium.org/p/chromium/issues/detail?id=798223
	function transformDirection ( a, b ) {
		return options.dir ? 100 - a - b : a;
	}

	// Updates scope_Locations and scope_Values, updates visual state
	function updateHandlePosition ( handleNumber, to ) {

		// Update locations.
		scope_Locations[handleNumber] = to;

		// Convert the value to the slider stepping/range.
		scope_Values[handleNumber] = scope_Spectrum.fromStepping(to);

		var rule = 'translate(' + inRuleOrder(toPct(transformDirection(to, 0) - scope_DirOffset), '0') + ')';
		scope_Handles[handleNumber].style[options.transformRule] = rule;

		updateConnect(handleNumber);
		updateConnect(handleNumber + 1);
	}

	// Handles before the slider middle are stacked later = higher,
	// Handles after the middle later is lower
	// [[7] [8] .......... | .......... [5] [4]
	function setZindex ( ) {

		scope_HandleNumbers.forEach(function(handleNumber){
			var dir = (scope_Locations[handleNumber] > 50 ? -1 : 1);
			var zIndex = 3 + (scope_Handles.length + (dir * handleNumber));
			scope_Handles[handleNumber].style.zIndex = zIndex;
		});
	}

	// Test suggested values and apply margin, step.
	function setHandle ( handleNumber, to, lookBackward, lookForward ) {

		to = checkHandlePosition(scope_Locations, handleNumber, to, lookBackward, lookForward, false);

		if ( to === false ) {
			return false;
		}

		updateHandlePosition(handleNumber, to);

		return true;
	}

	// Updates style attribute for connect nodes
	function updateConnect ( index ) {

		// Skip connects set to false
		if ( !scope_Connects[index] ) {
			return;
		}

		var l = 0;
		var h = 100;

		if ( index !== 0 ) {
			l = scope_Locations[index - 1];
		}

		if ( index !== scope_Connects.length - 1 ) {
			h = scope_Locations[index];
		}

		// We use two rules:
		// 'translate' to change the left/top offset;
		// 'scale' to change the width of the element;
		// As the element has a width of 100%, a translation of 100% is equal to 100% of the parent (.noUi-base)
		var connectWidth = h - l;
		var translateRule = 'translate(' + inRuleOrder(toPct(transformDirection(l, connectWidth)), '0') + ')';
		var scaleRule = 'scale(' + inRuleOrder(connectWidth / 100, '1') + ')';

		scope_Connects[index].style[options.transformRule] = translateRule + ' ' + scaleRule;
	}

/*! In this file: All methods eventually exposed in slider.noUiSlider... */

	// Parses value passed to .set method. Returns current value if not parse-able.
	function resolveToValue ( to, handleNumber ) {

		// Setting with null indicates an 'ignore'.
		// Inputting 'false' is invalid.
		if ( to === null || to === false || to === undefined ) {
			return scope_Locations[handleNumber];
		}

		// If a formatted number was passed, attempt to decode it.
		if ( typeof to === 'number' ) {
			to = String(to);
		}

		to = options.format.from(to);
		to = scope_Spectrum.toStepping(to);

		// If parsing the number failed, use the current value.
		if ( to === false || isNaN(to) ) {
			return scope_Locations[handleNumber];
		}

		return to;
	}

	// Set the slider value.
	function valueSet ( input, fireSetEvent ) {

		var values = asArray(input);
		var isInit = scope_Locations[0] === undefined;

		// Event fires by default
		fireSetEvent = (fireSetEvent === undefined ? true : !!fireSetEvent);

		// Animation is optional.
		// Make sure the initial values were set before using animated placement.
		if ( options.animate && !isInit ) {
			addClassFor(scope_Target, options.cssClasses.tap, options.animationDuration);
		}

		// First pass, without lookAhead but with lookBackward. Values are set from left to right.
		scope_HandleNumbers.forEach(function(handleNumber){
			setHandle(handleNumber, resolveToValue(values[handleNumber], handleNumber), true, false);
		});

		// Second pass. Now that all base values are set, apply constraints
		scope_HandleNumbers.forEach(function(handleNumber){
			setHandle(handleNumber, scope_Locations[handleNumber], true, true);
		});

		setZindex();

		scope_HandleNumbers.forEach(function(handleNumber){

			fireEvent('update', handleNumber);

			// Fire the event only for handles that received a new value, as per #579
			if ( values[handleNumber] !== null && fireSetEvent ) {
				fireEvent('set', handleNumber);
			}
		});
	}

	// Reset slider to initial values
	function valueReset ( fireSetEvent ) {
		valueSet(options.start, fireSetEvent);
	}

	// Get the slider value.
	function valueGet ( ) {

		var values = scope_Values.map(options.format.to);

		// If only one handle is used, return a single value.
		if ( values.length === 1 ){
			return values[0];
		}

		return values;
	}

	// Removes classes from the root and empties it.
	function destroy ( ) {

		for ( var key in options.cssClasses ) {
			if ( !options.cssClasses.hasOwnProperty(key) ) { continue; }
			removeClass(scope_Target, options.cssClasses[key]);
		}

		while (scope_Target.firstChild) {
			scope_Target.removeChild(scope_Target.firstChild);
		}

		delete scope_Target.noUiSlider;
	}

	// Get the current step size for the slider.
	function getCurrentStep ( ) {

		// Check all locations, map them to their stepping point.
		// Get the step point, then find it in the input list.
		return scope_Locations.map(function( location, index ){

			var nearbySteps = scope_Spectrum.getNearbySteps( location );
			var value = scope_Values[index];
			var increment = nearbySteps.thisStep.step;
			var decrement = null;

			// If the next value in this step moves into the next step,
			// the increment is the start of the next step - the current value
			if ( increment !== false ) {
				if ( value + increment > nearbySteps.stepAfter.startValue ) {
					increment = nearbySteps.stepAfter.startValue - value;
				}
			}


			// If the value is beyond the starting point
			if ( value > nearbySteps.thisStep.startValue ) {
				decrement = nearbySteps.thisStep.step;
			}

			else if ( nearbySteps.stepBefore.step === false ) {
				decrement = false;
			}

			// If a handle is at the start of a step, it always steps back into the previous step first
			else {
				decrement = value - nearbySteps.stepBefore.highestStep;
			}


			// Now, if at the slider edges, there is not in/decrement
			if ( location === 100 ) {
				increment = null;
			}

			else if ( location === 0 ) {
				decrement = null;
			}

			// As per #391, the comparison for the decrement step can have some rounding issues.
			var stepDecimals = scope_Spectrum.countStepDecimals();

			// Round per #391
			if ( increment !== null && increment !== false ) {
				increment = Number(increment.toFixed(stepDecimals));
			}

			if ( decrement !== null && decrement !== false ) {
				decrement = Number(decrement.toFixed(stepDecimals));
			}

			return [decrement, increment];
		});
	}

	// Updateable: margin, limit, padding, step, range, animate, snap
	function updateOptions ( optionsToUpdate, fireSetEvent ) {

		// Spectrum is created using the range, snap, direction and step options.
		// 'snap' and 'step' can be updated.
		// If 'snap' and 'step' are not passed, they should remain unchanged.
		var v = valueGet();

		var updateAble = ['margin', 'limit', 'padding', 'range', 'animate', 'snap', 'step', 'format'];

		// Only change options that we're actually passed to update.
		updateAble.forEach(function(name){
			if ( optionsToUpdate[name] !== undefined ) {
				originalOptions[name] = optionsToUpdate[name];
			}
		});

		var newOptions = testOptions(originalOptions);

		// Load new options into the slider state
		updateAble.forEach(function(name){
			if ( optionsToUpdate[name] !== undefined ) {
				options[name] = newOptions[name];
			}
		});

		scope_Spectrum = newOptions.spectrum;

		// Limit, margin and padding depend on the spectrum but are stored outside of it. (#677)
		options.margin = newOptions.margin;
		options.limit = newOptions.limit;
		options.padding = newOptions.padding;

		// Update pips, removes existing.
		if ( options.pips ) {
			pips(options.pips);
		}

		// Invalidate the current positioning so valueSet forces an update.
		scope_Locations = [];
		valueSet(optionsToUpdate.start || v, fireSetEvent);
	}

/*! In this file: Calls to functions. All other scope_ files define functions only; */

	// Create the base element, initialize HTML and set classes.
	// Add handles and connect elements.
	addSlider(scope_Target);
	addElements(options.connect, scope_Base);

	// Attach user events.
	bindSliderEvents(options.events);

	// Use the public value method to set the start values.
	valueSet(options.start);

	scope_Self = {
		destroy: destroy,
		steps: getCurrentStep,
		on: bindEvent,
		off: removeEvent,
		get: valueGet,
		set: valueSet,
		reset: valueReset,
		// Exposed for unit testing, don't use this in your application.
		__moveHandles: function(a, b, c) { moveHandles(a, b, scope_Locations, c); },
		options: originalOptions, // Issue #600, #678
		updateOptions: updateOptions,
		target: scope_Target, // Issue #597
		removePips: removePips,
		pips: pips // Issue #594
	};

	if ( options.pips ) {
		pips(options.pips);
	}

	if ( options.tooltips ) {
		tooltips();
	}

	aria();

	return scope_Self;

}


	// Run the standard initializer
	function initialize ( target, originalOptions ) {

		if ( !target || !target.nodeName ) {
			throw new Error("noUiSlider (" + VERSION + "): create requires a single element, got: " + target);
		}

		// Throw an error if the slider was already initialized.
		if ( target.noUiSlider ) {
			throw new Error("noUiSlider (" + VERSION + "): Slider was already initialized.");
		}

		// Test the options and create the slider environment;
		var options = testOptions( originalOptions, target );
		var api = scope( target, options, originalOptions );

		target.noUiSlider = api;

		return api;
	}

	// Use an object instead of a function for future expandability;
	return {
		version: VERSION,
		create: initialize
	};

}));
},{}],3:[function(require,module,exports){
(function (global){

var $ 				= (typeof window !== "undefined" ? window['jQuery'] : typeof global !== "undefined" ? global['jQuery'] : null);
var state 			= require('./state');
var process_form 	= require('./process_form');
var noUiSlider		= require('nouislider');
//var cookies         = require('js-cookie');
var thirdParty      = require('./thirdparty');

window.searchAndFilter = {
    extensions: [],
    registerExtension: function( extensionName ) {
        this.extensions.push( extensionName );
    }
};

module.exports = function(options)
{
    var defaults = {
        startOpened: false,
        isInit: true,
        action: ""
    };

    var opts = jQuery.extend(defaults, options);
    
    thirdParty.init();
    
    //loop through each item matched
    this.each(function()
    {

        var $this = $(this);
        var self = this;
        this.sfid = $this.attr("data-sf-form-id");

        state.addSearchForm(this.sfid, this);

        this.$fields = $this.find("> ul > li"); //a reference to each fields parent LI

        this.enable_taxonomy_archives = $this.attr('data-taxonomy-archives');
        this.current_taxonomy_archive = $this.attr('data-current-taxonomy-archive');

        if(typeof(this.enable_taxonomy_archives)=="undefined")
        {
            this.enable_taxonomy_archives = "0";
        }
        if(typeof(this.current_taxonomy_archive)=="undefined")
        {
            this.current_taxonomy_archive = "";
        }

        process_form.init(self.enable_taxonomy_archives, self.current_taxonomy_archive);
        //process_form.setTaxArchiveResultsUrl(self);
        process_form.enableInputs(self);

        if(typeof(this.extra_query_params)=="undefined")
        {
            this.extra_query_params = {all: {}, results: {}, ajax: {}};
        }


        this.template_is_loaded = $this.attr("data-template-loaded");
        this.is_ajax = $this.attr("data-ajax");
        this.instance_number = $this.attr('data-instance-count');
        this.$ajax_results_container = jQuery($this.attr("data-ajax-target"));

        this.ajax_update_sections = $this.attr("data-ajax-update-sections") ? JSON.parse( $this.attr("data-ajax-update-sections") ) : [];
        
        this.results_url = $this.attr("data-results-url");
        this.debug_mode = $this.attr("data-debug-mode");
        this.update_ajax_url = $this.attr("data-update-ajax-url");
        this.pagination_type = $this.attr("data-ajax-pagination-type");
        this.auto_count = $this.attr("data-auto-count");
        this.auto_count_refresh_mode = $this.attr("data-auto-count-refresh-mode");
        this.only_results_ajax = $this.attr("data-only-results-ajax"); //if we are not on the results page, redirect rather than try to load via ajax
        this.scroll_to_pos = $this.attr("data-scroll-to-pos");
        this.custom_scroll_to = $this.attr("data-custom-scroll-to");
        this.scroll_on_action = $this.attr("data-scroll-on-action");
        this.lang_code = $this.attr("data-lang-code");
        this.ajax_url = $this.attr('data-ajax-url');
        this.ajax_form_url = $this.attr('data-ajax-form-url');
        this.is_rtl = $this.attr('data-is-rtl');

        this.display_result_method = $this.attr('data-display-result-method');
        this.maintain_state = $this.attr('data-maintain-state');
        this.ajax_action = "";
        this.last_submit_query_params = "";

        this.current_paged = parseInt($this.attr('data-init-paged'));
        this.last_load_more_html = "";
        this.load_more_html = "";
        this.ajax_data_type = $this.attr('data-ajax-data-type');
        this.ajax_target_attr = $this.attr("data-ajax-target");
        this.use_history_api = $this.attr("data-use-history-api");
        this.is_submitting = false;

        this.last_ajax_request = null;

        if(typeof(this.use_history_api)=="undefined")
        {
            this.use_history_api = "";
        }

        if(typeof(this.pagination_type)=="undefined")
        {
            this.pagination_type = "normal";
        }
        if(typeof(this.current_paged)=="undefined")
        {
            this.current_paged = 1;
        }

        if(typeof(this.ajax_target_attr)=="undefined")
        {
            this.ajax_target_attr = "";
        }

        if(typeof(this.ajax_url)=="undefined")
        {
            this.ajax_url = "";
        }

        if(typeof(this.ajax_form_url)=="undefined")
        {
            this.ajax_form_url = "";
        }

        if(typeof(this.results_url)=="undefined")
        {
            this.results_url = "";
        }

        if(typeof(this.scroll_to_pos)=="undefined")
        {
            this.scroll_to_pos = "";
        }

        if(typeof(this.scroll_on_action)=="undefined")
        {
            this.scroll_on_action = "";
        }
        if(typeof(this.custom_scroll_to)=="undefined")
        {
            this.custom_scroll_to = "";
        }
        this.$custom_scroll_to = jQuery(this.custom_scroll_to);

        if(typeof(this.update_ajax_url)=="undefined")
        {
            this.update_ajax_url = "";
        }

        if(typeof(this.debug_mode)=="undefined")
        {
            this.debug_mode = "";
        }

        if(typeof(this.ajax_target_object)=="undefined")
        {
            this.ajax_target_object = "";
        }

        if(typeof(this.template_is_loaded)=="undefined")
        {
            this.template_is_loaded = "0";
        }

        if(typeof(this.auto_count_refresh_mode)=="undefined")
        {
            this.auto_count_refresh_mode = "0";
        }

        this.ajax_links_selector = $this.attr("data-ajax-links-selector");


        this.auto_update = $this.attr("data-auto-update");
        this.inputTimer = 0;

        this.setInfiniteScrollContainer = function()
        {
            // When we navigate away from search results, and then press back,
            // is_max_paged is retained, so we only want to set it to false if
            // we are initalizing the results page the first time - so just 
            // check if this var is undefined (as it should be on first use);
            if ( typeof ( this.is_max_paged ) === 'undefined' ) {
                this.is_max_paged = false; //for load more only, once we detect we're at the end set this to true
            }

            this.use_scroll_loader = $this.attr('data-show-scroll-loader');
            this.infinite_scroll_container = $this.attr('data-infinite-scroll-container');
            this.infinite_scroll_trigger_amount = $this.attr('data-infinite-scroll-trigger');
            this.infinite_scroll_result_class = $this.attr('data-infinite-scroll-result-class');
            this.$infinite_scroll_container = this.$ajax_results_container;

            if(typeof(this.infinite_scroll_container)=="undefined")
            {
                this.infinite_scroll_container = "";
            }
            else
            {
                this.$infinite_scroll_container = jQuery($this.attr('data-infinite-scroll-container'));
            }

            if(typeof(this.infinite_scroll_result_class)=="undefined")
            {
                this.infinite_scroll_result_class = "";
            }

            if(typeof(this.use_scroll_loader)=="undefined")
            {
                this.use_scroll_loader = 1;
            }

        };
        this.setInfiniteScrollContainer();

        /* functions */

        this.reset = function(submit_form)
        {

            this.resetForm(submit_form);
            return true;
        }

        this.inputUpdate = function(delayDuration)
        {
            if(typeof(delayDuration)=="undefined")
            {
                var delayDuration = 300;
            }

            self.resetTimer(delayDuration);
        }

        this.scrollToPos = function() {
            var offset = 0;
            var canScroll = true;

            if(self.is_ajax==1)
            {
                if(self.scroll_to_pos=="window")
                {
                    offset = 0;

                }
                else if(self.scroll_to_pos=="form")
                {
                    offset = $this.offset().top;
                }
                else if(self.scroll_to_pos=="results")
                {
                    if(self.$ajax_results_container.length>0)
                    {
                        offset = self.$ajax_results_container.offset().top;
                    }
                }
                else if(self.scroll_to_pos=="custom")
                {
                    //custom_scroll_to
                    if(self.$custom_scroll_to.length>0)
                    {
                        offset = self.$custom_scroll_to.offset().top;
                    }
                }
                else
                {
                    canScroll = false;
                }

                if(canScroll)
                {
                    $("html, body").stop().animate({
                        scrollTop: offset
                    }, "normal", "easeOutQuad" );
                }
            }

        };

        this.attachActiveClass = function(){

            //check to see if we are using ajax & auto count
            //if not, the search form does not get reloaded, so we need to update the sf-option-active class on all fields

            $this.on('change', 'input[type="radio"], input[type="checkbox"], select', function(e)
            {
                var $cthis = $(this);
                var $cthis_parent = $cthis.closest("li[data-sf-field-name]");
                var this_tag = $cthis.prop("tagName").toLowerCase();
                var input_type = $cthis.attr("type");
                var parent_tag = $cthis_parent.prop("tagName").toLowerCase();

                if((this_tag=="input")&&((input_type=="radio")||(input_type=="checkbox")) && (parent_tag=="li"))
                {
                    var $all_options = $cthis_parent.parent().find('li');
                    var $all_options_fields = $cthis_parent.parent().find('input:checked');

                    $all_options.removeClass("sf-option-active");
                    $all_options_fields.each(function(){

                        var $parent = $(this).closest("li");
                        $parent.addClass("sf-option-active");

                    });

                }
                else if(this_tag=="select")
                {
                    var $all_options = $cthis.children();
                    $all_options.removeClass("sf-option-active");
                    var this_val = $cthis.val();

                    var this_arr_val = (typeof this_val == 'string' || this_val instanceof String) ? [this_val] : this_val;

                    $(this_arr_val).each(function(i, value){
                        $cthis.find("option[value='"+value+"']").addClass("sf-option-active");
                    });


                }
            });

        };
        this.initAutoUpdateEvents = function(){

            /* auto update */
            if((self.auto_update==1)||(self.auto_count_refresh_mode==1))
            {
                $this.on('change', 'input[type="radio"], input[type="checkbox"], select', function(e) {
                    self.inputUpdate(200);
                });

                $this.on('input', 'input[type="number"]', function(e) {
                    self.inputUpdate(800);
                });

                var $textInput = $this.find('input[type="text"]:not(.sf-datepicker)');
                var lastValue = $textInput.val();

                $this.on('input', 'input[type="text"]:not(.sf-datepicker)', function()
                {
                    if(lastValue!=$textInput.val())
                    {
                        self.inputUpdate(1200);
                    }

                    lastValue = $textInput.val();
                });


                $this.on('keypress', 'input[type="text"]:not(.sf-datepicker)', function(e)
                {
                    if (e.which == 13){

                        e.preventDefault();
                        self.submitForm();
                        return false;
                    }

                });

                //$this.on('input', 'input.sf-datepicker', self.dateInputType);

            }
        };

        //this.initAutoUpdateEvents();


        this.clearTimer = function()
        {
            clearTimeout(self.inputTimer);
        };
        this.resetTimer = function(delayDuration)
        {
            clearTimeout(self.inputTimer);
            self.inputTimer = setTimeout(self.formUpdated, delayDuration);

        };

        this.addDatePickers = function()
        {
            var $date_picker = $this.find(".sf-datepicker");

            if($date_picker.length>0)
            {
                $date_picker.each(function(){

                    var $this = $(this);
                    var dateFormat = "";
                    var dateDropdownYear = false;
                    var dateDropdownMonth = false;

                    var $closest_date_wrap = $this.closest(".sf_date_field");
                    if($closest_date_wrap.length>0)
                    {
                        dateFormat = $closest_date_wrap.attr("data-date-format");

                        if($closest_date_wrap.attr("data-date-use-year-dropdown")==1)
                        {
                            dateDropdownYear = true;
                        }
                        if($closest_date_wrap.attr("data-date-use-month-dropdown")==1)
                        {
                            dateDropdownMonth = true;
                        }
                    }

                    var datePickerOptions = {
                        inline: true,
                        showOtherMonths: true,
                        onSelect: function(e, from_field){ self.dateSelect(e, from_field, $(this)); },
                        dateFormat: dateFormat,

                        changeMonth: dateDropdownMonth,
                        changeYear: dateDropdownYear
                    };

                    if(self.is_rtl==1)
                    {
                        datePickerOptions.direction = "rtl";
                    }

                    $this.datepicker(datePickerOptions);

                    if(self.lang_code!="")
                    {
                        $.datepicker.setDefaults(
                            $.extend(
                                {'dateFormat':dateFormat},
                                $.datepicker.regional[ self.lang_code]
                            )
                        );

                    }
                    else
                    {
                        $.datepicker.setDefaults(
                            $.extend(
                                {'dateFormat':dateFormat},
                                $.datepicker.regional["en"]
                            )
                        );

                    }

                });

                if($('.ll-skin-melon').length==0){

                    $date_picker.datepicker('widget').wrap('<div class="ll-skin-melon searchandfilter-date-picker"/>');
                }

            }
        };

        this.dateSelect = function(e, from_field, $this)
        {
            var $input_field = $(from_field.input.get(0));
            var $this = $(this);

            var $date_fields = $input_field.closest('[data-sf-field-input-type="daterange"], [data-sf-field-input-type="date"]');
            $date_fields.each(function(e, index){
                
                var $tf_date_pickers = $(this).find(".sf-datepicker");
                var no_date_pickers = $tf_date_pickers.length;
                
                if(no_date_pickers>1)
                {
                    //then it is a date range, so make sure both fields are filled before updating
                    var dp_counter = 0;
                    var dp_empty_field_count = 0;
                    $tf_date_pickers.each(function(){

                        if($(this).val()=="")
                        {
                            dp_empty_field_count++;
                        }

                        dp_counter++;
                    });

                    if(dp_empty_field_count==0)
                    {
                        self.inputUpdate(1);
                    }
                }
                else
                {
                    self.inputUpdate(1);
                }

            });
        };

        this.addRangeSliders = function()
        {
            var $meta_range = $this.find(".sf-meta-range-slider");

            if($meta_range.length>0)
            {
                $meta_range.each(function(){

                    var $this = $(this);
                    var min = $this.attr("data-min");
                    var max = $this.attr("data-max");
                    var smin = $this.attr("data-start-min");
                    var smax = $this.attr("data-start-max");
                    var display_value_as = $this.attr("data-display-values-as");
                    var step = $this.attr("data-step");
                    var $start_val = $this.find('.sf-range-min');
                    var $end_val = $this.find('.sf-range-max');


                    var decimal_places = $this.attr("data-decimal-places");
                    var thousand_seperator = $this.attr("data-thousand-seperator");
                    var decimal_seperator = $this.attr("data-decimal-seperator");

                    var field_format = wNumb({
                        mark: decimal_seperator,
                        decimals: parseFloat(decimal_places),
                        thousand: thousand_seperator
                    });



                    var min_unformatted = parseFloat(smin);
                    var min_formatted = field_format.to(parseFloat(smin));
                    var max_formatted = field_format.to(parseFloat(smax));
                    var max_unformatted = parseFloat(smax);
                    //alert(min_formatted);
                    //alert(max_formatted);
                    //alert(display_value_as);


                    if(display_value_as=="textinput")
                    {
                        $start_val.val(min_formatted);
                        $end_val.val(max_formatted);
                    }
                    else if(display_value_as=="text")
                    {
                        $start_val.html(min_formatted);
                        $end_val.html(max_formatted);
                    }


                    var noUIOptions = {
                        range: {
                            'min': [ parseFloat(min) ],
                            'max': [ parseFloat(max) ]
                        },
                        start: [min_formatted, max_formatted],
                        handles: 2,
                        connect: true,
                        step: parseFloat(step),

                        behaviour: 'extend-tap',
                        format: field_format
                    };



                    if(self.is_rtl==1)
                    {
                        noUIOptions.direction = "rtl";
                    }

                    var slider_object = $(this).find(".meta-slider")[0];

                    if( "undefined" !== typeof( slider_object.noUiSlider ) ) {
                        //destroy if it exists.. this means somehow another instance had initialised it..
                        slider_object.noUiSlider.destroy();
                    }

                    noUiSlider.create(slider_object, noUIOptions);

                    $start_val.off();
                    $start_val.on('change', function(){
                        slider_object.noUiSlider.set([$(this).val(), null]);
                    });

                    $end_val.off();
                    $end_val.on('change', function(){
                        slider_object.noUiSlider.set([null, $(this).val()]);
                    });

                    //$start_val.html(min_formatted);
                    //$end_val.html(max_formatted);

                    slider_object.noUiSlider.off('update');
                    slider_object.noUiSlider.on('update', function( values, handle ) {

                        var slider_start_val  = min_formatted;
                        var slider_end_val  = max_formatted;

                        var value = values[handle];


                        if ( handle ) {
                            max_formatted = value;
                        } else {
                            min_formatted = value;
                        }

                        if(display_value_as=="textinput")
                        {
                            $start_val.val(min_formatted);
                            $end_val.val(max_formatted);
                        }
                        else if(display_value_as=="text")
                        {
                            $start_val.html(min_formatted);
                            $end_val.html(max_formatted);
                        }


                        //i think the function that builds the URL needs to decode the formatted string before adding to the url
                        if((self.auto_update==1)||(self.auto_count_refresh_mode==1))
                        {
                            //only try to update if the values have actually changed
                            if((slider_start_val!=min_formatted)||(slider_end_val!=max_formatted)) {

                                self.inputUpdate(800);
                            }


                        }

                    });

                });

                self.clearTimer(); //ignore any changes recently made by the slider (this was just init shouldn't count as an update event)
            }
        };

        this.init = function(keep_pagination)
        {
            if(typeof(keep_pagination)=="undefined")
            {
                var keep_pagination = false;
            }

            this.initAutoUpdateEvents();
            this.attachActiveClass();

            this.addDatePickers();
            this.addRangeSliders();

            //init combo boxes
            var $combobox = $this.find("select[data-combobox='1']");

            if($combobox.length>0)
            {
                $combobox.each(function(index ){
                    var $thiscb = $( this );
                    var nrm = $thiscb.attr("data-combobox-nrm");

                    if (typeof $thiscb.chosen != "undefined")
                    {
                        var chosenoptions = {
                            search_contains: true
                        };

                        if((typeof(nrm)!=="undefined")&&(nrm)){
                            chosenoptions.no_results_text = nrm;
                        }
                        // safe to use the function
                        //search_contains
                        if(self.is_rtl==1)
                        {
                            $thiscb.addClass("chosen-rtl");
                        }

                        $thiscb.chosen(chosenoptions);
                    }
                    else
                    {

                        var select2options = {};

                        if(self.is_rtl==1)
                        {
                            select2options.dir = "rtl";
                        }
                        if((typeof(nrm)!=="undefined")&&(nrm)){
                            select2options.language= {
                                "noResults": function(){
                                    return nrm;
                                }
                            };
                        }

                        $thiscb.select2(select2options);
                    }

                });


            }

            self.isSubmitting = false;

            //if ajax is enabled init the pagination
            if(self.is_ajax==1)
            {
                self.setupAjaxPagination();
            }

            $this.on("submit", this.submitForm);

            self.initWooCommerceControls(); //woocommerce orderby

            if(keep_pagination==false)
            {
                self.last_submit_query_params = self.getUrlParams(false);
            }
        }

        this.onWindowScroll = function(event)
        {
            if((!self.is_loading_more) && (!self.is_max_paged))
            {
                var window_scroll = $(window).scrollTop();
                var window_scroll_bottom = $(window).scrollTop() + $(window).height();
                var scroll_offset = parseInt(self.infinite_scroll_trigger_amount);

                if(self.$infinite_scroll_container.length==1)
                {
                    var results_scroll_bottom = self.$infinite_scroll_container.offset().top + self.$infinite_scroll_container.height();

                    var offset = (self.$infinite_scroll_container.offset().top + self.$infinite_scroll_container.height()) - window_scroll;

                    if(window_scroll_bottom > results_scroll_bottom + scroll_offset)
                    {
                        self.loadMoreResults();
                    }
                    else
                    {//dont load more

                    }
                }
            }
        }

        this.stripQueryStringAndHashFromPath = function(url) {
            return url.split("?")[0].split("#")[0];
        }

        this.gup = function( name, url ) {
            if (!url) url = location.href
            name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var regexS = "[\\?&]"+name+"=([^&#]*)";
            var regex = new RegExp( regexS );
            var results = regex.exec( url );
            return results == null ? null : results[1];
        };


        this.getUrlParams = function(keep_pagination, type, exclude)
        {
            if(typeof(keep_pagination)=="undefined")
            {
                var keep_pagination = true;
            }

            if(typeof(type)=="undefined")
            {
                var type = "";
            }

            var url_params_str = "";

            // get all params from fields
            var url_params_array = process_form.getUrlParams(self);

            var length = Object.keys(url_params_array).length;
            var count = 0;

            if(typeof(exclude)!="undefined") {
                if (url_params_array.hasOwnProperty(exclude)) {
                    length--;
                }
            }

            if(length>0)
            {
                for (var k in url_params_array) {
                    if (url_params_array.hasOwnProperty(k)) {

                        var can_add = true;
                        if(typeof(exclude)!="undefined")
                        {
                            if(k==exclude) {
                                can_add = false;
                            }
                        }

                        if(can_add) {
                            url_params_str += k + "=" + url_params_array[k];

                            if (count < length - 1) {
                                url_params_str += "&";
                            }

                            count++;
                        }
                    }
                }
            }

            var query_params = "";

            //form params as url query string
            var form_params = url_params_str;

            //get url params from the form itself (what the user has selected)
            query_params = self.joinUrlParam(query_params, form_params);

            //add pagination
            if(keep_pagination==true)
            {
                var pageNumber = self.$ajax_results_container.attr("data-paged");

                if(typeof(pageNumber)=="undefined")
                {
                    pageNumber = 1;
                }

                if(pageNumber>1)
                {
                    query_params = self.joinUrlParam(query_params, "sf_paged="+pageNumber);
                }
            }

            //add sfid
            //query_params = self.joinUrlParam(query_params, "sfid="+self.sfid);

            // loop through any extra params (from ext plugins) and add to the url (ie woocommerce `orderby`)
            /*var extra_query_param = "";
             var length = Object.keys(self.extra_query_params).length;
             var count = 0;

             if(length>0)
             {

             for (var k in self.extra_query_params) {
             if (self.extra_query_params.hasOwnProperty(k)) {

             if(self.extra_query_params[k]!="")
             {
             extra_query_param = k+"="+self.extra_query_params[k];
             query_params = self.joinUrlParam(query_params, extra_query_param);
             }
             */
            query_params = self.addQueryParams(query_params, self.extra_query_params.all);

            if(type!="")
            {
                //query_params = self.addQueryParams(query_params, self.extra_query_params[type]);
            }

            return query_params;
        }
        this.addQueryParams = function(query_params, new_params)
        {
            var extra_query_param = "";
            var length = Object.keys(new_params).length;
            var count = 0;

            if(length>0)
            {

                for (var k in new_params) {
                    if (new_params.hasOwnProperty(k)) {

                        if(new_params[k]!="")
                        {
                            extra_query_param = k+"="+new_params[k];
                            query_params = self.joinUrlParam(query_params, extra_query_param);
                        }
                    }
                }
            }

            return query_params;
        }
        this.addUrlParam = function(url, string)
        {
            var add_params = "";

            if(url!="")
            {
                if(url.indexOf("?") != -1)
                {
                    add_params += "&";
                }
                else
                {
                    //url = this.trailingSlashIt(url);
                    add_params += "?";
                }
            }

            if(string!="")
            {

                return url + add_params + string;
            }
            else
            {
                return url;
            }
        };

        this.joinUrlParam = function(params, string)
        {
            var add_params = "";

            if(params!="")
            {
                add_params += "&";
            }

            if(string!="")
            {

                return params + add_params + string;
            }
            else
            {
                return params;
            }
        };

        this.setAjaxResultsURLs = function(query_params)
        {
            if(typeof(self.ajax_results_conf)=="undefined")
            {
                self.ajax_results_conf = new Array();
            }

            self.ajax_results_conf['processing_url'] = "";
            self.ajax_results_conf['results_url'] = "";
            self.ajax_results_conf['data_type'] = "";

            //if(self.ajax_url!="")
            if(self.display_result_method=="shortcode")
            {//then we want to do a request to the ajax endpoint
                self.ajax_results_conf['results_url'] = self.addUrlParam(self.results_url, query_params);

                //add lang code to ajax api request, lang code should already be in there for other requests (ie, supplied in the Results URL)

                if(self.lang_code!="")
                {
                    //so add it
                    query_params = self.joinUrlParam(query_params, "lang="+self.lang_code);
                }

                self.ajax_results_conf['processing_url'] = self.addUrlParam(self.ajax_url, query_params);
                //self.ajax_results_conf['data_type'] = 'json';

            }
            else if(self.display_result_method=="post_type_archive")
            {
                process_form.setTaxArchiveResultsUrl(self, self.results_url);
                var results_url = process_form.getResultsUrl(self, self.results_url);

                self.ajax_results_conf['results_url'] = self.addUrlParam(results_url, query_params);
                self.ajax_results_conf['processing_url'] = self.addUrlParam(results_url, query_params);

            }
            else if(self.display_result_method=="custom_woocommerce_store")
            {
                process_form.setTaxArchiveResultsUrl(self, self.results_url);
                var results_url = process_form.getResultsUrl(self, self.results_url);

                self.ajax_results_conf['results_url'] = self.addUrlParam(results_url, query_params);
                self.ajax_results_conf['processing_url'] = self.addUrlParam(results_url, query_params);

            }
            else
            {//otherwise we want to pull the results directly from the results page
                self.ajax_results_conf['results_url'] = self.addUrlParam(self.results_url, query_params);
                self.ajax_results_conf['processing_url'] = self.addUrlParam(self.ajax_url, query_params);
                //self.ajax_results_conf['data_type'] = 'html';
            }

            self.ajax_results_conf['processing_url'] = self.addQueryParams(self.ajax_results_conf['processing_url'], self.extra_query_params['ajax']);

            self.ajax_results_conf['data_type'] = self.ajax_data_type;
        };



        this.updateLoaderTag = function($object, tagName) {

            var $parent;

            if(self.infinite_scroll_result_class!="")
            {
                $parent = self.$infinite_scroll_container.find(self.infinite_scroll_result_class).last().parent();
            }
            else
            {
                $parent = self.$infinite_scroll_container;
            }

            var tagName = $parent.prop("tagName");

            var tagType = 'div';
            if( ( tagName.toLowerCase() == 'ol' ) || ( tagName.toLowerCase() == 'ul' ) ){
                tagType = 'li';
            }

            var $new = $('<'+tagType+' />').html($object.html());
            var attributes = $object.prop("attributes");

            // loop through <select> attributes and apply them on <div>
            $.each(attributes, function() {
                $new.attr(this.name, this.value);
            });

            return $new;

        }


        this.loadMoreResults = function()
        {
            if ( this.is_max_paged === true ) {
                return;
            }
            self.is_loading_more = true;

            //trigger start event
            var event_data = {
                sfid: self.sfid,
                targetSelector: self.ajax_target_attr,
                type: "load_more",
                object: self
            };

            self.triggerEvent("sf:ajaxstart", event_data);
            process_form.setTaxArchiveResultsUrl(self, self.results_url);
            console.log("load more results");
            console.log("results url: "+self.results_url);
            var query_params = self.getUrlParams(true);
            self.last_submit_query_params = self.getUrlParams(false); //grab a copy of hte URL params without pagination already added

            var ajax_processing_url = "";
            var ajax_results_url = "";
            var data_type = "";


            //now add the new pagination
            var next_paged_number = this.current_paged + 1;
            query_params = self.joinUrlParam(query_params, "sf_paged="+next_paged_number);

            self.setAjaxResultsURLs(query_params);
            ajax_processing_url = self.ajax_results_conf['processing_url'];
            ajax_results_url = self.ajax_results_conf['results_url'];
            data_type = self.ajax_results_conf['data_type'];

            //abort any previous ajax requests
            if(self.last_ajax_request)
            {
                self.last_ajax_request.abort();
            }

            if(self.use_scroll_loader==1)
            {
                var $loader = $('<div/>',{
                    'class': 'search-filter-scroll-loading'
                });//.appendTo(self.$ajax_results_container);

                $loader = self.updateLoaderTag($loader);

                self.infiniteScrollAppend($loader);
            }
            console.log("ajax_processing_url: "+ajax_processing_url);
            self.last_ajax_request = $.get(ajax_processing_url, function(data, status, request)
            {
                self.current_paged++;
                self.last_ajax_request = null;

                // **************
                // TODO - PASTE THIS AND WATCH THE REDIRECT - ONLY HAPPENS WITH WC (CPT AND TAX DOES NOT)
                // https://search-filter.test/product-category/clothing/tshirts/page/3/?sf_paged=3

                //updates the resutls & form html
                self.addResults(data, data_type);

            }, data_type).fail(function(jqXHR, textStatus, errorThrown)
            {
                var data = {};
                data.sfid = self.sfid;
                data.object = self;
                data.targetSelector = self.ajax_target_attr;
                data.ajaxURL = ajax_processing_url;
                data.jqXHR = jqXHR;
                data.textStatus = textStatus;
                data.errorThrown = errorThrown;
                self.triggerEvent("sf:ajaxerror", data);

            }).always(function()
            {
                var data = {};
                data.sfid = self.sfid;
                data.targetSelector = self.ajax_target_attr;
                data.object = self;

                if(self.use_scroll_loader==1)
                {
                    $loader.detach();
                }

                self.is_loading_more = false;

                self.triggerEvent("sf:ajaxfinish", data);
            });

        }
        this.fetchAjaxResults = function()
        {
            //trigger start event
            var event_data = {
                sfid: self.sfid,
                targetSelector: self.ajax_target_attr,
                type: "load_results",
                object: self
            };

            self.triggerEvent("sf:ajaxstart", event_data);

            //refocus any input fields after the form has been updated
            var $last_active_input_text = $this.find('input[type="text"]:focus').not(".sf-datepicker");
            if($last_active_input_text.length==1)
            {
                var last_active_input_text = $last_active_input_text.attr("name");
            }

            $this.addClass("search-filter-disabled");
            process_form.disableInputs(self);

            //fade out results
            self.$ajax_results_container.animate({ opacity: 0.5 }, "fast"); //loading
            self.fadeContentAreas( "out" );

            if(self.ajax_action=="pagination")
            {
                //need to remove active filter from URL

                //query_params = self.last_submit_query_params;

                //now add the new pagination
                var pageNumber = self.$ajax_results_container.attr("data-paged");

                if(typeof(pageNumber)=="undefined")
                {
                    pageNumber = 1;
                }
                process_form.setTaxArchiveResultsUrl(self, self.results_url);
                query_params = self.getUrlParams(false);

                if(pageNumber>1)
                {
                    query_params = self.joinUrlParam(query_params, "sf_paged="+pageNumber);
                }

            }
            else if(self.ajax_action=="submit")
            {
                var query_params = self.getUrlParams(true);
                self.last_submit_query_params = self.getUrlParams(false); //grab a copy of hte URL params without pagination already added
            }

            var ajax_processing_url = "";
            var ajax_results_url = "";
            var data_type = "";

            self.setAjaxResultsURLs(query_params);
            ajax_processing_url = self.ajax_results_conf['processing_url'];
            ajax_results_url = self.ajax_results_conf['results_url'];
            data_type = self.ajax_results_conf['data_type'];


            //abort any previous ajax requests
            if(self.last_ajax_request)
            {
                self.last_ajax_request.abort();
            }
            var ajax_action = self.ajax_action;
            self.last_ajax_request = $.get(ajax_processing_url, function(data, status, request)
            {
                self.last_ajax_request = null;

                //updates the resutls & form html
                self.updateResults(data, data_type);

                // scroll 
                // set the var back to what it was before the ajax request nad the form re-init
                self.ajax_action = ajax_action;
                self.scrollResults( self.ajax_action );

                /* update URL */
                //update url before pagination, because we need to do some checks agains the URL for infinite scroll
                self.updateUrlHistory(ajax_results_url);

                //setup pagination
                self.setupAjaxPagination();

                self.isSubmitting = false;

                /* user def */
                self.initWooCommerceControls(); //woocommerce orderby


            }, data_type).fail(function(jqXHR, textStatus, errorThrown)
            {
                var data = {};
                data.sfid = self.sfid;
                data.targetSelector = self.ajax_target_attr;
                data.object = self;
                data.ajaxURL = ajax_processing_url;
                data.jqXHR = jqXHR;
                data.textStatus = textStatus;
                data.errorThrown = errorThrown;
                self.isSubmitting = false;
                self.triggerEvent("sf:ajaxerror", data);

            }).always(function()
            {
                self.$ajax_results_container.stop(true,true).animate({ opacity: 1}, "fast"); //finished loading
                self.fadeContentAreas( "in" );
                var data = {};
                data.sfid = self.sfid;
                data.targetSelector = self.ajax_target_attr;
                data.object = self;
                $this.removeClass("search-filter-disabled");
                process_form.enableInputs(self);

                //refocus the last active text field
                if(last_active_input_text!="")
                {
                    var $input = [];
                    self.$fields.each(function(){

                        var $active_input = $(this).find("input[name='"+last_active_input_text+"']");
                        if($active_input.length==1)
                        {
                            $input = $active_input;
                        }

                    });
                    if($input.length==1) {

                        $input.focus().val($input.val());
                        self.focusCampo($input[0]);
                    }
                }

                $this.find("input[name='_sf_search']").trigger('focus');
                self.triggerEvent("sf:ajaxfinish",  data );

            });
        };

        this.focusCampo = function(inputField){
            //var inputField = document.getElementById(id);
            if (inputField != null && inputField.value.length != 0){
                if (inputField.createTextRange){
                    var FieldRange = inputField.createTextRange();
                    FieldRange.moveStart('character',inputField.value.length);
                    FieldRange.collapse();
                    FieldRange.select();
                }else if (inputField.selectionStart || inputField.selectionStart == '0') {
                    var elemLen = inputField.value.length;
                    inputField.selectionStart = elemLen;
                    inputField.selectionEnd = elemLen;
                }
                inputField.blur();
                inputField.focus();
            } else{
                if ( inputField ) {
                    inputField.focus();
                }
                
            }
        }

        this.triggerEvent = function(eventname, data)
        {
            var $event_container = $(".searchandfilter[data-sf-form-id='"+self.sfid+"']");
            $event_container.trigger(eventname, [ data ]);
        }

        this.fetchAjaxForm = function()
        {
            //trigger start event
            var event_data = {
                sfid: self.sfid,
                targetSelector: self.ajax_target_attr,
                type: "form",
                object: self
            };

            self.triggerEvent("sf:ajaxformstart", [ event_data ]);

            $this.addClass("search-filter-disabled");
            process_form.disableInputs(self);

            var query_params = self.getUrlParams();

            if(self.lang_code!="")
            {
                //so add it
                query_params = self.joinUrlParam(query_params, "lang="+self.lang_code);
            }

            var ajax_processing_url = self.addUrlParam(self.ajax_form_url, query_params);
            var data_type = "json";


            //abort any previous ajax requests
            /*if(self.last_ajax_request)
             {
             self.last_ajax_request.abort();
             }*/


            //self.last_ajax_request =

            $.get(ajax_processing_url, function(data, status, request)
            {
                //self.last_ajax_request = null;

                //updates the resutls & form html
                self.updateForm(data, data_type);


            }, data_type).fail(function(jqXHR, textStatus, errorThrown)
            {
                var data = {};
                data.sfid = self.sfid;
                data.targetSelector = self.ajax_target_attr;
                data.object = self;
                data.ajaxURL = ajax_processing_url;
                data.jqXHR = jqXHR;
                data.textStatus = textStatus;
                data.errorThrown = errorThrown;
                self.triggerEvent("sf:ajaxerror", [ data ]);

            }).always(function()
            {
                var data = {};
                data.sfid = self.sfid;
                data.targetSelector = self.ajax_target_attr;
                data.object = self;

                $this.removeClass("search-filter-disabled");
                process_form.enableInputs(self);

                self.triggerEvent("sf:ajaxformfinish", [ data ]);
            });
        };

        this.copyListItemsContents = function($list_from, $list_to)
        {
            var self = this;

            //copy over child list items
            var li_contents_array = new Array();
            var from_attributes = new Array();

            var $from_fields = $list_from.find("> ul > li");

            $from_fields.each(function(i){

                li_contents_array.push($(this).html());

                var attributes = $(this).prop("attributes");
                from_attributes.push(attributes);

                //var field_name = $(this).attr("data-sf-field-name");
                //var to_field = $list_to.find("> ul > li[data-sf-field-name='"+field_name+"']");

                //self.copyAttributes($(this), $list_to, "data-sf-");

            });

            var li_it = 0;
            var $to_fields = $list_to.find("> ul > li");
            $to_fields.each(function(i){
                $(this).html(li_contents_array[li_it]);

                var $from_field = $($from_fields.get(li_it));

                var $to_field = $(this);
                $to_field.removeAttr("data-sf-taxonomy-archive");
                self.copyAttributes($from_field, $to_field);

                li_it++;
            });

            /*var $from_fields = $list_from.find(" ul > li");
             var $to_fields = $list_to.find(" > li");
             $from_fields.each(function(index, val){
             if($(this).hasAttribute("data-sf-taxonomy-archive"))
             {

             }
             });

             this.copyAttributes($list_from, $list_to);*/
        }

        this.updateFormAttributes = function($list_from, $list_to)
        {
            var from_attributes = $list_from.prop("attributes");
            // loop through <select> attributes and apply them on <div>

            var to_attributes = $list_to.prop("attributes");
            $.each(to_attributes, function() {
                $list_to.removeAttr(this.name);
            });

            $.each(from_attributes, function() {
                $list_to.attr(this.name, this.value);
            });

        }

        this.copyAttributes = function($from, $to, prefix)
        {
            if(typeof(prefix)=="undefined")
            {
                var prefix = "";
            }

            var from_attributes = $from.prop("attributes");

            var to_attributes = $to.prop("attributes");
            $.each(to_attributes, function() {

                if(prefix!="") {
                    if (this.name.indexOf(prefix) == 0) {
                        $to.removeAttr(this.name);
                    }
                }
                else
                {
                    //$to.removeAttr(this.name);
                }
            });

            $.each(from_attributes, function() {
                $to.attr(this.name, this.value);
            });
        }

        this.copyFormAttributes = function($from, $to)
        {
            $to.removeAttr("data-current-taxonomy-archive");
            this.copyAttributes($from, $to);

        }

        this.updateForm = function(data, data_type)
        {
            var self = this;

            if(data_type=="json")
            {//then we did a request to the ajax endpoint, so expect an object back

                if(typeof(data['form'])!=="undefined")
                {
                    //remove all events from S&F form
                    $this.off();

                    //refresh the form (auto count)
                    self.copyListItemsContents($(data['form']), $this);

                    //re init S&F class on the form
                    //$this.searchAndFilter();

                    //if ajax is enabled init the pagination

                    this.init(true);

                    if(self.is_ajax==1)
                    {
                        self.setupAjaxPagination();
                    }



                }
            }


        }
        this.addResults = function(data, data_type)
        {
            var self = this;

            if(data_type=="json")
            {//then we did a request to the ajax endpoint, so expect an object back
                //grab the results and load in
                //self.$ajax_results_container.append(data['results']);
                self.load_more_html = data['results'];
            }
            else if(data_type=="html")
            {//we are expecting the html of the results page back, so extract the html we need

                var $data_obj = $(data);

                //self.$infinite_scroll_container.append($data_obj.find(self.ajax_target_attr).html());
                self.load_more_html = $data_obj.find(self.ajax_target_attr).html();
            }

            var infinite_scroll_end = false;

            if($("<div>"+self.load_more_html+"</div>").find("[data-search-filter-action='infinite-scroll-end']").length>0)
            {
                infinite_scroll_end = true;
            }

            //if there is another selector for infinite scroll, find the contents of that instead
            if(self.infinite_scroll_container!="")
            {
                self.load_more_html = $("<div>"+self.load_more_html+"</div>").find(self.infinite_scroll_container).html();
            }
            if(self.infinite_scroll_result_class!="")
            {
                var $result_items = $("<div>"+self.load_more_html+"</div>").find(self.infinite_scroll_result_class);
                var $result_items_container = $('<div/>', {});
                $result_items_container.append($result_items);

                self.load_more_html = $result_items_container.html();
            }

            if(infinite_scroll_end)
            {//we found a data attribute signalling the last page so finish here

                self.is_max_paged = true;
                self.last_load_more_html = self.load_more_html;

                self.infiniteScrollAppend(self.load_more_html);

            }
            else if(self.last_load_more_html!==self.load_more_html)
            {
                //check to make sure the new html fetched is different
                self.last_load_more_html = self.load_more_html;
                self.infiniteScrollAppend(self.load_more_html);

            }
            else
            {//we received the same message again so don't add, and tell S&F that we're at the end..
                self.is_max_paged = true;
            }
        }


        this.infiniteScrollAppend = function($object)
        {
            if(self.infinite_scroll_result_class!="")
            {
                self.$infinite_scroll_container.find(self.infinite_scroll_result_class).last().after($object);
            }
            else
            {
               self.$infinite_scroll_container.append($object);
            }
        }


        this.updateResults = function(data, data_type)
        {
            var self = this;

            if(data_type=="json")
            {//then we did a request to the ajax endpoint, so expect an object back
                //grab the results and load in
                self.$ajax_results_container.html(data['results']);

                if(typeof(data['form'])!=="undefined")
                {
                    //remove all events from S&F form
                    $this.off();

                    //remove pagination
                    self.removeAjaxPagination();

                    //refresh the form (auto count)
                    self.copyListItemsContents($(data['form']), $this);

                    //update attributes on form
                    self.copyFormAttributes($(data['form']), $this);

                    //re init S&F class on the form
                    $this.searchAndFilter({'isInit': false});
                }
                else
                {
                    //$this.find("input").removeAttr("disabled");
                }
            }
            else if(data_type=="html") {//we are expecting the html of the results page back, so extract the html we need

                var $data_obj = $(data);

                self.$ajax_results_container.html($data_obj.find(self.ajax_target_attr).html());

                self.updateContentAreas( $data_obj );

                if (self.$ajax_results_container.find(".searchandfilter").length > 0)
                {//then there are search form(s) inside the results container, so re-init them

                    self.$ajax_results_container.find(".searchandfilter").searchAndFilter();
                }

                //if the current search form is not inside the results container, then proceed as normal and update the form
                if(self.$ajax_results_container.find(".searchandfilter[data-sf-form-id='" + self.sfid + "']").length==0) {

                    var $new_search_form = $data_obj.find(".searchandfilter[data-sf-form-id='" + self.sfid + "']");

                    if ($new_search_form.length == 1) {//then replace the search form with the new one

                        //remove all events from S&F form
                        $this.off();

                        //remove pagination
                        self.removeAjaxPagination();

                        //refresh the form (auto count)
                        self.copyListItemsContents($new_search_form, $this);

                        //update attributes on form
                        self.copyFormAttributes($new_search_form, $this);

                        //re init S&F class on the form
                        $this.searchAndFilter({'isInit': false});

                    }
                    else {

                        //$this.find("input").removeAttr("disabled");
                    }
                }
            }

            self.is_max_paged = false; //for infinite scroll
            self.current_paged = 1; //for infinite scroll
            self.setInfiniteScrollContainer();

        }

        this.updateContentAreas = function( $html_data ) {
            
            // add additional content areas
            if ( this.ajax_update_sections && this.ajax_update_sections.length ) {
                for (index = 0; index < this.ajax_update_sections.length; ++index) {
                    var selector = this.ajax_update_sections[index];
                    $( selector ).html( $html_data.find( selector ).html() );
                }
            }
        }
        this.fadeContentAreas = function( direction ) {
            
            var opacity = 0.5;
            if ( direction === "in" ) {
                opacity = 1;
            }

            if ( this.ajax_update_sections && this.ajax_update_sections.length ) {
                for (index = 0; index < this.ajax_update_sections.length; ++index) {
                    var selector = this.ajax_update_sections[index];
                    $( selector ).stop(true,true).animate( { opacity: opacity}, "fast" );
                }
            }
           
            
        }

        this.removeWooCommerceControls = function(){
            var $woo_orderby = $('.woocommerce-ordering .orderby');
            var $woo_orderby_form = $('.woocommerce-ordering');

            $woo_orderby_form.off();
            $woo_orderby.off();
        };

        this.addQueryParam = function(name, value, url_type){

            if(typeof(url_type)=="undefined")
            {
                var url_type = "all";
            }
            self.extra_query_params[url_type][name] = value;

        };

        this.initWooCommerceControls = function(){

            self.removeWooCommerceControls();

            var $woo_orderby = $('.woocommerce-ordering .orderby');
            var $woo_orderby_form = $('.woocommerce-ordering');

            var order_val = "";
            if($woo_orderby.length>0)
            {
                order_val = $woo_orderby.val();
            }
            else
            {
                order_val = self.getQueryParamFromURL("orderby", window.location.href);
            }

            if(order_val=="menu_order")
            {
                order_val = "";
            }

            if((order_val!="")&&(!!order_val))
            {
                self.extra_query_params.all.orderby = order_val;
            }


            $woo_orderby_form.on('submit', function(e)
            {
                e.preventDefault();
                //var form = e.target;
                return false;
            });

            $woo_orderby.on("change", function(e)
            {
                e.preventDefault();

                var val = $(this).val();
                if(val=="menu_order")
                {
                    val = "";
                }

                self.extra_query_params.all.orderby = val;

                $this.trigger("submit")

                return false;
            });

        }

        this.scrollResults = function()
        {
            var self = this;
            if((self.scroll_on_action==self.ajax_action)||(self.scroll_on_action=="all"))
            {
                self.scrollToPos(); //scroll the window if it has been set
                //self.ajax_action = "";
            }
        }

        this.updateUrlHistory = function(ajax_results_url)
        {
            var self = this;

            var use_history_api = 0;
            if (window.history && window.history.pushState)
            {
                use_history_api = $this.attr("data-use-history-api");
            }

            if((self.update_ajax_url==1)&&(use_history_api==1))
            {
                //now check if the browser supports history state push :)
                if (window.history && window.history.pushState)
                {
                    history.pushState(null, null, ajax_results_url);
                }
            }
        }
        this.removeAjaxPagination = function()
        {
            var self = this;

            if(typeof(self.ajax_links_selector)!="undefined")
            {
                var $ajax_links_object = jQuery(self.ajax_links_selector);

                if($ajax_links_object.length>0)
                {
                    $ajax_links_object.off();
                }
            }
        }

        this.getBaseUrl = function( url ) {
            //now see if we are on the URL we think...
            var url_parts = url.split("?");
            var url_base = "";

            if(url_parts.length>0)
            {
                url_base = url_parts[0];
            }
            else {
                url_base = url;
            }
            return url_base;
        }
        this.canFetchAjaxResults = function(fetch_type)
        {
            if(typeof(fetch_type)=="undefined")
            {
                var fetch_type = "";
            }

            var self = this;
            var fetch_ajax_results = false;

            if(self.is_ajax==1)
            {//then we will ajax submit the form

                //and if we can find the results container
                if(self.$ajax_results_container.length==1)
                {
                    fetch_ajax_results = true;
                }

                var results_url = self.results_url;  //
                var results_url_encoded = '';  //
                var current_url = window.location.href;

                //ignore # and everything after
                var hash_pos = window.location.href.indexOf('#');
                if(hash_pos!==-1){
                    current_url = window.location.href.substr(0, window.location.href.indexOf('#'));
                }

                if( ( ( self.display_result_method=="custom_woocommerce_store" ) || ( self.display_result_method=="post_type_archive" ) ) && ( self.enable_taxonomy_archives == 1 ) )
                {
                    if( self.current_taxonomy_archive !=="" )
                    {
                        fetch_ajax_results = true;
                        return fetch_ajax_results;
                    }

                    /*var results_url = process_form.getResultsUrl(self, self.results_url);
                     var active_tax = process_form.getActiveTax();
                     var query_params = self.getUrlParams(true, '', active_tax);*/
                }




                //now see if we are on the URL we think...
                var url_base = this.getBaseUrl( current_url );
                //var results_url_base = this.getBaseUrl( current_url );

                var lang = self.getQueryParamFromURL("lang", window.location.href);
                if((typeof(lang)!=="undefined")&&(lang!==null))
                {
                    url_base = self.addUrlParam(url_base, "lang="+lang);
                }

                var sfid = self.getQueryParamFromURL("sfid", window.location.href);

                //if sfid is a number
                if(Number(parseFloat(sfid)) == sfid)
                {
                    url_base = self.addUrlParam(url_base, "sfid="+sfid);
                }

                //if any of the 3 conditions are true, then its good to go
                // - 1 | if the url base == results_url
                // - 2 | if url base+ "/"  == results_url - in case of user error in the results URL
                // - 3 | if the results URL has url params, and the current url starts with the results URL 

                //trim any trailing slash for easier comparison:
                url_base = url_base.replace(/\/$/, '');
                results_url = results_url.replace(/\/$/, '');
                results_url_encoded = encodeURI(results_url);
                

                var current_url_contains_results_url = -1;
                if((url_base==results_url)||(url_base.toLowerCase()==results_url_encoded.toLowerCase())  ){
                    current_url_contains_results_url = 1;
                } else {
                    if ( results_url.indexOf( '?' ) !== -1 && current_url.lastIndexOf(results_url, 0) === 0 ) {
                        current_url_contains_results_url = 1;
                    }
                }

                if(self.only_results_ajax==1)
                {//if a user has chosen to only allow ajax on results pages (default behaviour)

                    if( current_url_contains_results_url > -1)
                    {//this means the current URL contains the results url, which means we can do ajax
                        fetch_ajax_results = true;
                    }
                    else
                    {
                        fetch_ajax_results = false;
                    }
                }
                else
                {
                    if(fetch_type=="pagination")
                    {
                        if( current_url_contains_results_url > -1)
                        {//this means the current URL contains the results url, which means we can do ajax

                        }
                        else
                        {
                            //don't ajax pagination when not on a S&F page
                            fetch_ajax_results = false;
                        }


                    }

                }
            }

            return fetch_ajax_results;
        }

        this.setupAjaxPagination = function()
        {
            //infinite scroll
            if(this.pagination_type==="infinite_scroll")
            {
                var infinite_scroll_end = false;
                if(self.$ajax_results_container.find("[data-search-filter-action='infinite-scroll-end']").length>0)
                {
                    infinite_scroll_end = true;
                    self.is_max_paged = true;
                }

                if(parseInt(this.instance_number)===1) {
                    $(window).off("scroll", self.onWindowScroll);

                    if (self.canFetchAjaxResults("pagination")) {
                        $(window).on("scroll", self.onWindowScroll);
                    }
                }
            }
            else if(typeof(self.ajax_links_selector)=="undefined") {
                return;
            }
            else {
                $(document).off('click', self.ajax_links_selector);
                $(document).off(self.ajax_links_selector);
                $(self.ajax_links_selector).off();

                $(document).on('click', self.ajax_links_selector, function(e){

                    if(self.canFetchAjaxResults("pagination"))
                    {
                        e.preventDefault();

                        var link = jQuery(this).attr('href');
                        self.ajax_action = "pagination";

                        var pageNumber = self.getPagedFromURL(link);

                        self.$ajax_results_container.attr("data-paged", pageNumber);

                        self.fetchAjaxResults();

                        return false;
                    }
                });
            }
        };

        this.getPagedFromURL = function(URL){

            var pagedVal = 1;
            //first test to see if we have "/page/4/" in the URL
            var tpVal = self.getQueryParamFromURL("sf_paged", URL);
            if((typeof(tpVal)=="string")||(typeof(tpVal)=="number"))
            {
                pagedVal = tpVal;
            }

            return pagedVal;
        };

        this.getQueryParamFromURL = function(name, URL){

            var qstring = "?"+URL.split('?')[1];
            if(typeof(qstring)!="undefined")
            {
                var val = decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(qstring)||[,""])[1].replace(/\+/g, '%20'))||null;
                return val;
            }
            return "";
        };



        this.formUpdated = function(e){

            //e.preventDefault();
            if(self.auto_update==1) {
                self.submitForm();
            }
            else if((self.auto_update==0)&&(self.auto_count_refresh_mode==1))
            {
                self.formUpdatedFetchAjax();
            }

            return false;
        };

        this.formUpdatedFetchAjax = function(){

            //loop through all the fields and build the URL
            self.fetchAjaxForm();


            return false;
        };

        //make any corrections/updates to fields before the submit completes
        this.setFields = function(e){

            //if(self.is_ajax==0) {

                //sometimes the form is submitted without the slider yet having updated, and as we get our values from
                //the slider and not inputs, we need to check it if needs to be set
                //only occurs if ajax is off, and autosubmit on
                self.$fields.each(function() {

                    var $field = $(this);

                    var range_display_values = $field.find('.sf-meta-range-slider').attr("data-display-values-as");//data-display-values-as="text"

                    if(range_display_values==="textinput") {

                        if($field.find(".meta-slider").length>0){

                        }
                        $field.find(".meta-slider").each(function (index) {

                            var slider_object = $(this)[0];
                            var $slider_el = $(this).closest(".sf-meta-range-slider");
                            //var minVal = $slider_el.attr("data-min");
                            //var maxVal = $slider_el.attr("data-max");
                            var minVal = $slider_el.find(".sf-range-min").val();
                            var maxVal = $slider_el.find(".sf-range-max").val();
                            slider_object.noUiSlider.set([minVal, maxVal]);

                        });
                    }
                });
            //}

        }

        //submit
        this.submitForm = function(e){

            //loop through all the fields and build the URL
            if(self.isSubmitting == true) {
                return false;
            }

            self.setFields();
            self.clearTimer();

            self.isSubmitting = true;

            process_form.setTaxArchiveResultsUrl(self, self.results_url);

            self.$ajax_results_container.attr("data-paged", 1); //init paged

            if(self.canFetchAjaxResults())
            {//then we will ajax submit the form

                self.ajax_action = "submit"; //so we know it wasn't pagination
                self.fetchAjaxResults();
            }
            else
            {//then we will simply redirect to the Results URL

                var results_url = process_form.getResultsUrl(self, self.results_url);
                var query_params = self.getUrlParams(true, '');
                results_url = self.addUrlParam(results_url, query_params);

                window.location.href = results_url;
            }

            return false;
        };
        this.resetForm = function(submit_form)
        {
            //unset all fields
            self.$fields.each(function(){

                var $field = $(this);
				
				$field.removeAttr("data-sf-taxonomy-archive");
				
                //standard field types
                $field.find("select:not([multiple='multiple']) > option:first-child").prop("selected", true);
                $field.find("select[multiple='multiple'] > option").prop("selected", false);
                $field.find("input[type='checkbox']").prop("checked", false);
                $field.find("> ul > li:first-child input[type='radio']").prop("checked", true);
                $field.find("input[type='text']").val("");
                $field.find(".sf-option-active").removeClass("sf-option-active");
                $field.find("> ul > li:first-child input[type='radio']").parent().addClass("sf-option-active"); //re add active class to first "default" option

                //number range - 2 number input fields
                $field.find("input[type='number']").each(function(index){

                    var $thisInput = $(this);

                    if($thisInput.parent().parent().hasClass("sf-meta-range")) {

                        if(index==0) {
                            $thisInput.val($thisInput.attr("min"));
                        }
                        else if(index==1) {
                            $thisInput.val($thisInput.attr("max"));
                        }
                    }

                });

                //meta / numbers with 2 inputs (from / to fields) - second input must be reset to max value
                var $meta_select_from_to = $field.find(".sf-meta-range-select-fromto");

                if($meta_select_from_to.length>0) {

                    var start_min = $meta_select_from_to.attr("data-min");
                    var start_max = $meta_select_from_to.attr("data-max");

                    $meta_select_from_to.find("select").each(function(index){

                        var $thisInput = $(this);

                        if(index==0) {

                            $thisInput.val(start_min);
                        }
                        else if(index==1) {
                            $thisInput.val(start_max);
                        }

                    });
                }

                var $meta_radio_from_to = $field.find(".sf-meta-range-radio-fromto");

                if($meta_radio_from_to.length>0)
                {
                    var start_min = $meta_radio_from_to.attr("data-min");
                    var start_max = $meta_radio_from_to.attr("data-max");

                    var $radio_groups = $meta_radio_from_to.find('.sf-input-range-radio');

                    $radio_groups.each(function(index){


                        var $radios = $(this).find(".sf-input-radio");
                        $radios.prop("checked", false);

                        if(index==0)
                        {
                            $radios.filter('[value="'+start_min+'"]').prop("checked", true);
                        }
                        else if(index==1)
                        {
                            $radios.filter('[value="'+start_max+'"]').prop("checked", true);
                        }

                    });

                }

                //number slider - noUiSlider
                $field.find(".meta-slider").each(function(index){

                    var slider_object = $(this)[0];
                    /*var slider_object = $container.find(".meta-slider")[0];
                     var slider_val = slider_object.noUiSlider.get();*/

                    var $slider_el = $(this).closest(".sf-meta-range-slider");
                    var minVal = $slider_el.attr("data-min");
                    var maxVal = $slider_el.attr("data-max");
                    slider_object.noUiSlider.set([minVal, maxVal]);

                });

                //need to see if any are combobox and act accordingly
                var $combobox = $field.find("select[data-combobox='1']");
                if($combobox.length>0)
                {
                    if (typeof $combobox.chosen != "undefined")
                    {
                        $combobox.trigger("chosen:updated"); //for chosen only
                    }
                    else
                    {
                        $combobox.val('');
                        $combobox.trigger('change.select2');
                    }
                }


            });
            self.clearTimer();



            if(submit_form=="always")
            {
                self.submitForm();
            }
            else if(submit_form=="never")
            {
                if(this.auto_count_refresh_mode==1)
                {
                    self.formUpdatedFetchAjax();
                }
            }
            else if(submit_form=="auto")
            {
                if(this.auto_update==true)
                {
                    self.submitForm();
                }
                else
                {
                    if(this.auto_count_refresh_mode==1)
                    {
                        self.formUpdatedFetchAjax();
                    }
                }
            }

        };

        this.init();

        var event_data = {};
        event_data.sfid = self.sfid;
        event_data.targetSelector = self.ajax_target_attr;
        event_data.object = this;
        if(opts.isInit)
        {
            self.triggerEvent("sf:init", event_data);
        }

    });
};

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3BsdWdpbi5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyJcclxudmFyICQgXHRcdFx0XHQ9ICh0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93WydqUXVlcnknXSA6IHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWxbJ2pRdWVyeSddIDogbnVsbCk7XHJcbnZhciBzdGF0ZSBcdFx0XHQ9IHJlcXVpcmUoJy4vc3RhdGUnKTtcclxudmFyIHByb2Nlc3NfZm9ybSBcdD0gcmVxdWlyZSgnLi9wcm9jZXNzX2Zvcm0nKTtcclxudmFyIG5vVWlTbGlkZXJcdFx0PSByZXF1aXJlKCdub3Vpc2xpZGVyJyk7XHJcbi8vdmFyIGNvb2tpZXMgICAgICAgICA9IHJlcXVpcmUoJ2pzLWNvb2tpZScpO1xyXG52YXIgdGhpcmRQYXJ0eSAgICAgID0gcmVxdWlyZSgnLi90aGlyZHBhcnR5Jyk7XHJcblxyXG53aW5kb3cuc2VhcmNoQW5kRmlsdGVyID0ge1xyXG4gICAgZXh0ZW5zaW9uczogW10sXHJcbiAgICByZWdpc3RlckV4dGVuc2lvbjogZnVuY3Rpb24oIGV4dGVuc2lvbk5hbWUgKSB7XHJcbiAgICAgICAgdGhpcy5leHRlbnNpb25zLnB1c2goIGV4dGVuc2lvbk5hbWUgKTtcclxuICAgIH1cclxufTtcclxuXHJcbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24ob3B0aW9ucylcclxue1xyXG4gICAgdmFyIGRlZmF1bHRzID0ge1xyXG4gICAgICAgIHN0YXJ0T3BlbmVkOiBmYWxzZSxcclxuICAgICAgICBpc0luaXQ6IHRydWUsXHJcbiAgICAgICAgYWN0aW9uOiBcIlwiXHJcbiAgICB9O1xyXG5cclxuICAgIHZhciBvcHRzID0galF1ZXJ5LmV4dGVuZChkZWZhdWx0cywgb3B0aW9ucyk7XHJcbiAgICBcclxuICAgIHRoaXJkUGFydHkuaW5pdCgpO1xyXG4gICAgXHJcbiAgICAvL2xvb3AgdGhyb3VnaCBlYWNoIGl0ZW0gbWF0Y2hlZFxyXG4gICAgdGhpcy5lYWNoKGZ1bmN0aW9uKClcclxuICAgIHtcclxuXHJcbiAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcbiAgICAgICAgdGhpcy5zZmlkID0gJHRoaXMuYXR0cihcImRhdGEtc2YtZm9ybS1pZFwiKTtcclxuXHJcbiAgICAgICAgc3RhdGUuYWRkU2VhcmNoRm9ybSh0aGlzLnNmaWQsIHRoaXMpO1xyXG5cclxuICAgICAgICB0aGlzLiRmaWVsZHMgPSAkdGhpcy5maW5kKFwiPiB1bCA+IGxpXCIpOyAvL2EgcmVmZXJlbmNlIHRvIGVhY2ggZmllbGRzIHBhcmVudCBMSVxyXG5cclxuICAgICAgICB0aGlzLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcyA9ICR0aGlzLmF0dHIoJ2RhdGEtdGF4b25vbXktYXJjaGl2ZXMnKTtcclxuICAgICAgICB0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSA9ICR0aGlzLmF0dHIoJ2RhdGEtY3VycmVudC10YXhvbm9teS1hcmNoaXZlJyk7XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcyA9IFwiMFwiO1xyXG4gICAgICAgIH1cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgcHJvY2Vzc19mb3JtLmluaXQoc2VsZi5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMsIHNlbGYuY3VycmVudF90YXhvbm9teV9hcmNoaXZlKTtcclxuICAgICAgICAvL3Byb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmKTtcclxuICAgICAgICBwcm9jZXNzX2Zvcm0uZW5hYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5leHRyYV9xdWVyeV9wYXJhbXMpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5leHRyYV9xdWVyeV9wYXJhbXMgPSB7YWxsOiB7fSwgcmVzdWx0czoge30sIGFqYXg6IHt9fTtcclxuICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCA9ICR0aGlzLmF0dHIoXCJkYXRhLXRlbXBsYXRlLWxvYWRlZFwiKTtcclxuICAgICAgICB0aGlzLmlzX2FqYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4XCIpO1xyXG4gICAgICAgIHRoaXMuaW5zdGFuY2VfbnVtYmVyID0gJHRoaXMuYXR0cignZGF0YS1pbnN0YW5jZS1jb3VudCcpO1xyXG4gICAgICAgIHRoaXMuJGFqYXhfcmVzdWx0c19jb250YWluZXIgPSBqUXVlcnkoJHRoaXMuYXR0cihcImRhdGEtYWpheC10YXJnZXRcIikpO1xyXG5cclxuICAgICAgICB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC11cGRhdGUtc2VjdGlvbnNcIikgPyBKU09OLnBhcnNlKCAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXVwZGF0ZS1zZWN0aW9uc1wiKSApIDogW107XHJcbiAgICAgICAgXHJcbiAgICAgICAgdGhpcy5yZXN1bHRzX3VybCA9ICR0aGlzLmF0dHIoXCJkYXRhLXJlc3VsdHMtdXJsXCIpO1xyXG4gICAgICAgIHRoaXMuZGVidWdfbW9kZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWRlYnVnLW1vZGVcIik7XHJcbiAgICAgICAgdGhpcy51cGRhdGVfYWpheF91cmwgPSAkdGhpcy5hdHRyKFwiZGF0YS11cGRhdGUtYWpheC11cmxcIik7XHJcbiAgICAgICAgdGhpcy5wYWdpbmF0aW9uX3R5cGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXBhZ2luYXRpb24tdHlwZVwiKTtcclxuICAgICAgICB0aGlzLmF1dG9fY291bnQgPSAkdGhpcy5hdHRyKFwiZGF0YS1hdXRvLWNvdW50XCIpO1xyXG4gICAgICAgIHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1hdXRvLWNvdW50LXJlZnJlc2gtbW9kZVwiKTtcclxuICAgICAgICB0aGlzLm9ubHlfcmVzdWx0c19hamF4ID0gJHRoaXMuYXR0cihcImRhdGEtb25seS1yZXN1bHRzLWFqYXhcIik7IC8vaWYgd2UgYXJlIG5vdCBvbiB0aGUgcmVzdWx0cyBwYWdlLCByZWRpcmVjdCByYXRoZXIgdGhhbiB0cnkgdG8gbG9hZCB2aWEgYWpheFxyXG4gICAgICAgIHRoaXMuc2Nyb2xsX3RvX3BvcyA9ICR0aGlzLmF0dHIoXCJkYXRhLXNjcm9sbC10by1wb3NcIik7XHJcbiAgICAgICAgdGhpcy5jdXN0b21fc2Nyb2xsX3RvID0gJHRoaXMuYXR0cihcImRhdGEtY3VzdG9tLXNjcm9sbC10b1wiKTtcclxuICAgICAgICB0aGlzLnNjcm9sbF9vbl9hY3Rpb24gPSAkdGhpcy5hdHRyKFwiZGF0YS1zY3JvbGwtb24tYWN0aW9uXCIpO1xyXG4gICAgICAgIHRoaXMubGFuZ19jb2RlID0gJHRoaXMuYXR0cihcImRhdGEtbGFuZy1jb2RlXCIpO1xyXG4gICAgICAgIHRoaXMuYWpheF91cmwgPSAkdGhpcy5hdHRyKCdkYXRhLWFqYXgtdXJsJyk7XHJcbiAgICAgICAgdGhpcy5hamF4X2Zvcm1fdXJsID0gJHRoaXMuYXR0cignZGF0YS1hamF4LWZvcm0tdXJsJyk7XHJcbiAgICAgICAgdGhpcy5pc19ydGwgPSAkdGhpcy5hdHRyKCdkYXRhLWlzLXJ0bCcpO1xyXG5cclxuICAgICAgICB0aGlzLmRpc3BsYXlfcmVzdWx0X21ldGhvZCA9ICR0aGlzLmF0dHIoJ2RhdGEtZGlzcGxheS1yZXN1bHQtbWV0aG9kJyk7XHJcbiAgICAgICAgdGhpcy5tYWludGFpbl9zdGF0ZSA9ICR0aGlzLmF0dHIoJ2RhdGEtbWFpbnRhaW4tc3RhdGUnKTtcclxuICAgICAgICB0aGlzLmFqYXhfYWN0aW9uID0gXCJcIjtcclxuICAgICAgICB0aGlzLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IFwiXCI7XHJcblxyXG4gICAgICAgIHRoaXMuY3VycmVudF9wYWdlZCA9IHBhcnNlSW50KCR0aGlzLmF0dHIoJ2RhdGEtaW5pdC1wYWdlZCcpKTtcclxuICAgICAgICB0aGlzLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBcIlwiO1xyXG4gICAgICAgIHRoaXMubG9hZF9tb3JlX2h0bWwgPSBcIlwiO1xyXG4gICAgICAgIHRoaXMuYWpheF9kYXRhX3R5cGUgPSAkdGhpcy5hdHRyKCdkYXRhLWFqYXgtZGF0YS10eXBlJyk7XHJcbiAgICAgICAgdGhpcy5hamF4X3RhcmdldF9hdHRyID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC10YXJnZXRcIik7XHJcbiAgICAgICAgdGhpcy51c2VfaGlzdG9yeV9hcGkgPSAkdGhpcy5hdHRyKFwiZGF0YS11c2UtaGlzdG9yeS1hcGlcIik7XHJcbiAgICAgICAgdGhpcy5pc19zdWJtaXR0aW5nID0gZmFsc2U7XHJcblxyXG4gICAgICAgIHRoaXMubGFzdF9hamF4X3JlcXVlc3QgPSBudWxsO1xyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy51c2VfaGlzdG9yeV9hcGkpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy51c2VfaGlzdG9yeV9hcGkgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMucGFnaW5hdGlvbl90eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMucGFnaW5hdGlvbl90eXBlID0gXCJub3JtYWxcIjtcclxuICAgICAgICB9XHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuY3VycmVudF9wYWdlZCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmN1cnJlbnRfcGFnZWQgPSAxO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF90YXJnZXRfYXR0cik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmFqYXhfdGFyZ2V0X2F0dHIgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF91cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hamF4X3VybCA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5hamF4X2Zvcm1fdXJsKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF9mb3JtX3VybCA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5yZXN1bHRzX3VybCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnJlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnNjcm9sbF90b19wb3MpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5zY3JvbGxfdG9fcG9zID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnNjcm9sbF9vbl9hY3Rpb24pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5zY3JvbGxfb25fYWN0aW9uID0gXCJcIjtcclxuICAgICAgICB9XHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuY3VzdG9tX3Njcm9sbF90byk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmN1c3RvbV9zY3JvbGxfdG8gPSBcIlwiO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLiRjdXN0b21fc2Nyb2xsX3RvID0galF1ZXJ5KHRoaXMuY3VzdG9tX3Njcm9sbF90byk7XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnVwZGF0ZV9hamF4X3VybCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnVwZGF0ZV9hamF4X3VybCA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5kZWJ1Z19tb2RlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuZGVidWdfbW9kZSA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5hamF4X3RhcmdldF9vYmplY3QpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hamF4X3RhcmdldF9vYmplY3QgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMudGVtcGxhdGVfaXNfbG9hZGVkKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMudGVtcGxhdGVfaXNfbG9hZGVkID0gXCIwXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlID0gXCIwXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmFqYXhfbGlua3Nfc2VsZWN0b3IgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LWxpbmtzLXNlbGVjdG9yXCIpO1xyXG5cclxuXHJcbiAgICAgICAgdGhpcy5hdXRvX3VwZGF0ZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWF1dG8tdXBkYXRlXCIpO1xyXG4gICAgICAgIHRoaXMuaW5wdXRUaW1lciA9IDA7XHJcblxyXG4gICAgICAgIHRoaXMuc2V0SW5maW5pdGVTY3JvbGxDb250YWluZXIgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvLyBXaGVuIHdlIG5hdmlnYXRlIGF3YXkgZnJvbSBzZWFyY2ggcmVzdWx0cywgYW5kIHRoZW4gcHJlc3MgYmFjayxcclxuICAgICAgICAgICAgLy8gaXNfbWF4X3BhZ2VkIGlzIHJldGFpbmVkLCBzbyB3ZSBvbmx5IHdhbnQgdG8gc2V0IGl0IHRvIGZhbHNlIGlmXHJcbiAgICAgICAgICAgIC8vIHdlIGFyZSBpbml0YWxpemluZyB0aGUgcmVzdWx0cyBwYWdlIHRoZSBmaXJzdCB0aW1lIC0gc28ganVzdCBcclxuICAgICAgICAgICAgLy8gY2hlY2sgaWYgdGhpcyB2YXIgaXMgdW5kZWZpbmVkIChhcyBpdCBzaG91bGQgYmUgb24gZmlyc3QgdXNlKTtcclxuICAgICAgICAgICAgaWYgKCB0eXBlb2YgKCB0aGlzLmlzX21heF9wYWdlZCApID09PSAndW5kZWZpbmVkJyApIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaXNfbWF4X3BhZ2VkID0gZmFsc2U7IC8vZm9yIGxvYWQgbW9yZSBvbmx5LCBvbmNlIHdlIGRldGVjdCB3ZSdyZSBhdCB0aGUgZW5kIHNldCB0aGlzIHRvIHRydWVcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9ICR0aGlzLmF0dHIoJ2RhdGEtc2hvdy1zY3JvbGwtbG9hZGVyJyk7XHJcbiAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpO1xyXG4gICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLXRyaWdnZXInKTtcclxuICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzID0gJHRoaXMuYXR0cignZGF0YS1pbmZpbml0ZS1zY3JvbGwtcmVzdWx0LWNsYXNzJyk7XHJcbiAgICAgICAgICAgIHRoaXMuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSB0aGlzLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyO1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyID0galF1ZXJ5KCR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLnVzZV9zY3JvbGxfbG9hZGVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9IDE7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyKCk7XHJcblxyXG4gICAgICAgIC8qIGZ1bmN0aW9ucyAqL1xyXG5cclxuICAgICAgICB0aGlzLnJlc2V0ID0gZnVuY3Rpb24oc3VibWl0X2Zvcm0pXHJcbiAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgdGhpcy5yZXNldEZvcm0oc3VibWl0X2Zvcm0pO1xyXG4gICAgICAgICAgICByZXR1cm4gdHJ1ZTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuaW5wdXRVcGRhdGUgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGRlbGF5RHVyYXRpb24pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGVsYXlEdXJhdGlvbiA9IDMwMDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5yZXNldFRpbWVyKGRlbGF5RHVyYXRpb24pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zY3JvbGxUb1BvcyA9IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICB2YXIgb2Zmc2V0ID0gMDtcclxuICAgICAgICAgICAgdmFyIGNhblNjcm9sbCA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJ3aW5kb3dcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAwO1xyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImZvcm1cIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAkdGhpcy5vZmZzZXQoKS50b3A7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJyZXN1bHRzXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9mZnNldCA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIub2Zmc2V0KCkudG9wO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImN1c3RvbVwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vY3VzdG9tX3Njcm9sbF90b1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuJGN1c3RvbV9zY3JvbGxfdG8ubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSBzZWxmLiRjdXN0b21fc2Nyb2xsX3RvLm9mZnNldCgpLnRvcDtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgY2FuU2Nyb2xsID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoY2FuU2Nyb2xsKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCJodG1sLCBib2R5XCIpLnN0b3AoKS5hbmltYXRlKHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2Nyb2xsVG9wOiBvZmZzZXRcclxuICAgICAgICAgICAgICAgICAgICB9LCBcIm5vcm1hbFwiLCBcImVhc2VPdXRRdWFkXCIgKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmF0dGFjaEFjdGl2ZUNsYXNzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8vY2hlY2sgdG8gc2VlIGlmIHdlIGFyZSB1c2luZyBhamF4ICYgYXV0byBjb3VudFxyXG4gICAgICAgICAgICAvL2lmIG5vdCwgdGhlIHNlYXJjaCBmb3JtIGRvZXMgbm90IGdldCByZWxvYWRlZCwgc28gd2UgbmVlZCB0byB1cGRhdGUgdGhlIHNmLW9wdGlvbi1hY3RpdmUgY2xhc3Mgb24gYWxsIGZpZWxkc1xyXG5cclxuICAgICAgICAgICAgJHRoaXMub24oJ2NoYW5nZScsICdpbnB1dFt0eXBlPVwicmFkaW9cIl0sIGlucHV0W3R5cGU9XCJjaGVja2JveFwiXSwgc2VsZWN0JywgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyICRjdGhpcyA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGN0aGlzX3BhcmVudCA9ICRjdGhpcy5jbG9zZXN0KFwibGlbZGF0YS1zZi1maWVsZC1uYW1lXVwiKTtcclxuICAgICAgICAgICAgICAgIHZhciB0aGlzX3RhZyA9ICRjdGhpcy5wcm9wKFwidGFnTmFtZVwiKS50b0xvd2VyQ2FzZSgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIGlucHV0X3R5cGUgPSAkY3RoaXMuYXR0cihcInR5cGVcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgcGFyZW50X3RhZyA9ICRjdGhpc19wYXJlbnQucHJvcChcInRhZ05hbWVcIikudG9Mb3dlckNhc2UoKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigodGhpc190YWc9PVwiaW5wdXRcIikmJigoaW5wdXRfdHlwZT09XCJyYWRpb1wiKXx8KGlucHV0X3R5cGU9PVwiY2hlY2tib3hcIikpICYmIChwYXJlbnRfdGFnPT1cImxpXCIpKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2xpJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRhbGxfb3B0aW9uc19maWVsZHMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2lucHV0OmNoZWNrZWQnKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJGFsbF9vcHRpb25zLnJlbW92ZUNsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnNfZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkcGFyZW50ID0gJCh0aGlzKS5jbG9zZXN0KFwibGlcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRwYXJlbnQuYWRkQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHRoaXNfdGFnPT1cInNlbGVjdFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXMuY2hpbGRyZW4oKTtcclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnMucmVtb3ZlQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciB0aGlzX3ZhbCA9ICRjdGhpcy52YWwoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRoaXNfYXJyX3ZhbCA9ICh0eXBlb2YgdGhpc192YWwgPT0gJ3N0cmluZycgfHwgdGhpc192YWwgaW5zdGFuY2VvZiBTdHJpbmcpID8gW3RoaXNfdmFsXSA6IHRoaXNfdmFsO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkKHRoaXNfYXJyX3ZhbCkuZWFjaChmdW5jdGlvbihpLCB2YWx1ZSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjdGhpcy5maW5kKFwib3B0aW9uW3ZhbHVlPSdcIit2YWx1ZStcIiddXCIpLmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8qIGF1dG8gdXBkYXRlICovXHJcbiAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignY2hhbmdlJywgJ2lucHV0W3R5cGU9XCJyYWRpb1wiXSwgaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdLCBzZWxlY3QnLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgyMDApO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMub24oJ2lucHV0JywgJ2lucHV0W3R5cGU9XCJudW1iZXJcIl0nLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSg4MDApO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICR0ZXh0SW5wdXQgPSAkdGhpcy5maW5kKCdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgbGFzdFZhbHVlID0gJHRleHRJbnB1dC52YWwoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignaW5wdXQnLCAnaW5wdXRbdHlwZT1cInRleHRcIl06bm90KC5zZi1kYXRlcGlja2VyKScsIGZ1bmN0aW9uKClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZihsYXN0VmFsdWUhPSR0ZXh0SW5wdXQudmFsKCkpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEyMDApO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgbGFzdFZhbHVlID0gJHRleHRJbnB1dC52YWwoKTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbigna2V5cHJlc3MnLCAnaW5wdXRbdHlwZT1cInRleHRcIl06bm90KC5zZi1kYXRlcGlja2VyKScsIGZ1bmN0aW9uKGUpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGUud2hpY2ggPT0gMTMpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAvLyR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dC5zZi1kYXRlcGlja2VyJywgc2VsZi5kYXRlSW5wdXRUeXBlKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICAvL3RoaXMuaW5pdEF1dG9VcGRhdGVFdmVudHMoKTtcclxuXHJcblxyXG4gICAgICAgIHRoaXMuY2xlYXJUaW1lciA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGNsZWFyVGltZW91dChzZWxmLmlucHV0VGltZXIpO1xyXG4gICAgICAgIH07XHJcbiAgICAgICAgdGhpcy5yZXNldFRpbWVyID0gZnVuY3Rpb24oZGVsYXlEdXJhdGlvbilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGNsZWFyVGltZW91dChzZWxmLmlucHV0VGltZXIpO1xyXG4gICAgICAgICAgICBzZWxmLmlucHV0VGltZXIgPSBzZXRUaW1lb3V0KHNlbGYuZm9ybVVwZGF0ZWQsIGRlbGF5RHVyYXRpb24pO1xyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmFkZERhdGVQaWNrZXJzID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRkYXRlX3BpY2tlciA9ICR0aGlzLmZpbmQoXCIuc2YtZGF0ZXBpY2tlclwiKTtcclxuXHJcbiAgICAgICAgICAgIGlmKCRkYXRlX3BpY2tlci5sZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJGRhdGVfcGlja2VyLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZUZvcm1hdCA9IFwiXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGVEcm9wZG93blllYXIgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZURyb3Bkb3duTW9udGggPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRjbG9zZXN0X2RhdGVfd3JhcCA9ICR0aGlzLmNsb3Nlc3QoXCIuc2ZfZGF0ZV9maWVsZFwiKTtcclxuICAgICAgICAgICAgICAgICAgICBpZigkY2xvc2VzdF9kYXRlX3dyYXAubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlRm9ybWF0ID0gJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtZm9ybWF0XCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtdXNlLXllYXItZHJvcGRvd25cIik9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVEcm9wZG93blllYXIgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRjbG9zZXN0X2RhdGVfd3JhcC5hdHRyKFwiZGF0YS1kYXRlLXVzZS1tb250aC1kcm9wZG93blwiKT09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZURyb3Bkb3duTW9udGggPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZVBpY2tlck9wdGlvbnMgPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlubGluZTogdHJ1ZSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2hvd090aGVyTW9udGhzOiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBvblNlbGVjdDogZnVuY3Rpb24oZSwgZnJvbV9maWVsZCl7IHNlbGYuZGF0ZVNlbGVjdChlLCBmcm9tX2ZpZWxkLCAkKHRoaXMpKTsgfSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZUZvcm1hdDogZGF0ZUZvcm1hdCxcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNoYW5nZU1vbnRoOiBkYXRlRHJvcGRvd25Nb250aCxcclxuICAgICAgICAgICAgICAgICAgICAgICAgY2hhbmdlWWVhcjogZGF0ZURyb3Bkb3duWWVhclxyXG4gICAgICAgICAgICAgICAgICAgIH07XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZVBpY2tlck9wdGlvbnMuZGlyZWN0aW9uID0gXCJydGxcIjtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLmRhdGVwaWNrZXIoZGF0ZVBpY2tlck9wdGlvbnMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5zZXREZWZhdWx0cyhcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuZXh0ZW5kKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHsnZGF0ZUZvcm1hdCc6ZGF0ZUZvcm1hdH0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnJlZ2lvbmFsWyBzZWxmLmxhbmdfY29kZV1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIClcclxuICAgICAgICAgICAgICAgICAgICAgICAgKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5zZXREZWZhdWx0cyhcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuZXh0ZW5kKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHsnZGF0ZUZvcm1hdCc6ZGF0ZUZvcm1hdH0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnJlZ2lvbmFsW1wiZW5cIl1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIClcclxuICAgICAgICAgICAgICAgICAgICAgICAgKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCQoJy5sbC1za2luLW1lbG9uJykubGVuZ3RoPT0wKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJGRhdGVfcGlja2VyLmRhdGVwaWNrZXIoJ3dpZGdldCcpLndyYXAoJzxkaXYgY2xhc3M9XCJsbC1za2luLW1lbG9uIHNlYXJjaGFuZGZpbHRlci1kYXRlLXBpY2tlclwiLz4nKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmRhdGVTZWxlY3QgPSBmdW5jdGlvbihlLCBmcm9tX2ZpZWxkLCAkdGhpcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciAkaW5wdXRfZmllbGQgPSAkKGZyb21fZmllbGQuaW5wdXQuZ2V0KDApKTtcclxuICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuXHJcbiAgICAgICAgICAgIHZhciAkZGF0ZV9maWVsZHMgPSAkaW5wdXRfZmllbGQuY2xvc2VzdCgnW2RhdGEtc2YtZmllbGQtaW5wdXQtdHlwZT1cImRhdGVyYW5nZVwiXSwgW2RhdGEtc2YtZmllbGQtaW5wdXQtdHlwZT1cImRhdGVcIl0nKTtcclxuICAgICAgICAgICAgJGRhdGVfZmllbGRzLmVhY2goZnVuY3Rpb24oZSwgaW5kZXgpe1xyXG4gICAgICAgICAgICAgICAgXHJcbiAgICAgICAgICAgICAgICB2YXIgJHRmX2RhdGVfcGlja2VycyA9ICQodGhpcykuZmluZChcIi5zZi1kYXRlcGlja2VyXCIpO1xyXG4gICAgICAgICAgICAgICAgdmFyIG5vX2RhdGVfcGlja2VycyA9ICR0Zl9kYXRlX3BpY2tlcnMubGVuZ3RoO1xyXG4gICAgICAgICAgICAgICAgXHJcbiAgICAgICAgICAgICAgICBpZihub19kYXRlX3BpY2tlcnM+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3RoZW4gaXQgaXMgYSBkYXRlIHJhbmdlLCBzbyBtYWtlIHN1cmUgYm90aCBmaWVsZHMgYXJlIGZpbGxlZCBiZWZvcmUgdXBkYXRpbmdcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfY291bnRlciA9IDA7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRwX2VtcHR5X2ZpZWxkX2NvdW50ID0gMDtcclxuICAgICAgICAgICAgICAgICAgICAkdGZfZGF0ZV9waWNrZXJzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCQodGhpcykudmFsKCk9PVwiXCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRwX2VtcHR5X2ZpZWxkX2NvdW50Kys7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRwX2NvdW50ZXIrKztcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZHBfZW1wdHlfZmllbGRfY291bnQ9PTApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5hZGRSYW5nZVNsaWRlcnMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJG1ldGFfcmFuZ2UgPSAkdGhpcy5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJG1ldGFfcmFuZ2UubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRtZXRhX3JhbmdlLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWluID0gJHRoaXMuYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtaW4gPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRpc3BsYXlfdmFsdWVfYXMgPSAkdGhpcy5hdHRyKFwiZGF0YS1kaXNwbGF5LXZhbHVlcy1hc1wiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RlcCA9ICR0aGlzLmF0dHIoXCJkYXRhLXN0ZXBcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzdGFydF92YWwgPSAkdGhpcy5maW5kKCcuc2YtcmFuZ2UtbWluJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRlbmRfdmFsID0gJHRoaXMuZmluZCgnLnNmLXJhbmdlLW1heCcpO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRlY2ltYWxfcGxhY2VzID0gJHRoaXMuYXR0cihcImRhdGEtZGVjaW1hbC1wbGFjZXNcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRob3VzYW5kX3NlcGVyYXRvciA9ICR0aGlzLmF0dHIoXCJkYXRhLXRob3VzYW5kLXNlcGVyYXRvclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGVjaW1hbF9zZXBlcmF0b3IgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWNpbWFsLXNlcGVyYXRvclwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX2Zvcm1hdCA9IHdOdW1iKHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgbWFyazogZGVjaW1hbF9zZXBlcmF0b3IsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRlY2ltYWxzOiBwYXJzZUZsb2F0KGRlY2ltYWxfcGxhY2VzKSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhvdXNhbmQ6IHRob3VzYW5kX3NlcGVyYXRvclxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtaW4pO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21pbikpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21heCkpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtYXgpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9hbGVydChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KGRpc3BsYXlfdmFsdWVfYXMpO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0aW5wdXRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwudmFsKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC52YWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG5vVUlPcHRpb25zID0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByYW5nZToge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJ21pbic6IFsgcGFyc2VGbG9hdChtaW4pIF0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnbWF4JzogWyBwYXJzZUZsb2F0KG1heCkgXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzdGFydDogW21pbl9mb3JtYXR0ZWQsIG1heF9mb3JtYXR0ZWRdLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVzOiAyLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25uZWN0OiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzdGVwOiBwYXJzZUZsb2F0KHN0ZXApLFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgYmVoYXZpb3VyOiAnZXh0ZW5kLXRhcCcsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZvcm1hdDogZmllbGRfZm9ybWF0XHJcbiAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX3J0bD09MSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG5vVUlPcHRpb25zLmRpcmVjdGlvbiA9IFwicnRsXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX29iamVjdCA9ICQodGhpcykuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoIFwidW5kZWZpbmVkXCIgIT09IHR5cGVvZiggc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyICkgKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vZGVzdHJveSBpZiBpdCBleGlzdHMuLiB0aGlzIG1lYW5zIHNvbWVob3cgYW5vdGhlciBpbnN0YW5jZSBoYWQgaW5pdGlhbGlzZWQgaXQuLlxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZGVzdHJveSgpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgbm9VaVNsaWRlci5jcmVhdGUoc2xpZGVyX29iamVjdCwgbm9VSU9wdGlvbnMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLm9mZigpO1xyXG4gICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoWyQodGhpcykudmFsKCksIG51bGxdKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwub2ZmKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoW251bGwsICQodGhpcykudmFsKCldKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy8kc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8kZW5kX3ZhbC5odG1sKG1heF9mb3JtYXR0ZWQpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIub2ZmKCd1cGRhdGUnKTtcclxuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIub24oJ3VwZGF0ZScsIGZ1bmN0aW9uKCB2YWx1ZXMsIGhhbmRsZSApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfc3RhcnRfdmFsICA9IG1pbl9mb3JtYXR0ZWQ7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfZW5kX3ZhbCAgPSBtYXhfZm9ybWF0dGVkO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHZhbHVlID0gdmFsdWVzW2hhbmRsZV07XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCBoYW5kbGUgKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBtYXhfZm9ybWF0dGVkID0gdmFsdWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBtaW5fZm9ybWF0dGVkID0gdmFsdWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGRpc3BsYXlfdmFsdWVfYXM9PVwidGV4dGlucHV0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwudmFsKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwudmFsKG1heF9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwuaHRtbChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2kgdGhpbmsgdGhlIGZ1bmN0aW9uIHRoYXQgYnVpbGRzIHRoZSBVUkwgbmVlZHMgdG8gZGVjb2RlIHRoZSBmb3JtYXR0ZWQgc3RyaW5nIGJlZm9yZSBhZGRpbmcgdG8gdGhlIHVybFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigoc2VsZi5hdXRvX3VwZGF0ZT09MSl8fChzZWxmLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy9vbmx5IHRyeSB0byB1cGRhdGUgaWYgdGhlIHZhbHVlcyBoYXZlIGFjdHVhbGx5IGNoYW5nZWRcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmKChzbGlkZXJfc3RhcnRfdmFsIT1taW5fZm9ybWF0dGVkKXx8KHNsaWRlcl9lbmRfdmFsIT1tYXhfZm9ybWF0dGVkKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDgwMCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmNsZWFyVGltZXIoKTsgLy9pZ25vcmUgYW55IGNoYW5nZXMgcmVjZW50bHkgbWFkZSBieSB0aGUgc2xpZGVyICh0aGlzIHdhcyBqdXN0IGluaXQgc2hvdWxkbid0IGNvdW50IGFzIGFuIHVwZGF0ZSBldmVudClcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuaW5pdCA9IGZ1bmN0aW9uKGtlZXBfcGFnaW5hdGlvbilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihrZWVwX3BhZ2luYXRpb24pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIga2VlcF9wYWdpbmF0aW9uID0gZmFsc2U7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHRoaXMuaW5pdEF1dG9VcGRhdGVFdmVudHMoKTtcclxuICAgICAgICAgICAgdGhpcy5hdHRhY2hBY3RpdmVDbGFzcygpO1xyXG5cclxuICAgICAgICAgICAgdGhpcy5hZGREYXRlUGlja2VycygpO1xyXG4gICAgICAgICAgICB0aGlzLmFkZFJhbmdlU2xpZGVycygpO1xyXG5cclxuICAgICAgICAgICAgLy9pbml0IGNvbWJvIGJveGVzXHJcbiAgICAgICAgICAgIHZhciAkY29tYm9ib3ggPSAkdGhpcy5maW5kKFwic2VsZWN0W2RhdGEtY29tYm9ib3g9JzEnXVwiKTtcclxuXHJcbiAgICAgICAgICAgIGlmKCRjb21ib2JveC5sZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJGNvbWJvYm94LmVhY2goZnVuY3Rpb24oaW5kZXggKXtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNjYiA9ICQoIHRoaXMgKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbnJtID0gJHRoaXNjYi5hdHRyKFwiZGF0YS1jb21ib2JveC1ucm1cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmICh0eXBlb2YgJHRoaXNjYi5jaG9zZW4gIT0gXCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBjaG9zZW5vcHRpb25zID0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VhcmNoX2NvbnRhaW5zOiB0cnVlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH07XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigodHlwZW9mKG5ybSkhPT1cInVuZGVmaW5lZFwiKSYmKG5ybSkpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2hvc2Vub3B0aW9ucy5ub19yZXN1bHRzX3RleHQgPSBucm07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy8gc2FmZSB0byB1c2UgdGhlIGZ1bmN0aW9uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vc2VhcmNoX2NvbnRhaW5zXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLmFkZENsYXNzKFwiY2hvc2VuLXJ0bFwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNjYi5jaG9zZW4oY2hvc2Vub3B0aW9ucyk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgc2VsZWN0Mm9wdGlvbnMgPSB7fTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWxlY3Qyb3B0aW9ucy5kaXIgPSBcInJ0bFwiO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCh0eXBlb2YobnJtKSE9PVwidW5kZWZpbmVkXCIpJiYobnJtKSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWxlY3Qyb3B0aW9ucy5sYW5ndWFnZT0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwibm9SZXN1bHRzXCI6IGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBucm07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNjYi5zZWxlY3QyKHNlbGVjdDJvcHRpb25zKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG5cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIC8vaWYgYWpheCBpcyBlbmFibGVkIGluaXQgdGhlIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnNldHVwQWpheFBhZ2luYXRpb24oKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgJHRoaXMub24oXCJzdWJtaXRcIiwgdGhpcy5zdWJtaXRGb3JtKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMoKTsgLy93b29jb21tZXJjZSBvcmRlcmJ5XHJcblxyXG4gICAgICAgICAgICBpZihrZWVwX3BhZ2luYXRpb249PWZhbHNlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5vbldpbmRvd1Njcm9sbCA9IGZ1bmN0aW9uKGV2ZW50KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYoKCFzZWxmLmlzX2xvYWRpbmdfbW9yZSkgJiYgKCFzZWxmLmlzX21heF9wYWdlZCkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB3aW5kb3dfc2Nyb2xsID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHdpbmRvd19zY3JvbGxfYm90dG9tID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpICsgJCh3aW5kb3cpLmhlaWdodCgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHNjcm9sbF9vZmZzZXQgPSBwYXJzZUludChzZWxmLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfc2Nyb2xsX2JvdHRvbSA9IHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIub2Zmc2V0KCkudG9wICsgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5oZWlnaHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG9mZnNldCA9IChzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLm9mZnNldCgpLnRvcCArIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuaGVpZ2h0KCkpIC0gd2luZG93X3Njcm9sbDtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYod2luZG93X3Njcm9sbF9ib3R0b20gPiByZXN1bHRzX3Njcm9sbF9ib3R0b20gKyBzY3JvbGxfb2Zmc2V0KVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5sb2FkTW9yZVJlc3VsdHMoKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHsvL2RvbnQgbG9hZCBtb3JlXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zdHJpcFF1ZXJ5U3RyaW5nQW5kSGFzaEZyb21QYXRoID0gZnVuY3Rpb24odXJsKSB7XHJcbiAgICAgICAgICAgIHJldHVybiB1cmwuc3BsaXQoXCI/XCIpWzBdLnNwbGl0KFwiI1wiKVswXTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuZ3VwID0gZnVuY3Rpb24oIG5hbWUsIHVybCApIHtcclxuICAgICAgICAgICAgaWYgKCF1cmwpIHVybCA9IGxvY2F0aW9uLmhyZWZcclxuICAgICAgICAgICAgbmFtZSA9IG5hbWUucmVwbGFjZSgvW1xcW10vLFwiXFxcXFxcW1wiKS5yZXBsYWNlKC9bXFxdXS8sXCJcXFxcXFxdXCIpO1xyXG4gICAgICAgICAgICB2YXIgcmVnZXhTID0gXCJbXFxcXD8mXVwiK25hbWUrXCI9KFteJiNdKilcIjtcclxuICAgICAgICAgICAgdmFyIHJlZ2V4ID0gbmV3IFJlZ0V4cCggcmVnZXhTICk7XHJcbiAgICAgICAgICAgIHZhciByZXN1bHRzID0gcmVnZXguZXhlYyggdXJsICk7XHJcbiAgICAgICAgICAgIHJldHVybiByZXN1bHRzID09IG51bGwgPyBudWxsIDogcmVzdWx0c1sxXTtcclxuICAgICAgICB9O1xyXG5cclxuXHJcbiAgICAgICAgdGhpcy5nZXRVcmxQYXJhbXMgPSBmdW5jdGlvbihrZWVwX3BhZ2luYXRpb24sIHR5cGUsIGV4Y2x1ZGUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZih0eXBlb2Yoa2VlcF9wYWdpbmF0aW9uKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGtlZXBfcGFnaW5hdGlvbiA9IHRydWU7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih0eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHR5cGUgPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgdXJsX3BhcmFtc19zdHIgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgLy8gZ2V0IGFsbCBwYXJhbXMgZnJvbSBmaWVsZHNcclxuICAgICAgICAgICAgdmFyIHVybF9wYXJhbXNfYXJyYXkgPSBwcm9jZXNzX2Zvcm0uZ2V0VXJsUGFyYW1zKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKHVybF9wYXJhbXNfYXJyYXkpLmxlbmd0aDtcclxuICAgICAgICAgICAgdmFyIGNvdW50ID0gMDtcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihleGNsdWRlKSE9XCJ1bmRlZmluZWRcIikge1xyXG4gICAgICAgICAgICAgICAgaWYgKHVybF9wYXJhbXNfYXJyYXkuaGFzT3duUHJvcGVydHkoZXhjbHVkZSkpIHtcclxuICAgICAgICAgICAgICAgICAgICBsZW5ndGgtLTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYobGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gdXJsX3BhcmFtc19hcnJheSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICh1cmxfcGFyYW1zX2FycmF5Lmhhc093blByb3BlcnR5KGspKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgY2FuX2FkZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHR5cGVvZihleGNsdWRlKSE9XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYoaz09ZXhjbHVkZSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhbl9hZGQgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoY2FuX2FkZCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsX3BhcmFtc19zdHIgKz0gayArIFwiPVwiICsgdXJsX3BhcmFtc19hcnJheVtrXTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoY291bnQgPCBsZW5ndGggLSAxKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsX3BhcmFtc19zdHIgKz0gXCImXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY291bnQrKztcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICAvL2Zvcm0gcGFyYW1zIGFzIHVybCBxdWVyeSBzdHJpbmdcclxuICAgICAgICAgICAgdmFyIGZvcm1fcGFyYW1zID0gdXJsX3BhcmFtc19zdHI7XHJcblxyXG4gICAgICAgICAgICAvL2dldCB1cmwgcGFyYW1zIGZyb20gdGhlIGZvcm0gaXRzZWxmICh3aGF0IHRoZSB1c2VyIGhhcyBzZWxlY3RlZClcclxuICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBmb3JtX3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAvL2FkZCBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgIGlmKGtlZXBfcGFnaW5hdGlvbj09dHJ1ZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHBhZ2VOdW1iZXIgPSBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihwYWdlTnVtYmVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBwYWdlTnVtYmVyID0gMTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZihwYWdlTnVtYmVyPjEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK3BhZ2VOdW1iZXIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvL2FkZCBzZmlkXHJcbiAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmaWQ9XCIrc2VsZi5zZmlkKTtcclxuXHJcbiAgICAgICAgICAgIC8vIGxvb3AgdGhyb3VnaCBhbnkgZXh0cmEgcGFyYW1zIChmcm9tIGV4dCBwbHVnaW5zKSBhbmQgYWRkIHRvIHRoZSB1cmwgKGllIHdvb2NvbW1lcmNlIGBvcmRlcmJ5YClcclxuICAgICAgICAgICAgLyp2YXIgZXh0cmFfcXVlcnlfcGFyYW0gPSBcIlwiO1xyXG4gICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zKS5sZW5ndGg7XHJcbiAgICAgICAgICAgICB2YXIgY291bnQgPSAwO1xyXG5cclxuICAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxyXG4gICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMpIHtcclxuICAgICAgICAgICAgIGlmIChzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5oYXNPd25Qcm9wZXJ0eShrKSkge1xyXG5cclxuICAgICAgICAgICAgIGlmKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdIT1cIlwiKVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgZXh0cmFfcXVlcnlfcGFyYW0gPSBrK1wiPVwiK3NlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdO1xyXG4gICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBleHRyYV9xdWVyeV9wYXJhbSk7XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAqL1xyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmFkZFF1ZXJ5UGFyYW1zKHF1ZXJ5X3BhcmFtcywgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsKTtcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGUhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhxdWVyeV9wYXJhbXMsIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW3R5cGVdKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIHF1ZXJ5X3BhcmFtcztcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5hZGRRdWVyeVBhcmFtcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcywgbmV3X3BhcmFtcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBleHRyYV9xdWVyeV9wYXJhbSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyhuZXdfcGFyYW1zKS5sZW5ndGg7XHJcbiAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XHJcblxyXG4gICAgICAgICAgICBpZihsZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gbmV3X3BhcmFtcykge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChuZXdfcGFyYW1zLmhhc093blByb3BlcnR5KGspKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihuZXdfcGFyYW1zW2tdIT1cIlwiKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHRyYV9xdWVyeV9wYXJhbSA9IGsrXCI9XCIrbmV3X3BhcmFtc1trXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgZXh0cmFfcXVlcnlfcGFyYW0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gcXVlcnlfcGFyYW1zO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmFkZFVybFBhcmFtID0gZnVuY3Rpb24odXJsLCBzdHJpbmcpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgYWRkX3BhcmFtcyA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICBpZih1cmwhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHVybC5pbmRleE9mKFwiP1wiKSAhPSAtMSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vdXJsID0gdGhpcy50cmFpbGluZ1NsYXNoSXQodXJsKTtcclxuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiP1wiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gdXJsICsgYWRkX3BhcmFtcyArIHN0cmluZztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiB1cmw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmpvaW5VcmxQYXJhbSA9IGZ1bmN0aW9uKHBhcmFtcywgc3RyaW5nKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIGFkZF9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgaWYocGFyYW1zIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gcGFyYW1zICsgYWRkX3BhcmFtcyArIHN0cmluZztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiBwYXJhbXM7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLnNldEFqYXhSZXN1bHRzVVJMcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfcmVzdWx0c19jb25mKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZiA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gXCJcIjtcclxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIC8vaWYoc2VsZi5hamF4X3VybCE9XCJcIilcclxuICAgICAgICAgICAgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwic2hvcnRjb2RlXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2FudCB0byBkbyBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnRcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYucmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9hZGQgbGFuZyBjb2RlIHRvIGFqYXggYXBpIHJlcXVlc3QsIGxhbmcgY29kZSBzaG91bGQgYWxyZWFkeSBiZSBpbiB0aGVyZSBmb3Igb3RoZXIgcmVxdWVzdHMgKGllLCBzdXBwbGllZCBpbiB0aGUgUmVzdWx0cyBVUkwpXHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5sYW5nX2NvZGUhPVwiXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9zbyBhZGQgaXRcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwibGFuZz1cIitzZWxmLmxhbmdfY29kZSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5hamF4X3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIC8vc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSAnanNvbic7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwicG9zdF90eXBlX2FyY2hpdmVcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJjdXN0b21fd29vY29tbWVyY2Vfc3RvcmVcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly9vdGhlcndpc2Ugd2Ugd2FudCB0byBwdWxsIHRoZSByZXN1bHRzIGRpcmVjdGx5IGZyb20gdGhlIHJlc3VsdHMgcGFnZVxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5yZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF91cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gJ2h0bWwnO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1snYWpheCddKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gc2VsZi5hamF4X2RhdGFfdHlwZTtcclxuICAgICAgICB9O1xyXG5cclxuXHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlTG9hZGVyVGFnID0gZnVuY3Rpb24oJG9iamVjdCwgdGFnTmFtZSkge1xyXG5cclxuICAgICAgICAgICAgdmFyICRwYXJlbnQ7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRwYXJlbnQgPSBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKS5sYXN0KCkucGFyZW50KCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkcGFyZW50ID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHRhZ05hbWUgPSAkcGFyZW50LnByb3AoXCJ0YWdOYW1lXCIpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHRhZ1R5cGUgPSAnZGl2JztcclxuICAgICAgICAgICAgaWYoICggdGFnTmFtZS50b0xvd2VyQ2FzZSgpID09ICdvbCcgKSB8fCAoIHRhZ05hbWUudG9Mb3dlckNhc2UoKSA9PSAndWwnICkgKXtcclxuICAgICAgICAgICAgICAgIHRhZ1R5cGUgPSAnbGknO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgJG5ldyA9ICQoJzwnK3RhZ1R5cGUrJyAvPicpLmh0bWwoJG9iamVjdC5odG1sKCkpO1xyXG4gICAgICAgICAgICB2YXIgYXR0cmlidXRlcyA9ICRvYmplY3QucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcblxyXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggPHNlbGVjdD4gYXR0cmlidXRlcyBhbmQgYXBwbHkgdGhlbSBvbiA8ZGl2PlxyXG4gICAgICAgICAgICAkLmVhY2goYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAkbmV3LmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gJG5ldztcclxuXHJcbiAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5sb2FkTW9yZVJlc3VsdHMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZiAoIHRoaXMuaXNfbWF4X3BhZ2VkID09PSB0cnVlICkge1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHNlbGYuaXNfbG9hZGluZ19tb3JlID0gdHJ1ZTtcclxuXHJcbiAgICAgICAgICAgIC8vdHJpZ2dlciBzdGFydCBldmVudFxyXG4gICAgICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHtcclxuICAgICAgICAgICAgICAgIHNmaWQ6IHNlbGYuc2ZpZCxcclxuICAgICAgICAgICAgICAgIHRhcmdldFNlbGVjdG9yOiBzZWxmLmFqYXhfdGFyZ2V0X2F0dHIsXHJcbiAgICAgICAgICAgICAgICB0eXBlOiBcImxvYWRfbW9yZVwiLFxyXG4gICAgICAgICAgICAgICAgb2JqZWN0OiBzZWxmXHJcbiAgICAgICAgICAgIH07XHJcblxyXG4gICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhzdGFydFwiLCBldmVudF9kYXRhKTtcclxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICBjb25zb2xlLmxvZyhcImxvYWQgbW9yZSByZXN1bHRzXCIpO1xyXG4gICAgICAgICAgICBjb25zb2xlLmxvZyhcInJlc3VsdHMgdXJsOiBcIitzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUpO1xyXG4gICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTsgLy9ncmFiIGEgY29weSBvZiBodGUgVVJMIHBhcmFtcyB3aXRob3V0IHBhZ2luYXRpb24gYWxyZWFkeSBhZGRlZFxyXG5cclxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBcIlwiO1xyXG4gICAgICAgICAgICB2YXIgYWpheF9yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBkYXRhX3R5cGUgPSBcIlwiO1xyXG5cclxuXHJcbiAgICAgICAgICAgIC8vbm93IGFkZCB0aGUgbmV3IHBhZ2luYXRpb25cclxuICAgICAgICAgICAgdmFyIG5leHRfcGFnZWRfbnVtYmVyID0gdGhpcy5jdXJyZW50X3BhZ2VkICsgMTtcclxuICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK25leHRfcGFnZWRfbnVtYmVyKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuc2V0QWpheFJlc3VsdHNVUkxzKHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddO1xyXG4gICAgICAgICAgICBhamF4X3Jlc3VsdHNfdXJsID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXTtcclxuICAgICAgICAgICAgZGF0YV90eXBlID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ107XHJcblxyXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXHJcbiAgICAgICAgICAgIGlmKHNlbGYubGFzdF9hamF4X3JlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi51c2Vfc2Nyb2xsX2xvYWRlcj09MSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyICRsb2FkZXIgPSAkKCc8ZGl2Lz4nLHtcclxuICAgICAgICAgICAgICAgICAgICAnY2xhc3MnOiAnc2VhcmNoLWZpbHRlci1zY3JvbGwtbG9hZGluZydcclxuICAgICAgICAgICAgICAgIH0pOy8vLmFwcGVuZFRvKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIpO1xyXG5cclxuICAgICAgICAgICAgICAgICRsb2FkZXIgPSBzZWxmLnVwZGF0ZUxvYWRlclRhZygkbG9hZGVyKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmluZmluaXRlU2Nyb2xsQXBwZW5kKCRsb2FkZXIpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKFwiYWpheF9wcm9jZXNzaW5nX3VybDogXCIrYWpheF9wcm9jZXNzaW5nX3VybCk7XHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QgPSAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuY3VycmVudF9wYWdlZCsrO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLy8gKioqKioqKioqKioqKipcclxuICAgICAgICAgICAgICAgIC8vIFRPRE8gLSBQQVNURSBUSElTIEFORCBXQVRDSCBUSEUgUkVESVJFQ1QgLSBPTkxZIEhBUFBFTlMgV0lUSCBXQyAoQ1BUIEFORCBUQVggRE9FUyBOT1QpXHJcbiAgICAgICAgICAgICAgICAvLyBodHRwczovL3NlYXJjaC1maWx0ZXIudGVzdC9wcm9kdWN0LWNhdGVnb3J5L2Nsb3RoaW5nL3RzaGlydHMvcGFnZS8zLz9zZl9wYWdlZD0zXHJcblxyXG4gICAgICAgICAgICAgICAgLy91cGRhdGVzIHRoZSByZXN1dGxzICYgZm9ybSBodG1sXHJcbiAgICAgICAgICAgICAgICBzZWxmLmFkZFJlc3VsdHMoZGF0YSwgZGF0YV90eXBlKTtcclxuXHJcbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcclxuICAgICAgICAgICAgICAgIGRhdGEuanFYSFIgPSBqcVhIUjtcclxuICAgICAgICAgICAgICAgIGRhdGEudGV4dFN0YXR1cyA9IHRleHRTdGF0dXM7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBkYXRhKTtcclxuXHJcbiAgICAgICAgICAgIH0pLmFsd2F5cyhmdW5jdGlvbigpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHNlbGYudXNlX3Njcm9sbF9sb2FkZXI9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgJGxvYWRlci5kZXRhY2goKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzX2xvYWRpbmdfbW9yZSA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZpbmlzaFwiLCBkYXRhKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmZldGNoQWpheFJlc3VsdHMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcclxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XHJcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXHJcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogXCJsb2FkX3Jlc3VsdHNcIixcclxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxyXG4gICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4c3RhcnRcIiwgZXZlbnRfZGF0YSk7XHJcblxyXG4gICAgICAgICAgICAvL3JlZm9jdXMgYW55IGlucHV0IGZpZWxkcyBhZnRlciB0aGUgZm9ybSBoYXMgYmVlbiB1cGRhdGVkXHJcbiAgICAgICAgICAgIHZhciAkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dCA9ICR0aGlzLmZpbmQoJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOmZvY3VzJykubm90KFwiLnNmLWRhdGVwaWNrZXJcIik7XHJcbiAgICAgICAgICAgIGlmKCRsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0Lmxlbmd0aD09MSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGxhc3RfYWN0aXZlX2lucHV0X3RleHQgPSAkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dC5hdHRyKFwibmFtZVwiKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgJHRoaXMuYWRkQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZGlzYWJsZUlucHV0cyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgIC8vZmFkZSBvdXQgcmVzdWx0c1xyXG4gICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmFuaW1hdGUoeyBvcGFjaXR5OiAwLjUgfSwgXCJmYXN0XCIpOyAvL2xvYWRpbmdcclxuICAgICAgICAgICAgc2VsZi5mYWRlQ29udGVudEFyZWFzKCBcIm91dFwiICk7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmFqYXhfYWN0aW9uPT1cInBhZ2luYXRpb25cIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9uZWVkIHRvIHJlbW92ZSBhY3RpdmUgZmlsdGVyIGZyb20gVVJMXHJcblxyXG4gICAgICAgICAgICAgICAgLy9xdWVyeV9wYXJhbXMgPSBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcztcclxuXHJcbiAgICAgICAgICAgICAgICAvL25vdyBhZGQgdGhlIG5ldyBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKHBhZ2VOdW1iZXIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHBhZ2VOdW1iZXIgPSAxO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHBhZ2VOdW1iZXI+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrcGFnZU51bWJlcik7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5hamF4X2FjdGlvbj09XCJzdWJtaXRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7IC8vZ3JhYiBhIGNvcHkgb2YgaHRlIFVSTCBwYXJhbXMgd2l0aG91dCBwYWdpbmF0aW9uIGFscmVhZHkgYWRkZWRcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBcIlwiO1xyXG4gICAgICAgICAgICB2YXIgYWpheF9yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBkYXRhX3R5cGUgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ107XHJcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xyXG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcclxuXHJcblxyXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXHJcbiAgICAgICAgICAgIGlmKHNlbGYubGFzdF9hamF4X3JlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB2YXIgYWpheF9hY3Rpb24gPSBzZWxmLmFqYXhfYWN0aW9uO1xyXG4gICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gJC5nZXQoYWpheF9wcm9jZXNzaW5nX3VybCwgZnVuY3Rpb24oZGF0YSwgc3RhdHVzLCByZXF1ZXN0KVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlUmVzdWx0cyhkYXRhLCBkYXRhX3R5cGUpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vIHNjcm9sbCBcclxuICAgICAgICAgICAgICAgIC8vIHNldCB0aGUgdmFyIGJhY2sgdG8gd2hhdCBpdCB3YXMgYmVmb3JlIHRoZSBhamF4IHJlcXVlc3QgbmFkIHRoZSBmb3JtIHJlLWluaXRcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9hY3Rpb24gPSBhamF4X2FjdGlvbjtcclxuICAgICAgICAgICAgICAgIHNlbGYuc2Nyb2xsUmVzdWx0cyggc2VsZi5hamF4X2FjdGlvbiApO1xyXG5cclxuICAgICAgICAgICAgICAgIC8qIHVwZGF0ZSBVUkwgKi9cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlIHVybCBiZWZvcmUgcGFnaW5hdGlvbiwgYmVjYXVzZSB3ZSBuZWVkIHRvIGRvIHNvbWUgY2hlY2tzIGFnYWlucyB0aGUgVVJMIGZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlVXJsSGlzdG9yeShhamF4X3Jlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NldHVwIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gZmFsc2U7XHJcblxyXG4gICAgICAgICAgICAgICAgLyogdXNlciBkZWYgKi9cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMoKTsgLy93b29jb21tZXJjZSBvcmRlcmJ5XHJcblxyXG5cclxuICAgICAgICAgICAgfSwgZGF0YV90eXBlKS5mYWlsKGZ1bmN0aW9uKGpxWEhSLCB0ZXh0U3RhdHVzLCBlcnJvclRocm93bilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmFqYXhVUkwgPSBhamF4X3Byb2Nlc3NpbmdfdXJsO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5qcVhIUiA9IGpxWEhSO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50ZXh0U3RhdHVzID0gdGV4dFN0YXR1cztcclxuICAgICAgICAgICAgICAgIGRhdGEuZXJyb3JUaHJvd24gPSBlcnJvclRocm93bjtcclxuICAgICAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBkYXRhKTtcclxuXHJcbiAgICAgICAgICAgIH0pLmFsd2F5cyhmdW5jdGlvbigpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuc3RvcCh0cnVlLHRydWUpLmFuaW1hdGUoeyBvcGFjaXR5OiAxfSwgXCJmYXN0XCIpOyAvL2ZpbmlzaGVkIGxvYWRpbmdcclxuICAgICAgICAgICAgICAgIHNlbGYuZmFkZUNvbnRlbnRBcmVhcyggXCJpblwiICk7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuICAgICAgICAgICAgICAgICR0aGlzLnJlbW92ZUNsYXNzKFwic2VhcmNoLWZpbHRlci1kaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9yZWZvY3VzIHRoZSBsYXN0IGFjdGl2ZSB0ZXh0IGZpZWxkXHJcbiAgICAgICAgICAgICAgICBpZihsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0IT1cIlwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkaW5wdXQgPSBbXTtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmVfaW5wdXQgPSAkKHRoaXMpLmZpbmQoXCJpbnB1dFtuYW1lPSdcIitsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0K1wiJ11cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRhY3RpdmVfaW5wdXQubGVuZ3RoPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkaW5wdXQgPSAkYWN0aXZlX2lucHV0O1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKCRpbnB1dC5sZW5ndGg9PTEpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRpbnB1dC5mb2N1cygpLnZhbCgkaW5wdXQudmFsKCkpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZvY3VzQ2FtcG8oJGlucHV0WzBdKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMuZmluZChcImlucHV0W25hbWU9J19zZl9zZWFyY2gnXVwiKS50cmlnZ2VyKCdmb2N1cycpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZmluaXNoXCIsICBkYXRhICk7XHJcblxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmZvY3VzQ2FtcG8gPSBmdW5jdGlvbihpbnB1dEZpZWxkKXtcclxuICAgICAgICAgICAgLy92YXIgaW5wdXRGaWVsZCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlkKTtcclxuICAgICAgICAgICAgaWYgKGlucHV0RmllbGQgIT0gbnVsbCAmJiBpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aCAhPSAwKXtcclxuICAgICAgICAgICAgICAgIGlmIChpbnB1dEZpZWxkLmNyZWF0ZVRleHRSYW5nZSl7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIEZpZWxkUmFuZ2UgPSBpbnB1dEZpZWxkLmNyZWF0ZVRleHRSYW5nZSgpO1xyXG4gICAgICAgICAgICAgICAgICAgIEZpZWxkUmFuZ2UubW92ZVN0YXJ0KCdjaGFyYWN0ZXInLGlucHV0RmllbGQudmFsdWUubGVuZ3RoKTtcclxuICAgICAgICAgICAgICAgICAgICBGaWVsZFJhbmdlLmNvbGxhcHNlKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgRmllbGRSYW5nZS5zZWxlY3QoKTtcclxuICAgICAgICAgICAgICAgIH1lbHNlIGlmIChpbnB1dEZpZWxkLnNlbGVjdGlvblN0YXJ0IHx8IGlucHV0RmllbGQuc2VsZWN0aW9uU3RhcnQgPT0gJzAnKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGVsZW1MZW4gPSBpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aDtcclxuICAgICAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLnNlbGVjdGlvblN0YXJ0ID0gZWxlbUxlbjtcclxuICAgICAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLnNlbGVjdGlvbkVuZCA9IGVsZW1MZW47XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLmJsdXIoKTtcclxuICAgICAgICAgICAgICAgIGlucHV0RmllbGQuZm9jdXMoKTtcclxuICAgICAgICAgICAgfSBlbHNle1xyXG4gICAgICAgICAgICAgICAgaWYgKCBpbnB1dEZpZWxkICkge1xyXG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuZm9jdXMoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIFxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnRyaWdnZXJFdmVudCA9IGZ1bmN0aW9uKGV2ZW50bmFtZSwgZGF0YSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciAkZXZlbnRfY29udGFpbmVyID0gJChcIi5zZWFyY2hhbmRmaWx0ZXJbZGF0YS1zZi1mb3JtLWlkPSdcIitzZWxmLnNmaWQrXCInXVwiKTtcclxuICAgICAgICAgICAgJGV2ZW50X2NvbnRhaW5lci50cmlnZ2VyKGV2ZW50bmFtZSwgWyBkYXRhIF0pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5mZXRjaEFqYXhGb3JtID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XHJcbiAgICAgICAgICAgIHZhciBldmVudF9kYXRhID0ge1xyXG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxyXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcclxuICAgICAgICAgICAgICAgIHR5cGU6IFwiZm9ybVwiLFxyXG4gICAgICAgICAgICAgICAgb2JqZWN0OiBzZWxmXHJcbiAgICAgICAgICAgIH07XHJcblxyXG4gICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmb3Jtc3RhcnRcIiwgWyBldmVudF9kYXRhIF0pO1xyXG5cclxuICAgICAgICAgICAgJHRoaXMuYWRkQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZGlzYWJsZUlucHV0cyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcygpO1xyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi5sYW5nX2NvZGUhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vc28gYWRkIGl0XHJcbiAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwibGFuZz1cIitzZWxmLmxhbmdfY29kZSk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBhamF4X3Byb2Nlc3NpbmdfdXJsID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLmFqYXhfZm9ybV91cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgIHZhciBkYXRhX3R5cGUgPSBcImpzb25cIjtcclxuXHJcblxyXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXHJcbiAgICAgICAgICAgIC8qaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcclxuICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcclxuICAgICAgICAgICAgIH0qL1xyXG5cclxuXHJcbiAgICAgICAgICAgIC8vc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9XHJcblxyXG4gICAgICAgICAgICAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLy91cGRhdGVzIHRoZSByZXN1dGxzICYgZm9ybSBodG1sXHJcbiAgICAgICAgICAgICAgICBzZWxmLnVwZGF0ZUZvcm0oZGF0YSwgZGF0YV90eXBlKTtcclxuXHJcblxyXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgWyBkYXRhIF0pO1xyXG5cclxuICAgICAgICAgICAgfSkuYWx3YXlzKGZ1bmN0aW9uKClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMucmVtb3ZlQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmVuYWJsZUlucHV0cyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmb3JtZmluaXNoXCIsIFsgZGF0YSBdKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5jb3B5TGlzdEl0ZW1zQ29udGVudHMgPSBmdW5jdGlvbigkbGlzdF9mcm9tLCAkbGlzdF90bylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIC8vY29weSBvdmVyIGNoaWxkIGxpc3QgaXRlbXNcclxuICAgICAgICAgICAgdmFyIGxpX2NvbnRlbnRzX2FycmF5ID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgIHZhciBmcm9tX2F0dHJpYnV0ZXMgPSBuZXcgQXJyYXkoKTtcclxuXHJcbiAgICAgICAgICAgIHZhciAkZnJvbV9maWVsZHMgPSAkbGlzdF9mcm9tLmZpbmQoXCI+IHVsID4gbGlcIik7XHJcblxyXG4gICAgICAgICAgICAkZnJvbV9maWVsZHMuZWFjaChmdW5jdGlvbihpKXtcclxuXHJcbiAgICAgICAgICAgICAgICBsaV9jb250ZW50c19hcnJheS5wdXNoKCQodGhpcykuaHRtbCgpKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgYXR0cmlidXRlcyA9ICQodGhpcykucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcbiAgICAgICAgICAgICAgICBmcm9tX2F0dHJpYnV0ZXMucHVzaChhdHRyaWJ1dGVzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3ZhciBmaWVsZF9uYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG4gICAgICAgICAgICAgICAgLy92YXIgdG9fZmllbGQgPSAkbGlzdF90by5maW5kKFwiPiB1bCA+IGxpW2RhdGEtc2YtZmllbGQtbmFtZT0nXCIrZmllbGRfbmFtZStcIiddXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vc2VsZi5jb3B5QXR0cmlidXRlcygkKHRoaXMpLCAkbGlzdF90bywgXCJkYXRhLXNmLVwiKTtcclxuXHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgdmFyIGxpX2l0ID0gMDtcclxuICAgICAgICAgICAgdmFyICR0b19maWVsZHMgPSAkbGlzdF90by5maW5kKFwiPiB1bCA+IGxpXCIpO1xyXG4gICAgICAgICAgICAkdG9fZmllbGRzLmVhY2goZnVuY3Rpb24oaSl7XHJcbiAgICAgICAgICAgICAgICAkKHRoaXMpLmh0bWwobGlfY29udGVudHNfYXJyYXlbbGlfaXRdKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGZyb21fZmllbGQgPSAkKCRmcm9tX2ZpZWxkcy5nZXQobGlfaXQpKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJHRvX2ZpZWxkID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICR0b19maWVsZC5yZW1vdmVBdHRyKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5jb3B5QXR0cmlidXRlcygkZnJvbV9maWVsZCwgJHRvX2ZpZWxkKTtcclxuXHJcbiAgICAgICAgICAgICAgICBsaV9pdCsrO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgIC8qdmFyICRmcm9tX2ZpZWxkcyA9ICRsaXN0X2Zyb20uZmluZChcIiB1bCA+IGxpXCIpO1xyXG4gICAgICAgICAgICAgdmFyICR0b19maWVsZHMgPSAkbGlzdF90by5maW5kKFwiID4gbGlcIik7XHJcbiAgICAgICAgICAgICAkZnJvbV9maWVsZHMuZWFjaChmdW5jdGlvbihpbmRleCwgdmFsKXtcclxuICAgICAgICAgICAgIGlmKCQodGhpcykuaGFzQXR0cmlidXRlKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpKVxyXG4gICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgIHRoaXMuY29weUF0dHJpYnV0ZXMoJGxpc3RfZnJvbSwgJGxpc3RfdG8pOyovXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZUZvcm1BdHRyaWJ1dGVzID0gZnVuY3Rpb24oJGxpc3RfZnJvbSwgJGxpc3RfdG8pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gJGxpc3RfZnJvbS5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgLy8gbG9vcCB0aHJvdWdoIDxzZWxlY3Q+IGF0dHJpYnV0ZXMgYW5kIGFwcGx5IHRoZW0gb24gPGRpdj5cclxuXHJcbiAgICAgICAgICAgIHZhciB0b19hdHRyaWJ1dGVzID0gJGxpc3RfdG8ucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcbiAgICAgICAgICAgICQuZWFjaCh0b19hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICRsaXN0X3RvLnJlbW92ZUF0dHIodGhpcy5uYW1lKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAkLmVhY2goZnJvbV9hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICRsaXN0X3RvLmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5jb3B5QXR0cmlidXRlcyA9IGZ1bmN0aW9uKCRmcm9tLCAkdG8sIHByZWZpeClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihwcmVmaXgpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgcHJlZml4ID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGZyb21fYXR0cmlidXRlcyA9ICRmcm9tLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHRvX2F0dHJpYnV0ZXMgPSAkdG8ucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcbiAgICAgICAgICAgICQuZWFjaCh0b19hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihwcmVmaXghPVwiXCIpIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAodGhpcy5uYW1lLmluZGV4T2YocHJlZml4KSA9PSAwKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICR0by5yZW1vdmVBdHRyKHRoaXMubmFtZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vJHRvLnJlbW92ZUF0dHIodGhpcy5uYW1lKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAkLmVhY2goZnJvbV9hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICR0by5hdHRyKHRoaXMubmFtZSwgdGhpcy52YWx1ZSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5jb3B5Rm9ybUF0dHJpYnV0ZXMgPSBmdW5jdGlvbigkZnJvbSwgJHRvKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgJHRvLnJlbW92ZUF0dHIoXCJkYXRhLWN1cnJlbnQtdGF4b25vbXktYXJjaGl2ZVwiKTtcclxuICAgICAgICAgICAgdGhpcy5jb3B5QXR0cmlidXRlcygkZnJvbSwgJHRvKTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZUZvcm0gPSBmdW5jdGlvbihkYXRhLCBkYXRhX3R5cGUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgICAgICBpZihkYXRhX3R5cGU9PVwianNvblwiKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIGRpZCBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnQsIHNvIGV4cGVjdCBhbiBvYmplY3QgYmFja1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihkYXRhWydmb3JtJ10pIT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBhbGwgZXZlbnRzIGZyb20gUyZGIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUxpc3RJdGVtc0NvbnRlbnRzKCQoZGF0YVsnZm9ybSddKSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3JlIGluaXQgUyZGIGNsYXNzIG9uIHRoZSBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgLy8kdGhpcy5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9pZiBhamF4IGlzIGVuYWJsZWQgaW5pdCB0aGUgcGFnaW5hdGlvblxyXG5cclxuICAgICAgICAgICAgICAgICAgICB0aGlzLmluaXQodHJ1ZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuYWRkUmVzdWx0cyA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXHJcbiAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJlc3VsdHMgYW5kIGxvYWQgaW5cclxuICAgICAgICAgICAgICAgIC8vc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hcHBlbmQoZGF0YVsncmVzdWx0cyddKTtcclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSBkYXRhWydyZXN1bHRzJ107XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihkYXRhX3R5cGU9PVwiaHRtbFwiKVxyXG4gICAgICAgICAgICB7Ly93ZSBhcmUgZXhwZWN0aW5nIHRoZSBodG1sIG9mIHRoZSByZXN1bHRzIHBhZ2UgYmFjaywgc28gZXh0cmFjdCB0aGUgaHRtbCB3ZSBuZWVkXHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICRkYXRhX29iaiA9ICQoZGF0YSk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmFwcGVuZCgkZGF0YV9vYmouZmluZChzZWxmLmFqYXhfdGFyZ2V0X2F0dHIpLmh0bWwoKSk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxvYWRfbW9yZV9odG1sID0gJGRhdGFfb2JqLmZpbmQoc2VsZi5hamF4X3RhcmdldF9hdHRyKS5odG1sKCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBpbmZpbml0ZV9zY3JvbGxfZW5kID0gZmFsc2U7XHJcblxyXG4gICAgICAgICAgICBpZigkKFwiPGRpdj5cIitzZWxmLmxvYWRfbW9yZV9odG1sK1wiPC9kaXY+XCIpLmZpbmQoXCJbZGF0YS1zZWFyY2gtZmlsdGVyLWFjdGlvbj0naW5maW5pdGUtc2Nyb2xsLWVuZCddXCIpLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpbmZpbml0ZV9zY3JvbGxfZW5kID0gdHJ1ZTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy9pZiB0aGVyZSBpcyBhbm90aGVyIHNlbGVjdG9yIGZvciBpbmZpbml0ZSBzY3JvbGwsIGZpbmQgdGhlIGNvbnRlbnRzIG9mIHRoYXQgaW5zdGVhZFxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSAkKFwiPGRpdj5cIitzZWxmLmxvYWRfbW9yZV9odG1sK1wiPC9kaXY+XCIpLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyKS5odG1sKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgaWYoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJHJlc3VsdF9pdGVtcyA9ICQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpO1xyXG4gICAgICAgICAgICAgICAgdmFyICRyZXN1bHRfaXRlbXNfY29udGFpbmVyID0gJCgnPGRpdi8+Jywge30pO1xyXG4gICAgICAgICAgICAgICAgJHJlc3VsdF9pdGVtc19jb250YWluZXIuYXBwZW5kKCRyZXN1bHRfaXRlbXMpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lci5odG1sKCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKGluZmluaXRlX3Njcm9sbF9lbmQpXHJcbiAgICAgICAgICAgIHsvL3dlIGZvdW5kIGEgZGF0YSBhdHRyaWJ1dGUgc2lnbmFsbGluZyB0aGUgbGFzdCBwYWdlIHNvIGZpbmlzaCBoZXJlXHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2xvYWRfbW9yZV9odG1sID0gc2VsZi5sb2FkX21vcmVfaHRtbDtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmluZmluaXRlU2Nyb2xsQXBwZW5kKHNlbGYubG9hZF9tb3JlX2h0bWwpO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHNlbGYubGFzdF9sb2FkX21vcmVfaHRtbCE9PXNlbGYubG9hZF9tb3JlX2h0bWwpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vY2hlY2sgdG8gbWFrZSBzdXJlIHRoZSBuZXcgaHRtbCBmZXRjaGVkIGlzIGRpZmZlcmVudFxyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2xvYWRfbW9yZV9odG1sID0gc2VsZi5sb2FkX21vcmVfaHRtbDtcclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoc2VsZi5sb2FkX21vcmVfaHRtbCk7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgey8vd2UgcmVjZWl2ZWQgdGhlIHNhbWUgbWVzc2FnZSBhZ2FpbiBzbyBkb24ndCBhZGQsIGFuZCB0ZWxsIFMmRiB0aGF0IHdlJ3JlIGF0IHRoZSBlbmQuLlxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5pbmZpbml0ZVNjcm9sbEFwcGVuZCA9IGZ1bmN0aW9uKCRvYmplY3QpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpLmxhc3QoKS5hZnRlcigkb2JqZWN0KTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5hcHBlbmQoJG9iamVjdCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZVJlc3VsdHMgPSBmdW5jdGlvbihkYXRhLCBkYXRhX3R5cGUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgICAgICBpZihkYXRhX3R5cGU9PVwianNvblwiKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIGRpZCBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnQsIHNvIGV4cGVjdCBhbiBvYmplY3QgYmFja1xyXG4gICAgICAgICAgICAgICAgLy9ncmFiIHRoZSByZXN1bHRzIGFuZCBsb2FkIGluXHJcbiAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmh0bWwoZGF0YVsncmVzdWx0cyddKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZih0eXBlb2YoZGF0YVsnZm9ybSddKSE9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgYWxsIGV2ZW50cyBmcm9tIFMmRiBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgJHRoaXMub2ZmKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgICAgICBzZWxmLnJlbW92ZUFqYXhQYWdpbmF0aW9uKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVmcmVzaCB0aGUgZm9ybSAoYXV0byBjb3VudClcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlMaXN0SXRlbXNDb250ZW50cygkKGRhdGFbJ2Zvcm0nXSksICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy91cGRhdGUgYXR0cmlidXRlcyBvbiBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5Rm9ybUF0dHJpYnV0ZXMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmUgaW5pdCBTJkYgY2xhc3Mgb24gdGhlIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5zZWFyY2hBbmRGaWx0ZXIoeydpc0luaXQnOiBmYWxzZX0pO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vJHRoaXMuZmluZChcImlucHV0XCIpLnJlbW92ZUF0dHIoXCJkaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKGRhdGFfdHlwZT09XCJodG1sXCIpIHsvL3dlIGFyZSBleHBlY3RpbmcgdGhlIGh0bWwgb2YgdGhlIHJlc3VsdHMgcGFnZSBiYWNrLCBzbyBleHRyYWN0IHRoZSBodG1sIHdlIG5lZWRcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGRhdGFfb2JqID0gJChkYXRhKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmh0bWwoJGRhdGFfb2JqLmZpbmQoc2VsZi5hamF4X3RhcmdldF9hdHRyKS5odG1sKCkpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlQ29udGVudEFyZWFzKCAkZGF0YV9vYmogKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZiAoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlclwiKS5sZW5ndGggPiAwKVxyXG4gICAgICAgICAgICAgICAgey8vdGhlbiB0aGVyZSBhcmUgc2VhcmNoIGZvcm0ocykgaW5zaWRlIHRoZSByZXN1bHRzIGNvbnRhaW5lciwgc28gcmUtaW5pdCB0aGVtXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJcIikuc2VhcmNoQW5kRmlsdGVyKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgLy9pZiB0aGUgY3VycmVudCBzZWFyY2ggZm9ybSBpcyBub3QgaW5zaWRlIHRoZSByZXN1bHRzIGNvbnRhaW5lciwgdGhlbiBwcm9jZWVkIGFzIG5vcm1hbCBhbmQgdXBkYXRlIHRoZSBmb3JtXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyW2RhdGEtc2YtZm9ybS1pZD0nXCIgKyBzZWxmLnNmaWQgKyBcIiddXCIpLmxlbmd0aD09MCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJG5ld19zZWFyY2hfZm9ybSA9ICRkYXRhX29iai5maW5kKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiICsgc2VsZi5zZmlkICsgXCInXVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKCRuZXdfc2VhcmNoX2Zvcm0ubGVuZ3RoID09IDEpIHsvL3RoZW4gcmVwbGFjZSB0aGUgc2VhcmNoIGZvcm0gd2l0aCB0aGUgbmV3IG9uZVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgYWxsIGV2ZW50cyBmcm9tIFMmRiBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLm9mZigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLnJlbW92ZUFqYXhQYWdpbmF0aW9uKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3JlZnJlc2ggdGhlIGZvcm0gKGF1dG8gY291bnQpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUxpc3RJdGVtc0NvbnRlbnRzKCRuZXdfc2VhcmNoX2Zvcm0sICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vdXBkYXRlIGF0dHJpYnV0ZXMgb24gZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlGb3JtQXR0cmlidXRlcygkbmV3X3NlYXJjaF9mb3JtLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3JlIGluaXQgUyZGIGNsYXNzIG9uIHRoZSBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLnNlYXJjaEFuZEZpbHRlcih7J2lzSW5pdCc6IGZhbHNlfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vJHRoaXMuZmluZChcImlucHV0XCIpLnJlbW92ZUF0dHIoXCJkaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gZmFsc2U7IC8vZm9yIGluZmluaXRlIHNjcm9sbFxyXG4gICAgICAgICAgICBzZWxmLmN1cnJlbnRfcGFnZWQgPSAxOyAvL2ZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgc2VsZi5zZXRJbmZpbml0ZVNjcm9sbENvbnRhaW5lcigpO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlQ29udGVudEFyZWFzID0gZnVuY3Rpb24oICRodG1sX2RhdGEgKSB7XHJcbiAgICAgICAgICAgIFxyXG4gICAgICAgICAgICAvLyBhZGQgYWRkaXRpb25hbCBjb250ZW50IGFyZWFzXHJcbiAgICAgICAgICAgIGlmICggdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucyAmJiB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zLmxlbmd0aCApIHtcclxuICAgICAgICAgICAgICAgIGZvciAoaW5kZXggPSAwOyBpbmRleCA8IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoOyArK2luZGV4KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNlbGVjdG9yID0gdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9uc1tpbmRleF07XHJcbiAgICAgICAgICAgICAgICAgICAgJCggc2VsZWN0b3IgKS5odG1sKCAkaHRtbF9kYXRhLmZpbmQoIHNlbGVjdG9yICkuaHRtbCgpICk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5mYWRlQ29udGVudEFyZWFzID0gZnVuY3Rpb24oIGRpcmVjdGlvbiApIHtcclxuICAgICAgICAgICAgXHJcbiAgICAgICAgICAgIHZhciBvcGFjaXR5ID0gMC41O1xyXG4gICAgICAgICAgICBpZiAoIGRpcmVjdGlvbiA9PT0gXCJpblwiICkge1xyXG4gICAgICAgICAgICAgICAgb3BhY2l0eSA9IDE7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmICggdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucyAmJiB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zLmxlbmd0aCApIHtcclxuICAgICAgICAgICAgICAgIGZvciAoaW5kZXggPSAwOyBpbmRleCA8IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoOyArK2luZGV4KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNlbGVjdG9yID0gdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9uc1tpbmRleF07XHJcbiAgICAgICAgICAgICAgICAgICAgJCggc2VsZWN0b3IgKS5zdG9wKHRydWUsdHJ1ZSkuYW5pbWF0ZSggeyBvcGFjaXR5OiBvcGFjaXR5fSwgXCJmYXN0XCIgKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgIFxyXG4gICAgICAgICAgICBcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMucmVtb3ZlV29vQ29tbWVyY2VDb250cm9scyA9IGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnkgPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcgLm9yZGVyYnknKTtcclxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieV9mb3JtID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nJyk7XHJcblxyXG4gICAgICAgICAgICAkd29vX29yZGVyYnlfZm9ybS5vZmYoKTtcclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5Lm9mZigpO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuYWRkUXVlcnlQYXJhbSA9IGZ1bmN0aW9uKG5hbWUsIHZhbHVlLCB1cmxfdHlwZSl7XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YodXJsX3R5cGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgdXJsX3R5cGUgPSBcImFsbFwiO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW3VybF90eXBlXVtuYW1lXSA9IHZhbHVlO1xyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmluaXRXb29Db21tZXJjZUNvbnRyb2xzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIHNlbGYucmVtb3ZlV29vQ29tbWVyY2VDb250cm9scygpO1xyXG5cclxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZyAub3JkZXJieScpO1xyXG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5X2Zvcm0gPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcnKTtcclxuXHJcbiAgICAgICAgICAgIHZhciBvcmRlcl92YWwgPSBcIlwiO1xyXG4gICAgICAgICAgICBpZigkd29vX29yZGVyYnkubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9ICR3b29fb3JkZXJieS52YWwoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJvcmRlcmJ5XCIsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYob3JkZXJfdmFsPT1cIm1lbnVfb3JkZXJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgb3JkZXJfdmFsID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoKG9yZGVyX3ZhbCE9XCJcIikmJighIW9yZGVyX3ZhbCkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zLmFsbC5vcmRlcmJ5ID0gb3JkZXJfdmFsO1xyXG4gICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5X2Zvcm0ub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKGUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgICAgIC8vdmFyIGZvcm0gPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAkd29vX29yZGVyYnkub24oXCJjaGFuZ2VcIiwgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSAkKHRoaXMpLnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgaWYodmFsPT1cIm1lbnVfb3JkZXJcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YWwgPSBcIlwiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zLmFsbC5vcmRlcmJ5ID0gdmFsO1xyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLnRyaWdnZXIoXCJzdWJtaXRcIilcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuc2Nyb2xsUmVzdWx0cyA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICAgICAgaWYoKHNlbGYuc2Nyb2xsX29uX2FjdGlvbj09c2VsZi5hamF4X2FjdGlvbil8fChzZWxmLnNjcm9sbF9vbl9hY3Rpb249PVwiYWxsXCIpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnNjcm9sbFRvUG9zKCk7IC8vc2Nyb2xsIHRoZSB3aW5kb3cgaWYgaXQgaGFzIGJlZW4gc2V0XHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9hY3Rpb24gPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZVVybEhpc3RvcnkgPSBmdW5jdGlvbihhamF4X3Jlc3VsdHNfdXJsKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgdmFyIHVzZV9oaXN0b3J5X2FwaSA9IDA7XHJcbiAgICAgICAgICAgIGlmICh3aW5kb3cuaGlzdG9yeSAmJiB3aW5kb3cuaGlzdG9yeS5wdXNoU3RhdGUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHVzZV9oaXN0b3J5X2FwaSA9ICR0aGlzLmF0dHIoXCJkYXRhLXVzZS1oaXN0b3J5LWFwaVwiKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoKHNlbGYudXBkYXRlX2FqYXhfdXJsPT0xKSYmKHVzZV9oaXN0b3J5X2FwaT09MSkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vbm93IGNoZWNrIGlmIHRoZSBicm93c2VyIHN1cHBvcnRzIGhpc3Rvcnkgc3RhdGUgcHVzaCA6KVxyXG4gICAgICAgICAgICAgICAgaWYgKHdpbmRvdy5oaXN0b3J5ICYmIHdpbmRvdy5oaXN0b3J5LnB1c2hTdGF0ZSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBoaXN0b3J5LnB1c2hTdGF0ZShudWxsLCBudWxsLCBhamF4X3Jlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLnJlbW92ZUFqYXhQYWdpbmF0aW9uID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHNlbGYuYWpheF9saW5rc19zZWxlY3RvcikhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciAkYWpheF9saW5rc19vYmplY3QgPSBqUXVlcnkoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigkYWpheF9saW5rc19vYmplY3QubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgJGFqYXhfbGlua3Nfb2JqZWN0Lm9mZigpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmdldEJhc2VVcmwgPSBmdW5jdGlvbiggdXJsICkge1xyXG4gICAgICAgICAgICAvL25vdyBzZWUgaWYgd2UgYXJlIG9uIHRoZSBVUkwgd2UgdGhpbmsuLi5cclxuICAgICAgICAgICAgdmFyIHVybF9wYXJ0cyA9IHVybC5zcGxpdChcIj9cIik7XHJcbiAgICAgICAgICAgIHZhciB1cmxfYmFzZSA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICBpZih1cmxfcGFydHMubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHVybF9iYXNlID0gdXJsX3BhcnRzWzBdO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSB1cmw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgcmV0dXJuIHVybF9iYXNlO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmNhbkZldGNoQWpheFJlc3VsdHMgPSBmdW5jdGlvbihmZXRjaF90eXBlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGZldGNoX3R5cGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZmV0Y2hfdHlwZSA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICAgICAgdmFyIGZldGNoX2FqYXhfcmVzdWx0cyA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgYWpheCBzdWJtaXQgdGhlIGZvcm1cclxuXHJcbiAgICAgICAgICAgICAgICAvL2FuZCBpZiB3ZSBjYW4gZmluZCB0aGUgcmVzdWx0cyBjb250YWluZXJcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIubGVuZ3RoPT0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gc2VsZi5yZXN1bHRzX3VybDsgIC8vXHJcbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmxfZW5jb2RlZCA9ICcnOyAgLy9cclxuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3VybCA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vaWdub3JlICMgYW5kIGV2ZXJ5dGhpbmcgYWZ0ZXJcclxuICAgICAgICAgICAgICAgIHZhciBoYXNoX3BvcyA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmLmluZGV4T2YoJyMnKTtcclxuICAgICAgICAgICAgICAgIGlmKGhhc2hfcG9zIT09LTEpe1xyXG4gICAgICAgICAgICAgICAgICAgIGN1cnJlbnRfdXJsID0gd2luZG93LmxvY2F0aW9uLmhyZWYuc3Vic3RyKDAsIHdpbmRvdy5sb2NhdGlvbi5ocmVmLmluZGV4T2YoJyMnKSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoICggKCBzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJjdXN0b21fd29vY29tbWVyY2Vfc3RvcmVcIiApIHx8ICggc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwicG9zdF90eXBlX2FyY2hpdmVcIiApICkgJiYgKCBzZWxmLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcyA9PSAxICkgKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKCBzZWxmLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSAhPT1cIlwiIClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmZXRjaF9hamF4X3Jlc3VsdHM7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAvKnZhciByZXN1bHRzX3VybCA9IHByb2Nlc3NfZm9ybS5nZXRSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgICAgICB2YXIgYWN0aXZlX3RheCA9IHByb2Nlc3NfZm9ybS5nZXRBY3RpdmVUYXgoKTtcclxuICAgICAgICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUsICcnLCBhY3RpdmVfdGF4KTsqL1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgIC8vbm93IHNlZSBpZiB3ZSBhcmUgb24gdGhlIFVSTCB3ZSB0aGluay4uLlxyXG4gICAgICAgICAgICAgICAgdmFyIHVybF9iYXNlID0gdGhpcy5nZXRCYXNlVXJsKCBjdXJyZW50X3VybCApO1xyXG4gICAgICAgICAgICAgICAgLy92YXIgcmVzdWx0c191cmxfYmFzZSA9IHRoaXMuZ2V0QmFzZVVybCggY3VycmVudF91cmwgKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgbGFuZyA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJsYW5nXCIsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcclxuICAgICAgICAgICAgICAgIGlmKCh0eXBlb2YobGFuZykhPT1cInVuZGVmaW5lZFwiKSYmKGxhbmchPT1udWxsKSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHNlbGYuYWRkVXJsUGFyYW0odXJsX2Jhc2UsIFwibGFuZz1cIitsYW5nKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgc2ZpZCA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJzZmlkXCIsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL2lmIHNmaWQgaXMgYSBudW1iZXJcclxuICAgICAgICAgICAgICAgIGlmKE51bWJlcihwYXJzZUZsb2F0KHNmaWQpKSA9PSBzZmlkKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHVybF9iYXNlID0gc2VsZi5hZGRVcmxQYXJhbSh1cmxfYmFzZSwgXCJzZmlkPVwiK3NmaWQpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vaWYgYW55IG9mIHRoZSAzIGNvbmRpdGlvbnMgYXJlIHRydWUsIHRoZW4gaXRzIGdvb2QgdG8gZ29cclxuICAgICAgICAgICAgICAgIC8vIC0gMSB8IGlmIHRoZSB1cmwgYmFzZSA9PSByZXN1bHRzX3VybFxyXG4gICAgICAgICAgICAgICAgLy8gLSAyIHwgaWYgdXJsIGJhc2UrIFwiL1wiICA9PSByZXN1bHRzX3VybCAtIGluIGNhc2Ugb2YgdXNlciBlcnJvciBpbiB0aGUgcmVzdWx0cyBVUkxcclxuICAgICAgICAgICAgICAgIC8vIC0gMyB8IGlmIHRoZSByZXN1bHRzIFVSTCBoYXMgdXJsIHBhcmFtcywgYW5kIHRoZSBjdXJyZW50IHVybCBzdGFydHMgd2l0aCB0aGUgcmVzdWx0cyBVUkwgXHJcblxyXG4gICAgICAgICAgICAgICAgLy90cmltIGFueSB0cmFpbGluZyBzbGFzaCBmb3IgZWFzaWVyIGNvbXBhcmlzb246XHJcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9iYXNlLnJlcGxhY2UoL1xcLyQvLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybCA9IHJlc3VsdHNfdXJsLnJlcGxhY2UoL1xcLyQvLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybF9lbmNvZGVkID0gZW5jb2RlVVJJKHJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgIFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IC0xO1xyXG4gICAgICAgICAgICAgICAgaWYoKHVybF9iYXNlPT1yZXN1bHRzX3VybCl8fCh1cmxfYmFzZS50b0xvd2VyQ2FzZSgpPT1yZXN1bHRzX3VybF9lbmNvZGVkLnRvTG93ZXJDYXNlKCkpICApe1xyXG4gICAgICAgICAgICAgICAgICAgIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID0gMTtcclxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKCByZXN1bHRzX3VybC5pbmRleE9mKCAnPycgKSAhPT0gLTEgJiYgY3VycmVudF91cmwubGFzdEluZGV4T2YocmVzdWx0c191cmwsIDApID09PSAwICkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IDE7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKHNlbGYub25seV9yZXN1bHRzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgICAgICB7Ly9pZiBhIHVzZXIgaGFzIGNob3NlbiB0byBvbmx5IGFsbG93IGFqYXggb24gcmVzdWx0cyBwYWdlcyAoZGVmYXVsdCBiZWhhdmlvdXIpXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA+IC0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHsvL3RoaXMgbWVhbnMgdGhlIGN1cnJlbnQgVVJMIGNvbnRhaW5zIHRoZSByZXN1bHRzIHVybCwgd2hpY2ggbWVhbnMgd2UgY2FuIGRvIGFqYXhcclxuICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKGZldGNoX3R5cGU9PVwicGFnaW5hdGlvblwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID4gLTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHsvL3RoaXMgbWVhbnMgdGhlIGN1cnJlbnQgVVJMIGNvbnRhaW5zIHRoZSByZXN1bHRzIHVybCwgd2hpY2ggbWVhbnMgd2UgY2FuIGRvIGFqYXhcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL2Rvbid0IGFqYXggcGFnaW5hdGlvbiB3aGVuIG5vdCBvbiBhIFMmRiBwYWdlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZldGNoX2FqYXhfcmVzdWx0cztcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuc2V0dXBBamF4UGFnaW5hdGlvbiA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIC8vaW5maW5pdGUgc2Nyb2xsXHJcbiAgICAgICAgICAgIGlmKHRoaXMucGFnaW5hdGlvbl90eXBlPT09XCJpbmZpbml0ZV9zY3JvbGxcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGluZmluaXRlX3Njcm9sbF9lbmQgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIltkYXRhLXNlYXJjaC1maWx0ZXItYWN0aW9uPSdpbmZpbml0ZS1zY3JvbGwtZW5kJ11cIikubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKHBhcnNlSW50KHRoaXMuaW5zdGFuY2VfbnVtYmVyKT09PTEpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKHdpbmRvdykub2ZmKFwic2Nyb2xsXCIsIHNlbGYub25XaW5kb3dTY3JvbGwpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAoc2VsZi5jYW5GZXRjaEFqYXhSZXN1bHRzKFwicGFnaW5hdGlvblwiKSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKHdpbmRvdykub24oXCJzY3JvbGxcIiwgc2VsZi5vbldpbmRvd1Njcm9sbCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYodHlwZW9mKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik9PVwidW5kZWZpbmVkXCIpIHtcclxuICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgICAgICQoZG9jdW1lbnQpLm9mZignY2xpY2snLCBzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpO1xyXG4gICAgICAgICAgICAgICAgJChkb2N1bWVudCkub2ZmKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcbiAgICAgICAgICAgICAgICAkKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcikub2ZmKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgJChkb2N1bWVudCkub24oJ2NsaWNrJywgc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yLCBmdW5jdGlvbihlKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5jYW5GZXRjaEFqYXhSZXN1bHRzKFwicGFnaW5hdGlvblwiKSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBsaW5rID0galF1ZXJ5KHRoaXMpLmF0dHIoJ2hyZWYnKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5hamF4X2FjdGlvbiA9IFwicGFnaW5hdGlvblwiO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHBhZ2VOdW1iZXIgPSBzZWxmLmdldFBhZ2VkRnJvbVVSTChsaW5rKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIiwgcGFnZU51bWJlcik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZldGNoQWpheFJlc3VsdHMoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZ2V0UGFnZWRGcm9tVVJMID0gZnVuY3Rpb24oVVJMKXtcclxuXHJcbiAgICAgICAgICAgIHZhciBwYWdlZFZhbCA9IDE7XHJcbiAgICAgICAgICAgIC8vZmlyc3QgdGVzdCB0byBzZWUgaWYgd2UgaGF2ZSBcIi9wYWdlLzQvXCIgaW4gdGhlIFVSTFxyXG4gICAgICAgICAgICB2YXIgdHBWYWwgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwic2ZfcGFnZWRcIiwgVVJMKTtcclxuICAgICAgICAgICAgaWYoKHR5cGVvZih0cFZhbCk9PVwic3RyaW5nXCIpfHwodHlwZW9mKHRwVmFsKT09XCJudW1iZXJcIikpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHBhZ2VkVmFsID0gdHBWYWw7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBwYWdlZFZhbDtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMID0gZnVuY3Rpb24obmFtZSwgVVJMKXtcclxuXHJcbiAgICAgICAgICAgIHZhciBxc3RyaW5nID0gXCI/XCIrVVJMLnNwbGl0KCc/JylbMV07XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihxc3RyaW5nKSE9XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGRlY29kZVVSSUNvbXBvbmVudCgobmV3IFJlZ0V4cCgnWz98Jl0nICsgbmFtZSArICc9JyArICcoW14mO10rPykoJnwjfDt8JCknKS5leGVjKHFzdHJpbmcpfHxbLFwiXCJdKVsxXS5yZXBsYWNlKC9cXCsvZywgJyUyMCcpKXx8bnVsbDtcclxuICAgICAgICAgICAgICAgIHJldHVybiB2YWw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgcmV0dXJuIFwiXCI7XHJcbiAgICAgICAgfTtcclxuXHJcblxyXG5cclxuICAgICAgICB0aGlzLmZvcm1VcGRhdGVkID0gZnVuY3Rpb24oZSl7XHJcblxyXG4gICAgICAgICAgICAvL2UucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgaWYoc2VsZi5hdXRvX3VwZGF0ZT09MSkge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zdWJtaXRGb3JtKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZigoc2VsZi5hdXRvX3VwZGF0ZT09MCkmJihzZWxmLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5mb3JtVXBkYXRlZEZldGNoQWpheCgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5mb3JtVXBkYXRlZEZldGNoQWpheCA9IGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAvL2xvb3AgdGhyb3VnaCBhbGwgdGhlIGZpZWxkcyBhbmQgYnVpbGQgdGhlIFVSTFxyXG4gICAgICAgICAgICBzZWxmLmZldGNoQWpheEZvcm0oKTtcclxuXHJcblxyXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgLy9tYWtlIGFueSBjb3JyZWN0aW9ucy91cGRhdGVzIHRvIGZpZWxkcyBiZWZvcmUgdGhlIHN1Ym1pdCBjb21wbGV0ZXNcclxuICAgICAgICB0aGlzLnNldEZpZWxkcyA9IGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgLy9pZihzZWxmLmlzX2FqYXg9PTApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NvbWV0aW1lcyB0aGUgZm9ybSBpcyBzdWJtaXR0ZWQgd2l0aG91dCB0aGUgc2xpZGVyIHlldCBoYXZpbmcgdXBkYXRlZCwgYW5kIGFzIHdlIGdldCBvdXIgdmFsdWVzIGZyb21cclxuICAgICAgICAgICAgICAgIC8vdGhlIHNsaWRlciBhbmQgbm90IGlucHV0cywgd2UgbmVlZCB0byBjaGVjayBpdCBpZiBuZWVkcyB0byBiZSBzZXRcclxuICAgICAgICAgICAgICAgIC8vb25seSBvY2N1cnMgaWYgYWpheCBpcyBvZmYsIGFuZCBhdXRvc3VibWl0IG9uXHJcbiAgICAgICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRmaWVsZCA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciByYW5nZV9kaXNwbGF5X3ZhbHVlcyA9ICRmaWVsZC5maW5kKCcuc2YtbWV0YS1yYW5nZS1zbGlkZXInKS5hdHRyKFwiZGF0YS1kaXNwbGF5LXZhbHVlcy1hc1wiKTsvL2RhdGEtZGlzcGxheS12YWx1ZXMtYXM9XCJ0ZXh0XCJcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYocmFuZ2VfZGlzcGxheV92YWx1ZXM9PT1cInRleHRpbnB1dFwiKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkZmllbGQuZmluZChcIi5tZXRhLXNsaWRlclwiKS5sZW5ndGg+MCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmVhY2goZnVuY3Rpb24gKGluZGV4KSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9vYmplY3QgPSAkKHRoaXMpWzBdO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRzbGlkZXJfZWwgPSAkKHRoaXMpLmNsb3Nlc3QoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL3ZhciBtaW5WYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vdmFyIG1heFZhbCA9ICRzbGlkZXJfZWwuYXR0cihcImRhdGEtbWF4XCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG1pblZhbCA9ICRzbGlkZXJfZWwuZmluZChcIi5zZi1yYW5nZS1taW5cIikudmFsKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgbWF4VmFsID0gJHNsaWRlcl9lbC5maW5kKFwiLnNmLXJhbmdlLW1heFwiKS52YWwoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoW21pblZhbCwgbWF4VmFsXSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgLy99XHJcblxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgLy9zdWJtaXRcclxuICAgICAgICB0aGlzLnN1Ym1pdEZvcm0gPSBmdW5jdGlvbihlKXtcclxuXHJcbiAgICAgICAgICAgIC8vbG9vcCB0aHJvdWdoIGFsbCB0aGUgZmllbGRzIGFuZCBidWlsZCB0aGUgVVJMXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaXNTdWJtaXR0aW5nID09IHRydWUpIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRGaWVsZHMoKTtcclxuICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7XHJcblxyXG4gICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIsIDEpOyAvL2luaXQgcGFnZWRcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYuY2FuRmV0Y2hBamF4UmVzdWx0cygpKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgYWpheCBzdWJtaXQgdGhlIGZvcm1cclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gXCJzdWJtaXRcIjsgLy9zbyB3ZSBrbm93IGl0IHdhc24ndCBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICBzZWxmLmZldGNoQWpheFJlc3VsdHMoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2lsbCBzaW1wbHkgcmVkaXJlY3QgdG8gdGhlIFJlc3VsdHMgVVJMXHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSwgJycpO1xyXG4gICAgICAgICAgICAgICAgcmVzdWx0c191cmwgPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG5cclxuICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gcmVzdWx0c191cmw7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICB9O1xyXG4gICAgICAgIHRoaXMucmVzZXRGb3JtID0gZnVuY3Rpb24oc3VibWl0X2Zvcm0pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvL3Vuc2V0IGFsbCBmaWVsZHNcclxuICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGZpZWxkID0gJCh0aGlzKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQkZmllbGQucmVtb3ZlQXR0cihcImRhdGEtc2YtdGF4b25vbXktYXJjaGl2ZVwiKTtcclxuXHRcdFx0XHRcclxuICAgICAgICAgICAgICAgIC8vc3RhbmRhcmQgZmllbGQgdHlwZXNcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwic2VsZWN0Om5vdChbbXVsdGlwbGU9J211bHRpcGxlJ10pID4gb3B0aW9uOmZpcnN0LWNoaWxkXCIpLnByb3AoXCJzZWxlY3RlZFwiLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwic2VsZWN0W211bHRpcGxlPSdtdWx0aXBsZSddID4gb3B0aW9uXCIpLnByb3AoXCJzZWxlY3RlZFwiLCBmYWxzZSk7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcImlucHV0W3R5cGU9J2NoZWNrYm94J11cIikucHJvcChcImNoZWNrZWRcIiwgZmFsc2UpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCI+IHVsID4gbGk6Zmlyc3QtY2hpbGQgaW5wdXRbdHlwZT0ncmFkaW8nXVwiKS5wcm9wKFwiY2hlY2tlZFwiLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiaW5wdXRbdHlwZT0ndGV4dCddXCIpLnZhbChcIlwiKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLnNmLW9wdGlvbi1hY3RpdmVcIikucmVtb3ZlQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCI+IHVsID4gbGk6Zmlyc3QtY2hpbGQgaW5wdXRbdHlwZT0ncmFkaW8nXVwiKS5wYXJlbnQoKS5hZGRDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7IC8vcmUgYWRkIGFjdGl2ZSBjbGFzcyB0byBmaXJzdCBcImRlZmF1bHRcIiBvcHRpb25cclxuXHJcbiAgICAgICAgICAgICAgICAvL251bWJlciByYW5nZSAtIDIgbnVtYmVyIGlucHV0IGZpZWxkc1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJpbnB1dFt0eXBlPSdudW1iZXInXVwiKS5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzSW5wdXQgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZigkdGhpc0lucHV0LnBhcmVudCgpLnBhcmVudCgpLmhhc0NsYXNzKFwic2YtbWV0YS1yYW5nZVwiKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoaW5kZXg9PTApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKCR0aGlzSW5wdXQuYXR0cihcIm1pblwiKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihpbmRleD09MSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoJHRoaXNJbnB1dC5hdHRyKFwibWF4XCIpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL21ldGEgLyBudW1iZXJzIHdpdGggMiBpbnB1dHMgKGZyb20gLyB0byBmaWVsZHMpIC0gc2Vjb25kIGlucHV0IG11c3QgYmUgcmVzZXQgdG8gbWF4IHZhbHVlXHJcbiAgICAgICAgICAgICAgICB2YXIgJG1ldGFfc2VsZWN0X2Zyb21fdG8gPSAkZmllbGQuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNlbGVjdC1mcm9tdG9cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJG1ldGFfc2VsZWN0X2Zyb21fdG8ubGVuZ3RoPjApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21pbiA9ICRtZXRhX3NlbGVjdF9mcm9tX3RvLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWF4ID0gJG1ldGFfc2VsZWN0X2Zyb21fdG8uYXR0cihcImRhdGEtbWF4XCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkbWV0YV9zZWxlY3RfZnJvbV90by5maW5kKFwic2VsZWN0XCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzSW5wdXQgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoaW5kZXg9PTApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbChzdGFydF9taW4pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoaW5kZXg9PTEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKHN0YXJ0X21heCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICRtZXRhX3JhZGlvX2Zyb21fdG8gPSAkZmllbGQuZmluZChcIi5zZi1tZXRhLXJhbmdlLXJhZGlvLWZyb210b1wiKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigkbWV0YV9yYWRpb19mcm9tX3RvLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9taW4gPSAkbWV0YV9yYWRpb19mcm9tX3RvLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWF4ID0gJG1ldGFfcmFkaW9fZnJvbV90by5hdHRyKFwiZGF0YS1tYXhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkcmFkaW9fZ3JvdXBzID0gJG1ldGFfcmFkaW9fZnJvbV90by5maW5kKCcuc2YtaW5wdXQtcmFuZ2UtcmFkaW8nKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJHJhZGlvX2dyb3Vwcy5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHJhZGlvcyA9ICQodGhpcykuZmluZChcIi5zZi1pbnB1dC1yYWRpb1wiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHJhZGlvcy5wcm9wKFwiY2hlY2tlZFwiLCBmYWxzZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MClcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHJhZGlvcy5maWx0ZXIoJ1t2YWx1ZT1cIicrc3RhcnRfbWluKydcIl0nKS5wcm9wKFwiY2hlY2tlZFwiLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLmZpbHRlcignW3ZhbHVlPVwiJytzdGFydF9tYXgrJ1wiXScpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAvL251bWJlciBzbGlkZXIgLSBub1VpU2xpZGVyXHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIi5tZXRhLXNsaWRlclwiKS5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9vYmplY3QgPSAkKHRoaXMpWzBdO1xyXG4gICAgICAgICAgICAgICAgICAgIC8qdmFyIHNsaWRlcl9vYmplY3QgPSAkY29udGFpbmVyLmZpbmQoXCIubWV0YS1zbGlkZXJcIilbMF07XHJcbiAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfdmFsID0gc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmdldCgpOyovXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkc2xpZGVyX2VsID0gJCh0aGlzKS5jbG9zZXN0KFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5WYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWF4VmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbbWluVmFsLCBtYXhWYWxdKTtcclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL25lZWQgdG8gc2VlIGlmIGFueSBhcmUgY29tYm9ib3ggYW5kIGFjdCBhY2NvcmRpbmdseVxyXG4gICAgICAgICAgICAgICAgdmFyICRjb21ib2JveCA9ICRmaWVsZC5maW5kKFwic2VsZWN0W2RhdGEtY29tYm9ib3g9JzEnXVwiKTtcclxuICAgICAgICAgICAgICAgIGlmKCRjb21ib2JveC5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAodHlwZW9mICRjb21ib2JveC5jaG9zZW4gIT0gXCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC50cmlnZ2VyKFwiY2hvc2VuOnVwZGF0ZWRcIik7IC8vZm9yIGNob3NlbiBvbmx5XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC52YWwoJycpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkY29tYm9ib3gudHJpZ2dlcignY2hhbmdlLnNlbGVjdDInKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpO1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICBpZihzdWJtaXRfZm9ybT09XCJhbHdheXNcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zdWJtaXRGb3JtKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzdWJtaXRfZm9ybT09XCJuZXZlclwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuZm9ybVVwZGF0ZWRGZXRjaEFqYXgoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHN1Ym1pdF9mb3JtPT1cImF1dG9cIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgaWYodGhpcy5hdXRvX3VwZGF0ZT09dHJ1ZSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5mb3JtVXBkYXRlZEZldGNoQWpheCgpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmluaXQoKTtcclxuXHJcbiAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7fTtcclxuICAgICAgICBldmVudF9kYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgZXZlbnRfZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICBldmVudF9kYXRhLm9iamVjdCA9IHRoaXM7XHJcbiAgICAgICAgaWYob3B0cy5pc0luaXQpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmluaXRcIiwgZXZlbnRfZGF0YSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgIH0pO1xyXG59O1xyXG4iXX0=
},{"./process_form":4,"./state":5,"./thirdparty":6,"nouislider":2}],4:[function(require,module,exports){
(function (global){

var $ = (typeof window !== "undefined" ? window['jQuery'] : typeof global !== "undefined" ? global['jQuery'] : null);

module.exports = {

	taxonomy_archives: 0,
    url_params: {},
    tax_archive_results_url: "",
    active_tax: "",
    fields: {},
	init: function(taxonomy_archives, current_taxonomy_archive){

        this.taxonomy_archives = 0;
        this.url_params = {};
        this.tax_archive_results_url = "";
        this.active_tax = "";

		//this.$fields = $fields;
        this.taxonomy_archives = taxonomy_archives;
        this.current_taxonomy_archive = current_taxonomy_archive;

		this.clearUrlComponents();

	},
    setTaxArchiveResultsUrl: function($form, current_results_url, get_active) {

        var self = this;
		this.clearTaxArchiveResultsUrl();
        //var current_results_url = "";
        if(this.taxonomy_archives!=1)
        {
            return;
        }

        if(typeof(get_active)=="undefined")
		{
			var get_active = false;
		}

        //check to see if we have any taxonomies selected
        //if so, check their rewrites and use those as the results url
        var $field = false;
        var field_name = "";
        var field_value = "";

        var $active_taxonomy = $form.$fields.parent().find("[data-sf-taxonomy-archive='1']");
        if($active_taxonomy.length==1)
        {
            $field = $active_taxonomy;

            var fieldType = $field.attr("data-sf-field-type");

            if ((fieldType == "tag") || (fieldType == "category") || (fieldType == "taxonomy")) {
                var taxonomy_value = self.processTaxonomy($field, true);
                field_name = $field.attr("data-sf-field-name");
                var taxonomy_name = field_name.replace("_sft_", "");

                if (taxonomy_value) {
                    field_value = taxonomy_value.value;
                }
            }

            if(field_value=="")
            {
                $field = false;
            }
        }

        if((self.current_taxonomy_archive!="")&&(self.current_taxonomy_archive!=taxonomy_name))
        {

            this.tax_archive_results_url = current_results_url;
            return;
        }

        if(((field_value=="")||(!$field) ))
        {
            $form.$fields.each(function () {

                if (!$field) {

                    var fieldType = $(this).attr("data-sf-field-type");

                    if ((fieldType == "tag") || (fieldType == "category") || (fieldType == "taxonomy")) {
                        var taxonomy_value = self.processTaxonomy($(this), true);
                        field_name = $(this).attr("data-sf-field-name");

                        if (taxonomy_value) {

                            field_value = taxonomy_value.value;

                            if (field_value != "") {

                                $field = $(this);
                            }

                        }
                    }
                }
            });
        }

        if( ($field) && (field_value != "" )) {
            //if we found a field
			var rewrite_attr = ($field.attr("data-sf-term-rewrite"));

            if(rewrite_attr!="") {

                var rewrite = JSON.parse(rewrite_attr);
                var input_type = $field.attr("data-sf-field-input-type");
                self.active_tax = field_name;

                //find the active element
                if ((input_type == "radio") || (input_type == "checkbox")) {

                    //var $active = $field.find(".sf-option-active");
                    //explode the values if there is a delim
                    //field_value

                    var is_single_value = true;
                    var field_values = field_value.split(",").join("+").split("+");
                    if (field_values.length > 1) {
                        is_single_value = false;
                    }

                    if (is_single_value) {

                        var $input = $field.find("input[value='" + field_value + "']");
                        var $active = $input.parent();
                        var depth = $active.attr("data-sf-depth");

                        //now loop through parents to grab their names
                        var values = new Array();
                        values.push(field_value);

                        for (var i = depth; i > 0; i--) {
                            $active = $active.parent().parent();
                            values.push($active.find("input").val());
                        }

                        values.reverse();

                        //grab the rewrite for this depth
                        var active_rewrite = rewrite[depth];
                        var url = active_rewrite;


                        //then map from the parents to the depth
                        $(values).each(function (index, value) {

                            url = url.replace("[" + index + "]", value);

                        });
                        this.tax_archive_results_url = url;
                    }
                    else {

                        //if there are multiple values,
                        //then we need to check for 3 things:

                        //if the values selected are all in the same tree then we can do some clever rewrite stuff
                        //merge all values in same level, then combine the levels

                        //if they are from different trees then just combine them or just use `field_value`
                        /*

                         var depths = new Array();
                         $(field_values).each(function (index, val) {

                         var $input = $field.find("input[value='" + field_value + "']");
                         var $active = $input.parent();

                         var depth = $active.attr("data-sf-depth");
                         //depths.push(depth);

                         });*/

                    }
                }
                else if ((input_type == "select") || (input_type == "multiselect")) {

                    var is_single_value = true;
                    var field_values = field_value.split(",").join("+").split("+");
                    if (field_values.length > 1) {
                        is_single_value = false;
                    }

                    if (is_single_value) {

                        var $active = $field.find("option[value='" + field_value + "']");
                        var depth = $active.attr("data-sf-depth");

                        var values = new Array();
                        values.push(field_value);

                        for (var i = depth; i > 0; i--) {
                            $active = $active.prevAll("option[data-sf-depth='" + (i - 1) + "']");
                            values.push($active.val());
                        }

                        values.reverse();
                        var active_rewrite = rewrite[depth];
                        var url = active_rewrite;
                        $(values).each(function (index, value) {

                            url = url.replace("[" + index + "]", value);

                        });
                        this.tax_archive_results_url = url;
                    }

                }
            }

        }
        //this.tax_archive_results_url = current_results_url;
    },
    getResultsUrl: function($form, current_results_url) {

        //this.setTaxArchiveResultsUrl($form, current_results_url);

        if(this.tax_archive_results_url=="")
        {
            return current_results_url;
        }

        return this.tax_archive_results_url;
    },
	getUrlParams: function($form){

		this.buildUrlComponents($form, true);

        if(this.tax_archive_results_url!="")
        {

            if(this.active_tax!="")
            {
                var field_name = this.active_tax;

                if(typeof(this.url_params[field_name])!="undefined")
                {
                    delete this.url_params[field_name];
                }
            }
        }

		return this.url_params;
	},
	clearUrlComponents: function(){
		//this.url_components = "";
		this.url_params = {};
	},
	clearTaxArchiveResultsUrl: function() {
		this.tax_archive_results_url = '';
	},
	disableInputs: function($form){
		var self = this;
		
		$form.$fields.each(function(){
			
			var $inputs = $(this).find("input, select, .meta-slider");
			$inputs.attr("disabled", "disabled");
			$inputs.attr("disabled", true);
			$inputs.prop("disabled", true);
			$inputs.trigger("chosen:updated");
			
		});
		
		
	},
	enableInputs: function($form){
		var self = this;
		$form.$fields.each(function(){
			var $inputs = $(this).find("input, select, .meta-slider");
			$inputs.prop("disabled", false);
			$inputs.attr("disabled", false);
			$inputs.trigger("chosen:updated");			
		});
		
		
	},
	buildUrlComponents: function($form, clear_components){
		
		var self = this;
		
		if(typeof(clear_components)!="undefined")
		{
			if(clear_components==true)
			{
				this.clearUrlComponents();
			}
		}
		
		$form.$fields.each(function(){
			
			var fieldName = $(this).attr("data-sf-field-name");
			var fieldType = $(this).attr("data-sf-field-type");
			
			if(fieldType=="search")
			{
				self.processSearchField($(this));
			}
			else if((fieldType=="tag")||(fieldType=="category")||(fieldType=="taxonomy"))
			{
				self.processTaxonomy($(this));
			}
			else if(fieldType=="sort_order")
			{
				self.processSortOrderField($(this));
			}
			else if(fieldType=="posts_per_page")
			{
				self.processResultsPerPageField($(this));
			}
			else if(fieldType=="author")
			{
				self.processAuthor($(this));
			}
			else if(fieldType=="post_type")
			{
				self.processPostType($(this));
			}
			else if(fieldType=="post_date")
			{
				self.processPostDate($(this));
			}
			else if(fieldType=="post_meta")
			{
				self.processPostMeta($(this));
				
			}
			else
			{
				
			}
			
		});
		
	},
	processSearchField: function($container)
	{
		var self = this;
		
		var $field = $container.find("input[name^='_sf_search']");
		
		if($field.length>0)
		{
			var fieldName = $field.attr("name").replace('[]', '');
			var fieldVal = $field.val();
			
			if(fieldVal!="")
			{
				//self.url_components += "&_sf_s="+encodeURIComponent(fieldVal);
				self.url_params['_sf_s'] = encodeURIComponent(fieldVal);
			}
		}
	},
	processSortOrderField: function($container)
	{
		this.processAuthor($container);
		
	},
	processResultsPerPageField: function($container)
	{
		this.processAuthor($container);
		
	},
	getActiveTax: function($field) {
		return this.active_tax;
	},
	getSelectVal: function($field){

		var fieldVal = "";
		
		if($field.val()!=0)
		{
			fieldVal = $field.val();
		}
		
		if(fieldVal==null)
		{
			fieldVal = "";
		}
		
		return fieldVal;
	},
	getMetaSelectVal: function($field){
		
		var fieldVal = "";
		
		fieldVal = $field.val();
						
		if(fieldVal==null)
		{
			fieldVal = "";
		}
		
		return fieldVal;
	},
	getMultiSelectVal: function($field, operator){
		
		var delim = "+";
		if(operator=="or")
		{
			delim = ",";
		}
		
		if(typeof($field.val())=="object")
		{
			if($field.val()!=null)
			{
				return $field.val().join(delim);
			}
		}
		
	},
	getMetaMultiSelectVal: function($field, operator){
		
		var delim = "-+-";
		if(operator=="or")
		{
			delim = "-,-";
		}
				
		if(typeof($field.val())=="object")
		{
			if($field.val()!=null)
			{
				
				var fieldval = [];
				
				$($field.val()).each(function(index,value){
					
					fieldval.push((value));
				});
				
				return fieldval.join(delim);
			}
		}
		
		return "";
		
	},
	getCheckboxVal: function($field, operator){
		
		
		var fieldVal = $field.map(function(){
			if($(this).prop("checked")==true)
			{
				return $(this).val();
			}
		}).get();
		
		var delim = "+";
		if(operator=="or")
		{
			delim = ",";
		}
		
		return fieldVal.join(delim);
	},
	getMetaCheckboxVal: function($field, operator){
		
		
		var fieldVal = $field.map(function(){
			if($(this).prop("checked")==true)
			{
				return ($(this).val());
			}
		}).get();
		
		var delim = "-+-";
		if(operator=="or")
		{
			delim = "-,-";
		}
		
		return fieldVal.join(delim);
	},
	getRadioVal: function($field){
							
		var fieldVal = $field.map(function()
		{
			if($(this).prop("checked")==true)
			{
				return $(this).val();
			}
			
		}).get();
		
		
		if(fieldVal[0]!=0)
		{
			return fieldVal[0];
		}
	},
	getMetaRadioVal: function($field){
							
		var fieldVal = $field.map(function()
		{
			if($(this).prop("checked")==true)
			{
				return $(this).val();
			}
			
		}).get();
		
		return fieldVal[0];
	},
	processAuthor: function($container)
	{
		var self = this;
		
		
		var fieldType = $container.attr("data-sf-field-type");
		var inputType = $container.attr("data-sf-field-input-type");
		
		var $field;
		var fieldName = "";
		var fieldVal = "";
		
		if(inputType=="select")
		{
			$field = $container.find("select");
			fieldName = $field.attr("name").replace('[]', '');
			
			fieldVal = self.getSelectVal($field); 
		}
		else if(inputType=="multiselect")
		{
			$field = $container.find("select");
			fieldName = $field.attr("name").replace('[]', '');
			var operator = $field.attr("data-operator");
			
			fieldVal = self.getMultiSelectVal($field, "or");
			
		}
		else if(inputType=="checkbox")
		{
			$field = $container.find("ul > li input:checkbox");
			
			if($field.length>0)
			{
				fieldName = $field.attr("name").replace('[]', '');
										
				var operator = $container.find("> ul").attr("data-operator");
				fieldVal = self.getCheckboxVal($field, "or");
			}
			
		}
		else if(inputType=="radio")
		{
			
			$field = $container.find("ul > li input:radio");
						
			if($field.length>0)
			{
				fieldName = $field.attr("name").replace('[]', '');
				
				fieldVal = self.getRadioVal($field);
			}
		}
		
		if(typeof(fieldVal)!="undefined")
		{
			if(fieldVal!="")
			{
				var fieldSlug = "";
				
				if(fieldName=="_sf_author")
				{
					fieldSlug = "authors";
				}
				else if(fieldName=="_sf_sort_order")
				{
					fieldSlug = "sort_order";
				}
				else if(fieldName=="_sf_ppp")
				{
					fieldSlug = "_sf_ppp";
				}
				else if(fieldName=="_sf_post_type")
				{
					fieldSlug = "post_types";
				}
				else
				{
				
				}
				
				if(fieldSlug!="")
				{
					//self.url_components += "&"+fieldSlug+"="+fieldVal;
					self.url_params[fieldSlug] = fieldVal;
				}
			}
		}
		
	},
	processPostType : function($this){
		
		this.processAuthor($this);
		
	},
	processPostMeta: function($container)
	{
		var self = this;
		
		var fieldType = $container.attr("data-sf-field-type");
		var inputType = $container.attr("data-sf-field-input-type");
		var metaType = $container.attr("data-sf-meta-type");

		var fieldVal = "";
		var $field;
		var fieldName = "";
		
		if(metaType=="number")
		{
			if(inputType=="range-number")
			{
				$field = $container.find(".sf-meta-range-number input");
				
				var values = [];
				$field.each(function(){
					
					values.push($(this).val());
				
				});
				
				fieldVal = values.join("+");
				
			}
			else if(inputType=="range-slider")
			{
				$field = $container.find(".sf-meta-range-slider input");
				
				//get any number formatting stuff
				var $meta_range = $container.find(".sf-meta-range-slider");
				
				var decimal_places = $meta_range.attr("data-decimal-places");
				var thousand_seperator = $meta_range.attr("data-thousand-seperator");
				var decimal_seperator = $meta_range.attr("data-decimal-seperator");

				var field_format = wNumb({
					mark: decimal_seperator,
					decimals: parseFloat(decimal_places),
					thousand: thousand_seperator
				});
				
				var values = [];


				var slider_object = $container.find(".meta-slider")[0];
				//val from slider object
				var slider_val = slider_object.noUiSlider.get();

				values.push(field_format.from(slider_val[0]));
				values.push(field_format.from(slider_val[1]));
				
				fieldVal = values.join("+");
				
				fieldName = $meta_range.attr("data-sf-field-name");
				
				
			}
			else if(inputType=="range-radio")
			{
				$field = $container.find(".sf-input-range-radio");
				
				if($field.length==0)
				{
					//then try again, we must be using a single field
					$field = $container.find("> ul");
				}

				var $meta_range = $container.find(".sf-meta-range");
				
				//there is an element with a from/to class - so we need to get the values of the from & to input fields seperately
				if($field.length>0)
				{	
					var field_vals = [];
					
					$field.each(function(){
						
						var $radios = $(this).find(".sf-input-radio");
						field_vals.push(self.getMetaRadioVal($radios));
						
					});
					
					//prevent second number from being lower than the first
					if(field_vals.length==2)
					{
						if(Number(field_vals[1])<Number(field_vals[0]))
						{
							field_vals[1] = field_vals[0];
						}
					}
					
					fieldVal = field_vals.join("+");
				}
								
				if($field.length==1)
				{
					fieldName = $field.find(".sf-input-radio").attr("name").replace('[]', '');
				}
				else
				{
					fieldName = $meta_range.attr("data-sf-field-name");
				}

			}
			else if(inputType=="range-select")
			{
				$field = $container.find(".sf-input-select");
				var $meta_range = $container.find(".sf-meta-range");
				
				//there is an element with a from/to class - so we need to get the values of the from & to input fields seperately
				
				if($field.length>0)
				{
					var field_vals = [];
					
					$field.each(function(){
						
						var $this = $(this);
						field_vals.push(self.getMetaSelectVal($this));
						
					});
					
					//prevent second number from being lower than the first
					if(field_vals.length==2)
					{
						if(Number(field_vals[1])<Number(field_vals[0]))
						{
							field_vals[1] = field_vals[0];
						}
					}
					
					
					fieldVal = field_vals.join("+");
				}
								
				if($field.length==1)
				{
					fieldName = $field.attr("name").replace('[]', '');
				}
				else
				{
					fieldName = $meta_range.attr("data-sf-field-name");
				}
				
			}
			else if(inputType=="range-checkbox")
			{
				$field = $container.find("ul > li input:checkbox");
				
				if($field.length>0)
				{
					fieldVal = self.getCheckboxVal($field, "and");
				}
			}
			
			if(fieldName=="")
			{
				fieldName = $field.attr("name").replace('[]', '');
			}
		}
		else if(metaType=="choice")
		{
			if(inputType=="select")
			{
				$field = $container.find("select");
				
				fieldVal = self.getMetaSelectVal($field); 
				
			}
			else if(inputType=="multiselect")
			{
				$field = $container.find("select");
				var operator = $field.attr("data-operator");
				
				fieldVal = self.getMetaMultiSelectVal($field, operator);
			}
			else if(inputType=="checkbox")
			{
				$field = $container.find("ul > li input:checkbox");
				
				if($field.length>0)
				{
					var operator = $container.find("> ul").attr("data-operator");
					fieldVal = self.getMetaCheckboxVal($field, operator);
				}
			}
			else if(inputType=="radio")
			{
				$field = $container.find("ul > li input:radio");
				
				if($field.length>0)
				{
					fieldVal = self.getMetaRadioVal($field);
				}
			}
			
			fieldVal = encodeURIComponent(fieldVal);
			if(typeof($field)!=="undefined")
			{
				if($field.length>0)
				{
					fieldName = $field.attr("name").replace('[]', '');
					
					//for those who insist on using & ampersands in the name of the custom field (!)
					fieldName = (fieldName);
				}
			}
			
		}
		else if(metaType=="date")
		{
			self.processPostDate($container);
		}
		
		if(typeof(fieldVal)!="undefined")
		{
			if(fieldVal!="")
			{
				//self.url_components += "&"+encodeURIComponent(fieldName)+"="+(fieldVal);
				self.url_params[encodeURIComponent(fieldName)] = (fieldVal);
			}
		}
	},
	processPostDate: function($container)
	{
		var self = this;
		
		var fieldType = $container.attr("data-sf-field-type");
		var inputType = $container.attr("data-sf-field-input-type");
		
		var $field;
		var fieldName = "";
		var fieldVal = "";
		
		$field = $container.find("ul > li input:text");
		fieldName = $field.attr("name").replace('[]', '');
		
		var dates = [];
		$field.each(function(){
			
			dates.push($(this).val());
		
		});
		
		if($field.length==2)
		{
			if((dates[0]!="")||(dates[1]!=""))
			{
				fieldVal = dates.join("+");
				fieldVal = fieldVal.replace(/\//g,'');
			}
		}
		else if($field.length==1)
		{
			if(dates[0]!="")
			{
				fieldVal = dates.join("+");
				fieldVal = fieldVal.replace(/\//g,'');
			}
		}
		
		if(typeof(fieldVal)!="undefined")
		{
			if(fieldVal!="")
			{
				var fieldSlug = "";
				
				if(fieldName=="_sf_post_date")
				{
					fieldSlug = "post_date";
				}
				else
				{
					fieldSlug = fieldName;
				}
				
				if(fieldSlug!="")
				{
					//self.url_components += "&"+fieldSlug+"="+fieldVal;
					self.url_params[fieldSlug] = fieldVal;
				}
			}
		}
		
	},
	processTaxonomy: function($container, return_object)
	{
        if(typeof(return_object)=="undefined")
        {
            return_object = false;
        }

		//if()					
		//var fieldName = $(this).attr("data-sf-field-name");
		var self = this;
	
		var fieldType = $container.attr("data-sf-field-type");
		var inputType = $container.attr("data-sf-field-input-type");
		
		var $field;
		var fieldName = "";
		var fieldVal = "";
		
		if(inputType=="select")
		{
			$field = $container.find("select");
			fieldName = $field.attr("name").replace('[]', '');
			
			fieldVal = self.getSelectVal($field); 
		}
		else if(inputType=="multiselect")
		{
			$field = $container.find("select");
			fieldName = $field.attr("name").replace('[]', '');
			var operator = $field.attr("data-operator");
			
			fieldVal = self.getMultiSelectVal($field, operator);
		}
		else if(inputType=="checkbox")
		{
			$field = $container.find("ul > li input:checkbox");
			if($field.length>0)
			{
				fieldName = $field.attr("name").replace('[]', '');
										
				var operator = $container.find("> ul").attr("data-operator");
				fieldVal = self.getCheckboxVal($field, operator);
			}
		}
		else if(inputType=="radio")
		{
			$field = $container.find("ul > li input:radio");
			if($field.length>0)
			{
				fieldName = $field.attr("name").replace('[]', '');
				
				fieldVal = self.getRadioVal($field);
			}
		}
		
		if(typeof(fieldVal)!="undefined")
		{
			if(fieldVal!="")
			{
                if(return_object==true)
                {
                    return {name: fieldName, value: fieldVal};
                }
                else
                {
                    //self.url_components += "&"+fieldName+"="+fieldVal;
                    self.url_params[fieldName] = fieldVal;
                }

			}
		}

        if(return_object==true)
        {
            return false;
        }
	}
};
}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3Byb2Nlc3NfZm9ybS5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIlxyXG52YXIgJCA9ICh0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93WydqUXVlcnknXSA6IHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWxbJ2pRdWVyeSddIDogbnVsbCk7XHJcblxyXG5tb2R1bGUuZXhwb3J0cyA9IHtcclxuXHJcblx0dGF4b25vbXlfYXJjaGl2ZXM6IDAsXHJcbiAgICB1cmxfcGFyYW1zOiB7fSxcclxuICAgIHRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsOiBcIlwiLFxyXG4gICAgYWN0aXZlX3RheDogXCJcIixcclxuICAgIGZpZWxkczoge30sXHJcblx0aW5pdDogZnVuY3Rpb24odGF4b25vbXlfYXJjaGl2ZXMsIGN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSl7XHJcblxyXG4gICAgICAgIHRoaXMudGF4b25vbXlfYXJjaGl2ZXMgPSAwO1xyXG4gICAgICAgIHRoaXMudXJsX3BhcmFtcyA9IHt9O1xyXG4gICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSBcIlwiO1xyXG4gICAgICAgIHRoaXMuYWN0aXZlX3RheCA9IFwiXCI7XHJcblxyXG5cdFx0Ly90aGlzLiRmaWVsZHMgPSAkZmllbGRzO1xyXG4gICAgICAgIHRoaXMudGF4b25vbXlfYXJjaGl2ZXMgPSB0YXhvbm9teV9hcmNoaXZlcztcclxuICAgICAgICB0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSA9IGN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZTtcclxuXHJcblx0XHR0aGlzLmNsZWFyVXJsQ29tcG9uZW50cygpO1xyXG5cclxuXHR9LFxyXG4gICAgc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmw6IGZ1bmN0aW9uKCRmb3JtLCBjdXJyZW50X3Jlc3VsdHNfdXJsLCBnZXRfYWN0aXZlKSB7XHJcblxyXG4gICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHRcdHRoaXMuY2xlYXJUYXhBcmNoaXZlUmVzdWx0c1VybCgpO1xyXG4gICAgICAgIC8vdmFyIGN1cnJlbnRfcmVzdWx0c191cmwgPSBcIlwiO1xyXG4gICAgICAgIGlmKHRoaXMudGF4b25vbXlfYXJjaGl2ZXMhPTEpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YoZ2V0X2FjdGl2ZSk9PVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdHZhciBnZXRfYWN0aXZlID0gZmFsc2U7XHJcblx0XHR9XHJcblxyXG4gICAgICAgIC8vY2hlY2sgdG8gc2VlIGlmIHdlIGhhdmUgYW55IHRheG9ub21pZXMgc2VsZWN0ZWRcclxuICAgICAgICAvL2lmIHNvLCBjaGVjayB0aGVpciByZXdyaXRlcyBhbmQgdXNlIHRob3NlIGFzIHRoZSByZXN1bHRzIHVybFxyXG4gICAgICAgIHZhciAkZmllbGQgPSBmYWxzZTtcclxuICAgICAgICB2YXIgZmllbGRfbmFtZSA9IFwiXCI7XHJcbiAgICAgICAgdmFyIGZpZWxkX3ZhbHVlID0gXCJcIjtcclxuXHJcbiAgICAgICAgdmFyICRhY3RpdmVfdGF4b25vbXkgPSAkZm9ybS4kZmllbGRzLnBhcmVudCgpLmZpbmQoXCJbZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlPScxJ11cIik7XHJcbiAgICAgICAgaWYoJGFjdGl2ZV90YXhvbm9teS5sZW5ndGg9PTEpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAkZmllbGQgPSAkYWN0aXZlX3RheG9ub215O1xyXG5cclxuICAgICAgICAgICAgdmFyIGZpZWxkVHlwZSA9ICRmaWVsZC5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYgKChmaWVsZFR5cGUgPT0gXCJ0YWdcIikgfHwgKGZpZWxkVHlwZSA9PSBcImNhdGVnb3J5XCIpIHx8IChmaWVsZFR5cGUgPT0gXCJ0YXhvbm9teVwiKSkge1xyXG4gICAgICAgICAgICAgICAgdmFyIHRheG9ub215X3ZhbHVlID0gc2VsZi5wcm9jZXNzVGF4b25vbXkoJGZpZWxkLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgIGZpZWxkX25hbWUgPSAkZmllbGQuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuICAgICAgICAgICAgICAgIHZhciB0YXhvbm9teV9uYW1lID0gZmllbGRfbmFtZS5yZXBsYWNlKFwiX3NmdF9cIiwgXCJcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYgKHRheG9ub215X3ZhbHVlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgZmllbGRfdmFsdWUgPSB0YXhvbm9teV92YWx1ZS52YWx1ZTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoZmllbGRfdmFsdWU9PVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRmaWVsZCA9IGZhbHNlO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZigoc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUhPVwiXCIpJiYoc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUhPXRheG9ub215X25hbWUpKVxyXG4gICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSBjdXJyZW50X3Jlc3VsdHNfdXJsO1xyXG4gICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZigoKGZpZWxkX3ZhbHVlPT1cIlwiKXx8KCEkZmllbGQpICkpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAkZm9ybS4kZmllbGRzLmVhY2goZnVuY3Rpb24gKCkge1xyXG5cclxuICAgICAgICAgICAgICAgIGlmICghJGZpZWxkKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZFR5cGUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmICgoZmllbGRUeXBlID09IFwidGFnXCIpIHx8IChmaWVsZFR5cGUgPT0gXCJjYXRlZ29yeVwiKSB8fCAoZmllbGRUeXBlID09IFwidGF4b25vbXlcIikpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHRheG9ub215X3ZhbHVlID0gc2VsZi5wcm9jZXNzVGF4b25vbXkoJCh0aGlzKSwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZpZWxkX25hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAodGF4b25vbXlfdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaWVsZF92YWx1ZSA9IHRheG9ub215X3ZhbHVlLnZhbHVlO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChmaWVsZF92YWx1ZSAhPSBcIlwiKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRmaWVsZCA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKCAoJGZpZWxkKSAmJiAoZmllbGRfdmFsdWUgIT0gXCJcIiApKSB7XHJcbiAgICAgICAgICAgIC8vaWYgd2UgZm91bmQgYSBmaWVsZFxyXG5cdFx0XHR2YXIgcmV3cml0ZV9hdHRyID0gKCRmaWVsZC5hdHRyKFwiZGF0YS1zZi10ZXJtLXJld3JpdGVcIikpO1xyXG5cclxuICAgICAgICAgICAgaWYocmV3cml0ZV9hdHRyIT1cIlwiKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHJld3JpdGUgPSBKU09OLnBhcnNlKHJld3JpdGVfYXR0cik7XHJcbiAgICAgICAgICAgICAgICB2YXIgaW5wdXRfdHlwZSA9ICRmaWVsZC5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hY3RpdmVfdGF4ID0gZmllbGRfbmFtZTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL2ZpbmQgdGhlIGFjdGl2ZSBlbGVtZW50XHJcbiAgICAgICAgICAgICAgICBpZiAoKGlucHV0X3R5cGUgPT0gXCJyYWRpb1wiKSB8fCAoaW5wdXRfdHlwZSA9PSBcImNoZWNrYm94XCIpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vdmFyICRhY3RpdmUgPSAkZmllbGQuZmluZChcIi5zZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vZXhwbG9kZSB0aGUgdmFsdWVzIGlmIHRoZXJlIGlzIGEgZGVsaW1cclxuICAgICAgICAgICAgICAgICAgICAvL2ZpZWxkX3ZhbHVlXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBpc19zaW5nbGVfdmFsdWUgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZF92YWx1ZXMgPSBmaWVsZF92YWx1ZS5zcGxpdChcIixcIikuam9pbihcIitcIikuc3BsaXQoXCIrXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChmaWVsZF92YWx1ZXMubGVuZ3RoID4gMSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpc19zaW5nbGVfdmFsdWUgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmIChpc19zaW5nbGVfdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkaW5wdXQgPSAkZmllbGQuZmluZChcImlucHV0W3ZhbHVlPSdcIiArIGZpZWxkX3ZhbHVlICsgXCInXVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkaW5wdXQucGFyZW50KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aCA9ICRhY3RpdmUuYXR0cihcImRhdGEtc2YtZGVwdGhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL25vdyBsb29wIHRocm91Z2ggcGFyZW50cyB0byBncmFiIHRoZWlyIG5hbWVzXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB2YWx1ZXMgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goZmllbGRfdmFsdWUpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgZm9yICh2YXIgaSA9IGRlcHRoOyBpID4gMDsgaS0tKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkYWN0aXZlID0gJGFjdGl2ZS5wYXJlbnQoKS5wYXJlbnQoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKCRhY3RpdmUuZmluZChcImlucHV0XCIpLnZhbCgpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnJldmVyc2UoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vZ3JhYiB0aGUgcmV3cml0ZSBmb3IgdGhpcyBkZXB0aFxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgYWN0aXZlX3Jld3JpdGUgPSByZXdyaXRlW2RlcHRoXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHVybCA9IGFjdGl2ZV9yZXdyaXRlO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vdGhlbiBtYXAgZnJvbSB0aGUgcGFyZW50cyB0byB0aGUgZGVwdGhcclxuICAgICAgICAgICAgICAgICAgICAgICAgJCh2YWx1ZXMpLmVhY2goZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybCA9IHVybC5yZXBsYWNlKFwiW1wiICsgaW5kZXggKyBcIl1cIiwgdmFsdWUpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSB1cmw7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pZiB0aGVyZSBhcmUgbXVsdGlwbGUgdmFsdWVzLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3RoZW4gd2UgbmVlZCB0byBjaGVjayBmb3IgMyB0aGluZ3M6XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2lmIHRoZSB2YWx1ZXMgc2VsZWN0ZWQgYXJlIGFsbCBpbiB0aGUgc2FtZSB0cmVlIHRoZW4gd2UgY2FuIGRvIHNvbWUgY2xldmVyIHJld3JpdGUgc3R1ZmZcclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9tZXJnZSBhbGwgdmFsdWVzIGluIHNhbWUgbGV2ZWwsIHRoZW4gY29tYmluZSB0aGUgbGV2ZWxzXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2lmIHRoZXkgYXJlIGZyb20gZGlmZmVyZW50IHRyZWVzIHRoZW4ganVzdCBjb21iaW5lIHRoZW0gb3IganVzdCB1c2UgYGZpZWxkX3ZhbHVlYFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvKlxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aHMgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICQoZmllbGRfdmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRpbnB1dCA9ICRmaWVsZC5maW5kKFwiaW5wdXRbdmFsdWU9J1wiICsgZmllbGRfdmFsdWUgKyBcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkaW5wdXQucGFyZW50KCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRlcHRoID0gJGFjdGl2ZS5hdHRyKFwiZGF0YS1zZi1kZXB0aFwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgIC8vZGVwdGhzLnB1c2goZGVwdGgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgIH0pOyovXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYgKChpbnB1dF90eXBlID09IFwic2VsZWN0XCIpIHx8IChpbnB1dF90eXBlID09IFwibXVsdGlzZWxlY3RcIikpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGlzX3NpbmdsZV92YWx1ZSA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX3ZhbHVlcyA9IGZpZWxkX3ZhbHVlLnNwbGl0KFwiLFwiKS5qb2luKFwiK1wiKS5zcGxpdChcIitcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGZpZWxkX3ZhbHVlcy5sZW5ndGggPiAxKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlzX3NpbmdsZV92YWx1ZSA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGlzX3NpbmdsZV92YWx1ZSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkZmllbGQuZmluZChcIm9wdGlvblt2YWx1ZT0nXCIgKyBmaWVsZF92YWx1ZSArIFwiJ11cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aCA9ICRhY3RpdmUuYXR0cihcImRhdGEtc2YtZGVwdGhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWVzID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKGZpZWxkX3ZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZvciAodmFyIGkgPSBkZXB0aDsgaSA+IDA7IGktLSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGFjdGl2ZSA9ICRhY3RpdmUucHJldkFsbChcIm9wdGlvbltkYXRhLXNmLWRlcHRoPSdcIiArIChpIC0gMSkgKyBcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goJGFjdGl2ZS52YWwoKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5yZXZlcnNlKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBhY3RpdmVfcmV3cml0ZSA9IHJld3JpdGVbZGVwdGhdO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdXJsID0gYWN0aXZlX3Jld3JpdGU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQodmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB1cmwgPSB1cmwucmVwbGFjZShcIltcIiArIGluZGV4ICsgXCJdXCIsIHZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gdXJsO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgfVxyXG4gICAgICAgIC8vdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IGN1cnJlbnRfcmVzdWx0c191cmw7XHJcbiAgICB9LFxyXG4gICAgZ2V0UmVzdWx0c1VybDogZnVuY3Rpb24oJGZvcm0sIGN1cnJlbnRfcmVzdWx0c191cmwpIHtcclxuXHJcbiAgICAgICAgLy90aGlzLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKCRmb3JtLCBjdXJyZW50X3Jlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgaWYodGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybD09XCJcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHJldHVybiBjdXJyZW50X3Jlc3VsdHNfdXJsO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgcmV0dXJuIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmw7XHJcbiAgICB9LFxyXG5cdGdldFVybFBhcmFtczogZnVuY3Rpb24oJGZvcm0pe1xyXG5cclxuXHRcdHRoaXMuYnVpbGRVcmxDb21wb25lbnRzKCRmb3JtLCB0cnVlKTtcclxuXHJcbiAgICAgICAgaWYodGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCE9XCJcIilcclxuICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICBpZih0aGlzLmFjdGl2ZV90YXghPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBmaWVsZF9uYW1lID0gdGhpcy5hY3RpdmVfdGF4O1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLnVybF9wYXJhbXNbZmllbGRfbmFtZV0pIT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGRlbGV0ZSB0aGlzLnVybF9wYXJhbXNbZmllbGRfbmFtZV07XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG5cdFx0cmV0dXJuIHRoaXMudXJsX3BhcmFtcztcclxuXHR9LFxyXG5cdGNsZWFyVXJsQ29tcG9uZW50czogZnVuY3Rpb24oKXtcclxuXHRcdC8vdGhpcy51cmxfY29tcG9uZW50cyA9IFwiXCI7XHJcblx0XHR0aGlzLnVybF9wYXJhbXMgPSB7fTtcclxuXHR9LFxyXG5cdGNsZWFyVGF4QXJjaGl2ZVJlc3VsdHNVcmw6IGZ1bmN0aW9uKCkge1xyXG5cdFx0dGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9ICcnO1xyXG5cdH0sXHJcblx0ZGlzYWJsZUlucHV0czogZnVuY3Rpb24oJGZvcm0pe1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHQkZm9ybS4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHJcblx0XHRcdHZhciAkaW5wdXRzID0gJCh0aGlzKS5maW5kKFwiaW5wdXQsIHNlbGVjdCwgLm1ldGEtc2xpZGVyXCIpO1xyXG5cdFx0XHQkaW5wdXRzLmF0dHIoXCJkaXNhYmxlZFwiLCBcImRpc2FibGVkXCIpO1xyXG5cdFx0XHQkaW5wdXRzLmF0dHIoXCJkaXNhYmxlZFwiLCB0cnVlKTtcclxuXHRcdFx0JGlucHV0cy5wcm9wKFwiZGlzYWJsZWRcIiwgdHJ1ZSk7XHJcblx0XHRcdCRpbnB1dHMudHJpZ2dlcihcImNob3Nlbjp1cGRhdGVkXCIpO1xyXG5cdFx0XHRcclxuXHRcdH0pO1xyXG5cdFx0XHJcblx0XHRcclxuXHR9LFxyXG5cdGVuYWJsZUlucHV0czogZnVuY3Rpb24oJGZvcm0pe1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdHZhciAkaW5wdXRzID0gJCh0aGlzKS5maW5kKFwiaW5wdXQsIHNlbGVjdCwgLm1ldGEtc2xpZGVyXCIpO1xyXG5cdFx0XHQkaW5wdXRzLnByb3AoXCJkaXNhYmxlZFwiLCBmYWxzZSk7XHJcblx0XHRcdCRpbnB1dHMuYXR0cihcImRpc2FibGVkXCIsIGZhbHNlKTtcclxuXHRcdFx0JGlucHV0cy50cmlnZ2VyKFwiY2hvc2VuOnVwZGF0ZWRcIik7XHRcdFx0XHJcblx0XHR9KTtcclxuXHRcdFxyXG5cdFx0XHJcblx0fSxcclxuXHRidWlsZFVybENvbXBvbmVudHM6IGZ1bmN0aW9uKCRmb3JtLCBjbGVhcl9jb21wb25lbnRzKXtcclxuXHRcdFxyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoY2xlYXJfY29tcG9uZW50cykhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGNsZWFyX2NvbXBvbmVudHM9PXRydWUpXHJcblx0XHRcdHtcclxuXHRcdFx0XHR0aGlzLmNsZWFyVXJsQ29tcG9uZW50cygpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdCRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcclxuXHRcdFx0dmFyIGZpZWxkTmFtZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHRcdFx0dmFyIGZpZWxkVHlwZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHRcdFx0XHJcblx0XHRcdGlmKGZpZWxkVHlwZT09XCJzZWFyY2hcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1NlYXJjaEZpZWxkKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoKGZpZWxkVHlwZT09XCJ0YWdcIil8fChmaWVsZFR5cGU9PVwiY2F0ZWdvcnlcIil8fChmaWVsZFR5cGU9PVwidGF4b25vbXlcIikpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NUYXhvbm9teSgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJzb3J0X29yZGVyXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NTb3J0T3JkZXJGaWVsZCgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0c19wZXJfcGFnZVwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzUmVzdWx0c1BlclBhZ2VGaWVsZCgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJhdXRob3JcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc0F1dGhvcigkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0X3R5cGVcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Bvc3RUeXBlKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInBvc3RfZGF0ZVwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzUG9zdERhdGUoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdF9tZXRhXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NQb3N0TWV0YSgkKHRoaXMpKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlXHJcblx0XHRcdHtcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH0pO1xyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzU2VhcmNoRmllbGQ6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHR2YXIgJGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiaW5wdXRbbmFtZV49J19zZl9zZWFyY2gnXVwiKTtcclxuXHRcdFxyXG5cdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0e1xyXG5cdFx0XHR2YXIgZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQudmFsKCk7XHJcblx0XHRcdFxyXG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZfc2Zfcz1cIitlbmNvZGVVUklDb21wb25lbnQoZmllbGRWYWwpO1xyXG5cdFx0XHRcdHNlbGYudXJsX3BhcmFtc1snX3NmX3MnXSA9IGVuY29kZVVSSUNvbXBvbmVudChmaWVsZFZhbCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHR9LFxyXG5cdHByb2Nlc3NTb3J0T3JkZXJGaWVsZDogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR0aGlzLnByb2Nlc3NBdXRob3IoJGNvbnRhaW5lcik7XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NSZXN1bHRzUGVyUGFnZUZpZWxkOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHRoaXMucHJvY2Vzc0F1dGhvcigkY29udGFpbmVyKTtcclxuXHRcdFxyXG5cdH0sXHJcblx0Z2V0QWN0aXZlVGF4OiBmdW5jdGlvbigkZmllbGQpIHtcclxuXHRcdHJldHVybiB0aGlzLmFjdGl2ZV90YXg7XHJcblx0fSxcclxuXHRnZXRTZWxlY3RWYWw6IGZ1bmN0aW9uKCRmaWVsZCl7XHJcblxyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0aWYoJGZpZWxkLnZhbCgpIT0wKVxyXG5cdFx0e1xyXG5cdFx0XHRmaWVsZFZhbCA9ICRmaWVsZC52YWwoKTtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYoZmllbGRWYWw9PW51bGwpXHJcblx0XHR7XHJcblx0XHRcdGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0cmV0dXJuIGZpZWxkVmFsO1xyXG5cdH0sXHJcblx0Z2V0TWV0YVNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkKXtcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0ZmllbGRWYWwgPSAkZmllbGQudmFsKCk7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0aWYoZmllbGRWYWw9PW51bGwpXHJcblx0XHR7XHJcblx0XHRcdGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0cmV0dXJuIGZpZWxkVmFsO1xyXG5cdH0sXHJcblx0Z2V0TXVsdGlTZWxlY3RWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xyXG5cdFx0XHJcblx0XHR2YXIgZGVsaW0gPSBcIitcIjtcclxuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXHJcblx0XHR7XHJcblx0XHRcdGRlbGltID0gXCIsXCI7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZigkZmllbGQudmFsKCkpPT1cIm9iamVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZigkZmllbGQudmFsKCkhPW51bGwpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRyZXR1cm4gJGZpZWxkLnZhbCgpLmpvaW4oZGVsaW0pO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHR9LFxyXG5cdGdldE1ldGFNdWx0aVNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XHJcblx0XHRcclxuXHRcdHZhciBkZWxpbSA9IFwiLSstXCI7XHJcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRkZWxpbSA9IFwiLSwtXCI7XHJcblx0XHR9XHJcblx0XHRcdFx0XHJcblx0XHRpZih0eXBlb2YoJGZpZWxkLnZhbCgpKT09XCJvYmplY3RcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoJGZpZWxkLnZhbCgpIT1udWxsKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIGZpZWxkdmFsID0gW107XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0JCgkZmllbGQudmFsKCkpLmVhY2goZnVuY3Rpb24oaW5kZXgsdmFsdWUpe1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRmaWVsZHZhbC5wdXNoKCh2YWx1ZSkpO1xyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdHJldHVybiBmaWVsZHZhbC5qb2luKGRlbGltKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gXCJcIjtcclxuXHRcdFxyXG5cdH0sXHJcblx0Z2V0Q2hlY2tib3hWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xyXG5cdFx0XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKXtcclxuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAkKHRoaXMpLnZhbCgpO1xyXG5cdFx0XHR9XHJcblx0XHR9KS5nZXQoKTtcclxuXHRcdFxyXG5cdFx0dmFyIGRlbGltID0gXCIrXCI7XHJcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRkZWxpbSA9IFwiLFwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWwuam9pbihkZWxpbSk7XHJcblx0fSxcclxuXHRnZXRNZXRhQ2hlY2tib3hWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xyXG5cdFx0XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKXtcclxuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAoJCh0aGlzKS52YWwoKSk7XHJcblx0XHRcdH1cclxuXHRcdH0pLmdldCgpO1xyXG5cdFx0XHJcblx0XHR2YXIgZGVsaW0gPSBcIi0rLVwiO1xyXG5cdFx0aWYob3BlcmF0b3I9PVwib3JcIilcclxuXHRcdHtcclxuXHRcdFx0ZGVsaW0gPSBcIi0sLVwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWwuam9pbihkZWxpbSk7XHJcblx0fSxcclxuXHRnZXRSYWRpb1ZhbDogZnVuY3Rpb24oJGZpZWxkKXtcclxuXHRcdFx0XHRcdFx0XHRcclxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKVxyXG5cdFx0e1xyXG5cdFx0XHRpZigkKHRoaXMpLnByb3AoXCJjaGVja2VkXCIpPT10cnVlKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0cmV0dXJuICQodGhpcykudmFsKCk7XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHR9KS5nZXQoKTtcclxuXHRcdFxyXG5cdFx0XHJcblx0XHRpZihmaWVsZFZhbFswXSE9MClcclxuXHRcdHtcclxuXHRcdFx0cmV0dXJuIGZpZWxkVmFsWzBdO1xyXG5cdFx0fVxyXG5cdH0sXHJcblx0Z2V0TWV0YVJhZGlvVmFsOiBmdW5jdGlvbigkZmllbGQpe1xyXG5cdFx0XHRcdFx0XHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpXHJcblx0XHR7XHJcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRyZXR1cm4gJCh0aGlzKS52YWwoKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH0pLmdldCgpO1xyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWxbMF07XHJcblx0fSxcclxuXHRwcm9jZXNzQXV0aG9yOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuXHRcdFxyXG5cdFx0dmFyICRmaWVsZDtcclxuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRTZWxlY3RWYWwoJGZpZWxkKTsgXHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0dmFyIG9wZXJhdG9yID0gJGZpZWxkLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE11bHRpU2VsZWN0VmFsKCRmaWVsZCwgXCJvclwiKTtcclxuXHRcdFx0XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJjaGVja2JveFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xyXG5cdFx0XHRcclxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIikuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldENoZWNrYm94VmFsKCRmaWVsZCwgXCJvclwiKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhZGlvXCIpXHJcblx0XHR7XHJcblx0XHRcdFxyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnJhZGlvXCIpO1xyXG5cdFx0XHRcdFx0XHRcclxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRSYWRpb1ZhbCgkZmllbGQpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0dmFyIGZpZWxkU2x1ZyA9IFwiXCI7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoZmllbGROYW1lPT1cIl9zZl9hdXRob3JcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcImF1dGhvcnNcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZSBpZihmaWVsZE5hbWU9PVwiX3NmX3NvcnRfb3JkZXJcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcInNvcnRfb3JkZXJcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZSBpZihmaWVsZE5hbWU9PVwiX3NmX3BwcFwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwiX3NmX3BwcFwiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlIGlmKGZpZWxkTmFtZT09XCJfc2ZfcG9zdF90eXBlXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJwb3N0X3R5cGVzXCI7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2VcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKGZpZWxkU2x1ZyE9XCJcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZmllbGRTbHVnK1wiPVwiK2ZpZWxkVmFsO1xyXG5cdFx0XHRcdFx0c2VsZi51cmxfcGFyYW1zW2ZpZWxkU2x1Z10gPSBmaWVsZFZhbDtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdH0sXHJcblx0cHJvY2Vzc1Bvc3RUeXBlIDogZnVuY3Rpb24oJHRoaXMpe1xyXG5cdFx0XHJcblx0XHR0aGlzLnByb2Nlc3NBdXRob3IoJHRoaXMpO1xyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzUG9zdE1ldGE6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuXHRcdHZhciBtZXRhVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtbWV0YS10eXBlXCIpO1xyXG5cclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHR2YXIgJGZpZWxkO1xyXG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XHJcblx0XHRcclxuXHRcdGlmKG1ldGFUeXBlPT1cIm51bWJlclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihpbnB1dFR5cGU9PVwicmFuZ2UtbnVtYmVyXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1udW1iZXIgaW5wdXRcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIHZhbHVlcyA9IFtdO1xyXG5cdFx0XHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdHZhbHVlcy5wdXNoKCQodGhpcykudmFsKCkpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gdmFsdWVzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLXNsaWRlclwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyIGlucHV0XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdC8vZ2V0IGFueSBudW1iZXIgZm9ybWF0dGluZyBzdHVmZlxyXG5cdFx0XHRcdHZhciAkbWV0YV9yYW5nZSA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNsaWRlclwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgZGVjaW1hbF9wbGFjZXMgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1kZWNpbWFsLXBsYWNlc1wiKTtcclxuXHRcdFx0XHR2YXIgdGhvdXNhbmRfc2VwZXJhdG9yID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtdGhvdXNhbmQtc2VwZXJhdG9yXCIpO1xyXG5cdFx0XHRcdHZhciBkZWNpbWFsX3NlcGVyYXRvciA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLWRlY2ltYWwtc2VwZXJhdG9yXCIpO1xyXG5cclxuXHRcdFx0XHR2YXIgZmllbGRfZm9ybWF0ID0gd051bWIoe1xyXG5cdFx0XHRcdFx0bWFyazogZGVjaW1hbF9zZXBlcmF0b3IsXHJcblx0XHRcdFx0XHRkZWNpbWFsczogcGFyc2VGbG9hdChkZWNpbWFsX3BsYWNlcyksXHJcblx0XHRcdFx0XHR0aG91c2FuZDogdGhvdXNhbmRfc2VwZXJhdG9yXHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIHZhbHVlcyA9IFtdO1xyXG5cclxuXHJcblx0XHRcdFx0dmFyIHNsaWRlcl9vYmplY3QgPSAkY29udGFpbmVyLmZpbmQoXCIubWV0YS1zbGlkZXJcIilbMF07XHJcblx0XHRcdFx0Ly92YWwgZnJvbSBzbGlkZXIgb2JqZWN0XHJcblx0XHRcdFx0dmFyIHNsaWRlcl92YWwgPSBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZ2V0KCk7XHJcblxyXG5cdFx0XHRcdHZhbHVlcy5wdXNoKGZpZWxkX2Zvcm1hdC5mcm9tKHNsaWRlcl92YWxbMF0pKTtcclxuXHRcdFx0XHR2YWx1ZXMucHVzaChmaWVsZF9mb3JtYXQuZnJvbShzbGlkZXJfdmFsWzFdKSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSB2YWx1ZXMuam9pbihcIitcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1yYWRpb1wiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLWlucHV0LXJhbmdlLXJhZGlvXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg9PTApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0Ly90aGVuIHRyeSBhZ2Fpbiwgd2UgbXVzdCBiZSB1c2luZyBhIHNpbmdsZSBmaWVsZFxyXG5cdFx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdHZhciAkbWV0YV9yYW5nZSA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdC8vdGhlcmUgaXMgYW4gZWxlbWVudCB3aXRoIGEgZnJvbS90byBjbGFzcyAtIHNvIHdlIG5lZWQgdG8gZ2V0IHRoZSB2YWx1ZXMgb2YgdGhlIGZyb20gJiB0byBpbnB1dCBmaWVsZHMgc2VwZXJhdGVseVxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHRcclxuXHRcdFx0XHRcdHZhciBmaWVsZF92YWxzID0gW107XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0XHR2YXIgJHJhZGlvcyA9ICQodGhpcykuZmluZChcIi5zZi1pbnB1dC1yYWRpb1wiKTtcclxuXHRcdFx0XHRcdFx0ZmllbGRfdmFscy5wdXNoKHNlbGYuZ2V0TWV0YVJhZGlvVmFsKCRyYWRpb3MpKTtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0XHR9KTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0Ly9wcmV2ZW50IHNlY29uZCBudW1iZXIgZnJvbSBiZWluZyBsb3dlciB0aGFuIHRoZSBmaXJzdFxyXG5cdFx0XHRcdFx0aWYoZmllbGRfdmFscy5sZW5ndGg9PTIpXHJcblx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdGlmKE51bWJlcihmaWVsZF92YWxzWzFdKTxOdW1iZXIoZmllbGRfdmFsc1swXSkpXHJcblx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRmaWVsZF92YWxzWzFdID0gZmllbGRfdmFsc1swXTtcclxuXHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkX3ZhbHMuam9pbihcIitcIik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD09MSlcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuZmluZChcIi5zZi1pbnB1dC1yYWRpb1wiKS5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1zZWxlY3RcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1pbnB1dC1zZWxlY3RcIik7XHJcblx0XHRcdFx0dmFyICRtZXRhX3JhbmdlID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2VcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0Ly90aGVyZSBpcyBhbiBlbGVtZW50IHdpdGggYSBmcm9tL3RvIGNsYXNzIC0gc28gd2UgbmVlZCB0byBnZXQgdGhlIHZhbHVlcyBvZiB0aGUgZnJvbSAmIHRvIGlucHV0IGZpZWxkcyBzZXBlcmF0ZWx5XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdHZhciBmaWVsZF92YWxzID0gW107XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0XHR2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG5cdFx0XHRcdFx0XHRmaWVsZF92YWxzLnB1c2goc2VsZi5nZXRNZXRhU2VsZWN0VmFsKCR0aGlzKSk7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdC8vcHJldmVudCBzZWNvbmQgbnVtYmVyIGZyb20gYmVpbmcgbG93ZXIgdGhhbiB0aGUgZmlyc3RcclxuXHRcdFx0XHRcdGlmKGZpZWxkX3ZhbHMubGVuZ3RoPT0yKVxyXG5cdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRpZihOdW1iZXIoZmllbGRfdmFsc1sxXSk8TnVtYmVyKGZpZWxkX3ZhbHNbMF0pKVxyXG5cdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0ZmllbGRfdmFsc1sxXSA9IGZpZWxkX3ZhbHNbMF07XHJcblx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkX3ZhbHMuam9pbihcIitcIik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD09MSlcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2VcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1jaGVja2JveFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpjaGVja2JveFwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldENoZWNrYm94VmFsKCRmaWVsZCwgXCJhbmRcIik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0XHRpZihmaWVsZE5hbWU9PVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdGVsc2UgaWYobWV0YVR5cGU9PVwiY2hvaWNlXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGlucHV0VHlwZT09XCJzZWxlY3RcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YVNlbGVjdFZhbCgkZmllbGQpOyBcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRmaWVsZC5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YU11bHRpU2VsZWN0VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cImNoZWNrYm94XCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHR2YXIgb3BlcmF0b3IgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE1ldGFDaGVja2JveFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFkaW9cIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6cmFkaW9cIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhUmFkaW9WYWwoJGZpZWxkKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkVmFsKTtcclxuXHRcdFx0aWYodHlwZW9mKCRmaWVsZCkhPT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0Ly9mb3IgdGhvc2Ugd2hvIGluc2lzdCBvbiB1c2luZyAmIGFtcGVyc2FuZHMgaW4gdGhlIG5hbWUgb2YgdGhlIGN1c3RvbSBmaWVsZCAoISlcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9IChmaWVsZE5hbWUpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYobWV0YVR5cGU9PVwiZGF0ZVwiKVxyXG5cdFx0e1xyXG5cdFx0XHRzZWxmLnByb2Nlc3NQb3N0RGF0ZSgkY29udGFpbmVyKTtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkTmFtZSkrXCI9XCIrKGZpZWxkVmFsKTtcclxuXHRcdFx0XHRzZWxmLnVybF9wYXJhbXNbZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkTmFtZSldID0gKGZpZWxkVmFsKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdH0sXHJcblx0cHJvY2Vzc1Bvc3REYXRlOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHRcdHZhciBpbnB1dFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XHJcblx0XHRcclxuXHRcdHZhciAkZmllbGQ7XHJcblx0XHR2YXIgZmllbGROYW1lID0gXCJcIjtcclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHRcclxuXHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6dGV4dFwiKTtcclxuXHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFxyXG5cdFx0dmFyIGRhdGVzID0gW107XHJcblx0XHQkZmllbGQuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcclxuXHRcdFx0ZGF0ZXMucHVzaCgkKHRoaXMpLnZhbCgpKTtcclxuXHRcdFxyXG5cdFx0fSk7XHJcblx0XHRcclxuXHRcdGlmKCRmaWVsZC5sZW5ndGg9PTIpXHJcblx0XHR7XHJcblx0XHRcdGlmKChkYXRlc1swXSE9XCJcIil8fChkYXRlc1sxXSE9XCJcIikpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IGRhdGVzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gZmllbGRWYWwucmVwbGFjZSgvXFwvL2csJycpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKCRmaWVsZC5sZW5ndGg9PTEpXHJcblx0XHR7XHJcblx0XHRcdGlmKGRhdGVzWzBdIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBkYXRlcy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkVmFsLnJlcGxhY2UoL1xcLy9nLCcnKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoZmllbGRWYWwpIT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHZhciBmaWVsZFNsdWcgPSBcIlwiO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKGZpZWxkTmFtZT09XCJfc2ZfcG9zdF9kYXRlXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJwb3N0X2RhdGVcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IGZpZWxkTmFtZTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoZmllbGRTbHVnIT1cIlwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZFNsdWcrXCI9XCIrZmllbGRWYWw7XHJcblx0XHRcdFx0XHRzZWxmLnVybF9wYXJhbXNbZmllbGRTbHVnXSA9IGZpZWxkVmFsO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzVGF4b25vbXk6IGZ1bmN0aW9uKCRjb250YWluZXIsIHJldHVybl9vYmplY3QpXHJcblx0e1xyXG4gICAgICAgIGlmKHR5cGVvZihyZXR1cm5fb2JqZWN0KT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHJldHVybl9vYmplY3QgPSBmYWxzZTtcclxuICAgICAgICB9XHJcblxyXG5cdFx0Ly9pZigpXHRcdFx0XHRcdFxyXG5cdFx0Ly92YXIgZmllbGROYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFxyXG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHRcdHZhciBpbnB1dFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XHJcblx0XHRcclxuXHRcdHZhciAkZmllbGQ7XHJcblx0XHR2YXIgZmllbGROYW1lID0gXCJcIjtcclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHRcclxuXHRcdGlmKGlucHV0VHlwZT09XCJzZWxlY3RcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFxyXG5cdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0U2VsZWN0VmFsKCRmaWVsZCk7IFxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwibXVsdGlzZWxlY3RcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdHZhciBvcGVyYXRvciA9ICRmaWVsZC5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNdWx0aVNlbGVjdFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cImNoZWNrYm94XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XHJcblx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgb3BlcmF0b3IgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRDaGVja2JveFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFkaW9cIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpyYWRpb1wiKTtcclxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRSYWRpb1ZhbCgkZmllbGQpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcbiAgICAgICAgICAgICAgICBpZihyZXR1cm5fb2JqZWN0PT10cnVlKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB7bmFtZTogZmllbGROYW1lLCB2YWx1ZTogZmllbGRWYWx9O1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZE5hbWUrXCI9XCIrZmllbGRWYWw7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi51cmxfcGFyYW1zW2ZpZWxkTmFtZV0gPSBmaWVsZFZhbDtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcbiAgICAgICAgaWYocmV0dXJuX29iamVjdD09dHJ1ZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICB9XHJcblx0fVxyXG59OyJdfQ==
},{}],5:[function(require,module,exports){

module.exports = {
	
	searchForms: {},
	
	init: function(){
		
		
	},
	addSearchForm: function(id, object){
		
		this.searchForms[id] = object;
	},
	getSearchForm: function(id)
	{
		return this.searchForms[id];	
	}
	
};
},{}],6:[function(require,module,exports){
(function (global){

var $ 				= (typeof window !== "undefined" ? window['jQuery'] : typeof global !== "undefined" ? global['jQuery'] : null);

module.exports = {
	
	init: function(){
		$(document).on("sf:ajaxfinish", ".searchandfilter", function( e, data ) {
			var display_method = data.object.display_result_method;
			if ( display_method === 'custom_edd_store' ) {
				$('input.edd-add-to-cart').css('display', "none");
				$('a.edd-add-to-cart').addClass('edd-has-js');
			} else if ( display_method === 'custom_layouts' ) {
				if ( $('.cl-layout').hasClass( 'cl-layout--masonry' ) ) {
					//then re-init masonry
					const masonryContainer = document.querySelectorAll( '.cl-layout--masonry' );
					if ( masonryContainer.length > 0 ) {
						const customLayoutGrid = new Masonry( '.cl-layout--masonry', {
							// options...
							itemSelector: '.cl-layout__item',
							//columnWidth: 319
							percentPosition: true,
							//gutter: 10,
							transitionDuration: 0,
						} );
						imagesLoaded( masonryContainer ).on( 'progress', function() {
							customLayoutGrid.layout();
						} );
					}
				}
			}
		});
	},

};
}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3RoaXJkcGFydHkuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IjtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyJcbnZhciAkIFx0XHRcdFx0PSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xuXG5tb2R1bGUuZXhwb3J0cyA9IHtcblx0XG5cdGluaXQ6IGZ1bmN0aW9uKCl7XG5cdFx0JChkb2N1bWVudCkub24oXCJzZjphamF4ZmluaXNoXCIsIFwiLnNlYXJjaGFuZGZpbHRlclwiLCBmdW5jdGlvbiggZSwgZGF0YSApIHtcblx0XHRcdHZhciBkaXNwbGF5X21ldGhvZCA9IGRhdGEub2JqZWN0LmRpc3BsYXlfcmVzdWx0X21ldGhvZDtcblx0XHRcdGlmICggZGlzcGxheV9tZXRob2QgPT09ICdjdXN0b21fZWRkX3N0b3JlJyApIHtcblx0XHRcdFx0JCgnaW5wdXQuZWRkLWFkZC10by1jYXJ0JykuY3NzKCdkaXNwbGF5JywgXCJub25lXCIpO1xuXHRcdFx0XHQkKCdhLmVkZC1hZGQtdG8tY2FydCcpLmFkZENsYXNzKCdlZGQtaGFzLWpzJyk7XG5cdFx0XHR9IGVsc2UgaWYgKCBkaXNwbGF5X21ldGhvZCA9PT0gJ2N1c3RvbV9sYXlvdXRzJyApIHtcblx0XHRcdFx0aWYgKCAkKCcuY2wtbGF5b3V0JykuaGFzQ2xhc3MoICdjbC1sYXlvdXQtLW1hc29ucnknICkgKSB7XG5cdFx0XHRcdFx0Ly90aGVuIHJlLWluaXQgbWFzb25yeVxuXHRcdFx0XHRcdGNvbnN0IG1hc29ucnlDb250YWluZXIgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCAnLmNsLWxheW91dC0tbWFzb25yeScgKTtcblx0XHRcdFx0XHRpZiAoIG1hc29ucnlDb250YWluZXIubGVuZ3RoID4gMCApIHtcblx0XHRcdFx0XHRcdGNvbnN0IGN1c3RvbUxheW91dEdyaWQgPSBuZXcgTWFzb25yeSggJy5jbC1sYXlvdXQtLW1hc29ucnknLCB7XG5cdFx0XHRcdFx0XHRcdC8vIG9wdGlvbnMuLi5cblx0XHRcdFx0XHRcdFx0aXRlbVNlbGVjdG9yOiAnLmNsLWxheW91dF9faXRlbScsXG5cdFx0XHRcdFx0XHRcdC8vY29sdW1uV2lkdGg6IDMxOVxuXHRcdFx0XHRcdFx0XHRwZXJjZW50UG9zaXRpb246IHRydWUsXG5cdFx0XHRcdFx0XHRcdC8vZ3V0dGVyOiAxMCxcblx0XHRcdFx0XHRcdFx0dHJhbnNpdGlvbkR1cmF0aW9uOiAwLFxuXHRcdFx0XHRcdFx0fSApO1xuXHRcdFx0XHRcdFx0aW1hZ2VzTG9hZGVkKCBtYXNvbnJ5Q29udGFpbmVyICkub24oICdwcm9ncmVzcycsIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdFx0XHRjdXN0b21MYXlvdXRHcmlkLmxheW91dCgpO1xuXHRcdFx0XHRcdFx0fSApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH0pO1xuXHR9LFxuXG59OyJdfQ==
},{}]},{},[1])
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9hcHAuanMiLCJub2RlX21vZHVsZXMvbm91aXNsaWRlci9kaXN0cmlidXRlL25vdWlzbGlkZXIuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9wbHVnaW4uanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9wcm9jZXNzX2Zvcm0uanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9zdGF0ZS5qcyIsInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3RoaXJkcGFydHkuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQ3RRQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUMxeUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUM5dEVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQzU4QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDbEJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gZSh0LG4scil7ZnVuY3Rpb24gcyhvLHUpe2lmKCFuW29dKXtpZighdFtvXSl7dmFyIGE9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtpZighdSYmYSlyZXR1cm4gYShvLCEwKTtpZihpKXJldHVybiBpKG8sITApO3ZhciBmPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIrbytcIidcIik7dGhyb3cgZi5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGZ9dmFyIGw9bltvXT17ZXhwb3J0czp7fX07dFtvXVswXS5jYWxsKGwuZXhwb3J0cyxmdW5jdGlvbihlKXt2YXIgbj10W29dWzFdW2VdO3JldHVybiBzKG4/bjplKX0sbCxsLmV4cG9ydHMsZSx0LG4scil9cmV0dXJuIG5bb10uZXhwb3J0c312YXIgaT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2Zvcih2YXIgbz0wO288ci5sZW5ndGg7bysrKXMocltvXSk7cmV0dXJuIHN9KSIsIihmdW5jdGlvbiAoZ2xvYmFsKXtcblxyXG52YXIgc3RhdGUgPSByZXF1aXJlKCcuL2luY2x1ZGVzL3N0YXRlJyk7XHJcbnZhciBwbHVnaW4gPSByZXF1aXJlKCcuL2luY2x1ZGVzL3BsdWdpbicpO1xyXG5cclxuXHJcbihmdW5jdGlvbiAoICQgKSB7XHJcblxyXG5cdFwidXNlIHN0cmljdFwiO1xyXG5cclxuXHQkKGZ1bmN0aW9uICgpIHtcclxuXHJcblx0XHRpZiAoIU9iamVjdC5rZXlzKSB7XHJcblx0XHQgIE9iamVjdC5rZXlzID0gKGZ1bmN0aW9uICgpIHtcclxuXHRcdFx0J3VzZSBzdHJpY3QnO1xyXG5cdFx0XHR2YXIgaGFzT3duUHJvcGVydHkgPSBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LFxyXG5cdFx0XHRcdGhhc0RvbnRFbnVtQnVnID0gISh7dG9TdHJpbmc6IG51bGx9KS5wcm9wZXJ0eUlzRW51bWVyYWJsZSgndG9TdHJpbmcnKSxcclxuXHRcdFx0XHRkb250RW51bXMgPSBbXHJcblx0XHRcdFx0ICAndG9TdHJpbmcnLFxyXG5cdFx0XHRcdCAgJ3RvTG9jYWxlU3RyaW5nJyxcclxuXHRcdFx0XHQgICd2YWx1ZU9mJyxcclxuXHRcdFx0XHQgICdoYXNPd25Qcm9wZXJ0eScsXHJcblx0XHRcdFx0ICAnaXNQcm90b3R5cGVPZicsXHJcblx0XHRcdFx0ICAncHJvcGVydHlJc0VudW1lcmFibGUnLFxyXG5cdFx0XHRcdCAgJ2NvbnN0cnVjdG9yJ1xyXG5cdFx0XHRcdF0sXHJcblx0XHRcdFx0ZG9udEVudW1zTGVuZ3RoID0gZG9udEVudW1zLmxlbmd0aDtcclxuXHJcblx0XHRcdHJldHVybiBmdW5jdGlvbiAob2JqKSB7XHJcblx0XHRcdCAgaWYgKHR5cGVvZiBvYmogIT09ICdvYmplY3QnICYmICh0eXBlb2Ygb2JqICE9PSAnZnVuY3Rpb24nIHx8IG9iaiA9PT0gbnVsbCkpIHtcclxuXHRcdFx0XHR0aHJvdyBuZXcgVHlwZUVycm9yKCdPYmplY3Qua2V5cyBjYWxsZWQgb24gbm9uLW9iamVjdCcpO1xyXG5cdFx0XHQgIH1cclxuXHJcblx0XHRcdCAgdmFyIHJlc3VsdCA9IFtdLCBwcm9wLCBpO1xyXG5cclxuXHRcdFx0ICBmb3IgKHByb3AgaW4gb2JqKSB7XHJcblx0XHRcdFx0aWYgKGhhc093blByb3BlcnR5LmNhbGwob2JqLCBwcm9wKSkge1xyXG5cdFx0XHRcdCAgcmVzdWx0LnB1c2gocHJvcCk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHQgIH1cclxuXHJcblx0XHRcdCAgaWYgKGhhc0RvbnRFbnVtQnVnKSB7XHJcblx0XHRcdFx0Zm9yIChpID0gMDsgaSA8IGRvbnRFbnVtc0xlbmd0aDsgaSsrKSB7XHJcblx0XHRcdFx0ICBpZiAoaGFzT3duUHJvcGVydHkuY2FsbChvYmosIGRvbnRFbnVtc1tpXSkpIHtcclxuXHRcdFx0XHRcdHJlc3VsdC5wdXNoKGRvbnRFbnVtc1tpXSk7XHJcblx0XHRcdFx0ICB9XHJcblx0XHRcdFx0fVxyXG5cdFx0XHQgIH1cclxuXHRcdFx0ICByZXR1cm4gcmVzdWx0O1xyXG5cdFx0XHR9O1xyXG5cdFx0ICB9KCkpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8qIFNlYXJjaCAmIEZpbHRlciBqUXVlcnkgUGx1Z2luICovXHJcblx0XHQkLmZuLnNlYXJjaEFuZEZpbHRlciA9IHBsdWdpbjtcclxuXHJcblx0XHQvKiBpbml0ICovXHJcblx0XHQkKFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuXHJcblx0XHQvKiBleHRlcm5hbCBjb250cm9scyAqL1xyXG5cdFx0JChkb2N1bWVudCkub24oXCJjbGlja1wiLCBcIi5zZWFyY2gtZmlsdGVyLXJlc2V0XCIsIGZ1bmN0aW9uKGUpe1xyXG5cclxuXHRcdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG5cclxuXHRcdFx0dmFyIHNlYXJjaEZvcm1JRCA9IHR5cGVvZigkKHRoaXMpLmF0dHIoXCJkYXRhLXNlYXJjaC1mb3JtLWlkXCIpKSE9XCJ1bmRlZmluZWRcIiA/ICQodGhpcykuYXR0cihcImRhdGEtc2VhcmNoLWZvcm0taWRcIikgOiBcIlwiO1xyXG5cdFx0XHR2YXIgc3VibWl0Rm9ybSA9IHR5cGVvZigkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLXN1Ym1pdC1mb3JtXCIpKSE9XCJ1bmRlZmluZWRcIiA/ICQodGhpcykuYXR0cihcImRhdGEtc2Ytc3VibWl0LWZvcm1cIikgOiBcIlwiO1xyXG5cclxuXHRcdFx0c3RhdGUuZ2V0U2VhcmNoRm9ybShzZWFyY2hGb3JtSUQpLnJlc2V0KHN1Ym1pdEZvcm0pO1xyXG5cclxuXHRcdFx0Ly92YXIgJGxpbmtlZCA9ICQoXCIjc2VhcmNoLWZpbHRlci1mb3JtLVwiK3NlYXJjaEZvcm1JRCkuc2VhcmNoRmlsdGVyRm9ybSh7YWN0aW9uOiBcInJlc2V0XCJ9KTtcclxuXHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHJcblx0XHR9KTtcclxuXHJcblx0fSk7XHJcblxyXG5cclxuLypcclxuICogalF1ZXJ5IEVhc2luZyB2MS40LjEgLSBodHRwOi8vZ3NnZC5jby51ay9zYW5kYm94L2pxdWVyeS9lYXNpbmcvXHJcbiAqIE9wZW4gc291cmNlIHVuZGVyIHRoZSBCU0QgTGljZW5zZS5cclxuICogQ29weXJpZ2h0IMKpIDIwMDggR2VvcmdlIE1jR2lubGV5IFNtaXRoXHJcbiAqIEFsbCByaWdodHMgcmVzZXJ2ZWQuXHJcbiAqIGh0dHBzOi8vcmF3LmdpdGh1Yi5jb20vZ2RzbWl0aC9qcXVlcnkuZWFzaW5nL21hc3Rlci9MSUNFTlNFXHJcbiovXHJcblxyXG4vKiBnbG9iYWxzIGpRdWVyeSwgZGVmaW5lLCBtb2R1bGUsIHJlcXVpcmUgKi9cclxuKGZ1bmN0aW9uIChmYWN0b3J5KSB7XHJcblx0aWYgKHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kKSB7XHJcblx0XHRkZWZpbmUoWydqcXVlcnknXSwgZnVuY3Rpb24gKCQpIHtcclxuXHRcdFx0cmV0dXJuIGZhY3RvcnkoJCk7XHJcblx0XHR9KTtcclxuXHR9IGVsc2UgaWYgKHR5cGVvZiBtb2R1bGUgPT09IFwib2JqZWN0XCIgJiYgdHlwZW9mIG1vZHVsZS5leHBvcnRzID09PSBcIm9iamVjdFwiKSB7XHJcblx0XHRtb2R1bGUuZXhwb3J0cyA9IGZhY3RvcnkoKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKSk7XHJcblx0fSBlbHNlIHtcclxuXHRcdGZhY3RvcnkoalF1ZXJ5KTtcclxuXHR9XHJcbn0pKGZ1bmN0aW9uKCQpe1xyXG5cclxuXHQvLyBQcmVzZXJ2ZSB0aGUgb3JpZ2luYWwgalF1ZXJ5IFwic3dpbmdcIiBlYXNpbmcgYXMgXCJqc3dpbmdcIlxyXG5cdGlmICh0eXBlb2YgJC5lYXNpbmcgIT09ICd1bmRlZmluZWQnKSB7XHJcblx0XHQkLmVhc2luZ1snanN3aW5nJ10gPSAkLmVhc2luZ1snc3dpbmcnXTtcclxuXHR9XHJcblxyXG5cdHZhciBwb3cgPSBNYXRoLnBvdyxcclxuXHRcdHNxcnQgPSBNYXRoLnNxcnQsXHJcblx0XHRzaW4gPSBNYXRoLnNpbixcclxuXHRcdGNvcyA9IE1hdGguY29zLFxyXG5cdFx0UEkgPSBNYXRoLlBJLFxyXG5cdFx0YzEgPSAxLjcwMTU4LFxyXG5cdFx0YzIgPSBjMSAqIDEuNTI1LFxyXG5cdFx0YzMgPSBjMSArIDEsXHJcblx0XHRjNCA9ICggMiAqIFBJICkgLyAzLFxyXG5cdFx0YzUgPSAoIDIgKiBQSSApIC8gNC41O1xyXG5cclxuXHQvLyB4IGlzIHRoZSBmcmFjdGlvbiBvZiBhbmltYXRpb24gcHJvZ3Jlc3MsIGluIHRoZSByYW5nZSAwLi4xXHJcblx0ZnVuY3Rpb24gYm91bmNlT3V0KHgpIHtcclxuXHRcdHZhciBuMSA9IDcuNTYyNSxcclxuXHRcdFx0ZDEgPSAyLjc1O1xyXG5cdFx0aWYgKCB4IDwgMS9kMSApIHtcclxuXHRcdFx0cmV0dXJuIG4xKngqeDtcclxuXHRcdH0gZWxzZSBpZiAoIHggPCAyL2QxICkge1xyXG5cdFx0XHRyZXR1cm4gbjEqKHgtPSgxLjUvZDEpKSp4ICsgLjc1O1xyXG5cdFx0fSBlbHNlIGlmICggeCA8IDIuNS9kMSApIHtcclxuXHRcdFx0cmV0dXJuIG4xKih4LT0oMi4yNS9kMSkpKnggKyAuOTM3NTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdHJldHVybiBuMSooeC09KDIuNjI1L2QxKSkqeCArIC45ODQzNzU7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQkLmV4dGVuZCggJC5lYXNpbmcsIHtcclxuXHRcdGRlZjogJ2Vhc2VPdXRRdWFkJyxcclxuXHRcdHN3aW5nOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gJC5lYXNpbmdbJC5lYXNpbmcuZGVmXSh4KTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5RdWFkOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dFF1YWQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxIC0gKCAxIC0geCApICogKCAxIC0geCApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dFF1YWQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQyICogeCAqIHggOlxyXG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDIgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluQ3ViaWM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ICogeCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEN1YmljOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gMSAtIHBvdyggMSAtIHgsIDMgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRDdWJpYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xyXG5cdFx0XHRcdDQgKiB4ICogeCAqIHggOlxyXG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDMgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluUXVhcnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ICogeCAqIHggKiB4O1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRRdWFydDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCA0ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0UXVhcnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQ4ICogeCAqIHggKiB4ICogeCA6XHJcblx0XHRcdFx0MSAtIHBvdyggLTIgKiB4ICsgMiwgNCApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5RdWludDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggKiB4ICogeCAqIHggKiB4O1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRRdWludDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCA1ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0UXVpbnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQxNiAqIHggKiB4ICogeCAqIHggKiB4IDpcclxuXHRcdFx0XHQxIC0gcG93KCAtMiAqIHggKyAyLCA1ICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJblNpbmU6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxIC0gY29zKCB4ICogUEkvMiApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRTaW5lOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gc2luKCB4ICogUEkvMiApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dFNpbmU6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAtKCBjb3MoIFBJICogeCApIC0gMSApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5FeHBvOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiBwb3coIDIsIDEwICogeCAtIDEwICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEV4cG86IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAxID8gMSA6IDEgLSBwb3coIDIsIC0xMCAqIHggKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRFeHBvOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6IHggPCAwLjUgP1xyXG5cdFx0XHRcdHBvdyggMiwgMjAgKiB4IC0gMTAgKSAvIDIgOlxyXG5cdFx0XHRcdCggMiAtIHBvdyggMiwgLTIwICogeCArIDEwICkgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluQ2lyYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBzcXJ0KCAxIC0gcG93KCB4LCAyICkgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0Q2lyYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHNxcnQoIDEgLSBwb3coIHggLSAxLCAyICkgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRDaXJjOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCAxIC0gc3FydCggMSAtIHBvdyggMiAqIHgsIDIgKSApICkgLyAyIDpcclxuXHRcdFx0XHQoIHNxcnQoIDEgLSBwb3coIC0yICogeCArIDIsIDIgKSApICsgMSApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5FbGFzdGljOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6XHJcblx0XHRcdFx0LXBvdyggMiwgMTAgKiB4IC0gMTAgKSAqIHNpbiggKCB4ICogMTAgLSAxMC43NSApICogYzQgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0RWxhc3RpYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPT09IDAgPyAwIDogeCA9PT0gMSA/IDEgOlxyXG5cdFx0XHRcdHBvdyggMiwgLTEwICogeCApICogc2luKCAoIHggKiAxMCAtIDAuNzUgKSAqIGM0ICkgKyAxO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dEVsYXN0aWM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHggPT09IDEgPyAxIDogeCA8IDAuNSA/XHJcblx0XHRcdFx0LSggcG93KCAyLCAyMCAqIHggLSAxMCApICogc2luKCAoIDIwICogeCAtIDExLjEyNSApICogYzUgKSkgLyAyIDpcclxuXHRcdFx0XHRwb3coIDIsIC0yMCAqIHggKyAxMCApICogc2luKCAoIDIwICogeCAtIDExLjEyNSApICogYzUgKSAvIDIgKyAxO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbkJhY2s6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiBjMyAqIHggKiB4ICogeCAtIGMxICogeCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEJhY2s6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxICsgYzMgKiBwb3coIHggLSAxLCAzICkgKyBjMSAqIHBvdyggeCAtIDEsIDIgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRCYWNrOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCBwb3coIDIgKiB4LCAyICkgKiAoICggYzIgKyAxICkgKiAyICogeCAtIGMyICkgKSAvIDIgOlxyXG5cdFx0XHRcdCggcG93KCAyICogeCAtIDIsIDIgKSAqKCAoIGMyICsgMSApICogKCB4ICogMiAtIDIgKSArIGMyICkgKyAyICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbkJvdW5jZTogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBib3VuY2VPdXQoIDEgLSB4ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEJvdW5jZTogYm91bmNlT3V0LFxyXG5cdFx0ZWFzZUluT3V0Qm91bmNlOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCAxIC0gYm91bmNlT3V0KCAxIC0gMiAqIHggKSApIC8gMiA6XHJcblx0XHRcdFx0KCAxICsgYm91bmNlT3V0KCAyICogeCAtIDEgKSApIC8gMjtcclxuXHRcdH1cclxuXHR9KTtcclxuXHRyZXR1cm4gJDtcclxufSk7XHJcblxyXG59KGpRdWVyeSkpO1xyXG5cclxuLy9zYWZhcmkgYmFjayBidXR0b24gZml4XHJcbmpRdWVyeSggd2luZG93ICkub24oIFwicGFnZXNob3dcIiwgZnVuY3Rpb24oZXZlbnQpIHtcclxuICAgIGlmIChldmVudC5vcmlnaW5hbEV2ZW50LnBlcnNpc3RlZCkge1xyXG4gICAgICAgIGpRdWVyeShcIi5zZWFyY2hhbmRmaWx0ZXJcIikub2ZmKCk7XHJcbiAgICAgICAgalF1ZXJ5KFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuICAgIH1cclxufSk7XHJcblxyXG4vKiB3cG51bWIgLSBub3Vpc2xpZGVyIG51bWJlciBmb3JtYXR0aW5nICovXHJcbiFmdW5jdGlvbigpe1widXNlIHN0cmljdFwiO2Z1bmN0aW9uIGUoZSl7cmV0dXJuIGUuc3BsaXQoXCJcIikucmV2ZXJzZSgpLmpvaW4oXCJcIil9ZnVuY3Rpb24gbihlLG4pe3JldHVybiBlLnN1YnN0cmluZygwLG4ubGVuZ3RoKT09PW59ZnVuY3Rpb24gcihlLG4pe3JldHVybiBlLnNsaWNlKC0xKm4ubGVuZ3RoKT09PW59ZnVuY3Rpb24gdChlLG4scil7aWYoKGVbbl18fGVbcl0pJiZlW25dPT09ZVtyXSl0aHJvdyBuZXcgRXJyb3Iobil9ZnVuY3Rpb24gaShlKXtyZXR1cm5cIm51bWJlclwiPT10eXBlb2YgZSYmaXNGaW5pdGUoZSl9ZnVuY3Rpb24gbyhlLG4pe3ZhciByPU1hdGgucG93KDEwLG4pO3JldHVybihNYXRoLnJvdW5kKGUqcikvcikudG9GaXhlZChuKX1mdW5jdGlvbiB1KG4scix0LHUsZixhLGMscyxwLGQsbCxoKXt2YXIgZyx2LHcsbT1oLHg9XCJcIixiPVwiXCI7cmV0dXJuIGEmJihoPWEoaCkpLGkoaCk/KG4hPT0hMSYmMD09PXBhcnNlRmxvYXQoaC50b0ZpeGVkKG4pKSYmKGg9MCksMD5oJiYoZz0hMCxoPU1hdGguYWJzKGgpKSxuIT09ITEmJihoPW8oaCxuKSksaD1oLnRvU3RyaW5nKCksLTEhPT1oLmluZGV4T2YoXCIuXCIpPyh2PWguc3BsaXQoXCIuXCIpLHc9dlswXSx0JiYoeD10K3ZbMV0pKTp3PWgsciYmKHc9ZSh3KS5tYXRjaCgvLnsxLDN9L2cpLHc9ZSh3LmpvaW4oZShyKSkpKSxnJiZzJiYoYis9cyksdSYmKGIrPXUpLGcmJnAmJihiKz1wKSxiKz13LGIrPXgsZiYmKGIrPWYpLGQmJihiPWQoYixtKSksYik6ITF9ZnVuY3Rpb24gZihlLHQsbyx1LGYsYSxjLHMscCxkLGwsaCl7dmFyIGcsdj1cIlwiO3JldHVybiBsJiYoaD1sKGgpKSxoJiZcInN0cmluZ1wiPT10eXBlb2YgaD8ocyYmbihoLHMpJiYoaD1oLnJlcGxhY2UocyxcIlwiKSxnPSEwKSx1JiZuKGgsdSkmJihoPWgucmVwbGFjZSh1LFwiXCIpKSxwJiZuKGgscCkmJihoPWgucmVwbGFjZShwLFwiXCIpLGc9ITApLGYmJnIoaCxmKSYmKGg9aC5zbGljZSgwLC0xKmYubGVuZ3RoKSksdCYmKGg9aC5zcGxpdCh0KS5qb2luKFwiXCIpKSxvJiYoaD1oLnJlcGxhY2UobyxcIi5cIikpLGcmJih2Kz1cIi1cIiksdis9aCx2PXYucmVwbGFjZSgvW14wLTlcXC5cXC0uXS9nLFwiXCIpLFwiXCI9PT12PyExOih2PU51bWJlcih2KSxjJiYodj1jKHYpKSxpKHYpP3Y6ITEpKTohMX1mdW5jdGlvbiBhKGUpe3ZhciBuLHIsaSxvPXt9O2ZvcihuPTA7bjxwLmxlbmd0aDtuKz0xKWlmKHI9cFtuXSxpPWVbcl0sdm9pZCAwPT09aSlcIm5lZ2F0aXZlXCIhPT1yfHxvLm5lZ2F0aXZlQmVmb3JlP1wibWFya1wiPT09ciYmXCIuXCIhPT1vLnRob3VzYW5kP29bcl09XCIuXCI6b1tyXT0hMTpvW3JdPVwiLVwiO2Vsc2UgaWYoXCJkZWNpbWFsc1wiPT09cil7aWYoIShpPj0wJiY4PmkpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9ZWxzZSBpZihcImVuY29kZXJcIj09PXJ8fFwiZGVjb2RlclwiPT09cnx8XCJlZGl0XCI9PT1yfHxcInVuZG9cIj09PXIpe2lmKFwiZnVuY3Rpb25cIiE9dHlwZW9mIGkpdGhyb3cgbmV3IEVycm9yKHIpO29bcl09aX1lbHNle2lmKFwic3RyaW5nXCIhPXR5cGVvZiBpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9cmV0dXJuIHQobyxcIm1hcmtcIixcInRob3VzYW5kXCIpLHQobyxcInByZWZpeFwiLFwibmVnYXRpdmVcIiksdChvLFwicHJlZml4XCIsXCJuZWdhdGl2ZUJlZm9yZVwiKSxvfWZ1bmN0aW9uIGMoZSxuLHIpe3ZhciB0LGk9W107Zm9yKHQ9MDt0PHAubGVuZ3RoO3QrPTEpaS5wdXNoKGVbcFt0XV0pO3JldHVybiBpLnB1c2gociksbi5hcHBseShcIlwiLGkpfWZ1bmN0aW9uIHMoZSl7cmV0dXJuIHRoaXMgaW5zdGFuY2VvZiBzP3ZvaWQoXCJvYmplY3RcIj09dHlwZW9mIGUmJihlPWEoZSksdGhpcy50bz1mdW5jdGlvbihuKXtyZXR1cm4gYyhlLHUsbil9LHRoaXMuZnJvbT1mdW5jdGlvbihuKXtyZXR1cm4gYyhlLGYsbil9KSk6bmV3IHMoZSl9dmFyIHA9W1wiZGVjaW1hbHNcIixcInRob3VzYW5kXCIsXCJtYXJrXCIsXCJwcmVmaXhcIixcInBvc3RmaXhcIixcImVuY29kZXJcIixcImRlY29kZXJcIixcIm5lZ2F0aXZlQmVmb3JlXCIsXCJuZWdhdGl2ZVwiLFwiZWRpdFwiLFwidW5kb1wiXTt3aW5kb3cud051bWI9c30oKTtcclxuXHJcblxufSkuY2FsbCh0aGlzLHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWwgOiB0eXBlb2Ygc2VsZiAhPT0gXCJ1bmRlZmluZWRcIiA/IHNlbGYgOiB0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93IDoge30pXG4vLyMgc291cmNlTWFwcGluZ1VSTD1kYXRhOmFwcGxpY2F0aW9uL2pzb247Y2hhcnNldDp1dGYtODtiYXNlNjQsZXlKMlpYSnphVzl1SWpvekxDSnpiM1Z5WTJWeklqcGJJbk55WXk5d2RXSnNhV012WVhOelpYUnpMMnB6TDJGd2NDNXFjeUpkTENKdVlXMWxjeUk2VzEwc0ltMWhjSEJwYm1keklqb2lPMEZCUVVFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVNJc0ltWnBiR1VpT2lKblpXNWxjbUYwWldRdWFuTWlMQ0p6YjNWeVkyVlNiMjkwSWpvaUlpd2ljMjkxY21ObGMwTnZiblJsYm5RaU9sc2lYSEpjYm5aaGNpQnpkR0YwWlNBOUlISmxjWFZwY21Vb0p5NHZhVzVqYkhWa1pYTXZjM1JoZEdVbktUdGNjbHh1ZG1GeUlIQnNkV2RwYmlBOUlISmxjWFZwY21Vb0p5NHZhVzVqYkhWa1pYTXZjR3gxWjJsdUp5azdYSEpjYmx4eVhHNWNjbHh1S0daMWJtTjBhVzl1SUNnZ0pDQXBJSHRjY2x4dVhISmNibHgwWENKMWMyVWdjM1J5YVdOMFhDSTdYSEpjYmx4eVhHNWNkQ1FvWm5WdVkzUnBiMjRnS0NrZ2UxeHlYRzVjY2x4dVhIUmNkR2xtSUNnaFQySnFaV04wTG10bGVYTXBJSHRjY2x4dVhIUmNkQ0FnVDJKcVpXTjBMbXRsZVhNZ1BTQW9ablZ1WTNScGIyNGdLQ2tnZTF4eVhHNWNkRngwWEhRbmRYTmxJSE4wY21samRDYzdYSEpjYmx4MFhIUmNkSFpoY2lCb1lYTlBkMjVRY205d1pYSjBlU0E5SUU5aWFtVmpkQzV3Y205MGIzUjVjR1V1YUdGelQzZHVVSEp2Y0dWeWRIa3NYSEpjYmx4MFhIUmNkRngwYUdGelJHOXVkRVZ1ZFcxQ2RXY2dQU0FoS0h0MGIxTjBjbWx1WnpvZ2JuVnNiSDBwTG5CeWIzQmxjblI1U1hORmJuVnRaWEpoWW14bEtDZDBiMU4wY21sdVp5Y3BMRnh5WEc1Y2RGeDBYSFJjZEdSdmJuUkZiblZ0Y3lBOUlGdGNjbHh1WEhSY2RGeDBYSFFnSUNkMGIxTjBjbWx1Wnljc1hISmNibHgwWEhSY2RGeDBJQ0FuZEc5TWIyTmhiR1ZUZEhKcGJtY25MRnh5WEc1Y2RGeDBYSFJjZENBZ0ozWmhiSFZsVDJZbkxGeHlYRzVjZEZ4MFhIUmNkQ0FnSjJoaGMwOTNibEJ5YjNCbGNuUjVKeXhjY2x4dVhIUmNkRngwWEhRZ0lDZHBjMUJ5YjNSdmRIbHdaVTltSnl4Y2NseHVYSFJjZEZ4MFhIUWdJQ2R3Y205d1pYSjBlVWx6Ulc1MWJXVnlZV0pzWlNjc1hISmNibHgwWEhSY2RGeDBJQ0FuWTI5dWMzUnlkV04wYjNJblhISmNibHgwWEhSY2RGeDBYU3hjY2x4dVhIUmNkRngwWEhSa2IyNTBSVzUxYlhOTVpXNW5kR2dnUFNCa2IyNTBSVzUxYlhNdWJHVnVaM1JvTzF4eVhHNWNjbHh1WEhSY2RGeDBjbVYwZFhKdUlHWjFibU4wYVc5dUlDaHZZbW9wSUh0Y2NseHVYSFJjZEZ4MElDQnBaaUFvZEhsd1pXOW1JRzlpYWlBaFBUMGdKMjlpYW1WamRDY2dKaVlnS0hSNWNHVnZaaUJ2WW1vZ0lUMDlJQ2RtZFc1amRHbHZiaWNnZkh3Z2IySnFJRDA5UFNCdWRXeHNLU2tnZTF4eVhHNWNkRngwWEhSY2RIUm9jbTkzSUc1bGR5QlVlWEJsUlhKeWIzSW9KMDlpYW1WamRDNXJaWGx6SUdOaGJHeGxaQ0J2YmlCdWIyNHRiMkpxWldOMEp5azdYSEpjYmx4MFhIUmNkQ0FnZlZ4eVhHNWNjbHh1WEhSY2RGeDBJQ0IyWVhJZ2NtVnpkV3gwSUQwZ1cxMHNJSEJ5YjNBc0lHazdYSEpjYmx4eVhHNWNkRngwWEhRZ0lHWnZjaUFvY0hKdmNDQnBiaUJ2WW1vcElIdGNjbHh1WEhSY2RGeDBYSFJwWmlBb2FHRnpUM2R1VUhKdmNHVnlkSGt1WTJGc2JDaHZZbW9zSUhCeWIzQXBLU0I3WEhKY2JseDBYSFJjZEZ4MElDQnlaWE4xYkhRdWNIVnphQ2h3Y205d0tUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZENBZ2ZWeHlYRzVjY2x4dVhIUmNkRngwSUNCcFppQW9hR0Z6Ukc5dWRFVnVkVzFDZFdjcElIdGNjbHh1WEhSY2RGeDBYSFJtYjNJZ0tHa2dQU0F3T3lCcElEd2daRzl1ZEVWdWRXMXpUR1Z1WjNSb095QnBLeXNwSUh0Y2NseHVYSFJjZEZ4MFhIUWdJR2xtSUNob1lYTlBkMjVRY205d1pYSjBlUzVqWVd4c0tHOWlhaXdnWkc5dWRFVnVkVzF6VzJsZEtTa2dlMXh5WEc1Y2RGeDBYSFJjZEZ4MGNtVnpkV3gwTG5CMWMyZ29aRzl1ZEVWdWRXMXpXMmxkS1R0Y2NseHVYSFJjZEZ4MFhIUWdJSDFjY2x4dVhIUmNkRngwWEhSOVhISmNibHgwWEhSY2RDQWdmVnh5WEc1Y2RGeDBYSFFnSUhKbGRIVnliaUJ5WlhOMWJIUTdYSEpjYmx4MFhIUmNkSDA3WEhKY2JseDBYSFFnSUgwb0tTazdYSEpjYmx4MFhIUjlYSEpjYmx4eVhHNWNkRngwTHlvZ1UyVmhjbU5vSUNZZ1JtbHNkR1Z5SUdwUmRXVnllU0JRYkhWbmFXNGdLaTljY2x4dVhIUmNkQ1F1Wm00dWMyVmhjbU5vUVc1a1JtbHNkR1Z5SUQwZ2NHeDFaMmx1TzF4eVhHNWNjbHh1WEhSY2RDOHFJR2x1YVhRZ0tpOWNjbHh1WEhSY2RDUW9YQ0l1YzJWaGNtTm9ZVzVrWm1sc2RHVnlYQ0lwTG5ObFlYSmphRUZ1WkVacGJIUmxjaWdwTzF4eVhHNWNjbHh1WEhSY2RDOHFJR1Y0ZEdWeWJtRnNJR052Ym5SeWIyeHpJQ292WEhKY2JseDBYSFFrS0dSdlkzVnRaVzUwS1M1dmJpaGNJbU5zYVdOclhDSXNJRndpTG5ObFlYSmphQzFtYVd4MFpYSXRjbVZ6WlhSY0lpd2dablZ1WTNScGIyNG9aU2w3WEhKY2JseHlYRzVjZEZ4MFhIUmxMbkJ5WlhabGJuUkVaV1poZFd4MEtDazdYSEpjYmx4eVhHNWNkRngwWEhSMllYSWdjMlZoY21Ob1JtOXliVWxFSUQwZ2RIbHdaVzltS0NRb2RHaHBjeWt1WVhSMGNpaGNJbVJoZEdFdGMyVmhjbU5vTFdadmNtMHRhV1JjSWlrcElUMWNJblZ1WkdWbWFXNWxaRndpSUQ4Z0pDaDBhR2x6S1M1aGRIUnlLRndpWkdGMFlTMXpaV0Z5WTJndFptOXliUzFwWkZ3aUtTQTZJRndpWENJN1hISmNibHgwWEhSY2RIWmhjaUJ6ZFdKdGFYUkdiM0p0SUQwZ2RIbHdaVzltS0NRb2RHaHBjeWt1WVhSMGNpaGNJbVJoZEdFdGMyWXRjM1ZpYldsMExXWnZjbTFjSWlrcElUMWNJblZ1WkdWbWFXNWxaRndpSUQ4Z0pDaDBhR2x6S1M1aGRIUnlLRndpWkdGMFlTMXpaaTF6ZFdKdGFYUXRabTl5YlZ3aUtTQTZJRndpWENJN1hISmNibHh5WEc1Y2RGeDBYSFJ6ZEdGMFpTNW5aWFJUWldGeVkyaEdiM0p0S0hObFlYSmphRVp2Y20xSlJDa3VjbVZ6WlhRb2MzVmliV2wwUm05eWJTazdYSEpjYmx4eVhHNWNkRngwWEhRdkwzWmhjaUFrYkdsdWEyVmtJRDBnSkNoY0lpTnpaV0Z5WTJndFptbHNkR1Z5TFdadmNtMHRYQ0lyYzJWaGNtTm9SbTl5YlVsRUtTNXpaV0Z5WTJoR2FXeDBaWEpHYjNKdEtIdGhZM1JwYjI0NklGd2ljbVZ6WlhSY0luMHBPMXh5WEc1Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUdaaGJITmxPMXh5WEc1Y2NseHVYSFJjZEgwcE8xeHlYRzVjY2x4dVhIUjlLVHRjY2x4dVhISmNibHh5WEc0dktseHlYRzRnS2lCcVVYVmxjbmtnUldGemFXNW5JSFl4TGpRdU1TQXRJR2gwZEhBNkx5OW5jMmRrTG1OdkxuVnJMM05oYm1SaWIzZ3ZhbkYxWlhKNUwyVmhjMmx1Wnk5Y2NseHVJQ29nVDNCbGJpQnpiM1Z5WTJVZ2RXNWtaWElnZEdobElFSlRSQ0JNYVdObGJuTmxMbHh5WEc0Z0tpQkRiM0I1Y21sbmFIUWd3cWtnTWpBd09DQkhaVzl5WjJVZ1RXTkhhVzVzWlhrZ1UyMXBkR2hjY2x4dUlDb2dRV3hzSUhKcFoyaDBjeUJ5WlhObGNuWmxaQzVjY2x4dUlDb2dhSFIwY0hNNkx5OXlZWGN1WjJsMGFIVmlMbU52YlM5blpITnRhWFJvTDJweGRXVnllUzVsWVhOcGJtY3ZiV0Z6ZEdWeUwweEpRMFZPVTBWY2NseHVLaTljY2x4dVhISmNiaThxSUdkc2IySmhiSE1nYWxGMVpYSjVMQ0JrWldacGJtVXNJRzF2WkhWc1pTd2djbVZ4ZFdseVpTQXFMMXh5WEc0b1puVnVZM1JwYjI0Z0tHWmhZM1J2Y25rcElIdGNjbHh1WEhScFppQW9kSGx3Wlc5bUlHUmxabWx1WlNBOVBUMGdYQ0ptZFc1amRHbHZibHdpSUNZbUlHUmxabWx1WlM1aGJXUXBJSHRjY2x4dVhIUmNkR1JsWm1sdVpTaGJKMnB4ZFdWeWVTZGRMQ0JtZFc1amRHbHZiaUFvSkNrZ2UxeHlYRzVjZEZ4MFhIUnlaWFIxY200Z1ptRmpkRzl5ZVNna0tUdGNjbHh1WEhSY2RIMHBPMXh5WEc1Y2RIMGdaV3h6WlNCcFppQW9kSGx3Wlc5bUlHMXZaSFZzWlNBOVBUMGdYQ0p2WW1wbFkzUmNJaUFtSmlCMGVYQmxiMllnYlc5a2RXeGxMbVY0Y0c5eWRITWdQVDA5SUZ3aWIySnFaV04wWENJcElIdGNjbHh1WEhSY2RHMXZaSFZzWlM1bGVIQnZjblJ6SUQwZ1ptRmpkRzl5ZVNnb2RIbHdaVzltSUhkcGJtUnZkeUFoUFQwZ1hDSjFibVJsWm1sdVpXUmNJaUEvSUhkcGJtUnZkMXNuYWxGMVpYSjVKMTBnT2lCMGVYQmxiMllnWjJ4dlltRnNJQ0U5UFNCY0luVnVaR1ZtYVc1bFpGd2lJRDhnWjJ4dlltRnNXeWRxVVhWbGNua25YU0E2SUc1MWJHd3BLVHRjY2x4dVhIUjlJR1ZzYzJVZ2UxeHlYRzVjZEZ4MFptRmpkRzl5ZVNocVVYVmxjbmtwTzF4eVhHNWNkSDFjY2x4dWZTa29ablZ1WTNScGIyNG9KQ2w3WEhKY2JseHlYRzVjZEM4dklGQnlaWE5sY25abElIUm9aU0J2Y21sbmFXNWhiQ0JxVVhWbGNua2dYQ0p6ZDJsdVoxd2lJR1ZoYzJsdVp5QmhjeUJjSW1wemQybHVaMXdpWEhKY2JseDBhV1lnS0hSNWNHVnZaaUFrTG1WaGMybHVaeUFoUFQwZ0ozVnVaR1ZtYVc1bFpDY3BJSHRjY2x4dVhIUmNkQ1F1WldGemFXNW5XeWRxYzNkcGJtY25YU0E5SUNRdVpXRnphVzVuV3lkemQybHVaeWRkTzF4eVhHNWNkSDFjY2x4dVhISmNibHgwZG1GeUlIQnZkeUE5SUUxaGRHZ3VjRzkzTEZ4eVhHNWNkRngwYzNGeWRDQTlJRTFoZEdndWMzRnlkQ3hjY2x4dVhIUmNkSE5wYmlBOUlFMWhkR2d1YzJsdUxGeHlYRzVjZEZ4MFkyOXpJRDBnVFdGMGFDNWpiM01zWEhKY2JseDBYSFJRU1NBOUlFMWhkR2d1VUVrc1hISmNibHgwWEhSak1TQTlJREV1TnpBeE5UZ3NYSEpjYmx4MFhIUmpNaUE5SUdNeElDb2dNUzQxTWpVc1hISmNibHgwWEhSak15QTlJR014SUNzZ01TeGNjbHh1WEhSY2RHTTBJRDBnS0NBeUlDb2dVRWtnS1NBdklETXNYSEpjYmx4MFhIUmpOU0E5SUNnZ01pQXFJRkJKSUNrZ0x5QTBMalU3WEhKY2JseHlYRzVjZEM4dklIZ2dhWE1nZEdobElHWnlZV04wYVc5dUlHOW1JR0Z1YVcxaGRHbHZiaUJ3Y205bmNtVnpjeXdnYVc0Z2RHaGxJSEpoYm1kbElEQXVMakZjY2x4dVhIUm1kVzVqZEdsdmJpQmliM1Z1WTJWUGRYUW9lQ2tnZTF4eVhHNWNkRngwZG1GeUlHNHhJRDBnTnk0MU5qSTFMRnh5WEc1Y2RGeDBYSFJrTVNBOUlESXVOelU3WEhKY2JseDBYSFJwWmlBb0lIZ2dQQ0F4TDJReElDa2dlMXh5WEc1Y2RGeDBYSFJ5WlhSMWNtNGdiakVxZUNwNE8xeHlYRzVjZEZ4MGZTQmxiSE5sSUdsbUlDZ2dlQ0E4SURJdlpERWdLU0I3WEhKY2JseDBYSFJjZEhKbGRIVnliaUJ1TVNvb2VDMDlLREV1TlM5a01Ta3BLbmdnS3lBdU56VTdYSEpjYmx4MFhIUjlJR1ZzYzJVZ2FXWWdLQ0I0SUR3Z01pNDFMMlF4SUNrZ2UxeHlYRzVjZEZ4MFhIUnlaWFIxY200Z2JqRXFLSGd0UFNneUxqSTFMMlF4S1NrcWVDQXJJQzQ1TXpjMU8xeHlYRzVjZEZ4MGZTQmxiSE5sSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUc0eEtpaDRMVDBvTWk0Mk1qVXZaREVwS1NwNElDc2dMams0TkRNM05UdGNjbHh1WEhSY2RIMWNjbHh1WEhSOVhISmNibHh5WEc1Y2RDUXVaWGgwWlc1a0tDQWtMbVZoYzJsdVp5d2dlMXh5WEc1Y2RGeDBaR1ZtT2lBblpXRnpaVTkxZEZGMVlXUW5MRnh5WEc1Y2RGeDBjM2RwYm1jNklHWjFibU4wYVc5dUlDaDRLU0I3WEhKY2JseDBYSFJjZEhKbGRIVnliaUFrTG1WaGMybHVaMXNrTG1WaGMybHVaeTVrWldaZEtIZ3BPMXh5WEc1Y2RGeDBmU3hjY2x4dVhIUmNkR1ZoYzJWSmJsRjFZV1E2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJQ29nZUR0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxUM1YwVVhWaFpEb2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SURFZ0xTQW9JREVnTFNCNElDa2dLaUFvSURFZ0xTQjRJQ2s3WEhKY2JseDBYSFI5TEZ4eVhHNWNkRngwWldGelpVbHVUM1YwVVhWaFpEb2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ1BDQXdMalVnUDF4eVhHNWNkRngwWEhSY2RESWdLaUI0SUNvZ2VDQTZYSEpjYmx4MFhIUmNkRngwTVNBdElIQnZkeWdnTFRJZ0tpQjRJQ3NnTWl3Z01pQXBJQzhnTWp0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxTVzVEZFdKcFl6b2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ0tpQjRJQ29nZUR0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxUM1YwUTNWaWFXTTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hISmNibHgwWEhSY2RISmxkSFZ5YmlBeElDMGdjRzkzS0NBeElDMGdlQ3dnTXlBcE8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZKYms5MWRFTjFZbWxqT2lCbWRXNWpkR2x2YmlBb2VDa2dlMXh5WEc1Y2RGeDBYSFJ5WlhSMWNtNGdlQ0E4SURBdU5TQS9YSEpjYmx4MFhIUmNkRngwTkNBcUlIZ2dLaUI0SUNvZ2VDQTZYSEpjYmx4MFhIUmNkRngwTVNBdElIQnZkeWdnTFRJZ0tpQjRJQ3NnTWl3Z015QXBJQzhnTWp0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxTVzVSZFdGeWREb2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ0tpQjRJQ29nZUNBcUlIZzdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlU5MWRGRjFZWEowT2lCbWRXNWpkR2x2YmlBb2VDa2dlMXh5WEc1Y2RGeDBYSFJ5WlhSMWNtNGdNU0F0SUhCdmR5Z2dNU0F0SUhnc0lEUWdLVHRjY2x4dVhIUmNkSDBzWEhKY2JseDBYSFJsWVhObFNXNVBkWFJSZFdGeWREb2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ1BDQXdMalVnUDF4eVhHNWNkRngwWEhSY2REZ2dLaUI0SUNvZ2VDQXFJSGdnS2lCNElEcGNjbHh1WEhSY2RGeDBYSFF4SUMwZ2NHOTNLQ0F0TWlBcUlIZ2dLeUF5TENBMElDa2dMeUF5TzF4eVhHNWNkRngwZlN4Y2NseHVYSFJjZEdWaGMyVkpibEYxYVc1ME9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnZUNBcUlIZ2dLaUI0SUNvZ2VDQXFJSGc3WEhKY2JseDBYSFI5TEZ4eVhHNWNkRngwWldGelpVOTFkRkYxYVc1ME9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnTVNBdElIQnZkeWdnTVNBdElIZ3NJRFVnS1R0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxTVzVQZFhSUmRXbHVkRG9nWm5WdVkzUnBiMjRnS0hncElIdGNjbHh1WEhSY2RGeDBjbVYwZFhKdUlIZ2dQQ0F3TGpVZ1AxeHlYRzVjZEZ4MFhIUmNkREUySUNvZ2VDQXFJSGdnS2lCNElDb2dlQ0FxSUhnZ09seHlYRzVjZEZ4MFhIUmNkREVnTFNCd2IzY29JQzB5SUNvZ2VDQXJJRElzSURVZ0tTQXZJREk3WEhKY2JseDBYSFI5TEZ4eVhHNWNkRngwWldGelpVbHVVMmx1WlRvZ1puVnVZM1JwYjI0Z0tIZ3BJSHRjY2x4dVhIUmNkRngwY21WMGRYSnVJREVnTFNCamIzTW9JSGdnS2lCUVNTOHlJQ2s3WEhKY2JseDBYSFI5TEZ4eVhHNWNkRngwWldGelpVOTFkRk5wYm1VNklHWjFibU4wYVc5dUlDaDRLU0I3WEhKY2JseDBYSFJjZEhKbGRIVnliaUJ6YVc0b0lIZ2dLaUJRU1M4eUlDazdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlVsdVQzVjBVMmx1WlRvZ1puVnVZM1JwYjI0Z0tIZ3BJSHRjY2x4dVhIUmNkRngwY21WMGRYSnVJQzBvSUdOdmN5Z2dVRWtnS2lCNElDa2dMU0F4SUNrZ0x5QXlPMXh5WEc1Y2RGeDBmU3hjY2x4dVhIUmNkR1ZoYzJWSmJrVjRjRzg2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJRDA5UFNBd0lEOGdNQ0E2SUhCdmR5Z2dNaXdnTVRBZ0tpQjRJQzBnTVRBZ0tUdGNjbHh1WEhSY2RIMHNYSEpjYmx4MFhIUmxZWE5sVDNWMFJYaHdiem9nWm5WdVkzUnBiMjRnS0hncElIdGNjbHh1WEhSY2RGeDBjbVYwZFhKdUlIZ2dQVDA5SURFZ1B5QXhJRG9nTVNBdElIQnZkeWdnTWl3Z0xURXdJQ29nZUNBcE8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZKYms5MWRFVjRjRzg2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJRDA5UFNBd0lEOGdNQ0E2SUhnZ1BUMDlJREVnUHlBeElEb2dlQ0E4SURBdU5TQS9YSEpjYmx4MFhIUmNkRngwY0c5M0tDQXlMQ0F5TUNBcUlIZ2dMU0F4TUNBcElDOGdNaUE2WEhKY2JseDBYSFJjZEZ4MEtDQXlJQzBnY0c5M0tDQXlMQ0F0TWpBZ0tpQjRJQ3NnTVRBZ0tTQXBJQzhnTWp0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxTVzVEYVhKak9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnTVNBdElITnhjblFvSURFZ0xTQndiM2NvSUhnc0lESWdLU0FwTzF4eVhHNWNkRngwZlN4Y2NseHVYSFJjZEdWaGMyVlBkWFJEYVhKak9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnYzNGeWRDZ2dNU0F0SUhCdmR5Z2dlQ0F0SURFc0lESWdLU0FwTzF4eVhHNWNkRngwZlN4Y2NseHVYSFJjZEdWaGMyVkpiazkxZEVOcGNtTTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hISmNibHgwWEhSY2RISmxkSFZ5YmlCNElEd2dNQzQxSUQ5Y2NseHVYSFJjZEZ4MFhIUW9JREVnTFNCemNYSjBLQ0F4SUMwZ2NHOTNLQ0F5SUNvZ2VDd2dNaUFwSUNrZ0tTQXZJRElnT2x4eVhHNWNkRngwWEhSY2RDZ2djM0Z5ZENnZ01TQXRJSEJ2ZHlnZ0xUSWdLaUI0SUNzZ01pd2dNaUFwSUNrZ0t5QXhJQ2tnTHlBeU8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZKYmtWc1lYTjBhV002SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJRDA5UFNBd0lEOGdNQ0E2SUhnZ1BUMDlJREVnUHlBeElEcGNjbHh1WEhSY2RGeDBYSFF0Y0c5M0tDQXlMQ0F4TUNBcUlIZ2dMU0F4TUNBcElDb2djMmx1S0NBb0lIZ2dLaUF4TUNBdElERXdMamMxSUNrZ0tpQmpOQ0FwTzF4eVhHNWNkRngwZlN4Y2NseHVYSFJjZEdWaGMyVlBkWFJGYkdGemRHbGpPaUJtZFc1amRHbHZiaUFvZUNrZ2UxeHlYRzVjZEZ4MFhIUnlaWFIxY200Z2VDQTlQVDBnTUNBL0lEQWdPaUI0SUQwOVBTQXhJRDhnTVNBNlhISmNibHgwWEhSY2RGeDBjRzkzS0NBeUxDQXRNVEFnS2lCNElDa2dLaUJ6YVc0b0lDZ2dlQ0FxSURFd0lDMGdNQzQzTlNBcElDb2dZelFnS1NBcklERTdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlVsdVQzVjBSV3hoYzNScFl6b2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ1BUMDlJREFnUHlBd0lEb2dlQ0E5UFQwZ01TQS9JREVnT2lCNElEd2dNQzQxSUQ5Y2NseHVYSFJjZEZ4MFhIUXRLQ0J3YjNjb0lESXNJREl3SUNvZ2VDQXRJREV3SUNrZ0tpQnphVzRvSUNnZ01qQWdLaUI0SUMwZ01URXVNVEkxSUNrZ0tpQmpOU0FwS1NBdklESWdPbHh5WEc1Y2RGeDBYSFJjZEhCdmR5Z2dNaXdnTFRJd0lDb2dlQ0FySURFd0lDa2dLaUJ6YVc0b0lDZ2dNakFnS2lCNElDMGdNVEV1TVRJMUlDa2dLaUJqTlNBcElDOGdNaUFySURFN1hISmNibHgwWEhSOUxGeHlYRzVjZEZ4MFpXRnpaVWx1UW1GamF6b2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUdNeklDb2dlQ0FxSUhnZ0tpQjRJQzBnWXpFZ0tpQjRJQ29nZUR0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxUM1YwUW1GamF6b2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SURFZ0t5QmpNeUFxSUhCdmR5Z2dlQ0F0SURFc0lETWdLU0FySUdNeElDb2djRzkzS0NCNElDMGdNU3dnTWlBcE8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZKYms5MWRFSmhZMnM2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJRHdnTUM0MUlEOWNjbHh1WEhSY2RGeDBYSFFvSUhCdmR5Z2dNaUFxSUhnc0lESWdLU0FxSUNnZ0tDQmpNaUFySURFZ0tTQXFJRElnS2lCNElDMGdZeklnS1NBcElDOGdNaUE2WEhKY2JseDBYSFJjZEZ4MEtDQndiM2NvSURJZ0tpQjRJQzBnTWl3Z01pQXBJQ29vSUNnZ1l6SWdLeUF4SUNrZ0tpQW9JSGdnS2lBeUlDMGdNaUFwSUNzZ1l6SWdLU0FySURJZ0tTQXZJREk3WEhKY2JseDBYSFI5TEZ4eVhHNWNkRngwWldGelpVbHVRbTkxYm1ObE9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnTVNBdElHSnZkVzVqWlU5MWRDZ2dNU0F0SUhnZ0tUdGNjbHh1WEhSY2RIMHNYSEpjYmx4MFhIUmxZWE5sVDNWMFFtOTFibU5sT2lCaWIzVnVZMlZQZFhRc1hISmNibHgwWEhSbFlYTmxTVzVQZFhSQ2IzVnVZMlU2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJRHdnTUM0MUlEOWNjbHh1WEhSY2RGeDBYSFFvSURFZ0xTQmliM1Z1WTJWUGRYUW9JREVnTFNBeUlDb2dlQ0FwSUNrZ0x5QXlJRHBjY2x4dVhIUmNkRngwWEhRb0lERWdLeUJpYjNWdVkyVlBkWFFvSURJZ0tpQjRJQzBnTVNBcElDa2dMeUF5TzF4eVhHNWNkRngwZlZ4eVhHNWNkSDBwTzF4eVhHNWNkSEpsZEhWeWJpQWtPMXh5WEc1OUtUdGNjbHh1WEhKY2JuMG9hbEYxWlhKNUtTazdYSEpjYmx4eVhHNHZMM05oWm1GeWFTQmlZV05ySUdKMWRIUnZiaUJtYVhoY2NseHVhbEYxWlhKNUtDQjNhVzVrYjNjZ0tTNXZiaWdnWENKd1lXZGxjMmh2ZDF3aUxDQm1kVzVqZEdsdmJpaGxkbVZ1ZENrZ2UxeHlYRzRnSUNBZ2FXWWdLR1YyWlc1MExtOXlhV2RwYm1Gc1JYWmxiblF1Y0dWeWMybHpkR1ZrS1NCN1hISmNiaUFnSUNBZ0lDQWdhbEYxWlhKNUtGd2lMbk5sWVhKamFHRnVaR1pwYkhSbGNsd2lLUzV2Wm1Zb0tUdGNjbHh1SUNBZ0lDQWdJQ0JxVVhWbGNua29YQ0l1YzJWaGNtTm9ZVzVrWm1sc2RHVnlYQ0lwTG5ObFlYSmphRUZ1WkVacGJIUmxjaWdwTzF4eVhHNGdJQ0FnZlZ4eVhHNTlLVHRjY2x4dVhISmNiaThxSUhkd2JuVnRZaUF0SUc1dmRXbHpiR2xrWlhJZ2JuVnRZbVZ5SUdadmNtMWhkSFJwYm1jZ0tpOWNjbHh1SVdaMWJtTjBhVzl1S0NsN1hDSjFjMlVnYzNSeWFXTjBYQ0k3Wm5WdVkzUnBiMjRnWlNobEtYdHlaWFIxY200Z1pTNXpjR3hwZENoY0lsd2lLUzV5WlhabGNuTmxLQ2t1YW05cGJpaGNJbHdpS1gxbWRXNWpkR2x2YmlCdUtHVXNiaWw3Y21WMGRYSnVJR1V1YzNWaWMzUnlhVzVuS0RBc2JpNXNaVzVuZEdncFBUMDlibjFtZFc1amRHbHZiaUJ5S0dVc2JpbDdjbVYwZFhKdUlHVXVjMnhwWTJVb0xURXFiaTVzWlc1bmRHZ3BQVDA5Ym4xbWRXNWpkR2x2YmlCMEtHVXNiaXh5S1h0cFppZ29aVnR1WFh4OFpWdHlYU2ttSm1WYmJsMDlQVDFsVzNKZEtYUm9jbTkzSUc1bGR5QkZjbkp2Y2lodUtYMW1kVzVqZEdsdmJpQnBLR1VwZTNKbGRIVnlibHdpYm5WdFltVnlYQ0k5UFhSNWNHVnZaaUJsSmlacGMwWnBibWwwWlNobEtYMW1kVzVqZEdsdmJpQnZLR1VzYmlsN2RtRnlJSEk5VFdGMGFDNXdiM2NvTVRBc2JpazdjbVYwZFhKdUtFMWhkR2d1Y205MWJtUW9aU3B5S1M5eUtTNTBiMFpwZUdWa0tHNHBmV1oxYm1OMGFXOXVJSFVvYml4eUxIUXNkU3htTEdFc1l5eHpMSEFzWkN4c0xHZ3BlM1poY2lCbkxIWXNkeXh0UFdnc2VEMWNJbHdpTEdJOVhDSmNJanR5WlhSMWNtNGdZU1ltS0dnOVlTaG9LU2tzYVNob0tUOG9iaUU5UFNFeEppWXdQVDA5Y0dGeWMyVkdiRzloZENob0xuUnZSbWw0WldRb2Jpa3BKaVlvYUQwd0tTd3dQbWdtSmloblBTRXdMR2c5VFdGMGFDNWhZbk1vYUNrcExHNGhQVDBoTVNZbUtHZzlieWhvTEc0cEtTeG9QV2d1ZEc5VGRISnBibWNvS1N3dE1TRTlQV2d1YVc1a1pYaFBaaWhjSWk1Y0lpay9LSFk5YUM1emNHeHBkQ2hjSWk1Y0lpa3NkejEyV3pCZExIUW1KaWg0UFhRcmRsc3hYU2twT25jOWFDeHlKaVlvZHoxbEtIY3BMbTFoZEdOb0tDOHVlekVzTTMwdlp5a3NkejFsS0hjdWFtOXBiaWhsS0hJcEtTa3BMR2NtSm5NbUppaGlLejF6S1N4MUppWW9ZaXM5ZFNrc1p5WW1jQ1ltS0dJclBYQXBMR0lyUFhjc1lpczllQ3htSmlZb1lpczlaaWtzWkNZbUtHSTlaQ2hpTEcwcEtTeGlLVG9oTVgxbWRXNWpkR2x2YmlCbUtHVXNkQ3h2TEhVc1ppeGhMR01zY3l4d0xHUXNiQ3hvS1h0MllYSWdaeXgyUFZ3aVhDSTdjbVYwZFhKdUlHd21KaWhvUFd3b2FDa3BMR2dtSmx3aWMzUnlhVzVuWENJOVBYUjVjR1Z2WmlCb1B5aHpKaVp1S0dnc2N5a21KaWhvUFdndWNtVndiR0ZqWlNoekxGd2lYQ0lwTEdjOUlUQXBMSFVtSm00b2FDeDFLU1ltS0dnOWFDNXlaWEJzWVdObEtIVXNYQ0pjSWlrcExIQW1KbTRvYUN4d0tTWW1LR2c5YUM1eVpYQnNZV05sS0hBc1hDSmNJaWtzWnowaE1Da3NaaVltY2lob0xHWXBKaVlvYUQxb0xuTnNhV05sS0RBc0xURXFaaTVzWlc1bmRHZ3BLU3gwSmlZb2FEMW9Mbk53YkdsMEtIUXBMbXB2YVc0b1hDSmNJaWtwTEc4bUppaG9QV2d1Y21Wd2JHRmpaU2h2TEZ3aUxsd2lLU2tzWnlZbUtIWXJQVndpTFZ3aUtTeDJLejFvTEhZOWRpNXlaWEJzWVdObEtDOWJYakF0T1Z4Y0xseGNMUzVkTDJjc1hDSmNJaWtzWENKY0lqMDlQWFkvSVRFNktIWTlUblZ0WW1WeUtIWXBMR01tSmloMlBXTW9kaWtwTEdrb2Rpay9kam9oTVNrcE9pRXhmV1oxYm1OMGFXOXVJR0VvWlNsN2RtRnlJRzRzY2l4cExHODllMzA3Wm05eUtHNDlNRHR1UEhBdWJHVnVaM1JvTzI0clBURXBhV1lvY2oxd1cyNWRMR2s5WlZ0eVhTeDJiMmxrSURBOVBUMXBLVndpYm1WbllYUnBkbVZjSWlFOVBYSjhmRzh1Ym1WbllYUnBkbVZDWldadmNtVS9YQ0p0WVhKclhDSTlQVDF5SmlaY0lpNWNJaUU5UFc4dWRHaHZkWE5oYm1RL2IxdHlYVDFjSWk1Y0lqcHZXM0pkUFNFeE9tOWJjbDA5WENJdFhDSTdaV3h6WlNCcFppaGNJbVJsWTJsdFlXeHpYQ0k5UFQxeUtYdHBaaWdoS0drK1BUQW1KamcrYVNrcGRHaHliM2NnYm1WM0lFVnljbTl5S0hJcE8yOWJjbDA5YVgxbGJITmxJR2xtS0Z3aVpXNWpiMlJsY2x3aVBUMDljbng4WENKa1pXTnZaR1Z5WENJOVBUMXlmSHhjSW1Wa2FYUmNJajA5UFhKOGZGd2lkVzVrYjF3aVBUMDljaWw3YVdZb1hDSm1kVzVqZEdsdmJsd2lJVDEwZVhCbGIyWWdhU2wwYUhKdmR5QnVaWGNnUlhKeWIzSW9jaWs3YjF0eVhUMXBmV1ZzYzJWN2FXWW9YQ0p6ZEhKcGJtZGNJaUU5ZEhsd1pXOW1JR2twZEdoeWIzY2dibVYzSUVWeWNtOXlLSElwTzI5YmNsMDlhWDF5WlhSMWNtNGdkQ2h2TEZ3aWJXRnlhMXdpTEZ3aWRHaHZkWE5oYm1SY0lpa3NkQ2h2TEZ3aWNISmxabWw0WENJc1hDSnVaV2RoZEdsMlpWd2lLU3gwS0c4c1hDSndjbVZtYVhoY0lpeGNJbTVsWjJGMGFYWmxRbVZtYjNKbFhDSXBMRzk5Wm5WdVkzUnBiMjRnWXlobExHNHNjaWw3ZG1GeUlIUXNhVDFiWFR0bWIzSW9kRDB3TzNROGNDNXNaVzVuZEdnN2RDczlNU2xwTG5CMWMyZ29aVnR3VzNSZFhTazdjbVYwZFhKdUlHa3VjSFZ6YUNoeUtTeHVMbUZ3Y0d4NUtGd2lYQ0lzYVNsOVpuVnVZM1JwYjI0Z2N5aGxLWHR5WlhSMWNtNGdkR2hwY3lCcGJuTjBZVzVqWlc5bUlITS9kbTlwWkNoY0ltOWlhbVZqZEZ3aVBUMTBlWEJsYjJZZ1pTWW1LR1U5WVNobEtTeDBhR2x6TG5SdlBXWjFibU4wYVc5dUtHNHBlM0psZEhWeWJpQmpLR1VzZFN4dUtYMHNkR2hwY3k1bWNtOXRQV1oxYm1OMGFXOXVLRzRwZTNKbGRIVnliaUJqS0dVc1ppeHVLWDBwS1RwdVpYY2djeWhsS1gxMllYSWdjRDFiWENKa1pXTnBiV0ZzYzF3aUxGd2lkR2h2ZFhOaGJtUmNJaXhjSW0xaGNtdGNJaXhjSW5CeVpXWnBlRndpTEZ3aWNHOXpkR1pwZUZ3aUxGd2laVzVqYjJSbGNsd2lMRndpWkdWamIyUmxjbHdpTEZ3aWJtVm5ZWFJwZG1WQ1pXWnZjbVZjSWl4Y0ltNWxaMkYwYVhabFhDSXNYQ0psWkdsMFhDSXNYQ0oxYm1SdlhDSmRPM2RwYm1SdmR5NTNUblZ0WWoxemZTZ3BPMXh5WEc1Y2NseHVJbDE5IiwiLyohIG5vdWlzbGlkZXIgLSAxMS4xLjAgLSAyMDE4LTA0LTAyIDExOjE4OjEzICovXHJcblxyXG4oZnVuY3Rpb24gKGZhY3RvcnkpIHtcclxuXHJcbiAgICBpZiAoIHR5cGVvZiBkZWZpbmUgPT09ICdmdW5jdGlvbicgJiYgZGVmaW5lLmFtZCApIHtcclxuXHJcbiAgICAgICAgLy8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxyXG4gICAgICAgIGRlZmluZShbXSwgZmFjdG9yeSk7XHJcblxyXG4gICAgfSBlbHNlIGlmICggdHlwZW9mIGV4cG9ydHMgPT09ICdvYmplY3QnICkge1xyXG5cclxuICAgICAgICAvLyBOb2RlL0NvbW1vbkpTXHJcbiAgICAgICAgbW9kdWxlLmV4cG9ydHMgPSBmYWN0b3J5KCk7XHJcblxyXG4gICAgfSBlbHNlIHtcclxuXHJcbiAgICAgICAgLy8gQnJvd3NlciBnbG9iYWxzXHJcbiAgICAgICAgd2luZG93Lm5vVWlTbGlkZXIgPSBmYWN0b3J5KCk7XHJcbiAgICB9XHJcblxyXG59KGZ1bmN0aW9uKCApe1xyXG5cclxuXHQndXNlIHN0cmljdCc7XHJcblxyXG5cdHZhciBWRVJTSU9OID0gJzExLjEuMCc7XHJcblxyXG5cblx0ZnVuY3Rpb24gaXNWYWxpZEZvcm1hdHRlciAoIGVudHJ5ICkge1xuXHRcdHJldHVybiB0eXBlb2YgZW50cnkgPT09ICdvYmplY3QnICYmIHR5cGVvZiBlbnRyeS50byA9PT0gJ2Z1bmN0aW9uJyAmJiB0eXBlb2YgZW50cnkuZnJvbSA9PT0gJ2Z1bmN0aW9uJztcblx0fVxuXG5cdGZ1bmN0aW9uIHJlbW92ZUVsZW1lbnQgKCBlbCApIHtcblx0XHRlbC5wYXJlbnRFbGVtZW50LnJlbW92ZUNoaWxkKGVsKTtcblx0fVxuXG5cdGZ1bmN0aW9uIGlzU2V0ICggdmFsdWUgKSB7XG5cdFx0cmV0dXJuIHZhbHVlICE9PSBudWxsICYmIHZhbHVlICE9PSB1bmRlZmluZWQ7XG5cdH1cblxuXHQvLyBCaW5kYWJsZSB2ZXJzaW9uXG5cdGZ1bmN0aW9uIHByZXZlbnREZWZhdWx0ICggZSApIHtcblx0XHRlLnByZXZlbnREZWZhdWx0KCk7XG5cdH1cblxuXHQvLyBSZW1vdmVzIGR1cGxpY2F0ZXMgZnJvbSBhbiBhcnJheS5cblx0ZnVuY3Rpb24gdW5pcXVlICggYXJyYXkgKSB7XG5cdFx0cmV0dXJuIGFycmF5LmZpbHRlcihmdW5jdGlvbihhKXtcblx0XHRcdHJldHVybiAhdGhpc1thXSA/IHRoaXNbYV0gPSB0cnVlIDogZmFsc2U7XG5cdFx0fSwge30pO1xuXHR9XG5cblx0Ly8gUm91bmQgYSB2YWx1ZSB0byB0aGUgY2xvc2VzdCAndG8nLlxuXHRmdW5jdGlvbiBjbG9zZXN0ICggdmFsdWUsIHRvICkge1xuXHRcdHJldHVybiBNYXRoLnJvdW5kKHZhbHVlIC8gdG8pICogdG87XG5cdH1cblxuXHQvLyBDdXJyZW50IHBvc2l0aW9uIG9mIGFuIGVsZW1lbnQgcmVsYXRpdmUgdG8gdGhlIGRvY3VtZW50LlxuXHRmdW5jdGlvbiBvZmZzZXQgKCBlbGVtLCBvcmllbnRhdGlvbiApIHtcblxuXHRcdHZhciByZWN0ID0gZWxlbS5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTtcblx0XHR2YXIgZG9jID0gZWxlbS5vd25lckRvY3VtZW50O1xuXHRcdHZhciBkb2NFbGVtID0gZG9jLmRvY3VtZW50RWxlbWVudDtcblx0XHR2YXIgcGFnZU9mZnNldCA9IGdldFBhZ2VPZmZzZXQoZG9jKTtcblxuXHRcdC8vIGdldEJvdW5kaW5nQ2xpZW50UmVjdCBjb250YWlucyBsZWZ0IHNjcm9sbCBpbiBDaHJvbWUgb24gQW5kcm9pZC5cblx0XHQvLyBJIGhhdmVuJ3QgZm91bmQgYSBmZWF0dXJlIGRldGVjdGlvbiB0aGF0IHByb3ZlcyB0aGlzLiBXb3JzdCBjYXNlXG5cdFx0Ly8gc2NlbmFyaW8gb24gbWlzLW1hdGNoOiB0aGUgJ3RhcCcgZmVhdHVyZSBvbiBob3Jpem9udGFsIHNsaWRlcnMgYnJlYWtzLlxuXHRcdGlmICggL3dlYmtpdC4qQ2hyb21lLipNb2JpbGUvaS50ZXN0KG5hdmlnYXRvci51c2VyQWdlbnQpICkge1xuXHRcdFx0cGFnZU9mZnNldC54ID0gMDtcblx0XHR9XG5cblx0XHRyZXR1cm4gb3JpZW50YXRpb24gPyAocmVjdC50b3AgKyBwYWdlT2Zmc2V0LnkgLSBkb2NFbGVtLmNsaWVudFRvcCkgOiAocmVjdC5sZWZ0ICsgcGFnZU9mZnNldC54IC0gZG9jRWxlbS5jbGllbnRMZWZ0KTtcblx0fVxuXG5cdC8vIENoZWNrcyB3aGV0aGVyIGEgdmFsdWUgaXMgbnVtZXJpY2FsLlxuXHRmdW5jdGlvbiBpc051bWVyaWMgKCBhICkge1xuXHRcdHJldHVybiB0eXBlb2YgYSA9PT0gJ251bWJlcicgJiYgIWlzTmFOKCBhICkgJiYgaXNGaW5pdGUoIGEgKTtcblx0fVxuXG5cdC8vIFNldHMgYSBjbGFzcyBhbmQgcmVtb3ZlcyBpdCBhZnRlciBbZHVyYXRpb25dIG1zLlxuXHRmdW5jdGlvbiBhZGRDbGFzc0ZvciAoIGVsZW1lbnQsIGNsYXNzTmFtZSwgZHVyYXRpb24gKSB7XG5cdFx0aWYgKGR1cmF0aW9uID4gMCkge1xuXHRcdGFkZENsYXNzKGVsZW1lbnQsIGNsYXNzTmFtZSk7XG5cdFx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG5cdFx0XHRcdHJlbW92ZUNsYXNzKGVsZW1lbnQsIGNsYXNzTmFtZSk7XG5cdFx0XHR9LCBkdXJhdGlvbik7XG5cdFx0fVxuXHR9XG5cblx0Ly8gTGltaXRzIGEgdmFsdWUgdG8gMCAtIDEwMFxuXHRmdW5jdGlvbiBsaW1pdCAoIGEgKSB7XG5cdFx0cmV0dXJuIE1hdGgubWF4KE1hdGgubWluKGEsIDEwMCksIDApO1xuXHR9XG5cblx0Ly8gV3JhcHMgYSB2YXJpYWJsZSBhcyBhbiBhcnJheSwgaWYgaXQgaXNuJ3Qgb25lIHlldC5cblx0Ly8gTm90ZSB0aGF0IGFuIGlucHV0IGFycmF5IGlzIHJldHVybmVkIGJ5IHJlZmVyZW5jZSFcblx0ZnVuY3Rpb24gYXNBcnJheSAoIGEgKSB7XG5cdFx0cmV0dXJuIEFycmF5LmlzQXJyYXkoYSkgPyBhIDogW2FdO1xuXHR9XG5cblx0Ly8gQ291bnRzIGRlY2ltYWxzXG5cdGZ1bmN0aW9uIGNvdW50RGVjaW1hbHMgKCBudW1TdHIgKSB7XG5cdFx0bnVtU3RyID0gU3RyaW5nKG51bVN0cik7XG5cdFx0dmFyIHBpZWNlcyA9IG51bVN0ci5zcGxpdChcIi5cIik7XG5cdFx0cmV0dXJuIHBpZWNlcy5sZW5ndGggPiAxID8gcGllY2VzWzFdLmxlbmd0aCA6IDA7XG5cdH1cblxuXHQvLyBodHRwOi8veW91bWlnaHRub3RuZWVkanF1ZXJ5LmNvbS8jYWRkX2NsYXNzXG5cdGZ1bmN0aW9uIGFkZENsYXNzICggZWwsIGNsYXNzTmFtZSApIHtcblx0XHRpZiAoIGVsLmNsYXNzTGlzdCApIHtcblx0XHRcdGVsLmNsYXNzTGlzdC5hZGQoY2xhc3NOYW1lKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZWwuY2xhc3NOYW1lICs9ICcgJyArIGNsYXNzTmFtZTtcblx0XHR9XG5cdH1cblxuXHQvLyBodHRwOi8veW91bWlnaHRub3RuZWVkanF1ZXJ5LmNvbS8jcmVtb3ZlX2NsYXNzXG5cdGZ1bmN0aW9uIHJlbW92ZUNsYXNzICggZWwsIGNsYXNzTmFtZSApIHtcblx0XHRpZiAoIGVsLmNsYXNzTGlzdCApIHtcblx0XHRcdGVsLmNsYXNzTGlzdC5yZW1vdmUoY2xhc3NOYW1lKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZWwuY2xhc3NOYW1lID0gZWwuY2xhc3NOYW1lLnJlcGxhY2UobmV3IFJlZ0V4cCgnKF58XFxcXGIpJyArIGNsYXNzTmFtZS5zcGxpdCgnICcpLmpvaW4oJ3wnKSArICcoXFxcXGJ8JCknLCAnZ2knKSwgJyAnKTtcblx0XHR9XG5cdH1cblxuXHQvLyBodHRwczovL3BsYWluanMuY29tL2phdmFzY3JpcHQvYXR0cmlidXRlcy9hZGRpbmctcmVtb3ZpbmctYW5kLXRlc3RpbmctZm9yLWNsYXNzZXMtOS9cblx0ZnVuY3Rpb24gaGFzQ2xhc3MgKCBlbCwgY2xhc3NOYW1lICkge1xuXHRcdHJldHVybiBlbC5jbGFzc0xpc3QgPyBlbC5jbGFzc0xpc3QuY29udGFpbnMoY2xhc3NOYW1lKSA6IG5ldyBSZWdFeHAoJ1xcXFxiJyArIGNsYXNzTmFtZSArICdcXFxcYicpLnRlc3QoZWwuY2xhc3NOYW1lKTtcblx0fVxuXG5cdC8vIGh0dHBzOi8vZGV2ZWxvcGVyLm1vemlsbGEub3JnL2VuLVVTL2RvY3MvV2ViL0FQSS9XaW5kb3cvc2Nyb2xsWSNOb3Rlc1xuXHRmdW5jdGlvbiBnZXRQYWdlT2Zmc2V0ICggZG9jICkge1xuXG5cdFx0dmFyIHN1cHBvcnRQYWdlT2Zmc2V0ID0gd2luZG93LnBhZ2VYT2Zmc2V0ICE9PSB1bmRlZmluZWQ7XG5cdFx0dmFyIGlzQ1NTMUNvbXBhdCA9ICgoZG9jLmNvbXBhdE1vZGUgfHwgXCJcIikgPT09IFwiQ1NTMUNvbXBhdFwiKTtcblx0XHR2YXIgeCA9IHN1cHBvcnRQYWdlT2Zmc2V0ID8gd2luZG93LnBhZ2VYT2Zmc2V0IDogaXNDU1MxQ29tcGF0ID8gZG9jLmRvY3VtZW50RWxlbWVudC5zY3JvbGxMZWZ0IDogZG9jLmJvZHkuc2Nyb2xsTGVmdDtcblx0XHR2YXIgeSA9IHN1cHBvcnRQYWdlT2Zmc2V0ID8gd2luZG93LnBhZ2VZT2Zmc2V0IDogaXNDU1MxQ29tcGF0ID8gZG9jLmRvY3VtZW50RWxlbWVudC5zY3JvbGxUb3AgOiBkb2MuYm9keS5zY3JvbGxUb3A7XG5cblx0XHRyZXR1cm4ge1xuXHRcdFx0eDogeCxcblx0XHRcdHk6IHlcblx0XHR9O1xuXHR9XG5cclxuXHQvLyB3ZSBwcm92aWRlIGEgZnVuY3Rpb24gdG8gY29tcHV0ZSBjb25zdGFudHMgaW5zdGVhZFxyXG5cdC8vIG9mIGFjY2Vzc2luZyB3aW5kb3cuKiBhcyBzb29uIGFzIHRoZSBtb2R1bGUgbmVlZHMgaXRcclxuXHQvLyBzbyB0aGF0IHdlIGRvIG5vdCBjb21wdXRlIGFueXRoaW5nIGlmIG5vdCBuZWVkZWRcclxuXHRmdW5jdGlvbiBnZXRBY3Rpb25zICggKSB7XHJcblxyXG5cdFx0Ly8gRGV0ZXJtaW5lIHRoZSBldmVudHMgdG8gYmluZC4gSUUxMSBpbXBsZW1lbnRzIHBvaW50ZXJFdmVudHMgd2l0aG91dFxyXG5cdFx0Ly8gYSBwcmVmaXgsIHdoaWNoIGJyZWFrcyBjb21wYXRpYmlsaXR5IHdpdGggdGhlIElFMTAgaW1wbGVtZW50YXRpb24uXHJcblx0XHRyZXR1cm4gd2luZG93Lm5hdmlnYXRvci5wb2ludGVyRW5hYmxlZCA/IHtcclxuXHRcdFx0c3RhcnQ6ICdwb2ludGVyZG93bicsXHJcblx0XHRcdG1vdmU6ICdwb2ludGVybW92ZScsXHJcblx0XHRcdGVuZDogJ3BvaW50ZXJ1cCdcclxuXHRcdH0gOiB3aW5kb3cubmF2aWdhdG9yLm1zUG9pbnRlckVuYWJsZWQgPyB7XHJcblx0XHRcdHN0YXJ0OiAnTVNQb2ludGVyRG93bicsXHJcblx0XHRcdG1vdmU6ICdNU1BvaW50ZXJNb3ZlJyxcclxuXHRcdFx0ZW5kOiAnTVNQb2ludGVyVXAnXHJcblx0XHR9IDoge1xyXG5cdFx0XHRzdGFydDogJ21vdXNlZG93biB0b3VjaHN0YXJ0JyxcclxuXHRcdFx0bW92ZTogJ21vdXNlbW92ZSB0b3VjaG1vdmUnLFxyXG5cdFx0XHRlbmQ6ICdtb3VzZXVwIHRvdWNoZW5kJ1xyXG5cdFx0fTtcclxuXHR9XHJcblxyXG5cdC8vIGh0dHBzOi8vZ2l0aHViLmNvbS9XSUNHL0V2ZW50TGlzdGVuZXJPcHRpb25zL2Jsb2IvZ2gtcGFnZXMvZXhwbGFpbmVyLm1kXHJcblx0Ly8gSXNzdWUgIzc4NVxyXG5cdGZ1bmN0aW9uIGdldFN1cHBvcnRzUGFzc2l2ZSAoICkge1xyXG5cclxuXHRcdHZhciBzdXBwb3J0c1Bhc3NpdmUgPSBmYWxzZTtcclxuXHJcblx0XHR0cnkge1xyXG5cclxuXHRcdFx0dmFyIG9wdHMgPSBPYmplY3QuZGVmaW5lUHJvcGVydHkoe30sICdwYXNzaXZlJywge1xyXG5cdFx0XHRcdGdldDogZnVuY3Rpb24oKSB7XHJcblx0XHRcdFx0XHRzdXBwb3J0c1Bhc3NpdmUgPSB0cnVlO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fSk7XHJcblxyXG5cdFx0XHR3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcigndGVzdCcsIG51bGwsIG9wdHMpO1xyXG5cclxuXHRcdH0gY2F0Y2ggKGUpIHt9XHJcblxyXG5cdFx0cmV0dXJuIHN1cHBvcnRzUGFzc2l2ZTtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIGdldFN1cHBvcnRzVG91Y2hBY3Rpb25Ob25lICggKSB7XHJcblx0XHRyZXR1cm4gd2luZG93LkNTUyAmJiBDU1Muc3VwcG9ydHMgJiYgQ1NTLnN1cHBvcnRzKCd0b3VjaC1hY3Rpb24nLCAnbm9uZScpO1xyXG5cdH1cclxuXHJcblxyXG4vLyBWYWx1ZSBjYWxjdWxhdGlvblxyXG5cclxuXHQvLyBEZXRlcm1pbmUgdGhlIHNpemUgb2YgYSBzdWItcmFuZ2UgaW4gcmVsYXRpb24gdG8gYSBmdWxsIHJhbmdlLlxyXG5cdGZ1bmN0aW9uIHN1YlJhbmdlUmF0aW8gKCBwYSwgcGIgKSB7XHJcblx0XHRyZXR1cm4gKDEwMCAvIChwYiAtIHBhKSk7XHJcblx0fVxyXG5cclxuXHQvLyAocGVyY2VudGFnZSkgSG93IG1hbnkgcGVyY2VudCBpcyB0aGlzIHZhbHVlIG9mIHRoaXMgcmFuZ2U/XHJcblx0ZnVuY3Rpb24gZnJvbVBlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gKHZhbHVlICogMTAwKSAvICggcmFuZ2VbMV0gLSByYW5nZVswXSApO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIFdoZXJlIGlzIHRoaXMgdmFsdWUgb24gdGhpcyByYW5nZT9cclxuXHRmdW5jdGlvbiB0b1BlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gZnJvbVBlcmNlbnRhZ2UoIHJhbmdlLCByYW5nZVswXSA8IDAgP1xyXG5cdFx0XHR2YWx1ZSArIE1hdGguYWJzKHJhbmdlWzBdKSA6XHJcblx0XHRcdFx0dmFsdWUgLSByYW5nZVswXSApO1xyXG5cdH1cclxuXHJcblx0Ly8gKHZhbHVlKSBIb3cgbXVjaCBpcyB0aGlzIHBlcmNlbnRhZ2Ugb24gdGhpcyByYW5nZT9cclxuXHRmdW5jdGlvbiBpc1BlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gKCh2YWx1ZSAqICggcmFuZ2VbMV0gLSByYW5nZVswXSApKSAvIDEwMCkgKyByYW5nZVswXTtcclxuXHR9XHJcblxyXG5cclxuLy8gUmFuZ2UgY29udmVyc2lvblxyXG5cclxuXHRmdW5jdGlvbiBnZXRKICggdmFsdWUsIGFyciApIHtcclxuXHJcblx0XHR2YXIgaiA9IDE7XHJcblxyXG5cdFx0d2hpbGUgKCB2YWx1ZSA+PSBhcnJbal0gKXtcclxuXHRcdFx0aiArPSAxO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBqO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIElucHV0IGEgdmFsdWUsIGZpbmQgd2hlcmUsIG9uIGEgc2NhbGUgb2YgMC0xMDAsIGl0IGFwcGxpZXMuXHJcblx0ZnVuY3Rpb24gdG9TdGVwcGluZyAoIHhWYWwsIHhQY3QsIHZhbHVlICkge1xyXG5cclxuXHRcdGlmICggdmFsdWUgPj0geFZhbC5zbGljZSgtMSlbMF0gKXtcclxuXHRcdFx0cmV0dXJuIDEwMDtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgaiA9IGdldEooIHZhbHVlLCB4VmFsICk7XHJcblx0XHR2YXIgdmEgPSB4VmFsW2otMV07XHJcblx0XHR2YXIgdmIgPSB4VmFsW2pdO1xyXG5cdFx0dmFyIHBhID0geFBjdFtqLTFdO1xyXG5cdFx0dmFyIHBiID0geFBjdFtqXTtcclxuXHJcblx0XHRyZXR1cm4gcGEgKyAodG9QZXJjZW50YWdlKFt2YSwgdmJdLCB2YWx1ZSkgLyBzdWJSYW5nZVJhdGlvIChwYSwgcGIpKTtcclxuXHR9XHJcblxyXG5cdC8vICh2YWx1ZSkgSW5wdXQgYSBwZXJjZW50YWdlLCBmaW5kIHdoZXJlIGl0IGlzIG9uIHRoZSBzcGVjaWZpZWQgcmFuZ2UuXHJcblx0ZnVuY3Rpb24gZnJvbVN0ZXBwaW5nICggeFZhbCwgeFBjdCwgdmFsdWUgKSB7XHJcblxyXG5cdFx0Ly8gVGhlcmUgaXMgbm8gcmFuZ2UgZ3JvdXAgdGhhdCBmaXRzIDEwMFxyXG5cdFx0aWYgKCB2YWx1ZSA+PSAxMDAgKXtcclxuXHRcdFx0cmV0dXJuIHhWYWwuc2xpY2UoLTEpWzBdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBqID0gZ2V0SiggdmFsdWUsIHhQY3QgKTtcclxuXHRcdHZhciB2YSA9IHhWYWxbai0xXTtcclxuXHRcdHZhciB2YiA9IHhWYWxbal07XHJcblx0XHR2YXIgcGEgPSB4UGN0W2otMV07XHJcblx0XHR2YXIgcGIgPSB4UGN0W2pdO1xyXG5cclxuXHRcdHJldHVybiBpc1BlcmNlbnRhZ2UoW3ZhLCB2Yl0sICh2YWx1ZSAtIHBhKSAqIHN1YlJhbmdlUmF0aW8gKHBhLCBwYikpO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIEdldCB0aGUgc3RlcCB0aGF0IGFwcGxpZXMgYXQgYSBjZXJ0YWluIHZhbHVlLlxyXG5cdGZ1bmN0aW9uIGdldFN0ZXAgKCB4UGN0LCB4U3RlcHMsIHNuYXAsIHZhbHVlICkge1xyXG5cclxuXHRcdGlmICggdmFsdWUgPT09IDEwMCApIHtcclxuXHRcdFx0cmV0dXJuIHZhbHVlO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBqID0gZ2V0SiggdmFsdWUsIHhQY3QgKTtcclxuXHRcdHZhciBhID0geFBjdFtqLTFdO1xyXG5cdFx0dmFyIGIgPSB4UGN0W2pdO1xyXG5cclxuXHRcdC8vIElmICdzbmFwJyBpcyBzZXQsIHN0ZXBzIGFyZSB1c2VkIGFzIGZpeGVkIHBvaW50cyBvbiB0aGUgc2xpZGVyLlxyXG5cdFx0aWYgKCBzbmFwICkge1xyXG5cclxuXHRcdFx0Ly8gRmluZCB0aGUgY2xvc2VzdCBwb3NpdGlvbiwgYSBvciBiLlxyXG5cdFx0XHRpZiAoKHZhbHVlIC0gYSkgPiAoKGItYSkvMikpe1xyXG5cdFx0XHRcdHJldHVybiBiO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRyZXR1cm4gYTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoICF4U3RlcHNbai0xXSApe1xyXG5cdFx0XHRyZXR1cm4gdmFsdWU7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHhQY3Rbai0xXSArIGNsb3Nlc3QoXHJcblx0XHRcdHZhbHVlIC0geFBjdFtqLTFdLFxyXG5cdFx0XHR4U3RlcHNbai0xXVxyXG5cdFx0KTtcclxuXHR9XHJcblxyXG5cclxuLy8gRW50cnkgcGFyc2luZ1xyXG5cclxuXHRmdW5jdGlvbiBoYW5kbGVFbnRyeVBvaW50ICggaW5kZXgsIHZhbHVlLCB0aGF0ICkge1xyXG5cclxuXHRcdHZhciBwZXJjZW50YWdlO1xyXG5cclxuXHRcdC8vIFdyYXAgbnVtZXJpY2FsIGlucHV0IGluIGFuIGFycmF5LlxyXG5cdFx0aWYgKCB0eXBlb2YgdmFsdWUgPT09IFwibnVtYmVyXCIgKSB7XHJcblx0XHRcdHZhbHVlID0gW3ZhbHVlXTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBSZWplY3QgYW55IGludmFsaWQgaW5wdXQsIGJ5IHRlc3Rpbmcgd2hldGhlciB2YWx1ZSBpcyBhbiBhcnJheS5cclxuXHRcdGlmICggIUFycmF5LmlzQXJyYXkodmFsdWUpICl7XHJcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3JhbmdlJyBjb250YWlucyBpbnZhbGlkIHZhbHVlLlwiKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBDb3ZlcnQgbWluL21heCBzeW50YXggdG8gMCBhbmQgMTAwLlxyXG5cdFx0aWYgKCBpbmRleCA9PT0gJ21pbicgKSB7XHJcblx0XHRcdHBlcmNlbnRhZ2UgPSAwO1xyXG5cdFx0fSBlbHNlIGlmICggaW5kZXggPT09ICdtYXgnICkge1xyXG5cdFx0XHRwZXJjZW50YWdlID0gMTAwO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0cGVyY2VudGFnZSA9IHBhcnNlRmxvYXQoIGluZGV4ICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQ2hlY2sgZm9yIGNvcnJlY3QgaW5wdXQuXHJcblx0XHRpZiAoICFpc051bWVyaWMoIHBlcmNlbnRhZ2UgKSB8fCAhaXNOdW1lcmljKCB2YWx1ZVswXSApICkge1xyXG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdyYW5nZScgdmFsdWUgaXNuJ3QgbnVtZXJpYy5cIik7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gU3RvcmUgdmFsdWVzLlxyXG5cdFx0dGhhdC54UGN0LnB1c2goIHBlcmNlbnRhZ2UgKTtcclxuXHRcdHRoYXQueFZhbC5wdXNoKCB2YWx1ZVswXSApO1xyXG5cclxuXHRcdC8vIE5hTiB3aWxsIGV2YWx1YXRlIHRvIGZhbHNlIHRvbywgYnV0IHRvIGtlZXBcclxuXHRcdC8vIGxvZ2dpbmcgY2xlYXIsIHNldCBzdGVwIGV4cGxpY2l0bHkuIE1ha2Ugc3VyZVxyXG5cdFx0Ly8gbm90IHRvIG92ZXJyaWRlIHRoZSAnc3RlcCcgc2V0dGluZyB3aXRoIGZhbHNlLlxyXG5cdFx0aWYgKCAhcGVyY2VudGFnZSApIHtcclxuXHRcdFx0aWYgKCAhaXNOYU4oIHZhbHVlWzFdICkgKSB7XHJcblx0XHRcdFx0dGhhdC54U3RlcHNbMF0gPSB2YWx1ZVsxXTtcclxuXHRcdFx0fVxyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0dGhhdC54U3RlcHMucHVzaCggaXNOYU4odmFsdWVbMV0pID8gZmFsc2UgOiB2YWx1ZVsxXSApO1xyXG5cdFx0fVxyXG5cclxuXHRcdHRoYXQueEhpZ2hlc3RDb21wbGV0ZVN0ZXAucHVzaCgwKTtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIGhhbmRsZVN0ZXBQb2ludCAoIGksIG4sIHRoYXQgKSB7XHJcblxyXG5cdFx0Ly8gSWdub3JlICdmYWxzZScgc3RlcHBpbmcuXHJcblx0XHRpZiAoICFuICkge1xyXG5cdFx0XHRyZXR1cm4gdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBGYWN0b3IgdG8gcmFuZ2UgcmF0aW9cclxuXHRcdHRoYXQueFN0ZXBzW2ldID0gZnJvbVBlcmNlbnRhZ2UoW3RoYXQueFZhbFtpXSwgdGhhdC54VmFsW2krMV1dLCBuKSAvIHN1YlJhbmdlUmF0aW8odGhhdC54UGN0W2ldLCB0aGF0LnhQY3RbaSsxXSk7XHJcblxyXG5cdFx0dmFyIHRvdGFsU3RlcHMgPSAodGhhdC54VmFsW2krMV0gLSB0aGF0LnhWYWxbaV0pIC8gdGhhdC54TnVtU3RlcHNbaV07XHJcblx0XHR2YXIgaGlnaGVzdFN0ZXAgPSBNYXRoLmNlaWwoTnVtYmVyKHRvdGFsU3RlcHMudG9GaXhlZCgzKSkgLSAxKTtcclxuXHRcdHZhciBzdGVwID0gdGhhdC54VmFsW2ldICsgKHRoYXQueE51bVN0ZXBzW2ldICogaGlnaGVzdFN0ZXApO1xyXG5cclxuXHRcdHRoYXQueEhpZ2hlc3RDb21wbGV0ZVN0ZXBbaV0gPSBzdGVwO1xyXG5cdH1cclxuXHJcblxyXG4vLyBJbnRlcmZhY2VcclxuXHJcblx0ZnVuY3Rpb24gU3BlY3RydW0gKCBlbnRyeSwgc25hcCwgc2luZ2xlU3RlcCApIHtcclxuXHJcblx0XHR0aGlzLnhQY3QgPSBbXTtcclxuXHRcdHRoaXMueFZhbCA9IFtdO1xyXG5cdFx0dGhpcy54U3RlcHMgPSBbIHNpbmdsZVN0ZXAgfHwgZmFsc2UgXTtcclxuXHRcdHRoaXMueE51bVN0ZXBzID0gWyBmYWxzZSBdO1xyXG5cdFx0dGhpcy54SGlnaGVzdENvbXBsZXRlU3RlcCA9IFtdO1xyXG5cclxuXHRcdHRoaXMuc25hcCA9IHNuYXA7XHJcblxyXG5cdFx0dmFyIGluZGV4O1xyXG5cdFx0dmFyIG9yZGVyZWQgPSBbXTsgLy8gWzAsICdtaW4nXSwgWzEsICc1MCUnXSwgWzIsICdtYXgnXVxyXG5cclxuXHRcdC8vIE1hcCB0aGUgb2JqZWN0IGtleXMgdG8gYW4gYXJyYXkuXHJcblx0XHRmb3IgKCBpbmRleCBpbiBlbnRyeSApIHtcclxuXHRcdFx0aWYgKCBlbnRyeS5oYXNPd25Qcm9wZXJ0eShpbmRleCkgKSB7XHJcblx0XHRcdFx0b3JkZXJlZC5wdXNoKFtlbnRyeVtpbmRleF0sIGluZGV4XSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBTb3J0IGFsbCBlbnRyaWVzIGJ5IHZhbHVlIChudW1lcmljIHNvcnQpLlxyXG5cdFx0aWYgKCBvcmRlcmVkLmxlbmd0aCAmJiB0eXBlb2Ygb3JkZXJlZFswXVswXSA9PT0gXCJvYmplY3RcIiApIHtcclxuXHRcdFx0b3JkZXJlZC5zb3J0KGZ1bmN0aW9uKGEsIGIpIHsgcmV0dXJuIGFbMF1bMF0gLSBiWzBdWzBdOyB9KTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdG9yZGVyZWQuc29ydChmdW5jdGlvbihhLCBiKSB7IHJldHVybiBhWzBdIC0gYlswXTsgfSk7XHJcblx0XHR9XHJcblxyXG5cclxuXHRcdC8vIENvbnZlcnQgYWxsIGVudHJpZXMgdG8gc3VicmFuZ2VzLlxyXG5cdFx0Zm9yICggaW5kZXggPSAwOyBpbmRleCA8IG9yZGVyZWQubGVuZ3RoOyBpbmRleCsrICkge1xyXG5cdFx0XHRoYW5kbGVFbnRyeVBvaW50KG9yZGVyZWRbaW5kZXhdWzFdLCBvcmRlcmVkW2luZGV4XVswXSwgdGhpcyk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gU3RvcmUgdGhlIGFjdHVhbCBzdGVwIHZhbHVlcy5cclxuXHRcdC8vIHhTdGVwcyBpcyBzb3J0ZWQgaW4gdGhlIHNhbWUgb3JkZXIgYXMgeFBjdCBhbmQgeFZhbC5cclxuXHRcdHRoaXMueE51bVN0ZXBzID0gdGhpcy54U3RlcHMuc2xpY2UoMCk7XHJcblxyXG5cdFx0Ly8gQ29udmVydCBhbGwgbnVtZXJpYyBzdGVwcyB0byB0aGUgcGVyY2VudGFnZSBvZiB0aGUgc3VicmFuZ2UgdGhleSByZXByZXNlbnQuXHJcblx0XHRmb3IgKCBpbmRleCA9IDA7IGluZGV4IDwgdGhpcy54TnVtU3RlcHMubGVuZ3RoOyBpbmRleCsrICkge1xyXG5cdFx0XHRoYW5kbGVTdGVwUG9pbnQoaW5kZXgsIHRoaXMueE51bVN0ZXBzW2luZGV4XSwgdGhpcyk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUuZ2V0TWFyZ2luID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHJcblx0XHR2YXIgc3RlcCA9IHRoaXMueE51bVN0ZXBzWzBdO1xyXG5cclxuXHRcdGlmICggc3RlcCAmJiAoKHZhbHVlIC8gc3RlcCkgJSAxKSAhPT0gMCApIHtcclxuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbGltaXQnLCAnbWFyZ2luJyBhbmQgJ3BhZGRpbmcnIG11c3QgYmUgZGl2aXNpYmxlIGJ5IHN0ZXAuXCIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiB0aGlzLnhQY3QubGVuZ3RoID09PSAyID8gZnJvbVBlcmNlbnRhZ2UodGhpcy54VmFsLCB2YWx1ZSkgOiBmYWxzZTtcclxuXHR9O1xyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUudG9TdGVwcGluZyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0dmFsdWUgPSB0b1N0ZXBwaW5nKCB0aGlzLnhWYWwsIHRoaXMueFBjdCwgdmFsdWUgKTtcclxuXHJcblx0XHRyZXR1cm4gdmFsdWU7XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmZyb21TdGVwcGluZyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0cmV0dXJuIGZyb21TdGVwcGluZyggdGhpcy54VmFsLCB0aGlzLnhQY3QsIHZhbHVlICk7XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmdldFN0ZXAgPSBmdW5jdGlvbiAoIHZhbHVlICkge1xyXG5cclxuXHRcdHZhbHVlID0gZ2V0U3RlcCh0aGlzLnhQY3QsIHRoaXMueFN0ZXBzLCB0aGlzLnNuYXAsIHZhbHVlICk7XHJcblxyXG5cdFx0cmV0dXJuIHZhbHVlO1xyXG5cdH07XHJcblxyXG5cdFNwZWN0cnVtLnByb3RvdHlwZS5nZXROZWFyYnlTdGVwcyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0dmFyIGogPSBnZXRKKHZhbHVlLCB0aGlzLnhQY3QpO1xyXG5cclxuXHRcdHJldHVybiB7XHJcblx0XHRcdHN0ZXBCZWZvcmU6IHsgc3RhcnRWYWx1ZTogdGhpcy54VmFsW2otMl0sIHN0ZXA6IHRoaXMueE51bVN0ZXBzW2otMl0sIGhpZ2hlc3RTdGVwOiB0aGlzLnhIaWdoZXN0Q29tcGxldGVTdGVwW2otMl0gfSxcclxuXHRcdFx0dGhpc1N0ZXA6IHsgc3RhcnRWYWx1ZTogdGhpcy54VmFsW2otMV0sIHN0ZXA6IHRoaXMueE51bVN0ZXBzW2otMV0sIGhpZ2hlc3RTdGVwOiB0aGlzLnhIaWdoZXN0Q29tcGxldGVTdGVwW2otMV0gfSxcclxuXHRcdFx0c3RlcEFmdGVyOiB7IHN0YXJ0VmFsdWU6IHRoaXMueFZhbFtqLTBdLCBzdGVwOiB0aGlzLnhOdW1TdGVwc1tqLTBdLCBoaWdoZXN0U3RlcDogdGhpcy54SGlnaGVzdENvbXBsZXRlU3RlcFtqLTBdIH1cclxuXHRcdH07XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmNvdW50U3RlcERlY2ltYWxzID0gZnVuY3Rpb24gKCkge1xyXG5cdFx0dmFyIHN0ZXBEZWNpbWFscyA9IHRoaXMueE51bVN0ZXBzLm1hcChjb3VudERlY2ltYWxzKTtcclxuXHRcdHJldHVybiBNYXRoLm1heC5hcHBseShudWxsLCBzdGVwRGVjaW1hbHMpO1xyXG5cdH07XHJcblxyXG5cdC8vIE91dHNpZGUgdGVzdGluZ1xyXG5cdFNwZWN0cnVtLnByb3RvdHlwZS5jb252ZXJ0ID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHRcdHJldHVybiB0aGlzLmdldFN0ZXAodGhpcy50b1N0ZXBwaW5nKHZhbHVlKSk7XHJcblx0fTtcclxuXHJcbi8qXHRFdmVyeSBpbnB1dCBvcHRpb24gaXMgdGVzdGVkIGFuZCBwYXJzZWQuIFRoaXMnbGwgcHJldmVudFxuXHRlbmRsZXNzIHZhbGlkYXRpb24gaW4gaW50ZXJuYWwgbWV0aG9kcy4gVGhlc2UgdGVzdHMgYXJlXG5cdHN0cnVjdHVyZWQgd2l0aCBhbiBpdGVtIGZvciBldmVyeSBvcHRpb24gYXZhaWxhYmxlLiBBblxuXHRvcHRpb24gY2FuIGJlIG1hcmtlZCBhcyByZXF1aXJlZCBieSBzZXR0aW5nIHRoZSAncicgZmxhZy5cblx0VGhlIHRlc3RpbmcgZnVuY3Rpb24gaXMgcHJvdmlkZWQgd2l0aCB0aHJlZSBhcmd1bWVudHM6XG5cdFx0LSBUaGUgcHJvdmlkZWQgdmFsdWUgZm9yIHRoZSBvcHRpb247XG5cdFx0LSBBIHJlZmVyZW5jZSB0byB0aGUgb3B0aW9ucyBvYmplY3Q7XG5cdFx0LSBUaGUgbmFtZSBmb3IgdGhlIG9wdGlvbjtcblxuXHRUaGUgdGVzdGluZyBmdW5jdGlvbiByZXR1cm5zIGZhbHNlIHdoZW4gYW4gZXJyb3IgaXMgZGV0ZWN0ZWQsXG5cdG9yIHRydWUgd2hlbiBldmVyeXRoaW5nIGlzIE9LLiBJdCBjYW4gYWxzbyBtb2RpZnkgdGhlIG9wdGlvblxuXHRvYmplY3QsIHRvIG1ha2Ugc3VyZSBhbGwgdmFsdWVzIGNhbiBiZSBjb3JyZWN0bHkgbG9vcGVkIGVsc2V3aGVyZS4gKi9cblxuXHR2YXIgZGVmYXVsdEZvcm1hdHRlciA9IHsgJ3RvJzogZnVuY3Rpb24oIHZhbHVlICl7XG5cdFx0cmV0dXJuIHZhbHVlICE9PSB1bmRlZmluZWQgJiYgdmFsdWUudG9GaXhlZCgyKTtcblx0fSwgJ2Zyb20nOiBOdW1iZXIgfTtcblxuXHRmdW5jdGlvbiB2YWxpZGF0ZUZvcm1hdCAoIGVudHJ5ICkge1xuXG5cdFx0Ly8gQW55IG9iamVjdCB3aXRoIGEgdG8gYW5kIGZyb20gbWV0aG9kIGlzIHN1cHBvcnRlZC5cblx0XHRpZiAoIGlzVmFsaWRGb3JtYXR0ZXIoZW50cnkpICkge1xuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fVxuXG5cdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnZm9ybWF0JyByZXF1aXJlcyAndG8nIGFuZCAnZnJvbScgbWV0aG9kcy5cIik7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0U3RlcCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoICFpc051bWVyaWMoIGVudHJ5ICkgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdzdGVwJyBpcyBub3QgbnVtZXJpYy5cIik7XG5cdFx0fVxuXG5cdFx0Ly8gVGhlIHN0ZXAgb3B0aW9uIGNhbiBzdGlsbCBiZSB1c2VkIHRvIHNldCBzdGVwcGluZ1xuXHRcdC8vIGZvciBsaW5lYXIgc2xpZGVycy4gT3ZlcndyaXR0ZW4gaWYgc2V0IGluICdyYW5nZScuXG5cdFx0cGFyc2VkLnNpbmdsZVN0ZXAgPSBlbnRyeTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RSYW5nZSAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBGaWx0ZXIgaW5jb3JyZWN0IGlucHV0LlxuXHRcdGlmICggdHlwZW9mIGVudHJ5ICE9PSAnb2JqZWN0JyB8fCBBcnJheS5pc0FycmF5KGVudHJ5KSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3JhbmdlJyBpcyBub3QgYW4gb2JqZWN0LlwiKTtcblx0XHR9XG5cblx0XHQvLyBDYXRjaCBtaXNzaW5nIHN0YXJ0IG9yIGVuZC5cblx0XHRpZiAoIGVudHJ5Lm1pbiA9PT0gdW5kZWZpbmVkIHx8IGVudHJ5Lm1heCA9PT0gdW5kZWZpbmVkICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiBNaXNzaW5nICdtaW4nIG9yICdtYXgnIGluICdyYW5nZScuXCIpO1xuXHRcdH1cblxuXHRcdC8vIENhdGNoIGVxdWFsIHN0YXJ0IG9yIGVuZC5cblx0XHRpZiAoIGVudHJ5Lm1pbiA9PT0gZW50cnkubWF4ICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncmFuZ2UnICdtaW4nIGFuZCAnbWF4JyBjYW5ub3QgYmUgZXF1YWwuXCIpO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5zcGVjdHJ1bSA9IG5ldyBTcGVjdHJ1bShlbnRyeSwgcGFyc2VkLnNuYXAsIHBhcnNlZC5zaW5nbGVTdGVwKTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RTdGFydCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRlbnRyeSA9IGFzQXJyYXkoZW50cnkpO1xuXG5cdFx0Ly8gVmFsaWRhdGUgaW5wdXQuIFZhbHVlcyBhcmVuJ3QgdGVzdGVkLCBhcyB0aGUgcHVibGljIC52YWwgbWV0aG9kXG5cdFx0Ly8gd2lsbCBhbHdheXMgcHJvdmlkZSBhIHZhbGlkIGxvY2F0aW9uLlxuXHRcdGlmICggIUFycmF5LmlzQXJyYXkoIGVudHJ5ICkgfHwgIWVudHJ5Lmxlbmd0aCApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3N0YXJ0JyBvcHRpb24gaXMgaW5jb3JyZWN0LlwiKTtcblx0XHR9XG5cblx0XHQvLyBTdG9yZSB0aGUgbnVtYmVyIG9mIGhhbmRsZXMuXG5cdFx0cGFyc2VkLmhhbmRsZXMgPSBlbnRyeS5sZW5ndGg7XG5cblx0XHQvLyBXaGVuIHRoZSBzbGlkZXIgaXMgaW5pdGlhbGl6ZWQsIHRoZSAudmFsIG1ldGhvZCB3aWxsXG5cdFx0Ly8gYmUgY2FsbGVkIHdpdGggdGhlIHN0YXJ0IG9wdGlvbnMuXG5cdFx0cGFyc2VkLnN0YXJ0ID0gZW50cnk7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0U25hcCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBFbmZvcmNlIDEwMCUgc3RlcHBpbmcgd2l0aGluIHN1YnJhbmdlcy5cblx0XHRwYXJzZWQuc25hcCA9IGVudHJ5O1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdib29sZWFuJyApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnc25hcCcgb3B0aW9uIG11c3QgYmUgYSBib29sZWFuLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0QW5pbWF0ZSAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBFbmZvcmNlIDEwMCUgc3RlcHBpbmcgd2l0aGluIHN1YnJhbmdlcy5cblx0XHRwYXJzZWQuYW5pbWF0ZSA9IGVudHJ5O1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdib29sZWFuJyApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnYW5pbWF0ZScgb3B0aW9uIG11c3QgYmUgYSBib29sZWFuLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0QW5pbWF0aW9uRHVyYXRpb24gKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0cGFyc2VkLmFuaW1hdGlvbkR1cmF0aW9uID0gZW50cnk7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ251bWJlcicgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2FuaW1hdGlvbkR1cmF0aW9uJyBvcHRpb24gbXVzdCBiZSBhIG51bWJlci5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdENvbm5lY3QgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0dmFyIGNvbm5lY3QgPSBbZmFsc2VdO1xuXHRcdHZhciBpO1xuXG5cdFx0Ly8gTWFwIGxlZ2FjeSBvcHRpb25zXG5cdFx0aWYgKCBlbnRyeSA9PT0gJ2xvd2VyJyApIHtcblx0XHRcdGVudHJ5ID0gW3RydWUsIGZhbHNlXTtcblx0XHR9XG5cblx0XHRlbHNlIGlmICggZW50cnkgPT09ICd1cHBlcicgKSB7XG5cdFx0XHRlbnRyeSA9IFtmYWxzZSwgdHJ1ZV07XG5cdFx0fVxuXG5cdFx0Ly8gSGFuZGxlIGJvb2xlYW4gb3B0aW9uc1xuXHRcdGlmICggZW50cnkgPT09IHRydWUgfHwgZW50cnkgPT09IGZhbHNlICkge1xuXG5cdFx0XHRmb3IgKCBpID0gMTsgaSA8IHBhcnNlZC5oYW5kbGVzOyBpKysgKSB7XG5cdFx0XHRcdGNvbm5lY3QucHVzaChlbnRyeSk7XG5cdFx0XHR9XG5cblx0XHRcdGNvbm5lY3QucHVzaChmYWxzZSk7XG5cdFx0fVxuXG5cdFx0Ly8gUmVqZWN0IGludmFsaWQgaW5wdXRcblx0XHRlbHNlIGlmICggIUFycmF5LmlzQXJyYXkoIGVudHJ5ICkgfHwgIWVudHJ5Lmxlbmd0aCB8fCBlbnRyeS5sZW5ndGggIT09IHBhcnNlZC5oYW5kbGVzICsgMSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2Nvbm5lY3QnIG9wdGlvbiBkb2Vzbid0IG1hdGNoIGhhbmRsZSBjb3VudC5cIik7XG5cdFx0fVxuXG5cdFx0ZWxzZSB7XG5cdFx0XHRjb25uZWN0ID0gZW50cnk7XG5cdFx0fVxuXG5cdFx0cGFyc2VkLmNvbm5lY3QgPSBjb25uZWN0O1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdE9yaWVudGF0aW9uICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdC8vIFNldCBvcmllbnRhdGlvbiB0byBhbiBhIG51bWVyaWNhbCB2YWx1ZSBmb3IgZWFzeVxuXHRcdC8vIGFycmF5IHNlbGVjdGlvbi5cblx0XHRzd2l0Y2ggKCBlbnRyeSApe1xuXHRcdFx0Y2FzZSAnaG9yaXpvbnRhbCc6XG5cdFx0XHRcdHBhcnNlZC5vcnQgPSAwO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdGNhc2UgJ3ZlcnRpY2FsJzpcblx0XHRcdFx0cGFyc2VkLm9ydCA9IDE7XG5cdFx0XHRcdGJyZWFrO1xuXHRcdFx0ZGVmYXVsdDpcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnb3JpZW50YXRpb24nIG9wdGlvbiBpcyBpbnZhbGlkLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0TWFyZ2luICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGlmICggIWlzTnVtZXJpYyhlbnRyeSkgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ21hcmdpbicgb3B0aW9uIG11c3QgYmUgbnVtZXJpYy5cIik7XG5cdFx0fVxuXG5cdFx0Ly8gSXNzdWUgIzU4MlxuXHRcdGlmICggZW50cnkgPT09IDAgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0cGFyc2VkLm1hcmdpbiA9IHBhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnkpO1xuXG5cdFx0aWYgKCAhcGFyc2VkLm1hcmdpbiApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ21hcmdpbicgb3B0aW9uIGlzIG9ubHkgc3VwcG9ydGVkIG9uIGxpbmVhciBzbGlkZXJzLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0TGltaXQgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCAhaXNOdW1lcmljKGVudHJ5KSApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbGltaXQnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMuXCIpO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5saW1pdCA9IHBhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnkpO1xuXG5cdFx0aWYgKCAhcGFyc2VkLmxpbWl0IHx8IHBhcnNlZC5oYW5kbGVzIDwgMiApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2xpbWl0JyBvcHRpb24gaXMgb25seSBzdXBwb3J0ZWQgb24gbGluZWFyIHNsaWRlcnMgd2l0aCAyIG9yIG1vcmUgaGFuZGxlcy5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdFBhZGRpbmcgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCAhaXNOdW1lcmljKGVudHJ5KSAmJiAhQXJyYXkuaXNBcnJheShlbnRyeSkgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMgb3IgYXJyYXkgb2YgZXhhY3RseSAyIG51bWJlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggQXJyYXkuaXNBcnJheShlbnRyeSkgJiYgIShlbnRyeS5sZW5ndGggPT09IDIgfHwgaXNOdW1lcmljKGVudHJ5WzBdKSB8fCBpc051bWVyaWMoZW50cnlbMV0pKSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMgb3IgYXJyYXkgb2YgZXhhY3RseSAyIG51bWJlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggZW50cnkgPT09IDAgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0aWYgKCAhQXJyYXkuaXNBcnJheShlbnRyeSkgKSB7XG5cdFx0XHRlbnRyeSA9IFtlbnRyeSwgZW50cnldO1xuXHRcdH1cblxuXHRcdC8vICdnZXRNYXJnaW4nIHJldHVybnMgZmFsc2UgZm9yIGludmFsaWQgdmFsdWVzLlxuXHRcdHBhcnNlZC5wYWRkaW5nID0gW3BhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnlbMF0pLCBwYXJzZWQuc3BlY3RydW0uZ2V0TWFyZ2luKGVudHJ5WzFdKV07XG5cblx0XHRpZiAoIHBhcnNlZC5wYWRkaW5nWzBdID09PSBmYWxzZSB8fCBwYXJzZWQucGFkZGluZ1sxXSA9PT0gZmFsc2UgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdwYWRkaW5nJyBvcHRpb24gaXMgb25seSBzdXBwb3J0ZWQgb24gbGluZWFyIHNsaWRlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggcGFyc2VkLnBhZGRpbmdbMF0gPCAwIHx8IHBhcnNlZC5wYWRkaW5nWzFdIDwgMCApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIGEgcG9zaXRpdmUgbnVtYmVyKHMpLlwiKTtcblx0XHR9XG5cblx0XHRpZiAoIHBhcnNlZC5wYWRkaW5nWzBdICsgcGFyc2VkLnBhZGRpbmdbMV0gPj0gMTAwICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncGFkZGluZycgb3B0aW9uIG11c3Qgbm90IGV4Y2VlZCAxMDAlIG9mIHRoZSByYW5nZS5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdERpcmVjdGlvbiAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBTZXQgZGlyZWN0aW9uIGFzIGEgbnVtZXJpY2FsIHZhbHVlIGZvciBlYXN5IHBhcnNpbmcuXG5cdFx0Ly8gSW52ZXJ0IGNvbm5lY3Rpb24gZm9yIFJUTCBzbGlkZXJzLCBzbyB0aGF0IHRoZSBwcm9wZXJcblx0XHQvLyBoYW5kbGVzIGdldCB0aGUgY29ubmVjdC9iYWNrZ3JvdW5kIGNsYXNzZXMuXG5cdFx0c3dpdGNoICggZW50cnkgKSB7XG5cdFx0XHRjYXNlICdsdHInOlxuXHRcdFx0XHRwYXJzZWQuZGlyID0gMDtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHRjYXNlICdydGwnOlxuXHRcdFx0XHRwYXJzZWQuZGlyID0gMTtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHRkZWZhdWx0OlxuXHRcdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdkaXJlY3Rpb24nIG9wdGlvbiB3YXMgbm90IHJlY29nbml6ZWQuXCIpO1xuXHRcdH1cblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RCZWhhdmlvdXIgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSBpbnB1dCBpcyBhIHN0cmluZy5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ3N0cmluZycgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdiZWhhdmlvdXInIG11c3QgYmUgYSBzdHJpbmcgY29udGFpbmluZyBvcHRpb25zLlwiKTtcblx0XHR9XG5cblx0XHQvLyBDaGVjayBpZiB0aGUgc3RyaW5nIGNvbnRhaW5zIGFueSBrZXl3b3Jkcy5cblx0XHQvLyBOb25lIGFyZSByZXF1aXJlZC5cblx0XHR2YXIgdGFwID0gZW50cnkuaW5kZXhPZigndGFwJykgPj0gMDtcblx0XHR2YXIgZHJhZyA9IGVudHJ5LmluZGV4T2YoJ2RyYWcnKSA+PSAwO1xuXHRcdHZhciBmaXhlZCA9IGVudHJ5LmluZGV4T2YoJ2ZpeGVkJykgPj0gMDtcblx0XHR2YXIgc25hcCA9IGVudHJ5LmluZGV4T2YoJ3NuYXAnKSA+PSAwO1xuXHRcdHZhciBob3ZlciA9IGVudHJ5LmluZGV4T2YoJ2hvdmVyJykgPj0gMDtcblxuXHRcdGlmICggZml4ZWQgKSB7XG5cblx0XHRcdGlmICggcGFyc2VkLmhhbmRsZXMgIT09IDIgKSB7XG5cdFx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2ZpeGVkJyBiZWhhdmlvdXIgbXVzdCBiZSB1c2VkIHdpdGggMiBoYW5kbGVzXCIpO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBVc2UgbWFyZ2luIHRvIGVuZm9yY2UgZml4ZWQgc3RhdGVcblx0XHRcdHRlc3RNYXJnaW4ocGFyc2VkLCBwYXJzZWQuc3RhcnRbMV0gLSBwYXJzZWQuc3RhcnRbMF0pO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5ldmVudHMgPSB7XG5cdFx0XHR0YXA6IHRhcCB8fCBzbmFwLFxuXHRcdFx0ZHJhZzogZHJhZyxcblx0XHRcdGZpeGVkOiBmaXhlZCxcblx0XHRcdHNuYXA6IHNuYXAsXG5cdFx0XHRob3ZlcjogaG92ZXJcblx0XHR9O1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdFRvb2x0aXBzICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGlmICggZW50cnkgPT09IGZhbHNlICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdGVsc2UgaWYgKCBlbnRyeSA9PT0gdHJ1ZSApIHtcblxuXHRcdFx0cGFyc2VkLnRvb2x0aXBzID0gW107XG5cblx0XHRcdGZvciAoIHZhciBpID0gMDsgaSA8IHBhcnNlZC5oYW5kbGVzOyBpKysgKSB7XG5cdFx0XHRcdHBhcnNlZC50b29sdGlwcy5wdXNoKHRydWUpO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdGVsc2Uge1xuXG5cdFx0XHRwYXJzZWQudG9vbHRpcHMgPSBhc0FycmF5KGVudHJ5KTtcblxuXHRcdFx0aWYgKCBwYXJzZWQudG9vbHRpcHMubGVuZ3RoICE9PSBwYXJzZWQuaGFuZGxlcyApIHtcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiBtdXN0IHBhc3MgYSBmb3JtYXR0ZXIgZm9yIGFsbCBoYW5kbGVzLlwiKTtcblx0XHRcdH1cblxuXHRcdFx0cGFyc2VkLnRvb2x0aXBzLmZvckVhY2goZnVuY3Rpb24oZm9ybWF0dGVyKXtcblx0XHRcdFx0aWYgKCB0eXBlb2YgZm9ybWF0dGVyICE9PSAnYm9vbGVhbicgJiYgKHR5cGVvZiBmb3JtYXR0ZXIgIT09ICdvYmplY3QnIHx8IHR5cGVvZiBmb3JtYXR0ZXIudG8gIT09ICdmdW5jdGlvbicpICkge1xuXHRcdFx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3Rvb2x0aXBzJyBtdXN0IGJlIHBhc3NlZCBhIGZvcm1hdHRlciBvciAnZmFsc2UnLlwiKTtcblx0XHRcdFx0fVxuXHRcdFx0fSk7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdEFyaWFGb3JtYXQgKCBwYXJzZWQsIGVudHJ5ICkge1xuXHRcdHBhcnNlZC5hcmlhRm9ybWF0ID0gZW50cnk7XG5cdFx0dmFsaWRhdGVGb3JtYXQoZW50cnkpO1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdEZvcm1hdCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cdFx0cGFyc2VkLmZvcm1hdCA9IGVudHJ5O1xuXHRcdHZhbGlkYXRlRm9ybWF0KGVudHJ5KTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RDc3NQcmVmaXggKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdzdHJpbmcnICYmIGVudHJ5ICE9PSBmYWxzZSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2Nzc1ByZWZpeCcgbXVzdCBiZSBhIHN0cmluZyBvciBgZmFsc2VgLlwiKTtcblx0XHR9XG5cblx0XHRwYXJzZWQuY3NzUHJlZml4ID0gZW50cnk7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0Q3NzQ2xhc3NlcyAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ29iamVjdCcgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdjc3NDbGFzc2VzJyBtdXN0IGJlIGFuIG9iamVjdC5cIik7XG5cdFx0fVxuXG5cdFx0aWYgKCB0eXBlb2YgcGFyc2VkLmNzc1ByZWZpeCA9PT0gJ3N0cmluZycgKSB7XG5cdFx0XHRwYXJzZWQuY3NzQ2xhc3NlcyA9IHt9O1xuXG5cdFx0XHRmb3IgKCB2YXIga2V5IGluIGVudHJ5ICkge1xuXHRcdFx0XHRpZiAoICFlbnRyeS5oYXNPd25Qcm9wZXJ0eShrZXkpICkgeyBjb250aW51ZTsgfVxuXG5cdFx0XHRcdHBhcnNlZC5jc3NDbGFzc2VzW2tleV0gPSBwYXJzZWQuY3NzUHJlZml4ICsgZW50cnlba2V5XTtcblx0XHRcdH1cblx0XHR9IGVsc2Uge1xuXHRcdFx0cGFyc2VkLmNzc0NsYXNzZXMgPSBlbnRyeTtcblx0XHR9XG5cdH1cblxuXHQvLyBUZXN0IGFsbCBkZXZlbG9wZXIgc2V0dGluZ3MgYW5kIHBhcnNlIHRvIGFzc3VtcHRpb24tc2FmZSB2YWx1ZXMuXG5cdGZ1bmN0aW9uIHRlc3RPcHRpb25zICggb3B0aW9ucyApIHtcblxuXHRcdC8vIFRvIHByb3ZlIGEgZml4IGZvciAjNTM3LCBmcmVlemUgb3B0aW9ucyBoZXJlLlxuXHRcdC8vIElmIHRoZSBvYmplY3QgaXMgbW9kaWZpZWQsIGFuIGVycm9yIHdpbGwgYmUgdGhyb3duLlxuXHRcdC8vIE9iamVjdC5mcmVlemUob3B0aW9ucyk7XG5cblx0XHR2YXIgcGFyc2VkID0ge1xuXHRcdFx0bWFyZ2luOiAwLFxuXHRcdFx0bGltaXQ6IDAsXG5cdFx0XHRwYWRkaW5nOiAwLFxuXHRcdFx0YW5pbWF0ZTogdHJ1ZSxcblx0XHRcdGFuaW1hdGlvbkR1cmF0aW9uOiAzMDAsXG5cdFx0XHRhcmlhRm9ybWF0OiBkZWZhdWx0Rm9ybWF0dGVyLFxuXHRcdFx0Zm9ybWF0OiBkZWZhdWx0Rm9ybWF0dGVyXG5cdFx0fTtcblxuXHRcdC8vIFRlc3RzIGFyZSBleGVjdXRlZCBpbiB0aGUgb3JkZXIgdGhleSBhcmUgcHJlc2VudGVkIGhlcmUuXG5cdFx0dmFyIHRlc3RzID0ge1xuXHRcdFx0J3N0ZXAnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0U3RlcCB9LFxuXHRcdFx0J3N0YXJ0JzogeyByOiB0cnVlLCB0OiB0ZXN0U3RhcnQgfSxcblx0XHRcdCdjb25uZWN0JzogeyByOiB0cnVlLCB0OiB0ZXN0Q29ubmVjdCB9LFxuXHRcdFx0J2RpcmVjdGlvbic6IHsgcjogdHJ1ZSwgdDogdGVzdERpcmVjdGlvbiB9LFxuXHRcdFx0J3NuYXAnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0U25hcCB9LFxuXHRcdFx0J2FuaW1hdGUnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0QW5pbWF0ZSB9LFxuXHRcdFx0J2FuaW1hdGlvbkR1cmF0aW9uJzogeyByOiBmYWxzZSwgdDogdGVzdEFuaW1hdGlvbkR1cmF0aW9uIH0sXG5cdFx0XHQncmFuZ2UnOiB7IHI6IHRydWUsIHQ6IHRlc3RSYW5nZSB9LFxuXHRcdFx0J29yaWVudGF0aW9uJzogeyByOiBmYWxzZSwgdDogdGVzdE9yaWVudGF0aW9uIH0sXG5cdFx0XHQnbWFyZ2luJzogeyByOiBmYWxzZSwgdDogdGVzdE1hcmdpbiB9LFxuXHRcdFx0J2xpbWl0JzogeyByOiBmYWxzZSwgdDogdGVzdExpbWl0IH0sXG5cdFx0XHQncGFkZGluZyc6IHsgcjogZmFsc2UsIHQ6IHRlc3RQYWRkaW5nIH0sXG5cdFx0XHQnYmVoYXZpb3VyJzogeyByOiB0cnVlLCB0OiB0ZXN0QmVoYXZpb3VyIH0sXG5cdFx0XHQnYXJpYUZvcm1hdCc6IHsgcjogZmFsc2UsIHQ6IHRlc3RBcmlhRm9ybWF0IH0sXG5cdFx0XHQnZm9ybWF0JzogeyByOiBmYWxzZSwgdDogdGVzdEZvcm1hdCB9LFxuXHRcdFx0J3Rvb2x0aXBzJzogeyByOiBmYWxzZSwgdDogdGVzdFRvb2x0aXBzIH0sXG5cdFx0XHQnY3NzUHJlZml4JzogeyByOiB0cnVlLCB0OiB0ZXN0Q3NzUHJlZml4IH0sXG5cdFx0XHQnY3NzQ2xhc3Nlcyc6IHsgcjogdHJ1ZSwgdDogdGVzdENzc0NsYXNzZXMgfVxuXHRcdH07XG5cblx0XHR2YXIgZGVmYXVsdHMgPSB7XG5cdFx0XHQnY29ubmVjdCc6IGZhbHNlLFxuXHRcdFx0J2RpcmVjdGlvbic6ICdsdHInLFxuXHRcdFx0J2JlaGF2aW91cic6ICd0YXAnLFxuXHRcdFx0J29yaWVudGF0aW9uJzogJ2hvcml6b250YWwnLFxuXHRcdFx0J2Nzc1ByZWZpeCcgOiAnbm9VaS0nLFxuXHRcdFx0J2Nzc0NsYXNzZXMnOiB7XG5cdFx0XHRcdHRhcmdldDogJ3RhcmdldCcsXG5cdFx0XHRcdGJhc2U6ICdiYXNlJyxcblx0XHRcdFx0b3JpZ2luOiAnb3JpZ2luJyxcblx0XHRcdFx0aGFuZGxlOiAnaGFuZGxlJyxcblx0XHRcdFx0aGFuZGxlTG93ZXI6ICdoYW5kbGUtbG93ZXInLFxuXHRcdFx0XHRoYW5kbGVVcHBlcjogJ2hhbmRsZS11cHBlcicsXG5cdFx0XHRcdGhvcml6b250YWw6ICdob3Jpem9udGFsJyxcblx0XHRcdFx0dmVydGljYWw6ICd2ZXJ0aWNhbCcsXG5cdFx0XHRcdGJhY2tncm91bmQ6ICdiYWNrZ3JvdW5kJyxcblx0XHRcdFx0Y29ubmVjdDogJ2Nvbm5lY3QnLFxuXHRcdFx0XHRjb25uZWN0czogJ2Nvbm5lY3RzJyxcblx0XHRcdFx0bHRyOiAnbHRyJyxcblx0XHRcdFx0cnRsOiAncnRsJyxcblx0XHRcdFx0ZHJhZ2dhYmxlOiAnZHJhZ2dhYmxlJyxcblx0XHRcdFx0ZHJhZzogJ3N0YXRlLWRyYWcnLFxuXHRcdFx0XHR0YXA6ICdzdGF0ZS10YXAnLFxuXHRcdFx0XHRhY3RpdmU6ICdhY3RpdmUnLFxuXHRcdFx0XHR0b29sdGlwOiAndG9vbHRpcCcsXG5cdFx0XHRcdHBpcHM6ICdwaXBzJyxcblx0XHRcdFx0cGlwc0hvcml6b250YWw6ICdwaXBzLWhvcml6b250YWwnLFxuXHRcdFx0XHRwaXBzVmVydGljYWw6ICdwaXBzLXZlcnRpY2FsJyxcblx0XHRcdFx0bWFya2VyOiAnbWFya2VyJyxcblx0XHRcdFx0bWFya2VySG9yaXpvbnRhbDogJ21hcmtlci1ob3Jpem9udGFsJyxcblx0XHRcdFx0bWFya2VyVmVydGljYWw6ICdtYXJrZXItdmVydGljYWwnLFxuXHRcdFx0XHRtYXJrZXJOb3JtYWw6ICdtYXJrZXItbm9ybWFsJyxcblx0XHRcdFx0bWFya2VyTGFyZ2U6ICdtYXJrZXItbGFyZ2UnLFxuXHRcdFx0XHRtYXJrZXJTdWI6ICdtYXJrZXItc3ViJyxcblx0XHRcdFx0dmFsdWU6ICd2YWx1ZScsXG5cdFx0XHRcdHZhbHVlSG9yaXpvbnRhbDogJ3ZhbHVlLWhvcml6b250YWwnLFxuXHRcdFx0XHR2YWx1ZVZlcnRpY2FsOiAndmFsdWUtdmVydGljYWwnLFxuXHRcdFx0XHR2YWx1ZU5vcm1hbDogJ3ZhbHVlLW5vcm1hbCcsXG5cdFx0XHRcdHZhbHVlTGFyZ2U6ICd2YWx1ZS1sYXJnZScsXG5cdFx0XHRcdHZhbHVlU3ViOiAndmFsdWUtc3ViJ1xuXHRcdFx0fVxuXHRcdH07XG5cblx0XHQvLyBBcmlhRm9ybWF0IGRlZmF1bHRzIHRvIHJlZ3VsYXIgZm9ybWF0LCBpZiBhbnkuXG5cdFx0aWYgKCBvcHRpb25zLmZvcm1hdCAmJiAhb3B0aW9ucy5hcmlhRm9ybWF0ICkge1xuXHRcdFx0b3B0aW9ucy5hcmlhRm9ybWF0ID0gb3B0aW9ucy5mb3JtYXQ7XG5cdFx0fVxuXG5cdFx0Ly8gUnVuIGFsbCBvcHRpb25zIHRocm91Z2ggYSB0ZXN0aW5nIG1lY2hhbmlzbSB0byBlbnN1cmUgY29ycmVjdFxuXHRcdC8vIGlucHV0LiBJdCBzaG91bGQgYmUgbm90ZWQgdGhhdCBvcHRpb25zIG1pZ2h0IGdldCBtb2RpZmllZCB0b1xuXHRcdC8vIGJlIGhhbmRsZWQgcHJvcGVybHkuIEUuZy4gd3JhcHBpbmcgaW50ZWdlcnMgaW4gYXJyYXlzLlxuXHRcdE9iamVjdC5rZXlzKHRlc3RzKS5mb3JFYWNoKGZ1bmN0aW9uKCBuYW1lICl7XG5cblx0XHRcdC8vIElmIHRoZSBvcHRpb24gaXNuJ3Qgc2V0LCBidXQgaXQgaXMgcmVxdWlyZWQsIHRocm93IGFuIGVycm9yLlxuXHRcdFx0aWYgKCAhaXNTZXQob3B0aW9uc1tuYW1lXSkgJiYgZGVmYXVsdHNbbmFtZV0gPT09IHVuZGVmaW5lZCApIHtcblxuXHRcdFx0XHRpZiAoIHRlc3RzW25hbWVdLnIgKSB7XG5cdFx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnXCIgKyBuYW1lICsgXCInIGlzIHJlcXVpcmVkLlwiKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHJldHVybiB0cnVlO1xuXHRcdFx0fVxuXG5cdFx0XHR0ZXN0c1tuYW1lXS50KCBwYXJzZWQsICFpc1NldChvcHRpb25zW25hbWVdKSA/IGRlZmF1bHRzW25hbWVdIDogb3B0aW9uc1tuYW1lXSApO1xuXHRcdH0pO1xuXG5cdFx0Ly8gRm9yd2FyZCBwaXBzIG9wdGlvbnNcblx0XHRwYXJzZWQucGlwcyA9IG9wdGlvbnMucGlwcztcblxuXHRcdC8vIEFsbCByZWNlbnQgYnJvd3NlcnMgYWNjZXB0IHVucHJlZml4ZWQgdHJhbnNmb3JtLlxuXHRcdC8vIFdlIG5lZWQgLW1zLSBmb3IgSUU5IGFuZCAtd2Via2l0LSBmb3Igb2xkZXIgQW5kcm9pZDtcblx0XHQvLyBBc3N1bWUgdXNlIG9mIC13ZWJraXQtIGlmIHVucHJlZml4ZWQgYW5kIC1tcy0gYXJlIG5vdCBzdXBwb3J0ZWQuXG5cdFx0Ly8gaHR0cHM6Ly9jYW5pdXNlLmNvbS8jZmVhdD10cmFuc2Zvcm1zMmRcblx0XHR2YXIgZCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJkaXZcIik7XG5cdFx0dmFyIG1zUHJlZml4ID0gZC5zdHlsZS5tc1RyYW5zZm9ybSAhPT0gdW5kZWZpbmVkO1xuXHRcdHZhciBub1ByZWZpeCA9IGQuc3R5bGUudHJhbnNmb3JtICE9PSB1bmRlZmluZWQ7XG5cblx0XHRwYXJzZWQudHJhbnNmb3JtUnVsZSA9IG5vUHJlZml4ID8gJ3RyYW5zZm9ybScgOiAobXNQcmVmaXggPyAnbXNUcmFuc2Zvcm0nIDogJ3dlYmtpdFRyYW5zZm9ybScpO1xuXG5cdFx0Ly8gUGlwcyBkb24ndCBtb3ZlLCBzbyB3ZSBjYW4gcGxhY2UgdGhlbSB1c2luZyBsZWZ0L3RvcC5cblx0XHR2YXIgc3R5bGVzID0gW1snbGVmdCcsICd0b3AnXSwgWydyaWdodCcsICdib3R0b20nXV07XG5cblx0XHRwYXJzZWQuc3R5bGUgPSBzdHlsZXNbcGFyc2VkLmRpcl1bcGFyc2VkLm9ydF07XG5cblx0XHRyZXR1cm4gcGFyc2VkO1xuXHR9XG5cclxuXHJcbmZ1bmN0aW9uIHNjb3BlICggdGFyZ2V0LCBvcHRpb25zLCBvcmlnaW5hbE9wdGlvbnMgKXtcclxuXHJcblx0dmFyIGFjdGlvbnMgPSBnZXRBY3Rpb25zKCk7XHJcblx0dmFyIHN1cHBvcnRzVG91Y2hBY3Rpb25Ob25lID0gZ2V0U3VwcG9ydHNUb3VjaEFjdGlvbk5vbmUoKTtcclxuXHR2YXIgc3VwcG9ydHNQYXNzaXZlID0gc3VwcG9ydHNUb3VjaEFjdGlvbk5vbmUgJiYgZ2V0U3VwcG9ydHNQYXNzaXZlKCk7XHJcblxyXG5cdC8vIEFsbCB2YXJpYWJsZXMgbG9jYWwgdG8gJ3Njb3BlJyBhcmUgcHJlZml4ZWQgd2l0aCAnc2NvcGVfJ1xyXG5cdHZhciBzY29wZV9UYXJnZXQgPSB0YXJnZXQ7XHJcblx0dmFyIHNjb3BlX0xvY2F0aW9ucyA9IFtdO1xyXG5cdHZhciBzY29wZV9CYXNlO1xyXG5cdHZhciBzY29wZV9IYW5kbGVzO1xyXG5cdHZhciBzY29wZV9IYW5kbGVOdW1iZXJzID0gW107XHJcblx0dmFyIHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCA9IDA7XHJcblx0dmFyIHNjb3BlX0Nvbm5lY3RzO1xyXG5cdHZhciBzY29wZV9TcGVjdHJ1bSA9IG9wdGlvbnMuc3BlY3RydW07XHJcblx0dmFyIHNjb3BlX1ZhbHVlcyA9IFtdO1xyXG5cdHZhciBzY29wZV9FdmVudHMgPSB7fTtcclxuXHR2YXIgc2NvcGVfU2VsZjtcclxuXHR2YXIgc2NvcGVfUGlwcztcclxuXHR2YXIgc2NvcGVfRG9jdW1lbnQgPSB0YXJnZXQub3duZXJEb2N1bWVudDtcclxuXHR2YXIgc2NvcGVfRG9jdW1lbnRFbGVtZW50ID0gc2NvcGVfRG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50O1xyXG5cdHZhciBzY29wZV9Cb2R5ID0gc2NvcGVfRG9jdW1lbnQuYm9keTtcclxuXHJcblxyXG5cdC8vIEZvciBob3Jpem9udGFsIHNsaWRlcnMgaW4gc3RhbmRhcmQgbHRyIGRvY3VtZW50cyxcclxuXHQvLyBtYWtlIC5ub1VpLW9yaWdpbiBvdmVyZmxvdyB0byB0aGUgbGVmdCBzbyB0aGUgZG9jdW1lbnQgZG9lc24ndCBzY3JvbGwuXHJcblx0dmFyIHNjb3BlX0Rpck9mZnNldCA9IChzY29wZV9Eb2N1bWVudC5kaXIgPT09ICdydGwnKSB8fCAob3B0aW9ucy5vcnQgPT09IDEpID8gMCA6IDEwMDtcclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IENvbnN0cnVjdGlvbiBvZiBET00gZWxlbWVudHM7ICovXHJcblxyXG5cdC8vIENyZWF0ZXMgYSBub2RlLCBhZGRzIGl0IHRvIHRhcmdldCwgcmV0dXJucyB0aGUgbmV3IG5vZGUuXHJcblx0ZnVuY3Rpb24gYWRkTm9kZVRvICggYWRkVGFyZ2V0LCBjbGFzc05hbWUgKSB7XHJcblxyXG5cdFx0dmFyIGRpdiA9IHNjb3BlX0RvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xyXG5cclxuXHRcdGlmICggY2xhc3NOYW1lICkge1xyXG5cdFx0XHRhZGRDbGFzcyhkaXYsIGNsYXNzTmFtZSk7XHJcblx0XHR9XHJcblxyXG5cdFx0YWRkVGFyZ2V0LmFwcGVuZENoaWxkKGRpdik7XHJcblxyXG5cdFx0cmV0dXJuIGRpdjtcclxuXHR9XHJcblxyXG5cdC8vIEFwcGVuZCBhIG9yaWdpbiB0byB0aGUgYmFzZVxyXG5cdGZ1bmN0aW9uIGFkZE9yaWdpbiAoIGJhc2UsIGhhbmRsZU51bWJlciApIHtcclxuXHJcblx0XHR2YXIgb3JpZ2luID0gYWRkTm9kZVRvKGJhc2UsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5vcmlnaW4pO1xyXG5cdFx0dmFyIGhhbmRsZSA9IGFkZE5vZGVUbyhvcmlnaW4sIG9wdGlvbnMuY3NzQ2xhc3Nlcy5oYW5kbGUpO1xyXG5cclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ2RhdGEtaGFuZGxlJywgaGFuZGxlTnVtYmVyKTtcclxuXHJcblx0XHQvLyBodHRwczovL2RldmVsb3Blci5tb3ppbGxhLm9yZy9lbi1VUy9kb2NzL1dlYi9IVE1ML0dsb2JhbF9hdHRyaWJ1dGVzL3RhYmluZGV4XHJcblx0XHQvLyAwID0gZm9jdXNhYmxlIGFuZCByZWFjaGFibGVcclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ3RhYmluZGV4JywgJzAnKTtcclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ3JvbGUnLCAnc2xpZGVyJyk7XHJcblx0XHRoYW5kbGUuc2V0QXR0cmlidXRlKCdhcmlhLW9yaWVudGF0aW9uJywgb3B0aW9ucy5vcnQgPyAndmVydGljYWwnIDogJ2hvcml6b250YWwnKTtcclxuXHJcblx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gMCApIHtcclxuXHRcdFx0YWRkQ2xhc3MoaGFuZGxlLCBvcHRpb25zLmNzc0NsYXNzZXMuaGFuZGxlTG93ZXIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGVsc2UgaWYgKCBoYW5kbGVOdW1iZXIgPT09IG9wdGlvbnMuaGFuZGxlcyAtIDEgKSB7XHJcblx0XHRcdGFkZENsYXNzKGhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmhhbmRsZVVwcGVyKTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gb3JpZ2luO1xyXG5cdH1cclxuXHJcblx0Ly8gSW5zZXJ0IG5vZGVzIGZvciBjb25uZWN0IGVsZW1lbnRzXHJcblx0ZnVuY3Rpb24gYWRkQ29ubmVjdCAoIGJhc2UsIGFkZCApIHtcclxuXHJcblx0XHRpZiAoICFhZGQgKSB7XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gYWRkTm9kZVRvKGJhc2UsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5jb25uZWN0KTtcclxuXHR9XHJcblxyXG5cdC8vIEFkZCBoYW5kbGVzIHRvIHRoZSBzbGlkZXIgYmFzZS5cclxuXHRmdW5jdGlvbiBhZGRFbGVtZW50cyAoIGNvbm5lY3RPcHRpb25zLCBiYXNlICkge1xyXG5cclxuXHRcdHZhciBjb25uZWN0QmFzZSA9IGFkZE5vZGVUbyhiYXNlLCBvcHRpb25zLmNzc0NsYXNzZXMuY29ubmVjdHMpO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZXMgPSBbXTtcclxuXHRcdHNjb3BlX0Nvbm5lY3RzID0gW107XHJcblxyXG5cdFx0c2NvcGVfQ29ubmVjdHMucHVzaChhZGRDb25uZWN0KGNvbm5lY3RCYXNlLCBjb25uZWN0T3B0aW9uc1swXSkpO1xyXG5cclxuXHRcdC8vIFs6Ojo6Tz09PT1PPT09PU89PT09XVxyXG5cdFx0Ly8gY29ubmVjdE9wdGlvbnMgPSBbMCwgMSwgMSwgMV1cclxuXHJcblx0XHRmb3IgKCB2YXIgaSA9IDA7IGkgPCBvcHRpb25zLmhhbmRsZXM7IGkrKyApIHtcclxuXHRcdFx0Ly8gS2VlcCBhIGxpc3Qgb2YgYWxsIGFkZGVkIGhhbmRsZXMuXHJcblx0XHRcdHNjb3BlX0hhbmRsZXMucHVzaChhZGRPcmlnaW4oYmFzZSwgaSkpO1xyXG5cdFx0XHRzY29wZV9IYW5kbGVOdW1iZXJzW2ldID0gaTtcclxuXHRcdFx0c2NvcGVfQ29ubmVjdHMucHVzaChhZGRDb25uZWN0KGNvbm5lY3RCYXNlLCBjb25uZWN0T3B0aW9uc1tpICsgMV0pKTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8vIEluaXRpYWxpemUgYSBzaW5nbGUgc2xpZGVyLlxyXG5cdGZ1bmN0aW9uIGFkZFNsaWRlciAoIGFkZFRhcmdldCApIHtcclxuXHJcblx0XHQvLyBBcHBseSBjbGFzc2VzIGFuZCBkYXRhIHRvIHRoZSB0YXJnZXQuXHJcblx0XHRhZGRDbGFzcyhhZGRUYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50YXJnZXQpO1xyXG5cclxuXHRcdGlmICggb3B0aW9ucy5kaXIgPT09IDAgKSB7XHJcblx0XHRcdGFkZENsYXNzKGFkZFRhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmx0cik7XHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHRhZGRDbGFzcyhhZGRUYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5ydGwpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggb3B0aW9ucy5vcnQgPT09IDAgKSB7XHJcblx0XHRcdGFkZENsYXNzKGFkZFRhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmhvcml6b250YWwpO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0YWRkQ2xhc3MoYWRkVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMudmVydGljYWwpO1xyXG5cdFx0fVxyXG5cclxuXHRcdHNjb3BlX0Jhc2UgPSBhZGROb2RlVG8oYWRkVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMuYmFzZSk7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gYWRkVG9vbHRpcCAoIGhhbmRsZSwgaGFuZGxlTnVtYmVyICkge1xyXG5cclxuXHRcdGlmICggIW9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXSApIHtcclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBhZGROb2RlVG8oaGFuZGxlLmZpcnN0Q2hpbGQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50b29sdGlwKTtcclxuXHR9XHJcblxyXG5cdC8vIFRoZSB0b29sdGlwcyBvcHRpb24gaXMgYSBzaG9ydGhhbmQgZm9yIHVzaW5nIHRoZSAndXBkYXRlJyBldmVudC5cclxuXHRmdW5jdGlvbiB0b29sdGlwcyAoICkge1xyXG5cclxuXHRcdC8vIFRvb2x0aXBzIGFyZSBhZGRlZCB3aXRoIG9wdGlvbnMudG9vbHRpcHMgaW4gb3JpZ2luYWwgb3JkZXIuXHJcblx0XHR2YXIgdGlwcyA9IHNjb3BlX0hhbmRsZXMubWFwKGFkZFRvb2x0aXApO1xyXG5cclxuXHRcdGJpbmRFdmVudCgndXBkYXRlJywgZnVuY3Rpb24odmFsdWVzLCBoYW5kbGVOdW1iZXIsIHVuZW5jb2RlZCkge1xyXG5cclxuXHRcdFx0aWYgKCAhdGlwc1toYW5kbGVOdW1iZXJdICkge1xyXG5cdFx0XHRcdHJldHVybjtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0dmFyIGZvcm1hdHRlZFZhbHVlID0gdmFsdWVzW2hhbmRsZU51bWJlcl07XHJcblxyXG5cdFx0XHRpZiAoIG9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXSAhPT0gdHJ1ZSApIHtcclxuXHRcdFx0XHRmb3JtYXR0ZWRWYWx1ZSA9IG9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXS50byh1bmVuY29kZWRbaGFuZGxlTnVtYmVyXSk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHRpcHNbaGFuZGxlTnVtYmVyXS5pbm5lckhUTUwgPSBmb3JtYXR0ZWRWYWx1ZTtcclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblxyXG5cdGZ1bmN0aW9uIGFyaWEgKCApIHtcclxuXHJcblx0XHRiaW5kRXZlbnQoJ3VwZGF0ZScsIGZ1bmN0aW9uICggdmFsdWVzLCBoYW5kbGVOdW1iZXIsIHVuZW5jb2RlZCwgdGFwLCBwb3NpdGlvbnMgKSB7XHJcblxyXG5cdFx0XHQvLyBVcGRhdGUgQXJpYSBWYWx1ZXMgZm9yIGFsbCBoYW5kbGVzLCBhcyBhIGNoYW5nZSBpbiBvbmUgY2hhbmdlcyBtaW4gYW5kIG1heCB2YWx1ZXMgZm9yIHRoZSBuZXh0LlxyXG5cdFx0XHRzY29wZV9IYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oIGluZGV4ICl7XHJcblxyXG5cdFx0XHRcdHZhciBoYW5kbGUgPSBzY29wZV9IYW5kbGVzW2luZGV4XTtcclxuXHJcblx0XHRcdFx0dmFyIG1pbiA9IGNoZWNrSGFuZGxlUG9zaXRpb24oc2NvcGVfTG9jYXRpb25zLCBpbmRleCwgMCwgdHJ1ZSwgdHJ1ZSwgdHJ1ZSk7XHJcblx0XHRcdFx0dmFyIG1heCA9IGNoZWNrSGFuZGxlUG9zaXRpb24oc2NvcGVfTG9jYXRpb25zLCBpbmRleCwgMTAwLCB0cnVlLCB0cnVlLCB0cnVlKTtcclxuXHJcblx0XHRcdFx0dmFyIG5vdyA9IHBvc2l0aW9uc1tpbmRleF07XHJcblx0XHRcdFx0dmFyIHRleHQgPSBvcHRpb25zLmFyaWFGb3JtYXQudG8odW5lbmNvZGVkW2luZGV4XSk7XHJcblxyXG5cdFx0XHRcdGhhbmRsZS5jaGlsZHJlblswXS5zZXRBdHRyaWJ1dGUoJ2FyaWEtdmFsdWVtaW4nLCBtaW4udG9GaXhlZCgxKSk7XHJcblx0XHRcdFx0aGFuZGxlLmNoaWxkcmVuWzBdLnNldEF0dHJpYnV0ZSgnYXJpYS12YWx1ZW1heCcsIG1heC50b0ZpeGVkKDEpKTtcclxuXHRcdFx0XHRoYW5kbGUuY2hpbGRyZW5bMF0uc2V0QXR0cmlidXRlKCdhcmlhLXZhbHVlbm93Jywgbm93LnRvRml4ZWQoMSkpO1xyXG5cdFx0XHRcdGhhbmRsZS5jaGlsZHJlblswXS5zZXRBdHRyaWJ1dGUoJ2FyaWEtdmFsdWV0ZXh0JywgdGV4dCk7XHJcblx0XHRcdH0pO1xyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gZ2V0R3JvdXAgKCBtb2RlLCB2YWx1ZXMsIHN0ZXBwZWQgKSB7XHJcblxyXG5cdFx0Ly8gVXNlIHRoZSByYW5nZS5cclxuXHRcdGlmICggbW9kZSA9PT0gJ3JhbmdlJyB8fCBtb2RlID09PSAnc3RlcHMnICkge1xyXG5cdFx0XHRyZXR1cm4gc2NvcGVfU3BlY3RydW0ueFZhbDtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIG1vZGUgPT09ICdjb3VudCcgKSB7XHJcblxyXG5cdFx0XHRpZiAoIHZhbHVlcyA8IDIgKSB7XHJcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAndmFsdWVzJyAoPj0gMikgcmVxdWlyZWQgZm9yIG1vZGUgJ2NvdW50Jy5cIik7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIERpdmlkZSAwIC0gMTAwIGluICdjb3VudCcgcGFydHMuXHJcblx0XHRcdHZhciBpbnRlcnZhbCA9IHZhbHVlcyAtIDE7XHJcblx0XHRcdHZhciBzcHJlYWQgPSAoIDEwMCAvIGludGVydmFsICk7XHJcblxyXG5cdFx0XHR2YWx1ZXMgPSBbXTtcclxuXHJcblx0XHRcdC8vIExpc3QgdGhlc2UgcGFydHMgYW5kIGhhdmUgdGhlbSBoYW5kbGVkIGFzICdwb3NpdGlvbnMnLlxyXG5cdFx0XHR3aGlsZSAoIGludGVydmFsLS0gKSB7XHJcblx0XHRcdFx0dmFsdWVzWyBpbnRlcnZhbCBdID0gKCBpbnRlcnZhbCAqIHNwcmVhZCApO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHR2YWx1ZXMucHVzaCgxMDApO1xyXG5cclxuXHRcdFx0bW9kZSA9ICdwb3NpdGlvbnMnO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggbW9kZSA9PT0gJ3Bvc2l0aW9ucycgKSB7XHJcblxyXG5cdFx0XHQvLyBNYXAgYWxsIHBlcmNlbnRhZ2VzIHRvIG9uLXJhbmdlIHZhbHVlcy5cclxuXHRcdFx0cmV0dXJuIHZhbHVlcy5tYXAoZnVuY3Rpb24oIHZhbHVlICl7XHJcblx0XHRcdFx0cmV0dXJuIHNjb3BlX1NwZWN0cnVtLmZyb21TdGVwcGluZyggc3RlcHBlZCA/IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAoIHZhbHVlICkgOiB2YWx1ZSApO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIG1vZGUgPT09ICd2YWx1ZXMnICkge1xyXG5cclxuXHRcdFx0Ly8gSWYgdGhlIHZhbHVlIG11c3QgYmUgc3RlcHBlZCwgaXQgbmVlZHMgdG8gYmUgY29udmVydGVkIHRvIGEgcGVyY2VudGFnZSBmaXJzdC5cclxuXHRcdFx0aWYgKCBzdGVwcGVkICkge1xyXG5cclxuXHRcdFx0XHRyZXR1cm4gdmFsdWVzLm1hcChmdW5jdGlvbiggdmFsdWUgKXtcclxuXHJcblx0XHRcdFx0XHQvLyBDb252ZXJ0IHRvIHBlcmNlbnRhZ2UsIGFwcGx5IHN0ZXAsIHJldHVybiB0byB2YWx1ZS5cclxuXHRcdFx0XHRcdHJldHVybiBzY29wZV9TcGVjdHJ1bS5mcm9tU3RlcHBpbmcoIHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAoIHNjb3BlX1NwZWN0cnVtLnRvU3RlcHBpbmcoIHZhbHVlICkgKSApO1xyXG5cdFx0XHRcdH0pO1xyXG5cclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gT3RoZXJ3aXNlLCB3ZSBjYW4gc2ltcGx5IHVzZSB0aGUgdmFsdWVzLlxyXG5cdFx0XHRyZXR1cm4gdmFsdWVzO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gZ2VuZXJhdGVTcHJlYWQgKCBkZW5zaXR5LCBtb2RlLCBncm91cCApIHtcclxuXHJcblx0XHRmdW5jdGlvbiBzYWZlSW5jcmVtZW50KHZhbHVlLCBpbmNyZW1lbnQpIHtcclxuXHRcdFx0Ly8gQXZvaWQgZmxvYXRpbmcgcG9pbnQgdmFyaWFuY2UgYnkgZHJvcHBpbmcgdGhlIHNtYWxsZXN0IGRlY2ltYWwgcGxhY2VzLlxyXG5cdFx0XHRyZXR1cm4gKHZhbHVlICsgaW5jcmVtZW50KS50b0ZpeGVkKDcpIC8gMTtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgaW5kZXhlcyA9IHt9O1xyXG5cdFx0dmFyIGZpcnN0SW5SYW5nZSA9IHNjb3BlX1NwZWN0cnVtLnhWYWxbMF07XHJcblx0XHR2YXIgbGFzdEluUmFuZ2UgPSBzY29wZV9TcGVjdHJ1bS54VmFsW3Njb3BlX1NwZWN0cnVtLnhWYWwubGVuZ3RoLTFdO1xyXG5cdFx0dmFyIGlnbm9yZUZpcnN0ID0gZmFsc2U7XHJcblx0XHR2YXIgaWdub3JlTGFzdCA9IGZhbHNlO1xyXG5cdFx0dmFyIHByZXZQY3QgPSAwO1xyXG5cclxuXHRcdC8vIENyZWF0ZSBhIGNvcHkgb2YgdGhlIGdyb3VwLCBzb3J0IGl0IGFuZCBmaWx0ZXIgYXdheSBhbGwgZHVwbGljYXRlcy5cclxuXHRcdGdyb3VwID0gdW5pcXVlKGdyb3VwLnNsaWNlKCkuc29ydChmdW5jdGlvbihhLCBiKXsgcmV0dXJuIGEgLSBiOyB9KSk7XHJcblxyXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSByYW5nZSBzdGFydHMgd2l0aCB0aGUgZmlyc3QgZWxlbWVudC5cclxuXHRcdGlmICggZ3JvdXBbMF0gIT09IGZpcnN0SW5SYW5nZSApIHtcclxuXHRcdFx0Z3JvdXAudW5zaGlmdChmaXJzdEluUmFuZ2UpO1xyXG5cdFx0XHRpZ25vcmVGaXJzdCA9IHRydWU7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gTGlrZXdpc2UgZm9yIHRoZSBsYXN0IG9uZS5cclxuXHRcdGlmICggZ3JvdXBbZ3JvdXAubGVuZ3RoIC0gMV0gIT09IGxhc3RJblJhbmdlICkge1xyXG5cdFx0XHRncm91cC5wdXNoKGxhc3RJblJhbmdlKTtcclxuXHRcdFx0aWdub3JlTGFzdCA9IHRydWU7XHJcblx0XHR9XHJcblxyXG5cdFx0Z3JvdXAuZm9yRWFjaChmdW5jdGlvbiAoIGN1cnJlbnQsIGluZGV4ICkge1xyXG5cclxuXHRcdFx0Ly8gR2V0IHRoZSBjdXJyZW50IHN0ZXAgYW5kIHRoZSBsb3dlciArIHVwcGVyIHBvc2l0aW9ucy5cclxuXHRcdFx0dmFyIHN0ZXA7XHJcblx0XHRcdHZhciBpO1xyXG5cdFx0XHR2YXIgcTtcclxuXHRcdFx0dmFyIGxvdyA9IGN1cnJlbnQ7XHJcblx0XHRcdHZhciBoaWdoID0gZ3JvdXBbaW5kZXgrMV07XHJcblx0XHRcdHZhciBuZXdQY3Q7XHJcblx0XHRcdHZhciBwY3REaWZmZXJlbmNlO1xyXG5cdFx0XHR2YXIgcGN0UG9zO1xyXG5cdFx0XHR2YXIgdHlwZTtcclxuXHRcdFx0dmFyIHN0ZXBzO1xyXG5cdFx0XHR2YXIgcmVhbFN0ZXBzO1xyXG5cdFx0XHR2YXIgc3RlcHNpemU7XHJcblxyXG5cdFx0XHQvLyBXaGVuIHVzaW5nICdzdGVwcycgbW9kZSwgdXNlIHRoZSBwcm92aWRlZCBzdGVwcy5cclxuXHRcdFx0Ly8gT3RoZXJ3aXNlLCB3ZSdsbCBzdGVwIG9uIHRvIHRoZSBuZXh0IHN1YnJhbmdlLlxyXG5cdFx0XHRpZiAoIG1vZGUgPT09ICdzdGVwcycgKSB7XHJcblx0XHRcdFx0c3RlcCA9IHNjb3BlX1NwZWN0cnVtLnhOdW1TdGVwc1sgaW5kZXggXTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gRGVmYXVsdCB0byBhICdmdWxsJyBzdGVwLlxyXG5cdFx0XHRpZiAoICFzdGVwICkge1xyXG5cdFx0XHRcdHN0ZXAgPSBoaWdoLWxvdztcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gTG93IGNhbiBiZSAwLCBzbyB0ZXN0IGZvciBmYWxzZS4gSWYgaGlnaCBpcyB1bmRlZmluZWQsXHJcblx0XHRcdC8vIHdlIGFyZSBhdCB0aGUgbGFzdCBzdWJyYW5nZS4gSW5kZXggMCBpcyBhbHJlYWR5IGhhbmRsZWQuXHJcblx0XHRcdGlmICggbG93ID09PSBmYWxzZSB8fCBoaWdoID09PSB1bmRlZmluZWQgKSB7XHJcblx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBNYWtlIHN1cmUgc3RlcCBpc24ndCAwLCB3aGljaCB3b3VsZCBjYXVzZSBhbiBpbmZpbml0ZSBsb29wICgjNjU0KVxyXG5cdFx0XHRzdGVwID0gTWF0aC5tYXgoc3RlcCwgMC4wMDAwMDAxKTtcclxuXHJcblx0XHRcdC8vIEZpbmQgYWxsIHN0ZXBzIGluIHRoZSBzdWJyYW5nZS5cclxuXHRcdFx0Zm9yICggaSA9IGxvdzsgaSA8PSBoaWdoOyBpID0gc2FmZUluY3JlbWVudChpLCBzdGVwKSApIHtcclxuXHJcblx0XHRcdFx0Ly8gR2V0IHRoZSBwZXJjZW50YWdlIHZhbHVlIGZvciB0aGUgY3VycmVudCBzdGVwLFxyXG5cdFx0XHRcdC8vIGNhbGN1bGF0ZSB0aGUgc2l6ZSBmb3IgdGhlIHN1YnJhbmdlLlxyXG5cdFx0XHRcdG5ld1BjdCA9IHNjb3BlX1NwZWN0cnVtLnRvU3RlcHBpbmcoIGkgKTtcclxuXHRcdFx0XHRwY3REaWZmZXJlbmNlID0gbmV3UGN0IC0gcHJldlBjdDtcclxuXHJcblx0XHRcdFx0c3RlcHMgPSBwY3REaWZmZXJlbmNlIC8gZGVuc2l0eTtcclxuXHRcdFx0XHRyZWFsU3RlcHMgPSBNYXRoLnJvdW5kKHN0ZXBzKTtcclxuXHJcblx0XHRcdFx0Ly8gVGhpcyByYXRpbyByZXByZXNlbnRzIHRoZSBhbW91bnQgb2YgcGVyY2VudGFnZS1zcGFjZSBhIHBvaW50IGluZGljYXRlcy5cclxuXHRcdFx0XHQvLyBGb3IgYSBkZW5zaXR5IDEgdGhlIHBvaW50cy9wZXJjZW50YWdlID0gMS4gRm9yIGRlbnNpdHkgMiwgdGhhdCBwZXJjZW50YWdlIG5lZWRzIHRvIGJlIHJlLWRldmlkZWQuXHJcblx0XHRcdFx0Ly8gUm91bmQgdGhlIHBlcmNlbnRhZ2Ugb2Zmc2V0IHRvIGFuIGV2ZW4gbnVtYmVyLCB0aGVuIGRpdmlkZSBieSB0d29cclxuXHRcdFx0XHQvLyB0byBzcHJlYWQgdGhlIG9mZnNldCBvbiBib3RoIHNpZGVzIG9mIHRoZSByYW5nZS5cclxuXHRcdFx0XHRzdGVwc2l6ZSA9IHBjdERpZmZlcmVuY2UvcmVhbFN0ZXBzO1xyXG5cclxuXHRcdFx0XHQvLyBEaXZpZGUgYWxsIHBvaW50cyBldmVubHksIGFkZGluZyB0aGUgY29ycmVjdCBudW1iZXIgdG8gdGhpcyBzdWJyYW5nZS5cclxuXHRcdFx0XHQvLyBSdW4gdXAgdG8gPD0gc28gdGhhdCAxMDAlIGdldHMgYSBwb2ludCwgZXZlbnQgaWYgaWdub3JlTGFzdCBpcyBzZXQuXHJcblx0XHRcdFx0Zm9yICggcSA9IDE7IHEgPD0gcmVhbFN0ZXBzOyBxICs9IDEgKSB7XHJcblxyXG5cdFx0XHRcdFx0Ly8gVGhlIHJhdGlvIGJldHdlZW4gdGhlIHJvdW5kZWQgdmFsdWUgYW5kIHRoZSBhY3R1YWwgc2l6ZSBtaWdodCBiZSB+MSUgb2ZmLlxyXG5cdFx0XHRcdFx0Ly8gQ29ycmVjdCB0aGUgcGVyY2VudGFnZSBvZmZzZXQgYnkgdGhlIG51bWJlciBvZiBwb2ludHNcclxuXHRcdFx0XHRcdC8vIHBlciBzdWJyYW5nZS4gZGVuc2l0eSA9IDEgd2lsbCByZXN1bHQgaW4gMTAwIHBvaW50cyBvbiB0aGVcclxuXHRcdFx0XHRcdC8vIGZ1bGwgcmFuZ2UsIDIgZm9yIDUwLCA0IGZvciAyNSwgZXRjLlxyXG5cdFx0XHRcdFx0cGN0UG9zID0gcHJldlBjdCArICggcSAqIHN0ZXBzaXplICk7XHJcblx0XHRcdFx0XHRpbmRleGVzW3BjdFBvcy50b0ZpeGVkKDUpXSA9IFsneCcsIDBdO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gRGV0ZXJtaW5lIHRoZSBwb2ludCB0eXBlLlxyXG5cdFx0XHRcdHR5cGUgPSAoZ3JvdXAuaW5kZXhPZihpKSA+IC0xKSA/IDEgOiAoIG1vZGUgPT09ICdzdGVwcycgPyAyIDogMCApO1xyXG5cclxuXHRcdFx0XHQvLyBFbmZvcmNlIHRoZSAnaWdub3JlRmlyc3QnIG9wdGlvbiBieSBvdmVyd3JpdGluZyB0aGUgdHlwZSBmb3IgMC5cclxuXHRcdFx0XHRpZiAoICFpbmRleCAmJiBpZ25vcmVGaXJzdCApIHtcclxuXHRcdFx0XHRcdHR5cGUgPSAwO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0aWYgKCAhKGkgPT09IGhpZ2ggJiYgaWdub3JlTGFzdCkpIHtcclxuXHRcdFx0XHRcdC8vIE1hcmsgdGhlICd0eXBlJyBvZiB0aGlzIHBvaW50LiAwID0gcGxhaW4sIDEgPSByZWFsIHZhbHVlLCAyID0gc3RlcCB2YWx1ZS5cclxuXHRcdFx0XHRcdGluZGV4ZXNbbmV3UGN0LnRvRml4ZWQoNSldID0gW2ksIHR5cGVdO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gVXBkYXRlIHRoZSBwZXJjZW50YWdlIGNvdW50LlxyXG5cdFx0XHRcdHByZXZQY3QgPSBuZXdQY3Q7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cclxuXHRcdHJldHVybiBpbmRleGVzO1xyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gYWRkTWFya2luZyAoIHNwcmVhZCwgZmlsdGVyRnVuYywgZm9ybWF0dGVyICkge1xyXG5cclxuXHRcdHZhciBlbGVtZW50ID0gc2NvcGVfRG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XHJcblxyXG5cdFx0dmFyIHZhbHVlU2l6ZUNsYXNzZXMgPSBbXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZU5vcm1hbCxcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLnZhbHVlTGFyZ2UsXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZVN1YlxyXG5cdFx0XTtcclxuXHRcdHZhciBtYXJrZXJTaXplQ2xhc3NlcyA9IFtcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlck5vcm1hbCxcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlckxhcmdlLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyU3ViXHJcblx0XHRdO1xyXG5cdFx0dmFyIHZhbHVlT3JpZW50YXRpb25DbGFzc2VzID0gW1xyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMudmFsdWVIb3Jpem9udGFsLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMudmFsdWVWZXJ0aWNhbFxyXG5cdFx0XTtcclxuXHRcdHZhciBtYXJrZXJPcmllbnRhdGlvbkNsYXNzZXMgPSBbXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy5tYXJrZXJIb3Jpem9udGFsLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyVmVydGljYWxcclxuXHRcdF07XHJcblxyXG5cdFx0YWRkQ2xhc3MoZWxlbWVudCwgb3B0aW9ucy5jc3NDbGFzc2VzLnBpcHMpO1xyXG5cdFx0YWRkQ2xhc3MoZWxlbWVudCwgb3B0aW9ucy5vcnQgPT09IDAgPyBvcHRpb25zLmNzc0NsYXNzZXMucGlwc0hvcml6b250YWwgOiBvcHRpb25zLmNzc0NsYXNzZXMucGlwc1ZlcnRpY2FsKTtcclxuXHJcblx0XHRmdW5jdGlvbiBnZXRDbGFzc2VzKCB0eXBlLCBzb3VyY2UgKXtcclxuXHRcdFx0dmFyIGEgPSBzb3VyY2UgPT09IG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZTtcclxuXHRcdFx0dmFyIG9yaWVudGF0aW9uQ2xhc3NlcyA9IGEgPyB2YWx1ZU9yaWVudGF0aW9uQ2xhc3NlcyA6IG1hcmtlck9yaWVudGF0aW9uQ2xhc3NlcztcclxuXHRcdFx0dmFyIHNpemVDbGFzc2VzID0gYSA/IHZhbHVlU2l6ZUNsYXNzZXMgOiBtYXJrZXJTaXplQ2xhc3NlcztcclxuXHJcblx0XHRcdHJldHVybiBzb3VyY2UgKyAnICcgKyBvcmllbnRhdGlvbkNsYXNzZXNbb3B0aW9ucy5vcnRdICsgJyAnICsgc2l6ZUNsYXNzZXNbdHlwZV07XHJcblx0XHR9XHJcblxyXG5cdFx0ZnVuY3Rpb24gYWRkU3ByZWFkICggb2Zmc2V0LCB2YWx1ZXMgKXtcclxuXHJcblx0XHRcdC8vIEFwcGx5IHRoZSBmaWx0ZXIgZnVuY3Rpb24sIGlmIGl0IGlzIHNldC5cclxuXHRcdFx0dmFsdWVzWzFdID0gKHZhbHVlc1sxXSAmJiBmaWx0ZXJGdW5jKSA/IGZpbHRlckZ1bmModmFsdWVzWzBdLCB2YWx1ZXNbMV0pIDogdmFsdWVzWzFdO1xyXG5cclxuXHRcdFx0Ly8gQWRkIGEgbWFya2VyIGZvciBldmVyeSBwb2ludFxyXG5cdFx0XHR2YXIgbm9kZSA9IGFkZE5vZGVUbyhlbGVtZW50LCBmYWxzZSk7XHJcblx0XHRcdFx0bm9kZS5jbGFzc05hbWUgPSBnZXRDbGFzc2VzKHZhbHVlc1sxXSwgb3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlcik7XHJcblx0XHRcdFx0bm9kZS5zdHlsZVtvcHRpb25zLnN0eWxlXSA9IG9mZnNldCArICclJztcclxuXHJcblx0XHRcdC8vIFZhbHVlcyBhcmUgb25seSBhcHBlbmRlZCBmb3IgcG9pbnRzIG1hcmtlZCAnMScgb3IgJzInLlxyXG5cdFx0XHRpZiAoIHZhbHVlc1sxXSApIHtcclxuXHRcdFx0XHRub2RlID0gYWRkTm9kZVRvKGVsZW1lbnQsIGZhbHNlKTtcclxuXHRcdFx0XHRub2RlLmNsYXNzTmFtZSA9IGdldENsYXNzZXModmFsdWVzWzFdLCBvcHRpb25zLmNzc0NsYXNzZXMudmFsdWUpO1xyXG5cdFx0XHRcdG5vZGUuc2V0QXR0cmlidXRlKCdkYXRhLXZhbHVlJywgdmFsdWVzWzBdKTtcclxuXHRcdFx0XHRub2RlLnN0eWxlW29wdGlvbnMuc3R5bGVdID0gb2Zmc2V0ICsgJyUnO1xyXG5cdFx0XHRcdG5vZGUuaW5uZXJUZXh0ID0gZm9ybWF0dGVyLnRvKHZhbHVlc1swXSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBBcHBlbmQgYWxsIHBvaW50cy5cclxuXHRcdE9iamVjdC5rZXlzKHNwcmVhZCkuZm9yRWFjaChmdW5jdGlvbihhKXtcclxuXHRcdFx0YWRkU3ByZWFkKGEsIHNwcmVhZFthXSk7XHJcblx0XHR9KTtcclxuXHJcblx0XHRyZXR1cm4gZWxlbWVudDtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIHJlbW92ZVBpcHMgKCApIHtcclxuXHRcdGlmICggc2NvcGVfUGlwcyApIHtcclxuXHRcdFx0cmVtb3ZlRWxlbWVudChzY29wZV9QaXBzKTtcclxuXHRcdFx0c2NvcGVfUGlwcyA9IG51bGw7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRmdW5jdGlvbiBwaXBzICggZ3JpZCApIHtcclxuXHJcblx0XHQvLyBGaXggIzY2OVxyXG5cdFx0cmVtb3ZlUGlwcygpO1xyXG5cclxuXHRcdHZhciBtb2RlID0gZ3JpZC5tb2RlO1xyXG5cdFx0dmFyIGRlbnNpdHkgPSBncmlkLmRlbnNpdHkgfHwgMTtcclxuXHRcdHZhciBmaWx0ZXIgPSBncmlkLmZpbHRlciB8fCBmYWxzZTtcclxuXHRcdHZhciB2YWx1ZXMgPSBncmlkLnZhbHVlcyB8fCBmYWxzZTtcclxuXHRcdHZhciBzdGVwcGVkID0gZ3JpZC5zdGVwcGVkIHx8IGZhbHNlO1xyXG5cdFx0dmFyIGdyb3VwID0gZ2V0R3JvdXAoIG1vZGUsIHZhbHVlcywgc3RlcHBlZCApO1xyXG5cdFx0dmFyIHNwcmVhZCA9IGdlbmVyYXRlU3ByZWFkKCBkZW5zaXR5LCBtb2RlLCBncm91cCApO1xyXG5cdFx0dmFyIGZvcm1hdCA9IGdyaWQuZm9ybWF0IHx8IHtcclxuXHRcdFx0dG86IE1hdGgucm91bmRcclxuXHRcdH07XHJcblxyXG5cdFx0c2NvcGVfUGlwcyA9IHNjb3BlX1RhcmdldC5hcHBlbmRDaGlsZChhZGRNYXJraW5nKFxyXG5cdFx0XHRzcHJlYWQsXHJcblx0XHRcdGZpbHRlcixcclxuXHRcdFx0Zm9ybWF0XHJcblx0XHQpKTtcclxuXHJcblx0XHRyZXR1cm4gc2NvcGVfUGlwcztcclxuXHR9XHJcblxyXG4vKiEgSW4gdGhpcyBmaWxlOiBCcm93c2VyIGV2ZW50cyAobm90IHNsaWRlciBldmVudHMgbGlrZSBzbGlkZSwgY2hhbmdlKTsgKi9cclxuXHJcblx0Ly8gU2hvcnRoYW5kIGZvciBiYXNlIGRpbWVuc2lvbnMuXHJcblx0ZnVuY3Rpb24gYmFzZVNpemUgKCApIHtcclxuXHRcdHZhciByZWN0ID0gc2NvcGVfQmFzZS5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTtcclxuXHRcdHZhciBhbHQgPSAnb2Zmc2V0JyArIFsnV2lkdGgnLCAnSGVpZ2h0J11bb3B0aW9ucy5vcnRdO1xyXG5cdFx0cmV0dXJuIG9wdGlvbnMub3J0ID09PSAwID8gKHJlY3Qud2lkdGh8fHNjb3BlX0Jhc2VbYWx0XSkgOiAocmVjdC5oZWlnaHR8fHNjb3BlX0Jhc2VbYWx0XSk7XHJcblx0fVxyXG5cclxuXHQvLyBIYW5kbGVyIGZvciBhdHRhY2hpbmcgZXZlbnRzIHRyb3VnaCBhIHByb3h5LlxyXG5cdGZ1bmN0aW9uIGF0dGFjaEV2ZW50ICggZXZlbnRzLCBlbGVtZW50LCBjYWxsYmFjaywgZGF0YSApIHtcclxuXHJcblx0XHQvLyBUaGlzIGZ1bmN0aW9uIGNhbiBiZSB1c2VkIHRvICdmaWx0ZXInIGV2ZW50cyB0byB0aGUgc2xpZGVyLlxyXG5cdFx0Ly8gZWxlbWVudCBpcyBhIG5vZGUsIG5vdCBhIG5vZGVMaXN0XHJcblxyXG5cdFx0dmFyIG1ldGhvZCA9IGZ1bmN0aW9uICggZSApe1xyXG5cclxuXHRcdFx0ZSA9IGZpeEV2ZW50KGUsIGRhdGEucGFnZU9mZnNldCwgZGF0YS50YXJnZXQgfHwgZWxlbWVudCk7XHJcblxyXG5cdFx0XHQvLyBmaXhFdmVudCByZXR1cm5zIGZhbHNlIGlmIHRoaXMgZXZlbnQgaGFzIGEgZGlmZmVyZW50IHRhcmdldFxyXG5cdFx0XHQvLyB3aGVuIGhhbmRsaW5nIChtdWx0aS0pIHRvdWNoIGV2ZW50cztcclxuXHRcdFx0aWYgKCAhZSApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIGRvTm90UmVqZWN0IGlzIHBhc3NlZCBieSBhbGwgZW5kIGV2ZW50cyB0byBtYWtlIHN1cmUgcmVsZWFzZWQgdG91Y2hlc1xyXG5cdFx0XHQvLyBhcmUgbm90IHJlamVjdGVkLCBsZWF2aW5nIHRoZSBzbGlkZXIgXCJzdHVja1wiIHRvIHRoZSBjdXJzb3I7XHJcblx0XHRcdGlmICggc2NvcGVfVGFyZ2V0Lmhhc0F0dHJpYnV0ZSgnZGlzYWJsZWQnKSAmJiAhZGF0YS5kb05vdFJlamVjdCApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIFN0b3AgaWYgYW4gYWN0aXZlICd0YXAnIHRyYW5zaXRpb24gaXMgdGFraW5nIHBsYWNlLlxyXG5cdFx0XHRpZiAoIGhhc0NsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLnRhcCkgJiYgIWRhdGEuZG9Ob3RSZWplY3QgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBJZ25vcmUgcmlnaHQgb3IgbWlkZGxlIGNsaWNrcyBvbiBzdGFydCAjNDU0XHJcblx0XHRcdGlmICggZXZlbnRzID09PSBhY3Rpb25zLnN0YXJ0ICYmIGUuYnV0dG9ucyAhPT0gdW5kZWZpbmVkICYmIGUuYnV0dG9ucyA+IDEgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBJZ25vcmUgcmlnaHQgb3IgbWlkZGxlIGNsaWNrcyBvbiBzdGFydCAjNDU0XHJcblx0XHRcdGlmICggZGF0YS5ob3ZlciAmJiBlLmJ1dHRvbnMgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyAnc3VwcG9ydHNQYXNzaXZlJyBpcyBvbmx5IHRydWUgaWYgYSBicm93c2VyIGFsc28gc3VwcG9ydHMgdG91Y2gtYWN0aW9uOiBub25lIGluIENTUy5cclxuXHRcdFx0Ly8gaU9TIHNhZmFyaSBkb2VzIG5vdCwgc28gaXQgZG9lc24ndCBnZXQgdG8gYmVuZWZpdCBmcm9tIHBhc3NpdmUgc2Nyb2xsaW5nLiBpT1MgZG9lcyBzdXBwb3J0XHJcblx0XHRcdC8vIHRvdWNoLWFjdGlvbjogbWFuaXB1bGF0aW9uLCBidXQgdGhhdCBhbGxvd3MgcGFubmluZywgd2hpY2ggYnJlYWtzXHJcblx0XHRcdC8vIHNsaWRlcnMgYWZ0ZXIgem9vbWluZy9vbiBub24tcmVzcG9uc2l2ZSBwYWdlcy5cclxuXHRcdFx0Ly8gU2VlOiBodHRwczovL2J1Z3Mud2Via2l0Lm9yZy9zaG93X2J1Zy5jZ2k/aWQ9MTMzMTEyXHJcblx0XHRcdGlmICggIXN1cHBvcnRzUGFzc2l2ZSApIHtcclxuXHRcdFx0XHRlLnByZXZlbnREZWZhdWx0KCk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGUuY2FsY1BvaW50ID0gZS5wb2ludHNbIG9wdGlvbnMub3J0IF07XHJcblxyXG5cdFx0XHQvLyBDYWxsIHRoZSBldmVudCBoYW5kbGVyIHdpdGggdGhlIGV2ZW50IFsgYW5kIGFkZGl0aW9uYWwgZGF0YSBdLlxyXG5cdFx0XHRjYWxsYmFjayAoIGUsIGRhdGEgKTtcclxuXHRcdH07XHJcblxyXG5cdFx0dmFyIG1ldGhvZHMgPSBbXTtcclxuXHJcblx0XHQvLyBCaW5kIGEgY2xvc3VyZSBvbiB0aGUgdGFyZ2V0IGZvciBldmVyeSBldmVudCB0eXBlLlxyXG5cdFx0ZXZlbnRzLnNwbGl0KCcgJykuZm9yRWFjaChmdW5jdGlvbiggZXZlbnROYW1lICl7XHJcblx0XHRcdGVsZW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihldmVudE5hbWUsIG1ldGhvZCwgc3VwcG9ydHNQYXNzaXZlID8geyBwYXNzaXZlOiB0cnVlIH0gOiBmYWxzZSk7XHJcblx0XHRcdG1ldGhvZHMucHVzaChbZXZlbnROYW1lLCBtZXRob2RdKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdHJldHVybiBtZXRob2RzO1xyXG5cdH1cclxuXHJcblx0Ly8gUHJvdmlkZSBhIGNsZWFuIGV2ZW50IHdpdGggc3RhbmRhcmRpemVkIG9mZnNldCB2YWx1ZXMuXHJcblx0ZnVuY3Rpb24gZml4RXZlbnQgKCBlLCBwYWdlT2Zmc2V0LCBldmVudFRhcmdldCApIHtcclxuXHJcblx0XHQvLyBGaWx0ZXIgdGhlIGV2ZW50IHRvIHJlZ2lzdGVyIHRoZSB0eXBlLCB3aGljaCBjYW4gYmVcclxuXHRcdC8vIHRvdWNoLCBtb3VzZSBvciBwb2ludGVyLiBPZmZzZXQgY2hhbmdlcyBuZWVkIHRvIGJlXHJcblx0XHQvLyBtYWRlIG9uIGFuIGV2ZW50IHNwZWNpZmljIGJhc2lzLlxyXG5cdFx0dmFyIHRvdWNoID0gZS50eXBlLmluZGV4T2YoJ3RvdWNoJykgPT09IDA7XHJcblx0XHR2YXIgbW91c2UgPSBlLnR5cGUuaW5kZXhPZignbW91c2UnKSA9PT0gMDtcclxuXHRcdHZhciBwb2ludGVyID0gZS50eXBlLmluZGV4T2YoJ3BvaW50ZXInKSA9PT0gMDtcclxuXHJcblx0XHR2YXIgeDtcclxuXHRcdHZhciB5O1xyXG5cclxuXHRcdC8vIElFMTAgaW1wbGVtZW50ZWQgcG9pbnRlciBldmVudHMgd2l0aCBhIHByZWZpeDtcclxuXHRcdGlmICggZS50eXBlLmluZGV4T2YoJ01TUG9pbnRlcicpID09PSAwICkge1xyXG5cdFx0XHRwb2ludGVyID0gdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJbiB0aGUgZXZlbnQgdGhhdCBtdWx0aXRvdWNoIGlzIGFjdGl2YXRlZCwgdGhlIG9ubHkgdGhpbmcgb25lIGhhbmRsZSBzaG91bGQgYmUgY29uY2VybmVkXHJcblx0XHQvLyBhYm91dCBpcyB0aGUgdG91Y2hlcyB0aGF0IG9yaWdpbmF0ZWQgb24gdG9wIG9mIGl0LlxyXG5cdFx0aWYgKCB0b3VjaCApIHtcclxuXHJcblx0XHRcdC8vIFJldHVybnMgdHJ1ZSBpZiBhIHRvdWNoIG9yaWdpbmF0ZWQgb24gdGhlIHRhcmdldC5cclxuXHRcdFx0dmFyIGlzVG91Y2hPblRhcmdldCA9IGZ1bmN0aW9uIChjaGVja1RvdWNoKSB7XHJcblx0XHRcdFx0cmV0dXJuIGNoZWNrVG91Y2gudGFyZ2V0ID09PSBldmVudFRhcmdldCB8fCBldmVudFRhcmdldC5jb250YWlucyhjaGVja1RvdWNoLnRhcmdldCk7XHJcblx0XHRcdH07XHJcblxyXG5cdFx0XHQvLyBJbiB0aGUgY2FzZSBvZiB0b3VjaHN0YXJ0IGV2ZW50cywgd2UgbmVlZCB0byBtYWtlIHN1cmUgdGhlcmUgaXMgc3RpbGwgbm8gbW9yZSB0aGFuIG9uZVxyXG5cdFx0XHQvLyB0b3VjaCBvbiB0aGUgdGFyZ2V0IHNvIHdlIGxvb2sgYW1vbmdzdCBhbGwgdG91Y2hlcy5cclxuXHRcdFx0aWYgKGUudHlwZSA9PT0gJ3RvdWNoc3RhcnQnKSB7XHJcblxyXG5cdFx0XHRcdHZhciB0YXJnZXRUb3VjaGVzID0gQXJyYXkucHJvdG90eXBlLmZpbHRlci5jYWxsKGUudG91Y2hlcywgaXNUb3VjaE9uVGFyZ2V0KTtcclxuXHJcblx0XHRcdFx0Ly8gRG8gbm90IHN1cHBvcnQgbW9yZSB0aGFuIG9uZSB0b3VjaCBwZXIgaGFuZGxlLlxyXG5cdFx0XHRcdGlmICggdGFyZ2V0VG91Y2hlcy5sZW5ndGggPiAxICkge1xyXG5cdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0eCA9IHRhcmdldFRvdWNoZXNbMF0ucGFnZVg7XHJcblx0XHRcdFx0eSA9IHRhcmdldFRvdWNoZXNbMF0ucGFnZVk7XHJcblxyXG5cdFx0XHR9IGVsc2Uge1xyXG5cclxuXHRcdFx0XHQvLyBJbiB0aGUgb3RoZXIgY2FzZXMsIGZpbmQgb24gY2hhbmdlZFRvdWNoZXMgaXMgZW5vdWdoLlxyXG5cdFx0XHRcdHZhciB0YXJnZXRUb3VjaCA9IEFycmF5LnByb3RvdHlwZS5maW5kLmNhbGwoZS5jaGFuZ2VkVG91Y2hlcywgaXNUb3VjaE9uVGFyZ2V0KTtcclxuXHJcblx0XHRcdFx0Ly8gQ2FuY2VsIGlmIHRoZSB0YXJnZXQgdG91Y2ggaGFzIG5vdCBtb3ZlZC5cclxuXHRcdFx0XHRpZiAoICF0YXJnZXRUb3VjaCApIHtcclxuXHRcdFx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdHggPSB0YXJnZXRUb3VjaC5wYWdlWDtcclxuXHRcdFx0XHR5ID0gdGFyZ2V0VG91Y2gucGFnZVk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRwYWdlT2Zmc2V0ID0gcGFnZU9mZnNldCB8fCBnZXRQYWdlT2Zmc2V0KHNjb3BlX0RvY3VtZW50KTtcclxuXHJcblx0XHRpZiAoIG1vdXNlIHx8IHBvaW50ZXIgKSB7XHJcblx0XHRcdHggPSBlLmNsaWVudFggKyBwYWdlT2Zmc2V0Lng7XHJcblx0XHRcdHkgPSBlLmNsaWVudFkgKyBwYWdlT2Zmc2V0Lnk7XHJcblx0XHR9XHJcblxyXG5cdFx0ZS5wYWdlT2Zmc2V0ID0gcGFnZU9mZnNldDtcclxuXHRcdGUucG9pbnRzID0gW3gsIHldO1xyXG5cdFx0ZS5jdXJzb3IgPSBtb3VzZSB8fCBwb2ludGVyOyAvLyBGaXggIzQzNVxyXG5cclxuXHRcdHJldHVybiBlO1xyXG5cdH1cclxuXHJcblx0Ly8gVHJhbnNsYXRlIGEgY29vcmRpbmF0ZSBpbiB0aGUgZG9jdW1lbnQgdG8gYSBwZXJjZW50YWdlIG9uIHRoZSBzbGlkZXJcclxuXHRmdW5jdGlvbiBjYWxjUG9pbnRUb1BlcmNlbnRhZ2UgKCBjYWxjUG9pbnQgKSB7XHJcblx0XHR2YXIgbG9jYXRpb24gPSBjYWxjUG9pbnQgLSBvZmZzZXQoc2NvcGVfQmFzZSwgb3B0aW9ucy5vcnQpO1xyXG5cdFx0dmFyIHByb3Bvc2FsID0gKCBsb2NhdGlvbiAqIDEwMCApIC8gYmFzZVNpemUoKTtcclxuXHJcblx0XHQvLyBDbGFtcCBwcm9wb3NhbCBiZXR3ZWVuIDAlIGFuZCAxMDAlXHJcblx0XHQvLyBPdXQtb2YtYm91bmQgY29vcmRpbmF0ZXMgbWF5IG9jY3VyIHdoZW4gLm5vVWktYmFzZSBwc2V1ZG8tZWxlbWVudHNcclxuXHRcdC8vIGFyZSB1c2VkIChlLmcuIGNvbnRhaW5lZCBoYW5kbGVzIGZlYXR1cmUpXHJcblx0XHRwcm9wb3NhbCA9IGxpbWl0KHByb3Bvc2FsKTtcclxuXHJcblx0XHRyZXR1cm4gb3B0aW9ucy5kaXIgPyAxMDAgLSBwcm9wb3NhbCA6IHByb3Bvc2FsO1xyXG5cdH1cclxuXHJcblx0Ly8gRmluZCBoYW5kbGUgY2xvc2VzdCB0byBhIGNlcnRhaW4gcGVyY2VudGFnZSBvbiB0aGUgc2xpZGVyXHJcblx0ZnVuY3Rpb24gZ2V0Q2xvc2VzdEhhbmRsZSAoIHByb3Bvc2FsICkge1xyXG5cclxuXHRcdHZhciBjbG9zZXN0ID0gMTAwO1xyXG5cdFx0dmFyIGhhbmRsZU51bWJlciA9IGZhbHNlO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZXMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGUsIGluZGV4KXtcclxuXHJcblx0XHRcdC8vIERpc2FibGVkIGhhbmRsZXMgYXJlIGlnbm9yZWRcclxuXHRcdFx0aWYgKCBoYW5kbGUuaGFzQXR0cmlidXRlKCdkaXNhYmxlZCcpICkge1xyXG5cdFx0XHRcdHJldHVybjtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0dmFyIHBvcyA9IE1hdGguYWJzKHNjb3BlX0xvY2F0aW9uc1tpbmRleF0gLSBwcm9wb3NhbCk7XHJcblxyXG5cdFx0XHRpZiAoIHBvcyA8IGNsb3Nlc3QgfHwgKHBvcyA9PT0gMTAwICYmIGNsb3Nlc3QgPT09IDEwMCkgKSB7XHJcblx0XHRcdFx0aGFuZGxlTnVtYmVyID0gaW5kZXg7XHJcblx0XHRcdFx0Y2xvc2VzdCA9IHBvcztcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0cmV0dXJuIGhhbmRsZU51bWJlcjtcclxuXHR9XHJcblxyXG5cdC8vIEZpcmUgJ2VuZCcgd2hlbiBhIG1vdXNlIG9yIHBlbiBsZWF2ZXMgdGhlIGRvY3VtZW50LlxyXG5cdGZ1bmN0aW9uIGRvY3VtZW50TGVhdmUgKCBldmVudCwgZGF0YSApIHtcclxuXHRcdGlmICggZXZlbnQudHlwZSA9PT0gXCJtb3VzZW91dFwiICYmIGV2ZW50LnRhcmdldC5ub2RlTmFtZSA9PT0gXCJIVE1MXCIgJiYgZXZlbnQucmVsYXRlZFRhcmdldCA9PT0gbnVsbCApe1xyXG5cdFx0XHRldmVudEVuZCAoZXZlbnQsIGRhdGEpO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0Ly8gSGFuZGxlIG1vdmVtZW50IG9uIGRvY3VtZW50IGZvciBoYW5kbGUgYW5kIHJhbmdlIGRyYWcuXHJcblx0ZnVuY3Rpb24gZXZlbnRNb3ZlICggZXZlbnQsIGRhdGEgKSB7XHJcblxyXG5cdFx0Ly8gRml4ICM0OThcclxuXHRcdC8vIENoZWNrIHZhbHVlIG9mIC5idXR0b25zIGluICdzdGFydCcgdG8gd29yayBhcm91bmQgYSBidWcgaW4gSUUxMCBtb2JpbGUgKGRhdGEuYnV0dG9uc1Byb3BlcnR5KS5cclxuXHRcdC8vIGh0dHBzOi8vY29ubmVjdC5taWNyb3NvZnQuY29tL0lFL2ZlZWRiYWNrL2RldGFpbHMvOTI3MDA1L21vYmlsZS1pZTEwLXdpbmRvd3MtcGhvbmUtYnV0dG9ucy1wcm9wZXJ0eS1vZi1wb2ludGVybW92ZS1ldmVudC1hbHdheXMtemVyb1xyXG5cdFx0Ly8gSUU5IGhhcyAuYnV0dG9ucyBhbmQgLndoaWNoIHplcm8gb24gbW91c2Vtb3ZlLlxyXG5cdFx0Ly8gRmlyZWZveCBicmVha3MgdGhlIHNwZWMgTUROIGRlZmluZXMuXHJcblx0XHRpZiAoIG5hdmlnYXRvci5hcHBWZXJzaW9uLmluZGV4T2YoXCJNU0lFIDlcIikgPT09IC0xICYmIGV2ZW50LmJ1dHRvbnMgPT09IDAgJiYgZGF0YS5idXR0b25zUHJvcGVydHkgIT09IDAgKSB7XHJcblx0XHRcdHJldHVybiBldmVudEVuZChldmVudCwgZGF0YSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQ2hlY2sgaWYgd2UgYXJlIG1vdmluZyB1cCBvciBkb3duXHJcblx0XHR2YXIgbW92ZW1lbnQgPSAob3B0aW9ucy5kaXIgPyAtMSA6IDEpICogKGV2ZW50LmNhbGNQb2ludCAtIGRhdGEuc3RhcnRDYWxjUG9pbnQpO1xyXG5cclxuXHRcdC8vIENvbnZlcnQgdGhlIG1vdmVtZW50IGludG8gYSBwZXJjZW50YWdlIG9mIHRoZSBzbGlkZXIgd2lkdGgvaGVpZ2h0XHJcblx0XHR2YXIgcHJvcG9zYWwgPSAobW92ZW1lbnQgKiAxMDApIC8gZGF0YS5iYXNlU2l6ZTtcclxuXHJcblx0XHRtb3ZlSGFuZGxlcyhtb3ZlbWVudCA+IDAsIHByb3Bvc2FsLCBkYXRhLmxvY2F0aW9ucywgZGF0YS5oYW5kbGVOdW1iZXJzKTtcclxuXHR9XHJcblxyXG5cdC8vIFVuYmluZCBtb3ZlIGV2ZW50cyBvbiBkb2N1bWVudCwgY2FsbCBjYWxsYmFja3MuXHJcblx0ZnVuY3Rpb24gZXZlbnRFbmQgKCBldmVudCwgZGF0YSApIHtcclxuXHJcblx0XHQvLyBUaGUgaGFuZGxlIGlzIG5vIGxvbmdlciBhY3RpdmUsIHNvIHJlbW92ZSB0aGUgY2xhc3MuXHJcblx0XHRpZiAoIGRhdGEuaGFuZGxlICkge1xyXG5cdFx0XHRyZW1vdmVDbGFzcyhkYXRhLmhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmFjdGl2ZSk7XHJcblx0XHRcdHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCAtPSAxO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFVuYmluZCB0aGUgbW92ZSBhbmQgZW5kIGV2ZW50cywgd2hpY2ggYXJlIGFkZGVkIG9uICdzdGFydCcuXHJcblx0XHRkYXRhLmxpc3RlbmVycy5mb3JFYWNoKGZ1bmN0aW9uKCBjICkge1xyXG5cdFx0XHRzY29wZV9Eb2N1bWVudEVsZW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcihjWzBdLCBjWzFdKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdGlmICggc2NvcGVfQWN0aXZlSGFuZGxlc0NvdW50ID09PSAwICkge1xyXG5cdFx0XHQvLyBSZW1vdmUgZHJhZ2dpbmcgY2xhc3MuXHJcblx0XHRcdHJlbW92ZUNsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmRyYWcpO1xyXG5cdFx0XHRzZXRaaW5kZXgoKTtcclxuXHJcblx0XHRcdC8vIFJlbW92ZSBjdXJzb3Igc3R5bGVzIGFuZCB0ZXh0LXNlbGVjdGlvbiBldmVudHMgYm91bmQgdG8gdGhlIGJvZHkuXHJcblx0XHRcdGlmICggZXZlbnQuY3Vyc29yICkge1xyXG5cdFx0XHRcdHNjb3BlX0JvZHkuc3R5bGUuY3Vyc29yID0gJyc7XHJcblx0XHRcdFx0c2NvcGVfQm9keS5yZW1vdmVFdmVudExpc3RlbmVyKCdzZWxlY3RzdGFydCcsIHByZXZlbnREZWZhdWx0KTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdGRhdGEuaGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdGZpcmVFdmVudCgnY2hhbmdlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0ZmlyZUV2ZW50KCdzZXQnLCBoYW5kbGVOdW1iZXIpO1xyXG5cdFx0XHRmaXJlRXZlbnQoJ2VuZCcsIGhhbmRsZU51bWJlcik7XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cdC8vIEJpbmQgbW92ZSBldmVudHMgb24gZG9jdW1lbnQuXHJcblx0ZnVuY3Rpb24gZXZlbnRTdGFydCAoIGV2ZW50LCBkYXRhICkge1xyXG5cclxuXHRcdHZhciBoYW5kbGU7XHJcblx0XHRpZiAoIGRhdGEuaGFuZGxlTnVtYmVycy5sZW5ndGggPT09IDEgKSB7XHJcblxyXG5cdFx0XHR2YXIgaGFuZGxlT3JpZ2luID0gc2NvcGVfSGFuZGxlc1tkYXRhLmhhbmRsZU51bWJlcnNbMF1dO1xyXG5cclxuXHRcdFx0Ly8gSWdub3JlICdkaXNhYmxlZCcgaGFuZGxlc1xyXG5cdFx0XHRpZiAoIGhhbmRsZU9yaWdpbi5oYXNBdHRyaWJ1dGUoJ2Rpc2FibGVkJykgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRoYW5kbGUgPSBoYW5kbGVPcmlnaW4uY2hpbGRyZW5bMF07XHJcblx0XHRcdHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCArPSAxO1xyXG5cclxuXHRcdFx0Ly8gTWFyayB0aGUgaGFuZGxlIGFzICdhY3RpdmUnIHNvIGl0IGNhbiBiZSBzdHlsZWQuXHJcblx0XHRcdGFkZENsYXNzKGhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmFjdGl2ZSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQSBkcmFnIHNob3VsZCBuZXZlciBwcm9wYWdhdGUgdXAgdG8gdGhlICd0YXAnIGV2ZW50LlxyXG5cdFx0ZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XHJcblxyXG5cdFx0Ly8gUmVjb3JkIHRoZSBldmVudCBsaXN0ZW5lcnMuXHJcblx0XHR2YXIgbGlzdGVuZXJzID0gW107XHJcblxyXG5cdFx0Ly8gQXR0YWNoIHRoZSBtb3ZlIGFuZCBlbmQgZXZlbnRzLlxyXG5cdFx0dmFyIG1vdmVFdmVudCA9IGF0dGFjaEV2ZW50KGFjdGlvbnMubW92ZSwgc2NvcGVfRG9jdW1lbnRFbGVtZW50LCBldmVudE1vdmUsIHtcclxuXHRcdFx0Ly8gVGhlIGV2ZW50IHRhcmdldCBoYXMgY2hhbmdlZCBzbyB3ZSBuZWVkIHRvIHByb3BhZ2F0ZSB0aGUgb3JpZ2luYWwgb25lIHNvIHRoYXQgd2Uga2VlcFxyXG5cdFx0XHQvLyByZWx5aW5nIG9uIGl0IHRvIGV4dHJhY3QgdGFyZ2V0IHRvdWNoZXMuXHJcblx0XHRcdHRhcmdldDogZXZlbnQudGFyZ2V0LFxyXG5cdFx0XHRoYW5kbGU6IGhhbmRsZSxcclxuXHRcdFx0bGlzdGVuZXJzOiBsaXN0ZW5lcnMsXHJcblx0XHRcdHN0YXJ0Q2FsY1BvaW50OiBldmVudC5jYWxjUG9pbnQsXHJcblx0XHRcdGJhc2VTaXplOiBiYXNlU2l6ZSgpLFxyXG5cdFx0XHRwYWdlT2Zmc2V0OiBldmVudC5wYWdlT2Zmc2V0LFxyXG5cdFx0XHRoYW5kbGVOdW1iZXJzOiBkYXRhLmhhbmRsZU51bWJlcnMsXHJcblx0XHRcdGJ1dHRvbnNQcm9wZXJ0eTogZXZlbnQuYnV0dG9ucyxcclxuXHRcdFx0bG9jYXRpb25zOiBzY29wZV9Mb2NhdGlvbnMuc2xpY2UoKVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0dmFyIGVuZEV2ZW50ID0gYXR0YWNoRXZlbnQoYWN0aW9ucy5lbmQsIHNjb3BlX0RvY3VtZW50RWxlbWVudCwgZXZlbnRFbmQsIHtcclxuXHRcdFx0dGFyZ2V0OiBldmVudC50YXJnZXQsXHJcblx0XHRcdGhhbmRsZTogaGFuZGxlLFxyXG5cdFx0XHRsaXN0ZW5lcnM6IGxpc3RlbmVycyxcclxuXHRcdFx0ZG9Ob3RSZWplY3Q6IHRydWUsXHJcblx0XHRcdGhhbmRsZU51bWJlcnM6IGRhdGEuaGFuZGxlTnVtYmVyc1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0dmFyIG91dEV2ZW50ID0gYXR0YWNoRXZlbnQoXCJtb3VzZW91dFwiLCBzY29wZV9Eb2N1bWVudEVsZW1lbnQsIGRvY3VtZW50TGVhdmUsIHtcclxuXHRcdFx0dGFyZ2V0OiBldmVudC50YXJnZXQsXHJcblx0XHRcdGhhbmRsZTogaGFuZGxlLFxyXG5cdFx0XHRsaXN0ZW5lcnM6IGxpc3RlbmVycyxcclxuXHRcdFx0ZG9Ob3RSZWplY3Q6IHRydWUsXHJcblx0XHRcdGhhbmRsZU51bWJlcnM6IGRhdGEuaGFuZGxlTnVtYmVyc1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gV2Ugd2FudCB0byBtYWtlIHN1cmUgd2UgcHVzaGVkIHRoZSBsaXN0ZW5lcnMgaW4gdGhlIGxpc3RlbmVyIGxpc3QgcmF0aGVyIHRoYW4gY3JlYXRpbmdcclxuXHRcdC8vIGEgbmV3IG9uZSBhcyBpdCBoYXMgYWxyZWFkeSBiZWVuIHBhc3NlZCB0byB0aGUgZXZlbnQgaGFuZGxlcnMuXHJcblx0XHRsaXN0ZW5lcnMucHVzaC5hcHBseShsaXN0ZW5lcnMsIG1vdmVFdmVudC5jb25jYXQoZW5kRXZlbnQsIG91dEV2ZW50KSk7XHJcblxyXG5cdFx0Ly8gVGV4dCBzZWxlY3Rpb24gaXNuJ3QgYW4gaXNzdWUgb24gdG91Y2ggZGV2aWNlcyxcclxuXHRcdC8vIHNvIGFkZGluZyBjdXJzb3Igc3R5bGVzIGNhbiBiZSBza2lwcGVkLlxyXG5cdFx0aWYgKCBldmVudC5jdXJzb3IgKSB7XHJcblxyXG5cdFx0XHQvLyBQcmV2ZW50IHRoZSAnSScgY3Vyc29yIGFuZCBleHRlbmQgdGhlIHJhbmdlLWRyYWcgY3Vyc29yLlxyXG5cdFx0XHRzY29wZV9Cb2R5LnN0eWxlLmN1cnNvciA9IGdldENvbXB1dGVkU3R5bGUoZXZlbnQudGFyZ2V0KS5jdXJzb3I7XHJcblxyXG5cdFx0XHQvLyBNYXJrIHRoZSB0YXJnZXQgd2l0aCBhIGRyYWdnaW5nIHN0YXRlLlxyXG5cdFx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSApIHtcclxuXHRcdFx0XHRhZGRDbGFzcyhzY29wZV9UYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5kcmFnKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gUHJldmVudCB0ZXh0IHNlbGVjdGlvbiB3aGVuIGRyYWdnaW5nIHRoZSBoYW5kbGVzLlxyXG5cdFx0XHQvLyBJbiBub1VpU2xpZGVyIDw9IDkuMi4wLCB0aGlzIHdhcyBoYW5kbGVkIGJ5IGNhbGxpbmcgcHJldmVudERlZmF1bHQgb24gbW91c2UvdG91Y2ggc3RhcnQvbW92ZSxcclxuXHRcdFx0Ly8gd2hpY2ggaXMgc2Nyb2xsIGJsb2NraW5nLiBUaGUgc2VsZWN0c3RhcnQgZXZlbnQgaXMgc3VwcG9ydGVkIGJ5IEZpcmVGb3ggc3RhcnRpbmcgZnJvbSB2ZXJzaW9uIDUyLFxyXG5cdFx0XHQvLyBtZWFuaW5nIHRoZSBvbmx5IGhvbGRvdXQgaXMgaU9TIFNhZmFyaS4gVGhpcyBkb2Vzbid0IG1hdHRlcjogdGV4dCBzZWxlY3Rpb24gaXNuJ3QgdHJpZ2dlcmVkIHRoZXJlLlxyXG5cdFx0XHQvLyBUaGUgJ2N1cnNvcicgZmxhZyBpcyBmYWxzZS5cclxuXHRcdFx0Ly8gU2VlOiBodHRwOi8vY2FuaXVzZS5jb20vI3NlYXJjaD1zZWxlY3RzdGFydFxyXG5cdFx0XHRzY29wZV9Cb2R5LmFkZEV2ZW50TGlzdGVuZXIoJ3NlbGVjdHN0YXJ0JywgcHJldmVudERlZmF1bHQsIGZhbHNlKTtcclxuXHRcdH1cclxuXHJcblx0XHRkYXRhLmhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRmaXJlRXZlbnQoJ3N0YXJ0JywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gTW92ZSBjbG9zZXN0IGhhbmRsZSB0byB0YXBwZWQgbG9jYXRpb24uXHJcblx0ZnVuY3Rpb24gZXZlbnRUYXAgKCBldmVudCApIHtcclxuXHJcblx0XHQvLyBUaGUgdGFwIGV2ZW50IHNob3VsZG4ndCBwcm9wYWdhdGUgdXBcclxuXHRcdGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbCA9IGNhbGNQb2ludFRvUGVyY2VudGFnZShldmVudC5jYWxjUG9pbnQpO1xyXG5cdFx0dmFyIGhhbmRsZU51bWJlciA9IGdldENsb3Nlc3RIYW5kbGUocHJvcG9zYWwpO1xyXG5cclxuXHRcdC8vIFRhY2tsZSB0aGUgY2FzZSB0aGF0IGFsbCBoYW5kbGVzIGFyZSAnZGlzYWJsZWQnLlxyXG5cdFx0aWYgKCBoYW5kbGVOdW1iZXIgPT09IGZhbHNlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gRmxhZyB0aGUgc2xpZGVyIGFzIGl0IGlzIG5vdyBpbiBhIHRyYW5zaXRpb25hbCBzdGF0ZS5cclxuXHRcdC8vIFRyYW5zaXRpb24gdGFrZXMgYSBjb25maWd1cmFibGUgYW1vdW50IG9mIG1zIChkZWZhdWx0IDMwMCkuIFJlLWVuYWJsZSB0aGUgc2xpZGVyIGFmdGVyIHRoYXQuXHJcblx0XHRpZiAoICFvcHRpb25zLmV2ZW50cy5zbmFwICkge1xyXG5cdFx0XHRhZGRDbGFzc0ZvcihzY29wZV9UYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50YXAsIG9wdGlvbnMuYW5pbWF0aW9uRHVyYXRpb24pO1xyXG5cdFx0fVxyXG5cclxuXHRcdHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIHByb3Bvc2FsLCB0cnVlLCB0cnVlKTtcclxuXHJcblx0XHRzZXRaaW5kZXgoKTtcclxuXHJcblx0XHRmaXJlRXZlbnQoJ3NsaWRlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgndXBkYXRlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgnY2hhbmdlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgnc2V0JywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHJcblx0XHRpZiAoIG9wdGlvbnMuZXZlbnRzLnNuYXAgKSB7XHJcblx0XHRcdGV2ZW50U3RhcnQoZXZlbnQsIHsgaGFuZGxlTnVtYmVyczogW2hhbmRsZU51bWJlcl0gfSk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQvLyBGaXJlcyBhICdob3ZlcicgZXZlbnQgZm9yIGEgaG92ZXJlZCBtb3VzZS9wZW4gcG9zaXRpb24uXHJcblx0ZnVuY3Rpb24gZXZlbnRIb3ZlciAoIGV2ZW50ICkge1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbCA9IGNhbGNQb2ludFRvUGVyY2VudGFnZShldmVudC5jYWxjUG9pbnQpO1xyXG5cclxuXHRcdHZhciB0byA9IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAocHJvcG9zYWwpO1xyXG5cdFx0dmFyIHZhbHVlID0gc2NvcGVfU3BlY3RydW0uZnJvbVN0ZXBwaW5nKHRvKTtcclxuXHJcblx0XHRPYmplY3Qua2V5cyhzY29wZV9FdmVudHMpLmZvckVhY2goZnVuY3Rpb24oIHRhcmdldEV2ZW50ICkge1xyXG5cdFx0XHRpZiAoICdob3ZlcicgPT09IHRhcmdldEV2ZW50LnNwbGl0KCcuJylbMF0gKSB7XHJcblx0XHRcdFx0c2NvcGVfRXZlbnRzW3RhcmdldEV2ZW50XS5mb3JFYWNoKGZ1bmN0aW9uKCBjYWxsYmFjayApIHtcclxuXHRcdFx0XHRcdGNhbGxiYWNrLmNhbGwoIHNjb3BlX1NlbGYsIHZhbHVlICk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gQXR0YWNoIGV2ZW50cyB0byBzZXZlcmFsIHNsaWRlciBwYXJ0cy5cclxuXHRmdW5jdGlvbiBiaW5kU2xpZGVyRXZlbnRzICggYmVoYXZpb3VyICkge1xyXG5cclxuXHRcdC8vIEF0dGFjaCB0aGUgc3RhbmRhcmQgZHJhZyBldmVudCB0byB0aGUgaGFuZGxlcy5cclxuXHRcdGlmICggIWJlaGF2aW91ci5maXhlZCApIHtcclxuXHJcblx0XHRcdHNjb3BlX0hhbmRsZXMuZm9yRWFjaChmdW5jdGlvbiggaGFuZGxlLCBpbmRleCApe1xyXG5cclxuXHRcdFx0XHQvLyBUaGVzZSBldmVudHMgYXJlIG9ubHkgYm91bmQgdG8gdGhlIHZpc3VhbCBoYW5kbGVcclxuXHRcdFx0XHQvLyBlbGVtZW50LCBub3QgdGhlICdyZWFsJyBvcmlnaW4gZWxlbWVudC5cclxuXHRcdFx0XHRhdHRhY2hFdmVudCAoIGFjdGlvbnMuc3RhcnQsIGhhbmRsZS5jaGlsZHJlblswXSwgZXZlbnRTdGFydCwge1xyXG5cdFx0XHRcdFx0aGFuZGxlTnVtYmVyczogW2luZGV4XVxyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBBdHRhY2ggdGhlIHRhcCBldmVudCB0byB0aGUgc2xpZGVyIGJhc2UuXHJcblx0XHRpZiAoIGJlaGF2aW91ci50YXAgKSB7XHJcblx0XHRcdGF0dGFjaEV2ZW50IChhY3Rpb25zLnN0YXJ0LCBzY29wZV9CYXNlLCBldmVudFRhcCwge30pO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEZpcmUgaG92ZXIgZXZlbnRzXHJcblx0XHRpZiAoIGJlaGF2aW91ci5ob3ZlciApIHtcclxuXHRcdFx0YXR0YWNoRXZlbnQgKGFjdGlvbnMubW92ZSwgc2NvcGVfQmFzZSwgZXZlbnRIb3ZlciwgeyBob3ZlcjogdHJ1ZSB9KTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBNYWtlIHRoZSByYW5nZSBkcmFnZ2FibGUuXHJcblx0XHRpZiAoIGJlaGF2aW91ci5kcmFnICl7XHJcblxyXG5cdFx0XHRzY29wZV9Db25uZWN0cy5mb3JFYWNoKGZ1bmN0aW9uKCBjb25uZWN0LCBpbmRleCApe1xyXG5cclxuXHRcdFx0XHRpZiAoIGNvbm5lY3QgPT09IGZhbHNlIHx8IGluZGV4ID09PSAwIHx8IGluZGV4ID09PSBzY29wZV9Db25uZWN0cy5sZW5ndGggLSAxICkge1xyXG5cdFx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0dmFyIGhhbmRsZUJlZm9yZSA9IHNjb3BlX0hhbmRsZXNbaW5kZXggLSAxXTtcclxuXHRcdFx0XHR2YXIgaGFuZGxlQWZ0ZXIgPSBzY29wZV9IYW5kbGVzW2luZGV4XTtcclxuXHRcdFx0XHR2YXIgZXZlbnRIb2xkZXJzID0gW2Nvbm5lY3RdO1xyXG5cclxuXHRcdFx0XHRhZGRDbGFzcyhjb25uZWN0LCBvcHRpb25zLmNzc0NsYXNzZXMuZHJhZ2dhYmxlKTtcclxuXHJcblx0XHRcdFx0Ly8gV2hlbiB0aGUgcmFuZ2UgaXMgZml4ZWQsIHRoZSBlbnRpcmUgcmFuZ2UgY2FuXHJcblx0XHRcdFx0Ly8gYmUgZHJhZ2dlZCBieSB0aGUgaGFuZGxlcy4gVGhlIGhhbmRsZSBpbiB0aGUgZmlyc3RcclxuXHRcdFx0XHQvLyBvcmlnaW4gd2lsbCBwcm9wYWdhdGUgdGhlIHN0YXJ0IGV2ZW50IHVwd2FyZCxcclxuXHRcdFx0XHQvLyBidXQgaXQgbmVlZHMgdG8gYmUgYm91bmQgbWFudWFsbHkgb24gdGhlIG90aGVyLlxyXG5cdFx0XHRcdGlmICggYmVoYXZpb3VyLmZpeGVkICkge1xyXG5cdFx0XHRcdFx0ZXZlbnRIb2xkZXJzLnB1c2goaGFuZGxlQmVmb3JlLmNoaWxkcmVuWzBdKTtcclxuXHRcdFx0XHRcdGV2ZW50SG9sZGVycy5wdXNoKGhhbmRsZUFmdGVyLmNoaWxkcmVuWzBdKTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdGV2ZW50SG9sZGVycy5mb3JFYWNoKGZ1bmN0aW9uKCBldmVudEhvbGRlciApIHtcclxuXHRcdFx0XHRcdGF0dGFjaEV2ZW50ICggYWN0aW9ucy5zdGFydCwgZXZlbnRIb2xkZXIsIGV2ZW50U3RhcnQsIHtcclxuXHRcdFx0XHRcdFx0aGFuZGxlczogW2hhbmRsZUJlZm9yZSwgaGFuZGxlQWZ0ZXJdLFxyXG5cdFx0XHRcdFx0XHRoYW5kbGVOdW1iZXJzOiBbaW5kZXggLSAxLCBpbmRleF1cclxuXHRcdFx0XHRcdH0pO1xyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG4vKiEgSW4gdGhpcyBmaWxlOiBTbGlkZXIgZXZlbnRzIChub3QgYnJvd3NlciBldmVudHMpOyAqL1xyXG5cclxuXHQvLyBBdHRhY2ggYW4gZXZlbnQgdG8gdGhpcyBzbGlkZXIsIHBvc3NpYmx5IGluY2x1ZGluZyBhIG5hbWVzcGFjZVxyXG5cdGZ1bmN0aW9uIGJpbmRFdmVudCAoIG5hbWVzcGFjZWRFdmVudCwgY2FsbGJhY2sgKSB7XHJcblx0XHRzY29wZV9FdmVudHNbbmFtZXNwYWNlZEV2ZW50XSA9IHNjb3BlX0V2ZW50c1tuYW1lc3BhY2VkRXZlbnRdIHx8IFtdO1xyXG5cdFx0c2NvcGVfRXZlbnRzW25hbWVzcGFjZWRFdmVudF0ucHVzaChjYWxsYmFjayk7XHJcblxyXG5cdFx0Ly8gSWYgdGhlIGV2ZW50IGJvdW5kIGlzICd1cGRhdGUsJyBmaXJlIGl0IGltbWVkaWF0ZWx5IGZvciBhbGwgaGFuZGxlcy5cclxuXHRcdGlmICggbmFtZXNwYWNlZEV2ZW50LnNwbGl0KCcuJylbMF0gPT09ICd1cGRhdGUnICkge1xyXG5cdFx0XHRzY29wZV9IYW5kbGVzLmZvckVhY2goZnVuY3Rpb24oYSwgaW5kZXgpe1xyXG5cdFx0XHRcdGZpcmVFdmVudCgndXBkYXRlJywgaW5kZXgpO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8vIFVuZG8gYXR0YWNobWVudCBvZiBldmVudFxyXG5cdGZ1bmN0aW9uIHJlbW92ZUV2ZW50ICggbmFtZXNwYWNlZEV2ZW50ICkge1xyXG5cclxuXHRcdHZhciBldmVudCA9IG5hbWVzcGFjZWRFdmVudCAmJiBuYW1lc3BhY2VkRXZlbnQuc3BsaXQoJy4nKVswXTtcclxuXHRcdHZhciBuYW1lc3BhY2UgPSBldmVudCAmJiBuYW1lc3BhY2VkRXZlbnQuc3Vic3RyaW5nKGV2ZW50Lmxlbmd0aCk7XHJcblxyXG5cdFx0T2JqZWN0LmtleXMoc2NvcGVfRXZlbnRzKS5mb3JFYWNoKGZ1bmN0aW9uKCBiaW5kICl7XHJcblxyXG5cdFx0XHR2YXIgdEV2ZW50ID0gYmluZC5zcGxpdCgnLicpWzBdO1xyXG5cdFx0XHR2YXIgdE5hbWVzcGFjZSA9IGJpbmQuc3Vic3RyaW5nKHRFdmVudC5sZW5ndGgpO1xyXG5cclxuXHRcdFx0aWYgKCAoIWV2ZW50IHx8IGV2ZW50ID09PSB0RXZlbnQpICYmICghbmFtZXNwYWNlIHx8IG5hbWVzcGFjZSA9PT0gdE5hbWVzcGFjZSkgKSB7XHJcblx0XHRcdFx0ZGVsZXRlIHNjb3BlX0V2ZW50c1tiaW5kXTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBFeHRlcm5hbCBldmVudCBoYW5kbGluZ1xyXG5cdGZ1bmN0aW9uIGZpcmVFdmVudCAoIGV2ZW50TmFtZSwgaGFuZGxlTnVtYmVyLCB0YXAgKSB7XHJcblxyXG5cdFx0T2JqZWN0LmtleXMoc2NvcGVfRXZlbnRzKS5mb3JFYWNoKGZ1bmN0aW9uKCB0YXJnZXRFdmVudCApIHtcclxuXHJcblx0XHRcdHZhciBldmVudFR5cGUgPSB0YXJnZXRFdmVudC5zcGxpdCgnLicpWzBdO1xyXG5cclxuXHRcdFx0aWYgKCBldmVudE5hbWUgPT09IGV2ZW50VHlwZSApIHtcclxuXHRcdFx0XHRzY29wZV9FdmVudHNbdGFyZ2V0RXZlbnRdLmZvckVhY2goZnVuY3Rpb24oIGNhbGxiYWNrICkge1xyXG5cclxuXHRcdFx0XHRcdGNhbGxiYWNrLmNhbGwoXHJcblx0XHRcdFx0XHRcdC8vIFVzZSB0aGUgc2xpZGVyIHB1YmxpYyBBUEkgYXMgdGhlIHNjb3BlICgndGhpcycpXHJcblx0XHRcdFx0XHRcdHNjb3BlX1NlbGYsXHJcblx0XHRcdFx0XHRcdC8vIFJldHVybiB2YWx1ZXMgYXMgYXJyYXksIHNvIGFyZ18xW2FyZ18yXSBpcyBhbHdheXMgdmFsaWQuXHJcblx0XHRcdFx0XHRcdHNjb3BlX1ZhbHVlcy5tYXAob3B0aW9ucy5mb3JtYXQudG8pLFxyXG5cdFx0XHRcdFx0XHQvLyBIYW5kbGUgaW5kZXgsIDAgb3IgMVxyXG5cdFx0XHRcdFx0XHRoYW5kbGVOdW1iZXIsXHJcblx0XHRcdFx0XHRcdC8vIFVuZm9ybWF0dGVkIHNsaWRlciB2YWx1ZXNcclxuXHRcdFx0XHRcdFx0c2NvcGVfVmFsdWVzLnNsaWNlKCksXHJcblx0XHRcdFx0XHRcdC8vIEV2ZW50IGlzIGZpcmVkIGJ5IHRhcCwgdHJ1ZSBvciBmYWxzZVxyXG5cdFx0XHRcdFx0XHR0YXAgfHwgZmFsc2UsXHJcblx0XHRcdFx0XHRcdC8vIExlZnQgb2Zmc2V0IG9mIHRoZSBoYW5kbGUsIGluIHJlbGF0aW9uIHRvIHRoZSBzbGlkZXJcclxuXHRcdFx0XHRcdFx0c2NvcGVfTG9jYXRpb25zLnNsaWNlKClcclxuXHRcdFx0XHRcdCk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IE1lY2hhbmljcyBmb3Igc2xpZGVyIG9wZXJhdGlvbiAqL1xyXG5cclxuXHRmdW5jdGlvbiB0b1BjdCAoIHBjdCApIHtcclxuXHRcdHJldHVybiBwY3QgKyAnJSc7XHJcblx0fVxyXG5cclxuXHQvLyBTcGxpdCBvdXQgdGhlIGhhbmRsZSBwb3NpdGlvbmluZyBsb2dpYyBzbyB0aGUgTW92ZSBldmVudCBjYW4gdXNlIGl0LCB0b29cclxuXHRmdW5jdGlvbiBjaGVja0hhbmRsZVBvc2l0aW9uICggcmVmZXJlbmNlLCBoYW5kbGVOdW1iZXIsIHRvLCBsb29rQmFja3dhcmQsIGxvb2tGb3J3YXJkLCBnZXRWYWx1ZSApIHtcclxuXHJcblx0XHQvLyBGb3Igc2xpZGVycyB3aXRoIG11bHRpcGxlIGhhbmRsZXMsIGxpbWl0IG1vdmVtZW50IHRvIHRoZSBvdGhlciBoYW5kbGUuXHJcblx0XHQvLyBBcHBseSB0aGUgbWFyZ2luIG9wdGlvbiBieSBhZGRpbmcgaXQgdG8gdGhlIGhhbmRsZSBwb3NpdGlvbnMuXHJcblx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSApIHtcclxuXHJcblx0XHRcdGlmICggbG9va0JhY2t3YXJkICYmIGhhbmRsZU51bWJlciA+IDAgKSB7XHJcblx0XHRcdFx0dG8gPSBNYXRoLm1heCh0bywgcmVmZXJlbmNlW2hhbmRsZU51bWJlciAtIDFdICsgb3B0aW9ucy5tYXJnaW4pO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRpZiAoIGxvb2tGb3J3YXJkICYmIGhhbmRsZU51bWJlciA8IHNjb3BlX0hhbmRsZXMubGVuZ3RoIC0gMSApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWluKHRvLCByZWZlcmVuY2VbaGFuZGxlTnVtYmVyICsgMV0gLSBvcHRpb25zLm1hcmdpbik7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBUaGUgbGltaXQgb3B0aW9uIGhhcyB0aGUgb3Bwb3NpdGUgZWZmZWN0LCBsaW1pdGluZyBoYW5kbGVzIHRvIGFcclxuXHRcdC8vIG1heGltdW0gZGlzdGFuY2UgZnJvbSBhbm90aGVyLiBMaW1pdCBtdXN0IGJlID4gMCwgYXMgb3RoZXJ3aXNlXHJcblx0XHQvLyBoYW5kbGVzIHdvdWxkIGJlIHVubW92ZWFibGUuXHJcblx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSAmJiBvcHRpb25zLmxpbWl0ICkge1xyXG5cclxuXHRcdFx0aWYgKCBsb29rQmFja3dhcmQgJiYgaGFuZGxlTnVtYmVyID4gMCApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWluKHRvLCByZWZlcmVuY2VbaGFuZGxlTnVtYmVyIC0gMV0gKyBvcHRpb25zLmxpbWl0KTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0aWYgKCBsb29rRm9yd2FyZCAmJiBoYW5kbGVOdW1iZXIgPCBzY29wZV9IYW5kbGVzLmxlbmd0aCAtIDEgKSB7XHJcblx0XHRcdFx0dG8gPSBNYXRoLm1heCh0bywgcmVmZXJlbmNlW2hhbmRsZU51bWJlciArIDFdIC0gb3B0aW9ucy5saW1pdCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBUaGUgcGFkZGluZyBvcHRpb24ga2VlcHMgdGhlIGhhbmRsZXMgYSBjZXJ0YWluIGRpc3RhbmNlIGZyb20gdGhlXHJcblx0XHQvLyBlZGdlcyBvZiB0aGUgc2xpZGVyLiBQYWRkaW5nIG11c3QgYmUgPiAwLlxyXG5cdFx0aWYgKCBvcHRpb25zLnBhZGRpbmcgKSB7XHJcblxyXG5cdFx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gMCApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWF4KHRvLCBvcHRpb25zLnBhZGRpbmdbMF0pO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gc2NvcGVfSGFuZGxlcy5sZW5ndGggLSAxICkge1xyXG5cdFx0XHRcdHRvID0gTWF0aC5taW4odG8sIDEwMCAtIG9wdGlvbnMucGFkZGluZ1sxXSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHR0byA9IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAodG8pO1xyXG5cclxuXHRcdC8vIExpbWl0IHBlcmNlbnRhZ2UgdG8gdGhlIDAgLSAxMDAgcmFuZ2VcclxuXHRcdHRvID0gbGltaXQodG8pO1xyXG5cclxuXHRcdC8vIFJldHVybiBmYWxzZSBpZiBoYW5kbGUgY2FuJ3QgbW92ZVxyXG5cdFx0aWYgKCB0byA9PT0gcmVmZXJlbmNlW2hhbmRsZU51bWJlcl0gJiYgIWdldFZhbHVlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHRvO1xyXG5cdH1cclxuXHJcblx0Ly8gVXNlcyBzbGlkZXIgb3JpZW50YXRpb24gdG8gY3JlYXRlIENTUyBydWxlcy4gYSA9IGJhc2UgdmFsdWU7XHJcblx0ZnVuY3Rpb24gaW5SdWxlT3JkZXIgKCB2LCBhICkge1xyXG5cdFx0dmFyIG8gPSBvcHRpb25zLm9ydDtcclxuXHRcdHJldHVybiAobz9hOnYpICsgJywgJyArIChvP3Y6YSk7XHJcblx0fVxyXG5cclxuXHQvLyBNb3ZlcyBoYW5kbGUocykgYnkgYSBwZXJjZW50YWdlXHJcblx0Ly8gKGJvb2wsICUgdG8gbW92ZSwgWyUgd2hlcmUgaGFuZGxlIHN0YXJ0ZWQsIC4uLl0sIFtpbmRleCBpbiBzY29wZV9IYW5kbGVzLCAuLi5dKVxyXG5cdGZ1bmN0aW9uIG1vdmVIYW5kbGVzICggdXB3YXJkLCBwcm9wb3NhbCwgbG9jYXRpb25zLCBoYW5kbGVOdW1iZXJzICkge1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbHMgPSBsb2NhdGlvbnMuc2xpY2UoKTtcclxuXHJcblx0XHR2YXIgYiA9IFshdXB3YXJkLCB1cHdhcmRdO1xyXG5cdFx0dmFyIGYgPSBbdXB3YXJkLCAhdXB3YXJkXTtcclxuXHJcblx0XHQvLyBDb3B5IGhhbmRsZU51bWJlcnMgc28gd2UgZG9uJ3QgY2hhbmdlIHRoZSBkYXRhc2V0XHJcblx0XHRoYW5kbGVOdW1iZXJzID0gaGFuZGxlTnVtYmVycy5zbGljZSgpO1xyXG5cclxuXHRcdC8vIENoZWNrIHRvIHNlZSB3aGljaCBoYW5kbGUgaXMgJ2xlYWRpbmcnLlxyXG5cdFx0Ly8gSWYgdGhhdCBvbmUgY2FuJ3QgbW92ZSB0aGUgc2Vjb25kIGNhbid0IGVpdGhlci5cclxuXHRcdGlmICggdXB3YXJkICkge1xyXG5cdFx0XHRoYW5kbGVOdW1iZXJzLnJldmVyc2UoKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBTdGVwIDE6IGdldCB0aGUgbWF4aW11bSBwZXJjZW50YWdlIHRoYXQgYW55IG9mIHRoZSBoYW5kbGVzIGNhbiBtb3ZlXHJcblx0XHRpZiAoIGhhbmRsZU51bWJlcnMubGVuZ3RoID4gMSApIHtcclxuXHJcblx0XHRcdGhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIsIG8pIHtcclxuXHJcblx0XHRcdFx0dmFyIHRvID0gY2hlY2tIYW5kbGVQb3NpdGlvbihwcm9wb3NhbHMsIGhhbmRsZU51bWJlciwgcHJvcG9zYWxzW2hhbmRsZU51bWJlcl0gKyBwcm9wb3NhbCwgYltvXSwgZltvXSwgZmFsc2UpO1xyXG5cclxuXHRcdFx0XHQvLyBTdG9wIGlmIG9uZSBvZiB0aGUgaGFuZGxlcyBjYW4ndCBtb3ZlLlxyXG5cdFx0XHRcdGlmICggdG8gPT09IGZhbHNlICkge1xyXG5cdFx0XHRcdFx0cHJvcG9zYWwgPSAwO1xyXG5cdFx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0XHRwcm9wb3NhbCA9IHRvIC0gcHJvcG9zYWxzW2hhbmRsZU51bWJlcl07XHJcblx0XHRcdFx0XHRwcm9wb3NhbHNbaGFuZGxlTnVtYmVyXSA9IHRvO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gSWYgdXNpbmcgb25lIGhhbmRsZSwgY2hlY2sgYmFja3dhcmQgQU5EIGZvcndhcmRcclxuXHRcdGVsc2Uge1xyXG5cdFx0XHRiID0gZiA9IFt0cnVlXTtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgc3RhdGUgPSBmYWxzZTtcclxuXHJcblx0XHQvLyBTdGVwIDI6IFRyeSB0byBzZXQgdGhlIGhhbmRsZXMgd2l0aCB0aGUgZm91bmQgcGVyY2VudGFnZVxyXG5cdFx0aGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlciwgbykge1xyXG5cdFx0XHRzdGF0ZSA9IHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIGxvY2F0aW9uc1toYW5kbGVOdW1iZXJdICsgcHJvcG9zYWwsIGJbb10sIGZbb10pIHx8IHN0YXRlO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gU3RlcCAzOiBJZiBhIGhhbmRsZSBtb3ZlZCwgZmlyZSBldmVudHNcclxuXHRcdGlmICggc3RhdGUgKSB7XHJcblx0XHRcdGhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRcdGZpcmVFdmVudCgndXBkYXRlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0XHRmaXJlRXZlbnQoJ3NsaWRlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0fSk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQvLyBUYWtlcyBhIGJhc2UgdmFsdWUgYW5kIGFuIG9mZnNldC4gVGhpcyBvZmZzZXQgaXMgdXNlZCBmb3IgdGhlIGNvbm5lY3QgYmFyIHNpemUuXHJcblx0Ly8gSW4gdGhlIGluaXRpYWwgZGVzaWduIGZvciB0aGlzIGZlYXR1cmUsIHRoZSBvcmlnaW4gZWxlbWVudCB3YXMgMSUgd2lkZS5cclxuXHQvLyBVbmZvcnR1bmF0ZWx5LCBhIHJvdW5kaW5nIGJ1ZyBpbiBDaHJvbWUgbWFrZXMgaXQgaW1wb3NzaWJsZSB0byBpbXBsZW1lbnQgdGhpcyBmZWF0dXJlXHJcblx0Ly8gaW4gdGhpcyBtYW5uZXI6IGh0dHBzOi8vYnVncy5jaHJvbWl1bS5vcmcvcC9jaHJvbWl1bS9pc3N1ZXMvZGV0YWlsP2lkPTc5ODIyM1xyXG5cdGZ1bmN0aW9uIHRyYW5zZm9ybURpcmVjdGlvbiAoIGEsIGIgKSB7XHJcblx0XHRyZXR1cm4gb3B0aW9ucy5kaXIgPyAxMDAgLSBhIC0gYiA6IGE7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVzIHNjb3BlX0xvY2F0aW9ucyBhbmQgc2NvcGVfVmFsdWVzLCB1cGRhdGVzIHZpc3VhbCBzdGF0ZVxyXG5cdGZ1bmN0aW9uIHVwZGF0ZUhhbmRsZVBvc2l0aW9uICggaGFuZGxlTnVtYmVyLCB0byApIHtcclxuXHJcblx0XHQvLyBVcGRhdGUgbG9jYXRpb25zLlxyXG5cdFx0c2NvcGVfTG9jYXRpb25zW2hhbmRsZU51bWJlcl0gPSB0bztcclxuXHJcblx0XHQvLyBDb252ZXJ0IHRoZSB2YWx1ZSB0byB0aGUgc2xpZGVyIHN0ZXBwaW5nL3JhbmdlLlxyXG5cdFx0c2NvcGVfVmFsdWVzW2hhbmRsZU51bWJlcl0gPSBzY29wZV9TcGVjdHJ1bS5mcm9tU3RlcHBpbmcodG8pO1xyXG5cclxuXHRcdHZhciBydWxlID0gJ3RyYW5zbGF0ZSgnICsgaW5SdWxlT3JkZXIodG9QY3QodHJhbnNmb3JtRGlyZWN0aW9uKHRvLCAwKSAtIHNjb3BlX0Rpck9mZnNldCksICcwJykgKyAnKSc7XHJcblx0XHRzY29wZV9IYW5kbGVzW2hhbmRsZU51bWJlcl0uc3R5bGVbb3B0aW9ucy50cmFuc2Zvcm1SdWxlXSA9IHJ1bGU7XHJcblxyXG5cdFx0dXBkYXRlQ29ubmVjdChoYW5kbGVOdW1iZXIpO1xyXG5cdFx0dXBkYXRlQ29ubmVjdChoYW5kbGVOdW1iZXIgKyAxKTtcclxuXHR9XHJcblxyXG5cdC8vIEhhbmRsZXMgYmVmb3JlIHRoZSBzbGlkZXIgbWlkZGxlIGFyZSBzdGFja2VkIGxhdGVyID0gaGlnaGVyLFxyXG5cdC8vIEhhbmRsZXMgYWZ0ZXIgdGhlIG1pZGRsZSBsYXRlciBpcyBsb3dlclxyXG5cdC8vIFtbN10gWzhdIC4uLi4uLi4uLi4gfCAuLi4uLi4uLi4uIFs1XSBbNF1cclxuXHRmdW5jdGlvbiBzZXRaaW5kZXggKCApIHtcclxuXHJcblx0XHRzY29wZV9IYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oaGFuZGxlTnVtYmVyKXtcclxuXHRcdFx0dmFyIGRpciA9IChzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXSA+IDUwID8gLTEgOiAxKTtcclxuXHRcdFx0dmFyIHpJbmRleCA9IDMgKyAoc2NvcGVfSGFuZGxlcy5sZW5ndGggKyAoZGlyICogaGFuZGxlTnVtYmVyKSk7XHJcblx0XHRcdHNjb3BlX0hhbmRsZXNbaGFuZGxlTnVtYmVyXS5zdHlsZS56SW5kZXggPSB6SW5kZXg7XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cdC8vIFRlc3Qgc3VnZ2VzdGVkIHZhbHVlcyBhbmQgYXBwbHkgbWFyZ2luLCBzdGVwLlxyXG5cdGZ1bmN0aW9uIHNldEhhbmRsZSAoIGhhbmRsZU51bWJlciwgdG8sIGxvb2tCYWNrd2FyZCwgbG9va0ZvcndhcmQgKSB7XHJcblxyXG5cdFx0dG8gPSBjaGVja0hhbmRsZVBvc2l0aW9uKHNjb3BlX0xvY2F0aW9ucywgaGFuZGxlTnVtYmVyLCB0bywgbG9va0JhY2t3YXJkLCBsb29rRm9yd2FyZCwgZmFsc2UpO1xyXG5cclxuXHRcdGlmICggdG8gPT09IGZhbHNlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0dXBkYXRlSGFuZGxlUG9zaXRpb24oaGFuZGxlTnVtYmVyLCB0byk7XHJcblxyXG5cdFx0cmV0dXJuIHRydWU7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVzIHN0eWxlIGF0dHJpYnV0ZSBmb3IgY29ubmVjdCBub2Rlc1xyXG5cdGZ1bmN0aW9uIHVwZGF0ZUNvbm5lY3QgKCBpbmRleCApIHtcclxuXHJcblx0XHQvLyBTa2lwIGNvbm5lY3RzIHNldCB0byBmYWxzZVxyXG5cdFx0aWYgKCAhc2NvcGVfQ29ubmVjdHNbaW5kZXhdICkge1xyXG5cdFx0XHRyZXR1cm47XHJcblx0XHR9XHJcblxyXG5cdFx0dmFyIGwgPSAwO1xyXG5cdFx0dmFyIGggPSAxMDA7XHJcblxyXG5cdFx0aWYgKCBpbmRleCAhPT0gMCApIHtcclxuXHRcdFx0bCA9IHNjb3BlX0xvY2F0aW9uc1tpbmRleCAtIDFdO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggaW5kZXggIT09IHNjb3BlX0Nvbm5lY3RzLmxlbmd0aCAtIDEgKSB7XHJcblx0XHRcdGggPSBzY29wZV9Mb2NhdGlvbnNbaW5kZXhdO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFdlIHVzZSB0d28gcnVsZXM6XHJcblx0XHQvLyAndHJhbnNsYXRlJyB0byBjaGFuZ2UgdGhlIGxlZnQvdG9wIG9mZnNldDtcclxuXHRcdC8vICdzY2FsZScgdG8gY2hhbmdlIHRoZSB3aWR0aCBvZiB0aGUgZWxlbWVudDtcclxuXHRcdC8vIEFzIHRoZSBlbGVtZW50IGhhcyBhIHdpZHRoIG9mIDEwMCUsIGEgdHJhbnNsYXRpb24gb2YgMTAwJSBpcyBlcXVhbCB0byAxMDAlIG9mIHRoZSBwYXJlbnQgKC5ub1VpLWJhc2UpXHJcblx0XHR2YXIgY29ubmVjdFdpZHRoID0gaCAtIGw7XHJcblx0XHR2YXIgdHJhbnNsYXRlUnVsZSA9ICd0cmFuc2xhdGUoJyArIGluUnVsZU9yZGVyKHRvUGN0KHRyYW5zZm9ybURpcmVjdGlvbihsLCBjb25uZWN0V2lkdGgpKSwgJzAnKSArICcpJztcclxuXHRcdHZhciBzY2FsZVJ1bGUgPSAnc2NhbGUoJyArIGluUnVsZU9yZGVyKGNvbm5lY3RXaWR0aCAvIDEwMCwgJzEnKSArICcpJztcclxuXHJcblx0XHRzY29wZV9Db25uZWN0c1tpbmRleF0uc3R5bGVbb3B0aW9ucy50cmFuc2Zvcm1SdWxlXSA9IHRyYW5zbGF0ZVJ1bGUgKyAnICcgKyBzY2FsZVJ1bGU7XHJcblx0fVxyXG5cclxuLyohIEluIHRoaXMgZmlsZTogQWxsIG1ldGhvZHMgZXZlbnR1YWxseSBleHBvc2VkIGluIHNsaWRlci5ub1VpU2xpZGVyLi4uICovXHJcblxyXG5cdC8vIFBhcnNlcyB2YWx1ZSBwYXNzZWQgdG8gLnNldCBtZXRob2QuIFJldHVybnMgY3VycmVudCB2YWx1ZSBpZiBub3QgcGFyc2UtYWJsZS5cclxuXHRmdW5jdGlvbiByZXNvbHZlVG9WYWx1ZSAoIHRvLCBoYW5kbGVOdW1iZXIgKSB7XHJcblxyXG5cdFx0Ly8gU2V0dGluZyB3aXRoIG51bGwgaW5kaWNhdGVzIGFuICdpZ25vcmUnLlxyXG5cdFx0Ly8gSW5wdXR0aW5nICdmYWxzZScgaXMgaW52YWxpZC5cclxuXHRcdGlmICggdG8gPT09IG51bGwgfHwgdG8gPT09IGZhbHNlIHx8IHRvID09PSB1bmRlZmluZWQgKSB7XHJcblx0XHRcdHJldHVybiBzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJZiBhIGZvcm1hdHRlZCBudW1iZXIgd2FzIHBhc3NlZCwgYXR0ZW1wdCB0byBkZWNvZGUgaXQuXHJcblx0XHRpZiAoIHR5cGVvZiB0byA9PT0gJ251bWJlcicgKSB7XHJcblx0XHRcdHRvID0gU3RyaW5nKHRvKTtcclxuXHRcdH1cclxuXHJcblx0XHR0byA9IG9wdGlvbnMuZm9ybWF0LmZyb20odG8pO1xyXG5cdFx0dG8gPSBzY29wZV9TcGVjdHJ1bS50b1N0ZXBwaW5nKHRvKTtcclxuXHJcblx0XHQvLyBJZiBwYXJzaW5nIHRoZSBudW1iZXIgZmFpbGVkLCB1c2UgdGhlIGN1cnJlbnQgdmFsdWUuXHJcblx0XHRpZiAoIHRvID09PSBmYWxzZSB8fCBpc05hTih0bykgKSB7XHJcblx0XHRcdHJldHVybiBzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gdG87XHJcblx0fVxyXG5cclxuXHQvLyBTZXQgdGhlIHNsaWRlciB2YWx1ZS5cclxuXHRmdW5jdGlvbiB2YWx1ZVNldCAoIGlucHV0LCBmaXJlU2V0RXZlbnQgKSB7XHJcblxyXG5cdFx0dmFyIHZhbHVlcyA9IGFzQXJyYXkoaW5wdXQpO1xyXG5cdFx0dmFyIGlzSW5pdCA9IHNjb3BlX0xvY2F0aW9uc1swXSA9PT0gdW5kZWZpbmVkO1xyXG5cclxuXHRcdC8vIEV2ZW50IGZpcmVzIGJ5IGRlZmF1bHRcclxuXHRcdGZpcmVTZXRFdmVudCA9IChmaXJlU2V0RXZlbnQgPT09IHVuZGVmaW5lZCA/IHRydWUgOiAhIWZpcmVTZXRFdmVudCk7XHJcblxyXG5cdFx0Ly8gQW5pbWF0aW9uIGlzIG9wdGlvbmFsLlxyXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSBpbml0aWFsIHZhbHVlcyB3ZXJlIHNldCBiZWZvcmUgdXNpbmcgYW5pbWF0ZWQgcGxhY2VtZW50LlxyXG5cdFx0aWYgKCBvcHRpb25zLmFuaW1hdGUgJiYgIWlzSW5pdCApIHtcclxuXHRcdFx0YWRkQ2xhc3NGb3Ioc2NvcGVfVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMudGFwLCBvcHRpb25zLmFuaW1hdGlvbkR1cmF0aW9uKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBGaXJzdCBwYXNzLCB3aXRob3V0IGxvb2tBaGVhZCBidXQgd2l0aCBsb29rQmFja3dhcmQuIFZhbHVlcyBhcmUgc2V0IGZyb20gbGVmdCB0byByaWdodC5cclxuXHRcdHNjb3BlX0hhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRzZXRIYW5kbGUoaGFuZGxlTnVtYmVyLCByZXNvbHZlVG9WYWx1ZSh2YWx1ZXNbaGFuZGxlTnVtYmVyXSwgaGFuZGxlTnVtYmVyKSwgdHJ1ZSwgZmFsc2UpO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gU2Vjb25kIHBhc3MuIE5vdyB0aGF0IGFsbCBiYXNlIHZhbHVlcyBhcmUgc2V0LCBhcHBseSBjb25zdHJhaW50c1xyXG5cdFx0c2NvcGVfSGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIHNjb3BlX0xvY2F0aW9uc1toYW5kbGVOdW1iZXJdLCB0cnVlLCB0cnVlKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdHNldFppbmRleCgpO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cclxuXHRcdFx0ZmlyZUV2ZW50KCd1cGRhdGUnLCBoYW5kbGVOdW1iZXIpO1xyXG5cclxuXHRcdFx0Ly8gRmlyZSB0aGUgZXZlbnQgb25seSBmb3IgaGFuZGxlcyB0aGF0IHJlY2VpdmVkIGEgbmV3IHZhbHVlLCBhcyBwZXIgIzU3OVxyXG5cdFx0XHRpZiAoIHZhbHVlc1toYW5kbGVOdW1iZXJdICE9PSBudWxsICYmIGZpcmVTZXRFdmVudCApIHtcclxuXHRcdFx0XHRmaXJlRXZlbnQoJ3NldCcsIGhhbmRsZU51bWJlcik7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gUmVzZXQgc2xpZGVyIHRvIGluaXRpYWwgdmFsdWVzXHJcblx0ZnVuY3Rpb24gdmFsdWVSZXNldCAoIGZpcmVTZXRFdmVudCApIHtcclxuXHRcdHZhbHVlU2V0KG9wdGlvbnMuc3RhcnQsIGZpcmVTZXRFdmVudCk7XHJcblx0fVxyXG5cclxuXHQvLyBHZXQgdGhlIHNsaWRlciB2YWx1ZS5cclxuXHRmdW5jdGlvbiB2YWx1ZUdldCAoICkge1xyXG5cclxuXHRcdHZhciB2YWx1ZXMgPSBzY29wZV9WYWx1ZXMubWFwKG9wdGlvbnMuZm9ybWF0LnRvKTtcclxuXHJcblx0XHQvLyBJZiBvbmx5IG9uZSBoYW5kbGUgaXMgdXNlZCwgcmV0dXJuIGEgc2luZ2xlIHZhbHVlLlxyXG5cdFx0aWYgKCB2YWx1ZXMubGVuZ3RoID09PSAxICl7XHJcblx0XHRcdHJldHVybiB2YWx1ZXNbMF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHZhbHVlcztcclxuXHR9XHJcblxyXG5cdC8vIFJlbW92ZXMgY2xhc3NlcyBmcm9tIHRoZSByb290IGFuZCBlbXB0aWVzIGl0LlxyXG5cdGZ1bmN0aW9uIGRlc3Ryb3kgKCApIHtcclxuXHJcblx0XHRmb3IgKCB2YXIga2V5IGluIG9wdGlvbnMuY3NzQ2xhc3NlcyApIHtcclxuXHRcdFx0aWYgKCAhb3B0aW9ucy5jc3NDbGFzc2VzLmhhc093blByb3BlcnR5KGtleSkgKSB7IGNvbnRpbnVlOyB9XHJcblx0XHRcdHJlbW92ZUNsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzW2tleV0pO1xyXG5cdFx0fVxyXG5cclxuXHRcdHdoaWxlIChzY29wZV9UYXJnZXQuZmlyc3RDaGlsZCkge1xyXG5cdFx0XHRzY29wZV9UYXJnZXQucmVtb3ZlQ2hpbGQoc2NvcGVfVGFyZ2V0LmZpcnN0Q2hpbGQpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGRlbGV0ZSBzY29wZV9UYXJnZXQubm9VaVNsaWRlcjtcclxuXHR9XHJcblxyXG5cdC8vIEdldCB0aGUgY3VycmVudCBzdGVwIHNpemUgZm9yIHRoZSBzbGlkZXIuXHJcblx0ZnVuY3Rpb24gZ2V0Q3VycmVudFN0ZXAgKCApIHtcclxuXHJcblx0XHQvLyBDaGVjayBhbGwgbG9jYXRpb25zLCBtYXAgdGhlbSB0byB0aGVpciBzdGVwcGluZyBwb2ludC5cclxuXHRcdC8vIEdldCB0aGUgc3RlcCBwb2ludCwgdGhlbiBmaW5kIGl0IGluIHRoZSBpbnB1dCBsaXN0LlxyXG5cdFx0cmV0dXJuIHNjb3BlX0xvY2F0aW9ucy5tYXAoZnVuY3Rpb24oIGxvY2F0aW9uLCBpbmRleCApe1xyXG5cclxuXHRcdFx0dmFyIG5lYXJieVN0ZXBzID0gc2NvcGVfU3BlY3RydW0uZ2V0TmVhcmJ5U3RlcHMoIGxvY2F0aW9uICk7XHJcblx0XHRcdHZhciB2YWx1ZSA9IHNjb3BlX1ZhbHVlc1tpbmRleF07XHJcblx0XHRcdHZhciBpbmNyZW1lbnQgPSBuZWFyYnlTdGVwcy50aGlzU3RlcC5zdGVwO1xyXG5cdFx0XHR2YXIgZGVjcmVtZW50ID0gbnVsbDtcclxuXHJcblx0XHRcdC8vIElmIHRoZSBuZXh0IHZhbHVlIGluIHRoaXMgc3RlcCBtb3ZlcyBpbnRvIHRoZSBuZXh0IHN0ZXAsXHJcblx0XHRcdC8vIHRoZSBpbmNyZW1lbnQgaXMgdGhlIHN0YXJ0IG9mIHRoZSBuZXh0IHN0ZXAgLSB0aGUgY3VycmVudCB2YWx1ZVxyXG5cdFx0XHRpZiAoIGluY3JlbWVudCAhPT0gZmFsc2UgKSB7XHJcblx0XHRcdFx0aWYgKCB2YWx1ZSArIGluY3JlbWVudCA+IG5lYXJieVN0ZXBzLnN0ZXBBZnRlci5zdGFydFZhbHVlICkge1xyXG5cdFx0XHRcdFx0aW5jcmVtZW50ID0gbmVhcmJ5U3RlcHMuc3RlcEFmdGVyLnN0YXJ0VmFsdWUgLSB2YWx1ZTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblxyXG5cdFx0XHQvLyBJZiB0aGUgdmFsdWUgaXMgYmV5b25kIHRoZSBzdGFydGluZyBwb2ludFxyXG5cdFx0XHRpZiAoIHZhbHVlID4gbmVhcmJ5U3RlcHMudGhpc1N0ZXAuc3RhcnRWYWx1ZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBuZWFyYnlTdGVwcy50aGlzU3RlcC5zdGVwO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRlbHNlIGlmICggbmVhcmJ5U3RlcHMuc3RlcEJlZm9yZS5zdGVwID09PSBmYWxzZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBmYWxzZTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gSWYgYSBoYW5kbGUgaXMgYXQgdGhlIHN0YXJ0IG9mIGEgc3RlcCwgaXQgYWx3YXlzIHN0ZXBzIGJhY2sgaW50byB0aGUgcHJldmlvdXMgc3RlcCBmaXJzdFxyXG5cdFx0XHRlbHNlIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSB2YWx1ZSAtIG5lYXJieVN0ZXBzLnN0ZXBCZWZvcmUuaGlnaGVzdFN0ZXA7XHJcblx0XHRcdH1cclxuXHJcblxyXG5cdFx0XHQvLyBOb3csIGlmIGF0IHRoZSBzbGlkZXIgZWRnZXMsIHRoZXJlIGlzIG5vdCBpbi9kZWNyZW1lbnRcclxuXHRcdFx0aWYgKCBsb2NhdGlvbiA9PT0gMTAwICkge1xyXG5cdFx0XHRcdGluY3JlbWVudCA9IG51bGw7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGVsc2UgaWYgKCBsb2NhdGlvbiA9PT0gMCApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBudWxsO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBBcyBwZXIgIzM5MSwgdGhlIGNvbXBhcmlzb24gZm9yIHRoZSBkZWNyZW1lbnQgc3RlcCBjYW4gaGF2ZSBzb21lIHJvdW5kaW5nIGlzc3Vlcy5cclxuXHRcdFx0dmFyIHN0ZXBEZWNpbWFscyA9IHNjb3BlX1NwZWN0cnVtLmNvdW50U3RlcERlY2ltYWxzKCk7XHJcblxyXG5cdFx0XHQvLyBSb3VuZCBwZXIgIzM5MVxyXG5cdFx0XHRpZiAoIGluY3JlbWVudCAhPT0gbnVsbCAmJiBpbmNyZW1lbnQgIT09IGZhbHNlICkge1xyXG5cdFx0XHRcdGluY3JlbWVudCA9IE51bWJlcihpbmNyZW1lbnQudG9GaXhlZChzdGVwRGVjaW1hbHMpKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0aWYgKCBkZWNyZW1lbnQgIT09IG51bGwgJiYgZGVjcmVtZW50ICE9PSBmYWxzZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBOdW1iZXIoZGVjcmVtZW50LnRvRml4ZWQoc3RlcERlY2ltYWxzKSk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiBbZGVjcmVtZW50LCBpbmNyZW1lbnRdO1xyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVhYmxlOiBtYXJnaW4sIGxpbWl0LCBwYWRkaW5nLCBzdGVwLCByYW5nZSwgYW5pbWF0ZSwgc25hcFxyXG5cdGZ1bmN0aW9uIHVwZGF0ZU9wdGlvbnMgKCBvcHRpb25zVG9VcGRhdGUsIGZpcmVTZXRFdmVudCApIHtcclxuXHJcblx0XHQvLyBTcGVjdHJ1bSBpcyBjcmVhdGVkIHVzaW5nIHRoZSByYW5nZSwgc25hcCwgZGlyZWN0aW9uIGFuZCBzdGVwIG9wdGlvbnMuXHJcblx0XHQvLyAnc25hcCcgYW5kICdzdGVwJyBjYW4gYmUgdXBkYXRlZC5cclxuXHRcdC8vIElmICdzbmFwJyBhbmQgJ3N0ZXAnIGFyZSBub3QgcGFzc2VkLCB0aGV5IHNob3VsZCByZW1haW4gdW5jaGFuZ2VkLlxyXG5cdFx0dmFyIHYgPSB2YWx1ZUdldCgpO1xyXG5cclxuXHRcdHZhciB1cGRhdGVBYmxlID0gWydtYXJnaW4nLCAnbGltaXQnLCAncGFkZGluZycsICdyYW5nZScsICdhbmltYXRlJywgJ3NuYXAnLCAnc3RlcCcsICdmb3JtYXQnXTtcclxuXHJcblx0XHQvLyBPbmx5IGNoYW5nZSBvcHRpb25zIHRoYXQgd2UncmUgYWN0dWFsbHkgcGFzc2VkIHRvIHVwZGF0ZS5cclxuXHRcdHVwZGF0ZUFibGUuZm9yRWFjaChmdW5jdGlvbihuYW1lKXtcclxuXHRcdFx0aWYgKCBvcHRpb25zVG9VcGRhdGVbbmFtZV0gIT09IHVuZGVmaW5lZCApIHtcclxuXHRcdFx0XHRvcmlnaW5hbE9wdGlvbnNbbmFtZV0gPSBvcHRpb25zVG9VcGRhdGVbbmFtZV07XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cclxuXHRcdHZhciBuZXdPcHRpb25zID0gdGVzdE9wdGlvbnMob3JpZ2luYWxPcHRpb25zKTtcclxuXHJcblx0XHQvLyBMb2FkIG5ldyBvcHRpb25zIGludG8gdGhlIHNsaWRlciBzdGF0ZVxyXG5cdFx0dXBkYXRlQWJsZS5mb3JFYWNoKGZ1bmN0aW9uKG5hbWUpe1xyXG5cdFx0XHRpZiAoIG9wdGlvbnNUb1VwZGF0ZVtuYW1lXSAhPT0gdW5kZWZpbmVkICkge1xyXG5cdFx0XHRcdG9wdGlvbnNbbmFtZV0gPSBuZXdPcHRpb25zW25hbWVdO1xyXG5cdFx0XHR9XHJcblx0XHR9KTtcclxuXHJcblx0XHRzY29wZV9TcGVjdHJ1bSA9IG5ld09wdGlvbnMuc3BlY3RydW07XHJcblxyXG5cdFx0Ly8gTGltaXQsIG1hcmdpbiBhbmQgcGFkZGluZyBkZXBlbmQgb24gdGhlIHNwZWN0cnVtIGJ1dCBhcmUgc3RvcmVkIG91dHNpZGUgb2YgaXQuICgjNjc3KVxyXG5cdFx0b3B0aW9ucy5tYXJnaW4gPSBuZXdPcHRpb25zLm1hcmdpbjtcclxuXHRcdG9wdGlvbnMubGltaXQgPSBuZXdPcHRpb25zLmxpbWl0O1xyXG5cdFx0b3B0aW9ucy5wYWRkaW5nID0gbmV3T3B0aW9ucy5wYWRkaW5nO1xyXG5cclxuXHRcdC8vIFVwZGF0ZSBwaXBzLCByZW1vdmVzIGV4aXN0aW5nLlxyXG5cdFx0aWYgKCBvcHRpb25zLnBpcHMgKSB7XHJcblx0XHRcdHBpcHMob3B0aW9ucy5waXBzKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJbnZhbGlkYXRlIHRoZSBjdXJyZW50IHBvc2l0aW9uaW5nIHNvIHZhbHVlU2V0IGZvcmNlcyBhbiB1cGRhdGUuXHJcblx0XHRzY29wZV9Mb2NhdGlvbnMgPSBbXTtcclxuXHRcdHZhbHVlU2V0KG9wdGlvbnNUb1VwZGF0ZS5zdGFydCB8fCB2LCBmaXJlU2V0RXZlbnQpO1xyXG5cdH1cclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IENhbGxzIHRvIGZ1bmN0aW9ucy4gQWxsIG90aGVyIHNjb3BlXyBmaWxlcyBkZWZpbmUgZnVuY3Rpb25zIG9ubHk7ICovXHJcblxyXG5cdC8vIENyZWF0ZSB0aGUgYmFzZSBlbGVtZW50LCBpbml0aWFsaXplIEhUTUwgYW5kIHNldCBjbGFzc2VzLlxyXG5cdC8vIEFkZCBoYW5kbGVzIGFuZCBjb25uZWN0IGVsZW1lbnRzLlxyXG5cdGFkZFNsaWRlcihzY29wZV9UYXJnZXQpO1xyXG5cdGFkZEVsZW1lbnRzKG9wdGlvbnMuY29ubmVjdCwgc2NvcGVfQmFzZSk7XHJcblxyXG5cdC8vIEF0dGFjaCB1c2VyIGV2ZW50cy5cclxuXHRiaW5kU2xpZGVyRXZlbnRzKG9wdGlvbnMuZXZlbnRzKTtcclxuXHJcblx0Ly8gVXNlIHRoZSBwdWJsaWMgdmFsdWUgbWV0aG9kIHRvIHNldCB0aGUgc3RhcnQgdmFsdWVzLlxyXG5cdHZhbHVlU2V0KG9wdGlvbnMuc3RhcnQpO1xyXG5cclxuXHRzY29wZV9TZWxmID0ge1xyXG5cdFx0ZGVzdHJveTogZGVzdHJveSxcclxuXHRcdHN0ZXBzOiBnZXRDdXJyZW50U3RlcCxcclxuXHRcdG9uOiBiaW5kRXZlbnQsXHJcblx0XHRvZmY6IHJlbW92ZUV2ZW50LFxyXG5cdFx0Z2V0OiB2YWx1ZUdldCxcclxuXHRcdHNldDogdmFsdWVTZXQsXHJcblx0XHRyZXNldDogdmFsdWVSZXNldCxcclxuXHRcdC8vIEV4cG9zZWQgZm9yIHVuaXQgdGVzdGluZywgZG9uJ3QgdXNlIHRoaXMgaW4geW91ciBhcHBsaWNhdGlvbi5cclxuXHRcdF9fbW92ZUhhbmRsZXM6IGZ1bmN0aW9uKGEsIGIsIGMpIHsgbW92ZUhhbmRsZXMoYSwgYiwgc2NvcGVfTG9jYXRpb25zLCBjKTsgfSxcclxuXHRcdG9wdGlvbnM6IG9yaWdpbmFsT3B0aW9ucywgLy8gSXNzdWUgIzYwMCwgIzY3OFxyXG5cdFx0dXBkYXRlT3B0aW9uczogdXBkYXRlT3B0aW9ucyxcclxuXHRcdHRhcmdldDogc2NvcGVfVGFyZ2V0LCAvLyBJc3N1ZSAjNTk3XHJcblx0XHRyZW1vdmVQaXBzOiByZW1vdmVQaXBzLFxyXG5cdFx0cGlwczogcGlwcyAvLyBJc3N1ZSAjNTk0XHJcblx0fTtcclxuXHJcblx0aWYgKCBvcHRpb25zLnBpcHMgKSB7XHJcblx0XHRwaXBzKG9wdGlvbnMucGlwcyk7XHJcblx0fVxyXG5cclxuXHRpZiAoIG9wdGlvbnMudG9vbHRpcHMgKSB7XHJcblx0XHR0b29sdGlwcygpO1xyXG5cdH1cclxuXHJcblx0YXJpYSgpO1xyXG5cclxuXHRyZXR1cm4gc2NvcGVfU2VsZjtcclxuXHJcbn1cclxuXHJcblxyXG5cdC8vIFJ1biB0aGUgc3RhbmRhcmQgaW5pdGlhbGl6ZXJcclxuXHRmdW5jdGlvbiBpbml0aWFsaXplICggdGFyZ2V0LCBvcmlnaW5hbE9wdGlvbnMgKSB7XHJcblxyXG5cdFx0aWYgKCAhdGFyZ2V0IHx8ICF0YXJnZXQubm9kZU5hbWUgKSB7XHJcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogY3JlYXRlIHJlcXVpcmVzIGEgc2luZ2xlIGVsZW1lbnQsIGdvdDogXCIgKyB0YXJnZXQpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFRocm93IGFuIGVycm9yIGlmIHRoZSBzbGlkZXIgd2FzIGFscmVhZHkgaW5pdGlhbGl6ZWQuXHJcblx0XHRpZiAoIHRhcmdldC5ub1VpU2xpZGVyICkge1xyXG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6IFNsaWRlciB3YXMgYWxyZWFkeSBpbml0aWFsaXplZC5cIik7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gVGVzdCB0aGUgb3B0aW9ucyBhbmQgY3JlYXRlIHRoZSBzbGlkZXIgZW52aXJvbm1lbnQ7XHJcblx0XHR2YXIgb3B0aW9ucyA9IHRlc3RPcHRpb25zKCBvcmlnaW5hbE9wdGlvbnMsIHRhcmdldCApO1xyXG5cdFx0dmFyIGFwaSA9IHNjb3BlKCB0YXJnZXQsIG9wdGlvbnMsIG9yaWdpbmFsT3B0aW9ucyApO1xyXG5cclxuXHRcdHRhcmdldC5ub1VpU2xpZGVyID0gYXBpO1xyXG5cclxuXHRcdHJldHVybiBhcGk7XHJcblx0fVxyXG5cclxuXHQvLyBVc2UgYW4gb2JqZWN0IGluc3RlYWQgb2YgYSBmdW5jdGlvbiBmb3IgZnV0dXJlIGV4cGFuZGFiaWxpdHk7XHJcblx0cmV0dXJuIHtcclxuXHRcdHZlcnNpb246IFZFUlNJT04sXHJcblx0XHRjcmVhdGU6IGluaXRpYWxpemVcclxuXHR9O1xyXG5cclxufSkpOyIsIihmdW5jdGlvbiAoZ2xvYmFsKXtcblxyXG52YXIgJCBcdFx0XHRcdD0gKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKTtcclxudmFyIHN0YXRlIFx0XHRcdD0gcmVxdWlyZSgnLi9zdGF0ZScpO1xyXG52YXIgcHJvY2Vzc19mb3JtIFx0PSByZXF1aXJlKCcuL3Byb2Nlc3NfZm9ybScpO1xyXG52YXIgbm9VaVNsaWRlclx0XHQ9IHJlcXVpcmUoJ25vdWlzbGlkZXInKTtcclxuLy92YXIgY29va2llcyAgICAgICAgID0gcmVxdWlyZSgnanMtY29va2llJyk7XHJcbnZhciB0aGlyZFBhcnR5ICAgICAgPSByZXF1aXJlKCcuL3RoaXJkcGFydHknKTtcclxuXHJcbndpbmRvdy5zZWFyY2hBbmRGaWx0ZXIgPSB7XHJcbiAgICBleHRlbnNpb25zOiBbXSxcclxuICAgIHJlZ2lzdGVyRXh0ZW5zaW9uOiBmdW5jdGlvbiggZXh0ZW5zaW9uTmFtZSApIHtcclxuICAgICAgICB0aGlzLmV4dGVuc2lvbnMucHVzaCggZXh0ZW5zaW9uTmFtZSApO1xyXG4gICAgfVxyXG59O1xyXG5cclxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbihvcHRpb25zKVxyXG57XHJcbiAgICB2YXIgZGVmYXVsdHMgPSB7XHJcbiAgICAgICAgc3RhcnRPcGVuZWQ6IGZhbHNlLFxyXG4gICAgICAgIGlzSW5pdDogdHJ1ZSxcclxuICAgICAgICBhY3Rpb246IFwiXCJcclxuICAgIH07XHJcblxyXG4gICAgdmFyIG9wdHMgPSBqUXVlcnkuZXh0ZW5kKGRlZmF1bHRzLCBvcHRpb25zKTtcclxuICAgIFxyXG4gICAgdGhpcmRQYXJ0eS5pbml0KCk7XHJcbiAgICBcclxuICAgIC8vbG9vcCB0aHJvdWdoIGVhY2ggaXRlbSBtYXRjaGVkXHJcbiAgICB0aGlzLmVhY2goZnVuY3Rpb24oKVxyXG4gICAge1xyXG5cclxuICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICB0aGlzLnNmaWQgPSAkdGhpcy5hdHRyKFwiZGF0YS1zZi1mb3JtLWlkXCIpO1xyXG5cclxuICAgICAgICBzdGF0ZS5hZGRTZWFyY2hGb3JtKHRoaXMuc2ZpZCwgdGhpcyk7XHJcblxyXG4gICAgICAgIHRoaXMuJGZpZWxkcyA9ICR0aGlzLmZpbmQoXCI+IHVsID4gbGlcIik7IC8vYSByZWZlcmVuY2UgdG8gZWFjaCBmaWVsZHMgcGFyZW50IExJXHJcblxyXG4gICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gJHRoaXMuYXR0cignZGF0YS10YXhvbm9teS1hcmNoaXZlcycpO1xyXG4gICAgICAgIHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlID0gJHRoaXMuYXR0cignZGF0YS1jdXJyZW50LXRheG9ub215LWFyY2hpdmUnKTtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gXCIwXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBwcm9jZXNzX2Zvcm0uaW5pdChzZWxmLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcywgc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUpO1xyXG4gICAgICAgIC8vcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYpO1xyXG4gICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyA9IHthbGw6IHt9LCByZXN1bHRzOiB7fSwgYWpheDoge319O1xyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMudGVtcGxhdGVfaXNfbG9hZGVkID0gJHRoaXMuYXR0cihcImRhdGEtdGVtcGxhdGUtbG9hZGVkXCIpO1xyXG4gICAgICAgIHRoaXMuaXNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXhcIik7XHJcbiAgICAgICAgdGhpcy5pbnN0YW5jZV9udW1iZXIgPSAkdGhpcy5hdHRyKCdkYXRhLWluc3RhbmNlLWNvdW50Jyk7XHJcbiAgICAgICAgdGhpcy4kYWpheF9yZXN1bHRzX2NvbnRhaW5lciA9IGpRdWVyeSgkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXRhcmdldFwiKSk7XHJcblxyXG4gICAgICAgIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXVwZGF0ZS1zZWN0aW9uc1wiKSA/IEpTT04ucGFyc2UoICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdXBkYXRlLXNlY3Rpb25zXCIpICkgOiBbXTtcclxuICAgICAgICBcclxuICAgICAgICB0aGlzLnJlc3VsdHNfdXJsID0gJHRoaXMuYXR0cihcImRhdGEtcmVzdWx0cy11cmxcIik7XHJcbiAgICAgICAgdGhpcy5kZWJ1Z19tb2RlID0gJHRoaXMuYXR0cihcImRhdGEtZGVidWctbW9kZVwiKTtcclxuICAgICAgICB0aGlzLnVwZGF0ZV9hamF4X3VybCA9ICR0aGlzLmF0dHIoXCJkYXRhLXVwZGF0ZS1hamF4LXVybFwiKTtcclxuICAgICAgICB0aGlzLnBhZ2luYXRpb25fdHlwZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtcGFnaW5hdGlvbi10eXBlXCIpO1xyXG4gICAgICAgIHRoaXMuYXV0b19jb3VudCA9ICR0aGlzLmF0dHIoXCJkYXRhLWF1dG8tY291bnRcIik7XHJcbiAgICAgICAgdGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWF1dG8tY291bnQtcmVmcmVzaC1tb2RlXCIpO1xyXG4gICAgICAgIHRoaXMub25seV9yZXN1bHRzX2FqYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1vbmx5LXJlc3VsdHMtYWpheFwiKTsgLy9pZiB3ZSBhcmUgbm90IG9uIHRoZSByZXN1bHRzIHBhZ2UsIHJlZGlyZWN0IHJhdGhlciB0aGFuIHRyeSB0byBsb2FkIHZpYSBhamF4XHJcbiAgICAgICAgdGhpcy5zY3JvbGxfdG9fcG9zID0gJHRoaXMuYXR0cihcImRhdGEtc2Nyb2xsLXRvLXBvc1wiKTtcclxuICAgICAgICB0aGlzLmN1c3RvbV9zY3JvbGxfdG8gPSAkdGhpcy5hdHRyKFwiZGF0YS1jdXN0b20tc2Nyb2xsLXRvXCIpO1xyXG4gICAgICAgIHRoaXMuc2Nyb2xsX29uX2FjdGlvbiA9ICR0aGlzLmF0dHIoXCJkYXRhLXNjcm9sbC1vbi1hY3Rpb25cIik7XHJcbiAgICAgICAgdGhpcy5sYW5nX2NvZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1sYW5nLWNvZGVcIik7XHJcbiAgICAgICAgdGhpcy5hamF4X3VybCA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC11cmwnKTtcclxuICAgICAgICB0aGlzLmFqYXhfZm9ybV91cmwgPSAkdGhpcy5hdHRyKCdkYXRhLWFqYXgtZm9ybS11cmwnKTtcclxuICAgICAgICB0aGlzLmlzX3J0bCA9ICR0aGlzLmF0dHIoJ2RhdGEtaXMtcnRsJyk7XHJcblxyXG4gICAgICAgIHRoaXMuZGlzcGxheV9yZXN1bHRfbWV0aG9kID0gJHRoaXMuYXR0cignZGF0YS1kaXNwbGF5LXJlc3VsdC1tZXRob2QnKTtcclxuICAgICAgICB0aGlzLm1haW50YWluX3N0YXRlID0gJHRoaXMuYXR0cignZGF0YS1tYWludGFpbi1zdGF0ZScpO1xyXG4gICAgICAgIHRoaXMuYWpheF9hY3Rpb24gPSBcIlwiO1xyXG4gICAgICAgIHRoaXMubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zID0gXCJcIjtcclxuXHJcbiAgICAgICAgdGhpcy5jdXJyZW50X3BhZ2VkID0gcGFyc2VJbnQoJHRoaXMuYXR0cignZGF0YS1pbml0LXBhZ2VkJykpO1xyXG4gICAgICAgIHRoaXMubGFzdF9sb2FkX21vcmVfaHRtbCA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5sb2FkX21vcmVfaHRtbCA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5hamF4X2RhdGFfdHlwZSA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC1kYXRhLXR5cGUnKTtcclxuICAgICAgICB0aGlzLmFqYXhfdGFyZ2V0X2F0dHIgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXRhcmdldFwiKTtcclxuICAgICAgICB0aGlzLnVzZV9oaXN0b3J5X2FwaSA9ICR0aGlzLmF0dHIoXCJkYXRhLXVzZS1oaXN0b3J5LWFwaVwiKTtcclxuICAgICAgICB0aGlzLmlzX3N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgdGhpcy5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnVzZV9oaXN0b3J5X2FwaSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnVzZV9oaXN0b3J5X2FwaSA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5wYWdpbmF0aW9uX3R5cGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5wYWdpbmF0aW9uX3R5cGUgPSBcIm5vcm1hbFwiO1xyXG4gICAgICAgIH1cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5jdXJyZW50X3BhZ2VkKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuY3VycmVudF9wYWdlZCA9IDE7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5hamF4X3RhcmdldF9hdHRyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF90YXJnZXRfYXR0ciA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5hamF4X3VybCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmFqYXhfdXJsID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfZm9ybV91cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hamF4X2Zvcm1fdXJsID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnJlc3VsdHNfdXJsKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMucmVzdWx0c191cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuc2Nyb2xsX3RvX3Bvcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnNjcm9sbF90b19wb3MgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuc2Nyb2xsX29uX2FjdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnNjcm9sbF9vbl9hY3Rpb24gPSBcIlwiO1xyXG4gICAgICAgIH1cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5jdXN0b21fc2Nyb2xsX3RvKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuY3VzdG9tX3Njcm9sbF90byA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuJGN1c3RvbV9zY3JvbGxfdG8gPSBqUXVlcnkodGhpcy5jdXN0b21fc2Nyb2xsX3RvKTtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMudXBkYXRlX2FqYXhfdXJsKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMudXBkYXRlX2FqYXhfdXJsID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmRlYnVnX21vZGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5kZWJ1Z19tb2RlID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdGFyZ2V0X29iamVjdCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmFqYXhfdGFyZ2V0X29iamVjdCA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy50ZW1wbGF0ZV9pc19sb2FkZWQpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy50ZW1wbGF0ZV9pc19sb2FkZWQgPSBcIjBcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGUgPSBcIjBcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuYWpheF9saW5rc19zZWxlY3RvciA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtbGlua3Mtc2VsZWN0b3JcIik7XHJcblxyXG5cclxuICAgICAgICB0aGlzLmF1dG9fdXBkYXRlID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by11cGRhdGVcIik7XHJcbiAgICAgICAgdGhpcy5pbnB1dFRpbWVyID0gMDtcclxuXHJcbiAgICAgICAgdGhpcy5zZXRJbmZpbml0ZVNjcm9sbENvbnRhaW5lciA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIC8vIFdoZW4gd2UgbmF2aWdhdGUgYXdheSBmcm9tIHNlYXJjaCByZXN1bHRzLCBhbmQgdGhlbiBwcmVzcyBiYWNrLFxyXG4gICAgICAgICAgICAvLyBpc19tYXhfcGFnZWQgaXMgcmV0YWluZWQsIHNvIHdlIG9ubHkgd2FudCB0byBzZXQgaXQgdG8gZmFsc2UgaWZcclxuICAgICAgICAgICAgLy8gd2UgYXJlIGluaXRhbGl6aW5nIHRoZSByZXN1bHRzIHBhZ2UgdGhlIGZpcnN0IHRpbWUgLSBzbyBqdXN0IFxyXG4gICAgICAgICAgICAvLyBjaGVjayBpZiB0aGlzIHZhciBpcyB1bmRlZmluZWQgKGFzIGl0IHNob3VsZCBiZSBvbiBmaXJzdCB1c2UpO1xyXG4gICAgICAgICAgICBpZiAoIHR5cGVvZiAoIHRoaXMuaXNfbWF4X3BhZ2VkICkgPT09ICd1bmRlZmluZWQnICkge1xyXG4gICAgICAgICAgICAgICAgdGhpcy5pc19tYXhfcGFnZWQgPSBmYWxzZTsgLy9mb3IgbG9hZCBtb3JlIG9ubHksIG9uY2Ugd2UgZGV0ZWN0IHdlJ3JlIGF0IHRoZSBlbmQgc2V0IHRoaXMgdG8gdHJ1ZVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB0aGlzLnVzZV9zY3JvbGxfbG9hZGVyID0gJHRoaXMuYXR0cignZGF0YS1zaG93LXNjcm9sbC1sb2FkZXInKTtcclxuICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyID0gJHRoaXMuYXR0cignZGF0YS1pbmZpbml0ZS1zY3JvbGwtY29udGFpbmVyJyk7XHJcbiAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX3RyaWdnZXJfYW1vdW50ID0gJHRoaXMuYXR0cignZGF0YS1pbmZpbml0ZS1zY3JvbGwtdHJpZ2dlcicpO1xyXG4gICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MgPSAkdGhpcy5hdHRyKCdkYXRhLWluZmluaXRlLXNjcm9sbC1yZXN1bHQtY2xhc3MnKTtcclxuICAgICAgICAgICAgdGhpcy4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IHRoaXMuJGFqYXhfcmVzdWx0c19jb250YWluZXI7XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YodGhpcy5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSBqUXVlcnkoJHRoaXMuYXR0cignZGF0YS1pbmZpbml0ZS1zY3JvbGwtY29udGFpbmVyJykpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YodGhpcy5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMudXNlX3Njcm9sbF9sb2FkZXIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLnVzZV9zY3JvbGxfbG9hZGVyID0gMTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICB9O1xyXG4gICAgICAgIHRoaXMuc2V0SW5maW5pdGVTY3JvbGxDb250YWluZXIoKTtcclxuXHJcbiAgICAgICAgLyogZnVuY3Rpb25zICovXHJcblxyXG4gICAgICAgIHRoaXMucmVzZXQgPSBmdW5jdGlvbihzdWJtaXRfZm9ybSlcclxuICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICB0aGlzLnJlc2V0Rm9ybShzdWJtaXRfZm9ybSk7XHJcbiAgICAgICAgICAgIHJldHVybiB0cnVlO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5pbnB1dFVwZGF0ZSA9IGZ1bmN0aW9uKGRlbGF5RHVyYXRpb24pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZih0eXBlb2YoZGVsYXlEdXJhdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkZWxheUR1cmF0aW9uID0gMzAwO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLnJlc2V0VGltZXIoZGVsYXlEdXJhdGlvbik7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnNjcm9sbFRvUG9zID0gZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgIHZhciBvZmZzZXQgPSAwO1xyXG4gICAgICAgICAgICB2YXIgY2FuU2Nyb2xsID0gdHJ1ZTtcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cIndpbmRvd1wiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIG9mZnNldCA9IDA7XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZSBpZihzZWxmLnNjcm9sbF90b19wb3M9PVwiZm9ybVwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIG9mZnNldCA9ICR0aGlzLm9mZnNldCgpLnRvcDtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cInJlc3VsdHNcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgb2Zmc2V0ID0gc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5vZmZzZXQoKS50b3A7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZSBpZihzZWxmLnNjcm9sbF90b19wb3M9PVwiY3VzdG9tXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9jdXN0b21fc2Nyb2xsX3RvXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi4kY3VzdG9tX3Njcm9sbF90by5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9mZnNldCA9IHNlbGYuJGN1c3RvbV9zY3JvbGxfdG8ub2Zmc2V0KCkudG9wO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBjYW5TY3JvbGwgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZihjYW5TY3JvbGwpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgJChcImh0bWwsIGJvZHlcIikuc3RvcCgpLmFuaW1hdGUoe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzY3JvbGxUb3A6IG9mZnNldFxyXG4gICAgICAgICAgICAgICAgICAgIH0sIFwibm9ybWFsXCIsIFwiZWFzZU91dFF1YWRcIiApO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuYXR0YWNoQWN0aXZlQ2xhc3MgPSBmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgLy9jaGVjayB0byBzZWUgaWYgd2UgYXJlIHVzaW5nIGFqYXggJiBhdXRvIGNvdW50XHJcbiAgICAgICAgICAgIC8vaWYgbm90LCB0aGUgc2VhcmNoIGZvcm0gZG9lcyBub3QgZ2V0IHJlbG9hZGVkLCBzbyB3ZSBuZWVkIHRvIHVwZGF0ZSB0aGUgc2Ytb3B0aW9uLWFjdGl2ZSBjbGFzcyBvbiBhbGwgZmllbGRzXHJcblxyXG4gICAgICAgICAgICAkdGhpcy5vbignY2hhbmdlJywgJ2lucHV0W3R5cGU9XCJyYWRpb1wiXSwgaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdLCBzZWxlY3QnLCBmdW5jdGlvbihlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGN0aGlzID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgIHZhciAkY3RoaXNfcGFyZW50ID0gJGN0aGlzLmNsb3Nlc3QoXCJsaVtkYXRhLXNmLWZpZWxkLW5hbWVdXCIpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHRoaXNfdGFnID0gJGN0aGlzLnByb3AoXCJ0YWdOYW1lXCIpLnRvTG93ZXJDYXNlKCk7XHJcbiAgICAgICAgICAgICAgICB2YXIgaW5wdXRfdHlwZSA9ICRjdGhpcy5hdHRyKFwidHlwZVwiKTtcclxuICAgICAgICAgICAgICAgIHZhciBwYXJlbnRfdGFnID0gJGN0aGlzX3BhcmVudC5wcm9wKFwidGFnTmFtZVwiKS50b0xvd2VyQ2FzZSgpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCh0aGlzX3RhZz09XCJpbnB1dFwiKSYmKChpbnB1dF90eXBlPT1cInJhZGlvXCIpfHwoaW5wdXRfdHlwZT09XCJjaGVja2JveFwiKSkgJiYgKHBhcmVudF90YWc9PVwibGlcIikpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRhbGxfb3B0aW9ucyA9ICRjdGhpc19wYXJlbnQucGFyZW50KCkuZmluZCgnbGknKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGFsbF9vcHRpb25zX2ZpZWxkcyA9ICRjdGhpc19wYXJlbnQucGFyZW50KCkuZmluZCgnaW5wdXQ6Y2hlY2tlZCcpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnMucmVtb3ZlQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICRhbGxfb3B0aW9uc19maWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRwYXJlbnQgPSAkKHRoaXMpLmNsb3Nlc3QoXCJsaVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHBhcmVudC5hZGRDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYodGhpc190YWc9PVwic2VsZWN0XCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRhbGxfb3B0aW9ucyA9ICRjdGhpcy5jaGlsZHJlbigpO1xyXG4gICAgICAgICAgICAgICAgICAgICRhbGxfb3B0aW9ucy5yZW1vdmVDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRoaXNfdmFsID0gJGN0aGlzLnZhbCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgdGhpc19hcnJfdmFsID0gKHR5cGVvZiB0aGlzX3ZhbCA9PSAnc3RyaW5nJyB8fCB0aGlzX3ZhbCBpbnN0YW5jZW9mIFN0cmluZykgPyBbdGhpc192YWxdIDogdGhpc192YWw7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICQodGhpc19hcnJfdmFsKS5lYWNoKGZ1bmN0aW9uKGksIHZhbHVlKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGN0aGlzLmZpbmQoXCJvcHRpb25bdmFsdWU9J1wiK3ZhbHVlK1wiJ11cIikuYWRkQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9O1xyXG4gICAgICAgIHRoaXMuaW5pdEF1dG9VcGRhdGVFdmVudHMgPSBmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgLyogYXV0byB1cGRhdGUgKi9cclxuICAgICAgICAgICAgaWYoKHNlbGYuYXV0b191cGRhdGU9PTEpfHwoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdjaGFuZ2UnLCAnaW5wdXRbdHlwZT1cInJhZGlvXCJdLCBpbnB1dFt0eXBlPVwiY2hlY2tib3hcIl0sIHNlbGVjdCcsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDIwMCk7XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignaW5wdXQnLCAnaW5wdXRbdHlwZT1cIm51bWJlclwiXScsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDgwMCk7XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJHRleHRJbnB1dCA9ICR0aGlzLmZpbmQoJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOm5vdCguc2YtZGF0ZXBpY2tlciknKTtcclxuICAgICAgICAgICAgICAgIHZhciBsYXN0VmFsdWUgPSAkdGV4dElucHV0LnZhbCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJywgZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKGxhc3RWYWx1ZSE9JHRleHRJbnB1dC52YWwoKSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMTIwMCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBsYXN0VmFsdWUgPSAkdGV4dElucHV0LnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdrZXlwcmVzcycsICdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJywgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoZS53aGljaCA9PSAxMyl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vJHRoaXMub24oJ2lucHV0JywgJ2lucHV0LnNmLWRhdGVwaWNrZXInLCBzZWxmLmRhdGVJbnB1dFR5cGUpO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIC8vdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cygpO1xyXG5cclxuXHJcbiAgICAgICAgdGhpcy5jbGVhclRpbWVyID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgY2xlYXJUaW1lb3V0KHNlbGYuaW5wdXRUaW1lcik7XHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLnJlc2V0VGltZXIgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgY2xlYXJUaW1lb3V0KHNlbGYuaW5wdXRUaW1lcik7XHJcbiAgICAgICAgICAgIHNlbGYuaW5wdXRUaW1lciA9IHNldFRpbWVvdXQoc2VsZi5mb3JtVXBkYXRlZCwgZGVsYXlEdXJhdGlvbik7XHJcblxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuYWRkRGF0ZVBpY2tlcnMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJGRhdGVfcGlja2VyID0gJHRoaXMuZmluZChcIi5zZi1kYXRlcGlja2VyXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJGRhdGVfcGlja2VyLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkZGF0ZV9waWNrZXIuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRm9ybWF0ID0gXCJcIjtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZURyb3Bkb3duWWVhciA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRHJvcGRvd25Nb250aCA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGNsb3Nlc3RfZGF0ZV93cmFwID0gJHRoaXMuY2xvc2VzdChcIi5zZl9kYXRlX2ZpZWxkXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKCRjbG9zZXN0X2RhdGVfd3JhcC5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVGb3JtYXQgPSAkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS1mb3JtYXRcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS11c2UteWVhci1kcm9wZG93blwiKT09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZURyb3Bkb3duWWVhciA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtdXNlLW1vbnRoLWRyb3Bkb3duXCIpPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkYXRlRHJvcGRvd25Nb250aCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlUGlja2VyT3B0aW9ucyA9IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaW5saW5lOiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzaG93T3RoZXJNb250aHM6IHRydWUsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9uU2VsZWN0OiBmdW5jdGlvbihlLCBmcm9tX2ZpZWxkKXsgc2VsZi5kYXRlU2VsZWN0KGUsIGZyb21fZmllbGQsICQodGhpcykpOyB9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlRm9ybWF0OiBkYXRlRm9ybWF0LFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgY2hhbmdlTW9udGg6IGRhdGVEcm9wZG93bk1vbnRoLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjaGFuZ2VZZWFyOiBkYXRlRHJvcGRvd25ZZWFyXHJcbiAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlUGlja2VyT3B0aW9ucy5kaXJlY3Rpb24gPSBcInJ0bFwiO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJHRoaXMuZGF0ZXBpY2tlcihkYXRlUGlja2VyT3B0aW9ucyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYubGFuZ19jb2RlIT1cIlwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnNldERlZmF1bHRzKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5leHRlbmQoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeydkYXRlRm9ybWF0JzpkYXRlRm9ybWF0fSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIucmVnaW9uYWxbIHNlbGYubGFuZ19jb2RlXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICApO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnNldERlZmF1bHRzKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5leHRlbmQoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeydkYXRlRm9ybWF0JzpkYXRlRm9ybWF0fSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIucmVnaW9uYWxbXCJlblwiXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICApO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJCgnLmxsLXNraW4tbWVsb24nKS5sZW5ndGg9PTApe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkZGF0ZV9waWNrZXIuZGF0ZXBpY2tlcignd2lkZ2V0Jykud3JhcCgnPGRpdiBjbGFzcz1cImxsLXNraW4tbWVsb24gc2VhcmNoYW5kZmlsdGVyLWRhdGUtcGlja2VyXCIvPicpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZGF0ZVNlbGVjdCA9IGZ1bmN0aW9uKGUsIGZyb21fZmllbGQsICR0aGlzKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRpbnB1dF9maWVsZCA9ICQoZnJvbV9maWVsZC5pbnB1dC5nZXQoMCkpO1xyXG4gICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgdmFyICRkYXRlX2ZpZWxkcyA9ICRpbnB1dF9maWVsZC5jbG9zZXN0KCdbZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlPVwiZGF0ZXJhbmdlXCJdLCBbZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlPVwiZGF0ZVwiXScpO1xyXG4gICAgICAgICAgICAkZGF0ZV9maWVsZHMuZWFjaChmdW5jdGlvbihlLCBpbmRleCl7XHJcbiAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgICAgIHZhciAkdGZfZGF0ZV9waWNrZXJzID0gJCh0aGlzKS5maW5kKFwiLnNmLWRhdGVwaWNrZXJcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgbm9fZGF0ZV9waWNrZXJzID0gJHRmX2RhdGVfcGlja2Vycy5sZW5ndGg7XHJcbiAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgICAgIGlmKG5vX2RhdGVfcGlja2Vycz4xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vdGhlbiBpdCBpcyBhIGRhdGUgcmFuZ2UsIHNvIG1ha2Ugc3VyZSBib3RoIGZpZWxkcyBhcmUgZmlsbGVkIGJlZm9yZSB1cGRhdGluZ1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkcF9jb3VudGVyID0gMDtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfZW1wdHlfZmllbGRfY291bnQgPSAwO1xyXG4gICAgICAgICAgICAgICAgICAgICR0Zl9kYXRlX3BpY2tlcnMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJCh0aGlzKS52YWwoKT09XCJcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZHBfZW1wdHlfZmllbGRfY291bnQrKztcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgZHBfY291bnRlcisrO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihkcF9lbXB0eV9maWVsZF9jb3VudD09MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmFkZFJhbmdlU2xpZGVycyA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciAkbWV0YV9yYW5nZSA9ICR0aGlzLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XHJcblxyXG4gICAgICAgICAgICBpZigkbWV0YV9yYW5nZS5sZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJG1ldGFfcmFuZ2UuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW4gPSAkdGhpcy5hdHRyKFwiZGF0YS1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1heCA9ICR0aGlzLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc21pbiA9ICR0aGlzLmF0dHIoXCJkYXRhLXN0YXJ0LW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc21heCA9ICR0aGlzLmF0dHIoXCJkYXRhLXN0YXJ0LW1heFwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGlzcGxheV92YWx1ZV9hcyA9ICR0aGlzLmF0dHIoXCJkYXRhLWRpc3BsYXktdmFsdWVzLWFzXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGVwID0gJHRoaXMuYXR0cihcImRhdGEtc3RlcFwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHN0YXJ0X3ZhbCA9ICR0aGlzLmZpbmQoJy5zZi1yYW5nZS1taW4nKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGVuZF92YWwgPSAkdGhpcy5maW5kKCcuc2YtcmFuZ2UtbWF4Jyk7XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGVjaW1hbF9wbGFjZXMgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWNpbWFsLXBsYWNlc1wiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgdGhvdXNhbmRfc2VwZXJhdG9yID0gJHRoaXMuYXR0cihcImRhdGEtdGhvdXNhbmQtc2VwZXJhdG9yXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkZWNpbWFsX3NlcGVyYXRvciA9ICR0aGlzLmF0dHIoXCJkYXRhLWRlY2ltYWwtc2VwZXJhdG9yXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRfZm9ybWF0ID0gd051bWIoe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBtYXJrOiBkZWNpbWFsX3NlcGVyYXRvcixcclxuICAgICAgICAgICAgICAgICAgICAgICAgZGVjaW1hbHM6IHBhcnNlRmxvYXQoZGVjaW1hbF9wbGFjZXMpLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aG91c2FuZDogdGhvdXNhbmRfc2VwZXJhdG9yXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1pbl91bmZvcm1hdHRlZCA9IHBhcnNlRmxvYXQoc21pbik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1pbl9mb3JtYXR0ZWQgPSBmaWVsZF9mb3JtYXQudG8ocGFyc2VGbG9hdChzbWluKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1heF9mb3JtYXR0ZWQgPSBmaWVsZF9mb3JtYXQudG8ocGFyc2VGbG9hdChzbWF4KSk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1heF91bmZvcm1hdHRlZCA9IHBhcnNlRmxvYXQoc21heCk7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9hbGVydChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KG1heF9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQoZGlzcGxheV92YWx1ZV9hcyk7XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRpbnB1dFwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC52YWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLnZhbChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwuaHRtbChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwuaHRtbChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgbm9VSU9wdGlvbnMgPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJhbmdlOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnbWluJzogWyBwYXJzZUZsb2F0KG1pbikgXSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICdtYXgnOiBbIHBhcnNlRmxvYXQobWF4KSBdXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0YXJ0OiBbbWluX2Zvcm1hdHRlZCwgbWF4X2Zvcm1hdHRlZF0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGhhbmRsZXM6IDIsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNvbm5lY3Q6IHRydWUsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0ZXA6IHBhcnNlRmxvYXQoc3RlcCksXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBiZWhhdmlvdXI6ICdleHRlbmQtdGFwJyxcclxuICAgICAgICAgICAgICAgICAgICAgICAgZm9ybWF0OiBmaWVsZF9mb3JtYXRcclxuICAgICAgICAgICAgICAgICAgICB9O1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgbm9VSU9wdGlvbnMuZGlyZWN0aW9uID0gXCJydGxcIjtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfb2JqZWN0ID0gJCh0aGlzKS5maW5kKFwiLm1ldGEtc2xpZGVyXCIpWzBdO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiggXCJ1bmRlZmluZWRcIiAhPT0gdHlwZW9mKCBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIgKSApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9kZXN0cm95IGlmIGl0IGV4aXN0cy4uIHRoaXMgbWVhbnMgc29tZWhvdyBhbm90aGVyIGluc3RhbmNlIGhhZCBpbml0aWFsaXNlZCBpdC4uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5kZXN0cm95KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBub1VpU2xpZGVyLmNyZWF0ZShzbGlkZXJfb2JqZWN0LCBub1VJT3B0aW9ucyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwub2ZmKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5vbignY2hhbmdlJywgZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbJCh0aGlzKS52YWwoKSwgbnVsbF0pO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5vZmYoKTtcclxuICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5vbignY2hhbmdlJywgZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbbnVsbCwgJCh0aGlzKS52YWwoKV0pO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvLyRzdGFydF92YWwuaHRtbChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAvLyRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5vZmYoJ3VwZGF0ZScpO1xyXG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5vbigndXBkYXRlJywgZnVuY3Rpb24oIHZhbHVlcywgaGFuZGxlICkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9zdGFydF92YWwgID0gbWluX2Zvcm1hdHRlZDtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9lbmRfdmFsICA9IG1heF9mb3JtYXR0ZWQ7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWUgPSB2YWx1ZXNbaGFuZGxlXTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAoIGhhbmRsZSApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1heF9mb3JtYXR0ZWQgPSB2YWx1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1pbl9mb3JtYXR0ZWQgPSB2YWx1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0aW5wdXRcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC52YWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC52YWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5odG1sKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwuaHRtbChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaSB0aGluayB0aGUgZnVuY3Rpb24gdGhhdCBidWlsZHMgdGhlIFVSTCBuZWVkcyB0byBkZWNvZGUgdGhlIGZvcm1hdHRlZCBzdHJpbmcgYmVmb3JlIGFkZGluZyB0byB0aGUgdXJsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL29ubHkgdHJ5IHRvIHVwZGF0ZSBpZiB0aGUgdmFsdWVzIGhhdmUgYWN0dWFsbHkgY2hhbmdlZFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHNsaWRlcl9zdGFydF92YWwhPW1pbl9mb3JtYXR0ZWQpfHwoc2xpZGVyX2VuZF92YWwhPW1heF9mb3JtYXR0ZWQpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoODAwKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpOyAvL2lnbm9yZSBhbnkgY2hhbmdlcyByZWNlbnRseSBtYWRlIGJ5IHRoZSBzbGlkZXIgKHRoaXMgd2FzIGp1c3QgaW5pdCBzaG91bGRuJ3QgY291bnQgYXMgYW4gdXBkYXRlIGV2ZW50KVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5pbml0ID0gZnVuY3Rpb24oa2VlcF9wYWdpbmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGtlZXBfcGFnaW5hdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBrZWVwX3BhZ2luYXRpb24gPSBmYWxzZTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cygpO1xyXG4gICAgICAgICAgICB0aGlzLmF0dGFjaEFjdGl2ZUNsYXNzKCk7XHJcblxyXG4gICAgICAgICAgICB0aGlzLmFkZERhdGVQaWNrZXJzKCk7XHJcbiAgICAgICAgICAgIHRoaXMuYWRkUmFuZ2VTbGlkZXJzKCk7XHJcblxyXG4gICAgICAgICAgICAvL2luaXQgY29tYm8gYm94ZXNcclxuICAgICAgICAgICAgdmFyICRjb21ib2JveCA9ICR0aGlzLmZpbmQoXCJzZWxlY3RbZGF0YS1jb21ib2JveD0nMSddXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJGNvbWJvYm94Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkY29tYm9ib3guZWFjaChmdW5jdGlvbihpbmRleCApe1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkdGhpc2NiID0gJCggdGhpcyApO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBucm0gPSAkdGhpc2NiLmF0dHIoXCJkYXRhLWNvbWJvYm94LW5ybVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHR5cGVvZiAkdGhpc2NiLmNob3NlbiAhPSBcInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGNob3Nlbm9wdGlvbnMgPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWFyY2hfY29udGFpbnM6IHRydWVcclxuICAgICAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCh0eXBlb2YobnJtKSE9PVwidW5kZWZpbmVkXCIpJiYobnJtKSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjaG9zZW5vcHRpb25zLm5vX3Jlc3VsdHNfdGV4dCA9IG5ybTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyBzYWZlIHRvIHVzZSB0aGUgZnVuY3Rpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9zZWFyY2hfY29udGFpbnNcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzY2IuYWRkQ2xhc3MoXCJjaG9zZW4tcnRsXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLmNob3NlbihjaG9zZW5vcHRpb25zKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzZWxlY3Qyb3B0aW9ucyA9IHt9O1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGVjdDJvcHRpb25zLmRpciA9IFwicnRsXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHR5cGVvZihucm0pIT09XCJ1bmRlZmluZWRcIikmJihucm0pKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGVjdDJvcHRpb25zLmxhbmd1YWdlPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJub1Jlc3VsdHNcIjogZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIG5ybTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9O1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLnNlbGVjdDIoc2VsZWN0Mm9wdGlvbnMpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgLy9pZiBhamF4IGlzIGVuYWJsZWQgaW5pdCB0aGUgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAkdGhpcy5vbihcInN1Ym1pdFwiLCB0aGlzLnN1Ym1pdEZvcm0pO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5pbml0V29vQ29tbWVyY2VDb250cm9scygpOyAvL3dvb2NvbW1lcmNlIG9yZGVyYnlcclxuXHJcbiAgICAgICAgICAgIGlmKGtlZXBfcGFnaW5hdGlvbj09ZmFsc2UpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLm9uV2luZG93U2Nyb2xsID0gZnVuY3Rpb24oZXZlbnQpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZigoIXNlbGYuaXNfbG9hZGluZ19tb3JlKSAmJiAoIXNlbGYuaXNfbWF4X3BhZ2VkKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHdpbmRvd19zY3JvbGwgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XHJcbiAgICAgICAgICAgICAgICB2YXIgd2luZG93X3Njcm9sbF9ib3R0b20gPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCkgKyAkKHdpbmRvdykuaGVpZ2h0KCk7XHJcbiAgICAgICAgICAgICAgICB2YXIgc2Nyb2xsX29mZnNldCA9IHBhcnNlSW50KHNlbGYuaW5maW5pdGVfc2Nyb2xsX3RyaWdnZXJfYW1vdW50KTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmxlbmd0aD09MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c19zY3JvbGxfYm90dG9tID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5vZmZzZXQoKS50b3AgKyBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmhlaWdodCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgb2Zmc2V0ID0gKHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIub2Zmc2V0KCkudG9wICsgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5oZWlnaHQoKSkgLSB3aW5kb3dfc2Nyb2xsO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZih3aW5kb3dfc2Nyb2xsX2JvdHRvbSA+IHJlc3VsdHNfc2Nyb2xsX2JvdHRvbSArIHNjcm9sbF9vZmZzZXQpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmxvYWRNb3JlUmVzdWx0cygpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAgey8vZG9udCBsb2FkIG1vcmVcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnN0cmlwUXVlcnlTdHJpbmdBbmRIYXNoRnJvbVBhdGggPSBmdW5jdGlvbih1cmwpIHtcclxuICAgICAgICAgICAgcmV0dXJuIHVybC5zcGxpdChcIj9cIilbMF0uc3BsaXQoXCIjXCIpWzBdO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5ndXAgPSBmdW5jdGlvbiggbmFtZSwgdXJsICkge1xyXG4gICAgICAgICAgICBpZiAoIXVybCkgdXJsID0gbG9jYXRpb24uaHJlZlxyXG4gICAgICAgICAgICBuYW1lID0gbmFtZS5yZXBsYWNlKC9bXFxbXS8sXCJcXFxcXFxbXCIpLnJlcGxhY2UoL1tcXF1dLyxcIlxcXFxcXF1cIik7XHJcbiAgICAgICAgICAgIHZhciByZWdleFMgPSBcIltcXFxcPyZdXCIrbmFtZStcIj0oW14mI10qKVwiO1xyXG4gICAgICAgICAgICB2YXIgcmVnZXggPSBuZXcgUmVnRXhwKCByZWdleFMgKTtcclxuICAgICAgICAgICAgdmFyIHJlc3VsdHMgPSByZWdleC5leGVjKCB1cmwgKTtcclxuICAgICAgICAgICAgcmV0dXJuIHJlc3VsdHMgPT0gbnVsbCA/IG51bGwgOiByZXN1bHRzWzFdO1xyXG4gICAgICAgIH07XHJcblxyXG5cclxuICAgICAgICB0aGlzLmdldFVybFBhcmFtcyA9IGZ1bmN0aW9uKGtlZXBfcGFnaW5hdGlvbiwgdHlwZSwgZXhjbHVkZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihrZWVwX3BhZ2luYXRpb24pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIga2VlcF9wYWdpbmF0aW9uID0gdHJ1ZTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHR5cGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgdHlwZSA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciB1cmxfcGFyYW1zX3N0ciA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICAvLyBnZXQgYWxsIHBhcmFtcyBmcm9tIGZpZWxkc1xyXG4gICAgICAgICAgICB2YXIgdXJsX3BhcmFtc19hcnJheSA9IHByb2Nlc3NfZm9ybS5nZXRVcmxQYXJhbXMoc2VsZik7XHJcblxyXG4gICAgICAgICAgICB2YXIgbGVuZ3RoID0gT2JqZWN0LmtleXModXJsX3BhcmFtc19hcnJheSkubGVuZ3RoO1xyXG4gICAgICAgICAgICB2YXIgY291bnQgPSAwO1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKGV4Y2x1ZGUpIT1cInVuZGVmaW5lZFwiKSB7XHJcbiAgICAgICAgICAgICAgICBpZiAodXJsX3BhcmFtc19hcnJheS5oYXNPd25Qcm9wZXJ0eShleGNsdWRlKSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGxlbmd0aC0tO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihsZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgZm9yICh2YXIgayBpbiB1cmxfcGFyYW1zX2FycmF5KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHVybF9wYXJhbXNfYXJyYXkuaGFzT3duUHJvcGVydHkoaykpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBjYW5fYWRkID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYodHlwZW9mKGV4Y2x1ZGUpIT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZihrPT1leGNsdWRlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FuX2FkZCA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihjYW5fYWRkKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB1cmxfcGFyYW1zX3N0ciArPSBrICsgXCI9XCIgKyB1cmxfcGFyYW1zX2FycmF5W2tdO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChjb3VudCA8IGxlbmd0aCAtIDEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB1cmxfcGFyYW1zX3N0ciArPSBcIiZcIjtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb3VudCsrO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIC8vZm9ybSBwYXJhbXMgYXMgdXJsIHF1ZXJ5IHN0cmluZ1xyXG4gICAgICAgICAgICB2YXIgZm9ybV9wYXJhbXMgPSB1cmxfcGFyYW1zX3N0cjtcclxuXHJcbiAgICAgICAgICAgIC8vZ2V0IHVybCBwYXJhbXMgZnJvbSB0aGUgZm9ybSBpdHNlbGYgKHdoYXQgdGhlIHVzZXIgaGFzIHNlbGVjdGVkKVxyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIGZvcm1fcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIC8vYWRkIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgaWYoa2VlcF9wYWdpbmF0aW9uPT10cnVlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKHBhZ2VOdW1iZXIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHBhZ2VOdW1iZXIgPSAxO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKHBhZ2VOdW1iZXI+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrcGFnZU51bWJlcik7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIC8vYWRkIHNmaWRcclxuICAgICAgICAgICAgLy9xdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZpZD1cIitzZWxmLnNmaWQpO1xyXG5cclxuICAgICAgICAgICAgLy8gbG9vcCB0aHJvdWdoIGFueSBleHRyYSBwYXJhbXMgKGZyb20gZXh0IHBsdWdpbnMpIGFuZCBhZGQgdG8gdGhlIHVybCAoaWUgd29vY29tbWVyY2UgYG9yZGVyYnlgKVxyXG4gICAgICAgICAgICAvKnZhciBleHRyYV9xdWVyeV9wYXJhbSA9IFwiXCI7XHJcbiAgICAgICAgICAgICB2YXIgbGVuZ3RoID0gT2JqZWN0LmtleXMoc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMpLmxlbmd0aDtcclxuICAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XHJcblxyXG4gICAgICAgICAgICAgaWYobGVuZ3RoPjApXHJcbiAgICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgZm9yICh2YXIgayBpbiBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcykge1xyXG4gICAgICAgICAgICAgaWYgKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zLmhhc093blByb3BlcnR5KGspKSB7XHJcblxyXG4gICAgICAgICAgICAgaWYoc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNba10hPVwiXCIpXHJcbiAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICBleHRyYV9xdWVyeV9wYXJhbSA9IGsrXCI9XCIrc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNba107XHJcbiAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIGV4dHJhX3F1ZXJ5X3BhcmFtKTtcclxuICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICovXHJcbiAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuYWRkUXVlcnlQYXJhbXMocXVlcnlfcGFyYW1zLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5hbGwpO1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZSE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9xdWVyeV9wYXJhbXMgPSBzZWxmLmFkZFF1ZXJ5UGFyYW1zKHF1ZXJ5X3BhcmFtcywgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNbdHlwZV0pO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gcXVlcnlfcGFyYW1zO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmFkZFF1ZXJ5UGFyYW1zID0gZnVuY3Rpb24ocXVlcnlfcGFyYW1zLCBuZXdfcGFyYW1zKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIGV4dHJhX3F1ZXJ5X3BhcmFtID0gXCJcIjtcclxuICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKG5ld19wYXJhbXMpLmxlbmd0aDtcclxuICAgICAgICAgICAgdmFyIGNvdW50ID0gMDtcclxuXHJcbiAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgICAgZm9yICh2YXIgayBpbiBuZXdfcGFyYW1zKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKG5ld19wYXJhbXMuaGFzT3duUHJvcGVydHkoaykpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKG5ld19wYXJhbXNba10hPVwiXCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGV4dHJhX3F1ZXJ5X3BhcmFtID0gaytcIj1cIituZXdfcGFyYW1zW2tdO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBleHRyYV9xdWVyeV9wYXJhbSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBxdWVyeV9wYXJhbXM7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuYWRkVXJsUGFyYW0gPSBmdW5jdGlvbih1cmwsIHN0cmluZylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBhZGRfcGFyYW1zID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIGlmKHVybCE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgaWYodXJsLmluZGV4T2YoXCI/XCIpICE9IC0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGFkZF9wYXJhbXMgKz0gXCImXCI7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy91cmwgPSB0aGlzLnRyYWlsaW5nU2xhc2hJdCh1cmwpO1xyXG4gICAgICAgICAgICAgICAgICAgIGFkZF9wYXJhbXMgKz0gXCI/XCI7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHN0cmluZyE9XCJcIilcclxuICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgIHJldHVybiB1cmwgKyBhZGRfcGFyYW1zICsgc3RyaW5nO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIHVybDtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuam9pblVybFBhcmFtID0gZnVuY3Rpb24ocGFyYW1zLCBzdHJpbmcpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgYWRkX3BhcmFtcyA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICBpZihwYXJhbXMhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGFkZF9wYXJhbXMgKz0gXCImXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHN0cmluZyE9XCJcIilcclxuICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgIHJldHVybiBwYXJhbXMgKyBhZGRfcGFyYW1zICsgc3RyaW5nO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIHBhcmFtcztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuc2V0QWpheFJlc3VsdHNVUkxzID0gZnVuY3Rpb24ocXVlcnlfcGFyYW1zKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKHNlbGYuYWpheF9yZXN1bHRzX2NvbmYpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBcIlwiO1xyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gXCJcIjtcclxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgLy9pZihzZWxmLmFqYXhfdXJsIT1cIlwiKVxyXG4gICAgICAgICAgICBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJzaG9ydGNvZGVcIilcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3YW50IHRvIGRvIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludFxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5yZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL2FkZCBsYW5nIGNvZGUgdG8gYWpheCBhcGkgcmVxdWVzdCwgbGFuZyBjb2RlIHNob3VsZCBhbHJlYWR5IGJlIGluIHRoZXJlIGZvciBvdGhlciByZXF1ZXN0cyAoaWUsIHN1cHBsaWVkIGluIHRoZSBSZXN1bHRzIFVSTClcclxuXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3NvIGFkZCBpdFxyXG4gICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJsYW5nPVwiK3NlbGYubGFuZ19jb2RlKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLmFqYXhfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXSA9ICdqc29uJztcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJwb3N0X3R5cGVfYXJjaGl2ZVwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cImN1c3RvbV93b29jb21tZXJjZV9zdG9yZVwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHsvL290aGVyd2lzZSB3ZSB3YW50IHRvIHB1bGwgdGhlIHJlc3VsdHMgZGlyZWN0bHkgZnJvbSB0aGUgcmVzdWx0cyBwYWdlXHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLnJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5hamF4X3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIC8vc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSAnaHRtbCc7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFF1ZXJ5UGFyYW1zKHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10sIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zWydhamF4J10pO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSBzZWxmLmFqYXhfZGF0YV90eXBlO1xyXG4gICAgICAgIH07XHJcblxyXG5cclxuXHJcbiAgICAgICAgdGhpcy51cGRhdGVMb2FkZXJUYWcgPSBmdW5jdGlvbigkb2JqZWN0LCB0YWdOYW1lKSB7XHJcblxyXG4gICAgICAgICAgICB2YXIgJHBhcmVudDtcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJHBhcmVudCA9IHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpLmxhc3QoKS5wYXJlbnQoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRwYXJlbnQgPSBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgdGFnTmFtZSA9ICRwYXJlbnQucHJvcChcInRhZ05hbWVcIik7XHJcblxyXG4gICAgICAgICAgICB2YXIgdGFnVHlwZSA9ICdkaXYnO1xyXG4gICAgICAgICAgICBpZiggKCB0YWdOYW1lLnRvTG93ZXJDYXNlKCkgPT0gJ29sJyApIHx8ICggdGFnTmFtZS50b0xvd2VyQ2FzZSgpID09ICd1bCcgKSApe1xyXG4gICAgICAgICAgICAgICAgdGFnVHlwZSA9ICdsaSc7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciAkbmV3ID0gJCgnPCcrdGFnVHlwZSsnIC8+JykuaHRtbCgkb2JqZWN0Lmh0bWwoKSk7XHJcbiAgICAgICAgICAgIHZhciBhdHRyaWJ1dGVzID0gJG9iamVjdC5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuXHJcbiAgICAgICAgICAgIC8vIGxvb3AgdGhyb3VnaCA8c2VsZWN0PiBhdHRyaWJ1dGVzIGFuZCBhcHBseSB0aGVtIG9uIDxkaXY+XHJcbiAgICAgICAgICAgICQuZWFjaChhdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICRuZXcuYXR0cih0aGlzLm5hbWUsIHRoaXMudmFsdWUpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgIHJldHVybiAkbmV3O1xyXG5cclxuICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB0aGlzLmxvYWRNb3JlUmVzdWx0cyA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmICggdGhpcy5pc19tYXhfcGFnZWQgPT09IHRydWUgKSB7XHJcbiAgICAgICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgc2VsZi5pc19sb2FkaW5nX21vcmUgPSB0cnVlO1xyXG5cclxuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XHJcbiAgICAgICAgICAgIHZhciBldmVudF9kYXRhID0ge1xyXG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxyXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcclxuICAgICAgICAgICAgICAgIHR5cGU6IFwibG9hZF9tb3JlXCIsXHJcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheHN0YXJ0XCIsIGV2ZW50X2RhdGEpO1xyXG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKFwibG9hZCBtb3JlIHJlc3VsdHNcIik7XHJcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKFwicmVzdWx0cyB1cmw6IFwiK3NlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSk7XHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpOyAvL2dyYWIgYSBjb3B5IG9mIGh0ZSBVUkwgcGFyYW1zIHdpdGhvdXQgcGFnaW5hdGlvbiBhbHJlYWR5IGFkZGVkXHJcblxyXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBhamF4X3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwiXCI7XHJcblxyXG5cclxuICAgICAgICAgICAgLy9ub3cgYWRkIHRoZSBuZXcgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICB2YXIgbmV4dF9wYWdlZF9udW1iZXIgPSB0aGlzLmN1cnJlbnRfcGFnZWQgKyAxO1xyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrbmV4dF9wYWdlZF9udW1iZXIpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ107XHJcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xyXG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcclxuXHJcbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcclxuICAgICAgICAgICAgaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGxvYWRlciA9ICQoJzxkaXYvPicse1xyXG4gICAgICAgICAgICAgICAgICAgICdjbGFzcyc6ICdzZWFyY2gtZmlsdGVyLXNjcm9sbC1sb2FkaW5nJ1xyXG4gICAgICAgICAgICAgICAgfSk7Ly8uYXBwZW5kVG8oc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lcik7XHJcblxyXG4gICAgICAgICAgICAgICAgJGxvYWRlciA9IHNlbGYudXBkYXRlTG9hZGVyVGFnKCRsb2FkZXIpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoJGxvYWRlcik7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgY29uc29sZS5sb2coXCJhamF4X3Byb2Nlc3NpbmdfdXJsOiBcIithamF4X3Byb2Nlc3NpbmdfdXJsKTtcclxuICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9ICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5jdXJyZW50X3BhZ2VkKys7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgICAgICAgICAvLyAqKioqKioqKioqKioqKlxyXG4gICAgICAgICAgICAgICAgLy8gVE9ETyAtIFBBU1RFIFRISVMgQU5EIFdBVENIIFRIRSBSRURJUkVDVCAtIE9OTFkgSEFQUEVOUyBXSVRIIFdDIChDUFQgQU5EIFRBWCBET0VTIE5PVClcclxuICAgICAgICAgICAgICAgIC8vIGh0dHBzOi8vc2VhcmNoLWZpbHRlci50ZXN0L3Byb2R1Y3QtY2F0ZWdvcnkvY2xvdGhpbmcvdHNoaXJ0cy9wYWdlLzMvP3NmX3BhZ2VkPTNcclxuXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcclxuICAgICAgICAgICAgICAgIHNlbGYuYWRkUmVzdWx0cyhkYXRhLCBkYXRhX3R5cGUpO1xyXG5cclxuICAgICAgICAgICAgfSwgZGF0YV90eXBlKS5mYWlsKGZ1bmN0aW9uKGpxWEhSLCB0ZXh0U3RhdHVzLCBlcnJvclRocm93bilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmFqYXhVUkwgPSBhamF4X3Byb2Nlc3NpbmdfdXJsO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5qcVhIUiA9IGpxWEhSO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50ZXh0U3RhdHVzID0gdGV4dFN0YXR1cztcclxuICAgICAgICAgICAgICAgIGRhdGEuZXJyb3JUaHJvd24gPSBlcnJvclRocm93bjtcclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGVycm9yXCIsIGRhdGEpO1xyXG5cclxuICAgICAgICAgICAgfSkuYWx3YXlzKGZ1bmN0aW9uKClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi51c2Vfc2Nyb2xsX2xvYWRlcj09MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAkbG9hZGVyLmRldGFjaCgpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaXNfbG9hZGluZ19tb3JlID0gZmFsc2U7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZmluaXNoXCIsIGRhdGEpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuZmV0Y2hBamF4UmVzdWx0cyA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIC8vdHJpZ2dlciBzdGFydCBldmVudFxyXG4gICAgICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHtcclxuICAgICAgICAgICAgICAgIHNmaWQ6IHNlbGYuc2ZpZCxcclxuICAgICAgICAgICAgICAgIHRhcmdldFNlbGVjdG9yOiBzZWxmLmFqYXhfdGFyZ2V0X2F0dHIsXHJcbiAgICAgICAgICAgICAgICB0eXBlOiBcImxvYWRfcmVzdWx0c1wiLFxyXG4gICAgICAgICAgICAgICAgb2JqZWN0OiBzZWxmXHJcbiAgICAgICAgICAgIH07XHJcblxyXG4gICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhzdGFydFwiLCBldmVudF9kYXRhKTtcclxuXHJcbiAgICAgICAgICAgIC8vcmVmb2N1cyBhbnkgaW5wdXQgZmllbGRzIGFmdGVyIHRoZSBmb3JtIGhhcyBiZWVuIHVwZGF0ZWRcclxuICAgICAgICAgICAgdmFyICRsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0ID0gJHRoaXMuZmluZCgnaW5wdXRbdHlwZT1cInRleHRcIl06Zm9jdXMnKS5ub3QoXCIuc2YtZGF0ZXBpY2tlclwiKTtcclxuICAgICAgICAgICAgaWYoJGxhc3RfYWN0aXZlX2lucHV0X3RleHQubGVuZ3RoPT0xKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgbGFzdF9hY3RpdmVfaW5wdXRfdGV4dCA9ICRsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0LmF0dHIoXCJuYW1lXCIpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAkdGhpcy5hZGRDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5kaXNhYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgLy9mYWRlIG91dCByZXN1bHRzXHJcbiAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYW5pbWF0ZSh7IG9wYWNpdHk6IDAuNSB9LCBcImZhc3RcIik7IC8vbG9hZGluZ1xyXG4gICAgICAgICAgICBzZWxmLmZhZGVDb250ZW50QXJlYXMoIFwib3V0XCIgKTtcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYuYWpheF9hY3Rpb249PVwicGFnaW5hdGlvblwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAvL25lZWQgdG8gcmVtb3ZlIGFjdGl2ZSBmaWx0ZXIgZnJvbSBVUkxcclxuXHJcbiAgICAgICAgICAgICAgICAvL3F1ZXJ5X3BhcmFtcyA9IHNlbGYubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vbm93IGFkZCB0aGUgbmV3IHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgIHZhciBwYWdlTnVtYmVyID0gc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZih0eXBlb2YocGFnZU51bWJlcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcGFnZU51bWJlciA9IDE7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYocGFnZU51bWJlcj4xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJzZl9wYWdlZD1cIitwYWdlTnVtYmVyKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmFqYXhfYWN0aW9uPT1cInN1Ym1pdFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTsgLy9ncmFiIGEgY29weSBvZiBodGUgVVJMIHBhcmFtcyB3aXRob3V0IHBhZ2luYXRpb24gYWxyZWFkeSBhZGRlZFxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBhamF4X3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICBzZWxmLnNldEFqYXhSZXN1bHRzVVJMcyhxdWVyeV9wYXJhbXMpO1xyXG4gICAgICAgICAgICBhamF4X3Byb2Nlc3NpbmdfdXJsID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXTtcclxuICAgICAgICAgICAgYWpheF9yZXN1bHRzX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ107XHJcbiAgICAgICAgICAgIGRhdGFfdHlwZSA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddO1xyXG5cclxuXHJcbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcclxuICAgICAgICAgICAgaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHZhciBhamF4X2FjdGlvbiA9IHNlbGYuYWpheF9hY3Rpb247XHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QgPSAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QgPSBudWxsO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlcyB0aGUgcmVzdXRscyAmIGZvcm0gaHRtbFxyXG4gICAgICAgICAgICAgICAgc2VsZi51cGRhdGVSZXN1bHRzKGRhdGEsIGRhdGFfdHlwZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy8gc2Nyb2xsIFxyXG4gICAgICAgICAgICAgICAgLy8gc2V0IHRoZSB2YXIgYmFjayB0byB3aGF0IGl0IHdhcyBiZWZvcmUgdGhlIGFqYXggcmVxdWVzdCBuYWQgdGhlIGZvcm0gcmUtaW5pdFxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X2FjdGlvbiA9IGFqYXhfYWN0aW9uO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zY3JvbGxSZXN1bHRzKCBzZWxmLmFqYXhfYWN0aW9uICk7XHJcblxyXG4gICAgICAgICAgICAgICAgLyogdXBkYXRlIFVSTCAqL1xyXG4gICAgICAgICAgICAgICAgLy91cGRhdGUgdXJsIGJlZm9yZSBwYWdpbmF0aW9uLCBiZWNhdXNlIHdlIG5lZWQgdG8gZG8gc29tZSBjaGVja3MgYWdhaW5zIHRoZSBVUkwgZm9yIGluZmluaXRlIHNjcm9sbFxyXG4gICAgICAgICAgICAgICAgc2VsZi51cGRhdGVVcmxIaXN0b3J5KGFqYXhfcmVzdWx0c191cmwpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vc2V0dXAgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgc2VsZi5zZXR1cEFqYXhQYWdpbmF0aW9uKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgICAgICAvKiB1c2VyIGRlZiAqL1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pbml0V29vQ29tbWVyY2VDb250cm9scygpOyAvL3dvb2NvbW1lcmNlIG9yZGVyYnlcclxuXHJcblxyXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGVycm9yXCIsIGRhdGEpO1xyXG5cclxuICAgICAgICAgICAgfSkuYWx3YXlzKGZ1bmN0aW9uKClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5zdG9wKHRydWUsdHJ1ZSkuYW5pbWF0ZSh7IG9wYWNpdHk6IDF9LCBcImZhc3RcIik7IC8vZmluaXNoZWQgbG9hZGluZ1xyXG4gICAgICAgICAgICAgICAgc2VsZi5mYWRlQ29udGVudEFyZWFzKCBcImluXCIgKTtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG4gICAgICAgICAgICAgICAgJHRoaXMucmVtb3ZlQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmVuYWJsZUlucHV0cyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3JlZm9jdXMgdGhlIGxhc3QgYWN0aXZlIHRleHQgZmllbGRcclxuICAgICAgICAgICAgICAgIGlmKGxhc3RfYWN0aXZlX2lucHV0X3RleHQhPVwiXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRpbnB1dCA9IFtdO1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGFjdGl2ZV9pbnB1dCA9ICQodGhpcykuZmluZChcImlucHV0W25hbWU9J1wiK2xhc3RfYWN0aXZlX2lucHV0X3RleHQrXCInXVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGFjdGl2ZV9pbnB1dC5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRpbnB1dCA9ICRhY3RpdmVfaW5wdXQ7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoJGlucHV0Lmxlbmd0aD09MSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgJGlucHV0LmZvY3VzKCkudmFsKCRpbnB1dC52YWwoKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuZm9jdXNDYW1wbygkaW5wdXRbMF0pO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5maW5kKFwiaW5wdXRbbmFtZT0nX3NmX3NlYXJjaCddXCIpLnRyaWdnZXIoJ2ZvY3VzJyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmaW5pc2hcIiwgIGRhdGEgKTtcclxuXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZm9jdXNDYW1wbyA9IGZ1bmN0aW9uKGlucHV0RmllbGQpe1xyXG4gICAgICAgICAgICAvL3ZhciBpbnB1dEZpZWxkID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xyXG4gICAgICAgICAgICBpZiAoaW5wdXRGaWVsZCAhPSBudWxsICYmIGlucHV0RmllbGQudmFsdWUubGVuZ3RoICE9IDApe1xyXG4gICAgICAgICAgICAgICAgaWYgKGlucHV0RmllbGQuY3JlYXRlVGV4dFJhbmdlKXtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgRmllbGRSYW5nZSA9IGlucHV0RmllbGQuY3JlYXRlVGV4dFJhbmdlKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgRmllbGRSYW5nZS5tb3ZlU3RhcnQoJ2NoYXJhY3RlcicsaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGgpO1xyXG4gICAgICAgICAgICAgICAgICAgIEZpZWxkUmFuZ2UuY29sbGFwc2UoKTtcclxuICAgICAgICAgICAgICAgICAgICBGaWVsZFJhbmdlLnNlbGVjdCgpO1xyXG4gICAgICAgICAgICAgICAgfWVsc2UgaWYgKGlucHV0RmllbGQuc2VsZWN0aW9uU3RhcnQgfHwgaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCA9PSAnMCcpIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZWxlbUxlbiA9IGlucHV0RmllbGQudmFsdWUubGVuZ3RoO1xyXG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuc2VsZWN0aW9uU3RhcnQgPSBlbGVtTGVuO1xyXG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuc2VsZWN0aW9uRW5kID0gZWxlbUxlbjtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGlucHV0RmllbGQuYmx1cigpO1xyXG4gICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5mb2N1cygpO1xyXG4gICAgICAgICAgICB9IGVsc2V7XHJcbiAgICAgICAgICAgICAgICBpZiAoIGlucHV0RmllbGQgKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5mb2N1cygpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudHJpZ2dlckV2ZW50ID0gZnVuY3Rpb24oZXZlbnRuYW1lLCBkYXRhKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRldmVudF9jb250YWluZXIgPSAkKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiK3NlbGYuc2ZpZCtcIiddXCIpO1xyXG4gICAgICAgICAgICAkZXZlbnRfY29udGFpbmVyLnRyaWdnZXIoZXZlbnRuYW1lLCBbIGRhdGEgXSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmZldGNoQWpheEZvcm0gPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcclxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XHJcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXHJcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogXCJmb3JtXCIsXHJcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZvcm1zdGFydFwiLCBbIGV2ZW50X2RhdGEgXSk7XHJcblxyXG4gICAgICAgICAgICAkdGhpcy5hZGRDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5kaXNhYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKCk7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9zbyBhZGQgaXRcclxuICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJsYW5nPVwiK3NlbGYubGFuZ19jb2RlKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF9mb3JtX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwianNvblwiO1xyXG5cclxuXHJcbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcclxuICAgICAgICAgICAgLyppZihzZWxmLmxhc3RfYWpheF9yZXF1ZXN0KVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xyXG4gICAgICAgICAgICAgfSovXHJcblxyXG5cclxuICAgICAgICAgICAgLy9zZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID1cclxuXHJcbiAgICAgICAgICAgICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlRm9ybShkYXRhLCBkYXRhX3R5cGUpO1xyXG5cclxuXHJcbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcclxuICAgICAgICAgICAgICAgIGRhdGEuanFYSFIgPSBqcVhIUjtcclxuICAgICAgICAgICAgICAgIGRhdGEudGV4dFN0YXR1cyA9IHRleHRTdGF0dXM7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBbIGRhdGEgXSk7XHJcblxyXG4gICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZW5hYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZvcm1maW5pc2hcIiwgWyBkYXRhIF0pO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmNvcHlMaXN0SXRlbXNDb250ZW50cyA9IGZ1bmN0aW9uKCRsaXN0X2Zyb20sICRsaXN0X3RvKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgLy9jb3B5IG92ZXIgY2hpbGQgbGlzdCBpdGVtc1xyXG4gICAgICAgICAgICB2YXIgbGlfY29udGVudHNfYXJyYXkgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgdmFyIGZyb21fYXR0cmlidXRlcyA9IG5ldyBBcnJheSgpO1xyXG5cclxuICAgICAgICAgICAgdmFyICRmcm9tX2ZpZWxkcyA9ICRsaXN0X2Zyb20uZmluZChcIj4gdWwgPiBsaVwiKTtcclxuXHJcbiAgICAgICAgICAgICRmcm9tX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGkpe1xyXG5cclxuICAgICAgICAgICAgICAgIGxpX2NvbnRlbnRzX2FycmF5LnB1c2goJCh0aGlzKS5odG1sKCkpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciBhdHRyaWJ1dGVzID0gJCh0aGlzKS5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgICAgIGZyb21fYXR0cmlidXRlcy5wdXNoKGF0dHJpYnV0ZXMpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vdmFyIGZpZWxkX25hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcbiAgICAgICAgICAgICAgICAvL3ZhciB0b19maWVsZCA9ICRsaXN0X3RvLmZpbmQoXCI+IHVsID4gbGlbZGF0YS1zZi1maWVsZC1uYW1lPSdcIitmaWVsZF9uYW1lK1wiJ11cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmNvcHlBdHRyaWJ1dGVzKCQodGhpcyksICRsaXN0X3RvLCBcImRhdGEtc2YtXCIpO1xyXG5cclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICB2YXIgbGlfaXQgPSAwO1xyXG4gICAgICAgICAgICB2YXIgJHRvX2ZpZWxkcyA9ICRsaXN0X3RvLmZpbmQoXCI+IHVsID4gbGlcIik7XHJcbiAgICAgICAgICAgICR0b19maWVsZHMuZWFjaChmdW5jdGlvbihpKXtcclxuICAgICAgICAgICAgICAgICQodGhpcykuaHRtbChsaV9jb250ZW50c19hcnJheVtsaV9pdF0pO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZnJvbV9maWVsZCA9ICQoJGZyb21fZmllbGRzLmdldChsaV9pdCkpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkdG9fZmllbGQgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgJHRvX2ZpZWxkLnJlbW92ZUF0dHIoXCJkYXRhLXNmLXRheG9ub215LWFyY2hpdmVcIik7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmNvcHlBdHRyaWJ1dGVzKCRmcm9tX2ZpZWxkLCAkdG9fZmllbGQpO1xyXG5cclxuICAgICAgICAgICAgICAgIGxpX2l0Kys7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgLyp2YXIgJGZyb21fZmllbGRzID0gJGxpc3RfZnJvbS5maW5kKFwiIHVsID4gbGlcIik7XHJcbiAgICAgICAgICAgICB2YXIgJHRvX2ZpZWxkcyA9ICRsaXN0X3RvLmZpbmQoXCIgPiBsaVwiKTtcclxuICAgICAgICAgICAgICRmcm9tX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGluZGV4LCB2YWwpe1xyXG4gICAgICAgICAgICAgaWYoJCh0aGlzKS5oYXNBdHRyaWJ1dGUoXCJkYXRhLXNmLXRheG9ub215LWFyY2hpdmVcIikpXHJcbiAgICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgdGhpcy5jb3B5QXR0cmlidXRlcygkbGlzdF9mcm9tLCAkbGlzdF90byk7Ki9cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlRm9ybUF0dHJpYnV0ZXMgPSBmdW5jdGlvbigkbGlzdF9mcm9tLCAkbGlzdF90bylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBmcm9tX2F0dHJpYnV0ZXMgPSAkbGlzdF9mcm9tLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggPHNlbGVjdD4gYXR0cmlidXRlcyBhbmQgYXBwbHkgdGhlbSBvbiA8ZGl2PlxyXG5cclxuICAgICAgICAgICAgdmFyIHRvX2F0dHJpYnV0ZXMgPSAkbGlzdF90by5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgJC5lYWNoKHRvX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJGxpc3RfdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICQuZWFjaChmcm9tX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJGxpc3RfdG8uYXR0cih0aGlzLm5hbWUsIHRoaXMudmFsdWUpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzID0gZnVuY3Rpb24oJGZyb20sICR0bywgcHJlZml4KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKHByZWZpeCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBwcmVmaXggPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gJGZyb20ucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcblxyXG4gICAgICAgICAgICB2YXIgdG9fYXR0cmlidXRlcyA9ICR0by5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgJC5lYWNoKHRvX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHByZWZpeCE9XCJcIikge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICh0aGlzLm5hbWUuaW5kZXhPZihwcmVmaXgpID09IDApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRvLnJlbW92ZUF0dHIodGhpcy5uYW1lKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8kdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICQuZWFjaChmcm9tX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJHRvLmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmNvcHlGb3JtQXR0cmlidXRlcyA9IGZ1bmN0aW9uKCRmcm9tLCAkdG8pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAkdG8ucmVtb3ZlQXR0cihcImRhdGEtY3VycmVudC10YXhvbm9teS1hcmNoaXZlXCIpO1xyXG4gICAgICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzKCRmcm9tLCAkdG8pO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlRm9ybSA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKGRhdGFbJ2Zvcm0nXSkhPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLm9mZigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3JlZnJlc2ggdGhlIGZvcm0gKGF1dG8gY291bnQpXHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5TGlzdEl0ZW1zQ29udGVudHMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmUgaW5pdCBTJkYgY2xhc3Mgb24gdGhlIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLnNlYXJjaEFuZEZpbHRlcigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL2lmIGFqYXggaXMgZW5hYmxlZCBpbml0IHRoZSBwYWdpbmF0aW9uXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHRoaXMuaW5pdCh0cnVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5zZXR1cEFqYXhQYWdpbmF0aW9uKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5hZGRSZXN1bHRzID0gZnVuY3Rpb24oZGF0YSwgZGF0YV90eXBlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgaWYoZGF0YV90eXBlPT1cImpzb25cIilcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSBkaWQgYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50LCBzbyBleHBlY3QgYW4gb2JqZWN0IGJhY2tcclxuICAgICAgICAgICAgICAgIC8vZ3JhYiB0aGUgcmVzdWx0cyBhbmQgbG9hZCBpblxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmFwcGVuZChkYXRhWydyZXN1bHRzJ10pO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9IGRhdGFbJ3Jlc3VsdHMnXTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKGRhdGFfdHlwZT09XCJodG1sXCIpXHJcbiAgICAgICAgICAgIHsvL3dlIGFyZSBleHBlY3RpbmcgdGhlIGh0bWwgb2YgdGhlIHJlc3VsdHMgcGFnZSBiYWNrLCBzbyBleHRyYWN0IHRoZSBodG1sIHdlIG5lZWRcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGRhdGFfb2JqID0gJChkYXRhKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuYXBwZW5kKCRkYXRhX29iai5maW5kKHNlbGYuYWpheF90YXJnZXRfYXR0cikuaHRtbCgpKTtcclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSAkZGF0YV9vYmouZmluZChzZWxmLmFqYXhfdGFyZ2V0X2F0dHIpLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGluZmluaXRlX3Njcm9sbF9lbmQgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIGlmKCQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChcIltkYXRhLXNlYXJjaC1maWx0ZXItYWN0aW9uPSdpbmZpbml0ZS1zY3JvbGwtZW5kJ11cIikubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGluZmluaXRlX3Njcm9sbF9lbmQgPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvL2lmIHRoZXJlIGlzIGFub3RoZXIgc2VsZWN0b3IgZm9yIGluZmluaXRlIHNjcm9sbCwgZmluZCB0aGUgY29udGVudHMgb2YgdGhhdCBpbnN0ZWFkXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIpLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciAkcmVzdWx0X2l0ZW1zID0gJChcIjxkaXY+XCIrc2VsZi5sb2FkX21vcmVfaHRtbCtcIjwvZGl2PlwiKS5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJHJlc3VsdF9pdGVtc19jb250YWluZXIgPSAkKCc8ZGl2Lz4nLCB7fSk7XHJcbiAgICAgICAgICAgICAgICAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lci5hcHBlbmQoJHJlc3VsdF9pdGVtcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICRyZXN1bHRfaXRlbXNfY29udGFpbmVyLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoaW5maW5pdGVfc2Nyb2xsX2VuZClcclxuICAgICAgICAgICAgey8vd2UgZm91bmQgYSBkYXRhIGF0dHJpYnV0ZSBzaWduYWxsaW5nIHRoZSBsYXN0IHBhZ2Ugc28gZmluaXNoIGhlcmVcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBzZWxmLmxvYWRfbW9yZV9odG1sO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoc2VsZi5sb2FkX21vcmVfaHRtbCk7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5sYXN0X2xvYWRfbW9yZV9odG1sIT09c2VsZi5sb2FkX21vcmVfaHRtbClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9jaGVjayB0byBtYWtlIHN1cmUgdGhlIG5ldyBodG1sIGZldGNoZWQgaXMgZGlmZmVyZW50XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBzZWxmLmxvYWRfbW9yZV9odG1sO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pbmZpbml0ZVNjcm9sbEFwcGVuZChzZWxmLmxvYWRfbW9yZV9odG1sKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly93ZSByZWNlaXZlZCB0aGUgc2FtZSBtZXNzYWdlIGFnYWluIHNvIGRvbid0IGFkZCwgYW5kIHRlbGwgUyZGIHRoYXQgd2UncmUgYXQgdGhlIGVuZC4uXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB0aGlzLmluZmluaXRlU2Nyb2xsQXBwZW5kID0gZnVuY3Rpb24oJG9iamVjdClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcykubGFzdCgpLmFmdGVyKCRvYmplY3QpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmFwcGVuZCgkb2JqZWN0KTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlUmVzdWx0cyA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXHJcbiAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJlc3VsdHMgYW5kIGxvYWQgaW5cclxuICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuaHRtbChkYXRhWydyZXN1bHRzJ10pO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihkYXRhWydmb3JtJ10pIT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBhbGwgZXZlbnRzIGZyb20gUyZGIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYucmVtb3ZlQWpheFBhZ2luYXRpb24oKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUxpc3RJdGVtc0NvbnRlbnRzKCQoZGF0YVsnZm9ybSddKSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3VwZGF0ZSBhdHRyaWJ1dGVzIG9uIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlGb3JtQXR0cmlidXRlcygkKGRhdGFbJ2Zvcm0nXSksICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLnNlYXJjaEFuZEZpbHRlcih7J2lzSW5pdCc6IGZhbHNlfSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8kdGhpcy5maW5kKFwiaW5wdXRcIikucmVtb3ZlQXR0cihcImRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoZGF0YV90eXBlPT1cImh0bWxcIikgey8vd2UgYXJlIGV4cGVjdGluZyB0aGUgaHRtbCBvZiB0aGUgcmVzdWx0cyBwYWdlIGJhY2ssIHNvIGV4dHJhY3QgdGhlIGh0bWwgd2UgbmVlZFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZGF0YV9vYmogPSAkKGRhdGEpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuaHRtbCgkZGF0YV9vYmouZmluZChzZWxmLmFqYXhfdGFyZ2V0X2F0dHIpLmh0bWwoKSk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi51cGRhdGVDb250ZW50QXJlYXMoICRkYXRhX29iaiApO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmIChzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLmxlbmd0aCA+IDApXHJcbiAgICAgICAgICAgICAgICB7Ly90aGVuIHRoZXJlIGFyZSBzZWFyY2ggZm9ybShzKSBpbnNpZGUgdGhlIHJlc3VsdHMgY29udGFpbmVyLCBzbyByZS1pbml0IHRoZW1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAvL2lmIHRoZSBjdXJyZW50IHNlYXJjaCBmb3JtIGlzIG5vdCBpbnNpZGUgdGhlIHJlc3VsdHMgY29udGFpbmVyLCB0aGVuIHByb2NlZWQgYXMgbm9ybWFsIGFuZCB1cGRhdGUgdGhlIGZvcm1cclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJbZGF0YS1zZi1mb3JtLWlkPSdcIiArIHNlbGYuc2ZpZCArIFwiJ11cIikubGVuZ3RoPT0wKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkbmV3X3NlYXJjaF9mb3JtID0gJGRhdGFfb2JqLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyW2RhdGEtc2YtZm9ybS1pZD0nXCIgKyBzZWxmLnNmaWQgKyBcIiddXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAoJG5ld19zZWFyY2hfZm9ybS5sZW5ndGggPT0gMSkgey8vdGhlbiByZXBsYWNlIHRoZSBzZWFyY2ggZm9ybSB3aXRoIHRoZSBuZXcgb25lXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBhbGwgZXZlbnRzIGZyb20gUyZGIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMub2ZmKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYucmVtb3ZlQWpheFBhZ2luYXRpb24oKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVmcmVzaCB0aGUgZm9ybSAoYXV0byBjb3VudClcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5TGlzdEl0ZW1zQ29udGVudHMoJG5ld19zZWFyY2hfZm9ybSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy91cGRhdGUgYXR0cmlidXRlcyBvbiBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUZvcm1BdHRyaWJ1dGVzKCRuZXdfc2VhcmNoX2Zvcm0sICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmUgaW5pdCBTJkYgY2xhc3Mgb24gdGhlIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMuc2VhcmNoQW5kRmlsdGVyKHsnaXNJbml0JzogZmFsc2V9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy8kdGhpcy5maW5kKFwiaW5wdXRcIikucmVtb3ZlQXR0cihcImRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSBmYWxzZTsgLy9mb3IgaW5maW5pdGUgc2Nyb2xsXHJcbiAgICAgICAgICAgIHNlbGYuY3VycmVudF9wYWdlZCA9IDE7IC8vZm9yIGluZmluaXRlIHNjcm9sbFxyXG4gICAgICAgICAgICBzZWxmLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyKCk7XHJcblxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy51cGRhdGVDb250ZW50QXJlYXMgPSBmdW5jdGlvbiggJGh0bWxfZGF0YSApIHtcclxuICAgICAgICAgICAgXHJcbiAgICAgICAgICAgIC8vIGFkZCBhZGRpdGlvbmFsIGNvbnRlbnQgYXJlYXNcclxuICAgICAgICAgICAgaWYgKCB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zICYmIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoICkge1xyXG4gICAgICAgICAgICAgICAgZm9yIChpbmRleCA9IDA7IGluZGV4IDwgdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucy5sZW5ndGg7ICsraW5kZXgpIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc2VsZWN0b3IgPSB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zW2luZGV4XTtcclxuICAgICAgICAgICAgICAgICAgICAkKCBzZWxlY3RvciApLmh0bWwoICRodG1sX2RhdGEuZmluZCggc2VsZWN0b3IgKS5odG1sKCkgKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmZhZGVDb250ZW50QXJlYXMgPSBmdW5jdGlvbiggZGlyZWN0aW9uICkge1xyXG4gICAgICAgICAgICBcclxuICAgICAgICAgICAgdmFyIG9wYWNpdHkgPSAwLjU7XHJcbiAgICAgICAgICAgIGlmICggZGlyZWN0aW9uID09PSBcImluXCIgKSB7XHJcbiAgICAgICAgICAgICAgICBvcGFjaXR5ID0gMTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYgKCB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zICYmIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoICkge1xyXG4gICAgICAgICAgICAgICAgZm9yIChpbmRleCA9IDA7IGluZGV4IDwgdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucy5sZW5ndGg7ICsraW5kZXgpIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc2VsZWN0b3IgPSB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zW2luZGV4XTtcclxuICAgICAgICAgICAgICAgICAgICAkKCBzZWxlY3RvciApLnN0b3AodHJ1ZSx0cnVlKS5hbmltYXRlKCB7IG9wYWNpdHk6IG9wYWNpdHl9LCBcImZhc3RcIiApO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgXHJcbiAgICAgICAgICAgIFxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5yZW1vdmVXb29Db21tZXJjZUNvbnRyb2xzID0gZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZyAub3JkZXJieScpO1xyXG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5X2Zvcm0gPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcnKTtcclxuXHJcbiAgICAgICAgICAgICR3b29fb3JkZXJieV9mb3JtLm9mZigpO1xyXG4gICAgICAgICAgICAkd29vX29yZGVyYnkub2ZmKCk7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5hZGRRdWVyeVBhcmFtID0gZnVuY3Rpb24obmFtZSwgdmFsdWUsIHVybF90eXBlKXtcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih1cmxfdHlwZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB1cmxfdHlwZSA9IFwiYWxsXCI7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNbdXJsX3R5cGVdW25hbWVdID0gdmFsdWU7XHJcblxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMgPSBmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgc2VsZi5yZW1vdmVXb29Db21tZXJjZUNvbnRyb2xzKCk7XHJcblxyXG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5ID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nIC5vcmRlcmJ5Jyk7XHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnlfZm9ybSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZycpO1xyXG5cclxuICAgICAgICAgICAgdmFyIG9yZGVyX3ZhbCA9IFwiXCI7XHJcbiAgICAgICAgICAgIGlmKCR3b29fb3JkZXJieS5sZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgb3JkZXJfdmFsID0gJHdvb19vcmRlcmJ5LnZhbCgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgb3JkZXJfdmFsID0gc2VsZi5nZXRRdWVyeVBhcmFtRnJvbVVSTChcIm9yZGVyYnlcIiwgd2luZG93LmxvY2F0aW9uLmhyZWYpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihvcmRlcl92YWw9PVwibWVudV9vcmRlclwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZigob3JkZXJfdmFsIT1cIlwiKSYmKCEhb3JkZXJfdmFsKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsLm9yZGVyYnkgPSBvcmRlcl92YWw7XHJcbiAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICAkd29vX29yZGVyYnlfZm9ybS5vbignc3VibWl0JywgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgICAgICAgICAgLy92YXIgZm9ybSA9IGUudGFyZ2V0O1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICR3b29fb3JkZXJieS5vbihcImNoYW5nZVwiLCBmdW5jdGlvbihlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9ICQodGhpcykudmFsKCk7XHJcbiAgICAgICAgICAgICAgICBpZih2YWw9PVwibWVudV9vcmRlclwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhbCA9IFwiXCI7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsLm9yZGVyYnkgPSB2YWw7XHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMudHJpZ2dlcihcInN1Ym1pdFwiKVxyXG5cclxuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zY3JvbGxSZXN1bHRzID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG4gICAgICAgICAgICBpZigoc2VsZi5zY3JvbGxfb25fYWN0aW9uPT1zZWxmLmFqYXhfYWN0aW9uKXx8KHNlbGYuc2Nyb2xsX29uX2FjdGlvbj09XCJhbGxcIikpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuc2Nyb2xsVG9Qb3MoKTsgLy9zY3JvbGwgdGhlIHdpbmRvdyBpZiBpdCBoYXMgYmVlbiBzZXRcclxuICAgICAgICAgICAgICAgIC8vc2VsZi5hamF4X2FjdGlvbiA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlVXJsSGlzdG9yeSA9IGZ1bmN0aW9uKGFqYXhfcmVzdWx0c191cmwpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgICAgICB2YXIgdXNlX2hpc3RvcnlfYXBpID0gMDtcclxuICAgICAgICAgICAgaWYgKHdpbmRvdy5oaXN0b3J5ICYmIHdpbmRvdy5oaXN0b3J5LnB1c2hTdGF0ZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdXNlX2hpc3RvcnlfYXBpID0gJHRoaXMuYXR0cihcImRhdGEtdXNlLWhpc3RvcnktYXBpXCIpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZigoc2VsZi51cGRhdGVfYWpheF91cmw9PTEpJiYodXNlX2hpc3RvcnlfYXBpPT0xKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9ub3cgY2hlY2sgaWYgdGhlIGJyb3dzZXIgc3VwcG9ydHMgaGlzdG9yeSBzdGF0ZSBwdXNoIDopXHJcbiAgICAgICAgICAgICAgICBpZiAod2luZG93Lmhpc3RvcnkgJiYgd2luZG93Lmhpc3RvcnkucHVzaFN0YXRlKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGhpc3RvcnkucHVzaFN0YXRlKG51bGwsIG51bGwsIGFqYXhfcmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMucmVtb3ZlQWpheFBhZ2luYXRpb24gPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2Yoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKSE9XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyICRhamF4X2xpbmtzX29iamVjdCA9IGpRdWVyeShzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCRhamF4X2xpbmtzX29iamVjdC5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAkYWpheF9saW5rc19vYmplY3Qub2ZmKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuZ2V0QmFzZVVybCA9IGZ1bmN0aW9uKCB1cmwgKSB7XHJcbiAgICAgICAgICAgIC8vbm93IHNlZSBpZiB3ZSBhcmUgb24gdGhlIFVSTCB3ZSB0aGluay4uLlxyXG4gICAgICAgICAgICB2YXIgdXJsX3BhcnRzID0gdXJsLnNwbGl0KFwiP1wiKTtcclxuICAgICAgICAgICAgdmFyIHVybF9iYXNlID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIGlmKHVybF9wYXJ0cy5sZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSB1cmxfcGFydHNbMF07XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybDtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICByZXR1cm4gdXJsX2Jhc2U7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuY2FuRmV0Y2hBamF4UmVzdWx0cyA9IGZ1bmN0aW9uKGZldGNoX3R5cGUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZih0eXBlb2YoZmV0Y2hfdHlwZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBmZXRjaF90eXBlID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG4gICAgICAgICAgICB2YXIgZmV0Y2hfYWpheF9yZXN1bHRzID0gZmFsc2U7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2lsbCBhamF4IHN1Ym1pdCB0aGUgZm9ybVxyXG5cclxuICAgICAgICAgICAgICAgIC8vYW5kIGlmIHdlIGNhbiBmaW5kIHRoZSByZXN1bHRzIGNvbnRhaW5lclxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmwgPSBzZWxmLnJlc3VsdHNfdXJsOyAgLy9cclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybF9lbmNvZGVkID0gJyc7ICAvL1xyXG4gICAgICAgICAgICAgICAgdmFyIGN1cnJlbnRfdXJsID0gd2luZG93LmxvY2F0aW9uLmhyZWY7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9pZ25vcmUgIyBhbmQgZXZlcnl0aGluZyBhZnRlclxyXG4gICAgICAgICAgICAgICAgdmFyIGhhc2hfcG9zID0gd2luZG93LmxvY2F0aW9uLmhyZWYuaW5kZXhPZignIycpO1xyXG4gICAgICAgICAgICAgICAgaWYoaGFzaF9wb3MhPT0tMSl7XHJcbiAgICAgICAgICAgICAgICAgICAgY3VycmVudF91cmwgPSB3aW5kb3cubG9jYXRpb24uaHJlZi5zdWJzdHIoMCwgd2luZG93LmxvY2F0aW9uLmhyZWYuaW5kZXhPZignIycpKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZiggKCAoIHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cImN1c3RvbV93b29jb21tZXJjZV9zdG9yZVwiICkgfHwgKCBzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJwb3N0X3R5cGVfYXJjaGl2ZVwiICkgKSAmJiAoIHNlbGYuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID09IDEgKSApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoIHNlbGYuY3VycmVudF90YXhvbm9teV9hcmNoaXZlICE9PVwiXCIgKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZldGNoX2FqYXhfcmVzdWx0cztcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8qdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICAgICAgIHZhciBhY3RpdmVfdGF4ID0gcHJvY2Vzc19mb3JtLmdldEFjdGl2ZVRheCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSwgJycsIGFjdGl2ZV90YXgpOyovXHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgLy9ub3cgc2VlIGlmIHdlIGFyZSBvbiB0aGUgVVJMIHdlIHRoaW5rLi4uXHJcbiAgICAgICAgICAgICAgICB2YXIgdXJsX2Jhc2UgPSB0aGlzLmdldEJhc2VVcmwoIGN1cnJlbnRfdXJsICk7XHJcbiAgICAgICAgICAgICAgICAvL3ZhciByZXN1bHRzX3VybF9iYXNlID0gdGhpcy5nZXRCYXNlVXJsKCBjdXJyZW50X3VybCApO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciBsYW5nID0gc2VsZi5nZXRRdWVyeVBhcmFtRnJvbVVSTChcImxhbmdcIiwgd2luZG93LmxvY2F0aW9uLmhyZWYpO1xyXG4gICAgICAgICAgICAgICAgaWYoKHR5cGVvZihsYW5nKSE9PVwidW5kZWZpbmVkXCIpJiYobGFuZyE9PW51bGwpKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHVybF9iYXNlID0gc2VsZi5hZGRVcmxQYXJhbSh1cmxfYmFzZSwgXCJsYW5nPVwiK2xhbmcpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHZhciBzZmlkID0gc2VsZi5nZXRRdWVyeVBhcmFtRnJvbVVSTChcInNmaWRcIiwgd2luZG93LmxvY2F0aW9uLmhyZWYpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vaWYgc2ZpZCBpcyBhIG51bWJlclxyXG4gICAgICAgICAgICAgICAgaWYoTnVtYmVyKHBhcnNlRmxvYXQoc2ZpZCkpID09IHNmaWQpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSBzZWxmLmFkZFVybFBhcmFtKHVybF9iYXNlLCBcInNmaWQ9XCIrc2ZpZCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgLy9pZiBhbnkgb2YgdGhlIDMgY29uZGl0aW9ucyBhcmUgdHJ1ZSwgdGhlbiBpdHMgZ29vZCB0byBnb1xyXG4gICAgICAgICAgICAgICAgLy8gLSAxIHwgaWYgdGhlIHVybCBiYXNlID09IHJlc3VsdHNfdXJsXHJcbiAgICAgICAgICAgICAgICAvLyAtIDIgfCBpZiB1cmwgYmFzZSsgXCIvXCIgID09IHJlc3VsdHNfdXJsIC0gaW4gY2FzZSBvZiB1c2VyIGVycm9yIGluIHRoZSByZXN1bHRzIFVSTFxyXG4gICAgICAgICAgICAgICAgLy8gLSAzIHwgaWYgdGhlIHJlc3VsdHMgVVJMIGhhcyB1cmwgcGFyYW1zLCBhbmQgdGhlIGN1cnJlbnQgdXJsIHN0YXJ0cyB3aXRoIHRoZSByZXN1bHRzIFVSTCBcclxuXHJcbiAgICAgICAgICAgICAgICAvL3RyaW0gYW55IHRyYWlsaW5nIHNsYXNoIGZvciBlYXNpZXIgY29tcGFyaXNvbjpcclxuICAgICAgICAgICAgICAgIHVybF9iYXNlID0gdXJsX2Jhc2UucmVwbGFjZSgvXFwvJC8sICcnKTtcclxuICAgICAgICAgICAgICAgIHJlc3VsdHNfdXJsID0gcmVzdWx0c191cmwucmVwbGFjZSgvXFwvJC8sICcnKTtcclxuICAgICAgICAgICAgICAgIHJlc3VsdHNfdXJsX2VuY29kZWQgPSBlbmNvZGVVUkkocmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgXHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID0gLTE7XHJcbiAgICAgICAgICAgICAgICBpZigodXJsX2Jhc2U9PXJlc3VsdHNfdXJsKXx8KHVybF9iYXNlLnRvTG93ZXJDYXNlKCk9PXJlc3VsdHNfdXJsX2VuY29kZWQudG9Mb3dlckNhc2UoKSkgICl7XHJcbiAgICAgICAgICAgICAgICAgICAgY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPSAxO1xyXG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoIHJlc3VsdHNfdXJsLmluZGV4T2YoICc/JyApICE9PSAtMSAmJiBjdXJyZW50X3VybC5sYXN0SW5kZXhPZihyZXN1bHRzX3VybCwgMCkgPT09IDAgKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID0gMTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5vbmx5X3Jlc3VsdHNfYWpheD09MSlcclxuICAgICAgICAgICAgICAgIHsvL2lmIGEgdXNlciBoYXMgY2hvc2VuIHRvIG9ubHkgYWxsb3cgYWpheCBvbiByZXN1bHRzIHBhZ2VzIChkZWZhdWx0IGJlaGF2aW91cilcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID4gLTEpXHJcbiAgICAgICAgICAgICAgICAgICAgey8vdGhpcyBtZWFucyB0aGUgY3VycmVudCBVUkwgY29udGFpbnMgdGhlIHJlc3VsdHMgdXJsLCB3aGljaCBtZWFucyB3ZSBjYW4gZG8gYWpheFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZmV0Y2hfdHlwZT09XCJwYWdpbmF0aW9uXCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiggY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPiAtMSlcclxuICAgICAgICAgICAgICAgICAgICAgICAgey8vdGhpcyBtZWFucyB0aGUgY3VycmVudCBVUkwgY29udGFpbnMgdGhlIHJlc3VsdHMgdXJsLCB3aGljaCBtZWFucyB3ZSBjYW4gZG8gYWpheFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vZG9uJ3QgYWpheCBwYWdpbmF0aW9uIHdoZW4gbm90IG9uIGEgUyZGIHBhZ2VcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gZmV0Y2hfYWpheF9yZXN1bHRzO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zZXR1cEFqYXhQYWdpbmF0aW9uID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgLy9pbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgaWYodGhpcy5wYWdpbmF0aW9uX3R5cGU9PT1cImluZmluaXRlX3Njcm9sbFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiW2RhdGEtc2VhcmNoLWZpbHRlci1hY3Rpb249J2luZmluaXRlLXNjcm9sbC1lbmQnXVwiKS5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpbmZpbml0ZV9zY3JvbGxfZW5kID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYocGFyc2VJbnQodGhpcy5pbnN0YW5jZV9udW1iZXIpPT09MSkge1xyXG4gICAgICAgICAgICAgICAgICAgICQod2luZG93KS5vZmYoXCJzY3JvbGxcIiwgc2VsZi5vbldpbmRvd1Njcm9sbCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmIChzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoXCJwYWdpbmF0aW9uXCIpKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQod2luZG93KS5vbihcInNjcm9sbFwiLCBzZWxmLm9uV2luZG93U2Nyb2xsKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZih0eXBlb2Yoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKT09XCJ1bmRlZmluZWRcIikge1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgJChkb2N1bWVudCkub2ZmKCdjbGljaycsIHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vZmYoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcclxuICAgICAgICAgICAgICAgICQoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKS5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vbignY2xpY2snLCBzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IsIGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoXCJwYWdpbmF0aW9uXCIpKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGxpbmsgPSBqUXVlcnkodGhpcykuYXR0cignaHJlZicpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gXCJwYWdpbmF0aW9uXCI7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuZ2V0UGFnZWRGcm9tVVJMKGxpbmspO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiLCBwYWdlTnVtYmVyKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuZmV0Y2hBamF4UmVzdWx0cygpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5nZXRQYWdlZEZyb21VUkwgPSBmdW5jdGlvbihVUkwpe1xyXG5cclxuICAgICAgICAgICAgdmFyIHBhZ2VkVmFsID0gMTtcclxuICAgICAgICAgICAgLy9maXJzdCB0ZXN0IHRvIHNlZSBpZiB3ZSBoYXZlIFwiL3BhZ2UvNC9cIiBpbiB0aGUgVVJMXHJcbiAgICAgICAgICAgIHZhciB0cFZhbCA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJzZl9wYWdlZFwiLCBVUkwpO1xyXG4gICAgICAgICAgICBpZigodHlwZW9mKHRwVmFsKT09XCJzdHJpbmdcIil8fCh0eXBlb2YodHBWYWwpPT1cIm51bWJlclwiKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcGFnZWRWYWwgPSB0cFZhbDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIHBhZ2VkVmFsO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZ2V0UXVlcnlQYXJhbUZyb21VUkwgPSBmdW5jdGlvbihuYW1lLCBVUkwpe1xyXG5cclxuICAgICAgICAgICAgdmFyIHFzdHJpbmcgPSBcIj9cIitVUkwuc3BsaXQoJz8nKVsxXTtcclxuICAgICAgICAgICAgaWYodHlwZW9mKHFzdHJpbmcpIT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZGVjb2RlVVJJQ29tcG9uZW50KChuZXcgUmVnRXhwKCdbP3wmXScgKyBuYW1lICsgJz0nICsgJyhbXiY7XSs/KSgmfCN8O3wkKScpLmV4ZWMocXN0cmluZyl8fFssXCJcIl0pWzFdLnJlcGxhY2UoL1xcKy9nLCAnJTIwJykpfHxudWxsO1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIHZhbDtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICByZXR1cm4gXCJcIjtcclxuICAgICAgICB9O1xyXG5cclxuXHJcblxyXG4gICAgICAgIHRoaXMuZm9ybVVwZGF0ZWQgPSBmdW5jdGlvbihlKXtcclxuXHJcbiAgICAgICAgICAgIC8vZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgICAgICBpZihzZWxmLmF1dG9fdXBkYXRlPT0xKSB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0wKSYmKHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmZvcm1VcGRhdGVkRmV0Y2hBamF4KCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmZvcm1VcGRhdGVkRmV0Y2hBamF4ID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8vbG9vcCB0aHJvdWdoIGFsbCB0aGUgZmllbGRzIGFuZCBidWlsZCB0aGUgVVJMXHJcbiAgICAgICAgICAgIHNlbGYuZmV0Y2hBamF4Rm9ybSgpO1xyXG5cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICAvL21ha2UgYW55IGNvcnJlY3Rpb25zL3VwZGF0ZXMgdG8gZmllbGRzIGJlZm9yZSB0aGUgc3VibWl0IGNvbXBsZXRlc1xyXG4gICAgICAgIHRoaXMuc2V0RmllbGRzID0gZnVuY3Rpb24oZSl7XHJcblxyXG4gICAgICAgICAgICAvL2lmKHNlbGYuaXNfYWpheD09MCkge1xyXG5cclxuICAgICAgICAgICAgICAgIC8vc29tZXRpbWVzIHRoZSBmb3JtIGlzIHN1Ym1pdHRlZCB3aXRob3V0IHRoZSBzbGlkZXIgeWV0IGhhdmluZyB1cGRhdGVkLCBhbmQgYXMgd2UgZ2V0IG91ciB2YWx1ZXMgZnJvbVxyXG4gICAgICAgICAgICAgICAgLy90aGUgc2xpZGVyIGFuZCBub3QgaW5wdXRzLCB3ZSBuZWVkIHRvIGNoZWNrIGl0IGlmIG5lZWRzIHRvIGJlIHNldFxyXG4gICAgICAgICAgICAgICAgLy9vbmx5IG9jY3VycyBpZiBhamF4IGlzIG9mZiwgYW5kIGF1dG9zdWJtaXQgb25cclxuICAgICAgICAgICAgICAgIHNlbGYuJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGZpZWxkID0gJCh0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJhbmdlX2Rpc3BsYXlfdmFsdWVzID0gJGZpZWxkLmZpbmQoJy5zZi1tZXRhLXJhbmdlLXNsaWRlcicpLmF0dHIoXCJkYXRhLWRpc3BsYXktdmFsdWVzLWFzXCIpOy8vZGF0YS1kaXNwbGF5LXZhbHVlcy1hcz1cInRleHRcIlxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihyYW5nZV9kaXNwbGF5X3ZhbHVlcz09PVwidGV4dGlucHV0XCIpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmxlbmd0aD4wKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCIubWV0YS1zbGlkZXJcIikuZWFjaChmdW5jdGlvbiAoaW5kZXgpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX29iamVjdCA9ICQodGhpcylbMF07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHNsaWRlcl9lbCA9ICQodGhpcykuY2xvc2VzdChcIi5zZi1tZXRhLXJhbmdlLXNsaWRlclwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vdmFyIG1pblZhbCA9ICRzbGlkZXJfZWwuYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy92YXIgbWF4VmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgbWluVmFsID0gJHNsaWRlcl9lbC5maW5kKFwiLnNmLXJhbmdlLW1pblwiKS52YWwoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmZpbmQoXCIuc2YtcmFuZ2UtbWF4XCIpLnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbbWluVmFsLCBtYXhWYWxdKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAvL31cclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICAvL3N1Ym1pdFxyXG4gICAgICAgIHRoaXMuc3VibWl0Rm9ybSA9IGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgLy9sb29wIHRocm91Z2ggYWxsIHRoZSBmaWVsZHMgYW5kIGJ1aWxkIHRoZSBVUkxcclxuICAgICAgICAgICAgaWYoc2VsZi5pc1N1Ym1pdHRpbmcgPT0gdHJ1ZSkge1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLnNldEZpZWxkcygpO1xyXG4gICAgICAgICAgICBzZWxmLmNsZWFyVGltZXIoKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gdHJ1ZTtcclxuXHJcbiAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIiwgMSk7IC8vaW5pdCBwYWdlZFxyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi5jYW5GZXRjaEFqYXhSZXN1bHRzKCkpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2lsbCBhamF4IHN1Ym1pdCB0aGUgZm9ybVxyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9hY3Rpb24gPSBcInN1Ym1pdFwiOyAvL3NvIHdlIGtub3cgaXQgd2Fzbid0IHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgIHNlbGYuZmV0Y2hBamF4UmVzdWx0cygpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIHNpbXBseSByZWRpcmVjdCB0byB0aGUgUmVzdWx0cyBVUkxcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyh0cnVlLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybCA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgd2luZG93LmxvY2F0aW9uLmhyZWYgPSByZXN1bHRzX3VybDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH07XHJcbiAgICAgICAgdGhpcy5yZXNldEZvcm0gPSBmdW5jdGlvbihzdWJtaXRfZm9ybSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIC8vdW5zZXQgYWxsIGZpZWxkc1xyXG4gICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZmllbGQgPSAkKHRoaXMpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdCRmaWVsZC5yZW1vdmVBdHRyKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpO1xyXG5cdFx0XHRcdFxyXG4gICAgICAgICAgICAgICAgLy9zdGFuZGFyZCBmaWVsZCB0eXBlc1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJzZWxlY3Q6bm90KFttdWx0aXBsZT0nbXVsdGlwbGUnXSkgPiBvcHRpb246Zmlyc3QtY2hpbGRcIikucHJvcChcInNlbGVjdGVkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJzZWxlY3RbbXVsdGlwbGU9J211bHRpcGxlJ10gPiBvcHRpb25cIikucHJvcChcInNlbGVjdGVkXCIsIGZhbHNlKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiaW5wdXRbdHlwZT0nY2hlY2tib3gnXVwiKS5wcm9wKFwiY2hlY2tlZFwiLCBmYWxzZSk7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIj4gdWwgPiBsaTpmaXJzdC1jaGlsZCBpbnB1dFt0eXBlPSdyYWRpbyddXCIpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJpbnB1dFt0eXBlPSd0ZXh0J11cIikudmFsKFwiXCIpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCIuc2Ytb3B0aW9uLWFjdGl2ZVwiKS5yZW1vdmVDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIj4gdWwgPiBsaTpmaXJzdC1jaGlsZCBpbnB1dFt0eXBlPSdyYWRpbyddXCIpLnBhcmVudCgpLmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTsgLy9yZSBhZGQgYWN0aXZlIGNsYXNzIHRvIGZpcnN0IFwiZGVmYXVsdFwiIG9wdGlvblxyXG5cclxuICAgICAgICAgICAgICAgIC8vbnVtYmVyIHJhbmdlIC0gMiBudW1iZXIgaW5wdXQgZmllbGRzXHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcImlucHV0W3R5cGU9J251bWJlciddXCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNJbnB1dCA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCR0aGlzSW5wdXQucGFyZW50KCkucGFyZW50KCkuaGFzQ2xhc3MoXCJzZi1tZXRhLXJhbmdlXCIpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoJHRoaXNJbnB1dC5hdHRyKFwibWluXCIpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbCgkdGhpc0lucHV0LmF0dHIoXCJtYXhcIikpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vbWV0YSAvIG51bWJlcnMgd2l0aCAyIGlucHV0cyAoZnJvbSAvIHRvIGZpZWxkcykgLSBzZWNvbmQgaW5wdXQgbXVzdCBiZSByZXNldCB0byBtYXggdmFsdWVcclxuICAgICAgICAgICAgICAgIHZhciAkbWV0YV9zZWxlY3RfZnJvbV90byA9ICRmaWVsZC5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2VsZWN0LWZyb210b1wiKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigkbWV0YV9zZWxlY3RfZnJvbV90by5sZW5ndGg+MCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWluID0gJG1ldGFfc2VsZWN0X2Zyb21fdG8uYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9tYXggPSAkbWV0YV9zZWxlY3RfZnJvbV90by5hdHRyKFwiZGF0YS1tYXhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRtZXRhX3NlbGVjdF9mcm9tX3RvLmZpbmQoXCJzZWxlY3RcIikuZWFjaChmdW5jdGlvbihpbmRleCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNJbnB1dCA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKHN0YXJ0X21pbik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihpbmRleD09MSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoc3RhcnRfbWF4KTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJG1ldGFfcmFkaW9fZnJvbV90byA9ICRmaWVsZC5maW5kKFwiLnNmLW1ldGEtcmFuZ2UtcmFkaW8tZnJvbXRvXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCRtZXRhX3JhZGlvX2Zyb21fdG8ubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21pbiA9ICRtZXRhX3JhZGlvX2Zyb21fdG8uYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9tYXggPSAkbWV0YV9yYWRpb19mcm9tX3RvLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRyYWRpb19ncm91cHMgPSAkbWV0YV9yYWRpb19mcm9tX3RvLmZpbmQoJy5zZi1pbnB1dC1yYW5nZS1yYWRpbycpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkcmFkaW9fZ3JvdXBzLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkcmFkaW9zID0gJCh0aGlzKS5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLnByb3AoXCJjaGVja2VkXCIsIGZhbHNlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGluZGV4PT0wKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLmZpbHRlcignW3ZhbHVlPVwiJytzdGFydF9taW4rJ1wiXScpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoaW5kZXg9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRyYWRpb3MuZmlsdGVyKCdbdmFsdWU9XCInK3N0YXJ0X21heCsnXCJdJykucHJvcChcImNoZWNrZWRcIiwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vbnVtYmVyIHNsaWRlciAtIG5vVWlTbGlkZXJcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX29iamVjdCA9ICQodGhpcylbMF07XHJcbiAgICAgICAgICAgICAgICAgICAgLyp2YXIgc2xpZGVyX29iamVjdCA9ICRjb250YWluZXIuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcclxuICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl92YWwgPSBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZ2V0KCk7Ki9cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzbGlkZXJfZWwgPSAkKHRoaXMpLmNsb3Nlc3QoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1pblZhbCA9ICRzbGlkZXJfZWwuYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFttaW5WYWwsIG1heFZhbF0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vbmVlZCB0byBzZWUgaWYgYW55IGFyZSBjb21ib2JveCBhbmQgYWN0IGFjY29yZGluZ2x5XHJcbiAgICAgICAgICAgICAgICB2YXIgJGNvbWJvYm94ID0gJGZpZWxkLmZpbmQoXCJzZWxlY3RbZGF0YS1jb21ib2JveD0nMSddXCIpO1xyXG4gICAgICAgICAgICAgICAgaWYoJGNvbWJvYm94Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICh0eXBlb2YgJGNvbWJvYm94LmNob3NlbiAhPSBcInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTsgLy9mb3IgY2hvc2VuIG9ubHlcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnZhbCgnJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC50cmlnZ2VyKCdjaGFuZ2Uuc2VsZWN0MicpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7XHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgIGlmKHN1Ym1pdF9mb3JtPT1cImFsd2F5c1wiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHN1Ym1pdF9mb3JtPT1cIm5ldmVyXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5mb3JtVXBkYXRlZEZldGNoQWpheCgpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc3VibWl0X2Zvcm09PVwiYXV0b1wiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fdXBkYXRlPT10cnVlKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZvcm1VcGRhdGVkRmV0Y2hBamF4KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuaW5pdCgpO1xyXG5cclxuICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHt9O1xyXG4gICAgICAgIGV2ZW50X2RhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICBldmVudF9kYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgIGV2ZW50X2RhdGEub2JqZWN0ID0gdGhpcztcclxuICAgICAgICBpZihvcHRzLmlzSW5pdClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6aW5pdFwiLCBldmVudF9kYXRhKTtcclxuICAgICAgICB9XHJcblxyXG4gICAgfSk7XHJcbn07XHJcblxufSkuY2FsbCh0aGlzLHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWwgOiB0eXBlb2Ygc2VsZiAhPT0gXCJ1bmRlZmluZWRcIiA/IHNlbGYgOiB0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93IDoge30pXG4vLyMgc291cmNlTWFwcGluZ1VSTD1kYXRhOmFwcGxpY2F0aW9uL2pzb247Y2hhcnNldDp1dGYtODtiYXNlNjQsZXlKMlpYSnphVzl1SWpvekxDSnpiM1Z5WTJWeklqcGJJbk55WXk5d2RXSnNhV012WVhOelpYUnpMMnB6TDJsdVkyeDFaR1Z6TDNCc2RXZHBiaTVxY3lKZExDSnVZVzFsY3lJNlcxMHNJbTFoY0hCcGJtZHpJam9pTzBGQlFVRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CSWl3aVptbHNaU0k2SW1kbGJtVnlZWFJsWkM1cWN5SXNJbk52ZFhKalpWSnZiM1FpT2lJaUxDSnpiM1Z5WTJWelEyOXVkR1Z1ZENJNld5SmNjbHh1ZG1GeUlDUWdYSFJjZEZ4MFhIUTlJQ2gwZVhCbGIyWWdkMmx1Wkc5M0lDRTlQU0JjSW5WdVpHVm1hVzVsWkZ3aUlEOGdkMmx1Wkc5M1d5ZHFVWFZsY25rblhTQTZJSFI1Y0dWdlppQm5iRzlpWVd3Z0lUMDlJRndpZFc1a1pXWnBibVZrWENJZ1B5Qm5iRzlpWVd4YkoycFJkV1Z5ZVNkZElEb2diblZzYkNrN1hISmNiblpoY2lCemRHRjBaU0JjZEZ4MFhIUTlJSEpsY1hWcGNtVW9KeTR2YzNSaGRHVW5LVHRjY2x4dWRtRnlJSEJ5YjJObGMzTmZabTl5YlNCY2REMGdjbVZ4ZFdseVpTZ25MaTl3Y205alpYTnpYMlp2Y20wbktUdGNjbHh1ZG1GeUlHNXZWV2xUYkdsa1pYSmNkRngwUFNCeVpYRjFhWEpsS0NkdWIzVnBjMnhwWkdWeUp5azdYSEpjYmk4dmRtRnlJR052YjJ0cFpYTWdJQ0FnSUNBZ0lDQTlJSEpsY1hWcGNtVW9KMnB6TFdOdmIydHBaU2NwTzF4eVhHNTJZWElnZEdocGNtUlFZWEowZVNBZ0lDQWdJRDBnY21WeGRXbHlaU2duTGk5MGFHbHlaSEJoY25SNUp5azdYSEpjYmx4eVhHNTNhVzVrYjNjdWMyVmhjbU5vUVc1a1JtbHNkR1Z5SUQwZ2UxeHlYRzRnSUNBZ1pYaDBaVzV6YVc5dWN6b2dXMTBzWEhKY2JpQWdJQ0J5WldkcGMzUmxja1Y0ZEdWdWMybHZiam9nWm5WdVkzUnBiMjRvSUdWNGRHVnVjMmx2Yms1aGJXVWdLU0I3WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVsZUhSbGJuTnBiMjV6TG5CMWMyZ29JR1Y0ZEdWdWMybHZiazVoYldVZ0tUdGNjbHh1SUNBZ0lIMWNjbHh1ZlR0Y2NseHVYSEpjYm0xdlpIVnNaUzVsZUhCdmNuUnpJRDBnWm5WdVkzUnBiMjRvYjNCMGFXOXVjeWxjY2x4dWUxeHlYRzRnSUNBZ2RtRnlJR1JsWm1GMWJIUnpJRDBnZTF4eVhHNGdJQ0FnSUNBZ0lITjBZWEowVDNCbGJtVmtPaUJtWVd4elpTeGNjbHh1SUNBZ0lDQWdJQ0JwYzBsdWFYUTZJSFJ5ZFdVc1hISmNiaUFnSUNBZ0lDQWdZV04wYVc5dU9pQmNJbHdpWEhKY2JpQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lIWmhjaUJ2Y0hSeklEMGdhbEYxWlhKNUxtVjRkR1Z1WkNoa1pXWmhkV3gwY3l3Z2IzQjBhVzl1Y3lrN1hISmNiaUFnSUNCY2NseHVJQ0FnSUhSb2FYSmtVR0Z5ZEhrdWFXNXBkQ2dwTzF4eVhHNGdJQ0FnWEhKY2JpQWdJQ0F2TDJ4dmIzQWdkR2h5YjNWbmFDQmxZV05vSUdsMFpXMGdiV0YwWTJobFpGeHlYRzRnSUNBZ2RHaHBjeTVsWVdOb0tHWjFibU4wYVc5dUtDbGNjbHh1SUNBZ0lIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RtRnlJQ1IwYUdseklEMGdKQ2gwYUdsektUdGNjbHh1SUNBZ0lDQWdJQ0IyWVhJZ2MyVnNaaUE5SUhSb2FYTTdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NXpabWxrSUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdGMyWXRabTl5YlMxcFpGd2lLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdjM1JoZEdVdVlXUmtVMlZoY21Ob1JtOXliU2gwYUdsekxuTm1hV1FzSUhSb2FYTXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TGlSbWFXVnNaSE1nUFNBa2RHaHBjeTVtYVc1a0tGd2lQaUIxYkNBK0lHeHBYQ0lwT3lBdkwyRWdjbVZtWlhKbGJtTmxJSFJ2SUdWaFkyZ2dabWxsYkdSeklIQmhjbVZ1ZENCTVNWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbVZ1WVdKc1pWOTBZWGh2Ym05dGVWOWhjbU5vYVhabGN5QTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRkR0Y0YjI1dmJYa3RZWEpqYUdsMlpYTW5LVHRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbU4xY25KbGJuUmZkR0Y0YjI1dmJYbGZZWEpqYUdsMlpTQTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRZM1Z5Y21WdWRDMTBZWGh2Ym05dGVTMWhjbU5vYVhabEp5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG1WdVlXSnNaVjkwWVhodmJtOXRlVjloY21Ob2FYWmxjeWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxtVnVZV0pzWlY5MFlYaHZibTl0ZVY5aGNtTm9hWFpsY3lBOUlGd2lNRndpTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvZEdocGN5NWpkWEp5Wlc1MFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1VcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVqZFhKeVpXNTBYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVWdQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdjSEp2WTJWemMxOW1iM0p0TG1sdWFYUW9jMlZzWmk1bGJtRmliR1ZmZEdGNGIyNXZiWGxmWVhKamFHbDJaWE1zSUhObGJHWXVZM1Z5Y21WdWRGOTBZWGh2Ym05dGVWOWhjbU5vYVhabEtUdGNjbHh1SUNBZ0lDQWdJQ0F2TDNCeWIyTmxjM05mWm05eWJTNXpaWFJVWVhoQmNtTm9hWFpsVW1WemRXeDBjMVZ5YkNoelpXeG1LVHRjY2x4dUlDQWdJQ0FnSUNCd2NtOWpaWE56WDJadmNtMHVaVzVoWW14bFNXNXdkWFJ6S0hObGJHWXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1bGVIUnlZVjl4ZFdWeWVWOXdZWEpoYlhNcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVsZUhSeVlWOXhkV1Z5ZVY5d1lYSmhiWE1nUFNCN1lXeHNPaUI3ZlN3Z2NtVnpkV3gwY3pvZ2UzMHNJR0ZxWVhnNklIdDlmVHRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5SbGJYQnNZWFJsWDJselgyeHZZV1JsWkNBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExYUmxiWEJzWVhSbExXeHZZV1JsWkZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtbHpYMkZxWVhnZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMWhhbUY0WENJcE8xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWFXNXpkR0Z1WTJWZmJuVnRZbVZ5SUQwZ0pIUm9hWE11WVhSMGNpZ25aR0YwWVMxcGJuTjBZVzVqWlMxamIzVnVkQ2NwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11SkdGcVlYaGZjbVZ6ZFd4MGMxOWpiMjUwWVdsdVpYSWdQU0JxVVhWbGNua29KSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRZV3BoZUMxMFlYSm5aWFJjSWlrcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZmRYQmtZWFJsWDNObFkzUnBiMjV6SUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdFlXcGhlQzExY0dSaGRHVXRjMlZqZEdsdmJuTmNJaWtnUHlCS1UwOU9MbkJoY25ObEtDQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMWhhbUY0TFhWd1pHRjBaUzF6WldOMGFXOXVjMXdpS1NBcElEb2dXMTA3WEhKY2JpQWdJQ0FnSUNBZ1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1eVpYTjFiSFJ6WDNWeWJDQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMWEpsYzNWc2RITXRkWEpzWENJcE8xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVpHVmlkV2RmYlc5a1pTQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV1JsWW5WbkxXMXZaR1ZjSWlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1MWNHUmhkR1ZmWVdwaGVGOTFjbXdnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxMWNHUmhkR1V0WVdwaGVDMTFjbXhjSWlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1d1lXZHBibUYwYVc5dVgzUjVjR1VnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxaGFtRjRMWEJoWjJsdVlYUnBiMjR0ZEhsd1pWd2lLVHRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUYxZEc5ZlkyOTFiblFnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxaGRYUnZMV052ZFc1MFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZWFYwYjE5amIzVnVkRjl5WldaeVpYTm9YMjF2WkdVZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMWhkWFJ2TFdOdmRXNTBMWEpsWm5KbGMyZ3RiVzlrWlZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtOXViSGxmY21WemRXeDBjMTloYW1GNElEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRiMjVzZVMxeVpYTjFiSFJ6TFdGcVlYaGNJaWs3SUM4dmFXWWdkMlVnWVhKbElHNXZkQ0J2YmlCMGFHVWdjbVZ6ZFd4MGN5QndZV2RsTENCeVpXUnBjbVZqZENCeVlYUm9aWElnZEdoaGJpQjBjbmtnZEc4Z2JHOWhaQ0IyYVdFZ1lXcGhlRnh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVjMk55YjJ4c1gzUnZYM0J2Y3lBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExYTmpjbTlzYkMxMGJ5MXdiM05jSWlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1amRYTjBiMjFmYzJOeWIyeHNYM1J2SUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdFkzVnpkRzl0TFhOamNtOXNiQzEwYjF3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuTmpjbTlzYkY5dmJsOWhZM1JwYjI0Z1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMXpZM0p2Ykd3dGIyNHRZV04wYVc5dVhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXViR0Z1WjE5amIyUmxJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0YkdGdVp5MWpiMlJsWENJcE8xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVlXcGhlRjkxY213Z1BTQWtkR2hwY3k1aGRIUnlLQ2RrWVhSaExXRnFZWGd0ZFhKc0p5azdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDJadmNtMWZkWEpzSUQwZ0pIUm9hWE11WVhSMGNpZ25aR0YwWVMxaGFtRjRMV1p2Y20wdGRYSnNKeWs3WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVwYzE5eWRHd2dQU0FrZEdocGN5NWhkSFJ5S0Nka1lYUmhMV2x6TFhKMGJDY3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1ScGMzQnNZWGxmY21WemRXeDBYMjFsZEdodlpDQTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRaR2x6Y0d4aGVTMXlaWE4xYkhRdGJXVjBhRzlrSnlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1dFlXbHVkR0ZwYmw5emRHRjBaU0E5SUNSMGFHbHpMbUYwZEhJb0oyUmhkR0V0YldGcGJuUmhhVzR0YzNSaGRHVW5LVHRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZllXTjBhVzl1SUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbXhoYzNSZmMzVmliV2wwWDNGMVpYSjVYM0JoY21GdGN5QTlJRndpWENJN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZM1Z5Y21WdWRGOXdZV2RsWkNBOUlIQmhjbk5sU1c1MEtDUjBhR2x6TG1GMGRISW9KMlJoZEdFdGFXNXBkQzF3WVdkbFpDY3BLVHRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbXhoYzNSZmJHOWhaRjl0YjNKbFgyaDBiV3dnUFNCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXViRzloWkY5dGIzSmxYMmgwYld3Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WVdwaGVGOWtZWFJoWDNSNWNHVWdQU0FrZEdocGN5NWhkSFJ5S0Nka1lYUmhMV0ZxWVhndFpHRjBZUzEwZVhCbEp5azdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDNSaGNtZGxkRjloZEhSeUlEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRZV3BoZUMxMFlYSm5aWFJjSWlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1MWMyVmZhR2x6ZEc5eWVWOWhjR2tnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxMWMyVXRhR2x6ZEc5eWVTMWhjR2xjSWlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1cGMxOXpkV0p0YVhSMGFXNW5JRDBnWm1Gc2MyVTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YkdGemRGOWhhbUY0WDNKbGNYVmxjM1FnUFNCdWRXeHNPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1MWMyVmZhR2x6ZEc5eWVWOWhjR2twUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NTFjMlZmYUdsemRHOXllVjloY0drZ1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11Y0dGbmFXNWhkR2x2Ymw5MGVYQmxLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWNHRm5hVzVoZEdsdmJsOTBlWEJsSUQwZ1hDSnViM0p0WVd4Y0lqdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11WTNWeWNtVnVkRjl3WVdkbFpDazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1OMWNuSmxiblJmY0dGblpXUWdQU0F4TzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11WVdwaGVGOTBZWEpuWlhSZllYUjBjaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxtRnFZWGhmZEdGeVoyVjBYMkYwZEhJZ1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11WVdwaGVGOTFjbXdwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDNWeWJDQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1aGFtRjRYMlp2Y20xZmRYSnNLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdVlXcGhlRjltYjNKdFgzVnliQ0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvZEdocGN5NXlaWE4xYkhSelgzVnliQ2s5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxuSmxjM1ZzZEhOZmRYSnNJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxuTmpjbTlzYkY5MGIxOXdiM01wUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NXpZM0p2Ykd4ZmRHOWZjRzl6SUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbk5qY205c2JGOXZibDloWTNScGIyNHBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1elkzSnZiR3hmYjI1ZllXTjBhVzl1SUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdVkzVnpkRzl0WDNOamNtOXNiRjkwYnlrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbU4xYzNSdmJWOXpZM0p2Ykd4ZmRHOGdQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMaVJqZFhOMGIyMWZjMk55YjJ4c1gzUnZJRDBnYWxGMVpYSjVLSFJvYVhNdVkzVnpkRzl0WDNOamNtOXNiRjkwYnlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMblZ3WkdGMFpWOWhhbUY0WDNWeWJDazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG5Wd1pHRjBaVjloYW1GNFgzVnliQ0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvZEdocGN5NWtaV0oxWjE5dGIyUmxLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdVpHVmlkV2RmYlc5a1pTQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1aGFtRjRYM1JoY21kbGRGOXZZbXBsWTNRcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVoYW1GNFgzUmhjbWRsZEY5dlltcGxZM1FnUFNCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hSb2FYTXVkR1Z0Y0d4aGRHVmZhWE5mYkc5aFpHVmtLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWRHVnRjR3hoZEdWZmFYTmZiRzloWkdWa0lEMGdYQ0l3WENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1aGRYUnZYMk52ZFc1MFgzSmxabkpsYzJoZmJXOWtaU2s5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsSUQwZ1hDSXdYQ0k3WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZmJHbHVhM05mYzJWc1pXTjBiM0lnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxaGFtRjRMV3hwYm10ekxYTmxiR1ZqZEc5eVhDSXBPMXh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhkWFJ2WDNWd1pHRjBaU0E5SUNSMGFHbHpMbUYwZEhJb1hDSmtZWFJoTFdGMWRHOHRkWEJrWVhSbFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVhVzV3ZFhSVWFXMWxjaUE5SURBN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVjMlYwU1c1bWFXNXBkR1ZUWTNKdmJHeERiMjUwWVdsdVpYSWdQU0JtZFc1amRHbHZiaWdwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkx5QlhhR1Z1SUhkbElHNWhkbWxuWVhSbElHRjNZWGtnWm5KdmJTQnpaV0Z5WTJnZ2NtVnpkV3gwY3l3Z1lXNWtJSFJvWlc0Z2NISmxjM01nWW1GamF5eGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OGdhWE5mYldGNFgzQmhaMlZrSUdseklISmxkR0ZwYm1Wa0xDQnpieUIzWlNCdmJteDVJSGRoYm5RZ2RHOGdjMlYwSUdsMElIUnZJR1poYkhObElHbG1YSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZJSGRsSUdGeVpTQnBibWwwWVd4cGVtbHVaeUIwYUdVZ2NtVnpkV3gwY3lCd1lXZGxJSFJvWlNCbWFYSnpkQ0IwYVcxbElDMGdjMjhnYW5WemRDQmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OGdZMmhsWTJzZ2FXWWdkR2hwY3lCMllYSWdhWE1nZFc1a1pXWnBibVZrSUNoaGN5QnBkQ0J6YUc5MWJHUWdZbVVnYjI0Z1ptbHljM1FnZFhObEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLQ0IwZVhCbGIyWWdLQ0IwYUdsekxtbHpYMjFoZUY5d1lXZGxaQ0FwSUQwOVBTQW5kVzVrWldacGJtVmtKeUFwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11YVhOZmJXRjRYM0JoWjJWa0lEMGdabUZzYzJVN0lDOHZabTl5SUd4dllXUWdiVzl5WlNCdmJteDVMQ0J2Ym1ObElIZGxJR1JsZEdWamRDQjNaU2R5WlNCaGRDQjBhR1VnWlc1a0lITmxkQ0IwYUdseklIUnZJSFJ5ZFdWY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTUxYzJWZmMyTnliMnhzWDJ4dllXUmxjaUE5SUNSMGFHbHpMbUYwZEhJb0oyUmhkR0V0YzJodmR5MXpZM0p2Ykd3dGJHOWhaR1Z5SnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpQTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRhVzVtYVc1cGRHVXRjMk55YjJ4c0xXTnZiblJoYVc1bGNpY3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1sdVptbHVhWFJsWDNOamNtOXNiRjkwY21sbloyVnlYMkZ0YjNWdWRDQTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRhVzVtYVc1cGRHVXRjMk55YjJ4c0xYUnlhV2RuWlhJbktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVwYm1acGJtbDBaVjl6WTNKdmJHeGZjbVZ6ZFd4MFgyTnNZWE56SUQwZ0pIUm9hWE11WVhSMGNpZ25aR0YwWVMxcGJtWnBibWwwWlMxelkzSnZiR3d0Y21WemRXeDBMV05zWVhOekp5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11SkdsdVptbHVhWFJsWDNOamNtOXNiRjlqYjI1MFlXbHVaWElnUFNCMGFHbHpMaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdWFXNW1hVzVwZEdWZmMyTnliMnhzWDJOdmJuUmhhVzVsY2lrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TGlScGJtWnBibWwwWlY5elkzSnZiR3hmWTI5dWRHRnBibVZ5SUQwZ2FsRjFaWEo1S0NSMGFHbHpMbUYwZEhJb0oyUmhkR0V0YVc1bWFXNXBkR1V0YzJOeWIyeHNMV052Ym5SaGFXNWxjaWNwS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11YVc1bWFXNXBkR1ZmYzJOeWIyeHNYM0psYzNWc2RGOWpiR0Z6Y3lrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzSmxjM1ZzZEY5amJHRnpjeUE5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxuVnpaVjl6WTNKdmJHeGZiRzloWkdWeUtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTUxYzJWZmMyTnliMnhzWDJ4dllXUmxjaUE5SURFN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5ObGRFbHVabWx1YVhSbFUyTnliMnhzUTI5dWRHRnBibVZ5S0NrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUM4cUlHWjFibU4wYVc5dWN5QXFMMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5KbGMyVjBJRDBnWm5WdVkzUnBiMjRvYzNWaWJXbDBYMlp2Y20wcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NXlaWE5sZEVadmNtMG9jM1ZpYldsMFgyWnZjbTBwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdkSEoxWlR0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YVc1d2RYUlZjR1JoZEdVZ1BTQm1kVzVqZEdsdmJpaGtaV3hoZVVSMWNtRjBhVzl1S1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtHUmxiR0Y1UkhWeVlYUnBiMjRwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1pHVnNZWGxFZFhKaGRHbHZiaUE5SURNd01EdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1eVpYTmxkRlJwYldWeUtHUmxiR0Y1UkhWeVlYUnBiMjRwTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTV6WTNKdmJHeFViMUJ2Y3lBOUlHWjFibU4wYVc5dUtDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYjJabWMyVjBJRDBnTUR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHTmhibE5qY205c2JDQTlJSFJ5ZFdVN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxtbHpYMkZxWVhnOVBURXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVjMk55YjJ4c1gzUnZYM0J2Y3owOVhDSjNhVzVrYjNkY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnZabVp6WlhRZ1BTQXdPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9jMlZzWmk1elkzSnZiR3hmZEc5ZmNHOXpQVDFjSW1admNtMWNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J2Wm1aelpYUWdQU0FrZEdocGN5NXZabVp6WlhRb0tTNTBiM0E3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtITmxiR1l1YzJOeWIyeHNYM1J2WDNCdmN6MDlYQ0p5WlhOMWJIUnpYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNXNaVzVuZEdnK01DbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHOW1abk5sZENBOUlITmxiR1l1SkdGcVlYaGZjbVZ6ZFd4MGMxOWpiMjUwWVdsdVpYSXViMlptYzJWMEtDa3VkRzl3TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb2MyVnNaaTV6WTNKdmJHeGZkRzlmY0c5elBUMWNJbU4xYzNSdmJWd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2WTNWemRHOXRYM05qY205c2JGOTBiMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdUpHTjFjM1J2YlY5elkzSnZiR3hmZEc4dWJHVnVaM1JvUGpBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCdlptWnpaWFFnUFNCelpXeG1MaVJqZFhOMGIyMWZjMk55YjJ4c1gzUnZMbTltWm5ObGRDZ3BMblJ2Y0R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWTJGdVUyTnliMnhzSUQwZ1ptRnNjMlU3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb1kyRnVVMk55YjJ4c0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUW9YQ0pvZEcxc0xDQmliMlI1WENJcExuTjBiM0FvS1M1aGJtbHRZWFJsS0h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyTnliMnhzVkc5d09pQnZabVp6WlhSY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5TENCY0ltNXZjbTFoYkZ3aUxDQmNJbVZoYzJWUGRYUlJkV0ZrWENJZ0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjlPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1GMGRHRmphRUZqZEdsMlpVTnNZWE56SUQwZ1puVnVZM1JwYjI0b0tYdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2WTJobFkyc2dkRzhnYzJWbElHbG1JSGRsSUdGeVpTQjFjMmx1WnlCaGFtRjRJQ1lnWVhWMGJ5QmpiM1Z1ZEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUlHNXZkQ3dnZEdobElITmxZWEpqYUNCbWIzSnRJR1J2WlhNZ2JtOTBJR2RsZENCeVpXeHZZV1JsWkN3Z2MyOGdkMlVnYm1WbFpDQjBieUIxY0dSaGRHVWdkR2hsSUhObUxXOXdkR2x2YmkxaFkzUnBkbVVnWTJ4aGMzTWdiMjRnWVd4c0lHWnBaV3hrYzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0pIUm9hWE11YjI0b0oyTm9ZVzVuWlNjc0lDZHBibkIxZEZ0MGVYQmxQVndpY21Ga2FXOWNJbDBzSUdsdWNIVjBXM1I1Y0dVOVhDSmphR1ZqYTJKdmVGd2lYU3dnYzJWc1pXTjBKeXdnWm5WdVkzUnBiMjRvWlNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JqZEdocGN5QTlJQ1FvZEdocGN5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHTjBhR2x6WDNCaGNtVnVkQ0E5SUNSamRHaHBjeTVqYkc5elpYTjBLRndpYkdsYlpHRjBZUzF6WmkxbWFXVnNaQzF1WVcxbFhWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQjBhR2x6WDNSaFp5QTlJQ1JqZEdocGN5NXdjbTl3S0Z3aWRHRm5UbUZ0WlZ3aUtTNTBiMHh2ZDJWeVEyRnpaU2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR2x1Y0hWMFgzUjVjR1VnUFNBa1kzUm9hWE11WVhSMGNpaGNJblI1Y0dWY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NHRnlaVzUwWDNSaFp5QTlJQ1JqZEdocGMxOXdZWEpsYm5RdWNISnZjQ2hjSW5SaFowNWhiV1ZjSWlrdWRHOU1iM2RsY2tOaGMyVW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdvZEdocGMxOTBZV2M5UFZ3aWFXNXdkWFJjSWlrbUppZ29hVzV3ZFhSZmRIbHdaVDA5WENKeVlXUnBiMXdpS1h4OEtHbHVjSFYwWDNSNWNHVTlQVndpWTJobFkydGliM2hjSWlrcElDWW1JQ2h3WVhKbGJuUmZkR0ZuUFQxY0lteHBYQ0lwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtZV3hzWDI5d2RHbHZibk1nUFNBa1kzUm9hWE5mY0dGeVpXNTBMbkJoY21WdWRDZ3BMbVpwYm1Rb0oyeHBKeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSaGJHeGZiM0IwYVc5dWMxOW1hV1ZzWkhNZ1BTQWtZM1JvYVhOZmNHRnlaVzUwTG5CaGNtVnVkQ2dwTG1acGJtUW9KMmx1Y0hWME9tTm9aV05yWldRbktUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR0ZzYkY5dmNIUnBiMjV6TG5KbGJXOTJaVU5zWVhOektGd2ljMll0YjNCMGFXOXVMV0ZqZEdsMlpWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtZV3hzWDI5d2RHbHZibk5mWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0b0tYdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtjR0Z5Wlc1MElEMGdKQ2gwYUdsektTNWpiRzl6WlhOMEtGd2liR2xjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUndZWEpsYm5RdVlXUmtRMnhoYzNNb1hDSnpaaTF2Y0hScGIyNHRZV04wYVhabFhDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJR2xtS0hSb2FYTmZkR0ZuUFQxY0luTmxiR1ZqZEZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrWVd4c1gyOXdkR2x2Ym5NZ1BTQWtZM1JvYVhNdVkyaHBiR1J5Wlc0b0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1lXeHNYMjl3ZEdsdmJuTXVjbVZ0YjNabFEyeGhjM01vWENKelppMXZjSFJwYjI0dFlXTjBhWFpsWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQjBhR2x6WDNaaGJDQTlJQ1JqZEdocGN5NTJZV3dvS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJvYVhOZllYSnlYM1poYkNBOUlDaDBlWEJsYjJZZ2RHaHBjMTkyWVd3Z1BUMGdKM04wY21sdVp5Y2dmSHdnZEdocGMxOTJZV3dnYVc1emRHRnVZMlZ2WmlCVGRISnBibWNwSUQ4Z1czUm9hWE5mZG1Gc1hTQTZJSFJvYVhOZmRtRnNPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrS0hSb2FYTmZZWEp5WDNaaGJDa3VaV0ZqYUNobWRXNWpkR2x2YmlocExDQjJZV3gxWlNsN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUmpkR2hwY3k1bWFXNWtLRndpYjNCMGFXOXVXM1poYkhWbFBTZGNJaXQyWVd4MVpTdGNJaWRkWENJcExtRmtaRU5zWVhOektGd2ljMll0YjNCMGFXOXVMV0ZqZEdsMlpWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1sdWFYUkJkWFJ2VlhCa1lYUmxSWFpsYm5SeklEMGdablZ1WTNScGIyNG9LWHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4cUlHRjFkRzhnZFhCa1lYUmxJQ292WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0NoelpXeG1MbUYxZEc5ZmRYQmtZWFJsUFQweEtYeDhLSE5sYkdZdVlYVjBiMTlqYjNWdWRGOXlaV1p5WlhOb1gyMXZaR1U5UFRFcEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkR2hwY3k1dmJpZ25ZMmhoYm1kbEp5d2dKMmx1Y0hWMFczUjVjR1U5WENKeVlXUnBiMXdpWFN3Z2FXNXdkWFJiZEhsd1pUMWNJbU5vWldOclltOTRYQ0pkTENCelpXeGxZM1FuTENCbWRXNWpkR2x2YmlobEtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYm5CMWRGVndaR0YwWlNneU1EQXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTXViMjRvSjJsdWNIVjBKeXdnSjJsdWNIVjBXM1I1Y0dVOVhDSnVkVzFpWlhKY0lsMG5MQ0JtZFc1amRHbHZiaWhsS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBibkIxZEZWd1pHRjBaU2c0TURBcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSMFpYaDBTVzV3ZFhRZ1BTQWtkR2hwY3k1bWFXNWtLQ2RwYm5CMWRGdDBlWEJsUFZ3aWRHVjRkRndpWFRwdWIzUW9Mbk5tTFdSaGRHVndhV05yWlhJcEp5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2JHRnpkRlpoYkhWbElEMGdKSFJsZUhSSmJuQjFkQzUyWVd3b0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTV2YmlnbmFXNXdkWFFuTENBbmFXNXdkWFJiZEhsd1pUMWNJblJsZUhSY0lsMDZibTkwS0M1elppMWtZWFJsY0dsamEyVnlLU2NzSUdaMWJtTjBhVzl1S0NsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHNZWE4wVm1Gc2RXVWhQU1IwWlhoMFNXNXdkWFF1ZG1Gc0tDa3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWNIVjBWWEJrWVhSbEtERXlNREFwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYkdGemRGWmhiSFZsSUQwZ0pIUmxlSFJKYm5CMWRDNTJZV3dvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGN5NXZiaWduYTJWNWNISmxjM01uTENBbmFXNXdkWFJiZEhsd1pUMWNJblJsZUhSY0lsMDZibTkwS0M1elppMWtZWFJsY0dsamEyVnlLU2NzSUdaMWJtTjBhVzl1S0dVcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLR1V1ZDJocFkyZ2dQVDBnTVRNcGUxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWlM1d2NtVjJaVzUwUkdWbVlYVnNkQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1Mbk4xWW0xcGRFWnZjbTBvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUdaaGJITmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5UjBhR2x6TG05dUtDZHBibkIxZENjc0lDZHBibkIxZEM1elppMWtZWFJsY0dsamEyVnlKeXdnYzJWc1ppNWtZWFJsU1c1d2RYUlVlWEJsS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0F2TDNSb2FYTXVhVzVwZEVGMWRHOVZjR1JoZEdWRmRtVnVkSE1vS1R0Y2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WTJ4bFlYSlVhVzFsY2lBOUlHWjFibU4wYVc5dUtDbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR05zWldGeVZHbHRaVzkxZENoelpXeG1MbWx1Y0hWMFZHbHRaWElwTzF4eVhHNGdJQ0FnSUNBZ0lIMDdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NXlaWE5sZEZScGJXVnlJRDBnWm5WdVkzUnBiMjRvWkdWc1lYbEVkWEpoZEdsdmJpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR05zWldGeVZHbHRaVzkxZENoelpXeG1MbWx1Y0hWMFZHbHRaWElwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHVjSFYwVkdsdFpYSWdQU0J6WlhSVWFXMWxiM1YwS0hObGJHWXVabTl5YlZWd1pHRjBaV1FzSUdSbGJHRjVSSFZ5WVhScGIyNHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjlPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1Ga1pFUmhkR1ZRYVdOclpYSnpJRDBnWm5WdVkzUnBiMjRvS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JrWVhSbFgzQnBZMnRsY2lBOUlDUjBhR2x6TG1acGJtUW9YQ0l1YzJZdFpHRjBaWEJwWTJ0bGNsd2lLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtDUmtZWFJsWDNCcFkydGxjaTVzWlc1bmRHZytNQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdSaGRHVmZjR2xqYTJWeUxtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwYUdseklEMGdKQ2gwYUdsektUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR0YwWlVadmNtMWhkQ0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdWRWNtOXdaRzkzYmxsbFlYSWdQU0JtWVd4elpUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR0YwWlVSeWIzQmtiM2R1VFc5dWRHZ2dQU0JtWVd4elpUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSamJHOXpaWE4wWDJSaGRHVmZkM0poY0NBOUlDUjBhR2x6TG1Oc2IzTmxjM1FvWENJdWMyWmZaR0YwWlY5bWFXVnNaRndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlna1kyeHZjMlZ6ZEY5a1lYUmxYM2R5WVhBdWJHVnVaM1JvUGpBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmxSbTl5YldGMElEMGdKR05zYjNObGMzUmZaR0YwWlY5M2NtRndMbUYwZEhJb1hDSmtZWFJoTFdSaGRHVXRabTl5YldGMFhDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KR05zYjNObGMzUmZaR0YwWlY5M2NtRndMbUYwZEhJb1hDSmtZWFJoTFdSaGRHVXRkWE5sTFhsbFlYSXRaSEp2Y0dSdmQyNWNJaWs5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHVkVjbTl3Wkc5M2JsbGxZWElnUFNCMGNuVmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDUmpiRzl6WlhOMFgyUmhkR1ZmZDNKaGNDNWhkSFJ5S0Z3aVpHRjBZUzFrWVhSbExYVnpaUzF0YjI1MGFDMWtjbTl3Wkc5M2Jsd2lLVDA5TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFpVUnliM0JrYjNkdVRXOXVkR2dnUFNCMGNuVmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1pHRjBaVkJwWTJ0bGNrOXdkR2x2Ym5NZ1BTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2x1YkdsdVpUb2dkSEoxWlN4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyaHZkMDkwYUdWeVRXOXVkR2h6T2lCMGNuVmxMRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J2YmxObGJHVmpkRG9nWm5WdVkzUnBiMjRvWlN3Z1puSnZiVjltYVdWc1pDbDdJSE5sYkdZdVpHRjBaVk5sYkdWamRDaGxMQ0JtY205dFgyWnBaV3hrTENBa0tIUm9hWE1wS1RzZ2ZTeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWlVadmNtMWhkRG9nWkdGMFpVWnZjbTFoZEN4Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR05vWVc1blpVMXZiblJvT2lCa1lYUmxSSEp2Y0dSdmQyNU5iMjUwYUN4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1kyaGhibWRsV1dWaGNqb2daR0YwWlVSeWIzQmtiM2R1V1dWaGNseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWFYTmZjblJzUFQweEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBaVkJwWTJ0bGNrOXdkR2x2Ym5NdVpHbHlaV04wYVc5dUlEMGdYQ0p5ZEd4Y0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG1SaGRHVndhV05yWlhJb1pHRjBaVkJwWTJ0bGNrOXdkR2x2Ym5NcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxteGhibWRmWTI5a1pTRTlYQ0pjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRdVpHRjBaWEJwWTJ0bGNpNXpaWFJFWldaaGRXeDBjeWhjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUXVaWGgwWlc1a0tGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIc25aR0YwWlVadmNtMWhkQ2M2WkdGMFpVWnZjbTFoZEgwc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pDNWtZWFJsY0dsamEyVnlMbkpsWjJsdmJtRnNXeUJ6Wld4bUxteGhibWRmWTI5a1pWMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlZjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1F1WkdGMFpYQnBZMnRsY2k1elpYUkVaV1poZFd4MGN5aGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRdVpYaDBaVzVrS0Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhzblpHRjBaVVp2Y20xaGRDYzZaR0YwWlVadmNtMWhkSDBzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkM1a1lYUmxjR2xqYTJWeUxuSmxaMmx2Ym1Gc1cxd2laVzVjSWwxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDUW9KeTVzYkMxemEybHVMVzFsYkc5dUp5a3ViR1Z1WjNSb1BUMHdLWHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdSaGRHVmZjR2xqYTJWeUxtUmhkR1Z3YVdOclpYSW9KM2RwWkdkbGRDY3BMbmR5WVhBb0p6eGthWFlnWTJ4aGMzTTlYQ0pzYkMxemEybHVMVzFsYkc5dUlITmxZWEpqYUdGdVpHWnBiSFJsY2kxa1lYUmxMWEJwWTJ0bGNsd2lMejRuS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbVJoZEdWVFpXeGxZM1FnUFNCbWRXNWpkR2x2YmlobExDQm1jbTl0WDJacFpXeGtMQ0FrZEdocGN5bGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2FXNXdkWFJmWm1sbGJHUWdQU0FrS0daeWIyMWZabWxsYkdRdWFXNXdkWFF1WjJWMEtEQXBLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSMGFHbHpJRDBnSkNoMGFHbHpLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtaR0YwWlY5bWFXVnNaSE1nUFNBa2FXNXdkWFJmWm1sbGJHUXVZMnh2YzJWemRDZ25XMlJoZEdFdGMyWXRabWxsYkdRdGFXNXdkWFF0ZEhsd1pUMWNJbVJoZEdWeVlXNW5aVndpWFN3Z1cyUmhkR0V0YzJZdFptbGxiR1F0YVc1d2RYUXRkSGx3WlQxY0ltUmhkR1ZjSWwwbktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0pHUmhkR1ZmWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0b1pTd2dhVzVrWlhncGUxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pIUm1YMlJoZEdWZmNHbGphMlZ5Y3lBOUlDUW9kR2hwY3lrdVptbHVaQ2hjSWk1elppMWtZWFJsY0dsamEyVnlYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzV2WDJSaGRHVmZjR2xqYTJWeWN5QTlJQ1IwWmw5a1lYUmxYM0JwWTJ0bGNuTXViR1Z1WjNSb08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlodWIxOWtZWFJsWDNCcFkydGxjbk0rTVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzUm9aVzRnYVhRZ2FYTWdZU0JrWVhSbElISmhibWRsTENCemJ5QnRZV3RsSUhOMWNtVWdZbTkwYUNCbWFXVnNaSE1nWVhKbElHWnBiR3hsWkNCaVpXWnZjbVVnZFhCa1lYUnBibWRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWkhCZlkyOTFiblJsY2lBOUlEQTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1J3WDJWdGNIUjVYMlpwWld4a1gyTnZkVzUwSUQwZ01EdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHWmZaR0YwWlY5d2FXTnJaWEp6TG1WaFkyZ29ablZ1WTNScGIyNG9LWHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1FvZEdocGN5a3VkbUZzS0NrOVBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1J3WDJWdGNIUjVYMlpwWld4a1gyTnZkVzUwS3lzN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSd1gyTnZkVzUwWlhJckt6dGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvWkhCZlpXMXdkSGxmWm1sbGJHUmZZMjkxYm5ROVBUQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWNIVjBWWEJrWVhSbEtERXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWNIVjBWWEJrWVhSbEtERXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhaR1JTWVc1blpWTnNhV1JsY25NZ1BTQm1kVzVqZEdsdmJpZ3BYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHMWxkR0ZmY21GdVoyVWdQU0FrZEdocGN5NW1hVzVrS0Z3aUxuTm1MVzFsZEdFdGNtRnVaMlV0YzJ4cFpHVnlYQ0lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KRzFsZEdGZmNtRnVaMlV1YkdWdVozUm9QakFwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSdFpYUmhYM0poYm1kbExtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwYUdseklEMGdKQ2gwYUdsektUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiV2x1SUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdGJXbHVYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdFlYZ2dQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzF0WVhoY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE50YVc0Z1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMXpkR0Z5ZEMxdGFXNWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOdFlYZ2dQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzF6ZEdGeWRDMXRZWGhjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHUnBjM0JzWVhsZmRtRnNkV1ZmWVhNZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMWthWE53YkdGNUxYWmhiSFZsY3kxaGMxd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzNSbGNDQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMWE4wWlhCY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1J6ZEdGeWRGOTJZV3dnUFNBa2RHaHBjeTVtYVc1a0tDY3VjMll0Y21GdVoyVXRiV2x1SnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmxibVJmZG1Gc0lEMGdKSFJvYVhNdVptbHVaQ2duTG5ObUxYSmhibWRsTFcxaGVDY3BPMXh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JsWTJsdFlXeGZjR3hoWTJWeklEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRaR1ZqYVcxaGJDMXdiR0ZqWlhOY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJvYjNWellXNWtYM05sY0dWeVlYUnZjaUE5SUNSMGFHbHpMbUYwZEhJb1hDSmtZWFJoTFhSb2IzVnpZVzVrTFhObGNHVnlZWFJ2Y2x3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR1ZqYVcxaGJGOXpaWEJsY21GMGIzSWdQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzFrWldOcGJXRnNMWE5sY0dWeVlYUnZjbHdpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1pwWld4a1gyWnZjbTFoZENBOUlIZE9kVzFpS0h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2JXRnlhem9nWkdWamFXMWhiRjl6WlhCbGNtRjBiM0lzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSbFkybHRZV3h6T2lCd1lYSnpaVVpzYjJGMEtHUmxZMmx0WVd4ZmNHeGhZMlZ6S1N4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHaHZkWE5oYm1RNklIUm9iM1Z6WVc1a1gzTmxjR1Z5WVhSdmNseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ0YVc1ZmRXNW1iM0p0WVhSMFpXUWdQU0J3WVhKelpVWnNiMkYwS0hOdGFXNHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ0YVc1ZlptOXliV0YwZEdWa0lEMGdabWxsYkdSZlptOXliV0YwTG5SdktIQmhjbk5sUm14dllYUW9jMjFwYmlrcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnRZWGhmWm05eWJXRjBkR1ZrSUQwZ1ptbGxiR1JmWm05eWJXRjBMblJ2S0hCaGNuTmxSbXh2WVhRb2MyMWhlQ2twTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdFlYaGZkVzVtYjNKdFlYUjBaV1FnUFNCd1lYSnpaVVpzYjJGMEtITnRZWGdwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2WVd4bGNuUW9iV2x1WDJadmNtMWhkSFJsWkNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5aGJHVnlkQ2h0WVhoZlptOXliV0YwZEdWa0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyRnNaWEowS0dScGMzQnNZWGxmZG1Gc2RXVmZZWE1wTzF4eVhHNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvWkdsemNHeGhlVjkyWVd4MVpWOWhjejA5WENKMFpYaDBhVzV3ZFhSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUnpkR0Z5ZEY5MllXd3VkbUZzS0cxcGJsOW1iM0p0WVhSMFpXUXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWlc1a1gzWmhiQzUyWVd3b2JXRjRYMlp2Y20xaGRIUmxaQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb1pHbHpjR3hoZVY5MllXeDFaVjloY3owOVhDSjBaWGgwWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2MzUmhjblJmZG1Gc0xtaDBiV3dvYldsdVgyWnZjbTFoZEhSbFpDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JsYm1SZmRtRnNMbWgwYld3b2JXRjRYMlp2Y20xaGRIUmxaQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzV2VlVsUGNIUnBiMjV6SUQwZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlZVzVuWlRvZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSjIxcGJpYzZJRnNnY0dGeWMyVkdiRzloZENodGFXNHBJRjBzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQW5iV0Y0SnpvZ1d5QndZWEp6WlVac2IyRjBLRzFoZUNrZ1hWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlMRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6ZEdGeWREb2dXMjFwYmw5bWIzSnRZWFIwWldRc0lHMWhlRjltYjNKdFlYUjBaV1JkTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCb1lXNWtiR1Z6T2lBeUxGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmpiMjV1WldOME9pQjBjblZsTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCemRHVndPaUJ3WVhKelpVWnNiMkYwS0hOMFpYQXBMRnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1ltVm9ZWFpwYjNWeU9pQW5aWGgwWlc1a0xYUmhjQ2NzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdadmNtMWhkRG9nWm1sbGJHUmZabTl5YldGMFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgzSjBiRDA5TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUc1dlZVbFBjSFJwYjI1ekxtUnBjbVZqZEdsdmJpQTlJRndpY25Sc1hDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJ4cFpHVnlYMjlpYW1WamRDQTlJQ1FvZEdocGN5a3VabWx1WkNoY0lpNXRaWFJoTFhOc2FXUmxjbHdpS1Zzd1hUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvSUZ3aWRXNWtaV1pwYm1Wa1hDSWdJVDA5SUhSNWNHVnZaaWdnYzJ4cFpHVnlYMjlpYW1WamRDNXViMVZwVTJ4cFpHVnlJQ2tnS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZaR1Z6ZEhKdmVTQnBaaUJwZENCbGVHbHpkSE11TGlCMGFHbHpJRzFsWVc1eklITnZiV1ZvYjNjZ1lXNXZkR2hsY2lCcGJuTjBZVzVqWlNCb1lXUWdhVzVwZEdsaGJHbHpaV1FnYVhRdUxseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpiR2xrWlhKZmIySnFaV04wTG01dlZXbFRiR2xrWlhJdVpHVnpkSEp2ZVNncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2JtOVZhVk5zYVdSbGNpNWpjbVZoZEdVb2MyeHBaR1Z5WDI5aWFtVmpkQ3dnYm05VlNVOXdkR2x2Ym5NcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtjM1JoY25SZmRtRnNMbTltWmlncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSemRHRnlkRjkyWVd3dWIyNG9KMk5vWVc1blpTY3NJR1oxYm1OMGFXOXVLQ2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhOc2FXUmxjbDl2WW1wbFkzUXVibTlWYVZOc2FXUmxjaTV6WlhRb1d5UW9kR2hwY3lrdWRtRnNLQ2tzSUc1MWJHeGRLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdWdVpGOTJZV3d1YjJabUtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHVnVaRjkyWVd3dWIyNG9KMk5vWVc1blpTY3NJR1oxYm1OMGFXOXVLQ2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhOc2FXUmxjbDl2WW1wbFkzUXVibTlWYVZOc2FXUmxjaTV6WlhRb1cyNTFiR3dzSUNRb2RHaHBjeWt1ZG1Gc0tDbGRLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk4a2MzUmhjblJmZG1Gc0xtaDBiV3dvYldsdVgyWnZjbTFoZEhSbFpDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OGtaVzVrWDNaaGJDNW9kRzFzS0cxaGVGOW1iM0p0WVhSMFpXUXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSXViMlptS0NkMWNHUmhkR1VuS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSXViMjRvSjNWd1pHRjBaU2NzSUdaMWJtTjBhVzl1S0NCMllXeDFaWE1zSUdoaGJtUnNaU0FwSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCemJHbGtaWEpmYzNSaGNuUmZkbUZzSUNBOUlHMXBibDltYjNKdFlYUjBaV1E3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnpiR2xrWlhKZlpXNWtYM1poYkNBZ1BTQnRZWGhmWm05eWJXRjBkR1ZrTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhaaGJIVmxJRDBnZG1Gc2RXVnpXMmhoYm1Sc1pWMDdYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0NCb1lXNWtiR1VnS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J0WVhoZlptOXliV0YwZEdWa0lEMGdkbUZzZFdVN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMGdaV3h6WlNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J0YVc1ZlptOXliV0YwZEdWa0lEMGdkbUZzZFdVN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtHUnBjM0JzWVhsZmRtRnNkV1ZmWVhNOVBWd2lkR1Y0ZEdsdWNIVjBYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1J6ZEdGeWRGOTJZV3d1ZG1Gc0tHMXBibDltYjNKdFlYUjBaV1FwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR1Z1WkY5MllXd3VkbUZzS0cxaGVGOW1iM0p0WVhSMFpXUXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvWkdsemNHeGhlVjkyWVd4MVpWOWhjejA5WENKMFpYaDBYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1J6ZEdGeWRGOTJZV3d1YUhSdGJDaHRhVzVmWm05eWJXRjBkR1ZrS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JsYm1SZmRtRnNMbWgwYld3b2JXRjRYMlp2Y20xaGRIUmxaQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwya2dkR2hwYm1zZ2RHaGxJR1oxYm1OMGFXOXVJSFJvWVhRZ1luVnBiR1J6SUhSb1pTQlZVa3dnYm1WbFpITWdkRzhnWkdWamIyUmxJSFJvWlNCbWIzSnRZWFIwWldRZ2MzUnlhVzVuSUdKbFptOXlaU0JoWkdScGJtY2dkRzhnZEdobElIVnliRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlnb2MyVnNaaTVoZFhSdlgzVndaR0YwWlQwOU1TbDhmQ2h6Wld4bUxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsUFQweEtTbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXZibXg1SUhSeWVTQjBieUIxY0dSaGRHVWdhV1lnZEdobElIWmhiSFZsY3lCb1lYWmxJR0ZqZEhWaGJHeDVJR05vWVc1blpXUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDaHpiR2xrWlhKZmMzUmhjblJmZG1Gc0lUMXRhVzVmWm05eWJXRjBkR1ZrS1h4OEtITnNhV1JsY2w5bGJtUmZkbUZzSVQxdFlYaGZabTl5YldGMGRHVmtLU2tnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWNIVjBWWEJrWVhSbEtEZ3dNQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtTnNaV0Z5VkdsdFpYSW9LVHNnTHk5cFoyNXZjbVVnWVc1NUlHTm9ZVzVuWlhNZ2NtVmpaVzUwYkhrZ2JXRmtaU0JpZVNCMGFHVWdjMnhwWkdWeUlDaDBhR2x6SUhkaGN5QnFkWE4wSUdsdWFYUWdjMmh2ZFd4a2JpZDBJR052ZFc1MElHRnpJR0Z1SUhWd1pHRjBaU0JsZG1WdWRDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJSDA3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWFXNXBkQ0E5SUdaMWJtTjBhVzl1S0d0bFpYQmZjR0ZuYVc1aGRHbHZiaWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloclpXVndYM0JoWjJsdVlYUnBiMjRwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2EyVmxjRjl3WVdkcGJtRjBhVzl1SUQwZ1ptRnNjMlU3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVhVzVwZEVGMWRHOVZjR1JoZEdWRmRtVnVkSE1vS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWhkSFJoWTJoQlkzUnBkbVZEYkdGemN5Z3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWhaR1JFWVhSbFVHbGphMlZ5Y3lncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbUZrWkZKaGJtZGxVMnhwWkdWeWN5Z3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5cGJtbDBJR052YldKdklHSnZlR1Z6WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1kyOXRZbTlpYjNnZ1BTQWtkR2hwY3k1bWFXNWtLRndpYzJWc1pXTjBXMlJoZEdFdFkyOXRZbTlpYjNnOUp6RW5YVndpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1JqYjIxaWIySnZlQzVzWlc1bmRHZytNQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdOdmJXSnZZbTk0TG1WaFkyZ29ablZ1WTNScGIyNG9hVzVrWlhnZ0tYdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSFJvYVhOallpQTlJQ1FvSUhSb2FYTWdLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYm5KdElEMGdKSFJvYVhOallpNWhkSFJ5S0Z3aVpHRjBZUzFqYjIxaWIySnZlQzF1Y20xY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNoMGVYQmxiMllnSkhSb2FYTmpZaTVqYUc5elpXNGdJVDBnWENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJqYUc5elpXNXZjSFJwYjI1eklEMGdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVmhjbU5vWDJOdmJuUmhhVzV6T2lCMGNuVmxYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDA3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdvZEhsd1pXOW1LRzV5YlNraFBUMWNJblZ1WkdWbWFXNWxaRndpS1NZbUtHNXliU2twZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdZMmh2YzJWdWIzQjBhVzl1Y3k1dWIxOXlaWE4xYkhSelgzUmxlSFFnUFNCdWNtMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk4Z2MyRm1aU0IwYnlCMWMyVWdkR2hsSUdaMWJtTjBhVzl1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyVmhjbU5vWDJOdmJuUmhhVzV6WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YVhOZmNuUnNQVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGMyTmlMbUZrWkVOc1lYTnpLRndpWTJodmMyVnVMWEowYkZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUm9hWE5qWWk1amFHOXpaVzRvWTJodmMyVnViM0IwYVc5dWN5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MyVnNaV04wTW05d2RHbHZibk1nUFNCN2ZUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YVhOZmNuUnNQVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bFkzUXliM0IwYVc5dWN5NWthWElnUFNCY0luSjBiRndpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ2gwZVhCbGIyWW9ibkp0S1NFOVBWd2lkVzVrWldacGJtVmtYQ0lwSmlZb2JuSnRLU2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3hsWTNReWIzQjBhVzl1Y3k1c1lXNW5kV0ZuWlQwZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lGd2libTlTWlhOMWJIUnpYQ0k2SUdaMWJtTjBhVzl1S0NsN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQnVjbTA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhOallpNXpaV3hsWTNReUtITmxiR1ZqZERKdmNIUnBiMjV6S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBjMU4xWW0xcGRIUnBibWNnUFNCbVlXeHpaVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmFXWWdZV3BoZUNCcGN5QmxibUZpYkdWa0lHbHVhWFFnZEdobElIQmhaMmx1WVhScGIyNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1cGMxOWhhbUY0UFQweEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5ObGRIVndRV3BoZUZCaFoybHVZWFJwYjI0b0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdWIyNG9YQ0p6ZFdKdGFYUmNJaXdnZEdocGN5NXpkV0p0YVhSR2IzSnRLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhVzVwZEZkdmIwTnZiVzFsY21ObFEyOXVkSEp2YkhNb0tUc2dMeTkzYjI5amIyMXRaWEpqWlNCdmNtUmxjbUo1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHJaV1Z3WDNCaFoybHVZWFJwYjI0OVBXWmhiSE5sS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXhoYzNSZmMzVmliV2wwWDNGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdVoyVjBWWEpzVUdGeVlXMXpLR1poYkhObEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1dmJsZHBibVJ2ZDFOamNtOXNiQ0E5SUdaMWJtTjBhVzl1S0dWMlpXNTBLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tDRnpaV3htTG1selgyeHZZV1JwYm1kZmJXOXlaU2tnSmlZZ0tDRnpaV3htTG1selgyMWhlRjl3WVdkbFpDa3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCM2FXNWtiM2RmYzJOeWIyeHNJRDBnSkNoM2FXNWtiM2NwTG5OamNtOXNiRlJ2Y0NncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhkcGJtUnZkMTl6WTNKdmJHeGZZbTkwZEc5dElEMGdKQ2gzYVc1a2IzY3BMbk5qY205c2JGUnZjQ2dwSUNzZ0pDaDNhVzVrYjNjcExtaGxhV2RvZENncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOamNtOXNiRjl2Wm1aelpYUWdQU0J3WVhKelpVbHVkQ2h6Wld4bUxtbHVabWx1YVhSbFgzTmpjbTlzYkY5MGNtbG5aMlZ5WDJGdGIzVnVkQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNGthVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpNXNaVzVuZEdnOVBURXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGMzVnNkSE5mYzJOeWIyeHNYMkp2ZEhSdmJTQTlJSE5sYkdZdUpHbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJdWIyWm1jMlYwS0NrdWRHOXdJQ3NnYzJWc1ppNGthVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpNW9aV2xuYUhRb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUc5bVpuTmxkQ0E5SUNoelpXeG1MaVJwYm1acGJtbDBaVjl6WTNKdmJHeGZZMjl1ZEdGcGJtVnlMbTltWm5ObGRDZ3BMblJ2Y0NBcklITmxiR1l1SkdsdVptbHVhWFJsWDNOamNtOXNiRjlqYjI1MFlXbHVaWEl1YUdWcFoyaDBLQ2twSUMwZ2QybHVaRzkzWDNOamNtOXNiRHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2QybHVaRzkzWDNOamNtOXNiRjlpYjNSMGIyMGdQaUJ5WlhOMWJIUnpYM05qY205c2JGOWliM1IwYjIwZ0t5QnpZM0p2Ykd4ZmIyWm1jMlYwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNiMkZrVFc5eVpWSmxjM1ZzZEhNb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhzdkwyUnZiblFnYkc5aFpDQnRiM0psWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1emRISnBjRkYxWlhKNVUzUnlhVzVuUVc1a1NHRnphRVp5YjIxUVlYUm9JRDBnWm5WdVkzUnBiMjRvZFhKc0tTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCMWNtd3VjM0JzYVhRb1hDSS9YQ0lwV3pCZExuTndiR2wwS0Z3aUkxd2lLVnN3WFR0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WjNWd0lEMGdablZ1WTNScGIyNG9JRzVoYldVc0lIVnliQ0FwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tDRjFjbXdwSUhWeWJDQTlJR3h2WTJGMGFXOXVMbWh5WldaY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYm1GdFpTQTlJRzVoYldVdWNtVndiR0ZqWlNndlcxeGNXMTB2TEZ3aVhGeGNYRnhjVzF3aUtTNXlaWEJzWVdObEtDOWJYRnhkWFM4c1hDSmNYRnhjWEZ4ZFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnY21WblpYaFRJRDBnWENKYlhGeGNYRDhtWFZ3aUsyNWhiV1VyWENJOUtGdGVKaU5kS2lsY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEpsWjJWNElEMGdibVYzSUZKbFowVjRjQ2dnY21WblpYaFRJQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeVpYTjFiSFJ6SUQwZ2NtVm5aWGd1WlhobFl5Z2dkWEpzSUNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhKbGRIVnliaUJ5WlhOMWJIUnpJRDA5SUc1MWJHd2dQeUJ1ZFd4c0lEb2djbVZ6ZFd4MGMxc3hYVHRjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1blpYUlZjbXhRWVhKaGJYTWdQU0JtZFc1amRHbHZiaWhyWldWd1gzQmhaMmx1WVhScGIyNHNJSFI1Y0dVc0lHVjRZMngxWkdVcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9hMlZsY0Y5d1lXZHBibUYwYVc5dUtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR3RsWlhCZmNHRm5hVzVoZEdsdmJpQTlJSFJ5ZFdVN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBlWEJsS1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUjVjR1VnUFNCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RYSnNYM0JoY21GdGMxOXpkSElnUFNCY0lsd2lPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk4Z1oyVjBJR0ZzYkNCd1lYSmhiWE1nWm5KdmJTQm1hV1ZzWkhOY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliRjl3WVhKaGJYTmZZWEp5WVhrZ1BTQndjbTlqWlhOelgyWnZjbTB1WjJWMFZYSnNVR0Z5WVcxektITmxiR1lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR3hsYm1kMGFDQTlJRTlpYW1WamRDNXJaWGx6S0hWeWJGOXdZWEpoYlhOZllYSnlZWGtwTG14bGJtZDBhRHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdOdmRXNTBJRDBnTUR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaGxlR05zZFdSbEtTRTlYQ0oxYm1SbFptbHVaV1JjSWlrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0hWeWJGOXdZWEpoYlhOZllYSnlZWGt1YUdGelQzZHVVSEp2Y0dWeWRIa29aWGhqYkhWa1pTa3BJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnNaVzVuZEdndExUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2JHVnVaM1JvUGpBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnZjaUFvZG1GeUlHc2dhVzRnZFhKc1gzQmhjbUZ0YzE5aGNuSmhlU2tnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNoMWNteGZjR0Z5WVcxelgyRnljbUY1TG1oaGMwOTNibEJ5YjNCbGNuUjVLR3NwS1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1kyRnVYMkZrWkNBOUlIUnlkV1U3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmlobGVHTnNkV1JsS1NFOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYXowOVpYaGpiSFZrWlNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHTmhibDloWkdRZ1BTQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvWTJGdVgyRmtaQ2tnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkWEpzWDNCaGNtRnRjMTl6ZEhJZ0t6MGdheUFySUZ3aVBWd2lJQ3NnZFhKc1gzQmhjbUZ0YzE5aGNuSmhlVnRyWFR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9ZMjkxYm5RZ1BDQnNaVzVuZEdnZ0xTQXhLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZFhKc1gzQmhjbUZ0YzE5emRISWdLejBnWENJbVhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1kyOTFiblFyS3p0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhGMVpYSjVYM0JoY21GdGN5QTlJRndpWENJN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMlp2Y20wZ2NHRnlZVzF6SUdGeklIVnliQ0J4ZFdWeWVTQnpkSEpwYm1kY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHWnZjbTFmY0dGeVlXMXpJRDBnZFhKc1gzQmhjbUZ0YzE5emRISTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJkbGRDQjFjbXdnY0dGeVlXMXpJR1p5YjIwZ2RHaGxJR1p2Y20wZ2FYUnpaV3htSUNoM2FHRjBJSFJvWlNCMWMyVnlJR2hoY3lCelpXeGxZM1JsWkNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnY1hWbGNubGZjR0Z5WVcxeklEMGdjMlZzWmk1cWIybHVWWEpzVUdGeVlXMG9jWFZsY25sZmNHRnlZVzF6TENCbWIzSnRYM0JoY21GdGN5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJGa1pDQndZV2RwYm1GMGFXOXVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LR3RsWlhCZmNHRm5hVzVoZEdsdmJqMDlkSEoxWlNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEJoWjJWT2RXMWlaWElnUFNCelpXeG1MaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxtRjBkSElvWENKa1lYUmhMWEJoWjJWa1hDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaHdZV2RsVG5WdFltVnlLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQndZV2RsVG5WdFltVnlJRDBnTVR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHdZV2RsVG5WdFltVnlQakVwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY1hWbGNubGZjR0Z5WVcxeklEMGdjMlZzWmk1cWIybHVWWEpzVUdGeVlXMG9jWFZsY25sZmNHRnlZVzF6TENCY0luTm1YM0JoWjJWa1BWd2lLM0JoWjJWT2RXMWlaWElwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMkZrWkNCelptbGtYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVxYjJsdVZYSnNVR0Z5WVcwb2NYVmxjbmxmY0dGeVlXMXpMQ0JjSW5ObWFXUTlYQ0lyYzJWc1ppNXpabWxrS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZJR3h2YjNBZ2RHaHliM1ZuYUNCaGJua2daWGgwY21FZ2NHRnlZVzF6SUNobWNtOXRJR1Y0ZENCd2JIVm5hVzV6S1NCaGJtUWdZV1JrSUhSdklIUm9aU0IxY213Z0tHbGxJSGR2YjJOdmJXMWxjbU5sSUdCdmNtUmxjbUo1WUNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHlwMllYSWdaWGgwY21GZmNYVmxjbmxmY0dGeVlXMGdQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR3hsYm1kMGFDQTlJRTlpYW1WamRDNXJaWGx6S0hObGJHWXVaWGgwY21GZmNYVmxjbmxmY0dGeVlXMXpLUzVzWlc1bmRHZzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWTI5MWJuUWdQU0F3TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LR3hsYm1kMGFENHdLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUdadmNpQW9kbUZ5SUdzZ2FXNGdjMlZzWmk1bGVIUnlZVjl4ZFdWeWVWOXdZWEpoYlhNcElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2h6Wld4bUxtVjRkSEpoWDNGMVpYSjVYM0JoY21GdGN5NW9ZWE5QZDI1UWNtOXdaWEowZVNocktTa2dlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1WlhoMGNtRmZjWFZsY25sZmNHRnlZVzF6VzJ0ZElUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnWlhoMGNtRmZjWFZsY25sZmNHRnlZVzBnUFNCcksxd2lQVndpSzNObGJHWXVaWGgwY21GZmNYVmxjbmxmY0dGeVlXMXpXMnRkTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnY1hWbGNubGZjR0Z5WVcxeklEMGdjMlZzWmk1cWIybHVWWEpzVUdGeVlXMG9jWFZsY25sZmNHRnlZVzF6TENCbGVIUnlZVjl4ZFdWeWVWOXdZWEpoYlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBcUwxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxtRmtaRkYxWlhKNVVHRnlZVzF6S0hGMVpYSjVYM0JoY21GdGN5d2djMlZzWmk1bGVIUnlZVjl4ZFdWeWVWOXdZWEpoYlhNdVlXeHNLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtIUjVjR1VoUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Y1hWbGNubGZjR0Z5WVcxeklEMGdjMlZzWmk1aFpHUlJkV1Z5ZVZCaGNtRnRjeWh4ZFdWeWVWOXdZWEpoYlhNc0lITmxiR1l1WlhoMGNtRmZjWFZsY25sZmNHRnlZVzF6VzNSNWNHVmRLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVJSEYxWlhKNVgzQmhjbUZ0Y3p0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhaR1JSZFdWeWVWQmhjbUZ0Y3lBOUlHWjFibU4wYVc5dUtIRjFaWEo1WDNCaGNtRnRjeXdnYm1WM1gzQmhjbUZ0Y3lsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJsZUhSeVlWOXhkV1Z5ZVY5d1lYSmhiU0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJzWlc1bmRHZ2dQU0JQWW1wbFkzUXVhMlY1Y3lodVpYZGZjR0Z5WVcxektTNXNaVzVuZEdnN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmpiM1Z1ZENBOUlEQTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloc1pXNW5kR2crTUNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1p2Y2lBb2RtRnlJR3NnYVc0Z2JtVjNYM0JoY21GdGN5a2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2h1WlhkZmNHRnlZVzF6TG1oaGMwOTNibEJ5YjNCbGNuUjVLR3NwS1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlodVpYZGZjR0Z5WVcxelcydGRJVDFjSWx3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGVIUnlZVjl4ZFdWeWVWOXdZWEpoYlNBOUlHc3JYQ0k5WENJcmJtVjNYM0JoY21GdGMxdHJYVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIRjFaWEo1WDNCaGNtRnRjeUE5SUhObGJHWXVhbTlwYmxWeWJGQmhjbUZ0S0hGMVpYSjVYM0JoY21GdGN5d2daWGgwY21GZmNYVmxjbmxmY0dGeVlXMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnY1hWbGNubGZjR0Z5WVcxek8xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUZrWkZWeWJGQmhjbUZ0SUQwZ1puVnVZM1JwYjI0b2RYSnNMQ0J6ZEhKcGJtY3BYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1lXUmtYM0JoY21GdGN5QTlJRndpWENJN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgxY213aFBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIVnliQzVwYm1SbGVFOW1LRndpUDF3aUtTQWhQU0F0TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCaFpHUmZjR0Z5WVcxeklDczlJRndpSmx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZkWEpzSUQwZ2RHaHBjeTUwY21GcGJHbHVaMU5zWVhOb1NYUW9kWEpzS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JoWkdSZmNHRnlZVzF6SUNzOUlGd2lQMXdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWh6ZEhKcGJtY2hQVndpWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdkWEpzSUNzZ1lXUmtYM0JoY21GdGN5QXJJSE4wY21sdVp6dGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCbGJITmxYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQjFjbXc3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbXB2YVc1VmNteFFZWEpoYlNBOUlHWjFibU4wYVc5dUtIQmhjbUZ0Y3l3Z2MzUnlhVzVuS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR0ZrWkY5d1lYSmhiWE1nUFNCY0lsd2lPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2NHRnlZVzF6SVQxY0lsd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JoWkdSZmNHRnlZVzF6SUNzOUlGd2lKbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpkSEpwYm1jaFBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z2NHRnlZVzF6SUNzZ1lXUmtYM0JoY21GdGN5QXJJSE4wY21sdVp6dGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCbGJITmxYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQndZWEpoYlhNN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQjlPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5ObGRFRnFZWGhTWlhOMWJIUnpWVkpNY3lBOUlHWjFibU4wYVc5dUtIRjFaWEo1WDNCaGNtRnRjeWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1LVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aGFtRjRYM0psYzNWc2RITmZZMjl1WmlBOUlHNWxkeUJCY25KaGVTZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZHdjbTlqWlhOemFXNW5YM1Z5YkNkZElEMGdYQ0pjSWp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jbVZ6ZFd4MGMxOTFjbXduWFNBOUlGd2lYQ0k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1aYkoyUmhkR0ZmZEhsd1pTZGRJRDBnWENKY0lqdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2YVdZb2MyVnNaaTVoYW1GNFgzVnliQ0U5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1a2FYTndiR0Y1WDNKbGMzVnNkRjl0WlhSb2IyUTlQVndpYzJodmNuUmpiMlJsWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhzdkwzUm9aVzRnZDJVZ2QyRnVkQ0IwYnlCa2J5QmhJSEpsY1hWbGMzUWdkRzhnZEdobElHRnFZWGdnWlc1a2NHOXBiblJjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKM0psYzNWc2RITmZkWEpzSjEwZ1BTQnpaV3htTG1Ga1pGVnliRkJoY21GdEtITmxiR1l1Y21WemRXeDBjMTkxY213c0lIRjFaWEo1WDNCaGNtRnRjeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTloWkdRZ2JHRnVaeUJqYjJSbElIUnZJR0ZxWVhnZ1lYQnBJSEpsY1hWbGMzUXNJR3hoYm1jZ1kyOWtaU0J6YUc5MWJHUWdZV3h5WldGa2VTQmlaU0JwYmlCMGFHVnlaU0JtYjNJZ2IzUm9aWElnY21WeGRXVnpkSE1nS0dsbExDQnpkWEJ3YkdsbFpDQnBiaUIwYUdVZ1VtVnpkV3gwY3lCVlVrd3BYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1c1lXNW5YMk52WkdVaFBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5emJ5QmhaR1FnYVhSY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG1wdmFXNVZjbXhRWVhKaGJTaHhkV1Z5ZVY5d1lYSmhiWE1zSUZ3aWJHRnVaejFjSWl0elpXeG1MbXhoYm1kZlkyOWtaU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jSEp2WTJWemMybHVaMTkxY213blhTQTlJSE5sYkdZdVlXUmtWWEpzVUdGeVlXMG9jMlZzWmk1aGFtRjRYM1Z5YkN3Z2NYVmxjbmxmY0dGeVlXMXpLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuWkdGMFlWOTBlWEJsSjEwZ1BTQW5hbk52YmljN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb2MyVnNaaTVrYVhOd2JHRjVYM0psYzNWc2RGOXRaWFJvYjJROVBWd2ljRzl6ZEY5MGVYQmxYMkZ5WTJocGRtVmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY0hKdlkyVnpjMTltYjNKdExuTmxkRlJoZUVGeVkyaHBkbVZTWlhOMWJIUnpWWEpzS0hObGJHWXNJSE5sYkdZdWNtVnpkV3gwYzE5MWNtd3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlISmxjM1ZzZEhOZmRYSnNJRDBnY0hKdlkyVnpjMTltYjNKdExtZGxkRkpsYzNWc2RITlZjbXdvYzJWc1ppd2djMlZzWmk1eVpYTjFiSFJ6WDNWeWJDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuY21WemRXeDBjMTkxY213blhTQTlJSE5sYkdZdVlXUmtWWEpzVUdGeVlXMG9jbVZ6ZFd4MGMxOTFjbXdzSUhGMVpYSjVYM0JoY21GdGN5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZHdjbTlqWlhOemFXNW5YM1Z5YkNkZElEMGdjMlZzWmk1aFpHUlZjbXhRWVhKaGJTaHlaWE4xYkhSelgzVnliQ3dnY1hWbGNubGZjR0Z5WVcxektUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCcFppaHpaV3htTG1ScGMzQnNZWGxmY21WemRXeDBYMjFsZEdodlpEMDlYQ0pqZFhOMGIyMWZkMjl2WTI5dGJXVnlZMlZmYzNSdmNtVmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY0hKdlkyVnpjMTltYjNKdExuTmxkRlJoZUVGeVkyaHBkbVZTWlhOMWJIUnpWWEpzS0hObGJHWXNJSE5sYkdZdWNtVnpkV3gwYzE5MWNtd3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlISmxjM1ZzZEhOZmRYSnNJRDBnY0hKdlkyVnpjMTltYjNKdExtZGxkRkpsYzNWc2RITlZjbXdvYzJWc1ppd2djMlZzWmk1eVpYTjFiSFJ6WDNWeWJDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuY21WemRXeDBjMTkxY213blhTQTlJSE5sYkdZdVlXUmtWWEpzVUdGeVlXMG9jbVZ6ZFd4MGMxOTFjbXdzSUhGMVpYSjVYM0JoY21GdGN5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZHdjbTlqWlhOemFXNW5YM1Z5YkNkZElEMGdjMlZzWmk1aFpHUlZjbXhRWVhKaGJTaHlaWE4xYkhSelgzVnliQ3dnY1hWbGNubGZjR0Z5WVcxektUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3THk5dmRHaGxjbmRwYzJVZ2QyVWdkMkZ1ZENCMGJ5QndkV3hzSUhSb1pTQnlaWE4xYkhSeklHUnBjbVZqZEd4NUlHWnliMjBnZEdobElISmxjM1ZzZEhNZ2NHRm5aVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jbVZ6ZFd4MGMxOTFjbXduWFNBOUlITmxiR1l1WVdSa1ZYSnNVR0Z5WVcwb2MyVnNaaTV5WlhOMWJIUnpYM1Z5YkN3Z2NYVmxjbmxmY0dGeVlXMXpLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKM0J5YjJObGMzTnBibWRmZFhKc0oxMGdQU0J6Wld4bUxtRmtaRlZ5YkZCaGNtRnRLSE5sYkdZdVlXcGhlRjkxY213c0lIRjFaWEo1WDNCaGNtRnRjeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzTmxiR1l1WVdwaGVGOXlaWE4xYkhSelgyTnZibVpiSjJSaGRHRmZkSGx3WlNkZElEMGdKMmgwYld3bk8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkd2NtOWpaWE56YVc1blgzVnliQ2RkSUQwZ2MyVnNaaTVoWkdSUmRXVnllVkJoY21GdGN5aHpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkd2NtOWpaWE56YVc1blgzVnliQ2RkTENCelpXeG1MbVY0ZEhKaFgzRjFaWEo1WDNCaGNtRnRjMXNuWVdwaGVDZGRLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKMlJoZEdGZmRIbHdaU2RkSUQwZ2MyVnNaaTVoYW1GNFgyUmhkR0ZmZEhsd1pUdGNjbHh1SUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWRYQmtZWFJsVEc5aFpHVnlWR0ZuSUQwZ1puVnVZM1JwYjI0b0pHOWlhbVZqZEN3Z2RHRm5UbUZ0WlNrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSd1lYSmxiblE3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1sdVptbHVhWFJsWDNOamNtOXNiRjl5WlhOMWJIUmZZMnhoYzNNaFBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSd1lYSmxiblFnUFNCelpXeG1MaVJwYm1acGJtbDBaVjl6WTNKdmJHeGZZMjl1ZEdGcGJtVnlMbVpwYm1Rb2MyVnNaaTVwYm1acGJtbDBaVjl6WTNKdmJHeGZjbVZ6ZFd4MFgyTnNZWE56S1M1c1lYTjBLQ2t1Y0dGeVpXNTBLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2NHRnlaVzUwSUQwZ2MyVnNaaTRrYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUmhaMDVoYldVZ1BTQWtjR0Z5Wlc1MExuQnliM0FvWENKMFlXZE9ZVzFsWENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhSaFoxUjVjR1VnUFNBblpHbDJKenRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvSUNnZ2RHRm5UbUZ0WlM1MGIweHZkMlZ5UTJGelpTZ3BJRDA5SUNkdmJDY2dLU0I4ZkNBb0lIUmhaMDVoYldVdWRHOU1iM2RsY2tOaGMyVW9LU0E5UFNBbmRXd25JQ2tnS1h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIUmhaMVI1Y0dVZ1BTQW5iR2tuTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKRzVsZHlBOUlDUW9KenduSzNSaFoxUjVjR1VySnlBdlBpY3BMbWgwYld3b0pHOWlhbVZqZEM1b2RHMXNLQ2twTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1lYUjBjbWxpZFhSbGN5QTlJQ1J2WW1wbFkzUXVjSEp2Y0NoY0ltRjBkSEpwWW5WMFpYTmNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkx5QnNiMjl3SUhSb2NtOTFaMmdnUEhObGJHVmpkRDRnWVhSMGNtbGlkWFJsY3lCaGJtUWdZWEJ3YkhrZ2RHaGxiU0J2YmlBOFpHbDJQbHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWtMbVZoWTJnb1lYUjBjbWxpZFhSbGN5d2dablZ1WTNScGIyNG9LU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2JtVjNMbUYwZEhJb2RHaHBjeTV1WVcxbExDQjBhR2x6TG5aaGJIVmxLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnSkc1bGR6dGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1c2IyRmtUVzl5WlZKbGMzVnNkSE1nUFNCbWRXNWpkR2x2YmlncFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaUFvSUhSb2FYTXVhWE5mYldGNFgzQmhaMlZrSUQwOVBTQjBjblZsSUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhWE5mYkc5aFpHbHVaMTl0YjNKbElEMGdkSEoxWlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZkSEpwWjJkbGNpQnpkR0Z5ZENCbGRtVnVkRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWlhabGJuUmZaR0YwWVNBOUlIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5tYVdRNklITmxiR1l1YzJacFpDeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFJoY21kbGRGTmxiR1ZqZEc5eU9pQnpaV3htTG1GcVlYaGZkR0Z5WjJWMFgyRjBkSElzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMGVYQmxPaUJjSW14dllXUmZiVzl5WlZ3aUxGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdiMkpxWldOME9pQnpaV3htWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDA3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MblJ5YVdkblpYSkZkbVZ1ZENoY0luTm1PbUZxWVhoemRHRnlkRndpTENCbGRtVnVkRjlrWVhSaEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NISnZZMlZ6YzE5bWIzSnRMbk5sZEZSaGVFRnlZMmhwZG1WU1pYTjFiSFJ6VlhKc0tITmxiR1lzSUhObGJHWXVjbVZ6ZFd4MGMxOTFjbXdwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JqYjI1emIyeGxMbXh2WnloY0lteHZZV1FnYlc5eVpTQnlaWE4xYkhSelhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmpiMjV6YjJ4bExteHZaeWhjSW5KbGMzVnNkSE1nZFhKc09pQmNJaXR6Wld4bUxuSmxjM1ZzZEhOZmRYSnNLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdVoyVjBWWEpzVUdGeVlXMXpLSFJ5ZFdVcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXhoYzNSZmMzVmliV2wwWDNGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdVoyVjBWWEpzVUdGeVlXMXpLR1poYkhObEtUc2dMeTluY21GaUlHRWdZMjl3ZVNCdlppQm9kR1VnVlZKTUlIQmhjbUZ0Y3lCM2FYUm9iM1YwSUhCaFoybHVZWFJwYjI0Z1lXeHlaV0ZrZVNCaFpHUmxaRnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHRnFZWGhmY0hKdlkyVnpjMmx1WjE5MWNtd2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdZV3BoZUY5eVpYTjFiSFJ6WDNWeWJDQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtZWFJoWDNSNWNHVWdQU0JjSWx3aU8xeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmJtOTNJR0ZrWkNCMGFHVWdibVYzSUhCaFoybHVZWFJwYjI1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHNWxlSFJmY0dGblpXUmZiblZ0WW1WeUlEMGdkR2hwY3k1amRYSnlaVzUwWDNCaFoyVmtJQ3NnTVR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnY1hWbGNubGZjR0Z5WVcxeklEMGdjMlZzWmk1cWIybHVWWEpzVUdGeVlXMG9jWFZsY25sZmNHRnlZVzF6TENCY0luTm1YM0JoWjJWa1BWd2lLMjVsZUhSZmNHRm5aV1JmYm5WdFltVnlLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjMlYwUVdwaGVGSmxjM1ZzZEhOVlVreHpLSEYxWlhKNVgzQmhjbUZ0Y3lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdGcVlYaGZjSEp2WTJWemMybHVaMTkxY213Z1BTQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkd2NtOWpaWE56YVc1blgzVnliQ2RkTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JoYW1GNFgzSmxjM1ZzZEhOZmRYSnNJRDBnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jbVZ6ZFd4MGMxOTFjbXduWFR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlWOTBlWEJsSUQwZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuWkdGMFlWOTBlWEJsSjEwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMkZpYjNKMElHRnVlU0J3Y21WMmFXOTFjeUJoYW1GNElISmxjWFZsYzNSelhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1FwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXViR0Z6ZEY5aGFtRjRYM0psY1hWbGMzUXVZV0p2Y25Rb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNTFjMlZmYzJOeWIyeHNYMnh2WVdSbGNqMDlNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUnNiMkZrWlhJZ1BTQWtLQ2M4WkdsMkx6NG5MSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQW5ZMnhoYzNNbk9pQW5jMlZoY21Ob0xXWnBiSFJsY2kxelkzSnZiR3d0Ykc5aFpHbHVaeWRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE95OHZMbUZ3Y0dWdVpGUnZLSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWElwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JzYjJGa1pYSWdQU0J6Wld4bUxuVndaR0YwWlV4dllXUmxjbFJoWnlna2JHOWhaR1Z5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHVabWx1YVhSbFUyTnliMnhzUVhCd1pXNWtLQ1JzYjJGa1pYSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHTnZibk52YkdVdWJHOW5LRndpWVdwaGVGOXdjbTlqWlhOemFXNW5YM1Z5YkRvZ1hDSXJZV3BoZUY5d2NtOWpaWE56YVc1blgzVnliQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWJHRnpkRjloYW1GNFgzSmxjWFZsYzNRZ1BTQWtMbWRsZENoaGFtRjRYM0J5YjJObGMzTnBibWRmZFhKc0xDQm1kVzVqZEdsdmJpaGtZWFJoTENCemRHRjBkWE1zSUhKbGNYVmxjM1FwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZM1Z5Y21WdWRGOXdZV2RsWkNzck8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c1lYTjBYMkZxWVhoZmNtVnhkV1Z6ZENBOUlHNTFiR3c3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeThnS2lvcUtpb3FLaW9xS2lvcUtpcGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2SUZSUFJFOGdMU0JRUVZOVVJTQlVTRWxUSUVGT1JDQlhRVlJEU0NCVVNFVWdVa1ZFU1ZKRlExUWdMU0JQVGt4WklFaEJVRkJGVGxNZ1YwbFVTQ0JYUXlBb1ExQlVJRUZPUkNCVVFWZ2dSRTlGVXlCT1QxUXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2THlCb2RIUndjem92TDNObFlYSmphQzFtYVd4MFpYSXVkR1Z6ZEM5d2NtOWtkV04wTFdOaGRHVm5iM0o1TDJOc2IzUm9hVzVuTDNSemFHbHlkSE12Y0dGblpTOHpMejl6Wmw5d1lXZGxaRDB6WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTkxY0dSaGRHVnpJSFJvWlNCeVpYTjFkR3h6SUNZZ1ptOXliU0JvZEcxc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1Ga1pGSmxjM1ZzZEhNb1pHRjBZU3dnWkdGMFlWOTBlWEJsS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHNJR1JoZEdGZmRIbHdaU2t1Wm1GcGJDaG1kVzVqZEdsdmJpaHFjVmhJVWl3Z2RHVjRkRk4wWVhSMWN5d2daWEp5YjNKVWFISnZkMjRwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtZWFJoSUQwZ2UzMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExuTm1hV1FnUFNCelpXeG1Mbk5tYVdRN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG05aWFtVmpkQ0E5SUhObGJHWTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExuUmhjbWRsZEZObGJHVmpkRzl5SUQwZ2MyVnNaaTVoYW1GNFgzUmhjbWRsZEY5aGRIUnlPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNWhhbUY0VlZKTUlEMGdZV3BoZUY5d2NtOWpaWE56YVc1blgzVnliRHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVhbkZZU0ZJZ1BTQnFjVmhJVWp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1ZEdWNGRGTjBZWFIxY3lBOUlIUmxlSFJUZEdGMGRYTTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtVnljbTl5VkdoeWIzZHVJRDBnWlhKeWIzSlVhSEp2ZDI0N1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5SeWFXZG5aWEpGZG1WdWRDaGNJbk5tT21GcVlYaGxjbkp2Y2x3aUxDQmtZWFJoS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBMbUZzZDJGNWN5aG1kVzVqZEdsdmJpZ3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1lYUmhJRDBnZTMwN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG5ObWFXUWdQU0J6Wld4bUxuTm1hV1E3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMblJoY21kbGRGTmxiR1ZqZEc5eUlEMGdjMlZzWmk1aGFtRjRYM1JoY21kbGRGOWhkSFJ5TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzV2WW1wbFkzUWdQU0J6Wld4bU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1ZFhObFgzTmpjbTlzYkY5c2IyRmtaWEk5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHeHZZV1JsY2k1a1pYUmhZMmdvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx6WDJ4dllXUnBibWRmYlc5eVpTQTlJR1poYkhObE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVkSEpwWjJkbGNrVjJaVzUwS0Z3aWMyWTZZV3BoZUdacGJtbHphRndpTENCa1lYUmhLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbVpsZEdOb1FXcGhlRkpsYzNWc2RITWdQU0JtZFc1amRHbHZiaWdwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwzUnlhV2RuWlhJZ2MzUmhjblFnWlhabGJuUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1YyWlc1MFgyUmhkR0VnUFNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpabWxrT2lCelpXeG1Mbk5tYVdRc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjBZWEpuWlhSVFpXeGxZM1J2Y2pvZ2MyVnNaaTVoYW1GNFgzUmhjbWRsZEY5aGRIUnlMRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZEhsd1pUb2dYQ0pzYjJGa1gzSmxjM1ZzZEhOY0lpeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzlpYW1WamREb2djMlZzWmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTUwY21sbloyVnlSWFpsYm5Rb1hDSnpaanBoYW1GNGMzUmhjblJjSWl3Z1pYWmxiblJmWkdGMFlTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDNKbFptOWpkWE1nWVc1NUlHbHVjSFYwSUdacFpXeGtjeUJoWm5SbGNpQjBhR1VnWm05eWJTQm9ZWE1nWW1WbGJpQjFjR1JoZEdWa1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtiR0Z6ZEY5aFkzUnBkbVZmYVc1d2RYUmZkR1Y0ZENBOUlDUjBhR2x6TG1acGJtUW9KMmx1Y0hWMFczUjVjR1U5WENKMFpYaDBYQ0pkT21adlkzVnpKeWt1Ym05MEtGd2lMbk5tTFdSaGRHVndhV05yWlhKY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1JzWVhOMFgyRmpkR2wyWlY5cGJuQjFkRjkwWlhoMExteGxibWQwYUQwOU1TbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUd4aGMzUmZZV04wYVhabFgybHVjSFYwWDNSbGVIUWdQU0FrYkdGemRGOWhZM1JwZG1WZmFXNXdkWFJmZEdWNGRDNWhkSFJ5S0Z3aWJtRnRaVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0pIUm9hWE11WVdSa1EyeGhjM01vWENKelpXRnlZMmd0Wm1sc2RHVnlMV1JwYzJGaWJHVmtYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J3Y205alpYTnpYMlp2Y20wdVpHbHpZV0pzWlVsdWNIVjBjeWh6Wld4bUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2Wm1Ga1pTQnZkWFFnY21WemRXeDBjMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbUZ1YVcxaGRHVW9leUJ2Y0dGamFYUjVPaUF3TGpVZ2ZTd2dYQ0ptWVhOMFhDSXBPeUF2TDJ4dllXUnBibWRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1bVlXUmxRMjl1ZEdWdWRFRnlaV0Z6S0NCY0ltOTFkRndpSUNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxtRnFZWGhmWVdOMGFXOXVQVDFjSW5CaFoybHVZWFJwYjI1Y0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl1WldWa0lIUnZJSEpsYlc5MlpTQmhZM1JwZG1VZ1ptbHNkR1Z5SUdaeWIyMGdWVkpNWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG14aGMzUmZjM1ZpYldsMFgzRjFaWEo1WDNCaGNtRnRjenRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMjV2ZHlCaFpHUWdkR2hsSUc1bGR5QndZV2RwYm1GMGFXOXVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NHRm5aVTUxYldKbGNpQTlJSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1WVhSMGNpaGNJbVJoZEdFdGNHRm5aV1JjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hCaFoyVk9kVzFpWlhJcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhCaFoyVk9kVzFpWlhJZ1BTQXhPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NISnZZMlZ6YzE5bWIzSnRMbk5sZEZSaGVFRnlZMmhwZG1WU1pYTjFiSFJ6VlhKc0tITmxiR1lzSUhObGJHWXVjbVZ6ZFd4MGMxOTFjbXdwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NYVmxjbmxmY0dGeVlXMXpJRDBnYzJWc1ppNW5aWFJWY214UVlYSmhiWE1vWm1Gc2MyVXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSEJoWjJWT2RXMWlaWEkrTVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxtcHZhVzVWY214UVlYSmhiU2h4ZFdWeWVWOXdZWEpoYlhNc0lGd2ljMlpmY0dGblpXUTlYQ0lyY0dGblpVNTFiV0psY2lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9jMlZzWmk1aGFtRjRYMkZqZEdsdmJqMDlYQ0p6ZFdKdGFYUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIRjFaWEo1WDNCaGNtRnRjeUE5SUhObGJHWXVaMlYwVlhKc1VHRnlZVzF6S0hSeWRXVXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNZWE4wWDNOMVltMXBkRjl4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG1kbGRGVnliRkJoY21GdGN5aG1ZV3h6WlNrN0lDOHZaM0poWWlCaElHTnZjSGtnYjJZZ2FIUmxJRlZTVENCd1lYSmhiWE1nZDJsMGFHOTFkQ0J3WVdkcGJtRjBhVzl1SUdGc2NtVmhaSGtnWVdSa1pXUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdGcVlYaGZjSEp2WTJWemMybHVaMTkxY213Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1lXcGhlRjl5WlhOMWJIUnpYM1Z5YkNBOUlGd2lYQ0k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1lYUmhYM1I1Y0dVZ1BTQmNJbHdpTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV6WlhSQmFtRjRVbVZ6ZFd4MGMxVlNUSE1vY1hWbGNubGZjR0Z5WVcxektUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1lXcGhlRjl3Y205alpYTnphVzVuWDNWeWJDQTlJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1aYkozQnliMk5sYzNOcGJtZGZkWEpzSjEwN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdGcVlYaGZjbVZ6ZFd4MGMxOTFjbXdnUFNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR5WlhOMWJIUnpYM1Z5YkNkZE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhYM1I1Y0dVZ1BTQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lka1lYUmhYM1I1Y0dVblhUdGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyRmliM0owSUdGdWVTQndjbVYyYVc5MWN5QmhhbUY0SUhKbGNYVmxjM1J6WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXViR0Z6ZEY5aGFtRjRYM0psY1hWbGMzUXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWJHRnpkRjloYW1GNFgzSmxjWFZsYzNRdVlXSnZjblFvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1lXcGhlRjloWTNScGIyNGdQU0J6Wld4bUxtRnFZWGhmWVdOMGFXOXVPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG14aGMzUmZZV3BoZUY5eVpYRjFaWE4wSUQwZ0pDNW5aWFFvWVdwaGVGOXdjbTlqWlhOemFXNW5YM1Z5YkN3Z1puVnVZM1JwYjI0b1pHRjBZU3dnYzNSaGRIVnpMQ0J5WlhGMVpYTjBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxteGhjM1JmWVdwaGVGOXlaWEYxWlhOMElEMGdiblZzYkR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNWd1pHRjBaWE1nZEdobElISmxjM1YwYkhNZ0ppQm1iM0p0SUdoMGJXeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRYQmtZWFJsVW1WemRXeDBjeWhrWVhSaExDQmtZWFJoWDNSNWNHVXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZJSE5qY205c2JDQmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2SUhObGRDQjBhR1VnZG1GeUlHSmhZMnNnZEc4Z2QyaGhkQ0JwZENCM1lYTWdZbVZtYjNKbElIUm9aU0JoYW1GNElISmxjWFZsYzNRZ2JtRmtJSFJvWlNCbWIzSnRJSEpsTFdsdWFYUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVlXcGhlRjloWTNScGIyNGdQU0JoYW1GNFgyRmpkR2x2Ymp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YzJOeWIyeHNVbVZ6ZFd4MGN5Z2djMlZzWmk1aGFtRjRYMkZqZEdsdmJpQXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHFJSFZ3WkdGMFpTQlZVa3dnS2k5Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZkWEJrWVhSbElIVnliQ0JpWldadmNtVWdjR0ZuYVc1aGRHbHZiaXdnWW1WallYVnpaU0IzWlNCdVpXVmtJSFJ2SUdSdklITnZiV1VnWTJobFkydHpJR0ZuWVdsdWN5QjBhR1VnVlZKTUlHWnZjaUJwYm1acGJtbDBaU0J6WTNKdmJHeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRYQmtZWFJsVlhKc1NHbHpkRzl5ZVNoaGFtRjRYM0psYzNWc2RITmZkWEpzS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNObGRIVndJSEJoWjJsdVlYUnBiMjVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjMlYwZFhCQmFtRjRVR0ZuYVc1aGRHbHZiaWdwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFYTlRkV0p0YVhSMGFXNW5JRDBnWm1Gc2MyVTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5b2dkWE5sY2lCa1pXWWdLaTljY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhVzVwZEZkdmIwTnZiVzFsY21ObFEyOXVkSEp2YkhNb0tUc2dMeTkzYjI5amIyMXRaWEpqWlNCdmNtUmxjbUo1WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmU3dnWkdGMFlWOTBlWEJsS1M1bVlXbHNLR1oxYm1OMGFXOXVLR3B4V0VoU0xDQjBaWGgwVTNSaGRIVnpMQ0JsY25KdmNsUm9jbTkzYmlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdFZ1BTQjdmVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVjMlpwWkNBOUlITmxiR1l1YzJacFpEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdWRHRnlaMlYwVTJWc1pXTjBiM0lnUFNCelpXeG1MbUZxWVhoZmRHRnlaMlYwWDJGMGRISTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtOWlhbVZqZENBOUlITmxiR1k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMbUZxWVhoVlVrd2dQU0JoYW1GNFgzQnliMk5sYzNOcGJtZGZkWEpzTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzVxY1ZoSVVpQTlJR3B4V0VoU08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1MFpYaDBVM1JoZEhWeklEMGdkR1Y0ZEZOMFlYUjFjenRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVaWEp5YjNKVWFISnZkMjRnUFNCbGNuSnZjbFJvY205M2JqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFYTlRkV0p0YVhSMGFXNW5JRDBnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxuUnlhV2RuWlhKRmRtVnVkQ2hjSW5ObU9tRnFZWGhsY25KdmNsd2lMQ0JrWVhSaEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDBwTG1Gc2QyRjVjeWhtZFc1amRHbHZiaWdwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVKR0ZxWVhoZmNtVnpkV3gwYzE5amIyNTBZV2x1WlhJdWMzUnZjQ2gwY25WbExIUnlkV1VwTG1GdWFXMWhkR1VvZXlCdmNHRmphWFI1T2lBeGZTd2dYQ0ptWVhOMFhDSXBPeUF2TDJacGJtbHphR1ZrSUd4dllXUnBibWRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVabUZrWlVOdmJuUmxiblJCY21WaGN5Z2dYQ0pwYmx3aUlDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1pHRjBZU0E5SUh0OU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1elptbGtJRDBnYzJWc1ppNXpabWxrTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzUwWVhKblpYUlRaV3hsWTNSdmNpQTlJSE5sYkdZdVlXcGhlRjkwWVhKblpYUmZZWFIwY2p0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1YjJKcVpXTjBJRDBnYzJWc1pqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdsekxuSmxiVzkyWlVOc1lYTnpLRndpYzJWaGNtTm9MV1pwYkhSbGNpMWthWE5oWW14bFpGd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhCeWIyTmxjM05mWm05eWJTNWxibUZpYkdWSmJuQjFkSE1vYzJWc1ppazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaV1p2WTNWeklIUm9aU0JzWVhOMElHRmpkR2wyWlNCMFpYaDBJR1pwWld4a1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWhzWVhOMFgyRmpkR2wyWlY5cGJuQjFkRjkwWlhoMElUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWthVzV3ZFhRZ1BTQmJYVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlSbWFXVnNaSE11WldGamFDaG1kVzVqZEdsdmJpZ3BlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JoWTNScGRtVmZhVzV3ZFhRZ1BTQWtLSFJvYVhNcExtWnBibVFvWENKcGJuQjFkRnR1WVcxbFBTZGNJaXRzWVhOMFgyRmpkR2wyWlY5cGJuQjFkRjkwWlhoMEsxd2lKMTFjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1JoWTNScGRtVmZhVzV3ZFhRdWJHVnVaM1JvUFQweEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2FXNXdkWFFnUFNBa1lXTjBhWFpsWDJsdWNIVjBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDUnBibkIxZEM1c1pXNW5kR2c5UFRFcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNScGJuQjFkQzVtYjJOMWN5Z3BMblpoYkNna2FXNXdkWFF1ZG1Gc0tDa3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtWnZZM1Z6UTJGdGNHOG9KR2x1Y0hWMFd6QmRLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdVptbHVaQ2hjSW1sdWNIVjBXMjVoYldVOUoxOXpabDl6WldGeVkyZ25YVndpS1M1MGNtbG5aMlZ5S0NkbWIyTjFjeWNwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTUwY21sbloyVnlSWFpsYm5Rb1hDSnpaanBoYW1GNFptbHVhWE5vWENJc0lDQmtZWFJoSUNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbVp2WTNWelEyRnRjRzhnUFNCbWRXNWpkR2x2YmlocGJuQjFkRVpwWld4a0tYdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OTJZWElnYVc1d2RYUkdhV1ZzWkNBOUlHUnZZM1Z0Wlc1MExtZGxkRVZzWlcxbGJuUkNlVWxrS0dsa0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLR2x1Y0hWMFJtbGxiR1FnSVQwZ2JuVnNiQ0FtSmlCcGJuQjFkRVpwWld4a0xuWmhiSFZsTG14bGJtZDBhQ0FoUFNBd0tYdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNocGJuQjFkRVpwWld4a0xtTnlaV0YwWlZSbGVIUlNZVzVuWlNsN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlFWnBaV3hrVW1GdVoyVWdQU0JwYm5CMWRFWnBaV3hrTG1OeVpXRjBaVlJsZUhSU1lXNW5aU2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRVpwWld4a1VtRnVaMlV1Ylc5MlpWTjBZWEowS0NkamFHRnlZV04wWlhJbkxHbHVjSFYwUm1sbGJHUXVkbUZzZFdVdWJHVnVaM1JvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JHYVdWc1pGSmhibWRsTG1OdmJHeGhjSE5sS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnUm1sbGJHUlNZVzVuWlM1elpXeGxZM1FvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWxiSE5sSUdsbUlDaHBibkIxZEVacFpXeGtMbk5sYkdWamRHbHZibE4wWVhKMElIeDhJR2x1Y0hWMFJtbGxiR1F1YzJWc1pXTjBhVzl1VTNSaGNuUWdQVDBnSnpBbktTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1ZzWlcxTVpXNGdQU0JwYm5CMWRFWnBaV3hrTG5aaGJIVmxMbXhsYm1kMGFEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcGJuQjFkRVpwWld4a0xuTmxiR1ZqZEdsdmJsTjBZWEowSUQwZ1pXeGxiVXhsYmp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwYm5CMWRFWnBaV3hrTG5ObGJHVmpkR2x2YmtWdVpDQTlJR1ZzWlcxTVpXNDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcGJuQjFkRVpwWld4a0xtSnNkWElvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbHVjSFYwUm1sbGJHUXVabTlqZFhNb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTQmxiSE5sZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLQ0JwYm5CMWRFWnBaV3hrSUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsdWNIVjBSbWxsYkdRdVptOWpkWE1vS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuUnlhV2RuWlhKRmRtVnVkQ0E5SUdaMWJtTjBhVzl1S0dWMlpXNTBibUZ0WlN3Z1pHRjBZU2xjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtaWFpsYm5SZlkyOXVkR0ZwYm1WeUlEMGdKQ2hjSWk1elpXRnlZMmhoYm1SbWFXeDBaWEpiWkdGMFlTMXpaaTFtYjNKdExXbGtQU2RjSWl0elpXeG1Mbk5tYVdRclhDSW5YVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkdWMlpXNTBYMk52Ym5SaGFXNWxjaTUwY21sbloyVnlLR1YyWlc1MGJtRnRaU3dnV3lCa1lYUmhJRjBwTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVtWlhSamFFRnFZWGhHYjNKdElEMGdablZ1WTNScGIyNG9LVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5MGNtbG5aMlZ5SUhOMFlYSjBJR1YyWlc1MFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmxkbVZ1ZEY5a1lYUmhJRDBnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyWnBaRG9nYzJWc1ppNXpabWxrTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHRnlaMlYwVTJWc1pXTjBiM0k2SUhObGJHWXVZV3BoZUY5MFlYSm5aWFJmWVhSMGNpeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFI1Y0dVNklGd2labTl5YlZ3aUxGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdiMkpxWldOME9pQnpaV3htWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDA3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MblJ5YVdkblpYSkZkbVZ1ZENoY0luTm1PbUZxWVhobWIzSnRjM1JoY25SY0lpd2dXeUJsZG1WdWRGOWtZWFJoSUYwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdVlXUmtRMnhoYzNNb1hDSnpaV0Z5WTJndFptbHNkR1Z5TFdScGMyRmliR1ZrWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCd2NtOWpaWE56WDJadmNtMHVaR2x6WVdKc1pVbHVjSFYwY3loelpXeG1LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQnhkV1Z5ZVY5d1lYSmhiWE1nUFNCelpXeG1MbWRsZEZWeWJGQmhjbUZ0Y3lncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNXNZVzVuWDJOdlpHVWhQVndpWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjMjhnWVdSa0lHbDBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG1wdmFXNVZjbXhRWVhKaGJTaHhkV1Z5ZVY5d1lYSmhiWE1zSUZ3aWJHRnVaejFjSWl0elpXeG1MbXhoYm1kZlkyOWtaU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmhhbUY0WDNCeWIyTmxjM05wYm1kZmRYSnNJRDBnYzJWc1ppNWhaR1JWY214UVlYSmhiU2h6Wld4bUxtRnFZWGhmWm05eWJWOTFjbXdzSUhGMVpYSjVYM0JoY21GdGN5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrWVhSaFgzUjVjR1VnUFNCY0ltcHpiMjVjSWp0Y2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJGaWIzSjBJR0Z1ZVNCd2NtVjJhVzkxY3lCaGFtRjRJSEpsY1hWbGMzUnpYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHFhV1lvYzJWc1ppNXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1F1WVdKdmNuUW9LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJSDBxTDF4eVhHNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2YzJWc1ppNXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDQTlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FrTG1kbGRDaGhhbUY0WDNCeWIyTmxjM05wYm1kZmRYSnNMQ0JtZFc1amRHbHZiaWhrWVhSaExDQnpkR0YwZFhNc0lISmxjWFZsYzNRcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjMlZzWmk1c1lYTjBYMkZxWVhoZmNtVnhkV1Z6ZENBOUlHNTFiR3c3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTkxY0dSaGRHVnpJSFJvWlNCeVpYTjFkR3h6SUNZZ1ptOXliU0JvZEcxc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5Wd1pHRjBaVVp2Y20wb1pHRjBZU3dnWkdGMFlWOTBlWEJsS1R0Y2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5TENCa1lYUmhYM1I1Y0dVcExtWmhhV3dvWm5WdVkzUnBiMjRvYW5GWVNGSXNJSFJsZUhSVGRHRjBkWE1zSUdWeWNtOXlWR2h5YjNkdUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWkdGMFlTQTlJSHQ5TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzV6Wm1sa0lEMGdjMlZzWmk1elptbGtPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNTBZWEpuWlhSVFpXeGxZM1J2Y2lBOUlITmxiR1l1WVdwaGVGOTBZWEpuWlhSZllYUjBjanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXViMkpxWldOMElEMGdjMlZzWmp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1WVdwaGVGVlNUQ0E5SUdGcVlYaGZjSEp2WTJWemMybHVaMTkxY213N1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG1weFdFaFNJRDBnYW5GWVNGSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExuUmxlSFJUZEdGMGRYTWdQU0IwWlhoMFUzUmhkSFZ6TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzVsY25KdmNsUm9jbTkzYmlBOUlHVnljbTl5VkdoeWIzZHVPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNTBjbWxuWjJWeVJYWmxiblFvWENKelpqcGhhbUY0WlhKeWIzSmNJaXdnV3lCa1lYUmhJRjBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTa3VZV3gzWVhsektHWjFibU4wYVc5dUtDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSaGRHRWdQU0I3ZlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1YzJacFpDQTlJSE5sYkdZdWMyWnBaRHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVkR0Z5WjJWMFUyVnNaV04wYjNJZ1BTQnpaV3htTG1GcVlYaGZkR0Z5WjJWMFgyRjBkSEk3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMbTlpYW1WamRDQTlJSE5sYkdZN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTXVjbVZ0YjNabFEyeGhjM01vWENKelpXRnlZMmd0Wm1sc2RHVnlMV1JwYzJGaWJHVmtYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NISnZZMlZ6YzE5bWIzSnRMbVZ1WVdKc1pVbHVjSFYwY3loelpXeG1LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5SeWFXZG5aWEpGZG1WdWRDaGNJbk5tT21GcVlYaG1iM0p0Wm1sdWFYTm9YQ0lzSUZzZ1pHRjBZU0JkS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1amIzQjVUR2x6ZEVsMFpXMXpRMjl1ZEdWdWRITWdQU0JtZFc1amRHbHZiaWdrYkdsemRGOW1jbTl0TENBa2JHbHpkRjkwYnlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6Wld4bUlEMGdkR2hwY3p0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZZMjl3ZVNCdmRtVnlJR05vYVd4a0lHeHBjM1FnYVhSbGJYTmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR3hwWDJOdmJuUmxiblJ6WDJGeWNtRjVJRDBnYm1WM0lFRnljbUY1S0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1jbTl0WDJGMGRISnBZblYwWlhNZ1BTQnVaWGNnUVhKeVlYa29LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtabkp2YlY5bWFXVnNaSE1nUFNBa2JHbHpkRjltY205dExtWnBibVFvWENJK0lIVnNJRDRnYkdsY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FrWm5KdmJWOW1hV1ZzWkhNdVpXRmphQ2htZFc1amRHbHZiaWhwS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JzYVY5amIyNTBaVzUwYzE5aGNuSmhlUzV3ZFhOb0tDUW9kR2hwY3lrdWFIUnRiQ2dwS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1lYUjBjbWxpZFhSbGN5QTlJQ1FvZEdocGN5a3VjSEp2Y0NoY0ltRjBkSEpwWW5WMFpYTmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbWNtOXRYMkYwZEhKcFluVjBaWE11Y0hWemFDaGhkSFJ5YVdKMWRHVnpLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1poY2lCbWFXVnNaRjl1WVcxbElEMGdKQ2gwYUdsektTNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzF1WVcxbFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5MllYSWdkRzlmWm1sbGJHUWdQU0FrYkdsemRGOTBieTVtYVc1a0tGd2lQaUIxYkNBK0lHeHBXMlJoZEdFdGMyWXRabWxsYkdRdGJtRnRaVDBuWENJclptbGxiR1JmYm1GdFpTdGNJaWRkWENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyVnNaaTVqYjNCNVFYUjBjbWxpZFhSbGN5Z2tLSFJvYVhNcExDQWtiR2x6ZEY5MGJ5d2dYQ0prWVhSaExYTm1MVndpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHeHBYMmwwSUQwZ01EdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwYjE5bWFXVnNaSE1nUFNBa2JHbHpkRjkwYnk1bWFXNWtLRndpUGlCMWJDQStJR3hwWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBa2RHOWZabWxsYkdSekxtVmhZMmdvWm5WdVkzUnBiMjRvYVNsN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtLSFJvYVhNcExtaDBiV3dvYkdsZlkyOXVkR1Z1ZEhOZllYSnlZWGxiYkdsZmFYUmRLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdaeWIyMWZabWxsYkdRZ1BTQWtLQ1JtY205dFgyWnBaV3hrY3k1blpYUW9iR2xmYVhRcEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSFJ2WDJacFpXeGtJRDBnSkNoMGFHbHpLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGIxOW1hV1ZzWkM1eVpXMXZkbVZCZEhSeUtGd2laR0YwWVMxelppMTBZWGh2Ym05dGVTMWhjbU5vYVhabFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWpiM0I1UVhSMGNtbGlkWFJsY3lna1puSnZiVjltYVdWc1pDd2dKSFJ2WDJacFpXeGtLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnNhVjlwZENzck8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzhxZG1GeUlDUm1jbTl0WDJacFpXeGtjeUE5SUNSc2FYTjBYMlp5YjIwdVptbHVaQ2hjSWlCMWJDQStJR3hwWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwYjE5bWFXVnNaSE1nUFNBa2JHbHpkRjkwYnk1bWFXNWtLRndpSUQ0Z2JHbGNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FrWm5KdmJWOW1hV1ZzWkhNdVpXRmphQ2htZFc1amRHbHZiaWhwYm1SbGVDd2dkbUZzS1h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDUW9kR2hwY3lrdWFHRnpRWFIwY21saWRYUmxLRndpWkdGMFlTMXpaaTEwWVhodmJtOXRlUzFoY21Ob2FYWmxYQ0lwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVZMjl3ZVVGMGRISnBZblYwWlhNb0pHeHBjM1JmWm5KdmJTd2dKR3hwYzNSZmRHOHBPeW92WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMblZ3WkdGMFpVWnZjbTFCZEhSeWFXSjFkR1Z6SUQwZ1puVnVZM1JwYjI0b0pHeHBjM1JmWm5KdmJTd2dKR3hwYzNSZmRHOHBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1puSnZiVjloZEhSeWFXSjFkR1Z6SUQwZ0pHeHBjM1JmWm5KdmJTNXdjbTl3S0Z3aVlYUjBjbWxpZFhSbGMxd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeThnYkc5dmNDQjBhSEp2ZFdkb0lEeHpaV3hsWTNRK0lHRjBkSEpwWW5WMFpYTWdZVzVrSUdGd2NHeDVJSFJvWlcwZ2IyNGdQR1JwZGo1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIwYjE5aGRIUnlhV0oxZEdWeklEMGdKR3hwYzNSZmRHOHVjSEp2Y0NoY0ltRjBkSEpwWW5WMFpYTmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ1F1WldGamFDaDBiMTloZEhSeWFXSjFkR1Z6TENCbWRXNWpkR2x2YmlncElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JzYVhOMFgzUnZMbkpsYlc5MlpVRjBkSElvZEdocGN5NXVZVzFsS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWtMbVZoWTJnb1puSnZiVjloZEhSeWFXSjFkR1Z6TENCbWRXNWpkR2x2YmlncElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JzYVhOMFgzUnZMbUYwZEhJb2RHaHBjeTV1WVcxbExDQjBhR2x6TG5aaGJIVmxLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1amIzQjVRWFIwY21saWRYUmxjeUE5SUdaMWJtTjBhVzl1S0NSbWNtOXRMQ0FrZEc4c0lIQnlaV1pwZUNsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaHdjbVZtYVhncFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjSEpsWm1sNElEMGdYQ0pjSWp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1p5YjIxZllYUjBjbWxpZFhSbGN5QTlJQ1JtY205dExuQnliM0FvWENKaGRIUnlhV0oxZEdWelhDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUnZYMkYwZEhKcFluVjBaWE1nUFNBa2RHOHVjSEp2Y0NoY0ltRjBkSEpwWW5WMFpYTmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ1F1WldGamFDaDBiMTloZEhSeWFXSjFkR1Z6TENCbWRXNWpkR2x2YmlncElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHdjbVZtYVhnaFBWd2lYQ0lwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2RHaHBjeTV1WVcxbExtbHVaR1Y0VDJZb2NISmxabWw0S1NBOVBTQXdLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGJ5NXlaVzF2ZG1WQmRIUnlLSFJvYVhNdWJtRnRaU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2SkhSdkxuSmxiVzkyWlVGMGRISW9kR2hwY3k1dVlXMWxLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWtMbVZoWTJnb1puSnZiVjloZEhSeWFXSjFkR1Z6TENCbWRXNWpkR2x2YmlncElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYnk1aGRIUnlLSFJvYVhNdWJtRnRaU3dnZEdocGN5NTJZV3gxWlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1amIzQjVSbTl5YlVGMGRISnBZblYwWlhNZ1BTQm1kVzVqZEdsdmJpZ2tabkp2YlN3Z0pIUnZLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkhSdkxuSmxiVzkyWlVGMGRISW9YQ0prWVhSaExXTjFjbkpsYm5RdGRHRjRiMjV2YlhrdFlYSmphR2wyWlZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVqYjNCNVFYUjBjbWxpZFhSbGN5Z2tabkp2YlN3Z0pIUnZLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5Wd1pHRjBaVVp2Y20wZ1BTQm1kVzVqZEdsdmJpaGtZWFJoTENCa1lYUmhYM1I1Y0dVcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJWc1ppQTlJSFJvYVhNN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhrWVhSaFgzUjVjR1U5UFZ3aWFuTnZibHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3THk5MGFHVnVJSGRsSUdScFpDQmhJSEpsY1hWbGMzUWdkRzhnZEdobElHRnFZWGdnWlc1a2NHOXBiblFzSUhOdklHVjRjR1ZqZENCaGJpQnZZbXBsWTNRZ1ltRmphMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaGtZWFJoV3lkbWIzSnRKMTBwSVQwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNKbGJXOTJaU0JoYkd3Z1pYWmxiblJ6SUdaeWIyMGdVeVpHSUdadmNtMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTV2Wm1Zb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl5WldaeVpYTm9JSFJvWlNCbWIzSnRJQ2hoZFhSdklHTnZkVzUwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVkyOXdlVXhwYzNSSmRHVnRjME52Ym5SbGJuUnpLQ1FvWkdGMFlWc25abTl5YlNkZEtTd2dKSFJvYVhNcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM0psSUdsdWFYUWdVeVpHSUdOc1lYTnpJRzl1SUhSb1pTQm1iM0p0WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeThrZEdocGN5NXpaV0Z5WTJoQmJtUkdhV3gwWlhJb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTlwWmlCaGFtRjRJR2x6SUdWdVlXSnNaV1FnYVc1cGRDQjBhR1VnY0dGbmFXNWhkR2x2Ymx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbWx1YVhRb2RISjFaU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YVhOZllXcGhlRDA5TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjMlYwZFhCQmFtRjRVR0ZuYVc1aGRHbHZiaWdwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNibHh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZV1JrVW1WemRXeDBjeUE5SUdaMWJtTjBhVzl1S0dSaGRHRXNJR1JoZEdGZmRIbHdaU2xjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQnpaV3htSUQwZ2RHaHBjenRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtHUmhkR0ZmZEhsd1pUMDlYQ0pxYzI5dVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIc3ZMM1JvWlc0Z2QyVWdaR2xrSUdFZ2NtVnhkV1Z6ZENCMGJ5QjBhR1VnWVdwaGVDQmxibVJ3YjJsdWRDd2djMjhnWlhod1pXTjBJR0Z1SUc5aWFtVmpkQ0JpWVdOclhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMmR5WVdJZ2RHaGxJSEpsYzNWc2RITWdZVzVrSUd4dllXUWdhVzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNWhjSEJsYm1Rb1pHRjBZVnNuY21WemRXeDBjeWRkS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1Ykc5aFpGOXRiM0psWDJoMGJXd2dQU0JrWVhSaFd5ZHlaWE4xYkhSekoxMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0JwWmloa1lYUmhYM1I1Y0dVOVBWd2lhSFJ0YkZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN0x5OTNaU0JoY21VZ1pYaHdaV04wYVc1bklIUm9aU0JvZEcxc0lHOW1JSFJvWlNCeVpYTjFiSFJ6SUhCaFoyVWdZbUZqYXl3Z2MyOGdaWGgwY21GamRDQjBhR1VnYUhSdGJDQjNaU0J1WldWa1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmtZWFJoWDI5aWFpQTlJQ1FvWkdGMFlTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXpaV3htTGlScGJtWnBibWwwWlY5elkzSnZiR3hmWTI5dWRHRnBibVZ5TG1Gd2NHVnVaQ2drWkdGMFlWOXZZbW91Wm1sdVpDaHpaV3htTG1GcVlYaGZkR0Z5WjJWMFgyRjBkSElwTG1oMGJXd29LU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc0lEMGdKR1JoZEdGZmIySnFMbVpwYm1Rb2MyVnNaaTVoYW1GNFgzUmhjbWRsZEY5aGRIUnlLUzVvZEcxc0tDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCcGJtWnBibWwwWlY5elkzSnZiR3hmWlc1a0lEMGdabUZzYzJVN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWdrS0Z3aVBHUnBkajVjSWl0elpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc0sxd2lQQzlrYVhZK1hDSXBMbVpwYm1Rb1hDSmJaR0YwWVMxelpXRnlZMmd0Wm1sc2RHVnlMV0ZqZEdsdmJqMG5hVzVtYVc1cGRHVXRjMk55YjJ4c0xXVnVaQ2RkWENJcExteGxibWQwYUQ0d0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBibVpwYm1sMFpWOXpZM0p2Ykd4ZlpXNWtJRDBnZEhKMVpUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTlwWmlCMGFHVnlaU0JwY3lCaGJtOTBhR1Z5SUhObGJHVmpkRzl5SUdadmNpQnBibVpwYm1sMFpTQnpZM0p2Ykd3c0lHWnBibVFnZEdobElHTnZiblJsYm5SeklHOW1JSFJvWVhRZ2FXNXpkR1ZoWkZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbWx1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSWhQVndpWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1Ykc5aFpGOXRiM0psWDJoMGJXd2dQU0FrS0Z3aVBHUnBkajVjSWl0elpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc0sxd2lQQzlrYVhZK1hDSXBMbVpwYm1Rb2MyVnNaaTVwYm1acGJtbDBaVjl6WTNKdmJHeGZZMjl1ZEdGcGJtVnlLUzVvZEcxc0tDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1cGJtWnBibWwwWlY5elkzSnZiR3hmY21WemRXeDBYMk5zWVhOeklUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSEpsYzNWc2RGOXBkR1Z0Y3lBOUlDUW9YQ0k4WkdsMlBsd2lLM05sYkdZdWJHOWhaRjl0YjNKbFgyaDBiV3dyWENJOEwyUnBkajVjSWlrdVptbHVaQ2h6Wld4bUxtbHVabWx1YVhSbFgzTmpjbTlzYkY5eVpYTjFiSFJmWTJ4aGMzTXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUnlaWE4xYkhSZmFYUmxiWE5mWTI5dWRHRnBibVZ5SUQwZ0pDZ25QR1JwZGk4K0p5d2dlMzBwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pISmxjM1ZzZEY5cGRHVnRjMTlqYjI1MFlXbHVaWEl1WVhCd1pXNWtLQ1J5WlhOMWJIUmZhWFJsYlhNcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXViRzloWkY5dGIzSmxYMmgwYld3Z1BTQWtjbVZ6ZFd4MFgybDBaVzF6WDJOdmJuUmhhVzVsY2k1b2RHMXNLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtHbHVabWx1YVhSbFgzTmpjbTlzYkY5bGJtUXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIc3ZMM2RsSUdadmRXNWtJR0VnWkdGMFlTQmhkSFJ5YVdKMWRHVWdjMmxuYm1Gc2JHbHVaeUIwYUdVZ2JHRnpkQ0J3WVdkbElITnZJR1pwYm1semFDQm9aWEpsWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGMxOXRZWGhmY0dGblpXUWdQU0IwY25WbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c1lYTjBYMnh2WVdSZmJXOXlaVjlvZEcxc0lEMGdjMlZzWmk1c2IyRmtYMjF2Y21WZmFIUnRiRHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdVptbHVhWFJsVTJOeWIyeHNRWEJ3Wlc1a0tITmxiR1l1Ykc5aFpGOXRiM0psWDJoMGJXd3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElHbG1LSE5sYkdZdWJHRnpkRjlzYjJGa1gyMXZjbVZmYUhSdGJDRTlQWE5sYkdZdWJHOWhaRjl0YjNKbFgyaDBiV3dwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dlkyaGxZMnNnZEc4Z2JXRnJaU0J6ZFhKbElIUm9aU0J1WlhjZ2FIUnRiQ0JtWlhSamFHVmtJR2x6SUdScFptWmxjbVZ1ZEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzWVhOMFgyeHZZV1JmYlc5eVpWOW9kRzFzSUQwZ2MyVnNaaTVzYjJGa1gyMXZjbVZmYUhSdGJEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFXNW1hVzVwZEdWVFkzSnZiR3hCY0hCbGJtUW9jMlZzWmk1c2IyRmtYMjF2Y21WZmFIUnRiQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2V5OHZkMlVnY21WalpXbDJaV1FnZEdobElITmhiV1VnYldWemMyRm5aU0JoWjJGcGJpQnpieUJrYjI0bmRDQmhaR1FzSUdGdVpDQjBaV3hzSUZNbVJpQjBhR0YwSUhkbEozSmxJR0YwSUhSb1pTQmxibVF1TGx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYzE5dFlYaGZjR0ZuWldRZ1BTQjBjblZsTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1cGJtWnBibWwwWlZOamNtOXNiRUZ3Y0dWdVpDQTlJR1oxYm1OMGFXOXVLQ1J2WW1wbFkzUXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbWx1Wm1sdWFYUmxYM05qY205c2JGOXlaWE4xYkhSZlkyeGhjM01oUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdUpHbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJdVptbHVaQ2h6Wld4bUxtbHVabWx1YVhSbFgzTmpjbTlzYkY5eVpYTjFiSFJmWTJ4aGMzTXBMbXhoYzNRb0tTNWhablJsY2lna2IySnFaV04wS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjaTVoY0hCbGJtUW9KRzlpYW1WamRDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMblZ3WkdGMFpWSmxjM1ZzZEhNZ1BTQm1kVzVqZEdsdmJpaGtZWFJoTENCa1lYUmhYM1I1Y0dVcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJWc1ppQTlJSFJvYVhNN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhrWVhSaFgzUjVjR1U5UFZ3aWFuTnZibHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3THk5MGFHVnVJSGRsSUdScFpDQmhJSEpsY1hWbGMzUWdkRzhnZEdobElHRnFZWGdnWlc1a2NHOXBiblFzSUhOdklHVjRjR1ZqZENCaGJpQnZZbXBsWTNRZ1ltRmphMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5bmNtRmlJSFJvWlNCeVpYTjFiSFJ6SUdGdVpDQnNiMkZrSUdsdVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbWgwYld3b1pHRjBZVnNuY21WemRXeDBjeWRkS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvWkdGMFlWc25abTl5YlNkZEtTRTlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaVzF2ZG1VZ1lXeHNJR1YyWlc1MGN5Qm1jbTl0SUZNbVJpQm1iM0p0WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdWIyWm1LQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmNtVnRiM1psSUhCaFoybHVZWFJwYjI1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxuSmxiVzkyWlVGcVlYaFFZV2RwYm1GMGFXOXVLQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmNtVm1jbVZ6YUNCMGFHVWdabTl5YlNBb1lYVjBieUJqYjNWdWRDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbU52Y0hsTWFYTjBTWFJsYlhORGIyNTBaVzUwY3lna0tHUmhkR0ZiSjJadmNtMG5YU2tzSUNSMGFHbHpLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5MWNHUmhkR1VnWVhSMGNtbGlkWFJsY3lCdmJpQm1iM0p0WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1amIzQjVSbTl5YlVGMGRISnBZblYwWlhNb0pDaGtZWFJoV3lkbWIzSnRKMTBwTENBa2RHaHBjeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmNtVWdhVzVwZENCVEprWWdZMnhoYzNNZ2IyNGdkR2hsSUdadmNtMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTV6WldGeVkyaEJibVJHYVd4MFpYSW9leWRwYzBsdWFYUW5PaUJtWVd4elpYMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2SkhSb2FYTXVabWx1WkNoY0ltbHVjSFYwWENJcExuSmxiVzkyWlVGMGRISW9YQ0prYVhOaFlteGxaRndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJR2xtS0dSaGRHRmZkSGx3WlQwOVhDSm9kRzFzWENJcElIc3ZMM2RsSUdGeVpTQmxlSEJsWTNScGJtY2dkR2hsSUdoMGJXd2diMllnZEdobElISmxjM1ZzZEhNZ2NHRm5aU0JpWVdOckxDQnpieUJsZUhSeVlXTjBJSFJvWlNCb2RHMXNJSGRsSUc1bFpXUmNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR1JoZEdGZmIySnFJRDBnSkNoa1lYUmhLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbWgwYld3b0pHUmhkR0ZmYjJKcUxtWnBibVFvYzJWc1ppNWhhbUY0WDNSaGNtZGxkRjloZEhSeUtTNW9kRzFzS0NrcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVkWEJrWVhSbFEyOXVkR1Z1ZEVGeVpXRnpLQ0FrWkdGMFlWOXZZbW9nS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNW1hVzVrS0Z3aUxuTmxZWEpqYUdGdVpHWnBiSFJsY2x3aUtTNXNaVzVuZEdnZ1BpQXdLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZXk4dmRHaGxiaUIwYUdWeVpTQmhjbVVnYzJWaGNtTm9JR1p2Y20wb2N5a2dhVzV6YVdSbElIUm9aU0J5WlhOMWJIUnpJR052Ym5SaGFXNWxjaXdnYzI4Z2NtVXRhVzVwZENCMGFHVnRYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJaTV6WldGeVkyaGhibVJtYVd4MFpYSmNJaWt1YzJWaGNtTm9RVzVrUm1sc2RHVnlLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5cFppQjBhR1VnWTNWeWNtVnVkQ0J6WldGeVkyZ2dabTl5YlNCcGN5QnViM1FnYVc1emFXUmxJSFJvWlNCeVpYTjFiSFJ6SUdOdmJuUmhhVzVsY2l3Z2RHaGxiaUJ3Y205alpXVmtJR0Z6SUc1dmNtMWhiQ0JoYm1RZ2RYQmtZWFJsSUhSb1pTQm1iM0p0WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSXVjMlZoY21Ob1lXNWtabWxzZEdWeVcyUmhkR0V0YzJZdFptOXliUzFwWkQwblhDSWdLeUJ6Wld4bUxuTm1hV1FnS3lCY0lpZGRYQ0lwTG14bGJtZDBhRDA5TUNrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkc1bGQxOXpaV0Z5WTJoZlptOXliU0E5SUNSa1lYUmhYMjlpYWk1bWFXNWtLRndpTG5ObFlYSmphR0Z1WkdacGJIUmxjbHRrWVhSaExYTm1MV1p2Y20wdGFXUTlKMXdpSUNzZ2MyVnNaaTV6Wm1sa0lDc2dYQ0luWFZ3aUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0NSdVpYZGZjMlZoY21Ob1gyWnZjbTB1YkdWdVozUm9JRDA5SURFcElIc3ZMM1JvWlc0Z2NtVndiR0ZqWlNCMGFHVWdjMlZoY21Ob0lHWnZjbTBnZDJsMGFDQjBhR1VnYm1WM0lHOXVaVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaVzF2ZG1VZ1lXeHNJR1YyWlc1MGN5Qm1jbTl0SUZNbVJpQm1iM0p0WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbTltWmlncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5eVpXMXZkbVVnY0dGbmFXNWhkR2x2Ymx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbkpsYlc5MlpVRnFZWGhRWVdkcGJtRjBhVzl1S0NrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNKbFpuSmxjMmdnZEdobElHWnZjbTBnS0dGMWRHOGdZMjkxYm5RcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WTI5d2VVeHBjM1JKZEdWdGMwTnZiblJsYm5SektDUnVaWGRmYzJWaGNtTm9YMlp2Y20wc0lDUjBhR2x6S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZFhCa1lYUmxJR0YwZEhKcFluVjBaWE1nYjI0Z1ptOXliVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtTnZjSGxHYjNKdFFYUjBjbWxpZFhSbGN5Z2tibVYzWDNObFlYSmphRjltYjNKdExDQWtkR2hwY3lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNKbElHbHVhWFFnVXlaR0lHTnNZWE56SUc5dUlIUm9aU0JtYjNKdFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG5ObFlYSmphRUZ1WkVacGJIUmxjaWg3SjJselNXNXBkQ2M2SUdaaGJITmxmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dkpIUm9hWE11Wm1sdVpDaGNJbWx1Y0hWMFhDSXBMbkpsYlc5MlpVRjBkSElvWENKa2FYTmhZbXhsWkZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFYTmZiV0Y0WDNCaFoyVmtJRDBnWm1Gc2MyVTdJQzh2Wm05eUlHbHVabWx1YVhSbElITmpjbTlzYkZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtTjFjbkpsYm5SZmNHRm5aV1FnUFNBeE95QXZMMlp2Y2lCcGJtWnBibWwwWlNCelkzSnZiR3hjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1elpYUkpibVpwYm1sMFpWTmpjbTlzYkVOdmJuUmhhVzVsY2lncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVkWEJrWVhSbFEyOXVkR1Z1ZEVGeVpXRnpJRDBnWm5WdVkzUnBiMjRvSUNSb2RHMXNYMlJoZEdFZ0tTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkx5QmhaR1FnWVdSa2FYUnBiMjVoYkNCamIyNTBaVzUwSUdGeVpXRnpYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2dnZEdocGN5NWhhbUY0WDNWd1pHRjBaVjl6WldOMGFXOXVjeUFtSmlCMGFHbHpMbUZxWVhoZmRYQmtZWFJsWDNObFkzUnBiMjV6TG14bGJtZDBhQ0FwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnZjaUFvYVc1a1pYZ2dQU0F3T3lCcGJtUmxlQ0E4SUhSb2FYTXVZV3BoZUY5MWNHUmhkR1ZmYzJWamRHbHZibk11YkdWdVozUm9PeUFySzJsdVpHVjRLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhObGJHVmpkRzl5SUQwZ2RHaHBjeTVoYW1GNFgzVndaR0YwWlY5elpXTjBhVzl1YzF0cGJtUmxlRjA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQ2dnYzJWc1pXTjBiM0lnS1M1b2RHMXNLQ0FrYUhSdGJGOWtZWFJoTG1acGJtUW9JSE5sYkdWamRHOXlJQ2t1YUhSdGJDZ3BJQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NW1ZV1JsUTI5dWRHVnVkRUZ5WldGeklEMGdablZ1WTNScGIyNG9JR1JwY21WamRHbHZiaUFwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdmNHRmphWFI1SUQwZ01DNDFPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaUFvSUdScGNtVmpkR2x2YmlBOVBUMGdYQ0pwYmx3aUlDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYjNCaFkybDBlU0E5SURFN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2dnZEdocGN5NWhhbUY0WDNWd1pHRjBaVjl6WldOMGFXOXVjeUFtSmlCMGFHbHpMbUZxWVhoZmRYQmtZWFJsWDNObFkzUnBiMjV6TG14bGJtZDBhQ0FwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnZjaUFvYVc1a1pYZ2dQU0F3T3lCcGJtUmxlQ0E4SUhSb2FYTXVZV3BoZUY5MWNHUmhkR1ZmYzJWamRHbHZibk11YkdWdVozUm9PeUFySzJsdVpHVjRLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhObGJHVmpkRzl5SUQwZ2RHaHBjeTVoYW1GNFgzVndaR0YwWlY5elpXTjBhVzl1YzF0cGJtUmxlRjA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQ2dnYzJWc1pXTjBiM0lnS1M1emRHOXdLSFJ5ZFdVc2RISjFaU2t1WVc1cGJXRjBaU2dnZXlCdmNHRmphWFI1T2lCdmNHRmphWFI1ZlN3Z1hDSm1ZWE4wWENJZ0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCY2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11Y21WdGIzWmxWMjl2UTI5dGJXVnlZMlZEYjI1MGNtOXNjeUE5SUdaMWJtTjBhVzl1S0NsN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtkMjl2WDI5eVpHVnlZbmtnUFNBa0tDY3VkMjl2WTI5dGJXVnlZMlV0YjNKa1pYSnBibWNnTG05eVpHVnlZbmtuS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUjNiMjlmYjNKa1pYSmllVjltYjNKdElEMGdKQ2duTG5kdmIyTnZiVzFsY21ObExXOXlaR1Z5YVc1bkp5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FrZDI5dlgyOXlaR1Z5WW5sZlptOXliUzV2Wm1Zb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0pIZHZiMTl2Y21SbGNtSjVMbTltWmlncE8xeHlYRzRnSUNBZ0lDQWdJSDA3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVlXUmtVWFZsY25sUVlYSmhiU0E5SUdaMWJtTjBhVzl1S0c1aGJXVXNJSFpoYkhWbExDQjFjbXhmZEhsd1pTbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvZFhKc1gzUjVjR1VwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RYSnNYM1I1Y0dVZ1BTQmNJbUZzYkZ3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVaWGgwY21GZmNYVmxjbmxmY0dGeVlXMXpXM1Z5YkY5MGVYQmxYVnR1WVcxbFhTQTlJSFpoYkhWbE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbWx1YVhSWGIyOURiMjF0WlhKalpVTnZiblJ5YjJ4eklEMGdablZ1WTNScGIyNG9LWHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjbVZ0YjNabFYyOXZRMjl0YldWeVkyVkRiMjUwY205c2N5Z3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUjNiMjlmYjNKa1pYSmllU0E5SUNRb0p5NTNiMjlqYjIxdFpYSmpaUzF2Y21SbGNtbHVaeUF1YjNKa1pYSmllU2NwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pIZHZiMTl2Y21SbGNtSjVYMlp2Y20wZ1BTQWtLQ2N1ZDI5dlkyOXRiV1Z5WTJVdGIzSmtaWEpwYm1jbktUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdmNtUmxjbDkyWVd3Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlna2QyOXZYMjl5WkdWeVlua3ViR1Z1WjNSb1BqQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzl5WkdWeVgzWmhiQ0E5SUNSM2IyOWZiM0prWlhKaWVTNTJZV3dvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHOXlaR1Z5WDNaaGJDQTlJSE5sYkdZdVoyVjBVWFZsY25sUVlYSmhiVVp5YjIxVlVrd29YQ0p2Y21SbGNtSjVYQ0lzSUhkcGJtUnZkeTVzYjJOaGRHbHZiaTVvY21WbUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvYjNKa1pYSmZkbUZzUFQxY0ltMWxiblZmYjNKa1pYSmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYjNKa1pYSmZkbUZzSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tHOXlaR1Z5WDNaaGJDRTlYQ0pjSWlrbUppZ2hJVzl5WkdWeVgzWmhiQ2twWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVaWGgwY21GZmNYVmxjbmxmY0dGeVlXMXpMbUZzYkM1dmNtUmxjbUo1SUQwZ2IzSmtaWEpmZG1Gc08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkhkdmIxOXZjbVJsY21KNVgyWnZjbTB1YjI0b0ozTjFZbTFwZENjc0lHWjFibU4wYVc5dUtHVXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1V1Y0hKbGRtVnVkRVJsWm1GMWJIUW9LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRtRnlJR1p2Y20wZ1BTQmxMblJoY21kbGREdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWtkMjl2WDI5eVpHVnlZbmt1YjI0b1hDSmphR0Z1WjJWY0lpd2dablZ1WTNScGIyNG9aU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWlM1d2NtVjJaVzUwUkdWbVlYVnNkQ2dwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMllXd2dQU0FrS0hSb2FYTXBMblpoYkNncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvZG1Gc1BUMWNJbTFsYm5WZmIzSmtaWEpjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllXd2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WlhoMGNtRmZjWFZsY25sZmNHRnlZVzF6TG1Gc2JDNXZjbVJsY21KNUlEMGdkbUZzTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdsekxuUnlhV2RuWlhJb1hDSnpkV0p0YVhSY0lpbGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YzJOeWIyeHNVbVZ6ZFd4MGN5QTlJR1oxYm1OMGFXOXVLQ2xjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQnpaV3htSUQwZ2RHaHBjenRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvS0hObGJHWXVjMk55YjJ4c1gyOXVYMkZqZEdsdmJqMDljMlZzWmk1aGFtRjRYMkZqZEdsdmJpbDhmQ2h6Wld4bUxuTmpjbTlzYkY5dmJsOWhZM1JwYjI0OVBWd2lZV3hzWENJcEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5OamNtOXNiRlJ2VUc5ektDazdJQzh2YzJOeWIyeHNJSFJvWlNCM2FXNWtiM2NnYVdZZ2FYUWdhR0Z6SUdKbFpXNGdjMlYwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzTmxiR1l1WVdwaGVGOWhZM1JwYjI0Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMblZ3WkdGMFpWVnliRWhwYzNSdmNua2dQU0JtZFc1amRHbHZiaWhoYW1GNFgzSmxjM1ZzZEhOZmRYSnNLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnpaVjlvYVhOMGIzSjVYMkZ3YVNBOUlEQTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2gzYVc1a2IzY3VhR2x6ZEc5eWVTQW1KaUIzYVc1a2IzY3VhR2x6ZEc5eWVTNXdkWE5vVTNSaGRHVXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFZ6WlY5b2FYTjBiM0o1WDJGd2FTQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMWFZ6WlMxb2FYTjBiM0o1TFdGd2FWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tITmxiR1l1ZFhCa1lYUmxYMkZxWVhoZmRYSnNQVDB4S1NZbUtIVnpaVjlvYVhOMGIzSjVYMkZ3YVQwOU1Ta3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Ym05M0lHTm9aV05ySUdsbUlIUm9aU0JpY205M2MyVnlJSE4xY0hCdmNuUnpJR2hwYzNSdmNua2djM1JoZEdVZ2NIVnphQ0E2S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLSGRwYm1SdmR5NW9hWE4wYjNKNUlDWW1JSGRwYm1SdmR5NW9hWE4wYjNKNUxuQjFjMmhUZEdGMFpTbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm9hWE4wYjNKNUxuQjFjMmhUZEdGMFpTaHVkV3hzTENCdWRXeHNMQ0JoYW1GNFgzSmxjM1ZzZEhOZmRYSnNLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuSmxiVzkyWlVGcVlYaFFZV2RwYm1GMGFXOXVJRDBnWm5WdVkzUnBiMjRvS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE5sYkdZZ1BTQjBhR2x6TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtITmxiR1l1WVdwaGVGOXNhVzVyYzE5elpXeGxZM1J2Y2lraFBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtZV3BoZUY5c2FXNXJjMTl2WW1wbFkzUWdQU0JxVVhWbGNua29jMlZzWmk1aGFtRjRYMnhwYm10elgzTmxiR1ZqZEc5eUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tZV3BoZUY5c2FXNXJjMTl2WW1wbFkzUXViR1Z1WjNSb1BqQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR0ZxWVhoZmJHbHVhM05mYjJKcVpXTjBMbTltWmlncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtZGxkRUpoYzJWVmNtd2dQU0JtZFc1amRHbHZiaWdnZFhKc0lDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMjV2ZHlCelpXVWdhV1lnZDJVZ1lYSmxJRzl1SUhSb1pTQlZVa3dnZDJVZ2RHaHBibXN1TGk1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliRjl3WVhKMGN5QTlJSFZ5YkM1emNHeHBkQ2hjSWo5Y0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIxY214ZlltRnpaU0E5SUZ3aVhDSTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMWNteGZjR0Z5ZEhNdWJHVnVaM1JvUGpBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIVnliRjlpWVhObElEMGdkWEpzWDNCaGNuUnpXekJkTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkWEpzWDJKaGMyVWdQU0IxY213N1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVJSFZ5YkY5aVlYTmxPMXh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1OaGJrWmxkR05vUVdwaGVGSmxjM1ZzZEhNZ1BTQm1kVzVqZEdsdmJpaG1aWFJqYUY5MGVYQmxLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0dabGRHTm9YM1I1Y0dVcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdabVYwWTJoZmRIbHdaU0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1psZEdOb1gyRnFZWGhmY21WemRXeDBjeUE5SUdaaGJITmxPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTVwYzE5aGFtRjRQVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3THk5MGFHVnVJSGRsSUhkcGJHd2dZV3BoZUNCemRXSnRhWFFnZEdobElHWnZjbTFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMkZ1WkNCcFppQjNaU0JqWVc0Z1ptbHVaQ0IwYUdVZ2NtVnpkV3gwY3lCamIyNTBZV2x1WlhKY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1YkdWdVozUm9QVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdabGRHTm9YMkZxWVhoZmNtVnpkV3gwY3lBOUlIUnlkV1U3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlISmxjM1ZzZEhOZmRYSnNJRDBnYzJWc1ppNXlaWE4xYkhSelgzVnliRHNnSUM4dlhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnY21WemRXeDBjMTkxY214ZlpXNWpiMlJsWkNBOUlDY25PeUFnTHk5Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJqZFhKeVpXNTBYM1Z5YkNBOUlIZHBibVJ2ZHk1c2IyTmhkR2x2Ymk1b2NtVm1PMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZhV2R1YjNKbElDTWdZVzVrSUdWMlpYSjVkR2hwYm1jZ1lXWjBaWEpjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQm9ZWE5vWDNCdmN5QTlJSGRwYm1SdmR5NXNiMk5oZEdsdmJpNW9jbVZtTG1sdVpHVjRUMllvSnlNbktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0doaGMyaGZjRzl6SVQwOUxURXBlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHTjFjbkpsYm5SZmRYSnNJRDBnZDJsdVpHOTNMbXh2WTJGMGFXOXVMbWh5WldZdWMzVmljM1J5S0RBc0lIZHBibVJ2ZHk1c2IyTmhkR2x2Ymk1b2NtVm1MbWx1WkdWNFQyWW9KeU1uS1NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9JQ2dnS0NCelpXeG1MbVJwYzNCc1lYbGZjbVZ6ZFd4MFgyMWxkR2h2WkQwOVhDSmpkWE4wYjIxZmQyOXZZMjl0YldWeVkyVmZjM1J2Y21WY0lpQXBJSHg4SUNnZ2MyVnNaaTVrYVhOd2JHRjVYM0psYzNWc2RGOXRaWFJvYjJROVBWd2ljRzl6ZEY5MGVYQmxYMkZ5WTJocGRtVmNJaUFwSUNrZ0ppWWdLQ0J6Wld4bUxtVnVZV0pzWlY5MFlYaHZibTl0ZVY5aGNtTm9hWFpsY3lBOVBTQXhJQ2tnS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDQnpaV3htTG1OMWNuSmxiblJmZEdGNGIyNXZiWGxmWVhKamFHbDJaU0FoUFQxY0lsd2lJQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1psZEdOb1gyRnFZWGhmY21WemRXeDBjeUE5SUhSeWRXVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZLblpoY2lCeVpYTjFiSFJ6WDNWeWJDQTlJSEJ5YjJObGMzTmZabTl5YlM1blpYUlNaWE4xYkhSelZYSnNLSE5sYkdZc0lITmxiR1l1Y21WemRXeDBjMTkxY213cE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdZV04wYVhabFgzUmhlQ0E5SUhCeWIyTmxjM05mWm05eWJTNW5aWFJCWTNScGRtVlVZWGdvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIRjFaWEo1WDNCaGNtRnRjeUE5SUhObGJHWXVaMlYwVlhKc1VHRnlZVzF6S0hSeWRXVXNJQ2NuTENCaFkzUnBkbVZmZEdGNEtUc3FMMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmJtOTNJSE5sWlNCcFppQjNaU0JoY21VZ2IyNGdkR2hsSUZWU1RDQjNaU0IwYUdsdWF5NHVMbHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliRjlpWVhObElEMGdkR2hwY3k1blpYUkNZWE5sVlhKc0tDQmpkWEp5Wlc1MFgzVnliQ0FwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OTJZWElnY21WemRXeDBjMTkxY214ZlltRnpaU0E5SUhSb2FYTXVaMlYwUW1GelpWVnliQ2dnWTNWeWNtVnVkRjkxY213Z0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiR0Z1WnlBOUlITmxiR1l1WjJWMFVYVmxjbmxRWVhKaGJVWnliMjFWVWt3b1hDSnNZVzVuWENJc0lIZHBibVJ2ZHk1c2IyTmhkR2x2Ymk1b2NtVm1LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDaDBlWEJsYjJZb2JHRnVaeWtoUFQxY0luVnVaR1ZtYVc1bFpGd2lLU1ltS0d4aGJtY2hQVDF1ZFd4c0tTbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjFjbXhmWW1GelpTQTlJSE5sYkdZdVlXUmtWWEpzVUdGeVlXMG9kWEpzWDJKaGMyVXNJRndpYkdGdVp6MWNJaXRzWVc1bktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJacFpDQTlJSE5sYkdZdVoyVjBVWFZsY25sUVlYSmhiVVp5YjIxVlVrd29YQ0p6Wm1sa1hDSXNJSGRwYm1SdmR5NXNiMk5oZEdsdmJpNW9jbVZtS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUlITm1hV1FnYVhNZ1lTQnVkVzFpWlhKY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LRTUxYldKbGNpaHdZWEp6WlVac2IyRjBLSE5tYVdRcEtTQTlQU0J6Wm1sa0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIVnliRjlpWVhObElEMGdjMlZzWmk1aFpHUlZjbXhRWVhKaGJTaDFjbXhmWW1GelpTd2dYQ0p6Wm1sa1BWd2lLM05tYVdRcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZhV1lnWVc1NUlHOW1JSFJvWlNBeklHTnZibVJwZEdsdmJuTWdZWEpsSUhSeWRXVXNJSFJvWlc0Z2FYUnpJR2R2YjJRZ2RHOGdaMjljY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dklDMGdNU0I4SUdsbUlIUm9aU0IxY213Z1ltRnpaU0E5UFNCeVpYTjFiSFJ6WDNWeWJGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeThnTFNBeUlId2dhV1lnZFhKc0lHSmhjMlVySUZ3aUwxd2lJQ0E5UFNCeVpYTjFiSFJ6WDNWeWJDQXRJR2x1SUdOaGMyVWdiMllnZFhObGNpQmxjbkp2Y2lCcGJpQjBhR1VnY21WemRXeDBjeUJWVWt4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZJQzBnTXlCOElHbG1JSFJvWlNCeVpYTjFiSFJ6SUZWU1RDQm9ZWE1nZFhKc0lIQmhjbUZ0Y3l3Z1lXNWtJSFJvWlNCamRYSnlaVzUwSUhWeWJDQnpkR0Z5ZEhNZ2QybDBhQ0IwYUdVZ2NtVnpkV3gwY3lCVlVrd2dYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OTBjbWx0SUdGdWVTQjBjbUZwYkdsdVp5QnpiR0Z6YUNCbWIzSWdaV0Z6YVdWeUlHTnZiWEJoY21semIyNDZYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IxY214ZlltRnpaU0E5SUhWeWJGOWlZWE5sTG5KbGNHeGhZMlVvTDF4Y0x5UXZMQ0FuSnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWE4xYkhSelgzVnliQ0E5SUhKbGMzVnNkSE5mZFhKc0xuSmxjR3hoWTJVb0wxeGNMeVF2TENBbkp5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhOMWJIUnpYM1Z5YkY5bGJtTnZaR1ZrSUQwZ1pXNWpiMlJsVlZKSktISmxjM1ZzZEhOZmRYSnNLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCamRYSnlaVzUwWDNWeWJGOWpiMjUwWVdsdWMxOXlaWE4xYkhSelgzVnliQ0E5SUMweE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvS0hWeWJGOWlZWE5sUFQxeVpYTjFiSFJ6WDNWeWJDbDhmQ2gxY214ZlltRnpaUzUwYjB4dmQyVnlRMkZ6WlNncFBUMXlaWE4xYkhSelgzVnliRjlsYm1OdlpHVmtMblJ2VEc5M1pYSkRZWE5sS0NrcElDQXBlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHTjFjbkpsYm5SZmRYSnNYMk52Ym5SaGFXNXpYM0psYzNWc2RITmZkWEpzSUQwZ01UdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDBnWld4elpTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLQ0J5WlhOMWJIUnpYM1Z5YkM1cGJtUmxlRTltS0NBblB5Y2dLU0FoUFQwZ0xURWdKaVlnWTNWeWNtVnVkRjkxY213dWJHRnpkRWx1WkdWNFQyWW9jbVZ6ZFd4MGMxOTFjbXdzSURBcElEMDlQU0F3SUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmpkWEp5Wlc1MFgzVnliRjlqYjI1MFlXbHVjMTl5WlhOMWJIUnpYM1Z5YkNBOUlERTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWIyNXNlVjl5WlhOMWJIUnpYMkZxWVhnOVBURXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3THk5cFppQmhJSFZ6WlhJZ2FHRnpJR05vYjNObGJpQjBieUJ2Ym14NUlHRnNiRzkzSUdGcVlYZ2diMjRnY21WemRXeDBjeUJ3WVdkbGN5QW9aR1ZtWVhWc2RDQmlaV2hoZG1sdmRYSXBYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0NCamRYSnlaVzUwWDNWeWJGOWpiMjUwWVdsdWMxOXlaWE4xYkhSelgzVnliQ0ErSUMweEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhzdkwzUm9hWE1nYldWaGJuTWdkR2hsSUdOMWNuSmxiblFnVlZKTUlHTnZiblJoYVc1eklIUm9aU0J5WlhOMWJIUnpJSFZ5YkN3Z2QyaHBZMmdnYldWaGJuTWdkMlVnWTJGdUlHUnZJR0ZxWVhoY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1ptVjBZMmhmWVdwaGVGOXlaWE4xYkhSeklEMGdkSEoxWlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWm1WMFkyaGZZV3BoZUY5eVpYTjFiSFJ6SUQwZ1ptRnNjMlU3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dabGRHTm9YM1I1Y0dVOVBWd2ljR0ZuYVc1aGRHbHZibHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0lHTjFjbkpsYm5SZmRYSnNYMk52Ym5SaGFXNXpYM0psYzNWc2RITmZkWEpzSUQ0Z0xURXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHN2TDNSb2FYTWdiV1ZoYm5NZ2RHaGxJR04xY25KbGJuUWdWVkpNSUdOdmJuUmhhVzV6SUhSb1pTQnlaWE4xYkhSeklIVnliQ3dnZDJocFkyZ2diV1ZoYm5NZ2QyVWdZMkZ1SUdSdklHRnFZWGhjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJSdmJpZDBJR0ZxWVhnZ2NHRm5hVzVoZEdsdmJpQjNhR1Z1SUc1dmRDQnZiaUJoSUZNbVJpQndZV2RsWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITWdQU0JtWVd4elpUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUdabGRHTm9YMkZxWVhoZmNtVnpkV3gwY3p0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YzJWMGRYQkJhbUY0VUdGbmFXNWhkR2x2YmlBOUlHWjFibU4wYVc5dUtDbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2YVc1bWFXNXBkR1VnYzJOeWIyeHNYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFJvYVhNdWNHRm5hVzVoZEdsdmJsOTBlWEJsUFQwOVhDSnBibVpwYm1sMFpWOXpZM0p2Ykd4Y0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdsdVptbHVhWFJsWDNOamNtOXNiRjlsYm1RZ1BTQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJbHRrWVhSaExYTmxZWEpqYUMxbWFXeDBaWEl0WVdOMGFXOXVQU2RwYm1acGJtbDBaUzF6WTNKdmJHd3RaVzVrSjExY0lpa3ViR1Z1WjNSb1BqQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhVzVtYVc1cGRHVmZjMk55YjJ4c1gyVnVaQ0E5SUhSeWRXVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYzE5dFlYaGZjR0ZuWldRZ1BTQjBjblZsTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIQmhjbk5sU1c1MEtIUm9hWE11YVc1emRHRnVZMlZmYm5WdFltVnlLVDA5UFRFcElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa0tIZHBibVJ2ZHlrdWIyWm1LRndpYzJOeWIyeHNYQ0lzSUhObGJHWXViMjVYYVc1a2IzZFRZM0p2Ykd3cE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvYzJWc1ppNWpZVzVHWlhSamFFRnFZWGhTWlhOMWJIUnpLRndpY0dGbmFXNWhkR2x2Ymx3aUtTa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrS0hkcGJtUnZkeWt1YjI0b1hDSnpZM0p2Ykd4Y0lpd2djMlZzWmk1dmJsZHBibVJ2ZDFOamNtOXNiQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9kSGx3Wlc5bUtITmxiR1l1WVdwaGVGOXNhVzVyYzE5elpXeGxZM1J2Y2lrOVBWd2lkVzVrWldacGJtVmtYQ0lwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5Ymp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1FvWkc5amRXMWxiblFwTG05bVppZ25ZMnhwWTJzbkxDQnpaV3htTG1GcVlYaGZiR2x1YTNOZmMyVnNaV04wYjNJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQ2hrYjJOMWJXVnVkQ2t1YjJabUtITmxiR1l1WVdwaGVGOXNhVzVyYzE5elpXeGxZM1J2Y2lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtLSE5sYkdZdVlXcGhlRjlzYVc1cmMxOXpaV3hsWTNSdmNpa3ViMlptS0NrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkNoa2IyTjFiV1Z1ZENrdWIyNG9KMk5zYVdOckp5d2djMlZzWmk1aGFtRjRYMnhwYm10elgzTmxiR1ZqZEc5eUxDQm1kVzVqZEdsdmJpaGxLWHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTVqWVc1R1pYUmphRUZxWVhoU1pYTjFiSFJ6S0Z3aWNHRm5hVzVoZEdsdmJsd2lLU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1V1Y0hKbGRtVnVkRVJsWm1GMWJIUW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJzYVc1cklEMGdhbEYxWlhKNUtIUm9hWE1wTG1GMGRISW9KMmh5WldZbktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aGFtRjRYMkZqZEdsdmJpQTlJRndpY0dGbmFXNWhkR2x2Ymx3aU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIQmhaMlZPZFcxaVpYSWdQU0J6Wld4bUxtZGxkRkJoWjJWa1JuSnZiVlZTVENoc2FXNXJLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1SkdGcVlYaGZjbVZ6ZFd4MGMxOWpiMjUwWVdsdVpYSXVZWFIwY2loY0ltUmhkR0V0Y0dGblpXUmNJaXdnY0dGblpVNTFiV0psY2lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtWmxkR05vUVdwaGVGSmxjM1ZzZEhNb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhKbGRIVnliaUJtWVd4elpUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVaMlYwVUdGblpXUkdjbTl0VlZKTUlEMGdablZ1WTNScGIyNG9WVkpNS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ3WVdkbFpGWmhiQ0E5SURFN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dlptbHljM1FnZEdWemRDQjBieUJ6WldVZ2FXWWdkMlVnYUdGMlpTQmNJaTl3WVdkbEx6UXZYQ0lnYVc0Z2RHaGxJRlZTVEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RIQldZV3dnUFNCelpXeG1MbWRsZEZGMVpYSjVVR0Z5WVcxR2NtOXRWVkpNS0Z3aWMyWmZjR0ZuWldSY0lpd2dWVkpNS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tIUjVjR1Z2WmloMGNGWmhiQ2s5UFZ3aWMzUnlhVzVuWENJcGZId29kSGx3Wlc5bUtIUndWbUZzS1QwOVhDSnVkVzFpWlhKY0lpa3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEJoWjJWa1ZtRnNJRDBnZEhCV1lXdzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQndZV2RsWkZaaGJEdGNjbHh1SUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtZGxkRkYxWlhKNVVHRnlZVzFHY205dFZWSk1JRDBnWm5WdVkzUnBiMjRvYm1GdFpTd2dWVkpNS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ4YzNSeWFXNW5JRDBnWENJL1hDSXJWVkpNTG5Od2JHbDBLQ2MvSnlsYk1WMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaHhjM1J5YVc1bktTRTlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFpoYkNBOUlHUmxZMjlrWlZWU1NVTnZiWEJ2Ym1WdWRDZ29ibVYzSUZKbFowVjRjQ2duV3o5OEpsMG5JQ3NnYm1GdFpTQXJJQ2M5SnlBcklDY29XMTRtTzEwclB5a29KbndqZkR0OEpDa25LUzVsZUdWaktIRnpkSEpwYm1jcGZIeGJMRndpWENKZEtWc3hYUzV5WlhCc1lXTmxLQzljWENzdlp5d2dKeVV5TUNjcEtYeDhiblZzYkR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCMllXdzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtWnZjbTFWY0dSaGRHVmtJRDBnWm5WdVkzUnBiMjRvWlNsN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMlV1Y0hKbGRtVnVkRVJsWm1GMWJIUW9LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNWhkWFJ2WDNWd1pHRjBaVDA5TVNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1emRXSnRhWFJHYjNKdEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0JwWmlnb2MyVnNaaTVoZFhSdlgzVndaR0YwWlQwOU1Da21KaWh6Wld4bUxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsUFQweEtTbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1bWIzSnRWWEJrWVhSbFpFWmxkR05vUVdwaGVDZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdabUZzYzJVN1hISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1bWIzSnRWWEJrWVhSbFpFWmxkR05vUVdwaGVDQTlJR1oxYm1OMGFXOXVLQ2w3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyeHZiM0FnZEdoeWIzVm5hQ0JoYkd3Z2RHaGxJR1pwWld4a2N5QmhibVFnWW5WcGJHUWdkR2hsSUZWU1RGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbVpsZEdOb1FXcGhlRVp2Y20wb0tUdGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnTHk5dFlXdGxJR0Z1ZVNCamIzSnlaV04wYVc5dWN5OTFjR1JoZEdWeklIUnZJR1pwWld4a2N5QmlaV1p2Y21VZ2RHaGxJSE4xWW0xcGRDQmpiMjF3YkdWMFpYTmNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuTmxkRVpwWld4a2N5QTlJR1oxYm1OMGFXOXVLR1VwZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OXBaaWh6Wld4bUxtbHpYMkZxWVhnOVBUQXBJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM052YldWMGFXMWxjeUIwYUdVZ1ptOXliU0JwY3lCemRXSnRhWFIwWldRZ2QybDBhRzkxZENCMGFHVWdjMnhwWkdWeUlIbGxkQ0JvWVhacGJtY2dkWEJrWVhSbFpDd2dZVzVrSUdGeklIZGxJR2RsZENCdmRYSWdkbUZzZFdWeklHWnliMjFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRHaGxJSE5zYVdSbGNpQmhibVFnYm05MElHbHVjSFYwY3l3Z2QyVWdibVZsWkNCMGJ5QmphR1ZqYXlCcGRDQnBaaUJ1WldWa2N5QjBieUJpWlNCelpYUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2YjI1c2VTQnZZMk4xY25NZ2FXWWdZV3BoZUNCcGN5QnZabVlzSUdGdVpDQmhkWFJ2YzNWaWJXbDBJRzl1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MaVJtYVdWc1pITXVaV0ZqYUNobWRXNWpkR2x2YmlncElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSbWFXVnNaQ0E5SUNRb2RHaHBjeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnlZVzVuWlY5a2FYTndiR0Y1WDNaaGJIVmxjeUE5SUNSbWFXVnNaQzVtYVc1a0tDY3VjMll0YldWMFlTMXlZVzVuWlMxemJHbGtaWEluS1M1aGRIUnlLRndpWkdGMFlTMWthWE53YkdGNUxYWmhiSFZsY3kxaGMxd2lLVHN2TDJSaGRHRXRaR2x6Y0d4aGVTMTJZV3gxWlhNdFlYTTlYQ0owWlhoMFhDSmNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvY21GdVoyVmZaR2x6Y0d4aGVWOTJZV3gxWlhNOVBUMWNJblJsZUhScGJuQjFkRndpS1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlna1ptbGxiR1F1Wm1sdVpDaGNJaTV0WlhSaExYTnNhV1JsY2x3aUtTNXNaVzVuZEdnK01DbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUm1hV1ZzWkM1bWFXNWtLRndpTG0xbGRHRXRjMnhwWkdWeVhDSXBMbVZoWTJnb1puVnVZM1JwYjI0Z0tHbHVaR1Y0S1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE5zYVdSbGNsOXZZbXBsWTNRZ1BTQWtLSFJvYVhNcFd6QmRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1J6Ykdsa1pYSmZaV3dnUFNBa0tIUm9hWE1wTG1Oc2IzTmxjM1FvWENJdWMyWXRiV1YwWVMxeVlXNW5aUzF6Ykdsa1pYSmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1poY2lCdGFXNVdZV3dnUFNBa2MyeHBaR1Z5WDJWc0xtRjBkSElvWENKa1lYUmhMVzFwYmx3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRtRnlJRzFoZUZaaGJDQTlJQ1J6Ykdsa1pYSmZaV3d1WVhSMGNpaGNJbVJoZEdFdGJXRjRYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUcxcGJsWmhiQ0E5SUNSemJHbGtaWEpmWld3dVptbHVaQ2hjSWk1elppMXlZVzVuWlMxdGFXNWNJaWt1ZG1Gc0tDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiV0Y0Vm1Gc0lEMGdKSE5zYVdSbGNsOWxiQzVtYVc1a0tGd2lMbk5tTFhKaGJtZGxMVzFoZUZ3aUtTNTJZV3dvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5zYVdSbGNsOXZZbXBsWTNRdWJtOVZhVk5zYVdSbGNpNXpaWFFvVzIxcGJsWmhiQ3dnYldGNFZtRnNYU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5OVhISmNibHh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnTHk5emRXSnRhWFJjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbk4xWW0xcGRFWnZjbTBnUFNCbWRXNWpkR2x2YmlobEtYdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2Ykc5dmNDQjBhSEp2ZFdkb0lHRnNiQ0IwYUdVZ1ptbGxiR1J6SUdGdVpDQmlkV2xzWkNCMGFHVWdWVkpNWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVhWE5UZFdKdGFYUjBhVzVuSUQwOUlIUnlkV1VwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCbVlXeHpaVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXpaWFJHYVdWc1pITW9LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1amJHVmhjbFJwYldWeUtDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHpVM1ZpYldsMGRHbHVaeUE5SUhSeWRXVTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J3Y205alpYTnpYMlp2Y20wdWMyVjBWR0Y0UVhKamFHbDJaVkpsYzNWc2RITlZjbXdvYzJWc1ppd2djMlZzWmk1eVpYTjFiSFJ6WDNWeWJDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxpUmhhbUY0WDNKbGMzVnNkSE5mWTI5dWRHRnBibVZ5TG1GMGRISW9YQ0prWVhSaExYQmhaMlZrWENJc0lERXBPeUF2TDJsdWFYUWdjR0ZuWldSY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdVkyRnVSbVYwWTJoQmFtRjRVbVZ6ZFd4MGN5Z3BLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdMeTkwYUdWdUlIZGxJSGRwYkd3Z1lXcGhlQ0J6ZFdKdGFYUWdkR2hsSUdadmNtMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbUZxWVhoZllXTjBhVzl1SUQwZ1hDSnpkV0p0YVhSY0lqc2dMeTl6YnlCM1pTQnJibTkzSUdsMElIZGhjMjRuZENCd1lXZHBibUYwYVc5dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1abGRHTm9RV3BoZUZKbGMzVnNkSE1vS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhzdkwzUm9aVzRnZDJVZ2QybHNiQ0J6YVcxd2JIa2djbVZrYVhKbFkzUWdkRzhnZEdobElGSmxjM1ZzZEhNZ1ZWSk1YSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEpsYzNWc2RITmZkWEpzSUQwZ2NISnZZMlZ6YzE5bWIzSnRMbWRsZEZKbGMzVnNkSE5WY213b2MyVnNaaXdnYzJWc1ppNXlaWE4xYkhSelgzVnliQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVuWlhSVmNteFFZWEpoYlhNb2RISjFaU3dnSnljcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbVZ6ZFd4MGMxOTFjbXdnUFNCelpXeG1MbUZrWkZWeWJGQmhjbUZ0S0hKbGMzVnNkSE5mZFhKc0xDQnhkV1Z5ZVY5d1lYSmhiWE1wTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSGRwYm1SdmR5NXNiMk5oZEdsdmJpNW9jbVZtSUQwZ2NtVnpkV3gwYzE5MWNtdzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQjlPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVjbVZ6WlhSR2IzSnRJRDBnWm5WdVkzUnBiMjRvYzNWaWJXbDBYMlp2Y20wcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMM1Z1YzJWMElHRnNiQ0JtYVdWc1pITmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0b0tYdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR1pwWld4a0lEMGdKQ2gwYUdsektUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhRa1ptbGxiR1F1Y21WdGIzWmxRWFIwY2loY0ltUmhkR0V0YzJZdGRHRjRiMjV2YlhrdFlYSmphR2wyWlZ3aUtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMzUmhibVJoY21RZ1ptbGxiR1FnZEhsd1pYTmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JtYVdWc1pDNW1hVzVrS0Z3aWMyVnNaV04wT201dmRDaGJiWFZzZEdsd2JHVTlKMjExYkhScGNHeGxKMTBwSUQ0Z2IzQjBhVzl1T21acGNuTjBMV05vYVd4a1hDSXBMbkJ5YjNBb1hDSnpaV3hsWTNSbFpGd2lMQ0IwY25WbEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JtYVdWc1pDNW1hVzVrS0Z3aWMyVnNaV04wVzIxMWJIUnBjR3hsUFNkdGRXeDBhWEJzWlNkZElENGdiM0IwYVc5dVhDSXBMbkJ5YjNBb1hDSnpaV3hsWTNSbFpGd2lMQ0JtWVd4elpTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWm1sbGJHUXVabWx1WkNoY0ltbHVjSFYwVzNSNWNHVTlKMk5vWldOclltOTRKMTFjSWlrdWNISnZjQ2hjSW1Ob1pXTnJaV1JjSWl3Z1ptRnNjMlVwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHWnBaV3hrTG1acGJtUW9YQ0krSUhWc0lENGdiR2s2Wm1seWMzUXRZMmhwYkdRZ2FXNXdkWFJiZEhsd1pUMG5jbUZrYVc4blhWd2lLUzV3Y205d0tGd2lZMmhsWTJ0bFpGd2lMQ0IwY25WbEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JtYVdWc1pDNW1hVzVrS0Z3aWFXNXdkWFJiZEhsd1pUMG5kR1Y0ZENkZFhDSXBMblpoYkNoY0lsd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbWFXVnNaQzVtYVc1a0tGd2lMbk5tTFc5d2RHbHZiaTFoWTNScGRtVmNJaWt1Y21WdGIzWmxRMnhoYzNNb1hDSnpaaTF2Y0hScGIyNHRZV04wYVhabFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdacFpXeGtMbVpwYm1Rb1hDSStJSFZzSUQ0Z2JHazZabWx5YzNRdFkyaHBiR1FnYVc1d2RYUmJkSGx3WlQwbmNtRmthVzhuWFZ3aUtTNXdZWEpsYm5Rb0tTNWhaR1JEYkdGemN5aGNJbk5tTFc5d2RHbHZiaTFoWTNScGRtVmNJaWs3SUM4dmNtVWdZV1JrSUdGamRHbDJaU0JqYkdGemN5QjBieUJtYVhKemRDQmNJbVJsWm1GMWJIUmNJaUJ2Y0hScGIyNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyNTFiV0psY2lCeVlXNW5aU0F0SURJZ2JuVnRZbVZ5SUdsdWNIVjBJR1pwWld4a2MxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR1pwWld4a0xtWnBibVFvWENKcGJuQjFkRnQwZVhCbFBTZHVkVzFpWlhJblhWd2lLUzVsWVdOb0tHWjFibU4wYVc5dUtHbHVaR1Y0S1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwYUdselNXNXdkWFFnUFNBa0tIUm9hWE1wTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tkR2hwYzBsdWNIVjBMbkJoY21WdWRDZ3BMbkJoY21WdWRDZ3BMbWhoYzBOc1lYTnpLRndpYzJZdGJXVjBZUzF5WVc1blpWd2lLU2tnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYVc1a1pYZzlQVEFwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdselNXNXdkWFF1ZG1Gc0tDUjBhR2x6U1c1d2RYUXVZWFIwY2loY0ltMXBibHdpS1NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCcFppaHBibVJsZUQwOU1Ta2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUm9hWE5KYm5CMWRDNTJZV3dvSkhSb2FYTkpibkIxZEM1aGRIUnlLRndpYldGNFhDSXBLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMjFsZEdFZ0x5QnVkVzFpWlhKeklIZHBkR2dnTWlCcGJuQjFkSE1nS0daeWIyMGdMeUIwYnlCbWFXVnNaSE1wSUMwZ2MyVmpiMjVrSUdsdWNIVjBJRzExYzNRZ1ltVWdjbVZ6WlhRZ2RHOGdiV0Y0SUhaaGJIVmxYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHMWxkR0ZmYzJWc1pXTjBYMlp5YjIxZmRHOGdQU0FrWm1sbGJHUXVabWx1WkNoY0lpNXpaaTF0WlhSaExYSmhibWRsTFhObGJHVmpkQzFtY205dGRHOWNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvSkcxbGRHRmZjMlZzWldOMFgyWnliMjFmZEc4dWJHVnVaM1JvUGpBcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOMFlYSjBYMjFwYmlBOUlDUnRaWFJoWDNObGJHVmpkRjltY205dFgzUnZMbUYwZEhJb1hDSmtZWFJoTFcxcGJsd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzNSaGNuUmZiV0Y0SUQwZ0pHMWxkR0ZmYzJWc1pXTjBYMlp5YjIxZmRHOHVZWFIwY2loY0ltUmhkR0V0YldGNFhDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrYldWMFlWOXpaV3hsWTNSZlpuSnZiVjkwYnk1bWFXNWtLRndpYzJWc1pXTjBYQ0lwTG1WaFkyZ29ablZ1WTNScGIyNG9hVzVrWlhncGUxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUjBhR2x6U1c1d2RYUWdQU0FrS0hSb2FYTXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9hVzVrWlhnOVBUQXBJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGMwbHVjSFYwTG5aaGJDaHpkR0Z5ZEY5dGFXNHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYVc1a1pYZzlQVEVwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdselNXNXdkWFF1ZG1Gc0tITjBZWEowWDIxaGVDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1J0WlhSaFgzSmhaR2x2WDJaeWIyMWZkRzhnUFNBa1ptbGxiR1F1Wm1sdVpDaGNJaTV6WmkxdFpYUmhMWEpoYm1kbExYSmhaR2x2TFdaeWIyMTBiMXdpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlna2JXVjBZVjl5WVdScGIxOW1jbTl0WDNSdkxteGxibWQwYUQ0d0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6ZEdGeWRGOXRhVzRnUFNBa2JXVjBZVjl5WVdScGIxOW1jbTl0WDNSdkxtRjBkSElvWENKa1lYUmhMVzFwYmx3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjM1JoY25SZmJXRjRJRDBnSkcxbGRHRmZjbUZrYVc5ZlpuSnZiVjkwYnk1aGRIUnlLRndpWkdGMFlTMXRZWGhjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrY21Ga2FXOWZaM0p2ZFhCeklEMGdKRzFsZEdGZmNtRmthVzlmWm5KdmJWOTBieTVtYVc1a0tDY3VjMll0YVc1d2RYUXRjbUZ1WjJVdGNtRmthVzhuS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pISmhaR2x2WDJkeWIzVndjeTVsWVdOb0tHWjFibU4wYVc5dUtHbHVaR1Y0S1h0Y2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSEpoWkdsdmN5QTlJQ1FvZEdocGN5a3VabWx1WkNoY0lpNXpaaTFwYm5CMWRDMXlZV1JwYjF3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSEpoWkdsdmN5NXdjbTl3S0Z3aVkyaGxZMnRsWkZ3aUxDQm1ZV3h6WlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlocGJtUmxlRDA5TUNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhKaFpHbHZjeTVtYVd4MFpYSW9KMXQyWVd4MVpUMWNJaWNyYzNSaGNuUmZiV2x1S3lkY0lsMG5LUzV3Y205d0tGd2lZMmhsWTJ0bFpGd2lMQ0IwY25WbEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElHbG1LR2x1WkdWNFBUMHhLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtjbUZrYVc5ekxtWnBiSFJsY2lnblczWmhiSFZsUFZ3aUp5dHpkR0Z5ZEY5dFlYZ3JKMXdpWFNjcExuQnliM0FvWENKamFHVmphMlZrWENJc0lIUnlkV1VwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyNTFiV0psY2lCemJHbGtaWElnTFNCdWIxVnBVMnhwWkdWeVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRdVptbHVaQ2hjSWk1dFpYUmhMWE5zYVdSbGNsd2lLUzVsWVdOb0tHWjFibU4wYVc5dUtHbHVaR1Y0S1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE5zYVdSbGNsOXZZbXBsWTNRZ1BTQWtLSFJvYVhNcFd6QmRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHFkbUZ5SUhOc2FXUmxjbDl2WW1wbFkzUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0l1YldWMFlTMXpiR2xrWlhKY0lpbGJNRjA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCemJHbGtaWEpmZG1Gc0lEMGdjMnhwWkdWeVgyOWlhbVZqZEM1dWIxVnBVMnhwWkdWeUxtZGxkQ2dwT3lvdlhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrYzJ4cFpHVnlYMlZzSUQwZ0pDaDBhR2x6S1M1amJHOXpaWE4wS0Z3aUxuTm1MVzFsZEdFdGNtRnVaMlV0YzJ4cFpHVnlYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdGFXNVdZV3dnUFNBa2MyeHBaR1Z5WDJWc0xtRjBkSElvWENKa1lYUmhMVzFwYmx3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiV0Y0Vm1Gc0lEMGdKSE5zYVdSbGNsOWxiQzVoZEhSeUtGd2laR0YwWVMxdFlYaGNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMnhwWkdWeVgyOWlhbVZqZEM1dWIxVnBVMnhwWkdWeUxuTmxkQ2hiYldsdVZtRnNMQ0J0WVhoV1lXeGRLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMjVsWldRZ2RHOGdjMlZsSUdsbUlHRnVlU0JoY21VZ1kyOXRZbTlpYjNnZ1lXNWtJR0ZqZENCaFkyTnZjbVJwYm1kc2VWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSamIyMWliMkp2ZUNBOUlDUm1hV1ZzWkM1bWFXNWtLRndpYzJWc1pXTjBXMlJoZEdFdFkyOXRZbTlpYjNnOUp6RW5YVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1JqYjIxaWIySnZlQzVzWlc1bmRHZytNQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2RIbHdaVzltSUNSamIyMWliMkp2ZUM1amFHOXpaVzRnSVQwZ1hDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JqYjIxaWIySnZlQzUwY21sbloyVnlLRndpWTJodmMyVnVPblZ3WkdGMFpXUmNJaWs3SUM4dlptOXlJR05vYjNObGJpQnZibXg1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlZjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JqYjIxaWIySnZlQzUyWVd3b0p5Y3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWTI5dFltOWliM2d1ZEhKcFoyZGxjaWduWTJoaGJtZGxMbk5sYkdWamRESW5LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVkyeGxZWEpVYVcxbGNpZ3BPMXh5WEc1Y2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloemRXSnRhWFJmWm05eWJUMDlYQ0poYkhkaGVYTmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXpkV0p0YVhSR2IzSnRLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCcFppaHpkV0p0YVhSZlptOXliVDA5WENKdVpYWmxjbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaDBhR2x6TG1GMWRHOWZZMjkxYm5SZmNtVm1jbVZ6YUY5dGIyUmxQVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVabTl5YlZWd1pHRjBaV1JHWlhSamFFRnFZWGdvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJR2xtS0hOMVltMXBkRjltYjNKdFBUMWNJbUYxZEc5Y0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvZEdocGN5NWhkWFJ2WDNWd1pHRjBaVDA5ZEhKMVpTbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5OMVltMXBkRVp2Y20wb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWgwYUdsekxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsUFQweEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVtYjNKdFZYQmtZWFJsWkVabGRHTm9RV3BoZUNncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbWx1YVhRb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RtRnlJR1YyWlc1MFgyUmhkR0VnUFNCN2ZUdGNjbHh1SUNBZ0lDQWdJQ0JsZG1WdWRGOWtZWFJoTG5ObWFXUWdQU0J6Wld4bUxuTm1hV1E3WEhKY2JpQWdJQ0FnSUNBZ1pYWmxiblJmWkdGMFlTNTBZWEpuWlhSVFpXeGxZM1J2Y2lBOUlITmxiR1l1WVdwaGVGOTBZWEpuWlhSZllYUjBjanRjY2x4dUlDQWdJQ0FnSUNCbGRtVnVkRjlrWVhSaExtOWlhbVZqZENBOUlIUm9hWE03WEhKY2JpQWdJQ0FnSUNBZ2FXWW9iM0IwY3k1cGMwbHVhWFFwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MblJ5YVdkblpYSkZkbVZ1ZENoY0luTm1PbWx1YVhSY0lpd2daWFpsYm5SZlpHRjBZU2s3WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJSDBwTzF4eVhHNTlPMXh5WEc0aVhYMD0iLCIoZnVuY3Rpb24gKGdsb2JhbCl7XG5cclxudmFyICQgPSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xyXG5cclxubW9kdWxlLmV4cG9ydHMgPSB7XHJcblxyXG5cdHRheG9ub215X2FyY2hpdmVzOiAwLFxyXG4gICAgdXJsX3BhcmFtczoge30sXHJcbiAgICB0YXhfYXJjaGl2ZV9yZXN1bHRzX3VybDogXCJcIixcclxuICAgIGFjdGl2ZV90YXg6IFwiXCIsXHJcbiAgICBmaWVsZHM6IHt9LFxyXG5cdGluaXQ6IGZ1bmN0aW9uKHRheG9ub215X2FyY2hpdmVzLCBjdXJyZW50X3RheG9ub215X2FyY2hpdmUpe1xyXG5cclxuICAgICAgICB0aGlzLnRheG9ub215X2FyY2hpdmVzID0gMDtcclxuICAgICAgICB0aGlzLnVybF9wYXJhbXMgPSB7fTtcclxuICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICB0aGlzLmFjdGl2ZV90YXggPSBcIlwiO1xyXG5cclxuXHRcdC8vdGhpcy4kZmllbGRzID0gJGZpZWxkcztcclxuICAgICAgICB0aGlzLnRheG9ub215X2FyY2hpdmVzID0gdGF4b25vbXlfYXJjaGl2ZXM7XHJcbiAgICAgICAgdGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgPSBjdXJyZW50X3RheG9ub215X2FyY2hpdmU7XHJcblxyXG5cdFx0dGhpcy5jbGVhclVybENvbXBvbmVudHMoKTtcclxuXHJcblx0fSxcclxuICAgIHNldFRheEFyY2hpdmVSZXN1bHRzVXJsOiBmdW5jdGlvbigkZm9ybSwgY3VycmVudF9yZXN1bHRzX3VybCwgZ2V0X2FjdGl2ZSkge1xyXG5cclxuICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHR0aGlzLmNsZWFyVGF4QXJjaGl2ZVJlc3VsdHNVcmwoKTtcclxuICAgICAgICAvL3ZhciBjdXJyZW50X3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICBpZih0aGlzLnRheG9ub215X2FyY2hpdmVzIT0xKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKGdldF9hY3RpdmUpPT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHR2YXIgZ2V0X2FjdGl2ZSA9IGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuICAgICAgICAvL2NoZWNrIHRvIHNlZSBpZiB3ZSBoYXZlIGFueSB0YXhvbm9taWVzIHNlbGVjdGVkXHJcbiAgICAgICAgLy9pZiBzbywgY2hlY2sgdGhlaXIgcmV3cml0ZXMgYW5kIHVzZSB0aG9zZSBhcyB0aGUgcmVzdWx0cyB1cmxcclxuICAgICAgICB2YXIgJGZpZWxkID0gZmFsc2U7XHJcbiAgICAgICAgdmFyIGZpZWxkX25hbWUgPSBcIlwiO1xyXG4gICAgICAgIHZhciBmaWVsZF92YWx1ZSA9IFwiXCI7XHJcblxyXG4gICAgICAgIHZhciAkYWN0aXZlX3RheG9ub215ID0gJGZvcm0uJGZpZWxkcy5wYXJlbnQoKS5maW5kKFwiW2RhdGEtc2YtdGF4b25vbXktYXJjaGl2ZT0nMSddXCIpO1xyXG4gICAgICAgIGlmKCRhY3RpdmVfdGF4b25vbXkubGVuZ3RoPT0xKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgJGZpZWxkID0gJGFjdGl2ZV90YXhvbm9teTtcclxuXHJcbiAgICAgICAgICAgIHZhciBmaWVsZFR5cGUgPSAkZmllbGQuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHJcbiAgICAgICAgICAgIGlmICgoZmllbGRUeXBlID09IFwidGFnXCIpIHx8IChmaWVsZFR5cGUgPT0gXCJjYXRlZ29yeVwiKSB8fCAoZmllbGRUeXBlID09IFwidGF4b25vbXlcIikpIHtcclxuICAgICAgICAgICAgICAgIHZhciB0YXhvbm9teV92YWx1ZSA9IHNlbGYucHJvY2Vzc1RheG9ub215KCRmaWVsZCwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICBmaWVsZF9uYW1lID0gJGZpZWxkLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgdGF4b25vbXlfbmFtZSA9IGZpZWxkX25hbWUucmVwbGFjZShcIl9zZnRfXCIsIFwiXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmICh0YXhvbm9teV92YWx1ZSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGZpZWxkX3ZhbHVlID0gdGF4b25vbXlfdmFsdWUudmFsdWU7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKGZpZWxkX3ZhbHVlPT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQgPSBmYWxzZTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYoKHNlbGYuY3VycmVudF90YXhvbm9teV9hcmNoaXZlIT1cIlwiKSYmKHNlbGYuY3VycmVudF90YXhvbm9teV9hcmNoaXZlIT10YXhvbm9teV9uYW1lKSlcclxuICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gY3VycmVudF9yZXN1bHRzX3VybDtcclxuICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYoKChmaWVsZF92YWx1ZT09XCJcIil8fCghJGZpZWxkKSApKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgJGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uICgpIHtcclxuXHJcbiAgICAgICAgICAgICAgICBpZiAoISRmaWVsZCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRUeXBlID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAoKGZpZWxkVHlwZSA9PSBcInRhZ1wiKSB8fCAoZmllbGRUeXBlID09IFwiY2F0ZWdvcnlcIikgfHwgKGZpZWxkVHlwZSA9PSBcInRheG9ub215XCIpKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB0YXhvbm9teV92YWx1ZSA9IHNlbGYucHJvY2Vzc1RheG9ub215KCQodGhpcyksIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmaWVsZF9uYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHRheG9ub215X3ZhbHVlKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZmllbGRfdmFsdWUgPSB0YXhvbm9teV92YWx1ZS52YWx1ZTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoZmllbGRfdmFsdWUgIT0gXCJcIikge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZmllbGQgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZiggKCRmaWVsZCkgJiYgKGZpZWxkX3ZhbHVlICE9IFwiXCIgKSkge1xyXG4gICAgICAgICAgICAvL2lmIHdlIGZvdW5kIGEgZmllbGRcclxuXHRcdFx0dmFyIHJld3JpdGVfYXR0ciA9ICgkZmllbGQuYXR0cihcImRhdGEtc2YtdGVybS1yZXdyaXRlXCIpKTtcclxuXHJcbiAgICAgICAgICAgIGlmKHJld3JpdGVfYXR0ciE9XCJcIikge1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciByZXdyaXRlID0gSlNPTi5wYXJzZShyZXdyaXRlX2F0dHIpO1xyXG4gICAgICAgICAgICAgICAgdmFyIGlucHV0X3R5cGUgPSAkZmllbGQuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWN0aXZlX3RheCA9IGZpZWxkX25hbWU7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9maW5kIHRoZSBhY3RpdmUgZWxlbWVudFxyXG4gICAgICAgICAgICAgICAgaWYgKChpbnB1dF90eXBlID09IFwicmFkaW9cIikgfHwgKGlucHV0X3R5cGUgPT0gXCJjaGVja2JveFwiKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3ZhciAkYWN0aXZlID0gJGZpZWxkLmZpbmQoXCIuc2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAvL2V4cGxvZGUgdGhlIHZhbHVlcyBpZiB0aGVyZSBpcyBhIGRlbGltXHJcbiAgICAgICAgICAgICAgICAgICAgLy9maWVsZF92YWx1ZVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgaXNfc2luZ2xlX3ZhbHVlID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRfdmFsdWVzID0gZmllbGRfdmFsdWUuc3BsaXQoXCIsXCIpLmpvaW4oXCIrXCIpLnNwbGl0KFwiK1wiKTtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoZmllbGRfdmFsdWVzLmxlbmd0aCA+IDEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaXNfc2luZ2xlX3ZhbHVlID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAoaXNfc2luZ2xlX3ZhbHVlKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gJGZpZWxkLmZpbmQoXCJpbnB1dFt2YWx1ZT0nXCIgKyBmaWVsZF92YWx1ZSArIFwiJ11cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlID0gJGlucHV0LnBhcmVudCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGggPSAkYWN0aXZlLmF0dHIoXCJkYXRhLXNmLWRlcHRoXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9ub3cgbG9vcCB0aHJvdWdoIHBhcmVudHMgdG8gZ3JhYiB0aGVpciBuYW1lc1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWVzID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKGZpZWxkX3ZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZvciAodmFyIGkgPSBkZXB0aDsgaSA+IDA7IGktLSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGFjdGl2ZSA9ICRhY3RpdmUucGFyZW50KCkucGFyZW50KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaCgkYWN0aXZlLmZpbmQoXCJpbnB1dFwiKS52YWwoKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5yZXZlcnNlKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJld3JpdGUgZm9yIHRoaXMgZGVwdGhcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGFjdGl2ZV9yZXdyaXRlID0gcmV3cml0ZVtkZXB0aF07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB1cmwgPSBhY3RpdmVfcmV3cml0ZTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3RoZW4gbWFwIGZyb20gdGhlIHBhcmVudHMgdG8gdGhlIGRlcHRoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQodmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB1cmwgPSB1cmwucmVwbGFjZShcIltcIiArIGluZGV4ICsgXCJdXCIsIHZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gdXJsO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaWYgdGhlcmUgYXJlIG11bHRpcGxlIHZhbHVlcyxcclxuICAgICAgICAgICAgICAgICAgICAgICAgLy90aGVuIHdlIG5lZWQgdG8gY2hlY2sgZm9yIDMgdGhpbmdzOlxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pZiB0aGUgdmFsdWVzIHNlbGVjdGVkIGFyZSBhbGwgaW4gdGhlIHNhbWUgdHJlZSB0aGVuIHdlIGNhbiBkbyBzb21lIGNsZXZlciByZXdyaXRlIHN0dWZmXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vbWVyZ2UgYWxsIHZhbHVlcyBpbiBzYW1lIGxldmVsLCB0aGVuIGNvbWJpbmUgdGhlIGxldmVsc1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pZiB0aGV5IGFyZSBmcm9tIGRpZmZlcmVudCB0cmVlcyB0aGVuIGp1c3QgY29tYmluZSB0aGVtIG9yIGp1c3QgdXNlIGBmaWVsZF92YWx1ZWBcclxuICAgICAgICAgICAgICAgICAgICAgICAgLypcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGhzID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAkKGZpZWxkX3ZhbHVlcykuZWFjaChmdW5jdGlvbiAoaW5kZXgsIHZhbCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkaW5wdXQgPSAkZmllbGQuZmluZChcImlucHV0W3ZhbHVlPSdcIiArIGZpZWxkX3ZhbHVlICsgXCInXVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlID0gJGlucHV0LnBhcmVudCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aCA9ICRhY3RpdmUuYXR0cihcImRhdGEtc2YtZGVwdGhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAvL2RlcHRocy5wdXNoKGRlcHRoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICB9KTsqL1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmICgoaW5wdXRfdHlwZSA9PSBcInNlbGVjdFwiKSB8fCAoaW5wdXRfdHlwZSA9PSBcIm11bHRpc2VsZWN0XCIpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBpc19zaW5nbGVfdmFsdWUgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZF92YWx1ZXMgPSBmaWVsZF92YWx1ZS5zcGxpdChcIixcIikuam9pbihcIitcIikuc3BsaXQoXCIrXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChmaWVsZF92YWx1ZXMubGVuZ3RoID4gMSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpc19zaW5nbGVfdmFsdWUgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmIChpc19zaW5nbGVfdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlID0gJGZpZWxkLmZpbmQoXCJvcHRpb25bdmFsdWU9J1wiICsgZmllbGRfdmFsdWUgKyBcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGggPSAkYWN0aXZlLmF0dHIoXCJkYXRhLXNmLWRlcHRoXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHZhbHVlcyA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaChmaWVsZF92YWx1ZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBmb3IgKHZhciBpID0gZGVwdGg7IGkgPiAwOyBpLS0pIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRhY3RpdmUgPSAkYWN0aXZlLnByZXZBbGwoXCJvcHRpb25bZGF0YS1zZi1kZXB0aD0nXCIgKyAoaSAtIDEpICsgXCInXVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKCRhY3RpdmUudmFsKCkpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucmV2ZXJzZSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgYWN0aXZlX3Jld3JpdGUgPSByZXdyaXRlW2RlcHRoXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHVybCA9IGFjdGl2ZV9yZXdyaXRlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKHZhbHVlcykuZWFjaChmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsID0gdXJsLnJlcGxhY2UoXCJbXCIgKyBpbmRleCArIFwiXVwiLCB2YWx1ZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IHVybDtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgIH1cclxuICAgICAgICAvL3RoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSBjdXJyZW50X3Jlc3VsdHNfdXJsO1xyXG4gICAgfSxcclxuICAgIGdldFJlc3VsdHNVcmw6IGZ1bmN0aW9uKCRmb3JtLCBjdXJyZW50X3Jlc3VsdHNfdXJsKSB7XHJcblxyXG4gICAgICAgIC8vdGhpcy5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybCgkZm9ybSwgY3VycmVudF9yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgIGlmKHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmw9PVwiXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICByZXR1cm4gY3VycmVudF9yZXN1bHRzX3VybDtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHJldHVybiB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsO1xyXG4gICAgfSxcclxuXHRnZXRVcmxQYXJhbXM6IGZ1bmN0aW9uKCRmb3JtKXtcclxuXHJcblx0XHR0aGlzLmJ1aWxkVXJsQ29tcG9uZW50cygkZm9ybSwgdHJ1ZSk7XHJcblxyXG4gICAgICAgIGlmKHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwhPVwiXCIpXHJcbiAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgaWYodGhpcy5hY3RpdmVfdGF4IT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZmllbGRfbmFtZSA9IHRoaXMuYWN0aXZlX3RheDtcclxuXHJcbiAgICAgICAgICAgICAgICBpZih0eXBlb2YodGhpcy51cmxfcGFyYW1zW2ZpZWxkX25hbWVdKSE9XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBkZWxldGUgdGhpcy51cmxfcGFyYW1zW2ZpZWxkX25hbWVdO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuXHRcdHJldHVybiB0aGlzLnVybF9wYXJhbXM7XHJcblx0fSxcclxuXHRjbGVhclVybENvbXBvbmVudHM6IGZ1bmN0aW9uKCl7XHJcblx0XHQvL3RoaXMudXJsX2NvbXBvbmVudHMgPSBcIlwiO1xyXG5cdFx0dGhpcy51cmxfcGFyYW1zID0ge307XHJcblx0fSxcclxuXHRjbGVhclRheEFyY2hpdmVSZXN1bHRzVXJsOiBmdW5jdGlvbigpIHtcclxuXHRcdHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSAnJztcclxuXHR9LFxyXG5cdGRpc2FibGVJbnB1dHM6IGZ1bmN0aW9uKCRmb3JtKXtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFxyXG5cdFx0XHR2YXIgJGlucHV0cyA9ICQodGhpcykuZmluZChcImlucHV0LCBzZWxlY3QsIC5tZXRhLXNsaWRlclwiKTtcclxuXHRcdFx0JGlucHV0cy5hdHRyKFwiZGlzYWJsZWRcIiwgXCJkaXNhYmxlZFwiKTtcclxuXHRcdFx0JGlucHV0cy5hdHRyKFwiZGlzYWJsZWRcIiwgdHJ1ZSk7XHJcblx0XHRcdCRpbnB1dHMucHJvcChcImRpc2FibGVkXCIsIHRydWUpO1xyXG5cdFx0XHQkaW5wdXRzLnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTtcclxuXHRcdFx0XHJcblx0XHR9KTtcclxuXHRcdFxyXG5cdFx0XHJcblx0fSxcclxuXHRlbmFibGVJbnB1dHM6IGZ1bmN0aW9uKCRmb3JtKXtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdCRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHR2YXIgJGlucHV0cyA9ICQodGhpcykuZmluZChcImlucHV0LCBzZWxlY3QsIC5tZXRhLXNsaWRlclwiKTtcclxuXHRcdFx0JGlucHV0cy5wcm9wKFwiZGlzYWJsZWRcIiwgZmFsc2UpO1xyXG5cdFx0XHQkaW5wdXRzLmF0dHIoXCJkaXNhYmxlZFwiLCBmYWxzZSk7XHJcblx0XHRcdCRpbnB1dHMudHJpZ2dlcihcImNob3Nlbjp1cGRhdGVkXCIpO1x0XHRcdFxyXG5cdFx0fSk7XHJcblx0XHRcclxuXHRcdFxyXG5cdH0sXHJcblx0YnVpbGRVcmxDb21wb25lbnRzOiBmdW5jdGlvbigkZm9ybSwgY2xlYXJfY29tcG9uZW50cyl7XHJcblx0XHRcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKGNsZWFyX2NvbXBvbmVudHMpIT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihjbGVhcl9jb21wb25lbnRzPT10cnVlKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0dGhpcy5jbGVhclVybENvbXBvbmVudHMoKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHQkZm9ybS4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHJcblx0XHRcdHZhciBmaWVsZE5hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblx0XHRcdHZhciBmaWVsZFR5cGUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblx0XHRcdFxyXG5cdFx0XHRpZihmaWVsZFR5cGU9PVwic2VhcmNoXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NTZWFyY2hGaWVsZCgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKChmaWVsZFR5cGU9PVwidGFnXCIpfHwoZmllbGRUeXBlPT1cImNhdGVnb3J5XCIpfHwoZmllbGRUeXBlPT1cInRheG9ub215XCIpKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzVGF4b25vbXkoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwic29ydF9vcmRlclwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzU29ydE9yZGVyRmllbGQoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdHNfcGVyX3BhZ2VcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Jlc3VsdHNQZXJQYWdlRmllbGQoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwiYXV0aG9yXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NBdXRob3IoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdF90eXBlXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NQb3N0VHlwZSgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0X2RhdGVcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Bvc3REYXRlKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInBvc3RfbWV0YVwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzUG9zdE1ldGEoJCh0aGlzKSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHR9KTtcclxuXHRcdFxyXG5cdH0sXHJcblx0cHJvY2Vzc1NlYXJjaEZpZWxkOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0dmFyICRmaWVsZCA9ICRjb250YWluZXIuZmluZChcImlucHV0W25hbWVePSdfc2Zfc2VhcmNoJ11cIik7XHJcblx0XHRcclxuXHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdHtcclxuXHRcdFx0dmFyIGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLnZhbCgpO1xyXG5cdFx0XHRcclxuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImX3NmX3M9XCIrZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkVmFsKTtcclxuXHRcdFx0XHRzZWxmLnVybF9wYXJhbXNbJ19zZl9zJ10gPSBlbmNvZGVVUklDb21wb25lbnQoZmllbGRWYWwpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0fSxcclxuXHRwcm9jZXNzU29ydE9yZGVyRmllbGQ6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dGhpcy5wcm9jZXNzQXV0aG9yKCRjb250YWluZXIpO1xyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzUmVzdWx0c1BlclBhZ2VGaWVsZDogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR0aGlzLnByb2Nlc3NBdXRob3IoJGNvbnRhaW5lcik7XHJcblx0XHRcclxuXHR9LFxyXG5cdGdldEFjdGl2ZVRheDogZnVuY3Rpb24oJGZpZWxkKSB7XHJcblx0XHRyZXR1cm4gdGhpcy5hY3RpdmVfdGF4O1xyXG5cdH0sXHJcblx0Z2V0U2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQpe1xyXG5cclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHRcclxuXHRcdGlmKCRmaWVsZC52YWwoKSE9MClcclxuXHRcdHtcclxuXHRcdFx0ZmllbGRWYWwgPSAkZmllbGQudmFsKCk7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKGZpZWxkVmFsPT1udWxsKVxyXG5cdFx0e1xyXG5cdFx0XHRmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdHJldHVybiBmaWVsZFZhbDtcclxuXHR9LFxyXG5cdGdldE1ldGFTZWxlY3RWYWw6IGZ1bmN0aW9uKCRmaWVsZCl7XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHRcclxuXHRcdGZpZWxkVmFsID0gJGZpZWxkLnZhbCgpO1xyXG5cdFx0XHRcdFx0XHRcclxuXHRcdGlmKGZpZWxkVmFsPT1udWxsKVxyXG5cdFx0e1xyXG5cdFx0XHRmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdHJldHVybiBmaWVsZFZhbDtcclxuXHR9LFxyXG5cdGdldE11bHRpU2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQsIG9wZXJhdG9yKXtcclxuXHRcdFxyXG5cdFx0dmFyIGRlbGltID0gXCIrXCI7XHJcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRkZWxpbSA9IFwiLFwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoJGZpZWxkLnZhbCgpKT09XCJvYmplY3RcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoJGZpZWxkLnZhbCgpIT1udWxsKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0cmV0dXJuICRmaWVsZC52YWwoKS5qb2luKGRlbGltKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0fSxcclxuXHRnZXRNZXRhTXVsdGlTZWxlY3RWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xyXG5cdFx0XHJcblx0XHR2YXIgZGVsaW0gPSBcIi0rLVwiO1xyXG5cdFx0aWYob3BlcmF0b3I9PVwib3JcIilcclxuXHRcdHtcclxuXHRcdFx0ZGVsaW0gPSBcIi0sLVwiO1xyXG5cdFx0fVxyXG5cdFx0XHRcdFxyXG5cdFx0aWYodHlwZW9mKCRmaWVsZC52YWwoKSk9PVwib2JqZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKCRmaWVsZC52YWwoKSE9bnVsbClcclxuXHRcdFx0e1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdHZhciBmaWVsZHZhbCA9IFtdO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdCQoJGZpZWxkLnZhbCgpKS5lYWNoKGZ1bmN0aW9uKGluZGV4LHZhbHVlKXtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0ZmllbGR2YWwucHVzaCgodmFsdWUpKTtcclxuXHRcdFx0XHR9KTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRyZXR1cm4gZmllbGR2YWwuam9pbihkZWxpbSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0cmV0dXJuIFwiXCI7XHJcblx0XHRcclxuXHR9LFxyXG5cdGdldENoZWNrYm94VmFsOiBmdW5jdGlvbigkZmllbGQsIG9wZXJhdG9yKXtcclxuXHRcdFxyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQubWFwKGZ1bmN0aW9uKCl7XHJcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRyZXR1cm4gJCh0aGlzKS52YWwoKTtcclxuXHRcdFx0fVxyXG5cdFx0fSkuZ2V0KCk7XHJcblx0XHRcclxuXHRcdHZhciBkZWxpbSA9IFwiK1wiO1xyXG5cdFx0aWYob3BlcmF0b3I9PVwib3JcIilcclxuXHRcdHtcclxuXHRcdFx0ZGVsaW0gPSBcIixcIjtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0cmV0dXJuIGZpZWxkVmFsLmpvaW4oZGVsaW0pO1xyXG5cdH0sXHJcblx0Z2V0TWV0YUNoZWNrYm94VmFsOiBmdW5jdGlvbigkZmllbGQsIG9wZXJhdG9yKXtcclxuXHRcdFxyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQubWFwKGZ1bmN0aW9uKCl7XHJcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRyZXR1cm4gKCQodGhpcykudmFsKCkpO1xyXG5cdFx0XHR9XHJcblx0XHR9KS5nZXQoKTtcclxuXHRcdFxyXG5cdFx0dmFyIGRlbGltID0gXCItKy1cIjtcclxuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXHJcblx0XHR7XHJcblx0XHRcdGRlbGltID0gXCItLC1cIjtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0cmV0dXJuIGZpZWxkVmFsLmpvaW4oZGVsaW0pO1xyXG5cdH0sXHJcblx0Z2V0UmFkaW9WYWw6IGZ1bmN0aW9uKCRmaWVsZCl7XHJcblx0XHRcdFx0XHRcdFx0XHJcblx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQubWFwKGZ1bmN0aW9uKClcclxuXHRcdHtcclxuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAkKHRoaXMpLnZhbCgpO1xyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fSkuZ2V0KCk7XHJcblx0XHRcclxuXHRcdFxyXG5cdFx0aWYoZmllbGRWYWxbMF0hPTApXHJcblx0XHR7XHJcblx0XHRcdHJldHVybiBmaWVsZFZhbFswXTtcclxuXHRcdH1cclxuXHR9LFxyXG5cdGdldE1ldGFSYWRpb1ZhbDogZnVuY3Rpb24oJGZpZWxkKXtcclxuXHRcdFx0XHRcdFx0XHRcclxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKVxyXG5cdFx0e1xyXG5cdFx0XHRpZigkKHRoaXMpLnByb3AoXCJjaGVja2VkXCIpPT10cnVlKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0cmV0dXJuICQodGhpcykudmFsKCk7XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHR9KS5nZXQoKTtcclxuXHRcdFxyXG5cdFx0cmV0dXJuIGZpZWxkVmFsWzBdO1xyXG5cdH0sXHJcblx0cHJvY2Vzc0F1dGhvcjogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHRcdHZhciBpbnB1dFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XHJcblx0XHRcclxuXHRcdHZhciAkZmllbGQ7XHJcblx0XHR2YXIgZmllbGROYW1lID0gXCJcIjtcclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHRcclxuXHRcdGlmKGlucHV0VHlwZT09XCJzZWxlY3RcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFxyXG5cdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0U2VsZWN0VmFsKCRmaWVsZCk7IFxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwibXVsdGlzZWxlY3RcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdHZhciBvcGVyYXRvciA9ICRmaWVsZC5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNdWx0aVNlbGVjdFZhbCgkZmllbGQsIFwib3JcIik7XHJcblx0XHRcdFxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwiY2hlY2tib3hcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpjaGVja2JveFwiKTtcclxuXHRcdFx0XHJcblx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgb3BlcmF0b3IgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRDaGVja2JveFZhbCgkZmllbGQsIFwib3JcIik7XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYWRpb1wiKVxyXG5cdFx0e1xyXG5cdFx0XHRcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpyYWRpb1wiKTtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0UmFkaW9WYWwoJGZpZWxkKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoZmllbGRWYWwpIT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHZhciBmaWVsZFNsdWcgPSBcIlwiO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKGZpZWxkTmFtZT09XCJfc2ZfYXV0aG9yXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJhdXRob3JzXCI7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2UgaWYoZmllbGROYW1lPT1cIl9zZl9zb3J0X29yZGVyXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJzb3J0X29yZGVyXCI7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2UgaWYoZmllbGROYW1lPT1cIl9zZl9wcHBcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcIl9zZl9wcHBcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZSBpZihmaWVsZE5hbWU9PVwiX3NmX3Bvc3RfdHlwZVwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwicG9zdF90eXBlc1wiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZihmaWVsZFNsdWchPVwiXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJlwiK2ZpZWxkU2x1ZytcIj1cIitmaWVsZFZhbDtcclxuXHRcdFx0XHRcdHNlbGYudXJsX3BhcmFtc1tmaWVsZFNsdWddID0gZmllbGRWYWw7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NQb3N0VHlwZSA6IGZ1bmN0aW9uKCR0aGlzKXtcclxuXHRcdFxyXG5cdFx0dGhpcy5wcm9jZXNzQXV0aG9yKCR0aGlzKTtcclxuXHRcdFxyXG5cdH0sXHJcblx0cHJvY2Vzc1Bvc3RNZXRhOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHRcdHZhciBpbnB1dFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XHJcblx0XHR2YXIgbWV0YVR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLW1ldGEtdHlwZVwiKTtcclxuXHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0dmFyICRmaWVsZDtcclxuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHRpZihtZXRhVHlwZT09XCJudW1iZXJcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoaW5wdXRUeXBlPT1cInJhbmdlLW51bWJlclwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2UtbnVtYmVyIGlucHV0XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdHZhciB2YWx1ZXMgPSBbXTtcclxuXHRcdFx0XHQkZmllbGQuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHR2YWx1ZXMucHVzaCgkKHRoaXMpLnZhbCgpKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR9KTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHZhbHVlcy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1zbGlkZXJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNsaWRlciBpbnB1dFwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQvL2dldCBhbnkgbnVtYmVyIGZvcm1hdHRpbmcgc3R1ZmZcclxuXHRcdFx0XHR2YXIgJG1ldGFfcmFuZ2UgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIGRlY2ltYWxfcGxhY2VzID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtZGVjaW1hbC1wbGFjZXNcIik7XHJcblx0XHRcdFx0dmFyIHRob3VzYW5kX3NlcGVyYXRvciA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXRob3VzYW5kLXNlcGVyYXRvclwiKTtcclxuXHRcdFx0XHR2YXIgZGVjaW1hbF9zZXBlcmF0b3IgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1kZWNpbWFsLXNlcGVyYXRvclwiKTtcclxuXHJcblx0XHRcdFx0dmFyIGZpZWxkX2Zvcm1hdCA9IHdOdW1iKHtcclxuXHRcdFx0XHRcdG1hcms6IGRlY2ltYWxfc2VwZXJhdG9yLFxyXG5cdFx0XHRcdFx0ZGVjaW1hbHM6IHBhcnNlRmxvYXQoZGVjaW1hbF9wbGFjZXMpLFxyXG5cdFx0XHRcdFx0dGhvdXNhbmQ6IHRob3VzYW5kX3NlcGVyYXRvclxyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdHZhciB2YWx1ZXMgPSBbXTtcclxuXHJcblxyXG5cdFx0XHRcdHZhciBzbGlkZXJfb2JqZWN0ID0gJGNvbnRhaW5lci5maW5kKFwiLm1ldGEtc2xpZGVyXCIpWzBdO1xyXG5cdFx0XHRcdC8vdmFsIGZyb20gc2xpZGVyIG9iamVjdFxyXG5cdFx0XHRcdHZhciBzbGlkZXJfdmFsID0gc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmdldCgpO1xyXG5cclxuXHRcdFx0XHR2YWx1ZXMucHVzaChmaWVsZF9mb3JtYXQuZnJvbShzbGlkZXJfdmFsWzBdKSk7XHJcblx0XHRcdFx0dmFsdWVzLnB1c2goZmllbGRfZm9ybWF0LmZyb20oc2xpZGVyX3ZhbFsxXSkpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gdmFsdWVzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFuZ2UtcmFkaW9cIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1pbnB1dC1yYW5nZS1yYWRpb1wiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPT0wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdC8vdGhlbiB0cnkgYWdhaW4sIHdlIG11c3QgYmUgdXNpbmcgYSBzaW5nbGUgZmllbGRcclxuXHRcdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIik7XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHR2YXIgJG1ldGFfcmFuZ2UgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZVwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQvL3RoZXJlIGlzIGFuIGVsZW1lbnQgd2l0aCBhIGZyb20vdG8gY2xhc3MgLSBzbyB3ZSBuZWVkIHRvIGdldCB0aGUgdmFsdWVzIG9mIHRoZSBmcm9tICYgdG8gaW5wdXQgZmllbGRzIHNlcGVyYXRlbHlcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1x0XHJcblx0XHRcdFx0XHR2YXIgZmllbGRfdmFscyA9IFtdO1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHQkZmllbGQuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdFx0dmFyICRyYWRpb3MgPSAkKHRoaXMpLmZpbmQoXCIuc2YtaW5wdXQtcmFkaW9cIik7XHJcblx0XHRcdFx0XHRcdGZpZWxkX3ZhbHMucHVzaChzZWxmLmdldE1ldGFSYWRpb1ZhbCgkcmFkaW9zKSk7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdC8vcHJldmVudCBzZWNvbmQgbnVtYmVyIGZyb20gYmVpbmcgbG93ZXIgdGhhbiB0aGUgZmlyc3RcclxuXHRcdFx0XHRcdGlmKGZpZWxkX3ZhbHMubGVuZ3RoPT0yKVxyXG5cdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRpZihOdW1iZXIoZmllbGRfdmFsc1sxXSk8TnVtYmVyKGZpZWxkX3ZhbHNbMF0pKVxyXG5cdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0ZmllbGRfdmFsc1sxXSA9IGZpZWxkX3ZhbHNbMF07XHJcblx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBmaWVsZF92YWxzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg9PTEpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmZpbmQoXCIuc2YtaW5wdXQtcmFkaW9cIikuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2VcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFuZ2Utc2VsZWN0XCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtaW5wdXQtc2VsZWN0XCIpO1xyXG5cdFx0XHRcdHZhciAkbWV0YV9yYW5nZSA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdC8vdGhlcmUgaXMgYW4gZWxlbWVudCB3aXRoIGEgZnJvbS90byBjbGFzcyAtIHNvIHdlIG5lZWQgdG8gZ2V0IHRoZSB2YWx1ZXMgb2YgdGhlIGZyb20gJiB0byBpbnB1dCBmaWVsZHMgc2VwZXJhdGVseVxyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHR2YXIgZmllbGRfdmFscyA9IFtdO1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHQkZmllbGQuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdFx0dmFyICR0aGlzID0gJCh0aGlzKTtcclxuXHRcdFx0XHRcdFx0ZmllbGRfdmFscy5wdXNoKHNlbGYuZ2V0TWV0YVNlbGVjdFZhbCgkdGhpcykpO1xyXG5cdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdH0pO1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHQvL3ByZXZlbnQgc2Vjb25kIG51bWJlciBmcm9tIGJlaW5nIGxvd2VyIHRoYW4gdGhlIGZpcnN0XHJcblx0XHRcdFx0XHRpZihmaWVsZF92YWxzLmxlbmd0aD09MilcclxuXHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0aWYoTnVtYmVyKGZpZWxkX3ZhbHNbMV0pPE51bWJlcihmaWVsZF92YWxzWzBdKSlcclxuXHRcdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRcdGZpZWxkX3ZhbHNbMV0gPSBmaWVsZF92YWxzWzBdO1xyXG5cdFx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBmaWVsZF92YWxzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg9PTEpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFuZ2UtY2hlY2tib3hcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRDaGVja2JveFZhbCgkZmllbGQsIFwiYW5kXCIpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdFx0aWYoZmllbGROYW1lPT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKG1ldGFUeXBlPT1cImNob2ljZVwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihpbnB1dFR5cGU9PVwic2VsZWN0XCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE1ldGFTZWxlY3RWYWwoJGZpZWxkKTsgXHJcblx0XHRcdFx0XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwibXVsdGlzZWxlY3RcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0XHR2YXIgb3BlcmF0b3IgPSAkZmllbGQuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE1ldGFNdWx0aVNlbGVjdFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJjaGVja2JveFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpjaGVja2JveFwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKS5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhQ2hlY2tib3hWYWwoJGZpZWxkLCBvcGVyYXRvcik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhZGlvXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnJhZGlvXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YVJhZGlvVmFsKCRmaWVsZCk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0XHRmaWVsZFZhbCA9IGVuY29kZVVSSUNvbXBvbmVudChmaWVsZFZhbCk7XHJcblx0XHRcdGlmKHR5cGVvZigkZmllbGQpIT09XCJ1bmRlZmluZWRcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdC8vZm9yIHRob3NlIHdobyBpbnNpc3Qgb24gdXNpbmcgJiBhbXBlcnNhbmRzIGluIHRoZSBuYW1lIG9mIHRoZSBjdXN0b20gZmllbGQgKCEpXHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAoZmllbGROYW1lKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKG1ldGFUeXBlPT1cImRhdGVcIilcclxuXHRcdHtcclxuXHRcdFx0c2VsZi5wcm9jZXNzUG9zdERhdGUoJGNvbnRhaW5lcik7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJlwiK2VuY29kZVVSSUNvbXBvbmVudChmaWVsZE5hbWUpK1wiPVwiKyhmaWVsZFZhbCk7XHJcblx0XHRcdFx0c2VsZi51cmxfcGFyYW1zW2VuY29kZVVSSUNvbXBvbmVudChmaWVsZE5hbWUpXSA9IChmaWVsZFZhbCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHR9LFxyXG5cdHByb2Nlc3NQb3N0RGF0ZTogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xyXG5cdFx0XHJcblx0XHR2YXIgJGZpZWxkO1xyXG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnRleHRcIik7XHJcblx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcclxuXHRcdHZhciBkYXRlcyA9IFtdO1xyXG5cdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHJcblx0XHRcdGRhdGVzLnB1c2goJCh0aGlzKS52YWwoKSk7XHJcblx0XHRcclxuXHRcdH0pO1xyXG5cdFx0XHJcblx0XHRpZigkZmllbGQubGVuZ3RoPT0yKVxyXG5cdFx0e1xyXG5cdFx0XHRpZigoZGF0ZXNbMF0hPVwiXCIpfHwoZGF0ZXNbMV0hPVwiXCIpKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBkYXRlcy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkVmFsLnJlcGxhY2UoL1xcLy9nLCcnKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZigkZmllbGQubGVuZ3RoPT0xKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihkYXRlc1swXSE9XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gZGF0ZXMuam9pbihcIitcIik7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBmaWVsZFZhbC5yZXBsYWNlKC9cXC8vZywnJyk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHR2YXIgZmllbGRTbHVnID0gXCJcIjtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZihmaWVsZE5hbWU9PVwiX3NmX3Bvc3RfZGF0ZVwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwicG9zdF9kYXRlXCI7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2VcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBmaWVsZE5hbWU7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKGZpZWxkU2x1ZyE9XCJcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZmllbGRTbHVnK1wiPVwiK2ZpZWxkVmFsO1xyXG5cdFx0XHRcdFx0c2VsZi51cmxfcGFyYW1zW2ZpZWxkU2x1Z10gPSBmaWVsZFZhbDtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdH0sXHJcblx0cHJvY2Vzc1RheG9ub215OiBmdW5jdGlvbigkY29udGFpbmVyLCByZXR1cm5fb2JqZWN0KVxyXG5cdHtcclxuICAgICAgICBpZih0eXBlb2YocmV0dXJuX29iamVjdCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICByZXR1cm5fb2JqZWN0ID0gZmFsc2U7XHJcbiAgICAgICAgfVxyXG5cclxuXHRcdC8vaWYoKVx0XHRcdFx0XHRcclxuXHRcdC8vdmFyIGZpZWxkTmFtZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcclxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xyXG5cdFx0XHJcblx0XHR2YXIgJGZpZWxkO1xyXG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHRpZihpbnB1dFR5cGU9PVwic2VsZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFNlbGVjdFZhbCgkZmllbGQpOyBcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cIm11bHRpc2VsZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHR2YXIgb3BlcmF0b3IgPSAkZmllbGQuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFxyXG5cdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TXVsdGlTZWxlY3RWYWwoJGZpZWxkLCBvcGVyYXRvcik7XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJjaGVja2JveFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xyXG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKS5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0Q2hlY2tib3hWYWwoJGZpZWxkLCBvcGVyYXRvcik7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhZGlvXCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6cmFkaW9cIik7XHJcblx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0UmFkaW9WYWwoJGZpZWxkKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoZmllbGRWYWwpIT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcclxuXHRcdFx0e1xyXG4gICAgICAgICAgICAgICAgaWYocmV0dXJuX29iamVjdD09dHJ1ZSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICByZXR1cm4ge25hbWU6IGZpZWxkTmFtZSwgdmFsdWU6IGZpZWxkVmFsfTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZmllbGROYW1lK1wiPVwiK2ZpZWxkVmFsO1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYudXJsX3BhcmFtc1tmaWVsZE5hbWVdID0gZmllbGRWYWw7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG4gICAgICAgIGlmKHJldHVybl9vYmplY3Q9PXRydWUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgfVxyXG5cdH1cclxufTtcbn0pLmNhbGwodGhpcyx0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsIDogdHlwZW9mIHNlbGYgIT09IFwidW5kZWZpbmVkXCIgPyBzZWxmIDogdHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvdyA6IHt9KVxuLy8jIHNvdXJjZU1hcHBpbmdVUkw9ZGF0YTphcHBsaWNhdGlvbi9qc29uO2NoYXJzZXQ6dXRmLTg7YmFzZTY0LGV5SjJaWEp6YVc5dUlqb3pMQ0p6YjNWeVkyVnpJanBiSW5OeVl5OXdkV0pzYVdNdllYTnpaWFJ6TDJwekwybHVZMngxWkdWekwzQnliMk5sYzNOZlptOXliUzVxY3lKZExDSnVZVzFsY3lJNlcxMHNJbTFoY0hCcGJtZHpJam9pTzBGQlFVRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEVpTENKbWFXeGxJam9pWjJWdVpYSmhkR1ZrTG1weklpd2ljMjkxY21ObFVtOXZkQ0k2SWlJc0luTnZkWEpqWlhORGIyNTBaVzUwSWpwYklseHlYRzUyWVhJZ0pDQTlJQ2gwZVhCbGIyWWdkMmx1Wkc5M0lDRTlQU0JjSW5WdVpHVm1hVzVsWkZ3aUlEOGdkMmx1Wkc5M1d5ZHFVWFZsY25rblhTQTZJSFI1Y0dWdlppQm5iRzlpWVd3Z0lUMDlJRndpZFc1a1pXWnBibVZrWENJZ1B5Qm5iRzlpWVd4YkoycFJkV1Z5ZVNkZElEb2diblZzYkNrN1hISmNibHh5WEc1dGIyUjFiR1V1Wlhod2IzSjBjeUE5SUh0Y2NseHVYSEpjYmx4MGRHRjRiMjV2YlhsZllYSmphR2wyWlhNNklEQXNYSEpjYmlBZ0lDQjFjbXhmY0dGeVlXMXpPaUI3ZlN4Y2NseHVJQ0FnSUhSaGVGOWhjbU5vYVhabFgzSmxjM1ZzZEhOZmRYSnNPaUJjSWx3aUxGeHlYRzRnSUNBZ1lXTjBhWFpsWDNSaGVEb2dYQ0pjSWl4Y2NseHVJQ0FnSUdacFpXeGtjem9nZTMwc1hISmNibHgwYVc1cGREb2dablZ1WTNScGIyNG9kR0Y0YjI1dmJYbGZZWEpqYUdsMlpYTXNJR04xY25KbGJuUmZkR0Y0YjI1dmJYbGZZWEpqYUdsMlpTbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11ZEdGNGIyNXZiWGxmWVhKamFHbDJaWE1nUFNBd08xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWRYSnNYM0JoY21GdGN5QTlJSHQ5TzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11ZEdGNFgyRnlZMmhwZG1WZmNtVnpkV3gwYzE5MWNtd2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVlXTjBhWFpsWDNSaGVDQTlJRndpWENJN1hISmNibHh5WEc1Y2RGeDBMeTkwYUdsekxpUm1hV1ZzWkhNZ1BTQWtabWxsYkdSek8xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWRHRjRiMjV2YlhsZllYSmphR2wyWlhNZ1BTQjBZWGh2Ym05dGVWOWhjbU5vYVhabGN6dGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtTjFjbkpsYm5SZmRHRjRiMjV2YlhsZllYSmphR2wyWlNBOUlHTjFjbkpsYm5SZmRHRjRiMjV2YlhsZllYSmphR2wyWlR0Y2NseHVYSEpjYmx4MFhIUjBhR2x6TG1Oc1pXRnlWWEpzUTI5dGNHOXVaVzUwY3lncE8xeHlYRzVjY2x4dVhIUjlMRnh5WEc0Z0lDQWdjMlYwVkdGNFFYSmphR2wyWlZKbGMzVnNkSE5WY213NklHWjFibU4wYVc5dUtDUm1iM0p0TENCamRYSnlaVzUwWDNKbGMzVnNkSE5mZFhKc0xDQm5aWFJmWVdOMGFYWmxLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhSY2RIUm9hWE11WTJ4bFlYSlVZWGhCY21Ob2FYWmxVbVZ6ZFd4MGMxVnliQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDOHZkbUZ5SUdOMWNuSmxiblJmY21WemRXeDBjMTkxY213Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lHbG1LSFJvYVhNdWRHRjRiMjV2YlhsZllYSmphR2wyWlhNaFBURXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNDdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvWjJWMFgyRmpkR2wyWlNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEhaaGNpQm5aWFJmWVdOMGFYWmxJRDBnWm1Gc2MyVTdYSEpjYmx4MFhIUjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDOHZZMmhsWTJzZ2RHOGdjMlZsSUdsbUlIZGxJR2hoZG1VZ1lXNTVJSFJoZUc5dWIyMXBaWE1nYzJWc1pXTjBaV1JjY2x4dUlDQWdJQ0FnSUNBdkwybG1JSE52TENCamFHVmpheUIwYUdWcGNpQnlaWGR5YVhSbGN5QmhibVFnZFhObElIUm9iM05sSUdGeklIUm9aU0J5WlhOMWJIUnpJSFZ5YkZ4eVhHNGdJQ0FnSUNBZ0lIWmhjaUFrWm1sbGJHUWdQU0JtWVd4elpUdGNjbHh1SUNBZ0lDQWdJQ0IyWVhJZ1ptbGxiR1JmYm1GdFpTQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdkbUZ5SUdacFpXeGtYM1poYkhWbElEMGdYQ0pjSWp0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZG1GeUlDUmhZM1JwZG1WZmRHRjRiMjV2YlhrZ1BTQWtabTl5YlM0a1ptbGxiR1J6TG5CaGNtVnVkQ2dwTG1acGJtUW9YQ0piWkdGMFlTMXpaaTEwWVhodmJtOXRlUzFoY21Ob2FYWmxQU2N4SjExY0lpazdYSEpjYmlBZ0lDQWdJQ0FnYVdZb0pHRmpkR2wyWlY5MFlYaHZibTl0ZVM1c1pXNW5kR2c5UFRFcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRZ1BTQWtZV04wYVhabFgzUmhlRzl1YjIxNU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdacFpXeGtWSGx3WlNBOUlDUm1hV1ZzWkM1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMTBlWEJsWENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lnS0NobWFXVnNaRlI1Y0dVZ1BUMGdYQ0owWVdkY0lpa2dmSHdnS0dacFpXeGtWSGx3WlNBOVBTQmNJbU5oZEdWbmIzSjVYQ0lwSUh4OElDaG1hV1ZzWkZSNWNHVWdQVDBnWENKMFlYaHZibTl0ZVZ3aUtTa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUmhlRzl1YjIxNVgzWmhiSFZsSUQwZ2MyVnNaaTV3Y205alpYTnpWR0Y0YjI1dmJYa29KR1pwWld4a0xDQjBjblZsS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnBaV3hrWDI1aGJXVWdQU0FrWm1sbGJHUXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0Ym1GdFpWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQjBZWGh2Ym05dGVWOXVZVzFsSUQwZ1ptbGxiR1JmYm1GdFpTNXlaWEJzWVdObEtGd2lYM05tZEY5Y0lpd2dYQ0pjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tIUmhlRzl1YjIxNVgzWmhiSFZsS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWm1sbGJHUmZkbUZzZFdVZ1BTQjBZWGh2Ym05dGVWOTJZV3gxWlM1MllXeDFaVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9abWxsYkdSZmRtRnNkV1U5UFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JtYVdWc1pDQTlJR1poYkhObE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWdvYzJWc1ppNWpkWEp5Wlc1MFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1VaFBWd2lYQ0lwSmlZb2MyVnNaaTVqZFhKeVpXNTBYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVWhQWFJoZUc5dWIyMTVYMjVoYldVcEtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVkR0Y0WDJGeVkyaHBkbVZmY21WemRXeDBjMTkxY213Z1BTQmpkWEp5Wlc1MFgzSmxjM1ZzZEhOZmRYSnNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200N1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWdvS0dacFpXeGtYM1poYkhWbFBUMWNJbHdpS1h4OEtDRWtabWxsYkdRcElDa3BYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FrWm05eWJTNGtabWxsYkdSekxtVmhZMmdvWm5WdVkzUnBiMjRnS0NrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDZ2hKR1pwWld4a0tTQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWFXVnNaRlI1Y0dVZ1BTQWtLSFJvYVhNcExtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMWFI1Y0dWY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNnb1ptbGxiR1JVZVhCbElEMDlJRndpZEdGblhDSXBJSHg4SUNobWFXVnNaRlI1Y0dVZ1BUMGdYQ0pqWVhSbFoyOXllVndpS1NCOGZDQW9abWxsYkdSVWVYQmxJRDA5SUZ3aWRHRjRiMjV2YlhsY0lpa3BJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUmhlRzl1YjIxNVgzWmhiSFZsSUQwZ2MyVnNaaTV3Y205alpYTnpWR0Y0YjI1dmJYa29KQ2gwYUdsektTd2dkSEoxWlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnBaV3hrWDI1aGJXVWdQU0FrS0hSb2FYTXBMbUYwZEhJb1hDSmtZWFJoTFhObUxXWnBaV3hrTFc1aGJXVmNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvZEdGNGIyNXZiWGxmZG1Gc2RXVXBJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JtYVdWc1pGOTJZV3gxWlNBOUlIUmhlRzl1YjIxNVgzWmhiSFZsTG5aaGJIVmxPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNobWFXVnNaRjkyWVd4MVpTQWhQU0JjSWx3aUtTQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbWFXVnNaQ0E5SUNRb2RHaHBjeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0NBb0pHWnBaV3hrS1NBbUppQW9abWxsYkdSZmRtRnNkV1VnSVQwZ1hDSmNJaUFwS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmFXWWdkMlVnWm05MWJtUWdZU0JtYVdWc1pGeHlYRzVjZEZ4MFhIUjJZWElnY21WM2NtbDBaVjloZEhSeUlEMGdLQ1JtYVdWc1pDNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxMFpYSnRMWEpsZDNKcGRHVmNJaWtwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jbVYzY21sMFpWOWhkSFJ5SVQxY0lsd2lLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGQzSnBkR1VnUFNCS1UwOU9MbkJoY25ObEtISmxkM0pwZEdWZllYUjBjaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdhVzV3ZFhSZmRIbHdaU0E5SUNSbWFXVnNaQzVoZEhSeUtGd2laR0YwWVMxelppMW1hV1ZzWkMxcGJuQjFkQzEwZVhCbFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhZM1JwZG1WZmRHRjRJRDBnWm1sbGJHUmZibUZ0WlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJacGJtUWdkR2hsSUdGamRHbDJaU0JsYkdWdFpXNTBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb0tHbHVjSFYwWDNSNWNHVWdQVDBnWENKeVlXUnBiMXdpS1NCOGZDQW9hVzV3ZFhSZmRIbHdaU0E5UFNCY0ltTm9aV05yWW05NFhDSXBLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRtRnlJQ1JoWTNScGRtVWdQU0FrWm1sbGJHUXVabWx1WkNoY0lpNXpaaTF2Y0hScGIyNHRZV04wYVhabFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZaWGh3Ykc5a1pTQjBhR1VnZG1Gc2RXVnpJR2xtSUhSb1pYSmxJR2x6SUdFZ1pHVnNhVzFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMlpwWld4a1gzWmhiSFZsWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnBjMTl6YVc1bmJHVmZkbUZzZFdVZ1BTQjBjblZsTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWFXVnNaRjkyWVd4MVpYTWdQU0JtYVdWc1pGOTJZV3gxWlM1emNHeHBkQ2hjSWl4Y0lpa3VhbTlwYmloY0lpdGNJaWt1YzNCc2FYUW9YQ0lyWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaG1hV1ZzWkY5MllXeDFaWE11YkdWdVozUm9JRDRnTVNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBjMTl6YVc1bmJHVmZkbUZzZFdVZ1BTQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaHBjMTl6YVc1bmJHVmZkbUZzZFdVcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWthVzV3ZFhRZ1BTQWtabWxsYkdRdVptbHVaQ2hjSW1sdWNIVjBXM1poYkhWbFBTZGNJaUFySUdacFpXeGtYM1poYkhWbElDc2dYQ0luWFZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSaFkzUnBkbVVnUFNBa2FXNXdkWFF1Y0dGeVpXNTBLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtaWEIwYUNBOUlDUmhZM1JwZG1VdVlYUjBjaWhjSW1SaGRHRXRjMll0WkdWd2RHaGNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMjV2ZHlCc2IyOXdJSFJvY205MVoyZ2djR0Z5Wlc1MGN5QjBieUJuY21GaUlIUm9aV2x5SUc1aGJXVnpYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMllXeDFaWE1nUFNCdVpYY2dRWEp5WVhrb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZzZFdWekxuQjFjMmdvWm1sbGJHUmZkbUZzZFdVcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWm05eUlDaDJZWElnYVNBOUlHUmxjSFJvT3lCcElENGdNRHNnYVMwdEtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1lXTjBhWFpsSUQwZ0pHRmpkR2wyWlM1d1lYSmxiblFvS1M1d1lYSmxiblFvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoYkhWbGN5NXdkWE5vS0NSaFkzUnBkbVV1Wm1sdVpDaGNJbWx1Y0hWMFhDSXBMblpoYkNncEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnNkV1Z6TG5KbGRtVnljMlVvS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2WjNKaFlpQjBhR1VnY21WM2NtbDBaU0JtYjNJZ2RHaHBjeUJrWlhCMGFGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWVdOMGFYWmxYM0psZDNKcGRHVWdQU0J5WlhkeWFYUmxXMlJsY0hSb1hUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhWeWJDQTlJR0ZqZEdsMlpWOXlaWGR5YVhSbE8xeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZkR2hsYmlCdFlYQWdabkp2YlNCMGFHVWdjR0Z5Wlc1MGN5QjBieUIwYUdVZ1pHVndkR2hjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkNoMllXeDFaWE1wTG1WaFkyZ29ablZ1WTNScGIyNGdLR2x1WkdWNExDQjJZV3gxWlNrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIVnliQ0E5SUhWeWJDNXlaWEJzWVdObEtGd2lXMXdpSUNzZ2FXNWtaWGdnS3lCY0lsMWNJaXdnZG1Gc2RXVXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWRHRjRYMkZ5WTJocGRtVmZjbVZ6ZFd4MGMxOTFjbXdnUFNCMWNtdzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXBaaUIwYUdWeVpTQmhjbVVnYlhWc2RHbHdiR1VnZG1Gc2RXVnpMRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNSb1pXNGdkMlVnYm1WbFpDQjBieUJqYUdWamF5Qm1iM0lnTXlCMGFHbHVaM002WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMmxtSUhSb1pTQjJZV3gxWlhNZ2MyVnNaV04wWldRZ1lYSmxJR0ZzYkNCcGJpQjBhR1VnYzJGdFpTQjBjbVZsSUhSb1pXNGdkMlVnWTJGdUlHUnZJSE52YldVZ1kyeGxkbVZ5SUhKbGQzSnBkR1VnYzNSMVptWmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl0WlhKblpTQmhiR3dnZG1Gc2RXVnpJR2x1SUhOaGJXVWdiR1YyWld3c0lIUm9aVzRnWTI5dFltbHVaU0IwYUdVZ2JHVjJaV3h6WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMmxtSUhSb1pYa2dZWEpsSUdaeWIyMGdaR2xtWm1WeVpXNTBJSFJ5WldWeklIUm9aVzRnYW5WemRDQmpiMjFpYVc1bElIUm9aVzBnYjNJZ2FuVnpkQ0IxYzJVZ1lHWnBaV3hrWDNaaGJIVmxZRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2S2x4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1pYQjBhSE1nUFNCdVpYY2dRWEp5WVhrb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1FvWm1sbGJHUmZkbUZzZFdWektTNWxZV05vS0daMWJtTjBhVzl1SUNocGJtUmxlQ3dnZG1Gc0tTQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JwYm5CMWRDQTlJQ1JtYVdWc1pDNW1hVzVrS0Z3aWFXNXdkWFJiZG1Gc2RXVTlKMXdpSUNzZ1ptbGxiR1JmZG1Gc2RXVWdLeUJjSWlkZFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmhZM1JwZG1VZ1BTQWthVzV3ZFhRdWNHRnlaVzUwS0NrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHUmxjSFJvSUQwZ0pHRmpkR2wyWlM1aGRIUnlLRndpWkdGMFlTMXpaaTFrWlhCMGFGd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dlpHVndkR2h6TG5CMWMyZ29aR1Z3ZEdncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE95b3ZYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZZ0tDaHBibkIxZEY5MGVYQmxJRDA5SUZ3aWMyVnNaV04wWENJcElIeDhJQ2hwYm5CMWRGOTBlWEJsSUQwOUlGd2liWFZzZEdselpXeGxZM1JjSWlrcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdselgzTnBibWRzWlY5MllXeDFaU0E5SUhSeWRXVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1pwWld4a1gzWmhiSFZsY3lBOUlHWnBaV3hrWDNaaGJIVmxMbk53YkdsMEtGd2lMRndpS1M1cWIybHVLRndpSzF3aUtTNXpjR3hwZENoY0lpdGNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0dacFpXeGtYM1poYkhWbGN5NXNaVzVuZEdnZ1BpQXhLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdselgzTnBibWRzWlY5MllXeDFaU0E5SUdaaGJITmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0dselgzTnBibWRzWlY5MllXeDFaU2tnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSaFkzUnBkbVVnUFNBa1ptbGxiR1F1Wm1sdVpDaGNJbTl3ZEdsdmJsdDJZV3gxWlQwblhDSWdLeUJtYVdWc1pGOTJZV3gxWlNBcklGd2lKMTFjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrWlhCMGFDQTlJQ1JoWTNScGRtVXVZWFIwY2loY0ltUmhkR0V0YzJZdFpHVndkR2hjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RtRnNkV1Z6SUQwZ2JtVjNJRUZ5Y21GNUtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoYkhWbGN5NXdkWE5vS0dacFpXeGtYM1poYkhWbEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdadmNpQW9kbUZ5SUdrZ1BTQmtaWEIwYURzZ2FTQStJREE3SUdrdExTa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHRmpkR2wyWlNBOUlDUmhZM1JwZG1VdWNISmxka0ZzYkNoY0ltOXdkR2x2Ymx0a1lYUmhMWE5tTFdSbGNIUm9QU2RjSWlBcklDaHBJQzBnTVNrZ0t5QmNJaWRkWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1Gc2RXVnpMbkIxYzJnb0pHRmpkR2wyWlM1MllXd29LU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoYkhWbGN5NXlaWFpsY25ObEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCaFkzUnBkbVZmY21WM2NtbDBaU0E5SUhKbGQzSnBkR1ZiWkdWd2RHaGRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RYSnNJRDBnWVdOMGFYWmxYM0psZDNKcGRHVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1FvZG1Gc2RXVnpLUzVsWVdOb0tHWjFibU4wYVc5dUlDaHBibVJsZUN3Z2RtRnNkV1VwSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMWNtd2dQU0IxY213dWNtVndiR0ZqWlNoY0lsdGNJaUFySUdsdVpHVjRJQ3NnWENKZFhDSXNJSFpoYkhWbEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG5SaGVGOWhjbU5vYVhabFgzSmxjM1ZzZEhOZmRYSnNJRDBnZFhKc08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUM4dmRHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJDQTlJR04xY25KbGJuUmZjbVZ6ZFd4MGMxOTFjbXc3WEhKY2JpQWdJQ0I5TEZ4eVhHNGdJQ0FnWjJWMFVtVnpkV3gwYzFWeWJEb2dablZ1WTNScGIyNG9KR1p2Y20wc0lHTjFjbkpsYm5SZmNtVnpkV3gwYzE5MWNtd3BJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdMeTkwYUdsekxuTmxkRlJoZUVGeVkyaHBkbVZTWlhOMWJIUnpWWEpzS0NSbWIzSnRMQ0JqZFhKeVpXNTBYM0psYzNWc2RITmZkWEpzS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnYVdZb2RHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJEMDlYQ0pjSWlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCamRYSnlaVzUwWDNKbGMzVnNkSE5mZFhKc08xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdjbVYwZFhKdUlIUm9hWE11ZEdGNFgyRnlZMmhwZG1WZmNtVnpkV3gwYzE5MWNtdzdYSEpjYmlBZ0lDQjlMRnh5WEc1Y2RHZGxkRlZ5YkZCaGNtRnRjem9nWm5WdVkzUnBiMjRvSkdadmNtMHBlMXh5WEc1Y2NseHVYSFJjZEhSb2FYTXVZblZwYkdSVmNteERiMjF3YjI1bGJuUnpLQ1JtYjNKdExDQjBjblZsS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnYVdZb2RHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJDRTlYQ0pjSWlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGFHbHpMbUZqZEdsMlpWOTBZWGdoUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWFXVnNaRjl1WVcxbElEMGdkR2hwY3k1aFkzUnBkbVZmZEdGNE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMblZ5YkY5d1lYSmhiWE5iWm1sbGJHUmZibUZ0WlYwcElUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSbGJHVjBaU0IwYUdsekxuVnliRjl3WVhKaGJYTmJabWxsYkdSZmJtRnRaVjA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNWNkRngwY21WMGRYSnVJSFJvYVhNdWRYSnNYM0JoY21GdGN6dGNjbHh1WEhSOUxGeHlYRzVjZEdOc1pXRnlWWEpzUTI5dGNHOXVaVzUwY3pvZ1puVnVZM1JwYjI0b0tYdGNjbHh1WEhSY2RDOHZkR2hwY3k1MWNteGZZMjl0Y0c5dVpXNTBjeUE5SUZ3aVhDSTdYSEpjYmx4MFhIUjBhR2x6TG5WeWJGOXdZWEpoYlhNZ1BTQjdmVHRjY2x4dVhIUjlMRnh5WEc1Y2RHTnNaV0Z5VkdGNFFYSmphR2wyWlZKbGMzVnNkSE5WY213NklHWjFibU4wYVc5dUtDa2dlMXh5WEc1Y2RGeDBkR2hwY3k1MFlYaGZZWEpqYUdsMlpWOXlaWE4xYkhSelgzVnliQ0E5SUNjbk8xeHlYRzVjZEgwc1hISmNibHgwWkdsellXSnNaVWx1Y0hWMGN6b2dablZ1WTNScGIyNG9KR1p2Y20wcGUxeHlYRzVjZEZ4MGRtRnlJSE5sYkdZZ1BTQjBhR2x6TzF4eVhHNWNkRngwWEhKY2JseDBYSFFrWm05eWJTNGtabWxsYkdSekxtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSFJjZEZ4MFhISmNibHgwWEhSY2RIWmhjaUFrYVc1d2RYUnpJRDBnSkNoMGFHbHpLUzVtYVc1a0tGd2lhVzV3ZFhRc0lITmxiR1ZqZEN3Z0xtMWxkR0V0YzJ4cFpHVnlYQ0lwTzF4eVhHNWNkRngwWEhRa2FXNXdkWFJ6TG1GMGRISW9YQ0prYVhOaFlteGxaRndpTENCY0ltUnBjMkZpYkdWa1hDSXBPMXh5WEc1Y2RGeDBYSFFrYVc1d2RYUnpMbUYwZEhJb1hDSmthWE5oWW14bFpGd2lMQ0IwY25WbEtUdGNjbHh1WEhSY2RGeDBKR2x1Y0hWMGN5NXdjbTl3S0Z3aVpHbHpZV0pzWldSY0lpd2dkSEoxWlNrN1hISmNibHgwWEhSY2RDUnBibkIxZEhNdWRISnBaMmRsY2loY0ltTm9iM05sYmpwMWNHUmhkR1ZrWENJcE8xeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RIMHBPMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUmNjbHh1WEhSOUxGeHlYRzVjZEdWdVlXSnNaVWx1Y0hWMGN6b2dablZ1WTNScGIyNG9KR1p2Y20wcGUxeHlYRzVjZEZ4MGRtRnlJSE5sYkdZZ1BTQjBhR2x6TzF4eVhHNWNkRngwSkdadmNtMHVKR1pwWld4a2N5NWxZV05vS0daMWJtTjBhVzl1S0NsN1hISmNibHgwWEhSY2RIWmhjaUFrYVc1d2RYUnpJRDBnSkNoMGFHbHpLUzVtYVc1a0tGd2lhVzV3ZFhRc0lITmxiR1ZqZEN3Z0xtMWxkR0V0YzJ4cFpHVnlYQ0lwTzF4eVhHNWNkRngwWEhRa2FXNXdkWFJ6TG5CeWIzQW9YQ0prYVhOaFlteGxaRndpTENCbVlXeHpaU2s3WEhKY2JseDBYSFJjZENScGJuQjFkSE11WVhSMGNpaGNJbVJwYzJGaWJHVmtYQ0lzSUdaaGJITmxLVHRjY2x4dVhIUmNkRngwSkdsdWNIVjBjeTUwY21sbloyVnlLRndpWTJodmMyVnVPblZ3WkdGMFpXUmNJaWs3WEhSY2RGeDBYSEpjYmx4MFhIUjlLVHRjY2x4dVhIUmNkRnh5WEc1Y2RGeDBYSEpjYmx4MGZTeGNjbHh1WEhSaWRXbHNaRlZ5YkVOdmJYQnZibVZ1ZEhNNklHWjFibU4wYVc5dUtDUm1iM0p0TENCamJHVmhjbDlqYjIxd2IyNWxiblJ6S1h0Y2NseHVYSFJjZEZ4eVhHNWNkRngwZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUnBaaWgwZVhCbGIyWW9ZMnhsWVhKZlkyOXRjRzl1Wlc1MGN5a2hQVndpZFc1a1pXWnBibVZrWENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHbG1LR05zWldGeVgyTnZiWEJ2Ym1WdWRITTlQWFJ5ZFdVcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFIwYUdsekxtTnNaV0Z5VlhKc1EyOXRjRzl1Wlc1MGN5Z3BPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFI5WEhKY2JseDBYSFJjY2x4dVhIUmNkQ1JtYjNKdExpUm1hV1ZzWkhNdVpXRmphQ2htZFc1amRHbHZiaWdwZTF4eVhHNWNkRngwWEhSY2NseHVYSFJjZEZ4MGRtRnlJR1pwWld4a1RtRnRaU0E5SUNRb2RHaHBjeWt1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGJtRnRaVndpS1R0Y2NseHVYSFJjZEZ4MGRtRnlJR1pwWld4a1ZIbHdaU0E5SUNRb2RHaHBjeWt1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGRIbHdaVndpS1R0Y2NseHVYSFJjZEZ4MFhISmNibHgwWEhSY2RHbG1LR1pwWld4a1ZIbHdaVDA5WENKelpXRnlZMmhjSWlsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkSE5sYkdZdWNISnZZMlZ6YzFObFlYSmphRVpwWld4a0tDUW9kR2hwY3lrcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9LR1pwWld4a1ZIbHdaVDA5WENKMFlXZGNJaWw4ZkNobWFXVnNaRlI1Y0dVOVBWd2lZMkYwWldkdmNubGNJaWw4ZkNobWFXVnNaRlI1Y0dVOVBWd2lkR0Y0YjI1dmJYbGNJaWtwWEhKY2JseDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUnpaV3htTG5CeWIyTmxjM05VWVhodmJtOXRlU2drS0hSb2FYTXBLVHRjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwWEhSbGJITmxJR2xtS0dacFpXeGtWSGx3WlQwOVhDSnpiM0owWDI5eVpHVnlYQ0lwWEhKY2JseDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUnpaV3htTG5CeWIyTmxjM05UYjNKMFQzSmtaWEpHYVdWc1pDZ2tLSFJvYVhNcEtUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObElHbG1LR1pwWld4a1ZIbHdaVDA5WENKd2IzTjBjMTl3WlhKZmNHRm5aVndpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBjMlZzWmk1d2NtOWpaWE56VW1WemRXeDBjMUJsY2xCaFoyVkdhV1ZzWkNna0tIUm9hWE1wS1R0Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmxiSE5sSUdsbUtHWnBaV3hrVkhsd1pUMDlYQ0poZFhSb2IzSmNJaWxjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RITmxiR1l1Y0hKdlkyVnpjMEYxZEdodmNpZ2tLSFJvYVhNcEtUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObElHbG1LR1pwWld4a1ZIbHdaVDA5WENKd2IzTjBYM1I1Y0dWY0lpbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhObGJHWXVjSEp2WTJWemMxQnZjM1JVZVhCbEtDUW9kR2hwY3lrcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9abWxsYkdSVWVYQmxQVDFjSW5CdmMzUmZaR0YwWlZ3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwYzJWc1ppNXdjbTlqWlhOelVHOXpkRVJoZEdVb0pDaDBhR2x6S1NrN1hISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RGeDBaV3h6WlNCcFppaG1hV1ZzWkZSNWNHVTlQVndpY0c5emRGOXRaWFJoWENJcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJ6Wld4bUxuQnliMk5sYzNOUWIzTjBUV1YwWVNna0tIUm9hWE1wS1R0Y2NseHVYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2NseHVYSFJjZEgwcE8xeHlYRzVjZEZ4MFhISmNibHgwZlN4Y2NseHVYSFJ3Y205alpYTnpVMlZoY21Ob1JtbGxiR1E2SUdaMWJtTjBhVzl1S0NSamIyNTBZV2x1WlhJcFhISmNibHgwZTF4eVhHNWNkRngwZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUjJZWElnSkdacFpXeGtJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpYVc1d2RYUmJibUZ0WlY0OUoxOXpabDl6WldGeVkyZ25YVndpS1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDR3S1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhSMllYSWdabWxsYkdST1lXMWxJRDBnSkdacFpXeGtMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHlYRzVjZEZ4MFhIUjJZWElnWm1sbGJHUldZV3dnUFNBa1ptbGxiR1F1ZG1Gc0tDazdYSEpjYmx4MFhIUmNkRnh5WEc1Y2RGeDBYSFJwWmlobWFXVnNaRlpoYkNFOVhDSmNJaWxjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RDOHZjMlZzWmk1MWNteGZZMjl0Y0c5dVpXNTBjeUFyUFNCY0lpWmZjMlpmY3oxY0lpdGxibU52WkdWVlVrbERiMjF3YjI1bGJuUW9abWxsYkdSV1lXd3BPMXh5WEc1Y2RGeDBYSFJjZEhObGJHWXVkWEpzWDNCaGNtRnRjMXNuWDNObVgzTW5YU0E5SUdWdVkyOWtaVlZTU1VOdmJYQnZibVZ1ZENobWFXVnNaRlpoYkNrN1hISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RIMWNjbHh1WEhSOUxGeHlYRzVjZEhCeWIyTmxjM05UYjNKMFQzSmtaWEpHYVdWc1pEb2dablZ1WTNScGIyNG9KR052Ym5SaGFXNWxjaWxjY2x4dVhIUjdYSEpjYmx4MFhIUjBhR2x6TG5CeWIyTmxjM05CZFhSb2IzSW9KR052Ym5SaGFXNWxjaWs3WEhKY2JseDBYSFJjY2x4dVhIUjlMRnh5WEc1Y2RIQnliMk5sYzNOU1pYTjFiSFJ6VUdWeVVHRm5aVVpwWld4a09pQm1kVzVqZEdsdmJpZ2tZMjl1ZEdGcGJtVnlLVnh5WEc1Y2RIdGNjbHh1WEhSY2RIUm9hWE11Y0hKdlkyVnpjMEYxZEdodmNpZ2tZMjl1ZEdGcGJtVnlLVHRjY2x4dVhIUmNkRnh5WEc1Y2RIMHNYSEpjYmx4MFoyVjBRV04wYVhabFZHRjRPaUJtZFc1amRHbHZiaWdrWm1sbGJHUXBJSHRjY2x4dVhIUmNkSEpsZEhWeWJpQjBhR2x6TG1GamRHbDJaVjkwWVhnN1hISmNibHgwZlN4Y2NseHVYSFJuWlhSVFpXeGxZM1JXWVd3NklHWjFibU4wYVc5dUtDUm1hV1ZzWkNsN1hISmNibHh5WEc1Y2RGeDBkbUZ5SUdacFpXeGtWbUZzSUQwZ1hDSmNJanRjY2x4dVhIUmNkRnh5WEc1Y2RGeDBhV1lvSkdacFpXeGtMblpoYkNncElUMHdLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFJtYVdWc1pGWmhiQ0E5SUNSbWFXVnNaQzUyWVd3b0tUdGNjbHh1WEhSY2RIMWNjbHh1WEhSY2RGeHlYRzVjZEZ4MGFXWW9abWxsYkdSV1lXdzlQVzUxYkd3cFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHWnBaV3hrVm1Gc0lEMGdYQ0pjSWp0Y2NseHVYSFJjZEgxY2NseHVYSFJjZEZ4eVhHNWNkRngwY21WMGRYSnVJR1pwWld4a1ZtRnNPMXh5WEc1Y2RIMHNYSEpjYmx4MFoyVjBUV1YwWVZObGJHVmpkRlpoYkRvZ1puVnVZM1JwYjI0b0pHWnBaV3hrS1h0Y2NseHVYSFJjZEZ4eVhHNWNkRngwZG1GeUlHWnBaV3hrVm1Gc0lEMGdYQ0pjSWp0Y2NseHVYSFJjZEZ4eVhHNWNkRngwWm1sbGJHUldZV3dnUFNBa1ptbGxiR1F1ZG1Gc0tDazdYSEpjYmx4MFhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MGFXWW9abWxsYkdSV1lXdzlQVzUxYkd3cFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHWnBaV3hrVm1Gc0lEMGdYQ0pjSWp0Y2NseHVYSFJjZEgxY2NseHVYSFJjZEZ4eVhHNWNkRngwY21WMGRYSnVJR1pwWld4a1ZtRnNPMXh5WEc1Y2RIMHNYSEpjYmx4MFoyVjBUWFZzZEdsVFpXeGxZM1JXWVd3NklHWjFibU4wYVc5dUtDUm1hV1ZzWkN3Z2IzQmxjbUYwYjNJcGUxeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdaR1ZzYVcwZ1BTQmNJaXRjSWp0Y2NseHVYSFJjZEdsbUtHOXdaWEpoZEc5eVBUMWNJbTl5WENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHUmxiR2x0SUQwZ1hDSXNYQ0k3WEhKY2JseDBYSFI5WEhKY2JseDBYSFJjY2x4dVhIUmNkR2xtS0hSNWNHVnZaaWdrWm1sbGJHUXVkbUZzS0NrcFBUMWNJbTlpYW1WamRGd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFJwWmlna1ptbGxiR1F1ZG1Gc0tDa2hQVzUxYkd3cFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJ5WlhSMWNtNGdKR1pwWld4a0xuWmhiQ2dwTG1wdmFXNG9aR1ZzYVcwcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUjlYSEpjYmx4MFhIUmNjbHh1WEhSOUxGeHlYRzVjZEdkbGRFMWxkR0ZOZFd4MGFWTmxiR1ZqZEZaaGJEb2dablZ1WTNScGIyNG9KR1pwWld4a0xDQnZjR1Z5WVhSdmNpbDdYSEpjYmx4MFhIUmNjbHh1WEhSY2RIWmhjaUJrWld4cGJTQTlJRndpTFNzdFhDSTdYSEpjYmx4MFhIUnBaaWh2Y0dWeVlYUnZjajA5WENKdmNsd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFJrWld4cGJTQTlJRndpTFN3dFhDSTdYSEpjYmx4MFhIUjlYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJwWmloMGVYQmxiMllvSkdacFpXeGtMblpoYkNncEtUMDlYQ0p2WW1wbFkzUmNJaWxjY2x4dVhIUmNkSHRjY2x4dVhIUmNkRngwYVdZb0pHWnBaV3hrTG5aaGJDZ3BJVDF1ZFd4c0tWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGRtRnlJR1pwWld4a2RtRnNJRDBnVzEwN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwSkNna1ptbGxiR1F1ZG1Gc0tDa3BMbVZoWTJnb1puVnVZM1JwYjI0b2FXNWtaWGdzZG1Gc2RXVXBlMXh5WEc1Y2RGeDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pIWmhiQzV3ZFhOb0tDaDJZV3gxWlNrcE8xeHlYRzVjZEZ4MFhIUmNkSDBwTzF4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkSEpsZEhWeWJpQm1hV1ZzWkhaaGJDNXFiMmx1S0dSbGJHbHRLVHRjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwZlZ4eVhHNWNkRngwWEhKY2JseDBYSFJ5WlhSMWNtNGdYQ0pjSWp0Y2NseHVYSFJjZEZ4eVhHNWNkSDBzWEhKY2JseDBaMlYwUTJobFkydGliM2hXWVd3NklHWjFibU4wYVc5dUtDUm1hV1ZzWkN3Z2IzQmxjbUYwYjNJcGUxeHlYRzVjZEZ4MFhISmNibHgwWEhSY2NseHVYSFJjZEhaaGNpQm1hV1ZzWkZaaGJDQTlJQ1JtYVdWc1pDNXRZWEFvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSFJjZEZ4MGFXWW9KQ2gwYUdsektTNXdjbTl3S0Z3aVkyaGxZMnRsWkZ3aUtUMDlkSEoxWlNsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkSEpsZEhWeWJpQWtLSFJvYVhNcExuWmhiQ2dwTzF4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSOUtTNW5aWFFvS1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwZG1GeUlHUmxiR2x0SUQwZ1hDSXJYQ0k3WEhKY2JseDBYSFJwWmlodmNHVnlZWFJ2Y2owOVhDSnZjbHdpS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhSa1pXeHBiU0E5SUZ3aUxGd2lPMXh5WEc1Y2RGeDBmVnh5WEc1Y2RGeDBYSEpjYmx4MFhIUnlaWFIxY200Z1ptbGxiR1JXWVd3dWFtOXBiaWhrWld4cGJTazdYSEpjYmx4MGZTeGNjbHh1WEhSblpYUk5aWFJoUTJobFkydGliM2hXWVd3NklHWjFibU4wYVc5dUtDUm1hV1ZzWkN3Z2IzQmxjbUYwYjNJcGUxeHlYRzVjZEZ4MFhISmNibHgwWEhSY2NseHVYSFJjZEhaaGNpQm1hV1ZzWkZaaGJDQTlJQ1JtYVdWc1pDNXRZWEFvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSFJjZEZ4MGFXWW9KQ2gwYUdsektTNXdjbTl3S0Z3aVkyaGxZMnRsWkZ3aUtUMDlkSEoxWlNsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkSEpsZEhWeWJpQW9KQ2gwYUdsektTNTJZV3dvS1NrN1hISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RIMHBMbWRsZENncE8xeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdaR1ZzYVcwZ1BTQmNJaTByTFZ3aU8xeHlYRzVjZEZ4MGFXWW9iM0JsY21GMGIzSTlQVndpYjNKY0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBaR1ZzYVcwZ1BTQmNJaTBzTFZ3aU8xeHlYRzVjZEZ4MGZWeHlYRzVjZEZ4MFhISmNibHgwWEhSeVpYUjFjbTRnWm1sbGJHUldZV3d1YW05cGJpaGtaV3hwYlNrN1hISmNibHgwZlN4Y2NseHVYSFJuWlhSU1lXUnBiMVpoYkRvZ1puVnVZM1JwYjI0b0pHWnBaV3hrS1h0Y2NseHVYSFJjZEZ4MFhIUmNkRngwWEhSY2NseHVYSFJjZEhaaGNpQm1hV1ZzWkZaaGJDQTlJQ1JtYVdWc1pDNXRZWEFvWm5WdVkzUnBiMjRvS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhScFppZ2tLSFJvYVhNcExuQnliM0FvWENKamFHVmphMlZrWENJcFBUMTBjblZsS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBjbVYwZFhKdUlDUW9kR2hwY3lrdWRtRnNLQ2s3WEhKY2JseDBYSFJjZEgxY2NseHVYSFJjZEZ4MFhISmNibHgwWEhSOUtTNW5aWFFvS1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwWEhKY2JseDBYSFJwWmlobWFXVnNaRlpoYkZzd1hTRTlNQ2xjY2x4dVhIUmNkSHRjY2x4dVhIUmNkRngwY21WMGRYSnVJR1pwWld4a1ZtRnNXekJkTzF4eVhHNWNkRngwZlZ4eVhHNWNkSDBzWEhKY2JseDBaMlYwVFdWMFlWSmhaR2x2Vm1Gc09pQm1kVzVqZEdsdmJpZ2tabWxsYkdRcGUxeHlYRzVjZEZ4MFhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZtRnNJRDBnSkdacFpXeGtMbTFoY0NobWRXNWpkR2x2YmlncFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHbG1LQ1FvZEdocGN5a3VjSEp2Y0NoY0ltTm9aV05yWldSY0lpazlQWFJ5ZFdVcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJ5WlhSMWNtNGdKQ2gwYUdsektTNTJZV3dvS1R0Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RIMHBMbWRsZENncE8xeHlYRzVjZEZ4MFhISmNibHgwWEhSeVpYUjFjbTRnWm1sbGJHUldZV3hiTUYwN1hISmNibHgwZlN4Y2NseHVYSFJ3Y205alpYTnpRWFYwYUc5eU9pQm1kVzVqZEdsdmJpZ2tZMjl1ZEdGcGJtVnlLVnh5WEc1Y2RIdGNjbHh1WEhSY2RIWmhjaUJ6Wld4bUlEMGdkR2hwY3p0Y2NseHVYSFJjZEZ4eVhHNWNkRngwWEhKY2JseDBYSFIyWVhJZ1ptbGxiR1JVZVhCbElEMGdKR052Ym5SaGFXNWxjaTVoZEhSeUtGd2laR0YwWVMxelppMW1hV1ZzWkMxMGVYQmxYQ0lwTzF4eVhHNWNkRngwZG1GeUlHbHVjSFYwVkhsd1pTQTlJQ1JqYjI1MFlXbHVaWEl1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGFXNXdkWFF0ZEhsd1pWd2lLVHRjY2x4dVhIUmNkRnh5WEc1Y2RGeDBkbUZ5SUNSbWFXVnNaRHRjY2x4dVhIUmNkSFpoY2lCbWFXVnNaRTVoYldVZ1BTQmNJbHdpTzF4eVhHNWNkRngwZG1GeUlHWnBaV3hrVm1Gc0lEMGdYQ0pjSWp0Y2NseHVYSFJjZEZ4eVhHNWNkRngwYVdZb2FXNXdkWFJVZVhCbFBUMWNJbk5sYkdWamRGd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFFrWm1sbGJHUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0p6Wld4bFkzUmNJaWs3WEhKY2JseDBYSFJjZEdacFpXeGtUbUZ0WlNBOUlDUm1hV1ZzWkM1aGRIUnlLRndpYm1GdFpWd2lLUzV5WlhCc1lXTmxLQ2RiWFNjc0lDY25LVHRjY2x4dVhIUmNkRngwWEhKY2JseDBYSFJjZEdacFpXeGtWbUZzSUQwZ2MyVnNaaTVuWlhSVFpXeGxZM1JXWVd3b0pHWnBaV3hrS1RzZ1hISmNibHgwWEhSOVhISmNibHgwWEhSbGJITmxJR2xtS0dsdWNIVjBWSGx3WlQwOVhDSnRkV3gwYVhObGJHVmpkRndpS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhRa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENKelpXeGxZM1JjSWlrN1hISmNibHgwWEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2NseHVYSFJjZEZ4MGRtRnlJRzl3WlhKaGRHOXlJRDBnSkdacFpXeGtMbUYwZEhJb1hDSmtZWFJoTFc5d1pYSmhkRzl5WENJcE8xeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RGeDBabWxsYkdSV1lXd2dQU0J6Wld4bUxtZGxkRTExYkhScFUyVnNaV04wVm1Gc0tDUm1hV1ZzWkN3Z1hDSnZjbHdpS1R0Y2NseHVYSFJjZEZ4MFhISmNibHgwWEhSOVhISmNibHgwWEhSbGJITmxJR2xtS0dsdWNIVjBWSGx3WlQwOVhDSmphR1ZqYTJKdmVGd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFFrWm1sbGJHUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0oxYkNBK0lHeHBJR2x1Y0hWME9tTm9aV05yWW05NFhDSXBPMXh5WEc1Y2RGeDBYSFJjY2x4dVhIUmNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDR3S1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBabWxsYkdST1lXMWxJRDBnSkdacFpXeGtMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHlYRzVjZEZ4MFhIUmNkRngwWEhSY2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RIWmhjaUJ2Y0dWeVlYUnZjaUE5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSWo0Z2RXeGNJaWt1WVhSMGNpaGNJbVJoZEdFdGIzQmxjbUYwYjNKY0lpazdYSEpjYmx4MFhIUmNkRngwWm1sbGJHUldZV3dnUFNCelpXeG1MbWRsZEVOb1pXTnJZbTk0Vm1Gc0tDUm1hV1ZzWkN3Z1hDSnZjbHdpS1R0Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RIMWNjbHh1WEhSY2RHVnNjMlVnYVdZb2FXNXdkWFJVZVhCbFBUMWNJbkpoWkdsdlhDSXBYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkRnh5WEc1Y2RGeDBYSFFrWm1sbGJHUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0oxYkNBK0lHeHBJR2x1Y0hWME9uSmhaR2x2WENJcE8xeHlYRzVjZEZ4MFhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQ0d0tWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWm1sbGJHUk9ZVzFsSUQwZ0pHWnBaV3hrTG1GMGRISW9YQ0p1WVcxbFhDSXBMbkpsY0d4aFkyVW9KMXRkSnl3Z0p5Y3BPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUlNZV1JwYjFaaGJDZ2tabWxsYkdRcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUjlYSEpjYmx4MFhIUmNjbHh1WEhSY2RHbG1LSFI1Y0dWdlppaG1hV1ZzWkZaaGJDa2hQVndpZFc1a1pXWnBibVZrWENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHbG1LR1pwWld4a1ZtRnNJVDFjSWx3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwZG1GeUlHWnBaV3hrVTJ4MVp5QTlJRndpWENJN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwYVdZb1ptbGxiR1JPWVcxbFBUMWNJbDl6Wmw5aGRYUm9iM0pjSWlsY2NseHVYSFJjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWEhSbWFXVnNaRk5zZFdjZ1BTQmNJbUYxZEdodmNuTmNJanRjY2x4dVhIUmNkRngwWEhSOVhISmNibHgwWEhSY2RGeDBaV3h6WlNCcFppaG1hV1ZzWkU1aGJXVTlQVndpWDNObVgzTnZjblJmYjNKa1pYSmNJaWxjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pGTnNkV2NnUFNCY0luTnZjblJmYjNKa1pYSmNJanRjY2x4dVhIUmNkRngwWEhSOVhISmNibHgwWEhSY2RGeDBaV3h6WlNCcFppaG1hV1ZzWkU1aGJXVTlQVndpWDNObVgzQndjRndpS1Z4eVhHNWNkRngwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjZEdacFpXeGtVMngxWnlBOUlGd2lYM05tWDNCd2NGd2lPMXh5WEc1Y2RGeDBYSFJjZEgxY2NseHVYSFJjZEZ4MFhIUmxiSE5sSUdsbUtHWnBaV3hrVG1GdFpUMDlYQ0pmYzJaZmNHOXpkRjkwZVhCbFhDSXBYSEpjYmx4MFhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RGeDBabWxsYkdSVGJIVm5JRDBnWENKd2IzTjBYM1I1Y0dWelhDSTdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2RHVnNjMlZjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkR2xtS0dacFpXeGtVMngxWnlFOVhDSmNJaWxjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFF2TDNObGJHWXVkWEpzWDJOdmJYQnZibVZ1ZEhNZ0t6MGdYQ0ltWENJclptbGxiR1JUYkhWbksxd2lQVndpSzJacFpXeGtWbUZzTzF4eVhHNWNkRngwWEhSY2RGeDBjMlZzWmk1MWNteGZjR0Z5WVcxelcyWnBaV3hrVTJ4MVoxMGdQU0JtYVdWc1pGWmhiRHRjY2x4dVhIUmNkRngwWEhSOVhISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RIMWNjbHh1WEhSY2RGeHlYRzVjZEgwc1hISmNibHgwY0hKdlkyVnpjMUJ2YzNSVWVYQmxJRG9nWm5WdVkzUnBiMjRvSkhSb2FYTXBlMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUjBhR2x6TG5CeWIyTmxjM05CZFhSb2IzSW9KSFJvYVhNcE8xeHlYRzVjZEZ4MFhISmNibHgwZlN4Y2NseHVYSFJ3Y205alpYTnpVRzl6ZEUxbGRHRTZJR1oxYm1OMGFXOXVLQ1JqYjI1MFlXbHVaWElwWEhKY2JseDBlMXh5WEc1Y2RGeDBkbUZ5SUhObGJHWWdQU0IwYUdsek8xeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdabWxsYkdSVWVYQmxJRDBnSkdOdmJuUmhhVzVsY2k1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMTBlWEJsWENJcE8xeHlYRzVjZEZ4MGRtRnlJR2x1Y0hWMFZIbHdaU0E5SUNSamIyNTBZV2x1WlhJdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRhVzV3ZFhRdGRIbHdaVndpS1R0Y2NseHVYSFJjZEhaaGNpQnRaWFJoVkhsd1pTQTlJQ1JqYjI1MFlXbHVaWEl1WVhSMGNpaGNJbVJoZEdFdGMyWXRiV1YwWVMxMGVYQmxYQ0lwTzF4eVhHNWNjbHh1WEhSY2RIWmhjaUJtYVdWc1pGWmhiQ0E5SUZ3aVhDSTdYSEpjYmx4MFhIUjJZWElnSkdacFpXeGtPMXh5WEc1Y2RGeDBkbUZ5SUdacFpXeGtUbUZ0WlNBOUlGd2lYQ0k3WEhKY2JseDBYSFJjY2x4dVhIUmNkR2xtS0cxbGRHRlVlWEJsUFQxY0ltNTFiV0psY2x3aUtWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUnBaaWhwYm5CMWRGUjVjR1U5UFZ3aWNtRnVaMlV0Ym5WdFltVnlYQ0lwWEhKY2JseDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUWtabWxsYkdRZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSXVjMll0YldWMFlTMXlZVzVuWlMxdWRXMWlaWElnYVc1d2RYUmNJaWs3WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBkbUZ5SUhaaGJIVmxjeUE5SUZ0ZE8xeHlYRzVjZEZ4MFhIUmNkQ1JtYVdWc1pDNWxZV05vS0daMWJtTjBhVzl1S0NsN1hISmNibHgwWEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSY2RIWmhiSFZsY3k1d2RYTm9LQ1FvZEdocGN5a3VkbUZzS0NrcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEgwcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEdacFpXeGtWbUZzSUQwZ2RtRnNkV1Z6TG1wdmFXNG9YQ0lyWENJcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEdWc2MyVWdhV1lvYVc1d2RYUlVlWEJsUFQxY0luSmhibWRsTFhOc2FXUmxjbHdpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2lMbk5tTFcxbGRHRXRjbUZ1WjJVdGMyeHBaR1Z5SUdsdWNIVjBYQ0lwTzF4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkQzh2WjJWMElHRnVlU0J1ZFcxaVpYSWdabTl5YldGMGRHbHVaeUJ6ZEhWbVpseHlYRzVjZEZ4MFhIUmNkSFpoY2lBa2JXVjBZVjl5WVc1blpTQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJaTV6WmkxdFpYUmhMWEpoYm1kbExYTnNhV1JsY2x3aUtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSMllYSWdaR1ZqYVcxaGJGOXdiR0ZqWlhNZ1BTQWtiV1YwWVY5eVlXNW5aUzVoZEhSeUtGd2laR0YwWVMxa1pXTnBiV0ZzTFhCc1lXTmxjMXdpS1R0Y2NseHVYSFJjZEZ4MFhIUjJZWElnZEdodmRYTmhibVJmYzJWd1pYSmhkRzl5SUQwZ0pHMWxkR0ZmY21GdVoyVXVZWFIwY2loY0ltUmhkR0V0ZEdodmRYTmhibVF0YzJWd1pYSmhkRzl5WENJcE8xeHlYRzVjZEZ4MFhIUmNkSFpoY2lCa1pXTnBiV0ZzWDNObGNHVnlZWFJ2Y2lBOUlDUnRaWFJoWDNKaGJtZGxMbUYwZEhJb1hDSmtZWFJoTFdSbFkybHRZV3d0YzJWd1pYSmhkRzl5WENJcE8xeHlYRzVjY2x4dVhIUmNkRngwWEhSMllYSWdabWxsYkdSZlptOXliV0YwSUQwZ2QwNTFiV0lvZTF4eVhHNWNkRngwWEhSY2RGeDBiV0Z5YXpvZ1pHVmphVzFoYkY5elpYQmxjbUYwYjNJc1hISmNibHgwWEhSY2RGeDBYSFJrWldOcGJXRnNjem9nY0dGeWMyVkdiRzloZENoa1pXTnBiV0ZzWDNCc1lXTmxjeWtzWEhKY2JseDBYSFJjZEZ4MFhIUjBhRzkxYzJGdVpEb2dkR2h2ZFhOaGJtUmZjMlZ3WlhKaGRHOXlYSEpjYmx4MFhIUmNkRngwZlNrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwZG1GeUlIWmhiSFZsY3lBOUlGdGRPMXh5WEc1Y2NseHVYSEpjYmx4MFhIUmNkRngwZG1GeUlITnNhV1JsY2w5dlltcGxZM1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENJdWJXVjBZUzF6Ykdsa1pYSmNJaWxiTUYwN1hISmNibHgwWEhSY2RGeDBMeTkyWVd3Z1puSnZiU0J6Ykdsa1pYSWdiMkpxWldOMFhISmNibHgwWEhSY2RGeDBkbUZ5SUhOc2FXUmxjbDkyWVd3Z1BTQnpiR2xrWlhKZmIySnFaV04wTG01dlZXbFRiR2xrWlhJdVoyVjBLQ2s3WEhKY2JseHlYRzVjZEZ4MFhIUmNkSFpoYkhWbGN5NXdkWE5vS0dacFpXeGtYMlp2Y20xaGRDNW1jbTl0S0hOc2FXUmxjbDkyWVd4Yk1GMHBLVHRjY2x4dVhIUmNkRngwWEhSMllXeDFaWE11Y0hWemFDaG1hV1ZzWkY5bWIzSnRZWFF1Wm5KdmJTaHpiR2xrWlhKZmRtRnNXekZkS1NrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwWm1sbGJHUldZV3dnUFNCMllXeDFaWE11YW05cGJpaGNJaXRjSWlrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwWm1sbGJHUk9ZVzFsSUQwZ0pHMWxkR0ZmY21GdVoyVXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0Ym1GdFpWd2lLVHRjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObElHbG1LR2x1Y0hWMFZIbHdaVDA5WENKeVlXNW5aUzF5WVdScGIxd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MEpHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aUxuTm1MV2x1Y0hWMExYSmhibWRsTFhKaFpHbHZYQ0lwTzF4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkR2xtS0NSbWFXVnNaQzVzWlc1bmRHZzlQVEFwWEhKY2JseDBYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkRngwTHk5MGFHVnVJSFJ5ZVNCaFoyRnBiaXdnZDJVZ2JYVnpkQ0JpWlNCMWMybHVaeUJoSUhOcGJtZHNaU0JtYVdWc1pGeHlYRzVjZEZ4MFhIUmNkRngwSkdacFpXeGtJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpUGlCMWJGd2lLVHRjY2x4dVhIUmNkRngwWEhSOVhISmNibHh5WEc1Y2RGeDBYSFJjZEhaaGNpQWtiV1YwWVY5eVlXNW5aU0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSWk1elppMXRaWFJoTFhKaGJtZGxYQ0lwTzF4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkQzh2ZEdobGNtVWdhWE1nWVc0Z1pXeGxiV1Z1ZENCM2FYUm9JR0VnWm5KdmJTOTBieUJqYkdGemN5QXRJSE52SUhkbElHNWxaV1FnZEc4Z1oyVjBJSFJvWlNCMllXeDFaWE1nYjJZZ2RHaGxJR1p5YjIwZ0ppQjBieUJwYm5CMWRDQm1hV1ZzWkhNZ2MyVndaWEpoZEdWc2VWeHlYRzVjZEZ4MFhIUmNkR2xtS0NSbWFXVnNaQzVzWlc1bmRHZytNQ2xjY2x4dVhIUmNkRngwWEhSN1hIUmNjbHh1WEhSY2RGeDBYSFJjZEhaaGNpQm1hV1ZzWkY5MllXeHpJRDBnVzEwN1hISmNibHgwWEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSY2RDUm1hV1ZzWkM1bFlXTm9LR1oxYm1OMGFXOXVLQ2w3WEhKY2JseDBYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEZ4MFhIUjJZWElnSkhKaFpHbHZjeUE5SUNRb2RHaHBjeWt1Wm1sdVpDaGNJaTV6WmkxcGJuQjFkQzF5WVdScGIxd2lLVHRjY2x4dVhIUmNkRngwWEhSY2RGeDBabWxsYkdSZmRtRnNjeTV3ZFhOb0tITmxiR1l1WjJWMFRXVjBZVkpoWkdsdlZtRnNLQ1J5WVdScGIzTXBLVHRjY2x4dVhIUmNkRngwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwWEhSOUtUdGNjbHh1WEhSY2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RGeDBMeTl3Y21WMlpXNTBJSE5sWTI5dVpDQnVkVzFpWlhJZ1puSnZiU0JpWldsdVp5QnNiM2RsY2lCMGFHRnVJSFJvWlNCbWFYSnpkRnh5WEc1Y2RGeDBYSFJjZEZ4MGFXWW9abWxsYkdSZmRtRnNjeTVzWlc1bmRHZzlQVElwWEhKY2JseDBYSFJjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWEhSY2RHbG1LRTUxYldKbGNpaG1hV1ZzWkY5MllXeHpXekZkS1R4T2RXMWlaWElvWm1sbGJHUmZkbUZzYzFzd1hTa3BYSEpjYmx4MFhIUmNkRngwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjZEZ4MFhIUm1hV1ZzWkY5MllXeHpXekZkSUQwZ1ptbGxiR1JmZG1Gc2Mxc3dYVHRjY2x4dVhIUmNkRngwWEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJR1pwWld4a1gzWmhiSE11YW05cGJpaGNJaXRjSWlrN1hISmNibHgwWEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJjZEZ4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQwOU1TbGNjbHh1WEhSY2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkU1aGJXVWdQU0FrWm1sbGJHUXVabWx1WkNoY0lpNXpaaTFwYm5CMWRDMXlZV1JwYjF3aUtTNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2NseHVYSFJjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkRngwWld4elpWeHlYRzVjZEZ4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1J0WlhSaFgzSmhibWRsTG1GMGRISW9YQ0prWVhSaExYTm1MV1pwWld4a0xXNWhiV1ZjSWlrN1hISmNibHgwWEhSY2RGeDBmVnh5WEc1Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmxiSE5sSUdsbUtHbHVjSFYwVkhsd1pUMDlYQ0p5WVc1blpTMXpaV3hsWTNSY0lpbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSWk1elppMXBibkIxZEMxelpXeGxZM1JjSWlrN1hISmNibHgwWEhSY2RGeDBkbUZ5SUNSdFpYUmhYM0poYm1kbElEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2lMbk5tTFcxbGRHRXRjbUZ1WjJWY0lpazdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MEx5OTBhR1Z5WlNCcGN5QmhiaUJsYkdWdFpXNTBJSGRwZEdnZ1lTQm1jbTl0TDNSdklHTnNZWE56SUMwZ2MyOGdkMlVnYm1WbFpDQjBieUJuWlhRZ2RHaGxJSFpoYkhWbGN5QnZaaUIwYUdVZ1puSnZiU0FtSUhSdklHbHVjSFYwSUdacFpXeGtjeUJ6WlhCbGNtRjBaV3g1WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBhV1lvSkdacFpXeGtMbXhsYm1kMGFENHdLVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkSFpoY2lCbWFXVnNaRjkyWVd4eklEMGdXMTA3WEhKY2JseDBYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBYSFJjZENSbWFXVnNaQzVsWVdOb0tHWjFibU4wYVc5dUtDbDdYSEpjYmx4MFhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkRngwWEhSMllYSWdKSFJvYVhNZ1BTQWtLSFJvYVhNcE8xeHlYRzVjZEZ4MFhIUmNkRngwWEhSbWFXVnNaRjkyWVd4ekxuQjFjMmdvYzJWc1ppNW5aWFJOWlhSaFUyVnNaV04wVm1Gc0tDUjBhR2x6S1NrN1hISmNibHgwWEhSY2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RGeDBmU2s3WEhKY2JseDBYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBYSFJjZEM4dmNISmxkbVZ1ZENCelpXTnZibVFnYm5WdFltVnlJR1p5YjIwZ1ltVnBibWNnYkc5M1pYSWdkR2hoYmlCMGFHVWdabWx5YzNSY2NseHVYSFJjZEZ4MFhIUmNkR2xtS0dacFpXeGtYM1poYkhNdWJHVnVaM1JvUFQweUtWeHlYRzVjZEZ4MFhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RGeDBYSFJwWmloT2RXMWlaWElvWm1sbGJHUmZkbUZzYzFzeFhTazhUblZ0WW1WeUtHWnBaV3hrWDNaaGJITmJNRjBwS1Z4eVhHNWNkRngwWEhSY2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFhIUmNkRngwWm1sbGJHUmZkbUZzYzFzeFhTQTlJR1pwWld4a1gzWmhiSE5iTUYwN1hISmNibHgwWEhSY2RGeDBYSFJjZEgxY2NseHVYSFJjZEZ4MFhIUmNkSDFjY2x4dVhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJR1pwWld4a1gzWmhiSE11YW05cGJpaGNJaXRjSWlrN1hISmNibHgwWEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJjZEZ4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQwOU1TbGNjbHh1WEhSY2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkU1aGJXVWdQU0FrWm1sbGJHUXVZWFIwY2loY0ltNWhiV1ZjSWlrdWNtVndiR0ZqWlNnblcxMG5MQ0FuSnlrN1hISmNibHgwWEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJjZEdWc2MyVmNjbHh1WEhSY2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkU1aGJXVWdQU0FrYldWMFlWOXlZVzVuWlM1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMXVZVzFsWENJcE8xeHlYRzVjZEZ4MFhIUmNkSDFjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmxiSE5sSUdsbUtHbHVjSFYwVkhsd1pUMDlYQ0p5WVc1blpTMWphR1ZqYTJKdmVGd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MEpHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aWRXd2dQaUJzYVNCcGJuQjFkRHBqYUdWamEySnZlRndpS1R0Y2NseHVYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBYSFJwWmlna1ptbGxiR1F1YkdWdVozUm9QakFwWEhKY2JseDBYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkRngwWm1sbGJHUldZV3dnUFNCelpXeG1MbWRsZEVOb1pXTnJZbTk0Vm1Gc0tDUm1hV1ZzWkN3Z1hDSmhibVJjSWlrN1hISmNibHgwWEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEZ4eVhHNWNkRngwWEhScFppaG1hV1ZzWkU1aGJXVTlQVndpWENJcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbTVoYldWY0lpa3VjbVZ3YkdGalpTZ25XMTBuTENBbkp5azdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkSDFjY2x4dVhIUmNkR1ZzYzJVZ2FXWW9iV1YwWVZSNWNHVTlQVndpWTJodmFXTmxYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEdsbUtHbHVjSFYwVkhsd1pUMDlYQ0p6Wld4bFkzUmNJaWxjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0luTmxiR1ZqZEZ3aUtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlITmxiR1l1WjJWMFRXVjBZVk5sYkdWamRGWmhiQ2drWm1sbGJHUXBPeUJjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmxiSE5sSUdsbUtHbHVjSFYwVkhsd1pUMDlYQ0p0ZFd4MGFYTmxiR1ZqZEZ3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwSkdacFpXeGtJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpYzJWc1pXTjBYQ0lwTzF4eVhHNWNkRngwWEhSY2RIWmhjaUJ2Y0dWeVlYUnZjaUE5SUNSbWFXVnNaQzVoZEhSeUtGd2laR0YwWVMxdmNHVnlZWFJ2Y2x3aUtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlITmxiR1l1WjJWMFRXVjBZVTExYkhScFUyVnNaV04wVm1Gc0tDUm1hV1ZzWkN3Z2IzQmxjbUYwYjNJcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9hVzV3ZFhSVWVYQmxQVDFjSW1Ob1pXTnJZbTk0WENJcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFFrWm1sbGJHUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0oxYkNBK0lHeHBJR2x1Y0hWME9tTm9aV05yWW05NFhDSXBPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RHbG1LQ1JtYVdWc1pDNXNaVzVuZEdnK01DbGNjbHh1WEhSY2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFhIUjJZWElnYjNCbGNtRjBiM0lnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENJK0lIVnNYQ0lwTG1GMGRISW9YQ0prWVhSaExXOXdaWEpoZEc5eVhDSXBPMXh5WEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQnpaV3htTG1kbGRFMWxkR0ZEYUdWamEySnZlRlpoYkNna1ptbGxiR1FzSUc5d1pYSmhkRzl5S1R0Y2NseHVYSFJjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkRngwWld4elpTQnBaaWhwYm5CMWRGUjVjR1U5UFZ3aWNtRmthVzljSWlsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkQ1JtYVdWc1pDQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJblZzSUQ0Z2JHa2dhVzV3ZFhRNmNtRmthVzljSWlrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDR3S1Z4eVhHNWNkRngwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjZEdacFpXeGtWbUZzSUQwZ2MyVnNaaTVuWlhSTlpYUmhVbUZrYVc5V1lXd29KR1pwWld4a0tUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEgxY2NseHVYSFJjZEZ4MFhISmNibHgwWEhSY2RHWnBaV3hrVm1Gc0lEMGdaVzVqYjJSbFZWSkpRMjl0Y0c5dVpXNTBLR1pwWld4a1ZtRnNLVHRjY2x4dVhIUmNkRngwYVdZb2RIbHdaVzltS0NSbWFXVnNaQ2toUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQ0d0tWeHlYRzVjZEZ4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2NseHVYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEZ4MEx5OW1iM0lnZEdodmMyVWdkMmh2SUdsdWMybHpkQ0J2YmlCMWMybHVaeUFtSUdGdGNHVnljMkZ1WkhNZ2FXNGdkR2hsSUc1aGJXVWdiMllnZEdobElHTjFjM1J2YlNCbWFXVnNaQ0FvSVNsY2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1RtRnRaU0E5SUNobWFXVnNaRTVoYldVcE8xeHlYRzVjZEZ4MFhIUmNkSDFjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2NseHVYSFJjZEgxY2NseHVYSFJjZEdWc2MyVWdhV1lvYldWMFlWUjVjR1U5UFZ3aVpHRjBaVndpS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhSelpXeG1MbkJ5YjJObGMzTlFiM04wUkdGMFpTZ2tZMjl1ZEdGcGJtVnlLVHRjY2x4dVhIUmNkSDFjY2x4dVhIUmNkRnh5WEc1Y2RGeDBhV1lvZEhsd1pXOW1LR1pwWld4a1ZtRnNLU0U5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBhV1lvWm1sbGJHUldZV3doUFZ3aVhDSXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhRdkwzTmxiR1l1ZFhKc1gyTnZiWEJ2Ym1WdWRITWdLejBnWENJbVhDSXJaVzVqYjJSbFZWSkpRMjl0Y0c5dVpXNTBLR1pwWld4a1RtRnRaU2tyWENJOVhDSXJLR1pwWld4a1ZtRnNLVHRjY2x4dVhIUmNkRngwWEhSelpXeG1MblZ5YkY5d1lYSmhiWE5iWlc1amIyUmxWVkpKUTI5dGNHOXVaVzUwS0dacFpXeGtUbUZ0WlNsZElEMGdLR1pwWld4a1ZtRnNLVHRjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwZlZ4eVhHNWNkSDBzWEhKY2JseDBjSEp2WTJWemMxQnZjM1JFWVhSbE9pQm1kVzVqZEdsdmJpZ2tZMjl1ZEdGcGJtVnlLVnh5WEc1Y2RIdGNjbHh1WEhSY2RIWmhjaUJ6Wld4bUlEMGdkR2hwY3p0Y2NseHVYSFJjZEZ4eVhHNWNkRngwZG1GeUlHWnBaV3hrVkhsd1pTQTlJQ1JqYjI1MFlXbHVaWEl1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGRIbHdaVndpS1R0Y2NseHVYSFJjZEhaaGNpQnBibkIxZEZSNWNHVWdQU0FrWTI5dWRHRnBibVZ5TG1GMGRISW9YQ0prWVhSaExYTm1MV1pwWld4a0xXbHVjSFYwTFhSNWNHVmNJaWs3WEhKY2JseDBYSFJjY2x4dVhIUmNkSFpoY2lBa1ptbGxiR1E3WEhKY2JseDBYSFIyWVhJZ1ptbGxiR1JPWVcxbElEMGdYQ0pjSWp0Y2NseHVYSFJjZEhaaGNpQm1hV1ZzWkZaaGJDQTlJRndpWENJN1hISmNibHgwWEhSY2NseHVYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5Wc0lENGdiR2tnYVc1d2RYUTZkR1Y0ZEZ3aUtUdGNjbHh1WEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwZG1GeUlHUmhkR1Z6SUQwZ1cxMDdYSEpjYmx4MFhIUWtabWxsYkdRdVpXRmphQ2htZFc1amRHbHZiaWdwZTF4eVhHNWNkRngwWEhSY2NseHVYSFJjZEZ4MFpHRjBaWE11Y0hWemFDZ2tLSFJvYVhNcExuWmhiQ2dwS1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwZlNrN1hISmNibHgwWEhSY2NseHVYSFJjZEdsbUtDUm1hV1ZzWkM1c1pXNW5kR2c5UFRJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHbG1LQ2hrWVhSbGMxc3dYU0U5WENKY0lpbDhmQ2hrWVhSbGMxc3hYU0U5WENKY0lpa3BYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlHUmhkR1Z6TG1wdmFXNG9YQ0lyWENJcE8xeHlYRzVjZEZ4MFhIUmNkR1pwWld4a1ZtRnNJRDBnWm1sbGJHUldZV3d1Y21Wd2JHRmpaU2d2WEZ3dkwyY3NKeWNwTzF4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSOVhISmNibHgwWEhSbGJITmxJR2xtS0NSbWFXVnNaQzVzWlc1bmRHZzlQVEVwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEdsbUtHUmhkR1Z6V3pCZElUMWNJbHdpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBabWxsYkdSV1lXd2dQU0JrWVhSbGN5NXFiMmx1S0Z3aUsxd2lLVHRjY2x4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlHWnBaV3hrVm1Gc0xuSmxjR3hoWTJVb0wxeGNMeTluTENjbktUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBmVnh5WEc1Y2RGeDBYSEpjYmx4MFhIUnBaaWgwZVhCbGIyWW9abWxsYkdSV1lXd3BJVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUnBaaWhtYVdWc1pGWmhiQ0U5WENKY0lpbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhaaGNpQm1hV1ZzWkZOc2RXY2dQU0JjSWx3aU8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEdsbUtHWnBaV3hrVG1GdFpUMDlYQ0pmYzJaZmNHOXpkRjlrWVhSbFhDSXBYSEpjYmx4MFhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RGeDBabWxsYkdSVGJIVm5JRDBnWENKd2IzTjBYMlJoZEdWY0lqdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEZ4MFpXeHpaVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1UyeDFaeUE5SUdacFpXeGtUbUZ0WlR0Y2NseHVYSFJjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGFXWW9abWxsYkdSVGJIVm5JVDFjSWx3aUtWeHlYRzVjZEZ4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2RDOHZjMlZzWmk1MWNteGZZMjl0Y0c5dVpXNTBjeUFyUFNCY0lpWmNJaXRtYVdWc1pGTnNkV2NyWENJOVhDSXJabWxsYkdSV1lXdzdYSEpjYmx4MFhIUmNkRngwWEhSelpXeG1MblZ5YkY5d1lYSmhiWE5iWm1sbGJHUlRiSFZuWFNBOUlHWnBaV3hrVm1Gc08xeHlYRzVjZEZ4MFhIUmNkSDFjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwZlZ4eVhHNWNkRngwWEhKY2JseDBmU3hjY2x4dVhIUndjbTlqWlhOelZHRjRiMjV2YlhrNklHWjFibU4wYVc5dUtDUmpiMjUwWVdsdVpYSXNJSEpsZEhWeWJsOXZZbXBsWTNRcFhISmNibHgwZTF4eVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaHlaWFIxY201ZmIySnFaV04wS1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhKbGRIVnlibDl2WW1wbFkzUWdQU0JtWVd4elpUdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzVjZEZ4MEx5OXBaaWdwWEhSY2RGeDBYSFJjZEZ4eVhHNWNkRngwTHk5MllYSWdabWxsYkdST1lXMWxJRDBnSkNoMGFHbHpLUzVoZEhSeUtGd2laR0YwWVMxelppMW1hV1ZzWkMxdVlXMWxYQ0lwTzF4eVhHNWNkRngwZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh5WEc1Y2RGeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZIbHdaU0E5SUNSamIyNTBZV2x1WlhJdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRkSGx3WlZ3aUtUdGNjbHh1WEhSY2RIWmhjaUJwYm5CMWRGUjVjR1VnUFNBa1kyOXVkR0ZwYm1WeUxtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMV2x1Y0hWMExYUjVjR1ZjSWlrN1hISmNibHgwWEhSY2NseHVYSFJjZEhaaGNpQWtabWxsYkdRN1hISmNibHgwWEhSMllYSWdabWxsYkdST1lXMWxJRDBnWENKY0lqdGNjbHh1WEhSY2RIWmhjaUJtYVdWc1pGWmhiQ0E5SUZ3aVhDSTdYSEpjYmx4MFhIUmNjbHh1WEhSY2RHbG1LR2x1Y0hWMFZIbHdaVDA5WENKelpXeGxZM1JjSWlsY2NseHVYSFJjZEh0Y2NseHVYSFJjZEZ4MEpHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aWMyVnNaV04wWENJcE8xeHlYRzVjZEZ4MFhIUm1hV1ZzWkU1aGJXVWdQU0FrWm1sbGJHUXVZWFIwY2loY0ltNWhiV1ZjSWlrdWNtVndiR0ZqWlNnblcxMG5MQ0FuSnlrN1hISmNibHgwWEhSY2RGeHlYRzVjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJSE5sYkdZdVoyVjBVMlZzWldOMFZtRnNLQ1JtYVdWc1pDazdJRnh5WEc1Y2RGeDBmVnh5WEc1Y2RGeDBaV3h6WlNCcFppaHBibkIxZEZSNWNHVTlQVndpYlhWc2RHbHpaV3hsWTNSY0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2ljMlZzWldOMFhDSXBPMXh5WEc1Y2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbTVoYldWY0lpa3VjbVZ3YkdGalpTZ25XMTBuTENBbkp5azdYSEpjYmx4MFhIUmNkSFpoY2lCdmNHVnlZWFJ2Y2lBOUlDUm1hV1ZzWkM1aGRIUnlLRndpWkdGMFlTMXZjR1Z5WVhSdmNsd2lLVHRjY2x4dVhIUmNkRngwWEhKY2JseDBYSFJjZEdacFpXeGtWbUZzSUQwZ2MyVnNaaTVuWlhSTmRXeDBhVk5sYkdWamRGWmhiQ2drWm1sbGJHUXNJRzl3WlhKaGRHOXlLVHRjY2x4dVhIUmNkSDFjY2x4dVhIUmNkR1ZzYzJVZ2FXWW9hVzV3ZFhSVWVYQmxQVDFjSW1Ob1pXTnJZbTk0WENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0luVnNJRDRnYkdrZ2FXNXdkWFE2WTJobFkydGliM2hjSWlrN1hISmNibHgwWEhSY2RHbG1LQ1JtYVdWc1pDNXNaVzVuZEdnK01DbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEdacFpXeGtUbUZ0WlNBOUlDUm1hV1ZzWkM1aGRIUnlLRndpYm1GdFpWd2lLUzV5WlhCc1lXTmxLQ2RiWFNjc0lDY25LVHRjY2x4dVhIUmNkRngwWEhSY2RGeDBYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBYSFIyWVhJZ2IzQmxjbUYwYjNJZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSStJSFZzWENJcExtRjBkSElvWENKa1lYUmhMVzl3WlhKaGRHOXlYQ0lwTzF4eVhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUkRhR1ZqYTJKdmVGWmhiQ2drWm1sbGJHUXNJRzl3WlhKaGRHOXlLVHRjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwZlZ4eVhHNWNkRngwWld4elpTQnBaaWhwYm5CMWRGUjVjR1U5UFZ3aWNtRmthVzljSWlsY2NseHVYSFJjZEh0Y2NseHVYSFJjZEZ4MEpHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aWRXd2dQaUJzYVNCcGJuQjFkRHB5WVdScGIxd2lLVHRjY2x4dVhIUmNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDR3S1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBabWxsYkdST1lXMWxJRDBnSkdacFpXeGtMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEdacFpXeGtWbUZzSUQwZ2MyVnNaaTVuWlhSU1lXUnBiMVpoYkNna1ptbGxiR1FwTzF4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSOVhISmNibHgwWEhSY2NseHVYSFJjZEdsbUtIUjVjR1Z2WmlobWFXVnNaRlpoYkNraFBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEdsbUtHWnBaV3hrVm1Gc0lUMWNJbHdpS1Z4eVhHNWNkRngwWEhSN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh5WlhSMWNtNWZiMkpxWldOMFBUMTBjblZsS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhKbGRIVnliaUI3Ym1GdFpUb2dabWxsYkdST1lXMWxMQ0IyWVd4MVpUb2dabWxsYkdSV1lXeDlPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2YzJWc1ppNTFjbXhmWTI5dGNHOXVaVzUwY3lBclBTQmNJaVpjSWl0bWFXVnNaRTVoYldVclhDSTlYQ0lyWm1sbGJHUldZV3c3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1MWNteGZjR0Z5WVcxelcyWnBaV3hrVG1GdFpWMGdQU0JtYVdWc1pGWmhiRHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdhV1lvY21WMGRYSnVYMjlpYW1WamREMDlkSEoxWlNsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCbVlXeHpaVHRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHgwZlZ4eVhHNTlPeUpkZlE9PSIsIlxyXG5tb2R1bGUuZXhwb3J0cyA9IHtcclxuXHRcclxuXHRzZWFyY2hGb3Jtczoge30sXHJcblx0XHJcblx0aW5pdDogZnVuY3Rpb24oKXtcclxuXHRcdFxyXG5cdFx0XHJcblx0fSxcclxuXHRhZGRTZWFyY2hGb3JtOiBmdW5jdGlvbihpZCwgb2JqZWN0KXtcclxuXHRcdFxyXG5cdFx0dGhpcy5zZWFyY2hGb3Jtc1tpZF0gPSBvYmplY3Q7XHJcblx0fSxcclxuXHRnZXRTZWFyY2hGb3JtOiBmdW5jdGlvbihpZClcclxuXHR7XHJcblx0XHRyZXR1cm4gdGhpcy5zZWFyY2hGb3Jtc1tpZF07XHRcclxuXHR9XHJcblx0XHJcbn07IiwiKGZ1bmN0aW9uIChnbG9iYWwpe1xuXG52YXIgJCBcdFx0XHRcdD0gKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKTtcblxubW9kdWxlLmV4cG9ydHMgPSB7XG5cdFxuXHRpbml0OiBmdW5jdGlvbigpe1xuXHRcdCQoZG9jdW1lbnQpLm9uKFwic2Y6YWpheGZpbmlzaFwiLCBcIi5zZWFyY2hhbmRmaWx0ZXJcIiwgZnVuY3Rpb24oIGUsIGRhdGEgKSB7XG5cdFx0XHR2YXIgZGlzcGxheV9tZXRob2QgPSBkYXRhLm9iamVjdC5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q7XG5cdFx0XHRpZiAoIGRpc3BsYXlfbWV0aG9kID09PSAnY3VzdG9tX2VkZF9zdG9yZScgKSB7XG5cdFx0XHRcdCQoJ2lucHV0LmVkZC1hZGQtdG8tY2FydCcpLmNzcygnZGlzcGxheScsIFwibm9uZVwiKTtcblx0XHRcdFx0JCgnYS5lZGQtYWRkLXRvLWNhcnQnKS5hZGRDbGFzcygnZWRkLWhhcy1qcycpO1xuXHRcdFx0fSBlbHNlIGlmICggZGlzcGxheV9tZXRob2QgPT09ICdjdXN0b21fbGF5b3V0cycgKSB7XG5cdFx0XHRcdGlmICggJCgnLmNsLWxheW91dCcpLmhhc0NsYXNzKCAnY2wtbGF5b3V0LS1tYXNvbnJ5JyApICkge1xuXHRcdFx0XHRcdC8vdGhlbiByZS1pbml0IG1hc29ucnlcblx0XHRcdFx0XHRjb25zdCBtYXNvbnJ5Q29udGFpbmVyID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCggJy5jbC1sYXlvdXQtLW1hc29ucnknICk7XG5cdFx0XHRcdFx0aWYgKCBtYXNvbnJ5Q29udGFpbmVyLmxlbmd0aCA+IDAgKSB7XG5cdFx0XHRcdFx0XHRjb25zdCBjdXN0b21MYXlvdXRHcmlkID0gbmV3IE1hc29ucnkoICcuY2wtbGF5b3V0LS1tYXNvbnJ5Jywge1xuXHRcdFx0XHRcdFx0XHQvLyBvcHRpb25zLi4uXG5cdFx0XHRcdFx0XHRcdGl0ZW1TZWxlY3RvcjogJy5jbC1sYXlvdXRfX2l0ZW0nLFxuXHRcdFx0XHRcdFx0XHQvL2NvbHVtbldpZHRoOiAzMTlcblx0XHRcdFx0XHRcdFx0cGVyY2VudFBvc2l0aW9uOiB0cnVlLFxuXHRcdFx0XHRcdFx0XHQvL2d1dHRlcjogMTAsXG5cdFx0XHRcdFx0XHRcdHRyYW5zaXRpb25EdXJhdGlvbjogMCxcblx0XHRcdFx0XHRcdH0gKTtcblx0XHRcdFx0XHRcdGltYWdlc0xvYWRlZCggbWFzb25yeUNvbnRhaW5lciApLm9uKCAncHJvZ3Jlc3MnLCBmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRcdFx0Y3VzdG9tTGF5b3V0R3JpZC5sYXlvdXQoKTtcblx0XHRcdFx0XHRcdH0gKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9KTtcblx0fSxcblxufTtcbn0pLmNhbGwodGhpcyx0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsIDogdHlwZW9mIHNlbGYgIT09IFwidW5kZWZpbmVkXCIgPyBzZWxmIDogdHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvdyA6IHt9KVxuLy8jIHNvdXJjZU1hcHBpbmdVUkw9ZGF0YTphcHBsaWNhdGlvbi9qc29uO2NoYXJzZXQ6dXRmLTg7YmFzZTY0LGV5SjJaWEp6YVc5dUlqb3pMQ0p6YjNWeVkyVnpJanBiSW5OeVl5OXdkV0pzYVdNdllYTnpaWFJ6TDJwekwybHVZMngxWkdWekwzUm9hWEprY0dGeWRIa3Vhbk1pWFN3aWJtRnRaWE1pT2x0ZExDSnRZWEJ3YVc1bmN5STZJanRCUVVGQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJJaXdpWm1sc1pTSTZJbWRsYm1WeVlYUmxaQzVxY3lJc0luTnZkWEpqWlZKdmIzUWlPaUlpTENKemIzVnlZMlZ6UTI5dWRHVnVkQ0k2V3lKY2JuWmhjaUFrSUZ4MFhIUmNkRngwUFNBb2RIbHdaVzltSUhkcGJtUnZkeUFoUFQwZ1hDSjFibVJsWm1sdVpXUmNJaUEvSUhkcGJtUnZkMXNuYWxGMVpYSjVKMTBnT2lCMGVYQmxiMllnWjJ4dlltRnNJQ0U5UFNCY0luVnVaR1ZtYVc1bFpGd2lJRDhnWjJ4dlltRnNXeWRxVVhWbGNua25YU0E2SUc1MWJHd3BPMXh1WEc1dGIyUjFiR1V1Wlhod2IzSjBjeUE5SUh0Y2JseDBYRzVjZEdsdWFYUTZJR1oxYm1OMGFXOXVLQ2w3WEc1Y2RGeDBKQ2hrYjJOMWJXVnVkQ2t1YjI0b1hDSnpaanBoYW1GNFptbHVhWE5vWENJc0lGd2lMbk5sWVhKamFHRnVaR1pwYkhSbGNsd2lMQ0JtZFc1amRHbHZiaWdnWlN3Z1pHRjBZU0FwSUh0Y2JseDBYSFJjZEhaaGNpQmthWE53YkdGNVgyMWxkR2h2WkNBOUlHUmhkR0V1YjJKcVpXTjBMbVJwYzNCc1lYbGZjbVZ6ZFd4MFgyMWxkR2h2WkR0Y2JseDBYSFJjZEdsbUlDZ2daR2x6Y0d4aGVWOXRaWFJvYjJRZ1BUMDlJQ2RqZFhOMGIyMWZaV1JrWDNOMGIzSmxKeUFwSUh0Y2JseDBYSFJjZEZ4MEpDZ25hVzV3ZFhRdVpXUmtMV0ZrWkMxMGJ5MWpZWEowSnlrdVkzTnpLQ2RrYVhOd2JHRjVKeXdnWENKdWIyNWxYQ0lwTzF4dVhIUmNkRngwWEhRa0tDZGhMbVZrWkMxaFpHUXRkRzh0WTJGeWRDY3BMbUZrWkVOc1lYTnpLQ2RsWkdRdGFHRnpMV3B6SnlrN1hHNWNkRngwWEhSOUlHVnNjMlVnYVdZZ0tDQmthWE53YkdGNVgyMWxkR2h2WkNBOVBUMGdKMk4xYzNSdmJWOXNZWGx2ZFhSekp5QXBJSHRjYmx4MFhIUmNkRngwYVdZZ0tDQWtLQ2N1WTJ3dGJHRjViM1YwSnlrdWFHRnpRMnhoYzNNb0lDZGpiQzFzWVhsdmRYUXRMVzFoYzI5dWNua25JQ2tnS1NCN1hHNWNkRngwWEhSY2RGeDBMeTkwYUdWdUlISmxMV2x1YVhRZ2JXRnpiMjV5ZVZ4dVhIUmNkRngwWEhSY2RHTnZibk4wSUcxaGMyOXVjbmxEYjI1MFlXbHVaWElnUFNCa2IyTjFiV1Z1ZEM1eGRXVnllVk5sYkdWamRHOXlRV3hzS0NBbkxtTnNMV3hoZVc5MWRDMHRiV0Z6YjI1eWVTY2dLVHRjYmx4MFhIUmNkRngwWEhScFppQW9JRzFoYzI5dWNubERiMjUwWVdsdVpYSXViR1Z1WjNSb0lENGdNQ0FwSUh0Y2JseDBYSFJjZEZ4MFhIUmNkR052Ym5OMElHTjFjM1J2YlV4aGVXOTFkRWR5YVdRZ1BTQnVaWGNnVFdGemIyNXllU2dnSnk1amJDMXNZWGx2ZFhRdExXMWhjMjl1Y25rbkxDQjdYRzVjZEZ4MFhIUmNkRngwWEhSY2RDOHZJRzl3ZEdsdmJuTXVMaTVjYmx4MFhIUmNkRngwWEhSY2RGeDBhWFJsYlZObGJHVmpkRzl5T2lBbkxtTnNMV3hoZVc5MWRGOWZhWFJsYlNjc1hHNWNkRngwWEhSY2RGeDBYSFJjZEM4dlkyOXNkVzF1VjJsa2RHZzZJRE14T1Z4dVhIUmNkRngwWEhSY2RGeDBYSFJ3WlhKalpXNTBVRzl6YVhScGIyNDZJSFJ5ZFdVc1hHNWNkRngwWEhSY2RGeDBYSFJjZEM4dlozVjBkR1Z5T2lBeE1DeGNibHgwWEhSY2RGeDBYSFJjZEZ4MGRISmhibk5wZEdsdmJrUjFjbUYwYVc5dU9pQXdMRnh1WEhSY2RGeDBYSFJjZEZ4MGZTQXBPMXh1WEhSY2RGeDBYSFJjZEZ4MGFXMWhaMlZ6VEc5aFpHVmtLQ0J0WVhOdmJuSjVRMjl1ZEdGcGJtVnlJQ2t1YjI0b0lDZHdjbTluY21WemN5Y3NJR1oxYm1OMGFXOXVLQ2tnZTF4dVhIUmNkRngwWEhSY2RGeDBYSFJqZFhOMGIyMU1ZWGx2ZFhSSGNtbGtMbXhoZVc5MWRDZ3BPMXh1WEhSY2RGeDBYSFJjZEZ4MGZTQXBPMXh1WEhSY2RGeDBYSFJjZEgxY2JseDBYSFJjZEZ4MGZWeHVYSFJjZEZ4MGZWeHVYSFJjZEgwcE8xeHVYSFI5TEZ4dVhHNTlPeUpkZlE9PSJdfQ==

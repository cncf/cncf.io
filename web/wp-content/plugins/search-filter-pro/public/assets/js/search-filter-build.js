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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiXG52YXIgc3RhdGUgPSByZXF1aXJlKCcuL2luY2x1ZGVzL3N0YXRlJyk7XG52YXIgcGx1Z2luID0gcmVxdWlyZSgnLi9pbmNsdWRlcy9wbHVnaW4nKTtcblxuXG4oZnVuY3Rpb24gKCAkICkge1xuXG5cdFwidXNlIHN0cmljdFwiO1xuXG5cdCQoZnVuY3Rpb24gKCkge1xuXG5cdFx0aWYgKCFPYmplY3Qua2V5cykge1xuXHRcdCAgT2JqZWN0LmtleXMgPSAoZnVuY3Rpb24gKCkge1xuXHRcdFx0J3VzZSBzdHJpY3QnO1xuXHRcdFx0dmFyIGhhc093blByb3BlcnR5ID0gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eSxcblx0XHRcdFx0aGFzRG9udEVudW1CdWcgPSAhKHt0b1N0cmluZzogbnVsbH0pLnByb3BlcnR5SXNFbnVtZXJhYmxlKCd0b1N0cmluZycpLFxuXHRcdFx0XHRkb250RW51bXMgPSBbXG5cdFx0XHRcdCAgJ3RvU3RyaW5nJyxcblx0XHRcdFx0ICAndG9Mb2NhbGVTdHJpbmcnLFxuXHRcdFx0XHQgICd2YWx1ZU9mJyxcblx0XHRcdFx0ICAnaGFzT3duUHJvcGVydHknLFxuXHRcdFx0XHQgICdpc1Byb3RvdHlwZU9mJyxcblx0XHRcdFx0ICAncHJvcGVydHlJc0VudW1lcmFibGUnLFxuXHRcdFx0XHQgICdjb25zdHJ1Y3Rvcidcblx0XHRcdFx0XSxcblx0XHRcdFx0ZG9udEVudW1zTGVuZ3RoID0gZG9udEVudW1zLmxlbmd0aDtcblxuXHRcdFx0cmV0dXJuIGZ1bmN0aW9uIChvYmopIHtcblx0XHRcdCAgaWYgKHR5cGVvZiBvYmogIT09ICdvYmplY3QnICYmICh0eXBlb2Ygb2JqICE9PSAnZnVuY3Rpb24nIHx8IG9iaiA9PT0gbnVsbCkpIHtcblx0XHRcdFx0dGhyb3cgbmV3IFR5cGVFcnJvcignT2JqZWN0LmtleXMgY2FsbGVkIG9uIG5vbi1vYmplY3QnKTtcblx0XHRcdCAgfVxuXG5cdFx0XHQgIHZhciByZXN1bHQgPSBbXSwgcHJvcCwgaTtcblxuXHRcdFx0ICBmb3IgKHByb3AgaW4gb2JqKSB7XG5cdFx0XHRcdGlmIChoYXNPd25Qcm9wZXJ0eS5jYWxsKG9iaiwgcHJvcCkpIHtcblx0XHRcdFx0ICByZXN1bHQucHVzaChwcm9wKTtcblx0XHRcdFx0fVxuXHRcdFx0ICB9XG5cblx0XHRcdCAgaWYgKGhhc0RvbnRFbnVtQnVnKSB7XG5cdFx0XHRcdGZvciAoaSA9IDA7IGkgPCBkb250RW51bXNMZW5ndGg7IGkrKykge1xuXHRcdFx0XHQgIGlmIChoYXNPd25Qcm9wZXJ0eS5jYWxsKG9iaiwgZG9udEVudW1zW2ldKSkge1xuXHRcdFx0XHRcdHJlc3VsdC5wdXNoKGRvbnRFbnVtc1tpXSk7XG5cdFx0XHRcdCAgfVxuXHRcdFx0XHR9XG5cdFx0XHQgIH1cblx0XHRcdCAgcmV0dXJuIHJlc3VsdDtcblx0XHRcdH07XG5cdFx0ICB9KCkpO1xuXHRcdH1cblxuXHRcdC8qIFNlYXJjaCAmIEZpbHRlciBqUXVlcnkgUGx1Z2luICovXG5cdFx0JC5mbi5zZWFyY2hBbmRGaWx0ZXIgPSBwbHVnaW47XG5cblx0XHQvKiBpbml0ICovXG5cdFx0JChcIi5zZWFyY2hhbmRmaWx0ZXJcIikuc2VhcmNoQW5kRmlsdGVyKCk7XG5cblx0XHQvKiBleHRlcm5hbCBjb250cm9scyAqL1xuXHRcdCQoZG9jdW1lbnQpLm9uKFwiY2xpY2tcIiwgXCIuc2VhcmNoLWZpbHRlci1yZXNldFwiLCBmdW5jdGlvbihlKXtcblxuXHRcdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG5cdFx0XHR2YXIgc2VhcmNoRm9ybUlEID0gdHlwZW9mKCQodGhpcykuYXR0cihcImRhdGEtc2VhcmNoLWZvcm0taWRcIikpIT1cInVuZGVmaW5lZFwiID8gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZWFyY2gtZm9ybS1pZFwiKSA6IFwiXCI7XG5cdFx0XHR2YXIgc3VibWl0Rm9ybSA9IHR5cGVvZigkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLXN1Ym1pdC1mb3JtXCIpKSE9XCJ1bmRlZmluZWRcIiA/ICQodGhpcykuYXR0cihcImRhdGEtc2Ytc3VibWl0LWZvcm1cIikgOiBcIlwiO1xuXG5cdFx0XHRzdGF0ZS5nZXRTZWFyY2hGb3JtKHNlYXJjaEZvcm1JRCkucmVzZXQoc3VibWl0Rm9ybSk7XG5cblx0XHRcdC8vdmFyICRsaW5rZWQgPSAkKFwiI3NlYXJjaC1maWx0ZXItZm9ybS1cIitzZWFyY2hGb3JtSUQpLnNlYXJjaEZpbHRlckZvcm0oe2FjdGlvbjogXCJyZXNldFwifSk7XG5cblx0XHRcdHJldHVybiBmYWxzZTtcblxuXHRcdH0pO1xuXG5cdH0pO1xuXG5cbi8qXG4gKiBqUXVlcnkgRWFzaW5nIHYxLjQuMSAtIGh0dHA6Ly9nc2dkLmNvLnVrL3NhbmRib3gvanF1ZXJ5L2Vhc2luZy9cbiAqIE9wZW4gc291cmNlIHVuZGVyIHRoZSBCU0QgTGljZW5zZS5cbiAqIENvcHlyaWdodCDCqSAyMDA4IEdlb3JnZSBNY0dpbmxleSBTbWl0aFxuICogQWxsIHJpZ2h0cyByZXNlcnZlZC5cbiAqIGh0dHBzOi8vcmF3LmdpdGh1Yi5jb20vZ2RzbWl0aC9qcXVlcnkuZWFzaW5nL21hc3Rlci9MSUNFTlNFXG4qL1xuXG4vKiBnbG9iYWxzIGpRdWVyeSwgZGVmaW5lLCBtb2R1bGUsIHJlcXVpcmUgKi9cbihmdW5jdGlvbiAoZmFjdG9yeSkge1xuXHRpZiAodHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQpIHtcblx0XHRkZWZpbmUoWydqcXVlcnknXSwgZnVuY3Rpb24gKCQpIHtcblx0XHRcdHJldHVybiBmYWN0b3J5KCQpO1xuXHRcdH0pO1xuXHR9IGVsc2UgaWYgKHR5cGVvZiBtb2R1bGUgPT09IFwib2JqZWN0XCIgJiYgdHlwZW9mIG1vZHVsZS5leHBvcnRzID09PSBcIm9iamVjdFwiKSB7XG5cdFx0bW9kdWxlLmV4cG9ydHMgPSBmYWN0b3J5KCh0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93WydqUXVlcnknXSA6IHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWxbJ2pRdWVyeSddIDogbnVsbCkpO1xuXHR9IGVsc2Uge1xuXHRcdGZhY3RvcnkoalF1ZXJ5KTtcblx0fVxufSkoZnVuY3Rpb24oJCl7XG5cblx0Ly8gUHJlc2VydmUgdGhlIG9yaWdpbmFsIGpRdWVyeSBcInN3aW5nXCIgZWFzaW5nIGFzIFwianN3aW5nXCJcblx0aWYgKHR5cGVvZiAkLmVhc2luZyAhPT0gJ3VuZGVmaW5lZCcpIHtcblx0XHQkLmVhc2luZ1snanN3aW5nJ10gPSAkLmVhc2luZ1snc3dpbmcnXTtcblx0fVxuXG5cdHZhciBwb3cgPSBNYXRoLnBvdyxcblx0XHRzcXJ0ID0gTWF0aC5zcXJ0LFxuXHRcdHNpbiA9IE1hdGguc2luLFxuXHRcdGNvcyA9IE1hdGguY29zLFxuXHRcdFBJID0gTWF0aC5QSSxcblx0XHRjMSA9IDEuNzAxNTgsXG5cdFx0YzIgPSBjMSAqIDEuNTI1LFxuXHRcdGMzID0gYzEgKyAxLFxuXHRcdGM0ID0gKCAyICogUEkgKSAvIDMsXG5cdFx0YzUgPSAoIDIgKiBQSSApIC8gNC41O1xuXG5cdC8vIHggaXMgdGhlIGZyYWN0aW9uIG9mIGFuaW1hdGlvbiBwcm9ncmVzcywgaW4gdGhlIHJhbmdlIDAuLjFcblx0ZnVuY3Rpb24gYm91bmNlT3V0KHgpIHtcblx0XHR2YXIgbjEgPSA3LjU2MjUsXG5cdFx0XHRkMSA9IDIuNzU7XG5cdFx0aWYgKCB4IDwgMS9kMSApIHtcblx0XHRcdHJldHVybiBuMSp4Kng7XG5cdFx0fSBlbHNlIGlmICggeCA8IDIvZDEgKSB7XG5cdFx0XHRyZXR1cm4gbjEqKHgtPSgxLjUvZDEpKSp4ICsgLjc1O1xuXHRcdH0gZWxzZSBpZiAoIHggPCAyLjUvZDEgKSB7XG5cdFx0XHRyZXR1cm4gbjEqKHgtPSgyLjI1L2QxKSkqeCArIC45Mzc1O1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRyZXR1cm4gbjEqKHgtPSgyLjYyNS9kMSkpKnggKyAuOTg0Mzc1O1xuXHRcdH1cblx0fVxuXG5cdCQuZXh0ZW5kKCAkLmVhc2luZywge1xuXHRcdGRlZjogJ2Vhc2VPdXRRdWFkJyxcblx0XHRzd2luZzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiAkLmVhc2luZ1skLmVhc2luZy5kZWZdKHgpO1xuXHRcdH0sXG5cdFx0ZWFzZUluUXVhZDogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4ICogeDtcblx0XHR9LFxuXHRcdGVhc2VPdXRRdWFkOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIDEgLSAoIDEgLSB4ICkgKiAoIDEgLSB4ICk7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRRdWFkOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xuXHRcdFx0XHQyICogeCAqIHggOlxuXHRcdFx0XHQxIC0gcG93KCAtMiAqIHggKyAyLCAyICkgLyAyO1xuXHRcdH0sXG5cdFx0ZWFzZUluQ3ViaWM6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCAqIHggKiB4O1xuXHRcdH0sXG5cdFx0ZWFzZU91dEN1YmljOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCAzICk7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRDdWJpYzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4IDwgMC41ID9cblx0XHRcdFx0NCAqIHggKiB4ICogeCA6XG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDMgKSAvIDI7XG5cdFx0fSxcblx0XHRlYXNlSW5RdWFydDogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4ICogeCAqIHggKiB4O1xuXHRcdH0sXG5cdFx0ZWFzZU91dFF1YXJ0OiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCA0ICk7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRRdWFydDogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4IDwgMC41ID9cblx0XHRcdFx0OCAqIHggKiB4ICogeCAqIHggOlxuXHRcdFx0XHQxIC0gcG93KCAtMiAqIHggKyAyLCA0ICkgLyAyO1xuXHRcdH0sXG5cdFx0ZWFzZUluUXVpbnQ6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCAqIHggKiB4ICogeCAqIHg7XG5cdFx0fSxcblx0XHRlYXNlT3V0UXVpbnQ6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4gMSAtIHBvdyggMSAtIHgsIDUgKTtcblx0XHR9LFxuXHRcdGVhc2VJbk91dFF1aW50OiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xuXHRcdFx0XHQxNiAqIHggKiB4ICogeCAqIHggKiB4IDpcblx0XHRcdFx0MSAtIHBvdyggLTIgKiB4ICsgMiwgNSApIC8gMjtcblx0XHR9LFxuXHRcdGVhc2VJblNpbmU6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4gMSAtIGNvcyggeCAqIFBJLzIgKTtcblx0XHR9LFxuXHRcdGVhc2VPdXRTaW5lOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHNpbiggeCAqIFBJLzIgKTtcblx0XHR9LFxuXHRcdGVhc2VJbk91dFNpbmU6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4gLSggY29zKCBQSSAqIHggKSAtIDEgKSAvIDI7XG5cdFx0fSxcblx0XHRlYXNlSW5FeHBvOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPT09IDAgPyAwIDogcG93KCAyLCAxMCAqIHggLSAxMCApO1xuXHRcdH0sXG5cdFx0ZWFzZU91dEV4cG86IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCA9PT0gMSA/IDEgOiAxIC0gcG93KCAyLCAtMTAgKiB4ICk7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRFeHBvOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPT09IDAgPyAwIDogeCA9PT0gMSA/IDEgOiB4IDwgMC41ID9cblx0XHRcdFx0cG93KCAyLCAyMCAqIHggLSAxMCApIC8gMiA6XG5cdFx0XHRcdCggMiAtIHBvdyggMiwgLTIwICogeCArIDEwICkgKSAvIDI7XG5cdFx0fSxcblx0XHRlYXNlSW5DaXJjOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIDEgLSBzcXJ0KCAxIC0gcG93KCB4LCAyICkgKTtcblx0XHR9LFxuXHRcdGVhc2VPdXRDaXJjOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHNxcnQoIDEgLSBwb3coIHggLSAxLCAyICkgKTtcblx0XHR9LFxuXHRcdGVhc2VJbk91dENpcmM6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XG5cdFx0XHRcdCggMSAtIHNxcnQoIDEgLSBwb3coIDIgKiB4LCAyICkgKSApIC8gMiA6XG5cdFx0XHRcdCggc3FydCggMSAtIHBvdyggLTIgKiB4ICsgMiwgMiApICkgKyAxICkgLyAyO1xuXHRcdH0sXG5cdFx0ZWFzZUluRWxhc3RpYzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHggPT09IDEgPyAxIDpcblx0XHRcdFx0LXBvdyggMiwgMTAgKiB4IC0gMTAgKSAqIHNpbiggKCB4ICogMTAgLSAxMC43NSApICogYzQgKTtcblx0XHR9LFxuXHRcdGVhc2VPdXRFbGFzdGljOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPT09IDAgPyAwIDogeCA9PT0gMSA/IDEgOlxuXHRcdFx0XHRwb3coIDIsIC0xMCAqIHggKSAqIHNpbiggKCB4ICogMTAgLSAwLjc1ICkgKiBjNCApICsgMTtcblx0XHR9LFxuXHRcdGVhc2VJbk91dEVsYXN0aWM6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6IHggPCAwLjUgP1xuXHRcdFx0XHQtKCBwb3coIDIsIDIwICogeCAtIDEwICkgKiBzaW4oICggMjAgKiB4IC0gMTEuMTI1ICkgKiBjNSApKSAvIDIgOlxuXHRcdFx0XHRwb3coIDIsIC0yMCAqIHggKyAxMCApICogc2luKCAoIDIwICogeCAtIDExLjEyNSApICogYzUgKSAvIDIgKyAxO1xuXHRcdH0sXG5cdFx0ZWFzZUluQmFjazogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiBjMyAqIHggKiB4ICogeCAtIGMxICogeCAqIHg7XG5cdFx0fSxcblx0XHRlYXNlT3V0QmFjazogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiAxICsgYzMgKiBwb3coIHggLSAxLCAzICkgKyBjMSAqIHBvdyggeCAtIDEsIDIgKTtcblx0XHR9LFxuXHRcdGVhc2VJbk91dEJhY2s6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XG5cdFx0XHRcdCggcG93KCAyICogeCwgMiApICogKCAoIGMyICsgMSApICogMiAqIHggLSBjMiApICkgLyAyIDpcblx0XHRcdFx0KCBwb3coIDIgKiB4IC0gMiwgMiApICooICggYzIgKyAxICkgKiAoIHggKiAyIC0gMiApICsgYzIgKSArIDIgKSAvIDI7XG5cdFx0fSxcblx0XHRlYXNlSW5Cb3VuY2U6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4gMSAtIGJvdW5jZU91dCggMSAtIHggKTtcblx0XHR9LFxuXHRcdGVhc2VPdXRCb3VuY2U6IGJvdW5jZU91dCxcblx0XHRlYXNlSW5PdXRCb3VuY2U6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XG5cdFx0XHRcdCggMSAtIGJvdW5jZU91dCggMSAtIDIgKiB4ICkgKSAvIDIgOlxuXHRcdFx0XHQoIDEgKyBib3VuY2VPdXQoIDIgKiB4IC0gMSApICkgLyAyO1xuXHRcdH1cblx0fSk7XG5cdHJldHVybiAkO1xufSk7XG5cbn0oalF1ZXJ5KSk7XG5cbi8vc2FmYXJpIGJhY2sgYnV0dG9uIGZpeFxualF1ZXJ5KCB3aW5kb3cgKS5vbiggXCJwYWdlc2hvd1wiLCBmdW5jdGlvbihldmVudCkge1xuICAgIGlmIChldmVudC5vcmlnaW5hbEV2ZW50LnBlcnNpc3RlZCkge1xuICAgICAgICBqUXVlcnkoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLm9mZigpO1xuICAgICAgICBqUXVlcnkoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLnNlYXJjaEFuZEZpbHRlcigpO1xuICAgIH1cbn0pO1xuXG4vKiB3cG51bWIgLSBub3Vpc2xpZGVyIG51bWJlciBmb3JtYXR0aW5nICovXG4hZnVuY3Rpb24oKXtcInVzZSBzdHJpY3RcIjtmdW5jdGlvbiBlKGUpe3JldHVybiBlLnNwbGl0KFwiXCIpLnJldmVyc2UoKS5qb2luKFwiXCIpfWZ1bmN0aW9uIG4oZSxuKXtyZXR1cm4gZS5zdWJzdHJpbmcoMCxuLmxlbmd0aCk9PT1ufWZ1bmN0aW9uIHIoZSxuKXtyZXR1cm4gZS5zbGljZSgtMSpuLmxlbmd0aCk9PT1ufWZ1bmN0aW9uIHQoZSxuLHIpe2lmKChlW25dfHxlW3JdKSYmZVtuXT09PWVbcl0pdGhyb3cgbmV3IEVycm9yKG4pfWZ1bmN0aW9uIGkoZSl7cmV0dXJuXCJudW1iZXJcIj09dHlwZW9mIGUmJmlzRmluaXRlKGUpfWZ1bmN0aW9uIG8oZSxuKXt2YXIgcj1NYXRoLnBvdygxMCxuKTtyZXR1cm4oTWF0aC5yb3VuZChlKnIpL3IpLnRvRml4ZWQobil9ZnVuY3Rpb24gdShuLHIsdCx1LGYsYSxjLHMscCxkLGwsaCl7dmFyIGcsdix3LG09aCx4PVwiXCIsYj1cIlwiO3JldHVybiBhJiYoaD1hKGgpKSxpKGgpPyhuIT09ITEmJjA9PT1wYXJzZUZsb2F0KGgudG9GaXhlZChuKSkmJihoPTApLDA+aCYmKGc9ITAsaD1NYXRoLmFicyhoKSksbiE9PSExJiYoaD1vKGgsbikpLGg9aC50b1N0cmluZygpLC0xIT09aC5pbmRleE9mKFwiLlwiKT8odj1oLnNwbGl0KFwiLlwiKSx3PXZbMF0sdCYmKHg9dCt2WzFdKSk6dz1oLHImJih3PWUodykubWF0Y2goLy57MSwzfS9nKSx3PWUody5qb2luKGUocikpKSksZyYmcyYmKGIrPXMpLHUmJihiKz11KSxnJiZwJiYoYis9cCksYis9dyxiKz14LGYmJihiKz1mKSxkJiYoYj1kKGIsbSkpLGIpOiExfWZ1bmN0aW9uIGYoZSx0LG8sdSxmLGEsYyxzLHAsZCxsLGgpe3ZhciBnLHY9XCJcIjtyZXR1cm4gbCYmKGg9bChoKSksaCYmXCJzdHJpbmdcIj09dHlwZW9mIGg/KHMmJm4oaCxzKSYmKGg9aC5yZXBsYWNlKHMsXCJcIiksZz0hMCksdSYmbihoLHUpJiYoaD1oLnJlcGxhY2UodSxcIlwiKSkscCYmbihoLHApJiYoaD1oLnJlcGxhY2UocCxcIlwiKSxnPSEwKSxmJiZyKGgsZikmJihoPWguc2xpY2UoMCwtMSpmLmxlbmd0aCkpLHQmJihoPWguc3BsaXQodCkuam9pbihcIlwiKSksbyYmKGg9aC5yZXBsYWNlKG8sXCIuXCIpKSxnJiYodis9XCItXCIpLHYrPWgsdj12LnJlcGxhY2UoL1teMC05XFwuXFwtLl0vZyxcIlwiKSxcIlwiPT09dj8hMToodj1OdW1iZXIodiksYyYmKHY9Yyh2KSksaSh2KT92OiExKSk6ITF9ZnVuY3Rpb24gYShlKXt2YXIgbixyLGksbz17fTtmb3Iobj0wO248cC5sZW5ndGg7bis9MSlpZihyPXBbbl0saT1lW3JdLHZvaWQgMD09PWkpXCJuZWdhdGl2ZVwiIT09cnx8by5uZWdhdGl2ZUJlZm9yZT9cIm1hcmtcIj09PXImJlwiLlwiIT09by50aG91c2FuZD9vW3JdPVwiLlwiOm9bcl09ITE6b1tyXT1cIi1cIjtlbHNlIGlmKFwiZGVjaW1hbHNcIj09PXIpe2lmKCEoaT49MCYmOD5pKSl0aHJvdyBuZXcgRXJyb3Iocik7b1tyXT1pfWVsc2UgaWYoXCJlbmNvZGVyXCI9PT1yfHxcImRlY29kZXJcIj09PXJ8fFwiZWRpdFwiPT09cnx8XCJ1bmRvXCI9PT1yKXtpZihcImZ1bmN0aW9uXCIhPXR5cGVvZiBpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9ZWxzZXtpZihcInN0cmluZ1wiIT10eXBlb2YgaSl0aHJvdyBuZXcgRXJyb3Iocik7b1tyXT1pfXJldHVybiB0KG8sXCJtYXJrXCIsXCJ0aG91c2FuZFwiKSx0KG8sXCJwcmVmaXhcIixcIm5lZ2F0aXZlXCIpLHQobyxcInByZWZpeFwiLFwibmVnYXRpdmVCZWZvcmVcIiksb31mdW5jdGlvbiBjKGUsbixyKXt2YXIgdCxpPVtdO2Zvcih0PTA7dDxwLmxlbmd0aDt0Kz0xKWkucHVzaChlW3BbdF1dKTtyZXR1cm4gaS5wdXNoKHIpLG4uYXBwbHkoXCJcIixpKX1mdW5jdGlvbiBzKGUpe3JldHVybiB0aGlzIGluc3RhbmNlb2Ygcz92b2lkKFwib2JqZWN0XCI9PXR5cGVvZiBlJiYoZT1hKGUpLHRoaXMudG89ZnVuY3Rpb24obil7cmV0dXJuIGMoZSx1LG4pfSx0aGlzLmZyb209ZnVuY3Rpb24obil7cmV0dXJuIGMoZSxmLG4pfSkpOm5ldyBzKGUpfXZhciBwPVtcImRlY2ltYWxzXCIsXCJ0aG91c2FuZFwiLFwibWFya1wiLFwicHJlZml4XCIsXCJwb3N0Zml4XCIsXCJlbmNvZGVyXCIsXCJkZWNvZGVyXCIsXCJuZWdhdGl2ZUJlZm9yZVwiLFwibmVnYXRpdmVcIixcImVkaXRcIixcInVuZG9cIl07d2luZG93LndOdW1iPXN9KCk7XG5cbiJdfQ==
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
        this.replace_results = $this.attr("data-replace-results") === "0" ? false : true;
        
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

        if(typeof(this.results_html)=="undefined")
        {
            this.results_html = "";
        }

        if(typeof(this.results_page_html)=="undefined")
        {
            this.results_page_html = "";
        }

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
                this.$infinite_scroll_container = jQuery(this.ajax_target_attr + ' ' + this.infinite_scroll_container);
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



        this.updateLoaderTag = function($object) {

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
            if(data_type=="json")
            {//then we did a request to the ajax endpoint, so expect an object back
                //grab the results and load in
                //self.$ajax_results_container.append(data['results']);
                self.load_more_html = data['results'];
            }
            else if(data_type=="html")
            {//we are expecting the html of the results page back, so extract the html we need
                var $data_obj = $(data);
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
            if(data_type=="json")
            {//then we did a request to the ajax endpoint, so expect an object back
                //grab the results and load in
                this.results_html = data['results'];

                if ( this.replace_results ) {
                    self.$ajax_results_container.html(this.results_html);
                }

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
                this.results_page_html = data;
                this.results_html = $data_obj.find( this.ajax_target_attr ).html();

                if ( this.replace_results ) {
                    self.$ajax_results_container.html(this.results_html);
                }

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
            if((self.scroll_on_action==self.ajax_action)||(self.scroll_on_action=="all"))
            {
                self.scrollToPos(); //scroll the window if it has been set
                //self.ajax_action = "";
            }
        }

        this.updateUrlHistory = function(ajax_results_url)
        {
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
                        var minVal = $slider_el.find(".sf-range-min").val();
                        var maxVal = $slider_el.find(".sf-range-max").val();
                        slider_object.noUiSlider.set([minVal, maxVal]);

                    });
                }
            });

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
                    var minVal = $slider_el.attr("data-min-formatted");
                    var maxVal = $slider_el.attr("data-max-formatted");
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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3BsdWdpbi5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyJcbnZhciAkIFx0XHRcdFx0PSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xudmFyIHN0YXRlIFx0XHRcdD0gcmVxdWlyZSgnLi9zdGF0ZScpO1xudmFyIHByb2Nlc3NfZm9ybSBcdD0gcmVxdWlyZSgnLi9wcm9jZXNzX2Zvcm0nKTtcbnZhciBub1VpU2xpZGVyXHRcdD0gcmVxdWlyZSgnbm91aXNsaWRlcicpO1xuLy92YXIgY29va2llcyAgICAgICAgID0gcmVxdWlyZSgnanMtY29va2llJyk7XG52YXIgdGhpcmRQYXJ0eSAgICAgID0gcmVxdWlyZSgnLi90aGlyZHBhcnR5Jyk7XG5cbndpbmRvdy5zZWFyY2hBbmRGaWx0ZXIgPSB7XG4gICAgZXh0ZW5zaW9uczogW10sXG4gICAgcmVnaXN0ZXJFeHRlbnNpb246IGZ1bmN0aW9uKCBleHRlbnNpb25OYW1lICkge1xuICAgICAgICB0aGlzLmV4dGVuc2lvbnMucHVzaCggZXh0ZW5zaW9uTmFtZSApO1xuICAgIH1cbn07XG5cbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24ob3B0aW9ucylcbntcbiAgICB2YXIgZGVmYXVsdHMgPSB7XG4gICAgICAgIHN0YXJ0T3BlbmVkOiBmYWxzZSxcbiAgICAgICAgaXNJbml0OiB0cnVlLFxuICAgICAgICBhY3Rpb246IFwiXCJcbiAgICB9O1xuXG4gICAgdmFyIG9wdHMgPSBqUXVlcnkuZXh0ZW5kKGRlZmF1bHRzLCBvcHRpb25zKTtcbiAgICBcbiAgICB0aGlyZFBhcnR5LmluaXQoKTtcbiAgICBcbiAgICAvL2xvb3AgdGhyb3VnaCBlYWNoIGl0ZW0gbWF0Y2hlZFxuICAgIHRoaXMuZWFjaChmdW5jdGlvbigpXG4gICAge1xuXG4gICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XG4gICAgICAgIHZhciBzZWxmID0gdGhpcztcbiAgICAgICAgdGhpcy5zZmlkID0gJHRoaXMuYXR0cihcImRhdGEtc2YtZm9ybS1pZFwiKTtcblxuICAgICAgICBzdGF0ZS5hZGRTZWFyY2hGb3JtKHRoaXMuc2ZpZCwgdGhpcyk7XG5cbiAgICAgICAgdGhpcy4kZmllbGRzID0gJHRoaXMuZmluZChcIj4gdWwgPiBsaVwiKTsgLy9hIHJlZmVyZW5jZSB0byBlYWNoIGZpZWxkcyBwYXJlbnQgTElcblxuICAgICAgICB0aGlzLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcyA9ICR0aGlzLmF0dHIoJ2RhdGEtdGF4b25vbXktYXJjaGl2ZXMnKTtcbiAgICAgICAgdGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgPSAkdGhpcy5hdHRyKCdkYXRhLWN1cnJlbnQtdGF4b25vbXktYXJjaGl2ZScpO1xuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcyk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gXCIwXCI7XG4gICAgICAgIH1cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgcHJvY2Vzc19mb3JtLmluaXQoc2VsZi5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMsIHNlbGYuY3VycmVudF90YXhvbm9teV9hcmNoaXZlKTtcbiAgICAgICAgLy9wcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZik7XG4gICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZXh0cmFfcXVlcnlfcGFyYW1zKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5leHRyYV9xdWVyeV9wYXJhbXMgPSB7YWxsOiB7fSwgcmVzdWx0czoge30sIGFqYXg6IHt9fTtcbiAgICAgICAgfVxuXG5cbiAgICAgICAgdGhpcy50ZW1wbGF0ZV9pc19sb2FkZWQgPSAkdGhpcy5hdHRyKFwiZGF0YS10ZW1wbGF0ZS1sb2FkZWRcIik7XG4gICAgICAgIHRoaXMuaXNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXhcIik7XG4gICAgICAgIHRoaXMuaW5zdGFuY2VfbnVtYmVyID0gJHRoaXMuYXR0cignZGF0YS1pbnN0YW5jZS1jb3VudCcpO1xuICAgICAgICB0aGlzLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyID0galF1ZXJ5KCR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdGFyZ2V0XCIpKTtcblxuICAgICAgICB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC11cGRhdGUtc2VjdGlvbnNcIikgPyBKU09OLnBhcnNlKCAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXVwZGF0ZS1zZWN0aW9uc1wiKSApIDogW107XG4gICAgICAgIHRoaXMucmVwbGFjZV9yZXN1bHRzID0gJHRoaXMuYXR0cihcImRhdGEtcmVwbGFjZS1yZXN1bHRzXCIpID09PSBcIjBcIiA/IGZhbHNlIDogdHJ1ZTtcbiAgICAgICAgXG4gICAgICAgIHRoaXMucmVzdWx0c191cmwgPSAkdGhpcy5hdHRyKFwiZGF0YS1yZXN1bHRzLXVybFwiKTtcbiAgICAgICAgdGhpcy5kZWJ1Z19tb2RlID0gJHRoaXMuYXR0cihcImRhdGEtZGVidWctbW9kZVwiKTtcbiAgICAgICAgdGhpcy51cGRhdGVfYWpheF91cmwgPSAkdGhpcy5hdHRyKFwiZGF0YS11cGRhdGUtYWpheC11cmxcIik7XG4gICAgICAgIHRoaXMucGFnaW5hdGlvbl90eXBlID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC1wYWdpbmF0aW9uLXR5cGVcIik7XG4gICAgICAgIHRoaXMuYXV0b19jb3VudCA9ICR0aGlzLmF0dHIoXCJkYXRhLWF1dG8tY291bnRcIik7XG4gICAgICAgIHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1hdXRvLWNvdW50LXJlZnJlc2gtbW9kZVwiKTtcbiAgICAgICAgdGhpcy5vbmx5X3Jlc3VsdHNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLW9ubHktcmVzdWx0cy1hamF4XCIpOyAvL2lmIHdlIGFyZSBub3Qgb24gdGhlIHJlc3VsdHMgcGFnZSwgcmVkaXJlY3QgcmF0aGVyIHRoYW4gdHJ5IHRvIGxvYWQgdmlhIGFqYXhcbiAgICAgICAgdGhpcy5zY3JvbGxfdG9fcG9zID0gJHRoaXMuYXR0cihcImRhdGEtc2Nyb2xsLXRvLXBvc1wiKTtcbiAgICAgICAgdGhpcy5jdXN0b21fc2Nyb2xsX3RvID0gJHRoaXMuYXR0cihcImRhdGEtY3VzdG9tLXNjcm9sbC10b1wiKTtcbiAgICAgICAgdGhpcy5zY3JvbGxfb25fYWN0aW9uID0gJHRoaXMuYXR0cihcImRhdGEtc2Nyb2xsLW9uLWFjdGlvblwiKTtcbiAgICAgICAgdGhpcy5sYW5nX2NvZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1sYW5nLWNvZGVcIik7XG4gICAgICAgIHRoaXMuYWpheF91cmwgPSAkdGhpcy5hdHRyKCdkYXRhLWFqYXgtdXJsJyk7XG4gICAgICAgIHRoaXMuYWpheF9mb3JtX3VybCA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC1mb3JtLXVybCcpO1xuICAgICAgICB0aGlzLmlzX3J0bCA9ICR0aGlzLmF0dHIoJ2RhdGEtaXMtcnRsJyk7XG5cbiAgICAgICAgdGhpcy5kaXNwbGF5X3Jlc3VsdF9tZXRob2QgPSAkdGhpcy5hdHRyKCdkYXRhLWRpc3BsYXktcmVzdWx0LW1ldGhvZCcpO1xuICAgICAgICB0aGlzLm1haW50YWluX3N0YXRlID0gJHRoaXMuYXR0cignZGF0YS1tYWludGFpbi1zdGF0ZScpO1xuICAgICAgICB0aGlzLmFqYXhfYWN0aW9uID0gXCJcIjtcbiAgICAgICAgdGhpcy5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBcIlwiO1xuXG4gICAgICAgIHRoaXMuY3VycmVudF9wYWdlZCA9IHBhcnNlSW50KCR0aGlzLmF0dHIoJ2RhdGEtaW5pdC1wYWdlZCcpKTtcbiAgICAgICAgdGhpcy5sYXN0X2xvYWRfbW9yZV9odG1sID0gXCJcIjtcbiAgICAgICAgdGhpcy5sb2FkX21vcmVfaHRtbCA9IFwiXCI7XG4gICAgICAgIHRoaXMuYWpheF9kYXRhX3R5cGUgPSAkdGhpcy5hdHRyKCdkYXRhLWFqYXgtZGF0YS10eXBlJyk7XG4gICAgICAgIHRoaXMuYWpheF90YXJnZXRfYXR0ciA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdGFyZ2V0XCIpO1xuICAgICAgICB0aGlzLnVzZV9oaXN0b3J5X2FwaSA9ICR0aGlzLmF0dHIoXCJkYXRhLXVzZS1oaXN0b3J5LWFwaVwiKTtcbiAgICAgICAgdGhpcy5pc19zdWJtaXR0aW5nID0gZmFsc2U7XG5cbiAgICAgICAgdGhpcy5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMucmVzdWx0c19odG1sKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5yZXN1bHRzX2h0bWwgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMucmVzdWx0c19wYWdlX2h0bWwpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLnJlc3VsdHNfcGFnZV9odG1sID0gXCJcIjtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnVzZV9oaXN0b3J5X2FwaSk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMudXNlX2hpc3RvcnlfYXBpID0gXCJcIjtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnBhZ2luYXRpb25fdHlwZSk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMucGFnaW5hdGlvbl90eXBlID0gXCJub3JtYWxcIjtcbiAgICAgICAgfVxuICAgICAgICBpZih0eXBlb2YodGhpcy5jdXJyZW50X3BhZ2VkKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5jdXJyZW50X3BhZ2VkID0gMTtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdGFyZ2V0X2F0dHIpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmFqYXhfdGFyZ2V0X2F0dHIgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF91cmwpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmFqYXhfdXJsID0gXCJcIjtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfZm9ybV91cmwpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmFqYXhfZm9ybV91cmwgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMucmVzdWx0c191cmwpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLnJlc3VsdHNfdXJsID0gXCJcIjtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnNjcm9sbF90b19wb3MpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLnNjcm9sbF90b19wb3MgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuc2Nyb2xsX29uX2FjdGlvbik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuc2Nyb2xsX29uX2FjdGlvbiA9IFwiXCI7XG4gICAgICAgIH1cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuY3VzdG9tX3Njcm9sbF90byk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuY3VzdG9tX3Njcm9sbF90byA9IFwiXCI7XG4gICAgICAgIH1cbiAgICAgICAgdGhpcy4kY3VzdG9tX3Njcm9sbF90byA9IGpRdWVyeSh0aGlzLmN1c3RvbV9zY3JvbGxfdG8pO1xuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnVwZGF0ZV9hamF4X3VybCk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMudXBkYXRlX2FqYXhfdXJsID0gXCJcIjtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmRlYnVnX21vZGUpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmRlYnVnX21vZGUgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF90YXJnZXRfb2JqZWN0KT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5hamF4X3RhcmdldF9vYmplY3QgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMudGVtcGxhdGVfaXNfbG9hZGVkKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy50ZW1wbGF0ZV9pc19sb2FkZWQgPSBcIjBcIjtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZSA9IFwiMFwiO1xuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5hamF4X2xpbmtzX3NlbGVjdG9yID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC1saW5rcy1zZWxlY3RvclwiKTtcblxuXG4gICAgICAgIHRoaXMuYXV0b191cGRhdGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1hdXRvLXVwZGF0ZVwiKTtcbiAgICAgICAgdGhpcy5pbnB1dFRpbWVyID0gMDtcblxuICAgICAgICB0aGlzLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyID0gZnVuY3Rpb24oKVxuICAgICAgICB7XG4gICAgICAgICAgICAvLyBXaGVuIHdlIG5hdmlnYXRlIGF3YXkgZnJvbSBzZWFyY2ggcmVzdWx0cywgYW5kIHRoZW4gcHJlc3MgYmFjayxcbiAgICAgICAgICAgIC8vIGlzX21heF9wYWdlZCBpcyByZXRhaW5lZCwgc28gd2Ugb25seSB3YW50IHRvIHNldCBpdCB0byBmYWxzZSBpZlxuICAgICAgICAgICAgLy8gd2UgYXJlIGluaXRhbGl6aW5nIHRoZSByZXN1bHRzIHBhZ2UgdGhlIGZpcnN0IHRpbWUgLSBzbyBqdXN0IFxuICAgICAgICAgICAgLy8gY2hlY2sgaWYgdGhpcyB2YXIgaXMgdW5kZWZpbmVkIChhcyBpdCBzaG91bGQgYmUgb24gZmlyc3QgdXNlKTtcbiAgICAgICAgICAgIGlmICggdHlwZW9mICggdGhpcy5pc19tYXhfcGFnZWQgKSA9PT0gJ3VuZGVmaW5lZCcgKSB7XG4gICAgICAgICAgICAgICAgdGhpcy5pc19tYXhfcGFnZWQgPSBmYWxzZTsgLy9mb3IgbG9hZCBtb3JlIG9ubHksIG9uY2Ugd2UgZGV0ZWN0IHdlJ3JlIGF0IHRoZSBlbmQgc2V0IHRoaXMgdG8gdHJ1ZVxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB0aGlzLnVzZV9zY3JvbGxfbG9hZGVyID0gJHRoaXMuYXR0cignZGF0YS1zaG93LXNjcm9sbC1sb2FkZXInKTtcbiAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpO1xuICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfdHJpZ2dlcl9hbW91bnQgPSAkdGhpcy5hdHRyKCdkYXRhLWluZmluaXRlLXNjcm9sbC10cmlnZ2VyJyk7XG4gICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MgPSAkdGhpcy5hdHRyKCdkYXRhLWluZmluaXRlLXNjcm9sbC1yZXN1bHQtY2xhc3MnKTtcbiAgICAgICAgICAgIHRoaXMuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSB0aGlzLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyO1xuXG4gICAgICAgICAgICBpZih0eXBlb2YodGhpcy5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSBcIlwiO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHRoaXMuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSBqUXVlcnkodGhpcy5hamF4X3RhcmdldF9hdHRyICsgJyAnICsgdGhpcy5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzID0gXCJcIjtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMudXNlX3Njcm9sbF9sb2FkZXIpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHRoaXMudXNlX3Njcm9sbF9sb2FkZXIgPSAxO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgIH07XG4gICAgICAgIHRoaXMuc2V0SW5maW5pdGVTY3JvbGxDb250YWluZXIoKTtcblxuICAgICAgICAvKiBmdW5jdGlvbnMgKi9cblxuICAgICAgICB0aGlzLnJlc2V0ID0gZnVuY3Rpb24oc3VibWl0X2Zvcm0pXG4gICAgICAgIHtcblxuICAgICAgICAgICAgdGhpcy5yZXNldEZvcm0oc3VibWl0X2Zvcm0pO1xuICAgICAgICAgICAgcmV0dXJuIHRydWU7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmlucHV0VXBkYXRlID0gZnVuY3Rpb24oZGVsYXlEdXJhdGlvbilcbiAgICAgICAge1xuICAgICAgICAgICAgaWYodHlwZW9mKGRlbGF5RHVyYXRpb24pPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciBkZWxheUR1cmF0aW9uID0gMzAwO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBzZWxmLnJlc2V0VGltZXIoZGVsYXlEdXJhdGlvbik7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLnNjcm9sbFRvUG9zID0gZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICB2YXIgb2Zmc2V0ID0gMDtcbiAgICAgICAgICAgIHZhciBjYW5TY3JvbGwgPSB0cnVlO1xuXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cIndpbmRvd1wiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgb2Zmc2V0ID0gMDtcblxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBlbHNlIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJmb3JtXCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAkdGhpcy5vZmZzZXQoKS50b3A7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cInJlc3VsdHNcIilcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIubGVuZ3RoPjApXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG9mZnNldCA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIub2Zmc2V0KCkudG9wO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImN1c3RvbVwiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgLy9jdXN0b21fc2Nyb2xsX3RvXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuJGN1c3RvbV9zY3JvbGxfdG8ubGVuZ3RoPjApXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG9mZnNldCA9IHNlbGYuJGN1c3RvbV9zY3JvbGxfdG8ub2Zmc2V0KCkudG9wO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGNhblNjcm9sbCA9IGZhbHNlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIGlmKGNhblNjcm9sbClcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICQoXCJodG1sLCBib2R5XCIpLnN0b3AoKS5hbmltYXRlKHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNjcm9sbFRvcDogb2Zmc2V0XG4gICAgICAgICAgICAgICAgICAgIH0sIFwibm9ybWFsXCIsIFwiZWFzZU91dFF1YWRcIiApO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuYXR0YWNoQWN0aXZlQ2xhc3MgPSBmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICAvL2NoZWNrIHRvIHNlZSBpZiB3ZSBhcmUgdXNpbmcgYWpheCAmIGF1dG8gY291bnRcbiAgICAgICAgICAgIC8vaWYgbm90LCB0aGUgc2VhcmNoIGZvcm0gZG9lcyBub3QgZ2V0IHJlbG9hZGVkLCBzbyB3ZSBuZWVkIHRvIHVwZGF0ZSB0aGUgc2Ytb3B0aW9uLWFjdGl2ZSBjbGFzcyBvbiBhbGwgZmllbGRzXG5cbiAgICAgICAgICAgICR0aGlzLm9uKCdjaGFuZ2UnLCAnaW5wdXRbdHlwZT1cInJhZGlvXCJdLCBpbnB1dFt0eXBlPVwiY2hlY2tib3hcIl0sIHNlbGVjdCcsIGZ1bmN0aW9uKGUpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyICRjdGhpcyA9ICQodGhpcyk7XG4gICAgICAgICAgICAgICAgdmFyICRjdGhpc19wYXJlbnQgPSAkY3RoaXMuY2xvc2VzdChcImxpW2RhdGEtc2YtZmllbGQtbmFtZV1cIik7XG4gICAgICAgICAgICAgICAgdmFyIHRoaXNfdGFnID0gJGN0aGlzLnByb3AoXCJ0YWdOYW1lXCIpLnRvTG93ZXJDYXNlKCk7XG4gICAgICAgICAgICAgICAgdmFyIGlucHV0X3R5cGUgPSAkY3RoaXMuYXR0cihcInR5cGVcIik7XG4gICAgICAgICAgICAgICAgdmFyIHBhcmVudF90YWcgPSAkY3RoaXNfcGFyZW50LnByb3AoXCJ0YWdOYW1lXCIpLnRvTG93ZXJDYXNlKCk7XG5cbiAgICAgICAgICAgICAgICBpZigodGhpc190YWc9PVwiaW5wdXRcIikmJigoaW5wdXRfdHlwZT09XCJyYWRpb1wiKXx8KGlucHV0X3R5cGU9PVwiY2hlY2tib3hcIikpICYmIChwYXJlbnRfdGFnPT1cImxpXCIpKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyICRhbGxfb3B0aW9ucyA9ICRjdGhpc19wYXJlbnQucGFyZW50KCkuZmluZCgnbGknKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyICRhbGxfb3B0aW9uc19maWVsZHMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2lucHV0OmNoZWNrZWQnKTtcblxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnMucmVtb3ZlQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnNfZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRwYXJlbnQgPSAkKHRoaXMpLmNsb3Nlc3QoXCJsaVwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICRwYXJlbnQuYWRkQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xuXG4gICAgICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2UgaWYodGhpc190YWc9PVwic2VsZWN0XCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICB2YXIgJGFsbF9vcHRpb25zID0gJGN0aGlzLmNoaWxkcmVuKCk7XG4gICAgICAgICAgICAgICAgICAgICRhbGxfb3B0aW9ucy5yZW1vdmVDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciB0aGlzX3ZhbCA9ICRjdGhpcy52YWwoKTtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgdGhpc19hcnJfdmFsID0gKHR5cGVvZiB0aGlzX3ZhbCA9PSAnc3RyaW5nJyB8fCB0aGlzX3ZhbCBpbnN0YW5jZW9mIFN0cmluZykgPyBbdGhpc192YWxdIDogdGhpc192YWw7XG5cbiAgICAgICAgICAgICAgICAgICAgJCh0aGlzX2Fycl92YWwpLmVhY2goZnVuY3Rpb24oaSwgdmFsdWUpe1xuICAgICAgICAgICAgICAgICAgICAgICAgJGN0aGlzLmZpbmQoXCJvcHRpb25bdmFsdWU9J1wiK3ZhbHVlK1wiJ11cIikuYWRkQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xuICAgICAgICAgICAgICAgICAgICB9KTtcblxuXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgfTtcbiAgICAgICAgdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cyA9IGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgIC8qIGF1dG8gdXBkYXRlICovXG4gICAgICAgICAgICBpZigoc2VsZi5hdXRvX3VwZGF0ZT09MSl8fChzZWxmLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignY2hhbmdlJywgJ2lucHV0W3R5cGU9XCJyYWRpb1wiXSwgaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdLCBzZWxlY3QnLCBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMjAwKTtcbiAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dFt0eXBlPVwibnVtYmVyXCJdJywgZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDgwMCk7XG4gICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICB2YXIgJHRleHRJbnB1dCA9ICR0aGlzLmZpbmQoJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOm5vdCguc2YtZGF0ZXBpY2tlciknKTtcbiAgICAgICAgICAgICAgICB2YXIgbGFzdFZhbHVlID0gJHRleHRJbnB1dC52YWwoKTtcblxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJywgZnVuY3Rpb24oKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWYobGFzdFZhbHVlIT0kdGV4dElucHV0LnZhbCgpKVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEyMDApO1xuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgbGFzdFZhbHVlID0gJHRleHRJbnB1dC52YWwoKTtcbiAgICAgICAgICAgICAgICB9KTtcblxuXG4gICAgICAgICAgICAgICAgJHRoaXMub24oJ2tleXByZXNzJywgJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOm5vdCguc2YtZGF0ZXBpY2tlciknLCBmdW5jdGlvbihlKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKGUud2hpY2ggPT0gMTMpe1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICAvLyR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dC5zZi1kYXRlcGlja2VyJywgc2VsZi5kYXRlSW5wdXRUeXBlKTtcblxuICAgICAgICAgICAgfVxuICAgICAgICB9O1xuXG4gICAgICAgIC8vdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cygpO1xuXG5cbiAgICAgICAgdGhpcy5jbGVhclRpbWVyID0gZnVuY3Rpb24oKVxuICAgICAgICB7XG4gICAgICAgICAgICBjbGVhclRpbWVvdXQoc2VsZi5pbnB1dFRpbWVyKTtcbiAgICAgICAgfTtcbiAgICAgICAgdGhpcy5yZXNldFRpbWVyID0gZnVuY3Rpb24oZGVsYXlEdXJhdGlvbilcbiAgICAgICAge1xuICAgICAgICAgICAgY2xlYXJUaW1lb3V0KHNlbGYuaW5wdXRUaW1lcik7XG4gICAgICAgICAgICBzZWxmLmlucHV0VGltZXIgPSBzZXRUaW1lb3V0KHNlbGYuZm9ybVVwZGF0ZWQsIGRlbGF5RHVyYXRpb24pO1xuXG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5hZGREYXRlUGlja2VycyA9IGZ1bmN0aW9uKClcbiAgICAgICAge1xuICAgICAgICAgICAgdmFyICRkYXRlX3BpY2tlciA9ICR0aGlzLmZpbmQoXCIuc2YtZGF0ZXBpY2tlclwiKTtcblxuICAgICAgICAgICAgaWYoJGRhdGVfcGlja2VyLmxlbmd0aD4wKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICRkYXRlX3BpY2tlci5lYWNoKGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGVGb3JtYXQgPSBcIlwiO1xuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZURyb3Bkb3duWWVhciA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZURyb3Bkb3duTW9udGggPSBmYWxzZTtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgJGNsb3Nlc3RfZGF0ZV93cmFwID0gJHRoaXMuY2xvc2VzdChcIi5zZl9kYXRlX2ZpZWxkXCIpO1xuICAgICAgICAgICAgICAgICAgICBpZigkY2xvc2VzdF9kYXRlX3dyYXAubGVuZ3RoPjApXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVGb3JtYXQgPSAkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS1mb3JtYXRcIik7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRjbG9zZXN0X2RhdGVfd3JhcC5hdHRyKFwiZGF0YS1kYXRlLXVzZS15ZWFyLWRyb3Bkb3duXCIpPT0xKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVEcm9wZG93blllYXIgPSB0cnVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtdXNlLW1vbnRoLWRyb3Bkb3duXCIpPT0xKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVEcm9wZG93bk1vbnRoID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlUGlja2VyT3B0aW9ucyA9IHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlubGluZTogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIHNob3dPdGhlck1vbnRoczogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIG9uU2VsZWN0OiBmdW5jdGlvbihlLCBmcm9tX2ZpZWxkKXsgc2VsZi5kYXRlU2VsZWN0KGUsIGZyb21fZmllbGQsICQodGhpcykpOyB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZUZvcm1hdDogZGF0ZUZvcm1hdCxcblxuICAgICAgICAgICAgICAgICAgICAgICAgY2hhbmdlTW9udGg6IGRhdGVEcm9wZG93bk1vbnRoLFxuICAgICAgICAgICAgICAgICAgICAgICAgY2hhbmdlWWVhcjogZGF0ZURyb3Bkb3duWWVhclxuICAgICAgICAgICAgICAgICAgICB9O1xuXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlUGlja2VyT3B0aW9ucy5kaXJlY3Rpb24gPSBcInJ0bFwiO1xuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgJHRoaXMuZGF0ZXBpY2tlcihkYXRlUGlja2VyT3B0aW9ucyk7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5sYW5nX2NvZGUhPVwiXCIpXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5zZXREZWZhdWx0cyhcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmV4dGVuZChcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeydkYXRlRm9ybWF0JzpkYXRlRm9ybWF0fSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnJlZ2lvbmFsWyBzZWxmLmxhbmdfY29kZV1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgICAgICAgICApO1xuXG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIuc2V0RGVmYXVsdHMoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5leHRlbmQoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHsnZGF0ZUZvcm1hdCc6ZGF0ZUZvcm1hdH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5yZWdpb25hbFtcImVuXCJdXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICAgICAgKTtcblxuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgIGlmKCQoJy5sbC1za2luLW1lbG9uJykubGVuZ3RoPT0wKXtcblxuICAgICAgICAgICAgICAgICAgICAkZGF0ZV9waWNrZXIuZGF0ZXBpY2tlcignd2lkZ2V0Jykud3JhcCgnPGRpdiBjbGFzcz1cImxsLXNraW4tbWVsb24gc2VhcmNoYW5kZmlsdGVyLWRhdGUtcGlja2VyXCIvPicpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfVxuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuZGF0ZVNlbGVjdCA9IGZ1bmN0aW9uKGUsIGZyb21fZmllbGQsICR0aGlzKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgJGlucHV0X2ZpZWxkID0gJChmcm9tX2ZpZWxkLmlucHV0LmdldCgwKSk7XG4gICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xuXG4gICAgICAgICAgICB2YXIgJGRhdGVfZmllbGRzID0gJGlucHV0X2ZpZWxkLmNsb3Nlc3QoJ1tkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGU9XCJkYXRlcmFuZ2VcIl0sIFtkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGU9XCJkYXRlXCJdJyk7XG4gICAgICAgICAgICAkZGF0ZV9maWVsZHMuZWFjaChmdW5jdGlvbihlLCBpbmRleCl7XG4gICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgdmFyICR0Zl9kYXRlX3BpY2tlcnMgPSAkKHRoaXMpLmZpbmQoXCIuc2YtZGF0ZXBpY2tlclwiKTtcbiAgICAgICAgICAgICAgICB2YXIgbm9fZGF0ZV9waWNrZXJzID0gJHRmX2RhdGVfcGlja2Vycy5sZW5ndGg7XG4gICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgaWYobm9fZGF0ZV9waWNrZXJzPjEpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAvL3RoZW4gaXQgaXMgYSBkYXRlIHJhbmdlLCBzbyBtYWtlIHN1cmUgYm90aCBmaWVsZHMgYXJlIGZpbGxlZCBiZWZvcmUgdXBkYXRpbmdcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRwX2NvdW50ZXIgPSAwO1xuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfZW1wdHlfZmllbGRfY291bnQgPSAwO1xuICAgICAgICAgICAgICAgICAgICAkdGZfZGF0ZV9waWNrZXJzLmVhY2goZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJCh0aGlzKS52YWwoKT09XCJcIilcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkcF9lbXB0eV9maWVsZF9jb3VudCsrO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgICAgICBkcF9jb3VudGVyKys7XG4gICAgICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmKGRwX2VtcHR5X2ZpZWxkX2NvdW50PT0wKVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMSk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmFkZFJhbmdlU2xpZGVycyA9IGZ1bmN0aW9uKClcbiAgICAgICAge1xuICAgICAgICAgICAgdmFyICRtZXRhX3JhbmdlID0gJHRoaXMuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNsaWRlclwiKTtcblxuICAgICAgICAgICAgaWYoJG1ldGFfcmFuZ2UubGVuZ3RoPjApXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgJG1ldGFfcmFuZ2UuZWFjaChmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW4gPSAkdGhpcy5hdHRyKFwiZGF0YS1taW5cIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1tYXhcIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBzbWluID0gJHRoaXMuYXR0cihcImRhdGEtc3RhcnQtbWluXCIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgc21heCA9ICR0aGlzLmF0dHIoXCJkYXRhLXN0YXJ0LW1heFwiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRpc3BsYXlfdmFsdWVfYXMgPSAkdGhpcy5hdHRyKFwiZGF0YS1kaXNwbGF5LXZhbHVlcy1hc1wiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0ZXAgPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGVwXCIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgJHN0YXJ0X3ZhbCA9ICR0aGlzLmZpbmQoJy5zZi1yYW5nZS1taW4nKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyICRlbmRfdmFsID0gJHRoaXMuZmluZCgnLnNmLXJhbmdlLW1heCcpO1xuXG5cbiAgICAgICAgICAgICAgICAgICAgdmFyIGRlY2ltYWxfcGxhY2VzID0gJHRoaXMuYXR0cihcImRhdGEtZGVjaW1hbC1wbGFjZXNcIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciB0aG91c2FuZF9zZXBlcmF0b3IgPSAkdGhpcy5hdHRyKFwiZGF0YS10aG91c2FuZC1zZXBlcmF0b3JcIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBkZWNpbWFsX3NlcGVyYXRvciA9ICR0aGlzLmF0dHIoXCJkYXRhLWRlY2ltYWwtc2VwZXJhdG9yXCIpO1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZF9mb3JtYXQgPSB3TnVtYih7XG4gICAgICAgICAgICAgICAgICAgICAgICBtYXJrOiBkZWNpbWFsX3NlcGVyYXRvcixcbiAgICAgICAgICAgICAgICAgICAgICAgIGRlY2ltYWxzOiBwYXJzZUZsb2F0KGRlY2ltYWxfcGxhY2VzKSxcbiAgICAgICAgICAgICAgICAgICAgICAgIHRob3VzYW5kOiB0aG91c2FuZF9zZXBlcmF0b3JcbiAgICAgICAgICAgICAgICAgICAgfSk7XG5cblxuXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtaW4pO1xuICAgICAgICAgICAgICAgICAgICB2YXIgbWluX2Zvcm1hdHRlZCA9IGZpZWxkX2Zvcm1hdC50byhwYXJzZUZsb2F0KHNtaW4pKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1heF9mb3JtYXR0ZWQgPSBmaWVsZF9mb3JtYXQudG8ocGFyc2VGbG9hdChzbWF4KSk7XG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtYXgpO1xuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KG1pbl9mb3JtYXR0ZWQpO1xuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KG1heF9mb3JtYXR0ZWQpO1xuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KGRpc3BsYXlfdmFsdWVfYXMpO1xuXG5cbiAgICAgICAgICAgICAgICAgICAgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0aW5wdXRcIilcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC52YWwobWluX2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC52YWwobWF4X2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRcIilcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5odG1sKG1pbl9mb3JtYXR0ZWQpO1xuICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwuaHRtbChtYXhfZm9ybWF0dGVkKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG5cbiAgICAgICAgICAgICAgICAgICAgdmFyIG5vVUlPcHRpb25zID0ge1xuICAgICAgICAgICAgICAgICAgICAgICAgcmFuZ2U6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnbWluJzogWyBwYXJzZUZsb2F0KG1pbikgXSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnbWF4JzogWyBwYXJzZUZsb2F0KG1heCkgXVxuICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0YXJ0OiBbbWluX2Zvcm1hdHRlZCwgbWF4X2Zvcm1hdHRlZF0sXG4gICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVzOiAyLFxuICAgICAgICAgICAgICAgICAgICAgICAgY29ubmVjdDogdHJ1ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0ZXA6IHBhcnNlRmxvYXQoc3RlcCksXG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGJlaGF2aW91cjogJ2V4dGVuZC10YXAnLFxuICAgICAgICAgICAgICAgICAgICAgICAgZm9ybWF0OiBmaWVsZF9mb3JtYXRcbiAgICAgICAgICAgICAgICAgICAgfTtcblxuXG5cbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG5vVUlPcHRpb25zLmRpcmVjdGlvbiA9IFwicnRsXCI7XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX29iamVjdCA9ICQodGhpcykuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcblxuICAgICAgICAgICAgICAgICAgICBpZiggXCJ1bmRlZmluZWRcIiAhPT0gdHlwZW9mKCBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIgKSApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vZGVzdHJveSBpZiBpdCBleGlzdHMuLiB0aGlzIG1lYW5zIHNvbWVob3cgYW5vdGhlciBpbnN0YW5jZSBoYWQgaW5pdGlhbGlzZWQgaXQuLlxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmRlc3Ryb3koKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIG5vVWlTbGlkZXIuY3JlYXRlKHNsaWRlcl9vYmplY3QsIG5vVUlPcHRpb25zKTtcblxuICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLm9mZigpO1xuICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpe1xuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbJCh0aGlzKS52YWwoKSwgbnVsbF0pO1xuICAgICAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5vZmYoKTtcbiAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFtudWxsLCAkKHRoaXMpLnZhbCgpXSk7XG4gICAgICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vJHN0YXJ0X3ZhbC5odG1sKG1pbl9mb3JtYXR0ZWQpO1xuICAgICAgICAgICAgICAgICAgICAvLyRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XG5cbiAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLm9mZigndXBkYXRlJyk7XG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5vbigndXBkYXRlJywgZnVuY3Rpb24oIHZhbHVlcywgaGFuZGxlICkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX3N0YXJ0X3ZhbCAgPSBtaW5fZm9ybWF0dGVkO1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9lbmRfdmFsICA9IG1heF9mb3JtYXR0ZWQ7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB2YWx1ZSA9IHZhbHVlc1toYW5kbGVdO1xuXG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmICggaGFuZGxlICkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1heF9mb3JtYXR0ZWQgPSB2YWx1ZTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbWluX2Zvcm1hdHRlZCA9IHZhbHVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRpbnB1dFwiKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwudmFsKG1pbl9mb3JtYXR0ZWQpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLnZhbChtYXhfZm9ybWF0dGVkKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0XCIpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5odG1sKG1pbl9mb3JtYXR0ZWQpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pIHRoaW5rIHRoZSBmdW5jdGlvbiB0aGF0IGJ1aWxkcyB0aGUgVVJMIG5lZWRzIHRvIGRlY29kZSB0aGUgZm9ybWF0dGVkIHN0cmluZyBiZWZvcmUgYWRkaW5nIHRvIHRoZSB1cmxcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vb25seSB0cnkgdG8gdXBkYXRlIGlmIHRoZSB2YWx1ZXMgaGF2ZSBhY3R1YWxseSBjaGFuZ2VkXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHNsaWRlcl9zdGFydF92YWwhPW1pbl9mb3JtYXR0ZWQpfHwoc2xpZGVyX2VuZF92YWwhPW1heF9mb3JtYXR0ZWQpKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSg4MDApO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuXG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpOyAvL2lnbm9yZSBhbnkgY2hhbmdlcyByZWNlbnRseSBtYWRlIGJ5IHRoZSBzbGlkZXIgKHRoaXMgd2FzIGp1c3QgaW5pdCBzaG91bGRuJ3QgY291bnQgYXMgYW4gdXBkYXRlIGV2ZW50KVxuICAgICAgICAgICAgfVxuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuaW5pdCA9IGZ1bmN0aW9uKGtlZXBfcGFnaW5hdGlvbilcbiAgICAgICAge1xuICAgICAgICAgICAgaWYodHlwZW9mKGtlZXBfcGFnaW5hdGlvbik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGtlZXBfcGFnaW5hdGlvbiA9IGZhbHNlO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB0aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzKCk7XG4gICAgICAgICAgICB0aGlzLmF0dGFjaEFjdGl2ZUNsYXNzKCk7XG5cbiAgICAgICAgICAgIHRoaXMuYWRkRGF0ZVBpY2tlcnMoKTtcbiAgICAgICAgICAgIHRoaXMuYWRkUmFuZ2VTbGlkZXJzKCk7XG5cbiAgICAgICAgICAgIC8vaW5pdCBjb21ibyBib3hlc1xuICAgICAgICAgICAgdmFyICRjb21ib2JveCA9ICR0aGlzLmZpbmQoXCJzZWxlY3RbZGF0YS1jb21ib2JveD0nMSddXCIpO1xuXG4gICAgICAgICAgICBpZigkY29tYm9ib3gubGVuZ3RoPjApXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgJGNvbWJvYm94LmVhY2goZnVuY3Rpb24oaW5kZXggKXtcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzY2IgPSAkKCB0aGlzICk7XG4gICAgICAgICAgICAgICAgICAgIHZhciBucm0gPSAkdGhpc2NiLmF0dHIoXCJkYXRhLWNvbWJvYm94LW5ybVwiKTtcblxuICAgICAgICAgICAgICAgICAgICBpZiAodHlwZW9mICR0aGlzY2IuY2hvc2VuICE9IFwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBjaG9zZW5vcHRpb25zID0ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlYXJjaF9jb250YWluczogdHJ1ZVxuICAgICAgICAgICAgICAgICAgICAgICAgfTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHR5cGVvZihucm0pIT09XCJ1bmRlZmluZWRcIikmJihucm0pKXtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjaG9zZW5vcHRpb25zLm5vX3Jlc3VsdHNfdGV4dCA9IG5ybTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vIHNhZmUgdG8gdXNlIHRoZSBmdW5jdGlvblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9zZWFyY2hfY29udGFpbnNcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzY2IuYWRkQ2xhc3MoXCJjaG9zZW4tcnRsXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLmNob3NlbihjaG9zZW5vcHRpb25zKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAgICAgIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNlbGVjdDJvcHRpb25zID0ge307XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGVjdDJvcHRpb25zLmRpciA9IFwicnRsXCI7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICBpZigodHlwZW9mKG5ybSkhPT1cInVuZGVmaW5lZFwiKSYmKG5ybSkpe1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGVjdDJvcHRpb25zLmxhbmd1YWdlPSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwibm9SZXN1bHRzXCI6IGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gbnJtO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNjYi5zZWxlY3QyKHNlbGVjdDJvcHRpb25zKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgfSk7XG5cblxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IGZhbHNlO1xuXG4gICAgICAgICAgICAvL2lmIGFqYXggaXMgZW5hYmxlZCBpbml0IHRoZSBwYWdpbmF0aW9uXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5zZXR1cEFqYXhQYWdpbmF0aW9uKCk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICR0aGlzLm9uKFwic3VibWl0XCIsIHRoaXMuc3VibWl0Rm9ybSk7XG5cbiAgICAgICAgICAgIHNlbGYuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMoKTsgLy93b29jb21tZXJjZSBvcmRlcmJ5XG5cbiAgICAgICAgICAgIGlmKGtlZXBfcGFnaW5hdGlvbj09ZmFsc2UpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLm9uV2luZG93U2Nyb2xsID0gZnVuY3Rpb24oZXZlbnQpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKCghc2VsZi5pc19sb2FkaW5nX21vcmUpICYmICghc2VsZi5pc19tYXhfcGFnZWQpKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciB3aW5kb3dfc2Nyb2xsID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpO1xuICAgICAgICAgICAgICAgIHZhciB3aW5kb3dfc2Nyb2xsX2JvdHRvbSA9ICQod2luZG93KS5zY3JvbGxUb3AoKSArICQod2luZG93KS5oZWlnaHQoKTtcbiAgICAgICAgICAgICAgICB2YXIgc2Nyb2xsX29mZnNldCA9IHBhcnNlSW50KHNlbGYuaW5maW5pdGVfc2Nyb2xsX3RyaWdnZXJfYW1vdW50KTtcblxuICAgICAgICAgICAgICAgIGlmKHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIubGVuZ3RoPT0xKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfc2Nyb2xsX2JvdHRvbSA9IHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIub2Zmc2V0KCkudG9wICsgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5oZWlnaHQoKTtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgb2Zmc2V0ID0gKHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIub2Zmc2V0KCkudG9wICsgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5oZWlnaHQoKSkgLSB3aW5kb3dfc2Nyb2xsO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmKHdpbmRvd19zY3JvbGxfYm90dG9tID4gcmVzdWx0c19zY3JvbGxfYm90dG9tICsgc2Nyb2xsX29mZnNldClcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5sb2FkTW9yZVJlc3VsdHMoKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAgICAgIHsvL2RvbnQgbG9hZCBtb3JlXG5cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuc3RyaXBRdWVyeVN0cmluZ0FuZEhhc2hGcm9tUGF0aCA9IGZ1bmN0aW9uKHVybCkge1xuICAgICAgICAgICAgcmV0dXJuIHVybC5zcGxpdChcIj9cIilbMF0uc3BsaXQoXCIjXCIpWzBdO1xuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5ndXAgPSBmdW5jdGlvbiggbmFtZSwgdXJsICkge1xuICAgICAgICAgICAgaWYgKCF1cmwpIHVybCA9IGxvY2F0aW9uLmhyZWZcbiAgICAgICAgICAgIG5hbWUgPSBuYW1lLnJlcGxhY2UoL1tcXFtdLyxcIlxcXFxcXFtcIikucmVwbGFjZSgvW1xcXV0vLFwiXFxcXFxcXVwiKTtcbiAgICAgICAgICAgIHZhciByZWdleFMgPSBcIltcXFxcPyZdXCIrbmFtZStcIj0oW14mI10qKVwiO1xuICAgICAgICAgICAgdmFyIHJlZ2V4ID0gbmV3IFJlZ0V4cCggcmVnZXhTICk7XG4gICAgICAgICAgICB2YXIgcmVzdWx0cyA9IHJlZ2V4LmV4ZWMoIHVybCApO1xuICAgICAgICAgICAgcmV0dXJuIHJlc3VsdHMgPT0gbnVsbCA/IG51bGwgOiByZXN1bHRzWzFdO1xuICAgICAgICB9O1xuXG5cbiAgICAgICAgdGhpcy5nZXRVcmxQYXJhbXMgPSBmdW5jdGlvbihrZWVwX3BhZ2luYXRpb24sIHR5cGUsIGV4Y2x1ZGUpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKHR5cGVvZihrZWVwX3BhZ2luYXRpb24pPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciBrZWVwX3BhZ2luYXRpb24gPSB0cnVlO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZih0eXBlb2YodHlwZSk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIHR5cGUgPSBcIlwiO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB2YXIgdXJsX3BhcmFtc19zdHIgPSBcIlwiO1xuXG4gICAgICAgICAgICAvLyBnZXQgYWxsIHBhcmFtcyBmcm9tIGZpZWxkc1xuICAgICAgICAgICAgdmFyIHVybF9wYXJhbXNfYXJyYXkgPSBwcm9jZXNzX2Zvcm0uZ2V0VXJsUGFyYW1zKHNlbGYpO1xuXG4gICAgICAgICAgICB2YXIgbGVuZ3RoID0gT2JqZWN0LmtleXModXJsX3BhcmFtc19hcnJheSkubGVuZ3RoO1xuICAgICAgICAgICAgdmFyIGNvdW50ID0gMDtcblxuICAgICAgICAgICAgaWYodHlwZW9mKGV4Y2x1ZGUpIT1cInVuZGVmaW5lZFwiKSB7XG4gICAgICAgICAgICAgICAgaWYgKHVybF9wYXJhbXNfYXJyYXkuaGFzT3duUHJvcGVydHkoZXhjbHVkZSkpIHtcbiAgICAgICAgICAgICAgICAgICAgbGVuZ3RoLS07XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZihsZW5ndGg+MClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBmb3IgKHZhciBrIGluIHVybF9wYXJhbXNfYXJyYXkpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHVybF9wYXJhbXNfYXJyYXkuaGFzT3duUHJvcGVydHkoaykpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGNhbl9hZGQgPSB0cnVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYodHlwZW9mKGV4Y2x1ZGUpIT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmKGs9PWV4Y2x1ZGUpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FuX2FkZCA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoY2FuX2FkZCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybF9wYXJhbXNfc3RyICs9IGsgKyBcIj1cIiArIHVybF9wYXJhbXNfYXJyYXlba107XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoY291bnQgPCBsZW5ndGggLSAxKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybF9wYXJhbXNfc3RyICs9IFwiJlwiO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvdW50Kys7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBcIlwiO1xuXG4gICAgICAgICAgICAvL2Zvcm0gcGFyYW1zIGFzIHVybCBxdWVyeSBzdHJpbmdcbiAgICAgICAgICAgIHZhciBmb3JtX3BhcmFtcyA9IHVybF9wYXJhbXNfc3RyO1xuXG4gICAgICAgICAgICAvL2dldCB1cmwgcGFyYW1zIGZyb20gdGhlIGZvcm0gaXRzZWxmICh3aGF0IHRoZSB1c2VyIGhhcyBzZWxlY3RlZClcbiAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgZm9ybV9wYXJhbXMpO1xuXG4gICAgICAgICAgICAvL2FkZCBwYWdpbmF0aW9uXG4gICAgICAgICAgICBpZihrZWVwX3BhZ2luYXRpb249PXRydWUpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIHBhZ2VOdW1iZXIgPSBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIpO1xuXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKHBhZ2VOdW1iZXIpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgcGFnZU51bWJlciA9IDE7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYocGFnZU51bWJlcj4xKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK3BhZ2VOdW1iZXIpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgLy9hZGQgc2ZpZFxuICAgICAgICAgICAgLy9xdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZpZD1cIitzZWxmLnNmaWQpO1xuXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggYW55IGV4dHJhIHBhcmFtcyAoZnJvbSBleHQgcGx1Z2lucykgYW5kIGFkZCB0byB0aGUgdXJsIChpZSB3b29jb21tZXJjZSBgb3JkZXJieWApXG4gICAgICAgICAgICAvKnZhciBleHRyYV9xdWVyeV9wYXJhbSA9IFwiXCI7XG4gICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zKS5sZW5ndGg7XG4gICAgICAgICAgICAgdmFyIGNvdW50ID0gMDtcblxuICAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxuICAgICAgICAgICAgIHtcblxuICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMpIHtcbiAgICAgICAgICAgICBpZiAoc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuaGFzT3duUHJvcGVydHkoaykpIHtcblxuICAgICAgICAgICAgIGlmKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdIT1cIlwiKVxuICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICBleHRyYV9xdWVyeV9wYXJhbSA9IGsrXCI9XCIrc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNba107XG4gICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBleHRyYV9xdWVyeV9wYXJhbSk7XG4gICAgICAgICAgICAgfVxuICAgICAgICAgICAgICovXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmFkZFF1ZXJ5UGFyYW1zKHF1ZXJ5X3BhcmFtcywgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsKTtcblxuICAgICAgICAgICAgaWYodHlwZSE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAvL3F1ZXJ5X3BhcmFtcyA9IHNlbGYuYWRkUXVlcnlQYXJhbXMocXVlcnlfcGFyYW1zLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1t0eXBlXSk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHJldHVybiBxdWVyeV9wYXJhbXM7XG4gICAgICAgIH1cbiAgICAgICAgdGhpcy5hZGRRdWVyeVBhcmFtcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcywgbmV3X3BhcmFtcylcbiAgICAgICAge1xuICAgICAgICAgICAgdmFyIGV4dHJhX3F1ZXJ5X3BhcmFtID0gXCJcIjtcbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyhuZXdfcGFyYW1zKS5sZW5ndGg7XG4gICAgICAgICAgICB2YXIgY291bnQgPSAwO1xuXG4gICAgICAgICAgICBpZihsZW5ndGg+MClcbiAgICAgICAgICAgIHtcblxuICAgICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gbmV3X3BhcmFtcykge1xuICAgICAgICAgICAgICAgICAgICBpZiAobmV3X3BhcmFtcy5oYXNPd25Qcm9wZXJ0eShrKSkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihuZXdfcGFyYW1zW2tdIT1cIlwiKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGV4dHJhX3F1ZXJ5X3BhcmFtID0gaytcIj1cIituZXdfcGFyYW1zW2tdO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgZXh0cmFfcXVlcnlfcGFyYW0pO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICByZXR1cm4gcXVlcnlfcGFyYW1zO1xuICAgICAgICB9XG4gICAgICAgIHRoaXMuYWRkVXJsUGFyYW0gPSBmdW5jdGlvbih1cmwsIHN0cmluZylcbiAgICAgICAge1xuICAgICAgICAgICAgdmFyIGFkZF9wYXJhbXMgPSBcIlwiO1xuXG4gICAgICAgICAgICBpZih1cmwhPVwiXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWYodXJsLmluZGV4T2YoXCI/XCIpICE9IC0xKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgYWRkX3BhcmFtcyArPSBcIiZcIjtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgLy91cmwgPSB0aGlzLnRyYWlsaW5nU2xhc2hJdCh1cmwpO1xuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiP1wiO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYoc3RyaW5nIT1cIlwiKVxuICAgICAgICAgICAge1xuXG4gICAgICAgICAgICAgICAgcmV0dXJuIHVybCArIGFkZF9wYXJhbXMgKyBzdHJpbmc7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgcmV0dXJuIHVybDtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmpvaW5VcmxQYXJhbSA9IGZ1bmN0aW9uKHBhcmFtcywgc3RyaW5nKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgYWRkX3BhcmFtcyA9IFwiXCI7XG5cbiAgICAgICAgICAgIGlmKHBhcmFtcyE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXG4gICAgICAgICAgICB7XG5cbiAgICAgICAgICAgICAgICByZXR1cm4gcGFyYW1zICsgYWRkX3BhcmFtcyArIHN0cmluZztcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gcGFyYW1zO1xuICAgICAgICAgICAgfVxuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuc2V0QWpheFJlc3VsdHNVUkxzID0gZnVuY3Rpb24ocXVlcnlfcGFyYW1zKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZih0eXBlb2Yoc2VsZi5hamF4X3Jlc3VsdHNfY29uZik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZiA9IG5ldyBBcnJheSgpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gXCJcIjtcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBcIlwiO1xuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSBcIlwiO1xuXG4gICAgICAgICAgICAvL2lmKHNlbGYuYWpheF91cmwhPVwiXCIpXG4gICAgICAgICAgICBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJzaG9ydGNvZGVcIilcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2FudCB0byBkbyBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnRcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLnJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xuXG4gICAgICAgICAgICAgICAgLy9hZGQgbGFuZyBjb2RlIHRvIGFqYXggYXBpIHJlcXVlc3QsIGxhbmcgY29kZSBzaG91bGQgYWxyZWFkeSBiZSBpbiB0aGVyZSBmb3Igb3RoZXIgcmVxdWVzdHMgKGllLCBzdXBwbGllZCBpbiB0aGUgUmVzdWx0cyBVUkwpXG5cbiAgICAgICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIC8vc28gYWRkIGl0XG4gICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJsYW5nPVwiK3NlbGYubGFuZ19jb2RlKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLmFqYXhfdXJsLCBxdWVyeV9wYXJhbXMpO1xuICAgICAgICAgICAgICAgIC8vc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSAnanNvbic7XG5cbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwicG9zdF90eXBlX2FyY2hpdmVcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XG5cbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcblxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJjdXN0b21fd29vY29tbWVyY2Vfc3RvcmVcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XG5cbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcblxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgey8vb3RoZXJ3aXNlIHdlIHdhbnQgdG8gcHVsbCB0aGUgcmVzdWx0cyBkaXJlY3RseSBmcm9tIHRoZSByZXN1bHRzIHBhZ2VcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLnJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF91cmwsIHF1ZXJ5X3BhcmFtcyk7XG4gICAgICAgICAgICAgICAgLy9zZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXSA9ICdodG1sJztcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkUXVlcnlQYXJhbXMoc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSwgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNbJ2FqYXgnXSk7XG5cbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gc2VsZi5hamF4X2RhdGFfdHlwZTtcbiAgICAgICAgfTtcblxuXG5cbiAgICAgICAgdGhpcy51cGRhdGVMb2FkZXJUYWcgPSBmdW5jdGlvbigkb2JqZWN0KSB7XG5cbiAgICAgICAgICAgIHZhciAkcGFyZW50O1xuXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgJHBhcmVudCA9IHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpLmxhc3QoKS5wYXJlbnQoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAkcGFyZW50ID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcjtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgdmFyIHRhZ05hbWUgPSAkcGFyZW50LnByb3AoXCJ0YWdOYW1lXCIpO1xuXG4gICAgICAgICAgICB2YXIgdGFnVHlwZSA9ICdkaXYnO1xuICAgICAgICAgICAgaWYoICggdGFnTmFtZS50b0xvd2VyQ2FzZSgpID09ICdvbCcgKSB8fCAoIHRhZ05hbWUudG9Mb3dlckNhc2UoKSA9PSAndWwnICkgKXtcbiAgICAgICAgICAgICAgICB0YWdUeXBlID0gJ2xpJztcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgdmFyICRuZXcgPSAkKCc8Jyt0YWdUeXBlKycgLz4nKS5odG1sKCRvYmplY3QuaHRtbCgpKTtcbiAgICAgICAgICAgIHZhciBhdHRyaWJ1dGVzID0gJG9iamVjdC5wcm9wKFwiYXR0cmlidXRlc1wiKTtcblxuICAgICAgICAgICAgLy8gbG9vcCB0aHJvdWdoIDxzZWxlY3Q+IGF0dHJpYnV0ZXMgYW5kIGFwcGx5IHRoZW0gb24gPGRpdj5cbiAgICAgICAgICAgICQuZWFjaChhdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAkbmV3LmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICByZXR1cm4gJG5ldztcblxuICAgICAgICB9XG5cblxuICAgICAgICB0aGlzLmxvYWRNb3JlUmVzdWx0cyA9IGZ1bmN0aW9uKClcbiAgICAgICAge1xuICAgICAgICAgICAgaWYgKCB0aGlzLmlzX21heF9wYWdlZCA9PT0gdHJ1ZSApIHtcbiAgICAgICAgICAgICAgICByZXR1cm47XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBzZWxmLmlzX2xvYWRpbmdfbW9yZSA9IHRydWU7XG5cbiAgICAgICAgICAgIC8vdHJpZ2dlciBzdGFydCBldmVudFxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxuICAgICAgICAgICAgICAgIHRhcmdldFNlbGVjdG9yOiBzZWxmLmFqYXhfdGFyZ2V0X2F0dHIsXG4gICAgICAgICAgICAgICAgdHlwZTogXCJsb2FkX21vcmVcIixcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcbiAgICAgICAgICAgIH07XG5cbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheHN0YXJ0XCIsIGV2ZW50X2RhdGEpO1xuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUpO1xuICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7IC8vZ3JhYiBhIGNvcHkgb2YgaHRlIFVSTCBwYXJhbXMgd2l0aG91dCBwYWdpbmF0aW9uIGFscmVhZHkgYWRkZWRcblxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBcIlwiO1xuICAgICAgICAgICAgdmFyIGFqYXhfcmVzdWx0c191cmwgPSBcIlwiO1xuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwiXCI7XG5cblxuICAgICAgICAgICAgLy9ub3cgYWRkIHRoZSBuZXcgcGFnaW5hdGlvblxuICAgICAgICAgICAgdmFyIG5leHRfcGFnZWRfbnVtYmVyID0gdGhpcy5jdXJyZW50X3BhZ2VkICsgMTtcbiAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJzZl9wYWdlZD1cIituZXh0X3BhZ2VkX251bWJlcik7XG5cbiAgICAgICAgICAgIHNlbGYuc2V0QWpheFJlc3VsdHNVUkxzKHF1ZXJ5X3BhcmFtcyk7XG4gICAgICAgICAgICBhamF4X3Byb2Nlc3NpbmdfdXJsID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXTtcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xuICAgICAgICAgICAgZGF0YV90eXBlID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ107XG5cbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcbiAgICAgICAgICAgIGlmKHNlbGYubGFzdF9hamF4X3JlcXVlc3QpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciAkbG9hZGVyID0gJCgnPGRpdi8+Jyx7XG4gICAgICAgICAgICAgICAgICAgICdjbGFzcyc6ICdzZWFyY2gtZmlsdGVyLXNjcm9sbC1sb2FkaW5nJ1xuICAgICAgICAgICAgICAgIH0pOy8vLmFwcGVuZFRvKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIpO1xuXG4gICAgICAgICAgICAgICAgJGxvYWRlciA9IHNlbGYudXBkYXRlTG9hZGVyVGFnKCRsb2FkZXIpO1xuXG4gICAgICAgICAgICAgICAgc2VsZi5pbmZpbml0ZVNjcm9sbEFwcGVuZCgkbG9hZGVyKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QgPSAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5jdXJyZW50X3BhZ2VkKys7XG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XG5cbiAgICAgICAgICAgICAgICAvLyAqKioqKioqKioqKioqKlxuICAgICAgICAgICAgICAgIC8vIFRPRE8gLSBQQVNURSBUSElTIEFORCBXQVRDSCBUSEUgUkVESVJFQ1QgLSBPTkxZIEhBUFBFTlMgV0lUSCBXQyAoQ1BUIEFORCBUQVggRE9FUyBOT1QpXG4gICAgICAgICAgICAgICAgLy8gaHR0cHM6Ly9zZWFyY2gtZmlsdGVyLnRlc3QvcHJvZHVjdC1jYXRlZ29yeS9jbG90aGluZy90c2hpcnRzL3BhZ2UvMy8/c2ZfcGFnZWQ9M1xuXG4gICAgICAgICAgICAgICAgLy91cGRhdGVzIHRoZSByZXN1dGxzICYgZm9ybSBodG1sXG4gICAgICAgICAgICAgICAgc2VsZi5hZGRSZXN1bHRzKGRhdGEsIGRhdGFfdHlwZSk7XG5cbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XG4gICAgICAgICAgICAgICAgZGF0YS50ZXh0U3RhdHVzID0gdGV4dFN0YXR1cztcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgZGF0YSk7XG5cbiAgICAgICAgICAgIH0pLmFsd2F5cyhmdW5jdGlvbigpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XG5cbiAgICAgICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgJGxvYWRlci5kZXRhY2goKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBzZWxmLmlzX2xvYWRpbmdfbW9yZSA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZmluaXNoXCIsIGRhdGEpO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgfVxuICAgICAgICB0aGlzLmZldGNoQWpheFJlc3VsdHMgPSBmdW5jdGlvbigpXG4gICAgICAgIHtcbiAgICAgICAgICAgIC8vdHJpZ2dlciBzdGFydCBldmVudFxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxuICAgICAgICAgICAgICAgIHRhcmdldFNlbGVjdG9yOiBzZWxmLmFqYXhfdGFyZ2V0X2F0dHIsXG4gICAgICAgICAgICAgICAgdHlwZTogXCJsb2FkX3Jlc3VsdHNcIixcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcbiAgICAgICAgICAgIH07XG5cbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheHN0YXJ0XCIsIGV2ZW50X2RhdGEpO1xuXG4gICAgICAgICAgICAvL3JlZm9jdXMgYW55IGlucHV0IGZpZWxkcyBhZnRlciB0aGUgZm9ybSBoYXMgYmVlbiB1cGRhdGVkXG4gICAgICAgICAgICB2YXIgJGxhc3RfYWN0aXZlX2lucHV0X3RleHQgPSAkdGhpcy5maW5kKCdpbnB1dFt0eXBlPVwidGV4dFwiXTpmb2N1cycpLm5vdChcIi5zZi1kYXRlcGlja2VyXCIpO1xuICAgICAgICAgICAgaWYoJGxhc3RfYWN0aXZlX2lucHV0X3RleHQubGVuZ3RoPT0xKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciBsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0ID0gJGxhc3RfYWN0aXZlX2lucHV0X3RleHQuYXR0cihcIm5hbWVcIik7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICR0aGlzLmFkZENsYXNzKFwic2VhcmNoLWZpbHRlci1kaXNhYmxlZFwiKTtcbiAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5kaXNhYmxlSW5wdXRzKHNlbGYpO1xuXG4gICAgICAgICAgICAvL2ZhZGUgb3V0IHJlc3VsdHNcbiAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYW5pbWF0ZSh7IG9wYWNpdHk6IDAuNSB9LCBcImZhc3RcIik7IC8vbG9hZGluZ1xuICAgICAgICAgICAgc2VsZi5mYWRlQ29udGVudEFyZWFzKCBcIm91dFwiICk7XG5cbiAgICAgICAgICAgIGlmKHNlbGYuYWpheF9hY3Rpb249PVwicGFnaW5hdGlvblwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIC8vbmVlZCB0byByZW1vdmUgYWN0aXZlIGZpbHRlciBmcm9tIFVSTFxuXG4gICAgICAgICAgICAgICAgLy9xdWVyeV9wYXJhbXMgPSBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcztcblxuICAgICAgICAgICAgICAgIC8vbm93IGFkZCB0aGUgbmV3IHBhZ2luYXRpb25cbiAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIik7XG5cbiAgICAgICAgICAgICAgICBpZih0eXBlb2YocGFnZU51bWJlcik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBwYWdlTnVtYmVyID0gMTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xuICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTtcblxuICAgICAgICAgICAgICAgIGlmKHBhZ2VOdW1iZXI+MSlcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJzZl9wYWdlZD1cIitwYWdlTnVtYmVyKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5hamF4X2FjdGlvbj09XCJzdWJtaXRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSk7XG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7IC8vZ3JhYiBhIGNvcHkgb2YgaHRlIFVSTCBwYXJhbXMgd2l0aG91dCBwYWdpbmF0aW9uIGFscmVhZHkgYWRkZWRcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBcIlwiO1xuICAgICAgICAgICAgdmFyIGFqYXhfcmVzdWx0c191cmwgPSBcIlwiO1xuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwiXCI7XG5cbiAgICAgICAgICAgIHNlbGYuc2V0QWpheFJlc3VsdHNVUkxzKHF1ZXJ5X3BhcmFtcyk7XG4gICAgICAgICAgICBhamF4X3Byb2Nlc3NpbmdfdXJsID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXTtcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xuICAgICAgICAgICAgZGF0YV90eXBlID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ107XG5cblxuICAgICAgICAgICAgLy9hYm9ydCBhbnkgcHJldmlvdXMgYWpheCByZXF1ZXN0c1xuICAgICAgICAgICAgaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0LmFib3J0KCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICB2YXIgYWpheF9hY3Rpb24gPSBzZWxmLmFqYXhfYWN0aW9uO1xuICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9ICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcblxuICAgICAgICAgICAgICAgIC8vdXBkYXRlcyB0aGUgcmVzdXRscyAmIGZvcm0gaHRtbFxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlUmVzdWx0cyhkYXRhLCBkYXRhX3R5cGUpO1xuXG4gICAgICAgICAgICAgICAgLy8gc2Nyb2xsIFxuICAgICAgICAgICAgICAgIC8vIHNldCB0aGUgdmFyIGJhY2sgdG8gd2hhdCBpdCB3YXMgYmVmb3JlIHRoZSBhamF4IHJlcXVlc3QgbmFkIHRoZSBmb3JtIHJlLWluaXRcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gYWpheF9hY3Rpb247XG4gICAgICAgICAgICAgICAgc2VsZi5zY3JvbGxSZXN1bHRzKCBzZWxmLmFqYXhfYWN0aW9uICk7XG5cbiAgICAgICAgICAgICAgICAvKiB1cGRhdGUgVVJMICovXG4gICAgICAgICAgICAgICAgLy91cGRhdGUgdXJsIGJlZm9yZSBwYWdpbmF0aW9uLCBiZWNhdXNlIHdlIG5lZWQgdG8gZG8gc29tZSBjaGVja3MgYWdhaW5zIHRoZSBVUkwgZm9yIGluZmluaXRlIHNjcm9sbFxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlVXJsSGlzdG9yeShhamF4X3Jlc3VsdHNfdXJsKTtcblxuICAgICAgICAgICAgICAgIC8vc2V0dXAgcGFnaW5hdGlvblxuICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xuXG4gICAgICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcblxuICAgICAgICAgICAgICAgIC8qIHVzZXIgZGVmICovXG4gICAgICAgICAgICAgICAgc2VsZi5pbml0V29vQ29tbWVyY2VDb250cm9scygpOyAvL3dvb2NvbW1lcmNlIG9yZGVyYnlcblxuXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XG4gICAgICAgICAgICAgICAgZGF0YS5qcVhIUiA9IGpxWEhSO1xuICAgICAgICAgICAgICAgIGRhdGEudGV4dFN0YXR1cyA9IHRleHRTdGF0dXM7XG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xuICAgICAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgZGF0YSk7XG5cbiAgICAgICAgICAgIH0pLmFsd2F5cyhmdW5jdGlvbigpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5zdG9wKHRydWUsdHJ1ZSkuYW5pbWF0ZSh7IG9wYWNpdHk6IDF9LCBcImZhc3RcIik7IC8vZmluaXNoZWQgbG9hZGluZ1xuICAgICAgICAgICAgICAgIHNlbGYuZmFkZUNvbnRlbnRBcmVhcyggXCJpblwiICk7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XG4gICAgICAgICAgICAgICAgJHRoaXMucmVtb3ZlQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XG5cbiAgICAgICAgICAgICAgICAvL3JlZm9jdXMgdGhlIGxhc3QgYWN0aXZlIHRleHQgZmllbGRcbiAgICAgICAgICAgICAgICBpZihsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0IT1cIlwiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyICRpbnB1dCA9IFtdO1xuICAgICAgICAgICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGFjdGl2ZV9pbnB1dCA9ICQodGhpcykuZmluZChcImlucHV0W25hbWU9J1wiK2xhc3RfYWN0aXZlX2lucHV0X3RleHQrXCInXVwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRhY3RpdmVfaW5wdXQubGVuZ3RoPT0xKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRpbnB1dCA9ICRhY3RpdmVfaW5wdXQ7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgIGlmKCRpbnB1dC5sZW5ndGg9PTEpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgJGlucHV0LmZvY3VzKCkudmFsKCRpbnB1dC52YWwoKSk7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZvY3VzQ2FtcG8oJGlucHV0WzBdKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICR0aGlzLmZpbmQoXCJpbnB1dFtuYW1lPSdfc2Zfc2VhcmNoJ11cIikudHJpZ2dlcignZm9jdXMnKTtcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmaW5pc2hcIiwgIGRhdGEgKTtcblxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5mb2N1c0NhbXBvID0gZnVuY3Rpb24oaW5wdXRGaWVsZCl7XG4gICAgICAgICAgICAvL3ZhciBpbnB1dEZpZWxkID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICAgICAgICAgICAgaWYgKGlucHV0RmllbGQgIT0gbnVsbCAmJiBpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aCAhPSAwKXtcbiAgICAgICAgICAgICAgICBpZiAoaW5wdXRGaWVsZC5jcmVhdGVUZXh0UmFuZ2Upe1xuICAgICAgICAgICAgICAgICAgICB2YXIgRmllbGRSYW5nZSA9IGlucHV0RmllbGQuY3JlYXRlVGV4dFJhbmdlKCk7XG4gICAgICAgICAgICAgICAgICAgIEZpZWxkUmFuZ2UubW92ZVN0YXJ0KCdjaGFyYWN0ZXInLGlucHV0RmllbGQudmFsdWUubGVuZ3RoKTtcbiAgICAgICAgICAgICAgICAgICAgRmllbGRSYW5nZS5jb2xsYXBzZSgpO1xuICAgICAgICAgICAgICAgICAgICBGaWVsZFJhbmdlLnNlbGVjdCgpO1xuICAgICAgICAgICAgICAgIH1lbHNlIGlmIChpbnB1dEZpZWxkLnNlbGVjdGlvblN0YXJ0IHx8IGlucHV0RmllbGQuc2VsZWN0aW9uU3RhcnQgPT0gJzAnKSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciBlbGVtTGVuID0gaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGg7XG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuc2VsZWN0aW9uU3RhcnQgPSBlbGVtTGVuO1xuICAgICAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLnNlbGVjdGlvbkVuZCA9IGVsZW1MZW47XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGlucHV0RmllbGQuYmx1cigpO1xuICAgICAgICAgICAgICAgIGlucHV0RmllbGQuZm9jdXMoKTtcbiAgICAgICAgICAgIH0gZWxzZXtcbiAgICAgICAgICAgICAgICBpZiAoIGlucHV0RmllbGQgKSB7XG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuZm9jdXMoKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgXG4gICAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLnRyaWdnZXJFdmVudCA9IGZ1bmN0aW9uKGV2ZW50bmFtZSwgZGF0YSlcbiAgICAgICAge1xuICAgICAgICAgICAgdmFyICRldmVudF9jb250YWluZXIgPSAkKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiK3NlbGYuc2ZpZCtcIiddXCIpO1xuICAgICAgICAgICAgJGV2ZW50X2NvbnRhaW5lci50cmlnZ2VyKGV2ZW50bmFtZSwgWyBkYXRhIF0pO1xuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5mZXRjaEFqYXhGb3JtID0gZnVuY3Rpb24oKVxuICAgICAgICB7XG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcbiAgICAgICAgICAgIHZhciBldmVudF9kYXRhID0ge1xuICAgICAgICAgICAgICAgIHNmaWQ6IHNlbGYuc2ZpZCxcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxuICAgICAgICAgICAgICAgIHR5cGU6IFwiZm9ybVwiLFxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxuICAgICAgICAgICAgfTtcblxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4Zm9ybXN0YXJ0XCIsIFsgZXZlbnRfZGF0YSBdKTtcblxuICAgICAgICAgICAgJHRoaXMuYWRkQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmRpc2FibGVJbnB1dHMoc2VsZik7XG5cbiAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcygpO1xuXG4gICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAvL3NvIGFkZCBpdFxuICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJsYW5nPVwiK3NlbGYubGFuZ19jb2RlKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF9mb3JtX3VybCwgcXVlcnlfcGFyYW1zKTtcbiAgICAgICAgICAgIHZhciBkYXRhX3R5cGUgPSBcImpzb25cIjtcblxuXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXG4gICAgICAgICAgICAvKmlmKHNlbGYubGFzdF9hamF4X3JlcXVlc3QpXG4gICAgICAgICAgICAge1xuICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcbiAgICAgICAgICAgICB9Ki9cblxuXG4gICAgICAgICAgICAvL3NlbGYubGFzdF9hamF4X3JlcXVlc3QgPVxuXG4gICAgICAgICAgICAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgLy9zZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcblxuICAgICAgICAgICAgICAgIC8vdXBkYXRlcyB0aGUgcmVzdXRscyAmIGZvcm0gaHRtbFxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlRm9ybShkYXRhLCBkYXRhX3R5cGUpO1xuXG5cbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XG4gICAgICAgICAgICAgICAgZGF0YS50ZXh0U3RhdHVzID0gdGV4dFN0YXR1cztcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgWyBkYXRhIF0pO1xuXG4gICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xuXG4gICAgICAgICAgICAgICAgJHRoaXMucmVtb3ZlQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XG5cbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmb3JtZmluaXNoXCIsIFsgZGF0YSBdKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuY29weUxpc3RJdGVtc0NvbnRlbnRzID0gZnVuY3Rpb24oJGxpc3RfZnJvbSwgJGxpc3RfdG8pXG4gICAgICAgIHtcbiAgICAgICAgICAgIC8vY29weSBvdmVyIGNoaWxkIGxpc3QgaXRlbXNcbiAgICAgICAgICAgIHZhciBsaV9jb250ZW50c19hcnJheSA9IG5ldyBBcnJheSgpO1xuICAgICAgICAgICAgdmFyIGZyb21fYXR0cmlidXRlcyA9IG5ldyBBcnJheSgpO1xuXG4gICAgICAgICAgICB2YXIgJGZyb21fZmllbGRzID0gJGxpc3RfZnJvbS5maW5kKFwiPiB1bCA+IGxpXCIpO1xuXG4gICAgICAgICAgICAkZnJvbV9maWVsZHMuZWFjaChmdW5jdGlvbihpKXtcblxuICAgICAgICAgICAgICAgIGxpX2NvbnRlbnRzX2FycmF5LnB1c2goJCh0aGlzKS5odG1sKCkpO1xuXG4gICAgICAgICAgICAgICAgdmFyIGF0dHJpYnV0ZXMgPSAkKHRoaXMpLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xuICAgICAgICAgICAgICAgIGZyb21fYXR0cmlidXRlcy5wdXNoKGF0dHJpYnV0ZXMpO1xuXG4gICAgICAgICAgICAgICAgLy92YXIgZmllbGRfbmFtZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcbiAgICAgICAgICAgICAgICAvL3ZhciB0b19maWVsZCA9ICRsaXN0X3RvLmZpbmQoXCI+IHVsID4gbGlbZGF0YS1zZi1maWVsZC1uYW1lPSdcIitmaWVsZF9uYW1lK1wiJ11cIik7XG5cbiAgICAgICAgICAgICAgICAvL3NlbGYuY29weUF0dHJpYnV0ZXMoJCh0aGlzKSwgJGxpc3RfdG8sIFwiZGF0YS1zZi1cIik7XG5cbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICB2YXIgbGlfaXQgPSAwO1xuICAgICAgICAgICAgdmFyICR0b19maWVsZHMgPSAkbGlzdF90by5maW5kKFwiPiB1bCA+IGxpXCIpO1xuICAgICAgICAgICAgJHRvX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGkpe1xuICAgICAgICAgICAgICAgICQodGhpcykuaHRtbChsaV9jb250ZW50c19hcnJheVtsaV9pdF0pO1xuXG4gICAgICAgICAgICAgICAgdmFyICRmcm9tX2ZpZWxkID0gJCgkZnJvbV9maWVsZHMuZ2V0KGxpX2l0KSk7XG5cbiAgICAgICAgICAgICAgICB2YXIgJHRvX2ZpZWxkID0gJCh0aGlzKTtcbiAgICAgICAgICAgICAgICAkdG9fZmllbGQucmVtb3ZlQXR0cihcImRhdGEtc2YtdGF4b25vbXktYXJjaGl2ZVwiKTtcbiAgICAgICAgICAgICAgICBzZWxmLmNvcHlBdHRyaWJ1dGVzKCRmcm9tX2ZpZWxkLCAkdG9fZmllbGQpO1xuXG4gICAgICAgICAgICAgICAgbGlfaXQrKztcbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAvKnZhciAkZnJvbV9maWVsZHMgPSAkbGlzdF9mcm9tLmZpbmQoXCIgdWwgPiBsaVwiKTtcbiAgICAgICAgICAgICB2YXIgJHRvX2ZpZWxkcyA9ICRsaXN0X3RvLmZpbmQoXCIgPiBsaVwiKTtcbiAgICAgICAgICAgICAkZnJvbV9maWVsZHMuZWFjaChmdW5jdGlvbihpbmRleCwgdmFsKXtcbiAgICAgICAgICAgICBpZigkKHRoaXMpLmhhc0F0dHJpYnV0ZShcImRhdGEtc2YtdGF4b25vbXktYXJjaGl2ZVwiKSlcbiAgICAgICAgICAgICB7XG5cbiAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzKCRsaXN0X2Zyb20sICRsaXN0X3RvKTsqL1xuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy51cGRhdGVGb3JtQXR0cmlidXRlcyA9IGZ1bmN0aW9uKCRsaXN0X2Zyb20sICRsaXN0X3RvKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gJGxpc3RfZnJvbS5wcm9wKFwiYXR0cmlidXRlc1wiKTtcbiAgICAgICAgICAgIC8vIGxvb3AgdGhyb3VnaCA8c2VsZWN0PiBhdHRyaWJ1dGVzIGFuZCBhcHBseSB0aGVtIG9uIDxkaXY+XG5cbiAgICAgICAgICAgIHZhciB0b19hdHRyaWJ1dGVzID0gJGxpc3RfdG8ucHJvcChcImF0dHJpYnV0ZXNcIik7XG4gICAgICAgICAgICAkLmVhY2godG9fYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgJGxpc3RfdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICQuZWFjaChmcm9tX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICRsaXN0X3RvLmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzID0gZnVuY3Rpb24oJGZyb20sICR0bywgcHJlZml4KVxuICAgICAgICB7XG4gICAgICAgICAgICBpZih0eXBlb2YocHJlZml4KT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgcHJlZml4ID0gXCJcIjtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgdmFyIGZyb21fYXR0cmlidXRlcyA9ICRmcm9tLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xuXG4gICAgICAgICAgICB2YXIgdG9fYXR0cmlidXRlcyA9ICR0by5wcm9wKFwiYXR0cmlidXRlc1wiKTtcbiAgICAgICAgICAgICQuZWFjaCh0b19hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIGlmKHByZWZpeCE9XCJcIikge1xuICAgICAgICAgICAgICAgICAgICBpZiAodGhpcy5uYW1lLmluZGV4T2YocHJlZml4KSA9PSAwKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAkdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIC8vJHRvLnJlbW92ZUF0dHIodGhpcy5uYW1lKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgJC5lYWNoKGZyb21fYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgJHRvLmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5jb3B5Rm9ybUF0dHJpYnV0ZXMgPSBmdW5jdGlvbigkZnJvbSwgJHRvKVxuICAgICAgICB7XG4gICAgICAgICAgICAkdG8ucmVtb3ZlQXR0cihcImRhdGEtY3VycmVudC10YXhvbm9teS1hcmNoaXZlXCIpO1xuICAgICAgICAgICAgdGhpcy5jb3B5QXR0cmlidXRlcygkZnJvbSwgJHRvKTtcblxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy51cGRhdGVGb3JtID0gZnVuY3Rpb24oZGF0YSwgZGF0YV90eXBlKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZihkYXRhX3R5cGU9PVwianNvblwiKVxuICAgICAgICAgICAgey8vdGhlbiB3ZSBkaWQgYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50LCBzbyBleHBlY3QgYW4gb2JqZWN0IGJhY2tcblxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihkYXRhWydmb3JtJ10pIT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcblxuICAgICAgICAgICAgICAgICAgICAvL3JlZnJlc2ggdGhlIGZvcm0gKGF1dG8gY291bnQpXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUxpc3RJdGVtc0NvbnRlbnRzKCQoZGF0YVsnZm9ybSddKSwgJHRoaXMpO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vcmUgaW5pdCBTJkYgY2xhc3Mgb24gdGhlIGZvcm1cbiAgICAgICAgICAgICAgICAgICAgLy8kdGhpcy5zZWFyY2hBbmRGaWx0ZXIoKTtcblxuICAgICAgICAgICAgICAgICAgICAvL2lmIGFqYXggaXMgZW5hYmxlZCBpbml0IHRoZSBwYWdpbmF0aW9uXG5cbiAgICAgICAgICAgICAgICAgICAgdGhpcy5pbml0KHRydWUpO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5zZXR1cEFqYXhQYWdpbmF0aW9uKCk7XG4gICAgICAgICAgICAgICAgICAgIH1cblxuXG5cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cblxuICAgICAgICB9XG4gICAgICAgIHRoaXMuYWRkUmVzdWx0cyA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcbiAgICAgICAge1xuICAgICAgICAgICAgaWYoZGF0YV90eXBlPT1cImpzb25cIilcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXG4gICAgICAgICAgICAgICAgLy9ncmFiIHRoZSByZXN1bHRzIGFuZCBsb2FkIGluXG4gICAgICAgICAgICAgICAgLy9zZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmFwcGVuZChkYXRhWydyZXN1bHRzJ10pO1xuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSBkYXRhWydyZXN1bHRzJ107XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIGlmKGRhdGFfdHlwZT09XCJodG1sXCIpXG4gICAgICAgICAgICB7Ly93ZSBhcmUgZXhwZWN0aW5nIHRoZSBodG1sIG9mIHRoZSByZXN1bHRzIHBhZ2UgYmFjaywgc28gZXh0cmFjdCB0aGUgaHRtbCB3ZSBuZWVkXG4gICAgICAgICAgICAgICAgdmFyICRkYXRhX29iaiA9ICQoZGF0YSk7XG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICRkYXRhX29iai5maW5kKHNlbGYuYWpheF90YXJnZXRfYXR0cikuaHRtbCgpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB2YXIgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IGZhbHNlO1xuXG4gICAgICAgICAgICBpZigkKFwiPGRpdj5cIitzZWxmLmxvYWRfbW9yZV9odG1sK1wiPC9kaXY+XCIpLmZpbmQoXCJbZGF0YS1zZWFyY2gtZmlsdGVyLWFjdGlvbj0naW5maW5pdGUtc2Nyb2xsLWVuZCddXCIpLmxlbmd0aD4wKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGluZmluaXRlX3Njcm9sbF9lbmQgPSB0cnVlO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAvL2lmIHRoZXJlIGlzIGFub3RoZXIgc2VsZWN0b3IgZm9yIGluZmluaXRlIHNjcm9sbCwgZmluZCB0aGUgY29udGVudHMgb2YgdGhhdCBpbnN0ZWFkXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIhPVwiXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIpLmh0bWwoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgJHJlc3VsdF9pdGVtcyA9ICQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpO1xuICAgICAgICAgICAgICAgIHZhciAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lciA9ICQoJzxkaXYvPicsIHt9KTtcbiAgICAgICAgICAgICAgICAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lci5hcHBlbmQoJHJlc3VsdF9pdGVtcyk7XG5cbiAgICAgICAgICAgICAgICBzZWxmLmxvYWRfbW9yZV9odG1sID0gJHJlc3VsdF9pdGVtc19jb250YWluZXIuaHRtbCgpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZihpbmZpbml0ZV9zY3JvbGxfZW5kKVxuICAgICAgICAgICAgey8vd2UgZm91bmQgYSBkYXRhIGF0dHJpYnV0ZSBzaWduYWxsaW5nIHRoZSBsYXN0IHBhZ2Ugc28gZmluaXNoIGhlcmVcblxuICAgICAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBzZWxmLmxvYWRfbW9yZV9odG1sO1xuXG4gICAgICAgICAgICAgICAgc2VsZi5pbmZpbml0ZVNjcm9sbEFwcGVuZChzZWxmLmxvYWRfbW9yZV9odG1sKTtcblxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwhPT1zZWxmLmxvYWRfbW9yZV9odG1sKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIC8vY2hlY2sgdG8gbWFrZSBzdXJlIHRoZSBuZXcgaHRtbCBmZXRjaGVkIGlzIGRpZmZlcmVudFxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9sb2FkX21vcmVfaHRtbCA9IHNlbGYubG9hZF9tb3JlX2h0bWw7XG4gICAgICAgICAgICAgICAgc2VsZi5pbmZpbml0ZVNjcm9sbEFwcGVuZChzZWxmLmxvYWRfbW9yZV9odG1sKTtcblxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgey8vd2UgcmVjZWl2ZWQgdGhlIHNhbWUgbWVzc2FnZSBhZ2FpbiBzbyBkb24ndCBhZGQsIGFuZCB0ZWxsIFMmRiB0aGF0IHdlJ3JlIGF0IHRoZSBlbmQuLlxuICAgICAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gdHJ1ZTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG5cbiAgICAgICAgdGhpcy5pbmZpbml0ZVNjcm9sbEFwcGVuZCA9IGZ1bmN0aW9uKCRvYmplY3QpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKS5sYXN0KCkuYWZ0ZXIoJG9iamVjdCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmFwcGVuZCgkb2JqZWN0KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG5cbiAgICAgICAgdGhpcy51cGRhdGVSZXN1bHRzID0gZnVuY3Rpb24oZGF0YSwgZGF0YV90eXBlKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZihkYXRhX3R5cGU9PVwianNvblwiKVxuICAgICAgICAgICAgey8vdGhlbiB3ZSBkaWQgYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50LCBzbyBleHBlY3QgYW4gb2JqZWN0IGJhY2tcbiAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJlc3VsdHMgYW5kIGxvYWQgaW5cbiAgICAgICAgICAgICAgICB0aGlzLnJlc3VsdHNfaHRtbCA9IGRhdGFbJ3Jlc3VsdHMnXTtcblxuICAgICAgICAgICAgICAgIGlmICggdGhpcy5yZXBsYWNlX3Jlc3VsdHMgKSB7XG4gICAgICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuaHRtbCh0aGlzLnJlc3VsdHNfaHRtbCk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKGRhdGFbJ2Zvcm0nXSkhPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgYWxsIGV2ZW50cyBmcm9tIFMmRiBmb3JtXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLm9mZigpO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIHBhZ2luYXRpb25cbiAgICAgICAgICAgICAgICAgICAgc2VsZi5yZW1vdmVBamF4UGFnaW5hdGlvbigpO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vcmVmcmVzaCB0aGUgZm9ybSAoYXV0byBjb3VudClcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5TGlzdEl0ZW1zQ29udGVudHMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XG5cbiAgICAgICAgICAgICAgICAgICAgLy91cGRhdGUgYXR0cmlidXRlcyBvbiBmb3JtXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUZvcm1BdHRyaWJ1dGVzKCQoZGF0YVsnZm9ybSddKSwgJHRoaXMpO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vcmUgaW5pdCBTJkYgY2xhc3Mgb24gdGhlIGZvcm1cbiAgICAgICAgICAgICAgICAgICAgJHRoaXMuc2VhcmNoQW5kRmlsdGVyKHsnaXNJbml0JzogZmFsc2V9KTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgLy8kdGhpcy5maW5kKFwiaW5wdXRcIikucmVtb3ZlQXR0cihcImRpc2FibGVkXCIpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYoZGF0YV90eXBlPT1cImh0bWxcIikgey8vd2UgYXJlIGV4cGVjdGluZyB0aGUgaHRtbCBvZiB0aGUgcmVzdWx0cyBwYWdlIGJhY2ssIHNvIGV4dHJhY3QgdGhlIGh0bWwgd2UgbmVlZFxuXG4gICAgICAgICAgICAgICAgdmFyICRkYXRhX29iaiA9ICQoZGF0YSk7XG4gICAgICAgICAgICAgICAgdGhpcy5yZXN1bHRzX3BhZ2VfaHRtbCA9IGRhdGE7XG4gICAgICAgICAgICAgICAgdGhpcy5yZXN1bHRzX2h0bWwgPSAkZGF0YV9vYmouZmluZCggdGhpcy5hamF4X3RhcmdldF9hdHRyICkuaHRtbCgpO1xuXG4gICAgICAgICAgICAgICAgaWYgKCB0aGlzLnJlcGxhY2VfcmVzdWx0cyApIHtcbiAgICAgICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5odG1sKHRoaXMucmVzdWx0c19odG1sKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBzZWxmLnVwZGF0ZUNvbnRlbnRBcmVhcyggJGRhdGFfb2JqICk7XG5cbiAgICAgICAgICAgICAgICBpZiAoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlclwiKS5sZW5ndGggPiAwKVxuICAgICAgICAgICAgICAgIHsvL3RoZW4gdGhlcmUgYXJlIHNlYXJjaCBmb3JtKHMpIGluc2lkZSB0aGUgcmVzdWx0cyBjb250YWluZXIsIHNvIHJlLWluaXQgdGhlbVxuXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJcIikuc2VhcmNoQW5kRmlsdGVyKCk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgLy9pZiB0aGUgY3VycmVudCBzZWFyY2ggZm9ybSBpcyBub3QgaW5zaWRlIHRoZSByZXN1bHRzIGNvbnRhaW5lciwgdGhlbiBwcm9jZWVkIGFzIG5vcm1hbCBhbmQgdXBkYXRlIHRoZSBmb3JtXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiICsgc2VsZi5zZmlkICsgXCInXVwiKS5sZW5ndGg9PTApIHtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgJG5ld19zZWFyY2hfZm9ybSA9ICRkYXRhX29iai5maW5kKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiICsgc2VsZi5zZmlkICsgXCInXVwiKTtcblxuICAgICAgICAgICAgICAgICAgICBpZiAoJG5ld19zZWFyY2hfZm9ybS5sZW5ndGggPT0gMSkgey8vdGhlbiByZXBsYWNlIHRoZSBzZWFyY2ggZm9ybSB3aXRoIHRoZSBuZXcgb25lXG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMub2ZmKCk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIHBhZ2luYXRpb25cbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYucmVtb3ZlQWpheFBhZ2luYXRpb24oKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5TGlzdEl0ZW1zQ29udGVudHMoJG5ld19zZWFyY2hfZm9ybSwgJHRoaXMpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3VwZGF0ZSBhdHRyaWJ1dGVzIG9uIGZvcm1cbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUZvcm1BdHRyaWJ1dGVzKCRuZXdfc2VhcmNoX2Zvcm0sICR0aGlzKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMuc2VhcmNoQW5kRmlsdGVyKHsnaXNJbml0JzogZmFsc2V9KTtcblxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLmZpbmQoXCJpbnB1dFwiKS5yZW1vdmVBdHRyKFwiZGlzYWJsZWRcIik7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gZmFsc2U7IC8vZm9yIGluZmluaXRlIHNjcm9sbFxuICAgICAgICAgICAgc2VsZi5jdXJyZW50X3BhZ2VkID0gMTsgLy9mb3IgaW5maW5pdGUgc2Nyb2xsXG4gICAgICAgICAgICBzZWxmLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyKCk7XG5cbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMudXBkYXRlQ29udGVudEFyZWFzID0gZnVuY3Rpb24oICRodG1sX2RhdGEgKSB7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIC8vIGFkZCBhZGRpdGlvbmFsIGNvbnRlbnQgYXJlYXNcbiAgICAgICAgICAgIGlmICggdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucyAmJiB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zLmxlbmd0aCApIHtcbiAgICAgICAgICAgICAgICBmb3IgKGluZGV4ID0gMDsgaW5kZXggPCB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zLmxlbmd0aDsgKytpbmRleCkge1xuICAgICAgICAgICAgICAgICAgICB2YXIgc2VsZWN0b3IgPSB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zW2luZGV4XTtcbiAgICAgICAgICAgICAgICAgICAgJCggc2VsZWN0b3IgKS5odG1sKCAkaHRtbF9kYXRhLmZpbmQoIHNlbGVjdG9yICkuaHRtbCgpICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIHRoaXMuZmFkZUNvbnRlbnRBcmVhcyA9IGZ1bmN0aW9uKCBkaXJlY3Rpb24gKSB7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIHZhciBvcGFjaXR5ID0gMC41O1xuICAgICAgICAgICAgaWYgKCBkaXJlY3Rpb24gPT09IFwiaW5cIiApIHtcbiAgICAgICAgICAgICAgICBvcGFjaXR5ID0gMTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYgKCB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zICYmIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoICkge1xuICAgICAgICAgICAgICAgIGZvciAoaW5kZXggPSAwOyBpbmRleCA8IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoOyArK2luZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciBzZWxlY3RvciA9IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnNbaW5kZXhdO1xuICAgICAgICAgICAgICAgICAgICAkKCBzZWxlY3RvciApLnN0b3AodHJ1ZSx0cnVlKS5hbmltYXRlKCB7IG9wYWNpdHk6IG9wYWNpdHl9LCBcImZhc3RcIiApO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgXG4gICAgICAgICAgICBcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMucmVtb3ZlV29vQ29tbWVyY2VDb250cm9scyA9IGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5ID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nIC5vcmRlcmJ5Jyk7XG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5X2Zvcm0gPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcnKTtcblxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5X2Zvcm0ub2ZmKCk7XG4gICAgICAgICAgICAkd29vX29yZGVyYnkub2ZmKCk7XG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5hZGRRdWVyeVBhcmFtID0gZnVuY3Rpb24obmFtZSwgdmFsdWUsIHVybF90eXBlKXtcblxuICAgICAgICAgICAgaWYodHlwZW9mKHVybF90eXBlKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgdXJsX3R5cGUgPSBcImFsbFwiO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNbdXJsX3R5cGVdW25hbWVdID0gdmFsdWU7XG5cbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmluaXRXb29Db21tZXJjZUNvbnRyb2xzID0gZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgc2VsZi5yZW1vdmVXb29Db21tZXJjZUNvbnRyb2xzKCk7XG5cbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnkgPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcgLm9yZGVyYnknKTtcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnlfZm9ybSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZycpO1xuXG4gICAgICAgICAgICB2YXIgb3JkZXJfdmFsID0gXCJcIjtcbiAgICAgICAgICAgIGlmKCR3b29fb3JkZXJieS5sZW5ndGg+MClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSAkd29vX29yZGVyYnkudmFsKCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgb3JkZXJfdmFsID0gc2VsZi5nZXRRdWVyeVBhcmFtRnJvbVVSTChcIm9yZGVyYnlcIiwgd2luZG93LmxvY2F0aW9uLmhyZWYpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZihvcmRlcl92YWw9PVwibWVudV9vcmRlclwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9IFwiXCI7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmKChvcmRlcl92YWwhPVwiXCIpJiYoISFvcmRlcl92YWwpKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zLmFsbC5vcmRlcmJ5ID0gb3JkZXJfdmFsO1xuICAgICAgICAgICAgfVxuXG5cbiAgICAgICAgICAgICR3b29fb3JkZXJieV9mb3JtLm9uKCdzdWJtaXQnLCBmdW5jdGlvbihlKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICAgICAgICAvL3ZhciBmb3JtID0gZS50YXJnZXQ7XG4gICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICR3b29fb3JkZXJieS5vbihcImNoYW5nZVwiLCBmdW5jdGlvbihlKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcblxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSAkKHRoaXMpLnZhbCgpO1xuICAgICAgICAgICAgICAgIGlmKHZhbD09XCJtZW51X29yZGVyXCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICB2YWwgPSBcIlwiO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zLmFsbC5vcmRlcmJ5ID0gdmFsO1xuXG4gICAgICAgICAgICAgICAgJHRoaXMudHJpZ2dlcihcInN1Ym1pdFwiKVxuXG4gICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuc2Nyb2xsUmVzdWx0cyA9IGZ1bmN0aW9uKClcbiAgICAgICAge1xuICAgICAgICAgICAgaWYoKHNlbGYuc2Nyb2xsX29uX2FjdGlvbj09c2VsZi5hamF4X2FjdGlvbil8fChzZWxmLnNjcm9sbF9vbl9hY3Rpb249PVwiYWxsXCIpKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHNlbGYuc2Nyb2xsVG9Qb3MoKTsgLy9zY3JvbGwgdGhlIHdpbmRvdyBpZiBpdCBoYXMgYmVlbiBzZXRcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9hY3Rpb24gPSBcIlwiO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy51cGRhdGVVcmxIaXN0b3J5ID0gZnVuY3Rpb24oYWpheF9yZXN1bHRzX3VybClcbiAgICAgICAge1xuICAgICAgICAgICAgdmFyIHVzZV9oaXN0b3J5X2FwaSA9IDA7XG4gICAgICAgICAgICBpZiAod2luZG93Lmhpc3RvcnkgJiYgd2luZG93Lmhpc3RvcnkucHVzaFN0YXRlKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHVzZV9oaXN0b3J5X2FwaSA9ICR0aGlzLmF0dHIoXCJkYXRhLXVzZS1oaXN0b3J5LWFwaVwiKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYoKHNlbGYudXBkYXRlX2FqYXhfdXJsPT0xKSYmKHVzZV9oaXN0b3J5X2FwaT09MSkpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgLy9ub3cgY2hlY2sgaWYgdGhlIGJyb3dzZXIgc3VwcG9ydHMgaGlzdG9yeSBzdGF0ZSBwdXNoIDopXG4gICAgICAgICAgICAgICAgaWYgKHdpbmRvdy5oaXN0b3J5ICYmIHdpbmRvdy5oaXN0b3J5LnB1c2hTdGF0ZSlcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGhpc3RvcnkucHVzaFN0YXRlKG51bGwsIG51bGwsIGFqYXhfcmVzdWx0c191cmwpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgICB0aGlzLnJlbW92ZUFqYXhQYWdpbmF0aW9uID0gZnVuY3Rpb24oKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZih0eXBlb2Yoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKSE9XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgJGFqYXhfbGlua3Nfb2JqZWN0ID0galF1ZXJ5KHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XG5cbiAgICAgICAgICAgICAgICBpZigkYWpheF9saW5rc19vYmplY3QubGVuZ3RoPjApXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAkYWpheF9saW5rc19vYmplY3Qub2ZmKCk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5nZXRCYXNlVXJsID0gZnVuY3Rpb24oIHVybCApIHtcbiAgICAgICAgICAgIC8vbm93IHNlZSBpZiB3ZSBhcmUgb24gdGhlIFVSTCB3ZSB0aGluay4uLlxuICAgICAgICAgICAgdmFyIHVybF9wYXJ0cyA9IHVybC5zcGxpdChcIj9cIik7XG4gICAgICAgICAgICB2YXIgdXJsX2Jhc2UgPSBcIlwiO1xuXG4gICAgICAgICAgICBpZih1cmxfcGFydHMubGVuZ3RoPjApXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSB1cmxfcGFydHNbMF07XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybDtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHJldHVybiB1cmxfYmFzZTtcbiAgICAgICAgfVxuICAgICAgICB0aGlzLmNhbkZldGNoQWpheFJlc3VsdHMgPSBmdW5jdGlvbihmZXRjaF90eXBlKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZih0eXBlb2YoZmV0Y2hfdHlwZSk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGZldGNoX3R5cGUgPSBcIlwiO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB2YXIgZmV0Y2hfYWpheF9yZXN1bHRzID0gZmFsc2U7XG5cbiAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2lsbCBhamF4IHN1Ym1pdCB0aGUgZm9ybVxuXG4gICAgICAgICAgICAgICAgLy9hbmQgaWYgd2UgY2FuIGZpbmQgdGhlIHJlc3VsdHMgY29udGFpbmVyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg9PTEpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHNlbGYucmVzdWx0c191cmw7ICAvL1xuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybF9lbmNvZGVkID0gJyc7ICAvL1xuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3VybCA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmO1xuXG4gICAgICAgICAgICAgICAgLy9pZ25vcmUgIyBhbmQgZXZlcnl0aGluZyBhZnRlclxuICAgICAgICAgICAgICAgIHZhciBoYXNoX3BvcyA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmLmluZGV4T2YoJyMnKTtcbiAgICAgICAgICAgICAgICBpZihoYXNoX3BvcyE9PS0xKXtcbiAgICAgICAgICAgICAgICAgICAgY3VycmVudF91cmwgPSB3aW5kb3cubG9jYXRpb24uaHJlZi5zdWJzdHIoMCwgd2luZG93LmxvY2F0aW9uLmhyZWYuaW5kZXhPZignIycpKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBpZiggKCAoIHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cImN1c3RvbV93b29jb21tZXJjZV9zdG9yZVwiICkgfHwgKCBzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJwb3N0X3R5cGVfYXJjaGl2ZVwiICkgKSAmJiAoIHNlbGYuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID09IDEgKSApXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZiggc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgIT09XCJcIiApXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmV0Y2hfYWpheF9yZXN1bHRzO1xuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgLyp2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcbiAgICAgICAgICAgICAgICAgICAgIHZhciBhY3RpdmVfdGF4ID0gcHJvY2Vzc19mb3JtLmdldEFjdGl2ZVRheCgpO1xuICAgICAgICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUsICcnLCBhY3RpdmVfdGF4KTsqL1xuICAgICAgICAgICAgICAgIH1cblxuXG5cblxuICAgICAgICAgICAgICAgIC8vbm93IHNlZSBpZiB3ZSBhcmUgb24gdGhlIFVSTCB3ZSB0aGluay4uLlxuICAgICAgICAgICAgICAgIHZhciB1cmxfYmFzZSA9IHRoaXMuZ2V0QmFzZVVybCggY3VycmVudF91cmwgKTtcbiAgICAgICAgICAgICAgICAvL3ZhciByZXN1bHRzX3VybF9iYXNlID0gdGhpcy5nZXRCYXNlVXJsKCBjdXJyZW50X3VybCApO1xuXG4gICAgICAgICAgICAgICAgdmFyIGxhbmcgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwibGFuZ1wiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XG4gICAgICAgICAgICAgICAgaWYoKHR5cGVvZihsYW5nKSE9PVwidW5kZWZpbmVkXCIpJiYobGFuZyE9PW51bGwpKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSBzZWxmLmFkZFVybFBhcmFtKHVybF9iYXNlLCBcImxhbmc9XCIrbGFuZyk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgdmFyIHNmaWQgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwic2ZpZFwiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XG5cbiAgICAgICAgICAgICAgICAvL2lmIHNmaWQgaXMgYSBudW1iZXJcbiAgICAgICAgICAgICAgICBpZihOdW1iZXIocGFyc2VGbG9hdChzZmlkKSkgPT0gc2ZpZClcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHVybF9iYXNlID0gc2VsZi5hZGRVcmxQYXJhbSh1cmxfYmFzZSwgXCJzZmlkPVwiK3NmaWQpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIC8vaWYgYW55IG9mIHRoZSAzIGNvbmRpdGlvbnMgYXJlIHRydWUsIHRoZW4gaXRzIGdvb2QgdG8gZ29cbiAgICAgICAgICAgICAgICAvLyAtIDEgfCBpZiB0aGUgdXJsIGJhc2UgPT0gcmVzdWx0c191cmxcbiAgICAgICAgICAgICAgICAvLyAtIDIgfCBpZiB1cmwgYmFzZSsgXCIvXCIgID09IHJlc3VsdHNfdXJsIC0gaW4gY2FzZSBvZiB1c2VyIGVycm9yIGluIHRoZSByZXN1bHRzIFVSTFxuICAgICAgICAgICAgICAgIC8vIC0gMyB8IGlmIHRoZSByZXN1bHRzIFVSTCBoYXMgdXJsIHBhcmFtcywgYW5kIHRoZSBjdXJyZW50IHVybCBzdGFydHMgd2l0aCB0aGUgcmVzdWx0cyBVUkwgXG5cbiAgICAgICAgICAgICAgICAvL3RyaW0gYW55IHRyYWlsaW5nIHNsYXNoIGZvciBlYXNpZXIgY29tcGFyaXNvbjpcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9iYXNlLnJlcGxhY2UoL1xcLyQvLCAnJyk7XG4gICAgICAgICAgICAgICAgcmVzdWx0c191cmwgPSByZXN1bHRzX3VybC5yZXBsYWNlKC9cXC8kLywgJycpO1xuICAgICAgICAgICAgICAgIHJlc3VsdHNfdXJsX2VuY29kZWQgPSBlbmNvZGVVUkkocmVzdWx0c191cmwpO1xuICAgICAgICAgICAgICAgIFxuXG4gICAgICAgICAgICAgICAgdmFyIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID0gLTE7XG4gICAgICAgICAgICAgICAgaWYoKHVybF9iYXNlPT1yZXN1bHRzX3VybCl8fCh1cmxfYmFzZS50b0xvd2VyQ2FzZSgpPT1yZXN1bHRzX3VybF9lbmNvZGVkLnRvTG93ZXJDYXNlKCkpICApe1xuICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IDE7XG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKCByZXN1bHRzX3VybC5pbmRleE9mKCAnPycgKSAhPT0gLTEgJiYgY3VycmVudF91cmwubGFzdEluZGV4T2YocmVzdWx0c191cmwsIDApID09PSAwICkge1xuICAgICAgICAgICAgICAgICAgICAgICAgY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPSAxO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5vbmx5X3Jlc3VsdHNfYWpheD09MSlcbiAgICAgICAgICAgICAgICB7Ly9pZiBhIHVzZXIgaGFzIGNob3NlbiB0byBvbmx5IGFsbG93IGFqYXggb24gcmVzdWx0cyBwYWdlcyAoZGVmYXVsdCBiZWhhdmlvdXIpXG5cbiAgICAgICAgICAgICAgICAgICAgaWYoIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID4gLTEpXG4gICAgICAgICAgICAgICAgICAgIHsvL3RoaXMgbWVhbnMgdGhlIGN1cnJlbnQgVVJMIGNvbnRhaW5zIHRoZSByZXN1bHRzIHVybCwgd2hpY2ggbWVhbnMgd2UgY2FuIGRvIGFqYXhcbiAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZihmZXRjaF90eXBlPT1cInBhZ2luYXRpb25cIilcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYoIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID4gLTEpXG4gICAgICAgICAgICAgICAgICAgICAgICB7Ly90aGlzIG1lYW5zIHRoZSBjdXJyZW50IFVSTCBjb250YWlucyB0aGUgcmVzdWx0cyB1cmwsIHdoaWNoIG1lYW5zIHdlIGNhbiBkbyBhamF4XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL2Rvbid0IGFqYXggcGFnaW5hdGlvbiB3aGVuIG5vdCBvbiBhIFMmRiBwYWdlXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cblxuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHJldHVybiBmZXRjaF9hamF4X3Jlc3VsdHM7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLnNldHVwQWpheFBhZ2luYXRpb24gPSBmdW5jdGlvbigpXG4gICAgICAgIHtcbiAgICAgICAgICAgIC8vaW5maW5pdGUgc2Nyb2xsXG4gICAgICAgICAgICBpZih0aGlzLnBhZ2luYXRpb25fdHlwZT09PVwiaW5maW5pdGVfc2Nyb2xsXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGluZmluaXRlX3Njcm9sbF9lbmQgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCJbZGF0YS1zZWFyY2gtZmlsdGVyLWFjdGlvbj0naW5maW5pdGUtc2Nyb2xsLWVuZCddXCIpLmxlbmd0aD4wKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBpZihwYXJzZUludCh0aGlzLmluc3RhbmNlX251bWJlcik9PT0xKSB7XG4gICAgICAgICAgICAgICAgICAgICQod2luZG93KS5vZmYoXCJzY3JvbGxcIiwgc2VsZi5vbldpbmRvd1Njcm9sbCk7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKHNlbGYuY2FuRmV0Y2hBamF4UmVzdWx0cyhcInBhZ2luYXRpb25cIikpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICQod2luZG93KS5vbihcInNjcm9sbFwiLCBzZWxmLm9uV2luZG93U2Nyb2xsKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYodHlwZW9mKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik9PVwidW5kZWZpbmVkXCIpIHtcbiAgICAgICAgICAgICAgICByZXR1cm47XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vZmYoJ2NsaWNrJywgc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vZmYoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcbiAgICAgICAgICAgICAgICAkKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcikub2ZmKCk7XG5cbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vbignY2xpY2snLCBzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IsIGZ1bmN0aW9uKGUpe1xuXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuY2FuRmV0Y2hBamF4UmVzdWx0cyhcInBhZ2luYXRpb25cIikpXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGxpbmsgPSBqUXVlcnkodGhpcykuYXR0cignaHJlZicpO1xuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5hamF4X2FjdGlvbiA9IFwicGFnaW5hdGlvblwiO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuZ2V0UGFnZWRGcm9tVVJMKGxpbmspO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIsIHBhZ2VOdW1iZXIpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZldGNoQWpheFJlc3VsdHMoKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5nZXRQYWdlZEZyb21VUkwgPSBmdW5jdGlvbihVUkwpe1xuXG4gICAgICAgICAgICB2YXIgcGFnZWRWYWwgPSAxO1xuICAgICAgICAgICAgLy9maXJzdCB0ZXN0IHRvIHNlZSBpZiB3ZSBoYXZlIFwiL3BhZ2UvNC9cIiBpbiB0aGUgVVJMXG4gICAgICAgICAgICB2YXIgdHBWYWwgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwic2ZfcGFnZWRcIiwgVVJMKTtcbiAgICAgICAgICAgIGlmKCh0eXBlb2YodHBWYWwpPT1cInN0cmluZ1wiKXx8KHR5cGVvZih0cFZhbCk9PVwibnVtYmVyXCIpKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHBhZ2VkVmFsID0gdHBWYWw7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHJldHVybiBwYWdlZFZhbDtcbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMID0gZnVuY3Rpb24obmFtZSwgVVJMKXtcblxuICAgICAgICAgICAgdmFyIHFzdHJpbmcgPSBcIj9cIitVUkwuc3BsaXQoJz8nKVsxXTtcbiAgICAgICAgICAgIGlmKHR5cGVvZihxc3RyaW5nKSE9XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gZGVjb2RlVVJJQ29tcG9uZW50KChuZXcgUmVnRXhwKCdbP3wmXScgKyBuYW1lICsgJz0nICsgJyhbXiY7XSs/KSgmfCN8O3wkKScpLmV4ZWMocXN0cmluZyl8fFssXCJcIl0pWzFdLnJlcGxhY2UoL1xcKy9nLCAnJTIwJykpfHxudWxsO1xuICAgICAgICAgICAgICAgIHJldHVybiB2YWw7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICByZXR1cm4gXCJcIjtcbiAgICAgICAgfTtcblxuXG5cbiAgICAgICAgdGhpcy5mb3JtVXBkYXRlZCA9IGZ1bmN0aW9uKGUpe1xuXG4gICAgICAgICAgICAvL2UucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICAgIGlmKHNlbGYuYXV0b191cGRhdGU9PTEpIHtcbiAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYoKHNlbGYuYXV0b191cGRhdGU9PTApJiYoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5mb3JtVXBkYXRlZEZldGNoQWpheCgpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5mb3JtVXBkYXRlZEZldGNoQWpheCA9IGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgIC8vbG9vcCB0aHJvdWdoIGFsbCB0aGUgZmllbGRzIGFuZCBidWlsZCB0aGUgVVJMXG4gICAgICAgICAgICBzZWxmLmZldGNoQWpheEZvcm0oKTtcblxuXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH07XG5cbiAgICAgICAgLy9tYWtlIGFueSBjb3JyZWN0aW9ucy91cGRhdGVzIHRvIGZpZWxkcyBiZWZvcmUgdGhlIHN1Ym1pdCBjb21wbGV0ZXNcbiAgICAgICAgdGhpcy5zZXRGaWVsZHMgPSBmdW5jdGlvbihlKXtcblxuICAgICAgICAgICAgLy9zb21ldGltZXMgdGhlIGZvcm0gaXMgc3VibWl0dGVkIHdpdGhvdXQgdGhlIHNsaWRlciB5ZXQgaGF2aW5nIHVwZGF0ZWQsIGFuZCBhcyB3ZSBnZXQgb3VyIHZhbHVlcyBmcm9tXG4gICAgICAgICAgICAvL3RoZSBzbGlkZXIgYW5kIG5vdCBpbnB1dHMsIHdlIG5lZWQgdG8gY2hlY2sgaXQgaWYgbmVlZHMgdG8gYmUgc2V0XG4gICAgICAgICAgICAvL29ubHkgb2NjdXJzIGlmIGFqYXggaXMgb2ZmLCBhbmQgYXV0b3N1Ym1pdCBvblxuICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgICAgICAgICB2YXIgJGZpZWxkID0gJCh0aGlzKTtcblxuICAgICAgICAgICAgICAgIHZhciByYW5nZV9kaXNwbGF5X3ZhbHVlcyA9ICRmaWVsZC5maW5kKCcuc2YtbWV0YS1yYW5nZS1zbGlkZXInKS5hdHRyKFwiZGF0YS1kaXNwbGF5LXZhbHVlcy1hc1wiKTsvL2RhdGEtZGlzcGxheS12YWx1ZXMtYXM9XCJ0ZXh0XCJcblxuICAgICAgICAgICAgICAgIGlmKHJhbmdlX2Rpc3BsYXlfdmFsdWVzPT09XCJ0ZXh0aW5wdXRcIikge1xuXG4gICAgICAgICAgICAgICAgICAgIGlmKCRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmxlbmd0aD4wKXtcblxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmVhY2goZnVuY3Rpb24gKGluZGV4KSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfb2JqZWN0ID0gJCh0aGlzKVswXTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkc2xpZGVyX2VsID0gJCh0aGlzKS5jbG9zZXN0KFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG1pblZhbCA9ICRzbGlkZXJfZWwuZmluZChcIi5zZi1yYW5nZS1taW5cIikudmFsKCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgbWF4VmFsID0gJHNsaWRlcl9lbC5maW5kKFwiLnNmLXJhbmdlLW1heFwiKS52YWwoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoW21pblZhbCwgbWF4VmFsXSk7XG5cbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgfVxuXG4gICAgICAgIC8vc3VibWl0XG4gICAgICAgIHRoaXMuc3VibWl0Rm9ybSA9IGZ1bmN0aW9uKGUpe1xuXG4gICAgICAgICAgICAvL2xvb3AgdGhyb3VnaCBhbGwgdGhlIGZpZWxkcyBhbmQgYnVpbGQgdGhlIFVSTFxuICAgICAgICAgICAgaWYoc2VsZi5pc1N1Ym1pdHRpbmcgPT0gdHJ1ZSkge1xuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgc2VsZi5zZXRGaWVsZHMoKTtcbiAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpO1xuXG4gICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IHRydWU7XG5cbiAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcblxuICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiLCAxKTsgLy9pbml0IHBhZ2VkXG5cbiAgICAgICAgICAgIGlmKHNlbGYuY2FuRmV0Y2hBamF4UmVzdWx0cygpKVxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIGFqYXggc3VibWl0IHRoZSBmb3JtXG5cbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gXCJzdWJtaXRcIjsgLy9zbyB3ZSBrbm93IGl0IHdhc24ndCBwYWdpbmF0aW9uXG4gICAgICAgICAgICAgICAgc2VsZi5mZXRjaEFqYXhSZXN1bHRzKCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgc2ltcGx5IHJlZGlyZWN0IHRvIHRoZSBSZXN1bHRzIFVSTFxuXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XG4gICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUsICcnKTtcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybCA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XG5cbiAgICAgICAgICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9IHJlc3VsdHNfdXJsO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH07XG4gICAgICAgIHRoaXMucmVzZXRGb3JtID0gZnVuY3Rpb24oc3VibWl0X2Zvcm0pXG4gICAgICAgIHtcbiAgICAgICAgICAgIC8vdW5zZXQgYWxsIGZpZWxkc1xuICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgIHZhciAkZmllbGQgPSAkKHRoaXMpO1xuICAgICAgICAgICAgICAgIFxuXHRcdFx0XHQkZmllbGQucmVtb3ZlQXR0cihcImRhdGEtc2YtdGF4b25vbXktYXJjaGl2ZVwiKTtcblx0XHRcdFx0XG4gICAgICAgICAgICAgICAgLy9zdGFuZGFyZCBmaWVsZCB0eXBlc1xuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwic2VsZWN0Om5vdChbbXVsdGlwbGU9J211bHRpcGxlJ10pID4gb3B0aW9uOmZpcnN0LWNoaWxkXCIpLnByb3AoXCJzZWxlY3RlZFwiLCB0cnVlKTtcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcInNlbGVjdFttdWx0aXBsZT0nbXVsdGlwbGUnXSA+IG9wdGlvblwiKS5wcm9wKFwic2VsZWN0ZWRcIiwgZmFsc2UpO1xuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiaW5wdXRbdHlwZT0nY2hlY2tib3gnXVwiKS5wcm9wKFwiY2hlY2tlZFwiLCBmYWxzZSk7XG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCI+IHVsID4gbGk6Zmlyc3QtY2hpbGQgaW5wdXRbdHlwZT0ncmFkaW8nXVwiKS5wcm9wKFwiY2hlY2tlZFwiLCB0cnVlKTtcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcImlucHV0W3R5cGU9J3RleHQnXVwiKS52YWwoXCJcIik7XG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCIuc2Ytb3B0aW9uLWFjdGl2ZVwiKS5yZW1vdmVDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCI+IHVsID4gbGk6Zmlyc3QtY2hpbGQgaW5wdXRbdHlwZT0ncmFkaW8nXVwiKS5wYXJlbnQoKS5hZGRDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7IC8vcmUgYWRkIGFjdGl2ZSBjbGFzcyB0byBmaXJzdCBcImRlZmF1bHRcIiBvcHRpb25cblxuICAgICAgICAgICAgICAgIC8vbnVtYmVyIHJhbmdlIC0gMiBudW1iZXIgaW5wdXQgZmllbGRzXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJpbnB1dFt0eXBlPSdudW1iZXInXVwiKS5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNJbnB1dCA9ICQodGhpcyk7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYoJHRoaXNJbnB1dC5wYXJlbnQoKS5wYXJlbnQoKS5oYXNDbGFzcyhcInNmLW1ldGEtcmFuZ2VcIikpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoaW5kZXg9PTApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbCgkdGhpc0lucHV0LmF0dHIoXCJtaW5cIikpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihpbmRleD09MSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKCR0aGlzSW5wdXQuYXR0cihcIm1heFwiKSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgIC8vbWV0YSAvIG51bWJlcnMgd2l0aCAyIGlucHV0cyAoZnJvbSAvIHRvIGZpZWxkcykgLSBzZWNvbmQgaW5wdXQgbXVzdCBiZSByZXNldCB0byBtYXggdmFsdWVcbiAgICAgICAgICAgICAgICB2YXIgJG1ldGFfc2VsZWN0X2Zyb21fdG8gPSAkZmllbGQuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNlbGVjdC1mcm9tdG9cIik7XG5cbiAgICAgICAgICAgICAgICBpZigkbWV0YV9zZWxlY3RfZnJvbV90by5sZW5ndGg+MCkge1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9taW4gPSAkbWV0YV9zZWxlY3RfZnJvbV90by5hdHRyKFwiZGF0YS1taW5cIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9tYXggPSAkbWV0YV9zZWxlY3RfZnJvbV90by5hdHRyKFwiZGF0YS1tYXhcIik7XG5cbiAgICAgICAgICAgICAgICAgICAgJG1ldGFfc2VsZWN0X2Zyb21fdG8uZmluZChcInNlbGVjdFwiKS5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzSW5wdXQgPSAkKHRoaXMpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKHN0YXJ0X21pbik7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoc3RhcnRfbWF4KTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB2YXIgJG1ldGFfcmFkaW9fZnJvbV90byA9ICRmaWVsZC5maW5kKFwiLnNmLW1ldGEtcmFuZ2UtcmFkaW8tZnJvbXRvXCIpO1xuXG4gICAgICAgICAgICAgICAgaWYoJG1ldGFfcmFkaW9fZnJvbV90by5sZW5ndGg+MClcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9taW4gPSAkbWV0YV9yYWRpb19mcm9tX3RvLmF0dHIoXCJkYXRhLW1pblwiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21heCA9ICRtZXRhX3JhZGlvX2Zyb21fdG8uYXR0cihcImRhdGEtbWF4XCIpO1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciAkcmFkaW9fZ3JvdXBzID0gJG1ldGFfcmFkaW9fZnJvbV90by5maW5kKCcuc2YtaW5wdXQtcmFuZ2UtcmFkaW8nKTtcblxuICAgICAgICAgICAgICAgICAgICAkcmFkaW9fZ3JvdXBzLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xuXG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkcmFkaW9zID0gJCh0aGlzKS5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgJHJhZGlvcy5wcm9wKFwiY2hlY2tlZFwiLCBmYWxzZSk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGluZGV4PT0wKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRyYWRpb3MuZmlsdGVyKCdbdmFsdWU9XCInK3N0YXJ0X21pbisnXCJdJykucHJvcChcImNoZWNrZWRcIiwgdHJ1ZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRyYWRpb3MuZmlsdGVyKCdbdmFsdWU9XCInK3N0YXJ0X21heCsnXCJdJykucHJvcChcImNoZWNrZWRcIiwgdHJ1ZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgIFxuICAgICAgICAgICAgICAgIC8vbnVtYmVyIHNsaWRlciAtIG5vVWlTbGlkZXJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIi5tZXRhLXNsaWRlclwiKS5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX29iamVjdCA9ICQodGhpcylbMF07XG4gICAgICAgICAgICAgICAgICAgIC8qdmFyIHNsaWRlcl9vYmplY3QgPSAkY29udGFpbmVyLmZpbmQoXCIubWV0YS1zbGlkZXJcIilbMF07XG4gICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX3ZhbCA9IHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5nZXQoKTsqL1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciAkc2xpZGVyX2VsID0gJCh0aGlzKS5jbG9zZXN0KFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgbWluVmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1taW4tZm9ybWF0dGVkXCIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgbWF4VmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1tYXgtZm9ybWF0dGVkXCIpO1xuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFttaW5WYWwsIG1heFZhbF0pO1xuXG4gICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICAvL25lZWQgdG8gc2VlIGlmIGFueSBhcmUgY29tYm9ib3ggYW5kIGFjdCBhY2NvcmRpbmdseVxuICAgICAgICAgICAgICAgIHZhciAkY29tYm9ib3ggPSAkZmllbGQuZmluZChcInNlbGVjdFtkYXRhLWNvbWJvYm94PScxJ11cIik7XG4gICAgICAgICAgICAgICAgaWYoJGNvbWJvYm94Lmxlbmd0aD4wKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHR5cGVvZiAkY29tYm9ib3guY2hvc2VuICE9IFwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC50cmlnZ2VyKFwiY2hvc2VuOnVwZGF0ZWRcIik7IC8vZm9yIGNob3NlbiBvbmx5XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAkY29tYm9ib3gudmFsKCcnKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC50cmlnZ2VyKCdjaGFuZ2Uuc2VsZWN0MicpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuXG5cbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7XG5cbiAgICAgICAgICAgIGlmKHN1Ym1pdF9mb3JtPT1cImFsd2F5c1wiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZihzdWJtaXRfZm9ybT09XCJuZXZlclwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBzZWxmLmZvcm1VcGRhdGVkRmV0Y2hBamF4KCk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZihzdWJtaXRfZm9ybT09XCJhdXRvXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWYodGhpcy5hdXRvX3VwZGF0ZT09dHJ1ZSlcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZvcm1VcGRhdGVkRmV0Y2hBamF4KCk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmluaXQoKTtcblxuICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHt9O1xuICAgICAgICBldmVudF9kYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XG4gICAgICAgIGV2ZW50X2RhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XG4gICAgICAgIGV2ZW50X2RhdGEub2JqZWN0ID0gdGhpcztcbiAgICAgICAgaWYob3B0cy5pc0luaXQpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6aW5pdFwiLCBldmVudF9kYXRhKTtcbiAgICAgICAgfVxuXG4gICAgfSk7XG59O1xuIl19
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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3Byb2Nlc3NfZm9ybS5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIlxudmFyICQgPSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xuXG5tb2R1bGUuZXhwb3J0cyA9IHtcblxuXHR0YXhvbm9teV9hcmNoaXZlczogMCxcbiAgICB1cmxfcGFyYW1zOiB7fSxcbiAgICB0YXhfYXJjaGl2ZV9yZXN1bHRzX3VybDogXCJcIixcbiAgICBhY3RpdmVfdGF4OiBcIlwiLFxuICAgIGZpZWxkczoge30sXG5cdGluaXQ6IGZ1bmN0aW9uKHRheG9ub215X2FyY2hpdmVzLCBjdXJyZW50X3RheG9ub215X2FyY2hpdmUpe1xuXG4gICAgICAgIHRoaXMudGF4b25vbXlfYXJjaGl2ZXMgPSAwO1xuICAgICAgICB0aGlzLnVybF9wYXJhbXMgPSB7fTtcbiAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IFwiXCI7XG4gICAgICAgIHRoaXMuYWN0aXZlX3RheCA9IFwiXCI7XG5cblx0XHQvL3RoaXMuJGZpZWxkcyA9ICRmaWVsZHM7XG4gICAgICAgIHRoaXMudGF4b25vbXlfYXJjaGl2ZXMgPSB0YXhvbm9teV9hcmNoaXZlcztcbiAgICAgICAgdGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgPSBjdXJyZW50X3RheG9ub215X2FyY2hpdmU7XG5cblx0XHR0aGlzLmNsZWFyVXJsQ29tcG9uZW50cygpO1xuXG5cdH0sXG4gICAgc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmw6IGZ1bmN0aW9uKCRmb3JtLCBjdXJyZW50X3Jlc3VsdHNfdXJsLCBnZXRfYWN0aXZlKSB7XG5cbiAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xuXHRcdHRoaXMuY2xlYXJUYXhBcmNoaXZlUmVzdWx0c1VybCgpO1xuICAgICAgICAvL3ZhciBjdXJyZW50X3Jlc3VsdHNfdXJsID0gXCJcIjtcbiAgICAgICAgaWYodGhpcy50YXhvbm9teV9hcmNoaXZlcyE9MSlcbiAgICAgICAge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKGdldF9hY3RpdmUpPT1cInVuZGVmaW5lZFwiKVxuXHRcdHtcblx0XHRcdHZhciBnZXRfYWN0aXZlID0gZmFsc2U7XG5cdFx0fVxuXG4gICAgICAgIC8vY2hlY2sgdG8gc2VlIGlmIHdlIGhhdmUgYW55IHRheG9ub21pZXMgc2VsZWN0ZWRcbiAgICAgICAgLy9pZiBzbywgY2hlY2sgdGhlaXIgcmV3cml0ZXMgYW5kIHVzZSB0aG9zZSBhcyB0aGUgcmVzdWx0cyB1cmxcbiAgICAgICAgdmFyICRmaWVsZCA9IGZhbHNlO1xuICAgICAgICB2YXIgZmllbGRfbmFtZSA9IFwiXCI7XG4gICAgICAgIHZhciBmaWVsZF92YWx1ZSA9IFwiXCI7XG5cbiAgICAgICAgdmFyICRhY3RpdmVfdGF4b25vbXkgPSAkZm9ybS4kZmllbGRzLnBhcmVudCgpLmZpbmQoXCJbZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlPScxJ11cIik7XG4gICAgICAgIGlmKCRhY3RpdmVfdGF4b25vbXkubGVuZ3RoPT0xKVxuICAgICAgICB7XG4gICAgICAgICAgICAkZmllbGQgPSAkYWN0aXZlX3RheG9ub215O1xuXG4gICAgICAgICAgICB2YXIgZmllbGRUeXBlID0gJGZpZWxkLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XG5cbiAgICAgICAgICAgIGlmICgoZmllbGRUeXBlID09IFwidGFnXCIpIHx8IChmaWVsZFR5cGUgPT0gXCJjYXRlZ29yeVwiKSB8fCAoZmllbGRUeXBlID09IFwidGF4b25vbXlcIikpIHtcbiAgICAgICAgICAgICAgICB2YXIgdGF4b25vbXlfdmFsdWUgPSBzZWxmLnByb2Nlc3NUYXhvbm9teSgkZmllbGQsIHRydWUpO1xuICAgICAgICAgICAgICAgIGZpZWxkX25hbWUgPSAkZmllbGQuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcbiAgICAgICAgICAgICAgICB2YXIgdGF4b25vbXlfbmFtZSA9IGZpZWxkX25hbWUucmVwbGFjZShcIl9zZnRfXCIsIFwiXCIpO1xuXG4gICAgICAgICAgICAgICAgaWYgKHRheG9ub215X3ZhbHVlKSB7XG4gICAgICAgICAgICAgICAgICAgIGZpZWxkX3ZhbHVlID0gdGF4b25vbXlfdmFsdWUudmFsdWU7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZihmaWVsZF92YWx1ZT09XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAkZmllbGQgPSBmYWxzZTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIGlmKChzZWxmLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSE9XCJcIikmJihzZWxmLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSE9dGF4b25vbXlfbmFtZSkpXG4gICAgICAgIHtcblxuICAgICAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IGN1cnJlbnRfcmVzdWx0c191cmw7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICBpZigoKGZpZWxkX3ZhbHVlPT1cIlwiKXx8KCEkZmllbGQpICkpXG4gICAgICAgIHtcbiAgICAgICAgICAgICRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgICAgICAgICBpZiAoISRmaWVsZCkge1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZFR5cGUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKChmaWVsZFR5cGUgPT0gXCJ0YWdcIikgfHwgKGZpZWxkVHlwZSA9PSBcImNhdGVnb3J5XCIpIHx8IChmaWVsZFR5cGUgPT0gXCJ0YXhvbm9teVwiKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHRheG9ub215X3ZhbHVlID0gc2VsZi5wcm9jZXNzVGF4b25vbXkoJCh0aGlzKSwgdHJ1ZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICBmaWVsZF9uYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAodGF4b25vbXlfdmFsdWUpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpZWxkX3ZhbHVlID0gdGF4b25vbXlfdmFsdWUudmFsdWU7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoZmllbGRfdmFsdWUgIT0gXCJcIikge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRmaWVsZCA9ICQodGhpcyk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKCAoJGZpZWxkKSAmJiAoZmllbGRfdmFsdWUgIT0gXCJcIiApKSB7XG4gICAgICAgICAgICAvL2lmIHdlIGZvdW5kIGEgZmllbGRcblx0XHRcdHZhciByZXdyaXRlX2F0dHIgPSAoJGZpZWxkLmF0dHIoXCJkYXRhLXNmLXRlcm0tcmV3cml0ZVwiKSk7XG5cbiAgICAgICAgICAgIGlmKHJld3JpdGVfYXR0ciE9XCJcIikge1xuXG4gICAgICAgICAgICAgICAgdmFyIHJld3JpdGUgPSBKU09OLnBhcnNlKHJld3JpdGVfYXR0cik7XG4gICAgICAgICAgICAgICAgdmFyIGlucHV0X3R5cGUgPSAkZmllbGQuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcbiAgICAgICAgICAgICAgICBzZWxmLmFjdGl2ZV90YXggPSBmaWVsZF9uYW1lO1xuXG4gICAgICAgICAgICAgICAgLy9maW5kIHRoZSBhY3RpdmUgZWxlbWVudFxuICAgICAgICAgICAgICAgIGlmICgoaW5wdXRfdHlwZSA9PSBcInJhZGlvXCIpIHx8IChpbnB1dF90eXBlID09IFwiY2hlY2tib3hcIikpIHtcblxuICAgICAgICAgICAgICAgICAgICAvL3ZhciAkYWN0aXZlID0gJGZpZWxkLmZpbmQoXCIuc2Ytb3B0aW9uLWFjdGl2ZVwiKTtcbiAgICAgICAgICAgICAgICAgICAgLy9leHBsb2RlIHRoZSB2YWx1ZXMgaWYgdGhlcmUgaXMgYSBkZWxpbVxuICAgICAgICAgICAgICAgICAgICAvL2ZpZWxkX3ZhbHVlXG5cbiAgICAgICAgICAgICAgICAgICAgdmFyIGlzX3NpbmdsZV92YWx1ZSA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZF92YWx1ZXMgPSBmaWVsZF92YWx1ZS5zcGxpdChcIixcIikuam9pbihcIitcIikuc3BsaXQoXCIrXCIpO1xuICAgICAgICAgICAgICAgICAgICBpZiAoZmllbGRfdmFsdWVzLmxlbmd0aCA+IDEpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlzX3NpbmdsZV92YWx1ZSA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKGlzX3NpbmdsZV92YWx1ZSkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gJGZpZWxkLmZpbmQoXCJpbnB1dFt2YWx1ZT0nXCIgKyBmaWVsZF92YWx1ZSArIFwiJ11cIik7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGFjdGl2ZSA9ICRpbnB1dC5wYXJlbnQoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aCA9ICRhY3RpdmUuYXR0cihcImRhdGEtc2YtZGVwdGhcIik7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vbm93IGxvb3AgdGhyb3VnaCBwYXJlbnRzIHRvIGdyYWIgdGhlaXIgbmFtZXNcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB2YWx1ZXMgPSBuZXcgQXJyYXkoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKGZpZWxkX3ZhbHVlKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgZm9yICh2YXIgaSA9IGRlcHRoOyBpID4gMDsgaS0tKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGFjdGl2ZSA9ICRhY3RpdmUucGFyZW50KCkucGFyZW50KCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goJGFjdGl2ZS5maW5kKFwiaW5wdXRcIikudmFsKCkpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucmV2ZXJzZSgpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJld3JpdGUgZm9yIHRoaXMgZGVwdGhcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBhY3RpdmVfcmV3cml0ZSA9IHJld3JpdGVbZGVwdGhdO1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHVybCA9IGFjdGl2ZV9yZXdyaXRlO1xuXG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vdGhlbiBtYXAgZnJvbSB0aGUgcGFyZW50cyB0byB0aGUgZGVwdGhcbiAgICAgICAgICAgICAgICAgICAgICAgICQodmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybCA9IHVybC5yZXBsYWNlKFwiW1wiICsgaW5kZXggKyBcIl1cIiwgdmFsdWUpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSB1cmw7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaWYgdGhlcmUgYXJlIG11bHRpcGxlIHZhbHVlcyxcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vdGhlbiB3ZSBuZWVkIHRvIGNoZWNrIGZvciAzIHRoaW5nczpcblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pZiB0aGUgdmFsdWVzIHNlbGVjdGVkIGFyZSBhbGwgaW4gdGhlIHNhbWUgdHJlZSB0aGVuIHdlIGNhbiBkbyBzb21lIGNsZXZlciByZXdyaXRlIHN0dWZmXG4gICAgICAgICAgICAgICAgICAgICAgICAvL21lcmdlIGFsbCB2YWx1ZXMgaW4gc2FtZSBsZXZlbCwgdGhlbiBjb21iaW5lIHRoZSBsZXZlbHNcblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pZiB0aGV5IGFyZSBmcm9tIGRpZmZlcmVudCB0cmVlcyB0aGVuIGp1c3QgY29tYmluZSB0aGVtIG9yIGp1c3QgdXNlIGBmaWVsZF92YWx1ZWBcbiAgICAgICAgICAgICAgICAgICAgICAgIC8qXG5cbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGhzID0gbmV3IEFycmF5KCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgJChmaWVsZF92YWx1ZXMpLmVhY2goZnVuY3Rpb24gKGluZGV4LCB2YWwpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkaW5wdXQgPSAkZmllbGQuZmluZChcImlucHV0W3ZhbHVlPSdcIiArIGZpZWxkX3ZhbHVlICsgXCInXVwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGFjdGl2ZSA9ICRpbnB1dC5wYXJlbnQoKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aCA9ICRhY3RpdmUuYXR0cihcImRhdGEtc2YtZGVwdGhcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgLy9kZXB0aHMucHVzaChkZXB0aCk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICB9KTsqL1xuXG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZSBpZiAoKGlucHV0X3R5cGUgPT0gXCJzZWxlY3RcIikgfHwgKGlucHV0X3R5cGUgPT0gXCJtdWx0aXNlbGVjdFwiKSkge1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciBpc19zaW5nbGVfdmFsdWUgPSB0cnVlO1xuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRfdmFsdWVzID0gZmllbGRfdmFsdWUuc3BsaXQoXCIsXCIpLmpvaW4oXCIrXCIpLnNwbGl0KFwiK1wiKTtcbiAgICAgICAgICAgICAgICAgICAgaWYgKGZpZWxkX3ZhbHVlcy5sZW5ndGggPiAxKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBpc19zaW5nbGVfdmFsdWUgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIGlmIChpc19zaW5nbGVfdmFsdWUpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkZmllbGQuZmluZChcIm9wdGlvblt2YWx1ZT0nXCIgKyBmaWVsZF92YWx1ZSArIFwiJ11cIik7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGggPSAkYWN0aXZlLmF0dHIoXCJkYXRhLXNmLWRlcHRoXCIpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWVzID0gbmV3IEFycmF5KCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaChmaWVsZF92YWx1ZSk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGZvciAodmFyIGkgPSBkZXB0aDsgaSA+IDA7IGktLSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRhY3RpdmUgPSAkYWN0aXZlLnByZXZBbGwoXCJvcHRpb25bZGF0YS1zZi1kZXB0aD0nXCIgKyAoaSAtIDEpICsgXCInXVwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaCgkYWN0aXZlLnZhbCgpKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnJldmVyc2UoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBhY3RpdmVfcmV3cml0ZSA9IHJld3JpdGVbZGVwdGhdO1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHVybCA9IGFjdGl2ZV9yZXdyaXRlO1xuICAgICAgICAgICAgICAgICAgICAgICAgJCh2YWx1ZXMpLmVhY2goZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsID0gdXJsLnJlcGxhY2UoXCJbXCIgKyBpbmRleCArIFwiXVwiLCB2YWx1ZSk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IHVybDtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuXG4gICAgICAgIH1cbiAgICAgICAgLy90aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gY3VycmVudF9yZXN1bHRzX3VybDtcbiAgICB9LFxuICAgIGdldFJlc3VsdHNVcmw6IGZ1bmN0aW9uKCRmb3JtLCBjdXJyZW50X3Jlc3VsdHNfdXJsKSB7XG5cbiAgICAgICAgLy90aGlzLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKCRmb3JtLCBjdXJyZW50X3Jlc3VsdHNfdXJsKTtcblxuICAgICAgICBpZih0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsPT1cIlwiKVxuICAgICAgICB7XG4gICAgICAgICAgICByZXR1cm4gY3VycmVudF9yZXN1bHRzX3VybDtcbiAgICAgICAgfVxuXG4gICAgICAgIHJldHVybiB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsO1xuICAgIH0sXG5cdGdldFVybFBhcmFtczogZnVuY3Rpb24oJGZvcm0pe1xuXG5cdFx0dGhpcy5idWlsZFVybENvbXBvbmVudHMoJGZvcm0sIHRydWUpO1xuXG4gICAgICAgIGlmKHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwhPVwiXCIpXG4gICAgICAgIHtcblxuICAgICAgICAgICAgaWYodGhpcy5hY3RpdmVfdGF4IT1cIlwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciBmaWVsZF9uYW1lID0gdGhpcy5hY3RpdmVfdGF4O1xuXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMudXJsX3BhcmFtc1tmaWVsZF9uYW1lXSkhPVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBkZWxldGUgdGhpcy51cmxfcGFyYW1zW2ZpZWxkX25hbWVdO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG5cdFx0cmV0dXJuIHRoaXMudXJsX3BhcmFtcztcblx0fSxcblx0Y2xlYXJVcmxDb21wb25lbnRzOiBmdW5jdGlvbigpe1xuXHRcdC8vdGhpcy51cmxfY29tcG9uZW50cyA9IFwiXCI7XG5cdFx0dGhpcy51cmxfcGFyYW1zID0ge307XG5cdH0sXG5cdGNsZWFyVGF4QXJjaGl2ZVJlc3VsdHNVcmw6IGZ1bmN0aW9uKCkge1xuXHRcdHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSAnJztcblx0fSxcblx0ZGlzYWJsZUlucHV0czogZnVuY3Rpb24oJGZvcm0pe1xuXHRcdHZhciBzZWxmID0gdGhpcztcblx0XHRcblx0XHQkZm9ybS4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcblx0XHRcdFxuXHRcdFx0dmFyICRpbnB1dHMgPSAkKHRoaXMpLmZpbmQoXCJpbnB1dCwgc2VsZWN0LCAubWV0YS1zbGlkZXJcIik7XG5cdFx0XHQkaW5wdXRzLmF0dHIoXCJkaXNhYmxlZFwiLCBcImRpc2FibGVkXCIpO1xuXHRcdFx0JGlucHV0cy5hdHRyKFwiZGlzYWJsZWRcIiwgdHJ1ZSk7XG5cdFx0XHQkaW5wdXRzLnByb3AoXCJkaXNhYmxlZFwiLCB0cnVlKTtcblx0XHRcdCRpbnB1dHMudHJpZ2dlcihcImNob3Nlbjp1cGRhdGVkXCIpO1xuXHRcdFx0XG5cdFx0fSk7XG5cdFx0XG5cdFx0XG5cdH0sXG5cdGVuYWJsZUlucHV0czogZnVuY3Rpb24oJGZvcm0pe1xuXHRcdHZhciBzZWxmID0gdGhpcztcblx0XHQkZm9ybS4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcblx0XHRcdHZhciAkaW5wdXRzID0gJCh0aGlzKS5maW5kKFwiaW5wdXQsIHNlbGVjdCwgLm1ldGEtc2xpZGVyXCIpO1xuXHRcdFx0JGlucHV0cy5wcm9wKFwiZGlzYWJsZWRcIiwgZmFsc2UpO1xuXHRcdFx0JGlucHV0cy5hdHRyKFwiZGlzYWJsZWRcIiwgZmFsc2UpO1xuXHRcdFx0JGlucHV0cy50cmlnZ2VyKFwiY2hvc2VuOnVwZGF0ZWRcIik7XHRcdFx0XG5cdFx0fSk7XG5cdFx0XG5cdFx0XG5cdH0sXG5cdGJ1aWxkVXJsQ29tcG9uZW50czogZnVuY3Rpb24oJGZvcm0sIGNsZWFyX2NvbXBvbmVudHMpe1xuXHRcdFxuXHRcdHZhciBzZWxmID0gdGhpcztcblx0XHRcblx0XHRpZih0eXBlb2YoY2xlYXJfY29tcG9uZW50cykhPVwidW5kZWZpbmVkXCIpXG5cdFx0e1xuXHRcdFx0aWYoY2xlYXJfY29tcG9uZW50cz09dHJ1ZSlcblx0XHRcdHtcblx0XHRcdFx0dGhpcy5jbGVhclVybENvbXBvbmVudHMoKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0XG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XG5cdFx0XHRcblx0XHRcdHZhciBmaWVsZE5hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XG5cdFx0XHR2YXIgZmllbGRUeXBlID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xuXHRcdFx0XG5cdFx0XHRpZihmaWVsZFR5cGU9PVwic2VhcmNoXCIpXG5cdFx0XHR7XG5cdFx0XHRcdHNlbGYucHJvY2Vzc1NlYXJjaEZpZWxkKCQodGhpcykpO1xuXHRcdFx0fVxuXHRcdFx0ZWxzZSBpZigoZmllbGRUeXBlPT1cInRhZ1wiKXx8KGZpZWxkVHlwZT09XCJjYXRlZ29yeVwiKXx8KGZpZWxkVHlwZT09XCJ0YXhvbm9teVwiKSlcblx0XHRcdHtcblx0XHRcdFx0c2VsZi5wcm9jZXNzVGF4b25vbXkoJCh0aGlzKSk7XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJzb3J0X29yZGVyXCIpXG5cdFx0XHR7XG5cdFx0XHRcdHNlbGYucHJvY2Vzc1NvcnRPcmRlckZpZWxkKCQodGhpcykpO1xuXHRcdFx0fVxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdHNfcGVyX3BhZ2VcIilcblx0XHRcdHtcblx0XHRcdFx0c2VsZi5wcm9jZXNzUmVzdWx0c1BlclBhZ2VGaWVsZCgkKHRoaXMpKTtcblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cImF1dGhvclwiKVxuXHRcdFx0e1xuXHRcdFx0XHRzZWxmLnByb2Nlc3NBdXRob3IoJCh0aGlzKSk7XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0X3R5cGVcIilcblx0XHRcdHtcblx0XHRcdFx0c2VsZi5wcm9jZXNzUG9zdFR5cGUoJCh0aGlzKSk7XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0X2RhdGVcIilcblx0XHRcdHtcblx0XHRcdFx0c2VsZi5wcm9jZXNzUG9zdERhdGUoJCh0aGlzKSk7XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0X21ldGFcIilcblx0XHRcdHtcblx0XHRcdFx0c2VsZi5wcm9jZXNzUG9zdE1ldGEoJCh0aGlzKSk7XG5cdFx0XHRcdFxuXHRcdFx0fVxuXHRcdFx0ZWxzZVxuXHRcdFx0e1xuXHRcdFx0XHRcblx0XHRcdH1cblx0XHRcdFxuXHRcdH0pO1xuXHRcdFxuXHR9LFxuXHRwcm9jZXNzU2VhcmNoRmllbGQ6IGZ1bmN0aW9uKCRjb250YWluZXIpXG5cdHtcblx0XHR2YXIgc2VsZiA9IHRoaXM7XG5cdFx0XG5cdFx0dmFyICRmaWVsZCA9ICRjb250YWluZXIuZmluZChcImlucHV0W25hbWVePSdfc2Zfc2VhcmNoJ11cIik7XG5cdFx0XG5cdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxuXHRcdHtcblx0XHRcdHZhciBmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQudmFsKCk7XG5cdFx0XHRcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxuXHRcdFx0e1xuXHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImX3NmX3M9XCIrZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkVmFsKTtcblx0XHRcdFx0c2VsZi51cmxfcGFyYW1zWydfc2ZfcyddID0gZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkVmFsKTtcblx0XHRcdH1cblx0XHR9XG5cdH0sXG5cdHByb2Nlc3NTb3J0T3JkZXJGaWVsZDogZnVuY3Rpb24oJGNvbnRhaW5lcilcblx0e1xuXHRcdHRoaXMucHJvY2Vzc0F1dGhvcigkY29udGFpbmVyKTtcblx0XHRcblx0fSxcblx0cHJvY2Vzc1Jlc3VsdHNQZXJQYWdlRmllbGQ6IGZ1bmN0aW9uKCRjb250YWluZXIpXG5cdHtcblx0XHR0aGlzLnByb2Nlc3NBdXRob3IoJGNvbnRhaW5lcik7XG5cdFx0XG5cdH0sXG5cdGdldEFjdGl2ZVRheDogZnVuY3Rpb24oJGZpZWxkKSB7XG5cdFx0cmV0dXJuIHRoaXMuYWN0aXZlX3RheDtcblx0fSxcblx0Z2V0U2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQpe1xuXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcblx0XHRcblx0XHRpZigkZmllbGQudmFsKCkhPTApXG5cdFx0e1xuXHRcdFx0ZmllbGRWYWwgPSAkZmllbGQudmFsKCk7XG5cdFx0fVxuXHRcdFxuXHRcdGlmKGZpZWxkVmFsPT1udWxsKVxuXHRcdHtcblx0XHRcdGZpZWxkVmFsID0gXCJcIjtcblx0XHR9XG5cdFx0XG5cdFx0cmV0dXJuIGZpZWxkVmFsO1xuXHR9LFxuXHRnZXRNZXRhU2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQpe1xuXHRcdFxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XG5cdFx0XG5cdFx0ZmllbGRWYWwgPSAkZmllbGQudmFsKCk7XG5cdFx0XHRcdFx0XHRcblx0XHRpZihmaWVsZFZhbD09bnVsbClcblx0XHR7XG5cdFx0XHRmaWVsZFZhbCA9IFwiXCI7XG5cdFx0fVxuXHRcdFxuXHRcdHJldHVybiBmaWVsZFZhbDtcblx0fSxcblx0Z2V0TXVsdGlTZWxlY3RWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xuXHRcdFxuXHRcdHZhciBkZWxpbSA9IFwiK1wiO1xuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXG5cdFx0e1xuXHRcdFx0ZGVsaW0gPSBcIixcIjtcblx0XHR9XG5cdFx0XG5cdFx0aWYodHlwZW9mKCRmaWVsZC52YWwoKSk9PVwib2JqZWN0XCIpXG5cdFx0e1xuXHRcdFx0aWYoJGZpZWxkLnZhbCgpIT1udWxsKVxuXHRcdFx0e1xuXHRcdFx0XHRyZXR1cm4gJGZpZWxkLnZhbCgpLmpvaW4oZGVsaW0pO1xuXHRcdFx0fVxuXHRcdH1cblx0XHRcblx0fSxcblx0Z2V0TWV0YU11bHRpU2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQsIG9wZXJhdG9yKXtcblx0XHRcblx0XHR2YXIgZGVsaW0gPSBcIi0rLVwiO1xuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXG5cdFx0e1xuXHRcdFx0ZGVsaW0gPSBcIi0sLVwiO1xuXHRcdH1cblx0XHRcdFx0XG5cdFx0aWYodHlwZW9mKCRmaWVsZC52YWwoKSk9PVwib2JqZWN0XCIpXG5cdFx0e1xuXHRcdFx0aWYoJGZpZWxkLnZhbCgpIT1udWxsKVxuXHRcdFx0e1xuXHRcdFx0XHRcblx0XHRcdFx0dmFyIGZpZWxkdmFsID0gW107XG5cdFx0XHRcdFxuXHRcdFx0XHQkKCRmaWVsZC52YWwoKSkuZWFjaChmdW5jdGlvbihpbmRleCx2YWx1ZSl7XG5cdFx0XHRcdFx0XG5cdFx0XHRcdFx0ZmllbGR2YWwucHVzaCgodmFsdWUpKTtcblx0XHRcdFx0fSk7XG5cdFx0XHRcdFxuXHRcdFx0XHRyZXR1cm4gZmllbGR2YWwuam9pbihkZWxpbSk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdFxuXHRcdHJldHVybiBcIlwiO1xuXHRcdFxuXHR9LFxuXHRnZXRDaGVja2JveFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XG5cdFx0XG5cdFx0XG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpe1xuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcblx0XHRcdHtcblx0XHRcdFx0cmV0dXJuICQodGhpcykudmFsKCk7XG5cdFx0XHR9XG5cdFx0fSkuZ2V0KCk7XG5cdFx0XG5cdFx0dmFyIGRlbGltID0gXCIrXCI7XG5cdFx0aWYob3BlcmF0b3I9PVwib3JcIilcblx0XHR7XG5cdFx0XHRkZWxpbSA9IFwiLFwiO1xuXHRcdH1cblx0XHRcblx0XHRyZXR1cm4gZmllbGRWYWwuam9pbihkZWxpbSk7XG5cdH0sXG5cdGdldE1ldGFDaGVja2JveFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XG5cdFx0XG5cdFx0XG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpe1xuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcblx0XHRcdHtcblx0XHRcdFx0cmV0dXJuICgkKHRoaXMpLnZhbCgpKTtcblx0XHRcdH1cblx0XHR9KS5nZXQoKTtcblx0XHRcblx0XHR2YXIgZGVsaW0gPSBcIi0rLVwiO1xuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXG5cdFx0e1xuXHRcdFx0ZGVsaW0gPSBcIi0sLVwiO1xuXHRcdH1cblx0XHRcblx0XHRyZXR1cm4gZmllbGRWYWwuam9pbihkZWxpbSk7XG5cdH0sXG5cdGdldFJhZGlvVmFsOiBmdW5jdGlvbigkZmllbGQpe1xuXHRcdFx0XHRcdFx0XHRcblx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQubWFwKGZ1bmN0aW9uKClcblx0XHR7XG5cdFx0XHRpZigkKHRoaXMpLnByb3AoXCJjaGVja2VkXCIpPT10cnVlKVxuXHRcdFx0e1xuXHRcdFx0XHRyZXR1cm4gJCh0aGlzKS52YWwoKTtcblx0XHRcdH1cblx0XHRcdFxuXHRcdH0pLmdldCgpO1xuXHRcdFxuXHRcdFxuXHRcdGlmKGZpZWxkVmFsWzBdIT0wKVxuXHRcdHtcblx0XHRcdHJldHVybiBmaWVsZFZhbFswXTtcblx0XHR9XG5cdH0sXG5cdGdldE1ldGFSYWRpb1ZhbDogZnVuY3Rpb24oJGZpZWxkKXtcblx0XHRcdFx0XHRcdFx0XG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpXG5cdFx0e1xuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcblx0XHRcdHtcblx0XHRcdFx0cmV0dXJuICQodGhpcykudmFsKCk7XG5cdFx0XHR9XG5cdFx0XHRcblx0XHR9KS5nZXQoKTtcblx0XHRcblx0XHRyZXR1cm4gZmllbGRWYWxbMF07XG5cdH0sXG5cdHByb2Nlc3NBdXRob3I6IGZ1bmN0aW9uKCRjb250YWluZXIpXG5cdHtcblx0XHR2YXIgc2VsZiA9IHRoaXM7XG5cdFx0XG5cdFx0XG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xuXHRcdFxuXHRcdHZhciAkZmllbGQ7XG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcblx0XHRcblx0XHRpZihpbnB1dFR5cGU9PVwic2VsZWN0XCIpXG5cdFx0e1xuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xuXHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0XG5cdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0U2VsZWN0VmFsKCRmaWVsZCk7IFxuXHRcdH1cblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxuXHRcdHtcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcblx0XHRcdHZhciBvcGVyYXRvciA9ICRmaWVsZC5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcblx0XHRcdFxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE11bHRpU2VsZWN0VmFsKCRmaWVsZCwgXCJvclwiKTtcblx0XHRcdFxuXHRcdH1cblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJjaGVja2JveFwiKVxuXHRcdHtcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XG5cdFx0XHRcblx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcblx0XHRcdHtcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0XHRcdFx0XHRcdFx0XHRcblx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKS5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldENoZWNrYm94VmFsKCRmaWVsZCwgXCJvclwiKTtcblx0XHRcdH1cblx0XHRcdFxuXHRcdH1cblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYWRpb1wiKVxuXHRcdHtcblx0XHRcdFxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpyYWRpb1wiKTtcblx0XHRcdFx0XHRcdFxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxuXHRcdFx0e1xuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHRcdFxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0UmFkaW9WYWwoJGZpZWxkKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0XG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcblx0XHR7XG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcblx0XHRcdHtcblx0XHRcdFx0dmFyIGZpZWxkU2x1ZyA9IFwiXCI7XG5cdFx0XHRcdFxuXHRcdFx0XHRpZihmaWVsZE5hbWU9PVwiX3NmX2F1dGhvclwiKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJhdXRob3JzXCI7XG5cdFx0XHRcdH1cblx0XHRcdFx0ZWxzZSBpZihmaWVsZE5hbWU9PVwiX3NmX3NvcnRfb3JkZXJcIilcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwic29ydF9vcmRlclwiO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGVsc2UgaWYoZmllbGROYW1lPT1cIl9zZl9wcHBcIilcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwiX3NmX3BwcFwiO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGVsc2UgaWYoZmllbGROYW1lPT1cIl9zZl9wb3N0X3R5cGVcIilcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwicG9zdF90eXBlc1wiO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGVsc2Vcblx0XHRcdFx0e1xuXHRcdFx0XHRcblx0XHRcdFx0fVxuXHRcdFx0XHRcblx0XHRcdFx0aWYoZmllbGRTbHVnIT1cIlwiKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJlwiK2ZpZWxkU2x1ZytcIj1cIitmaWVsZFZhbDtcblx0XHRcdFx0XHRzZWxmLnVybF9wYXJhbXNbZmllbGRTbHVnXSA9IGZpZWxkVmFsO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXHRcdFxuXHR9LFxuXHRwcm9jZXNzUG9zdFR5cGUgOiBmdW5jdGlvbigkdGhpcyl7XG5cdFx0XG5cdFx0dGhpcy5wcm9jZXNzQXV0aG9yKCR0aGlzKTtcblx0XHRcblx0fSxcblx0cHJvY2Vzc1Bvc3RNZXRhOiBmdW5jdGlvbigkY29udGFpbmVyKVxuXHR7XG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xuXHRcdFxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcblx0XHR2YXIgbWV0YVR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLW1ldGEtdHlwZVwiKTtcblxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XG5cdFx0dmFyICRmaWVsZDtcblx0XHR2YXIgZmllbGROYW1lID0gXCJcIjtcblx0XHRcblx0XHRpZihtZXRhVHlwZT09XCJudW1iZXJcIilcblx0XHR7XG5cdFx0XHRpZihpbnB1dFR5cGU9PVwicmFuZ2UtbnVtYmVyXCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlLW51bWJlciBpbnB1dFwiKTtcblx0XHRcdFx0XG5cdFx0XHRcdHZhciB2YWx1ZXMgPSBbXTtcblx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcblx0XHRcdFx0XHRcblx0XHRcdFx0XHR2YWx1ZXMucHVzaCgkKHRoaXMpLnZhbCgpKTtcblx0XHRcdFx0XG5cdFx0XHRcdH0pO1xuXHRcdFx0XHRcblx0XHRcdFx0ZmllbGRWYWwgPSB2YWx1ZXMuam9pbihcIitcIik7XG5cdFx0XHRcdFxuXHRcdFx0fVxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFuZ2Utc2xpZGVyXCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNsaWRlciBpbnB1dFwiKTtcblx0XHRcdFx0XG5cdFx0XHRcdC8vZ2V0IGFueSBudW1iZXIgZm9ybWF0dGluZyBzdHVmZlxuXHRcdFx0XHR2YXIgJG1ldGFfcmFuZ2UgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHR2YXIgZGVjaW1hbF9wbGFjZXMgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1kZWNpbWFsLXBsYWNlc1wiKTtcblx0XHRcdFx0dmFyIHRob3VzYW5kX3NlcGVyYXRvciA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXRob3VzYW5kLXNlcGVyYXRvclwiKTtcblx0XHRcdFx0dmFyIGRlY2ltYWxfc2VwZXJhdG9yID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtZGVjaW1hbC1zZXBlcmF0b3JcIik7XG5cblx0XHRcdFx0dmFyIGZpZWxkX2Zvcm1hdCA9IHdOdW1iKHtcblx0XHRcdFx0XHRtYXJrOiBkZWNpbWFsX3NlcGVyYXRvcixcblx0XHRcdFx0XHRkZWNpbWFsczogcGFyc2VGbG9hdChkZWNpbWFsX3BsYWNlcyksXG5cdFx0XHRcdFx0dGhvdXNhbmQ6IHRob3VzYW5kX3NlcGVyYXRvclxuXHRcdFx0XHR9KTtcblx0XHRcdFx0XG5cdFx0XHRcdHZhciB2YWx1ZXMgPSBbXTtcblxuXG5cdFx0XHRcdHZhciBzbGlkZXJfb2JqZWN0ID0gJGNvbnRhaW5lci5maW5kKFwiLm1ldGEtc2xpZGVyXCIpWzBdO1xuXHRcdFx0XHQvL3ZhbCBmcm9tIHNsaWRlciBvYmplY3Rcblx0XHRcdFx0dmFyIHNsaWRlcl92YWwgPSBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZ2V0KCk7XG5cblx0XHRcdFx0dmFsdWVzLnB1c2goZmllbGRfZm9ybWF0LmZyb20oc2xpZGVyX3ZhbFswXSkpO1xuXHRcdFx0XHR2YWx1ZXMucHVzaChmaWVsZF9mb3JtYXQuZnJvbShzbGlkZXJfdmFsWzFdKSk7XG5cdFx0XHRcdFxuXHRcdFx0XHRmaWVsZFZhbCA9IHZhbHVlcy5qb2luKFwiK1wiKTtcblx0XHRcdFx0XG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHRcblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLXJhZGlvXCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1pbnB1dC1yYW5nZS1yYWRpb1wiKTtcblx0XHRcdFx0XG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg9PTApXG5cdFx0XHRcdHtcblx0XHRcdFx0XHQvL3RoZW4gdHJ5IGFnYWluLCB3ZSBtdXN0IGJlIHVzaW5nIGEgc2luZ2xlIGZpZWxkXG5cdFx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHZhciAkbWV0YV9yYW5nZSA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlXCIpO1xuXHRcdFx0XHRcblx0XHRcdFx0Ly90aGVyZSBpcyBhbiBlbGVtZW50IHdpdGggYSBmcm9tL3RvIGNsYXNzIC0gc28gd2UgbmVlZCB0byBnZXQgdGhlIHZhbHVlcyBvZiB0aGUgZnJvbSAmIHRvIGlucHV0IGZpZWxkcyBzZXBlcmF0ZWx5XG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcblx0XHRcdFx0e1x0XG5cdFx0XHRcdFx0dmFyIGZpZWxkX3ZhbHMgPSBbXTtcblx0XHRcdFx0XHRcblx0XHRcdFx0XHQkZmllbGQuZWFjaChmdW5jdGlvbigpe1xuXHRcdFx0XHRcdFx0XG5cdFx0XHRcdFx0XHR2YXIgJHJhZGlvcyA9ICQodGhpcykuZmluZChcIi5zZi1pbnB1dC1yYWRpb1wiKTtcblx0XHRcdFx0XHRcdGZpZWxkX3ZhbHMucHVzaChzZWxmLmdldE1ldGFSYWRpb1ZhbCgkcmFkaW9zKSk7XG5cdFx0XHRcdFx0XHRcblx0XHRcdFx0XHR9KTtcblx0XHRcdFx0XHRcblx0XHRcdFx0XHQvL3ByZXZlbnQgc2Vjb25kIG51bWJlciBmcm9tIGJlaW5nIGxvd2VyIHRoYW4gdGhlIGZpcnN0XG5cdFx0XHRcdFx0aWYoZmllbGRfdmFscy5sZW5ndGg9PTIpXG5cdFx0XHRcdFx0e1xuXHRcdFx0XHRcdFx0aWYoTnVtYmVyKGZpZWxkX3ZhbHNbMV0pPE51bWJlcihmaWVsZF92YWxzWzBdKSlcblx0XHRcdFx0XHRcdHtcblx0XHRcdFx0XHRcdFx0ZmllbGRfdmFsc1sxXSA9IGZpZWxkX3ZhbHNbMF07XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFxuXHRcdFx0XHRcdGZpZWxkVmFsID0gZmllbGRfdmFscy5qb2luKFwiK1wiKTtcblx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0XHRcdFxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPT0xKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmZpbmQoXCIuc2YtaW5wdXQtcmFkaW9cIikuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHRcdH1cblx0XHRcdFx0ZWxzZVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcblx0XHRcdFx0fVxuXG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1zZWxlY3RcIilcblx0XHRcdHtcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLWlucHV0LXNlbGVjdFwiKTtcblx0XHRcdFx0dmFyICRtZXRhX3JhbmdlID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2VcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHQvL3RoZXJlIGlzIGFuIGVsZW1lbnQgd2l0aCBhIGZyb20vdG8gY2xhc3MgLSBzbyB3ZSBuZWVkIHRvIGdldCB0aGUgdmFsdWVzIG9mIHRoZSBmcm9tICYgdG8gaW5wdXQgZmllbGRzIHNlcGVyYXRlbHlcblx0XHRcdFx0XG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcblx0XHRcdFx0e1xuXHRcdFx0XHRcdHZhciBmaWVsZF92YWxzID0gW107XG5cdFx0XHRcdFx0XG5cdFx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcblx0XHRcdFx0XHRcdFxuXHRcdFx0XHRcdFx0dmFyICR0aGlzID0gJCh0aGlzKTtcblx0XHRcdFx0XHRcdGZpZWxkX3ZhbHMucHVzaChzZWxmLmdldE1ldGFTZWxlY3RWYWwoJHRoaXMpKTtcblx0XHRcdFx0XHRcdFxuXHRcdFx0XHRcdH0pO1xuXHRcdFx0XHRcdFxuXHRcdFx0XHRcdC8vcHJldmVudCBzZWNvbmQgbnVtYmVyIGZyb20gYmVpbmcgbG93ZXIgdGhhbiB0aGUgZmlyc3Rcblx0XHRcdFx0XHRpZihmaWVsZF92YWxzLmxlbmd0aD09Milcblx0XHRcdFx0XHR7XG5cdFx0XHRcdFx0XHRpZihOdW1iZXIoZmllbGRfdmFsc1sxXSk8TnVtYmVyKGZpZWxkX3ZhbHNbMF0pKVxuXHRcdFx0XHRcdFx0e1xuXHRcdFx0XHRcdFx0XHRmaWVsZF92YWxzWzFdID0gZmllbGRfdmFsc1swXTtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XG5cdFx0XHRcdFx0XG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBmaWVsZF92YWxzLmpvaW4oXCIrXCIpO1xuXHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0XG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg9PTEpXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHRcdH1cblx0XHRcdFx0ZWxzZVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcblx0XHRcdFx0fVxuXHRcdFx0XHRcblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLWNoZWNrYm94XCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0Q2hlY2tib3hWYWwoJGZpZWxkLCBcImFuZFwiKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdFx0XG5cdFx0XHRpZihmaWVsZE5hbWU9PVwiXCIpXG5cdFx0XHR7XG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0ZWxzZSBpZihtZXRhVHlwZT09XCJjaG9pY2VcIilcblx0XHR7XG5cdFx0XHRpZihpbnB1dFR5cGU9PVwic2VsZWN0XCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcblx0XHRcdFx0XG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhU2VsZWN0VmFsKCRmaWVsZCk7IFxuXHRcdFx0XHRcblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cIm11bHRpc2VsZWN0XCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcblx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGZpZWxkLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xuXHRcdFx0XHRcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE1ldGFNdWx0aVNlbGVjdFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cImNoZWNrYm94XCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXG5cdFx0XHRcdHtcblx0XHRcdFx0XHR2YXIgb3BlcmF0b3IgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xuXHRcdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhQ2hlY2tib3hWYWwoJGZpZWxkLCBvcGVyYXRvcik7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhZGlvXCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6cmFkaW9cIik7XG5cdFx0XHRcdFxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YVJhZGlvVmFsKCRmaWVsZCk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHRcdFxuXHRcdFx0ZmllbGRWYWwgPSBlbmNvZGVVUklDb21wb25lbnQoZmllbGRWYWwpO1xuXHRcdFx0aWYodHlwZW9mKCRmaWVsZCkhPT1cInVuZGVmaW5lZFwiKVxuXHRcdFx0e1xuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHRcdFx0XG5cdFx0XHRcdFx0Ly9mb3IgdGhvc2Ugd2hvIGluc2lzdCBvbiB1c2luZyAmIGFtcGVyc2FuZHMgaW4gdGhlIG5hbWUgb2YgdGhlIGN1c3RvbSBmaWVsZCAoISlcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAoZmllbGROYW1lKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdFx0XG5cdFx0fVxuXHRcdGVsc2UgaWYobWV0YVR5cGU9PVwiZGF0ZVwiKVxuXHRcdHtcblx0XHRcdHNlbGYucHJvY2Vzc1Bvc3REYXRlKCRjb250YWluZXIpO1xuXHRcdH1cblx0XHRcblx0XHRpZih0eXBlb2YoZmllbGRWYWwpIT1cInVuZGVmaW5lZFwiKVxuXHRcdHtcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxuXHRcdFx0e1xuXHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkTmFtZSkrXCI9XCIrKGZpZWxkVmFsKTtcblx0XHRcdFx0c2VsZi51cmxfcGFyYW1zW2VuY29kZVVSSUNvbXBvbmVudChmaWVsZE5hbWUpXSA9IChmaWVsZFZhbCk7XG5cdFx0XHR9XG5cdFx0fVxuXHR9LFxuXHRwcm9jZXNzUG9zdERhdGU6IGZ1bmN0aW9uKCRjb250YWluZXIpXG5cdHtcblx0XHR2YXIgc2VsZiA9IHRoaXM7XG5cdFx0XG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xuXHRcdFxuXHRcdHZhciAkZmllbGQ7XG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcblx0XHRcblx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnRleHRcIik7XG5cdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFxuXHRcdHZhciBkYXRlcyA9IFtdO1xuXHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XG5cdFx0XHRcblx0XHRcdGRhdGVzLnB1c2goJCh0aGlzKS52YWwoKSk7XG5cdFx0XG5cdFx0fSk7XG5cdFx0XG5cdFx0aWYoJGZpZWxkLmxlbmd0aD09Milcblx0XHR7XG5cdFx0XHRpZigoZGF0ZXNbMF0hPVwiXCIpfHwoZGF0ZXNbMV0hPVwiXCIpKVxuXHRcdFx0e1xuXHRcdFx0XHRmaWVsZFZhbCA9IGRhdGVzLmpvaW4oXCIrXCIpO1xuXHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkVmFsLnJlcGxhY2UoL1xcLy9nLCcnKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0ZWxzZSBpZigkZmllbGQubGVuZ3RoPT0xKVxuXHRcdHtcblx0XHRcdGlmKGRhdGVzWzBdIT1cIlwiKVxuXHRcdFx0e1xuXHRcdFx0XHRmaWVsZFZhbCA9IGRhdGVzLmpvaW4oXCIrXCIpO1xuXHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkVmFsLnJlcGxhY2UoL1xcLy9nLCcnKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0XG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcblx0XHR7XG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcblx0XHRcdHtcblx0XHRcdFx0dmFyIGZpZWxkU2x1ZyA9IFwiXCI7XG5cdFx0XHRcdFxuXHRcdFx0XHRpZihmaWVsZE5hbWU9PVwiX3NmX3Bvc3RfZGF0ZVwiKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJwb3N0X2RhdGVcIjtcblx0XHRcdFx0fVxuXHRcdFx0XHRlbHNlXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBmaWVsZE5hbWU7XG5cdFx0XHRcdH1cblx0XHRcdFx0XG5cdFx0XHRcdGlmKGZpZWxkU2x1ZyE9XCJcIilcblx0XHRcdFx0e1xuXHRcdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZFNsdWcrXCI9XCIrZmllbGRWYWw7XG5cdFx0XHRcdFx0c2VsZi51cmxfcGFyYW1zW2ZpZWxkU2x1Z10gPSBmaWVsZFZhbDtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblx0XHRcblx0fSxcblx0cHJvY2Vzc1RheG9ub215OiBmdW5jdGlvbigkY29udGFpbmVyLCByZXR1cm5fb2JqZWN0KVxuXHR7XG4gICAgICAgIGlmKHR5cGVvZihyZXR1cm5fb2JqZWN0KT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgcmV0dXJuX29iamVjdCA9IGZhbHNlO1xuICAgICAgICB9XG5cblx0XHQvL2lmKClcdFx0XHRcdFx0XG5cdFx0Ly92YXIgZmllbGROYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xuXHRcdHZhciBzZWxmID0gdGhpcztcblx0XG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xuXHRcdFxuXHRcdHZhciAkZmllbGQ7XG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcblx0XHRcblx0XHRpZihpbnB1dFR5cGU9PVwic2VsZWN0XCIpXG5cdFx0e1xuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xuXHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0XG5cdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0U2VsZWN0VmFsKCRmaWVsZCk7IFxuXHRcdH1cblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxuXHRcdHtcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcblx0XHRcdHZhciBvcGVyYXRvciA9ICRmaWVsZC5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcblx0XHRcdFxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE11bHRpU2VsZWN0VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xuXHRcdH1cblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJjaGVja2JveFwiKVxuXHRcdHtcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXG5cdFx0XHR7XG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcblx0XHRcdFx0XHRcdFx0XHRcdFx0XG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIikuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRDaGVja2JveFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFkaW9cIilcblx0XHR7XG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnJhZGlvXCIpO1xuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxuXHRcdFx0e1xuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHRcdFxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0UmFkaW9WYWwoJGZpZWxkKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0XG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcblx0XHR7XG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcblx0XHRcdHtcbiAgICAgICAgICAgICAgICBpZihyZXR1cm5fb2JqZWN0PT10cnVlKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHtuYW1lOiBmaWVsZE5hbWUsIHZhbHVlOiBmaWVsZFZhbH07XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZE5hbWUrXCI9XCIrZmllbGRWYWw7XG4gICAgICAgICAgICAgICAgICAgIHNlbGYudXJsX3BhcmFtc1tmaWVsZE5hbWVdID0gZmllbGRWYWw7XG4gICAgICAgICAgICAgICAgfVxuXG5cdFx0XHR9XG5cdFx0fVxuXG4gICAgICAgIGlmKHJldHVybl9vYmplY3Q9PXRydWUpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgfVxuXHR9XG59OyJdfQ==
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
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9hcHAuanMiLCJub2RlX21vZHVsZXMvbm91aXNsaWRlci9kaXN0cmlidXRlL25vdWlzbGlkZXIuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9wbHVnaW4uanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9wcm9jZXNzX2Zvcm0uanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9zdGF0ZS5qcyIsInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3RoaXJkcGFydHkuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQ3RRQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUMxeUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUNydEVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQzU4QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDbEJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gZSh0LG4scil7ZnVuY3Rpb24gcyhvLHUpe2lmKCFuW29dKXtpZighdFtvXSl7dmFyIGE9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtpZighdSYmYSlyZXR1cm4gYShvLCEwKTtpZihpKXJldHVybiBpKG8sITApO3ZhciBmPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIrbytcIidcIik7dGhyb3cgZi5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGZ9dmFyIGw9bltvXT17ZXhwb3J0czp7fX07dFtvXVswXS5jYWxsKGwuZXhwb3J0cyxmdW5jdGlvbihlKXt2YXIgbj10W29dWzFdW2VdO3JldHVybiBzKG4/bjplKX0sbCxsLmV4cG9ydHMsZSx0LG4scil9cmV0dXJuIG5bb10uZXhwb3J0c312YXIgaT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2Zvcih2YXIgbz0wO288ci5sZW5ndGg7bysrKXMocltvXSk7cmV0dXJuIHN9KSIsIihmdW5jdGlvbiAoZ2xvYmFsKXtcblxudmFyIHN0YXRlID0gcmVxdWlyZSgnLi9pbmNsdWRlcy9zdGF0ZScpO1xudmFyIHBsdWdpbiA9IHJlcXVpcmUoJy4vaW5jbHVkZXMvcGx1Z2luJyk7XG5cblxuKGZ1bmN0aW9uICggJCApIHtcblxuXHRcInVzZSBzdHJpY3RcIjtcblxuXHQkKGZ1bmN0aW9uICgpIHtcblxuXHRcdGlmICghT2JqZWN0LmtleXMpIHtcblx0XHQgIE9iamVjdC5rZXlzID0gKGZ1bmN0aW9uICgpIHtcblx0XHRcdCd1c2Ugc3RyaWN0Jztcblx0XHRcdHZhciBoYXNPd25Qcm9wZXJ0eSA9IE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHksXG5cdFx0XHRcdGhhc0RvbnRFbnVtQnVnID0gISh7dG9TdHJpbmc6IG51bGx9KS5wcm9wZXJ0eUlzRW51bWVyYWJsZSgndG9TdHJpbmcnKSxcblx0XHRcdFx0ZG9udEVudW1zID0gW1xuXHRcdFx0XHQgICd0b1N0cmluZycsXG5cdFx0XHRcdCAgJ3RvTG9jYWxlU3RyaW5nJyxcblx0XHRcdFx0ICAndmFsdWVPZicsXG5cdFx0XHRcdCAgJ2hhc093blByb3BlcnR5Jyxcblx0XHRcdFx0ICAnaXNQcm90b3R5cGVPZicsXG5cdFx0XHRcdCAgJ3Byb3BlcnR5SXNFbnVtZXJhYmxlJyxcblx0XHRcdFx0ICAnY29uc3RydWN0b3InXG5cdFx0XHRcdF0sXG5cdFx0XHRcdGRvbnRFbnVtc0xlbmd0aCA9IGRvbnRFbnVtcy5sZW5ndGg7XG5cblx0XHRcdHJldHVybiBmdW5jdGlvbiAob2JqKSB7XG5cdFx0XHQgIGlmICh0eXBlb2Ygb2JqICE9PSAnb2JqZWN0JyAmJiAodHlwZW9mIG9iaiAhPT0gJ2Z1bmN0aW9uJyB8fCBvYmogPT09IG51bGwpKSB7XG5cdFx0XHRcdHRocm93IG5ldyBUeXBlRXJyb3IoJ09iamVjdC5rZXlzIGNhbGxlZCBvbiBub24tb2JqZWN0Jyk7XG5cdFx0XHQgIH1cblxuXHRcdFx0ICB2YXIgcmVzdWx0ID0gW10sIHByb3AsIGk7XG5cblx0XHRcdCAgZm9yIChwcm9wIGluIG9iaikge1xuXHRcdFx0XHRpZiAoaGFzT3duUHJvcGVydHkuY2FsbChvYmosIHByb3ApKSB7XG5cdFx0XHRcdCAgcmVzdWx0LnB1c2gocHJvcCk7XG5cdFx0XHRcdH1cblx0XHRcdCAgfVxuXG5cdFx0XHQgIGlmIChoYXNEb250RW51bUJ1Zykge1xuXHRcdFx0XHRmb3IgKGkgPSAwOyBpIDwgZG9udEVudW1zTGVuZ3RoOyBpKyspIHtcblx0XHRcdFx0ICBpZiAoaGFzT3duUHJvcGVydHkuY2FsbChvYmosIGRvbnRFbnVtc1tpXSkpIHtcblx0XHRcdFx0XHRyZXN1bHQucHVzaChkb250RW51bXNbaV0pO1xuXHRcdFx0XHQgIH1cblx0XHRcdFx0fVxuXHRcdFx0ICB9XG5cdFx0XHQgIHJldHVybiByZXN1bHQ7XG5cdFx0XHR9O1xuXHRcdCAgfSgpKTtcblx0XHR9XG5cblx0XHQvKiBTZWFyY2ggJiBGaWx0ZXIgalF1ZXJ5IFBsdWdpbiAqL1xuXHRcdCQuZm4uc2VhcmNoQW5kRmlsdGVyID0gcGx1Z2luO1xuXG5cdFx0LyogaW5pdCAqL1xuXHRcdCQoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLnNlYXJjaEFuZEZpbHRlcigpO1xuXG5cdFx0LyogZXh0ZXJuYWwgY29udHJvbHMgKi9cblx0XHQkKGRvY3VtZW50KS5vbihcImNsaWNrXCIsIFwiLnNlYXJjaC1maWx0ZXItcmVzZXRcIiwgZnVuY3Rpb24oZSl7XG5cblx0XHRcdGUucHJldmVudERlZmF1bHQoKTtcblxuXHRcdFx0dmFyIHNlYXJjaEZvcm1JRCA9IHR5cGVvZigkKHRoaXMpLmF0dHIoXCJkYXRhLXNlYXJjaC1mb3JtLWlkXCIpKSE9XCJ1bmRlZmluZWRcIiA/ICQodGhpcykuYXR0cihcImRhdGEtc2VhcmNoLWZvcm0taWRcIikgOiBcIlwiO1xuXHRcdFx0dmFyIHN1Ym1pdEZvcm0gPSB0eXBlb2YoJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1zdWJtaXQtZm9ybVwiKSkhPVwidW5kZWZpbmVkXCIgPyAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLXN1Ym1pdC1mb3JtXCIpIDogXCJcIjtcblxuXHRcdFx0c3RhdGUuZ2V0U2VhcmNoRm9ybShzZWFyY2hGb3JtSUQpLnJlc2V0KHN1Ym1pdEZvcm0pO1xuXG5cdFx0XHQvL3ZhciAkbGlua2VkID0gJChcIiNzZWFyY2gtZmlsdGVyLWZvcm0tXCIrc2VhcmNoRm9ybUlEKS5zZWFyY2hGaWx0ZXJGb3JtKHthY3Rpb246IFwicmVzZXRcIn0pO1xuXG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cblx0XHR9KTtcblxuXHR9KTtcblxuXG4vKlxuICogalF1ZXJ5IEVhc2luZyB2MS40LjEgLSBodHRwOi8vZ3NnZC5jby51ay9zYW5kYm94L2pxdWVyeS9lYXNpbmcvXG4gKiBPcGVuIHNvdXJjZSB1bmRlciB0aGUgQlNEIExpY2Vuc2UuXG4gKiBDb3B5cmlnaHQgwqkgMjAwOCBHZW9yZ2UgTWNHaW5sZXkgU21pdGhcbiAqIEFsbCByaWdodHMgcmVzZXJ2ZWQuXG4gKiBodHRwczovL3Jhdy5naXRodWIuY29tL2dkc21pdGgvanF1ZXJ5LmVhc2luZy9tYXN0ZXIvTElDRU5TRVxuKi9cblxuLyogZ2xvYmFscyBqUXVlcnksIGRlZmluZSwgbW9kdWxlLCByZXF1aXJlICovXG4oZnVuY3Rpb24gKGZhY3RvcnkpIHtcblx0aWYgKHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kKSB7XG5cdFx0ZGVmaW5lKFsnanF1ZXJ5J10sIGZ1bmN0aW9uICgkKSB7XG5cdFx0XHRyZXR1cm4gZmFjdG9yeSgkKTtcblx0XHR9KTtcblx0fSBlbHNlIGlmICh0eXBlb2YgbW9kdWxlID09PSBcIm9iamVjdFwiICYmIHR5cGVvZiBtb2R1bGUuZXhwb3J0cyA9PT0gXCJvYmplY3RcIikge1xuXHRcdG1vZHVsZS5leHBvcnRzID0gZmFjdG9yeSgodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpKTtcblx0fSBlbHNlIHtcblx0XHRmYWN0b3J5KGpRdWVyeSk7XG5cdH1cbn0pKGZ1bmN0aW9uKCQpe1xuXG5cdC8vIFByZXNlcnZlIHRoZSBvcmlnaW5hbCBqUXVlcnkgXCJzd2luZ1wiIGVhc2luZyBhcyBcImpzd2luZ1wiXG5cdGlmICh0eXBlb2YgJC5lYXNpbmcgIT09ICd1bmRlZmluZWQnKSB7XG5cdFx0JC5lYXNpbmdbJ2pzd2luZyddID0gJC5lYXNpbmdbJ3N3aW5nJ107XG5cdH1cblxuXHR2YXIgcG93ID0gTWF0aC5wb3csXG5cdFx0c3FydCA9IE1hdGguc3FydCxcblx0XHRzaW4gPSBNYXRoLnNpbixcblx0XHRjb3MgPSBNYXRoLmNvcyxcblx0XHRQSSA9IE1hdGguUEksXG5cdFx0YzEgPSAxLjcwMTU4LFxuXHRcdGMyID0gYzEgKiAxLjUyNSxcblx0XHRjMyA9IGMxICsgMSxcblx0XHRjNCA9ICggMiAqIFBJICkgLyAzLFxuXHRcdGM1ID0gKCAyICogUEkgKSAvIDQuNTtcblxuXHQvLyB4IGlzIHRoZSBmcmFjdGlvbiBvZiBhbmltYXRpb24gcHJvZ3Jlc3MsIGluIHRoZSByYW5nZSAwLi4xXG5cdGZ1bmN0aW9uIGJvdW5jZU91dCh4KSB7XG5cdFx0dmFyIG4xID0gNy41NjI1LFxuXHRcdFx0ZDEgPSAyLjc1O1xuXHRcdGlmICggeCA8IDEvZDEgKSB7XG5cdFx0XHRyZXR1cm4gbjEqeCp4O1xuXHRcdH0gZWxzZSBpZiAoIHggPCAyL2QxICkge1xuXHRcdFx0cmV0dXJuIG4xKih4LT0oMS41L2QxKSkqeCArIC43NTtcblx0XHR9IGVsc2UgaWYgKCB4IDwgMi41L2QxICkge1xuXHRcdFx0cmV0dXJuIG4xKih4LT0oMi4yNS9kMSkpKnggKyAuOTM3NTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0cmV0dXJuIG4xKih4LT0oMi42MjUvZDEpKSp4ICsgLjk4NDM3NTtcblx0XHR9XG5cdH1cblxuXHQkLmV4dGVuZCggJC5lYXNpbmcsIHtcblx0XHRkZWY6ICdlYXNlT3V0UXVhZCcsXG5cdFx0c3dpbmc6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4gJC5lYXNpbmdbJC5lYXNpbmcuZGVmXSh4KTtcblx0XHR9LFxuXHRcdGVhc2VJblF1YWQ6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCAqIHg7XG5cdFx0fSxcblx0XHRlYXNlT3V0UXVhZDogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiAxIC0gKCAxIC0geCApICogKCAxIC0geCApO1xuXHRcdH0sXG5cdFx0ZWFzZUluT3V0UXVhZDogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4IDwgMC41ID9cblx0XHRcdFx0MiAqIHggKiB4IDpcblx0XHRcdFx0MSAtIHBvdyggLTIgKiB4ICsgMiwgMiApIC8gMjtcblx0XHR9LFxuXHRcdGVhc2VJbkN1YmljOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggKiB4ICogeDtcblx0XHR9LFxuXHRcdGVhc2VPdXRDdWJpYzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiAxIC0gcG93KCAxIC0geCwgMyApO1xuXHRcdH0sXG5cdFx0ZWFzZUluT3V0Q3ViaWM6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XG5cdFx0XHRcdDQgKiB4ICogeCAqIHggOlxuXHRcdFx0XHQxIC0gcG93KCAtMiAqIHggKyAyLCAzICkgLyAyO1xuXHRcdH0sXG5cdFx0ZWFzZUluUXVhcnQ6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCAqIHggKiB4ICogeDtcblx0XHR9LFxuXHRcdGVhc2VPdXRRdWFydDogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiAxIC0gcG93KCAxIC0geCwgNCApO1xuXHRcdH0sXG5cdFx0ZWFzZUluT3V0UXVhcnQ6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XG5cdFx0XHRcdDggKiB4ICogeCAqIHggKiB4IDpcblx0XHRcdFx0MSAtIHBvdyggLTIgKiB4ICsgMiwgNCApIC8gMjtcblx0XHR9LFxuXHRcdGVhc2VJblF1aW50OiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggKiB4ICogeCAqIHggKiB4O1xuXHRcdH0sXG5cdFx0ZWFzZU91dFF1aW50OiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCA1ICk7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRRdWludDogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4IDwgMC41ID9cblx0XHRcdFx0MTYgKiB4ICogeCAqIHggKiB4ICogeCA6XG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDUgKSAvIDI7XG5cdFx0fSxcblx0XHRlYXNlSW5TaW5lOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIDEgLSBjb3MoIHggKiBQSS8yICk7XG5cdFx0fSxcblx0XHRlYXNlT3V0U2luZTogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiBzaW4oIHggKiBQSS8yICk7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRTaW5lOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIC0oIGNvcyggUEkgKiB4ICkgLSAxICkgLyAyO1xuXHRcdH0sXG5cdFx0ZWFzZUluRXhwbzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHBvdyggMiwgMTAgKiB4IC0gMTAgKTtcblx0XHR9LFxuXHRcdGVhc2VPdXRFeHBvOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPT09IDEgPyAxIDogMSAtIHBvdyggMiwgLTEwICogeCApO1xuXHRcdH0sXG5cdFx0ZWFzZUluT3V0RXhwbzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHggPT09IDEgPyAxIDogeCA8IDAuNSA/XG5cdFx0XHRcdHBvdyggMiwgMjAgKiB4IC0gMTAgKSAvIDIgOlxuXHRcdFx0XHQoIDIgLSBwb3coIDIsIC0yMCAqIHggKyAxMCApICkgLyAyO1xuXHRcdH0sXG5cdFx0ZWFzZUluQ2lyYzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiAxIC0gc3FydCggMSAtIHBvdyggeCwgMiApICk7XG5cdFx0fSxcblx0XHRlYXNlT3V0Q2lyYzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiBzcXJ0KCAxIC0gcG93KCB4IC0gMSwgMiApICk7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRDaXJjOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xuXHRcdFx0XHQoIDEgLSBzcXJ0KCAxIC0gcG93KCAyICogeCwgMiApICkgKSAvIDIgOlxuXHRcdFx0XHQoIHNxcnQoIDEgLSBwb3coIC0yICogeCArIDIsIDIgKSApICsgMSApIC8gMjtcblx0XHR9LFxuXHRcdGVhc2VJbkVsYXN0aWM6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6XG5cdFx0XHRcdC1wb3coIDIsIDEwICogeCAtIDEwICkgKiBzaW4oICggeCAqIDEwIC0gMTAuNzUgKSAqIGM0ICk7XG5cdFx0fSxcblx0XHRlYXNlT3V0RWxhc3RpYzogZnVuY3Rpb24gKHgpIHtcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHggPT09IDEgPyAxIDpcblx0XHRcdFx0cG93KCAyLCAtMTAgKiB4ICkgKiBzaW4oICggeCAqIDEwIC0gMC43NSApICogYzQgKSArIDE7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRFbGFzdGljOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPT09IDAgPyAwIDogeCA9PT0gMSA/IDEgOiB4IDwgMC41ID9cblx0XHRcdFx0LSggcG93KCAyLCAyMCAqIHggLSAxMCApICogc2luKCAoIDIwICogeCAtIDExLjEyNSApICogYzUgKSkgLyAyIDpcblx0XHRcdFx0cG93KCAyLCAtMjAgKiB4ICsgMTAgKSAqIHNpbiggKCAyMCAqIHggLSAxMS4xMjUgKSAqIGM1ICkgLyAyICsgMTtcblx0XHR9LFxuXHRcdGVhc2VJbkJhY2s6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4gYzMgKiB4ICogeCAqIHggLSBjMSAqIHggKiB4O1xuXHRcdH0sXG5cdFx0ZWFzZU91dEJhY2s6IGZ1bmN0aW9uICh4KSB7XG5cdFx0XHRyZXR1cm4gMSArIGMzICogcG93KCB4IC0gMSwgMyApICsgYzEgKiBwb3coIHggLSAxLCAyICk7XG5cdFx0fSxcblx0XHRlYXNlSW5PdXRCYWNrOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xuXHRcdFx0XHQoIHBvdyggMiAqIHgsIDIgKSAqICggKCBjMiArIDEgKSAqIDIgKiB4IC0gYzIgKSApIC8gMiA6XG5cdFx0XHRcdCggcG93KCAyICogeCAtIDIsIDIgKSAqKCAoIGMyICsgMSApICogKCB4ICogMiAtIDIgKSArIGMyICkgKyAyICkgLyAyO1xuXHRcdH0sXG5cdFx0ZWFzZUluQm91bmNlOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIDEgLSBib3VuY2VPdXQoIDEgLSB4ICk7XG5cdFx0fSxcblx0XHRlYXNlT3V0Qm91bmNlOiBib3VuY2VPdXQsXG5cdFx0ZWFzZUluT3V0Qm91bmNlOiBmdW5jdGlvbiAoeCkge1xuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xuXHRcdFx0XHQoIDEgLSBib3VuY2VPdXQoIDEgLSAyICogeCApICkgLyAyIDpcblx0XHRcdFx0KCAxICsgYm91bmNlT3V0KCAyICogeCAtIDEgKSApIC8gMjtcblx0XHR9XG5cdH0pO1xuXHRyZXR1cm4gJDtcbn0pO1xuXG59KGpRdWVyeSkpO1xuXG4vL3NhZmFyaSBiYWNrIGJ1dHRvbiBmaXhcbmpRdWVyeSggd2luZG93ICkub24oIFwicGFnZXNob3dcIiwgZnVuY3Rpb24oZXZlbnQpIHtcbiAgICBpZiAoZXZlbnQub3JpZ2luYWxFdmVudC5wZXJzaXN0ZWQpIHtcbiAgICAgICAgalF1ZXJ5KFwiLnNlYXJjaGFuZGZpbHRlclwiKS5vZmYoKTtcbiAgICAgICAgalF1ZXJ5KFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcbiAgICB9XG59KTtcblxuLyogd3BudW1iIC0gbm91aXNsaWRlciBudW1iZXIgZm9ybWF0dGluZyAqL1xuIWZ1bmN0aW9uKCl7XCJ1c2Ugc3RyaWN0XCI7ZnVuY3Rpb24gZShlKXtyZXR1cm4gZS5zcGxpdChcIlwiKS5yZXZlcnNlKCkuam9pbihcIlwiKX1mdW5jdGlvbiBuKGUsbil7cmV0dXJuIGUuc3Vic3RyaW5nKDAsbi5sZW5ndGgpPT09bn1mdW5jdGlvbiByKGUsbil7cmV0dXJuIGUuc2xpY2UoLTEqbi5sZW5ndGgpPT09bn1mdW5jdGlvbiB0KGUsbixyKXtpZigoZVtuXXx8ZVtyXSkmJmVbbl09PT1lW3JdKXRocm93IG5ldyBFcnJvcihuKX1mdW5jdGlvbiBpKGUpe3JldHVyblwibnVtYmVyXCI9PXR5cGVvZiBlJiZpc0Zpbml0ZShlKX1mdW5jdGlvbiBvKGUsbil7dmFyIHI9TWF0aC5wb3coMTAsbik7cmV0dXJuKE1hdGgucm91bmQoZSpyKS9yKS50b0ZpeGVkKG4pfWZ1bmN0aW9uIHUobixyLHQsdSxmLGEsYyxzLHAsZCxsLGgpe3ZhciBnLHYsdyxtPWgseD1cIlwiLGI9XCJcIjtyZXR1cm4gYSYmKGg9YShoKSksaShoKT8obiE9PSExJiYwPT09cGFyc2VGbG9hdChoLnRvRml4ZWQobikpJiYoaD0wKSwwPmgmJihnPSEwLGg9TWF0aC5hYnMoaCkpLG4hPT0hMSYmKGg9byhoLG4pKSxoPWgudG9TdHJpbmcoKSwtMSE9PWguaW5kZXhPZihcIi5cIik/KHY9aC5zcGxpdChcIi5cIiksdz12WzBdLHQmJih4PXQrdlsxXSkpOnc9aCxyJiYodz1lKHcpLm1hdGNoKC8uezEsM30vZyksdz1lKHcuam9pbihlKHIpKSkpLGcmJnMmJihiKz1zKSx1JiYoYis9dSksZyYmcCYmKGIrPXApLGIrPXcsYis9eCxmJiYoYis9ZiksZCYmKGI9ZChiLG0pKSxiKTohMX1mdW5jdGlvbiBmKGUsdCxvLHUsZixhLGMscyxwLGQsbCxoKXt2YXIgZyx2PVwiXCI7cmV0dXJuIGwmJihoPWwoaCkpLGgmJlwic3RyaW5nXCI9PXR5cGVvZiBoPyhzJiZuKGgscykmJihoPWgucmVwbGFjZShzLFwiXCIpLGc9ITApLHUmJm4oaCx1KSYmKGg9aC5yZXBsYWNlKHUsXCJcIikpLHAmJm4oaCxwKSYmKGg9aC5yZXBsYWNlKHAsXCJcIiksZz0hMCksZiYmcihoLGYpJiYoaD1oLnNsaWNlKDAsLTEqZi5sZW5ndGgpKSx0JiYoaD1oLnNwbGl0KHQpLmpvaW4oXCJcIikpLG8mJihoPWgucmVwbGFjZShvLFwiLlwiKSksZyYmKHYrPVwiLVwiKSx2Kz1oLHY9di5yZXBsYWNlKC9bXjAtOVxcLlxcLS5dL2csXCJcIiksXCJcIj09PXY/ITE6KHY9TnVtYmVyKHYpLGMmJih2PWModikpLGkodik/djohMSkpOiExfWZ1bmN0aW9uIGEoZSl7dmFyIG4scixpLG89e307Zm9yKG49MDtuPHAubGVuZ3RoO24rPTEpaWYocj1wW25dLGk9ZVtyXSx2b2lkIDA9PT1pKVwibmVnYXRpdmVcIiE9PXJ8fG8ubmVnYXRpdmVCZWZvcmU/XCJtYXJrXCI9PT1yJiZcIi5cIiE9PW8udGhvdXNhbmQ/b1tyXT1cIi5cIjpvW3JdPSExOm9bcl09XCItXCI7ZWxzZSBpZihcImRlY2ltYWxzXCI9PT1yKXtpZighKGk+PTAmJjg+aSkpdGhyb3cgbmV3IEVycm9yKHIpO29bcl09aX1lbHNlIGlmKFwiZW5jb2RlclwiPT09cnx8XCJkZWNvZGVyXCI9PT1yfHxcImVkaXRcIj09PXJ8fFwidW5kb1wiPT09cil7aWYoXCJmdW5jdGlvblwiIT10eXBlb2YgaSl0aHJvdyBuZXcgRXJyb3Iocik7b1tyXT1pfWVsc2V7aWYoXCJzdHJpbmdcIiE9dHlwZW9mIGkpdGhyb3cgbmV3IEVycm9yKHIpO29bcl09aX1yZXR1cm4gdChvLFwibWFya1wiLFwidGhvdXNhbmRcIiksdChvLFwicHJlZml4XCIsXCJuZWdhdGl2ZVwiKSx0KG8sXCJwcmVmaXhcIixcIm5lZ2F0aXZlQmVmb3JlXCIpLG99ZnVuY3Rpb24gYyhlLG4scil7dmFyIHQsaT1bXTtmb3IodD0wO3Q8cC5sZW5ndGg7dCs9MSlpLnB1c2goZVtwW3RdXSk7cmV0dXJuIGkucHVzaChyKSxuLmFwcGx5KFwiXCIsaSl9ZnVuY3Rpb24gcyhlKXtyZXR1cm4gdGhpcyBpbnN0YW5jZW9mIHM/dm9pZChcIm9iamVjdFwiPT10eXBlb2YgZSYmKGU9YShlKSx0aGlzLnRvPWZ1bmN0aW9uKG4pe3JldHVybiBjKGUsdSxuKX0sdGhpcy5mcm9tPWZ1bmN0aW9uKG4pe3JldHVybiBjKGUsZixuKX0pKTpuZXcgcyhlKX12YXIgcD1bXCJkZWNpbWFsc1wiLFwidGhvdXNhbmRcIixcIm1hcmtcIixcInByZWZpeFwiLFwicG9zdGZpeFwiLFwiZW5jb2RlclwiLFwiZGVjb2RlclwiLFwibmVnYXRpdmVCZWZvcmVcIixcIm5lZ2F0aXZlXCIsXCJlZGl0XCIsXCJ1bmRvXCJdO3dpbmRvdy53TnVtYj1zfSgpO1xuXG5cbn0pLmNhbGwodGhpcyx0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsIDogdHlwZW9mIHNlbGYgIT09IFwidW5kZWZpbmVkXCIgPyBzZWxmIDogdHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvdyA6IHt9KVxuLy8jIHNvdXJjZU1hcHBpbmdVUkw9ZGF0YTphcHBsaWNhdGlvbi9qc29uO2NoYXJzZXQ6dXRmLTg7YmFzZTY0LGV5SjJaWEp6YVc5dUlqb3pMQ0p6YjNWeVkyVnpJanBiSW5OeVl5OXdkV0pzYVdNdllYTnpaWFJ6TDJwekwyRndjQzVxY3lKZExDSnVZVzFsY3lJNlcxMHNJbTFoY0hCcGJtZHpJam9pTzBGQlFVRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFTSXNJbVpwYkdVaU9pSm5aVzVsY21GMFpXUXVhbk1pTENKemIzVnlZMlZTYjI5MElqb2lJaXdpYzI5MWNtTmxjME52Ym5SbGJuUWlPbHNpWEc1MllYSWdjM1JoZEdVZ1BTQnlaWEYxYVhKbEtDY3VMMmx1WTJ4MVpHVnpMM04wWVhSbEp5azdYRzUyWVhJZ2NHeDFaMmx1SUQwZ2NtVnhkV2x5WlNnbkxpOXBibU5zZFdSbGN5OXdiSFZuYVc0bktUdGNibHh1WEc0b1puVnVZM1JwYjI0Z0tDQWtJQ2tnZTF4dVhHNWNkRndpZFhObElITjBjbWxqZEZ3aU8xeHVYRzVjZENRb1puVnVZM1JwYjI0Z0tDa2dlMXh1WEc1Y2RGeDBhV1lnS0NGUFltcGxZM1F1YTJWNWN5a2dlMXh1WEhSY2RDQWdUMkpxWldOMExtdGxlWE1nUFNBb1puVnVZM1JwYjI0Z0tDa2dlMXh1WEhSY2RGeDBKM1Z6WlNCemRISnBZM1FuTzF4dVhIUmNkRngwZG1GeUlHaGhjMDkzYmxCeWIzQmxjblI1SUQwZ1QySnFaV04wTG5CeWIzUnZkSGx3WlM1b1lYTlBkMjVRY205d1pYSjBlU3hjYmx4MFhIUmNkRngwYUdGelJHOXVkRVZ1ZFcxQ2RXY2dQU0FoS0h0MGIxTjBjbWx1WnpvZ2JuVnNiSDBwTG5CeWIzQmxjblI1U1hORmJuVnRaWEpoWW14bEtDZDBiMU4wY21sdVp5Y3BMRnh1WEhSY2RGeDBYSFJrYjI1MFJXNTFiWE1nUFNCYlhHNWNkRngwWEhSY2RDQWdKM1J2VTNSeWFXNW5KeXhjYmx4MFhIUmNkRngwSUNBbmRHOU1iMk5oYkdWVGRISnBibWNuTEZ4dVhIUmNkRngwWEhRZ0lDZDJZV3gxWlU5bUp5eGNibHgwWEhSY2RGeDBJQ0FuYUdGelQzZHVVSEp2Y0dWeWRIa25MRnh1WEhSY2RGeDBYSFFnSUNkcGMxQnliM1J2ZEhsd1pVOW1KeXhjYmx4MFhIUmNkRngwSUNBbmNISnZjR1Z5ZEhsSmMwVnVkVzFsY21GaWJHVW5MRnh1WEhSY2RGeDBYSFFnSUNkamIyNXpkSEoxWTNSdmNpZGNibHgwWEhSY2RGeDBYU3hjYmx4MFhIUmNkRngwWkc5dWRFVnVkVzF6VEdWdVozUm9JRDBnWkc5dWRFVnVkVzF6TG14bGJtZDBhRHRjYmx4dVhIUmNkRngwY21WMGRYSnVJR1oxYm1OMGFXOXVJQ2h2WW1vcElIdGNibHgwWEhSY2RDQWdhV1lnS0hSNWNHVnZaaUJ2WW1vZ0lUMDlJQ2R2WW1wbFkzUW5JQ1ltSUNoMGVYQmxiMllnYjJKcUlDRTlQU0FuWm5WdVkzUnBiMjRuSUh4OElHOWlhaUE5UFQwZ2JuVnNiQ2twSUh0Y2JseDBYSFJjZEZ4MGRHaHliM2NnYm1WM0lGUjVjR1ZGY25KdmNpZ25UMkpxWldOMExtdGxlWE1nWTJGc2JHVmtJRzl1SUc1dmJpMXZZbXBsWTNRbktUdGNibHgwWEhSY2RDQWdmVnh1WEc1Y2RGeDBYSFFnSUhaaGNpQnlaWE4xYkhRZ1BTQmJYU3dnY0hKdmNDd2dhVHRjYmx4dVhIUmNkRngwSUNCbWIzSWdLSEJ5YjNBZ2FXNGdiMkpxS1NCN1hHNWNkRngwWEhSY2RHbG1JQ2hvWVhOUGQyNVFjbTl3WlhKMGVTNWpZV3hzS0c5aWFpd2djSEp2Y0NrcElIdGNibHgwWEhSY2RGeDBJQ0J5WlhOMWJIUXVjSFZ6YUNod2NtOXdLVHRjYmx4MFhIUmNkRngwZlZ4dVhIUmNkRngwSUNCOVhHNWNibHgwWEhSY2RDQWdhV1lnS0doaGMwUnZiblJGYm5WdFFuVm5LU0I3WEc1Y2RGeDBYSFJjZEdadmNpQW9hU0E5SURBN0lHa2dQQ0JrYjI1MFJXNTFiWE5NWlc1bmRHZzdJR2tyS3lrZ2UxeHVYSFJjZEZ4MFhIUWdJR2xtSUNob1lYTlBkMjVRY205d1pYSjBlUzVqWVd4c0tHOWlhaXdnWkc5dWRFVnVkVzF6VzJsZEtTa2dlMXh1WEhSY2RGeDBYSFJjZEhKbGMzVnNkQzV3ZFhOb0tHUnZiblJGYm5WdGMxdHBYU2s3WEc1Y2RGeDBYSFJjZENBZ2ZWeHVYSFJjZEZ4MFhIUjlYRzVjZEZ4MFhIUWdJSDFjYmx4MFhIUmNkQ0FnY21WMGRYSnVJSEpsYzNWc2REdGNibHgwWEhSY2RIMDdYRzVjZEZ4MElDQjlLQ2twTzF4dVhIUmNkSDFjYmx4dVhIUmNkQzhxSUZObFlYSmphQ0FtSUVacGJIUmxjaUJxVVhWbGNua2dVR3gxWjJsdUlDb3ZYRzVjZEZ4MEpDNW1iaTV6WldGeVkyaEJibVJHYVd4MFpYSWdQU0J3YkhWbmFXNDdYRzVjYmx4MFhIUXZLaUJwYm1sMElDb3ZYRzVjZEZ4MEpDaGNJaTV6WldGeVkyaGhibVJtYVd4MFpYSmNJaWt1YzJWaGNtTm9RVzVrUm1sc2RHVnlLQ2s3WEc1Y2JseDBYSFF2S2lCbGVIUmxjbTVoYkNCamIyNTBjbTlzY3lBcUwxeHVYSFJjZENRb1pHOWpkVzFsYm5RcExtOXVLRndpWTJ4cFkydGNJaXdnWENJdWMyVmhjbU5vTFdacGJIUmxjaTF5WlhObGRGd2lMQ0JtZFc1amRHbHZiaWhsS1h0Y2JseHVYSFJjZEZ4MFpTNXdjbVYyWlc1MFJHVm1ZWFZzZENncE8xeHVYRzVjZEZ4MFhIUjJZWElnYzJWaGNtTm9SbTl5YlVsRUlEMGdkSGx3Wlc5bUtDUW9kR2hwY3lrdVlYUjBjaWhjSW1SaGRHRXRjMlZoY21Ob0xXWnZjbTB0YVdSY0lpa3BJVDFjSW5WdVpHVm1hVzVsWkZ3aUlEOGdKQ2gwYUdsektTNWhkSFJ5S0Z3aVpHRjBZUzF6WldGeVkyZ3RabTl5YlMxcFpGd2lLU0E2SUZ3aVhDSTdYRzVjZEZ4MFhIUjJZWElnYzNWaWJXbDBSbTl5YlNBOUlIUjVjR1Z2Wmlna0tIUm9hWE1wTG1GMGRISW9YQ0prWVhSaExYTm1MWE4xWW0xcGRDMW1iM0p0WENJcEtTRTlYQ0oxYm1SbFptbHVaV1JjSWlBL0lDUW9kR2hwY3lrdVlYUjBjaWhjSW1SaGRHRXRjMll0YzNWaWJXbDBMV1p2Y20xY0lpa2dPaUJjSWx3aU8xeHVYRzVjZEZ4MFhIUnpkR0YwWlM1blpYUlRaV0Z5WTJoR2IzSnRLSE5sWVhKamFFWnZjbTFKUkNrdWNtVnpaWFFvYzNWaWJXbDBSbTl5YlNrN1hHNWNibHgwWEhSY2RDOHZkbUZ5SUNSc2FXNXJaV1FnUFNBa0tGd2lJM05sWVhKamFDMW1hV3gwWlhJdFptOXliUzFjSWl0elpXRnlZMmhHYjNKdFNVUXBMbk5sWVhKamFFWnBiSFJsY2tadmNtMG9lMkZqZEdsdmJqb2dYQ0p5WlhObGRGd2lmU2s3WEc1Y2JseDBYSFJjZEhKbGRIVnliaUJtWVd4elpUdGNibHh1WEhSY2RIMHBPMXh1WEc1Y2RIMHBPMXh1WEc1Y2JpOHFYRzRnS2lCcVVYVmxjbmtnUldGemFXNW5JSFl4TGpRdU1TQXRJR2gwZEhBNkx5OW5jMmRrTG1OdkxuVnJMM05oYm1SaWIzZ3ZhbkYxWlhKNUwyVmhjMmx1Wnk5Y2JpQXFJRTl3Wlc0Z2MyOTFjbU5sSUhWdVpHVnlJSFJvWlNCQ1UwUWdUR2xqWlc1elpTNWNiaUFxSUVOdmNIbHlhV2RvZENEQ3FTQXlNREE0SUVkbGIzSm5aU0JOWTBkcGJteGxlU0JUYldsMGFGeHVJQ29nUVd4c0lISnBaMmgwY3lCeVpYTmxjblpsWkM1Y2JpQXFJR2gwZEhCek9pOHZjbUYzTG1kcGRHaDFZaTVqYjIwdloyUnpiV2wwYUM5cWNYVmxjbmt1WldGemFXNW5MMjFoYzNSbGNpOU1TVU5GVGxORlhHNHFMMXh1WEc0dktpQm5iRzlpWVd4eklHcFJkV1Z5ZVN3Z1pHVm1hVzVsTENCdGIyUjFiR1VzSUhKbGNYVnBjbVVnS2k5Y2JpaG1kVzVqZEdsdmJpQW9abUZqZEc5eWVTa2dlMXh1WEhScFppQW9kSGx3Wlc5bUlHUmxabWx1WlNBOVBUMGdYQ0ptZFc1amRHbHZibHdpSUNZbUlHUmxabWx1WlM1aGJXUXBJSHRjYmx4MFhIUmtaV1pwYm1Vb1d5ZHFjWFZsY25rblhTd2dablZ1WTNScGIyNGdLQ1FwSUh0Y2JseDBYSFJjZEhKbGRIVnliaUJtWVdOMGIzSjVLQ1FwTzF4dVhIUmNkSDBwTzF4dVhIUjlJR1ZzYzJVZ2FXWWdLSFI1Y0dWdlppQnRiMlIxYkdVZ1BUMDlJRndpYjJKcVpXTjBYQ0lnSmlZZ2RIbHdaVzltSUcxdlpIVnNaUzVsZUhCdmNuUnpJRDA5UFNCY0ltOWlhbVZqZEZ3aUtTQjdYRzVjZEZ4MGJXOWtkV3hsTG1WNGNHOXlkSE1nUFNCbVlXTjBiM0o1S0NoMGVYQmxiMllnZDJsdVpHOTNJQ0U5UFNCY0luVnVaR1ZtYVc1bFpGd2lJRDhnZDJsdVpHOTNXeWRxVVhWbGNua25YU0E2SUhSNWNHVnZaaUJuYkc5aVlXd2dJVDA5SUZ3aWRXNWtaV1pwYm1Wa1hDSWdQeUJuYkc5aVlXeGJKMnBSZFdWeWVTZGRJRG9nYm5Wc2JDa3BPMXh1WEhSOUlHVnNjMlVnZTF4dVhIUmNkR1poWTNSdmNua29hbEYxWlhKNUtUdGNibHgwZlZ4dWZTa29ablZ1WTNScGIyNG9KQ2w3WEc1Y2JseDBMeThnVUhKbGMyVnlkbVVnZEdobElHOXlhV2RwYm1Gc0lHcFJkV1Z5ZVNCY0luTjNhVzVuWENJZ1pXRnphVzVuSUdGeklGd2lhbk4zYVc1blhDSmNibHgwYVdZZ0tIUjVjR1Z2WmlBa0xtVmhjMmx1WnlBaFBUMGdKM1Z1WkdWbWFXNWxaQ2NwSUh0Y2JseDBYSFFrTG1WaGMybHVaMXNuYW5OM2FXNW5KMTBnUFNBa0xtVmhjMmx1WjFzbmMzZHBibWNuWFR0Y2JseDBmVnh1WEc1Y2RIWmhjaUJ3YjNjZ1BTQk5ZWFJvTG5CdmR5eGNibHgwWEhSemNYSjBJRDBnVFdGMGFDNXpjWEowTEZ4dVhIUmNkSE5wYmlBOUlFMWhkR2d1YzJsdUxGeHVYSFJjZEdOdmN5QTlJRTFoZEdndVkyOXpMRnh1WEhSY2RGQkpJRDBnVFdGMGFDNVFTU3hjYmx4MFhIUmpNU0E5SURFdU56QXhOVGdzWEc1Y2RGeDBZeklnUFNCak1TQXFJREV1TlRJMUxGeHVYSFJjZEdNeklEMGdZekVnS3lBeExGeHVYSFJjZEdNMElEMGdLQ0F5SUNvZ1VFa2dLU0F2SURNc1hHNWNkRngwWXpVZ1BTQW9JRElnS2lCUVNTQXBJQzhnTkM0MU8xeHVYRzVjZEM4dklIZ2dhWE1nZEdobElHWnlZV04wYVc5dUlHOW1JR0Z1YVcxaGRHbHZiaUJ3Y205bmNtVnpjeXdnYVc0Z2RHaGxJSEpoYm1kbElEQXVMakZjYmx4MFpuVnVZM1JwYjI0Z1ltOTFibU5sVDNWMEtIZ3BJSHRjYmx4MFhIUjJZWElnYmpFZ1BTQTNMalUyTWpVc1hHNWNkRngwWEhSa01TQTlJREl1TnpVN1hHNWNkRngwYVdZZ0tDQjRJRHdnTVM5a01TQXBJSHRjYmx4MFhIUmNkSEpsZEhWeWJpQnVNU3A0S25nN1hHNWNkRngwZlNCbGJITmxJR2xtSUNnZ2VDQThJREl2WkRFZ0tTQjdYRzVjZEZ4MFhIUnlaWFIxY200Z2JqRXFLSGd0UFNneExqVXZaREVwS1NwNElDc2dMamMxTzF4dVhIUmNkSDBnWld4elpTQnBaaUFvSUhnZ1BDQXlMalV2WkRFZ0tTQjdYRzVjZEZ4MFhIUnlaWFIxY200Z2JqRXFLSGd0UFNneUxqSTFMMlF4S1NrcWVDQXJJQzQ1TXpjMU8xeHVYSFJjZEgwZ1pXeHpaU0I3WEc1Y2RGeDBYSFJ5WlhSMWNtNGdiakVxS0hndFBTZ3lMall5TlM5a01Ta3BLbmdnS3lBdU9UZzBNemMxTzF4dVhIUmNkSDFjYmx4MGZWeHVYRzVjZENRdVpYaDBaVzVrS0NBa0xtVmhjMmx1Wnl3Z2UxeHVYSFJjZEdSbFpqb2dKMlZoYzJWUGRYUlJkV0ZrSnl4Y2JseDBYSFJ6ZDJsdVp6b2dablZ1WTNScGIyNGdLSGdwSUh0Y2JseDBYSFJjZEhKbGRIVnliaUFrTG1WaGMybHVaMXNrTG1WaGMybHVaeTVrWldaZEtIZ3BPMXh1WEhSY2RIMHNYRzVjZEZ4MFpXRnpaVWx1VVhWaFpEb2dablZ1WTNScGIyNGdLSGdwSUh0Y2JseDBYSFJjZEhKbGRIVnliaUI0SUNvZ2VEdGNibHgwWEhSOUxGeHVYSFJjZEdWaGMyVlBkWFJSZFdGa09pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4dVhIUmNkRngwY21WMGRYSnVJREVnTFNBb0lERWdMU0I0SUNrZ0tpQW9JREVnTFNCNElDazdYRzVjZEZ4MGZTeGNibHgwWEhSbFlYTmxTVzVQZFhSUmRXRmtPaUJtZFc1amRHbHZiaUFvZUNrZ2UxeHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ1BDQXdMalVnUDF4dVhIUmNkRngwWEhReUlDb2dlQ0FxSUhnZ09seHVYSFJjZEZ4MFhIUXhJQzBnY0c5M0tDQXRNaUFxSUhnZ0t5QXlMQ0F5SUNrZ0x5QXlPMXh1WEhSY2RIMHNYRzVjZEZ4MFpXRnpaVWx1UTNWaWFXTTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hHNWNkRngwWEhSeVpYUjFjbTRnZUNBcUlIZ2dLaUI0TzF4dVhIUmNkSDBzWEc1Y2RGeDBaV0Z6WlU5MWRFTjFZbWxqT2lCbWRXNWpkR2x2YmlBb2VDa2dlMXh1WEhSY2RGeDBjbVYwZFhKdUlERWdMU0J3YjNjb0lERWdMU0I0TENBeklDazdYRzVjZEZ4MGZTeGNibHgwWEhSbFlYTmxTVzVQZFhSRGRXSnBZem9nWm5WdVkzUnBiMjRnS0hncElIdGNibHgwWEhSY2RISmxkSFZ5YmlCNElEd2dNQzQxSUQ5Y2JseDBYSFJjZEZ4ME5DQXFJSGdnS2lCNElDb2dlQ0E2WEc1Y2RGeDBYSFJjZERFZ0xTQndiM2NvSUMweUlDb2dlQ0FySURJc0lETWdLU0F2SURJN1hHNWNkRngwZlN4Y2JseDBYSFJsWVhObFNXNVJkV0Z5ZERvZ1puVnVZM1JwYjI0Z0tIZ3BJSHRjYmx4MFhIUmNkSEpsZEhWeWJpQjRJQ29nZUNBcUlIZ2dLaUI0TzF4dVhIUmNkSDBzWEc1Y2RGeDBaV0Z6WlU5MWRGRjFZWEowT2lCbWRXNWpkR2x2YmlBb2VDa2dlMXh1WEhSY2RGeDBjbVYwZFhKdUlERWdMU0J3YjNjb0lERWdMU0I0TENBMElDazdYRzVjZEZ4MGZTeGNibHgwWEhSbFlYTmxTVzVQZFhSUmRXRnlkRG9nWm5WdVkzUnBiMjRnS0hncElIdGNibHgwWEhSY2RISmxkSFZ5YmlCNElEd2dNQzQxSUQ5Y2JseDBYSFJjZEZ4ME9DQXFJSGdnS2lCNElDb2dlQ0FxSUhnZ09seHVYSFJjZEZ4MFhIUXhJQzBnY0c5M0tDQXRNaUFxSUhnZ0t5QXlMQ0EwSUNrZ0x5QXlPMXh1WEhSY2RIMHNYRzVjZEZ4MFpXRnpaVWx1VVhWcGJuUTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hHNWNkRngwWEhSeVpYUjFjbTRnZUNBcUlIZ2dLaUI0SUNvZ2VDQXFJSGc3WEc1Y2RGeDBmU3hjYmx4MFhIUmxZWE5sVDNWMFVYVnBiblE2SUdaMWJtTjBhVzl1SUNoNEtTQjdYRzVjZEZ4MFhIUnlaWFIxY200Z01TQXRJSEJ2ZHlnZ01TQXRJSGdzSURVZ0tUdGNibHgwWEhSOUxGeHVYSFJjZEdWaGMyVkpiazkxZEZGMWFXNTBPaUJtZFc1amRHbHZiaUFvZUNrZ2UxeHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ1BDQXdMalVnUDF4dVhIUmNkRngwWEhReE5pQXFJSGdnS2lCNElDb2dlQ0FxSUhnZ0tpQjRJRHBjYmx4MFhIUmNkRngwTVNBdElIQnZkeWdnTFRJZ0tpQjRJQ3NnTWl3Z05TQXBJQzhnTWp0Y2JseDBYSFI5TEZ4dVhIUmNkR1ZoYzJWSmJsTnBibVU2SUdaMWJtTjBhVzl1SUNoNEtTQjdYRzVjZEZ4MFhIUnlaWFIxY200Z01TQXRJR052Y3lnZ2VDQXFJRkJKTHpJZ0tUdGNibHgwWEhSOUxGeHVYSFJjZEdWaGMyVlBkWFJUYVc1bE9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4dVhIUmNkRngwY21WMGRYSnVJSE5wYmlnZ2VDQXFJRkJKTHpJZ0tUdGNibHgwWEhSOUxGeHVYSFJjZEdWaGMyVkpiazkxZEZOcGJtVTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hHNWNkRngwWEhSeVpYUjFjbTRnTFNnZ1kyOXpLQ0JRU1NBcUlIZ2dLU0F0SURFZ0tTQXZJREk3WEc1Y2RGeDBmU3hjYmx4MFhIUmxZWE5sU1c1RmVIQnZPaUJtZFc1amRHbHZiaUFvZUNrZ2UxeHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ1BUMDlJREFnUHlBd0lEb2djRzkzS0NBeUxDQXhNQ0FxSUhnZ0xTQXhNQ0FwTzF4dVhIUmNkSDBzWEc1Y2RGeDBaV0Z6WlU5MWRFVjRjRzg2SUdaMWJtTjBhVzl1SUNoNEtTQjdYRzVjZEZ4MFhIUnlaWFIxY200Z2VDQTlQVDBnTVNBL0lERWdPaUF4SUMwZ2NHOTNLQ0F5TENBdE1UQWdLaUI0SUNrN1hHNWNkRngwZlN4Y2JseDBYSFJsWVhObFNXNVBkWFJGZUhCdk9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4dVhIUmNkRngwY21WMGRYSnVJSGdnUFQwOUlEQWdQeUF3SURvZ2VDQTlQVDBnTVNBL0lERWdPaUI0SUR3Z01DNDFJRDljYmx4MFhIUmNkRngwY0c5M0tDQXlMQ0F5TUNBcUlIZ2dMU0F4TUNBcElDOGdNaUE2WEc1Y2RGeDBYSFJjZENnZ01pQXRJSEJ2ZHlnZ01pd2dMVEl3SUNvZ2VDQXJJREV3SUNrZ0tTQXZJREk3WEc1Y2RGeDBmU3hjYmx4MFhIUmxZWE5sU1c1RGFYSmpPaUJtZFc1amRHbHZiaUFvZUNrZ2UxeHVYSFJjZEZ4MGNtVjBkWEp1SURFZ0xTQnpjWEowS0NBeElDMGdjRzkzS0NCNExDQXlJQ2tnS1R0Y2JseDBYSFI5TEZ4dVhIUmNkR1ZoYzJWUGRYUkRhWEpqT2lCbWRXNWpkR2x2YmlBb2VDa2dlMXh1WEhSY2RGeDBjbVYwZFhKdUlITnhjblFvSURFZ0xTQndiM2NvSUhnZ0xTQXhMQ0F5SUNrZ0tUdGNibHgwWEhSOUxGeHVYSFJjZEdWaGMyVkpiazkxZEVOcGNtTTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hHNWNkRngwWEhSeVpYUjFjbTRnZUNBOElEQXVOU0EvWEc1Y2RGeDBYSFJjZENnZ01TQXRJSE54Y25Rb0lERWdMU0J3YjNjb0lESWdLaUI0TENBeUlDa2dLU0FwSUM4Z01pQTZYRzVjZEZ4MFhIUmNkQ2dnYzNGeWRDZ2dNU0F0SUhCdmR5Z2dMVElnS2lCNElDc2dNaXdnTWlBcElDa2dLeUF4SUNrZ0x5QXlPMXh1WEhSY2RIMHNYRzVjZEZ4MFpXRnpaVWx1Uld4aGMzUnBZem9nWm5WdVkzUnBiMjRnS0hncElIdGNibHgwWEhSY2RISmxkSFZ5YmlCNElEMDlQU0F3SUQ4Z01DQTZJSGdnUFQwOUlERWdQeUF4SURwY2JseDBYSFJjZEZ4MExYQnZkeWdnTWl3Z01UQWdLaUI0SUMwZ01UQWdLU0FxSUhOcGJpZ2dLQ0I0SUNvZ01UQWdMU0F4TUM0M05TQXBJQ29nWXpRZ0tUdGNibHgwWEhSOUxGeHVYSFJjZEdWaGMyVlBkWFJGYkdGemRHbGpPaUJtZFc1amRHbHZiaUFvZUNrZ2UxeHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ1BUMDlJREFnUHlBd0lEb2dlQ0E5UFQwZ01TQS9JREVnT2x4dVhIUmNkRngwWEhSd2IzY29JRElzSUMweE1DQXFJSGdnS1NBcUlITnBiaWdnS0NCNElDb2dNVEFnTFNBd0xqYzFJQ2tnS2lCak5DQXBJQ3NnTVR0Y2JseDBYSFI5TEZ4dVhIUmNkR1ZoYzJWSmJrOTFkRVZzWVhOMGFXTTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hHNWNkRngwWEhSeVpYUjFjbTRnZUNBOVBUMGdNQ0EvSURBZ09pQjRJRDA5UFNBeElEOGdNU0E2SUhnZ1BDQXdMalVnUDF4dVhIUmNkRngwWEhRdEtDQndiM2NvSURJc0lESXdJQ29nZUNBdElERXdJQ2tnS2lCemFXNG9JQ2dnTWpBZ0tpQjRJQzBnTVRFdU1USTFJQ2tnS2lCak5TQXBLU0F2SURJZ09seHVYSFJjZEZ4MFhIUndiM2NvSURJc0lDMHlNQ0FxSUhnZ0t5QXhNQ0FwSUNvZ2MybHVLQ0FvSURJd0lDb2dlQ0F0SURFeExqRXlOU0FwSUNvZ1l6VWdLU0F2SURJZ0t5QXhPMXh1WEhSY2RIMHNYRzVjZEZ4MFpXRnpaVWx1UW1GamF6b2dablZ1WTNScGIyNGdLSGdwSUh0Y2JseDBYSFJjZEhKbGRIVnliaUJqTXlBcUlIZ2dLaUI0SUNvZ2VDQXRJR014SUNvZ2VDQXFJSGc3WEc1Y2RGeDBmU3hjYmx4MFhIUmxZWE5sVDNWMFFtRmphem9nWm5WdVkzUnBiMjRnS0hncElIdGNibHgwWEhSY2RISmxkSFZ5YmlBeElDc2dZek1nS2lCd2IzY29JSGdnTFNBeExDQXpJQ2tnS3lCak1TQXFJSEJ2ZHlnZ2VDQXRJREVzSURJZ0tUdGNibHgwWEhSOUxGeHVYSFJjZEdWaGMyVkpiazkxZEVKaFkyczZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hHNWNkRngwWEhSeVpYUjFjbTRnZUNBOElEQXVOU0EvWEc1Y2RGeDBYSFJjZENnZ2NHOTNLQ0F5SUNvZ2VDd2dNaUFwSUNvZ0tDQW9JR015SUNzZ01TQXBJQ29nTWlBcUlIZ2dMU0JqTWlBcElDa2dMeUF5SURwY2JseDBYSFJjZEZ4MEtDQndiM2NvSURJZ0tpQjRJQzBnTWl3Z01pQXBJQ29vSUNnZ1l6SWdLeUF4SUNrZ0tpQW9JSGdnS2lBeUlDMGdNaUFwSUNzZ1l6SWdLU0FySURJZ0tTQXZJREk3WEc1Y2RGeDBmU3hjYmx4MFhIUmxZWE5sU1c1Q2IzVnVZMlU2SUdaMWJtTjBhVzl1SUNoNEtTQjdYRzVjZEZ4MFhIUnlaWFIxY200Z01TQXRJR0p2ZFc1alpVOTFkQ2dnTVNBdElIZ2dLVHRjYmx4MFhIUjlMRnh1WEhSY2RHVmhjMlZQZFhSQ2IzVnVZMlU2SUdKdmRXNWpaVTkxZEN4Y2JseDBYSFJsWVhObFNXNVBkWFJDYjNWdVkyVTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hHNWNkRngwWEhSeVpYUjFjbTRnZUNBOElEQXVOU0EvWEc1Y2RGeDBYSFJjZENnZ01TQXRJR0p2ZFc1alpVOTFkQ2dnTVNBdElESWdLaUI0SUNrZ0tTQXZJRElnT2x4dVhIUmNkRngwWEhRb0lERWdLeUJpYjNWdVkyVlBkWFFvSURJZ0tpQjRJQzBnTVNBcElDa2dMeUF5TzF4dVhIUmNkSDFjYmx4MGZTazdYRzVjZEhKbGRIVnliaUFrTzF4dWZTazdYRzVjYm4wb2FsRjFaWEo1S1NrN1hHNWNiaTh2YzJGbVlYSnBJR0poWTJzZ1luVjBkRzl1SUdacGVGeHVhbEYxWlhKNUtDQjNhVzVrYjNjZ0tTNXZiaWdnWENKd1lXZGxjMmh2ZDF3aUxDQm1kVzVqZEdsdmJpaGxkbVZ1ZENrZ2UxeHVJQ0FnSUdsbUlDaGxkbVZ1ZEM1dmNtbG5hVzVoYkVWMlpXNTBMbkJsY25OcGMzUmxaQ2tnZTF4dUlDQWdJQ0FnSUNCcVVYVmxjbmtvWENJdWMyVmhjbU5vWVc1a1ptbHNkR1Z5WENJcExtOW1aaWdwTzF4dUlDQWdJQ0FnSUNCcVVYVmxjbmtvWENJdWMyVmhjbU5vWVc1a1ptbHNkR1Z5WENJcExuTmxZWEpqYUVGdVpFWnBiSFJsY2lncE8xeHVJQ0FnSUgxY2JuMHBPMXh1WEc0dktpQjNjRzUxYldJZ0xTQnViM1ZwYzJ4cFpHVnlJRzUxYldKbGNpQm1iM0p0WVhSMGFXNW5JQ292WEc0aFpuVnVZM1JwYjI0b0tYdGNJblZ6WlNCemRISnBZM1JjSWp0bWRXNWpkR2x2YmlCbEtHVXBlM0psZEhWeWJpQmxMbk53YkdsMEtGd2lYQ0lwTG5KbGRtVnljMlVvS1M1cWIybHVLRndpWENJcGZXWjFibU4wYVc5dUlHNG9aU3h1S1h0eVpYUjFjbTRnWlM1emRXSnpkSEpwYm1jb01DeHVMbXhsYm1kMGFDazlQVDF1ZldaMWJtTjBhVzl1SUhJb1pTeHVLWHR5WlhSMWNtNGdaUzV6YkdsalpTZ3RNU3B1TG14bGJtZDBhQ2s5UFQxdWZXWjFibU4wYVc5dUlIUW9aU3h1TEhJcGUybG1LQ2hsVzI1ZGZIeGxXM0pkS1NZbVpWdHVYVDA5UFdWYmNsMHBkR2h5YjNjZ2JtVjNJRVZ5Y205eUtHNHBmV1oxYm1OMGFXOXVJR2tvWlNsN2NtVjBkWEp1WENKdWRXMWlaWEpjSWowOWRIbHdaVzltSUdVbUptbHpSbWx1YVhSbEtHVXBmV1oxYm1OMGFXOXVJRzhvWlN4dUtYdDJZWElnY2oxTllYUm9MbkJ2ZHlneE1DeHVLVHR5WlhSMWNtNG9UV0YwYUM1eWIzVnVaQ2hsS25JcEwzSXBMblJ2Um1sNFpXUW9iaWw5Wm5WdVkzUnBiMjRnZFNodUxISXNkQ3gxTEdZc1lTeGpMSE1zY0N4a0xHd3NhQ2w3ZG1GeUlHY3NkaXgzTEcwOWFDeDRQVndpWENJc1lqMWNJbHdpTzNKbGRIVnliaUJoSmlZb2FEMWhLR2dwS1N4cEtHZ3BQeWh1SVQwOUlURW1KakE5UFQxd1lYSnpaVVpzYjJGMEtHZ3VkRzlHYVhobFpDaHVLU2ttSmlob1BUQXBMREErYUNZbUtHYzlJVEFzYUQxTllYUm9MbUZpY3lob0tTa3NiaUU5UFNFeEppWW9hRDF2S0dnc2Jpa3BMR2c5YUM1MGIxTjBjbWx1WnlncExDMHhJVDA5YUM1cGJtUmxlRTltS0Z3aUxsd2lLVDhvZGoxb0xuTndiR2wwS0Z3aUxsd2lLU3gzUFhaYk1GMHNkQ1ltS0hnOWRDdDJXekZkS1NrNmR6MW9MSEltSmloM1BXVW9keWt1YldGMFkyZ29MeTU3TVN3emZTOW5LU3gzUFdVb2R5NXFiMmx1S0dVb2Npa3BLU2tzWnlZbWN5WW1LR0lyUFhNcExIVW1KaWhpS3oxMUtTeG5KaVp3SmlZb1lpczljQ2tzWWlzOWR5eGlLejE0TEdZbUppaGlLejFtS1N4a0ppWW9ZajFrS0dJc2JTa3BMR0lwT2lFeGZXWjFibU4wYVc5dUlHWW9aU3gwTEc4c2RTeG1MR0VzWXl4ekxIQXNaQ3hzTEdncGUzWmhjaUJuTEhZOVhDSmNJanR5WlhSMWNtNGdiQ1ltS0dnOWJDaG9LU2tzYUNZbVhDSnpkSEpwYm1kY0lqMDlkSGx3Wlc5bUlHZy9LSE1tSm00b2FDeHpLU1ltS0dnOWFDNXlaWEJzWVdObEtITXNYQ0pjSWlrc1p6MGhNQ2tzZFNZbWJpaG9MSFVwSmlZb2FEMW9MbkpsY0d4aFkyVW9kU3hjSWx3aUtTa3NjQ1ltYmlob0xIQXBKaVlvYUQxb0xuSmxjR3hoWTJVb2NDeGNJbHdpS1N4blBTRXdLU3htSmlaeUtHZ3NaaWttSmlob1BXZ3VjMnhwWTJVb01Dd3RNU3BtTG14bGJtZDBhQ2twTEhRbUppaG9QV2d1YzNCc2FYUW9kQ2t1YW05cGJpaGNJbHdpS1Nrc2J5WW1LR2c5YUM1eVpYQnNZV05sS0c4c1hDSXVYQ0lwS1N4bkppWW9kaXM5WENJdFhDSXBMSFlyUFdnc2RqMTJMbkpsY0d4aFkyVW9MMXRlTUMwNVhGd3VYRnd0TGwwdlp5eGNJbHdpS1N4Y0lsd2lQVDA5ZGo4aE1Ub29kajFPZFcxaVpYSW9kaWtzWXlZbUtIWTlZeWgyS1Nrc2FTaDJLVDkyT2lFeEtTazZJVEY5Wm5WdVkzUnBiMjRnWVNobEtYdDJZWElnYml4eUxHa3NiejE3ZlR0bWIzSW9iajB3TzI0OGNDNXNaVzVuZEdnN2JpczlNU2xwWmloeVBYQmJibDBzYVQxbFczSmRMSFp2YVdRZ01EMDlQV2twWENKdVpXZGhkR2wyWlZ3aUlUMDljbng4Ynk1dVpXZGhkR2wyWlVKbFptOXlaVDljSW0xaGNtdGNJajA5UFhJbUpsd2lMbHdpSVQwOWJ5NTBhRzkxYzJGdVpEOXZXM0pkUFZ3aUxsd2lPbTliY2wwOUlURTZiMXR5WFQxY0lpMWNJanRsYkhObElHbG1LRndpWkdWamFXMWhiSE5jSWowOVBYSXBlMmxtS0NFb2FUNDlNQ1ltT0Q1cEtTbDBhSEp2ZHlCdVpYY2dSWEp5YjNJb2NpazdiMXR5WFQxcGZXVnNjMlVnYVdZb1hDSmxibU52WkdWeVhDSTlQVDF5Zkh4Y0ltUmxZMjlrWlhKY0lqMDlQWEo4ZkZ3aVpXUnBkRndpUFQwOWNueDhYQ0oxYm1SdlhDSTlQVDF5S1h0cFppaGNJbVoxYm1OMGFXOXVYQ0loUFhSNWNHVnZaaUJwS1hSb2NtOTNJRzVsZHlCRmNuSnZjaWh5S1R0dlczSmRQV2w5Wld4elpYdHBaaWhjSW5OMGNtbHVaMXdpSVQxMGVYQmxiMllnYVNsMGFISnZkeUJ1WlhjZ1JYSnliM0lvY2lrN2IxdHlYVDFwZlhKbGRIVnliaUIwS0c4c1hDSnRZWEpyWENJc1hDSjBhRzkxYzJGdVpGd2lLU3gwS0c4c1hDSndjbVZtYVhoY0lpeGNJbTVsWjJGMGFYWmxYQ0lwTEhRb2J5eGNJbkJ5WldacGVGd2lMRndpYm1WbllYUnBkbVZDWldadmNtVmNJaWtzYjMxbWRXNWpkR2x2YmlCaktHVXNiaXh5S1h0MllYSWdkQ3hwUFZ0ZE8yWnZjaWgwUFRBN2REeHdMbXhsYm1kMGFEdDBLejB4S1drdWNIVnphQ2hsVzNCYmRGMWRLVHR5WlhSMWNtNGdhUzV3ZFhOb0tISXBMRzR1WVhCd2JIa29YQ0pjSWl4cEtYMW1kVzVqZEdsdmJpQnpLR1VwZTNKbGRIVnliaUIwYUdseklHbHVjM1JoYm1ObGIyWWdjejkyYjJsa0tGd2liMkpxWldOMFhDSTlQWFI1Y0dWdlppQmxKaVlvWlQxaEtHVXBMSFJvYVhNdWRHODlablZ1WTNScGIyNG9iaWw3Y21WMGRYSnVJR01vWlN4MUxHNHBmU3gwYUdsekxtWnliMjA5Wm5WdVkzUnBiMjRvYmlsN2NtVjBkWEp1SUdNb1pTeG1MRzRwZlNrcE9tNWxkeUJ6S0dVcGZYWmhjaUJ3UFZ0Y0ltUmxZMmx0WVd4elhDSXNYQ0owYUc5MWMyRnVaRndpTEZ3aWJXRnlhMXdpTEZ3aWNISmxabWw0WENJc1hDSndiM04wWm1sNFhDSXNYQ0psYm1OdlpHVnlYQ0lzWENKa1pXTnZaR1Z5WENJc1hDSnVaV2RoZEdsMlpVSmxabTl5WlZ3aUxGd2libVZuWVhScGRtVmNJaXhjSW1Wa2FYUmNJaXhjSW5WdVpHOWNJbDA3ZDJsdVpHOTNMbmRPZFcxaVBYTjlLQ2s3WEc1Y2JpSmRmUT09IiwiLyohIG5vdWlzbGlkZXIgLSAxMS4xLjAgLSAyMDE4LTA0LTAyIDExOjE4OjEzICovXHJcblxyXG4oZnVuY3Rpb24gKGZhY3RvcnkpIHtcclxuXHJcbiAgICBpZiAoIHR5cGVvZiBkZWZpbmUgPT09ICdmdW5jdGlvbicgJiYgZGVmaW5lLmFtZCApIHtcclxuXHJcbiAgICAgICAgLy8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxyXG4gICAgICAgIGRlZmluZShbXSwgZmFjdG9yeSk7XHJcblxyXG4gICAgfSBlbHNlIGlmICggdHlwZW9mIGV4cG9ydHMgPT09ICdvYmplY3QnICkge1xyXG5cclxuICAgICAgICAvLyBOb2RlL0NvbW1vbkpTXHJcbiAgICAgICAgbW9kdWxlLmV4cG9ydHMgPSBmYWN0b3J5KCk7XHJcblxyXG4gICAgfSBlbHNlIHtcclxuXHJcbiAgICAgICAgLy8gQnJvd3NlciBnbG9iYWxzXHJcbiAgICAgICAgd2luZG93Lm5vVWlTbGlkZXIgPSBmYWN0b3J5KCk7XHJcbiAgICB9XHJcblxyXG59KGZ1bmN0aW9uKCApe1xyXG5cclxuXHQndXNlIHN0cmljdCc7XHJcblxyXG5cdHZhciBWRVJTSU9OID0gJzExLjEuMCc7XHJcblxyXG5cblx0ZnVuY3Rpb24gaXNWYWxpZEZvcm1hdHRlciAoIGVudHJ5ICkge1xuXHRcdHJldHVybiB0eXBlb2YgZW50cnkgPT09ICdvYmplY3QnICYmIHR5cGVvZiBlbnRyeS50byA9PT0gJ2Z1bmN0aW9uJyAmJiB0eXBlb2YgZW50cnkuZnJvbSA9PT0gJ2Z1bmN0aW9uJztcblx0fVxuXG5cdGZ1bmN0aW9uIHJlbW92ZUVsZW1lbnQgKCBlbCApIHtcblx0XHRlbC5wYXJlbnRFbGVtZW50LnJlbW92ZUNoaWxkKGVsKTtcblx0fVxuXG5cdGZ1bmN0aW9uIGlzU2V0ICggdmFsdWUgKSB7XG5cdFx0cmV0dXJuIHZhbHVlICE9PSBudWxsICYmIHZhbHVlICE9PSB1bmRlZmluZWQ7XG5cdH1cblxuXHQvLyBCaW5kYWJsZSB2ZXJzaW9uXG5cdGZ1bmN0aW9uIHByZXZlbnREZWZhdWx0ICggZSApIHtcblx0XHRlLnByZXZlbnREZWZhdWx0KCk7XG5cdH1cblxuXHQvLyBSZW1vdmVzIGR1cGxpY2F0ZXMgZnJvbSBhbiBhcnJheS5cblx0ZnVuY3Rpb24gdW5pcXVlICggYXJyYXkgKSB7XG5cdFx0cmV0dXJuIGFycmF5LmZpbHRlcihmdW5jdGlvbihhKXtcblx0XHRcdHJldHVybiAhdGhpc1thXSA/IHRoaXNbYV0gPSB0cnVlIDogZmFsc2U7XG5cdFx0fSwge30pO1xuXHR9XG5cblx0Ly8gUm91bmQgYSB2YWx1ZSB0byB0aGUgY2xvc2VzdCAndG8nLlxuXHRmdW5jdGlvbiBjbG9zZXN0ICggdmFsdWUsIHRvICkge1xuXHRcdHJldHVybiBNYXRoLnJvdW5kKHZhbHVlIC8gdG8pICogdG87XG5cdH1cblxuXHQvLyBDdXJyZW50IHBvc2l0aW9uIG9mIGFuIGVsZW1lbnQgcmVsYXRpdmUgdG8gdGhlIGRvY3VtZW50LlxuXHRmdW5jdGlvbiBvZmZzZXQgKCBlbGVtLCBvcmllbnRhdGlvbiApIHtcblxuXHRcdHZhciByZWN0ID0gZWxlbS5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTtcblx0XHR2YXIgZG9jID0gZWxlbS5vd25lckRvY3VtZW50O1xuXHRcdHZhciBkb2NFbGVtID0gZG9jLmRvY3VtZW50RWxlbWVudDtcblx0XHR2YXIgcGFnZU9mZnNldCA9IGdldFBhZ2VPZmZzZXQoZG9jKTtcblxuXHRcdC8vIGdldEJvdW5kaW5nQ2xpZW50UmVjdCBjb250YWlucyBsZWZ0IHNjcm9sbCBpbiBDaHJvbWUgb24gQW5kcm9pZC5cblx0XHQvLyBJIGhhdmVuJ3QgZm91bmQgYSBmZWF0dXJlIGRldGVjdGlvbiB0aGF0IHByb3ZlcyB0aGlzLiBXb3JzdCBjYXNlXG5cdFx0Ly8gc2NlbmFyaW8gb24gbWlzLW1hdGNoOiB0aGUgJ3RhcCcgZmVhdHVyZSBvbiBob3Jpem9udGFsIHNsaWRlcnMgYnJlYWtzLlxuXHRcdGlmICggL3dlYmtpdC4qQ2hyb21lLipNb2JpbGUvaS50ZXN0KG5hdmlnYXRvci51c2VyQWdlbnQpICkge1xuXHRcdFx0cGFnZU9mZnNldC54ID0gMDtcblx0XHR9XG5cblx0XHRyZXR1cm4gb3JpZW50YXRpb24gPyAocmVjdC50b3AgKyBwYWdlT2Zmc2V0LnkgLSBkb2NFbGVtLmNsaWVudFRvcCkgOiAocmVjdC5sZWZ0ICsgcGFnZU9mZnNldC54IC0gZG9jRWxlbS5jbGllbnRMZWZ0KTtcblx0fVxuXG5cdC8vIENoZWNrcyB3aGV0aGVyIGEgdmFsdWUgaXMgbnVtZXJpY2FsLlxuXHRmdW5jdGlvbiBpc051bWVyaWMgKCBhICkge1xuXHRcdHJldHVybiB0eXBlb2YgYSA9PT0gJ251bWJlcicgJiYgIWlzTmFOKCBhICkgJiYgaXNGaW5pdGUoIGEgKTtcblx0fVxuXG5cdC8vIFNldHMgYSBjbGFzcyBhbmQgcmVtb3ZlcyBpdCBhZnRlciBbZHVyYXRpb25dIG1zLlxuXHRmdW5jdGlvbiBhZGRDbGFzc0ZvciAoIGVsZW1lbnQsIGNsYXNzTmFtZSwgZHVyYXRpb24gKSB7XG5cdFx0aWYgKGR1cmF0aW9uID4gMCkge1xuXHRcdGFkZENsYXNzKGVsZW1lbnQsIGNsYXNzTmFtZSk7XG5cdFx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG5cdFx0XHRcdHJlbW92ZUNsYXNzKGVsZW1lbnQsIGNsYXNzTmFtZSk7XG5cdFx0XHR9LCBkdXJhdGlvbik7XG5cdFx0fVxuXHR9XG5cblx0Ly8gTGltaXRzIGEgdmFsdWUgdG8gMCAtIDEwMFxuXHRmdW5jdGlvbiBsaW1pdCAoIGEgKSB7XG5cdFx0cmV0dXJuIE1hdGgubWF4KE1hdGgubWluKGEsIDEwMCksIDApO1xuXHR9XG5cblx0Ly8gV3JhcHMgYSB2YXJpYWJsZSBhcyBhbiBhcnJheSwgaWYgaXQgaXNuJ3Qgb25lIHlldC5cblx0Ly8gTm90ZSB0aGF0IGFuIGlucHV0IGFycmF5IGlzIHJldHVybmVkIGJ5IHJlZmVyZW5jZSFcblx0ZnVuY3Rpb24gYXNBcnJheSAoIGEgKSB7XG5cdFx0cmV0dXJuIEFycmF5LmlzQXJyYXkoYSkgPyBhIDogW2FdO1xuXHR9XG5cblx0Ly8gQ291bnRzIGRlY2ltYWxzXG5cdGZ1bmN0aW9uIGNvdW50RGVjaW1hbHMgKCBudW1TdHIgKSB7XG5cdFx0bnVtU3RyID0gU3RyaW5nKG51bVN0cik7XG5cdFx0dmFyIHBpZWNlcyA9IG51bVN0ci5zcGxpdChcIi5cIik7XG5cdFx0cmV0dXJuIHBpZWNlcy5sZW5ndGggPiAxID8gcGllY2VzWzFdLmxlbmd0aCA6IDA7XG5cdH1cblxuXHQvLyBodHRwOi8veW91bWlnaHRub3RuZWVkanF1ZXJ5LmNvbS8jYWRkX2NsYXNzXG5cdGZ1bmN0aW9uIGFkZENsYXNzICggZWwsIGNsYXNzTmFtZSApIHtcblx0XHRpZiAoIGVsLmNsYXNzTGlzdCApIHtcblx0XHRcdGVsLmNsYXNzTGlzdC5hZGQoY2xhc3NOYW1lKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZWwuY2xhc3NOYW1lICs9ICcgJyArIGNsYXNzTmFtZTtcblx0XHR9XG5cdH1cblxuXHQvLyBodHRwOi8veW91bWlnaHRub3RuZWVkanF1ZXJ5LmNvbS8jcmVtb3ZlX2NsYXNzXG5cdGZ1bmN0aW9uIHJlbW92ZUNsYXNzICggZWwsIGNsYXNzTmFtZSApIHtcblx0XHRpZiAoIGVsLmNsYXNzTGlzdCApIHtcblx0XHRcdGVsLmNsYXNzTGlzdC5yZW1vdmUoY2xhc3NOYW1lKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZWwuY2xhc3NOYW1lID0gZWwuY2xhc3NOYW1lLnJlcGxhY2UobmV3IFJlZ0V4cCgnKF58XFxcXGIpJyArIGNsYXNzTmFtZS5zcGxpdCgnICcpLmpvaW4oJ3wnKSArICcoXFxcXGJ8JCknLCAnZ2knKSwgJyAnKTtcblx0XHR9XG5cdH1cblxuXHQvLyBodHRwczovL3BsYWluanMuY29tL2phdmFzY3JpcHQvYXR0cmlidXRlcy9hZGRpbmctcmVtb3ZpbmctYW5kLXRlc3RpbmctZm9yLWNsYXNzZXMtOS9cblx0ZnVuY3Rpb24gaGFzQ2xhc3MgKCBlbCwgY2xhc3NOYW1lICkge1xuXHRcdHJldHVybiBlbC5jbGFzc0xpc3QgPyBlbC5jbGFzc0xpc3QuY29udGFpbnMoY2xhc3NOYW1lKSA6IG5ldyBSZWdFeHAoJ1xcXFxiJyArIGNsYXNzTmFtZSArICdcXFxcYicpLnRlc3QoZWwuY2xhc3NOYW1lKTtcblx0fVxuXG5cdC8vIGh0dHBzOi8vZGV2ZWxvcGVyLm1vemlsbGEub3JnL2VuLVVTL2RvY3MvV2ViL0FQSS9XaW5kb3cvc2Nyb2xsWSNOb3Rlc1xuXHRmdW5jdGlvbiBnZXRQYWdlT2Zmc2V0ICggZG9jICkge1xuXG5cdFx0dmFyIHN1cHBvcnRQYWdlT2Zmc2V0ID0gd2luZG93LnBhZ2VYT2Zmc2V0ICE9PSB1bmRlZmluZWQ7XG5cdFx0dmFyIGlzQ1NTMUNvbXBhdCA9ICgoZG9jLmNvbXBhdE1vZGUgfHwgXCJcIikgPT09IFwiQ1NTMUNvbXBhdFwiKTtcblx0XHR2YXIgeCA9IHN1cHBvcnRQYWdlT2Zmc2V0ID8gd2luZG93LnBhZ2VYT2Zmc2V0IDogaXNDU1MxQ29tcGF0ID8gZG9jLmRvY3VtZW50RWxlbWVudC5zY3JvbGxMZWZ0IDogZG9jLmJvZHkuc2Nyb2xsTGVmdDtcblx0XHR2YXIgeSA9IHN1cHBvcnRQYWdlT2Zmc2V0ID8gd2luZG93LnBhZ2VZT2Zmc2V0IDogaXNDU1MxQ29tcGF0ID8gZG9jLmRvY3VtZW50RWxlbWVudC5zY3JvbGxUb3AgOiBkb2MuYm9keS5zY3JvbGxUb3A7XG5cblx0XHRyZXR1cm4ge1xuXHRcdFx0eDogeCxcblx0XHRcdHk6IHlcblx0XHR9O1xuXHR9XG5cclxuXHQvLyB3ZSBwcm92aWRlIGEgZnVuY3Rpb24gdG8gY29tcHV0ZSBjb25zdGFudHMgaW5zdGVhZFxyXG5cdC8vIG9mIGFjY2Vzc2luZyB3aW5kb3cuKiBhcyBzb29uIGFzIHRoZSBtb2R1bGUgbmVlZHMgaXRcclxuXHQvLyBzbyB0aGF0IHdlIGRvIG5vdCBjb21wdXRlIGFueXRoaW5nIGlmIG5vdCBuZWVkZWRcclxuXHRmdW5jdGlvbiBnZXRBY3Rpb25zICggKSB7XHJcblxyXG5cdFx0Ly8gRGV0ZXJtaW5lIHRoZSBldmVudHMgdG8gYmluZC4gSUUxMSBpbXBsZW1lbnRzIHBvaW50ZXJFdmVudHMgd2l0aG91dFxyXG5cdFx0Ly8gYSBwcmVmaXgsIHdoaWNoIGJyZWFrcyBjb21wYXRpYmlsaXR5IHdpdGggdGhlIElFMTAgaW1wbGVtZW50YXRpb24uXHJcblx0XHRyZXR1cm4gd2luZG93Lm5hdmlnYXRvci5wb2ludGVyRW5hYmxlZCA/IHtcclxuXHRcdFx0c3RhcnQ6ICdwb2ludGVyZG93bicsXHJcblx0XHRcdG1vdmU6ICdwb2ludGVybW92ZScsXHJcblx0XHRcdGVuZDogJ3BvaW50ZXJ1cCdcclxuXHRcdH0gOiB3aW5kb3cubmF2aWdhdG9yLm1zUG9pbnRlckVuYWJsZWQgPyB7XHJcblx0XHRcdHN0YXJ0OiAnTVNQb2ludGVyRG93bicsXHJcblx0XHRcdG1vdmU6ICdNU1BvaW50ZXJNb3ZlJyxcclxuXHRcdFx0ZW5kOiAnTVNQb2ludGVyVXAnXHJcblx0XHR9IDoge1xyXG5cdFx0XHRzdGFydDogJ21vdXNlZG93biB0b3VjaHN0YXJ0JyxcclxuXHRcdFx0bW92ZTogJ21vdXNlbW92ZSB0b3VjaG1vdmUnLFxyXG5cdFx0XHRlbmQ6ICdtb3VzZXVwIHRvdWNoZW5kJ1xyXG5cdFx0fTtcclxuXHR9XHJcblxyXG5cdC8vIGh0dHBzOi8vZ2l0aHViLmNvbS9XSUNHL0V2ZW50TGlzdGVuZXJPcHRpb25zL2Jsb2IvZ2gtcGFnZXMvZXhwbGFpbmVyLm1kXHJcblx0Ly8gSXNzdWUgIzc4NVxyXG5cdGZ1bmN0aW9uIGdldFN1cHBvcnRzUGFzc2l2ZSAoICkge1xyXG5cclxuXHRcdHZhciBzdXBwb3J0c1Bhc3NpdmUgPSBmYWxzZTtcclxuXHJcblx0XHR0cnkge1xyXG5cclxuXHRcdFx0dmFyIG9wdHMgPSBPYmplY3QuZGVmaW5lUHJvcGVydHkoe30sICdwYXNzaXZlJywge1xyXG5cdFx0XHRcdGdldDogZnVuY3Rpb24oKSB7XHJcblx0XHRcdFx0XHRzdXBwb3J0c1Bhc3NpdmUgPSB0cnVlO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fSk7XHJcblxyXG5cdFx0XHR3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcigndGVzdCcsIG51bGwsIG9wdHMpO1xyXG5cclxuXHRcdH0gY2F0Y2ggKGUpIHt9XHJcblxyXG5cdFx0cmV0dXJuIHN1cHBvcnRzUGFzc2l2ZTtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIGdldFN1cHBvcnRzVG91Y2hBY3Rpb25Ob25lICggKSB7XHJcblx0XHRyZXR1cm4gd2luZG93LkNTUyAmJiBDU1Muc3VwcG9ydHMgJiYgQ1NTLnN1cHBvcnRzKCd0b3VjaC1hY3Rpb24nLCAnbm9uZScpO1xyXG5cdH1cclxuXHJcblxyXG4vLyBWYWx1ZSBjYWxjdWxhdGlvblxyXG5cclxuXHQvLyBEZXRlcm1pbmUgdGhlIHNpemUgb2YgYSBzdWItcmFuZ2UgaW4gcmVsYXRpb24gdG8gYSBmdWxsIHJhbmdlLlxyXG5cdGZ1bmN0aW9uIHN1YlJhbmdlUmF0aW8gKCBwYSwgcGIgKSB7XHJcblx0XHRyZXR1cm4gKDEwMCAvIChwYiAtIHBhKSk7XHJcblx0fVxyXG5cclxuXHQvLyAocGVyY2VudGFnZSkgSG93IG1hbnkgcGVyY2VudCBpcyB0aGlzIHZhbHVlIG9mIHRoaXMgcmFuZ2U/XHJcblx0ZnVuY3Rpb24gZnJvbVBlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gKHZhbHVlICogMTAwKSAvICggcmFuZ2VbMV0gLSByYW5nZVswXSApO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIFdoZXJlIGlzIHRoaXMgdmFsdWUgb24gdGhpcyByYW5nZT9cclxuXHRmdW5jdGlvbiB0b1BlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gZnJvbVBlcmNlbnRhZ2UoIHJhbmdlLCByYW5nZVswXSA8IDAgP1xyXG5cdFx0XHR2YWx1ZSArIE1hdGguYWJzKHJhbmdlWzBdKSA6XHJcblx0XHRcdFx0dmFsdWUgLSByYW5nZVswXSApO1xyXG5cdH1cclxuXHJcblx0Ly8gKHZhbHVlKSBIb3cgbXVjaCBpcyB0aGlzIHBlcmNlbnRhZ2Ugb24gdGhpcyByYW5nZT9cclxuXHRmdW5jdGlvbiBpc1BlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gKCh2YWx1ZSAqICggcmFuZ2VbMV0gLSByYW5nZVswXSApKSAvIDEwMCkgKyByYW5nZVswXTtcclxuXHR9XHJcblxyXG5cclxuLy8gUmFuZ2UgY29udmVyc2lvblxyXG5cclxuXHRmdW5jdGlvbiBnZXRKICggdmFsdWUsIGFyciApIHtcclxuXHJcblx0XHR2YXIgaiA9IDE7XHJcblxyXG5cdFx0d2hpbGUgKCB2YWx1ZSA+PSBhcnJbal0gKXtcclxuXHRcdFx0aiArPSAxO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBqO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIElucHV0IGEgdmFsdWUsIGZpbmQgd2hlcmUsIG9uIGEgc2NhbGUgb2YgMC0xMDAsIGl0IGFwcGxpZXMuXHJcblx0ZnVuY3Rpb24gdG9TdGVwcGluZyAoIHhWYWwsIHhQY3QsIHZhbHVlICkge1xyXG5cclxuXHRcdGlmICggdmFsdWUgPj0geFZhbC5zbGljZSgtMSlbMF0gKXtcclxuXHRcdFx0cmV0dXJuIDEwMDtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgaiA9IGdldEooIHZhbHVlLCB4VmFsICk7XHJcblx0XHR2YXIgdmEgPSB4VmFsW2otMV07XHJcblx0XHR2YXIgdmIgPSB4VmFsW2pdO1xyXG5cdFx0dmFyIHBhID0geFBjdFtqLTFdO1xyXG5cdFx0dmFyIHBiID0geFBjdFtqXTtcclxuXHJcblx0XHRyZXR1cm4gcGEgKyAodG9QZXJjZW50YWdlKFt2YSwgdmJdLCB2YWx1ZSkgLyBzdWJSYW5nZVJhdGlvIChwYSwgcGIpKTtcclxuXHR9XHJcblxyXG5cdC8vICh2YWx1ZSkgSW5wdXQgYSBwZXJjZW50YWdlLCBmaW5kIHdoZXJlIGl0IGlzIG9uIHRoZSBzcGVjaWZpZWQgcmFuZ2UuXHJcblx0ZnVuY3Rpb24gZnJvbVN0ZXBwaW5nICggeFZhbCwgeFBjdCwgdmFsdWUgKSB7XHJcblxyXG5cdFx0Ly8gVGhlcmUgaXMgbm8gcmFuZ2UgZ3JvdXAgdGhhdCBmaXRzIDEwMFxyXG5cdFx0aWYgKCB2YWx1ZSA+PSAxMDAgKXtcclxuXHRcdFx0cmV0dXJuIHhWYWwuc2xpY2UoLTEpWzBdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBqID0gZ2V0SiggdmFsdWUsIHhQY3QgKTtcclxuXHRcdHZhciB2YSA9IHhWYWxbai0xXTtcclxuXHRcdHZhciB2YiA9IHhWYWxbal07XHJcblx0XHR2YXIgcGEgPSB4UGN0W2otMV07XHJcblx0XHR2YXIgcGIgPSB4UGN0W2pdO1xyXG5cclxuXHRcdHJldHVybiBpc1BlcmNlbnRhZ2UoW3ZhLCB2Yl0sICh2YWx1ZSAtIHBhKSAqIHN1YlJhbmdlUmF0aW8gKHBhLCBwYikpO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIEdldCB0aGUgc3RlcCB0aGF0IGFwcGxpZXMgYXQgYSBjZXJ0YWluIHZhbHVlLlxyXG5cdGZ1bmN0aW9uIGdldFN0ZXAgKCB4UGN0LCB4U3RlcHMsIHNuYXAsIHZhbHVlICkge1xyXG5cclxuXHRcdGlmICggdmFsdWUgPT09IDEwMCApIHtcclxuXHRcdFx0cmV0dXJuIHZhbHVlO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBqID0gZ2V0SiggdmFsdWUsIHhQY3QgKTtcclxuXHRcdHZhciBhID0geFBjdFtqLTFdO1xyXG5cdFx0dmFyIGIgPSB4UGN0W2pdO1xyXG5cclxuXHRcdC8vIElmICdzbmFwJyBpcyBzZXQsIHN0ZXBzIGFyZSB1c2VkIGFzIGZpeGVkIHBvaW50cyBvbiB0aGUgc2xpZGVyLlxyXG5cdFx0aWYgKCBzbmFwICkge1xyXG5cclxuXHRcdFx0Ly8gRmluZCB0aGUgY2xvc2VzdCBwb3NpdGlvbiwgYSBvciBiLlxyXG5cdFx0XHRpZiAoKHZhbHVlIC0gYSkgPiAoKGItYSkvMikpe1xyXG5cdFx0XHRcdHJldHVybiBiO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRyZXR1cm4gYTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoICF4U3RlcHNbai0xXSApe1xyXG5cdFx0XHRyZXR1cm4gdmFsdWU7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHhQY3Rbai0xXSArIGNsb3Nlc3QoXHJcblx0XHRcdHZhbHVlIC0geFBjdFtqLTFdLFxyXG5cdFx0XHR4U3RlcHNbai0xXVxyXG5cdFx0KTtcclxuXHR9XHJcblxyXG5cclxuLy8gRW50cnkgcGFyc2luZ1xyXG5cclxuXHRmdW5jdGlvbiBoYW5kbGVFbnRyeVBvaW50ICggaW5kZXgsIHZhbHVlLCB0aGF0ICkge1xyXG5cclxuXHRcdHZhciBwZXJjZW50YWdlO1xyXG5cclxuXHRcdC8vIFdyYXAgbnVtZXJpY2FsIGlucHV0IGluIGFuIGFycmF5LlxyXG5cdFx0aWYgKCB0eXBlb2YgdmFsdWUgPT09IFwibnVtYmVyXCIgKSB7XHJcblx0XHRcdHZhbHVlID0gW3ZhbHVlXTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBSZWplY3QgYW55IGludmFsaWQgaW5wdXQsIGJ5IHRlc3Rpbmcgd2hldGhlciB2YWx1ZSBpcyBhbiBhcnJheS5cclxuXHRcdGlmICggIUFycmF5LmlzQXJyYXkodmFsdWUpICl7XHJcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3JhbmdlJyBjb250YWlucyBpbnZhbGlkIHZhbHVlLlwiKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBDb3ZlcnQgbWluL21heCBzeW50YXggdG8gMCBhbmQgMTAwLlxyXG5cdFx0aWYgKCBpbmRleCA9PT0gJ21pbicgKSB7XHJcblx0XHRcdHBlcmNlbnRhZ2UgPSAwO1xyXG5cdFx0fSBlbHNlIGlmICggaW5kZXggPT09ICdtYXgnICkge1xyXG5cdFx0XHRwZXJjZW50YWdlID0gMTAwO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0cGVyY2VudGFnZSA9IHBhcnNlRmxvYXQoIGluZGV4ICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQ2hlY2sgZm9yIGNvcnJlY3QgaW5wdXQuXHJcblx0XHRpZiAoICFpc051bWVyaWMoIHBlcmNlbnRhZ2UgKSB8fCAhaXNOdW1lcmljKCB2YWx1ZVswXSApICkge1xyXG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdyYW5nZScgdmFsdWUgaXNuJ3QgbnVtZXJpYy5cIik7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gU3RvcmUgdmFsdWVzLlxyXG5cdFx0dGhhdC54UGN0LnB1c2goIHBlcmNlbnRhZ2UgKTtcclxuXHRcdHRoYXQueFZhbC5wdXNoKCB2YWx1ZVswXSApO1xyXG5cclxuXHRcdC8vIE5hTiB3aWxsIGV2YWx1YXRlIHRvIGZhbHNlIHRvbywgYnV0IHRvIGtlZXBcclxuXHRcdC8vIGxvZ2dpbmcgY2xlYXIsIHNldCBzdGVwIGV4cGxpY2l0bHkuIE1ha2Ugc3VyZVxyXG5cdFx0Ly8gbm90IHRvIG92ZXJyaWRlIHRoZSAnc3RlcCcgc2V0dGluZyB3aXRoIGZhbHNlLlxyXG5cdFx0aWYgKCAhcGVyY2VudGFnZSApIHtcclxuXHRcdFx0aWYgKCAhaXNOYU4oIHZhbHVlWzFdICkgKSB7XHJcblx0XHRcdFx0dGhhdC54U3RlcHNbMF0gPSB2YWx1ZVsxXTtcclxuXHRcdFx0fVxyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0dGhhdC54U3RlcHMucHVzaCggaXNOYU4odmFsdWVbMV0pID8gZmFsc2UgOiB2YWx1ZVsxXSApO1xyXG5cdFx0fVxyXG5cclxuXHRcdHRoYXQueEhpZ2hlc3RDb21wbGV0ZVN0ZXAucHVzaCgwKTtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIGhhbmRsZVN0ZXBQb2ludCAoIGksIG4sIHRoYXQgKSB7XHJcblxyXG5cdFx0Ly8gSWdub3JlICdmYWxzZScgc3RlcHBpbmcuXHJcblx0XHRpZiAoICFuICkge1xyXG5cdFx0XHRyZXR1cm4gdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBGYWN0b3IgdG8gcmFuZ2UgcmF0aW9cclxuXHRcdHRoYXQueFN0ZXBzW2ldID0gZnJvbVBlcmNlbnRhZ2UoW3RoYXQueFZhbFtpXSwgdGhhdC54VmFsW2krMV1dLCBuKSAvIHN1YlJhbmdlUmF0aW8odGhhdC54UGN0W2ldLCB0aGF0LnhQY3RbaSsxXSk7XHJcblxyXG5cdFx0dmFyIHRvdGFsU3RlcHMgPSAodGhhdC54VmFsW2krMV0gLSB0aGF0LnhWYWxbaV0pIC8gdGhhdC54TnVtU3RlcHNbaV07XHJcblx0XHR2YXIgaGlnaGVzdFN0ZXAgPSBNYXRoLmNlaWwoTnVtYmVyKHRvdGFsU3RlcHMudG9GaXhlZCgzKSkgLSAxKTtcclxuXHRcdHZhciBzdGVwID0gdGhhdC54VmFsW2ldICsgKHRoYXQueE51bVN0ZXBzW2ldICogaGlnaGVzdFN0ZXApO1xyXG5cclxuXHRcdHRoYXQueEhpZ2hlc3RDb21wbGV0ZVN0ZXBbaV0gPSBzdGVwO1xyXG5cdH1cclxuXHJcblxyXG4vLyBJbnRlcmZhY2VcclxuXHJcblx0ZnVuY3Rpb24gU3BlY3RydW0gKCBlbnRyeSwgc25hcCwgc2luZ2xlU3RlcCApIHtcclxuXHJcblx0XHR0aGlzLnhQY3QgPSBbXTtcclxuXHRcdHRoaXMueFZhbCA9IFtdO1xyXG5cdFx0dGhpcy54U3RlcHMgPSBbIHNpbmdsZVN0ZXAgfHwgZmFsc2UgXTtcclxuXHRcdHRoaXMueE51bVN0ZXBzID0gWyBmYWxzZSBdO1xyXG5cdFx0dGhpcy54SGlnaGVzdENvbXBsZXRlU3RlcCA9IFtdO1xyXG5cclxuXHRcdHRoaXMuc25hcCA9IHNuYXA7XHJcblxyXG5cdFx0dmFyIGluZGV4O1xyXG5cdFx0dmFyIG9yZGVyZWQgPSBbXTsgLy8gWzAsICdtaW4nXSwgWzEsICc1MCUnXSwgWzIsICdtYXgnXVxyXG5cclxuXHRcdC8vIE1hcCB0aGUgb2JqZWN0IGtleXMgdG8gYW4gYXJyYXkuXHJcblx0XHRmb3IgKCBpbmRleCBpbiBlbnRyeSApIHtcclxuXHRcdFx0aWYgKCBlbnRyeS5oYXNPd25Qcm9wZXJ0eShpbmRleCkgKSB7XHJcblx0XHRcdFx0b3JkZXJlZC5wdXNoKFtlbnRyeVtpbmRleF0sIGluZGV4XSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBTb3J0IGFsbCBlbnRyaWVzIGJ5IHZhbHVlIChudW1lcmljIHNvcnQpLlxyXG5cdFx0aWYgKCBvcmRlcmVkLmxlbmd0aCAmJiB0eXBlb2Ygb3JkZXJlZFswXVswXSA9PT0gXCJvYmplY3RcIiApIHtcclxuXHRcdFx0b3JkZXJlZC5zb3J0KGZ1bmN0aW9uKGEsIGIpIHsgcmV0dXJuIGFbMF1bMF0gLSBiWzBdWzBdOyB9KTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdG9yZGVyZWQuc29ydChmdW5jdGlvbihhLCBiKSB7IHJldHVybiBhWzBdIC0gYlswXTsgfSk7XHJcblx0XHR9XHJcblxyXG5cclxuXHRcdC8vIENvbnZlcnQgYWxsIGVudHJpZXMgdG8gc3VicmFuZ2VzLlxyXG5cdFx0Zm9yICggaW5kZXggPSAwOyBpbmRleCA8IG9yZGVyZWQubGVuZ3RoOyBpbmRleCsrICkge1xyXG5cdFx0XHRoYW5kbGVFbnRyeVBvaW50KG9yZGVyZWRbaW5kZXhdWzFdLCBvcmRlcmVkW2luZGV4XVswXSwgdGhpcyk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gU3RvcmUgdGhlIGFjdHVhbCBzdGVwIHZhbHVlcy5cclxuXHRcdC8vIHhTdGVwcyBpcyBzb3J0ZWQgaW4gdGhlIHNhbWUgb3JkZXIgYXMgeFBjdCBhbmQgeFZhbC5cclxuXHRcdHRoaXMueE51bVN0ZXBzID0gdGhpcy54U3RlcHMuc2xpY2UoMCk7XHJcblxyXG5cdFx0Ly8gQ29udmVydCBhbGwgbnVtZXJpYyBzdGVwcyB0byB0aGUgcGVyY2VudGFnZSBvZiB0aGUgc3VicmFuZ2UgdGhleSByZXByZXNlbnQuXHJcblx0XHRmb3IgKCBpbmRleCA9IDA7IGluZGV4IDwgdGhpcy54TnVtU3RlcHMubGVuZ3RoOyBpbmRleCsrICkge1xyXG5cdFx0XHRoYW5kbGVTdGVwUG9pbnQoaW5kZXgsIHRoaXMueE51bVN0ZXBzW2luZGV4XSwgdGhpcyk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUuZ2V0TWFyZ2luID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHJcblx0XHR2YXIgc3RlcCA9IHRoaXMueE51bVN0ZXBzWzBdO1xyXG5cclxuXHRcdGlmICggc3RlcCAmJiAoKHZhbHVlIC8gc3RlcCkgJSAxKSAhPT0gMCApIHtcclxuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbGltaXQnLCAnbWFyZ2luJyBhbmQgJ3BhZGRpbmcnIG11c3QgYmUgZGl2aXNpYmxlIGJ5IHN0ZXAuXCIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiB0aGlzLnhQY3QubGVuZ3RoID09PSAyID8gZnJvbVBlcmNlbnRhZ2UodGhpcy54VmFsLCB2YWx1ZSkgOiBmYWxzZTtcclxuXHR9O1xyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUudG9TdGVwcGluZyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0dmFsdWUgPSB0b1N0ZXBwaW5nKCB0aGlzLnhWYWwsIHRoaXMueFBjdCwgdmFsdWUgKTtcclxuXHJcblx0XHRyZXR1cm4gdmFsdWU7XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmZyb21TdGVwcGluZyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0cmV0dXJuIGZyb21TdGVwcGluZyggdGhpcy54VmFsLCB0aGlzLnhQY3QsIHZhbHVlICk7XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmdldFN0ZXAgPSBmdW5jdGlvbiAoIHZhbHVlICkge1xyXG5cclxuXHRcdHZhbHVlID0gZ2V0U3RlcCh0aGlzLnhQY3QsIHRoaXMueFN0ZXBzLCB0aGlzLnNuYXAsIHZhbHVlICk7XHJcblxyXG5cdFx0cmV0dXJuIHZhbHVlO1xyXG5cdH07XHJcblxyXG5cdFNwZWN0cnVtLnByb3RvdHlwZS5nZXROZWFyYnlTdGVwcyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0dmFyIGogPSBnZXRKKHZhbHVlLCB0aGlzLnhQY3QpO1xyXG5cclxuXHRcdHJldHVybiB7XHJcblx0XHRcdHN0ZXBCZWZvcmU6IHsgc3RhcnRWYWx1ZTogdGhpcy54VmFsW2otMl0sIHN0ZXA6IHRoaXMueE51bVN0ZXBzW2otMl0sIGhpZ2hlc3RTdGVwOiB0aGlzLnhIaWdoZXN0Q29tcGxldGVTdGVwW2otMl0gfSxcclxuXHRcdFx0dGhpc1N0ZXA6IHsgc3RhcnRWYWx1ZTogdGhpcy54VmFsW2otMV0sIHN0ZXA6IHRoaXMueE51bVN0ZXBzW2otMV0sIGhpZ2hlc3RTdGVwOiB0aGlzLnhIaWdoZXN0Q29tcGxldGVTdGVwW2otMV0gfSxcclxuXHRcdFx0c3RlcEFmdGVyOiB7IHN0YXJ0VmFsdWU6IHRoaXMueFZhbFtqLTBdLCBzdGVwOiB0aGlzLnhOdW1TdGVwc1tqLTBdLCBoaWdoZXN0U3RlcDogdGhpcy54SGlnaGVzdENvbXBsZXRlU3RlcFtqLTBdIH1cclxuXHRcdH07XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmNvdW50U3RlcERlY2ltYWxzID0gZnVuY3Rpb24gKCkge1xyXG5cdFx0dmFyIHN0ZXBEZWNpbWFscyA9IHRoaXMueE51bVN0ZXBzLm1hcChjb3VudERlY2ltYWxzKTtcclxuXHRcdHJldHVybiBNYXRoLm1heC5hcHBseShudWxsLCBzdGVwRGVjaW1hbHMpO1xyXG5cdH07XHJcblxyXG5cdC8vIE91dHNpZGUgdGVzdGluZ1xyXG5cdFNwZWN0cnVtLnByb3RvdHlwZS5jb252ZXJ0ID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHRcdHJldHVybiB0aGlzLmdldFN0ZXAodGhpcy50b1N0ZXBwaW5nKHZhbHVlKSk7XHJcblx0fTtcclxuXHJcbi8qXHRFdmVyeSBpbnB1dCBvcHRpb24gaXMgdGVzdGVkIGFuZCBwYXJzZWQuIFRoaXMnbGwgcHJldmVudFxuXHRlbmRsZXNzIHZhbGlkYXRpb24gaW4gaW50ZXJuYWwgbWV0aG9kcy4gVGhlc2UgdGVzdHMgYXJlXG5cdHN0cnVjdHVyZWQgd2l0aCBhbiBpdGVtIGZvciBldmVyeSBvcHRpb24gYXZhaWxhYmxlLiBBblxuXHRvcHRpb24gY2FuIGJlIG1hcmtlZCBhcyByZXF1aXJlZCBieSBzZXR0aW5nIHRoZSAncicgZmxhZy5cblx0VGhlIHRlc3RpbmcgZnVuY3Rpb24gaXMgcHJvdmlkZWQgd2l0aCB0aHJlZSBhcmd1bWVudHM6XG5cdFx0LSBUaGUgcHJvdmlkZWQgdmFsdWUgZm9yIHRoZSBvcHRpb247XG5cdFx0LSBBIHJlZmVyZW5jZSB0byB0aGUgb3B0aW9ucyBvYmplY3Q7XG5cdFx0LSBUaGUgbmFtZSBmb3IgdGhlIG9wdGlvbjtcblxuXHRUaGUgdGVzdGluZyBmdW5jdGlvbiByZXR1cm5zIGZhbHNlIHdoZW4gYW4gZXJyb3IgaXMgZGV0ZWN0ZWQsXG5cdG9yIHRydWUgd2hlbiBldmVyeXRoaW5nIGlzIE9LLiBJdCBjYW4gYWxzbyBtb2RpZnkgdGhlIG9wdGlvblxuXHRvYmplY3QsIHRvIG1ha2Ugc3VyZSBhbGwgdmFsdWVzIGNhbiBiZSBjb3JyZWN0bHkgbG9vcGVkIGVsc2V3aGVyZS4gKi9cblxuXHR2YXIgZGVmYXVsdEZvcm1hdHRlciA9IHsgJ3RvJzogZnVuY3Rpb24oIHZhbHVlICl7XG5cdFx0cmV0dXJuIHZhbHVlICE9PSB1bmRlZmluZWQgJiYgdmFsdWUudG9GaXhlZCgyKTtcblx0fSwgJ2Zyb20nOiBOdW1iZXIgfTtcblxuXHRmdW5jdGlvbiB2YWxpZGF0ZUZvcm1hdCAoIGVudHJ5ICkge1xuXG5cdFx0Ly8gQW55IG9iamVjdCB3aXRoIGEgdG8gYW5kIGZyb20gbWV0aG9kIGlzIHN1cHBvcnRlZC5cblx0XHRpZiAoIGlzVmFsaWRGb3JtYXR0ZXIoZW50cnkpICkge1xuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fVxuXG5cdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnZm9ybWF0JyByZXF1aXJlcyAndG8nIGFuZCAnZnJvbScgbWV0aG9kcy5cIik7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0U3RlcCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoICFpc051bWVyaWMoIGVudHJ5ICkgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdzdGVwJyBpcyBub3QgbnVtZXJpYy5cIik7XG5cdFx0fVxuXG5cdFx0Ly8gVGhlIHN0ZXAgb3B0aW9uIGNhbiBzdGlsbCBiZSB1c2VkIHRvIHNldCBzdGVwcGluZ1xuXHRcdC8vIGZvciBsaW5lYXIgc2xpZGVycy4gT3ZlcndyaXR0ZW4gaWYgc2V0IGluICdyYW5nZScuXG5cdFx0cGFyc2VkLnNpbmdsZVN0ZXAgPSBlbnRyeTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RSYW5nZSAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBGaWx0ZXIgaW5jb3JyZWN0IGlucHV0LlxuXHRcdGlmICggdHlwZW9mIGVudHJ5ICE9PSAnb2JqZWN0JyB8fCBBcnJheS5pc0FycmF5KGVudHJ5KSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3JhbmdlJyBpcyBub3QgYW4gb2JqZWN0LlwiKTtcblx0XHR9XG5cblx0XHQvLyBDYXRjaCBtaXNzaW5nIHN0YXJ0IG9yIGVuZC5cblx0XHRpZiAoIGVudHJ5Lm1pbiA9PT0gdW5kZWZpbmVkIHx8IGVudHJ5Lm1heCA9PT0gdW5kZWZpbmVkICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiBNaXNzaW5nICdtaW4nIG9yICdtYXgnIGluICdyYW5nZScuXCIpO1xuXHRcdH1cblxuXHRcdC8vIENhdGNoIGVxdWFsIHN0YXJ0IG9yIGVuZC5cblx0XHRpZiAoIGVudHJ5Lm1pbiA9PT0gZW50cnkubWF4ICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncmFuZ2UnICdtaW4nIGFuZCAnbWF4JyBjYW5ub3QgYmUgZXF1YWwuXCIpO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5zcGVjdHJ1bSA9IG5ldyBTcGVjdHJ1bShlbnRyeSwgcGFyc2VkLnNuYXAsIHBhcnNlZC5zaW5nbGVTdGVwKTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RTdGFydCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRlbnRyeSA9IGFzQXJyYXkoZW50cnkpO1xuXG5cdFx0Ly8gVmFsaWRhdGUgaW5wdXQuIFZhbHVlcyBhcmVuJ3QgdGVzdGVkLCBhcyB0aGUgcHVibGljIC52YWwgbWV0aG9kXG5cdFx0Ly8gd2lsbCBhbHdheXMgcHJvdmlkZSBhIHZhbGlkIGxvY2F0aW9uLlxuXHRcdGlmICggIUFycmF5LmlzQXJyYXkoIGVudHJ5ICkgfHwgIWVudHJ5Lmxlbmd0aCApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3N0YXJ0JyBvcHRpb24gaXMgaW5jb3JyZWN0LlwiKTtcblx0XHR9XG5cblx0XHQvLyBTdG9yZSB0aGUgbnVtYmVyIG9mIGhhbmRsZXMuXG5cdFx0cGFyc2VkLmhhbmRsZXMgPSBlbnRyeS5sZW5ndGg7XG5cblx0XHQvLyBXaGVuIHRoZSBzbGlkZXIgaXMgaW5pdGlhbGl6ZWQsIHRoZSAudmFsIG1ldGhvZCB3aWxsXG5cdFx0Ly8gYmUgY2FsbGVkIHdpdGggdGhlIHN0YXJ0IG9wdGlvbnMuXG5cdFx0cGFyc2VkLnN0YXJ0ID0gZW50cnk7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0U25hcCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBFbmZvcmNlIDEwMCUgc3RlcHBpbmcgd2l0aGluIHN1YnJhbmdlcy5cblx0XHRwYXJzZWQuc25hcCA9IGVudHJ5O1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdib29sZWFuJyApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnc25hcCcgb3B0aW9uIG11c3QgYmUgYSBib29sZWFuLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0QW5pbWF0ZSAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBFbmZvcmNlIDEwMCUgc3RlcHBpbmcgd2l0aGluIHN1YnJhbmdlcy5cblx0XHRwYXJzZWQuYW5pbWF0ZSA9IGVudHJ5O1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdib29sZWFuJyApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnYW5pbWF0ZScgb3B0aW9uIG11c3QgYmUgYSBib29sZWFuLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0QW5pbWF0aW9uRHVyYXRpb24gKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0cGFyc2VkLmFuaW1hdGlvbkR1cmF0aW9uID0gZW50cnk7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ251bWJlcicgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2FuaW1hdGlvbkR1cmF0aW9uJyBvcHRpb24gbXVzdCBiZSBhIG51bWJlci5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdENvbm5lY3QgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0dmFyIGNvbm5lY3QgPSBbZmFsc2VdO1xuXHRcdHZhciBpO1xuXG5cdFx0Ly8gTWFwIGxlZ2FjeSBvcHRpb25zXG5cdFx0aWYgKCBlbnRyeSA9PT0gJ2xvd2VyJyApIHtcblx0XHRcdGVudHJ5ID0gW3RydWUsIGZhbHNlXTtcblx0XHR9XG5cblx0XHRlbHNlIGlmICggZW50cnkgPT09ICd1cHBlcicgKSB7XG5cdFx0XHRlbnRyeSA9IFtmYWxzZSwgdHJ1ZV07XG5cdFx0fVxuXG5cdFx0Ly8gSGFuZGxlIGJvb2xlYW4gb3B0aW9uc1xuXHRcdGlmICggZW50cnkgPT09IHRydWUgfHwgZW50cnkgPT09IGZhbHNlICkge1xuXG5cdFx0XHRmb3IgKCBpID0gMTsgaSA8IHBhcnNlZC5oYW5kbGVzOyBpKysgKSB7XG5cdFx0XHRcdGNvbm5lY3QucHVzaChlbnRyeSk7XG5cdFx0XHR9XG5cblx0XHRcdGNvbm5lY3QucHVzaChmYWxzZSk7XG5cdFx0fVxuXG5cdFx0Ly8gUmVqZWN0IGludmFsaWQgaW5wdXRcblx0XHRlbHNlIGlmICggIUFycmF5LmlzQXJyYXkoIGVudHJ5ICkgfHwgIWVudHJ5Lmxlbmd0aCB8fCBlbnRyeS5sZW5ndGggIT09IHBhcnNlZC5oYW5kbGVzICsgMSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2Nvbm5lY3QnIG9wdGlvbiBkb2Vzbid0IG1hdGNoIGhhbmRsZSBjb3VudC5cIik7XG5cdFx0fVxuXG5cdFx0ZWxzZSB7XG5cdFx0XHRjb25uZWN0ID0gZW50cnk7XG5cdFx0fVxuXG5cdFx0cGFyc2VkLmNvbm5lY3QgPSBjb25uZWN0O1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdE9yaWVudGF0aW9uICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdC8vIFNldCBvcmllbnRhdGlvbiB0byBhbiBhIG51bWVyaWNhbCB2YWx1ZSBmb3IgZWFzeVxuXHRcdC8vIGFycmF5IHNlbGVjdGlvbi5cblx0XHRzd2l0Y2ggKCBlbnRyeSApe1xuXHRcdFx0Y2FzZSAnaG9yaXpvbnRhbCc6XG5cdFx0XHRcdHBhcnNlZC5vcnQgPSAwO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdGNhc2UgJ3ZlcnRpY2FsJzpcblx0XHRcdFx0cGFyc2VkLm9ydCA9IDE7XG5cdFx0XHRcdGJyZWFrO1xuXHRcdFx0ZGVmYXVsdDpcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnb3JpZW50YXRpb24nIG9wdGlvbiBpcyBpbnZhbGlkLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0TWFyZ2luICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGlmICggIWlzTnVtZXJpYyhlbnRyeSkgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ21hcmdpbicgb3B0aW9uIG11c3QgYmUgbnVtZXJpYy5cIik7XG5cdFx0fVxuXG5cdFx0Ly8gSXNzdWUgIzU4MlxuXHRcdGlmICggZW50cnkgPT09IDAgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0cGFyc2VkLm1hcmdpbiA9IHBhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnkpO1xuXG5cdFx0aWYgKCAhcGFyc2VkLm1hcmdpbiApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ21hcmdpbicgb3B0aW9uIGlzIG9ubHkgc3VwcG9ydGVkIG9uIGxpbmVhciBzbGlkZXJzLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0TGltaXQgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCAhaXNOdW1lcmljKGVudHJ5KSApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbGltaXQnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMuXCIpO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5saW1pdCA9IHBhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnkpO1xuXG5cdFx0aWYgKCAhcGFyc2VkLmxpbWl0IHx8IHBhcnNlZC5oYW5kbGVzIDwgMiApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2xpbWl0JyBvcHRpb24gaXMgb25seSBzdXBwb3J0ZWQgb24gbGluZWFyIHNsaWRlcnMgd2l0aCAyIG9yIG1vcmUgaGFuZGxlcy5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdFBhZGRpbmcgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCAhaXNOdW1lcmljKGVudHJ5KSAmJiAhQXJyYXkuaXNBcnJheShlbnRyeSkgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMgb3IgYXJyYXkgb2YgZXhhY3RseSAyIG51bWJlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggQXJyYXkuaXNBcnJheShlbnRyeSkgJiYgIShlbnRyeS5sZW5ndGggPT09IDIgfHwgaXNOdW1lcmljKGVudHJ5WzBdKSB8fCBpc051bWVyaWMoZW50cnlbMV0pKSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMgb3IgYXJyYXkgb2YgZXhhY3RseSAyIG51bWJlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggZW50cnkgPT09IDAgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0aWYgKCAhQXJyYXkuaXNBcnJheShlbnRyeSkgKSB7XG5cdFx0XHRlbnRyeSA9IFtlbnRyeSwgZW50cnldO1xuXHRcdH1cblxuXHRcdC8vICdnZXRNYXJnaW4nIHJldHVybnMgZmFsc2UgZm9yIGludmFsaWQgdmFsdWVzLlxuXHRcdHBhcnNlZC5wYWRkaW5nID0gW3BhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnlbMF0pLCBwYXJzZWQuc3BlY3RydW0uZ2V0TWFyZ2luKGVudHJ5WzFdKV07XG5cblx0XHRpZiAoIHBhcnNlZC5wYWRkaW5nWzBdID09PSBmYWxzZSB8fCBwYXJzZWQucGFkZGluZ1sxXSA9PT0gZmFsc2UgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdwYWRkaW5nJyBvcHRpb24gaXMgb25seSBzdXBwb3J0ZWQgb24gbGluZWFyIHNsaWRlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggcGFyc2VkLnBhZGRpbmdbMF0gPCAwIHx8IHBhcnNlZC5wYWRkaW5nWzFdIDwgMCApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIGEgcG9zaXRpdmUgbnVtYmVyKHMpLlwiKTtcblx0XHR9XG5cblx0XHRpZiAoIHBhcnNlZC5wYWRkaW5nWzBdICsgcGFyc2VkLnBhZGRpbmdbMV0gPj0gMTAwICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncGFkZGluZycgb3B0aW9uIG11c3Qgbm90IGV4Y2VlZCAxMDAlIG9mIHRoZSByYW5nZS5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdERpcmVjdGlvbiAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBTZXQgZGlyZWN0aW9uIGFzIGEgbnVtZXJpY2FsIHZhbHVlIGZvciBlYXN5IHBhcnNpbmcuXG5cdFx0Ly8gSW52ZXJ0IGNvbm5lY3Rpb24gZm9yIFJUTCBzbGlkZXJzLCBzbyB0aGF0IHRoZSBwcm9wZXJcblx0XHQvLyBoYW5kbGVzIGdldCB0aGUgY29ubmVjdC9iYWNrZ3JvdW5kIGNsYXNzZXMuXG5cdFx0c3dpdGNoICggZW50cnkgKSB7XG5cdFx0XHRjYXNlICdsdHInOlxuXHRcdFx0XHRwYXJzZWQuZGlyID0gMDtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHRjYXNlICdydGwnOlxuXHRcdFx0XHRwYXJzZWQuZGlyID0gMTtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHRkZWZhdWx0OlxuXHRcdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdkaXJlY3Rpb24nIG9wdGlvbiB3YXMgbm90IHJlY29nbml6ZWQuXCIpO1xuXHRcdH1cblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RCZWhhdmlvdXIgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSBpbnB1dCBpcyBhIHN0cmluZy5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ3N0cmluZycgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdiZWhhdmlvdXInIG11c3QgYmUgYSBzdHJpbmcgY29udGFpbmluZyBvcHRpb25zLlwiKTtcblx0XHR9XG5cblx0XHQvLyBDaGVjayBpZiB0aGUgc3RyaW5nIGNvbnRhaW5zIGFueSBrZXl3b3Jkcy5cblx0XHQvLyBOb25lIGFyZSByZXF1aXJlZC5cblx0XHR2YXIgdGFwID0gZW50cnkuaW5kZXhPZigndGFwJykgPj0gMDtcblx0XHR2YXIgZHJhZyA9IGVudHJ5LmluZGV4T2YoJ2RyYWcnKSA+PSAwO1xuXHRcdHZhciBmaXhlZCA9IGVudHJ5LmluZGV4T2YoJ2ZpeGVkJykgPj0gMDtcblx0XHR2YXIgc25hcCA9IGVudHJ5LmluZGV4T2YoJ3NuYXAnKSA+PSAwO1xuXHRcdHZhciBob3ZlciA9IGVudHJ5LmluZGV4T2YoJ2hvdmVyJykgPj0gMDtcblxuXHRcdGlmICggZml4ZWQgKSB7XG5cblx0XHRcdGlmICggcGFyc2VkLmhhbmRsZXMgIT09IDIgKSB7XG5cdFx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2ZpeGVkJyBiZWhhdmlvdXIgbXVzdCBiZSB1c2VkIHdpdGggMiBoYW5kbGVzXCIpO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBVc2UgbWFyZ2luIHRvIGVuZm9yY2UgZml4ZWQgc3RhdGVcblx0XHRcdHRlc3RNYXJnaW4ocGFyc2VkLCBwYXJzZWQuc3RhcnRbMV0gLSBwYXJzZWQuc3RhcnRbMF0pO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5ldmVudHMgPSB7XG5cdFx0XHR0YXA6IHRhcCB8fCBzbmFwLFxuXHRcdFx0ZHJhZzogZHJhZyxcblx0XHRcdGZpeGVkOiBmaXhlZCxcblx0XHRcdHNuYXA6IHNuYXAsXG5cdFx0XHRob3ZlcjogaG92ZXJcblx0XHR9O1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdFRvb2x0aXBzICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGlmICggZW50cnkgPT09IGZhbHNlICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdGVsc2UgaWYgKCBlbnRyeSA9PT0gdHJ1ZSApIHtcblxuXHRcdFx0cGFyc2VkLnRvb2x0aXBzID0gW107XG5cblx0XHRcdGZvciAoIHZhciBpID0gMDsgaSA8IHBhcnNlZC5oYW5kbGVzOyBpKysgKSB7XG5cdFx0XHRcdHBhcnNlZC50b29sdGlwcy5wdXNoKHRydWUpO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdGVsc2Uge1xuXG5cdFx0XHRwYXJzZWQudG9vbHRpcHMgPSBhc0FycmF5KGVudHJ5KTtcblxuXHRcdFx0aWYgKCBwYXJzZWQudG9vbHRpcHMubGVuZ3RoICE9PSBwYXJzZWQuaGFuZGxlcyApIHtcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiBtdXN0IHBhc3MgYSBmb3JtYXR0ZXIgZm9yIGFsbCBoYW5kbGVzLlwiKTtcblx0XHRcdH1cblxuXHRcdFx0cGFyc2VkLnRvb2x0aXBzLmZvckVhY2goZnVuY3Rpb24oZm9ybWF0dGVyKXtcblx0XHRcdFx0aWYgKCB0eXBlb2YgZm9ybWF0dGVyICE9PSAnYm9vbGVhbicgJiYgKHR5cGVvZiBmb3JtYXR0ZXIgIT09ICdvYmplY3QnIHx8IHR5cGVvZiBmb3JtYXR0ZXIudG8gIT09ICdmdW5jdGlvbicpICkge1xuXHRcdFx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3Rvb2x0aXBzJyBtdXN0IGJlIHBhc3NlZCBhIGZvcm1hdHRlciBvciAnZmFsc2UnLlwiKTtcblx0XHRcdFx0fVxuXHRcdFx0fSk7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdEFyaWFGb3JtYXQgKCBwYXJzZWQsIGVudHJ5ICkge1xuXHRcdHBhcnNlZC5hcmlhRm9ybWF0ID0gZW50cnk7XG5cdFx0dmFsaWRhdGVGb3JtYXQoZW50cnkpO1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdEZvcm1hdCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cdFx0cGFyc2VkLmZvcm1hdCA9IGVudHJ5O1xuXHRcdHZhbGlkYXRlRm9ybWF0KGVudHJ5KTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RDc3NQcmVmaXggKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdzdHJpbmcnICYmIGVudHJ5ICE9PSBmYWxzZSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2Nzc1ByZWZpeCcgbXVzdCBiZSBhIHN0cmluZyBvciBgZmFsc2VgLlwiKTtcblx0XHR9XG5cblx0XHRwYXJzZWQuY3NzUHJlZml4ID0gZW50cnk7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0Q3NzQ2xhc3NlcyAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ29iamVjdCcgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdjc3NDbGFzc2VzJyBtdXN0IGJlIGFuIG9iamVjdC5cIik7XG5cdFx0fVxuXG5cdFx0aWYgKCB0eXBlb2YgcGFyc2VkLmNzc1ByZWZpeCA9PT0gJ3N0cmluZycgKSB7XG5cdFx0XHRwYXJzZWQuY3NzQ2xhc3NlcyA9IHt9O1xuXG5cdFx0XHRmb3IgKCB2YXIga2V5IGluIGVudHJ5ICkge1xuXHRcdFx0XHRpZiAoICFlbnRyeS5oYXNPd25Qcm9wZXJ0eShrZXkpICkgeyBjb250aW51ZTsgfVxuXG5cdFx0XHRcdHBhcnNlZC5jc3NDbGFzc2VzW2tleV0gPSBwYXJzZWQuY3NzUHJlZml4ICsgZW50cnlba2V5XTtcblx0XHRcdH1cblx0XHR9IGVsc2Uge1xuXHRcdFx0cGFyc2VkLmNzc0NsYXNzZXMgPSBlbnRyeTtcblx0XHR9XG5cdH1cblxuXHQvLyBUZXN0IGFsbCBkZXZlbG9wZXIgc2V0dGluZ3MgYW5kIHBhcnNlIHRvIGFzc3VtcHRpb24tc2FmZSB2YWx1ZXMuXG5cdGZ1bmN0aW9uIHRlc3RPcHRpb25zICggb3B0aW9ucyApIHtcblxuXHRcdC8vIFRvIHByb3ZlIGEgZml4IGZvciAjNTM3LCBmcmVlemUgb3B0aW9ucyBoZXJlLlxuXHRcdC8vIElmIHRoZSBvYmplY3QgaXMgbW9kaWZpZWQsIGFuIGVycm9yIHdpbGwgYmUgdGhyb3duLlxuXHRcdC8vIE9iamVjdC5mcmVlemUob3B0aW9ucyk7XG5cblx0XHR2YXIgcGFyc2VkID0ge1xuXHRcdFx0bWFyZ2luOiAwLFxuXHRcdFx0bGltaXQ6IDAsXG5cdFx0XHRwYWRkaW5nOiAwLFxuXHRcdFx0YW5pbWF0ZTogdHJ1ZSxcblx0XHRcdGFuaW1hdGlvbkR1cmF0aW9uOiAzMDAsXG5cdFx0XHRhcmlhRm9ybWF0OiBkZWZhdWx0Rm9ybWF0dGVyLFxuXHRcdFx0Zm9ybWF0OiBkZWZhdWx0Rm9ybWF0dGVyXG5cdFx0fTtcblxuXHRcdC8vIFRlc3RzIGFyZSBleGVjdXRlZCBpbiB0aGUgb3JkZXIgdGhleSBhcmUgcHJlc2VudGVkIGhlcmUuXG5cdFx0dmFyIHRlc3RzID0ge1xuXHRcdFx0J3N0ZXAnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0U3RlcCB9LFxuXHRcdFx0J3N0YXJ0JzogeyByOiB0cnVlLCB0OiB0ZXN0U3RhcnQgfSxcblx0XHRcdCdjb25uZWN0JzogeyByOiB0cnVlLCB0OiB0ZXN0Q29ubmVjdCB9LFxuXHRcdFx0J2RpcmVjdGlvbic6IHsgcjogdHJ1ZSwgdDogdGVzdERpcmVjdGlvbiB9LFxuXHRcdFx0J3NuYXAnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0U25hcCB9LFxuXHRcdFx0J2FuaW1hdGUnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0QW5pbWF0ZSB9LFxuXHRcdFx0J2FuaW1hdGlvbkR1cmF0aW9uJzogeyByOiBmYWxzZSwgdDogdGVzdEFuaW1hdGlvbkR1cmF0aW9uIH0sXG5cdFx0XHQncmFuZ2UnOiB7IHI6IHRydWUsIHQ6IHRlc3RSYW5nZSB9LFxuXHRcdFx0J29yaWVudGF0aW9uJzogeyByOiBmYWxzZSwgdDogdGVzdE9yaWVudGF0aW9uIH0sXG5cdFx0XHQnbWFyZ2luJzogeyByOiBmYWxzZSwgdDogdGVzdE1hcmdpbiB9LFxuXHRcdFx0J2xpbWl0JzogeyByOiBmYWxzZSwgdDogdGVzdExpbWl0IH0sXG5cdFx0XHQncGFkZGluZyc6IHsgcjogZmFsc2UsIHQ6IHRlc3RQYWRkaW5nIH0sXG5cdFx0XHQnYmVoYXZpb3VyJzogeyByOiB0cnVlLCB0OiB0ZXN0QmVoYXZpb3VyIH0sXG5cdFx0XHQnYXJpYUZvcm1hdCc6IHsgcjogZmFsc2UsIHQ6IHRlc3RBcmlhRm9ybWF0IH0sXG5cdFx0XHQnZm9ybWF0JzogeyByOiBmYWxzZSwgdDogdGVzdEZvcm1hdCB9LFxuXHRcdFx0J3Rvb2x0aXBzJzogeyByOiBmYWxzZSwgdDogdGVzdFRvb2x0aXBzIH0sXG5cdFx0XHQnY3NzUHJlZml4JzogeyByOiB0cnVlLCB0OiB0ZXN0Q3NzUHJlZml4IH0sXG5cdFx0XHQnY3NzQ2xhc3Nlcyc6IHsgcjogdHJ1ZSwgdDogdGVzdENzc0NsYXNzZXMgfVxuXHRcdH07XG5cblx0XHR2YXIgZGVmYXVsdHMgPSB7XG5cdFx0XHQnY29ubmVjdCc6IGZhbHNlLFxuXHRcdFx0J2RpcmVjdGlvbic6ICdsdHInLFxuXHRcdFx0J2JlaGF2aW91cic6ICd0YXAnLFxuXHRcdFx0J29yaWVudGF0aW9uJzogJ2hvcml6b250YWwnLFxuXHRcdFx0J2Nzc1ByZWZpeCcgOiAnbm9VaS0nLFxuXHRcdFx0J2Nzc0NsYXNzZXMnOiB7XG5cdFx0XHRcdHRhcmdldDogJ3RhcmdldCcsXG5cdFx0XHRcdGJhc2U6ICdiYXNlJyxcblx0XHRcdFx0b3JpZ2luOiAnb3JpZ2luJyxcblx0XHRcdFx0aGFuZGxlOiAnaGFuZGxlJyxcblx0XHRcdFx0aGFuZGxlTG93ZXI6ICdoYW5kbGUtbG93ZXInLFxuXHRcdFx0XHRoYW5kbGVVcHBlcjogJ2hhbmRsZS11cHBlcicsXG5cdFx0XHRcdGhvcml6b250YWw6ICdob3Jpem9udGFsJyxcblx0XHRcdFx0dmVydGljYWw6ICd2ZXJ0aWNhbCcsXG5cdFx0XHRcdGJhY2tncm91bmQ6ICdiYWNrZ3JvdW5kJyxcblx0XHRcdFx0Y29ubmVjdDogJ2Nvbm5lY3QnLFxuXHRcdFx0XHRjb25uZWN0czogJ2Nvbm5lY3RzJyxcblx0XHRcdFx0bHRyOiAnbHRyJyxcblx0XHRcdFx0cnRsOiAncnRsJyxcblx0XHRcdFx0ZHJhZ2dhYmxlOiAnZHJhZ2dhYmxlJyxcblx0XHRcdFx0ZHJhZzogJ3N0YXRlLWRyYWcnLFxuXHRcdFx0XHR0YXA6ICdzdGF0ZS10YXAnLFxuXHRcdFx0XHRhY3RpdmU6ICdhY3RpdmUnLFxuXHRcdFx0XHR0b29sdGlwOiAndG9vbHRpcCcsXG5cdFx0XHRcdHBpcHM6ICdwaXBzJyxcblx0XHRcdFx0cGlwc0hvcml6b250YWw6ICdwaXBzLWhvcml6b250YWwnLFxuXHRcdFx0XHRwaXBzVmVydGljYWw6ICdwaXBzLXZlcnRpY2FsJyxcblx0XHRcdFx0bWFya2VyOiAnbWFya2VyJyxcblx0XHRcdFx0bWFya2VySG9yaXpvbnRhbDogJ21hcmtlci1ob3Jpem9udGFsJyxcblx0XHRcdFx0bWFya2VyVmVydGljYWw6ICdtYXJrZXItdmVydGljYWwnLFxuXHRcdFx0XHRtYXJrZXJOb3JtYWw6ICdtYXJrZXItbm9ybWFsJyxcblx0XHRcdFx0bWFya2VyTGFyZ2U6ICdtYXJrZXItbGFyZ2UnLFxuXHRcdFx0XHRtYXJrZXJTdWI6ICdtYXJrZXItc3ViJyxcblx0XHRcdFx0dmFsdWU6ICd2YWx1ZScsXG5cdFx0XHRcdHZhbHVlSG9yaXpvbnRhbDogJ3ZhbHVlLWhvcml6b250YWwnLFxuXHRcdFx0XHR2YWx1ZVZlcnRpY2FsOiAndmFsdWUtdmVydGljYWwnLFxuXHRcdFx0XHR2YWx1ZU5vcm1hbDogJ3ZhbHVlLW5vcm1hbCcsXG5cdFx0XHRcdHZhbHVlTGFyZ2U6ICd2YWx1ZS1sYXJnZScsXG5cdFx0XHRcdHZhbHVlU3ViOiAndmFsdWUtc3ViJ1xuXHRcdFx0fVxuXHRcdH07XG5cblx0XHQvLyBBcmlhRm9ybWF0IGRlZmF1bHRzIHRvIHJlZ3VsYXIgZm9ybWF0LCBpZiBhbnkuXG5cdFx0aWYgKCBvcHRpb25zLmZvcm1hdCAmJiAhb3B0aW9ucy5hcmlhRm9ybWF0ICkge1xuXHRcdFx0b3B0aW9ucy5hcmlhRm9ybWF0ID0gb3B0aW9ucy5mb3JtYXQ7XG5cdFx0fVxuXG5cdFx0Ly8gUnVuIGFsbCBvcHRpb25zIHRocm91Z2ggYSB0ZXN0aW5nIG1lY2hhbmlzbSB0byBlbnN1cmUgY29ycmVjdFxuXHRcdC8vIGlucHV0LiBJdCBzaG91bGQgYmUgbm90ZWQgdGhhdCBvcHRpb25zIG1pZ2h0IGdldCBtb2RpZmllZCB0b1xuXHRcdC8vIGJlIGhhbmRsZWQgcHJvcGVybHkuIEUuZy4gd3JhcHBpbmcgaW50ZWdlcnMgaW4gYXJyYXlzLlxuXHRcdE9iamVjdC5rZXlzKHRlc3RzKS5mb3JFYWNoKGZ1bmN0aW9uKCBuYW1lICl7XG5cblx0XHRcdC8vIElmIHRoZSBvcHRpb24gaXNuJ3Qgc2V0LCBidXQgaXQgaXMgcmVxdWlyZWQsIHRocm93IGFuIGVycm9yLlxuXHRcdFx0aWYgKCAhaXNTZXQob3B0aW9uc1tuYW1lXSkgJiYgZGVmYXVsdHNbbmFtZV0gPT09IHVuZGVmaW5lZCApIHtcblxuXHRcdFx0XHRpZiAoIHRlc3RzW25hbWVdLnIgKSB7XG5cdFx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnXCIgKyBuYW1lICsgXCInIGlzIHJlcXVpcmVkLlwiKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHJldHVybiB0cnVlO1xuXHRcdFx0fVxuXG5cdFx0XHR0ZXN0c1tuYW1lXS50KCBwYXJzZWQsICFpc1NldChvcHRpb25zW25hbWVdKSA/IGRlZmF1bHRzW25hbWVdIDogb3B0aW9uc1tuYW1lXSApO1xuXHRcdH0pO1xuXG5cdFx0Ly8gRm9yd2FyZCBwaXBzIG9wdGlvbnNcblx0XHRwYXJzZWQucGlwcyA9IG9wdGlvbnMucGlwcztcblxuXHRcdC8vIEFsbCByZWNlbnQgYnJvd3NlcnMgYWNjZXB0IHVucHJlZml4ZWQgdHJhbnNmb3JtLlxuXHRcdC8vIFdlIG5lZWQgLW1zLSBmb3IgSUU5IGFuZCAtd2Via2l0LSBmb3Igb2xkZXIgQW5kcm9pZDtcblx0XHQvLyBBc3N1bWUgdXNlIG9mIC13ZWJraXQtIGlmIHVucHJlZml4ZWQgYW5kIC1tcy0gYXJlIG5vdCBzdXBwb3J0ZWQuXG5cdFx0Ly8gaHR0cHM6Ly9jYW5pdXNlLmNvbS8jZmVhdD10cmFuc2Zvcm1zMmRcblx0XHR2YXIgZCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJkaXZcIik7XG5cdFx0dmFyIG1zUHJlZml4ID0gZC5zdHlsZS5tc1RyYW5zZm9ybSAhPT0gdW5kZWZpbmVkO1xuXHRcdHZhciBub1ByZWZpeCA9IGQuc3R5bGUudHJhbnNmb3JtICE9PSB1bmRlZmluZWQ7XG5cblx0XHRwYXJzZWQudHJhbnNmb3JtUnVsZSA9IG5vUHJlZml4ID8gJ3RyYW5zZm9ybScgOiAobXNQcmVmaXggPyAnbXNUcmFuc2Zvcm0nIDogJ3dlYmtpdFRyYW5zZm9ybScpO1xuXG5cdFx0Ly8gUGlwcyBkb24ndCBtb3ZlLCBzbyB3ZSBjYW4gcGxhY2UgdGhlbSB1c2luZyBsZWZ0L3RvcC5cblx0XHR2YXIgc3R5bGVzID0gW1snbGVmdCcsICd0b3AnXSwgWydyaWdodCcsICdib3R0b20nXV07XG5cblx0XHRwYXJzZWQuc3R5bGUgPSBzdHlsZXNbcGFyc2VkLmRpcl1bcGFyc2VkLm9ydF07XG5cblx0XHRyZXR1cm4gcGFyc2VkO1xuXHR9XG5cclxuXHJcbmZ1bmN0aW9uIHNjb3BlICggdGFyZ2V0LCBvcHRpb25zLCBvcmlnaW5hbE9wdGlvbnMgKXtcclxuXHJcblx0dmFyIGFjdGlvbnMgPSBnZXRBY3Rpb25zKCk7XHJcblx0dmFyIHN1cHBvcnRzVG91Y2hBY3Rpb25Ob25lID0gZ2V0U3VwcG9ydHNUb3VjaEFjdGlvbk5vbmUoKTtcclxuXHR2YXIgc3VwcG9ydHNQYXNzaXZlID0gc3VwcG9ydHNUb3VjaEFjdGlvbk5vbmUgJiYgZ2V0U3VwcG9ydHNQYXNzaXZlKCk7XHJcblxyXG5cdC8vIEFsbCB2YXJpYWJsZXMgbG9jYWwgdG8gJ3Njb3BlJyBhcmUgcHJlZml4ZWQgd2l0aCAnc2NvcGVfJ1xyXG5cdHZhciBzY29wZV9UYXJnZXQgPSB0YXJnZXQ7XHJcblx0dmFyIHNjb3BlX0xvY2F0aW9ucyA9IFtdO1xyXG5cdHZhciBzY29wZV9CYXNlO1xyXG5cdHZhciBzY29wZV9IYW5kbGVzO1xyXG5cdHZhciBzY29wZV9IYW5kbGVOdW1iZXJzID0gW107XHJcblx0dmFyIHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCA9IDA7XHJcblx0dmFyIHNjb3BlX0Nvbm5lY3RzO1xyXG5cdHZhciBzY29wZV9TcGVjdHJ1bSA9IG9wdGlvbnMuc3BlY3RydW07XHJcblx0dmFyIHNjb3BlX1ZhbHVlcyA9IFtdO1xyXG5cdHZhciBzY29wZV9FdmVudHMgPSB7fTtcclxuXHR2YXIgc2NvcGVfU2VsZjtcclxuXHR2YXIgc2NvcGVfUGlwcztcclxuXHR2YXIgc2NvcGVfRG9jdW1lbnQgPSB0YXJnZXQub3duZXJEb2N1bWVudDtcclxuXHR2YXIgc2NvcGVfRG9jdW1lbnRFbGVtZW50ID0gc2NvcGVfRG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50O1xyXG5cdHZhciBzY29wZV9Cb2R5ID0gc2NvcGVfRG9jdW1lbnQuYm9keTtcclxuXHJcblxyXG5cdC8vIEZvciBob3Jpem9udGFsIHNsaWRlcnMgaW4gc3RhbmRhcmQgbHRyIGRvY3VtZW50cyxcclxuXHQvLyBtYWtlIC5ub1VpLW9yaWdpbiBvdmVyZmxvdyB0byB0aGUgbGVmdCBzbyB0aGUgZG9jdW1lbnQgZG9lc24ndCBzY3JvbGwuXHJcblx0dmFyIHNjb3BlX0Rpck9mZnNldCA9IChzY29wZV9Eb2N1bWVudC5kaXIgPT09ICdydGwnKSB8fCAob3B0aW9ucy5vcnQgPT09IDEpID8gMCA6IDEwMDtcclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IENvbnN0cnVjdGlvbiBvZiBET00gZWxlbWVudHM7ICovXHJcblxyXG5cdC8vIENyZWF0ZXMgYSBub2RlLCBhZGRzIGl0IHRvIHRhcmdldCwgcmV0dXJucyB0aGUgbmV3IG5vZGUuXHJcblx0ZnVuY3Rpb24gYWRkTm9kZVRvICggYWRkVGFyZ2V0LCBjbGFzc05hbWUgKSB7XHJcblxyXG5cdFx0dmFyIGRpdiA9IHNjb3BlX0RvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xyXG5cclxuXHRcdGlmICggY2xhc3NOYW1lICkge1xyXG5cdFx0XHRhZGRDbGFzcyhkaXYsIGNsYXNzTmFtZSk7XHJcblx0XHR9XHJcblxyXG5cdFx0YWRkVGFyZ2V0LmFwcGVuZENoaWxkKGRpdik7XHJcblxyXG5cdFx0cmV0dXJuIGRpdjtcclxuXHR9XHJcblxyXG5cdC8vIEFwcGVuZCBhIG9yaWdpbiB0byB0aGUgYmFzZVxyXG5cdGZ1bmN0aW9uIGFkZE9yaWdpbiAoIGJhc2UsIGhhbmRsZU51bWJlciApIHtcclxuXHJcblx0XHR2YXIgb3JpZ2luID0gYWRkTm9kZVRvKGJhc2UsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5vcmlnaW4pO1xyXG5cdFx0dmFyIGhhbmRsZSA9IGFkZE5vZGVUbyhvcmlnaW4sIG9wdGlvbnMuY3NzQ2xhc3Nlcy5oYW5kbGUpO1xyXG5cclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ2RhdGEtaGFuZGxlJywgaGFuZGxlTnVtYmVyKTtcclxuXHJcblx0XHQvLyBodHRwczovL2RldmVsb3Blci5tb3ppbGxhLm9yZy9lbi1VUy9kb2NzL1dlYi9IVE1ML0dsb2JhbF9hdHRyaWJ1dGVzL3RhYmluZGV4XHJcblx0XHQvLyAwID0gZm9jdXNhYmxlIGFuZCByZWFjaGFibGVcclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ3RhYmluZGV4JywgJzAnKTtcclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ3JvbGUnLCAnc2xpZGVyJyk7XHJcblx0XHRoYW5kbGUuc2V0QXR0cmlidXRlKCdhcmlhLW9yaWVudGF0aW9uJywgb3B0aW9ucy5vcnQgPyAndmVydGljYWwnIDogJ2hvcml6b250YWwnKTtcclxuXHJcblx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gMCApIHtcclxuXHRcdFx0YWRkQ2xhc3MoaGFuZGxlLCBvcHRpb25zLmNzc0NsYXNzZXMuaGFuZGxlTG93ZXIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGVsc2UgaWYgKCBoYW5kbGVOdW1iZXIgPT09IG9wdGlvbnMuaGFuZGxlcyAtIDEgKSB7XHJcblx0XHRcdGFkZENsYXNzKGhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmhhbmRsZVVwcGVyKTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gb3JpZ2luO1xyXG5cdH1cclxuXHJcblx0Ly8gSW5zZXJ0IG5vZGVzIGZvciBjb25uZWN0IGVsZW1lbnRzXHJcblx0ZnVuY3Rpb24gYWRkQ29ubmVjdCAoIGJhc2UsIGFkZCApIHtcclxuXHJcblx0XHRpZiAoICFhZGQgKSB7XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gYWRkTm9kZVRvKGJhc2UsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5jb25uZWN0KTtcclxuXHR9XHJcblxyXG5cdC8vIEFkZCBoYW5kbGVzIHRvIHRoZSBzbGlkZXIgYmFzZS5cclxuXHRmdW5jdGlvbiBhZGRFbGVtZW50cyAoIGNvbm5lY3RPcHRpb25zLCBiYXNlICkge1xyXG5cclxuXHRcdHZhciBjb25uZWN0QmFzZSA9IGFkZE5vZGVUbyhiYXNlLCBvcHRpb25zLmNzc0NsYXNzZXMuY29ubmVjdHMpO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZXMgPSBbXTtcclxuXHRcdHNjb3BlX0Nvbm5lY3RzID0gW107XHJcblxyXG5cdFx0c2NvcGVfQ29ubmVjdHMucHVzaChhZGRDb25uZWN0KGNvbm5lY3RCYXNlLCBjb25uZWN0T3B0aW9uc1swXSkpO1xyXG5cclxuXHRcdC8vIFs6Ojo6Tz09PT1PPT09PU89PT09XVxyXG5cdFx0Ly8gY29ubmVjdE9wdGlvbnMgPSBbMCwgMSwgMSwgMV1cclxuXHJcblx0XHRmb3IgKCB2YXIgaSA9IDA7IGkgPCBvcHRpb25zLmhhbmRsZXM7IGkrKyApIHtcclxuXHRcdFx0Ly8gS2VlcCBhIGxpc3Qgb2YgYWxsIGFkZGVkIGhhbmRsZXMuXHJcblx0XHRcdHNjb3BlX0hhbmRsZXMucHVzaChhZGRPcmlnaW4oYmFzZSwgaSkpO1xyXG5cdFx0XHRzY29wZV9IYW5kbGVOdW1iZXJzW2ldID0gaTtcclxuXHRcdFx0c2NvcGVfQ29ubmVjdHMucHVzaChhZGRDb25uZWN0KGNvbm5lY3RCYXNlLCBjb25uZWN0T3B0aW9uc1tpICsgMV0pKTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8vIEluaXRpYWxpemUgYSBzaW5nbGUgc2xpZGVyLlxyXG5cdGZ1bmN0aW9uIGFkZFNsaWRlciAoIGFkZFRhcmdldCApIHtcclxuXHJcblx0XHQvLyBBcHBseSBjbGFzc2VzIGFuZCBkYXRhIHRvIHRoZSB0YXJnZXQuXHJcblx0XHRhZGRDbGFzcyhhZGRUYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50YXJnZXQpO1xyXG5cclxuXHRcdGlmICggb3B0aW9ucy5kaXIgPT09IDAgKSB7XHJcblx0XHRcdGFkZENsYXNzKGFkZFRhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmx0cik7XHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHRhZGRDbGFzcyhhZGRUYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5ydGwpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggb3B0aW9ucy5vcnQgPT09IDAgKSB7XHJcblx0XHRcdGFkZENsYXNzKGFkZFRhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmhvcml6b250YWwpO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0YWRkQ2xhc3MoYWRkVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMudmVydGljYWwpO1xyXG5cdFx0fVxyXG5cclxuXHRcdHNjb3BlX0Jhc2UgPSBhZGROb2RlVG8oYWRkVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMuYmFzZSk7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gYWRkVG9vbHRpcCAoIGhhbmRsZSwgaGFuZGxlTnVtYmVyICkge1xyXG5cclxuXHRcdGlmICggIW9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXSApIHtcclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBhZGROb2RlVG8oaGFuZGxlLmZpcnN0Q2hpbGQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50b29sdGlwKTtcclxuXHR9XHJcblxyXG5cdC8vIFRoZSB0b29sdGlwcyBvcHRpb24gaXMgYSBzaG9ydGhhbmQgZm9yIHVzaW5nIHRoZSAndXBkYXRlJyBldmVudC5cclxuXHRmdW5jdGlvbiB0b29sdGlwcyAoICkge1xyXG5cclxuXHRcdC8vIFRvb2x0aXBzIGFyZSBhZGRlZCB3aXRoIG9wdGlvbnMudG9vbHRpcHMgaW4gb3JpZ2luYWwgb3JkZXIuXHJcblx0XHR2YXIgdGlwcyA9IHNjb3BlX0hhbmRsZXMubWFwKGFkZFRvb2x0aXApO1xyXG5cclxuXHRcdGJpbmRFdmVudCgndXBkYXRlJywgZnVuY3Rpb24odmFsdWVzLCBoYW5kbGVOdW1iZXIsIHVuZW5jb2RlZCkge1xyXG5cclxuXHRcdFx0aWYgKCAhdGlwc1toYW5kbGVOdW1iZXJdICkge1xyXG5cdFx0XHRcdHJldHVybjtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0dmFyIGZvcm1hdHRlZFZhbHVlID0gdmFsdWVzW2hhbmRsZU51bWJlcl07XHJcblxyXG5cdFx0XHRpZiAoIG9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXSAhPT0gdHJ1ZSApIHtcclxuXHRcdFx0XHRmb3JtYXR0ZWRWYWx1ZSA9IG9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXS50byh1bmVuY29kZWRbaGFuZGxlTnVtYmVyXSk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHRpcHNbaGFuZGxlTnVtYmVyXS5pbm5lckhUTUwgPSBmb3JtYXR0ZWRWYWx1ZTtcclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblxyXG5cdGZ1bmN0aW9uIGFyaWEgKCApIHtcclxuXHJcblx0XHRiaW5kRXZlbnQoJ3VwZGF0ZScsIGZ1bmN0aW9uICggdmFsdWVzLCBoYW5kbGVOdW1iZXIsIHVuZW5jb2RlZCwgdGFwLCBwb3NpdGlvbnMgKSB7XHJcblxyXG5cdFx0XHQvLyBVcGRhdGUgQXJpYSBWYWx1ZXMgZm9yIGFsbCBoYW5kbGVzLCBhcyBhIGNoYW5nZSBpbiBvbmUgY2hhbmdlcyBtaW4gYW5kIG1heCB2YWx1ZXMgZm9yIHRoZSBuZXh0LlxyXG5cdFx0XHRzY29wZV9IYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oIGluZGV4ICl7XHJcblxyXG5cdFx0XHRcdHZhciBoYW5kbGUgPSBzY29wZV9IYW5kbGVzW2luZGV4XTtcclxuXHJcblx0XHRcdFx0dmFyIG1pbiA9IGNoZWNrSGFuZGxlUG9zaXRpb24oc2NvcGVfTG9jYXRpb25zLCBpbmRleCwgMCwgdHJ1ZSwgdHJ1ZSwgdHJ1ZSk7XHJcblx0XHRcdFx0dmFyIG1heCA9IGNoZWNrSGFuZGxlUG9zaXRpb24oc2NvcGVfTG9jYXRpb25zLCBpbmRleCwgMTAwLCB0cnVlLCB0cnVlLCB0cnVlKTtcclxuXHJcblx0XHRcdFx0dmFyIG5vdyA9IHBvc2l0aW9uc1tpbmRleF07XHJcblx0XHRcdFx0dmFyIHRleHQgPSBvcHRpb25zLmFyaWFGb3JtYXQudG8odW5lbmNvZGVkW2luZGV4XSk7XHJcblxyXG5cdFx0XHRcdGhhbmRsZS5jaGlsZHJlblswXS5zZXRBdHRyaWJ1dGUoJ2FyaWEtdmFsdWVtaW4nLCBtaW4udG9GaXhlZCgxKSk7XHJcblx0XHRcdFx0aGFuZGxlLmNoaWxkcmVuWzBdLnNldEF0dHJpYnV0ZSgnYXJpYS12YWx1ZW1heCcsIG1heC50b0ZpeGVkKDEpKTtcclxuXHRcdFx0XHRoYW5kbGUuY2hpbGRyZW5bMF0uc2V0QXR0cmlidXRlKCdhcmlhLXZhbHVlbm93Jywgbm93LnRvRml4ZWQoMSkpO1xyXG5cdFx0XHRcdGhhbmRsZS5jaGlsZHJlblswXS5zZXRBdHRyaWJ1dGUoJ2FyaWEtdmFsdWV0ZXh0JywgdGV4dCk7XHJcblx0XHRcdH0pO1xyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gZ2V0R3JvdXAgKCBtb2RlLCB2YWx1ZXMsIHN0ZXBwZWQgKSB7XHJcblxyXG5cdFx0Ly8gVXNlIHRoZSByYW5nZS5cclxuXHRcdGlmICggbW9kZSA9PT0gJ3JhbmdlJyB8fCBtb2RlID09PSAnc3RlcHMnICkge1xyXG5cdFx0XHRyZXR1cm4gc2NvcGVfU3BlY3RydW0ueFZhbDtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIG1vZGUgPT09ICdjb3VudCcgKSB7XHJcblxyXG5cdFx0XHRpZiAoIHZhbHVlcyA8IDIgKSB7XHJcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAndmFsdWVzJyAoPj0gMikgcmVxdWlyZWQgZm9yIG1vZGUgJ2NvdW50Jy5cIik7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIERpdmlkZSAwIC0gMTAwIGluICdjb3VudCcgcGFydHMuXHJcblx0XHRcdHZhciBpbnRlcnZhbCA9IHZhbHVlcyAtIDE7XHJcblx0XHRcdHZhciBzcHJlYWQgPSAoIDEwMCAvIGludGVydmFsICk7XHJcblxyXG5cdFx0XHR2YWx1ZXMgPSBbXTtcclxuXHJcblx0XHRcdC8vIExpc3QgdGhlc2UgcGFydHMgYW5kIGhhdmUgdGhlbSBoYW5kbGVkIGFzICdwb3NpdGlvbnMnLlxyXG5cdFx0XHR3aGlsZSAoIGludGVydmFsLS0gKSB7XHJcblx0XHRcdFx0dmFsdWVzWyBpbnRlcnZhbCBdID0gKCBpbnRlcnZhbCAqIHNwcmVhZCApO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHR2YWx1ZXMucHVzaCgxMDApO1xyXG5cclxuXHRcdFx0bW9kZSA9ICdwb3NpdGlvbnMnO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggbW9kZSA9PT0gJ3Bvc2l0aW9ucycgKSB7XHJcblxyXG5cdFx0XHQvLyBNYXAgYWxsIHBlcmNlbnRhZ2VzIHRvIG9uLXJhbmdlIHZhbHVlcy5cclxuXHRcdFx0cmV0dXJuIHZhbHVlcy5tYXAoZnVuY3Rpb24oIHZhbHVlICl7XHJcblx0XHRcdFx0cmV0dXJuIHNjb3BlX1NwZWN0cnVtLmZyb21TdGVwcGluZyggc3RlcHBlZCA/IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAoIHZhbHVlICkgOiB2YWx1ZSApO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIG1vZGUgPT09ICd2YWx1ZXMnICkge1xyXG5cclxuXHRcdFx0Ly8gSWYgdGhlIHZhbHVlIG11c3QgYmUgc3RlcHBlZCwgaXQgbmVlZHMgdG8gYmUgY29udmVydGVkIHRvIGEgcGVyY2VudGFnZSBmaXJzdC5cclxuXHRcdFx0aWYgKCBzdGVwcGVkICkge1xyXG5cclxuXHRcdFx0XHRyZXR1cm4gdmFsdWVzLm1hcChmdW5jdGlvbiggdmFsdWUgKXtcclxuXHJcblx0XHRcdFx0XHQvLyBDb252ZXJ0IHRvIHBlcmNlbnRhZ2UsIGFwcGx5IHN0ZXAsIHJldHVybiB0byB2YWx1ZS5cclxuXHRcdFx0XHRcdHJldHVybiBzY29wZV9TcGVjdHJ1bS5mcm9tU3RlcHBpbmcoIHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAoIHNjb3BlX1NwZWN0cnVtLnRvU3RlcHBpbmcoIHZhbHVlICkgKSApO1xyXG5cdFx0XHRcdH0pO1xyXG5cclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gT3RoZXJ3aXNlLCB3ZSBjYW4gc2ltcGx5IHVzZSB0aGUgdmFsdWVzLlxyXG5cdFx0XHRyZXR1cm4gdmFsdWVzO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gZ2VuZXJhdGVTcHJlYWQgKCBkZW5zaXR5LCBtb2RlLCBncm91cCApIHtcclxuXHJcblx0XHRmdW5jdGlvbiBzYWZlSW5jcmVtZW50KHZhbHVlLCBpbmNyZW1lbnQpIHtcclxuXHRcdFx0Ly8gQXZvaWQgZmxvYXRpbmcgcG9pbnQgdmFyaWFuY2UgYnkgZHJvcHBpbmcgdGhlIHNtYWxsZXN0IGRlY2ltYWwgcGxhY2VzLlxyXG5cdFx0XHRyZXR1cm4gKHZhbHVlICsgaW5jcmVtZW50KS50b0ZpeGVkKDcpIC8gMTtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgaW5kZXhlcyA9IHt9O1xyXG5cdFx0dmFyIGZpcnN0SW5SYW5nZSA9IHNjb3BlX1NwZWN0cnVtLnhWYWxbMF07XHJcblx0XHR2YXIgbGFzdEluUmFuZ2UgPSBzY29wZV9TcGVjdHJ1bS54VmFsW3Njb3BlX1NwZWN0cnVtLnhWYWwubGVuZ3RoLTFdO1xyXG5cdFx0dmFyIGlnbm9yZUZpcnN0ID0gZmFsc2U7XHJcblx0XHR2YXIgaWdub3JlTGFzdCA9IGZhbHNlO1xyXG5cdFx0dmFyIHByZXZQY3QgPSAwO1xyXG5cclxuXHRcdC8vIENyZWF0ZSBhIGNvcHkgb2YgdGhlIGdyb3VwLCBzb3J0IGl0IGFuZCBmaWx0ZXIgYXdheSBhbGwgZHVwbGljYXRlcy5cclxuXHRcdGdyb3VwID0gdW5pcXVlKGdyb3VwLnNsaWNlKCkuc29ydChmdW5jdGlvbihhLCBiKXsgcmV0dXJuIGEgLSBiOyB9KSk7XHJcblxyXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSByYW5nZSBzdGFydHMgd2l0aCB0aGUgZmlyc3QgZWxlbWVudC5cclxuXHRcdGlmICggZ3JvdXBbMF0gIT09IGZpcnN0SW5SYW5nZSApIHtcclxuXHRcdFx0Z3JvdXAudW5zaGlmdChmaXJzdEluUmFuZ2UpO1xyXG5cdFx0XHRpZ25vcmVGaXJzdCA9IHRydWU7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gTGlrZXdpc2UgZm9yIHRoZSBsYXN0IG9uZS5cclxuXHRcdGlmICggZ3JvdXBbZ3JvdXAubGVuZ3RoIC0gMV0gIT09IGxhc3RJblJhbmdlICkge1xyXG5cdFx0XHRncm91cC5wdXNoKGxhc3RJblJhbmdlKTtcclxuXHRcdFx0aWdub3JlTGFzdCA9IHRydWU7XHJcblx0XHR9XHJcblxyXG5cdFx0Z3JvdXAuZm9yRWFjaChmdW5jdGlvbiAoIGN1cnJlbnQsIGluZGV4ICkge1xyXG5cclxuXHRcdFx0Ly8gR2V0IHRoZSBjdXJyZW50IHN0ZXAgYW5kIHRoZSBsb3dlciArIHVwcGVyIHBvc2l0aW9ucy5cclxuXHRcdFx0dmFyIHN0ZXA7XHJcblx0XHRcdHZhciBpO1xyXG5cdFx0XHR2YXIgcTtcclxuXHRcdFx0dmFyIGxvdyA9IGN1cnJlbnQ7XHJcblx0XHRcdHZhciBoaWdoID0gZ3JvdXBbaW5kZXgrMV07XHJcblx0XHRcdHZhciBuZXdQY3Q7XHJcblx0XHRcdHZhciBwY3REaWZmZXJlbmNlO1xyXG5cdFx0XHR2YXIgcGN0UG9zO1xyXG5cdFx0XHR2YXIgdHlwZTtcclxuXHRcdFx0dmFyIHN0ZXBzO1xyXG5cdFx0XHR2YXIgcmVhbFN0ZXBzO1xyXG5cdFx0XHR2YXIgc3RlcHNpemU7XHJcblxyXG5cdFx0XHQvLyBXaGVuIHVzaW5nICdzdGVwcycgbW9kZSwgdXNlIHRoZSBwcm92aWRlZCBzdGVwcy5cclxuXHRcdFx0Ly8gT3RoZXJ3aXNlLCB3ZSdsbCBzdGVwIG9uIHRvIHRoZSBuZXh0IHN1YnJhbmdlLlxyXG5cdFx0XHRpZiAoIG1vZGUgPT09ICdzdGVwcycgKSB7XHJcblx0XHRcdFx0c3RlcCA9IHNjb3BlX1NwZWN0cnVtLnhOdW1TdGVwc1sgaW5kZXggXTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gRGVmYXVsdCB0byBhICdmdWxsJyBzdGVwLlxyXG5cdFx0XHRpZiAoICFzdGVwICkge1xyXG5cdFx0XHRcdHN0ZXAgPSBoaWdoLWxvdztcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gTG93IGNhbiBiZSAwLCBzbyB0ZXN0IGZvciBmYWxzZS4gSWYgaGlnaCBpcyB1bmRlZmluZWQsXHJcblx0XHRcdC8vIHdlIGFyZSBhdCB0aGUgbGFzdCBzdWJyYW5nZS4gSW5kZXggMCBpcyBhbHJlYWR5IGhhbmRsZWQuXHJcblx0XHRcdGlmICggbG93ID09PSBmYWxzZSB8fCBoaWdoID09PSB1bmRlZmluZWQgKSB7XHJcblx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBNYWtlIHN1cmUgc3RlcCBpc24ndCAwLCB3aGljaCB3b3VsZCBjYXVzZSBhbiBpbmZpbml0ZSBsb29wICgjNjU0KVxyXG5cdFx0XHRzdGVwID0gTWF0aC5tYXgoc3RlcCwgMC4wMDAwMDAxKTtcclxuXHJcblx0XHRcdC8vIEZpbmQgYWxsIHN0ZXBzIGluIHRoZSBzdWJyYW5nZS5cclxuXHRcdFx0Zm9yICggaSA9IGxvdzsgaSA8PSBoaWdoOyBpID0gc2FmZUluY3JlbWVudChpLCBzdGVwKSApIHtcclxuXHJcblx0XHRcdFx0Ly8gR2V0IHRoZSBwZXJjZW50YWdlIHZhbHVlIGZvciB0aGUgY3VycmVudCBzdGVwLFxyXG5cdFx0XHRcdC8vIGNhbGN1bGF0ZSB0aGUgc2l6ZSBmb3IgdGhlIHN1YnJhbmdlLlxyXG5cdFx0XHRcdG5ld1BjdCA9IHNjb3BlX1NwZWN0cnVtLnRvU3RlcHBpbmcoIGkgKTtcclxuXHRcdFx0XHRwY3REaWZmZXJlbmNlID0gbmV3UGN0IC0gcHJldlBjdDtcclxuXHJcblx0XHRcdFx0c3RlcHMgPSBwY3REaWZmZXJlbmNlIC8gZGVuc2l0eTtcclxuXHRcdFx0XHRyZWFsU3RlcHMgPSBNYXRoLnJvdW5kKHN0ZXBzKTtcclxuXHJcblx0XHRcdFx0Ly8gVGhpcyByYXRpbyByZXByZXNlbnRzIHRoZSBhbW91bnQgb2YgcGVyY2VudGFnZS1zcGFjZSBhIHBvaW50IGluZGljYXRlcy5cclxuXHRcdFx0XHQvLyBGb3IgYSBkZW5zaXR5IDEgdGhlIHBvaW50cy9wZXJjZW50YWdlID0gMS4gRm9yIGRlbnNpdHkgMiwgdGhhdCBwZXJjZW50YWdlIG5lZWRzIHRvIGJlIHJlLWRldmlkZWQuXHJcblx0XHRcdFx0Ly8gUm91bmQgdGhlIHBlcmNlbnRhZ2Ugb2Zmc2V0IHRvIGFuIGV2ZW4gbnVtYmVyLCB0aGVuIGRpdmlkZSBieSB0d29cclxuXHRcdFx0XHQvLyB0byBzcHJlYWQgdGhlIG9mZnNldCBvbiBib3RoIHNpZGVzIG9mIHRoZSByYW5nZS5cclxuXHRcdFx0XHRzdGVwc2l6ZSA9IHBjdERpZmZlcmVuY2UvcmVhbFN0ZXBzO1xyXG5cclxuXHRcdFx0XHQvLyBEaXZpZGUgYWxsIHBvaW50cyBldmVubHksIGFkZGluZyB0aGUgY29ycmVjdCBudW1iZXIgdG8gdGhpcyBzdWJyYW5nZS5cclxuXHRcdFx0XHQvLyBSdW4gdXAgdG8gPD0gc28gdGhhdCAxMDAlIGdldHMgYSBwb2ludCwgZXZlbnQgaWYgaWdub3JlTGFzdCBpcyBzZXQuXHJcblx0XHRcdFx0Zm9yICggcSA9IDE7IHEgPD0gcmVhbFN0ZXBzOyBxICs9IDEgKSB7XHJcblxyXG5cdFx0XHRcdFx0Ly8gVGhlIHJhdGlvIGJldHdlZW4gdGhlIHJvdW5kZWQgdmFsdWUgYW5kIHRoZSBhY3R1YWwgc2l6ZSBtaWdodCBiZSB+MSUgb2ZmLlxyXG5cdFx0XHRcdFx0Ly8gQ29ycmVjdCB0aGUgcGVyY2VudGFnZSBvZmZzZXQgYnkgdGhlIG51bWJlciBvZiBwb2ludHNcclxuXHRcdFx0XHRcdC8vIHBlciBzdWJyYW5nZS4gZGVuc2l0eSA9IDEgd2lsbCByZXN1bHQgaW4gMTAwIHBvaW50cyBvbiB0aGVcclxuXHRcdFx0XHRcdC8vIGZ1bGwgcmFuZ2UsIDIgZm9yIDUwLCA0IGZvciAyNSwgZXRjLlxyXG5cdFx0XHRcdFx0cGN0UG9zID0gcHJldlBjdCArICggcSAqIHN0ZXBzaXplICk7XHJcblx0XHRcdFx0XHRpbmRleGVzW3BjdFBvcy50b0ZpeGVkKDUpXSA9IFsneCcsIDBdO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gRGV0ZXJtaW5lIHRoZSBwb2ludCB0eXBlLlxyXG5cdFx0XHRcdHR5cGUgPSAoZ3JvdXAuaW5kZXhPZihpKSA+IC0xKSA/IDEgOiAoIG1vZGUgPT09ICdzdGVwcycgPyAyIDogMCApO1xyXG5cclxuXHRcdFx0XHQvLyBFbmZvcmNlIHRoZSAnaWdub3JlRmlyc3QnIG9wdGlvbiBieSBvdmVyd3JpdGluZyB0aGUgdHlwZSBmb3IgMC5cclxuXHRcdFx0XHRpZiAoICFpbmRleCAmJiBpZ25vcmVGaXJzdCApIHtcclxuXHRcdFx0XHRcdHR5cGUgPSAwO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0aWYgKCAhKGkgPT09IGhpZ2ggJiYgaWdub3JlTGFzdCkpIHtcclxuXHRcdFx0XHRcdC8vIE1hcmsgdGhlICd0eXBlJyBvZiB0aGlzIHBvaW50LiAwID0gcGxhaW4sIDEgPSByZWFsIHZhbHVlLCAyID0gc3RlcCB2YWx1ZS5cclxuXHRcdFx0XHRcdGluZGV4ZXNbbmV3UGN0LnRvRml4ZWQoNSldID0gW2ksIHR5cGVdO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gVXBkYXRlIHRoZSBwZXJjZW50YWdlIGNvdW50LlxyXG5cdFx0XHRcdHByZXZQY3QgPSBuZXdQY3Q7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cclxuXHRcdHJldHVybiBpbmRleGVzO1xyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gYWRkTWFya2luZyAoIHNwcmVhZCwgZmlsdGVyRnVuYywgZm9ybWF0dGVyICkge1xyXG5cclxuXHRcdHZhciBlbGVtZW50ID0gc2NvcGVfRG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XHJcblxyXG5cdFx0dmFyIHZhbHVlU2l6ZUNsYXNzZXMgPSBbXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZU5vcm1hbCxcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLnZhbHVlTGFyZ2UsXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZVN1YlxyXG5cdFx0XTtcclxuXHRcdHZhciBtYXJrZXJTaXplQ2xhc3NlcyA9IFtcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlck5vcm1hbCxcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlckxhcmdlLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyU3ViXHJcblx0XHRdO1xyXG5cdFx0dmFyIHZhbHVlT3JpZW50YXRpb25DbGFzc2VzID0gW1xyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMudmFsdWVIb3Jpem9udGFsLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMudmFsdWVWZXJ0aWNhbFxyXG5cdFx0XTtcclxuXHRcdHZhciBtYXJrZXJPcmllbnRhdGlvbkNsYXNzZXMgPSBbXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy5tYXJrZXJIb3Jpem9udGFsLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyVmVydGljYWxcclxuXHRcdF07XHJcblxyXG5cdFx0YWRkQ2xhc3MoZWxlbWVudCwgb3B0aW9ucy5jc3NDbGFzc2VzLnBpcHMpO1xyXG5cdFx0YWRkQ2xhc3MoZWxlbWVudCwgb3B0aW9ucy5vcnQgPT09IDAgPyBvcHRpb25zLmNzc0NsYXNzZXMucGlwc0hvcml6b250YWwgOiBvcHRpb25zLmNzc0NsYXNzZXMucGlwc1ZlcnRpY2FsKTtcclxuXHJcblx0XHRmdW5jdGlvbiBnZXRDbGFzc2VzKCB0eXBlLCBzb3VyY2UgKXtcclxuXHRcdFx0dmFyIGEgPSBzb3VyY2UgPT09IG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZTtcclxuXHRcdFx0dmFyIG9yaWVudGF0aW9uQ2xhc3NlcyA9IGEgPyB2YWx1ZU9yaWVudGF0aW9uQ2xhc3NlcyA6IG1hcmtlck9yaWVudGF0aW9uQ2xhc3NlcztcclxuXHRcdFx0dmFyIHNpemVDbGFzc2VzID0gYSA/IHZhbHVlU2l6ZUNsYXNzZXMgOiBtYXJrZXJTaXplQ2xhc3NlcztcclxuXHJcblx0XHRcdHJldHVybiBzb3VyY2UgKyAnICcgKyBvcmllbnRhdGlvbkNsYXNzZXNbb3B0aW9ucy5vcnRdICsgJyAnICsgc2l6ZUNsYXNzZXNbdHlwZV07XHJcblx0XHR9XHJcblxyXG5cdFx0ZnVuY3Rpb24gYWRkU3ByZWFkICggb2Zmc2V0LCB2YWx1ZXMgKXtcclxuXHJcblx0XHRcdC8vIEFwcGx5IHRoZSBmaWx0ZXIgZnVuY3Rpb24sIGlmIGl0IGlzIHNldC5cclxuXHRcdFx0dmFsdWVzWzFdID0gKHZhbHVlc1sxXSAmJiBmaWx0ZXJGdW5jKSA/IGZpbHRlckZ1bmModmFsdWVzWzBdLCB2YWx1ZXNbMV0pIDogdmFsdWVzWzFdO1xyXG5cclxuXHRcdFx0Ly8gQWRkIGEgbWFya2VyIGZvciBldmVyeSBwb2ludFxyXG5cdFx0XHR2YXIgbm9kZSA9IGFkZE5vZGVUbyhlbGVtZW50LCBmYWxzZSk7XHJcblx0XHRcdFx0bm9kZS5jbGFzc05hbWUgPSBnZXRDbGFzc2VzKHZhbHVlc1sxXSwgb3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlcik7XHJcblx0XHRcdFx0bm9kZS5zdHlsZVtvcHRpb25zLnN0eWxlXSA9IG9mZnNldCArICclJztcclxuXHJcblx0XHRcdC8vIFZhbHVlcyBhcmUgb25seSBhcHBlbmRlZCBmb3IgcG9pbnRzIG1hcmtlZCAnMScgb3IgJzInLlxyXG5cdFx0XHRpZiAoIHZhbHVlc1sxXSApIHtcclxuXHRcdFx0XHRub2RlID0gYWRkTm9kZVRvKGVsZW1lbnQsIGZhbHNlKTtcclxuXHRcdFx0XHRub2RlLmNsYXNzTmFtZSA9IGdldENsYXNzZXModmFsdWVzWzFdLCBvcHRpb25zLmNzc0NsYXNzZXMudmFsdWUpO1xyXG5cdFx0XHRcdG5vZGUuc2V0QXR0cmlidXRlKCdkYXRhLXZhbHVlJywgdmFsdWVzWzBdKTtcclxuXHRcdFx0XHRub2RlLnN0eWxlW29wdGlvbnMuc3R5bGVdID0gb2Zmc2V0ICsgJyUnO1xyXG5cdFx0XHRcdG5vZGUuaW5uZXJUZXh0ID0gZm9ybWF0dGVyLnRvKHZhbHVlc1swXSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBBcHBlbmQgYWxsIHBvaW50cy5cclxuXHRcdE9iamVjdC5rZXlzKHNwcmVhZCkuZm9yRWFjaChmdW5jdGlvbihhKXtcclxuXHRcdFx0YWRkU3ByZWFkKGEsIHNwcmVhZFthXSk7XHJcblx0XHR9KTtcclxuXHJcblx0XHRyZXR1cm4gZWxlbWVudDtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIHJlbW92ZVBpcHMgKCApIHtcclxuXHRcdGlmICggc2NvcGVfUGlwcyApIHtcclxuXHRcdFx0cmVtb3ZlRWxlbWVudChzY29wZV9QaXBzKTtcclxuXHRcdFx0c2NvcGVfUGlwcyA9IG51bGw7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRmdW5jdGlvbiBwaXBzICggZ3JpZCApIHtcclxuXHJcblx0XHQvLyBGaXggIzY2OVxyXG5cdFx0cmVtb3ZlUGlwcygpO1xyXG5cclxuXHRcdHZhciBtb2RlID0gZ3JpZC5tb2RlO1xyXG5cdFx0dmFyIGRlbnNpdHkgPSBncmlkLmRlbnNpdHkgfHwgMTtcclxuXHRcdHZhciBmaWx0ZXIgPSBncmlkLmZpbHRlciB8fCBmYWxzZTtcclxuXHRcdHZhciB2YWx1ZXMgPSBncmlkLnZhbHVlcyB8fCBmYWxzZTtcclxuXHRcdHZhciBzdGVwcGVkID0gZ3JpZC5zdGVwcGVkIHx8IGZhbHNlO1xyXG5cdFx0dmFyIGdyb3VwID0gZ2V0R3JvdXAoIG1vZGUsIHZhbHVlcywgc3RlcHBlZCApO1xyXG5cdFx0dmFyIHNwcmVhZCA9IGdlbmVyYXRlU3ByZWFkKCBkZW5zaXR5LCBtb2RlLCBncm91cCApO1xyXG5cdFx0dmFyIGZvcm1hdCA9IGdyaWQuZm9ybWF0IHx8IHtcclxuXHRcdFx0dG86IE1hdGgucm91bmRcclxuXHRcdH07XHJcblxyXG5cdFx0c2NvcGVfUGlwcyA9IHNjb3BlX1RhcmdldC5hcHBlbmRDaGlsZChhZGRNYXJraW5nKFxyXG5cdFx0XHRzcHJlYWQsXHJcblx0XHRcdGZpbHRlcixcclxuXHRcdFx0Zm9ybWF0XHJcblx0XHQpKTtcclxuXHJcblx0XHRyZXR1cm4gc2NvcGVfUGlwcztcclxuXHR9XHJcblxyXG4vKiEgSW4gdGhpcyBmaWxlOiBCcm93c2VyIGV2ZW50cyAobm90IHNsaWRlciBldmVudHMgbGlrZSBzbGlkZSwgY2hhbmdlKTsgKi9cclxuXHJcblx0Ly8gU2hvcnRoYW5kIGZvciBiYXNlIGRpbWVuc2lvbnMuXHJcblx0ZnVuY3Rpb24gYmFzZVNpemUgKCApIHtcclxuXHRcdHZhciByZWN0ID0gc2NvcGVfQmFzZS5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTtcclxuXHRcdHZhciBhbHQgPSAnb2Zmc2V0JyArIFsnV2lkdGgnLCAnSGVpZ2h0J11bb3B0aW9ucy5vcnRdO1xyXG5cdFx0cmV0dXJuIG9wdGlvbnMub3J0ID09PSAwID8gKHJlY3Qud2lkdGh8fHNjb3BlX0Jhc2VbYWx0XSkgOiAocmVjdC5oZWlnaHR8fHNjb3BlX0Jhc2VbYWx0XSk7XHJcblx0fVxyXG5cclxuXHQvLyBIYW5kbGVyIGZvciBhdHRhY2hpbmcgZXZlbnRzIHRyb3VnaCBhIHByb3h5LlxyXG5cdGZ1bmN0aW9uIGF0dGFjaEV2ZW50ICggZXZlbnRzLCBlbGVtZW50LCBjYWxsYmFjaywgZGF0YSApIHtcclxuXHJcblx0XHQvLyBUaGlzIGZ1bmN0aW9uIGNhbiBiZSB1c2VkIHRvICdmaWx0ZXInIGV2ZW50cyB0byB0aGUgc2xpZGVyLlxyXG5cdFx0Ly8gZWxlbWVudCBpcyBhIG5vZGUsIG5vdCBhIG5vZGVMaXN0XHJcblxyXG5cdFx0dmFyIG1ldGhvZCA9IGZ1bmN0aW9uICggZSApe1xyXG5cclxuXHRcdFx0ZSA9IGZpeEV2ZW50KGUsIGRhdGEucGFnZU9mZnNldCwgZGF0YS50YXJnZXQgfHwgZWxlbWVudCk7XHJcblxyXG5cdFx0XHQvLyBmaXhFdmVudCByZXR1cm5zIGZhbHNlIGlmIHRoaXMgZXZlbnQgaGFzIGEgZGlmZmVyZW50IHRhcmdldFxyXG5cdFx0XHQvLyB3aGVuIGhhbmRsaW5nIChtdWx0aS0pIHRvdWNoIGV2ZW50cztcclxuXHRcdFx0aWYgKCAhZSApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIGRvTm90UmVqZWN0IGlzIHBhc3NlZCBieSBhbGwgZW5kIGV2ZW50cyB0byBtYWtlIHN1cmUgcmVsZWFzZWQgdG91Y2hlc1xyXG5cdFx0XHQvLyBhcmUgbm90IHJlamVjdGVkLCBsZWF2aW5nIHRoZSBzbGlkZXIgXCJzdHVja1wiIHRvIHRoZSBjdXJzb3I7XHJcblx0XHRcdGlmICggc2NvcGVfVGFyZ2V0Lmhhc0F0dHJpYnV0ZSgnZGlzYWJsZWQnKSAmJiAhZGF0YS5kb05vdFJlamVjdCApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIFN0b3AgaWYgYW4gYWN0aXZlICd0YXAnIHRyYW5zaXRpb24gaXMgdGFraW5nIHBsYWNlLlxyXG5cdFx0XHRpZiAoIGhhc0NsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLnRhcCkgJiYgIWRhdGEuZG9Ob3RSZWplY3QgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBJZ25vcmUgcmlnaHQgb3IgbWlkZGxlIGNsaWNrcyBvbiBzdGFydCAjNDU0XHJcblx0XHRcdGlmICggZXZlbnRzID09PSBhY3Rpb25zLnN0YXJ0ICYmIGUuYnV0dG9ucyAhPT0gdW5kZWZpbmVkICYmIGUuYnV0dG9ucyA+IDEgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBJZ25vcmUgcmlnaHQgb3IgbWlkZGxlIGNsaWNrcyBvbiBzdGFydCAjNDU0XHJcblx0XHRcdGlmICggZGF0YS5ob3ZlciAmJiBlLmJ1dHRvbnMgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyAnc3VwcG9ydHNQYXNzaXZlJyBpcyBvbmx5IHRydWUgaWYgYSBicm93c2VyIGFsc28gc3VwcG9ydHMgdG91Y2gtYWN0aW9uOiBub25lIGluIENTUy5cclxuXHRcdFx0Ly8gaU9TIHNhZmFyaSBkb2VzIG5vdCwgc28gaXQgZG9lc24ndCBnZXQgdG8gYmVuZWZpdCBmcm9tIHBhc3NpdmUgc2Nyb2xsaW5nLiBpT1MgZG9lcyBzdXBwb3J0XHJcblx0XHRcdC8vIHRvdWNoLWFjdGlvbjogbWFuaXB1bGF0aW9uLCBidXQgdGhhdCBhbGxvd3MgcGFubmluZywgd2hpY2ggYnJlYWtzXHJcblx0XHRcdC8vIHNsaWRlcnMgYWZ0ZXIgem9vbWluZy9vbiBub24tcmVzcG9uc2l2ZSBwYWdlcy5cclxuXHRcdFx0Ly8gU2VlOiBodHRwczovL2J1Z3Mud2Via2l0Lm9yZy9zaG93X2J1Zy5jZ2k/aWQ9MTMzMTEyXHJcblx0XHRcdGlmICggIXN1cHBvcnRzUGFzc2l2ZSApIHtcclxuXHRcdFx0XHRlLnByZXZlbnREZWZhdWx0KCk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGUuY2FsY1BvaW50ID0gZS5wb2ludHNbIG9wdGlvbnMub3J0IF07XHJcblxyXG5cdFx0XHQvLyBDYWxsIHRoZSBldmVudCBoYW5kbGVyIHdpdGggdGhlIGV2ZW50IFsgYW5kIGFkZGl0aW9uYWwgZGF0YSBdLlxyXG5cdFx0XHRjYWxsYmFjayAoIGUsIGRhdGEgKTtcclxuXHRcdH07XHJcblxyXG5cdFx0dmFyIG1ldGhvZHMgPSBbXTtcclxuXHJcblx0XHQvLyBCaW5kIGEgY2xvc3VyZSBvbiB0aGUgdGFyZ2V0IGZvciBldmVyeSBldmVudCB0eXBlLlxyXG5cdFx0ZXZlbnRzLnNwbGl0KCcgJykuZm9yRWFjaChmdW5jdGlvbiggZXZlbnROYW1lICl7XHJcblx0XHRcdGVsZW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihldmVudE5hbWUsIG1ldGhvZCwgc3VwcG9ydHNQYXNzaXZlID8geyBwYXNzaXZlOiB0cnVlIH0gOiBmYWxzZSk7XHJcblx0XHRcdG1ldGhvZHMucHVzaChbZXZlbnROYW1lLCBtZXRob2RdKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdHJldHVybiBtZXRob2RzO1xyXG5cdH1cclxuXHJcblx0Ly8gUHJvdmlkZSBhIGNsZWFuIGV2ZW50IHdpdGggc3RhbmRhcmRpemVkIG9mZnNldCB2YWx1ZXMuXHJcblx0ZnVuY3Rpb24gZml4RXZlbnQgKCBlLCBwYWdlT2Zmc2V0LCBldmVudFRhcmdldCApIHtcclxuXHJcblx0XHQvLyBGaWx0ZXIgdGhlIGV2ZW50IHRvIHJlZ2lzdGVyIHRoZSB0eXBlLCB3aGljaCBjYW4gYmVcclxuXHRcdC8vIHRvdWNoLCBtb3VzZSBvciBwb2ludGVyLiBPZmZzZXQgY2hhbmdlcyBuZWVkIHRvIGJlXHJcblx0XHQvLyBtYWRlIG9uIGFuIGV2ZW50IHNwZWNpZmljIGJhc2lzLlxyXG5cdFx0dmFyIHRvdWNoID0gZS50eXBlLmluZGV4T2YoJ3RvdWNoJykgPT09IDA7XHJcblx0XHR2YXIgbW91c2UgPSBlLnR5cGUuaW5kZXhPZignbW91c2UnKSA9PT0gMDtcclxuXHRcdHZhciBwb2ludGVyID0gZS50eXBlLmluZGV4T2YoJ3BvaW50ZXInKSA9PT0gMDtcclxuXHJcblx0XHR2YXIgeDtcclxuXHRcdHZhciB5O1xyXG5cclxuXHRcdC8vIElFMTAgaW1wbGVtZW50ZWQgcG9pbnRlciBldmVudHMgd2l0aCBhIHByZWZpeDtcclxuXHRcdGlmICggZS50eXBlLmluZGV4T2YoJ01TUG9pbnRlcicpID09PSAwICkge1xyXG5cdFx0XHRwb2ludGVyID0gdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJbiB0aGUgZXZlbnQgdGhhdCBtdWx0aXRvdWNoIGlzIGFjdGl2YXRlZCwgdGhlIG9ubHkgdGhpbmcgb25lIGhhbmRsZSBzaG91bGQgYmUgY29uY2VybmVkXHJcblx0XHQvLyBhYm91dCBpcyB0aGUgdG91Y2hlcyB0aGF0IG9yaWdpbmF0ZWQgb24gdG9wIG9mIGl0LlxyXG5cdFx0aWYgKCB0b3VjaCApIHtcclxuXHJcblx0XHRcdC8vIFJldHVybnMgdHJ1ZSBpZiBhIHRvdWNoIG9yaWdpbmF0ZWQgb24gdGhlIHRhcmdldC5cclxuXHRcdFx0dmFyIGlzVG91Y2hPblRhcmdldCA9IGZ1bmN0aW9uIChjaGVja1RvdWNoKSB7XHJcblx0XHRcdFx0cmV0dXJuIGNoZWNrVG91Y2gudGFyZ2V0ID09PSBldmVudFRhcmdldCB8fCBldmVudFRhcmdldC5jb250YWlucyhjaGVja1RvdWNoLnRhcmdldCk7XHJcblx0XHRcdH07XHJcblxyXG5cdFx0XHQvLyBJbiB0aGUgY2FzZSBvZiB0b3VjaHN0YXJ0IGV2ZW50cywgd2UgbmVlZCB0byBtYWtlIHN1cmUgdGhlcmUgaXMgc3RpbGwgbm8gbW9yZSB0aGFuIG9uZVxyXG5cdFx0XHQvLyB0b3VjaCBvbiB0aGUgdGFyZ2V0IHNvIHdlIGxvb2sgYW1vbmdzdCBhbGwgdG91Y2hlcy5cclxuXHRcdFx0aWYgKGUudHlwZSA9PT0gJ3RvdWNoc3RhcnQnKSB7XHJcblxyXG5cdFx0XHRcdHZhciB0YXJnZXRUb3VjaGVzID0gQXJyYXkucHJvdG90eXBlLmZpbHRlci5jYWxsKGUudG91Y2hlcywgaXNUb3VjaE9uVGFyZ2V0KTtcclxuXHJcblx0XHRcdFx0Ly8gRG8gbm90IHN1cHBvcnQgbW9yZSB0aGFuIG9uZSB0b3VjaCBwZXIgaGFuZGxlLlxyXG5cdFx0XHRcdGlmICggdGFyZ2V0VG91Y2hlcy5sZW5ndGggPiAxICkge1xyXG5cdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0eCA9IHRhcmdldFRvdWNoZXNbMF0ucGFnZVg7XHJcblx0XHRcdFx0eSA9IHRhcmdldFRvdWNoZXNbMF0ucGFnZVk7XHJcblxyXG5cdFx0XHR9IGVsc2Uge1xyXG5cclxuXHRcdFx0XHQvLyBJbiB0aGUgb3RoZXIgY2FzZXMsIGZpbmQgb24gY2hhbmdlZFRvdWNoZXMgaXMgZW5vdWdoLlxyXG5cdFx0XHRcdHZhciB0YXJnZXRUb3VjaCA9IEFycmF5LnByb3RvdHlwZS5maW5kLmNhbGwoZS5jaGFuZ2VkVG91Y2hlcywgaXNUb3VjaE9uVGFyZ2V0KTtcclxuXHJcblx0XHRcdFx0Ly8gQ2FuY2VsIGlmIHRoZSB0YXJnZXQgdG91Y2ggaGFzIG5vdCBtb3ZlZC5cclxuXHRcdFx0XHRpZiAoICF0YXJnZXRUb3VjaCApIHtcclxuXHRcdFx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdHggPSB0YXJnZXRUb3VjaC5wYWdlWDtcclxuXHRcdFx0XHR5ID0gdGFyZ2V0VG91Y2gucGFnZVk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRwYWdlT2Zmc2V0ID0gcGFnZU9mZnNldCB8fCBnZXRQYWdlT2Zmc2V0KHNjb3BlX0RvY3VtZW50KTtcclxuXHJcblx0XHRpZiAoIG1vdXNlIHx8IHBvaW50ZXIgKSB7XHJcblx0XHRcdHggPSBlLmNsaWVudFggKyBwYWdlT2Zmc2V0Lng7XHJcblx0XHRcdHkgPSBlLmNsaWVudFkgKyBwYWdlT2Zmc2V0Lnk7XHJcblx0XHR9XHJcblxyXG5cdFx0ZS5wYWdlT2Zmc2V0ID0gcGFnZU9mZnNldDtcclxuXHRcdGUucG9pbnRzID0gW3gsIHldO1xyXG5cdFx0ZS5jdXJzb3IgPSBtb3VzZSB8fCBwb2ludGVyOyAvLyBGaXggIzQzNVxyXG5cclxuXHRcdHJldHVybiBlO1xyXG5cdH1cclxuXHJcblx0Ly8gVHJhbnNsYXRlIGEgY29vcmRpbmF0ZSBpbiB0aGUgZG9jdW1lbnQgdG8gYSBwZXJjZW50YWdlIG9uIHRoZSBzbGlkZXJcclxuXHRmdW5jdGlvbiBjYWxjUG9pbnRUb1BlcmNlbnRhZ2UgKCBjYWxjUG9pbnQgKSB7XHJcblx0XHR2YXIgbG9jYXRpb24gPSBjYWxjUG9pbnQgLSBvZmZzZXQoc2NvcGVfQmFzZSwgb3B0aW9ucy5vcnQpO1xyXG5cdFx0dmFyIHByb3Bvc2FsID0gKCBsb2NhdGlvbiAqIDEwMCApIC8gYmFzZVNpemUoKTtcclxuXHJcblx0XHQvLyBDbGFtcCBwcm9wb3NhbCBiZXR3ZWVuIDAlIGFuZCAxMDAlXHJcblx0XHQvLyBPdXQtb2YtYm91bmQgY29vcmRpbmF0ZXMgbWF5IG9jY3VyIHdoZW4gLm5vVWktYmFzZSBwc2V1ZG8tZWxlbWVudHNcclxuXHRcdC8vIGFyZSB1c2VkIChlLmcuIGNvbnRhaW5lZCBoYW5kbGVzIGZlYXR1cmUpXHJcblx0XHRwcm9wb3NhbCA9IGxpbWl0KHByb3Bvc2FsKTtcclxuXHJcblx0XHRyZXR1cm4gb3B0aW9ucy5kaXIgPyAxMDAgLSBwcm9wb3NhbCA6IHByb3Bvc2FsO1xyXG5cdH1cclxuXHJcblx0Ly8gRmluZCBoYW5kbGUgY2xvc2VzdCB0byBhIGNlcnRhaW4gcGVyY2VudGFnZSBvbiB0aGUgc2xpZGVyXHJcblx0ZnVuY3Rpb24gZ2V0Q2xvc2VzdEhhbmRsZSAoIHByb3Bvc2FsICkge1xyXG5cclxuXHRcdHZhciBjbG9zZXN0ID0gMTAwO1xyXG5cdFx0dmFyIGhhbmRsZU51bWJlciA9IGZhbHNlO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZXMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGUsIGluZGV4KXtcclxuXHJcblx0XHRcdC8vIERpc2FibGVkIGhhbmRsZXMgYXJlIGlnbm9yZWRcclxuXHRcdFx0aWYgKCBoYW5kbGUuaGFzQXR0cmlidXRlKCdkaXNhYmxlZCcpICkge1xyXG5cdFx0XHRcdHJldHVybjtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0dmFyIHBvcyA9IE1hdGguYWJzKHNjb3BlX0xvY2F0aW9uc1tpbmRleF0gLSBwcm9wb3NhbCk7XHJcblxyXG5cdFx0XHRpZiAoIHBvcyA8IGNsb3Nlc3QgfHwgKHBvcyA9PT0gMTAwICYmIGNsb3Nlc3QgPT09IDEwMCkgKSB7XHJcblx0XHRcdFx0aGFuZGxlTnVtYmVyID0gaW5kZXg7XHJcblx0XHRcdFx0Y2xvc2VzdCA9IHBvcztcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0cmV0dXJuIGhhbmRsZU51bWJlcjtcclxuXHR9XHJcblxyXG5cdC8vIEZpcmUgJ2VuZCcgd2hlbiBhIG1vdXNlIG9yIHBlbiBsZWF2ZXMgdGhlIGRvY3VtZW50LlxyXG5cdGZ1bmN0aW9uIGRvY3VtZW50TGVhdmUgKCBldmVudCwgZGF0YSApIHtcclxuXHRcdGlmICggZXZlbnQudHlwZSA9PT0gXCJtb3VzZW91dFwiICYmIGV2ZW50LnRhcmdldC5ub2RlTmFtZSA9PT0gXCJIVE1MXCIgJiYgZXZlbnQucmVsYXRlZFRhcmdldCA9PT0gbnVsbCApe1xyXG5cdFx0XHRldmVudEVuZCAoZXZlbnQsIGRhdGEpO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0Ly8gSGFuZGxlIG1vdmVtZW50IG9uIGRvY3VtZW50IGZvciBoYW5kbGUgYW5kIHJhbmdlIGRyYWcuXHJcblx0ZnVuY3Rpb24gZXZlbnRNb3ZlICggZXZlbnQsIGRhdGEgKSB7XHJcblxyXG5cdFx0Ly8gRml4ICM0OThcclxuXHRcdC8vIENoZWNrIHZhbHVlIG9mIC5idXR0b25zIGluICdzdGFydCcgdG8gd29yayBhcm91bmQgYSBidWcgaW4gSUUxMCBtb2JpbGUgKGRhdGEuYnV0dG9uc1Byb3BlcnR5KS5cclxuXHRcdC8vIGh0dHBzOi8vY29ubmVjdC5taWNyb3NvZnQuY29tL0lFL2ZlZWRiYWNrL2RldGFpbHMvOTI3MDA1L21vYmlsZS1pZTEwLXdpbmRvd3MtcGhvbmUtYnV0dG9ucy1wcm9wZXJ0eS1vZi1wb2ludGVybW92ZS1ldmVudC1hbHdheXMtemVyb1xyXG5cdFx0Ly8gSUU5IGhhcyAuYnV0dG9ucyBhbmQgLndoaWNoIHplcm8gb24gbW91c2Vtb3ZlLlxyXG5cdFx0Ly8gRmlyZWZveCBicmVha3MgdGhlIHNwZWMgTUROIGRlZmluZXMuXHJcblx0XHRpZiAoIG5hdmlnYXRvci5hcHBWZXJzaW9uLmluZGV4T2YoXCJNU0lFIDlcIikgPT09IC0xICYmIGV2ZW50LmJ1dHRvbnMgPT09IDAgJiYgZGF0YS5idXR0b25zUHJvcGVydHkgIT09IDAgKSB7XHJcblx0XHRcdHJldHVybiBldmVudEVuZChldmVudCwgZGF0YSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQ2hlY2sgaWYgd2UgYXJlIG1vdmluZyB1cCBvciBkb3duXHJcblx0XHR2YXIgbW92ZW1lbnQgPSAob3B0aW9ucy5kaXIgPyAtMSA6IDEpICogKGV2ZW50LmNhbGNQb2ludCAtIGRhdGEuc3RhcnRDYWxjUG9pbnQpO1xyXG5cclxuXHRcdC8vIENvbnZlcnQgdGhlIG1vdmVtZW50IGludG8gYSBwZXJjZW50YWdlIG9mIHRoZSBzbGlkZXIgd2lkdGgvaGVpZ2h0XHJcblx0XHR2YXIgcHJvcG9zYWwgPSAobW92ZW1lbnQgKiAxMDApIC8gZGF0YS5iYXNlU2l6ZTtcclxuXHJcblx0XHRtb3ZlSGFuZGxlcyhtb3ZlbWVudCA+IDAsIHByb3Bvc2FsLCBkYXRhLmxvY2F0aW9ucywgZGF0YS5oYW5kbGVOdW1iZXJzKTtcclxuXHR9XHJcblxyXG5cdC8vIFVuYmluZCBtb3ZlIGV2ZW50cyBvbiBkb2N1bWVudCwgY2FsbCBjYWxsYmFja3MuXHJcblx0ZnVuY3Rpb24gZXZlbnRFbmQgKCBldmVudCwgZGF0YSApIHtcclxuXHJcblx0XHQvLyBUaGUgaGFuZGxlIGlzIG5vIGxvbmdlciBhY3RpdmUsIHNvIHJlbW92ZSB0aGUgY2xhc3MuXHJcblx0XHRpZiAoIGRhdGEuaGFuZGxlICkge1xyXG5cdFx0XHRyZW1vdmVDbGFzcyhkYXRhLmhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmFjdGl2ZSk7XHJcblx0XHRcdHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCAtPSAxO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFVuYmluZCB0aGUgbW92ZSBhbmQgZW5kIGV2ZW50cywgd2hpY2ggYXJlIGFkZGVkIG9uICdzdGFydCcuXHJcblx0XHRkYXRhLmxpc3RlbmVycy5mb3JFYWNoKGZ1bmN0aW9uKCBjICkge1xyXG5cdFx0XHRzY29wZV9Eb2N1bWVudEVsZW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcihjWzBdLCBjWzFdKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdGlmICggc2NvcGVfQWN0aXZlSGFuZGxlc0NvdW50ID09PSAwICkge1xyXG5cdFx0XHQvLyBSZW1vdmUgZHJhZ2dpbmcgY2xhc3MuXHJcblx0XHRcdHJlbW92ZUNsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmRyYWcpO1xyXG5cdFx0XHRzZXRaaW5kZXgoKTtcclxuXHJcblx0XHRcdC8vIFJlbW92ZSBjdXJzb3Igc3R5bGVzIGFuZCB0ZXh0LXNlbGVjdGlvbiBldmVudHMgYm91bmQgdG8gdGhlIGJvZHkuXHJcblx0XHRcdGlmICggZXZlbnQuY3Vyc29yICkge1xyXG5cdFx0XHRcdHNjb3BlX0JvZHkuc3R5bGUuY3Vyc29yID0gJyc7XHJcblx0XHRcdFx0c2NvcGVfQm9keS5yZW1vdmVFdmVudExpc3RlbmVyKCdzZWxlY3RzdGFydCcsIHByZXZlbnREZWZhdWx0KTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdGRhdGEuaGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdGZpcmVFdmVudCgnY2hhbmdlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0ZmlyZUV2ZW50KCdzZXQnLCBoYW5kbGVOdW1iZXIpO1xyXG5cdFx0XHRmaXJlRXZlbnQoJ2VuZCcsIGhhbmRsZU51bWJlcik7XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cdC8vIEJpbmQgbW92ZSBldmVudHMgb24gZG9jdW1lbnQuXHJcblx0ZnVuY3Rpb24gZXZlbnRTdGFydCAoIGV2ZW50LCBkYXRhICkge1xyXG5cclxuXHRcdHZhciBoYW5kbGU7XHJcblx0XHRpZiAoIGRhdGEuaGFuZGxlTnVtYmVycy5sZW5ndGggPT09IDEgKSB7XHJcblxyXG5cdFx0XHR2YXIgaGFuZGxlT3JpZ2luID0gc2NvcGVfSGFuZGxlc1tkYXRhLmhhbmRsZU51bWJlcnNbMF1dO1xyXG5cclxuXHRcdFx0Ly8gSWdub3JlICdkaXNhYmxlZCcgaGFuZGxlc1xyXG5cdFx0XHRpZiAoIGhhbmRsZU9yaWdpbi5oYXNBdHRyaWJ1dGUoJ2Rpc2FibGVkJykgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRoYW5kbGUgPSBoYW5kbGVPcmlnaW4uY2hpbGRyZW5bMF07XHJcblx0XHRcdHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCArPSAxO1xyXG5cclxuXHRcdFx0Ly8gTWFyayB0aGUgaGFuZGxlIGFzICdhY3RpdmUnIHNvIGl0IGNhbiBiZSBzdHlsZWQuXHJcblx0XHRcdGFkZENsYXNzKGhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmFjdGl2ZSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQSBkcmFnIHNob3VsZCBuZXZlciBwcm9wYWdhdGUgdXAgdG8gdGhlICd0YXAnIGV2ZW50LlxyXG5cdFx0ZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XHJcblxyXG5cdFx0Ly8gUmVjb3JkIHRoZSBldmVudCBsaXN0ZW5lcnMuXHJcblx0XHR2YXIgbGlzdGVuZXJzID0gW107XHJcblxyXG5cdFx0Ly8gQXR0YWNoIHRoZSBtb3ZlIGFuZCBlbmQgZXZlbnRzLlxyXG5cdFx0dmFyIG1vdmVFdmVudCA9IGF0dGFjaEV2ZW50KGFjdGlvbnMubW92ZSwgc2NvcGVfRG9jdW1lbnRFbGVtZW50LCBldmVudE1vdmUsIHtcclxuXHRcdFx0Ly8gVGhlIGV2ZW50IHRhcmdldCBoYXMgY2hhbmdlZCBzbyB3ZSBuZWVkIHRvIHByb3BhZ2F0ZSB0aGUgb3JpZ2luYWwgb25lIHNvIHRoYXQgd2Uga2VlcFxyXG5cdFx0XHQvLyByZWx5aW5nIG9uIGl0IHRvIGV4dHJhY3QgdGFyZ2V0IHRvdWNoZXMuXHJcblx0XHRcdHRhcmdldDogZXZlbnQudGFyZ2V0LFxyXG5cdFx0XHRoYW5kbGU6IGhhbmRsZSxcclxuXHRcdFx0bGlzdGVuZXJzOiBsaXN0ZW5lcnMsXHJcblx0XHRcdHN0YXJ0Q2FsY1BvaW50OiBldmVudC5jYWxjUG9pbnQsXHJcblx0XHRcdGJhc2VTaXplOiBiYXNlU2l6ZSgpLFxyXG5cdFx0XHRwYWdlT2Zmc2V0OiBldmVudC5wYWdlT2Zmc2V0LFxyXG5cdFx0XHRoYW5kbGVOdW1iZXJzOiBkYXRhLmhhbmRsZU51bWJlcnMsXHJcblx0XHRcdGJ1dHRvbnNQcm9wZXJ0eTogZXZlbnQuYnV0dG9ucyxcclxuXHRcdFx0bG9jYXRpb25zOiBzY29wZV9Mb2NhdGlvbnMuc2xpY2UoKVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0dmFyIGVuZEV2ZW50ID0gYXR0YWNoRXZlbnQoYWN0aW9ucy5lbmQsIHNjb3BlX0RvY3VtZW50RWxlbWVudCwgZXZlbnRFbmQsIHtcclxuXHRcdFx0dGFyZ2V0OiBldmVudC50YXJnZXQsXHJcblx0XHRcdGhhbmRsZTogaGFuZGxlLFxyXG5cdFx0XHRsaXN0ZW5lcnM6IGxpc3RlbmVycyxcclxuXHRcdFx0ZG9Ob3RSZWplY3Q6IHRydWUsXHJcblx0XHRcdGhhbmRsZU51bWJlcnM6IGRhdGEuaGFuZGxlTnVtYmVyc1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0dmFyIG91dEV2ZW50ID0gYXR0YWNoRXZlbnQoXCJtb3VzZW91dFwiLCBzY29wZV9Eb2N1bWVudEVsZW1lbnQsIGRvY3VtZW50TGVhdmUsIHtcclxuXHRcdFx0dGFyZ2V0OiBldmVudC50YXJnZXQsXHJcblx0XHRcdGhhbmRsZTogaGFuZGxlLFxyXG5cdFx0XHRsaXN0ZW5lcnM6IGxpc3RlbmVycyxcclxuXHRcdFx0ZG9Ob3RSZWplY3Q6IHRydWUsXHJcblx0XHRcdGhhbmRsZU51bWJlcnM6IGRhdGEuaGFuZGxlTnVtYmVyc1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gV2Ugd2FudCB0byBtYWtlIHN1cmUgd2UgcHVzaGVkIHRoZSBsaXN0ZW5lcnMgaW4gdGhlIGxpc3RlbmVyIGxpc3QgcmF0aGVyIHRoYW4gY3JlYXRpbmdcclxuXHRcdC8vIGEgbmV3IG9uZSBhcyBpdCBoYXMgYWxyZWFkeSBiZWVuIHBhc3NlZCB0byB0aGUgZXZlbnQgaGFuZGxlcnMuXHJcblx0XHRsaXN0ZW5lcnMucHVzaC5hcHBseShsaXN0ZW5lcnMsIG1vdmVFdmVudC5jb25jYXQoZW5kRXZlbnQsIG91dEV2ZW50KSk7XHJcblxyXG5cdFx0Ly8gVGV4dCBzZWxlY3Rpb24gaXNuJ3QgYW4gaXNzdWUgb24gdG91Y2ggZGV2aWNlcyxcclxuXHRcdC8vIHNvIGFkZGluZyBjdXJzb3Igc3R5bGVzIGNhbiBiZSBza2lwcGVkLlxyXG5cdFx0aWYgKCBldmVudC5jdXJzb3IgKSB7XHJcblxyXG5cdFx0XHQvLyBQcmV2ZW50IHRoZSAnSScgY3Vyc29yIGFuZCBleHRlbmQgdGhlIHJhbmdlLWRyYWcgY3Vyc29yLlxyXG5cdFx0XHRzY29wZV9Cb2R5LnN0eWxlLmN1cnNvciA9IGdldENvbXB1dGVkU3R5bGUoZXZlbnQudGFyZ2V0KS5jdXJzb3I7XHJcblxyXG5cdFx0XHQvLyBNYXJrIHRoZSB0YXJnZXQgd2l0aCBhIGRyYWdnaW5nIHN0YXRlLlxyXG5cdFx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSApIHtcclxuXHRcdFx0XHRhZGRDbGFzcyhzY29wZV9UYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5kcmFnKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gUHJldmVudCB0ZXh0IHNlbGVjdGlvbiB3aGVuIGRyYWdnaW5nIHRoZSBoYW5kbGVzLlxyXG5cdFx0XHQvLyBJbiBub1VpU2xpZGVyIDw9IDkuMi4wLCB0aGlzIHdhcyBoYW5kbGVkIGJ5IGNhbGxpbmcgcHJldmVudERlZmF1bHQgb24gbW91c2UvdG91Y2ggc3RhcnQvbW92ZSxcclxuXHRcdFx0Ly8gd2hpY2ggaXMgc2Nyb2xsIGJsb2NraW5nLiBUaGUgc2VsZWN0c3RhcnQgZXZlbnQgaXMgc3VwcG9ydGVkIGJ5IEZpcmVGb3ggc3RhcnRpbmcgZnJvbSB2ZXJzaW9uIDUyLFxyXG5cdFx0XHQvLyBtZWFuaW5nIHRoZSBvbmx5IGhvbGRvdXQgaXMgaU9TIFNhZmFyaS4gVGhpcyBkb2Vzbid0IG1hdHRlcjogdGV4dCBzZWxlY3Rpb24gaXNuJ3QgdHJpZ2dlcmVkIHRoZXJlLlxyXG5cdFx0XHQvLyBUaGUgJ2N1cnNvcicgZmxhZyBpcyBmYWxzZS5cclxuXHRcdFx0Ly8gU2VlOiBodHRwOi8vY2FuaXVzZS5jb20vI3NlYXJjaD1zZWxlY3RzdGFydFxyXG5cdFx0XHRzY29wZV9Cb2R5LmFkZEV2ZW50TGlzdGVuZXIoJ3NlbGVjdHN0YXJ0JywgcHJldmVudERlZmF1bHQsIGZhbHNlKTtcclxuXHRcdH1cclxuXHJcblx0XHRkYXRhLmhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRmaXJlRXZlbnQoJ3N0YXJ0JywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gTW92ZSBjbG9zZXN0IGhhbmRsZSB0byB0YXBwZWQgbG9jYXRpb24uXHJcblx0ZnVuY3Rpb24gZXZlbnRUYXAgKCBldmVudCApIHtcclxuXHJcblx0XHQvLyBUaGUgdGFwIGV2ZW50IHNob3VsZG4ndCBwcm9wYWdhdGUgdXBcclxuXHRcdGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbCA9IGNhbGNQb2ludFRvUGVyY2VudGFnZShldmVudC5jYWxjUG9pbnQpO1xyXG5cdFx0dmFyIGhhbmRsZU51bWJlciA9IGdldENsb3Nlc3RIYW5kbGUocHJvcG9zYWwpO1xyXG5cclxuXHRcdC8vIFRhY2tsZSB0aGUgY2FzZSB0aGF0IGFsbCBoYW5kbGVzIGFyZSAnZGlzYWJsZWQnLlxyXG5cdFx0aWYgKCBoYW5kbGVOdW1iZXIgPT09IGZhbHNlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gRmxhZyB0aGUgc2xpZGVyIGFzIGl0IGlzIG5vdyBpbiBhIHRyYW5zaXRpb25hbCBzdGF0ZS5cclxuXHRcdC8vIFRyYW5zaXRpb24gdGFrZXMgYSBjb25maWd1cmFibGUgYW1vdW50IG9mIG1zIChkZWZhdWx0IDMwMCkuIFJlLWVuYWJsZSB0aGUgc2xpZGVyIGFmdGVyIHRoYXQuXHJcblx0XHRpZiAoICFvcHRpb25zLmV2ZW50cy5zbmFwICkge1xyXG5cdFx0XHRhZGRDbGFzc0ZvcihzY29wZV9UYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50YXAsIG9wdGlvbnMuYW5pbWF0aW9uRHVyYXRpb24pO1xyXG5cdFx0fVxyXG5cclxuXHRcdHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIHByb3Bvc2FsLCB0cnVlLCB0cnVlKTtcclxuXHJcblx0XHRzZXRaaW5kZXgoKTtcclxuXHJcblx0XHRmaXJlRXZlbnQoJ3NsaWRlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgndXBkYXRlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgnY2hhbmdlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgnc2V0JywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHJcblx0XHRpZiAoIG9wdGlvbnMuZXZlbnRzLnNuYXAgKSB7XHJcblx0XHRcdGV2ZW50U3RhcnQoZXZlbnQsIHsgaGFuZGxlTnVtYmVyczogW2hhbmRsZU51bWJlcl0gfSk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQvLyBGaXJlcyBhICdob3ZlcicgZXZlbnQgZm9yIGEgaG92ZXJlZCBtb3VzZS9wZW4gcG9zaXRpb24uXHJcblx0ZnVuY3Rpb24gZXZlbnRIb3ZlciAoIGV2ZW50ICkge1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbCA9IGNhbGNQb2ludFRvUGVyY2VudGFnZShldmVudC5jYWxjUG9pbnQpO1xyXG5cclxuXHRcdHZhciB0byA9IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAocHJvcG9zYWwpO1xyXG5cdFx0dmFyIHZhbHVlID0gc2NvcGVfU3BlY3RydW0uZnJvbVN0ZXBwaW5nKHRvKTtcclxuXHJcblx0XHRPYmplY3Qua2V5cyhzY29wZV9FdmVudHMpLmZvckVhY2goZnVuY3Rpb24oIHRhcmdldEV2ZW50ICkge1xyXG5cdFx0XHRpZiAoICdob3ZlcicgPT09IHRhcmdldEV2ZW50LnNwbGl0KCcuJylbMF0gKSB7XHJcblx0XHRcdFx0c2NvcGVfRXZlbnRzW3RhcmdldEV2ZW50XS5mb3JFYWNoKGZ1bmN0aW9uKCBjYWxsYmFjayApIHtcclxuXHRcdFx0XHRcdGNhbGxiYWNrLmNhbGwoIHNjb3BlX1NlbGYsIHZhbHVlICk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gQXR0YWNoIGV2ZW50cyB0byBzZXZlcmFsIHNsaWRlciBwYXJ0cy5cclxuXHRmdW5jdGlvbiBiaW5kU2xpZGVyRXZlbnRzICggYmVoYXZpb3VyICkge1xyXG5cclxuXHRcdC8vIEF0dGFjaCB0aGUgc3RhbmRhcmQgZHJhZyBldmVudCB0byB0aGUgaGFuZGxlcy5cclxuXHRcdGlmICggIWJlaGF2aW91ci5maXhlZCApIHtcclxuXHJcblx0XHRcdHNjb3BlX0hhbmRsZXMuZm9yRWFjaChmdW5jdGlvbiggaGFuZGxlLCBpbmRleCApe1xyXG5cclxuXHRcdFx0XHQvLyBUaGVzZSBldmVudHMgYXJlIG9ubHkgYm91bmQgdG8gdGhlIHZpc3VhbCBoYW5kbGVcclxuXHRcdFx0XHQvLyBlbGVtZW50LCBub3QgdGhlICdyZWFsJyBvcmlnaW4gZWxlbWVudC5cclxuXHRcdFx0XHRhdHRhY2hFdmVudCAoIGFjdGlvbnMuc3RhcnQsIGhhbmRsZS5jaGlsZHJlblswXSwgZXZlbnRTdGFydCwge1xyXG5cdFx0XHRcdFx0aGFuZGxlTnVtYmVyczogW2luZGV4XVxyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBBdHRhY2ggdGhlIHRhcCBldmVudCB0byB0aGUgc2xpZGVyIGJhc2UuXHJcblx0XHRpZiAoIGJlaGF2aW91ci50YXAgKSB7XHJcblx0XHRcdGF0dGFjaEV2ZW50IChhY3Rpb25zLnN0YXJ0LCBzY29wZV9CYXNlLCBldmVudFRhcCwge30pO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEZpcmUgaG92ZXIgZXZlbnRzXHJcblx0XHRpZiAoIGJlaGF2aW91ci5ob3ZlciApIHtcclxuXHRcdFx0YXR0YWNoRXZlbnQgKGFjdGlvbnMubW92ZSwgc2NvcGVfQmFzZSwgZXZlbnRIb3ZlciwgeyBob3ZlcjogdHJ1ZSB9KTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBNYWtlIHRoZSByYW5nZSBkcmFnZ2FibGUuXHJcblx0XHRpZiAoIGJlaGF2aW91ci5kcmFnICl7XHJcblxyXG5cdFx0XHRzY29wZV9Db25uZWN0cy5mb3JFYWNoKGZ1bmN0aW9uKCBjb25uZWN0LCBpbmRleCApe1xyXG5cclxuXHRcdFx0XHRpZiAoIGNvbm5lY3QgPT09IGZhbHNlIHx8IGluZGV4ID09PSAwIHx8IGluZGV4ID09PSBzY29wZV9Db25uZWN0cy5sZW5ndGggLSAxICkge1xyXG5cdFx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0dmFyIGhhbmRsZUJlZm9yZSA9IHNjb3BlX0hhbmRsZXNbaW5kZXggLSAxXTtcclxuXHRcdFx0XHR2YXIgaGFuZGxlQWZ0ZXIgPSBzY29wZV9IYW5kbGVzW2luZGV4XTtcclxuXHRcdFx0XHR2YXIgZXZlbnRIb2xkZXJzID0gW2Nvbm5lY3RdO1xyXG5cclxuXHRcdFx0XHRhZGRDbGFzcyhjb25uZWN0LCBvcHRpb25zLmNzc0NsYXNzZXMuZHJhZ2dhYmxlKTtcclxuXHJcblx0XHRcdFx0Ly8gV2hlbiB0aGUgcmFuZ2UgaXMgZml4ZWQsIHRoZSBlbnRpcmUgcmFuZ2UgY2FuXHJcblx0XHRcdFx0Ly8gYmUgZHJhZ2dlZCBieSB0aGUgaGFuZGxlcy4gVGhlIGhhbmRsZSBpbiB0aGUgZmlyc3RcclxuXHRcdFx0XHQvLyBvcmlnaW4gd2lsbCBwcm9wYWdhdGUgdGhlIHN0YXJ0IGV2ZW50IHVwd2FyZCxcclxuXHRcdFx0XHQvLyBidXQgaXQgbmVlZHMgdG8gYmUgYm91bmQgbWFudWFsbHkgb24gdGhlIG90aGVyLlxyXG5cdFx0XHRcdGlmICggYmVoYXZpb3VyLmZpeGVkICkge1xyXG5cdFx0XHRcdFx0ZXZlbnRIb2xkZXJzLnB1c2goaGFuZGxlQmVmb3JlLmNoaWxkcmVuWzBdKTtcclxuXHRcdFx0XHRcdGV2ZW50SG9sZGVycy5wdXNoKGhhbmRsZUFmdGVyLmNoaWxkcmVuWzBdKTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdGV2ZW50SG9sZGVycy5mb3JFYWNoKGZ1bmN0aW9uKCBldmVudEhvbGRlciApIHtcclxuXHRcdFx0XHRcdGF0dGFjaEV2ZW50ICggYWN0aW9ucy5zdGFydCwgZXZlbnRIb2xkZXIsIGV2ZW50U3RhcnQsIHtcclxuXHRcdFx0XHRcdFx0aGFuZGxlczogW2hhbmRsZUJlZm9yZSwgaGFuZGxlQWZ0ZXJdLFxyXG5cdFx0XHRcdFx0XHRoYW5kbGVOdW1iZXJzOiBbaW5kZXggLSAxLCBpbmRleF1cclxuXHRcdFx0XHRcdH0pO1xyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG4vKiEgSW4gdGhpcyBmaWxlOiBTbGlkZXIgZXZlbnRzIChub3QgYnJvd3NlciBldmVudHMpOyAqL1xyXG5cclxuXHQvLyBBdHRhY2ggYW4gZXZlbnQgdG8gdGhpcyBzbGlkZXIsIHBvc3NpYmx5IGluY2x1ZGluZyBhIG5hbWVzcGFjZVxyXG5cdGZ1bmN0aW9uIGJpbmRFdmVudCAoIG5hbWVzcGFjZWRFdmVudCwgY2FsbGJhY2sgKSB7XHJcblx0XHRzY29wZV9FdmVudHNbbmFtZXNwYWNlZEV2ZW50XSA9IHNjb3BlX0V2ZW50c1tuYW1lc3BhY2VkRXZlbnRdIHx8IFtdO1xyXG5cdFx0c2NvcGVfRXZlbnRzW25hbWVzcGFjZWRFdmVudF0ucHVzaChjYWxsYmFjayk7XHJcblxyXG5cdFx0Ly8gSWYgdGhlIGV2ZW50IGJvdW5kIGlzICd1cGRhdGUsJyBmaXJlIGl0IGltbWVkaWF0ZWx5IGZvciBhbGwgaGFuZGxlcy5cclxuXHRcdGlmICggbmFtZXNwYWNlZEV2ZW50LnNwbGl0KCcuJylbMF0gPT09ICd1cGRhdGUnICkge1xyXG5cdFx0XHRzY29wZV9IYW5kbGVzLmZvckVhY2goZnVuY3Rpb24oYSwgaW5kZXgpe1xyXG5cdFx0XHRcdGZpcmVFdmVudCgndXBkYXRlJywgaW5kZXgpO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8vIFVuZG8gYXR0YWNobWVudCBvZiBldmVudFxyXG5cdGZ1bmN0aW9uIHJlbW92ZUV2ZW50ICggbmFtZXNwYWNlZEV2ZW50ICkge1xyXG5cclxuXHRcdHZhciBldmVudCA9IG5hbWVzcGFjZWRFdmVudCAmJiBuYW1lc3BhY2VkRXZlbnQuc3BsaXQoJy4nKVswXTtcclxuXHRcdHZhciBuYW1lc3BhY2UgPSBldmVudCAmJiBuYW1lc3BhY2VkRXZlbnQuc3Vic3RyaW5nKGV2ZW50Lmxlbmd0aCk7XHJcblxyXG5cdFx0T2JqZWN0LmtleXMoc2NvcGVfRXZlbnRzKS5mb3JFYWNoKGZ1bmN0aW9uKCBiaW5kICl7XHJcblxyXG5cdFx0XHR2YXIgdEV2ZW50ID0gYmluZC5zcGxpdCgnLicpWzBdO1xyXG5cdFx0XHR2YXIgdE5hbWVzcGFjZSA9IGJpbmQuc3Vic3RyaW5nKHRFdmVudC5sZW5ndGgpO1xyXG5cclxuXHRcdFx0aWYgKCAoIWV2ZW50IHx8IGV2ZW50ID09PSB0RXZlbnQpICYmICghbmFtZXNwYWNlIHx8IG5hbWVzcGFjZSA9PT0gdE5hbWVzcGFjZSkgKSB7XHJcblx0XHRcdFx0ZGVsZXRlIHNjb3BlX0V2ZW50c1tiaW5kXTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBFeHRlcm5hbCBldmVudCBoYW5kbGluZ1xyXG5cdGZ1bmN0aW9uIGZpcmVFdmVudCAoIGV2ZW50TmFtZSwgaGFuZGxlTnVtYmVyLCB0YXAgKSB7XHJcblxyXG5cdFx0T2JqZWN0LmtleXMoc2NvcGVfRXZlbnRzKS5mb3JFYWNoKGZ1bmN0aW9uKCB0YXJnZXRFdmVudCApIHtcclxuXHJcblx0XHRcdHZhciBldmVudFR5cGUgPSB0YXJnZXRFdmVudC5zcGxpdCgnLicpWzBdO1xyXG5cclxuXHRcdFx0aWYgKCBldmVudE5hbWUgPT09IGV2ZW50VHlwZSApIHtcclxuXHRcdFx0XHRzY29wZV9FdmVudHNbdGFyZ2V0RXZlbnRdLmZvckVhY2goZnVuY3Rpb24oIGNhbGxiYWNrICkge1xyXG5cclxuXHRcdFx0XHRcdGNhbGxiYWNrLmNhbGwoXHJcblx0XHRcdFx0XHRcdC8vIFVzZSB0aGUgc2xpZGVyIHB1YmxpYyBBUEkgYXMgdGhlIHNjb3BlICgndGhpcycpXHJcblx0XHRcdFx0XHRcdHNjb3BlX1NlbGYsXHJcblx0XHRcdFx0XHRcdC8vIFJldHVybiB2YWx1ZXMgYXMgYXJyYXksIHNvIGFyZ18xW2FyZ18yXSBpcyBhbHdheXMgdmFsaWQuXHJcblx0XHRcdFx0XHRcdHNjb3BlX1ZhbHVlcy5tYXAob3B0aW9ucy5mb3JtYXQudG8pLFxyXG5cdFx0XHRcdFx0XHQvLyBIYW5kbGUgaW5kZXgsIDAgb3IgMVxyXG5cdFx0XHRcdFx0XHRoYW5kbGVOdW1iZXIsXHJcblx0XHRcdFx0XHRcdC8vIFVuZm9ybWF0dGVkIHNsaWRlciB2YWx1ZXNcclxuXHRcdFx0XHRcdFx0c2NvcGVfVmFsdWVzLnNsaWNlKCksXHJcblx0XHRcdFx0XHRcdC8vIEV2ZW50IGlzIGZpcmVkIGJ5IHRhcCwgdHJ1ZSBvciBmYWxzZVxyXG5cdFx0XHRcdFx0XHR0YXAgfHwgZmFsc2UsXHJcblx0XHRcdFx0XHRcdC8vIExlZnQgb2Zmc2V0IG9mIHRoZSBoYW5kbGUsIGluIHJlbGF0aW9uIHRvIHRoZSBzbGlkZXJcclxuXHRcdFx0XHRcdFx0c2NvcGVfTG9jYXRpb25zLnNsaWNlKClcclxuXHRcdFx0XHRcdCk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IE1lY2hhbmljcyBmb3Igc2xpZGVyIG9wZXJhdGlvbiAqL1xyXG5cclxuXHRmdW5jdGlvbiB0b1BjdCAoIHBjdCApIHtcclxuXHRcdHJldHVybiBwY3QgKyAnJSc7XHJcblx0fVxyXG5cclxuXHQvLyBTcGxpdCBvdXQgdGhlIGhhbmRsZSBwb3NpdGlvbmluZyBsb2dpYyBzbyB0aGUgTW92ZSBldmVudCBjYW4gdXNlIGl0LCB0b29cclxuXHRmdW5jdGlvbiBjaGVja0hhbmRsZVBvc2l0aW9uICggcmVmZXJlbmNlLCBoYW5kbGVOdW1iZXIsIHRvLCBsb29rQmFja3dhcmQsIGxvb2tGb3J3YXJkLCBnZXRWYWx1ZSApIHtcclxuXHJcblx0XHQvLyBGb3Igc2xpZGVycyB3aXRoIG11bHRpcGxlIGhhbmRsZXMsIGxpbWl0IG1vdmVtZW50IHRvIHRoZSBvdGhlciBoYW5kbGUuXHJcblx0XHQvLyBBcHBseSB0aGUgbWFyZ2luIG9wdGlvbiBieSBhZGRpbmcgaXQgdG8gdGhlIGhhbmRsZSBwb3NpdGlvbnMuXHJcblx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSApIHtcclxuXHJcblx0XHRcdGlmICggbG9va0JhY2t3YXJkICYmIGhhbmRsZU51bWJlciA+IDAgKSB7XHJcblx0XHRcdFx0dG8gPSBNYXRoLm1heCh0bywgcmVmZXJlbmNlW2hhbmRsZU51bWJlciAtIDFdICsgb3B0aW9ucy5tYXJnaW4pO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRpZiAoIGxvb2tGb3J3YXJkICYmIGhhbmRsZU51bWJlciA8IHNjb3BlX0hhbmRsZXMubGVuZ3RoIC0gMSApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWluKHRvLCByZWZlcmVuY2VbaGFuZGxlTnVtYmVyICsgMV0gLSBvcHRpb25zLm1hcmdpbik7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBUaGUgbGltaXQgb3B0aW9uIGhhcyB0aGUgb3Bwb3NpdGUgZWZmZWN0LCBsaW1pdGluZyBoYW5kbGVzIHRvIGFcclxuXHRcdC8vIG1heGltdW0gZGlzdGFuY2UgZnJvbSBhbm90aGVyLiBMaW1pdCBtdXN0IGJlID4gMCwgYXMgb3RoZXJ3aXNlXHJcblx0XHQvLyBoYW5kbGVzIHdvdWxkIGJlIHVubW92ZWFibGUuXHJcblx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSAmJiBvcHRpb25zLmxpbWl0ICkge1xyXG5cclxuXHRcdFx0aWYgKCBsb29rQmFja3dhcmQgJiYgaGFuZGxlTnVtYmVyID4gMCApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWluKHRvLCByZWZlcmVuY2VbaGFuZGxlTnVtYmVyIC0gMV0gKyBvcHRpb25zLmxpbWl0KTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0aWYgKCBsb29rRm9yd2FyZCAmJiBoYW5kbGVOdW1iZXIgPCBzY29wZV9IYW5kbGVzLmxlbmd0aCAtIDEgKSB7XHJcblx0XHRcdFx0dG8gPSBNYXRoLm1heCh0bywgcmVmZXJlbmNlW2hhbmRsZU51bWJlciArIDFdIC0gb3B0aW9ucy5saW1pdCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBUaGUgcGFkZGluZyBvcHRpb24ga2VlcHMgdGhlIGhhbmRsZXMgYSBjZXJ0YWluIGRpc3RhbmNlIGZyb20gdGhlXHJcblx0XHQvLyBlZGdlcyBvZiB0aGUgc2xpZGVyLiBQYWRkaW5nIG11c3QgYmUgPiAwLlxyXG5cdFx0aWYgKCBvcHRpb25zLnBhZGRpbmcgKSB7XHJcblxyXG5cdFx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gMCApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWF4KHRvLCBvcHRpb25zLnBhZGRpbmdbMF0pO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gc2NvcGVfSGFuZGxlcy5sZW5ndGggLSAxICkge1xyXG5cdFx0XHRcdHRvID0gTWF0aC5taW4odG8sIDEwMCAtIG9wdGlvbnMucGFkZGluZ1sxXSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHR0byA9IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAodG8pO1xyXG5cclxuXHRcdC8vIExpbWl0IHBlcmNlbnRhZ2UgdG8gdGhlIDAgLSAxMDAgcmFuZ2VcclxuXHRcdHRvID0gbGltaXQodG8pO1xyXG5cclxuXHRcdC8vIFJldHVybiBmYWxzZSBpZiBoYW5kbGUgY2FuJ3QgbW92ZVxyXG5cdFx0aWYgKCB0byA9PT0gcmVmZXJlbmNlW2hhbmRsZU51bWJlcl0gJiYgIWdldFZhbHVlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHRvO1xyXG5cdH1cclxuXHJcblx0Ly8gVXNlcyBzbGlkZXIgb3JpZW50YXRpb24gdG8gY3JlYXRlIENTUyBydWxlcy4gYSA9IGJhc2UgdmFsdWU7XHJcblx0ZnVuY3Rpb24gaW5SdWxlT3JkZXIgKCB2LCBhICkge1xyXG5cdFx0dmFyIG8gPSBvcHRpb25zLm9ydDtcclxuXHRcdHJldHVybiAobz9hOnYpICsgJywgJyArIChvP3Y6YSk7XHJcblx0fVxyXG5cclxuXHQvLyBNb3ZlcyBoYW5kbGUocykgYnkgYSBwZXJjZW50YWdlXHJcblx0Ly8gKGJvb2wsICUgdG8gbW92ZSwgWyUgd2hlcmUgaGFuZGxlIHN0YXJ0ZWQsIC4uLl0sIFtpbmRleCBpbiBzY29wZV9IYW5kbGVzLCAuLi5dKVxyXG5cdGZ1bmN0aW9uIG1vdmVIYW5kbGVzICggdXB3YXJkLCBwcm9wb3NhbCwgbG9jYXRpb25zLCBoYW5kbGVOdW1iZXJzICkge1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbHMgPSBsb2NhdGlvbnMuc2xpY2UoKTtcclxuXHJcblx0XHR2YXIgYiA9IFshdXB3YXJkLCB1cHdhcmRdO1xyXG5cdFx0dmFyIGYgPSBbdXB3YXJkLCAhdXB3YXJkXTtcclxuXHJcblx0XHQvLyBDb3B5IGhhbmRsZU51bWJlcnMgc28gd2UgZG9uJ3QgY2hhbmdlIHRoZSBkYXRhc2V0XHJcblx0XHRoYW5kbGVOdW1iZXJzID0gaGFuZGxlTnVtYmVycy5zbGljZSgpO1xyXG5cclxuXHRcdC8vIENoZWNrIHRvIHNlZSB3aGljaCBoYW5kbGUgaXMgJ2xlYWRpbmcnLlxyXG5cdFx0Ly8gSWYgdGhhdCBvbmUgY2FuJ3QgbW92ZSB0aGUgc2Vjb25kIGNhbid0IGVpdGhlci5cclxuXHRcdGlmICggdXB3YXJkICkge1xyXG5cdFx0XHRoYW5kbGVOdW1iZXJzLnJldmVyc2UoKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBTdGVwIDE6IGdldCB0aGUgbWF4aW11bSBwZXJjZW50YWdlIHRoYXQgYW55IG9mIHRoZSBoYW5kbGVzIGNhbiBtb3ZlXHJcblx0XHRpZiAoIGhhbmRsZU51bWJlcnMubGVuZ3RoID4gMSApIHtcclxuXHJcblx0XHRcdGhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIsIG8pIHtcclxuXHJcblx0XHRcdFx0dmFyIHRvID0gY2hlY2tIYW5kbGVQb3NpdGlvbihwcm9wb3NhbHMsIGhhbmRsZU51bWJlciwgcHJvcG9zYWxzW2hhbmRsZU51bWJlcl0gKyBwcm9wb3NhbCwgYltvXSwgZltvXSwgZmFsc2UpO1xyXG5cclxuXHRcdFx0XHQvLyBTdG9wIGlmIG9uZSBvZiB0aGUgaGFuZGxlcyBjYW4ndCBtb3ZlLlxyXG5cdFx0XHRcdGlmICggdG8gPT09IGZhbHNlICkge1xyXG5cdFx0XHRcdFx0cHJvcG9zYWwgPSAwO1xyXG5cdFx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0XHRwcm9wb3NhbCA9IHRvIC0gcHJvcG9zYWxzW2hhbmRsZU51bWJlcl07XHJcblx0XHRcdFx0XHRwcm9wb3NhbHNbaGFuZGxlTnVtYmVyXSA9IHRvO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gSWYgdXNpbmcgb25lIGhhbmRsZSwgY2hlY2sgYmFja3dhcmQgQU5EIGZvcndhcmRcclxuXHRcdGVsc2Uge1xyXG5cdFx0XHRiID0gZiA9IFt0cnVlXTtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgc3RhdGUgPSBmYWxzZTtcclxuXHJcblx0XHQvLyBTdGVwIDI6IFRyeSB0byBzZXQgdGhlIGhhbmRsZXMgd2l0aCB0aGUgZm91bmQgcGVyY2VudGFnZVxyXG5cdFx0aGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlciwgbykge1xyXG5cdFx0XHRzdGF0ZSA9IHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIGxvY2F0aW9uc1toYW5kbGVOdW1iZXJdICsgcHJvcG9zYWwsIGJbb10sIGZbb10pIHx8IHN0YXRlO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gU3RlcCAzOiBJZiBhIGhhbmRsZSBtb3ZlZCwgZmlyZSBldmVudHNcclxuXHRcdGlmICggc3RhdGUgKSB7XHJcblx0XHRcdGhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRcdGZpcmVFdmVudCgndXBkYXRlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0XHRmaXJlRXZlbnQoJ3NsaWRlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0fSk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQvLyBUYWtlcyBhIGJhc2UgdmFsdWUgYW5kIGFuIG9mZnNldC4gVGhpcyBvZmZzZXQgaXMgdXNlZCBmb3IgdGhlIGNvbm5lY3QgYmFyIHNpemUuXHJcblx0Ly8gSW4gdGhlIGluaXRpYWwgZGVzaWduIGZvciB0aGlzIGZlYXR1cmUsIHRoZSBvcmlnaW4gZWxlbWVudCB3YXMgMSUgd2lkZS5cclxuXHQvLyBVbmZvcnR1bmF0ZWx5LCBhIHJvdW5kaW5nIGJ1ZyBpbiBDaHJvbWUgbWFrZXMgaXQgaW1wb3NzaWJsZSB0byBpbXBsZW1lbnQgdGhpcyBmZWF0dXJlXHJcblx0Ly8gaW4gdGhpcyBtYW5uZXI6IGh0dHBzOi8vYnVncy5jaHJvbWl1bS5vcmcvcC9jaHJvbWl1bS9pc3N1ZXMvZGV0YWlsP2lkPTc5ODIyM1xyXG5cdGZ1bmN0aW9uIHRyYW5zZm9ybURpcmVjdGlvbiAoIGEsIGIgKSB7XHJcblx0XHRyZXR1cm4gb3B0aW9ucy5kaXIgPyAxMDAgLSBhIC0gYiA6IGE7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVzIHNjb3BlX0xvY2F0aW9ucyBhbmQgc2NvcGVfVmFsdWVzLCB1cGRhdGVzIHZpc3VhbCBzdGF0ZVxyXG5cdGZ1bmN0aW9uIHVwZGF0ZUhhbmRsZVBvc2l0aW9uICggaGFuZGxlTnVtYmVyLCB0byApIHtcclxuXHJcblx0XHQvLyBVcGRhdGUgbG9jYXRpb25zLlxyXG5cdFx0c2NvcGVfTG9jYXRpb25zW2hhbmRsZU51bWJlcl0gPSB0bztcclxuXHJcblx0XHQvLyBDb252ZXJ0IHRoZSB2YWx1ZSB0byB0aGUgc2xpZGVyIHN0ZXBwaW5nL3JhbmdlLlxyXG5cdFx0c2NvcGVfVmFsdWVzW2hhbmRsZU51bWJlcl0gPSBzY29wZV9TcGVjdHJ1bS5mcm9tU3RlcHBpbmcodG8pO1xyXG5cclxuXHRcdHZhciBydWxlID0gJ3RyYW5zbGF0ZSgnICsgaW5SdWxlT3JkZXIodG9QY3QodHJhbnNmb3JtRGlyZWN0aW9uKHRvLCAwKSAtIHNjb3BlX0Rpck9mZnNldCksICcwJykgKyAnKSc7XHJcblx0XHRzY29wZV9IYW5kbGVzW2hhbmRsZU51bWJlcl0uc3R5bGVbb3B0aW9ucy50cmFuc2Zvcm1SdWxlXSA9IHJ1bGU7XHJcblxyXG5cdFx0dXBkYXRlQ29ubmVjdChoYW5kbGVOdW1iZXIpO1xyXG5cdFx0dXBkYXRlQ29ubmVjdChoYW5kbGVOdW1iZXIgKyAxKTtcclxuXHR9XHJcblxyXG5cdC8vIEhhbmRsZXMgYmVmb3JlIHRoZSBzbGlkZXIgbWlkZGxlIGFyZSBzdGFja2VkIGxhdGVyID0gaGlnaGVyLFxyXG5cdC8vIEhhbmRsZXMgYWZ0ZXIgdGhlIG1pZGRsZSBsYXRlciBpcyBsb3dlclxyXG5cdC8vIFtbN10gWzhdIC4uLi4uLi4uLi4gfCAuLi4uLi4uLi4uIFs1XSBbNF1cclxuXHRmdW5jdGlvbiBzZXRaaW5kZXggKCApIHtcclxuXHJcblx0XHRzY29wZV9IYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oaGFuZGxlTnVtYmVyKXtcclxuXHRcdFx0dmFyIGRpciA9IChzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXSA+IDUwID8gLTEgOiAxKTtcclxuXHRcdFx0dmFyIHpJbmRleCA9IDMgKyAoc2NvcGVfSGFuZGxlcy5sZW5ndGggKyAoZGlyICogaGFuZGxlTnVtYmVyKSk7XHJcblx0XHRcdHNjb3BlX0hhbmRsZXNbaGFuZGxlTnVtYmVyXS5zdHlsZS56SW5kZXggPSB6SW5kZXg7XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cdC8vIFRlc3Qgc3VnZ2VzdGVkIHZhbHVlcyBhbmQgYXBwbHkgbWFyZ2luLCBzdGVwLlxyXG5cdGZ1bmN0aW9uIHNldEhhbmRsZSAoIGhhbmRsZU51bWJlciwgdG8sIGxvb2tCYWNrd2FyZCwgbG9va0ZvcndhcmQgKSB7XHJcblxyXG5cdFx0dG8gPSBjaGVja0hhbmRsZVBvc2l0aW9uKHNjb3BlX0xvY2F0aW9ucywgaGFuZGxlTnVtYmVyLCB0bywgbG9va0JhY2t3YXJkLCBsb29rRm9yd2FyZCwgZmFsc2UpO1xyXG5cclxuXHRcdGlmICggdG8gPT09IGZhbHNlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0dXBkYXRlSGFuZGxlUG9zaXRpb24oaGFuZGxlTnVtYmVyLCB0byk7XHJcblxyXG5cdFx0cmV0dXJuIHRydWU7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVzIHN0eWxlIGF0dHJpYnV0ZSBmb3IgY29ubmVjdCBub2Rlc1xyXG5cdGZ1bmN0aW9uIHVwZGF0ZUNvbm5lY3QgKCBpbmRleCApIHtcclxuXHJcblx0XHQvLyBTa2lwIGNvbm5lY3RzIHNldCB0byBmYWxzZVxyXG5cdFx0aWYgKCAhc2NvcGVfQ29ubmVjdHNbaW5kZXhdICkge1xyXG5cdFx0XHRyZXR1cm47XHJcblx0XHR9XHJcblxyXG5cdFx0dmFyIGwgPSAwO1xyXG5cdFx0dmFyIGggPSAxMDA7XHJcblxyXG5cdFx0aWYgKCBpbmRleCAhPT0gMCApIHtcclxuXHRcdFx0bCA9IHNjb3BlX0xvY2F0aW9uc1tpbmRleCAtIDFdO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggaW5kZXggIT09IHNjb3BlX0Nvbm5lY3RzLmxlbmd0aCAtIDEgKSB7XHJcblx0XHRcdGggPSBzY29wZV9Mb2NhdGlvbnNbaW5kZXhdO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFdlIHVzZSB0d28gcnVsZXM6XHJcblx0XHQvLyAndHJhbnNsYXRlJyB0byBjaGFuZ2UgdGhlIGxlZnQvdG9wIG9mZnNldDtcclxuXHRcdC8vICdzY2FsZScgdG8gY2hhbmdlIHRoZSB3aWR0aCBvZiB0aGUgZWxlbWVudDtcclxuXHRcdC8vIEFzIHRoZSBlbGVtZW50IGhhcyBhIHdpZHRoIG9mIDEwMCUsIGEgdHJhbnNsYXRpb24gb2YgMTAwJSBpcyBlcXVhbCB0byAxMDAlIG9mIHRoZSBwYXJlbnQgKC5ub1VpLWJhc2UpXHJcblx0XHR2YXIgY29ubmVjdFdpZHRoID0gaCAtIGw7XHJcblx0XHR2YXIgdHJhbnNsYXRlUnVsZSA9ICd0cmFuc2xhdGUoJyArIGluUnVsZU9yZGVyKHRvUGN0KHRyYW5zZm9ybURpcmVjdGlvbihsLCBjb25uZWN0V2lkdGgpKSwgJzAnKSArICcpJztcclxuXHRcdHZhciBzY2FsZVJ1bGUgPSAnc2NhbGUoJyArIGluUnVsZU9yZGVyKGNvbm5lY3RXaWR0aCAvIDEwMCwgJzEnKSArICcpJztcclxuXHJcblx0XHRzY29wZV9Db25uZWN0c1tpbmRleF0uc3R5bGVbb3B0aW9ucy50cmFuc2Zvcm1SdWxlXSA9IHRyYW5zbGF0ZVJ1bGUgKyAnICcgKyBzY2FsZVJ1bGU7XHJcblx0fVxyXG5cclxuLyohIEluIHRoaXMgZmlsZTogQWxsIG1ldGhvZHMgZXZlbnR1YWxseSBleHBvc2VkIGluIHNsaWRlci5ub1VpU2xpZGVyLi4uICovXHJcblxyXG5cdC8vIFBhcnNlcyB2YWx1ZSBwYXNzZWQgdG8gLnNldCBtZXRob2QuIFJldHVybnMgY3VycmVudCB2YWx1ZSBpZiBub3QgcGFyc2UtYWJsZS5cclxuXHRmdW5jdGlvbiByZXNvbHZlVG9WYWx1ZSAoIHRvLCBoYW5kbGVOdW1iZXIgKSB7XHJcblxyXG5cdFx0Ly8gU2V0dGluZyB3aXRoIG51bGwgaW5kaWNhdGVzIGFuICdpZ25vcmUnLlxyXG5cdFx0Ly8gSW5wdXR0aW5nICdmYWxzZScgaXMgaW52YWxpZC5cclxuXHRcdGlmICggdG8gPT09IG51bGwgfHwgdG8gPT09IGZhbHNlIHx8IHRvID09PSB1bmRlZmluZWQgKSB7XHJcblx0XHRcdHJldHVybiBzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJZiBhIGZvcm1hdHRlZCBudW1iZXIgd2FzIHBhc3NlZCwgYXR0ZW1wdCB0byBkZWNvZGUgaXQuXHJcblx0XHRpZiAoIHR5cGVvZiB0byA9PT0gJ251bWJlcicgKSB7XHJcblx0XHRcdHRvID0gU3RyaW5nKHRvKTtcclxuXHRcdH1cclxuXHJcblx0XHR0byA9IG9wdGlvbnMuZm9ybWF0LmZyb20odG8pO1xyXG5cdFx0dG8gPSBzY29wZV9TcGVjdHJ1bS50b1N0ZXBwaW5nKHRvKTtcclxuXHJcblx0XHQvLyBJZiBwYXJzaW5nIHRoZSBudW1iZXIgZmFpbGVkLCB1c2UgdGhlIGN1cnJlbnQgdmFsdWUuXHJcblx0XHRpZiAoIHRvID09PSBmYWxzZSB8fCBpc05hTih0bykgKSB7XHJcblx0XHRcdHJldHVybiBzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gdG87XHJcblx0fVxyXG5cclxuXHQvLyBTZXQgdGhlIHNsaWRlciB2YWx1ZS5cclxuXHRmdW5jdGlvbiB2YWx1ZVNldCAoIGlucHV0LCBmaXJlU2V0RXZlbnQgKSB7XHJcblxyXG5cdFx0dmFyIHZhbHVlcyA9IGFzQXJyYXkoaW5wdXQpO1xyXG5cdFx0dmFyIGlzSW5pdCA9IHNjb3BlX0xvY2F0aW9uc1swXSA9PT0gdW5kZWZpbmVkO1xyXG5cclxuXHRcdC8vIEV2ZW50IGZpcmVzIGJ5IGRlZmF1bHRcclxuXHRcdGZpcmVTZXRFdmVudCA9IChmaXJlU2V0RXZlbnQgPT09IHVuZGVmaW5lZCA/IHRydWUgOiAhIWZpcmVTZXRFdmVudCk7XHJcblxyXG5cdFx0Ly8gQW5pbWF0aW9uIGlzIG9wdGlvbmFsLlxyXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSBpbml0aWFsIHZhbHVlcyB3ZXJlIHNldCBiZWZvcmUgdXNpbmcgYW5pbWF0ZWQgcGxhY2VtZW50LlxyXG5cdFx0aWYgKCBvcHRpb25zLmFuaW1hdGUgJiYgIWlzSW5pdCApIHtcclxuXHRcdFx0YWRkQ2xhc3NGb3Ioc2NvcGVfVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMudGFwLCBvcHRpb25zLmFuaW1hdGlvbkR1cmF0aW9uKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBGaXJzdCBwYXNzLCB3aXRob3V0IGxvb2tBaGVhZCBidXQgd2l0aCBsb29rQmFja3dhcmQuIFZhbHVlcyBhcmUgc2V0IGZyb20gbGVmdCB0byByaWdodC5cclxuXHRcdHNjb3BlX0hhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRzZXRIYW5kbGUoaGFuZGxlTnVtYmVyLCByZXNvbHZlVG9WYWx1ZSh2YWx1ZXNbaGFuZGxlTnVtYmVyXSwgaGFuZGxlTnVtYmVyKSwgdHJ1ZSwgZmFsc2UpO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gU2Vjb25kIHBhc3MuIE5vdyB0aGF0IGFsbCBiYXNlIHZhbHVlcyBhcmUgc2V0LCBhcHBseSBjb25zdHJhaW50c1xyXG5cdFx0c2NvcGVfSGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIHNjb3BlX0xvY2F0aW9uc1toYW5kbGVOdW1iZXJdLCB0cnVlLCB0cnVlKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdHNldFppbmRleCgpO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cclxuXHRcdFx0ZmlyZUV2ZW50KCd1cGRhdGUnLCBoYW5kbGVOdW1iZXIpO1xyXG5cclxuXHRcdFx0Ly8gRmlyZSB0aGUgZXZlbnQgb25seSBmb3IgaGFuZGxlcyB0aGF0IHJlY2VpdmVkIGEgbmV3IHZhbHVlLCBhcyBwZXIgIzU3OVxyXG5cdFx0XHRpZiAoIHZhbHVlc1toYW5kbGVOdW1iZXJdICE9PSBudWxsICYmIGZpcmVTZXRFdmVudCApIHtcclxuXHRcdFx0XHRmaXJlRXZlbnQoJ3NldCcsIGhhbmRsZU51bWJlcik7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gUmVzZXQgc2xpZGVyIHRvIGluaXRpYWwgdmFsdWVzXHJcblx0ZnVuY3Rpb24gdmFsdWVSZXNldCAoIGZpcmVTZXRFdmVudCApIHtcclxuXHRcdHZhbHVlU2V0KG9wdGlvbnMuc3RhcnQsIGZpcmVTZXRFdmVudCk7XHJcblx0fVxyXG5cclxuXHQvLyBHZXQgdGhlIHNsaWRlciB2YWx1ZS5cclxuXHRmdW5jdGlvbiB2YWx1ZUdldCAoICkge1xyXG5cclxuXHRcdHZhciB2YWx1ZXMgPSBzY29wZV9WYWx1ZXMubWFwKG9wdGlvbnMuZm9ybWF0LnRvKTtcclxuXHJcblx0XHQvLyBJZiBvbmx5IG9uZSBoYW5kbGUgaXMgdXNlZCwgcmV0dXJuIGEgc2luZ2xlIHZhbHVlLlxyXG5cdFx0aWYgKCB2YWx1ZXMubGVuZ3RoID09PSAxICl7XHJcblx0XHRcdHJldHVybiB2YWx1ZXNbMF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHZhbHVlcztcclxuXHR9XHJcblxyXG5cdC8vIFJlbW92ZXMgY2xhc3NlcyBmcm9tIHRoZSByb290IGFuZCBlbXB0aWVzIGl0LlxyXG5cdGZ1bmN0aW9uIGRlc3Ryb3kgKCApIHtcclxuXHJcblx0XHRmb3IgKCB2YXIga2V5IGluIG9wdGlvbnMuY3NzQ2xhc3NlcyApIHtcclxuXHRcdFx0aWYgKCAhb3B0aW9ucy5jc3NDbGFzc2VzLmhhc093blByb3BlcnR5KGtleSkgKSB7IGNvbnRpbnVlOyB9XHJcblx0XHRcdHJlbW92ZUNsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzW2tleV0pO1xyXG5cdFx0fVxyXG5cclxuXHRcdHdoaWxlIChzY29wZV9UYXJnZXQuZmlyc3RDaGlsZCkge1xyXG5cdFx0XHRzY29wZV9UYXJnZXQucmVtb3ZlQ2hpbGQoc2NvcGVfVGFyZ2V0LmZpcnN0Q2hpbGQpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGRlbGV0ZSBzY29wZV9UYXJnZXQubm9VaVNsaWRlcjtcclxuXHR9XHJcblxyXG5cdC8vIEdldCB0aGUgY3VycmVudCBzdGVwIHNpemUgZm9yIHRoZSBzbGlkZXIuXHJcblx0ZnVuY3Rpb24gZ2V0Q3VycmVudFN0ZXAgKCApIHtcclxuXHJcblx0XHQvLyBDaGVjayBhbGwgbG9jYXRpb25zLCBtYXAgdGhlbSB0byB0aGVpciBzdGVwcGluZyBwb2ludC5cclxuXHRcdC8vIEdldCB0aGUgc3RlcCBwb2ludCwgdGhlbiBmaW5kIGl0IGluIHRoZSBpbnB1dCBsaXN0LlxyXG5cdFx0cmV0dXJuIHNjb3BlX0xvY2F0aW9ucy5tYXAoZnVuY3Rpb24oIGxvY2F0aW9uLCBpbmRleCApe1xyXG5cclxuXHRcdFx0dmFyIG5lYXJieVN0ZXBzID0gc2NvcGVfU3BlY3RydW0uZ2V0TmVhcmJ5U3RlcHMoIGxvY2F0aW9uICk7XHJcblx0XHRcdHZhciB2YWx1ZSA9IHNjb3BlX1ZhbHVlc1tpbmRleF07XHJcblx0XHRcdHZhciBpbmNyZW1lbnQgPSBuZWFyYnlTdGVwcy50aGlzU3RlcC5zdGVwO1xyXG5cdFx0XHR2YXIgZGVjcmVtZW50ID0gbnVsbDtcclxuXHJcblx0XHRcdC8vIElmIHRoZSBuZXh0IHZhbHVlIGluIHRoaXMgc3RlcCBtb3ZlcyBpbnRvIHRoZSBuZXh0IHN0ZXAsXHJcblx0XHRcdC8vIHRoZSBpbmNyZW1lbnQgaXMgdGhlIHN0YXJ0IG9mIHRoZSBuZXh0IHN0ZXAgLSB0aGUgY3VycmVudCB2YWx1ZVxyXG5cdFx0XHRpZiAoIGluY3JlbWVudCAhPT0gZmFsc2UgKSB7XHJcblx0XHRcdFx0aWYgKCB2YWx1ZSArIGluY3JlbWVudCA+IG5lYXJieVN0ZXBzLnN0ZXBBZnRlci5zdGFydFZhbHVlICkge1xyXG5cdFx0XHRcdFx0aW5jcmVtZW50ID0gbmVhcmJ5U3RlcHMuc3RlcEFmdGVyLnN0YXJ0VmFsdWUgLSB2YWx1ZTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblxyXG5cdFx0XHQvLyBJZiB0aGUgdmFsdWUgaXMgYmV5b25kIHRoZSBzdGFydGluZyBwb2ludFxyXG5cdFx0XHRpZiAoIHZhbHVlID4gbmVhcmJ5U3RlcHMudGhpc1N0ZXAuc3RhcnRWYWx1ZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBuZWFyYnlTdGVwcy50aGlzU3RlcC5zdGVwO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRlbHNlIGlmICggbmVhcmJ5U3RlcHMuc3RlcEJlZm9yZS5zdGVwID09PSBmYWxzZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBmYWxzZTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gSWYgYSBoYW5kbGUgaXMgYXQgdGhlIHN0YXJ0IG9mIGEgc3RlcCwgaXQgYWx3YXlzIHN0ZXBzIGJhY2sgaW50byB0aGUgcHJldmlvdXMgc3RlcCBmaXJzdFxyXG5cdFx0XHRlbHNlIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSB2YWx1ZSAtIG5lYXJieVN0ZXBzLnN0ZXBCZWZvcmUuaGlnaGVzdFN0ZXA7XHJcblx0XHRcdH1cclxuXHJcblxyXG5cdFx0XHQvLyBOb3csIGlmIGF0IHRoZSBzbGlkZXIgZWRnZXMsIHRoZXJlIGlzIG5vdCBpbi9kZWNyZW1lbnRcclxuXHRcdFx0aWYgKCBsb2NhdGlvbiA9PT0gMTAwICkge1xyXG5cdFx0XHRcdGluY3JlbWVudCA9IG51bGw7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGVsc2UgaWYgKCBsb2NhdGlvbiA9PT0gMCApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBudWxsO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBBcyBwZXIgIzM5MSwgdGhlIGNvbXBhcmlzb24gZm9yIHRoZSBkZWNyZW1lbnQgc3RlcCBjYW4gaGF2ZSBzb21lIHJvdW5kaW5nIGlzc3Vlcy5cclxuXHRcdFx0dmFyIHN0ZXBEZWNpbWFscyA9IHNjb3BlX1NwZWN0cnVtLmNvdW50U3RlcERlY2ltYWxzKCk7XHJcblxyXG5cdFx0XHQvLyBSb3VuZCBwZXIgIzM5MVxyXG5cdFx0XHRpZiAoIGluY3JlbWVudCAhPT0gbnVsbCAmJiBpbmNyZW1lbnQgIT09IGZhbHNlICkge1xyXG5cdFx0XHRcdGluY3JlbWVudCA9IE51bWJlcihpbmNyZW1lbnQudG9GaXhlZChzdGVwRGVjaW1hbHMpKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0aWYgKCBkZWNyZW1lbnQgIT09IG51bGwgJiYgZGVjcmVtZW50ICE9PSBmYWxzZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBOdW1iZXIoZGVjcmVtZW50LnRvRml4ZWQoc3RlcERlY2ltYWxzKSk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiBbZGVjcmVtZW50LCBpbmNyZW1lbnRdO1xyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVhYmxlOiBtYXJnaW4sIGxpbWl0LCBwYWRkaW5nLCBzdGVwLCByYW5nZSwgYW5pbWF0ZSwgc25hcFxyXG5cdGZ1bmN0aW9uIHVwZGF0ZU9wdGlvbnMgKCBvcHRpb25zVG9VcGRhdGUsIGZpcmVTZXRFdmVudCApIHtcclxuXHJcblx0XHQvLyBTcGVjdHJ1bSBpcyBjcmVhdGVkIHVzaW5nIHRoZSByYW5nZSwgc25hcCwgZGlyZWN0aW9uIGFuZCBzdGVwIG9wdGlvbnMuXHJcblx0XHQvLyAnc25hcCcgYW5kICdzdGVwJyBjYW4gYmUgdXBkYXRlZC5cclxuXHRcdC8vIElmICdzbmFwJyBhbmQgJ3N0ZXAnIGFyZSBub3QgcGFzc2VkLCB0aGV5IHNob3VsZCByZW1haW4gdW5jaGFuZ2VkLlxyXG5cdFx0dmFyIHYgPSB2YWx1ZUdldCgpO1xyXG5cclxuXHRcdHZhciB1cGRhdGVBYmxlID0gWydtYXJnaW4nLCAnbGltaXQnLCAncGFkZGluZycsICdyYW5nZScsICdhbmltYXRlJywgJ3NuYXAnLCAnc3RlcCcsICdmb3JtYXQnXTtcclxuXHJcblx0XHQvLyBPbmx5IGNoYW5nZSBvcHRpb25zIHRoYXQgd2UncmUgYWN0dWFsbHkgcGFzc2VkIHRvIHVwZGF0ZS5cclxuXHRcdHVwZGF0ZUFibGUuZm9yRWFjaChmdW5jdGlvbihuYW1lKXtcclxuXHRcdFx0aWYgKCBvcHRpb25zVG9VcGRhdGVbbmFtZV0gIT09IHVuZGVmaW5lZCApIHtcclxuXHRcdFx0XHRvcmlnaW5hbE9wdGlvbnNbbmFtZV0gPSBvcHRpb25zVG9VcGRhdGVbbmFtZV07XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cclxuXHRcdHZhciBuZXdPcHRpb25zID0gdGVzdE9wdGlvbnMob3JpZ2luYWxPcHRpb25zKTtcclxuXHJcblx0XHQvLyBMb2FkIG5ldyBvcHRpb25zIGludG8gdGhlIHNsaWRlciBzdGF0ZVxyXG5cdFx0dXBkYXRlQWJsZS5mb3JFYWNoKGZ1bmN0aW9uKG5hbWUpe1xyXG5cdFx0XHRpZiAoIG9wdGlvbnNUb1VwZGF0ZVtuYW1lXSAhPT0gdW5kZWZpbmVkICkge1xyXG5cdFx0XHRcdG9wdGlvbnNbbmFtZV0gPSBuZXdPcHRpb25zW25hbWVdO1xyXG5cdFx0XHR9XHJcblx0XHR9KTtcclxuXHJcblx0XHRzY29wZV9TcGVjdHJ1bSA9IG5ld09wdGlvbnMuc3BlY3RydW07XHJcblxyXG5cdFx0Ly8gTGltaXQsIG1hcmdpbiBhbmQgcGFkZGluZyBkZXBlbmQgb24gdGhlIHNwZWN0cnVtIGJ1dCBhcmUgc3RvcmVkIG91dHNpZGUgb2YgaXQuICgjNjc3KVxyXG5cdFx0b3B0aW9ucy5tYXJnaW4gPSBuZXdPcHRpb25zLm1hcmdpbjtcclxuXHRcdG9wdGlvbnMubGltaXQgPSBuZXdPcHRpb25zLmxpbWl0O1xyXG5cdFx0b3B0aW9ucy5wYWRkaW5nID0gbmV3T3B0aW9ucy5wYWRkaW5nO1xyXG5cclxuXHRcdC8vIFVwZGF0ZSBwaXBzLCByZW1vdmVzIGV4aXN0aW5nLlxyXG5cdFx0aWYgKCBvcHRpb25zLnBpcHMgKSB7XHJcblx0XHRcdHBpcHMob3B0aW9ucy5waXBzKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJbnZhbGlkYXRlIHRoZSBjdXJyZW50IHBvc2l0aW9uaW5nIHNvIHZhbHVlU2V0IGZvcmNlcyBhbiB1cGRhdGUuXHJcblx0XHRzY29wZV9Mb2NhdGlvbnMgPSBbXTtcclxuXHRcdHZhbHVlU2V0KG9wdGlvbnNUb1VwZGF0ZS5zdGFydCB8fCB2LCBmaXJlU2V0RXZlbnQpO1xyXG5cdH1cclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IENhbGxzIHRvIGZ1bmN0aW9ucy4gQWxsIG90aGVyIHNjb3BlXyBmaWxlcyBkZWZpbmUgZnVuY3Rpb25zIG9ubHk7ICovXHJcblxyXG5cdC8vIENyZWF0ZSB0aGUgYmFzZSBlbGVtZW50LCBpbml0aWFsaXplIEhUTUwgYW5kIHNldCBjbGFzc2VzLlxyXG5cdC8vIEFkZCBoYW5kbGVzIGFuZCBjb25uZWN0IGVsZW1lbnRzLlxyXG5cdGFkZFNsaWRlcihzY29wZV9UYXJnZXQpO1xyXG5cdGFkZEVsZW1lbnRzKG9wdGlvbnMuY29ubmVjdCwgc2NvcGVfQmFzZSk7XHJcblxyXG5cdC8vIEF0dGFjaCB1c2VyIGV2ZW50cy5cclxuXHRiaW5kU2xpZGVyRXZlbnRzKG9wdGlvbnMuZXZlbnRzKTtcclxuXHJcblx0Ly8gVXNlIHRoZSBwdWJsaWMgdmFsdWUgbWV0aG9kIHRvIHNldCB0aGUgc3RhcnQgdmFsdWVzLlxyXG5cdHZhbHVlU2V0KG9wdGlvbnMuc3RhcnQpO1xyXG5cclxuXHRzY29wZV9TZWxmID0ge1xyXG5cdFx0ZGVzdHJveTogZGVzdHJveSxcclxuXHRcdHN0ZXBzOiBnZXRDdXJyZW50U3RlcCxcclxuXHRcdG9uOiBiaW5kRXZlbnQsXHJcblx0XHRvZmY6IHJlbW92ZUV2ZW50LFxyXG5cdFx0Z2V0OiB2YWx1ZUdldCxcclxuXHRcdHNldDogdmFsdWVTZXQsXHJcblx0XHRyZXNldDogdmFsdWVSZXNldCxcclxuXHRcdC8vIEV4cG9zZWQgZm9yIHVuaXQgdGVzdGluZywgZG9uJ3QgdXNlIHRoaXMgaW4geW91ciBhcHBsaWNhdGlvbi5cclxuXHRcdF9fbW92ZUhhbmRsZXM6IGZ1bmN0aW9uKGEsIGIsIGMpIHsgbW92ZUhhbmRsZXMoYSwgYiwgc2NvcGVfTG9jYXRpb25zLCBjKTsgfSxcclxuXHRcdG9wdGlvbnM6IG9yaWdpbmFsT3B0aW9ucywgLy8gSXNzdWUgIzYwMCwgIzY3OFxyXG5cdFx0dXBkYXRlT3B0aW9uczogdXBkYXRlT3B0aW9ucyxcclxuXHRcdHRhcmdldDogc2NvcGVfVGFyZ2V0LCAvLyBJc3N1ZSAjNTk3XHJcblx0XHRyZW1vdmVQaXBzOiByZW1vdmVQaXBzLFxyXG5cdFx0cGlwczogcGlwcyAvLyBJc3N1ZSAjNTk0XHJcblx0fTtcclxuXHJcblx0aWYgKCBvcHRpb25zLnBpcHMgKSB7XHJcblx0XHRwaXBzKG9wdGlvbnMucGlwcyk7XHJcblx0fVxyXG5cclxuXHRpZiAoIG9wdGlvbnMudG9vbHRpcHMgKSB7XHJcblx0XHR0b29sdGlwcygpO1xyXG5cdH1cclxuXHJcblx0YXJpYSgpO1xyXG5cclxuXHRyZXR1cm4gc2NvcGVfU2VsZjtcclxuXHJcbn1cclxuXHJcblxyXG5cdC8vIFJ1biB0aGUgc3RhbmRhcmQgaW5pdGlhbGl6ZXJcclxuXHRmdW5jdGlvbiBpbml0aWFsaXplICggdGFyZ2V0LCBvcmlnaW5hbE9wdGlvbnMgKSB7XHJcblxyXG5cdFx0aWYgKCAhdGFyZ2V0IHx8ICF0YXJnZXQubm9kZU5hbWUgKSB7XHJcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogY3JlYXRlIHJlcXVpcmVzIGEgc2luZ2xlIGVsZW1lbnQsIGdvdDogXCIgKyB0YXJnZXQpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFRocm93IGFuIGVycm9yIGlmIHRoZSBzbGlkZXIgd2FzIGFscmVhZHkgaW5pdGlhbGl6ZWQuXHJcblx0XHRpZiAoIHRhcmdldC5ub1VpU2xpZGVyICkge1xyXG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6IFNsaWRlciB3YXMgYWxyZWFkeSBpbml0aWFsaXplZC5cIik7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gVGVzdCB0aGUgb3B0aW9ucyBhbmQgY3JlYXRlIHRoZSBzbGlkZXIgZW52aXJvbm1lbnQ7XHJcblx0XHR2YXIgb3B0aW9ucyA9IHRlc3RPcHRpb25zKCBvcmlnaW5hbE9wdGlvbnMsIHRhcmdldCApO1xyXG5cdFx0dmFyIGFwaSA9IHNjb3BlKCB0YXJnZXQsIG9wdGlvbnMsIG9yaWdpbmFsT3B0aW9ucyApO1xyXG5cclxuXHRcdHRhcmdldC5ub1VpU2xpZGVyID0gYXBpO1xyXG5cclxuXHRcdHJldHVybiBhcGk7XHJcblx0fVxyXG5cclxuXHQvLyBVc2UgYW4gb2JqZWN0IGluc3RlYWQgb2YgYSBmdW5jdGlvbiBmb3IgZnV0dXJlIGV4cGFuZGFiaWxpdHk7XHJcblx0cmV0dXJuIHtcclxuXHRcdHZlcnNpb246IFZFUlNJT04sXHJcblx0XHRjcmVhdGU6IGluaXRpYWxpemVcclxuXHR9O1xyXG5cclxufSkpOyIsIihmdW5jdGlvbiAoZ2xvYmFsKXtcblxudmFyICQgXHRcdFx0XHQ9ICh0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93WydqUXVlcnknXSA6IHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWxbJ2pRdWVyeSddIDogbnVsbCk7XG52YXIgc3RhdGUgXHRcdFx0PSByZXF1aXJlKCcuL3N0YXRlJyk7XG52YXIgcHJvY2Vzc19mb3JtIFx0PSByZXF1aXJlKCcuL3Byb2Nlc3NfZm9ybScpO1xudmFyIG5vVWlTbGlkZXJcdFx0PSByZXF1aXJlKCdub3Vpc2xpZGVyJyk7XG4vL3ZhciBjb29raWVzICAgICAgICAgPSByZXF1aXJlKCdqcy1jb29raWUnKTtcbnZhciB0aGlyZFBhcnR5ICAgICAgPSByZXF1aXJlKCcuL3RoaXJkcGFydHknKTtcblxud2luZG93LnNlYXJjaEFuZEZpbHRlciA9IHtcbiAgICBleHRlbnNpb25zOiBbXSxcbiAgICByZWdpc3RlckV4dGVuc2lvbjogZnVuY3Rpb24oIGV4dGVuc2lvbk5hbWUgKSB7XG4gICAgICAgIHRoaXMuZXh0ZW5zaW9ucy5wdXNoKCBleHRlbnNpb25OYW1lICk7XG4gICAgfVxufTtcblxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbihvcHRpb25zKVxue1xuICAgIHZhciBkZWZhdWx0cyA9IHtcbiAgICAgICAgc3RhcnRPcGVuZWQ6IGZhbHNlLFxuICAgICAgICBpc0luaXQ6IHRydWUsXG4gICAgICAgIGFjdGlvbjogXCJcIlxuICAgIH07XG5cbiAgICB2YXIgb3B0cyA9IGpRdWVyeS5leHRlbmQoZGVmYXVsdHMsIG9wdGlvbnMpO1xuICAgIFxuICAgIHRoaXJkUGFydHkuaW5pdCgpO1xuICAgIFxuICAgIC8vbG9vcCB0aHJvdWdoIGVhY2ggaXRlbSBtYXRjaGVkXG4gICAgdGhpcy5lYWNoKGZ1bmN0aW9uKClcbiAgICB7XG5cbiAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcbiAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xuICAgICAgICB0aGlzLnNmaWQgPSAkdGhpcy5hdHRyKFwiZGF0YS1zZi1mb3JtLWlkXCIpO1xuXG4gICAgICAgIHN0YXRlLmFkZFNlYXJjaEZvcm0odGhpcy5zZmlkLCB0aGlzKTtcblxuICAgICAgICB0aGlzLiRmaWVsZHMgPSAkdGhpcy5maW5kKFwiPiB1bCA+IGxpXCIpOyAvL2EgcmVmZXJlbmNlIHRvIGVhY2ggZmllbGRzIHBhcmVudCBMSVxuXG4gICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gJHRoaXMuYXR0cignZGF0YS10YXhvbm9teS1hcmNoaXZlcycpO1xuICAgICAgICB0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSA9ICR0aGlzLmF0dHIoJ2RhdGEtY3VycmVudC10YXhvbm9teS1hcmNoaXZlJyk7XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMgPSBcIjBcIjtcbiAgICAgICAgfVxuICAgICAgICBpZih0eXBlb2YodGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSA9IFwiXCI7XG4gICAgICAgIH1cblxuICAgICAgICBwcm9jZXNzX2Zvcm0uaW5pdChzZWxmLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcywgc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUpO1xuICAgICAgICAvL3Byb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmKTtcbiAgICAgICAgcHJvY2Vzc19mb3JtLmVuYWJsZUlucHV0cyhzZWxmKTtcblxuICAgICAgICBpZih0eXBlb2YodGhpcy5leHRyYV9xdWVyeV9wYXJhbXMpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyA9IHthbGw6IHt9LCByZXN1bHRzOiB7fSwgYWpheDoge319O1xuICAgICAgICB9XG5cblxuICAgICAgICB0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCA9ICR0aGlzLmF0dHIoXCJkYXRhLXRlbXBsYXRlLWxvYWRlZFwiKTtcbiAgICAgICAgdGhpcy5pc19hamF4ID0gJHRoaXMuYXR0cihcImRhdGEtYWpheFwiKTtcbiAgICAgICAgdGhpcy5pbnN0YW5jZV9udW1iZXIgPSAkdGhpcy5hdHRyKCdkYXRhLWluc3RhbmNlLWNvdW50Jyk7XG4gICAgICAgIHRoaXMuJGFqYXhfcmVzdWx0c19jb250YWluZXIgPSBqUXVlcnkoJHRoaXMuYXR0cihcImRhdGEtYWpheC10YXJnZXRcIikpO1xuXG4gICAgICAgIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXVwZGF0ZS1zZWN0aW9uc1wiKSA/IEpTT04ucGFyc2UoICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdXBkYXRlLXNlY3Rpb25zXCIpICkgOiBbXTtcbiAgICAgICAgdGhpcy5yZXBsYWNlX3Jlc3VsdHMgPSAkdGhpcy5hdHRyKFwiZGF0YS1yZXBsYWNlLXJlc3VsdHNcIikgPT09IFwiMFwiID8gZmFsc2UgOiB0cnVlO1xuICAgICAgICBcbiAgICAgICAgdGhpcy5yZXN1bHRzX3VybCA9ICR0aGlzLmF0dHIoXCJkYXRhLXJlc3VsdHMtdXJsXCIpO1xuICAgICAgICB0aGlzLmRlYnVnX21vZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWJ1Zy1tb2RlXCIpO1xuICAgICAgICB0aGlzLnVwZGF0ZV9hamF4X3VybCA9ICR0aGlzLmF0dHIoXCJkYXRhLXVwZGF0ZS1hamF4LXVybFwiKTtcbiAgICAgICAgdGhpcy5wYWdpbmF0aW9uX3R5cGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXBhZ2luYXRpb24tdHlwZVwiKTtcbiAgICAgICAgdGhpcy5hdXRvX2NvdW50ID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by1jb3VudFwiKTtcbiAgICAgICAgdGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWF1dG8tY291bnQtcmVmcmVzaC1tb2RlXCIpO1xuICAgICAgICB0aGlzLm9ubHlfcmVzdWx0c19hamF4ID0gJHRoaXMuYXR0cihcImRhdGEtb25seS1yZXN1bHRzLWFqYXhcIik7IC8vaWYgd2UgYXJlIG5vdCBvbiB0aGUgcmVzdWx0cyBwYWdlLCByZWRpcmVjdCByYXRoZXIgdGhhbiB0cnkgdG8gbG9hZCB2aWEgYWpheFxuICAgICAgICB0aGlzLnNjcm9sbF90b19wb3MgPSAkdGhpcy5hdHRyKFwiZGF0YS1zY3JvbGwtdG8tcG9zXCIpO1xuICAgICAgICB0aGlzLmN1c3RvbV9zY3JvbGxfdG8gPSAkdGhpcy5hdHRyKFwiZGF0YS1jdXN0b20tc2Nyb2xsLXRvXCIpO1xuICAgICAgICB0aGlzLnNjcm9sbF9vbl9hY3Rpb24gPSAkdGhpcy5hdHRyKFwiZGF0YS1zY3JvbGwtb24tYWN0aW9uXCIpO1xuICAgICAgICB0aGlzLmxhbmdfY29kZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWxhbmctY29kZVwiKTtcbiAgICAgICAgdGhpcy5hamF4X3VybCA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC11cmwnKTtcbiAgICAgICAgdGhpcy5hamF4X2Zvcm1fdXJsID0gJHRoaXMuYXR0cignZGF0YS1hamF4LWZvcm0tdXJsJyk7XG4gICAgICAgIHRoaXMuaXNfcnRsID0gJHRoaXMuYXR0cignZGF0YS1pcy1ydGwnKTtcblxuICAgICAgICB0aGlzLmRpc3BsYXlfcmVzdWx0X21ldGhvZCA9ICR0aGlzLmF0dHIoJ2RhdGEtZGlzcGxheS1yZXN1bHQtbWV0aG9kJyk7XG4gICAgICAgIHRoaXMubWFpbnRhaW5fc3RhdGUgPSAkdGhpcy5hdHRyKCdkYXRhLW1haW50YWluLXN0YXRlJyk7XG4gICAgICAgIHRoaXMuYWpheF9hY3Rpb24gPSBcIlwiO1xuICAgICAgICB0aGlzLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IFwiXCI7XG5cbiAgICAgICAgdGhpcy5jdXJyZW50X3BhZ2VkID0gcGFyc2VJbnQoJHRoaXMuYXR0cignZGF0YS1pbml0LXBhZ2VkJykpO1xuICAgICAgICB0aGlzLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBcIlwiO1xuICAgICAgICB0aGlzLmxvYWRfbW9yZV9odG1sID0gXCJcIjtcbiAgICAgICAgdGhpcy5hamF4X2RhdGFfdHlwZSA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC1kYXRhLXR5cGUnKTtcbiAgICAgICAgdGhpcy5hamF4X3RhcmdldF9hdHRyID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC10YXJnZXRcIik7XG4gICAgICAgIHRoaXMudXNlX2hpc3RvcnlfYXBpID0gJHRoaXMuYXR0cihcImRhdGEtdXNlLWhpc3RvcnktYXBpXCIpO1xuICAgICAgICB0aGlzLmlzX3N1Ym1pdHRpbmcgPSBmYWxzZTtcblxuICAgICAgICB0aGlzLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcblxuICAgICAgICBpZih0eXBlb2YodGhpcy5yZXN1bHRzX2h0bWwpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLnJlc3VsdHNfaHRtbCA9IFwiXCI7XG4gICAgICAgIH1cblxuICAgICAgICBpZih0eXBlb2YodGhpcy5yZXN1bHRzX3BhZ2VfaHRtbCk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMucmVzdWx0c19wYWdlX2h0bWwgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMudXNlX2hpc3RvcnlfYXBpKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy51c2VfaGlzdG9yeV9hcGkgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMucGFnaW5hdGlvbl90eXBlKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5wYWdpbmF0aW9uX3R5cGUgPSBcIm5vcm1hbFwiO1xuICAgICAgICB9XG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1cnJlbnRfcGFnZWQpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmN1cnJlbnRfcGFnZWQgPSAxO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF90YXJnZXRfYXR0cik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuYWpheF90YXJnZXRfYXR0ciA9IFwiXCI7XG4gICAgICAgIH1cblxuICAgICAgICBpZih0eXBlb2YodGhpcy5hamF4X3VybCk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuYWpheF91cmwgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF9mb3JtX3VybCk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuYWpheF9mb3JtX3VybCA9IFwiXCI7XG4gICAgICAgIH1cblxuICAgICAgICBpZih0eXBlb2YodGhpcy5yZXN1bHRzX3VybCk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMucmVzdWx0c191cmwgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuc2Nyb2xsX3RvX3Bvcyk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuc2Nyb2xsX3RvX3BvcyA9IFwiXCI7XG4gICAgICAgIH1cblxuICAgICAgICBpZih0eXBlb2YodGhpcy5zY3JvbGxfb25fYWN0aW9uKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5zY3JvbGxfb25fYWN0aW9uID0gXCJcIjtcbiAgICAgICAgfVxuICAgICAgICBpZih0eXBlb2YodGhpcy5jdXN0b21fc2Nyb2xsX3RvKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy5jdXN0b21fc2Nyb2xsX3RvID0gXCJcIjtcbiAgICAgICAgfVxuICAgICAgICB0aGlzLiRjdXN0b21fc2Nyb2xsX3RvID0galF1ZXJ5KHRoaXMuY3VzdG9tX3Njcm9sbF90byk7XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMudXBkYXRlX2FqYXhfdXJsKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgdGhpcy51cGRhdGVfYWpheF91cmwgPSBcIlwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZGVidWdfbW9kZSk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuZGVidWdfbW9kZSA9IFwiXCI7XG4gICAgICAgIH1cblxuICAgICAgICBpZih0eXBlb2YodGhpcy5hamF4X3RhcmdldF9vYmplY3QpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmFqYXhfdGFyZ2V0X29iamVjdCA9IFwiXCI7XG4gICAgICAgIH1cblxuICAgICAgICBpZih0eXBlb2YodGhpcy50ZW1wbGF0ZV9pc19sb2FkZWQpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCA9IFwiMFwiO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGUpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlID0gXCIwXCI7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmFqYXhfbGlua3Nfc2VsZWN0b3IgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LWxpbmtzLXNlbGVjdG9yXCIpO1xuXG5cbiAgICAgICAgdGhpcy5hdXRvX3VwZGF0ZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWF1dG8tdXBkYXRlXCIpO1xuICAgICAgICB0aGlzLmlucHV0VGltZXIgPSAwO1xuXG4gICAgICAgIHRoaXMuc2V0SW5maW5pdGVTY3JvbGxDb250YWluZXIgPSBmdW5jdGlvbigpXG4gICAgICAgIHtcbiAgICAgICAgICAgIC8vIFdoZW4gd2UgbmF2aWdhdGUgYXdheSBmcm9tIHNlYXJjaCByZXN1bHRzLCBhbmQgdGhlbiBwcmVzcyBiYWNrLFxuICAgICAgICAgICAgLy8gaXNfbWF4X3BhZ2VkIGlzIHJldGFpbmVkLCBzbyB3ZSBvbmx5IHdhbnQgdG8gc2V0IGl0IHRvIGZhbHNlIGlmXG4gICAgICAgICAgICAvLyB3ZSBhcmUgaW5pdGFsaXppbmcgdGhlIHJlc3VsdHMgcGFnZSB0aGUgZmlyc3QgdGltZSAtIHNvIGp1c3QgXG4gICAgICAgICAgICAvLyBjaGVjayBpZiB0aGlzIHZhciBpcyB1bmRlZmluZWQgKGFzIGl0IHNob3VsZCBiZSBvbiBmaXJzdCB1c2UpO1xuICAgICAgICAgICAgaWYgKCB0eXBlb2YgKCB0aGlzLmlzX21heF9wYWdlZCApID09PSAndW5kZWZpbmVkJyApIHtcbiAgICAgICAgICAgICAgICB0aGlzLmlzX21heF9wYWdlZCA9IGZhbHNlOyAvL2ZvciBsb2FkIG1vcmUgb25seSwgb25jZSB3ZSBkZXRlY3Qgd2UncmUgYXQgdGhlIGVuZCBzZXQgdGhpcyB0byB0cnVlXG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHRoaXMudXNlX3Njcm9sbF9sb2FkZXIgPSAkdGhpcy5hdHRyKCdkYXRhLXNob3ctc2Nyb2xsLWxvYWRlcicpO1xuICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyID0gJHRoaXMuYXR0cignZGF0YS1pbmZpbml0ZS1zY3JvbGwtY29udGFpbmVyJyk7XG4gICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLXRyaWdnZXInKTtcbiAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLXJlc3VsdC1jbGFzcycpO1xuICAgICAgICAgICAgdGhpcy4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IHRoaXMuJGFqYXhfcmVzdWx0c19jb250YWluZXI7XG5cbiAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IFwiXCI7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdGhpcy4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IGpRdWVyeSh0aGlzLmFqYXhfdGFyZ2V0X2F0dHIgKyAnICcgKyB0aGlzLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZih0eXBlb2YodGhpcy5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MgPSBcIlwiO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZih0eXBlb2YodGhpcy51c2Vfc2Nyb2xsX2xvYWRlcik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9IDE7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgfTtcbiAgICAgICAgdGhpcy5zZXRJbmZpbml0ZVNjcm9sbENvbnRhaW5lcigpO1xuXG4gICAgICAgIC8qIGZ1bmN0aW9ucyAqL1xuXG4gICAgICAgIHRoaXMucmVzZXQgPSBmdW5jdGlvbihzdWJtaXRfZm9ybSlcbiAgICAgICAge1xuXG4gICAgICAgICAgICB0aGlzLnJlc2V0Rm9ybShzdWJtaXRfZm9ybSk7XG4gICAgICAgICAgICByZXR1cm4gdHJ1ZTtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuaW5wdXRVcGRhdGUgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZih0eXBlb2YoZGVsYXlEdXJhdGlvbik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGRlbGF5RHVyYXRpb24gPSAzMDA7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHNlbGYucmVzZXRUaW1lcihkZWxheUR1cmF0aW9uKTtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuc2Nyb2xsVG9Qb3MgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIHZhciBvZmZzZXQgPSAwO1xuICAgICAgICAgICAgdmFyIGNhblNjcm9sbCA9IHRydWU7XG5cbiAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZihzZWxmLnNjcm9sbF90b19wb3M9PVwid2luZG93XCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAwO1xuXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImZvcm1cIilcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIG9mZnNldCA9ICR0aGlzLm9mZnNldCgpLnRvcDtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZSBpZihzZWxmLnNjcm9sbF90b19wb3M9PVwicmVzdWx0c1wiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg+MClcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgb2Zmc2V0ID0gc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5vZmZzZXQoKS50b3A7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZSBpZihzZWxmLnNjcm9sbF90b19wb3M9PVwiY3VzdG9tXCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAvL2N1c3RvbV9zY3JvbGxfdG9cbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi4kY3VzdG9tX3Njcm9sbF90by5sZW5ndGg+MClcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgb2Zmc2V0ID0gc2VsZi4kY3VzdG9tX3Njcm9sbF90by5vZmZzZXQoKS50b3A7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgY2FuU2Nyb2xsID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYoY2FuU2Nyb2xsKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgJChcImh0bWwsIGJvZHlcIikuc3RvcCgpLmFuaW1hdGUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgc2Nyb2xsVG9wOiBvZmZzZXRcbiAgICAgICAgICAgICAgICAgICAgfSwgXCJub3JtYWxcIiwgXCJlYXNlT3V0UXVhZFwiICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuXG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5hdHRhY2hBY3RpdmVDbGFzcyA9IGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgIC8vY2hlY2sgdG8gc2VlIGlmIHdlIGFyZSB1c2luZyBhamF4ICYgYXV0byBjb3VudFxuICAgICAgICAgICAgLy9pZiBub3QsIHRoZSBzZWFyY2ggZm9ybSBkb2VzIG5vdCBnZXQgcmVsb2FkZWQsIHNvIHdlIG5lZWQgdG8gdXBkYXRlIHRoZSBzZi1vcHRpb24tYWN0aXZlIGNsYXNzIG9uIGFsbCBmaWVsZHNcblxuICAgICAgICAgICAgJHRoaXMub24oJ2NoYW5nZScsICdpbnB1dFt0eXBlPVwicmFkaW9cIl0sIGlucHV0W3R5cGU9XCJjaGVja2JveFwiXSwgc2VsZWN0JywgZnVuY3Rpb24oZSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgJGN0aGlzID0gJCh0aGlzKTtcbiAgICAgICAgICAgICAgICB2YXIgJGN0aGlzX3BhcmVudCA9ICRjdGhpcy5jbG9zZXN0KFwibGlbZGF0YS1zZi1maWVsZC1uYW1lXVwiKTtcbiAgICAgICAgICAgICAgICB2YXIgdGhpc190YWcgPSAkY3RoaXMucHJvcChcInRhZ05hbWVcIikudG9Mb3dlckNhc2UoKTtcbiAgICAgICAgICAgICAgICB2YXIgaW5wdXRfdHlwZSA9ICRjdGhpcy5hdHRyKFwidHlwZVwiKTtcbiAgICAgICAgICAgICAgICB2YXIgcGFyZW50X3RhZyA9ICRjdGhpc19wYXJlbnQucHJvcChcInRhZ05hbWVcIikudG9Mb3dlckNhc2UoKTtcblxuICAgICAgICAgICAgICAgIGlmKCh0aGlzX3RhZz09XCJpbnB1dFwiKSYmKChpbnB1dF90eXBlPT1cInJhZGlvXCIpfHwoaW5wdXRfdHlwZT09XCJjaGVja2JveFwiKSkgJiYgKHBhcmVudF90YWc9PVwibGlcIikpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICB2YXIgJGFsbF9vcHRpb25zID0gJGN0aGlzX3BhcmVudC5wYXJlbnQoKS5maW5kKCdsaScpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgJGFsbF9vcHRpb25zX2ZpZWxkcyA9ICRjdGhpc19wYXJlbnQucGFyZW50KCkuZmluZCgnaW5wdXQ6Y2hlY2tlZCcpO1xuXG4gICAgICAgICAgICAgICAgICAgICRhbGxfb3B0aW9ucy5yZW1vdmVDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XG4gICAgICAgICAgICAgICAgICAgICRhbGxfb3B0aW9uc19maWVsZHMuZWFjaChmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHBhcmVudCA9ICQodGhpcykuY2xvc2VzdChcImxpXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgJHBhcmVudC5hZGRDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XG5cbiAgICAgICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZSBpZih0aGlzX3RhZz09XCJzZWxlY3RcIilcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXMuY2hpbGRyZW4oKTtcbiAgICAgICAgICAgICAgICAgICAgJGFsbF9vcHRpb25zLnJlbW92ZUNsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRoaXNfdmFsID0gJGN0aGlzLnZhbCgpO1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciB0aGlzX2Fycl92YWwgPSAodHlwZW9mIHRoaXNfdmFsID09ICdzdHJpbmcnIHx8IHRoaXNfdmFsIGluc3RhbmNlb2YgU3RyaW5nKSA/IFt0aGlzX3ZhbF0gOiB0aGlzX3ZhbDtcblxuICAgICAgICAgICAgICAgICAgICAkKHRoaXNfYXJyX3ZhbCkuZWFjaChmdW5jdGlvbihpLCB2YWx1ZSl7XG4gICAgICAgICAgICAgICAgICAgICAgICAkY3RoaXMuZmluZChcIm9wdGlvblt2YWx1ZT0nXCIrdmFsdWUrXCInXVwiKS5hZGRDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XG4gICAgICAgICAgICAgICAgICAgIH0pO1xuXG5cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9O1xuICAgICAgICB0aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzID0gZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgLyogYXV0byB1cGRhdGUgKi9cbiAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdjaGFuZ2UnLCAnaW5wdXRbdHlwZT1cInJhZGlvXCJdLCBpbnB1dFt0eXBlPVwiY2hlY2tib3hcIl0sIHNlbGVjdCcsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgyMDApO1xuICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgJHRoaXMub24oJ2lucHV0JywgJ2lucHV0W3R5cGU9XCJudW1iZXJcIl0nLCBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoODAwKTtcbiAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgIHZhciAkdGV4dElucHV0ID0gJHRoaXMuZmluZCgnaW5wdXRbdHlwZT1cInRleHRcIl06bm90KC5zZi1kYXRlcGlja2VyKScpO1xuICAgICAgICAgICAgICAgIHZhciBsYXN0VmFsdWUgPSAkdGV4dElucHV0LnZhbCgpO1xuXG4gICAgICAgICAgICAgICAgJHRoaXMub24oJ2lucHV0JywgJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOm5vdCguc2YtZGF0ZXBpY2tlciknLCBmdW5jdGlvbigpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZihsYXN0VmFsdWUhPSR0ZXh0SW5wdXQudmFsKCkpXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMTIwMCk7XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBsYXN0VmFsdWUgPSAkdGV4dElucHV0LnZhbCgpO1xuICAgICAgICAgICAgICAgIH0pO1xuXG5cbiAgICAgICAgICAgICAgICAkdGhpcy5vbigna2V5cHJlc3MnLCAnaW5wdXRbdHlwZT1cInRleHRcIl06bm90KC5zZi1kYXRlcGlja2VyKScsIGZ1bmN0aW9uKGUpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZiAoZS53aGljaCA9PSAxMyl7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgIC8vJHRoaXMub24oJ2lucHV0JywgJ2lucHV0LnNmLWRhdGVwaWNrZXInLCBzZWxmLmRhdGVJbnB1dFR5cGUpO1xuXG4gICAgICAgICAgICB9XG4gICAgICAgIH07XG5cbiAgICAgICAgLy90aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzKCk7XG5cblxuICAgICAgICB0aGlzLmNsZWFyVGltZXIgPSBmdW5jdGlvbigpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGNsZWFyVGltZW91dChzZWxmLmlucHV0VGltZXIpO1xuICAgICAgICB9O1xuICAgICAgICB0aGlzLnJlc2V0VGltZXIgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxuICAgICAgICB7XG4gICAgICAgICAgICBjbGVhclRpbWVvdXQoc2VsZi5pbnB1dFRpbWVyKTtcbiAgICAgICAgICAgIHNlbGYuaW5wdXRUaW1lciA9IHNldFRpbWVvdXQoc2VsZi5mb3JtVXBkYXRlZCwgZGVsYXlEdXJhdGlvbik7XG5cbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmFkZERhdGVQaWNrZXJzID0gZnVuY3Rpb24oKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgJGRhdGVfcGlja2VyID0gJHRoaXMuZmluZChcIi5zZi1kYXRlcGlja2VyXCIpO1xuXG4gICAgICAgICAgICBpZigkZGF0ZV9waWNrZXIubGVuZ3RoPjApXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgJGRhdGVfcGlja2VyLmVhY2goZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZUZvcm1hdCA9IFwiXCI7XG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRHJvcGRvd25ZZWFyID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRHJvcGRvd25Nb250aCA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciAkY2xvc2VzdF9kYXRlX3dyYXAgPSAkdGhpcy5jbG9zZXN0KFwiLnNmX2RhdGVfZmllbGRcIik7XG4gICAgICAgICAgICAgICAgICAgIGlmKCRjbG9zZXN0X2RhdGVfd3JhcC5sZW5ndGg+MClcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZUZvcm1hdCA9ICRjbG9zZXN0X2RhdGVfd3JhcC5hdHRyKFwiZGF0YS1kYXRlLWZvcm1hdFwiKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtdXNlLXllYXItZHJvcGRvd25cIik9PTEpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZURyb3Bkb3duWWVhciA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS11c2UtbW9udGgtZHJvcGRvd25cIik9PTEpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZURyb3Bkb3duTW9udGggPSB0cnVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGVQaWNrZXJPcHRpb25zID0ge1xuICAgICAgICAgICAgICAgICAgICAgICAgaW5saW5lOiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICAgICAgc2hvd090aGVyTW9udGhzOiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICAgICAgb25TZWxlY3Q6IGZ1bmN0aW9uKGUsIGZyb21fZmllbGQpeyBzZWxmLmRhdGVTZWxlY3QoZSwgZnJvbV9maWVsZCwgJCh0aGlzKSk7IH0sXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlRm9ybWF0OiBkYXRlRm9ybWF0LFxuXG4gICAgICAgICAgICAgICAgICAgICAgICBjaGFuZ2VNb250aDogZGF0ZURyb3Bkb3duTW9udGgsXG4gICAgICAgICAgICAgICAgICAgICAgICBjaGFuZ2VZZWFyOiBkYXRlRHJvcGRvd25ZZWFyXG4gICAgICAgICAgICAgICAgICAgIH07XG5cbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVQaWNrZXJPcHRpb25zLmRpcmVjdGlvbiA9IFwicnRsXCI7XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5kYXRlcGlja2VyKGRhdGVQaWNrZXJPcHRpb25zKTtcblxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnNldERlZmF1bHRzKFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuZXh0ZW5kKFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7J2RhdGVGb3JtYXQnOmRhdGVGb3JtYXR9LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIucmVnaW9uYWxbIHNlbGYubGFuZ19jb2RlXVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICAgICAgICAgICk7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5zZXREZWZhdWx0cyhcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmV4dGVuZChcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeydkYXRlRm9ybWF0JzpkYXRlRm9ybWF0fSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnJlZ2lvbmFsW1wiZW5cIl1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgICAgICAgICApO1xuXG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgaWYoJCgnLmxsLXNraW4tbWVsb24nKS5sZW5ndGg9PTApe1xuXG4gICAgICAgICAgICAgICAgICAgICRkYXRlX3BpY2tlci5kYXRlcGlja2VyKCd3aWRnZXQnKS53cmFwKCc8ZGl2IGNsYXNzPVwibGwtc2tpbi1tZWxvbiBzZWFyY2hhbmRmaWx0ZXItZGF0ZS1waWNrZXJcIi8+Jyk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB9XG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5kYXRlU2VsZWN0ID0gZnVuY3Rpb24oZSwgZnJvbV9maWVsZCwgJHRoaXMpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHZhciAkaW5wdXRfZmllbGQgPSAkKGZyb21fZmllbGQuaW5wdXQuZ2V0KDApKTtcbiAgICAgICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XG5cbiAgICAgICAgICAgIHZhciAkZGF0ZV9maWVsZHMgPSAkaW5wdXRfZmllbGQuY2xvc2VzdCgnW2RhdGEtc2YtZmllbGQtaW5wdXQtdHlwZT1cImRhdGVyYW5nZVwiXSwgW2RhdGEtc2YtZmllbGQtaW5wdXQtdHlwZT1cImRhdGVcIl0nKTtcbiAgICAgICAgICAgICRkYXRlX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGUsIGluZGV4KXtcbiAgICAgICAgICAgICAgICBcbiAgICAgICAgICAgICAgICB2YXIgJHRmX2RhdGVfcGlja2VycyA9ICQodGhpcykuZmluZChcIi5zZi1kYXRlcGlja2VyXCIpO1xuICAgICAgICAgICAgICAgIHZhciBub19kYXRlX3BpY2tlcnMgPSAkdGZfZGF0ZV9waWNrZXJzLmxlbmd0aDtcbiAgICAgICAgICAgICAgICBcbiAgICAgICAgICAgICAgICBpZihub19kYXRlX3BpY2tlcnM+MSlcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIC8vdGhlbiBpdCBpcyBhIGRhdGUgcmFuZ2UsIHNvIG1ha2Ugc3VyZSBib3RoIGZpZWxkcyBhcmUgZmlsbGVkIGJlZm9yZSB1cGRhdGluZ1xuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfY291bnRlciA9IDA7XG4gICAgICAgICAgICAgICAgICAgIHZhciBkcF9lbXB0eV9maWVsZF9jb3VudCA9IDA7XG4gICAgICAgICAgICAgICAgICAgICR0Zl9kYXRlX3BpY2tlcnMuZWFjaChmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkKHRoaXMpLnZhbCgpPT1cIlwiKVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRwX2VtcHR5X2ZpZWxkX2NvdW50Kys7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGRwX2NvdW50ZXIrKztcbiAgICAgICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYoZHBfZW1wdHlfZmllbGRfY291bnQ9PTApXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMSk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgxKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuYWRkUmFuZ2VTbGlkZXJzID0gZnVuY3Rpb24oKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgJG1ldGFfcmFuZ2UgPSAkdGhpcy5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xuXG4gICAgICAgICAgICBpZigkbWV0YV9yYW5nZS5sZW5ndGg+MClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAkbWV0YV9yYW5nZS5lYWNoKGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1pbiA9ICR0aGlzLmF0dHIoXCJkYXRhLW1pblwiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1heCA9ICR0aGlzLmF0dHIoXCJkYXRhLW1heFwiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtaW4gPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1taW5cIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBzbWF4ID0gJHRoaXMuYXR0cihcImRhdGEtc3RhcnQtbWF4XCIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgZGlzcGxheV92YWx1ZV9hcyA9ICR0aGlzLmF0dHIoXCJkYXRhLWRpc3BsYXktdmFsdWVzLWFzXCIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgc3RlcCA9ICR0aGlzLmF0dHIoXCJkYXRhLXN0ZXBcIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciAkc3RhcnRfdmFsID0gJHRoaXMuZmluZCgnLnNmLXJhbmdlLW1pbicpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgJGVuZF92YWwgPSAkdGhpcy5maW5kKCcuc2YtcmFuZ2UtbWF4Jyk7XG5cblxuICAgICAgICAgICAgICAgICAgICB2YXIgZGVjaW1hbF9wbGFjZXMgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWNpbWFsLXBsYWNlc1wiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRob3VzYW5kX3NlcGVyYXRvciA9ICR0aGlzLmF0dHIoXCJkYXRhLXRob3VzYW5kLXNlcGVyYXRvclwiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRlY2ltYWxfc2VwZXJhdG9yID0gJHRoaXMuYXR0cihcImRhdGEtZGVjaW1hbC1zZXBlcmF0b3JcIik7XG5cbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX2Zvcm1hdCA9IHdOdW1iKHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG1hcms6IGRlY2ltYWxfc2VwZXJhdG9yLFxuICAgICAgICAgICAgICAgICAgICAgICAgZGVjaW1hbHM6IHBhcnNlRmxvYXQoZGVjaW1hbF9wbGFjZXMpLFxuICAgICAgICAgICAgICAgICAgICAgICAgdGhvdXNhbmQ6IHRob3VzYW5kX3NlcGVyYXRvclxuICAgICAgICAgICAgICAgICAgICB9KTtcblxuXG5cbiAgICAgICAgICAgICAgICAgICAgdmFyIG1pbl91bmZvcm1hdHRlZCA9IHBhcnNlRmxvYXQoc21pbik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21pbikpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgbWF4X2Zvcm1hdHRlZCA9IGZpZWxkX2Zvcm1hdC50byhwYXJzZUZsb2F0KHNtYXgpKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1heF91bmZvcm1hdHRlZCA9IHBhcnNlRmxvYXQoc21heCk7XG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQobWluX2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQobWF4X2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQoZGlzcGxheV92YWx1ZV9hcyk7XG5cblxuICAgICAgICAgICAgICAgICAgICBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRpbnB1dFwiKVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLnZhbChtaW5fZm9ybWF0dGVkKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLnZhbChtYXhfZm9ybWF0dGVkKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGRpc3BsYXlfdmFsdWVfYXM9PVwidGV4dFwiKVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5odG1sKG1heF9mb3JtYXR0ZWQpO1xuICAgICAgICAgICAgICAgICAgICB9XG5cblxuICAgICAgICAgICAgICAgICAgICB2YXIgbm9VSU9wdGlvbnMgPSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByYW5nZToge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICdtaW4nOiBbIHBhcnNlRmxvYXQobWluKSBdLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICdtYXgnOiBbIHBhcnNlRmxvYXQobWF4KSBdXG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgc3RhcnQ6IFttaW5fZm9ybWF0dGVkLCBtYXhfZm9ybWF0dGVkXSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGhhbmRsZXM6IDIsXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25uZWN0OiB0cnVlLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3RlcDogcGFyc2VGbG9hdChzdGVwKSxcblxuICAgICAgICAgICAgICAgICAgICAgICAgYmVoYXZpb3VyOiAnZXh0ZW5kLXRhcCcsXG4gICAgICAgICAgICAgICAgICAgICAgICBmb3JtYXQ6IGZpZWxkX2Zvcm1hdFxuICAgICAgICAgICAgICAgICAgICB9O1xuXG5cblxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX3J0bD09MSlcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgbm9VSU9wdGlvbnMuZGlyZWN0aW9uID0gXCJydGxcIjtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfb2JqZWN0ID0gJCh0aGlzKS5maW5kKFwiLm1ldGEtc2xpZGVyXCIpWzBdO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmKCBcInVuZGVmaW5lZFwiICE9PSB0eXBlb2YoIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlciApICkge1xuICAgICAgICAgICAgICAgICAgICAgICAgLy9kZXN0cm95IGlmIGl0IGV4aXN0cy4uIHRoaXMgbWVhbnMgc29tZWhvdyBhbm90aGVyIGluc3RhbmNlIGhhZCBpbml0aWFsaXNlZCBpdC4uXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZGVzdHJveSgpO1xuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgbm9VaVNsaWRlci5jcmVhdGUoc2xpZGVyX29iamVjdCwgbm9VSU9wdGlvbnMpO1xuXG4gICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwub2ZmKCk7XG4gICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFskKHRoaXMpLnZhbCgpLCBudWxsXSk7XG4gICAgICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLm9mZigpO1xuICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5vbignY2hhbmdlJywgZnVuY3Rpb24oKXtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoW251bGwsICQodGhpcykudmFsKCldKTtcbiAgICAgICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICAgICAgLy8kc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgIC8vJGVuZF92YWwuaHRtbChtYXhfZm9ybWF0dGVkKTtcblxuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIub2ZmKCd1cGRhdGUnKTtcbiAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLm9uKCd1cGRhdGUnLCBmdW5jdGlvbiggdmFsdWVzLCBoYW5kbGUgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfc3RhcnRfdmFsICA9IG1pbl9mb3JtYXR0ZWQ7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX2VuZF92YWwgID0gbWF4X2Zvcm1hdHRlZDtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHZhbHVlID0gdmFsdWVzW2hhbmRsZV07XG5cblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCBoYW5kbGUgKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbWF4X2Zvcm1hdHRlZCA9IHZhbHVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBtaW5fZm9ybWF0dGVkID0gdmFsdWU7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGRpc3BsYXlfdmFsdWVfYXM9PVwidGV4dGlucHV0XCIpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC52YWwobWluX2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwudmFsKG1heF9mb3JtYXR0ZWQpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRcIilcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwuaHRtbChtYXhfZm9ybWF0dGVkKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2kgdGhpbmsgdGhlIGZ1bmN0aW9uIHRoYXQgYnVpbGRzIHRoZSBVUkwgbmVlZHMgdG8gZGVjb2RlIHRoZSBmb3JtYXR0ZWQgc3RyaW5nIGJlZm9yZSBhZGRpbmcgdG8gdGhlIHVybFxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHNlbGYuYXV0b191cGRhdGU9PTEpfHwoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy9vbmx5IHRyeSB0byB1cGRhdGUgaWYgdGhlIHZhbHVlcyBoYXZlIGFjdHVhbGx5IGNoYW5nZWRcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZigoc2xpZGVyX3N0YXJ0X3ZhbCE9bWluX2Zvcm1hdHRlZCl8fChzbGlkZXJfZW5kX3ZhbCE9bWF4X2Zvcm1hdHRlZCkpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDgwMCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG5cbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7IC8vaWdub3JlIGFueSBjaGFuZ2VzIHJlY2VudGx5IG1hZGUgYnkgdGhlIHNsaWRlciAodGhpcyB3YXMganVzdCBpbml0IHNob3VsZG4ndCBjb3VudCBhcyBhbiB1cGRhdGUgZXZlbnQpXG4gICAgICAgICAgICB9XG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5pbml0ID0gZnVuY3Rpb24oa2VlcF9wYWdpbmF0aW9uKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZih0eXBlb2Yoa2VlcF9wYWdpbmF0aW9uKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIga2VlcF9wYWdpbmF0aW9uID0gZmFsc2U7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHRoaXMuaW5pdEF1dG9VcGRhdGVFdmVudHMoKTtcbiAgICAgICAgICAgIHRoaXMuYXR0YWNoQWN0aXZlQ2xhc3MoKTtcblxuICAgICAgICAgICAgdGhpcy5hZGREYXRlUGlja2VycygpO1xuICAgICAgICAgICAgdGhpcy5hZGRSYW5nZVNsaWRlcnMoKTtcblxuICAgICAgICAgICAgLy9pbml0IGNvbWJvIGJveGVzXG4gICAgICAgICAgICB2YXIgJGNvbWJvYm94ID0gJHRoaXMuZmluZChcInNlbGVjdFtkYXRhLWNvbWJvYm94PScxJ11cIik7XG5cbiAgICAgICAgICAgIGlmKCRjb21ib2JveC5sZW5ndGg+MClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAkY29tYm9ib3guZWFjaChmdW5jdGlvbihpbmRleCApe1xuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNjYiA9ICQoIHRoaXMgKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIG5ybSA9ICR0aGlzY2IuYXR0cihcImRhdGEtY29tYm9ib3gtbnJtXCIpO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmICh0eXBlb2YgJHRoaXNjYi5jaG9zZW4gIT0gXCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGNob3Nlbm9wdGlvbnMgPSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VhcmNoX2NvbnRhaW5zOiB0cnVlXG4gICAgICAgICAgICAgICAgICAgICAgICB9O1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigodHlwZW9mKG5ybSkhPT1cInVuZGVmaW5lZFwiKSYmKG5ybSkpe1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNob3Nlbm9wdGlvbnMubm9fcmVzdWx0c190ZXh0ID0gbnJtO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgLy8gc2FmZSB0byB1c2UgdGhlIGZ1bmN0aW9uXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3NlYXJjaF9jb250YWluc1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNjYi5hZGRDbGFzcyhcImNob3Nlbi1ydGxcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzY2IuY2hvc2VuKGNob3Nlbm9wdGlvbnMpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICAgICAge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgc2VsZWN0Mm9wdGlvbnMgPSB7fTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VsZWN0Mm9wdGlvbnMuZGlyID0gXCJydGxcIjtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCh0eXBlb2YobnJtKSE9PVwidW5kZWZpbmVkXCIpJiYobnJtKSl7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VsZWN0Mm9wdGlvbnMubGFuZ3VhZ2U9IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJub1Jlc3VsdHNcIjogZnVuY3Rpb24oKXtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBucm07XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLnNlbGVjdDIoc2VsZWN0Mm9wdGlvbnMpO1xuICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB9KTtcblxuXG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gZmFsc2U7XG5cbiAgICAgICAgICAgIC8vaWYgYWpheCBpcyBlbmFibGVkIGluaXQgdGhlIHBhZ2luYXRpb25cbiAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLnNldHVwQWpheFBhZ2luYXRpb24oKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgJHRoaXMub24oXCJzdWJtaXRcIiwgdGhpcy5zdWJtaXRGb3JtKTtcblxuICAgICAgICAgICAgc2VsZi5pbml0V29vQ29tbWVyY2VDb250cm9scygpOyAvL3dvb2NvbW1lcmNlIG9yZGVyYnlcblxuICAgICAgICAgICAgaWYoa2VlcF9wYWdpbmF0aW9uPT1mYWxzZSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMub25XaW5kb3dTY3JvbGwgPSBmdW5jdGlvbihldmVudClcbiAgICAgICAge1xuICAgICAgICAgICAgaWYoKCFzZWxmLmlzX2xvYWRpbmdfbW9yZSkgJiYgKCFzZWxmLmlzX21heF9wYWdlZCkpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIHdpbmRvd19zY3JvbGwgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XG4gICAgICAgICAgICAgICAgdmFyIHdpbmRvd19zY3JvbGxfYm90dG9tID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpICsgJCh3aW5kb3cpLmhlaWdodCgpO1xuICAgICAgICAgICAgICAgIHZhciBzY3JvbGxfb2Zmc2V0ID0gcGFyc2VJbnQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfdHJpZ2dlcl9hbW91bnQpO1xuXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5sZW5ndGg9PTEpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c19zY3JvbGxfYm90dG9tID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5vZmZzZXQoKS50b3AgKyBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmhlaWdodCgpO1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciBvZmZzZXQgPSAoc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5vZmZzZXQoKS50b3AgKyBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmhlaWdodCgpKSAtIHdpbmRvd19zY3JvbGw7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYod2luZG93X3Njcm9sbF9ib3R0b20gPiByZXN1bHRzX3Njcm9sbF9ib3R0b20gKyBzY3JvbGxfb2Zmc2V0KVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmxvYWRNb3JlUmVzdWx0cygpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICAgICAgey8vZG9udCBsb2FkIG1vcmVcblxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5zdHJpcFF1ZXJ5U3RyaW5nQW5kSGFzaEZyb21QYXRoID0gZnVuY3Rpb24odXJsKSB7XG4gICAgICAgICAgICByZXR1cm4gdXJsLnNwbGl0KFwiP1wiKVswXS5zcGxpdChcIiNcIilbMF07XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmd1cCA9IGZ1bmN0aW9uKCBuYW1lLCB1cmwgKSB7XG4gICAgICAgICAgICBpZiAoIXVybCkgdXJsID0gbG9jYXRpb24uaHJlZlxuICAgICAgICAgICAgbmFtZSA9IG5hbWUucmVwbGFjZSgvW1xcW10vLFwiXFxcXFxcW1wiKS5yZXBsYWNlKC9bXFxdXS8sXCJcXFxcXFxdXCIpO1xuICAgICAgICAgICAgdmFyIHJlZ2V4UyA9IFwiW1xcXFw/Jl1cIituYW1lK1wiPShbXiYjXSopXCI7XG4gICAgICAgICAgICB2YXIgcmVnZXggPSBuZXcgUmVnRXhwKCByZWdleFMgKTtcbiAgICAgICAgICAgIHZhciByZXN1bHRzID0gcmVnZXguZXhlYyggdXJsICk7XG4gICAgICAgICAgICByZXR1cm4gcmVzdWx0cyA9PSBudWxsID8gbnVsbCA6IHJlc3VsdHNbMV07XG4gICAgICAgIH07XG5cblxuICAgICAgICB0aGlzLmdldFVybFBhcmFtcyA9IGZ1bmN0aW9uKGtlZXBfcGFnaW5hdGlvbiwgdHlwZSwgZXhjbHVkZSlcbiAgICAgICAge1xuICAgICAgICAgICAgaWYodHlwZW9mKGtlZXBfcGFnaW5hdGlvbik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGtlZXBfcGFnaW5hdGlvbiA9IHRydWU7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmKHR5cGVvZih0eXBlKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgdHlwZSA9IFwiXCI7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHZhciB1cmxfcGFyYW1zX3N0ciA9IFwiXCI7XG5cbiAgICAgICAgICAgIC8vIGdldCBhbGwgcGFyYW1zIGZyb20gZmllbGRzXG4gICAgICAgICAgICB2YXIgdXJsX3BhcmFtc19hcnJheSA9IHByb2Nlc3NfZm9ybS5nZXRVcmxQYXJhbXMoc2VsZik7XG5cbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyh1cmxfcGFyYW1zX2FycmF5KS5sZW5ndGg7XG4gICAgICAgICAgICB2YXIgY291bnQgPSAwO1xuXG4gICAgICAgICAgICBpZih0eXBlb2YoZXhjbHVkZSkhPVwidW5kZWZpbmVkXCIpIHtcbiAgICAgICAgICAgICAgICBpZiAodXJsX3BhcmFtc19hcnJheS5oYXNPd25Qcm9wZXJ0eShleGNsdWRlKSkge1xuICAgICAgICAgICAgICAgICAgICBsZW5ndGgtLTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gdXJsX3BhcmFtc19hcnJheSkge1xuICAgICAgICAgICAgICAgICAgICBpZiAodXJsX3BhcmFtc19hcnJheS5oYXNPd25Qcm9wZXJ0eShrKSkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgY2FuX2FkZCA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgICAgICBpZih0eXBlb2YoZXhjbHVkZSkhPVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYoaz09ZXhjbHVkZSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYW5fYWRkID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihjYW5fYWRkKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsX3BhcmFtc19zdHIgKz0gayArIFwiPVwiICsgdXJsX3BhcmFtc19hcnJheVtrXTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChjb3VudCA8IGxlbmd0aCAtIDEpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsX3BhcmFtc19zdHIgKz0gXCImXCI7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY291bnQrKztcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IFwiXCI7XG5cbiAgICAgICAgICAgIC8vZm9ybSBwYXJhbXMgYXMgdXJsIHF1ZXJ5IHN0cmluZ1xuICAgICAgICAgICAgdmFyIGZvcm1fcGFyYW1zID0gdXJsX3BhcmFtc19zdHI7XG5cbiAgICAgICAgICAgIC8vZ2V0IHVybCBwYXJhbXMgZnJvbSB0aGUgZm9ybSBpdHNlbGYgKHdoYXQgdGhlIHVzZXIgaGFzIHNlbGVjdGVkKVxuICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBmb3JtX3BhcmFtcyk7XG5cbiAgICAgICAgICAgIC8vYWRkIHBhZ2luYXRpb25cbiAgICAgICAgICAgIGlmKGtlZXBfcGFnaW5hdGlvbj09dHJ1ZSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIik7XG5cbiAgICAgICAgICAgICAgICBpZih0eXBlb2YocGFnZU51bWJlcik9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBwYWdlTnVtYmVyID0gMTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBpZihwYWdlTnVtYmVyPjEpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrcGFnZU51bWJlcik7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAvL2FkZCBzZmlkXG4gICAgICAgICAgICAvL3F1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJzZmlkPVwiK3NlbGYuc2ZpZCk7XG5cbiAgICAgICAgICAgIC8vIGxvb3AgdGhyb3VnaCBhbnkgZXh0cmEgcGFyYW1zIChmcm9tIGV4dCBwbHVnaW5zKSBhbmQgYWRkIHRvIHRoZSB1cmwgKGllIHdvb2NvbW1lcmNlIGBvcmRlcmJ5YClcbiAgICAgICAgICAgIC8qdmFyIGV4dHJhX3F1ZXJ5X3BhcmFtID0gXCJcIjtcbiAgICAgICAgICAgICB2YXIgbGVuZ3RoID0gT2JqZWN0LmtleXMoc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMpLmxlbmd0aDtcbiAgICAgICAgICAgICB2YXIgY291bnQgPSAwO1xuXG4gICAgICAgICAgICAgaWYobGVuZ3RoPjApXG4gICAgICAgICAgICAge1xuXG4gICAgICAgICAgICAgZm9yICh2YXIgayBpbiBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcykge1xuICAgICAgICAgICAgIGlmIChzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5oYXNPd25Qcm9wZXJ0eShrKSkge1xuXG4gICAgICAgICAgICAgaWYoc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNba10hPVwiXCIpXG4gICAgICAgICAgICAge1xuICAgICAgICAgICAgIGV4dHJhX3F1ZXJ5X3BhcmFtID0gaytcIj1cIitzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1trXTtcbiAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIGV4dHJhX3F1ZXJ5X3BhcmFtKTtcbiAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgKi9cbiAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuYWRkUXVlcnlQYXJhbXMocXVlcnlfcGFyYW1zLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5hbGwpO1xuXG4gICAgICAgICAgICBpZih0eXBlIT1cIlwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhxdWVyeV9wYXJhbXMsIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW3R5cGVdKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgcmV0dXJuIHF1ZXJ5X3BhcmFtcztcbiAgICAgICAgfVxuICAgICAgICB0aGlzLmFkZFF1ZXJ5UGFyYW1zID0gZnVuY3Rpb24ocXVlcnlfcGFyYW1zLCBuZXdfcGFyYW1zKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgZXh0cmFfcXVlcnlfcGFyYW0gPSBcIlwiO1xuICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKG5ld19wYXJhbXMpLmxlbmd0aDtcbiAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XG5cbiAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxuICAgICAgICAgICAge1xuXG4gICAgICAgICAgICAgICAgZm9yICh2YXIgayBpbiBuZXdfcGFyYW1zKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChuZXdfcGFyYW1zLmhhc093blByb3BlcnR5KGspKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKG5ld19wYXJhbXNba10hPVwiXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZXh0cmFfcXVlcnlfcGFyYW0gPSBrK1wiPVwiK25ld19wYXJhbXNba107XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBleHRyYV9xdWVyeV9wYXJhbSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHJldHVybiBxdWVyeV9wYXJhbXM7XG4gICAgICAgIH1cbiAgICAgICAgdGhpcy5hZGRVcmxQYXJhbSA9IGZ1bmN0aW9uKHVybCwgc3RyaW5nKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgYWRkX3BhcmFtcyA9IFwiXCI7XG5cbiAgICAgICAgICAgIGlmKHVybCE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZih1cmwuaW5kZXhPZihcIj9cIikgIT0gLTEpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAvL3VybCA9IHRoaXMudHJhaWxpbmdTbGFzaEl0KHVybCk7XG4gICAgICAgICAgICAgICAgICAgIGFkZF9wYXJhbXMgKz0gXCI/XCI7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXG4gICAgICAgICAgICB7XG5cbiAgICAgICAgICAgICAgICByZXR1cm4gdXJsICsgYWRkX3BhcmFtcyArIHN0cmluZztcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gdXJsO1xuICAgICAgICAgICAgfVxuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuam9pblVybFBhcmFtID0gZnVuY3Rpb24ocGFyYW1zLCBzdHJpbmcpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHZhciBhZGRfcGFyYW1zID0gXCJcIjtcblxuICAgICAgICAgICAgaWYocGFyYW1zIT1cIlwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGFkZF9wYXJhbXMgKz0gXCImXCI7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmKHN0cmluZyE9XCJcIilcbiAgICAgICAgICAgIHtcblxuICAgICAgICAgICAgICAgIHJldHVybiBwYXJhbXMgKyBhZGRfcGFyYW1zICsgc3RyaW5nO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHJldHVybiBwYXJhbXM7XG4gICAgICAgICAgICB9XG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5zZXRBamF4UmVzdWx0c1VSTHMgPSBmdW5jdGlvbihxdWVyeV9wYXJhbXMpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfcmVzdWx0c19jb25mKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mID0gbmV3IEFycmF5KCk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBcIlwiO1xuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IFwiXCI7XG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXSA9IFwiXCI7XG5cbiAgICAgICAgICAgIC8vaWYoc2VsZi5hamF4X3VybCE9XCJcIilcbiAgICAgICAgICAgIGlmKHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cInNob3J0Y29kZVwiKVxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3YW50IHRvIGRvIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludFxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYucmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XG5cbiAgICAgICAgICAgICAgICAvL2FkZCBsYW5nIGNvZGUgdG8gYWpheCBhcGkgcmVxdWVzdCwgbGFuZyBjb2RlIHNob3VsZCBhbHJlYWR5IGJlIGluIHRoZXJlIGZvciBvdGhlciByZXF1ZXN0cyAoaWUsIHN1cHBsaWVkIGluIHRoZSBSZXN1bHRzIFVSTClcblxuICAgICAgICAgICAgICAgIGlmKHNlbGYubGFuZ19jb2RlIT1cIlwiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgLy9zbyBhZGQgaXRcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcImxhbmc9XCIrc2VsZi5sYW5nX2NvZGUpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF91cmwsIHF1ZXJ5X3BhcmFtcyk7XG4gICAgICAgICAgICAgICAgLy9zZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXSA9ICdqc29uJztcblxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJwb3N0X3R5cGVfYXJjaGl2ZVwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcblxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xuXG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIGlmKHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cImN1c3RvbV93b29jb21tZXJjZV9zdG9yZVwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcblxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xuXG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICB7Ly9vdGhlcndpc2Ugd2Ugd2FudCB0byBwdWxsIHRoZSByZXN1bHRzIGRpcmVjdGx5IGZyb20gdGhlIHJlc3VsdHMgcGFnZVxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYucmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5hamF4X3VybCwgcXVlcnlfcGFyYW1zKTtcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gJ2h0bWwnO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1snYWpheCddKTtcblxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSBzZWxmLmFqYXhfZGF0YV90eXBlO1xuICAgICAgICB9O1xuXG5cblxuICAgICAgICB0aGlzLnVwZGF0ZUxvYWRlclRhZyA9IGZ1bmN0aW9uKCRvYmplY3QpIHtcblxuICAgICAgICAgICAgdmFyICRwYXJlbnQ7XG5cbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAkcGFyZW50ID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcykubGFzdCgpLnBhcmVudCgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICRwYXJlbnQgPSBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB2YXIgdGFnTmFtZSA9ICRwYXJlbnQucHJvcChcInRhZ05hbWVcIik7XG5cbiAgICAgICAgICAgIHZhciB0YWdUeXBlID0gJ2Rpdic7XG4gICAgICAgICAgICBpZiggKCB0YWdOYW1lLnRvTG93ZXJDYXNlKCkgPT0gJ29sJyApIHx8ICggdGFnTmFtZS50b0xvd2VyQ2FzZSgpID09ICd1bCcgKSApe1xuICAgICAgICAgICAgICAgIHRhZ1R5cGUgPSAnbGknO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB2YXIgJG5ldyA9ICQoJzwnK3RhZ1R5cGUrJyAvPicpLmh0bWwoJG9iamVjdC5odG1sKCkpO1xuICAgICAgICAgICAgdmFyIGF0dHJpYnV0ZXMgPSAkb2JqZWN0LnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xuXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggPHNlbGVjdD4gYXR0cmlidXRlcyBhbmQgYXBwbHkgdGhlbSBvbiA8ZGl2PlxuICAgICAgICAgICAgJC5lYWNoKGF0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICRuZXcuYXR0cih0aGlzLm5hbWUsIHRoaXMudmFsdWUpO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIHJldHVybiAkbmV3O1xuXG4gICAgICAgIH1cblxuXG4gICAgICAgIHRoaXMubG9hZE1vcmVSZXN1bHRzID0gZnVuY3Rpb24oKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZiAoIHRoaXMuaXNfbWF4X3BhZ2VkID09PSB0cnVlICkge1xuICAgICAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHNlbGYuaXNfbG9hZGluZ19tb3JlID0gdHJ1ZTtcblxuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XG4gICAgICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHtcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcbiAgICAgICAgICAgICAgICB0eXBlOiBcImxvYWRfbW9yZVwiLFxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxuICAgICAgICAgICAgfTtcblxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4c3RhcnRcIiwgZXZlbnRfZGF0YSk7XG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XG4gICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSk7XG4gICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTsgLy9ncmFiIGEgY29weSBvZiBodGUgVVJMIHBhcmFtcyB3aXRob3V0IHBhZ2luYXRpb24gYWxyZWFkeSBhZGRlZFxuXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IFwiXCI7XG4gICAgICAgICAgICB2YXIgYWpheF9yZXN1bHRzX3VybCA9IFwiXCI7XG4gICAgICAgICAgICB2YXIgZGF0YV90eXBlID0gXCJcIjtcblxuXG4gICAgICAgICAgICAvL25vdyBhZGQgdGhlIG5ldyBwYWdpbmF0aW9uXG4gICAgICAgICAgICB2YXIgbmV4dF9wYWdlZF9udW1iZXIgPSB0aGlzLmN1cnJlbnRfcGFnZWQgKyAxO1xuICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK25leHRfcGFnZWRfbnVtYmVyKTtcblxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcbiAgICAgICAgICAgIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddO1xuICAgICAgICAgICAgYWpheF9yZXN1bHRzX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ107XG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcblxuICAgICAgICAgICAgLy9hYm9ydCBhbnkgcHJldmlvdXMgYWpheCByZXF1ZXN0c1xuICAgICAgICAgICAgaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0LmFib3J0KCk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmKHNlbGYudXNlX3Njcm9sbF9sb2FkZXI9PTEpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyICRsb2FkZXIgPSAkKCc8ZGl2Lz4nLHtcbiAgICAgICAgICAgICAgICAgICAgJ2NsYXNzJzogJ3NlYXJjaC1maWx0ZXItc2Nyb2xsLWxvYWRpbmcnXG4gICAgICAgICAgICAgICAgfSk7Ly8uYXBwZW5kVG8oc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lcik7XG5cbiAgICAgICAgICAgICAgICAkbG9hZGVyID0gc2VsZi51cGRhdGVMb2FkZXJUYWcoJGxvYWRlcik7XG5cbiAgICAgICAgICAgICAgICBzZWxmLmluZmluaXRlU2Nyb2xsQXBwZW5kKCRsb2FkZXIpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9ICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLmN1cnJlbnRfcGFnZWQrKztcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcblxuICAgICAgICAgICAgICAgIC8vICoqKioqKioqKioqKioqXG4gICAgICAgICAgICAgICAgLy8gVE9ETyAtIFBBU1RFIFRISVMgQU5EIFdBVENIIFRIRSBSRURJUkVDVCAtIE9OTFkgSEFQUEVOUyBXSVRIIFdDIChDUFQgQU5EIFRBWCBET0VTIE5PVClcbiAgICAgICAgICAgICAgICAvLyBodHRwczovL3NlYXJjaC1maWx0ZXIudGVzdC9wcm9kdWN0LWNhdGVnb3J5L2Nsb3RoaW5nL3RzaGlydHMvcGFnZS8zLz9zZl9wYWdlZD0zXG5cbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcbiAgICAgICAgICAgICAgICBzZWxmLmFkZFJlc3VsdHMoZGF0YSwgZGF0YV90eXBlKTtcblxuICAgICAgICAgICAgfSwgZGF0YV90eXBlKS5mYWlsKGZ1bmN0aW9uKGpxWEhSLCB0ZXh0U3RhdHVzLCBlcnJvclRocm93bilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcbiAgICAgICAgICAgICAgICBkYXRhLmFqYXhVUkwgPSBhamF4X3Byb2Nlc3NpbmdfdXJsO1xuICAgICAgICAgICAgICAgIGRhdGEuanFYSFIgPSBqcVhIUjtcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xuICAgICAgICAgICAgICAgIGRhdGEuZXJyb3JUaHJvd24gPSBlcnJvclRocm93bjtcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBkYXRhKTtcblxuICAgICAgICAgICAgfSkuYWx3YXlzKGZ1bmN0aW9uKClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcblxuICAgICAgICAgICAgICAgIGlmKHNlbGYudXNlX3Njcm9sbF9sb2FkZXI9PTEpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAkbG9hZGVyLmRldGFjaCgpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHNlbGYuaXNfbG9hZGluZ19tb3JlID0gZmFsc2U7XG5cbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmaW5pc2hcIiwgZGF0YSk7XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9XG4gICAgICAgIHRoaXMuZmV0Y2hBamF4UmVzdWx0cyA9IGZ1bmN0aW9uKClcbiAgICAgICAge1xuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XG4gICAgICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHtcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcbiAgICAgICAgICAgICAgICB0eXBlOiBcImxvYWRfcmVzdWx0c1wiLFxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxuICAgICAgICAgICAgfTtcblxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4c3RhcnRcIiwgZXZlbnRfZGF0YSk7XG5cbiAgICAgICAgICAgIC8vcmVmb2N1cyBhbnkgaW5wdXQgZmllbGRzIGFmdGVyIHRoZSBmb3JtIGhhcyBiZWVuIHVwZGF0ZWRcbiAgICAgICAgICAgIHZhciAkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dCA9ICR0aGlzLmZpbmQoJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOmZvY3VzJykubm90KFwiLnNmLWRhdGVwaWNrZXJcIik7XG4gICAgICAgICAgICBpZigkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dC5sZW5ndGg9PTEpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGxhc3RfYWN0aXZlX2lucHV0X3RleHQgPSAkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dC5hdHRyKFwibmFtZVwiKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgJHRoaXMuYWRkQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmRpc2FibGVJbnB1dHMoc2VsZik7XG5cbiAgICAgICAgICAgIC8vZmFkZSBvdXQgcmVzdWx0c1xuICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hbmltYXRlKHsgb3BhY2l0eTogMC41IH0sIFwiZmFzdFwiKTsgLy9sb2FkaW5nXG4gICAgICAgICAgICBzZWxmLmZhZGVDb250ZW50QXJlYXMoIFwib3V0XCIgKTtcblxuICAgICAgICAgICAgaWYoc2VsZi5hamF4X2FjdGlvbj09XCJwYWdpbmF0aW9uXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgLy9uZWVkIHRvIHJlbW92ZSBhY3RpdmUgZmlsdGVyIGZyb20gVVJMXG5cbiAgICAgICAgICAgICAgICAvL3F1ZXJ5X3BhcmFtcyA9IHNlbGYubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zO1xuXG4gICAgICAgICAgICAgICAgLy9ub3cgYWRkIHRoZSBuZXcgcGFnaW5hdGlvblxuICAgICAgICAgICAgICAgIHZhciBwYWdlTnVtYmVyID0gc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiKTtcblxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihwYWdlTnVtYmVyKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHBhZ2VOdW1iZXIgPSAxO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XG4gICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpO1xuXG4gICAgICAgICAgICAgICAgaWYocGFnZU51bWJlcj4xKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK3BhZ2VOdW1iZXIpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmFqYXhfYWN0aW9uPT1cInN1Ym1pdFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyh0cnVlKTtcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTsgLy9ncmFiIGEgY29weSBvZiBodGUgVVJMIHBhcmFtcyB3aXRob3V0IHBhZ2luYXRpb24gYWxyZWFkeSBhZGRlZFxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IFwiXCI7XG4gICAgICAgICAgICB2YXIgYWpheF9yZXN1bHRzX3VybCA9IFwiXCI7XG4gICAgICAgICAgICB2YXIgZGF0YV90eXBlID0gXCJcIjtcblxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcbiAgICAgICAgICAgIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddO1xuICAgICAgICAgICAgYWpheF9yZXN1bHRzX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ107XG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcblxuXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXG4gICAgICAgICAgICBpZihzZWxmLmxhc3RfYWpheF9yZXF1ZXN0KVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHZhciBhamF4X2FjdGlvbiA9IHNlbGYuYWpheF9hY3Rpb247XG4gICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gJC5nZXQoYWpheF9wcm9jZXNzaW5nX3VybCwgZnVuY3Rpb24oZGF0YSwgc3RhdHVzLCByZXF1ZXN0KVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QgPSBudWxsO1xuXG4gICAgICAgICAgICAgICAgLy91cGRhdGVzIHRoZSByZXN1dGxzICYgZm9ybSBodG1sXG4gICAgICAgICAgICAgICAgc2VsZi51cGRhdGVSZXN1bHRzKGRhdGEsIGRhdGFfdHlwZSk7XG5cbiAgICAgICAgICAgICAgICAvLyBzY3JvbGwgXG4gICAgICAgICAgICAgICAgLy8gc2V0IHRoZSB2YXIgYmFjayB0byB3aGF0IGl0IHdhcyBiZWZvcmUgdGhlIGFqYXggcmVxdWVzdCBuYWQgdGhlIGZvcm0gcmUtaW5pdFxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9hY3Rpb24gPSBhamF4X2FjdGlvbjtcbiAgICAgICAgICAgICAgICBzZWxmLnNjcm9sbFJlc3VsdHMoIHNlbGYuYWpheF9hY3Rpb24gKTtcblxuICAgICAgICAgICAgICAgIC8qIHVwZGF0ZSBVUkwgKi9cbiAgICAgICAgICAgICAgICAvL3VwZGF0ZSB1cmwgYmVmb3JlIHBhZ2luYXRpb24sIGJlY2F1c2Ugd2UgbmVlZCB0byBkbyBzb21lIGNoZWNrcyBhZ2FpbnMgdGhlIFVSTCBmb3IgaW5maW5pdGUgc2Nyb2xsXG4gICAgICAgICAgICAgICAgc2VsZi51cGRhdGVVcmxIaXN0b3J5KGFqYXhfcmVzdWx0c191cmwpO1xuXG4gICAgICAgICAgICAgICAgLy9zZXR1cCBwYWdpbmF0aW9uXG4gICAgICAgICAgICAgICAgc2VsZi5zZXR1cEFqYXhQYWdpbmF0aW9uKCk7XG5cbiAgICAgICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IGZhbHNlO1xuXG4gICAgICAgICAgICAgICAgLyogdXNlciBkZWYgKi9cbiAgICAgICAgICAgICAgICBzZWxmLmluaXRXb29Db21tZXJjZUNvbnRyb2xzKCk7IC8vd29vY29tbWVyY2Ugb3JkZXJieVxuXG5cbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XG4gICAgICAgICAgICAgICAgZGF0YS50ZXh0U3RhdHVzID0gdGV4dFN0YXR1cztcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XG4gICAgICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBkYXRhKTtcblxuICAgICAgICAgICAgfSkuYWx3YXlzKGZ1bmN0aW9uKClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLnN0b3AodHJ1ZSx0cnVlKS5hbmltYXRlKHsgb3BhY2l0eTogMX0sIFwiZmFzdFwiKTsgLy9maW5pc2hlZCBsb2FkaW5nXG4gICAgICAgICAgICAgICAgc2VsZi5mYWRlQ29udGVudEFyZWFzKCBcImluXCIgKTtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcbiAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmVuYWJsZUlucHV0cyhzZWxmKTtcblxuICAgICAgICAgICAgICAgIC8vcmVmb2N1cyB0aGUgbGFzdCBhY3RpdmUgdGV4dCBmaWVsZFxuICAgICAgICAgICAgICAgIGlmKGxhc3RfYWN0aXZlX2lucHV0X3RleHQhPVwiXCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gW107XG4gICAgICAgICAgICAgICAgICAgIHNlbGYuJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlX2lucHV0ID0gJCh0aGlzKS5maW5kKFwiaW5wdXRbbmFtZT0nXCIrbGFzdF9hY3RpdmVfaW5wdXRfdGV4dCtcIiddXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGFjdGl2ZV9pbnB1dC5sZW5ndGg9PTEpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGlucHV0ID0gJGFjdGl2ZV9pbnB1dDtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgaWYoJGlucHV0Lmxlbmd0aD09MSkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAkaW5wdXQuZm9jdXMoKS52YWwoJGlucHV0LnZhbCgpKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuZm9jdXNDYW1wbygkaW5wdXRbMF0pO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgJHRoaXMuZmluZChcImlucHV0W25hbWU9J19zZl9zZWFyY2gnXVwiKS50cmlnZ2VyKCdmb2N1cycpO1xuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZpbmlzaFwiLCAgZGF0YSApO1xuXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmZvY3VzQ2FtcG8gPSBmdW5jdGlvbihpbnB1dEZpZWxkKXtcbiAgICAgICAgICAgIC8vdmFyIGlucHV0RmllbGQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChpZCk7XG4gICAgICAgICAgICBpZiAoaW5wdXRGaWVsZCAhPSBudWxsICYmIGlucHV0RmllbGQudmFsdWUubGVuZ3RoICE9IDApe1xuICAgICAgICAgICAgICAgIGlmIChpbnB1dEZpZWxkLmNyZWF0ZVRleHRSYW5nZSl7XG4gICAgICAgICAgICAgICAgICAgIHZhciBGaWVsZFJhbmdlID0gaW5wdXRGaWVsZC5jcmVhdGVUZXh0UmFuZ2UoKTtcbiAgICAgICAgICAgICAgICAgICAgRmllbGRSYW5nZS5tb3ZlU3RhcnQoJ2NoYXJhY3RlcicsaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGgpO1xuICAgICAgICAgICAgICAgICAgICBGaWVsZFJhbmdlLmNvbGxhcHNlKCk7XG4gICAgICAgICAgICAgICAgICAgIEZpZWxkUmFuZ2Uuc2VsZWN0KCk7XG4gICAgICAgICAgICAgICAgfWVsc2UgaWYgKGlucHV0RmllbGQuc2VsZWN0aW9uU3RhcnQgfHwgaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCA9PSAnMCcpIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGVsZW1MZW4gPSBpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aDtcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCA9IGVsZW1MZW47XG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuc2VsZWN0aW9uRW5kID0gZWxlbUxlbjtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5ibHVyKCk7XG4gICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5mb2N1cygpO1xuICAgICAgICAgICAgfSBlbHNle1xuICAgICAgICAgICAgICAgIGlmICggaW5wdXRGaWVsZCApIHtcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5mb2N1cygpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMudHJpZ2dlckV2ZW50ID0gZnVuY3Rpb24oZXZlbnRuYW1lLCBkYXRhKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgJGV2ZW50X2NvbnRhaW5lciA9ICQoXCIuc2VhcmNoYW5kZmlsdGVyW2RhdGEtc2YtZm9ybS1pZD0nXCIrc2VsZi5zZmlkK1wiJ11cIik7XG4gICAgICAgICAgICAkZXZlbnRfY29udGFpbmVyLnRyaWdnZXIoZXZlbnRuYW1lLCBbIGRhdGEgXSk7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmZldGNoQWpheEZvcm0gPSBmdW5jdGlvbigpXG4gICAgICAgIHtcbiAgICAgICAgICAgIC8vdHJpZ2dlciBzdGFydCBldmVudFxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxuICAgICAgICAgICAgICAgIHRhcmdldFNlbGVjdG9yOiBzZWxmLmFqYXhfdGFyZ2V0X2F0dHIsXG4gICAgICAgICAgICAgICAgdHlwZTogXCJmb3JtXCIsXG4gICAgICAgICAgICAgICAgb2JqZWN0OiBzZWxmXG4gICAgICAgICAgICB9O1xuXG4gICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmb3Jtc3RhcnRcIiwgWyBldmVudF9kYXRhIF0pO1xuXG4gICAgICAgICAgICAkdGhpcy5hZGRDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZGlzYWJsZUlucHV0cyhzZWxmKTtcblxuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKCk7XG5cbiAgICAgICAgICAgIGlmKHNlbGYubGFuZ19jb2RlIT1cIlwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIC8vc28gYWRkIGl0XG4gICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcImxhbmc9XCIrc2VsZi5sYW5nX2NvZGUpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5hamF4X2Zvcm1fdXJsLCBxdWVyeV9wYXJhbXMpO1xuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwianNvblwiO1xuXG5cbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcbiAgICAgICAgICAgIC8qaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcbiAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xuICAgICAgICAgICAgIH0qL1xuXG5cbiAgICAgICAgICAgIC8vc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9XG5cbiAgICAgICAgICAgICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAvL3NlbGYubGFzdF9hamF4X3JlcXVlc3QgPSBudWxsO1xuXG4gICAgICAgICAgICAgICAgLy91cGRhdGVzIHRoZSByZXN1dGxzICYgZm9ybSBodG1sXG4gICAgICAgICAgICAgICAgc2VsZi51cGRhdGVGb3JtKGRhdGEsIGRhdGFfdHlwZSk7XG5cblxuICAgICAgICAgICAgfSwgZGF0YV90eXBlKS5mYWlsKGZ1bmN0aW9uKGpxWEhSLCB0ZXh0U3RhdHVzLCBlcnJvclRocm93bilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcbiAgICAgICAgICAgICAgICBkYXRhLmFqYXhVUkwgPSBhamF4X3Byb2Nlc3NpbmdfdXJsO1xuICAgICAgICAgICAgICAgIGRhdGEuanFYSFIgPSBqcVhIUjtcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xuICAgICAgICAgICAgICAgIGRhdGEuZXJyb3JUaHJvd24gPSBlcnJvclRocm93bjtcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBbIGRhdGEgXSk7XG5cbiAgICAgICAgICAgIH0pLmFsd2F5cyhmdW5jdGlvbigpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XG5cbiAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmVuYWJsZUlucHV0cyhzZWxmKTtcblxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZvcm1maW5pc2hcIiwgWyBkYXRhIF0pO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5jb3B5TGlzdEl0ZW1zQ29udGVudHMgPSBmdW5jdGlvbigkbGlzdF9mcm9tLCAkbGlzdF90bylcbiAgICAgICAge1xuICAgICAgICAgICAgLy9jb3B5IG92ZXIgY2hpbGQgbGlzdCBpdGVtc1xuICAgICAgICAgICAgdmFyIGxpX2NvbnRlbnRzX2FycmF5ID0gbmV3IEFycmF5KCk7XG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gbmV3IEFycmF5KCk7XG5cbiAgICAgICAgICAgIHZhciAkZnJvbV9maWVsZHMgPSAkbGlzdF9mcm9tLmZpbmQoXCI+IHVsID4gbGlcIik7XG5cbiAgICAgICAgICAgICRmcm9tX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGkpe1xuXG4gICAgICAgICAgICAgICAgbGlfY29udGVudHNfYXJyYXkucHVzaCgkKHRoaXMpLmh0bWwoKSk7XG5cbiAgICAgICAgICAgICAgICB2YXIgYXR0cmlidXRlcyA9ICQodGhpcykucHJvcChcImF0dHJpYnV0ZXNcIik7XG4gICAgICAgICAgICAgICAgZnJvbV9hdHRyaWJ1dGVzLnB1c2goYXR0cmlidXRlcyk7XG5cbiAgICAgICAgICAgICAgICAvL3ZhciBmaWVsZF9uYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xuICAgICAgICAgICAgICAgIC8vdmFyIHRvX2ZpZWxkID0gJGxpc3RfdG8uZmluZChcIj4gdWwgPiBsaVtkYXRhLXNmLWZpZWxkLW5hbWU9J1wiK2ZpZWxkX25hbWUrXCInXVwiKTtcblxuICAgICAgICAgICAgICAgIC8vc2VsZi5jb3B5QXR0cmlidXRlcygkKHRoaXMpLCAkbGlzdF90bywgXCJkYXRhLXNmLVwiKTtcblxuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIHZhciBsaV9pdCA9IDA7XG4gICAgICAgICAgICB2YXIgJHRvX2ZpZWxkcyA9ICRsaXN0X3RvLmZpbmQoXCI+IHVsID4gbGlcIik7XG4gICAgICAgICAgICAkdG9fZmllbGRzLmVhY2goZnVuY3Rpb24oaSl7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5odG1sKGxpX2NvbnRlbnRzX2FycmF5W2xpX2l0XSk7XG5cbiAgICAgICAgICAgICAgICB2YXIgJGZyb21fZmllbGQgPSAkKCRmcm9tX2ZpZWxkcy5nZXQobGlfaXQpKTtcblxuICAgICAgICAgICAgICAgIHZhciAkdG9fZmllbGQgPSAkKHRoaXMpO1xuICAgICAgICAgICAgICAgICR0b19maWVsZC5yZW1vdmVBdHRyKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpO1xuICAgICAgICAgICAgICAgIHNlbGYuY29weUF0dHJpYnV0ZXMoJGZyb21fZmllbGQsICR0b19maWVsZCk7XG5cbiAgICAgICAgICAgICAgICBsaV9pdCsrO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIC8qdmFyICRmcm9tX2ZpZWxkcyA9ICRsaXN0X2Zyb20uZmluZChcIiB1bCA+IGxpXCIpO1xuICAgICAgICAgICAgIHZhciAkdG9fZmllbGRzID0gJGxpc3RfdG8uZmluZChcIiA+IGxpXCIpO1xuICAgICAgICAgICAgICRmcm9tX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGluZGV4LCB2YWwpe1xuICAgICAgICAgICAgIGlmKCQodGhpcykuaGFzQXR0cmlidXRlKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpKVxuICAgICAgICAgICAgIHtcblxuICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgIHRoaXMuY29weUF0dHJpYnV0ZXMoJGxpc3RfZnJvbSwgJGxpc3RfdG8pOyovXG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLnVwZGF0ZUZvcm1BdHRyaWJ1dGVzID0gZnVuY3Rpb24oJGxpc3RfZnJvbSwgJGxpc3RfdG8pXG4gICAgICAgIHtcbiAgICAgICAgICAgIHZhciBmcm9tX2F0dHJpYnV0ZXMgPSAkbGlzdF9mcm9tLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xuICAgICAgICAgICAgLy8gbG9vcCB0aHJvdWdoIDxzZWxlY3Q+IGF0dHJpYnV0ZXMgYW5kIGFwcGx5IHRoZW0gb24gPGRpdj5cblxuICAgICAgICAgICAgdmFyIHRvX2F0dHJpYnV0ZXMgPSAkbGlzdF90by5wcm9wKFwiYXR0cmlidXRlc1wiKTtcbiAgICAgICAgICAgICQuZWFjaCh0b19hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAkbGlzdF90by5yZW1vdmVBdHRyKHRoaXMubmFtZSk7XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgJC5lYWNoKGZyb21fYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgJGxpc3RfdG8uYXR0cih0aGlzLm5hbWUsIHRoaXMudmFsdWUpO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuY29weUF0dHJpYnV0ZXMgPSBmdW5jdGlvbigkZnJvbSwgJHRvLCBwcmVmaXgpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKHR5cGVvZihwcmVmaXgpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciBwcmVmaXggPSBcIlwiO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gJGZyb20ucHJvcChcImF0dHJpYnV0ZXNcIik7XG5cbiAgICAgICAgICAgIHZhciB0b19hdHRyaWJ1dGVzID0gJHRvLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xuICAgICAgICAgICAgJC5lYWNoKHRvX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xuXG4gICAgICAgICAgICAgICAgaWYocHJlZml4IT1cIlwiKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmICh0aGlzLm5hbWUuaW5kZXhPZihwcmVmaXgpID09IDApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICR0by5yZW1vdmVBdHRyKHRoaXMubmFtZSk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgLy8kdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAkLmVhY2goZnJvbV9hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAkdG8uYXR0cih0aGlzLm5hbWUsIHRoaXMudmFsdWUpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmNvcHlGb3JtQXR0cmlidXRlcyA9IGZ1bmN0aW9uKCRmcm9tLCAkdG8pXG4gICAgICAgIHtcbiAgICAgICAgICAgICR0by5yZW1vdmVBdHRyKFwiZGF0YS1jdXJyZW50LXRheG9ub215LWFyY2hpdmVcIik7XG4gICAgICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzKCRmcm9tLCAkdG8pO1xuXG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLnVwZGF0ZUZvcm0gPSBmdW5jdGlvbihkYXRhLCBkYXRhX3R5cGUpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXG4gICAgICAgICAgICB7Ly90aGVuIHdlIGRpZCBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnQsIHNvIGV4cGVjdCBhbiBvYmplY3QgYmFja1xuXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKGRhdGFbJ2Zvcm0nXSkhPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgYWxsIGV2ZW50cyBmcm9tIFMmRiBmb3JtXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLm9mZigpO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vcmVmcmVzaCB0aGUgZm9ybSAoYXV0byBjb3VudClcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5TGlzdEl0ZW1zQ29udGVudHMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XG5cbiAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxuICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLnNlYXJjaEFuZEZpbHRlcigpO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vaWYgYWpheCBpcyBlbmFibGVkIGluaXQgdGhlIHBhZ2luYXRpb25cblxuICAgICAgICAgICAgICAgICAgICB0aGlzLmluaXQodHJ1ZSk7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLnNldHVwQWpheFBhZ2luYXRpb24oKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG5cblxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuXG4gICAgICAgIH1cbiAgICAgICAgdGhpcy5hZGRSZXN1bHRzID0gZnVuY3Rpb24oZGF0YSwgZGF0YV90eXBlKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZihkYXRhX3R5cGU9PVwianNvblwiKVxuICAgICAgICAgICAgey8vdGhlbiB3ZSBkaWQgYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50LCBzbyBleHBlY3QgYW4gb2JqZWN0IGJhY2tcbiAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJlc3VsdHMgYW5kIGxvYWQgaW5cbiAgICAgICAgICAgICAgICAvL3NlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXBwZW5kKGRhdGFbJ3Jlc3VsdHMnXSk7XG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9IGRhdGFbJ3Jlc3VsdHMnXTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2UgaWYoZGF0YV90eXBlPT1cImh0bWxcIilcbiAgICAgICAgICAgIHsvL3dlIGFyZSBleHBlY3RpbmcgdGhlIGh0bWwgb2YgdGhlIHJlc3VsdHMgcGFnZSBiYWNrLCBzbyBleHRyYWN0IHRoZSBodG1sIHdlIG5lZWRcbiAgICAgICAgICAgICAgICB2YXIgJGRhdGFfb2JqID0gJChkYXRhKTtcbiAgICAgICAgICAgICAgICBzZWxmLmxvYWRfbW9yZV9odG1sID0gJGRhdGFfb2JqLmZpbmQoc2VsZi5hamF4X3RhcmdldF9hdHRyKS5odG1sKCk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHZhciBpbmZpbml0ZV9zY3JvbGxfZW5kID0gZmFsc2U7XG5cbiAgICAgICAgICAgIGlmKCQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChcIltkYXRhLXNlYXJjaC1maWx0ZXItYWN0aW9uPSdpbmZpbml0ZS1zY3JvbGwtZW5kJ11cIikubGVuZ3RoPjApXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IHRydWU7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIC8vaWYgdGhlcmUgaXMgYW5vdGhlciBzZWxlY3RvciBmb3IgaW5maW5pdGUgc2Nyb2xsLCBmaW5kIHRoZSBjb250ZW50cyBvZiB0aGF0IGluc3RlYWRcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLmxvYWRfbW9yZV9odG1sID0gJChcIjxkaXY+XCIrc2VsZi5sb2FkX21vcmVfaHRtbCtcIjwvZGl2PlwiKS5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcikuaHRtbCgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgaWYoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzIT1cIlwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciAkcmVzdWx0X2l0ZW1zID0gJChcIjxkaXY+XCIrc2VsZi5sb2FkX21vcmVfaHRtbCtcIjwvZGl2PlwiKS5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk7XG4gICAgICAgICAgICAgICAgdmFyICRyZXN1bHRfaXRlbXNfY29udGFpbmVyID0gJCgnPGRpdi8+Jywge30pO1xuICAgICAgICAgICAgICAgICRyZXN1bHRfaXRlbXNfY29udGFpbmVyLmFwcGVuZCgkcmVzdWx0X2l0ZW1zKTtcblxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lci5odG1sKCk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmKGluZmluaXRlX3Njcm9sbF9lbmQpXG4gICAgICAgICAgICB7Ly93ZSBmb3VuZCBhIGRhdGEgYXR0cmlidXRlIHNpZ25hbGxpbmcgdGhlIGxhc3QgcGFnZSBzbyBmaW5pc2ggaGVyZVxuXG4gICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9sb2FkX21vcmVfaHRtbCA9IHNlbGYubG9hZF9tb3JlX2h0bWw7XG5cbiAgICAgICAgICAgICAgICBzZWxmLmluZmluaXRlU2Nyb2xsQXBwZW5kKHNlbGYubG9hZF9tb3JlX2h0bWwpO1xuXG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIGlmKHNlbGYubGFzdF9sb2FkX21vcmVfaHRtbCE9PXNlbGYubG9hZF9tb3JlX2h0bWwpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgLy9jaGVjayB0byBtYWtlIHN1cmUgdGhlIG5ldyBodG1sIGZldGNoZWQgaXMgZGlmZmVyZW50XG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2xvYWRfbW9yZV9odG1sID0gc2VsZi5sb2FkX21vcmVfaHRtbDtcbiAgICAgICAgICAgICAgICBzZWxmLmluZmluaXRlU2Nyb2xsQXBwZW5kKHNlbGYubG9hZF9tb3JlX2h0bWwpO1xuXG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICB7Ly93ZSByZWNlaXZlZCB0aGUgc2FtZSBtZXNzYWdlIGFnYWluIHNvIGRvbid0IGFkZCwgYW5kIHRlbGwgUyZGIHRoYXQgd2UncmUgYXQgdGhlIGVuZC4uXG4gICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cblxuICAgICAgICB0aGlzLmluZmluaXRlU2Nyb2xsQXBwZW5kID0gZnVuY3Rpb24oJG9iamVjdClcbiAgICAgICAge1xuICAgICAgICAgICAgaWYoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzIT1cIlwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpLmxhc3QoKS5hZnRlcigkb2JqZWN0KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuYXBwZW5kKCRvYmplY3QpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cblxuICAgICAgICB0aGlzLnVwZGF0ZVJlc3VsdHMgPSBmdW5jdGlvbihkYXRhLCBkYXRhX3R5cGUpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXG4gICAgICAgICAgICB7Ly90aGVuIHdlIGRpZCBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnQsIHNvIGV4cGVjdCBhbiBvYmplY3QgYmFja1xuICAgICAgICAgICAgICAgIC8vZ3JhYiB0aGUgcmVzdWx0cyBhbmQgbG9hZCBpblxuICAgICAgICAgICAgICAgIHRoaXMucmVzdWx0c19odG1sID0gZGF0YVsncmVzdWx0cyddO1xuXG4gICAgICAgICAgICAgICAgaWYgKCB0aGlzLnJlcGxhY2VfcmVzdWx0cyApIHtcbiAgICAgICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5odG1sKHRoaXMucmVzdWx0c19odG1sKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBpZih0eXBlb2YoZGF0YVsnZm9ybSddKSE9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBhbGwgZXZlbnRzIGZyb20gUyZGIGZvcm1cbiAgICAgICAgICAgICAgICAgICAgJHRoaXMub2ZmKCk7XG5cbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgcGFnaW5hdGlvblxuICAgICAgICAgICAgICAgICAgICBzZWxmLnJlbW92ZUFqYXhQYWdpbmF0aW9uKCk7XG5cbiAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxuICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlMaXN0SXRlbXNDb250ZW50cygkKGRhdGFbJ2Zvcm0nXSksICR0aGlzKTtcblxuICAgICAgICAgICAgICAgICAgICAvL3VwZGF0ZSBhdHRyaWJ1dGVzIG9uIGZvcm1cbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5Rm9ybUF0dHJpYnV0ZXMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XG5cbiAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5zZWFyY2hBbmRGaWx0ZXIoeydpc0luaXQnOiBmYWxzZX0pO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLmZpbmQoXCJpbnB1dFwiKS5yZW1vdmVBdHRyKFwiZGlzYWJsZWRcIik7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZihkYXRhX3R5cGU9PVwiaHRtbFwiKSB7Ly93ZSBhcmUgZXhwZWN0aW5nIHRoZSBodG1sIG9mIHRoZSByZXN1bHRzIHBhZ2UgYmFjaywgc28gZXh0cmFjdCB0aGUgaHRtbCB3ZSBuZWVkXG5cbiAgICAgICAgICAgICAgICB2YXIgJGRhdGFfb2JqID0gJChkYXRhKTtcbiAgICAgICAgICAgICAgICB0aGlzLnJlc3VsdHNfcGFnZV9odG1sID0gZGF0YTtcbiAgICAgICAgICAgICAgICB0aGlzLnJlc3VsdHNfaHRtbCA9ICRkYXRhX29iai5maW5kKCB0aGlzLmFqYXhfdGFyZ2V0X2F0dHIgKS5odG1sKCk7XG5cbiAgICAgICAgICAgICAgICBpZiAoIHRoaXMucmVwbGFjZV9yZXN1bHRzICkge1xuICAgICAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmh0bWwodGhpcy5yZXN1bHRzX2h0bWwpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlQ29udGVudEFyZWFzKCAkZGF0YV9vYmogKTtcblxuICAgICAgICAgICAgICAgIGlmIChzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLmxlbmd0aCA+IDApXG4gICAgICAgICAgICAgICAgey8vdGhlbiB0aGVyZSBhcmUgc2VhcmNoIGZvcm0ocykgaW5zaWRlIHRoZSByZXN1bHRzIGNvbnRhaW5lciwgc28gcmUtaW5pdCB0aGVtXG5cbiAgICAgICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAvL2lmIHRoZSBjdXJyZW50IHNlYXJjaCBmb3JtIGlzIG5vdCBpbnNpZGUgdGhlIHJlc3VsdHMgY29udGFpbmVyLCB0aGVuIHByb2NlZWQgYXMgbm9ybWFsIGFuZCB1cGRhdGUgdGhlIGZvcm1cbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyW2RhdGEtc2YtZm9ybS1pZD0nXCIgKyBzZWxmLnNmaWQgKyBcIiddXCIpLmxlbmd0aD09MCkge1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciAkbmV3X3NlYXJjaF9mb3JtID0gJGRhdGFfb2JqLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyW2RhdGEtc2YtZm9ybS1pZD0nXCIgKyBzZWxmLnNmaWQgKyBcIiddXCIpO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmICgkbmV3X3NlYXJjaF9mb3JtLmxlbmd0aCA9PSAxKSB7Ly90aGVuIHJlcGxhY2UgdGhlIHNlYXJjaCBmb3JtIHdpdGggdGhlIG5ldyBvbmVcblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgYWxsIGV2ZW50cyBmcm9tIFMmRiBmb3JtXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgcGFnaW5hdGlvblxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5yZW1vdmVBamF4UGFnaW5hdGlvbigpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3JlZnJlc2ggdGhlIGZvcm0gKGF1dG8gY291bnQpXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlMaXN0SXRlbXNDb250ZW50cygkbmV3X3NlYXJjaF9mb3JtLCAkdGhpcyk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vdXBkYXRlIGF0dHJpYnV0ZXMgb24gZm9ybVxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5Rm9ybUF0dHJpYnV0ZXMoJG5ld19zZWFyY2hfZm9ybSwgJHRoaXMpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3JlIGluaXQgUyZGIGNsYXNzIG9uIHRoZSBmb3JtXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy5zZWFyY2hBbmRGaWx0ZXIoeydpc0luaXQnOiBmYWxzZX0pO1xuXG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vJHRoaXMuZmluZChcImlucHV0XCIpLnJlbW92ZUF0dHIoXCJkaXNhYmxlZFwiKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSBmYWxzZTsgLy9mb3IgaW5maW5pdGUgc2Nyb2xsXG4gICAgICAgICAgICBzZWxmLmN1cnJlbnRfcGFnZWQgPSAxOyAvL2ZvciBpbmZpbml0ZSBzY3JvbGxcbiAgICAgICAgICAgIHNlbGYuc2V0SW5maW5pdGVTY3JvbGxDb250YWluZXIoKTtcblxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy51cGRhdGVDb250ZW50QXJlYXMgPSBmdW5jdGlvbiggJGh0bWxfZGF0YSApIHtcbiAgICAgICAgICAgIFxuICAgICAgICAgICAgLy8gYWRkIGFkZGl0aW9uYWwgY29udGVudCBhcmVhc1xuICAgICAgICAgICAgaWYgKCB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zICYmIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoICkge1xuICAgICAgICAgICAgICAgIGZvciAoaW5kZXggPSAwOyBpbmRleCA8IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoOyArK2luZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciBzZWxlY3RvciA9IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnNbaW5kZXhdO1xuICAgICAgICAgICAgICAgICAgICAkKCBzZWxlY3RvciApLmh0bWwoICRodG1sX2RhdGEuZmluZCggc2VsZWN0b3IgKS5odG1sKCkgKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgICAgdGhpcy5mYWRlQ29udGVudEFyZWFzID0gZnVuY3Rpb24oIGRpcmVjdGlvbiApIHtcbiAgICAgICAgICAgIFxuICAgICAgICAgICAgdmFyIG9wYWNpdHkgPSAwLjU7XG4gICAgICAgICAgICBpZiAoIGRpcmVjdGlvbiA9PT0gXCJpblwiICkge1xuICAgICAgICAgICAgICAgIG9wYWNpdHkgPSAxO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZiAoIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMgJiYgdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucy5sZW5ndGggKSB7XG4gICAgICAgICAgICAgICAgZm9yIChpbmRleCA9IDA7IGluZGV4IDwgdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucy5sZW5ndGg7ICsraW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNlbGVjdG9yID0gdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9uc1tpbmRleF07XG4gICAgICAgICAgICAgICAgICAgICQoIHNlbGVjdG9yICkuc3RvcCh0cnVlLHRydWUpLmFuaW1hdGUoIHsgb3BhY2l0eTogb3BhY2l0eX0sIFwiZmFzdFwiICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICAgICBcbiAgICAgICAgICAgIFxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5yZW1vdmVXb29Db21tZXJjZUNvbnRyb2xzID0gZnVuY3Rpb24oKXtcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnkgPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcgLm9yZGVyYnknKTtcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnlfZm9ybSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZycpO1xuXG4gICAgICAgICAgICAkd29vX29yZGVyYnlfZm9ybS5vZmYoKTtcbiAgICAgICAgICAgICR3b29fb3JkZXJieS5vZmYoKTtcbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmFkZFF1ZXJ5UGFyYW0gPSBmdW5jdGlvbihuYW1lLCB2YWx1ZSwgdXJsX3R5cGUpe1xuXG4gICAgICAgICAgICBpZih0eXBlb2YodXJsX3R5cGUpPT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciB1cmxfdHlwZSA9IFwiYWxsXCI7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1t1cmxfdHlwZV1bbmFtZV0gPSB2YWx1ZTtcblxuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMgPSBmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICBzZWxmLnJlbW92ZVdvb0NvbW1lcmNlQ29udHJvbHMoKTtcblxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZyAub3JkZXJieScpO1xuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieV9mb3JtID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nJyk7XG5cbiAgICAgICAgICAgIHZhciBvcmRlcl92YWwgPSBcIlwiO1xuICAgICAgICAgICAgaWYoJHdvb19vcmRlcmJ5Lmxlbmd0aD4wKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9ICR3b29fb3JkZXJieS52YWwoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwib3JkZXJieVwiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmKG9yZGVyX3ZhbD09XCJtZW51X29yZGVyXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgb3JkZXJfdmFsID0gXCJcIjtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYoKG9yZGVyX3ZhbCE9XCJcIikmJighIW9yZGVyX3ZhbCkpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsLm9yZGVyYnkgPSBvcmRlcl92YWw7XG4gICAgICAgICAgICB9XG5cblxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5X2Zvcm0ub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKGUpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgICAgICAgIC8vdmFyIGZvcm0gPSBlLnRhcmdldDtcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5Lm9uKFwiY2hhbmdlXCIsIGZ1bmN0aW9uKGUpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9ICQodGhpcykudmFsKCk7XG4gICAgICAgICAgICAgICAgaWYodmFsPT1cIm1lbnVfb3JkZXJcIilcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHZhbCA9IFwiXCI7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsLm9yZGVyYnkgPSB2YWw7XG5cbiAgICAgICAgICAgICAgICAkdGhpcy50cmlnZ2VyKFwic3VibWl0XCIpXG5cbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5zY3JvbGxSZXN1bHRzID0gZnVuY3Rpb24oKVxuICAgICAgICB7XG4gICAgICAgICAgICBpZigoc2VsZi5zY3JvbGxfb25fYWN0aW9uPT1zZWxmLmFqYXhfYWN0aW9uKXx8KHNlbGYuc2Nyb2xsX29uX2FjdGlvbj09XCJhbGxcIikpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5zY3JvbGxUb1BvcygpOyAvL3Njcm9sbCB0aGUgd2luZG93IGlmIGl0IGhhcyBiZWVuIHNldFxuICAgICAgICAgICAgICAgIC8vc2VsZi5hamF4X2FjdGlvbiA9IFwiXCI7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLnVwZGF0ZVVybEhpc3RvcnkgPSBmdW5jdGlvbihhamF4X3Jlc3VsdHNfdXJsKVxuICAgICAgICB7XG4gICAgICAgICAgICB2YXIgdXNlX2hpc3RvcnlfYXBpID0gMDtcbiAgICAgICAgICAgIGlmICh3aW5kb3cuaGlzdG9yeSAmJiB3aW5kb3cuaGlzdG9yeS5wdXNoU3RhdGUpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgdXNlX2hpc3RvcnlfYXBpID0gJHRoaXMuYXR0cihcImRhdGEtdXNlLWhpc3RvcnktYXBpXCIpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZigoc2VsZi51cGRhdGVfYWpheF91cmw9PTEpJiYodXNlX2hpc3RvcnlfYXBpPT0xKSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAvL25vdyBjaGVjayBpZiB0aGUgYnJvd3NlciBzdXBwb3J0cyBoaXN0b3J5IHN0YXRlIHB1c2ggOilcbiAgICAgICAgICAgICAgICBpZiAod2luZG93Lmhpc3RvcnkgJiYgd2luZG93Lmhpc3RvcnkucHVzaFN0YXRlKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaGlzdG9yeS5wdXNoU3RhdGUobnVsbCwgbnVsbCwgYWpheF9yZXN1bHRzX3VybCk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIHRoaXMucmVtb3ZlQWpheFBhZ2luYXRpb24gPSBmdW5jdGlvbigpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpIT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciAkYWpheF9saW5rc19vYmplY3QgPSBqUXVlcnkoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcblxuICAgICAgICAgICAgICAgIGlmKCRhamF4X2xpbmtzX29iamVjdC5sZW5ndGg+MClcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICRhamF4X2xpbmtzX29iamVjdC5vZmYoKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmdldEJhc2VVcmwgPSBmdW5jdGlvbiggdXJsICkge1xuICAgICAgICAgICAgLy9ub3cgc2VlIGlmIHdlIGFyZSBvbiB0aGUgVVJMIHdlIHRoaW5rLi4uXG4gICAgICAgICAgICB2YXIgdXJsX3BhcnRzID0gdXJsLnNwbGl0KFwiP1wiKTtcbiAgICAgICAgICAgIHZhciB1cmxfYmFzZSA9IFwiXCI7XG5cbiAgICAgICAgICAgIGlmKHVybF9wYXJ0cy5sZW5ndGg+MClcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9wYXJ0c1swXTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgIHVybF9iYXNlID0gdXJsO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgcmV0dXJuIHVybF9iYXNlO1xuICAgICAgICB9XG4gICAgICAgIHRoaXMuY2FuRmV0Y2hBamF4UmVzdWx0cyA9IGZ1bmN0aW9uKGZldGNoX3R5cGUpXG4gICAgICAgIHtcbiAgICAgICAgICAgIGlmKHR5cGVvZihmZXRjaF90eXBlKT09XCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgZmV0Y2hfdHlwZSA9IFwiXCI7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHZhciBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcblxuICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIGFqYXggc3VibWl0IHRoZSBmb3JtXG5cbiAgICAgICAgICAgICAgICAvL2FuZCBpZiB3ZSBjYW4gZmluZCB0aGUgcmVzdWx0cyBjb250YWluZXJcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmxlbmd0aD09MSlcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IHRydWU7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gc2VsZi5yZXN1bHRzX3VybDsgIC8vXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsX2VuY29kZWQgPSAnJzsgIC8vXG4gICAgICAgICAgICAgICAgdmFyIGN1cnJlbnRfdXJsID0gd2luZG93LmxvY2F0aW9uLmhyZWY7XG5cbiAgICAgICAgICAgICAgICAvL2lnbm9yZSAjIGFuZCBldmVyeXRoaW5nIGFmdGVyXG4gICAgICAgICAgICAgICAgdmFyIGhhc2hfcG9zID0gd2luZG93LmxvY2F0aW9uLmhyZWYuaW5kZXhPZignIycpO1xuICAgICAgICAgICAgICAgIGlmKGhhc2hfcG9zIT09LTEpe1xuICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybCA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmLnN1YnN0cigwLCB3aW5kb3cubG9jYXRpb24uaHJlZi5pbmRleE9mKCcjJykpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIGlmKCAoICggc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwiY3VzdG9tX3dvb2NvbW1lcmNlX3N0b3JlXCIgKSB8fCAoIHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cInBvc3RfdHlwZV9hcmNoaXZlXCIgKSApICYmICggc2VsZi5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMgPT0gMSApIClcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlmKCBzZWxmLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSAhPT1cIlwiIClcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmZXRjaF9hamF4X3Jlc3VsdHM7XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAvKnZhciByZXN1bHRzX3VybCA9IHByb2Nlc3NfZm9ybS5nZXRSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xuICAgICAgICAgICAgICAgICAgICAgdmFyIGFjdGl2ZV90YXggPSBwcm9jZXNzX2Zvcm0uZ2V0QWN0aXZlVGF4KCk7XG4gICAgICAgICAgICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSwgJycsIGFjdGl2ZV90YXgpOyovXG4gICAgICAgICAgICAgICAgfVxuXG5cblxuXG4gICAgICAgICAgICAgICAgLy9ub3cgc2VlIGlmIHdlIGFyZSBvbiB0aGUgVVJMIHdlIHRoaW5rLi4uXG4gICAgICAgICAgICAgICAgdmFyIHVybF9iYXNlID0gdGhpcy5nZXRCYXNlVXJsKCBjdXJyZW50X3VybCApO1xuICAgICAgICAgICAgICAgIC8vdmFyIHJlc3VsdHNfdXJsX2Jhc2UgPSB0aGlzLmdldEJhc2VVcmwoIGN1cnJlbnRfdXJsICk7XG5cbiAgICAgICAgICAgICAgICB2YXIgbGFuZyA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJsYW5nXCIsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcbiAgICAgICAgICAgICAgICBpZigodHlwZW9mKGxhbmcpIT09XCJ1bmRlZmluZWRcIikmJihsYW5nIT09bnVsbCkpXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHNlbGYuYWRkVXJsUGFyYW0odXJsX2Jhc2UsIFwibGFuZz1cIitsYW5nKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB2YXIgc2ZpZCA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJzZmlkXCIsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcblxuICAgICAgICAgICAgICAgIC8vaWYgc2ZpZCBpcyBhIG51bWJlclxuICAgICAgICAgICAgICAgIGlmKE51bWJlcihwYXJzZUZsb2F0KHNmaWQpKSA9PSBzZmlkKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSBzZWxmLmFkZFVybFBhcmFtKHVybF9iYXNlLCBcInNmaWQ9XCIrc2ZpZCk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgLy9pZiBhbnkgb2YgdGhlIDMgY29uZGl0aW9ucyBhcmUgdHJ1ZSwgdGhlbiBpdHMgZ29vZCB0byBnb1xuICAgICAgICAgICAgICAgIC8vIC0gMSB8IGlmIHRoZSB1cmwgYmFzZSA9PSByZXN1bHRzX3VybFxuICAgICAgICAgICAgICAgIC8vIC0gMiB8IGlmIHVybCBiYXNlKyBcIi9cIiAgPT0gcmVzdWx0c191cmwgLSBpbiBjYXNlIG9mIHVzZXIgZXJyb3IgaW4gdGhlIHJlc3VsdHMgVVJMXG4gICAgICAgICAgICAgICAgLy8gLSAzIHwgaWYgdGhlIHJlc3VsdHMgVVJMIGhhcyB1cmwgcGFyYW1zLCBhbmQgdGhlIGN1cnJlbnQgdXJsIHN0YXJ0cyB3aXRoIHRoZSByZXN1bHRzIFVSTCBcblxuICAgICAgICAgICAgICAgIC8vdHJpbSBhbnkgdHJhaWxpbmcgc2xhc2ggZm9yIGVhc2llciBjb21wYXJpc29uOlxuICAgICAgICAgICAgICAgIHVybF9iYXNlID0gdXJsX2Jhc2UucmVwbGFjZSgvXFwvJC8sICcnKTtcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybCA9IHJlc3VsdHNfdXJsLnJlcGxhY2UoL1xcLyQvLCAnJyk7XG4gICAgICAgICAgICAgICAgcmVzdWx0c191cmxfZW5jb2RlZCA9IGVuY29kZVVSSShyZXN1bHRzX3VybCk7XG4gICAgICAgICAgICAgICAgXG5cbiAgICAgICAgICAgICAgICB2YXIgY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPSAtMTtcbiAgICAgICAgICAgICAgICBpZigodXJsX2Jhc2U9PXJlc3VsdHNfdXJsKXx8KHVybF9iYXNlLnRvTG93ZXJDYXNlKCk9PXJlc3VsdHNfdXJsX2VuY29kZWQudG9Mb3dlckNhc2UoKSkgICl7XG4gICAgICAgICAgICAgICAgICAgIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID0gMTtcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBpZiAoIHJlc3VsdHNfdXJsLmluZGV4T2YoICc/JyApICE9PSAtMSAmJiBjdXJyZW50X3VybC5sYXN0SW5kZXhPZihyZXN1bHRzX3VybCwgMCkgPT09IDAgKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IDE7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBpZihzZWxmLm9ubHlfcmVzdWx0c19hamF4PT0xKVxuICAgICAgICAgICAgICAgIHsvL2lmIGEgdXNlciBoYXMgY2hvc2VuIHRvIG9ubHkgYWxsb3cgYWpheCBvbiByZXN1bHRzIHBhZ2VzIChkZWZhdWx0IGJlaGF2aW91cilcblxuICAgICAgICAgICAgICAgICAgICBpZiggY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPiAtMSlcbiAgICAgICAgICAgICAgICAgICAgey8vdGhpcyBtZWFucyB0aGUgY3VycmVudCBVUkwgY29udGFpbnMgdGhlIHJlc3VsdHMgdXJsLCB3aGljaCBtZWFucyB3ZSBjYW4gZG8gYWpheFxuICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlmKGZldGNoX3R5cGU9PVwicGFnaW5hdGlvblwiKVxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICBpZiggY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPiAtMSlcbiAgICAgICAgICAgICAgICAgICAgICAgIHsvL3RoaXMgbWVhbnMgdGhlIGN1cnJlbnQgVVJMIGNvbnRhaW5zIHRoZSByZXN1bHRzIHVybCwgd2hpY2ggbWVhbnMgd2UgY2FuIGRvIGFqYXhcblxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZVxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vZG9uJ3QgYWpheCBwYWdpbmF0aW9uIHdoZW4gbm90IG9uIGEgUyZGIHBhZ2VcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuXG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgcmV0dXJuIGZldGNoX2FqYXhfcmVzdWx0cztcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuc2V0dXBBamF4UGFnaW5hdGlvbiA9IGZ1bmN0aW9uKClcbiAgICAgICAge1xuICAgICAgICAgICAgLy9pbmZpbml0ZSBzY3JvbGxcbiAgICAgICAgICAgIGlmKHRoaXMucGFnaW5hdGlvbl90eXBlPT09XCJpbmZpbml0ZV9zY3JvbGxcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IGZhbHNlO1xuICAgICAgICAgICAgICAgIGlmKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIltkYXRhLXNlYXJjaC1maWx0ZXItYWN0aW9uPSdpbmZpbml0ZS1zY3JvbGwtZW5kJ11cIikubGVuZ3RoPjApXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpbmZpbml0ZV9zY3JvbGxfZW5kID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIGlmKHBhcnNlSW50KHRoaXMuaW5zdGFuY2VfbnVtYmVyKT09PTEpIHtcbiAgICAgICAgICAgICAgICAgICAgJCh3aW5kb3cpLm9mZihcInNjcm9sbFwiLCBzZWxmLm9uV2luZG93U2Nyb2xsKTtcblxuICAgICAgICAgICAgICAgICAgICBpZiAoc2VsZi5jYW5GZXRjaEFqYXhSZXN1bHRzKFwicGFnaW5hdGlvblwiKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgJCh3aW5kb3cpLm9uKFwic2Nyb2xsXCIsIHNlbGYub25XaW5kb3dTY3JvbGwpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZih0eXBlb2Yoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKT09XCJ1bmRlZmluZWRcIikge1xuICAgICAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgICQoZG9jdW1lbnQpLm9mZignY2xpY2snLCBzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpO1xuICAgICAgICAgICAgICAgICQoZG9jdW1lbnQpLm9mZihzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpO1xuICAgICAgICAgICAgICAgICQoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKS5vZmYoKTtcblxuICAgICAgICAgICAgICAgICQoZG9jdW1lbnQpLm9uKCdjbGljaycsIHNlbGYuYWpheF9saW5rc19zZWxlY3RvciwgZnVuY3Rpb24oZSl7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5jYW5GZXRjaEFqYXhSZXN1bHRzKFwicGFnaW5hdGlvblwiKSlcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgbGluayA9IGpRdWVyeSh0aGlzKS5hdHRyKCdocmVmJyk7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gXCJwYWdpbmF0aW9uXCI7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBwYWdlTnVtYmVyID0gc2VsZi5nZXRQYWdlZEZyb21VUkwobGluayk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIiwgcGFnZU51bWJlcik7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuZmV0Y2hBamF4UmVzdWx0cygpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmdldFBhZ2VkRnJvbVVSTCA9IGZ1bmN0aW9uKFVSTCl7XG5cbiAgICAgICAgICAgIHZhciBwYWdlZFZhbCA9IDE7XG4gICAgICAgICAgICAvL2ZpcnN0IHRlc3QgdG8gc2VlIGlmIHdlIGhhdmUgXCIvcGFnZS80L1wiIGluIHRoZSBVUkxcbiAgICAgICAgICAgIHZhciB0cFZhbCA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJzZl9wYWdlZFwiLCBVUkwpO1xuICAgICAgICAgICAgaWYoKHR5cGVvZih0cFZhbCk9PVwic3RyaW5nXCIpfHwodHlwZW9mKHRwVmFsKT09XCJudW1iZXJcIikpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgcGFnZWRWYWwgPSB0cFZhbDtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgcmV0dXJuIHBhZ2VkVmFsO1xuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuZ2V0UXVlcnlQYXJhbUZyb21VUkwgPSBmdW5jdGlvbihuYW1lLCBVUkwpe1xuXG4gICAgICAgICAgICB2YXIgcXN0cmluZyA9IFwiP1wiK1VSTC5zcGxpdCgnPycpWzFdO1xuICAgICAgICAgICAgaWYodHlwZW9mKHFzdHJpbmcpIT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBkZWNvZGVVUklDb21wb25lbnQoKG5ldyBSZWdFeHAoJ1s/fCZdJyArIG5hbWUgKyAnPScgKyAnKFteJjtdKz8pKCZ8I3w7fCQpJykuZXhlYyhxc3RyaW5nKXx8WyxcIlwiXSlbMV0ucmVwbGFjZSgvXFwrL2csICclMjAnKSl8fG51bGw7XG4gICAgICAgICAgICAgICAgcmV0dXJuIHZhbDtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHJldHVybiBcIlwiO1xuICAgICAgICB9O1xuXG5cblxuICAgICAgICB0aGlzLmZvcm1VcGRhdGVkID0gZnVuY3Rpb24oZSl7XG5cbiAgICAgICAgICAgIC8vZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgICAgaWYoc2VsZi5hdXRvX3VwZGF0ZT09MSkge1xuICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgZWxzZSBpZigoc2VsZi5hdXRvX3VwZGF0ZT09MCkmJihzZWxmLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKSlcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBzZWxmLmZvcm1VcGRhdGVkRmV0Y2hBamF4KCk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgfTtcblxuICAgICAgICB0aGlzLmZvcm1VcGRhdGVkRmV0Y2hBamF4ID0gZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgLy9sb29wIHRocm91Z2ggYWxsIHRoZSBmaWVsZHMgYW5kIGJ1aWxkIHRoZSBVUkxcbiAgICAgICAgICAgIHNlbGYuZmV0Y2hBamF4Rm9ybSgpO1xuXG5cbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgfTtcblxuICAgICAgICAvL21ha2UgYW55IGNvcnJlY3Rpb25zL3VwZGF0ZXMgdG8gZmllbGRzIGJlZm9yZSB0aGUgc3VibWl0IGNvbXBsZXRlc1xuICAgICAgICB0aGlzLnNldEZpZWxkcyA9IGZ1bmN0aW9uKGUpe1xuXG4gICAgICAgICAgICAvL3NvbWV0aW1lcyB0aGUgZm9ybSBpcyBzdWJtaXR0ZWQgd2l0aG91dCB0aGUgc2xpZGVyIHlldCBoYXZpbmcgdXBkYXRlZCwgYW5kIGFzIHdlIGdldCBvdXIgdmFsdWVzIGZyb21cbiAgICAgICAgICAgIC8vdGhlIHNsaWRlciBhbmQgbm90IGlucHV0cywgd2UgbmVlZCB0byBjaGVjayBpdCBpZiBuZWVkcyB0byBiZSBzZXRcbiAgICAgICAgICAgIC8vb25seSBvY2N1cnMgaWYgYWpheCBpcyBvZmYsIGFuZCBhdXRvc3VibWl0IG9uXG4gICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpIHtcblxuICAgICAgICAgICAgICAgIHZhciAkZmllbGQgPSAkKHRoaXMpO1xuXG4gICAgICAgICAgICAgICAgdmFyIHJhbmdlX2Rpc3BsYXlfdmFsdWVzID0gJGZpZWxkLmZpbmQoJy5zZi1tZXRhLXJhbmdlLXNsaWRlcicpLmF0dHIoXCJkYXRhLWRpc3BsYXktdmFsdWVzLWFzXCIpOy8vZGF0YS1kaXNwbGF5LXZhbHVlcy1hcz1cInRleHRcIlxuXG4gICAgICAgICAgICAgICAgaWYocmFuZ2VfZGlzcGxheV92YWx1ZXM9PT1cInRleHRpbnB1dFwiKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYoJGZpZWxkLmZpbmQoXCIubWV0YS1zbGlkZXJcIikubGVuZ3RoPjApe1xuXG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCIubWV0YS1zbGlkZXJcIikuZWFjaChmdW5jdGlvbiAoaW5kZXgpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9vYmplY3QgPSAkKHRoaXMpWzBdO1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRzbGlkZXJfZWwgPSAkKHRoaXMpLmNsb3Nlc3QoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgbWluVmFsID0gJHNsaWRlcl9lbC5maW5kKFwiLnNmLXJhbmdlLW1pblwiKS52YWwoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmZpbmQoXCIuc2YtcmFuZ2UtbWF4XCIpLnZhbCgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbbWluVmFsLCBtYXhWYWxdKTtcblxuICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9XG5cbiAgICAgICAgLy9zdWJtaXRcbiAgICAgICAgdGhpcy5zdWJtaXRGb3JtID0gZnVuY3Rpb24oZSl7XG5cbiAgICAgICAgICAgIC8vbG9vcCB0aHJvdWdoIGFsbCB0aGUgZmllbGRzIGFuZCBidWlsZCB0aGUgVVJMXG4gICAgICAgICAgICBpZihzZWxmLmlzU3VibWl0dGluZyA9PSB0cnVlKSB7XG4gICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBzZWxmLnNldEZpZWxkcygpO1xuICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7XG5cbiAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gdHJ1ZTtcblxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xuXG4gICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIsIDEpOyAvL2luaXQgcGFnZWRcblxuICAgICAgICAgICAgaWYoc2VsZi5jYW5GZXRjaEFqYXhSZXN1bHRzKCkpXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgYWpheCBzdWJtaXQgdGhlIGZvcm1cblxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9hY3Rpb24gPSBcInN1Ym1pdFwiOyAvL3NvIHdlIGtub3cgaXQgd2Fzbid0IHBhZ2luYXRpb25cbiAgICAgICAgICAgICAgICBzZWxmLmZldGNoQWpheFJlc3VsdHMoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2lsbCBzaW1wbHkgcmVkaXJlY3QgdG8gdGhlIFJlc3VsdHMgVVJMXG5cbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcbiAgICAgICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSwgJycpO1xuICAgICAgICAgICAgICAgIHJlc3VsdHNfdXJsID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcblxuICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gcmVzdWx0c191cmw7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgfTtcbiAgICAgICAgdGhpcy5yZXNldEZvcm0gPSBmdW5jdGlvbihzdWJtaXRfZm9ybSlcbiAgICAgICAge1xuICAgICAgICAgICAgLy91bnNldCBhbGwgZmllbGRzXG4gICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xuXG4gICAgICAgICAgICAgICAgdmFyICRmaWVsZCA9ICQodGhpcyk7XG4gICAgICAgICAgICAgICAgXG5cdFx0XHRcdCRmaWVsZC5yZW1vdmVBdHRyKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpO1xuXHRcdFx0XHRcbiAgICAgICAgICAgICAgICAvL3N0YW5kYXJkIGZpZWxkIHR5cGVzXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJzZWxlY3Q6bm90KFttdWx0aXBsZT0nbXVsdGlwbGUnXSkgPiBvcHRpb246Zmlyc3QtY2hpbGRcIikucHJvcChcInNlbGVjdGVkXCIsIHRydWUpO1xuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwic2VsZWN0W211bHRpcGxlPSdtdWx0aXBsZSddID4gb3B0aW9uXCIpLnByb3AoXCJzZWxlY3RlZFwiLCBmYWxzZSk7XG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJpbnB1dFt0eXBlPSdjaGVja2JveCddXCIpLnByb3AoXCJjaGVja2VkXCIsIGZhbHNlKTtcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIj4gdWwgPiBsaTpmaXJzdC1jaGlsZCBpbnB1dFt0eXBlPSdyYWRpbyddXCIpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiaW5wdXRbdHlwZT0ndGV4dCddXCIpLnZhbChcIlwiKTtcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIi5zZi1vcHRpb24tYWN0aXZlXCIpLnJlbW92ZUNsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIj4gdWwgPiBsaTpmaXJzdC1jaGlsZCBpbnB1dFt0eXBlPSdyYWRpbyddXCIpLnBhcmVudCgpLmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTsgLy9yZSBhZGQgYWN0aXZlIGNsYXNzIHRvIGZpcnN0IFwiZGVmYXVsdFwiIG9wdGlvblxuXG4gICAgICAgICAgICAgICAgLy9udW1iZXIgcmFuZ2UgLSAyIG51bWJlciBpbnB1dCBmaWVsZHNcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcImlucHV0W3R5cGU9J251bWJlciddXCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciAkdGhpc0lucHV0ID0gJCh0aGlzKTtcblxuICAgICAgICAgICAgICAgICAgICBpZigkdGhpc0lucHV0LnBhcmVudCgpLnBhcmVudCgpLmhhc0NsYXNzKFwic2YtbWV0YS1yYW5nZVwiKSkge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKCR0aGlzSW5wdXQuYXR0cihcIm1pblwiKSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoJHRoaXNJbnB1dC5hdHRyKFwibWF4XCIpKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgLy9tZXRhIC8gbnVtYmVycyB3aXRoIDIgaW5wdXRzIChmcm9tIC8gdG8gZmllbGRzKSAtIHNlY29uZCBpbnB1dCBtdXN0IGJlIHJlc2V0IHRvIG1heCB2YWx1ZVxuICAgICAgICAgICAgICAgIHZhciAkbWV0YV9zZWxlY3RfZnJvbV90byA9ICRmaWVsZC5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2VsZWN0LWZyb210b1wiKTtcblxuICAgICAgICAgICAgICAgIGlmKCRtZXRhX3NlbGVjdF9mcm9tX3RvLmxlbmd0aD4wKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21pbiA9ICRtZXRhX3NlbGVjdF9mcm9tX3RvLmF0dHIoXCJkYXRhLW1pblwiKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21heCA9ICRtZXRhX3NlbGVjdF9mcm9tX3RvLmF0dHIoXCJkYXRhLW1heFwiKTtcblxuICAgICAgICAgICAgICAgICAgICAkbWV0YV9zZWxlY3RfZnJvbV90by5maW5kKFwic2VsZWN0XCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNJbnB1dCA9ICQodGhpcyk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGluZGV4PT0wKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoc3RhcnRfbWluKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoaW5kZXg9PTEpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbChzdGFydF9tYXgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHZhciAkbWV0YV9yYWRpb19mcm9tX3RvID0gJGZpZWxkLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1yYWRpby1mcm9tdG9cIik7XG5cbiAgICAgICAgICAgICAgICBpZigkbWV0YV9yYWRpb19mcm9tX3RvLmxlbmd0aD4wKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21pbiA9ICRtZXRhX3JhZGlvX2Zyb21fdG8uYXR0cihcImRhdGEtbWluXCIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWF4ID0gJG1ldGFfcmFkaW9fZnJvbV90by5hdHRyKFwiZGF0YS1tYXhcIik7XG5cbiAgICAgICAgICAgICAgICAgICAgdmFyICRyYWRpb19ncm91cHMgPSAkbWV0YV9yYWRpb19mcm9tX3RvLmZpbmQoJy5zZi1pbnB1dC1yYW5nZS1yYWRpbycpO1xuXG4gICAgICAgICAgICAgICAgICAgICRyYWRpb19ncm91cHMuZWFjaChmdW5jdGlvbihpbmRleCl7XG5cblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRyYWRpb3MgPSAkKHRoaXMpLmZpbmQoXCIuc2YtaW5wdXQtcmFkaW9cIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLnByb3AoXCJjaGVja2VkXCIsIGZhbHNlKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoaW5kZXg9PTApXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHJhZGlvcy5maWx0ZXIoJ1t2YWx1ZT1cIicrc3RhcnRfbWluKydcIl0nKS5wcm9wKFwiY2hlY2tlZFwiLCB0cnVlKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoaW5kZXg9PTEpXG4gICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHJhZGlvcy5maWx0ZXIoJ1t2YWx1ZT1cIicrc3RhcnRfbWF4KydcIl0nKS5wcm9wKFwiY2hlY2tlZFwiLCB0cnVlKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBcbiAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgLy9udW1iZXIgc2xpZGVyIC0gbm9VaVNsaWRlclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xuXG4gICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfb2JqZWN0ID0gJCh0aGlzKVswXTtcbiAgICAgICAgICAgICAgICAgICAgLyp2YXIgc2xpZGVyX29iamVjdCA9ICRjb250YWluZXIuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcbiAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfdmFsID0gc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmdldCgpOyovXG5cbiAgICAgICAgICAgICAgICAgICAgdmFyICRzbGlkZXJfZWwgPSAkKHRoaXMpLmNsb3Nlc3QoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5WYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1pbi1mb3JtYXR0ZWRcIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1heC1mb3JtYXR0ZWRcIik7XG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoW21pblZhbCwgbWF4VmFsXSk7XG5cbiAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgIC8vbmVlZCB0byBzZWUgaWYgYW55IGFyZSBjb21ib2JveCBhbmQgYWN0IGFjY29yZGluZ2x5XG4gICAgICAgICAgICAgICAgdmFyICRjb21ib2JveCA9ICRmaWVsZC5maW5kKFwic2VsZWN0W2RhdGEtY29tYm9ib3g9JzEnXVwiKTtcbiAgICAgICAgICAgICAgICBpZigkY29tYm9ib3gubGVuZ3RoPjApXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZiAodHlwZW9mICRjb21ib2JveC5jaG9zZW4gIT0gXCJ1bmRlZmluZWRcIilcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTsgLy9mb3IgY2hvc2VuIG9ubHlcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC52YWwoJycpO1xuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnRyaWdnZXIoJ2NoYW5nZS5zZWxlY3QyJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG5cblxuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBzZWxmLmNsZWFyVGltZXIoKTtcblxuICAgICAgICAgICAgaWYoc3VibWl0X2Zvcm09PVwiYWx3YXlzXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgc2VsZi5zdWJtaXRGb3JtKCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIGlmKHN1Ym1pdF9mb3JtPT1cIm5ldmVyXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWYodGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSlcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHNlbGYuZm9ybVVwZGF0ZWRGZXRjaEFqYXgoKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBlbHNlIGlmKHN1Ym1pdF9mb3JtPT1cImF1dG9cIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fdXBkYXRlPT10cnVlKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5zdWJtaXRGb3JtKCk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2VcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpXG4gICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuZm9ybVVwZGF0ZWRGZXRjaEFqYXgoKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuaW5pdCgpO1xuXG4gICAgICAgIHZhciBldmVudF9kYXRhID0ge307XG4gICAgICAgIGV2ZW50X2RhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcbiAgICAgICAgZXZlbnRfZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcbiAgICAgICAgZXZlbnRfZGF0YS5vYmplY3QgPSB0aGlzO1xuICAgICAgICBpZihvcHRzLmlzSW5pdClcbiAgICAgICAge1xuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjppbml0XCIsIGV2ZW50X2RhdGEpO1xuICAgICAgICB9XG5cbiAgICB9KTtcbn07XG5cbn0pLmNhbGwodGhpcyx0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsIDogdHlwZW9mIHNlbGYgIT09IFwidW5kZWZpbmVkXCIgPyBzZWxmIDogdHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvdyA6IHt9KVxuLy8jIHNvdXJjZU1hcHBpbmdVUkw9ZGF0YTphcHBsaWNhdGlvbi9qc29uO2NoYXJzZXQ6dXRmLTg7YmFzZTY0LGV5SjJaWEp6YVc5dUlqb3pMQ0p6YjNWeVkyVnpJanBiSW5OeVl5OXdkV0pzYVdNdllYTnpaWFJ6TDJwekwybHVZMngxWkdWekwzQnNkV2RwYmk1cWN5SmRMQ0p1WVcxbGN5STZXMTBzSW0xaGNIQnBibWR6SWpvaU8wRkJRVUU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQklpd2labWxzWlNJNkltZGxibVZ5WVhSbFpDNXFjeUlzSW5OdmRYSmpaVkp2YjNRaU9pSWlMQ0p6YjNWeVkyVnpRMjl1ZEdWdWRDSTZXeUpjYm5aaGNpQWtJRngwWEhSY2RGeDBQU0FvZEhsd1pXOW1JSGRwYm1SdmR5QWhQVDBnWENKMWJtUmxabWx1WldSY0lpQS9JSGRwYm1SdmQxc25hbEYxWlhKNUoxMGdPaUIwZVhCbGIyWWdaMnh2WW1Gc0lDRTlQU0JjSW5WdVpHVm1hVzVsWkZ3aUlEOGdaMnh2WW1Gc1d5ZHFVWFZsY25rblhTQTZJRzUxYkd3cE8xeHVkbUZ5SUhOMFlYUmxJRngwWEhSY2REMGdjbVZ4ZFdseVpTZ25MaTl6ZEdGMFpTY3BPMXh1ZG1GeUlIQnliMk5sYzNOZlptOXliU0JjZEQwZ2NtVnhkV2x5WlNnbkxpOXdjbTlqWlhOelgyWnZjbTBuS1R0Y2JuWmhjaUJ1YjFWcFUyeHBaR1Z5WEhSY2REMGdjbVZ4ZFdseVpTZ25ibTkxYVhOc2FXUmxjaWNwTzF4dUx5OTJZWElnWTI5dmEybGxjeUFnSUNBZ0lDQWdJRDBnY21WeGRXbHlaU2duYW5NdFkyOXZhMmxsSnlrN1hHNTJZWElnZEdocGNtUlFZWEowZVNBZ0lDQWdJRDBnY21WeGRXbHlaU2duTGk5MGFHbHlaSEJoY25SNUp5azdYRzVjYm5kcGJtUnZkeTV6WldGeVkyaEJibVJHYVd4MFpYSWdQU0I3WEc0Z0lDQWdaWGgwWlc1emFXOXVjem9nVzEwc1hHNGdJQ0FnY21WbmFYTjBaWEpGZUhSbGJuTnBiMjQ2SUdaMWJtTjBhVzl1S0NCbGVIUmxibk5wYjI1T1lXMWxJQ2tnZTF4dUlDQWdJQ0FnSUNCMGFHbHpMbVY0ZEdWdWMybHZibk11Y0hWemFDZ2daWGgwWlc1emFXOXVUbUZ0WlNBcE8xeHVJQ0FnSUgxY2JuMDdYRzVjYm0xdlpIVnNaUzVsZUhCdmNuUnpJRDBnWm5WdVkzUnBiMjRvYjNCMGFXOXVjeWxjYm50Y2JpQWdJQ0IyWVhJZ1pHVm1ZWFZzZEhNZ1BTQjdYRzRnSUNBZ0lDQWdJSE4wWVhKMFQzQmxibVZrT2lCbVlXeHpaU3hjYmlBZ0lDQWdJQ0FnYVhOSmJtbDBPaUIwY25WbExGeHVJQ0FnSUNBZ0lDQmhZM1JwYjI0NklGd2lYQ0pjYmlBZ0lDQjlPMXh1WEc0Z0lDQWdkbUZ5SUc5d2RITWdQU0JxVVhWbGNua3VaWGgwWlc1a0tHUmxabUYxYkhSekxDQnZjSFJwYjI1ektUdGNiaUFnSUNCY2JpQWdJQ0IwYUdseVpGQmhjblI1TG1sdWFYUW9LVHRjYmlBZ0lDQmNiaUFnSUNBdkwyeHZiM0FnZEdoeWIzVm5hQ0JsWVdOb0lHbDBaVzBnYldGMFkyaGxaRnh1SUNBZ0lIUm9hWE11WldGamFDaG1kVzVqZEdsdmJpZ3BYRzRnSUNBZ2UxeHVYRzRnSUNBZ0lDQWdJSFpoY2lBa2RHaHBjeUE5SUNRb2RHaHBjeWs3WEc0Z0lDQWdJQ0FnSUhaaGNpQnpaV3htSUQwZ2RHaHBjenRjYmlBZ0lDQWdJQ0FnZEdocGN5NXpabWxrSUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdGMyWXRabTl5YlMxcFpGd2lLVHRjYmx4dUlDQWdJQ0FnSUNCemRHRjBaUzVoWkdSVFpXRnlZMmhHYjNKdEtIUm9hWE11YzJacFpDd2dkR2hwY3lrN1hHNWNiaUFnSUNBZ0lDQWdkR2hwY3k0a1ptbGxiR1J6SUQwZ0pIUm9hWE11Wm1sdVpDaGNJajRnZFd3Z1BpQnNhVndpS1RzZ0x5OWhJSEpsWm1WeVpXNWpaU0IwYnlCbFlXTm9JR1pwWld4a2N5QndZWEpsYm5RZ1RFbGNibHh1SUNBZ0lDQWdJQ0IwYUdsekxtVnVZV0pzWlY5MFlYaHZibTl0ZVY5aGNtTm9hWFpsY3lBOUlDUjBhR2x6TG1GMGRISW9KMlJoZEdFdGRHRjRiMjV2YlhrdFlYSmphR2wyWlhNbktUdGNiaUFnSUNBZ0lDQWdkR2hwY3k1amRYSnlaVzUwWDNSaGVHOXViMjE1WDJGeVkyaHBkbVVnUFNBa2RHaHBjeTVoZEhSeUtDZGtZWFJoTFdOMWNuSmxiblF0ZEdGNGIyNXZiWGt0WVhKamFHbDJaU2NwTzF4dVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG1WdVlXSnNaVjkwWVhodmJtOXRlVjloY21Ob2FYWmxjeWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYRzRnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11Wlc1aFlteGxYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVnpJRDBnWENJd1hDSTdYRzRnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hSb2FYTXVZM1Z5Y21WdWRGOTBZWGh2Ym05dGVWOWhjbU5vYVhabEtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWpkWEp5Wlc1MFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1VZ1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdjSEp2WTJWemMxOW1iM0p0TG1sdWFYUW9jMlZzWmk1bGJtRmliR1ZmZEdGNGIyNXZiWGxmWVhKamFHbDJaWE1zSUhObGJHWXVZM1Z5Y21WdWRGOTBZWGh2Ym05dGVWOWhjbU5vYVhabEtUdGNiaUFnSUNBZ0lDQWdMeTl3Y205alpYTnpYMlp2Y20wdWMyVjBWR0Y0UVhKamFHbDJaVkpsYzNWc2RITlZjbXdvYzJWc1ppazdYRzRnSUNBZ0lDQWdJSEJ5YjJObGMzTmZabTl5YlM1bGJtRmliR1ZKYm5CMWRITW9jMlZzWmlrN1hHNWNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdVpYaDBjbUZmY1hWbGNubGZjR0Z5WVcxektUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWxlSFJ5WVY5eGRXVnllVjl3WVhKaGJYTWdQU0I3WVd4c09pQjdmU3dnY21WemRXeDBjem9nZTMwc0lHRnFZWGc2SUh0OWZUdGNiaUFnSUNBZ0lDQWdmVnh1WEc1Y2JpQWdJQ0FnSUNBZ2RHaHBjeTUwWlcxd2JHRjBaVjlwYzE5c2IyRmtaV1FnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxMFpXMXdiR0YwWlMxc2IyRmtaV1JjSWlrN1hHNGdJQ0FnSUNBZ0lIUm9hWE11YVhOZllXcGhlQ0E5SUNSMGFHbHpMbUYwZEhJb1hDSmtZWFJoTFdGcVlYaGNJaWs3WEc0Z0lDQWdJQ0FnSUhSb2FYTXVhVzV6ZEdGdVkyVmZiblZ0WW1WeUlEMGdKSFJvYVhNdVlYUjBjaWduWkdGMFlTMXBibk4wWVc1alpTMWpiM1Z1ZENjcE8xeHVJQ0FnSUNBZ0lDQjBhR2x6TGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlJRDBnYWxGMVpYSjVLQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV0ZxWVhndGRHRnlaMlYwWENJcEtUdGNibHh1SUNBZ0lDQWdJQ0IwYUdsekxtRnFZWGhmZFhCa1lYUmxYM05sWTNScGIyNXpJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0WVdwaGVDMTFjR1JoZEdVdGMyVmpkR2x2Ym5OY0lpa2dQeUJLVTA5T0xuQmhjbk5sS0NBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxaGFtRjRMWFZ3WkdGMFpTMXpaV04wYVc5dWMxd2lLU0FwSURvZ1cxMDdYRzRnSUNBZ0lDQWdJSFJvYVhNdWNtVndiR0ZqWlY5eVpYTjFiSFJ6SUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdGNtVndiR0ZqWlMxeVpYTjFiSFJ6WENJcElEMDlQU0JjSWpCY0lpQS9JR1poYkhObElEb2dkSEoxWlR0Y2JpQWdJQ0FnSUNBZ1hHNGdJQ0FnSUNBZ0lIUm9hWE11Y21WemRXeDBjMTkxY213Z1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMXlaWE4xYkhSekxYVnliRndpS1R0Y2JpQWdJQ0FnSUNBZ2RHaHBjeTVrWldKMVoxOXRiMlJsSUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdFpHVmlkV2N0Ylc5a1pWd2lLVHRjYmlBZ0lDQWdJQ0FnZEdocGN5NTFjR1JoZEdWZllXcGhlRjkxY213Z1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMTFjR1JoZEdVdFlXcGhlQzExY214Y0lpazdYRzRnSUNBZ0lDQWdJSFJvYVhNdWNHRm5hVzVoZEdsdmJsOTBlWEJsSUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdFlXcGhlQzF3WVdkcGJtRjBhVzl1TFhSNWNHVmNJaWs3WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZWFYwYjE5amIzVnVkQ0E5SUNSMGFHbHpMbUYwZEhJb1hDSmtZWFJoTFdGMWRHOHRZMjkxYm5SY0lpazdYRzRnSUNBZ0lDQWdJSFJvYVhNdVlYVjBiMTlqYjNWdWRGOXlaV1p5WlhOb1gyMXZaR1VnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxaGRYUnZMV052ZFc1MExYSmxabkpsYzJndGJXOWtaVndpS1R0Y2JpQWdJQ0FnSUNBZ2RHaHBjeTV2Ym14NVgzSmxjM1ZzZEhOZllXcGhlQ0E5SUNSMGFHbHpMbUYwZEhJb1hDSmtZWFJoTFc5dWJIa3RjbVZ6ZFd4MGN5MWhhbUY0WENJcE95QXZMMmxtSUhkbElHRnlaU0J1YjNRZ2IyNGdkR2hsSUhKbGMzVnNkSE1nY0dGblpTd2djbVZrYVhKbFkzUWdjbUYwYUdWeUlIUm9ZVzRnZEhKNUlIUnZJR3h2WVdRZ2RtbGhJR0ZxWVhoY2JpQWdJQ0FnSUNBZ2RHaHBjeTV6WTNKdmJHeGZkRzlmY0c5eklEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRjMk55YjJ4c0xYUnZMWEJ2YzF3aUtUdGNiaUFnSUNBZ0lDQWdkR2hwY3k1amRYTjBiMjFmYzJOeWIyeHNYM1J2SUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdFkzVnpkRzl0TFhOamNtOXNiQzEwYjF3aUtUdGNiaUFnSUNBZ0lDQWdkR2hwY3k1elkzSnZiR3hmYjI1ZllXTjBhVzl1SUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdGMyTnliMnhzTFc5dUxXRmpkR2x2Ymx3aUtUdGNiaUFnSUNBZ0lDQWdkR2hwY3k1c1lXNW5YMk52WkdVZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMXNZVzVuTFdOdlpHVmNJaWs3WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZV3BoZUY5MWNtd2dQU0FrZEdocGN5NWhkSFJ5S0Nka1lYUmhMV0ZxWVhndGRYSnNKeWs3WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZV3BoZUY5bWIzSnRYM1Z5YkNBOUlDUjBhR2x6TG1GMGRISW9KMlJoZEdFdFlXcGhlQzFtYjNKdExYVnliQ2NwTzF4dUlDQWdJQ0FnSUNCMGFHbHpMbWx6WDNKMGJDQTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRhWE10Y25Sc0p5azdYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NWthWE53YkdGNVgzSmxjM1ZzZEY5dFpYUm9iMlFnUFNBa2RHaHBjeTVoZEhSeUtDZGtZWFJoTFdScGMzQnNZWGt0Y21WemRXeDBMVzFsZEdodlpDY3BPMXh1SUNBZ0lDQWdJQ0IwYUdsekxtMWhhVzUwWVdsdVgzTjBZWFJsSUQwZ0pIUm9hWE11WVhSMGNpZ25aR0YwWVMxdFlXbHVkR0ZwYmkxemRHRjBaU2NwTzF4dUlDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZllXTjBhVzl1SUQwZ1hDSmNJanRjYmlBZ0lDQWdJQ0FnZEdocGN5NXNZWE4wWDNOMVltMXBkRjl4ZFdWeWVWOXdZWEpoYlhNZ1BTQmNJbHdpTzF4dVhHNGdJQ0FnSUNBZ0lIUm9hWE11WTNWeWNtVnVkRjl3WVdkbFpDQTlJSEJoY25ObFNXNTBLQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRhVzVwZEMxd1lXZGxaQ2NwS1R0Y2JpQWdJQ0FnSUNBZ2RHaHBjeTVzWVhOMFgyeHZZV1JmYlc5eVpWOW9kRzFzSUQwZ1hDSmNJanRjYmlBZ0lDQWdJQ0FnZEdocGN5NXNiMkZrWDIxdmNtVmZhSFJ0YkNBOUlGd2lYQ0k3WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZV3BoZUY5a1lYUmhYM1I1Y0dVZ1BTQWtkR2hwY3k1aGRIUnlLQ2RrWVhSaExXRnFZWGd0WkdGMFlTMTBlWEJsSnlrN1hHNGdJQ0FnSUNBZ0lIUm9hWE11WVdwaGVGOTBZWEpuWlhSZllYUjBjaUE5SUNSMGFHbHpMbUYwZEhJb1hDSmtZWFJoTFdGcVlYZ3RkR0Z5WjJWMFhDSXBPMXh1SUNBZ0lDQWdJQ0IwYUdsekxuVnpaVjlvYVhOMGIzSjVYMkZ3YVNBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExYVnpaUzFvYVhOMGIzSjVMV0Z3YVZ3aUtUdGNiaUFnSUNBZ0lDQWdkR2hwY3k1cGMxOXpkV0p0YVhSMGFXNW5JRDBnWm1Gc2MyVTdYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDQTlJRzUxYkd3N1hHNWNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdWNtVnpkV3gwYzE5b2RHMXNLVDA5WENKMWJtUmxabWx1WldSY0lpbGNiaUFnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTV5WlhOMWJIUnpYMmgwYld3Z1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdWNtVnpkV3gwYzE5d1lXZGxYMmgwYld3cFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4dUlDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxuSmxjM1ZzZEhOZmNHRm5aVjlvZEcxc0lEMGdYQ0pjSWp0Y2JpQWdJQ0FnSUNBZ2ZWeHVYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxuVnpaVjlvYVhOMGIzSjVYMkZ3YVNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEc0Z0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWRYTmxYMmhwYzNSdmNubGZZWEJwSUQwZ1hDSmNJanRjYmlBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG5CaFoybHVZWFJwYjI1ZmRIbHdaU2s5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYRzRnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11Y0dGbmFXNWhkR2x2Ymw5MGVYQmxJRDBnWENKdWIzSnRZV3hjSWp0Y2JpQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1amRYSnlaVzUwWDNCaFoyVmtLVDA5WENKMWJtUmxabWx1WldSY0lpbGNiaUFnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVqZFhKeVpXNTBYM0JoWjJWa0lEMGdNVHRjYmlBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG1GcVlYaGZkR0Z5WjJWMFgyRjBkSElwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh1SUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1GcVlYaGZkR0Z5WjJWMFgyRjBkSElnUFNCY0lsd2lPMXh1SUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11WVdwaGVGOTFjbXdwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh1SUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1GcVlYaGZkWEpzSUQwZ1hDSmNJanRjYmlBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG1GcVlYaGZabTl5YlY5MWNtd3BQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZlptOXliVjkxY213Z1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdWNtVnpkV3gwYzE5MWNtd3BQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbkpsYzNWc2RITmZkWEpzSUQwZ1hDSmNJanRjYmlBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG5OamNtOXNiRjkwYjE5d2IzTXBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbk5qY205c2JGOTBiMTl3YjNNZ1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdWMyTnliMnhzWDI5dVgyRmpkR2x2YmlrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEc0Z0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWMyTnliMnhzWDI5dVgyRmpkR2x2YmlBOUlGd2lYQ0k3WEc0Z0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11WTNWemRHOXRYM05qY205c2JGOTBieWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYRzRnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11WTNWemRHOXRYM05qY205c2JGOTBieUE5SUZ3aVhDSTdYRzRnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnZEdocGN5NGtZM1Z6ZEc5dFgzTmpjbTlzYkY5MGJ5QTlJR3BSZFdWeWVTaDBhR2x6TG1OMWMzUnZiVjl6WTNKdmJHeGZkRzhwTzF4dVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG5Wd1pHRjBaVjloYW1GNFgzVnliQ2s5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYRzRnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11ZFhCa1lYUmxYMkZxWVhoZmRYSnNJRDBnWENKY0lqdGNiaUFnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbVJsWW5WblgyMXZaR1VwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh1SUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1SbFluVm5YMjF2WkdVZ1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdVlXcGhlRjkwWVhKblpYUmZiMkpxWldOMEtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDNSaGNtZGxkRjl2WW1wbFkzUWdQU0JjSWx3aU8xeHVJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hSb2FYTXVkR1Z0Y0d4aGRHVmZhWE5mYkc5aFpHVmtLVDA5WENKMWJtUmxabWx1WldSY0lpbGNiaUFnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTUwWlcxd2JHRjBaVjlwYzE5c2IyRmtaV1FnUFNCY0lqQmNJanRjYmlBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG1GMWRHOWZZMjkxYm5SZmNtVm1jbVZ6YUY5dGIyUmxLVDA5WENKMWJtUmxabWx1WldSY0lpbGNiaUFnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVoZFhSdlgyTnZkVzUwWDNKbFpuSmxjMmhmYlc5a1pTQTlJRndpTUZ3aU8xeHVJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDJ4cGJtdHpYM05sYkdWamRHOXlJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0WVdwaGVDMXNhVzVyY3kxelpXeGxZM1J2Y2x3aUtUdGNibHh1WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZWFYwYjE5MWNHUmhkR1VnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxaGRYUnZMWFZ3WkdGMFpWd2lLVHRjYmlBZ0lDQWdJQ0FnZEdocGN5NXBibkIxZEZScGJXVnlJRDBnTUR0Y2JseHVJQ0FnSUNBZ0lDQjBhR2x6TG5ObGRFbHVabWx1YVhSbFUyTnliMnhzUTI5dWRHRnBibVZ5SUQwZ1puVnVZM1JwYjI0b0tWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBdkx5QlhhR1Z1SUhkbElHNWhkbWxuWVhSbElHRjNZWGtnWm5KdmJTQnpaV0Z5WTJnZ2NtVnpkV3gwY3l3Z1lXNWtJSFJvWlc0Z2NISmxjM01nWW1GamF5eGNiaUFnSUNBZ0lDQWdJQ0FnSUM4dklHbHpYMjFoZUY5d1lXZGxaQ0JwY3lCeVpYUmhhVzVsWkN3Z2MyOGdkMlVnYjI1c2VTQjNZVzUwSUhSdklITmxkQ0JwZENCMGJ5Qm1ZV3h6WlNCcFpseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk4Z2QyVWdZWEpsSUdsdWFYUmhiR2w2YVc1bklIUm9aU0J5WlhOMWJIUnpJSEJoWjJVZ2RHaGxJR1pwY25OMElIUnBiV1VnTFNCemJ5QnFkWE4wSUZ4dUlDQWdJQ0FnSUNBZ0lDQWdMeThnWTJobFkyc2dhV1lnZEdocGN5QjJZWElnYVhNZ2RXNWtaV1pwYm1Wa0lDaGhjeUJwZENCemFHOTFiR1FnWW1VZ2IyNGdabWx5YzNRZ2RYTmxLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2dnZEhsd1pXOW1JQ2dnZEdocGN5NXBjMTl0WVhoZmNHRm5aV1FnS1NBOVBUMGdKM1Z1WkdWbWFXNWxaQ2NnS1NCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVwYzE5dFlYaGZjR0ZuWldRZ1BTQm1ZV3h6WlRzZ0x5OW1iM0lnYkc5aFpDQnRiM0psSUc5dWJIa3NJRzl1WTJVZ2QyVWdaR1YwWldOMElIZGxKM0psSUdGMElIUm9aU0JsYm1RZ2MyVjBJSFJvYVhNZ2RHOGdkSEoxWlZ4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG5WelpWOXpZM0p2Ykd4ZmJHOWhaR1Z5SUQwZ0pIUm9hWE11WVhSMGNpZ25aR0YwWVMxemFHOTNMWE5qY205c2JDMXNiMkZrWlhJbktUdGNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpQTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRhVzVtYVc1cGRHVXRjMk55YjJ4c0xXTnZiblJoYVc1bGNpY3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVwYm1acGJtbDBaVjl6WTNKdmJHeGZkSEpwWjJkbGNsOWhiVzkxYm5RZ1BTQWtkR2hwY3k1aGRIUnlLQ2RrWVhSaExXbHVabWx1YVhSbExYTmpjbTlzYkMxMGNtbG5aMlZ5SnlrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxtbHVabWx1YVhSbFgzTmpjbTlzYkY5eVpYTjFiSFJmWTJ4aGMzTWdQU0FrZEdocGN5NWhkSFJ5S0Nka1lYUmhMV2x1Wm1sdWFYUmxMWE5qY205c2JDMXlaWE4xYkhRdFkyeGhjM01uS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdUpHbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJZ1BTQjBhR2x6TGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1cGJtWnBibWwwWlY5elkzSnZiR3hmWTI5dWRHRnBibVZ5S1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1sdVptbHVhWFJsWDNOamNtOXNiRjlqYjI1MFlXbHVaWElnUFNCY0lsd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVKR2x1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSWdQU0JxVVhWbGNua29kR2hwY3k1aGFtRjRYM1JoY21kbGRGOWhkSFJ5SUNzZ0p5QW5JQ3NnZEdocGN5NXBibVpwYm1sMFpWOXpZM0p2Ykd4ZlkyOXVkR0ZwYm1WeUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hSb2FYTXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzSmxjM1ZzZEY5amJHRnpjeWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVwYm1acGJtbDBaVjl6WTNKdmJHeGZjbVZ6ZFd4MFgyTnNZWE56SUQwZ1hDSmNJanRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11ZFhObFgzTmpjbTlzYkY5c2IyRmtaWElwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11ZFhObFgzTmpjbTlzYkY5c2IyRmtaWElnUFNBeE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lIMDdYRzRnSUNBZ0lDQWdJSFJvYVhNdWMyVjBTVzVtYVc1cGRHVlRZM0p2Ykd4RGIyNTBZV2x1WlhJb0tUdGNibHh1SUNBZ0lDQWdJQ0F2S2lCbWRXNWpkR2x2Ym5NZ0tpOWNibHh1SUNBZ0lDQWdJQ0IwYUdsekxuSmxjMlYwSUQwZ1puVnVZM1JwYjI0b2MzVmliV2wwWDJadmNtMHBYRzRnSUNBZ0lDQWdJSHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1eVpYTmxkRVp2Y20wb2MzVmliV2wwWDJadmNtMHBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUhSeWRXVTdYRzRnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNCMGFHbHpMbWx1Y0hWMFZYQmtZWFJsSUQwZ1puVnVZM1JwYjI0b1pHVnNZWGxFZFhKaGRHbHZiaWxjYmlBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LR1JsYkdGNVJIVnlZWFJwYjI0cFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1pXeGhlVVIxY21GMGFXOXVJRDBnTXpBd08xeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxuSmxjMlYwVkdsdFpYSW9aR1ZzWVhsRWRYSmhkR2x2YmlrN1hHNGdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0IwYUdsekxuTmpjbTlzYkZSdlVHOXpJRDBnWm5WdVkzUnBiMjRvS1NCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2IyWm1jMlYwSUQwZ01EdGNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmpZVzVUWTNKdmJHd2dQU0IwY25WbE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgyRnFZWGc5UFRFcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTV6WTNKdmJHeGZkRzlmY0c5elBUMWNJbmRwYm1SdmQxd2lLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2IyWm1jMlYwSUQwZ01EdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElHbG1LSE5sYkdZdWMyTnliMnhzWDNSdlgzQnZjejA5WENKbWIzSnRYQ0lwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnZabVp6WlhRZ1BTQWtkR2hwY3k1dlptWnpaWFFvS1M1MGIzQTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9jMlZzWmk1elkzSnZiR3hmZEc5ZmNHOXpQVDFjSW5KbGMzVnNkSE5jSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVKR0ZxWVhoZmNtVnpkV3gwYzE5amIyNTBZV2x1WlhJdWJHVnVaM1JvUGpBcFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzltWm5ObGRDQTlJSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1YjJabWMyVjBLQ2t1ZEc5d08xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYzJWc1ppNXpZM0p2Ykd4ZmRHOWZjRzl6UFQxY0ltTjFjM1J2YlZ3aUtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5amRYTjBiMjFmYzJOeWIyeHNYM1J2WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdUpHTjFjM1J2YlY5elkzSnZiR3hmZEc4dWJHVnVaM1JvUGpBcFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzltWm5ObGRDQTlJSE5sYkdZdUpHTjFjM1J2YlY5elkzSnZiR3hmZEc4dWIyWm1jMlYwS0NrdWRHOXdPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlZjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHTmhibE5qY205c2JDQTlJR1poYkhObE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dOaGJsTmpjbTlzYkNsY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1FvWENKb2RHMXNMQ0JpYjJSNVhDSXBMbk4wYjNBb0tTNWhibWx0WVhSbEtIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmpjbTlzYkZSdmNEb2diMlptYzJWMFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDBzSUZ3aWJtOXliV0ZzWENJc0lGd2laV0Z6WlU5MWRGRjFZV1JjSWlBcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQjlPMXh1WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZWFIwWVdOb1FXTjBhWFpsUTJ4aGMzTWdQU0JtZFc1amRHbHZiaWdwZTF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJOb1pXTnJJSFJ2SUhObFpTQnBaaUIzWlNCaGNtVWdkWE5wYm1jZ1lXcGhlQ0FtSUdGMWRHOGdZMjkxYm5SY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2YVdZZ2JtOTBMQ0IwYUdVZ2MyVmhjbU5vSUdadmNtMGdaRzlsY3lCdWIzUWdaMlYwSUhKbGJHOWhaR1ZrTENCemJ5QjNaU0J1WldWa0lIUnZJSFZ3WkdGMFpTQjBhR1VnYzJZdGIzQjBhVzl1TFdGamRHbDJaU0JqYkdGemN5QnZiaUJoYkd3Z1ptbGxiR1J6WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdsekxtOXVLQ2RqYUdGdVoyVW5MQ0FuYVc1d2RYUmJkSGx3WlQxY0luSmhaR2x2WENKZExDQnBibkIxZEZ0MGVYQmxQVndpWTJobFkydGliM2hjSWwwc0lITmxiR1ZqZENjc0lHWjFibU4wYVc5dUtHVXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JqZEdocGN5QTlJQ1FvZEdocGN5azdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSamRHaHBjMTl3WVhKbGJuUWdQU0FrWTNSb2FYTXVZMnh2YzJWemRDaGNJbXhwVzJSaGRHRXRjMll0Wm1sbGJHUXRibUZ0WlYxY0lpazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhSb2FYTmZkR0ZuSUQwZ0pHTjBhR2x6TG5CeWIzQW9YQ0owWVdkT1lXMWxYQ0lwTG5SdlRHOTNaWEpEWVhObEtDazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdsdWNIVjBYM1I1Y0dVZ1BTQWtZM1JvYVhNdVlYUjBjaWhjSW5SNWNHVmNJaWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIQmhjbVZ1ZEY5MFlXY2dQU0FrWTNSb2FYTmZjR0Z5Wlc1MExuQnliM0FvWENKMFlXZE9ZVzFsWENJcExuUnZURzkzWlhKRFlYTmxLQ2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ29kR2hwYzE5MFlXYzlQVndpYVc1d2RYUmNJaWttSmlnb2FXNXdkWFJmZEhsd1pUMDlYQ0p5WVdScGIxd2lLWHg4S0dsdWNIVjBYM1I1Y0dVOVBWd2lZMmhsWTJ0aWIzaGNJaWtwSUNZbUlDaHdZWEpsYm5SZmRHRm5QVDFjSW14cFhDSXBLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JoYkd4ZmIzQjBhVzl1Y3lBOUlDUmpkR2hwYzE5d1lYSmxiblF1Y0dGeVpXNTBLQ2t1Wm1sdVpDZ25iR2tuS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSaGJHeGZiM0IwYVc5dWMxOW1hV1ZzWkhNZ1BTQWtZM1JvYVhOZmNHRnlaVzUwTG5CaGNtVnVkQ2dwTG1acGJtUW9KMmx1Y0hWME9tTm9aV05yWldRbktUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1lXeHNYMjl3ZEdsdmJuTXVjbVZ0YjNabFEyeGhjM01vWENKelppMXZjSFJwYjI0dFlXTjBhWFpsWENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWVd4c1gyOXdkR2x2Ym5OZlptbGxiR1J6TG1WaFkyZ29ablZ1WTNScGIyNG9LWHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUndZWEpsYm5RZ1BTQWtLSFJvYVhNcExtTnNiM05sYzNRb1hDSnNhVndpS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSd1lYSmxiblF1WVdSa1EyeGhjM01vWENKelppMXZjSFJwYjI0dFlXTjBhWFpsWENJcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9kR2hwYzE5MFlXYzlQVndpYzJWc1pXTjBYQ0lwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdGc2JGOXZjSFJwYjI1eklEMGdKR04wYUdsekxtTm9hV3hrY21WdUtDazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSaGJHeGZiM0IwYVc5dWN5NXlaVzF2ZG1WRGJHRnpjeWhjSW5ObUxXOXdkR2x2YmkxaFkzUnBkbVZjSWlrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMGFHbHpYM1poYkNBOUlDUmpkR2hwY3k1MllXd29LVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnZEdocGMxOWhjbkpmZG1Gc0lEMGdLSFI1Y0dWdlppQjBhR2x6WDNaaGJDQTlQU0FuYzNSeWFXNW5KeUI4ZkNCMGFHbHpYM1poYkNCcGJuTjBZVzVqWlc5bUlGTjBjbWx1WnlrZ1B5QmJkR2hwYzE5MllXeGRJRG9nZEdocGMxOTJZV3c3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQ2gwYUdselgyRnljbDkyWVd3cExtVmhZMmdvWm5WdVkzUnBiMjRvYVN3Z2RtRnNkV1VwZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdOMGFHbHpMbVpwYm1Rb1hDSnZjSFJwYjI1YmRtRnNkV1U5SjF3aUszWmhiSFZsSzF3aUoxMWNJaWt1WVdSa1EyeGhjM01vWENKelppMXZjSFJwYjI0dFlXTjBhWFpsWENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2JseHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYRzVjYmlBZ0lDQWdJQ0FnZlR0Y2JpQWdJQ0FnSUNBZ2RHaHBjeTVwYm1sMFFYVjBiMVZ3WkdGMFpVVjJaVzUwY3lBOUlHWjFibU4wYVc5dUtDbDdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHFJR0YxZEc4Z2RYQmtZWFJsSUNvdlhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlnb2MyVnNaaTVoZFhSdlgzVndaR0YwWlQwOU1TbDhmQ2h6Wld4bUxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsUFQweEtTbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTV2YmlnblkyaGhibWRsSnl3Z0oybHVjSFYwVzNSNWNHVTlYQ0p5WVdScGIxd2lYU3dnYVc1d2RYUmJkSGx3WlQxY0ltTm9aV05yWW05NFhDSmRMQ0J6Wld4bFkzUW5MQ0JtZFc1amRHbHZiaWhsS1NCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFXNXdkWFJWY0dSaGRHVW9NakF3S1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdsekxtOXVLQ2RwYm5CMWRDY3NJQ2RwYm5CMWRGdDBlWEJsUFZ3aWJuVnRZbVZ5WENKZEp5d2dablZ1WTNScGIyNG9aU2tnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWNIVjBWWEJrWVhSbEtEZ3dNQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhSbGVIUkpibkIxZENBOUlDUjBhR2x6TG1acGJtUW9KMmx1Y0hWMFczUjVjR1U5WENKMFpYaDBYQ0pkT201dmRDZ3VjMll0WkdGMFpYQnBZMnRsY2lrbktUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYkdGemRGWmhiSFZsSUQwZ0pIUmxlSFJKYm5CMWRDNTJZV3dvS1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG05dUtDZHBibkIxZENjc0lDZHBibkIxZEZ0MGVYQmxQVndpZEdWNGRGd2lYVHB1YjNRb0xuTm1MV1JoZEdWd2FXTnJaWElwSnl3Z1puVnVZM1JwYjI0b0tWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2JHRnpkRlpoYkhWbElUMGtkR1Y0ZEVsdWNIVjBMblpoYkNncEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHVjSFYwVlhCa1lYUmxLREV5TURBcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdiR0Z6ZEZaaGJIVmxJRDBnSkhSbGVIUkpibkIxZEM1MllXd29LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2JseHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdWIyNG9KMnRsZVhCeVpYTnpKeXdnSjJsdWNIVjBXM1I1Y0dVOVhDSjBaWGgwWENKZE9tNXZkQ2d1YzJZdFpHRjBaWEJwWTJ0bGNpa25MQ0JtZFc1amRHbHZiaWhsS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0dVdWQyaHBZMmdnUFQwZ01UTXBlMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsTG5CeVpYWmxiblJFWldaaGRXeDBLQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxuTjFZbTFwZEVadmNtMG9LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQm1ZV3h6WlR0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMeVIwYUdsekxtOXVLQ2RwYm5CMWRDY3NJQ2RwYm5CMWRDNXpaaTFrWVhSbGNHbGphMlZ5Snl3Z2MyVnNaaTVrWVhSbFNXNXdkWFJVZVhCbEtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQjlPMXh1WEc0Z0lDQWdJQ0FnSUM4dmRHaHBjeTVwYm1sMFFYVjBiMVZ3WkdGMFpVVjJaVzUwY3lncE8xeHVYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NWpiR1ZoY2xScGJXVnlJRDBnWm5WdVkzUnBiMjRvS1Z4dUlDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0JqYkdWaGNsUnBiV1Z2ZFhRb2MyVnNaaTVwYm5CMWRGUnBiV1Z5S1R0Y2JpQWdJQ0FnSUNBZ2ZUdGNiaUFnSUNBZ0lDQWdkR2hwY3k1eVpYTmxkRlJwYldWeUlEMGdablZ1WTNScGIyNG9aR1ZzWVhsRWRYSmhkR2x2YmlsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnWTJ4bFlYSlVhVzFsYjNWMEtITmxiR1l1YVc1d2RYUlVhVzFsY2lrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHVjSFYwVkdsdFpYSWdQU0J6WlhSVWFXMWxiM1YwS0hObGJHWXVabTl5YlZWd1pHRjBaV1FzSUdSbGJHRjVSSFZ5WVhScGIyNHBPMXh1WEc0Z0lDQWdJQ0FnSUgwN1hHNWNiaUFnSUNBZ0lDQWdkR2hwY3k1aFpHUkVZWFJsVUdsamEyVnljeUE5SUdaMWJtTjBhVzl1S0NsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmtZWFJsWDNCcFkydGxjaUE5SUNSMGFHbHpMbVpwYm1Rb1hDSXVjMll0WkdGMFpYQnBZMnRsY2x3aUtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KR1JoZEdWZmNHbGphMlZ5TG14bGJtZDBhRDR3S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JrWVhSbFgzQnBZMnRsY2k1bFlXTm9LR1oxYm1OMGFXOXVLQ2w3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSMGFHbHpJRDBnSkNoMGFHbHpLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdWR2IzSnRZWFFnUFNCY0lsd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR0YwWlVSeWIzQmtiM2R1V1dWaGNpQTlJR1poYkhObE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1pHRjBaVVJ5YjNCa2IzZHVUVzl1ZEdnZ1BTQm1ZV3h6WlR0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHTnNiM05sYzNSZlpHRjBaVjkzY21Gd0lEMGdKSFJvYVhNdVkyeHZjMlZ6ZENoY0lpNXpabDlrWVhSbFgyWnBaV3hrWENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlna1kyeHZjMlZ6ZEY5a1lYUmxYM2R5WVhBdWJHVnVaM1JvUGpBcFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdWR2IzSnRZWFFnUFNBa1kyeHZjMlZ6ZEY5a1lYUmxYM2R5WVhBdVlYUjBjaWhjSW1SaGRHRXRaR0YwWlMxbWIzSnRZWFJjSWlrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1JqYkc5elpYTjBYMlJoZEdWZmQzSmhjQzVoZEhSeUtGd2laR0YwWVMxa1lYUmxMWFZ6WlMxNVpXRnlMV1J5YjNCa2IzZHVYQ0lwUFQweEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdWRWNtOXdaRzkzYmxsbFlYSWdQU0IwY25WbE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KR05zYjNObGMzUmZaR0YwWlY5M2NtRndMbUYwZEhJb1hDSmtZWFJoTFdSaGRHVXRkWE5sTFcxdmJuUm9MV1J5YjNCa2IzZHVYQ0lwUFQweEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdWRWNtOXdaRzkzYmsxdmJuUm9JRDBnZEhKMVpUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1lYUmxVR2xqYTJWeVQzQjBhVzl1Y3lBOUlIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbHViR2x1WlRvZ2RISjFaU3hjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5vYjNkUGRHaGxjazF2Ym5Sb2N6b2dkSEoxWlN4Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUc5dVUyVnNaV04wT2lCbWRXNWpkR2x2YmlobExDQm1jbTl0WDJacFpXeGtLWHNnYzJWc1ppNWtZWFJsVTJWc1pXTjBLR1VzSUdaeWIyMWZabWxsYkdRc0lDUW9kR2hwY3lrcE95QjlMRnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWlVadmNtMWhkRG9nWkdGMFpVWnZjbTFoZEN4Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1kyaGhibWRsVFc5dWRHZzZJR1JoZEdWRWNtOXdaRzkzYmsxdmJuUm9MRnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdZMmhoYm1kbFdXVmhjam9nWkdGMFpVUnliM0JrYjNkdVdXVmhjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOU8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YVhOZmNuUnNQVDB4S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJsVUdsamEyVnlUM0IwYVc5dWN5NWthWEpsWTNScGIyNGdQU0JjSW5KMGJGd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTXVaR0YwWlhCcFkydGxjaWhrWVhSbFVHbGphMlZ5VDNCMGFXOXVjeWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNXNZVzVuWDJOdlpHVWhQVndpWENJcFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1F1WkdGMFpYQnBZMnRsY2k1elpYUkVaV1poZFd4MGN5aGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrTG1WNGRHVnVaQ2hjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdleWRrWVhSbFJtOXliV0YwSnpwa1lYUmxSbTl5YldGMGZTeGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pDNWtZWFJsY0dsamEyVnlMbkpsWjJsdmJtRnNXeUJ6Wld4bUxteGhibWRmWTI5a1pWMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa0xtUmhkR1Z3YVdOclpYSXVjMlYwUkdWbVlYVnNkSE1vWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pDNWxlSFJsYm1Rb1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhzblpHRjBaVVp2Y20xaGRDYzZaR0YwWlVadmNtMWhkSDBzWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1F1WkdGMFpYQnBZMnRsY2k1eVpXZHBiMjVoYkZ0Y0ltVnVYQ0pkWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0tWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0tUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDUW9KeTVzYkMxemEybHVMVzFsYkc5dUp5a3ViR1Z1WjNSb1BUMHdLWHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtaR0YwWlY5d2FXTnJaWEl1WkdGMFpYQnBZMnRsY2lnbmQybGtaMlYwSnlrdWQzSmhjQ2duUEdScGRpQmpiR0Z6Y3oxY0lteHNMWE5yYVc0dGJXVnNiMjRnYzJWaGNtTm9ZVzVrWm1sc2RHVnlMV1JoZEdVdGNHbGphMlZ5WENJdlBpY3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0I5TzF4dVhHNGdJQ0FnSUNBZ0lIUm9hWE11WkdGMFpWTmxiR1ZqZENBOUlHWjFibU4wYVc5dUtHVXNJR1p5YjIxZlptbGxiR1FzSUNSMGFHbHpLVnh1SUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdsdWNIVjBYMlpwWld4a0lEMGdKQ2htY205dFgyWnBaV3hrTG1sdWNIVjBMbWRsZENnd0tTazdYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSFJvYVhNZ1BTQWtLSFJvYVhNcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR1JoZEdWZlptbGxiR1J6SUQwZ0pHbHVjSFYwWDJacFpXeGtMbU5zYjNObGMzUW9KMXRrWVhSaExYTm1MV1pwWld4a0xXbHVjSFYwTFhSNWNHVTlYQ0prWVhSbGNtRnVaMlZjSWwwc0lGdGtZWFJoTFhObUxXWnBaV3hrTFdsdWNIVjBMWFI1Y0dVOVhDSmtZWFJsWENKZEp5azdYRzRnSUNBZ0lDQWdJQ0FnSUNBa1pHRjBaVjltYVdWc1pITXVaV0ZqYUNobWRXNWpkR2x2YmlobExDQnBibVJsZUNsN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwWmw5a1lYUmxYM0JwWTJ0bGNuTWdQU0FrS0hSb2FYTXBMbVpwYm1Rb1hDSXVjMll0WkdGMFpYQnBZMnRsY2x3aUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYm05ZlpHRjBaVjl3YVdOclpYSnpJRDBnSkhSbVgyUmhkR1ZmY0dsamEyVnljeTVzWlc1bmRHZzdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYm05ZlpHRjBaVjl3YVdOclpYSnpQakVwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1JvWlc0Z2FYUWdhWE1nWVNCa1lYUmxJSEpoYm1kbExDQnpieUJ0WVd0bElITjFjbVVnWW05MGFDQm1hV1ZzWkhNZ1lYSmxJR1pwYkd4bFpDQmlaV1p2Y21VZ2RYQmtZWFJwYm1kY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSd1gyTnZkVzUwWlhJZ1BTQXdPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaSEJmWlcxd2RIbGZabWxsYkdSZlkyOTFiblFnUFNBd08xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdaZlpHRjBaVjl3YVdOclpYSnpMbVZoWTJnb1puVnVZM1JwYjI0b0tYdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvSkNoMGFHbHpLUzUyWVd3b0tUMDlYQ0pjSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtjRjlsYlhCMGVWOW1hV1ZzWkY5amIzVnVkQ3NyTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa2NGOWpiM1Z1ZEdWeUt5czdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtHUndYMlZ0Y0hSNVgyWnBaV3hrWDJOdmRXNTBQVDB3S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWNIVjBWWEJrWVhSbEtERXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlZjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVc1d2RYUlZjR1JoZEdVb01TazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlLVHRjYmlBZ0lDQWdJQ0FnZlR0Y2JseHVJQ0FnSUNBZ0lDQjBhR2x6TG1Ga1pGSmhibWRsVTJ4cFpHVnljeUE5SUdaMWJtTjBhVzl1S0NsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUnRaWFJoWDNKaGJtZGxJRDBnSkhSb2FYTXVabWx1WkNoY0lpNXpaaTF0WlhSaExYSmhibWRsTFhOc2FXUmxjbHdpS1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0pHMWxkR0ZmY21GdVoyVXViR1Z1WjNSb1BqQXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHMWxkR0ZmY21GdVoyVXVaV0ZqYUNobWRXNWpkR2x2YmlncGUxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtkR2hwY3lBOUlDUW9kR2hwY3lrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdGFXNGdQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzF0YVc1Y0lpazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnRZWGdnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxdFlYaGNJaWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6YldsdUlEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRjM1JoY25RdGJXbHVYQ0lwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzIxaGVDQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMWE4wWVhKMExXMWhlRndpS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdScGMzQnNZWGxmZG1Gc2RXVmZZWE1nUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxa2FYTndiR0Y1TFhaaGJIVmxjeTFoYzF3aUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITjBaWEFnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxemRHVndYQ0lwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhOMFlYSjBYM1poYkNBOUlDUjBhR2x6TG1acGJtUW9KeTV6WmkxeVlXNW5aUzF0YVc0bktUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmxibVJmZG1Gc0lEMGdKSFJvYVhNdVptbHVaQ2duTG5ObUxYSmhibWRsTFcxaGVDY3BPMXh1WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSbFkybHRZV3hmY0d4aFkyVnpJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0WkdWamFXMWhiQzF3YkdGalpYTmNJaWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIwYUc5MWMyRnVaRjl6WlhCbGNtRjBiM0lnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxMGFHOTFjMkZ1WkMxelpYQmxjbUYwYjNKY0lpazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtaV05wYldGc1gzTmxjR1Z5WVhSdmNpQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV1JsWTJsdFlXd3RjMlZ3WlhKaGRHOXlYQ0lwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWFXVnNaRjltYjNKdFlYUWdQU0IzVG5WdFlpaDdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnRZWEpyT2lCa1pXTnBiV0ZzWDNObGNHVnlZWFJ2Y2l4Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSbFkybHRZV3h6T2lCd1lYSnpaVVpzYjJGMEtHUmxZMmx0WVd4ZmNHeGhZMlZ6S1N4Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhSb2IzVnpZVzVrT2lCMGFHOTFjMkZ1WkY5elpYQmxjbUYwYjNKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEc1Y2JseHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnRhVzVmZFc1bWIzSnRZWFIwWldRZ1BTQndZWEp6WlVac2IyRjBLSE50YVc0cE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2JXbHVYMlp2Y20xaGRIUmxaQ0E5SUdacFpXeGtYMlp2Y20xaGRDNTBieWh3WVhKelpVWnNiMkYwS0hOdGFXNHBLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzFoZUY5bWIzSnRZWFIwWldRZ1BTQm1hV1ZzWkY5bWIzSnRZWFF1ZEc4b2NHRnljMlZHYkc5aGRDaHpiV0Y0S1NrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdFlYaGZkVzVtYjNKdFlYUjBaV1FnUFNCd1lYSnpaVVpzYjJGMEtITnRZWGdwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMkZzWlhKMEtHMXBibDltYjNKdFlYUjBaV1FwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMkZzWlhKMEtHMWhlRjltYjNKdFlYUjBaV1FwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMkZzWlhKMEtHUnBjM0JzWVhsZmRtRnNkV1ZmWVhNcE8xeHVYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9aR2x6Y0d4aGVWOTJZV3gxWlY5aGN6MDlYQ0owWlhoMGFXNXdkWFJjSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSE4wWVhKMFgzWmhiQzUyWVd3b2JXbHVYMlp2Y20xaGRIUmxaQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWlc1a1gzWmhiQzUyWVd3b2JXRjRYMlp2Y20xaGRIUmxaQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWld4elpTQnBaaWhrYVhOd2JHRjVYM1poYkhWbFgyRnpQVDFjSW5SbGVIUmNJaWxjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pITjBZWEowWDNaaGJDNW9kRzFzS0cxcGJsOW1iM0p0WVhSMFpXUXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR1Z1WkY5MllXd3VhSFJ0YkNodFlYaGZabTl5YldGMGRHVmtLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzV2VlVsUGNIUnBiMjV6SUQwZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NtRnVaMlU2SUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQW5iV2x1SnpvZ1d5QndZWEp6WlVac2IyRjBLRzFwYmlrZ1hTeGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FuYldGNEp6b2dXeUJ3WVhKelpVWnNiMkYwS0cxaGVDa2dYVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU3hjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE4wWVhKME9pQmJiV2x1WDJadmNtMWhkSFJsWkN3Z2JXRjRYMlp2Y20xaGRIUmxaRjBzWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JvWVc1a2JHVnpPaUF5TEZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWTI5dWJtVmpkRG9nZEhKMVpTeGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITjBaWEE2SUhCaGNuTmxSbXh2WVhRb2MzUmxjQ2tzWEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdKbGFHRjJhVzkxY2pvZ0oyVjRkR1Z1WkMxMFlYQW5MRnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdabTl5YldGME9pQm1hV1ZzWkY5bWIzSnRZWFJjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZUdGNibHh1WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNXBjMTl5ZEd3OVBURXBYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUc1dlZVbFBjSFJwYjI1ekxtUnBjbVZqZEdsdmJpQTlJRndpY25Sc1hDSTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MyeHBaR1Z5WDI5aWFtVmpkQ0E5SUNRb2RHaHBjeWt1Wm1sdVpDaGNJaTV0WlhSaExYTnNhV1JsY2x3aUtWc3dYVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdnWENKMWJtUmxabWx1WldSY0lpQWhQVDBnZEhsd1pXOW1LQ0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSWdLU0FwSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dlpHVnpkSEp2ZVNCcFppQnBkQ0JsZUdsemRITXVMaUIwYUdseklHMWxZVzV6SUhOdmJXVm9iM2NnWVc1dmRHaGxjaUJwYm5OMFlXNWpaU0JvWVdRZ2FXNXBkR2xoYkdselpXUWdhWFF1TGx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJ4cFpHVnlYMjlpYW1WamRDNXViMVZwVTJ4cFpHVnlMbVJsYzNSeWIza29LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUc1dlZXbFRiR2xrWlhJdVkzSmxZWFJsS0hOc2FXUmxjbDl2WW1wbFkzUXNJRzV2VlVsUGNIUnBiMjV6S1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrYzNSaGNuUmZkbUZzTG05bVppZ3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2MzUmhjblJmZG1Gc0xtOXVLQ2RqYUdGdVoyVW5MQ0JtZFc1amRHbHZiaWdwZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJ4cFpHVnlYMjlpYW1WamRDNXViMVZwVTJ4cFpHVnlMbk5sZENoYkpDaDBhR2x6S1M1MllXd29LU3dnYm5Wc2JGMHBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1pXNWtYM1poYkM1dlptWW9LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHVnVaRjkyWVd3dWIyNG9KMk5vWVc1blpTY3NJR1oxYm1OMGFXOXVLQ2w3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSXVjMlYwS0Z0dWRXeHNMQ0FrS0hSb2FYTXBMblpoYkNncFhTazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dkpITjBZWEowWDNaaGJDNW9kRzFzS0cxcGJsOW1iM0p0WVhSMFpXUXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5UmxibVJmZG1Gc0xtaDBiV3dvYldGNFgyWnZjbTFoZEhSbFpDazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyeHBaR1Z5WDI5aWFtVmpkQzV1YjFWcFUyeHBaR1Z5TG05bVppZ25kWEJrWVhSbEp5azdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhOc2FXUmxjbDl2WW1wbFkzUXVibTlWYVZOc2FXUmxjaTV2YmlnbmRYQmtZWFJsSnl3Z1puVnVZM1JwYjI0b0lIWmhiSFZsY3l3Z2FHRnVaR3hsSUNrZ2UxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJ4cFpHVnlYM04wWVhKMFgzWmhiQ0FnUFNCdGFXNWZabTl5YldGMGRHVmtPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOc2FXUmxjbDlsYm1SZmRtRnNJQ0E5SUcxaGVGOW1iM0p0WVhSMFpXUTdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMllXeDFaU0E5SUhaaGJIVmxjMXRvWVc1a2JHVmRPMXh1WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDZ2dhR0Z1Wkd4bElDa2dlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUcxaGVGOW1iM0p0WVhSMFpXUWdQU0IyWVd4MVpUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMGdaV3h6WlNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdiV2x1WDJadmNtMWhkSFJsWkNBOUlIWmhiSFZsTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaGthWE53YkdGNVgzWmhiSFZsWDJGelBUMWNJblJsZUhScGJuQjFkRndpS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUnpkR0Z5ZEY5MllXd3VkbUZzS0cxcGJsOW1iM0p0WVhSMFpXUXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbGJtUmZkbUZzTG5aaGJDaHRZWGhmWm05eWJXRjBkR1ZrS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvWkdsemNHeGhlVjkyWVd4MVpWOWhjejA5WENKMFpYaDBYQ0lwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pITjBZWEowWDNaaGJDNW9kRzFzS0cxcGJsOW1iM0p0WVhSMFpXUXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbGJtUmZkbUZzTG1oMGJXd29iV0Y0WDJadmNtMWhkSFJsWkNrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTlwSUhSb2FXNXJJSFJvWlNCbWRXNWpkR2x2YmlCMGFHRjBJR0oxYVd4a2N5QjBhR1VnVlZKTUlHNWxaV1J6SUhSdklHUmxZMjlrWlNCMGFHVWdabTl5YldGMGRHVmtJSE4wY21sdVp5QmlaV1p2Y21VZ1lXUmthVzVuSUhSdklIUm9aU0IxY214Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDaHpaV3htTG1GMWRHOWZkWEJrWVhSbFBUMHhLWHg4S0hObGJHWXVZWFYwYjE5amIzVnVkRjl5WldaeVpYTm9YMjF2WkdVOVBURXBLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmIyNXNlU0IwY25rZ2RHOGdkWEJrWVhSbElHbG1JSFJvWlNCMllXeDFaWE1nYUdGMlpTQmhZM1IxWVd4c2VTQmphR0Z1WjJWa1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvS0hOc2FXUmxjbDl6ZEdGeWRGOTJZV3doUFcxcGJsOW1iM0p0WVhSMFpXUXBmSHdvYzJ4cFpHVnlYMlZ1WkY5MllXd2hQVzFoZUY5bWIzSnRZWFIwWldRcEtTQjdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGJuQjFkRlZ3WkdGMFpTZzRNREFwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVkyeGxZWEpVYVcxbGNpZ3BPeUF2TDJsbmJtOXlaU0JoYm5rZ1kyaGhibWRsY3lCeVpXTmxiblJzZVNCdFlXUmxJR0o1SUhSb1pTQnpiR2xrWlhJZ0tIUm9hWE1nZDJGeklHcDFjM1FnYVc1cGRDQnphRzkxYkdSdUozUWdZMjkxYm5RZ1lYTWdZVzRnZFhCa1lYUmxJR1YyWlc1MEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNCOU8xeHVYRzRnSUNBZ0lDQWdJSFJvYVhNdWFXNXBkQ0E5SUdaMWJtTjBhVzl1S0d0bFpYQmZjR0ZuYVc1aGRHbHZiaWxjYmlBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LR3RsWlhCZmNHRm5hVzVoZEdsdmJpazlQVndpZFc1a1pXWnBibVZrWENJcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHdGxaWEJmY0dGbmFXNWhkR2x2YmlBOUlHWmhiSE5sTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1sdWFYUkJkWFJ2VlhCa1lYUmxSWFpsYm5SektDazdYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbUYwZEdGamFFRmpkR2wyWlVOc1lYTnpLQ2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdVlXUmtSR0YwWlZCcFkydGxjbk1vS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdVlXUmtVbUZ1WjJWVGJHbGtaWEp6S0NrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmFXNXBkQ0JqYjIxaWJ5QmliM2hsYzF4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSamIyMWliMkp2ZUNBOUlDUjBhR2x6TG1acGJtUW9YQ0p6Wld4bFkzUmJaR0YwWVMxamIyMWliMkp2ZUQwbk1TZGRYQ0lwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlna1kyOXRZbTlpYjNndWJHVnVaM1JvUGpBcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdOdmJXSnZZbTk0TG1WaFkyZ29ablZ1WTNScGIyNG9hVzVrWlhnZ0tYdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUjBhR2x6WTJJZ1BTQWtLQ0IwYUdseklDazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnVjbTBnUFNBa2RHaHBjMk5pTG1GMGRISW9YQ0prWVhSaExXTnZiV0p2WW05NExXNXliVndpS1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2RIbHdaVzltSUNSMGFHbHpZMkl1WTJodmMyVnVJQ0U5SUZ3aWRXNWtaV1pwYm1Wa1hDSXBYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmphRzl6Wlc1dmNIUnBiMjV6SUQwZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sWVhKamFGOWpiMjUwWVdsdWN6b2dkSEoxWlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlR0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9LSFI1Y0dWdlppaHVjbTBwSVQwOVhDSjFibVJsWm1sdVpXUmNJaWttSmlodWNtMHBLWHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCamFHOXpaVzV2Y0hScGIyNXpMbTV2WDNKbGMzVnNkSE5mZEdWNGRDQTlJRzV5YlR0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dklITmhabVVnZEc4Z2RYTmxJSFJvWlNCbWRXNWpkR2x2Ymx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5elpXRnlZMmhmWTI5dWRHRnBibk5jYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVhWE5mY25Sc1BUMHhLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpZMkl1WVdSa1EyeGhjM01vWENKamFHOXpaVzR0Y25Sc1hDSXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGMyTmlMbU5vYjNObGJpaGphRzl6Wlc1dmNIUnBiMjV6S1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGJITmxYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE5sYkdWamRESnZjSFJwYjI1eklEMGdlMzA3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YVhOZmNuUnNQVDB4S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1ZqZERKdmNIUnBiMjV6TG1ScGNpQTlJRndpY25Sc1hDSTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdvZEhsd1pXOW1LRzV5YlNraFBUMWNJblZ1WkdWbWFXNWxaRndpS1NZbUtHNXliU2twZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1ZqZERKdmNIUnBiMjV6TG14aGJtZDFZV2RsUFNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUZ3aWJtOVNaWE4xYkhSelhDSTZJR1oxYm1OMGFXOXVLQ2w3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnYm5KdE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTmpZaTV6Wld4bFkzUXlLSE5sYkdWamRESnZjSFJwYjI1ektUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYRzVjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1selUzVmliV2wwZEdsdVp5QTlJR1poYkhObE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwybG1JR0ZxWVhnZ2FYTWdaVzVoWW14bFpDQnBibWwwSUhSb1pTQndZV2RwYm1GMGFXOXVYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgyRnFZWGc5UFRFcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXpaWFIxY0VGcVlYaFFZV2RwYm1GMGFXOXVLQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG05dUtGd2ljM1ZpYldsMFhDSXNJSFJvYVhNdWMzVmliV2wwUm05eWJTazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVc1cGRGZHZiME52YlcxbGNtTmxRMjl1ZEhKdmJITW9LVHNnTHk5M2IyOWpiMjF0WlhKalpTQnZjbVJsY21KNVhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtHdGxaWEJmY0dGbmFXNWhkR2x2YmowOVptRnNjMlVwWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c1lYTjBYM04xWW0xcGRGOXhkV1Z5ZVY5d1lYSmhiWE1nUFNCelpXeG1MbWRsZEZWeWJGQmhjbUZ0Y3lobVlXeHpaU2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNCMGFHbHpMbTl1VjJsdVpHOTNVMk55YjJ4c0lEMGdablZ1WTNScGIyNG9aWFpsYm5RcFhHNGdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtDZ2hjMlZzWmk1cGMxOXNiMkZrYVc1blgyMXZjbVVwSUNZbUlDZ2hjMlZzWmk1cGMxOXRZWGhmY0dGblpXUXBLVnh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIzYVc1a2IzZGZjMk55YjJ4c0lEMGdKQ2gzYVc1a2IzY3BMbk5qY205c2JGUnZjQ2dwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQjNhVzVrYjNkZmMyTnliMnhzWDJKdmRIUnZiU0E5SUNRb2QybHVaRzkzS1M1elkzSnZiR3hVYjNBb0tTQXJJQ1FvZDJsdVpHOTNLUzVvWldsbmFIUW9LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MyTnliMnhzWDI5bVpuTmxkQ0E5SUhCaGNuTmxTVzUwS0hObGJHWXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzUnlhV2RuWlhKZllXMXZkVzUwS1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdUpHbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJdWJHVnVaM1JvUFQweEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlISmxjM1ZzZEhOZmMyTnliMnhzWDJKdmRIUnZiU0E5SUhObGJHWXVKR2x1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSXViMlptYzJWMEtDa3VkRzl3SUNzZ2MyVnNaaTRrYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjaTVvWldsbmFIUW9LVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYjJabWMyVjBJRDBnS0hObGJHWXVKR2x1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSXViMlptYzJWMEtDa3VkRzl3SUNzZ2MyVnNaaTRrYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjaTVvWldsbmFIUW9LU2tnTFNCM2FXNWtiM2RmYzJOeWIyeHNPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSGRwYm1SdmQxOXpZM0p2Ykd4ZlltOTBkRzl0SUQ0Z2NtVnpkV3gwYzE5elkzSnZiR3hmWW05MGRHOXRJQ3NnYzJOeWIyeHNYMjltWm5ObGRDbGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNiMkZrVFc5eVpWSmxjM1ZzZEhNb0tUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIc3ZMMlJ2Ym5RZ2JHOWhaQ0J0YjNKbFhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lIUm9hWE11YzNSeWFYQlJkV1Z5ZVZOMGNtbHVaMEZ1WkVoaGMyaEdjbTl0VUdGMGFDQTlJR1oxYm1OMGFXOXVLSFZ5YkNrZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVJSFZ5YkM1emNHeHBkQ2hjSWo5Y0lpbGJNRjB1YzNCc2FYUW9YQ0lqWENJcFd6QmRPMXh1SUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ2RHaHBjeTVuZFhBZ1BTQm1kVzVqZEdsdmJpZ2dibUZ0WlN3Z2RYSnNJQ2tnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lnS0NGMWNtd3BJSFZ5YkNBOUlHeHZZMkYwYVc5dUxtaHlaV1pjYmlBZ0lDQWdJQ0FnSUNBZ0lHNWhiV1VnUFNCdVlXMWxMbkpsY0d4aFkyVW9MMXRjWEZ0ZEx5eGNJbHhjWEZ4Y1hGdGNJaWt1Y21Wd2JHRmpaU2d2VzF4Y1hWMHZMRndpWEZ4Y1hGeGNYVndpS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeVpXZGxlRk1nUFNCY0lsdGNYRnhjUHlaZFhDSXJibUZ0WlN0Y0lqMG9XMTRtSTEwcUtWd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEpsWjJWNElEMGdibVYzSUZKbFowVjRjQ2dnY21WblpYaFRJQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnY21WemRXeDBjeUE5SUhKbFoyVjRMbVY0WldNb0lIVnliQ0FwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlISmxjM1ZzZEhNZ1BUMGdiblZzYkNBL0lHNTFiR3dnT2lCeVpYTjFiSFJ6V3pGZE8xeHVJQ0FnSUNBZ0lDQjlPMXh1WEc1Y2JpQWdJQ0FnSUNBZ2RHaHBjeTVuWlhSVmNteFFZWEpoYlhNZ1BTQm1kVzVqZEdsdmJpaHJaV1Z3WDNCaFoybHVZWFJwYjI0c0lIUjVjR1VzSUdWNFkyeDFaR1VwWEc0Z0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWhyWldWd1gzQmhaMmx1WVhScGIyNHBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnJaV1Z3WDNCaFoybHVZWFJwYjI0Z1BTQjBjblZsTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kSGx3WlNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhSNWNHVWdQU0JjSWx3aU8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RYSnNYM0JoY21GdGMxOXpkSElnUFNCY0lsd2lPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMeUJuWlhRZ1lXeHNJSEJoY21GdGN5Qm1jbTl0SUdacFpXeGtjMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFZ5YkY5d1lYSmhiWE5mWVhKeVlYa2dQU0J3Y205alpYTnpYMlp2Y20wdVoyVjBWWEpzVUdGeVlXMXpLSE5sYkdZcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiR1Z1WjNSb0lEMGdUMkpxWldOMExtdGxlWE1vZFhKc1gzQmhjbUZ0YzE5aGNuSmhlU2t1YkdWdVozUm9PMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR052ZFc1MElEMGdNRHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LR1Y0WTJ4MVpHVXBJVDFjSW5WdVpHVm1hVzVsWkZ3aUtTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0hWeWJGOXdZWEpoYlhOZllYSnlZWGt1YUdGelQzZHVVSEp2Y0dWeWRIa29aWGhqYkhWa1pTa3BJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2JHVnVaM1JvTFMwN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloc1pXNW5kR2crTUNsY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JtYjNJZ0tIWmhjaUJySUdsdUlIVnliRjl3WVhKaGJYTmZZWEp5WVhrcElIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tIVnliRjl3WVhKaGJYTmZZWEp5WVhrdWFHRnpUM2R1VUhKdmNHVnlkSGtvYXlrcElIdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdOaGJsOWhaR1FnUFNCMGNuVmxPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LR1Y0WTJ4MVpHVXBJVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dzOVBXVjRZMngxWkdVcElIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1kyRnVYMkZrWkNBOUlHWmhiSE5sTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvWTJGdVgyRmtaQ2tnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIVnliRjl3WVhKaGJYTmZjM1J5SUNzOUlHc2dLeUJjSWoxY0lpQXJJSFZ5YkY5d1lYSmhiWE5mWVhKeVlYbGJhMTA3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvWTI5MWJuUWdQQ0JzWlc1bmRHZ2dMU0F4S1NCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhWeWJGOXdZWEpoYlhOZmMzUnlJQ3M5SUZ3aUpsd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR052ZFc1MEt5czdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeGRXVnllVjl3WVhKaGJYTWdQU0JjSWx3aU8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyWnZjbTBnY0dGeVlXMXpJR0Z6SUhWeWJDQnhkV1Z5ZVNCemRISnBibWRjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJtYjNKdFgzQmhjbUZ0Y3lBOUlIVnliRjl3WVhKaGJYTmZjM1J5TzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJkbGRDQjFjbXdnY0dGeVlXMXpJR1p5YjIwZ2RHaGxJR1p2Y20wZ2FYUnpaV3htSUNoM2FHRjBJSFJvWlNCMWMyVnlJR2hoY3lCelpXeGxZM1JsWkNsY2JpQWdJQ0FnSUNBZ0lDQWdJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1YW05cGJsVnliRkJoY21GdEtIRjFaWEo1WDNCaGNtRnRjeXdnWm05eWJWOXdZWEpoYlhNcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyRmtaQ0J3WVdkcGJtRjBhVzl1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhyWldWd1gzQmhaMmx1WVhScGIyNDlQWFJ5ZFdVcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIQmhaMlZPZFcxaVpYSWdQU0J6Wld4bUxpUmhhbUY0WDNKbGMzVnNkSE5mWTI5dWRHRnBibVZ5TG1GMGRISW9YQ0prWVhSaExYQmhaMlZrWENJcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSEJoWjJWT2RXMWlaWElwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NHRm5aVTUxYldKbGNpQTlJREU3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jR0ZuWlU1MWJXSmxjajR4S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVxYjJsdVZYSnNVR0Z5WVcwb2NYVmxjbmxmY0dGeVlXMXpMQ0JjSW5ObVgzQmhaMlZrUFZ3aUszQmhaMlZPZFcxaVpYSXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OWhaR1FnYzJacFpGeHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5eGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxtcHZhVzVWY214UVlYSmhiU2h4ZFdWeWVWOXdZWEpoYlhNc0lGd2ljMlpwWkQxY0lpdHpaV3htTG5ObWFXUXBPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMeUJzYjI5d0lIUm9jbTkxWjJnZ1lXNTVJR1Y0ZEhKaElIQmhjbUZ0Y3lBb1puSnZiU0JsZUhRZ2NHeDFaMmx1Y3lrZ1lXNWtJR0ZrWkNCMGJ5QjBhR1VnZFhKc0lDaHBaU0IzYjI5amIyMXRaWEpqWlNCZ2IzSmtaWEppZVdBcFhHNGdJQ0FnSUNBZ0lDQWdJQ0F2S25aaGNpQmxlSFJ5WVY5eGRXVnllVjl3WVhKaGJTQTlJRndpWENJN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHeGxibWQwYUNBOUlFOWlhbVZqZEM1clpYbHpLSE5sYkdZdVpYaDBjbUZmY1hWbGNubGZjR0Z5WVcxektTNXNaVzVuZEdnN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHTnZkVzUwSUQwZ01EdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LR3hsYm1kMGFENHdLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lIdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lHWnZjaUFvZG1GeUlHc2dhVzRnYzJWc1ppNWxlSFJ5WVY5eGRXVnllVjl3WVhKaGJYTXBJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvYzJWc1ppNWxlSFJ5WVY5eGRXVnllVjl3WVhKaGJYTXVhR0Z6VDNkdVVISnZjR1Z5ZEhrb2F5a3BJSHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVaWGgwY21GZmNYVmxjbmxmY0dGeVlXMXpXMnRkSVQxY0lsd2lLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNCbGVIUnlZVjl4ZFdWeWVWOXdZWEpoYlNBOUlHc3JYQ0k5WENJcmMyVnNaaTVsZUhSeVlWOXhkV1Z5ZVY5d1lYSmhiWE5iYTEwN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnY1hWbGNubGZjR0Z5WVcxeklEMGdjMlZzWmk1cWIybHVWWEpzVUdGeVlXMG9jWFZsY25sZmNHRnlZVzF6TENCbGVIUnlZVjl4ZFdWeWVWOXdZWEpoYlNrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ292WEc0Z0lDQWdJQ0FnSUNBZ0lDQnhkV1Z5ZVY5d1lYSmhiWE1nUFNCelpXeG1MbUZrWkZGMVpYSjVVR0Z5WVcxektIRjFaWEo1WDNCaGNtRnRjeXdnYzJWc1ppNWxlSFJ5WVY5eGRXVnllVjl3WVhKaGJYTXVZV3hzS1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaU0U5WENKY0lpbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzRjFaWEo1WDNCaGNtRnRjeUE5SUhObGJHWXVZV1JrVVhWbGNubFFZWEpoYlhNb2NYVmxjbmxmY0dGeVlXMXpMQ0J6Wld4bUxtVjRkSEpoWDNGMVpYSjVYM0JoY21GdGMxdDBlWEJsWFNrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQnhkV1Z5ZVY5d1lYSmhiWE03WEc0Z0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ2RHaHBjeTVoWkdSUmRXVnllVkJoY21GdGN5QTlJR1oxYm1OMGFXOXVLSEYxWlhKNVgzQmhjbUZ0Y3l3Z2JtVjNYM0JoY21GdGN5bGNiaUFnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1Y0ZEhKaFgzRjFaWEo1WDNCaGNtRnRJRDBnWENKY0lqdGNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQnNaVzVuZEdnZ1BTQlBZbXBsWTNRdWEyVjVjeWh1WlhkZmNHRnlZVzF6S1M1c1pXNW5kR2c3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWTI5MWJuUWdQU0F3TzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloc1pXNW5kR2crTUNsY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdadmNpQW9kbUZ5SUdzZ2FXNGdibVYzWDNCaGNtRnRjeWtnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvYm1WM1gzQmhjbUZ0Y3k1b1lYTlBkMjVRY205d1pYSjBlU2hyS1NrZ2UxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh1WlhkZmNHRnlZVzF6VzJ0ZElUMWNJbHdpS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVjRkSEpoWDNGMVpYSjVYM0JoY21GdElEMGdheXRjSWoxY0lpdHVaWGRmY0dGeVlXMXpXMnRkTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIRjFaWEo1WDNCaGNtRnRjeUE5SUhObGJHWXVhbTlwYmxWeWJGQmhjbUZ0S0hGMVpYSjVYM0JoY21GdGN5d2daWGgwY21GZmNYVmxjbmxmY0dGeVlXMHBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdjWFZsY25sZmNHRnlZVzF6TzF4dUlDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lIUm9hWE11WVdSa1ZYSnNVR0Z5WVcwZ1BTQm1kVzVqZEdsdmJpaDFjbXdzSUhOMGNtbHVaeWxjYmlBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdGa1pGOXdZWEpoYlhNZ1BTQmNJbHdpTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMWNtd2hQVndpWENJcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RYSnNMbWx1WkdWNFQyWW9YQ0kvWENJcElDRTlJQzB4S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdZV1JrWDNCaGNtRnRjeUFyUFNCY0lpWmNJanRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5MWNtd2dQU0IwYUdsekxuUnlZV2xzYVc1blUyeGhjMmhKZENoMWNtd3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCaFpHUmZjR0Z5WVcxeklDczlJRndpUDF3aU8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MzUnlhVzVuSVQxY0lsd2lLVnh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlIVnliQ0FySUdGa1pGOXdZWEpoYlhNZ0t5QnpkSEpwYm1jN1hHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlIVnliRHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdmVHRjYmx4dUlDQWdJQ0FnSUNCMGFHbHpMbXB2YVc1VmNteFFZWEpoYlNBOUlHWjFibU4wYVc5dUtIQmhjbUZ0Y3l3Z2MzUnlhVzVuS1Z4dUlDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1lXUmtYM0JoY21GdGN5QTlJRndpWENJN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtIQmhjbUZ0Y3lFOVhDSmNJaWxjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmhaR1JmY0dGeVlXMXpJQ3M5SUZ3aUpsd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpkSEpwYm1jaFBWd2lYQ0lwWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdjR0Z5WVcxeklDc2dZV1JrWDNCaGNtRnRjeUFySUhOMGNtbHVaenRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnY0dGeVlXMXpPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQjlPMXh1WEc0Z0lDQWdJQ0FnSUhSb2FYTXVjMlYwUVdwaGVGSmxjM1ZzZEhOVlVreHpJRDBnWm5WdVkzUnBiMjRvY1hWbGNubGZjR0Z5WVcxektWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaDBlWEJsYjJZb2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVaaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVaaUE5SUc1bGR5QkJjbkpoZVNncE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZHdjbTlqWlhOemFXNW5YM1Z5YkNkZElEMGdYQ0pjSWp0Y2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1aYkozSmxjM1ZzZEhOZmRYSnNKMTBnUFNCY0lsd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuWkdGMFlWOTBlWEJsSjEwZ1BTQmNJbHdpTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUtITmxiR1l1WVdwaGVGOTFjbXdoUFZ3aVhDSXBYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1ScGMzQnNZWGxmY21WemRXeDBYMjFsZEdodlpEMDlYQ0p6YUc5eWRHTnZaR1ZjSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJSHN2TDNSb1pXNGdkMlVnZDJGdWRDQjBieUJrYnlCaElISmxjWFZsYzNRZ2RHOGdkR2hsSUdGcVlYZ2daVzVrY0c5cGJuUmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkeVpYTjFiSFJ6WDNWeWJDZGRJRDBnYzJWc1ppNWhaR1JWY214UVlYSmhiU2h6Wld4bUxuSmxjM1ZzZEhOZmRYSnNMQ0J4ZFdWeWVWOXdZWEpoYlhNcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTloWkdRZ2JHRnVaeUJqYjJSbElIUnZJR0ZxWVhnZ1lYQnBJSEpsY1hWbGMzUXNJR3hoYm1jZ1kyOWtaU0J6YUc5MWJHUWdZV3h5WldGa2VTQmlaU0JwYmlCMGFHVnlaU0JtYjNJZ2IzUm9aWElnY21WeGRXVnpkSE1nS0dsbExDQnpkWEJ3YkdsbFpDQnBiaUIwYUdVZ1VtVnpkV3gwY3lCVlVrd3BYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbXhoYm1kZlkyOWtaU0U5WENKY0lpbGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyOGdZV1JrSUdsMFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1YW05cGJsVnliRkJoY21GdEtIRjFaWEo1WDNCaGNtRnRjeXdnWENKc1lXNW5QVndpSzNObGJHWXViR0Z1WjE5amIyUmxLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR3Y205alpYTnphVzVuWDNWeWJDZGRJRDBnYzJWc1ppNWhaR1JWY214UVlYSmhiU2h6Wld4bUxtRnFZWGhmZFhKc0xDQnhkV1Z5ZVY5d1lYSmhiWE1wTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuWkdGMFlWOTBlWEJsSjEwZ1BTQW5hbk52YmljN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9jMlZzWmk1a2FYTndiR0Y1WDNKbGMzVnNkRjl0WlhSb2IyUTlQVndpY0c5emRGOTBlWEJsWDJGeVkyaHBkbVZjSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J3Y205alpYTnpYMlp2Y20wdWMyVjBWR0Y0UVhKamFHbDJaVkpsYzNWc2RITlZjbXdvYzJWc1ppd2djMlZzWmk1eVpYTjFiSFJ6WDNWeWJDazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGMzVnNkSE5mZFhKc0lEMGdjSEp2WTJWemMxOW1iM0p0TG1kbGRGSmxjM1ZzZEhOVmNtd29jMlZzWml3Z2MyVnNaaTV5WlhOMWJIUnpYM1Z5YkNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkeVpYTjFiSFJ6WDNWeWJDZGRJRDBnYzJWc1ppNWhaR1JWY214UVlYSmhiU2h5WlhOMWJIUnpYM1Z5YkN3Z2NYVmxjbmxmY0dGeVlXMXpLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZHdjbTlqWlhOemFXNW5YM1Z5YkNkZElEMGdjMlZzWmk1aFpHUlZjbXhRWVhKaGJTaHlaWE4xYkhSelgzVnliQ3dnY1hWbGNubGZjR0Z5WVcxektUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpTQnBaaWh6Wld4bUxtUnBjM0JzWVhsZmNtVnpkV3gwWDIxbGRHaHZaRDA5WENKamRYTjBiMjFmZDI5dlkyOXRiV1Z5WTJWZmMzUnZjbVZjSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J3Y205alpYTnpYMlp2Y20wdWMyVjBWR0Y0UVhKamFHbDJaVkpsYzNWc2RITlZjbXdvYzJWc1ppd2djMlZzWmk1eVpYTjFiSFJ6WDNWeWJDazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGMzVnNkSE5mZFhKc0lEMGdjSEp2WTJWemMxOW1iM0p0TG1kbGRGSmxjM1ZzZEhOVmNtd29jMlZzWml3Z2MyVnNaaTV5WlhOMWJIUnpYM1Z5YkNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkeVpYTjFiSFJ6WDNWeWJDZGRJRDBnYzJWc1ppNWhaR1JWY214UVlYSmhiU2h5WlhOMWJIUnpYM1Z5YkN3Z2NYVmxjbmxmY0dGeVlXMXpLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZHdjbTlqWlhOemFXNW5YM1Z5YkNkZElEMGdjMlZzWmk1aFpHUlZjbXhRWVhKaGJTaHlaWE4xYkhSelgzVnliQ3dnY1hWbGNubGZjR0Z5WVcxektUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHVJQ0FnSUNBZ0lDQWdJQ0FnZXk4dmIzUm9aWEozYVhObElIZGxJSGRoYm5RZ2RHOGdjSFZzYkNCMGFHVWdjbVZ6ZFd4MGN5QmthWEpsWTNSc2VTQm1jbTl0SUhSb1pTQnlaWE4xYkhSeklIQmhaMlZjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZHlaWE4xYkhSelgzVnliQ2RkSUQwZ2MyVnNaaTVoWkdSVmNteFFZWEpoYlNoelpXeG1MbkpsYzNWc2RITmZkWEpzTENCeGRXVnllVjl3WVhKaGJYTXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1aYkozQnliMk5sYzNOcGJtZGZkWEpzSjEwZ1BTQnpaV3htTG1Ga1pGVnliRkJoY21GdEtITmxiR1l1WVdwaGVGOTFjbXdzSUhGMVpYSjVYM0JoY21GdGN5azdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZGtZWFJoWDNSNWNHVW5YU0E5SUNkb2RHMXNKenRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuY0hKdlkyVnpjMmx1WjE5MWNtd25YU0E5SUhObGJHWXVZV1JrVVhWbGNubFFZWEpoYlhNb2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuY0hKdlkyVnpjMmx1WjE5MWNtd25YU3dnYzJWc1ppNWxlSFJ5WVY5eGRXVnllVjl3WVhKaGJYTmJKMkZxWVhnblhTazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WVdwaGVGOXlaWE4xYkhSelgyTnZibVpiSjJSaGRHRmZkSGx3WlNkZElEMGdjMlZzWmk1aGFtRjRYMlJoZEdGZmRIbHdaVHRjYmlBZ0lDQWdJQ0FnZlR0Y2JseHVYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NTFjR1JoZEdWTWIyRmtaWEpVWVdjZ1BTQm1kVzVqZEdsdmJpZ2tiMkpxWldOMEtTQjdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrY0dGeVpXNTBPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxtbHVabWx1YVhSbFgzTmpjbTlzYkY5eVpYTjFiSFJmWTJ4aGMzTWhQVndpWENJcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhCaGNtVnVkQ0E5SUhObGJHWXVKR2x1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSXVabWx1WkNoelpXeG1MbWx1Wm1sdWFYUmxYM05qY205c2JGOXlaWE4xYkhSZlkyeGhjM01wTG14aGMzUW9LUzV3WVhKbGJuUW9LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2NHRnlaVzUwSUQwZ2MyVnNaaTRrYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjanRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJoWjA1aGJXVWdQU0FrY0dGeVpXNTBMbkJ5YjNBb1hDSjBZV2RPWVcxbFhDSXBPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnZEdGblZIbHdaU0E5SUNka2FYWW5PMXh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9JQ2dnZEdGblRtRnRaUzUwYjB4dmQyVnlRMkZ6WlNncElEMDlJQ2R2YkNjZ0tTQjhmQ0FvSUhSaFowNWhiV1V1ZEc5TWIzZGxja05oYzJVb0tTQTlQU0FuZFd3bklDa2dLWHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IwWVdkVWVYQmxJRDBnSjJ4cEp6dGNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUnVaWGNnUFNBa0tDYzhKeXQwWVdkVWVYQmxLeWNnTHo0bktTNW9kRzFzS0NSdlltcGxZM1F1YUhSdGJDZ3BLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJoZEhSeWFXSjFkR1Z6SUQwZ0pHOWlhbVZqZEM1d2NtOXdLRndpWVhSMGNtbGlkWFJsYzF3aUtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OGdiRzl2Y0NCMGFISnZkV2RvSUR4elpXeGxZM1ErSUdGMGRISnBZblYwWlhNZ1lXNWtJR0Z3Y0d4NUlIUm9aVzBnYjI0Z1BHUnBkajVjYmlBZ0lDQWdJQ0FnSUNBZ0lDUXVaV0ZqYUNoaGRIUnlhV0oxZEdWekxDQm1kVzVqZEdsdmJpZ3BJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrYm1WM0xtRjBkSElvZEdocGN5NXVZVzFsTENCMGFHbHpMblpoYkhWbEtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUgwcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnSkc1bGR6dGNibHh1SUNBZ0lDQWdJQ0I5WEc1Y2JseHVJQ0FnSUNBZ0lDQjBhR2x6TG14dllXUk5iM0psVW1WemRXeDBjeUE5SUdaMWJtTjBhVzl1S0NsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tDQjBhR2x6TG1selgyMWhlRjl3WVdkbFpDQTlQVDBnZEhKMVpTQXBJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNDdYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHpYMnh2WVdScGJtZGZiVzl5WlNBOUlIUnlkV1U3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQzh2ZEhKcFoyZGxjaUJ6ZEdGeWRDQmxkbVZ1ZEZ4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdWMlpXNTBYMlJoZEdFZ1BTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlpwWkRvZ2MyVnNaaTV6Wm1sa0xGeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIUmhjbWRsZEZObGJHVmpkRzl5T2lCelpXeG1MbUZxWVhoZmRHRnlaMlYwWDJGMGRISXNYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkSGx3WlRvZ1hDSnNiMkZrWDIxdmNtVmNJaXhjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J2WW1wbFkzUTZJSE5sYkdaY2JpQWdJQ0FnSUNBZ0lDQWdJSDA3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRISnBaMmRsY2tWMlpXNTBLRndpYzJZNllXcGhlSE4wWVhKMFhDSXNJR1YyWlc1MFgyUmhkR0VwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdjSEp2WTJWemMxOW1iM0p0TG5ObGRGUmhlRUZ5WTJocGRtVlNaWE4xYkhSelZYSnNLSE5sYkdZc0lITmxiR1l1Y21WemRXeDBjMTkxY213cE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIRjFaWEo1WDNCaGNtRnRjeUE5SUhObGJHWXVaMlYwVlhKc1VHRnlZVzF6S0hSeWRXVXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzWVhOMFgzTjFZbTFwZEY5eGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxtZGxkRlZ5YkZCaGNtRnRjeWhtWVd4elpTazdJQzh2WjNKaFlpQmhJR052Y0hrZ2IyWWdhSFJsSUZWU1RDQndZWEpoYlhNZ2QybDBhRzkxZENCd1lXZHBibUYwYVc5dUlHRnNjbVZoWkhrZ1lXUmtaV1JjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdGcVlYaGZjSEp2WTJWemMybHVaMTkxY213Z1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdGcVlYaGZjbVZ6ZFd4MGMxOTFjbXdnUFNCY0lsd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdGZmRIbHdaU0E5SUZ3aVhDSTdYRzVjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdMeTl1YjNjZ1lXUmtJSFJvWlNCdVpYY2djR0ZuYVc1aGRHbHZibHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzVsZUhSZmNHRm5aV1JmYm5WdFltVnlJRDBnZEdocGN5NWpkWEp5Wlc1MFgzQmhaMlZrSUNzZ01UdGNiaUFnSUNBZ0lDQWdJQ0FnSUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdWFtOXBibFZ5YkZCaGNtRnRLSEYxWlhKNVgzQmhjbUZ0Y3l3Z1hDSnpabDl3WVdkbFpEMWNJaXR1WlhoMFgzQmhaMlZrWDI1MWJXSmxjaWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWMyVjBRV3BoZUZKbGMzVnNkSE5WVWt4ektIRjFaWEo1WDNCaGNtRnRjeWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQmhhbUY0WDNCeWIyTmxjM05wYm1kZmRYSnNJRDBnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jSEp2WTJWemMybHVaMTkxY213blhUdGNiaUFnSUNBZ0lDQWdJQ0FnSUdGcVlYaGZjbVZ6ZFd4MGMxOTFjbXdnUFNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR5WlhOMWJIUnpYM1Z5YkNkZE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlWOTBlWEJsSUQwZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuWkdGMFlWOTBlWEJsSjEwN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUM4dllXSnZjblFnWVc1NUlIQnlaWFpwYjNWeklHRnFZWGdnY21WeGRXVnpkSE5jYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWJHRnpkRjloYW1GNFgzSmxjWFZsYzNRcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDNWhZbTl5ZENncE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MblZ6WlY5elkzSnZiR3hmYkc5aFpHVnlQVDB4S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2JHOWhaR1Z5SUQwZ0pDZ25QR1JwZGk4K0p5eDdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNkamJHRnpjeWM2SUNkelpXRnlZMmd0Wm1sc2RHVnlMWE5qY205c2JDMXNiMkZrYVc1bkoxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPeTh2TG1Gd2NHVnVaRlJ2S0hObGJHWXVKR0ZxWVhoZmNtVnpkV3gwYzE5amIyNTBZV2x1WlhJcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR3h2WVdSbGNpQTlJSE5sYkdZdWRYQmtZWFJsVEc5aFpHVnlWR0ZuS0NSc2IyRmtaWElwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYm1acGJtbDBaVk5qY205c2JFRndjR1Z1WkNna2JHOWhaR1Z5S1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1FnUFNBa0xtZGxkQ2hoYW1GNFgzQnliMk5sYzNOcGJtZGZkWEpzTENCbWRXNWpkR2x2Ymloa1lYUmhMQ0J6ZEdGMGRYTXNJSEpsY1hWbGMzUXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVqZFhKeVpXNTBYM0JoWjJWa0t5czdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c1lYTjBYMkZxWVhoZmNtVnhkV1Z6ZENBOUlHNTFiR3c3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5QXFLaW9xS2lvcUtpb3FLaW9xS2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dklGUlBSRThnTFNCUVFWTlVSU0JVU0VsVElFRk9SQ0JYUVZSRFNDQlVTRVVnVWtWRVNWSkZRMVFnTFNCUFRreFpJRWhCVUZCRlRsTWdWMGxVU0NCWFF5QW9RMUJVSUVGT1JDQlVRVmdnUkU5RlV5Qk9UMVFwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk4Z2FIUjBjSE02THk5elpXRnlZMmd0Wm1sc2RHVnlMblJsYzNRdmNISnZaSFZqZEMxallYUmxaMjl5ZVM5amJHOTBhR2x1Wnk5MGMyaHBjblJ6TDNCaFoyVXZNeTgvYzJaZmNHRm5aV1E5TTF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OTFjR1JoZEdWeklIUm9aU0J5WlhOMWRHeHpJQ1lnWm05eWJTQm9kRzFzWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhaR1JTWlhOMWJIUnpLR1JoZEdFc0lHUmhkR0ZmZEhsd1pTazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHNJR1JoZEdGZmRIbHdaU2t1Wm1GcGJDaG1kVzVqZEdsdmJpaHFjVmhJVWl3Z2RHVjRkRk4wWVhSMWN5d2daWEp5YjNKVWFISnZkMjRwWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSaGRHRWdQU0I3ZlR0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMbk5tYVdRZ1BTQnpaV3htTG5ObWFXUTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1dlltcGxZM1FnUFNCelpXeG1PMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdWRHRnlaMlYwVTJWc1pXTjBiM0lnUFNCelpXeG1MbUZxWVhoZmRHRnlaMlYwWDJGMGRISTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1aGFtRjRWVkpNSUQwZ1lXcGhlRjl3Y205alpYTnphVzVuWDNWeWJEdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG1weFdFaFNJRDBnYW5GWVNGSTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1MFpYaDBVM1JoZEhWeklEMGdkR1Y0ZEZOMFlYUjFjenRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtVnljbTl5VkdoeWIzZHVJRDBnWlhKeWIzSlVhSEp2ZDI0N1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTUwY21sbloyVnlSWFpsYm5Rb1hDSnpaanBoYW1GNFpYSnliM0pjSWl3Z1pHRjBZU2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSDBwTG1Gc2QyRjVjeWhtZFc1amRHbHZiaWdwWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSaGRHRWdQU0I3ZlR0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMbk5tYVdRZ1BTQnpaV3htTG5ObWFXUTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1MFlYSm5aWFJUWld4bFkzUnZjaUE5SUhObGJHWXVZV3BoZUY5MFlYSm5aWFJmWVhSMGNqdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG05aWFtVmpkQ0E5SUhObGJHWTdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MblZ6WlY5elkzSnZiR3hmYkc5aFpHVnlQVDB4S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR3h2WVdSbGNpNWtaWFJoWTJnb0tUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHpYMnh2WVdScGJtZGZiVzl5WlNBOUlHWmhiSE5sTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTUwY21sbloyVnlSWFpsYm5Rb1hDSnpaanBoYW1GNFptbHVhWE5vWENJc0lHUmhkR0VwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmU2s3WEc1Y2JpQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQjBhR2x6TG1abGRHTm9RV3BoZUZKbGMzVnNkSE1nUFNCbWRXNWpkR2x2YmlncFhHNGdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmRISnBaMmRsY2lCemRHRnlkQ0JsZG1WdWRGeHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHVjJaVzUwWDJSaGRHRWdQU0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJacFpEb2djMlZzWmk1elptbGtMRnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFJoY21kbGRGTmxiR1ZqZEc5eU9pQnpaV3htTG1GcVlYaGZkR0Z5WjJWMFgyRjBkSElzWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZEhsd1pUb2dYQ0pzYjJGa1gzSmxjM1ZzZEhOY0lpeGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnZZbXBsWTNRNklITmxiR1pjYmlBZ0lDQWdJQ0FnSUNBZ0lIMDdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZEhKcFoyZGxja1YyWlc1MEtGd2ljMlk2WVdwaGVITjBZWEowWENJc0lHVjJaVzUwWDJSaGRHRXBPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMM0psWm05amRYTWdZVzU1SUdsdWNIVjBJR1pwWld4a2N5QmhablJsY2lCMGFHVWdabTl5YlNCb1lYTWdZbVZsYmlCMWNHUmhkR1ZrWEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkd4aGMzUmZZV04wYVhabFgybHVjSFYwWDNSbGVIUWdQU0FrZEdocGN5NW1hVzVrS0NkcGJuQjFkRnQwZVhCbFBWd2lkR1Y0ZEZ3aVhUcG1iMk4xY3ljcExtNXZkQ2hjSWk1elppMWtZWFJsY0dsamEyVnlYQ0lwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvSkd4aGMzUmZZV04wYVhabFgybHVjSFYwWDNSbGVIUXViR1Z1WjNSb1BUMHhLVnh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJzWVhOMFgyRmpkR2wyWlY5cGJuQjFkRjkwWlhoMElEMGdKR3hoYzNSZllXTjBhWFpsWDJsdWNIVjBYM1JsZUhRdVlYUjBjaWhjSW01aGJXVmNJaWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG1Ga1pFTnNZWE56S0Z3aWMyVmhjbU5vTFdacGJIUmxjaTFrYVhOaFlteGxaRndpS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSEJ5YjJObGMzTmZabTl5YlM1a2FYTmhZbXhsU1c1d2RYUnpLSE5sYkdZcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyWmhaR1VnYjNWMElISmxjM1ZzZEhOY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1WVc1cGJXRjBaU2g3SUc5d1lXTnBkSGs2SURBdU5TQjlMQ0JjSW1aaGMzUmNJaWs3SUM4dmJHOWhaR2x1WjF4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1bVlXUmxRMjl1ZEdWdWRFRnlaV0Z6S0NCY0ltOTFkRndpSUNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1WVdwaGVGOWhZM1JwYjI0OVBWd2ljR0ZuYVc1aGRHbHZibHdpS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Ym1WbFpDQjBieUJ5WlcxdmRtVWdZV04wYVhabElHWnBiSFJsY2lCbWNtOXRJRlZTVEZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXhkV1Z5ZVY5d1lYSmhiWE1nUFNCelpXeG1MbXhoYzNSZmMzVmliV2wwWDNGMVpYSjVYM0JoY21GdGN6dGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Ym05M0lHRmtaQ0IwYUdVZ2JtVjNJSEJoWjJsdVlYUnBiMjVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NHRm5aVTUxYldKbGNpQTlJSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1WVhSMGNpaGNJbVJoZEdFdGNHRm5aV1JjSWlrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9jR0ZuWlU1MWJXSmxjaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCd1lXZGxUblZ0WW1WeUlEMGdNVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY0hKdlkyVnpjMTltYjNKdExuTmxkRlJoZUVGeVkyaHBkbVZTWlhOMWJIUnpWWEpzS0hObGJHWXNJSE5sYkdZdWNtVnpkV3gwYzE5MWNtd3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1WjJWMFZYSnNVR0Z5WVcxektHWmhiSE5sS1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSEJoWjJWT2RXMWlaWEkrTVNsY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1YW05cGJsVnliRkJoY21GdEtIRjFaWEo1WDNCaGNtRnRjeXdnWENKelpsOXdZV2RsWkQxY0lpdHdZV2RsVG5WdFltVnlLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb2MyVnNaaTVoYW1GNFgyRmpkR2x2YmowOVhDSnpkV0p0YVhSY0lpbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVuWlhSVmNteFFZWEpoYlhNb2RISjFaU2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNZWE4wWDNOMVltMXBkRjl4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG1kbGRGVnliRkJoY21GdGN5aG1ZV3h6WlNrN0lDOHZaM0poWWlCaElHTnZjSGtnYjJZZ2FIUmxJRlZTVENCd1lYSmhiWE1nZDJsMGFHOTFkQ0J3WVdkcGJtRjBhVzl1SUdGc2NtVmhaSGtnWVdSa1pXUmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHRnFZWGhmY0hKdlkyVnpjMmx1WjE5MWNtd2dQU0JjSWx3aU8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHRnFZWGhmY21WemRXeDBjMTkxY213Z1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSaGRHRmZkSGx3WlNBOUlGd2lYQ0k3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWMyVjBRV3BoZUZKbGMzVnNkSE5WVWt4ektIRjFaWEo1WDNCaGNtRnRjeWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQmhhbUY0WDNCeWIyTmxjM05wYm1kZmRYSnNJRDBnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jSEp2WTJWemMybHVaMTkxY213blhUdGNiaUFnSUNBZ0lDQWdJQ0FnSUdGcVlYaGZjbVZ6ZFd4MGMxOTFjbXdnUFNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR5WlhOMWJIUnpYM1Z5YkNkZE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlWOTBlWEJsSUQwZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVabHNuWkdGMFlWOTBlWEJsSjEwN1hHNWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OWhZbTl5ZENCaGJua2djSEpsZG1sdmRYTWdZV3BoZUNCeVpYRjFaWE4wYzF4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXhoYzNSZllXcGhlRjl5WlhGMVpYTjBMbUZpYjNKMEtDazdYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1lXcGhlRjloWTNScGIyNGdQU0J6Wld4bUxtRnFZWGhmWVdOMGFXOXVPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzWVhOMFgyRnFZWGhmY21WeGRXVnpkQ0E5SUNRdVoyVjBLR0ZxWVhoZmNISnZZMlZ6YzJsdVoxOTFjbXdzSUdaMWJtTjBhVzl1S0dSaGRHRXNJSE4wWVhSMWN5d2djbVZ4ZFdWemRDbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXhoYzNSZllXcGhlRjl5WlhGMVpYTjBJRDBnYm5Wc2JEdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZFhCa1lYUmxjeUIwYUdVZ2NtVnpkWFJzY3lBbUlHWnZjbTBnYUhSdGJGeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZFhCa1lYUmxVbVZ6ZFd4MGN5aGtZWFJoTENCa1lYUmhYM1I1Y0dVcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeThnYzJOeWIyeHNJRnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2SUhObGRDQjBhR1VnZG1GeUlHSmhZMnNnZEc4Z2QyaGhkQ0JwZENCM1lYTWdZbVZtYjNKbElIUm9aU0JoYW1GNElISmxjWFZsYzNRZ2JtRmtJSFJvWlNCbWIzSnRJSEpsTFdsdWFYUmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZZV04wYVc5dUlEMGdZV3BoZUY5aFkzUnBiMjQ3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXpZM0p2Ykd4U1pYTjFiSFJ6S0NCelpXeG1MbUZxWVhoZllXTjBhVzl1SUNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZLaUIxY0dSaGRHVWdWVkpNSUNvdlhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OTFjR1JoZEdVZ2RYSnNJR0psWm05eVpTQndZV2RwYm1GMGFXOXVMQ0JpWldOaGRYTmxJSGRsSUc1bFpXUWdkRzhnWkc4Z2MyOXRaU0JqYUdWamEzTWdZV2RoYVc1eklIUm9aU0JWVWt3Z1ptOXlJR2x1Wm1sdWFYUmxJSE5qY205c2JGeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZFhCa1lYUmxWWEpzU0dsemRHOXllU2hoYW1GNFgzSmxjM1ZzZEhOZmRYSnNLVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyVjBkWEFnY0dGbmFXNWhkR2x2Ymx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjMlYwZFhCQmFtRjRVR0ZuYVc1aGRHbHZiaWdwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYzFOMVltMXBkSFJwYm1jZ1BTQm1ZV3h6WlR0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHFJSFZ6WlhJZ1pHVm1JQ292WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBibWwwVjI5dlEyOXRiV1Z5WTJWRGIyNTBjbTlzY3lncE95QXZMM2R2YjJOdmJXMWxjbU5sSUc5eVpHVnlZbmxjYmx4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5TENCa1lYUmhYM1I1Y0dVcExtWmhhV3dvWm5WdVkzUnBiMjRvYW5GWVNGSXNJSFJsZUhSVGRHRjBkWE1zSUdWeWNtOXlWR2h5YjNkdUtWeHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtZWFJoSUQwZ2UzMDdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1elptbGtJRDBnYzJWc1ppNXpabWxrTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVkR0Z5WjJWMFUyVnNaV04wYjNJZ1BTQnpaV3htTG1GcVlYaGZkR0Z5WjJWMFgyRjBkSEk3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNXZZbXBsWTNRZ1BTQnpaV3htTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVZV3BoZUZWU1RDQTlJR0ZxWVhoZmNISnZZMlZ6YzJsdVoxOTFjbXc3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNXFjVmhJVWlBOUlHcHhXRWhTTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVkR1Y0ZEZOMFlYUjFjeUE5SUhSbGVIUlRkR0YwZFhNN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzVsY25KdmNsUm9jbTkzYmlBOUlHVnljbTl5VkdoeWIzZHVPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFYTlRkV0p0YVhSMGFXNW5JRDBnWm1Gc2MyVTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1MGNtbG5aMlZ5UlhabGJuUW9YQ0p6WmpwaGFtRjRaWEp5YjNKY0lpd2daR0YwWVNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUgwcExtRnNkMkY1Y3lobWRXNWpkR2x2YmlncFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1emRHOXdLSFJ5ZFdVc2RISjFaU2t1WVc1cGJXRjBaU2g3SUc5d1lXTnBkSGs2SURGOUxDQmNJbVpoYzNSY0lpazdJQzh2Wm1sdWFYTm9aV1FnYkc5aFpHbHVaMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVptRmtaVU52Ym5SbGJuUkJjbVZoY3lnZ1hDSnBibHdpSUNrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdFZ1BTQjdmVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExuTm1hV1FnUFNCelpXeG1Mbk5tYVdRN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzUwWVhKblpYUlRaV3hsWTNSdmNpQTlJSE5sYkdZdVlXcGhlRjkwWVhKblpYUmZZWFIwY2p0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMbTlpYW1WamRDQTlJSE5sYkdZN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUm9hWE11Y21WdGIzWmxRMnhoYzNNb1hDSnpaV0Z5WTJndFptbHNkR1Z5TFdScGMyRmliR1ZrWENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIQnliMk5sYzNOZlptOXliUzVsYm1GaWJHVkpibkIxZEhNb2MyVnNaaWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzSmxabTlqZFhNZ2RHaGxJR3hoYzNRZ1lXTjBhWFpsSUhSbGVIUWdabWxsYkdSY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHNZWE4wWDJGamRHbDJaVjlwYm5CMWRGOTBaWGgwSVQxY0lsd2lLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JwYm5CMWRDQTlJRnRkTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlSbWFXVnNaSE11WldGamFDaG1kVzVqZEdsdmJpZ3BlMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHRmpkR2wyWlY5cGJuQjFkQ0E5SUNRb2RHaHBjeWt1Wm1sdVpDaGNJbWx1Y0hWMFcyNWhiV1U5SjF3aUsyeGhjM1JmWVdOMGFYWmxYMmx1Y0hWMFgzUmxlSFFyWENJblhWd2lLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0NSaFkzUnBkbVZmYVc1d2RYUXViR1Z1WjNSb1BUMHhLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNScGJuQjFkQ0E5SUNSaFkzUnBkbVZmYVc1d2RYUTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDUnBibkIxZEM1c1pXNW5kR2c5UFRFcElIdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR2x1Y0hWMExtWnZZM1Z6S0NrdWRtRnNLQ1JwYm5CMWRDNTJZV3dvS1NrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbVp2WTNWelEyRnRjRzhvSkdsdWNIVjBXekJkS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbVpwYm1Rb1hDSnBibkIxZEZ0dVlXMWxQU2RmYzJaZmMyVmhjbU5vSjExY0lpa3VkSEpwWjJkbGNpZ25abTlqZFhNbktUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5SeWFXZG5aWEpGZG1WdWRDaGNJbk5tT21GcVlYaG1hVzVwYzJoY0lpd2dJR1JoZEdFZ0tUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYRzRnSUNBZ0lDQWdJSDA3WEc1Y2JpQWdJQ0FnSUNBZ2RHaHBjeTVtYjJOMWMwTmhiWEJ2SUQwZ1puVnVZM1JwYjI0b2FXNXdkWFJHYVdWc1pDbDdYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwzWmhjaUJwYm5CMWRFWnBaV3hrSUQwZ1pHOWpkVzFsYm5RdVoyVjBSV3hsYldWdWRFSjVTV1FvYVdRcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tHbHVjSFYwUm1sbGJHUWdJVDBnYm5Wc2JDQW1KaUJwYm5CMWRFWnBaV3hrTG5aaGJIVmxMbXhsYm1kMGFDQWhQU0F3S1h0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9hVzV3ZFhSR2FXVnNaQzVqY21WaGRHVlVaWGgwVW1GdVoyVXBlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdSbWxsYkdSU1lXNW5aU0E5SUdsdWNIVjBSbWxsYkdRdVkzSmxZWFJsVkdWNGRGSmhibWRsS0NrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRVpwWld4a1VtRnVaMlV1Ylc5MlpWTjBZWEowS0NkamFHRnlZV04wWlhJbkxHbHVjSFYwUm1sbGJHUXVkbUZzZFdVdWJHVnVaM1JvS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdSbWxsYkdSU1lXNW5aUzVqYjJ4c1lYQnpaU2dwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQkdhV1ZzWkZKaGJtZGxMbk5sYkdWamRDZ3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFsYkhObElHbG1JQ2hwYm5CMWRFWnBaV3hrTG5ObGJHVmpkR2x2YmxOMFlYSjBJSHg4SUdsdWNIVjBSbWxsYkdRdWMyVnNaV04wYVc5dVUzUmhjblFnUFQwZ0p6QW5LU0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJsYkdWdFRHVnVJRDBnYVc1d2RYUkdhV1ZzWkM1MllXeDFaUzVzWlc1bmRHZzdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsdWNIVjBSbWxsYkdRdWMyVnNaV04wYVc5dVUzUmhjblFnUFNCbGJHVnRUR1Z1TzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBibkIxZEVacFpXeGtMbk5sYkdWamRHbHZia1Z1WkNBOUlHVnNaVzFNWlc0N1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbHVjSFYwUm1sbGJHUXVZbXgxY2lncE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbHVjSFYwUm1sbGJHUXVabTlqZFhNb0tUdGNiaUFnSUNBZ0lDQWdJQ0FnSUgwZ1pXeHpaWHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb0lHbHVjSFYwUm1sbGJHUWdLU0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbHVjSFYwUm1sbGJHUXVabTlqZFhNb0tUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0IwYUdsekxuUnlhV2RuWlhKRmRtVnVkQ0E5SUdaMWJtTjBhVzl1S0dWMlpXNTBibUZ0WlN3Z1pHRjBZU2xjYmlBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSbGRtVnVkRjlqYjI1MFlXbHVaWElnUFNBa0tGd2lMbk5sWVhKamFHRnVaR1pwYkhSbGNsdGtZWFJoTFhObUxXWnZjbTB0YVdROUoxd2lLM05sYkdZdWMyWnBaQ3RjSWlkZFhDSXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0pHVjJaVzUwWDJOdmJuUmhhVzVsY2k1MGNtbG5aMlZ5S0dWMlpXNTBibUZ0WlN3Z1d5QmtZWFJoSUYwcE8xeHVJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NW1aWFJqYUVGcVlYaEdiM0p0SUQwZ1puVnVZM1JwYjI0b0tWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwzUnlhV2RuWlhJZ2MzUmhjblFnWlhabGJuUmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmxkbVZ1ZEY5a1lYUmhJRDBnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObWFXUTZJSE5sYkdZdWMyWnBaQ3hjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IwWVhKblpYUlRaV3hsWTNSdmNqb2djMlZzWmk1aGFtRjRYM1JoY21kbGRGOWhkSFJ5TEZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhSNWNHVTZJRndpWm05eWJWd2lMRnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzlpYW1WamREb2djMlZzWmx4dUlDQWdJQ0FnSUNBZ0lDQWdmVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1MGNtbG5aMlZ5UlhabGJuUW9YQ0p6WmpwaGFtRjRabTl5YlhOMFlYSjBYQ0lzSUZzZ1pYWmxiblJmWkdGMFlTQmRLVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdVlXUmtRMnhoYzNNb1hDSnpaV0Z5WTJndFptbHNkR1Z5TFdScGMyRmliR1ZrWENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnY0hKdlkyVnpjMTltYjNKdExtUnBjMkZpYkdWSmJuQjFkSE1vYzJWc1ppazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG1kbGRGVnliRkJoY21GdGN5Z3BPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxteGhibWRmWTI5a1pTRTlYQ0pjSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNOdklHRmtaQ0JwZEZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdWFtOXBibFZ5YkZCaGNtRnRLSEYxWlhKNVgzQmhjbUZ0Y3l3Z1hDSnNZVzVuUFZ3aUszTmxiR1l1YkdGdVoxOWpiMlJsS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdGcVlYaGZjSEp2WTJWemMybHVaMTkxY213Z1BTQnpaV3htTG1Ga1pGVnliRkJoY21GdEtITmxiR1l1WVdwaGVGOW1iM0p0WDNWeWJDd2djWFZsY25sZmNHRnlZVzF6S1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1lYUmhYM1I1Y0dVZ1BTQmNJbXB6YjI1Y0lqdGNibHh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMkZpYjNKMElHRnVlU0J3Y21WMmFXOTFjeUJoYW1GNElISmxjWFZsYzNSelhHNGdJQ0FnSUNBZ0lDQWdJQ0F2S21sbUtITmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1FwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1F1WVdKdmNuUW9LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQjlLaTljYmx4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDNObGJHWXViR0Z6ZEY5aGFtRjRYM0psY1hWbGMzUWdQVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWtMbWRsZENoaGFtRjRYM0J5YjJObGMzTnBibWRmZFhKc0xDQm1kVzVqZEdsdmJpaGtZWFJoTENCemRHRjBkWE1zSUhKbGNYVmxjM1FwWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl6Wld4bUxteGhjM1JmWVdwaGVGOXlaWEYxWlhOMElEMGdiblZzYkR0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZkWEJrWVhSbGN5QjBhR1VnY21WemRYUnNjeUFtSUdadmNtMGdhSFJ0YkZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVkWEJrWVhSbFJtOXliU2hrWVhSaExDQmtZWFJoWDNSNWNHVXBPMXh1WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSDBzSUdSaGRHRmZkSGx3WlNrdVptRnBiQ2htZFc1amRHbHZiaWhxY1ZoSVVpd2dkR1Y0ZEZOMFlYUjFjeXdnWlhKeWIzSlVhSEp2ZDI0cFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHUmhkR0VnUFNCN2ZUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG5ObWFXUWdQU0J6Wld4bUxuTm1hV1E3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNTBZWEpuWlhSVFpXeGxZM1J2Y2lBOUlITmxiR1l1WVdwaGVGOTBZWEpuWlhSZllYUjBjanRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtOWlhbVZqZENBOUlITmxiR1k3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNWhhbUY0VlZKTUlEMGdZV3BoZUY5d2NtOWpaWE56YVc1blgzVnliRHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtcHhXRWhTSUQwZ2FuRllTRkk3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNTBaWGgwVTNSaGRIVnpJRDBnZEdWNGRGTjBZWFIxY3p0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMbVZ5Y205eVZHaHliM2R1SUQwZ1pYSnliM0pVYUhKdmQyNDdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1MGNtbG5aMlZ5UlhabGJuUW9YQ0p6WmpwaGFtRjRaWEp5YjNKY0lpd2dXeUJrWVhSaElGMHBPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlLUzVoYkhkaGVYTW9ablZ1WTNScGIyNG9LVnh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrWVhSaElEMGdlMzA3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNXpabWxrSUQwZ2MyVnNaaTV6Wm1sa08xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1ZEdGeVoyVjBVMlZzWldOMGIzSWdQU0J6Wld4bUxtRnFZWGhmZEdGeVoyVjBYMkYwZEhJN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzV2WW1wbFkzUWdQU0J6Wld4bU8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdWNtVnRiM1psUTJ4aGMzTW9YQ0p6WldGeVkyZ3RabWxzZEdWeUxXUnBjMkZpYkdWa1hDSXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEJ5YjJObGMzTmZabTl5YlM1bGJtRmliR1ZKYm5CMWRITW9jMlZzWmlrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5SeWFXZG5aWEpGZG1WdWRDaGNJbk5tT21GcVlYaG1iM0p0Wm1sdWFYTm9YQ0lzSUZzZ1pHRjBZU0JkS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4dUlDQWdJQ0FnSUNCOU8xeHVYRzRnSUNBZ0lDQWdJSFJvYVhNdVkyOXdlVXhwYzNSSmRHVnRjME52Ym5SbGJuUnpJRDBnWm5WdVkzUnBiMjRvSkd4cGMzUmZabkp2YlN3Z0pHeHBjM1JmZEc4cFhHNGdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUM4dlkyOXdlU0J2ZG1WeUlHTm9hV3hrSUd4cGMzUWdhWFJsYlhOY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCc2FWOWpiMjUwWlc1MGMxOWhjbkpoZVNBOUlHNWxkeUJCY25KaGVTZ3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1p5YjIxZllYUjBjbWxpZFhSbGN5QTlJRzVsZHlCQmNuSmhlU2dwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHWnliMjFmWm1sbGJHUnpJRDBnSkd4cGMzUmZabkp2YlM1bWFXNWtLRndpUGlCMWJDQStJR3hwWENJcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBa1puSnZiVjltYVdWc1pITXVaV0ZqYUNobWRXNWpkR2x2YmlocEtYdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR3hwWDJOdmJuUmxiblJ6WDJGeWNtRjVMbkIxYzJnb0pDaDBhR2x6S1M1b2RHMXNLQ2twTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR0YwZEhKcFluVjBaWE1nUFNBa0tIUm9hWE1wTG5CeWIzQW9YQ0poZEhSeWFXSjFkR1Z6WENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnliMjFmWVhSMGNtbGlkWFJsY3k1d2RYTm9LR0YwZEhKcFluVjBaWE1wTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OTJZWElnWm1sbGJHUmZibUZ0WlNBOUlDUW9kR2hwY3lrdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRibUZ0WlZ3aUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1poY2lCMGIxOW1hV1ZzWkNBOUlDUnNhWE4wWDNSdkxtWnBibVFvWENJK0lIVnNJRDRnYkdsYlpHRjBZUzF6WmkxbWFXVnNaQzF1WVcxbFBTZGNJaXRtYVdWc1pGOXVZVzFsSzF3aUoxMWNJaWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzTmxiR1l1WTI5d2VVRjBkSEpwWW5WMFpYTW9KQ2gwYUdsektTd2dKR3hwYzNSZmRHOHNJRndpWkdGMFlTMXpaaTFjSWlrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUgwcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiR2xmYVhRZ1BTQXdPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwYjE5bWFXVnNaSE1nUFNBa2JHbHpkRjkwYnk1bWFXNWtLRndpUGlCMWJDQStJR3hwWENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSkhSdlgyWnBaV3hrY3k1bFlXTm9LR1oxYm1OMGFXOXVLR2twZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb2RHaHBjeWt1YUhSdGJDaHNhVjlqYjI1MFpXNTBjMTloY25KaGVWdHNhVjlwZEYwcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSbWNtOXRYMlpwWld4a0lEMGdKQ2drWm5KdmJWOW1hV1ZzWkhNdVoyVjBLR3hwWDJsMEtTazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pIUnZYMlpwWld4a0lEMGdKQ2gwYUdsektUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkRzlmWm1sbGJHUXVjbVZ0YjNabFFYUjBjaWhjSW1SaGRHRXRjMll0ZEdGNGIyNXZiWGt0WVhKamFHbDJaVndpS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbU52Y0hsQmRIUnlhV0oxZEdWektDUm1jbTl0WDJacFpXeGtMQ0FrZEc5ZlptbGxiR1FwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2JHbGZhWFFyS3p0Y2JpQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2S25aaGNpQWtabkp2YlY5bWFXVnNaSE1nUFNBa2JHbHpkRjltY205dExtWnBibVFvWENJZ2RXd2dQaUJzYVZ3aUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSFJ2WDJacFpXeGtjeUE5SUNSc2FYTjBYM1J2TG1acGJtUW9YQ0lnUGlCc2FWd2lLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWtabkp2YlY5bWFXVnNaSE11WldGamFDaG1kVzVqZEdsdmJpaHBibVJsZUN3Z2RtRnNLWHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdrS0hSb2FYTXBMbWhoYzBGMGRISnBZblYwWlNoY0ltUmhkR0V0YzJZdGRHRjRiMjV2YlhrdFlYSmphR2wyWlZ3aUtTbGNiaUFnSUNBZ0lDQWdJQ0FnSUNCN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbU52Y0hsQmRIUnlhV0oxZEdWektDUnNhWE4wWDJaeWIyMHNJQ1JzYVhOMFgzUnZLVHNxTDF4dUlDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdkR2hwY3k1MWNHUmhkR1ZHYjNKdFFYUjBjbWxpZFhSbGN5QTlJR1oxYm1OMGFXOXVLQ1JzYVhOMFgyWnliMjBzSUNSc2FYTjBYM1J2S1Z4dUlDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1puSnZiVjloZEhSeWFXSjFkR1Z6SUQwZ0pHeHBjM1JmWm5KdmJTNXdjbTl3S0Z3aVlYUjBjbWxpZFhSbGMxd2lLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZJR3h2YjNBZ2RHaHliM1ZuYUNBOGMyVnNaV04wUGlCaGRIUnlhV0oxZEdWeklHRnVaQ0JoY0hCc2VTQjBhR1Z0SUc5dUlEeGthWFkrWEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMGIxOWhkSFJ5YVdKMWRHVnpJRDBnSkd4cGMzUmZkRzh1Y0hKdmNDaGNJbUYwZEhKcFluVjBaWE5jSWlrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FrTG1WaFkyZ29kRzlmWVhSMGNtbGlkWFJsY3l3Z1puVnVZM1JwYjI0b0tTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR3hwYzNSZmRHOHVjbVZ0YjNabFFYUjBjaWgwYUdsekxtNWhiV1VwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmU2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ1F1WldGamFDaG1jbTl0WDJGMGRISnBZblYwWlhNc0lHWjFibU4wYVc5dUtDa2dlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JzYVhOMFgzUnZMbUYwZEhJb2RHaHBjeTV1WVcxbExDQjBhR2x6TG5aaGJIVmxLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh1WEc0Z0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQjBhR2x6TG1OdmNIbEJkSFJ5YVdKMWRHVnpJRDBnWm5WdVkzUnBiMjRvSkdaeWIyMHNJQ1IwYnl3Z2NISmxabWw0S1Z4dUlDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvY0hKbFptbDRLVDA5WENKMWJtUmxabWx1WldSY0lpbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjSEpsWm1sNElEMGdYQ0pjSWp0Y2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdaeWIyMWZZWFIwY21saWRYUmxjeUE5SUNSbWNtOXRMbkJ5YjNBb1hDSmhkSFJ5YVdKMWRHVnpYQ0lwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RHOWZZWFIwY21saWRYUmxjeUE5SUNSMGJ5NXdjbTl3S0Z3aVlYUjBjbWxpZFhSbGMxd2lLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDUXVaV0ZqYUNoMGIxOWhkSFJ5YVdKMWRHVnpMQ0JtZFc1amRHbHZiaWdwSUh0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSEJ5WldacGVDRTlYQ0pjSWlrZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2RHaHBjeTV1WVcxbExtbHVaR1Y0VDJZb2NISmxabWw0S1NBOVBTQXdLU0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEc4dWNtVnRiM1psUVhSMGNpaDBhR2x6TG01aGJXVXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlZjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZKSFJ2TG5KbGJXOTJaVUYwZEhJb2RHaHBjeTV1WVcxbEtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0pDNWxZV05vS0daeWIyMWZZWFIwY21saWRYUmxjeXdnWm5WdVkzUnBiMjRvS1NCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUnZMbUYwZEhJb2RHaHBjeTV1WVcxbExDQjBhR2x6TG5aaGJIVmxLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh1SUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ2RHaHBjeTVqYjNCNVJtOXliVUYwZEhKcFluVjBaWE1nUFNCbWRXNWpkR2x2Ymlna1puSnZiU3dnSkhSdktWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBa2RHOHVjbVZ0YjNabFFYUjBjaWhjSW1SaGRHRXRZM1Z5Y21WdWRDMTBZWGh2Ym05dGVTMWhjbU5vYVhabFhDSXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVqYjNCNVFYUjBjbWxpZFhSbGN5Z2tabkp2YlN3Z0pIUnZLVHRjYmx4dUlDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdkR2hwY3k1MWNHUmhkR1ZHYjNKdElEMGdablZ1WTNScGIyNG9aR0YwWVN3Z1pHRjBZVjkwZVhCbEtWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaGtZWFJoWDNSNWNHVTlQVndpYW5OdmJsd2lLVnh1SUNBZ0lDQWdJQ0FnSUNBZ2V5OHZkR2hsYmlCM1pTQmthV1FnWVNCeVpYRjFaWE4wSUhSdklIUm9aU0JoYW1GNElHVnVaSEJ2YVc1MExDQnpieUJsZUhCbFkzUWdZVzRnYjJKcVpXTjBJR0poWTJ0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaGtZWFJoV3lkbWIzSnRKMTBwSVQwOVhDSjFibVJsWm1sdVpXUmNJaWxjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjbVZ0YjNabElHRnNiQ0JsZG1WdWRITWdabkp2YlNCVEprWWdabTl5YlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkR2hwY3k1dlptWW9LVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM0psWm5KbGMyZ2dkR2hsSUdadmNtMGdLR0YxZEc4Z1kyOTFiblFwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WTI5d2VVeHBjM1JKZEdWdGMwTnZiblJsYm5SektDUW9aR0YwWVZzblptOXliU2RkS1N3Z0pIUm9hWE1wTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Y21VZ2FXNXBkQ0JUSmtZZ1kyeGhjM01nYjI0Z2RHaGxJR1p2Y20xY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeThrZEdocGN5NXpaV0Z5WTJoQmJtUkdhV3gwWlhJb0tUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwybG1JR0ZxWVhnZ2FYTWdaVzVoWW14bFpDQnBibWwwSUhSb1pTQndZV2RwYm1GMGFXOXVYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVwYm1sMEtIUnlkV1VwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVhWE5mWVdwaGVEMDlNU2xjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV6WlhSMWNFRnFZWGhRWVdkcGJtRjBhVzl1S0NrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmx4dVhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNWNibHh1SUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZV1JrVW1WemRXeDBjeUE5SUdaMWJtTjBhVzl1S0dSaGRHRXNJR1JoZEdGZmRIbHdaU2xjYmlBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvWkdGMFlWOTBlWEJsUFQxY0ltcHpiMjVjSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJSHN2TDNSb1pXNGdkMlVnWkdsa0lHRWdjbVZ4ZFdWemRDQjBieUIwYUdVZ1lXcGhlQ0JsYm1Sd2IybHVkQ3dnYzI4Z1pYaHdaV04wSUdGdUlHOWlhbVZqZENCaVlXTnJYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTluY21GaUlIUm9aU0J5WlhOMWJIUnpJR0Z1WkNCc2IyRmtJR2x1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5elpXeG1MaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxtRndjR1Z1WkNoa1lYUmhXeWR5WlhOMWJIUnpKMTBwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXViRzloWkY5dGIzSmxYMmgwYld3Z1BTQmtZWFJoV3lkeVpYTjFiSFJ6SjEwN1hHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtHUmhkR0ZmZEhsd1pUMDlYQ0pvZEcxc1hDSXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN0x5OTNaU0JoY21VZ1pYaHdaV04wYVc1bklIUm9aU0JvZEcxc0lHOW1JSFJvWlNCeVpYTjFiSFJ6SUhCaFoyVWdZbUZqYXl3Z2MyOGdaWGgwY21GamRDQjBhR1VnYUhSdGJDQjNaU0J1WldWa1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JrWVhSaFgyOWlhaUE5SUNRb1pHRjBZU2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNiMkZrWDIxdmNtVmZhSFJ0YkNBOUlDUmtZWFJoWDI5aWFpNW1hVzVrS0hObGJHWXVZV3BoZUY5MFlYSm5aWFJmWVhSMGNpa3VhSFJ0YkNncE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2FXNW1hVzVwZEdWZmMyTnliMnhzWDJWdVpDQTlJR1poYkhObE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tLRndpUEdScGRqNWNJaXR6Wld4bUxteHZZV1JmYlc5eVpWOW9kRzFzSzF3aVBDOWthWFkrWENJcExtWnBibVFvWENKYlpHRjBZUzF6WldGeVkyZ3RabWxzZEdWeUxXRmpkR2x2YmowbmFXNW1hVzVwZEdVdGMyTnliMnhzTFdWdVpDZGRYQ0lwTG14bGJtZDBhRDR3S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2x1Wm1sdWFYUmxYM05qY205c2JGOWxibVFnUFNCMGNuVmxPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwybG1JSFJvWlhKbElHbHpJR0Z1YjNSb1pYSWdjMlZzWldOMGIzSWdabTl5SUdsdVptbHVhWFJsSUhOamNtOXNiQ3dnWm1sdVpDQjBhR1VnWTI5dWRHVnVkSE1nYjJZZ2RHaGhkQ0JwYm5OMFpXRmtYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1sdVptbHVhWFJsWDNOamNtOXNiRjlqYjI1MFlXbHVaWEloUFZ3aVhDSXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzYjJGa1gyMXZjbVZmYUhSdGJDQTlJQ1FvWENJOFpHbDJQbHdpSzNObGJHWXViRzloWkY5dGIzSmxYMmgwYld3clhDSThMMlJwZGo1Y0lpa3VabWx1WkNoelpXeG1MbWx1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSXBMbWgwYld3b0tUdGNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzSmxjM1ZzZEY5amJHRnpjeUU5WENKY0lpbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSEpsYzNWc2RGOXBkR1Z0Y3lBOUlDUW9YQ0k4WkdsMlBsd2lLM05sYkdZdWJHOWhaRjl0YjNKbFgyaDBiV3dyWENJOEwyUnBkajVjSWlrdVptbHVaQ2h6Wld4bUxtbHVabWx1YVhSbFgzTmpjbTlzYkY5eVpYTjFiSFJmWTJ4aGMzTXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2NtVnpkV3gwWDJsMFpXMXpYMk52Ym5SaGFXNWxjaUE5SUNRb0p6eGthWFl2UGljc0lIdDlLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrY21WemRXeDBYMmwwWlcxelgyTnZiblJoYVc1bGNpNWhjSEJsYm1Rb0pISmxjM1ZzZEY5cGRHVnRjeWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc0lEMGdKSEpsYzNWc2RGOXBkR1Z0YzE5amIyNTBZV2x1WlhJdWFIUnRiQ2dwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhwYm1acGJtbDBaVjl6WTNKdmJHeGZaVzVrS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdleTh2ZDJVZ1ptOTFibVFnWVNCa1lYUmhJR0YwZEhKcFluVjBaU0J6YVdkdVlXeHNhVzVuSUhSb1pTQnNZWE4wSUhCaFoyVWdjMjhnWm1sdWFYTm9JR2hsY21WY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVhOZmJXRjRYM0JoWjJWa0lEMGdkSEoxWlR0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXhoYzNSZmJHOWhaRjl0YjNKbFgyaDBiV3dnUFNCelpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc08xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGJtWnBibWwwWlZOamNtOXNiRUZ3Y0dWdVpDaHpaV3htTG14dllXUmZiVzl5WlY5b2RHMXNLVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0JwWmloelpXeG1MbXhoYzNSZmJHOWhaRjl0YjNKbFgyaDBiV3doUFQxelpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc0tWeHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dlkyaGxZMnNnZEc4Z2JXRnJaU0J6ZFhKbElIUm9aU0J1WlhjZ2FIUnRiQ0JtWlhSamFHVmtJR2x6SUdScFptWmxjbVZ1ZEZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXViR0Z6ZEY5c2IyRmtYMjF2Y21WZmFIUnRiQ0E5SUhObGJHWXViRzloWkY5dGIzSmxYMmgwYld3N1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYm1acGJtbDBaVk5qY205c2JFRndjR1Z1WkNoelpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc0tUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHVJQ0FnSUNBZ0lDQWdJQ0FnZXk4dmQyVWdjbVZqWldsMlpXUWdkR2hsSUhOaGJXVWdiV1Z6YzJGblpTQmhaMkZwYmlCemJ5QmtiMjRuZENCaFpHUXNJR0Z1WkNCMFpXeHNJRk1tUmlCMGFHRjBJSGRsSjNKbElHRjBJSFJvWlNCbGJtUXVMbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFYTmZiV0Y0WDNCaFoyVmtJRDBnZEhKMVpUdGNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ2ZWeHVYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NXBibVpwYm1sMFpWTmpjbTlzYkVGd2NHVnVaQ0E5SUdaMWJtTjBhVzl1S0NSdlltcGxZM1FwWEc0Z0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzSmxjM1ZzZEY5amJHRnpjeUU5WENKY0lpbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MaVJwYm1acGJtbDBaVjl6WTNKdmJHeGZZMjl1ZEdGcGJtVnlMbVpwYm1Rb2MyVnNaaTVwYm1acGJtbDBaVjl6WTNKdmJHeGZjbVZ6ZFd4MFgyTnNZWE56S1M1c1lYTjBLQ2t1WVdaMFpYSW9KRzlpYW1WamRDazdYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxpUnBibVpwYm1sMFpWOXpZM0p2Ykd4ZlkyOXVkR0ZwYm1WeUxtRndjR1Z1WkNna2IySnFaV04wS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnZlZ4dVhHNWNiaUFnSUNBZ0lDQWdkR2hwY3k1MWNHUmhkR1ZTWlhOMWJIUnpJRDBnWm5WdVkzUnBiMjRvWkdGMFlTd2daR0YwWVY5MGVYQmxLVnh1SUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhrWVhSaFgzUjVjR1U5UFZ3aWFuTnZibHdpS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdleTh2ZEdobGJpQjNaU0JrYVdRZ1lTQnlaWEYxWlhOMElIUnZJSFJvWlNCaGFtRjRJR1Z1WkhCdmFXNTBMQ0J6YnlCbGVIQmxZM1FnWVc0Z2IySnFaV04wSUdKaFkydGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMmR5WVdJZ2RHaGxJSEpsYzNWc2RITWdZVzVrSUd4dllXUWdhVzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxuSmxjM1ZzZEhOZmFIUnRiQ0E5SUdSaGRHRmJKM0psYzNWc2RITW5YVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDZ2dkR2hwY3k1eVpYQnNZV05sWDNKbGMzVnNkSE1nS1NCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1YUhSdGJDaDBhR2x6TG5KbGMzVnNkSE5mYUhSdGJDazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0dSaGRHRmJKMlp2Y20wblhTa2hQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5eVpXMXZkbVVnWVd4c0lHVjJaVzUwY3lCbWNtOXRJRk1tUmlCbWIzSnRYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbTltWmlncE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmNtVnRiM1psSUhCaFoybHVZWFJwYjI1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1eVpXMXZkbVZCYW1GNFVHRm5hVzVoZEdsdmJpZ3BPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjbVZtY21WemFDQjBhR1VnWm05eWJTQW9ZWFYwYnlCamIzVnVkQ2xjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVqYjNCNVRHbHpkRWwwWlcxelEyOXVkR1Z1ZEhNb0pDaGtZWFJoV3lkbWIzSnRKMTBwTENBa2RHaHBjeWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTkxY0dSaGRHVWdZWFIwY21saWRYUmxjeUJ2YmlCbWIzSnRYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZMjl3ZVVadmNtMUJkSFJ5YVdKMWRHVnpLQ1FvWkdGMFlWc25abTl5YlNkZEtTd2dKSFJvYVhNcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmNtVWdhVzVwZENCVEprWWdZMnhoYzNNZ2IyNGdkR2hsSUdadmNtMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTXVjMlZoY21Ob1FXNWtSbWxzZEdWeUtIc25hWE5KYm1sMEp6b2dabUZzYzJWOUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeThrZEdocGN5NW1hVzVrS0Z3aWFXNXdkWFJjSWlrdWNtVnRiM1psUVhSMGNpaGNJbVJwYzJGaWJHVmtYQ0lwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb1pHRjBZVjkwZVhCbFBUMWNJbWgwYld4Y0lpa2dleTh2ZDJVZ1lYSmxJR1Y0Y0dWamRHbHVaeUIwYUdVZ2FIUnRiQ0J2WmlCMGFHVWdjbVZ6ZFd4MGN5QndZV2RsSUdKaFkyc3NJSE52SUdWNGRISmhZM1FnZEdobElHaDBiV3dnZDJVZ2JtVmxaRnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmtZWFJoWDI5aWFpQTlJQ1FvWkdGMFlTazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1eVpYTjFiSFJ6WDNCaFoyVmZhSFJ0YkNBOUlHUmhkR0U3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NXlaWE4xYkhSelgyaDBiV3dnUFNBa1pHRjBZVjl2WW1vdVptbHVaQ2dnZEdocGN5NWhhbUY0WDNSaGNtZGxkRjloZEhSeUlDa3VhSFJ0YkNncE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0NCMGFHbHpMbkpsY0d4aFkyVmZjbVZ6ZFd4MGN5QXBJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNW9kRzFzS0hSb2FYTXVjbVZ6ZFd4MGMxOW9kRzFzS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5Wd1pHRjBaVU52Ym5SbGJuUkJjbVZoY3lnZ0pHUmhkR0ZmYjJKcUlDazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNW1hVzVrS0Z3aUxuTmxZWEpqYUdGdVpHWnBiSFJsY2x3aUtTNXNaVzVuZEdnZ1BpQXdLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHN2TDNSb1pXNGdkR2hsY21VZ1lYSmxJSE5sWVhKamFDQm1iM0p0S0hNcElHbHVjMmxrWlNCMGFHVWdjbVZ6ZFd4MGN5QmpiMjUwWVdsdVpYSXNJSE52SUhKbExXbHVhWFFnZEdobGJWeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVKR0ZxWVhoZmNtVnpkV3gwYzE5amIyNTBZV2x1WlhJdVptbHVaQ2hjSWk1elpXRnlZMmhoYm1SbWFXeDBaWEpjSWlrdWMyVmhjbU5vUVc1a1JtbHNkR1Z5S0NrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTlwWmlCMGFHVWdZM1Z5Y21WdWRDQnpaV0Z5WTJnZ1ptOXliU0JwY3lCdWIzUWdhVzV6YVdSbElIUm9aU0J5WlhOMWJIUnpJR052Ym5SaGFXNWxjaXdnZEdobGJpQndjbTlqWldWa0lHRnpJRzV2Y20xaGJDQmhibVFnZFhCa1lYUmxJSFJvWlNCbWIzSnRYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1bWFXNWtLRndpTG5ObFlYSmphR0Z1WkdacGJIUmxjbHRrWVhSaExYTm1MV1p2Y20wdGFXUTlKMXdpSUNzZ2MyVnNaaTV6Wm1sa0lDc2dYQ0luWFZ3aUtTNXNaVzVuZEdnOVBUQXBJSHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkc1bGQxOXpaV0Z5WTJoZlptOXliU0E5SUNSa1lYUmhYMjlpYWk1bWFXNWtLRndpTG5ObFlYSmphR0Z1WkdacGJIUmxjbHRrWVhSaExYTm1MV1p2Y20wdGFXUTlKMXdpSUNzZ2MyVnNaaTV6Wm1sa0lDc2dYQ0luWFZ3aUtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9KRzVsZDE5elpXRnlZMmhmWm05eWJTNXNaVzVuZEdnZ1BUMGdNU2tnZXk4dmRHaGxiaUJ5WlhCc1lXTmxJSFJvWlNCelpXRnlZMmdnWm05eWJTQjNhWFJvSUhSb1pTQnVaWGNnYjI1bFhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjbVZ0YjNabElHRnNiQ0JsZG1WdWRITWdabkp2YlNCVEprWWdabTl5YlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTXViMlptS0NrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjbVZ0YjNabElIQmhaMmx1WVhScGIyNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1Y21WdGIzWmxRV3BoZUZCaFoybHVZWFJwYjI0b0tUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl5WldaeVpYTm9JSFJvWlNCbWIzSnRJQ2hoZFhSdklHTnZkVzUwS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWpiM0I1VEdsemRFbDBaVzF6UTI5dWRHVnVkSE1vSkc1bGQxOXpaV0Z5WTJoZlptOXliU3dnSkhSb2FYTXBPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNWd1pHRjBaU0JoZEhSeWFXSjFkR1Z6SUc5dUlHWnZjbTFjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVkyOXdlVVp2Y20xQmRIUnlhV0oxZEdWektDUnVaWGRmYzJWaGNtTm9YMlp2Y20wc0lDUjBhR2x6S1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaU0JwYm1sMElGTW1SaUJqYkdGemN5QnZiaUIwYUdVZ1ptOXliVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdWMyVmhjbU5vUVc1a1JtbHNkR1Z5S0hzbmFYTkpibWwwSnpvZ1ptRnNjMlY5S1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnZTF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5UjBhR2x6TG1acGJtUW9YQ0pwYm5CMWRGd2lLUzV5WlcxdmRtVkJkSFJ5S0Z3aVpHbHpZV0pzWldSY0lpazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFYTmZiV0Y0WDNCaFoyVmtJRDBnWm1Gc2MyVTdJQzh2Wm05eUlHbHVabWx1YVhSbElITmpjbTlzYkZ4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1amRYSnlaVzUwWDNCaFoyVmtJRDBnTVRzZ0x5OW1iM0lnYVc1bWFXNXBkR1VnYzJOeWIyeHNYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1Mbk5sZEVsdVptbHVhWFJsVTJOeWIyeHNRMjl1ZEdGcGJtVnlLQ2s3WEc1Y2JpQWdJQ0FnSUNBZ2ZWeHVYRzRnSUNBZ0lDQWdJSFJvYVhNdWRYQmtZWFJsUTI5dWRHVnVkRUZ5WldGeklEMGdablZ1WTNScGIyNG9JQ1JvZEcxc1gyUmhkR0VnS1NCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0JjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZJR0ZrWkNCaFpHUnBkR2x2Ym1Gc0lHTnZiblJsYm5RZ1lYSmxZWE5jYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2dnZEdocGN5NWhhbUY0WDNWd1pHRjBaVjl6WldOMGFXOXVjeUFtSmlCMGFHbHpMbUZxWVhoZmRYQmtZWFJsWDNObFkzUnBiMjV6TG14bGJtZDBhQ0FwSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbWIzSWdLR2x1WkdWNElEMGdNRHNnYVc1a1pYZ2dQQ0IwYUdsekxtRnFZWGhmZFhCa1lYUmxYM05sWTNScGIyNXpMbXhsYm1kMGFEc2dLeXRwYm1SbGVDa2dlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjMlZzWldOMGIzSWdQU0IwYUdsekxtRnFZWGhmZFhCa1lYUmxYM05sWTNScGIyNXpXMmx1WkdWNFhUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkNnZ2MyVnNaV04wYjNJZ0tTNW9kRzFzS0NBa2FIUnRiRjlrWVhSaExtWnBibVFvSUhObGJHVmpkRzl5SUNrdWFIUnRiQ2dwSUNrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lIUm9hWE11Wm1Ga1pVTnZiblJsYm5SQmNtVmhjeUE5SUdaMWJtTjBhVzl1S0NCa2FYSmxZM1JwYjI0Z0tTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNCY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdmNHRmphWFI1SUQwZ01DNDFPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLQ0JrYVhKbFkzUnBiMjRnUFQwOUlGd2lhVzVjSWlBcElIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnZjR0ZqYVhSNUlEMGdNVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLQ0IwYUdsekxtRnFZWGhmZFhCa1lYUmxYM05sWTNScGIyNXpJQ1ltSUhSb2FYTXVZV3BoZUY5MWNHUmhkR1ZmYzJWamRHbHZibk11YkdWdVozUm9JQ2tnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdadmNpQW9hVzVrWlhnZ1BTQXdPeUJwYm1SbGVDQThJSFJvYVhNdVlXcGhlRjkxY0dSaGRHVmZjMlZqZEdsdmJuTXViR1Z1WjNSb095QXJLMmx1WkdWNEtTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnpaV3hsWTNSdmNpQTlJSFJvYVhNdVlXcGhlRjkxY0dSaGRHVmZjMlZqZEdsdmJuTmJhVzVrWlhoZE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrS0NCelpXeGxZM1J2Y2lBcExuTjBiM0FvZEhKMVpTeDBjblZsS1M1aGJtbHRZWFJsS0NCN0lHOXdZV05wZEhrNklHOXdZV05wZEhsOUxDQmNJbVpoYzNSY0lpQXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnWEc0Z0lDQWdJQ0FnSUNBZ0lDQmNiaUFnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUhSb2FYTXVjbVZ0YjNabFYyOXZRMjl0YldWeVkyVkRiMjUwY205c2N5QTlJR1oxYm1OMGFXOXVLQ2w3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhkdmIxOXZjbVJsY21KNUlEMGdKQ2duTG5kdmIyTnZiVzFsY21ObExXOXlaR1Z5YVc1bklDNXZjbVJsY21KNUp5azdYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSGR2YjE5dmNtUmxjbUo1WDJadmNtMGdQU0FrS0NjdWQyOXZZMjl0YldWeVkyVXRiM0prWlhKcGJtY25LVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdKSGR2YjE5dmNtUmxjbUo1WDJadmNtMHViMlptS0NrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FrZDI5dlgyOXlaR1Z5WW5rdWIyWm1LQ2s3WEc0Z0lDQWdJQ0FnSUgwN1hHNWNiaUFnSUNBZ0lDQWdkR2hwY3k1aFpHUlJkV1Z5ZVZCaGNtRnRJRDBnWm5WdVkzUnBiMjRvYm1GdFpTd2dkbUZzZFdVc0lIVnliRjkwZVhCbEtYdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIVnliRjkwZVhCbEtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RYSnNYM1I1Y0dVZ1BTQmNJbUZzYkZ3aU8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1bGVIUnlZVjl4ZFdWeWVWOXdZWEpoYlhOYmRYSnNYM1I1Y0dWZFcyNWhiV1ZkSUQwZ2RtRnNkV1U3WEc1Y2JpQWdJQ0FnSUNBZ2ZUdGNibHh1SUNBZ0lDQWdJQ0IwYUdsekxtbHVhWFJYYjI5RGIyMXRaWEpqWlVOdmJuUnliMnh6SUQwZ1puVnVZM1JwYjI0b0tYdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV5WlcxdmRtVlhiMjlEYjIxdFpYSmpaVU52Ym5SeWIyeHpLQ2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2QyOXZYMjl5WkdWeVlua2dQU0FrS0NjdWQyOXZZMjl0YldWeVkyVXRiM0prWlhKcGJtY2dMbTl5WkdWeVlua25LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrZDI5dlgyOXlaR1Z5WW5sZlptOXliU0E5SUNRb0p5NTNiMjlqYjIxdFpYSmpaUzF2Y21SbGNtbHVaeWNwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2IzSmtaWEpmZG1Gc0lEMGdYQ0pjSWp0Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0NSM2IyOWZiM0prWlhKaWVTNXNaVzVuZEdnK01DbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCdmNtUmxjbDkyWVd3Z1BTQWtkMjl2WDI5eVpHVnlZbmt1ZG1Gc0tDazdYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYjNKa1pYSmZkbUZzSUQwZ2MyVnNaaTVuWlhSUmRXVnllVkJoY21GdFJuSnZiVlZTVENoY0ltOXlaR1Z5WW5sY0lpd2dkMmx1Wkc5M0xteHZZMkYwYVc5dUxtaHlaV1lwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWh2Y21SbGNsOTJZV3c5UFZ3aWJXVnVkVjl2Y21SbGNsd2lLVnh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHOXlaR1Z5WDNaaGJDQTlJRndpWENJN1hHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0NodmNtUmxjbDkyWVd3aFBWd2lYQ0lwSmlZb0lTRnZjbVJsY2w5MllXd3BLVnh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WlhoMGNtRmZjWFZsY25sZmNHRnlZVzF6TG1Gc2JDNXZjbVJsY21KNUlEMGdiM0prWlhKZmRtRnNPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjNiMjlmYjNKa1pYSmllVjltYjNKdExtOXVLQ2R6ZFdKdGFYUW5MQ0JtZFc1amRHbHZiaWhsS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1V1Y0hKbGRtVnVkRVJsWm1GMWJIUW9LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNaaGNpQm1iM0p0SUQwZ1pTNTBZWEpuWlhRN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUdaaGJITmxPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjNiMjlmYjNKa1pYSmllUzV2YmloY0ltTm9ZVzVuWlZ3aUxDQm1kVzVqZEdsdmJpaGxLVnh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVXVjSEpsZG1WdWRFUmxabUYxYkhRb0tUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMllXd2dQU0FrS0hSb2FYTXBMblpoYkNncE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFpoYkQwOVhDSnRaVzUxWDI5eVpHVnlYQ0lwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZV3dnUFNCY0lsd2lPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVaWGgwY21GZmNYVmxjbmxmY0dGeVlXMXpMbUZzYkM1dmNtUmxjbUo1SUQwZ2RtRnNPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTXVkSEpwWjJkbGNpaGNJbk4xWW0xcGRGd2lLVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVJR1poYkhObE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hHNWNiaUFnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUhSb2FYTXVjMk55YjJ4c1VtVnpkV3gwY3lBOUlHWjFibU4wYVc5dUtDbGNiaUFnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9LSE5sYkdZdWMyTnliMnhzWDI5dVgyRmpkR2x2YmowOWMyVnNaaTVoYW1GNFgyRmpkR2x2YmlsOGZDaHpaV3htTG5OamNtOXNiRjl2Ymw5aFkzUnBiMjQ5UFZ3aVlXeHNYQ0lwS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWMyTnliMnhzVkc5UWIzTW9LVHNnTHk5elkzSnZiR3dnZEdobElIZHBibVJ2ZHlCcFppQnBkQ0JvWVhNZ1ltVmxiaUJ6WlhSY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzTmxiR1l1WVdwaGVGOWhZM1JwYjI0Z1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ2RHaHBjeTUxY0dSaGRHVlZjbXhJYVhOMGIzSjVJRDBnWm5WdVkzUnBiMjRvWVdwaGVGOXlaWE4xYkhSelgzVnliQ2xjYmlBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhWelpWOW9hWE4wYjNKNVgyRndhU0E5SURBN1hHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2QybHVaRzkzTG1ocGMzUnZjbmtnSmlZZ2QybHVaRzkzTG1ocGMzUnZjbmt1Y0hWemFGTjBZWFJsS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFZ6WlY5b2FYTjBiM0o1WDJGd2FTQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMWFZ6WlMxb2FYTjBiM0o1TFdGd2FWd2lLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9LSE5sYkdZdWRYQmtZWFJsWDJGcVlYaGZkWEpzUFQweEtTWW1LSFZ6WlY5b2FYTjBiM0o1WDJGd2FUMDlNU2twWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl1YjNjZ1kyaGxZMnNnYVdZZ2RHaGxJR0p5YjNkelpYSWdjM1Z3Y0c5eWRITWdhR2x6ZEc5eWVTQnpkR0YwWlNCd2RYTm9JRG9wWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tIZHBibVJ2ZHk1b2FYTjBiM0o1SUNZbUlIZHBibVJ2ZHk1b2FYTjBiM0o1TG5CMWMyaFRkR0YwWlNsY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2hwYzNSdmNua3VjSFZ6YUZOMFlYUmxLRzUxYkd3c0lHNTFiR3dzSUdGcVlYaGZjbVZ6ZFd4MGMxOTFjbXdwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNCMGFHbHpMbkpsYlc5MlpVRnFZWGhRWVdkcGJtRjBhVzl1SUQwZ1puVnVZM1JwYjI0b0tWeHVJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaDBlWEJsYjJZb2MyVnNaaTVoYW1GNFgyeHBibXR6WDNObGJHVmpkRzl5S1NFOVhDSjFibVJsWm1sdVpXUmNJaWxjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdGcVlYaGZiR2x1YTNOZmIySnFaV04wSUQwZ2FsRjFaWEo1S0hObGJHWXVZV3BoZUY5c2FXNXJjMTl6Wld4bFkzUnZjaWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tZV3BoZUY5c2FXNXJjMTl2WW1wbFkzUXViR1Z1WjNSb1BqQXBYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1lXcGhlRjlzYVc1cmMxOXZZbXBsWTNRdWIyWm1LQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ2RHaHBjeTVuWlhSQ1lYTmxWWEpzSUQwZ1puVnVZM1JwYjI0b0lIVnliQ0FwSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQzh2Ym05M0lITmxaU0JwWmlCM1pTQmhjbVVnYjI0Z2RHaGxJRlZTVENCM1pTQjBhR2x1YXk0dUxseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliRjl3WVhKMGN5QTlJSFZ5YkM1emNHeHBkQ2hjSWo5Y0lpazdYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkWEpzWDJKaGMyVWdQU0JjSWx3aU8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaDFjbXhmY0dGeWRITXViR1Z1WjNSb1BqQXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RYSnNYMkpoYzJVZ1BTQjFjbXhmY0dGeWRITmJNRjA3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IxY214ZlltRnpaU0E5SUhWeWJEdGNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQjFjbXhmWW1GelpUdGNiaUFnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0IwYUdsekxtTmhia1psZEdOb1FXcGhlRkpsYzNWc2RITWdQU0JtZFc1amRHbHZiaWhtWlhSamFGOTBlWEJsS1Z4dUlDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvWm1WMFkyaGZkSGx3WlNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdabGRHTm9YM1I1Y0dVZ1BTQmNJbHdpTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWm1WMFkyaGZZV3BoZUY5eVpYTjFiSFJ6SUQwZ1ptRnNjMlU3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVhWE5mWVdwaGVEMDlNU2xjYmlBZ0lDQWdJQ0FnSUNBZ0lIc3ZMM1JvWlc0Z2QyVWdkMmxzYkNCaGFtRjRJSE4xWW0xcGRDQjBhR1VnWm05eWJWeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTloYm1RZ2FXWWdkMlVnWTJGdUlHWnBibVFnZEdobElISmxjM1ZzZEhNZ1kyOXVkR0ZwYm1WeVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk0a1lXcGhlRjl5WlhOMWJIUnpYMk52Ym5SaGFXNWxjaTVzWlc1bmRHZzlQVEVwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITWdQU0IwY25WbE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeVpYTjFiSFJ6WDNWeWJDQTlJSE5sYkdZdWNtVnpkV3gwYzE5MWNtdzdJQ0F2TDF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnlaWE4xYkhSelgzVnliRjlsYm1OdlpHVmtJRDBnSnljN0lDQXZMMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCamRYSnlaVzUwWDNWeWJDQTlJSGRwYm1SdmR5NXNiMk5oZEdsdmJpNW9jbVZtTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXBaMjV2Y21VZ0l5QmhibVFnWlhabGNubDBhR2x1WnlCaFpuUmxjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCb1lYTm9YM0J2Y3lBOUlIZHBibVJ2ZHk1c2IyTmhkR2x2Ymk1b2NtVm1MbWx1WkdWNFQyWW9KeU1uS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaG9ZWE5vWDNCdmN5RTlQUzB4S1h0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdZM1Z5Y21WdWRGOTFjbXdnUFNCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFppNXpkV0p6ZEhJb01Dd2dkMmx1Wkc5M0xteHZZMkYwYVc5dUxtaHlaV1l1YVc1a1pYaFBaaWduSXljcEtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlnZ0tDQW9JSE5sYkdZdVpHbHpjR3hoZVY5eVpYTjFiSFJmYldWMGFHOWtQVDFjSW1OMWMzUnZiVjkzYjI5amIyMXRaWEpqWlY5emRHOXlaVndpSUNrZ2ZId2dLQ0J6Wld4bUxtUnBjM0JzWVhsZmNtVnpkV3gwWDIxbGRHaHZaRDA5WENKd2IzTjBYM1I1Y0dWZllYSmphR2wyWlZ3aUlDa2dLU0FtSmlBb0lITmxiR1l1Wlc1aFlteGxYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVnpJRDA5SURFZ0tTQXBYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2djMlZzWmk1amRYSnlaVzUwWDNSaGVHOXViMjE1WDJGeVkyaHBkbVVnSVQwOVhDSmNJaUFwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWmxkR05vWDJGcVlYaGZjbVZ6ZFd4MGN5QTlJSFJ5ZFdVN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnWm1WMFkyaGZZV3BoZUY5eVpYTjFiSFJ6TzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5cDJZWElnY21WemRXeDBjMTkxY213Z1BTQndjbTlqWlhOelgyWnZjbTB1WjJWMFVtVnpkV3gwYzFWeWJDaHpaV3htTENCelpXeG1MbkpsYzNWc2RITmZkWEpzS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCaFkzUnBkbVZmZEdGNElEMGdjSEp2WTJWemMxOW1iM0p0TG1kbGRFRmpkR2wyWlZSaGVDZ3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1WjJWMFZYSnNVR0Z5WVcxektIUnlkV1VzSUNjbkxDQmhZM1JwZG1WZmRHRjRLVHNxTDF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JseHVYRzVjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmJtOTNJSE5sWlNCcFppQjNaU0JoY21VZ2IyNGdkR2hsSUZWU1RDQjNaU0IwYUdsdWF5NHVMbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMWNteGZZbUZ6WlNBOUlIUm9hWE11WjJWMFFtRnpaVlZ5YkNnZ1kzVnljbVZ1ZEY5MWNtd2dLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNaaGNpQnlaWE4xYkhSelgzVnliRjlpWVhObElEMGdkR2hwY3k1blpYUkNZWE5sVlhKc0tDQmpkWEp5Wlc1MFgzVnliQ0FwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR3hoYm1jZ1BTQnpaV3htTG1kbGRGRjFaWEo1VUdGeVlXMUdjbTl0VlZKTUtGd2liR0Z1WjF3aUxDQjNhVzVrYjNjdWJHOWpZWFJwYjI0dWFISmxaaWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tIUjVjR1Z2Wmloc1lXNW5LU0U5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBKaVlvYkdGdVp5RTlQVzUxYkd3cEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZFhKc1gySmhjMlVnUFNCelpXeG1MbUZrWkZWeWJGQmhjbUZ0S0hWeWJGOWlZWE5sTENCY0lteGhibWM5WENJcmJHRnVaeWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE5tYVdRZ1BTQnpaV3htTG1kbGRGRjFaWEo1VUdGeVlXMUdjbTl0VlZKTUtGd2ljMlpwWkZ3aUxDQjNhVzVrYjNjdWJHOWpZWFJwYjI0dWFISmxaaWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwybG1JSE5tYVdRZ2FYTWdZU0J1ZFcxaVpYSmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWhPZFcxaVpYSW9jR0Z5YzJWR2JHOWhkQ2h6Wm1sa0tTa2dQVDBnYzJacFpDbGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhWeWJGOWlZWE5sSUQwZ2MyVnNaaTVoWkdSVmNteFFZWEpoYlNoMWNteGZZbUZ6WlN3Z1hDSnpabWxrUFZ3aUszTm1hV1FwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZhV1lnWVc1NUlHOW1JSFJvWlNBeklHTnZibVJwZEdsdmJuTWdZWEpsSUhSeWRXVXNJSFJvWlc0Z2FYUnpJR2R2YjJRZ2RHOGdaMjljYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2THlBdElERWdmQ0JwWmlCMGFHVWdkWEpzSUdKaGMyVWdQVDBnY21WemRXeDBjMTkxY214Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5QXRJRElnZkNCcFppQjFjbXdnWW1GelpTc2dYQ0l2WENJZ0lEMDlJSEpsYzNWc2RITmZkWEpzSUMwZ2FXNGdZMkZ6WlNCdlppQjFjMlZ5SUdWeWNtOXlJR2x1SUhSb1pTQnlaWE4xYkhSeklGVlNURnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2SUMwZ015QjhJR2xtSUhSb1pTQnlaWE4xYkhSeklGVlNUQ0JvWVhNZ2RYSnNJSEJoY21GdGN5d2dZVzVrSUhSb1pTQmpkWEp5Wlc1MElIVnliQ0J6ZEdGeWRITWdkMmwwYUNCMGFHVWdjbVZ6ZFd4MGN5QlZVa3dnWEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzUnlhVzBnWVc1NUlIUnlZV2xzYVc1bklITnNZWE5vSUdadmNpQmxZWE5wWlhJZ1kyOXRjR0Z5YVhOdmJqcGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjFjbXhmWW1GelpTQTlJSFZ5YkY5aVlYTmxMbkpsY0d4aFkyVW9MMXhjTHlRdkxDQW5KeWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY21WemRXeDBjMTkxY213Z1BTQnlaWE4xYkhSelgzVnliQzV5WlhCc1lXTmxLQzljWEM4a0x5d2dKeWNwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhKbGMzVnNkSE5mZFhKc1gyVnVZMjlrWldRZ1BTQmxibU52WkdWVlVra29jbVZ6ZFd4MGMxOTFjbXdwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR04xY25KbGJuUmZkWEpzWDJOdmJuUmhhVzV6WDNKbGMzVnNkSE5mZFhKc0lEMGdMVEU3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tIVnliRjlpWVhObFBUMXlaWE4xYkhSelgzVnliQ2w4ZkNoMWNteGZZbUZ6WlM1MGIweHZkMlZ5UTJGelpTZ3BQVDF5WlhOMWJIUnpYM1Z5YkY5bGJtTnZaR1ZrTG5SdlRHOTNaWEpEWVhObEtDa3BJQ0FwZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmpkWEp5Wlc1MFgzVnliRjlqYjI1MFlXbHVjMTl5WlhOMWJIUnpYM1Z5YkNBOUlERTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU0JsYkhObElIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tDQnlaWE4xYkhSelgzVnliQzVwYm1SbGVFOW1LQ0FuUHljZ0tTQWhQVDBnTFRFZ0ppWWdZM1Z5Y21WdWRGOTFjbXd1YkdGemRFbHVaR1Y0VDJZb2NtVnpkV3gwYzE5MWNtd3NJREFwSUQwOVBTQXdJQ2tnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWTNWeWNtVnVkRjkxY214ZlkyOXVkR0ZwYm5OZmNtVnpkV3gwYzE5MWNtd2dQU0F4TzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTV2Ym14NVgzSmxjM1ZzZEhOZllXcGhlRDA5TVNsY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN0x5OXBaaUJoSUhWelpYSWdhR0Z6SUdOb2IzTmxiaUIwYnlCdmJteDVJR0ZzYkc5M0lHRnFZWGdnYjI0Z2NtVnpkV3gwY3lCd1lXZGxjeUFvWkdWbVlYVnNkQ0JpWldoaGRtbHZkWElwWEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvSUdOMWNuSmxiblJmZFhKc1gyTnZiblJoYVc1elgzSmxjM1ZzZEhOZmRYSnNJRDRnTFRFcFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHN2TDNSb2FYTWdiV1ZoYm5NZ2RHaGxJR04xY25KbGJuUWdWVkpNSUdOdmJuUmhhVzV6SUhSb1pTQnlaWE4xYkhSeklIVnliQ3dnZDJocFkyZ2diV1ZoYm5NZ2QyVWdZMkZ1SUdSdklHRnFZWGhjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1psZEdOb1gyRnFZWGhmY21WemRXeDBjeUE5SUhSeWRXVTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITWdQU0JtWVd4elpUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGJITmxYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaG1aWFJqYUY5MGVYQmxQVDFjSW5CaFoybHVZWFJwYjI1Y0lpbGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0lHTjFjbkpsYm5SZmRYSnNYMk52Ym5SaGFXNXpYM0psYzNWc2RITmZkWEpzSUQ0Z0xURXBYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdMeTkwYUdseklHMWxZVzV6SUhSb1pTQmpkWEp5Wlc1MElGVlNUQ0JqYjI1MFlXbHVjeUIwYUdVZ2NtVnpkV3gwY3lCMWNtd3NJSGRvYVdOb0lHMWxZVzV6SUhkbElHTmhiaUJrYnlCaGFtRjRYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJWY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMlJ2YmlkMElHRnFZWGdnY0dGbmFXNWhkR2x2YmlCM2FHVnVJRzV2ZENCdmJpQmhJRk1tUmlCd1lXZGxYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWm1WMFkyaGZZV3BoZUY5eVpYTjFiSFJ6SUQwZ1ptRnNjMlU3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITTdYRzRnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNCMGFHbHpMbk5sZEhWd1FXcGhlRkJoWjJsdVlYUnBiMjRnUFNCbWRXNWpkR2x2YmlncFhHNGdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmFXNW1hVzVwZEdVZ2MyTnliMnhzWEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwYUdsekxuQmhaMmx1WVhScGIyNWZkSGx3WlQwOVBWd2lhVzVtYVc1cGRHVmZjMk55YjJ4c1hDSXBYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR2x1Wm1sdWFYUmxYM05qY205c2JGOWxibVFnUFNCbVlXeHpaVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxtWnBibVFvWENKYlpHRjBZUzF6WldGeVkyZ3RabWxzZEdWeUxXRmpkR2x2YmowbmFXNW1hVzVwZEdVdGMyTnliMnhzTFdWdVpDZGRYQ0lwTG14bGJtZDBhRDR3S1Z4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhVzVtYVc1cGRHVmZjMk55YjJ4c1gyVnVaQ0E5SUhSeWRXVTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhWE5mYldGNFgzQmhaMlZrSUQwZ2RISjFaVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHdZWEp6WlVsdWRDaDBhR2x6TG1sdWMzUmhibU5sWDI1MWJXSmxjaWs5UFQweEtTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb2QybHVaRzkzS1M1dlptWW9YQ0p6WTNKdmJHeGNJaXdnYzJWc1ppNXZibGRwYm1SdmQxTmpjbTlzYkNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tITmxiR1l1WTJGdVJtVjBZMmhCYW1GNFVtVnpkV3gwY3loY0luQmhaMmx1WVhScGIyNWNJaWtwSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb2QybHVaRzkzS1M1dmJpaGNJbk5qY205c2JGd2lMQ0J6Wld4bUxtOXVWMmx1Wkc5M1UyTnliMnhzS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvZEhsd1pXOW1LSE5sYkdZdVlXcGhlRjlzYVc1cmMxOXpaV3hsWTNSdmNpazlQVndpZFc1a1pXWnBibVZrWENJcElIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200N1hHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa0tHUnZZM1Z0Wlc1MEtTNXZabVlvSjJOc2FXTnJKeXdnYzJWc1ppNWhhbUY0WDJ4cGJtdHpYM05sYkdWamRHOXlLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrS0dSdlkzVnRaVzUwS1M1dlptWW9jMlZzWmk1aGFtRjRYMnhwYm10elgzTmxiR1ZqZEc5eUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtLSE5sYkdZdVlXcGhlRjlzYVc1cmMxOXpaV3hsWTNSdmNpa3ViMlptS0NrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtLR1J2WTNWdFpXNTBLUzV2YmlnblkyeHBZMnNuTENCelpXeG1MbUZxWVhoZmJHbHVhM05mYzJWc1pXTjBiM0lzSUdaMWJtTjBhVzl1S0dVcGUxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1WTJGdVJtVjBZMmhCYW1GNFVtVnpkV3gwY3loY0luQmhaMmx1WVhScGIyNWNJaWtwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVXVjSEpsZG1WdWRFUmxabUYxYkhRb0tUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUd4cGJtc2dQU0JxVVhWbGNua29kR2hwY3lrdVlYUjBjaWduYUhKbFppY3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aGFtRjRYMkZqZEdsdmJpQTlJRndpY0dGbmFXNWhkR2x2Ymx3aU8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnY0dGblpVNTFiV0psY2lBOUlITmxiR1l1WjJWMFVHRm5aV1JHY205dFZWSk1LR3hwYm1zcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbUYwZEhJb1hDSmtZWFJoTFhCaFoyVmtYQ0lzSUhCaFoyVk9kVzFpWlhJcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1abGRHTm9RV3BoZUZKbGMzVnNkSE1vS1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUdaaGJITmxPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lIMDdYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NW5aWFJRWVdkbFpFWnliMjFWVWt3Z1BTQm1kVzVqZEdsdmJpaFZVa3dwZTF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NHRm5aV1JXWVd3Z1BTQXhPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OW1hWEp6ZENCMFpYTjBJSFJ2SUhObFpTQnBaaUIzWlNCb1lYWmxJRndpTDNCaFoyVXZOQzljSWlCcGJpQjBhR1VnVlZKTVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RIQldZV3dnUFNCelpXeG1MbWRsZEZGMVpYSjVVR0Z5WVcxR2NtOXRWVkpNS0Z3aWMyWmZjR0ZuWldSY0lpd2dWVkpNS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0NoMGVYQmxiMllvZEhCV1lXd3BQVDFjSW5OMGNtbHVaMXdpS1h4OEtIUjVjR1Z2WmloMGNGWmhiQ2s5UFZ3aWJuVnRZbVZ5WENJcEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhCaFoyVmtWbUZzSUQwZ2RIQldZV3c3WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCd1lXZGxaRlpoYkR0Y2JpQWdJQ0FnSUNBZ2ZUdGNibHh1SUNBZ0lDQWdJQ0IwYUdsekxtZGxkRkYxWlhKNVVHRnlZVzFHY205dFZWSk1JRDBnWm5WdVkzUnBiMjRvYm1GdFpTd2dWVkpNS1h0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIRnpkSEpwYm1jZ1BTQmNJajljSWl0VlVrd3VjM0JzYVhRb0p6OG5LVnN4WFR0Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWh4YzNSeWFXNW5LU0U5WENKMWJtUmxabWx1WldSY0lpbGNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkbUZzSUQwZ1pHVmpiMlJsVlZKSlEyOXRjRzl1Wlc1MEtDaHVaWGNnVW1WblJYaHdLQ2RiUDN3bVhTY2dLeUJ1WVcxbElDc2dKejBuSUNzZ0p5aGJYaVk3WFNzL0tTZ21mQ044TzN3a0tTY3BMbVY0WldNb2NYTjBjbWx1WnlsOGZGc3NYQ0pjSWwwcFd6RmRMbkpsY0d4aFkyVW9MMXhjS3k5bkxDQW5KVEl3SnlrcGZIeHVkV3hzTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhKbGRIVnliaUIyWVd3N1hHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z1hDSmNJanRjYmlBZ0lDQWdJQ0FnZlR0Y2JseHVYRzVjYmlBZ0lDQWdJQ0FnZEdocGN5NW1iM0p0VlhCa1lYUmxaQ0E5SUdaMWJtTjBhVzl1S0dVcGUxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyVXVjSEpsZG1WdWRFUmxabUYxYkhRb0tUdGNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1WVhWMGIxOTFjR1JoZEdVOVBURXBJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxuTjFZbTFwZEVadmNtMG9LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvS0hObGJHWXVZWFYwYjE5MWNHUmhkR1U5UFRBcEppWW9jMlZzWmk1aGRYUnZYMk52ZFc1MFgzSmxabkpsYzJoZmJXOWtaVDA5TVNrcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNW1iM0p0VlhCa1lYUmxaRVpsZEdOb1FXcGhlQ2dwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z1ptRnNjMlU3WEc0Z0lDQWdJQ0FnSUgwN1hHNWNiaUFnSUNBZ0lDQWdkR2hwY3k1bWIzSnRWWEJrWVhSbFpFWmxkR05vUVdwaGVDQTlJR1oxYm1OMGFXOXVLQ2w3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQzh2Ykc5dmNDQjBhSEp2ZFdkb0lHRnNiQ0IwYUdVZ1ptbGxiR1J6SUdGdVpDQmlkV2xzWkNCMGFHVWdWVkpNWEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1abGRHTm9RV3BoZUVadmNtMG9LVHRjYmx4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdabUZzYzJVN1hHNGdJQ0FnSUNBZ0lIMDdYRzVjYmlBZ0lDQWdJQ0FnTHk5dFlXdGxJR0Z1ZVNCamIzSnlaV04wYVc5dWN5OTFjR1JoZEdWeklIUnZJR1pwWld4a2N5QmlaV1p2Y21VZ2RHaGxJSE4xWW0xcGRDQmpiMjF3YkdWMFpYTmNiaUFnSUNBZ0lDQWdkR2hwY3k1elpYUkdhV1ZzWkhNZ1BTQm1kVzVqZEdsdmJpaGxLWHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdMeTl6YjIxbGRHbHRaWE1nZEdobElHWnZjbTBnYVhNZ2MzVmliV2wwZEdWa0lIZHBkR2h2ZFhRZ2RHaGxJSE5zYVdSbGNpQjVaWFFnYUdGMmFXNW5JSFZ3WkdGMFpXUXNJR0Z1WkNCaGN5QjNaU0JuWlhRZ2IzVnlJSFpoYkhWbGN5Qm1jbTl0WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMM1JvWlNCemJHbGtaWElnWVc1a0lHNXZkQ0JwYm5CMWRITXNJSGRsSUc1bFpXUWdkRzhnWTJobFkyc2dhWFFnYVdZZ2JtVmxaSE1nZEc4Z1ltVWdjMlYwWEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMjl1YkhrZ2IyTmpkWEp6SUdsbUlHRnFZWGdnYVhNZ2IyWm1MQ0JoYm1RZ1lYVjBiM04xWW0xcGRDQnZibHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0b0tTQjdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHWnBaV3hrSUQwZ0pDaDBhR2x6S1R0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ5WVc1blpWOWthWE53YkdGNVgzWmhiSFZsY3lBOUlDUm1hV1ZzWkM1bWFXNWtLQ2N1YzJZdGJXVjBZUzF5WVc1blpTMXpiR2xrWlhJbktTNWhkSFJ5S0Z3aVpHRjBZUzFrYVhOd2JHRjVMWFpoYkhWbGN5MWhjMXdpS1RzdkwyUmhkR0V0WkdsemNHeGhlUzEyWVd4MVpYTXRZWE05WENKMFpYaDBYQ0pjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtISmhibWRsWDJScGMzQnNZWGxmZG1Gc2RXVnpQVDA5WENKMFpYaDBhVzV3ZFhSY0lpa2dlMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1JtYVdWc1pDNW1hVzVrS0Z3aUxtMWxkR0V0YzJ4cFpHVnlYQ0lwTG14bGJtZDBhRDR3S1h0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUm1hV1ZzWkM1bWFXNWtLRndpTG0xbGRHRXRjMnhwWkdWeVhDSXBMbVZoWTJnb1puVnVZM1JwYjI0Z0tHbHVaR1Y0S1NCN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6Ykdsa1pYSmZiMkpxWldOMElEMGdKQ2gwYUdsektWc3dYVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2MyeHBaR1Z5WDJWc0lEMGdKQ2gwYUdsektTNWpiRzl6WlhOMEtGd2lMbk5tTFcxbGRHRXRjbUZ1WjJVdGMyeHBaR1Z5WENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzFwYmxaaGJDQTlJQ1J6Ykdsa1pYSmZaV3d1Wm1sdVpDaGNJaTV6WmkxeVlXNW5aUzF0YVc1Y0lpa3VkbUZzS0NrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiV0Y0Vm1Gc0lEMGdKSE5zYVdSbGNsOWxiQzVtYVc1a0tGd2lMbk5tTFhKaGJtZGxMVzFoZUZ3aUtTNTJZV3dvS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhOc2FXUmxjbDl2WW1wbFkzUXVibTlWYVZOc2FXUmxjaTV6WlhRb1cyMXBibFpoYkN3Z2JXRjRWbUZzWFNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hHNWNiaUFnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUM4dmMzVmliV2wwWEc0Z0lDQWdJQ0FnSUhSb2FYTXVjM1ZpYldsMFJtOXliU0E5SUdaMWJtTjBhVzl1S0dVcGUxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyeHZiM0FnZEdoeWIzVm5hQ0JoYkd3Z2RHaGxJR1pwWld4a2N5QmhibVFnWW5WcGJHUWdkR2hsSUZWU1RGeHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTVwYzFOMVltMXBkSFJwYm1jZ1BUMGdkSEoxWlNrZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCbVlXeHpaVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV6WlhSR2FXVnNaSE1vS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVkyeGxZWEpVYVcxbGNpZ3BPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1selUzVmliV2wwZEdsdVp5QTlJSFJ5ZFdVN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUhCeWIyTmxjM05mWm05eWJTNXpaWFJVWVhoQmNtTm9hWFpsVW1WemRXeDBjMVZ5YkNoelpXeG1MQ0J6Wld4bUxuSmxjM1ZzZEhOZmRYSnNLVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk0a1lXcGhlRjl5WlhOMWJIUnpYMk52Ym5SaGFXNWxjaTVoZEhSeUtGd2laR0YwWVMxd1lXZGxaRndpTENBeEtUc2dMeTlwYm1sMElIQmhaMlZrWEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVZMkZ1Um1WMFkyaEJhbUY0VW1WemRXeDBjeWdwS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdleTh2ZEdobGJpQjNaU0IzYVd4c0lHRnFZWGdnYzNWaWJXbDBJSFJvWlNCbWIzSnRYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmWVdOMGFXOXVJRDBnWENKemRXSnRhWFJjSWpzZ0x5OXpieUIzWlNCcmJtOTNJR2wwSUhkaGMyNG5kQ0J3WVdkcGJtRjBhVzl1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNW1aWFJqYUVGcVlYaFNaWE4xYkhSektDazdYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3THk5MGFHVnVJSGRsSUhkcGJHd2djMmx0Y0d4NUlISmxaR2x5WldOMElIUnZJSFJvWlNCU1pYTjFiSFJ6SUZWU1RGeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGMzVnNkSE5mZFhKc0lEMGdjSEp2WTJWemMxOW1iM0p0TG1kbGRGSmxjM1ZzZEhOVmNtd29jMlZzWml3Z2MyVnNaaTV5WlhOMWJIUnpYM1Z5YkNrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1WjJWMFZYSnNVR0Z5WVcxektIUnlkV1VzSUNjbktUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWE4xYkhSelgzVnliQ0E5SUhObGJHWXVZV1JrVlhKc1VHRnlZVzBvY21WemRXeDBjMTkxY213c0lIRjFaWEo1WDNCaGNtRnRjeWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFppQTlJSEpsYzNWc2RITmZkWEpzTzF4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z1ptRnNjMlU3WEc0Z0lDQWdJQ0FnSUgwN1hHNGdJQ0FnSUNBZ0lIUm9hWE11Y21WelpYUkdiM0p0SUQwZ1puVnVZM1JwYjI0b2MzVmliV2wwWDJadmNtMHBYRzRnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZkVzV6WlhRZ1lXeHNJR1pwWld4a2MxeHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGtabWxsYkdSekxtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrWm1sbGJHUWdQU0FrS0hSb2FYTXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRnh1WEhSY2RGeDBYSFFrWm1sbGJHUXVjbVZ0YjNabFFYUjBjaWhjSW1SaGRHRXRjMll0ZEdGNGIyNXZiWGt0WVhKamFHbDJaVndpS1R0Y2JseDBYSFJjZEZ4MFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXpkR0Z1WkdGeVpDQm1hV1ZzWkNCMGVYQmxjMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JtYVdWc1pDNW1hVzVrS0Z3aWMyVnNaV04wT201dmRDaGJiWFZzZEdsd2JHVTlKMjExYkhScGNHeGxKMTBwSUQ0Z2IzQjBhVzl1T21acGNuTjBMV05vYVd4a1hDSXBMbkJ5YjNBb1hDSnpaV3hsWTNSbFpGd2lMQ0IwY25WbEtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRdVptbHVaQ2hjSW5ObGJHVmpkRnR0ZFd4MGFYQnNaVDBuYlhWc2RHbHdiR1VuWFNBK0lHOXdkR2x2Ymx3aUtTNXdjbTl3S0Z3aWMyVnNaV04wWldSY0lpd2dabUZzYzJVcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUm1hV1ZzWkM1bWFXNWtLRndpYVc1d2RYUmJkSGx3WlQwblkyaGxZMnRpYjNnblhWd2lLUzV3Y205d0tGd2lZMmhsWTJ0bFpGd2lMQ0JtWVd4elpTazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR1pwWld4a0xtWnBibVFvWENJK0lIVnNJRDRnYkdrNlptbHljM1F0WTJocGJHUWdhVzV3ZFhSYmRIbHdaVDBuY21Ga2FXOG5YVndpS1M1d2NtOXdLRndpWTJobFkydGxaRndpTENCMGNuVmxLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWm1sbGJHUXVabWx1WkNoY0ltbHVjSFYwVzNSNWNHVTlKM1JsZUhRblhWd2lLUzUyWVd3b1hDSmNJaWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdacFpXeGtMbVpwYm1Rb1hDSXVjMll0YjNCMGFXOXVMV0ZqZEdsMlpWd2lLUzV5WlcxdmRtVkRiR0Z6Y3loY0luTm1MVzl3ZEdsdmJpMWhZM1JwZG1WY0lpazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR1pwWld4a0xtWnBibVFvWENJK0lIVnNJRDRnYkdrNlptbHljM1F0WTJocGJHUWdhVzV3ZFhSYmRIbHdaVDBuY21Ga2FXOG5YVndpS1M1d1lYSmxiblFvS1M1aFpHUkRiR0Z6Y3loY0luTm1MVzl3ZEdsdmJpMWhZM1JwZG1WY0lpazdJQzh2Y21VZ1lXUmtJR0ZqZEdsMlpTQmpiR0Z6Y3lCMGJ5Qm1hWEp6ZENCY0ltUmxabUYxYkhSY0lpQnZjSFJwYjI1Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZiblZ0WW1WeUlISmhibWRsSUMwZ01pQnVkVzFpWlhJZ2FXNXdkWFFnWm1sbGJHUnpYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR1pwWld4a0xtWnBibVFvWENKcGJuQjFkRnQwZVhCbFBTZHVkVzFpWlhJblhWd2lLUzVsWVdOb0tHWjFibU4wYVc5dUtHbHVaR1Y0S1h0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pIUm9hWE5KYm5CMWRDQTlJQ1FvZEdocGN5azdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KSFJvYVhOSmJuQjFkQzV3WVhKbGJuUW9LUzV3WVhKbGJuUW9LUzVvWVhORGJHRnpjeWhjSW5ObUxXMWxkR0V0Y21GdVoyVmNJaWtwSUh0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9hVzVrWlhnOVBUQXBJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjMGx1Y0hWMExuWmhiQ2drZEdocGMwbHVjSFYwTG1GMGRISW9YQ0p0YVc1Y0lpa3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCcFppaHBibVJsZUQwOU1Ta2dlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpTVzV3ZFhRdWRtRnNLQ1IwYUdselNXNXdkWFF1WVhSMGNpaGNJbTFoZUZ3aUtTazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2YldWMFlTQXZJRzUxYldKbGNuTWdkMmwwYUNBeUlHbHVjSFYwY3lBb1puSnZiU0F2SUhSdklHWnBaV3hrY3lrZ0xTQnpaV052Ym1RZ2FXNXdkWFFnYlhWemRDQmlaU0J5WlhObGRDQjBieUJ0WVhnZ2RtRnNkV1ZjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHMWxkR0ZmYzJWc1pXTjBYMlp5YjIxZmRHOGdQU0FrWm1sbGJHUXVabWx1WkNoY0lpNXpaaTF0WlhSaExYSmhibWRsTFhObGJHVmpkQzFtY205dGRHOWNJaWs3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tiV1YwWVY5elpXeGxZM1JmWm5KdmJWOTBieTVzWlc1bmRHZytNQ2tnZTF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCemRHRnlkRjl0YVc0Z1BTQWtiV1YwWVY5elpXeGxZM1JmWm5KdmJWOTBieTVoZEhSeUtGd2laR0YwWVMxdGFXNWNJaWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6ZEdGeWRGOXRZWGdnUFNBa2JXVjBZVjl6Wld4bFkzUmZabkp2YlY5MGJ5NWhkSFJ5S0Z3aVpHRjBZUzF0WVhoY0lpazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHMWxkR0ZmYzJWc1pXTjBYMlp5YjIxZmRHOHVabWx1WkNoY0luTmxiR1ZqZEZ3aUtTNWxZV05vS0daMWJtTjBhVzl1S0dsdVpHVjRLWHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUjBhR2x6U1c1d2RYUWdQU0FrS0hSb2FYTXBPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlocGJtUmxlRDA5TUNrZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdselNXNXdkWFF1ZG1Gc0tITjBZWEowWDIxcGJpazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtHbHVaR1Y0UFQweEtTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTkpibkIxZEM1MllXd29jM1JoY25SZmJXRjRLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKRzFsZEdGZmNtRmthVzlmWm5KdmJWOTBieUE5SUNSbWFXVnNaQzVtYVc1a0tGd2lMbk5tTFcxbGRHRXRjbUZ1WjJVdGNtRmthVzh0Wm5KdmJYUnZYQ0lwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KRzFsZEdGZmNtRmthVzlmWm5KdmJWOTBieTVzWlc1bmRHZytNQ2xjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6ZEdGeWRGOXRhVzRnUFNBa2JXVjBZVjl5WVdScGIxOW1jbTl0WDNSdkxtRjBkSElvWENKa1lYUmhMVzFwYmx3aUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITjBZWEowWDIxaGVDQTlJQ1J0WlhSaFgzSmhaR2x2WDJaeWIyMWZkRzh1WVhSMGNpaGNJbVJoZEdFdGJXRjRYQ0lwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2NtRmthVzlmWjNKdmRYQnpJRDBnSkcxbGRHRmZjbUZrYVc5ZlpuSnZiVjkwYnk1bWFXNWtLQ2N1YzJZdGFXNXdkWFF0Y21GdVoyVXRjbUZrYVc4bktUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2NtRmthVzlmWjNKdmRYQnpMbVZoWTJnb1puVnVZM1JwYjI0b2FXNWtaWGdwZTF4dVhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrY21Ga2FXOXpJRDBnSkNoMGFHbHpLUzVtYVc1a0tGd2lMbk5tTFdsdWNIVjBMWEpoWkdsdlhDSXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSEpoWkdsdmN5NXdjbTl3S0Z3aVkyaGxZMnRsWkZ3aUxDQm1ZV3h6WlNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LR2x1WkdWNFBUMHdLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSeVlXUnBiM011Wm1sc2RHVnlLQ2RiZG1Gc2RXVTlYQ0luSzNOMFlYSjBYMjFwYmlzblhDSmRKeWt1Y0hKdmNDaGNJbU5vWldOclpXUmNJaXdnZEhKMVpTazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtHbHVaR1Y0UFQweEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1J5WVdScGIzTXVabWxzZEdWeUtDZGJkbUZzZFdVOVhDSW5LM04wWVhKMFgyMWhlQ3NuWENKZEp5a3VjSEp2Y0NoY0ltTm9aV05yWldSY0lpd2dkSEoxWlNrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lGeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZiblZ0WW1WeUlITnNhV1JsY2lBdElHNXZWV2xUYkdsa1pYSmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRdVptbHVaQ2hjSWk1dFpYUmhMWE5zYVdSbGNsd2lLUzVsWVdOb0tHWjFibU4wYVc5dUtHbHVaR1Y0S1h0Y2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MyeHBaR1Z5WDI5aWFtVmpkQ0E5SUNRb2RHaHBjeWxiTUYwN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzhxZG1GeUlITnNhV1JsY2w5dlltcGxZM1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENJdWJXVjBZUzF6Ykdsa1pYSmNJaWxiTUYwN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MyeHBaR1Z5WDNaaGJDQTlJSE5zYVdSbGNsOXZZbXBsWTNRdWJtOVZhVk5zYVdSbGNpNW5aWFFvS1RzcUwxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtjMnhwWkdWeVgyVnNJRDBnSkNoMGFHbHpLUzVqYkc5elpYTjBLRndpTG5ObUxXMWxkR0V0Y21GdVoyVXRjMnhwWkdWeVhDSXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiV2x1Vm1Gc0lEMGdKSE5zYVdSbGNsOWxiQzVoZEhSeUtGd2laR0YwWVMxdGFXNHRabTl5YldGMGRHVmtYQ0lwTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYldGNFZtRnNJRDBnSkhOc2FXUmxjbDlsYkM1aGRIUnlLRndpWkdGMFlTMXRZWGd0Wm05eWJXRjBkR1ZrWENJcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSXVjMlYwS0Z0dGFXNVdZV3dzSUcxaGVGWmhiRjBwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDI1bFpXUWdkRzhnYzJWbElHbG1JR0Z1ZVNCaGNtVWdZMjl0WW05aWIzZ2dZVzVrSUdGamRDQmhZMk52Y21ScGJtZHNlVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1kyOXRZbTlpYjNnZ1BTQWtabWxsYkdRdVptbHVaQ2hjSW5ObGJHVmpkRnRrWVhSaExXTnZiV0p2WW05NFBTY3hKMTFjSWlrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KR052YldKdlltOTRMbXhsYm1kMGFENHdLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLSFI1Y0dWdlppQWtZMjl0WW05aWIzZ3VZMmh2YzJWdUlDRTlJRndpZFc1a1pXWnBibVZrWENJcFhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JqYjIxaWIySnZlQzUwY21sbloyVnlLRndpWTJodmMyVnVPblZ3WkdGMFpXUmNJaWs3SUM4dlptOXlJR05vYjNObGJpQnZibXg1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWTI5dFltOWliM2d1ZG1Gc0tDY25LVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JqYjIxaWIySnZlQzUwY21sbloyVnlLQ2RqYUdGdVoyVXVjMlZzWldOME1pY3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVqYkdWaGNsUnBiV1Z5S0NrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITjFZbTFwZEY5bWIzSnRQVDFjSW1Gc2QyRjVjMXdpS1Z4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWMzVmliV2wwUm05eWJTZ3BPMXh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpTQnBaaWh6ZFdKdGFYUmZabTl5YlQwOVhDSnVaWFpsY2x3aUtWeHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIUm9hWE11WVhWMGIxOWpiM1Z1ZEY5eVpXWnlaWE5vWDIxdlpHVTlQVEVwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1admNtMVZjR1JoZEdWa1JtVjBZMmhCYW1GNEtDazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpTQnBaaWh6ZFdKdGFYUmZabTl5YlQwOVhDSmhkWFJ2WENJcFhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RHaHBjeTVoZFhSdlgzVndaR0YwWlQwOWRISjFaU2xjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YzNWaWJXbDBSbTl5YlNncE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWgwYUdsekxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsUFQweEtWeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtWnZjbTFWY0dSaGRHVmtSbVYwWTJoQmFtRjRLQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhHNWNiaUFnSUNBZ0lDQWdmVHRjYmx4dUlDQWdJQ0FnSUNCMGFHbHpMbWx1YVhRb0tUdGNibHh1SUNBZ0lDQWdJQ0IyWVhJZ1pYWmxiblJmWkdGMFlTQTlJSHQ5TzF4dUlDQWdJQ0FnSUNCbGRtVnVkRjlrWVhSaExuTm1hV1FnUFNCelpXeG1Mbk5tYVdRN1hHNGdJQ0FnSUNBZ0lHVjJaVzUwWDJSaGRHRXVkR0Z5WjJWMFUyVnNaV04wYjNJZ1BTQnpaV3htTG1GcVlYaGZkR0Z5WjJWMFgyRjBkSEk3WEc0Z0lDQWdJQ0FnSUdWMlpXNTBYMlJoZEdFdWIySnFaV04wSUQwZ2RHaHBjenRjYmlBZ0lDQWdJQ0FnYVdZb2IzQjBjeTVwYzBsdWFYUXBYRzRnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZEhKcFoyZGxja1YyWlc1MEtGd2ljMlk2YVc1cGRGd2lMQ0JsZG1WdWRGOWtZWFJoS1R0Y2JpQWdJQ0FnSUNBZ2ZWeHVYRzRnSUNBZ2ZTazdYRzU5TzF4dUlsMTkiLCIoZnVuY3Rpb24gKGdsb2JhbCl7XG5cbnZhciAkID0gKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKTtcblxubW9kdWxlLmV4cG9ydHMgPSB7XG5cblx0dGF4b25vbXlfYXJjaGl2ZXM6IDAsXG4gICAgdXJsX3BhcmFtczoge30sXG4gICAgdGF4X2FyY2hpdmVfcmVzdWx0c191cmw6IFwiXCIsXG4gICAgYWN0aXZlX3RheDogXCJcIixcbiAgICBmaWVsZHM6IHt9LFxuXHRpbml0OiBmdW5jdGlvbih0YXhvbm9teV9hcmNoaXZlcywgY3VycmVudF90YXhvbm9teV9hcmNoaXZlKXtcblxuICAgICAgICB0aGlzLnRheG9ub215X2FyY2hpdmVzID0gMDtcbiAgICAgICAgdGhpcy51cmxfcGFyYW1zID0ge307XG4gICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSBcIlwiO1xuICAgICAgICB0aGlzLmFjdGl2ZV90YXggPSBcIlwiO1xuXG5cdFx0Ly90aGlzLiRmaWVsZHMgPSAkZmllbGRzO1xuICAgICAgICB0aGlzLnRheG9ub215X2FyY2hpdmVzID0gdGF4b25vbXlfYXJjaGl2ZXM7XG4gICAgICAgIHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlID0gY3VycmVudF90YXhvbm9teV9hcmNoaXZlO1xuXG5cdFx0dGhpcy5jbGVhclVybENvbXBvbmVudHMoKTtcblxuXHR9LFxuICAgIHNldFRheEFyY2hpdmVSZXN1bHRzVXJsOiBmdW5jdGlvbigkZm9ybSwgY3VycmVudF9yZXN1bHRzX3VybCwgZ2V0X2FjdGl2ZSkge1xuXG4gICAgICAgIHZhciBzZWxmID0gdGhpcztcblx0XHR0aGlzLmNsZWFyVGF4QXJjaGl2ZVJlc3VsdHNVcmwoKTtcbiAgICAgICAgLy92YXIgY3VycmVudF9yZXN1bHRzX3VybCA9IFwiXCI7XG4gICAgICAgIGlmKHRoaXMudGF4b25vbXlfYXJjaGl2ZXMhPTEpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKHR5cGVvZihnZXRfYWN0aXZlKT09XCJ1bmRlZmluZWRcIilcblx0XHR7XG5cdFx0XHR2YXIgZ2V0X2FjdGl2ZSA9IGZhbHNlO1xuXHRcdH1cblxuICAgICAgICAvL2NoZWNrIHRvIHNlZSBpZiB3ZSBoYXZlIGFueSB0YXhvbm9taWVzIHNlbGVjdGVkXG4gICAgICAgIC8vaWYgc28sIGNoZWNrIHRoZWlyIHJld3JpdGVzIGFuZCB1c2UgdGhvc2UgYXMgdGhlIHJlc3VsdHMgdXJsXG4gICAgICAgIHZhciAkZmllbGQgPSBmYWxzZTtcbiAgICAgICAgdmFyIGZpZWxkX25hbWUgPSBcIlwiO1xuICAgICAgICB2YXIgZmllbGRfdmFsdWUgPSBcIlwiO1xuXG4gICAgICAgIHZhciAkYWN0aXZlX3RheG9ub215ID0gJGZvcm0uJGZpZWxkcy5wYXJlbnQoKS5maW5kKFwiW2RhdGEtc2YtdGF4b25vbXktYXJjaGl2ZT0nMSddXCIpO1xuICAgICAgICBpZigkYWN0aXZlX3RheG9ub215Lmxlbmd0aD09MSlcbiAgICAgICAge1xuICAgICAgICAgICAgJGZpZWxkID0gJGFjdGl2ZV90YXhvbm9teTtcblxuICAgICAgICAgICAgdmFyIGZpZWxkVHlwZSA9ICRmaWVsZC5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xuXG4gICAgICAgICAgICBpZiAoKGZpZWxkVHlwZSA9PSBcInRhZ1wiKSB8fCAoZmllbGRUeXBlID09IFwiY2F0ZWdvcnlcIikgfHwgKGZpZWxkVHlwZSA9PSBcInRheG9ub215XCIpKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRheG9ub215X3ZhbHVlID0gc2VsZi5wcm9jZXNzVGF4b25vbXkoJGZpZWxkLCB0cnVlKTtcbiAgICAgICAgICAgICAgICBmaWVsZF9uYW1lID0gJGZpZWxkLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XG4gICAgICAgICAgICAgICAgdmFyIHRheG9ub215X25hbWUgPSBmaWVsZF9uYW1lLnJlcGxhY2UoXCJfc2Z0X1wiLCBcIlwiKTtcblxuICAgICAgICAgICAgICAgIGlmICh0YXhvbm9teV92YWx1ZSkge1xuICAgICAgICAgICAgICAgICAgICBmaWVsZF92YWx1ZSA9IHRheG9ub215X3ZhbHVlLnZhbHVlO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYoZmllbGRfdmFsdWU9PVwiXCIpXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgJGZpZWxkID0gZmFsc2U7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICBpZigoc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUhPVwiXCIpJiYoc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUhPXRheG9ub215X25hbWUpKVxuICAgICAgICB7XG5cbiAgICAgICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSBjdXJyZW50X3Jlc3VsdHNfdXJsO1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYoKChmaWVsZF92YWx1ZT09XCJcIil8fCghJGZpZWxkKSApKVxuICAgICAgICB7XG4gICAgICAgICAgICAkZm9ybS4kZmllbGRzLmVhY2goZnVuY3Rpb24gKCkge1xuXG4gICAgICAgICAgICAgICAgaWYgKCEkZmllbGQpIHtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRUeXBlID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xuXG4gICAgICAgICAgICAgICAgICAgIGlmICgoZmllbGRUeXBlID09IFwidGFnXCIpIHx8IChmaWVsZFR5cGUgPT0gXCJjYXRlZ29yeVwiKSB8fCAoZmllbGRUeXBlID09IFwidGF4b25vbXlcIikpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB0YXhvbm9teV92YWx1ZSA9IHNlbGYucHJvY2Vzc1RheG9ub215KCQodGhpcyksIHRydWUpO1xuICAgICAgICAgICAgICAgICAgICAgICAgZmllbGRfbmFtZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHRheG9ub215X3ZhbHVlKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaWVsZF92YWx1ZSA9IHRheG9ub215X3ZhbHVlLnZhbHVlO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGZpZWxkX3ZhbHVlICE9IFwiXCIpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZmllbGQgPSAkKHRoaXMpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cblxuICAgICAgICBpZiggKCRmaWVsZCkgJiYgKGZpZWxkX3ZhbHVlICE9IFwiXCIgKSkge1xuICAgICAgICAgICAgLy9pZiB3ZSBmb3VuZCBhIGZpZWxkXG5cdFx0XHR2YXIgcmV3cml0ZV9hdHRyID0gKCRmaWVsZC5hdHRyKFwiZGF0YS1zZi10ZXJtLXJld3JpdGVcIikpO1xuXG4gICAgICAgICAgICBpZihyZXdyaXRlX2F0dHIhPVwiXCIpIHtcblxuICAgICAgICAgICAgICAgIHZhciByZXdyaXRlID0gSlNPTi5wYXJzZShyZXdyaXRlX2F0dHIpO1xuICAgICAgICAgICAgICAgIHZhciBpbnB1dF90eXBlID0gJGZpZWxkLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XG4gICAgICAgICAgICAgICAgc2VsZi5hY3RpdmVfdGF4ID0gZmllbGRfbmFtZTtcblxuICAgICAgICAgICAgICAgIC8vZmluZCB0aGUgYWN0aXZlIGVsZW1lbnRcbiAgICAgICAgICAgICAgICBpZiAoKGlucHV0X3R5cGUgPT0gXCJyYWRpb1wiKSB8fCAoaW5wdXRfdHlwZSA9PSBcImNoZWNrYm94XCIpKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgLy92YXIgJGFjdGl2ZSA9ICRmaWVsZC5maW5kKFwiLnNmLW9wdGlvbi1hY3RpdmVcIik7XG4gICAgICAgICAgICAgICAgICAgIC8vZXhwbG9kZSB0aGUgdmFsdWVzIGlmIHRoZXJlIGlzIGEgZGVsaW1cbiAgICAgICAgICAgICAgICAgICAgLy9maWVsZF92YWx1ZVxuXG4gICAgICAgICAgICAgICAgICAgIHZhciBpc19zaW5nbGVfdmFsdWUgPSB0cnVlO1xuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRfdmFsdWVzID0gZmllbGRfdmFsdWUuc3BsaXQoXCIsXCIpLmpvaW4oXCIrXCIpLnNwbGl0KFwiK1wiKTtcbiAgICAgICAgICAgICAgICAgICAgaWYgKGZpZWxkX3ZhbHVlcy5sZW5ndGggPiAxKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBpc19zaW5nbGVfdmFsdWUgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIGlmIChpc19zaW5nbGVfdmFsdWUpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRpbnB1dCA9ICRmaWVsZC5maW5kKFwiaW5wdXRbdmFsdWU9J1wiICsgZmllbGRfdmFsdWUgKyBcIiddXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkaW5wdXQucGFyZW50KCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGggPSAkYWN0aXZlLmF0dHIoXCJkYXRhLXNmLWRlcHRoXCIpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAvL25vdyBsb29wIHRocm91Z2ggcGFyZW50cyB0byBncmFiIHRoZWlyIG5hbWVzXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWVzID0gbmV3IEFycmF5KCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaChmaWVsZF92YWx1ZSk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGZvciAodmFyIGkgPSBkZXB0aDsgaSA+IDA7IGktLSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRhY3RpdmUgPSAkYWN0aXZlLnBhcmVudCgpLnBhcmVudCgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKCRhY3RpdmUuZmluZChcImlucHV0XCIpLnZhbCgpKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnJldmVyc2UoKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9ncmFiIHRoZSByZXdyaXRlIGZvciB0aGlzIGRlcHRoXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgYWN0aXZlX3Jld3JpdGUgPSByZXdyaXRlW2RlcHRoXTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB1cmwgPSBhY3RpdmVfcmV3cml0ZTtcblxuXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3RoZW4gbWFwIGZyb20gdGhlIHBhcmVudHMgdG8gdGhlIGRlcHRoXG4gICAgICAgICAgICAgICAgICAgICAgICAkKHZhbHVlcykuZWFjaChmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB1cmwgPSB1cmwucmVwbGFjZShcIltcIiArIGluZGV4ICsgXCJdXCIsIHZhbHVlKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gdXJsO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2lmIHRoZXJlIGFyZSBtdWx0aXBsZSB2YWx1ZXMsXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3RoZW4gd2UgbmVlZCB0byBjaGVjayBmb3IgMyB0aGluZ3M6XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaWYgdGhlIHZhbHVlcyBzZWxlY3RlZCBhcmUgYWxsIGluIHRoZSBzYW1lIHRyZWUgdGhlbiB3ZSBjYW4gZG8gc29tZSBjbGV2ZXIgcmV3cml0ZSBzdHVmZlxuICAgICAgICAgICAgICAgICAgICAgICAgLy9tZXJnZSBhbGwgdmFsdWVzIGluIHNhbWUgbGV2ZWwsIHRoZW4gY29tYmluZSB0aGUgbGV2ZWxzXG5cbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaWYgdGhleSBhcmUgZnJvbSBkaWZmZXJlbnQgdHJlZXMgdGhlbiBqdXN0IGNvbWJpbmUgdGhlbSBvciBqdXN0IHVzZSBgZmllbGRfdmFsdWVgXG4gICAgICAgICAgICAgICAgICAgICAgICAvKlxuXG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRlcHRocyA9IG5ldyBBcnJheSgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICQoZmllbGRfdmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gJGZpZWxkLmZpbmQoXCJpbnB1dFt2YWx1ZT0nXCIgKyBmaWVsZF92YWx1ZSArIFwiJ11cIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkaW5wdXQucGFyZW50KCk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGggPSAkYWN0aXZlLmF0dHIoXCJkYXRhLXNmLWRlcHRoXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgIC8vZGVwdGhzLnB1c2goZGVwdGgpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgfSk7Ki9cblxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2UgaWYgKChpbnB1dF90eXBlID09IFwic2VsZWN0XCIpIHx8IChpbnB1dF90eXBlID09IFwibXVsdGlzZWxlY3RcIikpIHtcblxuICAgICAgICAgICAgICAgICAgICB2YXIgaXNfc2luZ2xlX3ZhbHVlID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX3ZhbHVlcyA9IGZpZWxkX3ZhbHVlLnNwbGl0KFwiLFwiKS5qb2luKFwiK1wiKS5zcGxpdChcIitcIik7XG4gICAgICAgICAgICAgICAgICAgIGlmIChmaWVsZF92YWx1ZXMubGVuZ3RoID4gMSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgaXNfc2luZ2xlX3ZhbHVlID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBpZiAoaXNfc2luZ2xlX3ZhbHVlKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlID0gJGZpZWxkLmZpbmQoXCJvcHRpb25bdmFsdWU9J1wiICsgZmllbGRfdmFsdWUgKyBcIiddXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRlcHRoID0gJGFjdGl2ZS5hdHRyKFwiZGF0YS1zZi1kZXB0aFwiKTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHZhbHVlcyA9IG5ldyBBcnJheSgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goZmllbGRfdmFsdWUpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICBmb3IgKHZhciBpID0gZGVwdGg7IGkgPiAwOyBpLS0pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkYWN0aXZlID0gJGFjdGl2ZS5wcmV2QWxsKFwib3B0aW9uW2RhdGEtc2YtZGVwdGg9J1wiICsgKGkgLSAxKSArIFwiJ11cIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goJGFjdGl2ZS52YWwoKSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5yZXZlcnNlKCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgYWN0aXZlX3Jld3JpdGUgPSByZXdyaXRlW2RlcHRoXTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB1cmwgPSBhY3RpdmVfcmV3cml0ZTtcbiAgICAgICAgICAgICAgICAgICAgICAgICQodmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybCA9IHVybC5yZXBsYWNlKFwiW1wiICsgaW5kZXggKyBcIl1cIiwgdmFsdWUpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSB1cmw7XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICB9XG4gICAgICAgIC8vdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IGN1cnJlbnRfcmVzdWx0c191cmw7XG4gICAgfSxcbiAgICBnZXRSZXN1bHRzVXJsOiBmdW5jdGlvbigkZm9ybSwgY3VycmVudF9yZXN1bHRzX3VybCkge1xuXG4gICAgICAgIC8vdGhpcy5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybCgkZm9ybSwgY3VycmVudF9yZXN1bHRzX3VybCk7XG5cbiAgICAgICAgaWYodGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybD09XCJcIilcbiAgICAgICAge1xuICAgICAgICAgICAgcmV0dXJuIGN1cnJlbnRfcmVzdWx0c191cmw7XG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybDtcbiAgICB9LFxuXHRnZXRVcmxQYXJhbXM6IGZ1bmN0aW9uKCRmb3JtKXtcblxuXHRcdHRoaXMuYnVpbGRVcmxDb21wb25lbnRzKCRmb3JtLCB0cnVlKTtcblxuICAgICAgICBpZih0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsIT1cIlwiKVxuICAgICAgICB7XG5cbiAgICAgICAgICAgIGlmKHRoaXMuYWN0aXZlX3RheCE9XCJcIilcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICB2YXIgZmllbGRfbmFtZSA9IHRoaXMuYWN0aXZlX3RheDtcblxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLnVybF9wYXJhbXNbZmllbGRfbmFtZV0pIT1cInVuZGVmaW5lZFwiKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgZGVsZXRlIHRoaXMudXJsX3BhcmFtc1tmaWVsZF9uYW1lXTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cblxuXHRcdHJldHVybiB0aGlzLnVybF9wYXJhbXM7XG5cdH0sXG5cdGNsZWFyVXJsQ29tcG9uZW50czogZnVuY3Rpb24oKXtcblx0XHQvL3RoaXMudXJsX2NvbXBvbmVudHMgPSBcIlwiO1xuXHRcdHRoaXMudXJsX3BhcmFtcyA9IHt9O1xuXHR9LFxuXHRjbGVhclRheEFyY2hpdmVSZXN1bHRzVXJsOiBmdW5jdGlvbigpIHtcblx0XHR0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gJyc7XG5cdH0sXG5cdGRpc2FibGVJbnB1dHM6IGZ1bmN0aW9uKCRmb3JtKXtcblx0XHR2YXIgc2VsZiA9IHRoaXM7XG5cdFx0XG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XG5cdFx0XHRcblx0XHRcdHZhciAkaW5wdXRzID0gJCh0aGlzKS5maW5kKFwiaW5wdXQsIHNlbGVjdCwgLm1ldGEtc2xpZGVyXCIpO1xuXHRcdFx0JGlucHV0cy5hdHRyKFwiZGlzYWJsZWRcIiwgXCJkaXNhYmxlZFwiKTtcblx0XHRcdCRpbnB1dHMuYXR0cihcImRpc2FibGVkXCIsIHRydWUpO1xuXHRcdFx0JGlucHV0cy5wcm9wKFwiZGlzYWJsZWRcIiwgdHJ1ZSk7XG5cdFx0XHQkaW5wdXRzLnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTtcblx0XHRcdFxuXHRcdH0pO1xuXHRcdFxuXHRcdFxuXHR9LFxuXHRlbmFibGVJbnB1dHM6IGZ1bmN0aW9uKCRmb3JtKXtcblx0XHR2YXIgc2VsZiA9IHRoaXM7XG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XG5cdFx0XHR2YXIgJGlucHV0cyA9ICQodGhpcykuZmluZChcImlucHV0LCBzZWxlY3QsIC5tZXRhLXNsaWRlclwiKTtcblx0XHRcdCRpbnB1dHMucHJvcChcImRpc2FibGVkXCIsIGZhbHNlKTtcblx0XHRcdCRpbnB1dHMuYXR0cihcImRpc2FibGVkXCIsIGZhbHNlKTtcblx0XHRcdCRpbnB1dHMudHJpZ2dlcihcImNob3Nlbjp1cGRhdGVkXCIpO1x0XHRcdFxuXHRcdH0pO1xuXHRcdFxuXHRcdFxuXHR9LFxuXHRidWlsZFVybENvbXBvbmVudHM6IGZ1bmN0aW9uKCRmb3JtLCBjbGVhcl9jb21wb25lbnRzKXtcblx0XHRcblx0XHR2YXIgc2VsZiA9IHRoaXM7XG5cdFx0XG5cdFx0aWYodHlwZW9mKGNsZWFyX2NvbXBvbmVudHMpIT1cInVuZGVmaW5lZFwiKVxuXHRcdHtcblx0XHRcdGlmKGNsZWFyX2NvbXBvbmVudHM9PXRydWUpXG5cdFx0XHR7XG5cdFx0XHRcdHRoaXMuY2xlYXJVcmxDb21wb25lbnRzKCk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdFxuXHRcdCRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xuXHRcdFx0XG5cdFx0XHR2YXIgZmllbGROYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xuXHRcdFx0dmFyIGZpZWxkVHlwZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcblx0XHRcdFxuXHRcdFx0aWYoZmllbGRUeXBlPT1cInNlYXJjaFwiKVxuXHRcdFx0e1xuXHRcdFx0XHRzZWxmLnByb2Nlc3NTZWFyY2hGaWVsZCgkKHRoaXMpKTtcblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoKGZpZWxkVHlwZT09XCJ0YWdcIil8fChmaWVsZFR5cGU9PVwiY2F0ZWdvcnlcIil8fChmaWVsZFR5cGU9PVwidGF4b25vbXlcIikpXG5cdFx0XHR7XG5cdFx0XHRcdHNlbGYucHJvY2Vzc1RheG9ub215KCQodGhpcykpO1xuXHRcdFx0fVxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwic29ydF9vcmRlclwiKVxuXHRcdFx0e1xuXHRcdFx0XHRzZWxmLnByb2Nlc3NTb3J0T3JkZXJGaWVsZCgkKHRoaXMpKTtcblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInBvc3RzX3Blcl9wYWdlXCIpXG5cdFx0XHR7XG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Jlc3VsdHNQZXJQYWdlRmllbGQoJCh0aGlzKSk7XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJhdXRob3JcIilcblx0XHRcdHtcblx0XHRcdFx0c2VsZi5wcm9jZXNzQXV0aG9yKCQodGhpcykpO1xuXHRcdFx0fVxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdF90eXBlXCIpXG5cdFx0XHR7XG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Bvc3RUeXBlKCQodGhpcykpO1xuXHRcdFx0fVxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdF9kYXRlXCIpXG5cdFx0XHR7XG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Bvc3REYXRlKCQodGhpcykpO1xuXHRcdFx0fVxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdF9tZXRhXCIpXG5cdFx0XHR7XG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Bvc3RNZXRhKCQodGhpcykpO1xuXHRcdFx0XHRcblx0XHRcdH1cblx0XHRcdGVsc2Vcblx0XHRcdHtcblx0XHRcdFx0XG5cdFx0XHR9XG5cdFx0XHRcblx0XHR9KTtcblx0XHRcblx0fSxcblx0cHJvY2Vzc1NlYXJjaEZpZWxkOiBmdW5jdGlvbigkY29udGFpbmVyKVxuXHR7XG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xuXHRcdFxuXHRcdHZhciAkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJpbnB1dFtuYW1lXj0nX3NmX3NlYXJjaCddXCIpO1xuXHRcdFxuXHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcblx0XHR7XG5cdFx0XHR2YXIgZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLnZhbCgpO1xuXHRcdFx0XG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcblx0XHRcdHtcblx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJl9zZl9zPVwiK2VuY29kZVVSSUNvbXBvbmVudChmaWVsZFZhbCk7XG5cdFx0XHRcdHNlbGYudXJsX3BhcmFtc1snX3NmX3MnXSA9IGVuY29kZVVSSUNvbXBvbmVudChmaWVsZFZhbCk7XG5cdFx0XHR9XG5cdFx0fVxuXHR9LFxuXHRwcm9jZXNzU29ydE9yZGVyRmllbGQ6IGZ1bmN0aW9uKCRjb250YWluZXIpXG5cdHtcblx0XHR0aGlzLnByb2Nlc3NBdXRob3IoJGNvbnRhaW5lcik7XG5cdFx0XG5cdH0sXG5cdHByb2Nlc3NSZXN1bHRzUGVyUGFnZUZpZWxkOiBmdW5jdGlvbigkY29udGFpbmVyKVxuXHR7XG5cdFx0dGhpcy5wcm9jZXNzQXV0aG9yKCRjb250YWluZXIpO1xuXHRcdFxuXHR9LFxuXHRnZXRBY3RpdmVUYXg6IGZ1bmN0aW9uKCRmaWVsZCkge1xuXHRcdHJldHVybiB0aGlzLmFjdGl2ZV90YXg7XG5cdH0sXG5cdGdldFNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkKXtcblxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XG5cdFx0XG5cdFx0aWYoJGZpZWxkLnZhbCgpIT0wKVxuXHRcdHtcblx0XHRcdGZpZWxkVmFsID0gJGZpZWxkLnZhbCgpO1xuXHRcdH1cblx0XHRcblx0XHRpZihmaWVsZFZhbD09bnVsbClcblx0XHR7XG5cdFx0XHRmaWVsZFZhbCA9IFwiXCI7XG5cdFx0fVxuXHRcdFxuXHRcdHJldHVybiBmaWVsZFZhbDtcblx0fSxcblx0Z2V0TWV0YVNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkKXtcblx0XHRcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xuXHRcdFxuXHRcdGZpZWxkVmFsID0gJGZpZWxkLnZhbCgpO1xuXHRcdFx0XHRcdFx0XG5cdFx0aWYoZmllbGRWYWw9PW51bGwpXG5cdFx0e1xuXHRcdFx0ZmllbGRWYWwgPSBcIlwiO1xuXHRcdH1cblx0XHRcblx0XHRyZXR1cm4gZmllbGRWYWw7XG5cdH0sXG5cdGdldE11bHRpU2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQsIG9wZXJhdG9yKXtcblx0XHRcblx0XHR2YXIgZGVsaW0gPSBcIitcIjtcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxuXHRcdHtcblx0XHRcdGRlbGltID0gXCIsXCI7XG5cdFx0fVxuXHRcdFxuXHRcdGlmKHR5cGVvZigkZmllbGQudmFsKCkpPT1cIm9iamVjdFwiKVxuXHRcdHtcblx0XHRcdGlmKCRmaWVsZC52YWwoKSE9bnVsbClcblx0XHRcdHtcblx0XHRcdFx0cmV0dXJuICRmaWVsZC52YWwoKS5qb2luKGRlbGltKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0XG5cdH0sXG5cdGdldE1ldGFNdWx0aVNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XG5cdFx0XG5cdFx0dmFyIGRlbGltID0gXCItKy1cIjtcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxuXHRcdHtcblx0XHRcdGRlbGltID0gXCItLC1cIjtcblx0XHR9XG5cdFx0XHRcdFxuXHRcdGlmKHR5cGVvZigkZmllbGQudmFsKCkpPT1cIm9iamVjdFwiKVxuXHRcdHtcblx0XHRcdGlmKCRmaWVsZC52YWwoKSE9bnVsbClcblx0XHRcdHtcblx0XHRcdFx0XG5cdFx0XHRcdHZhciBmaWVsZHZhbCA9IFtdO1xuXHRcdFx0XHRcblx0XHRcdFx0JCgkZmllbGQudmFsKCkpLmVhY2goZnVuY3Rpb24oaW5kZXgsdmFsdWUpe1xuXHRcdFx0XHRcdFxuXHRcdFx0XHRcdGZpZWxkdmFsLnB1c2goKHZhbHVlKSk7XG5cdFx0XHRcdH0pO1xuXHRcdFx0XHRcblx0XHRcdFx0cmV0dXJuIGZpZWxkdmFsLmpvaW4oZGVsaW0pO1xuXHRcdFx0fVxuXHRcdH1cblx0XHRcblx0XHRyZXR1cm4gXCJcIjtcblx0XHRcblx0fSxcblx0Z2V0Q2hlY2tib3hWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xuXHRcdFxuXHRcdFxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKXtcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXG5cdFx0XHR7XG5cdFx0XHRcdHJldHVybiAkKHRoaXMpLnZhbCgpO1xuXHRcdFx0fVxuXHRcdH0pLmdldCgpO1xuXHRcdFxuXHRcdHZhciBkZWxpbSA9IFwiK1wiO1xuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXG5cdFx0e1xuXHRcdFx0ZGVsaW0gPSBcIixcIjtcblx0XHR9XG5cdFx0XG5cdFx0cmV0dXJuIGZpZWxkVmFsLmpvaW4oZGVsaW0pO1xuXHR9LFxuXHRnZXRNZXRhQ2hlY2tib3hWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xuXHRcdFxuXHRcdFxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKXtcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXG5cdFx0XHR7XG5cdFx0XHRcdHJldHVybiAoJCh0aGlzKS52YWwoKSk7XG5cdFx0XHR9XG5cdFx0fSkuZ2V0KCk7XG5cdFx0XG5cdFx0dmFyIGRlbGltID0gXCItKy1cIjtcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxuXHRcdHtcblx0XHRcdGRlbGltID0gXCItLC1cIjtcblx0XHR9XG5cdFx0XG5cdFx0cmV0dXJuIGZpZWxkVmFsLmpvaW4oZGVsaW0pO1xuXHR9LFxuXHRnZXRSYWRpb1ZhbDogZnVuY3Rpb24oJGZpZWxkKXtcblx0XHRcdFx0XHRcdFx0XG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpXG5cdFx0e1xuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcblx0XHRcdHtcblx0XHRcdFx0cmV0dXJuICQodGhpcykudmFsKCk7XG5cdFx0XHR9XG5cdFx0XHRcblx0XHR9KS5nZXQoKTtcblx0XHRcblx0XHRcblx0XHRpZihmaWVsZFZhbFswXSE9MClcblx0XHR7XG5cdFx0XHRyZXR1cm4gZmllbGRWYWxbMF07XG5cdFx0fVxuXHR9LFxuXHRnZXRNZXRhUmFkaW9WYWw6IGZ1bmN0aW9uKCRmaWVsZCl7XG5cdFx0XHRcdFx0XHRcdFxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKVxuXHRcdHtcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXG5cdFx0XHR7XG5cdFx0XHRcdHJldHVybiAkKHRoaXMpLnZhbCgpO1xuXHRcdFx0fVxuXHRcdFx0XG5cdFx0fSkuZ2V0KCk7XG5cdFx0XG5cdFx0cmV0dXJuIGZpZWxkVmFsWzBdO1xuXHR9LFxuXHRwcm9jZXNzQXV0aG9yOiBmdW5jdGlvbigkY29udGFpbmVyKVxuXHR7XG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xuXHRcdFxuXHRcdFxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcblx0XHRcblx0XHR2YXIgJGZpZWxkO1xuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XG5cdFx0XG5cdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxuXHRcdHtcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcblx0XHRcdFxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFNlbGVjdFZhbCgkZmllbGQpOyBcblx0XHR9XG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwibXVsdGlzZWxlY3RcIilcblx0XHR7XG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XG5cdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHR2YXIgb3BlcmF0b3IgPSAkZmllbGQuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XG5cdFx0XHRcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNdWx0aVNlbGVjdFZhbCgkZmllbGQsIFwib3JcIik7XG5cdFx0XHRcblx0XHR9XG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwiY2hlY2tib3hcIilcblx0XHR7XG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xuXHRcdFx0XG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXG5cdFx0XHR7XG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcblx0XHRcdFx0XHRcdFx0XHRcdFx0XG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIikuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRDaGVja2JveFZhbCgkZmllbGQsIFwib3JcIik7XG5cdFx0XHR9XG5cdFx0XHRcblx0XHR9XG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFkaW9cIilcblx0XHR7XG5cdFx0XHRcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6cmFkaW9cIik7XG5cdFx0XHRcdFx0XHRcblx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcblx0XHRcdHtcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0XHRcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFJhZGlvVmFsKCRmaWVsZCk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdFxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXG5cdFx0e1xuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXG5cdFx0XHR7XG5cdFx0XHRcdHZhciBmaWVsZFNsdWcgPSBcIlwiO1xuXHRcdFx0XHRcblx0XHRcdFx0aWYoZmllbGROYW1lPT1cIl9zZl9hdXRob3JcIilcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwiYXV0aG9yc1wiO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGVsc2UgaWYoZmllbGROYW1lPT1cIl9zZl9zb3J0X29yZGVyXCIpXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcInNvcnRfb3JkZXJcIjtcblx0XHRcdFx0fVxuXHRcdFx0XHRlbHNlIGlmKGZpZWxkTmFtZT09XCJfc2ZfcHBwXCIpXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcIl9zZl9wcHBcIjtcblx0XHRcdFx0fVxuXHRcdFx0XHRlbHNlIGlmKGZpZWxkTmFtZT09XCJfc2ZfcG9zdF90eXBlXCIpXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcInBvc3RfdHlwZXNcIjtcblx0XHRcdFx0fVxuXHRcdFx0XHRlbHNlXG5cdFx0XHRcdHtcblx0XHRcdFx0XG5cdFx0XHRcdH1cblx0XHRcdFx0XG5cdFx0XHRcdGlmKGZpZWxkU2x1ZyE9XCJcIilcblx0XHRcdFx0e1xuXHRcdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZFNsdWcrXCI9XCIrZmllbGRWYWw7XG5cdFx0XHRcdFx0c2VsZi51cmxfcGFyYW1zW2ZpZWxkU2x1Z10gPSBmaWVsZFZhbDtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblx0XHRcblx0fSxcblx0cHJvY2Vzc1Bvc3RUeXBlIDogZnVuY3Rpb24oJHRoaXMpe1xuXHRcdFxuXHRcdHRoaXMucHJvY2Vzc0F1dGhvcigkdGhpcyk7XG5cdFx0XG5cdH0sXG5cdHByb2Nlc3NQb3N0TWV0YTogZnVuY3Rpb24oJGNvbnRhaW5lcilcblx0e1xuXHRcdHZhciBzZWxmID0gdGhpcztcblx0XHRcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xuXHRcdHZhciBpbnB1dFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XG5cdFx0dmFyIG1ldGFUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1tZXRhLXR5cGVcIik7XG5cblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xuXHRcdHZhciAkZmllbGQ7XG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XG5cdFx0XG5cdFx0aWYobWV0YVR5cGU9PVwibnVtYmVyXCIpXG5cdFx0e1xuXHRcdFx0aWYoaW5wdXRUeXBlPT1cInJhbmdlLW51bWJlclwiKVxuXHRcdFx0e1xuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1udW1iZXIgaW5wdXRcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHR2YXIgdmFsdWVzID0gW107XG5cdFx0XHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XG5cdFx0XHRcdFx0XG5cdFx0XHRcdFx0dmFsdWVzLnB1c2goJCh0aGlzKS52YWwoKSk7XG5cdFx0XHRcdFxuXHRcdFx0XHR9KTtcblx0XHRcdFx0XG5cdFx0XHRcdGZpZWxkVmFsID0gdmFsdWVzLmpvaW4oXCIrXCIpO1xuXHRcdFx0XHRcblx0XHRcdH1cblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLXNsaWRlclwiKVxuXHRcdFx0e1xuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXIgaW5wdXRcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHQvL2dldCBhbnkgbnVtYmVyIGZvcm1hdHRpbmcgc3R1ZmZcblx0XHRcdFx0dmFyICRtZXRhX3JhbmdlID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xuXHRcdFx0XHRcblx0XHRcdFx0dmFyIGRlY2ltYWxfcGxhY2VzID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtZGVjaW1hbC1wbGFjZXNcIik7XG5cdFx0XHRcdHZhciB0aG91c2FuZF9zZXBlcmF0b3IgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS10aG91c2FuZC1zZXBlcmF0b3JcIik7XG5cdFx0XHRcdHZhciBkZWNpbWFsX3NlcGVyYXRvciA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLWRlY2ltYWwtc2VwZXJhdG9yXCIpO1xuXG5cdFx0XHRcdHZhciBmaWVsZF9mb3JtYXQgPSB3TnVtYih7XG5cdFx0XHRcdFx0bWFyazogZGVjaW1hbF9zZXBlcmF0b3IsXG5cdFx0XHRcdFx0ZGVjaW1hbHM6IHBhcnNlRmxvYXQoZGVjaW1hbF9wbGFjZXMpLFxuXHRcdFx0XHRcdHRob3VzYW5kOiB0aG91c2FuZF9zZXBlcmF0b3Jcblx0XHRcdFx0fSk7XG5cdFx0XHRcdFxuXHRcdFx0XHR2YXIgdmFsdWVzID0gW107XG5cblxuXHRcdFx0XHR2YXIgc2xpZGVyX29iamVjdCA9ICRjb250YWluZXIuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcblx0XHRcdFx0Ly92YWwgZnJvbSBzbGlkZXIgb2JqZWN0XG5cdFx0XHRcdHZhciBzbGlkZXJfdmFsID0gc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmdldCgpO1xuXG5cdFx0XHRcdHZhbHVlcy5wdXNoKGZpZWxkX2Zvcm1hdC5mcm9tKHNsaWRlcl92YWxbMF0pKTtcblx0XHRcdFx0dmFsdWVzLnB1c2goZmllbGRfZm9ybWF0LmZyb20oc2xpZGVyX3ZhbFsxXSkpO1xuXHRcdFx0XHRcblx0XHRcdFx0ZmllbGRWYWwgPSB2YWx1ZXMuam9pbihcIitcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xuXHRcdFx0XHRcblx0XHRcdFx0XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1yYWRpb1wiKVxuXHRcdFx0e1xuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtaW5wdXQtcmFuZ2UtcmFkaW9cIik7XG5cdFx0XHRcdFxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPT0wKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0Ly90aGVuIHRyeSBhZ2Fpbiwgd2UgbXVzdCBiZSB1c2luZyBhIHNpbmdsZSBmaWVsZFxuXHRcdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIik7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHR2YXIgJG1ldGFfcmFuZ2UgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZVwiKTtcblx0XHRcdFx0XG5cdFx0XHRcdC8vdGhlcmUgaXMgYW4gZWxlbWVudCB3aXRoIGEgZnJvbS90byBjbGFzcyAtIHNvIHdlIG5lZWQgdG8gZ2V0IHRoZSB2YWx1ZXMgb2YgdGhlIGZyb20gJiB0byBpbnB1dCBmaWVsZHMgc2VwZXJhdGVseVxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXG5cdFx0XHRcdHtcdFxuXHRcdFx0XHRcdHZhciBmaWVsZF92YWxzID0gW107XG5cdFx0XHRcdFx0XG5cdFx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcblx0XHRcdFx0XHRcdFxuXHRcdFx0XHRcdFx0dmFyICRyYWRpb3MgPSAkKHRoaXMpLmZpbmQoXCIuc2YtaW5wdXQtcmFkaW9cIik7XG5cdFx0XHRcdFx0XHRmaWVsZF92YWxzLnB1c2goc2VsZi5nZXRNZXRhUmFkaW9WYWwoJHJhZGlvcykpO1xuXHRcdFx0XHRcdFx0XG5cdFx0XHRcdFx0fSk7XG5cdFx0XHRcdFx0XG5cdFx0XHRcdFx0Ly9wcmV2ZW50IHNlY29uZCBudW1iZXIgZnJvbSBiZWluZyBsb3dlciB0aGFuIHRoZSBmaXJzdFxuXHRcdFx0XHRcdGlmKGZpZWxkX3ZhbHMubGVuZ3RoPT0yKVxuXHRcdFx0XHRcdHtcblx0XHRcdFx0XHRcdGlmKE51bWJlcihmaWVsZF92YWxzWzFdKTxOdW1iZXIoZmllbGRfdmFsc1swXSkpXG5cdFx0XHRcdFx0XHR7XG5cdFx0XHRcdFx0XHRcdGZpZWxkX3ZhbHNbMV0gPSBmaWVsZF92YWxzWzBdO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcblx0XHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkX3ZhbHMuam9pbihcIitcIik7XG5cdFx0XHRcdH1cblx0XHRcdFx0XHRcdFx0XHRcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD09MSlcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGVsc2Vcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XG5cdFx0XHRcdH1cblxuXHRcdFx0fVxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFuZ2Utc2VsZWN0XCIpXG5cdFx0XHR7XG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1pbnB1dC1zZWxlY3RcIik7XG5cdFx0XHRcdHZhciAkbWV0YV9yYW5nZSA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlXCIpO1xuXHRcdFx0XHRcblx0XHRcdFx0Ly90aGVyZSBpcyBhbiBlbGVtZW50IHdpdGggYSBmcm9tL3RvIGNsYXNzIC0gc28gd2UgbmVlZCB0byBnZXQgdGhlIHZhbHVlcyBvZiB0aGUgZnJvbSAmIHRvIGlucHV0IGZpZWxkcyBzZXBlcmF0ZWx5XG5cdFx0XHRcdFxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXG5cdFx0XHRcdHtcblx0XHRcdFx0XHR2YXIgZmllbGRfdmFscyA9IFtdO1xuXHRcdFx0XHRcdFxuXHRcdFx0XHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XG5cdFx0XHRcdFx0XHRcblx0XHRcdFx0XHRcdHZhciAkdGhpcyA9ICQodGhpcyk7XG5cdFx0XHRcdFx0XHRmaWVsZF92YWxzLnB1c2goc2VsZi5nZXRNZXRhU2VsZWN0VmFsKCR0aGlzKSk7XG5cdFx0XHRcdFx0XHRcblx0XHRcdFx0XHR9KTtcblx0XHRcdFx0XHRcblx0XHRcdFx0XHQvL3ByZXZlbnQgc2Vjb25kIG51bWJlciBmcm9tIGJlaW5nIGxvd2VyIHRoYW4gdGhlIGZpcnN0XG5cdFx0XHRcdFx0aWYoZmllbGRfdmFscy5sZW5ndGg9PTIpXG5cdFx0XHRcdFx0e1xuXHRcdFx0XHRcdFx0aWYoTnVtYmVyKGZpZWxkX3ZhbHNbMV0pPE51bWJlcihmaWVsZF92YWxzWzBdKSlcblx0XHRcdFx0XHRcdHtcblx0XHRcdFx0XHRcdFx0ZmllbGRfdmFsc1sxXSA9IGZpZWxkX3ZhbHNbMF07XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFxuXHRcdFx0XHRcdFxuXHRcdFx0XHRcdGZpZWxkVmFsID0gZmllbGRfdmFscy5qb2luKFwiK1wiKTtcblx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0XHRcdFxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPT0xKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGVsc2Vcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XG5cdFx0XHRcdH1cblx0XHRcdFx0XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1jaGVja2JveFwiKVxuXHRcdFx0e1xuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xuXHRcdFx0XHRcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldENoZWNrYm94VmFsKCRmaWVsZCwgXCJhbmRcIik7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHRcdFxuXHRcdFx0aWYoZmllbGROYW1lPT1cIlwiKVxuXHRcdFx0e1xuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdGVsc2UgaWYobWV0YVR5cGU9PVwiY2hvaWNlXCIpXG5cdFx0e1xuXHRcdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxuXHRcdFx0e1xuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XG5cdFx0XHRcdFxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YVNlbGVjdFZhbCgkZmllbGQpOyBcblx0XHRcdFx0XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxuXHRcdFx0e1xuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRmaWVsZC5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcblx0XHRcdFx0XG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhTXVsdGlTZWxlY3RWYWwoJGZpZWxkLCBvcGVyYXRvcik7XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJjaGVja2JveFwiKVxuXHRcdFx0e1xuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xuXHRcdFx0XHRcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKS5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcblx0XHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YUNoZWNrYm94VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYWRpb1wiKVxuXHRcdFx0e1xuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnJhZGlvXCIpO1xuXHRcdFx0XHRcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE1ldGFSYWRpb1ZhbCgkZmllbGQpO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XHRcblx0XHRcdGZpZWxkVmFsID0gZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkVmFsKTtcblx0XHRcdGlmKHR5cGVvZigkZmllbGQpIT09XCJ1bmRlZmluZWRcIilcblx0XHRcdHtcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0XHRcdFxuXHRcdFx0XHRcdC8vZm9yIHRob3NlIHdobyBpbnNpc3Qgb24gdXNpbmcgJiBhbXBlcnNhbmRzIGluIHRoZSBuYW1lIG9mIHRoZSBjdXN0b20gZmllbGQgKCEpXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gKGZpZWxkTmFtZSk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHRcdFxuXHRcdH1cblx0XHRlbHNlIGlmKG1ldGFUeXBlPT1cImRhdGVcIilcblx0XHR7XG5cdFx0XHRzZWxmLnByb2Nlc3NQb3N0RGF0ZSgkY29udGFpbmVyKTtcblx0XHR9XG5cdFx0XG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcblx0XHR7XG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcblx0XHRcdHtcblx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJlwiK2VuY29kZVVSSUNvbXBvbmVudChmaWVsZE5hbWUpK1wiPVwiKyhmaWVsZFZhbCk7XG5cdFx0XHRcdHNlbGYudXJsX3BhcmFtc1tlbmNvZGVVUklDb21wb25lbnQoZmllbGROYW1lKV0gPSAoZmllbGRWYWwpO1xuXHRcdFx0fVxuXHRcdH1cblx0fSxcblx0cHJvY2Vzc1Bvc3REYXRlOiBmdW5jdGlvbigkY29udGFpbmVyKVxuXHR7XG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xuXHRcdFxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcblx0XHRcblx0XHR2YXIgJGZpZWxkO1xuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XG5cdFx0XG5cdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDp0ZXh0XCIpO1xuXHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcblx0XHRcblx0XHR2YXIgZGF0ZXMgPSBbXTtcblx0XHQkZmllbGQuZWFjaChmdW5jdGlvbigpe1xuXHRcdFx0XG5cdFx0XHRkYXRlcy5wdXNoKCQodGhpcykudmFsKCkpO1xuXHRcdFxuXHRcdH0pO1xuXHRcdFxuXHRcdGlmKCRmaWVsZC5sZW5ndGg9PTIpXG5cdFx0e1xuXHRcdFx0aWYoKGRhdGVzWzBdIT1cIlwiKXx8KGRhdGVzWzFdIT1cIlwiKSlcblx0XHRcdHtcblx0XHRcdFx0ZmllbGRWYWwgPSBkYXRlcy5qb2luKFwiK1wiKTtcblx0XHRcdFx0ZmllbGRWYWwgPSBmaWVsZFZhbC5yZXBsYWNlKC9cXC8vZywnJyk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdGVsc2UgaWYoJGZpZWxkLmxlbmd0aD09MSlcblx0XHR7XG5cdFx0XHRpZihkYXRlc1swXSE9XCJcIilcblx0XHRcdHtcblx0XHRcdFx0ZmllbGRWYWwgPSBkYXRlcy5qb2luKFwiK1wiKTtcblx0XHRcdFx0ZmllbGRWYWwgPSBmaWVsZFZhbC5yZXBsYWNlKC9cXC8vZywnJyk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdFxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXG5cdFx0e1xuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXG5cdFx0XHR7XG5cdFx0XHRcdHZhciBmaWVsZFNsdWcgPSBcIlwiO1xuXHRcdFx0XHRcblx0XHRcdFx0aWYoZmllbGROYW1lPT1cIl9zZl9wb3N0X2RhdGVcIilcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwicG9zdF9kYXRlXCI7XG5cdFx0XHRcdH1cblx0XHRcdFx0ZWxzZVxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gZmllbGROYW1lO1xuXHRcdFx0XHR9XG5cdFx0XHRcdFxuXHRcdFx0XHRpZihmaWVsZFNsdWchPVwiXCIpXG5cdFx0XHRcdHtcblx0XHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZmllbGRTbHVnK1wiPVwiK2ZpZWxkVmFsO1xuXHRcdFx0XHRcdHNlbGYudXJsX3BhcmFtc1tmaWVsZFNsdWddID0gZmllbGRWYWw7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cdFx0XG5cdH0sXG5cdHByb2Nlc3NUYXhvbm9teTogZnVuY3Rpb24oJGNvbnRhaW5lciwgcmV0dXJuX29iamVjdClcblx0e1xuICAgICAgICBpZih0eXBlb2YocmV0dXJuX29iamVjdCk9PVwidW5kZWZpbmVkXCIpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHJldHVybl9vYmplY3QgPSBmYWxzZTtcbiAgICAgICAgfVxuXG5cdFx0Ly9pZigpXHRcdFx0XHRcdFxuXHRcdC8vdmFyIGZpZWxkTmFtZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcblx0XHR2YXIgc2VsZiA9IHRoaXM7XG5cdFxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcblx0XHRcblx0XHR2YXIgJGZpZWxkO1xuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XG5cdFx0XG5cdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxuXHRcdHtcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcblx0XHRcdFxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFNlbGVjdFZhbCgkZmllbGQpOyBcblx0XHR9XG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwibXVsdGlzZWxlY3RcIilcblx0XHR7XG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XG5cdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHR2YXIgb3BlcmF0b3IgPSAkZmllbGQuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XG5cdFx0XHRcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNdWx0aVNlbGVjdFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcblx0XHR9XG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwiY2hlY2tib3hcIilcblx0XHR7XG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxuXHRcdFx0e1xuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XG5cdFx0XHRcdFx0XHRcdFx0XHRcdFxuXHRcdFx0XHR2YXIgb3BlcmF0b3IgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0Q2hlY2tib3hWYWwoJGZpZWxkLCBvcGVyYXRvcik7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhZGlvXCIpXG5cdFx0e1xuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpyYWRpb1wiKTtcblx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcblx0XHRcdHtcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xuXHRcdFx0XHRcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFJhZGlvVmFsKCRmaWVsZCk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdFxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXG5cdFx0e1xuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXG5cdFx0XHR7XG4gICAgICAgICAgICAgICAgaWYocmV0dXJuX29iamVjdD09dHJ1ZSlcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB7bmFtZTogZmllbGROYW1lLCB2YWx1ZTogZmllbGRWYWx9O1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZmllbGROYW1lK1wiPVwiK2ZpZWxkVmFsO1xuICAgICAgICAgICAgICAgICAgICBzZWxmLnVybF9wYXJhbXNbZmllbGROYW1lXSA9IGZpZWxkVmFsO1xuICAgICAgICAgICAgICAgIH1cblxuXHRcdFx0fVxuXHRcdH1cblxuICAgICAgICBpZihyZXR1cm5fb2JqZWN0PT10cnVlKVxuICAgICAgICB7XG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH1cblx0fVxufTtcbn0pLmNhbGwodGhpcyx0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsIDogdHlwZW9mIHNlbGYgIT09IFwidW5kZWZpbmVkXCIgPyBzZWxmIDogdHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvdyA6IHt9KVxuLy8jIHNvdXJjZU1hcHBpbmdVUkw9ZGF0YTphcHBsaWNhdGlvbi9qc29uO2NoYXJzZXQ6dXRmLTg7YmFzZTY0LGV5SjJaWEp6YVc5dUlqb3pMQ0p6YjNWeVkyVnpJanBiSW5OeVl5OXdkV0pzYVdNdllYTnpaWFJ6TDJwekwybHVZMngxWkdWekwzQnliMk5sYzNOZlptOXliUzVxY3lKZExDSnVZVzFsY3lJNlcxMHNJbTFoY0hCcGJtZHpJam9pTzBGQlFVRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEVpTENKbWFXeGxJam9pWjJWdVpYSmhkR1ZrTG1weklpd2ljMjkxY21ObFVtOXZkQ0k2SWlJc0luTnZkWEpqWlhORGIyNTBaVzUwSWpwYklseHVkbUZ5SUNRZ1BTQW9kSGx3Wlc5bUlIZHBibVJ2ZHlBaFBUMGdYQ0oxYm1SbFptbHVaV1JjSWlBL0lIZHBibVJ2ZDFzbmFsRjFaWEo1SjEwZ09pQjBlWEJsYjJZZ1oyeHZZbUZzSUNFOVBTQmNJblZ1WkdWbWFXNWxaRndpSUQ4Z1oyeHZZbUZzV3lkcVVYVmxjbmtuWFNBNklHNTFiR3dwTzF4dVhHNXRiMlIxYkdVdVpYaHdiM0owY3lBOUlIdGNibHh1WEhSMFlYaHZibTl0ZVY5aGNtTm9hWFpsY3pvZ01DeGNiaUFnSUNCMWNteGZjR0Z5WVcxek9pQjdmU3hjYmlBZ0lDQjBZWGhmWVhKamFHbDJaVjl5WlhOMWJIUnpYM1Z5YkRvZ1hDSmNJaXhjYmlBZ0lDQmhZM1JwZG1WZmRHRjRPaUJjSWx3aUxGeHVJQ0FnSUdacFpXeGtjem9nZTMwc1hHNWNkR2x1YVhRNklHWjFibU4wYVc5dUtIUmhlRzl1YjIxNVgyRnlZMmhwZG1WekxDQmpkWEp5Wlc1MFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1VcGUxeHVYRzRnSUNBZ0lDQWdJSFJvYVhNdWRHRjRiMjV2YlhsZllYSmphR2wyWlhNZ1BTQXdPMXh1SUNBZ0lDQWdJQ0IwYUdsekxuVnliRjl3WVhKaGJYTWdQU0I3ZlR0Y2JpQWdJQ0FnSUNBZ2RHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJDQTlJRndpWENJN1hHNGdJQ0FnSUNBZ0lIUm9hWE11WVdOMGFYWmxYM1JoZUNBOUlGd2lYQ0k3WEc1Y2JseDBYSFF2TDNSb2FYTXVKR1pwWld4a2N5QTlJQ1JtYVdWc1pITTdYRzRnSUNBZ0lDQWdJSFJvYVhNdWRHRjRiMjV2YlhsZllYSmphR2wyWlhNZ1BTQjBZWGh2Ym05dGVWOWhjbU5vYVhabGN6dGNiaUFnSUNBZ0lDQWdkR2hwY3k1amRYSnlaVzUwWDNSaGVHOXViMjE1WDJGeVkyaHBkbVVnUFNCamRYSnlaVzUwWDNSaGVHOXViMjE1WDJGeVkyaHBkbVU3WEc1Y2JseDBYSFIwYUdsekxtTnNaV0Z5VlhKc1EyOXRjRzl1Wlc1MGN5Z3BPMXh1WEc1Y2RIMHNYRzRnSUNBZ2MyVjBWR0Y0UVhKamFHbDJaVkpsYzNWc2RITlZjbXc2SUdaMWJtTjBhVzl1S0NSbWIzSnRMQ0JqZFhKeVpXNTBYM0psYzNWc2RITmZkWEpzTENCblpYUmZZV04wYVhabEtTQjdYRzVjYmlBZ0lDQWdJQ0FnZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh1WEhSY2RIUm9hWE11WTJ4bFlYSlVZWGhCY21Ob2FYWmxVbVZ6ZFd4MGMxVnliQ2dwTzF4dUlDQWdJQ0FnSUNBdkwzWmhjaUJqZFhKeVpXNTBYM0psYzNWc2RITmZkWEpzSUQwZ1hDSmNJanRjYmlBZ0lDQWdJQ0FnYVdZb2RHaHBjeTUwWVhodmJtOXRlVjloY21Ob2FYWmxjeUU5TVNsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVPMXh1SUNBZ0lDQWdJQ0I5WEc1Y2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtHZGxkRjloWTNScGRtVXBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHVYSFJjZEh0Y2JseDBYSFJjZEhaaGNpQm5aWFJmWVdOMGFYWmxJRDBnWm1Gc2MyVTdYRzVjZEZ4MGZWeHVYRzRnSUNBZ0lDQWdJQzh2WTJobFkyc2dkRzhnYzJWbElHbG1JSGRsSUdoaGRtVWdZVzU1SUhSaGVHOXViMjFwWlhNZ2MyVnNaV04wWldSY2JpQWdJQ0FnSUNBZ0x5OXBaaUJ6Ynl3Z1kyaGxZMnNnZEdobGFYSWdjbVYzY21sMFpYTWdZVzVrSUhWelpTQjBhRzl6WlNCaGN5QjBhR1VnY21WemRXeDBjeUIxY214Y2JpQWdJQ0FnSUNBZ2RtRnlJQ1JtYVdWc1pDQTlJR1poYkhObE8xeHVJQ0FnSUNBZ0lDQjJZWElnWm1sbGJHUmZibUZ0WlNBOUlGd2lYQ0k3WEc0Z0lDQWdJQ0FnSUhaaGNpQm1hV1ZzWkY5MllXeDFaU0E5SUZ3aVhDSTdYRzVjYmlBZ0lDQWdJQ0FnZG1GeUlDUmhZM1JwZG1WZmRHRjRiMjV2YlhrZ1BTQWtabTl5YlM0a1ptbGxiR1J6TG5CaGNtVnVkQ2dwTG1acGJtUW9YQ0piWkdGMFlTMXpaaTEwWVhodmJtOXRlUzFoY21Ob2FYWmxQU2N4SjExY0lpazdYRzRnSUNBZ0lDQWdJR2xtS0NSaFkzUnBkbVZmZEdGNGIyNXZiWGt1YkdWdVozUm9QVDB4S1Z4dUlDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FrWm1sbGJHUWdQU0FrWVdOMGFYWmxYM1JoZUc5dWIyMTVPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWm1sbGJHUlVlWEJsSUQwZ0pHWnBaV3hrTG1GMGRISW9YQ0prWVhSaExYTm1MV1pwWld4a0xYUjVjR1ZjSWlrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUlDZ29abWxsYkdSVWVYQmxJRDA5SUZ3aWRHRm5YQ0lwSUh4OElDaG1hV1ZzWkZSNWNHVWdQVDBnWENKallYUmxaMjl5ZVZ3aUtTQjhmQ0FvWm1sbGJHUlVlWEJsSUQwOUlGd2lkR0Y0YjI1dmJYbGNJaWtwSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkR0Y0YjI1dmJYbGZkbUZzZFdVZ1BTQnpaV3htTG5CeWIyTmxjM05VWVhodmJtOXRlU2drWm1sbGJHUXNJSFJ5ZFdVcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnBaV3hrWDI1aGJXVWdQU0FrWm1sbGJHUXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0Ym1GdFpWd2lLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RHRjRiMjV2YlhsZmJtRnRaU0E5SUdacFpXeGtYMjVoYldVdWNtVndiR0ZqWlNoY0lsOXpablJmWENJc0lGd2lYQ0lwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLSFJoZUc5dWIyMTVYM1poYkhWbEtTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdacFpXeGtYM1poYkhWbElEMGdkR0Y0YjI1dmJYbGZkbUZzZFdVdWRtRnNkV1U3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhtYVdWc1pGOTJZV3gxWlQwOVhDSmNJaWxjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRZ1BTQm1ZV3h6WlR0Y2JpQWdJQ0FnSUNBZ0lDQWdJSDFjYmlBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lHbG1LQ2h6Wld4bUxtTjFjbkpsYm5SZmRHRjRiMjV2YlhsZllYSmphR2wyWlNFOVhDSmNJaWttSmloelpXeG1MbU4xY25KbGJuUmZkR0Y0YjI1dmJYbGZZWEpqYUdsMlpTRTlkR0Y0YjI1dmJYbGZibUZ0WlNrcFhHNGdJQ0FnSUNBZ0lIdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJDQTlJR04xY25KbGJuUmZjbVZ6ZFd4MGMxOTFjbXc3WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200N1hHNGdJQ0FnSUNBZ0lIMWNibHh1SUNBZ0lDQWdJQ0JwWmlnb0tHWnBaV3hrWDNaaGJIVmxQVDFjSWx3aUtYeDhLQ0VrWm1sbGJHUXBJQ2twWEc0Z0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ1JtYjNKdExpUm1hV1ZzWkhNdVpXRmphQ2htZFc1amRHbHZiaUFvS1NCN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvSVNSbWFXVnNaQ2tnZTF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWFXVnNaRlI1Y0dVZ1BTQWtLSFJvYVhNcExtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMWFI1Y0dWY0lpazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLQ2htYVdWc1pGUjVjR1VnUFQwZ1hDSjBZV2RjSWlrZ2ZId2dLR1pwWld4a1ZIbHdaU0E5UFNCY0ltTmhkR1ZuYjNKNVhDSXBJSHg4SUNobWFXVnNaRlI1Y0dVZ1BUMGdYQ0owWVhodmJtOXRlVndpS1NrZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJoZUc5dWIyMTVYM1poYkhWbElEMGdjMlZzWmk1d2NtOWpaWE56VkdGNGIyNXZiWGtvSkNoMGFHbHpLU3dnZEhKMVpTazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1hV1ZzWkY5dVlXMWxJRDBnSkNoMGFHbHpLUzVoZEhSeUtGd2laR0YwWVMxelppMW1hV1ZzWkMxdVlXMWxYQ0lwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9kR0Y0YjI1dmJYbGZkbUZzZFdVcElIdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdacFpXeGtYM1poYkhWbElEMGdkR0Y0YjI1dmJYbGZkbUZzZFdVdWRtRnNkV1U3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvWm1sbGJHUmZkbUZzZFdVZ0lUMGdYQ0pjSWlrZ2UxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUm1hV1ZzWkNBOUlDUW9kR2hwY3lrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNiaUFnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUdsbUtDQW9KR1pwWld4a0tTQW1KaUFvWm1sbGJHUmZkbUZzZFdVZ0lUMGdYQ0pjSWlBcEtTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwybG1JSGRsSUdadmRXNWtJR0VnWm1sbGJHUmNibHgwWEhSY2RIWmhjaUJ5WlhkeWFYUmxYMkYwZEhJZ1BTQW9KR1pwWld4a0xtRjBkSElvWENKa1lYUmhMWE5tTFhSbGNtMHRjbVYzY21sMFpWd2lLU2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hKbGQzSnBkR1ZmWVhSMGNpRTlYQ0pjSWlrZ2UxeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGQzSnBkR1VnUFNCS1UwOU9MbkJoY25ObEtISmxkM0pwZEdWZllYUjBjaWs3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHbHVjSFYwWDNSNWNHVWdQU0FrWm1sbGJHUXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0YVc1d2RYUXRkSGx3WlZ3aUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GamRHbDJaVjkwWVhnZ1BTQm1hV1ZzWkY5dVlXMWxPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5bWFXNWtJSFJvWlNCaFkzUnBkbVVnWld4bGJXVnVkRnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNnb2FXNXdkWFJmZEhsd1pTQTlQU0JjSW5KaFpHbHZYQ0lwSUh4OElDaHBibkIxZEY5MGVYQmxJRDA5SUZ3aVkyaGxZMnRpYjNoY0lpa3BJSHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1poY2lBa1lXTjBhWFpsSUQwZ0pHWnBaV3hrTG1acGJtUW9YQ0l1YzJZdGIzQjBhVzl1TFdGamRHbDJaVndpS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTlsZUhCc2IyUmxJSFJvWlNCMllXeDFaWE1nYVdZZ2RHaGxjbVVnYVhNZ1lTQmtaV3hwYlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMlpwWld4a1gzWmhiSFZsWEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdselgzTnBibWRzWlY5MllXeDFaU0E5SUhSeWRXVTdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1hV1ZzWkY5MllXeDFaWE1nUFNCbWFXVnNaRjkyWVd4MVpTNXpjR3hwZENoY0lpeGNJaWt1YW05cGJpaGNJaXRjSWlrdWMzQnNhWFFvWENJclhDSXBPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9abWxsYkdSZmRtRnNkV1Z6TG14bGJtZDBhQ0ErSURFcElIdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbHpYM05wYm1kc1pWOTJZV3gxWlNBOUlHWmhiSE5sTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLR2x6WDNOcGJtZHNaVjkyWVd4MVpTa2dlMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHbHVjSFYwSUQwZ0pHWnBaV3hrTG1acGJtUW9YQ0pwYm5CMWRGdDJZV3gxWlQwblhDSWdLeUJtYVdWc1pGOTJZV3gxWlNBcklGd2lKMTFjSWlrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR0ZqZEdsMlpTQTlJQ1JwYm5CMWRDNXdZWEpsYm5Rb0tUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrWlhCMGFDQTlJQ1JoWTNScGRtVXVZWFIwY2loY0ltUmhkR0V0YzJZdFpHVndkR2hjSWlrN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZibTkzSUd4dmIzQWdkR2h5YjNWbmFDQndZWEpsYm5SeklIUnZJR2R5WVdJZ2RHaGxhWElnYm1GdFpYTmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIyWVd4MVpYTWdQU0J1WlhjZ1FYSnlZWGtvS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGJIVmxjeTV3ZFhOb0tHWnBaV3hrWDNaaGJIVmxLVHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWm05eUlDaDJZWElnYVNBOUlHUmxjSFJvT3lCcElENGdNRHNnYVMwdEtTQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdGamRHbDJaU0E5SUNSaFkzUnBkbVV1Y0dGeVpXNTBLQ2t1Y0dGeVpXNTBLQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnNkV1Z6TG5CMWMyZ29KR0ZqZEdsMlpTNW1hVzVrS0Z3aWFXNXdkWFJjSWlrdWRtRnNLQ2twTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllXeDFaWE11Y21WMlpYSnpaU2dwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyZHlZV0lnZEdobElISmxkM0pwZEdVZ1ptOXlJSFJvYVhNZ1pHVndkR2hjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCaFkzUnBkbVZmY21WM2NtbDBaU0E5SUhKbGQzSnBkR1ZiWkdWd2RHaGRPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhWeWJDQTlJR0ZqZEdsMlpWOXlaWGR5YVhSbE8xeHVYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZEdobGJpQnRZWEFnWm5KdmJTQjBhR1VnY0dGeVpXNTBjeUIwYnlCMGFHVWdaR1Z3ZEdoY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb2RtRnNkV1Z6S1M1bFlXTm9LR1oxYm1OMGFXOXVJQ2hwYm1SbGVDd2dkbUZzZFdVcElIdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhWeWJDQTlJSFZ5YkM1eVpYQnNZV05sS0Z3aVcxd2lJQ3NnYVc1a1pYZ2dLeUJjSWwxY0lpd2dkbUZzZFdVcE8xeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWRHRjRYMkZ5WTJocGRtVmZjbVZ6ZFd4MGMxOTFjbXdnUFNCMWNtdzdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCN1hHNWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZhV1lnZEdobGNtVWdZWEpsSUcxMWJIUnBjR3hsSUhaaGJIVmxjeXhjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZEdobGJpQjNaU0J1WldWa0lIUnZJR05vWldOcklHWnZjaUF6SUhSb2FXNW5jenBjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5cFppQjBhR1VnZG1Gc2RXVnpJSE5sYkdWamRHVmtJR0Z5WlNCaGJHd2dhVzRnZEdobElITmhiV1VnZEhKbFpTQjBhR1Z1SUhkbElHTmhiaUJrYnlCemIyMWxJR05zWlhabGNpQnlaWGR5YVhSbElITjBkV1ptWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDIxbGNtZGxJR0ZzYkNCMllXeDFaWE1nYVc0Z2MyRnRaU0JzWlhabGJDd2dkR2hsYmlCamIyMWlhVzVsSUhSb1pTQnNaWFpsYkhOY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXBaaUIwYUdWNUlHRnlaU0JtY205dElHUnBabVpsY21WdWRDQjBjbVZsY3lCMGFHVnVJR3AxYzNRZ1kyOXRZbWx1WlNCMGFHVnRJRzl5SUdwMWMzUWdkWE5sSUdCbWFXVnNaRjkyWVd4MVpXQmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHFYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1pHVndkR2h6SUQwZ2JtVjNJRUZ5Y21GNUtDazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQ2htYVdWc1pGOTJZV3gxWlhNcExtVmhZMmdvWm5WdVkzUnBiMjRnS0dsdVpHVjRMQ0IyWVd3cElIdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2FXNXdkWFFnUFNBa1ptbGxiR1F1Wm1sdVpDaGNJbWx1Y0hWMFczWmhiSFZsUFNkY0lpQXJJR1pwWld4a1gzWmhiSFZsSUNzZ1hDSW5YVndpS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR0ZqZEdsMlpTQTlJQ1JwYm5CMWRDNXdZWEpsYm5Rb0tUdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1pYQjBhQ0E5SUNSaFkzUnBkbVV1WVhSMGNpaGNJbVJoZEdFdGMyWXRaR1Z3ZEdoY0lpazdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTlrWlhCMGFITXVjSFZ6YUNoa1pYQjBhQ2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUc3FMMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCcFppQW9LR2x1Y0hWMFgzUjVjR1VnUFQwZ1hDSnpaV3hsWTNSY0lpa2dmSHdnS0dsdWNIVjBYM1I1Y0dVZ1BUMGdYQ0p0ZFd4MGFYTmxiR1ZqZEZ3aUtTa2dlMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJwYzE5emFXNW5iR1ZmZG1Gc2RXVWdQU0IwY25WbE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1ptbGxiR1JmZG1Gc2RXVnpJRDBnWm1sbGJHUmZkbUZzZFdVdWMzQnNhWFFvWENJc1hDSXBMbXB2YVc0b1hDSXJYQ0lwTG5Od2JHbDBLRndpSzF3aUtUdGNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tHWnBaV3hrWDNaaGJIVmxjeTVzWlc1bmRHZ2dQaUF4S1NCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcGMxOXphVzVuYkdWZmRtRnNkV1VnUFNCbVlXeHpaVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHVYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaHBjMTl6YVc1bmJHVmZkbUZzZFdVcElIdGNibHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSaFkzUnBkbVVnUFNBa1ptbGxiR1F1Wm1sdVpDaGNJbTl3ZEdsdmJsdDJZV3gxWlQwblhDSWdLeUJtYVdWc1pGOTJZV3gxWlNBcklGd2lKMTFjSWlrN1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR1Z3ZEdnZ1BTQWtZV04wYVhabExtRjBkSElvWENKa1lYUmhMWE5tTFdSbGNIUm9YQ0lwTzF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkbUZzZFdWeklEMGdibVYzSUVGeWNtRjVLQ2s3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVd4MVpYTXVjSFZ6YUNobWFXVnNaRjkyWVd4MVpTazdYRzVjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1p2Y2lBb2RtRnlJR2tnUFNCa1pYQjBhRHNnYVNBK0lEQTdJR2t0TFNrZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JoWTNScGRtVWdQU0FrWVdOMGFYWmxMbkJ5WlhaQmJHd29YQ0p2Y0hScGIyNWJaR0YwWVMxelppMWtaWEIwYUQwblhDSWdLeUFvYVNBdElERXBJQ3NnWENJblhWd2lLVHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllXeDFaWE11Y0hWemFDZ2tZV04wYVhabExuWmhiQ2dwS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2JseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnNkV1Z6TG5KbGRtVnljMlVvS1R0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmhZM1JwZG1WZmNtVjNjbWwwWlNBOUlISmxkM0pwZEdWYlpHVndkR2hkTzF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliQ0E5SUdGamRHbDJaVjl5WlhkeWFYUmxPMXh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQ2gyWVd4MVpYTXBMbVZoWTJnb1puVnVZM1JwYjI0Z0tHbHVaR1Y0TENCMllXeDFaU2tnZTF4dVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkWEpzSUQwZ2RYSnNMbkpsY0d4aFkyVW9YQ0piWENJZ0t5QnBibVJsZUNBcklGd2lYVndpTENCMllXeDFaU2s3WEc1Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJDQTlJSFZ5YkR0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh1WEc0Z0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ0x5OTBhR2x6TG5SaGVGOWhjbU5vYVhabFgzSmxjM1ZzZEhOZmRYSnNJRDBnWTNWeWNtVnVkRjl5WlhOMWJIUnpYM1Z5YkR0Y2JpQWdJQ0I5TEZ4dUlDQWdJR2RsZEZKbGMzVnNkSE5WY213NklHWjFibU4wYVc5dUtDUm1iM0p0TENCamRYSnlaVzUwWDNKbGMzVnNkSE5mZFhKc0tTQjdYRzVjYmlBZ0lDQWdJQ0FnTHk5MGFHbHpMbk5sZEZSaGVFRnlZMmhwZG1WU1pYTjFiSFJ6VlhKc0tDUm1iM0p0TENCamRYSnlaVzUwWDNKbGMzVnNkSE5mZFhKc0tUdGNibHh1SUNBZ0lDQWdJQ0JwWmloMGFHbHpMblJoZUY5aGNtTm9hWFpsWDNKbGMzVnNkSE5mZFhKc1BUMWNJbHdpS1Z4dUlDQWdJQ0FnSUNCN1hHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdZM1Z5Y21WdWRGOXlaWE4xYkhSelgzVnliRHRjYmlBZ0lDQWdJQ0FnZlZ4dVhHNGdJQ0FnSUNBZ0lISmxkSFZ5YmlCMGFHbHpMblJoZUY5aGNtTm9hWFpsWDNKbGMzVnNkSE5mZFhKc08xeHVJQ0FnSUgwc1hHNWNkR2RsZEZWeWJGQmhjbUZ0Y3pvZ1puVnVZM1JwYjI0b0pHWnZjbTBwZTF4dVhHNWNkRngwZEdocGN5NWlkV2xzWkZWeWJFTnZiWEJ2Ym1WdWRITW9KR1p2Y20wc0lIUnlkV1VwTzF4dVhHNGdJQ0FnSUNBZ0lHbG1LSFJvYVhNdWRHRjRYMkZ5WTJocGRtVmZjbVZ6ZFd4MGMxOTFjbXdoUFZ3aVhDSXBYRzRnSUNBZ0lDQWdJSHRjYmx4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZEdocGN5NWhZM1JwZG1WZmRHRjRJVDFjSWx3aUtWeHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1hV1ZzWkY5dVlXMWxJRDBnZEdocGN5NWhZM1JwZG1WZmRHRjRPMXh1WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hSb2FYTXVkWEpzWDNCaGNtRnRjMXRtYVdWc1pGOXVZVzFsWFNraFBWd2lkVzVrWldacGJtVmtYQ0lwWEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtaV3hsZEdVZ2RHaHBjeTUxY214ZmNHRnlZVzF6VzJacFpXeGtYMjVoYldWZE8xeHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2JpQWdJQ0FnSUNBZ2ZWeHVYRzVjZEZ4MGNtVjBkWEp1SUhSb2FYTXVkWEpzWDNCaGNtRnRjenRjYmx4MGZTeGNibHgwWTJ4bFlYSlZjbXhEYjIxd2IyNWxiblJ6T2lCbWRXNWpkR2x2YmlncGUxeHVYSFJjZEM4dmRHaHBjeTUxY214ZlkyOXRjRzl1Wlc1MGN5QTlJRndpWENJN1hHNWNkRngwZEdocGN5NTFjbXhmY0dGeVlXMXpJRDBnZTMwN1hHNWNkSDBzWEc1Y2RHTnNaV0Z5VkdGNFFYSmphR2wyWlZKbGMzVnNkSE5WY213NklHWjFibU4wYVc5dUtDa2dlMXh1WEhSY2RIUm9hWE11ZEdGNFgyRnlZMmhwZG1WZmNtVnpkV3gwYzE5MWNtd2dQU0FuSnp0Y2JseDBmU3hjYmx4MFpHbHpZV0pzWlVsdWNIVjBjem9nWm5WdVkzUnBiMjRvSkdadmNtMHBlMXh1WEhSY2RIWmhjaUJ6Wld4bUlEMGdkR2hwY3p0Y2JseDBYSFJjYmx4MFhIUWtabTl5YlM0a1ptbGxiR1J6TG1WaFkyZ29ablZ1WTNScGIyNG9LWHRjYmx4MFhIUmNkRnh1WEhSY2RGeDBkbUZ5SUNScGJuQjFkSE1nUFNBa0tIUm9hWE1wTG1acGJtUW9YQ0pwYm5CMWRDd2djMlZzWldOMExDQXViV1YwWVMxemJHbGtaWEpjSWlrN1hHNWNkRngwWEhRa2FXNXdkWFJ6TG1GMGRISW9YQ0prYVhOaFlteGxaRndpTENCY0ltUnBjMkZpYkdWa1hDSXBPMXh1WEhSY2RGeDBKR2x1Y0hWMGN5NWhkSFJ5S0Z3aVpHbHpZV0pzWldSY0lpd2dkSEoxWlNrN1hHNWNkRngwWEhRa2FXNXdkWFJ6TG5CeWIzQW9YQ0prYVhOaFlteGxaRndpTENCMGNuVmxLVHRjYmx4MFhIUmNkQ1JwYm5CMWRITXVkSEpwWjJkbGNpaGNJbU5vYjNObGJqcDFjR1JoZEdWa1hDSXBPMXh1WEhSY2RGeDBYRzVjZEZ4MGZTazdYRzVjZEZ4MFhHNWNkRngwWEc1Y2RIMHNYRzVjZEdWdVlXSnNaVWx1Y0hWMGN6b2dablZ1WTNScGIyNG9KR1p2Y20wcGUxeHVYSFJjZEhaaGNpQnpaV3htSUQwZ2RHaHBjenRjYmx4MFhIUWtabTl5YlM0a1ptbGxiR1J6TG1WaFkyZ29ablZ1WTNScGIyNG9LWHRjYmx4MFhIUmNkSFpoY2lBa2FXNXdkWFJ6SUQwZ0pDaDBhR2x6S1M1bWFXNWtLRndpYVc1d2RYUXNJSE5sYkdWamRDd2dMbTFsZEdFdGMyeHBaR1Z5WENJcE8xeHVYSFJjZEZ4MEpHbHVjSFYwY3k1d2NtOXdLRndpWkdsellXSnNaV1JjSWl3Z1ptRnNjMlVwTzF4dVhIUmNkRngwSkdsdWNIVjBjeTVoZEhSeUtGd2laR2x6WVdKc1pXUmNJaXdnWm1Gc2MyVXBPMXh1WEhSY2RGeDBKR2x1Y0hWMGN5NTBjbWxuWjJWeUtGd2lZMmh2YzJWdU9uVndaR0YwWldSY0lpazdYSFJjZEZ4MFhHNWNkRngwZlNrN1hHNWNkRngwWEc1Y2RGeDBYRzVjZEgwc1hHNWNkR0oxYVd4a1ZYSnNRMjl0Y0c5dVpXNTBjem9nWm5WdVkzUnBiMjRvSkdadmNtMHNJR05zWldGeVgyTnZiWEJ2Ym1WdWRITXBlMXh1WEhSY2RGeHVYSFJjZEhaaGNpQnpaV3htSUQwZ2RHaHBjenRjYmx4MFhIUmNibHgwWEhScFppaDBlWEJsYjJZb1kyeGxZWEpmWTI5dGNHOXVaVzUwY3lraFBWd2lkVzVrWldacGJtVmtYQ0lwWEc1Y2RGeDBlMXh1WEhSY2RGeDBhV1lvWTJ4bFlYSmZZMjl0Y0c5dVpXNTBjejA5ZEhKMVpTbGNibHgwWEhSY2RIdGNibHgwWEhSY2RGeDBkR2hwY3k1amJHVmhjbFZ5YkVOdmJYQnZibVZ1ZEhNb0tUdGNibHgwWEhSY2RIMWNibHgwWEhSOVhHNWNkRngwWEc1Y2RGeDBKR1p2Y20wdUpHWnBaV3hrY3k1bFlXTm9LR1oxYm1OMGFXOXVLQ2w3WEc1Y2RGeDBYSFJjYmx4MFhIUmNkSFpoY2lCbWFXVnNaRTVoYldVZ1BTQWtLSFJvYVhNcExtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMVzVoYldWY0lpazdYRzVjZEZ4MFhIUjJZWElnWm1sbGJHUlVlWEJsSUQwZ0pDaDBhR2x6S1M1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMTBlWEJsWENJcE8xeHVYSFJjZEZ4MFhHNWNkRngwWEhScFppaG1hV1ZzWkZSNWNHVTlQVndpYzJWaGNtTm9YQ0lwWEc1Y2RGeDBYSFI3WEc1Y2RGeDBYSFJjZEhObGJHWXVjSEp2WTJWemMxTmxZWEpqYUVacFpXeGtLQ1FvZEdocGN5a3BPMXh1WEhSY2RGeDBmVnh1WEhSY2RGeDBaV3h6WlNCcFppZ29abWxsYkdSVWVYQmxQVDFjSW5SaFoxd2lLWHg4S0dacFpXeGtWSGx3WlQwOVhDSmpZWFJsWjI5eWVWd2lLWHg4S0dacFpXeGtWSGx3WlQwOVhDSjBZWGh2Ym05dGVWd2lLU2xjYmx4MFhIUmNkSHRjYmx4MFhIUmNkRngwYzJWc1ppNXdjbTlqWlhOelZHRjRiMjV2Ylhrb0pDaDBhR2x6S1NrN1hHNWNkRngwWEhSOVhHNWNkRngwWEhSbGJITmxJR2xtS0dacFpXeGtWSGx3WlQwOVhDSnpiM0owWDI5eVpHVnlYQ0lwWEc1Y2RGeDBYSFI3WEc1Y2RGeDBYSFJjZEhObGJHWXVjSEp2WTJWemMxTnZjblJQY21SbGNrWnBaV3hrS0NRb2RHaHBjeWtwTzF4dVhIUmNkRngwZlZ4dVhIUmNkRngwWld4elpTQnBaaWhtYVdWc1pGUjVjR1U5UFZ3aWNHOXpkSE5mY0dWeVgzQmhaMlZjSWlsY2JseDBYSFJjZEh0Y2JseDBYSFJjZEZ4MGMyVnNaaTV3Y205alpYTnpVbVZ6ZFd4MGMxQmxjbEJoWjJWR2FXVnNaQ2drS0hSb2FYTXBLVHRjYmx4MFhIUmNkSDFjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9abWxsYkdSVWVYQmxQVDFjSW1GMWRHaHZjbHdpS1Z4dVhIUmNkRngwZTF4dVhIUmNkRngwWEhSelpXeG1MbkJ5YjJObGMzTkJkWFJvYjNJb0pDaDBhR2x6S1NrN1hHNWNkRngwWEhSOVhHNWNkRngwWEhSbGJITmxJR2xtS0dacFpXeGtWSGx3WlQwOVhDSndiM04wWDNSNWNHVmNJaWxjYmx4MFhIUmNkSHRjYmx4MFhIUmNkRngwYzJWc1ppNXdjbTlqWlhOelVHOXpkRlI1Y0dVb0pDaDBhR2x6S1NrN1hHNWNkRngwWEhSOVhHNWNkRngwWEhSbGJITmxJR2xtS0dacFpXeGtWSGx3WlQwOVhDSndiM04wWDJSaGRHVmNJaWxjYmx4MFhIUmNkSHRjYmx4MFhIUmNkRngwYzJWc1ppNXdjbTlqWlhOelVHOXpkRVJoZEdVb0pDaDBhR2x6S1NrN1hHNWNkRngwWEhSOVhHNWNkRngwWEhSbGJITmxJR2xtS0dacFpXeGtWSGx3WlQwOVhDSndiM04wWDIxbGRHRmNJaWxjYmx4MFhIUmNkSHRjYmx4MFhIUmNkRngwYzJWc1ppNXdjbTlqWlhOelVHOXpkRTFsZEdFb0pDaDBhR2x6S1NrN1hHNWNkRngwWEhSY2RGeHVYSFJjZEZ4MGZWeHVYSFJjZEZ4MFpXeHpaVnh1WEhSY2RGeDBlMXh1WEhSY2RGeDBYSFJjYmx4MFhIUmNkSDFjYmx4MFhIUmNkRnh1WEhSY2RIMHBPMXh1WEhSY2RGeHVYSFI5TEZ4dVhIUndjbTlqWlhOelUyVmhjbU5vUm1sbGJHUTZJR1oxYm1OMGFXOXVLQ1JqYjI1MFlXbHVaWElwWEc1Y2RIdGNibHgwWEhSMllYSWdjMlZzWmlBOUlIUm9hWE03WEc1Y2RGeDBYRzVjZEZ4MGRtRnlJQ1JtYVdWc1pDQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJbWx1Y0hWMFcyNWhiV1ZlUFNkZmMyWmZjMlZoY21Ob0oxMWNJaWs3WEc1Y2RGeDBYRzVjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQ0d0tWeHVYSFJjZEh0Y2JseDBYSFJjZEhaaGNpQm1hV1ZzWkU1aGJXVWdQU0FrWm1sbGJHUXVZWFIwY2loY0ltNWhiV1ZjSWlrdWNtVndiR0ZqWlNnblcxMG5MQ0FuSnlrN1hHNWNkRngwWEhSMllYSWdabWxsYkdSV1lXd2dQU0FrWm1sbGJHUXVkbUZzS0NrN1hHNWNkRngwWEhSY2JseDBYSFJjZEdsbUtHWnBaV3hrVm1Gc0lUMWNJbHdpS1Z4dVhIUmNkRngwZTF4dVhIUmNkRngwWEhRdkwzTmxiR1l1ZFhKc1gyTnZiWEJ2Ym1WdWRITWdLejBnWENJbVgzTm1YM005WENJclpXNWpiMlJsVlZKSlEyOXRjRzl1Wlc1MEtHWnBaV3hrVm1Gc0tUdGNibHgwWEhSY2RGeDBjMlZzWmk1MWNteGZjR0Z5WVcxeld5ZGZjMlpmY3lkZElEMGdaVzVqYjJSbFZWSkpRMjl0Y0c5dVpXNTBLR1pwWld4a1ZtRnNLVHRjYmx4MFhIUmNkSDFjYmx4MFhIUjlYRzVjZEgwc1hHNWNkSEJ5YjJObGMzTlRiM0owVDNKa1pYSkdhV1ZzWkRvZ1puVnVZM1JwYjI0b0pHTnZiblJoYVc1bGNpbGNibHgwZTF4dVhIUmNkSFJvYVhNdWNISnZZMlZ6YzBGMWRHaHZjaWdrWTI5dWRHRnBibVZ5S1R0Y2JseDBYSFJjYmx4MGZTeGNibHgwY0hKdlkyVnpjMUpsYzNWc2RITlFaWEpRWVdkbFJtbGxiR1E2SUdaMWJtTjBhVzl1S0NSamIyNTBZV2x1WlhJcFhHNWNkSHRjYmx4MFhIUjBhR2x6TG5CeWIyTmxjM05CZFhSb2IzSW9KR052Ym5SaGFXNWxjaWs3WEc1Y2RGeDBYRzVjZEgwc1hHNWNkR2RsZEVGamRHbDJaVlJoZURvZ1puVnVZM1JwYjI0b0pHWnBaV3hrS1NCN1hHNWNkRngwY21WMGRYSnVJSFJvYVhNdVlXTjBhWFpsWDNSaGVEdGNibHgwZlN4Y2JseDBaMlYwVTJWc1pXTjBWbUZzT2lCbWRXNWpkR2x2Ymlna1ptbGxiR1FwZTF4dVhHNWNkRngwZG1GeUlHWnBaV3hrVm1Gc0lEMGdYQ0pjSWp0Y2JseDBYSFJjYmx4MFhIUnBaaWdrWm1sbGJHUXVkbUZzS0NraFBUQXBYRzVjZEZ4MGUxeHVYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQWtabWxsYkdRdWRtRnNLQ2s3WEc1Y2RGeDBmVnh1WEhSY2RGeHVYSFJjZEdsbUtHWnBaV3hrVm1Gc1BUMXVkV3hzS1Z4dVhIUmNkSHRjYmx4MFhIUmNkR1pwWld4a1ZtRnNJRDBnWENKY0lqdGNibHgwWEhSOVhHNWNkRngwWEc1Y2RGeDBjbVYwZFhKdUlHWnBaV3hrVm1Gc08xeHVYSFI5TEZ4dVhIUm5aWFJOWlhSaFUyVnNaV04wVm1Gc09pQm1kVzVqZEdsdmJpZ2tabWxsYkdRcGUxeHVYSFJjZEZ4dVhIUmNkSFpoY2lCbWFXVnNaRlpoYkNBOUlGd2lYQ0k3WEc1Y2RGeDBYRzVjZEZ4MFptbGxiR1JXWVd3Z1BTQWtabWxsYkdRdWRtRnNLQ2s3WEc1Y2RGeDBYSFJjZEZ4MFhIUmNibHgwWEhScFppaG1hV1ZzWkZaaGJEMDliblZzYkNsY2JseDBYSFI3WEc1Y2RGeDBYSFJtYVdWc1pGWmhiQ0E5SUZ3aVhDSTdYRzVjZEZ4MGZWeHVYSFJjZEZ4dVhIUmNkSEpsZEhWeWJpQm1hV1ZzWkZaaGJEdGNibHgwZlN4Y2JseDBaMlYwVFhWc2RHbFRaV3hsWTNSV1lXdzZJR1oxYm1OMGFXOXVLQ1JtYVdWc1pDd2diM0JsY21GMGIzSXBlMXh1WEhSY2RGeHVYSFJjZEhaaGNpQmtaV3hwYlNBOUlGd2lLMXdpTzF4dVhIUmNkR2xtS0c5d1pYSmhkRzl5UFQxY0ltOXlYQ0lwWEc1Y2RGeDBlMXh1WEhSY2RGeDBaR1ZzYVcwZ1BTQmNJaXhjSWp0Y2JseDBYSFI5WEc1Y2RGeDBYRzVjZEZ4MGFXWW9kSGx3Wlc5bUtDUm1hV1ZzWkM1MllXd29LU2s5UFZ3aWIySnFaV04wWENJcFhHNWNkRngwZTF4dVhIUmNkRngwYVdZb0pHWnBaV3hrTG5aaGJDZ3BJVDF1ZFd4c0tWeHVYSFJjZEZ4MGUxeHVYSFJjZEZ4MFhIUnlaWFIxY200Z0pHWnBaV3hrTG5aaGJDZ3BMbXB2YVc0b1pHVnNhVzBwTzF4dVhIUmNkRngwZlZ4dVhIUmNkSDFjYmx4MFhIUmNibHgwZlN4Y2JseDBaMlYwVFdWMFlVMTFiSFJwVTJWc1pXTjBWbUZzT2lCbWRXNWpkR2x2Ymlna1ptbGxiR1FzSUc5d1pYSmhkRzl5S1h0Y2JseDBYSFJjYmx4MFhIUjJZWElnWkdWc2FXMGdQU0JjSWkwckxWd2lPMXh1WEhSY2RHbG1LRzl3WlhKaGRHOXlQVDFjSW05eVhDSXBYRzVjZEZ4MGUxeHVYSFJjZEZ4MFpHVnNhVzBnUFNCY0lpMHNMVndpTzF4dVhIUmNkSDFjYmx4MFhIUmNkRngwWEc1Y2RGeDBhV1lvZEhsd1pXOW1LQ1JtYVdWc1pDNTJZV3dvS1NrOVBWd2liMkpxWldOMFhDSXBYRzVjZEZ4MGUxeHVYSFJjZEZ4MGFXWW9KR1pwWld4a0xuWmhiQ2dwSVQxdWRXeHNLVnh1WEhSY2RGeDBlMXh1WEhSY2RGeDBYSFJjYmx4MFhIUmNkRngwZG1GeUlHWnBaV3hrZG1Gc0lEMGdXMTA3WEc1Y2RGeDBYSFJjZEZ4dVhIUmNkRngwWEhRa0tDUm1hV1ZzWkM1MllXd29LU2t1WldGamFDaG1kVzVqZEdsdmJpaHBibVJsZUN4MllXeDFaU2w3WEc1Y2RGeDBYSFJjZEZ4MFhHNWNkRngwWEhSY2RGeDBabWxsYkdSMllXd3VjSFZ6YUNnb2RtRnNkV1VwS1R0Y2JseDBYSFJjZEZ4MGZTazdYRzVjZEZ4MFhIUmNkRnh1WEhSY2RGeDBYSFJ5WlhSMWNtNGdabWxsYkdSMllXd3VhbTlwYmloa1pXeHBiU2s3WEc1Y2RGeDBYSFI5WEc1Y2RGeDBmVnh1WEhSY2RGeHVYSFJjZEhKbGRIVnliaUJjSWx3aU8xeHVYSFJjZEZ4dVhIUjlMRnh1WEhSblpYUkRhR1ZqYTJKdmVGWmhiRG9nWm5WdVkzUnBiMjRvSkdacFpXeGtMQ0J2Y0dWeVlYUnZjaWw3WEc1Y2RGeDBYRzVjZEZ4MFhHNWNkRngwZG1GeUlHWnBaV3hrVm1Gc0lEMGdKR1pwWld4a0xtMWhjQ2htZFc1amRHbHZiaWdwZTF4dVhIUmNkRngwYVdZb0pDaDBhR2x6S1M1d2NtOXdLRndpWTJobFkydGxaRndpS1QwOWRISjFaU2xjYmx4MFhIUmNkSHRjYmx4MFhIUmNkRngwY21WMGRYSnVJQ1FvZEdocGN5a3VkbUZzS0NrN1hHNWNkRngwWEhSOVhHNWNkRngwZlNrdVoyVjBLQ2s3WEc1Y2RGeDBYRzVjZEZ4MGRtRnlJR1JsYkdsdElEMGdYQ0lyWENJN1hHNWNkRngwYVdZb2IzQmxjbUYwYjNJOVBWd2liM0pjSWlsY2JseDBYSFI3WEc1Y2RGeDBYSFJrWld4cGJTQTlJRndpTEZ3aU8xeHVYSFJjZEgxY2JseDBYSFJjYmx4MFhIUnlaWFIxY200Z1ptbGxiR1JXWVd3dWFtOXBiaWhrWld4cGJTazdYRzVjZEgwc1hHNWNkR2RsZEUxbGRHRkRhR1ZqYTJKdmVGWmhiRG9nWm5WdVkzUnBiMjRvSkdacFpXeGtMQ0J2Y0dWeVlYUnZjaWw3WEc1Y2RGeDBYRzVjZEZ4MFhHNWNkRngwZG1GeUlHWnBaV3hrVm1Gc0lEMGdKR1pwWld4a0xtMWhjQ2htZFc1amRHbHZiaWdwZTF4dVhIUmNkRngwYVdZb0pDaDBhR2x6S1M1d2NtOXdLRndpWTJobFkydGxaRndpS1QwOWRISjFaU2xjYmx4MFhIUmNkSHRjYmx4MFhIUmNkRngwY21WMGRYSnVJQ2drS0hSb2FYTXBMblpoYkNncEtUdGNibHgwWEhSY2RIMWNibHgwWEhSOUtTNW5aWFFvS1R0Y2JseDBYSFJjYmx4MFhIUjJZWElnWkdWc2FXMGdQU0JjSWkwckxWd2lPMXh1WEhSY2RHbG1LRzl3WlhKaGRHOXlQVDFjSW05eVhDSXBYRzVjZEZ4MGUxeHVYSFJjZEZ4MFpHVnNhVzBnUFNCY0lpMHNMVndpTzF4dVhIUmNkSDFjYmx4MFhIUmNibHgwWEhSeVpYUjFjbTRnWm1sbGJHUldZV3d1YW05cGJpaGtaV3hwYlNrN1hHNWNkSDBzWEc1Y2RHZGxkRkpoWkdsdlZtRnNPaUJtZFc1amRHbHZiaWdrWm1sbGJHUXBlMXh1WEhSY2RGeDBYSFJjZEZ4MFhIUmNibHgwWEhSMllYSWdabWxsYkdSV1lXd2dQU0FrWm1sbGJHUXViV0Z3S0daMWJtTjBhVzl1S0NsY2JseDBYSFI3WEc1Y2RGeDBYSFJwWmlna0tIUm9hWE1wTG5CeWIzQW9YQ0pqYUdWamEyVmtYQ0lwUFQxMGNuVmxLVnh1WEhSY2RGeDBlMXh1WEhSY2RGeDBYSFJ5WlhSMWNtNGdKQ2gwYUdsektTNTJZV3dvS1R0Y2JseDBYSFJjZEgxY2JseDBYSFJjZEZ4dVhIUmNkSDBwTG1kbGRDZ3BPMXh1WEhSY2RGeHVYSFJjZEZ4dVhIUmNkR2xtS0dacFpXeGtWbUZzV3pCZElUMHdLVnh1WEhSY2RIdGNibHgwWEhSY2RISmxkSFZ5YmlCbWFXVnNaRlpoYkZzd1hUdGNibHgwWEhSOVhHNWNkSDBzWEc1Y2RHZGxkRTFsZEdGU1lXUnBiMVpoYkRvZ1puVnVZM1JwYjI0b0pHWnBaV3hrS1h0Y2JseDBYSFJjZEZ4MFhIUmNkRngwWEc1Y2RGeDBkbUZ5SUdacFpXeGtWbUZzSUQwZ0pHWnBaV3hrTG0xaGNDaG1kVzVqZEdsdmJpZ3BYRzVjZEZ4MGUxeHVYSFJjZEZ4MGFXWW9KQ2gwYUdsektTNXdjbTl3S0Z3aVkyaGxZMnRsWkZ3aUtUMDlkSEoxWlNsY2JseDBYSFJjZEh0Y2JseDBYSFJjZEZ4MGNtVjBkWEp1SUNRb2RHaHBjeWt1ZG1Gc0tDazdYRzVjZEZ4MFhIUjlYRzVjZEZ4MFhIUmNibHgwWEhSOUtTNW5aWFFvS1R0Y2JseDBYSFJjYmx4MFhIUnlaWFIxY200Z1ptbGxiR1JXWVd4Yk1GMDdYRzVjZEgwc1hHNWNkSEJ5YjJObGMzTkJkWFJvYjNJNklHWjFibU4wYVc5dUtDUmpiMjUwWVdsdVpYSXBYRzVjZEh0Y2JseDBYSFIyWVhJZ2MyVnNaaUE5SUhSb2FYTTdYRzVjZEZ4MFhHNWNkRngwWEc1Y2RGeDBkbUZ5SUdacFpXeGtWSGx3WlNBOUlDUmpiMjUwWVdsdVpYSXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0ZEhsd1pWd2lLVHRjYmx4MFhIUjJZWElnYVc1d2RYUlVlWEJsSUQwZ0pHTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzFwYm5CMWRDMTBlWEJsWENJcE8xeHVYSFJjZEZ4dVhIUmNkSFpoY2lBa1ptbGxiR1E3WEc1Y2RGeDBkbUZ5SUdacFpXeGtUbUZ0WlNBOUlGd2lYQ0k3WEc1Y2RGeDBkbUZ5SUdacFpXeGtWbUZzSUQwZ1hDSmNJanRjYmx4MFhIUmNibHgwWEhScFppaHBibkIxZEZSNWNHVTlQVndpYzJWc1pXTjBYQ0lwWEc1Y2RGeDBlMXh1WEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2ljMlZzWldOMFhDSXBPMXh1WEhSY2RGeDBabWxsYkdST1lXMWxJRDBnSkdacFpXeGtMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHVYSFJjZEZ4MFhHNWNkRngwWEhSbWFXVnNaRlpoYkNBOUlITmxiR1l1WjJWMFUyVnNaV04wVm1Gc0tDUm1hV1ZzWkNrN0lGeHVYSFJjZEgxY2JseDBYSFJsYkhObElHbG1LR2x1Y0hWMFZIbHdaVDA5WENKdGRXeDBhWE5sYkdWamRGd2lLVnh1WEhSY2RIdGNibHgwWEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0luTmxiR1ZqZEZ3aUtUdGNibHgwWEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2JseDBYSFJjZEhaaGNpQnZjR1Z5WVhSdmNpQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aVpHRjBZUzF2Y0dWeVlYUnZjbHdpS1R0Y2JseDBYSFJjZEZ4dVhIUmNkRngwWm1sbGJHUldZV3dnUFNCelpXeG1MbWRsZEUxMWJIUnBVMlZzWldOMFZtRnNLQ1JtYVdWc1pDd2dYQ0p2Y2x3aUtUdGNibHgwWEhSY2RGeHVYSFJjZEgxY2JseDBYSFJsYkhObElHbG1LR2x1Y0hWMFZIbHdaVDA5WENKamFHVmphMkp2ZUZ3aUtWeHVYSFJjZEh0Y2JseDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5Wc0lENGdiR2tnYVc1d2RYUTZZMmhsWTJ0aWIzaGNJaWs3WEc1Y2RGeDBYSFJjYmx4MFhIUmNkR2xtS0NSbWFXVnNaQzVzWlc1bmRHZytNQ2xjYmx4MFhIUmNkSHRjYmx4MFhIUmNkRngwWm1sbGJHUk9ZVzFsSUQwZ0pHWnBaV3hrTG1GMGRISW9YQ0p1WVcxbFhDSXBMbkpsY0d4aFkyVW9KMXRkSnl3Z0p5Y3BPMXh1WEhSY2RGeDBYSFJjZEZ4MFhIUmNkRngwWEhSY2JseDBYSFJjZEZ4MGRtRnlJRzl3WlhKaGRHOXlJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpUGlCMWJGd2lLUzVoZEhSeUtGd2laR0YwWVMxdmNHVnlZWFJ2Y2x3aUtUdGNibHgwWEhSY2RGeDBabWxsYkdSV1lXd2dQU0J6Wld4bUxtZGxkRU5vWldOclltOTRWbUZzS0NSbWFXVnNaQ3dnWENKdmNsd2lLVHRjYmx4MFhIUmNkSDFjYmx4MFhIUmNkRnh1WEhSY2RIMWNibHgwWEhSbGJITmxJR2xtS0dsdWNIVjBWSGx3WlQwOVhDSnlZV1JwYjF3aUtWeHVYSFJjZEh0Y2JseDBYSFJjZEZ4dVhIUmNkRngwSkdacFpXeGtJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpZFd3Z1BpQnNhU0JwYm5CMWREcHlZV1JwYjF3aUtUdGNibHgwWEhSY2RGeDBYSFJjZEZ4dVhIUmNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDR3S1Z4dVhIUmNkRngwZTF4dVhIUmNkRngwWEhSbWFXVnNaRTVoYldVZ1BTQWtabWxsYkdRdVlYUjBjaWhjSW01aGJXVmNJaWt1Y21Wd2JHRmpaU2duVzEwbkxDQW5KeWs3WEc1Y2RGeDBYSFJjZEZ4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlITmxiR1l1WjJWMFVtRmthVzlXWVd3b0pHWnBaV3hrS1R0Y2JseDBYSFJjZEgxY2JseDBYSFI5WEc1Y2RGeDBYRzVjZEZ4MGFXWW9kSGx3Wlc5bUtHWnBaV3hrVm1Gc0tTRTlYQ0oxYm1SbFptbHVaV1JjSWlsY2JseDBYSFI3WEc1Y2RGeDBYSFJwWmlobWFXVnNaRlpoYkNFOVhDSmNJaWxjYmx4MFhIUmNkSHRjYmx4MFhIUmNkRngwZG1GeUlHWnBaV3hrVTJ4MVp5QTlJRndpWENJN1hHNWNkRngwWEhSY2RGeHVYSFJjZEZ4MFhIUnBaaWhtYVdWc1pFNWhiV1U5UFZ3aVgzTm1YMkYxZEdodmNsd2lLVnh1WEhSY2RGeDBYSFI3WEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JUYkhWbklEMGdYQ0poZFhSb2IzSnpYQ0k3WEc1Y2RGeDBYSFJjZEgxY2JseDBYSFJjZEZ4MFpXeHpaU0JwWmlobWFXVnNaRTVoYldVOVBWd2lYM05tWDNOdmNuUmZiM0prWlhKY0lpbGNibHgwWEhSY2RGeDBlMXh1WEhSY2RGeDBYSFJjZEdacFpXeGtVMngxWnlBOUlGd2ljMjl5ZEY5dmNtUmxjbHdpTzF4dVhIUmNkRngwWEhSOVhHNWNkRngwWEhSY2RHVnNjMlVnYVdZb1ptbGxiR1JPWVcxbFBUMWNJbDl6Wmw5d2NIQmNJaWxjYmx4MFhIUmNkRngwZTF4dVhIUmNkRngwWEhSY2RHWnBaV3hrVTJ4MVp5QTlJRndpWDNObVgzQndjRndpTzF4dVhIUmNkRngwWEhSOVhHNWNkRngwWEhSY2RHVnNjMlVnYVdZb1ptbGxiR1JPWVcxbFBUMWNJbDl6Wmw5d2IzTjBYM1I1Y0dWY0lpbGNibHgwWEhSY2RGeDBlMXh1WEhSY2RGeDBYSFJjZEdacFpXeGtVMngxWnlBOUlGd2ljRzl6ZEY5MGVYQmxjMXdpTzF4dVhIUmNkRngwWEhSOVhHNWNkRngwWEhSY2RHVnNjMlZjYmx4MFhIUmNkRngwZTF4dVhIUmNkRngwWEhSY2JseDBYSFJjZEZ4MGZWeHVYSFJjZEZ4MFhIUmNibHgwWEhSY2RGeDBhV1lvWm1sbGJHUlRiSFZuSVQxY0lsd2lLVnh1WEhSY2RGeDBYSFI3WEc1Y2RGeDBYSFJjZEZ4MEx5OXpaV3htTG5WeWJGOWpiMjF3YjI1bGJuUnpJQ3M5SUZ3aUpsd2lLMlpwWld4a1UyeDFaeXRjSWoxY0lpdG1hV1ZzWkZaaGJEdGNibHgwWEhSY2RGeDBYSFJ6Wld4bUxuVnliRjl3WVhKaGJYTmJabWxsYkdSVGJIVm5YU0E5SUdacFpXeGtWbUZzTzF4dVhIUmNkRngwWEhSOVhHNWNkRngwWEhSOVhHNWNkRngwZlZ4dVhIUmNkRnh1WEhSOUxGeHVYSFJ3Y205alpYTnpVRzl6ZEZSNWNHVWdPaUJtZFc1amRHbHZiaWdrZEdocGN5bDdYRzVjZEZ4MFhHNWNkRngwZEdocGN5NXdjbTlqWlhOelFYVjBhRzl5S0NSMGFHbHpLVHRjYmx4MFhIUmNibHgwZlN4Y2JseDBjSEp2WTJWemMxQnZjM1JOWlhSaE9pQm1kVzVqZEdsdmJpZ2tZMjl1ZEdGcGJtVnlLVnh1WEhSN1hHNWNkRngwZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh1WEhSY2RGeHVYSFJjZEhaaGNpQm1hV1ZzWkZSNWNHVWdQU0FrWTI5dWRHRnBibVZ5TG1GMGRISW9YQ0prWVhSaExYTm1MV1pwWld4a0xYUjVjR1ZjSWlrN1hHNWNkRngwZG1GeUlHbHVjSFYwVkhsd1pTQTlJQ1JqYjI1MFlXbHVaWEl1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGFXNXdkWFF0ZEhsd1pWd2lLVHRjYmx4MFhIUjJZWElnYldWMFlWUjVjR1VnUFNBa1kyOXVkR0ZwYm1WeUxtRjBkSElvWENKa1lYUmhMWE5tTFcxbGRHRXRkSGx3WlZ3aUtUdGNibHh1WEhSY2RIWmhjaUJtYVdWc1pGWmhiQ0E5SUZ3aVhDSTdYRzVjZEZ4MGRtRnlJQ1JtYVdWc1pEdGNibHgwWEhSMllYSWdabWxsYkdST1lXMWxJRDBnWENKY0lqdGNibHgwWEhSY2JseDBYSFJwWmlodFpYUmhWSGx3WlQwOVhDSnVkVzFpWlhKY0lpbGNibHgwWEhSN1hHNWNkRngwWEhScFppaHBibkIxZEZSNWNHVTlQVndpY21GdVoyVXRiblZ0WW1WeVhDSXBYRzVjZEZ4MFhIUjdYRzVjZEZ4MFhIUmNkQ1JtYVdWc1pDQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJaTV6WmkxdFpYUmhMWEpoYm1kbExXNTFiV0psY2lCcGJuQjFkRndpS1R0Y2JseDBYSFJjZEZ4MFhHNWNkRngwWEhSY2RIWmhjaUIyWVd4MVpYTWdQU0JiWFR0Y2JseDBYSFJjZEZ4MEpHWnBaV3hrTG1WaFkyZ29ablZ1WTNScGIyNG9LWHRjYmx4MFhIUmNkRngwWEhSY2JseDBYSFJjZEZ4MFhIUjJZV3gxWlhNdWNIVnphQ2drS0hSb2FYTXBMblpoYkNncEtUdGNibHgwWEhSY2RGeDBYRzVjZEZ4MFhIUmNkSDBwTzF4dVhIUmNkRngwWEhSY2JseDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQjJZV3gxWlhNdWFtOXBiaWhjSWl0Y0lpazdYRzVjZEZ4MFhIUmNkRnh1WEhSY2RGeDBmVnh1WEhSY2RGeDBaV3h6WlNCcFppaHBibkIxZEZSNWNHVTlQVndpY21GdVoyVXRjMnhwWkdWeVhDSXBYRzVjZEZ4MFhIUjdYRzVjZEZ4MFhIUmNkQ1JtYVdWc1pDQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJaTV6WmkxdFpYUmhMWEpoYm1kbExYTnNhV1JsY2lCcGJuQjFkRndpS1R0Y2JseDBYSFJjZEZ4MFhHNWNkRngwWEhSY2RDOHZaMlYwSUdGdWVTQnVkVzFpWlhJZ1ptOXliV0YwZEdsdVp5QnpkSFZtWmx4dVhIUmNkRngwWEhSMllYSWdKRzFsZEdGZmNtRnVaMlVnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENJdWMyWXRiV1YwWVMxeVlXNW5aUzF6Ykdsa1pYSmNJaWs3WEc1Y2RGeDBYSFJjZEZ4dVhIUmNkRngwWEhSMllYSWdaR1ZqYVcxaGJGOXdiR0ZqWlhNZ1BTQWtiV1YwWVY5eVlXNW5aUzVoZEhSeUtGd2laR0YwWVMxa1pXTnBiV0ZzTFhCc1lXTmxjMXdpS1R0Y2JseDBYSFJjZEZ4MGRtRnlJSFJvYjNWellXNWtYM05sY0dWeVlYUnZjaUE5SUNSdFpYUmhYM0poYm1kbExtRjBkSElvWENKa1lYUmhMWFJvYjNWellXNWtMWE5sY0dWeVlYUnZjbHdpS1R0Y2JseDBYSFJjZEZ4MGRtRnlJR1JsWTJsdFlXeGZjMlZ3WlhKaGRHOXlJRDBnSkcxbGRHRmZjbUZ1WjJVdVlYUjBjaWhjSW1SaGRHRXRaR1ZqYVcxaGJDMXpaWEJsY21GMGIzSmNJaWs3WEc1Y2JseDBYSFJjZEZ4MGRtRnlJR1pwWld4a1gyWnZjbTFoZENBOUlIZE9kVzFpS0h0Y2JseDBYSFJjZEZ4MFhIUnRZWEpyT2lCa1pXTnBiV0ZzWDNObGNHVnlZWFJ2Y2l4Y2JseDBYSFJjZEZ4MFhIUmtaV05wYldGc2N6b2djR0Z5YzJWR2JHOWhkQ2hrWldOcGJXRnNYM0JzWVdObGN5a3NYRzVjZEZ4MFhIUmNkRngwZEdodmRYTmhibVE2SUhSb2IzVnpZVzVrWDNObGNHVnlZWFJ2Y2x4dVhIUmNkRngwWEhSOUtUdGNibHgwWEhSY2RGeDBYRzVjZEZ4MFhIUmNkSFpoY2lCMllXeDFaWE1nUFNCYlhUdGNibHh1WEc1Y2RGeDBYSFJjZEhaaGNpQnpiR2xrWlhKZmIySnFaV04wSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aUxtMWxkR0V0YzJ4cFpHVnlYQ0lwV3pCZE8xeHVYSFJjZEZ4MFhIUXZMM1poYkNCbWNtOXRJSE5zYVdSbGNpQnZZbXBsWTNSY2JseDBYSFJjZEZ4MGRtRnlJSE5zYVdSbGNsOTJZV3dnUFNCemJHbGtaWEpmYjJKcVpXTjBMbTV2VldsVGJHbGtaWEl1WjJWMEtDazdYRzVjYmx4MFhIUmNkRngwZG1Gc2RXVnpMbkIxYzJnb1ptbGxiR1JmWm05eWJXRjBMbVp5YjIwb2MyeHBaR1Z5WDNaaGJGc3dYU2twTzF4dVhIUmNkRngwWEhSMllXeDFaWE11Y0hWemFDaG1hV1ZzWkY5bWIzSnRZWFF1Wm5KdmJTaHpiR2xrWlhKZmRtRnNXekZkS1NrN1hHNWNkRngwWEhSY2RGeHVYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJSFpoYkhWbGN5NXFiMmx1S0Z3aUsxd2lLVHRjYmx4MFhIUmNkRngwWEc1Y2RGeDBYSFJjZEdacFpXeGtUbUZ0WlNBOUlDUnRaWFJoWDNKaGJtZGxMbUYwZEhJb1hDSmtZWFJoTFhObUxXWnBaV3hrTFc1aGJXVmNJaWs3WEc1Y2RGeDBYSFJjZEZ4dVhIUmNkRngwWEhSY2JseDBYSFJjZEgxY2JseDBYSFJjZEdWc2MyVWdhV1lvYVc1d2RYUlVlWEJsUFQxY0luSmhibWRsTFhKaFpHbHZYQ0lwWEc1Y2RGeDBYSFI3WEc1Y2RGeDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSWk1elppMXBibkIxZEMxeVlXNW5aUzF5WVdScGIxd2lLVHRjYmx4MFhIUmNkRngwWEc1Y2RGeDBYSFJjZEdsbUtDUm1hV1ZzWkM1c1pXNW5kR2c5UFRBcFhHNWNkRngwWEhSY2RIdGNibHgwWEhSY2RGeDBYSFF2TDNSb1pXNGdkSEo1SUdGbllXbHVMQ0IzWlNCdGRYTjBJR0psSUhWemFXNW5JR0VnYzJsdVoyeGxJR1pwWld4a1hHNWNkRngwWEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2lQaUIxYkZ3aUtUdGNibHgwWEhSY2RGeDBmVnh1WEc1Y2RGeDBYSFJjZEhaaGNpQWtiV1YwWVY5eVlXNW5aU0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSWk1elppMXRaWFJoTFhKaGJtZGxYQ0lwTzF4dVhIUmNkRngwWEhSY2JseDBYSFJjZEZ4MEx5OTBhR1Z5WlNCcGN5QmhiaUJsYkdWdFpXNTBJSGRwZEdnZ1lTQm1jbTl0TDNSdklHTnNZWE56SUMwZ2MyOGdkMlVnYm1WbFpDQjBieUJuWlhRZ2RHaGxJSFpoYkhWbGN5QnZaaUIwYUdVZ1puSnZiU0FtSUhSdklHbHVjSFYwSUdacFpXeGtjeUJ6WlhCbGNtRjBaV3g1WEc1Y2RGeDBYSFJjZEdsbUtDUm1hV1ZzWkM1c1pXNW5kR2crTUNsY2JseDBYSFJjZEZ4MGUxeDBYRzVjZEZ4MFhIUmNkRngwZG1GeUlHWnBaV3hrWDNaaGJITWdQU0JiWFR0Y2JseDBYSFJjZEZ4MFhIUmNibHgwWEhSY2RGeDBYSFFrWm1sbGJHUXVaV0ZqYUNobWRXNWpkR2x2YmlncGUxeHVYSFJjZEZ4MFhIUmNkRngwWEc1Y2RGeDBYSFJjZEZ4MFhIUjJZWElnSkhKaFpHbHZjeUE5SUNRb2RHaHBjeWt1Wm1sdVpDaGNJaTV6WmkxcGJuQjFkQzF5WVdScGIxd2lLVHRjYmx4MFhIUmNkRngwWEhSY2RHWnBaV3hrWDNaaGJITXVjSFZ6YUNoelpXeG1MbWRsZEUxbGRHRlNZV1JwYjFaaGJDZ2tjbUZrYVc5ektTazdYRzVjZEZ4MFhIUmNkRngwWEhSY2JseDBYSFJjZEZ4MFhIUjlLVHRjYmx4MFhIUmNkRngwWEhSY2JseDBYSFJjZEZ4MFhIUXZMM0J5WlhabGJuUWdjMlZqYjI1a0lHNTFiV0psY2lCbWNtOXRJR0psYVc1bklHeHZkMlZ5SUhSb1lXNGdkR2hsSUdacGNuTjBYRzVjZEZ4MFhIUmNkRngwYVdZb1ptbGxiR1JmZG1Gc2N5NXNaVzVuZEdnOVBUSXBYRzVjZEZ4MFhIUmNkRngwZTF4dVhIUmNkRngwWEhSY2RGeDBhV1lvVG5WdFltVnlLR1pwWld4a1gzWmhiSE5iTVYwcFBFNTFiV0psY2lobWFXVnNaRjkyWVd4eld6QmRLU2xjYmx4MFhIUmNkRngwWEhSY2RIdGNibHgwWEhSY2RGeDBYSFJjZEZ4MFptbGxiR1JmZG1Gc2Mxc3hYU0E5SUdacFpXeGtYM1poYkhOYk1GMDdYRzVjZEZ4MFhIUmNkRngwWEhSOVhHNWNkRngwWEhSY2RGeDBmVnh1WEhSY2RGeDBYSFJjZEZ4dVhIUmNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdabWxsYkdSZmRtRnNjeTVxYjJsdUtGd2lLMXdpS1R0Y2JseDBYSFJjZEZ4MGZWeHVYSFJjZEZ4MFhIUmNkRngwWEhSY2RGeHVYSFJjZEZ4MFhIUnBaaWdrWm1sbGJHUXViR1Z1WjNSb1BUMHhLVnh1WEhSY2RGeDBYSFI3WEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JPWVcxbElEMGdKR1pwWld4a0xtWnBibVFvWENJdWMyWXRhVzV3ZFhRdGNtRmthVzljSWlrdVlYUjBjaWhjSW01aGJXVmNJaWt1Y21Wd2JHRmpaU2duVzEwbkxDQW5KeWs3WEc1Y2RGeDBYSFJjZEgxY2JseDBYSFJjZEZ4MFpXeHpaVnh1WEhSY2RGeDBYSFI3WEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JPWVcxbElEMGdKRzFsZEdGZmNtRnVaMlV1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGJtRnRaVndpS1R0Y2JseDBYSFJjZEZ4MGZWeHVYRzVjZEZ4MFhIUjlYRzVjZEZ4MFhIUmxiSE5sSUdsbUtHbHVjSFYwVkhsd1pUMDlYQ0p5WVc1blpTMXpaV3hsWTNSY0lpbGNibHgwWEhSY2RIdGNibHgwWEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2lMbk5tTFdsdWNIVjBMWE5sYkdWamRGd2lLVHRjYmx4MFhIUmNkRngwZG1GeUlDUnRaWFJoWDNKaGJtZGxJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpTG5ObUxXMWxkR0V0Y21GdVoyVmNJaWs3WEc1Y2RGeDBYSFJjZEZ4dVhIUmNkRngwWEhRdkwzUm9aWEpsSUdseklHRnVJR1ZzWlcxbGJuUWdkMmwwYUNCaElHWnliMjB2ZEc4Z1kyeGhjM01nTFNCemJ5QjNaU0J1WldWa0lIUnZJR2RsZENCMGFHVWdkbUZzZFdWeklHOW1JSFJvWlNCbWNtOXRJQ1lnZEc4Z2FXNXdkWFFnWm1sbGJHUnpJSE5sY0dWeVlYUmxiSGxjYmx4MFhIUmNkRngwWEc1Y2RGeDBYSFJjZEdsbUtDUm1hV1ZzWkM1c1pXNW5kR2crTUNsY2JseDBYSFJjZEZ4MGUxeHVYSFJjZEZ4MFhIUmNkSFpoY2lCbWFXVnNaRjkyWVd4eklEMGdXMTA3WEc1Y2RGeDBYSFJjZEZ4MFhHNWNkRngwWEhSY2RGeDBKR1pwWld4a0xtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2JseDBYSFJjZEZ4MFhIUmNkRnh1WEhSY2RGeDBYSFJjZEZ4MGRtRnlJQ1IwYUdseklEMGdKQ2gwYUdsektUdGNibHgwWEhSY2RGeDBYSFJjZEdacFpXeGtYM1poYkhNdWNIVnphQ2h6Wld4bUxtZGxkRTFsZEdGVFpXeGxZM1JXWVd3b0pIUm9hWE1wS1R0Y2JseDBYSFJjZEZ4MFhIUmNkRnh1WEhSY2RGeDBYSFJjZEgwcE8xeHVYSFJjZEZ4MFhIUmNkRnh1WEhSY2RGeDBYSFJjZEM4dmNISmxkbVZ1ZENCelpXTnZibVFnYm5WdFltVnlJR1p5YjIwZ1ltVnBibWNnYkc5M1pYSWdkR2hoYmlCMGFHVWdabWx5YzNSY2JseDBYSFJjZEZ4MFhIUnBaaWhtYVdWc1pGOTJZV3h6TG14bGJtZDBhRDA5TWlsY2JseDBYSFJjZEZ4MFhIUjdYRzVjZEZ4MFhIUmNkRngwWEhScFppaE9kVzFpWlhJb1ptbGxiR1JmZG1Gc2Mxc3hYU2s4VG5WdFltVnlLR1pwWld4a1gzWmhiSE5iTUYwcEtWeHVYSFJjZEZ4MFhIUmNkRngwZTF4dVhIUmNkRngwWEhSY2RGeDBYSFJtYVdWc1pGOTJZV3h6V3pGZElEMGdabWxsYkdSZmRtRnNjMXN3WFR0Y2JseDBYSFJjZEZ4MFhIUmNkSDFjYmx4MFhIUmNkRngwWEhSOVhHNWNkRngwWEhSY2RGeDBYRzVjZEZ4MFhIUmNkRngwWEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQm1hV1ZzWkY5MllXeHpMbXB2YVc0b1hDSXJYQ0lwTzF4dVhIUmNkRngwWEhSOVhHNWNkRngwWEhSY2RGeDBYSFJjZEZ4MFhHNWNkRngwWEhSY2RHbG1LQ1JtYVdWc1pDNXNaVzVuZEdnOVBURXBYRzVjZEZ4MFhIUmNkSHRjYmx4MFhIUmNkRngwWEhSbWFXVnNaRTVoYldVZ1BTQWtabWxsYkdRdVlYUjBjaWhjSW01aGJXVmNJaWt1Y21Wd2JHRmpaU2duVzEwbkxDQW5KeWs3WEc1Y2RGeDBYSFJjZEgxY2JseDBYSFJjZEZ4MFpXeHpaVnh1WEhSY2RGeDBYSFI3WEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JPWVcxbElEMGdKRzFsZEdGZmNtRnVaMlV1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGJtRnRaVndpS1R0Y2JseDBYSFJjZEZ4MGZWeHVYSFJjZEZ4MFhIUmNibHgwWEhSY2RIMWNibHgwWEhSY2RHVnNjMlVnYVdZb2FXNXdkWFJVZVhCbFBUMWNJbkpoYm1kbExXTm9aV05yWW05NFhDSXBYRzVjZEZ4MFhIUjdYRzVjZEZ4MFhIUmNkQ1JtYVdWc1pDQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJblZzSUQ0Z2JHa2dhVzV3ZFhRNlkyaGxZMnRpYjNoY0lpazdYRzVjZEZ4MFhIUmNkRnh1WEhSY2RGeDBYSFJwWmlna1ptbGxiR1F1YkdWdVozUm9QakFwWEc1Y2RGeDBYSFJjZEh0Y2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJSE5sYkdZdVoyVjBRMmhsWTJ0aWIzaFdZV3dvSkdacFpXeGtMQ0JjSW1GdVpGd2lLVHRjYmx4MFhIUmNkRngwZlZ4dVhIUmNkRngwZlZ4dVhIUmNkRngwWEc1Y2RGeDBYSFJwWmlobWFXVnNaRTVoYldVOVBWd2lYQ0lwWEc1Y2RGeDBYSFI3WEc1Y2RGeDBYSFJjZEdacFpXeGtUbUZ0WlNBOUlDUm1hV1ZzWkM1aGRIUnlLRndpYm1GdFpWd2lLUzV5WlhCc1lXTmxLQ2RiWFNjc0lDY25LVHRjYmx4MFhIUmNkSDFjYmx4MFhIUjlYRzVjZEZ4MFpXeHpaU0JwWmlodFpYUmhWSGx3WlQwOVhDSmphRzlwWTJWY0lpbGNibHgwWEhSN1hHNWNkRngwWEhScFppaHBibkIxZEZSNWNHVTlQVndpYzJWc1pXTjBYQ0lwWEc1Y2RGeDBYSFI3WEc1Y2RGeDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5ObGJHVmpkRndpS1R0Y2JseDBYSFJjZEZ4MFhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUk5aWFJoVTJWc1pXTjBWbUZzS0NSbWFXVnNaQ2s3SUZ4dVhIUmNkRngwWEhSY2JseDBYSFJjZEgxY2JseDBYSFJjZEdWc2MyVWdhV1lvYVc1d2RYUlVlWEJsUFQxY0ltMTFiSFJwYzJWc1pXTjBYQ0lwWEc1Y2RGeDBYSFI3WEc1Y2RGeDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5ObGJHVmpkRndpS1R0Y2JseDBYSFJjZEZ4MGRtRnlJRzl3WlhKaGRHOXlJRDBnSkdacFpXeGtMbUYwZEhJb1hDSmtZWFJoTFc5d1pYSmhkRzl5WENJcE8xeHVYSFJjZEZ4MFhIUmNibHgwWEhSY2RGeDBabWxsYkdSV1lXd2dQU0J6Wld4bUxtZGxkRTFsZEdGTmRXeDBhVk5sYkdWamRGWmhiQ2drWm1sbGJHUXNJRzl3WlhKaGRHOXlLVHRjYmx4MFhIUmNkSDFjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9hVzV3ZFhSVWVYQmxQVDFjSW1Ob1pXTnJZbTk0WENJcFhHNWNkRngwWEhSN1hHNWNkRngwWEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0luVnNJRDRnYkdrZ2FXNXdkWFE2WTJobFkydGliM2hjSWlrN1hHNWNkRngwWEhSY2RGeHVYSFJjZEZ4MFhIUnBaaWdrWm1sbGJHUXViR1Z1WjNSb1BqQXBYRzVjZEZ4MFhIUmNkSHRjYmx4MFhIUmNkRngwWEhSMllYSWdiM0JsY21GMGIzSWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0krSUhWc1hDSXBMbUYwZEhJb1hDSmtZWFJoTFc5d1pYSmhkRzl5WENJcE8xeHVYSFJjZEZ4MFhIUmNkR1pwWld4a1ZtRnNJRDBnYzJWc1ppNW5aWFJOWlhSaFEyaGxZMnRpYjNoV1lXd29KR1pwWld4a0xDQnZjR1Z5WVhSdmNpazdYRzVjZEZ4MFhIUmNkSDFjYmx4MFhIUmNkSDFjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9hVzV3ZFhSVWVYQmxQVDFjSW5KaFpHbHZYQ0lwWEc1Y2RGeDBYSFI3WEc1Y2RGeDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5Wc0lENGdiR2tnYVc1d2RYUTZjbUZrYVc5Y0lpazdYRzVjZEZ4MFhIUmNkRnh1WEhSY2RGeDBYSFJwWmlna1ptbGxiR1F1YkdWdVozUm9QakFwWEc1Y2RGeDBYSFJjZEh0Y2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJSE5sYkdZdVoyVjBUV1YwWVZKaFpHbHZWbUZzS0NSbWFXVnNaQ2s3WEc1Y2RGeDBYSFJjZEgxY2JseDBYSFJjZEgxY2JseDBYSFJjZEZ4dVhIUmNkRngwWm1sbGJHUldZV3dnUFNCbGJtTnZaR1ZWVWtsRGIyMXdiMjVsYm5Rb1ptbGxiR1JXWVd3cE8xeHVYSFJjZEZ4MGFXWW9kSGx3Wlc5bUtDUm1hV1ZzWkNraFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4dVhIUmNkRngwZTF4dVhIUmNkRngwWEhScFppZ2tabWxsYkdRdWJHVnVaM1JvUGpBcFhHNWNkRngwWEhSY2RIdGNibHgwWEhSY2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbTVoYldWY0lpa3VjbVZ3YkdGalpTZ25XMTBuTENBbkp5azdYRzVjZEZ4MFhIUmNkRngwWEc1Y2RGeDBYSFJjZEZ4MEx5OW1iM0lnZEdodmMyVWdkMmh2SUdsdWMybHpkQ0J2YmlCMWMybHVaeUFtSUdGdGNHVnljMkZ1WkhNZ2FXNGdkR2hsSUc1aGJXVWdiMllnZEdobElHTjFjM1J2YlNCbWFXVnNaQ0FvSVNsY2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkU1aGJXVWdQU0FvWm1sbGJHUk9ZVzFsS1R0Y2JseDBYSFJjZEZ4MGZWeHVYSFJjZEZ4MGZWeHVYSFJjZEZ4MFhHNWNkRngwZlZ4dVhIUmNkR1ZzYzJVZ2FXWW9iV1YwWVZSNWNHVTlQVndpWkdGMFpWd2lLVnh1WEhSY2RIdGNibHgwWEhSY2RITmxiR1l1Y0hKdlkyVnpjMUJ2YzNSRVlYUmxLQ1JqYjI1MFlXbHVaWElwTzF4dVhIUmNkSDFjYmx4MFhIUmNibHgwWEhScFppaDBlWEJsYjJZb1ptbGxiR1JXWVd3cElUMWNJblZ1WkdWbWFXNWxaRndpS1Z4dVhIUmNkSHRjYmx4MFhIUmNkR2xtS0dacFpXeGtWbUZzSVQxY0lsd2lLVnh1WEhSY2RGeDBlMXh1WEhSY2RGeDBYSFF2TDNObGJHWXVkWEpzWDJOdmJYQnZibVZ1ZEhNZ0t6MGdYQ0ltWENJclpXNWpiMlJsVlZKSlEyOXRjRzl1Wlc1MEtHWnBaV3hrVG1GdFpTa3JYQ0k5WENJcktHWnBaV3hrVm1Gc0tUdGNibHgwWEhSY2RGeDBjMlZzWmk1MWNteGZjR0Z5WVcxelcyVnVZMjlrWlZWU1NVTnZiWEJ2Ym1WdWRDaG1hV1ZzWkU1aGJXVXBYU0E5SUNobWFXVnNaRlpoYkNrN1hHNWNkRngwWEhSOVhHNWNkRngwZlZ4dVhIUjlMRnh1WEhSd2NtOWpaWE56VUc5emRFUmhkR1U2SUdaMWJtTjBhVzl1S0NSamIyNTBZV2x1WlhJcFhHNWNkSHRjYmx4MFhIUjJZWElnYzJWc1ppQTlJSFJvYVhNN1hHNWNkRngwWEc1Y2RGeDBkbUZ5SUdacFpXeGtWSGx3WlNBOUlDUmpiMjUwWVdsdVpYSXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0ZEhsd1pWd2lLVHRjYmx4MFhIUjJZWElnYVc1d2RYUlVlWEJsSUQwZ0pHTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzFwYm5CMWRDMTBlWEJsWENJcE8xeHVYSFJjZEZ4dVhIUmNkSFpoY2lBa1ptbGxiR1E3WEc1Y2RGeDBkbUZ5SUdacFpXeGtUbUZ0WlNBOUlGd2lYQ0k3WEc1Y2RGeDBkbUZ5SUdacFpXeGtWbUZzSUQwZ1hDSmNJanRjYmx4MFhIUmNibHgwWEhRa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENKMWJDQStJR3hwSUdsdWNIVjBPblJsZUhSY0lpazdYRzVjZEZ4MFptbGxiR1JPWVcxbElEMGdKR1pwWld4a0xtRjBkSElvWENKdVlXMWxYQ0lwTG5KbGNHeGhZMlVvSjF0ZEp5d2dKeWNwTzF4dVhIUmNkRnh1WEhSY2RIWmhjaUJrWVhSbGN5QTlJRnRkTzF4dVhIUmNkQ1JtYVdWc1pDNWxZV05vS0daMWJtTjBhVzl1S0NsN1hHNWNkRngwWEhSY2JseDBYSFJjZEdSaGRHVnpMbkIxYzJnb0pDaDBhR2x6S1M1MllXd29LU2s3WEc1Y2RGeDBYRzVjZEZ4MGZTazdYRzVjZEZ4MFhHNWNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDA5TWlsY2JseDBYSFI3WEc1Y2RGeDBYSFJwWmlnb1pHRjBaWE5iTUYwaFBWd2lYQ0lwZkh3b1pHRjBaWE5iTVYwaFBWd2lYQ0lwS1Z4dVhIUmNkRngwZTF4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlHUmhkR1Z6TG1wdmFXNG9YQ0lyWENJcE8xeHVYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJR1pwWld4a1ZtRnNMbkpsY0d4aFkyVW9MMXhjTHk5bkxDY25LVHRjYmx4MFhIUmNkSDFjYmx4MFhIUjlYRzVjZEZ4MFpXeHpaU0JwWmlna1ptbGxiR1F1YkdWdVozUm9QVDB4S1Z4dVhIUmNkSHRjYmx4MFhIUmNkR2xtS0dSaGRHVnpXekJkSVQxY0lsd2lLVnh1WEhSY2RGeDBlMXh1WEhSY2RGeDBYSFJtYVdWc1pGWmhiQ0E5SUdSaGRHVnpMbXB2YVc0b1hDSXJYQ0lwTzF4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlHWnBaV3hrVm1Gc0xuSmxjR3hoWTJVb0wxeGNMeTluTENjbktUdGNibHgwWEhSY2RIMWNibHgwWEhSOVhHNWNkRngwWEc1Y2RGeDBhV1lvZEhsd1pXOW1LR1pwWld4a1ZtRnNLU0U5WENKMWJtUmxabWx1WldSY0lpbGNibHgwWEhSN1hHNWNkRngwWEhScFppaG1hV1ZzWkZaaGJDRTlYQ0pjSWlsY2JseDBYSFJjZEh0Y2JseDBYSFJjZEZ4MGRtRnlJR1pwWld4a1UyeDFaeUE5SUZ3aVhDSTdYRzVjZEZ4MFhIUmNkRnh1WEhSY2RGeDBYSFJwWmlobWFXVnNaRTVoYldVOVBWd2lYM05tWDNCdmMzUmZaR0YwWlZ3aUtWeHVYSFJjZEZ4MFhIUjdYRzVjZEZ4MFhIUmNkRngwWm1sbGJHUlRiSFZuSUQwZ1hDSndiM04wWDJSaGRHVmNJanRjYmx4MFhIUmNkRngwZlZ4dVhIUmNkRngwWEhSbGJITmxYRzVjZEZ4MFhIUmNkSHRjYmx4MFhIUmNkRngwWEhSbWFXVnNaRk5zZFdjZ1BTQm1hV1ZzWkU1aGJXVTdYRzVjZEZ4MFhIUmNkSDFjYmx4MFhIUmNkRngwWEc1Y2RGeDBYSFJjZEdsbUtHWnBaV3hrVTJ4MVp5RTlYQ0pjSWlsY2JseDBYSFJjZEZ4MGUxeHVYSFJjZEZ4MFhIUmNkQzh2YzJWc1ppNTFjbXhmWTI5dGNHOXVaVzUwY3lBclBTQmNJaVpjSWl0bWFXVnNaRk5zZFdjclhDSTlYQ0lyWm1sbGJHUldZV3c3WEc1Y2RGeDBYSFJjZEZ4MGMyVnNaaTUxY214ZmNHRnlZVzF6VzJacFpXeGtVMngxWjEwZ1BTQm1hV1ZzWkZaaGJEdGNibHgwWEhSY2RGeDBmVnh1WEhSY2RGeDBmVnh1WEhSY2RIMWNibHgwWEhSY2JseDBmU3hjYmx4MGNISnZZMlZ6YzFSaGVHOXViMjE1T2lCbWRXNWpkR2x2Ymlna1kyOXVkR0ZwYm1WeUxDQnlaWFIxY201ZmIySnFaV04wS1Z4dVhIUjdYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWh5WlhSMWNtNWZiMkpxWldOMEtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2JpQWdJQ0FnSUNBZ2UxeHVJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVYMjlpYW1WamRDQTlJR1poYkhObE8xeHVJQ0FnSUNBZ0lDQjlYRzVjYmx4MFhIUXZMMmxtS0NsY2RGeDBYSFJjZEZ4MFhHNWNkRngwTHk5MllYSWdabWxsYkdST1lXMWxJRDBnSkNoMGFHbHpLUzVoZEhSeUtGd2laR0YwWVMxelppMW1hV1ZzWkMxdVlXMWxYQ0lwTzF4dVhIUmNkSFpoY2lCelpXeG1JRDBnZEdocGN6dGNibHgwWEc1Y2RGeDBkbUZ5SUdacFpXeGtWSGx3WlNBOUlDUmpiMjUwWVdsdVpYSXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0ZEhsd1pWd2lLVHRjYmx4MFhIUjJZWElnYVc1d2RYUlVlWEJsSUQwZ0pHTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzFwYm5CMWRDMTBlWEJsWENJcE8xeHVYSFJjZEZ4dVhIUmNkSFpoY2lBa1ptbGxiR1E3WEc1Y2RGeDBkbUZ5SUdacFpXeGtUbUZ0WlNBOUlGd2lYQ0k3WEc1Y2RGeDBkbUZ5SUdacFpXeGtWbUZzSUQwZ1hDSmNJanRjYmx4MFhIUmNibHgwWEhScFppaHBibkIxZEZSNWNHVTlQVndpYzJWc1pXTjBYQ0lwWEc1Y2RGeDBlMXh1WEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2ljMlZzWldOMFhDSXBPMXh1WEhSY2RGeDBabWxsYkdST1lXMWxJRDBnSkdacFpXeGtMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHVYSFJjZEZ4MFhHNWNkRngwWEhSbWFXVnNaRlpoYkNBOUlITmxiR1l1WjJWMFUyVnNaV04wVm1Gc0tDUm1hV1ZzWkNrN0lGeHVYSFJjZEgxY2JseDBYSFJsYkhObElHbG1LR2x1Y0hWMFZIbHdaVDA5WENKdGRXeDBhWE5sYkdWamRGd2lLVnh1WEhSY2RIdGNibHgwWEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0luTmxiR1ZqZEZ3aUtUdGNibHgwWEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2JseDBYSFJjZEhaaGNpQnZjR1Z5WVhSdmNpQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aVpHRjBZUzF2Y0dWeVlYUnZjbHdpS1R0Y2JseDBYSFJjZEZ4dVhIUmNkRngwWm1sbGJHUldZV3dnUFNCelpXeG1MbWRsZEUxMWJIUnBVMlZzWldOMFZtRnNLQ1JtYVdWc1pDd2diM0JsY21GMGIzSXBPMXh1WEhSY2RIMWNibHgwWEhSbGJITmxJR2xtS0dsdWNIVjBWSGx3WlQwOVhDSmphR1ZqYTJKdmVGd2lLVnh1WEhSY2RIdGNibHgwWEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0luVnNJRDRnYkdrZ2FXNXdkWFE2WTJobFkydGliM2hjSWlrN1hHNWNkRngwWEhScFppZ2tabWxsYkdRdWJHVnVaM1JvUGpBcFhHNWNkRngwWEhSN1hHNWNkRngwWEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2JseDBYSFJjZEZ4MFhIUmNkRngwWEhSY2RGeDBYRzVjZEZ4MFhIUmNkSFpoY2lCdmNHVnlZWFJ2Y2lBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0lqNGdkV3hjSWlrdVlYUjBjaWhjSW1SaGRHRXRiM0JsY21GMGIzSmNJaWs3WEc1Y2RGeDBYSFJjZEdacFpXeGtWbUZzSUQwZ2MyVnNaaTVuWlhSRGFHVmphMkp2ZUZaaGJDZ2tabWxsYkdRc0lHOXdaWEpoZEc5eUtUdGNibHgwWEhSY2RIMWNibHgwWEhSOVhHNWNkRngwWld4elpTQnBaaWhwYm5CMWRGUjVjR1U5UFZ3aWNtRmthVzljSWlsY2JseDBYSFI3WEc1Y2RGeDBYSFFrWm1sbGJHUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0oxYkNBK0lHeHBJR2x1Y0hWME9uSmhaR2x2WENJcE8xeHVYSFJjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQ0d0tWeHVYSFJjZEZ4MGUxeHVYSFJjZEZ4MFhIUm1hV1ZzWkU1aGJXVWdQU0FrWm1sbGJHUXVZWFIwY2loY0ltNWhiV1ZjSWlrdWNtVndiR0ZqWlNnblcxMG5MQ0FuSnlrN1hHNWNkRngwWEhSY2RGeHVYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJSE5sYkdZdVoyVjBVbUZrYVc5V1lXd29KR1pwWld4a0tUdGNibHgwWEhSY2RIMWNibHgwWEhSOVhHNWNkRngwWEc1Y2RGeDBhV1lvZEhsd1pXOW1LR1pwWld4a1ZtRnNLU0U5WENKMWJtUmxabWx1WldSY0lpbGNibHgwWEhSN1hHNWNkRngwWEhScFppaG1hV1ZzWkZaaGJDRTlYQ0pjSWlsY2JseDBYSFJjZEh0Y2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHlaWFIxY201ZmIySnFaV04wUFQxMGNuVmxLVnh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUh0dVlXMWxPaUJtYVdWc1pFNWhiV1VzSUhaaGJIVmxPaUJtYVdWc1pGWmhiSDA3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyVnNaaTUxY214ZlkyOXRjRzl1Wlc1MGN5QXJQU0JjSWlaY0lpdG1hV1ZzWkU1aGJXVXJYQ0k5WENJclptbGxiR1JXWVd3N1hHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRYSnNYM0JoY21GdGMxdG1hV1ZzWkU1aGJXVmRJRDBnWm1sbGJHUldZV3c3WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4dVhHNWNkRngwWEhSOVhHNWNkRngwZlZ4dVhHNGdJQ0FnSUNBZ0lHbG1LSEpsZEhWeWJsOXZZbXBsWTNROVBYUnlkV1VwWEc0Z0lDQWdJQ0FnSUh0Y2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQm1ZV3h6WlR0Y2JpQWdJQ0FnSUNBZ2ZWeHVYSFI5WEc1OU95SmRmUT09IiwiXG5tb2R1bGUuZXhwb3J0cyA9IHtcblx0XG5cdHNlYXJjaEZvcm1zOiB7fSxcblx0XG5cdGluaXQ6IGZ1bmN0aW9uKCl7XG5cdFx0XG5cdFx0XG5cdH0sXG5cdGFkZFNlYXJjaEZvcm06IGZ1bmN0aW9uKGlkLCBvYmplY3Qpe1xuXHRcdFxuXHRcdHRoaXMuc2VhcmNoRm9ybXNbaWRdID0gb2JqZWN0O1xuXHR9LFxuXHRnZXRTZWFyY2hGb3JtOiBmdW5jdGlvbihpZClcblx0e1xuXHRcdHJldHVybiB0aGlzLnNlYXJjaEZvcm1zW2lkXTtcdFxuXHR9XG5cdFxufTsiLCIoZnVuY3Rpb24gKGdsb2JhbCl7XG5cbnZhciAkIFx0XHRcdFx0PSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xuXG5tb2R1bGUuZXhwb3J0cyA9IHtcblx0XG5cdGluaXQ6IGZ1bmN0aW9uKCl7XG5cdFx0JChkb2N1bWVudCkub24oXCJzZjphamF4ZmluaXNoXCIsIFwiLnNlYXJjaGFuZGZpbHRlclwiLCBmdW5jdGlvbiggZSwgZGF0YSApIHtcblx0XHRcdHZhciBkaXNwbGF5X21ldGhvZCA9IGRhdGEub2JqZWN0LmRpc3BsYXlfcmVzdWx0X21ldGhvZDtcblx0XHRcdGlmICggZGlzcGxheV9tZXRob2QgPT09ICdjdXN0b21fZWRkX3N0b3JlJyApIHtcblx0XHRcdFx0JCgnaW5wdXQuZWRkLWFkZC10by1jYXJ0JykuY3NzKCdkaXNwbGF5JywgXCJub25lXCIpO1xuXHRcdFx0XHQkKCdhLmVkZC1hZGQtdG8tY2FydCcpLmFkZENsYXNzKCdlZGQtaGFzLWpzJyk7XG5cdFx0XHR9IGVsc2UgaWYgKCBkaXNwbGF5X21ldGhvZCA9PT0gJ2N1c3RvbV9sYXlvdXRzJyApIHtcblx0XHRcdFx0aWYgKCAkKCcuY2wtbGF5b3V0JykuaGFzQ2xhc3MoICdjbC1sYXlvdXQtLW1hc29ucnknICkgKSB7XG5cdFx0XHRcdFx0Ly90aGVuIHJlLWluaXQgbWFzb25yeVxuXHRcdFx0XHRcdGNvbnN0IG1hc29ucnlDb250YWluZXIgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCAnLmNsLWxheW91dC0tbWFzb25yeScgKTtcblx0XHRcdFx0XHRpZiAoIG1hc29ucnlDb250YWluZXIubGVuZ3RoID4gMCApIHtcblx0XHRcdFx0XHRcdGNvbnN0IGN1c3RvbUxheW91dEdyaWQgPSBuZXcgTWFzb25yeSggJy5jbC1sYXlvdXQtLW1hc29ucnknLCB7XG5cdFx0XHRcdFx0XHRcdC8vIG9wdGlvbnMuLi5cblx0XHRcdFx0XHRcdFx0aXRlbVNlbGVjdG9yOiAnLmNsLWxheW91dF9faXRlbScsXG5cdFx0XHRcdFx0XHRcdC8vY29sdW1uV2lkdGg6IDMxOVxuXHRcdFx0XHRcdFx0XHRwZXJjZW50UG9zaXRpb246IHRydWUsXG5cdFx0XHRcdFx0XHRcdC8vZ3V0dGVyOiAxMCxcblx0XHRcdFx0XHRcdFx0dHJhbnNpdGlvbkR1cmF0aW9uOiAwLFxuXHRcdFx0XHRcdFx0fSApO1xuXHRcdFx0XHRcdFx0aW1hZ2VzTG9hZGVkKCBtYXNvbnJ5Q29udGFpbmVyICkub24oICdwcm9ncmVzcycsIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdFx0XHRjdXN0b21MYXlvdXRHcmlkLmxheW91dCgpO1xuXHRcdFx0XHRcdFx0fSApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH0pO1xuXHR9LFxuXG59O1xufSkuY2FsbCh0aGlzLHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWwgOiB0eXBlb2Ygc2VsZiAhPT0gXCJ1bmRlZmluZWRcIiA/IHNlbGYgOiB0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93IDoge30pXG4vLyMgc291cmNlTWFwcGluZ1VSTD1kYXRhOmFwcGxpY2F0aW9uL2pzb247Y2hhcnNldDp1dGYtODtiYXNlNjQsZXlKMlpYSnphVzl1SWpvekxDSnpiM1Z5WTJWeklqcGJJbk55WXk5d2RXSnNhV012WVhOelpYUnpMMnB6TDJsdVkyeDFaR1Z6TDNSb2FYSmtjR0Z5ZEhrdWFuTWlYU3dpYm1GdFpYTWlPbHRkTENKdFlYQndhVzVuY3lJNklqdEJRVUZCTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQklpd2labWxzWlNJNkltZGxibVZ5WVhSbFpDNXFjeUlzSW5OdmRYSmpaVkp2YjNRaU9pSWlMQ0p6YjNWeVkyVnpRMjl1ZEdWdWRDSTZXeUpjYm5aaGNpQWtJRngwWEhSY2RGeDBQU0FvZEhsd1pXOW1JSGRwYm1SdmR5QWhQVDBnWENKMWJtUmxabWx1WldSY0lpQS9JSGRwYm1SdmQxc25hbEYxWlhKNUoxMGdPaUIwZVhCbGIyWWdaMnh2WW1Gc0lDRTlQU0JjSW5WdVpHVm1hVzVsWkZ3aUlEOGdaMnh2WW1Gc1d5ZHFVWFZsY25rblhTQTZJRzUxYkd3cE8xeHVYRzV0YjJSMWJHVXVaWGh3YjNKMGN5QTlJSHRjYmx4MFhHNWNkR2x1YVhRNklHWjFibU4wYVc5dUtDbDdYRzVjZEZ4MEpDaGtiMk4xYldWdWRDa3ViMjRvWENKelpqcGhhbUY0Wm1sdWFYTm9YQ0lzSUZ3aUxuTmxZWEpqYUdGdVpHWnBiSFJsY2x3aUxDQm1kVzVqZEdsdmJpZ2daU3dnWkdGMFlTQXBJSHRjYmx4MFhIUmNkSFpoY2lCa2FYTndiR0Y1WDIxbGRHaHZaQ0E5SUdSaGRHRXViMkpxWldOMExtUnBjM0JzWVhsZmNtVnpkV3gwWDIxbGRHaHZaRHRjYmx4MFhIUmNkR2xtSUNnZ1pHbHpjR3hoZVY5dFpYUm9iMlFnUFQwOUlDZGpkWE4wYjIxZlpXUmtYM04wYjNKbEp5QXBJSHRjYmx4MFhIUmNkRngwSkNnbmFXNXdkWFF1WldSa0xXRmtaQzEwYnkxallYSjBKeWt1WTNOektDZGthWE53YkdGNUp5d2dYQ0p1YjI1bFhDSXBPMXh1WEhSY2RGeDBYSFFrS0NkaExtVmtaQzFoWkdRdGRHOHRZMkZ5ZENjcExtRmtaRU5zWVhOektDZGxaR1F0YUdGekxXcHpKeWs3WEc1Y2RGeDBYSFI5SUdWc2MyVWdhV1lnS0NCa2FYTndiR0Y1WDIxbGRHaHZaQ0E5UFQwZ0oyTjFjM1J2YlY5c1lYbHZkWFJ6SnlBcElIdGNibHgwWEhSY2RGeDBhV1lnS0NBa0tDY3VZMnd0YkdGNWIzVjBKeWt1YUdGelEyeGhjM01vSUNkamJDMXNZWGx2ZFhRdExXMWhjMjl1Y25rbklDa2dLU0I3WEc1Y2RGeDBYSFJjZEZ4MEx5OTBhR1Z1SUhKbExXbHVhWFFnYldGemIyNXllVnh1WEhSY2RGeDBYSFJjZEdOdmJuTjBJRzFoYzI5dWNubERiMjUwWVdsdVpYSWdQU0JrYjJOMWJXVnVkQzV4ZFdWeWVWTmxiR1ZqZEc5eVFXeHNLQ0FuTG1Oc0xXeGhlVzkxZEMwdGJXRnpiMjV5ZVNjZ0tUdGNibHgwWEhSY2RGeDBYSFJwWmlBb0lHMWhjMjl1Y25sRGIyNTBZV2x1WlhJdWJHVnVaM1JvSUQ0Z01DQXBJSHRjYmx4MFhIUmNkRngwWEhSY2RHTnZibk4wSUdOMWMzUnZiVXhoZVc5MWRFZHlhV1FnUFNCdVpYY2dUV0Z6YjI1eWVTZ2dKeTVqYkMxc1lYbHZkWFF0TFcxaGMyOXVjbmtuTENCN1hHNWNkRngwWEhSY2RGeDBYSFJjZEM4dklHOXdkR2x2Ym5NdUxpNWNibHgwWEhSY2RGeDBYSFJjZEZ4MGFYUmxiVk5sYkdWamRHOXlPaUFuTG1Oc0xXeGhlVzkxZEY5ZmFYUmxiU2NzWEc1Y2RGeDBYSFJjZEZ4MFhIUmNkQzh2WTI5c2RXMXVWMmxrZEdnNklETXhPVnh1WEhSY2RGeDBYSFJjZEZ4MFhIUndaWEpqWlc1MFVHOXphWFJwYjI0NklIUnlkV1VzWEc1Y2RGeDBYSFJjZEZ4MFhIUmNkQzh2WjNWMGRHVnlPaUF4TUN4Y2JseDBYSFJjZEZ4MFhIUmNkRngwZEhKaGJuTnBkR2x2YmtSMWNtRjBhVzl1T2lBd0xGeHVYSFJjZEZ4MFhIUmNkRngwZlNBcE8xeHVYSFJjZEZ4MFhIUmNkRngwYVcxaFoyVnpURzloWkdWa0tDQnRZWE52Ym5KNVEyOXVkR0ZwYm1WeUlDa3ViMjRvSUNkd2NtOW5jbVZ6Y3ljc0lHWjFibU4wYVc5dUtDa2dlMXh1WEhSY2RGeDBYSFJjZEZ4MFhIUmpkWE4wYjIxTVlYbHZkWFJIY21sa0xteGhlVzkxZENncE8xeHVYSFJjZEZ4MFhIUmNkRngwZlNBcE8xeHVYSFJjZEZ4MFhIUmNkSDFjYmx4MFhIUmNkRngwZlZ4dVhIUmNkRngwZlZ4dVhIUmNkSDBwTzF4dVhIUjlMRnh1WEc1OU95SmRmUT09Il19

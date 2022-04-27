(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
(function (global){

var state = require('./includes/state');
var plugin = require('./includes/plugin');


(function ( $ ) {

	"use strict";

	$(function () {

		String.prototype.replaceAll = function(str1, str2, ignore)
		{
			return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
		}

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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIlxyXG52YXIgc3RhdGUgPSByZXF1aXJlKCcuL2luY2x1ZGVzL3N0YXRlJyk7XHJcbnZhciBwbHVnaW4gPSByZXF1aXJlKCcuL2luY2x1ZGVzL3BsdWdpbicpO1xyXG5cclxuXHJcbihmdW5jdGlvbiAoICQgKSB7XHJcblxyXG5cdFwidXNlIHN0cmljdFwiO1xyXG5cclxuXHQkKGZ1bmN0aW9uICgpIHtcclxuXHJcblx0XHRTdHJpbmcucHJvdG90eXBlLnJlcGxhY2VBbGwgPSBmdW5jdGlvbihzdHIxLCBzdHIyLCBpZ25vcmUpXHJcblx0XHR7XHJcblx0XHRcdHJldHVybiB0aGlzLnJlcGxhY2UobmV3IFJlZ0V4cChzdHIxLnJlcGxhY2UoLyhbXFwvXFwsXFwhXFxcXFxcXlxcJFxce1xcfVxcW1xcXVxcKFxcKVxcLlxcKlxcK1xcP1xcfFxcPFxcPlxcLVxcJl0pL2csXCJcXFxcJCZcIiksKGlnbm9yZT9cImdpXCI6XCJnXCIpKSwodHlwZW9mKHN0cjIpPT1cInN0cmluZ1wiKT9zdHIyLnJlcGxhY2UoL1xcJC9nLFwiJCQkJFwiKTpzdHIyKTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIU9iamVjdC5rZXlzKSB7XHJcblx0XHQgIE9iamVjdC5rZXlzID0gKGZ1bmN0aW9uICgpIHtcclxuXHRcdFx0J3VzZSBzdHJpY3QnO1xyXG5cdFx0XHR2YXIgaGFzT3duUHJvcGVydHkgPSBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LFxyXG5cdFx0XHRcdGhhc0RvbnRFbnVtQnVnID0gISh7dG9TdHJpbmc6IG51bGx9KS5wcm9wZXJ0eUlzRW51bWVyYWJsZSgndG9TdHJpbmcnKSxcclxuXHRcdFx0XHRkb250RW51bXMgPSBbXHJcblx0XHRcdFx0ICAndG9TdHJpbmcnLFxyXG5cdFx0XHRcdCAgJ3RvTG9jYWxlU3RyaW5nJyxcclxuXHRcdFx0XHQgICd2YWx1ZU9mJyxcclxuXHRcdFx0XHQgICdoYXNPd25Qcm9wZXJ0eScsXHJcblx0XHRcdFx0ICAnaXNQcm90b3R5cGVPZicsXHJcblx0XHRcdFx0ICAncHJvcGVydHlJc0VudW1lcmFibGUnLFxyXG5cdFx0XHRcdCAgJ2NvbnN0cnVjdG9yJ1xyXG5cdFx0XHRcdF0sXHJcblx0XHRcdFx0ZG9udEVudW1zTGVuZ3RoID0gZG9udEVudW1zLmxlbmd0aDtcclxuXHJcblx0XHRcdHJldHVybiBmdW5jdGlvbiAob2JqKSB7XHJcblx0XHRcdCAgaWYgKHR5cGVvZiBvYmogIT09ICdvYmplY3QnICYmICh0eXBlb2Ygb2JqICE9PSAnZnVuY3Rpb24nIHx8IG9iaiA9PT0gbnVsbCkpIHtcclxuXHRcdFx0XHR0aHJvdyBuZXcgVHlwZUVycm9yKCdPYmplY3Qua2V5cyBjYWxsZWQgb24gbm9uLW9iamVjdCcpO1xyXG5cdFx0XHQgIH1cclxuXHJcblx0XHRcdCAgdmFyIHJlc3VsdCA9IFtdLCBwcm9wLCBpO1xyXG5cclxuXHRcdFx0ICBmb3IgKHByb3AgaW4gb2JqKSB7XHJcblx0XHRcdFx0aWYgKGhhc093blByb3BlcnR5LmNhbGwob2JqLCBwcm9wKSkge1xyXG5cdFx0XHRcdCAgcmVzdWx0LnB1c2gocHJvcCk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHQgIH1cclxuXHJcblx0XHRcdCAgaWYgKGhhc0RvbnRFbnVtQnVnKSB7XHJcblx0XHRcdFx0Zm9yIChpID0gMDsgaSA8IGRvbnRFbnVtc0xlbmd0aDsgaSsrKSB7XHJcblx0XHRcdFx0ICBpZiAoaGFzT3duUHJvcGVydHkuY2FsbChvYmosIGRvbnRFbnVtc1tpXSkpIHtcclxuXHRcdFx0XHRcdHJlc3VsdC5wdXNoKGRvbnRFbnVtc1tpXSk7XHJcblx0XHRcdFx0ICB9XHJcblx0XHRcdFx0fVxyXG5cdFx0XHQgIH1cclxuXHRcdFx0ICByZXR1cm4gcmVzdWx0O1xyXG5cdFx0XHR9O1xyXG5cdFx0ICB9KCkpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8qIFNlYXJjaCAmIEZpbHRlciBqUXVlcnkgUGx1Z2luICovXHJcblx0XHQkLmZuLnNlYXJjaEFuZEZpbHRlciA9IHBsdWdpbjtcclxuXHJcblx0XHQvKiBpbml0ICovXHJcblx0XHQkKFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuXHJcblx0XHQvKiBleHRlcm5hbCBjb250cm9scyAqL1xyXG5cdFx0JChkb2N1bWVudCkub24oXCJjbGlja1wiLCBcIi5zZWFyY2gtZmlsdGVyLXJlc2V0XCIsIGZ1bmN0aW9uKGUpe1xyXG5cclxuXHRcdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG5cclxuXHRcdFx0dmFyIHNlYXJjaEZvcm1JRCA9IHR5cGVvZigkKHRoaXMpLmF0dHIoXCJkYXRhLXNlYXJjaC1mb3JtLWlkXCIpKSE9XCJ1bmRlZmluZWRcIiA/ICQodGhpcykuYXR0cihcImRhdGEtc2VhcmNoLWZvcm0taWRcIikgOiBcIlwiO1xyXG5cdFx0XHR2YXIgc3VibWl0Rm9ybSA9IHR5cGVvZigkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLXN1Ym1pdC1mb3JtXCIpKSE9XCJ1bmRlZmluZWRcIiA/ICQodGhpcykuYXR0cihcImRhdGEtc2Ytc3VibWl0LWZvcm1cIikgOiBcIlwiO1xyXG5cclxuXHRcdFx0c3RhdGUuZ2V0U2VhcmNoRm9ybShzZWFyY2hGb3JtSUQpLnJlc2V0KHN1Ym1pdEZvcm0pO1xyXG5cclxuXHRcdFx0Ly92YXIgJGxpbmtlZCA9ICQoXCIjc2VhcmNoLWZpbHRlci1mb3JtLVwiK3NlYXJjaEZvcm1JRCkuc2VhcmNoRmlsdGVyRm9ybSh7YWN0aW9uOiBcInJlc2V0XCJ9KTtcclxuXHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHJcblx0XHR9KTtcclxuXHJcblx0fSk7XHJcblxyXG5cclxuLypcclxuICogalF1ZXJ5IEVhc2luZyB2MS40LjEgLSBodHRwOi8vZ3NnZC5jby51ay9zYW5kYm94L2pxdWVyeS9lYXNpbmcvXHJcbiAqIE9wZW4gc291cmNlIHVuZGVyIHRoZSBCU0QgTGljZW5zZS5cclxuICogQ29weXJpZ2h0IMKpIDIwMDggR2VvcmdlIE1jR2lubGV5IFNtaXRoXHJcbiAqIEFsbCByaWdodHMgcmVzZXJ2ZWQuXHJcbiAqIGh0dHBzOi8vcmF3LmdpdGh1Yi5jb20vZ2RzbWl0aC9qcXVlcnkuZWFzaW5nL21hc3Rlci9MSUNFTlNFXHJcbiovXHJcblxyXG4vKiBnbG9iYWxzIGpRdWVyeSwgZGVmaW5lLCBtb2R1bGUsIHJlcXVpcmUgKi9cclxuKGZ1bmN0aW9uIChmYWN0b3J5KSB7XHJcblx0aWYgKHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kKSB7XHJcblx0XHRkZWZpbmUoWydqcXVlcnknXSwgZnVuY3Rpb24gKCQpIHtcclxuXHRcdFx0cmV0dXJuIGZhY3RvcnkoJCk7XHJcblx0XHR9KTtcclxuXHR9IGVsc2UgaWYgKHR5cGVvZiBtb2R1bGUgPT09IFwib2JqZWN0XCIgJiYgdHlwZW9mIG1vZHVsZS5leHBvcnRzID09PSBcIm9iamVjdFwiKSB7XHJcblx0XHRtb2R1bGUuZXhwb3J0cyA9IGZhY3RvcnkoKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKSk7XHJcblx0fSBlbHNlIHtcclxuXHRcdGZhY3RvcnkoalF1ZXJ5KTtcclxuXHR9XHJcbn0pKGZ1bmN0aW9uKCQpe1xyXG5cclxuXHQvLyBQcmVzZXJ2ZSB0aGUgb3JpZ2luYWwgalF1ZXJ5IFwic3dpbmdcIiBlYXNpbmcgYXMgXCJqc3dpbmdcIlxyXG5cdGlmICh0eXBlb2YgJC5lYXNpbmcgIT09ICd1bmRlZmluZWQnKSB7XHJcblx0XHQkLmVhc2luZ1snanN3aW5nJ10gPSAkLmVhc2luZ1snc3dpbmcnXTtcclxuXHR9XHJcblxyXG5cdHZhciBwb3cgPSBNYXRoLnBvdyxcclxuXHRcdHNxcnQgPSBNYXRoLnNxcnQsXHJcblx0XHRzaW4gPSBNYXRoLnNpbixcclxuXHRcdGNvcyA9IE1hdGguY29zLFxyXG5cdFx0UEkgPSBNYXRoLlBJLFxyXG5cdFx0YzEgPSAxLjcwMTU4LFxyXG5cdFx0YzIgPSBjMSAqIDEuNTI1LFxyXG5cdFx0YzMgPSBjMSArIDEsXHJcblx0XHRjNCA9ICggMiAqIFBJICkgLyAzLFxyXG5cdFx0YzUgPSAoIDIgKiBQSSApIC8gNC41O1xyXG5cclxuXHQvLyB4IGlzIHRoZSBmcmFjdGlvbiBvZiBhbmltYXRpb24gcHJvZ3Jlc3MsIGluIHRoZSByYW5nZSAwLi4xXHJcblx0ZnVuY3Rpb24gYm91bmNlT3V0KHgpIHtcclxuXHRcdHZhciBuMSA9IDcuNTYyNSxcclxuXHRcdFx0ZDEgPSAyLjc1O1xyXG5cdFx0aWYgKCB4IDwgMS9kMSApIHtcclxuXHRcdFx0cmV0dXJuIG4xKngqeDtcclxuXHRcdH0gZWxzZSBpZiAoIHggPCAyL2QxICkge1xyXG5cdFx0XHRyZXR1cm4gbjEqKHgtPSgxLjUvZDEpKSp4ICsgLjc1O1xyXG5cdFx0fSBlbHNlIGlmICggeCA8IDIuNS9kMSApIHtcclxuXHRcdFx0cmV0dXJuIG4xKih4LT0oMi4yNS9kMSkpKnggKyAuOTM3NTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdHJldHVybiBuMSooeC09KDIuNjI1L2QxKSkqeCArIC45ODQzNzU7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQkLmV4dGVuZCggJC5lYXNpbmcsIHtcclxuXHRcdGRlZjogJ2Vhc2VPdXRRdWFkJyxcclxuXHRcdHN3aW5nOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gJC5lYXNpbmdbJC5lYXNpbmcuZGVmXSh4KTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5RdWFkOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dFF1YWQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxIC0gKCAxIC0geCApICogKCAxIC0geCApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dFF1YWQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQyICogeCAqIHggOlxyXG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDIgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluQ3ViaWM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ICogeCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEN1YmljOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gMSAtIHBvdyggMSAtIHgsIDMgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRDdWJpYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xyXG5cdFx0XHRcdDQgKiB4ICogeCAqIHggOlxyXG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDMgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluUXVhcnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ICogeCAqIHggKiB4O1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRRdWFydDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCA0ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0UXVhcnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQ4ICogeCAqIHggKiB4ICogeCA6XHJcblx0XHRcdFx0MSAtIHBvdyggLTIgKiB4ICsgMiwgNCApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5RdWludDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggKiB4ICogeCAqIHggKiB4O1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRRdWludDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCA1ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0UXVpbnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQxNiAqIHggKiB4ICogeCAqIHggKiB4IDpcclxuXHRcdFx0XHQxIC0gcG93KCAtMiAqIHggKyAyLCA1ICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJblNpbmU6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxIC0gY29zKCB4ICogUEkvMiApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRTaW5lOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gc2luKCB4ICogUEkvMiApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dFNpbmU6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAtKCBjb3MoIFBJICogeCApIC0gMSApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5FeHBvOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiBwb3coIDIsIDEwICogeCAtIDEwICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEV4cG86IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAxID8gMSA6IDEgLSBwb3coIDIsIC0xMCAqIHggKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRFeHBvOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6IHggPCAwLjUgP1xyXG5cdFx0XHRcdHBvdyggMiwgMjAgKiB4IC0gMTAgKSAvIDIgOlxyXG5cdFx0XHRcdCggMiAtIHBvdyggMiwgLTIwICogeCArIDEwICkgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluQ2lyYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBzcXJ0KCAxIC0gcG93KCB4LCAyICkgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0Q2lyYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHNxcnQoIDEgLSBwb3coIHggLSAxLCAyICkgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRDaXJjOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCAxIC0gc3FydCggMSAtIHBvdyggMiAqIHgsIDIgKSApICkgLyAyIDpcclxuXHRcdFx0XHQoIHNxcnQoIDEgLSBwb3coIC0yICogeCArIDIsIDIgKSApICsgMSApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5FbGFzdGljOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6XHJcblx0XHRcdFx0LXBvdyggMiwgMTAgKiB4IC0gMTAgKSAqIHNpbiggKCB4ICogMTAgLSAxMC43NSApICogYzQgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0RWxhc3RpYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPT09IDAgPyAwIDogeCA9PT0gMSA/IDEgOlxyXG5cdFx0XHRcdHBvdyggMiwgLTEwICogeCApICogc2luKCAoIHggKiAxMCAtIDAuNzUgKSAqIGM0ICkgKyAxO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dEVsYXN0aWM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHggPT09IDEgPyAxIDogeCA8IDAuNSA/XHJcblx0XHRcdFx0LSggcG93KCAyLCAyMCAqIHggLSAxMCApICogc2luKCAoIDIwICogeCAtIDExLjEyNSApICogYzUgKSkgLyAyIDpcclxuXHRcdFx0XHRwb3coIDIsIC0yMCAqIHggKyAxMCApICogc2luKCAoIDIwICogeCAtIDExLjEyNSApICogYzUgKSAvIDIgKyAxO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbkJhY2s6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiBjMyAqIHggKiB4ICogeCAtIGMxICogeCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEJhY2s6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxICsgYzMgKiBwb3coIHggLSAxLCAzICkgKyBjMSAqIHBvdyggeCAtIDEsIDIgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRCYWNrOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCBwb3coIDIgKiB4LCAyICkgKiAoICggYzIgKyAxICkgKiAyICogeCAtIGMyICkgKSAvIDIgOlxyXG5cdFx0XHRcdCggcG93KCAyICogeCAtIDIsIDIgKSAqKCAoIGMyICsgMSApICogKCB4ICogMiAtIDIgKSArIGMyICkgKyAyICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbkJvdW5jZTogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBib3VuY2VPdXQoIDEgLSB4ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEJvdW5jZTogYm91bmNlT3V0LFxyXG5cdFx0ZWFzZUluT3V0Qm91bmNlOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCAxIC0gYm91bmNlT3V0KCAxIC0gMiAqIHggKSApIC8gMiA6XHJcblx0XHRcdFx0KCAxICsgYm91bmNlT3V0KCAyICogeCAtIDEgKSApIC8gMjtcclxuXHRcdH1cclxuXHR9KTtcclxuXHRyZXR1cm4gJDtcclxufSk7XHJcblxyXG59KGpRdWVyeSkpO1xyXG5cclxuLy9zYWZhcmkgYmFjayBidXR0b24gZml4XHJcbmpRdWVyeSggd2luZG93ICkub24oIFwicGFnZXNob3dcIiwgZnVuY3Rpb24oZXZlbnQpIHtcclxuICAgIGlmIChldmVudC5vcmlnaW5hbEV2ZW50LnBlcnNpc3RlZCkge1xyXG4gICAgICAgIGpRdWVyeShcIi5zZWFyY2hhbmRmaWx0ZXJcIikub2ZmKCk7XHJcbiAgICAgICAgalF1ZXJ5KFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuICAgIH1cclxufSk7XHJcblxyXG4vKiB3cG51bWIgLSBub3Vpc2xpZGVyIG51bWJlciBmb3JtYXR0aW5nICovXHJcbiFmdW5jdGlvbigpe1widXNlIHN0cmljdFwiO2Z1bmN0aW9uIGUoZSl7cmV0dXJuIGUuc3BsaXQoXCJcIikucmV2ZXJzZSgpLmpvaW4oXCJcIil9ZnVuY3Rpb24gbihlLG4pe3JldHVybiBlLnN1YnN0cmluZygwLG4ubGVuZ3RoKT09PW59ZnVuY3Rpb24gcihlLG4pe3JldHVybiBlLnNsaWNlKC0xKm4ubGVuZ3RoKT09PW59ZnVuY3Rpb24gdChlLG4scil7aWYoKGVbbl18fGVbcl0pJiZlW25dPT09ZVtyXSl0aHJvdyBuZXcgRXJyb3Iobil9ZnVuY3Rpb24gaShlKXtyZXR1cm5cIm51bWJlclwiPT10eXBlb2YgZSYmaXNGaW5pdGUoZSl9ZnVuY3Rpb24gbyhlLG4pe3ZhciByPU1hdGgucG93KDEwLG4pO3JldHVybihNYXRoLnJvdW5kKGUqcikvcikudG9GaXhlZChuKX1mdW5jdGlvbiB1KG4scix0LHUsZixhLGMscyxwLGQsbCxoKXt2YXIgZyx2LHcsbT1oLHg9XCJcIixiPVwiXCI7cmV0dXJuIGEmJihoPWEoaCkpLGkoaCk/KG4hPT0hMSYmMD09PXBhcnNlRmxvYXQoaC50b0ZpeGVkKG4pKSYmKGg9MCksMD5oJiYoZz0hMCxoPU1hdGguYWJzKGgpKSxuIT09ITEmJihoPW8oaCxuKSksaD1oLnRvU3RyaW5nKCksLTEhPT1oLmluZGV4T2YoXCIuXCIpPyh2PWguc3BsaXQoXCIuXCIpLHc9dlswXSx0JiYoeD10K3ZbMV0pKTp3PWgsciYmKHc9ZSh3KS5tYXRjaCgvLnsxLDN9L2cpLHc9ZSh3LmpvaW4oZShyKSkpKSxnJiZzJiYoYis9cyksdSYmKGIrPXUpLGcmJnAmJihiKz1wKSxiKz13LGIrPXgsZiYmKGIrPWYpLGQmJihiPWQoYixtKSksYik6ITF9ZnVuY3Rpb24gZihlLHQsbyx1LGYsYSxjLHMscCxkLGwsaCl7dmFyIGcsdj1cIlwiO3JldHVybiBsJiYoaD1sKGgpKSxoJiZcInN0cmluZ1wiPT10eXBlb2YgaD8ocyYmbihoLHMpJiYoaD1oLnJlcGxhY2UocyxcIlwiKSxnPSEwKSx1JiZuKGgsdSkmJihoPWgucmVwbGFjZSh1LFwiXCIpKSxwJiZuKGgscCkmJihoPWgucmVwbGFjZShwLFwiXCIpLGc9ITApLGYmJnIoaCxmKSYmKGg9aC5zbGljZSgwLC0xKmYubGVuZ3RoKSksdCYmKGg9aC5zcGxpdCh0KS5qb2luKFwiXCIpKSxvJiYoaD1oLnJlcGxhY2UobyxcIi5cIikpLGcmJih2Kz1cIi1cIiksdis9aCx2PXYucmVwbGFjZSgvW14wLTlcXC5cXC0uXS9nLFwiXCIpLFwiXCI9PT12PyExOih2PU51bWJlcih2KSxjJiYodj1jKHYpKSxpKHYpP3Y6ITEpKTohMX1mdW5jdGlvbiBhKGUpe3ZhciBuLHIsaSxvPXt9O2ZvcihuPTA7bjxwLmxlbmd0aDtuKz0xKWlmKHI9cFtuXSxpPWVbcl0sdm9pZCAwPT09aSlcIm5lZ2F0aXZlXCIhPT1yfHxvLm5lZ2F0aXZlQmVmb3JlP1wibWFya1wiPT09ciYmXCIuXCIhPT1vLnRob3VzYW5kP29bcl09XCIuXCI6b1tyXT0hMTpvW3JdPVwiLVwiO2Vsc2UgaWYoXCJkZWNpbWFsc1wiPT09cil7aWYoIShpPj0wJiY4PmkpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9ZWxzZSBpZihcImVuY29kZXJcIj09PXJ8fFwiZGVjb2RlclwiPT09cnx8XCJlZGl0XCI9PT1yfHxcInVuZG9cIj09PXIpe2lmKFwiZnVuY3Rpb25cIiE9dHlwZW9mIGkpdGhyb3cgbmV3IEVycm9yKHIpO29bcl09aX1lbHNle2lmKFwic3RyaW5nXCIhPXR5cGVvZiBpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9cmV0dXJuIHQobyxcIm1hcmtcIixcInRob3VzYW5kXCIpLHQobyxcInByZWZpeFwiLFwibmVnYXRpdmVcIiksdChvLFwicHJlZml4XCIsXCJuZWdhdGl2ZUJlZm9yZVwiKSxvfWZ1bmN0aW9uIGMoZSxuLHIpe3ZhciB0LGk9W107Zm9yKHQ9MDt0PHAubGVuZ3RoO3QrPTEpaS5wdXNoKGVbcFt0XV0pO3JldHVybiBpLnB1c2gociksbi5hcHBseShcIlwiLGkpfWZ1bmN0aW9uIHMoZSl7cmV0dXJuIHRoaXMgaW5zdGFuY2VvZiBzP3ZvaWQoXCJvYmplY3RcIj09dHlwZW9mIGUmJihlPWEoZSksdGhpcy50bz1mdW5jdGlvbihuKXtyZXR1cm4gYyhlLHUsbil9LHRoaXMuZnJvbT1mdW5jdGlvbihuKXtyZXR1cm4gYyhlLGYsbil9KSk6bmV3IHMoZSl9dmFyIHA9W1wiZGVjaW1hbHNcIixcInRob3VzYW5kXCIsXCJtYXJrXCIsXCJwcmVmaXhcIixcInBvc3RmaXhcIixcImVuY29kZXJcIixcImRlY29kZXJcIixcIm5lZ2F0aXZlQmVmb3JlXCIsXCJuZWdhdGl2ZVwiLFwiZWRpdFwiLFwidW5kb1wiXTt3aW5kb3cud051bWI9c30oKTtcclxuXHJcbiJdfQ==
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

            this.is_max_paged = false; //for load more only, once we detect we're at the end set this to true
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

                /* scroll */
                //self.scrollResults();

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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3BsdWdpbi5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIlxyXG52YXIgJCBcdFx0XHRcdD0gKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKTtcclxudmFyIHN0YXRlIFx0XHRcdD0gcmVxdWlyZSgnLi9zdGF0ZScpO1xyXG52YXIgcHJvY2Vzc19mb3JtIFx0PSByZXF1aXJlKCcuL3Byb2Nlc3NfZm9ybScpO1xyXG52YXIgbm9VaVNsaWRlclx0XHQ9IHJlcXVpcmUoJ25vdWlzbGlkZXInKTtcclxuLy92YXIgY29va2llcyAgICAgICAgID0gcmVxdWlyZSgnanMtY29va2llJyk7XHJcbnZhciB0aGlyZFBhcnR5ICAgICAgPSByZXF1aXJlKCcuL3RoaXJkcGFydHknKTtcclxuXHJcbndpbmRvdy5zZWFyY2hBbmRGaWx0ZXIgPSB7XHJcbiAgICBleHRlbnNpb25zOiBbXSxcclxuICAgIHJlZ2lzdGVyRXh0ZW5zaW9uOiBmdW5jdGlvbiggZXh0ZW5zaW9uTmFtZSApIHtcclxuICAgICAgICB0aGlzLmV4dGVuc2lvbnMucHVzaCggZXh0ZW5zaW9uTmFtZSApO1xyXG4gICAgfVxyXG59O1xyXG5cclxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbihvcHRpb25zKVxyXG57XHJcbiAgICB2YXIgZGVmYXVsdHMgPSB7XHJcbiAgICAgICAgc3RhcnRPcGVuZWQ6IGZhbHNlLFxyXG4gICAgICAgIGlzSW5pdDogdHJ1ZSxcclxuICAgICAgICBhY3Rpb246IFwiXCJcclxuICAgIH07XHJcblxyXG4gICAgdmFyIG9wdHMgPSBqUXVlcnkuZXh0ZW5kKGRlZmF1bHRzLCBvcHRpb25zKTtcclxuICAgIFxyXG4gICAgdGhpcmRQYXJ0eS5pbml0KCk7XHJcbiAgICBcclxuICAgIC8vbG9vcCB0aHJvdWdoIGVhY2ggaXRlbSBtYXRjaGVkXHJcbiAgICB0aGlzLmVhY2goZnVuY3Rpb24oKVxyXG4gICAge1xyXG5cclxuICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICB0aGlzLnNmaWQgPSAkdGhpcy5hdHRyKFwiZGF0YS1zZi1mb3JtLWlkXCIpO1xyXG5cclxuICAgICAgICBzdGF0ZS5hZGRTZWFyY2hGb3JtKHRoaXMuc2ZpZCwgdGhpcyk7XHJcblxyXG4gICAgICAgIHRoaXMuJGZpZWxkcyA9ICR0aGlzLmZpbmQoXCI+IHVsID4gbGlcIik7IC8vYSByZWZlcmVuY2UgdG8gZWFjaCBmaWVsZHMgcGFyZW50IExJXHJcblxyXG4gICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gJHRoaXMuYXR0cignZGF0YS10YXhvbm9teS1hcmNoaXZlcycpO1xyXG4gICAgICAgIHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlID0gJHRoaXMuYXR0cignZGF0YS1jdXJyZW50LXRheG9ub215LWFyY2hpdmUnKTtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gXCIwXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBwcm9jZXNzX2Zvcm0uaW5pdChzZWxmLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcywgc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUpO1xyXG4gICAgICAgIC8vcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYpO1xyXG4gICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyA9IHthbGw6IHt9LCByZXN1bHRzOiB7fSwgYWpheDoge319O1xyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMudGVtcGxhdGVfaXNfbG9hZGVkID0gJHRoaXMuYXR0cihcImRhdGEtdGVtcGxhdGUtbG9hZGVkXCIpO1xyXG4gICAgICAgIHRoaXMuaXNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXhcIik7XHJcbiAgICAgICAgdGhpcy5pbnN0YW5jZV9udW1iZXIgPSAkdGhpcy5hdHRyKCdkYXRhLWluc3RhbmNlLWNvdW50Jyk7XHJcbiAgICAgICAgdGhpcy4kYWpheF9yZXN1bHRzX2NvbnRhaW5lciA9IGpRdWVyeSgkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXRhcmdldFwiKSk7XHJcblxyXG4gICAgICAgIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXVwZGF0ZS1zZWN0aW9uc1wiKSA/IEpTT04ucGFyc2UoICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdXBkYXRlLXNlY3Rpb25zXCIpICkgOiBbXTtcclxuICAgICAgICBcclxuICAgICAgICB0aGlzLnJlc3VsdHNfdXJsID0gJHRoaXMuYXR0cihcImRhdGEtcmVzdWx0cy11cmxcIik7XHJcbiAgICAgICAgdGhpcy5kZWJ1Z19tb2RlID0gJHRoaXMuYXR0cihcImRhdGEtZGVidWctbW9kZVwiKTtcclxuICAgICAgICB0aGlzLnVwZGF0ZV9hamF4X3VybCA9ICR0aGlzLmF0dHIoXCJkYXRhLXVwZGF0ZS1hamF4LXVybFwiKTtcclxuICAgICAgICB0aGlzLnBhZ2luYXRpb25fdHlwZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtcGFnaW5hdGlvbi10eXBlXCIpO1xyXG4gICAgICAgIHRoaXMuYXV0b19jb3VudCA9ICR0aGlzLmF0dHIoXCJkYXRhLWF1dG8tY291bnRcIik7XHJcbiAgICAgICAgdGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWF1dG8tY291bnQtcmVmcmVzaC1tb2RlXCIpO1xyXG4gICAgICAgIHRoaXMub25seV9yZXN1bHRzX2FqYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1vbmx5LXJlc3VsdHMtYWpheFwiKTsgLy9pZiB3ZSBhcmUgbm90IG9uIHRoZSByZXN1bHRzIHBhZ2UsIHJlZGlyZWN0IHJhdGhlciB0aGFuIHRyeSB0byBsb2FkIHZpYSBhamF4XHJcbiAgICAgICAgdGhpcy5zY3JvbGxfdG9fcG9zID0gJHRoaXMuYXR0cihcImRhdGEtc2Nyb2xsLXRvLXBvc1wiKTtcclxuICAgICAgICB0aGlzLmN1c3RvbV9zY3JvbGxfdG8gPSAkdGhpcy5hdHRyKFwiZGF0YS1jdXN0b20tc2Nyb2xsLXRvXCIpO1xyXG4gICAgICAgIHRoaXMuc2Nyb2xsX29uX2FjdGlvbiA9ICR0aGlzLmF0dHIoXCJkYXRhLXNjcm9sbC1vbi1hY3Rpb25cIik7XHJcbiAgICAgICAgdGhpcy5sYW5nX2NvZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1sYW5nLWNvZGVcIik7XHJcbiAgICAgICAgdGhpcy5hamF4X3VybCA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC11cmwnKTtcclxuICAgICAgICB0aGlzLmFqYXhfZm9ybV91cmwgPSAkdGhpcy5hdHRyKCdkYXRhLWFqYXgtZm9ybS11cmwnKTtcclxuICAgICAgICB0aGlzLmlzX3J0bCA9ICR0aGlzLmF0dHIoJ2RhdGEtaXMtcnRsJyk7XHJcblxyXG4gICAgICAgIHRoaXMuZGlzcGxheV9yZXN1bHRfbWV0aG9kID0gJHRoaXMuYXR0cignZGF0YS1kaXNwbGF5LXJlc3VsdC1tZXRob2QnKTtcclxuICAgICAgICB0aGlzLm1haW50YWluX3N0YXRlID0gJHRoaXMuYXR0cignZGF0YS1tYWludGFpbi1zdGF0ZScpO1xyXG4gICAgICAgIHRoaXMuYWpheF9hY3Rpb24gPSBcIlwiO1xyXG4gICAgICAgIHRoaXMubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zID0gXCJcIjtcclxuXHJcbiAgICAgICAgdGhpcy5jdXJyZW50X3BhZ2VkID0gcGFyc2VJbnQoJHRoaXMuYXR0cignZGF0YS1pbml0LXBhZ2VkJykpO1xyXG4gICAgICAgIHRoaXMubGFzdF9sb2FkX21vcmVfaHRtbCA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5sb2FkX21vcmVfaHRtbCA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5hamF4X2RhdGFfdHlwZSA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC1kYXRhLXR5cGUnKTtcclxuICAgICAgICB0aGlzLmFqYXhfdGFyZ2V0X2F0dHIgPSAkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXRhcmdldFwiKTtcclxuICAgICAgICB0aGlzLnVzZV9oaXN0b3J5X2FwaSA9ICR0aGlzLmF0dHIoXCJkYXRhLXVzZS1oaXN0b3J5LWFwaVwiKTtcclxuICAgICAgICB0aGlzLmlzX3N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgdGhpcy5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnVzZV9oaXN0b3J5X2FwaSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnVzZV9oaXN0b3J5X2FwaSA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5wYWdpbmF0aW9uX3R5cGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5wYWdpbmF0aW9uX3R5cGUgPSBcIm5vcm1hbFwiO1xyXG4gICAgICAgIH1cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5jdXJyZW50X3BhZ2VkKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuY3VycmVudF9wYWdlZCA9IDE7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5hamF4X3RhcmdldF9hdHRyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF90YXJnZXRfYXR0ciA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5hamF4X3VybCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmFqYXhfdXJsID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfZm9ybV91cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hamF4X2Zvcm1fdXJsID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnJlc3VsdHNfdXJsKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMucmVzdWx0c191cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuc2Nyb2xsX3RvX3Bvcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnNjcm9sbF90b19wb3MgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuc2Nyb2xsX29uX2FjdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnNjcm9sbF9vbl9hY3Rpb24gPSBcIlwiO1xyXG4gICAgICAgIH1cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5jdXN0b21fc2Nyb2xsX3RvKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuY3VzdG9tX3Njcm9sbF90byA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuJGN1c3RvbV9zY3JvbGxfdG8gPSBqUXVlcnkodGhpcy5jdXN0b21fc2Nyb2xsX3RvKTtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMudXBkYXRlX2FqYXhfdXJsKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMudXBkYXRlX2FqYXhfdXJsID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmRlYnVnX21vZGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5kZWJ1Z19tb2RlID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdGFyZ2V0X29iamVjdCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmFqYXhfdGFyZ2V0X29iamVjdCA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy50ZW1wbGF0ZV9pc19sb2FkZWQpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy50ZW1wbGF0ZV9pc19sb2FkZWQgPSBcIjBcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGUgPSBcIjBcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuYWpheF9saW5rc19zZWxlY3RvciA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtbGlua3Mtc2VsZWN0b3JcIik7XHJcblxyXG5cclxuICAgICAgICB0aGlzLmF1dG9fdXBkYXRlID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by11cGRhdGVcIik7XHJcbiAgICAgICAgdGhpcy5pbnB1dFRpbWVyID0gMDtcclxuXHJcbiAgICAgICAgdGhpcy5zZXRJbmZpbml0ZVNjcm9sbENvbnRhaW5lciA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICB0aGlzLmlzX21heF9wYWdlZCA9IGZhbHNlOyAvL2ZvciBsb2FkIG1vcmUgb25seSwgb25jZSB3ZSBkZXRlY3Qgd2UncmUgYXQgdGhlIGVuZCBzZXQgdGhpcyB0byB0cnVlXHJcbiAgICAgICAgICAgIHRoaXMudXNlX3Njcm9sbF9sb2FkZXIgPSAkdGhpcy5hdHRyKCdkYXRhLXNob3ctc2Nyb2xsLWxvYWRlcicpO1xyXG4gICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSAkdGhpcy5hdHRyKCdkYXRhLWluZmluaXRlLXNjcm9sbC1jb250YWluZXInKTtcclxuICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfdHJpZ2dlcl9hbW91bnQgPSAkdGhpcy5hdHRyKCdkYXRhLWluZmluaXRlLXNjcm9sbC10cmlnZ2VyJyk7XHJcbiAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLXJlc3VsdC1jbGFzcycpO1xyXG4gICAgICAgICAgICB0aGlzLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyID0gdGhpcy4kYWpheF9yZXN1bHRzX2NvbnRhaW5lcjtcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdGhpcy4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IGpRdWVyeSgkdGhpcy5hdHRyKCdkYXRhLWluZmluaXRlLXNjcm9sbC1jb250YWluZXInKSk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MgPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YodGhpcy51c2Vfc2Nyb2xsX2xvYWRlcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMudXNlX3Njcm9sbF9sb2FkZXIgPSAxO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgIH07XHJcbiAgICAgICAgdGhpcy5zZXRJbmZpbml0ZVNjcm9sbENvbnRhaW5lcigpO1xyXG5cclxuICAgICAgICAvKiBmdW5jdGlvbnMgKi9cclxuXHJcbiAgICAgICAgdGhpcy5yZXNldCA9IGZ1bmN0aW9uKHN1Ym1pdF9mb3JtKVxyXG4gICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgIHRoaXMucmVzZXRGb3JtKHN1Ym1pdF9mb3JtKTtcclxuICAgICAgICAgICAgcmV0dXJuIHRydWU7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmlucHV0VXBkYXRlID0gZnVuY3Rpb24oZGVsYXlEdXJhdGlvbilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihkZWxheUR1cmF0aW9uKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRlbGF5RHVyYXRpb24gPSAzMDA7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYucmVzZXRUaW1lcihkZWxheUR1cmF0aW9uKTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuc2Nyb2xsVG9Qb3MgPSBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgdmFyIG9mZnNldCA9IDA7XHJcbiAgICAgICAgICAgIHZhciBjYW5TY3JvbGwgPSB0cnVlO1xyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLnNjcm9sbF90b19wb3M9PVwid2luZG93XCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgb2Zmc2V0ID0gMDtcclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJmb3JtXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgb2Zmc2V0ID0gJHRoaXMub2Zmc2V0KCkudG9wO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZSBpZihzZWxmLnNjcm9sbF90b19wb3M9PVwicmVzdWx0c1wiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLm9mZnNldCgpLnRvcDtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJjdXN0b21cIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL2N1c3RvbV9zY3JvbGxfdG9cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLiRjdXN0b21fc2Nyb2xsX3RvLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgb2Zmc2V0ID0gc2VsZi4kY3VzdG9tX3Njcm9sbF90by5vZmZzZXQoKS50b3A7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGNhblNjcm9sbCA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKGNhblNjcm9sbClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAkKFwiaHRtbCwgYm9keVwiKS5zdG9wKCkuYW5pbWF0ZSh7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNjcm9sbFRvcDogb2Zmc2V0XHJcbiAgICAgICAgICAgICAgICAgICAgfSwgXCJub3JtYWxcIiwgXCJlYXNlT3V0UXVhZFwiICk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5hdHRhY2hBY3RpdmVDbGFzcyA9IGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAvL2NoZWNrIHRvIHNlZSBpZiB3ZSBhcmUgdXNpbmcgYWpheCAmIGF1dG8gY291bnRcclxuICAgICAgICAgICAgLy9pZiBub3QsIHRoZSBzZWFyY2ggZm9ybSBkb2VzIG5vdCBnZXQgcmVsb2FkZWQsIHNvIHdlIG5lZWQgdG8gdXBkYXRlIHRoZSBzZi1vcHRpb24tYWN0aXZlIGNsYXNzIG9uIGFsbCBmaWVsZHNcclxuXHJcbiAgICAgICAgICAgICR0aGlzLm9uKCdjaGFuZ2UnLCAnaW5wdXRbdHlwZT1cInJhZGlvXCJdLCBpbnB1dFt0eXBlPVwiY2hlY2tib3hcIl0sIHNlbGVjdCcsIGZ1bmN0aW9uKGUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciAkY3RoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgdmFyICRjdGhpc19wYXJlbnQgPSAkY3RoaXMuY2xvc2VzdChcImxpW2RhdGEtc2YtZmllbGQtbmFtZV1cIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgdGhpc190YWcgPSAkY3RoaXMucHJvcChcInRhZ05hbWVcIikudG9Mb3dlckNhc2UoKTtcclxuICAgICAgICAgICAgICAgIHZhciBpbnB1dF90eXBlID0gJGN0aGlzLmF0dHIoXCJ0eXBlXCIpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHBhcmVudF90YWcgPSAkY3RoaXNfcGFyZW50LnByb3AoXCJ0YWdOYW1lXCIpLnRvTG93ZXJDYXNlKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoKHRoaXNfdGFnPT1cImlucHV0XCIpJiYoKGlucHV0X3R5cGU9PVwicmFkaW9cIil8fChpbnB1dF90eXBlPT1cImNoZWNrYm94XCIpKSAmJiAocGFyZW50X3RhZz09XCJsaVwiKSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGFsbF9vcHRpb25zID0gJGN0aGlzX3BhcmVudC5wYXJlbnQoKS5maW5kKCdsaScpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnNfZmllbGRzID0gJGN0aGlzX3BhcmVudC5wYXJlbnQoKS5maW5kKCdpbnB1dDpjaGVja2VkJyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRhbGxfb3B0aW9ucy5yZW1vdmVDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgJGFsbF9vcHRpb25zX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHBhcmVudCA9ICQodGhpcykuY2xvc2VzdChcImxpXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkcGFyZW50LmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZSBpZih0aGlzX3RhZz09XCJzZWxlY3RcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGFsbF9vcHRpb25zID0gJGN0aGlzLmNoaWxkcmVuKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgJGFsbF9vcHRpb25zLnJlbW92ZUNsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgdGhpc192YWwgPSAkY3RoaXMudmFsKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciB0aGlzX2Fycl92YWwgPSAodHlwZW9mIHRoaXNfdmFsID09ICdzdHJpbmcnIHx8IHRoaXNfdmFsIGluc3RhbmNlb2YgU3RyaW5nKSA/IFt0aGlzX3ZhbF0gOiB0aGlzX3ZhbDtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJCh0aGlzX2Fycl92YWwpLmVhY2goZnVuY3Rpb24oaSwgdmFsdWUpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkY3RoaXMuZmluZChcIm9wdGlvblt2YWx1ZT0nXCIrdmFsdWUrXCInXVwiKS5hZGRDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgIH07XHJcbiAgICAgICAgdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cyA9IGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAvKiBhdXRvIHVwZGF0ZSAqL1xyXG4gICAgICAgICAgICBpZigoc2VsZi5hdXRvX3VwZGF0ZT09MSl8fChzZWxmLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJHRoaXMub24oJ2NoYW5nZScsICdpbnB1dFt0eXBlPVwicmFkaW9cIl0sIGlucHV0W3R5cGU9XCJjaGVja2JveFwiXSwgc2VsZWN0JywgZnVuY3Rpb24oZSkge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMjAwKTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dFt0eXBlPVwibnVtYmVyXCJdJywgZnVuY3Rpb24oZSkge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoODAwKTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkdGV4dElucHV0ID0gJHRoaXMuZmluZCgnaW5wdXRbdHlwZT1cInRleHRcIl06bm90KC5zZi1kYXRlcGlja2VyKScpO1xyXG4gICAgICAgICAgICAgICAgdmFyIGxhc3RWYWx1ZSA9ICR0ZXh0SW5wdXQudmFsKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMub24oJ2lucHV0JywgJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOm5vdCguc2YtZGF0ZXBpY2tlciknLCBmdW5jdGlvbigpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYobGFzdFZhbHVlIT0kdGV4dElucHV0LnZhbCgpKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgxMjAwKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGxhc3RWYWx1ZSA9ICR0ZXh0SW5wdXQudmFsKCk7XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMub24oJ2tleXByZXNzJywgJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOm5vdCguc2YtZGF0ZXBpY2tlciknLCBmdW5jdGlvbihlKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChlLndoaWNoID09IDEzKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5zdWJtaXRGb3JtKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy8kdGhpcy5vbignaW5wdXQnLCAnaW5wdXQuc2YtZGF0ZXBpY2tlcicsIHNlbGYuZGF0ZUlucHV0VHlwZSk7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgLy90aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzKCk7XHJcblxyXG5cclxuICAgICAgICB0aGlzLmNsZWFyVGltZXIgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBjbGVhclRpbWVvdXQoc2VsZi5pbnB1dFRpbWVyKTtcclxuICAgICAgICB9O1xyXG4gICAgICAgIHRoaXMucmVzZXRUaW1lciA9IGZ1bmN0aW9uKGRlbGF5RHVyYXRpb24pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBjbGVhclRpbWVvdXQoc2VsZi5pbnB1dFRpbWVyKTtcclxuICAgICAgICAgICAgc2VsZi5pbnB1dFRpbWVyID0gc2V0VGltZW91dChzZWxmLmZvcm1VcGRhdGVkLCBkZWxheUR1cmF0aW9uKTtcclxuXHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5hZGREYXRlUGlja2VycyA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciAkZGF0ZV9waWNrZXIgPSAkdGhpcy5maW5kKFwiLnNmLWRhdGVwaWNrZXJcIik7XHJcblxyXG4gICAgICAgICAgICBpZigkZGF0ZV9waWNrZXIubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRkYXRlX3BpY2tlci5lYWNoKGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGVGb3JtYXQgPSBcIlwiO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRHJvcGRvd25ZZWFyID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGVEcm9wZG93bk1vbnRoID0gZmFsc2U7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkY2xvc2VzdF9kYXRlX3dyYXAgPSAkdGhpcy5jbG9zZXN0KFwiLnNmX2RhdGVfZmllbGRcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoJGNsb3Nlc3RfZGF0ZV93cmFwLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZUZvcm1hdCA9ICRjbG9zZXN0X2RhdGVfd3JhcC5hdHRyKFwiZGF0YS1kYXRlLWZvcm1hdFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRjbG9zZXN0X2RhdGVfd3JhcC5hdHRyKFwiZGF0YS1kYXRlLXVzZS15ZWFyLWRyb3Bkb3duXCIpPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkYXRlRHJvcGRvd25ZZWFyID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS11c2UtbW9udGgtZHJvcGRvd25cIik9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVEcm9wZG93bk1vbnRoID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGVQaWNrZXJPcHRpb25zID0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpbmxpbmU6IHRydWUsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNob3dPdGhlck1vbnRoczogdHJ1ZSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgb25TZWxlY3Q6IGZ1bmN0aW9uKGUsIGZyb21fZmllbGQpeyBzZWxmLmRhdGVTZWxlY3QoZSwgZnJvbV9maWVsZCwgJCh0aGlzKSk7IH0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVGb3JtYXQ6IGRhdGVGb3JtYXQsXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjaGFuZ2VNb250aDogZGF0ZURyb3Bkb3duTW9udGgsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNoYW5nZVllYXI6IGRhdGVEcm9wZG93blllYXJcclxuICAgICAgICAgICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX3J0bD09MSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVQaWNrZXJPcHRpb25zLmRpcmVjdGlvbiA9IFwicnRsXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5kYXRlcGlja2VyKGRhdGVQaWNrZXJPcHRpb25zKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5sYW5nX2NvZGUhPVwiXCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIuc2V0RGVmYXVsdHMoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmV4dGVuZChcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7J2RhdGVGb3JtYXQnOmRhdGVGb3JtYXR9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5yZWdpb25hbFsgc2VsZi5sYW5nX2NvZGVdXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICApXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIuc2V0RGVmYXVsdHMoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmV4dGVuZChcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7J2RhdGVGb3JtYXQnOmRhdGVGb3JtYXR9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5yZWdpb25hbFtcImVuXCJdXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICApXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigkKCcubGwtc2tpbi1tZWxvbicpLmxlbmd0aD09MCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRkYXRlX3BpY2tlci5kYXRlcGlja2VyKCd3aWRnZXQnKS53cmFwKCc8ZGl2IGNsYXNzPVwibGwtc2tpbi1tZWxvbiBzZWFyY2hhbmRmaWx0ZXItZGF0ZS1waWNrZXJcIi8+Jyk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5kYXRlU2VsZWN0ID0gZnVuY3Rpb24oZSwgZnJvbV9maWVsZCwgJHRoaXMpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJGlucHV0X2ZpZWxkID0gJChmcm9tX2ZpZWxkLmlucHV0LmdldCgwKSk7XHJcbiAgICAgICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICB2YXIgJGRhdGVfZmllbGRzID0gJGlucHV0X2ZpZWxkLmNsb3Nlc3QoJ1tkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGU9XCJkYXRlcmFuZ2VcIl0sIFtkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGU9XCJkYXRlXCJdJyk7XHJcbiAgICAgICAgICAgICRkYXRlX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGUsIGluZGV4KXtcclxuICAgICAgICAgICAgICAgIFxyXG4gICAgICAgICAgICAgICAgdmFyICR0Zl9kYXRlX3BpY2tlcnMgPSAkKHRoaXMpLmZpbmQoXCIuc2YtZGF0ZXBpY2tlclwiKTtcclxuICAgICAgICAgICAgICAgIHZhciBub19kYXRlX3BpY2tlcnMgPSAkdGZfZGF0ZV9waWNrZXJzLmxlbmd0aDtcclxuICAgICAgICAgICAgICAgIFxyXG4gICAgICAgICAgICAgICAgaWYobm9fZGF0ZV9waWNrZXJzPjEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy90aGVuIGl0IGlzIGEgZGF0ZSByYW5nZSwgc28gbWFrZSBzdXJlIGJvdGggZmllbGRzIGFyZSBmaWxsZWQgYmVmb3JlIHVwZGF0aW5nXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRwX2NvdW50ZXIgPSAwO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkcF9lbXB0eV9maWVsZF9jb3VudCA9IDA7XHJcbiAgICAgICAgICAgICAgICAgICAgJHRmX2RhdGVfcGlja2Vycy5lYWNoKGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkKHRoaXMpLnZhbCgpPT1cIlwiKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkcF9lbXB0eV9maWVsZF9jb3VudCsrO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBkcF9jb3VudGVyKys7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKGRwX2VtcHR5X2ZpZWxkX2NvdW50PT0wKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgxKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgxKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuYWRkUmFuZ2VTbGlkZXJzID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRtZXRhX3JhbmdlID0gJHRoaXMuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNsaWRlclwiKTtcclxuXHJcbiAgICAgICAgICAgIGlmKCRtZXRhX3JhbmdlLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkbWV0YV9yYW5nZS5lYWNoKGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1pbiA9ICR0aGlzLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWF4ID0gJHRoaXMuYXR0cihcImRhdGEtbWF4XCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzbWluID0gJHRoaXMuYXR0cihcImRhdGEtc3RhcnQtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzbWF4ID0gJHRoaXMuYXR0cihcImRhdGEtc3RhcnQtbWF4XCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkaXNwbGF5X3ZhbHVlX2FzID0gJHRoaXMuYXR0cihcImRhdGEtZGlzcGxheS12YWx1ZXMtYXNcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0ZXAgPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGVwXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkc3RhcnRfdmFsID0gJHRoaXMuZmluZCgnLnNmLXJhbmdlLW1pbicpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkZW5kX3ZhbCA9ICR0aGlzLmZpbmQoJy5zZi1yYW5nZS1tYXgnKTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkZWNpbWFsX3BsYWNlcyA9ICR0aGlzLmF0dHIoXCJkYXRhLWRlY2ltYWwtcGxhY2VzXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciB0aG91c2FuZF9zZXBlcmF0b3IgPSAkdGhpcy5hdHRyKFwiZGF0YS10aG91c2FuZC1zZXBlcmF0b3JcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRlY2ltYWxfc2VwZXJhdG9yID0gJHRoaXMuYXR0cihcImRhdGEtZGVjaW1hbC1zZXBlcmF0b3JcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZF9mb3JtYXQgPSB3TnVtYih7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG1hcms6IGRlY2ltYWxfc2VwZXJhdG9yLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBkZWNpbWFsczogcGFyc2VGbG9hdChkZWNpbWFsX3BsYWNlcyksXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRob3VzYW5kOiB0aG91c2FuZF9zZXBlcmF0b3JcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWluX3VuZm9ybWF0dGVkID0gcGFyc2VGbG9hdChzbWluKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWluX2Zvcm1hdHRlZCA9IGZpZWxkX2Zvcm1hdC50byhwYXJzZUZsb2F0KHNtaW4pKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWF4X2Zvcm1hdHRlZCA9IGZpZWxkX2Zvcm1hdC50byhwYXJzZUZsb2F0KHNtYXgpKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWF4X3VuZm9ybWF0dGVkID0gcGFyc2VGbG9hdChzbWF4KTtcclxuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9hbGVydChkaXNwbGF5X3ZhbHVlX2FzKTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKGRpc3BsYXlfdmFsdWVfYXM9PVwidGV4dGlucHV0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLnZhbChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwudmFsKG1heF9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGRpc3BsYXlfdmFsdWVfYXM9PVwidGV4dFwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5odG1sKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5odG1sKG1heF9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBub1VJT3B0aW9ucyA9IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgcmFuZ2U6IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICdtaW4nOiBbIHBhcnNlRmxvYXQobWluKSBdLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJ21heCc6IFsgcGFyc2VGbG9hdChtYXgpIF1cclxuICAgICAgICAgICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgc3RhcnQ6IFttaW5fZm9ybWF0dGVkLCBtYXhfZm9ybWF0dGVkXSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgaGFuZGxlczogMixcclxuICAgICAgICAgICAgICAgICAgICAgICAgY29ubmVjdDogdHJ1ZSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgc3RlcDogcGFyc2VGbG9hdChzdGVwKSxcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGJlaGF2aW91cjogJ2V4dGVuZC10YXAnLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBmb3JtYXQ6IGZpZWxkX2Zvcm1hdFxyXG4gICAgICAgICAgICAgICAgICAgIH07XHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBub1VJT3B0aW9ucy5kaXJlY3Rpb24gPSBcInJ0bFwiO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9vYmplY3QgPSAkKHRoaXMpLmZpbmQoXCIubWV0YS1zbGlkZXJcIilbMF07XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCBcInVuZGVmaW5lZFwiICE9PSB0eXBlb2YoIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlciApICkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2Rlc3Ryb3kgaWYgaXQgZXhpc3RzLi4gdGhpcyBtZWFucyBzb21laG93IGFub3RoZXIgaW5zdGFuY2UgaGFkIGluaXRpYWxpc2VkIGl0Li5cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmRlc3Ryb3koKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIG5vVWlTbGlkZXIuY3JlYXRlKHNsaWRlcl9vYmplY3QsIG5vVUlPcHRpb25zKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5vZmYoKTtcclxuICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFskKHRoaXMpLnZhbCgpLCBudWxsXSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLm9mZigpO1xyXG4gICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFtudWxsLCAkKHRoaXMpLnZhbCgpXSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vJHN0YXJ0X3ZhbC5odG1sKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vJGVuZF92YWwuaHRtbChtYXhfZm9ybWF0dGVkKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLm9mZigndXBkYXRlJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLm9uKCd1cGRhdGUnLCBmdW5jdGlvbiggdmFsdWVzLCBoYW5kbGUgKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX3N0YXJ0X3ZhbCAgPSBtaW5fZm9ybWF0dGVkO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX2VuZF92YWwgID0gbWF4X2Zvcm1hdHRlZDtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB2YWx1ZSA9IHZhbHVlc1toYW5kbGVdO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmICggaGFuZGxlICkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbWF4X2Zvcm1hdHRlZCA9IHZhbHVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbWluX2Zvcm1hdHRlZCA9IHZhbHVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRpbnB1dFwiKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLnZhbChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLnZhbChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGRpc3BsYXlfdmFsdWVfYXM9PVwidGV4dFwiKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5odG1sKG1heF9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pIHRoaW5rIHRoZSBmdW5jdGlvbiB0aGF0IGJ1aWxkcyB0aGUgVVJMIG5lZWRzIHRvIGRlY29kZSB0aGUgZm9ybWF0dGVkIHN0cmluZyBiZWZvcmUgYWRkaW5nIHRvIHRoZSB1cmxcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHNlbGYuYXV0b191cGRhdGU9PTEpfHwoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vb25seSB0cnkgdG8gdXBkYXRlIGlmIHRoZSB2YWx1ZXMgaGF2ZSBhY3R1YWxseSBjaGFuZ2VkXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZigoc2xpZGVyX3N0YXJ0X3ZhbCE9bWluX2Zvcm1hdHRlZCl8fChzbGlkZXJfZW5kX3ZhbCE9bWF4X2Zvcm1hdHRlZCkpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSg4MDApO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7IC8vaWdub3JlIGFueSBjaGFuZ2VzIHJlY2VudGx5IG1hZGUgYnkgdGhlIHNsaWRlciAodGhpcyB3YXMganVzdCBpbml0IHNob3VsZG4ndCBjb3VudCBhcyBhbiB1cGRhdGUgZXZlbnQpXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmluaXQgPSBmdW5jdGlvbihrZWVwX3BhZ2luYXRpb24pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZih0eXBlb2Yoa2VlcF9wYWdpbmF0aW9uKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGtlZXBfcGFnaW5hdGlvbiA9IGZhbHNlO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB0aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzKCk7XHJcbiAgICAgICAgICAgIHRoaXMuYXR0YWNoQWN0aXZlQ2xhc3MoKTtcclxuXHJcbiAgICAgICAgICAgIHRoaXMuYWRkRGF0ZVBpY2tlcnMoKTtcclxuICAgICAgICAgICAgdGhpcy5hZGRSYW5nZVNsaWRlcnMoKTtcclxuXHJcbiAgICAgICAgICAgIC8vaW5pdCBjb21ibyBib3hlc1xyXG4gICAgICAgICAgICB2YXIgJGNvbWJvYm94ID0gJHRoaXMuZmluZChcInNlbGVjdFtkYXRhLWNvbWJvYm94PScxJ11cIik7XHJcblxyXG4gICAgICAgICAgICBpZigkY29tYm9ib3gubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRjb21ib2JveC5lYWNoKGZ1bmN0aW9uKGluZGV4ICl7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzY2IgPSAkKCB0aGlzICk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG5ybSA9ICR0aGlzY2IuYXR0cihcImRhdGEtY29tYm9ib3gtbnJtXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAodHlwZW9mICR0aGlzY2IuY2hvc2VuICE9IFwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgY2hvc2Vub3B0aW9ucyA9IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlYXJjaF9jb250YWluczogdHJ1ZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHR5cGVvZihucm0pIT09XCJ1bmRlZmluZWRcIikmJihucm0pKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNob3Nlbm9wdGlvbnMubm9fcmVzdWx0c190ZXh0ID0gbnJtO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vIHNhZmUgdG8gdXNlIHRoZSBmdW5jdGlvblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3NlYXJjaF9jb250YWluc1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX3J0bD09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNjYi5hZGRDbGFzcyhcImNob3Nlbi1ydGxcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzY2IuY2hvc2VuKGNob3Nlbm9wdGlvbnMpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNlbGVjdDJvcHRpb25zID0ge307XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX3J0bD09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VsZWN0Mm9wdGlvbnMuZGlyID0gXCJydGxcIjtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigodHlwZW9mKG5ybSkhPT1cInVuZGVmaW5lZFwiKSYmKG5ybSkpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VsZWN0Mm9wdGlvbnMubGFuZ3VhZ2U9IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBcIm5vUmVzdWx0c1wiOiBmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gbnJtO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzY2Iuc2VsZWN0MihzZWxlY3Qyb3B0aW9ucyk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gZmFsc2U7XHJcblxyXG4gICAgICAgICAgICAvL2lmIGFqYXggaXMgZW5hYmxlZCBpbml0IHRoZSBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zZXR1cEFqYXhQYWdpbmF0aW9uKCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICR0aGlzLm9uKFwic3VibWl0XCIsIHRoaXMuc3VibWl0Rm9ybSk7XHJcblxyXG4gICAgICAgICAgICBzZWxmLmluaXRXb29Db21tZXJjZUNvbnRyb2xzKCk7IC8vd29vY29tbWVyY2Ugb3JkZXJieVxyXG5cclxuICAgICAgICAgICAgaWYoa2VlcF9wYWdpbmF0aW9uPT1mYWxzZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMub25XaW5kb3dTY3JvbGwgPSBmdW5jdGlvbihldmVudClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKCghc2VsZi5pc19sb2FkaW5nX21vcmUpICYmICghc2VsZi5pc19tYXhfcGFnZWQpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgd2luZG93X3Njcm9sbCA9ICQod2luZG93KS5zY3JvbGxUb3AoKTtcclxuICAgICAgICAgICAgICAgIHZhciB3aW5kb3dfc2Nyb2xsX2JvdHRvbSA9ICQod2luZG93KS5zY3JvbGxUb3AoKSArICQod2luZG93KS5oZWlnaHQoKTtcclxuICAgICAgICAgICAgICAgIHZhciBzY3JvbGxfb2Zmc2V0ID0gcGFyc2VJbnQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfdHJpZ2dlcl9hbW91bnQpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIubGVuZ3RoPT0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3Njcm9sbF9ib3R0b20gPSBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLm9mZnNldCgpLnRvcCArIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuaGVpZ2h0KCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBvZmZzZXQgPSAoc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5vZmZzZXQoKS50b3AgKyBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmhlaWdodCgpKSAtIHdpbmRvd19zY3JvbGw7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHdpbmRvd19zY3JvbGxfYm90dG9tID4gcmVzdWx0c19zY3JvbGxfYm90dG9tICsgc2Nyb2xsX29mZnNldClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYubG9hZE1vcmVSZXN1bHRzKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICB7Ly9kb250IGxvYWQgbW9yZVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuc3RyaXBRdWVyeVN0cmluZ0FuZEhhc2hGcm9tUGF0aCA9IGZ1bmN0aW9uKHVybCkge1xyXG4gICAgICAgICAgICByZXR1cm4gdXJsLnNwbGl0KFwiP1wiKVswXS5zcGxpdChcIiNcIilbMF07XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmd1cCA9IGZ1bmN0aW9uKCBuYW1lLCB1cmwgKSB7XHJcbiAgICAgICAgICAgIGlmICghdXJsKSB1cmwgPSBsb2NhdGlvbi5ocmVmXHJcbiAgICAgICAgICAgIG5hbWUgPSBuYW1lLnJlcGxhY2UoL1tcXFtdLyxcIlxcXFxcXFtcIikucmVwbGFjZSgvW1xcXV0vLFwiXFxcXFxcXVwiKTtcclxuICAgICAgICAgICAgdmFyIHJlZ2V4UyA9IFwiW1xcXFw/Jl1cIituYW1lK1wiPShbXiYjXSopXCI7XHJcbiAgICAgICAgICAgIHZhciByZWdleCA9IG5ldyBSZWdFeHAoIHJlZ2V4UyApO1xyXG4gICAgICAgICAgICB2YXIgcmVzdWx0cyA9IHJlZ2V4LmV4ZWMoIHVybCApO1xyXG4gICAgICAgICAgICByZXR1cm4gcmVzdWx0cyA9PSBudWxsID8gbnVsbCA6IHJlc3VsdHNbMV07XHJcbiAgICAgICAgfTtcclxuXHJcblxyXG4gICAgICAgIHRoaXMuZ2V0VXJsUGFyYW1zID0gZnVuY3Rpb24oa2VlcF9wYWdpbmF0aW9uLCB0eXBlLCBleGNsdWRlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGtlZXBfcGFnaW5hdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBrZWVwX3BhZ2luYXRpb24gPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YodHlwZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB0eXBlID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHVybF9wYXJhbXNfc3RyID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIC8vIGdldCBhbGwgcGFyYW1zIGZyb20gZmllbGRzXHJcbiAgICAgICAgICAgIHZhciB1cmxfcGFyYW1zX2FycmF5ID0gcHJvY2Vzc19mb3JtLmdldFVybFBhcmFtcyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyh1cmxfcGFyYW1zX2FycmF5KS5sZW5ndGg7XHJcbiAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YoZXhjbHVkZSkhPVwidW5kZWZpbmVkXCIpIHtcclxuICAgICAgICAgICAgICAgIGlmICh1cmxfcGFyYW1zX2FycmF5Lmhhc093blByb3BlcnR5KGV4Y2x1ZGUpKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgbGVuZ3RoLS07XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBmb3IgKHZhciBrIGluIHVybF9wYXJhbXNfYXJyYXkpIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAodXJsX3BhcmFtc19hcnJheS5oYXNPd25Qcm9wZXJ0eShrKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGNhbl9hZGQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZih0eXBlb2YoZXhjbHVkZSkhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmKGs9PWV4Y2x1ZGUpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYW5fYWRkID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGNhbl9hZGQpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybF9wYXJhbXNfc3RyICs9IGsgKyBcIj1cIiArIHVybF9wYXJhbXNfYXJyYXlba107XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGNvdW50IDwgbGVuZ3RoIC0gMSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybF9wYXJhbXNfc3RyICs9IFwiJlwiO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvdW50Kys7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgLy9mb3JtIHBhcmFtcyBhcyB1cmwgcXVlcnkgc3RyaW5nXHJcbiAgICAgICAgICAgIHZhciBmb3JtX3BhcmFtcyA9IHVybF9wYXJhbXNfc3RyO1xyXG5cclxuICAgICAgICAgICAgLy9nZXQgdXJsIHBhcmFtcyBmcm9tIHRoZSBmb3JtIGl0c2VsZiAod2hhdCB0aGUgdXNlciBoYXMgc2VsZWN0ZWQpXHJcbiAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgZm9ybV9wYXJhbXMpO1xyXG5cclxuICAgICAgICAgICAgLy9hZGQgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICBpZihrZWVwX3BhZ2luYXRpb249PXRydWUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBwYWdlTnVtYmVyID0gc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZih0eXBlb2YocGFnZU51bWJlcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcGFnZU51bWJlciA9IDE7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYocGFnZU51bWJlcj4xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJzZl9wYWdlZD1cIitwYWdlTnVtYmVyKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy9hZGQgc2ZpZFxyXG4gICAgICAgICAgICAvL3F1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJzZmlkPVwiK3NlbGYuc2ZpZCk7XHJcblxyXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggYW55IGV4dHJhIHBhcmFtcyAoZnJvbSBleHQgcGx1Z2lucykgYW5kIGFkZCB0byB0aGUgdXJsIChpZSB3b29jb21tZXJjZSBgb3JkZXJieWApXHJcbiAgICAgICAgICAgIC8qdmFyIGV4dHJhX3F1ZXJ5X3BhcmFtID0gXCJcIjtcclxuICAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyhzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcykubGVuZ3RoO1xyXG4gICAgICAgICAgICAgdmFyIGNvdW50ID0gMDtcclxuXHJcbiAgICAgICAgICAgICBpZihsZW5ndGg+MClcclxuICAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICBmb3IgKHZhciBrIGluIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zKSB7XHJcbiAgICAgICAgICAgICBpZiAoc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuaGFzT3duUHJvcGVydHkoaykpIHtcclxuXHJcbiAgICAgICAgICAgICBpZihzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1trXSE9XCJcIilcclxuICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgIGV4dHJhX3F1ZXJ5X3BhcmFtID0gaytcIj1cIitzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1trXTtcclxuICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgZXh0cmFfcXVlcnlfcGFyYW0pO1xyXG4gICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgKi9cclxuICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhxdWVyeV9wYXJhbXMsIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zLmFsbCk7XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAvL3F1ZXJ5X3BhcmFtcyA9IHNlbGYuYWRkUXVlcnlQYXJhbXMocXVlcnlfcGFyYW1zLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1t0eXBlXSk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBxdWVyeV9wYXJhbXM7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuYWRkUXVlcnlQYXJhbXMgPSBmdW5jdGlvbihxdWVyeV9wYXJhbXMsIG5ld19wYXJhbXMpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgZXh0cmFfcXVlcnlfcGFyYW0gPSBcIlwiO1xyXG4gICAgICAgICAgICB2YXIgbGVuZ3RoID0gT2JqZWN0LmtleXMobmV3X3BhcmFtcykubGVuZ3RoO1xyXG4gICAgICAgICAgICB2YXIgY291bnQgPSAwO1xyXG5cclxuICAgICAgICAgICAgaWYobGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICBmb3IgKHZhciBrIGluIG5ld19wYXJhbXMpIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAobmV3X3BhcmFtcy5oYXNPd25Qcm9wZXJ0eShrKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYobmV3X3BhcmFtc1trXSE9XCJcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZXh0cmFfcXVlcnlfcGFyYW0gPSBrK1wiPVwiK25ld19wYXJhbXNba107XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIGV4dHJhX3F1ZXJ5X3BhcmFtKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIHF1ZXJ5X3BhcmFtcztcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5hZGRVcmxQYXJhbSA9IGZ1bmN0aW9uKHVybCwgc3RyaW5nKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIGFkZF9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgaWYodXJsIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpZih1cmwuaW5kZXhPZihcIj9cIikgIT0gLTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgYWRkX3BhcmFtcyArPSBcIiZcIjtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3VybCA9IHRoaXMudHJhaWxpbmdTbGFzaEl0KHVybCk7XHJcbiAgICAgICAgICAgICAgICAgICAgYWRkX3BhcmFtcyArPSBcIj9cIjtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoc3RyaW5nIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgICAgcmV0dXJuIHVybCArIGFkZF9wYXJhbXMgKyBzdHJpbmc7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gdXJsO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5qb2luVXJsUGFyYW0gPSBmdW5jdGlvbihwYXJhbXMsIHN0cmluZylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBhZGRfcGFyYW1zID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIGlmKHBhcmFtcyE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgYWRkX3BhcmFtcyArPSBcIiZcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoc3RyaW5nIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgICAgcmV0dXJuIHBhcmFtcyArIGFkZF9wYXJhbXMgKyBzdHJpbmc7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gcGFyYW1zO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5zZXRBamF4UmVzdWx0c1VSTHMgPSBmdW5jdGlvbihxdWVyeV9wYXJhbXMpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZih0eXBlb2Yoc2VsZi5hamF4X3Jlc3VsdHNfY29uZik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmYgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBcIlwiO1xyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXSA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICAvL2lmKHNlbGYuYWpheF91cmwhPVwiXCIpXHJcbiAgICAgICAgICAgIGlmKHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cInNob3J0Y29kZVwiKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdhbnQgdG8gZG8gYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLnJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vYWRkIGxhbmcgY29kZSB0byBhamF4IGFwaSByZXF1ZXN0LCBsYW5nIGNvZGUgc2hvdWxkIGFscmVhZHkgYmUgaW4gdGhlcmUgZm9yIG90aGVyIHJlcXVlc3RzIChpZSwgc3VwcGxpZWQgaW4gdGhlIFJlc3VsdHMgVVJMKVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKHNlbGYubGFuZ19jb2RlIT1cIlwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vc28gYWRkIGl0XHJcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcImxhbmc9XCIrc2VsZi5sYW5nX2NvZGUpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF91cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gJ2pzb24nO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cInBvc3RfdHlwZV9hcmNoaXZlXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHByb2Nlc3NfZm9ybS5nZXRSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwiY3VzdG9tX3dvb2NvbW1lcmNlX3N0b3JlXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHByb2Nlc3NfZm9ybS5nZXRSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgey8vb3RoZXJ3aXNlIHdlIHdhbnQgdG8gcHVsbCB0aGUgcmVzdWx0cyBkaXJlY3RseSBmcm9tIHRoZSByZXN1bHRzIHBhZ2VcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYucmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLmFqYXhfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXSA9ICdodG1sJztcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkUXVlcnlQYXJhbXMoc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSwgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXNbJ2FqYXgnXSk7XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXSA9IHNlbGYuYWpheF9kYXRhX3R5cGU7XHJcbiAgICAgICAgfTtcclxuXHJcblxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZUxvYWRlclRhZyA9IGZ1bmN0aW9uKCRvYmplY3QsIHRhZ05hbWUpIHtcclxuXHJcbiAgICAgICAgICAgIHZhciAkcGFyZW50O1xyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkcGFyZW50ID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcykubGFzdCgpLnBhcmVudCgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJHBhcmVudCA9IHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciB0YWdOYW1lID0gJHBhcmVudC5wcm9wKFwidGFnTmFtZVwiKTtcclxuXHJcbiAgICAgICAgICAgIHZhciB0YWdUeXBlID0gJ2Rpdic7XHJcbiAgICAgICAgICAgIGlmKCAoIHRhZ05hbWUudG9Mb3dlckNhc2UoKSA9PSAnb2wnICkgfHwgKCB0YWdOYW1lLnRvTG93ZXJDYXNlKCkgPT0gJ3VsJyApICl7XHJcbiAgICAgICAgICAgICAgICB0YWdUeXBlID0gJ2xpJztcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyICRuZXcgPSAkKCc8Jyt0YWdUeXBlKycgLz4nKS5odG1sKCRvYmplY3QuaHRtbCgpKTtcclxuICAgICAgICAgICAgdmFyIGF0dHJpYnV0ZXMgPSAkb2JqZWN0LnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG5cclxuICAgICAgICAgICAgLy8gbG9vcCB0aHJvdWdoIDxzZWxlY3Q+IGF0dHJpYnV0ZXMgYW5kIGFwcGx5IHRoZW0gb24gPGRpdj5cclxuICAgICAgICAgICAgJC5lYWNoKGF0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJG5ldy5hdHRyKHRoaXMubmFtZSwgdGhpcy52YWx1ZSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgcmV0dXJuICRuZXc7XHJcblxyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMubG9hZE1vcmVSZXN1bHRzID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgc2VsZi5pc19sb2FkaW5nX21vcmUgPSB0cnVlO1xyXG5cclxuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XHJcbiAgICAgICAgICAgIHZhciBldmVudF9kYXRhID0ge1xyXG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxyXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcclxuICAgICAgICAgICAgICAgIHR5cGU6IFwibG9hZF9tb3JlXCIsXHJcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheHN0YXJ0XCIsIGV2ZW50X2RhdGEpO1xyXG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgIFxyXG4gICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSk7XHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpOyAvL2dyYWIgYSBjb3B5IG9mIGh0ZSBVUkwgcGFyYW1zIHdpdGhvdXQgcGFnaW5hdGlvbiBhbHJlYWR5IGFkZGVkXHJcblxyXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBhamF4X3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwiXCI7XHJcblxyXG5cclxuICAgICAgICAgICAgLy9ub3cgYWRkIHRoZSBuZXcgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICB2YXIgbmV4dF9wYWdlZF9udW1iZXIgPSB0aGlzLmN1cnJlbnRfcGFnZWQgKyAxO1xyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrbmV4dF9wYWdlZF9udW1iZXIpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ107XHJcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xyXG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcclxuXHJcbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcclxuICAgICAgICAgICAgaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGxvYWRlciA9ICQoJzxkaXYvPicse1xyXG4gICAgICAgICAgICAgICAgICAgICdjbGFzcyc6ICdzZWFyY2gtZmlsdGVyLXNjcm9sbC1sb2FkaW5nJ1xyXG4gICAgICAgICAgICAgICAgfSk7Ly8uYXBwZW5kVG8oc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lcik7XHJcblxyXG4gICAgICAgICAgICAgICAgJGxvYWRlciA9IHNlbGYudXBkYXRlTG9hZGVyVGFnKCRsb2FkZXIpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoJGxvYWRlcik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QgPSAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuY3VycmVudF9wYWdlZCsrO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLyogc2Nyb2xsICovXHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuc2Nyb2xsUmVzdWx0cygpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlcyB0aGUgcmVzdXRscyAmIGZvcm0gaHRtbFxyXG4gICAgICAgICAgICAgICAgc2VsZi5hZGRSZXN1bHRzKGRhdGEsIGRhdGFfdHlwZSk7XHJcblxyXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgZGF0YSk7XHJcblxyXG4gICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICRsb2FkZXIuZGV0YWNoKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc19sb2FkaW5nX21vcmUgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmaW5pc2hcIiwgZGF0YSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5mZXRjaEFqYXhSZXN1bHRzID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XHJcbiAgICAgICAgICAgIHZhciBldmVudF9kYXRhID0ge1xyXG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxyXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcclxuICAgICAgICAgICAgICAgIHR5cGU6IFwibG9hZF9yZXN1bHRzXCIsXHJcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheHN0YXJ0XCIsIGV2ZW50X2RhdGEpO1xyXG5cclxuICAgICAgICAgICAgLy9yZWZvY3VzIGFueSBpbnB1dCBmaWVsZHMgYWZ0ZXIgdGhlIGZvcm0gaGFzIGJlZW4gdXBkYXRlZFxyXG4gICAgICAgICAgICB2YXIgJGxhc3RfYWN0aXZlX2lucHV0X3RleHQgPSAkdGhpcy5maW5kKCdpbnB1dFt0eXBlPVwidGV4dFwiXTpmb2N1cycpLm5vdChcIi5zZi1kYXRlcGlja2VyXCIpO1xyXG4gICAgICAgICAgICBpZigkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dC5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0ID0gJGxhc3RfYWN0aXZlX2lucHV0X3RleHQuYXR0cihcIm5hbWVcIik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICR0aGlzLmFkZENsYXNzKFwic2VhcmNoLWZpbHRlci1kaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmRpc2FibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgICAgICAvL2ZhZGUgb3V0IHJlc3VsdHNcclxuICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hbmltYXRlKHsgb3BhY2l0eTogMC41IH0sIFwiZmFzdFwiKTsgLy9sb2FkaW5nXHJcbiAgICAgICAgICAgIHNlbGYuZmFkZUNvbnRlbnRBcmVhcyggXCJvdXRcIiApO1xyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi5hamF4X2FjdGlvbj09XCJwYWdpbmF0aW9uXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vbmVlZCB0byByZW1vdmUgYWN0aXZlIGZpbHRlciBmcm9tIFVSTFxyXG5cclxuICAgICAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXM7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9ub3cgYWRkIHRoZSBuZXcgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgdmFyIHBhZ2VOdW1iZXIgPSBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihwYWdlTnVtYmVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBwYWdlTnVtYmVyID0gMTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihwYWdlTnVtYmVyPjEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK3BhZ2VOdW1iZXIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHNlbGYuYWpheF9hY3Rpb249PVwic3VibWl0XCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyh0cnVlKTtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpOyAvL2dyYWIgYSBjb3B5IG9mIGh0ZSBVUkwgcGFyYW1zIHdpdGhvdXQgcGFnaW5hdGlvbiBhbHJlYWR5IGFkZGVkXHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBhamF4X3Byb2Nlc3NpbmdfdXJsID0gXCJcIjtcclxuICAgICAgICAgICAgdmFyIGFqYXhfcmVzdWx0c191cmwgPSBcIlwiO1xyXG4gICAgICAgICAgICB2YXIgZGF0YV90eXBlID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuc2V0QWpheFJlc3VsdHNVUkxzKHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddO1xyXG4gICAgICAgICAgICBhamF4X3Jlc3VsdHNfdXJsID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXTtcclxuICAgICAgICAgICAgZGF0YV90eXBlID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ107XHJcblxyXG5cclxuICAgICAgICAgICAgLy9hYm9ydCBhbnkgcHJldmlvdXMgYWpheCByZXF1ZXN0c1xyXG4gICAgICAgICAgICBpZihzZWxmLmxhc3RfYWpheF9yZXF1ZXN0KVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0LmFib3J0KCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgdmFyIGFqYXhfYWN0aW9uID0gc2VsZi5hamF4X2FjdGlvbjtcclxuICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9ICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLy91cGRhdGVzIHRoZSByZXN1dGxzICYgZm9ybSBodG1sXHJcbiAgICAgICAgICAgICAgICBzZWxmLnVwZGF0ZVJlc3VsdHMoZGF0YSwgZGF0YV90eXBlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvLyBzY3JvbGwgXHJcbiAgICAgICAgICAgICAgICAvLyBzZXQgdGhlIHZhciBiYWNrIHRvIHdoYXQgaXQgd2FzIGJlZm9yZSB0aGUgYWpheCByZXF1ZXN0IG5hZCB0aGUgZm9ybSByZS1pbml0XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gYWpheF9hY3Rpb247XHJcbiAgICAgICAgICAgICAgICBzZWxmLnNjcm9sbFJlc3VsdHMoIHNlbGYuYWpheF9hY3Rpb24gKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvKiB1cGRhdGUgVVJMICovXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZSB1cmwgYmVmb3JlIHBhZ2luYXRpb24sIGJlY2F1c2Ugd2UgbmVlZCB0byBkbyBzb21lIGNoZWNrcyBhZ2FpbnMgdGhlIFVSTCBmb3IgaW5maW5pdGUgc2Nyb2xsXHJcbiAgICAgICAgICAgICAgICBzZWxmLnVwZGF0ZVVybEhpc3RvcnkoYWpheF9yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zZXR1cCBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICBzZWxmLnNldHVwQWpheFBhZ2luYXRpb24oKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgICAgIC8qIHVzZXIgZGVmICovXHJcbiAgICAgICAgICAgICAgICBzZWxmLmluaXRXb29Db21tZXJjZUNvbnRyb2xzKCk7IC8vd29vY29tbWVyY2Ugb3JkZXJieVxyXG5cclxuXHJcbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcclxuICAgICAgICAgICAgICAgIGRhdGEuanFYSFIgPSBqcVhIUjtcclxuICAgICAgICAgICAgICAgIGRhdGEudGV4dFN0YXR1cyA9IHRleHRTdGF0dXM7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgZGF0YSk7XHJcblxyXG4gICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLnN0b3AodHJ1ZSx0cnVlKS5hbmltYXRlKHsgb3BhY2l0eTogMX0sIFwiZmFzdFwiKTsgLy9maW5pc2hlZCBsb2FkaW5nXHJcbiAgICAgICAgICAgICAgICBzZWxmLmZhZGVDb250ZW50QXJlYXMoIFwiaW5cIiApO1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcbiAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZW5hYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vcmVmb2N1cyB0aGUgbGFzdCBhY3RpdmUgdGV4dCBmaWVsZFxyXG4gICAgICAgICAgICAgICAgaWYobGFzdF9hY3RpdmVfaW5wdXRfdGV4dCE9XCJcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gW107XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlX2lucHV0ID0gJCh0aGlzKS5maW5kKFwiaW5wdXRbbmFtZT0nXCIrbGFzdF9hY3RpdmVfaW5wdXRfdGV4dCtcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkYWN0aXZlX2lucHV0Lmxlbmd0aD09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGlucHV0ID0gJGFjdGl2ZV9pbnB1dDtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICBpZigkaW5wdXQubGVuZ3RoPT0xKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkaW5wdXQuZm9jdXMoKS52YWwoJGlucHV0LnZhbCgpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5mb2N1c0NhbXBvKCRpbnB1dFswXSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLmZpbmQoXCJpbnB1dFtuYW1lPSdfc2Zfc2VhcmNoJ11cIikudHJpZ2dlcignZm9jdXMnKTtcclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZpbmlzaFwiLCAgZGF0YSApO1xyXG5cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5mb2N1c0NhbXBvID0gZnVuY3Rpb24oaW5wdXRGaWVsZCl7XHJcbiAgICAgICAgICAgIC8vdmFyIGlucHV0RmllbGQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChpZCk7XHJcbiAgICAgICAgICAgIGlmIChpbnB1dEZpZWxkICE9IG51bGwgJiYgaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGggIT0gMCl7XHJcbiAgICAgICAgICAgICAgICBpZiAoaW5wdXRGaWVsZC5jcmVhdGVUZXh0UmFuZ2Upe1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBGaWVsZFJhbmdlID0gaW5wdXRGaWVsZC5jcmVhdGVUZXh0UmFuZ2UoKTtcclxuICAgICAgICAgICAgICAgICAgICBGaWVsZFJhbmdlLm1vdmVTdGFydCgnY2hhcmFjdGVyJyxpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aCk7XHJcbiAgICAgICAgICAgICAgICAgICAgRmllbGRSYW5nZS5jb2xsYXBzZSgpO1xyXG4gICAgICAgICAgICAgICAgICAgIEZpZWxkUmFuZ2Uuc2VsZWN0KCk7XHJcbiAgICAgICAgICAgICAgICB9ZWxzZSBpZiAoaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCB8fCBpbnB1dEZpZWxkLnNlbGVjdGlvblN0YXJ0ID09ICcwJykge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBlbGVtTGVuID0gaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGg7XHJcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCA9IGVsZW1MZW47XHJcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5zZWxlY3Rpb25FbmQgPSBlbGVtTGVuO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5ibHVyKCk7XHJcbiAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLmZvY3VzKCk7XHJcbiAgICAgICAgICAgIH0gZWxzZXtcclxuICAgICAgICAgICAgICAgIGlmICggaW5wdXRGaWVsZCApIHtcclxuICAgICAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLmZvY3VzKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy50cmlnZ2VyRXZlbnQgPSBmdW5jdGlvbihldmVudG5hbWUsIGRhdGEpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJGV2ZW50X2NvbnRhaW5lciA9ICQoXCIuc2VhcmNoYW5kZmlsdGVyW2RhdGEtc2YtZm9ybS1pZD0nXCIrc2VsZi5zZmlkK1wiJ11cIik7XHJcbiAgICAgICAgICAgICRldmVudF9jb250YWluZXIudHJpZ2dlcihldmVudG5hbWUsIFsgZGF0YSBdKTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuZmV0Y2hBamF4Rm9ybSA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIC8vdHJpZ2dlciBzdGFydCBldmVudFxyXG4gICAgICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHtcclxuICAgICAgICAgICAgICAgIHNmaWQ6IHNlbGYuc2ZpZCxcclxuICAgICAgICAgICAgICAgIHRhcmdldFNlbGVjdG9yOiBzZWxmLmFqYXhfdGFyZ2V0X2F0dHIsXHJcbiAgICAgICAgICAgICAgICB0eXBlOiBcImZvcm1cIixcclxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxyXG4gICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4Zm9ybXN0YXJ0XCIsIFsgZXZlbnRfZGF0YSBdKTtcclxuXHJcbiAgICAgICAgICAgICR0aGlzLmFkZENsYXNzKFwic2VhcmNoLWZpbHRlci1kaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmRpc2FibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoKTtcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYubGFuZ19jb2RlIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAvL3NvIGFkZCBpdFxyXG4gICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcImxhbmc9XCIrc2VsZi5sYW5nX2NvZGUpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5hamF4X2Zvcm1fdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG4gICAgICAgICAgICB2YXIgZGF0YV90eXBlID0gXCJqc29uXCI7XHJcblxyXG5cclxuICAgICAgICAgICAgLy9hYm9ydCBhbnkgcHJldmlvdXMgYWpheCByZXF1ZXN0c1xyXG4gICAgICAgICAgICAvKmlmKHNlbGYubGFzdF9hamF4X3JlcXVlc3QpXHJcbiAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0LmFib3J0KCk7XHJcbiAgICAgICAgICAgICB9Ki9cclxuXHJcblxyXG4gICAgICAgICAgICAvL3NlbGYubGFzdF9hamF4X3JlcXVlc3QgPVxyXG5cclxuICAgICAgICAgICAgJC5nZXQoYWpheF9wcm9jZXNzaW5nX3VybCwgZnVuY3Rpb24oZGF0YSwgc3RhdHVzLCByZXF1ZXN0KVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAvL3NlbGYubGFzdF9hamF4X3JlcXVlc3QgPSBudWxsO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlcyB0aGUgcmVzdXRscyAmIGZvcm0gaHRtbFxyXG4gICAgICAgICAgICAgICAgc2VsZi51cGRhdGVGb3JtKGRhdGEsIGRhdGFfdHlwZSk7XHJcblxyXG5cclxuICAgICAgICAgICAgfSwgZGF0YV90eXBlKS5mYWlsKGZ1bmN0aW9uKGpxWEhSLCB0ZXh0U3RhdHVzLCBlcnJvclRocm93bilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmFqYXhVUkwgPSBhamF4X3Byb2Nlc3NpbmdfdXJsO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5qcVhIUiA9IGpxWEhSO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50ZXh0U3RhdHVzID0gdGV4dFN0YXR1cztcclxuICAgICAgICAgICAgICAgIGRhdGEuZXJyb3JUaHJvd24gPSBlcnJvclRocm93bjtcclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGVycm9yXCIsIFsgZGF0YSBdKTtcclxuXHJcbiAgICAgICAgICAgIH0pLmFsd2F5cyhmdW5jdGlvbigpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLnJlbW92ZUNsYXNzKFwic2VhcmNoLWZpbHRlci1kaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4Zm9ybWZpbmlzaFwiLCBbIGRhdGEgXSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuY29weUxpc3RJdGVtc0NvbnRlbnRzID0gZnVuY3Rpb24oJGxpc3RfZnJvbSwgJGxpc3RfdG8pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgICAgICAvL2NvcHkgb3ZlciBjaGlsZCBsaXN0IGl0ZW1zXHJcbiAgICAgICAgICAgIHZhciBsaV9jb250ZW50c19hcnJheSA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gbmV3IEFycmF5KCk7XHJcblxyXG4gICAgICAgICAgICB2YXIgJGZyb21fZmllbGRzID0gJGxpc3RfZnJvbS5maW5kKFwiPiB1bCA+IGxpXCIpO1xyXG5cclxuICAgICAgICAgICAgJGZyb21fZmllbGRzLmVhY2goZnVuY3Rpb24oaSl7XHJcblxyXG4gICAgICAgICAgICAgICAgbGlfY29udGVudHNfYXJyYXkucHVzaCgkKHRoaXMpLmh0bWwoKSk7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIGF0dHJpYnV0ZXMgPSAkKHRoaXMpLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG4gICAgICAgICAgICAgICAgZnJvbV9hdHRyaWJ1dGVzLnB1c2goYXR0cmlidXRlcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy92YXIgZmllbGRfbmFtZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuICAgICAgICAgICAgICAgIC8vdmFyIHRvX2ZpZWxkID0gJGxpc3RfdG8uZmluZChcIj4gdWwgPiBsaVtkYXRhLXNmLWZpZWxkLW5hbWU9J1wiK2ZpZWxkX25hbWUrXCInXVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuY29weUF0dHJpYnV0ZXMoJCh0aGlzKSwgJGxpc3RfdG8sIFwiZGF0YS1zZi1cIik7XHJcblxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgIHZhciBsaV9pdCA9IDA7XHJcbiAgICAgICAgICAgIHZhciAkdG9fZmllbGRzID0gJGxpc3RfdG8uZmluZChcIj4gdWwgPiBsaVwiKTtcclxuICAgICAgICAgICAgJHRvX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGkpe1xyXG4gICAgICAgICAgICAgICAgJCh0aGlzKS5odG1sKGxpX2NvbnRlbnRzX2FycmF5W2xpX2l0XSk7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICRmcm9tX2ZpZWxkID0gJCgkZnJvbV9maWVsZHMuZ2V0KGxpX2l0KSk7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICR0b19maWVsZCA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICAkdG9fZmllbGQucmVtb3ZlQXR0cihcImRhdGEtc2YtdGF4b25vbXktYXJjaGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuY29weUF0dHJpYnV0ZXMoJGZyb21fZmllbGQsICR0b19maWVsZCk7XHJcblxyXG4gICAgICAgICAgICAgICAgbGlfaXQrKztcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAvKnZhciAkZnJvbV9maWVsZHMgPSAkbGlzdF9mcm9tLmZpbmQoXCIgdWwgPiBsaVwiKTtcclxuICAgICAgICAgICAgIHZhciAkdG9fZmllbGRzID0gJGxpc3RfdG8uZmluZChcIiA+IGxpXCIpO1xyXG4gICAgICAgICAgICAgJGZyb21fZmllbGRzLmVhY2goZnVuY3Rpb24oaW5kZXgsIHZhbCl7XHJcbiAgICAgICAgICAgICBpZigkKHRoaXMpLmhhc0F0dHJpYnV0ZShcImRhdGEtc2YtdGF4b25vbXktYXJjaGl2ZVwiKSlcclxuICAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzKCRsaXN0X2Zyb20sICRsaXN0X3RvKTsqL1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy51cGRhdGVGb3JtQXR0cmlidXRlcyA9IGZ1bmN0aW9uKCRsaXN0X2Zyb20sICRsaXN0X3RvKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIGZyb21fYXR0cmlidXRlcyA9ICRsaXN0X2Zyb20ucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcbiAgICAgICAgICAgIC8vIGxvb3AgdGhyb3VnaCA8c2VsZWN0PiBhdHRyaWJ1dGVzIGFuZCBhcHBseSB0aGVtIG9uIDxkaXY+XHJcblxyXG4gICAgICAgICAgICB2YXIgdG9fYXR0cmlidXRlcyA9ICRsaXN0X3RvLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG4gICAgICAgICAgICAkLmVhY2godG9fYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAkbGlzdF90by5yZW1vdmVBdHRyKHRoaXMubmFtZSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgJC5lYWNoKGZyb21fYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAkbGlzdF90by5hdHRyKHRoaXMubmFtZSwgdGhpcy52YWx1ZSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuY29weUF0dHJpYnV0ZXMgPSBmdW5jdGlvbigkZnJvbSwgJHRvLCBwcmVmaXgpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZih0eXBlb2YocHJlZml4KT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHByZWZpeCA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBmcm9tX2F0dHJpYnV0ZXMgPSAkZnJvbS5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuXHJcbiAgICAgICAgICAgIHZhciB0b19hdHRyaWJ1dGVzID0gJHRvLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG4gICAgICAgICAgICAkLmVhY2godG9fYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYocHJlZml4IT1cIlwiKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHRoaXMubmFtZS5pbmRleE9mKHByZWZpeCkgPT0gMCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvLyR0by5yZW1vdmVBdHRyKHRoaXMubmFtZSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgJC5lYWNoKGZyb21fYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAkdG8uYXR0cih0aGlzLm5hbWUsIHRoaXMudmFsdWUpO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuY29weUZvcm1BdHRyaWJ1dGVzID0gZnVuY3Rpb24oJGZyb20sICR0bylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgICR0by5yZW1vdmVBdHRyKFwiZGF0YS1jdXJyZW50LXRheG9ub215LWFyY2hpdmVcIik7XHJcbiAgICAgICAgICAgIHRoaXMuY29weUF0dHJpYnV0ZXMoJGZyb20sICR0byk7XHJcblxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy51cGRhdGVGb3JtID0gZnVuY3Rpb24oZGF0YSwgZGF0YV90eXBlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgaWYoZGF0YV90eXBlPT1cImpzb25cIilcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSBkaWQgYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50LCBzbyBleHBlY3QgYW4gb2JqZWN0IGJhY2tcclxuXHJcbiAgICAgICAgICAgICAgICBpZih0eXBlb2YoZGF0YVsnZm9ybSddKSE9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgYWxsIGV2ZW50cyBmcm9tIFMmRiBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgJHRoaXMub2ZmKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVmcmVzaCB0aGUgZm9ybSAoYXV0byBjb3VudClcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlMaXN0SXRlbXNDb250ZW50cygkKGRhdGFbJ2Zvcm0nXSksICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgIC8vJHRoaXMuc2VhcmNoQW5kRmlsdGVyKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vaWYgYWpheCBpcyBlbmFibGVkIGluaXQgdGhlIHBhZ2luYXRpb25cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdGhpcy5pbml0KHRydWUpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLnNldHVwQWpheFBhZ2luYXRpb24oKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmFkZFJlc3VsdHMgPSBmdW5jdGlvbihkYXRhLCBkYXRhX3R5cGUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgICAgICBpZihkYXRhX3R5cGU9PVwianNvblwiKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIGRpZCBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnQsIHNvIGV4cGVjdCBhbiBvYmplY3QgYmFja1xyXG4gICAgICAgICAgICAgICAgLy9ncmFiIHRoZSByZXN1bHRzIGFuZCBsb2FkIGluXHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXBwZW5kKGRhdGFbJ3Jlc3VsdHMnXSk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxvYWRfbW9yZV9odG1sID0gZGF0YVsncmVzdWx0cyddO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoZGF0YV90eXBlPT1cImh0bWxcIilcclxuICAgICAgICAgICAgey8vd2UgYXJlIGV4cGVjdGluZyB0aGUgaHRtbCBvZiB0aGUgcmVzdWx0cyBwYWdlIGJhY2ssIHNvIGV4dHJhY3QgdGhlIGh0bWwgd2UgbmVlZFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZGF0YV9vYmogPSAkKGRhdGEpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5hcHBlbmQoJGRhdGFfb2JqLmZpbmQoc2VsZi5hamF4X3RhcmdldF9hdHRyKS5odG1sKCkpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICRkYXRhX29iai5maW5kKHNlbGYuYWpheF90YXJnZXRfYXR0cikuaHRtbCgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgaWYoJChcIjxkaXY+XCIrc2VsZi5sb2FkX21vcmVfaHRtbCtcIjwvZGl2PlwiKS5maW5kKFwiW2RhdGEtc2VhcmNoLWZpbHRlci1hY3Rpb249J2luZmluaXRlLXNjcm9sbC1lbmQnXVwiKS5sZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IHRydWU7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIC8vaWYgdGhlcmUgaXMgYW5vdGhlciBzZWxlY3RvciBmb3IgaW5maW5pdGUgc2Nyb2xsLCBmaW5kIHRoZSBjb250ZW50cyBvZiB0aGF0IGluc3RlYWRcclxuICAgICAgICAgICAgaWYoc2VsZi5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxvYWRfbW9yZV9odG1sID0gJChcIjxkaXY+XCIrc2VsZi5sb2FkX21vcmVfaHRtbCtcIjwvZGl2PlwiKS5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcikuaHRtbCgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyICRyZXN1bHRfaXRlbXMgPSAkKFwiPGRpdj5cIitzZWxmLmxvYWRfbW9yZV9odG1sK1wiPC9kaXY+XCIpLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKTtcclxuICAgICAgICAgICAgICAgIHZhciAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lciA9ICQoJzxkaXYvPicsIHt9KTtcclxuICAgICAgICAgICAgICAgICRyZXN1bHRfaXRlbXNfY29udGFpbmVyLmFwcGVuZCgkcmVzdWx0X2l0ZW1zKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmxvYWRfbW9yZV9odG1sID0gJHJlc3VsdF9pdGVtc19jb250YWluZXIuaHRtbCgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihpbmZpbml0ZV9zY3JvbGxfZW5kKVxyXG4gICAgICAgICAgICB7Ly93ZSBmb3VuZCBhIGRhdGEgYXR0cmlidXRlIHNpZ25hbGxpbmcgdGhlIGxhc3QgcGFnZSBzbyBmaW5pc2ggaGVyZVxyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9sb2FkX21vcmVfaHRtbCA9IHNlbGYubG9hZF9tb3JlX2h0bWw7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pbmZpbml0ZVNjcm9sbEFwcGVuZChzZWxmLmxvYWRfbW9yZV9odG1sKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwhPT1zZWxmLmxvYWRfbW9yZV9odG1sKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAvL2NoZWNrIHRvIG1ha2Ugc3VyZSB0aGUgbmV3IGh0bWwgZmV0Y2hlZCBpcyBkaWZmZXJlbnRcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9sb2FkX21vcmVfaHRtbCA9IHNlbGYubG9hZF9tb3JlX2h0bWw7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmluZmluaXRlU2Nyb2xsQXBwZW5kKHNlbGYubG9hZF9tb3JlX2h0bWwpO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHsvL3dlIHJlY2VpdmVkIHRoZSBzYW1lIG1lc3NhZ2UgYWdhaW4gc28gZG9uJ3QgYWRkLCBhbmQgdGVsbCBTJkYgdGhhdCB3ZSdyZSBhdCB0aGUgZW5kLi5cclxuICAgICAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gdHJ1ZTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMuaW5maW5pdGVTY3JvbGxBcHBlbmQgPSBmdW5jdGlvbigkb2JqZWN0KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKS5sYXN0KCkuYWZ0ZXIoJG9iamVjdCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuYXBwZW5kKCRvYmplY3QpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgdGhpcy51cGRhdGVSZXN1bHRzID0gZnVuY3Rpb24oZGF0YSwgZGF0YV90eXBlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgaWYoZGF0YV90eXBlPT1cImpzb25cIilcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSBkaWQgYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50LCBzbyBleHBlY3QgYW4gb2JqZWN0IGJhY2tcclxuICAgICAgICAgICAgICAgIC8vZ3JhYiB0aGUgcmVzdWx0cyBhbmQgbG9hZCBpblxyXG4gICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5odG1sKGRhdGFbJ3Jlc3VsdHMnXSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKGRhdGFbJ2Zvcm0nXSkhPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLm9mZigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5yZW1vdmVBamF4UGFnaW5hdGlvbigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3JlZnJlc2ggdGhlIGZvcm0gKGF1dG8gY291bnQpXHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5TGlzdEl0ZW1zQ29udGVudHMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vdXBkYXRlIGF0dHJpYnV0ZXMgb24gZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUZvcm1BdHRyaWJ1dGVzKCQoZGF0YVsnZm9ybSddKSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3JlIGluaXQgUyZGIGNsYXNzIG9uIHRoZSBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgJHRoaXMuc2VhcmNoQW5kRmlsdGVyKHsnaXNJbml0JzogZmFsc2V9KTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLmZpbmQoXCJpbnB1dFwiKS5yZW1vdmVBdHRyKFwiZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihkYXRhX3R5cGU9PVwiaHRtbFwiKSB7Ly93ZSBhcmUgZXhwZWN0aW5nIHRoZSBodG1sIG9mIHRoZSByZXN1bHRzIHBhZ2UgYmFjaywgc28gZXh0cmFjdCB0aGUgaHRtbCB3ZSBuZWVkXHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICRkYXRhX29iaiA9ICQoZGF0YSk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5odG1sKCRkYXRhX29iai5maW5kKHNlbGYuYWpheF90YXJnZXRfYXR0cikuaHRtbCgpKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLnVwZGF0ZUNvbnRlbnRBcmVhcyggJGRhdGFfb2JqICk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYgKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJcIikubGVuZ3RoID4gMClcclxuICAgICAgICAgICAgICAgIHsvL3RoZW4gdGhlcmUgYXJlIHNlYXJjaCBmb3JtKHMpIGluc2lkZSB0aGUgcmVzdWx0cyBjb250YWluZXIsIHNvIHJlLWluaXQgdGhlbVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLnNlYXJjaEFuZEZpbHRlcigpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vaWYgdGhlIGN1cnJlbnQgc2VhcmNoIGZvcm0gaXMgbm90IGluc2lkZSB0aGUgcmVzdWx0cyBjb250YWluZXIsIHRoZW4gcHJvY2VlZCBhcyBub3JtYWwgYW5kIHVwZGF0ZSB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiICsgc2VsZi5zZmlkICsgXCInXVwiKS5sZW5ndGg9PTApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRuZXdfc2VhcmNoX2Zvcm0gPSAkZGF0YV9vYmouZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJbZGF0YS1zZi1mb3JtLWlkPSdcIiArIHNlbGYuc2ZpZCArIFwiJ11cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmICgkbmV3X3NlYXJjaF9mb3JtLmxlbmd0aCA9PSAxKSB7Ly90aGVuIHJlcGxhY2UgdGhlIHNlYXJjaCBmb3JtIHdpdGggdGhlIG5ldyBvbmVcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5yZW1vdmVBamF4UGFnaW5hdGlvbigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlMaXN0SXRlbXNDb250ZW50cygkbmV3X3NlYXJjaF9mb3JtLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3VwZGF0ZSBhdHRyaWJ1dGVzIG9uIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5Rm9ybUF0dHJpYnV0ZXMoJG5ld19zZWFyY2hfZm9ybSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy5zZWFyY2hBbmRGaWx0ZXIoeydpc0luaXQnOiBmYWxzZX0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLmZpbmQoXCJpbnB1dFwiKS5yZW1vdmVBdHRyKFwiZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IGZhbHNlOyAvL2ZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgc2VsZi5jdXJyZW50X3BhZ2VkID0gMTsgLy9mb3IgaW5maW5pdGUgc2Nyb2xsXHJcbiAgICAgICAgICAgIHNlbGYuc2V0SW5maW5pdGVTY3JvbGxDb250YWluZXIoKTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZUNvbnRlbnRBcmVhcyA9IGZ1bmN0aW9uKCAkaHRtbF9kYXRhICkge1xyXG4gICAgICAgICAgICBcclxuICAgICAgICAgICAgLy8gYWRkIGFkZGl0aW9uYWwgY29udGVudCBhcmVhc1xyXG4gICAgICAgICAgICBpZiAoIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMgJiYgdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucy5sZW5ndGggKSB7XHJcbiAgICAgICAgICAgICAgICBmb3IgKGluZGV4ID0gMDsgaW5kZXggPCB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zLmxlbmd0aDsgKytpbmRleCkge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzZWxlY3RvciA9IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnNbaW5kZXhdO1xyXG4gICAgICAgICAgICAgICAgICAgICQoIHNlbGVjdG9yICkuaHRtbCggJGh0bWxfZGF0YS5maW5kKCBzZWxlY3RvciApLmh0bWwoKSApO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuZmFkZUNvbnRlbnRBcmVhcyA9IGZ1bmN0aW9uKCBkaXJlY3Rpb24gKSB7XHJcbiAgICAgICAgICAgIFxyXG4gICAgICAgICAgICB2YXIgb3BhY2l0eSA9IDAuNTtcclxuICAgICAgICAgICAgaWYgKCBkaXJlY3Rpb24gPT09IFwiaW5cIiApIHtcclxuICAgICAgICAgICAgICAgIG9wYWNpdHkgPSAxO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZiAoIHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMgJiYgdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucy5sZW5ndGggKSB7XHJcbiAgICAgICAgICAgICAgICBmb3IgKGluZGV4ID0gMDsgaW5kZXggPCB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zLmxlbmd0aDsgKytpbmRleCkge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzZWxlY3RvciA9IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnNbaW5kZXhdO1xyXG4gICAgICAgICAgICAgICAgICAgICQoIHNlbGVjdG9yICkuc3RvcCh0cnVlLHRydWUpLmFuaW1hdGUoIHsgb3BhY2l0eTogb3BhY2l0eX0sIFwiZmFzdFwiICk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICBcclxuICAgICAgICAgICAgXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnJlbW92ZVdvb0NvbW1lcmNlQ29udHJvbHMgPSBmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5ID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nIC5vcmRlcmJ5Jyk7XHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnlfZm9ybSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZycpO1xyXG5cclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5X2Zvcm0ub2ZmKCk7XHJcbiAgICAgICAgICAgICR3b29fb3JkZXJieS5vZmYoKTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmFkZFF1ZXJ5UGFyYW0gPSBmdW5jdGlvbihuYW1lLCB2YWx1ZSwgdXJsX3R5cGUpe1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHVybF90eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHVybF90eXBlID0gXCJhbGxcIjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1t1cmxfdHlwZV1bbmFtZV0gPSB2YWx1ZTtcclxuXHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5pbml0V29vQ29tbWVyY2VDb250cm9scyA9IGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICBzZWxmLnJlbW92ZVdvb0NvbW1lcmNlQ29udHJvbHMoKTtcclxuXHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnkgPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcgLm9yZGVyYnknKTtcclxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieV9mb3JtID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nJyk7XHJcblxyXG4gICAgICAgICAgICB2YXIgb3JkZXJfdmFsID0gXCJcIjtcclxuICAgICAgICAgICAgaWYoJHdvb19vcmRlcmJ5Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSAkd29vX29yZGVyYnkudmFsKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwib3JkZXJieVwiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKG9yZGVyX3ZhbD09XCJtZW51X29yZGVyXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKChvcmRlcl92YWwhPVwiXCIpJiYoISFvcmRlcl92YWwpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5hbGwub3JkZXJieSA9IG9yZGVyX3ZhbDtcclxuICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICR3b29fb3JkZXJieV9mb3JtLm9uKCdzdWJtaXQnLCBmdW5jdGlvbihlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICAvL3ZhciBmb3JtID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5Lm9uKFwiY2hhbmdlXCIsIGZ1bmN0aW9uKGUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gJCh0aGlzKS52YWwoKTtcclxuICAgICAgICAgICAgICAgIGlmKHZhbD09XCJtZW51X29yZGVyXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFsID0gXCJcIjtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5hbGwub3JkZXJieSA9IHZhbDtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy50cmlnZ2VyKFwic3VibWl0XCIpXHJcblxyXG4gICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnNjcm9sbFJlc3VsdHMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcbiAgICAgICAgICAgIGlmKChzZWxmLnNjcm9sbF9vbl9hY3Rpb249PXNlbGYuYWpheF9hY3Rpb24pfHwoc2VsZi5zY3JvbGxfb25fYWN0aW9uPT1cImFsbFwiKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zY3JvbGxUb1BvcygpOyAvL3Njcm9sbCB0aGUgd2luZG93IGlmIGl0IGhhcyBiZWVuIHNldFxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmFqYXhfYWN0aW9uID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy51cGRhdGVVcmxIaXN0b3J5ID0gZnVuY3Rpb24oYWpheF9yZXN1bHRzX3VybClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIHZhciB1c2VfaGlzdG9yeV9hcGkgPSAwO1xyXG4gICAgICAgICAgICBpZiAod2luZG93Lmhpc3RvcnkgJiYgd2luZG93Lmhpc3RvcnkucHVzaFN0YXRlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB1c2VfaGlzdG9yeV9hcGkgPSAkdGhpcy5hdHRyKFwiZGF0YS11c2UtaGlzdG9yeS1hcGlcIik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKChzZWxmLnVwZGF0ZV9hamF4X3VybD09MSkmJih1c2VfaGlzdG9yeV9hcGk9PTEpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAvL25vdyBjaGVjayBpZiB0aGUgYnJvd3NlciBzdXBwb3J0cyBoaXN0b3J5IHN0YXRlIHB1c2ggOilcclxuICAgICAgICAgICAgICAgIGlmICh3aW5kb3cuaGlzdG9yeSAmJiB3aW5kb3cuaGlzdG9yeS5wdXNoU3RhdGUpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaGlzdG9yeS5wdXNoU3RhdGUobnVsbCwgbnVsbCwgYWpheF9yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5yZW1vdmVBamF4UGFnaW5hdGlvbiA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpIT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGFqYXhfbGlua3Nfb2JqZWN0ID0galF1ZXJ5KHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJGFqYXhfbGlua3Nfb2JqZWN0Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICRhamF4X2xpbmtzX29iamVjdC5vZmYoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5nZXRCYXNlVXJsID0gZnVuY3Rpb24oIHVybCApIHtcclxuICAgICAgICAgICAgLy9ub3cgc2VlIGlmIHdlIGFyZSBvbiB0aGUgVVJMIHdlIHRoaW5rLi4uXHJcbiAgICAgICAgICAgIHZhciB1cmxfcGFydHMgPSB1cmwuc3BsaXQoXCI/XCIpO1xyXG4gICAgICAgICAgICB2YXIgdXJsX2Jhc2UgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgaWYodXJsX3BhcnRzLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9wYXJ0c1swXTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgICAgIHVybF9iYXNlID0gdXJsO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHJldHVybiB1cmxfYmFzZTtcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5jYW5GZXRjaEFqYXhSZXN1bHRzID0gZnVuY3Rpb24oZmV0Y2hfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihmZXRjaF90eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGZldGNoX3R5cGUgPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcbiAgICAgICAgICAgIHZhciBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIGFqYXggc3VibWl0IHRoZSBmb3JtXHJcblxyXG4gICAgICAgICAgICAgICAgLy9hbmQgaWYgd2UgY2FuIGZpbmQgdGhlIHJlc3VsdHMgY29udGFpbmVyXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmxlbmd0aD09MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHNlbGYucmVzdWx0c191cmw7ICAvL1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsX2VuY29kZWQgPSAnJzsgIC8vXHJcbiAgICAgICAgICAgICAgICB2YXIgY3VycmVudF91cmwgPSB3aW5kb3cubG9jYXRpb24uaHJlZjtcclxuXHJcbiAgICAgICAgICAgICAgICAvL2lnbm9yZSAjIGFuZCBldmVyeXRoaW5nIGFmdGVyXHJcbiAgICAgICAgICAgICAgICB2YXIgaGFzaF9wb3MgPSB3aW5kb3cubG9jYXRpb24uaHJlZi5pbmRleE9mKCcjJyk7XHJcbiAgICAgICAgICAgICAgICBpZihoYXNoX3BvcyE9PS0xKXtcclxuICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybCA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmLnN1YnN0cigwLCB3aW5kb3cubG9jYXRpb24uaHJlZi5pbmRleE9mKCcjJykpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKCAoICggc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwiY3VzdG9tX3dvb2NvbW1lcmNlX3N0b3JlXCIgKSB8fCAoIHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cInBvc3RfdHlwZV9hcmNoaXZlXCIgKSApICYmICggc2VsZi5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMgPT0gMSApIClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiggc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgIT09XCJcIiApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmV0Y2hfYWpheF9yZXN1bHRzO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLyp2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgICAgICAgdmFyIGFjdGl2ZV90YXggPSBwcm9jZXNzX2Zvcm0uZ2V0QWN0aXZlVGF4KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyh0cnVlLCAnJywgYWN0aXZlX3RheCk7Ki9cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAvL25vdyBzZWUgaWYgd2UgYXJlIG9uIHRoZSBVUkwgd2UgdGhpbmsuLi5cclxuICAgICAgICAgICAgICAgIHZhciB1cmxfYmFzZSA9IHRoaXMuZ2V0QmFzZVVybCggY3VycmVudF91cmwgKTtcclxuICAgICAgICAgICAgICAgIC8vdmFyIHJlc3VsdHNfdXJsX2Jhc2UgPSB0aGlzLmdldEJhc2VVcmwoIGN1cnJlbnRfdXJsICk7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIGxhbmcgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwibGFuZ1wiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcbiAgICAgICAgICAgICAgICBpZigodHlwZW9mKGxhbmcpIT09XCJ1bmRlZmluZWRcIikmJihsYW5nIT09bnVsbCkpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSBzZWxmLmFkZFVybFBhcmFtKHVybF9iYXNlLCBcImxhbmc9XCIrbGFuZyk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHNmaWQgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwic2ZpZFwiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9pZiBzZmlkIGlzIGEgbnVtYmVyXHJcbiAgICAgICAgICAgICAgICBpZihOdW1iZXIocGFyc2VGbG9hdChzZmlkKSkgPT0gc2ZpZClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHNlbGYuYWRkVXJsUGFyYW0odXJsX2Jhc2UsIFwic2ZpZD1cIitzZmlkKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAvL2lmIGFueSBvZiB0aGUgMyBjb25kaXRpb25zIGFyZSB0cnVlLCB0aGVuIGl0cyBnb29kIHRvIGdvXHJcbiAgICAgICAgICAgICAgICAvLyAtIDEgfCBpZiB0aGUgdXJsIGJhc2UgPT0gcmVzdWx0c191cmxcclxuICAgICAgICAgICAgICAgIC8vIC0gMiB8IGlmIHVybCBiYXNlKyBcIi9cIiAgPT0gcmVzdWx0c191cmwgLSBpbiBjYXNlIG9mIHVzZXIgZXJyb3IgaW4gdGhlIHJlc3VsdHMgVVJMXHJcbiAgICAgICAgICAgICAgICAvLyAtIDMgfCBpZiB0aGUgcmVzdWx0cyBVUkwgaGFzIHVybCBwYXJhbXMsIGFuZCB0aGUgY3VycmVudCB1cmwgc3RhcnRzIHdpdGggdGhlIHJlc3VsdHMgVVJMIFxyXG5cclxuICAgICAgICAgICAgICAgIC8vdHJpbSBhbnkgdHJhaWxpbmcgc2xhc2ggZm9yIGVhc2llciBjb21wYXJpc29uOlxyXG4gICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSB1cmxfYmFzZS5yZXBsYWNlKC9cXC8kLywgJycpO1xyXG4gICAgICAgICAgICAgICAgcmVzdWx0c191cmwgPSByZXN1bHRzX3VybC5yZXBsYWNlKC9cXC8kLywgJycpO1xyXG4gICAgICAgICAgICAgICAgcmVzdWx0c191cmxfZW5jb2RlZCA9IGVuY29kZVVSSShyZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICBcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPSAtMTtcclxuICAgICAgICAgICAgICAgIGlmKCh1cmxfYmFzZT09cmVzdWx0c191cmwpfHwodXJsX2Jhc2UudG9Mb3dlckNhc2UoKT09cmVzdWx0c191cmxfZW5jb2RlZC50b0xvd2VyQ2FzZSgpKSAgKXtcclxuICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IDE7XHJcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICggcmVzdWx0c191cmwuaW5kZXhPZiggJz8nICkgIT09IC0xICYmIGN1cnJlbnRfdXJsLmxhc3RJbmRleE9mKHJlc3VsdHNfdXJsLCAwKSA9PT0gMCApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPSAxO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLm9ubHlfcmVzdWx0c19hamF4PT0xKVxyXG4gICAgICAgICAgICAgICAgey8vaWYgYSB1c2VyIGhhcyBjaG9zZW4gdG8gb25seSBhbGxvdyBhamF4IG9uIHJlc3VsdHMgcGFnZXMgKGRlZmF1bHQgYmVoYXZpb3VyKVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiggY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPiAtMSlcclxuICAgICAgICAgICAgICAgICAgICB7Ly90aGlzIG1lYW5zIHRoZSBjdXJyZW50IFVSTCBjb250YWlucyB0aGUgcmVzdWx0cyB1cmwsIHdoaWNoIG1lYW5zIHdlIGNhbiBkbyBhamF4XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZihmZXRjaF90eXBlPT1cInBhZ2luYXRpb25cIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA+IC0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7Ly90aGlzIG1lYW5zIHRoZSBjdXJyZW50IFVSTCBjb250YWlucyB0aGUgcmVzdWx0cyB1cmwsIHdoaWNoIG1lYW5zIHdlIGNhbiBkbyBhamF4XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy9kb24ndCBhamF4IHBhZ2luYXRpb24gd2hlbiBub3Qgb24gYSBTJkYgcGFnZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBmZXRjaF9hamF4X3Jlc3VsdHM7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnNldHVwQWpheFBhZ2luYXRpb24gPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvL2luZmluaXRlIHNjcm9sbFxyXG4gICAgICAgICAgICBpZih0aGlzLnBhZ2luYXRpb25fdHlwZT09PVwiaW5maW5pdGVfc2Nyb2xsXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBpbmZpbml0ZV9zY3JvbGxfZW5kID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCJbZGF0YS1zZWFyY2gtZmlsdGVyLWFjdGlvbj0naW5maW5pdGUtc2Nyb2xsLWVuZCddXCIpLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGluZmluaXRlX3Njcm9sbF9lbmQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZihwYXJzZUludCh0aGlzLmluc3RhbmNlX251bWJlcik9PT0xKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgJCh3aW5kb3cpLm9mZihcInNjcm9sbFwiLCBzZWxmLm9uV2luZG93U2Nyb2xsKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHNlbGYuY2FuRmV0Y2hBamF4UmVzdWx0cyhcInBhZ2luYXRpb25cIikpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJCh3aW5kb3cpLm9uKFwic2Nyb2xsXCIsIHNlbGYub25XaW5kb3dTY3JvbGwpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHR5cGVvZihzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpPT1cInVuZGVmaW5lZFwiKSB7XHJcbiAgICAgICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vZmYoJ2NsaWNrJywgc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcclxuICAgICAgICAgICAgICAgICQoZG9jdW1lbnQpLm9mZihzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpO1xyXG4gICAgICAgICAgICAgICAgJChzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpLm9mZigpO1xyXG5cclxuICAgICAgICAgICAgICAgICQoZG9jdW1lbnQpLm9uKCdjbGljaycsIHNlbGYuYWpheF9saW5rc19zZWxlY3RvciwgZnVuY3Rpb24oZSl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuY2FuRmV0Y2hBamF4UmVzdWx0cyhcInBhZ2luYXRpb25cIikpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgbGluayA9IGpRdWVyeSh0aGlzKS5hdHRyKCdocmVmJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuYWpheF9hY3Rpb24gPSBcInBhZ2luYXRpb25cIjtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBwYWdlTnVtYmVyID0gc2VsZi5nZXRQYWdlZEZyb21VUkwobGluayk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIsIHBhZ2VOdW1iZXIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5mZXRjaEFqYXhSZXN1bHRzKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmdldFBhZ2VkRnJvbVVSTCA9IGZ1bmN0aW9uKFVSTCl7XHJcblxyXG4gICAgICAgICAgICB2YXIgcGFnZWRWYWwgPSAxO1xyXG4gICAgICAgICAgICAvL2ZpcnN0IHRlc3QgdG8gc2VlIGlmIHdlIGhhdmUgXCIvcGFnZS80L1wiIGluIHRoZSBVUkxcclxuICAgICAgICAgICAgdmFyIHRwVmFsID0gc2VsZi5nZXRRdWVyeVBhcmFtRnJvbVVSTChcInNmX3BhZ2VkXCIsIFVSTCk7XHJcbiAgICAgICAgICAgIGlmKCh0eXBlb2YodHBWYWwpPT1cInN0cmluZ1wiKXx8KHR5cGVvZih0cFZhbCk9PVwibnVtYmVyXCIpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBwYWdlZFZhbCA9IHRwVmFsO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gcGFnZWRWYWw7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5nZXRRdWVyeVBhcmFtRnJvbVVSTCA9IGZ1bmN0aW9uKG5hbWUsIFVSTCl7XHJcblxyXG4gICAgICAgICAgICB2YXIgcXN0cmluZyA9IFwiP1wiK1VSTC5zcGxpdCgnPycpWzFdO1xyXG4gICAgICAgICAgICBpZih0eXBlb2YocXN0cmluZykhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBkZWNvZGVVUklDb21wb25lbnQoKG5ldyBSZWdFeHAoJ1s/fCZdJyArIG5hbWUgKyAnPScgKyAnKFteJjtdKz8pKCZ8I3w7fCQpJykuZXhlYyhxc3RyaW5nKXx8WyxcIlwiXSlbMV0ucmVwbGFjZSgvXFwrL2csICclMjAnKSl8fG51bGw7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gdmFsO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHJldHVybiBcIlwiO1xyXG4gICAgICAgIH07XHJcblxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5mb3JtVXBkYXRlZCA9IGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgLy9lLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgIGlmKHNlbGYuYXV0b191cGRhdGU9PTEpIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoKHNlbGYuYXV0b191cGRhdGU9PTApJiYoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuZm9ybVVwZGF0ZWRGZXRjaEFqYXgoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZm9ybVVwZGF0ZWRGZXRjaEFqYXggPSBmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgLy9sb29wIHRocm91Z2ggYWxsIHRoZSBmaWVsZHMgYW5kIGJ1aWxkIHRoZSBVUkxcclxuICAgICAgICAgICAgc2VsZi5mZXRjaEFqYXhGb3JtKCk7XHJcblxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIC8vbWFrZSBhbnkgY29ycmVjdGlvbnMvdXBkYXRlcyB0byBmaWVsZHMgYmVmb3JlIHRoZSBzdWJtaXQgY29tcGxldGVzXHJcbiAgICAgICAgdGhpcy5zZXRGaWVsZHMgPSBmdW5jdGlvbihlKXtcclxuXHJcbiAgICAgICAgICAgIC8vaWYoc2VsZi5pc19hamF4PT0wKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zb21ldGltZXMgdGhlIGZvcm0gaXMgc3VibWl0dGVkIHdpdGhvdXQgdGhlIHNsaWRlciB5ZXQgaGF2aW5nIHVwZGF0ZWQsIGFuZCBhcyB3ZSBnZXQgb3VyIHZhbHVlcyBmcm9tXHJcbiAgICAgICAgICAgICAgICAvL3RoZSBzbGlkZXIgYW5kIG5vdCBpbnB1dHMsIHdlIG5lZWQgdG8gY2hlY2sgaXQgaWYgbmVlZHMgdG8gYmUgc2V0XHJcbiAgICAgICAgICAgICAgICAvL29ubHkgb2NjdXJzIGlmIGFqYXggaXMgb2ZmLCBhbmQgYXV0b3N1Ym1pdCBvblxyXG4gICAgICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkZmllbGQgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgcmFuZ2VfZGlzcGxheV92YWx1ZXMgPSAkZmllbGQuZmluZCgnLnNmLW1ldGEtcmFuZ2Utc2xpZGVyJykuYXR0cihcImRhdGEtZGlzcGxheS12YWx1ZXMtYXNcIik7Ly9kYXRhLWRpc3BsYXktdmFsdWVzLWFzPVwidGV4dFwiXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHJhbmdlX2Rpc3BsYXlfdmFsdWVzPT09XCJ0ZXh0aW5wdXRcIikge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGZpZWxkLmZpbmQoXCIubWV0YS1zbGlkZXJcIikubGVuZ3RoPjApe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIi5tZXRhLXNsaWRlclwiKS5lYWNoKGZ1bmN0aW9uIChpbmRleCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfb2JqZWN0ID0gJCh0aGlzKVswXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkc2xpZGVyX2VsID0gJCh0aGlzKS5jbG9zZXN0KFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy92YXIgbWluVmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL3ZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBtaW5WYWwgPSAkc2xpZGVyX2VsLmZpbmQoXCIuc2YtcmFuZ2UtbWluXCIpLnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG1heFZhbCA9ICRzbGlkZXJfZWwuZmluZChcIi5zZi1yYW5nZS1tYXhcIikudmFsKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFttaW5WYWwsIG1heFZhbF0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIC8vfVxyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIC8vc3VibWl0XHJcbiAgICAgICAgdGhpcy5zdWJtaXRGb3JtID0gZnVuY3Rpb24oZSl7XHJcblxyXG4gICAgICAgICAgICAvL2xvb3AgdGhyb3VnaCBhbGwgdGhlIGZpZWxkcyBhbmQgYnVpbGQgdGhlIFVSTFxyXG4gICAgICAgICAgICBpZihzZWxmLmlzU3VibWl0dGluZyA9PSB0cnVlKSB7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYuc2V0RmllbGRzKCk7XHJcbiAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSB0cnVlO1xyXG5cclxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiLCAxKTsgLy9pbml0IHBhZ2VkXHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoKSlcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIGFqYXggc3VibWl0IHRoZSBmb3JtXHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X2FjdGlvbiA9IFwic3VibWl0XCI7IC8vc28gd2Uga25vdyBpdCB3YXNuJ3QgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgc2VsZi5mZXRjaEFqYXhSZXN1bHRzKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgc2ltcGx5IHJlZGlyZWN0IHRvIHRoZSBSZXN1bHRzIFVSTFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHByb2Nlc3NfZm9ybS5nZXRSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUsICcnKTtcclxuICAgICAgICAgICAgICAgIHJlc3VsdHNfdXJsID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9IHJlc3VsdHNfdXJsO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLnJlc2V0Rm9ybSA9IGZ1bmN0aW9uKHN1Ym1pdF9mb3JtKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgLy91bnNldCBhbGwgZmllbGRzXHJcbiAgICAgICAgICAgIHNlbGYuJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICRmaWVsZCA9ICQodGhpcyk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0JGZpZWxkLnJlbW92ZUF0dHIoXCJkYXRhLXNmLXRheG9ub215LWFyY2hpdmVcIik7XHJcblx0XHRcdFx0XHJcbiAgICAgICAgICAgICAgICAvL3N0YW5kYXJkIGZpZWxkIHR5cGVzXHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcInNlbGVjdDpub3QoW211bHRpcGxlPSdtdWx0aXBsZSddKSA+IG9wdGlvbjpmaXJzdC1jaGlsZFwiKS5wcm9wKFwic2VsZWN0ZWRcIiwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcInNlbGVjdFttdWx0aXBsZT0nbXVsdGlwbGUnXSA+IG9wdGlvblwiKS5wcm9wKFwic2VsZWN0ZWRcIiwgZmFsc2UpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJpbnB1dFt0eXBlPSdjaGVja2JveCddXCIpLnByb3AoXCJjaGVja2VkXCIsIGZhbHNlKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiPiB1bCA+IGxpOmZpcnN0LWNoaWxkIGlucHV0W3R5cGU9J3JhZGlvJ11cIikucHJvcChcImNoZWNrZWRcIiwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcImlucHV0W3R5cGU9J3RleHQnXVwiKS52YWwoXCJcIik7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIi5zZi1vcHRpb24tYWN0aXZlXCIpLnJlbW92ZUNsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiPiB1bCA+IGxpOmZpcnN0LWNoaWxkIGlucHV0W3R5cGU9J3JhZGlvJ11cIikucGFyZW50KCkuYWRkQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpOyAvL3JlIGFkZCBhY3RpdmUgY2xhc3MgdG8gZmlyc3QgXCJkZWZhdWx0XCIgb3B0aW9uXHJcblxyXG4gICAgICAgICAgICAgICAgLy9udW1iZXIgcmFuZ2UgLSAyIG51bWJlciBpbnB1dCBmaWVsZHNcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiaW5wdXRbdHlwZT0nbnVtYmVyJ11cIikuZWFjaChmdW5jdGlvbihpbmRleCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkdGhpc0lucHV0ID0gJCh0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoJHRoaXNJbnB1dC5wYXJlbnQoKS5wYXJlbnQoKS5oYXNDbGFzcyhcInNmLW1ldGEtcmFuZ2VcIikpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGluZGV4PT0wKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbCgkdGhpc0lucHV0LmF0dHIoXCJtaW5cIikpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoaW5kZXg9PTEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKCR0aGlzSW5wdXQuYXR0cihcIm1heFwiKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9tZXRhIC8gbnVtYmVycyB3aXRoIDIgaW5wdXRzIChmcm9tIC8gdG8gZmllbGRzKSAtIHNlY29uZCBpbnB1dCBtdXN0IGJlIHJlc2V0IHRvIG1heCB2YWx1ZVxyXG4gICAgICAgICAgICAgICAgdmFyICRtZXRhX3NlbGVjdF9mcm9tX3RvID0gJGZpZWxkLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1zZWxlY3QtZnJvbXRvXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCRtZXRhX3NlbGVjdF9mcm9tX3RvLmxlbmd0aD4wKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9taW4gPSAkbWV0YV9zZWxlY3RfZnJvbV90by5hdHRyKFwiZGF0YS1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21heCA9ICRtZXRhX3NlbGVjdF9mcm9tX3RvLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJG1ldGFfc2VsZWN0X2Zyb21fdG8uZmluZChcInNlbGVjdFwiKS5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkdGhpc0lucHV0ID0gJCh0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGluZGV4PT0wKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoc3RhcnRfbWluKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbChzdGFydF9tYXgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkbWV0YV9yYWRpb19mcm9tX3RvID0gJGZpZWxkLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1yYWRpby1mcm9tdG9cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJG1ldGFfcmFkaW9fZnJvbV90by5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWluID0gJG1ldGFfcmFkaW9fZnJvbV90by5hdHRyKFwiZGF0YS1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21heCA9ICRtZXRhX3JhZGlvX2Zyb21fdG8uYXR0cihcImRhdGEtbWF4XCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHJhZGlvX2dyb3VwcyA9ICRtZXRhX3JhZGlvX2Zyb21fdG8uZmluZCgnLnNmLWlucHV0LXJhbmdlLXJhZGlvJyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRyYWRpb19ncm91cHMuZWFjaChmdW5jdGlvbihpbmRleCl7XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRyYWRpb3MgPSAkKHRoaXMpLmZpbmQoXCIuc2YtaW5wdXQtcmFkaW9cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRyYWRpb3MucHJvcChcImNoZWNrZWRcIiwgZmFsc2UpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoaW5kZXg9PTApXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRyYWRpb3MuZmlsdGVyKCdbdmFsdWU9XCInK3N0YXJ0X21pbisnXCJdJykucHJvcChcImNoZWNrZWRcIiwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihpbmRleD09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHJhZGlvcy5maWx0ZXIoJ1t2YWx1ZT1cIicrc3RhcnRfbWF4KydcIl0nKS5wcm9wKFwiY2hlY2tlZFwiLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgLy9udW1iZXIgc2xpZGVyIC0gbm9VaVNsaWRlclxyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCIubWV0YS1zbGlkZXJcIikuZWFjaChmdW5jdGlvbihpbmRleCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfb2JqZWN0ID0gJCh0aGlzKVswXTtcclxuICAgICAgICAgICAgICAgICAgICAvKnZhciBzbGlkZXJfb2JqZWN0ID0gJGNvbnRhaW5lci5maW5kKFwiLm1ldGEtc2xpZGVyXCIpWzBdO1xyXG4gICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX3ZhbCA9IHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5nZXQoKTsqL1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHNsaWRlcl9lbCA9ICQodGhpcykuY2xvc2VzdChcIi5zZi1tZXRhLXJhbmdlLXNsaWRlclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWluVmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1heFZhbCA9ICRzbGlkZXJfZWwuYXR0cihcImRhdGEtbWF4XCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoW21pblZhbCwgbWF4VmFsXSk7XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9uZWVkIHRvIHNlZSBpZiBhbnkgYXJlIGNvbWJvYm94IGFuZCBhY3QgYWNjb3JkaW5nbHlcclxuICAgICAgICAgICAgICAgIHZhciAkY29tYm9ib3ggPSAkZmllbGQuZmluZChcInNlbGVjdFtkYXRhLWNvbWJvYm94PScxJ11cIik7XHJcbiAgICAgICAgICAgICAgICBpZigkY29tYm9ib3gubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHR5cGVvZiAkY29tYm9ib3guY2hvc2VuICE9IFwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkY29tYm9ib3gudHJpZ2dlcihcImNob3Nlbjp1cGRhdGVkXCIpOyAvL2ZvciBjaG9zZW4gb25seVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkY29tYm9ib3gudmFsKCcnKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnRyaWdnZXIoJ2NoYW5nZS5zZWxlY3QyJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICBzZWxmLmNsZWFyVGltZXIoKTtcclxuXHJcblxyXG5cclxuICAgICAgICAgICAgaWYoc3VibWl0X2Zvcm09PVwiYWx3YXlzXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc3VibWl0X2Zvcm09PVwibmV2ZXJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgaWYodGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmZvcm1VcGRhdGVkRmV0Y2hBamF4KCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzdWJtaXRfZm9ybT09XCJhdXRvXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b191cGRhdGU9PXRydWUpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5zdWJtaXRGb3JtKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYodGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuZm9ybVVwZGF0ZWRGZXRjaEFqYXgoKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5pbml0KCk7XHJcblxyXG4gICAgICAgIHZhciBldmVudF9kYXRhID0ge307XHJcbiAgICAgICAgZXZlbnRfZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgIGV2ZW50X2RhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgZXZlbnRfZGF0YS5vYmplY3QgPSB0aGlzO1xyXG4gICAgICAgIGlmKG9wdHMuaXNJbml0KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjppbml0XCIsIGV2ZW50X2RhdGEpO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICB9KTtcclxufTtcclxuIl19
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
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9hcHAuanMiLCJub2RlX21vZHVsZXMvbm91aXNsaWRlci9kaXN0cmlidXRlL25vdWlzbGlkZXIuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9wbHVnaW4uanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9wcm9jZXNzX2Zvcm0uanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9zdGF0ZS5qcyIsInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3RoaXJkcGFydHkuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUMzUUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDMXlFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUNudEVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQzU4QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDbEJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gZSh0LG4scil7ZnVuY3Rpb24gcyhvLHUpe2lmKCFuW29dKXtpZighdFtvXSl7dmFyIGE9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtpZighdSYmYSlyZXR1cm4gYShvLCEwKTtpZihpKXJldHVybiBpKG8sITApO3ZhciBmPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIrbytcIidcIik7dGhyb3cgZi5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGZ9dmFyIGw9bltvXT17ZXhwb3J0czp7fX07dFtvXVswXS5jYWxsKGwuZXhwb3J0cyxmdW5jdGlvbihlKXt2YXIgbj10W29dWzFdW2VdO3JldHVybiBzKG4/bjplKX0sbCxsLmV4cG9ydHMsZSx0LG4scil9cmV0dXJuIG5bb10uZXhwb3J0c312YXIgaT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2Zvcih2YXIgbz0wO288ci5sZW5ndGg7bysrKXMocltvXSk7cmV0dXJuIHN9KSIsIihmdW5jdGlvbiAoZ2xvYmFsKXtcblxyXG52YXIgc3RhdGUgPSByZXF1aXJlKCcuL2luY2x1ZGVzL3N0YXRlJyk7XHJcbnZhciBwbHVnaW4gPSByZXF1aXJlKCcuL2luY2x1ZGVzL3BsdWdpbicpO1xyXG5cclxuXHJcbihmdW5jdGlvbiAoICQgKSB7XHJcblxyXG5cdFwidXNlIHN0cmljdFwiO1xyXG5cclxuXHQkKGZ1bmN0aW9uICgpIHtcclxuXHJcblx0XHRTdHJpbmcucHJvdG90eXBlLnJlcGxhY2VBbGwgPSBmdW5jdGlvbihzdHIxLCBzdHIyLCBpZ25vcmUpXHJcblx0XHR7XHJcblx0XHRcdHJldHVybiB0aGlzLnJlcGxhY2UobmV3IFJlZ0V4cChzdHIxLnJlcGxhY2UoLyhbXFwvXFwsXFwhXFxcXFxcXlxcJFxce1xcfVxcW1xcXVxcKFxcKVxcLlxcKlxcK1xcP1xcfFxcPFxcPlxcLVxcJl0pL2csXCJcXFxcJCZcIiksKGlnbm9yZT9cImdpXCI6XCJnXCIpKSwodHlwZW9mKHN0cjIpPT1cInN0cmluZ1wiKT9zdHIyLnJlcGxhY2UoL1xcJC9nLFwiJCQkJFwiKTpzdHIyKTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIU9iamVjdC5rZXlzKSB7XHJcblx0XHQgIE9iamVjdC5rZXlzID0gKGZ1bmN0aW9uICgpIHtcclxuXHRcdFx0J3VzZSBzdHJpY3QnO1xyXG5cdFx0XHR2YXIgaGFzT3duUHJvcGVydHkgPSBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LFxyXG5cdFx0XHRcdGhhc0RvbnRFbnVtQnVnID0gISh7dG9TdHJpbmc6IG51bGx9KS5wcm9wZXJ0eUlzRW51bWVyYWJsZSgndG9TdHJpbmcnKSxcclxuXHRcdFx0XHRkb250RW51bXMgPSBbXHJcblx0XHRcdFx0ICAndG9TdHJpbmcnLFxyXG5cdFx0XHRcdCAgJ3RvTG9jYWxlU3RyaW5nJyxcclxuXHRcdFx0XHQgICd2YWx1ZU9mJyxcclxuXHRcdFx0XHQgICdoYXNPd25Qcm9wZXJ0eScsXHJcblx0XHRcdFx0ICAnaXNQcm90b3R5cGVPZicsXHJcblx0XHRcdFx0ICAncHJvcGVydHlJc0VudW1lcmFibGUnLFxyXG5cdFx0XHRcdCAgJ2NvbnN0cnVjdG9yJ1xyXG5cdFx0XHRcdF0sXHJcblx0XHRcdFx0ZG9udEVudW1zTGVuZ3RoID0gZG9udEVudW1zLmxlbmd0aDtcclxuXHJcblx0XHRcdHJldHVybiBmdW5jdGlvbiAob2JqKSB7XHJcblx0XHRcdCAgaWYgKHR5cGVvZiBvYmogIT09ICdvYmplY3QnICYmICh0eXBlb2Ygb2JqICE9PSAnZnVuY3Rpb24nIHx8IG9iaiA9PT0gbnVsbCkpIHtcclxuXHRcdFx0XHR0aHJvdyBuZXcgVHlwZUVycm9yKCdPYmplY3Qua2V5cyBjYWxsZWQgb24gbm9uLW9iamVjdCcpO1xyXG5cdFx0XHQgIH1cclxuXHJcblx0XHRcdCAgdmFyIHJlc3VsdCA9IFtdLCBwcm9wLCBpO1xyXG5cclxuXHRcdFx0ICBmb3IgKHByb3AgaW4gb2JqKSB7XHJcblx0XHRcdFx0aWYgKGhhc093blByb3BlcnR5LmNhbGwob2JqLCBwcm9wKSkge1xyXG5cdFx0XHRcdCAgcmVzdWx0LnB1c2gocHJvcCk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHQgIH1cclxuXHJcblx0XHRcdCAgaWYgKGhhc0RvbnRFbnVtQnVnKSB7XHJcblx0XHRcdFx0Zm9yIChpID0gMDsgaSA8IGRvbnRFbnVtc0xlbmd0aDsgaSsrKSB7XHJcblx0XHRcdFx0ICBpZiAoaGFzT3duUHJvcGVydHkuY2FsbChvYmosIGRvbnRFbnVtc1tpXSkpIHtcclxuXHRcdFx0XHRcdHJlc3VsdC5wdXNoKGRvbnRFbnVtc1tpXSk7XHJcblx0XHRcdFx0ICB9XHJcblx0XHRcdFx0fVxyXG5cdFx0XHQgIH1cclxuXHRcdFx0ICByZXR1cm4gcmVzdWx0O1xyXG5cdFx0XHR9O1xyXG5cdFx0ICB9KCkpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8qIFNlYXJjaCAmIEZpbHRlciBqUXVlcnkgUGx1Z2luICovXHJcblx0XHQkLmZuLnNlYXJjaEFuZEZpbHRlciA9IHBsdWdpbjtcclxuXHJcblx0XHQvKiBpbml0ICovXHJcblx0XHQkKFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuXHJcblx0XHQvKiBleHRlcm5hbCBjb250cm9scyAqL1xyXG5cdFx0JChkb2N1bWVudCkub24oXCJjbGlja1wiLCBcIi5zZWFyY2gtZmlsdGVyLXJlc2V0XCIsIGZ1bmN0aW9uKGUpe1xyXG5cclxuXHRcdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG5cclxuXHRcdFx0dmFyIHNlYXJjaEZvcm1JRCA9IHR5cGVvZigkKHRoaXMpLmF0dHIoXCJkYXRhLXNlYXJjaC1mb3JtLWlkXCIpKSE9XCJ1bmRlZmluZWRcIiA/ICQodGhpcykuYXR0cihcImRhdGEtc2VhcmNoLWZvcm0taWRcIikgOiBcIlwiO1xyXG5cdFx0XHR2YXIgc3VibWl0Rm9ybSA9IHR5cGVvZigkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLXN1Ym1pdC1mb3JtXCIpKSE9XCJ1bmRlZmluZWRcIiA/ICQodGhpcykuYXR0cihcImRhdGEtc2Ytc3VibWl0LWZvcm1cIikgOiBcIlwiO1xyXG5cclxuXHRcdFx0c3RhdGUuZ2V0U2VhcmNoRm9ybShzZWFyY2hGb3JtSUQpLnJlc2V0KHN1Ym1pdEZvcm0pO1xyXG5cclxuXHRcdFx0Ly92YXIgJGxpbmtlZCA9ICQoXCIjc2VhcmNoLWZpbHRlci1mb3JtLVwiK3NlYXJjaEZvcm1JRCkuc2VhcmNoRmlsdGVyRm9ybSh7YWN0aW9uOiBcInJlc2V0XCJ9KTtcclxuXHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHJcblx0XHR9KTtcclxuXHJcblx0fSk7XHJcblxyXG5cclxuLypcclxuICogalF1ZXJ5IEVhc2luZyB2MS40LjEgLSBodHRwOi8vZ3NnZC5jby51ay9zYW5kYm94L2pxdWVyeS9lYXNpbmcvXHJcbiAqIE9wZW4gc291cmNlIHVuZGVyIHRoZSBCU0QgTGljZW5zZS5cclxuICogQ29weXJpZ2h0IMKpIDIwMDggR2VvcmdlIE1jR2lubGV5IFNtaXRoXHJcbiAqIEFsbCByaWdodHMgcmVzZXJ2ZWQuXHJcbiAqIGh0dHBzOi8vcmF3LmdpdGh1Yi5jb20vZ2RzbWl0aC9qcXVlcnkuZWFzaW5nL21hc3Rlci9MSUNFTlNFXHJcbiovXHJcblxyXG4vKiBnbG9iYWxzIGpRdWVyeSwgZGVmaW5lLCBtb2R1bGUsIHJlcXVpcmUgKi9cclxuKGZ1bmN0aW9uIChmYWN0b3J5KSB7XHJcblx0aWYgKHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kKSB7XHJcblx0XHRkZWZpbmUoWydqcXVlcnknXSwgZnVuY3Rpb24gKCQpIHtcclxuXHRcdFx0cmV0dXJuIGZhY3RvcnkoJCk7XHJcblx0XHR9KTtcclxuXHR9IGVsc2UgaWYgKHR5cGVvZiBtb2R1bGUgPT09IFwib2JqZWN0XCIgJiYgdHlwZW9mIG1vZHVsZS5leHBvcnRzID09PSBcIm9iamVjdFwiKSB7XHJcblx0XHRtb2R1bGUuZXhwb3J0cyA9IGZhY3RvcnkoKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKSk7XHJcblx0fSBlbHNlIHtcclxuXHRcdGZhY3RvcnkoalF1ZXJ5KTtcclxuXHR9XHJcbn0pKGZ1bmN0aW9uKCQpe1xyXG5cclxuXHQvLyBQcmVzZXJ2ZSB0aGUgb3JpZ2luYWwgalF1ZXJ5IFwic3dpbmdcIiBlYXNpbmcgYXMgXCJqc3dpbmdcIlxyXG5cdGlmICh0eXBlb2YgJC5lYXNpbmcgIT09ICd1bmRlZmluZWQnKSB7XHJcblx0XHQkLmVhc2luZ1snanN3aW5nJ10gPSAkLmVhc2luZ1snc3dpbmcnXTtcclxuXHR9XHJcblxyXG5cdHZhciBwb3cgPSBNYXRoLnBvdyxcclxuXHRcdHNxcnQgPSBNYXRoLnNxcnQsXHJcblx0XHRzaW4gPSBNYXRoLnNpbixcclxuXHRcdGNvcyA9IE1hdGguY29zLFxyXG5cdFx0UEkgPSBNYXRoLlBJLFxyXG5cdFx0YzEgPSAxLjcwMTU4LFxyXG5cdFx0YzIgPSBjMSAqIDEuNTI1LFxyXG5cdFx0YzMgPSBjMSArIDEsXHJcblx0XHRjNCA9ICggMiAqIFBJICkgLyAzLFxyXG5cdFx0YzUgPSAoIDIgKiBQSSApIC8gNC41O1xyXG5cclxuXHQvLyB4IGlzIHRoZSBmcmFjdGlvbiBvZiBhbmltYXRpb24gcHJvZ3Jlc3MsIGluIHRoZSByYW5nZSAwLi4xXHJcblx0ZnVuY3Rpb24gYm91bmNlT3V0KHgpIHtcclxuXHRcdHZhciBuMSA9IDcuNTYyNSxcclxuXHRcdFx0ZDEgPSAyLjc1O1xyXG5cdFx0aWYgKCB4IDwgMS9kMSApIHtcclxuXHRcdFx0cmV0dXJuIG4xKngqeDtcclxuXHRcdH0gZWxzZSBpZiAoIHggPCAyL2QxICkge1xyXG5cdFx0XHRyZXR1cm4gbjEqKHgtPSgxLjUvZDEpKSp4ICsgLjc1O1xyXG5cdFx0fSBlbHNlIGlmICggeCA8IDIuNS9kMSApIHtcclxuXHRcdFx0cmV0dXJuIG4xKih4LT0oMi4yNS9kMSkpKnggKyAuOTM3NTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdHJldHVybiBuMSooeC09KDIuNjI1L2QxKSkqeCArIC45ODQzNzU7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQkLmV4dGVuZCggJC5lYXNpbmcsIHtcclxuXHRcdGRlZjogJ2Vhc2VPdXRRdWFkJyxcclxuXHRcdHN3aW5nOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gJC5lYXNpbmdbJC5lYXNpbmcuZGVmXSh4KTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5RdWFkOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dFF1YWQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxIC0gKCAxIC0geCApICogKCAxIC0geCApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dFF1YWQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQyICogeCAqIHggOlxyXG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDIgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluQ3ViaWM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ICogeCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEN1YmljOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gMSAtIHBvdyggMSAtIHgsIDMgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRDdWJpYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPCAwLjUgP1xyXG5cdFx0XHRcdDQgKiB4ICogeCAqIHggOlxyXG5cdFx0XHRcdDEgLSBwb3coIC0yICogeCArIDIsIDMgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluUXVhcnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ICogeCAqIHggKiB4O1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRRdWFydDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCA0ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0UXVhcnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQ4ICogeCAqIHggKiB4ICogeCA6XHJcblx0XHRcdFx0MSAtIHBvdyggLTIgKiB4ICsgMiwgNCApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5RdWludDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggKiB4ICogeCAqIHggKiB4O1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRRdWludDogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBwb3coIDEgLSB4LCA1ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluT3V0UXVpbnQ6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4IDwgMC41ID9cclxuXHRcdFx0XHQxNiAqIHggKiB4ICogeCAqIHggKiB4IDpcclxuXHRcdFx0XHQxIC0gcG93KCAtMiAqIHggKyAyLCA1ICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJblNpbmU6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxIC0gY29zKCB4ICogUEkvMiApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VPdXRTaW5lOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4gc2luKCB4ICogUEkvMiApO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dFNpbmU6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAtKCBjb3MoIFBJICogeCApIC0gMSApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5FeHBvOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiBwb3coIDIsIDEwICogeCAtIDEwICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEV4cG86IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAxID8gMSA6IDEgLSBwb3coIDIsIC0xMCAqIHggKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRFeHBvOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6IHggPCAwLjUgP1xyXG5cdFx0XHRcdHBvdyggMiwgMjAgKiB4IC0gMTAgKSAvIDIgOlxyXG5cdFx0XHRcdCggMiAtIHBvdyggMiwgLTIwICogeCArIDEwICkgKSAvIDI7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZUluQ2lyYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBzcXJ0KCAxIC0gcG93KCB4LCAyICkgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0Q2lyYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHNxcnQoIDEgLSBwb3coIHggLSAxLCAyICkgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRDaXJjOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCAxIC0gc3FydCggMSAtIHBvdyggMiAqIHgsIDIgKSApICkgLyAyIDpcclxuXHRcdFx0XHQoIHNxcnQoIDEgLSBwb3coIC0yICogeCArIDIsIDIgKSApICsgMSApIC8gMjtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5FbGFzdGljOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA9PT0gMCA/IDAgOiB4ID09PSAxID8gMSA6XHJcblx0XHRcdFx0LXBvdyggMiwgMTAgKiB4IC0gMTAgKSAqIHNpbiggKCB4ICogMTAgLSAxMC43NSApICogYzQgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlT3V0RWxhc3RpYzogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIHggPT09IDAgPyAwIDogeCA9PT0gMSA/IDEgOlxyXG5cdFx0XHRcdHBvdyggMiwgLTEwICogeCApICogc2luKCAoIHggKiAxMCAtIDAuNzUgKSAqIGM0ICkgKyAxO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbk91dEVsYXN0aWM6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiB4ID09PSAwID8gMCA6IHggPT09IDEgPyAxIDogeCA8IDAuNSA/XHJcblx0XHRcdFx0LSggcG93KCAyLCAyMCAqIHggLSAxMCApICogc2luKCAoIDIwICogeCAtIDExLjEyNSApICogYzUgKSkgLyAyIDpcclxuXHRcdFx0XHRwb3coIDIsIC0yMCAqIHggKyAxMCApICogc2luKCAoIDIwICogeCAtIDExLjEyNSApICogYzUgKSAvIDIgKyAxO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbkJhY2s6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiBjMyAqIHggKiB4ICogeCAtIGMxICogeCAqIHg7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEJhY2s6IGZ1bmN0aW9uICh4KSB7XHJcblx0XHRcdHJldHVybiAxICsgYzMgKiBwb3coIHggLSAxLCAzICkgKyBjMSAqIHBvdyggeCAtIDEsIDIgKTtcclxuXHRcdH0sXHJcblx0XHRlYXNlSW5PdXRCYWNrOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCBwb3coIDIgKiB4LCAyICkgKiAoICggYzIgKyAxICkgKiAyICogeCAtIGMyICkgKSAvIDIgOlxyXG5cdFx0XHRcdCggcG93KCAyICogeCAtIDIsIDIgKSAqKCAoIGMyICsgMSApICogKCB4ICogMiAtIDIgKSArIGMyICkgKyAyICkgLyAyO1xyXG5cdFx0fSxcclxuXHRcdGVhc2VJbkJvdW5jZTogZnVuY3Rpb24gKHgpIHtcclxuXHRcdFx0cmV0dXJuIDEgLSBib3VuY2VPdXQoIDEgLSB4ICk7XHJcblx0XHR9LFxyXG5cdFx0ZWFzZU91dEJvdW5jZTogYm91bmNlT3V0LFxyXG5cdFx0ZWFzZUluT3V0Qm91bmNlOiBmdW5jdGlvbiAoeCkge1xyXG5cdFx0XHRyZXR1cm4geCA8IDAuNSA/XHJcblx0XHRcdFx0KCAxIC0gYm91bmNlT3V0KCAxIC0gMiAqIHggKSApIC8gMiA6XHJcblx0XHRcdFx0KCAxICsgYm91bmNlT3V0KCAyICogeCAtIDEgKSApIC8gMjtcclxuXHRcdH1cclxuXHR9KTtcclxuXHRyZXR1cm4gJDtcclxufSk7XHJcblxyXG59KGpRdWVyeSkpO1xyXG5cclxuLy9zYWZhcmkgYmFjayBidXR0b24gZml4XHJcbmpRdWVyeSggd2luZG93ICkub24oIFwicGFnZXNob3dcIiwgZnVuY3Rpb24oZXZlbnQpIHtcclxuICAgIGlmIChldmVudC5vcmlnaW5hbEV2ZW50LnBlcnNpc3RlZCkge1xyXG4gICAgICAgIGpRdWVyeShcIi5zZWFyY2hhbmRmaWx0ZXJcIikub2ZmKCk7XHJcbiAgICAgICAgalF1ZXJ5KFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuICAgIH1cclxufSk7XHJcblxyXG4vKiB3cG51bWIgLSBub3Vpc2xpZGVyIG51bWJlciBmb3JtYXR0aW5nICovXHJcbiFmdW5jdGlvbigpe1widXNlIHN0cmljdFwiO2Z1bmN0aW9uIGUoZSl7cmV0dXJuIGUuc3BsaXQoXCJcIikucmV2ZXJzZSgpLmpvaW4oXCJcIil9ZnVuY3Rpb24gbihlLG4pe3JldHVybiBlLnN1YnN0cmluZygwLG4ubGVuZ3RoKT09PW59ZnVuY3Rpb24gcihlLG4pe3JldHVybiBlLnNsaWNlKC0xKm4ubGVuZ3RoKT09PW59ZnVuY3Rpb24gdChlLG4scil7aWYoKGVbbl18fGVbcl0pJiZlW25dPT09ZVtyXSl0aHJvdyBuZXcgRXJyb3Iobil9ZnVuY3Rpb24gaShlKXtyZXR1cm5cIm51bWJlclwiPT10eXBlb2YgZSYmaXNGaW5pdGUoZSl9ZnVuY3Rpb24gbyhlLG4pe3ZhciByPU1hdGgucG93KDEwLG4pO3JldHVybihNYXRoLnJvdW5kKGUqcikvcikudG9GaXhlZChuKX1mdW5jdGlvbiB1KG4scix0LHUsZixhLGMscyxwLGQsbCxoKXt2YXIgZyx2LHcsbT1oLHg9XCJcIixiPVwiXCI7cmV0dXJuIGEmJihoPWEoaCkpLGkoaCk/KG4hPT0hMSYmMD09PXBhcnNlRmxvYXQoaC50b0ZpeGVkKG4pKSYmKGg9MCksMD5oJiYoZz0hMCxoPU1hdGguYWJzKGgpKSxuIT09ITEmJihoPW8oaCxuKSksaD1oLnRvU3RyaW5nKCksLTEhPT1oLmluZGV4T2YoXCIuXCIpPyh2PWguc3BsaXQoXCIuXCIpLHc9dlswXSx0JiYoeD10K3ZbMV0pKTp3PWgsciYmKHc9ZSh3KS5tYXRjaCgvLnsxLDN9L2cpLHc9ZSh3LmpvaW4oZShyKSkpKSxnJiZzJiYoYis9cyksdSYmKGIrPXUpLGcmJnAmJihiKz1wKSxiKz13LGIrPXgsZiYmKGIrPWYpLGQmJihiPWQoYixtKSksYik6ITF9ZnVuY3Rpb24gZihlLHQsbyx1LGYsYSxjLHMscCxkLGwsaCl7dmFyIGcsdj1cIlwiO3JldHVybiBsJiYoaD1sKGgpKSxoJiZcInN0cmluZ1wiPT10eXBlb2YgaD8ocyYmbihoLHMpJiYoaD1oLnJlcGxhY2UocyxcIlwiKSxnPSEwKSx1JiZuKGgsdSkmJihoPWgucmVwbGFjZSh1LFwiXCIpKSxwJiZuKGgscCkmJihoPWgucmVwbGFjZShwLFwiXCIpLGc9ITApLGYmJnIoaCxmKSYmKGg9aC5zbGljZSgwLC0xKmYubGVuZ3RoKSksdCYmKGg9aC5zcGxpdCh0KS5qb2luKFwiXCIpKSxvJiYoaD1oLnJlcGxhY2UobyxcIi5cIikpLGcmJih2Kz1cIi1cIiksdis9aCx2PXYucmVwbGFjZSgvW14wLTlcXC5cXC0uXS9nLFwiXCIpLFwiXCI9PT12PyExOih2PU51bWJlcih2KSxjJiYodj1jKHYpKSxpKHYpP3Y6ITEpKTohMX1mdW5jdGlvbiBhKGUpe3ZhciBuLHIsaSxvPXt9O2ZvcihuPTA7bjxwLmxlbmd0aDtuKz0xKWlmKHI9cFtuXSxpPWVbcl0sdm9pZCAwPT09aSlcIm5lZ2F0aXZlXCIhPT1yfHxvLm5lZ2F0aXZlQmVmb3JlP1wibWFya1wiPT09ciYmXCIuXCIhPT1vLnRob3VzYW5kP29bcl09XCIuXCI6b1tyXT0hMTpvW3JdPVwiLVwiO2Vsc2UgaWYoXCJkZWNpbWFsc1wiPT09cil7aWYoIShpPj0wJiY4PmkpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9ZWxzZSBpZihcImVuY29kZXJcIj09PXJ8fFwiZGVjb2RlclwiPT09cnx8XCJlZGl0XCI9PT1yfHxcInVuZG9cIj09PXIpe2lmKFwiZnVuY3Rpb25cIiE9dHlwZW9mIGkpdGhyb3cgbmV3IEVycm9yKHIpO29bcl09aX1lbHNle2lmKFwic3RyaW5nXCIhPXR5cGVvZiBpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9cmV0dXJuIHQobyxcIm1hcmtcIixcInRob3VzYW5kXCIpLHQobyxcInByZWZpeFwiLFwibmVnYXRpdmVcIiksdChvLFwicHJlZml4XCIsXCJuZWdhdGl2ZUJlZm9yZVwiKSxvfWZ1bmN0aW9uIGMoZSxuLHIpe3ZhciB0LGk9W107Zm9yKHQ9MDt0PHAubGVuZ3RoO3QrPTEpaS5wdXNoKGVbcFt0XV0pO3JldHVybiBpLnB1c2gociksbi5hcHBseShcIlwiLGkpfWZ1bmN0aW9uIHMoZSl7cmV0dXJuIHRoaXMgaW5zdGFuY2VvZiBzP3ZvaWQoXCJvYmplY3RcIj09dHlwZW9mIGUmJihlPWEoZSksdGhpcy50bz1mdW5jdGlvbihuKXtyZXR1cm4gYyhlLHUsbil9LHRoaXMuZnJvbT1mdW5jdGlvbihuKXtyZXR1cm4gYyhlLGYsbil9KSk6bmV3IHMoZSl9dmFyIHA9W1wiZGVjaW1hbHNcIixcInRob3VzYW5kXCIsXCJtYXJrXCIsXCJwcmVmaXhcIixcInBvc3RmaXhcIixcImVuY29kZXJcIixcImRlY29kZXJcIixcIm5lZ2F0aXZlQmVmb3JlXCIsXCJuZWdhdGl2ZVwiLFwiZWRpdFwiLFwidW5kb1wiXTt3aW5kb3cud051bWI9c30oKTtcclxuXHJcblxufSkuY2FsbCh0aGlzLHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWwgOiB0eXBlb2Ygc2VsZiAhPT0gXCJ1bmRlZmluZWRcIiA/IHNlbGYgOiB0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93IDoge30pXG4vLyMgc291cmNlTWFwcGluZ1VSTD1kYXRhOmFwcGxpY2F0aW9uL2pzb247Y2hhcnNldDp1dGYtODtiYXNlNjQsZXlKMlpYSnphVzl1SWpvekxDSnpiM1Z5WTJWeklqcGJJbk55WXk5d2RXSnNhV012WVhOelpYUnpMMnB6TDJGd2NDNXFjeUpkTENKdVlXMWxjeUk2VzEwc0ltMWhjSEJwYm1keklqb2lPMEZCUVVFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEVpTENKbWFXeGxJam9pWjJWdVpYSmhkR1ZrTG1weklpd2ljMjkxY21ObFVtOXZkQ0k2SWlJc0luTnZkWEpqWlhORGIyNTBaVzUwSWpwYklseHlYRzUyWVhJZ2MzUmhkR1VnUFNCeVpYRjFhWEpsS0NjdUwybHVZMngxWkdWekwzTjBZWFJsSnlrN1hISmNiblpoY2lCd2JIVm5hVzRnUFNCeVpYRjFhWEpsS0NjdUwybHVZMngxWkdWekwzQnNkV2RwYmljcE8xeHlYRzVjY2x4dVhISmNiaWhtZFc1amRHbHZiaUFvSUNRZ0tTQjdYSEpjYmx4eVhHNWNkRndpZFhObElITjBjbWxqZEZ3aU8xeHlYRzVjY2x4dVhIUWtLR1oxYm1OMGFXOXVJQ2dwSUh0Y2NseHVYSEpjYmx4MFhIUlRkSEpwYm1jdWNISnZkRzkwZVhCbExuSmxjR3hoWTJWQmJHd2dQU0JtZFc1amRHbHZiaWh6ZEhJeExDQnpkSEl5TENCcFoyNXZjbVVwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEhKbGRIVnliaUIwYUdsekxuSmxjR3hoWTJVb2JtVjNJRkpsWjBWNGNDaHpkSEl4TG5KbGNHeGhZMlVvTHloYlhGd3ZYRndzWEZ3aFhGeGNYRnhjWGx4Y0pGeGNlMXhjZlZ4Y1cxeGNYVnhjS0Z4Y0tWeGNMbHhjS2x4Y0sxeGNQMXhjZkZ4Y1BGeGNQbHhjTFZ4Y0psMHBMMmNzWENKY1hGeGNKQ1pjSWlrc0tHbG5ibTl5WlQ5Y0ltZHBYQ0k2WENKblhDSXBLU3dvZEhsd1pXOW1LSE4wY2pJcFBUMWNJbk4wY21sdVoxd2lLVDl6ZEhJeUxuSmxjR3hoWTJVb0wxeGNKQzluTEZ3aUpDUWtKRndpS1RwemRISXlLVHRjY2x4dVhIUmNkSDFjY2x4dVhISmNibHgwWEhScFppQW9JVTlpYW1WamRDNXJaWGx6S1NCN1hISmNibHgwWEhRZ0lFOWlhbVZqZEM1clpYbHpJRDBnS0daMWJtTjBhVzl1SUNncElIdGNjbHh1WEhSY2RGeDBKM1Z6WlNCemRISnBZM1FuTzF4eVhHNWNkRngwWEhSMllYSWdhR0Z6VDNkdVVISnZjR1Z5ZEhrZ1BTQlBZbXBsWTNRdWNISnZkRzkwZVhCbExtaGhjMDkzYmxCeWIzQmxjblI1TEZ4eVhHNWNkRngwWEhSY2RHaGhjMFJ2Ym5SRmJuVnRRblZuSUQwZ0lTaDdkRzlUZEhKcGJtYzZJRzUxYkd4OUtTNXdjbTl3WlhKMGVVbHpSVzUxYldWeVlXSnNaU2duZEc5VGRISnBibWNuS1N4Y2NseHVYSFJjZEZ4MFhIUmtiMjUwUlc1MWJYTWdQU0JiWEhKY2JseDBYSFJjZEZ4MElDQW5kRzlUZEhKcGJtY25MRnh5WEc1Y2RGeDBYSFJjZENBZ0ozUnZURzlqWVd4bFUzUnlhVzVuSnl4Y2NseHVYSFJjZEZ4MFhIUWdJQ2QyWVd4MVpVOW1KeXhjY2x4dVhIUmNkRngwWEhRZ0lDZG9ZWE5QZDI1UWNtOXdaWEowZVNjc1hISmNibHgwWEhSY2RGeDBJQ0FuYVhOUWNtOTBiM1I1Y0dWUFppY3NYSEpjYmx4MFhIUmNkRngwSUNBbmNISnZjR1Z5ZEhsSmMwVnVkVzFsY21GaWJHVW5MRnh5WEc1Y2RGeDBYSFJjZENBZ0oyTnZibk4wY25WamRHOXlKMXh5WEc1Y2RGeDBYSFJjZEYwc1hISmNibHgwWEhSY2RGeDBaRzl1ZEVWdWRXMXpUR1Z1WjNSb0lEMGdaRzl1ZEVWdWRXMXpMbXhsYm1kMGFEdGNjbHh1WEhKY2JseDBYSFJjZEhKbGRIVnliaUJtZFc1amRHbHZiaUFvYjJKcUtTQjdYSEpjYmx4MFhIUmNkQ0FnYVdZZ0tIUjVjR1Z2WmlCdlltb2dJVDA5SUNkdlltcGxZM1FuSUNZbUlDaDBlWEJsYjJZZ2IySnFJQ0U5UFNBblpuVnVZM1JwYjI0bklIeDhJRzlpYWlBOVBUMGdiblZzYkNrcElIdGNjbHh1WEhSY2RGeDBYSFIwYUhKdmR5QnVaWGNnVkhsd1pVVnljbTl5S0NkUFltcGxZM1F1YTJWNWN5QmpZV3hzWldRZ2IyNGdibTl1TFc5aWFtVmpkQ2NwTzF4eVhHNWNkRngwWEhRZ0lIMWNjbHh1WEhKY2JseDBYSFJjZENBZ2RtRnlJSEpsYzNWc2RDQTlJRnRkTENCd2NtOXdMQ0JwTzF4eVhHNWNjbHh1WEhSY2RGeDBJQ0JtYjNJZ0tIQnliM0FnYVc0Z2IySnFLU0I3WEhKY2JseDBYSFJjZEZ4MGFXWWdLR2hoYzA5M2JsQnliM0JsY25SNUxtTmhiR3dvYjJKcUxDQndjbTl3S1NrZ2UxeHlYRzVjZEZ4MFhIUmNkQ0FnY21WemRXeDBMbkIxYzJnb2NISnZjQ2s3WEhKY2JseDBYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUWdJSDFjY2x4dVhISmNibHgwWEhSY2RDQWdhV1lnS0doaGMwUnZiblJGYm5WdFFuVm5LU0I3WEhKY2JseDBYSFJjZEZ4MFptOXlJQ2hwSUQwZ01Ec2dhU0E4SUdSdmJuUkZiblZ0YzB4bGJtZDBhRHNnYVNzcktTQjdYSEpjYmx4MFhIUmNkRngwSUNCcFppQW9hR0Z6VDNkdVVISnZjR1Z5ZEhrdVkyRnNiQ2h2WW1vc0lHUnZiblJGYm5WdGMxdHBYU2twSUh0Y2NseHVYSFJjZEZ4MFhIUmNkSEpsYzNWc2RDNXdkWE5vS0dSdmJuUkZiblZ0YzF0cFhTazdYSEpjYmx4MFhIUmNkRngwSUNCOVhISmNibHgwWEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFFnSUgxY2NseHVYSFJjZEZ4MElDQnlaWFIxY200Z2NtVnpkV3gwTzF4eVhHNWNkRngwWEhSOU8xeHlYRzVjZEZ4MElDQjlLQ2twTzF4eVhHNWNkRngwZlZ4eVhHNWNjbHh1WEhSY2RDOHFJRk5sWVhKamFDQW1JRVpwYkhSbGNpQnFVWFZsY25rZ1VHeDFaMmx1SUNvdlhISmNibHgwWEhRa0xtWnVMbk5sWVhKamFFRnVaRVpwYkhSbGNpQTlJSEJzZFdkcGJqdGNjbHh1WEhKY2JseDBYSFF2S2lCcGJtbDBJQ292WEhKY2JseDBYSFFrS0Z3aUxuTmxZWEpqYUdGdVpHWnBiSFJsY2x3aUtTNXpaV0Z5WTJoQmJtUkdhV3gwWlhJb0tUdGNjbHh1WEhKY2JseDBYSFF2S2lCbGVIUmxjbTVoYkNCamIyNTBjbTlzY3lBcUwxeHlYRzVjZEZ4MEpDaGtiMk4xYldWdWRDa3ViMjRvWENKamJHbGphMXdpTENCY0lpNXpaV0Z5WTJndFptbHNkR1Z5TFhKbGMyVjBYQ0lzSUdaMWJtTjBhVzl1S0dVcGUxeHlYRzVjY2x4dVhIUmNkRngwWlM1d2NtVjJaVzUwUkdWbVlYVnNkQ2dwTzF4eVhHNWNjbHh1WEhSY2RGeDBkbUZ5SUhObFlYSmphRVp2Y20xSlJDQTlJSFI1Y0dWdlppZ2tLSFJvYVhNcExtRjBkSElvWENKa1lYUmhMWE5sWVhKamFDMW1iM0p0TFdsa1hDSXBLU0U5WENKMWJtUmxabWx1WldSY0lpQS9JQ1FvZEdocGN5a3VZWFIwY2loY0ltUmhkR0V0YzJWaGNtTm9MV1p2Y20wdGFXUmNJaWtnT2lCY0lsd2lPMXh5WEc1Y2RGeDBYSFIyWVhJZ2MzVmliV2wwUm05eWJTQTlJSFI1Y0dWdlppZ2tLSFJvYVhNcExtRjBkSElvWENKa1lYUmhMWE5tTFhOMVltMXBkQzFtYjNKdFhDSXBLU0U5WENKMWJtUmxabWx1WldSY0lpQS9JQ1FvZEdocGN5a3VZWFIwY2loY0ltUmhkR0V0YzJZdGMzVmliV2wwTFdadmNtMWNJaWtnT2lCY0lsd2lPMXh5WEc1Y2NseHVYSFJjZEZ4MGMzUmhkR1V1WjJWMFUyVmhjbU5vUm05eWJTaHpaV0Z5WTJoR2IzSnRTVVFwTG5KbGMyVjBLSE4xWW0xcGRFWnZjbTBwTzF4eVhHNWNjbHh1WEhSY2RGeDBMeTkyWVhJZ0pHeHBibXRsWkNBOUlDUW9YQ0lqYzJWaGNtTm9MV1pwYkhSbGNpMW1iM0p0TFZ3aUszTmxZWEpqYUVadmNtMUpSQ2t1YzJWaGNtTm9SbWxzZEdWeVJtOXliU2g3WVdOMGFXOXVPaUJjSW5KbGMyVjBYQ0o5S1R0Y2NseHVYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQm1ZV3h6WlR0Y2NseHVYSEpjYmx4MFhIUjlLVHRjY2x4dVhISmNibHgwZlNrN1hISmNibHh5WEc1Y2NseHVMeXBjY2x4dUlDb2dhbEYxWlhKNUlFVmhjMmx1WnlCMk1TNDBMakVnTFNCb2RIUndPaTh2WjNOblpDNWpieTUxYXk5ellXNWtZbTk0TDJweGRXVnllUzlsWVhOcGJtY3ZYSEpjYmlBcUlFOXdaVzRnYzI5MWNtTmxJSFZ1WkdWeUlIUm9aU0JDVTBRZ1RHbGpaVzV6WlM1Y2NseHVJQ29nUTI5d2VYSnBaMmgwSU1LcElESXdNRGdnUjJWdmNtZGxJRTFqUjJsdWJHVjVJRk50YVhSb1hISmNiaUFxSUVGc2JDQnlhV2RvZEhNZ2NtVnpaWEoyWldRdVhISmNiaUFxSUdoMGRIQnpPaTh2Y21GM0xtZHBkR2gxWWk1amIyMHZaMlJ6YldsMGFDOXFjWFZsY25rdVpXRnphVzVuTDIxaGMzUmxjaTlNU1VORlRsTkZYSEpjYmlvdlhISmNibHh5WEc0dktpQm5iRzlpWVd4eklHcFJkV1Z5ZVN3Z1pHVm1hVzVsTENCdGIyUjFiR1VzSUhKbGNYVnBjbVVnS2k5Y2NseHVLR1oxYm1OMGFXOXVJQ2htWVdOMGIzSjVLU0I3WEhKY2JseDBhV1lnS0hSNWNHVnZaaUJrWldacGJtVWdQVDA5SUZ3aVpuVnVZM1JwYjI1Y0lpQW1KaUJrWldacGJtVXVZVzFrS1NCN1hISmNibHgwWEhSa1pXWnBibVVvV3lkcWNYVmxjbmtuWFN3Z1puVnVZM1JwYjI0Z0tDUXBJSHRjY2x4dVhIUmNkRngwY21WMGRYSnVJR1poWTNSdmNua29KQ2s3WEhKY2JseDBYSFI5S1R0Y2NseHVYSFI5SUdWc2MyVWdhV1lnS0hSNWNHVnZaaUJ0YjJSMWJHVWdQVDA5SUZ3aWIySnFaV04wWENJZ0ppWWdkSGx3Wlc5bUlHMXZaSFZzWlM1bGVIQnZjblJ6SUQwOVBTQmNJbTlpYW1WamRGd2lLU0I3WEhKY2JseDBYSFJ0YjJSMWJHVXVaWGh3YjNKMGN5QTlJR1poWTNSdmNua29LSFI1Y0dWdlppQjNhVzVrYjNjZ0lUMDlJRndpZFc1a1pXWnBibVZrWENJZ1B5QjNhVzVrYjNkYkoycFJkV1Z5ZVNkZElEb2dkSGx3Wlc5bUlHZHNiMkpoYkNBaFBUMGdYQ0oxYm1SbFptbHVaV1JjSWlBL0lHZHNiMkpoYkZzbmFsRjFaWEo1SjEwZ09pQnVkV3hzS1NrN1hISmNibHgwZlNCbGJITmxJSHRjY2x4dVhIUmNkR1poWTNSdmNua29hbEYxWlhKNUtUdGNjbHh1WEhSOVhISmNibjBwS0daMWJtTjBhVzl1S0NRcGUxeHlYRzVjY2x4dVhIUXZMeUJRY21WelpYSjJaU0IwYUdVZ2IzSnBaMmx1WVd3Z2FsRjFaWEo1SUZ3aWMzZHBibWRjSWlCbFlYTnBibWNnWVhNZ1hDSnFjM2RwYm1kY0lseHlYRzVjZEdsbUlDaDBlWEJsYjJZZ0pDNWxZWE5wYm1jZ0lUMDlJQ2QxYm1SbFptbHVaV1FuS1NCN1hISmNibHgwWEhRa0xtVmhjMmx1WjFzbmFuTjNhVzVuSjEwZ1BTQWtMbVZoYzJsdVoxc25jM2RwYm1jblhUdGNjbHh1WEhSOVhISmNibHh5WEc1Y2RIWmhjaUJ3YjNjZ1BTQk5ZWFJvTG5CdmR5eGNjbHh1WEhSY2RITnhjblFnUFNCTllYUm9Mbk54Y25Rc1hISmNibHgwWEhSemFXNGdQU0JOWVhSb0xuTnBiaXhjY2x4dVhIUmNkR052Y3lBOUlFMWhkR2d1WTI5ekxGeHlYRzVjZEZ4MFVFa2dQU0JOWVhSb0xsQkpMRnh5WEc1Y2RGeDBZekVnUFNBeExqY3dNVFU0TEZ4eVhHNWNkRngwWXpJZ1BTQmpNU0FxSURFdU5USTFMRnh5WEc1Y2RGeDBZek1nUFNCak1TQXJJREVzWEhKY2JseDBYSFJqTkNBOUlDZ2dNaUFxSUZCSklDa2dMeUF6TEZ4eVhHNWNkRngwWXpVZ1BTQW9JRElnS2lCUVNTQXBJQzhnTkM0MU8xeHlYRzVjY2x4dVhIUXZMeUI0SUdseklIUm9aU0JtY21GamRHbHZiaUJ2WmlCaGJtbHRZWFJwYjI0Z2NISnZaM0psYzNNc0lHbHVJSFJvWlNCeVlXNW5aU0F3TGk0eFhISmNibHgwWm5WdVkzUnBiMjRnWW05MWJtTmxUM1YwS0hncElIdGNjbHh1WEhSY2RIWmhjaUJ1TVNBOUlEY3VOVFl5TlN4Y2NseHVYSFJjZEZ4MFpERWdQU0F5TGpjMU8xeHlYRzVjZEZ4MGFXWWdLQ0I0SUR3Z01TOWtNU0FwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUc0eEtuZ3FlRHRjY2x4dVhIUmNkSDBnWld4elpTQnBaaUFvSUhnZ1BDQXlMMlF4SUNrZ2UxeHlYRzVjZEZ4MFhIUnlaWFIxY200Z2JqRXFLSGd0UFNneExqVXZaREVwS1NwNElDc2dMamMxTzF4eVhHNWNkRngwZlNCbGJITmxJR2xtSUNnZ2VDQThJREl1TlM5a01TQXBJSHRjY2x4dVhIUmNkRngwY21WMGRYSnVJRzR4S2loNExUMG9NaTR5TlM5a01Ta3BLbmdnS3lBdU9UTTNOVHRjY2x4dVhIUmNkSDBnWld4elpTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQnVNU29vZUMwOUtESXVOakkxTDJReEtTa3FlQ0FySUM0NU9EUXpOelU3WEhKY2JseDBYSFI5WEhKY2JseDBmVnh5WEc1Y2NseHVYSFFrTG1WNGRHVnVaQ2dnSkM1bFlYTnBibWNzSUh0Y2NseHVYSFJjZEdSbFpqb2dKMlZoYzJWUGRYUlJkV0ZrSnl4Y2NseHVYSFJjZEhOM2FXNW5PaUJtZFc1amRHbHZiaUFvZUNrZ2UxeHlYRzVjZEZ4MFhIUnlaWFIxY200Z0pDNWxZWE5wYm1kYkpDNWxZWE5wYm1jdVpHVm1YU2g0S1R0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxTVzVSZFdGa09pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnZUNBcUlIZzdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlU5MWRGRjFZV1E2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQXhJQzBnS0NBeElDMGdlQ0FwSUNvZ0tDQXhJQzBnZUNBcE8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZKYms5MWRGRjFZV1E2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJRHdnTUM0MUlEOWNjbHh1WEhSY2RGeDBYSFF5SUNvZ2VDQXFJSGdnT2x4eVhHNWNkRngwWEhSY2RERWdMU0J3YjNjb0lDMHlJQ29nZUNBcklESXNJRElnS1NBdklESTdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlVsdVEzVmlhV002SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJQ29nZUNBcUlIZzdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlU5MWRFTjFZbWxqT2lCbWRXNWpkR2x2YmlBb2VDa2dlMXh5WEc1Y2RGeDBYSFJ5WlhSMWNtNGdNU0F0SUhCdmR5Z2dNU0F0SUhnc0lETWdLVHRjY2x4dVhIUmNkSDBzWEhKY2JseDBYSFJsWVhObFNXNVBkWFJEZFdKcFl6b2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUhnZ1BDQXdMalVnUDF4eVhHNWNkRngwWEhSY2REUWdLaUI0SUNvZ2VDQXFJSGdnT2x4eVhHNWNkRngwWEhSY2RERWdMU0J3YjNjb0lDMHlJQ29nZUNBcklESXNJRE1nS1NBdklESTdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlVsdVVYVmhjblE2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJQ29nZUNBcUlIZ2dLaUI0TzF4eVhHNWNkRngwZlN4Y2NseHVYSFJjZEdWaGMyVlBkWFJSZFdGeWREb2dablZ1WTNScGIyNGdLSGdwSUh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SURFZ0xTQndiM2NvSURFZ0xTQjRMQ0EwSUNrN1hISmNibHgwWEhSOUxGeHlYRzVjZEZ4MFpXRnpaVWx1VDNWMFVYVmhjblE2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJRHdnTUM0MUlEOWNjbHh1WEhSY2RGeDBYSFE0SUNvZ2VDQXFJSGdnS2lCNElDb2dlQ0E2WEhKY2JseDBYSFJjZEZ4ME1TQXRJSEJ2ZHlnZ0xUSWdLaUI0SUNzZ01pd2dOQ0FwSUM4Z01qdGNjbHh1WEhSY2RIMHNYSEpjYmx4MFhIUmxZWE5sU1c1UmRXbHVkRG9nWm5WdVkzUnBiMjRnS0hncElIdGNjbHh1WEhSY2RGeDBjbVYwZFhKdUlIZ2dLaUI0SUNvZ2VDQXFJSGdnS2lCNE8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZQZFhSUmRXbHVkRG9nWm5WdVkzUnBiMjRnS0hncElIdGNjbHh1WEhSY2RGeDBjbVYwZFhKdUlERWdMU0J3YjNjb0lERWdMU0I0TENBMUlDazdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlVsdVQzVjBVWFZwYm5RNklHWjFibU4wYVc5dUlDaDRLU0I3WEhKY2JseDBYSFJjZEhKbGRIVnliaUI0SUR3Z01DNDFJRDljY2x4dVhIUmNkRngwWEhReE5pQXFJSGdnS2lCNElDb2dlQ0FxSUhnZ0tpQjRJRHBjY2x4dVhIUmNkRngwWEhReElDMGdjRzkzS0NBdE1pQXFJSGdnS3lBeUxDQTFJQ2tnTHlBeU8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZKYmxOcGJtVTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hISmNibHgwWEhSY2RISmxkSFZ5YmlBeElDMGdZMjl6S0NCNElDb2dVRWt2TWlBcE8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZQZFhSVGFXNWxPaUJtZFc1amRHbHZiaUFvZUNrZ2UxeHlYRzVjZEZ4MFhIUnlaWFIxY200Z2MybHVLQ0I0SUNvZ1VFa3ZNaUFwTzF4eVhHNWNkRngwZlN4Y2NseHVYSFJjZEdWaGMyVkpiazkxZEZOcGJtVTZJR1oxYm1OMGFXOXVJQ2g0S1NCN1hISmNibHgwWEhSY2RISmxkSFZ5YmlBdEtDQmpiM01vSUZCSklDb2dlQ0FwSUMwZ01TQXBJQzhnTWp0Y2NseHVYSFJjZEgwc1hISmNibHgwWEhSbFlYTmxTVzVGZUhCdk9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnZUNBOVBUMGdNQ0EvSURBZ09pQndiM2NvSURJc0lERXdJQ29nZUNBdElERXdJQ2s3WEhKY2JseDBYSFI5TEZ4eVhHNWNkRngwWldGelpVOTFkRVY0Y0c4NklHWjFibU4wYVc5dUlDaDRLU0I3WEhKY2JseDBYSFJjZEhKbGRIVnliaUI0SUQwOVBTQXhJRDhnTVNBNklERWdMU0J3YjNjb0lESXNJQzB4TUNBcUlIZ2dLVHRjY2x4dVhIUmNkSDBzWEhKY2JseDBYSFJsWVhObFNXNVBkWFJGZUhCdk9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnZUNBOVBUMGdNQ0EvSURBZ09pQjRJRDA5UFNBeElEOGdNU0E2SUhnZ1BDQXdMalVnUDF4eVhHNWNkRngwWEhSY2RIQnZkeWdnTWl3Z01qQWdLaUI0SUMwZ01UQWdLU0F2SURJZ09seHlYRzVjZEZ4MFhIUmNkQ2dnTWlBdElIQnZkeWdnTWl3Z0xUSXdJQ29nZUNBcklERXdJQ2tnS1NBdklESTdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlVsdVEybHlZem9nWm5WdVkzUnBiMjRnS0hncElIdGNjbHh1WEhSY2RGeDBjbVYwZFhKdUlERWdMU0J6Y1hKMEtDQXhJQzBnY0c5M0tDQjRMQ0F5SUNrZ0tUdGNjbHh1WEhSY2RIMHNYSEpjYmx4MFhIUmxZWE5sVDNWMFEybHlZem9nWm5WdVkzUnBiMjRnS0hncElIdGNjbHh1WEhSY2RGeDBjbVYwZFhKdUlITnhjblFvSURFZ0xTQndiM2NvSUhnZ0xTQXhMQ0F5SUNrZ0tUdGNjbHh1WEhSY2RIMHNYSEpjYmx4MFhIUmxZWE5sU1c1UGRYUkRhWEpqT2lCbWRXNWpkR2x2YmlBb2VDa2dlMXh5WEc1Y2RGeDBYSFJ5WlhSMWNtNGdlQ0E4SURBdU5TQS9YSEpjYmx4MFhIUmNkRngwS0NBeElDMGdjM0Z5ZENnZ01TQXRJSEJ2ZHlnZ01pQXFJSGdzSURJZ0tTQXBJQ2tnTHlBeUlEcGNjbHh1WEhSY2RGeDBYSFFvSUhOeGNuUW9JREVnTFNCd2IzY29JQzB5SUNvZ2VDQXJJRElzSURJZ0tTQXBJQ3NnTVNBcElDOGdNanRjY2x4dVhIUmNkSDBzWEhKY2JseDBYSFJsWVhObFNXNUZiR0Z6ZEdsak9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnZUNBOVBUMGdNQ0EvSURBZ09pQjRJRDA5UFNBeElEOGdNU0E2WEhKY2JseDBYSFJjZEZ4MExYQnZkeWdnTWl3Z01UQWdLaUI0SUMwZ01UQWdLU0FxSUhOcGJpZ2dLQ0I0SUNvZ01UQWdMU0F4TUM0M05TQXBJQ29nWXpRZ0tUdGNjbHh1WEhSY2RIMHNYSEpjYmx4MFhIUmxZWE5sVDNWMFJXeGhjM1JwWXpvZ1puVnVZM1JwYjI0Z0tIZ3BJSHRjY2x4dVhIUmNkRngwY21WMGRYSnVJSGdnUFQwOUlEQWdQeUF3SURvZ2VDQTlQVDBnTVNBL0lERWdPbHh5WEc1Y2RGeDBYSFJjZEhCdmR5Z2dNaXdnTFRFd0lDb2dlQ0FwSUNvZ2MybHVLQ0FvSUhnZ0tpQXhNQ0F0SURBdU56VWdLU0FxSUdNMElDa2dLeUF4TzF4eVhHNWNkRngwZlN4Y2NseHVYSFJjZEdWaGMyVkpiazkxZEVWc1lYTjBhV002SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQjRJRDA5UFNBd0lEOGdNQ0E2SUhnZ1BUMDlJREVnUHlBeElEb2dlQ0E4SURBdU5TQS9YSEpjYmx4MFhIUmNkRngwTFNnZ2NHOTNLQ0F5TENBeU1DQXFJSGdnTFNBeE1DQXBJQ29nYzJsdUtDQW9JREl3SUNvZ2VDQXRJREV4TGpFeU5TQXBJQ29nWXpVZ0tTa2dMeUF5SURwY2NseHVYSFJjZEZ4MFhIUndiM2NvSURJc0lDMHlNQ0FxSUhnZ0t5QXhNQ0FwSUNvZ2MybHVLQ0FvSURJd0lDb2dlQ0F0SURFeExqRXlOU0FwSUNvZ1l6VWdLU0F2SURJZ0t5QXhPMXh5WEc1Y2RGeDBmU3hjY2x4dVhIUmNkR1ZoYzJWSmJrSmhZMnM2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQmpNeUFxSUhnZ0tpQjRJQ29nZUNBdElHTXhJQ29nZUNBcUlIZzdYSEpjYmx4MFhIUjlMRnh5WEc1Y2RGeDBaV0Z6WlU5MWRFSmhZMnM2SUdaMWJtTjBhVzl1SUNoNEtTQjdYSEpjYmx4MFhIUmNkSEpsZEhWeWJpQXhJQ3NnWXpNZ0tpQndiM2NvSUhnZ0xTQXhMQ0F6SUNrZ0t5QmpNU0FxSUhCdmR5Z2dlQ0F0SURFc0lESWdLVHRjY2x4dVhIUmNkSDBzWEhKY2JseDBYSFJsWVhObFNXNVBkWFJDWVdOck9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnZUNBOElEQXVOU0EvWEhKY2JseDBYSFJjZEZ4MEtDQndiM2NvSURJZ0tpQjRMQ0F5SUNrZ0tpQW9JQ2dnWXpJZ0t5QXhJQ2tnS2lBeUlDb2dlQ0F0SUdNeUlDa2dLU0F2SURJZ09seHlYRzVjZEZ4MFhIUmNkQ2dnY0c5M0tDQXlJQ29nZUNBdElESXNJRElnS1NBcUtDQW9JR015SUNzZ01TQXBJQ29nS0NCNElDb2dNaUF0SURJZ0tTQXJJR015SUNrZ0t5QXlJQ2tnTHlBeU8xeHlYRzVjZEZ4MGZTeGNjbHh1WEhSY2RHVmhjMlZKYmtKdmRXNWpaVG9nWm5WdVkzUnBiMjRnS0hncElIdGNjbHh1WEhSY2RGeDBjbVYwZFhKdUlERWdMU0JpYjNWdVkyVlBkWFFvSURFZ0xTQjRJQ2s3WEhKY2JseDBYSFI5TEZ4eVhHNWNkRngwWldGelpVOTFkRUp2ZFc1alpUb2dZbTkxYm1ObFQzVjBMRnh5WEc1Y2RGeDBaV0Z6WlVsdVQzVjBRbTkxYm1ObE9pQm1kVzVqZEdsdmJpQW9lQ2tnZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnZUNBOElEQXVOU0EvWEhKY2JseDBYSFJjZEZ4MEtDQXhJQzBnWW05MWJtTmxUM1YwS0NBeElDMGdNaUFxSUhnZ0tTQXBJQzhnTWlBNlhISmNibHgwWEhSY2RGeDBLQ0F4SUNzZ1ltOTFibU5sVDNWMEtDQXlJQ29nZUNBdElERWdLU0FwSUM4Z01qdGNjbHh1WEhSY2RIMWNjbHh1WEhSOUtUdGNjbHh1WEhSeVpYUjFjbTRnSkR0Y2NseHVmU2s3WEhKY2JseHlYRzU5S0dwUmRXVnllU2twTzF4eVhHNWNjbHh1THk5ellXWmhjbWtnWW1GamF5QmlkWFIwYjI0Z1ptbDRYSEpjYm1wUmRXVnllU2dnZDJsdVpHOTNJQ2t1YjI0b0lGd2ljR0ZuWlhOb2IzZGNJaXdnWm5WdVkzUnBiMjRvWlhabGJuUXBJSHRjY2x4dUlDQWdJR2xtSUNobGRtVnVkQzV2Y21sbmFXNWhiRVYyWlc1MExuQmxjbk5wYzNSbFpDa2dlMXh5WEc0Z0lDQWdJQ0FnSUdwUmRXVnllU2hjSWk1elpXRnlZMmhoYm1SbWFXeDBaWEpjSWlrdWIyWm1LQ2s3WEhKY2JpQWdJQ0FnSUNBZ2FsRjFaWEo1S0Z3aUxuTmxZWEpqYUdGdVpHWnBiSFJsY2x3aUtTNXpaV0Z5WTJoQmJtUkdhV3gwWlhJb0tUdGNjbHh1SUNBZ0lIMWNjbHh1ZlNrN1hISmNibHh5WEc0dktpQjNjRzUxYldJZ0xTQnViM1ZwYzJ4cFpHVnlJRzUxYldKbGNpQm1iM0p0WVhSMGFXNW5JQ292WEhKY2JpRm1kVzVqZEdsdmJpZ3BlMXdpZFhObElITjBjbWxqZEZ3aU8yWjFibU4wYVc5dUlHVW9aU2w3Y21WMGRYSnVJR1V1YzNCc2FYUW9YQ0pjSWlrdWNtVjJaWEp6WlNncExtcHZhVzRvWENKY0lpbDlablZ1WTNScGIyNGdiaWhsTEc0cGUzSmxkSFZ5YmlCbExuTjFZbk4wY21sdVp5Z3dMRzR1YkdWdVozUm9LVDA5UFc1OVpuVnVZM1JwYjI0Z2NpaGxMRzRwZTNKbGRIVnliaUJsTG5Oc2FXTmxLQzB4S200dWJHVnVaM1JvS1QwOVBXNTlablZ1WTNScGIyNGdkQ2hsTEc0c2NpbDdhV1lvS0dWYmJsMThmR1ZiY2wwcEppWmxXMjVkUFQwOVpWdHlYU2wwYUhKdmR5QnVaWGNnUlhKeWIzSW9iaWw5Wm5WdVkzUnBiMjRnYVNobEtYdHlaWFIxY201Y0ltNTFiV0psY2x3aVBUMTBlWEJsYjJZZ1pTWW1hWE5HYVc1cGRHVW9aU2w5Wm5WdVkzUnBiMjRnYnlobExHNHBlM1poY2lCeVBVMWhkR2d1Y0c5M0tERXdMRzRwTzNKbGRIVnliaWhOWVhSb0xuSnZkVzVrS0dVcWNpa3ZjaWt1ZEc5R2FYaGxaQ2h1S1gxbWRXNWpkR2x2YmlCMUtHNHNjaXgwTEhVc1ppeGhMR01zY3l4d0xHUXNiQ3hvS1h0MllYSWdaeXgyTEhjc2JUMW9MSGc5WENKY0lpeGlQVndpWENJN2NtVjBkWEp1SUdFbUppaG9QV0VvYUNrcExHa29hQ2svS0c0aFBUMGhNU1ltTUQwOVBYQmhjbk5sUm14dllYUW9hQzUwYjBacGVHVmtLRzRwS1NZbUtHZzlNQ2tzTUQ1b0ppWW9aejBoTUN4b1BVMWhkR2d1WVdKektHZ3BLU3h1SVQwOUlURW1KaWhvUFc4b2FDeHVLU2tzYUQxb0xuUnZVM1J5YVc1bktDa3NMVEVoUFQxb0xtbHVaR1Y0VDJZb1hDSXVYQ0lwUHloMlBXZ3VjM0JzYVhRb1hDSXVYQ0lwTEhjOWRsc3dYU3gwSmlZb2VEMTBLM1piTVYwcEtUcDNQV2dzY2lZbUtIYzlaU2gzS1M1dFlYUmphQ2d2TG5zeExETjlMMmNwTEhjOVpTaDNMbXB2YVc0b1pTaHlLU2twS1N4bkppWnpKaVlvWWlzOWN5a3NkU1ltS0dJclBYVXBMR2NtSm5BbUppaGlLejF3S1N4aUt6MTNMR0lyUFhnc1ppWW1LR0lyUFdZcExHUW1KaWhpUFdRb1lpeHRLU2tzWWlrNklURjlablZ1WTNScGIyNGdaaWhsTEhRc2J5eDFMR1lzWVN4akxITXNjQ3hrTEd3c2FDbDdkbUZ5SUdjc2RqMWNJbHdpTzNKbGRIVnliaUJzSmlZb2FEMXNLR2dwS1N4b0ppWmNJbk4wY21sdVoxd2lQVDEwZVhCbGIyWWdhRDhvY3lZbWJpaG9MSE1wSmlZb2FEMW9MbkpsY0d4aFkyVW9jeXhjSWx3aUtTeG5QU0V3S1N4MUppWnVLR2dzZFNrbUppaG9QV2d1Y21Wd2JHRmpaU2gxTEZ3aVhDSXBLU3h3SmladUtHZ3NjQ2ttSmlob1BXZ3VjbVZ3YkdGalpTaHdMRndpWENJcExHYzlJVEFwTEdZbUpuSW9hQ3htS1NZbUtHZzlhQzV6YkdsalpTZ3dMQzB4S21ZdWJHVnVaM1JvS1Nrc2RDWW1LR2c5YUM1emNHeHBkQ2gwS1M1cWIybHVLRndpWENJcEtTeHZKaVlvYUQxb0xuSmxjR3hoWTJVb2J5eGNJaTVjSWlrcExHY21KaWgyS3oxY0lpMWNJaWtzZGlzOWFDeDJQWFl1Y21Wd2JHRmpaU2d2VzE0d0xUbGNYQzVjWEMwdVhTOW5MRndpWENJcExGd2lYQ0k5UFQxMlB5RXhPaWgyUFU1MWJXSmxjaWgyS1N4akppWW9kajFqS0hZcEtTeHBLSFlwUDNZNklURXBLVG9oTVgxbWRXNWpkR2x2YmlCaEtHVXBlM1poY2lCdUxISXNhU3h2UFh0OU8yWnZjaWh1UFRBN2JqeHdMbXhsYm1kMGFEdHVLejB4S1dsbUtISTljRnR1WFN4cFBXVmJjbDBzZG05cFpDQXdQVDA5YVNsY0ltNWxaMkYwYVhabFhDSWhQVDF5Zkh4dkxtNWxaMkYwYVhabFFtVm1iM0psUDF3aWJXRnlhMXdpUFQwOWNpWW1YQ0l1WENJaFBUMXZMblJvYjNWellXNWtQMjliY2wwOVhDSXVYQ0k2YjF0eVhUMGhNVHB2VzNKZFBWd2lMVndpTzJWc2MyVWdhV1lvWENKa1pXTnBiV0ZzYzF3aVBUMDljaWw3YVdZb0lTaHBQajB3SmlZNFBta3BLWFJvY205M0lHNWxkeUJGY25KdmNpaHlLVHR2VzNKZFBXbDlaV3h6WlNCcFppaGNJbVZ1WTI5a1pYSmNJajA5UFhKOGZGd2laR1ZqYjJSbGNsd2lQVDA5Y254OFhDSmxaR2wwWENJOVBUMXlmSHhjSW5WdVpHOWNJajA5UFhJcGUybG1LRndpWm5WdVkzUnBiMjVjSWlFOWRIbHdaVzltSUdrcGRHaHliM2NnYm1WM0lFVnljbTl5S0hJcE8yOWJjbDA5YVgxbGJITmxlMmxtS0Z3aWMzUnlhVzVuWENJaFBYUjVjR1Z2WmlCcEtYUm9jbTkzSUc1bGR5QkZjbkp2Y2loeUtUdHZXM0pkUFdsOWNtVjBkWEp1SUhRb2J5eGNJbTFoY210Y0lpeGNJblJvYjNWellXNWtYQ0lwTEhRb2J5eGNJbkJ5WldacGVGd2lMRndpYm1WbllYUnBkbVZjSWlrc2RDaHZMRndpY0hKbFptbDRYQ0lzWENKdVpXZGhkR2wyWlVKbFptOXlaVndpS1N4dmZXWjFibU4wYVc5dUlHTW9aU3h1TEhJcGUzWmhjaUIwTEdrOVcxMDdabTl5S0hROU1EdDBQSEF1YkdWdVozUm9PM1FyUFRFcGFTNXdkWE5vS0dWYmNGdDBYVjBwTzNKbGRIVnliaUJwTG5CMWMyZ29jaWtzYmk1aGNIQnNlU2hjSWx3aUxHa3BmV1oxYm1OMGFXOXVJSE1vWlNsN2NtVjBkWEp1SUhSb2FYTWdhVzV6ZEdGdVkyVnZaaUJ6UDNadmFXUW9YQ0p2WW1wbFkzUmNJajA5ZEhsd1pXOW1JR1VtSmlobFBXRW9aU2tzZEdocGN5NTBiejFtZFc1amRHbHZiaWh1S1h0eVpYUjFjbTRnWXlobExIVXNiaWw5TEhSb2FYTXVabkp2YlQxbWRXNWpkR2x2YmlodUtYdHlaWFIxY200Z1l5aGxMR1lzYmlsOUtTazZibVYzSUhNb1pTbDlkbUZ5SUhBOVcxd2laR1ZqYVcxaGJITmNJaXhjSW5Sb2IzVnpZVzVrWENJc1hDSnRZWEpyWENJc1hDSndjbVZtYVhoY0lpeGNJbkJ2YzNSbWFYaGNJaXhjSW1WdVkyOWtaWEpjSWl4Y0ltUmxZMjlrWlhKY0lpeGNJbTVsWjJGMGFYWmxRbVZtYjNKbFhDSXNYQ0p1WldkaGRHbDJaVndpTEZ3aVpXUnBkRndpTEZ3aWRXNWtiMXdpWFR0M2FXNWtiM2N1ZDA1MWJXSTljMzBvS1R0Y2NseHVYSEpjYmlKZGZRPT0iLCIvKiEgbm91aXNsaWRlciAtIDExLjEuMCAtIDIwMTgtMDQtMDIgMTE6MTg6MTMgKi9cclxuXHJcbihmdW5jdGlvbiAoZmFjdG9yeSkge1xyXG5cclxuICAgIGlmICggdHlwZW9mIGRlZmluZSA9PT0gJ2Z1bmN0aW9uJyAmJiBkZWZpbmUuYW1kICkge1xyXG5cclxuICAgICAgICAvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXHJcbiAgICAgICAgZGVmaW5lKFtdLCBmYWN0b3J5KTtcclxuXHJcbiAgICB9IGVsc2UgaWYgKCB0eXBlb2YgZXhwb3J0cyA9PT0gJ29iamVjdCcgKSB7XHJcblxyXG4gICAgICAgIC8vIE5vZGUvQ29tbW9uSlNcclxuICAgICAgICBtb2R1bGUuZXhwb3J0cyA9IGZhY3RvcnkoKTtcclxuXHJcbiAgICB9IGVsc2Uge1xyXG5cclxuICAgICAgICAvLyBCcm93c2VyIGdsb2JhbHNcclxuICAgICAgICB3aW5kb3cubm9VaVNsaWRlciA9IGZhY3RvcnkoKTtcclxuICAgIH1cclxuXHJcbn0oZnVuY3Rpb24oICl7XHJcblxyXG5cdCd1c2Ugc3RyaWN0JztcclxuXHJcblx0dmFyIFZFUlNJT04gPSAnMTEuMS4wJztcclxuXHJcblxuXHRmdW5jdGlvbiBpc1ZhbGlkRm9ybWF0dGVyICggZW50cnkgKSB7XG5cdFx0cmV0dXJuIHR5cGVvZiBlbnRyeSA9PT0gJ29iamVjdCcgJiYgdHlwZW9mIGVudHJ5LnRvID09PSAnZnVuY3Rpb24nICYmIHR5cGVvZiBlbnRyeS5mcm9tID09PSAnZnVuY3Rpb24nO1xuXHR9XG5cblx0ZnVuY3Rpb24gcmVtb3ZlRWxlbWVudCAoIGVsICkge1xuXHRcdGVsLnBhcmVudEVsZW1lbnQucmVtb3ZlQ2hpbGQoZWwpO1xuXHR9XG5cblx0ZnVuY3Rpb24gaXNTZXQgKCB2YWx1ZSApIHtcblx0XHRyZXR1cm4gdmFsdWUgIT09IG51bGwgJiYgdmFsdWUgIT09IHVuZGVmaW5lZDtcblx0fVxuXG5cdC8vIEJpbmRhYmxlIHZlcnNpb25cblx0ZnVuY3Rpb24gcHJldmVudERlZmF1bHQgKCBlICkge1xuXHRcdGUucHJldmVudERlZmF1bHQoKTtcblx0fVxuXG5cdC8vIFJlbW92ZXMgZHVwbGljYXRlcyBmcm9tIGFuIGFycmF5LlxuXHRmdW5jdGlvbiB1bmlxdWUgKCBhcnJheSApIHtcblx0XHRyZXR1cm4gYXJyYXkuZmlsdGVyKGZ1bmN0aW9uKGEpe1xuXHRcdFx0cmV0dXJuICF0aGlzW2FdID8gdGhpc1thXSA9IHRydWUgOiBmYWxzZTtcblx0XHR9LCB7fSk7XG5cdH1cblxuXHQvLyBSb3VuZCBhIHZhbHVlIHRvIHRoZSBjbG9zZXN0ICd0bycuXG5cdGZ1bmN0aW9uIGNsb3Nlc3QgKCB2YWx1ZSwgdG8gKSB7XG5cdFx0cmV0dXJuIE1hdGgucm91bmQodmFsdWUgLyB0bykgKiB0bztcblx0fVxuXG5cdC8vIEN1cnJlbnQgcG9zaXRpb24gb2YgYW4gZWxlbWVudCByZWxhdGl2ZSB0byB0aGUgZG9jdW1lbnQuXG5cdGZ1bmN0aW9uIG9mZnNldCAoIGVsZW0sIG9yaWVudGF0aW9uICkge1xuXG5cdFx0dmFyIHJlY3QgPSBlbGVtLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuXHRcdHZhciBkb2MgPSBlbGVtLm93bmVyRG9jdW1lbnQ7XG5cdFx0dmFyIGRvY0VsZW0gPSBkb2MuZG9jdW1lbnRFbGVtZW50O1xuXHRcdHZhciBwYWdlT2Zmc2V0ID0gZ2V0UGFnZU9mZnNldChkb2MpO1xuXG5cdFx0Ly8gZ2V0Qm91bmRpbmdDbGllbnRSZWN0IGNvbnRhaW5zIGxlZnQgc2Nyb2xsIGluIENocm9tZSBvbiBBbmRyb2lkLlxuXHRcdC8vIEkgaGF2ZW4ndCBmb3VuZCBhIGZlYXR1cmUgZGV0ZWN0aW9uIHRoYXQgcHJvdmVzIHRoaXMuIFdvcnN0IGNhc2Vcblx0XHQvLyBzY2VuYXJpbyBvbiBtaXMtbWF0Y2g6IHRoZSAndGFwJyBmZWF0dXJlIG9uIGhvcml6b250YWwgc2xpZGVycyBicmVha3MuXG5cdFx0aWYgKCAvd2Via2l0LipDaHJvbWUuKk1vYmlsZS9pLnRlc3QobmF2aWdhdG9yLnVzZXJBZ2VudCkgKSB7XG5cdFx0XHRwYWdlT2Zmc2V0LnggPSAwO1xuXHRcdH1cblxuXHRcdHJldHVybiBvcmllbnRhdGlvbiA/IChyZWN0LnRvcCArIHBhZ2VPZmZzZXQueSAtIGRvY0VsZW0uY2xpZW50VG9wKSA6IChyZWN0LmxlZnQgKyBwYWdlT2Zmc2V0LnggLSBkb2NFbGVtLmNsaWVudExlZnQpO1xuXHR9XG5cblx0Ly8gQ2hlY2tzIHdoZXRoZXIgYSB2YWx1ZSBpcyBudW1lcmljYWwuXG5cdGZ1bmN0aW9uIGlzTnVtZXJpYyAoIGEgKSB7XG5cdFx0cmV0dXJuIHR5cGVvZiBhID09PSAnbnVtYmVyJyAmJiAhaXNOYU4oIGEgKSAmJiBpc0Zpbml0ZSggYSApO1xuXHR9XG5cblx0Ly8gU2V0cyBhIGNsYXNzIGFuZCByZW1vdmVzIGl0IGFmdGVyIFtkdXJhdGlvbl0gbXMuXG5cdGZ1bmN0aW9uIGFkZENsYXNzRm9yICggZWxlbWVudCwgY2xhc3NOYW1lLCBkdXJhdGlvbiApIHtcblx0XHRpZiAoZHVyYXRpb24gPiAwKSB7XG5cdFx0YWRkQ2xhc3MoZWxlbWVudCwgY2xhc3NOYW1lKTtcblx0XHRcdHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcblx0XHRcdFx0cmVtb3ZlQ2xhc3MoZWxlbWVudCwgY2xhc3NOYW1lKTtcblx0XHRcdH0sIGR1cmF0aW9uKTtcblx0XHR9XG5cdH1cblxuXHQvLyBMaW1pdHMgYSB2YWx1ZSB0byAwIC0gMTAwXG5cdGZ1bmN0aW9uIGxpbWl0ICggYSApIHtcblx0XHRyZXR1cm4gTWF0aC5tYXgoTWF0aC5taW4oYSwgMTAwKSwgMCk7XG5cdH1cblxuXHQvLyBXcmFwcyBhIHZhcmlhYmxlIGFzIGFuIGFycmF5LCBpZiBpdCBpc24ndCBvbmUgeWV0LlxuXHQvLyBOb3RlIHRoYXQgYW4gaW5wdXQgYXJyYXkgaXMgcmV0dXJuZWQgYnkgcmVmZXJlbmNlIVxuXHRmdW5jdGlvbiBhc0FycmF5ICggYSApIHtcblx0XHRyZXR1cm4gQXJyYXkuaXNBcnJheShhKSA/IGEgOiBbYV07XG5cdH1cblxuXHQvLyBDb3VudHMgZGVjaW1hbHNcblx0ZnVuY3Rpb24gY291bnREZWNpbWFscyAoIG51bVN0ciApIHtcblx0XHRudW1TdHIgPSBTdHJpbmcobnVtU3RyKTtcblx0XHR2YXIgcGllY2VzID0gbnVtU3RyLnNwbGl0KFwiLlwiKTtcblx0XHRyZXR1cm4gcGllY2VzLmxlbmd0aCA+IDEgPyBwaWVjZXNbMV0ubGVuZ3RoIDogMDtcblx0fVxuXG5cdC8vIGh0dHA6Ly95b3VtaWdodG5vdG5lZWRqcXVlcnkuY29tLyNhZGRfY2xhc3Ncblx0ZnVuY3Rpb24gYWRkQ2xhc3MgKCBlbCwgY2xhc3NOYW1lICkge1xuXHRcdGlmICggZWwuY2xhc3NMaXN0ICkge1xuXHRcdFx0ZWwuY2xhc3NMaXN0LmFkZChjbGFzc05hbWUpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbC5jbGFzc05hbWUgKz0gJyAnICsgY2xhc3NOYW1lO1xuXHRcdH1cblx0fVxuXG5cdC8vIGh0dHA6Ly95b3VtaWdodG5vdG5lZWRqcXVlcnkuY29tLyNyZW1vdmVfY2xhc3Ncblx0ZnVuY3Rpb24gcmVtb3ZlQ2xhc3MgKCBlbCwgY2xhc3NOYW1lICkge1xuXHRcdGlmICggZWwuY2xhc3NMaXN0ICkge1xuXHRcdFx0ZWwuY2xhc3NMaXN0LnJlbW92ZShjbGFzc05hbWUpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbC5jbGFzc05hbWUgPSBlbC5jbGFzc05hbWUucmVwbGFjZShuZXcgUmVnRXhwKCcoXnxcXFxcYiknICsgY2xhc3NOYW1lLnNwbGl0KCcgJykuam9pbignfCcpICsgJyhcXFxcYnwkKScsICdnaScpLCAnICcpO1xuXHRcdH1cblx0fVxuXG5cdC8vIGh0dHBzOi8vcGxhaW5qcy5jb20vamF2YXNjcmlwdC9hdHRyaWJ1dGVzL2FkZGluZy1yZW1vdmluZy1hbmQtdGVzdGluZy1mb3ItY2xhc3Nlcy05L1xuXHRmdW5jdGlvbiBoYXNDbGFzcyAoIGVsLCBjbGFzc05hbWUgKSB7XG5cdFx0cmV0dXJuIGVsLmNsYXNzTGlzdCA/IGVsLmNsYXNzTGlzdC5jb250YWlucyhjbGFzc05hbWUpIDogbmV3IFJlZ0V4cCgnXFxcXGInICsgY2xhc3NOYW1lICsgJ1xcXFxiJykudGVzdChlbC5jbGFzc05hbWUpO1xuXHR9XG5cblx0Ly8gaHR0cHM6Ly9kZXZlbG9wZXIubW96aWxsYS5vcmcvZW4tVVMvZG9jcy9XZWIvQVBJL1dpbmRvdy9zY3JvbGxZI05vdGVzXG5cdGZ1bmN0aW9uIGdldFBhZ2VPZmZzZXQgKCBkb2MgKSB7XG5cblx0XHR2YXIgc3VwcG9ydFBhZ2VPZmZzZXQgPSB3aW5kb3cucGFnZVhPZmZzZXQgIT09IHVuZGVmaW5lZDtcblx0XHR2YXIgaXNDU1MxQ29tcGF0ID0gKChkb2MuY29tcGF0TW9kZSB8fCBcIlwiKSA9PT0gXCJDU1MxQ29tcGF0XCIpO1xuXHRcdHZhciB4ID0gc3VwcG9ydFBhZ2VPZmZzZXQgPyB3aW5kb3cucGFnZVhPZmZzZXQgOiBpc0NTUzFDb21wYXQgPyBkb2MuZG9jdW1lbnRFbGVtZW50LnNjcm9sbExlZnQgOiBkb2MuYm9keS5zY3JvbGxMZWZ0O1xuXHRcdHZhciB5ID0gc3VwcG9ydFBhZ2VPZmZzZXQgPyB3aW5kb3cucGFnZVlPZmZzZXQgOiBpc0NTUzFDb21wYXQgPyBkb2MuZG9jdW1lbnRFbGVtZW50LnNjcm9sbFRvcCA6IGRvYy5ib2R5LnNjcm9sbFRvcDtcblxuXHRcdHJldHVybiB7XG5cdFx0XHR4OiB4LFxuXHRcdFx0eTogeVxuXHRcdH07XG5cdH1cblxyXG5cdC8vIHdlIHByb3ZpZGUgYSBmdW5jdGlvbiB0byBjb21wdXRlIGNvbnN0YW50cyBpbnN0ZWFkXHJcblx0Ly8gb2YgYWNjZXNzaW5nIHdpbmRvdy4qIGFzIHNvb24gYXMgdGhlIG1vZHVsZSBuZWVkcyBpdFxyXG5cdC8vIHNvIHRoYXQgd2UgZG8gbm90IGNvbXB1dGUgYW55dGhpbmcgaWYgbm90IG5lZWRlZFxyXG5cdGZ1bmN0aW9uIGdldEFjdGlvbnMgKCApIHtcclxuXHJcblx0XHQvLyBEZXRlcm1pbmUgdGhlIGV2ZW50cyB0byBiaW5kLiBJRTExIGltcGxlbWVudHMgcG9pbnRlckV2ZW50cyB3aXRob3V0XHJcblx0XHQvLyBhIHByZWZpeCwgd2hpY2ggYnJlYWtzIGNvbXBhdGliaWxpdHkgd2l0aCB0aGUgSUUxMCBpbXBsZW1lbnRhdGlvbi5cclxuXHRcdHJldHVybiB3aW5kb3cubmF2aWdhdG9yLnBvaW50ZXJFbmFibGVkID8ge1xyXG5cdFx0XHRzdGFydDogJ3BvaW50ZXJkb3duJyxcclxuXHRcdFx0bW92ZTogJ3BvaW50ZXJtb3ZlJyxcclxuXHRcdFx0ZW5kOiAncG9pbnRlcnVwJ1xyXG5cdFx0fSA6IHdpbmRvdy5uYXZpZ2F0b3IubXNQb2ludGVyRW5hYmxlZCA/IHtcclxuXHRcdFx0c3RhcnQ6ICdNU1BvaW50ZXJEb3duJyxcclxuXHRcdFx0bW92ZTogJ01TUG9pbnRlck1vdmUnLFxyXG5cdFx0XHRlbmQ6ICdNU1BvaW50ZXJVcCdcclxuXHRcdH0gOiB7XHJcblx0XHRcdHN0YXJ0OiAnbW91c2Vkb3duIHRvdWNoc3RhcnQnLFxyXG5cdFx0XHRtb3ZlOiAnbW91c2Vtb3ZlIHRvdWNobW92ZScsXHJcblx0XHRcdGVuZDogJ21vdXNldXAgdG91Y2hlbmQnXHJcblx0XHR9O1xyXG5cdH1cclxuXHJcblx0Ly8gaHR0cHM6Ly9naXRodWIuY29tL1dJQ0cvRXZlbnRMaXN0ZW5lck9wdGlvbnMvYmxvYi9naC1wYWdlcy9leHBsYWluZXIubWRcclxuXHQvLyBJc3N1ZSAjNzg1XHJcblx0ZnVuY3Rpb24gZ2V0U3VwcG9ydHNQYXNzaXZlICggKSB7XHJcblxyXG5cdFx0dmFyIHN1cHBvcnRzUGFzc2l2ZSA9IGZhbHNlO1xyXG5cclxuXHRcdHRyeSB7XHJcblxyXG5cdFx0XHR2YXIgb3B0cyA9IE9iamVjdC5kZWZpbmVQcm9wZXJ0eSh7fSwgJ3Bhc3NpdmUnLCB7XHJcblx0XHRcdFx0Z2V0OiBmdW5jdGlvbigpIHtcclxuXHRcdFx0XHRcdHN1cHBvcnRzUGFzc2l2ZSA9IHRydWU7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9KTtcclxuXHJcblx0XHRcdHdpbmRvdy5hZGRFdmVudExpc3RlbmVyKCd0ZXN0JywgbnVsbCwgb3B0cyk7XHJcblxyXG5cdFx0fSBjYXRjaCAoZSkge31cclxuXHJcblx0XHRyZXR1cm4gc3VwcG9ydHNQYXNzaXZlO1xyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gZ2V0U3VwcG9ydHNUb3VjaEFjdGlvbk5vbmUgKCApIHtcclxuXHRcdHJldHVybiB3aW5kb3cuQ1NTICYmIENTUy5zdXBwb3J0cyAmJiBDU1Muc3VwcG9ydHMoJ3RvdWNoLWFjdGlvbicsICdub25lJyk7XHJcblx0fVxyXG5cclxuXHJcbi8vIFZhbHVlIGNhbGN1bGF0aW9uXHJcblxyXG5cdC8vIERldGVybWluZSB0aGUgc2l6ZSBvZiBhIHN1Yi1yYW5nZSBpbiByZWxhdGlvbiB0byBhIGZ1bGwgcmFuZ2UuXHJcblx0ZnVuY3Rpb24gc3ViUmFuZ2VSYXRpbyAoIHBhLCBwYiApIHtcclxuXHRcdHJldHVybiAoMTAwIC8gKHBiIC0gcGEpKTtcclxuXHR9XHJcblxyXG5cdC8vIChwZXJjZW50YWdlKSBIb3cgbWFueSBwZXJjZW50IGlzIHRoaXMgdmFsdWUgb2YgdGhpcyByYW5nZT9cclxuXHRmdW5jdGlvbiBmcm9tUGVyY2VudGFnZSAoIHJhbmdlLCB2YWx1ZSApIHtcclxuXHRcdHJldHVybiAodmFsdWUgKiAxMDApIC8gKCByYW5nZVsxXSAtIHJhbmdlWzBdICk7XHJcblx0fVxyXG5cclxuXHQvLyAocGVyY2VudGFnZSkgV2hlcmUgaXMgdGhpcyB2YWx1ZSBvbiB0aGlzIHJhbmdlP1xyXG5cdGZ1bmN0aW9uIHRvUGVyY2VudGFnZSAoIHJhbmdlLCB2YWx1ZSApIHtcclxuXHRcdHJldHVybiBmcm9tUGVyY2VudGFnZSggcmFuZ2UsIHJhbmdlWzBdIDwgMCA/XHJcblx0XHRcdHZhbHVlICsgTWF0aC5hYnMocmFuZ2VbMF0pIDpcclxuXHRcdFx0XHR2YWx1ZSAtIHJhbmdlWzBdICk7XHJcblx0fVxyXG5cclxuXHQvLyAodmFsdWUpIEhvdyBtdWNoIGlzIHRoaXMgcGVyY2VudGFnZSBvbiB0aGlzIHJhbmdlP1xyXG5cdGZ1bmN0aW9uIGlzUGVyY2VudGFnZSAoIHJhbmdlLCB2YWx1ZSApIHtcclxuXHRcdHJldHVybiAoKHZhbHVlICogKCByYW5nZVsxXSAtIHJhbmdlWzBdICkpIC8gMTAwKSArIHJhbmdlWzBdO1xyXG5cdH1cclxuXHJcblxyXG4vLyBSYW5nZSBjb252ZXJzaW9uXHJcblxyXG5cdGZ1bmN0aW9uIGdldEogKCB2YWx1ZSwgYXJyICkge1xyXG5cclxuXHRcdHZhciBqID0gMTtcclxuXHJcblx0XHR3aGlsZSAoIHZhbHVlID49IGFycltqXSApe1xyXG5cdFx0XHRqICs9IDE7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIGo7XHJcblx0fVxyXG5cclxuXHQvLyAocGVyY2VudGFnZSkgSW5wdXQgYSB2YWx1ZSwgZmluZCB3aGVyZSwgb24gYSBzY2FsZSBvZiAwLTEwMCwgaXQgYXBwbGllcy5cclxuXHRmdW5jdGlvbiB0b1N0ZXBwaW5nICggeFZhbCwgeFBjdCwgdmFsdWUgKSB7XHJcblxyXG5cdFx0aWYgKCB2YWx1ZSA+PSB4VmFsLnNsaWNlKC0xKVswXSApe1xyXG5cdFx0XHRyZXR1cm4gMTAwO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBqID0gZ2V0SiggdmFsdWUsIHhWYWwgKTtcclxuXHRcdHZhciB2YSA9IHhWYWxbai0xXTtcclxuXHRcdHZhciB2YiA9IHhWYWxbal07XHJcblx0XHR2YXIgcGEgPSB4UGN0W2otMV07XHJcblx0XHR2YXIgcGIgPSB4UGN0W2pdO1xyXG5cclxuXHRcdHJldHVybiBwYSArICh0b1BlcmNlbnRhZ2UoW3ZhLCB2Yl0sIHZhbHVlKSAvIHN1YlJhbmdlUmF0aW8gKHBhLCBwYikpO1xyXG5cdH1cclxuXHJcblx0Ly8gKHZhbHVlKSBJbnB1dCBhIHBlcmNlbnRhZ2UsIGZpbmQgd2hlcmUgaXQgaXMgb24gdGhlIHNwZWNpZmllZCByYW5nZS5cclxuXHRmdW5jdGlvbiBmcm9tU3RlcHBpbmcgKCB4VmFsLCB4UGN0LCB2YWx1ZSApIHtcclxuXHJcblx0XHQvLyBUaGVyZSBpcyBubyByYW5nZSBncm91cCB0aGF0IGZpdHMgMTAwXHJcblx0XHRpZiAoIHZhbHVlID49IDEwMCApe1xyXG5cdFx0XHRyZXR1cm4geFZhbC5zbGljZSgtMSlbMF07XHJcblx0XHR9XHJcblxyXG5cdFx0dmFyIGogPSBnZXRKKCB2YWx1ZSwgeFBjdCApO1xyXG5cdFx0dmFyIHZhID0geFZhbFtqLTFdO1xyXG5cdFx0dmFyIHZiID0geFZhbFtqXTtcclxuXHRcdHZhciBwYSA9IHhQY3Rbai0xXTtcclxuXHRcdHZhciBwYiA9IHhQY3Rbal07XHJcblxyXG5cdFx0cmV0dXJuIGlzUGVyY2VudGFnZShbdmEsIHZiXSwgKHZhbHVlIC0gcGEpICogc3ViUmFuZ2VSYXRpbyAocGEsIHBiKSk7XHJcblx0fVxyXG5cclxuXHQvLyAocGVyY2VudGFnZSkgR2V0IHRoZSBzdGVwIHRoYXQgYXBwbGllcyBhdCBhIGNlcnRhaW4gdmFsdWUuXHJcblx0ZnVuY3Rpb24gZ2V0U3RlcCAoIHhQY3QsIHhTdGVwcywgc25hcCwgdmFsdWUgKSB7XHJcblxyXG5cdFx0aWYgKCB2YWx1ZSA9PT0gMTAwICkge1xyXG5cdFx0XHRyZXR1cm4gdmFsdWU7XHJcblx0XHR9XHJcblxyXG5cdFx0dmFyIGogPSBnZXRKKCB2YWx1ZSwgeFBjdCApO1xyXG5cdFx0dmFyIGEgPSB4UGN0W2otMV07XHJcblx0XHR2YXIgYiA9IHhQY3Rbal07XHJcblxyXG5cdFx0Ly8gSWYgJ3NuYXAnIGlzIHNldCwgc3RlcHMgYXJlIHVzZWQgYXMgZml4ZWQgcG9pbnRzIG9uIHRoZSBzbGlkZXIuXHJcblx0XHRpZiAoIHNuYXAgKSB7XHJcblxyXG5cdFx0XHQvLyBGaW5kIHRoZSBjbG9zZXN0IHBvc2l0aW9uLCBhIG9yIGIuXHJcblx0XHRcdGlmICgodmFsdWUgLSBhKSA+ICgoYi1hKS8yKSl7XHJcblx0XHRcdFx0cmV0dXJuIGI7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiBhO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggIXhTdGVwc1tqLTFdICl7XHJcblx0XHRcdHJldHVybiB2YWx1ZTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4geFBjdFtqLTFdICsgY2xvc2VzdChcclxuXHRcdFx0dmFsdWUgLSB4UGN0W2otMV0sXHJcblx0XHRcdHhTdGVwc1tqLTFdXHJcblx0XHQpO1xyXG5cdH1cclxuXHJcblxyXG4vLyBFbnRyeSBwYXJzaW5nXHJcblxyXG5cdGZ1bmN0aW9uIGhhbmRsZUVudHJ5UG9pbnQgKCBpbmRleCwgdmFsdWUsIHRoYXQgKSB7XHJcblxyXG5cdFx0dmFyIHBlcmNlbnRhZ2U7XHJcblxyXG5cdFx0Ly8gV3JhcCBudW1lcmljYWwgaW5wdXQgaW4gYW4gYXJyYXkuXHJcblx0XHRpZiAoIHR5cGVvZiB2YWx1ZSA9PT0gXCJudW1iZXJcIiApIHtcclxuXHRcdFx0dmFsdWUgPSBbdmFsdWVdO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFJlamVjdCBhbnkgaW52YWxpZCBpbnB1dCwgYnkgdGVzdGluZyB3aGV0aGVyIHZhbHVlIGlzIGFuIGFycmF5LlxyXG5cdFx0aWYgKCAhQXJyYXkuaXNBcnJheSh2YWx1ZSkgKXtcclxuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncmFuZ2UnIGNvbnRhaW5zIGludmFsaWQgdmFsdWUuXCIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIENvdmVydCBtaW4vbWF4IHN5bnRheCB0byAwIGFuZCAxMDAuXHJcblx0XHRpZiAoIGluZGV4ID09PSAnbWluJyApIHtcclxuXHRcdFx0cGVyY2VudGFnZSA9IDA7XHJcblx0XHR9IGVsc2UgaWYgKCBpbmRleCA9PT0gJ21heCcgKSB7XHJcblx0XHRcdHBlcmNlbnRhZ2UgPSAxMDA7XHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHRwZXJjZW50YWdlID0gcGFyc2VGbG9hdCggaW5kZXggKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBDaGVjayBmb3IgY29ycmVjdCBpbnB1dC5cclxuXHRcdGlmICggIWlzTnVtZXJpYyggcGVyY2VudGFnZSApIHx8ICFpc051bWVyaWMoIHZhbHVlWzBdICkgKSB7XHJcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3JhbmdlJyB2YWx1ZSBpc24ndCBudW1lcmljLlwiKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBTdG9yZSB2YWx1ZXMuXHJcblx0XHR0aGF0LnhQY3QucHVzaCggcGVyY2VudGFnZSApO1xyXG5cdFx0dGhhdC54VmFsLnB1c2goIHZhbHVlWzBdICk7XHJcblxyXG5cdFx0Ly8gTmFOIHdpbGwgZXZhbHVhdGUgdG8gZmFsc2UgdG9vLCBidXQgdG8ga2VlcFxyXG5cdFx0Ly8gbG9nZ2luZyBjbGVhciwgc2V0IHN0ZXAgZXhwbGljaXRseS4gTWFrZSBzdXJlXHJcblx0XHQvLyBub3QgdG8gb3ZlcnJpZGUgdGhlICdzdGVwJyBzZXR0aW5nIHdpdGggZmFsc2UuXHJcblx0XHRpZiAoICFwZXJjZW50YWdlICkge1xyXG5cdFx0XHRpZiAoICFpc05hTiggdmFsdWVbMV0gKSApIHtcclxuXHRcdFx0XHR0aGF0LnhTdGVwc1swXSA9IHZhbHVlWzFdO1xyXG5cdFx0XHR9XHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHR0aGF0LnhTdGVwcy5wdXNoKCBpc05hTih2YWx1ZVsxXSkgPyBmYWxzZSA6IHZhbHVlWzFdICk7XHJcblx0XHR9XHJcblxyXG5cdFx0dGhhdC54SGlnaGVzdENvbXBsZXRlU3RlcC5wdXNoKDApO1xyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gaGFuZGxlU3RlcFBvaW50ICggaSwgbiwgdGhhdCApIHtcclxuXHJcblx0XHQvLyBJZ25vcmUgJ2ZhbHNlJyBzdGVwcGluZy5cclxuXHRcdGlmICggIW4gKSB7XHJcblx0XHRcdHJldHVybiB0cnVlO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEZhY3RvciB0byByYW5nZSByYXRpb1xyXG5cdFx0dGhhdC54U3RlcHNbaV0gPSBmcm9tUGVyY2VudGFnZShbdGhhdC54VmFsW2ldLCB0aGF0LnhWYWxbaSsxXV0sIG4pIC8gc3ViUmFuZ2VSYXRpbyh0aGF0LnhQY3RbaV0sIHRoYXQueFBjdFtpKzFdKTtcclxuXHJcblx0XHR2YXIgdG90YWxTdGVwcyA9ICh0aGF0LnhWYWxbaSsxXSAtIHRoYXQueFZhbFtpXSkgLyB0aGF0LnhOdW1TdGVwc1tpXTtcclxuXHRcdHZhciBoaWdoZXN0U3RlcCA9IE1hdGguY2VpbChOdW1iZXIodG90YWxTdGVwcy50b0ZpeGVkKDMpKSAtIDEpO1xyXG5cdFx0dmFyIHN0ZXAgPSB0aGF0LnhWYWxbaV0gKyAodGhhdC54TnVtU3RlcHNbaV0gKiBoaWdoZXN0U3RlcCk7XHJcblxyXG5cdFx0dGhhdC54SGlnaGVzdENvbXBsZXRlU3RlcFtpXSA9IHN0ZXA7XHJcblx0fVxyXG5cclxuXHJcbi8vIEludGVyZmFjZVxyXG5cclxuXHRmdW5jdGlvbiBTcGVjdHJ1bSAoIGVudHJ5LCBzbmFwLCBzaW5nbGVTdGVwICkge1xyXG5cclxuXHRcdHRoaXMueFBjdCA9IFtdO1xyXG5cdFx0dGhpcy54VmFsID0gW107XHJcblx0XHR0aGlzLnhTdGVwcyA9IFsgc2luZ2xlU3RlcCB8fCBmYWxzZSBdO1xyXG5cdFx0dGhpcy54TnVtU3RlcHMgPSBbIGZhbHNlIF07XHJcblx0XHR0aGlzLnhIaWdoZXN0Q29tcGxldGVTdGVwID0gW107XHJcblxyXG5cdFx0dGhpcy5zbmFwID0gc25hcDtcclxuXHJcblx0XHR2YXIgaW5kZXg7XHJcblx0XHR2YXIgb3JkZXJlZCA9IFtdOyAvLyBbMCwgJ21pbiddLCBbMSwgJzUwJSddLCBbMiwgJ21heCddXHJcblxyXG5cdFx0Ly8gTWFwIHRoZSBvYmplY3Qga2V5cyB0byBhbiBhcnJheS5cclxuXHRcdGZvciAoIGluZGV4IGluIGVudHJ5ICkge1xyXG5cdFx0XHRpZiAoIGVudHJ5Lmhhc093blByb3BlcnR5KGluZGV4KSApIHtcclxuXHRcdFx0XHRvcmRlcmVkLnB1c2goW2VudHJ5W2luZGV4XSwgaW5kZXhdKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFNvcnQgYWxsIGVudHJpZXMgYnkgdmFsdWUgKG51bWVyaWMgc29ydCkuXHJcblx0XHRpZiAoIG9yZGVyZWQubGVuZ3RoICYmIHR5cGVvZiBvcmRlcmVkWzBdWzBdID09PSBcIm9iamVjdFwiICkge1xyXG5cdFx0XHRvcmRlcmVkLnNvcnQoZnVuY3Rpb24oYSwgYikgeyByZXR1cm4gYVswXVswXSAtIGJbMF1bMF07IH0pO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0b3JkZXJlZC5zb3J0KGZ1bmN0aW9uKGEsIGIpIHsgcmV0dXJuIGFbMF0gLSBiWzBdOyB9KTtcclxuXHRcdH1cclxuXHJcblxyXG5cdFx0Ly8gQ29udmVydCBhbGwgZW50cmllcyB0byBzdWJyYW5nZXMuXHJcblx0XHRmb3IgKCBpbmRleCA9IDA7IGluZGV4IDwgb3JkZXJlZC5sZW5ndGg7IGluZGV4KysgKSB7XHJcblx0XHRcdGhhbmRsZUVudHJ5UG9pbnQob3JkZXJlZFtpbmRleF1bMV0sIG9yZGVyZWRbaW5kZXhdWzBdLCB0aGlzKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBTdG9yZSB0aGUgYWN0dWFsIHN0ZXAgdmFsdWVzLlxyXG5cdFx0Ly8geFN0ZXBzIGlzIHNvcnRlZCBpbiB0aGUgc2FtZSBvcmRlciBhcyB4UGN0IGFuZCB4VmFsLlxyXG5cdFx0dGhpcy54TnVtU3RlcHMgPSB0aGlzLnhTdGVwcy5zbGljZSgwKTtcclxuXHJcblx0XHQvLyBDb252ZXJ0IGFsbCBudW1lcmljIHN0ZXBzIHRvIHRoZSBwZXJjZW50YWdlIG9mIHRoZSBzdWJyYW5nZSB0aGV5IHJlcHJlc2VudC5cclxuXHRcdGZvciAoIGluZGV4ID0gMDsgaW5kZXggPCB0aGlzLnhOdW1TdGVwcy5sZW5ndGg7IGluZGV4KysgKSB7XHJcblx0XHRcdGhhbmRsZVN0ZXBQb2ludChpbmRleCwgdGhpcy54TnVtU3RlcHNbaW5kZXhdLCB0aGlzKTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdFNwZWN0cnVtLnByb3RvdHlwZS5nZXRNYXJnaW4gPSBmdW5jdGlvbiAoIHZhbHVlICkge1xyXG5cclxuXHRcdHZhciBzdGVwID0gdGhpcy54TnVtU3RlcHNbMF07XHJcblxyXG5cdFx0aWYgKCBzdGVwICYmICgodmFsdWUgLyBzdGVwKSAlIDEpICE9PSAwICkge1xyXG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdsaW1pdCcsICdtYXJnaW4nIGFuZCAncGFkZGluZycgbXVzdCBiZSBkaXZpc2libGUgYnkgc3RlcC5cIik7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHRoaXMueFBjdC5sZW5ndGggPT09IDIgPyBmcm9tUGVyY2VudGFnZSh0aGlzLnhWYWwsIHZhbHVlKSA6IGZhbHNlO1xyXG5cdH07XHJcblxyXG5cdFNwZWN0cnVtLnByb3RvdHlwZS50b1N0ZXBwaW5nID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHJcblx0XHR2YWx1ZSA9IHRvU3RlcHBpbmcoIHRoaXMueFZhbCwgdGhpcy54UGN0LCB2YWx1ZSApO1xyXG5cclxuXHRcdHJldHVybiB2YWx1ZTtcclxuXHR9O1xyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUuZnJvbVN0ZXBwaW5nID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHJcblx0XHRyZXR1cm4gZnJvbVN0ZXBwaW5nKCB0aGlzLnhWYWwsIHRoaXMueFBjdCwgdmFsdWUgKTtcclxuXHR9O1xyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUuZ2V0U3RlcCA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0dmFsdWUgPSBnZXRTdGVwKHRoaXMueFBjdCwgdGhpcy54U3RlcHMsIHRoaXMuc25hcCwgdmFsdWUgKTtcclxuXHJcblx0XHRyZXR1cm4gdmFsdWU7XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmdldE5lYXJieVN0ZXBzID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHJcblx0XHR2YXIgaiA9IGdldEoodmFsdWUsIHRoaXMueFBjdCk7XHJcblxyXG5cdFx0cmV0dXJuIHtcclxuXHRcdFx0c3RlcEJlZm9yZTogeyBzdGFydFZhbHVlOiB0aGlzLnhWYWxbai0yXSwgc3RlcDogdGhpcy54TnVtU3RlcHNbai0yXSwgaGlnaGVzdFN0ZXA6IHRoaXMueEhpZ2hlc3RDb21wbGV0ZVN0ZXBbai0yXSB9LFxyXG5cdFx0XHR0aGlzU3RlcDogeyBzdGFydFZhbHVlOiB0aGlzLnhWYWxbai0xXSwgc3RlcDogdGhpcy54TnVtU3RlcHNbai0xXSwgaGlnaGVzdFN0ZXA6IHRoaXMueEhpZ2hlc3RDb21wbGV0ZVN0ZXBbai0xXSB9LFxyXG5cdFx0XHRzdGVwQWZ0ZXI6IHsgc3RhcnRWYWx1ZTogdGhpcy54VmFsW2otMF0sIHN0ZXA6IHRoaXMueE51bVN0ZXBzW2otMF0sIGhpZ2hlc3RTdGVwOiB0aGlzLnhIaWdoZXN0Q29tcGxldGVTdGVwW2otMF0gfVxyXG5cdFx0fTtcclxuXHR9O1xyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUuY291bnRTdGVwRGVjaW1hbHMgPSBmdW5jdGlvbiAoKSB7XHJcblx0XHR2YXIgc3RlcERlY2ltYWxzID0gdGhpcy54TnVtU3RlcHMubWFwKGNvdW50RGVjaW1hbHMpO1xyXG5cdFx0cmV0dXJuIE1hdGgubWF4LmFwcGx5KG51bGwsIHN0ZXBEZWNpbWFscyk7XHJcblx0fTtcclxuXHJcblx0Ly8gT3V0c2lkZSB0ZXN0aW5nXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmNvbnZlcnQgPSBmdW5jdGlvbiAoIHZhbHVlICkge1xyXG5cdFx0cmV0dXJuIHRoaXMuZ2V0U3RlcCh0aGlzLnRvU3RlcHBpbmcodmFsdWUpKTtcclxuXHR9O1xyXG5cclxuLypcdEV2ZXJ5IGlucHV0IG9wdGlvbiBpcyB0ZXN0ZWQgYW5kIHBhcnNlZC4gVGhpcydsbCBwcmV2ZW50XG5cdGVuZGxlc3MgdmFsaWRhdGlvbiBpbiBpbnRlcm5hbCBtZXRob2RzLiBUaGVzZSB0ZXN0cyBhcmVcblx0c3RydWN0dXJlZCB3aXRoIGFuIGl0ZW0gZm9yIGV2ZXJ5IG9wdGlvbiBhdmFpbGFibGUuIEFuXG5cdG9wdGlvbiBjYW4gYmUgbWFya2VkIGFzIHJlcXVpcmVkIGJ5IHNldHRpbmcgdGhlICdyJyBmbGFnLlxuXHRUaGUgdGVzdGluZyBmdW5jdGlvbiBpcyBwcm92aWRlZCB3aXRoIHRocmVlIGFyZ3VtZW50czpcblx0XHQtIFRoZSBwcm92aWRlZCB2YWx1ZSBmb3IgdGhlIG9wdGlvbjtcblx0XHQtIEEgcmVmZXJlbmNlIHRvIHRoZSBvcHRpb25zIG9iamVjdDtcblx0XHQtIFRoZSBuYW1lIGZvciB0aGUgb3B0aW9uO1xuXG5cdFRoZSB0ZXN0aW5nIGZ1bmN0aW9uIHJldHVybnMgZmFsc2Ugd2hlbiBhbiBlcnJvciBpcyBkZXRlY3RlZCxcblx0b3IgdHJ1ZSB3aGVuIGV2ZXJ5dGhpbmcgaXMgT0suIEl0IGNhbiBhbHNvIG1vZGlmeSB0aGUgb3B0aW9uXG5cdG9iamVjdCwgdG8gbWFrZSBzdXJlIGFsbCB2YWx1ZXMgY2FuIGJlIGNvcnJlY3RseSBsb29wZWQgZWxzZXdoZXJlLiAqL1xuXG5cdHZhciBkZWZhdWx0Rm9ybWF0dGVyID0geyAndG8nOiBmdW5jdGlvbiggdmFsdWUgKXtcblx0XHRyZXR1cm4gdmFsdWUgIT09IHVuZGVmaW5lZCAmJiB2YWx1ZS50b0ZpeGVkKDIpO1xuXHR9LCAnZnJvbSc6IE51bWJlciB9O1xuXG5cdGZ1bmN0aW9uIHZhbGlkYXRlRm9ybWF0ICggZW50cnkgKSB7XG5cblx0XHQvLyBBbnkgb2JqZWN0IHdpdGggYSB0byBhbmQgZnJvbSBtZXRob2QgaXMgc3VwcG9ydGVkLlxuXHRcdGlmICggaXNWYWxpZEZvcm1hdHRlcihlbnRyeSkgKSB7XG5cdFx0XHRyZXR1cm4gdHJ1ZTtcblx0XHR9XG5cblx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdmb3JtYXQnIHJlcXVpcmVzICd0bycgYW5kICdmcm9tJyBtZXRob2RzLlwiKTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RTdGVwICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGlmICggIWlzTnVtZXJpYyggZW50cnkgKSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3N0ZXAnIGlzIG5vdCBudW1lcmljLlwiKTtcblx0XHR9XG5cblx0XHQvLyBUaGUgc3RlcCBvcHRpb24gY2FuIHN0aWxsIGJlIHVzZWQgdG8gc2V0IHN0ZXBwaW5nXG5cdFx0Ly8gZm9yIGxpbmVhciBzbGlkZXJzLiBPdmVyd3JpdHRlbiBpZiBzZXQgaW4gJ3JhbmdlJy5cblx0XHRwYXJzZWQuc2luZ2xlU3RlcCA9IGVudHJ5O1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdFJhbmdlICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdC8vIEZpbHRlciBpbmNvcnJlY3QgaW5wdXQuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdvYmplY3QnIHx8IEFycmF5LmlzQXJyYXkoZW50cnkpICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncmFuZ2UnIGlzIG5vdCBhbiBvYmplY3QuXCIpO1xuXHRcdH1cblxuXHRcdC8vIENhdGNoIG1pc3Npbmcgc3RhcnQgb3IgZW5kLlxuXHRcdGlmICggZW50cnkubWluID09PSB1bmRlZmluZWQgfHwgZW50cnkubWF4ID09PSB1bmRlZmluZWQgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6IE1pc3NpbmcgJ21pbicgb3IgJ21heCcgaW4gJ3JhbmdlJy5cIik7XG5cdFx0fVxuXG5cdFx0Ly8gQ2F0Y2ggZXF1YWwgc3RhcnQgb3IgZW5kLlxuXHRcdGlmICggZW50cnkubWluID09PSBlbnRyeS5tYXggKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdyYW5nZScgJ21pbicgYW5kICdtYXgnIGNhbm5vdCBiZSBlcXVhbC5cIik7XG5cdFx0fVxuXG5cdFx0cGFyc2VkLnNwZWN0cnVtID0gbmV3IFNwZWN0cnVtKGVudHJ5LCBwYXJzZWQuc25hcCwgcGFyc2VkLnNpbmdsZVN0ZXApO1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdFN0YXJ0ICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGVudHJ5ID0gYXNBcnJheShlbnRyeSk7XG5cblx0XHQvLyBWYWxpZGF0ZSBpbnB1dC4gVmFsdWVzIGFyZW4ndCB0ZXN0ZWQsIGFzIHRoZSBwdWJsaWMgLnZhbCBtZXRob2Rcblx0XHQvLyB3aWxsIGFsd2F5cyBwcm92aWRlIGEgdmFsaWQgbG9jYXRpb24uXG5cdFx0aWYgKCAhQXJyYXkuaXNBcnJheSggZW50cnkgKSB8fCAhZW50cnkubGVuZ3RoICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnc3RhcnQnIG9wdGlvbiBpcyBpbmNvcnJlY3QuXCIpO1xuXHRcdH1cblxuXHRcdC8vIFN0b3JlIHRoZSBudW1iZXIgb2YgaGFuZGxlcy5cblx0XHRwYXJzZWQuaGFuZGxlcyA9IGVudHJ5Lmxlbmd0aDtcblxuXHRcdC8vIFdoZW4gdGhlIHNsaWRlciBpcyBpbml0aWFsaXplZCwgdGhlIC52YWwgbWV0aG9kIHdpbGxcblx0XHQvLyBiZSBjYWxsZWQgd2l0aCB0aGUgc3RhcnQgb3B0aW9ucy5cblx0XHRwYXJzZWQuc3RhcnQgPSBlbnRyeTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RTbmFwICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdC8vIEVuZm9yY2UgMTAwJSBzdGVwcGluZyB3aXRoaW4gc3VicmFuZ2VzLlxuXHRcdHBhcnNlZC5zbmFwID0gZW50cnk7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ2Jvb2xlYW4nICl7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdzbmFwJyBvcHRpb24gbXVzdCBiZSBhIGJvb2xlYW4uXCIpO1xuXHRcdH1cblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RBbmltYXRlICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdC8vIEVuZm9yY2UgMTAwJSBzdGVwcGluZyB3aXRoaW4gc3VicmFuZ2VzLlxuXHRcdHBhcnNlZC5hbmltYXRlID0gZW50cnk7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ2Jvb2xlYW4nICl7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdhbmltYXRlJyBvcHRpb24gbXVzdCBiZSBhIGJvb2xlYW4uXCIpO1xuXHRcdH1cblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RBbmltYXRpb25EdXJhdGlvbiAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRwYXJzZWQuYW5pbWF0aW9uRHVyYXRpb24gPSBlbnRyeTtcblxuXHRcdGlmICggdHlwZW9mIGVudHJ5ICE9PSAnbnVtYmVyJyApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnYW5pbWF0aW9uRHVyYXRpb24nIG9wdGlvbiBtdXN0IGJlIGEgbnVtYmVyLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0Q29ubmVjdCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHR2YXIgY29ubmVjdCA9IFtmYWxzZV07XG5cdFx0dmFyIGk7XG5cblx0XHQvLyBNYXAgbGVnYWN5IG9wdGlvbnNcblx0XHRpZiAoIGVudHJ5ID09PSAnbG93ZXInICkge1xuXHRcdFx0ZW50cnkgPSBbdHJ1ZSwgZmFsc2VdO1xuXHRcdH1cblxuXHRcdGVsc2UgaWYgKCBlbnRyeSA9PT0gJ3VwcGVyJyApIHtcblx0XHRcdGVudHJ5ID0gW2ZhbHNlLCB0cnVlXTtcblx0XHR9XG5cblx0XHQvLyBIYW5kbGUgYm9vbGVhbiBvcHRpb25zXG5cdFx0aWYgKCBlbnRyeSA9PT0gdHJ1ZSB8fCBlbnRyeSA9PT0gZmFsc2UgKSB7XG5cblx0XHRcdGZvciAoIGkgPSAxOyBpIDwgcGFyc2VkLmhhbmRsZXM7IGkrKyApIHtcblx0XHRcdFx0Y29ubmVjdC5wdXNoKGVudHJ5KTtcblx0XHRcdH1cblxuXHRcdFx0Y29ubmVjdC5wdXNoKGZhbHNlKTtcblx0XHR9XG5cblx0XHQvLyBSZWplY3QgaW52YWxpZCBpbnB1dFxuXHRcdGVsc2UgaWYgKCAhQXJyYXkuaXNBcnJheSggZW50cnkgKSB8fCAhZW50cnkubGVuZ3RoIHx8IGVudHJ5Lmxlbmd0aCAhPT0gcGFyc2VkLmhhbmRsZXMgKyAxICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnY29ubmVjdCcgb3B0aW9uIGRvZXNuJ3QgbWF0Y2ggaGFuZGxlIGNvdW50LlwiKTtcblx0XHR9XG5cblx0XHRlbHNlIHtcblx0XHRcdGNvbm5lY3QgPSBlbnRyeTtcblx0XHR9XG5cblx0XHRwYXJzZWQuY29ubmVjdCA9IGNvbm5lY3Q7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0T3JpZW50YXRpb24gKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0Ly8gU2V0IG9yaWVudGF0aW9uIHRvIGFuIGEgbnVtZXJpY2FsIHZhbHVlIGZvciBlYXN5XG5cdFx0Ly8gYXJyYXkgc2VsZWN0aW9uLlxuXHRcdHN3aXRjaCAoIGVudHJ5ICl7XG5cdFx0XHRjYXNlICdob3Jpem9udGFsJzpcblx0XHRcdFx0cGFyc2VkLm9ydCA9IDA7XG5cdFx0XHRcdGJyZWFrO1xuXHRcdFx0Y2FzZSAndmVydGljYWwnOlxuXHRcdFx0XHRwYXJzZWQub3J0ID0gMTtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHRkZWZhdWx0OlxuXHRcdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdvcmllbnRhdGlvbicgb3B0aW9uIGlzIGludmFsaWQuXCIpO1xuXHRcdH1cblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RNYXJnaW4gKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCAhaXNOdW1lcmljKGVudHJ5KSApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbWFyZ2luJyBvcHRpb24gbXVzdCBiZSBudW1lcmljLlwiKTtcblx0XHR9XG5cblx0XHQvLyBJc3N1ZSAjNTgyXG5cdFx0aWYgKCBlbnRyeSA9PT0gMCApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHRwYXJzZWQubWFyZ2luID0gcGFyc2VkLnNwZWN0cnVtLmdldE1hcmdpbihlbnRyeSk7XG5cblx0XHRpZiAoICFwYXJzZWQubWFyZ2luICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbWFyZ2luJyBvcHRpb24gaXMgb25seSBzdXBwb3J0ZWQgb24gbGluZWFyIHNsaWRlcnMuXCIpO1xuXHRcdH1cblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RMaW1pdCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoICFpc051bWVyaWMoZW50cnkpICl7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdsaW1pdCcgb3B0aW9uIG11c3QgYmUgbnVtZXJpYy5cIik7XG5cdFx0fVxuXG5cdFx0cGFyc2VkLmxpbWl0ID0gcGFyc2VkLnNwZWN0cnVtLmdldE1hcmdpbihlbnRyeSk7XG5cblx0XHRpZiAoICFwYXJzZWQubGltaXQgfHwgcGFyc2VkLmhhbmRsZXMgPCAyICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbGltaXQnIG9wdGlvbiBpcyBvbmx5IHN1cHBvcnRlZCBvbiBsaW5lYXIgc2xpZGVycyB3aXRoIDIgb3IgbW9yZSBoYW5kbGVzLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0UGFkZGluZyAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoICFpc051bWVyaWMoZW50cnkpICYmICFBcnJheS5pc0FycmF5KGVudHJ5KSApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncGFkZGluZycgb3B0aW9uIG11c3QgYmUgbnVtZXJpYyBvciBhcnJheSBvZiBleGFjdGx5IDIgbnVtYmVycy5cIik7XG5cdFx0fVxuXG5cdFx0aWYgKCBBcnJheS5pc0FycmF5KGVudHJ5KSAmJiAhKGVudHJ5Lmxlbmd0aCA9PT0gMiB8fCBpc051bWVyaWMoZW50cnlbMF0pIHx8IGlzTnVtZXJpYyhlbnRyeVsxXSkpICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncGFkZGluZycgb3B0aW9uIG11c3QgYmUgbnVtZXJpYyBvciBhcnJheSBvZiBleGFjdGx5IDIgbnVtYmVycy5cIik7XG5cdFx0fVxuXG5cdFx0aWYgKCBlbnRyeSA9PT0gMCApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHRpZiAoICFBcnJheS5pc0FycmF5KGVudHJ5KSApIHtcblx0XHRcdGVudHJ5ID0gW2VudHJ5LCBlbnRyeV07XG5cdFx0fVxuXG5cdFx0Ly8gJ2dldE1hcmdpbicgcmV0dXJucyBmYWxzZSBmb3IgaW52YWxpZCB2YWx1ZXMuXG5cdFx0cGFyc2VkLnBhZGRpbmcgPSBbcGFyc2VkLnNwZWN0cnVtLmdldE1hcmdpbihlbnRyeVswXSksIHBhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnlbMV0pXTtcblxuXHRcdGlmICggcGFyc2VkLnBhZGRpbmdbMF0gPT09IGZhbHNlIHx8IHBhcnNlZC5wYWRkaW5nWzFdID09PSBmYWxzZSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBpcyBvbmx5IHN1cHBvcnRlZCBvbiBsaW5lYXIgc2xpZGVycy5cIik7XG5cdFx0fVxuXG5cdFx0aWYgKCBwYXJzZWQucGFkZGluZ1swXSA8IDAgfHwgcGFyc2VkLnBhZGRpbmdbMV0gPCAwICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncGFkZGluZycgb3B0aW9uIG11c3QgYmUgYSBwb3NpdGl2ZSBudW1iZXIocykuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggcGFyc2VkLnBhZGRpbmdbMF0gKyBwYXJzZWQucGFkZGluZ1sxXSA+PSAxMDAgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdwYWRkaW5nJyBvcHRpb24gbXVzdCBub3QgZXhjZWVkIDEwMCUgb2YgdGhlIHJhbmdlLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0RGlyZWN0aW9uICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdC8vIFNldCBkaXJlY3Rpb24gYXMgYSBudW1lcmljYWwgdmFsdWUgZm9yIGVhc3kgcGFyc2luZy5cblx0XHQvLyBJbnZlcnQgY29ubmVjdGlvbiBmb3IgUlRMIHNsaWRlcnMsIHNvIHRoYXQgdGhlIHByb3BlclxuXHRcdC8vIGhhbmRsZXMgZ2V0IHRoZSBjb25uZWN0L2JhY2tncm91bmQgY2xhc3Nlcy5cblx0XHRzd2l0Y2ggKCBlbnRyeSApIHtcblx0XHRcdGNhc2UgJ2x0cic6XG5cdFx0XHRcdHBhcnNlZC5kaXIgPSAwO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdGNhc2UgJ3J0bCc6XG5cdFx0XHRcdHBhcnNlZC5kaXIgPSAxO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdGRlZmF1bHQ6XG5cdFx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2RpcmVjdGlvbicgb3B0aW9uIHdhcyBub3QgcmVjb2duaXplZC5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdEJlaGF2aW91ciAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBNYWtlIHN1cmUgdGhlIGlucHV0IGlzIGEgc3RyaW5nLlxuXHRcdGlmICggdHlwZW9mIGVudHJ5ICE9PSAnc3RyaW5nJyApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2JlaGF2aW91cicgbXVzdCBiZSBhIHN0cmluZyBjb250YWluaW5nIG9wdGlvbnMuXCIpO1xuXHRcdH1cblxuXHRcdC8vIENoZWNrIGlmIHRoZSBzdHJpbmcgY29udGFpbnMgYW55IGtleXdvcmRzLlxuXHRcdC8vIE5vbmUgYXJlIHJlcXVpcmVkLlxuXHRcdHZhciB0YXAgPSBlbnRyeS5pbmRleE9mKCd0YXAnKSA+PSAwO1xuXHRcdHZhciBkcmFnID0gZW50cnkuaW5kZXhPZignZHJhZycpID49IDA7XG5cdFx0dmFyIGZpeGVkID0gZW50cnkuaW5kZXhPZignZml4ZWQnKSA+PSAwO1xuXHRcdHZhciBzbmFwID0gZW50cnkuaW5kZXhPZignc25hcCcpID49IDA7XG5cdFx0dmFyIGhvdmVyID0gZW50cnkuaW5kZXhPZignaG92ZXInKSA+PSAwO1xuXG5cdFx0aWYgKCBmaXhlZCApIHtcblxuXHRcdFx0aWYgKCBwYXJzZWQuaGFuZGxlcyAhPT0gMiApIHtcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnZml4ZWQnIGJlaGF2aW91ciBtdXN0IGJlIHVzZWQgd2l0aCAyIGhhbmRsZXNcIik7XG5cdFx0XHR9XG5cblx0XHRcdC8vIFVzZSBtYXJnaW4gdG8gZW5mb3JjZSBmaXhlZCBzdGF0ZVxuXHRcdFx0dGVzdE1hcmdpbihwYXJzZWQsIHBhcnNlZC5zdGFydFsxXSAtIHBhcnNlZC5zdGFydFswXSk7XG5cdFx0fVxuXG5cdFx0cGFyc2VkLmV2ZW50cyA9IHtcblx0XHRcdHRhcDogdGFwIHx8IHNuYXAsXG5cdFx0XHRkcmFnOiBkcmFnLFxuXHRcdFx0Zml4ZWQ6IGZpeGVkLFxuXHRcdFx0c25hcDogc25hcCxcblx0XHRcdGhvdmVyOiBob3ZlclxuXHRcdH07XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0VG9vbHRpcHMgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCBlbnRyeSA9PT0gZmFsc2UgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0ZWxzZSBpZiAoIGVudHJ5ID09PSB0cnVlICkge1xuXG5cdFx0XHRwYXJzZWQudG9vbHRpcHMgPSBbXTtcblxuXHRcdFx0Zm9yICggdmFyIGkgPSAwOyBpIDwgcGFyc2VkLmhhbmRsZXM7IGkrKyApIHtcblx0XHRcdFx0cGFyc2VkLnRvb2x0aXBzLnB1c2godHJ1ZSk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0ZWxzZSB7XG5cblx0XHRcdHBhcnNlZC50b29sdGlwcyA9IGFzQXJyYXkoZW50cnkpO1xuXG5cdFx0XHRpZiAoIHBhcnNlZC50b29sdGlwcy5sZW5ndGggIT09IHBhcnNlZC5oYW5kbGVzICkge1xuXHRcdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6IG11c3QgcGFzcyBhIGZvcm1hdHRlciBmb3IgYWxsIGhhbmRsZXMuXCIpO1xuXHRcdFx0fVxuXG5cdFx0XHRwYXJzZWQudG9vbHRpcHMuZm9yRWFjaChmdW5jdGlvbihmb3JtYXR0ZXIpe1xuXHRcdFx0XHRpZiAoIHR5cGVvZiBmb3JtYXR0ZXIgIT09ICdib29sZWFuJyAmJiAodHlwZW9mIGZvcm1hdHRlciAhPT0gJ29iamVjdCcgfHwgdHlwZW9mIGZvcm1hdHRlci50byAhPT0gJ2Z1bmN0aW9uJykgKSB7XG5cdFx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAndG9vbHRpcHMnIG11c3QgYmUgcGFzc2VkIGEgZm9ybWF0dGVyIG9yICdmYWxzZScuXCIpO1xuXHRcdFx0XHR9XG5cdFx0XHR9KTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0QXJpYUZvcm1hdCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cdFx0cGFyc2VkLmFyaWFGb3JtYXQgPSBlbnRyeTtcblx0XHR2YWxpZGF0ZUZvcm1hdChlbnRyeSk7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0Rm9ybWF0ICggcGFyc2VkLCBlbnRyeSApIHtcblx0XHRwYXJzZWQuZm9ybWF0ID0gZW50cnk7XG5cdFx0dmFsaWRhdGVGb3JtYXQoZW50cnkpO1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdENzc1ByZWZpeCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ3N0cmluZycgJiYgZW50cnkgIT09IGZhbHNlICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnY3NzUHJlZml4JyBtdXN0IGJlIGEgc3RyaW5nIG9yIGBmYWxzZWAuXCIpO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5jc3NQcmVmaXggPSBlbnRyeTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RDc3NDbGFzc2VzICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGlmICggdHlwZW9mIGVudHJ5ICE9PSAnb2JqZWN0JyApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2Nzc0NsYXNzZXMnIG11c3QgYmUgYW4gb2JqZWN0LlwiKTtcblx0XHR9XG5cblx0XHRpZiAoIHR5cGVvZiBwYXJzZWQuY3NzUHJlZml4ID09PSAnc3RyaW5nJyApIHtcblx0XHRcdHBhcnNlZC5jc3NDbGFzc2VzID0ge307XG5cblx0XHRcdGZvciAoIHZhciBrZXkgaW4gZW50cnkgKSB7XG5cdFx0XHRcdGlmICggIWVudHJ5Lmhhc093blByb3BlcnR5KGtleSkgKSB7IGNvbnRpbnVlOyB9XG5cblx0XHRcdFx0cGFyc2VkLmNzc0NsYXNzZXNba2V5XSA9IHBhcnNlZC5jc3NQcmVmaXggKyBlbnRyeVtrZXldO1xuXHRcdFx0fVxuXHRcdH0gZWxzZSB7XG5cdFx0XHRwYXJzZWQuY3NzQ2xhc3NlcyA9IGVudHJ5O1xuXHRcdH1cblx0fVxuXG5cdC8vIFRlc3QgYWxsIGRldmVsb3BlciBzZXR0aW5ncyBhbmQgcGFyc2UgdG8gYXNzdW1wdGlvbi1zYWZlIHZhbHVlcy5cblx0ZnVuY3Rpb24gdGVzdE9wdGlvbnMgKCBvcHRpb25zICkge1xuXG5cdFx0Ly8gVG8gcHJvdmUgYSBmaXggZm9yICM1MzcsIGZyZWV6ZSBvcHRpb25zIGhlcmUuXG5cdFx0Ly8gSWYgdGhlIG9iamVjdCBpcyBtb2RpZmllZCwgYW4gZXJyb3Igd2lsbCBiZSB0aHJvd24uXG5cdFx0Ly8gT2JqZWN0LmZyZWV6ZShvcHRpb25zKTtcblxuXHRcdHZhciBwYXJzZWQgPSB7XG5cdFx0XHRtYXJnaW46IDAsXG5cdFx0XHRsaW1pdDogMCxcblx0XHRcdHBhZGRpbmc6IDAsXG5cdFx0XHRhbmltYXRlOiB0cnVlLFxuXHRcdFx0YW5pbWF0aW9uRHVyYXRpb246IDMwMCxcblx0XHRcdGFyaWFGb3JtYXQ6IGRlZmF1bHRGb3JtYXR0ZXIsXG5cdFx0XHRmb3JtYXQ6IGRlZmF1bHRGb3JtYXR0ZXJcblx0XHR9O1xuXG5cdFx0Ly8gVGVzdHMgYXJlIGV4ZWN1dGVkIGluIHRoZSBvcmRlciB0aGV5IGFyZSBwcmVzZW50ZWQgaGVyZS5cblx0XHR2YXIgdGVzdHMgPSB7XG5cdFx0XHQnc3RlcCc6IHsgcjogZmFsc2UsIHQ6IHRlc3RTdGVwIH0sXG5cdFx0XHQnc3RhcnQnOiB7IHI6IHRydWUsIHQ6IHRlc3RTdGFydCB9LFxuXHRcdFx0J2Nvbm5lY3QnOiB7IHI6IHRydWUsIHQ6IHRlc3RDb25uZWN0IH0sXG5cdFx0XHQnZGlyZWN0aW9uJzogeyByOiB0cnVlLCB0OiB0ZXN0RGlyZWN0aW9uIH0sXG5cdFx0XHQnc25hcCc6IHsgcjogZmFsc2UsIHQ6IHRlc3RTbmFwIH0sXG5cdFx0XHQnYW5pbWF0ZSc6IHsgcjogZmFsc2UsIHQ6IHRlc3RBbmltYXRlIH0sXG5cdFx0XHQnYW5pbWF0aW9uRHVyYXRpb24nOiB7IHI6IGZhbHNlLCB0OiB0ZXN0QW5pbWF0aW9uRHVyYXRpb24gfSxcblx0XHRcdCdyYW5nZSc6IHsgcjogdHJ1ZSwgdDogdGVzdFJhbmdlIH0sXG5cdFx0XHQnb3JpZW50YXRpb24nOiB7IHI6IGZhbHNlLCB0OiB0ZXN0T3JpZW50YXRpb24gfSxcblx0XHRcdCdtYXJnaW4nOiB7IHI6IGZhbHNlLCB0OiB0ZXN0TWFyZ2luIH0sXG5cdFx0XHQnbGltaXQnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0TGltaXQgfSxcblx0XHRcdCdwYWRkaW5nJzogeyByOiBmYWxzZSwgdDogdGVzdFBhZGRpbmcgfSxcblx0XHRcdCdiZWhhdmlvdXInOiB7IHI6IHRydWUsIHQ6IHRlc3RCZWhhdmlvdXIgfSxcblx0XHRcdCdhcmlhRm9ybWF0JzogeyByOiBmYWxzZSwgdDogdGVzdEFyaWFGb3JtYXQgfSxcblx0XHRcdCdmb3JtYXQnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0Rm9ybWF0IH0sXG5cdFx0XHQndG9vbHRpcHMnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0VG9vbHRpcHMgfSxcblx0XHRcdCdjc3NQcmVmaXgnOiB7IHI6IHRydWUsIHQ6IHRlc3RDc3NQcmVmaXggfSxcblx0XHRcdCdjc3NDbGFzc2VzJzogeyByOiB0cnVlLCB0OiB0ZXN0Q3NzQ2xhc3NlcyB9XG5cdFx0fTtcblxuXHRcdHZhciBkZWZhdWx0cyA9IHtcblx0XHRcdCdjb25uZWN0JzogZmFsc2UsXG5cdFx0XHQnZGlyZWN0aW9uJzogJ2x0cicsXG5cdFx0XHQnYmVoYXZpb3VyJzogJ3RhcCcsXG5cdFx0XHQnb3JpZW50YXRpb24nOiAnaG9yaXpvbnRhbCcsXG5cdFx0XHQnY3NzUHJlZml4JyA6ICdub1VpLScsXG5cdFx0XHQnY3NzQ2xhc3Nlcyc6IHtcblx0XHRcdFx0dGFyZ2V0OiAndGFyZ2V0Jyxcblx0XHRcdFx0YmFzZTogJ2Jhc2UnLFxuXHRcdFx0XHRvcmlnaW46ICdvcmlnaW4nLFxuXHRcdFx0XHRoYW5kbGU6ICdoYW5kbGUnLFxuXHRcdFx0XHRoYW5kbGVMb3dlcjogJ2hhbmRsZS1sb3dlcicsXG5cdFx0XHRcdGhhbmRsZVVwcGVyOiAnaGFuZGxlLXVwcGVyJyxcblx0XHRcdFx0aG9yaXpvbnRhbDogJ2hvcml6b250YWwnLFxuXHRcdFx0XHR2ZXJ0aWNhbDogJ3ZlcnRpY2FsJyxcblx0XHRcdFx0YmFja2dyb3VuZDogJ2JhY2tncm91bmQnLFxuXHRcdFx0XHRjb25uZWN0OiAnY29ubmVjdCcsXG5cdFx0XHRcdGNvbm5lY3RzOiAnY29ubmVjdHMnLFxuXHRcdFx0XHRsdHI6ICdsdHInLFxuXHRcdFx0XHRydGw6ICdydGwnLFxuXHRcdFx0XHRkcmFnZ2FibGU6ICdkcmFnZ2FibGUnLFxuXHRcdFx0XHRkcmFnOiAnc3RhdGUtZHJhZycsXG5cdFx0XHRcdHRhcDogJ3N0YXRlLXRhcCcsXG5cdFx0XHRcdGFjdGl2ZTogJ2FjdGl2ZScsXG5cdFx0XHRcdHRvb2x0aXA6ICd0b29sdGlwJyxcblx0XHRcdFx0cGlwczogJ3BpcHMnLFxuXHRcdFx0XHRwaXBzSG9yaXpvbnRhbDogJ3BpcHMtaG9yaXpvbnRhbCcsXG5cdFx0XHRcdHBpcHNWZXJ0aWNhbDogJ3BpcHMtdmVydGljYWwnLFxuXHRcdFx0XHRtYXJrZXI6ICdtYXJrZXInLFxuXHRcdFx0XHRtYXJrZXJIb3Jpem9udGFsOiAnbWFya2VyLWhvcml6b250YWwnLFxuXHRcdFx0XHRtYXJrZXJWZXJ0aWNhbDogJ21hcmtlci12ZXJ0aWNhbCcsXG5cdFx0XHRcdG1hcmtlck5vcm1hbDogJ21hcmtlci1ub3JtYWwnLFxuXHRcdFx0XHRtYXJrZXJMYXJnZTogJ21hcmtlci1sYXJnZScsXG5cdFx0XHRcdG1hcmtlclN1YjogJ21hcmtlci1zdWInLFxuXHRcdFx0XHR2YWx1ZTogJ3ZhbHVlJyxcblx0XHRcdFx0dmFsdWVIb3Jpem9udGFsOiAndmFsdWUtaG9yaXpvbnRhbCcsXG5cdFx0XHRcdHZhbHVlVmVydGljYWw6ICd2YWx1ZS12ZXJ0aWNhbCcsXG5cdFx0XHRcdHZhbHVlTm9ybWFsOiAndmFsdWUtbm9ybWFsJyxcblx0XHRcdFx0dmFsdWVMYXJnZTogJ3ZhbHVlLWxhcmdlJyxcblx0XHRcdFx0dmFsdWVTdWI6ICd2YWx1ZS1zdWInXG5cdFx0XHR9XG5cdFx0fTtcblxuXHRcdC8vIEFyaWFGb3JtYXQgZGVmYXVsdHMgdG8gcmVndWxhciBmb3JtYXQsIGlmIGFueS5cblx0XHRpZiAoIG9wdGlvbnMuZm9ybWF0ICYmICFvcHRpb25zLmFyaWFGb3JtYXQgKSB7XG5cdFx0XHRvcHRpb25zLmFyaWFGb3JtYXQgPSBvcHRpb25zLmZvcm1hdDtcblx0XHR9XG5cblx0XHQvLyBSdW4gYWxsIG9wdGlvbnMgdGhyb3VnaCBhIHRlc3RpbmcgbWVjaGFuaXNtIHRvIGVuc3VyZSBjb3JyZWN0XG5cdFx0Ly8gaW5wdXQuIEl0IHNob3VsZCBiZSBub3RlZCB0aGF0IG9wdGlvbnMgbWlnaHQgZ2V0IG1vZGlmaWVkIHRvXG5cdFx0Ly8gYmUgaGFuZGxlZCBwcm9wZXJseS4gRS5nLiB3cmFwcGluZyBpbnRlZ2VycyBpbiBhcnJheXMuXG5cdFx0T2JqZWN0LmtleXModGVzdHMpLmZvckVhY2goZnVuY3Rpb24oIG5hbWUgKXtcblxuXHRcdFx0Ly8gSWYgdGhlIG9wdGlvbiBpc24ndCBzZXQsIGJ1dCBpdCBpcyByZXF1aXJlZCwgdGhyb3cgYW4gZXJyb3IuXG5cdFx0XHRpZiAoICFpc1NldChvcHRpb25zW25hbWVdKSAmJiBkZWZhdWx0c1tuYW1lXSA9PT0gdW5kZWZpbmVkICkge1xuXG5cdFx0XHRcdGlmICggdGVzdHNbbmFtZV0uciApIHtcblx0XHRcdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdcIiArIG5hbWUgKyBcIicgaXMgcmVxdWlyZWQuXCIpO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0XHR9XG5cblx0XHRcdHRlc3RzW25hbWVdLnQoIHBhcnNlZCwgIWlzU2V0KG9wdGlvbnNbbmFtZV0pID8gZGVmYXVsdHNbbmFtZV0gOiBvcHRpb25zW25hbWVdICk7XG5cdFx0fSk7XG5cblx0XHQvLyBGb3J3YXJkIHBpcHMgb3B0aW9uc1xuXHRcdHBhcnNlZC5waXBzID0gb3B0aW9ucy5waXBzO1xuXG5cdFx0Ly8gQWxsIHJlY2VudCBicm93c2VycyBhY2NlcHQgdW5wcmVmaXhlZCB0cmFuc2Zvcm0uXG5cdFx0Ly8gV2UgbmVlZCAtbXMtIGZvciBJRTkgYW5kIC13ZWJraXQtIGZvciBvbGRlciBBbmRyb2lkO1xuXHRcdC8vIEFzc3VtZSB1c2Ugb2YgLXdlYmtpdC0gaWYgdW5wcmVmaXhlZCBhbmQgLW1zLSBhcmUgbm90IHN1cHBvcnRlZC5cblx0XHQvLyBodHRwczovL2Nhbml1c2UuY29tLyNmZWF0PXRyYW5zZm9ybXMyZFxuXHRcdHZhciBkID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudChcImRpdlwiKTtcblx0XHR2YXIgbXNQcmVmaXggPSBkLnN0eWxlLm1zVHJhbnNmb3JtICE9PSB1bmRlZmluZWQ7XG5cdFx0dmFyIG5vUHJlZml4ID0gZC5zdHlsZS50cmFuc2Zvcm0gIT09IHVuZGVmaW5lZDtcblxuXHRcdHBhcnNlZC50cmFuc2Zvcm1SdWxlID0gbm9QcmVmaXggPyAndHJhbnNmb3JtJyA6IChtc1ByZWZpeCA/ICdtc1RyYW5zZm9ybScgOiAnd2Via2l0VHJhbnNmb3JtJyk7XG5cblx0XHQvLyBQaXBzIGRvbid0IG1vdmUsIHNvIHdlIGNhbiBwbGFjZSB0aGVtIHVzaW5nIGxlZnQvdG9wLlxuXHRcdHZhciBzdHlsZXMgPSBbWydsZWZ0JywgJ3RvcCddLCBbJ3JpZ2h0JywgJ2JvdHRvbSddXTtcblxuXHRcdHBhcnNlZC5zdHlsZSA9IHN0eWxlc1twYXJzZWQuZGlyXVtwYXJzZWQub3J0XTtcblxuXHRcdHJldHVybiBwYXJzZWQ7XG5cdH1cblxyXG5cclxuZnVuY3Rpb24gc2NvcGUgKCB0YXJnZXQsIG9wdGlvbnMsIG9yaWdpbmFsT3B0aW9ucyApe1xyXG5cclxuXHR2YXIgYWN0aW9ucyA9IGdldEFjdGlvbnMoKTtcclxuXHR2YXIgc3VwcG9ydHNUb3VjaEFjdGlvbk5vbmUgPSBnZXRTdXBwb3J0c1RvdWNoQWN0aW9uTm9uZSgpO1xyXG5cdHZhciBzdXBwb3J0c1Bhc3NpdmUgPSBzdXBwb3J0c1RvdWNoQWN0aW9uTm9uZSAmJiBnZXRTdXBwb3J0c1Bhc3NpdmUoKTtcclxuXHJcblx0Ly8gQWxsIHZhcmlhYmxlcyBsb2NhbCB0byAnc2NvcGUnIGFyZSBwcmVmaXhlZCB3aXRoICdzY29wZV8nXHJcblx0dmFyIHNjb3BlX1RhcmdldCA9IHRhcmdldDtcclxuXHR2YXIgc2NvcGVfTG9jYXRpb25zID0gW107XHJcblx0dmFyIHNjb3BlX0Jhc2U7XHJcblx0dmFyIHNjb3BlX0hhbmRsZXM7XHJcblx0dmFyIHNjb3BlX0hhbmRsZU51bWJlcnMgPSBbXTtcclxuXHR2YXIgc2NvcGVfQWN0aXZlSGFuZGxlc0NvdW50ID0gMDtcclxuXHR2YXIgc2NvcGVfQ29ubmVjdHM7XHJcblx0dmFyIHNjb3BlX1NwZWN0cnVtID0gb3B0aW9ucy5zcGVjdHJ1bTtcclxuXHR2YXIgc2NvcGVfVmFsdWVzID0gW107XHJcblx0dmFyIHNjb3BlX0V2ZW50cyA9IHt9O1xyXG5cdHZhciBzY29wZV9TZWxmO1xyXG5cdHZhciBzY29wZV9QaXBzO1xyXG5cdHZhciBzY29wZV9Eb2N1bWVudCA9IHRhcmdldC5vd25lckRvY3VtZW50O1xyXG5cdHZhciBzY29wZV9Eb2N1bWVudEVsZW1lbnQgPSBzY29wZV9Eb2N1bWVudC5kb2N1bWVudEVsZW1lbnQ7XHJcblx0dmFyIHNjb3BlX0JvZHkgPSBzY29wZV9Eb2N1bWVudC5ib2R5O1xyXG5cclxuXHJcblx0Ly8gRm9yIGhvcml6b250YWwgc2xpZGVycyBpbiBzdGFuZGFyZCBsdHIgZG9jdW1lbnRzLFxyXG5cdC8vIG1ha2UgLm5vVWktb3JpZ2luIG92ZXJmbG93IHRvIHRoZSBsZWZ0IHNvIHRoZSBkb2N1bWVudCBkb2Vzbid0IHNjcm9sbC5cclxuXHR2YXIgc2NvcGVfRGlyT2Zmc2V0ID0gKHNjb3BlX0RvY3VtZW50LmRpciA9PT0gJ3J0bCcpIHx8IChvcHRpb25zLm9ydCA9PT0gMSkgPyAwIDogMTAwO1xyXG5cclxuLyohIEluIHRoaXMgZmlsZTogQ29uc3RydWN0aW9uIG9mIERPTSBlbGVtZW50czsgKi9cclxuXHJcblx0Ly8gQ3JlYXRlcyBhIG5vZGUsIGFkZHMgaXQgdG8gdGFyZ2V0LCByZXR1cm5zIHRoZSBuZXcgbm9kZS5cclxuXHRmdW5jdGlvbiBhZGROb2RlVG8gKCBhZGRUYXJnZXQsIGNsYXNzTmFtZSApIHtcclxuXHJcblx0XHR2YXIgZGl2ID0gc2NvcGVfRG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XHJcblxyXG5cdFx0aWYgKCBjbGFzc05hbWUgKSB7XHJcblx0XHRcdGFkZENsYXNzKGRpdiwgY2xhc3NOYW1lKTtcclxuXHRcdH1cclxuXHJcblx0XHRhZGRUYXJnZXQuYXBwZW5kQ2hpbGQoZGl2KTtcclxuXHJcblx0XHRyZXR1cm4gZGl2O1xyXG5cdH1cclxuXHJcblx0Ly8gQXBwZW5kIGEgb3JpZ2luIHRvIHRoZSBiYXNlXHJcblx0ZnVuY3Rpb24gYWRkT3JpZ2luICggYmFzZSwgaGFuZGxlTnVtYmVyICkge1xyXG5cclxuXHRcdHZhciBvcmlnaW4gPSBhZGROb2RlVG8oYmFzZSwgb3B0aW9ucy5jc3NDbGFzc2VzLm9yaWdpbik7XHJcblx0XHR2YXIgaGFuZGxlID0gYWRkTm9kZVRvKG9yaWdpbiwgb3B0aW9ucy5jc3NDbGFzc2VzLmhhbmRsZSk7XHJcblxyXG5cdFx0aGFuZGxlLnNldEF0dHJpYnV0ZSgnZGF0YS1oYW5kbGUnLCBoYW5kbGVOdW1iZXIpO1xyXG5cclxuXHRcdC8vIGh0dHBzOi8vZGV2ZWxvcGVyLm1vemlsbGEub3JnL2VuLVVTL2RvY3MvV2ViL0hUTUwvR2xvYmFsX2F0dHJpYnV0ZXMvdGFiaW5kZXhcclxuXHRcdC8vIDAgPSBmb2N1c2FibGUgYW5kIHJlYWNoYWJsZVxyXG5cdFx0aGFuZGxlLnNldEF0dHJpYnV0ZSgndGFiaW5kZXgnLCAnMCcpO1xyXG5cdFx0aGFuZGxlLnNldEF0dHJpYnV0ZSgncm9sZScsICdzbGlkZXInKTtcclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ2FyaWEtb3JpZW50YXRpb24nLCBvcHRpb25zLm9ydCA/ICd2ZXJ0aWNhbCcgOiAnaG9yaXpvbnRhbCcpO1xyXG5cclxuXHRcdGlmICggaGFuZGxlTnVtYmVyID09PSAwICkge1xyXG5cdFx0XHRhZGRDbGFzcyhoYW5kbGUsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5oYW5kbGVMb3dlcik7XHJcblx0XHR9XHJcblxyXG5cdFx0ZWxzZSBpZiAoIGhhbmRsZU51bWJlciA9PT0gb3B0aW9ucy5oYW5kbGVzIC0gMSApIHtcclxuXHRcdFx0YWRkQ2xhc3MoaGFuZGxlLCBvcHRpb25zLmNzc0NsYXNzZXMuaGFuZGxlVXBwZXIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBvcmlnaW47XHJcblx0fVxyXG5cclxuXHQvLyBJbnNlcnQgbm9kZXMgZm9yIGNvbm5lY3QgZWxlbWVudHNcclxuXHRmdW5jdGlvbiBhZGRDb25uZWN0ICggYmFzZSwgYWRkICkge1xyXG5cclxuXHRcdGlmICggIWFkZCApIHtcclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBhZGROb2RlVG8oYmFzZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmNvbm5lY3QpO1xyXG5cdH1cclxuXHJcblx0Ly8gQWRkIGhhbmRsZXMgdG8gdGhlIHNsaWRlciBiYXNlLlxyXG5cdGZ1bmN0aW9uIGFkZEVsZW1lbnRzICggY29ubmVjdE9wdGlvbnMsIGJhc2UgKSB7XHJcblxyXG5cdFx0dmFyIGNvbm5lY3RCYXNlID0gYWRkTm9kZVRvKGJhc2UsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5jb25uZWN0cyk7XHJcblxyXG5cdFx0c2NvcGVfSGFuZGxlcyA9IFtdO1xyXG5cdFx0c2NvcGVfQ29ubmVjdHMgPSBbXTtcclxuXHJcblx0XHRzY29wZV9Db25uZWN0cy5wdXNoKGFkZENvbm5lY3QoY29ubmVjdEJhc2UsIGNvbm5lY3RPcHRpb25zWzBdKSk7XHJcblxyXG5cdFx0Ly8gWzo6OjpPPT09PU89PT09Tz09PT1dXHJcblx0XHQvLyBjb25uZWN0T3B0aW9ucyA9IFswLCAxLCAxLCAxXVxyXG5cclxuXHRcdGZvciAoIHZhciBpID0gMDsgaSA8IG9wdGlvbnMuaGFuZGxlczsgaSsrICkge1xyXG5cdFx0XHQvLyBLZWVwIGEgbGlzdCBvZiBhbGwgYWRkZWQgaGFuZGxlcy5cclxuXHRcdFx0c2NvcGVfSGFuZGxlcy5wdXNoKGFkZE9yaWdpbihiYXNlLCBpKSk7XHJcblx0XHRcdHNjb3BlX0hhbmRsZU51bWJlcnNbaV0gPSBpO1xyXG5cdFx0XHRzY29wZV9Db25uZWN0cy5wdXNoKGFkZENvbm5lY3QoY29ubmVjdEJhc2UsIGNvbm5lY3RPcHRpb25zW2kgKyAxXSkpO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0Ly8gSW5pdGlhbGl6ZSBhIHNpbmdsZSBzbGlkZXIuXHJcblx0ZnVuY3Rpb24gYWRkU2xpZGVyICggYWRkVGFyZ2V0ICkge1xyXG5cclxuXHRcdC8vIEFwcGx5IGNsYXNzZXMgYW5kIGRhdGEgdG8gdGhlIHRhcmdldC5cclxuXHRcdGFkZENsYXNzKGFkZFRhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLnRhcmdldCk7XHJcblxyXG5cdFx0aWYgKCBvcHRpb25zLmRpciA9PT0gMCApIHtcclxuXHRcdFx0YWRkQ2xhc3MoYWRkVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMubHRyKTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdGFkZENsYXNzKGFkZFRhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLnJ0bCk7XHJcblx0XHR9XHJcblxyXG5cdFx0aWYgKCBvcHRpb25zLm9ydCA9PT0gMCApIHtcclxuXHRcdFx0YWRkQ2xhc3MoYWRkVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMuaG9yaXpvbnRhbCk7XHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHRhZGRDbGFzcyhhZGRUYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy52ZXJ0aWNhbCk7XHJcblx0XHR9XHJcblxyXG5cdFx0c2NvcGVfQmFzZSA9IGFkZE5vZGVUbyhhZGRUYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5iYXNlKTtcclxuXHR9XHJcblxyXG5cclxuXHRmdW5jdGlvbiBhZGRUb29sdGlwICggaGFuZGxlLCBoYW5kbGVOdW1iZXIgKSB7XHJcblxyXG5cdFx0aWYgKCAhb3B0aW9ucy50b29sdGlwc1toYW5kbGVOdW1iZXJdICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIGFkZE5vZGVUbyhoYW5kbGUuZmlyc3RDaGlsZCwgb3B0aW9ucy5jc3NDbGFzc2VzLnRvb2x0aXApO1xyXG5cdH1cclxuXHJcblx0Ly8gVGhlIHRvb2x0aXBzIG9wdGlvbiBpcyBhIHNob3J0aGFuZCBmb3IgdXNpbmcgdGhlICd1cGRhdGUnIGV2ZW50LlxyXG5cdGZ1bmN0aW9uIHRvb2x0aXBzICggKSB7XHJcblxyXG5cdFx0Ly8gVG9vbHRpcHMgYXJlIGFkZGVkIHdpdGggb3B0aW9ucy50b29sdGlwcyBpbiBvcmlnaW5hbCBvcmRlci5cclxuXHRcdHZhciB0aXBzID0gc2NvcGVfSGFuZGxlcy5tYXAoYWRkVG9vbHRpcCk7XHJcblxyXG5cdFx0YmluZEV2ZW50KCd1cGRhdGUnLCBmdW5jdGlvbih2YWx1ZXMsIGhhbmRsZU51bWJlciwgdW5lbmNvZGVkKSB7XHJcblxyXG5cdFx0XHRpZiAoICF0aXBzW2hhbmRsZU51bWJlcl0gKSB7XHJcblx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHR2YXIgZm9ybWF0dGVkVmFsdWUgPSB2YWx1ZXNbaGFuZGxlTnVtYmVyXTtcclxuXHJcblx0XHRcdGlmICggb3B0aW9ucy50b29sdGlwc1toYW5kbGVOdW1iZXJdICE9PSB0cnVlICkge1xyXG5cdFx0XHRcdGZvcm1hdHRlZFZhbHVlID0gb3B0aW9ucy50b29sdGlwc1toYW5kbGVOdW1iZXJdLnRvKHVuZW5jb2RlZFtoYW5kbGVOdW1iZXJdKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0dGlwc1toYW5kbGVOdW1iZXJdLmlubmVySFRNTCA9IGZvcm1hdHRlZFZhbHVlO1xyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gYXJpYSAoICkge1xyXG5cclxuXHRcdGJpbmRFdmVudCgndXBkYXRlJywgZnVuY3Rpb24gKCB2YWx1ZXMsIGhhbmRsZU51bWJlciwgdW5lbmNvZGVkLCB0YXAsIHBvc2l0aW9ucyApIHtcclxuXHJcblx0XHRcdC8vIFVwZGF0ZSBBcmlhIFZhbHVlcyBmb3IgYWxsIGhhbmRsZXMsIGFzIGEgY2hhbmdlIGluIG9uZSBjaGFuZ2VzIG1pbiBhbmQgbWF4IHZhbHVlcyBmb3IgdGhlIG5leHQuXHJcblx0XHRcdHNjb3BlX0hhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbiggaW5kZXggKXtcclxuXHJcblx0XHRcdFx0dmFyIGhhbmRsZSA9IHNjb3BlX0hhbmRsZXNbaW5kZXhdO1xyXG5cclxuXHRcdFx0XHR2YXIgbWluID0gY2hlY2tIYW5kbGVQb3NpdGlvbihzY29wZV9Mb2NhdGlvbnMsIGluZGV4LCAwLCB0cnVlLCB0cnVlLCB0cnVlKTtcclxuXHRcdFx0XHR2YXIgbWF4ID0gY2hlY2tIYW5kbGVQb3NpdGlvbihzY29wZV9Mb2NhdGlvbnMsIGluZGV4LCAxMDAsIHRydWUsIHRydWUsIHRydWUpO1xyXG5cclxuXHRcdFx0XHR2YXIgbm93ID0gcG9zaXRpb25zW2luZGV4XTtcclxuXHRcdFx0XHR2YXIgdGV4dCA9IG9wdGlvbnMuYXJpYUZvcm1hdC50byh1bmVuY29kZWRbaW5kZXhdKTtcclxuXHJcblx0XHRcdFx0aGFuZGxlLmNoaWxkcmVuWzBdLnNldEF0dHJpYnV0ZSgnYXJpYS12YWx1ZW1pbicsIG1pbi50b0ZpeGVkKDEpKTtcclxuXHRcdFx0XHRoYW5kbGUuY2hpbGRyZW5bMF0uc2V0QXR0cmlidXRlKCdhcmlhLXZhbHVlbWF4JywgbWF4LnRvRml4ZWQoMSkpO1xyXG5cdFx0XHRcdGhhbmRsZS5jaGlsZHJlblswXS5zZXRBdHRyaWJ1dGUoJ2FyaWEtdmFsdWVub3cnLCBub3cudG9GaXhlZCgxKSk7XHJcblx0XHRcdFx0aGFuZGxlLmNoaWxkcmVuWzBdLnNldEF0dHJpYnV0ZSgnYXJpYS12YWx1ZXRleHQnLCB0ZXh0KTtcclxuXHRcdFx0fSk7XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cclxuXHRmdW5jdGlvbiBnZXRHcm91cCAoIG1vZGUsIHZhbHVlcywgc3RlcHBlZCApIHtcclxuXHJcblx0XHQvLyBVc2UgdGhlIHJhbmdlLlxyXG5cdFx0aWYgKCBtb2RlID09PSAncmFuZ2UnIHx8IG1vZGUgPT09ICdzdGVwcycgKSB7XHJcblx0XHRcdHJldHVybiBzY29wZV9TcGVjdHJ1bS54VmFsO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggbW9kZSA9PT0gJ2NvdW50JyApIHtcclxuXHJcblx0XHRcdGlmICggdmFsdWVzIDwgMiApIHtcclxuXHRcdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICd2YWx1ZXMnICg+PSAyKSByZXF1aXJlZCBmb3IgbW9kZSAnY291bnQnLlwiKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gRGl2aWRlIDAgLSAxMDAgaW4gJ2NvdW50JyBwYXJ0cy5cclxuXHRcdFx0dmFyIGludGVydmFsID0gdmFsdWVzIC0gMTtcclxuXHRcdFx0dmFyIHNwcmVhZCA9ICggMTAwIC8gaW50ZXJ2YWwgKTtcclxuXHJcblx0XHRcdHZhbHVlcyA9IFtdO1xyXG5cclxuXHRcdFx0Ly8gTGlzdCB0aGVzZSBwYXJ0cyBhbmQgaGF2ZSB0aGVtIGhhbmRsZWQgYXMgJ3Bvc2l0aW9ucycuXHJcblx0XHRcdHdoaWxlICggaW50ZXJ2YWwtLSApIHtcclxuXHRcdFx0XHR2YWx1ZXNbIGludGVydmFsIF0gPSAoIGludGVydmFsICogc3ByZWFkICk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHZhbHVlcy5wdXNoKDEwMCk7XHJcblxyXG5cdFx0XHRtb2RlID0gJ3Bvc2l0aW9ucyc7XHJcblx0XHR9XHJcblxyXG5cdFx0aWYgKCBtb2RlID09PSAncG9zaXRpb25zJyApIHtcclxuXHJcblx0XHRcdC8vIE1hcCBhbGwgcGVyY2VudGFnZXMgdG8gb24tcmFuZ2UgdmFsdWVzLlxyXG5cdFx0XHRyZXR1cm4gdmFsdWVzLm1hcChmdW5jdGlvbiggdmFsdWUgKXtcclxuXHRcdFx0XHRyZXR1cm4gc2NvcGVfU3BlY3RydW0uZnJvbVN0ZXBwaW5nKCBzdGVwcGVkID8gc2NvcGVfU3BlY3RydW0uZ2V0U3RlcCggdmFsdWUgKSA6IHZhbHVlICk7XHJcblx0XHRcdH0pO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggbW9kZSA9PT0gJ3ZhbHVlcycgKSB7XHJcblxyXG5cdFx0XHQvLyBJZiB0aGUgdmFsdWUgbXVzdCBiZSBzdGVwcGVkLCBpdCBuZWVkcyB0byBiZSBjb252ZXJ0ZWQgdG8gYSBwZXJjZW50YWdlIGZpcnN0LlxyXG5cdFx0XHRpZiAoIHN0ZXBwZWQgKSB7XHJcblxyXG5cdFx0XHRcdHJldHVybiB2YWx1ZXMubWFwKGZ1bmN0aW9uKCB2YWx1ZSApe1xyXG5cclxuXHRcdFx0XHRcdC8vIENvbnZlcnQgdG8gcGVyY2VudGFnZSwgYXBwbHkgc3RlcCwgcmV0dXJuIHRvIHZhbHVlLlxyXG5cdFx0XHRcdFx0cmV0dXJuIHNjb3BlX1NwZWN0cnVtLmZyb21TdGVwcGluZyggc2NvcGVfU3BlY3RydW0uZ2V0U3RlcCggc2NvcGVfU3BlY3RydW0udG9TdGVwcGluZyggdmFsdWUgKSApICk7XHJcblx0XHRcdFx0fSk7XHJcblxyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBPdGhlcndpc2UsIHdlIGNhbiBzaW1wbHkgdXNlIHRoZSB2YWx1ZXMuXHJcblx0XHRcdHJldHVybiB2YWx1ZXM7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRmdW5jdGlvbiBnZW5lcmF0ZVNwcmVhZCAoIGRlbnNpdHksIG1vZGUsIGdyb3VwICkge1xyXG5cclxuXHRcdGZ1bmN0aW9uIHNhZmVJbmNyZW1lbnQodmFsdWUsIGluY3JlbWVudCkge1xyXG5cdFx0XHQvLyBBdm9pZCBmbG9hdGluZyBwb2ludCB2YXJpYW5jZSBieSBkcm9wcGluZyB0aGUgc21hbGxlc3QgZGVjaW1hbCBwbGFjZXMuXHJcblx0XHRcdHJldHVybiAodmFsdWUgKyBpbmNyZW1lbnQpLnRvRml4ZWQoNykgLyAxO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBpbmRleGVzID0ge307XHJcblx0XHR2YXIgZmlyc3RJblJhbmdlID0gc2NvcGVfU3BlY3RydW0ueFZhbFswXTtcclxuXHRcdHZhciBsYXN0SW5SYW5nZSA9IHNjb3BlX1NwZWN0cnVtLnhWYWxbc2NvcGVfU3BlY3RydW0ueFZhbC5sZW5ndGgtMV07XHJcblx0XHR2YXIgaWdub3JlRmlyc3QgPSBmYWxzZTtcclxuXHRcdHZhciBpZ25vcmVMYXN0ID0gZmFsc2U7XHJcblx0XHR2YXIgcHJldlBjdCA9IDA7XHJcblxyXG5cdFx0Ly8gQ3JlYXRlIGEgY29weSBvZiB0aGUgZ3JvdXAsIHNvcnQgaXQgYW5kIGZpbHRlciBhd2F5IGFsbCBkdXBsaWNhdGVzLlxyXG5cdFx0Z3JvdXAgPSB1bmlxdWUoZ3JvdXAuc2xpY2UoKS5zb3J0KGZ1bmN0aW9uKGEsIGIpeyByZXR1cm4gYSAtIGI7IH0pKTtcclxuXHJcblx0XHQvLyBNYWtlIHN1cmUgdGhlIHJhbmdlIHN0YXJ0cyB3aXRoIHRoZSBmaXJzdCBlbGVtZW50LlxyXG5cdFx0aWYgKCBncm91cFswXSAhPT0gZmlyc3RJblJhbmdlICkge1xyXG5cdFx0XHRncm91cC51bnNoaWZ0KGZpcnN0SW5SYW5nZSk7XHJcblx0XHRcdGlnbm9yZUZpcnN0ID0gdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBMaWtld2lzZSBmb3IgdGhlIGxhc3Qgb25lLlxyXG5cdFx0aWYgKCBncm91cFtncm91cC5sZW5ndGggLSAxXSAhPT0gbGFzdEluUmFuZ2UgKSB7XHJcblx0XHRcdGdyb3VwLnB1c2gobGFzdEluUmFuZ2UpO1xyXG5cdFx0XHRpZ25vcmVMYXN0ID0gdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHRncm91cC5mb3JFYWNoKGZ1bmN0aW9uICggY3VycmVudCwgaW5kZXggKSB7XHJcblxyXG5cdFx0XHQvLyBHZXQgdGhlIGN1cnJlbnQgc3RlcCBhbmQgdGhlIGxvd2VyICsgdXBwZXIgcG9zaXRpb25zLlxyXG5cdFx0XHR2YXIgc3RlcDtcclxuXHRcdFx0dmFyIGk7XHJcblx0XHRcdHZhciBxO1xyXG5cdFx0XHR2YXIgbG93ID0gY3VycmVudDtcclxuXHRcdFx0dmFyIGhpZ2ggPSBncm91cFtpbmRleCsxXTtcclxuXHRcdFx0dmFyIG5ld1BjdDtcclxuXHRcdFx0dmFyIHBjdERpZmZlcmVuY2U7XHJcblx0XHRcdHZhciBwY3RQb3M7XHJcblx0XHRcdHZhciB0eXBlO1xyXG5cdFx0XHR2YXIgc3RlcHM7XHJcblx0XHRcdHZhciByZWFsU3RlcHM7XHJcblx0XHRcdHZhciBzdGVwc2l6ZTtcclxuXHJcblx0XHRcdC8vIFdoZW4gdXNpbmcgJ3N0ZXBzJyBtb2RlLCB1c2UgdGhlIHByb3ZpZGVkIHN0ZXBzLlxyXG5cdFx0XHQvLyBPdGhlcndpc2UsIHdlJ2xsIHN0ZXAgb24gdG8gdGhlIG5leHQgc3VicmFuZ2UuXHJcblx0XHRcdGlmICggbW9kZSA9PT0gJ3N0ZXBzJyApIHtcclxuXHRcdFx0XHRzdGVwID0gc2NvcGVfU3BlY3RydW0ueE51bVN0ZXBzWyBpbmRleCBdO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBEZWZhdWx0IHRvIGEgJ2Z1bGwnIHN0ZXAuXHJcblx0XHRcdGlmICggIXN0ZXAgKSB7XHJcblx0XHRcdFx0c3RlcCA9IGhpZ2gtbG93O1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBMb3cgY2FuIGJlIDAsIHNvIHRlc3QgZm9yIGZhbHNlLiBJZiBoaWdoIGlzIHVuZGVmaW5lZCxcclxuXHRcdFx0Ly8gd2UgYXJlIGF0IHRoZSBsYXN0IHN1YnJhbmdlLiBJbmRleCAwIGlzIGFscmVhZHkgaGFuZGxlZC5cclxuXHRcdFx0aWYgKCBsb3cgPT09IGZhbHNlIHx8IGhpZ2ggPT09IHVuZGVmaW5lZCApIHtcclxuXHRcdFx0XHRyZXR1cm47XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIE1ha2Ugc3VyZSBzdGVwIGlzbid0IDAsIHdoaWNoIHdvdWxkIGNhdXNlIGFuIGluZmluaXRlIGxvb3AgKCM2NTQpXHJcblx0XHRcdHN0ZXAgPSBNYXRoLm1heChzdGVwLCAwLjAwMDAwMDEpO1xyXG5cclxuXHRcdFx0Ly8gRmluZCBhbGwgc3RlcHMgaW4gdGhlIHN1YnJhbmdlLlxyXG5cdFx0XHRmb3IgKCBpID0gbG93OyBpIDw9IGhpZ2g7IGkgPSBzYWZlSW5jcmVtZW50KGksIHN0ZXApICkge1xyXG5cclxuXHRcdFx0XHQvLyBHZXQgdGhlIHBlcmNlbnRhZ2UgdmFsdWUgZm9yIHRoZSBjdXJyZW50IHN0ZXAsXHJcblx0XHRcdFx0Ly8gY2FsY3VsYXRlIHRoZSBzaXplIGZvciB0aGUgc3VicmFuZ2UuXHJcblx0XHRcdFx0bmV3UGN0ID0gc2NvcGVfU3BlY3RydW0udG9TdGVwcGluZyggaSApO1xyXG5cdFx0XHRcdHBjdERpZmZlcmVuY2UgPSBuZXdQY3QgLSBwcmV2UGN0O1xyXG5cclxuXHRcdFx0XHRzdGVwcyA9IHBjdERpZmZlcmVuY2UgLyBkZW5zaXR5O1xyXG5cdFx0XHRcdHJlYWxTdGVwcyA9IE1hdGgucm91bmQoc3RlcHMpO1xyXG5cclxuXHRcdFx0XHQvLyBUaGlzIHJhdGlvIHJlcHJlc2VudHMgdGhlIGFtb3VudCBvZiBwZXJjZW50YWdlLXNwYWNlIGEgcG9pbnQgaW5kaWNhdGVzLlxyXG5cdFx0XHRcdC8vIEZvciBhIGRlbnNpdHkgMSB0aGUgcG9pbnRzL3BlcmNlbnRhZ2UgPSAxLiBGb3IgZGVuc2l0eSAyLCB0aGF0IHBlcmNlbnRhZ2UgbmVlZHMgdG8gYmUgcmUtZGV2aWRlZC5cclxuXHRcdFx0XHQvLyBSb3VuZCB0aGUgcGVyY2VudGFnZSBvZmZzZXQgdG8gYW4gZXZlbiBudW1iZXIsIHRoZW4gZGl2aWRlIGJ5IHR3b1xyXG5cdFx0XHRcdC8vIHRvIHNwcmVhZCB0aGUgb2Zmc2V0IG9uIGJvdGggc2lkZXMgb2YgdGhlIHJhbmdlLlxyXG5cdFx0XHRcdHN0ZXBzaXplID0gcGN0RGlmZmVyZW5jZS9yZWFsU3RlcHM7XHJcblxyXG5cdFx0XHRcdC8vIERpdmlkZSBhbGwgcG9pbnRzIGV2ZW5seSwgYWRkaW5nIHRoZSBjb3JyZWN0IG51bWJlciB0byB0aGlzIHN1YnJhbmdlLlxyXG5cdFx0XHRcdC8vIFJ1biB1cCB0byA8PSBzbyB0aGF0IDEwMCUgZ2V0cyBhIHBvaW50LCBldmVudCBpZiBpZ25vcmVMYXN0IGlzIHNldC5cclxuXHRcdFx0XHRmb3IgKCBxID0gMTsgcSA8PSByZWFsU3RlcHM7IHEgKz0gMSApIHtcclxuXHJcblx0XHRcdFx0XHQvLyBUaGUgcmF0aW8gYmV0d2VlbiB0aGUgcm91bmRlZCB2YWx1ZSBhbmQgdGhlIGFjdHVhbCBzaXplIG1pZ2h0IGJlIH4xJSBvZmYuXHJcblx0XHRcdFx0XHQvLyBDb3JyZWN0IHRoZSBwZXJjZW50YWdlIG9mZnNldCBieSB0aGUgbnVtYmVyIG9mIHBvaW50c1xyXG5cdFx0XHRcdFx0Ly8gcGVyIHN1YnJhbmdlLiBkZW5zaXR5ID0gMSB3aWxsIHJlc3VsdCBpbiAxMDAgcG9pbnRzIG9uIHRoZVxyXG5cdFx0XHRcdFx0Ly8gZnVsbCByYW5nZSwgMiBmb3IgNTAsIDQgZm9yIDI1LCBldGMuXHJcblx0XHRcdFx0XHRwY3RQb3MgPSBwcmV2UGN0ICsgKCBxICogc3RlcHNpemUgKTtcclxuXHRcdFx0XHRcdGluZGV4ZXNbcGN0UG9zLnRvRml4ZWQoNSldID0gWyd4JywgMF07XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHQvLyBEZXRlcm1pbmUgdGhlIHBvaW50IHR5cGUuXHJcblx0XHRcdFx0dHlwZSA9IChncm91cC5pbmRleE9mKGkpID4gLTEpID8gMSA6ICggbW9kZSA9PT0gJ3N0ZXBzJyA/IDIgOiAwICk7XHJcblxyXG5cdFx0XHRcdC8vIEVuZm9yY2UgdGhlICdpZ25vcmVGaXJzdCcgb3B0aW9uIGJ5IG92ZXJ3cml0aW5nIHRoZSB0eXBlIGZvciAwLlxyXG5cdFx0XHRcdGlmICggIWluZGV4ICYmIGlnbm9yZUZpcnN0ICkge1xyXG5cdFx0XHRcdFx0dHlwZSA9IDA7XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHRpZiAoICEoaSA9PT0gaGlnaCAmJiBpZ25vcmVMYXN0KSkge1xyXG5cdFx0XHRcdFx0Ly8gTWFyayB0aGUgJ3R5cGUnIG9mIHRoaXMgcG9pbnQuIDAgPSBwbGFpbiwgMSA9IHJlYWwgdmFsdWUsIDIgPSBzdGVwIHZhbHVlLlxyXG5cdFx0XHRcdFx0aW5kZXhlc1tuZXdQY3QudG9GaXhlZCg1KV0gPSBbaSwgdHlwZV07XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHQvLyBVcGRhdGUgdGhlIHBlcmNlbnRhZ2UgY291bnQuXHJcblx0XHRcdFx0cHJldlBjdCA9IG5ld1BjdDtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0cmV0dXJuIGluZGV4ZXM7XHJcblx0fVxyXG5cclxuXHRmdW5jdGlvbiBhZGRNYXJraW5nICggc3ByZWFkLCBmaWx0ZXJGdW5jLCBmb3JtYXR0ZXIgKSB7XHJcblxyXG5cdFx0dmFyIGVsZW1lbnQgPSBzY29wZV9Eb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcclxuXHJcblx0XHR2YXIgdmFsdWVTaXplQ2xhc3NlcyA9IFtcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLnZhbHVlTm9ybWFsLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMudmFsdWVMYXJnZSxcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLnZhbHVlU3ViXHJcblx0XHRdO1xyXG5cdFx0dmFyIG1hcmtlclNpemVDbGFzc2VzID0gW1xyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyTm9ybWFsLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyTGFyZ2UsXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy5tYXJrZXJTdWJcclxuXHRcdF07XHJcblx0XHR2YXIgdmFsdWVPcmllbnRhdGlvbkNsYXNzZXMgPSBbXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZUhvcml6b250YWwsXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZVZlcnRpY2FsXHJcblx0XHRdO1xyXG5cdFx0dmFyIG1hcmtlck9yaWVudGF0aW9uQ2xhc3NlcyA9IFtcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlckhvcml6b250YWwsXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy5tYXJrZXJWZXJ0aWNhbFxyXG5cdFx0XTtcclxuXHJcblx0XHRhZGRDbGFzcyhlbGVtZW50LCBvcHRpb25zLmNzc0NsYXNzZXMucGlwcyk7XHJcblx0XHRhZGRDbGFzcyhlbGVtZW50LCBvcHRpb25zLm9ydCA9PT0gMCA/IG9wdGlvbnMuY3NzQ2xhc3Nlcy5waXBzSG9yaXpvbnRhbCA6IG9wdGlvbnMuY3NzQ2xhc3Nlcy5waXBzVmVydGljYWwpO1xyXG5cclxuXHRcdGZ1bmN0aW9uIGdldENsYXNzZXMoIHR5cGUsIHNvdXJjZSApe1xyXG5cdFx0XHR2YXIgYSA9IHNvdXJjZSA9PT0gb3B0aW9ucy5jc3NDbGFzc2VzLnZhbHVlO1xyXG5cdFx0XHR2YXIgb3JpZW50YXRpb25DbGFzc2VzID0gYSA/IHZhbHVlT3JpZW50YXRpb25DbGFzc2VzIDogbWFya2VyT3JpZW50YXRpb25DbGFzc2VzO1xyXG5cdFx0XHR2YXIgc2l6ZUNsYXNzZXMgPSBhID8gdmFsdWVTaXplQ2xhc3NlcyA6IG1hcmtlclNpemVDbGFzc2VzO1xyXG5cclxuXHRcdFx0cmV0dXJuIHNvdXJjZSArICcgJyArIG9yaWVudGF0aW9uQ2xhc3Nlc1tvcHRpb25zLm9ydF0gKyAnICcgKyBzaXplQ2xhc3Nlc1t0eXBlXTtcclxuXHRcdH1cclxuXHJcblx0XHRmdW5jdGlvbiBhZGRTcHJlYWQgKCBvZmZzZXQsIHZhbHVlcyApe1xyXG5cclxuXHRcdFx0Ly8gQXBwbHkgdGhlIGZpbHRlciBmdW5jdGlvbiwgaWYgaXQgaXMgc2V0LlxyXG5cdFx0XHR2YWx1ZXNbMV0gPSAodmFsdWVzWzFdICYmIGZpbHRlckZ1bmMpID8gZmlsdGVyRnVuYyh2YWx1ZXNbMF0sIHZhbHVlc1sxXSkgOiB2YWx1ZXNbMV07XHJcblxyXG5cdFx0XHQvLyBBZGQgYSBtYXJrZXIgZm9yIGV2ZXJ5IHBvaW50XHJcblx0XHRcdHZhciBub2RlID0gYWRkTm9kZVRvKGVsZW1lbnQsIGZhbHNlKTtcclxuXHRcdFx0XHRub2RlLmNsYXNzTmFtZSA9IGdldENsYXNzZXModmFsdWVzWzFdLCBvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyKTtcclxuXHRcdFx0XHRub2RlLnN0eWxlW29wdGlvbnMuc3R5bGVdID0gb2Zmc2V0ICsgJyUnO1xyXG5cclxuXHRcdFx0Ly8gVmFsdWVzIGFyZSBvbmx5IGFwcGVuZGVkIGZvciBwb2ludHMgbWFya2VkICcxJyBvciAnMicuXHJcblx0XHRcdGlmICggdmFsdWVzWzFdICkge1xyXG5cdFx0XHRcdG5vZGUgPSBhZGROb2RlVG8oZWxlbWVudCwgZmFsc2UpO1xyXG5cdFx0XHRcdG5vZGUuY2xhc3NOYW1lID0gZ2V0Q2xhc3Nlcyh2YWx1ZXNbMV0sIG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZSk7XHJcblx0XHRcdFx0bm9kZS5zZXRBdHRyaWJ1dGUoJ2RhdGEtdmFsdWUnLCB2YWx1ZXNbMF0pO1xyXG5cdFx0XHRcdG5vZGUuc3R5bGVbb3B0aW9ucy5zdHlsZV0gPSBvZmZzZXQgKyAnJSc7XHJcblx0XHRcdFx0bm9kZS5pbm5lclRleHQgPSBmb3JtYXR0ZXIudG8odmFsdWVzWzBdKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEFwcGVuZCBhbGwgcG9pbnRzLlxyXG5cdFx0T2JqZWN0LmtleXMoc3ByZWFkKS5mb3JFYWNoKGZ1bmN0aW9uKGEpe1xyXG5cdFx0XHRhZGRTcHJlYWQoYSwgc3ByZWFkW2FdKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdHJldHVybiBlbGVtZW50O1xyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gcmVtb3ZlUGlwcyAoICkge1xyXG5cdFx0aWYgKCBzY29wZV9QaXBzICkge1xyXG5cdFx0XHRyZW1vdmVFbGVtZW50KHNjb3BlX1BpcHMpO1xyXG5cdFx0XHRzY29wZV9QaXBzID0gbnVsbDtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIHBpcHMgKCBncmlkICkge1xyXG5cclxuXHRcdC8vIEZpeCAjNjY5XHJcblx0XHRyZW1vdmVQaXBzKCk7XHJcblxyXG5cdFx0dmFyIG1vZGUgPSBncmlkLm1vZGU7XHJcblx0XHR2YXIgZGVuc2l0eSA9IGdyaWQuZGVuc2l0eSB8fCAxO1xyXG5cdFx0dmFyIGZpbHRlciA9IGdyaWQuZmlsdGVyIHx8IGZhbHNlO1xyXG5cdFx0dmFyIHZhbHVlcyA9IGdyaWQudmFsdWVzIHx8IGZhbHNlO1xyXG5cdFx0dmFyIHN0ZXBwZWQgPSBncmlkLnN0ZXBwZWQgfHwgZmFsc2U7XHJcblx0XHR2YXIgZ3JvdXAgPSBnZXRHcm91cCggbW9kZSwgdmFsdWVzLCBzdGVwcGVkICk7XHJcblx0XHR2YXIgc3ByZWFkID0gZ2VuZXJhdGVTcHJlYWQoIGRlbnNpdHksIG1vZGUsIGdyb3VwICk7XHJcblx0XHR2YXIgZm9ybWF0ID0gZ3JpZC5mb3JtYXQgfHwge1xyXG5cdFx0XHR0bzogTWF0aC5yb3VuZFxyXG5cdFx0fTtcclxuXHJcblx0XHRzY29wZV9QaXBzID0gc2NvcGVfVGFyZ2V0LmFwcGVuZENoaWxkKGFkZE1hcmtpbmcoXHJcblx0XHRcdHNwcmVhZCxcclxuXHRcdFx0ZmlsdGVyLFxyXG5cdFx0XHRmb3JtYXRcclxuXHRcdCkpO1xyXG5cclxuXHRcdHJldHVybiBzY29wZV9QaXBzO1xyXG5cdH1cclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IEJyb3dzZXIgZXZlbnRzIChub3Qgc2xpZGVyIGV2ZW50cyBsaWtlIHNsaWRlLCBjaGFuZ2UpOyAqL1xyXG5cclxuXHQvLyBTaG9ydGhhbmQgZm9yIGJhc2UgZGltZW5zaW9ucy5cclxuXHRmdW5jdGlvbiBiYXNlU2l6ZSAoICkge1xyXG5cdFx0dmFyIHJlY3QgPSBzY29wZV9CYXNlLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xyXG5cdFx0dmFyIGFsdCA9ICdvZmZzZXQnICsgWydXaWR0aCcsICdIZWlnaHQnXVtvcHRpb25zLm9ydF07XHJcblx0XHRyZXR1cm4gb3B0aW9ucy5vcnQgPT09IDAgPyAocmVjdC53aWR0aHx8c2NvcGVfQmFzZVthbHRdKSA6IChyZWN0LmhlaWdodHx8c2NvcGVfQmFzZVthbHRdKTtcclxuXHR9XHJcblxyXG5cdC8vIEhhbmRsZXIgZm9yIGF0dGFjaGluZyBldmVudHMgdHJvdWdoIGEgcHJveHkuXHJcblx0ZnVuY3Rpb24gYXR0YWNoRXZlbnQgKCBldmVudHMsIGVsZW1lbnQsIGNhbGxiYWNrLCBkYXRhICkge1xyXG5cclxuXHRcdC8vIFRoaXMgZnVuY3Rpb24gY2FuIGJlIHVzZWQgdG8gJ2ZpbHRlcicgZXZlbnRzIHRvIHRoZSBzbGlkZXIuXHJcblx0XHQvLyBlbGVtZW50IGlzIGEgbm9kZSwgbm90IGEgbm9kZUxpc3RcclxuXHJcblx0XHR2YXIgbWV0aG9kID0gZnVuY3Rpb24gKCBlICl7XHJcblxyXG5cdFx0XHRlID0gZml4RXZlbnQoZSwgZGF0YS5wYWdlT2Zmc2V0LCBkYXRhLnRhcmdldCB8fCBlbGVtZW50KTtcclxuXHJcblx0XHRcdC8vIGZpeEV2ZW50IHJldHVybnMgZmFsc2UgaWYgdGhpcyBldmVudCBoYXMgYSBkaWZmZXJlbnQgdGFyZ2V0XHJcblx0XHRcdC8vIHdoZW4gaGFuZGxpbmcgKG11bHRpLSkgdG91Y2ggZXZlbnRzO1xyXG5cdFx0XHRpZiAoICFlICkge1xyXG5cdFx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gZG9Ob3RSZWplY3QgaXMgcGFzc2VkIGJ5IGFsbCBlbmQgZXZlbnRzIHRvIG1ha2Ugc3VyZSByZWxlYXNlZCB0b3VjaGVzXHJcblx0XHRcdC8vIGFyZSBub3QgcmVqZWN0ZWQsIGxlYXZpbmcgdGhlIHNsaWRlciBcInN0dWNrXCIgdG8gdGhlIGN1cnNvcjtcclxuXHRcdFx0aWYgKCBzY29wZV9UYXJnZXQuaGFzQXR0cmlidXRlKCdkaXNhYmxlZCcpICYmICFkYXRhLmRvTm90UmVqZWN0ICkge1xyXG5cdFx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gU3RvcCBpZiBhbiBhY3RpdmUgJ3RhcCcgdHJhbnNpdGlvbiBpcyB0YWtpbmcgcGxhY2UuXHJcblx0XHRcdGlmICggaGFzQ2xhc3Moc2NvcGVfVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMudGFwKSAmJiAhZGF0YS5kb05vdFJlamVjdCApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIElnbm9yZSByaWdodCBvciBtaWRkbGUgY2xpY2tzIG9uIHN0YXJ0ICM0NTRcclxuXHRcdFx0aWYgKCBldmVudHMgPT09IGFjdGlvbnMuc3RhcnQgJiYgZS5idXR0b25zICE9PSB1bmRlZmluZWQgJiYgZS5idXR0b25zID4gMSApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIElnbm9yZSByaWdodCBvciBtaWRkbGUgY2xpY2tzIG9uIHN0YXJ0ICM0NTRcclxuXHRcdFx0aWYgKCBkYXRhLmhvdmVyICYmIGUuYnV0dG9ucyApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vICdzdXBwb3J0c1Bhc3NpdmUnIGlzIG9ubHkgdHJ1ZSBpZiBhIGJyb3dzZXIgYWxzbyBzdXBwb3J0cyB0b3VjaC1hY3Rpb246IG5vbmUgaW4gQ1NTLlxyXG5cdFx0XHQvLyBpT1Mgc2FmYXJpIGRvZXMgbm90LCBzbyBpdCBkb2Vzbid0IGdldCB0byBiZW5lZml0IGZyb20gcGFzc2l2ZSBzY3JvbGxpbmcuIGlPUyBkb2VzIHN1cHBvcnRcclxuXHRcdFx0Ly8gdG91Y2gtYWN0aW9uOiBtYW5pcHVsYXRpb24sIGJ1dCB0aGF0IGFsbG93cyBwYW5uaW5nLCB3aGljaCBicmVha3NcclxuXHRcdFx0Ly8gc2xpZGVycyBhZnRlciB6b29taW5nL29uIG5vbi1yZXNwb25zaXZlIHBhZ2VzLlxyXG5cdFx0XHQvLyBTZWU6IGh0dHBzOi8vYnVncy53ZWJraXQub3JnL3Nob3dfYnVnLmNnaT9pZD0xMzMxMTJcclxuXHRcdFx0aWYgKCAhc3VwcG9ydHNQYXNzaXZlICkge1xyXG5cdFx0XHRcdGUucHJldmVudERlZmF1bHQoKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0ZS5jYWxjUG9pbnQgPSBlLnBvaW50c1sgb3B0aW9ucy5vcnQgXTtcclxuXHJcblx0XHRcdC8vIENhbGwgdGhlIGV2ZW50IGhhbmRsZXIgd2l0aCB0aGUgZXZlbnQgWyBhbmQgYWRkaXRpb25hbCBkYXRhIF0uXHJcblx0XHRcdGNhbGxiYWNrICggZSwgZGF0YSApO1xyXG5cdFx0fTtcclxuXHJcblx0XHR2YXIgbWV0aG9kcyA9IFtdO1xyXG5cclxuXHRcdC8vIEJpbmQgYSBjbG9zdXJlIG9uIHRoZSB0YXJnZXQgZm9yIGV2ZXJ5IGV2ZW50IHR5cGUuXHJcblx0XHRldmVudHMuc3BsaXQoJyAnKS5mb3JFYWNoKGZ1bmN0aW9uKCBldmVudE5hbWUgKXtcclxuXHRcdFx0ZWxlbWVudC5hZGRFdmVudExpc3RlbmVyKGV2ZW50TmFtZSwgbWV0aG9kLCBzdXBwb3J0c1Bhc3NpdmUgPyB7IHBhc3NpdmU6IHRydWUgfSA6IGZhbHNlKTtcclxuXHRcdFx0bWV0aG9kcy5wdXNoKFtldmVudE5hbWUsIG1ldGhvZF0pO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0cmV0dXJuIG1ldGhvZHM7XHJcblx0fVxyXG5cclxuXHQvLyBQcm92aWRlIGEgY2xlYW4gZXZlbnQgd2l0aCBzdGFuZGFyZGl6ZWQgb2Zmc2V0IHZhbHVlcy5cclxuXHRmdW5jdGlvbiBmaXhFdmVudCAoIGUsIHBhZ2VPZmZzZXQsIGV2ZW50VGFyZ2V0ICkge1xyXG5cclxuXHRcdC8vIEZpbHRlciB0aGUgZXZlbnQgdG8gcmVnaXN0ZXIgdGhlIHR5cGUsIHdoaWNoIGNhbiBiZVxyXG5cdFx0Ly8gdG91Y2gsIG1vdXNlIG9yIHBvaW50ZXIuIE9mZnNldCBjaGFuZ2VzIG5lZWQgdG8gYmVcclxuXHRcdC8vIG1hZGUgb24gYW4gZXZlbnQgc3BlY2lmaWMgYmFzaXMuXHJcblx0XHR2YXIgdG91Y2ggPSBlLnR5cGUuaW5kZXhPZigndG91Y2gnKSA9PT0gMDtcclxuXHRcdHZhciBtb3VzZSA9IGUudHlwZS5pbmRleE9mKCdtb3VzZScpID09PSAwO1xyXG5cdFx0dmFyIHBvaW50ZXIgPSBlLnR5cGUuaW5kZXhPZigncG9pbnRlcicpID09PSAwO1xyXG5cclxuXHRcdHZhciB4O1xyXG5cdFx0dmFyIHk7XHJcblxyXG5cdFx0Ly8gSUUxMCBpbXBsZW1lbnRlZCBwb2ludGVyIGV2ZW50cyB3aXRoIGEgcHJlZml4O1xyXG5cdFx0aWYgKCBlLnR5cGUuaW5kZXhPZignTVNQb2ludGVyJykgPT09IDAgKSB7XHJcblx0XHRcdHBvaW50ZXIgPSB0cnVlO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEluIHRoZSBldmVudCB0aGF0IG11bHRpdG91Y2ggaXMgYWN0aXZhdGVkLCB0aGUgb25seSB0aGluZyBvbmUgaGFuZGxlIHNob3VsZCBiZSBjb25jZXJuZWRcclxuXHRcdC8vIGFib3V0IGlzIHRoZSB0b3VjaGVzIHRoYXQgb3JpZ2luYXRlZCBvbiB0b3Agb2YgaXQuXHJcblx0XHRpZiAoIHRvdWNoICkge1xyXG5cclxuXHRcdFx0Ly8gUmV0dXJucyB0cnVlIGlmIGEgdG91Y2ggb3JpZ2luYXRlZCBvbiB0aGUgdGFyZ2V0LlxyXG5cdFx0XHR2YXIgaXNUb3VjaE9uVGFyZ2V0ID0gZnVuY3Rpb24gKGNoZWNrVG91Y2gpIHtcclxuXHRcdFx0XHRyZXR1cm4gY2hlY2tUb3VjaC50YXJnZXQgPT09IGV2ZW50VGFyZ2V0IHx8IGV2ZW50VGFyZ2V0LmNvbnRhaW5zKGNoZWNrVG91Y2gudGFyZ2V0KTtcclxuXHRcdFx0fTtcclxuXHJcblx0XHRcdC8vIEluIHRoZSBjYXNlIG9mIHRvdWNoc3RhcnQgZXZlbnRzLCB3ZSBuZWVkIHRvIG1ha2Ugc3VyZSB0aGVyZSBpcyBzdGlsbCBubyBtb3JlIHRoYW4gb25lXHJcblx0XHRcdC8vIHRvdWNoIG9uIHRoZSB0YXJnZXQgc28gd2UgbG9vayBhbW9uZ3N0IGFsbCB0b3VjaGVzLlxyXG5cdFx0XHRpZiAoZS50eXBlID09PSAndG91Y2hzdGFydCcpIHtcclxuXHJcblx0XHRcdFx0dmFyIHRhcmdldFRvdWNoZXMgPSBBcnJheS5wcm90b3R5cGUuZmlsdGVyLmNhbGwoZS50b3VjaGVzLCBpc1RvdWNoT25UYXJnZXQpO1xyXG5cclxuXHRcdFx0XHQvLyBEbyBub3Qgc3VwcG9ydCBtb3JlIHRoYW4gb25lIHRvdWNoIHBlciBoYW5kbGUuXHJcblx0XHRcdFx0aWYgKCB0YXJnZXRUb3VjaGVzLmxlbmd0aCA+IDEgKSB7XHJcblx0XHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHR4ID0gdGFyZ2V0VG91Y2hlc1swXS5wYWdlWDtcclxuXHRcdFx0XHR5ID0gdGFyZ2V0VG91Y2hlc1swXS5wYWdlWTtcclxuXHJcblx0XHRcdH0gZWxzZSB7XHJcblxyXG5cdFx0XHRcdC8vIEluIHRoZSBvdGhlciBjYXNlcywgZmluZCBvbiBjaGFuZ2VkVG91Y2hlcyBpcyBlbm91Z2guXHJcblx0XHRcdFx0dmFyIHRhcmdldFRvdWNoID0gQXJyYXkucHJvdG90eXBlLmZpbmQuY2FsbChlLmNoYW5nZWRUb3VjaGVzLCBpc1RvdWNoT25UYXJnZXQpO1xyXG5cclxuXHRcdFx0XHQvLyBDYW5jZWwgaWYgdGhlIHRhcmdldCB0b3VjaCBoYXMgbm90IG1vdmVkLlxyXG5cdFx0XHRcdGlmICggIXRhcmdldFRvdWNoICkge1xyXG5cdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0eCA9IHRhcmdldFRvdWNoLnBhZ2VYO1xyXG5cdFx0XHRcdHkgPSB0YXJnZXRUb3VjaC5wYWdlWTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdHBhZ2VPZmZzZXQgPSBwYWdlT2Zmc2V0IHx8IGdldFBhZ2VPZmZzZXQoc2NvcGVfRG9jdW1lbnQpO1xyXG5cclxuXHRcdGlmICggbW91c2UgfHwgcG9pbnRlciApIHtcclxuXHRcdFx0eCA9IGUuY2xpZW50WCArIHBhZ2VPZmZzZXQueDtcclxuXHRcdFx0eSA9IGUuY2xpZW50WSArIHBhZ2VPZmZzZXQueTtcclxuXHRcdH1cclxuXHJcblx0XHRlLnBhZ2VPZmZzZXQgPSBwYWdlT2Zmc2V0O1xyXG5cdFx0ZS5wb2ludHMgPSBbeCwgeV07XHJcblx0XHRlLmN1cnNvciA9IG1vdXNlIHx8IHBvaW50ZXI7IC8vIEZpeCAjNDM1XHJcblxyXG5cdFx0cmV0dXJuIGU7XHJcblx0fVxyXG5cclxuXHQvLyBUcmFuc2xhdGUgYSBjb29yZGluYXRlIGluIHRoZSBkb2N1bWVudCB0byBhIHBlcmNlbnRhZ2Ugb24gdGhlIHNsaWRlclxyXG5cdGZ1bmN0aW9uIGNhbGNQb2ludFRvUGVyY2VudGFnZSAoIGNhbGNQb2ludCApIHtcclxuXHRcdHZhciBsb2NhdGlvbiA9IGNhbGNQb2ludCAtIG9mZnNldChzY29wZV9CYXNlLCBvcHRpb25zLm9ydCk7XHJcblx0XHR2YXIgcHJvcG9zYWwgPSAoIGxvY2F0aW9uICogMTAwICkgLyBiYXNlU2l6ZSgpO1xyXG5cclxuXHRcdC8vIENsYW1wIHByb3Bvc2FsIGJldHdlZW4gMCUgYW5kIDEwMCVcclxuXHRcdC8vIE91dC1vZi1ib3VuZCBjb29yZGluYXRlcyBtYXkgb2NjdXIgd2hlbiAubm9VaS1iYXNlIHBzZXVkby1lbGVtZW50c1xyXG5cdFx0Ly8gYXJlIHVzZWQgKGUuZy4gY29udGFpbmVkIGhhbmRsZXMgZmVhdHVyZSlcclxuXHRcdHByb3Bvc2FsID0gbGltaXQocHJvcG9zYWwpO1xyXG5cclxuXHRcdHJldHVybiBvcHRpb25zLmRpciA/IDEwMCAtIHByb3Bvc2FsIDogcHJvcG9zYWw7XHJcblx0fVxyXG5cclxuXHQvLyBGaW5kIGhhbmRsZSBjbG9zZXN0IHRvIGEgY2VydGFpbiBwZXJjZW50YWdlIG9uIHRoZSBzbGlkZXJcclxuXHRmdW5jdGlvbiBnZXRDbG9zZXN0SGFuZGxlICggcHJvcG9zYWwgKSB7XHJcblxyXG5cdFx0dmFyIGNsb3Nlc3QgPSAxMDA7XHJcblx0XHR2YXIgaGFuZGxlTnVtYmVyID0gZmFsc2U7XHJcblxyXG5cdFx0c2NvcGVfSGFuZGxlcy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZSwgaW5kZXgpe1xyXG5cclxuXHRcdFx0Ly8gRGlzYWJsZWQgaGFuZGxlcyBhcmUgaWdub3JlZFxyXG5cdFx0XHRpZiAoIGhhbmRsZS5oYXNBdHRyaWJ1dGUoJ2Rpc2FibGVkJykgKSB7XHJcblx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHR2YXIgcG9zID0gTWF0aC5hYnMoc2NvcGVfTG9jYXRpb25zW2luZGV4XSAtIHByb3Bvc2FsKTtcclxuXHJcblx0XHRcdGlmICggcG9zIDwgY2xvc2VzdCB8fCAocG9zID09PSAxMDAgJiYgY2xvc2VzdCA9PT0gMTAwKSApIHtcclxuXHRcdFx0XHRoYW5kbGVOdW1iZXIgPSBpbmRleDtcclxuXHRcdFx0XHRjbG9zZXN0ID0gcG9zO1xyXG5cdFx0XHR9XHJcblx0XHR9KTtcclxuXHJcblx0XHRyZXR1cm4gaGFuZGxlTnVtYmVyO1xyXG5cdH1cclxuXHJcblx0Ly8gRmlyZSAnZW5kJyB3aGVuIGEgbW91c2Ugb3IgcGVuIGxlYXZlcyB0aGUgZG9jdW1lbnQuXHJcblx0ZnVuY3Rpb24gZG9jdW1lbnRMZWF2ZSAoIGV2ZW50LCBkYXRhICkge1xyXG5cdFx0aWYgKCBldmVudC50eXBlID09PSBcIm1vdXNlb3V0XCIgJiYgZXZlbnQudGFyZ2V0Lm5vZGVOYW1lID09PSBcIkhUTUxcIiAmJiBldmVudC5yZWxhdGVkVGFyZ2V0ID09PSBudWxsICl7XHJcblx0XHRcdGV2ZW50RW5kIChldmVudCwgZGF0YSk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQvLyBIYW5kbGUgbW92ZW1lbnQgb24gZG9jdW1lbnQgZm9yIGhhbmRsZSBhbmQgcmFuZ2UgZHJhZy5cclxuXHRmdW5jdGlvbiBldmVudE1vdmUgKCBldmVudCwgZGF0YSApIHtcclxuXHJcblx0XHQvLyBGaXggIzQ5OFxyXG5cdFx0Ly8gQ2hlY2sgdmFsdWUgb2YgLmJ1dHRvbnMgaW4gJ3N0YXJ0JyB0byB3b3JrIGFyb3VuZCBhIGJ1ZyBpbiBJRTEwIG1vYmlsZSAoZGF0YS5idXR0b25zUHJvcGVydHkpLlxyXG5cdFx0Ly8gaHR0cHM6Ly9jb25uZWN0Lm1pY3Jvc29mdC5jb20vSUUvZmVlZGJhY2svZGV0YWlscy85MjcwMDUvbW9iaWxlLWllMTAtd2luZG93cy1waG9uZS1idXR0b25zLXByb3BlcnR5LW9mLXBvaW50ZXJtb3ZlLWV2ZW50LWFsd2F5cy16ZXJvXHJcblx0XHQvLyBJRTkgaGFzIC5idXR0b25zIGFuZCAud2hpY2ggemVybyBvbiBtb3VzZW1vdmUuXHJcblx0XHQvLyBGaXJlZm94IGJyZWFrcyB0aGUgc3BlYyBNRE4gZGVmaW5lcy5cclxuXHRcdGlmICggbmF2aWdhdG9yLmFwcFZlcnNpb24uaW5kZXhPZihcIk1TSUUgOVwiKSA9PT0gLTEgJiYgZXZlbnQuYnV0dG9ucyA9PT0gMCAmJiBkYXRhLmJ1dHRvbnNQcm9wZXJ0eSAhPT0gMCApIHtcclxuXHRcdFx0cmV0dXJuIGV2ZW50RW5kKGV2ZW50LCBkYXRhKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBDaGVjayBpZiB3ZSBhcmUgbW92aW5nIHVwIG9yIGRvd25cclxuXHRcdHZhciBtb3ZlbWVudCA9IChvcHRpb25zLmRpciA/IC0xIDogMSkgKiAoZXZlbnQuY2FsY1BvaW50IC0gZGF0YS5zdGFydENhbGNQb2ludCk7XHJcblxyXG5cdFx0Ly8gQ29udmVydCB0aGUgbW92ZW1lbnQgaW50byBhIHBlcmNlbnRhZ2Ugb2YgdGhlIHNsaWRlciB3aWR0aC9oZWlnaHRcclxuXHRcdHZhciBwcm9wb3NhbCA9IChtb3ZlbWVudCAqIDEwMCkgLyBkYXRhLmJhc2VTaXplO1xyXG5cclxuXHRcdG1vdmVIYW5kbGVzKG1vdmVtZW50ID4gMCwgcHJvcG9zYWwsIGRhdGEubG9jYXRpb25zLCBkYXRhLmhhbmRsZU51bWJlcnMpO1xyXG5cdH1cclxuXHJcblx0Ly8gVW5iaW5kIG1vdmUgZXZlbnRzIG9uIGRvY3VtZW50LCBjYWxsIGNhbGxiYWNrcy5cclxuXHRmdW5jdGlvbiBldmVudEVuZCAoIGV2ZW50LCBkYXRhICkge1xyXG5cclxuXHRcdC8vIFRoZSBoYW5kbGUgaXMgbm8gbG9uZ2VyIGFjdGl2ZSwgc28gcmVtb3ZlIHRoZSBjbGFzcy5cclxuXHRcdGlmICggZGF0YS5oYW5kbGUgKSB7XHJcblx0XHRcdHJlbW92ZUNsYXNzKGRhdGEuaGFuZGxlLCBvcHRpb25zLmNzc0NsYXNzZXMuYWN0aXZlKTtcclxuXHRcdFx0c2NvcGVfQWN0aXZlSGFuZGxlc0NvdW50IC09IDE7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gVW5iaW5kIHRoZSBtb3ZlIGFuZCBlbmQgZXZlbnRzLCB3aGljaCBhcmUgYWRkZWQgb24gJ3N0YXJ0Jy5cclxuXHRcdGRhdGEubGlzdGVuZXJzLmZvckVhY2goZnVuY3Rpb24oIGMgKSB7XHJcblx0XHRcdHNjb3BlX0RvY3VtZW50RWxlbWVudC5yZW1vdmVFdmVudExpc3RlbmVyKGNbMF0sIGNbMV0pO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0aWYgKCBzY29wZV9BY3RpdmVIYW5kbGVzQ291bnQgPT09IDAgKSB7XHJcblx0XHRcdC8vIFJlbW92ZSBkcmFnZ2luZyBjbGFzcy5cclxuXHRcdFx0cmVtb3ZlQ2xhc3Moc2NvcGVfVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMuZHJhZyk7XHJcblx0XHRcdHNldFppbmRleCgpO1xyXG5cclxuXHRcdFx0Ly8gUmVtb3ZlIGN1cnNvciBzdHlsZXMgYW5kIHRleHQtc2VsZWN0aW9uIGV2ZW50cyBib3VuZCB0byB0aGUgYm9keS5cclxuXHRcdFx0aWYgKCBldmVudC5jdXJzb3IgKSB7XHJcblx0XHRcdFx0c2NvcGVfQm9keS5zdHlsZS5jdXJzb3IgPSAnJztcclxuXHRcdFx0XHRzY29wZV9Cb2R5LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ3NlbGVjdHN0YXJ0JywgcHJldmVudERlZmF1bHQpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblxyXG5cdFx0ZGF0YS5oYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oaGFuZGxlTnVtYmVyKXtcclxuXHRcdFx0ZmlyZUV2ZW50KCdjaGFuZ2UnLCBoYW5kbGVOdW1iZXIpO1xyXG5cdFx0XHRmaXJlRXZlbnQoJ3NldCcsIGhhbmRsZU51bWJlcik7XHJcblx0XHRcdGZpcmVFdmVudCgnZW5kJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gQmluZCBtb3ZlIGV2ZW50cyBvbiBkb2N1bWVudC5cclxuXHRmdW5jdGlvbiBldmVudFN0YXJ0ICggZXZlbnQsIGRhdGEgKSB7XHJcblxyXG5cdFx0dmFyIGhhbmRsZTtcclxuXHRcdGlmICggZGF0YS5oYW5kbGVOdW1iZXJzLmxlbmd0aCA9PT0gMSApIHtcclxuXHJcblx0XHRcdHZhciBoYW5kbGVPcmlnaW4gPSBzY29wZV9IYW5kbGVzW2RhdGEuaGFuZGxlTnVtYmVyc1swXV07XHJcblxyXG5cdFx0XHQvLyBJZ25vcmUgJ2Rpc2FibGVkJyBoYW5kbGVzXHJcblx0XHRcdGlmICggaGFuZGxlT3JpZ2luLmhhc0F0dHJpYnV0ZSgnZGlzYWJsZWQnKSApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGhhbmRsZSA9IGhhbmRsZU9yaWdpbi5jaGlsZHJlblswXTtcclxuXHRcdFx0c2NvcGVfQWN0aXZlSGFuZGxlc0NvdW50ICs9IDE7XHJcblxyXG5cdFx0XHQvLyBNYXJrIHRoZSBoYW5kbGUgYXMgJ2FjdGl2ZScgc28gaXQgY2FuIGJlIHN0eWxlZC5cclxuXHRcdFx0YWRkQ2xhc3MoaGFuZGxlLCBvcHRpb25zLmNzc0NsYXNzZXMuYWN0aXZlKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBBIGRyYWcgc2hvdWxkIG5ldmVyIHByb3BhZ2F0ZSB1cCB0byB0aGUgJ3RhcCcgZXZlbnQuXHJcblx0XHRldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcclxuXHJcblx0XHQvLyBSZWNvcmQgdGhlIGV2ZW50IGxpc3RlbmVycy5cclxuXHRcdHZhciBsaXN0ZW5lcnMgPSBbXTtcclxuXHJcblx0XHQvLyBBdHRhY2ggdGhlIG1vdmUgYW5kIGVuZCBldmVudHMuXHJcblx0XHR2YXIgbW92ZUV2ZW50ID0gYXR0YWNoRXZlbnQoYWN0aW9ucy5tb3ZlLCBzY29wZV9Eb2N1bWVudEVsZW1lbnQsIGV2ZW50TW92ZSwge1xyXG5cdFx0XHQvLyBUaGUgZXZlbnQgdGFyZ2V0IGhhcyBjaGFuZ2VkIHNvIHdlIG5lZWQgdG8gcHJvcGFnYXRlIHRoZSBvcmlnaW5hbCBvbmUgc28gdGhhdCB3ZSBrZWVwXHJcblx0XHRcdC8vIHJlbHlpbmcgb24gaXQgdG8gZXh0cmFjdCB0YXJnZXQgdG91Y2hlcy5cclxuXHRcdFx0dGFyZ2V0OiBldmVudC50YXJnZXQsXHJcblx0XHRcdGhhbmRsZTogaGFuZGxlLFxyXG5cdFx0XHRsaXN0ZW5lcnM6IGxpc3RlbmVycyxcclxuXHRcdFx0c3RhcnRDYWxjUG9pbnQ6IGV2ZW50LmNhbGNQb2ludCxcclxuXHRcdFx0YmFzZVNpemU6IGJhc2VTaXplKCksXHJcblx0XHRcdHBhZ2VPZmZzZXQ6IGV2ZW50LnBhZ2VPZmZzZXQsXHJcblx0XHRcdGhhbmRsZU51bWJlcnM6IGRhdGEuaGFuZGxlTnVtYmVycyxcclxuXHRcdFx0YnV0dG9uc1Byb3BlcnR5OiBldmVudC5idXR0b25zLFxyXG5cdFx0XHRsb2NhdGlvbnM6IHNjb3BlX0xvY2F0aW9ucy5zbGljZSgpXHJcblx0XHR9KTtcclxuXHJcblx0XHR2YXIgZW5kRXZlbnQgPSBhdHRhY2hFdmVudChhY3Rpb25zLmVuZCwgc2NvcGVfRG9jdW1lbnRFbGVtZW50LCBldmVudEVuZCwge1xyXG5cdFx0XHR0YXJnZXQ6IGV2ZW50LnRhcmdldCxcclxuXHRcdFx0aGFuZGxlOiBoYW5kbGUsXHJcblx0XHRcdGxpc3RlbmVyczogbGlzdGVuZXJzLFxyXG5cdFx0XHRkb05vdFJlamVjdDogdHJ1ZSxcclxuXHRcdFx0aGFuZGxlTnVtYmVyczogZGF0YS5oYW5kbGVOdW1iZXJzXHJcblx0XHR9KTtcclxuXHJcblx0XHR2YXIgb3V0RXZlbnQgPSBhdHRhY2hFdmVudChcIm1vdXNlb3V0XCIsIHNjb3BlX0RvY3VtZW50RWxlbWVudCwgZG9jdW1lbnRMZWF2ZSwge1xyXG5cdFx0XHR0YXJnZXQ6IGV2ZW50LnRhcmdldCxcclxuXHRcdFx0aGFuZGxlOiBoYW5kbGUsXHJcblx0XHRcdGxpc3RlbmVyczogbGlzdGVuZXJzLFxyXG5cdFx0XHRkb05vdFJlamVjdDogdHJ1ZSxcclxuXHRcdFx0aGFuZGxlTnVtYmVyczogZGF0YS5oYW5kbGVOdW1iZXJzXHJcblx0XHR9KTtcclxuXHJcblx0XHQvLyBXZSB3YW50IHRvIG1ha2Ugc3VyZSB3ZSBwdXNoZWQgdGhlIGxpc3RlbmVycyBpbiB0aGUgbGlzdGVuZXIgbGlzdCByYXRoZXIgdGhhbiBjcmVhdGluZ1xyXG5cdFx0Ly8gYSBuZXcgb25lIGFzIGl0IGhhcyBhbHJlYWR5IGJlZW4gcGFzc2VkIHRvIHRoZSBldmVudCBoYW5kbGVycy5cclxuXHRcdGxpc3RlbmVycy5wdXNoLmFwcGx5KGxpc3RlbmVycywgbW92ZUV2ZW50LmNvbmNhdChlbmRFdmVudCwgb3V0RXZlbnQpKTtcclxuXHJcblx0XHQvLyBUZXh0IHNlbGVjdGlvbiBpc24ndCBhbiBpc3N1ZSBvbiB0b3VjaCBkZXZpY2VzLFxyXG5cdFx0Ly8gc28gYWRkaW5nIGN1cnNvciBzdHlsZXMgY2FuIGJlIHNraXBwZWQuXHJcblx0XHRpZiAoIGV2ZW50LmN1cnNvciApIHtcclxuXHJcblx0XHRcdC8vIFByZXZlbnQgdGhlICdJJyBjdXJzb3IgYW5kIGV4dGVuZCB0aGUgcmFuZ2UtZHJhZyBjdXJzb3IuXHJcblx0XHRcdHNjb3BlX0JvZHkuc3R5bGUuY3Vyc29yID0gZ2V0Q29tcHV0ZWRTdHlsZShldmVudC50YXJnZXQpLmN1cnNvcjtcclxuXHJcblx0XHRcdC8vIE1hcmsgdGhlIHRhcmdldCB3aXRoIGEgZHJhZ2dpbmcgc3RhdGUuXHJcblx0XHRcdGlmICggc2NvcGVfSGFuZGxlcy5sZW5ndGggPiAxICkge1xyXG5cdFx0XHRcdGFkZENsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmRyYWcpO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBQcmV2ZW50IHRleHQgc2VsZWN0aW9uIHdoZW4gZHJhZ2dpbmcgdGhlIGhhbmRsZXMuXHJcblx0XHRcdC8vIEluIG5vVWlTbGlkZXIgPD0gOS4yLjAsIHRoaXMgd2FzIGhhbmRsZWQgYnkgY2FsbGluZyBwcmV2ZW50RGVmYXVsdCBvbiBtb3VzZS90b3VjaCBzdGFydC9tb3ZlLFxyXG5cdFx0XHQvLyB3aGljaCBpcyBzY3JvbGwgYmxvY2tpbmcuIFRoZSBzZWxlY3RzdGFydCBldmVudCBpcyBzdXBwb3J0ZWQgYnkgRmlyZUZveCBzdGFydGluZyBmcm9tIHZlcnNpb24gNTIsXHJcblx0XHRcdC8vIG1lYW5pbmcgdGhlIG9ubHkgaG9sZG91dCBpcyBpT1MgU2FmYXJpLiBUaGlzIGRvZXNuJ3QgbWF0dGVyOiB0ZXh0IHNlbGVjdGlvbiBpc24ndCB0cmlnZ2VyZWQgdGhlcmUuXHJcblx0XHRcdC8vIFRoZSAnY3Vyc29yJyBmbGFnIGlzIGZhbHNlLlxyXG5cdFx0XHQvLyBTZWU6IGh0dHA6Ly9jYW5pdXNlLmNvbS8jc2VhcmNoPXNlbGVjdHN0YXJ0XHJcblx0XHRcdHNjb3BlX0JvZHkuYWRkRXZlbnRMaXN0ZW5lcignc2VsZWN0c3RhcnQnLCBwcmV2ZW50RGVmYXVsdCwgZmFsc2UpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGRhdGEuaGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdGZpcmVFdmVudCgnc3RhcnQnLCBoYW5kbGVOdW1iZXIpO1xyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBNb3ZlIGNsb3Nlc3QgaGFuZGxlIHRvIHRhcHBlZCBsb2NhdGlvbi5cclxuXHRmdW5jdGlvbiBldmVudFRhcCAoIGV2ZW50ICkge1xyXG5cclxuXHRcdC8vIFRoZSB0YXAgZXZlbnQgc2hvdWxkbid0IHByb3BhZ2F0ZSB1cFxyXG5cdFx0ZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XHJcblxyXG5cdFx0dmFyIHByb3Bvc2FsID0gY2FsY1BvaW50VG9QZXJjZW50YWdlKGV2ZW50LmNhbGNQb2ludCk7XHJcblx0XHR2YXIgaGFuZGxlTnVtYmVyID0gZ2V0Q2xvc2VzdEhhbmRsZShwcm9wb3NhbCk7XHJcblxyXG5cdFx0Ly8gVGFja2xlIHRoZSBjYXNlIHRoYXQgYWxsIGhhbmRsZXMgYXJlICdkaXNhYmxlZCcuXHJcblx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gZmFsc2UgKSB7XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBGbGFnIHRoZSBzbGlkZXIgYXMgaXQgaXMgbm93IGluIGEgdHJhbnNpdGlvbmFsIHN0YXRlLlxyXG5cdFx0Ly8gVHJhbnNpdGlvbiB0YWtlcyBhIGNvbmZpZ3VyYWJsZSBhbW91bnQgb2YgbXMgKGRlZmF1bHQgMzAwKS4gUmUtZW5hYmxlIHRoZSBzbGlkZXIgYWZ0ZXIgdGhhdC5cclxuXHRcdGlmICggIW9wdGlvbnMuZXZlbnRzLnNuYXAgKSB7XHJcblx0XHRcdGFkZENsYXNzRm9yKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLnRhcCwgb3B0aW9ucy5hbmltYXRpb25EdXJhdGlvbik7XHJcblx0XHR9XHJcblxyXG5cdFx0c2V0SGFuZGxlKGhhbmRsZU51bWJlciwgcHJvcG9zYWwsIHRydWUsIHRydWUpO1xyXG5cclxuXHRcdHNldFppbmRleCgpO1xyXG5cclxuXHRcdGZpcmVFdmVudCgnc2xpZGUnLCBoYW5kbGVOdW1iZXIsIHRydWUpO1xyXG5cdFx0ZmlyZUV2ZW50KCd1cGRhdGUnLCBoYW5kbGVOdW1iZXIsIHRydWUpO1xyXG5cdFx0ZmlyZUV2ZW50KCdjaGFuZ2UnLCBoYW5kbGVOdW1iZXIsIHRydWUpO1xyXG5cdFx0ZmlyZUV2ZW50KCdzZXQnLCBoYW5kbGVOdW1iZXIsIHRydWUpO1xyXG5cclxuXHRcdGlmICggb3B0aW9ucy5ldmVudHMuc25hcCApIHtcclxuXHRcdFx0ZXZlbnRTdGFydChldmVudCwgeyBoYW5kbGVOdW1iZXJzOiBbaGFuZGxlTnVtYmVyXSB9KTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8vIEZpcmVzIGEgJ2hvdmVyJyBldmVudCBmb3IgYSBob3ZlcmVkIG1vdXNlL3BlbiBwb3NpdGlvbi5cclxuXHRmdW5jdGlvbiBldmVudEhvdmVyICggZXZlbnQgKSB7XHJcblxyXG5cdFx0dmFyIHByb3Bvc2FsID0gY2FsY1BvaW50VG9QZXJjZW50YWdlKGV2ZW50LmNhbGNQb2ludCk7XHJcblxyXG5cdFx0dmFyIHRvID0gc2NvcGVfU3BlY3RydW0uZ2V0U3RlcChwcm9wb3NhbCk7XHJcblx0XHR2YXIgdmFsdWUgPSBzY29wZV9TcGVjdHJ1bS5mcm9tU3RlcHBpbmcodG8pO1xyXG5cclxuXHRcdE9iamVjdC5rZXlzKHNjb3BlX0V2ZW50cykuZm9yRWFjaChmdW5jdGlvbiggdGFyZ2V0RXZlbnQgKSB7XHJcblx0XHRcdGlmICggJ2hvdmVyJyA9PT0gdGFyZ2V0RXZlbnQuc3BsaXQoJy4nKVswXSApIHtcclxuXHRcdFx0XHRzY29wZV9FdmVudHNbdGFyZ2V0RXZlbnRdLmZvckVhY2goZnVuY3Rpb24oIGNhbGxiYWNrICkge1xyXG5cdFx0XHRcdFx0Y2FsbGJhY2suY2FsbCggc2NvcGVfU2VsZiwgdmFsdWUgKTtcclxuXHRcdFx0XHR9KTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBBdHRhY2ggZXZlbnRzIHRvIHNldmVyYWwgc2xpZGVyIHBhcnRzLlxyXG5cdGZ1bmN0aW9uIGJpbmRTbGlkZXJFdmVudHMgKCBiZWhhdmlvdXIgKSB7XHJcblxyXG5cdFx0Ly8gQXR0YWNoIHRoZSBzdGFuZGFyZCBkcmFnIGV2ZW50IHRvIHRoZSBoYW5kbGVzLlxyXG5cdFx0aWYgKCAhYmVoYXZpb3VyLmZpeGVkICkge1xyXG5cclxuXHRcdFx0c2NvcGVfSGFuZGxlcy5mb3JFYWNoKGZ1bmN0aW9uKCBoYW5kbGUsIGluZGV4ICl7XHJcblxyXG5cdFx0XHRcdC8vIFRoZXNlIGV2ZW50cyBhcmUgb25seSBib3VuZCB0byB0aGUgdmlzdWFsIGhhbmRsZVxyXG5cdFx0XHRcdC8vIGVsZW1lbnQsIG5vdCB0aGUgJ3JlYWwnIG9yaWdpbiBlbGVtZW50LlxyXG5cdFx0XHRcdGF0dGFjaEV2ZW50ICggYWN0aW9ucy5zdGFydCwgaGFuZGxlLmNoaWxkcmVuWzBdLCBldmVudFN0YXJ0LCB7XHJcblx0XHRcdFx0XHRoYW5kbGVOdW1iZXJzOiBbaW5kZXhdXHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdH0pO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEF0dGFjaCB0aGUgdGFwIGV2ZW50IHRvIHRoZSBzbGlkZXIgYmFzZS5cclxuXHRcdGlmICggYmVoYXZpb3VyLnRhcCApIHtcclxuXHRcdFx0YXR0YWNoRXZlbnQgKGFjdGlvbnMuc3RhcnQsIHNjb3BlX0Jhc2UsIGV2ZW50VGFwLCB7fSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gRmlyZSBob3ZlciBldmVudHNcclxuXHRcdGlmICggYmVoYXZpb3VyLmhvdmVyICkge1xyXG5cdFx0XHRhdHRhY2hFdmVudCAoYWN0aW9ucy5tb3ZlLCBzY29wZV9CYXNlLCBldmVudEhvdmVyLCB7IGhvdmVyOiB0cnVlIH0pO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIE1ha2UgdGhlIHJhbmdlIGRyYWdnYWJsZS5cclxuXHRcdGlmICggYmVoYXZpb3VyLmRyYWcgKXtcclxuXHJcblx0XHRcdHNjb3BlX0Nvbm5lY3RzLmZvckVhY2goZnVuY3Rpb24oIGNvbm5lY3QsIGluZGV4ICl7XHJcblxyXG5cdFx0XHRcdGlmICggY29ubmVjdCA9PT0gZmFsc2UgfHwgaW5kZXggPT09IDAgfHwgaW5kZXggPT09IHNjb3BlX0Nvbm5lY3RzLmxlbmd0aCAtIDEgKSB7XHJcblx0XHRcdFx0XHRyZXR1cm47XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0XHR2YXIgaGFuZGxlQmVmb3JlID0gc2NvcGVfSGFuZGxlc1tpbmRleCAtIDFdO1xyXG5cdFx0XHRcdHZhciBoYW5kbGVBZnRlciA9IHNjb3BlX0hhbmRsZXNbaW5kZXhdO1xyXG5cdFx0XHRcdHZhciBldmVudEhvbGRlcnMgPSBbY29ubmVjdF07XHJcblxyXG5cdFx0XHRcdGFkZENsYXNzKGNvbm5lY3QsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5kcmFnZ2FibGUpO1xyXG5cclxuXHRcdFx0XHQvLyBXaGVuIHRoZSByYW5nZSBpcyBmaXhlZCwgdGhlIGVudGlyZSByYW5nZSBjYW5cclxuXHRcdFx0XHQvLyBiZSBkcmFnZ2VkIGJ5IHRoZSBoYW5kbGVzLiBUaGUgaGFuZGxlIGluIHRoZSBmaXJzdFxyXG5cdFx0XHRcdC8vIG9yaWdpbiB3aWxsIHByb3BhZ2F0ZSB0aGUgc3RhcnQgZXZlbnQgdXB3YXJkLFxyXG5cdFx0XHRcdC8vIGJ1dCBpdCBuZWVkcyB0byBiZSBib3VuZCBtYW51YWxseSBvbiB0aGUgb3RoZXIuXHJcblx0XHRcdFx0aWYgKCBiZWhhdmlvdXIuZml4ZWQgKSB7XHJcblx0XHRcdFx0XHRldmVudEhvbGRlcnMucHVzaChoYW5kbGVCZWZvcmUuY2hpbGRyZW5bMF0pO1xyXG5cdFx0XHRcdFx0ZXZlbnRIb2xkZXJzLnB1c2goaGFuZGxlQWZ0ZXIuY2hpbGRyZW5bMF0pO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0ZXZlbnRIb2xkZXJzLmZvckVhY2goZnVuY3Rpb24oIGV2ZW50SG9sZGVyICkge1xyXG5cdFx0XHRcdFx0YXR0YWNoRXZlbnQgKCBhY3Rpb25zLnN0YXJ0LCBldmVudEhvbGRlciwgZXZlbnRTdGFydCwge1xyXG5cdFx0XHRcdFx0XHRoYW5kbGVzOiBbaGFuZGxlQmVmb3JlLCBoYW5kbGVBZnRlcl0sXHJcblx0XHRcdFx0XHRcdGhhbmRsZU51bWJlcnM6IFtpbmRleCAtIDEsIGluZGV4XVxyXG5cdFx0XHRcdFx0fSk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdH0pO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IFNsaWRlciBldmVudHMgKG5vdCBicm93c2VyIGV2ZW50cyk7ICovXHJcblxyXG5cdC8vIEF0dGFjaCBhbiBldmVudCB0byB0aGlzIHNsaWRlciwgcG9zc2libHkgaW5jbHVkaW5nIGEgbmFtZXNwYWNlXHJcblx0ZnVuY3Rpb24gYmluZEV2ZW50ICggbmFtZXNwYWNlZEV2ZW50LCBjYWxsYmFjayApIHtcclxuXHRcdHNjb3BlX0V2ZW50c1tuYW1lc3BhY2VkRXZlbnRdID0gc2NvcGVfRXZlbnRzW25hbWVzcGFjZWRFdmVudF0gfHwgW107XHJcblx0XHRzY29wZV9FdmVudHNbbmFtZXNwYWNlZEV2ZW50XS5wdXNoKGNhbGxiYWNrKTtcclxuXHJcblx0XHQvLyBJZiB0aGUgZXZlbnQgYm91bmQgaXMgJ3VwZGF0ZSwnIGZpcmUgaXQgaW1tZWRpYXRlbHkgZm9yIGFsbCBoYW5kbGVzLlxyXG5cdFx0aWYgKCBuYW1lc3BhY2VkRXZlbnQuc3BsaXQoJy4nKVswXSA9PT0gJ3VwZGF0ZScgKSB7XHJcblx0XHRcdHNjb3BlX0hhbmRsZXMuZm9yRWFjaChmdW5jdGlvbihhLCBpbmRleCl7XHJcblx0XHRcdFx0ZmlyZUV2ZW50KCd1cGRhdGUnLCBpbmRleCk7XHJcblx0XHRcdH0pO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0Ly8gVW5kbyBhdHRhY2htZW50IG9mIGV2ZW50XHJcblx0ZnVuY3Rpb24gcmVtb3ZlRXZlbnQgKCBuYW1lc3BhY2VkRXZlbnQgKSB7XHJcblxyXG5cdFx0dmFyIGV2ZW50ID0gbmFtZXNwYWNlZEV2ZW50ICYmIG5hbWVzcGFjZWRFdmVudC5zcGxpdCgnLicpWzBdO1xyXG5cdFx0dmFyIG5hbWVzcGFjZSA9IGV2ZW50ICYmIG5hbWVzcGFjZWRFdmVudC5zdWJzdHJpbmcoZXZlbnQubGVuZ3RoKTtcclxuXHJcblx0XHRPYmplY3Qua2V5cyhzY29wZV9FdmVudHMpLmZvckVhY2goZnVuY3Rpb24oIGJpbmQgKXtcclxuXHJcblx0XHRcdHZhciB0RXZlbnQgPSBiaW5kLnNwbGl0KCcuJylbMF07XHJcblx0XHRcdHZhciB0TmFtZXNwYWNlID0gYmluZC5zdWJzdHJpbmcodEV2ZW50Lmxlbmd0aCk7XHJcblxyXG5cdFx0XHRpZiAoICghZXZlbnQgfHwgZXZlbnQgPT09IHRFdmVudCkgJiYgKCFuYW1lc3BhY2UgfHwgbmFtZXNwYWNlID09PSB0TmFtZXNwYWNlKSApIHtcclxuXHRcdFx0XHRkZWxldGUgc2NvcGVfRXZlbnRzW2JpbmRdO1xyXG5cdFx0XHR9XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cdC8vIEV4dGVybmFsIGV2ZW50IGhhbmRsaW5nXHJcblx0ZnVuY3Rpb24gZmlyZUV2ZW50ICggZXZlbnROYW1lLCBoYW5kbGVOdW1iZXIsIHRhcCApIHtcclxuXHJcblx0XHRPYmplY3Qua2V5cyhzY29wZV9FdmVudHMpLmZvckVhY2goZnVuY3Rpb24oIHRhcmdldEV2ZW50ICkge1xyXG5cclxuXHRcdFx0dmFyIGV2ZW50VHlwZSA9IHRhcmdldEV2ZW50LnNwbGl0KCcuJylbMF07XHJcblxyXG5cdFx0XHRpZiAoIGV2ZW50TmFtZSA9PT0gZXZlbnRUeXBlICkge1xyXG5cdFx0XHRcdHNjb3BlX0V2ZW50c1t0YXJnZXRFdmVudF0uZm9yRWFjaChmdW5jdGlvbiggY2FsbGJhY2sgKSB7XHJcblxyXG5cdFx0XHRcdFx0Y2FsbGJhY2suY2FsbChcclxuXHRcdFx0XHRcdFx0Ly8gVXNlIHRoZSBzbGlkZXIgcHVibGljIEFQSSBhcyB0aGUgc2NvcGUgKCd0aGlzJylcclxuXHRcdFx0XHRcdFx0c2NvcGVfU2VsZixcclxuXHRcdFx0XHRcdFx0Ly8gUmV0dXJuIHZhbHVlcyBhcyBhcnJheSwgc28gYXJnXzFbYXJnXzJdIGlzIGFsd2F5cyB2YWxpZC5cclxuXHRcdFx0XHRcdFx0c2NvcGVfVmFsdWVzLm1hcChvcHRpb25zLmZvcm1hdC50byksXHJcblx0XHRcdFx0XHRcdC8vIEhhbmRsZSBpbmRleCwgMCBvciAxXHJcblx0XHRcdFx0XHRcdGhhbmRsZU51bWJlcixcclxuXHRcdFx0XHRcdFx0Ly8gVW5mb3JtYXR0ZWQgc2xpZGVyIHZhbHVlc1xyXG5cdFx0XHRcdFx0XHRzY29wZV9WYWx1ZXMuc2xpY2UoKSxcclxuXHRcdFx0XHRcdFx0Ly8gRXZlbnQgaXMgZmlyZWQgYnkgdGFwLCB0cnVlIG9yIGZhbHNlXHJcblx0XHRcdFx0XHRcdHRhcCB8fCBmYWxzZSxcclxuXHRcdFx0XHRcdFx0Ly8gTGVmdCBvZmZzZXQgb2YgdGhlIGhhbmRsZSwgaW4gcmVsYXRpb24gdG8gdGhlIHNsaWRlclxyXG5cdFx0XHRcdFx0XHRzY29wZV9Mb2NhdGlvbnMuc2xpY2UoKVxyXG5cdFx0XHRcdFx0KTtcclxuXHRcdFx0XHR9KTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuLyohIEluIHRoaXMgZmlsZTogTWVjaGFuaWNzIGZvciBzbGlkZXIgb3BlcmF0aW9uICovXHJcblxyXG5cdGZ1bmN0aW9uIHRvUGN0ICggcGN0ICkge1xyXG5cdFx0cmV0dXJuIHBjdCArICclJztcclxuXHR9XHJcblxyXG5cdC8vIFNwbGl0IG91dCB0aGUgaGFuZGxlIHBvc2l0aW9uaW5nIGxvZ2ljIHNvIHRoZSBNb3ZlIGV2ZW50IGNhbiB1c2UgaXQsIHRvb1xyXG5cdGZ1bmN0aW9uIGNoZWNrSGFuZGxlUG9zaXRpb24gKCByZWZlcmVuY2UsIGhhbmRsZU51bWJlciwgdG8sIGxvb2tCYWNrd2FyZCwgbG9va0ZvcndhcmQsIGdldFZhbHVlICkge1xyXG5cclxuXHRcdC8vIEZvciBzbGlkZXJzIHdpdGggbXVsdGlwbGUgaGFuZGxlcywgbGltaXQgbW92ZW1lbnQgdG8gdGhlIG90aGVyIGhhbmRsZS5cclxuXHRcdC8vIEFwcGx5IHRoZSBtYXJnaW4gb3B0aW9uIGJ5IGFkZGluZyBpdCB0byB0aGUgaGFuZGxlIHBvc2l0aW9ucy5cclxuXHRcdGlmICggc2NvcGVfSGFuZGxlcy5sZW5ndGggPiAxICkge1xyXG5cclxuXHRcdFx0aWYgKCBsb29rQmFja3dhcmQgJiYgaGFuZGxlTnVtYmVyID4gMCApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWF4KHRvLCByZWZlcmVuY2VbaGFuZGxlTnVtYmVyIC0gMV0gKyBvcHRpb25zLm1hcmdpbik7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGlmICggbG9va0ZvcndhcmQgJiYgaGFuZGxlTnVtYmVyIDwgc2NvcGVfSGFuZGxlcy5sZW5ndGggLSAxICkge1xyXG5cdFx0XHRcdHRvID0gTWF0aC5taW4odG8sIHJlZmVyZW5jZVtoYW5kbGVOdW1iZXIgKyAxXSAtIG9wdGlvbnMubWFyZ2luKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFRoZSBsaW1pdCBvcHRpb24gaGFzIHRoZSBvcHBvc2l0ZSBlZmZlY3QsIGxpbWl0aW5nIGhhbmRsZXMgdG8gYVxyXG5cdFx0Ly8gbWF4aW11bSBkaXN0YW5jZSBmcm9tIGFub3RoZXIuIExpbWl0IG11c3QgYmUgPiAwLCBhcyBvdGhlcndpc2VcclxuXHRcdC8vIGhhbmRsZXMgd291bGQgYmUgdW5tb3ZlYWJsZS5cclxuXHRcdGlmICggc2NvcGVfSGFuZGxlcy5sZW5ndGggPiAxICYmIG9wdGlvbnMubGltaXQgKSB7XHJcblxyXG5cdFx0XHRpZiAoIGxvb2tCYWNrd2FyZCAmJiBoYW5kbGVOdW1iZXIgPiAwICkge1xyXG5cdFx0XHRcdHRvID0gTWF0aC5taW4odG8sIHJlZmVyZW5jZVtoYW5kbGVOdW1iZXIgLSAxXSArIG9wdGlvbnMubGltaXQpO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRpZiAoIGxvb2tGb3J3YXJkICYmIGhhbmRsZU51bWJlciA8IHNjb3BlX0hhbmRsZXMubGVuZ3RoIC0gMSApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWF4KHRvLCByZWZlcmVuY2VbaGFuZGxlTnVtYmVyICsgMV0gLSBvcHRpb25zLmxpbWl0KTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFRoZSBwYWRkaW5nIG9wdGlvbiBrZWVwcyB0aGUgaGFuZGxlcyBhIGNlcnRhaW4gZGlzdGFuY2UgZnJvbSB0aGVcclxuXHRcdC8vIGVkZ2VzIG9mIHRoZSBzbGlkZXIuIFBhZGRpbmcgbXVzdCBiZSA+IDAuXHJcblx0XHRpZiAoIG9wdGlvbnMucGFkZGluZyApIHtcclxuXHJcblx0XHRcdGlmICggaGFuZGxlTnVtYmVyID09PSAwICkge1xyXG5cdFx0XHRcdHRvID0gTWF0aC5tYXgodG8sIG9wdGlvbnMucGFkZGluZ1swXSk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGlmICggaGFuZGxlTnVtYmVyID09PSBzY29wZV9IYW5kbGVzLmxlbmd0aCAtIDEgKSB7XHJcblx0XHRcdFx0dG8gPSBNYXRoLm1pbih0bywgMTAwIC0gb3B0aW9ucy5wYWRkaW5nWzFdKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdHRvID0gc2NvcGVfU3BlY3RydW0uZ2V0U3RlcCh0byk7XHJcblxyXG5cdFx0Ly8gTGltaXQgcGVyY2VudGFnZSB0byB0aGUgMCAtIDEwMCByYW5nZVxyXG5cdFx0dG8gPSBsaW1pdCh0byk7XHJcblxyXG5cdFx0Ly8gUmV0dXJuIGZhbHNlIGlmIGhhbmRsZSBjYW4ndCBtb3ZlXHJcblx0XHRpZiAoIHRvID09PSByZWZlcmVuY2VbaGFuZGxlTnVtYmVyXSAmJiAhZ2V0VmFsdWUgKSB7XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gdG87XHJcblx0fVxyXG5cclxuXHQvLyBVc2VzIHNsaWRlciBvcmllbnRhdGlvbiB0byBjcmVhdGUgQ1NTIHJ1bGVzLiBhID0gYmFzZSB2YWx1ZTtcclxuXHRmdW5jdGlvbiBpblJ1bGVPcmRlciAoIHYsIGEgKSB7XHJcblx0XHR2YXIgbyA9IG9wdGlvbnMub3J0O1xyXG5cdFx0cmV0dXJuIChvP2E6dikgKyAnLCAnICsgKG8/djphKTtcclxuXHR9XHJcblxyXG5cdC8vIE1vdmVzIGhhbmRsZShzKSBieSBhIHBlcmNlbnRhZ2VcclxuXHQvLyAoYm9vbCwgJSB0byBtb3ZlLCBbJSB3aGVyZSBoYW5kbGUgc3RhcnRlZCwgLi4uXSwgW2luZGV4IGluIHNjb3BlX0hhbmRsZXMsIC4uLl0pXHJcblx0ZnVuY3Rpb24gbW92ZUhhbmRsZXMgKCB1cHdhcmQsIHByb3Bvc2FsLCBsb2NhdGlvbnMsIGhhbmRsZU51bWJlcnMgKSB7XHJcblxyXG5cdFx0dmFyIHByb3Bvc2FscyA9IGxvY2F0aW9ucy5zbGljZSgpO1xyXG5cclxuXHRcdHZhciBiID0gWyF1cHdhcmQsIHVwd2FyZF07XHJcblx0XHR2YXIgZiA9IFt1cHdhcmQsICF1cHdhcmRdO1xyXG5cclxuXHRcdC8vIENvcHkgaGFuZGxlTnVtYmVycyBzbyB3ZSBkb24ndCBjaGFuZ2UgdGhlIGRhdGFzZXRcclxuXHRcdGhhbmRsZU51bWJlcnMgPSBoYW5kbGVOdW1iZXJzLnNsaWNlKCk7XHJcblxyXG5cdFx0Ly8gQ2hlY2sgdG8gc2VlIHdoaWNoIGhhbmRsZSBpcyAnbGVhZGluZycuXHJcblx0XHQvLyBJZiB0aGF0IG9uZSBjYW4ndCBtb3ZlIHRoZSBzZWNvbmQgY2FuJ3QgZWl0aGVyLlxyXG5cdFx0aWYgKCB1cHdhcmQgKSB7XHJcblx0XHRcdGhhbmRsZU51bWJlcnMucmV2ZXJzZSgpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFN0ZXAgMTogZ2V0IHRoZSBtYXhpbXVtIHBlcmNlbnRhZ2UgdGhhdCBhbnkgb2YgdGhlIGhhbmRsZXMgY2FuIG1vdmVcclxuXHRcdGlmICggaGFuZGxlTnVtYmVycy5sZW5ndGggPiAxICkge1xyXG5cclxuXHRcdFx0aGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlciwgbykge1xyXG5cclxuXHRcdFx0XHR2YXIgdG8gPSBjaGVja0hhbmRsZVBvc2l0aW9uKHByb3Bvc2FscywgaGFuZGxlTnVtYmVyLCBwcm9wb3NhbHNbaGFuZGxlTnVtYmVyXSArIHByb3Bvc2FsLCBiW29dLCBmW29dLCBmYWxzZSk7XHJcblxyXG5cdFx0XHRcdC8vIFN0b3AgaWYgb25lIG9mIHRoZSBoYW5kbGVzIGNhbid0IG1vdmUuXHJcblx0XHRcdFx0aWYgKCB0byA9PT0gZmFsc2UgKSB7XHJcblx0XHRcdFx0XHRwcm9wb3NhbCA9IDA7XHJcblx0XHRcdFx0fSBlbHNlIHtcclxuXHRcdFx0XHRcdHByb3Bvc2FsID0gdG8gLSBwcm9wb3NhbHNbaGFuZGxlTnVtYmVyXTtcclxuXHRcdFx0XHRcdHByb3Bvc2Fsc1toYW5kbGVOdW1iZXJdID0gdG87XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJZiB1c2luZyBvbmUgaGFuZGxlLCBjaGVjayBiYWNrd2FyZCBBTkQgZm9yd2FyZFxyXG5cdFx0ZWxzZSB7XHJcblx0XHRcdGIgPSBmID0gW3RydWVdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBzdGF0ZSA9IGZhbHNlO1xyXG5cclxuXHRcdC8vIFN0ZXAgMjogVHJ5IHRvIHNldCB0aGUgaGFuZGxlcyB3aXRoIHRoZSBmb3VuZCBwZXJjZW50YWdlXHJcblx0XHRoYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oaGFuZGxlTnVtYmVyLCBvKSB7XHJcblx0XHRcdHN0YXRlID0gc2V0SGFuZGxlKGhhbmRsZU51bWJlciwgbG9jYXRpb25zW2hhbmRsZU51bWJlcl0gKyBwcm9wb3NhbCwgYltvXSwgZltvXSkgfHwgc3RhdGU7XHJcblx0XHR9KTtcclxuXHJcblx0XHQvLyBTdGVwIDM6IElmIGEgaGFuZGxlIG1vdmVkLCBmaXJlIGV2ZW50c1xyXG5cdFx0aWYgKCBzdGF0ZSApIHtcclxuXHRcdFx0aGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdFx0ZmlyZUV2ZW50KCd1cGRhdGUnLCBoYW5kbGVOdW1iZXIpO1xyXG5cdFx0XHRcdGZpcmVFdmVudCgnc2xpZGUnLCBoYW5kbGVOdW1iZXIpO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8vIFRha2VzIGEgYmFzZSB2YWx1ZSBhbmQgYW4gb2Zmc2V0LiBUaGlzIG9mZnNldCBpcyB1c2VkIGZvciB0aGUgY29ubmVjdCBiYXIgc2l6ZS5cclxuXHQvLyBJbiB0aGUgaW5pdGlhbCBkZXNpZ24gZm9yIHRoaXMgZmVhdHVyZSwgdGhlIG9yaWdpbiBlbGVtZW50IHdhcyAxJSB3aWRlLlxyXG5cdC8vIFVuZm9ydHVuYXRlbHksIGEgcm91bmRpbmcgYnVnIGluIENocm9tZSBtYWtlcyBpdCBpbXBvc3NpYmxlIHRvIGltcGxlbWVudCB0aGlzIGZlYXR1cmVcclxuXHQvLyBpbiB0aGlzIG1hbm5lcjogaHR0cHM6Ly9idWdzLmNocm9taXVtLm9yZy9wL2Nocm9taXVtL2lzc3Vlcy9kZXRhaWw/aWQ9Nzk4MjIzXHJcblx0ZnVuY3Rpb24gdHJhbnNmb3JtRGlyZWN0aW9uICggYSwgYiApIHtcclxuXHRcdHJldHVybiBvcHRpb25zLmRpciA/IDEwMCAtIGEgLSBiIDogYTtcclxuXHR9XHJcblxyXG5cdC8vIFVwZGF0ZXMgc2NvcGVfTG9jYXRpb25zIGFuZCBzY29wZV9WYWx1ZXMsIHVwZGF0ZXMgdmlzdWFsIHN0YXRlXHJcblx0ZnVuY3Rpb24gdXBkYXRlSGFuZGxlUG9zaXRpb24gKCBoYW5kbGVOdW1iZXIsIHRvICkge1xyXG5cclxuXHRcdC8vIFVwZGF0ZSBsb2NhdGlvbnMuXHJcblx0XHRzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXSA9IHRvO1xyXG5cclxuXHRcdC8vIENvbnZlcnQgdGhlIHZhbHVlIHRvIHRoZSBzbGlkZXIgc3RlcHBpbmcvcmFuZ2UuXHJcblx0XHRzY29wZV9WYWx1ZXNbaGFuZGxlTnVtYmVyXSA9IHNjb3BlX1NwZWN0cnVtLmZyb21TdGVwcGluZyh0byk7XHJcblxyXG5cdFx0dmFyIHJ1bGUgPSAndHJhbnNsYXRlKCcgKyBpblJ1bGVPcmRlcih0b1BjdCh0cmFuc2Zvcm1EaXJlY3Rpb24odG8sIDApIC0gc2NvcGVfRGlyT2Zmc2V0KSwgJzAnKSArICcpJztcclxuXHRcdHNjb3BlX0hhbmRsZXNbaGFuZGxlTnVtYmVyXS5zdHlsZVtvcHRpb25zLnRyYW5zZm9ybVJ1bGVdID0gcnVsZTtcclxuXHJcblx0XHR1cGRhdGVDb25uZWN0KGhhbmRsZU51bWJlcik7XHJcblx0XHR1cGRhdGVDb25uZWN0KGhhbmRsZU51bWJlciArIDEpO1xyXG5cdH1cclxuXHJcblx0Ly8gSGFuZGxlcyBiZWZvcmUgdGhlIHNsaWRlciBtaWRkbGUgYXJlIHN0YWNrZWQgbGF0ZXIgPSBoaWdoZXIsXHJcblx0Ly8gSGFuZGxlcyBhZnRlciB0aGUgbWlkZGxlIGxhdGVyIGlzIGxvd2VyXHJcblx0Ly8gW1s3XSBbOF0gLi4uLi4uLi4uLiB8IC4uLi4uLi4uLi4gWzVdIFs0XVxyXG5cdGZ1bmN0aW9uIHNldFppbmRleCAoICkge1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHR2YXIgZGlyID0gKHNjb3BlX0xvY2F0aW9uc1toYW5kbGVOdW1iZXJdID4gNTAgPyAtMSA6IDEpO1xyXG5cdFx0XHR2YXIgekluZGV4ID0gMyArIChzY29wZV9IYW5kbGVzLmxlbmd0aCArIChkaXIgKiBoYW5kbGVOdW1iZXIpKTtcclxuXHRcdFx0c2NvcGVfSGFuZGxlc1toYW5kbGVOdW1iZXJdLnN0eWxlLnpJbmRleCA9IHpJbmRleDtcclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gVGVzdCBzdWdnZXN0ZWQgdmFsdWVzIGFuZCBhcHBseSBtYXJnaW4sIHN0ZXAuXHJcblx0ZnVuY3Rpb24gc2V0SGFuZGxlICggaGFuZGxlTnVtYmVyLCB0bywgbG9va0JhY2t3YXJkLCBsb29rRm9yd2FyZCApIHtcclxuXHJcblx0XHR0byA9IGNoZWNrSGFuZGxlUG9zaXRpb24oc2NvcGVfTG9jYXRpb25zLCBoYW5kbGVOdW1iZXIsIHRvLCBsb29rQmFja3dhcmQsIGxvb2tGb3J3YXJkLCBmYWxzZSk7XHJcblxyXG5cdFx0aWYgKCB0byA9PT0gZmFsc2UgKSB7XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHR1cGRhdGVIYW5kbGVQb3NpdGlvbihoYW5kbGVOdW1iZXIsIHRvKTtcclxuXHJcblx0XHRyZXR1cm4gdHJ1ZTtcclxuXHR9XHJcblxyXG5cdC8vIFVwZGF0ZXMgc3R5bGUgYXR0cmlidXRlIGZvciBjb25uZWN0IG5vZGVzXHJcblx0ZnVuY3Rpb24gdXBkYXRlQ29ubmVjdCAoIGluZGV4ICkge1xyXG5cclxuXHRcdC8vIFNraXAgY29ubmVjdHMgc2V0IHRvIGZhbHNlXHJcblx0XHRpZiAoICFzY29wZV9Db25uZWN0c1tpbmRleF0gKSB7XHJcblx0XHRcdHJldHVybjtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgbCA9IDA7XHJcblx0XHR2YXIgaCA9IDEwMDtcclxuXHJcblx0XHRpZiAoIGluZGV4ICE9PSAwICkge1xyXG5cdFx0XHRsID0gc2NvcGVfTG9jYXRpb25zW2luZGV4IC0gMV07XHJcblx0XHR9XHJcblxyXG5cdFx0aWYgKCBpbmRleCAhPT0gc2NvcGVfQ29ubmVjdHMubGVuZ3RoIC0gMSApIHtcclxuXHRcdFx0aCA9IHNjb3BlX0xvY2F0aW9uc1tpbmRleF07XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gV2UgdXNlIHR3byBydWxlczpcclxuXHRcdC8vICd0cmFuc2xhdGUnIHRvIGNoYW5nZSB0aGUgbGVmdC90b3Agb2Zmc2V0O1xyXG5cdFx0Ly8gJ3NjYWxlJyB0byBjaGFuZ2UgdGhlIHdpZHRoIG9mIHRoZSBlbGVtZW50O1xyXG5cdFx0Ly8gQXMgdGhlIGVsZW1lbnQgaGFzIGEgd2lkdGggb2YgMTAwJSwgYSB0cmFuc2xhdGlvbiBvZiAxMDAlIGlzIGVxdWFsIHRvIDEwMCUgb2YgdGhlIHBhcmVudCAoLm5vVWktYmFzZSlcclxuXHRcdHZhciBjb25uZWN0V2lkdGggPSBoIC0gbDtcclxuXHRcdHZhciB0cmFuc2xhdGVSdWxlID0gJ3RyYW5zbGF0ZSgnICsgaW5SdWxlT3JkZXIodG9QY3QodHJhbnNmb3JtRGlyZWN0aW9uKGwsIGNvbm5lY3RXaWR0aCkpLCAnMCcpICsgJyknO1xyXG5cdFx0dmFyIHNjYWxlUnVsZSA9ICdzY2FsZSgnICsgaW5SdWxlT3JkZXIoY29ubmVjdFdpZHRoIC8gMTAwLCAnMScpICsgJyknO1xyXG5cclxuXHRcdHNjb3BlX0Nvbm5lY3RzW2luZGV4XS5zdHlsZVtvcHRpb25zLnRyYW5zZm9ybVJ1bGVdID0gdHJhbnNsYXRlUnVsZSArICcgJyArIHNjYWxlUnVsZTtcclxuXHR9XHJcblxyXG4vKiEgSW4gdGhpcyBmaWxlOiBBbGwgbWV0aG9kcyBldmVudHVhbGx5IGV4cG9zZWQgaW4gc2xpZGVyLm5vVWlTbGlkZXIuLi4gKi9cclxuXHJcblx0Ly8gUGFyc2VzIHZhbHVlIHBhc3NlZCB0byAuc2V0IG1ldGhvZC4gUmV0dXJucyBjdXJyZW50IHZhbHVlIGlmIG5vdCBwYXJzZS1hYmxlLlxyXG5cdGZ1bmN0aW9uIHJlc29sdmVUb1ZhbHVlICggdG8sIGhhbmRsZU51bWJlciApIHtcclxuXHJcblx0XHQvLyBTZXR0aW5nIHdpdGggbnVsbCBpbmRpY2F0ZXMgYW4gJ2lnbm9yZScuXHJcblx0XHQvLyBJbnB1dHRpbmcgJ2ZhbHNlJyBpcyBpbnZhbGlkLlxyXG5cdFx0aWYgKCB0byA9PT0gbnVsbCB8fCB0byA9PT0gZmFsc2UgfHwgdG8gPT09IHVuZGVmaW5lZCApIHtcclxuXHRcdFx0cmV0dXJuIHNjb3BlX0xvY2F0aW9uc1toYW5kbGVOdW1iZXJdO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIElmIGEgZm9ybWF0dGVkIG51bWJlciB3YXMgcGFzc2VkLCBhdHRlbXB0IHRvIGRlY29kZSBpdC5cclxuXHRcdGlmICggdHlwZW9mIHRvID09PSAnbnVtYmVyJyApIHtcclxuXHRcdFx0dG8gPSBTdHJpbmcodG8pO1xyXG5cdFx0fVxyXG5cclxuXHRcdHRvID0gb3B0aW9ucy5mb3JtYXQuZnJvbSh0byk7XHJcblx0XHR0byA9IHNjb3BlX1NwZWN0cnVtLnRvU3RlcHBpbmcodG8pO1xyXG5cclxuXHRcdC8vIElmIHBhcnNpbmcgdGhlIG51bWJlciBmYWlsZWQsIHVzZSB0aGUgY3VycmVudCB2YWx1ZS5cclxuXHRcdGlmICggdG8gPT09IGZhbHNlIHx8IGlzTmFOKHRvKSApIHtcclxuXHRcdFx0cmV0dXJuIHNjb3BlX0xvY2F0aW9uc1toYW5kbGVOdW1iZXJdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiB0bztcclxuXHR9XHJcblxyXG5cdC8vIFNldCB0aGUgc2xpZGVyIHZhbHVlLlxyXG5cdGZ1bmN0aW9uIHZhbHVlU2V0ICggaW5wdXQsIGZpcmVTZXRFdmVudCApIHtcclxuXHJcblx0XHR2YXIgdmFsdWVzID0gYXNBcnJheShpbnB1dCk7XHJcblx0XHR2YXIgaXNJbml0ID0gc2NvcGVfTG9jYXRpb25zWzBdID09PSB1bmRlZmluZWQ7XHJcblxyXG5cdFx0Ly8gRXZlbnQgZmlyZXMgYnkgZGVmYXVsdFxyXG5cdFx0ZmlyZVNldEV2ZW50ID0gKGZpcmVTZXRFdmVudCA9PT0gdW5kZWZpbmVkID8gdHJ1ZSA6ICEhZmlyZVNldEV2ZW50KTtcclxuXHJcblx0XHQvLyBBbmltYXRpb24gaXMgb3B0aW9uYWwuXHJcblx0XHQvLyBNYWtlIHN1cmUgdGhlIGluaXRpYWwgdmFsdWVzIHdlcmUgc2V0IGJlZm9yZSB1c2luZyBhbmltYXRlZCBwbGFjZW1lbnQuXHJcblx0XHRpZiAoIG9wdGlvbnMuYW5pbWF0ZSAmJiAhaXNJbml0ICkge1xyXG5cdFx0XHRhZGRDbGFzc0ZvcihzY29wZV9UYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50YXAsIG9wdGlvbnMuYW5pbWF0aW9uRHVyYXRpb24pO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEZpcnN0IHBhc3MsIHdpdGhvdXQgbG9va0FoZWFkIGJ1dCB3aXRoIGxvb2tCYWNrd2FyZC4gVmFsdWVzIGFyZSBzZXQgZnJvbSBsZWZ0IHRvIHJpZ2h0LlxyXG5cdFx0c2NvcGVfSGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIHJlc29sdmVUb1ZhbHVlKHZhbHVlc1toYW5kbGVOdW1iZXJdLCBoYW5kbGVOdW1iZXIpLCB0cnVlLCBmYWxzZSk7XHJcblx0XHR9KTtcclxuXHJcblx0XHQvLyBTZWNvbmQgcGFzcy4gTm93IHRoYXQgYWxsIGJhc2UgdmFsdWVzIGFyZSBzZXQsIGFwcGx5IGNvbnN0cmFpbnRzXHJcblx0XHRzY29wZV9IYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oaGFuZGxlTnVtYmVyKXtcclxuXHRcdFx0c2V0SGFuZGxlKGhhbmRsZU51bWJlciwgc2NvcGVfTG9jYXRpb25zW2hhbmRsZU51bWJlcl0sIHRydWUsIHRydWUpO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0c2V0WmluZGV4KCk7XHJcblxyXG5cdFx0c2NvcGVfSGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblxyXG5cdFx0XHRmaXJlRXZlbnQoJ3VwZGF0ZScsIGhhbmRsZU51bWJlcik7XHJcblxyXG5cdFx0XHQvLyBGaXJlIHRoZSBldmVudCBvbmx5IGZvciBoYW5kbGVzIHRoYXQgcmVjZWl2ZWQgYSBuZXcgdmFsdWUsIGFzIHBlciAjNTc5XHJcblx0XHRcdGlmICggdmFsdWVzW2hhbmRsZU51bWJlcl0gIT09IG51bGwgJiYgZmlyZVNldEV2ZW50ICkge1xyXG5cdFx0XHRcdGZpcmVFdmVudCgnc2V0JywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBSZXNldCBzbGlkZXIgdG8gaW5pdGlhbCB2YWx1ZXNcclxuXHRmdW5jdGlvbiB2YWx1ZVJlc2V0ICggZmlyZVNldEV2ZW50ICkge1xyXG5cdFx0dmFsdWVTZXQob3B0aW9ucy5zdGFydCwgZmlyZVNldEV2ZW50KTtcclxuXHR9XHJcblxyXG5cdC8vIEdldCB0aGUgc2xpZGVyIHZhbHVlLlxyXG5cdGZ1bmN0aW9uIHZhbHVlR2V0ICggKSB7XHJcblxyXG5cdFx0dmFyIHZhbHVlcyA9IHNjb3BlX1ZhbHVlcy5tYXAob3B0aW9ucy5mb3JtYXQudG8pO1xyXG5cclxuXHRcdC8vIElmIG9ubHkgb25lIGhhbmRsZSBpcyB1c2VkLCByZXR1cm4gYSBzaW5nbGUgdmFsdWUuXHJcblx0XHRpZiAoIHZhbHVlcy5sZW5ndGggPT09IDEgKXtcclxuXHRcdFx0cmV0dXJuIHZhbHVlc1swXTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gdmFsdWVzO1xyXG5cdH1cclxuXHJcblx0Ly8gUmVtb3ZlcyBjbGFzc2VzIGZyb20gdGhlIHJvb3QgYW5kIGVtcHRpZXMgaXQuXHJcblx0ZnVuY3Rpb24gZGVzdHJveSAoICkge1xyXG5cclxuXHRcdGZvciAoIHZhciBrZXkgaW4gb3B0aW9ucy5jc3NDbGFzc2VzICkge1xyXG5cdFx0XHRpZiAoICFvcHRpb25zLmNzc0NsYXNzZXMuaGFzT3duUHJvcGVydHkoa2V5KSApIHsgY29udGludWU7IH1cclxuXHRcdFx0cmVtb3ZlQ2xhc3Moc2NvcGVfVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXNba2V5XSk7XHJcblx0XHR9XHJcblxyXG5cdFx0d2hpbGUgKHNjb3BlX1RhcmdldC5maXJzdENoaWxkKSB7XHJcblx0XHRcdHNjb3BlX1RhcmdldC5yZW1vdmVDaGlsZChzY29wZV9UYXJnZXQuZmlyc3RDaGlsZCk7XHJcblx0XHR9XHJcblxyXG5cdFx0ZGVsZXRlIHNjb3BlX1RhcmdldC5ub1VpU2xpZGVyO1xyXG5cdH1cclxuXHJcblx0Ly8gR2V0IHRoZSBjdXJyZW50IHN0ZXAgc2l6ZSBmb3IgdGhlIHNsaWRlci5cclxuXHRmdW5jdGlvbiBnZXRDdXJyZW50U3RlcCAoICkge1xyXG5cclxuXHRcdC8vIENoZWNrIGFsbCBsb2NhdGlvbnMsIG1hcCB0aGVtIHRvIHRoZWlyIHN0ZXBwaW5nIHBvaW50LlxyXG5cdFx0Ly8gR2V0IHRoZSBzdGVwIHBvaW50LCB0aGVuIGZpbmQgaXQgaW4gdGhlIGlucHV0IGxpc3QuXHJcblx0XHRyZXR1cm4gc2NvcGVfTG9jYXRpb25zLm1hcChmdW5jdGlvbiggbG9jYXRpb24sIGluZGV4ICl7XHJcblxyXG5cdFx0XHR2YXIgbmVhcmJ5U3RlcHMgPSBzY29wZV9TcGVjdHJ1bS5nZXROZWFyYnlTdGVwcyggbG9jYXRpb24gKTtcclxuXHRcdFx0dmFyIHZhbHVlID0gc2NvcGVfVmFsdWVzW2luZGV4XTtcclxuXHRcdFx0dmFyIGluY3JlbWVudCA9IG5lYXJieVN0ZXBzLnRoaXNTdGVwLnN0ZXA7XHJcblx0XHRcdHZhciBkZWNyZW1lbnQgPSBudWxsO1xyXG5cclxuXHRcdFx0Ly8gSWYgdGhlIG5leHQgdmFsdWUgaW4gdGhpcyBzdGVwIG1vdmVzIGludG8gdGhlIG5leHQgc3RlcCxcclxuXHRcdFx0Ly8gdGhlIGluY3JlbWVudCBpcyB0aGUgc3RhcnQgb2YgdGhlIG5leHQgc3RlcCAtIHRoZSBjdXJyZW50IHZhbHVlXHJcblx0XHRcdGlmICggaW5jcmVtZW50ICE9PSBmYWxzZSApIHtcclxuXHRcdFx0XHRpZiAoIHZhbHVlICsgaW5jcmVtZW50ID4gbmVhcmJ5U3RlcHMuc3RlcEFmdGVyLnN0YXJ0VmFsdWUgKSB7XHJcblx0XHRcdFx0XHRpbmNyZW1lbnQgPSBuZWFyYnlTdGVwcy5zdGVwQWZ0ZXIuc3RhcnRWYWx1ZSAtIHZhbHVlO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cclxuXHJcblx0XHRcdC8vIElmIHRoZSB2YWx1ZSBpcyBiZXlvbmQgdGhlIHN0YXJ0aW5nIHBvaW50XHJcblx0XHRcdGlmICggdmFsdWUgPiBuZWFyYnlTdGVwcy50aGlzU3RlcC5zdGFydFZhbHVlICkge1xyXG5cdFx0XHRcdGRlY3JlbWVudCA9IG5lYXJieVN0ZXBzLnRoaXNTdGVwLnN0ZXA7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGVsc2UgaWYgKCBuZWFyYnlTdGVwcy5zdGVwQmVmb3JlLnN0ZXAgPT09IGZhbHNlICkge1xyXG5cdFx0XHRcdGRlY3JlbWVudCA9IGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBJZiBhIGhhbmRsZSBpcyBhdCB0aGUgc3RhcnQgb2YgYSBzdGVwLCBpdCBhbHdheXMgc3RlcHMgYmFjayBpbnRvIHRoZSBwcmV2aW91cyBzdGVwIGZpcnN0XHJcblx0XHRcdGVsc2Uge1xyXG5cdFx0XHRcdGRlY3JlbWVudCA9IHZhbHVlIC0gbmVhcmJ5U3RlcHMuc3RlcEJlZm9yZS5oaWdoZXN0U3RlcDtcclxuXHRcdFx0fVxyXG5cclxuXHJcblx0XHRcdC8vIE5vdywgaWYgYXQgdGhlIHNsaWRlciBlZGdlcywgdGhlcmUgaXMgbm90IGluL2RlY3JlbWVudFxyXG5cdFx0XHRpZiAoIGxvY2F0aW9uID09PSAxMDAgKSB7XHJcblx0XHRcdFx0aW5jcmVtZW50ID0gbnVsbDtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0ZWxzZSBpZiAoIGxvY2F0aW9uID09PSAwICkge1xyXG5cdFx0XHRcdGRlY3JlbWVudCA9IG51bGw7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIEFzIHBlciAjMzkxLCB0aGUgY29tcGFyaXNvbiBmb3IgdGhlIGRlY3JlbWVudCBzdGVwIGNhbiBoYXZlIHNvbWUgcm91bmRpbmcgaXNzdWVzLlxyXG5cdFx0XHR2YXIgc3RlcERlY2ltYWxzID0gc2NvcGVfU3BlY3RydW0uY291bnRTdGVwRGVjaW1hbHMoKTtcclxuXHJcblx0XHRcdC8vIFJvdW5kIHBlciAjMzkxXHJcblx0XHRcdGlmICggaW5jcmVtZW50ICE9PSBudWxsICYmIGluY3JlbWVudCAhPT0gZmFsc2UgKSB7XHJcblx0XHRcdFx0aW5jcmVtZW50ID0gTnVtYmVyKGluY3JlbWVudC50b0ZpeGVkKHN0ZXBEZWNpbWFscykpO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRpZiAoIGRlY3JlbWVudCAhPT0gbnVsbCAmJiBkZWNyZW1lbnQgIT09IGZhbHNlICkge1xyXG5cdFx0XHRcdGRlY3JlbWVudCA9IE51bWJlcihkZWNyZW1lbnQudG9GaXhlZChzdGVwRGVjaW1hbHMpKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0cmV0dXJuIFtkZWNyZW1lbnQsIGluY3JlbWVudF07XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cdC8vIFVwZGF0ZWFibGU6IG1hcmdpbiwgbGltaXQsIHBhZGRpbmcsIHN0ZXAsIHJhbmdlLCBhbmltYXRlLCBzbmFwXHJcblx0ZnVuY3Rpb24gdXBkYXRlT3B0aW9ucyAoIG9wdGlvbnNUb1VwZGF0ZSwgZmlyZVNldEV2ZW50ICkge1xyXG5cclxuXHRcdC8vIFNwZWN0cnVtIGlzIGNyZWF0ZWQgdXNpbmcgdGhlIHJhbmdlLCBzbmFwLCBkaXJlY3Rpb24gYW5kIHN0ZXAgb3B0aW9ucy5cclxuXHRcdC8vICdzbmFwJyBhbmQgJ3N0ZXAnIGNhbiBiZSB1cGRhdGVkLlxyXG5cdFx0Ly8gSWYgJ3NuYXAnIGFuZCAnc3RlcCcgYXJlIG5vdCBwYXNzZWQsIHRoZXkgc2hvdWxkIHJlbWFpbiB1bmNoYW5nZWQuXHJcblx0XHR2YXIgdiA9IHZhbHVlR2V0KCk7XHJcblxyXG5cdFx0dmFyIHVwZGF0ZUFibGUgPSBbJ21hcmdpbicsICdsaW1pdCcsICdwYWRkaW5nJywgJ3JhbmdlJywgJ2FuaW1hdGUnLCAnc25hcCcsICdzdGVwJywgJ2Zvcm1hdCddO1xyXG5cclxuXHRcdC8vIE9ubHkgY2hhbmdlIG9wdGlvbnMgdGhhdCB3ZSdyZSBhY3R1YWxseSBwYXNzZWQgdG8gdXBkYXRlLlxyXG5cdFx0dXBkYXRlQWJsZS5mb3JFYWNoKGZ1bmN0aW9uKG5hbWUpe1xyXG5cdFx0XHRpZiAoIG9wdGlvbnNUb1VwZGF0ZVtuYW1lXSAhPT0gdW5kZWZpbmVkICkge1xyXG5cdFx0XHRcdG9yaWdpbmFsT3B0aW9uc1tuYW1lXSA9IG9wdGlvbnNUb1VwZGF0ZVtuYW1lXTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0dmFyIG5ld09wdGlvbnMgPSB0ZXN0T3B0aW9ucyhvcmlnaW5hbE9wdGlvbnMpO1xyXG5cclxuXHRcdC8vIExvYWQgbmV3IG9wdGlvbnMgaW50byB0aGUgc2xpZGVyIHN0YXRlXHJcblx0XHR1cGRhdGVBYmxlLmZvckVhY2goZnVuY3Rpb24obmFtZSl7XHJcblx0XHRcdGlmICggb3B0aW9uc1RvVXBkYXRlW25hbWVdICE9PSB1bmRlZmluZWQgKSB7XHJcblx0XHRcdFx0b3B0aW9uc1tuYW1lXSA9IG5ld09wdGlvbnNbbmFtZV07XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cclxuXHRcdHNjb3BlX1NwZWN0cnVtID0gbmV3T3B0aW9ucy5zcGVjdHJ1bTtcclxuXHJcblx0XHQvLyBMaW1pdCwgbWFyZ2luIGFuZCBwYWRkaW5nIGRlcGVuZCBvbiB0aGUgc3BlY3RydW0gYnV0IGFyZSBzdG9yZWQgb3V0c2lkZSBvZiBpdC4gKCM2NzcpXHJcblx0XHRvcHRpb25zLm1hcmdpbiA9IG5ld09wdGlvbnMubWFyZ2luO1xyXG5cdFx0b3B0aW9ucy5saW1pdCA9IG5ld09wdGlvbnMubGltaXQ7XHJcblx0XHRvcHRpb25zLnBhZGRpbmcgPSBuZXdPcHRpb25zLnBhZGRpbmc7XHJcblxyXG5cdFx0Ly8gVXBkYXRlIHBpcHMsIHJlbW92ZXMgZXhpc3RpbmcuXHJcblx0XHRpZiAoIG9wdGlvbnMucGlwcyApIHtcclxuXHRcdFx0cGlwcyhvcHRpb25zLnBpcHMpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEludmFsaWRhdGUgdGhlIGN1cnJlbnQgcG9zaXRpb25pbmcgc28gdmFsdWVTZXQgZm9yY2VzIGFuIHVwZGF0ZS5cclxuXHRcdHNjb3BlX0xvY2F0aW9ucyA9IFtdO1xyXG5cdFx0dmFsdWVTZXQob3B0aW9uc1RvVXBkYXRlLnN0YXJ0IHx8IHYsIGZpcmVTZXRFdmVudCk7XHJcblx0fVxyXG5cclxuLyohIEluIHRoaXMgZmlsZTogQ2FsbHMgdG8gZnVuY3Rpb25zLiBBbGwgb3RoZXIgc2NvcGVfIGZpbGVzIGRlZmluZSBmdW5jdGlvbnMgb25seTsgKi9cclxuXHJcblx0Ly8gQ3JlYXRlIHRoZSBiYXNlIGVsZW1lbnQsIGluaXRpYWxpemUgSFRNTCBhbmQgc2V0IGNsYXNzZXMuXHJcblx0Ly8gQWRkIGhhbmRsZXMgYW5kIGNvbm5lY3QgZWxlbWVudHMuXHJcblx0YWRkU2xpZGVyKHNjb3BlX1RhcmdldCk7XHJcblx0YWRkRWxlbWVudHMob3B0aW9ucy5jb25uZWN0LCBzY29wZV9CYXNlKTtcclxuXHJcblx0Ly8gQXR0YWNoIHVzZXIgZXZlbnRzLlxyXG5cdGJpbmRTbGlkZXJFdmVudHMob3B0aW9ucy5ldmVudHMpO1xyXG5cclxuXHQvLyBVc2UgdGhlIHB1YmxpYyB2YWx1ZSBtZXRob2QgdG8gc2V0IHRoZSBzdGFydCB2YWx1ZXMuXHJcblx0dmFsdWVTZXQob3B0aW9ucy5zdGFydCk7XHJcblxyXG5cdHNjb3BlX1NlbGYgPSB7XHJcblx0XHRkZXN0cm95OiBkZXN0cm95LFxyXG5cdFx0c3RlcHM6IGdldEN1cnJlbnRTdGVwLFxyXG5cdFx0b246IGJpbmRFdmVudCxcclxuXHRcdG9mZjogcmVtb3ZlRXZlbnQsXHJcblx0XHRnZXQ6IHZhbHVlR2V0LFxyXG5cdFx0c2V0OiB2YWx1ZVNldCxcclxuXHRcdHJlc2V0OiB2YWx1ZVJlc2V0LFxyXG5cdFx0Ly8gRXhwb3NlZCBmb3IgdW5pdCB0ZXN0aW5nLCBkb24ndCB1c2UgdGhpcyBpbiB5b3VyIGFwcGxpY2F0aW9uLlxyXG5cdFx0X19tb3ZlSGFuZGxlczogZnVuY3Rpb24oYSwgYiwgYykgeyBtb3ZlSGFuZGxlcyhhLCBiLCBzY29wZV9Mb2NhdGlvbnMsIGMpOyB9LFxyXG5cdFx0b3B0aW9uczogb3JpZ2luYWxPcHRpb25zLCAvLyBJc3N1ZSAjNjAwLCAjNjc4XHJcblx0XHR1cGRhdGVPcHRpb25zOiB1cGRhdGVPcHRpb25zLFxyXG5cdFx0dGFyZ2V0OiBzY29wZV9UYXJnZXQsIC8vIElzc3VlICM1OTdcclxuXHRcdHJlbW92ZVBpcHM6IHJlbW92ZVBpcHMsXHJcblx0XHRwaXBzOiBwaXBzIC8vIElzc3VlICM1OTRcclxuXHR9O1xyXG5cclxuXHRpZiAoIG9wdGlvbnMucGlwcyApIHtcclxuXHRcdHBpcHMob3B0aW9ucy5waXBzKTtcclxuXHR9XHJcblxyXG5cdGlmICggb3B0aW9ucy50b29sdGlwcyApIHtcclxuXHRcdHRvb2x0aXBzKCk7XHJcblx0fVxyXG5cclxuXHRhcmlhKCk7XHJcblxyXG5cdHJldHVybiBzY29wZV9TZWxmO1xyXG5cclxufVxyXG5cclxuXHJcblx0Ly8gUnVuIHRoZSBzdGFuZGFyZCBpbml0aWFsaXplclxyXG5cdGZ1bmN0aW9uIGluaXRpYWxpemUgKCB0YXJnZXQsIG9yaWdpbmFsT3B0aW9ucyApIHtcclxuXHJcblx0XHRpZiAoICF0YXJnZXQgfHwgIXRhcmdldC5ub2RlTmFtZSApIHtcclxuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiBjcmVhdGUgcmVxdWlyZXMgYSBzaW5nbGUgZWxlbWVudCwgZ290OiBcIiArIHRhcmdldCk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gVGhyb3cgYW4gZXJyb3IgaWYgdGhlIHNsaWRlciB3YXMgYWxyZWFkeSBpbml0aWFsaXplZC5cclxuXHRcdGlmICggdGFyZ2V0Lm5vVWlTbGlkZXIgKSB7XHJcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogU2xpZGVyIHdhcyBhbHJlYWR5IGluaXRpYWxpemVkLlwiKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBUZXN0IHRoZSBvcHRpb25zIGFuZCBjcmVhdGUgdGhlIHNsaWRlciBlbnZpcm9ubWVudDtcclxuXHRcdHZhciBvcHRpb25zID0gdGVzdE9wdGlvbnMoIG9yaWdpbmFsT3B0aW9ucywgdGFyZ2V0ICk7XHJcblx0XHR2YXIgYXBpID0gc2NvcGUoIHRhcmdldCwgb3B0aW9ucywgb3JpZ2luYWxPcHRpb25zICk7XHJcblxyXG5cdFx0dGFyZ2V0Lm5vVWlTbGlkZXIgPSBhcGk7XHJcblxyXG5cdFx0cmV0dXJuIGFwaTtcclxuXHR9XHJcblxyXG5cdC8vIFVzZSBhbiBvYmplY3QgaW5zdGVhZCBvZiBhIGZ1bmN0aW9uIGZvciBmdXR1cmUgZXhwYW5kYWJpbGl0eTtcclxuXHRyZXR1cm4ge1xyXG5cdFx0dmVyc2lvbjogVkVSU0lPTixcclxuXHRcdGNyZWF0ZTogaW5pdGlhbGl6ZVxyXG5cdH07XHJcblxyXG59KSk7IiwiKGZ1bmN0aW9uIChnbG9iYWwpe1xuXHJcbnZhciAkIFx0XHRcdFx0PSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xyXG52YXIgc3RhdGUgXHRcdFx0PSByZXF1aXJlKCcuL3N0YXRlJyk7XHJcbnZhciBwcm9jZXNzX2Zvcm0gXHQ9IHJlcXVpcmUoJy4vcHJvY2Vzc19mb3JtJyk7XHJcbnZhciBub1VpU2xpZGVyXHRcdD0gcmVxdWlyZSgnbm91aXNsaWRlcicpO1xyXG4vL3ZhciBjb29raWVzICAgICAgICAgPSByZXF1aXJlKCdqcy1jb29raWUnKTtcclxudmFyIHRoaXJkUGFydHkgICAgICA9IHJlcXVpcmUoJy4vdGhpcmRwYXJ0eScpO1xyXG5cclxud2luZG93LnNlYXJjaEFuZEZpbHRlciA9IHtcclxuICAgIGV4dGVuc2lvbnM6IFtdLFxyXG4gICAgcmVnaXN0ZXJFeHRlbnNpb246IGZ1bmN0aW9uKCBleHRlbnNpb25OYW1lICkge1xyXG4gICAgICAgIHRoaXMuZXh0ZW5zaW9ucy5wdXNoKCBleHRlbnNpb25OYW1lICk7XHJcbiAgICB9XHJcbn07XHJcblxyXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uKG9wdGlvbnMpXHJcbntcclxuICAgIHZhciBkZWZhdWx0cyA9IHtcclxuICAgICAgICBzdGFydE9wZW5lZDogZmFsc2UsXHJcbiAgICAgICAgaXNJbml0OiB0cnVlLFxyXG4gICAgICAgIGFjdGlvbjogXCJcIlxyXG4gICAgfTtcclxuXHJcbiAgICB2YXIgb3B0cyA9IGpRdWVyeS5leHRlbmQoZGVmYXVsdHMsIG9wdGlvbnMpO1xyXG4gICAgXHJcbiAgICB0aGlyZFBhcnR5LmluaXQoKTtcclxuICAgIFxyXG4gICAgLy9sb29wIHRocm91Z2ggZWFjaCBpdGVtIG1hdGNoZWRcclxuICAgIHRoaXMuZWFjaChmdW5jdGlvbigpXHJcbiAgICB7XHJcblxyXG4gICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XHJcbiAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG4gICAgICAgIHRoaXMuc2ZpZCA9ICR0aGlzLmF0dHIoXCJkYXRhLXNmLWZvcm0taWRcIik7XHJcblxyXG4gICAgICAgIHN0YXRlLmFkZFNlYXJjaEZvcm0odGhpcy5zZmlkLCB0aGlzKTtcclxuXHJcbiAgICAgICAgdGhpcy4kZmllbGRzID0gJHRoaXMuZmluZChcIj4gdWwgPiBsaVwiKTsgLy9hIHJlZmVyZW5jZSB0byBlYWNoIGZpZWxkcyBwYXJlbnQgTElcclxuXHJcbiAgICAgICAgdGhpcy5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMgPSAkdGhpcy5hdHRyKCdkYXRhLXRheG9ub215LWFyY2hpdmVzJyk7XHJcbiAgICAgICAgdGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgPSAkdGhpcy5hdHRyKCdkYXRhLWN1cnJlbnQtdGF4b25vbXktYXJjaGl2ZScpO1xyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMgPSBcIjBcIjtcclxuICAgICAgICB9XHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHByb2Nlc3NfZm9ybS5pbml0KHNlbGYuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzLCBzZWxmLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSk7XHJcbiAgICAgICAgLy9wcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZik7XHJcbiAgICAgICAgcHJvY2Vzc19mb3JtLmVuYWJsZUlucHV0cyhzZWxmKTtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZXh0cmFfcXVlcnlfcGFyYW1zKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuZXh0cmFfcXVlcnlfcGFyYW1zID0ge2FsbDoge30sIHJlc3VsdHM6IHt9LCBhamF4OiB7fX07XHJcbiAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgdGhpcy50ZW1wbGF0ZV9pc19sb2FkZWQgPSAkdGhpcy5hdHRyKFwiZGF0YS10ZW1wbGF0ZS1sb2FkZWRcIik7XHJcbiAgICAgICAgdGhpcy5pc19hamF4ID0gJHRoaXMuYXR0cihcImRhdGEtYWpheFwiKTtcclxuICAgICAgICB0aGlzLmluc3RhbmNlX251bWJlciA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5zdGFuY2UtY291bnQnKTtcclxuICAgICAgICB0aGlzLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyID0galF1ZXJ5KCR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdGFyZ2V0XCIpKTtcclxuXHJcbiAgICAgICAgdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucyA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdXBkYXRlLXNlY3Rpb25zXCIpID8gSlNPTi5wYXJzZSggJHRoaXMuYXR0cihcImRhdGEtYWpheC11cGRhdGUtc2VjdGlvbnNcIikgKSA6IFtdO1xyXG4gICAgICAgIFxyXG4gICAgICAgIHRoaXMucmVzdWx0c191cmwgPSAkdGhpcy5hdHRyKFwiZGF0YS1yZXN1bHRzLXVybFwiKTtcclxuICAgICAgICB0aGlzLmRlYnVnX21vZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWJ1Zy1tb2RlXCIpO1xyXG4gICAgICAgIHRoaXMudXBkYXRlX2FqYXhfdXJsID0gJHRoaXMuYXR0cihcImRhdGEtdXBkYXRlLWFqYXgtdXJsXCIpO1xyXG4gICAgICAgIHRoaXMucGFnaW5hdGlvbl90eXBlID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC1wYWdpbmF0aW9uLXR5cGVcIik7XHJcbiAgICAgICAgdGhpcy5hdXRvX2NvdW50ID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by1jb3VudFwiKTtcclxuICAgICAgICB0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by1jb3VudC1yZWZyZXNoLW1vZGVcIik7XHJcbiAgICAgICAgdGhpcy5vbmx5X3Jlc3VsdHNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLW9ubHktcmVzdWx0cy1hamF4XCIpOyAvL2lmIHdlIGFyZSBub3Qgb24gdGhlIHJlc3VsdHMgcGFnZSwgcmVkaXJlY3QgcmF0aGVyIHRoYW4gdHJ5IHRvIGxvYWQgdmlhIGFqYXhcclxuICAgICAgICB0aGlzLnNjcm9sbF90b19wb3MgPSAkdGhpcy5hdHRyKFwiZGF0YS1zY3JvbGwtdG8tcG9zXCIpO1xyXG4gICAgICAgIHRoaXMuY3VzdG9tX3Njcm9sbF90byA9ICR0aGlzLmF0dHIoXCJkYXRhLWN1c3RvbS1zY3JvbGwtdG9cIik7XHJcbiAgICAgICAgdGhpcy5zY3JvbGxfb25fYWN0aW9uID0gJHRoaXMuYXR0cihcImRhdGEtc2Nyb2xsLW9uLWFjdGlvblwiKTtcclxuICAgICAgICB0aGlzLmxhbmdfY29kZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWxhbmctY29kZVwiKTtcclxuICAgICAgICB0aGlzLmFqYXhfdXJsID0gJHRoaXMuYXR0cignZGF0YS1hamF4LXVybCcpO1xyXG4gICAgICAgIHRoaXMuYWpheF9mb3JtX3VybCA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC1mb3JtLXVybCcpO1xyXG4gICAgICAgIHRoaXMuaXNfcnRsID0gJHRoaXMuYXR0cignZGF0YS1pcy1ydGwnKTtcclxuXHJcbiAgICAgICAgdGhpcy5kaXNwbGF5X3Jlc3VsdF9tZXRob2QgPSAkdGhpcy5hdHRyKCdkYXRhLWRpc3BsYXktcmVzdWx0LW1ldGhvZCcpO1xyXG4gICAgICAgIHRoaXMubWFpbnRhaW5fc3RhdGUgPSAkdGhpcy5hdHRyKCdkYXRhLW1haW50YWluLXN0YXRlJyk7XHJcbiAgICAgICAgdGhpcy5hamF4X2FjdGlvbiA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICB0aGlzLmN1cnJlbnRfcGFnZWQgPSBwYXJzZUludCgkdGhpcy5hdHRyKCdkYXRhLWluaXQtcGFnZWQnKSk7XHJcbiAgICAgICAgdGhpcy5sYXN0X2xvYWRfbW9yZV9odG1sID0gXCJcIjtcclxuICAgICAgICB0aGlzLmxvYWRfbW9yZV9odG1sID0gXCJcIjtcclxuICAgICAgICB0aGlzLmFqYXhfZGF0YV90eXBlID0gJHRoaXMuYXR0cignZGF0YS1hamF4LWRhdGEtdHlwZScpO1xyXG4gICAgICAgIHRoaXMuYWpheF90YXJnZXRfYXR0ciA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdGFyZ2V0XCIpO1xyXG4gICAgICAgIHRoaXMudXNlX2hpc3RvcnlfYXBpID0gJHRoaXMuYXR0cihcImRhdGEtdXNlLWhpc3RvcnktYXBpXCIpO1xyXG4gICAgICAgIHRoaXMuaXNfc3VibWl0dGluZyA9IGZhbHNlO1xyXG5cclxuICAgICAgICB0aGlzLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMudXNlX2hpc3RvcnlfYXBpKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMudXNlX2hpc3RvcnlfYXBpID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnBhZ2luYXRpb25fdHlwZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnBhZ2luYXRpb25fdHlwZSA9IFwibm9ybWFsXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1cnJlbnRfcGFnZWQpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5jdXJyZW50X3BhZ2VkID0gMTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdGFyZ2V0X2F0dHIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hamF4X3RhcmdldF9hdHRyID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdXJsKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF9mb3JtX3VybCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmFqYXhfZm9ybV91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMucmVzdWx0c191cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5zY3JvbGxfdG9fcG9zKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuc2Nyb2xsX3RvX3BvcyA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5zY3JvbGxfb25fYWN0aW9uKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuc2Nyb2xsX29uX2FjdGlvbiA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1c3RvbV9zY3JvbGxfdG8pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5jdXN0b21fc2Nyb2xsX3RvID0gXCJcIjtcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy4kY3VzdG9tX3Njcm9sbF90byA9IGpRdWVyeSh0aGlzLmN1c3RvbV9zY3JvbGxfdG8pO1xyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy51cGRhdGVfYWpheF91cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy51cGRhdGVfYWpheF91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZGVidWdfbW9kZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmRlYnVnX21vZGUgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF90YXJnZXRfb2JqZWN0KT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF90YXJnZXRfb2JqZWN0ID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCA9IFwiMFwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZSA9IFwiMFwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5hamF4X2xpbmtzX3NlbGVjdG9yID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC1saW5rcy1zZWxlY3RvclwiKTtcclxuXHJcblxyXG4gICAgICAgIHRoaXMuYXV0b191cGRhdGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1hdXRvLXVwZGF0ZVwiKTtcclxuICAgICAgICB0aGlzLmlucHV0VGltZXIgPSAwO1xyXG5cclxuICAgICAgICB0aGlzLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgIHRoaXMuaXNfbWF4X3BhZ2VkID0gZmFsc2U7IC8vZm9yIGxvYWQgbW9yZSBvbmx5LCBvbmNlIHdlIGRldGVjdCB3ZSdyZSBhdCB0aGUgZW5kIHNldCB0aGlzIHRvIHRydWVcclxuICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9ICR0aGlzLmF0dHIoJ2RhdGEtc2hvdy1zY3JvbGwtbG9hZGVyJyk7XHJcbiAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpO1xyXG4gICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLXRyaWdnZXInKTtcclxuICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzID0gJHRoaXMuYXR0cignZGF0YS1pbmZpbml0ZS1zY3JvbGwtcmVzdWx0LWNsYXNzJyk7XHJcbiAgICAgICAgICAgIHRoaXMuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSB0aGlzLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyO1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyID0galF1ZXJ5KCR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLnVzZV9zY3JvbGxfbG9hZGVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9IDE7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyKCk7XHJcblxyXG4gICAgICAgIC8qIGZ1bmN0aW9ucyAqL1xyXG5cclxuICAgICAgICB0aGlzLnJlc2V0ID0gZnVuY3Rpb24oc3VibWl0X2Zvcm0pXHJcbiAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgdGhpcy5yZXNldEZvcm0oc3VibWl0X2Zvcm0pO1xyXG4gICAgICAgICAgICByZXR1cm4gdHJ1ZTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuaW5wdXRVcGRhdGUgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGRlbGF5RHVyYXRpb24pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGVsYXlEdXJhdGlvbiA9IDMwMDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5yZXNldFRpbWVyKGRlbGF5RHVyYXRpb24pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zY3JvbGxUb1BvcyA9IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICB2YXIgb2Zmc2V0ID0gMDtcclxuICAgICAgICAgICAgdmFyIGNhblNjcm9sbCA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJ3aW5kb3dcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAwO1xyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImZvcm1cIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAkdGhpcy5vZmZzZXQoKS50b3A7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJyZXN1bHRzXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9mZnNldCA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIub2Zmc2V0KCkudG9wO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImN1c3RvbVwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vY3VzdG9tX3Njcm9sbF90b1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuJGN1c3RvbV9zY3JvbGxfdG8ubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSBzZWxmLiRjdXN0b21fc2Nyb2xsX3RvLm9mZnNldCgpLnRvcDtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgY2FuU2Nyb2xsID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoY2FuU2Nyb2xsKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCJodG1sLCBib2R5XCIpLnN0b3AoKS5hbmltYXRlKHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2Nyb2xsVG9wOiBvZmZzZXRcclxuICAgICAgICAgICAgICAgICAgICB9LCBcIm5vcm1hbFwiLCBcImVhc2VPdXRRdWFkXCIgKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmF0dGFjaEFjdGl2ZUNsYXNzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8vY2hlY2sgdG8gc2VlIGlmIHdlIGFyZSB1c2luZyBhamF4ICYgYXV0byBjb3VudFxyXG4gICAgICAgICAgICAvL2lmIG5vdCwgdGhlIHNlYXJjaCBmb3JtIGRvZXMgbm90IGdldCByZWxvYWRlZCwgc28gd2UgbmVlZCB0byB1cGRhdGUgdGhlIHNmLW9wdGlvbi1hY3RpdmUgY2xhc3Mgb24gYWxsIGZpZWxkc1xyXG5cclxuICAgICAgICAgICAgJHRoaXMub24oJ2NoYW5nZScsICdpbnB1dFt0eXBlPVwicmFkaW9cIl0sIGlucHV0W3R5cGU9XCJjaGVja2JveFwiXSwgc2VsZWN0JywgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyICRjdGhpcyA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGN0aGlzX3BhcmVudCA9ICRjdGhpcy5jbG9zZXN0KFwibGlbZGF0YS1zZi1maWVsZC1uYW1lXVwiKTtcclxuICAgICAgICAgICAgICAgIHZhciB0aGlzX3RhZyA9ICRjdGhpcy5wcm9wKFwidGFnTmFtZVwiKS50b0xvd2VyQ2FzZSgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIGlucHV0X3R5cGUgPSAkY3RoaXMuYXR0cihcInR5cGVcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgcGFyZW50X3RhZyA9ICRjdGhpc19wYXJlbnQucHJvcChcInRhZ05hbWVcIikudG9Mb3dlckNhc2UoKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigodGhpc190YWc9PVwiaW5wdXRcIikmJigoaW5wdXRfdHlwZT09XCJyYWRpb1wiKXx8KGlucHV0X3R5cGU9PVwiY2hlY2tib3hcIikpICYmIChwYXJlbnRfdGFnPT1cImxpXCIpKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2xpJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRhbGxfb3B0aW9uc19maWVsZHMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2lucHV0OmNoZWNrZWQnKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJGFsbF9vcHRpb25zLnJlbW92ZUNsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnNfZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkcGFyZW50ID0gJCh0aGlzKS5jbG9zZXN0KFwibGlcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRwYXJlbnQuYWRkQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHRoaXNfdGFnPT1cInNlbGVjdFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXMuY2hpbGRyZW4oKTtcclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnMucmVtb3ZlQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciB0aGlzX3ZhbCA9ICRjdGhpcy52YWwoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRoaXNfYXJyX3ZhbCA9ICh0eXBlb2YgdGhpc192YWwgPT0gJ3N0cmluZycgfHwgdGhpc192YWwgaW5zdGFuY2VvZiBTdHJpbmcpID8gW3RoaXNfdmFsXSA6IHRoaXNfdmFsO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkKHRoaXNfYXJyX3ZhbCkuZWFjaChmdW5jdGlvbihpLCB2YWx1ZSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjdGhpcy5maW5kKFwib3B0aW9uW3ZhbHVlPSdcIit2YWx1ZStcIiddXCIpLmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8qIGF1dG8gdXBkYXRlICovXHJcbiAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignY2hhbmdlJywgJ2lucHV0W3R5cGU9XCJyYWRpb1wiXSwgaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdLCBzZWxlY3QnLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgyMDApO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMub24oJ2lucHV0JywgJ2lucHV0W3R5cGU9XCJudW1iZXJcIl0nLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSg4MDApO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICR0ZXh0SW5wdXQgPSAkdGhpcy5maW5kKCdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgbGFzdFZhbHVlID0gJHRleHRJbnB1dC52YWwoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignaW5wdXQnLCAnaW5wdXRbdHlwZT1cInRleHRcIl06bm90KC5zZi1kYXRlcGlja2VyKScsIGZ1bmN0aW9uKClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZihsYXN0VmFsdWUhPSR0ZXh0SW5wdXQudmFsKCkpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEyMDApO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgbGFzdFZhbHVlID0gJHRleHRJbnB1dC52YWwoKTtcclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbigna2V5cHJlc3MnLCAnaW5wdXRbdHlwZT1cInRleHRcIl06bm90KC5zZi1kYXRlcGlja2VyKScsIGZ1bmN0aW9uKGUpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGUud2hpY2ggPT0gMTMpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAvLyR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dC5zZi1kYXRlcGlja2VyJywgc2VsZi5kYXRlSW5wdXRUeXBlKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICAvL3RoaXMuaW5pdEF1dG9VcGRhdGVFdmVudHMoKTtcclxuXHJcblxyXG4gICAgICAgIHRoaXMuY2xlYXJUaW1lciA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGNsZWFyVGltZW91dChzZWxmLmlucHV0VGltZXIpO1xyXG4gICAgICAgIH07XHJcbiAgICAgICAgdGhpcy5yZXNldFRpbWVyID0gZnVuY3Rpb24oZGVsYXlEdXJhdGlvbilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGNsZWFyVGltZW91dChzZWxmLmlucHV0VGltZXIpO1xyXG4gICAgICAgICAgICBzZWxmLmlucHV0VGltZXIgPSBzZXRUaW1lb3V0KHNlbGYuZm9ybVVwZGF0ZWQsIGRlbGF5RHVyYXRpb24pO1xyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmFkZERhdGVQaWNrZXJzID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRkYXRlX3BpY2tlciA9ICR0aGlzLmZpbmQoXCIuc2YtZGF0ZXBpY2tlclwiKTtcclxuXHJcbiAgICAgICAgICAgIGlmKCRkYXRlX3BpY2tlci5sZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJGRhdGVfcGlja2VyLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZUZvcm1hdCA9IFwiXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGVEcm9wZG93blllYXIgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZURyb3Bkb3duTW9udGggPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRjbG9zZXN0X2RhdGVfd3JhcCA9ICR0aGlzLmNsb3Nlc3QoXCIuc2ZfZGF0ZV9maWVsZFwiKTtcclxuICAgICAgICAgICAgICAgICAgICBpZigkY2xvc2VzdF9kYXRlX3dyYXAubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlRm9ybWF0ID0gJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtZm9ybWF0XCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtdXNlLXllYXItZHJvcGRvd25cIik9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVEcm9wZG93blllYXIgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRjbG9zZXN0X2RhdGVfd3JhcC5hdHRyKFwiZGF0YS1kYXRlLXVzZS1tb250aC1kcm9wZG93blwiKT09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZURyb3Bkb3duTW9udGggPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZVBpY2tlck9wdGlvbnMgPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlubGluZTogdHJ1ZSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2hvd090aGVyTW9udGhzOiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBvblNlbGVjdDogZnVuY3Rpb24oZSwgZnJvbV9maWVsZCl7IHNlbGYuZGF0ZVNlbGVjdChlLCBmcm9tX2ZpZWxkLCAkKHRoaXMpKTsgfSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZUZvcm1hdDogZGF0ZUZvcm1hdCxcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNoYW5nZU1vbnRoOiBkYXRlRHJvcGRvd25Nb250aCxcclxuICAgICAgICAgICAgICAgICAgICAgICAgY2hhbmdlWWVhcjogZGF0ZURyb3Bkb3duWWVhclxyXG4gICAgICAgICAgICAgICAgICAgIH07XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZVBpY2tlck9wdGlvbnMuZGlyZWN0aW9uID0gXCJydGxcIjtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLmRhdGVwaWNrZXIoZGF0ZVBpY2tlck9wdGlvbnMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5zZXREZWZhdWx0cyhcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuZXh0ZW5kKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHsnZGF0ZUZvcm1hdCc6ZGF0ZUZvcm1hdH0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnJlZ2lvbmFsWyBzZWxmLmxhbmdfY29kZV1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIClcclxuICAgICAgICAgICAgICAgICAgICAgICAgKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQuZGF0ZXBpY2tlci5zZXREZWZhdWx0cyhcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuZXh0ZW5kKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHsnZGF0ZUZvcm1hdCc6ZGF0ZUZvcm1hdH0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnJlZ2lvbmFsW1wiZW5cIl1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIClcclxuICAgICAgICAgICAgICAgICAgICAgICAgKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCQoJy5sbC1za2luLW1lbG9uJykubGVuZ3RoPT0wKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJGRhdGVfcGlja2VyLmRhdGVwaWNrZXIoJ3dpZGdldCcpLndyYXAoJzxkaXYgY2xhc3M9XCJsbC1za2luLW1lbG9uIHNlYXJjaGFuZGZpbHRlci1kYXRlLXBpY2tlclwiLz4nKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmRhdGVTZWxlY3QgPSBmdW5jdGlvbihlLCBmcm9tX2ZpZWxkLCAkdGhpcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciAkaW5wdXRfZmllbGQgPSAkKGZyb21fZmllbGQuaW5wdXQuZ2V0KDApKTtcclxuICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuXHJcbiAgICAgICAgICAgIHZhciAkZGF0ZV9maWVsZHMgPSAkaW5wdXRfZmllbGQuY2xvc2VzdCgnW2RhdGEtc2YtZmllbGQtaW5wdXQtdHlwZT1cImRhdGVyYW5nZVwiXSwgW2RhdGEtc2YtZmllbGQtaW5wdXQtdHlwZT1cImRhdGVcIl0nKTtcclxuICAgICAgICAgICAgJGRhdGVfZmllbGRzLmVhY2goZnVuY3Rpb24oZSwgaW5kZXgpe1xyXG4gICAgICAgICAgICAgICAgXHJcbiAgICAgICAgICAgICAgICB2YXIgJHRmX2RhdGVfcGlja2VycyA9ICQodGhpcykuZmluZChcIi5zZi1kYXRlcGlja2VyXCIpO1xyXG4gICAgICAgICAgICAgICAgdmFyIG5vX2RhdGVfcGlja2VycyA9ICR0Zl9kYXRlX3BpY2tlcnMubGVuZ3RoO1xyXG4gICAgICAgICAgICAgICAgXHJcbiAgICAgICAgICAgICAgICBpZihub19kYXRlX3BpY2tlcnM+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3RoZW4gaXQgaXMgYSBkYXRlIHJhbmdlLCBzbyBtYWtlIHN1cmUgYm90aCBmaWVsZHMgYXJlIGZpbGxlZCBiZWZvcmUgdXBkYXRpbmdcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfY291bnRlciA9IDA7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRwX2VtcHR5X2ZpZWxkX2NvdW50ID0gMDtcclxuICAgICAgICAgICAgICAgICAgICAkdGZfZGF0ZV9waWNrZXJzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCQodGhpcykudmFsKCk9PVwiXCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRwX2VtcHR5X2ZpZWxkX2NvdW50Kys7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRwX2NvdW50ZXIrKztcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZHBfZW1wdHlfZmllbGRfY291bnQ9PTApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5hZGRSYW5nZVNsaWRlcnMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJG1ldGFfcmFuZ2UgPSAkdGhpcy5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJG1ldGFfcmFuZ2UubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRtZXRhX3JhbmdlLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWluID0gJHRoaXMuYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtaW4gPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRpc3BsYXlfdmFsdWVfYXMgPSAkdGhpcy5hdHRyKFwiZGF0YS1kaXNwbGF5LXZhbHVlcy1hc1wiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RlcCA9ICR0aGlzLmF0dHIoXCJkYXRhLXN0ZXBcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzdGFydF92YWwgPSAkdGhpcy5maW5kKCcuc2YtcmFuZ2UtbWluJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRlbmRfdmFsID0gJHRoaXMuZmluZCgnLnNmLXJhbmdlLW1heCcpO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRlY2ltYWxfcGxhY2VzID0gJHRoaXMuYXR0cihcImRhdGEtZGVjaW1hbC1wbGFjZXNcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRob3VzYW5kX3NlcGVyYXRvciA9ICR0aGlzLmF0dHIoXCJkYXRhLXRob3VzYW5kLXNlcGVyYXRvclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGVjaW1hbF9zZXBlcmF0b3IgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWNpbWFsLXNlcGVyYXRvclwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX2Zvcm1hdCA9IHdOdW1iKHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgbWFyazogZGVjaW1hbF9zZXBlcmF0b3IsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRlY2ltYWxzOiBwYXJzZUZsb2F0KGRlY2ltYWxfcGxhY2VzKSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhvdXNhbmQ6IHRob3VzYW5kX3NlcGVyYXRvclxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtaW4pO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21pbikpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21heCkpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtYXgpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9hbGVydChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KGRpc3BsYXlfdmFsdWVfYXMpO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0aW5wdXRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwudmFsKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC52YWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG5vVUlPcHRpb25zID0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByYW5nZToge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJ21pbic6IFsgcGFyc2VGbG9hdChtaW4pIF0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnbWF4JzogWyBwYXJzZUZsb2F0KG1heCkgXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzdGFydDogW21pbl9mb3JtYXR0ZWQsIG1heF9mb3JtYXR0ZWRdLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVzOiAyLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25uZWN0OiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzdGVwOiBwYXJzZUZsb2F0KHN0ZXApLFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgYmVoYXZpb3VyOiAnZXh0ZW5kLXRhcCcsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZvcm1hdDogZmllbGRfZm9ybWF0XHJcbiAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX3J0bD09MSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG5vVUlPcHRpb25zLmRpcmVjdGlvbiA9IFwicnRsXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX29iamVjdCA9ICQodGhpcykuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoIFwidW5kZWZpbmVkXCIgIT09IHR5cGVvZiggc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyICkgKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vZGVzdHJveSBpZiBpdCBleGlzdHMuLiB0aGlzIG1lYW5zIHNvbWVob3cgYW5vdGhlciBpbnN0YW5jZSBoYWQgaW5pdGlhbGlzZWQgaXQuLlxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZGVzdHJveSgpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgbm9VaVNsaWRlci5jcmVhdGUoc2xpZGVyX29iamVjdCwgbm9VSU9wdGlvbnMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLm9mZigpO1xyXG4gICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoWyQodGhpcykudmFsKCksIG51bGxdKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwub2ZmKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoW251bGwsICQodGhpcykudmFsKCldKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy8kc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8kZW5kX3ZhbC5odG1sKG1heF9mb3JtYXR0ZWQpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIub2ZmKCd1cGRhdGUnKTtcclxuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIub24oJ3VwZGF0ZScsIGZ1bmN0aW9uKCB2YWx1ZXMsIGhhbmRsZSApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfc3RhcnRfdmFsICA9IG1pbl9mb3JtYXR0ZWQ7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfZW5kX3ZhbCAgPSBtYXhfZm9ybWF0dGVkO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHZhbHVlID0gdmFsdWVzW2hhbmRsZV07XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCBoYW5kbGUgKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBtYXhfZm9ybWF0dGVkID0gdmFsdWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBtaW5fZm9ybWF0dGVkID0gdmFsdWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGRpc3BsYXlfdmFsdWVfYXM9PVwidGV4dGlucHV0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwudmFsKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwudmFsKG1heF9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwuaHRtbChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2kgdGhpbmsgdGhlIGZ1bmN0aW9uIHRoYXQgYnVpbGRzIHRoZSBVUkwgbmVlZHMgdG8gZGVjb2RlIHRoZSBmb3JtYXR0ZWQgc3RyaW5nIGJlZm9yZSBhZGRpbmcgdG8gdGhlIHVybFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigoc2VsZi5hdXRvX3VwZGF0ZT09MSl8fChzZWxmLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy9vbmx5IHRyeSB0byB1cGRhdGUgaWYgdGhlIHZhbHVlcyBoYXZlIGFjdHVhbGx5IGNoYW5nZWRcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmKChzbGlkZXJfc3RhcnRfdmFsIT1taW5fZm9ybWF0dGVkKXx8KHNsaWRlcl9lbmRfdmFsIT1tYXhfZm9ybWF0dGVkKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDgwMCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmNsZWFyVGltZXIoKTsgLy9pZ25vcmUgYW55IGNoYW5nZXMgcmVjZW50bHkgbWFkZSBieSB0aGUgc2xpZGVyICh0aGlzIHdhcyBqdXN0IGluaXQgc2hvdWxkbid0IGNvdW50IGFzIGFuIHVwZGF0ZSBldmVudClcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuaW5pdCA9IGZ1bmN0aW9uKGtlZXBfcGFnaW5hdGlvbilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihrZWVwX3BhZ2luYXRpb24pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIga2VlcF9wYWdpbmF0aW9uID0gZmFsc2U7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHRoaXMuaW5pdEF1dG9VcGRhdGVFdmVudHMoKTtcclxuICAgICAgICAgICAgdGhpcy5hdHRhY2hBY3RpdmVDbGFzcygpO1xyXG5cclxuICAgICAgICAgICAgdGhpcy5hZGREYXRlUGlja2VycygpO1xyXG4gICAgICAgICAgICB0aGlzLmFkZFJhbmdlU2xpZGVycygpO1xyXG5cclxuICAgICAgICAgICAgLy9pbml0IGNvbWJvIGJveGVzXHJcbiAgICAgICAgICAgIHZhciAkY29tYm9ib3ggPSAkdGhpcy5maW5kKFwic2VsZWN0W2RhdGEtY29tYm9ib3g9JzEnXVwiKTtcclxuXHJcbiAgICAgICAgICAgIGlmKCRjb21ib2JveC5sZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJGNvbWJvYm94LmVhY2goZnVuY3Rpb24oaW5kZXggKXtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNjYiA9ICQoIHRoaXMgKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbnJtID0gJHRoaXNjYi5hdHRyKFwiZGF0YS1jb21ib2JveC1ucm1cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmICh0eXBlb2YgJHRoaXNjYi5jaG9zZW4gIT0gXCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBjaG9zZW5vcHRpb25zID0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgc2VhcmNoX2NvbnRhaW5zOiB0cnVlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH07XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigodHlwZW9mKG5ybSkhPT1cInVuZGVmaW5lZFwiKSYmKG5ybSkpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2hvc2Vub3B0aW9ucy5ub19yZXN1bHRzX3RleHQgPSBucm07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy8gc2FmZSB0byB1c2UgdGhlIGZ1bmN0aW9uXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vc2VhcmNoX2NvbnRhaW5zXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLmFkZENsYXNzKFwiY2hvc2VuLXJ0bFwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNjYi5jaG9zZW4oY2hvc2Vub3B0aW9ucyk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgc2VsZWN0Mm9wdGlvbnMgPSB7fTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfcnRsPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWxlY3Qyb3B0aW9ucy5kaXIgPSBcInJ0bFwiO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCh0eXBlb2YobnJtKSE9PVwidW5kZWZpbmVkXCIpJiYobnJtKSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWxlY3Qyb3B0aW9ucy5sYW5ndWFnZT0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFwibm9SZXN1bHRzXCI6IGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBucm07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNjYi5zZWxlY3QyKHNlbGVjdDJvcHRpb25zKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG5cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIC8vaWYgYWpheCBpcyBlbmFibGVkIGluaXQgdGhlIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnNldHVwQWpheFBhZ2luYXRpb24oKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgJHRoaXMub24oXCJzdWJtaXRcIiwgdGhpcy5zdWJtaXRGb3JtKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMoKTsgLy93b29jb21tZXJjZSBvcmRlcmJ5XHJcblxyXG4gICAgICAgICAgICBpZihrZWVwX3BhZ2luYXRpb249PWZhbHNlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5vbldpbmRvd1Njcm9sbCA9IGZ1bmN0aW9uKGV2ZW50KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYoKCFzZWxmLmlzX2xvYWRpbmdfbW9yZSkgJiYgKCFzZWxmLmlzX21heF9wYWdlZCkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB3aW5kb3dfc2Nyb2xsID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHdpbmRvd19zY3JvbGxfYm90dG9tID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpICsgJCh3aW5kb3cpLmhlaWdodCgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHNjcm9sbF9vZmZzZXQgPSBwYXJzZUludChzZWxmLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfc2Nyb2xsX2JvdHRvbSA9IHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIub2Zmc2V0KCkudG9wICsgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5oZWlnaHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG9mZnNldCA9IChzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLm9mZnNldCgpLnRvcCArIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuaGVpZ2h0KCkpIC0gd2luZG93X3Njcm9sbDtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYod2luZG93X3Njcm9sbF9ib3R0b20gPiByZXN1bHRzX3Njcm9sbF9ib3R0b20gKyBzY3JvbGxfb2Zmc2V0KVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5sb2FkTW9yZVJlc3VsdHMoKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHsvL2RvbnQgbG9hZCBtb3JlXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zdHJpcFF1ZXJ5U3RyaW5nQW5kSGFzaEZyb21QYXRoID0gZnVuY3Rpb24odXJsKSB7XHJcbiAgICAgICAgICAgIHJldHVybiB1cmwuc3BsaXQoXCI/XCIpWzBdLnNwbGl0KFwiI1wiKVswXTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuZ3VwID0gZnVuY3Rpb24oIG5hbWUsIHVybCApIHtcclxuICAgICAgICAgICAgaWYgKCF1cmwpIHVybCA9IGxvY2F0aW9uLmhyZWZcclxuICAgICAgICAgICAgbmFtZSA9IG5hbWUucmVwbGFjZSgvW1xcW10vLFwiXFxcXFxcW1wiKS5yZXBsYWNlKC9bXFxdXS8sXCJcXFxcXFxdXCIpO1xyXG4gICAgICAgICAgICB2YXIgcmVnZXhTID0gXCJbXFxcXD8mXVwiK25hbWUrXCI9KFteJiNdKilcIjtcclxuICAgICAgICAgICAgdmFyIHJlZ2V4ID0gbmV3IFJlZ0V4cCggcmVnZXhTICk7XHJcbiAgICAgICAgICAgIHZhciByZXN1bHRzID0gcmVnZXguZXhlYyggdXJsICk7XHJcbiAgICAgICAgICAgIHJldHVybiByZXN1bHRzID09IG51bGwgPyBudWxsIDogcmVzdWx0c1sxXTtcclxuICAgICAgICB9O1xyXG5cclxuXHJcbiAgICAgICAgdGhpcy5nZXRVcmxQYXJhbXMgPSBmdW5jdGlvbihrZWVwX3BhZ2luYXRpb24sIHR5cGUsIGV4Y2x1ZGUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZih0eXBlb2Yoa2VlcF9wYWdpbmF0aW9uKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGtlZXBfcGFnaW5hdGlvbiA9IHRydWU7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih0eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHR5cGUgPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgdXJsX3BhcmFtc19zdHIgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgLy8gZ2V0IGFsbCBwYXJhbXMgZnJvbSBmaWVsZHNcclxuICAgICAgICAgICAgdmFyIHVybF9wYXJhbXNfYXJyYXkgPSBwcm9jZXNzX2Zvcm0uZ2V0VXJsUGFyYW1zKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKHVybF9wYXJhbXNfYXJyYXkpLmxlbmd0aDtcclxuICAgICAgICAgICAgdmFyIGNvdW50ID0gMDtcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihleGNsdWRlKSE9XCJ1bmRlZmluZWRcIikge1xyXG4gICAgICAgICAgICAgICAgaWYgKHVybF9wYXJhbXNfYXJyYXkuaGFzT3duUHJvcGVydHkoZXhjbHVkZSkpIHtcclxuICAgICAgICAgICAgICAgICAgICBsZW5ndGgtLTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYobGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gdXJsX3BhcmFtc19hcnJheSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICh1cmxfcGFyYW1zX2FycmF5Lmhhc093blByb3BlcnR5KGspKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgY2FuX2FkZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHR5cGVvZihleGNsdWRlKSE9XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYoaz09ZXhjbHVkZSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhbl9hZGQgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoY2FuX2FkZCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsX3BhcmFtc19zdHIgKz0gayArIFwiPVwiICsgdXJsX3BhcmFtc19hcnJheVtrXTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoY291bnQgPCBsZW5ndGggLSAxKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsX3BhcmFtc19zdHIgKz0gXCImXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY291bnQrKztcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICAvL2Zvcm0gcGFyYW1zIGFzIHVybCBxdWVyeSBzdHJpbmdcclxuICAgICAgICAgICAgdmFyIGZvcm1fcGFyYW1zID0gdXJsX3BhcmFtc19zdHI7XHJcblxyXG4gICAgICAgICAgICAvL2dldCB1cmwgcGFyYW1zIGZyb20gdGhlIGZvcm0gaXRzZWxmICh3aGF0IHRoZSB1c2VyIGhhcyBzZWxlY3RlZClcclxuICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBmb3JtX3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAvL2FkZCBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgIGlmKGtlZXBfcGFnaW5hdGlvbj09dHJ1ZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHBhZ2VOdW1iZXIgPSBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihwYWdlTnVtYmVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBwYWdlTnVtYmVyID0gMTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZihwYWdlTnVtYmVyPjEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK3BhZ2VOdW1iZXIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvL2FkZCBzZmlkXHJcbiAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmaWQ9XCIrc2VsZi5zZmlkKTtcclxuXHJcbiAgICAgICAgICAgIC8vIGxvb3AgdGhyb3VnaCBhbnkgZXh0cmEgcGFyYW1zIChmcm9tIGV4dCBwbHVnaW5zKSBhbmQgYWRkIHRvIHRoZSB1cmwgKGllIHdvb2NvbW1lcmNlIGBvcmRlcmJ5YClcclxuICAgICAgICAgICAgLyp2YXIgZXh0cmFfcXVlcnlfcGFyYW0gPSBcIlwiO1xyXG4gICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zKS5sZW5ndGg7XHJcbiAgICAgICAgICAgICB2YXIgY291bnQgPSAwO1xyXG5cclxuICAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxyXG4gICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMpIHtcclxuICAgICAgICAgICAgIGlmIChzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5oYXNPd25Qcm9wZXJ0eShrKSkge1xyXG5cclxuICAgICAgICAgICAgIGlmKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdIT1cIlwiKVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgZXh0cmFfcXVlcnlfcGFyYW0gPSBrK1wiPVwiK3NlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdO1xyXG4gICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBleHRyYV9xdWVyeV9wYXJhbSk7XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAqL1xyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmFkZFF1ZXJ5UGFyYW1zKHF1ZXJ5X3BhcmFtcywgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsKTtcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGUhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhxdWVyeV9wYXJhbXMsIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW3R5cGVdKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIHF1ZXJ5X3BhcmFtcztcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5hZGRRdWVyeVBhcmFtcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcywgbmV3X3BhcmFtcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBleHRyYV9xdWVyeV9wYXJhbSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyhuZXdfcGFyYW1zKS5sZW5ndGg7XHJcbiAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XHJcblxyXG4gICAgICAgICAgICBpZihsZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gbmV3X3BhcmFtcykge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChuZXdfcGFyYW1zLmhhc093blByb3BlcnR5KGspKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihuZXdfcGFyYW1zW2tdIT1cIlwiKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHRyYV9xdWVyeV9wYXJhbSA9IGsrXCI9XCIrbmV3X3BhcmFtc1trXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgZXh0cmFfcXVlcnlfcGFyYW0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gcXVlcnlfcGFyYW1zO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmFkZFVybFBhcmFtID0gZnVuY3Rpb24odXJsLCBzdHJpbmcpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgYWRkX3BhcmFtcyA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICBpZih1cmwhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHVybC5pbmRleE9mKFwiP1wiKSAhPSAtMSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vdXJsID0gdGhpcy50cmFpbGluZ1NsYXNoSXQodXJsKTtcclxuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiP1wiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gdXJsICsgYWRkX3BhcmFtcyArIHN0cmluZztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiB1cmw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmpvaW5VcmxQYXJhbSA9IGZ1bmN0aW9uKHBhcmFtcywgc3RyaW5nKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIGFkZF9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgaWYocGFyYW1zIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gcGFyYW1zICsgYWRkX3BhcmFtcyArIHN0cmluZztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiBwYXJhbXM7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLnNldEFqYXhSZXN1bHRzVVJMcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfcmVzdWx0c19jb25mKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZiA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gXCJcIjtcclxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIC8vaWYoc2VsZi5hamF4X3VybCE9XCJcIilcclxuICAgICAgICAgICAgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwic2hvcnRjb2RlXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2FudCB0byBkbyBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnRcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYucmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9hZGQgbGFuZyBjb2RlIHRvIGFqYXggYXBpIHJlcXVlc3QsIGxhbmcgY29kZSBzaG91bGQgYWxyZWFkeSBiZSBpbiB0aGVyZSBmb3Igb3RoZXIgcmVxdWVzdHMgKGllLCBzdXBwbGllZCBpbiB0aGUgUmVzdWx0cyBVUkwpXHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5sYW5nX2NvZGUhPVwiXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9zbyBhZGQgaXRcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwibGFuZz1cIitzZWxmLmxhbmdfY29kZSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5hamF4X3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIC8vc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSAnanNvbic7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwicG9zdF90eXBlX2FyY2hpdmVcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJjdXN0b21fd29vY29tbWVyY2Vfc3RvcmVcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly9vdGhlcndpc2Ugd2Ugd2FudCB0byBwdWxsIHRoZSByZXN1bHRzIGRpcmVjdGx5IGZyb20gdGhlIHJlc3VsdHMgcGFnZVxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5yZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF91cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gJ2h0bWwnO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1snYWpheCddKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gc2VsZi5hamF4X2RhdGFfdHlwZTtcclxuICAgICAgICB9O1xyXG5cclxuXHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlTG9hZGVyVGFnID0gZnVuY3Rpb24oJG9iamVjdCwgdGFnTmFtZSkge1xyXG5cclxuICAgICAgICAgICAgdmFyICRwYXJlbnQ7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRwYXJlbnQgPSBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKS5sYXN0KCkucGFyZW50KCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkcGFyZW50ID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHRhZ05hbWUgPSAkcGFyZW50LnByb3AoXCJ0YWdOYW1lXCIpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHRhZ1R5cGUgPSAnZGl2JztcclxuICAgICAgICAgICAgaWYoICggdGFnTmFtZS50b0xvd2VyQ2FzZSgpID09ICdvbCcgKSB8fCAoIHRhZ05hbWUudG9Mb3dlckNhc2UoKSA9PSAndWwnICkgKXtcclxuICAgICAgICAgICAgICAgIHRhZ1R5cGUgPSAnbGknO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgJG5ldyA9ICQoJzwnK3RhZ1R5cGUrJyAvPicpLmh0bWwoJG9iamVjdC5odG1sKCkpO1xyXG4gICAgICAgICAgICB2YXIgYXR0cmlidXRlcyA9ICRvYmplY3QucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcblxyXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggPHNlbGVjdD4gYXR0cmlidXRlcyBhbmQgYXBwbHkgdGhlbSBvbiA8ZGl2PlxyXG4gICAgICAgICAgICAkLmVhY2goYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAkbmV3LmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gJG5ldztcclxuXHJcbiAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5sb2FkTW9yZVJlc3VsdHMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBzZWxmLmlzX2xvYWRpbmdfbW9yZSA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcclxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XHJcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXHJcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogXCJsb2FkX21vcmVcIixcclxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxyXG4gICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4c3RhcnRcIiwgZXZlbnRfZGF0YSk7XHJcbiAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgXHJcbiAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyh0cnVlKTtcclxuICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7IC8vZ3JhYiBhIGNvcHkgb2YgaHRlIFVSTCBwYXJhbXMgd2l0aG91dCBwYWdpbmF0aW9uIGFscmVhZHkgYWRkZWRcclxuXHJcbiAgICAgICAgICAgIHZhciBhamF4X3Byb2Nlc3NpbmdfdXJsID0gXCJcIjtcclxuICAgICAgICAgICAgdmFyIGFqYXhfcmVzdWx0c191cmwgPSBcIlwiO1xyXG4gICAgICAgICAgICB2YXIgZGF0YV90eXBlID0gXCJcIjtcclxuXHJcblxyXG4gICAgICAgICAgICAvL25vdyBhZGQgdGhlIG5ldyBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgIHZhciBuZXh0X3BhZ2VkX251bWJlciA9IHRoaXMuY3VycmVudF9wYWdlZCArIDE7XHJcbiAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJzZl9wYWdlZD1cIituZXh0X3BhZ2VkX251bWJlcik7XHJcblxyXG4gICAgICAgICAgICBzZWxmLnNldEFqYXhSZXN1bHRzVVJMcyhxdWVyeV9wYXJhbXMpO1xyXG4gICAgICAgICAgICBhamF4X3Byb2Nlc3NpbmdfdXJsID0gc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXTtcclxuICAgICAgICAgICAgYWpheF9yZXN1bHRzX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ107XHJcbiAgICAgICAgICAgIGRhdGFfdHlwZSA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddO1xyXG5cclxuICAgICAgICAgICAgLy9hYm9ydCBhbnkgcHJldmlvdXMgYWpheCByZXF1ZXN0c1xyXG4gICAgICAgICAgICBpZihzZWxmLmxhc3RfYWpheF9yZXF1ZXN0KVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0LmFib3J0KCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYudXNlX3Njcm9sbF9sb2FkZXI9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciAkbG9hZGVyID0gJCgnPGRpdi8+Jyx7XHJcbiAgICAgICAgICAgICAgICAgICAgJ2NsYXNzJzogJ3NlYXJjaC1maWx0ZXItc2Nyb2xsLWxvYWRpbmcnXHJcbiAgICAgICAgICAgICAgICB9KTsvLy5hcHBlbmRUbyhzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyKTtcclxuXHJcbiAgICAgICAgICAgICAgICAkbG9hZGVyID0gc2VsZi51cGRhdGVMb2FkZXJUYWcoJGxvYWRlcik7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pbmZpbml0ZVNjcm9sbEFwcGVuZCgkbG9hZGVyKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9ICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5jdXJyZW50X3BhZ2VkKys7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgICAgICAgICAvKiBzY3JvbGwgKi9cclxuICAgICAgICAgICAgICAgIC8vc2VsZi5zY3JvbGxSZXN1bHRzKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy91cGRhdGVzIHRoZSByZXN1dGxzICYgZm9ybSBodG1sXHJcbiAgICAgICAgICAgICAgICBzZWxmLmFkZFJlc3VsdHMoZGF0YSwgZGF0YV90eXBlKTtcclxuXHJcbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcclxuICAgICAgICAgICAgICAgIGRhdGEuanFYSFIgPSBqcVhIUjtcclxuICAgICAgICAgICAgICAgIGRhdGEudGV4dFN0YXR1cyA9IHRleHRTdGF0dXM7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBkYXRhKTtcclxuXHJcbiAgICAgICAgICAgIH0pLmFsd2F5cyhmdW5jdGlvbigpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHNlbGYudXNlX3Njcm9sbF9sb2FkZXI9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgJGxvYWRlci5kZXRhY2goKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzX2xvYWRpbmdfbW9yZSA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZpbmlzaFwiLCBkYXRhKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmZldGNoQWpheFJlc3VsdHMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcclxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XHJcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXHJcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogXCJsb2FkX3Jlc3VsdHNcIixcclxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxyXG4gICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4c3RhcnRcIiwgZXZlbnRfZGF0YSk7XHJcblxyXG4gICAgICAgICAgICAvL3JlZm9jdXMgYW55IGlucHV0IGZpZWxkcyBhZnRlciB0aGUgZm9ybSBoYXMgYmVlbiB1cGRhdGVkXHJcbiAgICAgICAgICAgIHZhciAkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dCA9ICR0aGlzLmZpbmQoJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOmZvY3VzJykubm90KFwiLnNmLWRhdGVwaWNrZXJcIik7XHJcbiAgICAgICAgICAgIGlmKCRsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0Lmxlbmd0aD09MSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGxhc3RfYWN0aXZlX2lucHV0X3RleHQgPSAkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dC5hdHRyKFwibmFtZVwiKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgJHRoaXMuYWRkQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZGlzYWJsZUlucHV0cyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgIC8vZmFkZSBvdXQgcmVzdWx0c1xyXG4gICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmFuaW1hdGUoeyBvcGFjaXR5OiAwLjUgfSwgXCJmYXN0XCIpOyAvL2xvYWRpbmdcclxuICAgICAgICAgICAgc2VsZi5mYWRlQ29udGVudEFyZWFzKCBcIm91dFwiICk7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmFqYXhfYWN0aW9uPT1cInBhZ2luYXRpb25cIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9uZWVkIHRvIHJlbW92ZSBhY3RpdmUgZmlsdGVyIGZyb20gVVJMXHJcblxyXG4gICAgICAgICAgICAgICAgLy9xdWVyeV9wYXJhbXMgPSBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcztcclxuXHJcbiAgICAgICAgICAgICAgICAvL25vdyBhZGQgdGhlIG5ldyBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKHBhZ2VOdW1iZXIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHBhZ2VOdW1iZXIgPSAxO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHBhZ2VOdW1iZXI+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrcGFnZU51bWJlcik7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5hamF4X2FjdGlvbj09XCJzdWJtaXRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7IC8vZ3JhYiBhIGNvcHkgb2YgaHRlIFVSTCBwYXJhbXMgd2l0aG91dCBwYWdpbmF0aW9uIGFscmVhZHkgYWRkZWRcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBcIlwiO1xyXG4gICAgICAgICAgICB2YXIgYWpheF9yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBkYXRhX3R5cGUgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ107XHJcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xyXG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcclxuXHJcblxyXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXHJcbiAgICAgICAgICAgIGlmKHNlbGYubGFzdF9hamF4X3JlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB2YXIgYWpheF9hY3Rpb24gPSBzZWxmLmFqYXhfYWN0aW9uO1xyXG4gICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gJC5nZXQoYWpheF9wcm9jZXNzaW5nX3VybCwgZnVuY3Rpb24oZGF0YSwgc3RhdHVzLCByZXF1ZXN0KVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlUmVzdWx0cyhkYXRhLCBkYXRhX3R5cGUpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vIHNjcm9sbCBcclxuICAgICAgICAgICAgICAgIC8vIHNldCB0aGUgdmFyIGJhY2sgdG8gd2hhdCBpdCB3YXMgYmVmb3JlIHRoZSBhamF4IHJlcXVlc3QgbmFkIHRoZSBmb3JtIHJlLWluaXRcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9hY3Rpb24gPSBhamF4X2FjdGlvbjtcclxuICAgICAgICAgICAgICAgIHNlbGYuc2Nyb2xsUmVzdWx0cyggc2VsZi5hamF4X2FjdGlvbiApO1xyXG5cclxuICAgICAgICAgICAgICAgIC8qIHVwZGF0ZSBVUkwgKi9cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlIHVybCBiZWZvcmUgcGFnaW5hdGlvbiwgYmVjYXVzZSB3ZSBuZWVkIHRvIGRvIHNvbWUgY2hlY2tzIGFnYWlucyB0aGUgVVJMIGZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlVXJsSGlzdG9yeShhamF4X3Jlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NldHVwIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gZmFsc2U7XHJcblxyXG4gICAgICAgICAgICAgICAgLyogdXNlciBkZWYgKi9cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMoKTsgLy93b29jb21tZXJjZSBvcmRlcmJ5XHJcblxyXG5cclxuICAgICAgICAgICAgfSwgZGF0YV90eXBlKS5mYWlsKGZ1bmN0aW9uKGpxWEhSLCB0ZXh0U3RhdHVzLCBlcnJvclRocm93bilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmFqYXhVUkwgPSBhamF4X3Byb2Nlc3NpbmdfdXJsO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5qcVhIUiA9IGpxWEhSO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50ZXh0U3RhdHVzID0gdGV4dFN0YXR1cztcclxuICAgICAgICAgICAgICAgIGRhdGEuZXJyb3JUaHJvd24gPSBlcnJvclRocm93bjtcclxuICAgICAgICAgICAgICAgIHNlbGYuaXNTdWJtaXR0aW5nID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBkYXRhKTtcclxuXHJcbiAgICAgICAgICAgIH0pLmFsd2F5cyhmdW5jdGlvbigpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuc3RvcCh0cnVlLHRydWUpLmFuaW1hdGUoeyBvcGFjaXR5OiAxfSwgXCJmYXN0XCIpOyAvL2ZpbmlzaGVkIGxvYWRpbmdcclxuICAgICAgICAgICAgICAgIHNlbGYuZmFkZUNvbnRlbnRBcmVhcyggXCJpblwiICk7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuICAgICAgICAgICAgICAgICR0aGlzLnJlbW92ZUNsYXNzKFwic2VhcmNoLWZpbHRlci1kaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9yZWZvY3VzIHRoZSBsYXN0IGFjdGl2ZSB0ZXh0IGZpZWxkXHJcbiAgICAgICAgICAgICAgICBpZihsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0IT1cIlwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkaW5wdXQgPSBbXTtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmVfaW5wdXQgPSAkKHRoaXMpLmZpbmQoXCJpbnB1dFtuYW1lPSdcIitsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0K1wiJ11cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRhY3RpdmVfaW5wdXQubGVuZ3RoPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkaW5wdXQgPSAkYWN0aXZlX2lucHV0O1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKCRpbnB1dC5sZW5ndGg9PTEpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRpbnB1dC5mb2N1cygpLnZhbCgkaW5wdXQudmFsKCkpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZvY3VzQ2FtcG8oJGlucHV0WzBdKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMuZmluZChcImlucHV0W25hbWU9J19zZl9zZWFyY2gnXVwiKS50cmlnZ2VyKCdmb2N1cycpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZmluaXNoXCIsICBkYXRhICk7XHJcblxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmZvY3VzQ2FtcG8gPSBmdW5jdGlvbihpbnB1dEZpZWxkKXtcclxuICAgICAgICAgICAgLy92YXIgaW5wdXRGaWVsZCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlkKTtcclxuICAgICAgICAgICAgaWYgKGlucHV0RmllbGQgIT0gbnVsbCAmJiBpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aCAhPSAwKXtcclxuICAgICAgICAgICAgICAgIGlmIChpbnB1dEZpZWxkLmNyZWF0ZVRleHRSYW5nZSl7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIEZpZWxkUmFuZ2UgPSBpbnB1dEZpZWxkLmNyZWF0ZVRleHRSYW5nZSgpO1xyXG4gICAgICAgICAgICAgICAgICAgIEZpZWxkUmFuZ2UubW92ZVN0YXJ0KCdjaGFyYWN0ZXInLGlucHV0RmllbGQudmFsdWUubGVuZ3RoKTtcclxuICAgICAgICAgICAgICAgICAgICBGaWVsZFJhbmdlLmNvbGxhcHNlKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgRmllbGRSYW5nZS5zZWxlY3QoKTtcclxuICAgICAgICAgICAgICAgIH1lbHNlIGlmIChpbnB1dEZpZWxkLnNlbGVjdGlvblN0YXJ0IHx8IGlucHV0RmllbGQuc2VsZWN0aW9uU3RhcnQgPT0gJzAnKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGVsZW1MZW4gPSBpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aDtcclxuICAgICAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLnNlbGVjdGlvblN0YXJ0ID0gZWxlbUxlbjtcclxuICAgICAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLnNlbGVjdGlvbkVuZCA9IGVsZW1MZW47XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLmJsdXIoKTtcclxuICAgICAgICAgICAgICAgIGlucHV0RmllbGQuZm9jdXMoKTtcclxuICAgICAgICAgICAgfSBlbHNle1xyXG4gICAgICAgICAgICAgICAgaWYgKCBpbnB1dEZpZWxkICkge1xyXG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuZm9jdXMoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIFxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnRyaWdnZXJFdmVudCA9IGZ1bmN0aW9uKGV2ZW50bmFtZSwgZGF0YSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciAkZXZlbnRfY29udGFpbmVyID0gJChcIi5zZWFyY2hhbmRmaWx0ZXJbZGF0YS1zZi1mb3JtLWlkPSdcIitzZWxmLnNmaWQrXCInXVwiKTtcclxuICAgICAgICAgICAgJGV2ZW50X2NvbnRhaW5lci50cmlnZ2VyKGV2ZW50bmFtZSwgWyBkYXRhIF0pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5mZXRjaEFqYXhGb3JtID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XHJcbiAgICAgICAgICAgIHZhciBldmVudF9kYXRhID0ge1xyXG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxyXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcclxuICAgICAgICAgICAgICAgIHR5cGU6IFwiZm9ybVwiLFxyXG4gICAgICAgICAgICAgICAgb2JqZWN0OiBzZWxmXHJcbiAgICAgICAgICAgIH07XHJcblxyXG4gICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmb3Jtc3RhcnRcIiwgWyBldmVudF9kYXRhIF0pO1xyXG5cclxuICAgICAgICAgICAgJHRoaXMuYWRkQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZGlzYWJsZUlucHV0cyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcygpO1xyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi5sYW5nX2NvZGUhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vc28gYWRkIGl0XHJcbiAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwibGFuZz1cIitzZWxmLmxhbmdfY29kZSk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBhamF4X3Byb2Nlc3NpbmdfdXJsID0gc2VsZi5hZGRVcmxQYXJhbShzZWxmLmFqYXhfZm9ybV91cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgIHZhciBkYXRhX3R5cGUgPSBcImpzb25cIjtcclxuXHJcblxyXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXHJcbiAgICAgICAgICAgIC8qaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcclxuICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcclxuICAgICAgICAgICAgIH0qL1xyXG5cclxuXHJcbiAgICAgICAgICAgIC8vc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9XHJcblxyXG4gICAgICAgICAgICAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLy91cGRhdGVzIHRoZSByZXN1dGxzICYgZm9ybSBodG1sXHJcbiAgICAgICAgICAgICAgICBzZWxmLnVwZGF0ZUZvcm0oZGF0YSwgZGF0YV90eXBlKTtcclxuXHJcblxyXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgWyBkYXRhIF0pO1xyXG5cclxuICAgICAgICAgICAgfSkuYWx3YXlzKGZ1bmN0aW9uKClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcblxyXG4gICAgICAgICAgICAgICAgJHRoaXMucmVtb3ZlQ2xhc3MoXCJzZWFyY2gtZmlsdGVyLWRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmVuYWJsZUlucHV0cyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmb3JtZmluaXNoXCIsIFsgZGF0YSBdKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5jb3B5TGlzdEl0ZW1zQ29udGVudHMgPSBmdW5jdGlvbigkbGlzdF9mcm9tLCAkbGlzdF90bylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIC8vY29weSBvdmVyIGNoaWxkIGxpc3QgaXRlbXNcclxuICAgICAgICAgICAgdmFyIGxpX2NvbnRlbnRzX2FycmF5ID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgIHZhciBmcm9tX2F0dHJpYnV0ZXMgPSBuZXcgQXJyYXkoKTtcclxuXHJcbiAgICAgICAgICAgIHZhciAkZnJvbV9maWVsZHMgPSAkbGlzdF9mcm9tLmZpbmQoXCI+IHVsID4gbGlcIik7XHJcblxyXG4gICAgICAgICAgICAkZnJvbV9maWVsZHMuZWFjaChmdW5jdGlvbihpKXtcclxuXHJcbiAgICAgICAgICAgICAgICBsaV9jb250ZW50c19hcnJheS5wdXNoKCQodGhpcykuaHRtbCgpKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgYXR0cmlidXRlcyA9ICQodGhpcykucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcbiAgICAgICAgICAgICAgICBmcm9tX2F0dHJpYnV0ZXMucHVzaChhdHRyaWJ1dGVzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3ZhciBmaWVsZF9uYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG4gICAgICAgICAgICAgICAgLy92YXIgdG9fZmllbGQgPSAkbGlzdF90by5maW5kKFwiPiB1bCA+IGxpW2RhdGEtc2YtZmllbGQtbmFtZT0nXCIrZmllbGRfbmFtZStcIiddXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vc2VsZi5jb3B5QXR0cmlidXRlcygkKHRoaXMpLCAkbGlzdF90bywgXCJkYXRhLXNmLVwiKTtcclxuXHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgdmFyIGxpX2l0ID0gMDtcclxuICAgICAgICAgICAgdmFyICR0b19maWVsZHMgPSAkbGlzdF90by5maW5kKFwiPiB1bCA+IGxpXCIpO1xyXG4gICAgICAgICAgICAkdG9fZmllbGRzLmVhY2goZnVuY3Rpb24oaSl7XHJcbiAgICAgICAgICAgICAgICAkKHRoaXMpLmh0bWwobGlfY29udGVudHNfYXJyYXlbbGlfaXRdKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGZyb21fZmllbGQgPSAkKCRmcm9tX2ZpZWxkcy5nZXQobGlfaXQpKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJHRvX2ZpZWxkID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICR0b19maWVsZC5yZW1vdmVBdHRyKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5jb3B5QXR0cmlidXRlcygkZnJvbV9maWVsZCwgJHRvX2ZpZWxkKTtcclxuXHJcbiAgICAgICAgICAgICAgICBsaV9pdCsrO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgIC8qdmFyICRmcm9tX2ZpZWxkcyA9ICRsaXN0X2Zyb20uZmluZChcIiB1bCA+IGxpXCIpO1xyXG4gICAgICAgICAgICAgdmFyICR0b19maWVsZHMgPSAkbGlzdF90by5maW5kKFwiID4gbGlcIik7XHJcbiAgICAgICAgICAgICAkZnJvbV9maWVsZHMuZWFjaChmdW5jdGlvbihpbmRleCwgdmFsKXtcclxuICAgICAgICAgICAgIGlmKCQodGhpcykuaGFzQXR0cmlidXRlKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpKVxyXG4gICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgIHRoaXMuY29weUF0dHJpYnV0ZXMoJGxpc3RfZnJvbSwgJGxpc3RfdG8pOyovXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZUZvcm1BdHRyaWJ1dGVzID0gZnVuY3Rpb24oJGxpc3RfZnJvbSwgJGxpc3RfdG8pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gJGxpc3RfZnJvbS5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgLy8gbG9vcCB0aHJvdWdoIDxzZWxlY3Q+IGF0dHJpYnV0ZXMgYW5kIGFwcGx5IHRoZW0gb24gPGRpdj5cclxuXHJcbiAgICAgICAgICAgIHZhciB0b19hdHRyaWJ1dGVzID0gJGxpc3RfdG8ucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcbiAgICAgICAgICAgICQuZWFjaCh0b19hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICRsaXN0X3RvLnJlbW92ZUF0dHIodGhpcy5uYW1lKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAkLmVhY2goZnJvbV9hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICRsaXN0X3RvLmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5jb3B5QXR0cmlidXRlcyA9IGZ1bmN0aW9uKCRmcm9tLCAkdG8sIHByZWZpeClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihwcmVmaXgpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgcHJlZml4ID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGZyb21fYXR0cmlidXRlcyA9ICRmcm9tLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHRvX2F0dHJpYnV0ZXMgPSAkdG8ucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcbiAgICAgICAgICAgICQuZWFjaCh0b19hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihwcmVmaXghPVwiXCIpIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAodGhpcy5uYW1lLmluZGV4T2YocHJlZml4KSA9PSAwKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICR0by5yZW1vdmVBdHRyKHRoaXMubmFtZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vJHRvLnJlbW92ZUF0dHIodGhpcy5uYW1lKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAkLmVhY2goZnJvbV9hdHRyaWJ1dGVzLCBmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICR0by5hdHRyKHRoaXMubmFtZSwgdGhpcy52YWx1ZSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5jb3B5Rm9ybUF0dHJpYnV0ZXMgPSBmdW5jdGlvbigkZnJvbSwgJHRvKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgJHRvLnJlbW92ZUF0dHIoXCJkYXRhLWN1cnJlbnQtdGF4b25vbXktYXJjaGl2ZVwiKTtcclxuICAgICAgICAgICAgdGhpcy5jb3B5QXR0cmlidXRlcygkZnJvbSwgJHRvKTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZUZvcm0gPSBmdW5jdGlvbihkYXRhLCBkYXRhX3R5cGUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgICAgICBpZihkYXRhX3R5cGU9PVwianNvblwiKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIGRpZCBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnQsIHNvIGV4cGVjdCBhbiBvYmplY3QgYmFja1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihkYXRhWydmb3JtJ10pIT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBhbGwgZXZlbnRzIGZyb20gUyZGIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUxpc3RJdGVtc0NvbnRlbnRzKCQoZGF0YVsnZm9ybSddKSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3JlIGluaXQgUyZGIGNsYXNzIG9uIHRoZSBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgLy8kdGhpcy5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9pZiBhamF4IGlzIGVuYWJsZWQgaW5pdCB0aGUgcGFnaW5hdGlvblxyXG5cclxuICAgICAgICAgICAgICAgICAgICB0aGlzLmluaXQodHJ1ZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgfVxyXG4gICAgICAgIHRoaXMuYWRkUmVzdWx0cyA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXHJcbiAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJlc3VsdHMgYW5kIGxvYWQgaW5cclxuICAgICAgICAgICAgICAgIC8vc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hcHBlbmQoZGF0YVsncmVzdWx0cyddKTtcclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSBkYXRhWydyZXN1bHRzJ107XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihkYXRhX3R5cGU9PVwiaHRtbFwiKVxyXG4gICAgICAgICAgICB7Ly93ZSBhcmUgZXhwZWN0aW5nIHRoZSBodG1sIG9mIHRoZSByZXN1bHRzIHBhZ2UgYmFjaywgc28gZXh0cmFjdCB0aGUgaHRtbCB3ZSBuZWVkXHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICRkYXRhX29iaiA9ICQoZGF0YSk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmFwcGVuZCgkZGF0YV9vYmouZmluZChzZWxmLmFqYXhfdGFyZ2V0X2F0dHIpLmh0bWwoKSk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxvYWRfbW9yZV9odG1sID0gJGRhdGFfb2JqLmZpbmQoc2VsZi5hamF4X3RhcmdldF9hdHRyKS5odG1sKCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBpbmZpbml0ZV9zY3JvbGxfZW5kID0gZmFsc2U7XHJcblxyXG4gICAgICAgICAgICBpZigkKFwiPGRpdj5cIitzZWxmLmxvYWRfbW9yZV9odG1sK1wiPC9kaXY+XCIpLmZpbmQoXCJbZGF0YS1zZWFyY2gtZmlsdGVyLWFjdGlvbj0naW5maW5pdGUtc2Nyb2xsLWVuZCddXCIpLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpbmZpbml0ZV9zY3JvbGxfZW5kID0gdHJ1ZTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy9pZiB0aGVyZSBpcyBhbm90aGVyIHNlbGVjdG9yIGZvciBpbmZpbml0ZSBzY3JvbGwsIGZpbmQgdGhlIGNvbnRlbnRzIG9mIHRoYXQgaW5zdGVhZFxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSAkKFwiPGRpdj5cIitzZWxmLmxvYWRfbW9yZV9odG1sK1wiPC9kaXY+XCIpLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyKS5odG1sKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgaWYoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJHJlc3VsdF9pdGVtcyA9ICQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpO1xyXG4gICAgICAgICAgICAgICAgdmFyICRyZXN1bHRfaXRlbXNfY29udGFpbmVyID0gJCgnPGRpdi8+Jywge30pO1xyXG4gICAgICAgICAgICAgICAgJHJlc3VsdF9pdGVtc19jb250YWluZXIuYXBwZW5kKCRyZXN1bHRfaXRlbXMpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lci5odG1sKCk7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKGluZmluaXRlX3Njcm9sbF9lbmQpXHJcbiAgICAgICAgICAgIHsvL3dlIGZvdW5kIGEgZGF0YSBhdHRyaWJ1dGUgc2lnbmFsbGluZyB0aGUgbGFzdCBwYWdlIHNvIGZpbmlzaCBoZXJlXHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2xvYWRfbW9yZV9odG1sID0gc2VsZi5sb2FkX21vcmVfaHRtbDtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmluZmluaXRlU2Nyb2xsQXBwZW5kKHNlbGYubG9hZF9tb3JlX2h0bWwpO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHNlbGYubGFzdF9sb2FkX21vcmVfaHRtbCE9PXNlbGYubG9hZF9tb3JlX2h0bWwpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vY2hlY2sgdG8gbWFrZSBzdXJlIHRoZSBuZXcgaHRtbCBmZXRjaGVkIGlzIGRpZmZlcmVudFxyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2xvYWRfbW9yZV9odG1sID0gc2VsZi5sb2FkX21vcmVfaHRtbDtcclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoc2VsZi5sb2FkX21vcmVfaHRtbCk7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgey8vd2UgcmVjZWl2ZWQgdGhlIHNhbWUgbWVzc2FnZSBhZ2FpbiBzbyBkb24ndCBhZGQsIGFuZCB0ZWxsIFMmRiB0aGF0IHdlJ3JlIGF0IHRoZSBlbmQuLlxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5pbmZpbml0ZVNjcm9sbEFwcGVuZCA9IGZ1bmN0aW9uKCRvYmplY3QpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MpLmxhc3QoKS5hZnRlcigkb2JqZWN0KTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5hcHBlbmQoJG9iamVjdCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZVJlc3VsdHMgPSBmdW5jdGlvbihkYXRhLCBkYXRhX3R5cGUpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgICAgICBpZihkYXRhX3R5cGU9PVwianNvblwiKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIGRpZCBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnQsIHNvIGV4cGVjdCBhbiBvYmplY3QgYmFja1xyXG4gICAgICAgICAgICAgICAgLy9ncmFiIHRoZSByZXN1bHRzIGFuZCBsb2FkIGluXHJcbiAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmh0bWwoZGF0YVsncmVzdWx0cyddKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZih0eXBlb2YoZGF0YVsnZm9ybSddKSE9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgYWxsIGV2ZW50cyBmcm9tIFMmRiBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgJHRoaXMub2ZmKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgICAgICBzZWxmLnJlbW92ZUFqYXhQYWdpbmF0aW9uKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVmcmVzaCB0aGUgZm9ybSAoYXV0byBjb3VudClcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlMaXN0SXRlbXNDb250ZW50cygkKGRhdGFbJ2Zvcm0nXSksICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy91cGRhdGUgYXR0cmlidXRlcyBvbiBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5Rm9ybUF0dHJpYnV0ZXMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmUgaW5pdCBTJkYgY2xhc3Mgb24gdGhlIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5zZWFyY2hBbmRGaWx0ZXIoeydpc0luaXQnOiBmYWxzZX0pO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vJHRoaXMuZmluZChcImlucHV0XCIpLnJlbW92ZUF0dHIoXCJkaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKGRhdGFfdHlwZT09XCJodG1sXCIpIHsvL3dlIGFyZSBleHBlY3RpbmcgdGhlIGh0bWwgb2YgdGhlIHJlc3VsdHMgcGFnZSBiYWNrLCBzbyBleHRyYWN0IHRoZSBodG1sIHdlIG5lZWRcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGRhdGFfb2JqID0gJChkYXRhKTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmh0bWwoJGRhdGFfb2JqLmZpbmQoc2VsZi5hamF4X3RhcmdldF9hdHRyKS5odG1sKCkpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlQ29udGVudEFyZWFzKCAkZGF0YV9vYmogKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZiAoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlclwiKS5sZW5ndGggPiAwKVxyXG4gICAgICAgICAgICAgICAgey8vdGhlbiB0aGVyZSBhcmUgc2VhcmNoIGZvcm0ocykgaW5zaWRlIHRoZSByZXN1bHRzIGNvbnRhaW5lciwgc28gcmUtaW5pdCB0aGVtXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJcIikuc2VhcmNoQW5kRmlsdGVyKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgLy9pZiB0aGUgY3VycmVudCBzZWFyY2ggZm9ybSBpcyBub3QgaW5zaWRlIHRoZSByZXN1bHRzIGNvbnRhaW5lciwgdGhlbiBwcm9jZWVkIGFzIG5vcm1hbCBhbmQgdXBkYXRlIHRoZSBmb3JtXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyW2RhdGEtc2YtZm9ybS1pZD0nXCIgKyBzZWxmLnNmaWQgKyBcIiddXCIpLmxlbmd0aD09MCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJG5ld19zZWFyY2hfZm9ybSA9ICRkYXRhX29iai5maW5kKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiICsgc2VsZi5zZmlkICsgXCInXVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKCRuZXdfc2VhcmNoX2Zvcm0ubGVuZ3RoID09IDEpIHsvL3RoZW4gcmVwbGFjZSB0aGUgc2VhcmNoIGZvcm0gd2l0aCB0aGUgbmV3IG9uZVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgYWxsIGV2ZW50cyBmcm9tIFMmRiBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLm9mZigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLnJlbW92ZUFqYXhQYWdpbmF0aW9uKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3JlZnJlc2ggdGhlIGZvcm0gKGF1dG8gY291bnQpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUxpc3RJdGVtc0NvbnRlbnRzKCRuZXdfc2VhcmNoX2Zvcm0sICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vdXBkYXRlIGF0dHJpYnV0ZXMgb24gZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlGb3JtQXR0cmlidXRlcygkbmV3X3NlYXJjaF9mb3JtLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3JlIGluaXQgUyZGIGNsYXNzIG9uIHRoZSBmb3JtXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLnNlYXJjaEFuZEZpbHRlcih7J2lzSW5pdCc6IGZhbHNlfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vJHRoaXMuZmluZChcImlucHV0XCIpLnJlbW92ZUF0dHIoXCJkaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYuaXNfbWF4X3BhZ2VkID0gZmFsc2U7IC8vZm9yIGluZmluaXRlIHNjcm9sbFxyXG4gICAgICAgICAgICBzZWxmLmN1cnJlbnRfcGFnZWQgPSAxOyAvL2ZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgc2VsZi5zZXRJbmZpbml0ZVNjcm9sbENvbnRhaW5lcigpO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlQ29udGVudEFyZWFzID0gZnVuY3Rpb24oICRodG1sX2RhdGEgKSB7XHJcbiAgICAgICAgICAgIFxyXG4gICAgICAgICAgICAvLyBhZGQgYWRkaXRpb25hbCBjb250ZW50IGFyZWFzXHJcbiAgICAgICAgICAgIGlmICggdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucyAmJiB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zLmxlbmd0aCApIHtcclxuICAgICAgICAgICAgICAgIGZvciAoaW5kZXggPSAwOyBpbmRleCA8IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoOyArK2luZGV4KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNlbGVjdG9yID0gdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9uc1tpbmRleF07XHJcbiAgICAgICAgICAgICAgICAgICAgJCggc2VsZWN0b3IgKS5odG1sKCAkaHRtbF9kYXRhLmZpbmQoIHNlbGVjdG9yICkuaHRtbCgpICk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5mYWRlQ29udGVudEFyZWFzID0gZnVuY3Rpb24oIGRpcmVjdGlvbiApIHtcclxuICAgICAgICAgICAgXHJcbiAgICAgICAgICAgIHZhciBvcGFjaXR5ID0gMC41O1xyXG4gICAgICAgICAgICBpZiAoIGRpcmVjdGlvbiA9PT0gXCJpblwiICkge1xyXG4gICAgICAgICAgICAgICAgb3BhY2l0eSA9IDE7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmICggdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9ucyAmJiB0aGlzLmFqYXhfdXBkYXRlX3NlY3Rpb25zLmxlbmd0aCApIHtcclxuICAgICAgICAgICAgICAgIGZvciAoaW5kZXggPSAwOyBpbmRleCA8IHRoaXMuYWpheF91cGRhdGVfc2VjdGlvbnMubGVuZ3RoOyArK2luZGV4KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNlbGVjdG9yID0gdGhpcy5hamF4X3VwZGF0ZV9zZWN0aW9uc1tpbmRleF07XHJcbiAgICAgICAgICAgICAgICAgICAgJCggc2VsZWN0b3IgKS5zdG9wKHRydWUsdHJ1ZSkuYW5pbWF0ZSggeyBvcGFjaXR5OiBvcGFjaXR5fSwgXCJmYXN0XCIgKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgIFxyXG4gICAgICAgICAgICBcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMucmVtb3ZlV29vQ29tbWVyY2VDb250cm9scyA9IGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnkgPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcgLm9yZGVyYnknKTtcclxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieV9mb3JtID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nJyk7XHJcblxyXG4gICAgICAgICAgICAkd29vX29yZGVyYnlfZm9ybS5vZmYoKTtcclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5Lm9mZigpO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuYWRkUXVlcnlQYXJhbSA9IGZ1bmN0aW9uKG5hbWUsIHZhbHVlLCB1cmxfdHlwZSl7XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YodXJsX3R5cGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgdXJsX3R5cGUgPSBcImFsbFwiO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW3VybF90eXBlXVtuYW1lXSA9IHZhbHVlO1xyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmluaXRXb29Db21tZXJjZUNvbnRyb2xzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIHNlbGYucmVtb3ZlV29vQ29tbWVyY2VDb250cm9scygpO1xyXG5cclxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZyAub3JkZXJieScpO1xyXG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5X2Zvcm0gPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcnKTtcclxuXHJcbiAgICAgICAgICAgIHZhciBvcmRlcl92YWwgPSBcIlwiO1xyXG4gICAgICAgICAgICBpZigkd29vX29yZGVyYnkubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9ICR3b29fb3JkZXJieS52YWwoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJvcmRlcmJ5XCIsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYob3JkZXJfdmFsPT1cIm1lbnVfb3JkZXJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgb3JkZXJfdmFsID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoKG9yZGVyX3ZhbCE9XCJcIikmJighIW9yZGVyX3ZhbCkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zLmFsbC5vcmRlcmJ5ID0gb3JkZXJfdmFsO1xyXG4gICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5X2Zvcm0ub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKGUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgICAgIC8vdmFyIGZvcm0gPSBlLnRhcmdldDtcclxuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAkd29vX29yZGVyYnkub24oXCJjaGFuZ2VcIiwgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSAkKHRoaXMpLnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgaWYodmFsPT1cIm1lbnVfb3JkZXJcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YWwgPSBcIlwiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zLmFsbC5vcmRlcmJ5ID0gdmFsO1xyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLnRyaWdnZXIoXCJzdWJtaXRcIilcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuc2Nyb2xsUmVzdWx0cyA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICAgICAgaWYoKHNlbGYuc2Nyb2xsX29uX2FjdGlvbj09c2VsZi5hamF4X2FjdGlvbil8fChzZWxmLnNjcm9sbF9vbl9hY3Rpb249PVwiYWxsXCIpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnNjcm9sbFRvUG9zKCk7IC8vc2Nyb2xsIHRoZSB3aW5kb3cgaWYgaXQgaGFzIGJlZW4gc2V0XHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9hY3Rpb24gPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnVwZGF0ZVVybEhpc3RvcnkgPSBmdW5jdGlvbihhamF4X3Jlc3VsdHNfdXJsKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgdmFyIHVzZV9oaXN0b3J5X2FwaSA9IDA7XHJcbiAgICAgICAgICAgIGlmICh3aW5kb3cuaGlzdG9yeSAmJiB3aW5kb3cuaGlzdG9yeS5wdXNoU3RhdGUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHVzZV9oaXN0b3J5X2FwaSA9ICR0aGlzLmF0dHIoXCJkYXRhLXVzZS1oaXN0b3J5LWFwaVwiKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoKHNlbGYudXBkYXRlX2FqYXhfdXJsPT0xKSYmKHVzZV9oaXN0b3J5X2FwaT09MSkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vbm93IGNoZWNrIGlmIHRoZSBicm93c2VyIHN1cHBvcnRzIGhpc3Rvcnkgc3RhdGUgcHVzaCA6KVxyXG4gICAgICAgICAgICAgICAgaWYgKHdpbmRvdy5oaXN0b3J5ICYmIHdpbmRvdy5oaXN0b3J5LnB1c2hTdGF0ZSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBoaXN0b3J5LnB1c2hTdGF0ZShudWxsLCBudWxsLCBhamF4X3Jlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLnJlbW92ZUFqYXhQYWdpbmF0aW9uID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHNlbGYuYWpheF9saW5rc19zZWxlY3RvcikhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciAkYWpheF9saW5rc19vYmplY3QgPSBqUXVlcnkoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigkYWpheF9saW5rc19vYmplY3QubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgJGFqYXhfbGlua3Nfb2JqZWN0Lm9mZigpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmdldEJhc2VVcmwgPSBmdW5jdGlvbiggdXJsICkge1xyXG4gICAgICAgICAgICAvL25vdyBzZWUgaWYgd2UgYXJlIG9uIHRoZSBVUkwgd2UgdGhpbmsuLi5cclxuICAgICAgICAgICAgdmFyIHVybF9wYXJ0cyA9IHVybC5zcGxpdChcIj9cIik7XHJcbiAgICAgICAgICAgIHZhciB1cmxfYmFzZSA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICBpZih1cmxfcGFydHMubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHVybF9iYXNlID0gdXJsX3BhcnRzWzBdO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSB1cmw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgcmV0dXJuIHVybF9iYXNlO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmNhbkZldGNoQWpheFJlc3VsdHMgPSBmdW5jdGlvbihmZXRjaF90eXBlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGZldGNoX3R5cGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZmV0Y2hfdHlwZSA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICAgICAgdmFyIGZldGNoX2FqYXhfcmVzdWx0cyA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgYWpheCBzdWJtaXQgdGhlIGZvcm1cclxuXHJcbiAgICAgICAgICAgICAgICAvL2FuZCBpZiB3ZSBjYW4gZmluZCB0aGUgcmVzdWx0cyBjb250YWluZXJcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIubGVuZ3RoPT0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gc2VsZi5yZXN1bHRzX3VybDsgIC8vXHJcbiAgICAgICAgICAgICAgICB2YXIgcmVzdWx0c191cmxfZW5jb2RlZCA9ICcnOyAgLy9cclxuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3VybCA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vaWdub3JlICMgYW5kIGV2ZXJ5dGhpbmcgYWZ0ZXJcclxuICAgICAgICAgICAgICAgIHZhciBoYXNoX3BvcyA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmLmluZGV4T2YoJyMnKTtcclxuICAgICAgICAgICAgICAgIGlmKGhhc2hfcG9zIT09LTEpe1xyXG4gICAgICAgICAgICAgICAgICAgIGN1cnJlbnRfdXJsID0gd2luZG93LmxvY2F0aW9uLmhyZWYuc3Vic3RyKDAsIHdpbmRvdy5sb2NhdGlvbi5ocmVmLmluZGV4T2YoJyMnKSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoICggKCBzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJjdXN0b21fd29vY29tbWVyY2Vfc3RvcmVcIiApIHx8ICggc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwicG9zdF90eXBlX2FyY2hpdmVcIiApICkgJiYgKCBzZWxmLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcyA9PSAxICkgKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKCBzZWxmLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSAhPT1cIlwiIClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmZXRjaF9hamF4X3Jlc3VsdHM7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAvKnZhciByZXN1bHRzX3VybCA9IHByb2Nlc3NfZm9ybS5nZXRSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgICAgICB2YXIgYWN0aXZlX3RheCA9IHByb2Nlc3NfZm9ybS5nZXRBY3RpdmVUYXgoKTtcclxuICAgICAgICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUsICcnLCBhY3RpdmVfdGF4KTsqL1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgIC8vbm93IHNlZSBpZiB3ZSBhcmUgb24gdGhlIFVSTCB3ZSB0aGluay4uLlxyXG4gICAgICAgICAgICAgICAgdmFyIHVybF9iYXNlID0gdGhpcy5nZXRCYXNlVXJsKCBjdXJyZW50X3VybCApO1xyXG4gICAgICAgICAgICAgICAgLy92YXIgcmVzdWx0c191cmxfYmFzZSA9IHRoaXMuZ2V0QmFzZVVybCggY3VycmVudF91cmwgKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgbGFuZyA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJsYW5nXCIsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcclxuICAgICAgICAgICAgICAgIGlmKCh0eXBlb2YobGFuZykhPT1cInVuZGVmaW5lZFwiKSYmKGxhbmchPT1udWxsKSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHNlbGYuYWRkVXJsUGFyYW0odXJsX2Jhc2UsIFwibGFuZz1cIitsYW5nKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgc2ZpZCA9IHNlbGYuZ2V0UXVlcnlQYXJhbUZyb21VUkwoXCJzZmlkXCIsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL2lmIHNmaWQgaXMgYSBudW1iZXJcclxuICAgICAgICAgICAgICAgIGlmKE51bWJlcihwYXJzZUZsb2F0KHNmaWQpKSA9PSBzZmlkKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHVybF9iYXNlID0gc2VsZi5hZGRVcmxQYXJhbSh1cmxfYmFzZSwgXCJzZmlkPVwiK3NmaWQpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vaWYgYW55IG9mIHRoZSAzIGNvbmRpdGlvbnMgYXJlIHRydWUsIHRoZW4gaXRzIGdvb2QgdG8gZ29cclxuICAgICAgICAgICAgICAgIC8vIC0gMSB8IGlmIHRoZSB1cmwgYmFzZSA9PSByZXN1bHRzX3VybFxyXG4gICAgICAgICAgICAgICAgLy8gLSAyIHwgaWYgdXJsIGJhc2UrIFwiL1wiICA9PSByZXN1bHRzX3VybCAtIGluIGNhc2Ugb2YgdXNlciBlcnJvciBpbiB0aGUgcmVzdWx0cyBVUkxcclxuICAgICAgICAgICAgICAgIC8vIC0gMyB8IGlmIHRoZSByZXN1bHRzIFVSTCBoYXMgdXJsIHBhcmFtcywgYW5kIHRoZSBjdXJyZW50IHVybCBzdGFydHMgd2l0aCB0aGUgcmVzdWx0cyBVUkwgXHJcblxyXG4gICAgICAgICAgICAgICAgLy90cmltIGFueSB0cmFpbGluZyBzbGFzaCBmb3IgZWFzaWVyIGNvbXBhcmlzb246XHJcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9iYXNlLnJlcGxhY2UoL1xcLyQvLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybCA9IHJlc3VsdHNfdXJsLnJlcGxhY2UoL1xcLyQvLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybF9lbmNvZGVkID0gZW5jb2RlVVJJKHJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgIFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IC0xO1xyXG4gICAgICAgICAgICAgICAgaWYoKHVybF9iYXNlPT1yZXN1bHRzX3VybCl8fCh1cmxfYmFzZS50b0xvd2VyQ2FzZSgpPT1yZXN1bHRzX3VybF9lbmNvZGVkLnRvTG93ZXJDYXNlKCkpICApe1xyXG4gICAgICAgICAgICAgICAgICAgIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID0gMTtcclxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKCByZXN1bHRzX3VybC5pbmRleE9mKCAnPycgKSAhPT0gLTEgJiYgY3VycmVudF91cmwubGFzdEluZGV4T2YocmVzdWx0c191cmwsIDApID09PSAwICkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IDE7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKHNlbGYub25seV9yZXN1bHRzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgICAgICB7Ly9pZiBhIHVzZXIgaGFzIGNob3NlbiB0byBvbmx5IGFsbG93IGFqYXggb24gcmVzdWx0cyBwYWdlcyAoZGVmYXVsdCBiZWhhdmlvdXIpXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA+IC0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHsvL3RoaXMgbWVhbnMgdGhlIGN1cnJlbnQgVVJMIGNvbnRhaW5zIHRoZSByZXN1bHRzIHVybCwgd2hpY2ggbWVhbnMgd2UgY2FuIGRvIGFqYXhcclxuICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZmV0Y2hfYWpheF9yZXN1bHRzID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKGZldGNoX3R5cGU9PVwicGFnaW5hdGlvblwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID4gLTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHsvL3RoaXMgbWVhbnMgdGhlIGN1cnJlbnQgVVJMIGNvbnRhaW5zIHRoZSByZXN1bHRzIHVybCwgd2hpY2ggbWVhbnMgd2UgY2FuIGRvIGFqYXhcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL2Rvbid0IGFqYXggcGFnaW5hdGlvbiB3aGVuIG5vdCBvbiBhIFMmRiBwYWdlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZldGNoX2FqYXhfcmVzdWx0cztcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuc2V0dXBBamF4UGFnaW5hdGlvbiA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIC8vaW5maW5pdGUgc2Nyb2xsXHJcbiAgICAgICAgICAgIGlmKHRoaXMucGFnaW5hdGlvbl90eXBlPT09XCJpbmZpbml0ZV9zY3JvbGxcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGluZmluaXRlX3Njcm9sbF9lbmQgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIltkYXRhLXNlYXJjaC1maWx0ZXItYWN0aW9uPSdpbmZpbml0ZS1zY3JvbGwtZW5kJ11cIikubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pc19tYXhfcGFnZWQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKHBhcnNlSW50KHRoaXMuaW5zdGFuY2VfbnVtYmVyKT09PTEpIHtcclxuICAgICAgICAgICAgICAgICAgICAkKHdpbmRvdykub2ZmKFwic2Nyb2xsXCIsIHNlbGYub25XaW5kb3dTY3JvbGwpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAoc2VsZi5jYW5GZXRjaEFqYXhSZXN1bHRzKFwicGFnaW5hdGlvblwiKSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKHdpbmRvdykub24oXCJzY3JvbGxcIiwgc2VsZi5vbldpbmRvd1Njcm9sbCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYodHlwZW9mKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik9PVwidW5kZWZpbmVkXCIpIHtcclxuICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgICAgICQoZG9jdW1lbnQpLm9mZignY2xpY2snLCBzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpO1xyXG4gICAgICAgICAgICAgICAgJChkb2N1bWVudCkub2ZmKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcbiAgICAgICAgICAgICAgICAkKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcikub2ZmKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgJChkb2N1bWVudCkub24oJ2NsaWNrJywgc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yLCBmdW5jdGlvbihlKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5jYW5GZXRjaEFqYXhSZXN1bHRzKFwicGFnaW5hdGlvblwiKSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBsaW5rID0galF1ZXJ5KHRoaXMpLmF0dHIoJ2hyZWYnKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5hamF4X2FjdGlvbiA9IFwicGFnaW5hdGlvblwiO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHBhZ2VOdW1iZXIgPSBzZWxmLmdldFBhZ2VkRnJvbVVSTChsaW5rKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIiwgcGFnZU51bWJlcik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZldGNoQWpheFJlc3VsdHMoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZ2V0UGFnZWRGcm9tVVJMID0gZnVuY3Rpb24oVVJMKXtcclxuXHJcbiAgICAgICAgICAgIHZhciBwYWdlZFZhbCA9IDE7XHJcbiAgICAgICAgICAgIC8vZmlyc3QgdGVzdCB0byBzZWUgaWYgd2UgaGF2ZSBcIi9wYWdlLzQvXCIgaW4gdGhlIFVSTFxyXG4gICAgICAgICAgICB2YXIgdHBWYWwgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwic2ZfcGFnZWRcIiwgVVJMKTtcclxuICAgICAgICAgICAgaWYoKHR5cGVvZih0cFZhbCk9PVwic3RyaW5nXCIpfHwodHlwZW9mKHRwVmFsKT09XCJudW1iZXJcIikpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHBhZ2VkVmFsID0gdHBWYWw7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBwYWdlZFZhbDtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMID0gZnVuY3Rpb24obmFtZSwgVVJMKXtcclxuXHJcbiAgICAgICAgICAgIHZhciBxc3RyaW5nID0gXCI/XCIrVVJMLnNwbGl0KCc/JylbMV07XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihxc3RyaW5nKSE9XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHZhbCA9IGRlY29kZVVSSUNvbXBvbmVudCgobmV3IFJlZ0V4cCgnWz98Jl0nICsgbmFtZSArICc9JyArICcoW14mO10rPykoJnwjfDt8JCknKS5leGVjKHFzdHJpbmcpfHxbLFwiXCJdKVsxXS5yZXBsYWNlKC9cXCsvZywgJyUyMCcpKXx8bnVsbDtcclxuICAgICAgICAgICAgICAgIHJldHVybiB2YWw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgcmV0dXJuIFwiXCI7XHJcbiAgICAgICAgfTtcclxuXHJcblxyXG5cclxuICAgICAgICB0aGlzLmZvcm1VcGRhdGVkID0gZnVuY3Rpb24oZSl7XHJcblxyXG4gICAgICAgICAgICAvL2UucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgaWYoc2VsZi5hdXRvX3VwZGF0ZT09MSkge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zdWJtaXRGb3JtKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZigoc2VsZi5hdXRvX3VwZGF0ZT09MCkmJihzZWxmLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5mb3JtVXBkYXRlZEZldGNoQWpheCgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5mb3JtVXBkYXRlZEZldGNoQWpheCA9IGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICAvL2xvb3AgdGhyb3VnaCBhbGwgdGhlIGZpZWxkcyBhbmQgYnVpbGQgdGhlIFVSTFxyXG4gICAgICAgICAgICBzZWxmLmZldGNoQWpheEZvcm0oKTtcclxuXHJcblxyXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgLy9tYWtlIGFueSBjb3JyZWN0aW9ucy91cGRhdGVzIHRvIGZpZWxkcyBiZWZvcmUgdGhlIHN1Ym1pdCBjb21wbGV0ZXNcclxuICAgICAgICB0aGlzLnNldEZpZWxkcyA9IGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgLy9pZihzZWxmLmlzX2FqYXg9PTApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NvbWV0aW1lcyB0aGUgZm9ybSBpcyBzdWJtaXR0ZWQgd2l0aG91dCB0aGUgc2xpZGVyIHlldCBoYXZpbmcgdXBkYXRlZCwgYW5kIGFzIHdlIGdldCBvdXIgdmFsdWVzIGZyb21cclxuICAgICAgICAgICAgICAgIC8vdGhlIHNsaWRlciBhbmQgbm90IGlucHV0cywgd2UgbmVlZCB0byBjaGVjayBpdCBpZiBuZWVkcyB0byBiZSBzZXRcclxuICAgICAgICAgICAgICAgIC8vb25seSBvY2N1cnMgaWYgYWpheCBpcyBvZmYsIGFuZCBhdXRvc3VibWl0IG9uXHJcbiAgICAgICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRmaWVsZCA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciByYW5nZV9kaXNwbGF5X3ZhbHVlcyA9ICRmaWVsZC5maW5kKCcuc2YtbWV0YS1yYW5nZS1zbGlkZXInKS5hdHRyKFwiZGF0YS1kaXNwbGF5LXZhbHVlcy1hc1wiKTsvL2RhdGEtZGlzcGxheS12YWx1ZXMtYXM9XCJ0ZXh0XCJcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYocmFuZ2VfZGlzcGxheV92YWx1ZXM9PT1cInRleHRpbnB1dFwiKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkZmllbGQuZmluZChcIi5tZXRhLXNsaWRlclwiKS5sZW5ndGg+MCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmVhY2goZnVuY3Rpb24gKGluZGV4KSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9vYmplY3QgPSAkKHRoaXMpWzBdO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRzbGlkZXJfZWwgPSAkKHRoaXMpLmNsb3Nlc3QoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL3ZhciBtaW5WYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vdmFyIG1heFZhbCA9ICRzbGlkZXJfZWwuYXR0cihcImRhdGEtbWF4XCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG1pblZhbCA9ICRzbGlkZXJfZWwuZmluZChcIi5zZi1yYW5nZS1taW5cIikudmFsKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgbWF4VmFsID0gJHNsaWRlcl9lbC5maW5kKFwiLnNmLXJhbmdlLW1heFwiKS52YWwoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5zZXQoW21pblZhbCwgbWF4VmFsXSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgLy99XHJcblxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgLy9zdWJtaXRcclxuICAgICAgICB0aGlzLnN1Ym1pdEZvcm0gPSBmdW5jdGlvbihlKXtcclxuXHJcbiAgICAgICAgICAgIC8vbG9vcCB0aHJvdWdoIGFsbCB0aGUgZmllbGRzIGFuZCBidWlsZCB0aGUgVVJMXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaXNTdWJtaXR0aW5nID09IHRydWUpIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRGaWVsZHMoKTtcclxuICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7XHJcblxyXG4gICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICBwcm9jZXNzX2Zvcm0uc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIsIDEpOyAvL2luaXQgcGFnZWRcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYuY2FuRmV0Y2hBamF4UmVzdWx0cygpKVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgYWpheCBzdWJtaXQgdGhlIGZvcm1cclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gXCJzdWJtaXRcIjsgLy9zbyB3ZSBrbm93IGl0IHdhc24ndCBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICBzZWxmLmZldGNoQWpheFJlc3VsdHMoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2lsbCBzaW1wbHkgcmVkaXJlY3QgdG8gdGhlIFJlc3VsdHMgVVJMXHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSwgJycpO1xyXG4gICAgICAgICAgICAgICAgcmVzdWx0c191cmwgPSBzZWxmLmFkZFVybFBhcmFtKHJlc3VsdHNfdXJsLCBxdWVyeV9wYXJhbXMpO1xyXG5cclxuICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gcmVzdWx0c191cmw7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICB9O1xyXG4gICAgICAgIHRoaXMucmVzZXRGb3JtID0gZnVuY3Rpb24oc3VibWl0X2Zvcm0pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvL3Vuc2V0IGFsbCBmaWVsZHNcclxuICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGZpZWxkID0gJCh0aGlzKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQkZmllbGQucmVtb3ZlQXR0cihcImRhdGEtc2YtdGF4b25vbXktYXJjaGl2ZVwiKTtcclxuXHRcdFx0XHRcclxuICAgICAgICAgICAgICAgIC8vc3RhbmRhcmQgZmllbGQgdHlwZXNcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwic2VsZWN0Om5vdChbbXVsdGlwbGU9J211bHRpcGxlJ10pID4gb3B0aW9uOmZpcnN0LWNoaWxkXCIpLnByb3AoXCJzZWxlY3RlZFwiLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwic2VsZWN0W211bHRpcGxlPSdtdWx0aXBsZSddID4gb3B0aW9uXCIpLnByb3AoXCJzZWxlY3RlZFwiLCBmYWxzZSk7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcImlucHV0W3R5cGU9J2NoZWNrYm94J11cIikucHJvcChcImNoZWNrZWRcIiwgZmFsc2UpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCI+IHVsID4gbGk6Zmlyc3QtY2hpbGQgaW5wdXRbdHlwZT0ncmFkaW8nXVwiKS5wcm9wKFwiY2hlY2tlZFwiLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiaW5wdXRbdHlwZT0ndGV4dCddXCIpLnZhbChcIlwiKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLnNmLW9wdGlvbi1hY3RpdmVcIikucmVtb3ZlQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCI+IHVsID4gbGk6Zmlyc3QtY2hpbGQgaW5wdXRbdHlwZT0ncmFkaW8nXVwiKS5wYXJlbnQoKS5hZGRDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7IC8vcmUgYWRkIGFjdGl2ZSBjbGFzcyB0byBmaXJzdCBcImRlZmF1bHRcIiBvcHRpb25cclxuXHJcbiAgICAgICAgICAgICAgICAvL251bWJlciByYW5nZSAtIDIgbnVtYmVyIGlucHV0IGZpZWxkc1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJpbnB1dFt0eXBlPSdudW1iZXInXVwiKS5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzSW5wdXQgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZigkdGhpc0lucHV0LnBhcmVudCgpLnBhcmVudCgpLmhhc0NsYXNzKFwic2YtbWV0YS1yYW5nZVwiKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoaW5kZXg9PTApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKCR0aGlzSW5wdXQuYXR0cihcIm1pblwiKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihpbmRleD09MSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoJHRoaXNJbnB1dC5hdHRyKFwibWF4XCIpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL21ldGEgLyBudW1iZXJzIHdpdGggMiBpbnB1dHMgKGZyb20gLyB0byBmaWVsZHMpIC0gc2Vjb25kIGlucHV0IG11c3QgYmUgcmVzZXQgdG8gbWF4IHZhbHVlXHJcbiAgICAgICAgICAgICAgICB2YXIgJG1ldGFfc2VsZWN0X2Zyb21fdG8gPSAkZmllbGQuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNlbGVjdC1mcm9tdG9cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJG1ldGFfc2VsZWN0X2Zyb21fdG8ubGVuZ3RoPjApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21pbiA9ICRtZXRhX3NlbGVjdF9mcm9tX3RvLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWF4ID0gJG1ldGFfc2VsZWN0X2Zyb21fdG8uYXR0cihcImRhdGEtbWF4XCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkbWV0YV9zZWxlY3RfZnJvbV90by5maW5kKFwic2VsZWN0XCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzSW5wdXQgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoaW5kZXg9PTApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbChzdGFydF9taW4pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoaW5kZXg9PTEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKHN0YXJ0X21heCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyICRtZXRhX3JhZGlvX2Zyb21fdG8gPSAkZmllbGQuZmluZChcIi5zZi1tZXRhLXJhbmdlLXJhZGlvLWZyb210b1wiKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigkbWV0YV9yYWRpb19mcm9tX3RvLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9taW4gPSAkbWV0YV9yYWRpb19mcm9tX3RvLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWF4ID0gJG1ldGFfcmFkaW9fZnJvbV90by5hdHRyKFwiZGF0YS1tYXhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkcmFkaW9fZ3JvdXBzID0gJG1ldGFfcmFkaW9fZnJvbV90by5maW5kKCcuc2YtaW5wdXQtcmFuZ2UtcmFkaW8nKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJHJhZGlvX2dyb3Vwcy5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHJhZGlvcyA9ICQodGhpcykuZmluZChcIi5zZi1pbnB1dC1yYWRpb1wiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHJhZGlvcy5wcm9wKFwiY2hlY2tlZFwiLCBmYWxzZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MClcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHJhZGlvcy5maWx0ZXIoJ1t2YWx1ZT1cIicrc3RhcnRfbWluKydcIl0nKS5wcm9wKFwiY2hlY2tlZFwiLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLmZpbHRlcignW3ZhbHVlPVwiJytzdGFydF9tYXgrJ1wiXScpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAvL251bWJlciBzbGlkZXIgLSBub1VpU2xpZGVyXHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIi5tZXRhLXNsaWRlclwiKS5lYWNoKGZ1bmN0aW9uKGluZGV4KXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9vYmplY3QgPSAkKHRoaXMpWzBdO1xyXG4gICAgICAgICAgICAgICAgICAgIC8qdmFyIHNsaWRlcl9vYmplY3QgPSAkY29udGFpbmVyLmZpbmQoXCIubWV0YS1zbGlkZXJcIilbMF07XHJcbiAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfdmFsID0gc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmdldCgpOyovXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkc2xpZGVyX2VsID0gJCh0aGlzKS5jbG9zZXN0KFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5WYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1pblwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWF4VmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbbWluVmFsLCBtYXhWYWxdKTtcclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL25lZWQgdG8gc2VlIGlmIGFueSBhcmUgY29tYm9ib3ggYW5kIGFjdCBhY2NvcmRpbmdseVxyXG4gICAgICAgICAgICAgICAgdmFyICRjb21ib2JveCA9ICRmaWVsZC5maW5kKFwic2VsZWN0W2RhdGEtY29tYm9ib3g9JzEnXVwiKTtcclxuICAgICAgICAgICAgICAgIGlmKCRjb21ib2JveC5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAodHlwZW9mICRjb21ib2JveC5jaG9zZW4gIT0gXCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC50cmlnZ2VyKFwiY2hvc2VuOnVwZGF0ZWRcIik7IC8vZm9yIGNob3NlbiBvbmx5XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC52YWwoJycpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkY29tYm9ib3gudHJpZ2dlcignY2hhbmdlLnNlbGVjdDInKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpO1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICBpZihzdWJtaXRfZm9ybT09XCJhbHdheXNcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zdWJtaXRGb3JtKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzdWJtaXRfZm9ybT09XCJuZXZlclwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuZm9ybVVwZGF0ZWRGZXRjaEFqYXgoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHN1Ym1pdF9mb3JtPT1cImF1dG9cIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgaWYodGhpcy5hdXRvX3VwZGF0ZT09dHJ1ZSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5mb3JtVXBkYXRlZEZldGNoQWpheCgpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmluaXQoKTtcclxuXHJcbiAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7fTtcclxuICAgICAgICBldmVudF9kYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgZXZlbnRfZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICBldmVudF9kYXRhLm9iamVjdCA9IHRoaXM7XHJcbiAgICAgICAgaWYob3B0cy5pc0luaXQpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmluaXRcIiwgZXZlbnRfZGF0YSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgIH0pO1xyXG59O1xyXG5cbn0pLmNhbGwodGhpcyx0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsIDogdHlwZW9mIHNlbGYgIT09IFwidW5kZWZpbmVkXCIgPyBzZWxmIDogdHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvdyA6IHt9KVxuLy8jIHNvdXJjZU1hcHBpbmdVUkw9ZGF0YTphcHBsaWNhdGlvbi9qc29uO2NoYXJzZXQ6dXRmLTg7YmFzZTY0LGV5SjJaWEp6YVc5dUlqb3pMQ0p6YjNWeVkyVnpJanBiSW5OeVl5OXdkV0pzYVdNdllYTnpaWFJ6TDJwekwybHVZMngxWkdWekwzQnNkV2RwYmk1cWN5SmRMQ0p1WVcxbGN5STZXMTBzSW0xaGNIQnBibWR6SWpvaU8wRkJRVUU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFaUxDSm1hV3hsSWpvaVoyVnVaWEpoZEdWa0xtcHpJaXdpYzI5MWNtTmxVbTl2ZENJNklpSXNJbk52ZFhKalpYTkRiMjUwWlc1MElqcGJJbHh5WEc1MllYSWdKQ0JjZEZ4MFhIUmNkRDBnS0hSNWNHVnZaaUIzYVc1a2IzY2dJVDA5SUZ3aWRXNWtaV1pwYm1Wa1hDSWdQeUIzYVc1a2IzZGJKMnBSZFdWeWVTZGRJRG9nZEhsd1pXOW1JR2RzYjJKaGJDQWhQVDBnWENKMWJtUmxabWx1WldSY0lpQS9JR2RzYjJKaGJGc25hbEYxWlhKNUoxMGdPaUJ1ZFd4c0tUdGNjbHh1ZG1GeUlITjBZWFJsSUZ4MFhIUmNkRDBnY21WeGRXbHlaU2duTGk5emRHRjBaU2NwTzF4eVhHNTJZWElnY0hKdlkyVnpjMTltYjNKdElGeDBQU0J5WlhGMWFYSmxLQ2N1TDNCeWIyTmxjM05mWm05eWJTY3BPMXh5WEc1MllYSWdibTlWYVZOc2FXUmxjbHgwWEhROUlISmxjWFZwY21Vb0oyNXZkV2x6Ykdsa1pYSW5LVHRjY2x4dUx5OTJZWElnWTI5dmEybGxjeUFnSUNBZ0lDQWdJRDBnY21WeGRXbHlaU2duYW5NdFkyOXZhMmxsSnlrN1hISmNiblpoY2lCMGFHbHlaRkJoY25SNUlDQWdJQ0FnUFNCeVpYRjFhWEpsS0NjdUwzUm9hWEprY0dGeWRIa25LVHRjY2x4dVhISmNibmRwYm1SdmR5NXpaV0Z5WTJoQmJtUkdhV3gwWlhJZ1BTQjdYSEpjYmlBZ0lDQmxlSFJsYm5OcGIyNXpPaUJiWFN4Y2NseHVJQ0FnSUhKbFoybHpkR1Z5UlhoMFpXNXphVzl1T2lCbWRXNWpkR2x2YmlnZ1pYaDBaVzV6YVc5dVRtRnRaU0FwSUh0Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1WNGRHVnVjMmx2Ym5NdWNIVnphQ2dnWlhoMFpXNXphVzl1VG1GdFpTQXBPMXh5WEc0Z0lDQWdmVnh5WEc1OU8xeHlYRzVjY2x4dWJXOWtkV3hsTG1WNGNHOXlkSE1nUFNCbWRXNWpkR2x2YmlodmNIUnBiMjV6S1Z4eVhHNTdYSEpjYmlBZ0lDQjJZWElnWkdWbVlYVnNkSE1nUFNCN1hISmNiaUFnSUNBZ0lDQWdjM1JoY25SUGNHVnVaV1E2SUdaaGJITmxMRnh5WEc0Z0lDQWdJQ0FnSUdselNXNXBkRG9nZEhKMVpTeGNjbHh1SUNBZ0lDQWdJQ0JoWTNScGIyNDZJRndpWENKY2NseHVJQ0FnSUgwN1hISmNibHh5WEc0Z0lDQWdkbUZ5SUc5d2RITWdQU0JxVVhWbGNua3VaWGgwWlc1a0tHUmxabUYxYkhSekxDQnZjSFJwYjI1ektUdGNjbHh1SUNBZ0lGeHlYRzRnSUNBZ2RHaHBjbVJRWVhKMGVTNXBibWwwS0NrN1hISmNiaUFnSUNCY2NseHVJQ0FnSUM4dmJHOXZjQ0IwYUhKdmRXZG9JR1ZoWTJnZ2FYUmxiU0J0WVhSamFHVmtYSEpjYmlBZ0lDQjBhR2x6TG1WaFkyZ29ablZ1WTNScGIyNG9LVnh5WEc0Z0lDQWdlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjJZWElnSkhSb2FYTWdQU0FrS0hSb2FYTXBPMXh5WEc0Z0lDQWdJQ0FnSUhaaGNpQnpaV3htSUQwZ2RHaHBjenRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbk5tYVdRZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMXpaaTFtYjNKdExXbGtYQ0lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0J6ZEdGMFpTNWhaR1JUWldGeVkyaEdiM0p0S0hSb2FYTXVjMlpwWkN3Z2RHaHBjeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdUpHWnBaV3hrY3lBOUlDUjBhR2x6TG1acGJtUW9YQ0krSUhWc0lENGdiR2xjSWlrN0lDOHZZU0J5WldabGNtVnVZMlVnZEc4Z1pXRmphQ0JtYVdWc1pITWdjR0Z5Wlc1MElFeEpYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11Wlc1aFlteGxYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVnpJRDBnSkhSb2FYTXVZWFIwY2lnblpHRjBZUzEwWVhodmJtOXRlUzFoY21Ob2FYWmxjeWNwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WTNWeWNtVnVkRjkwWVhodmJtOXRlVjloY21Ob2FYWmxJRDBnSkhSb2FYTXVZWFIwY2lnblpHRjBZUzFqZFhKeVpXNTBMWFJoZUc5dWIyMTVMV0Z5WTJocGRtVW5LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdVpXNWhZbXhsWDNSaGVHOXViMjE1WDJGeVkyaHBkbVZ6S1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVaVzVoWW14bFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1WeklEMGdYQ0l3WENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbU4xY25KbGJuUmZkR0Y0YjI1dmJYbGZZWEpqYUdsMlpTazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1OMWNuSmxiblJmZEdGNGIyNXZiWGxmWVhKamFHbDJaU0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0J3Y205alpYTnpYMlp2Y20wdWFXNXBkQ2h6Wld4bUxtVnVZV0pzWlY5MFlYaHZibTl0ZVY5aGNtTm9hWFpsY3l3Z2MyVnNaaTVqZFhKeVpXNTBYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVXBPMXh5WEc0Z0lDQWdJQ0FnSUM4dmNISnZZMlZ6YzE5bWIzSnRMbk5sZEZSaGVFRnlZMmhwZG1WU1pYTjFiSFJ6VlhKc0tITmxiR1lwTzF4eVhHNGdJQ0FnSUNBZ0lIQnliMk5sYzNOZlptOXliUzVsYm1GaWJHVkpibkIxZEhNb2MyVnNaaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxtVjRkSEpoWDNGMVpYSjVYM0JoY21GdGN5azlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1WNGRISmhYM0YxWlhKNVgzQmhjbUZ0Y3lBOUlIdGhiR3c2SUh0OUxDQnlaWE4xYkhSek9pQjdmU3dnWVdwaGVEb2dlMzE5TzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWRHVnRjR3hoZEdWZmFYTmZiRzloWkdWa0lEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRkR1Z0Y0d4aGRHVXRiRzloWkdWa1hDSXBPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVhWE5mWVdwaGVDQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV0ZxWVhoY0lpazdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NXBibk4wWVc1alpWOXVkVzFpWlhJZ1BTQWtkR2hwY3k1aGRIUnlLQ2RrWVhSaExXbHVjM1JoYm1ObExXTnZkVzUwSnlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k0a1lXcGhlRjl5WlhOMWJIUnpYMk52Ym5SaGFXNWxjaUE5SUdwUmRXVnllU2drZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzFoYW1GNExYUmhjbWRsZEZ3aUtTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WVdwaGVGOTFjR1JoZEdWZmMyVmpkR2x2Ym5NZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMWhhbUY0TFhWd1pHRjBaUzF6WldOMGFXOXVjMXdpS1NBL0lFcFRUMDR1Y0dGeWMyVW9JQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV0ZxWVhndGRYQmtZWFJsTFhObFkzUnBiMjV6WENJcElDa2dPaUJiWFR0Y2NseHVJQ0FnSUNBZ0lDQmNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuSmxjM1ZzZEhOZmRYSnNJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0Y21WemRXeDBjeTExY214Y0lpazdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWtaV0oxWjE5dGIyUmxJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0WkdWaWRXY3RiVzlrWlZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuVndaR0YwWlY5aGFtRjRYM1Z5YkNBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExYVndaR0YwWlMxaGFtRjRMWFZ5YkZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuQmhaMmx1WVhScGIyNWZkSGx3WlNBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExXRnFZWGd0Y0dGbmFXNWhkR2x2YmkxMGVYQmxYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WVhWMGIxOWpiM1Z1ZENBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExXRjFkRzh0WTI5MWJuUmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVoZFhSdlgyTnZkVzUwWDNKbFpuSmxjMmhmYlc5a1pTQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV0YxZEc4dFkyOTFiblF0Y21WbWNtVnphQzF0YjJSbFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXViMjVzZVY5eVpYTjFiSFJ6WDJGcVlYZ2dQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzF2Ym14NUxYSmxjM1ZzZEhNdFlXcGhlRndpS1RzZ0x5OXBaaUIzWlNCaGNtVWdibTkwSUc5dUlIUm9aU0J5WlhOMWJIUnpJSEJoWjJVc0lISmxaR2x5WldOMElISmhkR2hsY2lCMGFHRnVJSFJ5ZVNCMGJ5QnNiMkZrSUhacFlTQmhhbUY0WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTV6WTNKdmJHeGZkRzlmY0c5eklEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRjMk55YjJ4c0xYUnZMWEJ2YzF3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtTjFjM1J2YlY5elkzSnZiR3hmZEc4Z1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMWpkWE4wYjIwdGMyTnliMnhzTFhSdlhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVjMk55YjJ4c1gyOXVYMkZqZEdsdmJpQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMWE5qY205c2JDMXZiaTFoWTNScGIyNWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVzWVc1blgyTnZaR1VnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxc1lXNW5MV052WkdWY0lpazdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDNWeWJDQTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRZV3BoZUMxMWNtd25LVHRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZlptOXliVjkxY213Z1BTQWtkR2hwY3k1aGRIUnlLQ2RrWVhSaExXRnFZWGd0Wm05eWJTMTFjbXduS1R0Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1selgzSjBiQ0E5SUNSMGFHbHpMbUYwZEhJb0oyUmhkR0V0YVhNdGNuUnNKeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVpHbHpjR3hoZVY5eVpYTjFiSFJmYldWMGFHOWtJRDBnSkhSb2FYTXVZWFIwY2lnblpHRjBZUzFrYVhOd2JHRjVMWEpsYzNWc2RDMXRaWFJvYjJRbktUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtMWhhVzUwWVdsdVgzTjBZWFJsSUQwZ0pIUm9hWE11WVhSMGNpZ25aR0YwWVMxdFlXbHVkR0ZwYmkxemRHRjBaU2NwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WVdwaGVGOWhZM1JwYjI0Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YkdGemRGOXpkV0p0YVhSZmNYVmxjbmxmY0dGeVlXMXpJRDBnWENKY0lqdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVqZFhKeVpXNTBYM0JoWjJWa0lEMGdjR0Z5YzJWSmJuUW9KSFJvYVhNdVlYUjBjaWduWkdGMFlTMXBibWwwTFhCaFoyVmtKeWtwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YkdGemRGOXNiMkZrWDIxdmNtVmZhSFJ0YkNBOUlGd2lYQ0k3WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVzYjJGa1gyMXZjbVZmYUhSdGJDQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1aGFtRjRYMlJoZEdGZmRIbHdaU0E5SUNSMGFHbHpMbUYwZEhJb0oyUmhkR0V0WVdwaGVDMWtZWFJoTFhSNWNHVW5LVHRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZmRHRnlaMlYwWDJGMGRISWdQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzFoYW1GNExYUmhjbWRsZEZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuVnpaVjlvYVhOMGIzSjVYMkZ3YVNBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExYVnpaUzFvYVhOMGIzSjVMV0Z3YVZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtbHpYM04xWW0xcGRIUnBibWNnUFNCbVlXeHpaVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1c1lYTjBYMkZxWVhoZmNtVnhkV1Z6ZENBOUlHNTFiR3c3WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxuVnpaVjlvYVhOMGIzSjVYMkZ3YVNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMblZ6WlY5b2FYTjBiM0o1WDJGd2FTQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1d1lXZHBibUYwYVc5dVgzUjVjR1VwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NXdZV2RwYm1GMGFXOXVYM1I1Y0dVZ1BTQmNJbTV2Y20xaGJGd2lPMXh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1amRYSnlaVzUwWDNCaFoyVmtLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdVkzVnljbVZ1ZEY5d1lXZGxaQ0E5SURFN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1aGFtRjRYM1JoY21kbGRGOWhkSFJ5S1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVZV3BoZUY5MFlYSm5aWFJmWVhSMGNpQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1aGFtRjRYM1Z5YkNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZmRYSnNJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxtRnFZWGhmWm05eWJWOTFjbXdwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDJadmNtMWZkWEpzSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbkpsYzNWc2RITmZkWEpzS1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVjbVZ6ZFd4MGMxOTFjbXdnUFNCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hSb2FYTXVjMk55YjJ4c1gzUnZYM0J2Y3lrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbk5qY205c2JGOTBiMTl3YjNNZ1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11YzJOeWIyeHNYMjl1WDJGamRHbHZiaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxuTmpjbTlzYkY5dmJsOWhZM1JwYjI0Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvZEdocGN5NWpkWE4wYjIxZmMyTnliMnhzWDNSdktUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11WTNWemRHOXRYM05qY205c2JGOTBieUE5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11SkdOMWMzUnZiVjl6WTNKdmJHeGZkRzhnUFNCcVVYVmxjbmtvZEdocGN5NWpkWE4wYjIxZmMyTnliMnhzWDNSdktUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11ZFhCa1lYUmxYMkZxWVhoZmRYSnNLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWRYQmtZWFJsWDJGcVlYaGZkWEpzSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbVJsWW5WblgyMXZaR1VwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWtaV0oxWjE5dGIyUmxJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxtRnFZWGhmZEdGeVoyVjBYMjlpYW1WamRDazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1GcVlYaGZkR0Z5WjJWMFgyOWlhbVZqZENBOUlGd2lYQ0k3WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCcFppaDBlWEJsYjJZb2RHaHBjeTUwWlcxd2JHRjBaVjlwYzE5c2IyRmtaV1FwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NTBaVzF3YkdGMFpWOXBjMTlzYjJGa1pXUWdQU0JjSWpCY0lqdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsS1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVZWFYwYjE5amIzVnVkRjl5WldaeVpYTm9YMjF2WkdVZ1BTQmNJakJjSWp0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WVdwaGVGOXNhVzVyYzE5elpXeGxZM1J2Y2lBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExXRnFZWGd0YkdsdWEzTXRjMlZzWldOMGIzSmNJaWs3WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUYxZEc5ZmRYQmtZWFJsSUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdFlYVjBieTExY0dSaGRHVmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVwYm5CMWRGUnBiV1Z5SUQwZ01EdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTV6WlhSSmJtWnBibWwwWlZOamNtOXNiRU52Ym5SaGFXNWxjaUE5SUdaMWJtTjBhVzl1S0NsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxtbHpYMjFoZUY5d1lXZGxaQ0E5SUdaaGJITmxPeUF2TDJadmNpQnNiMkZrSUcxdmNtVWdiMjVzZVN3Z2IyNWpaU0IzWlNCa1pYUmxZM1FnZDJVbmNtVWdZWFFnZEdobElHVnVaQ0J6WlhRZ2RHaHBjeUIwYnlCMGNuVmxYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11ZFhObFgzTmpjbTlzYkY5c2IyRmtaWElnUFNBa2RHaHBjeTVoZEhSeUtDZGtZWFJoTFhOb2IzY3RjMk55YjJ4c0xXeHZZV1JsY2ljcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbWx1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSWdQU0FrZEdocGN5NWhkSFJ5S0Nka1lYUmhMV2x1Wm1sdWFYUmxMWE5qY205c2JDMWpiMjUwWVdsdVpYSW5LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1cGJtWnBibWwwWlY5elkzSnZiR3hmZEhKcFoyZGxjbDloYlc5MWJuUWdQU0FrZEdocGN5NWhkSFJ5S0Nka1lYUmhMV2x1Wm1sdWFYUmxMWE5qY205c2JDMTBjbWxuWjJWeUp5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11YVc1bWFXNXBkR1ZmYzJOeWIyeHNYM0psYzNWc2RGOWpiR0Z6Y3lBOUlDUjBhR2x6TG1GMGRISW9KMlJoZEdFdGFXNW1hVzVwZEdVdGMyTnliMnhzTFhKbGMzVnNkQzFqYkdGemN5Y3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TGlScGJtWnBibWwwWlY5elkzSnZiR3hmWTI5dWRHRnBibVZ5SUQwZ2RHaHBjeTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNqdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxtbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbWx1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSWdQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k0a2FXNW1hVzVwZEdWZmMyTnliMnhzWDJOdmJuUmhhVzVsY2lBOUlHcFJkV1Z5ZVNna2RHaHBjeTVoZEhSeUtDZGtZWFJoTFdsdVptbHVhWFJsTFhOamNtOXNiQzFqYjI1MFlXbHVaWEluS1NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG1sdVptbHVhWFJsWDNOamNtOXNiRjl5WlhOMWJIUmZZMnhoYzNNcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbWx1Wm1sdWFYUmxYM05qY205c2JGOXlaWE4xYkhSZlkyeGhjM01nUFNCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvZEdocGN5NTFjMlZmYzJOeWIyeHNYMnh2WVdSbGNpazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11ZFhObFgzTmpjbTlzYkY5c2IyRmtaWElnUFNBeE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1elpYUkpibVpwYm1sMFpWTmpjbTlzYkVOdmJuUmhhVzVsY2lncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBdktpQm1kVzVqZEdsdmJuTWdLaTljY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1eVpYTmxkQ0E5SUdaMWJtTjBhVzl1S0hOMVltMXBkRjltYjNKdEtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVjbVZ6WlhSR2IzSnRLSE4xWW0xcGRGOW1iM0p0S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVJSFJ5ZFdVN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1sdWNIVjBWWEJrWVhSbElEMGdablZ1WTNScGIyNG9aR1ZzWVhsRWRYSmhkR2x2YmlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaGtaV3hoZVVSMWNtRjBhVzl1S1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHUmxiR0Y1UkhWeVlYUnBiMjRnUFNBek1EQTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWNtVnpaWFJVYVcxbGNpaGtaV3hoZVVSMWNtRjBhVzl1S1R0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YzJOeWIyeHNWRzlRYjNNZ1BTQm1kVzVqZEdsdmJpZ3BJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUc5bVpuTmxkQ0E5SURBN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmpZVzVUWTNKdmJHd2dQU0IwY25WbE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNXBjMTloYW1GNFBUMHhLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1Mbk5qY205c2JGOTBiMTl3YjNNOVBWd2lkMmx1Wkc5M1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdiMlptYzJWMElEMGdNRHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElHbG1LSE5sYkdZdWMyTnliMnhzWDNSdlgzQnZjejA5WENKbWIzSnRYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYjJabWMyVjBJRDBnSkhSb2FYTXViMlptYzJWMEtDa3VkRzl3TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCcFppaHpaV3htTG5OamNtOXNiRjkwYjE5d2IzTTlQVndpY21WemRXeDBjMXdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1SkdGcVlYaGZjbVZ6ZFd4MGMxOWpiMjUwWVdsdVpYSXViR1Z1WjNSb1BqQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnZabVp6WlhRZ1BTQnpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbTltWm5ObGRDZ3BMblJ2Y0R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtITmxiR1l1YzJOeWIyeHNYM1J2WDNCdmN6MDlYQ0pqZFhOMGIyMWNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJOMWMzUnZiVjl6WTNKdmJHeGZkRzljY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxpUmpkWE4wYjIxZmMyTnliMnhzWDNSdkxteGxibWQwYUQ0d0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2IyWm1jMlYwSUQwZ2MyVnNaaTRrWTNWemRHOXRYM05qY205c2JGOTBieTV2Wm1aelpYUW9LUzUwYjNBN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdOaGJsTmpjbTlzYkNBOUlHWmhiSE5sTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtHTmhibE5qY205c2JDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtLRndpYUhSdGJDd2dZbTlrZVZ3aUtTNXpkRzl3S0NrdVlXNXBiV0YwWlNoN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmpjbTlzYkZSdmNEb2diMlptYzJWMFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlN3Z1hDSnViM0p0WVd4Y0lpd2dYQ0psWVhObFQzVjBVWFZoWkZ3aUlDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1aGRIUmhZMmhCWTNScGRtVkRiR0Z6Y3lBOUlHWjFibU4wYVc5dUtDbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJOb1pXTnJJSFJ2SUhObFpTQnBaaUIzWlNCaGNtVWdkWE5wYm1jZ1lXcGhlQ0FtSUdGMWRHOGdZMjkxYm5SY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5cFppQnViM1FzSUhSb1pTQnpaV0Z5WTJnZ1ptOXliU0JrYjJWeklHNXZkQ0JuWlhRZ2NtVnNiMkZrWldRc0lITnZJSGRsSUc1bFpXUWdkRzhnZFhCa1lYUmxJSFJvWlNCelppMXZjSFJwYjI0dFlXTjBhWFpsSUdOc1lYTnpJRzl1SUdGc2JDQm1hV1ZzWkhOY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG05dUtDZGphR0Z1WjJVbkxDQW5hVzV3ZFhSYmRIbHdaVDFjSW5KaFpHbHZYQ0pkTENCcGJuQjFkRnQwZVhCbFBWd2lZMmhsWTJ0aWIzaGNJbDBzSUhObGJHVmpkQ2NzSUdaMWJtTjBhVzl1S0dVcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrWTNSb2FYTWdQU0FrS0hSb2FYTXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmpkR2hwYzE5d1lYSmxiblFnUFNBa1kzUm9hWE11WTJ4dmMyVnpkQ2hjSW14cFcyUmhkR0V0YzJZdFptbGxiR1F0Ym1GdFpWMWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkR2hwYzE5MFlXY2dQU0FrWTNSb2FYTXVjSEp2Y0NoY0luUmhaMDVoYldWY0lpa3VkRzlNYjNkbGNrTmhjMlVvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJwYm5CMWRGOTBlWEJsSUQwZ0pHTjBhR2x6TG1GMGRISW9YQ0owZVhCbFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIQmhjbVZ1ZEY5MFlXY2dQU0FrWTNSb2FYTmZjR0Z5Wlc1MExuQnliM0FvWENKMFlXZE9ZVzFsWENJcExuUnZURzkzWlhKRFlYTmxLQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvS0hSb2FYTmZkR0ZuUFQxY0ltbHVjSFYwWENJcEppWW9LR2x1Y0hWMFgzUjVjR1U5UFZ3aWNtRmthVzljSWlsOGZDaHBibkIxZEY5MGVYQmxQVDFjSW1Ob1pXTnJZbTk0WENJcEtTQW1KaUFvY0dGeVpXNTBYM1JoWnowOVhDSnNhVndpS1NsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR0ZzYkY5dmNIUnBiMjV6SUQwZ0pHTjBhR2x6WDNCaGNtVnVkQzV3WVhKbGJuUW9LUzVtYVc1a0tDZHNhU2NwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1lXeHNYMjl3ZEdsdmJuTmZabWxsYkdSeklEMGdKR04wYUdselgzQmhjbVZ1ZEM1d1lYSmxiblFvS1M1bWFXNWtLQ2RwYm5CMWREcGphR1ZqYTJWa0p5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JoYkd4ZmIzQjBhVzl1Y3k1eVpXMXZkbVZEYkdGemN5aGNJbk5tTFc5d2RHbHZiaTFoWTNScGRtVmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR0ZzYkY5dmNIUnBiMjV6WDJacFpXeGtjeTVsWVdOb0tHWjFibU4wYVc5dUtDbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSEJoY21WdWRDQTlJQ1FvZEdocGN5a3VZMnh2YzJWemRDaGNJbXhwWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtjR0Z5Wlc1MExtRmtaRU5zWVhOektGd2ljMll0YjNCMGFXOXVMV0ZqZEdsMlpWd2lLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0JwWmloMGFHbHpYM1JoWnowOVhDSnpaV3hsWTNSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdGc2JGOXZjSFJwYjI1eklEMGdKR04wYUdsekxtTm9hV3hrY21WdUtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHRnNiRjl2Y0hScGIyNXpMbkpsYlc5MlpVTnNZWE56S0Z3aWMyWXRiM0IwYVc5dUxXRmpkR2wyWlZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkR2hwYzE5MllXd2dQU0FrWTNSb2FYTXVkbUZzS0NrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIwYUdselgyRnljbDkyWVd3Z1BTQW9kSGx3Wlc5bUlIUm9hWE5mZG1Gc0lEMDlJQ2R6ZEhKcGJtY25JSHg4SUhSb2FYTmZkbUZzSUdsdWMzUmhibU5sYjJZZ1UzUnlhVzVuS1NBL0lGdDBhR2x6WDNaaGJGMGdPaUIwYUdselgzWmhiRHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkNoMGFHbHpYMkZ5Y2w5MllXd3BMbVZoWTJnb1puVnVZM1JwYjI0b2FTd2dkbUZzZFdVcGUxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtZM1JvYVhNdVptbHVaQ2hjSW05d2RHbHZibHQyWVd4MVpUMG5YQ0lyZG1Gc2RXVXJYQ0luWFZ3aUtTNWhaR1JEYkdGemN5aGNJbk5tTFc5d2RHbHZiaTFoWTNScGRtVmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1cGJtbDBRWFYwYjFWd1pHRjBaVVYyWlc1MGN5QTlJR1oxYm1OMGFXOXVLQ2w3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdktpQmhkWFJ2SUhWd1pHRjBaU0FxTDF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlnb2MyVnNaaTVoZFhSdlgzVndaR0YwWlQwOU1TbDhmQ2h6Wld4bUxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsUFQweEtTbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdWIyNG9KMk5vWVc1blpTY3NJQ2RwYm5CMWRGdDBlWEJsUFZ3aWNtRmthVzljSWwwc0lHbHVjSFYwVzNSNWNHVTlYQ0pqYUdWamEySnZlRndpWFN3Z2MyVnNaV04wSnl3Z1puVnVZM1JwYjI0b1pTa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVc1d2RYUlZjR1JoZEdVb01qQXdLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbTl1S0NkcGJuQjFkQ2NzSUNkcGJuQjFkRnQwZVhCbFBWd2liblZ0WW1WeVhDSmRKeXdnWm5WdVkzUnBiMjRvWlNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhVzV3ZFhSVmNHUmhkR1VvT0RBd0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2RHVjRkRWx1Y0hWMElEMGdKSFJvYVhNdVptbHVaQ2duYVc1d2RYUmJkSGx3WlQxY0luUmxlSFJjSWwwNmJtOTBLQzV6Wmkxa1lYUmxjR2xqYTJWeUtTY3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHeGhjM1JXWVd4MVpTQTlJQ1IwWlhoMFNXNXdkWFF1ZG1Gc0tDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUm9hWE11YjI0b0oybHVjSFYwSnl3Z0oybHVjSFYwVzNSNWNHVTlYQ0owWlhoMFhDSmRPbTV2ZENndWMyWXRaR0YwWlhCcFkydGxjaWtuTENCbWRXNWpkR2x2YmlncFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9iR0Z6ZEZaaGJIVmxJVDBrZEdWNGRFbHVjSFYwTG5aaGJDZ3BLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGJuQjFkRlZ3WkdGMFpTZ3hNakF3S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUd4aGMzUldZV3gxWlNBOUlDUjBaWGgwU1c1d2RYUXVkbUZzS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTXViMjRvSjJ0bGVYQnlaWE56Snl3Z0oybHVjSFYwVzNSNWNHVTlYQ0owWlhoMFhDSmRPbTV2ZENndWMyWXRaR0YwWlhCcFkydGxjaWtuTENCbWRXNWpkR2x2YmlobEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2hsTG5kb2FXTm9JRDA5SURFektYdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdVdWNISmxkbVZ1ZEVSbFptRjFiSFFvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV6ZFdKdGFYUkdiM0p0S0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCbVlXeHpaVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OGtkR2hwY3k1dmJpZ25hVzV3ZFhRbkxDQW5hVzV3ZFhRdWMyWXRaR0YwWlhCcFkydGxjaWNzSUhObGJHWXVaR0YwWlVsdWNIVjBWSGx3WlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnTHk5MGFHbHpMbWx1YVhSQmRYUnZWWEJrWVhSbFJYWmxiblJ6S0NrN1hISmNibHh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1Oc1pXRnlWR2x0WlhJZ1BTQm1kVzVqZEdsdmJpZ3BYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JqYkdWaGNsUnBiV1Z2ZFhRb2MyVnNaaTVwYm5CMWRGUnBiV1Z5S1R0Y2NseHVJQ0FnSUNBZ0lDQjlPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVjbVZ6WlhSVWFXMWxjaUE5SUdaMWJtTjBhVzl1S0dSbGJHRjVSSFZ5WVhScGIyNHBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JqYkdWaGNsUnBiV1Z2ZFhRb2MyVnNaaTVwYm5CMWRGUnBiV1Z5S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBibkIxZEZScGJXVnlJRDBnYzJWMFZHbHRaVzkxZENoelpXeG1MbVp2Y20xVmNHUmhkR1ZrTENCa1pXeGhlVVIxY21GMGFXOXVLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1aFpHUkVZWFJsVUdsamEyVnljeUE5SUdaMWJtTjBhVzl1S0NsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrWkdGMFpWOXdhV05yWlhJZ1BTQWtkR2hwY3k1bWFXNWtLRndpTG5ObUxXUmhkR1Z3YVdOclpYSmNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppZ2taR0YwWlY5d2FXTnJaWEl1YkdWdVozUm9QakFwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSa1lYUmxYM0JwWTJ0bGNpNWxZV05vS0daMWJtTjBhVzl1S0NsN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrZEdocGN5QTlJQ1FvZEdocGN5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdWR2IzSnRZWFFnUFNCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrWVhSbFJISnZjR1J2ZDI1WlpXRnlJRDBnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdWRWNtOXdaRzkzYmsxdmJuUm9JRDBnWm1Gc2MyVTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1kyeHZjMlZ6ZEY5a1lYUmxYM2R5WVhBZ1BTQWtkR2hwY3k1amJHOXpaWE4wS0Z3aUxuTm1YMlJoZEdWZlptbGxiR1JjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0pHTnNiM05sYzNSZlpHRjBaVjkzY21Gd0xteGxibWQwYUQ0d0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBaVVp2Y20xaGRDQTlJQ1JqYkc5elpYTjBYMlJoZEdWZmQzSmhjQzVoZEhSeUtGd2laR0YwWVMxa1lYUmxMV1p2Y20xaGRGd2lLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1JqYkc5elpYTjBYMlJoZEdWZmQzSmhjQzVoZEhSeUtGd2laR0YwWVMxa1lYUmxMWFZ6WlMxNVpXRnlMV1J5YjNCa2IzZHVYQ0lwUFQweEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmxSSEp2Y0dSdmQyNVpaV0Z5SUQwZ2RISjFaVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tZMnh2YzJWemRGOWtZWFJsWDNkeVlYQXVZWFIwY2loY0ltUmhkR0V0WkdGMFpTMTFjMlV0Ylc5dWRHZ3RaSEp2Y0dSdmQyNWNJaWs5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHVkVjbTl3Wkc5M2JrMXZiblJvSUQwZ2RISjFaVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHUmhkR1ZRYVdOclpYSlBjSFJwYjI1eklEMGdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwYm14cGJtVTZJSFJ5ZFdVc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITm9iM2RQZEdobGNrMXZiblJvY3pvZ2RISjFaU3hjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYjI1VFpXeGxZM1E2SUdaMWJtTjBhVzl1S0dVc0lHWnliMjFmWm1sbGJHUXBleUJ6Wld4bUxtUmhkR1ZUWld4bFkzUW9aU3dnWm5KdmJWOW1hV1ZzWkN3Z0pDaDBhR2x6S1NrN0lIMHNYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdWR2IzSnRZWFE2SUdSaGRHVkdiM0p0WVhRc1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JqYUdGdVoyVk5iMjUwYURvZ1pHRjBaVVJ5YjNCa2IzZHVUVzl1ZEdnc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHTm9ZVzVuWlZsbFlYSTZJR1JoZEdWRWNtOXdaRzkzYmxsbFlYSmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxtbHpYM0owYkQwOU1TbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR1ZRYVdOclpYSlBjSFJwYjI1ekxtUnBjbVZqZEdsdmJpQTlJRndpY25Sc1hDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkR2hwY3k1a1lYUmxjR2xqYTJWeUtHUmhkR1ZRYVdOclpYSlBjSFJwYjI1ektUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNXNZVzVuWDJOdlpHVWhQVndpWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa0xtUmhkR1Z3YVdOclpYSXVjMlYwUkdWbVlYVnNkSE1vWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtMbVY0ZEdWdVpDaGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdKMlJoZEdWR2IzSnRZWFFuT21SaGRHVkdiM0p0WVhSOUxGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUXVaR0YwWlhCcFkydGxjaTV5WldkcGIyNWhiRnNnYzJWc1ppNXNZVzVuWDJOdlpHVmRYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrTG1SaGRHVndhV05yWlhJdWMyVjBSR1ZtWVhWc2RITW9YSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa0xtVjRkR1Z1WkNoY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN0oyUmhkR1ZHYjNKdFlYUW5PbVJoZEdWR2IzSnRZWFI5TEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRdVpHRjBaWEJwWTJ0bGNpNXlaV2RwYjI1aGJGdGNJbVZ1WENKZFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tLQ2N1Ykd3dGMydHBiaTF0Wld4dmJpY3BMbXhsYm1kMGFEMDlNQ2w3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSa1lYUmxYM0JwWTJ0bGNpNWtZWFJsY0dsamEyVnlLQ2QzYVdSblpYUW5LUzUzY21Gd0tDYzhaR2wySUdOc1lYTnpQVndpYkd3dGMydHBiaTF0Wld4dmJpQnpaV0Z5WTJoaGJtUm1hV3gwWlhJdFpHRjBaUzF3YVdOclpYSmNJaTgrSnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2ZUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVrWVhSbFUyVnNaV04wSUQwZ1puVnVZM1JwYjI0b1pTd2dabkp2YlY5bWFXVnNaQ3dnSkhSb2FYTXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHbHVjSFYwWDJacFpXeGtJRDBnSkNobWNtOXRYMlpwWld4a0xtbHVjSFYwTG1kbGRDZ3dLU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2RHaHBjeUE5SUNRb2RHaHBjeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR1JoZEdWZlptbGxiR1J6SUQwZ0pHbHVjSFYwWDJacFpXeGtMbU5zYjNObGMzUW9KMXRrWVhSaExYTm1MV1pwWld4a0xXbHVjSFYwTFhSNWNHVTlYQ0prWVhSbGNtRnVaMlZjSWwwc0lGdGtZWFJoTFhObUxXWnBaV3hrTFdsdWNIVjBMWFI1Y0dVOVhDSmtZWFJsWENKZEp5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDUmtZWFJsWDJacFpXeGtjeTVsWVdOb0tHWjFibU4wYVc5dUtHVXNJR2x1WkdWNEtYdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUjBabDlrWVhSbFgzQnBZMnRsY25NZ1BTQWtLSFJvYVhNcExtWnBibVFvWENJdWMyWXRaR0YwWlhCcFkydGxjbHdpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ1YjE5a1lYUmxYM0JwWTJ0bGNuTWdQU0FrZEdaZlpHRjBaVjl3YVdOclpYSnpMbXhsYm1kMGFEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2JtOWZaR0YwWlY5d2FXTnJaWEp6UGpFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OTBhR1Z1SUdsMElHbHpJR0VnWkdGMFpTQnlZVzVuWlN3Z2MyOGdiV0ZyWlNCemRYSmxJR0p2ZEdnZ1ptbGxiR1J6SUdGeVpTQm1hV3hzWldRZ1ltVm1iM0psSUhWd1pHRjBhVzVuWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSd1gyTnZkVzUwWlhJZ1BTQXdPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrY0Y5bGJYQjBlVjltYVdWc1pGOWpiM1Z1ZENBOUlEQTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUm1YMlJoZEdWZmNHbGphMlZ5Y3k1bFlXTm9LR1oxYm1OMGFXOXVLQ2w3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdrS0hSb2FYTXBMblpoYkNncFBUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrY0Y5bGJYQjBlVjltYVdWc1pGOWpiM1Z1ZENzck8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa2NGOWpiM1Z1ZEdWeUt5czdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dSd1gyVnRjSFI1WDJacFpXeGtYMk52ZFc1MFBUMHdLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGJuQjFkRlZ3WkdGMFpTZ3hLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGJITmxYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGJuQjFkRlZ3WkdGMFpTZ3hLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZV1JrVW1GdVoyVlRiR2xrWlhKeklEMGdablZ1WTNScGIyNG9LVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUnRaWFJoWDNKaGJtZGxJRDBnSkhSb2FYTXVabWx1WkNoY0lpNXpaaTF0WlhSaExYSmhibWRsTFhOc2FXUmxjbHdpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1J0WlhSaFgzSmhibWRsTG14bGJtZDBhRDR3S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2JXVjBZVjl5WVc1blpTNWxZV05vS0daMWJtTjBhVzl1S0NsN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrZEdocGN5QTlJQ1FvZEdocGN5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzFwYmlBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExXMXBibHdpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2JXRjRJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0YldGNFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6YldsdUlEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRjM1JoY25RdGJXbHVYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCemJXRjRJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0YzNSaGNuUXRiV0Y0WENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmthWE53YkdGNVgzWmhiSFZsWDJGeklEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRaR2x6Y0d4aGVTMTJZV3gxWlhNdFlYTmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOMFpYQWdQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzF6ZEdWd1hDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrYzNSaGNuUmZkbUZzSUQwZ0pIUm9hWE11Wm1sdVpDZ25Mbk5tTFhKaGJtZGxMVzFwYmljcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtaVzVrWDNaaGJDQTlJQ1IwYUdsekxtWnBibVFvSnk1elppMXlZVzVuWlMxdFlYZ25LVHRjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrWldOcGJXRnNYM0JzWVdObGN5QTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV1JsWTJsdFlXd3RjR3hoWTJWelhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIwYUc5MWMyRnVaRjl6WlhCbGNtRjBiM0lnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxMGFHOTFjMkZ1WkMxelpYQmxjbUYwYjNKY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JsWTJsdFlXeGZjMlZ3WlhKaGRHOXlJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0WkdWamFXMWhiQzF6WlhCbGNtRjBiM0pjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJtYVdWc1pGOW1iM0p0WVhRZ1BTQjNUblZ0WWloN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHMWhjbXM2SUdSbFkybHRZV3hmYzJWd1pYSmhkRzl5TEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1pXTnBiV0ZzY3pvZ2NHRnljMlZHYkc5aGRDaGtaV05wYldGc1gzQnNZV05sY3lrc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIUm9iM1Z6WVc1a09pQjBhRzkxYzJGdVpGOXpaWEJsY21GMGIzSmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYldsdVgzVnVabTl5YldGMGRHVmtJRDBnY0dGeWMyVkdiRzloZENoemJXbHVLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYldsdVgyWnZjbTFoZEhSbFpDQTlJR1pwWld4a1gyWnZjbTFoZEM1MGJ5aHdZWEp6WlVac2IyRjBLSE50YVc0cEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiV0Y0WDJadmNtMWhkSFJsWkNBOUlHWnBaV3hrWDJadmNtMWhkQzUwYnlod1lYSnpaVVpzYjJGMEtITnRZWGdwS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2JXRjRYM1Z1Wm05eWJXRjBkR1ZrSUQwZ2NHRnljMlZHYkc5aGRDaHpiV0Y0S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJGc1pYSjBLRzFwYmw5bWIzSnRZWFIwWldRcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dllXeGxjblFvYldGNFgyWnZjbTFoZEhSbFpDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OWhiR1Z5ZENoa2FYTndiR0Y1WDNaaGJIVmxYMkZ6S1R0Y2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dScGMzQnNZWGxmZG1Gc2RXVmZZWE05UFZ3aWRHVjRkR2x1Y0hWMFhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtjM1JoY25SZmRtRnNMblpoYkNodGFXNWZabTl5YldGMGRHVmtLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdWdVpGOTJZV3d1ZG1Gc0tHMWhlRjltYjNKdFlYUjBaV1FwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtHUnBjM0JzWVhsZmRtRnNkV1ZmWVhNOVBWd2lkR1Y0ZEZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pITjBZWEowWDNaaGJDNW9kRzFzS0cxcGJsOW1iM0p0WVhSMFpXUXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWlc1a1gzWmhiQzVvZEcxc0tHMWhlRjltYjNKdFlYUjBaV1FwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ1YjFWSlQzQjBhVzl1Y3lBOUlIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbUZ1WjJVNklIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNkdGFXNG5PaUJiSUhCaGNuTmxSbXh2WVhRb2JXbHVLU0JkTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKMjFoZUNjNklGc2djR0Z5YzJWR2JHOWhkQ2h0WVhncElGMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU3hjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzNSaGNuUTZJRnR0YVc1ZlptOXliV0YwZEdWa0xDQnRZWGhmWm05eWJXRjBkR1ZrWFN4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FHRnVaR3hsY3pvZ01peGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdZMjl1Ym1WamREb2dkSEoxWlN4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MzUmxjRG9nY0dGeWMyVkdiRzloZENoemRHVndLU3hjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHSmxhR0YyYVc5MWNqb2dKMlY0ZEdWdVpDMTBZWEFuTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbWIzSnRZWFE2SUdacFpXeGtYMlp2Y20xaGRGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwN1hISmNibHh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1cGMxOXlkR3c5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCdWIxVkpUM0IwYVc5dWN5NWthWEpsWTNScGIyNGdQU0JjSW5KMGJGd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOc2FXUmxjbDl2WW1wbFkzUWdQU0FrS0hSb2FYTXBMbVpwYm1Rb1hDSXViV1YwWVMxemJHbGtaWEpjSWlsYk1GMDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0NCY0luVnVaR1ZtYVc1bFpGd2lJQ0U5UFNCMGVYQmxiMllvSUhOc2FXUmxjbDl2WW1wbFkzUXVibTlWYVZOc2FXUmxjaUFwSUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMlJsYzNSeWIza2dhV1lnYVhRZ1pYaHBjM1J6TGk0Z2RHaHBjeUJ0WldGdWN5QnpiMjFsYUc5M0lHRnViM1JvWlhJZ2FXNXpkR0Z1WTJVZ2FHRmtJR2x1YVhScFlXeHBjMlZrSUdsMExpNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMnhwWkdWeVgyOWlhbVZqZEM1dWIxVnBVMnhwWkdWeUxtUmxjM1J5YjNrb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHNXZWV2xUYkdsa1pYSXVZM0psWVhSbEtITnNhV1JsY2w5dlltcGxZM1FzSUc1dlZVbFBjSFJwYjI1ektUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSE4wWVhKMFgzWmhiQzV2Wm1Zb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2MzUmhjblJmZG1Gc0xtOXVLQ2RqYUdGdVoyVW5MQ0JtZFc1amRHbHZiaWdwZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCemJHbGtaWEpmYjJKcVpXTjBMbTV2VldsVGJHbGtaWEl1YzJWMEtGc2tLSFJvYVhNcExuWmhiQ2dwTENCdWRXeHNYU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbGJtUmZkbUZzTG05bVppZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUmxibVJmZG1Gc0xtOXVLQ2RqYUdGdVoyVW5MQ0JtZFc1amRHbHZiaWdwZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCemJHbGtaWEpmYjJKcVpXTjBMbTV2VldsVGJHbGtaWEl1YzJWMEtGdHVkV3hzTENBa0tIUm9hWE1wTG5aaGJDZ3BYU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dkpITjBZWEowWDNaaGJDNW9kRzFzS0cxcGJsOW1iM0p0WVhSMFpXUXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZKR1Z1WkY5MllXd3VhSFJ0YkNodFlYaGZabTl5YldGMGRHVmtLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJ4cFpHVnlYMjlpYW1WamRDNXViMVZwVTJ4cFpHVnlMbTltWmlnbmRYQmtZWFJsSnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJ4cFpHVnlYMjlpYW1WamRDNXViMVZwVTJ4cFpHVnlMbTl1S0NkMWNHUmhkR1VuTENCbWRXNWpkR2x2YmlnZ2RtRnNkV1Z6TENCb1lXNWtiR1VnS1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MyeHBaR1Z5WDNOMFlYSjBYM1poYkNBZ1BTQnRhVzVmWm05eWJXRjBkR1ZrTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjMnhwWkdWeVgyVnVaRjkyWVd3Z0lEMGdiV0Y0WDJadmNtMWhkSFJsWkR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMllXeDFaU0E5SUhaaGJIVmxjMXRvWVc1a2JHVmRPMXh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNnZ2FHRnVaR3hsSUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYldGNFgyWnZjbTFoZEhSbFpDQTlJSFpoYkhWbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlJR1ZzYzJVZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYldsdVgyWnZjbTFoZEhSbFpDQTlJSFpoYkhWbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaGthWE53YkdGNVgzWmhiSFZsWDJGelBUMWNJblJsZUhScGJuQjFkRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrYzNSaGNuUmZkbUZzTG5aaGJDaHRhVzVmWm05eWJXRjBkR1ZrS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JsYm1SZmRtRnNMblpoYkNodFlYaGZabTl5YldGMGRHVmtLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJR2xtS0dScGMzQnNZWGxmZG1Gc2RXVmZZWE05UFZ3aWRHVjRkRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrYzNSaGNuUmZkbUZzTG1oMGJXd29iV2x1WDJadmNtMWhkSFJsWkNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWlc1a1gzWmhiQzVvZEcxc0tHMWhlRjltYjNKdFlYUjBaV1FwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXBJSFJvYVc1cklIUm9aU0JtZFc1amRHbHZiaUIwYUdGMElHSjFhV3hrY3lCMGFHVWdWVkpNSUc1bFpXUnpJSFJ2SUdSbFkyOWtaU0IwYUdVZ1ptOXliV0YwZEdWa0lITjBjbWx1WnlCaVpXWnZjbVVnWVdSa2FXNW5JSFJ2SUhSb1pTQjFjbXhjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tITmxiR1l1WVhWMGIxOTFjR1JoZEdVOVBURXBmSHdvYzJWc1ppNWhkWFJ2WDJOdmRXNTBYM0psWm5KbGMyaGZiVzlrWlQwOU1Ta3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZiMjVzZVNCMGNua2dkRzhnZFhCa1lYUmxJR2xtSUhSb1pTQjJZV3gxWlhNZ2FHRjJaU0JoWTNSMVlXeHNlU0JqYUdGdVoyVmtYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ29jMnhwWkdWeVgzTjBZWEowWDNaaGJDRTliV2x1WDJadmNtMWhkSFJsWkNsOGZDaHpiR2xrWlhKZlpXNWtYM1poYkNFOWJXRjRYMlp2Y20xaGRIUmxaQ2twSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGJuQjFkRlZ3WkdGMFpTZzRNREFwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWpiR1ZoY2xScGJXVnlLQ2s3SUM4dmFXZHViM0psSUdGdWVTQmphR0Z1WjJWeklISmxZMlZ1ZEd4NUlHMWhaR1VnWW5rZ2RHaGxJSE5zYVdSbGNpQW9kR2hwY3lCM1lYTWdhblZ6ZENCcGJtbDBJSE5vYjNWc1pHNG5kQ0JqYjNWdWRDQmhjeUJoYmlCMWNHUmhkR1VnWlhabGJuUXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtbHVhWFFnUFNCbWRXNWpkR2x2YmloclpXVndYM0JoWjJsdVlYUnBiMjRwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaDBlWEJsYjJZb2EyVmxjRjl3WVdkcGJtRjBhVzl1S1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHdGxaWEJmY0dGbmFXNWhkR2x2YmlBOUlHWmhiSE5sTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbWx1YVhSQmRYUnZWWEJrWVhSbFJYWmxiblJ6S0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVZWFIwWVdOb1FXTjBhWFpsUTJ4aGMzTW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVZV1JrUkdGMFpWQnBZMnRsY25Nb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVoWkdSU1lXNW5aVk5zYVdSbGNuTW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmFXNXBkQ0JqYjIxaWJ5QmliM2hsYzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHTnZiV0p2WW05NElEMGdKSFJvYVhNdVptbHVaQ2hjSW5ObGJHVmpkRnRrWVhSaExXTnZiV0p2WW05NFBTY3hKMTFjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWdrWTI5dFltOWliM2d1YkdWdVozUm9QakFwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSamIyMWliMkp2ZUM1bFlXTm9LR1oxYm1OMGFXOXVLR2x1WkdWNElDbDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwYUdselkySWdQU0FrS0NCMGFHbHpJQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUc1eWJTQTlJQ1IwYUdselkySXVZWFIwY2loY0ltUmhkR0V0WTI5dFltOWliM2d0Ym5KdFhDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2RIbHdaVzltSUNSMGFHbHpZMkl1WTJodmMyVnVJQ0U5SUZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWTJodmMyVnViM0IwYVc5dWN5QTlJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxZWEpqYUY5amIyNTBZV2x1Y3pvZ2RISjFaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvS0hSNWNHVnZaaWh1Y20wcElUMDlYQ0oxYm1SbFptbHVaV1JjSWlrbUppaHVjbTBwS1h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR05vYjNObGJtOXdkR2x2Ym5NdWJtOWZjbVZ6ZFd4MGMxOTBaWGgwSUQwZ2JuSnRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dklITmhabVVnZEc4Z2RYTmxJSFJvWlNCbWRXNWpkR2x2Ymx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzTmxZWEpqYUY5amIyNTBZV2x1YzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgzSjBiRDA5TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTmpZaTVoWkdSRGJHRnpjeWhjSW1Ob2IzTmxiaTF5ZEd4Y0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6WTJJdVkyaHZjMlZ1S0dOb2IzTmxibTl3ZEdsdmJuTXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGJITmxYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITmxiR1ZqZERKdmNIUnBiMjV6SUQwZ2UzMDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgzSjBiRDA5TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1pXTjBNbTl3ZEdsdmJuTXVaR2x5SUQwZ1hDSnlkR3hjSWp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdvZEhsd1pXOW1LRzV5YlNraFBUMWNJblZ1WkdWbWFXNWxaRndpS1NZbUtHNXliU2twZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWldOME1tOXdkR2x2Ym5NdWJHRnVaM1ZoWjJVOUlIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmNJbTV2VW1WemRXeDBjMXdpT2lCbWRXNWpkR2x2YmlncGUxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdibkp0TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdselkySXVjMlZzWldOME1paHpaV3hsWTNReWIzQjBhVzl1Y3lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4eVhHNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhWE5UZFdKdGFYUjBhVzVuSUQwZ1ptRnNjMlU3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwybG1JR0ZxWVhnZ2FYTWdaVzVoWW14bFpDQnBibWwwSUhSb1pTQndZV2RwYm1GMGFXOXVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWFYTmZZV3BoZUQwOU1TbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1elpYUjFjRUZxWVhoUVlXZHBibUYwYVc5dUtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdsekxtOXVLRndpYzNWaWJXbDBYQ0lzSUhSb2FYTXVjM1ZpYldsMFJtOXliU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx1YVhSWGIyOURiMjF0WlhKalpVTnZiblJ5YjJ4ektDazdJQzh2ZDI5dlkyOXRiV1Z5WTJVZ2IzSmtaWEppZVZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9hMlZsY0Y5d1lXZHBibUYwYVc5dVBUMW1ZV3h6WlNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzWVhOMFgzTjFZbTFwZEY5eGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxtZGxkRlZ5YkZCaGNtRnRjeWhtWVd4elpTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWIyNVhhVzVrYjNkVFkzSnZiR3dnUFNCbWRXNWpkR2x2YmlobGRtVnVkQ2xjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtDZ2hjMlZzWmk1cGMxOXNiMkZrYVc1blgyMXZjbVVwSUNZbUlDZ2hjMlZzWmk1cGMxOXRZWGhmY0dGblpXUXBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2QybHVaRzkzWDNOamNtOXNiQ0E5SUNRb2QybHVaRzkzS1M1elkzSnZiR3hVYjNBb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCM2FXNWtiM2RmYzJOeWIyeHNYMkp2ZEhSdmJTQTlJQ1FvZDJsdVpHOTNLUzV6WTNKdmJHeFViM0FvS1NBcklDUW9kMmx1Wkc5M0tTNW9aV2xuYUhRb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCelkzSnZiR3hmYjJabWMyVjBJRDBnY0dGeWMyVkpiblFvYzJWc1ppNXBibVpwYm1sMFpWOXpZM0p2Ykd4ZmRISnBaMmRsY2w5aGJXOTFiblFwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVKR2x1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSXViR1Z1WjNSb1BUMHhLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeVpYTjFiSFJ6WDNOamNtOXNiRjlpYjNSMGIyMGdQU0J6Wld4bUxpUnBibVpwYm1sMFpWOXpZM0p2Ykd4ZlkyOXVkR0ZwYm1WeUxtOW1abk5sZENncExuUnZjQ0FySUhObGJHWXVKR2x1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSXVhR1ZwWjJoMEtDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdlptWnpaWFFnUFNBb2MyVnNaaTRrYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjaTV2Wm1aelpYUW9LUzUwYjNBZ0t5QnpaV3htTGlScGJtWnBibWwwWlY5elkzSnZiR3hmWTI5dWRHRnBibVZ5TG1obGFXZG9kQ2dwS1NBdElIZHBibVJ2ZDE5elkzSnZiR3c3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIZHBibVJ2ZDE5elkzSnZiR3hmWW05MGRHOXRJRDRnY21WemRXeDBjMTl6WTNKdmJHeGZZbTkwZEc5dElDc2djMk55YjJ4c1gyOW1abk5sZENsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXViRzloWkUxdmNtVlNaWE4xYkhSektDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN0x5OWtiMjUwSUd4dllXUWdiVzl5WlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWMzUnlhWEJSZFdWeWVWTjBjbWx1WjBGdVpFaGhjMmhHY205dFVHRjBhQ0E5SUdaMWJtTjBhVzl1S0hWeWJDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z2RYSnNMbk53YkdsMEtGd2lQMXdpS1Zzd1hTNXpjR3hwZENoY0lpTmNJaWxiTUYwN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1kMWNDQTlJR1oxYm1OMGFXOXVLQ0J1WVcxbExDQjFjbXdnS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUlDZ2hkWEpzS1NCMWNtd2dQU0JzYjJOaGRHbHZiaTVvY21WbVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUc1aGJXVWdQU0J1WVcxbExuSmxjR3hoWTJVb0wxdGNYRnRkTHl4Y0lseGNYRnhjWEZ0Y0lpa3VjbVZ3YkdGalpTZ3ZXMXhjWFYwdkxGd2lYRnhjWEZ4Y1hWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbFoyVjRVeUE5SUZ3aVcxeGNYRncvSmwxY0lpdHVZVzFsSzF3aVBTaGJYaVlqWFNvcFhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ5WldkbGVDQTlJRzVsZHlCU1pXZEZlSEFvSUhKbFoyVjRVeUFwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NtVnpkV3gwY3lBOUlISmxaMlY0TG1WNFpXTW9JSFZ5YkNBcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnY21WemRXeDBjeUE5UFNCdWRXeHNJRDhnYm5Wc2JDQTZJSEpsYzNWc2RITmJNVjA3WEhKY2JpQWdJQ0FnSUNBZ2ZUdGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVoyVjBWWEpzVUdGeVlXMXpJRDBnWm5WdVkzUnBiMjRvYTJWbGNGOXdZV2RwYm1GMGFXOXVMQ0IwZVhCbExDQmxlR05zZFdSbEtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LR3RsWlhCZmNHRm5hVzVoZEdsdmJpazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJyWldWd1gzQmhaMmx1WVhScGIyNGdQU0IwY25WbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kSGx3WlNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQjBlWEJsSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliRjl3WVhKaGJYTmZjM1J5SUQwZ1hDSmNJanRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dklHZGxkQ0JoYkd3Z2NHRnlZVzF6SUdaeWIyMGdabWxsYkdSelhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQjFjbXhmY0dGeVlXMXpYMkZ5Y21GNUlEMGdjSEp2WTJWemMxOW1iM0p0TG1kbGRGVnliRkJoY21GdGN5aHpaV3htS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJzWlc1bmRHZ2dQU0JQWW1wbFkzUXVhMlY1Y3loMWNteGZjR0Z5WVcxelgyRnljbUY1S1M1c1pXNW5kR2c3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCamIzVnVkQ0E5SURBN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9aWGhqYkhWa1pTa2hQVndpZFc1a1pXWnBibVZrWENJcElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNoMWNteGZjR0Z5WVcxelgyRnljbUY1TG1oaGMwOTNibEJ5YjNCbGNuUjVLR1Y0WTJ4MVpHVXBLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdiR1Z1WjNSb0xTMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtHeGxibWQwYUQ0d0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1iM0lnS0haaGNpQnJJR2x1SUhWeWJGOXdZWEpoYlhOZllYSnlZWGtwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2RYSnNYM0JoY21GdGMxOWhjbkpoZVM1b1lYTlBkMjVRY205d1pYSjBlU2hyS1NrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHTmhibDloWkdRZ1BTQjBjblZsTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaDBlWEJsYjJZb1pYaGpiSFZrWlNraFBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dzOVBXVjRZMngxWkdVcElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmpZVzVmWVdSa0lEMGdabUZzYzJVN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dOaGJsOWhaR1FwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFZ5YkY5d1lYSmhiWE5mYzNSeUlDczlJR3NnS3lCY0lqMWNJaUFySUhWeWJGOXdZWEpoYlhOZllYSnlZWGxiYTEwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLR052ZFc1MElEd2diR1Z1WjNSb0lDMGdNU2tnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhWeWJGOXdZWEpoYlhOZmMzUnlJQ3M5SUZ3aUpsd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHTnZkVzUwS3lzN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeGRXVnllVjl3WVhKaGJYTWdQU0JjSWx3aU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTltYjNKdElIQmhjbUZ0Y3lCaGN5QjFjbXdnY1hWbGNua2djM1J5YVc1blhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1iM0p0WDNCaGNtRnRjeUE5SUhWeWJGOXdZWEpoYlhOZmMzUnlPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5blpYUWdkWEpzSUhCaGNtRnRjeUJtY205dElIUm9aU0JtYjNKdElHbDBjMlZzWmlBb2QyaGhkQ0IwYUdVZ2RYTmxjaUJvWVhNZ2MyVnNaV04wWldRcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdWFtOXBibFZ5YkZCaGNtRnRLSEYxWlhKNVgzQmhjbUZ0Y3l3Z1ptOXliVjl3WVhKaGJYTXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5aFpHUWdjR0ZuYVc1aGRHbHZibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhyWldWd1gzQmhaMmx1WVhScGIyNDlQWFJ5ZFdVcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ3WVdkbFRuVnRZbVZ5SUQwZ2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF3WVdkbFpGd2lLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9jR0ZuWlU1MWJXSmxjaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjR0ZuWlU1MWJXSmxjaUE5SURFN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jR0ZuWlU1MWJXSmxjajR4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdWFtOXBibFZ5YkZCaGNtRnRLSEYxWlhKNVgzQmhjbUZ0Y3l3Z1hDSnpabDl3WVdkbFpEMWNJaXR3WVdkbFRuVnRZbVZ5S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTloWkdRZ2MyWnBaRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMM0YxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1YW05cGJsVnliRkJoY21GdEtIRjFaWEo1WDNCaGNtRnRjeXdnWENKelptbGtQVndpSzNObGJHWXVjMlpwWkNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMeUJzYjI5d0lIUm9jbTkxWjJnZ1lXNTVJR1Y0ZEhKaElIQmhjbUZ0Y3lBb1puSnZiU0JsZUhRZ2NHeDFaMmx1Y3lrZ1lXNWtJR0ZrWkNCMGJ5QjBhR1VnZFhKc0lDaHBaU0IzYjI5amIyMXRaWEpqWlNCZ2IzSmtaWEppZVdBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4cWRtRnlJR1Y0ZEhKaFgzRjFaWEo1WDNCaGNtRnRJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJzWlc1bmRHZ2dQU0JQWW1wbFkzUXVhMlY1Y3loelpXeG1MbVY0ZEhKaFgzRjFaWEo1WDNCaGNtRnRjeWt1YkdWdVozUm9PMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdOdmRXNTBJRDBnTUR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWhzWlc1bmRHZytNQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNCbWIzSWdLSFpoY2lCcklHbHVJSE5sYkdZdVpYaDBjbUZmY1hWbGNubGZjR0Z5WVcxektTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvYzJWc1ppNWxlSFJ5WVY5eGRXVnllVjl3WVhKaGJYTXVhR0Z6VDNkdVVISnZjR1Z5ZEhrb2F5a3BJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1WNGRISmhYM0YxWlhKNVgzQmhjbUZ0YzF0clhTRTlYQ0pjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUdWNGRISmhYM0YxWlhKNVgzQmhjbUZ0SUQwZ2F5dGNJajFjSWl0elpXeG1MbVY0ZEhKaFgzRjFaWEo1WDNCaGNtRnRjMXRyWFR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdWFtOXBibFZ5YkZCaGNtRnRLSEYxWlhKNVgzQmhjbUZ0Y3l3Z1pYaDBjbUZmY1hWbGNubGZjR0Z5WVcwcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0tpOWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NYVmxjbmxmY0dGeVlXMXpJRDBnYzJWc1ppNWhaR1JSZFdWeWVWQmhjbUZ0Y3loeGRXVnllVjl3WVhKaGJYTXNJSE5sYkdZdVpYaDBjbUZmY1hWbGNubGZjR0Z5WVcxekxtRnNiQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaDBlWEJsSVQxY0lsd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdVlXUmtVWFZsY25sUVlYSmhiWE1vY1hWbGNubGZjR0Z5WVcxekxDQnpaV3htTG1WNGRISmhYM0YxWlhKNVgzQmhjbUZ0YzF0MGVYQmxYU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhKbGRIVnliaUJ4ZFdWeWVWOXdZWEpoYlhNN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZV1JrVVhWbGNubFFZWEpoYlhNZ1BTQm1kVzVqZEdsdmJpaHhkV1Z5ZVY5d1lYSmhiWE1zSUc1bGQxOXdZWEpoYlhNcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWlhoMGNtRmZjWFZsY25sZmNHRnlZVzBnUFNCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYkdWdVozUm9JRDBnVDJKcVpXTjBMbXRsZVhNb2JtVjNYM0JoY21GdGN5a3ViR1Z1WjNSb08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdZMjkxYm5RZ1BTQXdPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2JHVnVaM1JvUGpBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JtYjNJZ0tIWmhjaUJySUdsdUlHNWxkMTl3WVhKaGJYTXBJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvYm1WM1gzQmhjbUZ0Y3k1b1lYTlBkMjVRY205d1pYSjBlU2hyS1NrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2JtVjNYM0JoY21GdGMxdHJYU0U5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pYaDBjbUZmY1hWbGNubGZjR0Z5WVcwZ1BTQnJLMXdpUFZ3aUsyNWxkMTl3WVhKaGJYTmJhMTA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnhkV1Z5ZVY5d1lYSmhiWE1nUFNCelpXeG1MbXB2YVc1VmNteFFZWEpoYlNoeGRXVnllVjl3WVhKaGJYTXNJR1Y0ZEhKaFgzRjFaWEo1WDNCaGNtRnRLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUhGMVpYSjVYM0JoY21GdGN6dGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVoWkdSVmNteFFZWEpoYlNBOUlHWjFibU4wYVc5dUtIVnliQ3dnYzNSeWFXNW5LVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHRmtaRjl3WVhKaGJYTWdQU0JjSWx3aU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZFhKc0lUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaDFjbXd1YVc1a1pYaFBaaWhjSWo5Y0lpa2dJVDBnTFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1lXUmtYM0JoY21GdGN5QXJQU0JjSWlaY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1Z5YkNBOUlIUm9hWE11ZEhKaGFXeHBibWRUYkdGemFFbDBLSFZ5YkNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWVdSa1gzQmhjbUZ0Y3lBclBTQmNJajljSWp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvYzNSeWFXNW5JVDFjSWx3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVJSFZ5YkNBcklHRmtaRjl3WVhKaGJYTWdLeUJ6ZEhKcGJtYzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdkWEpzTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2ZUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVxYjJsdVZYSnNVR0Z5WVcwZ1BTQm1kVzVqZEdsdmJpaHdZWEpoYlhNc0lITjBjbWx1WnlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJoWkdSZmNHRnlZVzF6SUQwZ1hDSmNJanRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtIQmhjbUZ0Y3lFOVhDSmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWVdSa1gzQmhjbUZ0Y3lBclBTQmNJaVpjSWp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jM1J5YVc1bklUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlIQmhjbUZ0Y3lBcklHRmtaRjl3WVhKaGJYTWdLeUJ6ZEhKcGJtYzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdjR0Z5WVcxek8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1elpYUkJhbUY0VW1WemRXeDBjMVZTVEhNZ1BTQm1kVzVqZEdsdmJpaHhkV1Z5ZVY5d1lYSmhiWE1wWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaDBlWEJsYjJZb2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVaaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1ZZ1BTQnVaWGNnUVhKeVlYa29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jSEp2WTJWemMybHVaMTkxY213blhTQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKM0psYzNWc2RITmZkWEpzSjEwZ1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZGtZWFJoWDNSNWNHVW5YU0E5SUZ3aVhDSTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUtITmxiR1l1WVdwaGVGOTFjbXdoUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdVpHbHpjR3hoZVY5eVpYTjFiSFJmYldWMGFHOWtQVDFjSW5Ob2IzSjBZMjlrWlZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN0x5OTBhR1Z1SUhkbElIZGhiblFnZEc4Z1pHOGdZU0J5WlhGMVpYTjBJSFJ2SUhSb1pTQmhhbUY0SUdWdVpIQnZhVzUwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR5WlhOMWJIUnpYM1Z5YkNkZElEMGdjMlZzWmk1aFpHUlZjbXhRWVhKaGJTaHpaV3htTG5KbGMzVnNkSE5mZFhKc0xDQnhkV1Z5ZVY5d1lYSmhiWE1wTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2WVdSa0lHeGhibWNnWTI5a1pTQjBieUJoYW1GNElHRndhU0J5WlhGMVpYTjBMQ0JzWVc1bklHTnZaR1VnYzJodmRXeGtJR0ZzY21WaFpIa2dZbVVnYVc0Z2RHaGxjbVVnWm05eUlHOTBhR1Z5SUhKbGNYVmxjM1J6SUNocFpTd2djM1Z3Y0d4cFpXUWdhVzRnZEdobElGSmxjM1ZzZEhNZ1ZWSk1LVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWJHRnVaMTlqYjJSbElUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyOGdZV1JrSUdsMFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY1hWbGNubGZjR0Z5WVcxeklEMGdjMlZzWmk1cWIybHVWWEpzVUdGeVlXMG9jWFZsY25sZmNHRnlZVzF6TENCY0lteGhibWM5WENJcmMyVnNaaTVzWVc1blgyTnZaR1VwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKM0J5YjJObGMzTnBibWRmZFhKc0oxMGdQU0J6Wld4bUxtRmtaRlZ5YkZCaGNtRnRLSE5sYkdZdVlXcGhlRjkxY213c0lIRjFaWEo1WDNCaGNtRnRjeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzTmxiR1l1WVdwaGVGOXlaWE4xYkhSelgyTnZibVpiSjJSaGRHRmZkSGx3WlNkZElEMGdKMnB6YjI0bk8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtITmxiR1l1WkdsemNHeGhlVjl5WlhOMWJIUmZiV1YwYUc5a1BUMWNJbkJ2YzNSZmRIbHdaVjloY21Ob2FYWmxYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhCeWIyTmxjM05mWm05eWJTNXpaWFJVWVhoQmNtTm9hWFpsVW1WemRXeDBjMVZ5YkNoelpXeG1MQ0J6Wld4bUxuSmxjM1ZzZEhOZmRYSnNLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnlaWE4xYkhSelgzVnliQ0E5SUhCeWIyTmxjM05mWm05eWJTNW5aWFJTWlhOMWJIUnpWWEpzS0hObGJHWXNJSE5sYkdZdWNtVnpkV3gwYzE5MWNtd3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WVdwaGVGOXlaWE4xYkhSelgyTnZibVpiSjNKbGMzVnNkSE5mZFhKc0oxMGdQU0J6Wld4bUxtRmtaRlZ5YkZCaGNtRnRLSEpsYzNWc2RITmZkWEpzTENCeGRXVnllVjl3WVhKaGJYTXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jSEp2WTJWemMybHVaMTkxY213blhTQTlJSE5sYkdZdVlXUmtWWEpzVUdGeVlXMG9jbVZ6ZFd4MGMxOTFjbXdzSUhGMVpYSjVYM0JoY21GdGN5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9jMlZzWmk1a2FYTndiR0Y1WDNKbGMzVnNkRjl0WlhSb2IyUTlQVndpWTNWemRHOXRYM2R2YjJOdmJXMWxjbU5sWDNOMGIzSmxYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhCeWIyTmxjM05mWm05eWJTNXpaWFJVWVhoQmNtTm9hWFpsVW1WemRXeDBjMVZ5YkNoelpXeG1MQ0J6Wld4bUxuSmxjM1ZzZEhOZmRYSnNLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnlaWE4xYkhSelgzVnliQ0E5SUhCeWIyTmxjM05mWm05eWJTNW5aWFJTWlhOMWJIUnpWWEpzS0hObGJHWXNJSE5sYkdZdWNtVnpkV3gwYzE5MWNtd3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WVdwaGVGOXlaWE4xYkhSelgyTnZibVpiSjNKbGMzVnNkSE5mZFhKc0oxMGdQU0J6Wld4bUxtRmtaRlZ5YkZCaGNtRnRLSEpsYzNWc2RITmZkWEpzTENCeGRXVnllVjl3WVhKaGJYTXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jSEp2WTJWemMybHVaMTkxY213blhTQTlJSE5sYkdZdVlXUmtWWEpzVUdGeVlXMG9jbVZ6ZFd4MGMxOTFjbXdzSUhGMVpYSjVYM0JoY21GdGN5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJWY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZXk4dmIzUm9aWEozYVhObElIZGxJSGRoYm5RZ2RHOGdjSFZzYkNCMGFHVWdjbVZ6ZFd4MGN5QmthWEpsWTNSc2VTQm1jbTl0SUhSb1pTQnlaWE4xYkhSeklIQmhaMlZjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKM0psYzNWc2RITmZkWEpzSjEwZ1BTQnpaV3htTG1Ga1pGVnliRkJoY21GdEtITmxiR1l1Y21WemRXeDBjMTkxY213c0lIRjFaWEo1WDNCaGNtRnRjeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR3Y205alpYTnphVzVuWDNWeWJDZGRJRDBnYzJWc1ppNWhaR1JWY214UVlYSmhiU2h6Wld4bUxtRnFZWGhmZFhKc0xDQnhkV1Z5ZVY5d1lYSmhiWE1wTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lka1lYUmhYM1I1Y0dVblhTQTlJQ2RvZEcxc0p6dGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aGFtRjRYM0psYzNWc2RITmZZMjl1WmxzbmNISnZZMlZ6YzJsdVoxOTFjbXduWFNBOUlITmxiR1l1WVdSa1VYVmxjbmxRWVhKaGJYTW9jMlZzWmk1aGFtRjRYM0psYzNWc2RITmZZMjl1WmxzbmNISnZZMlZ6YzJsdVoxOTFjbXduWFN3Z2MyVnNaaTVsZUhSeVlWOXhkV1Z5ZVY5d1lYSmhiWE5iSjJGcVlYZ25YU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWRrWVhSaFgzUjVjR1VuWFNBOUlITmxiR1l1WVdwaGVGOWtZWFJoWDNSNWNHVTdYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuVndaR0YwWlV4dllXUmxjbFJoWnlBOUlHWjFibU4wYVc5dUtDUnZZbXBsWTNRc0lIUmhaMDVoYldVcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2NHRnlaVzUwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1cGJtWnBibWwwWlY5elkzSnZiR3hmY21WemRXeDBYMk5zWVhOeklUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2NHRnlaVzUwSUQwZ2MyVnNaaTRrYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjaTVtYVc1a0tITmxiR1l1YVc1bWFXNXBkR1ZmYzJOeWIyeHNYM0psYzNWc2RGOWpiR0Z6Y3lrdWJHRnpkQ2dwTG5CaGNtVnVkQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJWY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIQmhjbVZ1ZENBOUlITmxiR1l1SkdsdVptbHVhWFJsWDNOamNtOXNiRjlqYjI1MFlXbHVaWEk3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQjBZV2RPWVcxbElEMGdKSEJoY21WdWRDNXdjbTl3S0Z3aWRHRm5UbUZ0WlZ3aUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMFlXZFVlWEJsSUQwZ0oyUnBkaWM3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0NBb0lIUmhaMDVoYldVdWRHOU1iM2RsY2tOaGMyVW9LU0E5UFNBbmIyd25JQ2tnZkh3Z0tDQjBZV2RPWVcxbExuUnZURzkzWlhKRFlYTmxLQ2tnUFQwZ0ozVnNKeUFwSUNsN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjBZV2RVZVhCbElEMGdKMnhwSnp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1J1WlhjZ1BTQWtLQ2M4Snl0MFlXZFVlWEJsS3ljZ0x6NG5LUzVvZEcxc0tDUnZZbXBsWTNRdWFIUnRiQ2dwS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHRjBkSEpwWW5WMFpYTWdQU0FrYjJKcVpXTjBMbkJ5YjNBb1hDSmhkSFJ5YVdKMWRHVnpYQ0lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OGdiRzl2Y0NCMGFISnZkV2RvSUR4elpXeGxZM1ErSUdGMGRISnBZblYwWlhNZ1lXNWtJR0Z3Y0d4NUlIUm9aVzBnYjI0Z1BHUnBkajVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdKQzVsWVdOb0tHRjBkSEpwWW5WMFpYTXNJR1oxYm1OMGFXOXVLQ2tnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHNWxkeTVoZEhSeUtIUm9hWE11Ym1GdFpTd2dkR2hwY3k1MllXeDFaU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUNSdVpYYzdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWJHOWhaRTF2Y21WU1pYTjFiSFJ6SUQwZ1puVnVZM1JwYjI0b0tWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGMxOXNiMkZrYVc1blgyMXZjbVVnUFNCMGNuVmxPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5MGNtbG5aMlZ5SUhOMFlYSjBJR1YyWlc1MFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmxkbVZ1ZEY5a1lYUmhJRDBnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyWnBaRG9nYzJWc1ppNXpabWxrTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHRnlaMlYwVTJWc1pXTjBiM0k2SUhObGJHWXVZV3BoZUY5MFlYSm5aWFJmWVhSMGNpeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFI1Y0dVNklGd2liRzloWkY5dGIzSmxYQ0lzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCdlltcGxZM1E2SUhObGJHWmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRISnBaMmRsY2tWMlpXNTBLRndpYzJZNllXcGhlSE4wWVhKMFhDSXNJR1YyWlc1MFgyUmhkR0VwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J3Y205alpYTnpYMlp2Y20wdWMyVjBWR0Y0UVhKamFHbDJaVkpsYzNWc2RITlZjbXdvYzJWc1ppd2djMlZzWmk1eVpYTjFiSFJ6WDNWeWJDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVuWlhSVmNteFFZWEpoYlhNb2RISjFaU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWJHRnpkRjl6ZFdKdGFYUmZjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVuWlhSVmNteFFZWEpoYlhNb1ptRnNjMlVwT3lBdkwyZHlZV0lnWVNCamIzQjVJRzltSUdoMFpTQlZVa3dnY0dGeVlXMXpJSGRwZEdodmRYUWdjR0ZuYVc1aGRHbHZiaUJoYkhKbFlXUjVJR0ZrWkdWa1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWVdwaGVGOXdjbTlqWlhOemFXNW5YM1Z5YkNBOUlGd2lYQ0k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCaGFtRjRYM0psYzNWc2RITmZkWEpzSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSaGRHRmZkSGx3WlNBOUlGd2lYQ0k3WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTl1YjNjZ1lXUmtJSFJvWlNCdVpYY2djR0ZuYVc1aGRHbHZibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYm1WNGRGOXdZV2RsWkY5dWRXMWlaWElnUFNCMGFHbHpMbU4xY25KbGJuUmZjR0ZuWldRZ0t5QXhPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnhkV1Z5ZVY5d1lYSmhiWE1nUFNCelpXeG1MbXB2YVc1VmNteFFZWEpoYlNoeGRXVnllVjl3WVhKaGJYTXNJRndpYzJaZmNHRm5aV1E5WENJcmJtVjRkRjl3WVdkbFpGOXVkVzFpWlhJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1elpYUkJhbUY0VW1WemRXeDBjMVZTVEhNb2NYVmxjbmxmY0dGeVlXMXpLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdZV3BoZUY5d2NtOWpaWE56YVc1blgzVnliQ0E5SUhObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKM0J5YjJObGMzTnBibWRmZFhKc0oxMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHRnFZWGhmY21WemRXeDBjMTkxY213Z1BTQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkeVpYTjFiSFJ6WDNWeWJDZGRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmtZWFJoWDNSNWNHVWdQU0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZGtZWFJoWDNSNWNHVW5YVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dllXSnZjblFnWVc1NUlIQnlaWFpwYjNWeklHRnFZWGdnY21WeGRXVnpkSE5jY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c1lYTjBYMkZxWVhoZmNtVnhkV1Z6ZEM1aFltOXlkQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG5WelpWOXpZM0p2Ykd4ZmJHOWhaR1Z5UFQweEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkd4dllXUmxjaUE5SUNRb0p6eGthWFl2UGljc2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNkamJHRnpjeWM2SUNkelpXRnlZMmd0Wm1sc2RHVnlMWE5qY205c2JDMXNiMkZrYVc1bkoxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3THk4dVlYQndaVzVrVkc4b2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHeHZZV1JsY2lBOUlITmxiR1l1ZFhCa1lYUmxURzloWkdWeVZHRm5LQ1JzYjJGa1pYSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVc1bWFXNXBkR1ZUWTNKdmJHeEJjSEJsYm1Rb0pHeHZZV1JsY2lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1FnUFNBa0xtZGxkQ2hoYW1GNFgzQnliMk5sYzNOcGJtZGZkWEpzTENCbWRXNWpkR2x2Ymloa1lYUmhMQ0J6ZEdGMGRYTXNJSEpsY1hWbGMzUXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVkzVnljbVZ1ZEY5d1lXZGxaQ3NyTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzWVhOMFgyRnFZWGhmY21WeGRXVnpkQ0E5SUc1MWJHdzdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5b2djMk55YjJ4c0lDb3ZYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNObGJHWXVjMk55YjJ4c1VtVnpkV3gwY3lncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRYQmtZWFJsY3lCMGFHVWdjbVZ6ZFhSc2N5QW1JR1p2Y20wZ2FIUnRiRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhaR1JTWlhOMWJIUnpLR1JoZEdFc0lHUmhkR0ZmZEhsd1pTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5TENCa1lYUmhYM1I1Y0dVcExtWmhhV3dvWm5WdVkzUnBiMjRvYW5GWVNGSXNJSFJsZUhSVGRHRjBkWE1zSUdWeWNtOXlWR2h5YjNkdUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWkdGMFlTQTlJSHQ5TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzV6Wm1sa0lEMGdjMlZzWmk1elptbGtPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNXZZbXBsWTNRZ1BTQnpaV3htTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzUwWVhKblpYUlRaV3hsWTNSdmNpQTlJSE5sYkdZdVlXcGhlRjkwWVhKblpYUmZZWFIwY2p0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1WVdwaGVGVlNUQ0E5SUdGcVlYaGZjSEp2WTJWemMybHVaMTkxY213N1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG1weFdFaFNJRDBnYW5GWVNGSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExuUmxlSFJUZEdGMGRYTWdQU0IwWlhoMFUzUmhkSFZ6TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzVsY25KdmNsUm9jbTkzYmlBOUlHVnljbTl5VkdoeWIzZHVPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNTBjbWxuWjJWeVJYWmxiblFvWENKelpqcGhhbUY0WlhKeWIzSmNJaXdnWkdGMFlTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5S1M1aGJIZGhlWE1vWm5WdVkzUnBiMjRvS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR0YwWVNBOUlIdDlPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNXpabWxrSUQwZ2MyVnNaaTV6Wm1sa08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1MFlYSm5aWFJUWld4bFkzUnZjaUE5SUhObGJHWXVZV3BoZUY5MFlYSm5aWFJmWVhSMGNqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdWIySnFaV04wSUQwZ2MyVnNaanRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxuVnpaVjl6WTNKdmJHeGZiRzloWkdWeVBUMHhLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JzYjJGa1pYSXVaR1YwWVdOb0tDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGMxOXNiMkZrYVc1blgyMXZjbVVnUFNCbVlXeHpaVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5SeWFXZG5aWEpGZG1WdWRDaGNJbk5tT21GcVlYaG1hVzVwYzJoY0lpd2daR0YwWVNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1bVpYUmphRUZxWVhoU1pYTjFiSFJ6SUQwZ1puVnVZM1JwYjI0b0tWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTkwY21sbloyVnlJSE4wWVhKMElHVjJaVzUwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbGRtVnVkRjlrWVhSaElEMGdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJacFpEb2djMlZzWmk1elptbGtMRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZEdGeVoyVjBVMlZzWldOMGIzSTZJSE5sYkdZdVlXcGhlRjkwWVhKblpYUmZZWFIwY2l4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIUjVjR1U2SUZ3aWJHOWhaRjl5WlhOMWJIUnpYQ0lzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCdlltcGxZM1E2SUhObGJHWmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRISnBaMmRsY2tWMlpXNTBLRndpYzJZNllXcGhlSE4wWVhKMFhDSXNJR1YyWlc1MFgyUmhkR0VwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaV1p2WTNWeklHRnVlU0JwYm5CMWRDQm1hV1ZzWkhNZ1lXWjBaWElnZEdobElHWnZjbTBnYUdGeklHSmxaVzRnZFhCa1lYUmxaRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkd4aGMzUmZZV04wYVhabFgybHVjSFYwWDNSbGVIUWdQU0FrZEdocGN5NW1hVzVrS0NkcGJuQjFkRnQwZVhCbFBWd2lkR1Y0ZEZ3aVhUcG1iMk4xY3ljcExtNXZkQ2hjSWk1elppMWtZWFJsY0dsamEyVnlYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlna2JHRnpkRjloWTNScGRtVmZhVzV3ZFhSZmRHVjRkQzVzWlc1bmRHZzlQVEVwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnNZWE4wWDJGamRHbDJaVjlwYm5CMWRGOTBaWGgwSUQwZ0pHeGhjM1JmWVdOMGFYWmxYMmx1Y0hWMFgzUmxlSFF1WVhSMGNpaGNJbTVoYldWY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdsekxtRmtaRU5zWVhOektGd2ljMlZoY21Ob0xXWnBiSFJsY2kxa2FYTmhZbXhsWkZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NISnZZMlZ6YzE5bWIzSnRMbVJwYzJGaWJHVkpibkIxZEhNb2MyVnNaaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyWmhaR1VnYjNWMElISmxjM1ZzZEhOY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1aGJtbHRZWFJsS0hzZ2IzQmhZMmwwZVRvZ01DNDFJSDBzSUZ3aVptRnpkRndpS1RzZ0x5OXNiMkZrYVc1blhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVabUZrWlVOdmJuUmxiblJCY21WaGN5Z2dYQ0p2ZFhSY0lpQXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTVoYW1GNFgyRmpkR2x2YmowOVhDSndZV2RwYm1GMGFXOXVYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmJtVmxaQ0IwYnlCeVpXMXZkbVVnWVdOMGFYWmxJR1pwYkhSbGNpQm1jbTl0SUZWU1RGeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmNYVmxjbmxmY0dGeVlXMXpJRDBnYzJWc1ppNXNZWE4wWDNOMVltMXBkRjl4ZFdWeWVWOXdZWEpoYlhNN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5dWIzY2dZV1JrSUhSb1pTQnVaWGNnY0dGbmFXNWhkR2x2Ymx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEJoWjJWT2RXMWlaWElnUFNCelpXeG1MaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxtRjBkSElvWENKa1lYUmhMWEJoWjJWa1hDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaHdZV2RsVG5WdFltVnlLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQndZV2RsVG5WdFltVnlJRDBnTVR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEJ5YjJObGMzTmZabTl5YlM1elpYUlVZWGhCY21Ob2FYWmxVbVZ6ZFd4MGMxVnliQ2h6Wld4bUxDQnpaV3htTG5KbGMzVnNkSE5mZFhKc0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1WjJWMFZYSnNVR0Z5WVcxektHWmhiSE5sS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlod1lXZGxUblZ0WW1WeVBqRXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVxYjJsdVZYSnNVR0Z5WVcwb2NYVmxjbmxmY0dGeVlXMXpMQ0JjSW5ObVgzQmhaMlZrUFZ3aUszQmhaMlZPZFcxaVpYSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJR2xtS0hObGJHWXVZV3BoZUY5aFkzUnBiMjQ5UFZ3aWMzVmliV2wwWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG1kbGRGVnliRkJoY21GdGN5aDBjblZsS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YkdGemRGOXpkV0p0YVhSZmNYVmxjbmxmY0dGeVlXMXpJRDBnYzJWc1ppNW5aWFJWY214UVlYSmhiWE1vWm1Gc2MyVXBPeUF2TDJkeVlXSWdZU0JqYjNCNUlHOW1JR2gwWlNCVlVrd2djR0Z5WVcxeklIZHBkR2h2ZFhRZ2NHRm5hVzVoZEdsdmJpQmhiSEpsWVdSNUlHRmtaR1ZrWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmhhbUY0WDNCeWIyTmxjM05wYm1kZmRYSnNJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR0ZxWVhoZmNtVnpkV3gwYzE5MWNtd2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR0YwWVY5MGVYQmxJRDBnWENKY0lqdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWMyVjBRV3BoZUZKbGMzVnNkSE5WVWt4ektIRjFaWEo1WDNCaGNtRnRjeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR0ZxWVhoZmNISnZZMlZ6YzJsdVoxOTFjbXdnUFNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR3Y205alpYTnphVzVuWDNWeWJDZGRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmhhbUY0WDNKbGMzVnNkSE5mZFhKc0lEMGdjMlZzWmk1aGFtRjRYM0psYzNWc2RITmZZMjl1WmxzbmNtVnpkV3gwYzE5MWNtd25YVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdaR0YwWVY5MGVYQmxJRDBnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25aR0YwWVY5MGVYQmxKMTA3WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTloWW05eWRDQmhibmtnY0hKbGRtbHZkWE1nWVdwaGVDQnlaWEYxWlhOMGMxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG14aGMzUmZZV3BoZUY5eVpYRjFaWE4wS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXhoYzNSZllXcGhlRjl5WlhGMVpYTjBMbUZpYjNKMEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR0ZxWVhoZllXTjBhVzl1SUQwZ2MyVnNaaTVoYW1GNFgyRmpkR2x2Ymp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDQTlJQ1F1WjJWMEtHRnFZWGhmY0hKdlkyVnpjMmx1WjE5MWNtd3NJR1oxYm1OMGFXOXVLR1JoZEdFc0lITjBZWFIxY3l3Z2NtVnhkV1Z6ZENsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzWVhOMFgyRnFZWGhmY21WeGRXVnpkQ0E5SUc1MWJHdzdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OTFjR1JoZEdWeklIUm9aU0J5WlhOMWRHeHpJQ1lnWm05eWJTQm9kRzFzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MblZ3WkdGMFpWSmxjM1ZzZEhNb1pHRjBZU3dnWkdGMFlWOTBlWEJsS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2THlCelkzSnZiR3dnWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5QnpaWFFnZEdobElIWmhjaUJpWVdOcklIUnZJSGRvWVhRZ2FYUWdkMkZ6SUdKbFptOXlaU0IwYUdVZ1lXcGhlQ0J5WlhGMVpYTjBJRzVoWkNCMGFHVWdabTl5YlNCeVpTMXBibWwwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbUZxWVhoZllXTjBhVzl1SUQwZ1lXcGhlRjloWTNScGIyNDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxuTmpjbTlzYkZKbGMzVnNkSE1vSUhObGJHWXVZV3BoZUY5aFkzUnBiMjRnS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2S2lCMWNHUmhkR1VnVlZKTUlDb3ZYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNWd1pHRjBaU0IxY213Z1ltVm1iM0psSUhCaFoybHVZWFJwYjI0c0lHSmxZMkYxYzJVZ2QyVWdibVZsWkNCMGJ5QmtieUJ6YjIxbElHTm9aV05yY3lCaFoyRnBibk1nZEdobElGVlNUQ0JtYjNJZ2FXNW1hVzVwZEdVZ2MyTnliMnhzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MblZ3WkdGMFpWVnliRWhwYzNSdmNua29ZV3BoZUY5eVpYTjFiSFJ6WDNWeWJDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXpaWFIxY0NCd1lXZHBibUYwYVc5dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5ObGRIVndRV3BoZUZCaFoybHVZWFJwYjI0b0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx6VTNWaWJXbDBkR2x1WnlBOUlHWmhiSE5sTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzhxSUhWelpYSWdaR1ZtSUNvdlhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWFYUlhiMjlEYjIxdFpYSmpaVU52Ym5SeWIyeHpLQ2s3SUM4dmQyOXZZMjl0YldWeVkyVWdiM0prWlhKaWVWeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUgwc0lHUmhkR0ZmZEhsd1pTa3VabUZwYkNobWRXNWpkR2x2YmlocWNWaElVaXdnZEdWNGRGTjBZWFIxY3l3Z1pYSnliM0pVYUhKdmQyNHBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1lYUmhJRDBnZTMwN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG5ObWFXUWdQU0J6Wld4bUxuTm1hV1E3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMblJoY21kbGRGTmxiR1ZqZEc5eUlEMGdjMlZzWmk1aGFtRjRYM1JoY21kbGRGOWhkSFJ5TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzV2WW1wbFkzUWdQU0J6Wld4bU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1aGFtRjRWVkpNSUQwZ1lXcGhlRjl3Y205alpYTnphVzVuWDNWeWJEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdWFuRllTRklnUFNCcWNWaElVanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVkR1Y0ZEZOMFlYUjFjeUE5SUhSbGVIUlRkR0YwZFhNN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG1WeWNtOXlWR2h5YjNkdUlEMGdaWEp5YjNKVWFISnZkMjQ3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx6VTNWaWJXbDBkR2x1WnlBOUlHWmhiSE5sTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTUwY21sbloyVnlSWFpsYm5Rb1hDSnpaanBoYW1GNFpYSnliM0pjSWl3Z1pHRjBZU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtTNWhiSGRoZVhNb1puVnVZM1JwYjI0b0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbk4wYjNBb2RISjFaU3gwY25WbEtTNWhibWx0WVhSbEtIc2diM0JoWTJsMGVUb2dNWDBzSUZ3aVptRnpkRndpS1RzZ0x5OW1hVzVwYzJobFpDQnNiMkZrYVc1blhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1aaFpHVkRiMjUwWlc1MFFYSmxZWE1vSUZ3aWFXNWNJaUFwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdFZ1BTQjdmVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVjMlpwWkNBOUlITmxiR1l1YzJacFpEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdWRHRnlaMlYwVTJWc1pXTjBiM0lnUFNCelpXeG1MbUZxWVhoZmRHRnlaMlYwWDJGMGRISTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtOWlhbVZqZENBOUlITmxiR1k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTV5WlcxdmRtVkRiR0Z6Y3loY0luTmxZWEpqYUMxbWFXeDBaWEl0WkdsellXSnNaV1JjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQndjbTlqWlhOelgyWnZjbTB1Wlc1aFlteGxTVzV3ZFhSektITmxiR1lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Y21WbWIyTjFjeUIwYUdVZ2JHRnpkQ0JoWTNScGRtVWdkR1Y0ZENCbWFXVnNaRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2JHRnpkRjloWTNScGRtVmZhVzV3ZFhSZmRHVjRkQ0U5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdsdWNIVjBJRDBnVzEwN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGtabWxsYkdSekxtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1lXTjBhWFpsWDJsdWNIVjBJRDBnSkNoMGFHbHpLUzVtYVc1a0tGd2lhVzV3ZFhSYmJtRnRaVDBuWENJcmJHRnpkRjloWTNScGRtVmZhVzV3ZFhSZmRHVjRkQ3RjSWlkZFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlna1lXTjBhWFpsWDJsdWNIVjBMbXhsYm1kMGFEMDlNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR2x1Y0hWMElEMGdKR0ZqZEdsMlpWOXBibkIxZER0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdrYVc1d2RYUXViR1Z1WjNSb1BUMHhLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWthVzV3ZFhRdVptOWpkWE1vS1M1MllXd29KR2x1Y0hWMExuWmhiQ2dwS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVtYjJOMWMwTmhiWEJ2S0NScGJuQjFkRnN3WFNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbVpwYm1Rb1hDSnBibkIxZEZ0dVlXMWxQU2RmYzJaZmMyVmhjbU5vSjExY0lpa3VkSEpwWjJkbGNpZ25abTlqZFhNbktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRISnBaMmRsY2tWMlpXNTBLRndpYzJZNllXcGhlR1pwYm1semFGd2lMQ0FnWkdGMFlTQXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1bWIyTjFjME5oYlhCdklEMGdablZ1WTNScGIyNG9hVzV3ZFhSR2FXVnNaQ2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2ZG1GeUlHbHVjSFYwUm1sbGJHUWdQU0JrYjJOMWJXVnVkQzVuWlhSRmJHVnRaVzUwUW5sSlpDaHBaQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtSUNocGJuQjFkRVpwWld4a0lDRTlJRzUxYkd3Z0ppWWdhVzV3ZFhSR2FXVnNaQzUyWVd4MVpTNXNaVzVuZEdnZ0lUMGdNQ2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9hVzV3ZFhSR2FXVnNaQzVqY21WaGRHVlVaWGgwVW1GdVoyVXBlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJHYVdWc1pGSmhibWRsSUQwZ2FXNXdkWFJHYVdWc1pDNWpjbVZoZEdWVVpYaDBVbUZ1WjJVb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCR2FXVnNaRkpoYm1kbExtMXZkbVZUZEdGeWRDZ25ZMmhoY21GamRHVnlKeXhwYm5CMWRFWnBaV3hrTG5aaGJIVmxMbXhsYm1kMGFDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1JtbGxiR1JTWVc1blpTNWpiMnhzWVhCelpTZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lFWnBaV3hrVW1GdVoyVXVjMlZzWldOMEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5Wld4elpTQnBaaUFvYVc1d2RYUkdhV1ZzWkM1elpXeGxZM1JwYjI1VGRHRnlkQ0I4ZkNCcGJuQjFkRVpwWld4a0xuTmxiR1ZqZEdsdmJsTjBZWEowSUQwOUlDY3dKeWtnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbGJHVnRUR1Z1SUQwZ2FXNXdkWFJHYVdWc1pDNTJZV3gxWlM1c1pXNW5kR2c3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhVzV3ZFhSR2FXVnNaQzV6Wld4bFkzUnBiMjVUZEdGeWRDQTlJR1ZzWlcxTVpXNDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXNXdkWFJHYVdWc1pDNXpaV3hsWTNScGIyNUZibVFnUFNCbGJHVnRUR1Z1TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhVzV3ZFhSR2FXVnNaQzVpYkhWeUtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwYm5CMWRFWnBaV3hrTG1adlkzVnpLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDBnWld4elpYdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNnZ2FXNXdkWFJHYVdWc1pDQXBJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBibkIxZEVacFpXeGtMbVp2WTNWektDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTUwY21sbloyVnlSWFpsYm5RZ1BTQm1kVzVqZEdsdmJpaGxkbVZ1ZEc1aGJXVXNJR1JoZEdFcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdWMlpXNTBYMk52Ym5SaGFXNWxjaUE5SUNRb1hDSXVjMlZoY21Ob1lXNWtabWxzZEdWeVcyUmhkR0V0YzJZdFptOXliUzFwWkQwblhDSXJjMlZzWmk1elptbGtLMXdpSjExY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDUmxkbVZ1ZEY5amIyNTBZV2x1WlhJdWRISnBaMmRsY2lobGRtVnVkRzVoYldVc0lGc2daR0YwWVNCZEtUdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVptVjBZMmhCYW1GNFJtOXliU0E5SUdaMWJtTjBhVzl1S0NsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZkSEpwWjJkbGNpQnpkR0Z5ZENCbGRtVnVkRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWlhabGJuUmZaR0YwWVNBOUlIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5tYVdRNklITmxiR1l1YzJacFpDeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFJoY21kbGRGTmxiR1ZqZEc5eU9pQnpaV3htTG1GcVlYaGZkR0Z5WjJWMFgyRjBkSElzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMGVYQmxPaUJjSW1admNtMWNJaXhjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUc5aWFtVmpkRG9nYzJWc1pseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1MGNtbG5aMlZ5UlhabGJuUW9YQ0p6WmpwaGFtRjRabTl5YlhOMFlYSjBYQ0lzSUZzZ1pYWmxiblJmWkdGMFlTQmRLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbUZrWkVOc1lYTnpLRndpYzJWaGNtTm9MV1pwYkhSbGNpMWthWE5oWW14bFpGd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjSEp2WTJWemMxOW1iM0p0TG1ScGMyRmliR1ZKYm5CMWRITW9jMlZzWmlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnY1hWbGNubGZjR0Z5WVcxeklEMGdjMlZzWmk1blpYUlZjbXhRWVhKaGJYTW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YkdGdVoxOWpiMlJsSVQxY0lsd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNOdklHRmtaQ0JwZEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NYVmxjbmxmY0dGeVlXMXpJRDBnYzJWc1ppNXFiMmx1VlhKc1VHRnlZVzBvY1hWbGNubGZjR0Z5WVcxekxDQmNJbXhoYm1jOVhDSXJjMlZzWmk1c1lXNW5YMk52WkdVcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWVdwaGVGOXdjbTlqWlhOemFXNW5YM1Z5YkNBOUlITmxiR1l1WVdSa1ZYSnNVR0Z5WVcwb2MyVnNaaTVoYW1GNFgyWnZjbTFmZFhKc0xDQnhkV1Z5ZVY5d1lYSmhiWE1wTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1pHRjBZVjkwZVhCbElEMGdYQ0pxYzI5dVhDSTdYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OWhZbTl5ZENCaGJua2djSEpsZG1sdmRYTWdZV3BoZUNCeVpYRjFaWE4wYzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2S21sbUtITmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1FwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxteGhjM1JmWVdwaGVGOXlaWEYxWlhOMExtRmliM0owS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNCOUtpOWNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwzTmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1FnUFZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0pDNW5aWFFvWVdwaGVGOXdjbTlqWlhOemFXNW5YM1Z5YkN3Z1puVnVZM1JwYjI0b1pHRjBZU3dnYzNSaGRIVnpMQ0J5WlhGMVpYTjBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNObGJHWXViR0Z6ZEY5aGFtRjRYM0psY1hWbGMzUWdQU0J1ZFd4c08xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRYQmtZWFJsY3lCMGFHVWdjbVZ6ZFhSc2N5QW1JR1p2Y20wZ2FIUnRiRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNTFjR1JoZEdWR2IzSnRLR1JoZEdFc0lHUmhkR0ZmZEhsd1pTazdYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTd2daR0YwWVY5MGVYQmxLUzVtWVdsc0tHWjFibU4wYVc5dUtHcHhXRWhTTENCMFpYaDBVM1JoZEhWekxDQmxjbkp2Y2xSb2NtOTNiaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHUmhkR0VnUFNCN2ZUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdWMyWnBaQ0E5SUhObGJHWXVjMlpwWkR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1ZEdGeVoyVjBVMlZzWldOMGIzSWdQU0J6Wld4bUxtRnFZWGhmZEdGeVoyVjBYMkYwZEhJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG05aWFtVmpkQ0E5SUhObGJHWTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtRnFZWGhWVWt3Z1BTQmhhbUY0WDNCeWIyTmxjM05wYm1kZmRYSnNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNXFjVmhJVWlBOUlHcHhXRWhTTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzUwWlhoMFUzUmhkSFZ6SUQwZ2RHVjRkRk4wWVhSMWN6dGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdVpYSnliM0pVYUhKdmQyNGdQU0JsY25KdmNsUm9jbTkzYmp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZEhKcFoyZGxja1YyWlc1MEtGd2ljMlk2WVdwaGVHVnljbTl5WENJc0lGc2daR0YwWVNCZEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDBwTG1Gc2QyRjVjeWhtZFc1amRHbHZiaWdwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtZWFJoSUQwZ2UzMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExuTm1hV1FnUFNCelpXeG1Mbk5tYVdRN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG5SaGNtZGxkRk5sYkdWamRHOXlJRDBnYzJWc1ppNWhhbUY0WDNSaGNtZGxkRjloZEhSeU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1dlltcGxZM1FnUFNCelpXeG1PMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG5KbGJXOTJaVU5zWVhOektGd2ljMlZoY21Ob0xXWnBiSFJsY2kxa2FYTmhZbXhsWkZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEJ5YjJObGMzTmZabTl5YlM1bGJtRmliR1ZKYm5CMWRITW9jMlZzWmlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNTBjbWxuWjJWeVJYWmxiblFvWENKelpqcGhhbUY0Wm05eWJXWnBibWx6YUZ3aUxDQmJJR1JoZEdFZ1hTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZMjl3ZVV4cGMzUkpkR1Z0YzBOdmJuUmxiblJ6SUQwZ1puVnVZM1JwYjI0b0pHeHBjM1JmWm5KdmJTd2dKR3hwYzNSZmRHOHBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MyVnNaaUE5SUhSb2FYTTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJOdmNIa2diM1psY2lCamFHbHNaQ0JzYVhOMElHbDBaVzF6WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCc2FWOWpiMjUwWlc1MGMxOWhjbkpoZVNBOUlHNWxkeUJCY25KaGVTZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWm5KdmJWOWhkSFJ5YVdKMWRHVnpJRDBnYm1WM0lFRnljbUY1S0NrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdaeWIyMWZabWxsYkdSeklEMGdKR3hwYzNSZlpuSnZiUzVtYVc1a0tGd2lQaUIxYkNBK0lHeHBYQ0lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0pHWnliMjFmWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0b2FTbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2JHbGZZMjl1ZEdWdWRITmZZWEp5WVhrdWNIVnphQ2drS0hSb2FYTXBMbWgwYld3b0tTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR0YwZEhKcFluVjBaWE1nUFNBa0tIUm9hWE1wTG5CeWIzQW9YQ0poZEhSeWFXSjFkR1Z6WENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdabkp2YlY5aGRIUnlhV0oxZEdWekxuQjFjMmdvWVhSMGNtbGlkWFJsY3lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5MllYSWdabWxsYkdSZmJtRnRaU0E5SUNRb2RHaHBjeWt1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGJtRnRaVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZkbUZ5SUhSdlgyWnBaV3hrSUQwZ0pHeHBjM1JmZEc4dVptbHVaQ2hjSWo0Z2RXd2dQaUJzYVZ0a1lYUmhMWE5tTFdacFpXeGtMVzVoYldVOUoxd2lLMlpwWld4a1gyNWhiV1VyWENJblhWd2lLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM05sYkdZdVkyOXdlVUYwZEhKcFluVjBaWE1vSkNoMGFHbHpLU3dnSkd4cGMzUmZkRzhzSUZ3aVpHRjBZUzF6WmkxY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJzYVY5cGRDQTlJREE3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2RHOWZabWxsYkdSeklEMGdKR3hwYzNSZmRHOHVabWx1WkNoY0lqNGdkV3dnUGlCc2FWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdKSFJ2WDJacFpXeGtjeTVsWVdOb0tHWjFibU4wYVc5dUtHa3BlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkNoMGFHbHpLUzVvZEcxc0tHeHBYMk52Ym5SbGJuUnpYMkZ5Y21GNVcyeHBYMmwwWFNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUm1jbTl0WDJacFpXeGtJRDBnSkNna1puSnZiVjltYVdWc1pITXVaMlYwS0d4cFgybDBLU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSMGIxOW1hV1ZzWkNBOUlDUW9kR2hwY3lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkRzlmWm1sbGJHUXVjbVZ0YjNabFFYUjBjaWhjSW1SaGRHRXRjMll0ZEdGNGIyNXZiWGt0WVhKamFHbDJaVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WTI5d2VVRjBkSEpwWW5WMFpYTW9KR1p5YjIxZlptbGxiR1FzSUNSMGIxOW1hV1ZzWkNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYkdsZmFYUXJLenRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdktuWmhjaUFrWm5KdmJWOW1hV1ZzWkhNZ1BTQWtiR2x6ZEY5bWNtOXRMbVpwYm1Rb1hDSWdkV3dnUGlCc2FWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2RHOWZabWxsYkdSeklEMGdKR3hwYzNSZmRHOHVabWx1WkNoY0lpQStJR3hwWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0pHWnliMjFmWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0b2FXNWtaWGdzSUhaaGJDbDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdrS0hSb2FYTXBMbWhoYzBGMGRISnBZblYwWlNoY0ltUmhkR0V0YzJZdGRHRjRiMjV2YlhrdFlYSmphR2wyWlZ3aUtTbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1OdmNIbEJkSFJ5YVdKMWRHVnpLQ1JzYVhOMFgyWnliMjBzSUNSc2FYTjBYM1J2S1RzcUwxeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1MWNHUmhkR1ZHYjNKdFFYUjBjbWxpZFhSbGN5QTlJR1oxYm1OMGFXOXVLQ1JzYVhOMFgyWnliMjBzSUNSc2FYTjBYM1J2S1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1p5YjIxZllYUjBjbWxpZFhSbGN5QTlJQ1JzYVhOMFgyWnliMjB1Y0hKdmNDaGNJbUYwZEhKcFluVjBaWE5jSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dklHeHZiM0FnZEdoeWIzVm5hQ0E4YzJWc1pXTjBQaUJoZEhSeWFXSjFkR1Z6SUdGdVpDQmhjSEJzZVNCMGFHVnRJRzl1SUR4a2FYWStYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RHOWZZWFIwY21saWRYUmxjeUE5SUNSc2FYTjBYM1J2TG5CeWIzQW9YQ0poZEhSeWFXSjFkR1Z6WENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBa0xtVmhZMmdvZEc5ZllYUjBjbWxpZFhSbGN5d2dablZ1WTNScGIyNG9LU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2JHbHpkRjkwYnk1eVpXMXZkbVZCZEhSeUtIUm9hWE11Ym1GdFpTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkM1bFlXTm9LR1p5YjIxZllYUjBjbWxpZFhSbGN5d2dablZ1WTNScGIyNG9LU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2JHbHpkRjkwYnk1aGRIUnlLSFJvYVhNdWJtRnRaU3dnZEdocGN5NTJZV3gxWlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZMjl3ZVVGMGRISnBZblYwWlhNZ1BTQm1kVzVqZEdsdmJpZ2tabkp2YlN3Z0pIUnZMQ0J3Y21WbWFYZ3BYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvY0hKbFptbDRLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhCeVpXWnBlQ0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWNtOXRYMkYwZEhKcFluVjBaWE1nUFNBa1puSnZiUzV3Y205d0tGd2lZWFIwY21saWRYUmxjMXdpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIwYjE5aGRIUnlhV0oxZEdWeklEMGdKSFJ2TG5CeWIzQW9YQ0poZEhSeWFXSjFkR1Z6WENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBa0xtVmhZMmdvZEc5ZllYUjBjbWxpZFhSbGN5d2dablZ1WTNScGIyNG9LU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvY0hKbFptbDRJVDFjSWx3aUtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLSFJvYVhNdWJtRnRaUzVwYm1SbGVFOW1LSEJ5WldacGVDa2dQVDBnTUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkRzh1Y21WdGIzWmxRWFIwY2loMGFHbHpMbTVoYldVcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJWY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5UjBieTV5WlcxdmRtVkJkSFJ5S0hSb2FYTXVibUZ0WlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkM1bFlXTm9LR1p5YjIxZllYUjBjbWxpZFhSbGN5d2dablZ1WTNScGIyNG9LU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHOHVZWFIwY2loMGFHbHpMbTVoYldVc0lIUm9hWE11ZG1Gc2RXVXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZMjl3ZVVadmNtMUJkSFJ5YVdKMWRHVnpJRDBnWm5WdVkzUnBiMjRvSkdaeWIyMHNJQ1IwYnlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjBieTV5WlcxdmRtVkJkSFJ5S0Z3aVpHRjBZUzFqZFhKeVpXNTBMWFJoZUc5dWIyMTVMV0Z5WTJocGRtVmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdVkyOXdlVUYwZEhKcFluVjBaWE1vSkdaeWIyMHNJQ1IwYnlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NTFjR1JoZEdWR2IzSnRJRDBnWm5WdVkzUnBiMjRvWkdGMFlTd2daR0YwWVY5MGVYQmxLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb1pHRjBZVjkwZVhCbFBUMWNJbXB6YjI1Y0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2V5OHZkR2hsYmlCM1pTQmthV1FnWVNCeVpYRjFaWE4wSUhSdklIUm9aU0JoYW1GNElHVnVaSEJ2YVc1MExDQnpieUJsZUhCbFkzUWdZVzRnYjJKcVpXTjBJR0poWTJ0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvWkdGMFlWc25abTl5YlNkZEtTRTlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaVzF2ZG1VZ1lXeHNJR1YyWlc1MGN5Qm1jbTl0SUZNbVJpQm1iM0p0WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdWIyWm1LQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmNtVm1jbVZ6YUNCMGFHVWdabTl5YlNBb1lYVjBieUJqYjNWdWRDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbU52Y0hsTWFYTjBTWFJsYlhORGIyNTBaVzUwY3lna0tHUmhkR0ZiSjJadmNtMG5YU2tzSUNSMGFHbHpLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5eVpTQnBibWwwSUZNbVJpQmpiR0Z6Y3lCdmJpQjBhR1VnWm05eWJWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dkpIUm9hWE11YzJWaGNtTm9RVzVrUm1sc2RHVnlLQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmFXWWdZV3BoZUNCcGN5QmxibUZpYkdWa0lHbHVhWFFnZEdobElIQmhaMmx1WVhScGIyNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1cGJtbDBLSFJ5ZFdVcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxtbHpYMkZxWVhnOVBURXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5ObGRIVndRV3BoZUZCaFoybHVZWFJwYjI0b0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1Ga1pGSmxjM1ZzZEhNZ1BTQm1kVzVqZEdsdmJpaGtZWFJoTENCa1lYUmhYM1I1Y0dVcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJWc1ppQTlJSFJvYVhNN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhrWVhSaFgzUjVjR1U5UFZ3aWFuTnZibHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3THk5MGFHVnVJSGRsSUdScFpDQmhJSEpsY1hWbGMzUWdkRzhnZEdobElHRnFZWGdnWlc1a2NHOXBiblFzSUhOdklHVjRjR1ZqZENCaGJpQnZZbXBsWTNRZ1ltRmphMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5bmNtRmlJSFJvWlNCeVpYTjFiSFJ6SUdGdVpDQnNiMkZrSUdsdVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM05sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1WVhCd1pXNWtLR1JoZEdGYkozSmxjM1ZzZEhNblhTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxteHZZV1JmYlc5eVpWOW9kRzFzSUQwZ1pHRjBZVnNuY21WemRXeDBjeWRkTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9aR0YwWVY5MGVYQmxQVDFjSW1oMGJXeGNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdleTh2ZDJVZ1lYSmxJR1Y0Y0dWamRHbHVaeUIwYUdVZ2FIUnRiQ0J2WmlCMGFHVWdjbVZ6ZFd4MGN5QndZV2RsSUdKaFkyc3NJSE52SUdWNGRISmhZM1FnZEdobElHaDBiV3dnZDJVZ2JtVmxaRnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrWkdGMFlWOXZZbW9nUFNBa0tHUmhkR0VwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2YzJWc1ppNGthVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpNWhjSEJsYm1Rb0pHUmhkR0ZmYjJKcUxtWnBibVFvYzJWc1ppNWhhbUY0WDNSaGNtZGxkRjloZEhSeUtTNW9kRzFzS0NrcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c2IyRmtYMjF2Y21WZmFIUnRiQ0E5SUNSa1lYUmhYMjlpYWk1bWFXNWtLSE5sYkdZdVlXcGhlRjkwWVhKblpYUmZZWFIwY2lrdWFIUnRiQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdhVzVtYVc1cGRHVmZjMk55YjJ4c1gyVnVaQ0E5SUdaaGJITmxPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0pDaGNJanhrYVhZK1hDSXJjMlZzWmk1c2IyRmtYMjF2Y21WZmFIUnRiQ3RjSWp3dlpHbDJQbHdpS1M1bWFXNWtLRndpVzJSaGRHRXRjMlZoY21Ob0xXWnBiSFJsY2kxaFkzUnBiMjQ5SjJsdVptbHVhWFJsTFhOamNtOXNiQzFsYm1RblhWd2lLUzVzWlc1bmRHZytNQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMlZ1WkNBOUlIUnlkV1U3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmFXWWdkR2hsY21VZ2FYTWdZVzV2ZEdobGNpQnpaV3hsWTNSdmNpQm1iM0lnYVc1bWFXNXBkR1VnYzJOeWIyeHNMQ0JtYVc1a0lIUm9aU0JqYjI1MFpXNTBjeUJ2WmlCMGFHRjBJR2x1YzNSbFlXUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1cGJtWnBibWwwWlY5elkzSnZiR3hmWTI5dWRHRnBibVZ5SVQxY0lsd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxteHZZV1JmYlc5eVpWOW9kRzFzSUQwZ0pDaGNJanhrYVhZK1hDSXJjMlZzWmk1c2IyRmtYMjF2Y21WZmFIUnRiQ3RjSWp3dlpHbDJQbHdpS1M1bWFXNWtLSE5sYkdZdWFXNW1hVzVwZEdWZmMyTnliMnhzWDJOdmJuUmhhVzVsY2lrdWFIUnRiQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzSmxjM1ZzZEY5amJHRnpjeUU5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSeVpYTjFiSFJmYVhSbGJYTWdQU0FrS0Z3aVBHUnBkajVjSWl0elpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc0sxd2lQQzlrYVhZK1hDSXBMbVpwYm1Rb2MyVnNaaTVwYm1acGJtbDBaVjl6WTNKdmJHeGZjbVZ6ZFd4MFgyTnNZWE56S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrY21WemRXeDBYMmwwWlcxelgyTnZiblJoYVc1bGNpQTlJQ1FvSnp4a2FYWXZQaWNzSUh0OUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1J5WlhOMWJIUmZhWFJsYlhOZlkyOXVkR0ZwYm1WeUxtRndjR1Z1WkNna2NtVnpkV3gwWDJsMFpXMXpLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG14dllXUmZiVzl5WlY5b2RHMXNJRDBnSkhKbGMzVnNkRjlwZEdWdGMxOWpiMjUwWVdsdVpYSXVhSFJ0YkNncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhwYm1acGJtbDBaVjl6WTNKdmJHeGZaVzVrS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3THk5M1pTQm1iM1Z1WkNCaElHUmhkR0VnWVhSMGNtbGlkWFJsSUhOcFoyNWhiR3hwYm1jZ2RHaGxJR3hoYzNRZ2NHRm5aU0J6YnlCbWFXNXBjMmdnYUdWeVpWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhWE5mYldGNFgzQmhaMlZrSUQwZ2RISjFaVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXViR0Z6ZEY5c2IyRmtYMjF2Y21WZmFIUnRiQ0E5SUhObGJHWXViRzloWkY5dGIzSmxYMmgwYld3N1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBibVpwYm1sMFpWTmpjbTlzYkVGd2NHVnVaQ2h6Wld4bUxteHZZV1JmYlc5eVpWOW9kRzFzS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0JwWmloelpXeG1MbXhoYzNSZmJHOWhaRjl0YjNKbFgyaDBiV3doUFQxelpXeG1MbXh2WVdSZmJXOXlaVjlvZEcxc0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMk5vWldOcklIUnZJRzFoYTJVZ2MzVnlaU0IwYUdVZ2JtVjNJR2gwYld3Z1ptVjBZMmhsWkNCcGN5QmthV1ptWlhKbGJuUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWJHRnpkRjlzYjJGa1gyMXZjbVZmYUhSdGJDQTlJSE5sYkdZdWJHOWhaRjl0YjNKbFgyaDBiV3c3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx1Wm1sdWFYUmxVMk55YjJ4c1FYQndaVzVrS0hObGJHWXViRzloWkY5dGIzSmxYMmgwYld3cE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHN2TDNkbElISmxZMlZwZG1Wa0lIUm9aU0J6WVcxbElHMWxjM05oWjJVZ1lXZGhhVzRnYzI4Z1pHOXVKM1FnWVdSa0xDQmhibVFnZEdWc2JDQlRKa1lnZEdoaGRDQjNaU2R5WlNCaGRDQjBhR1VnWlc1a0xpNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFYTmZiV0Y0WDNCaFoyVmtJRDBnZEhKMVpUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVhVzVtYVc1cGRHVlRZM0p2Ykd4QmNIQmxibVFnUFNCbWRXNWpkR2x2Ymlna2IySnFaV04wS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1cGJtWnBibWwwWlY5elkzSnZiR3hmY21WemRXeDBYMk5zWVhOeklUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MaVJwYm1acGJtbDBaVjl6WTNKdmJHeGZZMjl1ZEdGcGJtVnlMbVpwYm1Rb2MyVnNaaTVwYm1acGJtbDBaVjl6WTNKdmJHeGZjbVZ6ZFd4MFgyTnNZWE56S1M1c1lYTjBLQ2t1WVdaMFpYSW9KRzlpYW1WamRDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdUpHbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJdVlYQndaVzVrS0NSdlltcGxZM1FwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1MWNHUmhkR1ZTWlhOMWJIUnpJRDBnWm5WdVkzUnBiMjRvWkdGMFlTd2daR0YwWVY5MGVYQmxLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb1pHRjBZVjkwZVhCbFBUMWNJbXB6YjI1Y0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2V5OHZkR2hsYmlCM1pTQmthV1FnWVNCeVpYRjFaWE4wSUhSdklIUm9aU0JoYW1GNElHVnVaSEJ2YVc1MExDQnpieUJsZUhCbFkzUWdZVzRnYjJKcVpXTjBJR0poWTJ0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZaM0poWWlCMGFHVWdjbVZ6ZFd4MGN5QmhibVFnYkc5aFpDQnBibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1b2RHMXNLR1JoZEdGYkozSmxjM1ZzZEhNblhTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtHUmhkR0ZiSjJadmNtMG5YU2toUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Y21WdGIzWmxJR0ZzYkNCbGRtVnVkSE1nWm5KdmJTQlRKa1lnWm05eWJWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbTltWmlncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM0psYlc5MlpTQndZV2RwYm1GMGFXOXVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV5WlcxdmRtVkJhbUY0VUdGbmFXNWhkR2x2YmlncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM0psWm5KbGMyZ2dkR2hsSUdadmNtMGdLR0YxZEc4Z1kyOTFiblFwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1amIzQjVUR2x6ZEVsMFpXMXpRMjl1ZEdWdWRITW9KQ2hrWVhSaFd5ZG1iM0p0SjEwcExDQWtkR2hwY3lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZkWEJrWVhSbElHRjBkSEpwWW5WMFpYTWdiMjRnWm05eWJWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZMjl3ZVVadmNtMUJkSFJ5YVdKMWRHVnpLQ1FvWkdGMFlWc25abTl5YlNkZEtTd2dKSFJvYVhNcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM0psSUdsdWFYUWdVeVpHSUdOc1lYTnpJRzl1SUhSb1pTQm1iM0p0WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSFJvYVhNdWMyVmhjbU5vUVc1a1JtbHNkR1Z5S0hzbmFYTkpibWwwSnpvZ1ptRnNjMlY5S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJWY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5UjBhR2x6TG1acGJtUW9YQ0pwYm5CMWRGd2lLUzV5WlcxdmRtVkJkSFJ5S0Z3aVpHbHpZV0pzWldSY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCcFppaGtZWFJoWDNSNWNHVTlQVndpYUhSdGJGd2lLU0I3THk5M1pTQmhjbVVnWlhod1pXTjBhVzVuSUhSb1pTQm9kRzFzSUc5bUlIUm9aU0J5WlhOMWJIUnpJSEJoWjJVZ1ltRmpheXdnYzI4Z1pYaDBjbUZqZENCMGFHVWdhSFJ0YkNCM1pTQnVaV1ZrWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSa1lYUmhYMjlpYWlBOUlDUW9aR0YwWVNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1b2RHMXNLQ1JrWVhSaFgyOWlhaTVtYVc1a0tITmxiR1l1WVdwaGVGOTBZWEpuWlhSZllYUjBjaWt1YUhSdGJDZ3BLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5Wd1pHRjBaVU52Ym5SbGJuUkJjbVZoY3lnZ0pHUmhkR0ZmYjJKcUlDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJaTV6WldGeVkyaGhibVJtYVd4MFpYSmNJaWt1YkdWdVozUm9JRDRnTUNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIc3ZMM1JvWlc0Z2RHaGxjbVVnWVhKbElITmxZWEpqYUNCbWIzSnRLSE1wSUdsdWMybGtaU0IwYUdVZ2NtVnpkV3gwY3lCamIyNTBZV2x1WlhJc0lITnZJSEpsTFdsdWFYUWdkR2hsYlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxtWnBibVFvWENJdWMyVmhjbU5vWVc1a1ptbHNkR1Z5WENJcExuTmxZWEpqYUVGdVpFWnBiSFJsY2lncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZhV1lnZEdobElHTjFjbkpsYm5RZ2MyVmhjbU5vSUdadmNtMGdhWE1nYm05MElHbHVjMmxrWlNCMGFHVWdjbVZ6ZFd4MGN5QmpiMjUwWVdsdVpYSXNJSFJvWlc0Z2NISnZZMlZsWkNCaGN5QnViM0p0WVd3Z1lXNWtJSFZ3WkdGMFpTQjBhR1VnWm05eWJWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1bWFXNWtLRndpTG5ObFlYSmphR0Z1WkdacGJIUmxjbHRrWVhSaExYTm1MV1p2Y20wdGFXUTlKMXdpSUNzZ2MyVnNaaTV6Wm1sa0lDc2dYQ0luWFZ3aUtTNXNaVzVuZEdnOVBUQXBJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUnVaWGRmYzJWaGNtTm9YMlp2Y20wZ1BTQWtaR0YwWVY5dlltb3VabWx1WkNoY0lpNXpaV0Z5WTJoaGJtUm1hV3gwWlhKYlpHRjBZUzF6WmkxbWIzSnRMV2xrUFNkY0lpQXJJSE5sYkdZdWMyWnBaQ0FySUZ3aUoxMWNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDZ2tibVYzWDNObFlYSmphRjltYjNKdExteGxibWQwYUNBOVBTQXhLU0I3THk5MGFHVnVJSEpsY0d4aFkyVWdkR2hsSUhObFlYSmphQ0JtYjNKdElIZHBkR2dnZEdobElHNWxkeUJ2Ym1WY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Y21WdGIzWmxJR0ZzYkNCbGRtVnVkSE1nWm5KdmJTQlRKa1lnWm05eWJWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkR2hwY3k1dlptWW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjbVZ0YjNabElIQmhaMmx1WVhScGIyNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1eVpXMXZkbVZCYW1GNFVHRm5hVzVoZEdsdmJpZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaV1p5WlhOb0lIUm9aU0JtYjNKdElDaGhkWFJ2SUdOdmRXNTBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtTnZjSGxNYVhOMFNYUmxiWE5EYjI1MFpXNTBjeWdrYm1WM1gzTmxZWEpqYUY5bWIzSnRMQ0FrZEdocGN5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzVndaR0YwWlNCaGRIUnlhV0oxZEdWeklHOXVJR1p2Y20xY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVqYjNCNVJtOXliVUYwZEhKcFluVjBaWE1vSkc1bGQxOXpaV0Z5WTJoZlptOXliU3dnSkhSb2FYTXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaU0JwYm1sMElGTW1SaUJqYkdGemN5QnZiaUIwYUdVZ1ptOXliVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGN5NXpaV0Z5WTJoQmJtUkdhV3gwWlhJb2V5ZHBjMGx1YVhRbk9pQm1ZV3h6WlgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMeVIwYUdsekxtWnBibVFvWENKcGJuQjFkRndpS1M1eVpXMXZkbVZCZEhSeUtGd2laR2x6WVdKc1pXUmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx6WDIxaGVGOXdZV2RsWkNBOUlHWmhiSE5sT3lBdkwyWnZjaUJwYm1acGJtbDBaU0J6WTNKdmJHeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVqZFhKeVpXNTBYM0JoWjJWa0lEMGdNVHNnTHk5bWIzSWdhVzVtYVc1cGRHVWdjMk55YjJ4c1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjMlYwU1c1bWFXNXBkR1ZUWTNKdmJHeERiMjUwWVdsdVpYSW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5Wd1pHRjBaVU52Ym5SbGJuUkJjbVZoY3lBOUlHWjFibU4wYVc5dUtDQWthSFJ0YkY5a1lYUmhJQ2tnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeThnWVdSa0lHRmtaR2wwYVc5dVlXd2dZMjl1ZEdWdWRDQmhjbVZoYzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb0lIUm9hWE11WVdwaGVGOTFjR1JoZEdWZmMyVmpkR2x2Ym5NZ0ppWWdkR2hwY3k1aGFtRjRYM1Z3WkdGMFpWOXpaV04wYVc5dWN5NXNaVzVuZEdnZ0tTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JtYjNJZ0tHbHVaR1Y0SUQwZ01Ec2dhVzVrWlhnZ1BDQjBhR2x6TG1GcVlYaGZkWEJrWVhSbFgzTmxZM1JwYjI1ekxteGxibWQwYURzZ0t5dHBibVJsZUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnpaV3hsWTNSdmNpQTlJSFJvYVhNdVlXcGhlRjkxY0dSaGRHVmZjMlZqZEdsdmJuTmJhVzVrWlhoZE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb0lITmxiR1ZqZEc5eUlDa3VhSFJ0YkNnZ0pHaDBiV3hmWkdGMFlTNW1hVzVrS0NCelpXeGxZM1J2Y2lBcExtaDBiV3dvS1NBcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11Wm1Ga1pVTnZiblJsYm5SQmNtVmhjeUE5SUdaMWJtTjBhVzl1S0NCa2FYSmxZM1JwYjI0Z0tTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiM0JoWTJsMGVTQTlJREF1TlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tDQmthWEpsWTNScGIyNGdQVDA5SUZ3aWFXNWNJaUFwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHOXdZV05wZEhrZ1BTQXhPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb0lIUm9hWE11WVdwaGVGOTFjR1JoZEdWZmMyVmpkR2x2Ym5NZ0ppWWdkR2hwY3k1aGFtRjRYM1Z3WkdGMFpWOXpaV04wYVc5dWN5NXNaVzVuZEdnZ0tTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JtYjNJZ0tHbHVaR1Y0SUQwZ01Ec2dhVzVrWlhnZ1BDQjBhR2x6TG1GcVlYaGZkWEJrWVhSbFgzTmxZM1JwYjI1ekxteGxibWQwYURzZ0t5dHBibVJsZUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnpaV3hsWTNSdmNpQTlJSFJvYVhNdVlXcGhlRjkxY0dSaGRHVmZjMlZqZEdsdmJuTmJhVzVrWlhoZE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb0lITmxiR1ZqZEc5eUlDa3VjM1J2Y0NoMGNuVmxMSFJ5ZFdVcExtRnVhVzFoZEdVb0lIc2diM0JoWTJsMGVUb2diM0JoWTJsMGVYMHNJRndpWm1GemRGd2lJQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0JjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuSmxiVzkyWlZkdmIwTnZiVzFsY21ObFEyOXVkSEp2YkhNZ1BTQm1kVzVqZEdsdmJpZ3BlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhkdmIxOXZjbVJsY21KNUlEMGdKQ2duTG5kdmIyTnZiVzFsY21ObExXOXlaR1Z5YVc1bklDNXZjbVJsY21KNUp5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrZDI5dlgyOXlaR1Z5WW5sZlptOXliU0E5SUNRb0p5NTNiMjlqYjIxdFpYSmpaUzF2Y21SbGNtbHVaeWNwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0pIZHZiMTl2Y21SbGNtSjVYMlp2Y20wdWIyWm1LQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ1IzYjI5ZmIzSmtaWEppZVM1dlptWW9LVHRjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUZrWkZGMVpYSjVVR0Z5WVcwZ1BTQm1kVzVqZEdsdmJpaHVZVzFsTENCMllXeDFaU3dnZFhKc1gzUjVjR1VwZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIVnliRjkwZVhCbEtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFZ5YkY5MGVYQmxJRDBnWENKaGJHeGNJanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1WNGRISmhYM0YxWlhKNVgzQmhjbUZ0YzF0MWNteGZkSGx3WlYxYmJtRnRaVjBnUFNCMllXeDFaVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1cGJtbDBWMjl2UTI5dGJXVnlZMlZEYjI1MGNtOXNjeUE5SUdaMWJtTjBhVzl1S0NsN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5KbGJXOTJaVmR2YjBOdmJXMWxjbU5sUTI5dWRISnZiSE1vS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrZDI5dlgyOXlaR1Z5WW5rZ1BTQWtLQ2N1ZDI5dlkyOXRiV1Z5WTJVdGIzSmtaWEpwYm1jZ0xtOXlaR1Z5WW5rbktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IzYjI5ZmIzSmtaWEppZVY5bWIzSnRJRDBnSkNnbkxuZHZiMk52YlcxbGNtTmxMVzl5WkdWeWFXNW5KeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiM0prWlhKZmRtRnNJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KSGR2YjE5dmNtUmxjbUo1TG14bGJtZDBhRDR3S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCdmNtUmxjbDkyWVd3Z1BTQWtkMjl2WDI5eVpHVnlZbmt1ZG1Gc0tDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J2Y21SbGNsOTJZV3dnUFNCelpXeG1MbWRsZEZGMVpYSjVVR0Z5WVcxR2NtOXRWVkpNS0Z3aWIzSmtaWEppZVZ3aUxDQjNhVzVrYjNjdWJHOWpZWFJwYjI0dWFISmxaaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtHOXlaR1Z5WDNaaGJEMDlYQ0p0Wlc1MVgyOXlaR1Z5WENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHOXlaR1Z5WDNaaGJDQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ2h2Y21SbGNsOTJZV3doUFZ3aVhDSXBKaVlvSVNGdmNtUmxjbDkyWVd3cEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1WNGRISmhYM0YxWlhKNVgzQmhjbUZ0Y3k1aGJHd3ViM0prWlhKaWVTQTlJRzl5WkdWeVgzWmhiRHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjNiMjlmYjNKa1pYSmllVjltYjNKdExtOXVLQ2R6ZFdKdGFYUW5MQ0JtZFc1amRHbHZiaWhsS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbExuQnlaWFpsYm5SRVpXWmhkV3gwS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1poY2lCbWIzSnRJRDBnWlM1MFlYSm5aWFE3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkhkdmIxOXZjbVJsY21KNUxtOXVLRndpWTJoaGJtZGxYQ0lzSUdaMWJtTjBhVzl1S0dVcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVXVjSEpsZG1WdWRFUmxabUYxYkhRb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkbUZzSUQwZ0pDaDBhR2x6S1M1MllXd29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIWmhiRDA5WENKdFpXNTFYMjl5WkdWeVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZzSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtVjRkSEpoWDNGMVpYSjVYM0JoY21GdGN5NWhiR3d1YjNKa1pYSmllU0E5SUhaaGJEdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTUwY21sbloyVnlLRndpYzNWaWJXbDBYQ0lwWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlHWmhiSE5sTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuTmpjbTlzYkZKbGMzVnNkSE1nUFNCbWRXNWpkR2x2YmlncFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJWc1ppQTlJSFJvYVhNN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtDaHpaV3htTG5OamNtOXNiRjl2Ymw5aFkzUnBiMjQ5UFhObGJHWXVZV3BoZUY5aFkzUnBiMjRwZkh3b2MyVnNaaTV6WTNKdmJHeGZiMjVmWVdOMGFXOXVQVDFjSW1Gc2JGd2lLU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXpZM0p2Ykd4VWIxQnZjeWdwT3lBdkwzTmpjbTlzYkNCMGFHVWdkMmx1Wkc5M0lHbG1JR2wwSUdoaGN5QmlaV1Z1SUhObGRGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl6Wld4bUxtRnFZWGhmWVdOMGFXOXVJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1MWNHUmhkR1ZWY214SWFYTjBiM0o1SUQwZ1puVnVZM1JwYjI0b1lXcGhlRjl5WlhOMWJIUnpYM1Z5YkNsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6Wld4bUlEMGdkR2hwY3p0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIxYzJWZmFHbHpkRzl5ZVY5aGNHa2dQU0F3TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2QybHVaRzkzTG1ocGMzUnZjbmtnSmlZZ2QybHVaRzkzTG1ocGMzUnZjbmt1Y0hWemFGTjBZWFJsS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMWMyVmZhR2x6ZEc5eWVWOWhjR2tnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxMWMyVXRhR2x6ZEc5eWVTMWhjR2xjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ2h6Wld4bUxuVndaR0YwWlY5aGFtRjRYM1Z5YkQwOU1Ta21KaWgxYzJWZmFHbHpkRzl5ZVY5aGNHazlQVEVwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyNXZkeUJqYUdWamF5QnBaaUIwYUdVZ1luSnZkM05sY2lCemRYQndiM0owY3lCb2FYTjBiM0o1SUhOMFlYUmxJSEIxYzJnZ09pbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNoM2FXNWtiM2N1YUdsemRHOXllU0FtSmlCM2FXNWtiM2N1YUdsemRHOXllUzV3ZFhOb1UzUmhkR1VwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYUdsemRHOXllUzV3ZFhOb1UzUmhkR1VvYm5Wc2JDd2diblZzYkN3Z1lXcGhlRjl5WlhOMWJIUnpYM1Z5YkNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTV5WlcxdmRtVkJhbUY0VUdGbmFXNWhkR2x2YmlBOUlHWjFibU4wYVc5dUtDbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWh6Wld4bUxtRnFZWGhmYkdsdWEzTmZjMlZzWldOMGIzSXBJVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdGcVlYaGZiR2x1YTNOZmIySnFaV04wSUQwZ2FsRjFaWEo1S0hObGJHWXVZV3BoZUY5c2FXNXJjMTl6Wld4bFkzUnZjaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvSkdGcVlYaGZiR2x1YTNOZmIySnFaV04wTG14bGJtZDBhRDR3S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSaGFtRjRYMnhwYm10elgyOWlhbVZqZEM1dlptWW9LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVuWlhSQ1lYTmxWWEpzSUQwZ1puVnVZM1JwYjI0b0lIVnliQ0FwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5dWIzY2djMlZsSUdsbUlIZGxJR0Z5WlNCdmJpQjBhR1VnVlZKTUlIZGxJSFJvYVc1ckxpNHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIxY214ZmNHRnlkSE1nUFNCMWNtd3VjM0JzYVhRb1hDSS9YQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RYSnNYMkpoYzJVZ1BTQmNJbHdpTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kWEpzWDNCaGNuUnpMbXhsYm1kMGFENHdLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IxY214ZlltRnpaU0E5SUhWeWJGOXdZWEowYzFzd1hUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhWeWJGOWlZWE5sSUQwZ2RYSnNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCMWNteGZZbUZ6WlR0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWpZVzVHWlhSamFFRnFZWGhTWlhOMWJIUnpJRDBnWm5WdVkzUnBiMjRvWm1WMFkyaGZkSGx3WlNsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaG1aWFJqYUY5MGVYQmxLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdabGRHTm9YM1I1Y0dVZ1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjMlZzWmlBOUlIUm9hWE03WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbVpYUmphRjloYW1GNFgzSmxjM1ZzZEhNZ1BTQm1ZV3h6WlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWFYTmZZV3BoZUQwOU1TbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2V5OHZkR2hsYmlCM1pTQjNhV3hzSUdGcVlYZ2djM1ZpYldsMElIUm9aU0JtYjNKdFhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5aGJtUWdhV1lnZDJVZ1kyRnVJR1pwYm1RZ2RHaGxJSEpsYzNWc2RITWdZMjl1ZEdGcGJtVnlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxteGxibWQwYUQwOU1TbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITWdQU0IwY25WbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ5WlhOMWJIUnpYM1Z5YkNBOUlITmxiR1l1Y21WemRXeDBjMTkxY213N0lDQXZMMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlISmxjM1ZzZEhOZmRYSnNYMlZ1WTI5a1pXUWdQU0FuSnpzZ0lDOHZYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1kzVnljbVZ1ZEY5MWNtd2dQU0IzYVc1a2IzY3ViRzlqWVhScGIyNHVhSEpsWmp0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbmJtOXlaU0FqSUdGdVpDQmxkbVZ5ZVhSb2FXNW5JR0ZtZEdWeVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYUdGemFGOXdiM01nUFNCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFppNXBibVJsZUU5bUtDY2pKeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaG9ZWE5vWDNCdmN5RTlQUzB4S1h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JqZFhKeVpXNTBYM1Z5YkNBOUlIZHBibVJ2ZHk1c2IyTmhkR2x2Ymk1b2NtVm1Mbk4xWW5OMGNpZ3dMQ0IzYVc1a2IzY3ViRzlqWVhScGIyNHVhSEpsWmk1cGJtUmxlRTltS0Njakp5a3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0NBb0lDZ2djMlZzWmk1a2FYTndiR0Y1WDNKbGMzVnNkRjl0WlhSb2IyUTlQVndpWTNWemRHOXRYM2R2YjJOdmJXMWxjbU5sWDNOMGIzSmxYQ0lnS1NCOGZDQW9JSE5sYkdZdVpHbHpjR3hoZVY5eVpYTjFiSFJmYldWMGFHOWtQVDFjSW5CdmMzUmZkSGx3WlY5aGNtTm9hWFpsWENJZ0tTQXBJQ1ltSUNnZ2MyVnNaaTVsYm1GaWJHVmZkR0Y0YjI1dmJYbGZZWEpqYUdsMlpYTWdQVDBnTVNBcElDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdnYzJWc1ppNWpkWEp5Wlc1MFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1VZ0lUMDlYQ0pjSWlBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbVpYUmphRjloYW1GNFgzSmxjM1ZzZEhNZ1BTQjBjblZsTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnWm1WMFkyaGZZV3BoZUY5eVpYTjFiSFJ6TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHlwMllYSWdjbVZ6ZFd4MGMxOTFjbXdnUFNCd2NtOWpaWE56WDJadmNtMHVaMlYwVW1WemRXeDBjMVZ5YkNoelpXeG1MQ0J6Wld4bUxuSmxjM1ZzZEhOZmRYSnNLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdGamRHbDJaVjkwWVhnZ1BTQndjbTlqWlhOelgyWnZjbTB1WjJWMFFXTjBhWFpsVkdGNEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG1kbGRGVnliRkJoY21GdGN5aDBjblZsTENBbkp5d2dZV04wYVhabFgzUmhlQ2s3S2k5Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JseHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMjV2ZHlCelpXVWdhV1lnZDJVZ1lYSmxJRzl1SUhSb1pTQlZVa3dnZDJVZ2RHaHBibXN1TGk1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIxY214ZlltRnpaU0E5SUhSb2FYTXVaMlYwUW1GelpWVnliQ2dnWTNWeWNtVnVkRjkxY213Z0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZG1GeUlISmxjM1ZzZEhOZmRYSnNYMkpoYzJVZ1BTQjBhR2x6TG1kbGRFSmhjMlZWY213b0lHTjFjbkpsYm5SZmRYSnNJQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUd4aGJtY2dQU0J6Wld4bUxtZGxkRkYxWlhKNVVHRnlZVzFHY205dFZWSk1LRndpYkdGdVoxd2lMQ0IzYVc1a2IzY3ViRzlqWVhScGIyNHVhSEpsWmlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdvZEhsd1pXOW1LR3hoYm1jcElUMDlYQ0oxYm1SbFptbHVaV1JjSWlrbUppaHNZVzVuSVQwOWJuVnNiQ2twWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZFhKc1gySmhjMlVnUFNCelpXeG1MbUZrWkZWeWJGQmhjbUZ0S0hWeWJGOWlZWE5sTENCY0lteGhibWM5WENJcmJHRnVaeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITm1hV1FnUFNCelpXeG1MbWRsZEZGMVpYSjVVR0Z5WVcxR2NtOXRWVkpNS0Z3aWMyWnBaRndpTENCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFppazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXBaaUJ6Wm1sa0lHbHpJR0VnYm5WdFltVnlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloT2RXMWlaWElvY0dGeWMyVkdiRzloZENoelptbGtLU2tnUFQwZ2MyWnBaQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IxY214ZlltRnpaU0E5SUhObGJHWXVZV1JrVlhKc1VHRnlZVzBvZFhKc1gySmhjMlVzSUZ3aWMyWnBaRDFjSWl0elptbGtLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUlHRnVlU0J2WmlCMGFHVWdNeUJqYjI1a2FYUnBiMjV6SUdGeVpTQjBjblZsTENCMGFHVnVJR2wwY3lCbmIyOWtJSFJ2SUdkdlhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMeUF0SURFZ2ZDQnBaaUIwYUdVZ2RYSnNJR0poYzJVZ1BUMGdjbVZ6ZFd4MGMxOTFjbXhjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dklDMGdNaUI4SUdsbUlIVnliQ0JpWVhObEt5QmNJaTljSWlBZ1BUMGdjbVZ6ZFd4MGMxOTFjbXdnTFNCcGJpQmpZWE5sSUc5bUlIVnpaWElnWlhKeWIzSWdhVzRnZEdobElISmxjM1ZzZEhNZ1ZWSk1YSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2THlBdElETWdmQ0JwWmlCMGFHVWdjbVZ6ZFd4MGN5QlZVa3dnYUdGeklIVnliQ0J3WVhKaGJYTXNJR0Z1WkNCMGFHVWdZM1Z5Y21WdWRDQjFjbXdnYzNSaGNuUnpJSGRwZEdnZ2RHaGxJSEpsYzNWc2RITWdWVkpNSUZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZEhKcGJTQmhibmtnZEhKaGFXeHBibWNnYzJ4aGMyZ2dabTl5SUdWaGMybGxjaUJqYjIxd1lYSnBjMjl1T2x4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RYSnNYMkpoYzJVZ1BTQjFjbXhmWW1GelpTNXlaWEJzWVdObEtDOWNYQzhrTHl3Z0p5Y3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY21WemRXeDBjMTkxY213Z1BTQnlaWE4xYkhSelgzVnliQzV5WlhCc1lXTmxLQzljWEM4a0x5d2dKeWNwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NtVnpkV3gwYzE5MWNteGZaVzVqYjJSbFpDQTlJR1Z1WTI5a1pWVlNTU2h5WlhOMWJIUnpYM1Z5YkNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdZM1Z5Y21WdWRGOTFjbXhmWTI5dWRHRnBibk5mY21WemRXeDBjMTkxY213Z1BTQXRNVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDaDFjbXhmWW1GelpUMDljbVZ6ZFd4MGMxOTFjbXdwZkh3b2RYSnNYMkpoYzJVdWRHOU1iM2RsY2tOaGMyVW9LVDA5Y21WemRXeDBjMTkxY214ZlpXNWpiMlJsWkM1MGIweHZkMlZ5UTJGelpTZ3BLU0FnS1h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JqZFhKeVpXNTBYM1Z5YkY5amIyNTBZV2x1YzE5eVpYTjFiSFJ6WDNWeWJDQTlJREU3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUlHVnNjMlVnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNnZ2NtVnpkV3gwYzE5MWNtd3VhVzVrWlhoUFppZ2dKejhuSUNrZ0lUMDlJQzB4SUNZbUlHTjFjbkpsYm5SZmRYSnNMbXhoYzNSSmJtUmxlRTltS0hKbGMzVnNkSE5mZFhKc0xDQXdLU0E5UFQwZ01DQXBJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWTNWeWNtVnVkRjkxY214ZlkyOXVkR0ZwYm5OZmNtVnpkV3gwYzE5MWNtd2dQU0F4TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbTl1YkhsZmNtVnpkV3gwYzE5aGFtRjRQVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2V5OHZhV1lnWVNCMWMyVnlJR2hoY3lCamFHOXpaVzRnZEc4Z2IyNXNlU0JoYkd4dmR5QmhhbUY0SUc5dUlISmxjM1ZzZEhNZ2NHRm5aWE1nS0dSbFptRjFiSFFnWW1Wb1lYWnBiM1Z5S1Z4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2dZM1Z5Y21WdWRGOTFjbXhmWTI5dWRHRnBibk5mY21WemRXeDBjMTkxY213Z1BpQXRNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdMeTkwYUdseklHMWxZVzV6SUhSb1pTQmpkWEp5Wlc1MElGVlNUQ0JqYjI1MFlXbHVjeUIwYUdVZ2NtVnpkV3gwY3lCMWNtd3NJSGRvYVdOb0lHMWxZVzV6SUhkbElHTmhiaUJrYnlCaGFtRjRYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1psZEdOb1gyRnFZWGhmY21WemRXeDBjeUE5SUhSeWRXVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWmxkR05vWDJGcVlYaGZjbVZ6ZFd4MGN5QTlJR1poYkhObE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJWY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaG1aWFJqYUY5MGVYQmxQVDFjSW5CaFoybHVZWFJwYjI1Y0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ0JqZFhKeVpXNTBYM1Z5YkY5amIyNTBZV2x1YzE5eVpYTjFiSFJ6WDNWeWJDQStJQzB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN0x5OTBhR2x6SUcxbFlXNXpJSFJvWlNCamRYSnlaVzUwSUZWU1RDQmpiMjUwWVdsdWN5QjBhR1VnY21WemRXeDBjeUIxY213c0lIZG9hV05vSUcxbFlXNXpJSGRsSUdOaGJpQmtieUJoYW1GNFhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OWtiMjRuZENCaGFtRjRJSEJoWjJsdVlYUnBiMjRnZDJobGJpQnViM1FnYjI0Z1lTQlRKa1lnY0dGblpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWm1WMFkyaGZZV3BoZUY5eVpYTjFiSFJ6SUQwZ1ptRnNjMlU3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITTdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuTmxkSFZ3UVdwaGVGQmhaMmx1WVhScGIyNGdQU0JtZFc1amRHbHZiaWdwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwybHVabWx1YVhSbElITmpjbTlzYkZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGFHbHpMbkJoWjJsdVlYUnBiMjVmZEhsd1pUMDlQVndpYVc1bWFXNXBkR1ZmYzJOeWIyeHNYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnBibVpwYm1sMFpWOXpZM0p2Ykd4ZlpXNWtJRDBnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxtWnBibVFvWENKYlpHRjBZUzF6WldGeVkyZ3RabWxzZEdWeUxXRmpkR2x2YmowbmFXNW1hVzVwZEdVdGMyTnliMnhzTFdWdVpDZGRYQ0lwTG14bGJtZDBhRDR3S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsdVptbHVhWFJsWDNOamNtOXNiRjlsYm1RZ1BTQjBjblZsTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFYTmZiV0Y0WDNCaFoyVmtJRDBnZEhKMVpUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh3WVhKelpVbHVkQ2gwYUdsekxtbHVjM1JoYm1ObFgyNTFiV0psY2lrOVBUMHhLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQ2gzYVc1a2IzY3BMbTltWmloY0luTmpjbTlzYkZ3aUxDQnpaV3htTG05dVYybHVaRzkzVTJOeWIyeHNLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tITmxiR1l1WTJGdVJtVjBZMmhCYW1GNFVtVnpkV3gwY3loY0luQmhaMmx1WVhScGIyNWNJaWtwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pDaDNhVzVrYjNjcExtOXVLRndpYzJOeWIyeHNYQ0lzSUhObGJHWXViMjVYYVc1a2IzZFRZM0p2Ykd3cE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJR2xtS0hSNWNHVnZaaWh6Wld4bUxtRnFZWGhmYkdsdWEzTmZjMlZzWldOMGIzSXBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa0tHUnZZM1Z0Wlc1MEtTNXZabVlvSjJOc2FXTnJKeXdnYzJWc1ppNWhhbUY0WDJ4cGJtdHpYM05sYkdWamRHOXlLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb1pHOWpkVzFsYm5RcExtOW1aaWh6Wld4bUxtRnFZWGhmYkdsdWEzTmZjMlZzWldOMGIzSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkNoelpXeG1MbUZxWVhoZmJHbHVhM05mYzJWc1pXTjBiM0lwTG05bVppZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUW9aRzlqZFcxbGJuUXBMbTl1S0NkamJHbGpheWNzSUhObGJHWXVZV3BoZUY5c2FXNXJjMTl6Wld4bFkzUnZjaXdnWm5WdVkzUnBiMjRvWlNsN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdVkyRnVSbVYwWTJoQmFtRjRVbVZ6ZFd4MGN5aGNJbkJoWjJsdVlYUnBiMjVjSWlrcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbExuQnlaWFpsYm5SRVpXWmhkV3gwS0NrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2JHbHVheUE5SUdwUmRXVnllU2gwYUdsektTNWhkSFJ5S0Nkb2NtVm1KeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZV3BoZUY5aFkzUnBiMjRnUFNCY0luQmhaMmx1WVhScGIyNWNJanRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ3WVdkbFRuVnRZbVZ5SUQwZ2MyVnNaaTVuWlhSUVlXZGxaRVp5YjIxVlVrd29iR2x1YXlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxpUmhhbUY0WDNKbGMzVnNkSE5mWTI5dWRHRnBibVZ5TG1GMGRISW9YQ0prWVhSaExYQmhaMlZrWENJc0lIQmhaMlZPZFcxaVpYSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVtWlhSamFFRnFZWGhTWlhOMWJIUnpLQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z1ptRnNjMlU3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQjlPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1kbGRGQmhaMlZrUm5KdmJWVlNUQ0E5SUdaMWJtTjBhVzl1S0ZWU1RDbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NHRm5aV1JXWVd3Z1BTQXhPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMlpwY25OMElIUmxjM1FnZEc4Z2MyVmxJR2xtSUhkbElHaGhkbVVnWENJdmNHRm5aUzgwTDF3aUlHbHVJSFJvWlNCVlVreGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJ3Vm1Gc0lEMGdjMlZzWmk1blpYUlJkV1Z5ZVZCaGNtRnRSbkp2YlZWU1RDaGNJbk5tWDNCaFoyVmtYQ0lzSUZWU1RDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ2gwZVhCbGIyWW9kSEJXWVd3cFBUMWNJbk4wY21sdVoxd2lLWHg4S0hSNWNHVnZaaWgwY0ZaaGJDazlQVndpYm5WdFltVnlYQ0lwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCd1lXZGxaRlpoYkNBOUlIUndWbUZzTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnY0dGblpXUldZV3c3WEhKY2JpQWdJQ0FnSUNBZ2ZUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVuWlhSUmRXVnllVkJoY21GdFJuSnZiVlZTVENBOUlHWjFibU4wYVc5dUtHNWhiV1VzSUZWU1RDbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NYTjBjbWx1WnlBOUlGd2lQMXdpSzFWU1RDNXpjR3hwZENnblB5Y3BXekZkTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvY1hOMGNtbHVaeWtoUFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMllXd2dQU0JrWldOdlpHVlZVa2xEYjIxd2IyNWxiblFvS0c1bGR5QlNaV2RGZUhBb0oxcy9mQ1pkSnlBcklHNWhiV1VnS3lBblBTY2dLeUFuS0Z0ZUpqdGRLejhwS0NaOEkzdzdmQ1FwSnlrdVpYaGxZeWh4YzNSeWFXNW5LWHg4V3l4Y0lsd2lYU2xiTVYwdWNtVndiR0ZqWlNndlhGd3JMMmNzSUNjbE1qQW5LU2w4Zkc1MWJHdzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdkbUZzTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIMDdYSEpjYmx4eVhHNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVtYjNKdFZYQmtZWFJsWkNBOUlHWjFibU4wYVc5dUtHVXBlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5bExuQnlaWFpsYm5SRVpXWmhkV3gwS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1WVhWMGIxOTFjR1JoZEdVOVBURXBJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjM1ZpYldsMFJtOXliU2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWW9LSE5sYkdZdVlYVjBiMTkxY0dSaGRHVTlQVEFwSmlZb2MyVnNaaTVoZFhSdlgyTnZkVzUwWDNKbFpuSmxjMmhmYlc5a1pUMDlNU2twWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVabTl5YlZWd1pHRjBaV1JHWlhSamFFRnFZWGdvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUdaaGJITmxPMXh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVabTl5YlZWd1pHRjBaV1JHWlhSamFFRnFZWGdnUFNCbWRXNWpkR2x2YmlncGUxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTlzYjI5d0lIUm9jbTkxWjJnZ1lXeHNJSFJvWlNCbWFXVnNaSE1nWVc1a0lHSjFhV3hrSUhSb1pTQlZVa3hjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1bVpYUmphRUZxWVhoR2IzSnRLQ2s3WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlHWmhiSE5sTzF4eVhHNGdJQ0FnSUNBZ0lIMDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDOHZiV0ZyWlNCaGJua2dZMjl5Y21WamRHbHZibk12ZFhCa1lYUmxjeUIwYnlCbWFXVnNaSE1nWW1WbWIzSmxJSFJvWlNCemRXSnRhWFFnWTI5dGNHeGxkR1Z6WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTV6WlhSR2FXVnNaSE1nUFNCbWRXNWpkR2x2YmlobEtYdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2YVdZb2MyVnNaaTVwYzE5aGFtRjRQVDB3S1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5emIyMWxkR2x0WlhNZ2RHaGxJR1p2Y20wZ2FYTWdjM1ZpYldsMGRHVmtJSGRwZEdodmRYUWdkR2hsSUhOc2FXUmxjaUI1WlhRZ2FHRjJhVzVuSUhWd1pHRjBaV1FzSUdGdVpDQmhjeUIzWlNCblpYUWdiM1Z5SUhaaGJIVmxjeUJtY205dFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1JvWlNCemJHbGtaWElnWVc1a0lHNXZkQ0JwYm5CMWRITXNJSGRsSUc1bFpXUWdkRzhnWTJobFkyc2dhWFFnYVdZZ2JtVmxaSE1nZEc4Z1ltVWdjMlYwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyOXViSGtnYjJOamRYSnpJR2xtSUdGcVlYZ2dhWE1nYjJabUxDQmhibVFnWVhWMGIzTjFZbTFwZENCdmJseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk0a1ptbGxiR1J6TG1WaFkyZ29ablZ1WTNScGIyNG9LU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtabWxsYkdRZ1BTQWtLSFJvYVhNcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnY21GdVoyVmZaR2x6Y0d4aGVWOTJZV3gxWlhNZ1BTQWtabWxsYkdRdVptbHVaQ2duTG5ObUxXMWxkR0V0Y21GdVoyVXRjMnhwWkdWeUp5a3VZWFIwY2loY0ltUmhkR0V0WkdsemNHeGhlUzEyWVd4MVpYTXRZWE5jSWlrN0x5OWtZWFJoTFdScGMzQnNZWGt0ZG1Gc2RXVnpMV0Z6UFZ3aWRHVjRkRndpWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtISmhibWRsWDJScGMzQnNZWGxmZG1Gc2RXVnpQVDA5WENKMFpYaDBhVzV3ZFhSY0lpa2dlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KR1pwWld4a0xtWnBibVFvWENJdWJXVjBZUzF6Ykdsa1pYSmNJaWt1YkdWdVozUm9QakFwZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWm1sbGJHUXVabWx1WkNoY0lpNXRaWFJoTFhOc2FXUmxjbHdpS1M1bFlXTm9LR1oxYm1OMGFXOXVJQ2hwYm1SbGVDa2dlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCemJHbGtaWEpmYjJKcVpXTjBJRDBnSkNoMGFHbHpLVnN3WFR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2MyeHBaR1Z5WDJWc0lEMGdKQ2gwYUdsektTNWpiRzl6WlhOMEtGd2lMbk5tTFcxbGRHRXRjbUZ1WjJVdGMyeHBaR1Z5WENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5MllYSWdiV2x1Vm1Gc0lEMGdKSE5zYVdSbGNsOWxiQzVoZEhSeUtGd2laR0YwWVMxdGFXNWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1poY2lCdFlYaFdZV3dnUFNBa2MyeHBaR1Z5WDJWc0xtRjBkSElvWENKa1lYUmhMVzFoZUZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnRhVzVXWVd3Z1BTQWtjMnhwWkdWeVgyVnNMbVpwYm1Rb1hDSXVjMll0Y21GdVoyVXRiV2x1WENJcExuWmhiQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUcxaGVGWmhiQ0E5SUNSemJHbGtaWEpmWld3dVptbHVaQ2hjSWk1elppMXlZVzVuWlMxdFlYaGNJaWt1ZG1Gc0tDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCemJHbGtaWEpmYjJKcVpXTjBMbTV2VldsVGJHbGtaWEl1YzJWMEtGdHRhVzVXWVd3c0lHMWhlRlpoYkYwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDOHZjM1ZpYldsMFhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1emRXSnRhWFJHYjNKdElEMGdablZ1WTNScGIyNG9aU2w3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyeHZiM0FnZEdoeWIzVm5hQ0JoYkd3Z2RHaGxJR1pwWld4a2N5QmhibVFnWW5WcGJHUWdkR2hsSUZWU1RGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selUzVmliV2wwZEdsdVp5QTlQU0IwY25WbEtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdabUZzYzJVN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YzJWMFJtbGxiR1J6S0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVZMnhsWVhKVWFXMWxjaWdwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYzFOMVltMXBkSFJwYm1jZ1BTQjBjblZsTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NISnZZMlZ6YzE5bWIzSnRMbk5sZEZSaGVFRnlZMmhwZG1WU1pYTjFiSFJ6VlhKc0tITmxiR1lzSUhObGJHWXVjbVZ6ZFd4MGMxOTFjbXdwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF3WVdkbFpGd2lMQ0F4S1RzZ0x5OXBibWwwSUhCaFoyVmtYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbU5oYmtabGRHTm9RV3BoZUZKbGMzVnNkSE1vS1NsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZXk4dmRHaGxiaUIzWlNCM2FXeHNJR0ZxWVhnZ2MzVmliV2wwSUhSb1pTQm1iM0p0WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aGFtRjRYMkZqZEdsdmJpQTlJRndpYzNWaWJXbDBYQ0k3SUM4dmMyOGdkMlVnYTI1dmR5QnBkQ0IzWVhOdUozUWdjR0ZuYVc1aGRHbHZibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNW1aWFJqYUVGcVlYaFNaWE4xYkhSektDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdMeTkwYUdWdUlIZGxJSGRwYkd3Z2MybHRjR3g1SUhKbFpHbHlaV04wSUhSdklIUm9aU0JTWlhOMWJIUnpJRlZTVEZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeVpYTjFiSFJ6WDNWeWJDQTlJSEJ5YjJObGMzTmZabTl5YlM1blpYUlNaWE4xYkhSelZYSnNLSE5sYkdZc0lITmxiR1l1Y21WemRXeDBjMTkxY213cE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdVoyVjBWWEpzVUdGeVlXMXpLSFJ5ZFdVc0lDY25LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhKbGMzVnNkSE5mZFhKc0lEMGdjMlZzWmk1aFpHUlZjbXhRWVhKaGJTaHlaWE4xYkhSelgzVnliQ3dnY1hWbGNubGZjR0Z5WVcxektUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFppQTlJSEpsYzNWc2RITmZkWEpzTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5KbGMyVjBSbTl5YlNBOUlHWjFibU4wYVc5dUtITjFZbTFwZEY5bWIzSnRLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5MWJuTmxkQ0JoYkd3Z1ptbGxiR1J6WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdUpHWnBaV3hrY3k1bFlXTm9LR1oxYm1OMGFXOXVLQ2w3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSbWFXVnNaQ0E5SUNRb2RHaHBjeWs3WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBKR1pwWld4a0xuSmxiVzkyWlVGMGRISW9YQ0prWVhSaExYTm1MWFJoZUc5dWIyMTVMV0Z5WTJocGRtVmNJaWs3WEhKY2JseDBYSFJjZEZ4MFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM04wWVc1a1lYSmtJR1pwWld4a0lIUjVjR1Z6WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1ptbGxiR1F1Wm1sdVpDaGNJbk5sYkdWamREcHViM1FvVzIxMWJIUnBjR3hsUFNkdGRXeDBhWEJzWlNkZEtTQStJRzl3ZEdsdmJqcG1hWEp6ZEMxamFHbHNaRndpS1M1d2NtOXdLRndpYzJWc1pXTjBaV1JjSWl3Z2RISjFaU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1ptbGxiR1F1Wm1sdVpDaGNJbk5sYkdWamRGdHRkV3gwYVhCc1pUMG5iWFZzZEdsd2JHVW5YU0ErSUc5d2RHbHZibHdpS1M1d2NtOXdLRndpYzJWc1pXTjBaV1JjSWl3Z1ptRnNjMlVwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHWnBaV3hrTG1acGJtUW9YQ0pwYm5CMWRGdDBlWEJsUFNkamFHVmphMkp2ZUNkZFhDSXBMbkJ5YjNBb1hDSmphR1ZqYTJWa1hDSXNJR1poYkhObEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JtYVdWc1pDNW1hVzVrS0Z3aVBpQjFiQ0ErSUd4cE9tWnBjbk4wTFdOb2FXeGtJR2x1Y0hWMFczUjVjR1U5SjNKaFpHbHZKMTFjSWlrdWNISnZjQ2hjSW1Ob1pXTnJaV1JjSWl3Z2RISjFaU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1ptbGxiR1F1Wm1sdVpDaGNJbWx1Y0hWMFczUjVjR1U5SjNSbGVIUW5YVndpS1M1MllXd29YQ0pjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRdVptbHVaQ2hjSWk1elppMXZjSFJwYjI0dFlXTjBhWFpsWENJcExuSmxiVzkyWlVOc1lYTnpLRndpYzJZdGIzQjBhVzl1TFdGamRHbDJaVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUm1hV1ZzWkM1bWFXNWtLRndpUGlCMWJDQStJR3hwT21acGNuTjBMV05vYVd4a0lHbHVjSFYwVzNSNWNHVTlKM0poWkdsdkoxMWNJaWt1Y0dGeVpXNTBLQ2t1WVdSa1EyeGhjM01vWENKelppMXZjSFJwYjI0dFlXTjBhWFpsWENJcE95QXZMM0psSUdGa1pDQmhZM1JwZG1VZ1kyeGhjM01nZEc4Z1ptbHljM1FnWENKa1pXWmhkV3gwWENJZ2IzQjBhVzl1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl1ZFcxaVpYSWdjbUZ1WjJVZ0xTQXlJRzUxYldKbGNpQnBibkIxZENCbWFXVnNaSE5jY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbWFXVnNaQzVtYVc1a0tGd2lhVzV3ZFhSYmRIbHdaVDBuYm5WdFltVnlKMTFjSWlrdVpXRmphQ2htZFc1amRHbHZiaWhwYm1SbGVDbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2RHaHBjMGx1Y0hWMElEMGdKQ2gwYUdsektUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvSkhSb2FYTkpibkIxZEM1d1lYSmxiblFvS1M1d1lYSmxiblFvS1M1b1lYTkRiR0Z6Y3loY0luTm1MVzFsZEdFdGNtRnVaMlZjSWlrcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtHbHVaR1Y0UFQwd0tTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjMGx1Y0hWMExuWmhiQ2drZEdocGMwbHVjSFYwTG1GMGRISW9YQ0p0YVc1Y0lpa3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYVc1a1pYZzlQVEVwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdselNXNXdkWFF1ZG1Gc0tDUjBhR2x6U1c1d2RYUXVZWFIwY2loY0ltMWhlRndpS1NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5dFpYUmhJQzhnYm5WdFltVnljeUIzYVhSb0lESWdhVzV3ZFhSeklDaG1jbTl0SUM4Z2RHOGdabWxsYkdSektTQXRJSE5sWTI5dVpDQnBibkIxZENCdGRYTjBJR0psSUhKbGMyVjBJSFJ2SUcxaGVDQjJZV3gxWlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1J0WlhSaFgzTmxiR1ZqZEY5bWNtOXRYM1J2SUQwZ0pHWnBaV3hrTG1acGJtUW9YQ0l1YzJZdGJXVjBZUzF5WVc1blpTMXpaV3hsWTNRdFpuSnZiWFJ2WENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDUnRaWFJoWDNObGJHVmpkRjltY205dFgzUnZMbXhsYm1kMGFENHdLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnpkR0Z5ZEY5dGFXNGdQU0FrYldWMFlWOXpaV3hsWTNSZlpuSnZiVjkwYnk1aGRIUnlLRndpWkdGMFlTMXRhVzVjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITjBZWEowWDIxaGVDQTlJQ1J0WlhSaFgzTmxiR1ZqZEY5bWNtOXRYM1J2TG1GMGRISW9YQ0prWVhSaExXMWhlRndpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHMWxkR0ZmYzJWc1pXTjBYMlp5YjIxZmRHOHVabWx1WkNoY0luTmxiR1ZqZEZ3aUtTNWxZV05vS0daMWJtTjBhVzl1S0dsdVpHVjRLWHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrZEdocGMwbHVjSFYwSUQwZ0pDaDBhR2x6S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dsdVpHVjRQVDB3S1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUm9hWE5KYm5CMWRDNTJZV3dvYzNSaGNuUmZiV2x1S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtHbHVaR1Y0UFQweEtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjMGx1Y0hWMExuWmhiQ2h6ZEdGeWRGOXRZWGdwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2JXVjBZVjl5WVdScGIxOW1jbTl0WDNSdklEMGdKR1pwWld4a0xtWnBibVFvWENJdWMyWXRiV1YwWVMxeVlXNW5aUzF5WVdScGJ5MW1jbTl0ZEc5Y0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KRzFsZEdGZmNtRmthVzlmWm5KdmJWOTBieTVzWlc1bmRHZytNQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MzUmhjblJmYldsdUlEMGdKRzFsZEdGZmNtRmthVzlmWm5KdmJWOTBieTVoZEhSeUtGd2laR0YwWVMxdGFXNWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOMFlYSjBYMjFoZUNBOUlDUnRaWFJoWDNKaFpHbHZYMlp5YjIxZmRHOHVZWFIwY2loY0ltUmhkR0V0YldGNFhDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pISmhaR2x2WDJkeWIzVndjeUE5SUNSdFpYUmhYM0poWkdsdlgyWnliMjFmZEc4dVptbHVaQ2duTG5ObUxXbHVjSFYwTFhKaGJtZGxMWEpoWkdsdkp5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1J5WVdScGIxOW5jbTkxY0hNdVpXRmphQ2htZFc1amRHbHZiaWhwYm1SbGVDbDdYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSeVlXUnBiM01nUFNBa0tIUm9hWE1wTG1acGJtUW9YQ0l1YzJZdGFXNXdkWFF0Y21Ga2FXOWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSeVlXUnBiM011Y0hKdmNDaGNJbU5vWldOclpXUmNJaXdnWm1Gc2MyVXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9hVzVrWlhnOVBUQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUnlZV1JwYjNNdVptbHNkR1Z5S0NkYmRtRnNkV1U5WENJbkszTjBZWEowWDIxcGJpc25YQ0pkSnlrdWNISnZjQ2hjSW1Ob1pXTnJaV1JjSWl3Z2RISjFaU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0JwWmlocGJtUmxlRDA5TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhKaFpHbHZjeTVtYVd4MFpYSW9KMXQyWVd4MVpUMWNJaWNyYzNSaGNuUmZiV0Y0S3lkY0lsMG5LUzV3Y205d0tGd2lZMmhsWTJ0bFpGd2lMQ0IwY25WbEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl1ZFcxaVpYSWdjMnhwWkdWeUlDMGdibTlWYVZOc2FXUmxjbHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdacFpXeGtMbVpwYm1Rb1hDSXViV1YwWVMxemJHbGtaWEpjSWlrdVpXRmphQ2htZFc1amRHbHZiaWhwYm1SbGVDbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCemJHbGtaWEpmYjJKcVpXTjBJRDBnSkNoMGFHbHpLVnN3WFR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2S25aaGNpQnpiR2xrWlhKZmIySnFaV04wSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aUxtMWxkR0V0YzJ4cFpHVnlYQ0lwV3pCZE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjMnhwWkdWeVgzWmhiQ0E5SUhOc2FXUmxjbDl2WW1wbFkzUXVibTlWYVZOc2FXUmxjaTVuWlhRb0tUc3FMMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pITnNhV1JsY2w5bGJDQTlJQ1FvZEdocGN5a3VZMnh2YzJWemRDaGNJaTV6WmkxdFpYUmhMWEpoYm1kbExYTnNhV1JsY2x3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiV2x1Vm1Gc0lEMGdKSE5zYVdSbGNsOWxiQzVoZEhSeUtGd2laR0YwWVMxdGFXNWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUcxaGVGWmhiQ0E5SUNSemJHbGtaWEpmWld3dVlYUjBjaWhjSW1SaGRHRXRiV0Y0WENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhOc2FXUmxjbDl2WW1wbFkzUXVibTlWYVZOc2FXUmxjaTV6WlhRb1cyMXBibFpoYkN3Z2JXRjRWbUZzWFNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5dVpXVmtJSFJ2SUhObFpTQnBaaUJoYm5rZ1lYSmxJR052YldKdlltOTRJR0Z1WkNCaFkzUWdZV05qYjNKa2FXNW5iSGxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtZMjl0WW05aWIzZ2dQU0FrWm1sbGJHUXVabWx1WkNoY0luTmxiR1ZqZEZ0a1lYUmhMV052YldKdlltOTRQU2N4SjExY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlna1kyOXRZbTlpYjNndWJHVnVaM1JvUGpBcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLSFI1Y0dWdlppQWtZMjl0WW05aWIzZ3VZMmh2YzJWdUlDRTlJRndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1kyOXRZbTlpYjNndWRISnBaMmRsY2loY0ltTm9iM05sYmpwMWNHUmhkR1ZrWENJcE95QXZMMlp2Y2lCamFHOXpaVzRnYjI1c2VWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1kyOXRZbTlpYjNndWRtRnNLQ2NuS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHTnZiV0p2WW05NExuUnlhV2RuWlhJb0oyTm9ZVzVuWlM1elpXeGxZM1F5SnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbU5zWldGeVZHbHRaWElvS1R0Y2NseHVYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jM1ZpYldsMFgyWnZjbTA5UFZ3aVlXeDNZWGx6WENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YzNWaWJXbDBSbTl5YlNncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYzNWaWJXbDBYMlp2Y20wOVBWd2libVYyWlhKY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvZEdocGN5NWhkWFJ2WDJOdmRXNTBYM0psWm5KbGMyaGZiVzlrWlQwOU1TbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1admNtMVZjR1JoZEdWa1JtVjBZMmhCYW1GNEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdaV3h6WlNCcFppaHpkV0p0YVhSZlptOXliVDA5WENKaGRYUnZYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIUm9hWE11WVhWMGIxOTFjR1JoZEdVOVBYUnlkV1VwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXpkV0p0YVhSR2IzSnRLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RHaHBjeTVoZFhSdlgyTnZkVzUwWDNKbFpuSmxjMmhmYlc5a1pUMDlNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVptOXliVlZ3WkdGMFpXUkdaWFJqYUVGcVlYZ29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1cGJtbDBLQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFpoY2lCbGRtVnVkRjlrWVhSaElEMGdlMzA3WEhKY2JpQWdJQ0FnSUNBZ1pYWmxiblJmWkdGMFlTNXpabWxrSUQwZ2MyVnNaaTV6Wm1sa08xeHlYRzRnSUNBZ0lDQWdJR1YyWlc1MFgyUmhkR0V1ZEdGeVoyVjBVMlZzWldOMGIzSWdQU0J6Wld4bUxtRnFZWGhmZEdGeVoyVjBYMkYwZEhJN1hISmNiaUFnSUNBZ0lDQWdaWFpsYm5SZlpHRjBZUzV2WW1wbFkzUWdQU0IwYUdsek8xeHlYRzRnSUNBZ0lDQWdJR2xtS0c5d2RITXVhWE5KYm1sMEtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1MGNtbG5aMlZ5UlhabGJuUW9YQ0p6WmpwcGJtbDBYQ0lzSUdWMlpXNTBYMlJoZEdFcE8xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNCOUtUdGNjbHh1ZlR0Y2NseHVJbDE5IiwiKGZ1bmN0aW9uIChnbG9iYWwpe1xuXHJcbnZhciAkID0gKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKTtcclxuXHJcbm1vZHVsZS5leHBvcnRzID0ge1xyXG5cclxuXHR0YXhvbm9teV9hcmNoaXZlczogMCxcclxuICAgIHVybF9wYXJhbXM6IHt9LFxyXG4gICAgdGF4X2FyY2hpdmVfcmVzdWx0c191cmw6IFwiXCIsXHJcbiAgICBhY3RpdmVfdGF4OiBcIlwiLFxyXG4gICAgZmllbGRzOiB7fSxcclxuXHRpbml0OiBmdW5jdGlvbih0YXhvbm9teV9hcmNoaXZlcywgY3VycmVudF90YXhvbm9teV9hcmNoaXZlKXtcclxuXHJcbiAgICAgICAgdGhpcy50YXhvbm9teV9hcmNoaXZlcyA9IDA7XHJcbiAgICAgICAgdGhpcy51cmxfcGFyYW1zID0ge307XHJcbiAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5hY3RpdmVfdGF4ID0gXCJcIjtcclxuXHJcblx0XHQvL3RoaXMuJGZpZWxkcyA9ICRmaWVsZHM7XHJcbiAgICAgICAgdGhpcy50YXhvbm9teV9hcmNoaXZlcyA9IHRheG9ub215X2FyY2hpdmVzO1xyXG4gICAgICAgIHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlID0gY3VycmVudF90YXhvbm9teV9hcmNoaXZlO1xyXG5cclxuXHRcdHRoaXMuY2xlYXJVcmxDb21wb25lbnRzKCk7XHJcblxyXG5cdH0sXHJcbiAgICBzZXRUYXhBcmNoaXZlUmVzdWx0c1VybDogZnVuY3Rpb24oJGZvcm0sIGN1cnJlbnRfcmVzdWx0c191cmwsIGdldF9hY3RpdmUpIHtcclxuXHJcbiAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0dGhpcy5jbGVhclRheEFyY2hpdmVSZXN1bHRzVXJsKCk7XHJcbiAgICAgICAgLy92YXIgY3VycmVudF9yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgaWYodGhpcy50YXhvbm9teV9hcmNoaXZlcyE9MSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZihnZXRfYWN0aXZlKT09XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0dmFyIGdldF9hY3RpdmUgPSBmYWxzZTtcclxuXHRcdH1cclxuXHJcbiAgICAgICAgLy9jaGVjayB0byBzZWUgaWYgd2UgaGF2ZSBhbnkgdGF4b25vbWllcyBzZWxlY3RlZFxyXG4gICAgICAgIC8vaWYgc28sIGNoZWNrIHRoZWlyIHJld3JpdGVzIGFuZCB1c2UgdGhvc2UgYXMgdGhlIHJlc3VsdHMgdXJsXHJcbiAgICAgICAgdmFyICRmaWVsZCA9IGZhbHNlO1xyXG4gICAgICAgIHZhciBmaWVsZF9uYW1lID0gXCJcIjtcclxuICAgICAgICB2YXIgZmllbGRfdmFsdWUgPSBcIlwiO1xyXG5cclxuICAgICAgICB2YXIgJGFjdGl2ZV90YXhvbm9teSA9ICRmb3JtLiRmaWVsZHMucGFyZW50KCkuZmluZChcIltkYXRhLXNmLXRheG9ub215LWFyY2hpdmU9JzEnXVwiKTtcclxuICAgICAgICBpZigkYWN0aXZlX3RheG9ub215Lmxlbmd0aD09MSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgICRmaWVsZCA9ICRhY3RpdmVfdGF4b25vbXk7XHJcblxyXG4gICAgICAgICAgICB2YXIgZmllbGRUeXBlID0gJGZpZWxkLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblxyXG4gICAgICAgICAgICBpZiAoKGZpZWxkVHlwZSA9PSBcInRhZ1wiKSB8fCAoZmllbGRUeXBlID09IFwiY2F0ZWdvcnlcIikgfHwgKGZpZWxkVHlwZSA9PSBcInRheG9ub215XCIpKSB7XHJcbiAgICAgICAgICAgICAgICB2YXIgdGF4b25vbXlfdmFsdWUgPSBzZWxmLnByb2Nlc3NUYXhvbm9teSgkZmllbGQsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgZmllbGRfbmFtZSA9ICRmaWVsZC5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHRheG9ub215X25hbWUgPSBmaWVsZF9uYW1lLnJlcGxhY2UoXCJfc2Z0X1wiLCBcIlwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZiAodGF4b25vbXlfdmFsdWUpIHtcclxuICAgICAgICAgICAgICAgICAgICBmaWVsZF92YWx1ZSA9IHRheG9ub215X3ZhbHVlLnZhbHVlO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihmaWVsZF92YWx1ZT09XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkID0gZmFsc2U7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKChzZWxmLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSE9XCJcIikmJihzZWxmLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSE9dGF4b25vbXlfbmFtZSkpXHJcbiAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IGN1cnJlbnRfcmVzdWx0c191cmw7XHJcbiAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKCgoZmllbGRfdmFsdWU9PVwiXCIpfHwoISRmaWVsZCkgKSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgICRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbiAoKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYgKCEkZmllbGQpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkVHlwZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKChmaWVsZFR5cGUgPT0gXCJ0YWdcIikgfHwgKGZpZWxkVHlwZSA9PSBcImNhdGVnb3J5XCIpIHx8IChmaWVsZFR5cGUgPT0gXCJ0YXhvbm9teVwiKSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdGF4b25vbXlfdmFsdWUgPSBzZWxmLnByb2Nlc3NUYXhvbm9teSgkKHRoaXMpLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZmllbGRfbmFtZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmICh0YXhvbm9teV92YWx1ZSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpZWxkX3ZhbHVlID0gdGF4b25vbXlfdmFsdWUudmFsdWU7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGZpZWxkX3ZhbHVlICE9IFwiXCIpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGZpZWxkID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYoICgkZmllbGQpICYmIChmaWVsZF92YWx1ZSAhPSBcIlwiICkpIHtcclxuICAgICAgICAgICAgLy9pZiB3ZSBmb3VuZCBhIGZpZWxkXHJcblx0XHRcdHZhciByZXdyaXRlX2F0dHIgPSAoJGZpZWxkLmF0dHIoXCJkYXRhLXNmLXRlcm0tcmV3cml0ZVwiKSk7XHJcblxyXG4gICAgICAgICAgICBpZihyZXdyaXRlX2F0dHIhPVwiXCIpIHtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgcmV3cml0ZSA9IEpTT04ucGFyc2UocmV3cml0ZV9hdHRyKTtcclxuICAgICAgICAgICAgICAgIHZhciBpbnB1dF90eXBlID0gJGZpZWxkLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFjdGl2ZV90YXggPSBmaWVsZF9uYW1lO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vZmluZCB0aGUgYWN0aXZlIGVsZW1lbnRcclxuICAgICAgICAgICAgICAgIGlmICgoaW5wdXRfdHlwZSA9PSBcInJhZGlvXCIpIHx8IChpbnB1dF90eXBlID09IFwiY2hlY2tib3hcIikpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy92YXIgJGFjdGl2ZSA9ICRmaWVsZC5maW5kKFwiLnNmLW9wdGlvbi1hY3RpdmVcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9leHBsb2RlIHRoZSB2YWx1ZXMgaWYgdGhlcmUgaXMgYSBkZWxpbVxyXG4gICAgICAgICAgICAgICAgICAgIC8vZmllbGRfdmFsdWVcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGlzX3NpbmdsZV92YWx1ZSA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX3ZhbHVlcyA9IGZpZWxkX3ZhbHVlLnNwbGl0KFwiLFwiKS5qb2luKFwiK1wiKS5zcGxpdChcIitcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGZpZWxkX3ZhbHVlcy5sZW5ndGggPiAxKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlzX3NpbmdsZV92YWx1ZSA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGlzX3NpbmdsZV92YWx1ZSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRpbnB1dCA9ICRmaWVsZC5maW5kKFwiaW5wdXRbdmFsdWU9J1wiICsgZmllbGRfdmFsdWUgKyBcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGFjdGl2ZSA9ICRpbnB1dC5wYXJlbnQoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRlcHRoID0gJGFjdGl2ZS5hdHRyKFwiZGF0YS1zZi1kZXB0aFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vbm93IGxvb3AgdGhyb3VnaCBwYXJlbnRzIHRvIGdyYWIgdGhlaXIgbmFtZXNcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHZhbHVlcyA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaChmaWVsZF92YWx1ZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBmb3IgKHZhciBpID0gZGVwdGg7IGkgPiAwOyBpLS0pIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRhY3RpdmUgPSAkYWN0aXZlLnBhcmVudCgpLnBhcmVudCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goJGFjdGl2ZS5maW5kKFwiaW5wdXRcIikudmFsKCkpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucmV2ZXJzZSgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9ncmFiIHRoZSByZXdyaXRlIGZvciB0aGlzIGRlcHRoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBhY3RpdmVfcmV3cml0ZSA9IHJld3JpdGVbZGVwdGhdO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdXJsID0gYWN0aXZlX3Jld3JpdGU7XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy90aGVuIG1hcCBmcm9tIHRoZSBwYXJlbnRzIHRvIHRoZSBkZXB0aFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKHZhbHVlcykuZWFjaChmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsID0gdXJsLnJlcGxhY2UoXCJbXCIgKyBpbmRleCArIFwiXVwiLCB2YWx1ZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IHVybDtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2lmIHRoZXJlIGFyZSBtdWx0aXBsZSB2YWx1ZXMsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vdGhlbiB3ZSBuZWVkIHRvIGNoZWNrIGZvciAzIHRoaW5nczpcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaWYgdGhlIHZhbHVlcyBzZWxlY3RlZCBhcmUgYWxsIGluIHRoZSBzYW1lIHRyZWUgdGhlbiB3ZSBjYW4gZG8gc29tZSBjbGV2ZXIgcmV3cml0ZSBzdHVmZlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL21lcmdlIGFsbCB2YWx1ZXMgaW4gc2FtZSBsZXZlbCwgdGhlbiBjb21iaW5lIHRoZSBsZXZlbHNcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaWYgdGhleSBhcmUgZnJvbSBkaWZmZXJlbnQgdHJlZXMgdGhlbiBqdXN0IGNvbWJpbmUgdGhlbSBvciBqdXN0IHVzZSBgZmllbGRfdmFsdWVgXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8qXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRlcHRocyA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgJChmaWVsZF92YWx1ZXMpLmVhY2goZnVuY3Rpb24gKGluZGV4LCB2YWwpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gJGZpZWxkLmZpbmQoXCJpbnB1dFt2YWx1ZT0nXCIgKyBmaWVsZF92YWx1ZSArIFwiJ11cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGFjdGl2ZSA9ICRpbnB1dC5wYXJlbnQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGggPSAkYWN0aXZlLmF0dHIoXCJkYXRhLXNmLWRlcHRoXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgLy9kZXB0aHMucHVzaChkZXB0aCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgfSk7Ki9cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZSBpZiAoKGlucHV0X3R5cGUgPT0gXCJzZWxlY3RcIikgfHwgKGlucHV0X3R5cGUgPT0gXCJtdWx0aXNlbGVjdFwiKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgaXNfc2luZ2xlX3ZhbHVlID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRfdmFsdWVzID0gZmllbGRfdmFsdWUuc3BsaXQoXCIsXCIpLmpvaW4oXCIrXCIpLnNwbGl0KFwiK1wiKTtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoZmllbGRfdmFsdWVzLmxlbmd0aCA+IDEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaXNfc2luZ2xlX3ZhbHVlID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAoaXNfc2luZ2xlX3ZhbHVlKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGFjdGl2ZSA9ICRmaWVsZC5maW5kKFwib3B0aW9uW3ZhbHVlPSdcIiArIGZpZWxkX3ZhbHVlICsgXCInXVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRlcHRoID0gJGFjdGl2ZS5hdHRyKFwiZGF0YS1zZi1kZXB0aFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB2YWx1ZXMgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goZmllbGRfdmFsdWUpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgZm9yICh2YXIgaSA9IGRlcHRoOyBpID4gMDsgaS0tKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkYWN0aXZlID0gJGFjdGl2ZS5wcmV2QWxsKFwib3B0aW9uW2RhdGEtc2YtZGVwdGg9J1wiICsgKGkgLSAxKSArIFwiJ11cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaCgkYWN0aXZlLnZhbCgpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnJldmVyc2UoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGFjdGl2ZV9yZXdyaXRlID0gcmV3cml0ZVtkZXB0aF07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB1cmwgPSBhY3RpdmVfcmV3cml0ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJCh2YWx1ZXMpLmVhY2goZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybCA9IHVybC5yZXBsYWNlKFwiW1wiICsgaW5kZXggKyBcIl1cIiwgdmFsdWUpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSB1cmw7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICB9XHJcbiAgICAgICAgLy90aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gY3VycmVudF9yZXN1bHRzX3VybDtcclxuICAgIH0sXHJcbiAgICBnZXRSZXN1bHRzVXJsOiBmdW5jdGlvbigkZm9ybSwgY3VycmVudF9yZXN1bHRzX3VybCkge1xyXG5cclxuICAgICAgICAvL3RoaXMuc2V0VGF4QXJjaGl2ZVJlc3VsdHNVcmwoJGZvcm0sIGN1cnJlbnRfcmVzdWx0c191cmwpO1xyXG5cclxuICAgICAgICBpZih0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsPT1cIlwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgcmV0dXJuIGN1cnJlbnRfcmVzdWx0c191cmw7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICByZXR1cm4gdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybDtcclxuICAgIH0sXHJcblx0Z2V0VXJsUGFyYW1zOiBmdW5jdGlvbigkZm9ybSl7XHJcblxyXG5cdFx0dGhpcy5idWlsZFVybENvbXBvbmVudHMoJGZvcm0sIHRydWUpO1xyXG5cclxuICAgICAgICBpZih0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsIT1cIlwiKVxyXG4gICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgIGlmKHRoaXMuYWN0aXZlX3RheCE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGZpZWxkX25hbWUgPSB0aGlzLmFjdGl2ZV90YXg7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMudXJsX3BhcmFtc1tmaWVsZF9uYW1lXSkhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgZGVsZXRlIHRoaXMudXJsX3BhcmFtc1tmaWVsZF9uYW1lXTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcblx0XHRyZXR1cm4gdGhpcy51cmxfcGFyYW1zO1xyXG5cdH0sXHJcblx0Y2xlYXJVcmxDb21wb25lbnRzOiBmdW5jdGlvbigpe1xyXG5cdFx0Ly90aGlzLnVybF9jb21wb25lbnRzID0gXCJcIjtcclxuXHRcdHRoaXMudXJsX3BhcmFtcyA9IHt9O1xyXG5cdH0sXHJcblx0Y2xlYXJUYXhBcmNoaXZlUmVzdWx0c1VybDogZnVuY3Rpb24oKSB7XHJcblx0XHR0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gJyc7XHJcblx0fSxcclxuXHRkaXNhYmxlSW5wdXRzOiBmdW5jdGlvbigkZm9ybSl7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdCRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcclxuXHRcdFx0dmFyICRpbnB1dHMgPSAkKHRoaXMpLmZpbmQoXCJpbnB1dCwgc2VsZWN0LCAubWV0YS1zbGlkZXJcIik7XHJcblx0XHRcdCRpbnB1dHMuYXR0cihcImRpc2FibGVkXCIsIFwiZGlzYWJsZWRcIik7XHJcblx0XHRcdCRpbnB1dHMuYXR0cihcImRpc2FibGVkXCIsIHRydWUpO1xyXG5cdFx0XHQkaW5wdXRzLnByb3AoXCJkaXNhYmxlZFwiLCB0cnVlKTtcclxuXHRcdFx0JGlucHV0cy50cmlnZ2VyKFwiY2hvc2VuOnVwZGF0ZWRcIik7XHJcblx0XHRcdFxyXG5cdFx0fSk7XHJcblx0XHRcclxuXHRcdFxyXG5cdH0sXHJcblx0ZW5hYmxlSW5wdXRzOiBmdW5jdGlvbigkZm9ybSl7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHQkZm9ybS4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0dmFyICRpbnB1dHMgPSAkKHRoaXMpLmZpbmQoXCJpbnB1dCwgc2VsZWN0LCAubWV0YS1zbGlkZXJcIik7XHJcblx0XHRcdCRpbnB1dHMucHJvcChcImRpc2FibGVkXCIsIGZhbHNlKTtcclxuXHRcdFx0JGlucHV0cy5hdHRyKFwiZGlzYWJsZWRcIiwgZmFsc2UpO1xyXG5cdFx0XHQkaW5wdXRzLnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTtcdFx0XHRcclxuXHRcdH0pO1xyXG5cdFx0XHJcblx0XHRcclxuXHR9LFxyXG5cdGJ1aWxkVXJsQ29tcG9uZW50czogZnVuY3Rpb24oJGZvcm0sIGNsZWFyX2NvbXBvbmVudHMpe1xyXG5cdFx0XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihjbGVhcl9jb21wb25lbnRzKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoY2xlYXJfY29tcG9uZW50cz09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHRoaXMuY2xlYXJVcmxDb21wb25lbnRzKCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFxyXG5cdFx0XHR2YXIgZmllbGROYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0XHR2YXIgZmllbGRUeXBlID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0XHRcclxuXHRcdFx0aWYoZmllbGRUeXBlPT1cInNlYXJjaFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzU2VhcmNoRmllbGQoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZigoZmllbGRUeXBlPT1cInRhZ1wiKXx8KGZpZWxkVHlwZT09XCJjYXRlZ29yeVwiKXx8KGZpZWxkVHlwZT09XCJ0YXhvbm9teVwiKSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1RheG9ub215KCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInNvcnRfb3JkZXJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1NvcnRPcmRlckZpZWxkKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInBvc3RzX3Blcl9wYWdlXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NSZXN1bHRzUGVyUGFnZUZpZWxkKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cImF1dGhvclwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzQXV0aG9yKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInBvc3RfdHlwZVwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzUG9zdFR5cGUoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdF9kYXRlXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NQb3N0RGF0ZSgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0X21ldGFcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Bvc3RNZXRhKCQodGhpcykpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2VcclxuXHRcdFx0e1xyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fSk7XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NTZWFyY2hGaWVsZDogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdHZhciAkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJpbnB1dFtuYW1lXj0nX3NmX3NlYXJjaCddXCIpO1xyXG5cdFx0XHJcblx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHR7XHJcblx0XHRcdHZhciBmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC52YWwoKTtcclxuXHRcdFx0XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJl9zZl9zPVwiK2VuY29kZVVSSUNvbXBvbmVudChmaWVsZFZhbCk7XHJcblx0XHRcdFx0c2VsZi51cmxfcGFyYW1zWydfc2ZfcyddID0gZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkVmFsKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdH0sXHJcblx0cHJvY2Vzc1NvcnRPcmRlckZpZWxkOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHRoaXMucHJvY2Vzc0F1dGhvcigkY29udGFpbmVyKTtcclxuXHRcdFxyXG5cdH0sXHJcblx0cHJvY2Vzc1Jlc3VsdHNQZXJQYWdlRmllbGQ6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dGhpcy5wcm9jZXNzQXV0aG9yKCRjb250YWluZXIpO1xyXG5cdFx0XHJcblx0fSxcclxuXHRnZXRBY3RpdmVUYXg6IGZ1bmN0aW9uKCRmaWVsZCkge1xyXG5cdFx0cmV0dXJuIHRoaXMuYWN0aXZlX3RheDtcclxuXHR9LFxyXG5cdGdldFNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkKXtcclxuXHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHRpZigkZmllbGQudmFsKCkhPTApXHJcblx0XHR7XHJcblx0XHRcdGZpZWxkVmFsID0gJGZpZWxkLnZhbCgpO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZihmaWVsZFZhbD09bnVsbClcclxuXHRcdHtcclxuXHRcdFx0ZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWw7XHJcblx0fSxcclxuXHRnZXRNZXRhU2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQpe1xyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHRmaWVsZFZhbCA9ICRmaWVsZC52YWwoKTtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRpZihmaWVsZFZhbD09bnVsbClcclxuXHRcdHtcclxuXHRcdFx0ZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWw7XHJcblx0fSxcclxuXHRnZXRNdWx0aVNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XHJcblx0XHRcclxuXHRcdHZhciBkZWxpbSA9IFwiK1wiO1xyXG5cdFx0aWYob3BlcmF0b3I9PVwib3JcIilcclxuXHRcdHtcclxuXHRcdFx0ZGVsaW0gPSBcIixcIjtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKCRmaWVsZC52YWwoKSk9PVwib2JqZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKCRmaWVsZC52YWwoKSE9bnVsbClcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAkZmllbGQudmFsKCkuam9pbihkZWxpbSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdH0sXHJcblx0Z2V0TWV0YU11bHRpU2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQsIG9wZXJhdG9yKXtcclxuXHRcdFxyXG5cdFx0dmFyIGRlbGltID0gXCItKy1cIjtcclxuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXHJcblx0XHR7XHJcblx0XHRcdGRlbGltID0gXCItLC1cIjtcclxuXHRcdH1cclxuXHRcdFx0XHRcclxuXHRcdGlmKHR5cGVvZigkZmllbGQudmFsKCkpPT1cIm9iamVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZigkZmllbGQudmFsKCkhPW51bGwpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgZmllbGR2YWwgPSBbXTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQkKCRmaWVsZC52YWwoKSkuZWFjaChmdW5jdGlvbihpbmRleCx2YWx1ZSl7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdGZpZWxkdmFsLnB1c2goKHZhbHVlKSk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0cmV0dXJuIGZpZWxkdmFsLmpvaW4oZGVsaW0pO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdHJldHVybiBcIlwiO1xyXG5cdFx0XHJcblx0fSxcclxuXHRnZXRDaGVja2JveFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XHJcblx0XHRcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpe1xyXG5cdFx0XHRpZigkKHRoaXMpLnByb3AoXCJjaGVja2VkXCIpPT10cnVlKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0cmV0dXJuICQodGhpcykudmFsKCk7XHJcblx0XHRcdH1cclxuXHRcdH0pLmdldCgpO1xyXG5cdFx0XHJcblx0XHR2YXIgZGVsaW0gPSBcIitcIjtcclxuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXHJcblx0XHR7XHJcblx0XHRcdGRlbGltID0gXCIsXCI7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdHJldHVybiBmaWVsZFZhbC5qb2luKGRlbGltKTtcclxuXHR9LFxyXG5cdGdldE1ldGFDaGVja2JveFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XHJcblx0XHRcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpe1xyXG5cdFx0XHRpZigkKHRoaXMpLnByb3AoXCJjaGVja2VkXCIpPT10cnVlKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0cmV0dXJuICgkKHRoaXMpLnZhbCgpKTtcclxuXHRcdFx0fVxyXG5cdFx0fSkuZ2V0KCk7XHJcblx0XHRcclxuXHRcdHZhciBkZWxpbSA9IFwiLSstXCI7XHJcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRkZWxpbSA9IFwiLSwtXCI7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdHJldHVybiBmaWVsZFZhbC5qb2luKGRlbGltKTtcclxuXHR9LFxyXG5cdGdldFJhZGlvVmFsOiBmdW5jdGlvbigkZmllbGQpe1xyXG5cdFx0XHRcdFx0XHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpXHJcblx0XHR7XHJcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRyZXR1cm4gJCh0aGlzKS52YWwoKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH0pLmdldCgpO1xyXG5cdFx0XHJcblx0XHRcclxuXHRcdGlmKGZpZWxkVmFsWzBdIT0wKVxyXG5cdFx0e1xyXG5cdFx0XHRyZXR1cm4gZmllbGRWYWxbMF07XHJcblx0XHR9XHJcblx0fSxcclxuXHRnZXRNZXRhUmFkaW9WYWw6IGZ1bmN0aW9uKCRmaWVsZCl7XHJcblx0XHRcdFx0XHRcdFx0XHJcblx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQubWFwKGZ1bmN0aW9uKClcclxuXHRcdHtcclxuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAkKHRoaXMpLnZhbCgpO1xyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fSkuZ2V0KCk7XHJcblx0XHRcclxuXHRcdHJldHVybiBmaWVsZFZhbFswXTtcclxuXHR9LFxyXG5cdHByb2Nlc3NBdXRob3I6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xyXG5cdFx0XHJcblx0XHR2YXIgJGZpZWxkO1xyXG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHRpZihpbnB1dFR5cGU9PVwic2VsZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFNlbGVjdFZhbCgkZmllbGQpOyBcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cIm11bHRpc2VsZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHR2YXIgb3BlcmF0b3IgPSAkZmllbGQuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFxyXG5cdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TXVsdGlTZWxlY3RWYWwoJGZpZWxkLCBcIm9yXCIpO1xyXG5cdFx0XHRcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cImNoZWNrYm94XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XHJcblx0XHRcdFxyXG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKS5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0Q2hlY2tib3hWYWwoJGZpZWxkLCBcIm9yXCIpO1xyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFkaW9cIilcclxuXHRcdHtcclxuXHRcdFx0XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6cmFkaW9cIik7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFJhZGlvVmFsKCRmaWVsZCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHR2YXIgZmllbGRTbHVnID0gXCJcIjtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZihmaWVsZE5hbWU9PVwiX3NmX2F1dGhvclwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwiYXV0aG9yc1wiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlIGlmKGZpZWxkTmFtZT09XCJfc2Zfc29ydF9vcmRlclwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwic29ydF9vcmRlclwiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlIGlmKGZpZWxkTmFtZT09XCJfc2ZfcHBwXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJfc2ZfcHBwXCI7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2UgaWYoZmllbGROYW1lPT1cIl9zZl9wb3N0X3R5cGVcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcInBvc3RfdHlwZXNcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoZmllbGRTbHVnIT1cIlwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZFNsdWcrXCI9XCIrZmllbGRWYWw7XHJcblx0XHRcdFx0XHRzZWxmLnVybF9wYXJhbXNbZmllbGRTbHVnXSA9IGZpZWxkVmFsO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzUG9zdFR5cGUgOiBmdW5jdGlvbigkdGhpcyl7XHJcblx0XHRcclxuXHRcdHRoaXMucHJvY2Vzc0F1dGhvcigkdGhpcyk7XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NQb3N0TWV0YTogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xyXG5cdFx0dmFyIG1ldGFUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1tZXRhLXR5cGVcIik7XHJcblxyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdHZhciAkZmllbGQ7XHJcblx0XHR2YXIgZmllbGROYW1lID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0aWYobWV0YVR5cGU9PVwibnVtYmVyXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGlucHV0VHlwZT09XCJyYW5nZS1udW1iZXJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlLW51bWJlciBpbnB1dFwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgdmFsdWVzID0gW107XHJcblx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0dmFsdWVzLnB1c2goJCh0aGlzKS52YWwoKSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSB2YWx1ZXMuam9pbihcIitcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFuZ2Utc2xpZGVyXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXIgaW5wdXRcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0Ly9nZXQgYW55IG51bWJlciBmb3JtYXR0aW5nIHN0dWZmXHJcblx0XHRcdFx0dmFyICRtZXRhX3JhbmdlID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdHZhciBkZWNpbWFsX3BsYWNlcyA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLWRlY2ltYWwtcGxhY2VzXCIpO1xyXG5cdFx0XHRcdHZhciB0aG91c2FuZF9zZXBlcmF0b3IgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS10aG91c2FuZC1zZXBlcmF0b3JcIik7XHJcblx0XHRcdFx0dmFyIGRlY2ltYWxfc2VwZXJhdG9yID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtZGVjaW1hbC1zZXBlcmF0b3JcIik7XHJcblxyXG5cdFx0XHRcdHZhciBmaWVsZF9mb3JtYXQgPSB3TnVtYih7XHJcblx0XHRcdFx0XHRtYXJrOiBkZWNpbWFsX3NlcGVyYXRvcixcclxuXHRcdFx0XHRcdGRlY2ltYWxzOiBwYXJzZUZsb2F0KGRlY2ltYWxfcGxhY2VzKSxcclxuXHRcdFx0XHRcdHRob3VzYW5kOiB0aG91c2FuZF9zZXBlcmF0b3JcclxuXHRcdFx0XHR9KTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgdmFsdWVzID0gW107XHJcblxyXG5cclxuXHRcdFx0XHR2YXIgc2xpZGVyX29iamVjdCA9ICRjb250YWluZXIuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcclxuXHRcdFx0XHQvL3ZhbCBmcm9tIHNsaWRlciBvYmplY3RcclxuXHRcdFx0XHR2YXIgc2xpZGVyX3ZhbCA9IHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5nZXQoKTtcclxuXHJcblx0XHRcdFx0dmFsdWVzLnB1c2goZmllbGRfZm9ybWF0LmZyb20oc2xpZGVyX3ZhbFswXSkpO1xyXG5cdFx0XHRcdHZhbHVlcy5wdXNoKGZpZWxkX2Zvcm1hdC5mcm9tKHNsaWRlcl92YWxbMV0pKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHZhbHVlcy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLXJhZGlvXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtaW5wdXQtcmFuZ2UtcmFkaW9cIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD09MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHQvL3RoZW4gdHJ5IGFnYWluLCB3ZSBtdXN0IGJlIHVzaW5nIGEgc2luZ2xlIGZpZWxkXHJcblx0XHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0dmFyICRtZXRhX3JhbmdlID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2VcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0Ly90aGVyZSBpcyBhbiBlbGVtZW50IHdpdGggYSBmcm9tL3RvIGNsYXNzIC0gc28gd2UgbmVlZCB0byBnZXQgdGhlIHZhbHVlcyBvZiB0aGUgZnJvbSAmIHRvIGlucHV0IGZpZWxkcyBzZXBlcmF0ZWx5XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcdFxyXG5cdFx0XHRcdFx0dmFyIGZpZWxkX3ZhbHMgPSBbXTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRcdHZhciAkcmFkaW9zID0gJCh0aGlzKS5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpO1xyXG5cdFx0XHRcdFx0XHRmaWVsZF92YWxzLnB1c2goc2VsZi5nZXRNZXRhUmFkaW9WYWwoJHJhZGlvcykpO1xyXG5cdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdH0pO1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHQvL3ByZXZlbnQgc2Vjb25kIG51bWJlciBmcm9tIGJlaW5nIGxvd2VyIHRoYW4gdGhlIGZpcnN0XHJcblx0XHRcdFx0XHRpZihmaWVsZF92YWxzLmxlbmd0aD09MilcclxuXHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0aWYoTnVtYmVyKGZpZWxkX3ZhbHNbMV0pPE51bWJlcihmaWVsZF92YWxzWzBdKSlcclxuXHRcdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRcdGZpZWxkX3ZhbHNbMV0gPSBmaWVsZF92YWxzWzBdO1xyXG5cdFx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdGZpZWxkVmFsID0gZmllbGRfdmFscy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPT0xKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLXNlbGVjdFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLWlucHV0LXNlbGVjdFwiKTtcclxuXHRcdFx0XHR2YXIgJG1ldGFfcmFuZ2UgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZVwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQvL3RoZXJlIGlzIGFuIGVsZW1lbnQgd2l0aCBhIGZyb20vdG8gY2xhc3MgLSBzbyB3ZSBuZWVkIHRvIGdldCB0aGUgdmFsdWVzIG9mIHRoZSBmcm9tICYgdG8gaW5wdXQgZmllbGRzIHNlcGVyYXRlbHlcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0dmFyIGZpZWxkX3ZhbHMgPSBbXTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRcdHZhciAkdGhpcyA9ICQodGhpcyk7XHJcblx0XHRcdFx0XHRcdGZpZWxkX3ZhbHMucHVzaChzZWxmLmdldE1ldGFTZWxlY3RWYWwoJHRoaXMpKTtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0XHR9KTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0Ly9wcmV2ZW50IHNlY29uZCBudW1iZXIgZnJvbSBiZWluZyBsb3dlciB0aGFuIHRoZSBmaXJzdFxyXG5cdFx0XHRcdFx0aWYoZmllbGRfdmFscy5sZW5ndGg9PTIpXHJcblx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdGlmKE51bWJlcihmaWVsZF92YWxzWzFdKTxOdW1iZXIoZmllbGRfdmFsc1swXSkpXHJcblx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRmaWVsZF92YWxzWzFdID0gZmllbGRfdmFsc1swXTtcclxuXHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdGZpZWxkVmFsID0gZmllbGRfdmFscy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPT0xKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLWNoZWNrYm94XCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0Q2hlY2tib3hWYWwoJGZpZWxkLCBcImFuZFwiKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHRcdGlmKGZpZWxkTmFtZT09XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihtZXRhVHlwZT09XCJjaG9pY2VcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhU2VsZWN0VmFsKCRmaWVsZCk7IFxyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cIm11bHRpc2VsZWN0XCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGZpZWxkLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhTXVsdGlTZWxlY3RWYWwoJGZpZWxkLCBvcGVyYXRvcik7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwiY2hlY2tib3hcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdHZhciBvcGVyYXRvciA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIikuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YUNoZWNrYm94VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYWRpb1wiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpyYWRpb1wiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE1ldGFSYWRpb1ZhbCgkZmllbGQpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBlbmNvZGVVUklDb21wb25lbnQoZmllbGRWYWwpO1xyXG5cdFx0XHRpZih0eXBlb2YoJGZpZWxkKSE9PVwidW5kZWZpbmVkXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHQvL2ZvciB0aG9zZSB3aG8gaW5zaXN0IG9uIHVzaW5nICYgYW1wZXJzYW5kcyBpbiB0aGUgbmFtZSBvZiB0aGUgY3VzdG9tIGZpZWxkICghKVxyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gKGZpZWxkTmFtZSk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihtZXRhVHlwZT09XCJkYXRlXCIpXHJcblx0XHR7XHJcblx0XHRcdHNlbGYucHJvY2Vzc1Bvc3REYXRlKCRjb250YWluZXIpO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoZmllbGRWYWwpIT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitlbmNvZGVVUklDb21wb25lbnQoZmllbGROYW1lKStcIj1cIisoZmllbGRWYWwpO1xyXG5cdFx0XHRcdHNlbGYudXJsX3BhcmFtc1tlbmNvZGVVUklDb21wb25lbnQoZmllbGROYW1lKV0gPSAoZmllbGRWYWwpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0fSxcclxuXHRwcm9jZXNzUG9zdERhdGU6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuXHRcdFxyXG5cdFx0dmFyICRmaWVsZDtcclxuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDp0ZXh0XCIpO1xyXG5cdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHJcblx0XHR2YXIgZGF0ZXMgPSBbXTtcclxuXHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFxyXG5cdFx0XHRkYXRlcy5wdXNoKCQodGhpcykudmFsKCkpO1xyXG5cdFx0XHJcblx0XHR9KTtcclxuXHRcdFxyXG5cdFx0aWYoJGZpZWxkLmxlbmd0aD09MilcclxuXHRcdHtcclxuXHRcdFx0aWYoKGRhdGVzWzBdIT1cIlwiKXx8KGRhdGVzWzFdIT1cIlwiKSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gZGF0ZXMuam9pbihcIitcIik7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBmaWVsZFZhbC5yZXBsYWNlKC9cXC8vZywnJyk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoJGZpZWxkLmxlbmd0aD09MSlcclxuXHRcdHtcclxuXHRcdFx0aWYoZGF0ZXNbMF0hPVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IGRhdGVzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gZmllbGRWYWwucmVwbGFjZSgvXFwvL2csJycpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0dmFyIGZpZWxkU2x1ZyA9IFwiXCI7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoZmllbGROYW1lPT1cIl9zZl9wb3N0X2RhdGVcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcInBvc3RfZGF0ZVwiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gZmllbGROYW1lO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZihmaWVsZFNsdWchPVwiXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJlwiK2ZpZWxkU2x1ZytcIj1cIitmaWVsZFZhbDtcclxuXHRcdFx0XHRcdHNlbGYudXJsX3BhcmFtc1tmaWVsZFNsdWddID0gZmllbGRWYWw7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NUYXhvbm9teTogZnVuY3Rpb24oJGNvbnRhaW5lciwgcmV0dXJuX29iamVjdClcclxuXHR7XHJcbiAgICAgICAgaWYodHlwZW9mKHJldHVybl9vYmplY3QpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgcmV0dXJuX29iamVjdCA9IGZhbHNlO1xyXG4gICAgICAgIH1cclxuXHJcblx0XHQvL2lmKClcdFx0XHRcdFx0XHJcblx0XHQvL3ZhciBmaWVsZE5hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHJcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuXHRcdFxyXG5cdFx0dmFyICRmaWVsZDtcclxuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRTZWxlY3RWYWwoJGZpZWxkKTsgXHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0dmFyIG9wZXJhdG9yID0gJGZpZWxkLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE11bHRpU2VsZWN0VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwiY2hlY2tib3hcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpjaGVja2JveFwiKTtcclxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIikuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldENoZWNrYm94VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYWRpb1wiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnJhZGlvXCIpO1xyXG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFJhZGlvVmFsKCRmaWVsZCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXHJcblx0XHRcdHtcclxuICAgICAgICAgICAgICAgIGlmKHJldHVybl9vYmplY3Q9PXRydWUpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHtuYW1lOiBmaWVsZE5hbWUsIHZhbHVlOiBmaWVsZFZhbH07XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJlwiK2ZpZWxkTmFtZStcIj1cIitmaWVsZFZhbDtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLnVybF9wYXJhbXNbZmllbGROYW1lXSA9IGZpZWxkVmFsO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuICAgICAgICBpZihyZXR1cm5fb2JqZWN0PT10cnVlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH1cclxuXHR9XHJcbn07XG59KS5jYWxsKHRoaXMsdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbCA6IHR5cGVvZiBzZWxmICE9PSBcInVuZGVmaW5lZFwiID8gc2VsZiA6IHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3cgOiB7fSlcbi8vIyBzb3VyY2VNYXBwaW5nVVJMPWRhdGE6YXBwbGljYXRpb24vanNvbjtjaGFyc2V0OnV0Zi04O2Jhc2U2NCxleUoyWlhKemFXOXVJam96TENKemIzVnlZMlZ6SWpwYkluTnlZeTl3ZFdKc2FXTXZZWE56WlhSekwycHpMMmx1WTJ4MVpHVnpMM0J5YjJObGMzTmZabTl5YlM1cWN5SmRMQ0p1WVcxbGN5STZXMTBzSW0xaGNIQnBibWR6SWpvaU8wRkJRVUU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFaUxDSm1hV3hsSWpvaVoyVnVaWEpoZEdWa0xtcHpJaXdpYzI5MWNtTmxVbTl2ZENJNklpSXNJbk52ZFhKalpYTkRiMjUwWlc1MElqcGJJbHh5WEc1MllYSWdKQ0E5SUNoMGVYQmxiMllnZDJsdVpHOTNJQ0U5UFNCY0luVnVaR1ZtYVc1bFpGd2lJRDhnZDJsdVpHOTNXeWRxVVhWbGNua25YU0E2SUhSNWNHVnZaaUJuYkc5aVlXd2dJVDA5SUZ3aWRXNWtaV1pwYm1Wa1hDSWdQeUJuYkc5aVlXeGJKMnBSZFdWeWVTZGRJRG9nYm5Wc2JDazdYSEpjYmx4eVhHNXRiMlIxYkdVdVpYaHdiM0owY3lBOUlIdGNjbHh1WEhKY2JseDBkR0Y0YjI1dmJYbGZZWEpqYUdsMlpYTTZJREFzWEhKY2JpQWdJQ0IxY214ZmNHRnlZVzF6T2lCN2ZTeGNjbHh1SUNBZ0lIUmhlRjloY21Ob2FYWmxYM0psYzNWc2RITmZkWEpzT2lCY0lsd2lMRnh5WEc0Z0lDQWdZV04wYVhabFgzUmhlRG9nWENKY0lpeGNjbHh1SUNBZ0lHWnBaV3hrY3pvZ2UzMHNYSEpjYmx4MGFXNXBkRG9nWm5WdVkzUnBiMjRvZEdGNGIyNXZiWGxmWVhKamFHbDJaWE1zSUdOMWNuSmxiblJmZEdGNGIyNXZiWGxmWVhKamFHbDJaU2w3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWRHRjRiMjV2YlhsZllYSmphR2wyWlhNZ1BTQXdPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVkWEpzWDNCaGNtRnRjeUE5SUh0OU8xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWRHRjRYMkZ5WTJocGRtVmZjbVZ6ZFd4MGMxOTFjbXdnUFNCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVZV04wYVhabFgzUmhlQ0E5SUZ3aVhDSTdYSEpjYmx4eVhHNWNkRngwTHk5MGFHbHpMaVJtYVdWc1pITWdQU0FrWm1sbGJHUnpPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVkR0Y0YjI1dmJYbGZZWEpqYUdsMlpYTWdQU0IwWVhodmJtOXRlVjloY21Ob2FYWmxjenRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbU4xY25KbGJuUmZkR0Y0YjI1dmJYbGZZWEpqYUdsMlpTQTlJR04xY25KbGJuUmZkR0Y0YjI1dmJYbGZZWEpqYUdsMlpUdGNjbHh1WEhKY2JseDBYSFIwYUdsekxtTnNaV0Z5VlhKc1EyOXRjRzl1Wlc1MGN5Z3BPMXh5WEc1Y2NseHVYSFI5TEZ4eVhHNGdJQ0FnYzJWMFZHRjRRWEpqYUdsMlpWSmxjM1ZzZEhOVmNtdzZJR1oxYm1OMGFXOXVLQ1JtYjNKdExDQmpkWEp5Wlc1MFgzSmxjM1ZzZEhOZmRYSnNMQ0JuWlhSZllXTjBhWFpsS1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUhaaGNpQnpaV3htSUQwZ2RHaHBjenRjY2x4dVhIUmNkSFJvYVhNdVkyeGxZWEpVWVhoQmNtTm9hWFpsVW1WemRXeDBjMVZ5YkNncE8xeHlYRzRnSUNBZ0lDQWdJQzh2ZG1GeUlHTjFjbkpsYm5SZmNtVnpkV3gwYzE5MWNtd2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJR2xtS0hSb2FYTXVkR0Y0YjI1dmJYbGZZWEpqYUdsMlpYTWhQVEVwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTQ3WEhKY2JpQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCcFppaDBlWEJsYjJZb1oyVjBYMkZqZEdsMlpTazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RIWmhjaUJuWlhSZllXTjBhWFpsSUQwZ1ptRnNjMlU3WEhKY2JseDBYSFI5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQzh2WTJobFkyc2dkRzhnYzJWbElHbG1JSGRsSUdoaGRtVWdZVzU1SUhSaGVHOXViMjFwWlhNZ2MyVnNaV04wWldSY2NseHVJQ0FnSUNBZ0lDQXZMMmxtSUhOdkxDQmphR1ZqYXlCMGFHVnBjaUJ5WlhkeWFYUmxjeUJoYm1RZ2RYTmxJSFJvYjNObElHRnpJSFJvWlNCeVpYTjFiSFJ6SUhWeWJGeHlYRzRnSUNBZ0lDQWdJSFpoY2lBa1ptbGxiR1FnUFNCbVlXeHpaVHRjY2x4dUlDQWdJQ0FnSUNCMllYSWdabWxsYkdSZmJtRnRaU0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZG1GeUlHWnBaV3hrWDNaaGJIVmxJRDBnWENKY0lqdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RtRnlJQ1JoWTNScGRtVmZkR0Y0YjI1dmJYa2dQU0FrWm05eWJTNGtabWxsYkdSekxuQmhjbVZ1ZENncExtWnBibVFvWENKYlpHRjBZUzF6WmkxMFlYaHZibTl0ZVMxaGNtTm9hWFpsUFNjeEoxMWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ2FXWW9KR0ZqZEdsMlpWOTBZWGh2Ym05dGVTNXNaVzVuZEdnOVBURXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FrWm1sbGJHUWdQU0FrWVdOMGFYWmxYM1JoZUc5dWIyMTVPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHWnBaV3hrVkhsd1pTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzEwZVhCbFhDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tDaG1hV1ZzWkZSNWNHVWdQVDBnWENKMFlXZGNJaWtnZkh3Z0tHWnBaV3hrVkhsd1pTQTlQU0JjSW1OaGRHVm5iM0o1WENJcElIeDhJQ2htYVdWc1pGUjVjR1VnUFQwZ1hDSjBZWGh2Ym05dGVWd2lLU2tnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJoZUc5dWIyMTVYM1poYkhWbElEMGdjMlZzWmk1d2NtOWpaWE56VkdGNGIyNXZiWGtvSkdacFpXeGtMQ0IwY25WbEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1pwWld4a1gyNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGJtRnRaVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIwWVhodmJtOXRlVjl1WVcxbElEMGdabWxsYkdSZmJtRnRaUzV5WlhCc1lXTmxLRndpWDNObWRGOWNJaXdnWENKY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLSFJoZUc5dWIyMTVYM1poYkhWbEtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1ptbGxiR1JmZG1Gc2RXVWdQU0IwWVhodmJtOXRlVjkyWVd4MVpTNTJZV3gxWlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvWm1sbGJHUmZkbUZzZFdVOVBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbWFXVnNaQ0E5SUdaaGJITmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmlnb2MyVnNaaTVqZFhKeVpXNTBYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVWhQVndpWENJcEppWW9jMlZzWmk1amRYSnlaVzUwWDNSaGVHOXViMjE1WDJGeVkyaHBkbVVoUFhSaGVHOXViMjE1WDI1aGJXVXBLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11ZEdGNFgyRnlZMmhwZG1WZmNtVnpkV3gwYzE5MWNtd2dQU0JqZFhKeVpXNTBYM0psYzNWc2RITmZkWEpzTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNDdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmlnb0tHWnBaV3hrWDNaaGJIVmxQVDFjSWx3aUtYeDhLQ0VrWm1sbGJHUXBJQ2twWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBa1ptOXliUzRrWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0Z0tDa2dlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2doSkdacFpXeGtLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1hV1ZzWkZSNWNHVWdQU0FrS0hSb2FYTXBMbUYwZEhJb1hDSmtZWFJoTFhObUxXWnBaV3hrTFhSNWNHVmNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDZ29abWxsYkdSVWVYQmxJRDA5SUZ3aWRHRm5YQ0lwSUh4OElDaG1hV1ZzWkZSNWNHVWdQVDBnWENKallYUmxaMjl5ZVZ3aUtTQjhmQ0FvWm1sbGJHUlVlWEJsSUQwOUlGd2lkR0Y0YjI1dmJYbGNJaWtwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJoZUc5dWIyMTVYM1poYkhWbElEMGdjMlZzWmk1d2NtOWpaWE56VkdGNGIyNXZiWGtvSkNoMGFHbHpLU3dnZEhKMVpTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1pwWld4a1gyNWhiV1VnUFNBa0tIUm9hWE1wTG1GMGRISW9YQ0prWVhSaExYTm1MV1pwWld4a0xXNWhiV1ZjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2RHRjRiMjV2YlhsZmRtRnNkV1VwSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbWFXVnNaRjkyWVd4MVpTQTlJSFJoZUc5dWIyMTVYM1poYkhWbExuWmhiSFZsTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaG1hV1ZzWkY5MllXeDFaU0FoUFNCY0lsd2lLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUm1hV1ZzWkNBOUlDUW9kR2hwY3lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUdsbUtDQW9KR1pwWld4a0tTQW1KaUFvWm1sbGJHUmZkbUZzZFdVZ0lUMGdYQ0pjSWlBcEtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZhV1lnZDJVZ1ptOTFibVFnWVNCbWFXVnNaRnh5WEc1Y2RGeDBYSFIyWVhJZ2NtVjNjbWwwWlY5aGRIUnlJRDBnS0NSbWFXVnNaQzVoZEhSeUtGd2laR0YwWVMxelppMTBaWEp0TFhKbGQzSnBkR1ZjSWlrcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvY21WM2NtbDBaVjloZEhSeUlUMWNJbHdpS1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlISmxkM0pwZEdVZ1BTQktVMDlPTG5CaGNuTmxLSEpsZDNKcGRHVmZZWFIwY2lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYVc1d2RYUmZkSGx3WlNBOUlDUm1hV1ZzWkM1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMXBibkIxZEMxMGVYQmxYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVoWTNScGRtVmZkR0Y0SUQwZ1ptbGxiR1JmYm1GdFpUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyWnBibVFnZEdobElHRmpkR2wyWlNCbGJHVnRaVzUwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9LR2x1Y0hWMFgzUjVjR1VnUFQwZ1hDSnlZV1JwYjF3aUtTQjhmQ0FvYVc1d2RYUmZkSGx3WlNBOVBTQmNJbU5vWldOclltOTRYQ0lwS1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZkbUZ5SUNSaFkzUnBkbVVnUFNBa1ptbGxiR1F1Wm1sdVpDaGNJaTV6WmkxdmNIUnBiMjR0WVdOMGFYWmxYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Wlhod2JHOWtaU0IwYUdVZ2RtRnNkV1Z6SUdsbUlIUm9aWEpsSUdseklHRWdaR1ZzYVcxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJacFpXeGtYM1poYkhWbFhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJwYzE5emFXNW5iR1ZmZG1Gc2RXVWdQU0IwY25WbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1hV1ZzWkY5MllXeDFaWE1nUFNCbWFXVnNaRjkyWVd4MVpTNXpjR3hwZENoY0lpeGNJaWt1YW05cGJpaGNJaXRjSWlrdWMzQnNhWFFvWENJclhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2htYVdWc1pGOTJZV3gxWlhNdWJHVnVaM1JvSUQ0Z01Ta2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwYzE5emFXNW5iR1ZmZG1Gc2RXVWdQU0JtWVd4elpUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2hwYzE5emFXNW5iR1ZmZG1Gc2RXVXBJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrYVc1d2RYUWdQU0FrWm1sbGJHUXVabWx1WkNoY0ltbHVjSFYwVzNaaGJIVmxQU2RjSWlBcklHWnBaV3hrWDNaaGJIVmxJQ3NnWENJblhWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmhZM1JwZG1VZ1BTQWthVzV3ZFhRdWNHRnlaVzUwS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrWlhCMGFDQTlJQ1JoWTNScGRtVXVZWFIwY2loY0ltUmhkR0V0YzJZdFpHVndkR2hjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDI1dmR5QnNiMjl3SUhSb2NtOTFaMmdnY0dGeVpXNTBjeUIwYnlCbmNtRmlJSFJvWldseUlHNWhiV1Z6WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQjJZV3gxWlhNZ1BTQnVaWGNnUVhKeVlYa29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1Gc2RXVnpMbkIxYzJnb1ptbGxiR1JmZG1Gc2RXVXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1ptOXlJQ2gyWVhJZ2FTQTlJR1JsY0hSb095QnBJRDRnTURzZ2FTMHRLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtZV04wYVhabElEMGdKR0ZqZEdsMlpTNXdZWEpsYm5Rb0tTNXdZWEpsYm5Rb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGJIVmxjeTV3ZFhOb0tDUmhZM1JwZG1VdVptbHVaQ2hjSW1sdWNIVjBYQ0lwTG5aaGJDZ3BLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZzZFdWekxuSmxkbVZ5YzJVb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dlozSmhZaUIwYUdVZ2NtVjNjbWwwWlNCbWIzSWdkR2hwY3lCa1pYQjBhRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1lXTjBhWFpsWDNKbGQzSnBkR1VnUFNCeVpYZHlhWFJsVzJSbGNIUm9YVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliQ0E5SUdGamRHbDJaVjl5WlhkeWFYUmxPMXh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZEdobGJpQnRZWEFnWm5KdmJTQjBhR1VnY0dGeVpXNTBjeUIwYnlCMGFHVWdaR1Z3ZEdoY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pDaDJZV3gxWlhNcExtVmhZMmdvWm5WdVkzUnBiMjRnS0dsdVpHVjRMQ0IyWVd4MVpTa2dlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFZ5YkNBOUlIVnliQzV5WlhCc1lXTmxLRndpVzF3aUlDc2dhVzVrWlhnZ0t5QmNJbDFjSWl3Z2RtRnNkV1VwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVkR0Y0WDJGeVkyaHBkbVZmY21WemRXeDBjMTkxY213Z1BTQjFjbXc3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTlwWmlCMGFHVnlaU0JoY21VZ2JYVnNkR2x3YkdVZ2RtRnNkV1Z6TEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzUm9aVzRnZDJVZ2JtVmxaQ0IwYnlCamFHVmpheUJtYjNJZ015QjBhR2x1WjNNNlhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUlIUm9aU0IyWVd4MVpYTWdjMlZzWldOMFpXUWdZWEpsSUdGc2JDQnBiaUIwYUdVZ2MyRnRaU0IwY21WbElIUm9aVzRnZDJVZ1kyRnVJR1J2SUhOdmJXVWdZMnhsZG1WeUlISmxkM0pwZEdVZ2MzUjFabVpjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5dFpYSm5aU0JoYkd3Z2RtRnNkV1Z6SUdsdUlITmhiV1VnYkdWMlpXd3NJSFJvWlc0Z1kyOXRZbWx1WlNCMGFHVWdiR1YyWld4elhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUlIUm9aWGtnWVhKbElHWnliMjBnWkdsbVptVnlaVzUwSUhSeVpXVnpJSFJvWlc0Z2FuVnpkQ0JqYjIxaWFXNWxJSFJvWlcwZ2IzSWdhblZ6ZENCMWMyVWdZR1pwWld4a1gzWmhiSFZsWUZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdktseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtaWEIwYUhNZ1BTQnVaWGNnUVhKeVlYa29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb1ptbGxiR1JmZG1Gc2RXVnpLUzVsWVdOb0tHWjFibU4wYVc5dUlDaHBibVJsZUN3Z2RtRnNLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNScGJuQjFkQ0E5SUNSbWFXVnNaQzVtYVc1a0tGd2lhVzV3ZFhSYmRtRnNkV1U5SjF3aUlDc2dabWxsYkdSZmRtRnNkV1VnS3lCY0lpZGRYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JoWTNScGRtVWdQU0FrYVc1d2RYUXVjR0Z5Wlc1MEtDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JsY0hSb0lEMGdKR0ZqZEdsMlpTNWhkSFJ5S0Z3aVpHRjBZUzF6Wmkxa1pYQjBhRndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZaR1Z3ZEdoekxuQjFjMmdvWkdWd2RHZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPeW92WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1ZzYzJVZ2FXWWdLQ2hwYm5CMWRGOTBlWEJsSUQwOUlGd2ljMlZzWldOMFhDSXBJSHg4SUNocGJuQjFkRjkwZVhCbElEMDlJRndpYlhWc2RHbHpaV3hsWTNSY0lpa3BJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHbHpYM05wYm1kc1pWOTJZV3gxWlNBOUlIUnlkV1U3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdacFpXeGtYM1poYkhWbGN5QTlJR1pwWld4a1gzWmhiSFZsTG5Od2JHbDBLRndpTEZ3aUtTNXFiMmx1S0Z3aUsxd2lLUzV6Y0d4cGRDaGNJaXRjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tHWnBaV3hrWDNaaGJIVmxjeTVzWlc1bmRHZ2dQaUF4S1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbHpYM05wYm1kc1pWOTJZV3gxWlNBOUlHWmhiSE5sTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tHbHpYM05wYm1kc1pWOTJZV3gxWlNrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmhZM1JwZG1VZ1BTQWtabWxsYkdRdVptbHVaQ2hjSW05d2RHbHZibHQyWVd4MVpUMG5YQ0lnS3lCbWFXVnNaRjkyWVd4MVpTQXJJRndpSjExY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1pYQjBhQ0E5SUNSaFkzUnBkbVV1WVhSMGNpaGNJbVJoZEdFdGMyWXRaR1Z3ZEdoY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkbUZzZFdWeklEMGdibVYzSUVGeWNtRjVLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGJIVmxjeTV3ZFhOb0tHWnBaV3hrWDNaaGJIVmxLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnZjaUFvZG1GeUlHa2dQU0JrWlhCMGFEc2dhU0ErSURBN0lHa3RMU2tnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR0ZqZEdsMlpTQTlJQ1JoWTNScGRtVXVjSEpsZGtGc2JDaGNJbTl3ZEdsdmJsdGtZWFJoTFhObUxXUmxjSFJvUFNkY0lpQXJJQ2hwSUMwZ01Ta2dLeUJjSWlkZFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnNkV1Z6TG5CMWMyZ29KR0ZqZEdsMlpTNTJZV3dvS1NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGJIVmxjeTV5WlhabGNuTmxLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmhZM1JwZG1WZmNtVjNjbWwwWlNBOUlISmxkM0pwZEdWYlpHVndkR2hkTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkWEpzSUQwZ1lXTjBhWFpsWDNKbGQzSnBkR1U3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb2RtRnNkV1Z6S1M1bFlXTm9LR1oxYm1OMGFXOXVJQ2hwYm1SbGVDd2dkbUZzZFdVcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjFjbXdnUFNCMWNtd3VjbVZ3YkdGalpTaGNJbHRjSWlBcklHbHVaR1Y0SUNzZ1hDSmRYQ0lzSUhaaGJIVmxLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxuUmhlRjloY21Ob2FYWmxYM0psYzNWc2RITmZkWEpzSUQwZ2RYSnNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDOHZkR2hwY3k1MFlYaGZZWEpqYUdsMlpWOXlaWE4xYkhSelgzVnliQ0E5SUdOMWNuSmxiblJmY21WemRXeDBjMTkxY213N1hISmNiaUFnSUNCOUxGeHlYRzRnSUNBZ1oyVjBVbVZ6ZFd4MGMxVnliRG9nWm5WdVkzUnBiMjRvSkdadmNtMHNJR04xY25KbGJuUmZjbVZ6ZFd4MGMxOTFjbXdwSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnTHk5MGFHbHpMbk5sZEZSaGVFRnlZMmhwZG1WU1pYTjFiSFJ6VlhKc0tDUm1iM0p0TENCamRYSnlaVzUwWDNKbGMzVnNkSE5mZFhKc0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kR2hwY3k1MFlYaGZZWEpqYUdsMlpWOXlaWE4xYkhSelgzVnliRDA5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQmpkWEp5Wlc1MFgzSmxjM1ZzZEhOZmRYSnNPMXh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnY21WMGRYSnVJSFJvYVhNdWRHRjRYMkZ5WTJocGRtVmZjbVZ6ZFd4MGMxOTFjbXc3WEhKY2JpQWdJQ0I5TEZ4eVhHNWNkR2RsZEZWeWJGQmhjbUZ0Y3pvZ1puVnVZM1JwYjI0b0pHWnZjbTBwZTF4eVhHNWNjbHh1WEhSY2RIUm9hWE11WW5WcGJHUlZjbXhEYjIxd2IyNWxiblJ6S0NSbWIzSnRMQ0IwY25WbEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kR2hwY3k1MFlYaGZZWEpqYUdsMlpWOXlaWE4xYkhSelgzVnliQ0U5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaDBhR2x6TG1GamRHbDJaVjkwWVhnaFBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1hV1ZzWkY5dVlXMWxJRDBnZEdocGN5NWhZM1JwZG1WZmRHRjRPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG5WeWJGOXdZWEpoYlhOYlptbGxiR1JmYm1GdFpWMHBJVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmxiR1YwWlNCMGFHbHpMblZ5YkY5d1lYSmhiWE5iWm1sbGJHUmZibUZ0WlYwN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzVjZEZ4MGNtVjBkWEp1SUhSb2FYTXVkWEpzWDNCaGNtRnRjenRjY2x4dVhIUjlMRnh5WEc1Y2RHTnNaV0Z5VlhKc1EyOXRjRzl1Wlc1MGN6b2dablZ1WTNScGIyNG9LWHRjY2x4dVhIUmNkQzh2ZEdocGN5NTFjbXhmWTI5dGNHOXVaVzUwY3lBOUlGd2lYQ0k3WEhKY2JseDBYSFIwYUdsekxuVnliRjl3WVhKaGJYTWdQU0I3ZlR0Y2NseHVYSFI5TEZ4eVhHNWNkR05zWldGeVZHRjRRWEpqYUdsMlpWSmxjM1ZzZEhOVmNtdzZJR1oxYm1OMGFXOXVLQ2tnZTF4eVhHNWNkRngwZEdocGN5NTBZWGhmWVhKamFHbDJaVjl5WlhOMWJIUnpYM1Z5YkNBOUlDY25PMXh5WEc1Y2RIMHNYSEpjYmx4MFpHbHpZV0pzWlVsdWNIVjBjem9nWm5WdVkzUnBiMjRvSkdadmNtMHBlMXh5WEc1Y2RGeDBkbUZ5SUhObGJHWWdQU0IwYUdsek8xeHlYRzVjZEZ4MFhISmNibHgwWEhRa1ptOXliUzRrWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0b0tYdGNjbHh1WEhSY2RGeDBYSEpjYmx4MFhIUmNkSFpoY2lBa2FXNXdkWFJ6SUQwZ0pDaDBhR2x6S1M1bWFXNWtLRndpYVc1d2RYUXNJSE5sYkdWamRDd2dMbTFsZEdFdGMyeHBaR1Z5WENJcE8xeHlYRzVjZEZ4MFhIUWthVzV3ZFhSekxtRjBkSElvWENKa2FYTmhZbXhsWkZ3aUxDQmNJbVJwYzJGaWJHVmtYQ0lwTzF4eVhHNWNkRngwWEhRa2FXNXdkWFJ6TG1GMGRISW9YQ0prYVhOaFlteGxaRndpTENCMGNuVmxLVHRjY2x4dVhIUmNkRngwSkdsdWNIVjBjeTV3Y205d0tGd2laR2x6WVdKc1pXUmNJaXdnZEhKMVpTazdYSEpjYmx4MFhIUmNkQ1JwYm5CMWRITXVkSEpwWjJkbGNpaGNJbU5vYjNObGJqcDFjR1JoZEdWa1hDSXBPMXh5WEc1Y2RGeDBYSFJjY2x4dVhIUmNkSDBwTzF4eVhHNWNkRngwWEhKY2JseDBYSFJjY2x4dVhIUjlMRnh5WEc1Y2RHVnVZV0pzWlVsdWNIVjBjem9nWm5WdVkzUnBiMjRvSkdadmNtMHBlMXh5WEc1Y2RGeDBkbUZ5SUhObGJHWWdQU0IwYUdsek8xeHlYRzVjZEZ4MEpHWnZjbTB1SkdacFpXeGtjeTVsWVdOb0tHWjFibU4wYVc5dUtDbDdYSEpjYmx4MFhIUmNkSFpoY2lBa2FXNXdkWFJ6SUQwZ0pDaDBhR2x6S1M1bWFXNWtLRndpYVc1d2RYUXNJSE5sYkdWamRDd2dMbTFsZEdFdGMyeHBaR1Z5WENJcE8xeHlYRzVjZEZ4MFhIUWthVzV3ZFhSekxuQnliM0FvWENKa2FYTmhZbXhsWkZ3aUxDQm1ZV3h6WlNrN1hISmNibHgwWEhSY2RDUnBibkIxZEhNdVlYUjBjaWhjSW1ScGMyRmliR1ZrWENJc0lHWmhiSE5sS1R0Y2NseHVYSFJjZEZ4MEpHbHVjSFYwY3k1MGNtbG5aMlZ5S0Z3aVkyaHZjMlZ1T25Wd1pHRjBaV1JjSWlrN1hIUmNkRngwWEhKY2JseDBYSFI5S1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwWEhKY2JseDBmU3hjY2x4dVhIUmlkV2xzWkZWeWJFTnZiWEJ2Ym1WdWRITTZJR1oxYm1OMGFXOXVLQ1JtYjNKdExDQmpiR1ZoY2w5amIyMXdiMjVsYm5SektYdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGRtRnlJSE5sYkdZZ1BTQjBhR2x6TzF4eVhHNWNkRngwWEhKY2JseDBYSFJwWmloMGVYQmxiMllvWTJ4bFlYSmZZMjl0Y0c5dVpXNTBjeWtoUFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR2xtS0dOc1pXRnlYMk52YlhCdmJtVnVkSE05UFhSeWRXVXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSMGFHbHpMbU5zWldGeVZYSnNRMjl0Y0c5dVpXNTBjeWdwTzF4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSOVhISmNibHgwWEhSY2NseHVYSFJjZENSbWIzSnRMaVJtYVdWc1pITXVaV0ZqYUNobWRXNWpkR2x2YmlncGUxeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RGeDBkbUZ5SUdacFpXeGtUbUZ0WlNBOUlDUW9kR2hwY3lrdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRibUZ0WlZ3aUtUdGNjbHh1WEhSY2RGeDBkbUZ5SUdacFpXeGtWSGx3WlNBOUlDUW9kR2hwY3lrdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRkSGx3WlZ3aUtUdGNjbHh1WEhSY2RGeDBYSEpjYmx4MFhIUmNkR2xtS0dacFpXeGtWSGx3WlQwOVhDSnpaV0Z5WTJoY0lpbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhObGJHWXVjSEp2WTJWemMxTmxZWEpqYUVacFpXeGtLQ1FvZEdocGN5a3BPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEdWc2MyVWdhV1lvS0dacFpXeGtWSGx3WlQwOVhDSjBZV2RjSWlsOGZDaG1hV1ZzWkZSNWNHVTlQVndpWTJGMFpXZHZjbmxjSWlsOGZDaG1hV1ZzWkZSNWNHVTlQVndpZEdGNGIyNXZiWGxjSWlrcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJ6Wld4bUxuQnliMk5sYzNOVVlYaHZibTl0ZVNna0tIUm9hWE1wS1R0Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmxiSE5sSUdsbUtHWnBaV3hrVkhsd1pUMDlYQ0p6YjNKMFgyOXlaR1Z5WENJcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJ6Wld4bUxuQnliMk5sYzNOVGIzSjBUM0prWlhKR2FXVnNaQ2drS0hSb2FYTXBLVHRjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwWEhSbGJITmxJR2xtS0dacFpXeGtWSGx3WlQwOVhDSndiM04wYzE5d1pYSmZjR0ZuWlZ3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwYzJWc1ppNXdjbTlqWlhOelVtVnpkV3gwYzFCbGNsQmhaMlZHYVdWc1pDZ2tLSFJvYVhNcEtUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObElHbG1LR1pwWld4a1ZIbHdaVDA5WENKaGRYUm9iM0pjSWlsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkSE5sYkdZdWNISnZZMlZ6YzBGMWRHaHZjaWdrS0hSb2FYTXBLVHRjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwWEhSbGJITmxJR2xtS0dacFpXeGtWSGx3WlQwOVhDSndiM04wWDNSNWNHVmNJaWxjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RITmxiR1l1Y0hKdlkyVnpjMUJ2YzNSVWVYQmxLQ1FvZEdocGN5a3BPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEdWc2MyVWdhV1lvWm1sbGJHUlVlWEJsUFQxY0luQnZjM1JmWkdGMFpWd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MGMyVnNaaTV3Y205alpYTnpVRzl6ZEVSaGRHVW9KQ2gwYUdsektTazdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkRngwWld4elpTQnBaaWhtYVdWc1pGUjVjR1U5UFZ3aWNHOXpkRjl0WlhSaFhDSXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSelpXeG1MbkJ5YjJObGMzTlFiM04wVFdWMFlTZ2tLSFJvYVhNcEtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwWEhSbGJITmxYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RIMHBPMXh5WEc1Y2RGeDBYSEpjYmx4MGZTeGNjbHh1WEhSd2NtOWpaWE56VTJWaGNtTm9SbWxsYkdRNklHWjFibU4wYVc5dUtDUmpiMjUwWVdsdVpYSXBYSEpjYmx4MGUxeHlYRzVjZEZ4MGRtRnlJSE5sYkdZZ1BTQjBhR2x6TzF4eVhHNWNkRngwWEhKY2JseDBYSFIyWVhJZ0pHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aWFXNXdkWFJiYm1GdFpWNDlKMTl6Wmw5elpXRnlZMmduWFZ3aUtUdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQ0d0tWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUjJZWElnWm1sbGJHUk9ZVzFsSUQwZ0pHWnBaV3hrTG1GMGRISW9YQ0p1WVcxbFhDSXBMbkpsY0d4aFkyVW9KMXRkSnl3Z0p5Y3BPMXh5WEc1Y2RGeDBYSFIyWVhJZ1ptbGxiR1JXWVd3Z1BTQWtabWxsYkdRdWRtRnNLQ2s3WEhKY2JseDBYSFJjZEZ4eVhHNWNkRngwWEhScFppaG1hV1ZzWkZaaGJDRTlYQ0pjSWlsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkQzh2YzJWc1ppNTFjbXhmWTI5dGNHOXVaVzUwY3lBclBTQmNJaVpmYzJaZmN6MWNJaXRsYm1OdlpHVlZVa2xEYjIxd2IyNWxiblFvWm1sbGJHUldZV3dwTzF4eVhHNWNkRngwWEhSY2RITmxiR1l1ZFhKc1gzQmhjbUZ0YzFzblgzTm1YM01uWFNBOUlHVnVZMjlrWlZWU1NVTnZiWEJ2Ym1WdWRDaG1hV1ZzWkZaaGJDazdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkSDFjY2x4dVhIUjlMRnh5WEc1Y2RIQnliMk5sYzNOVGIzSjBUM0prWlhKR2FXVnNaRG9nWm5WdVkzUnBiMjRvSkdOdmJuUmhhVzVsY2lsY2NseHVYSFI3WEhKY2JseDBYSFIwYUdsekxuQnliMk5sYzNOQmRYUm9iM0lvSkdOdmJuUmhhVzVsY2lrN1hISmNibHgwWEhSY2NseHVYSFI5TEZ4eVhHNWNkSEJ5YjJObGMzTlNaWE4xYkhSelVHVnlVR0ZuWlVacFpXeGtPaUJtZFc1amRHbHZiaWdrWTI5dWRHRnBibVZ5S1Z4eVhHNWNkSHRjY2x4dVhIUmNkSFJvYVhNdWNISnZZMlZ6YzBGMWRHaHZjaWdrWTI5dWRHRnBibVZ5S1R0Y2NseHVYSFJjZEZ4eVhHNWNkSDBzWEhKY2JseDBaMlYwUVdOMGFYWmxWR0Y0T2lCbWRXNWpkR2x2Ymlna1ptbGxiR1FwSUh0Y2NseHVYSFJjZEhKbGRIVnliaUIwYUdsekxtRmpkR2wyWlY5MFlYZzdYSEpjYmx4MGZTeGNjbHh1WEhSblpYUlRaV3hsWTNSV1lXdzZJR1oxYm1OMGFXOXVLQ1JtYVdWc1pDbDdYSEpjYmx4eVhHNWNkRngwZG1GeUlHWnBaV3hrVm1Gc0lEMGdYQ0pjSWp0Y2NseHVYSFJjZEZ4eVhHNWNkRngwYVdZb0pHWnBaV3hrTG5aaGJDZ3BJVDB3S1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhSbWFXVnNaRlpoYkNBOUlDUm1hV1ZzWkM1MllXd29LVHRjY2x4dVhIUmNkSDFjY2x4dVhIUmNkRnh5WEc1Y2RGeDBhV1lvWm1sbGJHUldZV3c5UFc1MWJHd3BYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR1pwWld4a1ZtRnNJRDBnWENKY0lqdGNjbHh1WEhSY2RIMWNjbHh1WEhSY2RGeHlYRzVjZEZ4MGNtVjBkWEp1SUdacFpXeGtWbUZzTzF4eVhHNWNkSDBzWEhKY2JseDBaMlYwVFdWMFlWTmxiR1ZqZEZaaGJEb2dablZ1WTNScGIyNG9KR1pwWld4a0tYdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZtRnNJRDBnWENKY0lqdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MFptbGxiR1JXWVd3Z1BTQWtabWxsYkdRdWRtRnNLQ2s3WEhKY2JseDBYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBhV1lvWm1sbGJHUldZV3c5UFc1MWJHd3BYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR1pwWld4a1ZtRnNJRDBnWENKY0lqdGNjbHh1WEhSY2RIMWNjbHh1WEhSY2RGeHlYRzVjZEZ4MGNtVjBkWEp1SUdacFpXeGtWbUZzTzF4eVhHNWNkSDBzWEhKY2JseDBaMlYwVFhWc2RHbFRaV3hsWTNSV1lXdzZJR1oxYm1OMGFXOXVLQ1JtYVdWc1pDd2diM0JsY21GMGIzSXBlMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUjJZWElnWkdWc2FXMGdQU0JjSWl0Y0lqdGNjbHh1WEhSY2RHbG1LRzl3WlhKaGRHOXlQVDFjSW05eVhDSXBYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR1JsYkdsdElEMGdYQ0lzWENJN1hISmNibHgwWEhSOVhISmNibHgwWEhSY2NseHVYSFJjZEdsbUtIUjVjR1Z2Wmlna1ptbGxiR1F1ZG1Gc0tDa3BQVDFjSW05aWFtVmpkRndpS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhScFppZ2tabWxsYkdRdWRtRnNLQ2toUFc1MWJHd3BYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSeVpYUjFjbTRnSkdacFpXeGtMblpoYkNncExtcHZhVzRvWkdWc2FXMHBPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFI5WEhKY2JseDBYSFJjY2x4dVhIUjlMRnh5WEc1Y2RHZGxkRTFsZEdGTmRXeDBhVk5sYkdWamRGWmhiRG9nWm5WdVkzUnBiMjRvSkdacFpXeGtMQ0J2Y0dWeVlYUnZjaWw3WEhKY2JseDBYSFJjY2x4dVhIUmNkSFpoY2lCa1pXeHBiU0E5SUZ3aUxTc3RYQ0k3WEhKY2JseDBYSFJwWmlodmNHVnlZWFJ2Y2owOVhDSnZjbHdpS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhSa1pXeHBiU0E5SUZ3aUxTd3RYQ0k3WEhKY2JseDBYSFI5WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhScFppaDBlWEJsYjJZb0pHWnBaV3hrTG5aaGJDZ3BLVDA5WENKdlltcGxZM1JjSWlsY2NseHVYSFJjZEh0Y2NseHVYSFJjZEZ4MGFXWW9KR1pwWld4a0xuWmhiQ2dwSVQxdWRXeHNLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBkbUZ5SUdacFpXeGtkbUZzSUQwZ1cxMDdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MEpDZ2tabWxsYkdRdWRtRnNLQ2twTG1WaFkyZ29ablZ1WTNScGIyNG9hVzVrWlhnc2RtRnNkV1VwZTF4eVhHNWNkRngwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwWEhSbWFXVnNaSFpoYkM1d2RYTm9LQ2gyWVd4MVpTa3BPMXh5WEc1Y2RGeDBYSFJjZEgwcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEhKbGRIVnliaUJtYVdWc1pIWmhiQzVxYjJsdUtHUmxiR2x0S1R0Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MGZWeHlYRzVjZEZ4MFhISmNibHgwWEhSeVpYUjFjbTRnWENKY0lqdGNjbHh1WEhSY2RGeHlYRzVjZEgwc1hISmNibHgwWjJWMFEyaGxZMnRpYjNoV1lXdzZJR1oxYm1OMGFXOXVLQ1JtYVdWc1pDd2diM0JsY21GMGIzSXBlMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUmNjbHh1WEhSY2RIWmhjaUJtYVdWc1pGWmhiQ0E5SUNSbWFXVnNaQzV0WVhBb1puVnVZM1JwYjI0b0tYdGNjbHh1WEhSY2RGeDBhV1lvSkNoMGFHbHpLUzV3Y205d0tGd2lZMmhsWTJ0bFpGd2lLVDA5ZEhKMVpTbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhKbGRIVnliaUFrS0hSb2FYTXBMblpoYkNncE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUjlLUzVuWlhRb0tUdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGRtRnlJR1JsYkdsdElEMGdYQ0lyWENJN1hISmNibHgwWEhScFppaHZjR1Z5WVhSdmNqMDlYQ0p2Y2x3aUtWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUmtaV3hwYlNBOUlGd2lMRndpTzF4eVhHNWNkRngwZlZ4eVhHNWNkRngwWEhKY2JseDBYSFJ5WlhSMWNtNGdabWxsYkdSV1lXd3VhbTlwYmloa1pXeHBiU2s3WEhKY2JseDBmU3hjY2x4dVhIUm5aWFJOWlhSaFEyaGxZMnRpYjNoV1lXdzZJR1oxYm1OMGFXOXVLQ1JtYVdWc1pDd2diM0JsY21GMGIzSXBlMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUmNjbHh1WEhSY2RIWmhjaUJtYVdWc1pGWmhiQ0E5SUNSbWFXVnNaQzV0WVhBb1puVnVZM1JwYjI0b0tYdGNjbHh1WEhSY2RGeDBhV1lvSkNoMGFHbHpLUzV3Y205d0tGd2lZMmhsWTJ0bFpGd2lLVDA5ZEhKMVpTbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhKbGRIVnliaUFvSkNoMGFHbHpLUzUyWVd3b0tTazdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkSDBwTG1kbGRDZ3BPMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUjJZWElnWkdWc2FXMGdQU0JjSWkwckxWd2lPMXh5WEc1Y2RGeDBhV1lvYjNCbGNtRjBiM0k5UFZ3aWIzSmNJaWxjY2x4dVhIUmNkSHRjY2x4dVhIUmNkRngwWkdWc2FXMGdQU0JjSWkwc0xWd2lPMXh5WEc1Y2RGeDBmVnh5WEc1Y2RGeDBYSEpjYmx4MFhIUnlaWFIxY200Z1ptbGxiR1JXWVd3dWFtOXBiaWhrWld4cGJTazdYSEpjYmx4MGZTeGNjbHh1WEhSblpYUlNZV1JwYjFaaGJEb2dablZ1WTNScGIyNG9KR1pwWld4a0tYdGNjbHh1WEhSY2RGeDBYSFJjZEZ4MFhIUmNjbHh1WEhSY2RIWmhjaUJtYVdWc1pGWmhiQ0E5SUNSbWFXVnNaQzV0WVhBb1puVnVZM1JwYjI0b0tWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUnBaaWdrS0hSb2FYTXBMbkJ5YjNBb1hDSmphR1ZqYTJWa1hDSXBQVDEwY25WbEtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwY21WMGRYSnVJQ1FvZEdocGN5a3VkbUZzS0NrN1hISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RGeDBYSEpjYmx4MFhIUjlLUzVuWlhRb0tUdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MFhISmNibHgwWEhScFppaG1hV1ZzWkZaaGJGc3dYU0U5TUNsY2NseHVYSFJjZEh0Y2NseHVYSFJjZEZ4MGNtVjBkWEp1SUdacFpXeGtWbUZzV3pCZE8xeHlYRzVjZEZ4MGZWeHlYRzVjZEgwc1hISmNibHgwWjJWMFRXVjBZVkpoWkdsdlZtRnNPaUJtZFc1amRHbHZiaWdrWm1sbGJHUXBlMXh5WEc1Y2RGeDBYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBkbUZ5SUdacFpXeGtWbUZzSUQwZ0pHWnBaV3hrTG0xaGNDaG1kVzVqZEdsdmJpZ3BYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR2xtS0NRb2RHaHBjeWt1Y0hKdmNDaGNJbU5vWldOclpXUmNJaWs5UFhSeWRXVXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSeVpYUjFjbTRnSkNoMGFHbHpLUzUyWVd3b0tUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJjY2x4dVhIUmNkSDBwTG1kbGRDZ3BPMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUnlaWFIxY200Z1ptbGxiR1JXWVd4Yk1GMDdYSEpjYmx4MGZTeGNjbHh1WEhSd2NtOWpaWE56UVhWMGFHOXlPaUJtZFc1amRHbHZiaWdrWTI5dWRHRnBibVZ5S1Z4eVhHNWNkSHRjY2x4dVhIUmNkSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhSY2RGeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdabWxsYkdSVWVYQmxJRDBnSkdOdmJuUmhhVzVsY2k1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMTBlWEJsWENJcE8xeHlYRzVjZEZ4MGRtRnlJR2x1Y0hWMFZIbHdaU0E5SUNSamIyNTBZV2x1WlhJdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRhVzV3ZFhRdGRIbHdaVndpS1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwZG1GeUlDUm1hV1ZzWkR0Y2NseHVYSFJjZEhaaGNpQm1hV1ZzWkU1aGJXVWdQU0JjSWx3aU8xeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZtRnNJRDBnWENKY0lqdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGFXWW9hVzV3ZFhSVWVYQmxQVDFjSW5ObGJHVmpkRndpS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhRa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENKelpXeGxZM1JjSWlrN1hISmNibHgwWEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2NseHVYSFJjZEZ4MFhISmNibHgwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUlRaV3hsWTNSV1lXd29KR1pwWld4a0tUc2dYSEpjYmx4MFhIUjlYSEpjYmx4MFhIUmxiSE5sSUdsbUtHbHVjSFYwVkhsd1pUMDlYQ0p0ZFd4MGFYTmxiR1ZqZEZ3aUtWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUWtabWxsYkdRZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSnpaV3hsWTNSY0lpazdYSEpjYmx4MFhIUmNkR1pwWld4a1RtRnRaU0E5SUNSbWFXVnNaQzVoZEhSeUtGd2libUZ0WlZ3aUtTNXlaWEJzWVdObEtDZGJYU2NzSUNjbktUdGNjbHh1WEhSY2RGeDBkbUZ5SUc5d1pYSmhkRzl5SUQwZ0pHWnBaV3hrTG1GMGRISW9YQ0prWVhSaExXOXdaWEpoZEc5eVhDSXBPMXh5WEc1Y2RGeDBYSFJjY2x4dVhIUmNkRngwWm1sbGJHUldZV3dnUFNCelpXeG1MbWRsZEUxMWJIUnBVMlZzWldOMFZtRnNLQ1JtYVdWc1pDd2dYQ0p2Y2x3aUtUdGNjbHh1WEhSY2RGeDBYSEpjYmx4MFhIUjlYSEpjYmx4MFhIUmxiSE5sSUdsbUtHbHVjSFYwVkhsd1pUMDlYQ0pqYUdWamEySnZlRndpS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhRa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENKMWJDQStJR3hwSUdsdWNIVjBPbU5vWldOclltOTRYQ0lwTzF4eVhHNWNkRngwWEhSY2NseHVYSFJjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQ0d0tWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWm1sbGJHUk9ZVzFsSUQwZ0pHWnBaV3hrTG1GMGRISW9YQ0p1WVcxbFhDSXBMbkpsY0d4aFkyVW9KMXRkSnl3Z0p5Y3BPMXh5WEc1Y2RGeDBYSFJjZEZ4MFhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkSFpoY2lCdmNHVnlZWFJ2Y2lBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0lqNGdkV3hjSWlrdVlYUjBjaWhjSW1SaGRHRXRiM0JsY21GMGIzSmNJaWs3WEhKY2JseDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQnpaV3htTG1kbGRFTm9aV05yWW05NFZtRnNLQ1JtYVdWc1pDd2dYQ0p2Y2x3aUtUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJjY2x4dVhIUmNkSDFjY2x4dVhIUmNkR1ZzYzJVZ2FXWW9hVzV3ZFhSVWVYQmxQVDFjSW5KaFpHbHZYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEZ4eVhHNWNkRngwWEhRa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENKMWJDQStJR3hwSUdsdWNIVjBPbkpoWkdsdlhDSXBPMXh5WEc1Y2RGeDBYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBhV1lvSkdacFpXeGtMbXhsYm1kMGFENHdLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFptbGxiR1JPWVcxbElEMGdKR1pwWld4a0xtRjBkSElvWENKdVlXMWxYQ0lwTG5KbGNHeGhZMlVvSjF0ZEp5d2dKeWNwTzF4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkR1pwWld4a1ZtRnNJRDBnYzJWc1ppNW5aWFJTWVdScGIxWmhiQ2drWm1sbGJHUXBPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFI5WEhKY2JseDBYSFJjY2x4dVhIUmNkR2xtS0hSNWNHVnZaaWhtYVdWc1pGWmhiQ2toUFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR2xtS0dacFpXeGtWbUZzSVQxY0lsd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MGRtRnlJR1pwWld4a1UyeDFaeUE5SUZ3aVhDSTdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGFXWW9abWxsYkdST1lXMWxQVDFjSWw5elpsOWhkWFJvYjNKY0lpbGNjbHh1WEhSY2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkZOc2RXY2dQU0JjSW1GMWRHaHZjbk5jSWp0Y2NseHVYSFJjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkRngwWld4elpTQnBaaWhtYVdWc1pFNWhiV1U5UFZ3aVgzTm1YM052Y25SZmIzSmtaWEpjSWlsY2NseHVYSFJjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWEhSbWFXVnNaRk5zZFdjZ1BTQmNJbk52Y25SZmIzSmtaWEpjSWp0Y2NseHVYSFJjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkRngwWld4elpTQnBaaWhtYVdWc1pFNWhiV1U5UFZ3aVgzTm1YM0J3Y0Z3aUtWeHlYRzVjZEZ4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2RHWnBaV3hrVTJ4MVp5QTlJRndpWDNObVgzQndjRndpTzF4eVhHNWNkRngwWEhSY2RIMWNjbHh1WEhSY2RGeDBYSFJsYkhObElHbG1LR1pwWld4a1RtRnRaVDA5WENKZmMyWmZjRzl6ZEY5MGVYQmxYQ0lwWEhKY2JseDBYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkRngwWm1sbGJHUlRiSFZuSUQwZ1hDSndiM04wWDNSNWNHVnpYQ0k3WEhKY2JseDBYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNkR1ZzYzJWY2NseHVYSFJjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEdsbUtHWnBaV3hrVTJ4MVp5RTlYQ0pjSWlsY2NseHVYSFJjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWEhRdkwzTmxiR1l1ZFhKc1gyTnZiWEJ2Ym1WdWRITWdLejBnWENJbVhDSXJabWxsYkdSVGJIVm5LMXdpUFZ3aUsyWnBaV3hrVm1Gc08xeHlYRzVjZEZ4MFhIUmNkRngwYzJWc1ppNTFjbXhmY0dGeVlXMXpXMlpwWld4a1UyeDFaMTBnUFNCbWFXVnNaRlpoYkR0Y2NseHVYSFJjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkSDFjY2x4dVhIUmNkRnh5WEc1Y2RIMHNYSEpjYmx4MGNISnZZMlZ6YzFCdmMzUlVlWEJsSURvZ1puVnVZM1JwYjI0b0pIUm9hWE1wZTF4eVhHNWNkRngwWEhKY2JseDBYSFIwYUdsekxuQnliMk5sYzNOQmRYUm9iM0lvSkhSb2FYTXBPMXh5WEc1Y2RGeDBYSEpjYmx4MGZTeGNjbHh1WEhSd2NtOWpaWE56VUc5emRFMWxkR0U2SUdaMWJtTjBhVzl1S0NSamIyNTBZV2x1WlhJcFhISmNibHgwZTF4eVhHNWNkRngwZG1GeUlITmxiR1lnUFNCMGFHbHpPMXh5WEc1Y2RGeDBYSEpjYmx4MFhIUjJZWElnWm1sbGJHUlVlWEJsSUQwZ0pHTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzEwZVhCbFhDSXBPMXh5WEc1Y2RGeDBkbUZ5SUdsdWNIVjBWSGx3WlNBOUlDUmpiMjUwWVdsdVpYSXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0YVc1d2RYUXRkSGx3WlZ3aUtUdGNjbHh1WEhSY2RIWmhjaUJ0WlhSaFZIbHdaU0E5SUNSamIyNTBZV2x1WlhJdVlYUjBjaWhjSW1SaGRHRXRjMll0YldWMFlTMTBlWEJsWENJcE8xeHlYRzVjY2x4dVhIUmNkSFpoY2lCbWFXVnNaRlpoYkNBOUlGd2lYQ0k3WEhKY2JseDBYSFIyWVhJZ0pHWnBaV3hrTzF4eVhHNWNkRngwZG1GeUlHWnBaV3hrVG1GdFpTQTlJRndpWENJN1hISmNibHgwWEhSY2NseHVYSFJjZEdsbUtHMWxkR0ZVZVhCbFBUMWNJbTUxYldKbGNsd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFJwWmlocGJuQjFkRlI1Y0dVOVBWd2ljbUZ1WjJVdGJuVnRZbVZ5WENJcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFFrWm1sbGJHUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0l1YzJZdGJXVjBZUzF5WVc1blpTMXVkVzFpWlhJZ2FXNXdkWFJjSWlrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwZG1GeUlIWmhiSFZsY3lBOUlGdGRPMXh5WEc1Y2RGeDBYSFJjZENSbWFXVnNaQzVsWVdOb0tHWjFibU4wYVc5dUtDbDdYSEpjYmx4MFhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUmNkSFpoYkhWbGN5NXdkWE5vS0NRb2RHaHBjeWt1ZG1Gc0tDa3BPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RIMHBPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdkbUZzZFdWekxtcHZhVzRvWENJclhDSXBPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSY2RHVnNjMlVnYVdZb2FXNXdkWFJVZVhCbFBUMWNJbkpoYm1kbExYTnNhV1JsY2x3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwSkdacFpXeGtJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpTG5ObUxXMWxkR0V0Y21GdVoyVXRjMnhwWkdWeUlHbHVjSFYwWENJcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEM4dloyVjBJR0Z1ZVNCdWRXMWlaWElnWm05eWJXRjBkR2x1WnlCemRIVm1abHh5WEc1Y2RGeDBYSFJjZEhaaGNpQWtiV1YwWVY5eVlXNW5aU0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSWk1elppMXRaWFJoTFhKaGJtZGxMWE5zYVdSbGNsd2lLVHRjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUjJZWElnWkdWamFXMWhiRjl3YkdGalpYTWdQU0FrYldWMFlWOXlZVzVuWlM1aGRIUnlLRndpWkdGMFlTMWtaV05wYldGc0xYQnNZV05sYzF3aUtUdGNjbHh1WEhSY2RGeDBYSFIyWVhJZ2RHaHZkWE5oYm1SZmMyVndaWEpoZEc5eUlEMGdKRzFsZEdGZmNtRnVaMlV1WVhSMGNpaGNJbVJoZEdFdGRHaHZkWE5oYm1RdGMyVndaWEpoZEc5eVhDSXBPMXh5WEc1Y2RGeDBYSFJjZEhaaGNpQmtaV05wYldGc1gzTmxjR1Z5WVhSdmNpQTlJQ1J0WlhSaFgzSmhibWRsTG1GMGRISW9YQ0prWVhSaExXUmxZMmx0WVd3dGMyVndaWEpoZEc5eVhDSXBPMXh5WEc1Y2NseHVYSFJjZEZ4MFhIUjJZWElnWm1sbGJHUmZabTl5YldGMElEMGdkMDUxYldJb2UxeHlYRzVjZEZ4MFhIUmNkRngwYldGeWF6b2daR1ZqYVcxaGJGOXpaWEJsY21GMGIzSXNYSEpjYmx4MFhIUmNkRngwWEhSa1pXTnBiV0ZzY3pvZ2NHRnljMlZHYkc5aGRDaGtaV05wYldGc1gzQnNZV05sY3lrc1hISmNibHgwWEhSY2RGeDBYSFIwYUc5MWMyRnVaRG9nZEdodmRYTmhibVJmYzJWd1pYSmhkRzl5WEhKY2JseDBYSFJjZEZ4MGZTazdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGRtRnlJSFpoYkhWbGN5QTlJRnRkTzF4eVhHNWNjbHh1WEhKY2JseDBYSFJjZEZ4MGRtRnlJSE5zYVdSbGNsOXZZbXBsWTNRZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSXViV1YwWVMxemJHbGtaWEpjSWlsYk1GMDdYSEpjYmx4MFhIUmNkRngwTHk5MllXd2dabkp2YlNCemJHbGtaWElnYjJKcVpXTjBYSEpjYmx4MFhIUmNkRngwZG1GeUlITnNhV1JsY2w5MllXd2dQU0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSXVaMlYwS0NrN1hISmNibHh5WEc1Y2RGeDBYSFJjZEhaaGJIVmxjeTV3ZFhOb0tHWnBaV3hrWDJadmNtMWhkQzVtY205dEtITnNhV1JsY2w5MllXeGJNRjBwS1R0Y2NseHVYSFJjZEZ4MFhIUjJZV3gxWlhNdWNIVnphQ2htYVdWc1pGOW1iM0p0WVhRdVpuSnZiU2h6Ykdsa1pYSmZkbUZzV3pGZEtTazdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQjJZV3gxWlhNdWFtOXBiaWhjSWl0Y0lpazdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFptbGxiR1JPWVcxbElEMGdKRzFsZEdGZmNtRnVaMlV1WVhSMGNpaGNJbVJoZEdFdGMyWXRabWxsYkdRdGJtRnRaVndpS1R0Y2NseHVYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwWEhSbGJITmxJR2xtS0dsdWNIVjBWSGx3WlQwOVhDSnlZVzVuWlMxeVlXUnBiMXdpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2lMbk5tTFdsdWNIVjBMWEpoYm1kbExYSmhaR2x2WENJcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEdsbUtDUm1hV1ZzWkM1c1pXNW5kR2c5UFRBcFhISmNibHgwWEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEZ4MEx5OTBhR1Z1SUhSeWVTQmhaMkZwYml3Z2QyVWdiWFZ6ZENCaVpTQjFjMmx1WnlCaElITnBibWRzWlNCbWFXVnNaRnh5WEc1Y2RGeDBYSFJjZEZ4MEpHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aVBpQjFiRndpS1R0Y2NseHVYSFJjZEZ4MFhIUjlYSEpjYmx4eVhHNWNkRngwWEhSY2RIWmhjaUFrYldWMFlWOXlZVzVuWlNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0lpNXpaaTF0WlhSaExYSmhibWRsWENJcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEM4dmRHaGxjbVVnYVhNZ1lXNGdaV3hsYldWdWRDQjNhWFJvSUdFZ1puSnZiUzkwYnlCamJHRnpjeUF0SUhOdklIZGxJRzVsWldRZ2RHOGdaMlYwSUhSb1pTQjJZV3gxWlhNZ2IyWWdkR2hsSUdaeWIyMGdKaUIwYnlCcGJuQjFkQ0JtYVdWc1pITWdjMlZ3WlhKaGRHVnNlVnh5WEc1Y2RGeDBYSFJjZEdsbUtDUm1hV1ZzWkM1c1pXNW5kR2crTUNsY2NseHVYSFJjZEZ4MFhIUjdYSFJjY2x4dVhIUmNkRngwWEhSY2RIWmhjaUJtYVdWc1pGOTJZV3h6SUQwZ1cxMDdYSEpjYmx4MFhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUmNkQ1JtYVdWc1pDNWxZV05vS0daMWJtTjBhVzl1S0NsN1hISmNibHgwWEhSY2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RGeDBYSFIyWVhJZ0pISmhaR2x2Y3lBOUlDUW9kR2hwY3lrdVptbHVaQ2hjSWk1elppMXBibkIxZEMxeVlXUnBiMXdpS1R0Y2NseHVYSFJjZEZ4MFhIUmNkRngwWm1sbGJHUmZkbUZzY3k1d2RYTm9LSE5sYkdZdVoyVjBUV1YwWVZKaFpHbHZWbUZzS0NSeVlXUnBiM01wS1R0Y2NseHVYSFJjZEZ4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFhIUjlLVHRjY2x4dVhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkRngwTHk5d2NtVjJaVzUwSUhObFkyOXVaQ0J1ZFcxaVpYSWdabkp2YlNCaVpXbHVaeUJzYjNkbGNpQjBhR0Z1SUhSb1pTQm1hWEp6ZEZ4eVhHNWNkRngwWEhSY2RGeDBhV1lvWm1sbGJHUmZkbUZzY3k1c1pXNW5kR2c5UFRJcFhISmNibHgwWEhSY2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFhIUmNkR2xtS0U1MWJXSmxjaWhtYVdWc1pGOTJZV3h6V3pGZEtUeE9kVzFpWlhJb1ptbGxiR1JmZG1Gc2Mxc3dYU2twWEhKY2JseDBYSFJjZEZ4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2RGeDBYSFJtYVdWc1pGOTJZV3h6V3pGZElEMGdabWxsYkdSZmRtRnNjMXN3WFR0Y2NseHVYSFJjZEZ4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pGWmhiQ0E5SUdacFpXeGtYM1poYkhNdWFtOXBiaWhjSWl0Y0lpazdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2RGeDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBhV1lvSkdacFpXeGtMbXhsYm1kMGFEMDlNU2xjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1Wm1sdVpDaGNJaTV6WmkxcGJuQjFkQzF5WVdScGIxd2lLUzVoZEhSeUtGd2libUZ0WlZ3aUtTNXlaWEJzWVdObEtDZGJYU2NzSUNjbktUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEZ4MFpXeHpaVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1RtRnRaU0E5SUNSdFpYUmhYM0poYm1kbExtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMVzVoYldWY0lpazdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObElHbG1LR2x1Y0hWMFZIbHdaVDA5WENKeVlXNW5aUzF6Wld4bFkzUmNJaWxjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0lpNXpaaTFwYm5CMWRDMXpaV3hsWTNSY0lpazdYSEpjYmx4MFhIUmNkRngwZG1GeUlDUnRaWFJoWDNKaGJtZGxJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpTG5ObUxXMWxkR0V0Y21GdVoyVmNJaWs3WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBMeTkwYUdWeVpTQnBjeUJoYmlCbGJHVnRaVzUwSUhkcGRHZ2dZU0JtY205dEwzUnZJR05zWVhOeklDMGdjMjhnZDJVZ2JtVmxaQ0IwYnlCblpYUWdkR2hsSUhaaGJIVmxjeUJ2WmlCMGFHVWdabkp2YlNBbUlIUnZJR2x1Y0hWMElHWnBaV3hrY3lCelpYQmxjbUYwWld4NVhISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDR3S1Z4eVhHNWNkRngwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjZEhaaGNpQm1hV1ZzWkY5MllXeHpJRDBnVzEwN1hISmNibHgwWEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSY2RDUm1hV1ZzWkM1bFlXTm9LR1oxYm1OMGFXOXVLQ2w3WEhKY2JseDBYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEZ4MFhIUjJZWElnSkhSb2FYTWdQU0FrS0hSb2FYTXBPMXh5WEc1Y2RGeDBYSFJjZEZ4MFhIUm1hV1ZzWkY5MllXeHpMbkIxYzJnb2MyVnNaaTVuWlhSTlpYUmhVMlZzWldOMFZtRnNLQ1IwYUdsektTazdYSEpjYmx4MFhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkRngwZlNrN1hISmNibHgwWEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSY2RDOHZjSEpsZG1WdWRDQnpaV052Ym1RZ2JuVnRZbVZ5SUdaeWIyMGdZbVZwYm1jZ2JHOTNaWElnZEdoaGJpQjBhR1VnWm1seWMzUmNjbHh1WEhSY2RGeDBYSFJjZEdsbUtHWnBaV3hrWDNaaGJITXViR1Z1WjNSb1BUMHlLVnh5WEc1Y2RGeDBYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkRngwWEhScFppaE9kVzFpWlhJb1ptbGxiR1JmZG1Gc2Mxc3hYU2s4VG5WdFltVnlLR1pwWld4a1gzWmhiSE5iTUYwcEtWeHlYRzVjZEZ4MFhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFJjZEZ4MFptbGxiR1JmZG1Gc2Mxc3hYU0E5SUdacFpXeGtYM1poYkhOYk1GMDdYSEpjYmx4MFhIUmNkRngwWEhSY2RIMWNjbHh1WEhSY2RGeDBYSFJjZEgxY2NseHVYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pGWmhiQ0E5SUdacFpXeGtYM1poYkhNdWFtOXBiaWhjSWl0Y0lpazdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2RGeDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBhV1lvSkdacFpXeGtMbXhsYm1kMGFEMDlNU2xjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbTVoYldWY0lpa3VjbVZ3YkdGalpTZ25XMTBuTENBbkp5azdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2RHVnNjMlZjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa2JXVjBZVjl5WVc1blpTNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzF1WVcxbFhDSXBPMXh5WEc1Y2RGeDBYSFJjZEgxY2NseHVYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObElHbG1LR2x1Y0hWMFZIbHdaVDA5WENKeVlXNW5aUzFqYUdWamEySnZlRndpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2lkV3dnUGlCc2FTQnBibkIxZERwamFHVmphMkp2ZUZ3aUtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhScFppZ2tabWxsYkdRdWJHVnVaM1JvUGpBcFhISmNibHgwWEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQnpaV3htTG1kbGRFTm9aV05yWW05NFZtRnNLQ1JtYVdWc1pDd2dYQ0poYm1SY0lpazdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSY2RGeHlYRzVjZEZ4MFhIUnBaaWhtYVdWc1pFNWhiV1U5UFZ3aVhDSXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSbWFXVnNaRTVoYldVZ1BTQWtabWxsYkdRdVlYUjBjaWhjSW01aGJXVmNJaWt1Y21Wd2JHRmpaU2duVzEwbkxDQW5KeWs3WEhKY2JseDBYSFJjZEgxY2NseHVYSFJjZEgxY2NseHVYSFJjZEdWc2MyVWdhV1lvYldWMFlWUjVjR1U5UFZ3aVkyaHZhV05sWENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHbG1LR2x1Y0hWMFZIbHdaVDA5WENKelpXeGxZM1JjSWlsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkQ1JtYVdWc1pDQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJbk5sYkdWamRGd2lLVHRjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJSE5sYkdZdVoyVjBUV1YwWVZObGJHVmpkRlpoYkNna1ptbGxiR1FwT3lCY2NseHVYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObElHbG1LR2x1Y0hWMFZIbHdaVDA5WENKdGRXeDBhWE5sYkdWamRGd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MEpHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aWMyVnNaV04wWENJcE8xeHlYRzVjZEZ4MFhIUmNkSFpoY2lCdmNHVnlZWFJ2Y2lBOUlDUm1hV1ZzWkM1aGRIUnlLRndpWkdGMFlTMXZjR1Z5WVhSdmNsd2lLVHRjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJSE5sYkdZdVoyVjBUV1YwWVUxMWJIUnBVMlZzWldOMFZtRnNLQ1JtYVdWc1pDd2diM0JsY21GMGIzSXBPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEdWc2MyVWdhV1lvYVc1d2RYUlVlWEJsUFQxY0ltTm9aV05yWW05NFhDSXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhRa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENKMWJDQStJR3hwSUdsdWNIVjBPbU5vWldOclltOTRYQ0lwTzF4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkR2xtS0NSbWFXVnNaQzVzWlc1bmRHZytNQ2xjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFIyWVhJZ2IzQmxjbUYwYjNJZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSStJSFZzWENJcExtRjBkSElvWENKa1lYUmhMVzl3WlhKaGRHOXlYQ0lwTzF4eVhHNWNkRngwWEhSY2RGeDBabWxsYkdSV1lXd2dQU0J6Wld4bUxtZGxkRTFsZEdGRGFHVmphMkp2ZUZaaGJDZ2tabWxsYkdRc0lHOXdaWEpoZEc5eUtUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEgxY2NseHVYSFJjZEZ4MFpXeHpaU0JwWmlocGJuQjFkRlI1Y0dVOVBWd2ljbUZrYVc5Y0lpbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5Wc0lENGdiR2tnYVc1d2RYUTZjbUZrYVc5Y0lpazdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQ0d0tWeHlYRzVjZEZ4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUk5aWFJoVW1Ga2FXOVdZV3dvSkdacFpXeGtLVHRjY2x4dVhIUmNkRngwWEhSOVhISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RGeDBYSEpjYmx4MFhIUmNkR1pwWld4a1ZtRnNJRDBnWlc1amIyUmxWVkpKUTI5dGNHOXVaVzUwS0dacFpXeGtWbUZzS1R0Y2NseHVYSFJjZEZ4MGFXWW9kSGx3Wlc5bUtDUm1hV1ZzWkNraFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBhV1lvSkdacFpXeGtMbXhsYm1kMGFENHdLVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1RtRnRaU0E5SUNSbWFXVnNaQzVoZEhSeUtGd2libUZ0WlZ3aUtTNXlaWEJzWVdObEtDZGJYU2NzSUNjbktUdGNjbHh1WEhSY2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RGeDBMeTltYjNJZ2RHaHZjMlVnZDJodklHbHVjMmx6ZENCdmJpQjFjMmx1WnlBbUlHRnRjR1Z5YzJGdVpITWdhVzRnZEdobElHNWhiV1VnYjJZZ2RHaGxJR04xYzNSdmJTQm1hV1ZzWkNBb0lTbGNjbHh1WEhSY2RGeDBYSFJjZEdacFpXeGtUbUZ0WlNBOUlDaG1hV1ZzWkU1aGJXVXBPMXh5WEc1Y2RGeDBYSFJjZEgxY2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RIMWNjbHh1WEhSY2RHVnNjMlVnYVdZb2JXVjBZVlI1Y0dVOVBWd2laR0YwWlZ3aUtWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUnpaV3htTG5CeWIyTmxjM05RYjNOMFJHRjBaU2drWTI5dWRHRnBibVZ5S1R0Y2NseHVYSFJjZEgxY2NseHVYSFJjZEZ4eVhHNWNkRngwYVdZb2RIbHdaVzltS0dacFpXeGtWbUZzS1NFOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dVhIUmNkSHRjY2x4dVhIUmNkRngwYVdZb1ptbGxiR1JXWVd3aFBWd2lYQ0lwWEhKY2JseDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUXZMM05sYkdZdWRYSnNYMk52YlhCdmJtVnVkSE1nS3owZ1hDSW1YQ0lyWlc1amIyUmxWVkpKUTI5dGNHOXVaVzUwS0dacFpXeGtUbUZ0WlNrclhDSTlYQ0lyS0dacFpXeGtWbUZzS1R0Y2NseHVYSFJjZEZ4MFhIUnpaV3htTG5WeWJGOXdZWEpoYlhOYlpXNWpiMlJsVlZKSlEyOXRjRzl1Wlc1MEtHWnBaV3hrVG1GdFpTbGRJRDBnS0dacFpXeGtWbUZzS1R0Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MGZWeHlYRzVjZEgwc1hISmNibHgwY0hKdlkyVnpjMUJ2YzNSRVlYUmxPaUJtZFc1amRHbHZiaWdrWTI5dWRHRnBibVZ5S1Z4eVhHNWNkSHRjY2x4dVhIUmNkSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZIbHdaU0E5SUNSamIyNTBZV2x1WlhJdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRkSGx3WlZ3aUtUdGNjbHh1WEhSY2RIWmhjaUJwYm5CMWRGUjVjR1VnUFNBa1kyOXVkR0ZwYm1WeUxtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMV2x1Y0hWMExYUjVjR1ZjSWlrN1hISmNibHgwWEhSY2NseHVYSFJjZEhaaGNpQWtabWxsYkdRN1hISmNibHgwWEhSMllYSWdabWxsYkdST1lXMWxJRDBnWENKY0lqdGNjbHh1WEhSY2RIWmhjaUJtYVdWc1pGWmhiQ0E5SUZ3aVhDSTdYSEpjYmx4MFhIUmNjbHh1WEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0luVnNJRDRnYkdrZ2FXNXdkWFE2ZEdWNGRGd2lLVHRjY2x4dVhIUmNkR1pwWld4a1RtRnRaU0E5SUNSbWFXVnNaQzVoZEhSeUtGd2libUZ0WlZ3aUtTNXlaWEJzWVdObEtDZGJYU2NzSUNjbktUdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGRtRnlJR1JoZEdWeklEMGdXMTA3WEhKY2JseDBYSFFrWm1sbGJHUXVaV0ZqYUNobWRXNWpkR2x2YmlncGUxeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RGeDBaR0YwWlhNdWNIVnphQ2drS0hSb2FYTXBMblpoYkNncEtUdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGZTazdYSEpjYmx4MFhIUmNjbHh1WEhSY2RHbG1LQ1JtYVdWc1pDNXNaVzVuZEdnOVBUSXBYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR2xtS0Noa1lYUmxjMXN3WFNFOVhDSmNJaWw4ZkNoa1lYUmxjMXN4WFNFOVhDSmNJaWtwWEhKY2JseDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJR1JoZEdWekxtcHZhVzRvWENJclhDSXBPMXh5WEc1Y2RGeDBYSFJjZEdacFpXeGtWbUZzSUQwZ1ptbGxiR1JXWVd3dWNtVndiR0ZqWlNndlhGd3ZMMmNzSnljcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUjlYSEpjYmx4MFhIUmxiSE5sSUdsbUtDUm1hV1ZzWkM1c1pXNW5kR2c5UFRFcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHbG1LR1JoZEdWeld6QmRJVDFjSWx3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWm1sbGJHUldZV3dnUFNCa1lYUmxjeTVxYjJsdUtGd2lLMXdpS1R0Y2NseHVYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJR1pwWld4a1ZtRnNMbkpsY0d4aFkyVW9MMXhjTHk5bkxDY25LVHRjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwZlZ4eVhHNWNkRngwWEhKY2JseDBYSFJwWmloMGVYQmxiMllvWm1sbGJHUldZV3dwSVQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFJwWmlobWFXVnNaRlpoYkNFOVhDSmNJaWxjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RIWmhjaUJtYVdWc1pGTnNkV2NnUFNCY0lsd2lPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RHbG1LR1pwWld4a1RtRnRaVDA5WENKZmMyWmZjRzl6ZEY5a1lYUmxYQ0lwWEhKY2JseDBYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkRngwWm1sbGJHUlRiSFZuSUQwZ1hDSndiM04wWDJSaGRHVmNJanRjY2x4dVhIUmNkRngwWEhSOVhISmNibHgwWEhSY2RGeDBaV3h6WlZ4eVhHNWNkRngwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjZEdacFpXeGtVMngxWnlBOUlHWnBaV3hrVG1GdFpUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBhV1lvWm1sbGJHUlRiSFZuSVQxY0lsd2lLVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkQzh2YzJWc1ppNTFjbXhmWTI5dGNHOXVaVzUwY3lBclBTQmNJaVpjSWl0bWFXVnNaRk5zZFdjclhDSTlYQ0lyWm1sbGJHUldZV3c3WEhKY2JseDBYSFJjZEZ4MFhIUnpaV3htTG5WeWJGOXdZWEpoYlhOYlptbGxiR1JUYkhWblhTQTlJR1pwWld4a1ZtRnNPMXh5WEc1Y2RGeDBYSFJjZEgxY2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MGZWeHlYRzVjZEZ4MFhISmNibHgwZlN4Y2NseHVYSFJ3Y205alpYTnpWR0Y0YjI1dmJYazZJR1oxYm1OMGFXOXVLQ1JqYjI1MFlXbHVaWElzSUhKbGRIVnlibDl2WW1wbFkzUXBYSEpjYmx4MGUxeHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWh5WlhSMWNtNWZiMkpxWldOMEtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5Ymw5dlltcGxZM1FnUFNCbVlXeHpaVHRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc1Y2RGeDBMeTlwWmlncFhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MEx5OTJZWElnWm1sbGJHUk9ZVzFsSUQwZ0pDaDBhR2x6S1M1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMXVZVzFsWENJcE8xeHlYRzVjZEZ4MGRtRnlJSE5sYkdZZ1BTQjBhR2x6TzF4eVhHNWNkRnh5WEc1Y2RGeDBkbUZ5SUdacFpXeGtWSGx3WlNBOUlDUmpiMjUwWVdsdVpYSXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0ZEhsd1pWd2lLVHRjY2x4dVhIUmNkSFpoY2lCcGJuQjFkRlI1Y0dVZ1BTQWtZMjl1ZEdGcGJtVnlMbUYwZEhJb1hDSmtZWFJoTFhObUxXWnBaV3hrTFdsdWNIVjBMWFI1Y0dWY0lpazdYSEpjYmx4MFhIUmNjbHh1WEhSY2RIWmhjaUFrWm1sbGJHUTdYSEpjYmx4MFhIUjJZWElnWm1sbGJHUk9ZVzFsSUQwZ1hDSmNJanRjY2x4dVhIUmNkSFpoY2lCbWFXVnNaRlpoYkNBOUlGd2lYQ0k3WEhKY2JseDBYSFJjY2x4dVhIUmNkR2xtS0dsdWNIVjBWSGx3WlQwOVhDSnpaV3hsWTNSY0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2ljMlZzWldOMFhDSXBPMXh5WEc1Y2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbTVoYldWY0lpa3VjbVZ3YkdGalpTZ25XMTBuTENBbkp5azdYSEpjYmx4MFhIUmNkRnh5WEc1Y2RGeDBYSFJtYVdWc1pGWmhiQ0E5SUhObGJHWXVaMlYwVTJWc1pXTjBWbUZzS0NSbWFXVnNaQ2s3SUZ4eVhHNWNkRngwZlZ4eVhHNWNkRngwWld4elpTQnBaaWhwYm5CMWRGUjVjR1U5UFZ3aWJYVnNkR2x6Wld4bFkzUmNJaWxjY2x4dVhIUmNkSHRjY2x4dVhIUmNkRngwSkdacFpXeGtJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpYzJWc1pXTjBYQ0lwTzF4eVhHNWNkRngwWEhSbWFXVnNaRTVoYldVZ1BTQWtabWxsYkdRdVlYUjBjaWhjSW01aGJXVmNJaWt1Y21Wd2JHRmpaU2duVzEwbkxDQW5KeWs3WEhKY2JseDBYSFJjZEhaaGNpQnZjR1Z5WVhSdmNpQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aVpHRjBZUzF2Y0dWeVlYUnZjbHdpS1R0Y2NseHVYSFJjZEZ4MFhISmNibHgwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUk5kV3gwYVZObGJHVmpkRlpoYkNna1ptbGxiR1FzSUc5d1pYSmhkRzl5S1R0Y2NseHVYSFJjZEgxY2NseHVYSFJjZEdWc2MyVWdhV1lvYVc1d2RYUlVlWEJsUFQxY0ltTm9aV05yWW05NFhDSXBYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkQ1JtYVdWc1pDQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJblZzSUQ0Z2JHa2dhVzV3ZFhRNlkyaGxZMnRpYjNoY0lpazdYSEpjYmx4MFhIUmNkR2xtS0NSbWFXVnNaQzVzWlc1bmRHZytNQ2xjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RHWnBaV3hrVG1GdFpTQTlJQ1JtYVdWc1pDNWhkSFJ5S0Z3aWJtRnRaVndpS1M1eVpYQnNZV05sS0NkYlhTY3NJQ2NuS1R0Y2NseHVYSFJjZEZ4MFhIUmNkRngwWEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSMllYSWdiM0JsY21GMGIzSWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0krSUhWc1hDSXBMbUYwZEhJb1hDSmtZWFJoTFc5d1pYSmhkRzl5WENJcE8xeHlYRzVjZEZ4MFhIUmNkR1pwWld4a1ZtRnNJRDBnYzJWc1ppNW5aWFJEYUdWamEySnZlRlpoYkNna1ptbGxiR1FzSUc5d1pYSmhkRzl5S1R0Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MGZWeHlYRzVjZEZ4MFpXeHpaU0JwWmlocGJuQjFkRlI1Y0dVOVBWd2ljbUZrYVc5Y0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2lkV3dnUGlCc2FTQnBibkIxZERweVlXUnBiMXdpS1R0Y2NseHVYSFJjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQ0d0tWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWm1sbGJHUk9ZVzFsSUQwZ0pHWnBaV3hrTG1GMGRISW9YQ0p1WVcxbFhDSXBMbkpsY0d4aFkyVW9KMXRkSnl3Z0p5Y3BPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUlNZV1JwYjFaaGJDZ2tabWxsYkdRcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUjlYSEpjYmx4MFhIUmNjbHh1WEhSY2RHbG1LSFI1Y0dWdlppaG1hV1ZzWkZaaGJDa2hQVndpZFc1a1pXWnBibVZrWENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHbG1LR1pwWld4a1ZtRnNJVDFjSWx3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloeVpYUjFjbTVmYjJKcVpXTjBQVDEwY25WbEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCN2JtRnRaVG9nWm1sbGJHUk9ZVzFsTENCMllXeDFaVG9nWm1sbGJHUldZV3g5TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmMyVnNaaTUxY214ZlkyOXRjRzl1Wlc1MGN5QXJQU0JjSWlaY0lpdG1hV1ZzWkU1aGJXVXJYQ0k5WENJclptbGxiR1JXWVd3N1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNTFjbXhmY0dGeVlXMXpXMlpwWld4a1RtRnRaVjBnUFNCbWFXVnNaRlpoYkR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JseDBYSFJjZEgxY2NseHVYSFJjZEgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnYVdZb2NtVjBkWEp1WDI5aWFtVmpkRDA5ZEhKMVpTbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJpQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4MGZWeHlYRzU5T3lKZGZRPT0iLCJcclxubW9kdWxlLmV4cG9ydHMgPSB7XHJcblx0XHJcblx0c2VhcmNoRm9ybXM6IHt9LFxyXG5cdFxyXG5cdGluaXQ6IGZ1bmN0aW9uKCl7XHJcblx0XHRcclxuXHRcdFxyXG5cdH0sXHJcblx0YWRkU2VhcmNoRm9ybTogZnVuY3Rpb24oaWQsIG9iamVjdCl7XHJcblx0XHRcclxuXHRcdHRoaXMuc2VhcmNoRm9ybXNbaWRdID0gb2JqZWN0O1xyXG5cdH0sXHJcblx0Z2V0U2VhcmNoRm9ybTogZnVuY3Rpb24oaWQpXHJcblx0e1xyXG5cdFx0cmV0dXJuIHRoaXMuc2VhcmNoRm9ybXNbaWRdO1x0XHJcblx0fVxyXG5cdFxyXG59OyIsIihmdW5jdGlvbiAoZ2xvYmFsKXtcblxudmFyICQgXHRcdFx0XHQ9ICh0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93WydqUXVlcnknXSA6IHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWxbJ2pRdWVyeSddIDogbnVsbCk7XG5cbm1vZHVsZS5leHBvcnRzID0ge1xuXHRcblx0aW5pdDogZnVuY3Rpb24oKXtcblx0XHQkKGRvY3VtZW50KS5vbihcInNmOmFqYXhmaW5pc2hcIiwgXCIuc2VhcmNoYW5kZmlsdGVyXCIsIGZ1bmN0aW9uKCBlLCBkYXRhICkge1xuXHRcdFx0dmFyIGRpc3BsYXlfbWV0aG9kID0gZGF0YS5vYmplY3QuZGlzcGxheV9yZXN1bHRfbWV0aG9kO1xuXHRcdFx0aWYgKCBkaXNwbGF5X21ldGhvZCA9PT0gJ2N1c3RvbV9lZGRfc3RvcmUnICkge1xuXHRcdFx0XHQkKCdpbnB1dC5lZGQtYWRkLXRvLWNhcnQnKS5jc3MoJ2Rpc3BsYXknLCBcIm5vbmVcIik7XG5cdFx0XHRcdCQoJ2EuZWRkLWFkZC10by1jYXJ0JykuYWRkQ2xhc3MoJ2VkZC1oYXMtanMnKTtcblx0XHRcdH0gZWxzZSBpZiAoIGRpc3BsYXlfbWV0aG9kID09PSAnY3VzdG9tX2xheW91dHMnICkge1xuXHRcdFx0XHRpZiAoICQoJy5jbC1sYXlvdXQnKS5oYXNDbGFzcyggJ2NsLWxheW91dC0tbWFzb25yeScgKSApIHtcblx0XHRcdFx0XHQvL3RoZW4gcmUtaW5pdCBtYXNvbnJ5XG5cdFx0XHRcdFx0Y29uc3QgbWFzb25yeUNvbnRhaW5lciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoICcuY2wtbGF5b3V0LS1tYXNvbnJ5JyApO1xuXHRcdFx0XHRcdGlmICggbWFzb25yeUNvbnRhaW5lci5sZW5ndGggPiAwICkge1xuXHRcdFx0XHRcdFx0Y29uc3QgY3VzdG9tTGF5b3V0R3JpZCA9IG5ldyBNYXNvbnJ5KCAnLmNsLWxheW91dC0tbWFzb25yeScsIHtcblx0XHRcdFx0XHRcdFx0Ly8gb3B0aW9ucy4uLlxuXHRcdFx0XHRcdFx0XHRpdGVtU2VsZWN0b3I6ICcuY2wtbGF5b3V0X19pdGVtJyxcblx0XHRcdFx0XHRcdFx0Ly9jb2x1bW5XaWR0aDogMzE5XG5cdFx0XHRcdFx0XHRcdHBlcmNlbnRQb3NpdGlvbjogdHJ1ZSxcblx0XHRcdFx0XHRcdFx0Ly9ndXR0ZXI6IDEwLFxuXHRcdFx0XHRcdFx0XHR0cmFuc2l0aW9uRHVyYXRpb246IDAsXG5cdFx0XHRcdFx0XHR9ICk7XG5cdFx0XHRcdFx0XHRpbWFnZXNMb2FkZWQoIG1hc29ucnlDb250YWluZXIgKS5vbiggJ3Byb2dyZXNzJywgZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRcdGN1c3RvbUxheW91dEdyaWQubGF5b3V0KCk7XG5cdFx0XHRcdFx0XHR9ICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fSk7XG5cdH0sXG5cbn07XG59KS5jYWxsKHRoaXMsdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbCA6IHR5cGVvZiBzZWxmICE9PSBcInVuZGVmaW5lZFwiID8gc2VsZiA6IHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3cgOiB7fSlcbi8vIyBzb3VyY2VNYXBwaW5nVVJMPWRhdGE6YXBwbGljYXRpb24vanNvbjtjaGFyc2V0OnV0Zi04O2Jhc2U2NCxleUoyWlhKemFXOXVJam96TENKemIzVnlZMlZ6SWpwYkluTnlZeTl3ZFdKc2FXTXZZWE56WlhSekwycHpMMmx1WTJ4MVpHVnpMM1JvYVhKa2NHRnlkSGt1YW5NaVhTd2libUZ0WlhNaU9sdGRMQ0p0WVhCd2FXNW5jeUk2SWp0QlFVRkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CSWl3aVptbHNaU0k2SW1kbGJtVnlZWFJsWkM1cWN5SXNJbk52ZFhKalpWSnZiM1FpT2lJaUxDSnpiM1Z5WTJWelEyOXVkR1Z1ZENJNld5SmNiblpoY2lBa0lGeDBYSFJjZEZ4MFBTQW9kSGx3Wlc5bUlIZHBibVJ2ZHlBaFBUMGdYQ0oxYm1SbFptbHVaV1JjSWlBL0lIZHBibVJ2ZDFzbmFsRjFaWEo1SjEwZ09pQjBlWEJsYjJZZ1oyeHZZbUZzSUNFOVBTQmNJblZ1WkdWbWFXNWxaRndpSUQ4Z1oyeHZZbUZzV3lkcVVYVmxjbmtuWFNBNklHNTFiR3dwTzF4dVhHNXRiMlIxYkdVdVpYaHdiM0owY3lBOUlIdGNibHgwWEc1Y2RHbHVhWFE2SUdaMWJtTjBhVzl1S0NsN1hHNWNkRngwSkNoa2IyTjFiV1Z1ZENrdWIyNG9YQ0p6WmpwaGFtRjRabWx1YVhOb1hDSXNJRndpTG5ObFlYSmphR0Z1WkdacGJIUmxjbHdpTENCbWRXNWpkR2x2YmlnZ1pTd2daR0YwWVNBcElIdGNibHgwWEhSY2RIWmhjaUJrYVhOd2JHRjVYMjFsZEdodlpDQTlJR1JoZEdFdWIySnFaV04wTG1ScGMzQnNZWGxmY21WemRXeDBYMjFsZEdodlpEdGNibHgwWEhSY2RHbG1JQ2dnWkdsemNHeGhlVjl0WlhSb2IyUWdQVDA5SUNkamRYTjBiMjFmWldSa1gzTjBiM0psSnlBcElIdGNibHgwWEhSY2RGeDBKQ2duYVc1d2RYUXVaV1JrTFdGa1pDMTBieTFqWVhKMEp5a3VZM056S0Nka2FYTndiR0Y1Snl3Z1hDSnViMjVsWENJcE8xeHVYSFJjZEZ4MFhIUWtLQ2RoTG1Wa1pDMWhaR1F0ZEc4dFkyRnlkQ2NwTG1Ga1pFTnNZWE56S0NkbFpHUXRhR0Z6TFdwekp5azdYRzVjZEZ4MFhIUjlJR1ZzYzJVZ2FXWWdLQ0JrYVhOd2JHRjVYMjFsZEdodlpDQTlQVDBnSjJOMWMzUnZiVjlzWVhsdmRYUnpKeUFwSUh0Y2JseDBYSFJjZEZ4MGFXWWdLQ0FrS0NjdVkyd3RiR0Y1YjNWMEp5a3VhR0Z6UTJ4aGMzTW9JQ2RqYkMxc1lYbHZkWFF0TFcxaGMyOXVjbmtuSUNrZ0tTQjdYRzVjZEZ4MFhIUmNkRngwTHk5MGFHVnVJSEpsTFdsdWFYUWdiV0Z6YjI1eWVWeHVYSFJjZEZ4MFhIUmNkR052Ym5OMElHMWhjMjl1Y25sRGIyNTBZV2x1WlhJZ1BTQmtiMk4xYldWdWRDNXhkV1Z5ZVZObGJHVmpkRzl5UVd4c0tDQW5MbU5zTFd4aGVXOTFkQzB0YldGemIyNXllU2NnS1R0Y2JseDBYSFJjZEZ4MFhIUnBaaUFvSUcxaGMyOXVjbmxEYjI1MFlXbHVaWEl1YkdWdVozUm9JRDRnTUNBcElIdGNibHgwWEhSY2RGeDBYSFJjZEdOdmJuTjBJR04xYzNSdmJVeGhlVzkxZEVkeWFXUWdQU0J1WlhjZ1RXRnpiMjV5ZVNnZ0p5NWpiQzFzWVhsdmRYUXRMVzFoYzI5dWNua25MQ0I3WEc1Y2RGeDBYSFJjZEZ4MFhIUmNkQzh2SUc5d2RHbHZibk11TGk1Y2JseDBYSFJjZEZ4MFhIUmNkRngwYVhSbGJWTmxiR1ZqZEc5eU9pQW5MbU5zTFd4aGVXOTFkRjlmYVhSbGJTY3NYRzVjZEZ4MFhIUmNkRngwWEhSY2RDOHZZMjlzZFcxdVYybGtkR2c2SURNeE9WeHVYSFJjZEZ4MFhIUmNkRngwWEhSd1pYSmpaVzUwVUc5emFYUnBiMjQ2SUhSeWRXVXNYRzVjZEZ4MFhIUmNkRngwWEhSY2RDOHZaM1YwZEdWeU9pQXhNQ3hjYmx4MFhIUmNkRngwWEhSY2RGeDBkSEpoYm5OcGRHbHZia1IxY21GMGFXOXVPaUF3TEZ4dVhIUmNkRngwWEhSY2RGeDBmU0FwTzF4dVhIUmNkRngwWEhSY2RGeDBhVzFoWjJWelRHOWhaR1ZrS0NCdFlYTnZibko1UTI5dWRHRnBibVZ5SUNrdWIyNG9JQ2R3Y205bmNtVnpjeWNzSUdaMWJtTjBhVzl1S0NrZ2UxeHVYSFJjZEZ4MFhIUmNkRngwWEhSamRYTjBiMjFNWVhsdmRYUkhjbWxrTG14aGVXOTFkQ2dwTzF4dVhIUmNkRngwWEhSY2RGeDBmU0FwTzF4dVhIUmNkRngwWEhSY2RIMWNibHgwWEhSY2RGeDBmVnh1WEhSY2RGeDBmVnh1WEhSY2RIMHBPMXh1WEhSOUxGeHVYRzU5T3lKZGZRPT0iXX0=

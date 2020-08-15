(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){

var fields = require('./includes/fields');
var pagination = require('./includes/pagination');
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

	$.easing.jswing=$.easing.swing;$.extend($.easing,{def:"easeOutQuad",swing:function(e,t,n,r,i){return $.easing[$.easing.def](e,t,n,r,i)},easeInQuad:function(e,t,n,r,i){return r*(t/=i)*t+n},easeOutQuad:function(e,t,n,r,i){return-r*(t/=i)*(t-2)+n},easeInOutQuad:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t+n;return-r/2*(--t*(t-2)-1)+n},easeInCubic:function(e,t,n,r,i){return r*(t/=i)*t*t+n},easeOutCubic:function(e,t,n,r,i){return r*((t=t/i-1)*t*t+1)+n},easeInOutCubic:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t+n;return r/2*((t-=2)*t*t+2)+n},easeInQuart:function(e,t,n,r,i){return r*(t/=i)*t*t*t+n},easeOutQuart:function(e,t,n,r,i){return-r*((t=t/i-1)*t*t*t-1)+n},easeInOutQuart:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t*t+n;return-r/2*((t-=2)*t*t*t-2)+n},easeInQuint:function(e,t,n,r,i){return r*(t/=i)*t*t*t*t+n},easeOutQuint:function(e,t,n,r,i){return r*((t=t/i-1)*t*t*t*t+1)+n},easeInOutQuint:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t*t*t+n;return r/2*((t-=2)*t*t*t*t+2)+n},easeInSine:function(e,t,n,r,i){return-r*Math.cos(t/i*(Math.PI/2))+r+n},easeOutSine:function(e,t,n,r,i){return r*Math.sin(t/i*(Math.PI/2))+n},easeInOutSine:function(e,t,n,r,i){return-r/2*(Math.cos(Math.PI*t/i)-1)+n},easeInExpo:function(e,t,n,r,i){return t==0?n:r*Math.pow(2,10*(t/i-1))+n},easeOutExpo:function(e,t,n,r,i){return t==i?n+r:r*(-Math.pow(2,-10*t/i)+1)+n},easeInOutExpo:function(e,t,n,r,i){if(t==0)return n;if(t==i)return n+r;if((t/=i/2)<1)return r/2*Math.pow(2,10*(t-1))+n;return r/2*(-Math.pow(2,-10*--t)+2)+n},easeInCirc:function(e,t,n,r,i){return-r*(Math.sqrt(1-(t/=i)*t)-1)+n},easeOutCirc:function(e,t,n,r,i){return r*Math.sqrt(1-(t=t/i-1)*t)+n},easeInOutCirc:function(e,t,n,r,i){if((t/=i/2)<1)return-r/2*(Math.sqrt(1-t*t)-1)+n;return r/2*(Math.sqrt(1-(t-=2)*t)+1)+n},easeInElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i)==1)return n+r;if(!o)o=i*.3;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);return-(u*Math.pow(2,10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o))+n},easeOutElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i)==1)return n+r;if(!o)o=i*.3;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);return u*Math.pow(2,-10*t)*Math.sin((t*i-s)*2*Math.PI/o)+r+n},easeInOutElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i/2)==2)return n+r;if(!o)o=i*.3*1.5;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);if(t<1)return-.5*u*Math.pow(2,10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o)+n;return u*Math.pow(2,-10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o)*.5+r+n},easeInBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;return r*(t/=i)*t*((s+1)*t-s)+n},easeOutBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;return r*((t=t/i-1)*t*((s+1)*t+s)+1)+n},easeInOutBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;if((t/=i/2)<1)return r/2*t*t*(((s*=1.525)+1)*t-s)+n;return r/2*((t-=2)*t*(((s*=1.525)+1)*t+s)+2)+n},easeInBounce:function(e,t,n,r,i){return r-$.easing.easeOutBounce(e,i-t,0,r,i)+n},easeOutBounce:function(e,t,n,r,i){if((t/=i)<1/2.75){return r*7.5625*t*t+n}else if(t<2/2.75){return r*(7.5625*(t-=1.5/2.75)*t+.75)+n}else if(t<2.5/2.75){return r*(7.5625*(t-=2.25/2.75)*t+.9375)+n}else{return r*(7.5625*(t-=2.625/2.75)*t+.984375)+n}},easeInOutBounce:function(e,t,n,r,i){if(t<i/2)return $.easing.easeInBounce(e,t*2,0,r,i)*.5+n;return $.easing.easeOutBounce(e,t*2-i,0,r,i)*.5+r*.5+n}})

}(jQuery));

//safari back button fix
jQuery(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        jQuery(".searchandfilter").off();
        jQuery(".searchandfilter").searchAndFilter();
    }
});

/* wpnumb - nouislider number formatting */
!function(){"use strict";function e(e){return e.split("").reverse().join("")}function n(e,n){return e.substring(0,n.length)===n}function r(e,n){return e.slice(-1*n.length)===n}function t(e,n,r){if((e[n]||e[r])&&e[n]===e[r])throw new Error(n)}function i(e){return"number"==typeof e&&isFinite(e)}function o(e,n){var r=Math.pow(10,n);return(Math.round(e*r)/r).toFixed(n)}function u(n,r,t,u,f,a,c,s,p,d,l,h){var g,v,w,m=h,x="",b="";return a&&(h=a(h)),i(h)?(n!==!1&&0===parseFloat(h.toFixed(n))&&(h=0),0>h&&(g=!0,h=Math.abs(h)),n!==!1&&(h=o(h,n)),h=h.toString(),-1!==h.indexOf(".")?(v=h.split("."),w=v[0],t&&(x=t+v[1])):w=h,r&&(w=e(w).match(/.{1,3}/g),w=e(w.join(e(r)))),g&&s&&(b+=s),u&&(b+=u),g&&p&&(b+=p),b+=w,b+=x,f&&(b+=f),d&&(b=d(b,m)),b):!1}function f(e,t,o,u,f,a,c,s,p,d,l,h){var g,v="";return l&&(h=l(h)),h&&"string"==typeof h?(s&&n(h,s)&&(h=h.replace(s,""),g=!0),u&&n(h,u)&&(h=h.replace(u,"")),p&&n(h,p)&&(h=h.replace(p,""),g=!0),f&&r(h,f)&&(h=h.slice(0,-1*f.length)),t&&(h=h.split(t).join("")),o&&(h=h.replace(o,".")),g&&(v+="-"),v+=h,v=v.replace(/[^0-9\.\-.]/g,""),""===v?!1:(v=Number(v),c&&(v=c(v)),i(v)?v:!1)):!1}function a(e){var n,r,i,o={};for(n=0;n<p.length;n+=1)if(r=p[n],i=e[r],void 0===i)"negative"!==r||o.negativeBefore?"mark"===r&&"."!==o.thousand?o[r]=".":o[r]=!1:o[r]="-";else if("decimals"===r){if(!(i>=0&&8>i))throw new Error(r);o[r]=i}else if("encoder"===r||"decoder"===r||"edit"===r||"undo"===r){if("function"!=typeof i)throw new Error(r);o[r]=i}else{if("string"!=typeof i)throw new Error(r);o[r]=i}return t(o,"mark","thousand"),t(o,"prefix","negative"),t(o,"prefix","negativeBefore"),o}function c(e,n,r){var t,i=[];for(t=0;t<p.length;t+=1)i.push(e[p[t]]);return i.push(r),n.apply("",i)}function s(e){return this instanceof s?void("object"==typeof e&&(e=a(e),this.to=function(n){return c(e,u,n)},this.from=function(n){return c(e,f,n)})):new s(e)}var p=["decimals","thousand","mark","prefix","postfix","encoder","decoder","negativeBefore","negative","edit","undo"];window.wNumb=s}();


},{"./includes/fields":4,"./includes/pagination":5,"./includes/plugin":6,"./includes/state":8}],2:[function(require,module,exports){
/*!
 * JavaScript Cookie v2.2.0
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
	var registeredInModuleLoader = false;
	if (typeof define === 'function' && define.amd) {
		define(factory);
		registeredInModuleLoader = true;
	}
	if (typeof exports === 'object') {
		module.exports = factory();
		registeredInModuleLoader = true;
	}
	if (!registeredInModuleLoader) {
		var OldCookies = window.Cookies;
		var api = window.Cookies = factory();
		api.noConflict = function () {
			window.Cookies = OldCookies;
			return api;
		};
	}
}(function () {
	function extend () {
		var i = 0;
		var result = {};
		for (; i < arguments.length; i++) {
			var attributes = arguments[ i ];
			for (var key in attributes) {
				result[key] = attributes[key];
			}
		}
		return result;
	}

	function init (converter) {
		function api (key, value, attributes) {
			var result;
			if (typeof document === 'undefined') {
				return;
			}

			// Write

			if (arguments.length > 1) {
				attributes = extend({
					path: '/'
				}, api.defaults, attributes);

				if (typeof attributes.expires === 'number') {
					var expires = new Date();
					expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
					attributes.expires = expires;
				}

				// We're using "expires" because "max-age" is not supported by IE
				attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

				try {
					result = JSON.stringify(value);
					if (/^[\{\[]/.test(result)) {
						value = result;
					}
				} catch (e) {}

				if (!converter.write) {
					value = encodeURIComponent(String(value))
						.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
				} else {
					value = converter.write(value, key);
				}

				key = encodeURIComponent(String(key));
				key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
				key = key.replace(/[\(\)]/g, escape);

				var stringifiedAttributes = '';

				for (var attributeName in attributes) {
					if (!attributes[attributeName]) {
						continue;
					}
					stringifiedAttributes += '; ' + attributeName;
					if (attributes[attributeName] === true) {
						continue;
					}
					stringifiedAttributes += '=' + attributes[attributeName];
				}
				return (document.cookie = key + '=' + value + stringifiedAttributes);
			}

			// Read

			if (!key) {
				result = {};
			}

			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling "get()"
			var cookies = document.cookie ? document.cookie.split('; ') : [];
			var rdecode = /(%[0-9A-Z]{2})+/g;
			var i = 0;

			for (; i < cookies.length; i++) {
				var parts = cookies[i].split('=');
				var cookie = parts.slice(1).join('=');

				if (!this.json && cookie.charAt(0) === '"') {
					cookie = cookie.slice(1, -1);
				}

				try {
					var name = parts[0].replace(rdecode, decodeURIComponent);
					cookie = converter.read ?
						converter.read(cookie, name) : converter(cookie, name) ||
						cookie.replace(rdecode, decodeURIComponent);

					if (this.json) {
						try {
							cookie = JSON.parse(cookie);
						} catch (e) {}
					}

					if (key === name) {
						result = cookie;
						break;
					}

					if (!key) {
						result[name] = cookie;
					}
				} catch (e) {}
			}

			return result;
		}

		api.set = api;
		api.get = function (key) {
			return api.call(api, key);
		};
		api.getJSON = function () {
			return api.apply({
				json: true
			}, [].slice.call(arguments));
		};
		api.defaults = {};

		api.remove = function (key, attributes) {
			api(key, '', extend(attributes, {
				expires: -1
			}));
		};

		api.withConverter = init;

		return api;
	}

	return init(function () {});
}));

},{}],3:[function(require,module,exports){
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
},{}],4:[function(require,module,exports){

var fields = {
	
	functions: {}
	
};

module.exports = fields;
},{}],5:[function(require,module,exports){

//var state = require('./includes/state');

var pagination = {
	
	setupLegacy: function(){
		
		
	},
	
	setupLegacy: function(){
		
		/*if(typeof(self.ajax_links_selector)!="undefined")
		{
			var $ajax_links_object = jQuery(self.ajax_links_selector);
			
			if($ajax_links_object.length>0)
			{
				$ajax_links_object.on('click', function(e) {
					
					e.preventDefault();
					
					var link = jQuery(this).attr('href');
					self.ajax_action = "pagination";
					
					self.fetchLegacyAjaxResults(link);
					return false;
				});
			}
		}*/
	}
};

module.exports = pagination;
},{}],6:[function(require,module,exports){
(function (global){

var $ 				= (typeof window !== "undefined" ? window['jQuery'] : typeof global !== "undefined" ? global['jQuery'] : null);
var state 			= require('./state');
var process_form 	= require('./process_form');
var noUiSlider		= require('nouislider');
var cookies         = require('js-cookie');

module.exports = function(options)
{
    var defaults = {
        startOpened: false,
        isInit: true,
        action: ""
    };

    var opts = jQuery.extend(defaults, options);

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

                //$this.on('change', '.meta-slider', function(e) {
                //    self.inputUpdate(200);
                //    console.log("CHANGE META SLIDER");
                //});

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

            /*if((self.auto_update==1)||(self.auto_count_refresh_mode==1))
            {
                console.log($(this));
                var $date_fields = $this.find('[data-sf-field-input-type="date"]');
                $date_fields.each(function(e, index){
					console.log("------------");
					console.log("found date field");

				});
                var $tf_date_pickers = $this.find(".sf-datepicker");
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

            }*/
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

                    //$(this).find(".meta-slider").noUiSlider(noUIOptions);

                    var slider_object = $(this).find(".meta-slider")[0];

                    if( "undefined" !== typeof( slider_object.noUiSlider ) ) {
                        //destroy if it exists.. this means somehow another instance had initialised it..
                        slider_object.noUiSlider.destroy();
                        //console.log(typeof(slider_object.noUiSlider));
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

            $this.submit(this.submitForm);

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
                var scroll_offset = parseInt(self.infinite_scroll_trigger_amount);//self.infinite_scroll_trigger_amount;

                //var $ajax_results_container = jQuery($this.attr("data-ajax-target"));

                if(self.$infinite_scroll_container.length==1)
                {
                    var results_scroll_bottom = self.$infinite_scroll_container.offset().top + self.$infinite_scroll_container.height();

                    //var offset = ($ajax_results_container.offset().top + $ajax_results_container.height()) - window_scroll;
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

        /*if(this.debug_mode=="1")
         {//error logging

         if(self.is_ajax==1)
         {
         if(self.display_results_as=="shortcode")
         {
         if(self.$ajax_results_container.length==0)
         {
         console.log("Search & Filter | Form ID: "+self.sfid+": cannot find the results container on this page - ensure you use the shortcode on this page or provide a URL where it can be found (Results URL)");
         }
         if(self.results_url=="")
         {
         console.log("Search & Filter | Form ID: "+self.sfid+": No Results URL has been defined - ensure that you enter this in order to use the Search Form on any page)");
         }
         //check if results URL is on same domain for potential cross domain errors
         }
         else
         {
         if(self.$ajax_results_container.length==0)
         {
         console.log("Search & Filter | Form ID: "+self.sfid+": cannot find the results container on this page - ensure you use are using the right content selector");
         }
         }
         }
         else
         {

         }

         }*/


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
            /*if(typeof(exclude)=="undefined")
             {
             var exclude = "";
             }*/

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
            //var form_params = url_params_str.replaceAll("%2B", "+").replaceAll("%2C", ",")
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
             }
             }
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
                /*console.log("AJAX FAIL");
                 console.log(e);
                 console.log(x);*/

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

            self.last_ajax_request = $.get(ajax_processing_url, function(data, status, request)
            {
                self.last_ajax_request = null;

                /* scroll */
                self.scrollResults();

                //updates the resutls & form html
                self.updateResults(data, data_type);

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
                /*console.log("AJAX FAIL");
                 console.log(e);
                 console.log(x);*/

            }).always(function()
            {
                self.$ajax_results_container.stop(true,true).animate({ opacity: 1}, "fast"); //finished loading
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

                $this.find("input[name='_sf_search']").focus();
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
                    inputField.focus();
                }
            }else{
                inputField.focus();
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

                $this.submit();

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
                var url_parts = current_url.split("?");
                var url_base = "";

                if(url_parts.length>0)
                {
                    url_base = url_parts[0];
                }
                else {
                    url_base = current_url;
                }

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

                //trim any trailing slash for easier comparison:
                url_base = url_base.replace(/\/$/, '');
                results_url = results_url.replace(/\/$/, '');
                results_url_encoded = encodeURI(results_url.replace(/\/$/, ''));

                var current_url_contains_results_url = -1;
                if((url_base==results_url)||(url_base.toLowerCase()==results_url_encoded.toLowerCase())){
                    current_url_contains_results_url = 1;
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
            if(typeof(self.ajax_links_selector)=="undefined")
            {
                return;
            }

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

            //var $ajax_links_object = jQuery(self.ajax_links_selector);

            //if($ajax_links_object.length>0)
            //{
                //console.log("init pagination stuff");
                //$ajax_links_object.off('click');


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
           // }
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

            /*if(self.maintain_state=="1")
             {
             //alert("maintain state");
             var inFifteenMinutes = new Date(new Date().getTime() + 15 * 60 * 1000);
             //https://github.com/js-cookie/js-cookie/wiki/Frequently-Asked-Questions#expire-cookies-in-less-than-a-day
             var thirtyminutes = 1/48;
             //cookies.set('name', 'mrross', { expires: 7 });
             //cookies.set('name', 'mrross', { expires: thirtyminutes });
             cookies.set('name', 'mrross', { expires: inFifteenMinutes });
             }*/

            return false;
        };
        // console.log(cookies.get('name'));
        //console.log(cookies.get('name'));
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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3BsdWdpbi5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiXHJcbnZhciAkIFx0XHRcdFx0PSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xyXG52YXIgc3RhdGUgXHRcdFx0PSByZXF1aXJlKCcuL3N0YXRlJyk7XHJcbnZhciBwcm9jZXNzX2Zvcm0gXHQ9IHJlcXVpcmUoJy4vcHJvY2Vzc19mb3JtJyk7XHJcbnZhciBub1VpU2xpZGVyXHRcdD0gcmVxdWlyZSgnbm91aXNsaWRlcicpO1xyXG52YXIgY29va2llcyAgICAgICAgID0gcmVxdWlyZSgnanMtY29va2llJyk7XHJcblxyXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uKG9wdGlvbnMpXHJcbntcclxuICAgIHZhciBkZWZhdWx0cyA9IHtcclxuICAgICAgICBzdGFydE9wZW5lZDogZmFsc2UsXHJcbiAgICAgICAgaXNJbml0OiB0cnVlLFxyXG4gICAgICAgIGFjdGlvbjogXCJcIlxyXG4gICAgfTtcclxuXHJcbiAgICB2YXIgb3B0cyA9IGpRdWVyeS5leHRlbmQoZGVmYXVsdHMsIG9wdGlvbnMpO1xyXG5cclxuICAgIC8vbG9vcCB0aHJvdWdoIGVhY2ggaXRlbSBtYXRjaGVkXHJcbiAgICB0aGlzLmVhY2goZnVuY3Rpb24oKVxyXG4gICAge1xyXG5cclxuICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICB0aGlzLnNmaWQgPSAkdGhpcy5hdHRyKFwiZGF0YS1zZi1mb3JtLWlkXCIpO1xyXG5cclxuICAgICAgICBzdGF0ZS5hZGRTZWFyY2hGb3JtKHRoaXMuc2ZpZCwgdGhpcyk7XHJcblxyXG4gICAgICAgIHRoaXMuJGZpZWxkcyA9ICR0aGlzLmZpbmQoXCI+IHVsID4gbGlcIik7IC8vYSByZWZlcmVuY2UgdG8gZWFjaCBmaWVsZHMgcGFyZW50IExJXHJcblxyXG4gICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gJHRoaXMuYXR0cignZGF0YS10YXhvbm9teS1hcmNoaXZlcycpO1xyXG4gICAgICAgIHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlID0gJHRoaXMuYXR0cignZGF0YS1jdXJyZW50LXRheG9ub215LWFyY2hpdmUnKTtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gXCIwXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBwcm9jZXNzX2Zvcm0uaW5pdChzZWxmLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcywgc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUpO1xyXG4gICAgICAgIC8vcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYpO1xyXG4gICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyA9IHthbGw6IHt9LCByZXN1bHRzOiB7fSwgYWpheDoge319O1xyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMudGVtcGxhdGVfaXNfbG9hZGVkID0gJHRoaXMuYXR0cihcImRhdGEtdGVtcGxhdGUtbG9hZGVkXCIpO1xyXG4gICAgICAgIHRoaXMuaXNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXhcIik7XHJcbiAgICAgICAgdGhpcy5pbnN0YW5jZV9udW1iZXIgPSAkdGhpcy5hdHRyKCdkYXRhLWluc3RhbmNlLWNvdW50Jyk7XHJcbiAgICAgICAgdGhpcy4kYWpheF9yZXN1bHRzX2NvbnRhaW5lciA9IGpRdWVyeSgkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXRhcmdldFwiKSk7XHJcblxyXG4gICAgICAgIHRoaXMucmVzdWx0c191cmwgPSAkdGhpcy5hdHRyKFwiZGF0YS1yZXN1bHRzLXVybFwiKTtcclxuICAgICAgICB0aGlzLmRlYnVnX21vZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWJ1Zy1tb2RlXCIpO1xyXG4gICAgICAgIHRoaXMudXBkYXRlX2FqYXhfdXJsID0gJHRoaXMuYXR0cihcImRhdGEtdXBkYXRlLWFqYXgtdXJsXCIpO1xyXG4gICAgICAgIHRoaXMucGFnaW5hdGlvbl90eXBlID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC1wYWdpbmF0aW9uLXR5cGVcIik7XHJcbiAgICAgICAgdGhpcy5hdXRvX2NvdW50ID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by1jb3VudFwiKTtcclxuICAgICAgICB0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by1jb3VudC1yZWZyZXNoLW1vZGVcIik7XHJcbiAgICAgICAgdGhpcy5vbmx5X3Jlc3VsdHNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLW9ubHktcmVzdWx0cy1hamF4XCIpOyAvL2lmIHdlIGFyZSBub3Qgb24gdGhlIHJlc3VsdHMgcGFnZSwgcmVkaXJlY3QgcmF0aGVyIHRoYW4gdHJ5IHRvIGxvYWQgdmlhIGFqYXhcclxuICAgICAgICB0aGlzLnNjcm9sbF90b19wb3MgPSAkdGhpcy5hdHRyKFwiZGF0YS1zY3JvbGwtdG8tcG9zXCIpO1xyXG4gICAgICAgIHRoaXMuY3VzdG9tX3Njcm9sbF90byA9ICR0aGlzLmF0dHIoXCJkYXRhLWN1c3RvbS1zY3JvbGwtdG9cIik7XHJcbiAgICAgICAgdGhpcy5zY3JvbGxfb25fYWN0aW9uID0gJHRoaXMuYXR0cihcImRhdGEtc2Nyb2xsLW9uLWFjdGlvblwiKTtcclxuICAgICAgICB0aGlzLmxhbmdfY29kZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWxhbmctY29kZVwiKTtcclxuICAgICAgICB0aGlzLmFqYXhfdXJsID0gJHRoaXMuYXR0cignZGF0YS1hamF4LXVybCcpO1xyXG4gICAgICAgIHRoaXMuYWpheF9mb3JtX3VybCA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC1mb3JtLXVybCcpO1xyXG4gICAgICAgIHRoaXMuaXNfcnRsID0gJHRoaXMuYXR0cignZGF0YS1pcy1ydGwnKTtcclxuXHJcbiAgICAgICAgdGhpcy5kaXNwbGF5X3Jlc3VsdF9tZXRob2QgPSAkdGhpcy5hdHRyKCdkYXRhLWRpc3BsYXktcmVzdWx0LW1ldGhvZCcpO1xyXG4gICAgICAgIHRoaXMubWFpbnRhaW5fc3RhdGUgPSAkdGhpcy5hdHRyKCdkYXRhLW1haW50YWluLXN0YXRlJyk7XHJcbiAgICAgICAgdGhpcy5hamF4X2FjdGlvbiA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICB0aGlzLmN1cnJlbnRfcGFnZWQgPSBwYXJzZUludCgkdGhpcy5hdHRyKCdkYXRhLWluaXQtcGFnZWQnKSk7XHJcbiAgICAgICAgdGhpcy5sYXN0X2xvYWRfbW9yZV9odG1sID0gXCJcIjtcclxuICAgICAgICB0aGlzLmxvYWRfbW9yZV9odG1sID0gXCJcIjtcclxuICAgICAgICB0aGlzLmFqYXhfZGF0YV90eXBlID0gJHRoaXMuYXR0cignZGF0YS1hamF4LWRhdGEtdHlwZScpO1xyXG4gICAgICAgIHRoaXMuYWpheF90YXJnZXRfYXR0ciA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdGFyZ2V0XCIpO1xyXG4gICAgICAgIHRoaXMudXNlX2hpc3RvcnlfYXBpID0gJHRoaXMuYXR0cihcImRhdGEtdXNlLWhpc3RvcnktYXBpXCIpO1xyXG4gICAgICAgIHRoaXMuaXNfc3VibWl0dGluZyA9IGZhbHNlO1xyXG5cclxuICAgICAgICB0aGlzLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMudXNlX2hpc3RvcnlfYXBpKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMudXNlX2hpc3RvcnlfYXBpID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnBhZ2luYXRpb25fdHlwZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnBhZ2luYXRpb25fdHlwZSA9IFwibm9ybWFsXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1cnJlbnRfcGFnZWQpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5jdXJyZW50X3BhZ2VkID0gMTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdGFyZ2V0X2F0dHIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hamF4X3RhcmdldF9hdHRyID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdXJsKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF9mb3JtX3VybCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmFqYXhfZm9ybV91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMucmVzdWx0c191cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5zY3JvbGxfdG9fcG9zKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuc2Nyb2xsX3RvX3BvcyA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5zY3JvbGxfb25fYWN0aW9uKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuc2Nyb2xsX29uX2FjdGlvbiA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1c3RvbV9zY3JvbGxfdG8pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5jdXN0b21fc2Nyb2xsX3RvID0gXCJcIjtcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy4kY3VzdG9tX3Njcm9sbF90byA9IGpRdWVyeSh0aGlzLmN1c3RvbV9zY3JvbGxfdG8pO1xyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy51cGRhdGVfYWpheF91cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy51cGRhdGVfYWpheF91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZGVidWdfbW9kZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmRlYnVnX21vZGUgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF90YXJnZXRfb2JqZWN0KT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF90YXJnZXRfb2JqZWN0ID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCA9IFwiMFwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZSA9IFwiMFwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5hamF4X2xpbmtzX3NlbGVjdG9yID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC1saW5rcy1zZWxlY3RvclwiKTtcclxuXHJcblxyXG4gICAgICAgIHRoaXMuYXV0b191cGRhdGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1hdXRvLXVwZGF0ZVwiKTtcclxuICAgICAgICB0aGlzLmlucHV0VGltZXIgPSAwO1xyXG5cclxuICAgICAgICB0aGlzLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgIHRoaXMuaXNfbWF4X3BhZ2VkID0gZmFsc2U7IC8vZm9yIGxvYWQgbW9yZSBvbmx5LCBvbmNlIHdlIGRldGVjdCB3ZSdyZSBhdCB0aGUgZW5kIHNldCB0aGlzIHRvIHRydWVcclxuICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9ICR0aGlzLmF0dHIoJ2RhdGEtc2hvdy1zY3JvbGwtbG9hZGVyJyk7XHJcbiAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpO1xyXG4gICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLXRyaWdnZXInKTtcclxuICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzID0gJHRoaXMuYXR0cignZGF0YS1pbmZpbml0ZS1zY3JvbGwtcmVzdWx0LWNsYXNzJyk7XHJcbiAgICAgICAgICAgIHRoaXMuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSB0aGlzLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyO1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyID0galF1ZXJ5KCR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLnVzZV9zY3JvbGxfbG9hZGVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9IDE7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyKCk7XHJcblxyXG4gICAgICAgIC8qIGZ1bmN0aW9ucyAqL1xyXG5cclxuICAgICAgICB0aGlzLnJlc2V0ID0gZnVuY3Rpb24oc3VibWl0X2Zvcm0pXHJcbiAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgdGhpcy5yZXNldEZvcm0oc3VibWl0X2Zvcm0pO1xyXG4gICAgICAgICAgICByZXR1cm4gdHJ1ZTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuaW5wdXRVcGRhdGUgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGRlbGF5RHVyYXRpb24pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGVsYXlEdXJhdGlvbiA9IDMwMDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5yZXNldFRpbWVyKGRlbGF5RHVyYXRpb24pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zY3JvbGxUb1BvcyA9IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICB2YXIgb2Zmc2V0ID0gMDtcclxuICAgICAgICAgICAgdmFyIGNhblNjcm9sbCA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJ3aW5kb3dcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAwO1xyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImZvcm1cIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAkdGhpcy5vZmZzZXQoKS50b3A7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJyZXN1bHRzXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9mZnNldCA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIub2Zmc2V0KCkudG9wO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImN1c3RvbVwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vY3VzdG9tX3Njcm9sbF90b1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuJGN1c3RvbV9zY3JvbGxfdG8ubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSBzZWxmLiRjdXN0b21fc2Nyb2xsX3RvLm9mZnNldCgpLnRvcDtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgY2FuU2Nyb2xsID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoY2FuU2Nyb2xsKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCJodG1sLCBib2R5XCIpLnN0b3AoKS5hbmltYXRlKHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2Nyb2xsVG9wOiBvZmZzZXRcclxuICAgICAgICAgICAgICAgICAgICB9LCBcIm5vcm1hbFwiLCBcImVhc2VPdXRRdWFkXCIgKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmF0dGFjaEFjdGl2ZUNsYXNzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8vY2hlY2sgdG8gc2VlIGlmIHdlIGFyZSB1c2luZyBhamF4ICYgYXV0byBjb3VudFxyXG4gICAgICAgICAgICAvL2lmIG5vdCwgdGhlIHNlYXJjaCBmb3JtIGRvZXMgbm90IGdldCByZWxvYWRlZCwgc28gd2UgbmVlZCB0byB1cGRhdGUgdGhlIHNmLW9wdGlvbi1hY3RpdmUgY2xhc3Mgb24gYWxsIGZpZWxkc1xyXG5cclxuICAgICAgICAgICAgJHRoaXMub24oJ2NoYW5nZScsICdpbnB1dFt0eXBlPVwicmFkaW9cIl0sIGlucHV0W3R5cGU9XCJjaGVja2JveFwiXSwgc2VsZWN0JywgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyICRjdGhpcyA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGN0aGlzX3BhcmVudCA9ICRjdGhpcy5jbG9zZXN0KFwibGlbZGF0YS1zZi1maWVsZC1uYW1lXVwiKTtcclxuICAgICAgICAgICAgICAgIHZhciB0aGlzX3RhZyA9ICRjdGhpcy5wcm9wKFwidGFnTmFtZVwiKS50b0xvd2VyQ2FzZSgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIGlucHV0X3R5cGUgPSAkY3RoaXMuYXR0cihcInR5cGVcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgcGFyZW50X3RhZyA9ICRjdGhpc19wYXJlbnQucHJvcChcInRhZ05hbWVcIikudG9Mb3dlckNhc2UoKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigodGhpc190YWc9PVwiaW5wdXRcIikmJigoaW5wdXRfdHlwZT09XCJyYWRpb1wiKXx8KGlucHV0X3R5cGU9PVwiY2hlY2tib3hcIikpICYmIChwYXJlbnRfdGFnPT1cImxpXCIpKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2xpJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRhbGxfb3B0aW9uc19maWVsZHMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2lucHV0OmNoZWNrZWQnKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJGFsbF9vcHRpb25zLnJlbW92ZUNsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnNfZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkcGFyZW50ID0gJCh0aGlzKS5jbG9zZXN0KFwibGlcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRwYXJlbnQuYWRkQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHRoaXNfdGFnPT1cInNlbGVjdFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXMuY2hpbGRyZW4oKTtcclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnMucmVtb3ZlQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciB0aGlzX3ZhbCA9ICRjdGhpcy52YWwoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRoaXNfYXJyX3ZhbCA9ICh0eXBlb2YgdGhpc192YWwgPT0gJ3N0cmluZycgfHwgdGhpc192YWwgaW5zdGFuY2VvZiBTdHJpbmcpID8gW3RoaXNfdmFsXSA6IHRoaXNfdmFsO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkKHRoaXNfYXJyX3ZhbCkuZWFjaChmdW5jdGlvbihpLCB2YWx1ZSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjdGhpcy5maW5kKFwib3B0aW9uW3ZhbHVlPSdcIit2YWx1ZStcIiddXCIpLmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8qIGF1dG8gdXBkYXRlICovXHJcbiAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignY2hhbmdlJywgJ2lucHV0W3R5cGU9XCJyYWRpb1wiXSwgaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdLCBzZWxlY3QnLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgyMDApO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy8kdGhpcy5vbignY2hhbmdlJywgJy5tZXRhLXNsaWRlcicsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICAgICAgICAgIC8vICAgIHNlbGYuaW5wdXRVcGRhdGUoMjAwKTtcclxuICAgICAgICAgICAgICAgIC8vICAgIGNvbnNvbGUubG9nKFwiQ0hBTkdFIE1FVEEgU0xJREVSXCIpO1xyXG4gICAgICAgICAgICAgICAgLy99KTtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignaW5wdXQnLCAnaW5wdXRbdHlwZT1cIm51bWJlclwiXScsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDgwMCk7XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJHRleHRJbnB1dCA9ICR0aGlzLmZpbmQoJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOm5vdCguc2YtZGF0ZXBpY2tlciknKTtcclxuICAgICAgICAgICAgICAgIHZhciBsYXN0VmFsdWUgPSAkdGV4dElucHV0LnZhbCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJywgZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKGxhc3RWYWx1ZSE9JHRleHRJbnB1dC52YWwoKSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMTIwMCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBsYXN0VmFsdWUgPSAkdGV4dElucHV0LnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdrZXlwcmVzcycsICdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJywgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoZS53aGljaCA9PSAxMyl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vJHRoaXMub24oJ2lucHV0JywgJ2lucHV0LnNmLWRhdGVwaWNrZXInLCBzZWxmLmRhdGVJbnB1dFR5cGUpO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIC8vdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cygpO1xyXG5cclxuXHJcbiAgICAgICAgdGhpcy5jbGVhclRpbWVyID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgY2xlYXJUaW1lb3V0KHNlbGYuaW5wdXRUaW1lcik7XHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLnJlc2V0VGltZXIgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgY2xlYXJUaW1lb3V0KHNlbGYuaW5wdXRUaW1lcik7XHJcbiAgICAgICAgICAgIHNlbGYuaW5wdXRUaW1lciA9IHNldFRpbWVvdXQoc2VsZi5mb3JtVXBkYXRlZCwgZGVsYXlEdXJhdGlvbik7XHJcblxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuYWRkRGF0ZVBpY2tlcnMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJGRhdGVfcGlja2VyID0gJHRoaXMuZmluZChcIi5zZi1kYXRlcGlja2VyXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJGRhdGVfcGlja2VyLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkZGF0ZV9waWNrZXIuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRm9ybWF0ID0gXCJcIjtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZURyb3Bkb3duWWVhciA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRHJvcGRvd25Nb250aCA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGNsb3Nlc3RfZGF0ZV93cmFwID0gJHRoaXMuY2xvc2VzdChcIi5zZl9kYXRlX2ZpZWxkXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKCRjbG9zZXN0X2RhdGVfd3JhcC5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVGb3JtYXQgPSAkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS1mb3JtYXRcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS11c2UteWVhci1kcm9wZG93blwiKT09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZURyb3Bkb3duWWVhciA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtdXNlLW1vbnRoLWRyb3Bkb3duXCIpPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkYXRlRHJvcGRvd25Nb250aCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlUGlja2VyT3B0aW9ucyA9IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaW5saW5lOiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzaG93T3RoZXJNb250aHM6IHRydWUsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9uU2VsZWN0OiBmdW5jdGlvbihlLCBmcm9tX2ZpZWxkKXsgc2VsZi5kYXRlU2VsZWN0KGUsIGZyb21fZmllbGQsICQodGhpcykpOyB9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlRm9ybWF0OiBkYXRlRm9ybWF0LFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgY2hhbmdlTW9udGg6IGRhdGVEcm9wZG93bk1vbnRoLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjaGFuZ2VZZWFyOiBkYXRlRHJvcGRvd25ZZWFyXHJcbiAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlUGlja2VyT3B0aW9ucy5kaXJlY3Rpb24gPSBcInJ0bFwiO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJHRoaXMuZGF0ZXBpY2tlcihkYXRlUGlja2VyT3B0aW9ucyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYubGFuZ19jb2RlIT1cIlwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnNldERlZmF1bHRzKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5leHRlbmQoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeydkYXRlRm9ybWF0JzpkYXRlRm9ybWF0fSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIucmVnaW9uYWxbIHNlbGYubGFuZ19jb2RlXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICApO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnNldERlZmF1bHRzKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5leHRlbmQoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeydkYXRlRm9ybWF0JzpkYXRlRm9ybWF0fSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIucmVnaW9uYWxbXCJlblwiXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICApO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJCgnLmxsLXNraW4tbWVsb24nKS5sZW5ndGg9PTApe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkZGF0ZV9waWNrZXIuZGF0ZXBpY2tlcignd2lkZ2V0Jykud3JhcCgnPGRpdiBjbGFzcz1cImxsLXNraW4tbWVsb24gc2VhcmNoYW5kZmlsdGVyLWRhdGUtcGlja2VyXCIvPicpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZGF0ZVNlbGVjdCA9IGZ1bmN0aW9uKGUsIGZyb21fZmllbGQsICR0aGlzKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRpbnB1dF9maWVsZCA9ICQoZnJvbV9maWVsZC5pbnB1dC5nZXQoMCkpO1xyXG4gICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgdmFyICRkYXRlX2ZpZWxkcyA9ICRpbnB1dF9maWVsZC5jbG9zZXN0KCdbZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlPVwiZGF0ZXJhbmdlXCJdLCBbZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlPVwiZGF0ZVwiXScpO1xyXG4gICAgICAgICAgICAkZGF0ZV9maWVsZHMuZWFjaChmdW5jdGlvbihlLCBpbmRleCl7XHJcbiAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgICAgIHZhciAkdGZfZGF0ZV9waWNrZXJzID0gJCh0aGlzKS5maW5kKFwiLnNmLWRhdGVwaWNrZXJcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgbm9fZGF0ZV9waWNrZXJzID0gJHRmX2RhdGVfcGlja2Vycy5sZW5ndGg7XHJcbiAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgICAgIGlmKG5vX2RhdGVfcGlja2Vycz4xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vdGhlbiBpdCBpcyBhIGRhdGUgcmFuZ2UsIHNvIG1ha2Ugc3VyZSBib3RoIGZpZWxkcyBhcmUgZmlsbGVkIGJlZm9yZSB1cGRhdGluZ1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkcF9jb3VudGVyID0gMDtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfZW1wdHlfZmllbGRfY291bnQgPSAwO1xyXG4gICAgICAgICAgICAgICAgICAgICR0Zl9kYXRlX3BpY2tlcnMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJCh0aGlzKS52YWwoKT09XCJcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZHBfZW1wdHlfZmllbGRfY291bnQrKztcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgZHBfY291bnRlcisrO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihkcF9lbXB0eV9maWVsZF9jb3VudD09MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgIC8qaWYoKHNlbGYuYXV0b191cGRhdGU9PTEpfHwoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCQodGhpcykpO1xyXG4gICAgICAgICAgICAgICAgdmFyICRkYXRlX2ZpZWxkcyA9ICR0aGlzLmZpbmQoJ1tkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGU9XCJkYXRlXCJdJyk7XHJcbiAgICAgICAgICAgICAgICAkZGF0ZV9maWVsZHMuZWFjaChmdW5jdGlvbihlLCBpbmRleCl7XHJcblx0XHRcdFx0XHRjb25zb2xlLmxvZyhcIi0tLS0tLS0tLS0tLVwiKTtcclxuXHRcdFx0XHRcdGNvbnNvbGUubG9nKFwiZm91bmQgZGF0ZSBmaWVsZFwiKTtcclxuXHJcblx0XHRcdFx0fSk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJHRmX2RhdGVfcGlja2VycyA9ICR0aGlzLmZpbmQoXCIuc2YtZGF0ZXBpY2tlclwiKTtcclxuICAgICAgICAgICAgICAgIHZhciBub19kYXRlX3BpY2tlcnMgPSAkdGZfZGF0ZV9waWNrZXJzLmxlbmd0aDtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihub19kYXRlX3BpY2tlcnM+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3RoZW4gaXQgaXMgYSBkYXRlIHJhbmdlLCBzbyBtYWtlIHN1cmUgYm90aCBmaWVsZHMgYXJlIGZpbGxlZCBiZWZvcmUgdXBkYXRpbmdcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfY291bnRlciA9IDA7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRwX2VtcHR5X2ZpZWxkX2NvdW50ID0gMDtcclxuICAgICAgICAgICAgICAgICAgICAkdGZfZGF0ZV9waWNrZXJzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCQodGhpcykudmFsKCk9PVwiXCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRwX2VtcHR5X2ZpZWxkX2NvdW50Kys7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRwX2NvdW50ZXIrKztcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZHBfZW1wdHlfZmllbGRfY291bnQ9PTApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgfSovXHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5hZGRSYW5nZVNsaWRlcnMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJG1ldGFfcmFuZ2UgPSAkdGhpcy5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJG1ldGFfcmFuZ2UubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRtZXRhX3JhbmdlLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWluID0gJHRoaXMuYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtaW4gPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRpc3BsYXlfdmFsdWVfYXMgPSAkdGhpcy5hdHRyKFwiZGF0YS1kaXNwbGF5LXZhbHVlcy1hc1wiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RlcCA9ICR0aGlzLmF0dHIoXCJkYXRhLXN0ZXBcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzdGFydF92YWwgPSAkdGhpcy5maW5kKCcuc2YtcmFuZ2UtbWluJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRlbmRfdmFsID0gJHRoaXMuZmluZCgnLnNmLXJhbmdlLW1heCcpO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRlY2ltYWxfcGxhY2VzID0gJHRoaXMuYXR0cihcImRhdGEtZGVjaW1hbC1wbGFjZXNcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRob3VzYW5kX3NlcGVyYXRvciA9ICR0aGlzLmF0dHIoXCJkYXRhLXRob3VzYW5kLXNlcGVyYXRvclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGVjaW1hbF9zZXBlcmF0b3IgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWNpbWFsLXNlcGVyYXRvclwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX2Zvcm1hdCA9IHdOdW1iKHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgbWFyazogZGVjaW1hbF9zZXBlcmF0b3IsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRlY2ltYWxzOiBwYXJzZUZsb2F0KGRlY2ltYWxfcGxhY2VzKSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhvdXNhbmQ6IHRob3VzYW5kX3NlcGVyYXRvclxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtaW4pO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21pbikpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21heCkpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtYXgpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9hbGVydChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KGRpc3BsYXlfdmFsdWVfYXMpO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0aW5wdXRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwudmFsKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC52YWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG5vVUlPcHRpb25zID0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByYW5nZToge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJ21pbic6IFsgcGFyc2VGbG9hdChtaW4pIF0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnbWF4JzogWyBwYXJzZUZsb2F0KG1heCkgXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzdGFydDogW21pbl9mb3JtYXR0ZWQsIG1heF9mb3JtYXR0ZWRdLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVzOiAyLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25uZWN0OiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzdGVwOiBwYXJzZUZsb2F0KHN0ZXApLFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgYmVoYXZpb3VyOiAnZXh0ZW5kLXRhcCcsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZvcm1hdDogZmllbGRfZm9ybWF0XHJcbiAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX3J0bD09MSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG5vVUlPcHRpb25zLmRpcmVjdGlvbiA9IFwicnRsXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAvLyQodGhpcykuZmluZChcIi5tZXRhLXNsaWRlclwiKS5ub1VpU2xpZGVyKG5vVUlPcHRpb25zKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9vYmplY3QgPSAkKHRoaXMpLmZpbmQoXCIubWV0YS1zbGlkZXJcIilbMF07XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCBcInVuZGVmaW5lZFwiICE9PSB0eXBlb2YoIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlciApICkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2Rlc3Ryb3kgaWYgaXQgZXhpc3RzLi4gdGhpcyBtZWFucyBzb21laG93IGFub3RoZXIgaW5zdGFuY2UgaGFkIGluaXRpYWxpc2VkIGl0Li5cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmRlc3Ryb3koKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9jb25zb2xlLmxvZyh0eXBlb2Yoc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBub1VpU2xpZGVyLmNyZWF0ZShzbGlkZXJfb2JqZWN0LCBub1VJT3B0aW9ucyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwub2ZmKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5vbignY2hhbmdlJywgZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbJCh0aGlzKS52YWwoKSwgbnVsbF0pO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5vZmYoKTtcclxuICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5vbignY2hhbmdlJywgZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbbnVsbCwgJCh0aGlzKS52YWwoKV0pO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvLyRzdGFydF92YWwuaHRtbChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAvLyRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5vZmYoJ3VwZGF0ZScpO1xyXG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5vbigndXBkYXRlJywgZnVuY3Rpb24oIHZhbHVlcywgaGFuZGxlICkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9zdGFydF92YWwgID0gbWluX2Zvcm1hdHRlZDtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9lbmRfdmFsICA9IG1heF9mb3JtYXR0ZWQ7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWUgPSB2YWx1ZXNbaGFuZGxlXTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAoIGhhbmRsZSApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1heF9mb3JtYXR0ZWQgPSB2YWx1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1pbl9mb3JtYXR0ZWQgPSB2YWx1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0aW5wdXRcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC52YWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC52YWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5odG1sKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwuaHRtbChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaSB0aGluayB0aGUgZnVuY3Rpb24gdGhhdCBidWlsZHMgdGhlIFVSTCBuZWVkcyB0byBkZWNvZGUgdGhlIGZvcm1hdHRlZCBzdHJpbmcgYmVmb3JlIGFkZGluZyB0byB0aGUgdXJsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL29ubHkgdHJ5IHRvIHVwZGF0ZSBpZiB0aGUgdmFsdWVzIGhhdmUgYWN0dWFsbHkgY2hhbmdlZFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHNsaWRlcl9zdGFydF92YWwhPW1pbl9mb3JtYXR0ZWQpfHwoc2xpZGVyX2VuZF92YWwhPW1heF9mb3JtYXR0ZWQpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoODAwKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpOyAvL2lnbm9yZSBhbnkgY2hhbmdlcyByZWNlbnRseSBtYWRlIGJ5IHRoZSBzbGlkZXIgKHRoaXMgd2FzIGp1c3QgaW5pdCBzaG91bGRuJ3QgY291bnQgYXMgYW4gdXBkYXRlIGV2ZW50KVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5pbml0ID0gZnVuY3Rpb24oa2VlcF9wYWdpbmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGtlZXBfcGFnaW5hdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBrZWVwX3BhZ2luYXRpb24gPSBmYWxzZTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cygpO1xyXG4gICAgICAgICAgICB0aGlzLmF0dGFjaEFjdGl2ZUNsYXNzKCk7XHJcblxyXG4gICAgICAgICAgICB0aGlzLmFkZERhdGVQaWNrZXJzKCk7XHJcbiAgICAgICAgICAgIHRoaXMuYWRkUmFuZ2VTbGlkZXJzKCk7XHJcblxyXG4gICAgICAgICAgICAvL2luaXQgY29tYm8gYm94ZXNcclxuICAgICAgICAgICAgdmFyICRjb21ib2JveCA9ICR0aGlzLmZpbmQoXCJzZWxlY3RbZGF0YS1jb21ib2JveD0nMSddXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJGNvbWJvYm94Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkY29tYm9ib3guZWFjaChmdW5jdGlvbihpbmRleCApe1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkdGhpc2NiID0gJCggdGhpcyApO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBucm0gPSAkdGhpc2NiLmF0dHIoXCJkYXRhLWNvbWJvYm94LW5ybVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHR5cGVvZiAkdGhpc2NiLmNob3NlbiAhPSBcInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGNob3Nlbm9wdGlvbnMgPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWFyY2hfY29udGFpbnM6IHRydWVcclxuICAgICAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCh0eXBlb2YobnJtKSE9PVwidW5kZWZpbmVkXCIpJiYobnJtKSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjaG9zZW5vcHRpb25zLm5vX3Jlc3VsdHNfdGV4dCA9IG5ybTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyBzYWZlIHRvIHVzZSB0aGUgZnVuY3Rpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9zZWFyY2hfY29udGFpbnNcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzY2IuYWRkQ2xhc3MoXCJjaG9zZW4tcnRsXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLmNob3NlbihjaG9zZW5vcHRpb25zKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzZWxlY3Qyb3B0aW9ucyA9IHt9O1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGVjdDJvcHRpb25zLmRpciA9IFwicnRsXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHR5cGVvZihucm0pIT09XCJ1bmRlZmluZWRcIikmJihucm0pKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGVjdDJvcHRpb25zLmxhbmd1YWdlPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJub1Jlc3VsdHNcIjogZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIG5ybTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9O1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLnNlbGVjdDIoc2VsZWN0Mm9wdGlvbnMpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgLy9pZiBhamF4IGlzIGVuYWJsZWQgaW5pdCB0aGUgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAkdGhpcy5zdWJtaXQodGhpcy5zdWJtaXRGb3JtKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMoKTsgLy93b29jb21tZXJjZSBvcmRlcmJ5XHJcblxyXG4gICAgICAgICAgICBpZihrZWVwX3BhZ2luYXRpb249PWZhbHNlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5vbldpbmRvd1Njcm9sbCA9IGZ1bmN0aW9uKGV2ZW50KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYoKCFzZWxmLmlzX2xvYWRpbmdfbW9yZSkgJiYgKCFzZWxmLmlzX21heF9wYWdlZCkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB3aW5kb3dfc2Nyb2xsID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHdpbmRvd19zY3JvbGxfYm90dG9tID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpICsgJCh3aW5kb3cpLmhlaWdodCgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHNjcm9sbF9vZmZzZXQgPSBwYXJzZUludChzZWxmLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCk7Ly9zZWxmLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudDtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3ZhciAkYWpheF9yZXN1bHRzX2NvbnRhaW5lciA9IGpRdWVyeSgkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXRhcmdldFwiKSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfc2Nyb2xsX2JvdHRvbSA9IHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIub2Zmc2V0KCkudG9wICsgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5oZWlnaHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy92YXIgb2Zmc2V0ID0gKCRhamF4X3Jlc3VsdHNfY29udGFpbmVyLm9mZnNldCgpLnRvcCArICRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmhlaWdodCgpKSAtIHdpbmRvd19zY3JvbGw7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG9mZnNldCA9IChzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLm9mZnNldCgpLnRvcCArIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuaGVpZ2h0KCkpIC0gd2luZG93X3Njcm9sbDtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYod2luZG93X3Njcm9sbF9ib3R0b20gPiByZXN1bHRzX3Njcm9sbF9ib3R0b20gKyBzY3JvbGxfb2Zmc2V0KVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5sb2FkTW9yZVJlc3VsdHMoKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHsvL2RvbnQgbG9hZCBtb3JlXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgLyppZih0aGlzLmRlYnVnX21vZGU9PVwiMVwiKVxyXG4gICAgICAgICB7Ly9lcnJvciBsb2dnaW5nXHJcblxyXG4gICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgIHtcclxuICAgICAgICAgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdHNfYXM9PVwic2hvcnRjb2RlXCIpXHJcbiAgICAgICAgIHtcclxuICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg9PTApXHJcbiAgICAgICAgIHtcclxuICAgICAgICAgY29uc29sZS5sb2coXCJTZWFyY2ggJiBGaWx0ZXIgfCBGb3JtIElEOiBcIitzZWxmLnNmaWQrXCI6IGNhbm5vdCBmaW5kIHRoZSByZXN1bHRzIGNvbnRhaW5lciBvbiB0aGlzIHBhZ2UgLSBlbnN1cmUgeW91IHVzZSB0aGUgc2hvcnRjb2RlIG9uIHRoaXMgcGFnZSBvciBwcm92aWRlIGEgVVJMIHdoZXJlIGl0IGNhbiBiZSBmb3VuZCAoUmVzdWx0cyBVUkwpXCIpO1xyXG4gICAgICAgICB9XHJcbiAgICAgICAgIGlmKHNlbGYucmVzdWx0c191cmw9PVwiXCIpXHJcbiAgICAgICAgIHtcclxuICAgICAgICAgY29uc29sZS5sb2coXCJTZWFyY2ggJiBGaWx0ZXIgfCBGb3JtIElEOiBcIitzZWxmLnNmaWQrXCI6IE5vIFJlc3VsdHMgVVJMIGhhcyBiZWVuIGRlZmluZWQgLSBlbnN1cmUgdGhhdCB5b3UgZW50ZXIgdGhpcyBpbiBvcmRlciB0byB1c2UgdGhlIFNlYXJjaCBGb3JtIG9uIGFueSBwYWdlKVwiKTtcclxuICAgICAgICAgfVxyXG4gICAgICAgICAvL2NoZWNrIGlmIHJlc3VsdHMgVVJMIGlzIG9uIHNhbWUgZG9tYWluIGZvciBwb3RlbnRpYWwgY3Jvc3MgZG9tYWluIGVycm9yc1xyXG4gICAgICAgICB9XHJcbiAgICAgICAgIGVsc2VcclxuICAgICAgICAge1xyXG4gICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmxlbmd0aD09MClcclxuICAgICAgICAge1xyXG4gICAgICAgICBjb25zb2xlLmxvZyhcIlNlYXJjaCAmIEZpbHRlciB8IEZvcm0gSUQ6IFwiK3NlbGYuc2ZpZCtcIjogY2Fubm90IGZpbmQgdGhlIHJlc3VsdHMgY29udGFpbmVyIG9uIHRoaXMgcGFnZSAtIGVuc3VyZSB5b3UgdXNlIGFyZSB1c2luZyB0aGUgcmlnaHQgY29udGVudCBzZWxlY3RvclwiKTtcclxuICAgICAgICAgfVxyXG4gICAgICAgICB9XHJcbiAgICAgICAgIH1cclxuICAgICAgICAgZWxzZVxyXG4gICAgICAgICB7XHJcblxyXG4gICAgICAgICB9XHJcblxyXG4gICAgICAgICB9Ki9cclxuXHJcblxyXG4gICAgICAgIHRoaXMuc3RyaXBRdWVyeVN0cmluZ0FuZEhhc2hGcm9tUGF0aCA9IGZ1bmN0aW9uKHVybCkge1xyXG4gICAgICAgICAgICByZXR1cm4gdXJsLnNwbGl0KFwiP1wiKVswXS5zcGxpdChcIiNcIilbMF07XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmd1cCA9IGZ1bmN0aW9uKCBuYW1lLCB1cmwgKSB7XHJcbiAgICAgICAgICAgIGlmICghdXJsKSB1cmwgPSBsb2NhdGlvbi5ocmVmXHJcbiAgICAgICAgICAgIG5hbWUgPSBuYW1lLnJlcGxhY2UoL1tcXFtdLyxcIlxcXFxcXFtcIikucmVwbGFjZSgvW1xcXV0vLFwiXFxcXFxcXVwiKTtcclxuICAgICAgICAgICAgdmFyIHJlZ2V4UyA9IFwiW1xcXFw/Jl1cIituYW1lK1wiPShbXiYjXSopXCI7XHJcbiAgICAgICAgICAgIHZhciByZWdleCA9IG5ldyBSZWdFeHAoIHJlZ2V4UyApO1xyXG4gICAgICAgICAgICB2YXIgcmVzdWx0cyA9IHJlZ2V4LmV4ZWMoIHVybCApO1xyXG4gICAgICAgICAgICByZXR1cm4gcmVzdWx0cyA9PSBudWxsID8gbnVsbCA6IHJlc3VsdHNbMV07XHJcbiAgICAgICAgfTtcclxuXHJcblxyXG4gICAgICAgIHRoaXMuZ2V0VXJsUGFyYW1zID0gZnVuY3Rpb24oa2VlcF9wYWdpbmF0aW9uLCB0eXBlLCBleGNsdWRlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGtlZXBfcGFnaW5hdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBrZWVwX3BhZ2luYXRpb24gPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIC8qaWYodHlwZW9mKGV4Y2x1ZGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgdmFyIGV4Y2x1ZGUgPSBcIlwiO1xyXG4gICAgICAgICAgICAgfSovXHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YodHlwZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB0eXBlID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHVybF9wYXJhbXNfc3RyID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIC8vIGdldCBhbGwgcGFyYW1zIGZyb20gZmllbGRzXHJcbiAgICAgICAgICAgIHZhciB1cmxfcGFyYW1zX2FycmF5ID0gcHJvY2Vzc19mb3JtLmdldFVybFBhcmFtcyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyh1cmxfcGFyYW1zX2FycmF5KS5sZW5ndGg7XHJcbiAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YoZXhjbHVkZSkhPVwidW5kZWZpbmVkXCIpIHtcclxuICAgICAgICAgICAgICAgIGlmICh1cmxfcGFyYW1zX2FycmF5Lmhhc093blByb3BlcnR5KGV4Y2x1ZGUpKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgbGVuZ3RoLS07XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBmb3IgKHZhciBrIGluIHVybF9wYXJhbXNfYXJyYXkpIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAodXJsX3BhcmFtc19hcnJheS5oYXNPd25Qcm9wZXJ0eShrKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGNhbl9hZGQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZih0eXBlb2YoZXhjbHVkZSkhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmKGs9PWV4Y2x1ZGUpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYW5fYWRkID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGNhbl9hZGQpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybF9wYXJhbXNfc3RyICs9IGsgKyBcIj1cIiArIHVybF9wYXJhbXNfYXJyYXlba107XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGNvdW50IDwgbGVuZ3RoIC0gMSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybF9wYXJhbXNfc3RyICs9IFwiJlwiO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvdW50Kys7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgLy9mb3JtIHBhcmFtcyBhcyB1cmwgcXVlcnkgc3RyaW5nXHJcbiAgICAgICAgICAgIC8vdmFyIGZvcm1fcGFyYW1zID0gdXJsX3BhcmFtc19zdHIucmVwbGFjZUFsbChcIiUyQlwiLCBcIitcIikucmVwbGFjZUFsbChcIiUyQ1wiLCBcIixcIilcclxuICAgICAgICAgICAgdmFyIGZvcm1fcGFyYW1zID0gdXJsX3BhcmFtc19zdHI7XHJcblxyXG4gICAgICAgICAgICAvL2dldCB1cmwgcGFyYW1zIGZyb20gdGhlIGZvcm0gaXRzZWxmICh3aGF0IHRoZSB1c2VyIGhhcyBzZWxlY3RlZClcclxuICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBmb3JtX3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAvL2FkZCBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgIGlmKGtlZXBfcGFnaW5hdGlvbj09dHJ1ZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHBhZ2VOdW1iZXIgPSBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihwYWdlTnVtYmVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBwYWdlTnVtYmVyID0gMTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZihwYWdlTnVtYmVyPjEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK3BhZ2VOdW1iZXIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvL2FkZCBzZmlkXHJcbiAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmaWQ9XCIrc2VsZi5zZmlkKTtcclxuXHJcbiAgICAgICAgICAgIC8vIGxvb3AgdGhyb3VnaCBhbnkgZXh0cmEgcGFyYW1zIChmcm9tIGV4dCBwbHVnaW5zKSBhbmQgYWRkIHRvIHRoZSB1cmwgKGllIHdvb2NvbW1lcmNlIGBvcmRlcmJ5YClcclxuICAgICAgICAgICAgLyp2YXIgZXh0cmFfcXVlcnlfcGFyYW0gPSBcIlwiO1xyXG4gICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zKS5sZW5ndGg7XHJcbiAgICAgICAgICAgICB2YXIgY291bnQgPSAwO1xyXG5cclxuICAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxyXG4gICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMpIHtcclxuICAgICAgICAgICAgIGlmIChzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5oYXNPd25Qcm9wZXJ0eShrKSkge1xyXG5cclxuICAgICAgICAgICAgIGlmKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdIT1cIlwiKVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgZXh0cmFfcXVlcnlfcGFyYW0gPSBrK1wiPVwiK3NlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdO1xyXG4gICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBleHRyYV9xdWVyeV9wYXJhbSk7XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAqL1xyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmFkZFF1ZXJ5UGFyYW1zKHF1ZXJ5X3BhcmFtcywgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsKTtcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGUhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhxdWVyeV9wYXJhbXMsIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW3R5cGVdKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIHF1ZXJ5X3BhcmFtcztcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5hZGRRdWVyeVBhcmFtcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcywgbmV3X3BhcmFtcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBleHRyYV9xdWVyeV9wYXJhbSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyhuZXdfcGFyYW1zKS5sZW5ndGg7XHJcbiAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XHJcblxyXG4gICAgICAgICAgICBpZihsZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gbmV3X3BhcmFtcykge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChuZXdfcGFyYW1zLmhhc093blByb3BlcnR5KGspKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihuZXdfcGFyYW1zW2tdIT1cIlwiKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHRyYV9xdWVyeV9wYXJhbSA9IGsrXCI9XCIrbmV3X3BhcmFtc1trXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgZXh0cmFfcXVlcnlfcGFyYW0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gcXVlcnlfcGFyYW1zO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmFkZFVybFBhcmFtID0gZnVuY3Rpb24odXJsLCBzdHJpbmcpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgYWRkX3BhcmFtcyA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICBpZih1cmwhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHVybC5pbmRleE9mKFwiP1wiKSAhPSAtMSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vdXJsID0gdGhpcy50cmFpbGluZ1NsYXNoSXQodXJsKTtcclxuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiP1wiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gdXJsICsgYWRkX3BhcmFtcyArIHN0cmluZztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiB1cmw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmpvaW5VcmxQYXJhbSA9IGZ1bmN0aW9uKHBhcmFtcywgc3RyaW5nKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIGFkZF9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgaWYocGFyYW1zIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gcGFyYW1zICsgYWRkX3BhcmFtcyArIHN0cmluZztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiBwYXJhbXM7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLnNldEFqYXhSZXN1bHRzVVJMcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfcmVzdWx0c19jb25mKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZiA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gXCJcIjtcclxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIC8vaWYoc2VsZi5hamF4X3VybCE9XCJcIilcclxuICAgICAgICAgICAgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwic2hvcnRjb2RlXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2FudCB0byBkbyBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnRcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYucmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9hZGQgbGFuZyBjb2RlIHRvIGFqYXggYXBpIHJlcXVlc3QsIGxhbmcgY29kZSBzaG91bGQgYWxyZWFkeSBiZSBpbiB0aGVyZSBmb3Igb3RoZXIgcmVxdWVzdHMgKGllLCBzdXBwbGllZCBpbiB0aGUgUmVzdWx0cyBVUkwpXHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5sYW5nX2NvZGUhPVwiXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9zbyBhZGQgaXRcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwibGFuZz1cIitzZWxmLmxhbmdfY29kZSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5hamF4X3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIC8vc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSAnanNvbic7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwicG9zdF90eXBlX2FyY2hpdmVcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJjdXN0b21fd29vY29tbWVyY2Vfc3RvcmVcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly9vdGhlcndpc2Ugd2Ugd2FudCB0byBwdWxsIHRoZSByZXN1bHRzIGRpcmVjdGx5IGZyb20gdGhlIHJlc3VsdHMgcGFnZVxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5yZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF91cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gJ2h0bWwnO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1snYWpheCddKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gc2VsZi5hamF4X2RhdGFfdHlwZTtcclxuICAgICAgICB9O1xyXG5cclxuXHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlTG9hZGVyVGFnID0gZnVuY3Rpb24oJG9iamVjdCwgdGFnTmFtZSkge1xyXG5cclxuICAgICAgICAgICAgdmFyICRwYXJlbnQ7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRwYXJlbnQgPSBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKS5sYXN0KCkucGFyZW50KCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkcGFyZW50ID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHRhZ05hbWUgPSAkcGFyZW50LnByb3AoXCJ0YWdOYW1lXCIpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHRhZ1R5cGUgPSAnZGl2JztcclxuICAgICAgICAgICAgaWYoICggdGFnTmFtZS50b0xvd2VyQ2FzZSgpID09ICdvbCcgKSB8fCAoIHRhZ05hbWUudG9Mb3dlckNhc2UoKSA9PSAndWwnICkgKXtcclxuICAgICAgICAgICAgICAgIHRhZ1R5cGUgPSAnbGknO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgJG5ldyA9ICQoJzwnK3RhZ1R5cGUrJyAvPicpLmh0bWwoJG9iamVjdC5odG1sKCkpO1xyXG4gICAgICAgICAgICB2YXIgYXR0cmlidXRlcyA9ICRvYmplY3QucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcblxyXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggPHNlbGVjdD4gYXR0cmlidXRlcyBhbmQgYXBwbHkgdGhlbSBvbiA8ZGl2PlxyXG4gICAgICAgICAgICAkLmVhY2goYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAkbmV3LmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gJG5ldztcclxuXHJcbiAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5sb2FkTW9yZVJlc3VsdHMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBzZWxmLmlzX2xvYWRpbmdfbW9yZSA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcclxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XHJcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXHJcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogXCJsb2FkX21vcmVcIixcclxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxyXG4gICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4c3RhcnRcIiwgZXZlbnRfZGF0YSk7XHJcblxyXG4gICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSk7XHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpOyAvL2dyYWIgYSBjb3B5IG9mIGh0ZSBVUkwgcGFyYW1zIHdpdGhvdXQgcGFnaW5hdGlvbiBhbHJlYWR5IGFkZGVkXHJcblxyXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBhamF4X3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwiXCI7XHJcblxyXG5cclxuICAgICAgICAgICAgLy9ub3cgYWRkIHRoZSBuZXcgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICB2YXIgbmV4dF9wYWdlZF9udW1iZXIgPSB0aGlzLmN1cnJlbnRfcGFnZWQgKyAxO1xyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrbmV4dF9wYWdlZF9udW1iZXIpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ107XHJcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xyXG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcclxuXHJcbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcclxuICAgICAgICAgICAgaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGxvYWRlciA9ICQoJzxkaXYvPicse1xyXG4gICAgICAgICAgICAgICAgICAgICdjbGFzcyc6ICdzZWFyY2gtZmlsdGVyLXNjcm9sbC1sb2FkaW5nJ1xyXG4gICAgICAgICAgICAgICAgfSk7Ly8uYXBwZW5kVG8oc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lcik7XHJcblxyXG4gICAgICAgICAgICAgICAgJGxvYWRlciA9IHNlbGYudXBkYXRlTG9hZGVyVGFnKCRsb2FkZXIpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoJGxvYWRlcik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QgPSAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuY3VycmVudF9wYWdlZCsrO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLyogc2Nyb2xsICovXHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuc2Nyb2xsUmVzdWx0cygpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlcyB0aGUgcmVzdXRscyAmIGZvcm0gaHRtbFxyXG4gICAgICAgICAgICAgICAgc2VsZi5hZGRSZXN1bHRzKGRhdGEsIGRhdGFfdHlwZSk7XHJcblxyXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgZGF0YSk7XHJcbiAgICAgICAgICAgICAgICAvKmNvbnNvbGUubG9nKFwiQUpBWCBGQUlMXCIpO1xyXG4gICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKGUpO1xyXG4gICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKHgpOyovXHJcblxyXG4gICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICRsb2FkZXIuZGV0YWNoKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc19sb2FkaW5nX21vcmUgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmaW5pc2hcIiwgZGF0YSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5mZXRjaEFqYXhSZXN1bHRzID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XHJcbiAgICAgICAgICAgIHZhciBldmVudF9kYXRhID0ge1xyXG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxyXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcclxuICAgICAgICAgICAgICAgIHR5cGU6IFwibG9hZF9yZXN1bHRzXCIsXHJcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheHN0YXJ0XCIsIGV2ZW50X2RhdGEpO1xyXG5cclxuICAgICAgICAgICAgLy9yZWZvY3VzIGFueSBpbnB1dCBmaWVsZHMgYWZ0ZXIgdGhlIGZvcm0gaGFzIGJlZW4gdXBkYXRlZFxyXG4gICAgICAgICAgICB2YXIgJGxhc3RfYWN0aXZlX2lucHV0X3RleHQgPSAkdGhpcy5maW5kKCdpbnB1dFt0eXBlPVwidGV4dFwiXTpmb2N1cycpLm5vdChcIi5zZi1kYXRlcGlja2VyXCIpO1xyXG4gICAgICAgICAgICBpZigkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dC5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0ID0gJGxhc3RfYWN0aXZlX2lucHV0X3RleHQuYXR0cihcIm5hbWVcIik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICR0aGlzLmFkZENsYXNzKFwic2VhcmNoLWZpbHRlci1kaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmRpc2FibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgICAgICAvL2ZhZGUgb3V0IHJlc3VsdHNcclxuICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hbmltYXRlKHsgb3BhY2l0eTogMC41IH0sIFwiZmFzdFwiKTsgLy9sb2FkaW5nXHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmFqYXhfYWN0aW9uPT1cInBhZ2luYXRpb25cIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9uZWVkIHRvIHJlbW92ZSBhY3RpdmUgZmlsdGVyIGZyb20gVVJMXHJcblxyXG4gICAgICAgICAgICAgICAgLy9xdWVyeV9wYXJhbXMgPSBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcztcclxuXHJcbiAgICAgICAgICAgICAgICAvL25vdyBhZGQgdGhlIG5ldyBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKHBhZ2VOdW1iZXIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHBhZ2VOdW1iZXIgPSAxO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHBhZ2VOdW1iZXI+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrcGFnZU51bWJlcik7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5hamF4X2FjdGlvbj09XCJzdWJtaXRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7IC8vZ3JhYiBhIGNvcHkgb2YgaHRlIFVSTCBwYXJhbXMgd2l0aG91dCBwYWdpbmF0aW9uIGFscmVhZHkgYWRkZWRcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBcIlwiO1xyXG4gICAgICAgICAgICB2YXIgYWpheF9yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBkYXRhX3R5cGUgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ107XHJcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xyXG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcclxuXHJcblxyXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXHJcbiAgICAgICAgICAgIGlmKHNlbGYubGFzdF9hamF4X3JlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9ICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLyogc2Nyb2xsICovXHJcbiAgICAgICAgICAgICAgICBzZWxmLnNjcm9sbFJlc3VsdHMoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlUmVzdWx0cyhkYXRhLCBkYXRhX3R5cGUpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8qIHVwZGF0ZSBVUkwgKi9cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlIHVybCBiZWZvcmUgcGFnaW5hdGlvbiwgYmVjYXVzZSB3ZSBuZWVkIHRvIGRvIHNvbWUgY2hlY2tzIGFnYWlucyB0aGUgVVJMIGZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlVXJsSGlzdG9yeShhamF4X3Jlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NldHVwIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgICAgICAvKiB1c2VyIGRlZiAqL1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pbml0V29vQ29tbWVyY2VDb250cm9scygpOyAvL3dvb2NvbW1lcmNlIG9yZGVyYnlcclxuXHJcblxyXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGVycm9yXCIsIGRhdGEpO1xyXG4gICAgICAgICAgICAgICAgLypjb25zb2xlLmxvZyhcIkFKQVggRkFJTFwiKTtcclxuICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhlKTtcclxuICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyh4KTsqL1xyXG5cclxuICAgICAgICAgICAgfSkuYWx3YXlzKGZ1bmN0aW9uKClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5zdG9wKHRydWUsdHJ1ZSkuYW5pbWF0ZSh7IG9wYWNpdHk6IDF9LCBcImZhc3RcIik7IC8vZmluaXNoZWQgbG9hZGluZ1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcbiAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZW5hYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vcmVmb2N1cyB0aGUgbGFzdCBhY3RpdmUgdGV4dCBmaWVsZFxyXG4gICAgICAgICAgICAgICAgaWYobGFzdF9hY3RpdmVfaW5wdXRfdGV4dCE9XCJcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gW107XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlX2lucHV0ID0gJCh0aGlzKS5maW5kKFwiaW5wdXRbbmFtZT0nXCIrbGFzdF9hY3RpdmVfaW5wdXRfdGV4dCtcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkYWN0aXZlX2lucHV0Lmxlbmd0aD09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGlucHV0ID0gJGFjdGl2ZV9pbnB1dDtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICBpZigkaW5wdXQubGVuZ3RoPT0xKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkaW5wdXQuZm9jdXMoKS52YWwoJGlucHV0LnZhbCgpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5mb2N1c0NhbXBvKCRpbnB1dFswXSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLmZpbmQoXCJpbnB1dFtuYW1lPSdfc2Zfc2VhcmNoJ11cIikuZm9jdXMoKTtcclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZpbmlzaFwiLCAgZGF0YSApO1xyXG5cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5mb2N1c0NhbXBvID0gZnVuY3Rpb24oaW5wdXRGaWVsZCl7XHJcbiAgICAgICAgICAgIC8vdmFyIGlucHV0RmllbGQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChpZCk7XHJcbiAgICAgICAgICAgIGlmIChpbnB1dEZpZWxkICE9IG51bGwgJiYgaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGggIT0gMCl7XHJcbiAgICAgICAgICAgICAgICBpZiAoaW5wdXRGaWVsZC5jcmVhdGVUZXh0UmFuZ2Upe1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBGaWVsZFJhbmdlID0gaW5wdXRGaWVsZC5jcmVhdGVUZXh0UmFuZ2UoKTtcclxuICAgICAgICAgICAgICAgICAgICBGaWVsZFJhbmdlLm1vdmVTdGFydCgnY2hhcmFjdGVyJyxpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aCk7XHJcbiAgICAgICAgICAgICAgICAgICAgRmllbGRSYW5nZS5jb2xsYXBzZSgpO1xyXG4gICAgICAgICAgICAgICAgICAgIEZpZWxkUmFuZ2Uuc2VsZWN0KCk7XHJcbiAgICAgICAgICAgICAgICB9ZWxzZSBpZiAoaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCB8fCBpbnB1dEZpZWxkLnNlbGVjdGlvblN0YXJ0ID09ICcwJykge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBlbGVtTGVuID0gaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGg7XHJcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCA9IGVsZW1MZW47XHJcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5zZWxlY3Rpb25FbmQgPSBlbGVtTGVuO1xyXG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuZm9jdXMoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfWVsc2V7XHJcbiAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLmZvY3VzKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudHJpZ2dlckV2ZW50ID0gZnVuY3Rpb24oZXZlbnRuYW1lLCBkYXRhKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRldmVudF9jb250YWluZXIgPSAkKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiK3NlbGYuc2ZpZCtcIiddXCIpO1xyXG4gICAgICAgICAgICAkZXZlbnRfY29udGFpbmVyLnRyaWdnZXIoZXZlbnRuYW1lLCBbIGRhdGEgXSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmZldGNoQWpheEZvcm0gPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcclxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XHJcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXHJcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogXCJmb3JtXCIsXHJcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZvcm1zdGFydFwiLCBbIGV2ZW50X2RhdGEgXSk7XHJcblxyXG4gICAgICAgICAgICAkdGhpcy5hZGRDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5kaXNhYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKCk7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9zbyBhZGQgaXRcclxuICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJsYW5nPVwiK3NlbGYubGFuZ19jb2RlKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF9mb3JtX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwianNvblwiO1xyXG5cclxuXHJcbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcclxuICAgICAgICAgICAgLyppZihzZWxmLmxhc3RfYWpheF9yZXF1ZXN0KVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xyXG4gICAgICAgICAgICAgfSovXHJcblxyXG5cclxuICAgICAgICAgICAgLy9zZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID1cclxuXHJcbiAgICAgICAgICAgICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlRm9ybShkYXRhLCBkYXRhX3R5cGUpO1xyXG5cclxuXHJcbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcclxuICAgICAgICAgICAgICAgIGRhdGEuanFYSFIgPSBqcVhIUjtcclxuICAgICAgICAgICAgICAgIGRhdGEudGV4dFN0YXR1cyA9IHRleHRTdGF0dXM7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBbIGRhdGEgXSk7XHJcblxyXG4gICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZW5hYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZvcm1maW5pc2hcIiwgWyBkYXRhIF0pO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmNvcHlMaXN0SXRlbXNDb250ZW50cyA9IGZ1bmN0aW9uKCRsaXN0X2Zyb20sICRsaXN0X3RvKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgLy9jb3B5IG92ZXIgY2hpbGQgbGlzdCBpdGVtc1xyXG4gICAgICAgICAgICB2YXIgbGlfY29udGVudHNfYXJyYXkgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgdmFyIGZyb21fYXR0cmlidXRlcyA9IG5ldyBBcnJheSgpO1xyXG5cclxuICAgICAgICAgICAgdmFyICRmcm9tX2ZpZWxkcyA9ICRsaXN0X2Zyb20uZmluZChcIj4gdWwgPiBsaVwiKTtcclxuXHJcbiAgICAgICAgICAgICRmcm9tX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGkpe1xyXG5cclxuICAgICAgICAgICAgICAgIGxpX2NvbnRlbnRzX2FycmF5LnB1c2goJCh0aGlzKS5odG1sKCkpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciBhdHRyaWJ1dGVzID0gJCh0aGlzKS5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgICAgIGZyb21fYXR0cmlidXRlcy5wdXNoKGF0dHJpYnV0ZXMpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vdmFyIGZpZWxkX25hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcbiAgICAgICAgICAgICAgICAvL3ZhciB0b19maWVsZCA9ICRsaXN0X3RvLmZpbmQoXCI+IHVsID4gbGlbZGF0YS1zZi1maWVsZC1uYW1lPSdcIitmaWVsZF9uYW1lK1wiJ11cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmNvcHlBdHRyaWJ1dGVzKCQodGhpcyksICRsaXN0X3RvLCBcImRhdGEtc2YtXCIpO1xyXG5cclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICB2YXIgbGlfaXQgPSAwO1xyXG4gICAgICAgICAgICB2YXIgJHRvX2ZpZWxkcyA9ICRsaXN0X3RvLmZpbmQoXCI+IHVsID4gbGlcIik7XHJcbiAgICAgICAgICAgICR0b19maWVsZHMuZWFjaChmdW5jdGlvbihpKXtcclxuICAgICAgICAgICAgICAgICQodGhpcykuaHRtbChsaV9jb250ZW50c19hcnJheVtsaV9pdF0pO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZnJvbV9maWVsZCA9ICQoJGZyb21fZmllbGRzLmdldChsaV9pdCkpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkdG9fZmllbGQgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgJHRvX2ZpZWxkLnJlbW92ZUF0dHIoXCJkYXRhLXNmLXRheG9ub215LWFyY2hpdmVcIik7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmNvcHlBdHRyaWJ1dGVzKCRmcm9tX2ZpZWxkLCAkdG9fZmllbGQpO1xyXG5cclxuICAgICAgICAgICAgICAgIGxpX2l0Kys7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgLyp2YXIgJGZyb21fZmllbGRzID0gJGxpc3RfZnJvbS5maW5kKFwiIHVsID4gbGlcIik7XHJcbiAgICAgICAgICAgICB2YXIgJHRvX2ZpZWxkcyA9ICRsaXN0X3RvLmZpbmQoXCIgPiBsaVwiKTtcclxuICAgICAgICAgICAgICRmcm9tX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGluZGV4LCB2YWwpe1xyXG4gICAgICAgICAgICAgaWYoJCh0aGlzKS5oYXNBdHRyaWJ1dGUoXCJkYXRhLXNmLXRheG9ub215LWFyY2hpdmVcIikpXHJcbiAgICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgdGhpcy5jb3B5QXR0cmlidXRlcygkbGlzdF9mcm9tLCAkbGlzdF90byk7Ki9cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlRm9ybUF0dHJpYnV0ZXMgPSBmdW5jdGlvbigkbGlzdF9mcm9tLCAkbGlzdF90bylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBmcm9tX2F0dHJpYnV0ZXMgPSAkbGlzdF9mcm9tLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggPHNlbGVjdD4gYXR0cmlidXRlcyBhbmQgYXBwbHkgdGhlbSBvbiA8ZGl2PlxyXG5cclxuICAgICAgICAgICAgdmFyIHRvX2F0dHJpYnV0ZXMgPSAkbGlzdF90by5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgJC5lYWNoKHRvX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJGxpc3RfdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICQuZWFjaChmcm9tX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJGxpc3RfdG8uYXR0cih0aGlzLm5hbWUsIHRoaXMudmFsdWUpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzID0gZnVuY3Rpb24oJGZyb20sICR0bywgcHJlZml4KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKHByZWZpeCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBwcmVmaXggPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gJGZyb20ucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcblxyXG4gICAgICAgICAgICB2YXIgdG9fYXR0cmlidXRlcyA9ICR0by5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgJC5lYWNoKHRvX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHByZWZpeCE9XCJcIikge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICh0aGlzLm5hbWUuaW5kZXhPZihwcmVmaXgpID09IDApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRvLnJlbW92ZUF0dHIodGhpcy5uYW1lKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8kdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICQuZWFjaChmcm9tX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJHRvLmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmNvcHlGb3JtQXR0cmlidXRlcyA9IGZ1bmN0aW9uKCRmcm9tLCAkdG8pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAkdG8ucmVtb3ZlQXR0cihcImRhdGEtY3VycmVudC10YXhvbm9teS1hcmNoaXZlXCIpO1xyXG4gICAgICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzKCRmcm9tLCAkdG8pO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlRm9ybSA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKGRhdGFbJ2Zvcm0nXSkhPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLm9mZigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3JlZnJlc2ggdGhlIGZvcm0gKGF1dG8gY291bnQpXHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5TGlzdEl0ZW1zQ29udGVudHMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmUgaW5pdCBTJkYgY2xhc3Mgb24gdGhlIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLnNlYXJjaEFuZEZpbHRlcigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL2lmIGFqYXggaXMgZW5hYmxlZCBpbml0IHRoZSBwYWdpbmF0aW9uXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHRoaXMuaW5pdCh0cnVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5zZXR1cEFqYXhQYWdpbmF0aW9uKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5hZGRSZXN1bHRzID0gZnVuY3Rpb24oZGF0YSwgZGF0YV90eXBlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgaWYoZGF0YV90eXBlPT1cImpzb25cIilcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSBkaWQgYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50LCBzbyBleHBlY3QgYW4gb2JqZWN0IGJhY2tcclxuICAgICAgICAgICAgICAgIC8vZ3JhYiB0aGUgcmVzdWx0cyBhbmQgbG9hZCBpblxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmFwcGVuZChkYXRhWydyZXN1bHRzJ10pO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9IGRhdGFbJ3Jlc3VsdHMnXTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKGRhdGFfdHlwZT09XCJodG1sXCIpXHJcbiAgICAgICAgICAgIHsvL3dlIGFyZSBleHBlY3RpbmcgdGhlIGh0bWwgb2YgdGhlIHJlc3VsdHMgcGFnZSBiYWNrLCBzbyBleHRyYWN0IHRoZSBodG1sIHdlIG5lZWRcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGRhdGFfb2JqID0gJChkYXRhKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuYXBwZW5kKCRkYXRhX29iai5maW5kKHNlbGYuYWpheF90YXJnZXRfYXR0cikuaHRtbCgpKTtcclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSAkZGF0YV9vYmouZmluZChzZWxmLmFqYXhfdGFyZ2V0X2F0dHIpLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGluZmluaXRlX3Njcm9sbF9lbmQgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIGlmKCQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChcIltkYXRhLXNlYXJjaC1maWx0ZXItYWN0aW9uPSdpbmZpbml0ZS1zY3JvbGwtZW5kJ11cIikubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGluZmluaXRlX3Njcm9sbF9lbmQgPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvL2lmIHRoZXJlIGlzIGFub3RoZXIgc2VsZWN0b3IgZm9yIGluZmluaXRlIHNjcm9sbCwgZmluZCB0aGUgY29udGVudHMgb2YgdGhhdCBpbnN0ZWFkXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIpLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciAkcmVzdWx0X2l0ZW1zID0gJChcIjxkaXY+XCIrc2VsZi5sb2FkX21vcmVfaHRtbCtcIjwvZGl2PlwiKS5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJHJlc3VsdF9pdGVtc19jb250YWluZXIgPSAkKCc8ZGl2Lz4nLCB7fSk7XHJcbiAgICAgICAgICAgICAgICAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lci5hcHBlbmQoJHJlc3VsdF9pdGVtcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICRyZXN1bHRfaXRlbXNfY29udGFpbmVyLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoaW5maW5pdGVfc2Nyb2xsX2VuZClcclxuICAgICAgICAgICAgey8vd2UgZm91bmQgYSBkYXRhIGF0dHJpYnV0ZSBzaWduYWxsaW5nIHRoZSBsYXN0IHBhZ2Ugc28gZmluaXNoIGhlcmVcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBzZWxmLmxvYWRfbW9yZV9odG1sO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoc2VsZi5sb2FkX21vcmVfaHRtbCk7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5sYXN0X2xvYWRfbW9yZV9odG1sIT09c2VsZi5sb2FkX21vcmVfaHRtbClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9jaGVjayB0byBtYWtlIHN1cmUgdGhlIG5ldyBodG1sIGZldGNoZWQgaXMgZGlmZmVyZW50XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBzZWxmLmxvYWRfbW9yZV9odG1sO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pbmZpbml0ZVNjcm9sbEFwcGVuZChzZWxmLmxvYWRfbW9yZV9odG1sKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly93ZSByZWNlaXZlZCB0aGUgc2FtZSBtZXNzYWdlIGFnYWluIHNvIGRvbid0IGFkZCwgYW5kIHRlbGwgUyZGIHRoYXQgd2UncmUgYXQgdGhlIGVuZC4uXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB0aGlzLmluZmluaXRlU2Nyb2xsQXBwZW5kID0gZnVuY3Rpb24oJG9iamVjdClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcykubGFzdCgpLmFmdGVyKCRvYmplY3QpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmFwcGVuZCgkb2JqZWN0KTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlUmVzdWx0cyA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXHJcbiAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJlc3VsdHMgYW5kIGxvYWQgaW5cclxuICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuaHRtbChkYXRhWydyZXN1bHRzJ10pO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihkYXRhWydmb3JtJ10pIT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBhbGwgZXZlbnRzIGZyb20gUyZGIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYucmVtb3ZlQWpheFBhZ2luYXRpb24oKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUxpc3RJdGVtc0NvbnRlbnRzKCQoZGF0YVsnZm9ybSddKSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3VwZGF0ZSBhdHRyaWJ1dGVzIG9uIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlGb3JtQXR0cmlidXRlcygkKGRhdGFbJ2Zvcm0nXSksICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLnNlYXJjaEFuZEZpbHRlcih7J2lzSW5pdCc6IGZhbHNlfSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8kdGhpcy5maW5kKFwiaW5wdXRcIikucmVtb3ZlQXR0cihcImRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoZGF0YV90eXBlPT1cImh0bWxcIikgey8vd2UgYXJlIGV4cGVjdGluZyB0aGUgaHRtbCBvZiB0aGUgcmVzdWx0cyBwYWdlIGJhY2ssIHNvIGV4dHJhY3QgdGhlIGh0bWwgd2UgbmVlZFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZGF0YV9vYmogPSAkKGRhdGEpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuaHRtbCgkZGF0YV9vYmouZmluZChzZWxmLmFqYXhfdGFyZ2V0X2F0dHIpLmh0bWwoKSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYgKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJcIikubGVuZ3RoID4gMClcclxuICAgICAgICAgICAgICAgIHsvL3RoZW4gdGhlcmUgYXJlIHNlYXJjaCBmb3JtKHMpIGluc2lkZSB0aGUgcmVzdWx0cyBjb250YWluZXIsIHNvIHJlLWluaXQgdGhlbVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLnNlYXJjaEFuZEZpbHRlcigpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vaWYgdGhlIGN1cnJlbnQgc2VhcmNoIGZvcm0gaXMgbm90IGluc2lkZSB0aGUgcmVzdWx0cyBjb250YWluZXIsIHRoZW4gcHJvY2VlZCBhcyBub3JtYWwgYW5kIHVwZGF0ZSB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiICsgc2VsZi5zZmlkICsgXCInXVwiKS5sZW5ndGg9PTApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRuZXdfc2VhcmNoX2Zvcm0gPSAkZGF0YV9vYmouZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJbZGF0YS1zZi1mb3JtLWlkPSdcIiArIHNlbGYuc2ZpZCArIFwiJ11cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmICgkbmV3X3NlYXJjaF9mb3JtLmxlbmd0aCA9PSAxKSB7Ly90aGVuIHJlcGxhY2UgdGhlIHNlYXJjaCBmb3JtIHdpdGggdGhlIG5ldyBvbmVcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5yZW1vdmVBamF4UGFnaW5hdGlvbigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlMaXN0SXRlbXNDb250ZW50cygkbmV3X3NlYXJjaF9mb3JtLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3VwZGF0ZSBhdHRyaWJ1dGVzIG9uIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5Rm9ybUF0dHJpYnV0ZXMoJG5ld19zZWFyY2hfZm9ybSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy5zZWFyY2hBbmRGaWx0ZXIoeydpc0luaXQnOiBmYWxzZX0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLmZpbmQoXCJpbnB1dFwiKS5yZW1vdmVBdHRyKFwiZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IGZhbHNlOyAvL2ZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgc2VsZi5jdXJyZW50X3BhZ2VkID0gMTsgLy9mb3IgaW5maW5pdGUgc2Nyb2xsXHJcbiAgICAgICAgICAgIHNlbGYuc2V0SW5maW5pdGVTY3JvbGxDb250YWluZXIoKTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnJlbW92ZVdvb0NvbW1lcmNlQ29udHJvbHMgPSBmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5ID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nIC5vcmRlcmJ5Jyk7XHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnlfZm9ybSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZycpO1xyXG5cclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5X2Zvcm0ub2ZmKCk7XHJcbiAgICAgICAgICAgICR3b29fb3JkZXJieS5vZmYoKTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmFkZFF1ZXJ5UGFyYW0gPSBmdW5jdGlvbihuYW1lLCB2YWx1ZSwgdXJsX3R5cGUpe1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHVybF90eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHVybF90eXBlID0gXCJhbGxcIjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1t1cmxfdHlwZV1bbmFtZV0gPSB2YWx1ZTtcclxuXHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5pbml0V29vQ29tbWVyY2VDb250cm9scyA9IGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICBzZWxmLnJlbW92ZVdvb0NvbW1lcmNlQ29udHJvbHMoKTtcclxuXHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnkgPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcgLm9yZGVyYnknKTtcclxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieV9mb3JtID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nJyk7XHJcblxyXG4gICAgICAgICAgICB2YXIgb3JkZXJfdmFsID0gXCJcIjtcclxuICAgICAgICAgICAgaWYoJHdvb19vcmRlcmJ5Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSAkd29vX29yZGVyYnkudmFsKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwib3JkZXJieVwiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKG9yZGVyX3ZhbD09XCJtZW51X29yZGVyXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKChvcmRlcl92YWwhPVwiXCIpJiYoISFvcmRlcl92YWwpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5hbGwub3JkZXJieSA9IG9yZGVyX3ZhbDtcclxuICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICR3b29fb3JkZXJieV9mb3JtLm9uKCdzdWJtaXQnLCBmdW5jdGlvbihlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICAvL3ZhciBmb3JtID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5Lm9uKFwiY2hhbmdlXCIsIGZ1bmN0aW9uKGUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gJCh0aGlzKS52YWwoKTtcclxuICAgICAgICAgICAgICAgIGlmKHZhbD09XCJtZW51X29yZGVyXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFsID0gXCJcIjtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5hbGwub3JkZXJieSA9IHZhbDtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5zdWJtaXQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuc2Nyb2xsUmVzdWx0cyA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKChzZWxmLnNjcm9sbF9vbl9hY3Rpb249PXNlbGYuYWpheF9hY3Rpb24pfHwoc2VsZi5zY3JvbGxfb25fYWN0aW9uPT1cImFsbFwiKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zY3JvbGxUb1BvcygpOyAvL3Njcm9sbCB0aGUgd2luZG93IGlmIGl0IGhhcyBiZWVuIHNldFxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmFqYXhfYWN0aW9uID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy51cGRhdGVVcmxIaXN0b3J5ID0gZnVuY3Rpb24oYWpheF9yZXN1bHRzX3VybClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIHZhciB1c2VfaGlzdG9yeV9hcGkgPSAwO1xyXG4gICAgICAgICAgICBpZiAod2luZG93Lmhpc3RvcnkgJiYgd2luZG93Lmhpc3RvcnkucHVzaFN0YXRlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB1c2VfaGlzdG9yeV9hcGkgPSAkdGhpcy5hdHRyKFwiZGF0YS11c2UtaGlzdG9yeS1hcGlcIik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKChzZWxmLnVwZGF0ZV9hamF4X3VybD09MSkmJih1c2VfaGlzdG9yeV9hcGk9PTEpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAvL25vdyBjaGVjayBpZiB0aGUgYnJvd3NlciBzdXBwb3J0cyBoaXN0b3J5IHN0YXRlIHB1c2ggOilcclxuICAgICAgICAgICAgICAgIGlmICh3aW5kb3cuaGlzdG9yeSAmJiB3aW5kb3cuaGlzdG9yeS5wdXNoU3RhdGUpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaGlzdG9yeS5wdXNoU3RhdGUobnVsbCwgbnVsbCwgYWpheF9yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5yZW1vdmVBamF4UGFnaW5hdGlvbiA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpIT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGFqYXhfbGlua3Nfb2JqZWN0ID0galF1ZXJ5KHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJGFqYXhfbGlua3Nfb2JqZWN0Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICRhamF4X2xpbmtzX29iamVjdC5vZmYoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5jYW5GZXRjaEFqYXhSZXN1bHRzID0gZnVuY3Rpb24oZmV0Y2hfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihmZXRjaF90eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGZldGNoX3R5cGUgPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcbiAgICAgICAgICAgIHZhciBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIGFqYXggc3VibWl0IHRoZSBmb3JtXHJcblxyXG4gICAgICAgICAgICAgICAgLy9hbmQgaWYgd2UgY2FuIGZpbmQgdGhlIHJlc3VsdHMgY29udGFpbmVyXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmxlbmd0aD09MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHNlbGYucmVzdWx0c191cmw7ICAvL1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsX2VuY29kZWQgPSAnJzsgIC8vXHJcbiAgICAgICAgICAgICAgICB2YXIgY3VycmVudF91cmwgPSB3aW5kb3cubG9jYXRpb24uaHJlZjtcclxuXHJcbiAgICAgICAgICAgICAgICAvL2lnbm9yZSAjIGFuZCBldmVyeXRoaW5nIGFmdGVyXHJcbiAgICAgICAgICAgICAgICB2YXIgaGFzaF9wb3MgPSB3aW5kb3cubG9jYXRpb24uaHJlZi5pbmRleE9mKCcjJyk7XHJcbiAgICAgICAgICAgICAgICBpZihoYXNoX3BvcyE9PS0xKXtcclxuICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybCA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmLnN1YnN0cigwLCB3aW5kb3cubG9jYXRpb24uaHJlZi5pbmRleE9mKCcjJykpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKCAoICggc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwiY3VzdG9tX3dvb2NvbW1lcmNlX3N0b3JlXCIgKSB8fCAoIHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cInBvc3RfdHlwZV9hcmNoaXZlXCIgKSApICYmICggc2VsZi5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMgPT0gMSApIClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiggc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgIT09XCJcIiApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmV0Y2hfYWpheF9yZXN1bHRzO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLyp2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgICAgICAgdmFyIGFjdGl2ZV90YXggPSBwcm9jZXNzX2Zvcm0uZ2V0QWN0aXZlVGF4KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyh0cnVlLCAnJywgYWN0aXZlX3RheCk7Ki9cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAvL25vdyBzZWUgaWYgd2UgYXJlIG9uIHRoZSBVUkwgd2UgdGhpbmsuLi5cclxuICAgICAgICAgICAgICAgIHZhciB1cmxfcGFydHMgPSBjdXJyZW50X3VybC5zcGxpdChcIj9cIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgdXJsX2Jhc2UgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHVybF9wYXJ0cy5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9wYXJ0c1swXTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgIHVybF9iYXNlID0gY3VycmVudF91cmw7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIGxhbmcgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwibGFuZ1wiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcbiAgICAgICAgICAgICAgICBpZigodHlwZW9mKGxhbmcpIT09XCJ1bmRlZmluZWRcIikmJihsYW5nIT09bnVsbCkpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSBzZWxmLmFkZFVybFBhcmFtKHVybF9iYXNlLCBcImxhbmc9XCIrbGFuZyk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHNmaWQgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwic2ZpZFwiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9pZiBzZmlkIGlzIGEgbnVtYmVyXHJcbiAgICAgICAgICAgICAgICBpZihOdW1iZXIocGFyc2VGbG9hdChzZmlkKSkgPT0gc2ZpZClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHNlbGYuYWRkVXJsUGFyYW0odXJsX2Jhc2UsIFwic2ZpZD1cIitzZmlkKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAvL2lmIGFueSBvZiB0aGUgMyBjb25kaXRpb25zIGFyZSB0cnVlLCB0aGVuIGl0cyBnb29kIHRvIGdvXHJcbiAgICAgICAgICAgICAgICAvLyAtIDEgfCBpZiB0aGUgdXJsIGJhc2UgPT0gcmVzdWx0c191cmxcclxuICAgICAgICAgICAgICAgIC8vIC0gMiB8IGlmIHVybCBiYXNlKyBcIi9cIiAgPT0gcmVzdWx0c191cmwgLSBpbiBjYXNlIG9mIHVzZXIgZXJyb3IgaW4gdGhlIHJlc3VsdHMgVVJMXHJcblxyXG4gICAgICAgICAgICAgICAgLy90cmltIGFueSB0cmFpbGluZyBzbGFzaCBmb3IgZWFzaWVyIGNvbXBhcmlzb246XHJcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9iYXNlLnJlcGxhY2UoL1xcLyQvLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybCA9IHJlc3VsdHNfdXJsLnJlcGxhY2UoL1xcLyQvLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybF9lbmNvZGVkID0gZW5jb2RlVVJJKHJlc3VsdHNfdXJsLnJlcGxhY2UoL1xcLyQvLCAnJykpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IC0xO1xyXG4gICAgICAgICAgICAgICAgaWYoKHVybF9iYXNlPT1yZXN1bHRzX3VybCl8fCh1cmxfYmFzZS50b0xvd2VyQ2FzZSgpPT1yZXN1bHRzX3VybF9lbmNvZGVkLnRvTG93ZXJDYXNlKCkpKXtcclxuICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IDE7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5vbmx5X3Jlc3VsdHNfYWpheD09MSlcclxuICAgICAgICAgICAgICAgIHsvL2lmIGEgdXNlciBoYXMgY2hvc2VuIHRvIG9ubHkgYWxsb3cgYWpheCBvbiByZXN1bHRzIHBhZ2VzIChkZWZhdWx0IGJlaGF2aW91cilcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID4gLTEpXHJcbiAgICAgICAgICAgICAgICAgICAgey8vdGhpcyBtZWFucyB0aGUgY3VycmVudCBVUkwgY29udGFpbnMgdGhlIHJlc3VsdHMgdXJsLCB3aGljaCBtZWFucyB3ZSBjYW4gZG8gYWpheFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZmV0Y2hfdHlwZT09XCJwYWdpbmF0aW9uXCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiggY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPiAtMSlcclxuICAgICAgICAgICAgICAgICAgICAgICAgey8vdGhpcyBtZWFucyB0aGUgY3VycmVudCBVUkwgY29udGFpbnMgdGhlIHJlc3VsdHMgdXJsLCB3aGljaCBtZWFucyB3ZSBjYW4gZG8gYWpheFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vZG9uJ3QgYWpheCBwYWdpbmF0aW9uIHdoZW4gbm90IG9uIGEgUyZGIHBhZ2VcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gZmV0Y2hfYWpheF9yZXN1bHRzO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zZXR1cEFqYXhQYWdpbmF0aW9uID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy9pbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgaWYodGhpcy5wYWdpbmF0aW9uX3R5cGU9PT1cImluZmluaXRlX3Njcm9sbFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiW2RhdGEtc2VhcmNoLWZpbHRlci1hY3Rpb249J2luZmluaXRlLXNjcm9sbC1lbmQnXVwiKS5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpbmZpbml0ZV9zY3JvbGxfZW5kID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYocGFyc2VJbnQodGhpcy5pbnN0YW5jZV9udW1iZXIpPT09MSkge1xyXG4gICAgICAgICAgICAgICAgICAgICQod2luZG93KS5vZmYoXCJzY3JvbGxcIiwgc2VsZi5vbldpbmRvd1Njcm9sbCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmIChzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoXCJwYWdpbmF0aW9uXCIpKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQod2luZG93KS5vbihcInNjcm9sbFwiLCBzZWxmLm9uV2luZG93U2Nyb2xsKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIC8vdmFyICRhamF4X2xpbmtzX29iamVjdCA9IGpRdWVyeShzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpO1xyXG5cclxuICAgICAgICAgICAgLy9pZigkYWpheF9saW5rc19vYmplY3QubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIC8ve1xyXG4gICAgICAgICAgICAgICAgLy9jb25zb2xlLmxvZyhcImluaXQgcGFnaW5hdGlvbiBzdHVmZlwiKTtcclxuICAgICAgICAgICAgICAgIC8vJGFqYXhfbGlua3Nfb2JqZWN0Lm9mZignY2xpY2snKTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgJChkb2N1bWVudCkub2ZmKCdjbGljaycsIHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vZmYoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcclxuICAgICAgICAgICAgICAgICQoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKS5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vbignY2xpY2snLCBzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IsIGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoXCJwYWdpbmF0aW9uXCIpKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGxpbmsgPSBqUXVlcnkodGhpcykuYXR0cignaHJlZicpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gXCJwYWdpbmF0aW9uXCI7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuZ2V0UGFnZWRGcm9tVVJMKGxpbmspO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiLCBwYWdlTnVtYmVyKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuZmV0Y2hBamF4UmVzdWx0cygpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgIC8vIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmdldFBhZ2VkRnJvbVVSTCA9IGZ1bmN0aW9uKFVSTCl7XHJcblxyXG4gICAgICAgICAgICB2YXIgcGFnZWRWYWwgPSAxO1xyXG4gICAgICAgICAgICAvL2ZpcnN0IHRlc3QgdG8gc2VlIGlmIHdlIGhhdmUgXCIvcGFnZS80L1wiIGluIHRoZSBVUkxcclxuICAgICAgICAgICAgdmFyIHRwVmFsID0gc2VsZi5nZXRRdWVyeVBhcmFtRnJvbVVSTChcInNmX3BhZ2VkXCIsIFVSTCk7XHJcbiAgICAgICAgICAgIGlmKCh0eXBlb2YodHBWYWwpPT1cInN0cmluZ1wiKXx8KHR5cGVvZih0cFZhbCk9PVwibnVtYmVyXCIpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBwYWdlZFZhbCA9IHRwVmFsO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gcGFnZWRWYWw7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5nZXRRdWVyeVBhcmFtRnJvbVVSTCA9IGZ1bmN0aW9uKG5hbWUsIFVSTCl7XHJcblxyXG4gICAgICAgICAgICB2YXIgcXN0cmluZyA9IFwiP1wiK1VSTC5zcGxpdCgnPycpWzFdO1xyXG4gICAgICAgICAgICBpZih0eXBlb2YocXN0cmluZykhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBkZWNvZGVVUklDb21wb25lbnQoKG5ldyBSZWdFeHAoJ1s/fCZdJyArIG5hbWUgKyAnPScgKyAnKFteJjtdKz8pKCZ8I3w7fCQpJykuZXhlYyhxc3RyaW5nKXx8WyxcIlwiXSlbMV0ucmVwbGFjZSgvXFwrL2csICclMjAnKSl8fG51bGw7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gdmFsO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHJldHVybiBcIlwiO1xyXG4gICAgICAgIH07XHJcblxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5mb3JtVXBkYXRlZCA9IGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgLy9lLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgIGlmKHNlbGYuYXV0b191cGRhdGU9PTEpIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoKHNlbGYuYXV0b191cGRhdGU9PTApJiYoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuZm9ybVVwZGF0ZWRGZXRjaEFqYXgoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZm9ybVVwZGF0ZWRGZXRjaEFqYXggPSBmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgLy9sb29wIHRocm91Z2ggYWxsIHRoZSBmaWVsZHMgYW5kIGJ1aWxkIHRoZSBVUkxcclxuICAgICAgICAgICAgc2VsZi5mZXRjaEFqYXhGb3JtKCk7XHJcblxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIC8vbWFrZSBhbnkgY29ycmVjdGlvbnMvdXBkYXRlcyB0byBmaWVsZHMgYmVmb3JlIHRoZSBzdWJtaXQgY29tcGxldGVzXHJcbiAgICAgICAgdGhpcy5zZXRGaWVsZHMgPSBmdW5jdGlvbihlKXtcclxuXHJcbiAgICAgICAgICAgIC8vaWYoc2VsZi5pc19hamF4PT0wKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zb21ldGltZXMgdGhlIGZvcm0gaXMgc3VibWl0dGVkIHdpdGhvdXQgdGhlIHNsaWRlciB5ZXQgaGF2aW5nIHVwZGF0ZWQsIGFuZCBhcyB3ZSBnZXQgb3VyIHZhbHVlcyBmcm9tXHJcbiAgICAgICAgICAgICAgICAvL3RoZSBzbGlkZXIgYW5kIG5vdCBpbnB1dHMsIHdlIG5lZWQgdG8gY2hlY2sgaXQgaWYgbmVlZHMgdG8gYmUgc2V0XHJcbiAgICAgICAgICAgICAgICAvL29ubHkgb2NjdXJzIGlmIGFqYXggaXMgb2ZmLCBhbmQgYXV0b3N1Ym1pdCBvblxyXG4gICAgICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkZmllbGQgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgcmFuZ2VfZGlzcGxheV92YWx1ZXMgPSAkZmllbGQuZmluZCgnLnNmLW1ldGEtcmFuZ2Utc2xpZGVyJykuYXR0cihcImRhdGEtZGlzcGxheS12YWx1ZXMtYXNcIik7Ly9kYXRhLWRpc3BsYXktdmFsdWVzLWFzPVwidGV4dFwiXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHJhbmdlX2Rpc3BsYXlfdmFsdWVzPT09XCJ0ZXh0aW5wdXRcIikge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGZpZWxkLmZpbmQoXCIubWV0YS1zbGlkZXJcIikubGVuZ3RoPjApe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIi5tZXRhLXNsaWRlclwiKS5lYWNoKGZ1bmN0aW9uIChpbmRleCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfb2JqZWN0ID0gJCh0aGlzKVswXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkc2xpZGVyX2VsID0gJCh0aGlzKS5jbG9zZXN0KFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy92YXIgbWluVmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL3ZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBtaW5WYWwgPSAkc2xpZGVyX2VsLmZpbmQoXCIuc2YtcmFuZ2UtbWluXCIpLnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG1heFZhbCA9ICRzbGlkZXJfZWwuZmluZChcIi5zZi1yYW5nZS1tYXhcIikudmFsKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFttaW5WYWwsIG1heFZhbF0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIC8vfVxyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIC8vc3VibWl0XHJcbiAgICAgICAgdGhpcy5zdWJtaXRGb3JtID0gZnVuY3Rpb24oZSl7XHJcblxyXG4gICAgICAgICAgICAvL2xvb3AgdGhyb3VnaCBhbGwgdGhlIGZpZWxkcyBhbmQgYnVpbGQgdGhlIFVSTFxyXG4gICAgICAgICAgICBpZihzZWxmLmlzU3VibWl0dGluZyA9PSB0cnVlKSB7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYuc2V0RmllbGRzKCk7XHJcbiAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSB0cnVlO1xyXG5cclxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiLCAxKTsgLy9pbml0IHBhZ2VkXHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoKSlcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIGFqYXggc3VibWl0IHRoZSBmb3JtXHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X2FjdGlvbiA9IFwic3VibWl0XCI7IC8vc28gd2Uga25vdyBpdCB3YXNuJ3QgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgc2VsZi5mZXRjaEFqYXhSZXN1bHRzKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgc2ltcGx5IHJlZGlyZWN0IHRvIHRoZSBSZXN1bHRzIFVSTFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHByb2Nlc3NfZm9ybS5nZXRSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUsICcnKTtcclxuICAgICAgICAgICAgICAgIHJlc3VsdHNfdXJsID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9IHJlc3VsdHNfdXJsO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvKmlmKHNlbGYubWFpbnRhaW5fc3RhdGU9PVwiMVwiKVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgLy9hbGVydChcIm1haW50YWluIHN0YXRlXCIpO1xyXG4gICAgICAgICAgICAgdmFyIGluRmlmdGVlbk1pbnV0ZXMgPSBuZXcgRGF0ZShuZXcgRGF0ZSgpLmdldFRpbWUoKSArIDE1ICogNjAgKiAxMDAwKTtcclxuICAgICAgICAgICAgIC8vaHR0cHM6Ly9naXRodWIuY29tL2pzLWNvb2tpZS9qcy1jb29raWUvd2lraS9GcmVxdWVudGx5LUFza2VkLVF1ZXN0aW9ucyNleHBpcmUtY29va2llcy1pbi1sZXNzLXRoYW4tYS1kYXlcclxuICAgICAgICAgICAgIHZhciB0aGlydHltaW51dGVzID0gMS80ODtcclxuICAgICAgICAgICAgIC8vY29va2llcy5zZXQoJ25hbWUnLCAnbXJyb3NzJywgeyBleHBpcmVzOiA3IH0pO1xyXG4gICAgICAgICAgICAgLy9jb29raWVzLnNldCgnbmFtZScsICdtcnJvc3MnLCB7IGV4cGlyZXM6IHRoaXJ0eW1pbnV0ZXMgfSk7XHJcbiAgICAgICAgICAgICBjb29raWVzLnNldCgnbmFtZScsICdtcnJvc3MnLCB7IGV4cGlyZXM6IGluRmlmdGVlbk1pbnV0ZXMgfSk7XHJcbiAgICAgICAgICAgICB9Ki9cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICB9O1xyXG4gICAgICAgIC8vIGNvbnNvbGUubG9nKGNvb2tpZXMuZ2V0KCduYW1lJykpO1xyXG4gICAgICAgIC8vY29uc29sZS5sb2coY29va2llcy5nZXQoJ25hbWUnKSk7XHJcbiAgICAgICAgdGhpcy5yZXNldEZvcm0gPSBmdW5jdGlvbihzdWJtaXRfZm9ybSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIC8vdW5zZXQgYWxsIGZpZWxkc1xyXG4gICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZmllbGQgPSAkKHRoaXMpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdCRmaWVsZC5yZW1vdmVBdHRyKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpO1xyXG5cdFx0XHRcdFxyXG4gICAgICAgICAgICAgICAgLy9zdGFuZGFyZCBmaWVsZCB0eXBlc1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJzZWxlY3Q6bm90KFttdWx0aXBsZT0nbXVsdGlwbGUnXSkgPiBvcHRpb246Zmlyc3QtY2hpbGRcIikucHJvcChcInNlbGVjdGVkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJzZWxlY3RbbXVsdGlwbGU9J211bHRpcGxlJ10gPiBvcHRpb25cIikucHJvcChcInNlbGVjdGVkXCIsIGZhbHNlKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiaW5wdXRbdHlwZT0nY2hlY2tib3gnXVwiKS5wcm9wKFwiY2hlY2tlZFwiLCBmYWxzZSk7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIj4gdWwgPiBsaTpmaXJzdC1jaGlsZCBpbnB1dFt0eXBlPSdyYWRpbyddXCIpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJpbnB1dFt0eXBlPSd0ZXh0J11cIikudmFsKFwiXCIpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCIuc2Ytb3B0aW9uLWFjdGl2ZVwiKS5yZW1vdmVDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIj4gdWwgPiBsaTpmaXJzdC1jaGlsZCBpbnB1dFt0eXBlPSdyYWRpbyddXCIpLnBhcmVudCgpLmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTsgLy9yZSBhZGQgYWN0aXZlIGNsYXNzIHRvIGZpcnN0IFwiZGVmYXVsdFwiIG9wdGlvblxyXG5cclxuICAgICAgICAgICAgICAgIC8vbnVtYmVyIHJhbmdlIC0gMiBudW1iZXIgaW5wdXQgZmllbGRzXHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcImlucHV0W3R5cGU9J251bWJlciddXCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNJbnB1dCA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCR0aGlzSW5wdXQucGFyZW50KCkucGFyZW50KCkuaGFzQ2xhc3MoXCJzZi1tZXRhLXJhbmdlXCIpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoJHRoaXNJbnB1dC5hdHRyKFwibWluXCIpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbCgkdGhpc0lucHV0LmF0dHIoXCJtYXhcIikpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vbWV0YSAvIG51bWJlcnMgd2l0aCAyIGlucHV0cyAoZnJvbSAvIHRvIGZpZWxkcykgLSBzZWNvbmQgaW5wdXQgbXVzdCBiZSByZXNldCB0byBtYXggdmFsdWVcclxuICAgICAgICAgICAgICAgIHZhciAkbWV0YV9zZWxlY3RfZnJvbV90byA9ICRmaWVsZC5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2VsZWN0LWZyb210b1wiKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigkbWV0YV9zZWxlY3RfZnJvbV90by5sZW5ndGg+MCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWluID0gJG1ldGFfc2VsZWN0X2Zyb21fdG8uYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9tYXggPSAkbWV0YV9zZWxlY3RfZnJvbV90by5hdHRyKFwiZGF0YS1tYXhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRtZXRhX3NlbGVjdF9mcm9tX3RvLmZpbmQoXCJzZWxlY3RcIikuZWFjaChmdW5jdGlvbihpbmRleCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNJbnB1dCA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKHN0YXJ0X21pbik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihpbmRleD09MSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoc3RhcnRfbWF4KTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJG1ldGFfcmFkaW9fZnJvbV90byA9ICRmaWVsZC5maW5kKFwiLnNmLW1ldGEtcmFuZ2UtcmFkaW8tZnJvbXRvXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCRtZXRhX3JhZGlvX2Zyb21fdG8ubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21pbiA9ICRtZXRhX3JhZGlvX2Zyb21fdG8uYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9tYXggPSAkbWV0YV9yYWRpb19mcm9tX3RvLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRyYWRpb19ncm91cHMgPSAkbWV0YV9yYWRpb19mcm9tX3RvLmZpbmQoJy5zZi1pbnB1dC1yYW5nZS1yYWRpbycpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkcmFkaW9fZ3JvdXBzLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkcmFkaW9zID0gJCh0aGlzKS5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLnByb3AoXCJjaGVja2VkXCIsIGZhbHNlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGluZGV4PT0wKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLmZpbHRlcignW3ZhbHVlPVwiJytzdGFydF9taW4rJ1wiXScpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoaW5kZXg9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRyYWRpb3MuZmlsdGVyKCdbdmFsdWU9XCInK3N0YXJ0X21heCsnXCJdJykucHJvcChcImNoZWNrZWRcIiwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vbnVtYmVyIHNsaWRlciAtIG5vVWlTbGlkZXJcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX29iamVjdCA9ICQodGhpcylbMF07XHJcbiAgICAgICAgICAgICAgICAgICAgLyp2YXIgc2xpZGVyX29iamVjdCA9ICRjb250YWluZXIuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcclxuICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl92YWwgPSBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZ2V0KCk7Ki9cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzbGlkZXJfZWwgPSAkKHRoaXMpLmNsb3Nlc3QoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1pblZhbCA9ICRzbGlkZXJfZWwuYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFttaW5WYWwsIG1heFZhbF0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vbmVlZCB0byBzZWUgaWYgYW55IGFyZSBjb21ib2JveCBhbmQgYWN0IGFjY29yZGluZ2x5XHJcbiAgICAgICAgICAgICAgICB2YXIgJGNvbWJvYm94ID0gJGZpZWxkLmZpbmQoXCJzZWxlY3RbZGF0YS1jb21ib2JveD0nMSddXCIpO1xyXG4gICAgICAgICAgICAgICAgaWYoJGNvbWJvYm94Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICh0eXBlb2YgJGNvbWJvYm94LmNob3NlbiAhPSBcInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTsgLy9mb3IgY2hvc2VuIG9ubHlcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnZhbCgnJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC50cmlnZ2VyKCdjaGFuZ2Uuc2VsZWN0MicpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7XHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgIGlmKHN1Ym1pdF9mb3JtPT1cImFsd2F5c1wiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHN1Ym1pdF9mb3JtPT1cIm5ldmVyXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5mb3JtVXBkYXRlZEZldGNoQWpheCgpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc3VibWl0X2Zvcm09PVwiYXV0b1wiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fdXBkYXRlPT10cnVlKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZvcm1VcGRhdGVkRmV0Y2hBamF4KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuaW5pdCgpO1xyXG5cclxuICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHt9O1xyXG4gICAgICAgIGV2ZW50X2RhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICBldmVudF9kYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgIGV2ZW50X2RhdGEub2JqZWN0ID0gdGhpcztcclxuICAgICAgICBpZihvcHRzLmlzSW5pdClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6aW5pdFwiLCBldmVudF9kYXRhKTtcclxuICAgICAgICB9XHJcblxyXG4gICAgfSk7XHJcbn07XHJcbiJdfQ==
},{"./process_form":7,"./state":8,"js-cookie":2,"nouislider":3}],7:[function(require,module,exports){
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
			$inputs.prop("disabled", true);
			$inputs.removeAttr("disabled");
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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbInNyYy9wdWJsaWMvYXNzZXRzL2pzL2luY2x1ZGVzL3Byb2Nlc3NfZm9ybS5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyJcclxudmFyICQgPSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xyXG5cclxubW9kdWxlLmV4cG9ydHMgPSB7XHJcblxyXG5cdHRheG9ub215X2FyY2hpdmVzOiAwLFxyXG4gICAgdXJsX3BhcmFtczoge30sXHJcbiAgICB0YXhfYXJjaGl2ZV9yZXN1bHRzX3VybDogXCJcIixcclxuICAgIGFjdGl2ZV90YXg6IFwiXCIsXHJcbiAgICBmaWVsZHM6IHt9LFxyXG5cdGluaXQ6IGZ1bmN0aW9uKHRheG9ub215X2FyY2hpdmVzLCBjdXJyZW50X3RheG9ub215X2FyY2hpdmUpe1xyXG5cclxuICAgICAgICB0aGlzLnRheG9ub215X2FyY2hpdmVzID0gMDtcclxuICAgICAgICB0aGlzLnVybF9wYXJhbXMgPSB7fTtcclxuICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICB0aGlzLmFjdGl2ZV90YXggPSBcIlwiO1xyXG5cclxuXHRcdC8vdGhpcy4kZmllbGRzID0gJGZpZWxkcztcclxuICAgICAgICB0aGlzLnRheG9ub215X2FyY2hpdmVzID0gdGF4b25vbXlfYXJjaGl2ZXM7XHJcbiAgICAgICAgdGhpcy5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgPSBjdXJyZW50X3RheG9ub215X2FyY2hpdmU7XHJcblxyXG5cdFx0dGhpcy5jbGVhclVybENvbXBvbmVudHMoKTtcclxuXHJcblx0fSxcclxuICAgIHNldFRheEFyY2hpdmVSZXN1bHRzVXJsOiBmdW5jdGlvbigkZm9ybSwgY3VycmVudF9yZXN1bHRzX3VybCwgZ2V0X2FjdGl2ZSkge1xyXG5cclxuICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcblxyXG4gICAgICAgIC8vdmFyIGN1cnJlbnRfcmVzdWx0c191cmwgPSBcIlwiO1xyXG4gICAgICAgIGlmKHRoaXMudGF4b25vbXlfYXJjaGl2ZXMhPTEpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YoZ2V0X2FjdGl2ZSk9PVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdHZhciBnZXRfYWN0aXZlID0gZmFsc2U7XHJcblx0XHR9XHJcblxyXG4gICAgICAgIC8vY2hlY2sgdG8gc2VlIGlmIHdlIGhhdmUgYW55IHRheG9ub21pZXMgc2VsZWN0ZWRcclxuICAgICAgICAvL2lmIHNvLCBjaGVjayB0aGVpciByZXdyaXRlcyBhbmQgdXNlIHRob3NlIGFzIHRoZSByZXN1bHRzIHVybFxyXG4gICAgICAgIHZhciAkZmllbGQgPSBmYWxzZTtcclxuICAgICAgICB2YXIgZmllbGRfbmFtZSA9IFwiXCI7XHJcbiAgICAgICAgdmFyIGZpZWxkX3ZhbHVlID0gXCJcIjtcclxuXHJcbiAgICAgICAgdmFyICRhY3RpdmVfdGF4b25vbXkgPSAkZm9ybS4kZmllbGRzLnBhcmVudCgpLmZpbmQoXCJbZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlPScxJ11cIik7XHJcbiAgICAgICAgaWYoJGFjdGl2ZV90YXhvbm9teS5sZW5ndGg9PTEpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAkZmllbGQgPSAkYWN0aXZlX3RheG9ub215O1xyXG5cclxuICAgICAgICAgICAgdmFyIGZpZWxkVHlwZSA9ICRmaWVsZC5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYgKChmaWVsZFR5cGUgPT0gXCJ0YWdcIikgfHwgKGZpZWxkVHlwZSA9PSBcImNhdGVnb3J5XCIpIHx8IChmaWVsZFR5cGUgPT0gXCJ0YXhvbm9teVwiKSkge1xyXG4gICAgICAgICAgICAgICAgdmFyIHRheG9ub215X3ZhbHVlID0gc2VsZi5wcm9jZXNzVGF4b25vbXkoJGZpZWxkLCB0cnVlKTtcclxuICAgICAgICAgICAgICAgIGZpZWxkX25hbWUgPSAkZmllbGQuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuICAgICAgICAgICAgICAgIHZhciB0YXhvbm9teV9uYW1lID0gZmllbGRfbmFtZS5yZXBsYWNlKFwiX3NmdF9cIiwgXCJcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYgKHRheG9ub215X3ZhbHVlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgZmllbGRfdmFsdWUgPSB0YXhvbm9teV92YWx1ZS52YWx1ZTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoZmllbGRfdmFsdWU9PVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRmaWVsZCA9IGZhbHNlO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZigoc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUhPVwiXCIpJiYoc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUhPXRheG9ub215X25hbWUpKVxyXG4gICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSBjdXJyZW50X3Jlc3VsdHNfdXJsO1xyXG4gICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZigoKGZpZWxkX3ZhbHVlPT1cIlwiKXx8KCEkZmllbGQpICkpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAkZm9ybS4kZmllbGRzLmVhY2goZnVuY3Rpb24gKCkge1xyXG5cclxuICAgICAgICAgICAgICAgIGlmICghJGZpZWxkKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZFR5cGUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmICgoZmllbGRUeXBlID09IFwidGFnXCIpIHx8IChmaWVsZFR5cGUgPT0gXCJjYXRlZ29yeVwiKSB8fCAoZmllbGRUeXBlID09IFwidGF4b25vbXlcIikpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHRheG9ub215X3ZhbHVlID0gc2VsZi5wcm9jZXNzVGF4b25vbXkoJCh0aGlzKSwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZpZWxkX25hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAodGF4b25vbXlfdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaWVsZF92YWx1ZSA9IHRheG9ub215X3ZhbHVlLnZhbHVlO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChmaWVsZF92YWx1ZSAhPSBcIlwiKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRmaWVsZCA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKCAoJGZpZWxkKSAmJiAoZmllbGRfdmFsdWUgIT0gXCJcIiApKSB7XHJcbiAgICAgICAgICAgIC8vaWYgd2UgZm91bmQgYSBmaWVsZFxyXG5cdFx0XHR2YXIgcmV3cml0ZV9hdHRyID0gKCRmaWVsZC5hdHRyKFwiZGF0YS1zZi10ZXJtLXJld3JpdGVcIikpO1xyXG5cclxuICAgICAgICAgICAgaWYocmV3cml0ZV9hdHRyIT1cIlwiKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHJld3JpdGUgPSBKU09OLnBhcnNlKHJld3JpdGVfYXR0cik7XHJcbiAgICAgICAgICAgICAgICB2YXIgaW5wdXRfdHlwZSA9ICRmaWVsZC5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hY3RpdmVfdGF4ID0gZmllbGRfbmFtZTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL2ZpbmQgdGhlIGFjdGl2ZSBlbGVtZW50XHJcbiAgICAgICAgICAgICAgICBpZiAoKGlucHV0X3R5cGUgPT0gXCJyYWRpb1wiKSB8fCAoaW5wdXRfdHlwZSA9PSBcImNoZWNrYm94XCIpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vdmFyICRhY3RpdmUgPSAkZmllbGQuZmluZChcIi5zZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vZXhwbG9kZSB0aGUgdmFsdWVzIGlmIHRoZXJlIGlzIGEgZGVsaW1cclxuICAgICAgICAgICAgICAgICAgICAvL2ZpZWxkX3ZhbHVlXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBpc19zaW5nbGVfdmFsdWUgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZF92YWx1ZXMgPSBmaWVsZF92YWx1ZS5zcGxpdChcIixcIikuam9pbihcIitcIikuc3BsaXQoXCIrXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChmaWVsZF92YWx1ZXMubGVuZ3RoID4gMSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpc19zaW5nbGVfdmFsdWUgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmIChpc19zaW5nbGVfdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkaW5wdXQgPSAkZmllbGQuZmluZChcImlucHV0W3ZhbHVlPSdcIiArIGZpZWxkX3ZhbHVlICsgXCInXVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkaW5wdXQucGFyZW50KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aCA9ICRhY3RpdmUuYXR0cihcImRhdGEtc2YtZGVwdGhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL25vdyBsb29wIHRocm91Z2ggcGFyZW50cyB0byBncmFiIHRoZWlyIG5hbWVzXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB2YWx1ZXMgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goZmllbGRfdmFsdWUpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgZm9yICh2YXIgaSA9IGRlcHRoOyBpID4gMDsgaS0tKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkYWN0aXZlID0gJGFjdGl2ZS5wYXJlbnQoKS5wYXJlbnQoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKCRhY3RpdmUuZmluZChcImlucHV0XCIpLnZhbCgpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnJldmVyc2UoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vZ3JhYiB0aGUgcmV3cml0ZSBmb3IgdGhpcyBkZXB0aFxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgYWN0aXZlX3Jld3JpdGUgPSByZXdyaXRlW2RlcHRoXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHVybCA9IGFjdGl2ZV9yZXdyaXRlO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vdGhlbiBtYXAgZnJvbSB0aGUgcGFyZW50cyB0byB0aGUgZGVwdGhcclxuICAgICAgICAgICAgICAgICAgICAgICAgJCh2YWx1ZXMpLmVhY2goZnVuY3Rpb24gKGluZGV4LCB2YWx1ZSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybCA9IHVybC5yZXBsYWNlKFwiW1wiICsgaW5kZXggKyBcIl1cIiwgdmFsdWUpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSB1cmw7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2Uge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pZiB0aGVyZSBhcmUgbXVsdGlwbGUgdmFsdWVzLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3RoZW4gd2UgbmVlZCB0byBjaGVjayBmb3IgMyB0aGluZ3M6XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2lmIHRoZSB2YWx1ZXMgc2VsZWN0ZWQgYXJlIGFsbCBpbiB0aGUgc2FtZSB0cmVlIHRoZW4gd2UgY2FuIGRvIHNvbWUgY2xldmVyIHJld3JpdGUgc3R1ZmZcclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9tZXJnZSBhbGwgdmFsdWVzIGluIHNhbWUgbGV2ZWwsIHRoZW4gY29tYmluZSB0aGUgbGV2ZWxzXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2lmIHRoZXkgYXJlIGZyb20gZGlmZmVyZW50IHRyZWVzIHRoZW4ganVzdCBjb21iaW5lIHRoZW0gb3IganVzdCB1c2UgYGZpZWxkX3ZhbHVlYFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvKlxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aHMgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICQoZmllbGRfdmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRpbnB1dCA9ICRmaWVsZC5maW5kKFwiaW5wdXRbdmFsdWU9J1wiICsgZmllbGRfdmFsdWUgKyBcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkaW5wdXQucGFyZW50KCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRlcHRoID0gJGFjdGl2ZS5hdHRyKFwiZGF0YS1zZi1kZXB0aFwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgIC8vZGVwdGhzLnB1c2goZGVwdGgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgIH0pOyovXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYgKChpbnB1dF90eXBlID09IFwic2VsZWN0XCIpIHx8IChpbnB1dF90eXBlID09IFwibXVsdGlzZWxlY3RcIikpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGlzX3NpbmdsZV92YWx1ZSA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX3ZhbHVlcyA9IGZpZWxkX3ZhbHVlLnNwbGl0KFwiLFwiKS5qb2luKFwiK1wiKS5zcGxpdChcIitcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGZpZWxkX3ZhbHVlcy5sZW5ndGggPiAxKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlzX3NpbmdsZV92YWx1ZSA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKGlzX3NpbmdsZV92YWx1ZSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRhY3RpdmUgPSAkZmllbGQuZmluZChcIm9wdGlvblt2YWx1ZT0nXCIgKyBmaWVsZF92YWx1ZSArIFwiJ11cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aCA9ICRhY3RpdmUuYXR0cihcImRhdGEtc2YtZGVwdGhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWVzID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKGZpZWxkX3ZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZvciAodmFyIGkgPSBkZXB0aDsgaSA+IDA7IGktLSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGFjdGl2ZSA9ICRhY3RpdmUucHJldkFsbChcIm9wdGlvbltkYXRhLXNmLWRlcHRoPSdcIiArIChpIC0gMSkgKyBcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWVzLnB1c2goJGFjdGl2ZS52YWwoKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5yZXZlcnNlKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBhY3RpdmVfcmV3cml0ZSA9IHJld3JpdGVbZGVwdGhdO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdXJsID0gYWN0aXZlX3Jld3JpdGU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQodmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB1cmwgPSB1cmwucmVwbGFjZShcIltcIiArIGluZGV4ICsgXCJdXCIsIHZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gdXJsO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgfVxyXG4gICAgICAgIC8vdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IGN1cnJlbnRfcmVzdWx0c191cmw7XHJcbiAgICB9LFxyXG4gICAgZ2V0UmVzdWx0c1VybDogZnVuY3Rpb24oJGZvcm0sIGN1cnJlbnRfcmVzdWx0c191cmwpIHtcclxuXHJcbiAgICAgICAgLy90aGlzLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKCRmb3JtLCBjdXJyZW50X3Jlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgaWYodGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybD09XCJcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHJldHVybiBjdXJyZW50X3Jlc3VsdHNfdXJsO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgcmV0dXJuIHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmw7XHJcbiAgICB9LFxyXG5cdGdldFVybFBhcmFtczogZnVuY3Rpb24oJGZvcm0pe1xyXG5cclxuXHRcdHRoaXMuYnVpbGRVcmxDb21wb25lbnRzKCRmb3JtLCB0cnVlKTtcclxuXHJcbiAgICAgICAgaWYodGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCE9XCJcIilcclxuICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICBpZih0aGlzLmFjdGl2ZV90YXghPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBmaWVsZF9uYW1lID0gdGhpcy5hY3RpdmVfdGF4O1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLnVybF9wYXJhbXNbZmllbGRfbmFtZV0pIT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGRlbGV0ZSB0aGlzLnVybF9wYXJhbXNbZmllbGRfbmFtZV07XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG5cdFx0cmV0dXJuIHRoaXMudXJsX3BhcmFtcztcclxuXHR9LFxyXG5cdGNsZWFyVXJsQ29tcG9uZW50czogZnVuY3Rpb24oKXtcclxuXHRcdC8vdGhpcy51cmxfY29tcG9uZW50cyA9IFwiXCI7XHJcblx0XHR0aGlzLnVybF9wYXJhbXMgPSB7fTtcclxuXHR9LFxyXG5cdGRpc2FibGVJbnB1dHM6IGZ1bmN0aW9uKCRmb3JtKXtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFxyXG5cdFx0XHR2YXIgJGlucHV0cyA9ICQodGhpcykuZmluZChcImlucHV0LCBzZWxlY3QsIC5tZXRhLXNsaWRlclwiKTtcclxuXHRcdFx0JGlucHV0cy5hdHRyKFwiZGlzYWJsZWRcIiwgXCJkaXNhYmxlZFwiKTtcclxuXHRcdFx0JGlucHV0cy5hdHRyKFwiZGlzYWJsZWRcIiwgdHJ1ZSk7XHJcblx0XHRcdCRpbnB1dHMucHJvcChcImRpc2FibGVkXCIsIHRydWUpO1xyXG5cdFx0XHQkaW5wdXRzLnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTtcclxuXHRcdFx0XHJcblx0XHR9KTtcclxuXHRcdFxyXG5cdFx0XHJcblx0fSxcclxuXHRlbmFibGVJbnB1dHM6IGZ1bmN0aW9uKCRmb3JtKXtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFxyXG5cdFx0XHR2YXIgJGlucHV0cyA9ICQodGhpcykuZmluZChcImlucHV0LCBzZWxlY3QsIC5tZXRhLXNsaWRlclwiKTtcclxuXHRcdFx0JGlucHV0cy5wcm9wKFwiZGlzYWJsZWRcIiwgdHJ1ZSk7XHJcblx0XHRcdCRpbnB1dHMucmVtb3ZlQXR0cihcImRpc2FibGVkXCIpO1xyXG5cdFx0XHQkaW5wdXRzLnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTtcdFx0XHRcclxuXHRcdH0pO1xyXG5cdFx0XHJcblx0XHRcclxuXHR9LFxyXG5cdGJ1aWxkVXJsQ29tcG9uZW50czogZnVuY3Rpb24oJGZvcm0sIGNsZWFyX2NvbXBvbmVudHMpe1xyXG5cdFx0XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihjbGVhcl9jb21wb25lbnRzKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoY2xlYXJfY29tcG9uZW50cz09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHRoaXMuY2xlYXJVcmxDb21wb25lbnRzKCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0JGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFxyXG5cdFx0XHR2YXIgZmllbGROYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0XHR2YXIgZmllbGRUeXBlID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0XHRcclxuXHRcdFx0aWYoZmllbGRUeXBlPT1cInNlYXJjaFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzU2VhcmNoRmllbGQoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZigoZmllbGRUeXBlPT1cInRhZ1wiKXx8KGZpZWxkVHlwZT09XCJjYXRlZ29yeVwiKXx8KGZpZWxkVHlwZT09XCJ0YXhvbm9teVwiKSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1RheG9ub215KCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInNvcnRfb3JkZXJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1NvcnRPcmRlckZpZWxkKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInBvc3RzX3Blcl9wYWdlXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NSZXN1bHRzUGVyUGFnZUZpZWxkKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cImF1dGhvclwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzQXV0aG9yKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInBvc3RfdHlwZVwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzUG9zdFR5cGUoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdF9kYXRlXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NQb3N0RGF0ZSgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0X21ldGFcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Bvc3RNZXRhKCQodGhpcykpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2VcclxuXHRcdFx0e1xyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fSk7XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NTZWFyY2hGaWVsZDogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdHZhciAkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJpbnB1dFtuYW1lXj0nX3NmX3NlYXJjaCddXCIpO1xyXG5cdFx0XHJcblx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHR7XHJcblx0XHRcdHZhciBmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC52YWwoKTtcclxuXHRcdFx0XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJl9zZl9zPVwiK2VuY29kZVVSSUNvbXBvbmVudChmaWVsZFZhbCk7XHJcblx0XHRcdFx0c2VsZi51cmxfcGFyYW1zWydfc2ZfcyddID0gZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkVmFsKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdH0sXHJcblx0cHJvY2Vzc1NvcnRPcmRlckZpZWxkOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHRoaXMucHJvY2Vzc0F1dGhvcigkY29udGFpbmVyKTtcclxuXHRcdFxyXG5cdH0sXHJcblx0cHJvY2Vzc1Jlc3VsdHNQZXJQYWdlRmllbGQ6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dGhpcy5wcm9jZXNzQXV0aG9yKCRjb250YWluZXIpO1xyXG5cdFx0XHJcblx0fSxcclxuXHRnZXRBY3RpdmVUYXg6IGZ1bmN0aW9uKCRmaWVsZCkge1xyXG5cdFx0cmV0dXJuIHRoaXMuYWN0aXZlX3RheDtcclxuXHR9LFxyXG5cdGdldFNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkKXtcclxuXHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHRpZigkZmllbGQudmFsKCkhPTApXHJcblx0XHR7XHJcblx0XHRcdGZpZWxkVmFsID0gJGZpZWxkLnZhbCgpO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZihmaWVsZFZhbD09bnVsbClcclxuXHRcdHtcclxuXHRcdFx0ZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWw7XHJcblx0fSxcclxuXHRnZXRNZXRhU2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQpe1xyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHRmaWVsZFZhbCA9ICRmaWVsZC52YWwoKTtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRpZihmaWVsZFZhbD09bnVsbClcclxuXHRcdHtcclxuXHRcdFx0ZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWw7XHJcblx0fSxcclxuXHRnZXRNdWx0aVNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XHJcblx0XHRcclxuXHRcdHZhciBkZWxpbSA9IFwiK1wiO1xyXG5cdFx0aWYob3BlcmF0b3I9PVwib3JcIilcclxuXHRcdHtcclxuXHRcdFx0ZGVsaW0gPSBcIixcIjtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKCRmaWVsZC52YWwoKSk9PVwib2JqZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKCRmaWVsZC52YWwoKSE9bnVsbClcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAkZmllbGQudmFsKCkuam9pbihkZWxpbSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdH0sXHJcblx0Z2V0TWV0YU11bHRpU2VsZWN0VmFsOiBmdW5jdGlvbigkZmllbGQsIG9wZXJhdG9yKXtcclxuXHRcdFxyXG5cdFx0dmFyIGRlbGltID0gXCItKy1cIjtcclxuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXHJcblx0XHR7XHJcblx0XHRcdGRlbGltID0gXCItLC1cIjtcclxuXHRcdH1cclxuXHRcdFx0XHRcclxuXHRcdGlmKHR5cGVvZigkZmllbGQudmFsKCkpPT1cIm9iamVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZigkZmllbGQudmFsKCkhPW51bGwpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgZmllbGR2YWwgPSBbXTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQkKCRmaWVsZC52YWwoKSkuZWFjaChmdW5jdGlvbihpbmRleCx2YWx1ZSl7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdGZpZWxkdmFsLnB1c2goKHZhbHVlKSk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0cmV0dXJuIGZpZWxkdmFsLmpvaW4oZGVsaW0pO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdHJldHVybiBcIlwiO1xyXG5cdFx0XHJcblx0fSxcclxuXHRnZXRDaGVja2JveFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XHJcblx0XHRcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpe1xyXG5cdFx0XHRpZigkKHRoaXMpLnByb3AoXCJjaGVja2VkXCIpPT10cnVlKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0cmV0dXJuICQodGhpcykudmFsKCk7XHJcblx0XHRcdH1cclxuXHRcdH0pLmdldCgpO1xyXG5cdFx0XHJcblx0XHR2YXIgZGVsaW0gPSBcIitcIjtcclxuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXHJcblx0XHR7XHJcblx0XHRcdGRlbGltID0gXCIsXCI7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdHJldHVybiBmaWVsZFZhbC5qb2luKGRlbGltKTtcclxuXHR9LFxyXG5cdGdldE1ldGFDaGVja2JveFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XHJcblx0XHRcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpe1xyXG5cdFx0XHRpZigkKHRoaXMpLnByb3AoXCJjaGVja2VkXCIpPT10cnVlKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0cmV0dXJuICgkKHRoaXMpLnZhbCgpKTtcclxuXHRcdFx0fVxyXG5cdFx0fSkuZ2V0KCk7XHJcblx0XHRcclxuXHRcdHZhciBkZWxpbSA9IFwiLSstXCI7XHJcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRkZWxpbSA9IFwiLSwtXCI7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdHJldHVybiBmaWVsZFZhbC5qb2luKGRlbGltKTtcclxuXHR9LFxyXG5cdGdldFJhZGlvVmFsOiBmdW5jdGlvbigkZmllbGQpe1xyXG5cdFx0XHRcdFx0XHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpXHJcblx0XHR7XHJcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRyZXR1cm4gJCh0aGlzKS52YWwoKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH0pLmdldCgpO1xyXG5cdFx0XHJcblx0XHRcclxuXHRcdGlmKGZpZWxkVmFsWzBdIT0wKVxyXG5cdFx0e1xyXG5cdFx0XHRyZXR1cm4gZmllbGRWYWxbMF07XHJcblx0XHR9XHJcblx0fSxcclxuXHRnZXRNZXRhUmFkaW9WYWw6IGZ1bmN0aW9uKCRmaWVsZCl7XHJcblx0XHRcdFx0XHRcdFx0XHJcblx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQubWFwKGZ1bmN0aW9uKClcclxuXHRcdHtcclxuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAkKHRoaXMpLnZhbCgpO1xyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fSkuZ2V0KCk7XHJcblx0XHRcclxuXHRcdHJldHVybiBmaWVsZFZhbFswXTtcclxuXHR9LFxyXG5cdHByb2Nlc3NBdXRob3I6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xyXG5cdFx0XHJcblx0XHR2YXIgJGZpZWxkO1xyXG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XHJcblx0XHR2YXIgZmllbGRWYWwgPSBcIlwiO1xyXG5cdFx0XHJcblx0XHRpZihpbnB1dFR5cGU9PVwic2VsZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFNlbGVjdFZhbCgkZmllbGQpOyBcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cIm11bHRpc2VsZWN0XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHR2YXIgb3BlcmF0b3IgPSAkZmllbGQuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFxyXG5cdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TXVsdGlTZWxlY3RWYWwoJGZpZWxkLCBcIm9yXCIpO1xyXG5cdFx0XHRcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cImNoZWNrYm94XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XHJcblx0XHRcdFxyXG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKS5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0Q2hlY2tib3hWYWwoJGZpZWxkLCBcIm9yXCIpO1xyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFkaW9cIilcclxuXHRcdHtcclxuXHRcdFx0XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6cmFkaW9cIik7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFJhZGlvVmFsKCRmaWVsZCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHR2YXIgZmllbGRTbHVnID0gXCJcIjtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZihmaWVsZE5hbWU9PVwiX3NmX2F1dGhvclwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwiYXV0aG9yc1wiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlIGlmKGZpZWxkTmFtZT09XCJfc2Zfc29ydF9vcmRlclwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwic29ydF9vcmRlclwiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlIGlmKGZpZWxkTmFtZT09XCJfc2ZfcHBwXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJfc2ZfcHBwXCI7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2UgaWYoZmllbGROYW1lPT1cIl9zZl9wb3N0X3R5cGVcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcInBvc3RfdHlwZXNcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoZmllbGRTbHVnIT1cIlwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZFNsdWcrXCI9XCIrZmllbGRWYWw7XHJcblx0XHRcdFx0XHRzZWxmLnVybF9wYXJhbXNbZmllbGRTbHVnXSA9IGZpZWxkVmFsO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzUG9zdFR5cGUgOiBmdW5jdGlvbigkdGhpcyl7XHJcblx0XHRcclxuXHRcdHRoaXMucHJvY2Vzc0F1dGhvcigkdGhpcyk7XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NQb3N0TWV0YTogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLXR5cGVcIik7XHJcblx0XHR2YXIgaW5wdXRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlXCIpO1xyXG5cdFx0dmFyIG1ldGFUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1tZXRhLXR5cGVcIik7XHJcblxyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdHZhciAkZmllbGQ7XHJcblx0XHR2YXIgZmllbGROYW1lID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0aWYobWV0YVR5cGU9PVwibnVtYmVyXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGlucHV0VHlwZT09XCJyYW5nZS1udW1iZXJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlLW51bWJlciBpbnB1dFwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgdmFsdWVzID0gW107XHJcblx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0dmFsdWVzLnB1c2goJCh0aGlzKS52YWwoKSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSB2YWx1ZXMuam9pbihcIitcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFuZ2Utc2xpZGVyXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXIgaW5wdXRcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0Ly9nZXQgYW55IG51bWJlciBmb3JtYXR0aW5nIHN0dWZmXHJcblx0XHRcdFx0dmFyICRtZXRhX3JhbmdlID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdHZhciBkZWNpbWFsX3BsYWNlcyA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLWRlY2ltYWwtcGxhY2VzXCIpO1xyXG5cdFx0XHRcdHZhciB0aG91c2FuZF9zZXBlcmF0b3IgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS10aG91c2FuZC1zZXBlcmF0b3JcIik7XHJcblx0XHRcdFx0dmFyIGRlY2ltYWxfc2VwZXJhdG9yID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtZGVjaW1hbC1zZXBlcmF0b3JcIik7XHJcblxyXG5cdFx0XHRcdHZhciBmaWVsZF9mb3JtYXQgPSB3TnVtYih7XHJcblx0XHRcdFx0XHRtYXJrOiBkZWNpbWFsX3NlcGVyYXRvcixcclxuXHRcdFx0XHRcdGRlY2ltYWxzOiBwYXJzZUZsb2F0KGRlY2ltYWxfcGxhY2VzKSxcclxuXHRcdFx0XHRcdHRob3VzYW5kOiB0aG91c2FuZF9zZXBlcmF0b3JcclxuXHRcdFx0XHR9KTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgdmFsdWVzID0gW107XHJcblxyXG5cclxuXHRcdFx0XHR2YXIgc2xpZGVyX29iamVjdCA9ICRjb250YWluZXIuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcclxuXHRcdFx0XHQvL3ZhbCBmcm9tIHNsaWRlciBvYmplY3RcclxuXHRcdFx0XHR2YXIgc2xpZGVyX3ZhbCA9IHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5nZXQoKTtcclxuXHJcblx0XHRcdFx0dmFsdWVzLnB1c2goZmllbGRfZm9ybWF0LmZyb20oc2xpZGVyX3ZhbFswXSkpO1xyXG5cdFx0XHRcdHZhbHVlcy5wdXNoKGZpZWxkX2Zvcm1hdC5mcm9tKHNsaWRlcl92YWxbMV0pKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHZhbHVlcy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLXJhZGlvXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtaW5wdXQtcmFuZ2UtcmFkaW9cIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD09MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHQvL3RoZW4gdHJ5IGFnYWluLCB3ZSBtdXN0IGJlIHVzaW5nIGEgc2luZ2xlIGZpZWxkXHJcblx0XHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0dmFyICRtZXRhX3JhbmdlID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2VcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0Ly90aGVyZSBpcyBhbiBlbGVtZW50IHdpdGggYSBmcm9tL3RvIGNsYXNzIC0gc28gd2UgbmVlZCB0byBnZXQgdGhlIHZhbHVlcyBvZiB0aGUgZnJvbSAmIHRvIGlucHV0IGZpZWxkcyBzZXBlcmF0ZWx5XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcdFxyXG5cdFx0XHRcdFx0dmFyIGZpZWxkX3ZhbHMgPSBbXTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRcdHZhciAkcmFkaW9zID0gJCh0aGlzKS5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpO1xyXG5cdFx0XHRcdFx0XHRmaWVsZF92YWxzLnB1c2goc2VsZi5nZXRNZXRhUmFkaW9WYWwoJHJhZGlvcykpO1xyXG5cdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdH0pO1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHQvL3ByZXZlbnQgc2Vjb25kIG51bWJlciBmcm9tIGJlaW5nIGxvd2VyIHRoYW4gdGhlIGZpcnN0XHJcblx0XHRcdFx0XHRpZihmaWVsZF92YWxzLmxlbmd0aD09MilcclxuXHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0aWYoTnVtYmVyKGZpZWxkX3ZhbHNbMV0pPE51bWJlcihmaWVsZF92YWxzWzBdKSlcclxuXHRcdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRcdGZpZWxkX3ZhbHNbMV0gPSBmaWVsZF92YWxzWzBdO1xyXG5cdFx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdGZpZWxkVmFsID0gZmllbGRfdmFscy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPT0xKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLXNlbGVjdFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLWlucHV0LXNlbGVjdFwiKTtcclxuXHRcdFx0XHR2YXIgJG1ldGFfcmFuZ2UgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZVwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQvL3RoZXJlIGlzIGFuIGVsZW1lbnQgd2l0aCBhIGZyb20vdG8gY2xhc3MgLSBzbyB3ZSBuZWVkIHRvIGdldCB0aGUgdmFsdWVzIG9mIHRoZSBmcm9tICYgdG8gaW5wdXQgZmllbGRzIHNlcGVyYXRlbHlcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0dmFyIGZpZWxkX3ZhbHMgPSBbXTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0JGZpZWxkLmVhY2goZnVuY3Rpb24oKXtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRcdHZhciAkdGhpcyA9ICQodGhpcyk7XHJcblx0XHRcdFx0XHRcdGZpZWxkX3ZhbHMucHVzaChzZWxmLmdldE1ldGFTZWxlY3RWYWwoJHRoaXMpKTtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0XHR9KTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0Ly9wcmV2ZW50IHNlY29uZCBudW1iZXIgZnJvbSBiZWluZyBsb3dlciB0aGFuIHRoZSBmaXJzdFxyXG5cdFx0XHRcdFx0aWYoZmllbGRfdmFscy5sZW5ndGg9PTIpXHJcblx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdGlmKE51bWJlcihmaWVsZF92YWxzWzFdKTxOdW1iZXIoZmllbGRfdmFsc1swXSkpXHJcblx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRmaWVsZF92YWxzWzFdID0gZmllbGRfdmFsc1swXTtcclxuXHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdGZpZWxkVmFsID0gZmllbGRfdmFscy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPT0xKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLWNoZWNrYm94XCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0Q2hlY2tib3hWYWwoJGZpZWxkLCBcImFuZFwiKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHRcdGlmKGZpZWxkTmFtZT09XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihtZXRhVHlwZT09XCJjaG9pY2VcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhU2VsZWN0VmFsKCRmaWVsZCk7IFxyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cIm11bHRpc2VsZWN0XCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdFx0dmFyIG9wZXJhdG9yID0gJGZpZWxkLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhTXVsdGlTZWxlY3RWYWwoJGZpZWxkLCBvcGVyYXRvcik7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwiY2hlY2tib3hcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdHZhciBvcGVyYXRvciA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIikuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YUNoZWNrYm94VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYWRpb1wiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpyYWRpb1wiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE1ldGFSYWRpb1ZhbCgkZmllbGQpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBlbmNvZGVVUklDb21wb25lbnQoZmllbGRWYWwpO1xyXG5cdFx0XHRpZih0eXBlb2YoJGZpZWxkKSE9PVwidW5kZWZpbmVkXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHQvL2ZvciB0aG9zZSB3aG8gaW5zaXN0IG9uIHVzaW5nICYgYW1wZXJzYW5kcyBpbiB0aGUgbmFtZSBvZiB0aGUgY3VzdG9tIGZpZWxkICghKVxyXG5cdFx0XHRcdFx0ZmllbGROYW1lID0gKGZpZWxkTmFtZSk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihtZXRhVHlwZT09XCJkYXRlXCIpXHJcblx0XHR7XHJcblx0XHRcdHNlbGYucHJvY2Vzc1Bvc3REYXRlKCRjb250YWluZXIpO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoZmllbGRWYWwpIT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitlbmNvZGVVUklDb21wb25lbnQoZmllbGROYW1lKStcIj1cIisoZmllbGRWYWwpO1xyXG5cdFx0XHRcdHNlbGYudXJsX3BhcmFtc1tlbmNvZGVVUklDb21wb25lbnQoZmllbGROYW1lKV0gPSAoZmllbGRWYWwpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0fSxcclxuXHRwcm9jZXNzUG9zdERhdGU6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuXHRcdFxyXG5cdFx0dmFyICRmaWVsZDtcclxuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDp0ZXh0XCIpO1xyXG5cdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHJcblx0XHR2YXIgZGF0ZXMgPSBbXTtcclxuXHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFxyXG5cdFx0XHRkYXRlcy5wdXNoKCQodGhpcykudmFsKCkpO1xyXG5cdFx0XHJcblx0XHR9KTtcclxuXHRcdFxyXG5cdFx0aWYoJGZpZWxkLmxlbmd0aD09MilcclxuXHRcdHtcclxuXHRcdFx0aWYoKGRhdGVzWzBdIT1cIlwiKXx8KGRhdGVzWzFdIT1cIlwiKSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gZGF0ZXMuam9pbihcIitcIik7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBmaWVsZFZhbC5yZXBsYWNlKC9cXC8vZywnJyk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoJGZpZWxkLmxlbmd0aD09MSlcclxuXHRcdHtcclxuXHRcdFx0aWYoZGF0ZXNbMF0hPVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IGRhdGVzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gZmllbGRWYWwucmVwbGFjZSgvXFwvL2csJycpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0dmFyIGZpZWxkU2x1ZyA9IFwiXCI7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoZmllbGROYW1lPT1cIl9zZl9wb3N0X2RhdGVcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcInBvc3RfZGF0ZVwiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gZmllbGROYW1lO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZihmaWVsZFNsdWchPVwiXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0Ly9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJlwiK2ZpZWxkU2x1ZytcIj1cIitmaWVsZFZhbDtcclxuXHRcdFx0XHRcdHNlbGYudXJsX3BhcmFtc1tmaWVsZFNsdWddID0gZmllbGRWYWw7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NUYXhvbm9teTogZnVuY3Rpb24oJGNvbnRhaW5lciwgcmV0dXJuX29iamVjdClcclxuXHR7XHJcbiAgICAgICAgaWYodHlwZW9mKHJldHVybl9vYmplY3QpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgcmV0dXJuX29iamVjdCA9IGZhbHNlO1xyXG4gICAgICAgIH1cclxuXHJcblx0XHQvL2lmKClcdFx0XHRcdFx0XHJcblx0XHQvL3ZhciBmaWVsZE5hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHJcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuXHRcdFxyXG5cdFx0dmFyICRmaWVsZDtcclxuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRTZWxlY3RWYWwoJGZpZWxkKTsgXHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0dmFyIG9wZXJhdG9yID0gJGZpZWxkLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE11bHRpU2VsZWN0VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwiY2hlY2tib3hcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpjaGVja2JveFwiKTtcclxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIikuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldENoZWNrYm94VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYWRpb1wiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnJhZGlvXCIpO1xyXG5cdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldFJhZGlvVmFsKCRmaWVsZCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXHJcblx0XHRcdHtcclxuICAgICAgICAgICAgICAgIGlmKHJldHVybl9vYmplY3Q9PXRydWUpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHtuYW1lOiBmaWVsZE5hbWUsIHZhbHVlOiBmaWVsZFZhbH07XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9zZWxmLnVybF9jb21wb25lbnRzICs9IFwiJlwiK2ZpZWxkTmFtZStcIj1cIitmaWVsZFZhbDtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLnVybF9wYXJhbXNbZmllbGROYW1lXSA9IGZpZWxkVmFsO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuICAgICAgICBpZihyZXR1cm5fb2JqZWN0PT10cnVlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH1cclxuXHR9XHJcbn07Il19
},{}],8:[function(require,module,exports){

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
},{}]},{},[1])
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9hcHAuanMiLCJub2RlX21vZHVsZXMvanMtY29va2llL3NyYy9qcy5jb29raWUuanMiLCJub2RlX21vZHVsZXMvbm91aXNsaWRlci9kaXN0cmlidXRlL25vdWlzbGlkZXIuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9maWVsZHMuanMiLCJzcmMvcHVibGljL2Fzc2V0cy9qcy9pbmNsdWRlcy9wYWdpbmF0aW9uLmpzIiwic3JjL3B1YmxpYy9hc3NldHMvanMvaW5jbHVkZXMvcGx1Z2luLmpzIiwic3JjL3B1YmxpYy9hc3NldHMvanMvaW5jbHVkZXMvcHJvY2Vzc19mb3JtLmpzIiwic3JjL3B1YmxpYy9hc3NldHMvanMvaW5jbHVkZXMvc3RhdGUuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDbEdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQ3JLQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUMxeUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDUEE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDakNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDaHhFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDMzhCQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uIGUodCxuLHIpe2Z1bmN0aW9uIHMobyx1KXtpZighbltvXSl7aWYoIXRbb10pe3ZhciBhPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7aWYoIXUmJmEpcmV0dXJuIGEobywhMCk7aWYoaSlyZXR1cm4gaShvLCEwKTt2YXIgZj1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK28rXCInXCIpO3Rocm93IGYuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixmfXZhciBsPW5bb109e2V4cG9ydHM6e319O3Rbb11bMF0uY2FsbChsLmV4cG9ydHMsZnVuY3Rpb24oZSl7dmFyIG49dFtvXVsxXVtlXTtyZXR1cm4gcyhuP246ZSl9LGwsbC5leHBvcnRzLGUsdCxuLHIpfXJldHVybiBuW29dLmV4cG9ydHN9dmFyIGk9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtmb3IodmFyIG89MDtvPHIubGVuZ3RoO28rKylzKHJbb10pO3JldHVybiBzfSkiLCJcclxudmFyIGZpZWxkcyA9IHJlcXVpcmUoJy4vaW5jbHVkZXMvZmllbGRzJyk7XHJcbnZhciBwYWdpbmF0aW9uID0gcmVxdWlyZSgnLi9pbmNsdWRlcy9wYWdpbmF0aW9uJyk7XHJcbnZhciBzdGF0ZSA9IHJlcXVpcmUoJy4vaW5jbHVkZXMvc3RhdGUnKTtcclxudmFyIHBsdWdpbiA9IHJlcXVpcmUoJy4vaW5jbHVkZXMvcGx1Z2luJyk7XHJcblxyXG5cclxuKGZ1bmN0aW9uICggJCApIHtcclxuXHJcblx0XCJ1c2Ugc3RyaWN0XCI7XHJcblxyXG5cdCQoZnVuY3Rpb24gKCkge1xyXG5cclxuXHRcdFN0cmluZy5wcm90b3R5cGUucmVwbGFjZUFsbCA9IGZ1bmN0aW9uKHN0cjEsIHN0cjIsIGlnbm9yZSlcclxuXHRcdHtcclxuXHRcdFx0cmV0dXJuIHRoaXMucmVwbGFjZShuZXcgUmVnRXhwKHN0cjEucmVwbGFjZSgvKFtcXC9cXCxcXCFcXFxcXFxeXFwkXFx7XFx9XFxbXFxdXFwoXFwpXFwuXFwqXFwrXFw/XFx8XFw8XFw+XFwtXFwmXSkvZyxcIlxcXFwkJlwiKSwoaWdub3JlP1wiZ2lcIjpcImdcIikpLCh0eXBlb2Yoc3RyMik9PVwic3RyaW5nXCIpP3N0cjIucmVwbGFjZSgvXFwkL2csXCIkJCQkXCIpOnN0cjIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICghT2JqZWN0LmtleXMpIHtcclxuXHRcdCAgT2JqZWN0LmtleXMgPSAoZnVuY3Rpb24gKCkge1xyXG5cdFx0XHQndXNlIHN0cmljdCc7XHJcblx0XHRcdHZhciBoYXNPd25Qcm9wZXJ0eSA9IE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHksXHJcblx0XHRcdFx0aGFzRG9udEVudW1CdWcgPSAhKHt0b1N0cmluZzogbnVsbH0pLnByb3BlcnR5SXNFbnVtZXJhYmxlKCd0b1N0cmluZycpLFxyXG5cdFx0XHRcdGRvbnRFbnVtcyA9IFtcclxuXHRcdFx0XHQgICd0b1N0cmluZycsXHJcblx0XHRcdFx0ICAndG9Mb2NhbGVTdHJpbmcnLFxyXG5cdFx0XHRcdCAgJ3ZhbHVlT2YnLFxyXG5cdFx0XHRcdCAgJ2hhc093blByb3BlcnR5JyxcclxuXHRcdFx0XHQgICdpc1Byb3RvdHlwZU9mJyxcclxuXHRcdFx0XHQgICdwcm9wZXJ0eUlzRW51bWVyYWJsZScsXHJcblx0XHRcdFx0ICAnY29uc3RydWN0b3InXHJcblx0XHRcdFx0XSxcclxuXHRcdFx0XHRkb250RW51bXNMZW5ndGggPSBkb250RW51bXMubGVuZ3RoO1xyXG5cclxuXHRcdFx0cmV0dXJuIGZ1bmN0aW9uIChvYmopIHtcclxuXHRcdFx0ICBpZiAodHlwZW9mIG9iaiAhPT0gJ29iamVjdCcgJiYgKHR5cGVvZiBvYmogIT09ICdmdW5jdGlvbicgfHwgb2JqID09PSBudWxsKSkge1xyXG5cdFx0XHRcdHRocm93IG5ldyBUeXBlRXJyb3IoJ09iamVjdC5rZXlzIGNhbGxlZCBvbiBub24tb2JqZWN0Jyk7XHJcblx0XHRcdCAgfVxyXG5cclxuXHRcdFx0ICB2YXIgcmVzdWx0ID0gW10sIHByb3AsIGk7XHJcblxyXG5cdFx0XHQgIGZvciAocHJvcCBpbiBvYmopIHtcclxuXHRcdFx0XHRpZiAoaGFzT3duUHJvcGVydHkuY2FsbChvYmosIHByb3ApKSB7XHJcblx0XHRcdFx0ICByZXN1bHQucHVzaChwcm9wKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdCAgfVxyXG5cclxuXHRcdFx0ICBpZiAoaGFzRG9udEVudW1CdWcpIHtcclxuXHRcdFx0XHRmb3IgKGkgPSAwOyBpIDwgZG9udEVudW1zTGVuZ3RoOyBpKyspIHtcclxuXHRcdFx0XHQgIGlmIChoYXNPd25Qcm9wZXJ0eS5jYWxsKG9iaiwgZG9udEVudW1zW2ldKSkge1xyXG5cdFx0XHRcdFx0cmVzdWx0LnB1c2goZG9udEVudW1zW2ldKTtcclxuXHRcdFx0XHQgIH1cclxuXHRcdFx0XHR9XHJcblx0XHRcdCAgfVxyXG5cdFx0XHQgIHJldHVybiByZXN1bHQ7XHJcblx0XHRcdH07XHJcblx0XHQgIH0oKSk7XHJcblx0XHR9XHJcblxyXG5cdFx0LyogU2VhcmNoICYgRmlsdGVyIGpRdWVyeSBQbHVnaW4gKi9cclxuXHRcdCQuZm4uc2VhcmNoQW5kRmlsdGVyID0gcGx1Z2luO1xyXG5cclxuXHRcdC8qIGluaXQgKi9cclxuXHRcdCQoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLnNlYXJjaEFuZEZpbHRlcigpO1xyXG5cclxuXHRcdC8qIGV4dGVybmFsIGNvbnRyb2xzICovXHJcblx0XHQkKGRvY3VtZW50KS5vbihcImNsaWNrXCIsIFwiLnNlYXJjaC1maWx0ZXItcmVzZXRcIiwgZnVuY3Rpb24oZSl7XHJcblxyXG5cdFx0XHRlLnByZXZlbnREZWZhdWx0KCk7XHJcblxyXG5cdFx0XHR2YXIgc2VhcmNoRm9ybUlEID0gdHlwZW9mKCQodGhpcykuYXR0cihcImRhdGEtc2VhcmNoLWZvcm0taWRcIikpIT1cInVuZGVmaW5lZFwiID8gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZWFyY2gtZm9ybS1pZFwiKSA6IFwiXCI7XHJcblx0XHRcdHZhciBzdWJtaXRGb3JtID0gdHlwZW9mKCQodGhpcykuYXR0cihcImRhdGEtc2Ytc3VibWl0LWZvcm1cIikpIT1cInVuZGVmaW5lZFwiID8gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1zdWJtaXQtZm9ybVwiKSA6IFwiXCI7XHJcblxyXG5cdFx0XHRzdGF0ZS5nZXRTZWFyY2hGb3JtKHNlYXJjaEZvcm1JRCkucmVzZXQoc3VibWl0Rm9ybSk7XHJcblxyXG5cdFx0XHQvL3ZhciAkbGlua2VkID0gJChcIiNzZWFyY2gtZmlsdGVyLWZvcm0tXCIrc2VhcmNoRm9ybUlEKS5zZWFyY2hGaWx0ZXJGb3JtKHthY3Rpb246IFwicmVzZXRcIn0pO1xyXG5cclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cclxuXHRcdH0pO1xyXG5cclxuXHR9KTtcclxuXHJcblx0JC5lYXNpbmcuanN3aW5nPSQuZWFzaW5nLnN3aW5nOyQuZXh0ZW5kKCQuZWFzaW5nLHtkZWY6XCJlYXNlT3V0UXVhZFwiLHN3aW5nOmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuICQuZWFzaW5nWyQuZWFzaW5nLmRlZl0oZSx0LG4scixpKX0sZWFzZUluUXVhZDpmdW5jdGlvbihlLHQsbixyLGkpe3JldHVybiByKih0Lz1pKSp0K259LGVhc2VPdXRRdWFkOmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuLXIqKHQvPWkpKih0LTIpK259LGVhc2VJbk91dFF1YWQ6ZnVuY3Rpb24oZSx0LG4scixpKXtpZigodC89aS8yKTwxKXJldHVybiByLzIqdCp0K247cmV0dXJuLXIvMiooLS10Kih0LTIpLTEpK259LGVhc2VJbkN1YmljOmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuIHIqKHQvPWkpKnQqdCtufSxlYXNlT3V0Q3ViaWM6ZnVuY3Rpb24oZSx0LG4scixpKXtyZXR1cm4gciooKHQ9dC9pLTEpKnQqdCsxKStufSxlYXNlSW5PdXRDdWJpYzpmdW5jdGlvbihlLHQsbixyLGkpe2lmKCh0Lz1pLzIpPDEpcmV0dXJuIHIvMip0KnQqdCtuO3JldHVybiByLzIqKCh0LT0yKSp0KnQrMikrbn0sZWFzZUluUXVhcnQ6ZnVuY3Rpb24oZSx0LG4scixpKXtyZXR1cm4gcioodC89aSkqdCp0KnQrbn0sZWFzZU91dFF1YXJ0OmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuLXIqKCh0PXQvaS0xKSp0KnQqdC0xKStufSxlYXNlSW5PdXRRdWFydDpmdW5jdGlvbihlLHQsbixyLGkpe2lmKCh0Lz1pLzIpPDEpcmV0dXJuIHIvMip0KnQqdCp0K247cmV0dXJuLXIvMiooKHQtPTIpKnQqdCp0LTIpK259LGVhc2VJblF1aW50OmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuIHIqKHQvPWkpKnQqdCp0KnQrbn0sZWFzZU91dFF1aW50OmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuIHIqKCh0PXQvaS0xKSp0KnQqdCp0KzEpK259LGVhc2VJbk91dFF1aW50OmZ1bmN0aW9uKGUsdCxuLHIsaSl7aWYoKHQvPWkvMik8MSlyZXR1cm4gci8yKnQqdCp0KnQqdCtuO3JldHVybiByLzIqKCh0LT0yKSp0KnQqdCp0KzIpK259LGVhc2VJblNpbmU6ZnVuY3Rpb24oZSx0LG4scixpKXtyZXR1cm4tcipNYXRoLmNvcyh0L2kqKE1hdGguUEkvMikpK3Irbn0sZWFzZU91dFNpbmU6ZnVuY3Rpb24oZSx0LG4scixpKXtyZXR1cm4gcipNYXRoLnNpbih0L2kqKE1hdGguUEkvMikpK259LGVhc2VJbk91dFNpbmU6ZnVuY3Rpb24oZSx0LG4scixpKXtyZXR1cm4tci8yKihNYXRoLmNvcyhNYXRoLlBJKnQvaSktMSkrbn0sZWFzZUluRXhwbzpmdW5jdGlvbihlLHQsbixyLGkpe3JldHVybiB0PT0wP246cipNYXRoLnBvdygyLDEwKih0L2ktMSkpK259LGVhc2VPdXRFeHBvOmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuIHQ9PWk/bityOnIqKC1NYXRoLnBvdygyLC0xMCp0L2kpKzEpK259LGVhc2VJbk91dEV4cG86ZnVuY3Rpb24oZSx0LG4scixpKXtpZih0PT0wKXJldHVybiBuO2lmKHQ9PWkpcmV0dXJuIG4rcjtpZigodC89aS8yKTwxKXJldHVybiByLzIqTWF0aC5wb3coMiwxMCoodC0xKSkrbjtyZXR1cm4gci8yKigtTWF0aC5wb3coMiwtMTAqLS10KSsyKStufSxlYXNlSW5DaXJjOmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuLXIqKE1hdGguc3FydCgxLSh0Lz1pKSp0KS0xKStufSxlYXNlT3V0Q2lyYzpmdW5jdGlvbihlLHQsbixyLGkpe3JldHVybiByKk1hdGguc3FydCgxLSh0PXQvaS0xKSp0KStufSxlYXNlSW5PdXRDaXJjOmZ1bmN0aW9uKGUsdCxuLHIsaSl7aWYoKHQvPWkvMik8MSlyZXR1cm4tci8yKihNYXRoLnNxcnQoMS10KnQpLTEpK247cmV0dXJuIHIvMiooTWF0aC5zcXJ0KDEtKHQtPTIpKnQpKzEpK259LGVhc2VJbkVsYXN0aWM6ZnVuY3Rpb24oZSx0LG4scixpKXt2YXIgcz0xLjcwMTU4O3ZhciBvPTA7dmFyIHU9cjtpZih0PT0wKXJldHVybiBuO2lmKCh0Lz1pKT09MSlyZXR1cm4gbityO2lmKCFvKW89aSouMztpZih1PE1hdGguYWJzKHIpKXt1PXI7dmFyIHM9by80fWVsc2UgdmFyIHM9by8oMipNYXRoLlBJKSpNYXRoLmFzaW4oci91KTtyZXR1cm4tKHUqTWF0aC5wb3coMiwxMCoodC09MSkpKk1hdGguc2luKCh0KmktcykqMipNYXRoLlBJL28pKStufSxlYXNlT3V0RWxhc3RpYzpmdW5jdGlvbihlLHQsbixyLGkpe3ZhciBzPTEuNzAxNTg7dmFyIG89MDt2YXIgdT1yO2lmKHQ9PTApcmV0dXJuIG47aWYoKHQvPWkpPT0xKXJldHVybiBuK3I7aWYoIW8pbz1pKi4zO2lmKHU8TWF0aC5hYnMocikpe3U9cjt2YXIgcz1vLzR9ZWxzZSB2YXIgcz1vLygyKk1hdGguUEkpKk1hdGguYXNpbihyL3UpO3JldHVybiB1Kk1hdGgucG93KDIsLTEwKnQpKk1hdGguc2luKCh0KmktcykqMipNYXRoLlBJL28pK3Irbn0sZWFzZUluT3V0RWxhc3RpYzpmdW5jdGlvbihlLHQsbixyLGkpe3ZhciBzPTEuNzAxNTg7dmFyIG89MDt2YXIgdT1yO2lmKHQ9PTApcmV0dXJuIG47aWYoKHQvPWkvMik9PTIpcmV0dXJuIG4rcjtpZighbylvPWkqLjMqMS41O2lmKHU8TWF0aC5hYnMocikpe3U9cjt2YXIgcz1vLzR9ZWxzZSB2YXIgcz1vLygyKk1hdGguUEkpKk1hdGguYXNpbihyL3UpO2lmKHQ8MSlyZXR1cm4tLjUqdSpNYXRoLnBvdygyLDEwKih0LT0xKSkqTWF0aC5zaW4oKHQqaS1zKSoyKk1hdGguUEkvbykrbjtyZXR1cm4gdSpNYXRoLnBvdygyLC0xMCoodC09MSkpKk1hdGguc2luKCh0KmktcykqMipNYXRoLlBJL28pKi41K3Irbn0sZWFzZUluQmFjazpmdW5jdGlvbihlLHQsbixyLGkscyl7aWYocz09dW5kZWZpbmVkKXM9MS43MDE1ODtyZXR1cm4gcioodC89aSkqdCooKHMrMSkqdC1zKStufSxlYXNlT3V0QmFjazpmdW5jdGlvbihlLHQsbixyLGkscyl7aWYocz09dW5kZWZpbmVkKXM9MS43MDE1ODtyZXR1cm4gciooKHQ9dC9pLTEpKnQqKChzKzEpKnQrcykrMSkrbn0sZWFzZUluT3V0QmFjazpmdW5jdGlvbihlLHQsbixyLGkscyl7aWYocz09dW5kZWZpbmVkKXM9MS43MDE1ODtpZigodC89aS8yKTwxKXJldHVybiByLzIqdCp0KigoKHMqPTEuNTI1KSsxKSp0LXMpK247cmV0dXJuIHIvMiooKHQtPTIpKnQqKCgocyo9MS41MjUpKzEpKnQrcykrMikrbn0sZWFzZUluQm91bmNlOmZ1bmN0aW9uKGUsdCxuLHIsaSl7cmV0dXJuIHItJC5lYXNpbmcuZWFzZU91dEJvdW5jZShlLGktdCwwLHIsaSkrbn0sZWFzZU91dEJvdW5jZTpmdW5jdGlvbihlLHQsbixyLGkpe2lmKCh0Lz1pKTwxLzIuNzUpe3JldHVybiByKjcuNTYyNSp0KnQrbn1lbHNlIGlmKHQ8Mi8yLjc1KXtyZXR1cm4gciooNy41NjI1Kih0LT0xLjUvMi43NSkqdCsuNzUpK259ZWxzZSBpZih0PDIuNS8yLjc1KXtyZXR1cm4gciooNy41NjI1Kih0LT0yLjI1LzIuNzUpKnQrLjkzNzUpK259ZWxzZXtyZXR1cm4gciooNy41NjI1Kih0LT0yLjYyNS8yLjc1KSp0Ky45ODQzNzUpK259fSxlYXNlSW5PdXRCb3VuY2U6ZnVuY3Rpb24oZSx0LG4scixpKXtpZih0PGkvMilyZXR1cm4gJC5lYXNpbmcuZWFzZUluQm91bmNlKGUsdCoyLDAscixpKSouNStuO3JldHVybiAkLmVhc2luZy5lYXNlT3V0Qm91bmNlKGUsdCoyLWksMCxyLGkpKi41K3IqLjUrbn19KVxyXG5cclxufShqUXVlcnkpKTtcclxuXHJcbi8vc2FmYXJpIGJhY2sgYnV0dG9uIGZpeFxyXG5qUXVlcnkod2luZG93KS5iaW5kKFwicGFnZXNob3dcIiwgZnVuY3Rpb24oZXZlbnQpIHtcclxuICAgIGlmIChldmVudC5vcmlnaW5hbEV2ZW50LnBlcnNpc3RlZCkge1xyXG4gICAgICAgIGpRdWVyeShcIi5zZWFyY2hhbmRmaWx0ZXJcIikub2ZmKCk7XHJcbiAgICAgICAgalF1ZXJ5KFwiLnNlYXJjaGFuZGZpbHRlclwiKS5zZWFyY2hBbmRGaWx0ZXIoKTtcclxuICAgIH1cclxufSk7XHJcblxyXG4vKiB3cG51bWIgLSBub3Vpc2xpZGVyIG51bWJlciBmb3JtYXR0aW5nICovXHJcbiFmdW5jdGlvbigpe1widXNlIHN0cmljdFwiO2Z1bmN0aW9uIGUoZSl7cmV0dXJuIGUuc3BsaXQoXCJcIikucmV2ZXJzZSgpLmpvaW4oXCJcIil9ZnVuY3Rpb24gbihlLG4pe3JldHVybiBlLnN1YnN0cmluZygwLG4ubGVuZ3RoKT09PW59ZnVuY3Rpb24gcihlLG4pe3JldHVybiBlLnNsaWNlKC0xKm4ubGVuZ3RoKT09PW59ZnVuY3Rpb24gdChlLG4scil7aWYoKGVbbl18fGVbcl0pJiZlW25dPT09ZVtyXSl0aHJvdyBuZXcgRXJyb3Iobil9ZnVuY3Rpb24gaShlKXtyZXR1cm5cIm51bWJlclwiPT10eXBlb2YgZSYmaXNGaW5pdGUoZSl9ZnVuY3Rpb24gbyhlLG4pe3ZhciByPU1hdGgucG93KDEwLG4pO3JldHVybihNYXRoLnJvdW5kKGUqcikvcikudG9GaXhlZChuKX1mdW5jdGlvbiB1KG4scix0LHUsZixhLGMscyxwLGQsbCxoKXt2YXIgZyx2LHcsbT1oLHg9XCJcIixiPVwiXCI7cmV0dXJuIGEmJihoPWEoaCkpLGkoaCk/KG4hPT0hMSYmMD09PXBhcnNlRmxvYXQoaC50b0ZpeGVkKG4pKSYmKGg9MCksMD5oJiYoZz0hMCxoPU1hdGguYWJzKGgpKSxuIT09ITEmJihoPW8oaCxuKSksaD1oLnRvU3RyaW5nKCksLTEhPT1oLmluZGV4T2YoXCIuXCIpPyh2PWguc3BsaXQoXCIuXCIpLHc9dlswXSx0JiYoeD10K3ZbMV0pKTp3PWgsciYmKHc9ZSh3KS5tYXRjaCgvLnsxLDN9L2cpLHc9ZSh3LmpvaW4oZShyKSkpKSxnJiZzJiYoYis9cyksdSYmKGIrPXUpLGcmJnAmJihiKz1wKSxiKz13LGIrPXgsZiYmKGIrPWYpLGQmJihiPWQoYixtKSksYik6ITF9ZnVuY3Rpb24gZihlLHQsbyx1LGYsYSxjLHMscCxkLGwsaCl7dmFyIGcsdj1cIlwiO3JldHVybiBsJiYoaD1sKGgpKSxoJiZcInN0cmluZ1wiPT10eXBlb2YgaD8ocyYmbihoLHMpJiYoaD1oLnJlcGxhY2UocyxcIlwiKSxnPSEwKSx1JiZuKGgsdSkmJihoPWgucmVwbGFjZSh1LFwiXCIpKSxwJiZuKGgscCkmJihoPWgucmVwbGFjZShwLFwiXCIpLGc9ITApLGYmJnIoaCxmKSYmKGg9aC5zbGljZSgwLC0xKmYubGVuZ3RoKSksdCYmKGg9aC5zcGxpdCh0KS5qb2luKFwiXCIpKSxvJiYoaD1oLnJlcGxhY2UobyxcIi5cIikpLGcmJih2Kz1cIi1cIiksdis9aCx2PXYucmVwbGFjZSgvW14wLTlcXC5cXC0uXS9nLFwiXCIpLFwiXCI9PT12PyExOih2PU51bWJlcih2KSxjJiYodj1jKHYpKSxpKHYpP3Y6ITEpKTohMX1mdW5jdGlvbiBhKGUpe3ZhciBuLHIsaSxvPXt9O2ZvcihuPTA7bjxwLmxlbmd0aDtuKz0xKWlmKHI9cFtuXSxpPWVbcl0sdm9pZCAwPT09aSlcIm5lZ2F0aXZlXCIhPT1yfHxvLm5lZ2F0aXZlQmVmb3JlP1wibWFya1wiPT09ciYmXCIuXCIhPT1vLnRob3VzYW5kP29bcl09XCIuXCI6b1tyXT0hMTpvW3JdPVwiLVwiO2Vsc2UgaWYoXCJkZWNpbWFsc1wiPT09cil7aWYoIShpPj0wJiY4PmkpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9ZWxzZSBpZihcImVuY29kZXJcIj09PXJ8fFwiZGVjb2RlclwiPT09cnx8XCJlZGl0XCI9PT1yfHxcInVuZG9cIj09PXIpe2lmKFwiZnVuY3Rpb25cIiE9dHlwZW9mIGkpdGhyb3cgbmV3IEVycm9yKHIpO29bcl09aX1lbHNle2lmKFwic3RyaW5nXCIhPXR5cGVvZiBpKXRocm93IG5ldyBFcnJvcihyKTtvW3JdPWl9cmV0dXJuIHQobyxcIm1hcmtcIixcInRob3VzYW5kXCIpLHQobyxcInByZWZpeFwiLFwibmVnYXRpdmVcIiksdChvLFwicHJlZml4XCIsXCJuZWdhdGl2ZUJlZm9yZVwiKSxvfWZ1bmN0aW9uIGMoZSxuLHIpe3ZhciB0LGk9W107Zm9yKHQ9MDt0PHAubGVuZ3RoO3QrPTEpaS5wdXNoKGVbcFt0XV0pO3JldHVybiBpLnB1c2gociksbi5hcHBseShcIlwiLGkpfWZ1bmN0aW9uIHMoZSl7cmV0dXJuIHRoaXMgaW5zdGFuY2VvZiBzP3ZvaWQoXCJvYmplY3RcIj09dHlwZW9mIGUmJihlPWEoZSksdGhpcy50bz1mdW5jdGlvbihuKXtyZXR1cm4gYyhlLHUsbil9LHRoaXMuZnJvbT1mdW5jdGlvbihuKXtyZXR1cm4gYyhlLGYsbil9KSk6bmV3IHMoZSl9dmFyIHA9W1wiZGVjaW1hbHNcIixcInRob3VzYW5kXCIsXCJtYXJrXCIsXCJwcmVmaXhcIixcInBvc3RmaXhcIixcImVuY29kZXJcIixcImRlY29kZXJcIixcIm5lZ2F0aXZlQmVmb3JlXCIsXCJuZWdhdGl2ZVwiLFwiZWRpdFwiLFwidW5kb1wiXTt3aW5kb3cud051bWI9c30oKTtcclxuXHJcbiIsIi8qIVxuICogSmF2YVNjcmlwdCBDb29raWUgdjIuMi4wXG4gKiBodHRwczovL2dpdGh1Yi5jb20vanMtY29va2llL2pzLWNvb2tpZVxuICpcbiAqIENvcHlyaWdodCAyMDA2LCAyMDE1IEtsYXVzIEhhcnRsICYgRmFnbmVyIEJyYWNrXG4gKiBSZWxlYXNlZCB1bmRlciB0aGUgTUlUIGxpY2Vuc2VcbiAqL1xuOyhmdW5jdGlvbiAoZmFjdG9yeSkge1xuXHR2YXIgcmVnaXN0ZXJlZEluTW9kdWxlTG9hZGVyID0gZmFsc2U7XG5cdGlmICh0eXBlb2YgZGVmaW5lID09PSAnZnVuY3Rpb24nICYmIGRlZmluZS5hbWQpIHtcblx0XHRkZWZpbmUoZmFjdG9yeSk7XG5cdFx0cmVnaXN0ZXJlZEluTW9kdWxlTG9hZGVyID0gdHJ1ZTtcblx0fVxuXHRpZiAodHlwZW9mIGV4cG9ydHMgPT09ICdvYmplY3QnKSB7XG5cdFx0bW9kdWxlLmV4cG9ydHMgPSBmYWN0b3J5KCk7XG5cdFx0cmVnaXN0ZXJlZEluTW9kdWxlTG9hZGVyID0gdHJ1ZTtcblx0fVxuXHRpZiAoIXJlZ2lzdGVyZWRJbk1vZHVsZUxvYWRlcikge1xuXHRcdHZhciBPbGRDb29raWVzID0gd2luZG93LkNvb2tpZXM7XG5cdFx0dmFyIGFwaSA9IHdpbmRvdy5Db29raWVzID0gZmFjdG9yeSgpO1xuXHRcdGFwaS5ub0NvbmZsaWN0ID0gZnVuY3Rpb24gKCkge1xuXHRcdFx0d2luZG93LkNvb2tpZXMgPSBPbGRDb29raWVzO1xuXHRcdFx0cmV0dXJuIGFwaTtcblx0XHR9O1xuXHR9XG59KGZ1bmN0aW9uICgpIHtcblx0ZnVuY3Rpb24gZXh0ZW5kICgpIHtcblx0XHR2YXIgaSA9IDA7XG5cdFx0dmFyIHJlc3VsdCA9IHt9O1xuXHRcdGZvciAoOyBpIDwgYXJndW1lbnRzLmxlbmd0aDsgaSsrKSB7XG5cdFx0XHR2YXIgYXR0cmlidXRlcyA9IGFyZ3VtZW50c1sgaSBdO1xuXHRcdFx0Zm9yICh2YXIga2V5IGluIGF0dHJpYnV0ZXMpIHtcblx0XHRcdFx0cmVzdWx0W2tleV0gPSBhdHRyaWJ1dGVzW2tleV07XG5cdFx0XHR9XG5cdFx0fVxuXHRcdHJldHVybiByZXN1bHQ7XG5cdH1cblxuXHRmdW5jdGlvbiBpbml0IChjb252ZXJ0ZXIpIHtcblx0XHRmdW5jdGlvbiBhcGkgKGtleSwgdmFsdWUsIGF0dHJpYnV0ZXMpIHtcblx0XHRcdHZhciByZXN1bHQ7XG5cdFx0XHRpZiAodHlwZW9mIGRvY3VtZW50ID09PSAndW5kZWZpbmVkJykge1xuXHRcdFx0XHRyZXR1cm47XG5cdFx0XHR9XG5cblx0XHRcdC8vIFdyaXRlXG5cblx0XHRcdGlmIChhcmd1bWVudHMubGVuZ3RoID4gMSkge1xuXHRcdFx0XHRhdHRyaWJ1dGVzID0gZXh0ZW5kKHtcblx0XHRcdFx0XHRwYXRoOiAnLydcblx0XHRcdFx0fSwgYXBpLmRlZmF1bHRzLCBhdHRyaWJ1dGVzKTtcblxuXHRcdFx0XHRpZiAodHlwZW9mIGF0dHJpYnV0ZXMuZXhwaXJlcyA9PT0gJ251bWJlcicpIHtcblx0XHRcdFx0XHR2YXIgZXhwaXJlcyA9IG5ldyBEYXRlKCk7XG5cdFx0XHRcdFx0ZXhwaXJlcy5zZXRNaWxsaXNlY29uZHMoZXhwaXJlcy5nZXRNaWxsaXNlY29uZHMoKSArIGF0dHJpYnV0ZXMuZXhwaXJlcyAqIDg2NGUrNSk7XG5cdFx0XHRcdFx0YXR0cmlidXRlcy5leHBpcmVzID0gZXhwaXJlcztcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIFdlJ3JlIHVzaW5nIFwiZXhwaXJlc1wiIGJlY2F1c2UgXCJtYXgtYWdlXCIgaXMgbm90IHN1cHBvcnRlZCBieSBJRVxuXHRcdFx0XHRhdHRyaWJ1dGVzLmV4cGlyZXMgPSBhdHRyaWJ1dGVzLmV4cGlyZXMgPyBhdHRyaWJ1dGVzLmV4cGlyZXMudG9VVENTdHJpbmcoKSA6ICcnO1xuXG5cdFx0XHRcdHRyeSB7XG5cdFx0XHRcdFx0cmVzdWx0ID0gSlNPTi5zdHJpbmdpZnkodmFsdWUpO1xuXHRcdFx0XHRcdGlmICgvXltcXHtcXFtdLy50ZXN0KHJlc3VsdCkpIHtcblx0XHRcdFx0XHRcdHZhbHVlID0gcmVzdWx0O1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSBjYXRjaCAoZSkge31cblxuXHRcdFx0XHRpZiAoIWNvbnZlcnRlci53cml0ZSkge1xuXHRcdFx0XHRcdHZhbHVlID0gZW5jb2RlVVJJQ29tcG9uZW50KFN0cmluZyh2YWx1ZSkpXG5cdFx0XHRcdFx0XHQucmVwbGFjZSgvJSgyM3wyNHwyNnwyQnwzQXwzQ3wzRXwzRHwyRnwzRnw0MHw1Qnw1RHw1RXw2MHw3Qnw3RHw3QykvZywgZGVjb2RlVVJJQ29tcG9uZW50KTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHR2YWx1ZSA9IGNvbnZlcnRlci53cml0ZSh2YWx1ZSwga2V5KTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdGtleSA9IGVuY29kZVVSSUNvbXBvbmVudChTdHJpbmcoa2V5KSk7XG5cdFx0XHRcdGtleSA9IGtleS5yZXBsYWNlKC8lKDIzfDI0fDI2fDJCfDVFfDYwfDdDKS9nLCBkZWNvZGVVUklDb21wb25lbnQpO1xuXHRcdFx0XHRrZXkgPSBrZXkucmVwbGFjZSgvW1xcKFxcKV0vZywgZXNjYXBlKTtcblxuXHRcdFx0XHR2YXIgc3RyaW5naWZpZWRBdHRyaWJ1dGVzID0gJyc7XG5cblx0XHRcdFx0Zm9yICh2YXIgYXR0cmlidXRlTmFtZSBpbiBhdHRyaWJ1dGVzKSB7XG5cdFx0XHRcdFx0aWYgKCFhdHRyaWJ1dGVzW2F0dHJpYnV0ZU5hbWVdKSB7XG5cdFx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0c3RyaW5naWZpZWRBdHRyaWJ1dGVzICs9ICc7ICcgKyBhdHRyaWJ1dGVOYW1lO1xuXHRcdFx0XHRcdGlmIChhdHRyaWJ1dGVzW2F0dHJpYnV0ZU5hbWVdID09PSB0cnVlKSB7XG5cdFx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0c3RyaW5naWZpZWRBdHRyaWJ1dGVzICs9ICc9JyArIGF0dHJpYnV0ZXNbYXR0cmlidXRlTmFtZV07XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuIChkb2N1bWVudC5jb29raWUgPSBrZXkgKyAnPScgKyB2YWx1ZSArIHN0cmluZ2lmaWVkQXR0cmlidXRlcyk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIFJlYWRcblxuXHRcdFx0aWYgKCFrZXkpIHtcblx0XHRcdFx0cmVzdWx0ID0ge307XG5cdFx0XHR9XG5cblx0XHRcdC8vIFRvIHByZXZlbnQgdGhlIGZvciBsb29wIGluIHRoZSBmaXJzdCBwbGFjZSBhc3NpZ24gYW4gZW1wdHkgYXJyYXlcblx0XHRcdC8vIGluIGNhc2UgdGhlcmUgYXJlIG5vIGNvb2tpZXMgYXQgYWxsLiBBbHNvIHByZXZlbnRzIG9kZCByZXN1bHQgd2hlblxuXHRcdFx0Ly8gY2FsbGluZyBcImdldCgpXCJcblx0XHRcdHZhciBjb29raWVzID0gZG9jdW1lbnQuY29va2llID8gZG9jdW1lbnQuY29va2llLnNwbGl0KCc7ICcpIDogW107XG5cdFx0XHR2YXIgcmRlY29kZSA9IC8oJVswLTlBLVpdezJ9KSsvZztcblx0XHRcdHZhciBpID0gMDtcblxuXHRcdFx0Zm9yICg7IGkgPCBjb29raWVzLmxlbmd0aDsgaSsrKSB7XG5cdFx0XHRcdHZhciBwYXJ0cyA9IGNvb2tpZXNbaV0uc3BsaXQoJz0nKTtcblx0XHRcdFx0dmFyIGNvb2tpZSA9IHBhcnRzLnNsaWNlKDEpLmpvaW4oJz0nKTtcblxuXHRcdFx0XHRpZiAoIXRoaXMuanNvbiAmJiBjb29raWUuY2hhckF0KDApID09PSAnXCInKSB7XG5cdFx0XHRcdFx0Y29va2llID0gY29va2llLnNsaWNlKDEsIC0xKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHRyeSB7XG5cdFx0XHRcdFx0dmFyIG5hbWUgPSBwYXJ0c1swXS5yZXBsYWNlKHJkZWNvZGUsIGRlY29kZVVSSUNvbXBvbmVudCk7XG5cdFx0XHRcdFx0Y29va2llID0gY29udmVydGVyLnJlYWQgP1xuXHRcdFx0XHRcdFx0Y29udmVydGVyLnJlYWQoY29va2llLCBuYW1lKSA6IGNvbnZlcnRlcihjb29raWUsIG5hbWUpIHx8XG5cdFx0XHRcdFx0XHRjb29raWUucmVwbGFjZShyZGVjb2RlLCBkZWNvZGVVUklDb21wb25lbnQpO1xuXG5cdFx0XHRcdFx0aWYgKHRoaXMuanNvbikge1xuXHRcdFx0XHRcdFx0dHJ5IHtcblx0XHRcdFx0XHRcdFx0Y29va2llID0gSlNPTi5wYXJzZShjb29raWUpO1xuXHRcdFx0XHRcdFx0fSBjYXRjaCAoZSkge31cblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRpZiAoa2V5ID09PSBuYW1lKSB7XG5cdFx0XHRcdFx0XHRyZXN1bHQgPSBjb29raWU7XG5cdFx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRpZiAoIWtleSkge1xuXHRcdFx0XHRcdFx0cmVzdWx0W25hbWVdID0gY29va2llO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSBjYXRjaCAoZSkge31cblx0XHRcdH1cblxuXHRcdFx0cmV0dXJuIHJlc3VsdDtcblx0XHR9XG5cblx0XHRhcGkuc2V0ID0gYXBpO1xuXHRcdGFwaS5nZXQgPSBmdW5jdGlvbiAoa2V5KSB7XG5cdFx0XHRyZXR1cm4gYXBpLmNhbGwoYXBpLCBrZXkpO1xuXHRcdH07XG5cdFx0YXBpLmdldEpTT04gPSBmdW5jdGlvbiAoKSB7XG5cdFx0XHRyZXR1cm4gYXBpLmFwcGx5KHtcblx0XHRcdFx0anNvbjogdHJ1ZVxuXHRcdFx0fSwgW10uc2xpY2UuY2FsbChhcmd1bWVudHMpKTtcblx0XHR9O1xuXHRcdGFwaS5kZWZhdWx0cyA9IHt9O1xuXG5cdFx0YXBpLnJlbW92ZSA9IGZ1bmN0aW9uIChrZXksIGF0dHJpYnV0ZXMpIHtcblx0XHRcdGFwaShrZXksICcnLCBleHRlbmQoYXR0cmlidXRlcywge1xuXHRcdFx0XHRleHBpcmVzOiAtMVxuXHRcdFx0fSkpO1xuXHRcdH07XG5cblx0XHRhcGkud2l0aENvbnZlcnRlciA9IGluaXQ7XG5cblx0XHRyZXR1cm4gYXBpO1xuXHR9XG5cblx0cmV0dXJuIGluaXQoZnVuY3Rpb24gKCkge30pO1xufSkpO1xuIiwiLyohIG5vdWlzbGlkZXIgLSAxMS4xLjAgLSAyMDE4LTA0LTAyIDExOjE4OjEzICovXHJcblxyXG4oZnVuY3Rpb24gKGZhY3RvcnkpIHtcclxuXHJcbiAgICBpZiAoIHR5cGVvZiBkZWZpbmUgPT09ICdmdW5jdGlvbicgJiYgZGVmaW5lLmFtZCApIHtcclxuXHJcbiAgICAgICAgLy8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxyXG4gICAgICAgIGRlZmluZShbXSwgZmFjdG9yeSk7XHJcblxyXG4gICAgfSBlbHNlIGlmICggdHlwZW9mIGV4cG9ydHMgPT09ICdvYmplY3QnICkge1xyXG5cclxuICAgICAgICAvLyBOb2RlL0NvbW1vbkpTXHJcbiAgICAgICAgbW9kdWxlLmV4cG9ydHMgPSBmYWN0b3J5KCk7XHJcblxyXG4gICAgfSBlbHNlIHtcclxuXHJcbiAgICAgICAgLy8gQnJvd3NlciBnbG9iYWxzXHJcbiAgICAgICAgd2luZG93Lm5vVWlTbGlkZXIgPSBmYWN0b3J5KCk7XHJcbiAgICB9XHJcblxyXG59KGZ1bmN0aW9uKCApe1xyXG5cclxuXHQndXNlIHN0cmljdCc7XHJcblxyXG5cdHZhciBWRVJTSU9OID0gJzExLjEuMCc7XHJcblxyXG5cblx0ZnVuY3Rpb24gaXNWYWxpZEZvcm1hdHRlciAoIGVudHJ5ICkge1xuXHRcdHJldHVybiB0eXBlb2YgZW50cnkgPT09ICdvYmplY3QnICYmIHR5cGVvZiBlbnRyeS50byA9PT0gJ2Z1bmN0aW9uJyAmJiB0eXBlb2YgZW50cnkuZnJvbSA9PT0gJ2Z1bmN0aW9uJztcblx0fVxuXG5cdGZ1bmN0aW9uIHJlbW92ZUVsZW1lbnQgKCBlbCApIHtcblx0XHRlbC5wYXJlbnRFbGVtZW50LnJlbW92ZUNoaWxkKGVsKTtcblx0fVxuXG5cdGZ1bmN0aW9uIGlzU2V0ICggdmFsdWUgKSB7XG5cdFx0cmV0dXJuIHZhbHVlICE9PSBudWxsICYmIHZhbHVlICE9PSB1bmRlZmluZWQ7XG5cdH1cblxuXHQvLyBCaW5kYWJsZSB2ZXJzaW9uXG5cdGZ1bmN0aW9uIHByZXZlbnREZWZhdWx0ICggZSApIHtcblx0XHRlLnByZXZlbnREZWZhdWx0KCk7XG5cdH1cblxuXHQvLyBSZW1vdmVzIGR1cGxpY2F0ZXMgZnJvbSBhbiBhcnJheS5cblx0ZnVuY3Rpb24gdW5pcXVlICggYXJyYXkgKSB7XG5cdFx0cmV0dXJuIGFycmF5LmZpbHRlcihmdW5jdGlvbihhKXtcblx0XHRcdHJldHVybiAhdGhpc1thXSA/IHRoaXNbYV0gPSB0cnVlIDogZmFsc2U7XG5cdFx0fSwge30pO1xuXHR9XG5cblx0Ly8gUm91bmQgYSB2YWx1ZSB0byB0aGUgY2xvc2VzdCAndG8nLlxuXHRmdW5jdGlvbiBjbG9zZXN0ICggdmFsdWUsIHRvICkge1xuXHRcdHJldHVybiBNYXRoLnJvdW5kKHZhbHVlIC8gdG8pICogdG87XG5cdH1cblxuXHQvLyBDdXJyZW50IHBvc2l0aW9uIG9mIGFuIGVsZW1lbnQgcmVsYXRpdmUgdG8gdGhlIGRvY3VtZW50LlxuXHRmdW5jdGlvbiBvZmZzZXQgKCBlbGVtLCBvcmllbnRhdGlvbiApIHtcblxuXHRcdHZhciByZWN0ID0gZWxlbS5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTtcblx0XHR2YXIgZG9jID0gZWxlbS5vd25lckRvY3VtZW50O1xuXHRcdHZhciBkb2NFbGVtID0gZG9jLmRvY3VtZW50RWxlbWVudDtcblx0XHR2YXIgcGFnZU9mZnNldCA9IGdldFBhZ2VPZmZzZXQoZG9jKTtcblxuXHRcdC8vIGdldEJvdW5kaW5nQ2xpZW50UmVjdCBjb250YWlucyBsZWZ0IHNjcm9sbCBpbiBDaHJvbWUgb24gQW5kcm9pZC5cblx0XHQvLyBJIGhhdmVuJ3QgZm91bmQgYSBmZWF0dXJlIGRldGVjdGlvbiB0aGF0IHByb3ZlcyB0aGlzLiBXb3JzdCBjYXNlXG5cdFx0Ly8gc2NlbmFyaW8gb24gbWlzLW1hdGNoOiB0aGUgJ3RhcCcgZmVhdHVyZSBvbiBob3Jpem9udGFsIHNsaWRlcnMgYnJlYWtzLlxuXHRcdGlmICggL3dlYmtpdC4qQ2hyb21lLipNb2JpbGUvaS50ZXN0KG5hdmlnYXRvci51c2VyQWdlbnQpICkge1xuXHRcdFx0cGFnZU9mZnNldC54ID0gMDtcblx0XHR9XG5cblx0XHRyZXR1cm4gb3JpZW50YXRpb24gPyAocmVjdC50b3AgKyBwYWdlT2Zmc2V0LnkgLSBkb2NFbGVtLmNsaWVudFRvcCkgOiAocmVjdC5sZWZ0ICsgcGFnZU9mZnNldC54IC0gZG9jRWxlbS5jbGllbnRMZWZ0KTtcblx0fVxuXG5cdC8vIENoZWNrcyB3aGV0aGVyIGEgdmFsdWUgaXMgbnVtZXJpY2FsLlxuXHRmdW5jdGlvbiBpc051bWVyaWMgKCBhICkge1xuXHRcdHJldHVybiB0eXBlb2YgYSA9PT0gJ251bWJlcicgJiYgIWlzTmFOKCBhICkgJiYgaXNGaW5pdGUoIGEgKTtcblx0fVxuXG5cdC8vIFNldHMgYSBjbGFzcyBhbmQgcmVtb3ZlcyBpdCBhZnRlciBbZHVyYXRpb25dIG1zLlxuXHRmdW5jdGlvbiBhZGRDbGFzc0ZvciAoIGVsZW1lbnQsIGNsYXNzTmFtZSwgZHVyYXRpb24gKSB7XG5cdFx0aWYgKGR1cmF0aW9uID4gMCkge1xuXHRcdGFkZENsYXNzKGVsZW1lbnQsIGNsYXNzTmFtZSk7XG5cdFx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG5cdFx0XHRcdHJlbW92ZUNsYXNzKGVsZW1lbnQsIGNsYXNzTmFtZSk7XG5cdFx0XHR9LCBkdXJhdGlvbik7XG5cdFx0fVxuXHR9XG5cblx0Ly8gTGltaXRzIGEgdmFsdWUgdG8gMCAtIDEwMFxuXHRmdW5jdGlvbiBsaW1pdCAoIGEgKSB7XG5cdFx0cmV0dXJuIE1hdGgubWF4KE1hdGgubWluKGEsIDEwMCksIDApO1xuXHR9XG5cblx0Ly8gV3JhcHMgYSB2YXJpYWJsZSBhcyBhbiBhcnJheSwgaWYgaXQgaXNuJ3Qgb25lIHlldC5cblx0Ly8gTm90ZSB0aGF0IGFuIGlucHV0IGFycmF5IGlzIHJldHVybmVkIGJ5IHJlZmVyZW5jZSFcblx0ZnVuY3Rpb24gYXNBcnJheSAoIGEgKSB7XG5cdFx0cmV0dXJuIEFycmF5LmlzQXJyYXkoYSkgPyBhIDogW2FdO1xuXHR9XG5cblx0Ly8gQ291bnRzIGRlY2ltYWxzXG5cdGZ1bmN0aW9uIGNvdW50RGVjaW1hbHMgKCBudW1TdHIgKSB7XG5cdFx0bnVtU3RyID0gU3RyaW5nKG51bVN0cik7XG5cdFx0dmFyIHBpZWNlcyA9IG51bVN0ci5zcGxpdChcIi5cIik7XG5cdFx0cmV0dXJuIHBpZWNlcy5sZW5ndGggPiAxID8gcGllY2VzWzFdLmxlbmd0aCA6IDA7XG5cdH1cblxuXHQvLyBodHRwOi8veW91bWlnaHRub3RuZWVkanF1ZXJ5LmNvbS8jYWRkX2NsYXNzXG5cdGZ1bmN0aW9uIGFkZENsYXNzICggZWwsIGNsYXNzTmFtZSApIHtcblx0XHRpZiAoIGVsLmNsYXNzTGlzdCApIHtcblx0XHRcdGVsLmNsYXNzTGlzdC5hZGQoY2xhc3NOYW1lKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZWwuY2xhc3NOYW1lICs9ICcgJyArIGNsYXNzTmFtZTtcblx0XHR9XG5cdH1cblxuXHQvLyBodHRwOi8veW91bWlnaHRub3RuZWVkanF1ZXJ5LmNvbS8jcmVtb3ZlX2NsYXNzXG5cdGZ1bmN0aW9uIHJlbW92ZUNsYXNzICggZWwsIGNsYXNzTmFtZSApIHtcblx0XHRpZiAoIGVsLmNsYXNzTGlzdCApIHtcblx0XHRcdGVsLmNsYXNzTGlzdC5yZW1vdmUoY2xhc3NOYW1lKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZWwuY2xhc3NOYW1lID0gZWwuY2xhc3NOYW1lLnJlcGxhY2UobmV3IFJlZ0V4cCgnKF58XFxcXGIpJyArIGNsYXNzTmFtZS5zcGxpdCgnICcpLmpvaW4oJ3wnKSArICcoXFxcXGJ8JCknLCAnZ2knKSwgJyAnKTtcblx0XHR9XG5cdH1cblxuXHQvLyBodHRwczovL3BsYWluanMuY29tL2phdmFzY3JpcHQvYXR0cmlidXRlcy9hZGRpbmctcmVtb3ZpbmctYW5kLXRlc3RpbmctZm9yLWNsYXNzZXMtOS9cblx0ZnVuY3Rpb24gaGFzQ2xhc3MgKCBlbCwgY2xhc3NOYW1lICkge1xuXHRcdHJldHVybiBlbC5jbGFzc0xpc3QgPyBlbC5jbGFzc0xpc3QuY29udGFpbnMoY2xhc3NOYW1lKSA6IG5ldyBSZWdFeHAoJ1xcXFxiJyArIGNsYXNzTmFtZSArICdcXFxcYicpLnRlc3QoZWwuY2xhc3NOYW1lKTtcblx0fVxuXG5cdC8vIGh0dHBzOi8vZGV2ZWxvcGVyLm1vemlsbGEub3JnL2VuLVVTL2RvY3MvV2ViL0FQSS9XaW5kb3cvc2Nyb2xsWSNOb3Rlc1xuXHRmdW5jdGlvbiBnZXRQYWdlT2Zmc2V0ICggZG9jICkge1xuXG5cdFx0dmFyIHN1cHBvcnRQYWdlT2Zmc2V0ID0gd2luZG93LnBhZ2VYT2Zmc2V0ICE9PSB1bmRlZmluZWQ7XG5cdFx0dmFyIGlzQ1NTMUNvbXBhdCA9ICgoZG9jLmNvbXBhdE1vZGUgfHwgXCJcIikgPT09IFwiQ1NTMUNvbXBhdFwiKTtcblx0XHR2YXIgeCA9IHN1cHBvcnRQYWdlT2Zmc2V0ID8gd2luZG93LnBhZ2VYT2Zmc2V0IDogaXNDU1MxQ29tcGF0ID8gZG9jLmRvY3VtZW50RWxlbWVudC5zY3JvbGxMZWZ0IDogZG9jLmJvZHkuc2Nyb2xsTGVmdDtcblx0XHR2YXIgeSA9IHN1cHBvcnRQYWdlT2Zmc2V0ID8gd2luZG93LnBhZ2VZT2Zmc2V0IDogaXNDU1MxQ29tcGF0ID8gZG9jLmRvY3VtZW50RWxlbWVudC5zY3JvbGxUb3AgOiBkb2MuYm9keS5zY3JvbGxUb3A7XG5cblx0XHRyZXR1cm4ge1xuXHRcdFx0eDogeCxcblx0XHRcdHk6IHlcblx0XHR9O1xuXHR9XG5cclxuXHQvLyB3ZSBwcm92aWRlIGEgZnVuY3Rpb24gdG8gY29tcHV0ZSBjb25zdGFudHMgaW5zdGVhZFxyXG5cdC8vIG9mIGFjY2Vzc2luZyB3aW5kb3cuKiBhcyBzb29uIGFzIHRoZSBtb2R1bGUgbmVlZHMgaXRcclxuXHQvLyBzbyB0aGF0IHdlIGRvIG5vdCBjb21wdXRlIGFueXRoaW5nIGlmIG5vdCBuZWVkZWRcclxuXHRmdW5jdGlvbiBnZXRBY3Rpb25zICggKSB7XHJcblxyXG5cdFx0Ly8gRGV0ZXJtaW5lIHRoZSBldmVudHMgdG8gYmluZC4gSUUxMSBpbXBsZW1lbnRzIHBvaW50ZXJFdmVudHMgd2l0aG91dFxyXG5cdFx0Ly8gYSBwcmVmaXgsIHdoaWNoIGJyZWFrcyBjb21wYXRpYmlsaXR5IHdpdGggdGhlIElFMTAgaW1wbGVtZW50YXRpb24uXHJcblx0XHRyZXR1cm4gd2luZG93Lm5hdmlnYXRvci5wb2ludGVyRW5hYmxlZCA/IHtcclxuXHRcdFx0c3RhcnQ6ICdwb2ludGVyZG93bicsXHJcblx0XHRcdG1vdmU6ICdwb2ludGVybW92ZScsXHJcblx0XHRcdGVuZDogJ3BvaW50ZXJ1cCdcclxuXHRcdH0gOiB3aW5kb3cubmF2aWdhdG9yLm1zUG9pbnRlckVuYWJsZWQgPyB7XHJcblx0XHRcdHN0YXJ0OiAnTVNQb2ludGVyRG93bicsXHJcblx0XHRcdG1vdmU6ICdNU1BvaW50ZXJNb3ZlJyxcclxuXHRcdFx0ZW5kOiAnTVNQb2ludGVyVXAnXHJcblx0XHR9IDoge1xyXG5cdFx0XHRzdGFydDogJ21vdXNlZG93biB0b3VjaHN0YXJ0JyxcclxuXHRcdFx0bW92ZTogJ21vdXNlbW92ZSB0b3VjaG1vdmUnLFxyXG5cdFx0XHRlbmQ6ICdtb3VzZXVwIHRvdWNoZW5kJ1xyXG5cdFx0fTtcclxuXHR9XHJcblxyXG5cdC8vIGh0dHBzOi8vZ2l0aHViLmNvbS9XSUNHL0V2ZW50TGlzdGVuZXJPcHRpb25zL2Jsb2IvZ2gtcGFnZXMvZXhwbGFpbmVyLm1kXHJcblx0Ly8gSXNzdWUgIzc4NVxyXG5cdGZ1bmN0aW9uIGdldFN1cHBvcnRzUGFzc2l2ZSAoICkge1xyXG5cclxuXHRcdHZhciBzdXBwb3J0c1Bhc3NpdmUgPSBmYWxzZTtcclxuXHJcblx0XHR0cnkge1xyXG5cclxuXHRcdFx0dmFyIG9wdHMgPSBPYmplY3QuZGVmaW5lUHJvcGVydHkoe30sICdwYXNzaXZlJywge1xyXG5cdFx0XHRcdGdldDogZnVuY3Rpb24oKSB7XHJcblx0XHRcdFx0XHRzdXBwb3J0c1Bhc3NpdmUgPSB0cnVlO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fSk7XHJcblxyXG5cdFx0XHR3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcigndGVzdCcsIG51bGwsIG9wdHMpO1xyXG5cclxuXHRcdH0gY2F0Y2ggKGUpIHt9XHJcblxyXG5cdFx0cmV0dXJuIHN1cHBvcnRzUGFzc2l2ZTtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIGdldFN1cHBvcnRzVG91Y2hBY3Rpb25Ob25lICggKSB7XHJcblx0XHRyZXR1cm4gd2luZG93LkNTUyAmJiBDU1Muc3VwcG9ydHMgJiYgQ1NTLnN1cHBvcnRzKCd0b3VjaC1hY3Rpb24nLCAnbm9uZScpO1xyXG5cdH1cclxuXHJcblxyXG4vLyBWYWx1ZSBjYWxjdWxhdGlvblxyXG5cclxuXHQvLyBEZXRlcm1pbmUgdGhlIHNpemUgb2YgYSBzdWItcmFuZ2UgaW4gcmVsYXRpb24gdG8gYSBmdWxsIHJhbmdlLlxyXG5cdGZ1bmN0aW9uIHN1YlJhbmdlUmF0aW8gKCBwYSwgcGIgKSB7XHJcblx0XHRyZXR1cm4gKDEwMCAvIChwYiAtIHBhKSk7XHJcblx0fVxyXG5cclxuXHQvLyAocGVyY2VudGFnZSkgSG93IG1hbnkgcGVyY2VudCBpcyB0aGlzIHZhbHVlIG9mIHRoaXMgcmFuZ2U/XHJcblx0ZnVuY3Rpb24gZnJvbVBlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gKHZhbHVlICogMTAwKSAvICggcmFuZ2VbMV0gLSByYW5nZVswXSApO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIFdoZXJlIGlzIHRoaXMgdmFsdWUgb24gdGhpcyByYW5nZT9cclxuXHRmdW5jdGlvbiB0b1BlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gZnJvbVBlcmNlbnRhZ2UoIHJhbmdlLCByYW5nZVswXSA8IDAgP1xyXG5cdFx0XHR2YWx1ZSArIE1hdGguYWJzKHJhbmdlWzBdKSA6XHJcblx0XHRcdFx0dmFsdWUgLSByYW5nZVswXSApO1xyXG5cdH1cclxuXHJcblx0Ly8gKHZhbHVlKSBIb3cgbXVjaCBpcyB0aGlzIHBlcmNlbnRhZ2Ugb24gdGhpcyByYW5nZT9cclxuXHRmdW5jdGlvbiBpc1BlcmNlbnRhZ2UgKCByYW5nZSwgdmFsdWUgKSB7XHJcblx0XHRyZXR1cm4gKCh2YWx1ZSAqICggcmFuZ2VbMV0gLSByYW5nZVswXSApKSAvIDEwMCkgKyByYW5nZVswXTtcclxuXHR9XHJcblxyXG5cclxuLy8gUmFuZ2UgY29udmVyc2lvblxyXG5cclxuXHRmdW5jdGlvbiBnZXRKICggdmFsdWUsIGFyciApIHtcclxuXHJcblx0XHR2YXIgaiA9IDE7XHJcblxyXG5cdFx0d2hpbGUgKCB2YWx1ZSA+PSBhcnJbal0gKXtcclxuXHRcdFx0aiArPSAxO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBqO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIElucHV0IGEgdmFsdWUsIGZpbmQgd2hlcmUsIG9uIGEgc2NhbGUgb2YgMC0xMDAsIGl0IGFwcGxpZXMuXHJcblx0ZnVuY3Rpb24gdG9TdGVwcGluZyAoIHhWYWwsIHhQY3QsIHZhbHVlICkge1xyXG5cclxuXHRcdGlmICggdmFsdWUgPj0geFZhbC5zbGljZSgtMSlbMF0gKXtcclxuXHRcdFx0cmV0dXJuIDEwMDtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgaiA9IGdldEooIHZhbHVlLCB4VmFsICk7XHJcblx0XHR2YXIgdmEgPSB4VmFsW2otMV07XHJcblx0XHR2YXIgdmIgPSB4VmFsW2pdO1xyXG5cdFx0dmFyIHBhID0geFBjdFtqLTFdO1xyXG5cdFx0dmFyIHBiID0geFBjdFtqXTtcclxuXHJcblx0XHRyZXR1cm4gcGEgKyAodG9QZXJjZW50YWdlKFt2YSwgdmJdLCB2YWx1ZSkgLyBzdWJSYW5nZVJhdGlvIChwYSwgcGIpKTtcclxuXHR9XHJcblxyXG5cdC8vICh2YWx1ZSkgSW5wdXQgYSBwZXJjZW50YWdlLCBmaW5kIHdoZXJlIGl0IGlzIG9uIHRoZSBzcGVjaWZpZWQgcmFuZ2UuXHJcblx0ZnVuY3Rpb24gZnJvbVN0ZXBwaW5nICggeFZhbCwgeFBjdCwgdmFsdWUgKSB7XHJcblxyXG5cdFx0Ly8gVGhlcmUgaXMgbm8gcmFuZ2UgZ3JvdXAgdGhhdCBmaXRzIDEwMFxyXG5cdFx0aWYgKCB2YWx1ZSA+PSAxMDAgKXtcclxuXHRcdFx0cmV0dXJuIHhWYWwuc2xpY2UoLTEpWzBdO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBqID0gZ2V0SiggdmFsdWUsIHhQY3QgKTtcclxuXHRcdHZhciB2YSA9IHhWYWxbai0xXTtcclxuXHRcdHZhciB2YiA9IHhWYWxbal07XHJcblx0XHR2YXIgcGEgPSB4UGN0W2otMV07XHJcblx0XHR2YXIgcGIgPSB4UGN0W2pdO1xyXG5cclxuXHRcdHJldHVybiBpc1BlcmNlbnRhZ2UoW3ZhLCB2Yl0sICh2YWx1ZSAtIHBhKSAqIHN1YlJhbmdlUmF0aW8gKHBhLCBwYikpO1xyXG5cdH1cclxuXHJcblx0Ly8gKHBlcmNlbnRhZ2UpIEdldCB0aGUgc3RlcCB0aGF0IGFwcGxpZXMgYXQgYSBjZXJ0YWluIHZhbHVlLlxyXG5cdGZ1bmN0aW9uIGdldFN0ZXAgKCB4UGN0LCB4U3RlcHMsIHNuYXAsIHZhbHVlICkge1xyXG5cclxuXHRcdGlmICggdmFsdWUgPT09IDEwMCApIHtcclxuXHRcdFx0cmV0dXJuIHZhbHVlO1xyXG5cdFx0fVxyXG5cclxuXHRcdHZhciBqID0gZ2V0SiggdmFsdWUsIHhQY3QgKTtcclxuXHRcdHZhciBhID0geFBjdFtqLTFdO1xyXG5cdFx0dmFyIGIgPSB4UGN0W2pdO1xyXG5cclxuXHRcdC8vIElmICdzbmFwJyBpcyBzZXQsIHN0ZXBzIGFyZSB1c2VkIGFzIGZpeGVkIHBvaW50cyBvbiB0aGUgc2xpZGVyLlxyXG5cdFx0aWYgKCBzbmFwICkge1xyXG5cclxuXHRcdFx0Ly8gRmluZCB0aGUgY2xvc2VzdCBwb3NpdGlvbiwgYSBvciBiLlxyXG5cdFx0XHRpZiAoKHZhbHVlIC0gYSkgPiAoKGItYSkvMikpe1xyXG5cdFx0XHRcdHJldHVybiBiO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRyZXR1cm4gYTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoICF4U3RlcHNbai0xXSApe1xyXG5cdFx0XHRyZXR1cm4gdmFsdWU7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHhQY3Rbai0xXSArIGNsb3Nlc3QoXHJcblx0XHRcdHZhbHVlIC0geFBjdFtqLTFdLFxyXG5cdFx0XHR4U3RlcHNbai0xXVxyXG5cdFx0KTtcclxuXHR9XHJcblxyXG5cclxuLy8gRW50cnkgcGFyc2luZ1xyXG5cclxuXHRmdW5jdGlvbiBoYW5kbGVFbnRyeVBvaW50ICggaW5kZXgsIHZhbHVlLCB0aGF0ICkge1xyXG5cclxuXHRcdHZhciBwZXJjZW50YWdlO1xyXG5cclxuXHRcdC8vIFdyYXAgbnVtZXJpY2FsIGlucHV0IGluIGFuIGFycmF5LlxyXG5cdFx0aWYgKCB0eXBlb2YgdmFsdWUgPT09IFwibnVtYmVyXCIgKSB7XHJcblx0XHRcdHZhbHVlID0gW3ZhbHVlXTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBSZWplY3QgYW55IGludmFsaWQgaW5wdXQsIGJ5IHRlc3Rpbmcgd2hldGhlciB2YWx1ZSBpcyBhbiBhcnJheS5cclxuXHRcdGlmICggIUFycmF5LmlzQXJyYXkodmFsdWUpICl7XHJcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3JhbmdlJyBjb250YWlucyBpbnZhbGlkIHZhbHVlLlwiKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBDb3ZlcnQgbWluL21heCBzeW50YXggdG8gMCBhbmQgMTAwLlxyXG5cdFx0aWYgKCBpbmRleCA9PT0gJ21pbicgKSB7XHJcblx0XHRcdHBlcmNlbnRhZ2UgPSAwO1xyXG5cdFx0fSBlbHNlIGlmICggaW5kZXggPT09ICdtYXgnICkge1xyXG5cdFx0XHRwZXJjZW50YWdlID0gMTAwO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0cGVyY2VudGFnZSA9IHBhcnNlRmxvYXQoIGluZGV4ICk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQ2hlY2sgZm9yIGNvcnJlY3QgaW5wdXQuXHJcblx0XHRpZiAoICFpc051bWVyaWMoIHBlcmNlbnRhZ2UgKSB8fCAhaXNOdW1lcmljKCB2YWx1ZVswXSApICkge1xyXG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdyYW5nZScgdmFsdWUgaXNuJ3QgbnVtZXJpYy5cIik7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gU3RvcmUgdmFsdWVzLlxyXG5cdFx0dGhhdC54UGN0LnB1c2goIHBlcmNlbnRhZ2UgKTtcclxuXHRcdHRoYXQueFZhbC5wdXNoKCB2YWx1ZVswXSApO1xyXG5cclxuXHRcdC8vIE5hTiB3aWxsIGV2YWx1YXRlIHRvIGZhbHNlIHRvbywgYnV0IHRvIGtlZXBcclxuXHRcdC8vIGxvZ2dpbmcgY2xlYXIsIHNldCBzdGVwIGV4cGxpY2l0bHkuIE1ha2Ugc3VyZVxyXG5cdFx0Ly8gbm90IHRvIG92ZXJyaWRlIHRoZSAnc3RlcCcgc2V0dGluZyB3aXRoIGZhbHNlLlxyXG5cdFx0aWYgKCAhcGVyY2VudGFnZSApIHtcclxuXHRcdFx0aWYgKCAhaXNOYU4oIHZhbHVlWzFdICkgKSB7XHJcblx0XHRcdFx0dGhhdC54U3RlcHNbMF0gPSB2YWx1ZVsxXTtcclxuXHRcdFx0fVxyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0dGhhdC54U3RlcHMucHVzaCggaXNOYU4odmFsdWVbMV0pID8gZmFsc2UgOiB2YWx1ZVsxXSApO1xyXG5cdFx0fVxyXG5cclxuXHRcdHRoYXQueEhpZ2hlc3RDb21wbGV0ZVN0ZXAucHVzaCgwKTtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIGhhbmRsZVN0ZXBQb2ludCAoIGksIG4sIHRoYXQgKSB7XHJcblxyXG5cdFx0Ly8gSWdub3JlICdmYWxzZScgc3RlcHBpbmcuXHJcblx0XHRpZiAoICFuICkge1xyXG5cdFx0XHRyZXR1cm4gdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBGYWN0b3IgdG8gcmFuZ2UgcmF0aW9cclxuXHRcdHRoYXQueFN0ZXBzW2ldID0gZnJvbVBlcmNlbnRhZ2UoW3RoYXQueFZhbFtpXSwgdGhhdC54VmFsW2krMV1dLCBuKSAvIHN1YlJhbmdlUmF0aW8odGhhdC54UGN0W2ldLCB0aGF0LnhQY3RbaSsxXSk7XHJcblxyXG5cdFx0dmFyIHRvdGFsU3RlcHMgPSAodGhhdC54VmFsW2krMV0gLSB0aGF0LnhWYWxbaV0pIC8gdGhhdC54TnVtU3RlcHNbaV07XHJcblx0XHR2YXIgaGlnaGVzdFN0ZXAgPSBNYXRoLmNlaWwoTnVtYmVyKHRvdGFsU3RlcHMudG9GaXhlZCgzKSkgLSAxKTtcclxuXHRcdHZhciBzdGVwID0gdGhhdC54VmFsW2ldICsgKHRoYXQueE51bVN0ZXBzW2ldICogaGlnaGVzdFN0ZXApO1xyXG5cclxuXHRcdHRoYXQueEhpZ2hlc3RDb21wbGV0ZVN0ZXBbaV0gPSBzdGVwO1xyXG5cdH1cclxuXHJcblxyXG4vLyBJbnRlcmZhY2VcclxuXHJcblx0ZnVuY3Rpb24gU3BlY3RydW0gKCBlbnRyeSwgc25hcCwgc2luZ2xlU3RlcCApIHtcclxuXHJcblx0XHR0aGlzLnhQY3QgPSBbXTtcclxuXHRcdHRoaXMueFZhbCA9IFtdO1xyXG5cdFx0dGhpcy54U3RlcHMgPSBbIHNpbmdsZVN0ZXAgfHwgZmFsc2UgXTtcclxuXHRcdHRoaXMueE51bVN0ZXBzID0gWyBmYWxzZSBdO1xyXG5cdFx0dGhpcy54SGlnaGVzdENvbXBsZXRlU3RlcCA9IFtdO1xyXG5cclxuXHRcdHRoaXMuc25hcCA9IHNuYXA7XHJcblxyXG5cdFx0dmFyIGluZGV4O1xyXG5cdFx0dmFyIG9yZGVyZWQgPSBbXTsgLy8gWzAsICdtaW4nXSwgWzEsICc1MCUnXSwgWzIsICdtYXgnXVxyXG5cclxuXHRcdC8vIE1hcCB0aGUgb2JqZWN0IGtleXMgdG8gYW4gYXJyYXkuXHJcblx0XHRmb3IgKCBpbmRleCBpbiBlbnRyeSApIHtcclxuXHRcdFx0aWYgKCBlbnRyeS5oYXNPd25Qcm9wZXJ0eShpbmRleCkgKSB7XHJcblx0XHRcdFx0b3JkZXJlZC5wdXNoKFtlbnRyeVtpbmRleF0sIGluZGV4XSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBTb3J0IGFsbCBlbnRyaWVzIGJ5IHZhbHVlIChudW1lcmljIHNvcnQpLlxyXG5cdFx0aWYgKCBvcmRlcmVkLmxlbmd0aCAmJiB0eXBlb2Ygb3JkZXJlZFswXVswXSA9PT0gXCJvYmplY3RcIiApIHtcclxuXHRcdFx0b3JkZXJlZC5zb3J0KGZ1bmN0aW9uKGEsIGIpIHsgcmV0dXJuIGFbMF1bMF0gLSBiWzBdWzBdOyB9KTtcclxuXHRcdH0gZWxzZSB7XHJcblx0XHRcdG9yZGVyZWQuc29ydChmdW5jdGlvbihhLCBiKSB7IHJldHVybiBhWzBdIC0gYlswXTsgfSk7XHJcblx0XHR9XHJcblxyXG5cclxuXHRcdC8vIENvbnZlcnQgYWxsIGVudHJpZXMgdG8gc3VicmFuZ2VzLlxyXG5cdFx0Zm9yICggaW5kZXggPSAwOyBpbmRleCA8IG9yZGVyZWQubGVuZ3RoOyBpbmRleCsrICkge1xyXG5cdFx0XHRoYW5kbGVFbnRyeVBvaW50KG9yZGVyZWRbaW5kZXhdWzFdLCBvcmRlcmVkW2luZGV4XVswXSwgdGhpcyk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gU3RvcmUgdGhlIGFjdHVhbCBzdGVwIHZhbHVlcy5cclxuXHRcdC8vIHhTdGVwcyBpcyBzb3J0ZWQgaW4gdGhlIHNhbWUgb3JkZXIgYXMgeFBjdCBhbmQgeFZhbC5cclxuXHRcdHRoaXMueE51bVN0ZXBzID0gdGhpcy54U3RlcHMuc2xpY2UoMCk7XHJcblxyXG5cdFx0Ly8gQ29udmVydCBhbGwgbnVtZXJpYyBzdGVwcyB0byB0aGUgcGVyY2VudGFnZSBvZiB0aGUgc3VicmFuZ2UgdGhleSByZXByZXNlbnQuXHJcblx0XHRmb3IgKCBpbmRleCA9IDA7IGluZGV4IDwgdGhpcy54TnVtU3RlcHMubGVuZ3RoOyBpbmRleCsrICkge1xyXG5cdFx0XHRoYW5kbGVTdGVwUG9pbnQoaW5kZXgsIHRoaXMueE51bVN0ZXBzW2luZGV4XSwgdGhpcyk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUuZ2V0TWFyZ2luID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHJcblx0XHR2YXIgc3RlcCA9IHRoaXMueE51bVN0ZXBzWzBdO1xyXG5cclxuXHRcdGlmICggc3RlcCAmJiAoKHZhbHVlIC8gc3RlcCkgJSAxKSAhPT0gMCApIHtcclxuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbGltaXQnLCAnbWFyZ2luJyBhbmQgJ3BhZGRpbmcnIG11c3QgYmUgZGl2aXNpYmxlIGJ5IHN0ZXAuXCIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiB0aGlzLnhQY3QubGVuZ3RoID09PSAyID8gZnJvbVBlcmNlbnRhZ2UodGhpcy54VmFsLCB2YWx1ZSkgOiBmYWxzZTtcclxuXHR9O1xyXG5cclxuXHRTcGVjdHJ1bS5wcm90b3R5cGUudG9TdGVwcGluZyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0dmFsdWUgPSB0b1N0ZXBwaW5nKCB0aGlzLnhWYWwsIHRoaXMueFBjdCwgdmFsdWUgKTtcclxuXHJcblx0XHRyZXR1cm4gdmFsdWU7XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmZyb21TdGVwcGluZyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0cmV0dXJuIGZyb21TdGVwcGluZyggdGhpcy54VmFsLCB0aGlzLnhQY3QsIHZhbHVlICk7XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmdldFN0ZXAgPSBmdW5jdGlvbiAoIHZhbHVlICkge1xyXG5cclxuXHRcdHZhbHVlID0gZ2V0U3RlcCh0aGlzLnhQY3QsIHRoaXMueFN0ZXBzLCB0aGlzLnNuYXAsIHZhbHVlICk7XHJcblxyXG5cdFx0cmV0dXJuIHZhbHVlO1xyXG5cdH07XHJcblxyXG5cdFNwZWN0cnVtLnByb3RvdHlwZS5nZXROZWFyYnlTdGVwcyA9IGZ1bmN0aW9uICggdmFsdWUgKSB7XHJcblxyXG5cdFx0dmFyIGogPSBnZXRKKHZhbHVlLCB0aGlzLnhQY3QpO1xyXG5cclxuXHRcdHJldHVybiB7XHJcblx0XHRcdHN0ZXBCZWZvcmU6IHsgc3RhcnRWYWx1ZTogdGhpcy54VmFsW2otMl0sIHN0ZXA6IHRoaXMueE51bVN0ZXBzW2otMl0sIGhpZ2hlc3RTdGVwOiB0aGlzLnhIaWdoZXN0Q29tcGxldGVTdGVwW2otMl0gfSxcclxuXHRcdFx0dGhpc1N0ZXA6IHsgc3RhcnRWYWx1ZTogdGhpcy54VmFsW2otMV0sIHN0ZXA6IHRoaXMueE51bVN0ZXBzW2otMV0sIGhpZ2hlc3RTdGVwOiB0aGlzLnhIaWdoZXN0Q29tcGxldGVTdGVwW2otMV0gfSxcclxuXHRcdFx0c3RlcEFmdGVyOiB7IHN0YXJ0VmFsdWU6IHRoaXMueFZhbFtqLTBdLCBzdGVwOiB0aGlzLnhOdW1TdGVwc1tqLTBdLCBoaWdoZXN0U3RlcDogdGhpcy54SGlnaGVzdENvbXBsZXRlU3RlcFtqLTBdIH1cclxuXHRcdH07XHJcblx0fTtcclxuXHJcblx0U3BlY3RydW0ucHJvdG90eXBlLmNvdW50U3RlcERlY2ltYWxzID0gZnVuY3Rpb24gKCkge1xyXG5cdFx0dmFyIHN0ZXBEZWNpbWFscyA9IHRoaXMueE51bVN0ZXBzLm1hcChjb3VudERlY2ltYWxzKTtcclxuXHRcdHJldHVybiBNYXRoLm1heC5hcHBseShudWxsLCBzdGVwRGVjaW1hbHMpO1xyXG5cdH07XHJcblxyXG5cdC8vIE91dHNpZGUgdGVzdGluZ1xyXG5cdFNwZWN0cnVtLnByb3RvdHlwZS5jb252ZXJ0ID0gZnVuY3Rpb24gKCB2YWx1ZSApIHtcclxuXHRcdHJldHVybiB0aGlzLmdldFN0ZXAodGhpcy50b1N0ZXBwaW5nKHZhbHVlKSk7XHJcblx0fTtcclxuXHJcbi8qXHRFdmVyeSBpbnB1dCBvcHRpb24gaXMgdGVzdGVkIGFuZCBwYXJzZWQuIFRoaXMnbGwgcHJldmVudFxuXHRlbmRsZXNzIHZhbGlkYXRpb24gaW4gaW50ZXJuYWwgbWV0aG9kcy4gVGhlc2UgdGVzdHMgYXJlXG5cdHN0cnVjdHVyZWQgd2l0aCBhbiBpdGVtIGZvciBldmVyeSBvcHRpb24gYXZhaWxhYmxlLiBBblxuXHRvcHRpb24gY2FuIGJlIG1hcmtlZCBhcyByZXF1aXJlZCBieSBzZXR0aW5nIHRoZSAncicgZmxhZy5cblx0VGhlIHRlc3RpbmcgZnVuY3Rpb24gaXMgcHJvdmlkZWQgd2l0aCB0aHJlZSBhcmd1bWVudHM6XG5cdFx0LSBUaGUgcHJvdmlkZWQgdmFsdWUgZm9yIHRoZSBvcHRpb247XG5cdFx0LSBBIHJlZmVyZW5jZSB0byB0aGUgb3B0aW9ucyBvYmplY3Q7XG5cdFx0LSBUaGUgbmFtZSBmb3IgdGhlIG9wdGlvbjtcblxuXHRUaGUgdGVzdGluZyBmdW5jdGlvbiByZXR1cm5zIGZhbHNlIHdoZW4gYW4gZXJyb3IgaXMgZGV0ZWN0ZWQsXG5cdG9yIHRydWUgd2hlbiBldmVyeXRoaW5nIGlzIE9LLiBJdCBjYW4gYWxzbyBtb2RpZnkgdGhlIG9wdGlvblxuXHRvYmplY3QsIHRvIG1ha2Ugc3VyZSBhbGwgdmFsdWVzIGNhbiBiZSBjb3JyZWN0bHkgbG9vcGVkIGVsc2V3aGVyZS4gKi9cblxuXHR2YXIgZGVmYXVsdEZvcm1hdHRlciA9IHsgJ3RvJzogZnVuY3Rpb24oIHZhbHVlICl7XG5cdFx0cmV0dXJuIHZhbHVlICE9PSB1bmRlZmluZWQgJiYgdmFsdWUudG9GaXhlZCgyKTtcblx0fSwgJ2Zyb20nOiBOdW1iZXIgfTtcblxuXHRmdW5jdGlvbiB2YWxpZGF0ZUZvcm1hdCAoIGVudHJ5ICkge1xuXG5cdFx0Ly8gQW55IG9iamVjdCB3aXRoIGEgdG8gYW5kIGZyb20gbWV0aG9kIGlzIHN1cHBvcnRlZC5cblx0XHRpZiAoIGlzVmFsaWRGb3JtYXR0ZXIoZW50cnkpICkge1xuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fVxuXG5cdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnZm9ybWF0JyByZXF1aXJlcyAndG8nIGFuZCAnZnJvbScgbWV0aG9kcy5cIik7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0U3RlcCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoICFpc051bWVyaWMoIGVudHJ5ICkgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdzdGVwJyBpcyBub3QgbnVtZXJpYy5cIik7XG5cdFx0fVxuXG5cdFx0Ly8gVGhlIHN0ZXAgb3B0aW9uIGNhbiBzdGlsbCBiZSB1c2VkIHRvIHNldCBzdGVwcGluZ1xuXHRcdC8vIGZvciBsaW5lYXIgc2xpZGVycy4gT3ZlcndyaXR0ZW4gaWYgc2V0IGluICdyYW5nZScuXG5cdFx0cGFyc2VkLnNpbmdsZVN0ZXAgPSBlbnRyeTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RSYW5nZSAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBGaWx0ZXIgaW5jb3JyZWN0IGlucHV0LlxuXHRcdGlmICggdHlwZW9mIGVudHJ5ICE9PSAnb2JqZWN0JyB8fCBBcnJheS5pc0FycmF5KGVudHJ5KSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3JhbmdlJyBpcyBub3QgYW4gb2JqZWN0LlwiKTtcblx0XHR9XG5cblx0XHQvLyBDYXRjaCBtaXNzaW5nIHN0YXJ0IG9yIGVuZC5cblx0XHRpZiAoIGVudHJ5Lm1pbiA9PT0gdW5kZWZpbmVkIHx8IGVudHJ5Lm1heCA9PT0gdW5kZWZpbmVkICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiBNaXNzaW5nICdtaW4nIG9yICdtYXgnIGluICdyYW5nZScuXCIpO1xuXHRcdH1cblxuXHRcdC8vIENhdGNoIGVxdWFsIHN0YXJ0IG9yIGVuZC5cblx0XHRpZiAoIGVudHJ5Lm1pbiA9PT0gZW50cnkubWF4ICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncmFuZ2UnICdtaW4nIGFuZCAnbWF4JyBjYW5ub3QgYmUgZXF1YWwuXCIpO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5zcGVjdHJ1bSA9IG5ldyBTcGVjdHJ1bShlbnRyeSwgcGFyc2VkLnNuYXAsIHBhcnNlZC5zaW5nbGVTdGVwKTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RTdGFydCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRlbnRyeSA9IGFzQXJyYXkoZW50cnkpO1xuXG5cdFx0Ly8gVmFsaWRhdGUgaW5wdXQuIFZhbHVlcyBhcmVuJ3QgdGVzdGVkLCBhcyB0aGUgcHVibGljIC52YWwgbWV0aG9kXG5cdFx0Ly8gd2lsbCBhbHdheXMgcHJvdmlkZSBhIHZhbGlkIGxvY2F0aW9uLlxuXHRcdGlmICggIUFycmF5LmlzQXJyYXkoIGVudHJ5ICkgfHwgIWVudHJ5Lmxlbmd0aCApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3N0YXJ0JyBvcHRpb24gaXMgaW5jb3JyZWN0LlwiKTtcblx0XHR9XG5cblx0XHQvLyBTdG9yZSB0aGUgbnVtYmVyIG9mIGhhbmRsZXMuXG5cdFx0cGFyc2VkLmhhbmRsZXMgPSBlbnRyeS5sZW5ndGg7XG5cblx0XHQvLyBXaGVuIHRoZSBzbGlkZXIgaXMgaW5pdGlhbGl6ZWQsIHRoZSAudmFsIG1ldGhvZCB3aWxsXG5cdFx0Ly8gYmUgY2FsbGVkIHdpdGggdGhlIHN0YXJ0IG9wdGlvbnMuXG5cdFx0cGFyc2VkLnN0YXJ0ID0gZW50cnk7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0U25hcCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBFbmZvcmNlIDEwMCUgc3RlcHBpbmcgd2l0aGluIHN1YnJhbmdlcy5cblx0XHRwYXJzZWQuc25hcCA9IGVudHJ5O1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdib29sZWFuJyApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnc25hcCcgb3B0aW9uIG11c3QgYmUgYSBib29sZWFuLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0QW5pbWF0ZSAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBFbmZvcmNlIDEwMCUgc3RlcHBpbmcgd2l0aGluIHN1YnJhbmdlcy5cblx0XHRwYXJzZWQuYW5pbWF0ZSA9IGVudHJ5O1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdib29sZWFuJyApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnYW5pbWF0ZScgb3B0aW9uIG11c3QgYmUgYSBib29sZWFuLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0QW5pbWF0aW9uRHVyYXRpb24gKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0cGFyc2VkLmFuaW1hdGlvbkR1cmF0aW9uID0gZW50cnk7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ251bWJlcicgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2FuaW1hdGlvbkR1cmF0aW9uJyBvcHRpb24gbXVzdCBiZSBhIG51bWJlci5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdENvbm5lY3QgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0dmFyIGNvbm5lY3QgPSBbZmFsc2VdO1xuXHRcdHZhciBpO1xuXG5cdFx0Ly8gTWFwIGxlZ2FjeSBvcHRpb25zXG5cdFx0aWYgKCBlbnRyeSA9PT0gJ2xvd2VyJyApIHtcblx0XHRcdGVudHJ5ID0gW3RydWUsIGZhbHNlXTtcblx0XHR9XG5cblx0XHRlbHNlIGlmICggZW50cnkgPT09ICd1cHBlcicgKSB7XG5cdFx0XHRlbnRyeSA9IFtmYWxzZSwgdHJ1ZV07XG5cdFx0fVxuXG5cdFx0Ly8gSGFuZGxlIGJvb2xlYW4gb3B0aW9uc1xuXHRcdGlmICggZW50cnkgPT09IHRydWUgfHwgZW50cnkgPT09IGZhbHNlICkge1xuXG5cdFx0XHRmb3IgKCBpID0gMTsgaSA8IHBhcnNlZC5oYW5kbGVzOyBpKysgKSB7XG5cdFx0XHRcdGNvbm5lY3QucHVzaChlbnRyeSk7XG5cdFx0XHR9XG5cblx0XHRcdGNvbm5lY3QucHVzaChmYWxzZSk7XG5cdFx0fVxuXG5cdFx0Ly8gUmVqZWN0IGludmFsaWQgaW5wdXRcblx0XHRlbHNlIGlmICggIUFycmF5LmlzQXJyYXkoIGVudHJ5ICkgfHwgIWVudHJ5Lmxlbmd0aCB8fCBlbnRyeS5sZW5ndGggIT09IHBhcnNlZC5oYW5kbGVzICsgMSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2Nvbm5lY3QnIG9wdGlvbiBkb2Vzbid0IG1hdGNoIGhhbmRsZSBjb3VudC5cIik7XG5cdFx0fVxuXG5cdFx0ZWxzZSB7XG5cdFx0XHRjb25uZWN0ID0gZW50cnk7XG5cdFx0fVxuXG5cdFx0cGFyc2VkLmNvbm5lY3QgPSBjb25uZWN0O1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdE9yaWVudGF0aW9uICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdC8vIFNldCBvcmllbnRhdGlvbiB0byBhbiBhIG51bWVyaWNhbCB2YWx1ZSBmb3IgZWFzeVxuXHRcdC8vIGFycmF5IHNlbGVjdGlvbi5cblx0XHRzd2l0Y2ggKCBlbnRyeSApe1xuXHRcdFx0Y2FzZSAnaG9yaXpvbnRhbCc6XG5cdFx0XHRcdHBhcnNlZC5vcnQgPSAwO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdGNhc2UgJ3ZlcnRpY2FsJzpcblx0XHRcdFx0cGFyc2VkLm9ydCA9IDE7XG5cdFx0XHRcdGJyZWFrO1xuXHRcdFx0ZGVmYXVsdDpcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnb3JpZW50YXRpb24nIG9wdGlvbiBpcyBpbnZhbGlkLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0TWFyZ2luICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGlmICggIWlzTnVtZXJpYyhlbnRyeSkgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ21hcmdpbicgb3B0aW9uIG11c3QgYmUgbnVtZXJpYy5cIik7XG5cdFx0fVxuXG5cdFx0Ly8gSXNzdWUgIzU4MlxuXHRcdGlmICggZW50cnkgPT09IDAgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0cGFyc2VkLm1hcmdpbiA9IHBhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnkpO1xuXG5cdFx0aWYgKCAhcGFyc2VkLm1hcmdpbiApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ21hcmdpbicgb3B0aW9uIGlzIG9ubHkgc3VwcG9ydGVkIG9uIGxpbmVhciBzbGlkZXJzLlwiKTtcblx0XHR9XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0TGltaXQgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCAhaXNOdW1lcmljKGVudHJ5KSApe1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnbGltaXQnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMuXCIpO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5saW1pdCA9IHBhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnkpO1xuXG5cdFx0aWYgKCAhcGFyc2VkLmxpbWl0IHx8IHBhcnNlZC5oYW5kbGVzIDwgMiApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2xpbWl0JyBvcHRpb24gaXMgb25seSBzdXBwb3J0ZWQgb24gbGluZWFyIHNsaWRlcnMgd2l0aCAyIG9yIG1vcmUgaGFuZGxlcy5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdFBhZGRpbmcgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCAhaXNOdW1lcmljKGVudHJ5KSAmJiAhQXJyYXkuaXNBcnJheShlbnRyeSkgKXtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMgb3IgYXJyYXkgb2YgZXhhY3RseSAyIG51bWJlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggQXJyYXkuaXNBcnJheShlbnRyeSkgJiYgIShlbnRyeS5sZW5ndGggPT09IDIgfHwgaXNOdW1lcmljKGVudHJ5WzBdKSB8fCBpc051bWVyaWMoZW50cnlbMV0pKSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIG51bWVyaWMgb3IgYXJyYXkgb2YgZXhhY3RseSAyIG51bWJlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggZW50cnkgPT09IDAgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0aWYgKCAhQXJyYXkuaXNBcnJheShlbnRyeSkgKSB7XG5cdFx0XHRlbnRyeSA9IFtlbnRyeSwgZW50cnldO1xuXHRcdH1cblxuXHRcdC8vICdnZXRNYXJnaW4nIHJldHVybnMgZmFsc2UgZm9yIGludmFsaWQgdmFsdWVzLlxuXHRcdHBhcnNlZC5wYWRkaW5nID0gW3BhcnNlZC5zcGVjdHJ1bS5nZXRNYXJnaW4oZW50cnlbMF0pLCBwYXJzZWQuc3BlY3RydW0uZ2V0TWFyZ2luKGVudHJ5WzFdKV07XG5cblx0XHRpZiAoIHBhcnNlZC5wYWRkaW5nWzBdID09PSBmYWxzZSB8fCBwYXJzZWQucGFkZGluZ1sxXSA9PT0gZmFsc2UgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdwYWRkaW5nJyBvcHRpb24gaXMgb25seSBzdXBwb3J0ZWQgb24gbGluZWFyIHNsaWRlcnMuXCIpO1xuXHRcdH1cblxuXHRcdGlmICggcGFyc2VkLnBhZGRpbmdbMF0gPCAwIHx8IHBhcnNlZC5wYWRkaW5nWzFdIDwgMCApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3BhZGRpbmcnIG9wdGlvbiBtdXN0IGJlIGEgcG9zaXRpdmUgbnVtYmVyKHMpLlwiKTtcblx0XHR9XG5cblx0XHRpZiAoIHBhcnNlZC5wYWRkaW5nWzBdICsgcGFyc2VkLnBhZGRpbmdbMV0gPj0gMTAwICkge1xuXHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAncGFkZGluZycgb3B0aW9uIG11c3Qgbm90IGV4Y2VlZCAxMDAlIG9mIHRoZSByYW5nZS5cIik7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdERpcmVjdGlvbiAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHQvLyBTZXQgZGlyZWN0aW9uIGFzIGEgbnVtZXJpY2FsIHZhbHVlIGZvciBlYXN5IHBhcnNpbmcuXG5cdFx0Ly8gSW52ZXJ0IGNvbm5lY3Rpb24gZm9yIFJUTCBzbGlkZXJzLCBzbyB0aGF0IHRoZSBwcm9wZXJcblx0XHQvLyBoYW5kbGVzIGdldCB0aGUgY29ubmVjdC9iYWNrZ3JvdW5kIGNsYXNzZXMuXG5cdFx0c3dpdGNoICggZW50cnkgKSB7XG5cdFx0XHRjYXNlICdsdHInOlxuXHRcdFx0XHRwYXJzZWQuZGlyID0gMDtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHRjYXNlICdydGwnOlxuXHRcdFx0XHRwYXJzZWQuZGlyID0gMTtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHRkZWZhdWx0OlxuXHRcdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdkaXJlY3Rpb24nIG9wdGlvbiB3YXMgbm90IHJlY29nbml6ZWQuXCIpO1xuXHRcdH1cblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RCZWhhdmlvdXIgKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSBpbnB1dCBpcyBhIHN0cmluZy5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ3N0cmluZycgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdiZWhhdmlvdXInIG11c3QgYmUgYSBzdHJpbmcgY29udGFpbmluZyBvcHRpb25zLlwiKTtcblx0XHR9XG5cblx0XHQvLyBDaGVjayBpZiB0aGUgc3RyaW5nIGNvbnRhaW5zIGFueSBrZXl3b3Jkcy5cblx0XHQvLyBOb25lIGFyZSByZXF1aXJlZC5cblx0XHR2YXIgdGFwID0gZW50cnkuaW5kZXhPZigndGFwJykgPj0gMDtcblx0XHR2YXIgZHJhZyA9IGVudHJ5LmluZGV4T2YoJ2RyYWcnKSA+PSAwO1xuXHRcdHZhciBmaXhlZCA9IGVudHJ5LmluZGV4T2YoJ2ZpeGVkJykgPj0gMDtcblx0XHR2YXIgc25hcCA9IGVudHJ5LmluZGV4T2YoJ3NuYXAnKSA+PSAwO1xuXHRcdHZhciBob3ZlciA9IGVudHJ5LmluZGV4T2YoJ2hvdmVyJykgPj0gMDtcblxuXHRcdGlmICggZml4ZWQgKSB7XG5cblx0XHRcdGlmICggcGFyc2VkLmhhbmRsZXMgIT09IDIgKSB7XG5cdFx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2ZpeGVkJyBiZWhhdmlvdXIgbXVzdCBiZSB1c2VkIHdpdGggMiBoYW5kbGVzXCIpO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBVc2UgbWFyZ2luIHRvIGVuZm9yY2UgZml4ZWQgc3RhdGVcblx0XHRcdHRlc3RNYXJnaW4ocGFyc2VkLCBwYXJzZWQuc3RhcnRbMV0gLSBwYXJzZWQuc3RhcnRbMF0pO1xuXHRcdH1cblxuXHRcdHBhcnNlZC5ldmVudHMgPSB7XG5cdFx0XHR0YXA6IHRhcCB8fCBzbmFwLFxuXHRcdFx0ZHJhZzogZHJhZyxcblx0XHRcdGZpeGVkOiBmaXhlZCxcblx0XHRcdHNuYXA6IHNuYXAsXG5cdFx0XHRob3ZlcjogaG92ZXJcblx0XHR9O1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdFRvb2x0aXBzICggcGFyc2VkLCBlbnRyeSApIHtcblxuXHRcdGlmICggZW50cnkgPT09IGZhbHNlICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdGVsc2UgaWYgKCBlbnRyeSA9PT0gdHJ1ZSApIHtcblxuXHRcdFx0cGFyc2VkLnRvb2x0aXBzID0gW107XG5cblx0XHRcdGZvciAoIHZhciBpID0gMDsgaSA8IHBhcnNlZC5oYW5kbGVzOyBpKysgKSB7XG5cdFx0XHRcdHBhcnNlZC50b29sdGlwcy5wdXNoKHRydWUpO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdGVsc2Uge1xuXG5cdFx0XHRwYXJzZWQudG9vbHRpcHMgPSBhc0FycmF5KGVudHJ5KTtcblxuXHRcdFx0aWYgKCBwYXJzZWQudG9vbHRpcHMubGVuZ3RoICE9PSBwYXJzZWQuaGFuZGxlcyApIHtcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiBtdXN0IHBhc3MgYSBmb3JtYXR0ZXIgZm9yIGFsbCBoYW5kbGVzLlwiKTtcblx0XHRcdH1cblxuXHRcdFx0cGFyc2VkLnRvb2x0aXBzLmZvckVhY2goZnVuY3Rpb24oZm9ybWF0dGVyKXtcblx0XHRcdFx0aWYgKCB0eXBlb2YgZm9ybWF0dGVyICE9PSAnYm9vbGVhbicgJiYgKHR5cGVvZiBmb3JtYXR0ZXIgIT09ICdvYmplY3QnIHx8IHR5cGVvZiBmb3JtYXR0ZXIudG8gIT09ICdmdW5jdGlvbicpICkge1xuXHRcdFx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ3Rvb2x0aXBzJyBtdXN0IGJlIHBhc3NlZCBhIGZvcm1hdHRlciBvciAnZmFsc2UnLlwiKTtcblx0XHRcdFx0fVxuXHRcdFx0fSk7XG5cdFx0fVxuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdEFyaWFGb3JtYXQgKCBwYXJzZWQsIGVudHJ5ICkge1xuXHRcdHBhcnNlZC5hcmlhRm9ybWF0ID0gZW50cnk7XG5cdFx0dmFsaWRhdGVGb3JtYXQoZW50cnkpO1xuXHR9XG5cblx0ZnVuY3Rpb24gdGVzdEZvcm1hdCAoIHBhcnNlZCwgZW50cnkgKSB7XG5cdFx0cGFyc2VkLmZvcm1hdCA9IGVudHJ5O1xuXHRcdHZhbGlkYXRlRm9ybWF0KGVudHJ5KTtcblx0fVxuXG5cdGZ1bmN0aW9uIHRlc3RDc3NQcmVmaXggKCBwYXJzZWQsIGVudHJ5ICkge1xuXG5cdFx0aWYgKCB0eXBlb2YgZW50cnkgIT09ICdzdHJpbmcnICYmIGVudHJ5ICE9PSBmYWxzZSApIHtcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogJ2Nzc1ByZWZpeCcgbXVzdCBiZSBhIHN0cmluZyBvciBgZmFsc2VgLlwiKTtcblx0XHR9XG5cblx0XHRwYXJzZWQuY3NzUHJlZml4ID0gZW50cnk7XG5cdH1cblxuXHRmdW5jdGlvbiB0ZXN0Q3NzQ2xhc3NlcyAoIHBhcnNlZCwgZW50cnkgKSB7XG5cblx0XHRpZiAoIHR5cGVvZiBlbnRyeSAhPT0gJ29iamVjdCcgKSB7XG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6ICdjc3NDbGFzc2VzJyBtdXN0IGJlIGFuIG9iamVjdC5cIik7XG5cdFx0fVxuXG5cdFx0aWYgKCB0eXBlb2YgcGFyc2VkLmNzc1ByZWZpeCA9PT0gJ3N0cmluZycgKSB7XG5cdFx0XHRwYXJzZWQuY3NzQ2xhc3NlcyA9IHt9O1xuXG5cdFx0XHRmb3IgKCB2YXIga2V5IGluIGVudHJ5ICkge1xuXHRcdFx0XHRpZiAoICFlbnRyeS5oYXNPd25Qcm9wZXJ0eShrZXkpICkgeyBjb250aW51ZTsgfVxuXG5cdFx0XHRcdHBhcnNlZC5jc3NDbGFzc2VzW2tleV0gPSBwYXJzZWQuY3NzUHJlZml4ICsgZW50cnlba2V5XTtcblx0XHRcdH1cblx0XHR9IGVsc2Uge1xuXHRcdFx0cGFyc2VkLmNzc0NsYXNzZXMgPSBlbnRyeTtcblx0XHR9XG5cdH1cblxuXHQvLyBUZXN0IGFsbCBkZXZlbG9wZXIgc2V0dGluZ3MgYW5kIHBhcnNlIHRvIGFzc3VtcHRpb24tc2FmZSB2YWx1ZXMuXG5cdGZ1bmN0aW9uIHRlc3RPcHRpb25zICggb3B0aW9ucyApIHtcblxuXHRcdC8vIFRvIHByb3ZlIGEgZml4IGZvciAjNTM3LCBmcmVlemUgb3B0aW9ucyBoZXJlLlxuXHRcdC8vIElmIHRoZSBvYmplY3QgaXMgbW9kaWZpZWQsIGFuIGVycm9yIHdpbGwgYmUgdGhyb3duLlxuXHRcdC8vIE9iamVjdC5mcmVlemUob3B0aW9ucyk7XG5cblx0XHR2YXIgcGFyc2VkID0ge1xuXHRcdFx0bWFyZ2luOiAwLFxuXHRcdFx0bGltaXQ6IDAsXG5cdFx0XHRwYWRkaW5nOiAwLFxuXHRcdFx0YW5pbWF0ZTogdHJ1ZSxcblx0XHRcdGFuaW1hdGlvbkR1cmF0aW9uOiAzMDAsXG5cdFx0XHRhcmlhRm9ybWF0OiBkZWZhdWx0Rm9ybWF0dGVyLFxuXHRcdFx0Zm9ybWF0OiBkZWZhdWx0Rm9ybWF0dGVyXG5cdFx0fTtcblxuXHRcdC8vIFRlc3RzIGFyZSBleGVjdXRlZCBpbiB0aGUgb3JkZXIgdGhleSBhcmUgcHJlc2VudGVkIGhlcmUuXG5cdFx0dmFyIHRlc3RzID0ge1xuXHRcdFx0J3N0ZXAnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0U3RlcCB9LFxuXHRcdFx0J3N0YXJ0JzogeyByOiB0cnVlLCB0OiB0ZXN0U3RhcnQgfSxcblx0XHRcdCdjb25uZWN0JzogeyByOiB0cnVlLCB0OiB0ZXN0Q29ubmVjdCB9LFxuXHRcdFx0J2RpcmVjdGlvbic6IHsgcjogdHJ1ZSwgdDogdGVzdERpcmVjdGlvbiB9LFxuXHRcdFx0J3NuYXAnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0U25hcCB9LFxuXHRcdFx0J2FuaW1hdGUnOiB7IHI6IGZhbHNlLCB0OiB0ZXN0QW5pbWF0ZSB9LFxuXHRcdFx0J2FuaW1hdGlvbkR1cmF0aW9uJzogeyByOiBmYWxzZSwgdDogdGVzdEFuaW1hdGlvbkR1cmF0aW9uIH0sXG5cdFx0XHQncmFuZ2UnOiB7IHI6IHRydWUsIHQ6IHRlc3RSYW5nZSB9LFxuXHRcdFx0J29yaWVudGF0aW9uJzogeyByOiBmYWxzZSwgdDogdGVzdE9yaWVudGF0aW9uIH0sXG5cdFx0XHQnbWFyZ2luJzogeyByOiBmYWxzZSwgdDogdGVzdE1hcmdpbiB9LFxuXHRcdFx0J2xpbWl0JzogeyByOiBmYWxzZSwgdDogdGVzdExpbWl0IH0sXG5cdFx0XHQncGFkZGluZyc6IHsgcjogZmFsc2UsIHQ6IHRlc3RQYWRkaW5nIH0sXG5cdFx0XHQnYmVoYXZpb3VyJzogeyByOiB0cnVlLCB0OiB0ZXN0QmVoYXZpb3VyIH0sXG5cdFx0XHQnYXJpYUZvcm1hdCc6IHsgcjogZmFsc2UsIHQ6IHRlc3RBcmlhRm9ybWF0IH0sXG5cdFx0XHQnZm9ybWF0JzogeyByOiBmYWxzZSwgdDogdGVzdEZvcm1hdCB9LFxuXHRcdFx0J3Rvb2x0aXBzJzogeyByOiBmYWxzZSwgdDogdGVzdFRvb2x0aXBzIH0sXG5cdFx0XHQnY3NzUHJlZml4JzogeyByOiB0cnVlLCB0OiB0ZXN0Q3NzUHJlZml4IH0sXG5cdFx0XHQnY3NzQ2xhc3Nlcyc6IHsgcjogdHJ1ZSwgdDogdGVzdENzc0NsYXNzZXMgfVxuXHRcdH07XG5cblx0XHR2YXIgZGVmYXVsdHMgPSB7XG5cdFx0XHQnY29ubmVjdCc6IGZhbHNlLFxuXHRcdFx0J2RpcmVjdGlvbic6ICdsdHInLFxuXHRcdFx0J2JlaGF2aW91cic6ICd0YXAnLFxuXHRcdFx0J29yaWVudGF0aW9uJzogJ2hvcml6b250YWwnLFxuXHRcdFx0J2Nzc1ByZWZpeCcgOiAnbm9VaS0nLFxuXHRcdFx0J2Nzc0NsYXNzZXMnOiB7XG5cdFx0XHRcdHRhcmdldDogJ3RhcmdldCcsXG5cdFx0XHRcdGJhc2U6ICdiYXNlJyxcblx0XHRcdFx0b3JpZ2luOiAnb3JpZ2luJyxcblx0XHRcdFx0aGFuZGxlOiAnaGFuZGxlJyxcblx0XHRcdFx0aGFuZGxlTG93ZXI6ICdoYW5kbGUtbG93ZXInLFxuXHRcdFx0XHRoYW5kbGVVcHBlcjogJ2hhbmRsZS11cHBlcicsXG5cdFx0XHRcdGhvcml6b250YWw6ICdob3Jpem9udGFsJyxcblx0XHRcdFx0dmVydGljYWw6ICd2ZXJ0aWNhbCcsXG5cdFx0XHRcdGJhY2tncm91bmQ6ICdiYWNrZ3JvdW5kJyxcblx0XHRcdFx0Y29ubmVjdDogJ2Nvbm5lY3QnLFxuXHRcdFx0XHRjb25uZWN0czogJ2Nvbm5lY3RzJyxcblx0XHRcdFx0bHRyOiAnbHRyJyxcblx0XHRcdFx0cnRsOiAncnRsJyxcblx0XHRcdFx0ZHJhZ2dhYmxlOiAnZHJhZ2dhYmxlJyxcblx0XHRcdFx0ZHJhZzogJ3N0YXRlLWRyYWcnLFxuXHRcdFx0XHR0YXA6ICdzdGF0ZS10YXAnLFxuXHRcdFx0XHRhY3RpdmU6ICdhY3RpdmUnLFxuXHRcdFx0XHR0b29sdGlwOiAndG9vbHRpcCcsXG5cdFx0XHRcdHBpcHM6ICdwaXBzJyxcblx0XHRcdFx0cGlwc0hvcml6b250YWw6ICdwaXBzLWhvcml6b250YWwnLFxuXHRcdFx0XHRwaXBzVmVydGljYWw6ICdwaXBzLXZlcnRpY2FsJyxcblx0XHRcdFx0bWFya2VyOiAnbWFya2VyJyxcblx0XHRcdFx0bWFya2VySG9yaXpvbnRhbDogJ21hcmtlci1ob3Jpem9udGFsJyxcblx0XHRcdFx0bWFya2VyVmVydGljYWw6ICdtYXJrZXItdmVydGljYWwnLFxuXHRcdFx0XHRtYXJrZXJOb3JtYWw6ICdtYXJrZXItbm9ybWFsJyxcblx0XHRcdFx0bWFya2VyTGFyZ2U6ICdtYXJrZXItbGFyZ2UnLFxuXHRcdFx0XHRtYXJrZXJTdWI6ICdtYXJrZXItc3ViJyxcblx0XHRcdFx0dmFsdWU6ICd2YWx1ZScsXG5cdFx0XHRcdHZhbHVlSG9yaXpvbnRhbDogJ3ZhbHVlLWhvcml6b250YWwnLFxuXHRcdFx0XHR2YWx1ZVZlcnRpY2FsOiAndmFsdWUtdmVydGljYWwnLFxuXHRcdFx0XHR2YWx1ZU5vcm1hbDogJ3ZhbHVlLW5vcm1hbCcsXG5cdFx0XHRcdHZhbHVlTGFyZ2U6ICd2YWx1ZS1sYXJnZScsXG5cdFx0XHRcdHZhbHVlU3ViOiAndmFsdWUtc3ViJ1xuXHRcdFx0fVxuXHRcdH07XG5cblx0XHQvLyBBcmlhRm9ybWF0IGRlZmF1bHRzIHRvIHJlZ3VsYXIgZm9ybWF0LCBpZiBhbnkuXG5cdFx0aWYgKCBvcHRpb25zLmZvcm1hdCAmJiAhb3B0aW9ucy5hcmlhRm9ybWF0ICkge1xuXHRcdFx0b3B0aW9ucy5hcmlhRm9ybWF0ID0gb3B0aW9ucy5mb3JtYXQ7XG5cdFx0fVxuXG5cdFx0Ly8gUnVuIGFsbCBvcHRpb25zIHRocm91Z2ggYSB0ZXN0aW5nIG1lY2hhbmlzbSB0byBlbnN1cmUgY29ycmVjdFxuXHRcdC8vIGlucHV0LiBJdCBzaG91bGQgYmUgbm90ZWQgdGhhdCBvcHRpb25zIG1pZ2h0IGdldCBtb2RpZmllZCB0b1xuXHRcdC8vIGJlIGhhbmRsZWQgcHJvcGVybHkuIEUuZy4gd3JhcHBpbmcgaW50ZWdlcnMgaW4gYXJyYXlzLlxuXHRcdE9iamVjdC5rZXlzKHRlc3RzKS5mb3JFYWNoKGZ1bmN0aW9uKCBuYW1lICl7XG5cblx0XHRcdC8vIElmIHRoZSBvcHRpb24gaXNuJ3Qgc2V0LCBidXQgaXQgaXMgcmVxdWlyZWQsIHRocm93IGFuIGVycm9yLlxuXHRcdFx0aWYgKCAhaXNTZXQob3B0aW9uc1tuYW1lXSkgJiYgZGVmYXVsdHNbbmFtZV0gPT09IHVuZGVmaW5lZCApIHtcblxuXHRcdFx0XHRpZiAoIHRlc3RzW25hbWVdLnIgKSB7XG5cdFx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAnXCIgKyBuYW1lICsgXCInIGlzIHJlcXVpcmVkLlwiKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHJldHVybiB0cnVlO1xuXHRcdFx0fVxuXG5cdFx0XHR0ZXN0c1tuYW1lXS50KCBwYXJzZWQsICFpc1NldChvcHRpb25zW25hbWVdKSA/IGRlZmF1bHRzW25hbWVdIDogb3B0aW9uc1tuYW1lXSApO1xuXHRcdH0pO1xuXG5cdFx0Ly8gRm9yd2FyZCBwaXBzIG9wdGlvbnNcblx0XHRwYXJzZWQucGlwcyA9IG9wdGlvbnMucGlwcztcblxuXHRcdC8vIEFsbCByZWNlbnQgYnJvd3NlcnMgYWNjZXB0IHVucHJlZml4ZWQgdHJhbnNmb3JtLlxuXHRcdC8vIFdlIG5lZWQgLW1zLSBmb3IgSUU5IGFuZCAtd2Via2l0LSBmb3Igb2xkZXIgQW5kcm9pZDtcblx0XHQvLyBBc3N1bWUgdXNlIG9mIC13ZWJraXQtIGlmIHVucHJlZml4ZWQgYW5kIC1tcy0gYXJlIG5vdCBzdXBwb3J0ZWQuXG5cdFx0Ly8gaHR0cHM6Ly9jYW5pdXNlLmNvbS8jZmVhdD10cmFuc2Zvcm1zMmRcblx0XHR2YXIgZCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJkaXZcIik7XG5cdFx0dmFyIG1zUHJlZml4ID0gZC5zdHlsZS5tc1RyYW5zZm9ybSAhPT0gdW5kZWZpbmVkO1xuXHRcdHZhciBub1ByZWZpeCA9IGQuc3R5bGUudHJhbnNmb3JtICE9PSB1bmRlZmluZWQ7XG5cblx0XHRwYXJzZWQudHJhbnNmb3JtUnVsZSA9IG5vUHJlZml4ID8gJ3RyYW5zZm9ybScgOiAobXNQcmVmaXggPyAnbXNUcmFuc2Zvcm0nIDogJ3dlYmtpdFRyYW5zZm9ybScpO1xuXG5cdFx0Ly8gUGlwcyBkb24ndCBtb3ZlLCBzbyB3ZSBjYW4gcGxhY2UgdGhlbSB1c2luZyBsZWZ0L3RvcC5cblx0XHR2YXIgc3R5bGVzID0gW1snbGVmdCcsICd0b3AnXSwgWydyaWdodCcsICdib3R0b20nXV07XG5cblx0XHRwYXJzZWQuc3R5bGUgPSBzdHlsZXNbcGFyc2VkLmRpcl1bcGFyc2VkLm9ydF07XG5cblx0XHRyZXR1cm4gcGFyc2VkO1xuXHR9XG5cclxuXHJcbmZ1bmN0aW9uIHNjb3BlICggdGFyZ2V0LCBvcHRpb25zLCBvcmlnaW5hbE9wdGlvbnMgKXtcclxuXHJcblx0dmFyIGFjdGlvbnMgPSBnZXRBY3Rpb25zKCk7XHJcblx0dmFyIHN1cHBvcnRzVG91Y2hBY3Rpb25Ob25lID0gZ2V0U3VwcG9ydHNUb3VjaEFjdGlvbk5vbmUoKTtcclxuXHR2YXIgc3VwcG9ydHNQYXNzaXZlID0gc3VwcG9ydHNUb3VjaEFjdGlvbk5vbmUgJiYgZ2V0U3VwcG9ydHNQYXNzaXZlKCk7XHJcblxyXG5cdC8vIEFsbCB2YXJpYWJsZXMgbG9jYWwgdG8gJ3Njb3BlJyBhcmUgcHJlZml4ZWQgd2l0aCAnc2NvcGVfJ1xyXG5cdHZhciBzY29wZV9UYXJnZXQgPSB0YXJnZXQ7XHJcblx0dmFyIHNjb3BlX0xvY2F0aW9ucyA9IFtdO1xyXG5cdHZhciBzY29wZV9CYXNlO1xyXG5cdHZhciBzY29wZV9IYW5kbGVzO1xyXG5cdHZhciBzY29wZV9IYW5kbGVOdW1iZXJzID0gW107XHJcblx0dmFyIHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCA9IDA7XHJcblx0dmFyIHNjb3BlX0Nvbm5lY3RzO1xyXG5cdHZhciBzY29wZV9TcGVjdHJ1bSA9IG9wdGlvbnMuc3BlY3RydW07XHJcblx0dmFyIHNjb3BlX1ZhbHVlcyA9IFtdO1xyXG5cdHZhciBzY29wZV9FdmVudHMgPSB7fTtcclxuXHR2YXIgc2NvcGVfU2VsZjtcclxuXHR2YXIgc2NvcGVfUGlwcztcclxuXHR2YXIgc2NvcGVfRG9jdW1lbnQgPSB0YXJnZXQub3duZXJEb2N1bWVudDtcclxuXHR2YXIgc2NvcGVfRG9jdW1lbnRFbGVtZW50ID0gc2NvcGVfRG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50O1xyXG5cdHZhciBzY29wZV9Cb2R5ID0gc2NvcGVfRG9jdW1lbnQuYm9keTtcclxuXHJcblxyXG5cdC8vIEZvciBob3Jpem9udGFsIHNsaWRlcnMgaW4gc3RhbmRhcmQgbHRyIGRvY3VtZW50cyxcclxuXHQvLyBtYWtlIC5ub1VpLW9yaWdpbiBvdmVyZmxvdyB0byB0aGUgbGVmdCBzbyB0aGUgZG9jdW1lbnQgZG9lc24ndCBzY3JvbGwuXHJcblx0dmFyIHNjb3BlX0Rpck9mZnNldCA9IChzY29wZV9Eb2N1bWVudC5kaXIgPT09ICdydGwnKSB8fCAob3B0aW9ucy5vcnQgPT09IDEpID8gMCA6IDEwMDtcclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IENvbnN0cnVjdGlvbiBvZiBET00gZWxlbWVudHM7ICovXHJcblxyXG5cdC8vIENyZWF0ZXMgYSBub2RlLCBhZGRzIGl0IHRvIHRhcmdldCwgcmV0dXJucyB0aGUgbmV3IG5vZGUuXHJcblx0ZnVuY3Rpb24gYWRkTm9kZVRvICggYWRkVGFyZ2V0LCBjbGFzc05hbWUgKSB7XHJcblxyXG5cdFx0dmFyIGRpdiA9IHNjb3BlX0RvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xyXG5cclxuXHRcdGlmICggY2xhc3NOYW1lICkge1xyXG5cdFx0XHRhZGRDbGFzcyhkaXYsIGNsYXNzTmFtZSk7XHJcblx0XHR9XHJcblxyXG5cdFx0YWRkVGFyZ2V0LmFwcGVuZENoaWxkKGRpdik7XHJcblxyXG5cdFx0cmV0dXJuIGRpdjtcclxuXHR9XHJcblxyXG5cdC8vIEFwcGVuZCBhIG9yaWdpbiB0byB0aGUgYmFzZVxyXG5cdGZ1bmN0aW9uIGFkZE9yaWdpbiAoIGJhc2UsIGhhbmRsZU51bWJlciApIHtcclxuXHJcblx0XHR2YXIgb3JpZ2luID0gYWRkTm9kZVRvKGJhc2UsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5vcmlnaW4pO1xyXG5cdFx0dmFyIGhhbmRsZSA9IGFkZE5vZGVUbyhvcmlnaW4sIG9wdGlvbnMuY3NzQ2xhc3Nlcy5oYW5kbGUpO1xyXG5cclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ2RhdGEtaGFuZGxlJywgaGFuZGxlTnVtYmVyKTtcclxuXHJcblx0XHQvLyBodHRwczovL2RldmVsb3Blci5tb3ppbGxhLm9yZy9lbi1VUy9kb2NzL1dlYi9IVE1ML0dsb2JhbF9hdHRyaWJ1dGVzL3RhYmluZGV4XHJcblx0XHQvLyAwID0gZm9jdXNhYmxlIGFuZCByZWFjaGFibGVcclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ3RhYmluZGV4JywgJzAnKTtcclxuXHRcdGhhbmRsZS5zZXRBdHRyaWJ1dGUoJ3JvbGUnLCAnc2xpZGVyJyk7XHJcblx0XHRoYW5kbGUuc2V0QXR0cmlidXRlKCdhcmlhLW9yaWVudGF0aW9uJywgb3B0aW9ucy5vcnQgPyAndmVydGljYWwnIDogJ2hvcml6b250YWwnKTtcclxuXHJcblx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gMCApIHtcclxuXHRcdFx0YWRkQ2xhc3MoaGFuZGxlLCBvcHRpb25zLmNzc0NsYXNzZXMuaGFuZGxlTG93ZXIpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGVsc2UgaWYgKCBoYW5kbGVOdW1iZXIgPT09IG9wdGlvbnMuaGFuZGxlcyAtIDEgKSB7XHJcblx0XHRcdGFkZENsYXNzKGhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmhhbmRsZVVwcGVyKTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gb3JpZ2luO1xyXG5cdH1cclxuXHJcblx0Ly8gSW5zZXJ0IG5vZGVzIGZvciBjb25uZWN0IGVsZW1lbnRzXHJcblx0ZnVuY3Rpb24gYWRkQ29ubmVjdCAoIGJhc2UsIGFkZCApIHtcclxuXHJcblx0XHRpZiAoICFhZGQgKSB7XHJcblx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gYWRkTm9kZVRvKGJhc2UsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5jb25uZWN0KTtcclxuXHR9XHJcblxyXG5cdC8vIEFkZCBoYW5kbGVzIHRvIHRoZSBzbGlkZXIgYmFzZS5cclxuXHRmdW5jdGlvbiBhZGRFbGVtZW50cyAoIGNvbm5lY3RPcHRpb25zLCBiYXNlICkge1xyXG5cclxuXHRcdHZhciBjb25uZWN0QmFzZSA9IGFkZE5vZGVUbyhiYXNlLCBvcHRpb25zLmNzc0NsYXNzZXMuY29ubmVjdHMpO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZXMgPSBbXTtcclxuXHRcdHNjb3BlX0Nvbm5lY3RzID0gW107XHJcblxyXG5cdFx0c2NvcGVfQ29ubmVjdHMucHVzaChhZGRDb25uZWN0KGNvbm5lY3RCYXNlLCBjb25uZWN0T3B0aW9uc1swXSkpO1xyXG5cclxuXHRcdC8vIFs6Ojo6Tz09PT1PPT09PU89PT09XVxyXG5cdFx0Ly8gY29ubmVjdE9wdGlvbnMgPSBbMCwgMSwgMSwgMV1cclxuXHJcblx0XHRmb3IgKCB2YXIgaSA9IDA7IGkgPCBvcHRpb25zLmhhbmRsZXM7IGkrKyApIHtcclxuXHRcdFx0Ly8gS2VlcCBhIGxpc3Qgb2YgYWxsIGFkZGVkIGhhbmRsZXMuXHJcblx0XHRcdHNjb3BlX0hhbmRsZXMucHVzaChhZGRPcmlnaW4oYmFzZSwgaSkpO1xyXG5cdFx0XHRzY29wZV9IYW5kbGVOdW1iZXJzW2ldID0gaTtcclxuXHRcdFx0c2NvcGVfQ29ubmVjdHMucHVzaChhZGRDb25uZWN0KGNvbm5lY3RCYXNlLCBjb25uZWN0T3B0aW9uc1tpICsgMV0pKTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8vIEluaXRpYWxpemUgYSBzaW5nbGUgc2xpZGVyLlxyXG5cdGZ1bmN0aW9uIGFkZFNsaWRlciAoIGFkZFRhcmdldCApIHtcclxuXHJcblx0XHQvLyBBcHBseSBjbGFzc2VzIGFuZCBkYXRhIHRvIHRoZSB0YXJnZXQuXHJcblx0XHRhZGRDbGFzcyhhZGRUYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50YXJnZXQpO1xyXG5cclxuXHRcdGlmICggb3B0aW9ucy5kaXIgPT09IDAgKSB7XHJcblx0XHRcdGFkZENsYXNzKGFkZFRhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmx0cik7XHJcblx0XHR9IGVsc2Uge1xyXG5cdFx0XHRhZGRDbGFzcyhhZGRUYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5ydGwpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggb3B0aW9ucy5vcnQgPT09IDAgKSB7XHJcblx0XHRcdGFkZENsYXNzKGFkZFRhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmhvcml6b250YWwpO1xyXG5cdFx0fSBlbHNlIHtcclxuXHRcdFx0YWRkQ2xhc3MoYWRkVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMudmVydGljYWwpO1xyXG5cdFx0fVxyXG5cclxuXHRcdHNjb3BlX0Jhc2UgPSBhZGROb2RlVG8oYWRkVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMuYmFzZSk7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gYWRkVG9vbHRpcCAoIGhhbmRsZSwgaGFuZGxlTnVtYmVyICkge1xyXG5cclxuXHRcdGlmICggIW9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXSApIHtcclxuXHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuXHRcdHJldHVybiBhZGROb2RlVG8oaGFuZGxlLmZpcnN0Q2hpbGQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50b29sdGlwKTtcclxuXHR9XHJcblxyXG5cdC8vIFRoZSB0b29sdGlwcyBvcHRpb24gaXMgYSBzaG9ydGhhbmQgZm9yIHVzaW5nIHRoZSAndXBkYXRlJyBldmVudC5cclxuXHRmdW5jdGlvbiB0b29sdGlwcyAoICkge1xyXG5cclxuXHRcdC8vIFRvb2x0aXBzIGFyZSBhZGRlZCB3aXRoIG9wdGlvbnMudG9vbHRpcHMgaW4gb3JpZ2luYWwgb3JkZXIuXHJcblx0XHR2YXIgdGlwcyA9IHNjb3BlX0hhbmRsZXMubWFwKGFkZFRvb2x0aXApO1xyXG5cclxuXHRcdGJpbmRFdmVudCgndXBkYXRlJywgZnVuY3Rpb24odmFsdWVzLCBoYW5kbGVOdW1iZXIsIHVuZW5jb2RlZCkge1xyXG5cclxuXHRcdFx0aWYgKCAhdGlwc1toYW5kbGVOdW1iZXJdICkge1xyXG5cdFx0XHRcdHJldHVybjtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0dmFyIGZvcm1hdHRlZFZhbHVlID0gdmFsdWVzW2hhbmRsZU51bWJlcl07XHJcblxyXG5cdFx0XHRpZiAoIG9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXSAhPT0gdHJ1ZSApIHtcclxuXHRcdFx0XHRmb3JtYXR0ZWRWYWx1ZSA9IG9wdGlvbnMudG9vbHRpcHNbaGFuZGxlTnVtYmVyXS50byh1bmVuY29kZWRbaGFuZGxlTnVtYmVyXSk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHRpcHNbaGFuZGxlTnVtYmVyXS5pbm5lckhUTUwgPSBmb3JtYXR0ZWRWYWx1ZTtcclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblxyXG5cdGZ1bmN0aW9uIGFyaWEgKCApIHtcclxuXHJcblx0XHRiaW5kRXZlbnQoJ3VwZGF0ZScsIGZ1bmN0aW9uICggdmFsdWVzLCBoYW5kbGVOdW1iZXIsIHVuZW5jb2RlZCwgdGFwLCBwb3NpdGlvbnMgKSB7XHJcblxyXG5cdFx0XHQvLyBVcGRhdGUgQXJpYSBWYWx1ZXMgZm9yIGFsbCBoYW5kbGVzLCBhcyBhIGNoYW5nZSBpbiBvbmUgY2hhbmdlcyBtaW4gYW5kIG1heCB2YWx1ZXMgZm9yIHRoZSBuZXh0LlxyXG5cdFx0XHRzY29wZV9IYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oIGluZGV4ICl7XHJcblxyXG5cdFx0XHRcdHZhciBoYW5kbGUgPSBzY29wZV9IYW5kbGVzW2luZGV4XTtcclxuXHJcblx0XHRcdFx0dmFyIG1pbiA9IGNoZWNrSGFuZGxlUG9zaXRpb24oc2NvcGVfTG9jYXRpb25zLCBpbmRleCwgMCwgdHJ1ZSwgdHJ1ZSwgdHJ1ZSk7XHJcblx0XHRcdFx0dmFyIG1heCA9IGNoZWNrSGFuZGxlUG9zaXRpb24oc2NvcGVfTG9jYXRpb25zLCBpbmRleCwgMTAwLCB0cnVlLCB0cnVlLCB0cnVlKTtcclxuXHJcblx0XHRcdFx0dmFyIG5vdyA9IHBvc2l0aW9uc1tpbmRleF07XHJcblx0XHRcdFx0dmFyIHRleHQgPSBvcHRpb25zLmFyaWFGb3JtYXQudG8odW5lbmNvZGVkW2luZGV4XSk7XHJcblxyXG5cdFx0XHRcdGhhbmRsZS5jaGlsZHJlblswXS5zZXRBdHRyaWJ1dGUoJ2FyaWEtdmFsdWVtaW4nLCBtaW4udG9GaXhlZCgxKSk7XHJcblx0XHRcdFx0aGFuZGxlLmNoaWxkcmVuWzBdLnNldEF0dHJpYnV0ZSgnYXJpYS12YWx1ZW1heCcsIG1heC50b0ZpeGVkKDEpKTtcclxuXHRcdFx0XHRoYW5kbGUuY2hpbGRyZW5bMF0uc2V0QXR0cmlidXRlKCdhcmlhLXZhbHVlbm93Jywgbm93LnRvRml4ZWQoMSkpO1xyXG5cdFx0XHRcdGhhbmRsZS5jaGlsZHJlblswXS5zZXRBdHRyaWJ1dGUoJ2FyaWEtdmFsdWV0ZXh0JywgdGV4dCk7XHJcblx0XHRcdH0pO1xyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHJcblx0ZnVuY3Rpb24gZ2V0R3JvdXAgKCBtb2RlLCB2YWx1ZXMsIHN0ZXBwZWQgKSB7XHJcblxyXG5cdFx0Ly8gVXNlIHRoZSByYW5nZS5cclxuXHRcdGlmICggbW9kZSA9PT0gJ3JhbmdlJyB8fCBtb2RlID09PSAnc3RlcHMnICkge1xyXG5cdFx0XHRyZXR1cm4gc2NvcGVfU3BlY3RydW0ueFZhbDtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIG1vZGUgPT09ICdjb3VudCcgKSB7XHJcblxyXG5cdFx0XHRpZiAoIHZhbHVlcyA8IDIgKSB7XHJcblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKFwibm9VaVNsaWRlciAoXCIgKyBWRVJTSU9OICsgXCIpOiAndmFsdWVzJyAoPj0gMikgcmVxdWlyZWQgZm9yIG1vZGUgJ2NvdW50Jy5cIik7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIERpdmlkZSAwIC0gMTAwIGluICdjb3VudCcgcGFydHMuXHJcblx0XHRcdHZhciBpbnRlcnZhbCA9IHZhbHVlcyAtIDE7XHJcblx0XHRcdHZhciBzcHJlYWQgPSAoIDEwMCAvIGludGVydmFsICk7XHJcblxyXG5cdFx0XHR2YWx1ZXMgPSBbXTtcclxuXHJcblx0XHRcdC8vIExpc3QgdGhlc2UgcGFydHMgYW5kIGhhdmUgdGhlbSBoYW5kbGVkIGFzICdwb3NpdGlvbnMnLlxyXG5cdFx0XHR3aGlsZSAoIGludGVydmFsLS0gKSB7XHJcblx0XHRcdFx0dmFsdWVzWyBpbnRlcnZhbCBdID0gKCBpbnRlcnZhbCAqIHNwcmVhZCApO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHR2YWx1ZXMucHVzaCgxMDApO1xyXG5cclxuXHRcdFx0bW9kZSA9ICdwb3NpdGlvbnMnO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggbW9kZSA9PT0gJ3Bvc2l0aW9ucycgKSB7XHJcblxyXG5cdFx0XHQvLyBNYXAgYWxsIHBlcmNlbnRhZ2VzIHRvIG9uLXJhbmdlIHZhbHVlcy5cclxuXHRcdFx0cmV0dXJuIHZhbHVlcy5tYXAoZnVuY3Rpb24oIHZhbHVlICl7XHJcblx0XHRcdFx0cmV0dXJuIHNjb3BlX1NwZWN0cnVtLmZyb21TdGVwcGluZyggc3RlcHBlZCA/IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAoIHZhbHVlICkgOiB2YWx1ZSApO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHJcblx0XHRpZiAoIG1vZGUgPT09ICd2YWx1ZXMnICkge1xyXG5cclxuXHRcdFx0Ly8gSWYgdGhlIHZhbHVlIG11c3QgYmUgc3RlcHBlZCwgaXQgbmVlZHMgdG8gYmUgY29udmVydGVkIHRvIGEgcGVyY2VudGFnZSBmaXJzdC5cclxuXHRcdFx0aWYgKCBzdGVwcGVkICkge1xyXG5cclxuXHRcdFx0XHRyZXR1cm4gdmFsdWVzLm1hcChmdW5jdGlvbiggdmFsdWUgKXtcclxuXHJcblx0XHRcdFx0XHQvLyBDb252ZXJ0IHRvIHBlcmNlbnRhZ2UsIGFwcGx5IHN0ZXAsIHJldHVybiB0byB2YWx1ZS5cclxuXHRcdFx0XHRcdHJldHVybiBzY29wZV9TcGVjdHJ1bS5mcm9tU3RlcHBpbmcoIHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAoIHNjb3BlX1NwZWN0cnVtLnRvU3RlcHBpbmcoIHZhbHVlICkgKSApO1xyXG5cdFx0XHRcdH0pO1xyXG5cclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gT3RoZXJ3aXNlLCB3ZSBjYW4gc2ltcGx5IHVzZSB0aGUgdmFsdWVzLlxyXG5cdFx0XHRyZXR1cm4gdmFsdWVzO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gZ2VuZXJhdGVTcHJlYWQgKCBkZW5zaXR5LCBtb2RlLCBncm91cCApIHtcclxuXHJcblx0XHRmdW5jdGlvbiBzYWZlSW5jcmVtZW50KHZhbHVlLCBpbmNyZW1lbnQpIHtcclxuXHRcdFx0Ly8gQXZvaWQgZmxvYXRpbmcgcG9pbnQgdmFyaWFuY2UgYnkgZHJvcHBpbmcgdGhlIHNtYWxsZXN0IGRlY2ltYWwgcGxhY2VzLlxyXG5cdFx0XHRyZXR1cm4gKHZhbHVlICsgaW5jcmVtZW50KS50b0ZpeGVkKDcpIC8gMTtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgaW5kZXhlcyA9IHt9O1xyXG5cdFx0dmFyIGZpcnN0SW5SYW5nZSA9IHNjb3BlX1NwZWN0cnVtLnhWYWxbMF07XHJcblx0XHR2YXIgbGFzdEluUmFuZ2UgPSBzY29wZV9TcGVjdHJ1bS54VmFsW3Njb3BlX1NwZWN0cnVtLnhWYWwubGVuZ3RoLTFdO1xyXG5cdFx0dmFyIGlnbm9yZUZpcnN0ID0gZmFsc2U7XHJcblx0XHR2YXIgaWdub3JlTGFzdCA9IGZhbHNlO1xyXG5cdFx0dmFyIHByZXZQY3QgPSAwO1xyXG5cclxuXHRcdC8vIENyZWF0ZSBhIGNvcHkgb2YgdGhlIGdyb3VwLCBzb3J0IGl0IGFuZCBmaWx0ZXIgYXdheSBhbGwgZHVwbGljYXRlcy5cclxuXHRcdGdyb3VwID0gdW5pcXVlKGdyb3VwLnNsaWNlKCkuc29ydChmdW5jdGlvbihhLCBiKXsgcmV0dXJuIGEgLSBiOyB9KSk7XHJcblxyXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSByYW5nZSBzdGFydHMgd2l0aCB0aGUgZmlyc3QgZWxlbWVudC5cclxuXHRcdGlmICggZ3JvdXBbMF0gIT09IGZpcnN0SW5SYW5nZSApIHtcclxuXHRcdFx0Z3JvdXAudW5zaGlmdChmaXJzdEluUmFuZ2UpO1xyXG5cdFx0XHRpZ25vcmVGaXJzdCA9IHRydWU7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gTGlrZXdpc2UgZm9yIHRoZSBsYXN0IG9uZS5cclxuXHRcdGlmICggZ3JvdXBbZ3JvdXAubGVuZ3RoIC0gMV0gIT09IGxhc3RJblJhbmdlICkge1xyXG5cdFx0XHRncm91cC5wdXNoKGxhc3RJblJhbmdlKTtcclxuXHRcdFx0aWdub3JlTGFzdCA9IHRydWU7XHJcblx0XHR9XHJcblxyXG5cdFx0Z3JvdXAuZm9yRWFjaChmdW5jdGlvbiAoIGN1cnJlbnQsIGluZGV4ICkge1xyXG5cclxuXHRcdFx0Ly8gR2V0IHRoZSBjdXJyZW50IHN0ZXAgYW5kIHRoZSBsb3dlciArIHVwcGVyIHBvc2l0aW9ucy5cclxuXHRcdFx0dmFyIHN0ZXA7XHJcblx0XHRcdHZhciBpO1xyXG5cdFx0XHR2YXIgcTtcclxuXHRcdFx0dmFyIGxvdyA9IGN1cnJlbnQ7XHJcblx0XHRcdHZhciBoaWdoID0gZ3JvdXBbaW5kZXgrMV07XHJcblx0XHRcdHZhciBuZXdQY3Q7XHJcblx0XHRcdHZhciBwY3REaWZmZXJlbmNlO1xyXG5cdFx0XHR2YXIgcGN0UG9zO1xyXG5cdFx0XHR2YXIgdHlwZTtcclxuXHRcdFx0dmFyIHN0ZXBzO1xyXG5cdFx0XHR2YXIgcmVhbFN0ZXBzO1xyXG5cdFx0XHR2YXIgc3RlcHNpemU7XHJcblxyXG5cdFx0XHQvLyBXaGVuIHVzaW5nICdzdGVwcycgbW9kZSwgdXNlIHRoZSBwcm92aWRlZCBzdGVwcy5cclxuXHRcdFx0Ly8gT3RoZXJ3aXNlLCB3ZSdsbCBzdGVwIG9uIHRvIHRoZSBuZXh0IHN1YnJhbmdlLlxyXG5cdFx0XHRpZiAoIG1vZGUgPT09ICdzdGVwcycgKSB7XHJcblx0XHRcdFx0c3RlcCA9IHNjb3BlX1NwZWN0cnVtLnhOdW1TdGVwc1sgaW5kZXggXTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gRGVmYXVsdCB0byBhICdmdWxsJyBzdGVwLlxyXG5cdFx0XHRpZiAoICFzdGVwICkge1xyXG5cdFx0XHRcdHN0ZXAgPSBoaWdoLWxvdztcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gTG93IGNhbiBiZSAwLCBzbyB0ZXN0IGZvciBmYWxzZS4gSWYgaGlnaCBpcyB1bmRlZmluZWQsXHJcblx0XHRcdC8vIHdlIGFyZSBhdCB0aGUgbGFzdCBzdWJyYW5nZS4gSW5kZXggMCBpcyBhbHJlYWR5IGhhbmRsZWQuXHJcblx0XHRcdGlmICggbG93ID09PSBmYWxzZSB8fCBoaWdoID09PSB1bmRlZmluZWQgKSB7XHJcblx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBNYWtlIHN1cmUgc3RlcCBpc24ndCAwLCB3aGljaCB3b3VsZCBjYXVzZSBhbiBpbmZpbml0ZSBsb29wICgjNjU0KVxyXG5cdFx0XHRzdGVwID0gTWF0aC5tYXgoc3RlcCwgMC4wMDAwMDAxKTtcclxuXHJcblx0XHRcdC8vIEZpbmQgYWxsIHN0ZXBzIGluIHRoZSBzdWJyYW5nZS5cclxuXHRcdFx0Zm9yICggaSA9IGxvdzsgaSA8PSBoaWdoOyBpID0gc2FmZUluY3JlbWVudChpLCBzdGVwKSApIHtcclxuXHJcblx0XHRcdFx0Ly8gR2V0IHRoZSBwZXJjZW50YWdlIHZhbHVlIGZvciB0aGUgY3VycmVudCBzdGVwLFxyXG5cdFx0XHRcdC8vIGNhbGN1bGF0ZSB0aGUgc2l6ZSBmb3IgdGhlIHN1YnJhbmdlLlxyXG5cdFx0XHRcdG5ld1BjdCA9IHNjb3BlX1NwZWN0cnVtLnRvU3RlcHBpbmcoIGkgKTtcclxuXHRcdFx0XHRwY3REaWZmZXJlbmNlID0gbmV3UGN0IC0gcHJldlBjdDtcclxuXHJcblx0XHRcdFx0c3RlcHMgPSBwY3REaWZmZXJlbmNlIC8gZGVuc2l0eTtcclxuXHRcdFx0XHRyZWFsU3RlcHMgPSBNYXRoLnJvdW5kKHN0ZXBzKTtcclxuXHJcblx0XHRcdFx0Ly8gVGhpcyByYXRpbyByZXByZXNlbnRzIHRoZSBhbW91bnQgb2YgcGVyY2VudGFnZS1zcGFjZSBhIHBvaW50IGluZGljYXRlcy5cclxuXHRcdFx0XHQvLyBGb3IgYSBkZW5zaXR5IDEgdGhlIHBvaW50cy9wZXJjZW50YWdlID0gMS4gRm9yIGRlbnNpdHkgMiwgdGhhdCBwZXJjZW50YWdlIG5lZWRzIHRvIGJlIHJlLWRldmlkZWQuXHJcblx0XHRcdFx0Ly8gUm91bmQgdGhlIHBlcmNlbnRhZ2Ugb2Zmc2V0IHRvIGFuIGV2ZW4gbnVtYmVyLCB0aGVuIGRpdmlkZSBieSB0d29cclxuXHRcdFx0XHQvLyB0byBzcHJlYWQgdGhlIG9mZnNldCBvbiBib3RoIHNpZGVzIG9mIHRoZSByYW5nZS5cclxuXHRcdFx0XHRzdGVwc2l6ZSA9IHBjdERpZmZlcmVuY2UvcmVhbFN0ZXBzO1xyXG5cclxuXHRcdFx0XHQvLyBEaXZpZGUgYWxsIHBvaW50cyBldmVubHksIGFkZGluZyB0aGUgY29ycmVjdCBudW1iZXIgdG8gdGhpcyBzdWJyYW5nZS5cclxuXHRcdFx0XHQvLyBSdW4gdXAgdG8gPD0gc28gdGhhdCAxMDAlIGdldHMgYSBwb2ludCwgZXZlbnQgaWYgaWdub3JlTGFzdCBpcyBzZXQuXHJcblx0XHRcdFx0Zm9yICggcSA9IDE7IHEgPD0gcmVhbFN0ZXBzOyBxICs9IDEgKSB7XHJcblxyXG5cdFx0XHRcdFx0Ly8gVGhlIHJhdGlvIGJldHdlZW4gdGhlIHJvdW5kZWQgdmFsdWUgYW5kIHRoZSBhY3R1YWwgc2l6ZSBtaWdodCBiZSB+MSUgb2ZmLlxyXG5cdFx0XHRcdFx0Ly8gQ29ycmVjdCB0aGUgcGVyY2VudGFnZSBvZmZzZXQgYnkgdGhlIG51bWJlciBvZiBwb2ludHNcclxuXHRcdFx0XHRcdC8vIHBlciBzdWJyYW5nZS4gZGVuc2l0eSA9IDEgd2lsbCByZXN1bHQgaW4gMTAwIHBvaW50cyBvbiB0aGVcclxuXHRcdFx0XHRcdC8vIGZ1bGwgcmFuZ2UsIDIgZm9yIDUwLCA0IGZvciAyNSwgZXRjLlxyXG5cdFx0XHRcdFx0cGN0UG9zID0gcHJldlBjdCArICggcSAqIHN0ZXBzaXplICk7XHJcblx0XHRcdFx0XHRpbmRleGVzW3BjdFBvcy50b0ZpeGVkKDUpXSA9IFsneCcsIDBdO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gRGV0ZXJtaW5lIHRoZSBwb2ludCB0eXBlLlxyXG5cdFx0XHRcdHR5cGUgPSAoZ3JvdXAuaW5kZXhPZihpKSA+IC0xKSA/IDEgOiAoIG1vZGUgPT09ICdzdGVwcycgPyAyIDogMCApO1xyXG5cclxuXHRcdFx0XHQvLyBFbmZvcmNlIHRoZSAnaWdub3JlRmlyc3QnIG9wdGlvbiBieSBvdmVyd3JpdGluZyB0aGUgdHlwZSBmb3IgMC5cclxuXHRcdFx0XHRpZiAoICFpbmRleCAmJiBpZ25vcmVGaXJzdCApIHtcclxuXHRcdFx0XHRcdHR5cGUgPSAwO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0aWYgKCAhKGkgPT09IGhpZ2ggJiYgaWdub3JlTGFzdCkpIHtcclxuXHRcdFx0XHRcdC8vIE1hcmsgdGhlICd0eXBlJyBvZiB0aGlzIHBvaW50LiAwID0gcGxhaW4sIDEgPSByZWFsIHZhbHVlLCAyID0gc3RlcCB2YWx1ZS5cclxuXHRcdFx0XHRcdGluZGV4ZXNbbmV3UGN0LnRvRml4ZWQoNSldID0gW2ksIHR5cGVdO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0Ly8gVXBkYXRlIHRoZSBwZXJjZW50YWdlIGNvdW50LlxyXG5cdFx0XHRcdHByZXZQY3QgPSBuZXdQY3Q7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cclxuXHRcdHJldHVybiBpbmRleGVzO1xyXG5cdH1cclxuXHJcblx0ZnVuY3Rpb24gYWRkTWFya2luZyAoIHNwcmVhZCwgZmlsdGVyRnVuYywgZm9ybWF0dGVyICkge1xyXG5cclxuXHRcdHZhciBlbGVtZW50ID0gc2NvcGVfRG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XHJcblxyXG5cdFx0dmFyIHZhbHVlU2l6ZUNsYXNzZXMgPSBbXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZU5vcm1hbCxcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLnZhbHVlTGFyZ2UsXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZVN1YlxyXG5cdFx0XTtcclxuXHRcdHZhciBtYXJrZXJTaXplQ2xhc3NlcyA9IFtcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlck5vcm1hbCxcclxuXHRcdFx0b3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlckxhcmdlLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyU3ViXHJcblx0XHRdO1xyXG5cdFx0dmFyIHZhbHVlT3JpZW50YXRpb25DbGFzc2VzID0gW1xyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMudmFsdWVIb3Jpem9udGFsLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMudmFsdWVWZXJ0aWNhbFxyXG5cdFx0XTtcclxuXHRcdHZhciBtYXJrZXJPcmllbnRhdGlvbkNsYXNzZXMgPSBbXHJcblx0XHRcdG9wdGlvbnMuY3NzQ2xhc3Nlcy5tYXJrZXJIb3Jpem9udGFsLFxyXG5cdFx0XHRvcHRpb25zLmNzc0NsYXNzZXMubWFya2VyVmVydGljYWxcclxuXHRcdF07XHJcblxyXG5cdFx0YWRkQ2xhc3MoZWxlbWVudCwgb3B0aW9ucy5jc3NDbGFzc2VzLnBpcHMpO1xyXG5cdFx0YWRkQ2xhc3MoZWxlbWVudCwgb3B0aW9ucy5vcnQgPT09IDAgPyBvcHRpb25zLmNzc0NsYXNzZXMucGlwc0hvcml6b250YWwgOiBvcHRpb25zLmNzc0NsYXNzZXMucGlwc1ZlcnRpY2FsKTtcclxuXHJcblx0XHRmdW5jdGlvbiBnZXRDbGFzc2VzKCB0eXBlLCBzb3VyY2UgKXtcclxuXHRcdFx0dmFyIGEgPSBzb3VyY2UgPT09IG9wdGlvbnMuY3NzQ2xhc3Nlcy52YWx1ZTtcclxuXHRcdFx0dmFyIG9yaWVudGF0aW9uQ2xhc3NlcyA9IGEgPyB2YWx1ZU9yaWVudGF0aW9uQ2xhc3NlcyA6IG1hcmtlck9yaWVudGF0aW9uQ2xhc3NlcztcclxuXHRcdFx0dmFyIHNpemVDbGFzc2VzID0gYSA/IHZhbHVlU2l6ZUNsYXNzZXMgOiBtYXJrZXJTaXplQ2xhc3NlcztcclxuXHJcblx0XHRcdHJldHVybiBzb3VyY2UgKyAnICcgKyBvcmllbnRhdGlvbkNsYXNzZXNbb3B0aW9ucy5vcnRdICsgJyAnICsgc2l6ZUNsYXNzZXNbdHlwZV07XHJcblx0XHR9XHJcblxyXG5cdFx0ZnVuY3Rpb24gYWRkU3ByZWFkICggb2Zmc2V0LCB2YWx1ZXMgKXtcclxuXHJcblx0XHRcdC8vIEFwcGx5IHRoZSBmaWx0ZXIgZnVuY3Rpb24sIGlmIGl0IGlzIHNldC5cclxuXHRcdFx0dmFsdWVzWzFdID0gKHZhbHVlc1sxXSAmJiBmaWx0ZXJGdW5jKSA/IGZpbHRlckZ1bmModmFsdWVzWzBdLCB2YWx1ZXNbMV0pIDogdmFsdWVzWzFdO1xyXG5cclxuXHRcdFx0Ly8gQWRkIGEgbWFya2VyIGZvciBldmVyeSBwb2ludFxyXG5cdFx0XHR2YXIgbm9kZSA9IGFkZE5vZGVUbyhlbGVtZW50LCBmYWxzZSk7XHJcblx0XHRcdFx0bm9kZS5jbGFzc05hbWUgPSBnZXRDbGFzc2VzKHZhbHVlc1sxXSwgb3B0aW9ucy5jc3NDbGFzc2VzLm1hcmtlcik7XHJcblx0XHRcdFx0bm9kZS5zdHlsZVtvcHRpb25zLnN0eWxlXSA9IG9mZnNldCArICclJztcclxuXHJcblx0XHRcdC8vIFZhbHVlcyBhcmUgb25seSBhcHBlbmRlZCBmb3IgcG9pbnRzIG1hcmtlZCAnMScgb3IgJzInLlxyXG5cdFx0XHRpZiAoIHZhbHVlc1sxXSApIHtcclxuXHRcdFx0XHRub2RlID0gYWRkTm9kZVRvKGVsZW1lbnQsIGZhbHNlKTtcclxuXHRcdFx0XHRub2RlLmNsYXNzTmFtZSA9IGdldENsYXNzZXModmFsdWVzWzFdLCBvcHRpb25zLmNzc0NsYXNzZXMudmFsdWUpO1xyXG5cdFx0XHRcdG5vZGUuc2V0QXR0cmlidXRlKCdkYXRhLXZhbHVlJywgdmFsdWVzWzBdKTtcclxuXHRcdFx0XHRub2RlLnN0eWxlW29wdGlvbnMuc3R5bGVdID0gb2Zmc2V0ICsgJyUnO1xyXG5cdFx0XHRcdG5vZGUuaW5uZXJUZXh0ID0gZm9ybWF0dGVyLnRvKHZhbHVlc1swXSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBBcHBlbmQgYWxsIHBvaW50cy5cclxuXHRcdE9iamVjdC5rZXlzKHNwcmVhZCkuZm9yRWFjaChmdW5jdGlvbihhKXtcclxuXHRcdFx0YWRkU3ByZWFkKGEsIHNwcmVhZFthXSk7XHJcblx0XHR9KTtcclxuXHJcblx0XHRyZXR1cm4gZWxlbWVudDtcclxuXHR9XHJcblxyXG5cdGZ1bmN0aW9uIHJlbW92ZVBpcHMgKCApIHtcclxuXHRcdGlmICggc2NvcGVfUGlwcyApIHtcclxuXHRcdFx0cmVtb3ZlRWxlbWVudChzY29wZV9QaXBzKTtcclxuXHRcdFx0c2NvcGVfUGlwcyA9IG51bGw7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHRmdW5jdGlvbiBwaXBzICggZ3JpZCApIHtcclxuXHJcblx0XHQvLyBGaXggIzY2OVxyXG5cdFx0cmVtb3ZlUGlwcygpO1xyXG5cclxuXHRcdHZhciBtb2RlID0gZ3JpZC5tb2RlO1xyXG5cdFx0dmFyIGRlbnNpdHkgPSBncmlkLmRlbnNpdHkgfHwgMTtcclxuXHRcdHZhciBmaWx0ZXIgPSBncmlkLmZpbHRlciB8fCBmYWxzZTtcclxuXHRcdHZhciB2YWx1ZXMgPSBncmlkLnZhbHVlcyB8fCBmYWxzZTtcclxuXHRcdHZhciBzdGVwcGVkID0gZ3JpZC5zdGVwcGVkIHx8IGZhbHNlO1xyXG5cdFx0dmFyIGdyb3VwID0gZ2V0R3JvdXAoIG1vZGUsIHZhbHVlcywgc3RlcHBlZCApO1xyXG5cdFx0dmFyIHNwcmVhZCA9IGdlbmVyYXRlU3ByZWFkKCBkZW5zaXR5LCBtb2RlLCBncm91cCApO1xyXG5cdFx0dmFyIGZvcm1hdCA9IGdyaWQuZm9ybWF0IHx8IHtcclxuXHRcdFx0dG86IE1hdGgucm91bmRcclxuXHRcdH07XHJcblxyXG5cdFx0c2NvcGVfUGlwcyA9IHNjb3BlX1RhcmdldC5hcHBlbmRDaGlsZChhZGRNYXJraW5nKFxyXG5cdFx0XHRzcHJlYWQsXHJcblx0XHRcdGZpbHRlcixcclxuXHRcdFx0Zm9ybWF0XHJcblx0XHQpKTtcclxuXHJcblx0XHRyZXR1cm4gc2NvcGVfUGlwcztcclxuXHR9XHJcblxyXG4vKiEgSW4gdGhpcyBmaWxlOiBCcm93c2VyIGV2ZW50cyAobm90IHNsaWRlciBldmVudHMgbGlrZSBzbGlkZSwgY2hhbmdlKTsgKi9cclxuXHJcblx0Ly8gU2hvcnRoYW5kIGZvciBiYXNlIGRpbWVuc2lvbnMuXHJcblx0ZnVuY3Rpb24gYmFzZVNpemUgKCApIHtcclxuXHRcdHZhciByZWN0ID0gc2NvcGVfQmFzZS5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTtcclxuXHRcdHZhciBhbHQgPSAnb2Zmc2V0JyArIFsnV2lkdGgnLCAnSGVpZ2h0J11bb3B0aW9ucy5vcnRdO1xyXG5cdFx0cmV0dXJuIG9wdGlvbnMub3J0ID09PSAwID8gKHJlY3Qud2lkdGh8fHNjb3BlX0Jhc2VbYWx0XSkgOiAocmVjdC5oZWlnaHR8fHNjb3BlX0Jhc2VbYWx0XSk7XHJcblx0fVxyXG5cclxuXHQvLyBIYW5kbGVyIGZvciBhdHRhY2hpbmcgZXZlbnRzIHRyb3VnaCBhIHByb3h5LlxyXG5cdGZ1bmN0aW9uIGF0dGFjaEV2ZW50ICggZXZlbnRzLCBlbGVtZW50LCBjYWxsYmFjaywgZGF0YSApIHtcclxuXHJcblx0XHQvLyBUaGlzIGZ1bmN0aW9uIGNhbiBiZSB1c2VkIHRvICdmaWx0ZXInIGV2ZW50cyB0byB0aGUgc2xpZGVyLlxyXG5cdFx0Ly8gZWxlbWVudCBpcyBhIG5vZGUsIG5vdCBhIG5vZGVMaXN0XHJcblxyXG5cdFx0dmFyIG1ldGhvZCA9IGZ1bmN0aW9uICggZSApe1xyXG5cclxuXHRcdFx0ZSA9IGZpeEV2ZW50KGUsIGRhdGEucGFnZU9mZnNldCwgZGF0YS50YXJnZXQgfHwgZWxlbWVudCk7XHJcblxyXG5cdFx0XHQvLyBmaXhFdmVudCByZXR1cm5zIGZhbHNlIGlmIHRoaXMgZXZlbnQgaGFzIGEgZGlmZmVyZW50IHRhcmdldFxyXG5cdFx0XHQvLyB3aGVuIGhhbmRsaW5nIChtdWx0aS0pIHRvdWNoIGV2ZW50cztcclxuXHRcdFx0aWYgKCAhZSApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIGRvTm90UmVqZWN0IGlzIHBhc3NlZCBieSBhbGwgZW5kIGV2ZW50cyB0byBtYWtlIHN1cmUgcmVsZWFzZWQgdG91Y2hlc1xyXG5cdFx0XHQvLyBhcmUgbm90IHJlamVjdGVkLCBsZWF2aW5nIHRoZSBzbGlkZXIgXCJzdHVja1wiIHRvIHRoZSBjdXJzb3I7XHJcblx0XHRcdGlmICggc2NvcGVfVGFyZ2V0Lmhhc0F0dHJpYnV0ZSgnZGlzYWJsZWQnKSAmJiAhZGF0YS5kb05vdFJlamVjdCApIHtcclxuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdC8vIFN0b3AgaWYgYW4gYWN0aXZlICd0YXAnIHRyYW5zaXRpb24gaXMgdGFraW5nIHBsYWNlLlxyXG5cdFx0XHRpZiAoIGhhc0NsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLnRhcCkgJiYgIWRhdGEuZG9Ob3RSZWplY3QgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBJZ25vcmUgcmlnaHQgb3IgbWlkZGxlIGNsaWNrcyBvbiBzdGFydCAjNDU0XHJcblx0XHRcdGlmICggZXZlbnRzID09PSBhY3Rpb25zLnN0YXJ0ICYmIGUuYnV0dG9ucyAhPT0gdW5kZWZpbmVkICYmIGUuYnV0dG9ucyA+IDEgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBJZ25vcmUgcmlnaHQgb3IgbWlkZGxlIGNsaWNrcyBvbiBzdGFydCAjNDU0XHJcblx0XHRcdGlmICggZGF0YS5ob3ZlciAmJiBlLmJ1dHRvbnMgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyAnc3VwcG9ydHNQYXNzaXZlJyBpcyBvbmx5IHRydWUgaWYgYSBicm93c2VyIGFsc28gc3VwcG9ydHMgdG91Y2gtYWN0aW9uOiBub25lIGluIENTUy5cclxuXHRcdFx0Ly8gaU9TIHNhZmFyaSBkb2VzIG5vdCwgc28gaXQgZG9lc24ndCBnZXQgdG8gYmVuZWZpdCBmcm9tIHBhc3NpdmUgc2Nyb2xsaW5nLiBpT1MgZG9lcyBzdXBwb3J0XHJcblx0XHRcdC8vIHRvdWNoLWFjdGlvbjogbWFuaXB1bGF0aW9uLCBidXQgdGhhdCBhbGxvd3MgcGFubmluZywgd2hpY2ggYnJlYWtzXHJcblx0XHRcdC8vIHNsaWRlcnMgYWZ0ZXIgem9vbWluZy9vbiBub24tcmVzcG9uc2l2ZSBwYWdlcy5cclxuXHRcdFx0Ly8gU2VlOiBodHRwczovL2J1Z3Mud2Via2l0Lm9yZy9zaG93X2J1Zy5jZ2k/aWQ9MTMzMTEyXHJcblx0XHRcdGlmICggIXN1cHBvcnRzUGFzc2l2ZSApIHtcclxuXHRcdFx0XHRlLnByZXZlbnREZWZhdWx0KCk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGUuY2FsY1BvaW50ID0gZS5wb2ludHNbIG9wdGlvbnMub3J0IF07XHJcblxyXG5cdFx0XHQvLyBDYWxsIHRoZSBldmVudCBoYW5kbGVyIHdpdGggdGhlIGV2ZW50IFsgYW5kIGFkZGl0aW9uYWwgZGF0YSBdLlxyXG5cdFx0XHRjYWxsYmFjayAoIGUsIGRhdGEgKTtcclxuXHRcdH07XHJcblxyXG5cdFx0dmFyIG1ldGhvZHMgPSBbXTtcclxuXHJcblx0XHQvLyBCaW5kIGEgY2xvc3VyZSBvbiB0aGUgdGFyZ2V0IGZvciBldmVyeSBldmVudCB0eXBlLlxyXG5cdFx0ZXZlbnRzLnNwbGl0KCcgJykuZm9yRWFjaChmdW5jdGlvbiggZXZlbnROYW1lICl7XHJcblx0XHRcdGVsZW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihldmVudE5hbWUsIG1ldGhvZCwgc3VwcG9ydHNQYXNzaXZlID8geyBwYXNzaXZlOiB0cnVlIH0gOiBmYWxzZSk7XHJcblx0XHRcdG1ldGhvZHMucHVzaChbZXZlbnROYW1lLCBtZXRob2RdKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdHJldHVybiBtZXRob2RzO1xyXG5cdH1cclxuXHJcblx0Ly8gUHJvdmlkZSBhIGNsZWFuIGV2ZW50IHdpdGggc3RhbmRhcmRpemVkIG9mZnNldCB2YWx1ZXMuXHJcblx0ZnVuY3Rpb24gZml4RXZlbnQgKCBlLCBwYWdlT2Zmc2V0LCBldmVudFRhcmdldCApIHtcclxuXHJcblx0XHQvLyBGaWx0ZXIgdGhlIGV2ZW50IHRvIHJlZ2lzdGVyIHRoZSB0eXBlLCB3aGljaCBjYW4gYmVcclxuXHRcdC8vIHRvdWNoLCBtb3VzZSBvciBwb2ludGVyLiBPZmZzZXQgY2hhbmdlcyBuZWVkIHRvIGJlXHJcblx0XHQvLyBtYWRlIG9uIGFuIGV2ZW50IHNwZWNpZmljIGJhc2lzLlxyXG5cdFx0dmFyIHRvdWNoID0gZS50eXBlLmluZGV4T2YoJ3RvdWNoJykgPT09IDA7XHJcblx0XHR2YXIgbW91c2UgPSBlLnR5cGUuaW5kZXhPZignbW91c2UnKSA9PT0gMDtcclxuXHRcdHZhciBwb2ludGVyID0gZS50eXBlLmluZGV4T2YoJ3BvaW50ZXInKSA9PT0gMDtcclxuXHJcblx0XHR2YXIgeDtcclxuXHRcdHZhciB5O1xyXG5cclxuXHRcdC8vIElFMTAgaW1wbGVtZW50ZWQgcG9pbnRlciBldmVudHMgd2l0aCBhIHByZWZpeDtcclxuXHRcdGlmICggZS50eXBlLmluZGV4T2YoJ01TUG9pbnRlcicpID09PSAwICkge1xyXG5cdFx0XHRwb2ludGVyID0gdHJ1ZTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJbiB0aGUgZXZlbnQgdGhhdCBtdWx0aXRvdWNoIGlzIGFjdGl2YXRlZCwgdGhlIG9ubHkgdGhpbmcgb25lIGhhbmRsZSBzaG91bGQgYmUgY29uY2VybmVkXHJcblx0XHQvLyBhYm91dCBpcyB0aGUgdG91Y2hlcyB0aGF0IG9yaWdpbmF0ZWQgb24gdG9wIG9mIGl0LlxyXG5cdFx0aWYgKCB0b3VjaCApIHtcclxuXHJcblx0XHRcdC8vIFJldHVybnMgdHJ1ZSBpZiBhIHRvdWNoIG9yaWdpbmF0ZWQgb24gdGhlIHRhcmdldC5cclxuXHRcdFx0dmFyIGlzVG91Y2hPblRhcmdldCA9IGZ1bmN0aW9uIChjaGVja1RvdWNoKSB7XHJcblx0XHRcdFx0cmV0dXJuIGNoZWNrVG91Y2gudGFyZ2V0ID09PSBldmVudFRhcmdldCB8fCBldmVudFRhcmdldC5jb250YWlucyhjaGVja1RvdWNoLnRhcmdldCk7XHJcblx0XHRcdH07XHJcblxyXG5cdFx0XHQvLyBJbiB0aGUgY2FzZSBvZiB0b3VjaHN0YXJ0IGV2ZW50cywgd2UgbmVlZCB0byBtYWtlIHN1cmUgdGhlcmUgaXMgc3RpbGwgbm8gbW9yZSB0aGFuIG9uZVxyXG5cdFx0XHQvLyB0b3VjaCBvbiB0aGUgdGFyZ2V0IHNvIHdlIGxvb2sgYW1vbmdzdCBhbGwgdG91Y2hlcy5cclxuXHRcdFx0aWYgKGUudHlwZSA9PT0gJ3RvdWNoc3RhcnQnKSB7XHJcblxyXG5cdFx0XHRcdHZhciB0YXJnZXRUb3VjaGVzID0gQXJyYXkucHJvdG90eXBlLmZpbHRlci5jYWxsKGUudG91Y2hlcywgaXNUb3VjaE9uVGFyZ2V0KTtcclxuXHJcblx0XHRcdFx0Ly8gRG8gbm90IHN1cHBvcnQgbW9yZSB0aGFuIG9uZSB0b3VjaCBwZXIgaGFuZGxlLlxyXG5cdFx0XHRcdGlmICggdGFyZ2V0VG91Y2hlcy5sZW5ndGggPiAxICkge1xyXG5cdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0eCA9IHRhcmdldFRvdWNoZXNbMF0ucGFnZVg7XHJcblx0XHRcdFx0eSA9IHRhcmdldFRvdWNoZXNbMF0ucGFnZVk7XHJcblxyXG5cdFx0XHR9IGVsc2Uge1xyXG5cclxuXHRcdFx0XHQvLyBJbiB0aGUgb3RoZXIgY2FzZXMsIGZpbmQgb24gY2hhbmdlZFRvdWNoZXMgaXMgZW5vdWdoLlxyXG5cdFx0XHRcdHZhciB0YXJnZXRUb3VjaCA9IEFycmF5LnByb3RvdHlwZS5maW5kLmNhbGwoZS5jaGFuZ2VkVG91Y2hlcywgaXNUb3VjaE9uVGFyZ2V0KTtcclxuXHJcblx0XHRcdFx0Ly8gQ2FuY2VsIGlmIHRoZSB0YXJnZXQgdG91Y2ggaGFzIG5vdCBtb3ZlZC5cclxuXHRcdFx0XHRpZiAoICF0YXJnZXRUb3VjaCApIHtcclxuXHRcdFx0XHRcdHJldHVybiBmYWxzZTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdHggPSB0YXJnZXRUb3VjaC5wYWdlWDtcclxuXHRcdFx0XHR5ID0gdGFyZ2V0VG91Y2gucGFnZVk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHRwYWdlT2Zmc2V0ID0gcGFnZU9mZnNldCB8fCBnZXRQYWdlT2Zmc2V0KHNjb3BlX0RvY3VtZW50KTtcclxuXHJcblx0XHRpZiAoIG1vdXNlIHx8IHBvaW50ZXIgKSB7XHJcblx0XHRcdHggPSBlLmNsaWVudFggKyBwYWdlT2Zmc2V0Lng7XHJcblx0XHRcdHkgPSBlLmNsaWVudFkgKyBwYWdlT2Zmc2V0Lnk7XHJcblx0XHR9XHJcblxyXG5cdFx0ZS5wYWdlT2Zmc2V0ID0gcGFnZU9mZnNldDtcclxuXHRcdGUucG9pbnRzID0gW3gsIHldO1xyXG5cdFx0ZS5jdXJzb3IgPSBtb3VzZSB8fCBwb2ludGVyOyAvLyBGaXggIzQzNVxyXG5cclxuXHRcdHJldHVybiBlO1xyXG5cdH1cclxuXHJcblx0Ly8gVHJhbnNsYXRlIGEgY29vcmRpbmF0ZSBpbiB0aGUgZG9jdW1lbnQgdG8gYSBwZXJjZW50YWdlIG9uIHRoZSBzbGlkZXJcclxuXHRmdW5jdGlvbiBjYWxjUG9pbnRUb1BlcmNlbnRhZ2UgKCBjYWxjUG9pbnQgKSB7XHJcblx0XHR2YXIgbG9jYXRpb24gPSBjYWxjUG9pbnQgLSBvZmZzZXQoc2NvcGVfQmFzZSwgb3B0aW9ucy5vcnQpO1xyXG5cdFx0dmFyIHByb3Bvc2FsID0gKCBsb2NhdGlvbiAqIDEwMCApIC8gYmFzZVNpemUoKTtcclxuXHJcblx0XHQvLyBDbGFtcCBwcm9wb3NhbCBiZXR3ZWVuIDAlIGFuZCAxMDAlXHJcblx0XHQvLyBPdXQtb2YtYm91bmQgY29vcmRpbmF0ZXMgbWF5IG9jY3VyIHdoZW4gLm5vVWktYmFzZSBwc2V1ZG8tZWxlbWVudHNcclxuXHRcdC8vIGFyZSB1c2VkIChlLmcuIGNvbnRhaW5lZCBoYW5kbGVzIGZlYXR1cmUpXHJcblx0XHRwcm9wb3NhbCA9IGxpbWl0KHByb3Bvc2FsKTtcclxuXHJcblx0XHRyZXR1cm4gb3B0aW9ucy5kaXIgPyAxMDAgLSBwcm9wb3NhbCA6IHByb3Bvc2FsO1xyXG5cdH1cclxuXHJcblx0Ly8gRmluZCBoYW5kbGUgY2xvc2VzdCB0byBhIGNlcnRhaW4gcGVyY2VudGFnZSBvbiB0aGUgc2xpZGVyXHJcblx0ZnVuY3Rpb24gZ2V0Q2xvc2VzdEhhbmRsZSAoIHByb3Bvc2FsICkge1xyXG5cclxuXHRcdHZhciBjbG9zZXN0ID0gMTAwO1xyXG5cdFx0dmFyIGhhbmRsZU51bWJlciA9IGZhbHNlO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZXMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGUsIGluZGV4KXtcclxuXHJcblx0XHRcdC8vIERpc2FibGVkIGhhbmRsZXMgYXJlIGlnbm9yZWRcclxuXHRcdFx0aWYgKCBoYW5kbGUuaGFzQXR0cmlidXRlKCdkaXNhYmxlZCcpICkge1xyXG5cdFx0XHRcdHJldHVybjtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0dmFyIHBvcyA9IE1hdGguYWJzKHNjb3BlX0xvY2F0aW9uc1tpbmRleF0gLSBwcm9wb3NhbCk7XHJcblxyXG5cdFx0XHRpZiAoIHBvcyA8IGNsb3Nlc3QgfHwgKHBvcyA9PT0gMTAwICYmIGNsb3Nlc3QgPT09IDEwMCkgKSB7XHJcblx0XHRcdFx0aGFuZGxlTnVtYmVyID0gaW5kZXg7XHJcblx0XHRcdFx0Y2xvc2VzdCA9IHBvcztcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0cmV0dXJuIGhhbmRsZU51bWJlcjtcclxuXHR9XHJcblxyXG5cdC8vIEZpcmUgJ2VuZCcgd2hlbiBhIG1vdXNlIG9yIHBlbiBsZWF2ZXMgdGhlIGRvY3VtZW50LlxyXG5cdGZ1bmN0aW9uIGRvY3VtZW50TGVhdmUgKCBldmVudCwgZGF0YSApIHtcclxuXHRcdGlmICggZXZlbnQudHlwZSA9PT0gXCJtb3VzZW91dFwiICYmIGV2ZW50LnRhcmdldC5ub2RlTmFtZSA9PT0gXCJIVE1MXCIgJiYgZXZlbnQucmVsYXRlZFRhcmdldCA9PT0gbnVsbCApe1xyXG5cdFx0XHRldmVudEVuZCAoZXZlbnQsIGRhdGEpO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcblx0Ly8gSGFuZGxlIG1vdmVtZW50IG9uIGRvY3VtZW50IGZvciBoYW5kbGUgYW5kIHJhbmdlIGRyYWcuXHJcblx0ZnVuY3Rpb24gZXZlbnRNb3ZlICggZXZlbnQsIGRhdGEgKSB7XHJcblxyXG5cdFx0Ly8gRml4ICM0OThcclxuXHRcdC8vIENoZWNrIHZhbHVlIG9mIC5idXR0b25zIGluICdzdGFydCcgdG8gd29yayBhcm91bmQgYSBidWcgaW4gSUUxMCBtb2JpbGUgKGRhdGEuYnV0dG9uc1Byb3BlcnR5KS5cclxuXHRcdC8vIGh0dHBzOi8vY29ubmVjdC5taWNyb3NvZnQuY29tL0lFL2ZlZWRiYWNrL2RldGFpbHMvOTI3MDA1L21vYmlsZS1pZTEwLXdpbmRvd3MtcGhvbmUtYnV0dG9ucy1wcm9wZXJ0eS1vZi1wb2ludGVybW92ZS1ldmVudC1hbHdheXMtemVyb1xyXG5cdFx0Ly8gSUU5IGhhcyAuYnV0dG9ucyBhbmQgLndoaWNoIHplcm8gb24gbW91c2Vtb3ZlLlxyXG5cdFx0Ly8gRmlyZWZveCBicmVha3MgdGhlIHNwZWMgTUROIGRlZmluZXMuXHJcblx0XHRpZiAoIG5hdmlnYXRvci5hcHBWZXJzaW9uLmluZGV4T2YoXCJNU0lFIDlcIikgPT09IC0xICYmIGV2ZW50LmJ1dHRvbnMgPT09IDAgJiYgZGF0YS5idXR0b25zUHJvcGVydHkgIT09IDAgKSB7XHJcblx0XHRcdHJldHVybiBldmVudEVuZChldmVudCwgZGF0YSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQ2hlY2sgaWYgd2UgYXJlIG1vdmluZyB1cCBvciBkb3duXHJcblx0XHR2YXIgbW92ZW1lbnQgPSAob3B0aW9ucy5kaXIgPyAtMSA6IDEpICogKGV2ZW50LmNhbGNQb2ludCAtIGRhdGEuc3RhcnRDYWxjUG9pbnQpO1xyXG5cclxuXHRcdC8vIENvbnZlcnQgdGhlIG1vdmVtZW50IGludG8gYSBwZXJjZW50YWdlIG9mIHRoZSBzbGlkZXIgd2lkdGgvaGVpZ2h0XHJcblx0XHR2YXIgcHJvcG9zYWwgPSAobW92ZW1lbnQgKiAxMDApIC8gZGF0YS5iYXNlU2l6ZTtcclxuXHJcblx0XHRtb3ZlSGFuZGxlcyhtb3ZlbWVudCA+IDAsIHByb3Bvc2FsLCBkYXRhLmxvY2F0aW9ucywgZGF0YS5oYW5kbGVOdW1iZXJzKTtcclxuXHR9XHJcblxyXG5cdC8vIFVuYmluZCBtb3ZlIGV2ZW50cyBvbiBkb2N1bWVudCwgY2FsbCBjYWxsYmFja3MuXHJcblx0ZnVuY3Rpb24gZXZlbnRFbmQgKCBldmVudCwgZGF0YSApIHtcclxuXHJcblx0XHQvLyBUaGUgaGFuZGxlIGlzIG5vIGxvbmdlciBhY3RpdmUsIHNvIHJlbW92ZSB0aGUgY2xhc3MuXHJcblx0XHRpZiAoIGRhdGEuaGFuZGxlICkge1xyXG5cdFx0XHRyZW1vdmVDbGFzcyhkYXRhLmhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmFjdGl2ZSk7XHJcblx0XHRcdHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCAtPSAxO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFVuYmluZCB0aGUgbW92ZSBhbmQgZW5kIGV2ZW50cywgd2hpY2ggYXJlIGFkZGVkIG9uICdzdGFydCcuXHJcblx0XHRkYXRhLmxpc3RlbmVycy5mb3JFYWNoKGZ1bmN0aW9uKCBjICkge1xyXG5cdFx0XHRzY29wZV9Eb2N1bWVudEVsZW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcihjWzBdLCBjWzFdKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdGlmICggc2NvcGVfQWN0aXZlSGFuZGxlc0NvdW50ID09PSAwICkge1xyXG5cdFx0XHQvLyBSZW1vdmUgZHJhZ2dpbmcgY2xhc3MuXHJcblx0XHRcdHJlbW92ZUNsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzLmRyYWcpO1xyXG5cdFx0XHRzZXRaaW5kZXgoKTtcclxuXHJcblx0XHRcdC8vIFJlbW92ZSBjdXJzb3Igc3R5bGVzIGFuZCB0ZXh0LXNlbGVjdGlvbiBldmVudHMgYm91bmQgdG8gdGhlIGJvZHkuXHJcblx0XHRcdGlmICggZXZlbnQuY3Vyc29yICkge1xyXG5cdFx0XHRcdHNjb3BlX0JvZHkuc3R5bGUuY3Vyc29yID0gJyc7XHJcblx0XHRcdFx0c2NvcGVfQm9keS5yZW1vdmVFdmVudExpc3RlbmVyKCdzZWxlY3RzdGFydCcsIHByZXZlbnREZWZhdWx0KTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cclxuXHRcdGRhdGEuaGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdGZpcmVFdmVudCgnY2hhbmdlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0ZmlyZUV2ZW50KCdzZXQnLCBoYW5kbGVOdW1iZXIpO1xyXG5cdFx0XHRmaXJlRXZlbnQoJ2VuZCcsIGhhbmRsZU51bWJlcik7XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cdC8vIEJpbmQgbW92ZSBldmVudHMgb24gZG9jdW1lbnQuXHJcblx0ZnVuY3Rpb24gZXZlbnRTdGFydCAoIGV2ZW50LCBkYXRhICkge1xyXG5cclxuXHRcdHZhciBoYW5kbGU7XHJcblx0XHRpZiAoIGRhdGEuaGFuZGxlTnVtYmVycy5sZW5ndGggPT09IDEgKSB7XHJcblxyXG5cdFx0XHR2YXIgaGFuZGxlT3JpZ2luID0gc2NvcGVfSGFuZGxlc1tkYXRhLmhhbmRsZU51bWJlcnNbMF1dO1xyXG5cclxuXHRcdFx0Ly8gSWdub3JlICdkaXNhYmxlZCcgaGFuZGxlc1xyXG5cdFx0XHRpZiAoIGhhbmRsZU9yaWdpbi5oYXNBdHRyaWJ1dGUoJ2Rpc2FibGVkJykgKSB7XHJcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRoYW5kbGUgPSBoYW5kbGVPcmlnaW4uY2hpbGRyZW5bMF07XHJcblx0XHRcdHNjb3BlX0FjdGl2ZUhhbmRsZXNDb3VudCArPSAxO1xyXG5cclxuXHRcdFx0Ly8gTWFyayB0aGUgaGFuZGxlIGFzICdhY3RpdmUnIHNvIGl0IGNhbiBiZSBzdHlsZWQuXHJcblx0XHRcdGFkZENsYXNzKGhhbmRsZSwgb3B0aW9ucy5jc3NDbGFzc2VzLmFjdGl2ZSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gQSBkcmFnIHNob3VsZCBuZXZlciBwcm9wYWdhdGUgdXAgdG8gdGhlICd0YXAnIGV2ZW50LlxyXG5cdFx0ZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XHJcblxyXG5cdFx0Ly8gUmVjb3JkIHRoZSBldmVudCBsaXN0ZW5lcnMuXHJcblx0XHR2YXIgbGlzdGVuZXJzID0gW107XHJcblxyXG5cdFx0Ly8gQXR0YWNoIHRoZSBtb3ZlIGFuZCBlbmQgZXZlbnRzLlxyXG5cdFx0dmFyIG1vdmVFdmVudCA9IGF0dGFjaEV2ZW50KGFjdGlvbnMubW92ZSwgc2NvcGVfRG9jdW1lbnRFbGVtZW50LCBldmVudE1vdmUsIHtcclxuXHRcdFx0Ly8gVGhlIGV2ZW50IHRhcmdldCBoYXMgY2hhbmdlZCBzbyB3ZSBuZWVkIHRvIHByb3BhZ2F0ZSB0aGUgb3JpZ2luYWwgb25lIHNvIHRoYXQgd2Uga2VlcFxyXG5cdFx0XHQvLyByZWx5aW5nIG9uIGl0IHRvIGV4dHJhY3QgdGFyZ2V0IHRvdWNoZXMuXHJcblx0XHRcdHRhcmdldDogZXZlbnQudGFyZ2V0LFxyXG5cdFx0XHRoYW5kbGU6IGhhbmRsZSxcclxuXHRcdFx0bGlzdGVuZXJzOiBsaXN0ZW5lcnMsXHJcblx0XHRcdHN0YXJ0Q2FsY1BvaW50OiBldmVudC5jYWxjUG9pbnQsXHJcblx0XHRcdGJhc2VTaXplOiBiYXNlU2l6ZSgpLFxyXG5cdFx0XHRwYWdlT2Zmc2V0OiBldmVudC5wYWdlT2Zmc2V0LFxyXG5cdFx0XHRoYW5kbGVOdW1iZXJzOiBkYXRhLmhhbmRsZU51bWJlcnMsXHJcblx0XHRcdGJ1dHRvbnNQcm9wZXJ0eTogZXZlbnQuYnV0dG9ucyxcclxuXHRcdFx0bG9jYXRpb25zOiBzY29wZV9Mb2NhdGlvbnMuc2xpY2UoKVxyXG5cdFx0fSk7XHJcblxyXG5cdFx0dmFyIGVuZEV2ZW50ID0gYXR0YWNoRXZlbnQoYWN0aW9ucy5lbmQsIHNjb3BlX0RvY3VtZW50RWxlbWVudCwgZXZlbnRFbmQsIHtcclxuXHRcdFx0dGFyZ2V0OiBldmVudC50YXJnZXQsXHJcblx0XHRcdGhhbmRsZTogaGFuZGxlLFxyXG5cdFx0XHRsaXN0ZW5lcnM6IGxpc3RlbmVycyxcclxuXHRcdFx0ZG9Ob3RSZWplY3Q6IHRydWUsXHJcblx0XHRcdGhhbmRsZU51bWJlcnM6IGRhdGEuaGFuZGxlTnVtYmVyc1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0dmFyIG91dEV2ZW50ID0gYXR0YWNoRXZlbnQoXCJtb3VzZW91dFwiLCBzY29wZV9Eb2N1bWVudEVsZW1lbnQsIGRvY3VtZW50TGVhdmUsIHtcclxuXHRcdFx0dGFyZ2V0OiBldmVudC50YXJnZXQsXHJcblx0XHRcdGhhbmRsZTogaGFuZGxlLFxyXG5cdFx0XHRsaXN0ZW5lcnM6IGxpc3RlbmVycyxcclxuXHRcdFx0ZG9Ob3RSZWplY3Q6IHRydWUsXHJcblx0XHRcdGhhbmRsZU51bWJlcnM6IGRhdGEuaGFuZGxlTnVtYmVyc1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gV2Ugd2FudCB0byBtYWtlIHN1cmUgd2UgcHVzaGVkIHRoZSBsaXN0ZW5lcnMgaW4gdGhlIGxpc3RlbmVyIGxpc3QgcmF0aGVyIHRoYW4gY3JlYXRpbmdcclxuXHRcdC8vIGEgbmV3IG9uZSBhcyBpdCBoYXMgYWxyZWFkeSBiZWVuIHBhc3NlZCB0byB0aGUgZXZlbnQgaGFuZGxlcnMuXHJcblx0XHRsaXN0ZW5lcnMucHVzaC5hcHBseShsaXN0ZW5lcnMsIG1vdmVFdmVudC5jb25jYXQoZW5kRXZlbnQsIG91dEV2ZW50KSk7XHJcblxyXG5cdFx0Ly8gVGV4dCBzZWxlY3Rpb24gaXNuJ3QgYW4gaXNzdWUgb24gdG91Y2ggZGV2aWNlcyxcclxuXHRcdC8vIHNvIGFkZGluZyBjdXJzb3Igc3R5bGVzIGNhbiBiZSBza2lwcGVkLlxyXG5cdFx0aWYgKCBldmVudC5jdXJzb3IgKSB7XHJcblxyXG5cdFx0XHQvLyBQcmV2ZW50IHRoZSAnSScgY3Vyc29yIGFuZCBleHRlbmQgdGhlIHJhbmdlLWRyYWcgY3Vyc29yLlxyXG5cdFx0XHRzY29wZV9Cb2R5LnN0eWxlLmN1cnNvciA9IGdldENvbXB1dGVkU3R5bGUoZXZlbnQudGFyZ2V0KS5jdXJzb3I7XHJcblxyXG5cdFx0XHQvLyBNYXJrIHRoZSB0YXJnZXQgd2l0aCBhIGRyYWdnaW5nIHN0YXRlLlxyXG5cdFx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSApIHtcclxuXHRcdFx0XHRhZGRDbGFzcyhzY29wZV9UYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy5kcmFnKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gUHJldmVudCB0ZXh0IHNlbGVjdGlvbiB3aGVuIGRyYWdnaW5nIHRoZSBoYW5kbGVzLlxyXG5cdFx0XHQvLyBJbiBub1VpU2xpZGVyIDw9IDkuMi4wLCB0aGlzIHdhcyBoYW5kbGVkIGJ5IGNhbGxpbmcgcHJldmVudERlZmF1bHQgb24gbW91c2UvdG91Y2ggc3RhcnQvbW92ZSxcclxuXHRcdFx0Ly8gd2hpY2ggaXMgc2Nyb2xsIGJsb2NraW5nLiBUaGUgc2VsZWN0c3RhcnQgZXZlbnQgaXMgc3VwcG9ydGVkIGJ5IEZpcmVGb3ggc3RhcnRpbmcgZnJvbSB2ZXJzaW9uIDUyLFxyXG5cdFx0XHQvLyBtZWFuaW5nIHRoZSBvbmx5IGhvbGRvdXQgaXMgaU9TIFNhZmFyaS4gVGhpcyBkb2Vzbid0IG1hdHRlcjogdGV4dCBzZWxlY3Rpb24gaXNuJ3QgdHJpZ2dlcmVkIHRoZXJlLlxyXG5cdFx0XHQvLyBUaGUgJ2N1cnNvcicgZmxhZyBpcyBmYWxzZS5cclxuXHRcdFx0Ly8gU2VlOiBodHRwOi8vY2FuaXVzZS5jb20vI3NlYXJjaD1zZWxlY3RzdGFydFxyXG5cdFx0XHRzY29wZV9Cb2R5LmFkZEV2ZW50TGlzdGVuZXIoJ3NlbGVjdHN0YXJ0JywgcHJldmVudERlZmF1bHQsIGZhbHNlKTtcclxuXHRcdH1cclxuXHJcblx0XHRkYXRhLmhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRmaXJlRXZlbnQoJ3N0YXJ0JywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gTW92ZSBjbG9zZXN0IGhhbmRsZSB0byB0YXBwZWQgbG9jYXRpb24uXHJcblx0ZnVuY3Rpb24gZXZlbnRUYXAgKCBldmVudCApIHtcclxuXHJcblx0XHQvLyBUaGUgdGFwIGV2ZW50IHNob3VsZG4ndCBwcm9wYWdhdGUgdXBcclxuXHRcdGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbCA9IGNhbGNQb2ludFRvUGVyY2VudGFnZShldmVudC5jYWxjUG9pbnQpO1xyXG5cdFx0dmFyIGhhbmRsZU51bWJlciA9IGdldENsb3Nlc3RIYW5kbGUocHJvcG9zYWwpO1xyXG5cclxuXHRcdC8vIFRhY2tsZSB0aGUgY2FzZSB0aGF0IGFsbCBoYW5kbGVzIGFyZSAnZGlzYWJsZWQnLlxyXG5cdFx0aWYgKCBoYW5kbGVOdW1iZXIgPT09IGZhbHNlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gRmxhZyB0aGUgc2xpZGVyIGFzIGl0IGlzIG5vdyBpbiBhIHRyYW5zaXRpb25hbCBzdGF0ZS5cclxuXHRcdC8vIFRyYW5zaXRpb24gdGFrZXMgYSBjb25maWd1cmFibGUgYW1vdW50IG9mIG1zIChkZWZhdWx0IDMwMCkuIFJlLWVuYWJsZSB0aGUgc2xpZGVyIGFmdGVyIHRoYXQuXHJcblx0XHRpZiAoICFvcHRpb25zLmV2ZW50cy5zbmFwICkge1xyXG5cdFx0XHRhZGRDbGFzc0ZvcihzY29wZV9UYXJnZXQsIG9wdGlvbnMuY3NzQ2xhc3Nlcy50YXAsIG9wdGlvbnMuYW5pbWF0aW9uRHVyYXRpb24pO1xyXG5cdFx0fVxyXG5cclxuXHRcdHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIHByb3Bvc2FsLCB0cnVlLCB0cnVlKTtcclxuXHJcblx0XHRzZXRaaW5kZXgoKTtcclxuXHJcblx0XHRmaXJlRXZlbnQoJ3NsaWRlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgndXBkYXRlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgnY2hhbmdlJywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHRcdGZpcmVFdmVudCgnc2V0JywgaGFuZGxlTnVtYmVyLCB0cnVlKTtcclxuXHJcblx0XHRpZiAoIG9wdGlvbnMuZXZlbnRzLnNuYXAgKSB7XHJcblx0XHRcdGV2ZW50U3RhcnQoZXZlbnQsIHsgaGFuZGxlTnVtYmVyczogW2hhbmRsZU51bWJlcl0gfSk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQvLyBGaXJlcyBhICdob3ZlcicgZXZlbnQgZm9yIGEgaG92ZXJlZCBtb3VzZS9wZW4gcG9zaXRpb24uXHJcblx0ZnVuY3Rpb24gZXZlbnRIb3ZlciAoIGV2ZW50ICkge1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbCA9IGNhbGNQb2ludFRvUGVyY2VudGFnZShldmVudC5jYWxjUG9pbnQpO1xyXG5cclxuXHRcdHZhciB0byA9IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAocHJvcG9zYWwpO1xyXG5cdFx0dmFyIHZhbHVlID0gc2NvcGVfU3BlY3RydW0uZnJvbVN0ZXBwaW5nKHRvKTtcclxuXHJcblx0XHRPYmplY3Qua2V5cyhzY29wZV9FdmVudHMpLmZvckVhY2goZnVuY3Rpb24oIHRhcmdldEV2ZW50ICkge1xyXG5cdFx0XHRpZiAoICdob3ZlcicgPT09IHRhcmdldEV2ZW50LnNwbGl0KCcuJylbMF0gKSB7XHJcblx0XHRcdFx0c2NvcGVfRXZlbnRzW3RhcmdldEV2ZW50XS5mb3JFYWNoKGZ1bmN0aW9uKCBjYWxsYmFjayApIHtcclxuXHRcdFx0XHRcdGNhbGxiYWNrLmNhbGwoIHNjb3BlX1NlbGYsIHZhbHVlICk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gQXR0YWNoIGV2ZW50cyB0byBzZXZlcmFsIHNsaWRlciBwYXJ0cy5cclxuXHRmdW5jdGlvbiBiaW5kU2xpZGVyRXZlbnRzICggYmVoYXZpb3VyICkge1xyXG5cclxuXHRcdC8vIEF0dGFjaCB0aGUgc3RhbmRhcmQgZHJhZyBldmVudCB0byB0aGUgaGFuZGxlcy5cclxuXHRcdGlmICggIWJlaGF2aW91ci5maXhlZCApIHtcclxuXHJcblx0XHRcdHNjb3BlX0hhbmRsZXMuZm9yRWFjaChmdW5jdGlvbiggaGFuZGxlLCBpbmRleCApe1xyXG5cclxuXHRcdFx0XHQvLyBUaGVzZSBldmVudHMgYXJlIG9ubHkgYm91bmQgdG8gdGhlIHZpc3VhbCBoYW5kbGVcclxuXHRcdFx0XHQvLyBlbGVtZW50LCBub3QgdGhlICdyZWFsJyBvcmlnaW4gZWxlbWVudC5cclxuXHRcdFx0XHRhdHRhY2hFdmVudCAoIGFjdGlvbnMuc3RhcnQsIGhhbmRsZS5jaGlsZHJlblswXSwgZXZlbnRTdGFydCwge1xyXG5cdFx0XHRcdFx0aGFuZGxlTnVtYmVyczogW2luZGV4XVxyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBBdHRhY2ggdGhlIHRhcCBldmVudCB0byB0aGUgc2xpZGVyIGJhc2UuXHJcblx0XHRpZiAoIGJlaGF2aW91ci50YXAgKSB7XHJcblx0XHRcdGF0dGFjaEV2ZW50IChhY3Rpb25zLnN0YXJ0LCBzY29wZV9CYXNlLCBldmVudFRhcCwge30pO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIEZpcmUgaG92ZXIgZXZlbnRzXHJcblx0XHRpZiAoIGJlaGF2aW91ci5ob3ZlciApIHtcclxuXHRcdFx0YXR0YWNoRXZlbnQgKGFjdGlvbnMubW92ZSwgc2NvcGVfQmFzZSwgZXZlbnRIb3ZlciwgeyBob3ZlcjogdHJ1ZSB9KTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBNYWtlIHRoZSByYW5nZSBkcmFnZ2FibGUuXHJcblx0XHRpZiAoIGJlaGF2aW91ci5kcmFnICl7XHJcblxyXG5cdFx0XHRzY29wZV9Db25uZWN0cy5mb3JFYWNoKGZ1bmN0aW9uKCBjb25uZWN0LCBpbmRleCApe1xyXG5cclxuXHRcdFx0XHRpZiAoIGNvbm5lY3QgPT09IGZhbHNlIHx8IGluZGV4ID09PSAwIHx8IGluZGV4ID09PSBzY29wZV9Db25uZWN0cy5sZW5ndGggLSAxICkge1xyXG5cdFx0XHRcdFx0cmV0dXJuO1xyXG5cdFx0XHRcdH1cclxuXHJcblx0XHRcdFx0dmFyIGhhbmRsZUJlZm9yZSA9IHNjb3BlX0hhbmRsZXNbaW5kZXggLSAxXTtcclxuXHRcdFx0XHR2YXIgaGFuZGxlQWZ0ZXIgPSBzY29wZV9IYW5kbGVzW2luZGV4XTtcclxuXHRcdFx0XHR2YXIgZXZlbnRIb2xkZXJzID0gW2Nvbm5lY3RdO1xyXG5cclxuXHRcdFx0XHRhZGRDbGFzcyhjb25uZWN0LCBvcHRpb25zLmNzc0NsYXNzZXMuZHJhZ2dhYmxlKTtcclxuXHJcblx0XHRcdFx0Ly8gV2hlbiB0aGUgcmFuZ2UgaXMgZml4ZWQsIHRoZSBlbnRpcmUgcmFuZ2UgY2FuXHJcblx0XHRcdFx0Ly8gYmUgZHJhZ2dlZCBieSB0aGUgaGFuZGxlcy4gVGhlIGhhbmRsZSBpbiB0aGUgZmlyc3RcclxuXHRcdFx0XHQvLyBvcmlnaW4gd2lsbCBwcm9wYWdhdGUgdGhlIHN0YXJ0IGV2ZW50IHVwd2FyZCxcclxuXHRcdFx0XHQvLyBidXQgaXQgbmVlZHMgdG8gYmUgYm91bmQgbWFudWFsbHkgb24gdGhlIG90aGVyLlxyXG5cdFx0XHRcdGlmICggYmVoYXZpb3VyLmZpeGVkICkge1xyXG5cdFx0XHRcdFx0ZXZlbnRIb2xkZXJzLnB1c2goaGFuZGxlQmVmb3JlLmNoaWxkcmVuWzBdKTtcclxuXHRcdFx0XHRcdGV2ZW50SG9sZGVycy5wdXNoKGhhbmRsZUFmdGVyLmNoaWxkcmVuWzBdKTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdGV2ZW50SG9sZGVycy5mb3JFYWNoKGZ1bmN0aW9uKCBldmVudEhvbGRlciApIHtcclxuXHRcdFx0XHRcdGF0dGFjaEV2ZW50ICggYWN0aW9ucy5zdGFydCwgZXZlbnRIb2xkZXIsIGV2ZW50U3RhcnQsIHtcclxuXHRcdFx0XHRcdFx0aGFuZGxlczogW2hhbmRsZUJlZm9yZSwgaGFuZGxlQWZ0ZXJdLFxyXG5cdFx0XHRcdFx0XHRoYW5kbGVOdW1iZXJzOiBbaW5kZXggLSAxLCBpbmRleF1cclxuXHRcdFx0XHRcdH0pO1xyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG4vKiEgSW4gdGhpcyBmaWxlOiBTbGlkZXIgZXZlbnRzIChub3QgYnJvd3NlciBldmVudHMpOyAqL1xyXG5cclxuXHQvLyBBdHRhY2ggYW4gZXZlbnQgdG8gdGhpcyBzbGlkZXIsIHBvc3NpYmx5IGluY2x1ZGluZyBhIG5hbWVzcGFjZVxyXG5cdGZ1bmN0aW9uIGJpbmRFdmVudCAoIG5hbWVzcGFjZWRFdmVudCwgY2FsbGJhY2sgKSB7XHJcblx0XHRzY29wZV9FdmVudHNbbmFtZXNwYWNlZEV2ZW50XSA9IHNjb3BlX0V2ZW50c1tuYW1lc3BhY2VkRXZlbnRdIHx8IFtdO1xyXG5cdFx0c2NvcGVfRXZlbnRzW25hbWVzcGFjZWRFdmVudF0ucHVzaChjYWxsYmFjayk7XHJcblxyXG5cdFx0Ly8gSWYgdGhlIGV2ZW50IGJvdW5kIGlzICd1cGRhdGUsJyBmaXJlIGl0IGltbWVkaWF0ZWx5IGZvciBhbGwgaGFuZGxlcy5cclxuXHRcdGlmICggbmFtZXNwYWNlZEV2ZW50LnNwbGl0KCcuJylbMF0gPT09ICd1cGRhdGUnICkge1xyXG5cdFx0XHRzY29wZV9IYW5kbGVzLmZvckVhY2goZnVuY3Rpb24oYSwgaW5kZXgpe1xyXG5cdFx0XHRcdGZpcmVFdmVudCgndXBkYXRlJywgaW5kZXgpO1xyXG5cdFx0XHR9KTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG5cdC8vIFVuZG8gYXR0YWNobWVudCBvZiBldmVudFxyXG5cdGZ1bmN0aW9uIHJlbW92ZUV2ZW50ICggbmFtZXNwYWNlZEV2ZW50ICkge1xyXG5cclxuXHRcdHZhciBldmVudCA9IG5hbWVzcGFjZWRFdmVudCAmJiBuYW1lc3BhY2VkRXZlbnQuc3BsaXQoJy4nKVswXTtcclxuXHRcdHZhciBuYW1lc3BhY2UgPSBldmVudCAmJiBuYW1lc3BhY2VkRXZlbnQuc3Vic3RyaW5nKGV2ZW50Lmxlbmd0aCk7XHJcblxyXG5cdFx0T2JqZWN0LmtleXMoc2NvcGVfRXZlbnRzKS5mb3JFYWNoKGZ1bmN0aW9uKCBiaW5kICl7XHJcblxyXG5cdFx0XHR2YXIgdEV2ZW50ID0gYmluZC5zcGxpdCgnLicpWzBdO1xyXG5cdFx0XHR2YXIgdE5hbWVzcGFjZSA9IGJpbmQuc3Vic3RyaW5nKHRFdmVudC5sZW5ndGgpO1xyXG5cclxuXHRcdFx0aWYgKCAoIWV2ZW50IHx8IGV2ZW50ID09PSB0RXZlbnQpICYmICghbmFtZXNwYWNlIHx8IG5hbWVzcGFjZSA9PT0gdE5hbWVzcGFjZSkgKSB7XHJcblx0XHRcdFx0ZGVsZXRlIHNjb3BlX0V2ZW50c1tiaW5kXTtcclxuXHRcdFx0fVxyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBFeHRlcm5hbCBldmVudCBoYW5kbGluZ1xyXG5cdGZ1bmN0aW9uIGZpcmVFdmVudCAoIGV2ZW50TmFtZSwgaGFuZGxlTnVtYmVyLCB0YXAgKSB7XHJcblxyXG5cdFx0T2JqZWN0LmtleXMoc2NvcGVfRXZlbnRzKS5mb3JFYWNoKGZ1bmN0aW9uKCB0YXJnZXRFdmVudCApIHtcclxuXHJcblx0XHRcdHZhciBldmVudFR5cGUgPSB0YXJnZXRFdmVudC5zcGxpdCgnLicpWzBdO1xyXG5cclxuXHRcdFx0aWYgKCBldmVudE5hbWUgPT09IGV2ZW50VHlwZSApIHtcclxuXHRcdFx0XHRzY29wZV9FdmVudHNbdGFyZ2V0RXZlbnRdLmZvckVhY2goZnVuY3Rpb24oIGNhbGxiYWNrICkge1xyXG5cclxuXHRcdFx0XHRcdGNhbGxiYWNrLmNhbGwoXHJcblx0XHRcdFx0XHRcdC8vIFVzZSB0aGUgc2xpZGVyIHB1YmxpYyBBUEkgYXMgdGhlIHNjb3BlICgndGhpcycpXHJcblx0XHRcdFx0XHRcdHNjb3BlX1NlbGYsXHJcblx0XHRcdFx0XHRcdC8vIFJldHVybiB2YWx1ZXMgYXMgYXJyYXksIHNvIGFyZ18xW2FyZ18yXSBpcyBhbHdheXMgdmFsaWQuXHJcblx0XHRcdFx0XHRcdHNjb3BlX1ZhbHVlcy5tYXAob3B0aW9ucy5mb3JtYXQudG8pLFxyXG5cdFx0XHRcdFx0XHQvLyBIYW5kbGUgaW5kZXgsIDAgb3IgMVxyXG5cdFx0XHRcdFx0XHRoYW5kbGVOdW1iZXIsXHJcblx0XHRcdFx0XHRcdC8vIFVuZm9ybWF0dGVkIHNsaWRlciB2YWx1ZXNcclxuXHRcdFx0XHRcdFx0c2NvcGVfVmFsdWVzLnNsaWNlKCksXHJcblx0XHRcdFx0XHRcdC8vIEV2ZW50IGlzIGZpcmVkIGJ5IHRhcCwgdHJ1ZSBvciBmYWxzZVxyXG5cdFx0XHRcdFx0XHR0YXAgfHwgZmFsc2UsXHJcblx0XHRcdFx0XHRcdC8vIExlZnQgb2Zmc2V0IG9mIHRoZSBoYW5kbGUsIGluIHJlbGF0aW9uIHRvIHRoZSBzbGlkZXJcclxuXHRcdFx0XHRcdFx0c2NvcGVfTG9jYXRpb25zLnNsaWNlKClcclxuXHRcdFx0XHRcdCk7XHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IE1lY2hhbmljcyBmb3Igc2xpZGVyIG9wZXJhdGlvbiAqL1xyXG5cclxuXHRmdW5jdGlvbiB0b1BjdCAoIHBjdCApIHtcclxuXHRcdHJldHVybiBwY3QgKyAnJSc7XHJcblx0fVxyXG5cclxuXHQvLyBTcGxpdCBvdXQgdGhlIGhhbmRsZSBwb3NpdGlvbmluZyBsb2dpYyBzbyB0aGUgTW92ZSBldmVudCBjYW4gdXNlIGl0LCB0b29cclxuXHRmdW5jdGlvbiBjaGVja0hhbmRsZVBvc2l0aW9uICggcmVmZXJlbmNlLCBoYW5kbGVOdW1iZXIsIHRvLCBsb29rQmFja3dhcmQsIGxvb2tGb3J3YXJkLCBnZXRWYWx1ZSApIHtcclxuXHJcblx0XHQvLyBGb3Igc2xpZGVycyB3aXRoIG11bHRpcGxlIGhhbmRsZXMsIGxpbWl0IG1vdmVtZW50IHRvIHRoZSBvdGhlciBoYW5kbGUuXHJcblx0XHQvLyBBcHBseSB0aGUgbWFyZ2luIG9wdGlvbiBieSBhZGRpbmcgaXQgdG8gdGhlIGhhbmRsZSBwb3NpdGlvbnMuXHJcblx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSApIHtcclxuXHJcblx0XHRcdGlmICggbG9va0JhY2t3YXJkICYmIGhhbmRsZU51bWJlciA+IDAgKSB7XHJcblx0XHRcdFx0dG8gPSBNYXRoLm1heCh0bywgcmVmZXJlbmNlW2hhbmRsZU51bWJlciAtIDFdICsgb3B0aW9ucy5tYXJnaW4pO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRpZiAoIGxvb2tGb3J3YXJkICYmIGhhbmRsZU51bWJlciA8IHNjb3BlX0hhbmRsZXMubGVuZ3RoIC0gMSApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWluKHRvLCByZWZlcmVuY2VbaGFuZGxlTnVtYmVyICsgMV0gLSBvcHRpb25zLm1hcmdpbik7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBUaGUgbGltaXQgb3B0aW9uIGhhcyB0aGUgb3Bwb3NpdGUgZWZmZWN0LCBsaW1pdGluZyBoYW5kbGVzIHRvIGFcclxuXHRcdC8vIG1heGltdW0gZGlzdGFuY2UgZnJvbSBhbm90aGVyLiBMaW1pdCBtdXN0IGJlID4gMCwgYXMgb3RoZXJ3aXNlXHJcblx0XHQvLyBoYW5kbGVzIHdvdWxkIGJlIHVubW92ZWFibGUuXHJcblx0XHRpZiAoIHNjb3BlX0hhbmRsZXMubGVuZ3RoID4gMSAmJiBvcHRpb25zLmxpbWl0ICkge1xyXG5cclxuXHRcdFx0aWYgKCBsb29rQmFja3dhcmQgJiYgaGFuZGxlTnVtYmVyID4gMCApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWluKHRvLCByZWZlcmVuY2VbaGFuZGxlTnVtYmVyIC0gMV0gKyBvcHRpb25zLmxpbWl0KTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0aWYgKCBsb29rRm9yd2FyZCAmJiBoYW5kbGVOdW1iZXIgPCBzY29wZV9IYW5kbGVzLmxlbmd0aCAtIDEgKSB7XHJcblx0XHRcdFx0dG8gPSBNYXRoLm1heCh0bywgcmVmZXJlbmNlW2hhbmRsZU51bWJlciArIDFdIC0gb3B0aW9ucy5saW1pdCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHQvLyBUaGUgcGFkZGluZyBvcHRpb24ga2VlcHMgdGhlIGhhbmRsZXMgYSBjZXJ0YWluIGRpc3RhbmNlIGZyb20gdGhlXHJcblx0XHQvLyBlZGdlcyBvZiB0aGUgc2xpZGVyLiBQYWRkaW5nIG11c3QgYmUgPiAwLlxyXG5cdFx0aWYgKCBvcHRpb25zLnBhZGRpbmcgKSB7XHJcblxyXG5cdFx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gMCApIHtcclxuXHRcdFx0XHR0byA9IE1hdGgubWF4KHRvLCBvcHRpb25zLnBhZGRpbmdbMF0pO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRpZiAoIGhhbmRsZU51bWJlciA9PT0gc2NvcGVfSGFuZGxlcy5sZW5ndGggLSAxICkge1xyXG5cdFx0XHRcdHRvID0gTWF0aC5taW4odG8sIDEwMCAtIG9wdGlvbnMucGFkZGluZ1sxXSk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcblx0XHR0byA9IHNjb3BlX1NwZWN0cnVtLmdldFN0ZXAodG8pO1xyXG5cclxuXHRcdC8vIExpbWl0IHBlcmNlbnRhZ2UgdG8gdGhlIDAgLSAxMDAgcmFuZ2VcclxuXHRcdHRvID0gbGltaXQodG8pO1xyXG5cclxuXHRcdC8vIFJldHVybiBmYWxzZSBpZiBoYW5kbGUgY2FuJ3QgbW92ZVxyXG5cdFx0aWYgKCB0byA9PT0gcmVmZXJlbmNlW2hhbmRsZU51bWJlcl0gJiYgIWdldFZhbHVlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHRvO1xyXG5cdH1cclxuXHJcblx0Ly8gVXNlcyBzbGlkZXIgb3JpZW50YXRpb24gdG8gY3JlYXRlIENTUyBydWxlcy4gYSA9IGJhc2UgdmFsdWU7XHJcblx0ZnVuY3Rpb24gaW5SdWxlT3JkZXIgKCB2LCBhICkge1xyXG5cdFx0dmFyIG8gPSBvcHRpb25zLm9ydDtcclxuXHRcdHJldHVybiAobz9hOnYpICsgJywgJyArIChvP3Y6YSk7XHJcblx0fVxyXG5cclxuXHQvLyBNb3ZlcyBoYW5kbGUocykgYnkgYSBwZXJjZW50YWdlXHJcblx0Ly8gKGJvb2wsICUgdG8gbW92ZSwgWyUgd2hlcmUgaGFuZGxlIHN0YXJ0ZWQsIC4uLl0sIFtpbmRleCBpbiBzY29wZV9IYW5kbGVzLCAuLi5dKVxyXG5cdGZ1bmN0aW9uIG1vdmVIYW5kbGVzICggdXB3YXJkLCBwcm9wb3NhbCwgbG9jYXRpb25zLCBoYW5kbGVOdW1iZXJzICkge1xyXG5cclxuXHRcdHZhciBwcm9wb3NhbHMgPSBsb2NhdGlvbnMuc2xpY2UoKTtcclxuXHJcblx0XHR2YXIgYiA9IFshdXB3YXJkLCB1cHdhcmRdO1xyXG5cdFx0dmFyIGYgPSBbdXB3YXJkLCAhdXB3YXJkXTtcclxuXHJcblx0XHQvLyBDb3B5IGhhbmRsZU51bWJlcnMgc28gd2UgZG9uJ3QgY2hhbmdlIHRoZSBkYXRhc2V0XHJcblx0XHRoYW5kbGVOdW1iZXJzID0gaGFuZGxlTnVtYmVycy5zbGljZSgpO1xyXG5cclxuXHRcdC8vIENoZWNrIHRvIHNlZSB3aGljaCBoYW5kbGUgaXMgJ2xlYWRpbmcnLlxyXG5cdFx0Ly8gSWYgdGhhdCBvbmUgY2FuJ3QgbW92ZSB0aGUgc2Vjb25kIGNhbid0IGVpdGhlci5cclxuXHRcdGlmICggdXB3YXJkICkge1xyXG5cdFx0XHRoYW5kbGVOdW1iZXJzLnJldmVyc2UoKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBTdGVwIDE6IGdldCB0aGUgbWF4aW11bSBwZXJjZW50YWdlIHRoYXQgYW55IG9mIHRoZSBoYW5kbGVzIGNhbiBtb3ZlXHJcblx0XHRpZiAoIGhhbmRsZU51bWJlcnMubGVuZ3RoID4gMSApIHtcclxuXHJcblx0XHRcdGhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIsIG8pIHtcclxuXHJcblx0XHRcdFx0dmFyIHRvID0gY2hlY2tIYW5kbGVQb3NpdGlvbihwcm9wb3NhbHMsIGhhbmRsZU51bWJlciwgcHJvcG9zYWxzW2hhbmRsZU51bWJlcl0gKyBwcm9wb3NhbCwgYltvXSwgZltvXSwgZmFsc2UpO1xyXG5cclxuXHRcdFx0XHQvLyBTdG9wIGlmIG9uZSBvZiB0aGUgaGFuZGxlcyBjYW4ndCBtb3ZlLlxyXG5cdFx0XHRcdGlmICggdG8gPT09IGZhbHNlICkge1xyXG5cdFx0XHRcdFx0cHJvcG9zYWwgPSAwO1xyXG5cdFx0XHRcdH0gZWxzZSB7XHJcblx0XHRcdFx0XHRwcm9wb3NhbCA9IHRvIC0gcHJvcG9zYWxzW2hhbmRsZU51bWJlcl07XHJcblx0XHRcdFx0XHRwcm9wb3NhbHNbaGFuZGxlTnVtYmVyXSA9IHRvO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fSk7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gSWYgdXNpbmcgb25lIGhhbmRsZSwgY2hlY2sgYmFja3dhcmQgQU5EIGZvcndhcmRcclxuXHRcdGVsc2Uge1xyXG5cdFx0XHRiID0gZiA9IFt0cnVlXTtcclxuXHRcdH1cclxuXHJcblx0XHR2YXIgc3RhdGUgPSBmYWxzZTtcclxuXHJcblx0XHQvLyBTdGVwIDI6IFRyeSB0byBzZXQgdGhlIGhhbmRsZXMgd2l0aCB0aGUgZm91bmQgcGVyY2VudGFnZVxyXG5cdFx0aGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlciwgbykge1xyXG5cdFx0XHRzdGF0ZSA9IHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIGxvY2F0aW9uc1toYW5kbGVOdW1iZXJdICsgcHJvcG9zYWwsIGJbb10sIGZbb10pIHx8IHN0YXRlO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gU3RlcCAzOiBJZiBhIGhhbmRsZSBtb3ZlZCwgZmlyZSBldmVudHNcclxuXHRcdGlmICggc3RhdGUgKSB7XHJcblx0XHRcdGhhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRcdGZpcmVFdmVudCgndXBkYXRlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0XHRmaXJlRXZlbnQoJ3NsaWRlJywgaGFuZGxlTnVtYmVyKTtcclxuXHRcdFx0fSk7XHJcblx0XHR9XHJcblx0fVxyXG5cclxuXHQvLyBUYWtlcyBhIGJhc2UgdmFsdWUgYW5kIGFuIG9mZnNldC4gVGhpcyBvZmZzZXQgaXMgdXNlZCBmb3IgdGhlIGNvbm5lY3QgYmFyIHNpemUuXHJcblx0Ly8gSW4gdGhlIGluaXRpYWwgZGVzaWduIGZvciB0aGlzIGZlYXR1cmUsIHRoZSBvcmlnaW4gZWxlbWVudCB3YXMgMSUgd2lkZS5cclxuXHQvLyBVbmZvcnR1bmF0ZWx5LCBhIHJvdW5kaW5nIGJ1ZyBpbiBDaHJvbWUgbWFrZXMgaXQgaW1wb3NzaWJsZSB0byBpbXBsZW1lbnQgdGhpcyBmZWF0dXJlXHJcblx0Ly8gaW4gdGhpcyBtYW5uZXI6IGh0dHBzOi8vYnVncy5jaHJvbWl1bS5vcmcvcC9jaHJvbWl1bS9pc3N1ZXMvZGV0YWlsP2lkPTc5ODIyM1xyXG5cdGZ1bmN0aW9uIHRyYW5zZm9ybURpcmVjdGlvbiAoIGEsIGIgKSB7XHJcblx0XHRyZXR1cm4gb3B0aW9ucy5kaXIgPyAxMDAgLSBhIC0gYiA6IGE7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVzIHNjb3BlX0xvY2F0aW9ucyBhbmQgc2NvcGVfVmFsdWVzLCB1cGRhdGVzIHZpc3VhbCBzdGF0ZVxyXG5cdGZ1bmN0aW9uIHVwZGF0ZUhhbmRsZVBvc2l0aW9uICggaGFuZGxlTnVtYmVyLCB0byApIHtcclxuXHJcblx0XHQvLyBVcGRhdGUgbG9jYXRpb25zLlxyXG5cdFx0c2NvcGVfTG9jYXRpb25zW2hhbmRsZU51bWJlcl0gPSB0bztcclxuXHJcblx0XHQvLyBDb252ZXJ0IHRoZSB2YWx1ZSB0byB0aGUgc2xpZGVyIHN0ZXBwaW5nL3JhbmdlLlxyXG5cdFx0c2NvcGVfVmFsdWVzW2hhbmRsZU51bWJlcl0gPSBzY29wZV9TcGVjdHJ1bS5mcm9tU3RlcHBpbmcodG8pO1xyXG5cclxuXHRcdHZhciBydWxlID0gJ3RyYW5zbGF0ZSgnICsgaW5SdWxlT3JkZXIodG9QY3QodHJhbnNmb3JtRGlyZWN0aW9uKHRvLCAwKSAtIHNjb3BlX0Rpck9mZnNldCksICcwJykgKyAnKSc7XHJcblx0XHRzY29wZV9IYW5kbGVzW2hhbmRsZU51bWJlcl0uc3R5bGVbb3B0aW9ucy50cmFuc2Zvcm1SdWxlXSA9IHJ1bGU7XHJcblxyXG5cdFx0dXBkYXRlQ29ubmVjdChoYW5kbGVOdW1iZXIpO1xyXG5cdFx0dXBkYXRlQ29ubmVjdChoYW5kbGVOdW1iZXIgKyAxKTtcclxuXHR9XHJcblxyXG5cdC8vIEhhbmRsZXMgYmVmb3JlIHRoZSBzbGlkZXIgbWlkZGxlIGFyZSBzdGFja2VkIGxhdGVyID0gaGlnaGVyLFxyXG5cdC8vIEhhbmRsZXMgYWZ0ZXIgdGhlIG1pZGRsZSBsYXRlciBpcyBsb3dlclxyXG5cdC8vIFtbN10gWzhdIC4uLi4uLi4uLi4gfCAuLi4uLi4uLi4uIFs1XSBbNF1cclxuXHRmdW5jdGlvbiBzZXRaaW5kZXggKCApIHtcclxuXHJcblx0XHRzY29wZV9IYW5kbGVOdW1iZXJzLmZvckVhY2goZnVuY3Rpb24oaGFuZGxlTnVtYmVyKXtcclxuXHRcdFx0dmFyIGRpciA9IChzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXSA+IDUwID8gLTEgOiAxKTtcclxuXHRcdFx0dmFyIHpJbmRleCA9IDMgKyAoc2NvcGVfSGFuZGxlcy5sZW5ndGggKyAoZGlyICogaGFuZGxlTnVtYmVyKSk7XHJcblx0XHRcdHNjb3BlX0hhbmRsZXNbaGFuZGxlTnVtYmVyXS5zdHlsZS56SW5kZXggPSB6SW5kZXg7XHJcblx0XHR9KTtcclxuXHR9XHJcblxyXG5cdC8vIFRlc3Qgc3VnZ2VzdGVkIHZhbHVlcyBhbmQgYXBwbHkgbWFyZ2luLCBzdGVwLlxyXG5cdGZ1bmN0aW9uIHNldEhhbmRsZSAoIGhhbmRsZU51bWJlciwgdG8sIGxvb2tCYWNrd2FyZCwgbG9va0ZvcndhcmQgKSB7XHJcblxyXG5cdFx0dG8gPSBjaGVja0hhbmRsZVBvc2l0aW9uKHNjb3BlX0xvY2F0aW9ucywgaGFuZGxlTnVtYmVyLCB0bywgbG9va0JhY2t3YXJkLCBsb29rRm9yd2FyZCwgZmFsc2UpO1xyXG5cclxuXHRcdGlmICggdG8gPT09IGZhbHNlICkge1xyXG5cdFx0XHRyZXR1cm4gZmFsc2U7XHJcblx0XHR9XHJcblxyXG5cdFx0dXBkYXRlSGFuZGxlUG9zaXRpb24oaGFuZGxlTnVtYmVyLCB0byk7XHJcblxyXG5cdFx0cmV0dXJuIHRydWU7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVzIHN0eWxlIGF0dHJpYnV0ZSBmb3IgY29ubmVjdCBub2Rlc1xyXG5cdGZ1bmN0aW9uIHVwZGF0ZUNvbm5lY3QgKCBpbmRleCApIHtcclxuXHJcblx0XHQvLyBTa2lwIGNvbm5lY3RzIHNldCB0byBmYWxzZVxyXG5cdFx0aWYgKCAhc2NvcGVfQ29ubmVjdHNbaW5kZXhdICkge1xyXG5cdFx0XHRyZXR1cm47XHJcblx0XHR9XHJcblxyXG5cdFx0dmFyIGwgPSAwO1xyXG5cdFx0dmFyIGggPSAxMDA7XHJcblxyXG5cdFx0aWYgKCBpbmRleCAhPT0gMCApIHtcclxuXHRcdFx0bCA9IHNjb3BlX0xvY2F0aW9uc1tpbmRleCAtIDFdO1xyXG5cdFx0fVxyXG5cclxuXHRcdGlmICggaW5kZXggIT09IHNjb3BlX0Nvbm5lY3RzLmxlbmd0aCAtIDEgKSB7XHJcblx0XHRcdGggPSBzY29wZV9Mb2NhdGlvbnNbaW5kZXhdO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFdlIHVzZSB0d28gcnVsZXM6XHJcblx0XHQvLyAndHJhbnNsYXRlJyB0byBjaGFuZ2UgdGhlIGxlZnQvdG9wIG9mZnNldDtcclxuXHRcdC8vICdzY2FsZScgdG8gY2hhbmdlIHRoZSB3aWR0aCBvZiB0aGUgZWxlbWVudDtcclxuXHRcdC8vIEFzIHRoZSBlbGVtZW50IGhhcyBhIHdpZHRoIG9mIDEwMCUsIGEgdHJhbnNsYXRpb24gb2YgMTAwJSBpcyBlcXVhbCB0byAxMDAlIG9mIHRoZSBwYXJlbnQgKC5ub1VpLWJhc2UpXHJcblx0XHR2YXIgY29ubmVjdFdpZHRoID0gaCAtIGw7XHJcblx0XHR2YXIgdHJhbnNsYXRlUnVsZSA9ICd0cmFuc2xhdGUoJyArIGluUnVsZU9yZGVyKHRvUGN0KHRyYW5zZm9ybURpcmVjdGlvbihsLCBjb25uZWN0V2lkdGgpKSwgJzAnKSArICcpJztcclxuXHRcdHZhciBzY2FsZVJ1bGUgPSAnc2NhbGUoJyArIGluUnVsZU9yZGVyKGNvbm5lY3RXaWR0aCAvIDEwMCwgJzEnKSArICcpJztcclxuXHJcblx0XHRzY29wZV9Db25uZWN0c1tpbmRleF0uc3R5bGVbb3B0aW9ucy50cmFuc2Zvcm1SdWxlXSA9IHRyYW5zbGF0ZVJ1bGUgKyAnICcgKyBzY2FsZVJ1bGU7XHJcblx0fVxyXG5cclxuLyohIEluIHRoaXMgZmlsZTogQWxsIG1ldGhvZHMgZXZlbnR1YWxseSBleHBvc2VkIGluIHNsaWRlci5ub1VpU2xpZGVyLi4uICovXHJcblxyXG5cdC8vIFBhcnNlcyB2YWx1ZSBwYXNzZWQgdG8gLnNldCBtZXRob2QuIFJldHVybnMgY3VycmVudCB2YWx1ZSBpZiBub3QgcGFyc2UtYWJsZS5cclxuXHRmdW5jdGlvbiByZXNvbHZlVG9WYWx1ZSAoIHRvLCBoYW5kbGVOdW1iZXIgKSB7XHJcblxyXG5cdFx0Ly8gU2V0dGluZyB3aXRoIG51bGwgaW5kaWNhdGVzIGFuICdpZ25vcmUnLlxyXG5cdFx0Ly8gSW5wdXR0aW5nICdmYWxzZScgaXMgaW52YWxpZC5cclxuXHRcdGlmICggdG8gPT09IG51bGwgfHwgdG8gPT09IGZhbHNlIHx8IHRvID09PSB1bmRlZmluZWQgKSB7XHJcblx0XHRcdHJldHVybiBzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJZiBhIGZvcm1hdHRlZCBudW1iZXIgd2FzIHBhc3NlZCwgYXR0ZW1wdCB0byBkZWNvZGUgaXQuXHJcblx0XHRpZiAoIHR5cGVvZiB0byA9PT0gJ251bWJlcicgKSB7XHJcblx0XHRcdHRvID0gU3RyaW5nKHRvKTtcclxuXHRcdH1cclxuXHJcblx0XHR0byA9IG9wdGlvbnMuZm9ybWF0LmZyb20odG8pO1xyXG5cdFx0dG8gPSBzY29wZV9TcGVjdHJ1bS50b1N0ZXBwaW5nKHRvKTtcclxuXHJcblx0XHQvLyBJZiBwYXJzaW5nIHRoZSBudW1iZXIgZmFpbGVkLCB1c2UgdGhlIGN1cnJlbnQgdmFsdWUuXHJcblx0XHRpZiAoIHRvID09PSBmYWxzZSB8fCBpc05hTih0bykgKSB7XHJcblx0XHRcdHJldHVybiBzY29wZV9Mb2NhdGlvbnNbaGFuZGxlTnVtYmVyXTtcclxuXHRcdH1cclxuXHJcblx0XHRyZXR1cm4gdG87XHJcblx0fVxyXG5cclxuXHQvLyBTZXQgdGhlIHNsaWRlciB2YWx1ZS5cclxuXHRmdW5jdGlvbiB2YWx1ZVNldCAoIGlucHV0LCBmaXJlU2V0RXZlbnQgKSB7XHJcblxyXG5cdFx0dmFyIHZhbHVlcyA9IGFzQXJyYXkoaW5wdXQpO1xyXG5cdFx0dmFyIGlzSW5pdCA9IHNjb3BlX0xvY2F0aW9uc1swXSA9PT0gdW5kZWZpbmVkO1xyXG5cclxuXHRcdC8vIEV2ZW50IGZpcmVzIGJ5IGRlZmF1bHRcclxuXHRcdGZpcmVTZXRFdmVudCA9IChmaXJlU2V0RXZlbnQgPT09IHVuZGVmaW5lZCA/IHRydWUgOiAhIWZpcmVTZXRFdmVudCk7XHJcblxyXG5cdFx0Ly8gQW5pbWF0aW9uIGlzIG9wdGlvbmFsLlxyXG5cdFx0Ly8gTWFrZSBzdXJlIHRoZSBpbml0aWFsIHZhbHVlcyB3ZXJlIHNldCBiZWZvcmUgdXNpbmcgYW5pbWF0ZWQgcGxhY2VtZW50LlxyXG5cdFx0aWYgKCBvcHRpb25zLmFuaW1hdGUgJiYgIWlzSW5pdCApIHtcclxuXHRcdFx0YWRkQ2xhc3NGb3Ioc2NvcGVfVGFyZ2V0LCBvcHRpb25zLmNzc0NsYXNzZXMudGFwLCBvcHRpb25zLmFuaW1hdGlvbkR1cmF0aW9uKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBGaXJzdCBwYXNzLCB3aXRob3V0IGxvb2tBaGVhZCBidXQgd2l0aCBsb29rQmFja3dhcmQuIFZhbHVlcyBhcmUgc2V0IGZyb20gbGVmdCB0byByaWdodC5cclxuXHRcdHNjb3BlX0hhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cdFx0XHRzZXRIYW5kbGUoaGFuZGxlTnVtYmVyLCByZXNvbHZlVG9WYWx1ZSh2YWx1ZXNbaGFuZGxlTnVtYmVyXSwgaGFuZGxlTnVtYmVyKSwgdHJ1ZSwgZmFsc2UpO1xyXG5cdFx0fSk7XHJcblxyXG5cdFx0Ly8gU2Vjb25kIHBhc3MuIE5vdyB0aGF0IGFsbCBiYXNlIHZhbHVlcyBhcmUgc2V0LCBhcHBseSBjb25zdHJhaW50c1xyXG5cdFx0c2NvcGVfSGFuZGxlTnVtYmVycy5mb3JFYWNoKGZ1bmN0aW9uKGhhbmRsZU51bWJlcil7XHJcblx0XHRcdHNldEhhbmRsZShoYW5kbGVOdW1iZXIsIHNjb3BlX0xvY2F0aW9uc1toYW5kbGVOdW1iZXJdLCB0cnVlLCB0cnVlKTtcclxuXHRcdH0pO1xyXG5cclxuXHRcdHNldFppbmRleCgpO1xyXG5cclxuXHRcdHNjb3BlX0hhbmRsZU51bWJlcnMuZm9yRWFjaChmdW5jdGlvbihoYW5kbGVOdW1iZXIpe1xyXG5cclxuXHRcdFx0ZmlyZUV2ZW50KCd1cGRhdGUnLCBoYW5kbGVOdW1iZXIpO1xyXG5cclxuXHRcdFx0Ly8gRmlyZSB0aGUgZXZlbnQgb25seSBmb3IgaGFuZGxlcyB0aGF0IHJlY2VpdmVkIGEgbmV3IHZhbHVlLCBhcyBwZXIgIzU3OVxyXG5cdFx0XHRpZiAoIHZhbHVlc1toYW5kbGVOdW1iZXJdICE9PSBudWxsICYmIGZpcmVTZXRFdmVudCApIHtcclxuXHRcdFx0XHRmaXJlRXZlbnQoJ3NldCcsIGhhbmRsZU51bWJlcik7XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cdH1cclxuXHJcblx0Ly8gUmVzZXQgc2xpZGVyIHRvIGluaXRpYWwgdmFsdWVzXHJcblx0ZnVuY3Rpb24gdmFsdWVSZXNldCAoIGZpcmVTZXRFdmVudCApIHtcclxuXHRcdHZhbHVlU2V0KG9wdGlvbnMuc3RhcnQsIGZpcmVTZXRFdmVudCk7XHJcblx0fVxyXG5cclxuXHQvLyBHZXQgdGhlIHNsaWRlciB2YWx1ZS5cclxuXHRmdW5jdGlvbiB2YWx1ZUdldCAoICkge1xyXG5cclxuXHRcdHZhciB2YWx1ZXMgPSBzY29wZV9WYWx1ZXMubWFwKG9wdGlvbnMuZm9ybWF0LnRvKTtcclxuXHJcblx0XHQvLyBJZiBvbmx5IG9uZSBoYW5kbGUgaXMgdXNlZCwgcmV0dXJuIGEgc2luZ2xlIHZhbHVlLlxyXG5cdFx0aWYgKCB2YWx1ZXMubGVuZ3RoID09PSAxICl7XHJcblx0XHRcdHJldHVybiB2YWx1ZXNbMF07XHJcblx0XHR9XHJcblxyXG5cdFx0cmV0dXJuIHZhbHVlcztcclxuXHR9XHJcblxyXG5cdC8vIFJlbW92ZXMgY2xhc3NlcyBmcm9tIHRoZSByb290IGFuZCBlbXB0aWVzIGl0LlxyXG5cdGZ1bmN0aW9uIGRlc3Ryb3kgKCApIHtcclxuXHJcblx0XHRmb3IgKCB2YXIga2V5IGluIG9wdGlvbnMuY3NzQ2xhc3NlcyApIHtcclxuXHRcdFx0aWYgKCAhb3B0aW9ucy5jc3NDbGFzc2VzLmhhc093blByb3BlcnR5KGtleSkgKSB7IGNvbnRpbnVlOyB9XHJcblx0XHRcdHJlbW92ZUNsYXNzKHNjb3BlX1RhcmdldCwgb3B0aW9ucy5jc3NDbGFzc2VzW2tleV0pO1xyXG5cdFx0fVxyXG5cclxuXHRcdHdoaWxlIChzY29wZV9UYXJnZXQuZmlyc3RDaGlsZCkge1xyXG5cdFx0XHRzY29wZV9UYXJnZXQucmVtb3ZlQ2hpbGQoc2NvcGVfVGFyZ2V0LmZpcnN0Q2hpbGQpO1xyXG5cdFx0fVxyXG5cclxuXHRcdGRlbGV0ZSBzY29wZV9UYXJnZXQubm9VaVNsaWRlcjtcclxuXHR9XHJcblxyXG5cdC8vIEdldCB0aGUgY3VycmVudCBzdGVwIHNpemUgZm9yIHRoZSBzbGlkZXIuXHJcblx0ZnVuY3Rpb24gZ2V0Q3VycmVudFN0ZXAgKCApIHtcclxuXHJcblx0XHQvLyBDaGVjayBhbGwgbG9jYXRpb25zLCBtYXAgdGhlbSB0byB0aGVpciBzdGVwcGluZyBwb2ludC5cclxuXHRcdC8vIEdldCB0aGUgc3RlcCBwb2ludCwgdGhlbiBmaW5kIGl0IGluIHRoZSBpbnB1dCBsaXN0LlxyXG5cdFx0cmV0dXJuIHNjb3BlX0xvY2F0aW9ucy5tYXAoZnVuY3Rpb24oIGxvY2F0aW9uLCBpbmRleCApe1xyXG5cclxuXHRcdFx0dmFyIG5lYXJieVN0ZXBzID0gc2NvcGVfU3BlY3RydW0uZ2V0TmVhcmJ5U3RlcHMoIGxvY2F0aW9uICk7XHJcblx0XHRcdHZhciB2YWx1ZSA9IHNjb3BlX1ZhbHVlc1tpbmRleF07XHJcblx0XHRcdHZhciBpbmNyZW1lbnQgPSBuZWFyYnlTdGVwcy50aGlzU3RlcC5zdGVwO1xyXG5cdFx0XHR2YXIgZGVjcmVtZW50ID0gbnVsbDtcclxuXHJcblx0XHRcdC8vIElmIHRoZSBuZXh0IHZhbHVlIGluIHRoaXMgc3RlcCBtb3ZlcyBpbnRvIHRoZSBuZXh0IHN0ZXAsXHJcblx0XHRcdC8vIHRoZSBpbmNyZW1lbnQgaXMgdGhlIHN0YXJ0IG9mIHRoZSBuZXh0IHN0ZXAgLSB0aGUgY3VycmVudCB2YWx1ZVxyXG5cdFx0XHRpZiAoIGluY3JlbWVudCAhPT0gZmFsc2UgKSB7XHJcblx0XHRcdFx0aWYgKCB2YWx1ZSArIGluY3JlbWVudCA+IG5lYXJieVN0ZXBzLnN0ZXBBZnRlci5zdGFydFZhbHVlICkge1xyXG5cdFx0XHRcdFx0aW5jcmVtZW50ID0gbmVhcmJ5U3RlcHMuc3RlcEFmdGVyLnN0YXJ0VmFsdWUgLSB2YWx1ZTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHJcblxyXG5cdFx0XHQvLyBJZiB0aGUgdmFsdWUgaXMgYmV5b25kIHRoZSBzdGFydGluZyBwb2ludFxyXG5cdFx0XHRpZiAoIHZhbHVlID4gbmVhcmJ5U3RlcHMudGhpc1N0ZXAuc3RhcnRWYWx1ZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBuZWFyYnlTdGVwcy50aGlzU3RlcC5zdGVwO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHRlbHNlIGlmICggbmVhcmJ5U3RlcHMuc3RlcEJlZm9yZS5zdGVwID09PSBmYWxzZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBmYWxzZTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0Ly8gSWYgYSBoYW5kbGUgaXMgYXQgdGhlIHN0YXJ0IG9mIGEgc3RlcCwgaXQgYWx3YXlzIHN0ZXBzIGJhY2sgaW50byB0aGUgcHJldmlvdXMgc3RlcCBmaXJzdFxyXG5cdFx0XHRlbHNlIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSB2YWx1ZSAtIG5lYXJieVN0ZXBzLnN0ZXBCZWZvcmUuaGlnaGVzdFN0ZXA7XHJcblx0XHRcdH1cclxuXHJcblxyXG5cdFx0XHQvLyBOb3csIGlmIGF0IHRoZSBzbGlkZXIgZWRnZXMsIHRoZXJlIGlzIG5vdCBpbi9kZWNyZW1lbnRcclxuXHRcdFx0aWYgKCBsb2NhdGlvbiA9PT0gMTAwICkge1xyXG5cdFx0XHRcdGluY3JlbWVudCA9IG51bGw7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdGVsc2UgaWYgKCBsb2NhdGlvbiA9PT0gMCApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBudWxsO1xyXG5cdFx0XHR9XHJcblxyXG5cdFx0XHQvLyBBcyBwZXIgIzM5MSwgdGhlIGNvbXBhcmlzb24gZm9yIHRoZSBkZWNyZW1lbnQgc3RlcCBjYW4gaGF2ZSBzb21lIHJvdW5kaW5nIGlzc3Vlcy5cclxuXHRcdFx0dmFyIHN0ZXBEZWNpbWFscyA9IHNjb3BlX1NwZWN0cnVtLmNvdW50U3RlcERlY2ltYWxzKCk7XHJcblxyXG5cdFx0XHQvLyBSb3VuZCBwZXIgIzM5MVxyXG5cdFx0XHRpZiAoIGluY3JlbWVudCAhPT0gbnVsbCAmJiBpbmNyZW1lbnQgIT09IGZhbHNlICkge1xyXG5cdFx0XHRcdGluY3JlbWVudCA9IE51bWJlcihpbmNyZW1lbnQudG9GaXhlZChzdGVwRGVjaW1hbHMpKTtcclxuXHRcdFx0fVxyXG5cclxuXHRcdFx0aWYgKCBkZWNyZW1lbnQgIT09IG51bGwgJiYgZGVjcmVtZW50ICE9PSBmYWxzZSApIHtcclxuXHRcdFx0XHRkZWNyZW1lbnQgPSBOdW1iZXIoZGVjcmVtZW50LnRvRml4ZWQoc3RlcERlY2ltYWxzKSk7XHJcblx0XHRcdH1cclxuXHJcblx0XHRcdHJldHVybiBbZGVjcmVtZW50LCBpbmNyZW1lbnRdO1xyXG5cdFx0fSk7XHJcblx0fVxyXG5cclxuXHQvLyBVcGRhdGVhYmxlOiBtYXJnaW4sIGxpbWl0LCBwYWRkaW5nLCBzdGVwLCByYW5nZSwgYW5pbWF0ZSwgc25hcFxyXG5cdGZ1bmN0aW9uIHVwZGF0ZU9wdGlvbnMgKCBvcHRpb25zVG9VcGRhdGUsIGZpcmVTZXRFdmVudCApIHtcclxuXHJcblx0XHQvLyBTcGVjdHJ1bSBpcyBjcmVhdGVkIHVzaW5nIHRoZSByYW5nZSwgc25hcCwgZGlyZWN0aW9uIGFuZCBzdGVwIG9wdGlvbnMuXHJcblx0XHQvLyAnc25hcCcgYW5kICdzdGVwJyBjYW4gYmUgdXBkYXRlZC5cclxuXHRcdC8vIElmICdzbmFwJyBhbmQgJ3N0ZXAnIGFyZSBub3QgcGFzc2VkLCB0aGV5IHNob3VsZCByZW1haW4gdW5jaGFuZ2VkLlxyXG5cdFx0dmFyIHYgPSB2YWx1ZUdldCgpO1xyXG5cclxuXHRcdHZhciB1cGRhdGVBYmxlID0gWydtYXJnaW4nLCAnbGltaXQnLCAncGFkZGluZycsICdyYW5nZScsICdhbmltYXRlJywgJ3NuYXAnLCAnc3RlcCcsICdmb3JtYXQnXTtcclxuXHJcblx0XHQvLyBPbmx5IGNoYW5nZSBvcHRpb25zIHRoYXQgd2UncmUgYWN0dWFsbHkgcGFzc2VkIHRvIHVwZGF0ZS5cclxuXHRcdHVwZGF0ZUFibGUuZm9yRWFjaChmdW5jdGlvbihuYW1lKXtcclxuXHRcdFx0aWYgKCBvcHRpb25zVG9VcGRhdGVbbmFtZV0gIT09IHVuZGVmaW5lZCApIHtcclxuXHRcdFx0XHRvcmlnaW5hbE9wdGlvbnNbbmFtZV0gPSBvcHRpb25zVG9VcGRhdGVbbmFtZV07XHJcblx0XHRcdH1cclxuXHRcdH0pO1xyXG5cclxuXHRcdHZhciBuZXdPcHRpb25zID0gdGVzdE9wdGlvbnMob3JpZ2luYWxPcHRpb25zKTtcclxuXHJcblx0XHQvLyBMb2FkIG5ldyBvcHRpb25zIGludG8gdGhlIHNsaWRlciBzdGF0ZVxyXG5cdFx0dXBkYXRlQWJsZS5mb3JFYWNoKGZ1bmN0aW9uKG5hbWUpe1xyXG5cdFx0XHRpZiAoIG9wdGlvbnNUb1VwZGF0ZVtuYW1lXSAhPT0gdW5kZWZpbmVkICkge1xyXG5cdFx0XHRcdG9wdGlvbnNbbmFtZV0gPSBuZXdPcHRpb25zW25hbWVdO1xyXG5cdFx0XHR9XHJcblx0XHR9KTtcclxuXHJcblx0XHRzY29wZV9TcGVjdHJ1bSA9IG5ld09wdGlvbnMuc3BlY3RydW07XHJcblxyXG5cdFx0Ly8gTGltaXQsIG1hcmdpbiBhbmQgcGFkZGluZyBkZXBlbmQgb24gdGhlIHNwZWN0cnVtIGJ1dCBhcmUgc3RvcmVkIG91dHNpZGUgb2YgaXQuICgjNjc3KVxyXG5cdFx0b3B0aW9ucy5tYXJnaW4gPSBuZXdPcHRpb25zLm1hcmdpbjtcclxuXHRcdG9wdGlvbnMubGltaXQgPSBuZXdPcHRpb25zLmxpbWl0O1xyXG5cdFx0b3B0aW9ucy5wYWRkaW5nID0gbmV3T3B0aW9ucy5wYWRkaW5nO1xyXG5cclxuXHRcdC8vIFVwZGF0ZSBwaXBzLCByZW1vdmVzIGV4aXN0aW5nLlxyXG5cdFx0aWYgKCBvcHRpb25zLnBpcHMgKSB7XHJcblx0XHRcdHBpcHMob3B0aW9ucy5waXBzKTtcclxuXHRcdH1cclxuXHJcblx0XHQvLyBJbnZhbGlkYXRlIHRoZSBjdXJyZW50IHBvc2l0aW9uaW5nIHNvIHZhbHVlU2V0IGZvcmNlcyBhbiB1cGRhdGUuXHJcblx0XHRzY29wZV9Mb2NhdGlvbnMgPSBbXTtcclxuXHRcdHZhbHVlU2V0KG9wdGlvbnNUb1VwZGF0ZS5zdGFydCB8fCB2LCBmaXJlU2V0RXZlbnQpO1xyXG5cdH1cclxuXHJcbi8qISBJbiB0aGlzIGZpbGU6IENhbGxzIHRvIGZ1bmN0aW9ucy4gQWxsIG90aGVyIHNjb3BlXyBmaWxlcyBkZWZpbmUgZnVuY3Rpb25zIG9ubHk7ICovXHJcblxyXG5cdC8vIENyZWF0ZSB0aGUgYmFzZSBlbGVtZW50LCBpbml0aWFsaXplIEhUTUwgYW5kIHNldCBjbGFzc2VzLlxyXG5cdC8vIEFkZCBoYW5kbGVzIGFuZCBjb25uZWN0IGVsZW1lbnRzLlxyXG5cdGFkZFNsaWRlcihzY29wZV9UYXJnZXQpO1xyXG5cdGFkZEVsZW1lbnRzKG9wdGlvbnMuY29ubmVjdCwgc2NvcGVfQmFzZSk7XHJcblxyXG5cdC8vIEF0dGFjaCB1c2VyIGV2ZW50cy5cclxuXHRiaW5kU2xpZGVyRXZlbnRzKG9wdGlvbnMuZXZlbnRzKTtcclxuXHJcblx0Ly8gVXNlIHRoZSBwdWJsaWMgdmFsdWUgbWV0aG9kIHRvIHNldCB0aGUgc3RhcnQgdmFsdWVzLlxyXG5cdHZhbHVlU2V0KG9wdGlvbnMuc3RhcnQpO1xyXG5cclxuXHRzY29wZV9TZWxmID0ge1xyXG5cdFx0ZGVzdHJveTogZGVzdHJveSxcclxuXHRcdHN0ZXBzOiBnZXRDdXJyZW50U3RlcCxcclxuXHRcdG9uOiBiaW5kRXZlbnQsXHJcblx0XHRvZmY6IHJlbW92ZUV2ZW50LFxyXG5cdFx0Z2V0OiB2YWx1ZUdldCxcclxuXHRcdHNldDogdmFsdWVTZXQsXHJcblx0XHRyZXNldDogdmFsdWVSZXNldCxcclxuXHRcdC8vIEV4cG9zZWQgZm9yIHVuaXQgdGVzdGluZywgZG9uJ3QgdXNlIHRoaXMgaW4geW91ciBhcHBsaWNhdGlvbi5cclxuXHRcdF9fbW92ZUhhbmRsZXM6IGZ1bmN0aW9uKGEsIGIsIGMpIHsgbW92ZUhhbmRsZXMoYSwgYiwgc2NvcGVfTG9jYXRpb25zLCBjKTsgfSxcclxuXHRcdG9wdGlvbnM6IG9yaWdpbmFsT3B0aW9ucywgLy8gSXNzdWUgIzYwMCwgIzY3OFxyXG5cdFx0dXBkYXRlT3B0aW9uczogdXBkYXRlT3B0aW9ucyxcclxuXHRcdHRhcmdldDogc2NvcGVfVGFyZ2V0LCAvLyBJc3N1ZSAjNTk3XHJcblx0XHRyZW1vdmVQaXBzOiByZW1vdmVQaXBzLFxyXG5cdFx0cGlwczogcGlwcyAvLyBJc3N1ZSAjNTk0XHJcblx0fTtcclxuXHJcblx0aWYgKCBvcHRpb25zLnBpcHMgKSB7XHJcblx0XHRwaXBzKG9wdGlvbnMucGlwcyk7XHJcblx0fVxyXG5cclxuXHRpZiAoIG9wdGlvbnMudG9vbHRpcHMgKSB7XHJcblx0XHR0b29sdGlwcygpO1xyXG5cdH1cclxuXHJcblx0YXJpYSgpO1xyXG5cclxuXHRyZXR1cm4gc2NvcGVfU2VsZjtcclxuXHJcbn1cclxuXHJcblxyXG5cdC8vIFJ1biB0aGUgc3RhbmRhcmQgaW5pdGlhbGl6ZXJcclxuXHRmdW5jdGlvbiBpbml0aWFsaXplICggdGFyZ2V0LCBvcmlnaW5hbE9wdGlvbnMgKSB7XHJcblxyXG5cdFx0aWYgKCAhdGFyZ2V0IHx8ICF0YXJnZXQubm9kZU5hbWUgKSB7XHJcblx0XHRcdHRocm93IG5ldyBFcnJvcihcIm5vVWlTbGlkZXIgKFwiICsgVkVSU0lPTiArIFwiKTogY3JlYXRlIHJlcXVpcmVzIGEgc2luZ2xlIGVsZW1lbnQsIGdvdDogXCIgKyB0YXJnZXQpO1xyXG5cdFx0fVxyXG5cclxuXHRcdC8vIFRocm93IGFuIGVycm9yIGlmIHRoZSBzbGlkZXIgd2FzIGFscmVhZHkgaW5pdGlhbGl6ZWQuXHJcblx0XHRpZiAoIHRhcmdldC5ub1VpU2xpZGVyICkge1xyXG5cdFx0XHR0aHJvdyBuZXcgRXJyb3IoXCJub1VpU2xpZGVyIChcIiArIFZFUlNJT04gKyBcIik6IFNsaWRlciB3YXMgYWxyZWFkeSBpbml0aWFsaXplZC5cIik7XHJcblx0XHR9XHJcblxyXG5cdFx0Ly8gVGVzdCB0aGUgb3B0aW9ucyBhbmQgY3JlYXRlIHRoZSBzbGlkZXIgZW52aXJvbm1lbnQ7XHJcblx0XHR2YXIgb3B0aW9ucyA9IHRlc3RPcHRpb25zKCBvcmlnaW5hbE9wdGlvbnMsIHRhcmdldCApO1xyXG5cdFx0dmFyIGFwaSA9IHNjb3BlKCB0YXJnZXQsIG9wdGlvbnMsIG9yaWdpbmFsT3B0aW9ucyApO1xyXG5cclxuXHRcdHRhcmdldC5ub1VpU2xpZGVyID0gYXBpO1xyXG5cclxuXHRcdHJldHVybiBhcGk7XHJcblx0fVxyXG5cclxuXHQvLyBVc2UgYW4gb2JqZWN0IGluc3RlYWQgb2YgYSBmdW5jdGlvbiBmb3IgZnV0dXJlIGV4cGFuZGFiaWxpdHk7XHJcblx0cmV0dXJuIHtcclxuXHRcdHZlcnNpb246IFZFUlNJT04sXHJcblx0XHRjcmVhdGU6IGluaXRpYWxpemVcclxuXHR9O1xyXG5cclxufSkpOyIsIlxyXG52YXIgZmllbGRzID0ge1xyXG5cdFxyXG5cdGZ1bmN0aW9uczoge31cclxuXHRcclxufTtcclxuXHJcbm1vZHVsZS5leHBvcnRzID0gZmllbGRzOyIsIlxyXG4vL3ZhciBzdGF0ZSA9IHJlcXVpcmUoJy4vaW5jbHVkZXMvc3RhdGUnKTtcclxuXHJcbnZhciBwYWdpbmF0aW9uID0ge1xyXG5cdFxyXG5cdHNldHVwTGVnYWN5OiBmdW5jdGlvbigpe1xyXG5cdFx0XHJcblx0XHRcclxuXHR9LFxyXG5cdFxyXG5cdHNldHVwTGVnYWN5OiBmdW5jdGlvbigpe1xyXG5cdFx0XHJcblx0XHQvKmlmKHR5cGVvZihzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpIT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHR2YXIgJGFqYXhfbGlua3Nfb2JqZWN0ID0galF1ZXJ5KHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcblx0XHRcdFxyXG5cdFx0XHRpZigkYWpheF9saW5rc19vYmplY3QubGVuZ3RoPjApXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkYWpheF9saW5rc19vYmplY3Qub24oJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRlLnByZXZlbnREZWZhdWx0KCk7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdHZhciBsaW5rID0galF1ZXJ5KHRoaXMpLmF0dHIoJ2hyZWYnKTtcclxuXHRcdFx0XHRcdHNlbGYuYWpheF9hY3Rpb24gPSBcInBhZ2luYXRpb25cIjtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0c2VsZi5mZXRjaExlZ2FjeUFqYXhSZXN1bHRzKGxpbmspO1xyXG5cdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHR9XHJcblx0XHR9Ki9cclxuXHR9XHJcbn07XHJcblxyXG5tb2R1bGUuZXhwb3J0cyA9IHBhZ2luYXRpb247IiwiKGZ1bmN0aW9uIChnbG9iYWwpe1xuXHJcbnZhciAkIFx0XHRcdFx0PSAodHlwZW9mIHdpbmRvdyAhPT0gXCJ1bmRlZmluZWRcIiA/IHdpbmRvd1snalF1ZXJ5J10gOiB0eXBlb2YgZ2xvYmFsICE9PSBcInVuZGVmaW5lZFwiID8gZ2xvYmFsWydqUXVlcnknXSA6IG51bGwpO1xyXG52YXIgc3RhdGUgXHRcdFx0PSByZXF1aXJlKCcuL3N0YXRlJyk7XHJcbnZhciBwcm9jZXNzX2Zvcm0gXHQ9IHJlcXVpcmUoJy4vcHJvY2Vzc19mb3JtJyk7XHJcbnZhciBub1VpU2xpZGVyXHRcdD0gcmVxdWlyZSgnbm91aXNsaWRlcicpO1xyXG52YXIgY29va2llcyAgICAgICAgID0gcmVxdWlyZSgnanMtY29va2llJyk7XHJcblxyXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uKG9wdGlvbnMpXHJcbntcclxuICAgIHZhciBkZWZhdWx0cyA9IHtcclxuICAgICAgICBzdGFydE9wZW5lZDogZmFsc2UsXHJcbiAgICAgICAgaXNJbml0OiB0cnVlLFxyXG4gICAgICAgIGFjdGlvbjogXCJcIlxyXG4gICAgfTtcclxuXHJcbiAgICB2YXIgb3B0cyA9IGpRdWVyeS5leHRlbmQoZGVmYXVsdHMsIG9wdGlvbnMpO1xyXG5cclxuICAgIC8vbG9vcCB0aHJvdWdoIGVhY2ggaXRlbSBtYXRjaGVkXHJcbiAgICB0aGlzLmVhY2goZnVuY3Rpb24oKVxyXG4gICAge1xyXG5cclxuICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuICAgICAgICB0aGlzLnNmaWQgPSAkdGhpcy5hdHRyKFwiZGF0YS1zZi1mb3JtLWlkXCIpO1xyXG5cclxuICAgICAgICBzdGF0ZS5hZGRTZWFyY2hGb3JtKHRoaXMuc2ZpZCwgdGhpcyk7XHJcblxyXG4gICAgICAgIHRoaXMuJGZpZWxkcyA9ICR0aGlzLmZpbmQoXCI+IHVsID4gbGlcIik7IC8vYSByZWZlcmVuY2UgdG8gZWFjaCBmaWVsZHMgcGFyZW50IExJXHJcblxyXG4gICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gJHRoaXMuYXR0cignZGF0YS10YXhvbm9teS1hcmNoaXZlcycpO1xyXG4gICAgICAgIHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlID0gJHRoaXMuYXR0cignZGF0YS1jdXJyZW50LXRheG9ub215LWFyY2hpdmUnKTtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuZW5hYmxlX3RheG9ub215X2FyY2hpdmVzID0gXCIwXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmN1cnJlbnRfdGF4b25vbXlfYXJjaGl2ZSA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBwcm9jZXNzX2Zvcm0uaW5pdChzZWxmLmVuYWJsZV90YXhvbm9teV9hcmNoaXZlcywgc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUpO1xyXG4gICAgICAgIC8vcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYpO1xyXG4gICAgICAgIHByb2Nlc3NfZm9ybS5lbmFibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmV4dHJhX3F1ZXJ5X3BhcmFtcyA9IHthbGw6IHt9LCByZXN1bHRzOiB7fSwgYWpheDoge319O1xyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMudGVtcGxhdGVfaXNfbG9hZGVkID0gJHRoaXMuYXR0cihcImRhdGEtdGVtcGxhdGUtbG9hZGVkXCIpO1xyXG4gICAgICAgIHRoaXMuaXNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXhcIik7XHJcbiAgICAgICAgdGhpcy5pbnN0YW5jZV9udW1iZXIgPSAkdGhpcy5hdHRyKCdkYXRhLWluc3RhbmNlLWNvdW50Jyk7XHJcbiAgICAgICAgdGhpcy4kYWpheF9yZXN1bHRzX2NvbnRhaW5lciA9IGpRdWVyeSgkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXRhcmdldFwiKSk7XHJcblxyXG4gICAgICAgIHRoaXMucmVzdWx0c191cmwgPSAkdGhpcy5hdHRyKFwiZGF0YS1yZXN1bHRzLXVybFwiKTtcclxuICAgICAgICB0aGlzLmRlYnVnX21vZGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWJ1Zy1tb2RlXCIpO1xyXG4gICAgICAgIHRoaXMudXBkYXRlX2FqYXhfdXJsID0gJHRoaXMuYXR0cihcImRhdGEtdXBkYXRlLWFqYXgtdXJsXCIpO1xyXG4gICAgICAgIHRoaXMucGFnaW5hdGlvbl90eXBlID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC1wYWdpbmF0aW9uLXR5cGVcIik7XHJcbiAgICAgICAgdGhpcy5hdXRvX2NvdW50ID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by1jb3VudFwiKTtcclxuICAgICAgICB0aGlzLmF1dG9fY291bnRfcmVmcmVzaF9tb2RlID0gJHRoaXMuYXR0cihcImRhdGEtYXV0by1jb3VudC1yZWZyZXNoLW1vZGVcIik7XHJcbiAgICAgICAgdGhpcy5vbmx5X3Jlc3VsdHNfYWpheCA9ICR0aGlzLmF0dHIoXCJkYXRhLW9ubHktcmVzdWx0cy1hamF4XCIpOyAvL2lmIHdlIGFyZSBub3Qgb24gdGhlIHJlc3VsdHMgcGFnZSwgcmVkaXJlY3QgcmF0aGVyIHRoYW4gdHJ5IHRvIGxvYWQgdmlhIGFqYXhcclxuICAgICAgICB0aGlzLnNjcm9sbF90b19wb3MgPSAkdGhpcy5hdHRyKFwiZGF0YS1zY3JvbGwtdG8tcG9zXCIpO1xyXG4gICAgICAgIHRoaXMuY3VzdG9tX3Njcm9sbF90byA9ICR0aGlzLmF0dHIoXCJkYXRhLWN1c3RvbS1zY3JvbGwtdG9cIik7XHJcbiAgICAgICAgdGhpcy5zY3JvbGxfb25fYWN0aW9uID0gJHRoaXMuYXR0cihcImRhdGEtc2Nyb2xsLW9uLWFjdGlvblwiKTtcclxuICAgICAgICB0aGlzLmxhbmdfY29kZSA9ICR0aGlzLmF0dHIoXCJkYXRhLWxhbmctY29kZVwiKTtcclxuICAgICAgICB0aGlzLmFqYXhfdXJsID0gJHRoaXMuYXR0cignZGF0YS1hamF4LXVybCcpO1xyXG4gICAgICAgIHRoaXMuYWpheF9mb3JtX3VybCA9ICR0aGlzLmF0dHIoJ2RhdGEtYWpheC1mb3JtLXVybCcpO1xyXG4gICAgICAgIHRoaXMuaXNfcnRsID0gJHRoaXMuYXR0cignZGF0YS1pcy1ydGwnKTtcclxuXHJcbiAgICAgICAgdGhpcy5kaXNwbGF5X3Jlc3VsdF9tZXRob2QgPSAkdGhpcy5hdHRyKCdkYXRhLWRpc3BsYXktcmVzdWx0LW1ldGhvZCcpO1xyXG4gICAgICAgIHRoaXMubWFpbnRhaW5fc3RhdGUgPSAkdGhpcy5hdHRyKCdkYXRhLW1haW50YWluLXN0YXRlJyk7XHJcbiAgICAgICAgdGhpcy5hamF4X2FjdGlvbiA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICB0aGlzLmN1cnJlbnRfcGFnZWQgPSBwYXJzZUludCgkdGhpcy5hdHRyKCdkYXRhLWluaXQtcGFnZWQnKSk7XHJcbiAgICAgICAgdGhpcy5sYXN0X2xvYWRfbW9yZV9odG1sID0gXCJcIjtcclxuICAgICAgICB0aGlzLmxvYWRfbW9yZV9odG1sID0gXCJcIjtcclxuICAgICAgICB0aGlzLmFqYXhfZGF0YV90eXBlID0gJHRoaXMuYXR0cignZGF0YS1hamF4LWRhdGEtdHlwZScpO1xyXG4gICAgICAgIHRoaXMuYWpheF90YXJnZXRfYXR0ciA9ICR0aGlzLmF0dHIoXCJkYXRhLWFqYXgtdGFyZ2V0XCIpO1xyXG4gICAgICAgIHRoaXMudXNlX2hpc3RvcnlfYXBpID0gJHRoaXMuYXR0cihcImRhdGEtdXNlLWhpc3RvcnktYXBpXCIpO1xyXG4gICAgICAgIHRoaXMuaXNfc3VibWl0dGluZyA9IGZhbHNlO1xyXG5cclxuICAgICAgICB0aGlzLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMudXNlX2hpc3RvcnlfYXBpKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMudXNlX2hpc3RvcnlfYXBpID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnBhZ2luYXRpb25fdHlwZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnBhZ2luYXRpb25fdHlwZSA9IFwibm9ybWFsXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1cnJlbnRfcGFnZWQpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5jdXJyZW50X3BhZ2VkID0gMTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdGFyZ2V0X2F0dHIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hamF4X3RhcmdldF9hdHRyID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmFqYXhfdXJsKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF9mb3JtX3VybCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmFqYXhfZm9ybV91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMucmVzdWx0c191cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5zY3JvbGxfdG9fcG9zKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuc2Nyb2xsX3RvX3BvcyA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy5zY3JvbGxfb25fYWN0aW9uKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuc2Nyb2xsX29uX2FjdGlvbiA9IFwiXCI7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLmN1c3RvbV9zY3JvbGxfdG8pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5jdXN0b21fc2Nyb2xsX3RvID0gXCJcIjtcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy4kY3VzdG9tX3Njcm9sbF90byA9IGpRdWVyeSh0aGlzLmN1c3RvbV9zY3JvbGxfdG8pO1xyXG5cclxuICAgICAgICBpZih0eXBlb2YodGhpcy51cGRhdGVfYWpheF91cmwpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy51cGRhdGVfYWpheF91cmwgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuZGVidWdfbW9kZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLmRlYnVnX21vZGUgPSBcIlwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYWpheF90YXJnZXRfb2JqZWN0KT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHRoaXMuYWpheF90YXJnZXRfb2JqZWN0ID0gXCJcIjtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmKHR5cGVvZih0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB0aGlzLnRlbXBsYXRlX2lzX2xvYWRlZCA9IFwiMFwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdGhpcy5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZSA9IFwiMFwiO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5hamF4X2xpbmtzX3NlbGVjdG9yID0gJHRoaXMuYXR0cihcImRhdGEtYWpheC1saW5rcy1zZWxlY3RvclwiKTtcclxuXHJcblxyXG4gICAgICAgIHRoaXMuYXV0b191cGRhdGUgPSAkdGhpcy5hdHRyKFwiZGF0YS1hdXRvLXVwZGF0ZVwiKTtcclxuICAgICAgICB0aGlzLmlucHV0VGltZXIgPSAwO1xyXG5cclxuICAgICAgICB0aGlzLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgIHRoaXMuaXNfbWF4X3BhZ2VkID0gZmFsc2U7IC8vZm9yIGxvYWQgbW9yZSBvbmx5LCBvbmNlIHdlIGRldGVjdCB3ZSdyZSBhdCB0aGUgZW5kIHNldCB0aGlzIHRvIHRydWVcclxuICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9ICR0aGlzLmF0dHIoJ2RhdGEtc2hvdy1zY3JvbGwtbG9hZGVyJyk7XHJcbiAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpO1xyXG4gICAgICAgICAgICB0aGlzLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCA9ICR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLXRyaWdnZXInKTtcclxuICAgICAgICAgICAgdGhpcy5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzID0gJHRoaXMuYXR0cignZGF0YS1pbmZpbml0ZS1zY3JvbGwtcmVzdWx0LWNsYXNzJyk7XHJcbiAgICAgICAgICAgIHRoaXMuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIgPSB0aGlzLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyO1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB0aGlzLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyID0galF1ZXJ5KCR0aGlzLmF0dHIoJ2RhdGEtaW5maW5pdGUtc2Nyb2xsLWNvbnRhaW5lcicpKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHRoaXMuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZih0aGlzLnVzZV9zY3JvbGxfbG9hZGVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdGhpcy51c2Vfc2Nyb2xsX2xvYWRlciA9IDE7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLnNldEluZmluaXRlU2Nyb2xsQ29udGFpbmVyKCk7XHJcblxyXG4gICAgICAgIC8qIGZ1bmN0aW9ucyAqL1xyXG5cclxuICAgICAgICB0aGlzLnJlc2V0ID0gZnVuY3Rpb24oc3VibWl0X2Zvcm0pXHJcbiAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgdGhpcy5yZXNldEZvcm0oc3VibWl0X2Zvcm0pO1xyXG4gICAgICAgICAgICByZXR1cm4gdHJ1ZTtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuaW5wdXRVcGRhdGUgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGRlbGF5RHVyYXRpb24pPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGVsYXlEdXJhdGlvbiA9IDMwMDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5yZXNldFRpbWVyKGRlbGF5RHVyYXRpb24pO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zY3JvbGxUb1BvcyA9IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICB2YXIgb2Zmc2V0ID0gMDtcclxuICAgICAgICAgICAgdmFyIGNhblNjcm9sbCA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJ3aW5kb3dcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAwO1xyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImZvcm1cIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSAkdGhpcy5vZmZzZXQoKS50b3A7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHNlbGYuc2Nyb2xsX3RvX3Bvcz09XCJyZXN1bHRzXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9mZnNldCA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIub2Zmc2V0KCkudG9wO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5zY3JvbGxfdG9fcG9zPT1cImN1c3RvbVwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vY3VzdG9tX3Njcm9sbF90b1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYuJGN1c3RvbV9zY3JvbGxfdG8ubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBvZmZzZXQgPSBzZWxmLiRjdXN0b21fc2Nyb2xsX3RvLm9mZnNldCgpLnRvcDtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgY2FuU2Nyb2xsID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoY2FuU2Nyb2xsKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICQoXCJodG1sLCBib2R5XCIpLnN0b3AoKS5hbmltYXRlKHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2Nyb2xsVG9wOiBvZmZzZXRcclxuICAgICAgICAgICAgICAgICAgICB9LCBcIm5vcm1hbFwiLCBcImVhc2VPdXRRdWFkXCIgKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmF0dGFjaEFjdGl2ZUNsYXNzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8vY2hlY2sgdG8gc2VlIGlmIHdlIGFyZSB1c2luZyBhamF4ICYgYXV0byBjb3VudFxyXG4gICAgICAgICAgICAvL2lmIG5vdCwgdGhlIHNlYXJjaCBmb3JtIGRvZXMgbm90IGdldCByZWxvYWRlZCwgc28gd2UgbmVlZCB0byB1cGRhdGUgdGhlIHNmLW9wdGlvbi1hY3RpdmUgY2xhc3Mgb24gYWxsIGZpZWxkc1xyXG5cclxuICAgICAgICAgICAgJHRoaXMub24oJ2NoYW5nZScsICdpbnB1dFt0eXBlPVwicmFkaW9cIl0sIGlucHV0W3R5cGU9XCJjaGVja2JveFwiXSwgc2VsZWN0JywgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyICRjdGhpcyA9ICQodGhpcyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGN0aGlzX3BhcmVudCA9ICRjdGhpcy5jbG9zZXN0KFwibGlbZGF0YS1zZi1maWVsZC1uYW1lXVwiKTtcclxuICAgICAgICAgICAgICAgIHZhciB0aGlzX3RhZyA9ICRjdGhpcy5wcm9wKFwidGFnTmFtZVwiKS50b0xvd2VyQ2FzZSgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIGlucHV0X3R5cGUgPSAkY3RoaXMuYXR0cihcInR5cGVcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgcGFyZW50X3RhZyA9ICRjdGhpc19wYXJlbnQucHJvcChcInRhZ05hbWVcIikudG9Mb3dlckNhc2UoKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigodGhpc190YWc9PVwiaW5wdXRcIikmJigoaW5wdXRfdHlwZT09XCJyYWRpb1wiKXx8KGlucHV0X3R5cGU9PVwiY2hlY2tib3hcIikpICYmIChwYXJlbnRfdGFnPT1cImxpXCIpKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2xpJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRhbGxfb3B0aW9uc19maWVsZHMgPSAkY3RoaXNfcGFyZW50LnBhcmVudCgpLmZpbmQoJ2lucHV0OmNoZWNrZWQnKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJGFsbF9vcHRpb25zLnJlbW92ZUNsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnNfZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkcGFyZW50ID0gJCh0aGlzKS5jbG9zZXN0KFwibGlcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRwYXJlbnQuYWRkQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmKHRoaXNfdGFnPT1cInNlbGVjdFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkYWxsX29wdGlvbnMgPSAkY3RoaXMuY2hpbGRyZW4oKTtcclxuICAgICAgICAgICAgICAgICAgICAkYWxsX29wdGlvbnMucmVtb3ZlQ2xhc3MoXCJzZi1vcHRpb24tYWN0aXZlXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciB0aGlzX3ZhbCA9ICRjdGhpcy52YWwoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRoaXNfYXJyX3ZhbCA9ICh0eXBlb2YgdGhpc192YWwgPT0gJ3N0cmluZycgfHwgdGhpc192YWwgaW5zdGFuY2VvZiBTdHJpbmcpID8gW3RoaXNfdmFsXSA6IHRoaXNfdmFsO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkKHRoaXNfYXJyX3ZhbCkuZWFjaChmdW5jdGlvbihpLCB2YWx1ZSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjdGhpcy5maW5kKFwib3B0aW9uW3ZhbHVlPSdcIit2YWx1ZStcIiddXCIpLmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLmluaXRBdXRvVXBkYXRlRXZlbnRzID0gZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgIC8qIGF1dG8gdXBkYXRlICovXHJcbiAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignY2hhbmdlJywgJ2lucHV0W3R5cGU9XCJyYWRpb1wiXSwgaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdLCBzZWxlY3QnLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5pbnB1dFVwZGF0ZSgyMDApO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy8kdGhpcy5vbignY2hhbmdlJywgJy5tZXRhLXNsaWRlcicsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICAgICAgICAgIC8vICAgIHNlbGYuaW5wdXRVcGRhdGUoMjAwKTtcclxuICAgICAgICAgICAgICAgIC8vICAgIGNvbnNvbGUubG9nKFwiQ0hBTkdFIE1FVEEgU0xJREVSXCIpO1xyXG4gICAgICAgICAgICAgICAgLy99KTtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5vbignaW5wdXQnLCAnaW5wdXRbdHlwZT1cIm51bWJlclwiXScsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDgwMCk7XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJHRleHRJbnB1dCA9ICR0aGlzLmZpbmQoJ2lucHV0W3R5cGU9XCJ0ZXh0XCJdOm5vdCguc2YtZGF0ZXBpY2tlciknKTtcclxuICAgICAgICAgICAgICAgIHZhciBsYXN0VmFsdWUgPSAkdGV4dElucHV0LnZhbCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdpbnB1dCcsICdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJywgZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKGxhc3RWYWx1ZSE9JHRleHRJbnB1dC52YWwoKSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMTIwMCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBsYXN0VmFsdWUgPSAkdGV4dElucHV0LnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLm9uKCdrZXlwcmVzcycsICdpbnB1dFt0eXBlPVwidGV4dFwiXTpub3QoLnNmLWRhdGVwaWNrZXIpJywgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoZS53aGljaCA9PSAxMyl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vJHRoaXMub24oJ2lucHV0JywgJ2lucHV0LnNmLWRhdGVwaWNrZXInLCBzZWxmLmRhdGVJbnB1dFR5cGUpO1xyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIC8vdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cygpO1xyXG5cclxuXHJcbiAgICAgICAgdGhpcy5jbGVhclRpbWVyID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgY2xlYXJUaW1lb3V0KHNlbGYuaW5wdXRUaW1lcik7XHJcbiAgICAgICAgfTtcclxuICAgICAgICB0aGlzLnJlc2V0VGltZXIgPSBmdW5jdGlvbihkZWxheUR1cmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgY2xlYXJUaW1lb3V0KHNlbGYuaW5wdXRUaW1lcik7XHJcbiAgICAgICAgICAgIHNlbGYuaW5wdXRUaW1lciA9IHNldFRpbWVvdXQoc2VsZi5mb3JtVXBkYXRlZCwgZGVsYXlEdXJhdGlvbik7XHJcblxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuYWRkRGF0ZVBpY2tlcnMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJGRhdGVfcGlja2VyID0gJHRoaXMuZmluZChcIi5zZi1kYXRlcGlja2VyXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJGRhdGVfcGlja2VyLmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkZGF0ZV9waWNrZXIuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRm9ybWF0ID0gXCJcIjtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGF0ZURyb3Bkb3duWWVhciA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlRHJvcGRvd25Nb250aCA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGNsb3Nlc3RfZGF0ZV93cmFwID0gJHRoaXMuY2xvc2VzdChcIi5zZl9kYXRlX2ZpZWxkXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKCRjbG9zZXN0X2RhdGVfd3JhcC5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRhdGVGb3JtYXQgPSAkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS1mb3JtYXRcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkY2xvc2VzdF9kYXRlX3dyYXAuYXR0cihcImRhdGEtZGF0ZS11c2UteWVhci1kcm9wZG93blwiKT09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGF0ZURyb3Bkb3duWWVhciA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGNsb3Nlc3RfZGF0ZV93cmFwLmF0dHIoXCJkYXRhLWRhdGUtdXNlLW1vbnRoLWRyb3Bkb3duXCIpPT0xKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkYXRlRHJvcGRvd25Nb250aCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkYXRlUGlja2VyT3B0aW9ucyA9IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaW5saW5lOiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzaG93T3RoZXJNb250aHM6IHRydWUsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9uU2VsZWN0OiBmdW5jdGlvbihlLCBmcm9tX2ZpZWxkKXsgc2VsZi5kYXRlU2VsZWN0KGUsIGZyb21fZmllbGQsICQodGhpcykpOyB9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlRm9ybWF0OiBkYXRlRm9ybWF0LFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgY2hhbmdlTW9udGg6IGRhdGVEcm9wZG93bk1vbnRoLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjaGFuZ2VZZWFyOiBkYXRlRHJvcGRvd25ZZWFyXHJcbiAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBkYXRlUGlja2VyT3B0aW9ucy5kaXJlY3Rpb24gPSBcInJ0bFwiO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgJHRoaXMuZGF0ZXBpY2tlcihkYXRlUGlja2VyT3B0aW9ucyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHNlbGYubGFuZ19jb2RlIT1cIlwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnNldERlZmF1bHRzKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5leHRlbmQoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeydkYXRlRm9ybWF0JzpkYXRlRm9ybWF0fSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIucmVnaW9uYWxbIHNlbGYubGFuZ19jb2RlXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICApO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJC5kYXRlcGlja2VyLnNldERlZmF1bHRzKFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJC5leHRlbmQoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeydkYXRlRm9ybWF0JzpkYXRlRm9ybWF0fSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkLmRhdGVwaWNrZXIucmVnaW9uYWxbXCJlblwiXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICApO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJCgnLmxsLXNraW4tbWVsb24nKS5sZW5ndGg9PTApe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkZGF0ZV9waWNrZXIuZGF0ZXBpY2tlcignd2lkZ2V0Jykud3JhcCgnPGRpdiBjbGFzcz1cImxsLXNraW4tbWVsb24gc2VhcmNoYW5kZmlsdGVyLWRhdGUtcGlja2VyXCIvPicpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZGF0ZVNlbGVjdCA9IGZ1bmN0aW9uKGUsIGZyb21fZmllbGQsICR0aGlzKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRpbnB1dF9maWVsZCA9ICQoZnJvbV9maWVsZC5pbnB1dC5nZXQoMCkpO1xyXG4gICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgdmFyICRkYXRlX2ZpZWxkcyA9ICRpbnB1dF9maWVsZC5jbG9zZXN0KCdbZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlPVwiZGF0ZXJhbmdlXCJdLCBbZGF0YS1zZi1maWVsZC1pbnB1dC10eXBlPVwiZGF0ZVwiXScpO1xyXG4gICAgICAgICAgICAkZGF0ZV9maWVsZHMuZWFjaChmdW5jdGlvbihlLCBpbmRleCl7XHJcbiAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgICAgIHZhciAkdGZfZGF0ZV9waWNrZXJzID0gJCh0aGlzKS5maW5kKFwiLnNmLWRhdGVwaWNrZXJcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgbm9fZGF0ZV9waWNrZXJzID0gJHRmX2RhdGVfcGlja2Vycy5sZW5ndGg7XHJcbiAgICAgICAgICAgICAgICBcclxuICAgICAgICAgICAgICAgIGlmKG5vX2RhdGVfcGlja2Vycz4xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vdGhlbiBpdCBpcyBhIGRhdGUgcmFuZ2UsIHNvIG1ha2Ugc3VyZSBib3RoIGZpZWxkcyBhcmUgZmlsbGVkIGJlZm9yZSB1cGRhdGluZ1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBkcF9jb3VudGVyID0gMDtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfZW1wdHlfZmllbGRfY291bnQgPSAwO1xyXG4gICAgICAgICAgICAgICAgICAgICR0Zl9kYXRlX3BpY2tlcnMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJCh0aGlzKS52YWwoKT09XCJcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZHBfZW1wdHlfZmllbGRfY291bnQrKztcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgZHBfY291bnRlcisrO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihkcF9lbXB0eV9maWVsZF9jb3VudD09MClcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoMSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgIC8qaWYoKHNlbGYuYXV0b191cGRhdGU9PTEpfHwoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCQodGhpcykpO1xyXG4gICAgICAgICAgICAgICAgdmFyICRkYXRlX2ZpZWxkcyA9ICR0aGlzLmZpbmQoJ1tkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGU9XCJkYXRlXCJdJyk7XHJcbiAgICAgICAgICAgICAgICAkZGF0ZV9maWVsZHMuZWFjaChmdW5jdGlvbihlLCBpbmRleCl7XHJcblx0XHRcdFx0XHRjb25zb2xlLmxvZyhcIi0tLS0tLS0tLS0tLVwiKTtcclxuXHRcdFx0XHRcdGNvbnNvbGUubG9nKFwiZm91bmQgZGF0ZSBmaWVsZFwiKTtcclxuXHJcblx0XHRcdFx0fSk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJHRmX2RhdGVfcGlja2VycyA9ICR0aGlzLmZpbmQoXCIuc2YtZGF0ZXBpY2tlclwiKTtcclxuICAgICAgICAgICAgICAgIHZhciBub19kYXRlX3BpY2tlcnMgPSAkdGZfZGF0ZV9waWNrZXJzLmxlbmd0aDtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihub19kYXRlX3BpY2tlcnM+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3RoZW4gaXQgaXMgYSBkYXRlIHJhbmdlLCBzbyBtYWtlIHN1cmUgYm90aCBmaWVsZHMgYXJlIGZpbGxlZCBiZWZvcmUgdXBkYXRpbmdcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZHBfY291bnRlciA9IDA7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRwX2VtcHR5X2ZpZWxkX2NvdW50ID0gMDtcclxuICAgICAgICAgICAgICAgICAgICAkdGZfZGF0ZV9waWNrZXJzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCQodGhpcykudmFsKCk9PVwiXCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRwX2VtcHR5X2ZpZWxkX2NvdW50Kys7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRwX2NvdW50ZXIrKztcclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZHBfZW1wdHlfZmllbGRfY291bnQ9PTApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlucHV0VXBkYXRlKDEpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgfSovXHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5hZGRSYW5nZVNsaWRlcnMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgJG1ldGFfcmFuZ2UgPSAkdGhpcy5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJG1ldGFfcmFuZ2UubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRtZXRhX3JhbmdlLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgbWluID0gJHRoaXMuYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtaW4gPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNtYXggPSAkdGhpcy5hdHRyKFwiZGF0YS1zdGFydC1tYXhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRpc3BsYXlfdmFsdWVfYXMgPSAkdGhpcy5hdHRyKFwiZGF0YS1kaXNwbGF5LXZhbHVlcy1hc1wiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RlcCA9ICR0aGlzLmF0dHIoXCJkYXRhLXN0ZXBcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzdGFydF92YWwgPSAkdGhpcy5maW5kKCcuc2YtcmFuZ2UtbWluJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRlbmRfdmFsID0gJHRoaXMuZmluZCgnLnNmLXJhbmdlLW1heCcpO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGRlY2ltYWxfcGxhY2VzID0gJHRoaXMuYXR0cihcImRhdGEtZGVjaW1hbC1wbGFjZXNcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHRob3VzYW5kX3NlcGVyYXRvciA9ICR0aGlzLmF0dHIoXCJkYXRhLXRob3VzYW5kLXNlcGVyYXRvclwiKTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZGVjaW1hbF9zZXBlcmF0b3IgPSAkdGhpcy5hdHRyKFwiZGF0YS1kZWNpbWFsLXNlcGVyYXRvclwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIGZpZWxkX2Zvcm1hdCA9IHdOdW1iKHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgbWFyazogZGVjaW1hbF9zZXBlcmF0b3IsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRlY2ltYWxzOiBwYXJzZUZsb2F0KGRlY2ltYWxfcGxhY2VzKSxcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhvdXNhbmQ6IHRob3VzYW5kX3NlcGVyYXRvclxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtaW4pO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtaW5fZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21pbikpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfZm9ybWF0dGVkID0gZmllbGRfZm9ybWF0LnRvKHBhcnNlRmxvYXQoc21heCkpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhfdW5mb3JtYXR0ZWQgPSBwYXJzZUZsb2F0KHNtYXgpO1xyXG4gICAgICAgICAgICAgICAgICAgIC8vYWxlcnQobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9hbGVydChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAvL2FsZXJ0KGRpc3BsYXlfdmFsdWVfYXMpO1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0aW5wdXRcIilcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwudmFsKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC52YWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0XCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkc3RhcnRfdmFsLmh0bWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG5vVUlPcHRpb25zID0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByYW5nZToge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJ21pbic6IFsgcGFyc2VGbG9hdChtaW4pIF0sXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAnbWF4JzogWyBwYXJzZUZsb2F0KG1heCkgXVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzdGFydDogW21pbl9mb3JtYXR0ZWQsIG1heF9mb3JtYXR0ZWRdLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVzOiAyLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25uZWN0OiB0cnVlLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzdGVwOiBwYXJzZUZsb2F0KHN0ZXApLFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgYmVoYXZpb3VyOiAnZXh0ZW5kLXRhcCcsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZvcm1hdDogZmllbGRfZm9ybWF0XHJcbiAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmlzX3J0bD09MSlcclxuICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG5vVUlPcHRpb25zLmRpcmVjdGlvbiA9IFwicnRsXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAvLyQodGhpcykuZmluZChcIi5tZXRhLXNsaWRlclwiKS5ub1VpU2xpZGVyKG5vVUlPcHRpb25zKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9vYmplY3QgPSAkKHRoaXMpLmZpbmQoXCIubWV0YS1zbGlkZXJcIilbMF07XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCBcInVuZGVmaW5lZFwiICE9PSB0eXBlb2YoIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlciApICkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2Rlc3Ryb3kgaWYgaXQgZXhpc3RzLi4gdGhpcyBtZWFucyBzb21laG93IGFub3RoZXIgaW5zdGFuY2UgaGFkIGluaXRpYWxpc2VkIGl0Li5cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLmRlc3Ryb3koKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9jb25zb2xlLmxvZyh0eXBlb2Yoc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBub1VpU2xpZGVyLmNyZWF0ZShzbGlkZXJfb2JqZWN0LCBub1VJT3B0aW9ucyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRzdGFydF92YWwub2ZmKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5vbignY2hhbmdlJywgZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbJCh0aGlzKS52YWwoKSwgbnVsbF0pO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5vZmYoKTtcclxuICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC5vbignY2hhbmdlJywgZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2xpZGVyX29iamVjdC5ub1VpU2xpZGVyLnNldChbbnVsbCwgJCh0aGlzKS52YWwoKV0pO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvLyRzdGFydF92YWwuaHRtbChtaW5fZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAvLyRlbmRfdmFsLmh0bWwobWF4X2Zvcm1hdHRlZCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5vZmYoJ3VwZGF0ZScpO1xyXG4gICAgICAgICAgICAgICAgICAgIHNsaWRlcl9vYmplY3Qubm9VaVNsaWRlci5vbigndXBkYXRlJywgZnVuY3Rpb24oIHZhbHVlcywgaGFuZGxlICkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9zdGFydF92YWwgID0gbWluX2Zvcm1hdHRlZDtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl9lbmRfdmFsICA9IG1heF9mb3JtYXR0ZWQ7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWUgPSB2YWx1ZXNbaGFuZGxlXTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAoIGhhbmRsZSApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1heF9mb3JtYXR0ZWQgPSB2YWx1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1pbl9mb3JtYXR0ZWQgPSB2YWx1ZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoZGlzcGxheV92YWx1ZV9hcz09XCJ0ZXh0aW5wdXRcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC52YWwobWluX2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZW5kX3ZhbC52YWwobWF4X2Zvcm1hdHRlZCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihkaXNwbGF5X3ZhbHVlX2FzPT1cInRleHRcIilcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXJ0X3ZhbC5odG1sKG1pbl9mb3JtYXR0ZWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGVuZF92YWwuaHRtbChtYXhfZm9ybWF0dGVkKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaSB0aGluayB0aGUgZnVuY3Rpb24gdGhhdCBidWlsZHMgdGhlIFVSTCBuZWVkcyB0byBkZWNvZGUgdGhlIGZvcm1hdHRlZCBzdHJpbmcgYmVmb3JlIGFkZGluZyB0byB0aGUgdXJsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKChzZWxmLmF1dG9fdXBkYXRlPT0xKXx8KHNlbGYuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL29ubHkgdHJ5IHRvIHVwZGF0ZSBpZiB0aGUgdmFsdWVzIGhhdmUgYWN0dWFsbHkgY2hhbmdlZFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHNsaWRlcl9zdGFydF92YWwhPW1pbl9mb3JtYXR0ZWQpfHwoc2xpZGVyX2VuZF92YWwhPW1heF9mb3JtYXR0ZWQpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuaW5wdXRVcGRhdGUoODAwKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpOyAvL2lnbm9yZSBhbnkgY2hhbmdlcyByZWNlbnRseSBtYWRlIGJ5IHRoZSBzbGlkZXIgKHRoaXMgd2FzIGp1c3QgaW5pdCBzaG91bGRuJ3QgY291bnQgYXMgYW4gdXBkYXRlIGV2ZW50KVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5pbml0ID0gZnVuY3Rpb24oa2VlcF9wYWdpbmF0aW9uKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGtlZXBfcGFnaW5hdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBrZWVwX3BhZ2luYXRpb24gPSBmYWxzZTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdGhpcy5pbml0QXV0b1VwZGF0ZUV2ZW50cygpO1xyXG4gICAgICAgICAgICB0aGlzLmF0dGFjaEFjdGl2ZUNsYXNzKCk7XHJcblxyXG4gICAgICAgICAgICB0aGlzLmFkZERhdGVQaWNrZXJzKCk7XHJcbiAgICAgICAgICAgIHRoaXMuYWRkUmFuZ2VTbGlkZXJzKCk7XHJcblxyXG4gICAgICAgICAgICAvL2luaXQgY29tYm8gYm94ZXNcclxuICAgICAgICAgICAgdmFyICRjb21ib2JveCA9ICR0aGlzLmZpbmQoXCJzZWxlY3RbZGF0YS1jb21ib2JveD0nMSddXCIpO1xyXG5cclxuICAgICAgICAgICAgaWYoJGNvbWJvYm94Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkY29tYm9ib3guZWFjaChmdW5jdGlvbihpbmRleCApe1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkdGhpc2NiID0gJCggdGhpcyApO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBucm0gPSAkdGhpc2NiLmF0dHIoXCJkYXRhLWNvbWJvYm94LW5ybVwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHR5cGVvZiAkdGhpc2NiLmNob3NlbiAhPSBcInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGNob3Nlbm9wdGlvbnMgPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzZWFyY2hfY29udGFpbnM6IHRydWVcclxuICAgICAgICAgICAgICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKCh0eXBlb2YobnJtKSE9PVwidW5kZWZpbmVkXCIpJiYobnJtKSl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjaG9zZW5vcHRpb25zLm5vX3Jlc3VsdHNfdGV4dCA9IG5ybTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyBzYWZlIHRvIHVzZSB0aGUgZnVuY3Rpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9zZWFyY2hfY29udGFpbnNcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzY2IuYWRkQ2xhc3MoXCJjaG9zZW4tcnRsXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLmNob3NlbihjaG9zZW5vcHRpb25zKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzZWxlY3Qyb3B0aW9ucyA9IHt9O1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19ydGw9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGVjdDJvcHRpb25zLmRpciA9IFwicnRsXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoKHR5cGVvZihucm0pIT09XCJ1bmRlZmluZWRcIikmJihucm0pKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNlbGVjdDJvcHRpb25zLmxhbmd1YWdlPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXCJub1Jlc3VsdHNcIjogZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIG5ybTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9O1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpc2NiLnNlbGVjdDIoc2VsZWN0Mm9wdGlvbnMpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuXHJcblxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmlzU3VibWl0dGluZyA9IGZhbHNlO1xyXG5cclxuICAgICAgICAgICAgLy9pZiBhamF4IGlzIGVuYWJsZWQgaW5pdCB0aGUgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAkdGhpcy5zdWJtaXQodGhpcy5zdWJtaXRGb3JtKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuaW5pdFdvb0NvbW1lcmNlQ29udHJvbHMoKTsgLy93b29jb21tZXJjZSBvcmRlcmJ5XHJcblxyXG4gICAgICAgICAgICBpZihrZWVwX3BhZ2luYXRpb249PWZhbHNlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKGZhbHNlKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5vbldpbmRvd1Njcm9sbCA9IGZ1bmN0aW9uKGV2ZW50KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYoKCFzZWxmLmlzX2xvYWRpbmdfbW9yZSkgJiYgKCFzZWxmLmlzX21heF9wYWdlZCkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB3aW5kb3dfc2Nyb2xsID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHdpbmRvd19zY3JvbGxfYm90dG9tID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpICsgJCh3aW5kb3cpLmhlaWdodCgpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHNjcm9sbF9vZmZzZXQgPSBwYXJzZUludChzZWxmLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudCk7Ly9zZWxmLmluZmluaXRlX3Njcm9sbF90cmlnZ2VyX2Ftb3VudDtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3ZhciAkYWpheF9yZXN1bHRzX2NvbnRhaW5lciA9IGpRdWVyeSgkdGhpcy5hdHRyKFwiZGF0YS1hamF4LXRhcmdldFwiKSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfc2Nyb2xsX2JvdHRvbSA9IHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIub2Zmc2V0KCkudG9wICsgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5oZWlnaHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy92YXIgb2Zmc2V0ID0gKCRhamF4X3Jlc3VsdHNfY29udGFpbmVyLm9mZnNldCgpLnRvcCArICRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmhlaWdodCgpKSAtIHdpbmRvd19zY3JvbGw7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG9mZnNldCA9IChzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLm9mZnNldCgpLnRvcCArIHNlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuaGVpZ2h0KCkpIC0gd2luZG93X3Njcm9sbDtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYod2luZG93X3Njcm9sbF9ib3R0b20gPiByZXN1bHRzX3Njcm9sbF9ib3R0b20gKyBzY3JvbGxfb2Zmc2V0KVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5sb2FkTW9yZVJlc3VsdHMoKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHsvL2RvbnQgbG9hZCBtb3JlXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgLyppZih0aGlzLmRlYnVnX21vZGU9PVwiMVwiKVxyXG4gICAgICAgICB7Ly9lcnJvciBsb2dnaW5nXHJcblxyXG4gICAgICAgICBpZihzZWxmLmlzX2FqYXg9PTEpXHJcbiAgICAgICAgIHtcclxuICAgICAgICAgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdHNfYXM9PVwic2hvcnRjb2RlXCIpXHJcbiAgICAgICAgIHtcclxuICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5sZW5ndGg9PTApXHJcbiAgICAgICAgIHtcclxuICAgICAgICAgY29uc29sZS5sb2coXCJTZWFyY2ggJiBGaWx0ZXIgfCBGb3JtIElEOiBcIitzZWxmLnNmaWQrXCI6IGNhbm5vdCBmaW5kIHRoZSByZXN1bHRzIGNvbnRhaW5lciBvbiB0aGlzIHBhZ2UgLSBlbnN1cmUgeW91IHVzZSB0aGUgc2hvcnRjb2RlIG9uIHRoaXMgcGFnZSBvciBwcm92aWRlIGEgVVJMIHdoZXJlIGl0IGNhbiBiZSBmb3VuZCAoUmVzdWx0cyBVUkwpXCIpO1xyXG4gICAgICAgICB9XHJcbiAgICAgICAgIGlmKHNlbGYucmVzdWx0c191cmw9PVwiXCIpXHJcbiAgICAgICAgIHtcclxuICAgICAgICAgY29uc29sZS5sb2coXCJTZWFyY2ggJiBGaWx0ZXIgfCBGb3JtIElEOiBcIitzZWxmLnNmaWQrXCI6IE5vIFJlc3VsdHMgVVJMIGhhcyBiZWVuIGRlZmluZWQgLSBlbnN1cmUgdGhhdCB5b3UgZW50ZXIgdGhpcyBpbiBvcmRlciB0byB1c2UgdGhlIFNlYXJjaCBGb3JtIG9uIGFueSBwYWdlKVwiKTtcclxuICAgICAgICAgfVxyXG4gICAgICAgICAvL2NoZWNrIGlmIHJlc3VsdHMgVVJMIGlzIG9uIHNhbWUgZG9tYWluIGZvciBwb3RlbnRpYWwgY3Jvc3MgZG9tYWluIGVycm9yc1xyXG4gICAgICAgICB9XHJcbiAgICAgICAgIGVsc2VcclxuICAgICAgICAge1xyXG4gICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmxlbmd0aD09MClcclxuICAgICAgICAge1xyXG4gICAgICAgICBjb25zb2xlLmxvZyhcIlNlYXJjaCAmIEZpbHRlciB8IEZvcm0gSUQ6IFwiK3NlbGYuc2ZpZCtcIjogY2Fubm90IGZpbmQgdGhlIHJlc3VsdHMgY29udGFpbmVyIG9uIHRoaXMgcGFnZSAtIGVuc3VyZSB5b3UgdXNlIGFyZSB1c2luZyB0aGUgcmlnaHQgY29udGVudCBzZWxlY3RvclwiKTtcclxuICAgICAgICAgfVxyXG4gICAgICAgICB9XHJcbiAgICAgICAgIH1cclxuICAgICAgICAgZWxzZVxyXG4gICAgICAgICB7XHJcblxyXG4gICAgICAgICB9XHJcblxyXG4gICAgICAgICB9Ki9cclxuXHJcblxyXG4gICAgICAgIHRoaXMuc3RyaXBRdWVyeVN0cmluZ0FuZEhhc2hGcm9tUGF0aCA9IGZ1bmN0aW9uKHVybCkge1xyXG4gICAgICAgICAgICByZXR1cm4gdXJsLnNwbGl0KFwiP1wiKVswXS5zcGxpdChcIiNcIilbMF07XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmd1cCA9IGZ1bmN0aW9uKCBuYW1lLCB1cmwgKSB7XHJcbiAgICAgICAgICAgIGlmICghdXJsKSB1cmwgPSBsb2NhdGlvbi5ocmVmXHJcbiAgICAgICAgICAgIG5hbWUgPSBuYW1lLnJlcGxhY2UoL1tcXFtdLyxcIlxcXFxcXFtcIikucmVwbGFjZSgvW1xcXV0vLFwiXFxcXFxcXVwiKTtcclxuICAgICAgICAgICAgdmFyIHJlZ2V4UyA9IFwiW1xcXFw/Jl1cIituYW1lK1wiPShbXiYjXSopXCI7XHJcbiAgICAgICAgICAgIHZhciByZWdleCA9IG5ldyBSZWdFeHAoIHJlZ2V4UyApO1xyXG4gICAgICAgICAgICB2YXIgcmVzdWx0cyA9IHJlZ2V4LmV4ZWMoIHVybCApO1xyXG4gICAgICAgICAgICByZXR1cm4gcmVzdWx0cyA9PSBudWxsID8gbnVsbCA6IHJlc3VsdHNbMV07XHJcbiAgICAgICAgfTtcclxuXHJcblxyXG4gICAgICAgIHRoaXMuZ2V0VXJsUGFyYW1zID0gZnVuY3Rpb24oa2VlcF9wYWdpbmF0aW9uLCB0eXBlLCBleGNsdWRlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKGtlZXBfcGFnaW5hdGlvbik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBrZWVwX3BhZ2luYXRpb24gPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIC8qaWYodHlwZW9mKGV4Y2x1ZGUpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgdmFyIGV4Y2x1ZGUgPSBcIlwiO1xyXG4gICAgICAgICAgICAgfSovXHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YodHlwZSk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB0eXBlID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHVybF9wYXJhbXNfc3RyID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIC8vIGdldCBhbGwgcGFyYW1zIGZyb20gZmllbGRzXHJcbiAgICAgICAgICAgIHZhciB1cmxfcGFyYW1zX2FycmF5ID0gcHJvY2Vzc19mb3JtLmdldFVybFBhcmFtcyhzZWxmKTtcclxuXHJcbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyh1cmxfcGFyYW1zX2FycmF5KS5sZW5ndGg7XHJcbiAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XHJcblxyXG4gICAgICAgICAgICBpZih0eXBlb2YoZXhjbHVkZSkhPVwidW5kZWZpbmVkXCIpIHtcclxuICAgICAgICAgICAgICAgIGlmICh1cmxfcGFyYW1zX2FycmF5Lmhhc093blByb3BlcnR5KGV4Y2x1ZGUpKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgbGVuZ3RoLS07XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBmb3IgKHZhciBrIGluIHVybF9wYXJhbXNfYXJyYXkpIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiAodXJsX3BhcmFtc19hcnJheS5oYXNPd25Qcm9wZXJ0eShrKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGNhbl9hZGQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZih0eXBlb2YoZXhjbHVkZSkhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmKGs9PWV4Y2x1ZGUpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYW5fYWRkID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGNhbl9hZGQpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybF9wYXJhbXNfc3RyICs9IGsgKyBcIj1cIiArIHVybF9wYXJhbXNfYXJyYXlba107XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGNvdW50IDwgbGVuZ3RoIC0gMSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHVybF9wYXJhbXNfc3RyICs9IFwiJlwiO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvdW50Kys7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgLy9mb3JtIHBhcmFtcyBhcyB1cmwgcXVlcnkgc3RyaW5nXHJcbiAgICAgICAgICAgIC8vdmFyIGZvcm1fcGFyYW1zID0gdXJsX3BhcmFtc19zdHIucmVwbGFjZUFsbChcIiUyQlwiLCBcIitcIikucmVwbGFjZUFsbChcIiUyQ1wiLCBcIixcIilcclxuICAgICAgICAgICAgdmFyIGZvcm1fcGFyYW1zID0gdXJsX3BhcmFtc19zdHI7XHJcblxyXG4gICAgICAgICAgICAvL2dldCB1cmwgcGFyYW1zIGZyb20gdGhlIGZvcm0gaXRzZWxmICh3aGF0IHRoZSB1c2VyIGhhcyBzZWxlY3RlZClcclxuICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBmb3JtX3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAvL2FkZCBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgIGlmKGtlZXBfcGFnaW5hdGlvbj09dHJ1ZSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHBhZ2VOdW1iZXIgPSBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmF0dHIoXCJkYXRhLXBhZ2VkXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihwYWdlTnVtYmVyKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBwYWdlTnVtYmVyID0gMTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBpZihwYWdlTnVtYmVyPjEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmX3BhZ2VkPVwiK3BhZ2VOdW1iZXIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvL2FkZCBzZmlkXHJcbiAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBcInNmaWQ9XCIrc2VsZi5zZmlkKTtcclxuXHJcbiAgICAgICAgICAgIC8vIGxvb3AgdGhyb3VnaCBhbnkgZXh0cmEgcGFyYW1zIChmcm9tIGV4dCBwbHVnaW5zKSBhbmQgYWRkIHRvIHRoZSB1cmwgKGllIHdvb2NvbW1lcmNlIGBvcmRlcmJ5YClcclxuICAgICAgICAgICAgLyp2YXIgZXh0cmFfcXVlcnlfcGFyYW0gPSBcIlwiO1xyXG4gICAgICAgICAgICAgdmFyIGxlbmd0aCA9IE9iamVjdC5rZXlzKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zKS5sZW5ndGg7XHJcbiAgICAgICAgICAgICB2YXIgY291bnQgPSAwO1xyXG5cclxuICAgICAgICAgICAgIGlmKGxlbmd0aD4wKVxyXG4gICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMpIHtcclxuICAgICAgICAgICAgIGlmIChzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5oYXNPd25Qcm9wZXJ0eShrKSkge1xyXG5cclxuICAgICAgICAgICAgIGlmKHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdIT1cIlwiKVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgZXh0cmFfcXVlcnlfcGFyYW0gPSBrK1wiPVwiK3NlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW2tdO1xyXG4gICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5qb2luVXJsUGFyYW0ocXVlcnlfcGFyYW1zLCBleHRyYV9xdWVyeV9wYXJhbSk7XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAqL1xyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmFkZFF1ZXJ5UGFyYW1zKHF1ZXJ5X3BhcmFtcywgc2VsZi5leHRyYV9xdWVyeV9wYXJhbXMuYWxsKTtcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGUhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIC8vcXVlcnlfcGFyYW1zID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhxdWVyeV9wYXJhbXMsIHNlbGYuZXh0cmFfcXVlcnlfcGFyYW1zW3R5cGVdKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIHF1ZXJ5X3BhcmFtcztcclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5hZGRRdWVyeVBhcmFtcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcywgbmV3X3BhcmFtcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBleHRyYV9xdWVyeV9wYXJhbSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBsZW5ndGggPSBPYmplY3Qua2V5cyhuZXdfcGFyYW1zKS5sZW5ndGg7XHJcbiAgICAgICAgICAgIHZhciBjb3VudCA9IDA7XHJcblxyXG4gICAgICAgICAgICBpZihsZW5ndGg+MClcclxuICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgIGZvciAodmFyIGsgaW4gbmV3X3BhcmFtcykge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChuZXdfcGFyYW1zLmhhc093blByb3BlcnR5KGspKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihuZXdfcGFyYW1zW2tdIT1cIlwiKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBleHRyYV9xdWVyeV9wYXJhbSA9IGsrXCI9XCIrbmV3X3BhcmFtc1trXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgZXh0cmFfcXVlcnlfcGFyYW0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gcXVlcnlfcGFyYW1zO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0aGlzLmFkZFVybFBhcmFtID0gZnVuY3Rpb24odXJsLCBzdHJpbmcpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICB2YXIgYWRkX3BhcmFtcyA9IFwiXCI7XHJcblxyXG4gICAgICAgICAgICBpZih1cmwhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHVybC5pbmRleE9mKFwiP1wiKSAhPSAtMSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vdXJsID0gdGhpcy50cmFpbGluZ1NsYXNoSXQodXJsKTtcclxuICAgICAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiP1wiO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gdXJsICsgYWRkX3BhcmFtcyArIHN0cmluZztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiB1cmw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmpvaW5VcmxQYXJhbSA9IGZ1bmN0aW9uKHBhcmFtcywgc3RyaW5nKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIGFkZF9wYXJhbXMgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgaWYocGFyYW1zIT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBhZGRfcGFyYW1zICs9IFwiJlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzdHJpbmchPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gcGFyYW1zICsgYWRkX3BhcmFtcyArIHN0cmluZztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiBwYXJhbXM7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLnNldEFqYXhSZXN1bHRzVVJMcyA9IGZ1bmN0aW9uKHF1ZXJ5X3BhcmFtcylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfcmVzdWx0c19jb25mKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZiA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gXCJcIjtcclxuICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IFwiXCI7XHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gXCJcIjtcclxuXHJcbiAgICAgICAgICAgIC8vaWYoc2VsZi5hamF4X3VybCE9XCJcIilcclxuICAgICAgICAgICAgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwic2hvcnRjb2RlXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2Ugd2FudCB0byBkbyBhIHJlcXVlc3QgdG8gdGhlIGFqYXggZW5kcG9pbnRcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Jlc3VsdHNfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYucmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9hZGQgbGFuZyBjb2RlIHRvIGFqYXggYXBpIHJlcXVlc3QsIGxhbmcgY29kZSBzaG91bGQgYWxyZWFkeSBiZSBpbiB0aGVyZSBmb3Igb3RoZXIgcmVxdWVzdHMgKGllLCBzdXBwbGllZCBpbiB0aGUgUmVzdWx0cyBVUkwpXHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5sYW5nX2NvZGUhPVwiXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy9zbyBhZGQgaXRcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwibGFuZz1cIitzZWxmLmxhbmdfY29kZSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncHJvY2Vzc2luZ191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5hamF4X3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIC8vc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsnZGF0YV90eXBlJ10gPSAnanNvbic7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwicG9zdF90eXBlX2FyY2hpdmVcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZSBpZihzZWxmLmRpc3BsYXlfcmVzdWx0X21ldGhvZD09XCJjdXN0b21fd29vY29tbWVyY2Vfc3RvcmVcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsID0gcHJvY2Vzc19mb3JtLmdldFJlc3VsdHNVcmwoc2VsZiwgc2VsZi5yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0ocmVzdWx0c191cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly9vdGhlcndpc2Ugd2Ugd2FudCB0byBwdWxsIHRoZSByZXN1bHRzIGRpcmVjdGx5IGZyb20gdGhlIHJlc3VsdHMgcGFnZVxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X3Jlc3VsdHNfY29uZlsncmVzdWx0c191cmwnXSA9IHNlbGYuYWRkVXJsUGFyYW0oc2VsZi5yZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ10gPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF91cmwsIHF1ZXJ5X3BhcmFtcyk7XHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gJ2h0bWwnO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddID0gc2VsZi5hZGRRdWVyeVBhcmFtcyhzZWxmLmFqYXhfcmVzdWx0c19jb25mWydwcm9jZXNzaW5nX3VybCddLCBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1snYWpheCddKTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ2RhdGFfdHlwZSddID0gc2VsZi5hamF4X2RhdGFfdHlwZTtcclxuICAgICAgICB9O1xyXG5cclxuXHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlTG9hZGVyVGFnID0gZnVuY3Rpb24oJG9iamVjdCwgdGFnTmFtZSkge1xyXG5cclxuICAgICAgICAgICAgdmFyICRwYXJlbnQ7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICRwYXJlbnQgPSBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmZpbmQoc2VsZi5pbmZpbml0ZV9zY3JvbGxfcmVzdWx0X2NsYXNzKS5sYXN0KCkucGFyZW50KCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkcGFyZW50ID0gc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lcjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIHRhZ05hbWUgPSAkcGFyZW50LnByb3AoXCJ0YWdOYW1lXCIpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHRhZ1R5cGUgPSAnZGl2JztcclxuICAgICAgICAgICAgaWYoICggdGFnTmFtZS50b0xvd2VyQ2FzZSgpID09ICdvbCcgKSB8fCAoIHRhZ05hbWUudG9Mb3dlckNhc2UoKSA9PSAndWwnICkgKXtcclxuICAgICAgICAgICAgICAgIHRhZ1R5cGUgPSAnbGknO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgJG5ldyA9ICQoJzwnK3RhZ1R5cGUrJyAvPicpLmh0bWwoJG9iamVjdC5odG1sKCkpO1xyXG4gICAgICAgICAgICB2YXIgYXR0cmlidXRlcyA9ICRvYmplY3QucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcblxyXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggPHNlbGVjdD4gYXR0cmlidXRlcyBhbmQgYXBwbHkgdGhlbSBvbiA8ZGl2PlxyXG4gICAgICAgICAgICAkLmVhY2goYXR0cmlidXRlcywgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAkbmV3LmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gJG5ldztcclxuXHJcbiAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5sb2FkTW9yZVJlc3VsdHMgPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBzZWxmLmlzX2xvYWRpbmdfbW9yZSA9IHRydWU7XHJcblxyXG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcclxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XHJcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXHJcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogXCJsb2FkX21vcmVcIixcclxuICAgICAgICAgICAgICAgIG9iamVjdDogc2VsZlxyXG4gICAgICAgICAgICB9O1xyXG5cclxuICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4c3RhcnRcIiwgZXZlbnRfZGF0YSk7XHJcblxyXG4gICAgICAgICAgICB2YXIgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXModHJ1ZSk7XHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9zdWJtaXRfcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpOyAvL2dyYWIgYSBjb3B5IG9mIGh0ZSBVUkwgcGFyYW1zIHdpdGhvdXQgcGFnaW5hdGlvbiBhbHJlYWR5IGFkZGVkXHJcblxyXG4gICAgICAgICAgICB2YXIgYWpheF9wcm9jZXNzaW5nX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBhamF4X3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwiXCI7XHJcblxyXG5cclxuICAgICAgICAgICAgLy9ub3cgYWRkIHRoZSBuZXcgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICB2YXIgbmV4dF9wYWdlZF9udW1iZXIgPSB0aGlzLmN1cnJlbnRfcGFnZWQgKyAxO1xyXG4gICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrbmV4dF9wYWdlZF9udW1iZXIpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ107XHJcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xyXG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcclxuXHJcbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcclxuICAgICAgICAgICAgaWYoc2VsZi5sYXN0X2FqYXhfcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGxvYWRlciA9ICQoJzxkaXYvPicse1xyXG4gICAgICAgICAgICAgICAgICAgICdjbGFzcyc6ICdzZWFyY2gtZmlsdGVyLXNjcm9sbC1sb2FkaW5nJ1xyXG4gICAgICAgICAgICAgICAgfSk7Ly8uYXBwZW5kVG8oc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lcik7XHJcblxyXG4gICAgICAgICAgICAgICAgJGxvYWRlciA9IHNlbGYudXBkYXRlTG9hZGVyVGFnKCRsb2FkZXIpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoJGxvYWRlcik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QgPSAkLmdldChhamF4X3Byb2Nlc3NpbmdfdXJsLCBmdW5jdGlvbihkYXRhLCBzdGF0dXMsIHJlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuY3VycmVudF9wYWdlZCsrO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLyogc2Nyb2xsICovXHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuc2Nyb2xsUmVzdWx0cygpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlcyB0aGUgcmVzdXRscyAmIGZvcm0gaHRtbFxyXG4gICAgICAgICAgICAgICAgc2VsZi5hZGRSZXN1bHRzKGRhdGEsIGRhdGFfdHlwZSk7XHJcblxyXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xyXG4gICAgICAgICAgICAgICAgc2VsZi50cmlnZ2VyRXZlbnQoXCJzZjphamF4ZXJyb3JcIiwgZGF0YSk7XHJcbiAgICAgICAgICAgICAgICAvKmNvbnNvbGUubG9nKFwiQUpBWCBGQUlMXCIpO1xyXG4gICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKGUpO1xyXG4gICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKHgpOyovXHJcblxyXG4gICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLnVzZV9zY3JvbGxfbG9hZGVyPT0xKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICRsb2FkZXIuZGV0YWNoKCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc19sb2FkaW5nX21vcmUgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhmaW5pc2hcIiwgZGF0YSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5mZXRjaEFqYXhSZXN1bHRzID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgLy90cmlnZ2VyIHN0YXJ0IGV2ZW50XHJcbiAgICAgICAgICAgIHZhciBldmVudF9kYXRhID0ge1xyXG4gICAgICAgICAgICAgICAgc2ZpZDogc2VsZi5zZmlkLFxyXG4gICAgICAgICAgICAgICAgdGFyZ2V0U2VsZWN0b3I6IHNlbGYuYWpheF90YXJnZXRfYXR0cixcclxuICAgICAgICAgICAgICAgIHR5cGU6IFwibG9hZF9yZXN1bHRzXCIsXHJcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheHN0YXJ0XCIsIGV2ZW50X2RhdGEpO1xyXG5cclxuICAgICAgICAgICAgLy9yZWZvY3VzIGFueSBpbnB1dCBmaWVsZHMgYWZ0ZXIgdGhlIGZvcm0gaGFzIGJlZW4gdXBkYXRlZFxyXG4gICAgICAgICAgICB2YXIgJGxhc3RfYWN0aXZlX2lucHV0X3RleHQgPSAkdGhpcy5maW5kKCdpbnB1dFt0eXBlPVwidGV4dFwiXTpmb2N1cycpLm5vdChcIi5zZi1kYXRlcGlja2VyXCIpO1xyXG4gICAgICAgICAgICBpZigkbGFzdF9hY3RpdmVfaW5wdXRfdGV4dC5sZW5ndGg9PTEpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBsYXN0X2FjdGl2ZV9pbnB1dF90ZXh0ID0gJGxhc3RfYWN0aXZlX2lucHV0X3RleHQuYXR0cihcIm5hbWVcIik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICR0aGlzLmFkZENsYXNzKFwic2VhcmNoLWZpbHRlci1kaXNhYmxlZFwiKTtcclxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLmRpc2FibGVJbnB1dHMoc2VsZik7XHJcblxyXG4gICAgICAgICAgICAvL2ZhZGUgb3V0IHJlc3VsdHNcclxuICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hbmltYXRlKHsgb3BhY2l0eTogMC41IH0sIFwiZmFzdFwiKTsgLy9sb2FkaW5nXHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmFqYXhfYWN0aW9uPT1cInBhZ2luYXRpb25cIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9uZWVkIHRvIHJlbW92ZSBhY3RpdmUgZmlsdGVyIGZyb20gVVJMXHJcblxyXG4gICAgICAgICAgICAgICAgLy9xdWVyeV9wYXJhbXMgPSBzZWxmLmxhc3Rfc3VibWl0X3F1ZXJ5X3BhcmFtcztcclxuXHJcbiAgICAgICAgICAgICAgICAvL25vdyBhZGQgdGhlIG5ldyBwYWdpbmF0aW9uXHJcbiAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuYXR0cihcImRhdGEtcGFnZWRcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKHBhZ2VOdW1iZXIpPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHBhZ2VOdW1iZXIgPSAxO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgcXVlcnlfcGFyYW1zID0gc2VsZi5nZXRVcmxQYXJhbXMoZmFsc2UpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHBhZ2VOdW1iZXI+MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBxdWVyeV9wYXJhbXMgPSBzZWxmLmpvaW5VcmxQYXJhbShxdWVyeV9wYXJhbXMsIFwic2ZfcGFnZWQ9XCIrcGFnZU51bWJlcik7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5hamF4X2FjdGlvbj09XCJzdWJtaXRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUpO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X3N1Ym1pdF9xdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyhmYWxzZSk7IC8vZ3JhYiBhIGNvcHkgb2YgaHRlIFVSTCBwYXJhbXMgd2l0aG91dCBwYWdpbmF0aW9uIGFscmVhZHkgYWRkZWRcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBcIlwiO1xyXG4gICAgICAgICAgICB2YXIgYWpheF9yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgICAgIHZhciBkYXRhX3R5cGUgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5zZXRBamF4UmVzdWx0c1VSTHMocXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgYWpheF9wcm9jZXNzaW5nX3VybCA9IHNlbGYuYWpheF9yZXN1bHRzX2NvbmZbJ3Byb2Nlc3NpbmdfdXJsJ107XHJcbiAgICAgICAgICAgIGFqYXhfcmVzdWx0c191cmwgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydyZXN1bHRzX3VybCddO1xyXG4gICAgICAgICAgICBkYXRhX3R5cGUgPSBzZWxmLmFqYXhfcmVzdWx0c19jb25mWydkYXRhX3R5cGUnXTtcclxuXHJcblxyXG4gICAgICAgICAgICAvL2Fib3J0IGFueSBwcmV2aW91cyBhamF4IHJlcXVlc3RzXHJcbiAgICAgICAgICAgIGlmKHNlbGYubGFzdF9hamF4X3JlcXVlc3QpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYubGFzdF9hamF4X3JlcXVlc3QuYWJvcnQoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9ICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdCA9IG51bGw7XHJcblxyXG4gICAgICAgICAgICAgICAgLyogc2Nyb2xsICovXHJcbiAgICAgICAgICAgICAgICBzZWxmLnNjcm9sbFJlc3VsdHMoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlUmVzdWx0cyhkYXRhLCBkYXRhX3R5cGUpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8qIHVwZGF0ZSBVUkwgKi9cclxuICAgICAgICAgICAgICAgIC8vdXBkYXRlIHVybCBiZWZvcmUgcGFnaW5hdGlvbiwgYmVjYXVzZSB3ZSBuZWVkIHRvIGRvIHNvbWUgY2hlY2tzIGFnYWlucyB0aGUgVVJMIGZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlVXJsSGlzdG9yeShhamF4X3Jlc3VsdHNfdXJsKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NldHVwIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgIHNlbGYuc2V0dXBBamF4UGFnaW5hdGlvbigpO1xyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgICAgICAvKiB1c2VyIGRlZiAqL1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pbml0V29vQ29tbWVyY2VDb250cm9scygpOyAvL3dvb2NvbW1lcmNlIG9yZGVyYnlcclxuXHJcblxyXG4gICAgICAgICAgICB9LCBkYXRhX3R5cGUpLmZhaWwoZnVuY3Rpb24oanFYSFIsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuICAgICAgICAgICAgICAgIGRhdGEuYWpheFVSTCA9IGFqYXhfcHJvY2Vzc2luZ191cmw7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmpxWEhSID0ganFYSFI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRleHRTdGF0dXMgPSB0ZXh0U3RhdHVzO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5lcnJvclRocm93biA9IGVycm9yVGhyb3duO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGVycm9yXCIsIGRhdGEpO1xyXG4gICAgICAgICAgICAgICAgLypjb25zb2xlLmxvZyhcIkFKQVggRkFJTFwiKTtcclxuICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhlKTtcclxuICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyh4KTsqL1xyXG5cclxuICAgICAgICAgICAgfSkuYWx3YXlzKGZ1bmN0aW9uKClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5zdG9wKHRydWUsdHJ1ZSkuYW5pbWF0ZSh7IG9wYWNpdHk6IDF9LCBcImZhc3RcIik7IC8vZmluaXNoZWQgbG9hZGluZ1xyXG4gICAgICAgICAgICAgICAgdmFyIGRhdGEgPSB7fTtcclxuICAgICAgICAgICAgICAgIGRhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICAgICAgICAgIGRhdGEudGFyZ2V0U2VsZWN0b3IgPSBzZWxmLmFqYXhfdGFyZ2V0X2F0dHI7XHJcbiAgICAgICAgICAgICAgICBkYXRhLm9iamVjdCA9IHNlbGY7XHJcbiAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZW5hYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vcmVmb2N1cyB0aGUgbGFzdCBhY3RpdmUgdGV4dCBmaWVsZFxyXG4gICAgICAgICAgICAgICAgaWYobGFzdF9hY3RpdmVfaW5wdXRfdGV4dCE9XCJcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gW107XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlX2lucHV0ID0gJCh0aGlzKS5maW5kKFwiaW5wdXRbbmFtZT0nXCIrbGFzdF9hY3RpdmVfaW5wdXRfdGV4dCtcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZigkYWN0aXZlX2lucHV0Lmxlbmd0aD09MSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGlucHV0ID0gJGFjdGl2ZV9pbnB1dDtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICBpZigkaW5wdXQubGVuZ3RoPT0xKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkaW5wdXQuZm9jdXMoKS52YWwoJGlucHV0LnZhbCgpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5mb2N1c0NhbXBvKCRpbnB1dFswXSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICR0aGlzLmZpbmQoXCJpbnB1dFtuYW1lPSdfc2Zfc2VhcmNoJ11cIikuZm9jdXMoKTtcclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZpbmlzaFwiLCAgZGF0YSApO1xyXG5cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5mb2N1c0NhbXBvID0gZnVuY3Rpb24oaW5wdXRGaWVsZCl7XHJcbiAgICAgICAgICAgIC8vdmFyIGlucHV0RmllbGQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChpZCk7XHJcbiAgICAgICAgICAgIGlmIChpbnB1dEZpZWxkICE9IG51bGwgJiYgaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGggIT0gMCl7XHJcbiAgICAgICAgICAgICAgICBpZiAoaW5wdXRGaWVsZC5jcmVhdGVUZXh0UmFuZ2Upe1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBGaWVsZFJhbmdlID0gaW5wdXRGaWVsZC5jcmVhdGVUZXh0UmFuZ2UoKTtcclxuICAgICAgICAgICAgICAgICAgICBGaWVsZFJhbmdlLm1vdmVTdGFydCgnY2hhcmFjdGVyJyxpbnB1dEZpZWxkLnZhbHVlLmxlbmd0aCk7XHJcbiAgICAgICAgICAgICAgICAgICAgRmllbGRSYW5nZS5jb2xsYXBzZSgpO1xyXG4gICAgICAgICAgICAgICAgICAgIEZpZWxkUmFuZ2Uuc2VsZWN0KCk7XHJcbiAgICAgICAgICAgICAgICB9ZWxzZSBpZiAoaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCB8fCBpbnB1dEZpZWxkLnNlbGVjdGlvblN0YXJ0ID09ICcwJykge1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBlbGVtTGVuID0gaW5wdXRGaWVsZC52YWx1ZS5sZW5ndGg7XHJcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5zZWxlY3Rpb25TdGFydCA9IGVsZW1MZW47XHJcbiAgICAgICAgICAgICAgICAgICAgaW5wdXRGaWVsZC5zZWxlY3Rpb25FbmQgPSBlbGVtTGVuO1xyXG4gICAgICAgICAgICAgICAgICAgIGlucHV0RmllbGQuZm9jdXMoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfWVsc2V7XHJcbiAgICAgICAgICAgICAgICBpbnB1dEZpZWxkLmZvY3VzKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudHJpZ2dlckV2ZW50ID0gZnVuY3Rpb24oZXZlbnRuYW1lLCBkYXRhKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyICRldmVudF9jb250YWluZXIgPSAkKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiK3NlbGYuc2ZpZCtcIiddXCIpO1xyXG4gICAgICAgICAgICAkZXZlbnRfY29udGFpbmVyLnRyaWdnZXIoZXZlbnRuYW1lLCBbIGRhdGEgXSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmZldGNoQWpheEZvcm0gPSBmdW5jdGlvbigpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAvL3RyaWdnZXIgc3RhcnQgZXZlbnRcclxuICAgICAgICAgICAgdmFyIGV2ZW50X2RhdGEgPSB7XHJcbiAgICAgICAgICAgICAgICBzZmlkOiBzZWxmLnNmaWQsXHJcbiAgICAgICAgICAgICAgICB0YXJnZXRTZWxlY3Rvcjogc2VsZi5hamF4X3RhcmdldF9hdHRyLFxyXG4gICAgICAgICAgICAgICAgdHlwZTogXCJmb3JtXCIsXHJcbiAgICAgICAgICAgICAgICBvYmplY3Q6IHNlbGZcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZvcm1zdGFydFwiLCBbIGV2ZW50X2RhdGEgXSk7XHJcblxyXG4gICAgICAgICAgICAkdGhpcy5hZGRDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgIHByb2Nlc3NfZm9ybS5kaXNhYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKCk7XHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmxhbmdfY29kZSE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9zbyBhZGQgaXRcclxuICAgICAgICAgICAgICAgIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuam9pblVybFBhcmFtKHF1ZXJ5X3BhcmFtcywgXCJsYW5nPVwiK3NlbGYubGFuZ19jb2RlKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGFqYXhfcHJvY2Vzc2luZ191cmwgPSBzZWxmLmFkZFVybFBhcmFtKHNlbGYuYWpheF9mb3JtX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuICAgICAgICAgICAgdmFyIGRhdGFfdHlwZSA9IFwianNvblwiO1xyXG5cclxuXHJcbiAgICAgICAgICAgIC8vYWJvcnQgYW55IHByZXZpb3VzIGFqYXggcmVxdWVzdHNcclxuICAgICAgICAgICAgLyppZihzZWxmLmxhc3RfYWpheF9yZXF1ZXN0KVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgc2VsZi5sYXN0X2FqYXhfcmVxdWVzdC5hYm9ydCgpO1xyXG4gICAgICAgICAgICAgfSovXHJcblxyXG5cclxuICAgICAgICAgICAgLy9zZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID1cclxuXHJcbiAgICAgICAgICAgICQuZ2V0KGFqYXhfcHJvY2Vzc2luZ191cmwsIGZ1bmN0aW9uKGRhdGEsIHN0YXR1cywgcmVxdWVzdClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmxhc3RfYWpheF9yZXF1ZXN0ID0gbnVsbDtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3VwZGF0ZXMgdGhlIHJlc3V0bHMgJiBmb3JtIGh0bWxcclxuICAgICAgICAgICAgICAgIHNlbGYudXBkYXRlRm9ybShkYXRhLCBkYXRhX3R5cGUpO1xyXG5cclxuXHJcbiAgICAgICAgICAgIH0sIGRhdGFfdHlwZSkuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cywgZXJyb3JUaHJvd24pXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBkYXRhID0ge307XHJcbiAgICAgICAgICAgICAgICBkYXRhLnNmaWQgPSBzZWxmLnNmaWQ7XHJcbiAgICAgICAgICAgICAgICBkYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5vYmplY3QgPSBzZWxmO1xyXG4gICAgICAgICAgICAgICAgZGF0YS5hamF4VVJMID0gYWpheF9wcm9jZXNzaW5nX3VybDtcclxuICAgICAgICAgICAgICAgIGRhdGEuanFYSFIgPSBqcVhIUjtcclxuICAgICAgICAgICAgICAgIGRhdGEudGV4dFN0YXR1cyA9IHRleHRTdGF0dXM7XHJcbiAgICAgICAgICAgICAgICBkYXRhLmVycm9yVGhyb3duID0gZXJyb3JUaHJvd247XHJcbiAgICAgICAgICAgICAgICBzZWxmLnRyaWdnZXJFdmVudChcInNmOmFqYXhlcnJvclwiLCBbIGRhdGEgXSk7XHJcblxyXG4gICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IHt9O1xyXG4gICAgICAgICAgICAgICAgZGF0YS5zZmlkID0gc2VsZi5zZmlkO1xyXG4gICAgICAgICAgICAgICAgZGF0YS50YXJnZXRTZWxlY3RvciA9IHNlbGYuYWpheF90YXJnZXRfYXR0cjtcclxuICAgICAgICAgICAgICAgIGRhdGEub2JqZWN0ID0gc2VsZjtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcyhcInNlYXJjaC1maWx0ZXItZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICBwcm9jZXNzX2Zvcm0uZW5hYmxlSW5wdXRzKHNlbGYpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6YWpheGZvcm1maW5pc2hcIiwgWyBkYXRhIF0pO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmNvcHlMaXN0SXRlbXNDb250ZW50cyA9IGZ1bmN0aW9uKCRsaXN0X2Zyb20sICRsaXN0X3RvKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgLy9jb3B5IG92ZXIgY2hpbGQgbGlzdCBpdGVtc1xyXG4gICAgICAgICAgICB2YXIgbGlfY29udGVudHNfYXJyYXkgPSBuZXcgQXJyYXkoKTtcclxuICAgICAgICAgICAgdmFyIGZyb21fYXR0cmlidXRlcyA9IG5ldyBBcnJheSgpO1xyXG5cclxuICAgICAgICAgICAgdmFyICRmcm9tX2ZpZWxkcyA9ICRsaXN0X2Zyb20uZmluZChcIj4gdWwgPiBsaVwiKTtcclxuXHJcbiAgICAgICAgICAgICRmcm9tX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGkpe1xyXG5cclxuICAgICAgICAgICAgICAgIGxpX2NvbnRlbnRzX2FycmF5LnB1c2goJCh0aGlzKS5odG1sKCkpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciBhdHRyaWJ1dGVzID0gJCh0aGlzKS5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgICAgIGZyb21fYXR0cmlidXRlcy5wdXNoKGF0dHJpYnV0ZXMpO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vdmFyIGZpZWxkX25hbWUgPSAkKHRoaXMpLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcbiAgICAgICAgICAgICAgICAvL3ZhciB0b19maWVsZCA9ICRsaXN0X3RvLmZpbmQoXCI+IHVsID4gbGlbZGF0YS1zZi1maWVsZC1uYW1lPSdcIitmaWVsZF9uYW1lK1wiJ11cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmNvcHlBdHRyaWJ1dGVzKCQodGhpcyksICRsaXN0X3RvLCBcImRhdGEtc2YtXCIpO1xyXG5cclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICB2YXIgbGlfaXQgPSAwO1xyXG4gICAgICAgICAgICB2YXIgJHRvX2ZpZWxkcyA9ICRsaXN0X3RvLmZpbmQoXCI+IHVsID4gbGlcIik7XHJcbiAgICAgICAgICAgICR0b19maWVsZHMuZWFjaChmdW5jdGlvbihpKXtcclxuICAgICAgICAgICAgICAgICQodGhpcykuaHRtbChsaV9jb250ZW50c19hcnJheVtsaV9pdF0pO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZnJvbV9maWVsZCA9ICQoJGZyb21fZmllbGRzLmdldChsaV9pdCkpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkdG9fZmllbGQgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgJHRvX2ZpZWxkLnJlbW92ZUF0dHIoXCJkYXRhLXNmLXRheG9ub215LWFyY2hpdmVcIik7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmNvcHlBdHRyaWJ1dGVzKCRmcm9tX2ZpZWxkLCAkdG9fZmllbGQpO1xyXG5cclxuICAgICAgICAgICAgICAgIGxpX2l0Kys7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgLyp2YXIgJGZyb21fZmllbGRzID0gJGxpc3RfZnJvbS5maW5kKFwiIHVsID4gbGlcIik7XHJcbiAgICAgICAgICAgICB2YXIgJHRvX2ZpZWxkcyA9ICRsaXN0X3RvLmZpbmQoXCIgPiBsaVwiKTtcclxuICAgICAgICAgICAgICRmcm9tX2ZpZWxkcy5lYWNoKGZ1bmN0aW9uKGluZGV4LCB2YWwpe1xyXG4gICAgICAgICAgICAgaWYoJCh0aGlzKS5oYXNBdHRyaWJ1dGUoXCJkYXRhLXNmLXRheG9ub215LWFyY2hpdmVcIikpXHJcbiAgICAgICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgdGhpcy5jb3B5QXR0cmlidXRlcygkbGlzdF9mcm9tLCAkbGlzdF90byk7Ki9cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlRm9ybUF0dHJpYnV0ZXMgPSBmdW5jdGlvbigkbGlzdF9mcm9tLCAkbGlzdF90bylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBmcm9tX2F0dHJpYnV0ZXMgPSAkbGlzdF9mcm9tLnByb3AoXCJhdHRyaWJ1dGVzXCIpO1xyXG4gICAgICAgICAgICAvLyBsb29wIHRocm91Z2ggPHNlbGVjdD4gYXR0cmlidXRlcyBhbmQgYXBwbHkgdGhlbSBvbiA8ZGl2PlxyXG5cclxuICAgICAgICAgICAgdmFyIHRvX2F0dHJpYnV0ZXMgPSAkbGlzdF90by5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgJC5lYWNoKHRvX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJGxpc3RfdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICQuZWFjaChmcm9tX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJGxpc3RfdG8uYXR0cih0aGlzLm5hbWUsIHRoaXMudmFsdWUpO1xyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzID0gZnVuY3Rpb24oJGZyb20sICR0bywgcHJlZml4KVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKHByZWZpeCk9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciBwcmVmaXggPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgZnJvbV9hdHRyaWJ1dGVzID0gJGZyb20ucHJvcChcImF0dHJpYnV0ZXNcIik7XHJcblxyXG4gICAgICAgICAgICB2YXIgdG9fYXR0cmlidXRlcyA9ICR0by5wcm9wKFwiYXR0cmlidXRlc1wiKTtcclxuICAgICAgICAgICAgJC5lYWNoKHRvX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHByZWZpeCE9XCJcIikge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICh0aGlzLm5hbWUuaW5kZXhPZihwcmVmaXgpID09IDApIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJHRvLnJlbW92ZUF0dHIodGhpcy5uYW1lKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8kdG8ucmVtb3ZlQXR0cih0aGlzLm5hbWUpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgICAgICQuZWFjaChmcm9tX2F0dHJpYnV0ZXMsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgJHRvLmF0dHIodGhpcy5uYW1lLCB0aGlzLnZhbHVlKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLmNvcHlGb3JtQXR0cmlidXRlcyA9IGZ1bmN0aW9uKCRmcm9tLCAkdG8pXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICAkdG8ucmVtb3ZlQXR0cihcImRhdGEtY3VycmVudC10YXhvbm9teS1hcmNoaXZlXCIpO1xyXG4gICAgICAgICAgICB0aGlzLmNvcHlBdHRyaWJ1dGVzKCRmcm9tLCAkdG8pO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlRm9ybSA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXHJcblxyXG4gICAgICAgICAgICAgICAgaWYodHlwZW9mKGRhdGFbJ2Zvcm0nXSkhPT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLm9mZigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3JlZnJlc2ggdGhlIGZvcm0gKGF1dG8gY291bnQpXHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5TGlzdEl0ZW1zQ29udGVudHMoJChkYXRhWydmb3JtJ10pLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIC8vcmUgaW5pdCBTJkYgY2xhc3Mgb24gdGhlIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLnNlYXJjaEFuZEZpbHRlcigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL2lmIGFqYXggaXMgZW5hYmxlZCBpbml0IHRoZSBwYWdpbmF0aW9uXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHRoaXMuaW5pdCh0cnVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoc2VsZi5pc19hamF4PT0xKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5zZXR1cEFqYXhQYWdpbmF0aW9uKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuXHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5hZGRSZXN1bHRzID0gZnVuY3Rpb24oZGF0YSwgZGF0YV90eXBlKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAgICAgaWYoZGF0YV90eXBlPT1cImpzb25cIilcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSBkaWQgYSByZXF1ZXN0IHRvIHRoZSBhamF4IGVuZHBvaW50LCBzbyBleHBlY3QgYW4gb2JqZWN0IGJhY2tcclxuICAgICAgICAgICAgICAgIC8vZ3JhYiB0aGUgcmVzdWx0cyBhbmQgbG9hZCBpblxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmFwcGVuZChkYXRhWydyZXN1bHRzJ10pO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9IGRhdGFbJ3Jlc3VsdHMnXTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKGRhdGFfdHlwZT09XCJodG1sXCIpXHJcbiAgICAgICAgICAgIHsvL3dlIGFyZSBleHBlY3RpbmcgdGhlIGh0bWwgb2YgdGhlIHJlc3VsdHMgcGFnZSBiYWNrLCBzbyBleHRyYWN0IHRoZSBodG1sIHdlIG5lZWRcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJGRhdGFfb2JqID0gJChkYXRhKTtcclxuXHJcbiAgICAgICAgICAgICAgICAvL3NlbGYuJGluZmluaXRlX3Njcm9sbF9jb250YWluZXIuYXBwZW5kKCRkYXRhX29iai5maW5kKHNlbGYuYWpheF90YXJnZXRfYXR0cikuaHRtbCgpKTtcclxuICAgICAgICAgICAgICAgIHNlbGYubG9hZF9tb3JlX2h0bWwgPSAkZGF0YV9vYmouZmluZChzZWxmLmFqYXhfdGFyZ2V0X2F0dHIpLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgdmFyIGluZmluaXRlX3Njcm9sbF9lbmQgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIGlmKCQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChcIltkYXRhLXNlYXJjaC1maWx0ZXItYWN0aW9uPSdpbmZpbml0ZS1zY3JvbGwtZW5kJ11cIikubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGluZmluaXRlX3Njcm9sbF9lbmQgPSB0cnVlO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvL2lmIHRoZXJlIGlzIGFub3RoZXIgc2VsZWN0b3IgZm9yIGluZmluaXRlIHNjcm9sbCwgZmluZCB0aGUgY29udGVudHMgb2YgdGhhdCBpbnN0ZWFkXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lciE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICQoXCI8ZGl2PlwiK3NlbGYubG9hZF9tb3JlX2h0bWwrXCI8L2Rpdj5cIikuZmluZChzZWxmLmluZmluaXRlX3Njcm9sbF9jb250YWluZXIpLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBpZihzZWxmLmluZmluaXRlX3Njcm9sbF9yZXN1bHRfY2xhc3MhPVwiXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciAkcmVzdWx0X2l0ZW1zID0gJChcIjxkaXY+XCIrc2VsZi5sb2FkX21vcmVfaHRtbCtcIjwvZGl2PlwiKS5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyk7XHJcbiAgICAgICAgICAgICAgICB2YXIgJHJlc3VsdF9pdGVtc19jb250YWluZXIgPSAkKCc8ZGl2Lz4nLCB7fSk7XHJcbiAgICAgICAgICAgICAgICAkcmVzdWx0X2l0ZW1zX2NvbnRhaW5lci5hcHBlbmQoJHJlc3VsdF9pdGVtcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5sb2FkX21vcmVfaHRtbCA9ICRyZXN1bHRfaXRlbXNfY29udGFpbmVyLmh0bWwoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgaWYoaW5maW5pdGVfc2Nyb2xsX2VuZClcclxuICAgICAgICAgICAgey8vd2UgZm91bmQgYSBkYXRhIGF0dHJpYnV0ZSBzaWduYWxsaW5nIHRoZSBsYXN0IHBhZ2Ugc28gZmluaXNoIGhlcmVcclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBzZWxmLmxvYWRfbW9yZV9odG1sO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuaW5maW5pdGVTY3JvbGxBcHBlbmQoc2VsZi5sb2FkX21vcmVfaHRtbCk7XHJcblxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc2VsZi5sYXN0X2xvYWRfbW9yZV9odG1sIT09c2VsZi5sb2FkX21vcmVfaHRtbClcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgLy9jaGVjayB0byBtYWtlIHN1cmUgdGhlIG5ldyBodG1sIGZldGNoZWQgaXMgZGlmZmVyZW50XHJcbiAgICAgICAgICAgICAgICBzZWxmLmxhc3RfbG9hZF9tb3JlX2h0bWwgPSBzZWxmLmxvYWRfbW9yZV9odG1sO1xyXG4gICAgICAgICAgICAgICAgc2VsZi5pbmZpbml0ZVNjcm9sbEFwcGVuZChzZWxmLmxvYWRfbW9yZV9odG1sKTtcclxuXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly93ZSByZWNlaXZlZCB0aGUgc2FtZSBtZXNzYWdlIGFnYWluIHNvIGRvbid0IGFkZCwgYW5kIHRlbGwgUyZGIHRoYXQgd2UncmUgYXQgdGhlIGVuZC4uXHJcbiAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICB0aGlzLmluZmluaXRlU2Nyb2xsQXBwZW5kID0gZnVuY3Rpb24oJG9iamVjdClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcyE9XCJcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi4kaW5maW5pdGVfc2Nyb2xsX2NvbnRhaW5lci5maW5kKHNlbGYuaW5maW5pdGVfc2Nyb2xsX3Jlc3VsdF9jbGFzcykubGFzdCgpLmFmdGVyKCRvYmplY3QpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2VcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICBzZWxmLiRpbmZpbml0ZV9zY3JvbGxfY29udGFpbmVyLmFwcGVuZCgkb2JqZWN0KTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgIHRoaXMudXBkYXRlUmVzdWx0cyA9IGZ1bmN0aW9uKGRhdGEsIGRhdGFfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKGRhdGFfdHlwZT09XCJqc29uXCIpXHJcbiAgICAgICAgICAgIHsvL3RoZW4gd2UgZGlkIGEgcmVxdWVzdCB0byB0aGUgYWpheCBlbmRwb2ludCwgc28gZXhwZWN0IGFuIG9iamVjdCBiYWNrXHJcbiAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJlc3VsdHMgYW5kIGxvYWQgaW5cclxuICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuaHRtbChkYXRhWydyZXN1bHRzJ10pO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHR5cGVvZihkYXRhWydmb3JtJ10pIT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAvL3JlbW92ZSBhbGwgZXZlbnRzIGZyb20gUyZGIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZW1vdmUgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYucmVtb3ZlQWpheFBhZ2luYXRpb24oKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuY29weUxpc3RJdGVtc0NvbnRlbnRzKCQoZGF0YVsnZm9ybSddKSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3VwZGF0ZSBhdHRyaWJ1dGVzIG9uIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlGb3JtQXR0cmlidXRlcygkKGRhdGFbJ2Zvcm0nXSksICR0aGlzKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICR0aGlzLnNlYXJjaEFuZEZpbHRlcih7J2lzSW5pdCc6IGZhbHNlfSk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8kdGhpcy5maW5kKFwiaW5wdXRcIikucmVtb3ZlQXR0cihcImRpc2FibGVkXCIpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoZGF0YV90eXBlPT1cImh0bWxcIikgey8vd2UgYXJlIGV4cGVjdGluZyB0aGUgaHRtbCBvZiB0aGUgcmVzdWx0cyBwYWdlIGJhY2ssIHNvIGV4dHJhY3QgdGhlIGh0bWwgd2UgbmVlZFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZGF0YV9vYmogPSAkKGRhdGEpO1xyXG5cclxuICAgICAgICAgICAgICAgIHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuaHRtbCgkZGF0YV9vYmouZmluZChzZWxmLmFqYXhfdGFyZ2V0X2F0dHIpLmh0bWwoKSk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYgKHNlbGYuJGFqYXhfcmVzdWx0c19jb250YWluZXIuZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJcIikubGVuZ3RoID4gMClcclxuICAgICAgICAgICAgICAgIHsvL3RoZW4gdGhlcmUgYXJlIHNlYXJjaCBmb3JtKHMpIGluc2lkZSB0aGUgcmVzdWx0cyBjb250YWluZXIsIHNvIHJlLWluaXQgdGhlbVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmZpbmQoXCIuc2VhcmNoYW5kZmlsdGVyXCIpLnNlYXJjaEFuZEZpbHRlcigpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vaWYgdGhlIGN1cnJlbnQgc2VhcmNoIGZvcm0gaXMgbm90IGluc2lkZSB0aGUgcmVzdWx0cyBjb250YWluZXIsIHRoZW4gcHJvY2VlZCBhcyBub3JtYWwgYW5kIHVwZGF0ZSB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiLnNlYXJjaGFuZGZpbHRlcltkYXRhLXNmLWZvcm0taWQ9J1wiICsgc2VsZi5zZmlkICsgXCInXVwiKS5sZW5ndGg9PTApIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRuZXdfc2VhcmNoX2Zvcm0gPSAkZGF0YV9vYmouZmluZChcIi5zZWFyY2hhbmRmaWx0ZXJbZGF0YS1zZi1mb3JtLWlkPSdcIiArIHNlbGYuc2ZpZCArIFwiJ11cIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmICgkbmV3X3NlYXJjaF9mb3JtLmxlbmd0aCA9PSAxKSB7Ly90aGVuIHJlcGxhY2UgdGhlIHNlYXJjaCBmb3JtIHdpdGggdGhlIG5ldyBvbmVcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIGFsbCBldmVudHMgZnJvbSBTJkYgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vcmVtb3ZlIHBhZ2luYXRpb25cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5yZW1vdmVBamF4UGFnaW5hdGlvbigpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZWZyZXNoIHRoZSBmb3JtIChhdXRvIGNvdW50KVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmNvcHlMaXN0SXRlbXNDb250ZW50cygkbmV3X3NlYXJjaF9mb3JtLCAkdGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3VwZGF0ZSBhdHRyaWJ1dGVzIG9uIGZvcm1cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi5jb3B5Rm9ybUF0dHJpYnV0ZXMoJG5ld19zZWFyY2hfZm9ybSwgJHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9yZSBpbml0IFMmRiBjbGFzcyBvbiB0aGUgZm9ybVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy5zZWFyY2hBbmRGaWx0ZXIoeydpc0luaXQnOiBmYWxzZX0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvLyR0aGlzLmZpbmQoXCJpbnB1dFwiKS5yZW1vdmVBdHRyKFwiZGlzYWJsZWRcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IGZhbHNlOyAvL2ZvciBpbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgc2VsZi5jdXJyZW50X3BhZ2VkID0gMTsgLy9mb3IgaW5maW5pdGUgc2Nyb2xsXHJcbiAgICAgICAgICAgIHNlbGYuc2V0SW5maW5pdGVTY3JvbGxDb250YWluZXIoKTtcclxuXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICB0aGlzLnJlbW92ZVdvb0NvbW1lcmNlQ29udHJvbHMgPSBmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICB2YXIgJHdvb19vcmRlcmJ5ID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nIC5vcmRlcmJ5Jyk7XHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnlfZm9ybSA9ICQoJy53b29jb21tZXJjZS1vcmRlcmluZycpO1xyXG5cclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5X2Zvcm0ub2ZmKCk7XHJcbiAgICAgICAgICAgICR3b29fb3JkZXJieS5vZmYoKTtcclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmFkZFF1ZXJ5UGFyYW0gPSBmdW5jdGlvbihuYW1lLCB2YWx1ZSwgdXJsX3R5cGUpe1xyXG5cclxuICAgICAgICAgICAgaWYodHlwZW9mKHVybF90eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIHVybF90eXBlID0gXCJhbGxcIjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtc1t1cmxfdHlwZV1bbmFtZV0gPSB2YWx1ZTtcclxuXHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5pbml0V29vQ29tbWVyY2VDb250cm9scyA9IGZ1bmN0aW9uKCl7XHJcblxyXG4gICAgICAgICAgICBzZWxmLnJlbW92ZVdvb0NvbW1lcmNlQ29udHJvbHMoKTtcclxuXHJcbiAgICAgICAgICAgIHZhciAkd29vX29yZGVyYnkgPSAkKCcud29vY29tbWVyY2Utb3JkZXJpbmcgLm9yZGVyYnknKTtcclxuICAgICAgICAgICAgdmFyICR3b29fb3JkZXJieV9mb3JtID0gJCgnLndvb2NvbW1lcmNlLW9yZGVyaW5nJyk7XHJcblxyXG4gICAgICAgICAgICB2YXIgb3JkZXJfdmFsID0gXCJcIjtcclxuICAgICAgICAgICAgaWYoJHdvb19vcmRlcmJ5Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSAkd29vX29yZGVyYnkudmFsKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBvcmRlcl92YWwgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwib3JkZXJieVwiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKG9yZGVyX3ZhbD09XCJtZW51X29yZGVyXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIG9yZGVyX3ZhbCA9IFwiXCI7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKChvcmRlcl92YWwhPVwiXCIpJiYoISFvcmRlcl92YWwpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5hbGwub3JkZXJieSA9IG9yZGVyX3ZhbDtcclxuICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgICAgICR3b29fb3JkZXJieV9mb3JtLm9uKCdzdWJtaXQnLCBmdW5jdGlvbihlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICAvL3ZhciBmb3JtID0gZS50YXJnZXQ7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgJHdvb19vcmRlcmJ5Lm9uKFwiY2hhbmdlXCIsIGZ1bmN0aW9uKGUpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgdmFsID0gJCh0aGlzKS52YWwoKTtcclxuICAgICAgICAgICAgICAgIGlmKHZhbD09XCJtZW51X29yZGVyXCIpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFsID0gXCJcIjtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICBzZWxmLmV4dHJhX3F1ZXJ5X3BhcmFtcy5hbGwub3JkZXJieSA9IHZhbDtcclxuXHJcbiAgICAgICAgICAgICAgICAkdGhpcy5zdWJtaXQoKTtcclxuXHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHRoaXMuc2Nyb2xsUmVzdWx0cyA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKChzZWxmLnNjcm9sbF9vbl9hY3Rpb249PXNlbGYuYWpheF9hY3Rpb24pfHwoc2VsZi5zY3JvbGxfb25fYWN0aW9uPT1cImFsbFwiKSlcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgc2VsZi5zY3JvbGxUb1BvcygpOyAvL3Njcm9sbCB0aGUgd2luZG93IGlmIGl0IGhhcyBiZWVuIHNldFxyXG4gICAgICAgICAgICAgICAgLy9zZWxmLmFqYXhfYWN0aW9uID0gXCJcIjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy51cGRhdGVVcmxIaXN0b3J5ID0gZnVuY3Rpb24oYWpheF9yZXN1bHRzX3VybClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIHZhciB1c2VfaGlzdG9yeV9hcGkgPSAwO1xyXG4gICAgICAgICAgICBpZiAod2luZG93Lmhpc3RvcnkgJiYgd2luZG93Lmhpc3RvcnkucHVzaFN0YXRlKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB1c2VfaGlzdG9yeV9hcGkgPSAkdGhpcy5hdHRyKFwiZGF0YS11c2UtaGlzdG9yeS1hcGlcIik7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKChzZWxmLnVwZGF0ZV9hamF4X3VybD09MSkmJih1c2VfaGlzdG9yeV9hcGk9PTEpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAvL25vdyBjaGVjayBpZiB0aGUgYnJvd3NlciBzdXBwb3J0cyBoaXN0b3J5IHN0YXRlIHB1c2ggOilcclxuICAgICAgICAgICAgICAgIGlmICh3aW5kb3cuaGlzdG9yeSAmJiB3aW5kb3cuaGlzdG9yeS5wdXNoU3RhdGUpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaGlzdG9yeS5wdXNoU3RhdGUobnVsbCwgbnVsbCwgYWpheF9yZXN1bHRzX3VybCk7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgICAgdGhpcy5yZW1vdmVBamF4UGFnaW5hdGlvbiA9IGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHZhciBzZWxmID0gdGhpcztcclxuXHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpIT1cInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgJGFqYXhfbGlua3Nfb2JqZWN0ID0galF1ZXJ5KHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoJGFqYXhfbGlua3Nfb2JqZWN0Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICRhamF4X2xpbmtzX29iamVjdC5vZmYoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5jYW5GZXRjaEFqYXhSZXN1bHRzID0gZnVuY3Rpb24oZmV0Y2hfdHlwZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGlmKHR5cGVvZihmZXRjaF90eXBlKT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgdmFyIGZldGNoX3R5cGUgPSBcIlwiO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICB2YXIgc2VsZiA9IHRoaXM7XHJcbiAgICAgICAgICAgIHZhciBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIGlmKHNlbGYuaXNfYWpheD09MSlcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIGFqYXggc3VibWl0IHRoZSBmb3JtXHJcblxyXG4gICAgICAgICAgICAgICAgLy9hbmQgaWYgd2UgY2FuIGZpbmQgdGhlIHJlc3VsdHMgY29udGFpbmVyXHJcbiAgICAgICAgICAgICAgICBpZihzZWxmLiRhamF4X3Jlc3VsdHNfY29udGFpbmVyLmxlbmd0aD09MSlcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHNlbGYucmVzdWx0c191cmw7ICAvL1xyXG4gICAgICAgICAgICAgICAgdmFyIHJlc3VsdHNfdXJsX2VuY29kZWQgPSAnJzsgIC8vXHJcbiAgICAgICAgICAgICAgICB2YXIgY3VycmVudF91cmwgPSB3aW5kb3cubG9jYXRpb24uaHJlZjtcclxuXHJcbiAgICAgICAgICAgICAgICAvL2lnbm9yZSAjIGFuZCBldmVyeXRoaW5nIGFmdGVyXHJcbiAgICAgICAgICAgICAgICB2YXIgaGFzaF9wb3MgPSB3aW5kb3cubG9jYXRpb24uaHJlZi5pbmRleE9mKCcjJyk7XHJcbiAgICAgICAgICAgICAgICBpZihoYXNoX3BvcyE9PS0xKXtcclxuICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybCA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmLnN1YnN0cigwLCB3aW5kb3cubG9jYXRpb24uaHJlZi5pbmRleE9mKCcjJykpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIGlmKCAoICggc2VsZi5kaXNwbGF5X3Jlc3VsdF9tZXRob2Q9PVwiY3VzdG9tX3dvb2NvbW1lcmNlX3N0b3JlXCIgKSB8fCAoIHNlbGYuZGlzcGxheV9yZXN1bHRfbWV0aG9kPT1cInBvc3RfdHlwZV9hcmNoaXZlXCIgKSApICYmICggc2VsZi5lbmFibGVfdGF4b25vbXlfYXJjaGl2ZXMgPT0gMSApIClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpZiggc2VsZi5jdXJyZW50X3RheG9ub215X2FyY2hpdmUgIT09XCJcIiApXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZmV0Y2hfYWpheF9yZXN1bHRzO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgLyp2YXIgcmVzdWx0c191cmwgPSBwcm9jZXNzX2Zvcm0uZ2V0UmVzdWx0c1VybChzZWxmLCBzZWxmLnJlc3VsdHNfdXJsKTtcclxuICAgICAgICAgICAgICAgICAgICAgdmFyIGFjdGl2ZV90YXggPSBwcm9jZXNzX2Zvcm0uZ2V0QWN0aXZlVGF4KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgIHZhciBxdWVyeV9wYXJhbXMgPSBzZWxmLmdldFVybFBhcmFtcyh0cnVlLCAnJywgYWN0aXZlX3RheCk7Ki9cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAvL25vdyBzZWUgaWYgd2UgYXJlIG9uIHRoZSBVUkwgd2UgdGhpbmsuLi5cclxuICAgICAgICAgICAgICAgIHZhciB1cmxfcGFydHMgPSBjdXJyZW50X3VybC5zcGxpdChcIj9cIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgdXJsX2Jhc2UgPSBcIlwiO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKHVybF9wYXJ0cy5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9wYXJ0c1swXTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgICAgIHVybF9iYXNlID0gY3VycmVudF91cmw7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIGxhbmcgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwibGFuZ1wiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcbiAgICAgICAgICAgICAgICBpZigodHlwZW9mKGxhbmcpIT09XCJ1bmRlZmluZWRcIikmJihsYW5nIT09bnVsbCkpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdXJsX2Jhc2UgPSBzZWxmLmFkZFVybFBhcmFtKHVybF9iYXNlLCBcImxhbmc9XCIrbGFuZyk7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHNmaWQgPSBzZWxmLmdldFF1ZXJ5UGFyYW1Gcm9tVVJMKFwic2ZpZFwiLCB3aW5kb3cubG9jYXRpb24uaHJlZik7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9pZiBzZmlkIGlzIGEgbnVtYmVyXHJcbiAgICAgICAgICAgICAgICBpZihOdW1iZXIocGFyc2VGbG9hdChzZmlkKSkgPT0gc2ZpZClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHNlbGYuYWRkVXJsUGFyYW0odXJsX2Jhc2UsIFwic2ZpZD1cIitzZmlkKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAvL2lmIGFueSBvZiB0aGUgMyBjb25kaXRpb25zIGFyZSB0cnVlLCB0aGVuIGl0cyBnb29kIHRvIGdvXHJcbiAgICAgICAgICAgICAgICAvLyAtIDEgfCBpZiB0aGUgdXJsIGJhc2UgPT0gcmVzdWx0c191cmxcclxuICAgICAgICAgICAgICAgIC8vIC0gMiB8IGlmIHVybCBiYXNlKyBcIi9cIiAgPT0gcmVzdWx0c191cmwgLSBpbiBjYXNlIG9mIHVzZXIgZXJyb3IgaW4gdGhlIHJlc3VsdHMgVVJMXHJcblxyXG4gICAgICAgICAgICAgICAgLy90cmltIGFueSB0cmFpbGluZyBzbGFzaCBmb3IgZWFzaWVyIGNvbXBhcmlzb246XHJcbiAgICAgICAgICAgICAgICB1cmxfYmFzZSA9IHVybF9iYXNlLnJlcGxhY2UoL1xcLyQvLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybCA9IHJlc3VsdHNfdXJsLnJlcGxhY2UoL1xcLyQvLCAnJyk7XHJcbiAgICAgICAgICAgICAgICByZXN1bHRzX3VybF9lbmNvZGVkID0gZW5jb2RlVVJJKHJlc3VsdHNfdXJsLnJlcGxhY2UoL1xcLyQvLCAnJykpO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IC0xO1xyXG4gICAgICAgICAgICAgICAgaWYoKHVybF9iYXNlPT1yZXN1bHRzX3VybCl8fCh1cmxfYmFzZS50b0xvd2VyQ2FzZSgpPT1yZXN1bHRzX3VybF9lbmNvZGVkLnRvTG93ZXJDYXNlKCkpKXtcclxuICAgICAgICAgICAgICAgICAgICBjdXJyZW50X3VybF9jb250YWluc19yZXN1bHRzX3VybCA9IDE7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi5vbmx5X3Jlc3VsdHNfYWpheD09MSlcclxuICAgICAgICAgICAgICAgIHsvL2lmIGEgdXNlciBoYXMgY2hvc2VuIHRvIG9ubHkgYWxsb3cgYWpheCBvbiByZXN1bHRzIHBhZ2VzIChkZWZhdWx0IGJlaGF2aW91cilcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYoIGN1cnJlbnRfdXJsX2NvbnRhaW5zX3Jlc3VsdHNfdXJsID4gLTEpXHJcbiAgICAgICAgICAgICAgICAgICAgey8vdGhpcyBtZWFucyB0aGUgY3VycmVudCBVUkwgY29udGFpbnMgdGhlIHJlc3VsdHMgdXJsLCB3aGljaCBtZWFucyB3ZSBjYW4gZG8gYWpheFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmZXRjaF9hamF4X3Jlc3VsdHMgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYoZmV0Y2hfdHlwZT09XCJwYWdpbmF0aW9uXCIpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiggY3VycmVudF91cmxfY29udGFpbnNfcmVzdWx0c191cmwgPiAtMSlcclxuICAgICAgICAgICAgICAgICAgICAgICAgey8vdGhpcyBtZWFucyB0aGUgY3VycmVudCBVUkwgY29udGFpbnMgdGhlIHJlc3VsdHMgdXJsLCB3aGljaCBtZWFucyB3ZSBjYW4gZG8gYWpheFxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vZG9uJ3QgYWpheCBwYWdpbmF0aW9uIHdoZW4gbm90IG9uIGEgUyZGIHBhZ2VcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZldGNoX2FqYXhfcmVzdWx0cyA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gZmV0Y2hfYWpheF9yZXN1bHRzO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgdGhpcy5zZXR1cEFqYXhQYWdpbmF0aW9uID0gZnVuY3Rpb24oKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgaWYodHlwZW9mKHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik9PVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLy9pbmZpbml0ZSBzY3JvbGxcclxuICAgICAgICAgICAgaWYodGhpcy5wYWdpbmF0aW9uX3R5cGU9PT1cImluZmluaXRlX3Njcm9sbFwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgaW5maW5pdGVfc2Nyb2xsX2VuZCA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgaWYoc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5maW5kKFwiW2RhdGEtc2VhcmNoLWZpbHRlci1hY3Rpb249J2luZmluaXRlLXNjcm9sbC1lbmQnXVwiKS5sZW5ndGg+MClcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBpbmZpbml0ZV9zY3JvbGxfZW5kID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICBzZWxmLmlzX21heF9wYWdlZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgaWYocGFyc2VJbnQodGhpcy5pbnN0YW5jZV9udW1iZXIpPT09MSkge1xyXG4gICAgICAgICAgICAgICAgICAgICQod2luZG93KS5vZmYoXCJzY3JvbGxcIiwgc2VsZi5vbldpbmRvd1Njcm9sbCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmIChzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoXCJwYWdpbmF0aW9uXCIpKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQod2luZG93KS5vbihcInNjcm9sbFwiLCBzZWxmLm9uV2luZG93U2Nyb2xsKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIC8vdmFyICRhamF4X2xpbmtzX29iamVjdCA9IGpRdWVyeShzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IpO1xyXG5cclxuICAgICAgICAgICAgLy9pZigkYWpheF9saW5rc19vYmplY3QubGVuZ3RoPjApXHJcbiAgICAgICAgICAgIC8ve1xyXG4gICAgICAgICAgICAgICAgLy9jb25zb2xlLmxvZyhcImluaXQgcGFnaW5hdGlvbiBzdHVmZlwiKTtcclxuICAgICAgICAgICAgICAgIC8vJGFqYXhfbGlua3Nfb2JqZWN0Lm9mZignY2xpY2snKTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgJChkb2N1bWVudCkub2ZmKCdjbGljaycsIHNlbGYuYWpheF9saW5rc19zZWxlY3Rvcik7XHJcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vZmYoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKTtcclxuICAgICAgICAgICAgICAgICQoc2VsZi5hamF4X2xpbmtzX3NlbGVjdG9yKS5vZmYoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5vbignY2xpY2snLCBzZWxmLmFqYXhfbGlua3Nfc2VsZWN0b3IsIGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZihzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoXCJwYWdpbmF0aW9uXCIpKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGxpbmsgPSBqUXVlcnkodGhpcykuYXR0cignaHJlZicpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmFqYXhfYWN0aW9uID0gXCJwYWdpbmF0aW9uXCI7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgcGFnZU51bWJlciA9IHNlbGYuZ2V0UGFnZWRGcm9tVVJMKGxpbmspO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiLCBwYWdlTnVtYmVyKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuZmV0Y2hBamF4UmVzdWx0cygpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgIC8vIH1cclxuICAgICAgICB9O1xyXG5cclxuICAgICAgICB0aGlzLmdldFBhZ2VkRnJvbVVSTCA9IGZ1bmN0aW9uKFVSTCl7XHJcblxyXG4gICAgICAgICAgICB2YXIgcGFnZWRWYWwgPSAxO1xyXG4gICAgICAgICAgICAvL2ZpcnN0IHRlc3QgdG8gc2VlIGlmIHdlIGhhdmUgXCIvcGFnZS80L1wiIGluIHRoZSBVUkxcclxuICAgICAgICAgICAgdmFyIHRwVmFsID0gc2VsZi5nZXRRdWVyeVBhcmFtRnJvbVVSTChcInNmX3BhZ2VkXCIsIFVSTCk7XHJcbiAgICAgICAgICAgIGlmKCh0eXBlb2YodHBWYWwpPT1cInN0cmluZ1wiKXx8KHR5cGVvZih0cFZhbCk9PVwibnVtYmVyXCIpKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBwYWdlZFZhbCA9IHRwVmFsO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICByZXR1cm4gcGFnZWRWYWw7XHJcbiAgICAgICAgfTtcclxuXHJcbiAgICAgICAgdGhpcy5nZXRRdWVyeVBhcmFtRnJvbVVSTCA9IGZ1bmN0aW9uKG5hbWUsIFVSTCl7XHJcblxyXG4gICAgICAgICAgICB2YXIgcXN0cmluZyA9IFwiP1wiK1VSTC5zcGxpdCgnPycpWzFdO1xyXG4gICAgICAgICAgICBpZih0eXBlb2YocXN0cmluZykhPVwidW5kZWZpbmVkXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHZhciB2YWwgPSBkZWNvZGVVUklDb21wb25lbnQoKG5ldyBSZWdFeHAoJ1s/fCZdJyArIG5hbWUgKyAnPScgKyAnKFteJjtdKz8pKCZ8I3w7fCQpJykuZXhlYyhxc3RyaW5nKXx8WyxcIlwiXSlbMV0ucmVwbGFjZSgvXFwrL2csICclMjAnKSl8fG51bGw7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gdmFsO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHJldHVybiBcIlwiO1xyXG4gICAgICAgIH07XHJcblxyXG5cclxuXHJcbiAgICAgICAgdGhpcy5mb3JtVXBkYXRlZCA9IGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgICAgICAgICAgLy9lLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgIGlmKHNlbGYuYXV0b191cGRhdGU9PTEpIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoKHNlbGYuYXV0b191cGRhdGU9PTApJiYoc2VsZi5hdXRvX2NvdW50X3JlZnJlc2hfbW9kZT09MSkpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIHNlbGYuZm9ybVVwZGF0ZWRGZXRjaEFqYXgoKTtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuZm9ybVVwZGF0ZWRGZXRjaEFqYXggPSBmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgLy9sb29wIHRocm91Z2ggYWxsIHRoZSBmaWVsZHMgYW5kIGJ1aWxkIHRoZSBVUkxcclxuICAgICAgICAgICAgc2VsZi5mZXRjaEFqYXhGb3JtKCk7XHJcblxyXG5cclxuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIC8vbWFrZSBhbnkgY29ycmVjdGlvbnMvdXBkYXRlcyB0byBmaWVsZHMgYmVmb3JlIHRoZSBzdWJtaXQgY29tcGxldGVzXHJcbiAgICAgICAgdGhpcy5zZXRGaWVsZHMgPSBmdW5jdGlvbihlKXtcclxuXHJcbiAgICAgICAgICAgIC8vaWYoc2VsZi5pc19hamF4PT0wKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9zb21ldGltZXMgdGhlIGZvcm0gaXMgc3VibWl0dGVkIHdpdGhvdXQgdGhlIHNsaWRlciB5ZXQgaGF2aW5nIHVwZGF0ZWQsIGFuZCBhcyB3ZSBnZXQgb3VyIHZhbHVlcyBmcm9tXHJcbiAgICAgICAgICAgICAgICAvL3RoZSBzbGlkZXIgYW5kIG5vdCBpbnB1dHMsIHdlIG5lZWQgdG8gY2hlY2sgaXQgaWYgbmVlZHMgdG8gYmUgc2V0XHJcbiAgICAgICAgICAgICAgICAvL29ubHkgb2NjdXJzIGlmIGFqYXggaXMgb2ZmLCBhbmQgYXV0b3N1Ym1pdCBvblxyXG4gICAgICAgICAgICAgICAgc2VsZi4kZmllbGRzLmVhY2goZnVuY3Rpb24oKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciAkZmllbGQgPSAkKHRoaXMpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgcmFuZ2VfZGlzcGxheV92YWx1ZXMgPSAkZmllbGQuZmluZCgnLnNmLW1ldGEtcmFuZ2Utc2xpZGVyJykuYXR0cihcImRhdGEtZGlzcGxheS12YWx1ZXMtYXNcIik7Ly9kYXRhLWRpc3BsYXktdmFsdWVzLWFzPVwidGV4dFwiXHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKHJhbmdlX2Rpc3BsYXlfdmFsdWVzPT09XCJ0ZXh0aW5wdXRcIikge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGZpZWxkLmZpbmQoXCIubWV0YS1zbGlkZXJcIikubGVuZ3RoPjApe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIi5tZXRhLXNsaWRlclwiKS5lYWNoKGZ1bmN0aW9uIChpbmRleCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzbGlkZXJfb2JqZWN0ID0gJCh0aGlzKVswXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkc2xpZGVyX2VsID0gJCh0aGlzKS5jbG9zZXN0KFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy92YXIgbWluVmFsID0gJHNsaWRlcl9lbC5hdHRyKFwiZGF0YS1taW5cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL3ZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBtaW5WYWwgPSAkc2xpZGVyX2VsLmZpbmQoXCIuc2YtcmFuZ2UtbWluXCIpLnZhbCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG1heFZhbCA9ICRzbGlkZXJfZWwuZmluZChcIi5zZi1yYW5nZS1tYXhcIikudmFsKCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFttaW5WYWwsIG1heFZhbF0pO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIC8vfVxyXG5cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIC8vc3VibWl0XHJcbiAgICAgICAgdGhpcy5zdWJtaXRGb3JtID0gZnVuY3Rpb24oZSl7XHJcblxyXG4gICAgICAgICAgICAvL2xvb3AgdGhyb3VnaCBhbGwgdGhlIGZpZWxkcyBhbmQgYnVpbGQgdGhlIFVSTFxyXG4gICAgICAgICAgICBpZihzZWxmLmlzU3VibWl0dGluZyA9PSB0cnVlKSB7XHJcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIHNlbGYuc2V0RmllbGRzKCk7XHJcbiAgICAgICAgICAgIHNlbGYuY2xlYXJUaW1lcigpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi5pc1N1Ym1pdHRpbmcgPSB0cnVlO1xyXG5cclxuICAgICAgICAgICAgcHJvY2Vzc19mb3JtLnNldFRheEFyY2hpdmVSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG5cclxuICAgICAgICAgICAgc2VsZi4kYWpheF9yZXN1bHRzX2NvbnRhaW5lci5hdHRyKFwiZGF0YS1wYWdlZFwiLCAxKTsgLy9pbml0IHBhZ2VkXHJcblxyXG4gICAgICAgICAgICBpZihzZWxmLmNhbkZldGNoQWpheFJlc3VsdHMoKSlcclxuICAgICAgICAgICAgey8vdGhlbiB3ZSB3aWxsIGFqYXggc3VibWl0IHRoZSBmb3JtXHJcblxyXG4gICAgICAgICAgICAgICAgc2VsZi5hamF4X2FjdGlvbiA9IFwic3VibWl0XCI7IC8vc28gd2Uga25vdyBpdCB3YXNuJ3QgcGFnaW5hdGlvblxyXG4gICAgICAgICAgICAgICAgc2VsZi5mZXRjaEFqYXhSZXN1bHRzKCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICB7Ly90aGVuIHdlIHdpbGwgc2ltcGx5IHJlZGlyZWN0IHRvIHRoZSBSZXN1bHRzIFVSTFxyXG5cclxuICAgICAgICAgICAgICAgIHZhciByZXN1bHRzX3VybCA9IHByb2Nlc3NfZm9ybS5nZXRSZXN1bHRzVXJsKHNlbGYsIHNlbGYucmVzdWx0c191cmwpO1xyXG4gICAgICAgICAgICAgICAgdmFyIHF1ZXJ5X3BhcmFtcyA9IHNlbGYuZ2V0VXJsUGFyYW1zKHRydWUsICcnKTtcclxuICAgICAgICAgICAgICAgIHJlc3VsdHNfdXJsID0gc2VsZi5hZGRVcmxQYXJhbShyZXN1bHRzX3VybCwgcXVlcnlfcGFyYW1zKTtcclxuXHJcbiAgICAgICAgICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9IHJlc3VsdHNfdXJsO1xyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAvKmlmKHNlbGYubWFpbnRhaW5fc3RhdGU9PVwiMVwiKVxyXG4gICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgLy9hbGVydChcIm1haW50YWluIHN0YXRlXCIpO1xyXG4gICAgICAgICAgICAgdmFyIGluRmlmdGVlbk1pbnV0ZXMgPSBuZXcgRGF0ZShuZXcgRGF0ZSgpLmdldFRpbWUoKSArIDE1ICogNjAgKiAxMDAwKTtcclxuICAgICAgICAgICAgIC8vaHR0cHM6Ly9naXRodWIuY29tL2pzLWNvb2tpZS9qcy1jb29raWUvd2lraS9GcmVxdWVudGx5LUFza2VkLVF1ZXN0aW9ucyNleHBpcmUtY29va2llcy1pbi1sZXNzLXRoYW4tYS1kYXlcclxuICAgICAgICAgICAgIHZhciB0aGlydHltaW51dGVzID0gMS80ODtcclxuICAgICAgICAgICAgIC8vY29va2llcy5zZXQoJ25hbWUnLCAnbXJyb3NzJywgeyBleHBpcmVzOiA3IH0pO1xyXG4gICAgICAgICAgICAgLy9jb29raWVzLnNldCgnbmFtZScsICdtcnJvc3MnLCB7IGV4cGlyZXM6IHRoaXJ0eW1pbnV0ZXMgfSk7XHJcbiAgICAgICAgICAgICBjb29raWVzLnNldCgnbmFtZScsICdtcnJvc3MnLCB7IGV4cGlyZXM6IGluRmlmdGVlbk1pbnV0ZXMgfSk7XHJcbiAgICAgICAgICAgICB9Ki9cclxuXHJcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICB9O1xyXG4gICAgICAgIC8vIGNvbnNvbGUubG9nKGNvb2tpZXMuZ2V0KCduYW1lJykpO1xyXG4gICAgICAgIC8vY29uc29sZS5sb2coY29va2llcy5nZXQoJ25hbWUnKSk7XHJcbiAgICAgICAgdGhpcy5yZXNldEZvcm0gPSBmdW5jdGlvbihzdWJtaXRfZm9ybSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIC8vdW5zZXQgYWxsIGZpZWxkc1xyXG4gICAgICAgICAgICBzZWxmLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciAkZmllbGQgPSAkKHRoaXMpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdCRmaWVsZC5yZW1vdmVBdHRyKFwiZGF0YS1zZi10YXhvbm9teS1hcmNoaXZlXCIpO1xyXG5cdFx0XHRcdFxyXG4gICAgICAgICAgICAgICAgLy9zdGFuZGFyZCBmaWVsZCB0eXBlc1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJzZWxlY3Q6bm90KFttdWx0aXBsZT0nbXVsdGlwbGUnXSkgPiBvcHRpb246Zmlyc3QtY2hpbGRcIikucHJvcChcInNlbGVjdGVkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJzZWxlY3RbbXVsdGlwbGU9J211bHRpcGxlJ10gPiBvcHRpb25cIikucHJvcChcInNlbGVjdGVkXCIsIGZhbHNlKTtcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiaW5wdXRbdHlwZT0nY2hlY2tib3gnXVwiKS5wcm9wKFwiY2hlY2tlZFwiLCBmYWxzZSk7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIj4gdWwgPiBsaTpmaXJzdC1jaGlsZCBpbnB1dFt0eXBlPSdyYWRpbyddXCIpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCJpbnB1dFt0eXBlPSd0ZXh0J11cIikudmFsKFwiXCIpO1xyXG4gICAgICAgICAgICAgICAgJGZpZWxkLmZpbmQoXCIuc2Ytb3B0aW9uLWFjdGl2ZVwiKS5yZW1vdmVDbGFzcyhcInNmLW9wdGlvbi1hY3RpdmVcIik7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcIj4gdWwgPiBsaTpmaXJzdC1jaGlsZCBpbnB1dFt0eXBlPSdyYWRpbyddXCIpLnBhcmVudCgpLmFkZENsYXNzKFwic2Ytb3B0aW9uLWFjdGl2ZVwiKTsgLy9yZSBhZGQgYWN0aXZlIGNsYXNzIHRvIGZpcnN0IFwiZGVmYXVsdFwiIG9wdGlvblxyXG5cclxuICAgICAgICAgICAgICAgIC8vbnVtYmVyIHJhbmdlIC0gMiBudW1iZXIgaW5wdXQgZmllbGRzXHJcbiAgICAgICAgICAgICAgICAkZmllbGQuZmluZChcImlucHV0W3R5cGU9J251bWJlciddXCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNJbnB1dCA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCR0aGlzSW5wdXQucGFyZW50KCkucGFyZW50KCkuaGFzQ2xhc3MoXCJzZi1tZXRhLXJhbmdlXCIpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoJHRoaXNJbnB1dC5hdHRyKFwibWluXCIpKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbHNlIGlmKGluZGV4PT0xKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpc0lucHV0LnZhbCgkdGhpc0lucHV0LmF0dHIoXCJtYXhcIikpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vbWV0YSAvIG51bWJlcnMgd2l0aCAyIGlucHV0cyAoZnJvbSAvIHRvIGZpZWxkcykgLSBzZWNvbmQgaW5wdXQgbXVzdCBiZSByZXNldCB0byBtYXggdmFsdWVcclxuICAgICAgICAgICAgICAgIHZhciAkbWV0YV9zZWxlY3RfZnJvbV90byA9ICRmaWVsZC5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2VsZWN0LWZyb210b1wiKTtcclxuXHJcbiAgICAgICAgICAgICAgICBpZigkbWV0YV9zZWxlY3RfZnJvbV90by5sZW5ndGg+MCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgc3RhcnRfbWluID0gJG1ldGFfc2VsZWN0X2Zyb21fdG8uYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9tYXggPSAkbWV0YV9zZWxlY3RfZnJvbV90by5hdHRyKFwiZGF0YS1tYXhcIik7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICRtZXRhX3NlbGVjdF9mcm9tX3RvLmZpbmQoXCJzZWxlY3RcIikuZWFjaChmdW5jdGlvbihpbmRleCl7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXNJbnB1dCA9ICQodGhpcyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZihpbmRleD09MCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzSW5wdXQudmFsKHN0YXJ0X21pbik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihpbmRleD09MSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXNJbnB1dC52YWwoc3RhcnRfbWF4KTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICB2YXIgJG1ldGFfcmFkaW9fZnJvbV90byA9ICRmaWVsZC5maW5kKFwiLnNmLW1ldGEtcmFuZ2UtcmFkaW8tZnJvbXRvXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmKCRtZXRhX3JhZGlvX2Zyb21fdG8ubGVuZ3RoPjApXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXJ0X21pbiA9ICRtZXRhX3JhZGlvX2Zyb21fdG8uYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBzdGFydF9tYXggPSAkbWV0YV9yYWRpb19mcm9tX3RvLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRyYWRpb19ncm91cHMgPSAkbWV0YV9yYWRpb19mcm9tX3RvLmZpbmQoJy5zZi1pbnB1dC1yYW5nZS1yYWRpbycpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAkcmFkaW9fZ3JvdXBzLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkcmFkaW9zID0gJCh0aGlzKS5maW5kKFwiLnNmLWlucHV0LXJhZGlvXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLnByb3AoXCJjaGVja2VkXCIsIGZhbHNlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGluZGV4PT0wKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkcmFkaW9zLmZpbHRlcignW3ZhbHVlPVwiJytzdGFydF9taW4rJ1wiXScpLnByb3AoXCJjaGVja2VkXCIsIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UgaWYoaW5kZXg9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRyYWRpb3MuZmlsdGVyKCdbdmFsdWU9XCInK3N0YXJ0X21heCsnXCJdJykucHJvcChcImNoZWNrZWRcIiwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vbnVtYmVyIHNsaWRlciAtIG5vVWlTbGlkZXJcclxuICAgICAgICAgICAgICAgICRmaWVsZC5maW5kKFwiLm1ldGEtc2xpZGVyXCIpLmVhY2goZnVuY3Rpb24oaW5kZXgpe1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgc2xpZGVyX29iamVjdCA9ICQodGhpcylbMF07XHJcbiAgICAgICAgICAgICAgICAgICAgLyp2YXIgc2xpZGVyX29iamVjdCA9ICRjb250YWluZXIuZmluZChcIi5tZXRhLXNsaWRlclwiKVswXTtcclxuICAgICAgICAgICAgICAgICAgICAgdmFyIHNsaWRlcl92YWwgPSBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZ2V0KCk7Ki9cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgdmFyICRzbGlkZXJfZWwgPSAkKHRoaXMpLmNsb3Nlc3QoXCIuc2YtbWV0YS1yYW5nZS1zbGlkZXJcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgdmFyIG1pblZhbCA9ICRzbGlkZXJfZWwuYXR0cihcImRhdGEtbWluXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBtYXhWYWwgPSAkc2xpZGVyX2VsLmF0dHIoXCJkYXRhLW1heFwiKTtcclxuICAgICAgICAgICAgICAgICAgICBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuc2V0KFttaW5WYWwsIG1heFZhbF0pO1xyXG5cclxuICAgICAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vbmVlZCB0byBzZWUgaWYgYW55IGFyZSBjb21ib2JveCBhbmQgYWN0IGFjY29yZGluZ2x5XHJcbiAgICAgICAgICAgICAgICB2YXIgJGNvbWJvYm94ID0gJGZpZWxkLmZpbmQoXCJzZWxlY3RbZGF0YS1jb21ib2JveD0nMSddXCIpO1xyXG4gICAgICAgICAgICAgICAgaWYoJGNvbWJvYm94Lmxlbmd0aD4wKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICh0eXBlb2YgJGNvbWJvYm94LmNob3NlbiAhPSBcInVuZGVmaW5lZFwiKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnRyaWdnZXIoXCJjaG9zZW46dXBkYXRlZFwiKTsgLy9mb3IgY2hvc2VuIG9ubHlcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgJGNvbWJvYm94LnZhbCgnJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICRjb21ib2JveC50cmlnZ2VyKCdjaGFuZ2Uuc2VsZWN0MicpO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuXHJcblxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgc2VsZi5jbGVhclRpbWVyKCk7XHJcblxyXG5cclxuXHJcbiAgICAgICAgICAgIGlmKHN1Ym1pdF9mb3JtPT1cImFsd2F5c1wiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBzZWxmLnN1Ym1pdEZvcm0oKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIGlmKHN1Ym1pdF9mb3JtPT1cIm5ldmVyXCIpXHJcbiAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpXHJcbiAgICAgICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi5mb3JtVXBkYXRlZEZldGNoQWpheCgpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGVsc2UgaWYoc3VibWl0X2Zvcm09PVwiYXV0b1wiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICBpZih0aGlzLmF1dG9fdXBkYXRlPT10cnVlKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmKHRoaXMuYXV0b19jb3VudF9yZWZyZXNoX21vZGU9PTEpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBzZWxmLmZvcm1VcGRhdGVkRmV0Y2hBamF4KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgIH07XHJcblxyXG4gICAgICAgIHRoaXMuaW5pdCgpO1xyXG5cclxuICAgICAgICB2YXIgZXZlbnRfZGF0YSA9IHt9O1xyXG4gICAgICAgIGV2ZW50X2RhdGEuc2ZpZCA9IHNlbGYuc2ZpZDtcclxuICAgICAgICBldmVudF9kYXRhLnRhcmdldFNlbGVjdG9yID0gc2VsZi5hamF4X3RhcmdldF9hdHRyO1xyXG4gICAgICAgIGV2ZW50X2RhdGEub2JqZWN0ID0gdGhpcztcclxuICAgICAgICBpZihvcHRzLmlzSW5pdClcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHNlbGYudHJpZ2dlckV2ZW50KFwic2Y6aW5pdFwiLCBldmVudF9kYXRhKTtcclxuICAgICAgICB9XHJcblxyXG4gICAgfSk7XHJcbn07XHJcblxufSkuY2FsbCh0aGlzLHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWwgOiB0eXBlb2Ygc2VsZiAhPT0gXCJ1bmRlZmluZWRcIiA/IHNlbGYgOiB0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93IDoge30pXG4vLyMgc291cmNlTWFwcGluZ1VSTD1kYXRhOmFwcGxpY2F0aW9uL2pzb247Y2hhcnNldDp1dGYtODtiYXNlNjQsZXlKMlpYSnphVzl1SWpvekxDSnpiM1Z5WTJWeklqcGJJbk55WXk5d2RXSnNhV012WVhOelpYUnpMMnB6TDJsdVkyeDFaR1Z6TDNCc2RXZHBiaTVxY3lKZExDSnVZVzFsY3lJNlcxMHNJbTFoY0hCcGJtZHpJam9pTzBGQlFVRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRU0lzSW1acGJHVWlPaUpuWlc1bGNtRjBaV1F1YW5NaUxDSnpiM1Z5WTJWU2IyOTBJam9pSWl3aWMyOTFjbU5sYzBOdmJuUmxiblFpT2xzaVhISmNiblpoY2lBa0lGeDBYSFJjZEZ4MFBTQW9kSGx3Wlc5bUlIZHBibVJ2ZHlBaFBUMGdYQ0oxYm1SbFptbHVaV1JjSWlBL0lIZHBibVJ2ZDFzbmFsRjFaWEo1SjEwZ09pQjBlWEJsYjJZZ1oyeHZZbUZzSUNFOVBTQmNJblZ1WkdWbWFXNWxaRndpSUQ4Z1oyeHZZbUZzV3lkcVVYVmxjbmtuWFNBNklHNTFiR3dwTzF4eVhHNTJZWElnYzNSaGRHVWdYSFJjZEZ4MFBTQnlaWEYxYVhKbEtDY3VMM04wWVhSbEp5azdYSEpjYm5aaGNpQndjbTlqWlhOelgyWnZjbTBnWEhROUlISmxjWFZwY21Vb0p5NHZjSEp2WTJWemMxOW1iM0p0SnlrN1hISmNiblpoY2lCdWIxVnBVMnhwWkdWeVhIUmNkRDBnY21WeGRXbHlaU2duYm05MWFYTnNhV1JsY2ljcE8xeHlYRzUyWVhJZ1kyOXZhMmxsY3lBZ0lDQWdJQ0FnSUQwZ2NtVnhkV2x5WlNnbmFuTXRZMjl2YTJsbEp5azdYSEpjYmx4eVhHNXRiMlIxYkdVdVpYaHdiM0owY3lBOUlHWjFibU4wYVc5dUtHOXdkR2x2Ym5NcFhISmNibnRjY2x4dUlDQWdJSFpoY2lCa1pXWmhkV3gwY3lBOUlIdGNjbHh1SUNBZ0lDQWdJQ0J6ZEdGeWRFOXdaVzVsWkRvZ1ptRnNjMlVzWEhKY2JpQWdJQ0FnSUNBZ2FYTkpibWwwT2lCMGNuVmxMRnh5WEc0Z0lDQWdJQ0FnSUdGamRHbHZiam9nWENKY0lseHlYRzRnSUNBZ2ZUdGNjbHh1WEhKY2JpQWdJQ0IyWVhJZ2IzQjBjeUE5SUdwUmRXVnllUzVsZUhSbGJtUW9aR1ZtWVhWc2RITXNJRzl3ZEdsdmJuTXBPMXh5WEc1Y2NseHVJQ0FnSUM4dmJHOXZjQ0IwYUhKdmRXZG9JR1ZoWTJnZ2FYUmxiU0J0WVhSamFHVmtYSEpjYmlBZ0lDQjBhR2x6TG1WaFkyZ29ablZ1WTNScGIyNG9LVnh5WEc0Z0lDQWdlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjJZWElnSkhSb2FYTWdQU0FrS0hSb2FYTXBPMXh5WEc0Z0lDQWdJQ0FnSUhaaGNpQnpaV3htSUQwZ2RHaHBjenRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbk5tYVdRZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMXpaaTFtYjNKdExXbGtYQ0lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0J6ZEdGMFpTNWhaR1JUWldGeVkyaEdiM0p0S0hSb2FYTXVjMlpwWkN3Z2RHaHBjeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdUpHWnBaV3hrY3lBOUlDUjBhR2x6TG1acGJtUW9YQ0krSUhWc0lENGdiR2xjSWlrN0lDOHZZU0J5WldabGNtVnVZMlVnZEc4Z1pXRmphQ0JtYVdWc1pITWdjR0Z5Wlc1MElFeEpYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11Wlc1aFlteGxYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVnpJRDBnSkhSb2FYTXVZWFIwY2lnblpHRjBZUzEwWVhodmJtOXRlUzFoY21Ob2FYWmxjeWNwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WTNWeWNtVnVkRjkwWVhodmJtOXRlVjloY21Ob2FYWmxJRDBnSkhSb2FYTXVZWFIwY2lnblpHRjBZUzFqZFhKeVpXNTBMWFJoZUc5dWIyMTVMV0Z5WTJocGRtVW5LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdVpXNWhZbXhsWDNSaGVHOXViMjE1WDJGeVkyaHBkbVZ6S1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVaVzVoWW14bFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1WeklEMGdYQ0l3WENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbU4xY25KbGJuUmZkR0Y0YjI1dmJYbGZZWEpqYUdsMlpTazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1OMWNuSmxiblJmZEdGNGIyNXZiWGxmWVhKamFHbDJaU0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0J3Y205alpYTnpYMlp2Y20wdWFXNXBkQ2h6Wld4bUxtVnVZV0pzWlY5MFlYaHZibTl0ZVY5aGNtTm9hWFpsY3l3Z2MyVnNaaTVqZFhKeVpXNTBYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVXBPMXh5WEc0Z0lDQWdJQ0FnSUM4dmNISnZZMlZ6YzE5bWIzSnRMbk5sZEZSaGVFRnlZMmhwZG1WU1pYTjFiSFJ6VlhKc0tITmxiR1lwTzF4eVhHNGdJQ0FnSUNBZ0lIQnliMk5sYzNOZlptOXliUzVsYm1GaWJHVkpibkIxZEhNb2MyVnNaaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxtVjRkSEpoWDNGMVpYSjVYM0JoY21GdGN5azlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1WNGRISmhYM0YxWlhKNVgzQmhjbUZ0Y3lBOUlIdGhiR3c2SUh0OUxDQnlaWE4xYkhSek9pQjdmU3dnWVdwaGVEb2dlMzE5TzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWRHVnRjR3hoZEdWZmFYTmZiRzloWkdWa0lEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRkR1Z0Y0d4aGRHVXRiRzloWkdWa1hDSXBPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVhWE5mWVdwaGVDQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV0ZxWVhoY0lpazdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NXBibk4wWVc1alpWOXVkVzFpWlhJZ1BTQWtkR2hwY3k1aGRIUnlLQ2RrWVhSaExXbHVjM1JoYm1ObExXTnZkVzUwSnlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k0a1lXcGhlRjl5WlhOMWJIUnpYMk52Ym5SaGFXNWxjaUE5SUdwUmRXVnllU2drZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzFoYW1GNExYUmhjbWRsZEZ3aUtTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11Y21WemRXeDBjMTkxY213Z1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMXlaWE4xYkhSekxYVnliRndpS1R0Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1SbFluVm5YMjF2WkdVZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMWtaV0oxWnkxdGIyUmxYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11ZFhCa1lYUmxYMkZxWVhoZmRYSnNJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0ZFhCa1lYUmxMV0ZxWVhndGRYSnNYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11Y0dGbmFXNWhkR2x2Ymw5MGVYQmxJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0WVdwaGVDMXdZV2RwYm1GMGFXOXVMWFI1Y0dWY0lpazdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhkWFJ2WDJOdmRXNTBJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0WVhWMGJ5MWpiM1Z1ZEZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtRjFkRzlmWTI5MWJuUmZjbVZtY21WemFGOXRiMlJsSUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdFlYVjBieTFqYjNWdWRDMXlaV1p5WlhOb0xXMXZaR1ZjSWlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1dmJteDVYM0psYzNWc2RITmZZV3BoZUNBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExXOXViSGt0Y21WemRXeDBjeTFoYW1GNFhDSXBPeUF2TDJsbUlIZGxJR0Z5WlNCdWIzUWdiMjRnZEdobElISmxjM1ZzZEhNZ2NHRm5aU3dnY21Wa2FYSmxZM1FnY21GMGFHVnlJSFJvWVc0Z2RISjVJSFJ2SUd4dllXUWdkbWxoSUdGcVlYaGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuTmpjbTlzYkY5MGIxOXdiM01nUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxelkzSnZiR3d0ZEc4dGNHOXpYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WTNWemRHOXRYM05qY205c2JGOTBieUE5SUNSMGFHbHpMbUYwZEhJb1hDSmtZWFJoTFdOMWMzUnZiUzF6WTNKdmJHd3RkRzljSWlrN1hISmNiaUFnSUNBZ0lDQWdkR2hwY3k1elkzSnZiR3hmYjI1ZllXTjBhVzl1SUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdGMyTnliMnhzTFc5dUxXRmpkR2x2Ymx3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxteGhibWRmWTI5a1pTQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMV3hoYm1jdFkyOWtaVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1GcVlYaGZkWEpzSUQwZ0pIUm9hWE11WVhSMGNpZ25aR0YwWVMxaGFtRjRMWFZ5YkNjcE8xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVlXcGhlRjltYjNKdFgzVnliQ0E5SUNSMGFHbHpMbUYwZEhJb0oyUmhkR0V0WVdwaGVDMW1iM0p0TFhWeWJDY3BPMXh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVhWE5mY25Sc0lEMGdKSFJvYVhNdVlYUjBjaWduWkdGMFlTMXBjeTF5ZEd3bktUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVrYVhOd2JHRjVYM0psYzNWc2RGOXRaWFJvYjJRZ1BTQWtkR2hwY3k1aGRIUnlLQ2RrWVhSaExXUnBjM0JzWVhrdGNtVnpkV3gwTFcxbGRHaHZaQ2NwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YldGcGJuUmhhVzVmYzNSaGRHVWdQU0FrZEdocGN5NWhkSFJ5S0Nka1lYUmhMVzFoYVc1MFlXbHVMWE4wWVhSbEp5azdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDJGamRHbHZiaUE5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NXNZWE4wWDNOMVltMXBkRjl4ZFdWeWVWOXdZWEpoYlhNZ1BTQmNJbHdpTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtTjFjbkpsYm5SZmNHRm5aV1FnUFNCd1lYSnpaVWx1ZENna2RHaHBjeTVoZEhSeUtDZGtZWFJoTFdsdWFYUXRjR0ZuWldRbktTazdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NXNZWE4wWDJ4dllXUmZiVzl5WlY5b2RHMXNJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxteHZZV1JmYlc5eVpWOW9kRzFzSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUZxWVhoZlpHRjBZVjkwZVhCbElEMGdKSFJvYVhNdVlYUjBjaWduWkdGMFlTMWhhbUY0TFdSaGRHRXRkSGx3WlNjcE8xeHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVlXcGhlRjkwWVhKblpYUmZZWFIwY2lBOUlDUjBhR2x6TG1GMGRISW9YQ0prWVhSaExXRnFZWGd0ZEdGeVoyVjBYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11ZFhObFgyaHBjM1J2Y25sZllYQnBJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0ZFhObExXaHBjM1J2Y25rdFlYQnBYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YVhOZmMzVmliV2wwZEdsdVp5QTlJR1poYkhObE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbXhoYzNSZllXcGhlRjl5WlhGMVpYTjBJRDBnYm5Wc2JEdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11ZFhObFgyaHBjM1J2Y25sZllYQnBLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWRYTmxYMmhwYzNSdmNubGZZWEJwSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbkJoWjJsdVlYUnBiMjVmZEhsd1pTazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG5CaFoybHVZWFJwYjI1ZmRIbHdaU0E5SUZ3aWJtOXliV0ZzWENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbU4xY25KbGJuUmZjR0ZuWldRcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVqZFhKeVpXNTBYM0JoWjJWa0lEMGdNVHRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbUZxWVhoZmRHRnlaMlYwWDJGMGRISXBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1aGFtRjRYM1JoY21kbGRGOWhkSFJ5SUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMbUZxWVhoZmRYSnNLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdVlXcGhlRjkxY213Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11WVdwaGVGOW1iM0p0WDNWeWJDazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1GcVlYaGZabTl5YlY5MWNtd2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdWNtVnpkV3gwYzE5MWNtd3BQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1eVpYTjFiSFJ6WDNWeWJDQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kR2hwY3k1elkzSnZiR3hmZEc5ZmNHOXpLVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWMyTnliMnhzWDNSdlgzQnZjeUE5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvZEdocGN5NXpZM0p2Ykd4ZmIyNWZZV04wYVc5dUtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11YzJOeWIyeHNYMjl1WDJGamRHbHZiaUE5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG1OMWMzUnZiVjl6WTNKdmJHeGZkRzhwUFQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NWpkWE4wYjIxZmMyTnliMnhzWDNSdklEMGdYQ0pjSWp0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NGtZM1Z6ZEc5dFgzTmpjbTlzYkY5MGJ5QTlJR3BSZFdWeWVTaDBhR2x6TG1OMWMzUnZiVjl6WTNKdmJHeGZkRzhwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvZEdocGN5NTFjR1JoZEdWZllXcGhlRjkxY213cFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTUxY0dSaGRHVmZZV3BoZUY5MWNtd2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSFJvYVhNdVpHVmlkV2RmYlc5a1pTazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1SbFluVm5YMjF2WkdVZ1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11WVdwaGVGOTBZWEpuWlhSZmIySnFaV04wS1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVZV3BoZUY5MFlYSm5aWFJmYjJKcVpXTjBJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWgwYUdsekxuUmxiWEJzWVhSbFgybHpYMnh2WVdSbFpDazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG5SbGJYQnNZWFJsWDJselgyeHZZV1JsWkNBOUlGd2lNRndpTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11WVhWMGIxOWpiM1Z1ZEY5eVpXWnlaWE5vWDIxdlpHVXBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1aGRYUnZYMk52ZFc1MFgzSmxabkpsYzJoZmJXOWtaU0E5SUZ3aU1Gd2lPMXh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhhbUY0WDJ4cGJtdHpYM05sYkdWamRHOXlJRDBnSkhSb2FYTXVZWFIwY2loY0ltUmhkR0V0WVdwaGVDMXNhVzVyY3kxelpXeGxZM1J2Y2x3aUtUdGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVlYVjBiMTkxY0dSaGRHVWdQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzFoZFhSdkxYVndaR0YwWlZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtbHVjSFYwVkdsdFpYSWdQU0F3TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuTmxkRWx1Wm1sdWFYUmxVMk55YjJ4c1EyOXVkR0ZwYm1WeUlEMGdablZ1WTNScGIyNG9LVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11YVhOZmJXRjRYM0JoWjJWa0lEMGdabUZzYzJVN0lDOHZabTl5SUd4dllXUWdiVzl5WlNCdmJteDVMQ0J2Ym1ObElIZGxJR1JsZEdWamRDQjNaU2R5WlNCaGRDQjBhR1VnWlc1a0lITmxkQ0IwYUdseklIUnZJSFJ5ZFdWY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NTFjMlZmYzJOeWIyeHNYMnh2WVdSbGNpQTlJQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRjMmh2ZHkxelkzSnZiR3d0Ykc5aFpHVnlKeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWFXNW1hVzVwZEdWZmMyTnliMnhzWDJOdmJuUmhhVzVsY2lBOUlDUjBhR2x6TG1GMGRISW9KMlJoZEdFdGFXNW1hVzVwZEdVdGMyTnliMnhzTFdOdmJuUmhhVzVsY2ljcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMbWx1Wm1sdWFYUmxYM05qY205c2JGOTBjbWxuWjJWeVgyRnRiM1Z1ZENBOUlDUjBhR2x6TG1GMGRISW9KMlJoZEdFdGFXNW1hVzVwZEdVdGMyTnliMnhzTFhSeWFXZG5aWEluS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NXBibVpwYm1sMFpWOXpZM0p2Ykd4ZmNtVnpkV3gwWDJOc1lYTnpJRDBnSkhSb2FYTXVZWFIwY2lnblpHRjBZUzFwYm1acGJtbDBaUzF6WTNKdmJHd3RjbVZ6ZFd4MExXTnNZWE56SnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVKR2x1Wm1sdWFYUmxYM05qY205c2JGOWpiMjUwWVdsdVpYSWdQU0IwYUdsekxpUmhhbUY0WDNKbGMzVnNkSE5mWTI5dWRHRnBibVZ5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIUm9hWE11YVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWFXNW1hVzVwZEdWZmMyTnliMnhzWDJOdmJuUmhhVzVsY2lBOUlGd2lYQ0k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMGFHbHpMaVJwYm1acGJtbDBaVjl6WTNKdmJHeGZZMjl1ZEdGcGJtVnlJRDBnYWxGMVpYSjVLQ1IwYUdsekxtRjBkSElvSjJSaGRHRXRhVzVtYVc1cGRHVXRjMk55YjJ4c0xXTnZiblJoYVc1bGNpY3BLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hSb2FYTXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzSmxjM1ZzZEY5amJHRnpjeWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWFXNW1hVzVwZEdWZmMyTnliMnhzWDNKbGMzVnNkRjlqYkdGemN5QTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFI1Y0dWdlppaDBhR2x6TG5WelpWOXpZM0p2Ykd4ZmJHOWhaR1Z5S1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NTFjMlZmYzJOeWIyeHNYMnh2WVdSbGNpQTlJREU3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbk5sZEVsdVptbHVhWFJsVTJOeWIyeHNRMjl1ZEdGcGJtVnlLQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQzhxSUdaMWJtTjBhVzl1Y3lBcUwxeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbkpsYzJWMElEMGdablZ1WTNScGIyNG9jM1ZpYldsMFgyWnZjbTBwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkR2hwY3k1eVpYTmxkRVp2Y20wb2MzVmliV2wwWDJadmNtMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z2RISjFaVHRjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVhVzV3ZFhSVmNHUmhkR1VnUFNCbWRXNWpkR2x2Ymloa1pXeGhlVVIxY21GMGFXOXVLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0dSbGJHRjVSSFZ5WVhScGIyNHBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWkdWc1lYbEVkWEpoZEdsdmJpQTlJRE13TUR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV5WlhObGRGUnBiV1Z5S0dSbGJHRjVSSFZ5WVhScGIyNHBPMXh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NXpZM0p2Ykd4VWIxQnZjeUE5SUdaMWJtTjBhVzl1S0NrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiMlptYzJWMElEMGdNRHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdOaGJsTmpjbTlzYkNBOUlIUnlkV1U3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgyRnFZWGc5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWMyTnliMnhzWDNSdlgzQnZjejA5WENKM2FXNWtiM2RjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCdlptWnpaWFFnUFNBd08xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb2MyVnNaaTV6WTNKdmJHeGZkRzlmY0c5elBUMWNJbVp2Y20xY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnZabVp6WlhRZ1BTQWtkR2hwY3k1dlptWnpaWFFvS1M1MGIzQTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGJITmxJR2xtS0hObGJHWXVjMk55YjJ4c1gzUnZYM0J2Y3owOVhDSnlaWE4xYkhSelhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1c1pXNW5kR2crTUNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUc5bVpuTmxkQ0E5SUhObGJHWXVKR0ZxWVhoZmNtVnpkV3gwYzE5amIyNTBZV2x1WlhJdWIyWm1jMlYwS0NrdWRHOXdPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYzJWc1ppNXpZM0p2Ykd4ZmRHOWZjRzl6UFQxY0ltTjFjM1J2YlZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZZM1Z6ZEc5dFgzTmpjbTlzYkY5MGIxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1SkdOMWMzUnZiVjl6WTNKdmJHeGZkRzh1YkdWdVozUm9QakFwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J2Wm1aelpYUWdQU0J6Wld4bUxpUmpkWE4wYjIxZmMyTnliMnhzWDNSdkxtOW1abk5sZENncExuUnZjRHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbGJITmxYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdZMkZ1VTJOeWIyeHNJRDBnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvWTJGdVUyTnliMnhzS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb1hDSm9kRzFzTENCaWIyUjVYQ0lwTG5OMGIzQW9LUzVoYm1sdFlYUmxLSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJOeWIyeHNWRzl3T2lCdlptWnpaWFJjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlMQ0JjSW01dmNtMWhiRndpTENCY0ltVmhjMlZQZFhSUmRXRmtYQ0lnS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbUYwZEdGamFFRmpkR2wyWlVOc1lYTnpJRDBnWm5WdVkzUnBiMjRvS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZZMmhsWTJzZ2RHOGdjMlZsSUdsbUlIZGxJR0Z5WlNCMWMybHVaeUJoYW1GNElDWWdZWFYwYnlCamIzVnVkRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMmxtSUc1dmRDd2dkR2hsSUhObFlYSmphQ0JtYjNKdElHUnZaWE1nYm05MElHZGxkQ0J5Wld4dllXUmxaQ3dnYzI4Z2QyVWdibVZsWkNCMGJ5QjFjR1JoZEdVZ2RHaGxJSE5tTFc5d2RHbHZiaTFoWTNScGRtVWdZMnhoYzNNZ2IyNGdZV3hzSUdacFpXeGtjMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTXViMjRvSjJOb1lXNW5aU2NzSUNkcGJuQjFkRnQwZVhCbFBWd2ljbUZrYVc5Y0lsMHNJR2x1Y0hWMFczUjVjR1U5WENKamFHVmphMkp2ZUZ3aVhTd2djMlZzWldOMEp5d2dablZ1WTNScGIyNG9aU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmpkR2hwY3lBOUlDUW9kR2hwY3lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdOMGFHbHpYM0JoY21WdWRDQTlJQ1JqZEdocGN5NWpiRzl6WlhOMEtGd2liR2xiWkdGMFlTMXpaaTFtYVdWc1pDMXVZVzFsWFZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMGFHbHpYM1JoWnlBOUlDUmpkR2hwY3k1d2NtOXdLRndpZEdGblRtRnRaVndpS1M1MGIweHZkMlZ5UTJGelpTZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHbHVjSFYwWDNSNWNHVWdQU0FrWTNSb2FYTXVZWFIwY2loY0luUjVjR1ZjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnY0dGeVpXNTBYM1JoWnlBOUlDUmpkR2hwYzE5d1lYSmxiblF1Y0hKdmNDaGNJblJoWjA1aGJXVmNJaWt1ZEc5TWIzZGxja05oYzJVb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ29kR2hwYzE5MFlXYzlQVndpYVc1d2RYUmNJaWttSmlnb2FXNXdkWFJmZEhsd1pUMDlYQ0p5WVdScGIxd2lLWHg4S0dsdWNIVjBYM1I1Y0dVOVBWd2lZMmhsWTJ0aWIzaGNJaWtwSUNZbUlDaHdZWEpsYm5SZmRHRm5QVDFjSW14cFhDSXBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1lXeHNYMjl3ZEdsdmJuTWdQU0FrWTNSb2FYTmZjR0Z5Wlc1MExuQmhjbVZ1ZENncExtWnBibVFvSjJ4cEp5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JoYkd4ZmIzQjBhVzl1YzE5bWFXVnNaSE1nUFNBa1kzUm9hWE5mY0dGeVpXNTBMbkJoY21WdWRDZ3BMbVpwYm1Rb0oybHVjSFYwT21Ob1pXTnJaV1FuS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHRnNiRjl2Y0hScGIyNXpMbkpsYlc5MlpVTnNZWE56S0Z3aWMyWXRiM0IwYVc5dUxXRmpkR2wyWlZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1lXeHNYMjl3ZEdsdmJuTmZabWxsYkdSekxtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2NHRnlaVzUwSUQwZ0pDaDBhR2x6S1M1amJHOXpaWE4wS0Z3aWJHbGNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSd1lYSmxiblF1WVdSa1EyeGhjM01vWENKelppMXZjSFJwYjI0dFlXTjBhWFpsWENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElHbG1LSFJvYVhOZmRHRm5QVDFjSW5ObGJHVmpkRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtZV3hzWDI5d2RHbHZibk1nUFNBa1kzUm9hWE11WTJocGJHUnlaVzRvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWVd4c1gyOXdkR2x2Ym5NdWNtVnRiM1psUTJ4aGMzTW9YQ0p6WmkxdmNIUnBiMjR0WVdOMGFYWmxYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMGFHbHpYM1poYkNBOUlDUmpkR2hwY3k1MllXd29LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUm9hWE5mWVhKeVgzWmhiQ0E5SUNoMGVYQmxiMllnZEdocGMxOTJZV3dnUFQwZ0ozTjBjbWx1WnljZ2ZId2dkR2hwYzE5MllXd2dhVzV6ZEdGdVkyVnZaaUJUZEhKcGJtY3BJRDhnVzNSb2FYTmZkbUZzWFNBNklIUm9hWE5mZG1Gc08xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtLSFJvYVhOZllYSnlYM1poYkNrdVpXRmphQ2htZFc1amRHbHZiaWhwTENCMllXeDFaU2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSamRHaHBjeTVtYVc1a0tGd2liM0IwYVc5dVczWmhiSFZsUFNkY0lpdDJZV3gxWlN0Y0lpZGRYQ0lwTG1Ga1pFTnNZWE56S0Z3aWMyWXRiM0IwYVc5dUxXRmpkR2wyWlZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbWx1YVhSQmRYUnZWWEJrWVhSbFJYWmxiblJ6SUQwZ1puVnVZM1JwYjI0b0tYdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzhxSUdGMWRHOGdkWEJrWVhSbElDb3ZYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ2h6Wld4bUxtRjFkRzlmZFhCa1lYUmxQVDB4S1h4OEtITmxiR1l1WVhWMGIxOWpiM1Z1ZEY5eVpXWnlaWE5vWDIxdlpHVTlQVEVwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTV2YmlnblkyaGhibWRsSnl3Z0oybHVjSFYwVzNSNWNHVTlYQ0p5WVdScGIxd2lYU3dnYVc1d2RYUmJkSGx3WlQxY0ltTm9aV05yWW05NFhDSmRMQ0J6Wld4bFkzUW5MQ0JtZFc1amRHbHZiaWhsS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBibkIxZEZWd1pHRjBaU2d5TURBcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeThrZEdocGN5NXZiaWduWTJoaGJtZGxKeXdnSnk1dFpYUmhMWE5zYVdSbGNpY3NJR1oxYm1OMGFXOXVLR1VwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZJQ0FnSUhObGJHWXVhVzV3ZFhSVmNHUmhkR1VvTWpBd0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2SUNBZ0lHTnZibk52YkdVdWJHOW5LRndpUTBoQlRrZEZJRTFGVkVFZ1UweEpSRVZTWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTk5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGN5NXZiaWduYVc1d2RYUW5MQ0FuYVc1d2RYUmJkSGx3WlQxY0ltNTFiV0psY2x3aVhTY3NJR1oxYm1OMGFXOXVLR1VwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHVjSFYwVlhCa1lYUmxLRGd3TUNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhSbGVIUkpibkIxZENBOUlDUjBhR2x6TG1acGJtUW9KMmx1Y0hWMFczUjVjR1U5WENKMFpYaDBYQ0pkT201dmRDZ3VjMll0WkdGMFpYQnBZMnRsY2lrbktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCc1lYTjBWbUZzZFdVZ1BTQWtkR1Y0ZEVsdWNIVjBMblpoYkNncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbTl1S0NkcGJuQjFkQ2NzSUNkcGJuQjFkRnQwZVhCbFBWd2lkR1Y0ZEZ3aVhUcHViM1FvTG5ObUxXUmhkR1Z3YVdOclpYSXBKeXdnWm5WdVkzUnBiMjRvS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtHeGhjM1JXWVd4MVpTRTlKSFJsZUhSSmJuQjFkQzUyWVd3b0tTbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVc1d2RYUlZjR1JoZEdVb01USXdNQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JzWVhOMFZtRnNkV1VnUFNBa2RHVjRkRWx1Y0hWMExuWmhiQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdsekxtOXVLQ2RyWlhsd2NtVnpjeWNzSUNkcGJuQjFkRnQwZVhCbFBWd2lkR1Y0ZEZ3aVhUcHViM1FvTG5ObUxXUmhkR1Z3YVdOclpYSXBKeXdnWm5WdVkzUnBiMjRvWlNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9aUzUzYUdsamFDQTlQU0F4TXlsN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsTG5CeVpYWmxiblJFWldaaGRXeDBLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjM1ZpYldsMFJtOXliU2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dkpIUm9hWE11YjI0b0oybHVjSFYwSnl3Z0oybHVjSFYwTG5ObUxXUmhkR1Z3YVdOclpYSW5MQ0J6Wld4bUxtUmhkR1ZKYm5CMWRGUjVjR1VwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJSDA3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQzh2ZEdocGN5NXBibWwwUVhWMGIxVndaR0YwWlVWMlpXNTBjeWdwTzF4eVhHNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVqYkdWaGNsUnBiV1Z5SUQwZ1puVnVZM1JwYjI0b0tWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdZMnhsWVhKVWFXMWxiM1YwS0hObGJHWXVhVzV3ZFhSVWFXMWxjaWs3WEhKY2JpQWdJQ0FnSUNBZ2ZUdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuSmxjMlYwVkdsdFpYSWdQU0JtZFc1amRHbHZiaWhrWld4aGVVUjFjbUYwYVc5dUtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdZMnhsWVhKVWFXMWxiM1YwS0hObGJHWXVhVzV3ZFhSVWFXMWxjaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFXNXdkWFJVYVcxbGNpQTlJSE5sZEZScGJXVnZkWFFvYzJWc1ppNW1iM0p0VlhCa1lYUmxaQ3dnWkdWc1lYbEVkWEpoZEdsdmJpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIMDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11WVdSa1JHRjBaVkJwWTJ0bGNuTWdQU0JtZFc1amRHbHZiaWdwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR1JoZEdWZmNHbGphMlZ5SUQwZ0pIUm9hWE11Wm1sdVpDaGNJaTV6Wmkxa1lYUmxjR2xqYTJWeVhDSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0pHUmhkR1ZmY0dsamEyVnlMbXhsYm1kMGFENHdLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWkdGMFpWOXdhV05yWlhJdVpXRmphQ2htZFc1amRHbHZiaWdwZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSFJvYVhNZ1BTQWtLSFJvYVhNcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtZWFJsUm05eWJXRjBJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR0YwWlVSeWIzQmtiM2R1V1dWaGNpQTlJR1poYkhObE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtZWFJsUkhKdmNHUnZkMjVOYjI1MGFDQTlJR1poYkhObE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdOc2IzTmxjM1JmWkdGMFpWOTNjbUZ3SUQwZ0pIUm9hWE11WTJ4dmMyVnpkQ2hjSWk1elpsOWtZWFJsWDJacFpXeGtYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0NSamJHOXpaWE4wWDJSaGRHVmZkM0poY0M1c1pXNW5kR2crTUNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHVkdiM0p0WVhRZ1BTQWtZMnh2YzJWemRGOWtZWFJsWDNkeVlYQXVZWFIwY2loY0ltUmhkR0V0WkdGMFpTMW1iM0p0WVhSY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tZMnh2YzJWemRGOWtZWFJsWDNkeVlYQXVZWFIwY2loY0ltUmhkR0V0WkdGMFpTMTFjMlV0ZVdWaGNpMWtjbTl3Wkc5M2Jsd2lLVDA5TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFpVUnliM0JrYjNkdVdXVmhjaUE5SUhSeWRXVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0pHTnNiM05sYzNSZlpHRjBaVjkzY21Gd0xtRjBkSElvWENKa1lYUmhMV1JoZEdVdGRYTmxMVzF2Ym5Sb0xXUnliM0JrYjNkdVhDSXBQVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSbFJISnZjR1J2ZDI1TmIyNTBhQ0E5SUhSeWRXVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1lYUmxVR2xqYTJWeVQzQjBhVzl1Y3lBOUlIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhVzVzYVc1bE9pQjBjblZsTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCemFHOTNUM1JvWlhKTmIyNTBhSE02SUhSeWRXVXNYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzl1VTJWc1pXTjBPaUJtZFc1amRHbHZiaWhsTENCbWNtOXRYMlpwWld4a0tYc2djMlZzWmk1a1lYUmxVMlZzWldOMEtHVXNJR1p5YjIxZlptbGxiR1FzSUNRb2RHaHBjeWtwT3lCOUxGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJsUm05eWJXRjBPaUJrWVhSbFJtOXliV0YwTEZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdZMmhoYm1kbFRXOXVkR2c2SUdSaGRHVkVjbTl3Wkc5M2JrMXZiblJvTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCamFHRnVaMlZaWldGeU9pQmtZWFJsUkhKdmNHUnZkMjVaWldGeVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1cGMxOXlkR3c5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmxVR2xqYTJWeVQzQjBhVzl1Y3k1a2FYSmxZM1JwYjI0Z1BTQmNJbkowYkZ3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUm9hWE11WkdGMFpYQnBZMnRsY2loa1lYUmxVR2xqYTJWeVQzQjBhVzl1Y3lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWJHRnVaMTlqYjJSbElUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkM1a1lYUmxjR2xqYTJWeUxuTmxkRVJsWm1GMWJIUnpLRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pDNWxlSFJsYm1Rb1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2V5ZGtZWFJsUm05eWJXRjBKenBrWVhSbFJtOXliV0YwZlN4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa0xtUmhkR1Z3YVdOclpYSXVjbVZuYVc5dVlXeGJJSE5sYkdZdWJHRnVaMTlqYjJSbFhWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQzVrWVhSbGNHbGphMlZ5TG5ObGRFUmxabUYxYkhSektGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkM1bGVIUmxibVFvWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZXlka1lYUmxSbTl5YldGMEp6cGtZWFJsUm05eWJXRjBmU3hjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrTG1SaGRHVndhV05yWlhJdWNtVm5hVzl1WVd4YlhDSmxibHdpWFZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0pDZ25MbXhzTFhOcmFXNHRiV1ZzYjI0bktTNXNaVzVuZEdnOVBUQXBlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWkdGMFpWOXdhV05yWlhJdVpHRjBaWEJwWTJ0bGNpZ25kMmxrWjJWMEp5a3VkM0poY0NnblBHUnBkaUJqYkdGemN6MWNJbXhzTFhOcmFXNHRiV1ZzYjI0Z2MyVmhjbU5vWVc1a1ptbHNkR1Z5TFdSaGRHVXRjR2xqYTJWeVhDSXZQaWNwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVaR0YwWlZObGJHVmpkQ0E5SUdaMWJtTjBhVzl1S0dVc0lHWnliMjFmWm1sbGJHUXNJQ1IwYUdsektWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNScGJuQjFkRjltYVdWc1pDQTlJQ1FvWm5KdmJWOW1hV1ZzWkM1cGJuQjFkQzVuWlhRb01Da3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhSb2FYTWdQU0FrS0hSb2FYTXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmtZWFJsWDJacFpXeGtjeUE5SUNScGJuQjFkRjltYVdWc1pDNWpiRzl6WlhOMEtDZGJaR0YwWVMxelppMW1hV1ZzWkMxcGJuQjFkQzEwZVhCbFBWd2laR0YwWlhKaGJtZGxYQ0pkTENCYlpHRjBZUzF6WmkxbWFXVnNaQzFwYm5CMWRDMTBlWEJsUFZ3aVpHRjBaVndpWFNjcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBa1pHRjBaVjltYVdWc1pITXVaV0ZqYUNobWRXNWpkR2x2YmlobExDQnBibVJsZUNsN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa2RHWmZaR0YwWlY5d2FXTnJaWEp6SUQwZ0pDaDBhR2x6S1M1bWFXNWtLRndpTG5ObUxXUmhkR1Z3YVdOclpYSmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdibTlmWkdGMFpWOXdhV05yWlhKeklEMGdKSFJtWDJSaGRHVmZjR2xqYTJWeWN5NXNaVzVuZEdnN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0c1dlgyUmhkR1ZmY0dsamEyVnljejR4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRHaGxiaUJwZENCcGN5QmhJR1JoZEdVZ2NtRnVaMlVzSUhOdklHMWhhMlVnYzNWeVpTQmliM1JvSUdacFpXeGtjeUJoY21VZ1ptbHNiR1ZrSUdKbFptOXlaU0IxY0dSaGRHbHVaMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrY0Y5amIzVnVkR1Z5SUQwZ01EdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaSEJmWlcxd2RIbGZabWxsYkdSZlkyOTFiblFnUFNBd08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMFpsOWtZWFJsWDNCcFkydGxjbk11WldGamFDaG1kVzVqZEdsdmJpZ3BlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KQ2gwYUdsektTNTJZV3dvS1QwOVhDSmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaSEJmWlcxd2RIbGZabWxsYkdSZlkyOTFiblFyS3p0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkhCZlkyOTFiblJsY2lzck8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWhrY0Y5bGJYQjBlVjltYVdWc1pGOWpiM1Z1ZEQwOU1DbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVc1d2RYUlZjR1JoZEdVb01TazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVc1d2RYUlZjR1JoZEdVb01TazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzhxYVdZb0tITmxiR1l1WVhWMGIxOTFjR1JoZEdVOVBURXBmSHdvYzJWc1ppNWhkWFJ2WDJOdmRXNTBYM0psWm5KbGMyaGZiVzlrWlQwOU1Ta3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR052Ym5OdmJHVXViRzluS0NRb2RHaHBjeWtwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JrWVhSbFgyWnBaV3hrY3lBOUlDUjBhR2x6TG1acGJtUW9KMXRrWVhSaExYTm1MV1pwWld4a0xXbHVjSFYwTFhSNWNHVTlYQ0prWVhSbFhDSmRKeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1pHRjBaVjltYVdWc1pITXVaV0ZqYUNobWRXNWpkR2x2YmlobExDQnBibVJsZUNsN1hISmNibHgwWEhSY2RGeDBYSFJqYjI1emIyeGxMbXh2WnloY0lpMHRMUzB0TFMwdExTMHRMVndpS1R0Y2NseHVYSFJjZEZ4MFhIUmNkR052Ym5OdmJHVXViRzluS0Z3aVptOTFibVFnWkdGMFpTQm1hV1ZzWkZ3aUtUdGNjbHh1WEhKY2JseDBYSFJjZEZ4MGZTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pIUm1YMlJoZEdWZmNHbGphMlZ5Y3lBOUlDUjBhR2x6TG1acGJtUW9YQ0l1YzJZdFpHRjBaWEJwWTJ0bGNsd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnViMTlrWVhSbFgzQnBZMnRsY25NZ1BTQWtkR1pmWkdGMFpWOXdhV05yWlhKekxteGxibWQwYUR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlodWIxOWtZWFJsWDNCcFkydGxjbk0rTVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzUm9aVzRnYVhRZ2FYTWdZU0JrWVhSbElISmhibWRsTENCemJ5QnRZV3RsSUhOMWNtVWdZbTkwYUNCbWFXVnNaSE1nWVhKbElHWnBiR3hsWkNCaVpXWnZjbVVnZFhCa1lYUnBibWRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWkhCZlkyOTFiblJsY2lBOUlEQTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1J3WDJWdGNIUjVYMlpwWld4a1gyTnZkVzUwSUQwZ01EdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHWmZaR0YwWlY5d2FXTnJaWEp6TG1WaFkyZ29ablZ1WTNScGIyNG9LWHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1FvZEdocGN5a3VkbUZzS0NrOVBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1J3WDJWdGNIUjVYMlpwWld4a1gyTnZkVzUwS3lzN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSd1gyTnZkVzUwWlhJckt6dGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvWkhCZlpXMXdkSGxmWm1sbGJHUmZZMjkxYm5ROVBUQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWNIVjBWWEJrWVhSbEtERXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1sdWNIVjBWWEJrWVhSbEtERXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTb3ZYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWhaR1JTWVc1blpWTnNhV1JsY25NZ1BTQm1kVzVqZEdsdmJpZ3BYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHMWxkR0ZmY21GdVoyVWdQU0FrZEdocGN5NW1hVzVrS0Z3aUxuTm1MVzFsZEdFdGNtRnVaMlV0YzJ4cFpHVnlYQ0lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KRzFsZEdGZmNtRnVaMlV1YkdWdVozUm9QakFwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSdFpYUmhYM0poYm1kbExtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1IwYUdseklEMGdKQ2gwYUdsektUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiV2x1SUQwZ0pIUm9hWE11WVhSMGNpaGNJbVJoZEdFdGJXbHVYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdFlYZ2dQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzF0WVhoY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE50YVc0Z1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMXpkR0Z5ZEMxdGFXNWNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOdFlYZ2dQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzF6ZEdGeWRDMXRZWGhjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHUnBjM0JzWVhsZmRtRnNkV1ZmWVhNZ1BTQWtkR2hwY3k1aGRIUnlLRndpWkdGMFlTMWthWE53YkdGNUxYWmhiSFZsY3kxaGMxd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzNSbGNDQTlJQ1IwYUdsekxtRjBkSElvWENKa1lYUmhMWE4wWlhCY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1J6ZEdGeWRGOTJZV3dnUFNBa2RHaHBjeTVtYVc1a0tDY3VjMll0Y21GdVoyVXRiV2x1SnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmxibVJmZG1Gc0lEMGdKSFJvYVhNdVptbHVaQ2duTG5ObUxYSmhibWRsTFcxaGVDY3BPMXh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JsWTJsdFlXeGZjR3hoWTJWeklEMGdKSFJvYVhNdVlYUjBjaWhjSW1SaGRHRXRaR1ZqYVcxaGJDMXdiR0ZqWlhOY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJvYjNWellXNWtYM05sY0dWeVlYUnZjaUE5SUNSMGFHbHpMbUYwZEhJb1hDSmtZWFJoTFhSb2IzVnpZVzVrTFhObGNHVnlZWFJ2Y2x3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR1ZqYVcxaGJGOXpaWEJsY21GMGIzSWdQU0FrZEdocGN5NWhkSFJ5S0Z3aVpHRjBZUzFrWldOcGJXRnNMWE5sY0dWeVlYUnZjbHdpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1pwWld4a1gyWnZjbTFoZENBOUlIZE9kVzFpS0h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2JXRnlhem9nWkdWamFXMWhiRjl6WlhCbGNtRjBiM0lzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSbFkybHRZV3h6T2lCd1lYSnpaVVpzYjJGMEtHUmxZMmx0WVd4ZmNHeGhZMlZ6S1N4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHaHZkWE5oYm1RNklIUm9iM1Z6WVc1a1gzTmxjR1Z5WVhSdmNseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ0YVc1ZmRXNW1iM0p0WVhSMFpXUWdQU0J3WVhKelpVWnNiMkYwS0hOdGFXNHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ0YVc1ZlptOXliV0YwZEdWa0lEMGdabWxsYkdSZlptOXliV0YwTG5SdktIQmhjbk5sUm14dllYUW9jMjFwYmlrcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnRZWGhmWm05eWJXRjBkR1ZrSUQwZ1ptbGxiR1JmWm05eWJXRjBMblJ2S0hCaGNuTmxSbXh2WVhRb2MyMWhlQ2twTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdFlYaGZkVzVtYjNKdFlYUjBaV1FnUFNCd1lYSnpaVVpzYjJGMEtITnRZWGdwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2WVd4bGNuUW9iV2x1WDJadmNtMWhkSFJsWkNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5aGJHVnlkQ2h0WVhoZlptOXliV0YwZEdWa0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyRnNaWEowS0dScGMzQnNZWGxmZG1Gc2RXVmZZWE1wTzF4eVhHNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvWkdsemNHeGhlVjkyWVd4MVpWOWhjejA5WENKMFpYaDBhVzV3ZFhSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUnpkR0Z5ZEY5MllXd3VkbUZzS0cxcGJsOW1iM0p0WVhSMFpXUXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWlc1a1gzWmhiQzUyWVd3b2JXRjRYMlp2Y20xaGRIUmxaQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb1pHbHpjR3hoZVY5MllXeDFaVjloY3owOVhDSjBaWGgwWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2MzUmhjblJmZG1Gc0xtaDBiV3dvYldsdVgyWnZjbTFoZEhSbFpDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JsYm1SZmRtRnNMbWgwYld3b2JXRjRYMlp2Y20xaGRIUmxaQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzV2VlVsUGNIUnBiMjV6SUQwZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlZVzVuWlRvZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSjIxcGJpYzZJRnNnY0dGeWMyVkdiRzloZENodGFXNHBJRjBzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQW5iV0Y0SnpvZ1d5QndZWEp6WlVac2IyRjBLRzFoZUNrZ1hWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlMRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6ZEdGeWREb2dXMjFwYmw5bWIzSnRZWFIwWldRc0lHMWhlRjltYjNKdFlYUjBaV1JkTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCb1lXNWtiR1Z6T2lBeUxGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmpiMjV1WldOME9pQjBjblZsTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCemRHVndPaUJ3WVhKelpVWnNiMkYwS0hOMFpYQXBMRnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1ltVm9ZWFpwYjNWeU9pQW5aWGgwWlc1a0xYUmhjQ2NzWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdadmNtMWhkRG9nWm1sbGJHUmZabTl5YldGMFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgzSjBiRDA5TVNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUc1dlZVbFBjSFJwYjI1ekxtUnBjbVZqZEdsdmJpQTlJRndpY25Sc1hDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMeVFvZEdocGN5a3VabWx1WkNoY0lpNXRaWFJoTFhOc2FXUmxjbHdpS1M1dWIxVnBVMnhwWkdWeUtHNXZWVWxQY0hScGIyNXpLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITnNhV1JsY2w5dlltcGxZM1FnUFNBa0tIUm9hWE1wTG1acGJtUW9YQ0l1YldWMFlTMXpiR2xrWlhKY0lpbGJNRjA3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDQmNJblZ1WkdWbWFXNWxaRndpSUNFOVBTQjBlWEJsYjJZb0lITnNhV1JsY2w5dlltcGxZM1F1Ym05VmFWTnNhV1JsY2lBcElDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJSbGMzUnliM2tnYVdZZ2FYUWdaWGhwYzNSekxpNGdkR2hwY3lCdFpXRnVjeUJ6YjIxbGFHOTNJR0Z1YjNSb1pYSWdhVzV6ZEdGdVkyVWdhR0ZrSUdsdWFYUnBZV3hwYzJWa0lHbDBMaTVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJ4cFpHVnlYMjlpYW1WamRDNXViMVZwVTJ4cFpHVnlMbVJsYzNSeWIza29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5amIyNXpiMnhsTG14dlp5aDBlWEJsYjJZb2MyeHBaR1Z5WDI5aWFtVmpkQzV1YjFWcFUyeHBaR1Z5S1NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCdWIxVnBVMnhwWkdWeUxtTnlaV0YwWlNoemJHbGtaWEpmYjJKcVpXTjBMQ0J1YjFWSlQzQjBhVzl1Y3lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUnpkR0Z5ZEY5MllXd3ViMlptS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhOMFlYSjBYM1poYkM1dmJpZ25ZMmhoYm1kbEp5d2dablZ1WTNScGIyNG9LWHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJ4cFpHVnlYMjlpYW1WamRDNXViMVZwVTJ4cFpHVnlMbk5sZENoYkpDaDBhR2x6S1M1MllXd29LU3dnYm5Wc2JGMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWlc1a1gzWmhiQzV2Wm1Zb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1pXNWtYM1poYkM1dmJpZ25ZMmhoYm1kbEp5d2dablZ1WTNScGIyNG9LWHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJ4cFpHVnlYMjlpYW1WamRDNXViMVZwVTJ4cFpHVnlMbk5sZENoYmJuVnNiQ3dnSkNoMGFHbHpLUzUyWVd3b0tWMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2THlSemRHRnlkRjkyWVd3dWFIUnRiQ2h0YVc1ZlptOXliV0YwZEdWa0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkx5UmxibVJmZG1Gc0xtaDBiV3dvYldGNFgyWnZjbTFoZEhSbFpDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5zYVdSbGNsOXZZbXBsWTNRdWJtOVZhVk5zYVdSbGNpNXZabVlvSjNWd1pHRjBaU2NwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5zYVdSbGNsOXZZbXBsWTNRdWJtOVZhVk5zYVdSbGNpNXZiaWduZFhCa1lYUmxKeXdnWm5WdVkzUnBiMjRvSUhaaGJIVmxjeXdnYUdGdVpHeGxJQ2tnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOc2FXUmxjbDl6ZEdGeWRGOTJZV3dnSUQwZ2JXbHVYMlp2Y20xaGRIUmxaRHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITnNhV1JsY2w5bGJtUmZkbUZzSUNBOUlHMWhlRjltYjNKdFlYUjBaV1E3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnZG1Gc2RXVWdQU0IyWVd4MVpYTmJhR0Z1Wkd4bFhUdGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvSUdoaGJtUnNaU0FwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzFoZUY5bWIzSnRZWFIwWldRZ1BTQjJZV3gxWlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTQmxiSE5sSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzFwYmw5bWIzSnRZWFIwWldRZ1BTQjJZV3gxWlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb1pHbHpjR3hoZVY5MllXeDFaVjloY3owOVhDSjBaWGgwYVc1d2RYUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSE4wWVhKMFgzWmhiQzUyWVd3b2JXbHVYMlp2Y20xaGRIUmxaQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtaVzVrWDNaaGJDNTJZV3dvYldGNFgyWnZjbTFoZEhSbFpDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWld4elpTQnBaaWhrYVhOd2JHRjVYM1poYkhWbFgyRnpQVDFjSW5SbGVIUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKSE4wWVhKMFgzWmhiQzVvZEcxc0tHMXBibDltYjNKdFlYUjBaV1FwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR1Z1WkY5MllXd3VhSFJ0YkNodFlYaGZabTl5YldGMGRHVmtLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmFTQjBhR2x1YXlCMGFHVWdablZ1WTNScGIyNGdkR2hoZENCaWRXbHNaSE1nZEdobElGVlNUQ0J1WldWa2N5QjBieUJrWldOdlpHVWdkR2hsSUdadmNtMWhkSFJsWkNCemRISnBibWNnWW1WbWIzSmxJR0ZrWkdsdVp5QjBieUIwYUdVZ2RYSnNYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0NoelpXeG1MbUYxZEc5ZmRYQmtZWFJsUFQweEtYeDhLSE5sYkdZdVlYVjBiMTlqYjNWdWRGOXlaV1p5WlhOb1gyMXZaR1U5UFRFcEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyOXViSGtnZEhKNUlIUnZJSFZ3WkdGMFpTQnBaaUIwYUdVZ2RtRnNkV1Z6SUdoaGRtVWdZV04wZFdGc2JIa2dZMmhoYm1kbFpGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tITnNhV1JsY2w5emRHRnlkRjkyWVd3aFBXMXBibDltYjNKdFlYUjBaV1FwZkh3b2MyeHBaR1Z5WDJWdVpGOTJZV3doUFcxaGVGOW1iM0p0WVhSMFpXUXBLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YVc1d2RYUlZjR1JoZEdVb09EQXdLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVkyeGxZWEpVYVcxbGNpZ3BPeUF2TDJsbmJtOXlaU0JoYm5rZ1kyaGhibWRsY3lCeVpXTmxiblJzZVNCdFlXUmxJR0o1SUhSb1pTQnpiR2xrWlhJZ0tIUm9hWE1nZDJGeklHcDFjM1FnYVc1cGRDQnphRzkxYkdSdUozUWdZMjkxYm5RZ1lYTWdZVzRnZFhCa1lYUmxJR1YyWlc1MEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1cGJtbDBJRDBnWm5WdVkzUnBiMjRvYTJWbGNGOXdZV2RwYm1GMGFXOXVLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0d0bFpYQmZjR0ZuYVc1aGRHbHZiaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCclpXVndYM0JoWjJsdVlYUnBiMjRnUFNCbVlXeHpaVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZEdocGN5NXBibWwwUVhWMGIxVndaR0YwWlVWMlpXNTBjeWdwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxtRjBkR0ZqYUVGamRHbDJaVU5zWVhOektDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IwYUdsekxtRmtaRVJoZEdWUWFXTnJaWEp6S0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVZV1JrVW1GdVoyVlRiR2xrWlhKektDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJsdWFYUWdZMjl0WW04Z1ltOTRaWE5jY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSamIyMWliMkp2ZUNBOUlDUjBhR2x6TG1acGJtUW9YQ0p6Wld4bFkzUmJaR0YwWVMxamIyMWliMkp2ZUQwbk1TZGRYQ0lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KR052YldKdlltOTRMbXhsYm1kMGFENHdLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWTI5dFltOWliM2d1WldGamFDaG1kVzVqZEdsdmJpaHBibVJsZUNBcGUxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtkR2hwYzJOaUlEMGdKQ2dnZEdocGN5QXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ1Y20wZ1BTQWtkR2hwYzJOaUxtRjBkSElvWENKa1lYUmhMV052YldKdlltOTRMVzV5YlZ3aUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0hSNWNHVnZaaUFrZEdocGMyTmlMbU5vYjNObGJpQWhQU0JjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR05vYjNObGJtOXdkR2x2Ym5NZ1BTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXRnlZMmhmWTI5dWRHRnBibk02SUhSeWRXVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ2gwZVhCbGIyWW9ibkp0S1NFOVBWd2lkVzVrWldacGJtVmtYQ0lwSmlZb2JuSnRLU2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmphRzl6Wlc1dmNIUnBiMjV6TG01dlgzSmxjM1ZzZEhOZmRHVjRkQ0E5SUc1eWJUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2THlCellXWmxJSFJ2SUhWelpTQjBhR1VnWm5WdVkzUnBiMjVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5elpXRnlZMmhmWTI5dWRHRnBibk5jY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTVwYzE5eWRHdzlQVEVwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1IwYUdselkySXVZV1JrUTJ4aGMzTW9YQ0pqYUc5elpXNHRjblJzWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjMk5pTG1Ob2IzTmxiaWhqYUc5elpXNXZjSFJwYjI1ektUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCelpXeGxZM1F5YjNCMGFXOXVjeUE5SUh0OU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTVwYzE5eWRHdzlQVEVwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdWamRESnZjSFJwYjI1ekxtUnBjaUE5SUZ3aWNuUnNYQ0k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9LSFI1Y0dWdlppaHVjbTBwSVQwOVhDSjFibVJsWm1sdVpXUmNJaWttSmlodWNtMHBLWHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1ZqZERKdmNIUnBiMjV6TG14aGJtZDFZV2RsUFNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1hDSnViMUpsYzNWc2RITmNJam9nWm5WdVkzUnBiMjRvS1h0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlHNXliVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkR2hwYzJOaUxuTmxiR1ZqZERJb2MyVnNaV04wTW05d2RHbHZibk1wTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHpVM1ZpYldsMGRHbHVaeUE5SUdaaGJITmxPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5cFppQmhhbUY0SUdseklHVnVZV0pzWldRZ2FXNXBkQ0IwYUdVZ2NHRm5hVzVoZEdsdmJseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgyRnFZWGc5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YzJWMGRYQkJhbUY0VUdGbmFXNWhkR2x2YmlncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWtkR2hwY3k1emRXSnRhWFFvZEdocGN5NXpkV0p0YVhSR2IzSnRLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhVzVwZEZkdmIwTnZiVzFsY21ObFEyOXVkSEp2YkhNb0tUc2dMeTkzYjI5amIyMXRaWEpqWlNCdmNtUmxjbUo1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHJaV1Z3WDNCaFoybHVZWFJwYjI0OVBXWmhiSE5sS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbXhoYzNSZmMzVmliV2wwWDNGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdVoyVjBWWEpzVUdGeVlXMXpLR1poYkhObEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1dmJsZHBibVJ2ZDFOamNtOXNiQ0E5SUdaMWJtTjBhVzl1S0dWMlpXNTBLVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tDRnpaV3htTG1selgyeHZZV1JwYm1kZmJXOXlaU2tnSmlZZ0tDRnpaV3htTG1selgyMWhlRjl3WVdkbFpDa3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCM2FXNWtiM2RmYzJOeWIyeHNJRDBnSkNoM2FXNWtiM2NwTG5OamNtOXNiRlJ2Y0NncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhkcGJtUnZkMTl6WTNKdmJHeGZZbTkwZEc5dElEMGdKQ2gzYVc1a2IzY3BMbk5qY205c2JGUnZjQ2dwSUNzZ0pDaDNhVzVrYjNjcExtaGxhV2RvZENncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOamNtOXNiRjl2Wm1aelpYUWdQU0J3WVhKelpVbHVkQ2h6Wld4bUxtbHVabWx1YVhSbFgzTmpjbTlzYkY5MGNtbG5aMlZ5WDJGdGIzVnVkQ2s3THk5elpXeG1MbWx1Wm1sdWFYUmxYM05qY205c2JGOTBjbWxuWjJWeVgyRnRiM1Z1ZER0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNaaGNpQWtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2lBOUlHcFJkV1Z5ZVNna2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxaGFtRjRMWFJoY21kbGRGd2lLU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNGthVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpNXNaVzVuZEdnOVBURXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGMzVnNkSE5mYzJOeWIyeHNYMkp2ZEhSdmJTQTlJSE5sYkdZdUpHbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJdWIyWm1jMlYwS0NrdWRHOXdJQ3NnYzJWc1ppNGthVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpNW9aV2xuYUhRb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTkyWVhJZ2IyWm1jMlYwSUQwZ0tDUmhhbUY0WDNKbGMzVnNkSE5mWTI5dWRHRnBibVZ5TG05bVpuTmxkQ2dwTG5SdmNDQXJJQ1JoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxtaGxhV2RvZENncEtTQXRJSGRwYm1SdmQxOXpZM0p2Ykd3N1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHOW1abk5sZENBOUlDaHpaV3htTGlScGJtWnBibWwwWlY5elkzSnZiR3hmWTI5dWRHRnBibVZ5TG05bVpuTmxkQ2dwTG5SdmNDQXJJSE5sYkdZdUpHbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJdWFHVnBaMmgwS0NrcElDMGdkMmx1Wkc5M1gzTmpjbTlzYkR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kMmx1Wkc5M1gzTmpjbTlzYkY5aWIzUjBiMjBnUGlCeVpYTjFiSFJ6WDNOamNtOXNiRjlpYjNSMGIyMGdLeUJ6WTNKdmJHeGZiMlptYzJWMEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzYjJGa1RXOXlaVkpsYzNWc2RITW9LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIc3ZMMlJ2Ym5RZ2JHOWhaQ0J0YjNKbFhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnTHlwcFppaDBhR2x6TG1SbFluVm5YMjF2WkdVOVBWd2lNVndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQjdMeTlsY25KdmNpQnNiMmRuYVc1blhISmNibHh5WEc0Z0lDQWdJQ0FnSUNCcFppaHpaV3htTG1selgyRnFZWGc5UFRFcFhISmNiaUFnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1a2FYTndiR0Y1WDNKbGMzVnNkSE5mWVhNOVBWd2ljMmh2Y25SamIyUmxYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNXNaVzVuZEdnOVBUQXBYSEpjYmlBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdZMjl1YzI5c1pTNXNiMmNvWENKVFpXRnlZMmdnSmlCR2FXeDBaWElnZkNCR2IzSnRJRWxFT2lCY0lpdHpaV3htTG5ObWFXUXJYQ0k2SUdOaGJtNXZkQ0JtYVc1a0lIUm9aU0J5WlhOMWJIUnpJR052Ym5SaGFXNWxjaUJ2YmlCMGFHbHpJSEJoWjJVZ0xTQmxibk4xY21VZ2VXOTFJSFZ6WlNCMGFHVWdjMmh2Y25SamIyUmxJRzl1SUhSb2FYTWdjR0ZuWlNCdmNpQndjbTkyYVdSbElHRWdWVkpNSUhkb1pYSmxJR2wwSUdOaGJpQmlaU0JtYjNWdVpDQW9VbVZ6ZFd4MGN5QlZVa3dwWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lHbG1LSE5sYkdZdWNtVnpkV3gwYzE5MWNtdzlQVndpWENJcFhISmNiaUFnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ1kyOXVjMjlzWlM1c2IyY29YQ0pUWldGeVkyZ2dKaUJHYVd4MFpYSWdmQ0JHYjNKdElFbEVPaUJjSWl0elpXeG1Mbk5tYVdRclhDSTZJRTV2SUZKbGMzVnNkSE1nVlZKTUlHaGhjeUJpWldWdUlHUmxabWx1WldRZ0xTQmxibk4xY21VZ2RHaGhkQ0I1YjNVZ1pXNTBaWElnZEdocGN5QnBiaUJ2Y21SbGNpQjBieUIxYzJVZ2RHaGxJRk5sWVhKamFDQkdiM0p0SUc5dUlHRnVlU0J3WVdkbEtWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0F2TDJOb1pXTnJJR2xtSUhKbGMzVnNkSE1nVlZKTUlHbHpJRzl1SUhOaGJXVWdaRzl0WVdsdUlHWnZjaUJ3YjNSbGJuUnBZV3dnWTNKdmMzTWdaRzl0WVdsdUlHVnljbTl5YzF4eVhHNGdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxpUmhhbUY0WDNKbGMzVnNkSE5mWTI5dWRHRnBibVZ5TG14bGJtZDBhRDA5TUNsY2NseHVJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNCamIyNXpiMnhsTG14dlp5aGNJbE5sWVhKamFDQW1JRVpwYkhSbGNpQjhJRVp2Y20wZ1NVUTZJRndpSzNObGJHWXVjMlpwWkN0Y0lqb2dZMkZ1Ym05MElHWnBibVFnZEdobElISmxjM1ZzZEhNZ1kyOXVkR0ZwYm1WeUlHOXVJSFJvYVhNZ2NHRm5aU0F0SUdWdWMzVnlaU0I1YjNVZ2RYTmxJR0Z5WlNCMWMybHVaeUIwYUdVZ2NtbG5hSFFnWTI5dWRHVnVkQ0J6Wld4bFkzUnZjbHdpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNCOUtpOWNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWMzUnlhWEJSZFdWeWVWTjBjbWx1WjBGdVpFaGhjMmhHY205dFVHRjBhQ0E5SUdaMWJtTjBhVzl1S0hWeWJDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z2RYSnNMbk53YkdsMEtGd2lQMXdpS1Zzd1hTNXpjR3hwZENoY0lpTmNJaWxiTUYwN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1kMWNDQTlJR1oxYm1OMGFXOXVLQ0J1WVcxbExDQjFjbXdnS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUlDZ2hkWEpzS1NCMWNtd2dQU0JzYjJOaGRHbHZiaTVvY21WbVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUc1aGJXVWdQU0J1WVcxbExuSmxjR3hoWTJVb0wxdGNYRnRkTHl4Y0lseGNYRnhjWEZ0Y0lpa3VjbVZ3YkdGalpTZ3ZXMXhjWFYwdkxGd2lYRnhjWEZ4Y1hWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbFoyVjRVeUE5SUZ3aVcxeGNYRncvSmwxY0lpdHVZVzFsSzF3aVBTaGJYaVlqWFNvcFhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ5WldkbGVDQTlJRzVsZHlCU1pXZEZlSEFvSUhKbFoyVjRVeUFwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NtVnpkV3gwY3lBOUlISmxaMlY0TG1WNFpXTW9JSFZ5YkNBcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnY21WemRXeDBjeUE5UFNCdWRXeHNJRDhnYm5Wc2JDQTZJSEpsYzNWc2RITmJNVjA3WEhKY2JpQWdJQ0FnSUNBZ2ZUdGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVoyVjBWWEpzVUdGeVlXMXpJRDBnWm5WdVkzUnBiMjRvYTJWbGNGOXdZV2RwYm1GMGFXOXVMQ0IwZVhCbExDQmxlR05zZFdSbEtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LR3RsWlhCZmNHRm5hVzVoZEdsdmJpazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJyWldWd1gzQmhaMmx1WVhScGIyNGdQU0IwY25WbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4cWFXWW9kSGx3Wlc5bUtHVjRZMngxWkdVcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHVjRZMngxWkdVZ1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnZlNvdlhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9kSGx3WlNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQjBlWEJsSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliRjl3WVhKaGJYTmZjM1J5SUQwZ1hDSmNJanRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dklHZGxkQ0JoYkd3Z2NHRnlZVzF6SUdaeWIyMGdabWxsYkdSelhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQjFjbXhmY0dGeVlXMXpYMkZ5Y21GNUlEMGdjSEp2WTJWemMxOW1iM0p0TG1kbGRGVnliRkJoY21GdGN5aHpaV3htS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJzWlc1bmRHZ2dQU0JQWW1wbFkzUXVhMlY1Y3loMWNteGZjR0Z5WVcxelgyRnljbUY1S1M1c1pXNW5kR2c3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCamIzVnVkQ0E5SURBN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9aWGhqYkhWa1pTa2hQVndpZFc1a1pXWnBibVZrWENJcElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNoMWNteGZjR0Z5WVcxelgyRnljbUY1TG1oaGMwOTNibEJ5YjNCbGNuUjVLR1Y0WTJ4MVpHVXBLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdiR1Z1WjNSb0xTMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtHeGxibWQwYUQ0d0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1iM0lnS0haaGNpQnJJR2x1SUhWeWJGOXdZWEpoYlhOZllYSnlZWGtwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2RYSnNYM0JoY21GdGMxOWhjbkpoZVM1b1lYTlBkMjVRY205d1pYSjBlU2hyS1NrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHTmhibDloWkdRZ1BTQjBjblZsTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaDBlWEJsYjJZb1pYaGpiSFZrWlNraFBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dzOVBXVjRZMngxWkdVcElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmpZVzVmWVdSa0lEMGdabUZzYzJVN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0dOaGJsOWhaR1FwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFZ5YkY5d1lYSmhiWE5mYzNSeUlDczlJR3NnS3lCY0lqMWNJaUFySUhWeWJGOXdZWEpoYlhOZllYSnlZWGxiYTEwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLR052ZFc1MElEd2diR1Z1WjNSb0lDMGdNU2tnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhWeWJGOXdZWEpoYlhOZmMzUnlJQ3M5SUZ3aUpsd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHTnZkVzUwS3lzN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeGRXVnllVjl3WVhKaGJYTWdQU0JjSWx3aU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTltYjNKdElIQmhjbUZ0Y3lCaGN5QjFjbXdnY1hWbGNua2djM1J5YVc1blhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmRtRnlJR1p2Y20xZmNHRnlZVzF6SUQwZ2RYSnNYM0JoY21GdGMxOXpkSEl1Y21Wd2JHRmpaVUZzYkNoY0lpVXlRbHdpTENCY0lpdGNJaWt1Y21Wd2JHRmpaVUZzYkNoY0lpVXlRMXdpTENCY0lpeGNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdadmNtMWZjR0Z5WVcxeklEMGdkWEpzWDNCaGNtRnRjMTl6ZEhJN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMmRsZENCMWNtd2djR0Z5WVcxeklHWnliMjBnZEdobElHWnZjbTBnYVhSelpXeG1JQ2gzYUdGMElIUm9aU0IxYzJWeUlHaGhjeUJ6Wld4bFkzUmxaQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVxYjJsdVZYSnNVR0Z5WVcwb2NYVmxjbmxmY0dGeVlXMXpMQ0JtYjNKdFgzQmhjbUZ0Y3lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMkZrWkNCd1lXZHBibUYwYVc5dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtHdGxaWEJmY0dGbmFXNWhkR2x2YmowOWRISjFaU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIQmhaMlZPZFcxaVpYSWdQU0J6Wld4bUxpUmhhbUY0WDNKbGMzVnNkSE5mWTI5dWRHRnBibVZ5TG1GMGRISW9YQ0prWVhSaExYQmhaMlZrWENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIUjVjR1Z2Wmlod1lXZGxUblZ0WW1WeUtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCd1lXZGxUblZ0WW1WeUlEMGdNVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlod1lXZGxUblZ0WW1WeVBqRXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVxYjJsdVZYSnNVR0Z5WVcwb2NYVmxjbmxmY0dGeVlXMXpMQ0JjSW5ObVgzQmhaMlZrUFZ3aUszQmhaMlZPZFcxaVpYSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyRmtaQ0J6Wm1sa1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmNYVmxjbmxmY0dGeVlXMXpJRDBnYzJWc1ppNXFiMmx1VlhKc1VHRnlZVzBvY1hWbGNubGZjR0Z5WVcxekxDQmNJbk5tYVdROVhDSXJjMlZzWmk1elptbGtLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dklHeHZiM0FnZEdoeWIzVm5hQ0JoYm5rZ1pYaDBjbUVnY0dGeVlXMXpJQ2htY205dElHVjRkQ0J3YkhWbmFXNXpLU0JoYm1RZ1lXUmtJSFJ2SUhSb1pTQjFjbXdnS0dsbElIZHZiMk52YlcxbGNtTmxJR0J2Y21SbGNtSjVZQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeXAyWVhJZ1pYaDBjbUZmY1hWbGNubGZjR0Z5WVcwZ1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHeGxibWQwYUNBOUlFOWlhbVZqZEM1clpYbHpLSE5sYkdZdVpYaDBjbUZmY1hWbGNubGZjR0Z5WVcxektTNXNaVzVuZEdnN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNCMllYSWdZMjkxYm5RZ1BTQXdPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtHeGxibWQwYUQ0d0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJR1p2Y2lBb2RtRnlJR3NnYVc0Z2MyVnNaaTVsZUhSeVlWOXhkV1Z5ZVY5d1lYSmhiWE1wSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaHpaV3htTG1WNGRISmhYM0YxWlhKNVgzQmhjbUZ0Y3k1b1lYTlBkMjVRY205d1pYSjBlU2hyS1NrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVaWGgwY21GZmNYVmxjbmxmY0dGeVlXMXpXMnRkSVQxY0lsd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdaWGgwY21GZmNYVmxjbmxmY0dGeVlXMGdQU0JySzF3aVBWd2lLM05sYkdZdVpYaDBjbUZmY1hWbGNubGZjR0Z5WVcxelcydGRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVxYjJsdVZYSnNVR0Z5WVcwb2NYVmxjbmxmY0dGeVlXMXpMQ0JsZUhSeVlWOXhkV1Z5ZVY5d1lYSmhiU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FxTDF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J4ZFdWeWVWOXdZWEpoYlhNZ1BTQnpaV3htTG1Ga1pGRjFaWEo1VUdGeVlXMXpLSEYxWlhKNVgzQmhjbUZ0Y3l3Z2MyVnNaaTVsZUhSeVlWOXhkV1Z5ZVY5d1lYSmhiWE11WVd4c0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVWhQVndpWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVoWkdSUmRXVnllVkJoY21GdGN5aHhkV1Z5ZVY5d1lYSmhiWE1zSUhObGJHWXVaWGgwY21GZmNYVmxjbmxmY0dGeVlXMXpXM1I1Y0dWZEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlIRjFaWEo1WDNCaGNtRnRjenRjY2x4dUlDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1aFpHUlJkV1Z5ZVZCaGNtRnRjeUE5SUdaMWJtTjBhVzl1S0hGMVpYSjVYM0JoY21GdGN5d2dibVYzWDNCaGNtRnRjeWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmxlSFJ5WVY5eGRXVnllVjl3WVhKaGJTQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQnNaVzVuZEdnZ1BTQlBZbXBsWTNRdWEyVjVjeWh1WlhkZmNHRnlZVzF6S1M1c1pXNW5kR2c3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCamIzVnVkQ0E5SURBN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWhzWlc1bmRHZytNQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnZjaUFvZG1GeUlHc2dhVzRnYm1WM1gzQmhjbUZ0Y3lrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaHVaWGRmY0dGeVlXMXpMbWhoYzA5M2JsQnliM0JsY25SNUtHc3BLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWh1WlhkZmNHRnlZVzF6VzJ0ZElUMWNJbHdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsZUhSeVlWOXhkV1Z5ZVY5d1lYSmhiU0E5SUdzclhDSTlYQ0lyYm1WM1gzQmhjbUZ0YzF0clhUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdWFtOXBibFZ5YkZCaGNtRnRLSEYxWlhKNVgzQmhjbUZ0Y3l3Z1pYaDBjbUZmY1hWbGNubGZjR0Z5WVcwcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdjWFZsY25sZmNHRnlZVzF6TzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtRmtaRlZ5YkZCaGNtRnRJRDBnWm5WdVkzUnBiMjRvZFhKc0xDQnpkSEpwYm1jcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWVdSa1gzQmhjbUZ0Y3lBOUlGd2lYQ0k3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaDFjbXdoUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hWeWJDNXBibVJsZUU5bUtGd2lQMXdpS1NBaFBTQXRNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JoWkdSZmNHRnlZVzF6SUNzOUlGd2lKbHdpTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRYSnNJRDBnZEdocGN5NTBjbUZwYkdsdVoxTnNZWE5vU1hRb2RYSnNLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmhaR1JmY0dGeVlXMXpJQ3M5SUZ3aVAxd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppaHpkSEpwYm1jaFBWd2lYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z2RYSnNJQ3NnWVdSa1gzQmhjbUZ0Y3lBcklITjBjbWx1Wnp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCMWNtdzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtcHZhVzVWY214UVlYSmhiU0E5SUdaMWJtTjBhVzl1S0hCaGNtRnRjeXdnYzNSeWFXNW5LVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHRmtaRjl3WVhKaGJYTWdQU0JjSWx3aU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvY0dGeVlXMXpJVDFjSWx3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmhaR1JmY0dGeVlXMXpJQ3M5SUZ3aUpsd2lPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloemRISnBibWNoUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnY0dGeVlXMXpJQ3NnWVdSa1gzQmhjbUZ0Y3lBcklITjBjbWx1Wnp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCd1lYSmhiWE03WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbk5sZEVGcVlYaFNaWE4xYkhSelZWSk1jeUE5SUdaMWJtTjBhVzl1S0hGMVpYSjVYM0JoY21GdGN5bGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWh6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bUtUMDlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVoYW1GNFgzSmxjM1ZzZEhOZlkyOXVaaUE5SUc1bGR5QkJjbkpoZVNncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkd2NtOWpaWE56YVc1blgzVnliQ2RkSUQwZ1hDSmNJanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aGFtRjRYM0psYzNWc2RITmZZMjl1WmxzbmNtVnpkV3gwYzE5MWNtd25YU0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WVdwaGVGOXlaWE4xYkhSelgyTnZibVpiSjJSaGRHRmZkSGx3WlNkZElEMGdYQ0pjSWp0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZhV1lvYzJWc1ppNWhhbUY0WDNWeWJDRTlYQ0pjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTVrYVhOd2JHRjVYM0psYzNWc2RGOXRaWFJvYjJROVBWd2ljMmh2Y25SamIyUmxYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHN2TDNSb1pXNGdkMlVnZDJGdWRDQjBieUJrYnlCaElISmxjWFZsYzNRZ2RHOGdkR2hsSUdGcVlYZ2daVzVrY0c5cGJuUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1aYkozSmxjM1ZzZEhOZmRYSnNKMTBnUFNCelpXeG1MbUZrWkZWeWJGQmhjbUZ0S0hObGJHWXVjbVZ6ZFd4MGMxOTFjbXdzSUhGMVpYSjVYM0JoY21GdGN5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OWhaR1FnYkdGdVp5QmpiMlJsSUhSdklHRnFZWGdnWVhCcElISmxjWFZsYzNRc0lHeGhibWNnWTI5a1pTQnphRzkxYkdRZ1lXeHlaV0ZrZVNCaVpTQnBiaUIwYUdWeVpTQm1iM0lnYjNSb1pYSWdjbVZ4ZFdWemRITWdLR2xsTENCemRYQndiR2xsWkNCcGJpQjBhR1VnVW1WemRXeDBjeUJWVWt3cFhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2MyVnNaaTVzWVc1blgyTnZaR1VoUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl6YnlCaFpHUWdhWFJjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnhkV1Z5ZVY5d1lYSmhiWE1nUFNCelpXeG1MbXB2YVc1VmNteFFZWEpoYlNoeGRXVnllVjl3WVhKaGJYTXNJRndpYkdGdVp6MWNJaXR6Wld4bUxteGhibWRmWTI5a1pTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aGFtRjRYM0psYzNWc2RITmZZMjl1WmxzbmNISnZZMlZ6YzJsdVoxOTFjbXduWFNBOUlITmxiR1l1WVdSa1ZYSnNVR0Z5WVcwb2MyVnNaaTVoYW1GNFgzVnliQ3dnY1hWbGNubGZjR0Z5WVcxektUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2YzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25aR0YwWVY5MGVYQmxKMTBnUFNBbmFuTnZiaWM3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYzJWc1ppNWthWE53YkdGNVgzSmxjM1ZzZEY5dFpYUm9iMlE5UFZ3aWNHOXpkRjkwZVhCbFgyRnlZMmhwZG1WY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjSEp2WTJWemMxOW1iM0p0TG5ObGRGUmhlRUZ5WTJocGRtVlNaWE4xYkhSelZYSnNLSE5sYkdZc0lITmxiR1l1Y21WemRXeDBjMTkxY213cE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGMzVnNkSE5mZFhKc0lEMGdjSEp2WTJWemMxOW1iM0p0TG1kbGRGSmxjM1ZzZEhOVmNtd29jMlZzWml3Z2MyVnNaaTV5WlhOMWJIUnpYM1Z5YkNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jbVZ6ZFd4MGMxOTFjbXduWFNBOUlITmxiR1l1WVdSa1ZYSnNVR0Z5WVcwb2NtVnpkV3gwYzE5MWNtd3NJSEYxWlhKNVgzQmhjbUZ0Y3lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkd2NtOWpaWE56YVc1blgzVnliQ2RkSUQwZ2MyVnNaaTVoWkdSVmNteFFZWEpoYlNoeVpYTjFiSFJ6WDNWeWJDd2djWFZsY25sZmNHRnlZVzF6S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0JwWmloelpXeG1MbVJwYzNCc1lYbGZjbVZ6ZFd4MFgyMWxkR2h2WkQwOVhDSmpkWE4wYjIxZmQyOXZZMjl0YldWeVkyVmZjM1J2Y21WY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjSEp2WTJWemMxOW1iM0p0TG5ObGRGUmhlRUZ5WTJocGRtVlNaWE4xYkhSelZYSnNLSE5sYkdZc0lITmxiR1l1Y21WemRXeDBjMTkxY213cE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGMzVnNkSE5mZFhKc0lEMGdjSEp2WTJWemMxOW1iM0p0TG1kbGRGSmxjM1ZzZEhOVmNtd29jMlZzWml3Z2MyVnNaaTV5WlhOMWJIUnpYM1Z5YkNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhhbUY0WDNKbGMzVnNkSE5mWTI5dVpsc25jbVZ6ZFd4MGMxOTFjbXduWFNBOUlITmxiR1l1WVdSa1ZYSnNVR0Z5WVcwb2NtVnpkV3gwYzE5MWNtd3NJSEYxWlhKNVgzQmhjbUZ0Y3lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkd2NtOWpaWE56YVc1blgzVnliQ2RkSUQwZ2MyVnNaaTVoWkdSVmNteFFZWEpoYlNoeVpYTjFiSFJ6WDNWeWJDd2djWFZsY25sZmNHRnlZVzF6S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdMeTl2ZEdobGNuZHBjMlVnZDJVZ2QyRnVkQ0IwYnlCd2RXeHNJSFJvWlNCeVpYTjFiSFJ6SUdScGNtVmpkR3g1SUdaeWIyMGdkR2hsSUhKbGMzVnNkSE1nY0dGblpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aGFtRjRYM0psYzNWc2RITmZZMjl1WmxzbmNtVnpkV3gwYzE5MWNtd25YU0E5SUhObGJHWXVZV1JrVlhKc1VHRnlZVzBvYzJWc1ppNXlaWE4xYkhSelgzVnliQ3dnY1hWbGNubGZjR0Z5WVcxektUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1aYkozQnliMk5sYzNOcGJtZGZkWEpzSjEwZ1BTQnpaV3htTG1Ga1pGVnliRkJoY21GdEtITmxiR1l1WVdwaGVGOTFjbXdzSUhGMVpYSjVYM0JoY21GdGN5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKMlJoZEdGZmRIbHdaU2RkSUQwZ0oyaDBiV3duTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR3Y205alpYTnphVzVuWDNWeWJDZGRJRDBnYzJWc1ppNWhaR1JSZFdWeWVWQmhjbUZ0Y3loelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR3Y205alpYTnphVzVuWDNWeWJDZGRMQ0J6Wld4bUxtVjRkSEpoWDNGMVpYSjVYM0JoY21GdGMxc25ZV3BoZUNkZEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1aYkoyUmhkR0ZmZEhsd1pTZGRJRDBnYzJWc1ppNWhhbUY0WDJSaGRHRmZkSGx3WlR0Y2NseHVJQ0FnSUNBZ0lDQjlPMXh5WEc1Y2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11ZFhCa1lYUmxURzloWkdWeVZHRm5JRDBnWm5WdVkzUnBiMjRvSkc5aWFtVmpkQ3dnZEdGblRtRnRaU2tnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1J3WVhKbGJuUTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbWx1Wm1sdWFYUmxYM05qY205c2JGOXlaWE4xYkhSZlkyeGhjM01oUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1J3WVhKbGJuUWdQU0J6Wld4bUxpUnBibVpwYm1sMFpWOXpZM0p2Ykd4ZlkyOXVkR0ZwYm1WeUxtWnBibVFvYzJWc1ppNXBibVpwYm1sMFpWOXpZM0p2Ykd4ZmNtVnpkV3gwWDJOc1lYTnpLUzVzWVhOMEtDa3VjR0Z5Wlc1MEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrY0dGeVpXNTBJRDBnYzJWc1ppNGthVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhSaFowNWhiV1VnUFNBa2NHRnlaVzUwTG5CeWIzQW9YQ0owWVdkT1lXMWxYQ0lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSFJoWjFSNWNHVWdQU0FuWkdsMkp6dGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9JQ2dnZEdGblRtRnRaUzUwYjB4dmQyVnlRMkZ6WlNncElEMDlJQ2R2YkNjZ0tTQjhmQ0FvSUhSaFowNWhiV1V1ZEc5TWIzZGxja05oYzJVb0tTQTlQU0FuZFd3bklDa2dLWHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhSaFoxUjVjR1VnUFNBbmJHa25PMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHNWxkeUE5SUNRb0p6d25LM1JoWjFSNWNHVXJKeUF2UGljcExtaDBiV3dvSkc5aWFtVmpkQzVvZEcxc0tDa3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWVhSMGNtbGlkWFJsY3lBOUlDUnZZbXBsWTNRdWNISnZjQ2hjSW1GMGRISnBZblYwWlhOY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2THlCc2IyOXdJSFJvY205MVoyZ2dQSE5sYkdWamRENGdZWFIwY21saWRYUmxjeUJoYm1RZ1lYQndiSGtnZEdobGJTQnZiaUE4WkdsMlBseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBa0xtVmhZMmdvWVhSMGNtbGlkWFJsY3l3Z1puVnVZM1JwYjI0b0tTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrYm1WM0xtRjBkSElvZEdocGN5NXVZVzFsTENCMGFHbHpMblpoYkhWbEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdKRzVsZHp0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVzYjJGa1RXOXlaVkpsYzNWc2RITWdQU0JtZFc1amRHbHZiaWdwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx6WDJ4dllXUnBibWRmYlc5eVpTQTlJSFJ5ZFdVN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMM1J5YVdkblpYSWdjM1JoY25RZ1pYWmxiblJjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdWMlpXNTBYMlJoZEdFZ1BTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wm1sa09pQnpaV3htTG5ObWFXUXNYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IwWVhKblpYUlRaV3hsWTNSdmNqb2djMlZzWmk1aGFtRjRYM1JoY21kbGRGOWhkSFJ5TEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RIbHdaVG9nWENKc2IyRmtYMjF2Y21WY0lpeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJRzlpYW1WamREb2djMlZzWmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTUwY21sbloyVnlSWFpsYm5Rb1hDSnpaanBoYW1GNGMzUmhjblJjSWl3Z1pYWmxiblJmWkdGMFlTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NYVmxjbmxmY0dGeVlXMXpJRDBnYzJWc1ppNW5aWFJWY214UVlYSmhiWE1vZEhKMVpTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1YkdGemRGOXpkV0p0YVhSZmNYVmxjbmxmY0dGeVlXMXpJRDBnYzJWc1ppNW5aWFJWY214UVlYSmhiWE1vWm1Gc2MyVXBPeUF2TDJkeVlXSWdZU0JqYjNCNUlHOW1JR2gwWlNCVlVrd2djR0Z5WVcxeklIZHBkR2h2ZFhRZ2NHRm5hVzVoZEdsdmJpQmhiSEpsWVdSNUlHRmtaR1ZrWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdZV3BoZUY5d2NtOWpaWE56YVc1blgzVnliQ0E5SUZ3aVhDSTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJoYW1GNFgzSmxjM1ZzZEhOZmRYSnNJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdGZmRIbHdaU0E5SUZ3aVhDSTdYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OXViM2NnWVdSa0lIUm9aU0J1WlhjZ2NHRm5hVzVoZEdsdmJseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdibVY0ZEY5d1lXZGxaRjl1ZFcxaVpYSWdQU0IwYUdsekxtTjFjbkpsYm5SZmNHRm5aV1FnS3lBeE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCeGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxtcHZhVzVWY214UVlYSmhiU2h4ZFdWeWVWOXdZWEpoYlhNc0lGd2ljMlpmY0dGblpXUTlYQ0lyYm1WNGRGOXdZV2RsWkY5dWRXMWlaWElwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV6WlhSQmFtRjRVbVZ6ZFd4MGMxVlNUSE1vY1hWbGNubGZjR0Z5WVcxektUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1lXcGhlRjl3Y205alpYTnphVzVuWDNWeWJDQTlJSE5sYkdZdVlXcGhlRjl5WlhOMWJIUnpYMk52Ym1aYkozQnliMk5sYzNOcGJtZGZkWEpzSjEwN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdGcVlYaGZjbVZ6ZFd4MGMxOTFjbXdnUFNCelpXeG1MbUZxWVhoZmNtVnpkV3gwYzE5amIyNW1XeWR5WlhOMWJIUnpYM1Z5YkNkZE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhYM1I1Y0dVZ1BTQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lka1lYUmhYM1I1Y0dVblhUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2WVdKdmNuUWdZVzU1SUhCeVpYWnBiM1Z6SUdGcVlYZ2djbVZ4ZFdWemRITmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1c1lYTjBYMkZxWVhoZmNtVnhkV1Z6ZENsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzWVhOMFgyRnFZWGhmY21WeGRXVnpkQzVoWW05eWRDZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MblZ6WlY5elkzSnZiR3hmYkc5aFpHVnlQVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR3h2WVdSbGNpQTlJQ1FvSnp4a2FYWXZQaWNzZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ2RqYkdGemN5YzZJQ2R6WldGeVkyZ3RabWxzZEdWeUxYTmpjbTlzYkMxc2IyRmthVzVuSjF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdMeTh1WVhCd1pXNWtWRzhvYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkd4dllXUmxjaUE5SUhObGJHWXVkWEJrWVhSbFRHOWhaR1Z5VkdGbktDUnNiMkZrWlhJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVhVzVtYVc1cGRHVlRZM0p2Ykd4QmNIQmxibVFvSkd4dllXUmxjaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXViR0Z6ZEY5aGFtRjRYM0psY1hWbGMzUWdQU0FrTG1kbGRDaGhhbUY0WDNCeWIyTmxjM05wYm1kZmRYSnNMQ0JtZFc1amRHbHZiaWhrWVhSaExDQnpkR0YwZFhNc0lISmxjWFZsYzNRcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WTNWeWNtVnVkRjl3WVdkbFpDc3JPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDQTlJRzUxYkd3N1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHlvZ2MyTnliMnhzSUNvdlhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM05sYkdZdWMyTnliMnhzVW1WemRXeDBjeWdwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZFhCa1lYUmxjeUIwYUdVZ2NtVnpkWFJzY3lBbUlHWnZjbTBnYUhSdGJGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1aFpHUlNaWE4xYkhSektHUmhkR0VzSUdSaGRHRmZkSGx3WlNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlMQ0JrWVhSaFgzUjVjR1VwTG1aaGFXd29ablZ1WTNScGIyNG9hbkZZU0ZJc0lIUmxlSFJUZEdGMGRYTXNJR1Z5Y205eVZHaHliM2R1S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdaR0YwWVNBOUlIdDlPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNXpabWxrSUQwZ2MyVnNaaTV6Wm1sa08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1dlltcGxZM1FnUFNCelpXeG1PMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNTBZWEpuWlhSVFpXeGxZM1J2Y2lBOUlITmxiR1l1WVdwaGVGOTBZWEpuWlhSZllYUjBjanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVZV3BoZUZWU1RDQTlJR0ZxWVhoZmNISnZZMlZ6YzJsdVoxOTFjbXc3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMbXB4V0VoU0lEMGdhbkZZU0ZJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG5SbGVIUlRkR0YwZFhNZ1BTQjBaWGgwVTNSaGRIVnpPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNWxjbkp2Y2xSb2NtOTNiaUE5SUdWeWNtOXlWR2h5YjNkdU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1MGNtbG5aMlZ5UlhabGJuUW9YQ0p6WmpwaGFtRjRaWEp5YjNKY0lpd2daR0YwWVNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZLbU52Ym5OdmJHVXViRzluS0Z3aVFVcEJXQ0JHUVVsTVhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdOdmJuTnZiR1V1Ykc5bktHVXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdOdmJuTnZiR1V1Ykc5bktIZ3BPeW92WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtTNWhiSGRoZVhNb1puVnVZM1JwYjI0b0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWkdGMFlTQTlJSHQ5TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzV6Wm1sa0lEMGdjMlZzWmk1elptbGtPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWkdGMFlTNTBZWEpuWlhSVFpXeGxZM1J2Y2lBOUlITmxiR1l1WVdwaGVGOTBZWEpuWlhSZllYUjBjanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXViMkpxWldOMElEMGdjMlZzWmp0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MblZ6WlY5elkzSnZiR3hmYkc5aFpHVnlQVDB4S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSc2IyRmtaWEl1WkdWMFlXTm9LQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBjMTlzYjJGa2FXNW5YMjF2Y21VZ1BTQm1ZV3h6WlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxuUnlhV2RuWlhKRmRtVnVkQ2hjSW5ObU9tRnFZWGhtYVc1cGMyaGNJaXdnWkdGMFlTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NW1aWFJqYUVGcVlYaFNaWE4xYkhSeklEMGdablZ1WTNScGIyNG9LVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5MGNtbG5aMlZ5SUhOMFlYSjBJR1YyWlc1MFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmxkbVZ1ZEY5a1lYUmhJRDBnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyWnBaRG9nYzJWc1ppNXpabWxrTEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RHRnlaMlYwVTJWc1pXTjBiM0k2SUhObGJHWXVZV3BoZUY5MFlYSm5aWFJmWVhSMGNpeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFI1Y0dVNklGd2liRzloWkY5eVpYTjFiSFJ6WENJc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnZZbXBsWTNRNklITmxiR1pjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVkSEpwWjJkbGNrVjJaVzUwS0Z3aWMyWTZZV3BoZUhOMFlYSjBYQ0lzSUdWMlpXNTBYMlJoZEdFcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTl5WldadlkzVnpJR0Z1ZVNCcGJuQjFkQ0JtYVdWc1pITWdZV1owWlhJZ2RHaGxJR1p2Y20wZ2FHRnpJR0psWlc0Z2RYQmtZWFJsWkZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHeGhjM1JmWVdOMGFYWmxYMmx1Y0hWMFgzUmxlSFFnUFNBa2RHaHBjeTVtYVc1a0tDZHBibkIxZEZ0MGVYQmxQVndpZEdWNGRGd2lYVHBtYjJOMWN5Y3BMbTV2ZENoY0lpNXpaaTFrWVhSbGNHbGphMlZ5WENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCcFppZ2tiR0Z6ZEY5aFkzUnBkbVZmYVc1d2RYUmZkR1Y0ZEM1c1pXNW5kR2c5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJzWVhOMFgyRmpkR2wyWlY5cGJuQjFkRjkwWlhoMElEMGdKR3hoYzNSZllXTjBhWFpsWDJsdWNIVjBYM1JsZUhRdVlYUjBjaWhjSW01aGJXVmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbUZrWkVOc1lYTnpLRndpYzJWaGNtTm9MV1pwYkhSbGNpMWthWE5oWW14bFpGd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjSEp2WTJWemMxOW1iM0p0TG1ScGMyRmliR1ZKYm5CMWRITW9jMlZzWmlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMlpoWkdVZ2IzVjBJSEpsYzNWc2RITmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNWhibWx0WVhSbEtIc2diM0JoWTJsMGVUb2dNQzQxSUgwc0lGd2labUZ6ZEZ3aUtUc2dMeTlzYjJGa2FXNW5YSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbUZxWVhoZllXTjBhVzl1UFQxY0luQmhaMmx1WVhScGIyNWNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5dVpXVmtJSFJ2SUhKbGJXOTJaU0JoWTNScGRtVWdabWxzZEdWeUlHWnliMjBnVlZKTVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5eGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxteGhjM1JmYzNWaWJXbDBYM0YxWlhKNVgzQmhjbUZ0Y3p0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDI1dmR5QmhaR1FnZEdobElHNWxkeUJ3WVdkcGJtRjBhVzl1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjR0ZuWlU1MWJXSmxjaUE5SUhObGJHWXVKR0ZxWVhoZmNtVnpkV3gwYzE5amIyNTBZV2x1WlhJdVlYUjBjaWhjSW1SaGRHRXRjR0ZuWldSY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kSGx3Wlc5bUtIQmhaMlZPZFcxaVpYSXBQVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIQmhaMlZPZFcxaVpYSWdQU0F4TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjSEp2WTJWemMxOW1iM0p0TG5ObGRGUmhlRUZ5WTJocGRtVlNaWE4xYkhSelZYSnNLSE5sYkdZc0lITmxiR1l1Y21WemRXeDBjMTkxY213cE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjWFZsY25sZmNHRnlZVzF6SUQwZ2MyVnNaaTVuWlhSVmNteFFZWEpoYlhNb1ptRnNjMlVwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hCaFoyVk9kVzFpWlhJK01TbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnhkV1Z5ZVY5d1lYSmhiWE1nUFNCelpXeG1MbXB2YVc1VmNteFFZWEpoYlNoeGRXVnllVjl3WVhKaGJYTXNJRndpYzJaZmNHRm5aV1E5WENJcmNHRm5aVTUxYldKbGNpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYzJWc1ppNWhhbUY0WDJGamRHbHZiajA5WENKemRXSnRhWFJjSWlsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1WjJWMFZYSnNVR0Z5WVcxektIUnlkV1VwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzWVhOMFgzTjFZbTFwZEY5eGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxtZGxkRlZ5YkZCaGNtRnRjeWhtWVd4elpTazdJQzh2WjNKaFlpQmhJR052Y0hrZ2IyWWdhSFJsSUZWU1RDQndZWEpoYlhNZ2QybDBhRzkxZENCd1lXZHBibUYwYVc5dUlHRnNjbVZoWkhrZ1lXUmtaV1JjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHRnFZWGhmY0hKdlkyVnpjMmx1WjE5MWNtd2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdZV3BoZUY5eVpYTjFiSFJ6WDNWeWJDQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtZWFJoWDNSNWNHVWdQU0JjSWx3aU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1elpYUkJhbUY0VW1WemRXeDBjMVZTVEhNb2NYVmxjbmxmY0dGeVlXMXpLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdZV3BoZUY5d2NtOWpaWE56YVc1blgzVnliQ0E5SUhObGJHWXVZV3BoZUY5eVpYTjFiSFJ6WDJOdmJtWmJKM0J5YjJObGMzTnBibWRmZFhKc0oxMDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHRnFZWGhmY21WemRXeDBjMTkxY213Z1BTQnpaV3htTG1GcVlYaGZjbVZ6ZFd4MGMxOWpiMjVtV3lkeVpYTjFiSFJ6WDNWeWJDZGRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmtZWFJoWDNSNWNHVWdQU0J6Wld4bUxtRnFZWGhmY21WemRXeDBjMTlqYjI1bVd5ZGtZWFJoWDNSNWNHVW5YVHRjY2x4dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQXZMMkZpYjNKMElHRnVlU0J3Y21WMmFXOTFjeUJoYW1GNElISmxjWFZsYzNSelhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YkdGemRGOWhhbUY0WDNKbGNYVmxjM1FwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXViR0Z6ZEY5aGFtRjRYM0psY1hWbGMzUXVZV0p2Y25Rb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c1lYTjBYMkZxWVhoZmNtVnhkV1Z6ZENBOUlDUXVaMlYwS0dGcVlYaGZjSEp2WTJWemMybHVaMTkxY213c0lHWjFibU4wYVc5dUtHUmhkR0VzSUhOMFlYUjFjeXdnY21WeGRXVnpkQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXNZWE4wWDJGcVlYaGZjbVZ4ZFdWemRDQTlJRzUxYkd3N1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHlvZ2MyTnliMnhzSUNvdlhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG5OamNtOXNiRkpsYzNWc2RITW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM1Z3WkdGMFpYTWdkR2hsSUhKbGMzVjBiSE1nSmlCbWIzSnRJR2gwYld4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZFhCa1lYUmxVbVZ6ZFd4MGN5aGtZWFJoTENCa1lYUmhYM1I1Y0dVcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4cUlIVndaR0YwWlNCVlVrd2dLaTljY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRYQmtZWFJsSUhWeWJDQmlaV1p2Y21VZ2NHRm5hVzVoZEdsdmJpd2dZbVZqWVhWelpTQjNaU0J1WldWa0lIUnZJR1J2SUhOdmJXVWdZMmhsWTJ0eklHRm5ZV2x1Y3lCMGFHVWdWVkpNSUdadmNpQnBibVpwYm1sMFpTQnpZM0p2Ykd4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZFhCa1lYUmxWWEpzU0dsemRHOXllU2hoYW1GNFgzSmxjM1ZzZEhOZmRYSnNLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM05sZEhWd0lIQmhaMmx1WVhScGIyNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWMyVjBkWEJCYW1GNFVHRm5hVzVoZEdsdmJpZ3BPMXh5WEc1Y2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYzFOMVltMXBkSFJwYm1jZ1BTQm1ZV3h6WlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2S2lCMWMyVnlJR1JsWmlBcUwxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1cGJtbDBWMjl2UTI5dGJXVnlZMlZEYjI1MGNtOXNjeWdwT3lBdkwzZHZiMk52YlcxbGNtTmxJRzl5WkdWeVlubGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUxDQmtZWFJoWDNSNWNHVXBMbVpoYVd3b1puVnVZM1JwYjI0b2FuRllTRklzSUhSbGVIUlRkR0YwZFhNc0lHVnljbTl5VkdoeWIzZHVLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1pHRjBZU0E5SUh0OU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1elptbGtJRDBnYzJWc1ppNXpabWxrTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzUwWVhKblpYUlRaV3hsWTNSdmNpQTlJSE5sYkdZdVlXcGhlRjkwWVhKblpYUmZZWFIwY2p0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1YjJKcVpXTjBJRDBnYzJWc1pqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdVlXcGhlRlZTVENBOUlHRnFZWGhmY0hKdlkyVnpjMmx1WjE5MWNtdzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtcHhXRWhTSUQwZ2FuRllTRkk3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMblJsZUhSVGRHRjBkWE1nUFNCMFpYaDBVM1JoZEhWek8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1bGNuSnZjbFJvY205M2JpQTlJR1Z5Y205eVZHaHliM2R1TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVwYzFOMVltMXBkSFJwYm1jZ1BTQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZEhKcFoyZGxja1YyWlc1MEtGd2ljMlk2WVdwaGVHVnljbTl5WENJc0lHUmhkR0VwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5cGpiMjV6YjJ4bExteHZaeWhjSWtGS1FWZ2dSa0ZKVEZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JqYjI1emIyeGxMbXh2WnlobEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JqYjI1emIyeGxMbXh2WnloNEtUc3FMMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrdVlXeDNZWGx6S0daMWJtTjBhVzl1S0NsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNXpkRzl3S0hSeWRXVXNkSEoxWlNrdVlXNXBiV0YwWlNoN0lHOXdZV05wZEhrNklERjlMQ0JjSW1aaGMzUmNJaWs3SUM4dlptbHVhWE5vWldRZ2JHOWhaR2x1WjF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1JoZEdFZ1BTQjdmVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVjMlpwWkNBOUlITmxiR1l1YzJacFpEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdWRHRnlaMlYwVTJWc1pXTjBiM0lnUFNCelpXeG1MbUZxWVhoZmRHRnlaMlYwWDJGMGRISTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaExtOWlhbVZqZENBOUlITmxiR1k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTV5WlcxdmRtVkRiR0Z6Y3loY0luTmxZWEpqYUMxbWFXeDBaWEl0WkdsellXSnNaV1JjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQndjbTlqWlhOelgyWnZjbTB1Wlc1aFlteGxTVzV3ZFhSektITmxiR1lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Y21WbWIyTjFjeUIwYUdVZ2JHRnpkQ0JoWTNScGRtVWdkR1Y0ZENCbWFXVnNaRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2JHRnpkRjloWTNScGRtVmZhVzV3ZFhSZmRHVjRkQ0U5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdsdWNIVjBJRDBnVzEwN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGtabWxsYkdSekxtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1lXTjBhWFpsWDJsdWNIVjBJRDBnSkNoMGFHbHpLUzVtYVc1a0tGd2lhVzV3ZFhSYmJtRnRaVDBuWENJcmJHRnpkRjloWTNScGRtVmZhVzV3ZFhSZmRHVjRkQ3RjSWlkZFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlna1lXTjBhWFpsWDJsdWNIVjBMbXhsYm1kMGFEMDlNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKR2x1Y0hWMElEMGdKR0ZqZEdsMlpWOXBibkIxZER0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWdrYVc1d2RYUXViR1Z1WjNSb1BUMHhLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWthVzV3ZFhRdVptOWpkWE1vS1M1MllXd29KR2x1Y0hWMExuWmhiQ2dwS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVtYjJOMWMwTmhiWEJ2S0NScGJuQjFkRnN3WFNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpMbVpwYm1Rb1hDSnBibkIxZEZ0dVlXMWxQU2RmYzJaZmMyVmhjbU5vSjExY0lpa3VabTlqZFhNb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRISnBaMmRsY2tWMlpXNTBLRndpYzJZNllXcGhlR1pwYm1semFGd2lMQ0FnWkdGMFlTQXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNiaUFnSUNBZ0lDQWdmVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1bWIyTjFjME5oYlhCdklEMGdablZ1WTNScGIyNG9hVzV3ZFhSR2FXVnNaQ2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2ZG1GeUlHbHVjSFYwUm1sbGJHUWdQU0JrYjJOMWJXVnVkQzVuWlhSRmJHVnRaVzUwUW5sSlpDaHBaQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtSUNocGJuQjFkRVpwWld4a0lDRTlJRzUxYkd3Z0ppWWdhVzV3ZFhSR2FXVnNaQzUyWVd4MVpTNXNaVzVuZEdnZ0lUMGdNQ2w3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppQW9hVzV3ZFhSR2FXVnNaQzVqY21WaGRHVlVaWGgwVW1GdVoyVXBlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJHYVdWc1pGSmhibWRsSUQwZ2FXNXdkWFJHYVdWc1pDNWpjbVZoZEdWVVpYaDBVbUZ1WjJVb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCR2FXVnNaRkpoYm1kbExtMXZkbVZUZEdGeWRDZ25ZMmhoY21GamRHVnlKeXhwYm5CMWRFWnBaV3hrTG5aaGJIVmxMbXhsYm1kMGFDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1JtbGxiR1JTWVc1blpTNWpiMnhzWVhCelpTZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lFWnBaV3hrVW1GdVoyVXVjMlZzWldOMEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5Wld4elpTQnBaaUFvYVc1d2RYUkdhV1ZzWkM1elpXeGxZM1JwYjI1VGRHRnlkQ0I4ZkNCcGJuQjFkRVpwWld4a0xuTmxiR1ZqZEdsdmJsTjBZWEowSUQwOUlDY3dKeWtnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbGJHVnRUR1Z1SUQwZ2FXNXdkWFJHYVdWc1pDNTJZV3gxWlM1c1pXNW5kR2c3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhVzV3ZFhSR2FXVnNaQzV6Wld4bFkzUnBiMjVUZEdGeWRDQTlJR1ZzWlcxTVpXNDdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXNXdkWFJHYVdWc1pDNXpaV3hsWTNScGIyNUZibVFnUFNCbGJHVnRUR1Z1TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2x1Y0hWMFJtbGxiR1F1Wm05amRYTW9LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZldWc2MyVjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwYm5CMWRFWnBaV3hrTG1adlkzVnpLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUhSb2FYTXVkSEpwWjJkbGNrVjJaVzUwSUQwZ1puVnVZM1JwYjI0b1pYWmxiblJ1WVcxbExDQmtZWFJoS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JsZG1WdWRGOWpiMjUwWVdsdVpYSWdQU0FrS0Z3aUxuTmxZWEpqYUdGdVpHWnBiSFJsY2x0a1lYUmhMWE5tTFdadmNtMHRhV1E5SjF3aUszTmxiR1l1YzJacFpDdGNJaWRkWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBa1pYWmxiblJmWTI5dWRHRnBibVZ5TG5SeWFXZG5aWElvWlhabGJuUnVZVzFsTENCYklHUmhkR0VnWFNrN1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG1abGRHTm9RV3BoZUVadmNtMGdQU0JtZFc1amRHbHZiaWdwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwzUnlhV2RuWlhJZ2MzUmhjblFnWlhabGJuUmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1YyWlc1MFgyUmhkR0VnUFNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpabWxrT2lCelpXeG1Mbk5tYVdRc1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjBZWEpuWlhSVFpXeGxZM1J2Y2pvZ2MyVnNaaTVoYW1GNFgzUmhjbWRsZEY5aGRIUnlMRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZEhsd1pUb2dYQ0ptYjNKdFhDSXNYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J2WW1wbFkzUTZJSE5sYkdaY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZEhKcFoyZGxja1YyWlc1MEtGd2ljMlk2WVdwaGVHWnZjbTF6ZEdGeWRGd2lMQ0JiSUdWMlpXNTBYMlJoZEdFZ1hTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGN5NWhaR1JEYkdGemN5aGNJbk5sWVhKamFDMW1hV3gwWlhJdFpHbHpZV0pzWldSY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIQnliMk5sYzNOZlptOXliUzVrYVhOaFlteGxTVzV3ZFhSektITmxiR1lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1WjJWMFZYSnNVR0Z5WVcxektDazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbXhoYm1kZlkyOWtaU0U5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl6YnlCaFpHUWdhWFJjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhGMVpYSjVYM0JoY21GdGN5QTlJSE5sYkdZdWFtOXBibFZ5YkZCaGNtRnRLSEYxWlhKNVgzQmhjbUZ0Y3l3Z1hDSnNZVzVuUFZ3aUszTmxiR1l1YkdGdVoxOWpiMlJsS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR0ZxWVhoZmNISnZZMlZ6YzJsdVoxOTFjbXdnUFNCelpXeG1MbUZrWkZWeWJGQmhjbUZ0S0hObGJHWXVZV3BoZUY5bWIzSnRYM1Z5YkN3Z2NYVmxjbmxmY0dGeVlXMXpLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdSaGRHRmZkSGx3WlNBOUlGd2lhbk52Ymx3aU8xeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dllXSnZjblFnWVc1NUlIQnlaWFpwYjNWeklHRnFZWGdnY21WeGRXVnpkSE5jY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeXBwWmloelpXeG1MbXhoYzNSZllXcGhlRjl5WlhGMVpYTjBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c1lYTjBYMkZxWVhoZmNtVnhkV1Z6ZEM1aFltOXlkQ2dwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnZlNvdlhISmNibHh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5elpXeG1MbXhoYzNSZllXcGhlRjl5WlhGMVpYTjBJRDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNRdVoyVjBLR0ZxWVhoZmNISnZZMlZ6YzJsdVoxOTFjbXdzSUdaMWJtTjBhVzl1S0dSaGRHRXNJSE4wWVhSMWN5d2djbVZ4ZFdWemRDbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl6Wld4bUxteGhjM1JmWVdwaGVGOXlaWEYxWlhOMElEMGdiblZzYkR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNWd1pHRjBaWE1nZEdobElISmxjM1YwYkhNZ0ppQm1iM0p0SUdoMGJXeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRYQmtZWFJsUm05eWJTaGtZWFJoTENCa1lYUmhYM1I1Y0dVcE8xeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUgwc0lHUmhkR0ZmZEhsd1pTa3VabUZwYkNobWRXNWpkR2x2YmlocWNWaElVaXdnZEdWNGRGTjBZWFIxY3l3Z1pYSnliM0pVYUhKdmQyNHBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1lYUmhJRDBnZTMwN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG5ObWFXUWdQU0J6Wld4bUxuTm1hV1E3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCa1lYUmhMblJoY21kbGRGTmxiR1ZqZEc5eUlEMGdjMlZzWmk1aGFtRjRYM1JoY21kbGRGOWhkSFJ5TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzV2WW1wbFkzUWdQU0J6Wld4bU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1aGFtRjRWVkpNSUQwZ1lXcGhlRjl3Y205alpYTnphVzVuWDNWeWJEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1JoZEdFdWFuRllTRklnUFNCcWNWaElVanRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRXVkR1Y0ZEZOMFlYUjFjeUE5SUhSbGVIUlRkR0YwZFhNN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoTG1WeWNtOXlWR2h5YjNkdUlEMGdaWEp5YjNKVWFISnZkMjQ3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MblJ5YVdkblpYSkZkbVZ1ZENoY0luTm1PbUZxWVhobGNuSnZjbHdpTENCYklHUmhkR0VnWFNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlLUzVoYkhkaGVYTW9ablZ1WTNScGIyNG9LVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ1pHRjBZU0E5SUh0OU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaR0YwWVM1elptbGtJRDBnYzJWc1ppNXpabWxrTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pHRjBZUzUwWVhKblpYUlRaV3hsWTNSdmNpQTlJSE5sYkdZdVlXcGhlRjkwWVhKblpYUmZZWFIwY2p0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0V1YjJKcVpXTjBJRDBnYzJWc1pqdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2RHaHBjeTV5WlcxdmRtVkRiR0Z6Y3loY0luTmxZWEpqYUMxbWFXeDBaWEl0WkdsellXSnNaV1JjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQndjbTlqWlhOelgyWnZjbTB1Wlc1aFlteGxTVzV3ZFhSektITmxiR1lwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWRISnBaMmRsY2tWMlpXNTBLRndpYzJZNllXcGhlR1p2Y20xbWFXNXBjMmhjSWl3Z1d5QmtZWFJoSUYwcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1SUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtTnZjSGxNYVhOMFNYUmxiWE5EYjI1MFpXNTBjeUE5SUdaMWJtTjBhVzl1S0NSc2FYTjBYMlp5YjIwc0lDUnNhWE4wWDNSdktWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhObGJHWWdQU0IwYUdsek8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTlqYjNCNUlHOTJaWElnWTJocGJHUWdiR2x6ZENCcGRHVnRjMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYkdsZlkyOXVkR1Z1ZEhOZllYSnlZWGtnUFNCdVpYY2dRWEp5WVhrb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1p5YjIxZllYUjBjbWxpZFhSbGN5QTlJRzVsZHlCQmNuSmhlU2dwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JtY205dFgyWnBaV3hrY3lBOUlDUnNhWE4wWDJaeWIyMHVabWx1WkNoY0lqNGdkV3dnUGlCc2FWd2lLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNSbWNtOXRYMlpwWld4a2N5NWxZV05vS0daMWJtTjBhVzl1S0drcGUxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUd4cFgyTnZiblJsYm5SelgyRnljbUY1TG5CMWMyZ29KQ2gwYUdsektTNW9kRzFzS0NrcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmhkSFJ5YVdKMWRHVnpJRDBnSkNoMGFHbHpLUzV3Y205d0tGd2lZWFIwY21saWRYUmxjMXdpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnliMjFmWVhSMGNtbGlkWFJsY3k1d2RYTm9LR0YwZEhKcFluVjBaWE1wTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2ZG1GeUlHWnBaV3hrWDI1aGJXVWdQU0FrS0hSb2FYTXBMbUYwZEhJb1hDSmtZWFJoTFhObUxXWnBaV3hrTFc1aGJXVmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzWmhjaUIwYjE5bWFXVnNaQ0E5SUNSc2FYTjBYM1J2TG1acGJtUW9YQ0krSUhWc0lENGdiR2xiWkdGMFlTMXpaaTFtYVdWc1pDMXVZVzFsUFNkY0lpdG1hV1ZzWkY5dVlXMWxLMXdpSjExY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXpaV3htTG1OdmNIbEJkSFJ5YVdKMWRHVnpLQ1FvZEdocGN5a3NJQ1JzYVhOMFgzUnZMQ0JjSW1SaGRHRXRjMll0WENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdiR2xmYVhRZ1BTQXdPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhSdlgyWnBaV3hrY3lBOUlDUnNhWE4wWDNSdkxtWnBibVFvWENJK0lIVnNJRDRnYkdsY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjBiMTltYVdWc1pITXVaV0ZqYUNobWRXNWpkR2x2YmlocEtYdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1FvZEdocGN5a3VhSFJ0YkNoc2FWOWpiMjUwWlc1MGMxOWhjbkpoZVZ0c2FWOXBkRjBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1puSnZiVjltYVdWc1pDQTlJQ1FvSkdaeWIyMWZabWxsYkdSekxtZGxkQ2hzYVY5cGRDa3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrZEc5ZlptbGxiR1FnUFNBa0tIUm9hWE1wTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUnZYMlpwWld4a0xuSmxiVzkyWlVGMGRISW9YQ0prWVhSaExYTm1MWFJoZUc5dWIyMTVMV0Z5WTJocGRtVmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbU52Y0hsQmRIUnlhV0oxZEdWektDUm1jbTl0WDJacFpXeGtMQ0FrZEc5ZlptbGxiR1FwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR3hwWDJsMEt5czdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHlwMllYSWdKR1p5YjIxZlptbGxiR1J6SUQwZ0pHeHBjM1JmWm5KdmJTNW1hVzVrS0Z3aUlIVnNJRDRnYkdsY0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhSdlgyWnBaV3hrY3lBOUlDUnNhWE4wWDNSdkxtWnBibVFvWENJZ1BpQnNhVndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNSbWNtOXRYMlpwWld4a2N5NWxZV05vS0daMWJtTjBhVzl1S0dsdVpHVjRMQ0IyWVd3cGUxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9KQ2gwYUdsektTNW9ZWE5CZEhSeWFXSjFkR1VvWENKa1lYUmhMWE5tTFhSaGVHOXViMjE1TFdGeVkyaHBkbVZjSWlrcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ2RHaHBjeTVqYjNCNVFYUjBjbWxpZFhSbGN5Z2tiR2x6ZEY5bWNtOXRMQ0FrYkdsemRGOTBieWs3S2k5Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11ZFhCa1lYUmxSbTl5YlVGMGRISnBZblYwWlhNZ1BTQm1kVzVqZEdsdmJpZ2tiR2x6ZEY5bWNtOXRMQ0FrYkdsemRGOTBieWxjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1jbTl0WDJGMGRISnBZblYwWlhNZ1BTQWtiR2x6ZEY5bWNtOXRMbkJ5YjNBb1hDSmhkSFJ5YVdKMWRHVnpYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2THlCc2IyOXdJSFJvY205MVoyZ2dQSE5sYkdWamRENGdZWFIwY21saWRYUmxjeUJoYm1RZ1lYQndiSGtnZEdobGJTQnZiaUE4WkdsMlBseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhSdlgyRjBkSEpwWW5WMFpYTWdQU0FrYkdsemRGOTBieTV3Y205d0tGd2lZWFIwY21saWRYUmxjMXdpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkM1bFlXTm9LSFJ2WDJGMGRISnBZblYwWlhNc0lHWjFibU4wYVc5dUtDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkd4cGMzUmZkRzh1Y21WdGIzWmxRWFIwY2loMGFHbHpMbTVoYldVcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ1F1WldGamFDaG1jbTl0WDJGMGRISnBZblYwWlhNc0lHWjFibU4wYVc5dUtDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkd4cGMzUmZkRzh1WVhSMGNpaDBhR2x6TG01aGJXVXNJSFJvYVhNdWRtRnNkV1VwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtTnZjSGxCZEhSeWFXSjFkR1Z6SUQwZ1puVnVZM1JwYjI0b0pHWnliMjBzSUNSMGJ5d2djSEpsWm1sNEtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSEJ5WldacGVDazlQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ3Y21WbWFYZ2dQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnWm5KdmJWOWhkSFJ5YVdKMWRHVnpJRDBnSkdaeWIyMHVjSEp2Y0NoY0ltRjBkSEpwWW5WMFpYTmNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdkRzlmWVhSMGNtbGlkWFJsY3lBOUlDUjBieTV3Y205d0tGd2lZWFIwY21saWRYUmxjMXdpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkM1bFlXTm9LSFJ2WDJGMGRISnBZblYwWlhNc0lHWjFibU4wYVc5dUtDa2dlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSEJ5WldacGVDRTlYQ0pjSWlrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaDBhR2x6TG01aGJXVXVhVzVrWlhoUFppaHdjbVZtYVhncElEMDlJREFwSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pIUnZMbkpsYlc5MlpVRjBkSElvZEdocGN5NXVZVzFsS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk4a2RHOHVjbVZ0YjNabFFYUjBjaWgwYUdsekxtNWhiV1VwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ1F1WldGamFDaG1jbTl0WDJGMGRISnBZblYwWlhNc0lHWjFibU4wYVc5dUtDa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSdkxtRjBkSElvZEdocGN5NXVZVzFsTENCMGFHbHpMblpoYkhWbEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtTnZjSGxHYjNKdFFYUjBjbWxpZFhSbGN5QTlJR1oxYm1OMGFXOXVLQ1JtY205dExDQWtkRzhwWEhKY2JpQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBa2RHOHVjbVZ0YjNabFFYUjBjaWhjSW1SaGRHRXRZM1Z5Y21WdWRDMTBZWGh2Ym05dGVTMWhjbU5vYVhabFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG1OdmNIbEJkSFJ5YVdKMWRHVnpLQ1JtY205dExDQWtkRzhwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdWRYQmtZWFJsUm05eWJTQTlJR1oxYm1OMGFXOXVLR1JoZEdFc0lHUmhkR0ZmZEhsd1pTbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0dSaGRHRmZkSGx3WlQwOVhDSnFjMjl1WENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhzdkwzUm9aVzRnZDJVZ1pHbGtJR0VnY21WeGRXVnpkQ0IwYnlCMGFHVWdZV3BoZUNCbGJtUndiMmx1ZEN3Z2MyOGdaWGh3WldOMElHRnVJRzlpYW1WamRDQmlZV05yWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LR1JoZEdGYkoyWnZjbTBuWFNraFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmNtVnRiM1psSUdGc2JDQmxkbVZ1ZEhNZ1puSnZiU0JUSmtZZ1ptOXliVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG05bVppZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNKbFpuSmxjMmdnZEdobElHWnZjbTBnS0dGMWRHOGdZMjkxYm5RcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWpiM0I1VEdsemRFbDBaVzF6UTI5dWRHVnVkSE1vSkNoa1lYUmhXeWRtYjNKdEoxMHBMQ0FrZEdocGN5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Y21VZ2FXNXBkQ0JUSmtZZ1kyeGhjM01nYjI0Z2RHaGxJR1p2Y20xY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2THlSMGFHbHpMbk5sWVhKamFFRnVaRVpwYkhSbGNpZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUlHRnFZWGdnYVhNZ1pXNWhZbXhsWkNCcGJtbDBJSFJvWlNCd1lXZHBibUYwYVc5dVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIUm9hWE11YVc1cGRDaDBjblZsS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk1cGMxOWhhbUY0UFQweEtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTV6WlhSMWNFRnFZWGhRWVdkcGJtRjBhVzl1S0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVoWkdSU1pYTjFiSFJ6SUQwZ1puVnVZM1JwYjI0b1pHRjBZU3dnWkdGMFlWOTBlWEJsS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE5sYkdZZ1BTQjBhR2x6TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9aR0YwWVY5MGVYQmxQVDFjSW1wemIyNWNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdleTh2ZEdobGJpQjNaU0JrYVdRZ1lTQnlaWEYxWlhOMElIUnZJSFJvWlNCaGFtRjRJR1Z1WkhCdmFXNTBMQ0J6YnlCbGVIQmxZM1FnWVc0Z2IySnFaV04wSUdKaFkydGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2WjNKaFlpQjBhR1VnY21WemRXeDBjeUJoYm1RZ2JHOWhaQ0JwYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbUZ3Y0dWdVpDaGtZWFJoV3lkeVpYTjFiSFJ6SjEwcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c2IyRmtYMjF2Y21WZmFIUnRiQ0E5SUdSaGRHRmJKM0psYzNWc2RITW5YVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQmxiSE5sSUdsbUtHUmhkR0ZmZEhsd1pUMDlYQ0pvZEcxc1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIc3ZMM2RsSUdGeVpTQmxlSEJsWTNScGJtY2dkR2hsSUdoMGJXd2diMllnZEdobElISmxjM1ZzZEhNZ2NHRm5aU0JpWVdOckxDQnpieUJsZUhSeVlXTjBJSFJvWlNCb2RHMXNJSGRsSUc1bFpXUmNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKR1JoZEdGZmIySnFJRDBnSkNoa1lYUmhLVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM05sYkdZdUpHbHVabWx1YVhSbFgzTmpjbTlzYkY5amIyNTBZV2x1WlhJdVlYQndaVzVrS0NSa1lYUmhYMjlpYWk1bWFXNWtLSE5sYkdZdVlXcGhlRjkwWVhKblpYUmZZWFIwY2lrdWFIUnRiQ2dwS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1Ykc5aFpGOXRiM0psWDJoMGJXd2dQU0FrWkdGMFlWOXZZbW91Wm1sdVpDaHpaV3htTG1GcVlYaGZkR0Z5WjJWMFgyRjBkSElwTG1oMGJXd29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHbHVabWx1YVhSbFgzTmpjbTlzYkY5bGJtUWdQU0JtWVd4elpUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0NRb1hDSThaR2wyUGx3aUszTmxiR1l1Ykc5aFpGOXRiM0psWDJoMGJXd3JYQ0k4TDJScGRqNWNJaWt1Wm1sdVpDaGNJbHRrWVhSaExYTmxZWEpqYUMxbWFXeDBaWEl0WVdOMGFXOXVQU2RwYm1acGJtbDBaUzF6WTNKdmJHd3RaVzVrSjExY0lpa3ViR1Z1WjNSb1BqQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2x1Wm1sdWFYUmxYM05qY205c2JGOWxibVFnUFNCMGNuVmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJsbUlIUm9aWEpsSUdseklHRnViM1JvWlhJZ2MyVnNaV04wYjNJZ1ptOXlJR2x1Wm1sdWFYUmxJSE5qY205c2JDd2dabWx1WkNCMGFHVWdZMjl1ZEdWdWRITWdiMllnZEdoaGRDQnBibk4wWldGa1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YVc1bWFXNXBkR1ZmYzJOeWIyeHNYMk52Ym5SaGFXNWxjaUU5WENKY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1c2IyRmtYMjF2Y21WZmFIUnRiQ0E5SUNRb1hDSThaR2wyUGx3aUszTmxiR1l1Ykc5aFpGOXRiM0psWDJoMGJXd3JYQ0k4TDJScGRqNWNJaWt1Wm1sdVpDaHpaV3htTG1sdVptbHVhWFJsWDNOamNtOXNiRjlqYjI1MFlXbHVaWElwTG1oMGJXd29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxtbHVabWx1YVhSbFgzTmpjbTlzYkY5eVpYTjFiSFJmWTJ4aGMzTWhQVndpWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrY21WemRXeDBYMmwwWlcxeklEMGdKQ2hjSWp4a2FYWStYQ0lyYzJWc1ppNXNiMkZrWDIxdmNtVmZhSFJ0YkN0Y0lqd3ZaR2wyUGx3aUtTNW1hVzVrS0hObGJHWXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzSmxjM1ZzZEY5amJHRnpjeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSEpsYzNWc2RGOXBkR1Z0YzE5amIyNTBZV2x1WlhJZ1BTQWtLQ2M4WkdsMkx6NG5MQ0I3ZlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtjbVZ6ZFd4MFgybDBaVzF6WDJOdmJuUmhhVzVsY2k1aGNIQmxibVFvSkhKbGMzVnNkRjlwZEdWdGN5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVzYjJGa1gyMXZjbVZmYUhSdGJDQTlJQ1J5WlhOMWJIUmZhWFJsYlhOZlkyOXVkR0ZwYm1WeUxtaDBiV3dvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9hVzVtYVc1cGRHVmZjMk55YjJ4c1gyVnVaQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdleTh2ZDJVZ1ptOTFibVFnWVNCa1lYUmhJR0YwZEhKcFluVjBaU0J6YVdkdVlXeHNhVzVuSUhSb1pTQnNZWE4wSUhCaFoyVWdjMjhnWm1sdWFYTm9JR2hsY21WY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtbHpYMjFoZUY5d1lXZGxaQ0E5SUhSeWRXVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxteGhjM1JmYkc5aFpGOXRiM0psWDJoMGJXd2dQU0J6Wld4bUxteHZZV1JmYlc5eVpWOW9kRzFzTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWFXNW1hVzVwZEdWVFkzSnZiR3hCY0hCbGJtUW9jMlZzWmk1c2IyRmtYMjF2Y21WZmFIUnRiQ2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYzJWc1ppNXNZWE4wWDJ4dllXUmZiVzl5WlY5b2RHMXNJVDA5YzJWc1ppNXNiMkZrWDIxdmNtVmZhSFJ0YkNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OWphR1ZqYXlCMGJ5QnRZV3RsSUhOMWNtVWdkR2hsSUc1bGR5Qm9kRzFzSUdabGRHTm9aV1FnYVhNZ1pHbG1abVZ5Wlc1MFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG14aGMzUmZiRzloWkY5dGIzSmxYMmgwYld3Z1BTQnpaV3htTG14dllXUmZiVzl5WlY5b2RHMXNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBibVpwYm1sMFpWTmpjbTlzYkVGd2NHVnVaQ2h6Wld4bUxteHZZV1JmYlc5eVpWOW9kRzFzS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdMeTkzWlNCeVpXTmxhWFpsWkNCMGFHVWdjMkZ0WlNCdFpYTnpZV2RsSUdGbllXbHVJSE52SUdSdmJpZDBJR0ZrWkN3Z1lXNWtJSFJsYkd3Z1V5WkdJSFJvWVhRZ2QyVW5jbVVnWVhRZ2RHaGxJR1Z1WkM0dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1selgyMWhlRjl3WVdkbFpDQTlJSFJ5ZFdVN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtbHVabWx1YVhSbFUyTnliMnhzUVhCd1pXNWtJRDBnWm5WdVkzUnBiMjRvSkc5aWFtVmpkQ2xjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITmxiR1l1YVc1bWFXNXBkR1ZmYzJOeWIyeHNYM0psYzNWc2RGOWpiR0Z6Y3lFOVhDSmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGthVzVtYVc1cGRHVmZjMk55YjJ4c1gyTnZiblJoYVc1bGNpNW1hVzVrS0hObGJHWXVhVzVtYVc1cGRHVmZjMk55YjJ4c1gzSmxjM1ZzZEY5amJHRnpjeWt1YkdGemRDZ3BMbUZtZEdWeUtDUnZZbXBsWTNRcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlScGJtWnBibWwwWlY5elkzSnZiR3hmWTI5dWRHRnBibVZ5TG1Gd2NHVnVaQ2drYjJKcVpXTjBLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11ZFhCa1lYUmxVbVZ6ZFd4MGN5QTlJR1oxYm1OMGFXOXVLR1JoZEdFc0lHUmhkR0ZmZEhsd1pTbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0dSaGRHRmZkSGx3WlQwOVhDSnFjMjl1WENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhzdkwzUm9aVzRnZDJVZ1pHbGtJR0VnY21WeGRXVnpkQ0IwYnlCMGFHVWdZV3BoZUNCbGJtUndiMmx1ZEN3Z2MyOGdaWGh3WldOMElHRnVJRzlpYW1WamRDQmlZV05yWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyZHlZV0lnZEdobElISmxjM1ZzZEhNZ1lXNWtJR3h2WVdRZ2FXNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1YUhSdGJDaGtZWFJoV3lkeVpYTjFiSFJ6SjEwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIUjVjR1Z2Wmloa1lYUmhXeWRtYjNKdEoxMHBJVDA5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMM0psYlc5MlpTQmhiR3dnWlhabGJuUnpJR1p5YjIwZ1V5WkdJR1p2Y20xY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGN5NXZabVlvS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaVzF2ZG1VZ2NHRm5hVzVoZEdsdmJseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjbVZ0YjNabFFXcGhlRkJoWjJsdVlYUnBiMjRvS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaV1p5WlhOb0lIUm9aU0JtYjNKdElDaGhkWFJ2SUdOdmRXNTBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1WTI5d2VVeHBjM1JKZEdWdGMwTnZiblJsYm5SektDUW9aR0YwWVZzblptOXliU2RkS1N3Z0pIUm9hWE1wTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzVndaR0YwWlNCaGRIUnlhV0oxZEdWeklHOXVJR1p2Y20xY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtTnZjSGxHYjNKdFFYUjBjbWxpZFhSbGN5Z2tLR1JoZEdGYkoyWnZjbTBuWFNrc0lDUjBhR2x6S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaU0JwYm1sMElGTW1SaUJqYkdGemN5QnZiaUIwYUdVZ1ptOXliVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUjBhR2x6TG5ObFlYSmphRUZ1WkVacGJIUmxjaWg3SjJselNXNXBkQ2M2SUdaaGJITmxmU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk4a2RHaHBjeTVtYVc1a0tGd2lhVzV3ZFhSY0lpa3VjbVZ0YjNabFFYUjBjaWhjSW1ScGMyRmliR1ZrWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb1pHRjBZVjkwZVhCbFBUMWNJbWgwYld4Y0lpa2dleTh2ZDJVZ1lYSmxJR1Y0Y0dWamRHbHVaeUIwYUdVZ2FIUnRiQ0J2WmlCMGFHVWdjbVZ6ZFd4MGN5QndZV2RsSUdKaFkyc3NJSE52SUdWNGRISmhZM1FnZEdobElHaDBiV3dnZDJVZ2JtVmxaRnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrWkdGMFlWOXZZbW9nUFNBa0tHUmhkR0VwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1YUhSdGJDZ2taR0YwWVY5dlltb3VabWx1WkNoelpXeG1MbUZxWVhoZmRHRnlaMlYwWDJGMGRISXBMbWgwYld3b0tTazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWWdLSE5sYkdZdUpHRnFZWGhmY21WemRXeDBjMTlqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJaTV6WldGeVkyaGhibVJtYVd4MFpYSmNJaWt1YkdWdVozUm9JRDRnTUNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIc3ZMM1JvWlc0Z2RHaGxjbVVnWVhKbElITmxZWEpqYUNCbWIzSnRLSE1wSUdsdWMybGtaU0IwYUdVZ2NtVnpkV3gwY3lCamIyNTBZV2x1WlhJc0lITnZJSEpsTFdsdWFYUWdkR2hsYlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MaVJoYW1GNFgzSmxjM1ZzZEhOZlkyOXVkR0ZwYm1WeUxtWnBibVFvWENJdWMyVmhjbU5vWVc1a1ptbHNkR1Z5WENJcExuTmxZWEpqYUVGdVpFWnBiSFJsY2lncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZhV1lnZEdobElHTjFjbkpsYm5RZ2MyVmhjbU5vSUdadmNtMGdhWE1nYm05MElHbHVjMmxrWlNCMGFHVWdjbVZ6ZFd4MGN5QmpiMjUwWVdsdVpYSXNJSFJvWlc0Z2NISnZZMlZsWkNCaGN5QnViM0p0WVd3Z1lXNWtJSFZ3WkdGMFpTQjBhR1VnWm05eWJWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1bWFXNWtLRndpTG5ObFlYSmphR0Z1WkdacGJIUmxjbHRrWVhSaExYTm1MV1p2Y20wdGFXUTlKMXdpSUNzZ2MyVnNaaTV6Wm1sa0lDc2dYQ0luWFZ3aUtTNXNaVzVuZEdnOVBUQXBJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUnVaWGRmYzJWaGNtTm9YMlp2Y20wZ1BTQWtaR0YwWVY5dlltb3VabWx1WkNoY0lpNXpaV0Z5WTJoaGJtUm1hV3gwWlhKYlpHRjBZUzF6WmkxbWIzSnRMV2xrUFNkY0lpQXJJSE5sYkdZdWMyWnBaQ0FySUZ3aUoxMWNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDZ2tibVYzWDNObFlYSmphRjltYjNKdExteGxibWQwYUNBOVBTQXhLU0I3THk5MGFHVnVJSEpsY0d4aFkyVWdkR2hsSUhObFlYSmphQ0JtYjNKdElIZHBkR2dnZEdobElHNWxkeUJ2Ym1WY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Y21WdGIzWmxJR0ZzYkNCbGRtVnVkSE1nWm5KdmJTQlRKa1lnWm05eWJWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkR2hwY3k1dlptWW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZjbVZ0YjNabElIQmhaMmx1WVhScGIyNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1eVpXMXZkbVZCYW1GNFVHRm5hVzVoZEdsdmJpZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaV1p5WlhOb0lIUm9aU0JtYjNKdElDaGhkWFJ2SUdOdmRXNTBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxtTnZjSGxNYVhOMFNYUmxiWE5EYjI1MFpXNTBjeWdrYm1WM1gzTmxZWEpqYUY5bWIzSnRMQ0FrZEdocGN5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzVndaR0YwWlNCaGRIUnlhV0oxZEdWeklHOXVJR1p2Y20xY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVqYjNCNVJtOXliVUYwZEhKcFluVjBaWE1vSkc1bGQxOXpaV0Z5WTJoZlptOXliU3dnSkhSb2FYTXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXlaU0JwYm1sMElGTW1SaUJqYkdGemN5QnZiaUIwYUdVZ1ptOXliVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGN5NXpaV0Z5WTJoQmJtUkdhV3gwWlhJb2V5ZHBjMGx1YVhRbk9pQm1ZV3h6WlgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMeVIwYUdsekxtWnBibVFvWENKcGJuQjFkRndpS1M1eVpXMXZkbVZCZEhSeUtGd2laR2x6WVdKc1pXUmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx6WDIxaGVGOXdZV2RsWkNBOUlHWmhiSE5sT3lBdkwyWnZjaUJwYm1acGJtbDBaU0J6WTNKdmJHeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVqZFhKeVpXNTBYM0JoWjJWa0lEMGdNVHNnTHk5bWIzSWdhVzVtYVc1cGRHVWdjMk55YjJ4c1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjMlYwU1c1bWFXNXBkR1ZUWTNKdmJHeERiMjUwWVdsdVpYSW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5KbGJXOTJaVmR2YjBOdmJXMWxjbU5sUTI5dWRISnZiSE1nUFNCbWRXNWpkR2x2YmlncGUxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSGR2YjE5dmNtUmxjbUo1SUQwZ0pDZ25MbmR2YjJOdmJXMWxjbU5sTFc5eVpHVnlhVzVuSUM1dmNtUmxjbUo1SnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtkMjl2WDI5eVpHVnlZbmxmWm05eWJTQTlJQ1FvSnk1M2IyOWpiMjF0WlhKalpTMXZjbVJsY21sdVp5Y3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSkhkdmIxOXZjbVJsY21KNVgyWnZjbTB1YjJabUtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDUjNiMjlmYjNKa1pYSmllUzV2Wm1Zb0tUdGNjbHh1SUNBZ0lDQWdJQ0I5TzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtRmtaRkYxWlhKNVVHRnlZVzBnUFNCbWRXNWpkR2x2YmlodVlXMWxMQ0IyWVd4MVpTd2dkWEpzWDNSNWNHVXBlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hWeWJGOTBlWEJsS1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIVnliRjkwZVhCbElEMGdYQ0poYkd4Y0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbVY0ZEhKaFgzRjFaWEo1WDNCaGNtRnRjMXQxY214ZmRIbHdaVjFiYm1GdFpWMGdQU0IyWVd4MVpUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2ZUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVwYm1sMFYyOXZRMjl0YldWeVkyVkRiMjUwY205c2N5QTlJR1oxYm1OMGFXOXVLQ2w3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbkpsYlc5MlpWZHZiME52YlcxbGNtTmxRMjl1ZEhKdmJITW9LVHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtkMjl2WDI5eVpHVnlZbmtnUFNBa0tDY3VkMjl2WTI5dGJXVnlZMlV0YjNKa1pYSnBibWNnTG05eVpHVnlZbmtuS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUjNiMjlmYjNKa1pYSmllVjltYjNKdElEMGdKQ2duTG5kdmIyTnZiVzFsY21ObExXOXlaR1Z5YVc1bkp5azdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2IzSmtaWEpmZG1Gc0lEMGdYQ0pjSWp0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0pIZHZiMTl2Y21SbGNtSjVMbXhsYm1kMGFENHdLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J2Y21SbGNsOTJZV3dnUFNBa2QyOXZYMjl5WkdWeVlua3VkbUZzS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnZjbVJsY2w5MllXd2dQU0J6Wld4bUxtZGxkRkYxWlhKNVVHRnlZVzFHY205dFZWSk1LRndpYjNKa1pYSmllVndpTENCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFppazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0c5eVpHVnlYM1poYkQwOVhDSnRaVzUxWDI5eVpHVnlYQ0lwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUc5eVpHVnlYM1poYkNBOUlGd2lYQ0k3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtDaHZjbVJsY2w5MllXd2hQVndpWENJcEppWW9JU0Z2Y21SbGNsOTJZV3dwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbVY0ZEhKaFgzRjFaWEo1WDNCaGNtRnRjeTVoYkd3dWIzSmtaWEppZVNBOUlHOXlaR1Z5WDNaaGJEdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNSM2IyOWZiM0prWlhKaWVWOW1iM0p0TG05dUtDZHpkV0p0YVhRbkxDQm1kVzVqZEdsdmJpaGxLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsTG5CeVpYWmxiblJFWldaaGRXeDBLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzWmhjaUJtYjNKdElEMGdaUzUwWVhKblpYUTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdabUZzYzJVN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdKSGR2YjE5dmNtUmxjbUo1TG05dUtGd2lZMmhoYm1kbFhDSXNJR1oxYm1OMGFXOXVLR1VwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdVdWNISmxkbVZ1ZEVSbFptRjFiSFFvS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RtRnNJRDBnSkNoMGFHbHpLUzUyWVd3b0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0haaGJEMDlYQ0p0Wlc1MVgyOXlaR1Z5WENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnNJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1WNGRISmhYM0YxWlhKNVgzQmhjbUZ0Y3k1aGJHd3ViM0prWlhKaWVTQTlJSFpoYkR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrZEdocGN5NXpkV0p0YVhRb0tUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYUjFjbTRnWm1Gc2MyVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YzJOeWIyeHNVbVZ6ZFd4MGN5QTlJR1oxYm1OMGFXOXVLQ2xjY2x4dUlDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQnpaV3htSUQwZ2RHaHBjenRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtDaHpaV3htTG5OamNtOXNiRjl2Ymw5aFkzUnBiMjQ5UFhObGJHWXVZV3BoZUY5aFkzUnBiMjRwZkh3b2MyVnNaaTV6WTNKdmJHeGZiMjVmWVdOMGFXOXVQVDFjSW1Gc2JGd2lLU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXpZM0p2Ykd4VWIxQnZjeWdwT3lBdkwzTmpjbTlzYkNCMGFHVWdkMmx1Wkc5M0lHbG1JR2wwSUdoaGN5QmlaV1Z1SUhObGRGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl6Wld4bUxtRnFZWGhmWVdOMGFXOXVJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1MWNHUmhkR1ZWY214SWFYTjBiM0o1SUQwZ1puVnVZM1JwYjI0b1lXcGhlRjl5WlhOMWJIUnpYM1Z5YkNsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6Wld4bUlEMGdkR2hwY3p0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIxYzJWZmFHbHpkRzl5ZVY5aGNHa2dQU0F3TzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb2QybHVaRzkzTG1ocGMzUnZjbmtnSmlZZ2QybHVaRzkzTG1ocGMzUnZjbmt1Y0hWemFGTjBZWFJsS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMWMyVmZhR2x6ZEc5eWVWOWhjR2tnUFNBa2RHaHBjeTVoZEhSeUtGd2laR0YwWVMxMWMyVXRhR2x6ZEc5eWVTMWhjR2xjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ2h6Wld4bUxuVndaR0YwWlY5aGFtRjRYM1Z5YkQwOU1Ta21KaWgxYzJWZmFHbHpkRzl5ZVY5aGNHazlQVEVwS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwyNXZkeUJqYUdWamF5QnBaaUIwYUdVZ1luSnZkM05sY2lCemRYQndiM0owY3lCb2FYTjBiM0o1SUhOMFlYUmxJSEIxYzJnZ09pbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNoM2FXNWtiM2N1YUdsemRHOXllU0FtSmlCM2FXNWtiM2N1YUdsemRHOXllUzV3ZFhOb1UzUmhkR1VwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYUdsemRHOXllUzV3ZFhOb1UzUmhkR1VvYm5Wc2JDd2diblZzYkN3Z1lXcGhlRjl5WlhOMWJIUnpYM1Z5YkNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTV5WlcxdmRtVkJhbUY0VUdGbmFXNWhkR2x2YmlBOUlHWjFibU4wYVc5dUtDbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWh6Wld4bUxtRnFZWGhmYkdsdWEzTmZjMlZzWldOMGIzSXBJVDFjSW5WdVpHVm1hVzVsWkZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkdGcVlYaGZiR2x1YTNOZmIySnFaV04wSUQwZ2FsRjFaWEo1S0hObGJHWXVZV3BoZUY5c2FXNXJjMTl6Wld4bFkzUnZjaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvSkdGcVlYaGZiR2x1YTNOZmIySnFaV04wTG14bGJtZDBhRDR3S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSaGFtRjRYMnhwYm10elgyOWlhbVZqZEM1dlptWW9LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTVqWVc1R1pYUmphRUZxWVhoU1pYTjFiSFJ6SUQwZ1puVnVZM1JwYjI0b1ptVjBZMmhmZEhsd1pTbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSNWNHVnZaaWhtWlhSamFGOTBlWEJsS1QwOVhDSjFibVJsWm1sdVpXUmNJaWxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHWmxkR05vWDNSNWNHVWdQU0JjSWx3aU8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJWc1ppQTlJSFJvYVhNN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUhaaGNpQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITWdQU0JtWVd4elpUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVhWE5mWVdwaGVEMDlNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdleTh2ZEdobGJpQjNaU0IzYVd4c0lHRnFZWGdnYzNWaWJXbDBJSFJvWlNCbWIzSnRYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OWhibVFnYVdZZ2QyVWdZMkZ1SUdacGJtUWdkR2hsSUhKbGMzVnNkSE1nWTI5dWRHRnBibVZ5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaHpaV3htTGlSaGFtRjRYM0psYzNWc2RITmZZMjl1ZEdGcGJtVnlMbXhsYm1kMGFEMDlNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JtWlhSamFGOWhhbUY0WDNKbGMzVnNkSE1nUFNCMGNuVmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeVpYTjFiSFJ6WDNWeWJDQTlJSE5sYkdZdWNtVnpkV3gwYzE5MWNtdzdJQ0F2TDF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEpsYzNWc2RITmZkWEpzWDJWdVkyOWtaV1FnUFNBbkp6c2dJQzh2WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdZM1Z5Y21WdWRGOTFjbXdnUFNCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFpqdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwybG5ibTl5WlNBaklHRnVaQ0JsZG1WeWVYUm9hVzVuSUdGbWRHVnlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2FHRnphRjl3YjNNZ1BTQjNhVzVrYjNjdWJHOWpZWFJwYjI0dWFISmxaaTVwYm1SbGVFOW1LQ2NqSnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWhvWVhOb1gzQnZjeUU5UFMweEtYdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCamRYSnlaVzUwWDNWeWJDQTlJSGRwYm1SdmR5NXNiMk5oZEdsdmJpNW9jbVZtTG5OMVluTjBjaWd3TENCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFppNXBibVJsZUU5bUtDY2pKeWtwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDQW9JQ2dnYzJWc1ppNWthWE53YkdGNVgzSmxjM1ZzZEY5dFpYUm9iMlE5UFZ3aVkzVnpkRzl0WDNkdmIyTnZiVzFsY21ObFgzTjBiM0psWENJZ0tTQjhmQ0FvSUhObGJHWXVaR2x6Y0d4aGVWOXlaWE4xYkhSZmJXVjBhRzlrUFQxY0luQnZjM1JmZEhsd1pWOWhjbU5vYVhabFhDSWdLU0FwSUNZbUlDZ2djMlZzWmk1bGJtRmliR1ZmZEdGNGIyNXZiWGxmWVhKamFHbDJaWE1nUFQwZ01TQXBJQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlnZ2MyVnNaaTVqZFhKeVpXNTBYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVWdJVDA5WENKY0lpQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITWdQU0IwY25WbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z1ptVjBZMmhmWVdwaGVGOXlaWE4xYkhSek8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5cDJZWElnY21WemRXeDBjMTkxY213Z1BTQndjbTlqWlhOelgyWnZjbTB1WjJWMFVtVnpkV3gwYzFWeWJDaHpaV3htTENCelpXeG1MbkpsYzNWc2RITmZkWEpzS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHRmpkR2wyWlY5MFlYZ2dQU0J3Y205alpYTnpYMlp2Y20wdVoyVjBRV04wYVhabFZHRjRLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCeGRXVnllVjl3WVhKaGJYTWdQU0J6Wld4bUxtZGxkRlZ5YkZCaGNtRnRjeWgwY25WbExDQW5KeXdnWVdOMGFYWmxYM1JoZUNrN0tpOWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNibHh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDI1dmR5QnpaV1VnYVdZZ2QyVWdZWEpsSUc5dUlIUm9aU0JWVWt3Z2QyVWdkR2hwYm1zdUxpNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMWNteGZjR0Z5ZEhNZ1BTQmpkWEp5Wlc1MFgzVnliQzV6Y0d4cGRDaGNJajljSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnZFhKc1gySmhjMlVnUFNCY0lsd2lPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFZ5YkY5d1lYSjBjeTVzWlc1bmRHZytNQ2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IxY214ZlltRnpaU0E5SUhWeWJGOXdZWEowYzFzd1hUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIVnliRjlpWVhObElEMGdZM1Z5Y21WdWRGOTFjbXc3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHeGhibWNnUFNCelpXeG1MbWRsZEZGMVpYSjVVR0Z5WVcxR2NtOXRWVkpNS0Z3aWJHRnVaMXdpTENCM2FXNWtiM2N1Ykc5allYUnBiMjR1YUhKbFppazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlnb2RIbHdaVzltS0d4aGJtY3BJVDA5WENKMWJtUmxabWx1WldSY0lpa21KaWhzWVc1bklUMDliblZzYkNrcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RYSnNYMkpoYzJVZ1BTQnpaV3htTG1Ga1pGVnliRkJoY21GdEtIVnliRjlpWVhObExDQmNJbXhoYm1jOVhDSXJiR0Z1WnlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSE5tYVdRZ1BTQnpaV3htTG1kbGRGRjFaWEo1VUdGeVlXMUdjbTl0VlZKTUtGd2ljMlpwWkZ3aUxDQjNhVzVrYjNjdWJHOWpZWFJwYjI0dWFISmxaaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTlwWmlCelptbGtJR2x6SUdFZ2JuVnRZbVZ5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppaE9kVzFpWlhJb2NHRnljMlZHYkc5aGRDaHpabWxrS1NrZ1BUMGdjMlpwWkNsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMWNteGZZbUZ6WlNBOUlITmxiR1l1WVdSa1ZYSnNVR0Z5WVcwb2RYSnNYMkpoYzJVc0lGd2ljMlpwWkQxY0lpdHpabWxrS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwybG1JR0Z1ZVNCdlppQjBhR1VnTXlCamIyNWthWFJwYjI1eklHRnlaU0IwY25WbExDQjBhR1Z1SUdsMGN5Qm5iMjlrSUhSdklHZHZYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2THlBdElERWdmQ0JwWmlCMGFHVWdkWEpzSUdKaGMyVWdQVDBnY21WemRXeDBjMTkxY214Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZJQzBnTWlCOElHbG1JSFZ5YkNCaVlYTmxLeUJjSWk5Y0lpQWdQVDBnY21WemRXeDBjMTkxY213Z0xTQnBiaUJqWVhObElHOW1JSFZ6WlhJZ1pYSnliM0lnYVc0Z2RHaGxJSEpsYzNWc2RITWdWVkpNWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTkwY21sdElHRnVlU0IwY21GcGJHbHVaeUJ6YkdGemFDQm1iM0lnWldGemFXVnlJR052YlhCaGNtbHpiMjQ2WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMWNteGZZbUZ6WlNBOUlIVnliRjlpWVhObExuSmxjR3hoWTJVb0wxeGNMeVF2TENBbkp5azdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J5WlhOMWJIUnpYM1Z5YkNBOUlISmxjM1ZzZEhOZmRYSnNMbkpsY0d4aFkyVW9MMXhjTHlRdkxDQW5KeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCeVpYTjFiSFJ6WDNWeWJGOWxibU52WkdWa0lEMGdaVzVqYjJSbFZWSkpLSEpsYzNWc2RITmZkWEpzTG5KbGNHeGhZMlVvTDF4Y0x5UXZMQ0FuSnlrcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmpkWEp5Wlc1MFgzVnliRjlqYjI1MFlXbHVjMTl5WlhOMWJIUnpYM1Z5YkNBOUlDMHhPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0tIVnliRjlpWVhObFBUMXlaWE4xYkhSelgzVnliQ2w4ZkNoMWNteGZZbUZ6WlM1MGIweHZkMlZ5UTJGelpTZ3BQVDF5WlhOMWJIUnpYM1Z5YkY5bGJtTnZaR1ZrTG5SdlRHOTNaWEpEWVhObEtDa3BLWHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmpkWEp5Wlc1MFgzVnliRjlqYjI1MFlXbHVjMTl5WlhOMWJIUnpYM1Z5YkNBOUlERTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvYzJWc1ppNXZibXg1WDNKbGMzVnNkSE5mWVdwaGVEMDlNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhzdkwybG1JR0VnZFhObGNpQm9ZWE1nWTJodmMyVnVJSFJ2SUc5dWJIa2dZV3hzYjNjZ1lXcGhlQ0J2YmlCeVpYTjFiSFJ6SUhCaFoyVnpJQ2hrWldaaGRXeDBJR0psYUdGMmFXOTFjaWxjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0lHTjFjbkpsYm5SZmRYSnNYMk52Ym5SaGFXNXpYM0psYzNWc2RITmZkWEpzSUQ0Z0xURXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2V5OHZkR2hwY3lCdFpXRnVjeUIwYUdVZ1kzVnljbVZ1ZENCVlVrd2dZMjl1ZEdGcGJuTWdkR2hsSUhKbGMzVnNkSE1nZFhKc0xDQjNhR2xqYUNCdFpXRnVjeUIzWlNCallXNGdaRzhnWVdwaGVGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQm1aWFJqYUY5aGFtRjRYM0psYzNWc2RITWdQU0IwY25WbE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCbVpYUmphRjloYW1GNFgzSmxjM1ZzZEhNZ1BTQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb1ptVjBZMmhmZEhsd1pUMDlYQ0p3WVdkcGJtRjBhVzl1WENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCcFppZ2dZM1Z5Y21WdWRGOTFjbXhmWTI5dWRHRnBibk5mY21WemRXeDBjMTkxY213Z1BpQXRNU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZXk4dmRHaHBjeUJ0WldGdWN5QjBhR1VnWTNWeWNtVnVkQ0JWVWt3Z1kyOXVkR0ZwYm5NZ2RHaGxJSEpsYzNWc2RITWdkWEpzTENCM2FHbGphQ0J0WldGdWN5QjNaU0JqWVc0Z1pHOGdZV3BoZUZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dlpHOXVKM1FnWVdwaGVDQndZV2RwYm1GMGFXOXVJSGRvWlc0Z2JtOTBJRzl1SUdFZ1V5WkdJSEJoWjJWY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR1psZEdOb1gyRnFZWGhmY21WemRXeDBjeUE5SUdaaGJITmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z1ptVjBZMmhmWVdwaGVGOXlaWE4xYkhSek8xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdkR2hwY3k1elpYUjFjRUZxWVhoUVlXZHBibUYwYVc5dUlEMGdablZ1WTNScGIyNG9LVnh5WEc0Z0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2RIbHdaVzltS0hObGJHWXVZV3BoZUY5c2FXNXJjMTl6Wld4bFkzUnZjaWs5UFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEpsZEhWeWJqdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTlwYm1acGJtbDBaU0J6WTNKdmJHeGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9kR2hwY3k1d1lXZHBibUYwYVc5dVgzUjVjR1U5UFQxY0ltbHVabWx1YVhSbFgzTmpjbTlzYkZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYVc1bWFXNXBkR1ZmYzJOeWIyeHNYMlZ1WkNBOUlHWmhiSE5sTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jMlZzWmk0a1lXcGhlRjl5WlhOMWJIUnpYMk52Ym5SaGFXNWxjaTVtYVc1a0tGd2lXMlJoZEdFdGMyVmhjbU5vTFdacGJIUmxjaTFoWTNScGIyNDlKMmx1Wm1sdWFYUmxMWE5qY205c2JDMWxibVFuWFZ3aUtTNXNaVzVuZEdnK01DbGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBibVpwYm1sMFpWOXpZM0p2Ykd4ZlpXNWtJRDBnZEhKMVpUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1MbWx6WDIxaGVGOXdZV2RsWkNBOUlIUnlkV1U3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb2NHRnljMlZKYm5Rb2RHaHBjeTVwYm5OMFlXNWpaVjl1ZFcxaVpYSXBQVDA5TVNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNRb2QybHVaRzkzS1M1dlptWW9YQ0p6WTNKdmJHeGNJaXdnYzJWc1ppNXZibGRwYm1SdmQxTmpjbTlzYkNrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2h6Wld4bUxtTmhia1psZEdOb1FXcGhlRkpsYzNWc2RITW9YQ0p3WVdkcGJtRjBhVzl1WENJcEtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1FvZDJsdVpHOTNLUzV2YmloY0luTmpjbTlzYkZ3aUxDQnpaV3htTG05dVYybHVaRzkzVTJOeWIyeHNLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmRtRnlJQ1JoYW1GNFgyeHBibXR6WDI5aWFtVmpkQ0E5SUdwUmRXVnllU2h6Wld4bUxtRnFZWGhmYkdsdWEzTmZjMlZzWldOMGIzSXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnTHk5cFppZ2tZV3BoZUY5c2FXNXJjMTl2WW1wbFkzUXViR1Z1WjNSb1BqQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5amIyNXpiMnhsTG14dlp5aGNJbWx1YVhRZ2NHRm5hVzVoZEdsdmJpQnpkSFZtWmx3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2SkdGcVlYaGZiR2x1YTNOZmIySnFaV04wTG05bVppZ25ZMnhwWTJzbktUdGNjbHh1WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdKQ2hrYjJOMWJXVnVkQ2t1YjJabUtDZGpiR2xqYXljc0lITmxiR1l1WVdwaGVGOXNhVzVyYzE5elpXeGxZM1J2Y2lrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtLR1J2WTNWdFpXNTBLUzV2Wm1Zb2MyVnNaaTVoYW1GNFgyeHBibXR6WDNObGJHVmpkRzl5S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDUW9jMlZzWmk1aGFtRjRYMnhwYm10elgzTmxiR1ZqZEc5eUtTNXZabVlvS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrS0dSdlkzVnRaVzUwS1M1dmJpZ25ZMnhwWTJzbkxDQnpaV3htTG1GcVlYaGZiR2x1YTNOZmMyVnNaV04wYjNJc0lHWjFibU4wYVc5dUtHVXBlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbU5oYmtabGRHTm9RV3BoZUZKbGMzVnNkSE1vWENKd1lXZHBibUYwYVc5dVhDSXBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaUzV3Y21WMlpXNTBSR1ZtWVhWc2RDZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR3hwYm1zZ1BTQnFVWFZsY25rb2RHaHBjeWt1WVhSMGNpZ25hSEpsWmljcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1GcVlYaGZZV04wYVc5dUlEMGdYQ0p3WVdkcGJtRjBhVzl1WENJN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2NHRm5aVTUxYldKbGNpQTlJSE5sYkdZdVoyVjBVR0ZuWldSR2NtOXRWVkpNS0d4cGJtc3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrWVdwaGVGOXlaWE4xYkhSelgyTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF3WVdkbFpGd2lMQ0J3WVdkbFRuVnRZbVZ5S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVptVjBZMmhCYW1GNFVtVnpkV3gwY3lncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVJR1poYkhObE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDOHZJSDFjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNCMGFHbHpMbWRsZEZCaFoyVmtSbkp2YlZWU1RDQTlJR1oxYm1OMGFXOXVLRlZTVENsN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnY0dGblpXUldZV3dnUFNBeE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBdkwyWnBjbk4wSUhSbGMzUWdkRzhnYzJWbElHbG1JSGRsSUdoaGRtVWdYQ0l2Y0dGblpTODBMMXdpSUdsdUlIUm9aU0JWVWt4Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUndWbUZzSUQwZ2MyVnNaaTVuWlhSUmRXVnllVkJoY21GdFJuSnZiVlZTVENoY0luTm1YM0JoWjJWa1hDSXNJRlZTVENrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtDaDBlWEJsYjJZb2RIQldZV3dwUFQxY0luTjBjbWx1WjF3aUtYeDhLSFI1Y0dWdlppaDBjRlpoYkNrOVBWd2liblZ0WW1WeVhDSXBLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J3WVdkbFpGWmhiQ0E5SUhSd1ZtRnNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNGdjR0ZuWldSV1lXdzdYSEpjYmlBZ0lDQWdJQ0FnZlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NW5aWFJSZFdWeWVWQmhjbUZ0Um5KdmJWVlNUQ0E5SUdaMWJtTjBhVzl1S0c1aGJXVXNJRlZTVENsN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjJZWElnY1hOMGNtbHVaeUE5SUZ3aVAxd2lLMVZTVEM1emNHeHBkQ2duUHljcFd6RmRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWgwZVhCbGIyWW9jWE4wY21sdVp5a2hQVndpZFc1a1pXWnBibVZrWENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUIyWVd3Z1BTQmtaV052WkdWVlVrbERiMjF3YjI1bGJuUW9LRzVsZHlCU1pXZEZlSEFvSjFzL2ZDWmRKeUFySUc1aGJXVWdLeUFuUFNjZ0t5QW5LRnRlSmp0ZEt6OHBLQ1o4STN3N2ZDUXBKeWt1WlhobFl5aHhjM1J5YVc1bktYeDhXeXhjSWx3aVhTbGJNVjB1Y21Wd2JHRmpaU2d2WEZ3ckwyY3NJQ2NsTWpBbktTbDhmRzUxYkd3N1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z2RtRnNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCY0lsd2lPMXh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNibHh5WEc1Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NW1iM0p0VlhCa1lYUmxaQ0E5SUdaMWJtTjBhVzl1S0dVcGUxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdMeTlsTG5CeVpYWmxiblJFWldaaGRXeDBLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJR2xtS0hObGJHWXVZWFYwYjE5MWNHUmhkR1U5UFRFcElIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWMzVmliV2wwUm05eWJTZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb0tITmxiR1l1WVhWMGIxOTFjR1JoZEdVOVBUQXBKaVlvYzJWc1ppNWhkWFJ2WDJOdmRXNTBYM0psWm5KbGMyaGZiVzlrWlQwOU1Ta3BYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVptOXliVlZ3WkdGMFpXUkdaWFJqYUVGcVlYZ29LVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnY21WMGRYSnVJR1poYkhObE8xeHlYRzRnSUNBZ0lDQWdJSDA3WEhKY2JseHlYRzRnSUNBZ0lDQWdJSFJvYVhNdVptOXliVlZ3WkdGMFpXUkdaWFJqYUVGcVlYZ2dQU0JtZFc1amRHbHZiaWdwZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0x5OXNiMjl3SUhSb2NtOTFaMmdnWVd4c0lIUm9aU0JtYVdWc1pITWdZVzVrSUdKMWFXeGtJSFJvWlNCVlVreGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVtWlhSamFFRnFZWGhHYjNKdEtDazdYSEpjYmx4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUdaaGJITmxPMXh5WEc0Z0lDQWdJQ0FnSUgwN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUM4dmJXRnJaU0JoYm5rZ1kyOXljbVZqZEdsdmJuTXZkWEJrWVhSbGN5QjBieUJtYVdWc1pITWdZbVZtYjNKbElIUm9aU0J6ZFdKdGFYUWdZMjl0Y0d4bGRHVnpYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NXpaWFJHYVdWc1pITWdQU0JtZFc1amRHbHZiaWhsS1h0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDOHZhV1lvYzJWc1ppNXBjMTloYW1GNFBUMHdLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl6YjIxbGRHbHRaWE1nZEdobElHWnZjbTBnYVhNZ2MzVmliV2wwZEdWa0lIZHBkR2h2ZFhRZ2RHaGxJSE5zYVdSbGNpQjVaWFFnYUdGMmFXNW5JSFZ3WkdGMFpXUXNJR0Z1WkNCaGN5QjNaU0JuWlhRZ2IzVnlJSFpoYkhWbGN5Qm1jbTl0WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzUm9aU0J6Ykdsa1pYSWdZVzVrSUc1dmRDQnBibkIxZEhNc0lIZGxJRzVsWldRZ2RHOGdZMmhsWTJzZ2FYUWdhV1lnYm1WbFpITWdkRzhnWW1VZ2MyVjBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDI5dWJIa2diMk5qZFhKeklHbG1JR0ZxWVhnZ2FYTWdiMlptTENCaGJtUWdZWFYwYjNOMVltMXBkQ0J2Ymx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTRrWm1sbGJHUnpMbVZoWTJnb1puVnVZM1JwYjI0b0tTQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lBa1ptbGxiR1FnUFNBa0tIUm9hWE1wTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdjbUZ1WjJWZlpHbHpjR3hoZVY5MllXeDFaWE1nUFNBa1ptbGxiR1F1Wm1sdVpDZ25Mbk5tTFcxbGRHRXRjbUZ1WjJVdGMyeHBaR1Z5SnlrdVlYUjBjaWhjSW1SaGRHRXRaR2x6Y0d4aGVTMTJZV3gxWlhNdFlYTmNJaWs3THk5a1lYUmhMV1JwYzNCc1lYa3RkbUZzZFdWekxXRnpQVndpZEdWNGRGd2lYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hKaGJtZGxYMlJwYzNCc1lYbGZkbUZzZFdWelBUMDlYQ0owWlhoMGFXNXdkWFJjSWlrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZb0pHWnBaV3hrTG1acGJtUW9YQ0l1YldWMFlTMXpiR2xrWlhKY0lpa3ViR1Z1WjNSb1BqQXBlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRdVptbHVaQ2hjSWk1dFpYUmhMWE5zYVdSbGNsd2lLUzVsWVdOb0tHWjFibU4wYVc5dUlDaHBibVJsZUNrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6Ykdsa1pYSmZiMkpxWldOMElEMGdKQ2gwYUdsektWc3dYVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrYzJ4cFpHVnlYMlZzSUQwZ0pDaDBhR2x6S1M1amJHOXpaWE4wS0Z3aUxuTm1MVzFsZEdFdGNtRnVaMlV0YzJ4cFpHVnlYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTkyWVhJZ2JXbHVWbUZzSUQwZ0pITnNhV1JsY2w5bGJDNWhkSFJ5S0Z3aVpHRjBZUzF0YVc1Y0lpazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBdkwzWmhjaUJ0WVhoV1lXd2dQU0FrYzJ4cFpHVnlYMlZzTG1GMGRISW9YQ0prWVhSaExXMWhlRndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCdGFXNVdZV3dnUFNBa2MyeHBaR1Z5WDJWc0xtWnBibVFvWENJdWMyWXRjbUZ1WjJVdGJXbHVYQ0lwTG5aaGJDZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJRzFoZUZaaGJDQTlJQ1J6Ykdsa1pYSmZaV3d1Wm1sdVpDaGNJaTV6WmkxeVlXNW5aUzF0WVhoY0lpa3VkbUZzS0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSXVjMlYwS0Z0dGFXNVdZV3dzSUcxaGVGWmhiRjBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmZWeHlYRzVjY2x4dUlDQWdJQ0FnSUNCOVhISmNibHh5WEc0Z0lDQWdJQ0FnSUM4dmMzVmliV2wwWEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTV6ZFdKdGFYUkdiM0p0SUQwZ1puVnVZM1JwYjI0b1pTbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2TDJ4dmIzQWdkR2h5YjNWbmFDQmhiR3dnZEdobElHWnBaV3hrY3lCaGJtUWdZblZwYkdRZ2RHaGxJRlZTVEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloelpXeG1MbWx6VTNWaWJXbDBkR2x1WnlBOVBTQjBjblZsS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200Z1ptRnNjMlU3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhObGJHWXVjMlYwUm1sbGJHUnpLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdVkyeGxZWEpVYVcxbGNpZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNXBjMU4xWW0xcGRIUnBibWNnUFNCMGNuVmxPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnY0hKdlkyVnpjMTltYjNKdExuTmxkRlJoZUVGeVkyaHBkbVZTWlhOMWJIUnpWWEpzS0hObGJHWXNJSE5sYkdZdWNtVnpkV3gwYzE5MWNtd3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNGtZV3BoZUY5eVpYTjFiSFJ6WDJOdmJuUmhhVzVsY2k1aGRIUnlLRndpWkdGMFlTMXdZV2RsWkZ3aUxDQXhLVHNnTHk5cGJtbDBJSEJoWjJWa1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnBaaWh6Wld4bUxtTmhia1psZEdOb1FXcGhlRkpsYzNWc2RITW9LU2xjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdleTh2ZEdobGJpQjNaU0IzYVd4c0lHRnFZWGdnYzNWaWJXbDBJSFJvWlNCbWIzSnRYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVoYW1GNFgyRmpkR2x2YmlBOUlGd2ljM1ZpYldsMFhDSTdJQzh2YzI4Z2QyVWdhMjV2ZHlCcGRDQjNZWE51SjNRZ2NHRm5hVzVoZEdsdmJseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjMlZzWmk1bVpYUmphRUZxWVhoU1pYTjFiSFJ6S0NrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnWld4elpWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCN0x5OTBhR1Z1SUhkbElIZHBiR3dnYzJsdGNHeDVJSEpsWkdseVpXTjBJSFJ2SUhSb1pTQlNaWE4xYkhSeklGVlNURnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ5WlhOMWJIUnpYM1Z5YkNBOUlIQnliMk5sYzNOZlptOXliUzVuWlhSU1pYTjFiSFJ6VlhKc0tITmxiR1lzSUhObGJHWXVjbVZ6ZFd4MGMxOTFjbXdwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJSEYxWlhKNVgzQmhjbUZ0Y3lBOUlITmxiR1l1WjJWMFZYSnNVR0Z5WVcxektIUnlkV1VzSUNjbktUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSEpsYzNWc2RITmZkWEpzSUQwZ2MyVnNaaTVoWkdSVmNteFFZWEpoYlNoeVpYTjFiSFJ6WDNWeWJDd2djWFZsY25sZmNHRnlZVzF6S1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IzYVc1a2IzY3ViRzlqWVhScGIyNHVhSEpsWmlBOUlISmxjM1ZzZEhOZmRYSnNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0F2S21sbUtITmxiR1l1YldGcGJuUmhhVzVmYzNSaGRHVTlQVndpTVZ3aUtWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0x5OWhiR1Z5ZENoY0ltMWhhVzUwWVdsdUlITjBZWFJsWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR2x1Um1sbWRHVmxiazFwYm5WMFpYTWdQU0J1WlhjZ1JHRjBaU2h1WlhjZ1JHRjBaU2dwTG1kbGRGUnBiV1VvS1NBcklERTFJQ29nTmpBZ0tpQXhNREF3S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmFIUjBjSE02THk5bmFYUm9kV0l1WTI5dEwycHpMV052YjJ0cFpTOXFjeTFqYjI5cmFXVXZkMmxyYVM5R2NtVnhkV1Z1ZEd4NUxVRnphMlZrTFZGMVpYTjBhVzl1Y3lObGVIQnBjbVV0WTI5dmEybGxjeTFwYmkxc1pYTnpMWFJvWVc0dFlTMWtZWGxjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMGFHbHlkSGx0YVc1MWRHVnpJRDBnTVM4ME9EdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDOHZZMjl2YTJsbGN5NXpaWFFvSjI1aGJXVW5MQ0FuYlhKeWIzTnpKeXdnZXlCbGVIQnBjbVZ6T2lBM0lIMHBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdMeTlqYjI5cmFXVnpMbk5sZENnbmJtRnRaU2NzSUNkdGNuSnZjM01uTENCN0lHVjRjR2x5WlhNNklIUm9hWEowZVcxcGJuVjBaWE1nZlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNCamIyOXJhV1Z6TG5ObGRDZ25ibUZ0WlNjc0lDZHRjbkp2YzNNbkxDQjdJR1Y0Y0dseVpYTTZJR2x1Um1sbWRHVmxiazFwYm5WMFpYTWdmU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0I5S2k5Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCbVlXeHpaVHRjY2x4dUlDQWdJQ0FnSUNCOU8xeHlYRzRnSUNBZ0lDQWdJQzh2SUdOdmJuTnZiR1V1Ykc5bktHTnZiMnRwWlhNdVoyVjBLQ2R1WVcxbEp5a3BPMXh5WEc0Z0lDQWdJQ0FnSUM4dlkyOXVjMjlzWlM1c2IyY29ZMjl2YTJsbGN5NW5aWFFvSjI1aGJXVW5LU2s3WEhKY2JpQWdJQ0FnSUNBZ2RHaHBjeTV5WlhObGRFWnZjbTBnUFNCbWRXNWpkR2x2YmloemRXSnRhWFJmWm05eWJTbGNjbHh1SUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQzh2ZFc1elpYUWdZV3hzSUdacFpXeGtjMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnpaV3htTGlSbWFXVnNaSE11WldGamFDaG1kVzVqZEdsdmJpZ3BlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrWm1sbGJHUWdQU0FrS0hSb2FYTXBPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RDUm1hV1ZzWkM1eVpXMXZkbVZCZEhSeUtGd2laR0YwWVMxelppMTBZWGh2Ym05dGVTMWhjbU5vYVhabFhDSXBPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXpkR0Z1WkdGeVpDQm1hV1ZzWkNCMGVYQmxjMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdacFpXeGtMbVpwYm1Rb1hDSnpaV3hsWTNRNmJtOTBLRnR0ZFd4MGFYQnNaVDBuYlhWc2RHbHdiR1VuWFNrZ1BpQnZjSFJwYjI0NlptbHljM1F0WTJocGJHUmNJaWt1Y0hKdmNDaGNJbk5sYkdWamRHVmtYQ0lzSUhSeWRXVXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdacFpXeGtMbVpwYm1Rb1hDSnpaV3hsWTNSYmJYVnNkR2x3YkdVOUoyMTFiSFJwY0d4bEoxMGdQaUJ2Y0hScGIyNWNJaWt1Y0hKdmNDaGNJbk5sYkdWamRHVmtYQ0lzSUdaaGJITmxLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbWFXVnNaQzVtYVc1a0tGd2lhVzV3ZFhSYmRIbHdaVDBuWTJobFkydGliM2duWFZ3aUtTNXdjbTl3S0Z3aVkyaGxZMnRsWkZ3aUxDQm1ZV3h6WlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRdVptbHVaQ2hjSWo0Z2RXd2dQaUJzYVRwbWFYSnpkQzFqYUdsc1pDQnBibkIxZEZ0MGVYQmxQU2R5WVdScGJ5ZGRYQ0lwTG5CeWIzQW9YQ0pqYUdWamEyVmtYQ0lzSUhSeWRXVXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdacFpXeGtMbVpwYm1Rb1hDSnBibkIxZEZ0MGVYQmxQU2QwWlhoMEoxMWNJaWt1ZG1Gc0tGd2lYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHWnBaV3hrTG1acGJtUW9YQ0l1YzJZdGIzQjBhVzl1TFdGamRHbDJaVndpS1M1eVpXMXZkbVZEYkdGemN5aGNJbk5tTFc5d2RHbHZiaTFoWTNScGRtVmNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1ptbGxiR1F1Wm1sdVpDaGNJajRnZFd3Z1BpQnNhVHBtYVhKemRDMWphR2xzWkNCcGJuQjFkRnQwZVhCbFBTZHlZV1JwYnlkZFhDSXBMbkJoY21WdWRDZ3BMbUZrWkVOc1lYTnpLRndpYzJZdGIzQjBhVzl1TFdGamRHbDJaVndpS1RzZ0x5OXlaU0JoWkdRZ1lXTjBhWFpsSUdOc1lYTnpJSFJ2SUdacGNuTjBJRndpWkdWbVlYVnNkRndpSUc5d2RHbHZibHh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZiblZ0WW1WeUlISmhibWRsSUMwZ01pQnVkVzFpWlhJZ2FXNXdkWFFnWm1sbGJHUnpYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrWm1sbGJHUXVabWx1WkNoY0ltbHVjSFYwVzNSNWNHVTlKMjUxYldKbGNpZGRYQ0lwTG1WaFkyZ29ablZ1WTNScGIyNG9hVzVrWlhncGUxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkhSb2FYTkpibkIxZENBOUlDUW9kR2hwY3lrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LQ1IwYUdselNXNXdkWFF1Y0dGeVpXNTBLQ2t1Y0dGeVpXNTBLQ2t1YUdGelEyeGhjM01vWENKelppMXRaWFJoTFhKaGJtZGxYQ0lwS1NCN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlocGJtUmxlRDA5TUNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTkpibkIxZEM1MllXd29KSFJvYVhOSmJuQjFkQzVoZEhSeUtGd2liV2x1WENJcEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElHbG1LR2x1WkdWNFBUMHhLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtkR2hwYzBsdWNIVjBMblpoYkNna2RHaHBjMGx1Y0hWMExtRjBkSElvWENKdFlYaGNJaWtwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2YldWMFlTQXZJRzUxYldKbGNuTWdkMmwwYUNBeUlHbHVjSFYwY3lBb1puSnZiU0F2SUhSdklHWnBaV3hrY3lrZ0xTQnpaV052Ym1RZ2FXNXdkWFFnYlhWemRDQmlaU0J5WlhObGRDQjBieUJ0WVhnZ2RtRnNkV1ZjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWtiV1YwWVY5elpXeGxZM1JmWm5KdmJWOTBieUE5SUNSbWFXVnNaQzVtYVc1a0tGd2lMbk5tTFcxbGRHRXRjbUZ1WjJVdGMyVnNaV04wTFdaeWIyMTBiMXdpS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlna2JXVjBZVjl6Wld4bFkzUmZabkp2YlY5MGJ5NXNaVzVuZEdnK01Da2dlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2MzUmhjblJmYldsdUlEMGdKRzFsZEdGZmMyVnNaV04wWDJaeWIyMWZkRzh1WVhSMGNpaGNJbVJoZEdFdGJXbHVYQ0lwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCemRHRnlkRjl0WVhnZ1BTQWtiV1YwWVY5elpXeGxZM1JmWm5KdmJWOTBieTVoZEhSeUtGd2laR0YwWVMxdFlYaGNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSdFpYUmhYM05sYkdWamRGOW1jbTl0WDNSdkxtWnBibVFvWENKelpXeGxZM1JjSWlrdVpXRmphQ2htZFc1amRHbHZiaWhwYm1SbGVDbDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdKSFJvYVhOSmJuQjFkQ0E5SUNRb2RHaHBjeWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaWhwYm1SbGVEMDlNQ2tnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSMGFHbHpTVzV3ZFhRdWRtRnNLSE4wWVhKMFgyMXBiaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaU0JwWmlocGJtUmxlRDA5TVNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkhSb2FYTkpibkIxZEM1MllXd29jM1JoY25SZmJXRjRLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnSkcxbGRHRmZjbUZrYVc5ZlpuSnZiVjkwYnlBOUlDUm1hV1ZzWkM1bWFXNWtLRndpTG5ObUxXMWxkR0V0Y21GdVoyVXRjbUZrYVc4dFpuSnZiWFJ2WENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtDUnRaWFJoWDNKaFpHbHZYMlp5YjIxZmRHOHViR1Z1WjNSb1BqQXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhOMFlYSjBYMjFwYmlBOUlDUnRaWFJoWDNKaFpHbHZYMlp5YjIxZmRHOHVZWFIwY2loY0ltUmhkR0V0YldsdVhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ6ZEdGeWRGOXRZWGdnUFNBa2JXVjBZVjl5WVdScGIxOW1jbTl0WDNSdkxtRjBkSElvWENKa1lYUmhMVzFoZUZ3aUtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSeVlXUnBiMTluY205MWNITWdQU0FrYldWMFlWOXlZV1JwYjE5bWNtOXRYM1J2TG1acGJtUW9KeTV6WmkxcGJuQjFkQzF5WVc1blpTMXlZV1JwYnljcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWtjbUZrYVc5ZlozSnZkWEJ6TG1WaFkyZ29ablZ1WTNScGIyNG9hVzVrWlhncGUxeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUFrY21Ga2FXOXpJRDBnSkNoMGFHbHpLUzVtYVc1a0tGd2lMbk5tTFdsdWNIVjBMWEpoWkdsdlhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FrY21Ga2FXOXpMbkJ5YjNBb1hDSmphR1ZqYTJWa1hDSXNJR1poYkhObEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtHbHVaR1Y0UFQwd0tWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa2NtRmthVzl6TG1acGJIUmxjaWduVzNaaGJIVmxQVndpSnl0emRHRnlkRjl0YVc0ckoxd2lYU2NwTG5CeWIzQW9YQ0pqYUdWamEyVmtYQ0lzSUhSeWRXVXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdhV1lvYVc1a1pYZzlQVEVwWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1J5WVdScGIzTXVabWxzZEdWeUtDZGJkbUZzZFdVOVhDSW5LM04wWVhKMFgyMWhlQ3NuWENKZEp5a3VjSEp2Y0NoY0ltTm9aV05yWldSY0lpd2dkSEoxWlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmU2s3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZiblZ0WW1WeUlITnNhV1JsY2lBdElHNXZWV2xUYkdsa1pYSmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JtYVdWc1pDNW1hVzVrS0Z3aUxtMWxkR0V0YzJ4cFpHVnlYQ0lwTG1WaFkyZ29ablZ1WTNScGIyNG9hVzVrWlhncGUxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnYzJ4cFpHVnlYMjlpYW1WamRDQTlJQ1FvZEdocGN5bGJNRjA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeXAyWVhJZ2MyeHBaR1Z5WDI5aWFtVmpkQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSWk1dFpYUmhMWE5zYVdSbGNsd2lLVnN3WFR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlITnNhV1JsY2w5MllXd2dQU0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSXVaMlYwS0NrN0tpOWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSemJHbGtaWEpmWld3Z1BTQWtLSFJvYVhNcExtTnNiM05sYzNRb1hDSXVjMll0YldWMFlTMXlZVzVuWlMxemJHbGtaWEpjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHMXBibFpoYkNBOUlDUnpiR2xrWlhKZlpXd3VZWFIwY2loY0ltUmhkR0V0YldsdVhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJ0WVhoV1lXd2dQU0FrYzJ4cFpHVnlYMlZzTG1GMGRISW9YQ0prWVhSaExXMWhlRndpS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Ykdsa1pYSmZiMkpxWldOMExtNXZWV2xUYkdsa1pYSXVjMlYwS0Z0dGFXNVdZV3dzSUcxaGVGWmhiRjBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDBwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2Ym1WbFpDQjBieUJ6WldVZ2FXWWdZVzU1SUdGeVpTQmpiMjFpYjJKdmVDQmhibVFnWVdOMElHRmpZMjl5WkdsdVoyeDVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ0pHTnZiV0p2WW05NElEMGdKR1pwWld4a0xtWnBibVFvWENKelpXeGxZM1JiWkdGMFlTMWpiMjFpYjJKdmVEMG5NU2RkWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lvSkdOdmJXSnZZbTk0TG14bGJtZDBhRDR3S1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaDBlWEJsYjJZZ0pHTnZiV0p2WW05NExtTm9iM05sYmlBaFBTQmNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdOdmJXSnZZbTk0TG5SeWFXZG5aWElvWENKamFHOXpaVzQ2ZFhCa1lYUmxaRndpS1RzZ0x5OW1iM0lnWTJodmMyVnVJRzl1YkhsY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdaV3h6WlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkdOdmJXSnZZbTk0TG5aaGJDZ25KeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSamIyMWliMkp2ZUM1MGNtbG5aMlZ5S0NkamFHRnVaMlV1YzJWc1pXTjBNaWNwTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I5S1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWpiR1ZoY2xScGJXVnlLQ2s3WEhKY2JseHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUdsbUtITjFZbTFwZEY5bWIzSnRQVDFjSW1Gc2QyRjVjMXdpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCelpXeG1Mbk4xWW0xcGRFWnZjbTBvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JsYkhObElHbG1LSE4xWW0xcGRGOW1iM0p0UFQxY0ltNWxkbVZ5WENJcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUh0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHbG1LSFJvYVhNdVlYVjBiMTlqYjNWdWRGOXlaV1p5WlhOb1gyMXZaR1U5UFRFcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2MyVnNaaTVtYjNKdFZYQmtZWFJsWkVabGRHTm9RV3BoZUNncE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZb2MzVmliV2wwWDJadmNtMDlQVndpWVhWMGIxd2lLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGFHbHpMbUYxZEc5ZmRYQmtZWFJsUFQxMGNuVmxLVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSE5sYkdZdWMzVmliV2wwUm05eWJTZ3BPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ1pXeHpaVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hSb2FYTXVZWFYwYjE5amIzVnVkRjl5WldaeVpYTm9YMjF2WkdVOVBURXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnpaV3htTG1admNtMVZjR1JoZEdWa1JtVjBZMmhCYW1GNEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIMDdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lIUm9hWE11YVc1cGRDZ3BPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjJZWElnWlhabGJuUmZaR0YwWVNBOUlIdDlPMXh5WEc0Z0lDQWdJQ0FnSUdWMlpXNTBYMlJoZEdFdWMyWnBaQ0E5SUhObGJHWXVjMlpwWkR0Y2NseHVJQ0FnSUNBZ0lDQmxkbVZ1ZEY5a1lYUmhMblJoY21kbGRGTmxiR1ZqZEc5eUlEMGdjMlZzWmk1aGFtRjRYM1JoY21kbGRGOWhkSFJ5TzF4eVhHNGdJQ0FnSUNBZ0lHVjJaVzUwWDJSaGRHRXViMkpxWldOMElEMGdkR2hwY3p0Y2NseHVJQ0FnSUNBZ0lDQnBaaWh2Y0hSekxtbHpTVzVwZENsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lITmxiR1l1ZEhKcFoyZGxja1YyWlc1MEtGd2ljMlk2YVc1cGRGd2lMQ0JsZG1WdWRGOWtZWFJoS1R0Y2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnZlNrN1hISmNibjA3WEhKY2JpSmRmUT09IiwiKGZ1bmN0aW9uIChnbG9iYWwpe1xuXHJcbnZhciAkID0gKHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCIgPyB3aW5kb3dbJ2pRdWVyeSddIDogdHlwZW9mIGdsb2JhbCAhPT0gXCJ1bmRlZmluZWRcIiA/IGdsb2JhbFsnalF1ZXJ5J10gOiBudWxsKTtcclxuXHJcbm1vZHVsZS5leHBvcnRzID0ge1xyXG5cclxuXHR0YXhvbm9teV9hcmNoaXZlczogMCxcclxuICAgIHVybF9wYXJhbXM6IHt9LFxyXG4gICAgdGF4X2FyY2hpdmVfcmVzdWx0c191cmw6IFwiXCIsXHJcbiAgICBhY3RpdmVfdGF4OiBcIlwiLFxyXG4gICAgZmllbGRzOiB7fSxcclxuXHRpbml0OiBmdW5jdGlvbih0YXhvbm9teV9hcmNoaXZlcywgY3VycmVudF90YXhvbm9teV9hcmNoaXZlKXtcclxuXHJcbiAgICAgICAgdGhpcy50YXhvbm9teV9hcmNoaXZlcyA9IDA7XHJcbiAgICAgICAgdGhpcy51cmxfcGFyYW1zID0ge307XHJcbiAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IFwiXCI7XHJcbiAgICAgICAgdGhpcy5hY3RpdmVfdGF4ID0gXCJcIjtcclxuXHJcblx0XHQvL3RoaXMuJGZpZWxkcyA9ICRmaWVsZHM7XHJcbiAgICAgICAgdGhpcy50YXhvbm9teV9hcmNoaXZlcyA9IHRheG9ub215X2FyY2hpdmVzO1xyXG4gICAgICAgIHRoaXMuY3VycmVudF90YXhvbm9teV9hcmNoaXZlID0gY3VycmVudF90YXhvbm9teV9hcmNoaXZlO1xyXG5cclxuXHRcdHRoaXMuY2xlYXJVcmxDb21wb25lbnRzKCk7XHJcblxyXG5cdH0sXHJcbiAgICBzZXRUYXhBcmNoaXZlUmVzdWx0c1VybDogZnVuY3Rpb24oJGZvcm0sIGN1cnJlbnRfcmVzdWx0c191cmwsIGdldF9hY3RpdmUpIHtcclxuXHJcbiAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xyXG5cclxuICAgICAgICAvL3ZhciBjdXJyZW50X3Jlc3VsdHNfdXJsID0gXCJcIjtcclxuICAgICAgICBpZih0aGlzLnRheG9ub215X2FyY2hpdmVzIT0xKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodHlwZW9mKGdldF9hY3RpdmUpPT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHR2YXIgZ2V0X2FjdGl2ZSA9IGZhbHNlO1xyXG5cdFx0fVxyXG5cclxuICAgICAgICAvL2NoZWNrIHRvIHNlZSBpZiB3ZSBoYXZlIGFueSB0YXhvbm9taWVzIHNlbGVjdGVkXHJcbiAgICAgICAgLy9pZiBzbywgY2hlY2sgdGhlaXIgcmV3cml0ZXMgYW5kIHVzZSB0aG9zZSBhcyB0aGUgcmVzdWx0cyB1cmxcclxuICAgICAgICB2YXIgJGZpZWxkID0gZmFsc2U7XHJcbiAgICAgICAgdmFyIGZpZWxkX25hbWUgPSBcIlwiO1xyXG4gICAgICAgIHZhciBmaWVsZF92YWx1ZSA9IFwiXCI7XHJcblxyXG4gICAgICAgIHZhciAkYWN0aXZlX3RheG9ub215ID0gJGZvcm0uJGZpZWxkcy5wYXJlbnQoKS5maW5kKFwiW2RhdGEtc2YtdGF4b25vbXktYXJjaGl2ZT0nMSddXCIpO1xyXG4gICAgICAgIGlmKCRhY3RpdmVfdGF4b25vbXkubGVuZ3RoPT0xKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgJGZpZWxkID0gJGFjdGl2ZV90YXhvbm9teTtcclxuXHJcbiAgICAgICAgICAgIHZhciBmaWVsZFR5cGUgPSAkZmllbGQuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHJcbiAgICAgICAgICAgIGlmICgoZmllbGRUeXBlID09IFwidGFnXCIpIHx8IChmaWVsZFR5cGUgPT0gXCJjYXRlZ29yeVwiKSB8fCAoZmllbGRUeXBlID09IFwidGF4b25vbXlcIikpIHtcclxuICAgICAgICAgICAgICAgIHZhciB0YXhvbm9teV92YWx1ZSA9IHNlbGYucHJvY2Vzc1RheG9ub215KCRmaWVsZCwgdHJ1ZSk7XHJcbiAgICAgICAgICAgICAgICBmaWVsZF9uYW1lID0gJGZpZWxkLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcbiAgICAgICAgICAgICAgICB2YXIgdGF4b25vbXlfbmFtZSA9IGZpZWxkX25hbWUucmVwbGFjZShcIl9zZnRfXCIsIFwiXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgIGlmICh0YXhvbm9teV92YWx1ZSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGZpZWxkX3ZhbHVlID0gdGF4b25vbXlfdmFsdWUudmFsdWU7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIGlmKGZpZWxkX3ZhbHVlPT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICAkZmllbGQgPSBmYWxzZTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYoKHNlbGYuY3VycmVudF90YXhvbm9teV9hcmNoaXZlIT1cIlwiKSYmKHNlbGYuY3VycmVudF90YXhvbm9teV9hcmNoaXZlIT10YXhvbm9teV9uYW1lKSlcclxuICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gY3VycmVudF9yZXN1bHRzX3VybDtcclxuICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYoKChmaWVsZF92YWx1ZT09XCJcIil8fCghJGZpZWxkKSApKVxyXG4gICAgICAgIHtcclxuICAgICAgICAgICAgJGZvcm0uJGZpZWxkcy5lYWNoKGZ1bmN0aW9uICgpIHtcclxuXHJcbiAgICAgICAgICAgICAgICBpZiAoISRmaWVsZCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRUeXBlID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAoKGZpZWxkVHlwZSA9PSBcInRhZ1wiKSB8fCAoZmllbGRUeXBlID09IFwiY2F0ZWdvcnlcIikgfHwgKGZpZWxkVHlwZSA9PSBcInRheG9ub215XCIpKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB0YXhvbm9teV92YWx1ZSA9IHNlbGYucHJvY2Vzc1RheG9ub215KCQodGhpcyksIHRydWUpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmaWVsZF9uYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHRheG9ub215X3ZhbHVlKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZmllbGRfdmFsdWUgPSB0YXhvbm9teV92YWx1ZS52YWx1ZTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoZmllbGRfdmFsdWUgIT0gXCJcIikge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZmllbGQgPSAkKHRoaXMpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZiggKCRmaWVsZCkgJiYgKGZpZWxkX3ZhbHVlICE9IFwiXCIgKSkge1xyXG4gICAgICAgICAgICAvL2lmIHdlIGZvdW5kIGEgZmllbGRcclxuXHRcdFx0dmFyIHJld3JpdGVfYXR0ciA9ICgkZmllbGQuYXR0cihcImRhdGEtc2YtdGVybS1yZXdyaXRlXCIpKTtcclxuXHJcbiAgICAgICAgICAgIGlmKHJld3JpdGVfYXR0ciE9XCJcIikge1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciByZXdyaXRlID0gSlNPTi5wYXJzZShyZXdyaXRlX2F0dHIpO1xyXG4gICAgICAgICAgICAgICAgdmFyIGlucHV0X3R5cGUgPSAkZmllbGQuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuICAgICAgICAgICAgICAgIHNlbGYuYWN0aXZlX3RheCA9IGZpZWxkX25hbWU7XHJcblxyXG4gICAgICAgICAgICAgICAgLy9maW5kIHRoZSBhY3RpdmUgZWxlbWVudFxyXG4gICAgICAgICAgICAgICAgaWYgKChpbnB1dF90eXBlID09IFwicmFkaW9cIikgfHwgKGlucHV0X3R5cGUgPT0gXCJjaGVja2JveFwiKSkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAvL3ZhciAkYWN0aXZlID0gJGZpZWxkLmZpbmQoXCIuc2Ytb3B0aW9uLWFjdGl2ZVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAvL2V4cGxvZGUgdGhlIHZhbHVlcyBpZiB0aGVyZSBpcyBhIGRlbGltXHJcbiAgICAgICAgICAgICAgICAgICAgLy9maWVsZF92YWx1ZVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB2YXIgaXNfc2luZ2xlX3ZhbHVlID0gdHJ1ZTtcclxuICAgICAgICAgICAgICAgICAgICB2YXIgZmllbGRfdmFsdWVzID0gZmllbGRfdmFsdWUuc3BsaXQoXCIsXCIpLmpvaW4oXCIrXCIpLnNwbGl0KFwiK1wiKTtcclxuICAgICAgICAgICAgICAgICAgICBpZiAoZmllbGRfdmFsdWVzLmxlbmd0aCA+IDEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaXNfc2luZ2xlX3ZhbHVlID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICBpZiAoaXNfc2luZ2xlX3ZhbHVlKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgJGlucHV0ID0gJGZpZWxkLmZpbmQoXCJpbnB1dFt2YWx1ZT0nXCIgKyBmaWVsZF92YWx1ZSArIFwiJ11cIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlID0gJGlucHV0LnBhcmVudCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGggPSAkYWN0aXZlLmF0dHIoXCJkYXRhLXNmLWRlcHRoXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9ub3cgbG9vcCB0aHJvdWdoIHBhcmVudHMgdG8gZ3JhYiB0aGVpciBuYW1lc1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgdmFsdWVzID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKGZpZWxkX3ZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGZvciAodmFyIGkgPSBkZXB0aDsgaSA+IDA7IGktLSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJGFjdGl2ZSA9ICRhY3RpdmUucGFyZW50KCkucGFyZW50KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaCgkYWN0aXZlLmZpbmQoXCJpbnB1dFwiKS52YWwoKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5yZXZlcnNlKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL2dyYWIgdGhlIHJld3JpdGUgZm9yIHRoaXMgZGVwdGhcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGFjdGl2ZV9yZXdyaXRlID0gcmV3cml0ZVtkZXB0aF07XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB1cmwgPSBhY3RpdmVfcmV3cml0ZTtcclxuXHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3RoZW4gbWFwIGZyb20gdGhlIHBhcmVudHMgdG8gdGhlIGRlcHRoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICQodmFsdWVzKS5lYWNoKGZ1bmN0aW9uIChpbmRleCwgdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB1cmwgPSB1cmwucmVwbGFjZShcIltcIiArIGluZGV4ICsgXCJdXCIsIHZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsID0gdXJsO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBlbHNlIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vaWYgdGhlcmUgYXJlIG11bHRpcGxlIHZhbHVlcyxcclxuICAgICAgICAgICAgICAgICAgICAgICAgLy90aGVuIHdlIG5lZWQgdG8gY2hlY2sgZm9yIDMgdGhpbmdzOlxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pZiB0aGUgdmFsdWVzIHNlbGVjdGVkIGFyZSBhbGwgaW4gdGhlIHNhbWUgdHJlZSB0aGVuIHdlIGNhbiBkbyBzb21lIGNsZXZlciByZXdyaXRlIHN0dWZmXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vbWVyZ2UgYWxsIHZhbHVlcyBpbiBzYW1lIGxldmVsLCB0aGVuIGNvbWJpbmUgdGhlIGxldmVsc1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLy9pZiB0aGV5IGFyZSBmcm9tIGRpZmZlcmVudCB0cmVlcyB0aGVuIGp1c3QgY29tYmluZSB0aGVtIG9yIGp1c3QgdXNlIGBmaWVsZF92YWx1ZWBcclxuICAgICAgICAgICAgICAgICAgICAgICAgLypcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGhzID0gbmV3IEFycmF5KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAkKGZpZWxkX3ZhbHVlcykuZWFjaChmdW5jdGlvbiAoaW5kZXgsIHZhbCkge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkaW5wdXQgPSAkZmllbGQuZmluZChcImlucHV0W3ZhbHVlPSdcIiArIGZpZWxkX3ZhbHVlICsgXCInXVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlID0gJGlucHV0LnBhcmVudCgpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBkZXB0aCA9ICRhY3RpdmUuYXR0cihcImRhdGEtc2YtZGVwdGhcIik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAvL2RlcHRocy5wdXNoKGRlcHRoKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICB9KTsqL1xyXG5cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICBlbHNlIGlmICgoaW5wdXRfdHlwZSA9PSBcInNlbGVjdFwiKSB8fCAoaW5wdXRfdHlwZSA9PSBcIm11bHRpc2VsZWN0XCIpKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIHZhciBpc19zaW5nbGVfdmFsdWUgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgICAgIHZhciBmaWVsZF92YWx1ZXMgPSBmaWVsZF92YWx1ZS5zcGxpdChcIixcIikuam9pbihcIitcIikuc3BsaXQoXCIrXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChmaWVsZF92YWx1ZXMubGVuZ3RoID4gMSkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpc19zaW5nbGVfdmFsdWUgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmIChpc19zaW5nbGVfdmFsdWUpIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAkYWN0aXZlID0gJGZpZWxkLmZpbmQoXCJvcHRpb25bdmFsdWU9J1wiICsgZmllbGRfdmFsdWUgKyBcIiddXCIpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgZGVwdGggPSAkYWN0aXZlLmF0dHIoXCJkYXRhLXNmLWRlcHRoXCIpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHZhbHVlcyA9IG5ldyBBcnJheSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucHVzaChmaWVsZF92YWx1ZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICBmb3IgKHZhciBpID0gZGVwdGg7IGkgPiAwOyBpLS0pIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRhY3RpdmUgPSAkYWN0aXZlLnByZXZBbGwoXCJvcHRpb25bZGF0YS1zZi1kZXB0aD0nXCIgKyAoaSAtIDEpICsgXCInXVwiKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlcy5wdXNoKCRhY3RpdmUudmFsKCkpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZXMucmV2ZXJzZSgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgYWN0aXZlX3Jld3JpdGUgPSByZXdyaXRlW2RlcHRoXTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIHVybCA9IGFjdGl2ZV9yZXdyaXRlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAkKHZhbHVlcykuZWFjaChmdW5jdGlvbiAoaW5kZXgsIHZhbHVlKSB7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsID0gdXJsLnJlcGxhY2UoXCJbXCIgKyBpbmRleCArIFwiXVwiLCB2YWx1ZSk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy50YXhfYXJjaGl2ZV9yZXN1bHRzX3VybCA9IHVybDtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgIH1cclxuICAgICAgICAvL3RoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwgPSBjdXJyZW50X3Jlc3VsdHNfdXJsO1xyXG4gICAgfSxcclxuICAgIGdldFJlc3VsdHNVcmw6IGZ1bmN0aW9uKCRmb3JtLCBjdXJyZW50X3Jlc3VsdHNfdXJsKSB7XHJcblxyXG4gICAgICAgIC8vdGhpcy5zZXRUYXhBcmNoaXZlUmVzdWx0c1VybCgkZm9ybSwgY3VycmVudF9yZXN1bHRzX3VybCk7XHJcblxyXG4gICAgICAgIGlmKHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmw9PVwiXCIpXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICByZXR1cm4gY3VycmVudF9yZXN1bHRzX3VybDtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIHJldHVybiB0aGlzLnRheF9hcmNoaXZlX3Jlc3VsdHNfdXJsO1xyXG4gICAgfSxcclxuXHRnZXRVcmxQYXJhbXM6IGZ1bmN0aW9uKCRmb3JtKXtcclxuXHJcblx0XHR0aGlzLmJ1aWxkVXJsQ29tcG9uZW50cygkZm9ybSwgdHJ1ZSk7XHJcblxyXG4gICAgICAgIGlmKHRoaXMudGF4X2FyY2hpdmVfcmVzdWx0c191cmwhPVwiXCIpXHJcbiAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgaWYodGhpcy5hY3RpdmVfdGF4IT1cIlwiKVxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgICB2YXIgZmllbGRfbmFtZSA9IHRoaXMuYWN0aXZlX3RheDtcclxuXHJcbiAgICAgICAgICAgICAgICBpZih0eXBlb2YodGhpcy51cmxfcGFyYW1zW2ZpZWxkX25hbWVdKSE9XCJ1bmRlZmluZWRcIilcclxuICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICBkZWxldGUgdGhpcy51cmxfcGFyYW1zW2ZpZWxkX25hbWVdO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuXHRcdHJldHVybiB0aGlzLnVybF9wYXJhbXM7XHJcblx0fSxcclxuXHRjbGVhclVybENvbXBvbmVudHM6IGZ1bmN0aW9uKCl7XHJcblx0XHQvL3RoaXMudXJsX2NvbXBvbmVudHMgPSBcIlwiO1xyXG5cdFx0dGhpcy51cmxfcGFyYW1zID0ge307XHJcblx0fSxcclxuXHRkaXNhYmxlSW5wdXRzOiBmdW5jdGlvbigkZm9ybSl7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdCRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcclxuXHRcdFx0dmFyICRpbnB1dHMgPSAkKHRoaXMpLmZpbmQoXCJpbnB1dCwgc2VsZWN0LCAubWV0YS1zbGlkZXJcIik7XHJcblx0XHRcdCRpbnB1dHMuYXR0cihcImRpc2FibGVkXCIsIFwiZGlzYWJsZWRcIik7XHJcblx0XHRcdCRpbnB1dHMuYXR0cihcImRpc2FibGVkXCIsIHRydWUpO1xyXG5cdFx0XHQkaW5wdXRzLnByb3AoXCJkaXNhYmxlZFwiLCB0cnVlKTtcclxuXHRcdFx0JGlucHV0cy50cmlnZ2VyKFwiY2hvc2VuOnVwZGF0ZWRcIik7XHJcblx0XHRcdFxyXG5cdFx0fSk7XHJcblx0XHRcclxuXHRcdFxyXG5cdH0sXHJcblx0ZW5hYmxlSW5wdXRzOiBmdW5jdGlvbigkZm9ybSl7XHJcblx0XHR2YXIgc2VsZiA9IHRoaXM7XHJcblx0XHRcclxuXHRcdCRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcclxuXHRcdFx0dmFyICRpbnB1dHMgPSAkKHRoaXMpLmZpbmQoXCJpbnB1dCwgc2VsZWN0LCAubWV0YS1zbGlkZXJcIik7XHJcblx0XHRcdCRpbnB1dHMucHJvcChcImRpc2FibGVkXCIsIHRydWUpO1xyXG5cdFx0XHQkaW5wdXRzLnJlbW92ZUF0dHIoXCJkaXNhYmxlZFwiKTtcclxuXHRcdFx0JGlucHV0cy50cmlnZ2VyKFwiY2hvc2VuOnVwZGF0ZWRcIik7XHRcdFx0XHJcblx0XHR9KTtcclxuXHRcdFxyXG5cdFx0XHJcblx0fSxcclxuXHRidWlsZFVybENvbXBvbmVudHM6IGZ1bmN0aW9uKCRmb3JtLCBjbGVhcl9jb21wb25lbnRzKXtcclxuXHRcdFxyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoY2xlYXJfY29tcG9uZW50cykhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGNsZWFyX2NvbXBvbmVudHM9PXRydWUpXHJcblx0XHRcdHtcclxuXHRcdFx0XHR0aGlzLmNsZWFyVXJsQ29tcG9uZW50cygpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdCRmb3JtLiRmaWVsZHMuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcclxuXHRcdFx0dmFyIGZpZWxkTmFtZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHRcdFx0dmFyIGZpZWxkVHlwZSA9ICQodGhpcykuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHRcdFx0XHJcblx0XHRcdGlmKGZpZWxkVHlwZT09XCJzZWFyY2hcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1NlYXJjaEZpZWxkKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoKGZpZWxkVHlwZT09XCJ0YWdcIil8fChmaWVsZFR5cGU9PVwiY2F0ZWdvcnlcIil8fChmaWVsZFR5cGU9PVwidGF4b25vbXlcIikpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NUYXhvbm9teSgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJzb3J0X29yZGVyXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NTb3J0T3JkZXJGaWVsZCgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0c19wZXJfcGFnZVwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzUmVzdWx0c1BlclBhZ2VGaWVsZCgkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJhdXRob3JcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc0F1dGhvcigkKHRoaXMpKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGZpZWxkVHlwZT09XCJwb3N0X3R5cGVcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHNlbGYucHJvY2Vzc1Bvc3RUeXBlKCQodGhpcykpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoZmllbGRUeXBlPT1cInBvc3RfZGF0ZVwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0c2VsZi5wcm9jZXNzUG9zdERhdGUoJCh0aGlzKSk7XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihmaWVsZFR5cGU9PVwicG9zdF9tZXRhXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRzZWxmLnByb2Nlc3NQb3N0TWV0YSgkKHRoaXMpKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlXHJcblx0XHRcdHtcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH0pO1xyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzU2VhcmNoRmllbGQ6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHR2YXIgJGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiaW5wdXRbbmFtZV49J19zZl9zZWFyY2gnXVwiKTtcclxuXHRcdFxyXG5cdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0e1xyXG5cdFx0XHR2YXIgZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHR2YXIgZmllbGRWYWwgPSAkZmllbGQudmFsKCk7XHJcblx0XHRcdFxyXG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZfc2Zfcz1cIitlbmNvZGVVUklDb21wb25lbnQoZmllbGRWYWwpO1xyXG5cdFx0XHRcdHNlbGYudXJsX3BhcmFtc1snX3NmX3MnXSA9IGVuY29kZVVSSUNvbXBvbmVudChmaWVsZFZhbCk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHR9LFxyXG5cdHByb2Nlc3NTb3J0T3JkZXJGaWVsZDogZnVuY3Rpb24oJGNvbnRhaW5lcilcclxuXHR7XHJcblx0XHR0aGlzLnByb2Nlc3NBdXRob3IoJGNvbnRhaW5lcik7XHJcblx0XHRcclxuXHR9LFxyXG5cdHByb2Nlc3NSZXN1bHRzUGVyUGFnZUZpZWxkOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHRoaXMucHJvY2Vzc0F1dGhvcigkY29udGFpbmVyKTtcclxuXHRcdFxyXG5cdH0sXHJcblx0Z2V0QWN0aXZlVGF4OiBmdW5jdGlvbigkZmllbGQpIHtcclxuXHRcdHJldHVybiB0aGlzLmFjdGl2ZV90YXg7XHJcblx0fSxcclxuXHRnZXRTZWxlY3RWYWw6IGZ1bmN0aW9uKCRmaWVsZCl7XHJcblxyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0aWYoJGZpZWxkLnZhbCgpIT0wKVxyXG5cdFx0e1xyXG5cdFx0XHRmaWVsZFZhbCA9ICRmaWVsZC52YWwoKTtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYoZmllbGRWYWw9PW51bGwpXHJcblx0XHR7XHJcblx0XHRcdGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0cmV0dXJuIGZpZWxkVmFsO1xyXG5cdH0sXHJcblx0Z2V0TWV0YVNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkKXtcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0ZmllbGRWYWwgPSAkZmllbGQudmFsKCk7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0aWYoZmllbGRWYWw9PW51bGwpXHJcblx0XHR7XHJcblx0XHRcdGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0cmV0dXJuIGZpZWxkVmFsO1xyXG5cdH0sXHJcblx0Z2V0TXVsdGlTZWxlY3RWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xyXG5cdFx0XHJcblx0XHR2YXIgZGVsaW0gPSBcIitcIjtcclxuXHRcdGlmKG9wZXJhdG9yPT1cIm9yXCIpXHJcblx0XHR7XHJcblx0XHRcdGRlbGltID0gXCIsXCI7XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZigkZmllbGQudmFsKCkpPT1cIm9iamVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZigkZmllbGQudmFsKCkhPW51bGwpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRyZXR1cm4gJGZpZWxkLnZhbCgpLmpvaW4oZGVsaW0pO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHR9LFxyXG5cdGdldE1ldGFNdWx0aVNlbGVjdFZhbDogZnVuY3Rpb24oJGZpZWxkLCBvcGVyYXRvcil7XHJcblx0XHRcclxuXHRcdHZhciBkZWxpbSA9IFwiLSstXCI7XHJcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRkZWxpbSA9IFwiLSwtXCI7XHJcblx0XHR9XHJcblx0XHRcdFx0XHJcblx0XHRpZih0eXBlb2YoJGZpZWxkLnZhbCgpKT09XCJvYmplY3RcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoJGZpZWxkLnZhbCgpIT1udWxsKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIGZpZWxkdmFsID0gW107XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0JCgkZmllbGQudmFsKCkpLmVhY2goZnVuY3Rpb24oaW5kZXgsdmFsdWUpe1xyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRmaWVsZHZhbC5wdXNoKCh2YWx1ZSkpO1xyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdHJldHVybiBmaWVsZHZhbC5qb2luKGRlbGltKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gXCJcIjtcclxuXHRcdFxyXG5cdH0sXHJcblx0Z2V0Q2hlY2tib3hWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xyXG5cdFx0XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKXtcclxuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAkKHRoaXMpLnZhbCgpO1xyXG5cdFx0XHR9XHJcblx0XHR9KS5nZXQoKTtcclxuXHRcdFxyXG5cdFx0dmFyIGRlbGltID0gXCIrXCI7XHJcblx0XHRpZihvcGVyYXRvcj09XCJvclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRkZWxpbSA9IFwiLFwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWwuam9pbihkZWxpbSk7XHJcblx0fSxcclxuXHRnZXRNZXRhQ2hlY2tib3hWYWw6IGZ1bmN0aW9uKCRmaWVsZCwgb3BlcmF0b3Ipe1xyXG5cdFx0XHJcblx0XHRcclxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKXtcclxuXHRcdFx0aWYoJCh0aGlzKS5wcm9wKFwiY2hlY2tlZFwiKT09dHJ1ZSlcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHJldHVybiAoJCh0aGlzKS52YWwoKSk7XHJcblx0XHRcdH1cclxuXHRcdH0pLmdldCgpO1xyXG5cdFx0XHJcblx0XHR2YXIgZGVsaW0gPSBcIi0rLVwiO1xyXG5cdFx0aWYob3BlcmF0b3I9PVwib3JcIilcclxuXHRcdHtcclxuXHRcdFx0ZGVsaW0gPSBcIi0sLVwiO1xyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWwuam9pbihkZWxpbSk7XHJcblx0fSxcclxuXHRnZXRSYWRpb1ZhbDogZnVuY3Rpb24oJGZpZWxkKXtcclxuXHRcdFx0XHRcdFx0XHRcclxuXHRcdHZhciBmaWVsZFZhbCA9ICRmaWVsZC5tYXAoZnVuY3Rpb24oKVxyXG5cdFx0e1xyXG5cdFx0XHRpZigkKHRoaXMpLnByb3AoXCJjaGVja2VkXCIpPT10cnVlKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0cmV0dXJuICQodGhpcykudmFsKCk7XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHR9KS5nZXQoKTtcclxuXHRcdFxyXG5cdFx0XHJcblx0XHRpZihmaWVsZFZhbFswXSE9MClcclxuXHRcdHtcclxuXHRcdFx0cmV0dXJuIGZpZWxkVmFsWzBdO1xyXG5cdFx0fVxyXG5cdH0sXHJcblx0Z2V0TWV0YVJhZGlvVmFsOiBmdW5jdGlvbigkZmllbGQpe1xyXG5cdFx0XHRcdFx0XHRcdFxyXG5cdFx0dmFyIGZpZWxkVmFsID0gJGZpZWxkLm1hcChmdW5jdGlvbigpXHJcblx0XHR7XHJcblx0XHRcdGlmKCQodGhpcykucHJvcChcImNoZWNrZWRcIik9PXRydWUpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRyZXR1cm4gJCh0aGlzKS52YWwoKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH0pLmdldCgpO1xyXG5cdFx0XHJcblx0XHRyZXR1cm4gZmllbGRWYWxbMF07XHJcblx0fSxcclxuXHRwcm9jZXNzQXV0aG9yOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuXHRcdFxyXG5cdFx0dmFyICRmaWVsZDtcclxuXHRcdHZhciBmaWVsZE5hbWUgPSBcIlwiO1xyXG5cdFx0dmFyIGZpZWxkVmFsID0gXCJcIjtcclxuXHRcdFxyXG5cdFx0aWYoaW5wdXRUeXBlPT1cInNlbGVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRTZWxlY3RWYWwoJGZpZWxkKTsgXHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJzZWxlY3RcIik7XHJcblx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0dmFyIG9wZXJhdG9yID0gJGZpZWxkLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcclxuXHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE11bHRpU2VsZWN0VmFsKCRmaWVsZCwgXCJvclwiKTtcclxuXHRcdFx0XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJjaGVja2JveFwiKVxyXG5cdFx0e1xyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xyXG5cdFx0XHRcclxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRjb250YWluZXIuZmluZChcIj4gdWxcIikuYXR0cihcImRhdGEtb3BlcmF0b3JcIik7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldENoZWNrYm94VmFsKCRmaWVsZCwgXCJvclwiKTtcclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhZGlvXCIpXHJcblx0XHR7XHJcblx0XHRcdFxyXG5cdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OnJhZGlvXCIpO1xyXG5cdFx0XHRcdFx0XHRcclxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRSYWRpb1ZhbCgkZmllbGQpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0dmFyIGZpZWxkU2x1ZyA9IFwiXCI7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoZmllbGROYW1lPT1cIl9zZl9hdXRob3JcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcImF1dGhvcnNcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZSBpZihmaWVsZE5hbWU9PVwiX3NmX3NvcnRfb3JkZXJcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZFNsdWcgPSBcInNvcnRfb3JkZXJcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZSBpZihmaWVsZE5hbWU9PVwiX3NmX3BwcFwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IFwiX3NmX3BwcFwiO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRlbHNlIGlmKGZpZWxkTmFtZT09XCJfc2ZfcG9zdF90eXBlXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJwb3N0X3R5cGVzXCI7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2VcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKGZpZWxkU2x1ZyE9XCJcIilcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZmllbGRTbHVnK1wiPVwiK2ZpZWxkVmFsO1xyXG5cdFx0XHRcdFx0c2VsZi51cmxfcGFyYW1zW2ZpZWxkU2x1Z10gPSBmaWVsZFZhbDtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdFxyXG5cdH0sXHJcblx0cHJvY2Vzc1Bvc3RUeXBlIDogZnVuY3Rpb24oJHRoaXMpe1xyXG5cdFx0XHJcblx0XHR0aGlzLnByb2Nlc3NBdXRob3IoJHRoaXMpO1xyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzUG9zdE1ldGE6IGZ1bmN0aW9uKCRjb250YWluZXIpXHJcblx0e1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFx0XHJcblx0XHR2YXIgZmllbGRUeXBlID0gJGNvbnRhaW5lci5hdHRyKFwiZGF0YS1zZi1maWVsZC10eXBlXCIpO1xyXG5cdFx0dmFyIGlucHV0VHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtaW5wdXQtdHlwZVwiKTtcclxuXHRcdHZhciBtZXRhVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtbWV0YS10eXBlXCIpO1xyXG5cclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHR2YXIgJGZpZWxkO1xyXG5cdFx0dmFyIGZpZWxkTmFtZSA9IFwiXCI7XHJcblx0XHRcclxuXHRcdGlmKG1ldGFUeXBlPT1cIm51bWJlclwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihpbnB1dFR5cGU9PVwicmFuZ2UtbnVtYmVyXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCIuc2YtbWV0YS1yYW5nZS1udW1iZXIgaW5wdXRcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIHZhbHVlcyA9IFtdO1xyXG5cdFx0XHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdHZhbHVlcy5wdXNoKCQodGhpcykudmFsKCkpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdH0pO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gdmFsdWVzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cInJhbmdlLXNsaWRlclwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2Utc2xpZGVyIGlucHV0XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdC8vZ2V0IGFueSBudW1iZXIgZm9ybWF0dGluZyBzdHVmZlxyXG5cdFx0XHRcdHZhciAkbWV0YV9yYW5nZSA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlLXNsaWRlclwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgZGVjaW1hbF9wbGFjZXMgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1kZWNpbWFsLXBsYWNlc1wiKTtcclxuXHRcdFx0XHR2YXIgdGhvdXNhbmRfc2VwZXJhdG9yID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtdGhvdXNhbmQtc2VwZXJhdG9yXCIpO1xyXG5cdFx0XHRcdHZhciBkZWNpbWFsX3NlcGVyYXRvciA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLWRlY2ltYWwtc2VwZXJhdG9yXCIpO1xyXG5cclxuXHRcdFx0XHR2YXIgZmllbGRfZm9ybWF0ID0gd051bWIoe1xyXG5cdFx0XHRcdFx0bWFyazogZGVjaW1hbF9zZXBlcmF0b3IsXHJcblx0XHRcdFx0XHRkZWNpbWFsczogcGFyc2VGbG9hdChkZWNpbWFsX3BsYWNlcyksXHJcblx0XHRcdFx0XHR0aG91c2FuZDogdGhvdXNhbmRfc2VwZXJhdG9yXHJcblx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0dmFyIHZhbHVlcyA9IFtdO1xyXG5cclxuXHJcblx0XHRcdFx0dmFyIHNsaWRlcl9vYmplY3QgPSAkY29udGFpbmVyLmZpbmQoXCIubWV0YS1zbGlkZXJcIilbMF07XHJcblx0XHRcdFx0Ly92YWwgZnJvbSBzbGlkZXIgb2JqZWN0XHJcblx0XHRcdFx0dmFyIHNsaWRlcl92YWwgPSBzbGlkZXJfb2JqZWN0Lm5vVWlTbGlkZXIuZ2V0KCk7XHJcblxyXG5cdFx0XHRcdHZhbHVlcy5wdXNoKGZpZWxkX2Zvcm1hdC5mcm9tKHNsaWRlcl92YWxbMF0pKTtcclxuXHRcdFx0XHR2YWx1ZXMucHVzaChmaWVsZF9mb3JtYXQuZnJvbShzbGlkZXJfdmFsWzFdKSk7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGRWYWwgPSB2YWx1ZXMuam9pbihcIitcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJG1ldGFfcmFuZ2UuYXR0cihcImRhdGEtc2YtZmllbGQtbmFtZVwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1yYWRpb1wiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLWlucHV0LXJhbmdlLXJhZGlvXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg9PTApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0Ly90aGVuIHRyeSBhZ2Fpbiwgd2UgbXVzdCBiZSB1c2luZyBhIHNpbmdsZSBmaWVsZFxyXG5cdFx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwiPiB1bFwiKTtcclxuXHRcdFx0XHR9XHJcblxyXG5cdFx0XHRcdHZhciAkbWV0YV9yYW5nZSA9ICRjb250YWluZXIuZmluZChcIi5zZi1tZXRhLXJhbmdlXCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdC8vdGhlcmUgaXMgYW4gZWxlbWVudCB3aXRoIGEgZnJvbS90byBjbGFzcyAtIHNvIHdlIG5lZWQgdG8gZ2V0IHRoZSB2YWx1ZXMgb2YgdGhlIGZyb20gJiB0byBpbnB1dCBmaWVsZHMgc2VwZXJhdGVseVxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHRcclxuXHRcdFx0XHRcdHZhciBmaWVsZF92YWxzID0gW107XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0XHR2YXIgJHJhZGlvcyA9ICQodGhpcykuZmluZChcIi5zZi1pbnB1dC1yYWRpb1wiKTtcclxuXHRcdFx0XHRcdFx0ZmllbGRfdmFscy5wdXNoKHNlbGYuZ2V0TWV0YVJhZGlvVmFsKCRyYWRpb3MpKTtcclxuXHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0XHR9KTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0Ly9wcmV2ZW50IHNlY29uZCBudW1iZXIgZnJvbSBiZWluZyBsb3dlciB0aGFuIHRoZSBmaXJzdFxyXG5cdFx0XHRcdFx0aWYoZmllbGRfdmFscy5sZW5ndGg9PTIpXHJcblx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdGlmKE51bWJlcihmaWVsZF92YWxzWzFdKTxOdW1iZXIoZmllbGRfdmFsc1swXSkpXHJcblx0XHRcdFx0XHRcdHtcclxuXHRcdFx0XHRcdFx0XHRmaWVsZF92YWxzWzFdID0gZmllbGRfdmFsc1swXTtcclxuXHRcdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkX3ZhbHMuam9pbihcIitcIik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD09MSlcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuZmluZChcIi5zZi1pbnB1dC1yYWRpb1wiKS5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRtZXRhX3JhbmdlLmF0dHIoXCJkYXRhLXNmLWZpZWxkLW5hbWVcIik7XHJcblx0XHRcdFx0fVxyXG5cclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1zZWxlY3RcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcIi5zZi1pbnB1dC1zZWxlY3RcIik7XHJcblx0XHRcdFx0dmFyICRtZXRhX3JhbmdlID0gJGNvbnRhaW5lci5maW5kKFwiLnNmLW1ldGEtcmFuZ2VcIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0Ly90aGVyZSBpcyBhbiBlbGVtZW50IHdpdGggYSBmcm9tL3RvIGNsYXNzIC0gc28gd2UgbmVlZCB0byBnZXQgdGhlIHZhbHVlcyBvZiB0aGUgZnJvbSAmIHRvIGlucHV0IGZpZWxkcyBzZXBlcmF0ZWx5XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdHZhciBmaWVsZF92YWxzID0gW107XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdCRmaWVsZC5lYWNoKGZ1bmN0aW9uKCl7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0XHR2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG5cdFx0XHRcdFx0XHRmaWVsZF92YWxzLnB1c2goc2VsZi5nZXRNZXRhU2VsZWN0VmFsKCR0aGlzKSk7XHJcblx0XHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0fSk7XHJcblx0XHRcdFx0XHRcclxuXHRcdFx0XHRcdC8vcHJldmVudCBzZWNvbmQgbnVtYmVyIGZyb20gYmVpbmcgbG93ZXIgdGhhbiB0aGUgZmlyc3RcclxuXHRcdFx0XHRcdGlmKGZpZWxkX3ZhbHMubGVuZ3RoPT0yKVxyXG5cdFx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0XHRpZihOdW1iZXIoZmllbGRfdmFsc1sxXSk8TnVtYmVyKGZpZWxkX3ZhbHNbMF0pKVxyXG5cdFx0XHRcdFx0XHR7XHJcblx0XHRcdFx0XHRcdFx0ZmllbGRfdmFsc1sxXSA9IGZpZWxkX3ZhbHNbMF07XHJcblx0XHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdH1cclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0XHJcblx0XHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkX3ZhbHMuam9pbihcIitcIik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdFx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD09MSlcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHRcdGVsc2VcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHRmaWVsZE5hbWUgPSAkbWV0YV9yYW5nZS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJyYW5nZS1jaGVja2JveFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpjaGVja2JveFwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRpZigkZmllbGQubGVuZ3RoPjApXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldENoZWNrYm94VmFsKCRmaWVsZCwgXCJhbmRcIik7XHJcblx0XHRcdFx0fVxyXG5cdFx0XHR9XHJcblx0XHRcdFxyXG5cdFx0XHRpZihmaWVsZE5hbWU9PVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHRcdGVsc2UgaWYobWV0YVR5cGU9PVwiY2hvaWNlXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGlucHV0VHlwZT09XCJzZWxlY3RcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInNlbGVjdFwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YVNlbGVjdFZhbCgkZmllbGQpOyBcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRlbHNlIGlmKGlucHV0VHlwZT09XCJtdWx0aXNlbGVjdFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRcdHZhciBvcGVyYXRvciA9ICRmaWVsZC5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0TWV0YU11bHRpU2VsZWN0VmFsKCRmaWVsZCwgb3BlcmF0b3IpO1xyXG5cdFx0XHR9XHJcblx0XHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cImNoZWNrYm94XCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkZmllbGQgPSAkY29udGFpbmVyLmZpbmQoXCJ1bCA+IGxpIGlucHV0OmNoZWNrYm94XCIpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0XHR7XHJcblx0XHRcdFx0XHR2YXIgb3BlcmF0b3IgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcdFx0ZmllbGRWYWwgPSBzZWxmLmdldE1ldGFDaGVja2JveFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFkaW9cIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6cmFkaW9cIik7XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNZXRhUmFkaW9WYWwoJGZpZWxkKTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdH1cclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkVmFsKTtcclxuXHRcdFx0aWYodHlwZW9mKCRmaWVsZCkhPT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHRcdFxyXG5cdFx0XHRcdFx0Ly9mb3IgdGhvc2Ugd2hvIGluc2lzdCBvbiB1c2luZyAmIGFtcGVyc2FuZHMgaW4gdGhlIG5hbWUgb2YgdGhlIGN1c3RvbSBmaWVsZCAoISlcclxuXHRcdFx0XHRcdGZpZWxkTmFtZSA9IChmaWVsZE5hbWUpO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0XHRcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYobWV0YVR5cGU9PVwiZGF0ZVwiKVxyXG5cdFx0e1xyXG5cdFx0XHRzZWxmLnByb2Nlc3NQb3N0RGF0ZSgkY29udGFpbmVyKTtcclxuXHRcdH1cclxuXHRcdFxyXG5cdFx0aWYodHlwZW9mKGZpZWxkVmFsKSE9XCJ1bmRlZmluZWRcIilcclxuXHRcdHtcclxuXHRcdFx0aWYoZmllbGRWYWwhPVwiXCIpXHJcblx0XHRcdHtcclxuXHRcdFx0XHQvL3NlbGYudXJsX2NvbXBvbmVudHMgKz0gXCImXCIrZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkTmFtZSkrXCI9XCIrKGZpZWxkVmFsKTtcclxuXHRcdFx0XHRzZWxmLnVybF9wYXJhbXNbZW5jb2RlVVJJQ29tcG9uZW50KGZpZWxkTmFtZSldID0gKGZpZWxkVmFsKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdH0sXHJcblx0cHJvY2Vzc1Bvc3REYXRlOiBmdW5jdGlvbigkY29udGFpbmVyKVxyXG5cdHtcclxuXHRcdHZhciBzZWxmID0gdGhpcztcclxuXHRcdFxyXG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHRcdHZhciBpbnB1dFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XHJcblx0XHRcclxuXHRcdHZhciAkZmllbGQ7XHJcblx0XHR2YXIgZmllbGROYW1lID0gXCJcIjtcclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHRcclxuXHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6dGV4dFwiKTtcclxuXHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFxyXG5cdFx0dmFyIGRhdGVzID0gW107XHJcblx0XHQkZmllbGQuZWFjaChmdW5jdGlvbigpe1xyXG5cdFx0XHRcclxuXHRcdFx0ZGF0ZXMucHVzaCgkKHRoaXMpLnZhbCgpKTtcclxuXHRcdFxyXG5cdFx0fSk7XHJcblx0XHRcclxuXHRcdGlmKCRmaWVsZC5sZW5ndGg9PTIpXHJcblx0XHR7XHJcblx0XHRcdGlmKChkYXRlc1swXSE9XCJcIil8fChkYXRlc1sxXSE9XCJcIikpXHJcblx0XHRcdHtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IGRhdGVzLmpvaW4oXCIrXCIpO1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gZmllbGRWYWwucmVwbGFjZSgvXFwvL2csJycpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRlbHNlIGlmKCRmaWVsZC5sZW5ndGg9PTEpXHJcblx0XHR7XHJcblx0XHRcdGlmKGRhdGVzWzBdIT1cIlwiKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGRWYWwgPSBkYXRlcy5qb2luKFwiK1wiKTtcclxuXHRcdFx0XHRmaWVsZFZhbCA9IGZpZWxkVmFsLnJlcGxhY2UoL1xcLy9nLCcnKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0XHRpZih0eXBlb2YoZmllbGRWYWwpIT1cInVuZGVmaW5lZFwiKVxyXG5cdFx0e1xyXG5cdFx0XHRpZihmaWVsZFZhbCE9XCJcIilcclxuXHRcdFx0e1xyXG5cdFx0XHRcdHZhciBmaWVsZFNsdWcgPSBcIlwiO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGlmKGZpZWxkTmFtZT09XCJfc2ZfcG9zdF9kYXRlXCIpXHJcblx0XHRcdFx0e1xyXG5cdFx0XHRcdFx0ZmllbGRTbHVnID0gXCJwb3N0X2RhdGVcIjtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0ZWxzZVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdGZpZWxkU2x1ZyA9IGZpZWxkTmFtZTtcclxuXHRcdFx0XHR9XHJcblx0XHRcdFx0XHJcblx0XHRcdFx0aWYoZmllbGRTbHVnIT1cIlwiKVxyXG5cdFx0XHRcdHtcclxuXHRcdFx0XHRcdC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZFNsdWcrXCI9XCIrZmllbGRWYWw7XHJcblx0XHRcdFx0XHRzZWxmLnVybF9wYXJhbXNbZmllbGRTbHVnXSA9IGZpZWxkVmFsO1xyXG5cdFx0XHRcdH1cclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0XHJcblx0fSxcclxuXHRwcm9jZXNzVGF4b25vbXk6IGZ1bmN0aW9uKCRjb250YWluZXIsIHJldHVybl9vYmplY3QpXHJcblx0e1xyXG4gICAgICAgIGlmKHR5cGVvZihyZXR1cm5fb2JqZWN0KT09XCJ1bmRlZmluZWRcIilcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHJldHVybl9vYmplY3QgPSBmYWxzZTtcclxuICAgICAgICB9XHJcblxyXG5cdFx0Ly9pZigpXHRcdFx0XHRcdFxyXG5cdFx0Ly92YXIgZmllbGROYW1lID0gJCh0aGlzKS5hdHRyKFwiZGF0YS1zZi1maWVsZC1uYW1lXCIpO1xyXG5cdFx0dmFyIHNlbGYgPSB0aGlzO1xyXG5cdFxyXG5cdFx0dmFyIGZpZWxkVHlwZSA9ICRjb250YWluZXIuYXR0cihcImRhdGEtc2YtZmllbGQtdHlwZVwiKTtcclxuXHRcdHZhciBpbnB1dFR5cGUgPSAkY29udGFpbmVyLmF0dHIoXCJkYXRhLXNmLWZpZWxkLWlucHV0LXR5cGVcIik7XHJcblx0XHRcclxuXHRcdHZhciAkZmllbGQ7XHJcblx0XHR2YXIgZmllbGROYW1lID0gXCJcIjtcclxuXHRcdHZhciBmaWVsZFZhbCA9IFwiXCI7XHJcblx0XHRcclxuXHRcdGlmKGlucHV0VHlwZT09XCJzZWxlY3RcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdFxyXG5cdFx0XHRmaWVsZFZhbCA9IHNlbGYuZ2V0U2VsZWN0VmFsKCRmaWVsZCk7IFxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwibXVsdGlzZWxlY3RcIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwic2VsZWN0XCIpO1xyXG5cdFx0XHRmaWVsZE5hbWUgPSAkZmllbGQuYXR0cihcIm5hbWVcIikucmVwbGFjZSgnW10nLCAnJyk7XHJcblx0XHRcdHZhciBvcGVyYXRvciA9ICRmaWVsZC5hdHRyKFwiZGF0YS1vcGVyYXRvclwiKTtcclxuXHRcdFx0XHJcblx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRNdWx0aVNlbGVjdFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcclxuXHRcdH1cclxuXHRcdGVsc2UgaWYoaW5wdXRUeXBlPT1cImNoZWNrYm94XCIpXHJcblx0XHR7XHJcblx0XHRcdCRmaWVsZCA9ICRjb250YWluZXIuZmluZChcInVsID4gbGkgaW5wdXQ6Y2hlY2tib3hcIik7XHJcblx0XHRcdGlmKCRmaWVsZC5sZW5ndGg+MClcclxuXHRcdFx0e1xyXG5cdFx0XHRcdGZpZWxkTmFtZSA9ICRmaWVsZC5hdHRyKFwibmFtZVwiKS5yZXBsYWNlKCdbXScsICcnKTtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcclxuXHRcdFx0XHR2YXIgb3BlcmF0b3IgPSAkY29udGFpbmVyLmZpbmQoXCI+IHVsXCIpLmF0dHIoXCJkYXRhLW9wZXJhdG9yXCIpO1xyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRDaGVja2JveFZhbCgkZmllbGQsIG9wZXJhdG9yKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG5cdFx0ZWxzZSBpZihpbnB1dFR5cGU9PVwicmFkaW9cIilcclxuXHRcdHtcclxuXHRcdFx0JGZpZWxkID0gJGNvbnRhaW5lci5maW5kKFwidWwgPiBsaSBpbnB1dDpyYWRpb1wiKTtcclxuXHRcdFx0aWYoJGZpZWxkLmxlbmd0aD4wKVxyXG5cdFx0XHR7XHJcblx0XHRcdFx0ZmllbGROYW1lID0gJGZpZWxkLmF0dHIoXCJuYW1lXCIpLnJlcGxhY2UoJ1tdJywgJycpO1xyXG5cdFx0XHRcdFxyXG5cdFx0XHRcdGZpZWxkVmFsID0gc2VsZi5nZXRSYWRpb1ZhbCgkZmllbGQpO1xyXG5cdFx0XHR9XHJcblx0XHR9XHJcblx0XHRcclxuXHRcdGlmKHR5cGVvZihmaWVsZFZhbCkhPVwidW5kZWZpbmVkXCIpXHJcblx0XHR7XHJcblx0XHRcdGlmKGZpZWxkVmFsIT1cIlwiKVxyXG5cdFx0XHR7XHJcbiAgICAgICAgICAgICAgICBpZihyZXR1cm5fb2JqZWN0PT10cnVlKVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB7bmFtZTogZmllbGROYW1lLCB2YWx1ZTogZmllbGRWYWx9O1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgIC8vc2VsZi51cmxfY29tcG9uZW50cyArPSBcIiZcIitmaWVsZE5hbWUrXCI9XCIrZmllbGRWYWw7XHJcbiAgICAgICAgICAgICAgICAgICAgc2VsZi51cmxfcGFyYW1zW2ZpZWxkTmFtZV0gPSBmaWVsZFZhbDtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcblx0XHRcdH1cclxuXHRcdH1cclxuXHJcbiAgICAgICAgaWYocmV0dXJuX29iamVjdD09dHJ1ZSlcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgICAgICB9XHJcblx0fVxyXG59O1xufSkuY2FsbCh0aGlzLHR5cGVvZiBnbG9iYWwgIT09IFwidW5kZWZpbmVkXCIgPyBnbG9iYWwgOiB0eXBlb2Ygc2VsZiAhPT0gXCJ1bmRlZmluZWRcIiA/IHNlbGYgOiB0eXBlb2Ygd2luZG93ICE9PSBcInVuZGVmaW5lZFwiID8gd2luZG93IDoge30pXG4vLyMgc291cmNlTWFwcGluZ1VSTD1kYXRhOmFwcGxpY2F0aW9uL2pzb247Y2hhcnNldDp1dGYtODtiYXNlNjQsZXlKMlpYSnphVzl1SWpvekxDSnpiM1Z5WTJWeklqcGJJbk55WXk5d2RXSnNhV012WVhOelpYUnpMMnB6TDJsdVkyeDFaR1Z6TDNCeWIyTmxjM05mWm05eWJTNXFjeUpkTENKdVlXMWxjeUk2VzEwc0ltMWhjSEJwYm1keklqb2lPMEZCUVVFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CTzBGQlEwRTdRVUZEUVR0QlFVTkJPMEZCUTBFN1FVRkRRVHRCUVVOQk8wRkJRMEU3UVVGRFFUdEJRVU5CSWl3aVptbHNaU0k2SW1kbGJtVnlZWFJsWkM1cWN5SXNJbk52ZFhKalpWSnZiM1FpT2lJaUxDSnpiM1Z5WTJWelEyOXVkR1Z1ZENJNld5SmNjbHh1ZG1GeUlDUWdQU0FvZEhsd1pXOW1JSGRwYm1SdmR5QWhQVDBnWENKMWJtUmxabWx1WldSY0lpQS9JSGRwYm1SdmQxc25hbEYxWlhKNUoxMGdPaUIwZVhCbGIyWWdaMnh2WW1Gc0lDRTlQU0JjSW5WdVpHVm1hVzVsWkZ3aUlEOGdaMnh2WW1Gc1d5ZHFVWFZsY25rblhTQTZJRzUxYkd3cE8xeHlYRzVjY2x4dWJXOWtkV3hsTG1WNGNHOXlkSE1nUFNCN1hISmNibHh5WEc1Y2RIUmhlRzl1YjIxNVgyRnlZMmhwZG1Wek9pQXdMRnh5WEc0Z0lDQWdkWEpzWDNCaGNtRnRjem9nZTMwc1hISmNiaUFnSUNCMFlYaGZZWEpqYUdsMlpWOXlaWE4xYkhSelgzVnliRG9nWENKY0lpeGNjbHh1SUNBZ0lHRmpkR2wyWlY5MFlYZzZJRndpWENJc1hISmNiaUFnSUNCbWFXVnNaSE02SUh0OUxGeHlYRzVjZEdsdWFYUTZJR1oxYm1OMGFXOXVLSFJoZUc5dWIyMTVYMkZ5WTJocGRtVnpMQ0JqZFhKeVpXNTBYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVXBlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5SaGVHOXViMjE1WDJGeVkyaHBkbVZ6SUQwZ01EdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuVnliRjl3WVhKaGJYTWdQU0I3ZlR0Y2NseHVJQ0FnSUNBZ0lDQjBhR2x6TG5SaGVGOWhjbU5vYVhabFgzSmxjM1ZzZEhOZmRYSnNJRDBnWENKY0lqdGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxtRmpkR2wyWlY5MFlYZ2dQU0JjSWx3aU8xeHlYRzVjY2x4dVhIUmNkQzh2ZEdocGN5NGtabWxsYkdSeklEMGdKR1pwWld4a2N6dGNjbHh1SUNBZ0lDQWdJQ0IwYUdsekxuUmhlRzl1YjIxNVgyRnlZMmhwZG1WeklEMGdkR0Y0YjI1dmJYbGZZWEpqYUdsMlpYTTdYSEpjYmlBZ0lDQWdJQ0FnZEdocGN5NWpkWEp5Wlc1MFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1VZ1BTQmpkWEp5Wlc1MFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1VN1hISmNibHh5WEc1Y2RGeDBkR2hwY3k1amJHVmhjbFZ5YkVOdmJYQnZibVZ1ZEhNb0tUdGNjbHh1WEhKY2JseDBmU3hjY2x4dUlDQWdJSE5sZEZSaGVFRnlZMmhwZG1WU1pYTjFiSFJ6VlhKc09pQm1kVzVqZEdsdmJpZ2tabTl5YlN3Z1kzVnljbVZ1ZEY5eVpYTjFiSFJ6WDNWeWJDd2daMlYwWDJGamRHbDJaU2tnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0IyWVhJZ2MyVnNaaUE5SUhSb2FYTTdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDOHZkbUZ5SUdOMWNuSmxiblJmY21WemRXeDBjMTkxY213Z1BTQmNJbHdpTzF4eVhHNGdJQ0FnSUNBZ0lHbG1LSFJvYVhNdWRHRjRiMjV2YlhsZllYSmphR2wyWlhNaFBURXBYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0J5WlhSMWNtNDdYSEpjYmlBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmloMGVYQmxiMllvWjJWMFgyRmpkR2wyWlNrOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEhaaGNpQm5aWFJmWVdOMGFYWmxJRDBnWm1Gc2MyVTdYSEpjYmx4MFhIUjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDOHZZMmhsWTJzZ2RHOGdjMlZsSUdsbUlIZGxJR2hoZG1VZ1lXNTVJSFJoZUc5dWIyMXBaWE1nYzJWc1pXTjBaV1JjY2x4dUlDQWdJQ0FnSUNBdkwybG1JSE52TENCamFHVmpheUIwYUdWcGNpQnlaWGR5YVhSbGN5QmhibVFnZFhObElIUm9iM05sSUdGeklIUm9aU0J5WlhOMWJIUnpJSFZ5YkZ4eVhHNGdJQ0FnSUNBZ0lIWmhjaUFrWm1sbGJHUWdQU0JtWVd4elpUdGNjbHh1SUNBZ0lDQWdJQ0IyWVhJZ1ptbGxiR1JmYm1GdFpTQTlJRndpWENJN1hISmNiaUFnSUNBZ0lDQWdkbUZ5SUdacFpXeGtYM1poYkhWbElEMGdYQ0pjSWp0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnZG1GeUlDUmhZM1JwZG1WZmRHRjRiMjV2YlhrZ1BTQWtabTl5YlM0a1ptbGxiR1J6TG5CaGNtVnVkQ2dwTG1acGJtUW9YQ0piWkdGMFlTMXpaaTEwWVhodmJtOXRlUzFoY21Ob2FYWmxQU2N4SjExY0lpazdYSEpjYmlBZ0lDQWdJQ0FnYVdZb0pHRmpkR2wyWlY5MFlYaHZibTl0ZVM1c1pXNW5kR2c5UFRFcFhISmNiaUFnSUNBZ0lDQWdlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWtabWxsYkdRZ1BTQWtZV04wYVhabFgzUmhlRzl1YjIxNU8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdacFpXeGtWSGx3WlNBOUlDUm1hV1ZzWkM1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMTBlWEJsWENJcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdhV1lnS0NobWFXVnNaRlI1Y0dVZ1BUMGdYQ0owWVdkY0lpa2dmSHdnS0dacFpXeGtWSGx3WlNBOVBTQmNJbU5oZEdWbmIzSjVYQ0lwSUh4OElDaG1hV1ZzWkZSNWNHVWdQVDBnWENKMFlYaHZibTl0ZVZ3aUtTa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUmhlRzl1YjIxNVgzWmhiSFZsSUQwZ2MyVnNaaTV3Y205alpYTnpWR0Y0YjI1dmJYa29KR1pwWld4a0xDQjBjblZsS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnBaV3hrWDI1aGJXVWdQU0FrWm1sbGJHUXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0Ym1GdFpWd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQjBZWGh2Ym05dGVWOXVZVzFsSUQwZ1ptbGxiR1JmYm1GdFpTNXlaWEJzWVdObEtGd2lYM05tZEY5Y0lpd2dYQ0pjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYVdZZ0tIUmhlRzl1YjIxNVgzWmhiSFZsS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWm1sbGJHUmZkbUZzZFdVZ1BTQjBZWGh2Ym05dGVWOTJZV3gxWlM1MllXeDFaVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9abWxsYkdSZmRtRnNkV1U5UFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1JtYVdWc1pDQTlJR1poYkhObE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWdvYzJWc1ppNWpkWEp5Wlc1MFgzUmhlRzl1YjIxNVgyRnlZMmhwZG1VaFBWd2lYQ0lwSmlZb2MyVnNaaTVqZFhKeVpXNTBYM1JoZUc5dWIyMTVYMkZ5WTJocGRtVWhQWFJoZUc5dWIyMTVYMjVoYldVcEtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUhSb2FYTXVkR0Y0WDJGeVkyaHBkbVZmY21WemRXeDBjMTkxY213Z1BTQmpkWEp5Wlc1MFgzSmxjM1ZzZEhOZmRYSnNPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQnlaWFIxY200N1hISmNiaUFnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQnBaaWdvS0dacFpXeGtYM1poYkhWbFBUMWNJbHdpS1h4OEtDRWtabWxsYkdRcElDa3BYSEpjYmlBZ0lDQWdJQ0FnZTF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FrWm05eWJTNGtabWxsYkdSekxtVmhZMmdvWm5WdVkzUnBiMjRnS0NrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDZ2hKR1pwWld4a0tTQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWFXVnNaRlI1Y0dVZ1BTQWtLSFJvYVhNcExtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMWFI1Y0dWY0lpazdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNnb1ptbGxiR1JVZVhCbElEMDlJRndpZEdGblhDSXBJSHg4SUNobWFXVnNaRlI1Y0dVZ1BUMGdYQ0pqWVhSbFoyOXllVndpS1NCOGZDQW9abWxsYkdSVWVYQmxJRDA5SUZ3aWRHRjRiMjV2YlhsY0lpa3BJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlIUmhlRzl1YjIxNVgzWmhiSFZsSUQwZ2MyVnNaaTV3Y205alpYTnpWR0Y0YjI1dmJYa29KQ2gwYUdsektTd2dkSEoxWlNrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHWnBaV3hrWDI1aGJXVWdQU0FrS0hSb2FYTXBMbUYwZEhJb1hDSmtZWFJoTFhObUxXWnBaV3hrTFc1aGJXVmNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFvZEdGNGIyNXZiWGxmZG1Gc2RXVXBJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JtYVdWc1pGOTJZV3gxWlNBOUlIUmhlRzl1YjIxNVgzWmhiSFZsTG5aaGJIVmxPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtSUNobWFXVnNaRjkyWVd4MVpTQWhQU0JjSWx3aUtTQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNSbWFXVnNaQ0E5SUNRb2RHaHBjeWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZlZ4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNCOUtUdGNjbHh1SUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJR2xtS0NBb0pHWnBaV3hrS1NBbUppQW9abWxsYkdSZmRtRnNkV1VnSVQwZ1hDSmNJaUFwS1NCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUM4dmFXWWdkMlVnWm05MWJtUWdZU0JtYVdWc1pGeHlYRzVjZEZ4MFhIUjJZWElnY21WM2NtbDBaVjloZEhSeUlEMGdLQ1JtYVdWc1pDNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxMFpYSnRMWEpsZDNKcGRHVmNJaWtwTzF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2FXWW9jbVYzY21sMFpWOWhkSFJ5SVQxY0lsd2lLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhKbGQzSnBkR1VnUFNCS1UwOU9MbkJoY25ObEtISmxkM0pwZEdWZllYUjBjaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMllYSWdhVzV3ZFhSZmRIbHdaU0E5SUNSbWFXVnNaQzVoZEhSeUtGd2laR0YwWVMxelppMW1hV1ZzWkMxcGJuQjFkQzEwZVhCbFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnYzJWc1ppNWhZM1JwZG1WZmRHRjRJRDBnWm1sbGJHUmZibUZ0WlR0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDJacGJtUWdkR2hsSUdGamRHbDJaU0JsYkdWdFpXNTBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JwWmlBb0tHbHVjSFYwWDNSNWNHVWdQVDBnWENKeVlXUnBiMXdpS1NCOGZDQW9hVzV3ZFhSZmRIbHdaU0E5UFNCY0ltTm9aV05yWW05NFhDSXBLU0I3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dmRtRnlJQ1JoWTNScGRtVWdQU0FrWm1sbGJHUXVabWx1WkNoY0lpNXpaaTF2Y0hScGIyNHRZV04wYVhabFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZaWGh3Ykc5a1pTQjBhR1VnZG1Gc2RXVnpJR2xtSUhSb1pYSmxJR2x6SUdFZ1pHVnNhVzFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMlpwWld4a1gzWmhiSFZsWEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQnBjMTl6YVc1bmJHVmZkbUZzZFdVZ1BTQjBjblZsTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWFXVnNaRjkyWVd4MVpYTWdQU0JtYVdWc1pGOTJZV3gxWlM1emNHeHBkQ2hjSWl4Y0lpa3VhbTlwYmloY0lpdGNJaWt1YzNCc2FYUW9YQ0lyWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaG1hV1ZzWkY5MllXeDFaWE11YkdWdVozUm9JRDRnTVNrZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQnBjMTl6YVc1bmJHVmZkbUZzZFdVZ1BTQm1ZV3h6WlR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUlDaHBjMTl6YVc1bmJHVmZkbUZzZFdVcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQWthVzV3ZFhRZ1BTQWtabWxsYkdRdVptbHVaQ2hjSW1sdWNIVjBXM1poYkhWbFBTZGNJaUFySUdacFpXeGtYM1poYkhWbElDc2dYQ0luWFZ3aUtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSaFkzUnBkbVVnUFNBa2FXNXdkWFF1Y0dGeVpXNTBLQ2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUhaaGNpQmtaWEIwYUNBOUlDUmhZM1JwZG1VdVlYUjBjaWhjSW1SaGRHRXRjMll0WkdWd2RHaGNJaWs3WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMjV2ZHlCc2IyOXdJSFJvY205MVoyZ2djR0Z5Wlc1MGN5QjBieUJuY21GaUlIUm9aV2x5SUc1aGJXVnpYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCMllXeDFaWE1nUFNCdVpYY2dRWEp5WVhrb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZzZFdWekxuQjFjMmdvWm1sbGJHUmZkbUZzZFdVcE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnWm05eUlDaDJZWElnYVNBOUlHUmxjSFJvT3lCcElENGdNRHNnYVMwdEtTQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBa1lXTjBhWFpsSUQwZ0pHRmpkR2wyWlM1d1lYSmxiblFvS1M1d1lYSmxiblFvS1R0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoYkhWbGN5NXdkWE5vS0NSaFkzUnBkbVV1Wm1sdVpDaGNJbWx1Y0hWMFhDSXBMblpoYkNncEtUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdmVnh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnNkV1Z6TG5KbGRtVnljMlVvS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQzh2WjNKaFlpQjBhR1VnY21WM2NtbDBaU0JtYjNJZ2RHaHBjeUJrWlhCMGFGeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZWElnWVdOMGFYWmxYM0psZDNKcGRHVWdQU0J5WlhkeWFYUmxXMlJsY0hSb1hUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUhWeWJDQTlJR0ZqZEdsMlpWOXlaWGR5YVhSbE8xeHlYRzVjY2x4dVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDOHZkR2hsYmlCdFlYQWdabkp2YlNCMGFHVWdjR0Z5Wlc1MGN5QjBieUIwYUdVZ1pHVndkR2hjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSkNoMllXeDFaWE1wTG1WaFkyZ29ablZ1WTNScGIyNGdLR2x1WkdWNExDQjJZV3gxWlNrZ2UxeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIVnliQ0E5SUhWeWJDNXlaWEJzWVdObEtGd2lXMXdpSUNzZ2FXNWtaWGdnS3lCY0lsMWNJaXdnZG1Gc2RXVXBPMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZTazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFJvYVhNdWRHRjRYMkZ5WTJocGRtVmZjbVZ6ZFd4MGMxOTFjbXdnUFNCMWNtdzdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdWc2MyVWdlMXh5WEc1Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0x5OXBaaUIwYUdWeVpTQmhjbVVnYlhWc2RHbHdiR1VnZG1Gc2RXVnpMRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2TDNSb1pXNGdkMlVnYm1WbFpDQjBieUJqYUdWamF5Qm1iM0lnTXlCMGFHbHVaM002WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMmxtSUhSb1pTQjJZV3gxWlhNZ2MyVnNaV04wWldRZ1lYSmxJR0ZzYkNCcGJpQjBhR1VnYzJGdFpTQjBjbVZsSUhSb1pXNGdkMlVnWTJGdUlHUnZJSE52YldVZ1kyeGxkbVZ5SUhKbGQzSnBkR1VnYzNSMVptWmNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdMeTl0WlhKblpTQmhiR3dnZG1Gc2RXVnpJR2x1SUhOaGJXVWdiR1YyWld3c0lIUm9aVzRnWTI5dFltbHVaU0IwYUdVZ2JHVjJaV3h6WEhKY2JseHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQXZMMmxtSUhSb1pYa2dZWEpsSUdaeWIyMGdaR2xtWm1WeVpXNTBJSFJ5WldWeklIUm9aVzRnYW5WemRDQmpiMjFpYVc1bElIUm9aVzBnYjNJZ2FuVnpkQ0IxYzJVZ1lHWnBaV3hrWDNaaGJIVmxZRnh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0F2S2x4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCa1pYQjBhSE1nUFNCdVpYY2dRWEp5WVhrb0tUdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1FvWm1sbGJHUmZkbUZzZFdWektTNWxZV05vS0daMWJtTjBhVzl1SUNocGJtUmxlQ3dnZG1Gc0tTQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJQ1JwYm5CMWRDQTlJQ1JtYVdWc1pDNW1hVzVrS0Z3aWFXNXdkWFJiZG1Gc2RXVTlKMXdpSUNzZ1ptbGxiR1JmZG1Gc2RXVWdLeUJjSWlkZFhDSXBPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlDUmhZM1JwZG1VZ1BTQWthVzV3ZFhRdWNHRnlaVzUwS0NrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1GeUlHUmxjSFJvSUQwZ0pHRmpkR2wyWlM1aGRIUnlLRndpWkdGMFlTMXpaaTFrWlhCMGFGd2lLVHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUM4dlpHVndkR2h6TG5CMWMyZ29aR1Z3ZEdncE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE95b3ZYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlVnYVdZZ0tDaHBibkIxZEY5MGVYQmxJRDA5SUZ3aWMyVnNaV04wWENJcElIeDhJQ2hwYm5CMWRGOTBlWEJsSUQwOUlGd2liWFZzZEdselpXeGxZM1JjSWlrcElIdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUdselgzTnBibWRzWlY5MllXeDFaU0E5SUhSeWRXVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2RtRnlJR1pwWld4a1gzWmhiSFZsY3lBOUlHWnBaV3hrWDNaaGJIVmxMbk53YkdsMEtGd2lMRndpS1M1cWIybHVLRndpSzF3aUtTNXpjR3hwZENoY0lpdGNJaWs3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0dacFpXeGtYM1poYkhWbGN5NXNaVzVuZEdnZ1BpQXhLU0I3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdselgzTnBibWRzWlY5MllXeDFaU0E5SUdaaGJITmxPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIMWNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdhV1lnS0dselgzTnBibWRzWlY5MllXeDFaU2tnZTF4eVhHNWNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdkbUZ5SUNSaFkzUnBkbVVnUFNBa1ptbGxiR1F1Wm1sdVpDaGNJbTl3ZEdsdmJsdDJZV3gxWlQwblhDSWdLeUJtYVdWc1pGOTJZV3gxWlNBcklGd2lKMTFjSWlrN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lIWmhjaUJrWlhCMGFDQTlJQ1JoWTNScGRtVXVZWFIwY2loY0ltUmhkR0V0YzJZdFpHVndkR2hjSWlrN1hISmNibHh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RtRnNkV1Z6SUQwZ2JtVjNJRUZ5Y21GNUtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoYkhWbGN5NXdkWE5vS0dacFpXeGtYM1poYkhWbEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdadmNpQW9kbUZ5SUdrZ1BTQmtaWEIwYURzZ2FTQStJREE3SUdrdExTa2dlMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0pHRmpkR2wyWlNBOUlDUmhZM1JwZG1VdWNISmxka0ZzYkNoY0ltOXdkR2x2Ymx0a1lYUmhMWE5tTFdSbGNIUm9QU2RjSWlBcklDaHBJQzBnTVNrZ0t5QmNJaWRkWENJcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnZG1Gc2RXVnpMbkIxYzJnb0pHRmpkR2wyWlM1MllXd29LU2s3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoYkhWbGN5NXlaWFpsY25ObEtDazdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCaFkzUnBkbVZmY21WM2NtbDBaU0E5SUhKbGQzSnBkR1ZiWkdWd2RHaGRPMXh5WEc0Z0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVhJZ2RYSnNJRDBnWVdOMGFYWmxYM0psZDNKcGRHVTdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ1FvZG1Gc2RXVnpLUzVsWVdOb0tHWjFibU4wYVc5dUlDaHBibVJsZUN3Z2RtRnNkV1VwSUh0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCMWNtd2dQU0IxY213dWNtVndiR0ZqWlNoY0lsdGNJaUFySUdsdVpHVjRJQ3NnWENKZFhDSXNJSFpoYkhWbEtUdGNjbHh1WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgwcE8xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjBhR2x6TG5SaGVGOWhjbU5vYVhabFgzSmxjM1ZzZEhOZmRYSnNJRDBnZFhKc08xeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUgxY2NseHVYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0I5WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdmVnh5WEc0Z0lDQWdJQ0FnSUM4dmRHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJDQTlJR04xY25KbGJuUmZjbVZ6ZFd4MGMxOTFjbXc3WEhKY2JpQWdJQ0I5TEZ4eVhHNGdJQ0FnWjJWMFVtVnpkV3gwYzFWeWJEb2dablZ1WTNScGIyNG9KR1p2Y20wc0lHTjFjbkpsYm5SZmNtVnpkV3gwYzE5MWNtd3BJSHRjY2x4dVhISmNiaUFnSUNBZ0lDQWdMeTkwYUdsekxuTmxkRlJoZUVGeVkyaHBkbVZTWlhOMWJIUnpWWEpzS0NSbWIzSnRMQ0JqZFhKeVpXNTBYM0psYzNWc2RITmZkWEpzS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnYVdZb2RHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJEMDlYQ0pjSWlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lISmxkSFZ5YmlCamRYSnlaVzUwWDNKbGMzVnNkSE5mZFhKc08xeHlYRzRnSUNBZ0lDQWdJSDFjY2x4dVhISmNiaUFnSUNBZ0lDQWdjbVYwZFhKdUlIUm9hWE11ZEdGNFgyRnlZMmhwZG1WZmNtVnpkV3gwYzE5MWNtdzdYSEpjYmlBZ0lDQjlMRnh5WEc1Y2RHZGxkRlZ5YkZCaGNtRnRjem9nWm5WdVkzUnBiMjRvSkdadmNtMHBlMXh5WEc1Y2NseHVYSFJjZEhSb2FYTXVZblZwYkdSVmNteERiMjF3YjI1bGJuUnpLQ1JtYjNKdExDQjBjblZsS1R0Y2NseHVYSEpjYmlBZ0lDQWdJQ0FnYVdZb2RHaHBjeTUwWVhoZllYSmphR2wyWlY5eVpYTjFiSFJ6WDNWeWJDRTlYQ0pjSWlsY2NseHVJQ0FnSUNBZ0lDQjdYSEpjYmx4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0JwWmloMGFHbHpMbUZqZEdsMlpWOTBZWGdoUFZ3aVhDSXBYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJSFpoY2lCbWFXVnNaRjl1WVcxbElEMGdkR2hwY3k1aFkzUnBkbVZmZEdGNE8xeHlYRzVjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdsbUtIUjVjR1Z2WmloMGFHbHpMblZ5YkY5d1lYSmhiWE5iWm1sbGJHUmZibUZ0WlYwcElUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2UxeHlYRzRnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSbGJHVjBaU0IwYUdsekxuVnliRjl3WVhKaGJYTmJabWxsYkdSZmJtRnRaVjA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUgxY2NseHVJQ0FnSUNBZ0lDQjlYSEpjYmx4eVhHNWNkRngwY21WMGRYSnVJSFJvYVhNdWRYSnNYM0JoY21GdGN6dGNjbHh1WEhSOUxGeHlYRzVjZEdOc1pXRnlWWEpzUTI5dGNHOXVaVzUwY3pvZ1puVnVZM1JwYjI0b0tYdGNjbHh1WEhSY2RDOHZkR2hwY3k1MWNteGZZMjl0Y0c5dVpXNTBjeUE5SUZ3aVhDSTdYSEpjYmx4MFhIUjBhR2x6TG5WeWJGOXdZWEpoYlhNZ1BTQjdmVHRjY2x4dVhIUjlMRnh5WEc1Y2RHUnBjMkZpYkdWSmJuQjFkSE02SUdaMWJtTjBhVzl1S0NSbWIzSnRLWHRjY2x4dVhIUmNkSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhSY2RGeHlYRzVjZEZ4MEpHWnZjbTB1SkdacFpXeGtjeTVsWVdOb0tHWjFibU4wYVc5dUtDbDdYSEpjYmx4MFhIUmNkRnh5WEc1Y2RGeDBYSFIyWVhJZ0pHbHVjSFYwY3lBOUlDUW9kR2hwY3lrdVptbHVaQ2hjSW1sdWNIVjBMQ0J6Wld4bFkzUXNJQzV0WlhSaExYTnNhV1JsY2x3aUtUdGNjbHh1WEhSY2RGeDBKR2x1Y0hWMGN5NWhkSFJ5S0Z3aVpHbHpZV0pzWldSY0lpd2dYQ0prYVhOaFlteGxaRndpS1R0Y2NseHVYSFJjZEZ4MEpHbHVjSFYwY3k1aGRIUnlLRndpWkdsellXSnNaV1JjSWl3Z2RISjFaU2s3WEhKY2JseDBYSFJjZENScGJuQjFkSE11Y0hKdmNDaGNJbVJwYzJGaWJHVmtYQ0lzSUhSeWRXVXBPMXh5WEc1Y2RGeDBYSFFrYVc1d2RYUnpMblJ5YVdkblpYSW9YQ0pqYUc5elpXNDZkWEJrWVhSbFpGd2lLVHRjY2x4dVhIUmNkRngwWEhKY2JseDBYSFI5S1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwWEhKY2JseDBmU3hjY2x4dVhIUmxibUZpYkdWSmJuQjFkSE02SUdaMWJtTjBhVzl1S0NSbWIzSnRLWHRjY2x4dVhIUmNkSFpoY2lCelpXeG1JRDBnZEdocGN6dGNjbHh1WEhSY2RGeHlYRzVjZEZ4MEpHWnZjbTB1SkdacFpXeGtjeTVsWVdOb0tHWjFibU4wYVc5dUtDbDdYSEpjYmx4MFhIUmNkRnh5WEc1Y2RGeDBYSFIyWVhJZ0pHbHVjSFYwY3lBOUlDUW9kR2hwY3lrdVptbHVaQ2hjSW1sdWNIVjBMQ0J6Wld4bFkzUXNJQzV0WlhSaExYTnNhV1JsY2x3aUtUdGNjbHh1WEhSY2RGeDBKR2x1Y0hWMGN5NXdjbTl3S0Z3aVpHbHpZV0pzWldSY0lpd2dkSEoxWlNrN1hISmNibHgwWEhSY2RDUnBibkIxZEhNdWNtVnRiM1psUVhSMGNpaGNJbVJwYzJGaWJHVmtYQ0lwTzF4eVhHNWNkRngwWEhRa2FXNXdkWFJ6TG5SeWFXZG5aWElvWENKamFHOXpaVzQ2ZFhCa1lYUmxaRndpS1R0Y2RGeDBYSFJjY2x4dVhIUmNkSDBwTzF4eVhHNWNkRngwWEhKY2JseDBYSFJjY2x4dVhIUjlMRnh5WEc1Y2RHSjFhV3hrVlhKc1EyOXRjRzl1Wlc1MGN6b2dablZ1WTNScGIyNG9KR1p2Y20wc0lHTnNaV0Z5WDJOdmJYQnZibVZ1ZEhNcGUxeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdjMlZzWmlBOUlIUm9hWE03WEhKY2JseDBYSFJjY2x4dVhIUmNkR2xtS0hSNWNHVnZaaWhqYkdWaGNsOWpiMjF3YjI1bGJuUnpLU0U5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBhV1lvWTJ4bFlYSmZZMjl0Y0c5dVpXNTBjejA5ZEhKMVpTbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhSb2FYTXVZMnhsWVhKVmNteERiMjF3YjI1bGJuUnpLQ2s3WEhKY2JseDBYSFJjZEgxY2NseHVYSFJjZEgxY2NseHVYSFJjZEZ4eVhHNWNkRngwSkdadmNtMHVKR1pwWld4a2N5NWxZV05vS0daMWJtTjBhVzl1S0NsN1hISmNibHgwWEhSY2RGeHlYRzVjZEZ4MFhIUjJZWElnWm1sbGJHUk9ZVzFsSUQwZ0pDaDBhR2x6S1M1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMXVZVzFsWENJcE8xeHlYRzVjZEZ4MFhIUjJZWElnWm1sbGJHUlVlWEJsSUQwZ0pDaDBhR2x6S1M1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMTBlWEJsWENJcE8xeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RGeDBhV1lvWm1sbGJHUlVlWEJsUFQxY0luTmxZWEpqYUZ3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwYzJWc1ppNXdjbTlqWlhOelUyVmhjbU5vUm1sbGJHUW9KQ2gwYUdsektTazdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkRngwWld4elpTQnBaaWdvWm1sbGJHUlVlWEJsUFQxY0luUmhaMXdpS1h4OEtHWnBaV3hrVkhsd1pUMDlYQ0pqWVhSbFoyOXllVndpS1h4OEtHWnBaV3hrVkhsd1pUMDlYQ0owWVhodmJtOXRlVndpS1NsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkSE5sYkdZdWNISnZZMlZ6YzFSaGVHOXViMjE1S0NRb2RHaHBjeWtwTzF4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSY2RHVnNjMlVnYVdZb1ptbGxiR1JVZVhCbFBUMWNJbk52Y25SZmIzSmtaWEpjSWlsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkSE5sYkdZdWNISnZZMlZ6YzFOdmNuUlBjbVJsY2tacFpXeGtLQ1FvZEdocGN5a3BPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEdWc2MyVWdhV1lvWm1sbGJHUlVlWEJsUFQxY0luQnZjM1J6WDNCbGNsOXdZV2RsWENJcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJ6Wld4bUxuQnliMk5sYzNOU1pYTjFiSFJ6VUdWeVVHRm5aVVpwWld4a0tDUW9kR2hwY3lrcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9abWxsYkdSVWVYQmxQVDFjSW1GMWRHaHZjbHdpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBjMlZzWmk1d2NtOWpaWE56UVhWMGFHOXlLQ1FvZEdocGN5a3BPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEdWc2MyVWdhV1lvWm1sbGJHUlVlWEJsUFQxY0luQnZjM1JmZEhsd1pWd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MGMyVnNaaTV3Y205alpYTnpVRzl6ZEZSNWNHVW9KQ2gwYUdsektTazdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkRngwWld4elpTQnBaaWhtYVdWc1pGUjVjR1U5UFZ3aWNHOXpkRjlrWVhSbFhDSXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSelpXeG1MbkJ5YjJObGMzTlFiM04wUkdGMFpTZ2tLSFJvYVhNcEtUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBYSFJsYkhObElHbG1LR1pwWld4a1ZIbHdaVDA5WENKd2IzTjBYMjFsZEdGY0lpbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhObGJHWXVjSEp2WTJWemMxQnZjM1JOWlhSaEtDUW9kR2hwY3lrcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEdWc2MyVmNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSY2RGeHlYRzVjZEZ4MGZTazdYSEpjYmx4MFhIUmNjbHh1WEhSOUxGeHlYRzVjZEhCeWIyTmxjM05UWldGeVkyaEdhV1ZzWkRvZ1puVnVZM1JwYjI0b0pHTnZiblJoYVc1bGNpbGNjbHh1WEhSN1hISmNibHgwWEhSMllYSWdjMlZzWmlBOUlIUm9hWE03WEhKY2JseDBYSFJjY2x4dVhIUmNkSFpoY2lBa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENKcGJuQjFkRnR1WVcxbFhqMG5YM05tWDNObFlYSmphQ2RkWENJcE8xeHlYRzVjZEZ4MFhISmNibHgwWEhScFppZ2tabWxsYkdRdWJHVnVaM1JvUGpBcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RIWmhjaUJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbTVoYldWY0lpa3VjbVZ3YkdGalpTZ25XMTBuTENBbkp5azdYSEpjYmx4MFhIUmNkSFpoY2lCbWFXVnNaRlpoYkNBOUlDUm1hV1ZzWkM1MllXd29LVHRjY2x4dVhIUmNkRngwWEhKY2JseDBYSFJjZEdsbUtHWnBaV3hrVm1Gc0lUMWNJbHdpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBMeTl6Wld4bUxuVnliRjlqYjIxd2IyNWxiblJ6SUNzOUlGd2lKbDl6Wmw5elBWd2lLMlZ1WTI5a1pWVlNTVU52YlhCdmJtVnVkQ2htYVdWc1pGWmhiQ2s3WEhKY2JseDBYSFJjZEZ4MGMyVnNaaTUxY214ZmNHRnlZVzF6V3lkZmMyWmZjeWRkSUQwZ1pXNWpiMlJsVlZKSlEyOXRjRzl1Wlc1MEtHWnBaV3hrVm1Gc0tUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBmVnh5WEc1Y2RIMHNYSEpjYmx4MGNISnZZMlZ6YzFOdmNuUlBjbVJsY2tacFpXeGtPaUJtZFc1amRHbHZiaWdrWTI5dWRHRnBibVZ5S1Z4eVhHNWNkSHRjY2x4dVhIUmNkSFJvYVhNdWNISnZZMlZ6YzBGMWRHaHZjaWdrWTI5dWRHRnBibVZ5S1R0Y2NseHVYSFJjZEZ4eVhHNWNkSDBzWEhKY2JseDBjSEp2WTJWemMxSmxjM1ZzZEhOUVpYSlFZV2RsUm1sbGJHUTZJR1oxYm1OMGFXOXVLQ1JqYjI1MFlXbHVaWElwWEhKY2JseDBlMXh5WEc1Y2RGeDBkR2hwY3k1d2NtOWpaWE56UVhWMGFHOXlLQ1JqYjI1MFlXbHVaWElwTzF4eVhHNWNkRngwWEhKY2JseDBmU3hjY2x4dVhIUm5aWFJCWTNScGRtVlVZWGc2SUdaMWJtTjBhVzl1S0NSbWFXVnNaQ2tnZTF4eVhHNWNkRngwY21WMGRYSnVJSFJvYVhNdVlXTjBhWFpsWDNSaGVEdGNjbHh1WEhSOUxGeHlYRzVjZEdkbGRGTmxiR1ZqZEZaaGJEb2dablZ1WTNScGIyNG9KR1pwWld4a0tYdGNjbHh1WEhKY2JseDBYSFIyWVhJZ1ptbGxiR1JXWVd3Z1BTQmNJbHdpTzF4eVhHNWNkRngwWEhKY2JseDBYSFJwWmlna1ptbGxiR1F1ZG1Gc0tDa2hQVEFwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEdacFpXeGtWbUZzSUQwZ0pHWnBaV3hrTG5aaGJDZ3BPMXh5WEc1Y2RGeDBmVnh5WEc1Y2RGeDBYSEpjYmx4MFhIUnBaaWhtYVdWc1pGWmhiRDA5Ym5Wc2JDbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBabWxsYkdSV1lXd2dQU0JjSWx3aU8xeHlYRzVjZEZ4MGZWeHlYRzVjZEZ4MFhISmNibHgwWEhSeVpYUjFjbTRnWm1sbGJHUldZV3c3WEhKY2JseDBmU3hjY2x4dVhIUm5aWFJOWlhSaFUyVnNaV04wVm1Gc09pQm1kVzVqZEdsdmJpZ2tabWxsYkdRcGUxeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdabWxsYkdSV1lXd2dQU0JjSWx3aU8xeHlYRzVjZEZ4MFhISmNibHgwWEhSbWFXVnNaRlpoYkNBOUlDUm1hV1ZzWkM1MllXd29LVHRjY2x4dVhIUmNkRngwWEhSY2RGeDBYSEpjYmx4MFhIUnBaaWhtYVdWc1pGWmhiRDA5Ym5Wc2JDbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBabWxsYkdSV1lXd2dQU0JjSWx3aU8xeHlYRzVjZEZ4MGZWeHlYRzVjZEZ4MFhISmNibHgwWEhSeVpYUjFjbTRnWm1sbGJHUldZV3c3WEhKY2JseDBmU3hjY2x4dVhIUm5aWFJOZFd4MGFWTmxiR1ZqZEZaaGJEb2dablZ1WTNScGIyNG9KR1pwWld4a0xDQnZjR1Z5WVhSdmNpbDdYSEpjYmx4MFhIUmNjbHh1WEhSY2RIWmhjaUJrWld4cGJTQTlJRndpSzF3aU8xeHlYRzVjZEZ4MGFXWW9iM0JsY21GMGIzSTlQVndpYjNKY0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBaR1ZzYVcwZ1BTQmNJaXhjSWp0Y2NseHVYSFJjZEgxY2NseHVYSFJjZEZ4eVhHNWNkRngwYVdZb2RIbHdaVzltS0NSbWFXVnNaQzUyWVd3b0tTazlQVndpYjJKcVpXTjBYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEdsbUtDUm1hV1ZzWkM1MllXd29LU0U5Ym5Wc2JDbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhKbGRIVnliaUFrWm1sbGJHUXVkbUZzS0NrdWFtOXBiaWhrWld4cGJTazdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkSDFjY2x4dVhIUmNkRnh5WEc1Y2RIMHNYSEpjYmx4MFoyVjBUV1YwWVUxMWJIUnBVMlZzWldOMFZtRnNPaUJtZFc1amRHbHZiaWdrWm1sbGJHUXNJRzl3WlhKaGRHOXlLWHRjY2x4dVhIUmNkRnh5WEc1Y2RGeDBkbUZ5SUdSbGJHbHRJRDBnWENJdEt5MWNJanRjY2x4dVhIUmNkR2xtS0c5d1pYSmhkRzl5UFQxY0ltOXlYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZEdSbGJHbHRJRDBnWENJdExDMWNJanRjY2x4dVhIUmNkSDFjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEdsbUtIUjVjR1Z2Wmlna1ptbGxiR1F1ZG1Gc0tDa3BQVDFjSW05aWFtVmpkRndpS1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhScFppZ2tabWxsYkdRdWRtRnNLQ2toUFc1MWJHd3BYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUjJZWElnWm1sbGJHUjJZV3dnUFNCYlhUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhRa0tDUm1hV1ZzWkM1MllXd29LU2t1WldGamFDaG1kVzVqZEdsdmJpaHBibVJsZUN4MllXeDFaU2w3WEhKY2JseDBYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBYSFJjZEdacFpXeGtkbUZzTG5CMWMyZ29LSFpoYkhWbEtTazdYSEpjYmx4MFhIUmNkRngwZlNrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwY21WMGRYSnVJR1pwWld4a2RtRnNMbXB2YVc0b1pHVnNhVzBwTzF4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSOVhISmNibHgwWEhSY2NseHVYSFJjZEhKbGRIVnliaUJjSWx3aU8xeHlYRzVjZEZ4MFhISmNibHgwZlN4Y2NseHVYSFJuWlhSRGFHVmphMkp2ZUZaaGJEb2dablZ1WTNScGIyNG9KR1pwWld4a0xDQnZjR1Z5WVhSdmNpbDdYSEpjYmx4MFhIUmNjbHh1WEhSY2RGeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZtRnNJRDBnSkdacFpXeGtMbTFoY0NobWRXNWpkR2x2YmlncGUxeHlYRzVjZEZ4MFhIUnBaaWdrS0hSb2FYTXBMbkJ5YjNBb1hDSmphR1ZqYTJWa1hDSXBQVDEwY25WbEtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwY21WMGRYSnVJQ1FvZEdocGN5a3VkbUZzS0NrN1hISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RIMHBMbWRsZENncE8xeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdaR1ZzYVcwZ1BTQmNJaXRjSWp0Y2NseHVYSFJjZEdsbUtHOXdaWEpoZEc5eVBUMWNJbTl5WENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHUmxiR2x0SUQwZ1hDSXNYQ0k3WEhKY2JseDBYSFI5WEhKY2JseDBYSFJjY2x4dVhIUmNkSEpsZEhWeWJpQm1hV1ZzWkZaaGJDNXFiMmx1S0dSbGJHbHRLVHRjY2x4dVhIUjlMRnh5WEc1Y2RHZGxkRTFsZEdGRGFHVmphMkp2ZUZaaGJEb2dablZ1WTNScGIyNG9KR1pwWld4a0xDQnZjR1Z5WVhSdmNpbDdYSEpjYmx4MFhIUmNjbHh1WEhSY2RGeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZtRnNJRDBnSkdacFpXeGtMbTFoY0NobWRXNWpkR2x2YmlncGUxeHlYRzVjZEZ4MFhIUnBaaWdrS0hSb2FYTXBMbkJ5YjNBb1hDSmphR1ZqYTJWa1hDSXBQVDEwY25WbEtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwY21WMGRYSnVJQ2drS0hSb2FYTXBMblpoYkNncEtUdGNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBmU2t1WjJWMEtDazdYSEpjYmx4MFhIUmNjbHh1WEhSY2RIWmhjaUJrWld4cGJTQTlJRndpTFNzdFhDSTdYSEpjYmx4MFhIUnBaaWh2Y0dWeVlYUnZjajA5WENKdmNsd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFJrWld4cGJTQTlJRndpTFN3dFhDSTdYSEpjYmx4MFhIUjlYSEpjYmx4MFhIUmNjbHh1WEhSY2RISmxkSFZ5YmlCbWFXVnNaRlpoYkM1cWIybHVLR1JsYkdsdEtUdGNjbHh1WEhSOUxGeHlYRzVjZEdkbGRGSmhaR2x2Vm1Gc09pQm1kVzVqZEdsdmJpZ2tabWxsYkdRcGUxeHlYRzVjZEZ4MFhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZtRnNJRDBnSkdacFpXeGtMbTFoY0NobWRXNWpkR2x2YmlncFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RHbG1LQ1FvZEdocGN5a3VjSEp2Y0NoY0ltTm9aV05yWldSY0lpazlQWFJ5ZFdVcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJ5WlhSMWNtNGdKQ2gwYUdsektTNTJZV3dvS1R0Y2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RIMHBMbWRsZENncE8xeHlYRzVjZEZ4MFhISmNibHgwWEhSY2NseHVYSFJjZEdsbUtHWnBaV3hrVm1Gc1d6QmRJVDB3S1Z4eVhHNWNkRngwZTF4eVhHNWNkRngwWEhSeVpYUjFjbTRnWm1sbGJHUldZV3hiTUYwN1hISmNibHgwWEhSOVhISmNibHgwZlN4Y2NseHVYSFJuWlhSTlpYUmhVbUZrYVc5V1lXdzZJR1oxYm1OMGFXOXVLQ1JtYVdWc1pDbDdYSEpjYmx4MFhIUmNkRngwWEhSY2RGeDBYSEpjYmx4MFhIUjJZWElnWm1sbGJHUldZV3dnUFNBa1ptbGxiR1F1YldGd0tHWjFibU4wYVc5dUtDbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBhV1lvSkNoMGFHbHpLUzV3Y205d0tGd2lZMmhsWTJ0bFpGd2lLVDA5ZEhKMVpTbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEhKbGRIVnliaUFrS0hSb2FYTXBMblpoYkNncE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkRnh5WEc1Y2RGeDBmU2t1WjJWMEtDazdYSEpjYmx4MFhIUmNjbHh1WEhSY2RISmxkSFZ5YmlCbWFXVnNaRlpoYkZzd1hUdGNjbHh1WEhSOUxGeHlYRzVjZEhCeWIyTmxjM05CZFhSb2IzSTZJR1oxYm1OMGFXOXVLQ1JqYjI1MFlXbHVaWElwWEhKY2JseDBlMXh5WEc1Y2RGeDBkbUZ5SUhObGJHWWdQU0IwYUdsek8xeHlYRzVjZEZ4MFhISmNibHgwWEhSY2NseHVYSFJjZEhaaGNpQm1hV1ZzWkZSNWNHVWdQU0FrWTI5dWRHRnBibVZ5TG1GMGRISW9YQ0prWVhSaExYTm1MV1pwWld4a0xYUjVjR1ZjSWlrN1hISmNibHgwWEhSMllYSWdhVzV3ZFhSVWVYQmxJRDBnSkdOdmJuUmhhVzVsY2k1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMXBibkIxZEMxMGVYQmxYQ0lwTzF4eVhHNWNkRngwWEhKY2JseDBYSFIyWVhJZ0pHWnBaV3hrTzF4eVhHNWNkRngwZG1GeUlHWnBaV3hrVG1GdFpTQTlJRndpWENJN1hISmNibHgwWEhSMllYSWdabWxsYkdSV1lXd2dQU0JjSWx3aU8xeHlYRzVjZEZ4MFhISmNibHgwWEhScFppaHBibkIxZEZSNWNHVTlQVndpYzJWc1pXTjBYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5ObGJHVmpkRndpS1R0Y2NseHVYSFJjZEZ4MFptbGxiR1JPWVcxbElEMGdKR1pwWld4a0xtRjBkSElvWENKdVlXMWxYQ0lwTG5KbGNHeGhZMlVvSjF0ZEp5d2dKeWNwTzF4eVhHNWNkRngwWEhSY2NseHVYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQnpaV3htTG1kbGRGTmxiR1ZqZEZaaGJDZ2tabWxsYkdRcE95QmNjbHh1WEhSY2RIMWNjbHh1WEhSY2RHVnNjMlVnYVdZb2FXNXdkWFJVZVhCbFBUMWNJbTExYkhScGMyVnNaV04wWENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RDUm1hV1ZzWkNBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0luTmxiR1ZqZEZ3aUtUdGNjbHh1WEhSY2RGeDBabWxsYkdST1lXMWxJRDBnSkdacFpXeGtMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHlYRzVjZEZ4MFhIUjJZWElnYjNCbGNtRjBiM0lnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbVJoZEdFdGIzQmxjbUYwYjNKY0lpazdYSEpjYmx4MFhIUmNkRnh5WEc1Y2RGeDBYSFJtYVdWc1pGWmhiQ0E5SUhObGJHWXVaMlYwVFhWc2RHbFRaV3hsWTNSV1lXd29KR1pwWld4a0xDQmNJbTl5WENJcE8xeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RIMWNjbHh1WEhSY2RHVnNjMlVnYVdZb2FXNXdkWFJVZVhCbFBUMWNJbU5vWldOclltOTRYQ0lwWEhKY2JseDBYSFI3WEhKY2JseDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5Wc0lENGdiR2tnYVc1d2RYUTZZMmhsWTJ0aWIzaGNJaWs3WEhKY2JseDBYSFJjZEZ4eVhHNWNkRngwWEhScFppZ2tabWxsYkdRdWJHVnVaM1JvUGpBcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbTVoYldWY0lpa3VjbVZ3YkdGalpTZ25XMTBuTENBbkp5azdYSEpjYmx4MFhIUmNkRngwWEhSY2RGeDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBkbUZ5SUc5d1pYSmhkRzl5SUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aVBpQjFiRndpS1M1aGRIUnlLRndpWkdGMFlTMXZjR1Z5WVhSdmNsd2lLVHRjY2x4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlITmxiR1l1WjJWMFEyaGxZMnRpYjNoV1lXd29KR1pwWld4a0xDQmNJbTl5WENJcE8xeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkRnh5WEc1Y2RGeDBmVnh5WEc1Y2RGeDBaV3h6WlNCcFppaHBibkIxZEZSNWNHVTlQVndpY21Ga2FXOWNJaWxjY2x4dVhIUmNkSHRjY2x4dVhIUmNkRngwWEhKY2JseDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5Wc0lENGdiR2tnYVc1d2RYUTZjbUZrYVc5Y0lpazdYSEpjYmx4MFhIUmNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUnBaaWdrWm1sbGJHUXViR1Z1WjNSb1BqQXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSbWFXVnNaRTVoYldVZ1BTQWtabWxsYkdRdVlYUjBjaWhjSW01aGJXVmNJaWt1Y21Wd2JHRmpaU2duVzEwbkxDQW5KeWs3WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBabWxsYkdSV1lXd2dQU0J6Wld4bUxtZGxkRkpoWkdsdlZtRnNLQ1JtYVdWc1pDazdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkSDFjY2x4dVhIUmNkRnh5WEc1Y2RGeDBhV1lvZEhsd1pXOW1LR1pwWld4a1ZtRnNLU0U5WENKMWJtUmxabWx1WldSY0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBhV1lvWm1sbGJHUldZV3doUFZ3aVhDSXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSMllYSWdabWxsYkdSVGJIVm5JRDBnWENKY0lqdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhScFppaG1hV1ZzWkU1aGJXVTlQVndpWDNObVgyRjFkR2h2Y2x3aUtWeHlYRzVjZEZ4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2RHWnBaV3hrVTJ4MVp5QTlJRndpWVhWMGFHOXljMXdpTzF4eVhHNWNkRngwWEhSY2RIMWNjbHh1WEhSY2RGeDBYSFJsYkhObElHbG1LR1pwWld4a1RtRnRaVDA5WENKZmMyWmZjMjl5ZEY5dmNtUmxjbHdpS1Z4eVhHNWNkRngwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjZEdacFpXeGtVMngxWnlBOUlGd2ljMjl5ZEY5dmNtUmxjbHdpTzF4eVhHNWNkRngwWEhSY2RIMWNjbHh1WEhSY2RGeDBYSFJsYkhObElHbG1LR1pwWld4a1RtRnRaVDA5WENKZmMyWmZjSEJ3WENJcFhISmNibHgwWEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JUYkhWbklEMGdYQ0pmYzJaZmNIQndYQ0k3WEhKY2JseDBYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNkR1ZzYzJVZ2FXWW9abWxsYkdST1lXMWxQVDFjSWw5elpsOXdiM04wWDNSNWNHVmNJaWxjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pGTnNkV2NnUFNCY0luQnZjM1JmZEhsd1pYTmNJanRjY2x4dVhIUmNkRngwWEhSOVhISmNibHgwWEhSY2RGeDBaV3h6WlZ4eVhHNWNkRngwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSOVhISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwYVdZb1ptbGxiR1JUYkhWbklUMWNJbHdpS1Z4eVhHNWNkRngwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJjZEM4dmMyVnNaaTUxY214ZlkyOXRjRzl1Wlc1MGN5QXJQU0JjSWlaY0lpdG1hV1ZzWkZOc2RXY3JYQ0k5WENJclptbGxiR1JXWVd3N1hISmNibHgwWEhSY2RGeDBYSFJ6Wld4bUxuVnliRjl3WVhKaGJYTmJabWxsYkdSVGJIVm5YU0E5SUdacFpXeGtWbUZzTzF4eVhHNWNkRngwWEhSY2RIMWNjbHh1WEhSY2RGeDBmVnh5WEc1Y2RGeDBmVnh5WEc1Y2RGeDBYSEpjYmx4MGZTeGNjbHh1WEhSd2NtOWpaWE56VUc5emRGUjVjR1VnT2lCbWRXNWpkR2x2Ymlna2RHaHBjeWw3WEhKY2JseDBYSFJjY2x4dVhIUmNkSFJvYVhNdWNISnZZMlZ6YzBGMWRHaHZjaWdrZEdocGN5azdYSEpjYmx4MFhIUmNjbHh1WEhSOUxGeHlYRzVjZEhCeWIyTmxjM05RYjNOMFRXVjBZVG9nWm5WdVkzUnBiMjRvSkdOdmJuUmhhVzVsY2lsY2NseHVYSFI3WEhKY2JseDBYSFIyWVhJZ2MyVnNaaUE5SUhSb2FYTTdYSEpjYmx4MFhIUmNjbHh1WEhSY2RIWmhjaUJtYVdWc1pGUjVjR1VnUFNBa1kyOXVkR0ZwYm1WeUxtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMWFI1Y0dWY0lpazdYSEpjYmx4MFhIUjJZWElnYVc1d2RYUlVlWEJsSUQwZ0pHTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzFwYm5CMWRDMTBlWEJsWENJcE8xeHlYRzVjZEZ4MGRtRnlJRzFsZEdGVWVYQmxJRDBnSkdOdmJuUmhhVzVsY2k1aGRIUnlLRndpWkdGMFlTMXpaaTF0WlhSaExYUjVjR1ZjSWlrN1hISmNibHh5WEc1Y2RGeDBkbUZ5SUdacFpXeGtWbUZzSUQwZ1hDSmNJanRjY2x4dVhIUmNkSFpoY2lBa1ptbGxiR1E3WEhKY2JseDBYSFIyWVhJZ1ptbGxiR1JPWVcxbElEMGdYQ0pjSWp0Y2NseHVYSFJjZEZ4eVhHNWNkRngwYVdZb2JXVjBZVlI1Y0dVOVBWd2liblZ0WW1WeVhDSXBYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR2xtS0dsdWNIVjBWSGx3WlQwOVhDSnlZVzVuWlMxdWRXMWlaWEpjSWlsY2NseHVYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkQ1JtYVdWc1pDQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJaTV6WmkxdFpYUmhMWEpoYm1kbExXNTFiV0psY2lCcGJuQjFkRndpS1R0Y2NseHVYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBYSFIyWVhJZ2RtRnNkV1Z6SUQwZ1cxMDdYSEpjYmx4MFhIUmNkRngwSkdacFpXeGtMbVZoWTJnb1puVnVZM1JwYjI0b0tYdGNjbHh1WEhSY2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RGeDBkbUZzZFdWekxuQjFjMmdvSkNoMGFHbHpLUzUyWVd3b0tTazdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGZTazdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQjJZV3gxWlhNdWFtOXBiaWhjSWl0Y0lpazdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEgxY2NseHVYSFJjZEZ4MFpXeHpaU0JwWmlocGJuQjFkRlI1Y0dVOVBWd2ljbUZ1WjJVdGMyeHBaR1Z5WENJcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFFrWm1sbGJHUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0l1YzJZdGJXVjBZUzF5WVc1blpTMXpiR2xrWlhJZ2FXNXdkWFJjSWlrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwTHk5blpYUWdZVzU1SUc1MWJXSmxjaUJtYjNKdFlYUjBhVzVuSUhOMGRXWm1YSEpjYmx4MFhIUmNkRngwZG1GeUlDUnRaWFJoWDNKaGJtZGxJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpTG5ObUxXMWxkR0V0Y21GdVoyVXRjMnhwWkdWeVhDSXBPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RIWmhjaUJrWldOcGJXRnNYM0JzWVdObGN5QTlJQ1J0WlhSaFgzSmhibWRsTG1GMGRISW9YQ0prWVhSaExXUmxZMmx0WVd3dGNHeGhZMlZ6WENJcE8xeHlYRzVjZEZ4MFhIUmNkSFpoY2lCMGFHOTFjMkZ1WkY5elpYQmxjbUYwYjNJZ1BTQWtiV1YwWVY5eVlXNW5aUzVoZEhSeUtGd2laR0YwWVMxMGFHOTFjMkZ1WkMxelpYQmxjbUYwYjNKY0lpazdYSEpjYmx4MFhIUmNkRngwZG1GeUlHUmxZMmx0WVd4ZmMyVndaWEpoZEc5eUlEMGdKRzFsZEdGZmNtRnVaMlV1WVhSMGNpaGNJbVJoZEdFdFpHVmphVzFoYkMxelpYQmxjbUYwYjNKY0lpazdYSEpjYmx4eVhHNWNkRngwWEhSY2RIWmhjaUJtYVdWc1pGOW1iM0p0WVhRZ1BTQjNUblZ0WWloN1hISmNibHgwWEhSY2RGeDBYSFJ0WVhKck9pQmtaV05wYldGc1gzTmxjR1Z5WVhSdmNpeGNjbHh1WEhSY2RGeDBYSFJjZEdSbFkybHRZV3h6T2lCd1lYSnpaVVpzYjJGMEtHUmxZMmx0WVd4ZmNHeGhZMlZ6S1N4Y2NseHVYSFJjZEZ4MFhIUmNkSFJvYjNWellXNWtPaUIwYUc5MWMyRnVaRjl6WlhCbGNtRjBiM0pjY2x4dVhIUmNkRngwWEhSOUtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSMllYSWdkbUZzZFdWeklEMGdXMTA3WEhKY2JseHlYRzVjY2x4dVhIUmNkRngwWEhSMllYSWdjMnhwWkdWeVgyOWlhbVZqZENBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0lpNXRaWFJoTFhOc2FXUmxjbHdpS1Zzd1hUdGNjbHh1WEhSY2RGeDBYSFF2TDNaaGJDQm1jbTl0SUhOc2FXUmxjaUJ2WW1wbFkzUmNjbHh1WEhSY2RGeDBYSFIyWVhJZ2MyeHBaR1Z5WDNaaGJDQTlJSE5zYVdSbGNsOXZZbXBsWTNRdWJtOVZhVk5zYVdSbGNpNW5aWFFvS1R0Y2NseHVYSEpjYmx4MFhIUmNkRngwZG1Gc2RXVnpMbkIxYzJnb1ptbGxiR1JmWm05eWJXRjBMbVp5YjIwb2MyeHBaR1Z5WDNaaGJGc3dYU2twTzF4eVhHNWNkRngwWEhSY2RIWmhiSFZsY3k1d2RYTm9LR1pwWld4a1gyWnZjbTFoZEM1bWNtOXRLSE5zYVdSbGNsOTJZV3hiTVYwcEtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlIWmhiSFZsY3k1cWIybHVLRndpSzF3aUtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSbWFXVnNaRTVoYldVZ1BTQWtiV1YwWVY5eVlXNW5aUzVoZEhSeUtGd2laR0YwWVMxelppMW1hV1ZzWkMxdVlXMWxYQ0lwTzF4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFJjZEdWc2MyVWdhV1lvYVc1d2RYUlVlWEJsUFQxY0luSmhibWRsTFhKaFpHbHZYQ0lwWEhKY2JseDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUWtabWxsYkdRZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSXVjMll0YVc1d2RYUXRjbUZ1WjJVdGNtRmthVzljSWlrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDA5TUNsY2NseHVYSFJjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWEhRdkwzUm9aVzRnZEhKNUlHRm5ZV2x1TENCM1pTQnRkWE4wSUdKbElIVnphVzVuSUdFZ2MybHVaMnhsSUdacFpXeGtYSEpjYmx4MFhIUmNkRngwWEhRa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENJK0lIVnNYQ0lwTzF4eVhHNWNkRngwWEhSY2RIMWNjbHh1WEhKY2JseDBYSFJjZEZ4MGRtRnlJQ1J0WlhSaFgzSmhibWRsSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aUxuTm1MVzFsZEdFdGNtRnVaMlZjSWlrN1hISmNibHgwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwTHk5MGFHVnlaU0JwY3lCaGJpQmxiR1Z0Wlc1MElIZHBkR2dnWVNCbWNtOXRMM1J2SUdOc1lYTnpJQzBnYzI4Z2QyVWdibVZsWkNCMGJ5Qm5aWFFnZEdobElIWmhiSFZsY3lCdlppQjBhR1VnWm5KdmJTQW1JSFJ2SUdsdWNIVjBJR1pwWld4a2N5QnpaWEJsY21GMFpXeDVYSEpjYmx4MFhIUmNkRngwYVdZb0pHWnBaV3hrTG14bGJtZDBhRDR3S1Z4eVhHNWNkRngwWEhSY2RIdGNkRnh5WEc1Y2RGeDBYSFJjZEZ4MGRtRnlJR1pwWld4a1gzWmhiSE1nUFNCYlhUdGNjbHh1WEhSY2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RGeDBKR1pwWld4a0xtVmhZMmdvWm5WdVkzUnBiMjRvS1h0Y2NseHVYSFJjZEZ4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFhIUmNkSFpoY2lBa2NtRmthVzl6SUQwZ0pDaDBhR2x6S1M1bWFXNWtLRndpTG5ObUxXbHVjSFYwTFhKaFpHbHZYQ0lwTzF4eVhHNWNkRngwWEhSY2RGeDBYSFJtYVdWc1pGOTJZV3h6TG5CMWMyZ29jMlZzWmk1blpYUk5aWFJoVW1Ga2FXOVdZV3dvSkhKaFpHbHZjeWtwTzF4eVhHNWNkRngwWEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhSY2RIMHBPMXh5WEc1Y2RGeDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBYSFF2TDNCeVpYWmxiblFnYzJWamIyNWtJRzUxYldKbGNpQm1jbTl0SUdKbGFXNW5JR3h2ZDJWeUlIUm9ZVzRnZEdobElHWnBjbk4wWEhKY2JseDBYSFJjZEZ4MFhIUnBaaWhtYVdWc1pGOTJZV3h6TG14bGJtZDBhRDA5TWlsY2NseHVYSFJjZEZ4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhSY2RGeDBhV1lvVG5WdFltVnlLR1pwWld4a1gzWmhiSE5iTVYwcFBFNTFiV0psY2lobWFXVnNaRjkyWVd4eld6QmRLU2xjY2x4dVhIUmNkRngwWEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEZ4MFhIUmNkR1pwWld4a1gzWmhiSE5iTVYwZ1BTQm1hV1ZzWkY5MllXeHpXekJkTzF4eVhHNWNkRngwWEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1ZtRnNJRDBnWm1sbGJHUmZkbUZzY3k1cWIybHVLRndpSzF3aUtUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEZ4MFhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUnBaaWdrWm1sbGJHUXViR1Z1WjNSb1BUMHhLVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1RtRnRaU0E5SUNSbWFXVnNaQzVtYVc1a0tGd2lMbk5tTFdsdWNIVjBMWEpoWkdsdlhDSXBMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHlYRzVjZEZ4MFhIUmNkSDFjY2x4dVhIUmNkRngwWEhSbGJITmxYSEpjYmx4MFhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RGeDBabWxsYkdST1lXMWxJRDBnSkcxbGRHRmZjbUZ1WjJVdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRibUZ0WlZ3aUtUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9hVzV3ZFhSVWVYQmxQVDFjSW5KaGJtZGxMWE5sYkdWamRGd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MEpHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aUxuTm1MV2x1Y0hWMExYTmxiR1ZqZEZ3aUtUdGNjbHh1WEhSY2RGeDBYSFIyWVhJZ0pHMWxkR0ZmY21GdVoyVWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0l1YzJZdGJXVjBZUzF5WVc1blpWd2lLVHRjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUXZMM1JvWlhKbElHbHpJR0Z1SUdWc1pXMWxiblFnZDJsMGFDQmhJR1p5YjIwdmRHOGdZMnhoYzNNZ0xTQnpieUIzWlNCdVpXVmtJSFJ2SUdkbGRDQjBhR1VnZG1Gc2RXVnpJRzltSUhSb1pTQm1jbTl0SUNZZ2RHOGdhVzV3ZFhRZ1ptbGxiR1J6SUhObGNHVnlZWFJsYkhsY2NseHVYSFJjZEZ4MFhIUmNjbHh1WEhSY2RGeDBYSFJwWmlna1ptbGxiR1F1YkdWdVozUm9QakFwWEhKY2JseDBYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkRngwZG1GeUlHWnBaV3hrWDNaaGJITWdQU0JiWFR0Y2NseHVYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEZ4MEpHWnBaV3hrTG1WaFkyZ29ablZ1WTNScGIyNG9LWHRjY2x4dVhIUmNkRngwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwWEhSY2RIWmhjaUFrZEdocGN5QTlJQ1FvZEdocGN5azdYSEpjYmx4MFhIUmNkRngwWEhSY2RHWnBaV3hrWDNaaGJITXVjSFZ6YUNoelpXeG1MbWRsZEUxbGRHRlRaV3hsWTNSV1lXd29KSFJvYVhNcEtUdGNjbHh1WEhSY2RGeDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBYSFI5S1R0Y2NseHVYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEZ4MEx5OXdjbVYyWlc1MElITmxZMjl1WkNCdWRXMWlaWElnWm5KdmJTQmlaV2x1WnlCc2IzZGxjaUIwYUdGdUlIUm9aU0JtYVhKemRGeHlYRzVjZEZ4MFhIUmNkRngwYVdZb1ptbGxiR1JmZG1Gc2N5NXNaVzVuZEdnOVBUSXBYSEpjYmx4MFhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFJjZEdsbUtFNTFiV0psY2lobWFXVnNaRjkyWVd4eld6RmRLVHhPZFcxaVpYSW9abWxsYkdSZmRtRnNjMXN3WFNrcFhISmNibHgwWEhSY2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkRngwWEhSbWFXVnNaRjkyWVd4eld6RmRJRDBnWm1sbGJHUmZkbUZzYzFzd1hUdGNjbHh1WEhSY2RGeDBYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2RGeDBYSEpjYmx4MFhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1ZtRnNJRDBnWm1sbGJHUmZkbUZzY3k1cWIybHVLRndpSzF3aUtUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEZ4MFhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUnBaaWdrWm1sbGJHUXViR1Z1WjNSb1BUMHhLVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1RtRnRaU0E5SUNSbWFXVnNaQzVoZEhSeUtGd2libUZ0WlZ3aUtTNXlaWEJzWVdObEtDZGJYU2NzSUNjbktUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEZ4MFpXeHpaVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkR1pwWld4a1RtRnRaU0E5SUNSdFpYUmhYM0poYm1kbExtRjBkSElvWENKa1lYUmhMWE5tTFdacFpXeGtMVzVoYldWY0lpazdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9hVzV3ZFhSVWVYQmxQVDFjSW5KaGJtZGxMV05vWldOclltOTRYQ0lwWEhKY2JseDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUWtabWxsYkdRZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSjFiQ0ErSUd4cElHbHVjSFYwT21Ob1pXTnJZbTk0WENJcE8xeHlYRzVjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEdsbUtDUm1hV1ZzWkM1c1pXNW5kR2crTUNsY2NseHVYSFJjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwWEhSbWFXVnNaRlpoYkNBOUlITmxiR1l1WjJWMFEyaGxZMnRpYjNoV1lXd29KR1pwWld4a0xDQmNJbUZ1WkZ3aUtUdGNjbHh1WEhSY2RGeDBYSFI5WEhKY2JseDBYSFJjZEgxY2NseHVYSFJjZEZ4MFhISmNibHgwWEhSY2RHbG1LR1pwWld4a1RtRnRaVDA5WENKY0lpbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEdacFpXeGtUbUZ0WlNBOUlDUm1hV1ZzWkM1aGRIUnlLRndpYm1GdFpWd2lLUzV5WlhCc1lXTmxLQ2RiWFNjc0lDY25LVHRjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwZlZ4eVhHNWNkRngwWld4elpTQnBaaWh0WlhSaFZIbHdaVDA5WENKamFHOXBZMlZjSWlsY2NseHVYSFJjZEh0Y2NseHVYSFJjZEZ4MGFXWW9hVzV3ZFhSVWVYQmxQVDFjSW5ObGJHVmpkRndpS1Z4eVhHNWNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2ljMlZzWldOMFhDSXBPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUk5aWFJoVTJWc1pXTjBWbUZzS0NSbWFXVnNaQ2s3SUZ4eVhHNWNkRngwWEhSY2RGeHlYRzVjZEZ4MFhIUjlYSEpjYmx4MFhIUmNkR1ZzYzJVZ2FXWW9hVzV3ZFhSVWVYQmxQVDFjSW0xMWJIUnBjMlZzWldOMFhDSXBYSEpjYmx4MFhIUmNkSHRjY2x4dVhIUmNkRngwWEhRa1ptbGxiR1FnUFNBa1kyOXVkR0ZwYm1WeUxtWnBibVFvWENKelpXeGxZM1JjSWlrN1hISmNibHgwWEhSY2RGeDBkbUZ5SUc5d1pYSmhkRzl5SUQwZ0pHWnBaV3hrTG1GMGRISW9YQ0prWVhSaExXOXdaWEpoZEc5eVhDSXBPMXh5WEc1Y2RGeDBYSFJjZEZ4eVhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdjMlZzWmk1blpYUk5aWFJoVFhWc2RHbFRaV3hsWTNSV1lXd29KR1pwWld4a0xDQnZjR1Z5WVhSdmNpazdYSEpjYmx4MFhIUmNkSDFjY2x4dVhIUmNkRngwWld4elpTQnBaaWhwYm5CMWRGUjVjR1U5UFZ3aVkyaGxZMnRpYjNoY0lpbGNjbHh1WEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZENSbWFXVnNaQ0E5SUNSamIyNTBZV2x1WlhJdVptbHVaQ2hjSW5Wc0lENGdiR2tnYVc1d2RYUTZZMmhsWTJ0aWIzaGNJaWs3WEhKY2JseDBYSFJjZEZ4MFhISmNibHgwWEhSY2RGeDBhV1lvSkdacFpXeGtMbXhsYm1kMGFENHdLVnh5WEc1Y2RGeDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUmNkSFpoY2lCdmNHVnlZWFJ2Y2lBOUlDUmpiMjUwWVdsdVpYSXVabWx1WkNoY0lqNGdkV3hjSWlrdVlYUjBjaWhjSW1SaGRHRXRiM0JsY21GMGIzSmNJaWs3WEhKY2JseDBYSFJjZEZ4MFhIUm1hV1ZzWkZaaGJDQTlJSE5sYkdZdVoyVjBUV1YwWVVOb1pXTnJZbTk0Vm1Gc0tDUm1hV1ZzWkN3Z2IzQmxjbUYwYjNJcE8xeHlYRzVjZEZ4MFhIUmNkSDFjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwWEhSbGJITmxJR2xtS0dsdWNIVjBWSGx3WlQwOVhDSnlZV1JwYjF3aUtWeHlYRzVjZEZ4MFhIUjdYSEpjYmx4MFhIUmNkRngwSkdacFpXeGtJRDBnSkdOdmJuUmhhVzVsY2k1bWFXNWtLRndpZFd3Z1BpQnNhU0JwYm5CMWREcHlZV1JwYjF3aUtUdGNjbHh1WEhSY2RGeDBYSFJjY2x4dVhIUmNkRngwWEhScFppZ2tabWxsYkdRdWJHVnVaM1JvUGpBcFhISmNibHgwWEhSY2RGeDBlMXh5WEc1Y2RGeDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQnpaV3htTG1kbGRFMWxkR0ZTWVdScGIxWmhiQ2drWm1sbGJHUXBPMXh5WEc1Y2RGeDBYSFJjZEgxY2NseHVYSFJjZEZ4MGZWeHlYRzVjZEZ4MFhIUmNjbHh1WEhSY2RGeDBabWxsYkdSV1lXd2dQU0JsYm1OdlpHVlZVa2xEYjIxd2IyNWxiblFvWm1sbGJHUldZV3dwTzF4eVhHNWNkRngwWEhScFppaDBlWEJsYjJZb0pHWnBaV3hrS1NFOVBWd2lkVzVrWldacGJtVmtYQ0lwWEhKY2JseDBYSFJjZEh0Y2NseHVYSFJjZEZ4MFhIUnBaaWdrWm1sbGJHUXViR1Z1WjNSb1BqQXBYSEpjYmx4MFhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RGeDBabWxsYkdST1lXMWxJRDBnSkdacFpXeGtMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHlYRzVjZEZ4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFhIUXZMMlp2Y2lCMGFHOXpaU0IzYUc4Z2FXNXphWE4wSUc5dUlIVnphVzVuSUNZZ1lXMXdaWEp6WVc1a2N5QnBiaUIwYUdVZ2JtRnRaU0J2WmlCMGFHVWdZM1Z6ZEc5dElHWnBaV3hrSUNnaEtWeHlYRzVjZEZ4MFhIUmNkRngwWm1sbGJHUk9ZVzFsSUQwZ0tHWnBaV3hrVG1GdFpTazdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSY2RGeHlYRzVjZEZ4MGZWeHlYRzVjZEZ4MFpXeHpaU0JwWmlodFpYUmhWSGx3WlQwOVhDSmtZWFJsWENJcFhISmNibHgwWEhSN1hISmNibHgwWEhSY2RITmxiR1l1Y0hKdlkyVnpjMUJ2YzNSRVlYUmxLQ1JqYjI1MFlXbHVaWElwTzF4eVhHNWNkRngwZlZ4eVhHNWNkRngwWEhKY2JseDBYSFJwWmloMGVYQmxiMllvWm1sbGJHUldZV3dwSVQxY0luVnVaR1ZtYVc1bFpGd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFJwWmlobWFXVnNaRlpoYkNFOVhDSmNJaWxjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RDOHZjMlZzWmk1MWNteGZZMjl0Y0c5dVpXNTBjeUFyUFNCY0lpWmNJaXRsYm1OdlpHVlZVa2xEYjIxd2IyNWxiblFvWm1sbGJHUk9ZVzFsS1N0Y0lqMWNJaXNvWm1sbGJHUldZV3dwTzF4eVhHNWNkRngwWEhSY2RITmxiR1l1ZFhKc1gzQmhjbUZ0YzF0bGJtTnZaR1ZWVWtsRGIyMXdiMjVsYm5Rb1ptbGxiR1JPWVcxbEtWMGdQU0FvWm1sbGJHUldZV3dwTzF4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSOVhISmNibHgwZlN4Y2NseHVYSFJ3Y205alpYTnpVRzl6ZEVSaGRHVTZJR1oxYm1OMGFXOXVLQ1JqYjI1MFlXbHVaWElwWEhKY2JseDBlMXh5WEc1Y2RGeDBkbUZ5SUhObGJHWWdQU0IwYUdsek8xeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdabWxsYkdSVWVYQmxJRDBnSkdOdmJuUmhhVzVsY2k1aGRIUnlLRndpWkdGMFlTMXpaaTFtYVdWc1pDMTBlWEJsWENJcE8xeHlYRzVjZEZ4MGRtRnlJR2x1Y0hWMFZIbHdaU0E5SUNSamIyNTBZV2x1WlhJdVlYUjBjaWhjSW1SaGRHRXRjMll0Wm1sbGJHUXRhVzV3ZFhRdGRIbHdaVndpS1R0Y2NseHVYSFJjZEZ4eVhHNWNkRngwZG1GeUlDUm1hV1ZzWkR0Y2NseHVYSFJjZEhaaGNpQm1hV1ZzWkU1aGJXVWdQU0JjSWx3aU8xeHlYRzVjZEZ4MGRtRnlJR1pwWld4a1ZtRnNJRDBnWENKY0lqdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MEpHWnBaV3hrSUQwZ0pHTnZiblJoYVc1bGNpNW1hVzVrS0Z3aWRXd2dQaUJzYVNCcGJuQjFkRHAwWlhoMFhDSXBPMXh5WEc1Y2RGeDBabWxsYkdST1lXMWxJRDBnSkdacFpXeGtMbUYwZEhJb1hDSnVZVzFsWENJcExuSmxjR3hoWTJVb0oxdGRKeXdnSnljcE8xeHlYRzVjZEZ4MFhISmNibHgwWEhSMllYSWdaR0YwWlhNZ1BTQmJYVHRjY2x4dVhIUmNkQ1JtYVdWc1pDNWxZV05vS0daMWJtTjBhVzl1S0NsN1hISmNibHgwWEhSY2RGeHlYRzVjZEZ4MFhIUmtZWFJsY3k1d2RYTm9LQ1FvZEdocGN5a3VkbUZzS0NrcE8xeHlYRzVjZEZ4MFhISmNibHgwWEhSOUtUdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGFXWW9KR1pwWld4a0xteGxibWQwYUQwOU1pbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBhV1lvS0dSaGRHVnpXekJkSVQxY0lsd2lLWHg4S0dSaGRHVnpXekZkSVQxY0lsd2lLU2xjY2x4dVhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdaR0YwWlhNdWFtOXBiaWhjSWl0Y0lpazdYSEpjYmx4MFhIUmNkRngwWm1sbGJHUldZV3dnUFNCbWFXVnNaRlpoYkM1eVpYQnNZV05sS0M5Y1hDOHZaeXduSnlrN1hISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RIMWNjbHh1WEhSY2RHVnNjMlVnYVdZb0pHWnBaV3hrTG14bGJtZDBhRDA5TVNsY2NseHVYSFJjZEh0Y2NseHVYSFJjZEZ4MGFXWW9aR0YwWlhOYk1GMGhQVndpWENJcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJtYVdWc1pGWmhiQ0E5SUdSaGRHVnpMbXB2YVc0b1hDSXJYQ0lwTzF4eVhHNWNkRngwWEhSY2RHWnBaV3hrVm1Gc0lEMGdabWxsYkdSV1lXd3VjbVZ3YkdGalpTZ3ZYRnd2TDJjc0p5Y3BPMXh5WEc1Y2RGeDBYSFI5WEhKY2JseDBYSFI5WEhKY2JseDBYSFJjY2x4dVhIUmNkR2xtS0hSNWNHVnZaaWhtYVdWc1pGWmhiQ2toUFZ3aWRXNWtaV1pwYm1Wa1hDSXBYSEpjYmx4MFhIUjdYSEpjYmx4MFhIUmNkR2xtS0dacFpXeGtWbUZzSVQxY0lsd2lLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MGRtRnlJR1pwWld4a1UyeDFaeUE5SUZ3aVhDSTdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MGFXWW9abWxsYkdST1lXMWxQVDFjSWw5elpsOXdiM04wWDJSaGRHVmNJaWxjY2x4dVhIUmNkRngwWEhSN1hISmNibHgwWEhSY2RGeDBYSFJtYVdWc1pGTnNkV2NnUFNCY0luQnZjM1JmWkdGMFpWd2lPMXh5WEc1Y2RGeDBYSFJjZEgxY2NseHVYSFJjZEZ4MFhIUmxiSE5sWEhKY2JseDBYSFJjZEZ4MGUxeHlYRzVjZEZ4MFhIUmNkRngwWm1sbGJHUlRiSFZuSUQwZ1ptbGxiR1JPWVcxbE8xeHlYRzVjZEZ4MFhIUmNkSDFjY2x4dVhIUmNkRngwWEhSY2NseHVYSFJjZEZ4MFhIUnBaaWhtYVdWc1pGTnNkV2NoUFZ3aVhDSXBYSEpjYmx4MFhIUmNkRngwZTF4eVhHNWNkRngwWEhSY2RGeDBMeTl6Wld4bUxuVnliRjlqYjIxd2IyNWxiblJ6SUNzOUlGd2lKbHdpSzJacFpXeGtVMngxWnl0Y0lqMWNJaXRtYVdWc1pGWmhiRHRjY2x4dVhIUmNkRngwWEhSY2RITmxiR1l1ZFhKc1gzQmhjbUZ0YzF0bWFXVnNaRk5zZFdkZElEMGdabWxsYkdSV1lXdzdYSEpjYmx4MFhIUmNkRngwZlZ4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSOVhISmNibHgwWEhSY2NseHVYSFI5TEZ4eVhHNWNkSEJ5YjJObGMzTlVZWGh2Ym05dGVUb2dablZ1WTNScGIyNG9KR052Ym5SaGFXNWxjaXdnY21WMGRYSnVYMjlpYW1WamRDbGNjbHh1WEhSN1hISmNiaUFnSUNBZ0lDQWdhV1lvZEhsd1pXOW1LSEpsZEhWeWJsOXZZbXBsWTNRcFBUMWNJblZ1WkdWbWFXNWxaRndpS1Z4eVhHNGdJQ0FnSUNBZ0lIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1WDI5aWFtVmpkQ0E5SUdaaGJITmxPMXh5WEc0Z0lDQWdJQ0FnSUgxY2NseHVYSEpjYmx4MFhIUXZMMmxtS0NsY2RGeDBYSFJjZEZ4MFhISmNibHgwWEhRdkwzWmhjaUJtYVdWc1pFNWhiV1VnUFNBa0tIUm9hWE1wTG1GMGRISW9YQ0prWVhSaExYTm1MV1pwWld4a0xXNWhiV1ZjSWlrN1hISmNibHgwWEhSMllYSWdjMlZzWmlBOUlIUm9hWE03WEhKY2JseDBYSEpjYmx4MFhIUjJZWElnWm1sbGJHUlVlWEJsSUQwZ0pHTnZiblJoYVc1bGNpNWhkSFJ5S0Z3aVpHRjBZUzF6WmkxbWFXVnNaQzEwZVhCbFhDSXBPMXh5WEc1Y2RGeDBkbUZ5SUdsdWNIVjBWSGx3WlNBOUlDUmpiMjUwWVdsdVpYSXVZWFIwY2loY0ltUmhkR0V0YzJZdFptbGxiR1F0YVc1d2RYUXRkSGx3WlZ3aUtUdGNjbHh1WEhSY2RGeHlYRzVjZEZ4MGRtRnlJQ1JtYVdWc1pEdGNjbHh1WEhSY2RIWmhjaUJtYVdWc1pFNWhiV1VnUFNCY0lsd2lPMXh5WEc1Y2RGeDBkbUZ5SUdacFpXeGtWbUZzSUQwZ1hDSmNJanRjY2x4dVhIUmNkRnh5WEc1Y2RGeDBhV1lvYVc1d2RYUlVlWEJsUFQxY0luTmxiR1ZqZEZ3aUtWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUWtabWxsYkdRZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSnpaV3hsWTNSY0lpazdYSEpjYmx4MFhIUmNkR1pwWld4a1RtRnRaU0E5SUNSbWFXVnNaQzVoZEhSeUtGd2libUZ0WlZ3aUtTNXlaWEJzWVdObEtDZGJYU2NzSUNjbktUdGNjbHh1WEhSY2RGeDBYSEpjYmx4MFhIUmNkR1pwWld4a1ZtRnNJRDBnYzJWc1ppNW5aWFJUWld4bFkzUldZV3dvSkdacFpXeGtLVHNnWEhKY2JseDBYSFI5WEhKY2JseDBYSFJsYkhObElHbG1LR2x1Y0hWMFZIbHdaVDA5WENKdGRXeDBhWE5sYkdWamRGd2lLVnh5WEc1Y2RGeDBlMXh5WEc1Y2RGeDBYSFFrWm1sbGJHUWdQU0FrWTI5dWRHRnBibVZ5TG1acGJtUW9YQ0p6Wld4bFkzUmNJaWs3WEhKY2JseDBYSFJjZEdacFpXeGtUbUZ0WlNBOUlDUm1hV1ZzWkM1aGRIUnlLRndpYm1GdFpWd2lLUzV5WlhCc1lXTmxLQ2RiWFNjc0lDY25LVHRjY2x4dVhIUmNkRngwZG1GeUlHOXdaWEpoZEc5eUlEMGdKR1pwWld4a0xtRjBkSElvWENKa1lYUmhMVzl3WlhKaGRHOXlYQ0lwTzF4eVhHNWNkRngwWEhSY2NseHVYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQnpaV3htTG1kbGRFMTFiSFJwVTJWc1pXTjBWbUZzS0NSbWFXVnNaQ3dnYjNCbGNtRjBiM0lwTzF4eVhHNWNkRngwZlZ4eVhHNWNkRngwWld4elpTQnBaaWhwYm5CMWRGUjVjR1U5UFZ3aVkyaGxZMnRpYjNoY0lpbGNjbHh1WEhSY2RIdGNjbHh1WEhSY2RGeDBKR1pwWld4a0lEMGdKR052Ym5SaGFXNWxjaTVtYVc1a0tGd2lkV3dnUGlCc2FTQnBibkIxZERwamFHVmphMkp2ZUZ3aUtUdGNjbHh1WEhSY2RGeDBhV1lvSkdacFpXeGtMbXhsYm1kMGFENHdLVnh5WEc1Y2RGeDBYSFI3WEhKY2JseDBYSFJjZEZ4MFptbGxiR1JPWVcxbElEMGdKR1pwWld4a0xtRjBkSElvWENKdVlXMWxYQ0lwTG5KbGNHeGhZMlVvSjF0ZEp5d2dKeWNwTzF4eVhHNWNkRngwWEhSY2RGeDBYSFJjZEZ4MFhIUmNkRnh5WEc1Y2RGeDBYSFJjZEhaaGNpQnZjR1Z5WVhSdmNpQTlJQ1JqYjI1MFlXbHVaWEl1Wm1sdVpDaGNJajRnZFd4Y0lpa3VZWFIwY2loY0ltUmhkR0V0YjNCbGNtRjBiM0pjSWlrN1hISmNibHgwWEhSY2RGeDBabWxsYkdSV1lXd2dQU0J6Wld4bUxtZGxkRU5vWldOclltOTRWbUZzS0NSbWFXVnNaQ3dnYjNCbGNtRjBiM0lwTzF4eVhHNWNkRngwWEhSOVhISmNibHgwWEhSOVhISmNibHgwWEhSbGJITmxJR2xtS0dsdWNIVjBWSGx3WlQwOVhDSnlZV1JwYjF3aUtWeHlYRzVjZEZ4MGUxeHlYRzVjZEZ4MFhIUWtabWxsYkdRZ1BTQWtZMjl1ZEdGcGJtVnlMbVpwYm1Rb1hDSjFiQ0ErSUd4cElHbHVjSFYwT25KaFpHbHZYQ0lwTzF4eVhHNWNkRngwWEhScFppZ2tabWxsYkdRdWJHVnVaM1JvUGpBcFhISmNibHgwWEhSY2RIdGNjbHh1WEhSY2RGeDBYSFJtYVdWc1pFNWhiV1VnUFNBa1ptbGxiR1F1WVhSMGNpaGNJbTVoYldWY0lpa3VjbVZ3YkdGalpTZ25XMTBuTENBbkp5azdYSEpjYmx4MFhIUmNkRngwWEhKY2JseDBYSFJjZEZ4MFptbGxiR1JXWVd3Z1BTQnpaV3htTG1kbGRGSmhaR2x2Vm1Gc0tDUm1hV1ZzWkNrN1hISmNibHgwWEhSY2RIMWNjbHh1WEhSY2RIMWNjbHh1WEhSY2RGeHlYRzVjZEZ4MGFXWW9kSGx3Wlc5bUtHWnBaV3hrVm1Gc0tTRTlYQ0oxYm1SbFptbHVaV1JjSWlsY2NseHVYSFJjZEh0Y2NseHVYSFJjZEZ4MGFXWW9abWxsYkdSV1lXd2hQVndpWENJcFhISmNibHgwWEhSY2RIdGNjbHh1SUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJR2xtS0hKbGRIVnlibDl2WW1wbFkzUTlQWFJ5ZFdVcFhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjdYSEpjYmlBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2NtVjBkWEp1SUh0dVlXMWxPaUJtYVdWc1pFNWhiV1VzSUhaaGJIVmxPaUJtYVdWc1pGWmhiSDA3WEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCOVhISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmxiSE5sWEhKY2JpQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNCN1hISmNiaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnTHk5elpXeG1MblZ5YkY5amIyMXdiMjVsYm5SeklDczlJRndpSmx3aUsyWnBaV3hrVG1GdFpTdGNJajFjSWl0bWFXVnNaRlpoYkR0Y2NseHVJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0J6Wld4bUxuVnliRjl3WVhKaGJYTmJabWxsYkdST1lXMWxYU0E5SUdacFpXeGtWbUZzTzF4eVhHNGdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ2ZWeHlYRzVjY2x4dVhIUmNkRngwZlZ4eVhHNWNkRngwZlZ4eVhHNWNjbHh1SUNBZ0lDQWdJQ0JwWmloeVpYUjFjbTVmYjJKcVpXTjBQVDEwY25WbEtWeHlYRzRnSUNBZ0lDQWdJSHRjY2x4dUlDQWdJQ0FnSUNBZ0lDQWdjbVYwZFhKdUlHWmhiSE5sTzF4eVhHNGdJQ0FnSUNBZ0lIMWNjbHh1WEhSOVhISmNibjA3SWwxOSIsIlxyXG5tb2R1bGUuZXhwb3J0cyA9IHtcclxuXHRcclxuXHRzZWFyY2hGb3Jtczoge30sXHJcblx0XHJcblx0aW5pdDogZnVuY3Rpb24oKXtcclxuXHRcdFxyXG5cdFx0XHJcblx0fSxcclxuXHRhZGRTZWFyY2hGb3JtOiBmdW5jdGlvbihpZCwgb2JqZWN0KXtcclxuXHRcdFxyXG5cdFx0dGhpcy5zZWFyY2hGb3Jtc1tpZF0gPSBvYmplY3Q7XHJcblx0fSxcclxuXHRnZXRTZWFyY2hGb3JtOiBmdW5jdGlvbihpZClcclxuXHR7XHJcblx0XHRyZXR1cm4gdGhpcy5zZWFyY2hGb3Jtc1tpZF07XHRcclxuXHR9XHJcblx0XHJcbn07Il19

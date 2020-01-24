/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!***********************!*\
  !*** ./src/blocks.js ***!
  \***********************/
/*! no exports provided */
/*! all exports used */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("Object.defineProperty(__webpack_exports__, \"__esModule\", { value: true });\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__block_block_js__ = __webpack_require__(/*! ./block/block.js */ 1);\n/**\n * Gutenberg Blocks\n *\n * All blocks related JavaScript files should be imported here.\n * You can create a new block folder in this dir and include code\n * for that block here as well.\n *\n * All blocks should be included here since this is the file that\n * Webpack is compiling as the input file.\n */\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9ja3MuanM/N2I1YiJdLCJzb3VyY2VzQ29udGVudCI6WyIvKipcbiAqIEd1dGVuYmVyZyBCbG9ja3NcbiAqXG4gKiBBbGwgYmxvY2tzIHJlbGF0ZWQgSmF2YVNjcmlwdCBmaWxlcyBzaG91bGQgYmUgaW1wb3J0ZWQgaGVyZS5cbiAqIFlvdSBjYW4gY3JlYXRlIGEgbmV3IGJsb2NrIGZvbGRlciBpbiB0aGlzIGRpciBhbmQgaW5jbHVkZSBjb2RlXG4gKiBmb3IgdGhhdCBibG9jayBoZXJlIGFzIHdlbGwuXG4gKlxuICogQWxsIGJsb2NrcyBzaG91bGQgYmUgaW5jbHVkZWQgaGVyZSBzaW5jZSB0aGlzIGlzIHRoZSBmaWxlIHRoYXRcbiAqIFdlYnBhY2sgaXMgY29tcGlsaW5nIGFzIHRoZSBpbnB1dCBmaWxlLlxuICovXG5cbmltcG9ydCAnLi9ibG9jay9ibG9jay5qcyc7XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9zcmMvYmxvY2tzLmpzXG4vLyBtb2R1bGUgaWQgPSAwXG4vLyBtb2R1bGUgY2h1bmtzID0gMCJdLCJtYXBwaW5ncyI6IkFBQUE7QUFBQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Iiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///0\n");

/***/ }),
/* 1 */
/*!****************************!*\
  !*** ./src/block/block.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__styles_editor_scss__ = __webpack_require__(/*! ./styles/editor.scss */ 2);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__styles_editor_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__styles_editor_scss__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__styles_style_scss__ = __webpack_require__(/*! ./styles/style.scss */ 3);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__styles_style_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__styles_style_scss__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__edit_js__ = __webpack_require__(/*! ./edit.js */ 4);\n//  Import CSS.\n\n\n\n\n\nvar __ = wp.i18n.__;\nvar registerBlockType = wp.blocks.registerBlockType;\n\n\nvar blockIcon = wp.element.createElement(\n\t'svg',\n\t{ viewBox: '0 -31 512 512' },\n\twp.element.createElement('path', { d: 'M497.094 60.004c-.031 0-.063-.004-.094-.004H361V45c0-24.813-20.188-45-45-45H196c-24.813 0-45 20.188-45 45v15H15C6.648 60 0 66.844 0 75v330c0 24.813 20.188 45 45 45h422c24.813 0 45-20.188 45-45V75.316v-.058c-.574-9.852-6.633-15.2-14.906-15.254zM181 45c0-8.27 6.73-15 15-15h120c8.27 0 15 6.73 15 15v15H181zm295.188 45l-46.583 139.742A14.975 14.975 0 0 1 415.38 240H331v-15c0-8.285-6.715-15-15-15H196c-8.285 0-15 6.715-15 15v15H96.621a14.975 14.975 0 0 1-14.226-10.258L35.813 90zM301 240v30h-90v-30zm181 165c0 8.27-6.73 15-15 15H45c-8.27 0-15-6.73-15-15V167.434l23.934 71.796A44.935 44.935 0 0 0 96.62 270H181v15c0 8.285 6.715 15 15 15h120c8.285 0 15-6.715 15-15v-15h84.379a44.935 44.935 0 0 0 42.687-30.77L482 167.434zm0 0' })\n);\n\nregisterBlockType('lf/latest-jobs', {\n\ttitle: __('Latest Jobs'),\n\ticon: {\n\t\tsrc: blockIcon\n\t},\n\tcategory: 'common',\n\tkeywords: [__('Latest Jobs'), __('Jobs'), __('Linux')],\n\tattributes: {\n\t\tquantity: {\n\t\t\ttype: 'number',\n\t\t\tdefault: 4\n\t\t}\n\t},\n\tedit: __WEBPACK_IMPORTED_MODULE_2__edit_js__[\"a\" /* default */],\n\tsave: function save() {\n\t\treturn null;\n\t}\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMS5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9jay9ibG9jay5qcz85MjFkIl0sInNvdXJjZXNDb250ZW50IjpbIi8vICBJbXBvcnQgQ1NTLlxuaW1wb3J0ICcuL3N0eWxlcy9lZGl0b3Iuc2Nzcyc7XG5pbXBvcnQgJy4vc3R5bGVzL3N0eWxlLnNjc3MnO1xuXG5pbXBvcnQgRWRpdCBmcm9tICcuL2VkaXQuanMnO1xuXG52YXIgX18gPSB3cC5pMThuLl9fO1xudmFyIHJlZ2lzdGVyQmxvY2tUeXBlID0gd3AuYmxvY2tzLnJlZ2lzdGVyQmxvY2tUeXBlO1xuXG5cbnZhciBibG9ja0ljb24gPSB3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoXG5cdCdzdmcnLFxuXHR7IHZpZXdCb3g6ICcwIC0zMSA1MTIgNTEyJyB9LFxuXHR3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoJ3BhdGgnLCB7IGQ6ICdNNDk3LjA5NCA2MC4wMDRjLS4wMzEgMC0uMDYzLS4wMDQtLjA5NC0uMDA0SDM2MVY0NWMwLTI0LjgxMy0yMC4xODgtNDUtNDUtNDVIMTk2Yy0yNC44MTMgMC00NSAyMC4xODgtNDUgNDV2MTVIMTVDNi42NDggNjAgMCA2Ni44NDQgMCA3NXYzMzBjMCAyNC44MTMgMjAuMTg4IDQ1IDQ1IDQ1aDQyMmMyNC44MTMgMCA0NS0yMC4xODggNDUtNDVWNzUuMzE2di0uMDU4Yy0uNTc0LTkuODUyLTYuNjMzLTE1LjItMTQuOTA2LTE1LjI1NHpNMTgxIDQ1YzAtOC4yNyA2LjczLTE1IDE1LTE1aDEyMGM4LjI3IDAgMTUgNi43MyAxNSAxNXYxNUgxODF6bTI5NS4xODggNDVsLTQ2LjU4MyAxMzkuNzQyQTE0Ljk3NSAxNC45NzUgMCAwIDEgNDE1LjM4IDI0MEgzMzF2LTE1YzAtOC4yODUtNi43MTUtMTUtMTUtMTVIMTk2Yy04LjI4NSAwLTE1IDYuNzE1LTE1IDE1djE1SDk2LjYyMWExNC45NzUgMTQuOTc1IDAgMCAxLTE0LjIyNi0xMC4yNThMMzUuODEzIDkwek0zMDEgMjQwdjMwaC05MHYtMzB6bTE4MSAxNjVjMCA4LjI3LTYuNzMgMTUtMTUgMTVINDVjLTguMjcgMC0xNS02LjczLTE1LTE1VjE2Ny40MzRsMjMuOTM0IDcxLjc5NkE0NC45MzUgNDQuOTM1IDAgMCAwIDk2LjYyIDI3MEgxODF2MTVjMCA4LjI4NSA2LjcxNSAxNSAxNSAxNWgxMjBjOC4yODUgMCAxNS02LjcxNSAxNS0xNXYtMTVoODQuMzc5YTQ0LjkzNSA0NC45MzUgMCAwIDAgNDIuNjg3LTMwLjc3TDQ4MiAxNjcuNDM0em0wIDAnIH0pXG4pO1xuXG5yZWdpc3RlckJsb2NrVHlwZSgnbGYvbGF0ZXN0LWpvYnMnLCB7XG5cdHRpdGxlOiBfXygnTGF0ZXN0IEpvYnMnKSxcblx0aWNvbjoge1xuXHRcdHNyYzogYmxvY2tJY29uXG5cdH0sXG5cdGNhdGVnb3J5OiAnY29tbW9uJyxcblx0a2V5d29yZHM6IFtfXygnTGF0ZXN0IEpvYnMnKSwgX18oJ0pvYnMnKSwgX18oJ0xpbnV4JyldLFxuXHRhdHRyaWJ1dGVzOiB7XG5cdFx0cXVhbnRpdHk6IHtcblx0XHRcdHR5cGU6ICdudW1iZXInLFxuXHRcdFx0ZGVmYXVsdDogNFxuXHRcdH1cblx0fSxcblx0ZWRpdDogRWRpdCxcblx0c2F2ZTogZnVuY3Rpb24gc2F2ZSgpIHtcblx0XHRyZXR1cm4gbnVsbDtcblx0fVxufSk7XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9zcmMvYmxvY2svYmxvY2suanNcbi8vIG1vZHVsZSBpZCA9IDFcbi8vIG1vZHVsZSBjaHVua3MgPSAwIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///1\n");

/***/ }),
/* 2 */
/*!**************************************!*\
  !*** ./src/block/styles/editor.scss ***!
  \**************************************/
/*! dynamic exports provided */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMi5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9jay9zdHlsZXMvZWRpdG9yLnNjc3M/MDJkZSJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyByZW1vdmVkIGJ5IGV4dHJhY3QtdGV4dC13ZWJwYWNrLXBsdWdpblxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vc3JjL2Jsb2NrL3N0eWxlcy9lZGl0b3Iuc2Nzc1xuLy8gbW9kdWxlIGlkID0gMlxuLy8gbW9kdWxlIGNodW5rcyA9IDAiXSwibWFwcGluZ3MiOiJBQUFBIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///2\n");

/***/ }),
/* 3 */
/*!*************************************!*\
  !*** ./src/block/styles/style.scss ***!
  \*************************************/
/*! dynamic exports provided */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9jay9zdHlsZXMvc3R5bGUuc2Nzcz9lYTQzIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luXG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9zcmMvYmxvY2svc3R5bGVzL3N0eWxlLnNjc3Ncbi8vIG1vZHVsZSBpZCA9IDNcbi8vIG1vZHVsZSBjaHVua3MgPSAwIl0sIm1hcHBpbmdzIjoiQUFBQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///3\n");

/***/ }),
/* 4 */
/*!***************************!*\
  !*** ./src/block/edit.js ***!
  \***************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("var __ = wp.i18n.__;\n\nvar _ref = wp.blockEditor || wp.editor,\n    InspectorControls = _ref.InspectorControls;\n\nvar _wp$components = wp.components,\n    RangeControl = _wp$components.RangeControl,\n    PanelBody = _wp$components.PanelBody;\n\n\n/* harmony default export */ __webpack_exports__[\"a\"] = (function (props) {\n\tvar attributes = props.attributes,\n\t    setAttributes = props.setAttributes;\n\tvar quantity = attributes.quantity;\n\n\n\treturn [wp.element.createElement(\n\t\tInspectorControls,\n\t\t{ key: 'lf-latest-block-panel' },\n\t\twp.element.createElement(\n\t\t\tPanelBody,\n\t\t\t{ title: __('Settings') },\n\t\t\twp.element.createElement(RangeControl, {\n\t\t\t\tlabel: __('Quantity'),\n\t\t\t\tmin: 1,\n\t\t\t\tmax: 10,\n\t\t\t\tvalue: quantity,\n\t\t\t\tonChange: function onChange(value) {\n\t\t\t\t\treturn setAttributes({ quantity: value });\n\t\t\t\t}\n\t\t\t})\n\t\t)\n\t), wp.element.createElement(\n\t\t'div',\n\t\t{ className: 'description', key: 'lf-latest-jobs' },\n\t\twp.element.createElement(\n\t\t\t'i',\n\t\t\tnull,\n\t\t\t'This block will add the latest jobs section.'\n\t\t)\n\t)];\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9jay9lZGl0LmpzPzNmZTEiXSwic291cmNlc0NvbnRlbnQiOlsidmFyIF9fID0gd3AuaTE4bi5fXztcblxudmFyIF9yZWYgPSB3cC5ibG9ja0VkaXRvciB8fCB3cC5lZGl0b3IsXG4gICAgSW5zcGVjdG9yQ29udHJvbHMgPSBfcmVmLkluc3BlY3RvckNvbnRyb2xzO1xuXG52YXIgX3dwJGNvbXBvbmVudHMgPSB3cC5jb21wb25lbnRzLFxuICAgIFJhbmdlQ29udHJvbCA9IF93cCRjb21wb25lbnRzLlJhbmdlQ29udHJvbCxcbiAgICBQYW5lbEJvZHkgPSBfd3AkY29tcG9uZW50cy5QYW5lbEJvZHk7XG5cblxuZXhwb3J0IGRlZmF1bHQgKGZ1bmN0aW9uIChwcm9wcykge1xuXHR2YXIgYXR0cmlidXRlcyA9IHByb3BzLmF0dHJpYnV0ZXMsXG5cdCAgICBzZXRBdHRyaWJ1dGVzID0gcHJvcHMuc2V0QXR0cmlidXRlcztcblx0dmFyIHF1YW50aXR5ID0gYXR0cmlidXRlcy5xdWFudGl0eTtcblxuXG5cdHJldHVybiBbd3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFxuXHRcdEluc3BlY3RvckNvbnRyb2xzLFxuXHRcdHsga2V5OiAnbGYtbGF0ZXN0LWJsb2NrLXBhbmVsJyB9LFxuXHRcdHdwLmVsZW1lbnQuY3JlYXRlRWxlbWVudChcblx0XHRcdFBhbmVsQm9keSxcblx0XHRcdHsgdGl0bGU6IF9fKCdTZXR0aW5ncycpIH0sXG5cdFx0XHR3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoUmFuZ2VDb250cm9sLCB7XG5cdFx0XHRcdGxhYmVsOiBfXygnUXVhbnRpdHknKSxcblx0XHRcdFx0bWluOiAxLFxuXHRcdFx0XHRtYXg6IDEwLFxuXHRcdFx0XHR2YWx1ZTogcXVhbnRpdHksXG5cdFx0XHRcdG9uQ2hhbmdlOiBmdW5jdGlvbiBvbkNoYW5nZSh2YWx1ZSkge1xuXHRcdFx0XHRcdHJldHVybiBzZXRBdHRyaWJ1dGVzKHsgcXVhbnRpdHk6IHZhbHVlIH0pO1xuXHRcdFx0XHR9XG5cdFx0XHR9KVxuXHRcdClcblx0KSwgd3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFxuXHRcdCdkaXYnLFxuXHRcdHsgY2xhc3NOYW1lOiAnZGVzY3JpcHRpb24nLCBrZXk6ICdsZi1sYXRlc3Qtam9icycgfSxcblx0XHR3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoXG5cdFx0XHQnaScsXG5cdFx0XHRudWxsLFxuXHRcdFx0J1RoaXMgYmxvY2sgd2lsbCBhZGQgdGhlIGxhdGVzdCBqb2JzIHNlY3Rpb24uJ1xuXHRcdClcblx0KV07XG59KTtcblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3NyYy9ibG9jay9lZGl0LmpzXG4vLyBtb2R1bGUgaWQgPSA0XG4vLyBtb2R1bGUgY2h1bmtzID0gMCJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///4\n");

/***/ })
/******/ ]);
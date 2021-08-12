/**
 * @module
 * @exports ready
 * @description The core dispatcher for the dom ready event in javascript.
 */

import common from 'common';

const ready = ( fn ) => {
	if ( document.readyState !== 'loading' ) {
		fn();
	} else if ( document.addEventListener ) {
		document.addEventListener( 'DOMContentLoaded', fn );
	} else {
		document.attachEvent( 'onreadystatechange', () => {
			if ( document.readyState !== 'loading' ) {
				fn();
			}
		} );
	}
};

/**
 * @function bindEvents
 * @description Bind global event listeners here,
 */

const bindEvents = () => {};

/**
 * @function init
 * @description The core dispatcher for init across the codebase.
 */

const init = () => {
	// initialize global events

	bindEvents();

	// initialize common modules

	common();

	// initialize admin modules

	console.info(
		'Gravity Forms Admin: Initialized all javascript that targeted document ready.'
	);
};

/**
 * @function domReady
 * @description Export our dom ready enabled init.
 */

const domReady = () => {
	ready( init );
};

export default domReady;

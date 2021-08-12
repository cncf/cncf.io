const config = require( '../config' );

module.exports = {
	'scripts-theme': [
		'core-js/modules/es.array.iterator',
		`${ config.paths.src }/theme/index.js`,
	],
};

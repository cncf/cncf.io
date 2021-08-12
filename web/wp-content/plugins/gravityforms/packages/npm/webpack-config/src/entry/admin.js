const config = require( '../config' );

module.exports = {
	'scripts-admin': [
		'core-js/modules/es.array.iterator',
		`${ config.paths.src }/admin/index.js`,
	],
};

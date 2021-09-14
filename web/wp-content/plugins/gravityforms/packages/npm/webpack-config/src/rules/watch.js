const scripts = require( './scripts' );

scripts.use.push( {
	loader: 'ifdef-loader',
	options: {
		'INCLUDEREACT': false,
		'version': 3,
		'ifdef-verbose': true,
		'ifdef-triple-slash': false,
	},
} );

module.exports = [
	scripts,
];

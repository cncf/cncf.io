/**
 * External Dependencies
 */
const path = require( 'path' );
const webpack = require( 'webpack' );
const config = require( '../config' );

/**
 * Internal Dependencies
 */
const rules = require( '../rules' );

module.exports = {
	resolve: {
		extensions: [ '.js', '.jsx', '.json', '.pcss' ],
	},
	resolveLoader: {
		modules: [
			path.resolve( `${ __dirname }/../../`, 'node_modules' ),
			config.paths.modules
		],
	},
	module: {
		rules,
	},
	plugins: [
		new webpack.IgnorePlugin( {
			resourceRegExp: /^\.\/locale$/,
			contextRegExp: /moment$/,
		} ),
	],
};

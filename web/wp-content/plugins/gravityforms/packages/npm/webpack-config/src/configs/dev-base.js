/**
 * External Dependencies
 */
const webpack = require( 'webpack' );
const merge = require( 'webpack-merge' );
const config = require( '../config' );

/**
 * Internal Dependencies
 */
const base = require( './base.js' );
const output = merge( {
	filename: '[name].js',
	chunkFilename: '[name].[chunkhash].js',
}, config.overrides.output );

module.exports = merge.strategy( {
	plugins: 'append',
} )( base, {
	cache: true,
	mode: 'development',
	output,
	devtool: 'eval-source-map',
	plugins: [
		new webpack.LoaderOptionsPlugin( {
			debug: true,
		} ),
	],
	optimization: {
		noEmitOnErrors: true, // NoEmitOnErrorsPlugin
		concatenateModules: true, //ModuleConcatenationPlugin
	},
} );

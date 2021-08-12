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
const minimizer = require( '../optimization/minimizer' );
const output =  merge( {
	filename: '[name].min.js',
	chunkFilename: '[name].[chunkhash].min.js',
}, config.overrides.output );

module.exports = merge.strategy( {
	plugins: 'append',
} )( base, {
	cache: false,
	mode: 'production',
	devtool: false,
	output,
	plugins: [
		new webpack.DefinePlugin( {
			'process.env': { NODE_ENV: JSON.stringify( 'production' ) },
		} ),
		new webpack.LoaderOptionsPlugin( {
			debug: false,
		} ),
	],
	optimization: {
		noEmitOnErrors: true, // NoEmitOnErrorsPlugin
		concatenateModules: true, //ModuleConcatenationPlugin
		minimizer,
	},
} );

/**
 * External Dependencies
 */
const merge = require( 'webpack-merge' );
const BundleAnalyzerPlugin = require( 'webpack-bundle-analyzer' ).BundleAnalyzerPlugin;

/**
 * Internal Dependencies
 */
const prodBase = require( './configs/prod-base.js' );
const entry = require( './entry/admin' );
const externals = require( './externals/admin' );
const sc = require( './optimization/split-chunks' );
const config = require( './config' );

module.exports = merge.strategy( {
	optimization: 'append',
	plugins: 'append',
} )( prodBase, {
	entry,
	externals,
	optimization: {
		splitChunks: sc.scAdmin,
	},
	output: {
		path: config.paths.dist,
	},
	plugins: [
		new BundleAnalyzerPlugin( {
			analyzerMode: 'static',
			reportFilename: config.paths.reports.replace( '%s', 'admin-bundle-prod' ),
			openAnalyzer: false,
		} ),
	],
} );

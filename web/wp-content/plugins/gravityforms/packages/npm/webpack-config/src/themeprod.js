/**
 * External Dependencies
 */
const merge = require( 'webpack-merge' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const BundleAnalyzerPlugin = require( 'webpack-bundle-analyzer' ).BundleAnalyzerPlugin;

/**
 * Internal Dependencies
 */
const prodBase = require( './configs/prod-base.js' );
const entry = require( './entry/theme' );
const externals = require( './externals/theme' );
const sc = require( './optimization/split-chunks' );
const config = require( './config' );

module.exports = merge.strategy( {
	optimization: 'append',
	plugins: 'append',
} )(
	prodBase,
	{
		entry,
		externals,
		optimization: {
			splitChunks: sc.scTheme,
		},
		output: {
			path: config.paths.dist,
		},
		plugins: [
			new BundleAnalyzerPlugin( {
				analyzerMode: 'static',
				reportFilename: config.paths.reports.replace( '%s', 'theme-bundle-prod' ),
				openAnalyzer: false,
			} ),
		],
	}
);

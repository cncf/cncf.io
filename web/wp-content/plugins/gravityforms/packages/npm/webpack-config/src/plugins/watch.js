const path = require( 'path' );
const WatchExternalFilesPlugin = require( 'webpack-watch-files-plugin' ).default;
const config = require( '../config' );

module.exports = {
	theme: [
		new WatchExternalFilesPlugin( {
			files: [
				`${ config.paths.src }common/**/*.js`,
				`${ config.paths.src }utils/**/*.js`,
			]
		} ),

	],
	admin: [
		new WatchExternalFilesPlugin( {
			files: [
				`${ config.paths.src }common/**/*.js`,
				`${ config.paths.src }utils/**/*.js`,
			]
		} ),
	],
};

const merge = require( 'webpack-merge' );

const config = require( '../../config' );

module.exports = merge( {
	jquery: 'jQuery',
}, config.overrides.externals.theme );

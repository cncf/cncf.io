const merge = require( 'webpack-merge' );

const wordpress = require( './wordpress' );
const vendor = require( './vendor' );
const config = require( '../../config' );

module.exports = merge( {
	...wordpress,
	...vendor,
}, config.overrides.externals.admin );

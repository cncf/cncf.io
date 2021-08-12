const merge = require( 'webpack-merge' );
const findConfig = require( 'find-config' );
const defaults = require( './defaults' );

const configModule = findConfig.require( 'gravityforms.config', { module: true } );
const config = configModule?.webpackConfig || {};

module.exports = merge( defaults, config );

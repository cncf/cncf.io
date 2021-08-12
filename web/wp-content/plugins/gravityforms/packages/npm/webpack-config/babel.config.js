const merge = require( 'webpack-merge' );
const { resolve } = require( 'path' );
const config = require( './src/config' );
const aliasConfig = config.alias || {};

const defaultAlias = {
	'admin/config':  resolve( `${ __dirname }/../../../`, 'assets/js/src/admin/config' ),
	'admin/templates':  resolve( `${ __dirname }/../../../`, 'assets/js/src/admin/templates' ),
	common: resolve( `${ __dirname }/../../../`, 'assets/js/src/common' ),
	'common/templates':  resolve( `${ __dirname }/../../../`, 'assets/js/src/common/templates' ),
	'theme/config':  resolve( `${ __dirname }/../../../`, 'assets/js/src/theme/config' ),
	'theme/templates':  resolve( `${ __dirname }/../../../`, 'assets/js/src/theme/templates' ),
};

module.exports = {
	presets: [
		'@babel/preset-react',
		[
			'@babel/preset-env',
			{
				useBuiltIns: 'entry',
				modules: false,
				corejs: '3.1',
			},
		],
	],
	plugins: [
		'lodash',
		[
			'module-resolver',
			{
				alias: merge( defaultAlias, aliasConfig ),
			},
		],

		'@babel/plugin-proposal-optional-chaining',
		'@babel/plugin-transform-runtime',
		'@babel/plugin-proposal-object-rest-spread',
		'@babel/plugin-syntax-dynamic-import',
		'@babel/plugin-transform-regenerator',
		'@babel/plugin-proposal-class-properties',
		'@babel/plugin-transform-object-assign',
	],
	env: {
		test: {
			presets: [
				[
					'@babel/preset-env',
					{
						useBuiltIns: 'entry',
						modules: 'commonjs',
						corejs: '3.1',
					},
				],
			],
			plugins: ['istanbul'],
		},
	},
};

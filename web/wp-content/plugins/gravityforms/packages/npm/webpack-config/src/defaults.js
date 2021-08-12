const { resolve } = require( 'path' );

module.exports = {
	alias: {},
	paths: {
		src: resolve( `${ __dirname }/../../../../`, 'assets/js/src/'),
		dist: resolve( `${ __dirname }/../../../../`, 'assets/js/dist/' ),
		modules: resolve( `${ __dirname }/../../../../`, 'node_modules' ),
		reports: resolve( `${ __dirname }/../../../../`, 'reports/webpack-%s.html' ),
	},
	overrides: {
		externals: {
			admin: {
				'gform-admin-config': 'gform_admin_config',
				'gform-admin-i18n': 'gform_admin_i18n',
			},
			theme: {
				'gform-theme-config': 'gform_theme_config',
				'gform-theme-i18n': 'gform_theme_i18n',
			},
		},
		output: {
			uniqueName: 'gravityforms',
		},
		plugins: {
			admin: {
				dev: [],
				prod: [],
			},
			theme: {
				dev: [],
				prod: [],
			}
		}
	},
}

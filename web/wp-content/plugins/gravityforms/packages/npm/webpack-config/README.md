# Gravity Forms Webpack Config

[Webpack](https://github.com/webpack/webpack) configurations and custom babel configuration for Gravity Forms JavaScript development.

## Installation

Install the module

```bash
npm install @gravityforms/webpack-config --save-dev
```

**Note**: This package requires `node` 14.15.0 or later, and `npm` 6.14.8 or later.

## Overview

This configuration is tailored for use on Gravity Forms projects, but may be useful to others. It abstracts away the complex Webpack configuration we use, so it can be utilized by our add on repos along with the core plugin as needed from one managed package.

It is opinionated in one main way: A single admin and single theme bundle is output, to match the contexts which WordPress presents. Code splitting is used to keep the core enqueue for each context minimal.

## Usage

This config provides 4 main npm scripts to run:

```json
"js:theme:dev": "cross-env NODE_ENV=themedev BROWSERSLIST_ENV=theme npx webpack",
"js:admin:dev": "cross-env NODE_ENV=admindev BROWSERSLIST_ENV=admin npx webpack",
"js:theme:prod": "cross-env NODE_ENV=themeprod BROWSERSLIST_ENV=theme npx webpack",
"js:admin:prod": "cross-env NODE_ENV=adminprod BROWSERSLIST_ENV=admin npx webpack"
```

Each one produces the admin and theme dev and prod bundles respectively. ev bundles use `eval-source-map` for quality browser source mapping for modules, so don't be concerned by their output size, it's due to that.

To call these scripts from your project, place this in your package json in the scripts object:

```json
"js:theme:dev": "cd node_modules/@gravityforms/webpack-config && npm run js:theme:dev",
```

Map each of the four tasks that way. Changing directories into the package directory is needed for now.

Output files default to being output in `assets/js/dist` as `scripts-admin.js`, `vendor-admin.js`, `scripts-theme.js` and `vendor-theme.js` with `.min` equivalents for the production variants. Vendor files contain all imported node_modules sourced third party libraries.

To customize your output and the webpack configuration, place a `gravityform.config.js` file in your project root. The webpack config can be modified like so:

```js
const { resolve } = require( 'path' );

module.exports = {
	webpackConfig: {
		alias: {
			common: resolve( __dirname, 'assets/js/src/common'),
		},
		paths: {
			src: resolve( __dirname, 'assets/js/src/'),
			dist: resolve( __dirname, 'assets/js/dist/'),
			reports: resolve( __dirname, 'reports/webpack-%s.html' ),
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
		},
	}
}
```

The `alias` section allows you to pass custom short paths to the babel module resolver plugin so webpack uses them for module resolution. `paths` allows you to change source and output directories. `overrides` allows for tweaking of the actual webpack config internals, and will be extended much more shortly.



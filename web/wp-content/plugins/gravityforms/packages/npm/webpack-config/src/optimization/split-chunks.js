module.exports = {
	scTheme: {
		minSize: 50,
		cacheGroups: {
			vendor: {
				test: /[\\/]node_modules[\\/]/,
				name: 'vendor-theme',
				chunks: 'all',
			},
		},
	},
	scAdmin: {
		minSize: 50,
		cacheGroups: {
			vendor: {
				test: /[\\/]node_modules[\\/]/,
				name: 'vendor-admin',
				chunks: 'all',
			},
		},
	},
};

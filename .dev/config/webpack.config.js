/**
 * Webpack Configuration
 */
const paths                = require( './paths' );
const defaultConfig        = require("@wordpress/scripts/config/webpack.config");
const FileManagerPlugin    = require('filemanager-webpack-plugin');
const glob                 = require("glob");
const lodash               = require("lodash");
const entryPoint           = {};
var mode                   = 'development';

//remove CleanWebpackPlugin from default settings
const CleanWebpackPluginKey =  lodash.findIndex( defaultConfig.plugins, ['dangerouslyAllowCleanPatternsOutsideProject', false] )
defaultConfig.plugins.splice( CleanWebpackPluginKey, 1 );

//Disable creating sourcemap file
if ( process.env.NODE_ENV == 'development' ) {
	defaultConfig.devtool = false;
}

if ( process.env.NODE_ENV == 'production' ) {
	mode = 'production';
} 

// options is optional
const gStyleScss = glob.sync(`${paths.gSrc}/**/*(style.scss)`)
	.reduce(function(acc, path) {
		acc.push(path);

		return acc;
	}, []) 

entryPoint['./dist/style']  = gStyleScss;
entryPoint['./dist/blocks'] = [paths.gBlocksMain];

// Export configuration.
const Modules = {
	...defaultConfig,
	mode: mode,
	entry: entryPoint,
	output: {
		pathinfo: true,
		path: paths.pluginRoot,
		publicPath: '/',
		filename: '[name].js'
	},

	optimization: {
	    splitChunks: {
	    	chunks: 'async',
     	},
    },

	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules
		]
	},

	// Add plugins.
	plugins: [
		...defaultConfig.plugins,
	    new FileManagerPlugin({
	    	events: {
				onEnd: {
					delete: [
						//"./dist/*.map",
						`./dist/*(
							|editor.asset.php|style.asset.php|style.js|
							|app-style.asset.php|app-style.js|
							|theme.asset.php|theme.js|
							|editor.js|common.asset.php|common.js|plumber.asset.php|
							|grid.js|grid.asset.php|contact-form.asset.php|
							|bootstrap.js|bootstrap.asset.php|
							|flex.js|flex.asset.php|
						)`,
						`./dist/js/*(
							|contact-form.asset.php|
						)`
					],
					copy: [
				        { 
				          	source: `${paths.gSrc}/js`, 
				          	destination: './dist/js' 
				        }
			        ]
				}
			}
			
		})
	]
};

module.exports = [Modules];

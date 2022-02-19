/**
 * Webpack Configuration
 */

const path              = require( 'path' );
const fs                = require( 'fs' );
const defaultConfig     = require("@wordpress/scripts/config/webpack.config");
const FileManagerPlugin = require('filemanager-webpack-plugin');
const glob              = require("glob");
const lodash            = require("lodash");
const shell             = require('shelljs');
const entryPoint        = {};
var mode                = 'development';

// Make sure any symlinks in the project folder are resolved:
const pluginDir    = fs.realpathSync( process.cwd() );
const gutenBergDir = fs.realpathSync( process.cwd() + '/modules/gutenberg' );

const pluginPath    = relativePath => path.resolve( pluginDir, relativePath );
const gutenBergPath = relativePath => path.resolve( gutenBergDir, relativePath );

const paths = {
	gSrc: gutenBergPath( 'src' ), // g src folder path.
	gBlocksMain: gutenBergPath( 'src/blocks.js' ),
	gDist: gutenBergPath( 'dist' ),
	gComponents: gutenBergPath( 'src/components' ),
	gJs: gutenBergPath( 'src/js' ),
	gRoot: gutenBergPath( '.' ),
	pluginRoot: pluginPath( '.' ) // We are in ./dist folder already so the path '.' resolves to ./dist/.
};

// Remove existance dist direcoty
shell.rm('-rf', paths.gDist);

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
const gutbenbergWebpack = {
	...defaultConfig,
	mode: mode,
	entry: entryPoint,
	output: {
		pathinfo: true,
		path: paths.gRoot,
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
						`${paths.gDist}/*(
							|editor.asset.php|style.asset.php|style.js|
							|app-style.asset.php|app-style.js|
							|theme.asset.php|theme.js|
							|editor.js|common.asset.php|common.js|plumber.asset.php|
							|grid.js|grid.asset.php|contact-form.asset.php|
							|bootstrap.js|bootstrap.asset.php|
							|flex.js|flex.asset.php|
						)`,
						`${paths.gDist}/js/*(
							|contact-form.asset.php|
						)`
					],
					copy: [
				        { 
				          	source: `${paths.gSrc}/js`, 
				          	destination: `${paths.gRoot}/dist/js` 
				        }
			        ]
				}
			}
			
		})
	]
};

module.exports = gutbenbergWebpack;

/**
 * Paths
 *
 * Project related paths.
 */

const path = require( 'path' );
const fs   = require( 'fs' );

// Make sure any symlinks in the project folder are resolved:
const pluginDir    = fs.realpathSync( process.cwd() );
const gutenBergDir = fs.realpathSync( process.cwd() + '/modules/gutenberg' );

const pluginPath    = relativePath => path.resolve( pluginDir, relativePath );
const gutenBergPath = relativePath => path.resolve( gutenBergDir, relativePath );

// Config after eject: we're in ./config/
const paths = {
	gSrc: gutenBergPath( 'src' ), // g src folder path.
	gBlocksMain: gutenBergPath( 'src/blocks.js' ),
	gDist: gutenBergPath( './dist' ),
	gBlocksStyle: gutenBergPath( './src/style.scss' ),
	gBlocksEditor: gutenBergPath( './src/editor.scss' ),
	gComponents: gutenBergPath( './src/components' ),
	gJs: gutenBergPath( './src/js' ),
	gRoot: gutenBergPath( '.' ),
	pluginRoot: pluginPath( '.' ) // We are in ./dist folder already so the path '.' resolves to ./dist/.
};

module.exports = paths;
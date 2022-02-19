/**
 * Webpack Configuration
 */
const path         = require( 'path' );
const fs           = require( 'fs' );
const pluginDir    = fs.realpathSync( process.cwd() );
const guentbergDir = fs.realpathSync( process.cwd() + '/modules/gutenberg' );



const gWebpackConfig = require( `${guentbergDir}/webpack.config.js` )

module.exports = [gWebpackConfig];

/**
 * Start
 *
 * The Shop-Maker-Block CLI starts here.
 *
 */
'use strict';

const start = require( '../config/webpack.config.js' );

const paths = require( './../config/paths' );
const shell = require('shelljs');

shell.rm('-rf', paths.pluginDist);

module.exports = start;
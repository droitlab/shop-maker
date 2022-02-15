<?php
/**
 * Plugin Name: Shop Maker
 * Plugin URI: https://droitlab.com/
 * Description: Shop Maker based on WooCommerce.
 * Version: 0.1
 * Author: DroitLab
 * Author URI: https://droitlab.com
 * Text Domain: shop-maker
 * Requires at least: 5.6
 * Requires PHP: 7.0
 *
 * @package ShopMaker
 */

/**
 * Copyright (c) 2013 James J. Meyer (email: raj.ornob@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 * **********************************************************************
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'SH_MAKER_PLUGIN_FILE' ) ) {
	define( 'SH_MAKER_PLUGIN_FILE', __FILE__ );
}

// Load core packages and the autoloader.
require __DIR__ . '/vendor/autoload.php';

/**
 * Returns the main instance of WC.
 *
 * @since  2.1
 * @return WooCommerce
 */
function sh_maker() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return \Sh_Maker\DroitLab::instance();
}

// Global for backwards compatibility.
$GLOBALS['sh_maker'] = sh_maker();


<?php
/**
 * ShopMaker Modules.
 *
 * @class    Modules
 * @package  ShopMaker\Admin
 * @version  [SH_MAKER_VERSION]
 */

namespace ShopMaker\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * ShopMaker Modules Slass.
 */
class Modules {

	/**
	 * The single instance of the class.
	 *
	 * @since [SH_MAKER_VERSION]
	 * @var Menus
	 */
	private static $_instance;

	/**
	 * Main Shop_Maker Instance.
	 *
	 * Ensures only one instance of Shop_Maker is loaded or can be loaded.
	 *
	 * @since [SH_MAKER_VERSION]
	 * @static
	 * @return Menus - Main instance.
	 */
	public static function instance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Handles output of the modules page in admin.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function output() {
		sh_maker_admin_modules_settings();
	}
}

<?php
/**
 * Shop Maker Gutenberg Module.
 *
 * @class    Gutenberg
 * @package  ShopMaker\Gutenberg
 * @version  [SH_MAKER_VERSION]
 */

namespace ShopMaker\Gutenberg;

defined( 'ABSPATH' ) || exit;

/**
 * Main Gutenberg Class.
 *
 * @class Gutenberg
 */
final class Gutenberg {

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
	 * Gutenberg Constructor.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function includes() {

	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	private function init_hooks() {

	}

	/**
	 * Define Gutenberg Constants.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	private function define_constants() {

	}

	/**
	 * Define constant if not already set.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 *
	 * @return void
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
}

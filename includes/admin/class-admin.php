<?php
/**
 * ShopMaker Admin.
 *
 * @version [SH_MAKER_VERSION]
 *
 * @package ShopMaker\Admin
 */

namespace ShopMaker\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * ShopMaker Admin Class.
 */
class Admin {

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
	 * Class init.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
	}

	/**
	 * Include any classes we need within admin.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function includes() {
		// Module settings helper functions.
		require_once SH_MAKER_ABSPATH . '/includes/admin/helper/modules.php';

		\ShopMaker\Admin\Menus::instance();
	}

}



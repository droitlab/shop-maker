<?php
/**
 * Setup menus in WP admin.
 *
 * @version [SH_MAKER_VERSION]
 *
 * @package ShopMaker\Admin
 */

namespace ShopMaker\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * ShopMaker Menus Class.
 */
class Menus {

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
	 * Hook in tabs.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function __construct() {
		// Add menus.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
		add_action( 'admin_menu', array( $this, 'modules_menu' ), 20 );

	}

	/**
	 * Add root menu item.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function admin_menu() {
		global $menu;

		$frontrom_icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDI0IDEwMjQiPjxwYXRoIGZpbGw9IiNhMmFhYjIiIGQ9Ik02MTIuMTkyIDQyNi4zMzZjMC02Ljg5Ni0zLjEzNi01MS42LTI4LTUxLjYtMzcuMzYgMC00Ni43MDQgNzIuMjU2LTQ2LjcwNCA4Mi42MjQgMCAzLjQwOCAzLjE1MiA1OC40OTYgMjguMDMyIDU4LjQ5NiAzNC4xOTItLjAzMiA0Ni42NzItNzIuMjg4IDQ2LjY3Mi04OS41MnptMjAyLjE5MiAwYzAtNi44OTYtMy4xNTItNTEuNi0yOC4wMzItNTEuNi0zNy4yOCAwLTQ2LjYwOCA3Mi4yNTYtNDYuNjA4IDgyLjYyNCAwIDMuNDA4IDMuMDcyIDU4LjQ5NiAyNy45NTIgNTguNDk2IDM0LjE5Mi0uMDMyIDQ2LjY4OC03Mi4yODggNDYuNjg4LTg5LjUyek0xNDEuMjk2Ljc2OGMtNjguMjI0IDAtMTIzLjUwNCA1NS40ODgtMTIzLjUwNCAxMjMuOTJ2NjUwLjcyYzAgNjguNDMyIDU1LjI5NiAxMjMuOTIgMTIzLjUwNCAxMjMuOTJoMzM5LjgwOGwxMjMuNTA0IDEyMy45MzZWODk5LjMyOGgyNzguMDQ4YzY4LjIyNCAwIDEyMy41Mi01NS40NzIgMTIzLjUyLTEyMy45MnYtNjUwLjcyYzAtNjguNDMyLTU1LjI5Ni0xMjMuOTItMTIzLjUyLTEyMy45MmgtNzQxLjM2em01MjYuODY0IDQyMi4xNmMwIDU1LjA4OC0zMS4wODggMTU0Ljg4LTEwMi42NCAxNTQuODgtNi4yMDggMC0xOC40OTYtMy42MTYtMjUuNDI0LTYuMDE2LTMyLjUxMi0xMS4xNjgtNTAuMTkyLTQ5LjY5Ni01Mi4zNTItNjYuMjU2IDAgMC0zLjA3Mi0xNy43OTItMy4wNzItNDAuNzUyIDAtMjIuOTkyIDMuMDcyLTQ1LjMyOCAzLjA3Mi00NS4zMjggMTUuNTUyLTc1LjcyOCA0My41NTItMTA2LjczNiA5Ni40NDgtMTA2LjczNiA1OS4wNzItLjAzMiA4My45NjggNTguNTI4IDgzLjk2OCAxMTAuMjA4ek00ODYuNDk2IDMwMi40YzAgMy4zOTItNDMuNTUyIDE0MS4xNjgtNDMuNTUyIDIxMy40MjR2NzUuNzEyYy0yLjU5MiAxMi4wOC00LjE2IDI0LjE0NC0yMS44MjQgMjQuMTQ0LTQ2LjYwOCAwLTg4Ljg4LTE1MS40NzItOTIuMDE2LTE2MS44NC02LjIwOCA2Ljg5Ni02Mi4yNCAxNjEuODQtOTYuNDQ4IDE2MS44NC0yNC44NjQgMC00My41NTItMTEzLjY0OC00Ni42MDgtMTIzLjkzNkMxNzYuNzA0IDQzNi42NzIgMTYwIDMzNC4yMjQgMTYwIDMyNy4zMjhjMC0yMC42NzIgMS4xNTItMzguNzM2IDI2LjA0OC0zOC43MzYgNi4yMDggMCAyMS42IDYuMDY0IDIzLjcxMiAxNy4xNjggMTEuNjQ4IDYyLjAzMiAxNi42ODggMTIwLjUxMiAyOS4xNjggMTg1Ljk2OCAxLjg1NiAyLjkyOCAxLjUwNCA3LjAwOCA0LjU2IDEwLjQzMiAzLjE1Mi0xMC4yODggNjYuOTI4LTE2OC43ODQgOTQuOTYtMTY4Ljc4NCAyMi41NDQgMCAzMC40IDQ0LjU5MiAzMy41MzYgNjEuODI0IDYuMjA4IDIwLjY1NiAxMy4wODggNTUuMjE2IDIyLjQxNiA4Mi43NTIgMC0xMy43NzYgMTIuNDgtMjAzLjEyIDY1LjM5Mi0yMDMuMTIgMTguNTkyLjAzMiAyNi43MDQgNi45MjggMjYuNzA0IDI3LjU2OHpNODcwLjMyIDQyMi45MjhjMCA1NS4wODgtMzEuMDg4IDE1NC44OC0xMDIuNjQgMTU0Ljg4LTYuMTkyIDAtMTguNDQ4LTMuNjE2LTI1LjQyNC02LjAxNi0zMi40MzItMTEuMTY4LTUwLjE3Ni00OS42OTYtNTIuMjg4LTY2LjI1NiAwIDAtMy44ODgtMTcuOTItMy44ODgtNDAuODk2czMuODg4LTQ1LjE4NCAzLjg4OC00NS4xODRjMTUuNTUyLTc1LjcyOCA0My40ODgtMTA2LjczNiA5Ni4zODQtMTA2LjczNiA1OS4xMDQtLjAzMiA4My45NjggNTguNTI4IDgzLjk2OCAxMTAuMjA4eiIvPjwvc3ZnPg==';
		add_menu_page( __( 'Shop Maker', 'shop-maker' ), __( 'Shop Maker', 'shop-maker' ), 'manage_options', sh_maker_admin_root_page_slug(), null, $frontrom_icon, '55.5' );
	}

	/**
	 * Add modules menu item.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function modules_menu() {
		if ( current_user_can( 'manage_options' ) ) {
			add_submenu_page( sh_maker_admin_root_page_slug(), __( 'Modules', 'frontrom' ), __( 'Modules', 'frontrom' ), 'manage_options', sh_maker_admin_modules_page_slug(), array( $this, 'modules_page' ) );
		}
	}

	/**
	 * Init the modules page.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function modules_page() {
		\ShopMaker\Admin\Modules::instance()->output();
	}
}

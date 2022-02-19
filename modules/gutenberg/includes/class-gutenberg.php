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
		if ( $this->is_request( 'admin' ) ) {
			\ShopMaker\Gutenberg\Admin\Admin::instance();
		}
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
		$this->define( 'SH_MAKER_G_PATH', SH_MAKER_ABSPATH . '/modules/gutenberg' );
		$this->define( 'SH_MAKER_G_DIST_PATH', SH_MAKER_G_PATH . '/dist' );
		$this->define( 'SH_MAKER_G_DIST_URL', SH_MAKER_PLUGIN_URL . 'modules/gutenberg/dist' );
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

	/**
	 * What type of request is this?
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) && ! $this->is_rest_api_request();
		}
	}

	/**
	 * Returns true if the request is a non-legacy REST API request.
	 *
	 * Legacy REST requests should still run some extra code for backwards compatibility.
	 *
	 * @todo: replace this function once core WP function is available: https://core.trac.wordpress.org/ticket/42061.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return bool
	 */
	public function is_rest_api_request() {
		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return false;
		}

		$rest_prefix         = trailingslashit( rest_get_url_prefix() );
		$is_rest_api_request = ( false !== strpos( $_SERVER['REQUEST_URI'], $rest_prefix ) ); // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		return apply_filters( 'Shop_Maker_is_rest_api_request', $is_rest_api_request );
	}
}

<?php
/**
 * Shop_Maker setup
 *
 * @package Shop_Maker
 * @since [SH_MAKER_VERSION]
 */

namespace ShopMaker;

defined( 'ABSPATH' ) || exit;

/**
 * Main Shop_Maker Class.
 *
 * @class Shop_Maker
 *
 * @since [SH_MAKER_VERSION]
 */
final class Shop_Maker {

	/**
	 * Shop_Maker version.
	 *
	 * @var string
	 */
	public $version = '0.1';

	/**
	 * Shop_Maker Schema version.
	 *
	 * @since 0.1 started with version string 01.
	 *
	 * @var string
	 */
	public $db_version = '01';

	/**
	 * The single instance of the class.
	 *
	 * @since [SH_MAKER_VERSION]
	 * @var Shop_Maker
	 */
	protected static $_instance = null;

	/**
	 * Main Shop_Maker Instance.
	 *
	 * Ensures only one instance of Shop_Maker is loaded or can be loaded.
	 *
	 * @since [SH_MAKER_VERSION]
	 * @static
	 * @return Shop_Maker - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Shop_Maker Constructor.
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
	 * Define sh_maker Constants.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	private function define_constants() {
		$this->define( 'SH_MAKER_ABSPATH', dirname( SH_MAKER_PLUGIN_FILE ) . '/' );
		$this->define( 'SH_MAKER_PLUGIN_BASENAME', plugin_basename( SH_MAKER_PLUGIN_FILE ) );
		$this->define( 'SH_MAKER_VERSION', $this->version );
		$this->define( 'SH_MAKER_MINIMUM_ELEMENTOR_VERSION', '0.1' );
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
	 * Include required core files used in admin and on the frontend.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function includes() {

	}

	/**
	 * When WP has loaded all plugins, trigger the `Shop_Maker_loaded` hook.
	 *
	 * This ensures `Shop_Maker_loaded` is called only after all other plugins
	 * are loaded, to avoid issues caused by plugin directory naming changing
	 * the load order.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function on_plugins_loaded() {
		do_action( 'shop_maker_loaded' );
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	private function init_hooks() {
		//register_activation_hook( SH_MAKER_PLUGIN_FILE, array( 'Install', 'install' ) );
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ), -1 );
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
	 * Load Localisation files.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = determine_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'shop-maker' );

		unload_textdomain( 'shop-maker' );
		load_textdomain( 'shop-maker', WP_LANG_DIR . '/shop-maker/shop-maker-' . $locale . '.mo' );
		load_plugin_textdomain( 'shop-maker', false, plugin_basename( dirname( SH_MAKER_PLUGIN_FILE ) ) . '/i18n/languages' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', SH_MAKER_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( SH_MAKER_PLUGIN_FILE ) );
	}

	/**
	 * Get Ajax URL.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return string
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * Return the WC API URL for a given request.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @param string    $request Requested endpoint.
	 * @param bool|null $ssl     If should use SSL, null if should auto detect. Default: null.
	 *
	 * @return string
	 */
	public function api_request_url( $request, $ssl = null ) {
		if ( is_null( $ssl ) ) {
			$scheme = wp_parse_url( home_url(), PHP_URL_SCHEME );
		} elseif ( $ssl ) {
			$scheme = 'https';
		} else {
			$scheme = 'http';
		}

		if ( strstr( get_option( 'permalink_structure' ), '/index.php/' ) ) {
			$api_request_url = trailingslashit( home_url( '/index.php/shop-maker-api/' . $request, $scheme ) );
		} elseif ( get_option( 'permalink_structure' ) ) {
			$api_request_url = trailingslashit( home_url( '/shop-maker-api/' . $request, $scheme ) );
		} else {
			$api_request_url = add_query_arg( 'shop-maker-api', $request, trailingslashit( home_url( '', $scheme ) ) );
		}

		return esc_url_raw( apply_filters( 'shop_maker_api_request_url', $api_request_url, $request, $ssl ) );
	}


	/**
	 * Ran when any plugin is activated.
	 *
	 * @since [SH_MAKER_VERSION]
	 * @param string $filename The filename of the activated plugin.
	 *
	 * @return void
	 */
	public function activated_plugin( $filename ) {

	}

	/**
	 * Ran when any plugin is deactivated.
	 *
	 * @since [SH_MAKER_VERSION]
	 * @param string $filename The filename of the deactivated plugin.
	 *
	 * @return void
	 */
	public function deactivated_plugin( $filename ) {

	}
}

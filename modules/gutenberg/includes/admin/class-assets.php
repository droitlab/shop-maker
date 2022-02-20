<?php
/**
 * Load assets
 *
 * @package ShopMaker\Gutenberg\Admin\Assets
 * @version [SH_MAKER_VERSION]
 */

namespace ShopMaker\Gutenberg\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Assets', false ) ) :

	/**
	 * Admin_Assets Class.
	 *
	 * [SH_MAKER_VERSION]
	 */
	class Assets {

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
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'block_assets' ) );
		}

		/**
		 * Enqueue Block Scripts.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		public function block_assets() {
			$dependencies = require_once SH_MAKER_G_DIST_PATH . '/blocks.asset.php';

			wp_enqueue_script(
				'sh-maker-blocks',
				SH_MAKER_G_DIST_URL . '/blocks.js',
				$dependencies['dependencies'],
				$dependencies['version'],
				true
			);
		}

		/**
		 * Enqueue styles.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		public function admin_styles() {
			global $wp_scripts;
		}

		/**
		 * Enqueue scripts.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		public function admin_scripts() {
		}
	}

endif;

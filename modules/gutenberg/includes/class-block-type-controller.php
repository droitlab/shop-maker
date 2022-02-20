<?php
/**
 * Load assets
 *
 * @package ShopMaker\Gutenberg\Block_Type_Controller
 * @version [SH_MAKER_VERSION]
 */

namespace ShopMaker\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Block_Type_Controller', false ) ) :

	/**
	 * Admin_Assets Class.
	 *
	 * [SH_MAKER_VERSION]
	 */
	final class Block_Type_Controller {

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
		 * Constructor.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		public function __construct() {
			$this->initialize();
		}

		/**
		 * Initialize class features.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		protected function initialize() {
			add_action( 'init', array( $this, 'register_block_type' ) );
		}

		/**
		 * Register blocks, hooking up assets and render functions as needed.
		 */
		public function register_block_type() {
			$block_types = $this->get_block_types();

			foreach ( $block_types as $block_type ) {
				$format_type = str_replace( '-', '_',  $block_type );
				$class_name = ucwords( $format_type, '_' );
				$namespace = '\\ShopMaker\\Gutenberg\\BlockTypes\\' . $class_name;

				$namespace::instance();
			}
		}

		/**
		 * Get list of block types.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return array
		 */
		protected function get_block_types() {
			$block_types = array(
				'contact',
			);

			return $block_types;
		}
	}

endif;

<?php
/**
 * Load assets
 *
 * @package ShopMaker\Gutenberg
 * @version [SH_MAKER_VERSION]
 */

namespace ShopMaker\Gutenberg\BlockTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Abstract_Block', false ) ) :

	/**
	 * Admin_Assets Class.
	 *
	 * [SH_MAKER_VERSION]
	 */
	abstract class Abstract_Block {

		/**
		 * Block namespace.
		 *
		 * @var string
		 */
		protected $namespace = 'sh-maker';

		/**
		 * Block name within this namespace.
		 *
		 * @var string
		 */
		protected $block_name = '';

		/**
		 * Class Construct.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		public function __construct() {
			$this->initialize();
		}

		/**
		 * Initialize Methods.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		public function initialize() {
			if ( empty( $this->block_name ) ) {
				_doing_it_wrong( __METHOD__, esc_html__( 'Block name is required.', 'woocommerce' ), '4.5.0' );
				return false;
			}

			$this->register_block_type();
		}

		/**
		 * Registers the block type with WordPress.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void
		 */
		protected function register_block_type() {
			$block_settings = array(
				'render_callback' => $this->get_block_type_render_callback(),
				'attributes'      => $this->get_block_type_attributes(),
				'supports'        => $this->get_block_type_supports(),
				'view_script'     => $this->get_block_type_front_end_scripts(),
			);

			register_block_type(
				$this->get_block_type(),
				$block_settings
			);
		}

		/**
		 * Get the block type.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return string
		 */
		protected function get_block_type() {
			return $this->namespace . '/' . $this->block_name;
		}

		/**
		 * Get the render callback for this block type.
		 *
		 * Dynamic blocks should return a callback, for example, `return [ $this, 'render' ];`
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @see $this->register_block_type()
		 * @return callable|null;
		 */
		protected function get_block_type_render_callback() {
			return array( $this, 'render_callback' );
		}

		/**
		 * The default render_callback for all blocks. This will ensure assets are enqueued just in time, then render
		 * the block (if applicable).
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @param array|WP_Block $attributes Block attributes, or an instance of a WP_Block. Defaults to an empty array.
		 * @param string         $content    Block content. Default empty string.
		 * @return string Rendered block type output.
		 */
		public function render_callback( $attributes = [], $content = '' ) {
			$render_callback_attributes = $this->parse_render_callback_attributes( $attributes );
			return $this->render( $render_callback_attributes, $content );
		}

		/**
		 * Render the block. Extended by children.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @param array  $attributes Block attributes.
		 * @param string $content    Block content.
		 * @return string Rendered block type output.
		 */
		protected function render( $attributes, $content ) {
			return $content;
		}

		/**
		 * Parses block attributes from the render_callback.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @param array|WP_Block $attributes Block attributes, or an instance of a WP_Block. Defaults to an empty array.
		 * @return array
		 */
		protected function parse_render_callback_attributes( $attributes ) {
			return is_a( $attributes, 'WP_Block' ) ? $attributes->attributes : $attributes;
		}

		/**
		 * Get the supports array for this block type.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @see $this->register_block_type()
		 * @return string;
		 */
		protected function get_block_type_supports() {
			return array();
		}

		/**
		 * Get block attributes.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return array;
		 */
		protected function get_block_type_attributes() {
			return array();
		}

		/**
		 * Get block front-end scripts.
		 *
		 * [SH_MAKER_VERSION]
		 *
		 * @return void;
		 */
		protected function get_block_type_front_end_scripts() {

		}
	}

endif;

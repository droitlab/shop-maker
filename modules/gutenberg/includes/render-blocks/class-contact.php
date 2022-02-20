<?php
/**
 * Load assets
 *
 * @package ShopMaker\Gutenberg\BlockTypes
 * @version [SH_MAKER_VERSION]
 */

namespace ShopMaker\Gutenberg\BlockTypes;

use ShopMaker\Gutenberg\BlockTypes\Abstract_Block;

/**
 * HandpickedProducts class.
 */
class Contact extends Abstract_Block {

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
	 * Block name.
	 *
	 * [SH_MAKER_VERSION]
	 *
	 * @var string
	 */
	protected $block_name = 'contact';

	/**
	 * Render the block. Extended by children.
	 *
	 * [SH_MAKER_VERSION]
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content    Block content.
	 *
	 * @return string Rendered block type output.
	 */
	protected function render( $attributes, $content ) {
		return '<h1>I love my bangaldesh</h1>';
	}

	/**
	 * Get block attributes.
	 *
	 * [SH_MAKER_VERSION]
	 *
	 * @return array
	 */
	protected function get_block_type_attributes() {
		return array(
			'text' => array(
				'type'    => 'string',
				'default' => 'I love my Bangladesh',
			),
		);
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

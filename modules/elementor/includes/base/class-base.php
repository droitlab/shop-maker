<?php
namespace ShopMaker\Elementor;

use Elementor\Widget_Base;
/**
 * Elementor widget base.
 *
 * An abstract class to register new Elementor widgets. It extended the
 * `Element_Base` class to inherit its properties.
 *
 * This abstract class must be extended in order to register new widgets.
 *
 * @since 1.0.0
 * @abstract
 */
abstract class Base extends Widget_Base {
	public function get_name() {

		/**
		 * Automatically generate widget name from class
		 *
		 * Card will be card
		 * Blog_Card will be blog-card
		 */
		$name = str_replace( strtolower('ShopMaker\\Elementor\\Widgets'), '', strtolower($this->get_class_name()) );
	   
		$name = str_replace( '_', '-', $name );
		$name = ltrim( $name, '\\' );

		return 'sh-maker-' . $name;
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'sh-maker-elements', 'general' ];
	}

	/**
	 * Register content controls
	 *
	 * @return void
	 */
	abstract protected function register_content_controls();

	/**
	 * Register style controls
	 *
	 * @return void
	 */
	abstract protected function register_style_controls();
}

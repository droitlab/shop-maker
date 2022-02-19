<?php
/**
 * Shop Maker Elementor Widgets Manger.
 *
 * @class    Elementor
 * @package  ShopMaker\Elementor\Manager
 * @version  [SH_MAKER_VERSION]
 */

namespace ShopMaker\Elementor\Manager;

use ShopMaker\Elementor\Base;
use Elementor\Widgets_Manager;

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shop Maker elementor manager.
 *
 * Shop maker elementor manager handler class is responsible for registering and
 * initializing all the supported shop-maker elementor.
 *
 * @since [SH_MAKER_VERSION]
 */
class Elementor {

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
	 * Widgets manager constructor.
	 *
	 * Initializing shop-maker widgets manager.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'categories_registered' ) );
	}

	/**
	 * Init widgets.
	 *
	 * Initialize shop-maker widgets manager. Include all the the widgets files
	 * and register each shop-maker and WordPress widget.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return void
	 */
	public function categories_registered( $elements_manager ) {

		$categories = $this->category_lists();
		
		foreach ( $categories as $category ) {
			$elements_manager->add_category(
				$category['name'],
				[
					'title' => $category['title'],
					'icon' => $category['icon'],
				]
			);
		}

		/**
		 * After categories registered.
		 *
		 * Fires after Elementor widgets are registered.
		 *
		 * @since [SH_MAKER_VERSION]
		 *
		 * @param Manager $this The widgets manager.
		 */
		do_action( 'shop_maker_after_categories_registered', $elements_manager );
	}

	/**
	 * Require files.
	 *
	 * Require Elementor widget base class.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @return array
	 */
	public function category_lists() {
		$category_lists = array(
			'sh-maker-elements' => array(
				'name'  => 'sh-maker-elements',
				'title' => esc_html__( 'Shop Maker', 'plugin-name' ),
				'icon'  => 'hm hm-advanced-heading',
			),
		);

		/**
		 * Shop-Maker category lists.
		 *
		 * @since [SH_MAKER_VERSION]
		 *
		 * @param array $category_lists Widgets lists.
		 */
		return apply_filters( 'shop_maker_category_lists', $category_lists );
	}
}

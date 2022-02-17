<?php
/**
 * Shop Maker Elementor Widgets Manger.
 *
 * @class    Manager
 * @package  ShopMaker\Elementor
 * @version  [SH_MAKER_VERSION]
 */

namespace ShopMaker\Elementor;

use ShopMaker\Elementor\Base;
use Elementor\Widgets_Manager;

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shop Maker widgets manager.
 *
 * Shop maker widgets manager handler class is responsible for registering and
 * initializing all the supported shop-maker widgets.
 *
 * @since [SH_MAKER_VERSION]
 */
class Manager {

	/**
	 * Widget types.
	 *
	 * Holds the list of all the widget types.
	 *
	 * @since [SH_MAKER_VERSION]
	 * @access private
	 *
	 * @var Widget_Base[]
	 */
	//private $_widget_types = null;

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
		add_action( 'elementor/widgets/register', array( $this, 'my_widgets' ) );
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
	public function my_widgets( $class_instance ) {

		$widget_lists = $this->get_widget_lists();
		$this->_widget_types = array();

		foreach ( $widget_lists as $widget_key => $widget ) {
			$format_key = str_replace( '-', '_',  $widget_key );
			$class_name = ucwords( $format_key, '_' );
			$namespace = '\\ShopMaker\\Elementor\\Widgets\\'.$class_name;

			$class_instance->register( $namespace::instance() );
		}

		/**
		 * After widgets registered.
		 *
		 * Fires after Elementor widgets are registered.
		 *
		 * @since [SH_MAKER_VERSION]
		 *
		 * @param Manager $this The widgets manager.
		 */
		do_action( 'shop_maker_after_widgets_registered', $this );
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
	public function get_widget_lists() {
		$widget_lists = array(
			'alert-notice' => array(
				'cat'    => 'general',
				'title'  => __( 'Alert Mishu', 'shop-maker' ),
				'icon'   => 'hm hm-advanced-heading',
				'is_pro' => false,
			),
		);

		/**
		 * Shop-Maker widget lists.
		 *
		 * @since [SH_MAKER_VERSION]
		 *
		 * @param array $widget_lists Widgets lists.
		 */
		return apply_filters( 'shop_maker_widget_lists', $widget_lists );
	}
}

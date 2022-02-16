<?php
/**
 * Elementor Alert Widget.
 *
 * @class    Elementor
 * @package  ShopMaker\Elementor
 * @version  [SH_MAKER_VERSION]
 */

namespace ShopMaker\Elementor;

/**
 * Elementor alert widget.
 *
 * Elementor widget that displays a collapsible display of content in an toggle
 * style, allowing the user to open multiple items.
 *
 * @since [SH_MAKER_VERSION]
 */
class Alert {

	private static $_instance;

    public static function instance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

}

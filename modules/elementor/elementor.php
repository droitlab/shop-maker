<?php
/**
 * Shop Maker Elementor
 *
 * @package ShopMaker\Elementor
 * @version [SH_MAKER_VERSION]
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the main instance of WC.
 *
 * @since  [SH_MAKER_VERSION]
 * @return Elementor instance.
 */
function sh_maker_elementor() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return \ShopMaker\Elementor\Elementor::instance();
}

// Global for backwards compatibility.
$GLOBALS['sh_maker_elementor'] = sh_maker_elementor();

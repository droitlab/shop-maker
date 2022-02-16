<?php
/**
 * Shop Maker Gutenberg
 *
 * @package ShopMaker\Gutenberg
 * @version [SH_MAKER_VERSION]
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the main instance of WC.
 *
 * @since  [SH_MAKER_VERSION]
 * @return Gutenberg instance.
 */
function sh_maker_gutenberg() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return \ShopMaker\Gutenberg\Gutenberg::instance();
}

// Global for backwards compatibility.
$GLOBALS['sh_maker_gutenberg'] = sh_maker_gutenberg();

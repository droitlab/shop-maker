<?php
/**
 * Shop Maker Functions
 *
 * @package  ShopMaker\Functions
 * @version  [SH_MAKER_VERSION]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieve an option.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @param string $option_name The option to be retrieved.
 * @param string $default     Optional. Default value to be returned if the option
 *                            isn't set. See {@link get_blog_option()}.
 * @return mixed The value for the option.
 */
function sh_maker_get_option( $option_name, $default = '' ) {
	$value = get_option( $option_name, $default );

	/**
	 * Filters the option value for the requested option.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @param mixed $value The value for the option.
	 */
	return apply_filters( 'shop_maker_get_option', $value );
}

/**
 * Return the correct admin URL based on WordPress configuration.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @param string $path   Optional. The sub-path under /wp-admin to be
 *                       appended to the admin URL.
 * @param string $scheme The scheme to use. Default is 'admin', which
 *                       obeys {@link force_ssl_admin()} and {@link is_ssl()}. 'http'
 *                       or 'https' can be passed to force those schemes.
 *
 * @return string Admin url link with optional path appended.
 */
function sh_maker_get_admin_url( $path = '', $scheme = 'admin' ) {
	return admin_url( $path, $scheme );
}

/**
 * Format numbers.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @param int  $number   The number to be formatted.
 * @param bool $decimals Whether to use decimals. See {@link number_format_i18n()}.
 *
 * @return string The formatted number.
 */
function sh_maker_number_format( $number = 0, $decimals = false ) {
	// Force number to 0 if needed.
	if ( ! is_numeric( $number ) ) {
		$number = 0;
	}

	/**
	 * Filters the formatted number.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @param string $value    formatted value.
	 * @param int    $number   The number to be formatted.
	 * @param bool   $decimals Whether or not to use decimals.
	 */
	return apply_filters( 'shop_maker_number_format', number_format_i18n( $number, $decimals ), $number, $decimals );
}

/**
 * Save an option.
 *
 * This is a wrapper for {@link update_blog_option()}, which in turn stores
 * settings data (such as bp-pages) on the appropriate blog, given your current
 * setup.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @param string $option_name The option key to be set.
 * @param mixed  $value       The value to be set.
 *
 * @return bool True on success, false on failure.
 */
function sh_maker_update_option( $option_name, $value ) {
	return update_option( $option_name, $value );
}

/**
 * Check whether a given module (or feature of a module) is active.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @param string $module The module name.
 * @param string $feature   The feature name.
 * @return bool
 */
function sh_maker_is_active( $module = '' ) {

	return true;
	/**
	 * Filters whether or not a given module has been activated by the admin.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @param bool   $retval Whether or not a given module has been activated by the admin.
	 * @param string $module Current module being checked.
	 */
	return apply_filters( 'shop_maker_is_active', $retval, $module );
}

/**
 * Shop Maker admin modules page slug.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return string
 */
function sh_maker_is_active_elementor() {
	// Check if Elementor installed and activated
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action('admin_notices', 'ha_elementor_missing_notice');
		return false;
	}

	// Check for required Elementor version
	if ( ! version_compare( ELEMENTOR_VERSION, SH_MAKER_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
		add_action('admin_notices', 'ha_required_elementor_version_missing_notice');
		return false;
	}

	return true;
}

/**
 * Shop Maker admin menu slug.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return string
 */
function sh_maker_admin_root_page_slug() {
	return apply_filters( 'shop_maker_admin_root_page_slug', 'shop-maker' );
}

/**
 * Shop Maker admin modules page slug.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return string
 */
function sh_maker_admin_modules_page_slug() {
	return apply_filters( 'shop_maker_admin_module_page_slug', 'shop-maker-modules' );
}

/**
 * Get gutenberg module slug.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return string
 */
function sh_maker_gutenberg_module_slug() {
	return 'gutenberg';
}

/**
 * Get elementor module slug.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return string
 */
function sh_maker_elementor_module_slug() {
	return 'elementor';
}

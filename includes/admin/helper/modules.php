<?php
/**
 * ShopMaker Admin Module Functions.
 *
 * @package ShopMaker\Admin
 * @since [SH_MAKER_VERSION]
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Renders the Module Setup admin panel.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return void
 */
function sh_maker_admin_modules_settings() {
	// Flush the rewrite rule to work forum on newly assigned the page.
	if ( isset( $_GET['added'] ) && 'true' === $_GET['added'] ) {
		flush_rewrite_rules( true );
	}
	?>

	<div class="wrap">
		<form action="" method="post" id="sh-maker-admin-module-form">
			<?php sh_maker_admin_modules_options(); ?>
			<?php wp_nonce_field( 'sh-maker-admin-module-setup' ); ?>
		</form>
	</div>

	<?php
}

/**
 * Creates reusable markup for module setup on the Modules and Pages dashboard panel.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return void
 */
function sh_maker_admin_modules_options() {
	// Declare local variables.
	$deactivated_modules = array();

	/**
	 * Filters the array of available modules.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @param mixed $value Active modules.
	 */
	$active_modules   = sh_maker_get_active_modules();
	$default_modules  = sh_maker_get_modules( 'default' );
	$optional_modules = sh_maker_get_modules( 'optional' );
	$required_modules = sh_maker_get_modules( 'required' );

	if ( isset( $optional_modules['blogs'] ) ) {
		unset( $optional_modules['blogs'] );
	}

	// Merge optional and required together.
	$all_modules      = $required_modules + $optional_modules;
	$inactive_modules = array_diff( array_keys( $all_modules ), array_keys( $active_modules ) );

	// Get the total count of all plugins.
	$all_count = count( $all_modules );
	$page      = 'admin.php';
	$action    = ! empty( $_GET['action'] ) ? $_GET['action'] : 'all';

	switch ( $action ) {
		case 'all':
			$current_modules = $all_modules;
			break;
		case 'active':
			foreach ( array_keys( $active_modules ) as $module ) {
				if ( isset( $all_modules[ $module ] ) ) {
					$current_modules[ $module ] = $all_modules[ $module ];
				}
			}
			break;
		case 'inactive':
			foreach ( $inactive_modules as $module ) {
				if ( isset( $all_modules[ $module ] ) ) {
					$current_modules[ $module ] = $all_modules[ $module ];
				}
			}
			break;
		case 'mustuse':
			$current_modules = $required_modules;
			break;
	}
	?>

	<h3 class="screen-reader-text">
	<?php
		/* translators: accessibility text */
		_e( 'Filter modules list', 'shop-maker' );
	?>
	</h3>

	<ul class="subsubsub">
		<li><a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page'   => sh_maker_admin_modules_page_slug(),
					'action' => 'all',
				),
				sh_maker_get_admin_url( $page )
			)
		);
		?>
						"
	<?php
	if ( $action === 'all' ) :
		?>
		class="current"<?php endif; ?>><?php printf( __( 'All <span class="count">(%s)</span>', 'shop-maker' ), sh_maker_number_format( $all_count ) ); ?></a> | </li>
		<li><a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page'   => sh_maker_admin_modules_page_slug(),
					'action' => 'active',
				),
				sh_maker_get_admin_url( $page )
			)
		);
		?>
						"
	<?php
	if ( $action === 'active' ) :
		?>
		class="current"<?php endif; ?>><?php printf( __( 'Active <span class="count">(%s)</span>', 'shop-maker' ), sh_maker_number_format( count( $active_modules ) ) ); ?></a> | </li>
		<li><a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page'   => sh_maker_admin_modules_page_slug(),
					'action' => 'inactive',
				),
				sh_maker_get_admin_url( $page )
			)
		);
		?>
						"
	<?php
	if ( $action === 'inactive' ) :
		?>
		class="current"<?php endif; ?>><?php printf( __( 'Inactive <span class="count">(%s)</span>', 'shop-maker' ), sh_maker_number_format( count( $inactive_modules ) ) ); ?></a> | </li>
		<li><a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page'   => sh_maker_admin_modules_page_slug(),
					'action' => 'mustuse',
				),
				sh_maker_get_admin_url( $page )
			)
		);
		?>
						"
	<?php
	if ( $action === 'mustuse' ) :
		?>
		class="current"<?php endif; ?>><?php printf( __( 'Required <span class="count">(%s)</span>', 'shop-maker' ), sh_maker_number_format( count( $required_modules ) ) ); ?></a></li>
	</ul>

	<h3 class="screen-reader-text">
	<?php
		_e( 'Modules list', 'shop-maker' );
	?>
	</h3>

	<div class="tablenav top">
		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text"><?php _e( 'Select bulk action', 'shop-maker' ); ?></label>
			<select name="action" id="bulk-action-selector-top">
				<option value=""><?php _e( 'Bulk Actions', 'shop-maker' ); ?></option>
				<option value="active" class="hide-if-no-js"><?php _e( 'Activate', 'shop-maker' ); ?></option>
				<option value="inactive"><?php _e( 'Deactivate', 'shop-maker' ); ?></option>
			</select>
			<input type="submit" id="doaction" class="button action" name="sh-maker-admin-module-submit" value="<?php esc_attr_e( 'Apply', 'shop-maker' ); ?>">
		</div>
	</div>
	<table class="wp-list-table widefat plugins">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox" <?php checked( empty( $inactive_modules ) ); ?>>
					<label class="screen-reader-text" for="cb-select-all-1">
					<?php
					/* translators: accessibility text */
					_e( 'Enable or disable all optional modules in bulk', 'shop-maker' );
					?>
				</label></td>
				<th scope="col" id="name" class="manage-column column-title column-primary"><?php _e( 'Module', 'shop-maker' ); ?></th>
				<th scope="col" id="description" class="manage-column column-description"><?php _e( 'Description', 'shop-maker' ); ?></th>
			</tr>
		</thead>

		<tbody id="the-list">

			<?php if ( ! empty( $current_modules ) ) : ?>

				<?php
				foreach ( $current_modules as $name => $labels ) :
					$deactivate_confirm = ( isset( $labels['deactivation_confirm'] ) && true === $labels['deactivation_confirm'] ) ? true : false;
					?>

					<?php
					if ( in_array( $name, array( 'blogs' ) ) ) :
						$class = isset( $active_modules[ esc_attr( $name ) ] ) ? 'active hidden' : 'inactive hidden';
					elseif ( ! in_array( $name, array( 'core', 'members', 'xprofile' ) ) ) :
						$class = isset( $active_modules[ esc_attr( $name ) ] ) ? 'active' : 'inactive';
					else :
						$class = 'active';
					endif;
					?>

					<tr id="<?php echo esc_attr( $name ); ?>"
						class="<?php echo esc_attr( $name ) . ' ' . esc_attr( $class ); ?>">
						<th scope="row" class="check-column">
							<?php
							if ( ! in_array( $name, array( 'core', 'members', 'xprofile' ) ) ) :
								if ( isset( $active_modules[ esc_attr( $name ) ] ) ) {
									?>
									<input class="<?php echo esc_attr( ( true === $deactivate_confirm ) ? 'mass-check-deactivate' : '' ); ?>"
										   type="checkbox"
										   id="<?php echo esc_attr( "sh_maker_modules[$name]" ); ?>"
										   name="<?php echo esc_attr( "sh_maker_modules[$name]" ); ?>"
										   value="1"<?php checked( isset( $active_modules[ esc_attr( $name ) ] ) ); ?> />
									<?php
								} else {
									?>
									<input type="checkbox" id="<?php echo esc_attr( "sh_maker_modules[$name]" ); ?>"
										   name="<?php echo esc_attr( "sh_maker_modules[$name]" ); ?>"
										   value="1"<?php checked( isset( $active_modules[ esc_attr( $name ) ] ) ); ?> />
									<?php
								}
								?>
								<label for="<?php echo esc_attr( "sh_maker_modules[$name]" ); ?>"
									   class="screen-reader-text">
									<?php
									/* translators: accessibility text */
									printf( __( 'Select %s', 'shop-maker' ), esc_html( $labels['title'] ) );
									?>
								</label>
								<div class="module-deactivate-msg" style="display: none;">
									<?php
									if ( ! empty( $labels['deactivation_message'] ) ) {
										echo esc_html( $labels['deactivation_message'] );
									}
									?>
								</div>
							<?php endif; ?>
						</th>
						<td class="plugin-title column-primary">
							<label for="<?php echo esc_attr( "sh_maker_modules[$name]" ); ?>">
								<span aria-hidden="true"></span>
								<strong><?php echo esc_html( $labels['title'] ); ?></strong>
							</label>
							<div class="row-actions visible">
								<?php if ( in_array( $name, array( 'core', 'members', 'xprofile' ) ) ) : ?>
									<span class="required">
										<?php _e( 'Required', 'shop-maker' ); ?>
									</span>
								<?php elseif ( ! in_array( $name, array( 'core', 'members', 'xprofile' ) ) ) : ?>
									<?php if ( isset( $active_modules[ esc_attr( $name ) ] ) ) : ?>
										<span class="deactivate <?php echo esc_attr( ( true === $deactivate_confirm ) ? 'sh-maker-show-deactivate-popup' : '' ); ?>"
											  data-confirm="<?php echo esc_attr( $deactivate_confirm ); ?>">
											<a href="
											<?php
											echo wp_nonce_url(
												sh_maker_get_admin_url(
													add_query_arg(
														array(
															'page' => sh_maker_admin_modules_page_slug(),
															'action' => $action,
															'sh_maker_module' => $name,
															'do_action' => 'deactivate',
														),
														$page
													)
												),
												'sh-maker-admin-module-activation'
											);
											?>
											">
												<?php _e( 'Deactivate', 'shop-maker' ); ?>
											</a>
										</span>
										<div class="module-deactivate-msg" style="display: none;">
											<?php
											if ( ! empty( $labels['deactivation_message'] ) ) {
												echo esc_html( $labels['deactivation_message'] );
											}
											?>
										</div>
									<?php else : ?>
										<span class="activate">
											<a href="
											<?php
											echo wp_nonce_url(
												sh_maker_get_admin_url(
													add_query_arg(
														array(
															'page' => sh_maker_admin_modules_page_slug(),
															'action' => $action,
															'sh_maker_module' => $name,
															'do_action' => 'activate',
														),
														$page
													)
												),
												'sh-maker-admin-module-activation'
											);
											?>
														">
												<?php _e( 'Activate', 'shop-maker' ); ?>
											</a>
										</span>
									<?php endif; ?>
								<?php endif; ?>
								<?php if ( isset( $active_modules[ esc_attr( $name ) ] ) && ! empty( $labels['settings'] ) ) : ?>
									<span><?php _e( '|', 'shop-maker' ); ?></span>
									<span class="settings">
										<a href="<?php echo esc_url( $labels['settings'] ); ?>">
											<?php
											if ( 'xprofile' === $name ) {
												_e( 'Edit Fields', 'shop-maker' );
											} else {
												_e( 'Settings', 'shop-maker' );
											}
											?>
										</a>
									</span>
								<?php endif; ?>
							</div>
						</td>

						<td class="column-description desc">
							<div class="plugin-description">
								<p><?php echo $labels['description']; ?></p>
							</div>

						</td>
					</tr>

				<?php endforeach ?>

			<?php else : ?>

				<tr class="no-items">
					<td class="colspanchange" colspan="3"><?php _e( 'No modules found.', 'shop-maker' ); ?></td>
				</tr>

			<?php endif; ?>

		</tbody>

		<tfoot>
			<tr>
				<td class="manage-column column-cb check-column"><input id="cb-select-all-2" type="checkbox" <?php checked( empty( $inactive_modules ) ); ?>>
					<label class="screen-reader-text" for="cb-select-all-2">
					<?php
					/* translators: accessibility text */
					_e( 'Enable or disable all optional modules in bulk', 'shop-maker' );
					?>
				</label></td>
				<th class="manage-column column-title column-primary"><?php _e( 'Module', 'shop-maker' ); ?></th>
				<th class="manage-column column-description"><?php _e( 'Description', 'shop-maker' ); ?></th>
			</tr>
		</tfoot>

	</table>

	<input type="hidden" name="sh_maker_modules[members]" value="1" />
	<input type="hidden" name="sh_maker_modules[xprofile]" value="1" />

	<div class="tablenav bottom">
		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text"><?php _e( 'Select bulk action', 'shop-maker' ); ?></label>
			<select name="action2" id="bulk-action-selector-top">
				<option value=""><?php _e( 'Bulk Actions', 'shop-maker' ); ?></option>
				<option value="active" class="hide-if-no-js"><?php _e( 'Activate', 'shop-maker' ); ?></option>
				<option value="inactive"><?php _e( 'Deactivate', 'shop-maker' ); ?></option>
			</select>
			<input type="submit" id="doaction" class="button action" name="sh-maker-admin-module-submit" value="<?php esc_attr_e( 'Apply', 'shop-maker' ); ?>">
		</div>
	</div>
	<?php
}

/**
 * Handle saving the Module settings.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return void
 *
 * @todo Use settings API when it supports saving network settings
 */
function sh_maker_admin_modules_settings_handler() {

	// Bail if not saving settings.
	if ( ! isset( $_POST['sh-maker-admin-module-submit'] ) ) {
		return;
	}

	// Bail if nonce fails.
	if ( ! check_admin_referer( 'sh-maker-admin-module-setup' ) ) {
		return;
	}

	$action = ( isset( $_POST['action'] ) && '' !== $_POST['action'] ) ? $_POST['action'] : $_POST['action2'];

	if ( '' === $action ) {
		return;
	}

	// Settings form submitted, now save the settings. First, set active modules.
	if ( isset( $_POST['sh_maker_modules'] ) ) {

		// Save settings and upgrade schema.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$current_modules = sh_maker_get_active_modules();
		$submitted       = stripslashes_deep( $_POST['sh_maker_modules'] );

		if ( 'inactive' === $action ) {
			$submitted           = array_diff_key( $current_modules, $submitted );
			$uninstalled_modules = array_diff_key( $current_modules, $submitted );

			sh_maker_install( $submitted );
			sh_maker_update_option( 'sh-maker-active-modules', $submitted );

			sh_maker_uninstall( $uninstalled_modules );

		} else {
			$uninstalled_modules = array_diff_key( $current_modules, $submitted );

			sh_maker_install( $submitted );
			sh_maker_update_option( 'sh-maker-active-modules', $submitted );

			sh_maker_uninstall( $uninstalled_modules );
		}
	}

	$current_action = 'all';
	if ( isset( $_GET['action'] ) && in_array( $_GET['action'], array( 'active', 'inactive' ) ) ) {
		$current_action = $_GET['action'];
	}

	// Where are we redirecting to?
	$base_url = sh_maker_get_admin_url(
		add_query_arg(
			array(
				'page'    => sh_maker_admin_modules_page_slug(),
				'action'  => $current_action,
				'updated' => 'true',
				'added'   => 'true',
			),
			'admin.php'
		)
	);

	// Redirect.
	wp_safe_redirect( $base_url );
	die();
}
add_action( 'admin_init', 'sh_maker_admin_modules_settings_handler' );

/**
 * Handle saving the Module settings.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @todo Use settings API when it supports saving network settings
 */
function sh_maker_admin_modules_activation_handler() {
	if ( ! isset( $_GET['sh_maker_module'] ) ) {
		return;
	}

	// Bail if nonce fails.
	if ( ! check_admin_referer( 'sh-maker-admin-module-activation' ) ) {
		return;
	}

	// Settings form submitted, now save the settings. First, set active modules.
	if ( isset( $_GET['sh_maker_module'] ) ) {

		// Save settings and upgrade schema.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$current_action = 'active';
		if ( isset( $_GET['do_action'] ) && in_array( $_GET['do_action'], array( 'activate', 'deactivate' ) ) ) {
			$current_action = $_GET['do_action'];
		}

		$submitted = stripslashes_deep( $_GET['sh_maker_module'] );
		$current_modules = sh_maker_get_active_modules();
		$active_modules = $current_modules;

		switch ( $current_action ) {
			case 'deactivate':
				foreach ( $current_modules as $key => $module ) {
					if ( $submitted == $key ) {
						unset( $current_modules[ $key ] );
					}
				}
				$active_modules = $current_modules;
				break;

			case 'activate':
			default:
				$active_modules = array_merge( array( $submitted => 'activate' === $current_action ? '1' : '0' ), $current_modules );
				break;
		}

		$uninstalled_modules = array_diff_key( $current_modules, $active_modules );

		sh_maker_install( $active_modules );
		sh_maker_update_option( 'sh-maker-active-modules', $active_modules );
		sh_maker_uninstall( $uninstalled_modules );
	}

	$current_action = 'all';
	if ( isset( $_GET['action'] ) && in_array( $_GET['action'], array( 'active', 'inactive' ) ) ) {
		$current_action = $_GET['action'];
	}

	// Where are we redirecting to?
	$base_url = sh_maker_get_admin_url(
		add_query_arg(
			array(
				'page'    => sh_maker_admin_modules_page_slug(),
				'action'  => $current_action,
				'updated' => 'true',
				'added'   => 'true',
			),
			'admin.php'
		)
	);

	// Redirect.
	wp_safe_redirect( $base_url );
	die();
}
add_action( 'admin_init', 'sh_maker_admin_modules_activation_handler' );

/**
 * Main installer.
 *
 * Can be passed an optional array of modules to explicitly run installation
 * routines on, typically the first time a module is activated in Settings.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @param array|bool $active_modules Modules to install.
 *
 * @return void
 */
function sh_maker_install( $active_modules = false ) {
	flush_rewrite_rules();
}

/**
 * Uninstall modules.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @param array|bool $uninstalled_modules Modules to install.
 *
 * @return void
 */
function sh_maker_uninstall( $uninstalled_modules ) {

}

/**
 * Return a list of module information.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @param string $type Optional; module type to fetch. Default value is 'all', or 'optional', 'required', 'default'.
 *
 * @return array
 */
function sh_maker_get_modules( $type = 'all' ) {
	$optional_modules = array(
		sh_maker_gutenberg_module_slug() => array(
			'title'       => __( 'Gutenberg', 'shop-maker' ),
			'description' => __( 'Allow members to modify their account and notification settings from within their profile.', 'shop-maker' ),
			'default'     => true,
		),
		sh_maker_elementor_module_slug() => array(
			'title'       => __( 'Elementor', 'shop-maker' ),
			'description' => __( 'Notify members of relevant activity with a toolbar bubble and/or via email and allow them to customize their notification settings.', 'shop-maker' ),
			'default'     => true,
		),
		'groups'        => array(
			'title'       => __( 'Social Groups', 'shop-maker' ),
			'settings'    => sh_maker_get_admin_url(
				add_query_arg(
					array(
						'page' => 'bp-settings',
						'tab'  => 'bp-groups',
					),
					'admin.php'
				)
			),
			'description' => __( 'Allow members to organize themselves into public, private or hidden social groups with separate activity feeds and member listings.', 'shop-maker' ),
			'default'     => true,
		),
		'forums'        => array(
			'title'       => __( 'Forum Discussions', 'shop-maker' ),
			'settings'    => sh_maker_get_admin_url(
				add_query_arg(
					array(
						'page' => 'bp-settings',
						'tab'  => 'bp-forums',
					),
					'admin.php'
				)
			),
			'description' => __( 'Allow members to have discussions using Q&A style message boards. Forums can be standalone or connected to social groups.', 'shop-maker' ),
			'default'     => true,
		)
	);

	$default_modules = array();
	foreach ( $optional_modules as $key => $module ) {
		if ( isset( $module['default'] ) && true === $module['default'] ) {
			$default_modules[ $key ] = $module;
		}
	}

	switch ( $type ) {
		case 'optional':
			$modules = $optional_modules;
			break;
		case 'default':
			$modules = $default_modules;
			break;
		case 'required':
			$modules = array();
			break;
		case 'all':
		default:
			$modules = $optional_modules;
			break;
	}

	/**
	 * Filters the list of module information.
	 *
	 * @since [SH_MAKER_VERSION]
	 *
	 * @param array  $modules Array of module information.
	 * @param string $type    Type of module list requested.
	 *                        Possible values are 'all', 'optional', 'required'.
	 */
	return apply_filters( 'shop_maker_get_moduls', $modules, $type );
}

/**
 * Get active modules.
 *
 * @since [SH_MAKER_VERSION]
 *
 * @return string
 */
function sh_maker_get_active_modules() {
	return apply_filters( 'shop_maker_active_modules', sh_maker_get_option( 'sh-maker-active-modules', array() ) );
}

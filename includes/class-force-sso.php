<?php
/**
 * Extend body class.
 *
 * @package To51\Plugin\Jetpack_Force_SSO
 */

namespace To51\Plugin\Jetpack_Force_SSO;

use Jetpack;

defined( 'ABSPATH' ) || exit; // @phpstan-ignore-line

class Force_SSO {
	public static function init() {

		$force_sso = new static();

		// Bail if it is a staging, development or local site (only force SSO on producion sites).
		if ( 'production' !== wp_get_environment_type() ) {
			return;
		}

		add_filter( 'jetpack_active_modules', array( $force_sso, 'activate_sso' ) );
		add_action( 'jetpack_module_loaded_sso', array( $force_sso, 'sso_loaded' ) );

		if ( true === defined( 'TO51_JETPACK_FORCE_SSO_DISABLE_CONNECTION' ) ) {
			add_filter( 'jetpack_is_connection_ready', '__return_false' );
		}
	}

	/**
	 * Register SSO module is doesn't exist.
	 *
	 * @param  array  $modules
	 *
	 * @return array
	 */
	public function activate_sso( array $modules ): array {
		if ( false === array_search( 'sso', $modules, true ) ) {
			$modules[] = 'sso';
		}

		return $modules;
	}

	/**
	 * Execute filters when SSO module is loaded.
	 */
	public function sso_loaded(): void {
		// if connection is not ready - bail.
		if ( false === Jetpack::is_connection_ready() ) {
			return;
		}
		// Automatically link local accounts to WPCOM accounts by email.
		add_filter( 'jetpack_sso_match_by_email', '__return_true' );
		// Disable default login form.
		add_filter( 'jetpack_remove_login_form', '__return_true' );
		// To force 2FA for wordpress.com user login.
		add_filter( 'jetpack_sso_require_two_step', '__return_true' );
	}
}

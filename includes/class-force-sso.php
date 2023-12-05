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

		add_filter( 'jetpack_active_modules', array( $force_sso, 'activate_sso' ) );
		add_action( 'jetpack_module_loaded_sso', array( $force_sso, 'sso_loaded' ) );
		add_filter( 'update_plugins_github.com', array( $force_sso, 'self_update' ), 10, 4 );

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
		$environment_type = wp_get_environment_type();

		// Check if the 'sso' module should be enabled or disabled based on the environment type.
		if ( 'production' === $environment_type ) {
			// Add 'sso' module if it's not already enabled.
			if ( false === array_search( 'sso', $modules, true ) ) {
				$modules[] = 'sso';
			}
		} else {
			// Disable 'sso' module if it's enabled on a non-production site.
			$index = array_search( 'sso', $modules, true );
			if ( false !== $index ) {
				unset( $modules[ $index ] );
			}
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

	/**
	 * Check for updates to this plugin
	 *
	 * @param array  $update   Array of update data.
	 * @param array  $plugin_data Array of plugin data.
	 * @param string $plugin_file Path to plugin file.
	 * @param string $locales    Locale code.
	 *
	 * @return array|bool Array of update data or false if no update available.
	 */
	public function self_update( $update, array $plugin_data, string $plugin_file, $locales ) {
		// only check this plugin
		if ( 'team51-force-jetpack-sso/to51-jetpack-force-sso.php' !== $plugin_file ) {
			return $update;
		}

		// already completed update check elsewhere
		if ( ! empty( $update ) ) {
			return $update;
		}

		// let's go get the latest version number from GitHub
		$response = wp_remote_get(
			'https://github.com/a8cteam51/force-jetpack-sso/releases/latest',
			array(
				'user-agent' => 'wpspecialprojects',
			)
		);

		if ( is_wp_error( $response ) ) {
			return;
		} else {
			$output = json_decode( wp_remote_retrieve_body( $response ), true );
		}

		$new_version_number  = $output['tag_name'];
		$is_update_available = version_compare( $plugin_data['Version'], $new_version_number, '<' );

		if ( ! $is_update_available ) {
			return false;
		}

		$new_url     = $output['html_url'];
		$new_package = $output['assets'][0]['browser_download_url'];

		return array(
			'slug'    => $plugin_data['TextDomain'],
			'version' => $new_version_number,
			'url'     => $new_url,
			'package' => $new_package,
		);
	}
}

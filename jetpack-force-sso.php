<?php
/**
 * Plugin Name: Jetpack Force SSO
 * Description: Force Jetpack to turn SSO feature ON.
 * Force "Allow users to log in to this site using WordPress.com accounts".
 * Force "Match accounts using email addresses".
 * Force "Require accounts to use WordPress.com Two-Step Authentication".
 * Version:     1.0.3
 * Author:      WordPress.com Special Projects Team
 * Author URI:  https://wpspecialprojects.wordpress.com
 * Text Domain: jetpack-force-sso
 * Domain Path: /languages
 * Requires at least: 5.1
 * Tested up to: 5.7
 * Requires PHP: 7.2
 *
 * @package To51\Plugin\Jetpack_Force_SSO
 */

namespace To51\Plugin\Jetpack_Force_SSO;

defined( 'ABSPATH' ) || exit; // @phpstan-ignore-line

define( 'TO51_JETPACK_FORCE_SSO_PLUGIN', 'jetpack-force-sso' );
define( 'TO51_JETPACK_FORCE_SSO_VERSION', '1.0.3' );

define( 'TO51_JETPACK_FORCE_SSO_PLUGIN_DIR', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );
define( 'TO51_JETPACK_FORCE_SSO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once TO51_JETPACK_FORCE_SSO_PLUGIN_DIR . 'includes' . DIRECTORY_SEPARATOR . 'class-force-sso.php';

$jetpack_force_sso = new Force_SSO();

add_action(
	'jetpack_loaded',
	function () use ( $jetpack_force_sso ) {
		$jetpack_force_sso::init();
	}
);

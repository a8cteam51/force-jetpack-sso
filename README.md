# Force Jetpack SSO

This plugin automatically enables [Jetpack's "WordPress.com Secure Sign On" module](https://jetpack.com/support/sso/) in production sites. [Jetpack's Two‑Step Authentication](https://jetpack.com/support/sso/#requiring-two-step-authentication) is also forced on by this plugin.

SSO will automatically be disabled on non-production sites (when the [wp_get_environment_type()](https://developer.wordpress.org/reference/functions/wp_get_environment_type/) function returns anything different than `production`). 

## Usage

1. Download the .zip file from https://github.com/a8cteam51/force-jetpack-sso/releases
2. Via the wp-admin plugins page on your WordPress site, upload the zip file and activate the plugin

## Updates

This plugin will get automatically updated when a new version is released at https://github.com/a8cteam51/force-jetpack-sso/releases.

## Support

**This plugin is unsupported; use at your own discretion**

If you have a problem or suggestion, please make an issue in the repo here: https://github.com/a8cteam51/force-jetpack-sso/issues

Feel free to fork and/or create a PR!

## Compatibility

Installing this plugin on sites with a **membership**, **forum** or any other components **requiring a user log in** isn't recommended, as Jetpack SSO can interfere with their functionality.

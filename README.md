# team51-force-jetpack-sso

This repo is for team51-force-jetpack-sso, powered by WordPress.

## Project Structure

- Git is initialized in the `wp-content` directory
- The main `themes`, `plugins`, and `mu-plugins` directories are ignored
- Project-relevant themes and plugins are added as exceptions to the `.gitignore` file so they will be tracked

If the PHPCS checks are taking too long because of a plugin/code that we aren't responsible for, feel free to include that plugin folder in the files `.vipgoci_lint_skip_folders` and `.vipgoci_phpcs_skip_folders`. Please use this feature sparingly. We view the checks as a safety mechanism that can save sites from serious errors.

If `mu-plugins` are needed for a project, create directories within the `mu-plugins` folder with the filename to be loaded named the same as the folder that it is in. It will be automatically picked up by `mu-plugins/mu-loader.php` which should look something like this:

```
<?php
/**
 * This file is for loading all mu-plugins within subfolders
 * where the PHP file name is exactly like the directory name + .php.
 *
 * Example: /mu-tools/mu-tools.php
 */

$dirs = glob( dirname(__FILE__) . '/*' , GLOB_ONLYDIR );

foreach ( $dirs as $dir ) {
	if ( file_exists( $dir . DIRECTORY_SEPARATOR . basename( $dir ) . '.php' ) ) {
		require_once $dir . DIRECTORY_SEPARATOR . basename( $dir ) . '.php';
	}
}
```

## GitHub Workflow

1. Make your fix in a new branch.
1. Merge your `fix/` branch into the `develop` branch and test on the staging site.
1. If all looks good, make a PR and merge from your fix branch into `trunk`.

NOTE: While PRs are not required to be manually reviewed, we are happy to review any PR for any reason. Please ping us in Slack with a link to the PR.

## Deployment

- Prior to launch, during development, pushing to the `trunk` branch will automatically deploy to the in-progress site at https://
- Once this project is launched, pushing to the `trunk` branch will be reviewed and deployed to the production site by a member of the Special Projects Team (see GitHub workflow above)
- A new dev/staging site will then be created and pushing to the `develop` branch will then automatically deploy that dev/staging site at https://

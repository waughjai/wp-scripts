# WP Scripts

WordPress component for easily adding CSS stylesheets & JavaScript files.

## Examples

	use WaughJ\WPScripts\WPStylesheets;
	WPStylesheets::register( 'main' );

	use WaughJ\WPScripts\WPScripts;
	WPScripts::register( 'blog', true );

## Changelog

### 1.1.0
* Allow multiple scripts through 1 register call using commas.

### 1.0.0
* Initial stable version.

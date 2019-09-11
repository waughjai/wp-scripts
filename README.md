# WP Scripts

WordPress component for easily adding CSS stylesheets & JavaScript files.

## Examples

	use WaughJ\WPScripts\WPStylesheets;
	WPStylesheets::register( 'main' );

	use WaughJ\WPScripts\WPScripts;
	WPScripts::register( 'blog', true );

## Changelog

### 1.3.0
* Add dequeueWPDefaults method for WPStylesheets to dequeue new block library stylesheets for Gutenberg and add wp-embeds to dequeued scripts form WPScripts' dequeueWPDefaults method

### 1.2.0
* Add ability to add meta box to other post types

### 1.1.0
* Allow multiple scripts through 1 register call using commas

### 1.0.0
* Initial stable version.

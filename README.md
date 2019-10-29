# WP Scripts

WordPress component for easily adding CSS stylesheets & JavaScript files.

## Examples

	use WaughJ\WPScripts\WPStylesheets;
	WPStylesheets::init();
	WPStylesheets::dequeueWPDefaults();
	WPStylesheets::register( 'main' );
	WPStylesheets::registerRaw( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', true, '3.4.1' );
	WPScripts::addRegistrator
	(
		function() : array
		{
			return ( true ) ? [ 'page' ] : [ 'nopage' ];
		},
		true
	);
	WPStylesheets::registerPageMetaBox();

	use WaughJ\WPScripts\WPScripts;
	WPScripts::init();
	WPScripts::dequeueWPDefaults();
	WPScripts::register( 'blog', true );
	WPStylesheets::registerRaw( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto', '20190507' );
	WPStylesheets::addRegistrator
	(
		function() : array
		{
			return ( true ) ? [ 'page' ] : [ 'nopage' ];
		}
	);
	WPScripts::registerPageMetaBox();

## Changelog

### 2.0.0
* Separate page meta box registrar from initialization so it can go last.
* Remove WordPress admin pages.

### 1.3.0
* Add dequeueWPDefaults method for WPStylesheets to dequeue new block library stylesheets for Gutenberg and add wp-embeds to dequeued scripts form WPScripts' dequeueWPDefaults method

### 1.2.0
* Add ability to add meta box to other post types

### 1.1.0
* Allow multiple scripts through 1 register call using commas

### 1.0.0
* Initial stable version.

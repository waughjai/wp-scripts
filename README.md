# WAJ Scripts
Contributors: waughjai
Tags: scripts
Requires at least: 5.0.0
Tested up to: 5.0.1
Stable tag: 1.0.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


## Description

WordPress plugin for easily adding CSS stylesheets & JavaScript files.


## Installation

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

The main stylesheet & JavaScript external script can be set in Appearances -> Theme -> Directories. There is also a checkbox for turning off jQuery, which WordPress automatically loads.

Individual pages can have specific stylesheet or JavaScript external scripts added in input boxes on those pages' individual editor pages.

Beyond this, stylesheets & javascript files can be loaded manually in PHP by calling the "register" static method on the WPStylesheets or WPScripts classes. The WPScripts' register method includes an optional boolean 2nd argument to determine whether the script should be loaded in the footer or the header. Default is loading in the footer. "dequeueWPDefaults" static method for the WPScripts class can be used to turn off jQuery in PHP.


## Examples

	use WaughJ\WPScripts\WPStylesheets;
	WPStylesheets::register( 'main' );

	use WaughJ\WPScripts\WPScripts;
	WPScripts::register( 'blog', true );


## Changelog

### 1.0.1
* Fix bug causing meta boxes to try loading empty filename for empty meta boxes.

### 1.0
* Initial stable version.

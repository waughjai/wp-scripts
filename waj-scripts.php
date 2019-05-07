<?php

	/*
	Plugin Name:  WAJ Scripts
	Plugin URI:   https://github.com/waughjai/waj-scripts
	Description:  WordPress plugin for easily adding CSS stylesheets & JavaScript files.
	Version:      1.1.1
	Author:       Jaimeson Waugh
	Author URI:   https://www.jaimeson-waugh.com
	License:      GPL2
	License URI:  https://www.gnu.org/licenses/gpl-2.0.html
	Text Domain:  waj-scripts
	*/

	namespace WaughJ\WPScripts
	{
		require_once( 'vendor/autoload.php' );
		WPStylesheets::init();
		WPScripts::init();
	}
?>

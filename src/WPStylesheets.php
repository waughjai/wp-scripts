<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts;

use WaughJ\FileLoader\FileLoader;
use WaughJ\WPMetaBox\WPMetaBox;

class WPStylesheets
{
	public static function init( array $page_types_for_includer = [ 'page' ] ) : void
	{
		self::$sheet_manager = new WPSheetManager
		(
			new FileLoader
			([
				'directory-url' => get_stylesheet_directory_uri(),
				'directory-server' => get_stylesheet_directory(),
				'shared-directory' => 'css',
				'extension' => 'css'
			]),
			'wp_enqueue_style',
			'wp_enqueue_scripts',
			$page_types_for_includer
		);
	}

	public static function registerPageMetaBox() : void
	{
		self::$sheet_manager->registerPageMetaBox( 'page-css', 'Page Stylesheets' );
	}

	public static function register( string $name ) : void
	{
		self::$sheet_manager->register( $name, 'wp_enqueue_scripts' );
	}

	public static function registerRaw( string $name, string $src, string $version = null ) : void
	{
		self::$sheet_manager->registerRaw( $name, $src, 'wp_enqueue_scripts', $version );
	}

	public static function addRegistrator( callable $function ) : void
	{
		self::$sheet_manager->addRegistrator( $function, 'wp_enqueue_scripts' );
	}

	public static function dequeueWPDefaults() : void
	{
		add_action
		(
			'wp_enqueue_scripts',
			function()
			{
				wp_deregister_style( 'wp-block-library' );
				wp_deregister_style( 'wp-block-library-theme' );
			}
		);
	}

	private static $sheet_manager;
}

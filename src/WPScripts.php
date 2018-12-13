<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	use WaughJ\FileLoader\FileLoader;
	use WaughJ\WPMetaBox\WPMetaBox;

	class WPScripts
	{
		public static function init() : void
		{
			self::$sheet_manager = new WPSheetManager
			(
				new FileLoader
				([
					'directory-url' => get_stylesheet_directory_uri(),
					'directory-server' => get_stylesheet_directory(),
					'shared-directory' => 'js',
					'extension' => 'js'
				]),
				'wp_enqueue_script',
				new WPMetaBox
				(
					'page-js',
					'Page JavaScript'
				),
				'main_js',
				'Main JS',
				'wp_footer'
			);
		}

		public static function register( string $name, bool $load_in_header = false ) : void
		{
			self::$sheet_manager->register( $name, self::getWPHook( $load_in_header ) );
		}

		public static function dequeueWPDefaults() : void
		{
			add_action
			(
				'wp_enqueue_scripts',
				function()
				{
					wp_deregister_script( 'jquery' );
				}
			);
		}

		private static function getWPHook( bool $load_in_header ) : string
		{
			return ( $load_in_header ) ? 'wp_enqueue_scripts' : 'wp_footer';
		}

		private static $sheet_manager;
	}
}

<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	use WaughJ\FileLoader\FileLoader;

	WPScripts::init();

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
				'wp_enqueue_script'
			);
		}

		public static function register( string $name, bool $load_in_header = false ) : void
		{
			self::$sheet_manager->register( $name, self::getWPHook( $load_in_header ) );
		}

		private static function getWPHook( bool $load_in_header ) : string
		{
			return ( $load_in_header ) ? 'wp_enqueue_scripts' : 'wp_footer';
		}

		private static $sheet_manager;
	}
}

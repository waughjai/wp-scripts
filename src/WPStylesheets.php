<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	use WaughJ\FileLoader\FileLoader;

	WPStylesheets::init();

	class WPStylesheets
	{
		public static function init() : void
		{
			self::$loader = new FileLoader
			([
				'directory-url' => get_stylesheet_directory_uri(),
				'directory-server' => get_stylesheet_directory(),
				'shared-directory' => 'css',
				'extension' => 'css'
			]);
		}

		public static function register( string $name ) : void
		{
			add_action( 'wp_enqueue_scripts', self::generateStylesheetRegistrar( $name ) );
		}

		public static function getSource( string $name ) : string
		{
			return self::$loader->getSource( $name );
		}

		public static function getVersion( string $name ) : string
		{
			return ( string )( self::$loader->getVersion( $name ) );
		}

		private static function generateStylesheetRegistrar( string $name ) : callable
		{
			return function () use ( $name )
			{
				wp_enqueue_style( $name, self::getSource( $name ), [], self::getVersion( $name ) );
			};
		}

		private static $loader;
	}
}

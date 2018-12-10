<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	use WaughJ\FileLoader\FileLoader;
	use WaughJ\WPMetaBox\WPMetaBox;

	class WPStylesheets
	{
		public static function init() : void
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
				'wp_enqueue_style'
			);
			self::createPageStylesheetMetaBox();
		}

		public static function register( string $name ) : void
		{
			self::$sheet_manager->register( $name, 'wp_enqueue_scripts' );
		}

		private static function createPageStylesheetMetaBox() : void
		{
			self::$page_stylesheets_meta_box = new WPMetaBox
			(
				'page-css',
				'Page Stylesheets'
			);
		}

		private static $sheet_manager;
		private static $page_stylesheets_meta_box;
	}
}

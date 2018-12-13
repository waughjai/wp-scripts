<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	require_once( 'WPThemeOption.php' );
	require_once( 'WPThemeOptionsPage.php' );
	require_once( 'WPThemeOptionsSection.php' );

	use WaughJ\FileLoader\FileLoader;
	use WaughJ\WPMetaBox\WPMetaBox;
	use function WaughJ\TestHashItem\TestHashItemExists;
	use WaughJ\WPThemeOption\WPThemeOption;
	use WaughJ\WPThemeOption\WPThemeOptionsPage;
	use WaughJ\WPThemeOption\WPThemeOptionsSection;

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
				'wp_enqueue_style',
				new WPMetaBox
					(
						'page-css',
						'Page Stylesheets'
					)
			);

			$page = new WPThemeOptionsPage( 'directories', 'Directories' );
			$section = new WPThemeOptionsSection( $page, 'main_scripts', 'Main Scripts' );
			new WPThemeOption
			(
				$page,
				$section,
				'main_css',
				'Main CSS'
			);
		}

		public static function register( string $name ) : void
		{
			self::$sheet_manager->register( $name, 'wp_enqueue_scripts' );
		}

		private static $sheet_manager;
	}
}

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
				'wp_enqueue_style',
				new WPMetaBox
					(
						'page-css',
						'Page Stylesheets'
					)
			);

			add_action
			(
				'admin_menu',
				function()
				{
					add_options_page
					(
						__( 'Design', 'textdomain' ),
						__( 'Design', 'textdomain' ),
						'manage_options',
						'waj-design',
						function()
						{
							echo '<h1>Design</h1>';
						}
					);

					register_setting
					(
						'waj-design',
						'main-stylesheet',
						[
							'type' => 'string'
						]
					);
				}
			);
		}

		public static function register( string $name ) : void
		{
			self::$sheet_manager->register( $name, 'wp_enqueue_scripts' );
		}

		private static $sheet_manager;
	}
}

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
					add_theme_page
					(
						__( 'Directories', 'textdomain' ),
						__( 'Directories', 'textdomain' ),
						'manage_options',
						'ascendhg_theme_directories',
						function()
						{
							?>
								<div class="wrap">
									<h1>Directories</h1>
									<?php settings_errors(); ?>
									<form method="post" action="options.php">
							            <?php settings_fields( 'main_scripts' ); ?>
							            <?php do_settings_sections( 'main_scripts' ); ?>
							            <?php submit_button(); ?>
							        </form>
								</div>
							<?php
						}
					);
				}
			);

			add_action
			(
				'admin_init',
				function()
				{
					add_settings_section
					(
						'main_scripts',
						__( 'Main Scripts', 'textdomain' ),
						function()
						{
							echo 'scrip';
						},
						'ascendhg_theme_directories'
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

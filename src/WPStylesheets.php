<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	use WaughJ\FileLoader\FileLoader;
	use WaughJ\WPMetaBox\WPMetaBox;
	use function WaughJ\TestHashItem\TestHashItemExists;

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
						'theme_directories',
						function()
						{
							?>
								<div class="wrap">
									<h1>Directories</h1>
									<?php settings_errors(); ?>
									<form method="post" action="options.php">
							            <?php settings_fields( 'theme_directories_options' ); ?>
							            <?php do_settings_sections( 'theme_directories_options' ); ?>
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
					if ( get_option( 'theme_directories_options' ) == false )
					{
						add_option( 'theme_directories_options' );
					}

					add_settings_section
					(
						'main_scripts',
						__( 'Main Scripts', 'textdomain' ),
						function()
						{
						},
						'theme_directories_options'
					);

					add_settings_field
					(
						'main_css',
						__( 'Main CSS', 'textdomain' ),
						function()
						{
							$options = get_option( 'theme_directories_options' );
							$option_value = ( is_array( $options ) )
								? TestHashItemExists( $options, 'main_css', '' )
								: $options;
							?>
								<input type="text" id="main_css" name="theme_directories_options[main_css]" placeholder="Main CSS" value="<?= $option_value; ?>" />
							<?php
						},
						'theme_directories_options',
						'main_scripts'
					);

					register_setting
					(
						'theme_directories_options',
						'theme_directories_options'
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

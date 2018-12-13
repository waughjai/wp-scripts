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

			/*
			add_action
			(
				'customize_register',
				function( $wp_customize )
				{
					$wp_customize->add_section
					(
						'main_scripts',
						[
							'title' => __( 'Main Scripts', get_option( 'stylesheet' ) )
						]
					);

					$wp_customize->add_setting
					(
						'main_stylesheet',
						[
							'type' => 'theme_mod',
							'default' => '',
							'sanitize_callback' => 'sanitize_html_class'
						]
					);

					$wp_customize->add_control
					(
						'main_stylesheet',
						[
							'type' => 'text',
							'section' => 'main_scripts',
							'label' => __( 'Main Stylesheet' ),
							'description' => 'This is the stylesheet that will load on every page.'
						]
					);
				}
			);
			*/

			/*add_options_page
			(
				'Design',
				'Design',
				'manage_options',
				'waj-design',
				function() {}
			);*/
		}

		public static function register( string $name ) : void
		{
			self::$sheet_manager->register( $name, 'wp_enqueue_scripts' );
		}

		private static $sheet_manager;
	}
}

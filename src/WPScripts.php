<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts;

use WaughJ\FileLoader\FileLoader;
use WaughJ\WPMetaBox\WPMetaBox;

class WPScripts
{
	public static function init( array $page_types_for_includer = [ 'page' ] ) : void
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
			'wp_footer',
			$page_types_for_includer
		);
	}

	public static function registerPageMetaBox() : void
	{
		self::$sheet_manager->registerPageMetaBox( 'page-js', 'Page JavaScript' );
	}

	public static function register( string $name, bool $load_in_header = false ) : void
	{
		self::$sheet_manager->register( $name, self::getWPHook( $load_in_header ) );
	}

	public static function registerRaw( string $name, string $src, bool $load_in_header = false, string $version = null ) : void
	{
		self::$sheet_manager->registerRaw( $name, $src, self::getWPHook( $load_in_header ), $version );
	}

	public static function addRegistrator( callable $function, bool $load_in_header = false ) : void
	{
		self::$sheet_manager->addRegistrator( $function, self::getWPHook( $load_in_header ) );
	}

	public static function deregisterWPDefaults() : void
	{
		add_action
		(
			'wp_enqueue_scripts',
			function()
			{
				wp_deregister_script( 'jquery' );
				wp_deregister_script( 'wp-embed' );
			}
		);
		self::removeEmojiScript();
	}

	public static function dequeueWPDefaults() : void
	{
		self::deregisterWPDefaults();
	}

	public static function removeEmojiScript() : void
	{
		// Courtesy of Irina Blumenfeld @ https://www.netmagik.com/how-to-disable-emojis-in-wordpress/
		add_action
		(
			'init',
			function()
			{
				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
				remove_action( 'wp_print_styles', 'print_emoji_styles' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );	
				remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
				remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
				remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
				
				// Remove from TinyMCE
				add_filter
				(
					'tiny_mce_plugins',
					function( $plugins ) : array
					{
						if ( is_array( $plugins ) )
						{
							return array_diff( $plugins, array( 'wpemoji' ) );
						}
						return [];
					}
				);
			}
		);
	}

	private static function getWPHook( bool $load_in_header ) : string
	{
		return ( $load_in_header ) ? 'wp_enqueue_scripts' : 'wp_footer';
	}

	private static $sheet_manager;
	private static $no_jquery_checkbox;
}

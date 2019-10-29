<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts;

use WaughJ\FileLoader\FileLoader;
use WaughJ\WPMetaBox\WPMetaBox;

class WPSheetManager
{
	public function __construct( FileLoader $loader, string $wp_action, string $default_wp_hook = 'wp_enqueue_scripts', array $page_types_for_includer = [ 'page' ] )
	{
		$this->loader = $loader;
		$this->wp_action = $wp_action;
		$this->default_wp_hook = $default_wp_hook;
		$this->page_types_for_includer = $page_types_for_includer;
	}

	public function registerPageMetaBox( string $slug, string $name ) : void
	{
		$meta_box = new WPMetaBox
		(
			$slug,
			$name,
			$this->page_types_for_includer
		);

		add_action
		(
			$this->default_wp_hook,
			function() use ( $meta_box )
			{
				if ( in_array( get_post_type(), $this->page_types_for_includer ) )
				{
					$page_sheets = $meta_box->getValue( get_the_ID(), false );
					if ( $page_sheets )
					{
						foreach ( $page_sheets as $sheet )
						{
							if ( $sheet )
							{
								$this->enqueue( $sheet );
							}
						}
					}
				}
			}
		);
	}

	public function register( string $name, ?string $wp_hook = null ) : void
	{
		add_action( $this->getHook( $wp_hook ), self::generateRegistrar( $name ) );
	}

	public function registerRaw( string $name, string $src, ?string $wp_hook = null, ?string $version = null ) : void
	{
		add_action
		(
			$this->getHook( $wp_hook ),
			function() use ( $name, $src, $version )
			{
				call_user_func( $this->wp_action, $name, $src, [], $version );
			}
		);
	}

	public function addRegistrator( callable $function, ?string $wp_hook = null ) : void
	{
		add_action
		(
			$this->getHook( $wp_hook ),
			function() use ( $function )
			{
				$sheets = $function();
				foreach ( $sheets as $sheet )
				{
					$this->enqueue( $sheet );
				}
			}
		);
	}

	public function getSource( string $name ) : string
	{
		return $this->loader->getSource( $name );
	}

	public function getVersion( string $name ) : string
	{
		return ( string )( $this->loader->getVersion( $name ) );
	}

	private function enqueue( string $name ) : void
	{
		$scripts = explode( ',', $name );
		foreach ( $scripts as $script )
		{
			call_user_func( $this->wp_action, $script, $this->getSource( $script ), [], $this->getVersion( $script ) );
		}
	}

	private function generateRegistrar( string $name ) : callable
	{
		return function () use ( $name )
		{
			$this->enqueue( $name );
		};
	}

	private function getHook( ?string $hook = null ) : string
	{
		return ( $hook ) ? $hook : $this->default_wp_hook;
	}

	private $loader;
	private $wp_action;
	private $default_wp_hook;
	private $page_types_for_includer;
}

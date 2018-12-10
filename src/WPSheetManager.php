<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	use WaughJ\FileLoader\FileLoader;
	use WaughJ\WPMetaBox\WPMetaBox;

	class WPSheetManager
	{
		public function __construct( FileLoader $loader, string $wp_action, WPMetaBox $meta_box )
		{
			$this->loader = $loader;
			$this->wp_action = $wp_action;
			$this->meta_box = $meta_box;
		}

		public function register( string $name, string $wp_hook ) : void
		{
			add_action( $wp_hook, self::generateRegistrar( $name ) );
		}

		public function getSource( string $name ) : string
		{
			return $this->loader->getSource( $name );
		}

		public function getVersion( string $name ) : string
		{
			return ( string )( $this->loader->getVersion( $name ) );
		}

		private function generateRegistrar( string $name ) : callable
		{
			return function () use ( $name )
			{
				call_user_func( $this->wp_action, $name, $this->getSource( $name ), [], $this->getVersion( $name ) );
			};
		}

		private $loader;
		private $wp_action;
		private $meta_box;
	}
}

<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	use WaughJ\FileLoader\FileLoader;
	use WaughJ\WPMetaBox\WPMetaBox;

	class WPSheetManager
	{
		public function __construct( FileLoader $loader, string $wp_action, WPMetaBox $meta_box, string $default_wp_hook = 'wp_enqueue_scripts' )
		{
			$this->loader = $loader;
			$this->wp_action = $wp_action;
			$this->meta_box = $meta_box;
			$this->default_wp_hook = $default_wp_hook;

			add_action
			(
				$this->default_wp_hook,
				function()
				{
					if ( get_post_type() == 'page' )
					{
						$page_sheets = get_post_meta( get_the_ID(), $this->meta_box->getSlug(), false );
						foreach ( $page_sheets as $sheet )
						{
							$this->enqueue( $sheet );
						}
					}
				}
			);
		}

		public function register( string $name, string $wp_hook = null ) : void
		{
			if ( !$wp_hook )
			{
				$wp_hook = $this->default_wp_hook;
			}
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

		private function enqueue( string $name ) : void
		{
			call_user_func( $this->wp_action, $name, $this->getSource( $name ), [], $this->getVersion( $name ) );
		}

		private function generateRegistrar( string $name ) : callable
		{
			return function () use ( $name )
			{
				$this->enqueue( $name );
			};
		}

		private $loader;
		private $wp_action;
		private $meta_box;
		private $default_wp_hook;
	}
}

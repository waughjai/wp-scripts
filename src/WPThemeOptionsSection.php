<?php

declare( strict_types = 1 );
namespace WaughJ\WPThemeOption
{
	class WPThemeOptionsSection
	{
		public function __construct( WPThemeOptionsPage $page, string $slug, string $name )
		{
			$this->page = $page;
			$this->slug = $slug;
			$this->name = __( $name, 'textdomain' );
			add_action( 'admin_init', [ $this, 'register' ] );
		}

		public function register()
		{
			if ( get_option( 'theme_directories_options' ) == false )
			{
				add_option( 'theme_directories_options' );
			}

			add_settings_section
			(
				$this->slug,
				$this->name,
				function()
				{
				},
				$this->page->getOptionsGroup()
			);
		}

		private $page;
		private $slug;
		private $name;
	}
}

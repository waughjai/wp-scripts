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

		public function getSlug() : string
		{
			return $this->slug;
		}

		private $page;
		private $slug;
		private $name;
	}
}

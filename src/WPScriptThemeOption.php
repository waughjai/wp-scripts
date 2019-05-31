<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts;

use WaughJ\WPThemeOption\WPThemeOption;
use WaughJ\WPThemeOption\WPThemeOptionsPage;
use WaughJ\WPThemeOption\WPThemeOptionsPageManager;
use WaughJ\WPThemeOption\WPThemeOptionsSection;

class WPScriptThemeOption
{
    public function __construct( string $option_slug, string $option_name )
    {
		$section = self::getSection();
		$this->option = new WPThemeOption
		(
			$section,
			$option_slug,
			$option_name
		);
    }

    public function getValue()
    {
        return $this->option->getOptionValue();
    }

	public static function getSection() : WPThemeOptionsSection
	{
		if ( self::$theme_options_section === null )
		{
			if ( self::$theme_options_page === null )
			{
				self::$theme_options_page = WPThemeOptionsPageManager::initializeIfNotAlreadyInitialized( 'directories', 'Directories' );
			}
			self::$theme_options_section = new WPThemeOptionsSection( self::$theme_options_page, 'main_scripts', 'Main Scripts' );
		}
		return self::$theme_options_section;
	}

	private static $theme_options_page = null;
	private static $theme_options_section = null;

    private $option;
}

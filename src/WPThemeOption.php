<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	class WPThemeOption
	{
		public function __construct( string $page, string $section, string $slug, string $name )
		{
			$this->page = $page;
			$this->section = $section;
			$this->slug = $slug;
			$this->name = $name;
		}

		private $page;
		private $section;
		private $slug;
		private $name;

		private static $pages_initialized = [];
	}
/*

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
			'main_scripts',
			[ 'label_for' => 'main_css' ]
		);

		register_setting
		(
			'theme_directories_options',
			'theme_directories_options'
		);
	}
);*/
}

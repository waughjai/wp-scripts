<?php

declare( strict_types = 1 );
namespace WaughJ\WPScripts
{
	class WPThemeOptionsPage
	{
		public function __construct( string $slug, string $name )
		{
			$this->slug = $slug;
			$this->name = __( $name, 'textdomain' );
			add_action( 'admin_menu', [ $this, 'register' ] );
		}

		public function register()
		{
			add_theme_page
			(
				$this->name,
				$this->name,
				'manage_options',
				"theme_{$this->slug}",
				[ $this, 'render' ]
			);
		}

		public function render()
		{
			?>
				<div class="wrap">
					<h1><?= $this->name; ?></h1>
					<?php settings_errors(); ?>
					<form method="post" action="options.php">
						<?php settings_fields( 'theme_directories_options' ); ?>
						<?php do_settings_sections( 'theme_directories_options' ); ?>
						<?php submit_button(); ?>
					</form>
				</div>
			<?php
		}

		private $slug;
		private $name;
	}
}

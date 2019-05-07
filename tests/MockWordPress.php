<?php

	use WaughJ\Directory\Directory;
	use function WaughJ\TestHashItem\TestHashItemExists;

	global $enqueued_stylesheets;
	$enqueued_stylesheets = [];
	global $enqueued_scripts;
	$enqueued_scripts = [];
	global $last_type;
	$last_type = null;
	global $actions;
	$actions = [];

	function is_stylesheet_registered( $type )
	{
		global $enqueued_stylesheets;
		return array_key_exists( $type, $enqueued_stylesheets );
	}

	function is_script_registered( $type )
	{
		global $enqueued_scripts;
		return array_key_exists( $type, $enqueued_scripts );
	}

	function get_stylesheet_directory_uri()
	{
		return 'https://www.example.com';
	}

	function get_stylesheet_directory()
	{
		return ( string )( new Directory([ getcwd(), 'tests' ]) );
	}

	function add_action( $type, $action )
	{
		global $last_type;
		$last_type = $type;
		$action( 1 );
	}

	function wp_enqueue_style( $name, $url, $dependencies, $version )
	{
		global $enqueued_stylesheets;
		$enqueued_stylesheets[ $name ] =
		[
			'name' => $name,
			'url' => $url . ( ( $version ) ? '?m=' . $version : '' ),
			'version' => $version
		];
	}

	function wp_enqueue_script( $name, $url, $dependencies, $version )
	{
		global $enqueued_scripts;
		$enqueued_scripts[ $name ] =
		[
			'name' => $name,
			'url' => $url . ( ( $version ) ? '?m=' . $version : '' ),
			'version' => $version
		];
		global $last_type;
		global $actions;
		$actions[ $name ] = $last_type;
		$last_type = null;
	}

	function get_stylesheet_url( $name ) : string
	{
		global $enqueued_stylesheets;
		if ( array_key_exists( $name, $enqueued_stylesheets ) )
		{
			return $enqueued_stylesheets[ $name ][ 'url' ];
		}
		return null;
	}

	function get_script_url( $name ) : string
	{
		global $enqueued_scripts;
		if ( array_key_exists( $name, $enqueued_scripts ) )
		{
			return $enqueued_scripts[ $name ][ 'url' ];
		}
		return null;
	}

	function get_script_action( $name )
	{
		global $actions;
		return TestHashItemExists( $actions, $name, '' );
	}

	function add_meta_box()
	{
		// This doesn't need to do anything here.
	}

	function __( $name )
	{
		return $name;
	}

	function current_user_can()
	{
		return true;
	}

	function get_post_meta()
	{
		return [ 'home' ];
	}

	function get_the_ID()
	{
		return 62;
	}

	function get_post_type()
	{
		return 'page';
	}

	function add_theme_page()
	{
	}

	function register_setting()
	{
	}

	function get_option()
	{
	}

	function add_option()
	{
	}

	function add_settings_section()
	{
	}

	function add_settings_field()
	{
	}

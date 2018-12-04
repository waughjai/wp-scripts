<?php

	use WaughJ\Directory\Directory;

	global $enqueued_stylesheets;
	$enqueued_stylesheets = [];

	function is_stylesheet_registered( $type )
	{
		global $enqueued_stylesheets;
		return array_key_exists( $type, $enqueued_stylesheets );
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
		$action();
	}

	function wp_enqueue_stylesheet( $name, $url, $dependencies, $version )
	{
		global $enqueued_stylesheets;
		$enqueued_stylesheets[ $name ] =
		[
			'name' => $name,
			'url' => $url,
			'version' => $version
		];
	}

	function get_stylesheet_url( $name ) : string
	{
		global $enqueued_stylesheets;
		if ( array_key_exists( $name, $enqueued_stylesheets ) )
		{
			return $enqueued_stylesheets[ $name ][ 'url' ] . '?m=' . $enqueued_stylesheets[ $name ][ 'version' ];
		}
		return null;
	}

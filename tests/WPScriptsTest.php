<?php

require_once( 'MockWordPress.php' );
require_once( 'waj-scripts.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPScripts\WPScripts;

class WPScriptsTest extends TestCase
{
	public function testObjectWorks()
	{
		$this->assertTrue( is_script_registered( 'home' ) );
		$this->assertFalse( is_script_registered( 'main' ) );
		WPScripts::register( 'main' );
		$this->assertTrue( is_script_registered( 'main' ) );
		$this->assertEquals( get_script_url( 'main' ), 'https://www.example.com/js/main.js?m=' . filemtime( getcwd() . '/tests/js/main.js' ) );
		$this->assertEquals( get_script_action( 'main' ), 'wp_footer' );
		WPScripts::register( 'jquery', true );
		$this->assertEquals( get_script_action( 'jquery' ), 'wp_enqueue_scripts' );
	}

	public function testAddRegistrator()
	{
		WPScripts::addRegistrator
		(
			function() : array
			{
				return ( true ) ? [ 'page' ] : [ 'nopage' ];
			},
			true
		);
		$this->assertTrue( is_script_registered( 'page' ) );
		$this->assertFalse( is_script_registered( 'nopage' ) );
		$this->assertEquals( get_script_action( 'page' ), 'wp_enqueue_scripts' );
	}

	public function testRegisterRaw()
	{
		WPScripts::registerRaw( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js' );
		$this->assertTrue( is_script_registered( 'jquery' ) );
		$this->assertEquals( get_script_url( 'jquery' ), 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js' );
	}
}

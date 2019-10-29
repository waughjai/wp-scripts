<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPScripts\WPScripts;

class WPScriptsTest extends TestCase
{
	public function testBasic()
	{
		WPScripts::init();
		$this->assertFalse( is_script_registered( 'main' ) );
		WPScripts::register( 'main' );
		$this->assertTrue( is_script_registered( 'main' ) );
		$this->assertEquals( get_script_url( 'main' ), 'https://www.example.com/js/main.js?m=' . filemtime( getcwd() . '/tests/js/main.js' ) );
		$this->assertEquals( get_script_action( 'main' ), 'wp_footer' );
		WPScripts::register( 'header', true );
		$this->assertEquals( get_script_action( 'header' ), 'wp_enqueue_scripts' );
		WPScripts::registerPageMetaBox();
		$this->assertTrue( is_script_registered( 'home' ) );
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
		WPScripts::registerRaw( 'hammer', 'https://ajax.googleapis.com/ajax/libs/hammerjs/2.0.8/hammer.min.js' );
		$this->assertTrue( is_script_registered( 'hammer' ) );
		$this->assertEquals( get_script_url( 'hammer' ), 'https://ajax.googleapis.com/ajax/libs/hammerjs/2.0.8/hammer.min.js' );
	}

	public function testDequeueWPDefaults()
	{
		$this->assertTrue( is_script_registered( 'jquery' ) );
		$this->assertTrue( is_script_registered( 'wp-embed' ) );
		WPScripts::dequeueWPDefaults();
		$this->assertFalse( is_script_registered( 'jquery' ) );
		$this->assertFalse( is_script_registered( 'wp-embed' ) );
	}
}

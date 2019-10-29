<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPScripts\WPStylesheets;

class WPStylesheetsTest extends TestCase
{
	public function testObjectWorks()
	{
		WPStylesheets::init();
		$this->assertFalse( is_stylesheet_registered( 'main' ) );
		WPStylesheets::register( 'main' );
		$this->assertTrue( is_stylesheet_registered( 'main' ) );
		$this->assertEquals( get_stylesheet_url( 'main' ), 'https://www.example.com/css/main.css?m=' . filemtime( getcwd() . '/tests/css/main.css' ) );
		WPStylesheets::registerPageMetaBox();
		$this->assertTrue( is_stylesheet_registered( 'home' ) );
	}

	public function testAddRegistrator()
	{
		WPStylesheets::addRegistrator
		(
			function() : array
			{
				return ( true ) ? [ 'page' ] : [ 'nopage' ];
			}
		);
		$this->assertTrue( is_stylesheet_registered( 'page' ) );
		$this->assertFalse( is_stylesheet_registered( 'nopage' ) );
		$this->assertEquals( get_stylesheet_url( 'page' ), 'https://www.example.com/css/page.css?m=' . filemtime( getcwd() . '/tests/css/page.css' ) );
	}

	public function testRegisterRaw()
	{
		WPStylesheets::registerRaw( 'rubik', 'https://fonts.googleapis.com/css?family=Rubik:400,500,700' );
		$this->assertTrue( is_stylesheet_registered( 'rubik' ) );
		$this->assertEquals( get_stylesheet_url( 'rubik' ), 'https://fonts.googleapis.com/css?family=Rubik:400,500,700' );
		WPStylesheets::registerRaw( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto', '20190507' );
		$this->assertTrue( is_stylesheet_registered( 'roboto' ) );
		$this->assertEquals( get_stylesheet_url( 'roboto' ), 'https://fonts.googleapis.com/css?family=Roboto?m=20190507' );
	}

	public function testMultipleScripts()
	{
		WPStylesheets::init();
		WPStylesheets::register( 'main,other' );
		$this->assertTrue( is_stylesheet_registered( 'main' ) );
		$this->assertTrue( is_stylesheet_registered( 'other' ) );
	}

	public function testDequeueWPDefaults()
	{
		$this->assertTrue( is_stylesheet_registered( 'wp-block-library' ) );
		$this->assertTrue( is_stylesheet_registered( 'wp-block-library-theme' ) );
		WPStylesheets::dequeueWPDefaults();
		$this->assertFalse( is_stylesheet_registered( 'wp-block-library' ) );
		$this->assertFalse( is_stylesheet_registered( 'wp-block-library-theme' ) );
	}
}

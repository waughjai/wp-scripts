<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPScripts\WPStylesheets;

class WPStylesheetsTest extends TestCase
{
	public function testObjectWorks()
	{
		$this->assertTrue( is_stylesheet_registered( 'home' ) );
		$this->assertFalse( is_stylesheet_registered( 'main' ) );
		WPStylesheets::register( 'main' );
		$this->assertTrue( is_stylesheet_registered( 'main' ) );
		$this->assertEquals( get_stylesheet_url( 'main' ), 'https://www.example.com/css/main.css?m=' . filemtime( getcwd() . '/tests/css/main.css' ) );
	}
}

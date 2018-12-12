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
}

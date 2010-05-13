<?php
require_once "env.php";
require_once "PHPUnit/FrameWork.php";

class ConfigTest extends PHPUnit_FrameWork_TestCase {

	public function testGetInstance(){
		$instance = Config::getInstance();
		$this->assertType("Config",$instance);
	}

	/**
	 * @expectedException FileNotFoundException
	 */
	public function testImport1(){
		Config::import('nonexistent');
	}

	/**
	 * @expectedException ImportException
	 */
	public function testImport2(){
		Config::import('controllers_prueba_pruebaController');
	}

	public function testImport3(){
		Config::import('controllers_content_contentController');
	}

	/**
	 * @expectedException FileNotFoundException
	 */
	public function testLoadController1(){
		Config::loadController("nonexistent");
	}

	/**
	 * @expectedException ImportException
	 */
	public function testLoadController2(){
		Config::loadController("prueba");
	}

	public function testLoadController3(){
		Config::loadController("content");
	}

	/**
	 * @expectedException FileNotFoundException
	 */
	public function testReadInitFile1(){
		Config::readInitFile("/no/config.ini");
	}

	public function testReadInitFile2(){
		Config::readInitFile(CFG."config.ini");
	}

	public function testDefaults(){
		$defaults = Config::getDefaults();
	}
}
?>
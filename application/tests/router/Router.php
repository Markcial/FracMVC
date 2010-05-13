<?php
require_once "../env.php";
require_once "PHPUnit/FrameWork.php";

class RouterTest extends PHPUnit_FrameWork_TestCase {

	/**
     * @expectedException FileNotFoundException
     */
	public function testImportError(){
		Config::loadController("error");
	}

	/**
     * @expectedException LostControllerException
     */
	public function testImportWrongName(){
	   	Config::loadController("prueba");
	}

	public function testImportOk(){
	   	Config::loadController("content");
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* ArchivosController Test cases generated on: 2008-02-18 17:02:42 : 1203370542*/
App::import('Controller', 'Archivos');

class TestArchivos extends ArchivosController {
	var $autoRender = false;
}

class ArchivosControllerTest extends CakeTestCase {
	var $Archivos = null;

	function setUp() {
		$this->Archivos = new TestArchivos();
	}

	function testArchivosControllerInstance() {
		$this->assertTrue(is_a($this->Archivos, 'ArchivosController'));
	}

	function tearDown() {
		unset($this->Archivos);
	}
	
	
}
?>
<?php 
/* SVN FILE: $Id$ */
/* CategoriasController Test cases generated on: 2008-02-18 18:02:08 : 1203373688*/
App::import('Controller', 'Categorias');

class TestCategorias extends CategoriasController {
	var $autoRender = false;
}

class CategoriasControllerTest extends CakeTestCase {
	var $Categorias = null;

	function setUp() {
		$this->Categorias = new TestCategorias();
	}

	function testCategoriasControllerInstance() {
		$this->assertTrue(is_a($this->Categorias, 'CategoriasController'));
	}

	function tearDown() {
		unset($this->Categorias);
	}
}
?>
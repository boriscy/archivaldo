<?php 
/* SVN FILE: $Id$ */
/* UsuariosController Test cases generated on: 2008-03-18 11:03:52 : 1205851852*/
App::import('Controller', 'Usuarios');

class TestUsuarios extends UsuariosController {
	var $autoRender = false;
}

class UsuariosControllerTest extends CakeTestCase {
	var $Usuarios = null;

	function setUp() {
		$this->Usuarios = new TestUsuarios();
	}

	function testUsuariosControllerInstance() {
		$this->assertTrue(is_a($this->Usuarios, 'UsuariosController'));
	}

	function tearDown() {
		unset($this->Usuarios);
	}
}
?>
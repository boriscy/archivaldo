<?php 
/* SVN FILE: $Id$ */
/* Usuario Test cases generated on: 2008-03-18 11:03:22 : 1205850562*/
App::import('Model', 'Usuario');

class TestUsuario extends Usuario {
	var $cacheSources = false;
}

class UsuarioTestCase extends CakeTestCase {
	var $Usuario = null;
	var $fixtures = array('app.usuario', 'app.archivo');

	function start() {
		parent::start();
		$this->Usuario = new TestUsuario();
	}

	function testUsuarioInstance() {
		$this->assertTrue(is_a($this->Usuario, 'Usuario'));
	}

	function testUsuarioFind() {
		$results = $this->Usuario->recursive = -1;
		$results = $this->Usuario->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Usuario' => array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'login'  => 'Lorem ipsum do',
			'pass'  => 'Lorem ipsum dolor sit amet',
			'nombres'  => 'Lorem ipsum dolor sit amet',
			'apellido_p'  => 'Lorem ipsum dolor sit amet',
			'apellido_m'  => 'Lorem ipsum dolor sit amet',
			'nombre_c'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2008-03-18 11:29:21',
			'modified'  => '2008-03-18 11:29:21'
			));
		$this->assertEqual($results, $expected);
	}
}
?>
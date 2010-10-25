<?php 
/* SVN FILE: $Id$ */
/* Archivo Test cases generated on: 2008-02-18 17:02:37 : 1203370297*/
App::import('Model', 'Archivo');

class TestArchivo extends Archivo {
	var $cacheSources = false;
}

class ArchivoTestCase extends CakeTestCase {
	var $Archivo = null;
	var $fixtures = array('app.archivo', 'app.categorium', 'app.permiso');

	function start() {
		parent::start();
		$this->Archivo = new TestArchivo();
	}

	function testArchivoInstance() {
		$this->assertTrue(is_a($this->Archivo, 'Archivo'));
	}

	function testArchivoFind() {
		$results = $this->Archivo->recursive = -1;
		$results = $this->Archivo->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Archivo' => array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'categoria_id'  => 'Lorem ipsum dolor sit amet',
			'nombre'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2008-02-18 17:31:37',
			'modified'  => '2008-02-18 17:31:37',
			'deleted'  => 1,
			'active'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>
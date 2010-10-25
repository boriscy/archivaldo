<?php 
/* SVN FILE: $Id$ */
/* Permiso Test cases generated on: 2008-04-09 17:04:56 : 1207773476*/
App::import('Model', 'Permiso');

class TestPermiso extends Permiso {
	var $cacheSources = false;
}

class PermisoTestCase extends CakeTestCase {
	var $Permiso = null;
	var $fixtures = array('app.permiso', 'app.usuario', 'app.archivo');

	function start() {
		parent::start();
		$this->Permiso = new TestPermiso();
	}

	function testPermisoInstance() {
		$this->assertTrue(is_a($this->Permiso, 'Permiso'));
	}

	function testPermisoFind() {
		$results = $this->Permiso->recursive = -1;
		$results = $this->Permiso->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Permiso' => array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'usuarios_id'  => 'Lorem ipsum dolor sit amet',
			'archivo_id'  => 'Lorem ipsum dolor sit amet',
			'read'  => 1,
			'write'  => 1,
			'modify'  => 1,
			'created'  => '2008-04-09 17:37:56',
			'modified'  => '2008-04-09 17:37:56'
			));
		$this->assertEqual($results, $expected);
	}
}
?>
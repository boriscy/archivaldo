<?php 
/* SVN FILE: $Id$ */
/* Version Test cases generated on: 2008-03-18 11:03:24 : 1205851284*/
App::import('Model', 'Version');

class TestVersion extends Version {
	var $cacheSources = false;
}

class VersionTestCase extends CakeTestCase {
	var $Version = null;
	var $fixtures = array('app.version', 'app.usuario', 'app.archivo');

	function start() {
		parent::start();
		$this->Version = new TestVersion();
	}

	function testVersionInstance() {
		$this->assertTrue(is_a($this->Version, 'Version'));
	}

	function testVersionFind() {
		$results = $this->Version->recursive = -1;
		$results = $this->Version->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Version' => array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'usuarios_id'  => 'Lorem ipsum dolor sit amet',
			'archivo_id'  => 'Lorem ipsum dolor sit amet',
			'numero'  => 1,
			'archivo'  => 1,
			'created'  => '2008-03-18 11:41:24',
			'modified'  => '2008-03-18 11:41:24',
			'size'  => 1,
			'type'  => 'Lorem ipsum dolor sit amet',
			'ultima'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>
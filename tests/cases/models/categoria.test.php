<?php 
/* SVN FILE: $Id$ */
/* Categoria Test cases generated on: 2008-02-18 17:02:44 : 1203369944*/
App::import('Model', 'Categoria');

class TestCategoria extends Categoria {
	var $cacheSources = false;
}

class CategoriaTestCase extends CakeTestCase {
	var $Categoria = null;
	var $fixtures = array('app.categoria', 'app.parent', 'app.archivo');

	function start() {
		parent::start();
		$this->Categoria = new TestCategoria();
	}

	function testCategoriaInstance() {
		$this->assertTrue(is_a($this->Categoria, 'Categoria'));
	}

	function testCategoriaFind() {
		$results = $this->Categoria->recursive = -1;
		$results = $this->Categoria->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Categoria' => array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'parent_id'  => 'Lorem ipsum dolor sit amet',
			'nombre'  => 'Lorem ipsum dolor sit amet',
			'descripcion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,
									phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,
									vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,
									feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
									Orci aliquet, in lorem et velit maecenas luctus, wisi nulla at, mauris nam ut a, lorem et et elit eu.
									Sed dui facilisi, adipiscing mollis lacus congue integer, faucibus consectetuer eros amet sit sit,
									magna dolor posuere. Placeat et, ac occaecat rutrum ante ut fusce. Sit velit sit porttitor non enim purus,
									id semper consectetuer justo enim, nulla etiam quis justo condimentum vel, malesuada ligula arcu. Nisl neque,
									ligula cras suscipit nunc eget, et tellus in varius urna odio est. Fuga urna dis metus euismod laoreet orci,
									litora luctus suspendisse sed id luctus ut. Pede volutpat quam vitae, ut ornare wisi. Velit dis tincidunt,
									pede vel eleifend nec curabitur dui pellentesque, volutpat taciti aliquet vivamus viverra, eget tellus ut
									feugiat lacinia mauris sed, lacinia et felis.',
			'lft'  => 1,
			'rght'  => 1,
			'created'  => '2008-02-18 17:25:44',
			'modified'  => '2008-02-18 17:25:44',
			'deleted'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>
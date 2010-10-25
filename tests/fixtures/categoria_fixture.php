<?php 
/* SVN FILE: $Id$ */
/* Categoria Fixure generated on: 2008-02-18 17:02:44 : 1203369944*/

class CategoriaFixture extends CakeTestFixture {
	var $name = 'Categoria';
	var $table = 'categorias';
	var $fields = array(
			'id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
			'parent_id' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index'),
			'nombre' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
			'descripcion' => array('type'=>'text', 'null' => true, 'default' => NULL),
			'lft' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'rght' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'deleted' => array('type'=>'boolean', 'null' => true, 'default' => '0'),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Index_parent_id' => array('column' => 'parent_id', 'unique' => 0))
			);
	var $records = array(array(
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
}
?>
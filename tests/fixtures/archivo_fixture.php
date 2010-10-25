<?php 
/* SVN FILE: $Id$ */
/* Archivo Fixure generated on: 2008-02-18 17:02:37 : 1203370297*/

class ArchivoFixture extends CakeTestFixture {
	var $name = 'Archivo';
	var $table = 'archivos';
	var $fields = array(
			'id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
			'categoria_id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'index'),
			'nombre' => array('type'=>'string', 'null' => true, 'default' => NULL),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'deleted' => array('type'=>'boolean', 'null' => true, 'default' => '0'),
			'active' => array('type'=>'boolean', 'null' => true, 'default' => '0'),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Index_FKcategoria_id' => array('column' => 'categoria_id', 'unique' => 0))
			);
	var $records = array(array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'categoria_id'  => 'Lorem ipsum dolor sit amet',
			'nombre'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2008-02-18 17:31:37',
			'modified'  => '2008-02-18 17:31:37',
			'deleted'  => 1,
			'active'  => 1
			)
			);
}
?>
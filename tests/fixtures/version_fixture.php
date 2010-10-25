<?php 
/* SVN FILE: $Id$ */
/* Version Fixure generated on: 2008-03-18 11:03:24 : 1205851284*/

class VersionFixture extends CakeTestFixture {
	var $name = 'Version';
	var $table = 'versiones';
	var $fields = array(
			'id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
			'usuarios_id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'index'),
			'archivo_id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'index'),
			'numero' => array('type'=>'integer', 'null' => false, 'default' => '1', 'length' => 10),
			'archivo' => array('type'=>'binary', 'null' => true, 'default' => NULL),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'size' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'type' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'ultima' => array('type'=>'boolean', 'null' => true, 'default' => '1'),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Index_FKusuario_id' => array('column' => 'usuarios_id', 'unique' => 0), 'Index_FKarchivo_id' => array('column' => 'archivo_id', 'unique' => 0))
			);
	var $records = array(array(
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
}
?>
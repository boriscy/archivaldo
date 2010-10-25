<?php 
/* SVN FILE: $Id$ */
/* Permiso Fixure generated on: 2008-04-09 17:04:56 : 1207773476*/

class PermisoFixture extends CakeTestFixture {
	var $name = 'Permiso';
	var $table = 'permisos';
	var $fields = array(
			'id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
			'usuarios_id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'index'),
			'archivo_id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'index'),
			'read' => array('type'=>'boolean', 'null' => true, 'default' => '1'),
			'write' => array('type'=>'boolean', 'null' => true, 'default' => '0'),
			'modify' => array('type'=>'boolean', 'null' => true, 'default' => '0'),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Index_FKusuario_id' => array('column' => 'usuarios_id', 'unique' => 0), 'Index_FKarchivo_id' => array('column' => 'archivo_id', 'unique' => 0))
			);
	var $records = array(array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'usuarios_id'  => 'Lorem ipsum dolor sit amet',
			'archivo_id'  => 'Lorem ipsum dolor sit amet',
			'read'  => 1,
			'write'  => 1,
			'modify'  => 1,
			'created'  => '2008-04-09 17:37:56',
			'modified'  => '2008-04-09 17:37:56'
			));
}
?>
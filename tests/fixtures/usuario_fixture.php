<?php 
/* SVN FILE: $Id$ */
/* Usuario Fixure generated on: 2008-03-18 11:03:21 : 1205850561*/

class UsuarioFixture extends CakeTestFixture {
	var $name = 'Usuario';
	var $table = 'usuarios';
	var $fields = array(
			'id' => array('type'=>'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
			'login' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 16),
			'pass' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 32),
			'nombres' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
			'apellido_p' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
			'apellido_m' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
			'nombre_c' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 150, 'key' => 'index'),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Index_nombre_c' => array('column' => 'nombre_c', 'unique' => 0))
			);
	var $records = array(array(
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
}
?>
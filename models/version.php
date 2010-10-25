<?php
//ñ
class Version extends AppModel {

	public $name = 'Version';
	public $transactional = true;
	public $actsAs = array('TreeFolder'=>array('path'=>'files',
											   'name'=>'nombre',
											  'binaryTreeLog'=>'files/binaryTreeLog.txt') );

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $belongsTo = array(
			'Usuario' => array('className' => 'Usuario',
								'foreignKey' => 'usuario_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Archivo' => array('className' => 'Archivo',
								'foreignKey' => 'archivo_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	
}
?>
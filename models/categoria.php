<?php
class Categoria extends AppModel {

	public $actsAs = array('Tree');
	public $displayField = 'nombre';
	public $order = 'Categoria.lft ASC';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Parent' => array('className' => 'Categoria',
								'foreignKey' => 'parent_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Usuario' => array('className' => 'Usuario',
							   'foreignKey' => 'usuario_id')
	);

	var $hasMany = array(
			'Archivo' => array('className' => 'Archivo',
								'foreignKey' => 'categoria_id',
								'dependent' => true,
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);
	
	var $validate = array('nombre'=>array(
								//'alpha'=>array('rule'=>array('/[a-zñáéíóú]/i')),
								'length'=>array('rule'=>array('between',2,100))
								),
						  
						  );
	

}
?>
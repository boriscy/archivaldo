<?php
class Usuario extends AppModel {

	var $name = 'Usuario';
	var $actsAs = array('Concatenate'=>array('fields'=>array('nombres','apellido_p','apellido_m'),
											 'field'=>'nombre_c') );
	var $displayField = 'nombre_c';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Archivo' => array('className' => 'Archivo',
								'foreignKey' => 'usuario_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Categoria'=>array('className'=>'Categoria',
							   'foreignKey'=>'usuario_id',
							   'dependent'=>false),
			'Version'=>array('className'=>'Version',
							 'foreignKey'=>'usuario_id',
							 'dependent'=>true),
			'Permiso'=>array('className'=>'Permiso',
							 'foreignKey'=>'usuario_id',
							 'dependent'=>false)
	);
	
	var $order = array('apellido_p' => 'ASC', 'apellido_m' => 'ASC', 'nombre_c' => 'ASC');
	
	public $validate = array(
			'login' => array(
				'alpha' => array(
					'rule' => '/^[a-z]{4,16}$/i',
					//'required' => true,
					'message' => 'Solo ingrese de 4 a 16 caracteres alfabeticos'
				),
				'unique' => array(
					'rule' => 'isUnique',
					'message' => 'El login que ingreso ya existe'
				)
			),
			'pass' => array(
				'rule' =>  '/[a-b]+/i',//array('between', 5, 32),
				'message' => 'El password debe estar entre 5 y 32 caracteres',
				//'required' => true
			),
			'nombres' => array(
				'per' => array(
					'rule' => '/^[a-zñ]+[a-zñ\s]*[a-zñ]+$/i',
					'message' => 'Debe Ingresar solo letras'
				),
				'between' => array(
					'rule' => array('between', 4, 50),
					'message' => 'Debe ingresar de 4 a 50 catacteres'
				)
			),
			'apellido_p' => array(
				'per' => array(
					'rule' => '/^[a-zñ]+[a-zñ\s]*[a-zñ]+$/i',
					'message' => 'Debe Ingresar solo letras',
				),
				'between' => array(
					'rule' => array('between', 4, 50),
					'message' => 'Debe ingresar de 4 a 50 catacteres'
				)
			),
			'apellido_m' => array(
				'per' => array(
					'rule' => '/^[a-zñ]+[a-zñ\s]*[a-zñ]+$/i',
					'message' => 'Debe Ingresar solo letras',
				),
				'between' => array(
					'rule' => array('between', 4, 50),
					'message' => 'Debe ingresar de 4 a 50 catacteres'
				)
			)
		);
	
	public function beforeSave(){
		return true;
	}
	/*var $hasAndBelongsToMany = array(
			'Grupo' => array('className' => 'Grupo',
						'joinTable' => 'usuarios_grupos',
						'foreignKey' => 'usuario_id',
						'associationForeignKey' => 'grupo_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);*/

}
?>
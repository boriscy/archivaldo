<?php
class Permiso extends AppModel {

	var $name = 'Permiso';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Usuario' => array('className' => 'Usuario',
								'foreignKey' => 'usuarios_id',
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

	/**
	 *Busca todos los permisos para un determina Archivo, listando todos los usuarios en caso
	 *de que se quiera adicionar nuevos Usuarios a la lista de permisos
	 *@param string $archivo_id
	 *@param string $usuario_id
	 */
	function buscarPermisos($archivo_id=null, $usuario_id=null){
		if($archivo_id!=null && $usuario_id!=null){
			$sql = "SELECT Usuario.id, Usuario.nombre_c, Permiso.id, Permiso.read, Permiso.write
			FROM usuarios Usuario LEFT JOIN permisos Permiso
			ON (Usuario.id=Permiso.usuario_id AND Permiso.archivo_id='$archivo_id')
			WHERE Usuario.id<>'$usuario_id'
			ORDER BY Usuario.nombre_c";
			
			return $this->query($sql);
		}
	}
}
?>
<?php
class Archivo extends AppModel {

	//var $actsAs = array('Tree');
	var $displayField = 'nombre';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Categoria' => array('className' => 'Categoria',
								'foreignKey' => 'categoria_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Usuario' => array('className' => 'Usuario',
							   'foreignKey' => 'usuario_id')
	);

	var $hasMany = array(
			'Version' => array('className' => 'Version',
								'foreignKey' => 'archivo_id',
								'dependent' => true,
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Permiso'=>array('className'=>'Permiso',
							 'foreignKey'=>'archivo_id',
							 'dependent'=>false)
	);
	
	
	/**
	 *Realiza el conteo de cuantos archivos hay que el Usuario puede acceder
	 *@param string $archivo_id
	 *@param string $usuario_id
	 *@param string $alias Alias de Usuario ej('Admin', 'Usuario'...)
	 */
	function archivosCount($params, $alias=null ){

		$filtro = '';
		if(isset($params['conditions']['Archivo.categoria_id']) ){
			$filtro = "AND Archivo.categoria_id='{$params['conditions']['Archivo.categoria_id']}'";
		}
		// Verificacion en caso de que sea Admin
		$usuarioCond = '1=1';
		$usuarioCond2 = '1=1';
		$usuario_id = $params['conditions']['Permiso.usuario_id'];
		if($usuario_id) {
			$usuarioCond = "Archivo.usuario_id= '$usuario_id'";
			$usuarioCond2 = "Permiso.usuario_id='$usuario_id'";
		}
				
		$sql = "SELECT COUNT(*) AS count FROM (
		SELECT Archivo.id FROM archivos Archivo
		WHERE $usuarioCond $filtro
		UNION
		SELECT Archivo.id FROM archivos Archivo JOIN permisos Permiso
		ON (Permiso.archivo_id=Archivo.id AND $usuarioCond2)
		WHERE 1=1 $filtro
		) AS final";
		$count = Set::extract($this->query($sql), "{n}.0.count");
		return $count[0];
	}
	
	function buscarArchivos($params = array(), $alias=null) {
		
		$filtro = '';
		if(isset($params['conditions']['Archivo.categoria_id']) ){
			$filtro = "AND Archivo.categoria_id='{$params['conditions']['Archivo.categoria_id']}'";
		}
		
		$usuario_id = $params['conditions']['Permiso.usuario_id'];
		$usuarioCond = "Archivo.usuario_id = '$usuario_id'";
		if($alias == 'Admin') {
			$usuarioCond = '1=1';
		}
		
		$sql = "SELECT Archivo.id, Archivo.nombre, Archivo.categoria_id,
		Version.id AS version_id, Version.type, Version.size, Version.modified, Version.usuario_id, Version.numero,
		Usuario.nombre_c, Categoria.nombre AS categoria_nombre
		FROM archivos Archivo
		JOIN permisos Permiso ON (Archivo.id=Permiso.archivo_id AND Permiso.usuario_id='$usuario_id')
		JOIN versiones Version ON (Version.archivo_id=Archivo.id AND Version.ultima=1)
		JOIN usuarios Usuario ON (Usuario.id=Version.usuario_id)
		JOIN categorias Categoria ON (Categoria.id=Archivo.categoria_id)
		WHERE 1=1 $filtro
		UNION
		SELECT Archivo.id, Archivo.nombre, Archivo.categoria_id,
		Version.id AS version_id, Version.type, Version.size, Version.modified, Version.usuario_id, Version.numero,
		Usuario.nombre_c, Categoria.nombre AS categoria_nombre
		FROM archivos Archivo
		JOIN versiones Version ON (Version.archivo_id=Archivo.id AND Version.ultima=1)
		JOIN usuarios Usuario ON (Usuario.id=Version.usuario_id)
		JOIN categorias Categoria ON (Categoria.id=Archivo.categoria_id)
		WHERE $usuarioCond $filtro";
		
		$sql.= " ORDER BY {$params['sort']}";
		
		$init = ($params['page']-1)*$params['limit'];
		$init = intval($init);
		$limit = "LIMIT $init, {$params['limit']}";
		$sql.= " $limit";
		
		return $this->query($sql);
	}
	
	/**
	 *Verifica los permisos de un archivo para un usuario
	 *@param string $archivo_id
	 *@param string $usuario_id
	 *@param string $permiso
	 *@param string $alias
	 */
	function verificarPermiso($archivo_id, $usuario_id, $permiso, $alias) {
		if($alias == 'Admin')	
			return true;

		$conditions = array('Archivo.usuario_id'=>$usuario_id,
							'Archivo.id'=>$archivo_id);
		if($this->hasAny($conditions)) {
			return true;
		}
		
		$permisos = array('read', 'write');
		if(in_array($permiso, $permisos) ){
			$permiso = 'Permiso.'.$permiso;
		}else{
			$permiso = 'Permiso.read';
		}
		$conditions = array('Permiso.archivo_id'=>$archivo_id,
							'Permiso.usuario_id'=>$usuario_id,
							$permiso=>1);
		return $this->Permiso->hasAny($conditions);
	}
}
?>

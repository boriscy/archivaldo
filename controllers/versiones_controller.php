<?php
class VersionesController extends AppController
{
	var $helpers = array('icon');
	var $uses = array('Version', 'Archivo');
	/**
	 *Presenta todas las version de un archivo
	 *@param string $archivo_id Aunque tambien el parametro espasado mediante la forma
	 */
	function view($archivo_id=null){
		if(isset($this->params['form']['archivo_id']) ){
			$archivo_id = Sanitize::escape($this->params['form']['archivo_id']);
		}
		$this->Version->recursive = 0;
		$conditions = array('Version.archivo_id'=>$archivo_id);
		//$total = $this->Version->findCount($conditions);
		$versiones = $this->Version->findAll($conditions,
										array('Version.id',
											  'Version.numero',
											  'Usuario.nombre_c',
											  'Version.modified',
											  'Version.size'
											),
										'Version.numero DESC');
		$this->set(compact('versiones'));
	}
	
	/**
	 *Permite adicionar un nuevo archivo
	 */
	public function add() {
		
		$res['success'] = true;
		$data['nombre'] = $this->data['Version']['file']['name'];
		$data['tmp_name'] = $this->data['Version']['file']['tmp_name'];
		$data['size'] = $this->data['Version']['file']['size'];
		$data = Sanitize::clean($data);
		$data['type'] = Sanitize::escape($this->data['Version']['file']['type']);
		$data['archivo_id'] = Sanitize::escape($this->data['Version']['archivo_id']);
		$data['usuario_id'] = Sanitize::escape($this->Session->read('usuario_id'));
		
		#Verificar Permisos
		if($this->Archivo->verificarPermiso($data['archivo_id'], $this->Session->read('usuario_id'), 'write') ) {
			#Verificación el tipo de archivo
			$this->Archivo->unbind();
			$this->Archivo->unbindModel(array( 'hasMany' => array('Permiso') ) );			
			$archivo = $this->Archivo->findById($data['archivo_id']);
			
			$f = new File($data['nombre']);
			$ext1 = $f->ext();
			$f = new File($archivo['Archivo']['nombre']);
			$ext2 = $f->ext();
			
			if(true || $archivo['Archivo']['type']==$data['type'] && $ext1==$ext2) {
				
				$this->Version->begin();
				$save = true;
				$num = $this->Version->find('count', array('conditions' => array('Version.archivo_id' => $archivo['Archivo']['id']) ) );
				
				if(!$this->Version->updateAll(array('Version.ultima' => 0), array('Version.archivo_id' => $archivo['Archivo']['id'] ) ) ) {
					$save = false;
				}
				$data['numero'] = $num+1;
				if(!$this->Version->save($data)) {
					$save = false;
				}
				
				if($save) {
					$this->Version->commit();
				} else {
					$res['success'] = false;
					$this->Version->rollback();
					$res['error'] = 'No se pudo guardar, intente de nuevo';
				}
			}else{
				$res['success'] = false;
				$res['error'] = 'Debe subir un archivo del mismo tipo';
			}
			
		}else{
			$this->log('No pasa nada');
			$res['success'] = false;
			$res['error'] = 'Usted no tiene permiso de escritura';
		}
		$this->layout = 'ajax';
		$this->set(compact('res'));
		
		$this->render('../pages/json');
	}
	
	/**
	 *Funcion para realizar las descargas de Versiones
	 *@param string $id ID de la version que se desea descargar
	 */
	function download($id){
		
		$id = Sanitize::escape($id);
		//$this->Version->unbind();
		$archivo = $this->Version->findById($id);
		$archivo_id = $archivo['Archivo']['id'];
		
		#Permitir la descarga del archivo si tiene los permisos
		if(!$this->Archivo->verificarPermiso($archivo_id, $this->Session->read('usuario_id'), 'read', $this->Session->read('alias')) ){
			$this->flash("Existio un error no es posible descargar el Archivo", "/categorias/index");
		}else{
			$f = new File($archivo['Version']['nombre']);
			header('Content-type: ' . $archivo['Archivo']['type']);
			header('Content-length: ' . $archivo['Version']['size']);
			header('Content-Disposition: attachment; filename="'.$archivo['Archivo']['nombre'].'"');
			echo $f->read();
			Configure::write('debug',0);
			exit(0);
		}
	}
}
?>

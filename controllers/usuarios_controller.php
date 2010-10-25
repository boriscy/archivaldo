<?php
class UsuariosController extends AppController {

	var $name = 'Usuarios';
	var $helpers = array('Html', 'Form');
	var $paginate = array(
		'limit' => 25,
		'order' => array(
			'Usuario.nombre_c' => 'asc'
		)
	);
	
	function index() {
		$this->layout = 'html';
		$this->Usuario->recursive = 0;
		$this->set('usuarios', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Usuario.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('usuario', $this->Usuario->read(null, $id));
	}

	function add() {
		$this->layout = 'html';
		if (!empty($this->data)) {
			$this->Usuario->create();
			$data = $this->data;
			$data['Usuario']['pass'] = md5(sha1($this->data['Usuario']['pass']));
			if ($this->Usuario->save($data)) {
				$this->Session->setFlash(__('Se salvo correctamente el Usuario', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Error: El Usuario no se puedo salvar. Intente de Nuevo', true));
			}
			
		}
	}
	
	function edit($id = null) {
		$this->layout = 'html';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Usuario', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->Usuario->id = $this->data['Usuario']['id'];
			if ($this->Usuario->save($this->data)) {
				$this->Session->setFlash(__('El usuario Ha sido modificado', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Error: El Usuario no se puedo salvar. Intente de Nuevo', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Usuario->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Usuario', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Usuario->del($id)) {
			$this->Session->setFlash(__('Usuario deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	/**
	 *Permite logerase a un Usuario
	 *@return void
	 */
	function login(){
		$res['success'] = false;
		if(!empty($this->data)){
			$data = Sanit::cls($this->data);
			$data['Usuario']['pass'] = md5(sha1($data['Usuario']['pass']));
			$this->Usuario->unbind();
			$cond = array('Usuario.login'=>$data['Usuario']['login'], 'Usuario.pass'=>$data['Usuario']['pass']);
			$data = $this->Usuario->find($cond);
			
			if(isset($data['Usuario']['login'])){
				$res['success'] = true;
				$this->Session->write('usuario_id',$data['Usuario']['id']);
				$this->Session->write('alias', $data['Usuario']['alias_acl']);
				$res['data'] = $this->data['Usuario'];
				$res['__logged'] = true;
				$res['nombre'] = $data['Usuario']['nombre_c'];
				$this->Session->write('nombre', $data['Usuario']['nombre_c']);
			}
		}else{
			$res['data'] = 'No data';
		}
		
		$this->set(compact('res'));
	}
	
	/**
	 *Permite que un usuario salga de la sesion
	 *@return void
	 */
	function logout($ajax = null){
		$res['success'] = false;
		$this->Session->destroy();
		if( $ajax==='ajax'){
			$this->layout = 'ajax';
			//$res['s'] = 'logout';
			$this->set(compact('res'));
		}else{
			$this->redirect("/");
		}
	}
	
	/**
	 *Se cambia el password
	 *@return void
	 */
	function cambiarPass(){
		
		$res['success'] = false;
		if(!empty($this->data) && $this->Session->read('usuario_id')){
			$data = Sanit::cls($this->data);
			
			if($data['Usuario']['nuevo_pass2']===$data['Usuario']['nuevo_pass'] ){
				$buscar['Usuario.id'] = $this->Session->read('usuario_id');
				$buscar['Usuario.pass'] = md5(sha1($data['Usuario']['pass']));
				#Encriptación
				$data['Usuario']['nuevo_pass'] = md5(sha1($data['Usuario']['nuevo_pass']));
				
				if($this->Usuario->hasAny($buscar)){
					
					$this->Usuario->id = $this->Session->read('usuario_id');
					
					if($this->Usuario->saveField('pass',$data['Usuario']['nuevo_pass'])){
						$res['success'] = true;
					}
					$res['usuario_id'] = $this->Session->read('usuario_id');
				}
			}
		}
		$this->set(compact('res'));
	}
	
	/**
	 *Retorma un alista de usuarios
	 *@return mixed puede retornar una lista en array o para poder ser desplegado por un como Ext
	 */
	function lista($case = null, $opt = array()){
		/*$uri = $this->name.'::lista';
		$user = 'Admin';
		if($this->Acl->check($user, $uri, 'read') ){
			echo "si ".$uri;
		}else{
			echo "no ".$uri;
		}*/
		
		if($case === null){
			return $this->Usuario->find('list');
		}
		if($case === 'ext'){
			return $this->extList($this->Usuario->find('list', $opt));
		}
	}

}
?>
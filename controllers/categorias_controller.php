<?php
/*
 *Año y clase
 */
class CategoriasController extends AppController {

    var $name = 'Categorias';
    var $helpers = array('Tree');
    
    function beforeFilter()
    {
        #Acciones que puede ver siempre que este logueado
        //$this->checkAcl();
        // ensure our ajax methods are posted
        //$this->Security->requirePost('getnodes', 'reorder', 'reparent','edit','view');
    }
    
    function nu(){
        /*$this->action = 'add';
        $this->viewPath = 'archivos';
        //echo format('d-m-Y', date());*/
        $this->set('res',array('je'=>1212));
        $this->render('../archivos/add');
    }
    
    
    function getnodes(){
        #$this->redirect("/categorias/index");
        exit(0);
    }

    /*
    function getnodes()
    {    
            // retrieve the node id that Ext JS posts via ajax
            $parent = intval($this->params['form']['node']);
            
            // find all the nodes underneath the parent node defined above
            // the second parameter (true) means we only want direct children
            $nodes = $this->Categoria->children($parent, true);
            
            // send the nodes to our view
            $this->set(compact('nodes'));    
    }*/

    /**
     *Inicio
     */
    function index()
    {
        $this->Categoria->recursive = 0;
        $this->Categoria->unbind('belongsTo');
        $categorias = $this->Categoria->find('all', array('order'=>'lft ASC') );
        $this->set( compact('categorias') );
    }
    
    /**
     *Presenta los datos de una categoría
     *@param string $id ID del nodo
     */
    function view($id=null)
    {
        $id = Sanitize::escape($this->params['form']['id']);
        $this->Categoria->recursive = 0;
        $this->Categoria->unbindModel(array('belongsTo'=>array('Parent','Usuario') ) );
        $res['success'] = 1;
        $res['data'] = Set::extract($this->Categoria->findById("$id"),"Categoria");
        $this->set(compact('res'));
    }
    
    /**
     *Reordena un nodo
     */
    function reorder()
    {
	$res = array('success' => 0);	
	if($this->Session->read('alias') == 'Admin') {
		// retrieve the node instructions from javascript
		// delta is the difference in position (1 = next node, -1 = previous node)
		$data['id'] = trim($this->params['form']['id']);
		$data['delta'] = intval($this->params['form']['delta']);
		$data = Sanit::cls($data);
		extract($data);
		
		$res = array('success'=>0);
		if ($delta > 0) {
		    if($this->Categoria->movedown("$id", abs($delta)) )
			$res = array('success'=>1);
		} elseif ($delta < 0) {
		    if($this->Categoria->moveup("$id", abs($delta)))
			$res = array('success'=>1);
		}
        	$res['data'] = $data;
	}
        $this->set(compact('res'));
    }
    
    /**
     *Cambia el parent de un nodo
     */
    function reparent()
    {
	$res = array('success' => 0);	
	if($this->Session->read('alias') == 'Admin') {
		$data['id'] = trim($this->params['form']['id']);        
		$data['parent_id'] = trim($this->params['form']['parent_id']);
		if($data['parent_id']==='raiz')$data['parent_id'] = null;
		$data['position'] = trim($this->params['form']['position']);
		$data = Sanit::cls($data);
		extract($data);
		
		// save the employee node with the new parent id
		// this will move the employee node to the bottom of the parent list
		$res = array('success'=>0);
		$this->Categoria->id = "$id";
		if($this->Categoria->saveField('parent_id', "$parent_id")){
		    $res = array('success'=>1);
		}
		$res['data'] = $data;
	}
        // send success response
        $this->set(compact('res'));
    }

    /**
     *Adiciona un nodo
     *@return array
     */
    function add()
    {
	$res = array('success' => 0);
	if($this->Session->read('alias') == 'Admin') {

		$data = Sanit::cls($this->data);
		if($data['Categoria']['parent_id']==='' || $data['Categoria']['parent_id']==='raiz'){
		    $data['Categoria']['parent_id'] = null;
		}
		if($this->Categoria->save($data)){
		    $data['Categoria']['id'] = $this->Categoria->getLastInsertID();            
		    $res = array('success'=>1, 'data'=>listArray($data));
		}else{
		    $res = array('success'=>0, 'data'=>$data);
		}
	}
        $this->set(compact('res'));
    }

    /**
     *Editar nodo
     *@return array
     */
    function edit($id = null)
    {
	$res = array('success' => 0);
        if(!empty($this->data) && $this->Session->read('alias') == 'Admin') {
            $data = Sanit::cls($this->data);
            #Se debe hacer esto para que no reparente u ordene
            unset($data['Categoria']['parent_id']);
            if($this->Categoria->save($data) ) {
                $res = array('success'=>true, 'data'=>listArray($data));
            }
        }
        
        $this->set(compact('res'));
    }

    /**
     *Borra un nodo
     *@return array
     */
    function delete() {
        #POST
	$res = array('success' => 0);
	
	if($this->Session->read('alias') == 'Admin') {
		$id = $this->params['form']['id'];
		$id = Sanitize::escape($id);
		#Respuesta
		$res['success'] = false;
		if($this->Categoria->del($id))
		    $res['success'] = true;
	}
        $this->set(compact('res'));
    }
    
    /**
     *Lista en forma de árbol
     *@return array
     */
    function treelist($view = null){
        //Presentacion de la vista en caso de que sea una llamada ajax
        $cats = $this->Categoria->generatetreelist(null, null, null,"-");
        if(isset($this->params['return'])){
            return $cats;
        }else{
            $this->set(compact('cats'));
        }
    }
    
    /**
     *Retorna ua lista de las categorias
     *@return array
     */
	function lista(){
		return $this->Categoria->find('list');
	}
}
?>

<?php
/*
 *Año
*/
class ArchivosController extends AppController
{

    var $name = 'Archivos';
    var $helpers = array('Html', 'Form', 'Javascript','Icon');
    var $uses = array('Archivo','Version','Categoria');
    //var $components = array('TreeFolder');

    function test() {
        //$this->layout = 'ajax';
        $data = array();
        if(!empty($this->data)){
            $data = $this->data;
        }
        $this->Categoria->recursive = 0;
        $data = $this->Categoria->find('all',array('conditions'=>array('Categoria.deleted'=>'1'),
                                                   'order'=>array('Categoria.created'=>'DESC'),
                                                   'limit'=>'0,5',
                                                   'fields'=>array('Categoria.nombre', 'Categoria.created') ) );
        $this->set(compact('data'));
    }
    
    function index()
    {
        //
    }
    
    function menu(){
        #include_once('components/tree_folder.php');
        #$this->TreeFolder = new TreeFolderComponent();
        
    }
    
    /**
     *Prueba de subida de archivos a un directorio
     */
    function subir(){
        $d = date('Y/m/d H:i:s');
        $arch = 'nu.txt';
        $f = new File('files/nu.txt');
        if(!$f->exists()){
            $f->create();
        }
        //$f->write('hola, como estas, '.$d);
        $handle = $f->read();
        pr($data);
        $error = uniqid();
        
        $path = Helper::url('/webroot/files/');        
        //$this->TreeFolder->dateFolder('files/');
        //$f = new Folder($path);
        //echo $f->pwd();
        //echo $fo->inPath('files/jeje.txt');        
        $this->log(print_r($this->params['form'], 1) );
        //pr(Folder::tree('/'));
        $this->layout = 'ajax';
    }
    
    /**
     *Presenta la vista de todos los Archivos y permite paginacion y ordenameinto
     *@param int $limit
     *@param int $page
     */
    function view($limit=5, $page=1) {
        
        $form = $this->params['form'];
        if(isset($form['limit']) && intval($form['limit'])>0){
            $limit = $form['limit'];
        }
        if(isset($form['start']) && intval($form['start'])>0){
            $page = intval($form['start']/$limit)+1;
        }
        
        #Condiciones para filtrar la información
        $conditions['Archivo.deleted'] = "0";
        $conditions['Version.ultima'] = '1';
        if(isset($this->params['form']['categoria_id'])) {
            $conditions['Archivo.categoria_id'] = Sanitize::escape($this->params['form']['categoria_id']);
            if($conditions['Archivo.categoria_id']==='raiz'){
                unset($conditions['Archivo.categoria_id']);
            }
        }
       
	// En caso de que sea Admin	
	if($this->Session->read('alias') == 'Admin') {
        	$conditions['Permiso.usuario_id'] = false;
	}else {
		$conditions['Permiso.usuario_id'] = $this->Session->read('usuario_id');
	}
        
        #Orden
        $sort = 'modified DESC';
        if(isset($form['sort']) ) {
            $ord = strtoupper($form['dir']) === 'DESC' ? 'DESC' : 'ASC';            
            $sort = $form['sort'];
            $sort = Sanitize::escape("$sort $ord");
        }
        
        $archivos = array();
        #Parametros para busqueda
        $params = array('conditions'=>$conditions,
                        'sort'=>$sort,
                        'limit'=>$limit,
                        'page'=>$page);
        
        $count = $this->Archivo->archivosCount($params, $this->Session->read('alias') );
        $archivos = $this->Archivo->buscarArchivos($params, $this->Session->read('alias') );
        $archivos = Set::extract($archivos, "{n}.0");
		 
        $this->set(compact('archivos'));
        $this->set(compact('count'));
        //$this->set('categorias', $this->requestAction('/categorias/lista/') );
    }
    
    /**
     *Permite la adición de nuevos archivos o versiones dependiendo del parametro que se pase
     *
     */
    public function add() {
        
        $this->layout = 'ajax';
        #Revisar Permiso de la persona que hace el Upload
        $res['success'] = true;
        if(isset($this->params['form'])) {
            $form = $this->params['form'];
            $categoria_id = Sanitize::escape($form['categoria_id']);
            
            $data['categoria_id'] = $categoria_id;
            $data['nombre'] = $form['file']['name'];
            $data['type'] = $form['file']['type'];
            $data['tmp_name'] = $form['file']['tmp_name'];
            $data['size'] = $form['file']['size'];
            $data['usuario_id'] = $this->Session->read('usuario_id');
            
            #Inicio de la Transaccion
            $save = true;
            $this->Archivo->begin();
            $this->Archivo->create($data);
            if(!$this->Archivo->save($data) ) {
                $res['success'] = false;
            }else{
                $data['archivo_id'] = $this->Archivo->getLastInsertID();
            }
            //$this->log(sprintf("Archivo %s",$data['archivo_id'] ));
            #Salvar Version
            if($res['success']) {
                $dataVer['Version'] = $data;
                $this->log($data);/////////
                if(!$this->Version->save($dataVer) ) {
                    $res['success'] = false;
                    $this->log($this->Archivo->Version->errors);
                    //$res['error'] = $this->Archivo->Version->validationErrors['Version']['nombre'];
                }
            }
            //$this->Archivo->rollback();/////////
            
            if($res['success']) {
                $this->Archivo->commit();
            }else{
                $this->Archivo->rollback();
                //$res['error'] = 'La categoría que ha elejido no Existe';
            }
            $this->set(compact('res'));
        }
    }
    

    function edit($id = null) {
            /*
    if (!$id && empty($this->data)) {
                    $this->Session->setFlash(__('Invalid Archivo', true));
                    $this->redirect(array('action'=>'index'));
            }
            if (!empty($this->data)) {
                    if ($this->Archivo->save($this->data)) {
                            $this->Session->setFlash(__('The Archivo has been saved', true));
                            $this->redirect(array('action'=>'index'));
                    } else {
                            $this->Session->setFlash(__('The Archivo could not be saved. Please, try again.', true));
                    }
            }
            if (empty($this->data)) {
                    $this->data = $this->Archivo->read(null, $id);
            }
            $categorias = $this->Archivo->Categoria->find('list');
            $this->set(compact('categorias'));
    */
        if(isset($this->data['Archivo'])){
            //$this->data['Archivo']['nuevo'] = Sanitize::escape($this->data['Archivo']['nuevo']);
        }
        $this->layout = "ajax";
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Archivo', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Archivo->del($id)) {
            $this->Session->setFlash(__('Archivo deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }
}
?>

<?php
//uses('Acl');
class IniaclsController extends AppController
{
    var $components = array('Acl');
    var $uses = array('Usuario');
    var $modelos = array('Archivo', 'Categoria', 'Usuario', 'Version');
    
    function prueba(){
        $aro = new Aro();
        //$aro->create();
        /*$aro->save(array(
            'model'=>"Categoria",
            'foreign_key'=>null,
            'parent_id'=>null,
            'alias'=>"Categorias::reorder",
            ));
        /*
        $aco->create();
        $aco->save(array(
            'model'=>"Categoria",
            'foreign_key'=>null,
            'parent_id'=>null,
            'alias'=>"Categorias::reparent",
            ));
        */
        //$this->Acl->allow('Admin', 'Categorias::reorder', '*');
        //$this->Acl->allow('Admin', 'Categorias::reparent', '*');
    }
    
    /**
     *Lista de acciones
     */
    var $controllers = array('Archivos'=>
                                //Lista de Acciones no comunes distintas a: (index, view, add, create, update, edit, delete)
                                array('download'),
                             'Categorias'=>array('treelist', 'reorder', 'reparent'),
                             'Usuarios'=>array(/*'login','logout', */'cambiarPass', 'lista'),
                             'Versiones'=>array('download')
                            );
    
   
    /**
     *Retorna la lista de modelos
     */
    function listaModelos(){
        return $this->modelos;
    }
    
    function __autoload($name){
        require_once($name.'.php');
    }
    /**
     *Creacion de aco por alias
     */
    function crearAco() {
        $aco = new Aco();
        if(!empty($this->data)){
            $aco->create();
            $aco->save(array(
                'model'=>"{$this->modelos[$this->data['Iniacl']['modelo']]}",
                'foreign_key'=>null,
                'parent_id'=>null,
                'alias'=>"{$this->data['Iniacl']['alias']}"
                ));
        }
        $aco->unbind();
        $this->set('acos',$aco->find('all', array('order'=>'Aco.alias ASC')) );
        /*$cont = 'categorias_controller';
        $this->__autoload("$cont");
        $co = Inflector::camelize($cont);
        $obj = new $co();
        pr(get_class_methods($obj));*/
        //$this->set('controladores', $this->controllers);
    }
    
    /**
     *Funcion que permite crear los Aros
     */
    function crearAro(){
        $aro = new Aro();
        if(!empty($this->data)){
            $aro->create();
            $aro->save(array(
                'model'=>"Usuario",
                'foreing_key'=>null,
                'parent_id'=>null,
                'alias'=>"{$this->data['Iniacl']['alias']}"));
        }
        $aro->unbind();
        $this->set('aros', $aro->find('all', array('order'=>'Aro.alias ASC') ) );
    }
    
    /**
     *funcion para dar permisos
     */
    function permisos(){
        $aro = new Aro();
        $aro->unbind();
        $this->set('aros', Set::combine($aro->find('all'), "{n}.Aro.id", "{n}.Aro.alias") );
    }
    
    function crearPermisos(){
        $aro = new Aro();
        $aros = Set::combine($aro->find('all'), "{n}.Aro.id", "{n}.Aro.alias");
        $this->set(compact('aros') );
        if(!empty($this->data)){
            
            foreach($this->data as $k=>$v){
                $array = array();    
                if(isset($this->data[$k]['create']) ){
                    foreach( $v as $key=>$val ){
                        if($val){
                            $array[] = $key;
                        }
                    }
                    
                    $this->Acl->allow($aros[$this->data['Aro']['alias']], $k, $array);
                }
            }
        }
        
        $this->set('controladores', $this->controllers);
    }
    

  function ini()
  {
    $aro = new Aro();

    $aro->create();
    $aro->save(array(
      'model'=>'Usuario',
      'foreign_key'=>null,
      'parent_id'=>null,
      'alias'=>'Admin'));

    $aro->create();
    $aro->save(array(
      'model'=>'Usuario',
      'foreign_key'=>null,
      'parent_id'=>null,
      'alias'=>'Usuario'));

    /*$aro->create();
    $aro->save(array(
      'model'=>'User',
      'foreign_key'=>null,
      'parent_id'=>null,
      'alias'=>'Guest'));
    */
    $parent = $aro->findByAlias('Admin');
    $parentId = $parent['Aro']['id'];

    
    $aro->create();
    $aro->save(array(
      'model'=>'Usuario',
      'foreign_key'=>1,
      'parent_id'=>$parentId,
      'alias'=>'Usuario::47efb3fe-3018-4aed-b334-09c45340dbed'));
        
    
    $aco = new Aco();
    $aco->create();
    $aco->save(array(
       'model'=>'Usuario',
       'foreign_key'=>null,
       'parent_id'=>null,
       'alias'=>'Usuario'));
    $aco->create();
    $aco->save(array( 'model'=>'Categoria', 'foreing_key'=>null, 'parent_id'=>null, 'alias'=>'Categoria') );
    /*   
    $aco->create();
    $aco->save(array(
       'model'=>'Post',
       'foreign_key'=>null,
       'parent_id'=>null,
       'alias'=>'Post'));*/
    
    $this->Acl->allow('Admin', 'Usuario', '*');
   }
    
   // Give admin full control over acos 'User' & 'Post'
   
   //$this->Acl->allow('Admin', 'Post', '*');

   // Give the user group only create & read access for 'Post' 
   //$this->Acl->allow('User', 'Post', array('create', 'read'));

   // Give the Guests only create access for 'User'
   //$this->Acl->allow('Guest', 'User', 'create');
}
?>
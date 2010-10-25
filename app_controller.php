<?php
/**
 *@author Boris Barroso
 *Prueba de actualizacion
 */
class AppController extends Controller
{
    var $helpers = array('Html', 'Form', 'Javascript');
    var $components = array(/*'Security',*/'RequestHandler', 'Acl');
    
    /**
     *Realiza la revision de los ACL
     *$paramas array Parametros
     *$params['allowed'] array lista de acciones permitidas
     */
    protected function checkAcl($params = array() ) {
        
        if(isset($params['allowed']) && is_array($params['allowed']) && in_array($this->action, $params['allowed']) ){
            return ;
        }
        
        $redirectUrl = '/pages/forbiddenUri/';
        if( $this->RequestHandler->isAjax() ){
            $redirectUrl.= 'ajax';
        }
        
        #Revision de existencia de la sesion
        if($this->Session->read('usuario_id')=='') {
            $this->redirect($redirectUrl);
            return ;
        }
        
        
        $actions = array("read", "index", "view", "add", "create", "update",  "edit", "delete");
            
        if(in_array($this->action, $actions ) ){
            $action = "";
            if($this->action==="add" || $this->action==="create"){
                $action = "create";
            }
            if($this->action==="edit" || $this->action==="update"){
                $action = "update";
            }
            if($this->action==="read" || $this->action==="index" || $this->action==="view"){
                $action = "read";
            }
            if($this->action==="delete"){
                $action = "delete";
            }
            $aco = $this->name;
            
        }else{
            $aco = $this->name.'::'.$this->action;
            $action = "read";
        }
        
        if(!$this->Acl->check($this->Session->read("alias"), $aco, $action) ){
            $this->redirect($redirectUrl);
        }
    }

    function beforeFilter() {
        
        if($this->RequestHandler->isAjax()){
            $this->layout = 'ajax';
        }
    }
    
    
    /**
     *Acciones a ejecutarse antes de presentar la vista
     */
    function beforeRender(){
        if($this->Session->read('usuario_id') ) {
            //echo header("logged:1");
        }
    }
    
    /**
     *prepara una lista  en JSON para Extjs, es necesario recibir los datos en forma de lista
     *@param array $opt Parametros para realizar la busqueda
     *@param array $extra Parametros extra para dar un formato, etc
     *@return string
     */
    function extList($data, $opt=null, $extra=null){
        $value = '';
        foreach($data as $k=>$v){
			$value.= '["'.$k.'", "'.$v.'"],';
		}
        
        return '['.substr($value,0, strlen($value)-1 ).']';
    }
    
}
?>

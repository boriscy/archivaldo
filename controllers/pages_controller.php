<?php
/**
 *
 *
 */
class PagesController extends AppController
{
    var $uses = array();
    
    function beforeFilter() {
        //$this->Auth->allow('prueba');
        $allowed = array('home', 'forbiddenUri', 'prueba');
        $this->checkAcl(array('allowed'=>$allowed) );
        #Necesario para que no borre los datos
    }
    
    
    function prueba(){
        $action = 'read';
        echo $this->Session->read('alias');
    }
    
    /**
     *Pagina de Inicio
     */
    function home(){
        if( $this->Session->read('usuario_id') !='' ){
            $this->redirect("/categorias/");
        }
        $this->pageTitle = "Bienvenido al sistema de manejo de archivos \"".PROG_NAME."\"";
    }
    
    /**
     *Presenta los mensajes para URI prohibiros
     */
    function forbiddenUri($ajax = null) {
        $res['success'] = false;
        $res['error'] = 'Usted no tiene permiso para esta acción';
        if( $ajax==='ajax'){
			$this->layout = 'ajax';
			$this->set(compact('res') );
		}else{
			$this->redirect("/");
		}
    }
}
?>
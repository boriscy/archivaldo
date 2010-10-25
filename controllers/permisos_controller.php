<?php
class PermisosController extends AppController
{
    var $uses = array('Permiso', 'Usuario');
    /**
     *retorna la lista de permisos codificados en JSON
     */
    function index() {
        #Archivo a buscar
        $archivo_id = Sanitize::escape($this->params['form']['archivo_id']);
        $usuario_id = $this->Session->read('usuario_id');
        $this->Usuario->unbindModel(array('hasMany'=>array(
                                                        'Archivo', 'Categoria', 'Version')
                                           ) );
        $res = array();
        if($this->Permiso->Archivo->hasAny(array('Archivo.usuario_id'=>"$usuario_id",
                                                 'Archivo.id'=>"$archivo_id")) ){
            $permisos = $this->Permiso->buscarPermisos($archivo_id, $usuario_id);
            $i=0;
            foreach($permisos as $k=>$v){
                $res['data'][] = array(
                                    'usuario_id'=>$v['Usuario']['id'],
                                    'nombre'=>$v['Usuario']['nombre_c'],
                                    'permiso_id'=>$v['Permiso']['id'],
                                    'read'=>$v['Permiso']['read'],
                                    'write'=>$v['Permiso']['write']
                                    );
                $i++;
            }
            //$res['data'] = $this->Permiso->combineModels($permisos, 'Permiso', 'Usuario');
            $res['total'] = count($res['data']);
        }
        
        $this->set(compact('res'));
        $this->render('../comon/js');
    }
    
    /**
     *Permite la edición de permisos de un archivo
     */
    function edit(){
        $data = json_decode($this->data['permisos']);
        $archivo_id = $this->data['archivo_id'];
        $permiso = array();
        $this->Permiso->unbind();
        #Borrado de Pemisos
        $permisos = $this->Permiso->find('all', array('fields'=>array('Permiso.id'),
                                                      'conditions'=>array('Permiso.archivo_id'=>"$archivo_id")) );
        $permisos = Set::extract($permisos, "{n}.Permiso.id");
        
        $save = true;
        $this->Permiso->begin();
        
        foreach($data as $k=>$v) {
            
            $permiso = Set::__array($v);            
            #Borrar Permiso
            if(trim($permiso['permiso_id'])!=='' && $permiso['read']===false && $permiso['write']===false){
                if(!$this->Permiso->del($permiso['permiso_id']) ){
                    $save = false;
                }
            }else if($permiso['read']==true || $permiso['write']==true){
                
                $permiso['archivo_id'] = $this->data['archivo_id'];
                if($permiso['write']===true){
                    $permiso['read'] = true;
                }
                $this->Permiso->id = null;
                if(trim($permiso['permiso_id'])!=''){
                    $this->Permiso->id = $permiso['permiso_id'];
                }
                if(!$this->Permiso->save($permiso )){
                    $save = false;
                }
            }
        }
        
        if($save){
            $res['success'] = true;
            $this->Permiso->commit();
        }else{
            $res['success'] = false;
            $this->Permiso->rollback();
        }
        $this->set(compact('res'));
    }
}
?>
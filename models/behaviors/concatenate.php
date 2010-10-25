<?php
//
class ConcatenateBehavior extends  ModelBehavior
{
    var $settings;
    /**
     *Inicializa el behavior
     *@param object $model
     *@param array $settings
     *@return void
     */
    function setup(&$model, $settings = array() ) {
        if(isset($settings['fields']) && is_array($settings['fields']) && isset($settings['field'])){
            $this->settings['fields'] = $settings['fields'];
            $this->settings['field'] = $settings['field'];
            $this->mod = &$model;
        }else{
            debug('Error: You must set an array fields and field for the behavor');
        }
    }
    
    /**
     *@param object $model Modelo sobre el que se trabaja
     *@return string
     */
    function concatenate(&$model) {
        $value = array();
        foreach($this->settings['fields'] as $v){
            $value[] = trim($model->data[$model->name][$v]);
        }
        return join(' ', $value);
    }
    
    function beforeSave(&$model) {
        $verify = true;
        
        //Verificar si existen los campos como datos antes de realizar la actualizacion
        foreach($this->settings['fields'] as $v){
            if(!isset($model->data[$model->name][$v])){
                $verify = false;    
                break;
            }
        }
        
        if($verify) {
            $model->data[$model->name][$this->settings['field']] = $this->concatenate($model);            
        }
    }
}
?>
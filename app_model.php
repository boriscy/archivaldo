<?php
class AppModel extends Model
{
    //Elimina Todas las asociaciones de un tipo seleccionado
    //hasMany, belongsTo, hasOne, hasAndBelongsToMany
    function unbind($relationship=null)
    {
        $associations = array();
        #Unbind todos los Modelos
        if($relationship===null){
            $associations = $this->__associations;
        }elseif( is_string($relationship) && in_array($relationship, $this->__associations) ) {
            $associations[] = $relationship;
        }elseif(is_array($relationship) && in_array($relationship, $this->__associations)){
            foreach($relationship as $v){
                if(in_array($v, $this->__associations) )
                    $associations[] = $v;
            }
        }else{
            return false;
        }
        
        foreach($associations as $k=>$v) {
            $models = array();
                
            if( isset($this->{$v} ) && count($this->{$v})>0 ) {
                foreach($this->{$v} as $key=>$val)
                    $models[] = $key;
            }
            if(count($models) >0 )
                $this->unbindModel( array($v => $models) );
        }        
    }
    
    /**
     *Funcion que combina uno o mas arrays de Modelos y los retorna como un solo array
     *con nombres combinados ej(ModeloCampoId)
     *@param array $data Datos a ser combinados
     *@param function_get_args
     *@return array
     */
    function combineModels($data){
        //Recupera todos los Modelos (string)
        $arg = func_get_args();
        $tot = func_num_args();
        $ret = array();
        $num = 0;
        
        foreach($data as $v){
            for($i=1; $i<$tot; $i++) {                
                foreach($v[$arg[$i]] as $k=>$val){
                    #Se cameliza los nombres para que puedan lucir como llaves unicas
                    $nom = Inflector::camelize($arg[$i].'_'.$k);
                    $ret[$num][$nom] = $val;
                }
            }
            $num++;          
        }
        
        return $ret;
    }
}
?>
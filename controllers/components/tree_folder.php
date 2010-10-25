<?php
/***
 *Componente para la creación de arboles binarios y segun fecha
 *Boris Barroso <boriscyber@gmail.com>
 *Mayo 2008
 */
class TreeFolderComponent extends Object
{
    private $controller;
    
    function startup(&$controller)
    {
        $this->controller = &$controller;        
    }
    
    /**
     *Verifica si existe un directorio en una fecha para una ruta, si no existe
     *crea el directorio para la fecha
     *@param string $path
     *@param date $date
     *@param string $sep
     *@return bool
     */
    public function dateFolder($path, $date = '', $sep="/" ){
        $folder = new Folder($path);
        echo Helper::url($path);
        $ret = true;
        if($date == ''){
            $date = date("Y/m/d");
        }
        $fec = explode($sep, $date);
        $dir = "";
        $lista = array();
        foreach($fec as $v){
            $lista[] = $v;
            $dir = implode($sep, $lista);
            if(!is_dir($path.$dir)){
                if(!$folder->create($path.$dir, 0771)){
                    $ret = false;
                }
            }
        }
        
        echo $ret;
    }
    
    /**
     *Crea el folder del arbol binario
     *@param string $path Direccion en la cual se deb crear el arbol
     *@return bool
     */
    public function createBinaryFolder($path){
        $path = $this->createPath($path);
        $folder = new Folder($path);
        return $folder->create($path)==true;
    }
    
    /**
     *Creacion de arbol binario, retorna el siguiente elemento del arbol binario
     *@param string $dir Direccion o Path
     *@param int $max
     *@param string $join Union para el path
     *@return string
     */
    protected function createPath($dir, $max, $join="/"){
        $path = explode($join, $dir);
        $sw = false;
        $count = intval(count($path));
        
        for($j=$count; $j>0; $j--){
            
            if($path[$j-1]<$max){
                $sw = true;
            }
            $path[$j-1]++;
            if($j<$count){
                
                $path[$j] = 1;
            }
            
            if(!$sw && $path[0]>$max){
                
                for($k=0; $k<$count; $k++){
                    $path[$k] = 1;
                }
                $path[$count] = 1;
                $sw = true;
            }
            
            if($sw)
                break;
        }
        
        return implode($join, $path);
    }
}
?>
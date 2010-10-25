<?php
//
class TreeFolderBehavior extends  ModelBehavior
{
    private $defaultSettings = array(
                                /*defaultSettings por defecto
                                *Extensiones y detalles del archivo
                                */
                                'file'=>array(
                                   'allowMimetype' => true,
                                   'denyMimetype' => false,
                                   'allowExtension'=> true,
                                   'denyExtension' => array('php','cgi','asp',
                                                            'exe','sh','pl',
                                                            'py','com','rb','js',
                                                            'php3', 'php4', 'php5',
                                                            'asf','mp3', 'wma'),
                                   'maxSize'=>null,
                                   ),
                                #binaryTreeLog es el archivo donde se guarda los datos del arbol binario como ser
                                #(ej: 2008/06/01,1/1,1) fecha, directorio binario, numero de archivos en eldirectorio
                               'binaryTreeLog' => 'files/binaryTreeLog.txt',
                               'path' => 'file',#Lugar en el cual se almacenan los archivos
                               'name'=>'name', #nombre del archivo
                               'type' => 'type', #Tipo de archivo
                               'size' => 'size', #tamaño del archivo
                               'maxFiles' => 3, #Numero máximo de archivos y de directorios que se almacena en cada directorio
                            );
    
    /**
     *Inicializa el behavior verifica todos los defaultSettings y de que las direcciones sean correctas
     *@param object $model
     *@param array $defaultSettings
     *@return void
     */
    public function setup(&$model, $config = array() ) {
        #Se copia los valores de $config
        $this->settings = array_merge($this->defaultSettings, $config);
    }
    
    /**
     *Verifica si existe un directorio en una fecha para una ruta, si no existe
     *crea el directorio para la fecha
     *@param string $path Ruta en la cual se debe crear el directorio
     *@param date $date Fecha
     *@param string $sep Separador para la ruta del directorio
     *@return bool Retorna verdadero si es que se a creado correctamente los directorios Fecha
     */
    public function dateFolder($path, $date = '', $sep="/" ) {
        
        $folder = new Folder($path);
        $ret = true;
        #En caso de que no haya fecha se define la fecha del formato (2008/10/23)
        if($date == '') {
            $date = sprintf("%d$sep%02d$sep%02d" ,date("Y/m/d"));
        }
        $fec = explode($sep, $date);
        $dir = "";
        $lista = array();
        #Creación de direcotiro en forma recursiva en caso de existir el directorio no es creado
        foreach($fec as $v) {
            $lista[] = $v;
            $dir = implode($sep, $lista);
            if(!is_dir($path.$dir) ) {
                if(!$folder->create($path.DS.$dir, 0774) ) {
                    $this->log(sprintf("Error: No se pudo crear el directorio %s", $path.DS.$dir ));
                    $ret = false;
                }
            }
        }
        
        return $ret;
    }
    
    /**
     *Crea el folder del arbol binario
     *@param string $path Direccion en la cual se debe crear el arbol
     *@return bool Retorna correcto si se creo correctamente el directorio de arbol binario
     */
    public function createBinaryFolder() {
        
        $path = $this->createPath($path);
        $folder = new Folder($path);
        return $folder->create($path)==true;
    }
    
    /**
     *Creacion de arbol binario, retorna el elemento que corresponde en arbol binario
     *de manera secuencial (1, 2, 3, 1/1, 1/2, 1/3, 2/1)
     *@param string $dir Direccion o Path
     *@param int $max Numero maximo de directorios en el path
     *@param string $join Union para el path
     *@return string
     */
    public function createPath($dir, $max, $join="/") {
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
    
    /**
     *Acciones antes de guardar en el arboo Binario el directorio
     *@param object $model Modelo
     */
    public function beforeSave(&$model) {
        
        $ret = true;
        #Validación si es permitida Extension
        $f = new File($model->data[$model->name][$this->settings['name']]);
        $ext = $f->ext();
        if(in_array($ext, $this->settings['file']['denyExtension']) ) {
            $this->log('Extension denegada: '.$ext);
            $model->errors['nombre'] = "Extesión no permitida \"$ext\"";
            return false;
        }
        
        #Lectura del archivo de log
        $f = new File($this->settings['binaryTreeLog']);
        $contents = explode("\n", $f->read());
        list($date, $folder, $files) = explode(",",  $contents[0]);
        
        #Verificacion de la fecha
        $date2 = date("Y/m/d");
        #Crear directorio Fecha
        if($date!=$date2) {
            list($y,$m , $d) = explode("/", $date2);
            #Creacion de el directorios de Fecha
            $date = sprintf("%d/%02d/%02d", $y,$m , $d);            
            $ret = $this->dateFolder( $this->settings['path'], $date, DS);
            $folder = 1;
            $fold = new Folder();
            $ret = $fold->create($this->settings['path'].DS.$date.DS.$folder, 0774);
            if(!$ret)
                return false;
            $files = 0;
        }
        
        #Creacion de directorios binarios
        if(!($files < $this->settings['maxFiles']) ) {
            $folder = $this->createPath($folder, $this->settings['maxFiles']);
            $fold = new Folder();
            $ret = $fold->create($this->settings['path'].DS.$date.DS.$folder, 0774);
            $files = 0;
            if(!$ret) {
                return false;
            }
        }
        $path = $this->settings['path'].DS.$date.DS.$folder;
        $fileName = uniqid().'.'.$ext;
        $file = $this->settings['path'].DS.$date.DS.$folder.DS.$fileName;
        
        if( !move_uploaded_file($model->data[$model->name]['tmp_name'] , $file) ) {
            $this->log(sprintf("No se pudo subir: %s, con %s el directorio", $file, $files) );////
            $ret = false;
        }else{
            $files++;
            $model->data[$model->name][$this->settings['name']] = $file;
            $f = new File($this->settings['binaryTreeLog']);
            $ret = $f->write("$date,$folder,$files\n");
        }        
        
        return $ret;
    }
    
    /**
     *Acciones a realizar despues de haberse guardado en la base de datos la información del archivo
     *caso contrario se elimina el archivo que fue guardado para no crear archivos huerfanos
     *@param object $model Modelo
     *@param bool $created Indica si es que se almaceno correctamente
     *@return bool
     */
    function afterSave(&$model, $created){
        $ret = true;
        #Borrado en caso de que no se haya salvado correctamente para no dejar archivos huerfanos
        if(!$created) {
            $f = new File($model->data[$model->name][$this->settings['name']]);
            $ret = $f->delete();
            $this->log('Borrado el archivo '.$model->data[$model->name][$this->settings['name']]);
        }
        $this->log($model->data[$model->name][$this->settings['name']]);
        return $ret;
    }
    
    /**
     *Elimina el archivo que esta relaciona con el registro de la base de datos
     */
    public function afterDelete(&$model, $deleted) {
        if($deleted) {
            //
        }
    }
}
?>
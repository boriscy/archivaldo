<?php
//header('nombre: Archivaldo'); Se crea un ecabezado con variable nombre y valor Archivaldo
//Año
//$icon = new IconHelper();
$data = array();
$categorias = $this->requestAction('/categorias/lista/');
$usuarios = $this->requestAction('/usuarios/lista/');
foreach($archivos as &$v){
    $img = $icon->appIcon($v['type'],$v['nombre']);
    $v['nombre'] = $img.' '.$v['nombre'];
    $v['modified'] = dateFormat::mysql($v['modified'], true);
    $v['size'] = formatsize($v['size']);
}
$data = array('total'=>$count,'data'=>$archivos);
echo $javascript->object($data);
//Configure::write('debug',0);
?>
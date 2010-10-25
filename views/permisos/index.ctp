<?php
//$usuarios = $this->requestAction("/usuarios/lista/");
//$data = array();
$i = 0;
foreach($permisos as $k=>$v){
	$data[$i] = array(
						'usuario_id'=>$v['Usuario']['id'],
						'nombre'=>$v['Usuario']['nombre_c'],
						'permiso_id'=>$v['Permiso']['id'],
						'read'=>$v['Permiso']['read'],
						'write'=>$v['Permiso']['write']
						);
	$i++;
}
echo $javascript->object(array('total'=>$i, 'data'=>$data) );
?>
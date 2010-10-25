<?php
//$versiones = Set::extract($versiones,"{n}.Version");
$i = 0;
foreach($versiones as $k=>$v){
	$view[$i]['version_id'] = $v['Version']['id'];
	$view[$i]['numero'] = $v['Version']['numero'];
	$view[$i]['usuario'] = $v['Usuario']['nombre_c'];
	$view[$i]['modified'] = dateFormat::mysql($v['Version']['modified']);
	$view[$i]['size'] = formatsize($v['Version']['size']);
	$i++;
}
//$array['total'] = $i;
//$array['data'] = $view;
echo $javascript->object(array('total'=>$i, 'data' => $view));
//Configure::write('debug',0);
?>
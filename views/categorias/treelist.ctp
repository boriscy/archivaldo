<?php
$store = '';
foreach($cats as $k=>$v){
    $val = str_replace("-", "", $v, $count);
    $store.= "['$k','$val', '".str_repeat("MM",$count)."'],";
}
$store = substr($store,0,strlen($store)-1);
echo "[$store]";
?>
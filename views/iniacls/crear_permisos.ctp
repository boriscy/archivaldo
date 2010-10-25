<?php
$lista = array();
foreach($controladores as $k=>$v){
    $lista[$k] = $k;
    if(count($v)>0){
        foreach($v as $val){
            $lista[$k.'::'.$val] = $k.'::'.$val;
        }
    }
}
?>
<?php echo $form->create('Iniacls', array('action'=>'crearPermisos') );?>

<?php echo $form->label('Aro:');?>
<?php echo $form->select("Aro.alias",$aros);?>

<table>
    <tr>
        <th>Ruta</th>
        <th>Crear</th>
        <th>Leer</th>
        <th>Editar</th>
        <th>Borrar</th>
    </tr>
    <?php foreach($lista as $k=>$v):?>
    <tr>
        <td><?php echo $v?></td>
        <td><?php echo $form->checkbox("$k.create");?></td>
        <td><?php echo $form->checkbox("$k.read");?></td>
        <td><?php echo $form->checkbox("$k.update");?></td>
        <td><?php echo $form->checkbox("$k.delete");?></td>
    </tr>
    <?php endforeach;?>
</table>
<?php echo $form->submit('Ingresar');?>
<?php echo $form->end();?>
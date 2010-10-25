<style>
table{
    border-collapse:collapse;
}
th, td{
    border:1px solid #000;
    padding:3px;
}
th{font-weight:bold}
</style>
<table border="1" class="x-panel">
    <tr>
        <th>Modelo</th>
        <th>Alias</th>
    </tr>
<?php
foreach($acos as $k=>$v){
    echo "<tr><td>{$v['Aco']['model']}</td><td>{$v['Aco']['alias']}</td></tr>\n";
}
?>
</table>
<?php echo $form->create('Iniacl', array('action'=>'crearAco') );?>

<div>
<?php echo $form->label('Modelo:')?>
<?php echo $form->select('modelo', $this->requestAction('iniacls/listaModelos'))?>
</div>

<div>
<?php echo $form->label('Alias:')?>
<?php echo $form->text('alias')?>
</div>

<?php echo $form->submit('Ingresar'); ?>
<?php echo $form->end(); ?>

<?php ?>
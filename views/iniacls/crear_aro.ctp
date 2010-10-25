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
foreach($aros as $k=>$v){
    echo "<tr><td>{$v['Aro']['model']}</td><td>{$v['Aro']['alias']}</td></tr>\n";
}
?>
</table>
<?php echo $form->create('Iniacl', array('action'=>'crearAro') );?>

<div>
<?php echo $form->label('Alias:')?>
<?php echo $form->text('alias')?>
</div>

<?php echo $form->submit('Ingresar'); ?>
<?php echo $form->end(); ?>
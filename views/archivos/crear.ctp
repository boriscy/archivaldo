<?php
//ñ
echo $form->create('Archivo',array('type'=>'file','action'=>'add'))
?>
<?php echo $form->input('archivo',array('type'=>'file'))?>
<?php echo $form->submit()?>
<?php echo $form->end();?>
<?php
echo isset($archi['Archivo']['nombre'])?'true':'false';?>
<?php echo $form->create('Iniacl', array('action'=>'permisos')) ?>

<div>
<?php echo $form->label('Usuario');?>
<?php echo $form->select('usuario_id', $this->requestAction('/usuarios/lista/'), null, null, false); ?>
</div>

<div>
<?php echo $form->label('Nivel de Permiso:');?>
<?php echo $form->select('aros', $aros);?>
</div>

<?php echo $form->end();?>
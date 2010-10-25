<div class="permisos form">
<?php echo $form->create('Permiso');?>
	<fieldset>
 		<legend><?php __('Add Permiso');?></legend>
	<?php
		echo $form->input('usuarios_id');
		echo $form->input('archivo_id');
		echo $form->input('read');
		echo $form->input('write');
		echo $form->input('modify');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Permisos', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Usuarios', true), array('controller'=> 'usuarios', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Usuario', true), array('controller'=> 'usuarios', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Archivos', true), array('controller'=> 'archivos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Archivo', true), array('controller'=> 'archivos', 'action'=>'add')); ?> </li>
	</ul>
</div>

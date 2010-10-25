<style>
label{
	width:9em !important;
}
</style>
<div class="">
<?php echo $form->create('Usuario');?>
	<fieldset class="">
 		<legend><?php __('Crear Usuario');?></legend>
	<?php
		echo '<div class="input">';		
		echo $form->input('login', array('label' => 'Login:','class' => 'x-form-text x-form-field') );
		echo '</div><div class="input">';
		
		echo $form->input('pass', array('label' => 'Password:','class' => 'x-form-text x-form-field') );
		echo '</div><div class="input">';
		
		echo $form->input('nombres', array('label' => 'Nombres:', 'class' => 'x-form-text x-form-field') );
		echo '</div><div class="input">';
		
		echo $form->input('apellido_p', array('label' => 'Apellido Paterno:','class' => 'x-form-text x-form-field') );
		echo '</div><div class="input">';
		
		echo $form->input('apellido_m', array('label' => 'Apellido Paterno:','class' => 'x-form-text x-form-field') );
		echo '</div><div class="input">';
		$alias = array('Usuario' => 'Usuario', 'Admin' => 'Admin');
		
		echo $form->input('alias_acl', array('options'=>$alias, 'label'=>'Nivel:') );
		echo '</div>';
	?>
	</fieldset>
<?php echo $form->end('Ingresar');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Usuarios', true), array('action'=>'index'));?></li>
	</ul>
</div>

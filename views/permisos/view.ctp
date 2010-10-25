<div class="permisos view">
<h2><?php  __('Permiso');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permiso['Permiso']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Usuario'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($permiso['Usuario']['nombre_c'], array('controller'=> 'usuarios', 'action'=>'view', $permiso['Usuario']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Archivo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($permiso['Archivo']['nombre'], array('controller'=> 'archivos', 'action'=>'view', $permiso['Archivo']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Read'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permiso['Permiso']['read']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Write'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permiso['Permiso']['write']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modify'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permiso['Permiso']['modify']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permiso['Permiso']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permiso['Permiso']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Permiso', true), array('action'=>'edit', $permiso['Permiso']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Permiso', true), array('action'=>'delete', $permiso['Permiso']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $permiso['Permiso']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Permisos', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Permiso', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Usuarios', true), array('controller'=> 'usuarios', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Usuario', true), array('controller'=> 'usuarios', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Archivos', true), array('controller'=> 'archivos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Archivo', true), array('controller'=> 'archivos', 'action'=>'add')); ?> </li>
	</ul>
</div>

<div class="usuarios view">
<h2><?php  __('Usuario');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Login'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['login']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pass'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['pass']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombres'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['nombres']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Apellido P'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['apellido_p']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Apellido M'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['apellido_m']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre C'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['nombre_c']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Usuario', true), array('action'=>'edit', $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Usuario', true), array('action'=>'delete', $usuario['Usuario']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Usuarios', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Usuario', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Archivos', true), array('controller'=> 'archivos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Archivo', true), array('controller'=> 'archivos', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Categorias', true), array('controller'=> 'categorias', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Categoria', true), array('controller'=> 'categorias', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Versiones', true), array('controller'=> 'versiones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Version', true), array('controller'=> 'versiones', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Archivos');?></h3>
	<?php if (!empty($usuario['Archivo'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Categoria Id'); ?></th>
		<th><?php __('Usuario Id'); ?></th>
		<th><?php __('Nombre'); ?></th>
		<th><?php __('Descripcion'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Deleted'); ?></th>
		<th><?php __('Active'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($usuario['Archivo'] as $archivo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $archivo['id'];?></td>
			<td><?php echo $archivo['categoria_id'];?></td>
			<td><?php echo $archivo['usuario_id'];?></td>
			<td><?php echo $archivo['nombre'];?></td>
			<td><?php echo $archivo['descripcion'];?></td>
			<td><?php echo $archivo['created'];?></td>
			<td><?php echo $archivo['modified'];?></td>
			<td><?php echo $archivo['deleted'];?></td>
			<td><?php echo $archivo['active'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'archivos', 'action'=>'view', $archivo['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'archivos', 'action'=>'edit', $archivo['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'archivos', 'action'=>'delete', $archivo['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $archivo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Archivo', true), array('controller'=> 'archivos', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Categorias');?></h3>
	<?php if (!empty($usuario['Categoria'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuarios Id'); ?></th>
		<th><?php __('Parent Id'); ?></th>
		<th><?php __('Nombre'); ?></th>
		<th><?php __('Descripcion'); ?></th>
		<th><?php __('Lft'); ?></th>
		<th><?php __('Rght'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Deleted'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($usuario['Categoria'] as $categoria):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $categoria['id'];?></td>
			<td><?php echo $categoria['usuarios_id'];?></td>
			<td><?php echo $categoria['parent_id'];?></td>
			<td><?php echo $categoria['nombre'];?></td>
			<td><?php echo $categoria['descripcion'];?></td>
			<td><?php echo $categoria['lft'];?></td>
			<td><?php echo $categoria['rght'];?></td>
			<td><?php echo $categoria['created'];?></td>
			<td><?php echo $categoria['modified'];?></td>
			<td><?php echo $categoria['deleted'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'categorias', 'action'=>'view', $categoria['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'categorias', 'action'=>'edit', $categoria['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'categorias', 'action'=>'delete', $categoria['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $categoria['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Categoria', true), array('controller'=> 'categorias', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Versiones');?></h3>
	<?php if (!empty($usuario['Version'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuarios Id'); ?></th>
		<th><?php __('Archivo Id'); ?></th>
		<th><?php __('Numero'); ?></th>
		<th><?php __('Archivo'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Size'); ?></th>
		<th><?php __('Type'); ?></th>
		<th><?php __('Ultima'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($usuario['Version'] as $version):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $version['id'];?></td>
			<td><?php echo $version['usuarios_id'];?></td>
			<td><?php echo $version['archivo_id'];?></td>
			<td><?php echo $version['numero'];?></td>
			<td><?php echo $version['archivo'];?></td>
			<td><?php echo $version['created'];?></td>
			<td><?php echo $version['modified'];?></td>
			<td><?php echo $version['size'];?></td>
			<td><?php echo $version['type'];?></td>
			<td><?php echo $version['ultima'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'versiones', 'action'=>'view', $version['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'versiones', 'action'=>'edit', $version['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'versiones', 'action'=>'delete', $version['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $version['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Version', true), array('controller'=> 'versiones', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>

<div class="usuarios index">
<h2><?php __('Usuarios');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
	<caption><?php echo $html->link(__('Crear Usuario', true), array('action'=>'add')); ?></caption>
<tr class="x-window-tc">
	<th class="x-window-tl"><?php echo $paginator->sort('login');?></th>
	<th><?php echo $paginator->sort('Nombre','nombre_c');?></th>
	<th><?php echo $paginator->sort('Creado', 'created');?></th>
	<th class="x-window-tr"><?php __('Acciones');?></th>
</tr>
<?php
$i = 0;
foreach ($usuarios as $usuario):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $usuario['Usuario']['login']; ?>
		</td>
		<td>
			<?php echo $usuario['Usuario']['nombre_c']; ?>
		</td>
		<td>
			<?php echo $usuario['Usuario']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $usuario['Usuario']['id'])); ?>
			<?php echo $html->link(__('Borrar', true), array('action'=>'delete', $usuario['Usuario']['id']), null, sprintf(__('Esta seguro de borrar a %s?', true), $usuario['Usuario']['nombre_c'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('ant', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('sig', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
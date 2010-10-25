<?php echo $form->create('Archivo',array('action'=>'edit'))?>
<?php echo $form->label('Nuevo:').$form->textarea('nuevo')?>
<?php echo $form->submit()?>
<?php echo $form->end();?>

<?php
$search = array("\x00", "\x0a", "\x0d", "\x1a", "\x09");
$replace = array('\0', '\n', '\r', '\Z' , '\t');
$dat = str_replace($replace, $search, $this->data['Archivo']['nuevo']);
echo $dat."<hr/>\n";
$dat = Sanitize::escape($dat);
//$dat = str_replace($search, $replace,$dat);
echo $dat."<hr/>\n";
echo $this->data['Archivo']['nuevo'];
?>

<?php
header('Content-type: ' . $file['Archivo']['type']);
header('Content-length: ' . $file['Version']['size']);
header('Content-Disposition: attachment; filename="'.$file['Archivo']['nombre'].'"');
echo $file['Version']['archivo'];
?>
<?php Configure::write('debug',0);?>
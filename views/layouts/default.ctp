<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset('UTF-8');?>
<title><?php echo h($title_for_layout) ?></title>
<?php echo $html->css('/js/ext-2/resources/css/ext-all')."\n"; ?>
<?php echo $html->css('/js/ext-2/resources/css/xtheme-slate')."\n"; ?>
<style type="text/css">
body{
    height:100%;
    font-family:georgia;
}
</style>
<?php echo $html->css('extra'); ?>
<?php echo $html->css('Ext.ux.UploadDialog'); ?>

<?php echo $javascript->link('ext-2/adapter/ext/ext-base')."\n"; ?>
<?php echo $javascript->link('ext-2/ext-all-debug')."\n"; ?>
<?php echo $javascript->link('ext-2/resources/locale/ext-lang-sp')."\n"; ?>
<?php echo $javascript->link('Ext.ux.UploadDialog')."\n"; ?>

<script type="text/javascript">
Ext.BLANK_IMAGE_URL = '<?php echo $html->url('/js/ext-2/resources/images/default/s.gif') ?>';
Ext.MessageBox.buttonText.yes = "Si";
Ext.MessageBox.buttonText.cancel = "Cancelar";
Ext.QuickTips.init();
Ext.form.Field.prototype.msgTarget = 'side';
//Namespace de Archivaldo
Ext.namespace('A');
var pageSize = <?php echo PAGE_SIZE?>;
//Logo
if(Ext.Window){
    Ext.apply(Ext.Window.prototype, {iconCls:'archivaldo'});
}
</script>
</head>
<body>
    <?php echo $content_for_layout ?>
    
    <div id="debug"></div>
</body>
</html>
<?php echo $cakeDebug;?>
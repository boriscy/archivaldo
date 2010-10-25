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
    font-family:tahoma,arial,verdana,sans-serif;
    font-size:12px;
    background-color:#FFF;
}
#content{
    padding:10px;
}
table{
    boder-collapse:collapse;
    font-size:12px;
}
caption{
    font-weight:bold;
    text-align:center;
}
th, th a{
    color:#FFF;
    padding:2px;
    font-weight:bold;
    text-decoration:none;
}
td{
    padding:2px;
    border:1px solid #000;
}
form{
    font-family:tahoma,arial,verdana,sans-serif;
}
div.input{
    margin:4px;
}
label{
    display:block;
    float:left;
}
fieldset{
    border:2px solid #AABBCC;
}

</style>
<?php echo $html->css('extra'); ?>
</head>
<body>
    <div id="content">
    <?php
    if ($session->check('Message.flash')) {
		$session->flash();
	}
    
    echo $content_for_layout
    ?>
    </div>
</body>
</html>
<?php
Configure::write('debug', 0);
echo $cakeDebug;?>
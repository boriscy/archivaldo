<?php echo $javascript->link('login');?>
<script type="text/javascript">
Ext.onReady(function(){
    var login = new A.login({
        loginUrl:'<?php echo $html->url('/usuarios/login');?>',
        logoutUrl:'<?php echo $html->url('/usuarios/logout');?>',
        redirectUrl: '<?php echo $html->url('/categorias/');?>',
        imageLogo: '<?php echo $html->image('archi.png', array('align'=>'left', 'style'=>'margin:-4px 3px 0px 0px'));?>'
    });
    login.login();	
});
</script>

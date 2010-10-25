<?php
$data = array();
foreach($categorias as $k=>$v){
    $data[] = listArray($v);
}
$categorias = $data;//Set::extract($categorias, '{n}.Categoria');

#Creación de los nodos con el Helper
$categorias = $tree->extTree($categorias, array('id'=>'CategoriaId',
                                                'parent_id'=>'CategoriaParentId',
                                                'text'=>'CategoriaNombre',
                                                'CategoriaDescripcion',
                                                'CategoriaUsuarioId'));
//pr($categorias);
?>

<?php //echo $this->requestAction('/archivos/index',array('return'));?>
<?php echo $javascript->link(array('paging','tree', 'grid', 'usuario'))?>
<?php
#Categorias para adicionar nuevos archivos
$cats = $this->requestAction('/categorias/treelist/');

$store = '';
foreach($cats as $k=>$v){
    $val = str_replace("-", "", $v, $count);
    $store.= "['$k','$val', '".str_repeat("MM",$count)."'],";
}
$store = substr($store,0,strlen($store)-1);
?>
<script type="text/javascript">
//pageSize=2;//////////////////////////////
Ext.onReady(function(){
    /**
     *Funcion que permite presentar todo el programa una vez se haya logeado el usuario
     */
    function iniciar(){
        var g = new A.grid({
            loadUrl:'<?php echo $html->url('/archivos/view')?>',
            downloadUrl:'<?php echo $html->url('/versiones/download/')?>',
            uploadUrl:'<?php echo $html->url('/versiones/add'); ?>',
            versionesUrl:'<?php echo $html->url('/versiones/view')?>',
            pageSize:pageSize, 
            comboData:[<?php echo $store?>],
            comboUrl:'<?php echo $html->url('/categorias/treelist/') ?>',
            permisosUrl:'<?php echo $html->url('/permisos/index/') ?>',
            guardarPermisosUrl:'<?php echo $html->url('/permisos/edit/') ?>'
        });
        
        //Arbol
        var tree = new A.catTree({
            jsonTree:<?php echo $javascript->object($categorias)?>,
            comboData:<?php echo $this->requestAction('/usuarios/lista/ext');?>,
            reorderUrl:'<?php echo $html->url('/categorias/reorder/') ?>',
            reparentUrl:'<?php echo $html->url('/categorias/reparent/') ?>',
            deleteUrl:'<?php echo $html->url('/categorias/delete/');?>',
            addUrl:'<?php echo $html->url('/categorias/add/');?>',
            editUrl:'<?php echo $html->url('/categorias/edit/');?>',
            deleteUrl:'<?php echo $html->url('/categorias/delete/');?>',
            viewUrl:'<?php echo $html->url('/categorias/view/');?>',
            uploadUrl:'<?php echo $html->url('/archivos/add/');?>',
            grid:g.gridArchivos
        });
        
        var usuario = new A.usuarioPass({
            cambiarPassUrl:'<?php echo $html->url('/usuarios/cambiarPass/');?>',
            usuariosUrl:'<?php echo $html->url('/usuarios/');?>'
        });
        
        var SessAlias = '<?php echo $session->read('alias');?>'=='Admin'?false:true;
        
        /*
        if('<?php echo $session->read('alias');?>'=='Admin'){
            console.log('Admin');
        }else{
            console.log('Usuario');
        }*/
        //Panel principal
        
        
        var panel = new Ext.Viewport({
            id:'panelPrin',
            layout:'border',
            //renderTo:'panels',
            //height:600,
            items:[
                tree,
                {
                    xtype:'panel',
                    region:'center',
                    layout:'border',
                    margins: '5 5 5 5',
                    items:[
                        g.gridArchivos,
                        g.gridVersiones
                    ]
                },{
                    xtype:'panel', region:'north',
                    html:'<h2 class="x-panel-header" style="font-size:16px;height:22px"><?php echo $html->image('archi.png', array('align'=>'left', 'style'=>'margin:-4px 3px 0px 0px'));?> Archivaldo - <?php echo $session->read('nombre')?></h2>',id:'panelNorte',
                    margins:'5 5 0 5', 
                    bbar:[{
                        text:'Usuarios', iconCls:'user', disabled:SessAlias ,handler:function(){ usuario.mostrarUsuarios();}
                    },'-',{
                        text:'Cambiar Contraseña', iconCls:'pass', handler:function(){ usuario.show();}
                    },'-',
                    {
                        text:'Salir', iconCls:'logout',
                        handler: function(){
                            window.location = '<?php echo $html->url('/usuarios/logout')?>';
                        }
                    },'-']
                }
            ]
        });
        
        /***/
        /*dialog = new Ext.ux.UploadDialog.Dialog({
            url: 'upload-dialog-request.php',
            reset_on_hide: true,
            allow_close_on_upload: true,
            upload_autostart: false
        });
        dialog.show();*/
    }
    
    iniciar();
    //Fin de Iniciar
    Ext.getCmp("arbol").collapseAll();
    
    //console.log(login);
    //iniciar();
    
    //console.log(login.forma.getComponent('login'));
    
    //Verificacion de Refresh
    var ini = false;
<?php if($session->read('usuario_id')) { echo "ini = true;\n";}?>
    
    var horaFinal = new Date();
    horaFinal = horaFinal.add(Date.SECOND, 5);
    //Funcion general para poder Inicializar los Tokens
    
    /*Ext.Ajax.on('beforerequest', function(con, opt){
        var horaComp = new Date();
        /*
        if(horaComp.getTime() >= horaFinal.getTime()){
            horaFinal = new Date();//horaFinal.add(Date.SECOND, 5);
            horaFinal = horaFinal.add(Date.SECOND, 5);
            alert('5 segundos');            
        }else{
            horaFinal = horaFinal.add(Date.SECOND, 5);
        }*/
        
    /*    if(opt.form){
            //console.log(opt);
            opt.form.token.value = 'HJu636yHGjhe7467';
        }else{
            opt.params.token = 'HJu636yHGjhe7467';
        }
    });

    */
    //Funcion global para poder verificar todas las llamdas AJAX
    /*Ext.Ajax.on('requestcomplete', function(con, opt){
        try{
            var data = Ext.decode(opt.responseText);
            //console.log(opt);
            if(opt.getResponseHeader && ini==true){
                if(!opt.getResponseHeader.logged){
                    opt.responseText = '';
                    login.login();
                }
            }else if(data.__logged && ini==false){
                iniciar();
                ini=true;
                
            }else if(!data.__logged && ini==true){
                opt.responseText = '';
                login.login();
            }
        }
        catch(e){}
    });*/
});
</script>
<div id="panels"></div>
<!--<button id="login">Login</button>-->

<?php Configure::write('debug',0);?>

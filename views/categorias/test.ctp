<script type="text/javascript">
Ext.onReady(function(){
    Arbol = function(config){
        this.init(config);
    };
    Arbol.prototype = {
        id:'arbol',
        init:function(config){
            Ext.apply(this,config);
            this.crearVentana();
            this.crearBoton();
        },
        uno:'uno',
        dos:'dos',
        formaUrl:'',
        //Creación de ventana
        crearVentana:function(){
            if(!this.ventana){
                this.ventana = new Ext.Window({
                    id:'Ventana',
                    title:'Nueva Ventana',
                    closeAction:'hide',
                    width:350,
                    height:220
                    //items:[this.crearForma()]
                });
            }
            return this.ventana;
        },
        //Creación de Forma
        crearForma:function(){
            if(!this.forma){
                this.forma = new Ext.form.FormPanel({
                    id:'forma1',
                    title:'Forma',
                    height:200,
                    width:300,
                    url:'<?php echo $html->url('/archivos/test/')?>',
                    items:[{xtype:'textfield',name:"data[Categoria][nombre]",fieldLabel:'Nombre',width:200}],
                    buttons:[{xtype:'button',id:'botonForma',text:'Guardar', handler:this.guardar, scope:this}]
                });
            }
            return this.forma;
        },
        crearBoton:function(){
            /*Ext.get('boton').on({
                'click':{
                    scope:this,
                    fn:this.onClick
                }
            });*/
        },
        onClick:function(){
            this.ventana.show();
        },
        guardar:function(){
            //alert('Guardar');
            //console.log(this.forma);
            //alert(this.ventana.getXType());
            this.forma.form.submit({
                //url:'<?php echo $html->url('/archivos/test/')?>',
                success:function(a,b){
                    var temp = b.response;
                    var deb = Ext.getDom('debug');
                    //console.log(a);
                    //console.log(b);
                    //alert(b);
                    deb.innerHTML = b.response.responseText;
                    //for(var k in temp)deb.innerHTML+=k+'='+temp[k]+'<br/>';
                },
                failure:function(a,b){
                    //var temp = b;
                    //var deb = Ext.getDom('debug');
                    //for(var k in temp)deb.innerHTML+=k+'='+temp[k]+'<br/>';
                    alert(b);
                }
            });
        }
    };
    
    a = new Arbol({formaUrl:'forma.php'});
    //a.forma.buttons[0].on('click', function(){this.ventana.hide()}, a);    
    
    a.crearForma();
    a.forma.render('divForma');
    
    //var a = Ext.Msg.alert('Hola','Como estas');
    Ext.get(document.body).mask();
    setTimeout("Ext.get(document.body).unmask()",3000);
    //b = new Arbol({formaUrl:'Jeje.aspx',id:'arbol2'});
    //b.ventana.setPosition(100,100).show();
});





</script>
<button id="boton">Boton</button>
<div id="divForma"></div>
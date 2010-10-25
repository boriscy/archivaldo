A.usuarioPass = function(config){
    
    Ext.apply(this, config);
    
    /**
     *Creacion de la forma para cambiar password
     */
    this.forma = new Ext.FormPanel({
        id:'formaUsuario',
        baseCls:'x-panel',
        defaultType:'textfield',
        bodyStyle:'padding:10px;',
        labelWidth:120,
        maskDisabled:false,
        items:[{
            xtype:'hidden', name:'token', id:'token'
        },{
            inputType:'password', fieldLabel:'Contraseña', name:'data[Usuario][pass]', id:'usuarioPass'
        },{
            inputType:'password', fieldLabel:'Nueva Contraseña', name:'data[Usuario][nuevo_pass]', id:'nuevoPass'
        },{
            inputType:'password', fieldLabel:'Repita Contraseña', name:'data[Usuario][nuevo_pass2]', id:'nuevoPass2'
        }],
        buttons:[{
            text:'Guardar', scope:this, handler:this.cambiarPassSubmit
        }]
    });
    
    //Llamada al Parent
    A.usuarioPass.superclass.constructor.call(this, {
        title:'Cambiar Contraseña',
        closeAction:'hide',
        width:300,
        height:200,
        items:this.forma
    });
};
Ext.extend(A.usuarioPass, Ext.Window,{
    /**
     *Dirección para cambiar password
     */
    cambiarPassUrl:'',
    /**
     *
     */
    usuariosUrl:'',
    /**
     *Forma del PassWord
     */
    cambiarPass:function(){
        this.show();
        //return this.cambiarPassSubmit;
    },
    cambiarPassSubmit:function(){
        this.forma.getForm().submit({
            url:this.cambiarPassUrl,
            scope:this,
            success:function(){
                var i = 0;
                var cmp;
                while( this.forma.getComponent(i) ){
                    cmp = this.forma.getComponent(i);
                    if(cmp.getXType()=='textfield'){
                        cmp.reset();
                    }
                    i++;
                }
                this.hide();
                Ext.Msg.alert("Contraseña", "Se cambio correctamente su Contraseña");
                
                
            },
            failure:function(){
                Ext.Msg.show({title:'Error', msg:'No se pudo cambiar su Contraseña',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
            }
        });
    },
    mostrarUsuarios:function(){
        this.usuariosWin = new Ext.Window({
            title:'Usuarios',
            modal:true,
            resizable:false,
            width:750,
            height:500,
            html:'<iframe src="'+this.usuariosUrl+'" width="100%" height="100%"></iframe>'
        });
        this.usuariosWin.show();
    }
});
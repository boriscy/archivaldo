A.login = function(config){
    
    Ext.apply(this, config);
    
    this.forma = new Ext.FormPanel({
        id:'formaLogin',
        baseCls:'x-panel',
        defaultType:'textfield',
        bodyStyle:'padding:10px;',
        maskDisabled:false,
        items:[{
            xtype:'panel',html: '<h2 style="height:30px; padding:3px;font-size:14px;font-weight:bold">'+this.imageLogo+'Bienvenido a Archivaldo!!</h2>', border:false
        },{
            xtype:'hidden', name:'token', id:'token'
        },{
            fieldLabel:'Usuario', name:'data[Usuario][login]', id:'login'
        },{
            inputType:'password', fieldLabel:'Contraseña', name:'data[Usuario][pass]', id:'pass'
        }],
        buttons:[{
            text:'Ingresar', scope:this, handler:this.ingresar
        }]
    });
    
    A.login.superclass.constructor.call(this, {
        title:'Ingreso',
        closeAction:'hide',
        width:300,
        height:190,
        items:this.forma,
        modal:true,
        closable:false
    });
};
Ext.extend(A.login, Ext.Window,{
    /**
     *Dirección del login
     */
    loginUrl:'',
    /**
     *Dirección del logout
     */
    logoutUrl:'',
    /**
     *Lugar al cual se redirecciona una ves se haya validado el Login
     */
    redirectUrl:'',
    /**
     *Imagen, debe proveer con una imagen del logo Tag completo <img src="" alt=""/>
     */
    imageLogo:'',
    /**
     *realiza el ingreso
     */
    login:function(){
        this.show();
        return this.ingresar;
    },
    ingresar:function(){
        
        var forma = this.getComponent(0);
        
        forma.getForm().submit({
            url:this.loginUrl,
            scope:this,
            success:function(a, resp){
                this.hide();
                //Ext.getDom(this.domNode).innerHTML = resp.result.nombre;
                forma.getComponent('login').reset();
                forma.getComponent('pass').reset();
                window.location = this.redirectUrl;
                return false;
            },
            failure:function(){
                Ext.Msg.show({
                    title:'Error', msg:'Existio un Error, ingrese un login y pass correctos',
                    buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR
                });
            }
        });
    },
    salir:function(){
        //alert('Salir');
        Ext.Ajax.request({
            url:this.logoutUrl,
            params:{t:''},
            success:function(){},
            failure:function(){}
        });
    }
});

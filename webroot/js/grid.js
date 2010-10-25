/**
 *Plugin para presentar checkboxes en el Grid
 */
Ext.grid.CheckColumn = function(config){
    Ext.apply(this, config);
    if(!this.id){
        this.id = Ext.id();
    }
    this.renderer = this.renderer.createDelegate(this);
};

Ext.grid.CheckColumn.prototype ={
    init : function(grid){
        this.grid = grid;
        this.grid.on('render', function(){
            var view = this.grid.getView();
            view.mainBody.on('mousedown', this.onMouseDown, this);
        }, this);
    },

    onMouseDown : function(e, t){
        if(t.className && t.className.indexOf('x-grid3-cc-'+this.id) != -1){
            e.stopEvent();
            var index = this.grid.getView().findRowIndex(t);
            var record = this.grid.store.getAt(index);
            record.set(this.dataIndex, !record.data[this.dataIndex]);
        }
    },

    renderer : function(v, p, record){
        p.css += ' x-grid3-check-col-td'; 
        return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>';
    }
};
/**
 *A.grid
 *
 *Este objeto presenta ds grids uno que presenta los ultimos archivos gridArchivos y otros que presenta
 *las versiones gridVersiones ademas de una forma para poder realizar Uploads de nuevos archivos
 */
A.grid = function(config)
{
    this.init(config);
    
    /**********************************************
    *Grid de Permisos
    */
    var Permiso = new Ext.data.Record.create([
        {name:'usuario_id', type:'string'},
        {name:'nombre', type:'string'},
        {name:'permiso_id', type:'string'},
        {name:'read', type:'bool'},
        {name:'write', type:'bool'}
    ]);
    
    var store = new Ext.data.Store({
        pruneModifiedRecords:true,        
        proxy: new Ext.data.HttpProxy({url: this.permisosUrl}),
        reader: new Ext.data.JsonReader({
            root: 'data',
            totalProperty: 'total',
            id:'usuario_id',
            fields: [
                {name:'usuario_id'},
                {name: 'nombre'},
                {name: 'permiso_id'},
                {name: 'read'},
                {name: 'write'}
            ]
        }, Permiso)
    });
    store.baseParams.categoria_id = 'raiz';
    
    //Necesario crear estas variables para adicionar los plugins
    check1 = new Ext.grid.CheckColumn({
        header:'Lectura',
        width:60,
        dataIndex:'read',
        sortable:false
    });
    check2 = new Ext.grid.CheckColumn({
        id: 'write',
        header: 'Escritura',
        width: 60,
        dataIndex:'write',
        sortable:false
    });
   
    /*
    check2.on('click',function(){
        /*var gr = Ext.getCmp('gridPermisos');
        var css = gr.getView().getCell(0,2).firstChild.firstChild.className;
        var s = css.split(/\s/);
        
        if(s[0]=='x-grid3-check-col'){
        s[0] = 'x-grid3-check-col-on';
        }else{
        s[0] = 'x-grid3-check-col';
        }
        gr.getView().getCell(0,2).firstChild.firstChild.className = s.join(" ");//[0]+' '+s[1];    
    }, this);*/
    
    
    //Columna de Grid de Permisos
    var cm = new Ext.grid.ColumnModel([{
        id:'usuarioNombre',
        header:'Usuario',
        width:220,
        dataIndex:'nombre'
    },
        check1,
        check2
    ]);
    cm.defaultSortable = true;
    
    this.gridPermisos = new Ext.grid.EditorGridPanel({
        id:'gridPermisos',
        store: store,
        cm: cm,
        title:'Permisos',
        loadMask:true,
        plugins:[check1, check2],
        clicksToEdit:1,
        width:430,
        height:350
    });
    //console.log(this.gridPermisos.colModel);
    
    /*Fin Grid de permisos*/
    
    //Ventana para Grid Permisos
    this.ventanaPermisos = new Ext.Window({
        width:500,
        height:430,
        resizable:false,
        bodyStyle:'padding:15px',
        closeAction:'hide',
        items:this.gridPermisos,
        buttonAlign:'center',
        buttons: [new Ext.Button({text:'Guardar', scope:this, handler:this.guardarPermisos})]
    });
    
    /**************************************
    *Grid de Archivos
    */
    var dataStore = new Ext.data.Store({
        proxy: new Ext.data.HttpProxy({url: this.loadUrl}),
        reader: new Ext.data.JsonReader({
            root: 'data',
            totalProperty: 'total',
            id:'id',
            fields: [
                {name:'id'},
                {name:'version_id'},
                {name:'nombre'},
                {name:'nombre_c'},
                {name:'modified'},
                {name:'size'},
                {name:'categoria_nombre'}
            ]
        }),
        remoteSort:true
    });
    
    var colMod = new Ext.grid.ColumnModel([
        {hidden:true, hideable:false},
        {header: "Nombre", dataIndex: 'nombre',width:200, hideable:false},
        {header: "Creado Por", dataIndex: 'nombre_c', width:200, hideable:false},
        {header: "Modificado", dataIndex: 'modified',width:120, hideable:false},
        {header: "Tamaño", dataIndex:'size', width:100, hideable:false},
        {header: "Categoría", dataIndex: 'categoria_nombre', id:'categoria_nombre',width:200, sortable:false}
    ]);
    colMod.defaultSortable = true;
        
    //Creación del grid principal
    this.gridArchivos = new Ext.grid.GridPanel({
        id:'grid1',
        ds: dataStore,
        cm: colMod,
        stripeRows: true,
        minHeight: 350,
        height:350,
        title: 'Achivos',
        layout:'fit',
        region:'center',
        loadMask:true,
        autoExpandColumn: 1,
        bbar: new Ext.PagingToolbar({
            beforePageSizeText: 'Mostar',
            afterPageSizeText:'archivo(s)',
            showAllText:'Mostrar todo en una sola Página',
            pageSize: this.pageSize,
            store: dataStore,
            displayInfo: true,
            displayMsg: 'Archivos {0} - {1} de {2}',
            emptyMsg: "No hay Archivos"
        }),
        listeners:{
            rowclick: {scope:this, fn:this.rowClick},
            rowdblclick: {scope:this, fn:this.rowDblClick},
            rowcontextmenu: {scope:this, fn: this.crearGridArchivosContexto}
        }
    });
    this.gridArchivos.store.load({params:{start:0, limit:this.pageSize}});
    /*Fin de grid de archivos*/
    
}
//Extends
A.grid.prototype = {
    /**
     *@cfg string Url del cual carga el grid1
     */
    loadUrl:'',
    /**
     *@cfg string Url del cual se obtienen los datos del gridArchivos
     */
    downloadUrl:'',
    /**
     *@cfg string Url para subir archivos
     */
    uploadUrl:'',
    /**
     *@cfg string Url para que el gridVersiones
     */
    versionesUrl:'',
    /**
     *@cfg int cuantos archivos se presenta el en gridArchivos
     */
    pageSize:10,
    /**
     *@cfg array Datos del combo para seleccionar la categoría
     */
    comboData:[],
    /**
     *@cfg string Url del cual debe cargar el Combo los datos
     */
    comboUrl:'',
    /**
     *@cfg string Url para obtener los datos para el grid de permisos
     */
    permisosUrl:'',
    /**
     *@cfg string Url para guardar los datos de Permisos
     */
    guardarPermisosUrl:'',
    /**
     *@param Es donde se almacena la fila actual
     */
    currentRow:null,
    /**
     *Sirve para poder identificar si hicieron doble click
     */
    clicked:false,
    /**
     *Incializa todos los datos y llama a las funciones necesarias para crear los elementos
     *@param object config Objeto con valores de configuración
     */
    init:function(config){
        Ext.apply(this, config);
        //this.crearGridArchivos();
        //this.gridArchivos.store.load({params:{start:0, limit:this.pageSize}});
        this.crearGridVersiones();
        this.crearForma();
        this.ventana.hide();
    },
    /**
     *Forma para poder realizar uploads
     */
    crearForma:function(){
        if(!this.forma){
            //Template para presentar el combo con espacios simulando la estructura del arbol
            var template = new Ext.XTemplate(
                '<tpl for="."><div class="x-combo-list-item">',
                    '<span style="color:#FFF">{space}</span>{nombre}',
                '</div></tpl>'
            );
            var cat = new Ext.data.SimpleStore({
                fields: ['categoria_id', 'nombre','space'],
                data :this.comboData,
                url:this.comboUrl
            });
            this.forma = new Ext.form.FormPanel({
                url:this.uploadUrl,
                fileUpload:true,
                timeout:15000,
                id:'formaUpload',
                maskDisabled:false,
                labelWidth:120,
                items:[{
                    xtype:'hidden', name:'token', id:'token'
                },{
                    xtype:'hidden', name:'data[Version][archivo_id]', id:'ArchivoId'
                },{
                    html:'Hola', id:'ArchivoNombre', cls:'x-form-field bold center'
                },{
                    xtype:'textfield', fieldLabel:'Seleccionar Archivo',id:'archivo',
                    name:'data[Version][file]', inputType: 'file', allowBlank:false,
                    width:350, height:25, minLength:5,
                    listeners:{
                        blur:function(f){
                            var val = f.getValue();
                            if(val.match(/^[a-z]:\\.*/i) ){
                                //alert(val.replace(/^.*\\(.*)/, "$1"));
                            }else{
                                //alert('UNIX');
                            }
                        }
                    }
                }],
                buttons:[{
                    text:'Guardar', scope:this, handler:this.guardarDatos
                },{
                    text:'Cancelar', scope:this, handler: function(){ this.ventana.hide();}
                }]
            });
            //Creación de la ventana que contiene la Forma para hacer uploads
            this.ventana = new Ext.Window({
                title:'Subir Nueva Versión',
                id:'winUpload',
                width:550,
                height:200,
                labelWidth:130,
                margins:'5 5 5 5',
                layout:'fit',
                resizable:false,
                buttonAlign:'center',
                defaults:{bodyStyle:'padding:10px'},
                closeAction:'hide',
                items:[this.forma]
            });
        }
        
        //Cargar datos importares en la forma
        if(this.gridArchivos){
            var grid = this.gridArchivos.getSelectionModel();
            var datos = grid.getSelected().data;
            //nombre = nombre.replace(/<.* \/> (.*)$/, "$1");
            this.forma.findById('ArchivoId').setValue(datos.id);
            Ext.getDom('ArchivoNombre').innerHTML = datos.nombre;
        }
        this.ventana.show();
        return this.ventana;
    },
    /**
     *Guarda los datos de la Forma de Upload
     */
    guardarDatos:function(){
        this.forma.getForm().submit({
            waitMsg:'Subiendo Archivo...',
            scope:this,
            success: function(a,b) {
                Ext.Msg.alert('Estado','Su Archivo fue almacenado correctamente');
                this.forma.getComponent('archivo').reset('');
                this.ventana.hide();
                this.gridArchivos.store.reload();
            },
            failure: function(a,b) {
                try {
                    var res = Ext.decode(b.response.responseText);
                    Ext.Msg.show({title:'Error', msg:'Existio un Error al guardar los datos. '+res.error,buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
                } catch(e) {
                    Ext.Msg.show({title:'Error', msg:e,buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
                }
            }
        });
    },
    /**
     *Barra contextual de el gridArchivos
     */
    crearGridArchivosContexto:function(g, i, e){
        this.currentRow = i;
        var index = i;
        if(!this.gridArchivosContexto){
            //Barra contextual que permitira hacer downloads
            this.gridArchivosContexto = new Ext.menu.Menu({
                id:'menuContextualGridArchivos',
                items:[
                    {
                        text:'Cargar Versiones', scope: this, iconCls:'refresh',
                        handler: this.cargarVersiones
                    },{
                        text:'Editar Permisos', scope: this, iconCls:'edit-image',
                        handler: function(){
                            var nombre = this.gridArchivos.store.getAt(this.currentRow).data.nombre;
                            //Borrar todo el store para recargar asi si existen errores no presenta el anterior grid
                            this.gridPermisos.store.removeAll();
                            nombre = nombre.replace(/(<.*\/>)\s([\w\s\áéíóúñ]*\.\w+)/i, "$2")
                            this.ventanaPermisos.setTitle('Permisos - '+nombre);
                            this.gridPermisos.store.baseParams.archivo_id = this.gridArchivos.store.getAt(this.currentRow).data.id;
                            this.gridPermisos.store.reload();
                            this.ventanaPermisos.show();
                            //console.log(this.gridPermisos.store);
                        }
                    },{
                        text:'Subir Nueva Versión', scope: this, iconCls:'upload',
                        handler: this.crearForma
                    },{
                        text:'Descargar Archivo', scope: this, iconCls:'download',
                        handler: function(){this.download(g); }
                    }
                ]
            });
        }
        e.stopEvent();
        this.gridArchivosContexto.showAt(e.getXY());
        this.gridArchivos.getSelectionModel().selectRow(i);
        return this.gridArchivosContexto;
    },
	/**
     *Grid en el cual se presentan las versiones de un archivo
     */
    crearGridVersiones:function(){
        if(!this.gridVersiones){
            var dataStore = new Ext.data.Store({
                proxy: new Ext.data.HttpProxy({url: this.versionesUrl}),
                reader: new Ext.data.JsonReader({
                    root: 'data',
                    totalProperty: 'total',
                    id:'id',
                    fields: [
                        {name:'version_id'},
                        {name:'numero'},
                        {name:'usuario'},
                        {name:'modified'},
                        {name:'size'}
                    ]
                }),
                remoteSort:true
            });
            var colMod = new Ext.grid.ColumnModel([
                {header: "Nº", dataIndex: 'numero',width:30},
                {header: "Creado Por", dataIndex: 'usuario', width:200},
                {header: "Modificado", dataIndex: 'modified',width:120},
                {header: "Tamaño", dataIndex:'size', width:100}
            ]);
            //Segundo grid en el cual se presenta versiones    
            this.gridVersiones = new Ext.grid.GridPanel({
                id:'gridVersiones',
                ds: dataStore,
                cm: colMod,
                stripeRows: true,
                height: 300,
                title: 'Versiones',
                layout:'fit',
                loadMask:true,
                autoExpandColumn: 1,
                region:'south',
                collapsible:true,
                animCollapse:false,
                listeners:{
                    rowcontextmenu:{scope:this, fn:function(g, i, e){this.crearGridVersionesContexto(g, i, e);}},
                    rowdblclick:{scope:this, fn:this.onDblClickGrid2}
                }
            });
        }
        return this.gridVersiones;
	},
    /**
     *Menú contextual de gridVersiones
     */
    crearGridVersionesContexto:function(g, i, e){
        this.currentRow = i;
        if(!this.gridVersionesContexto){
            this.gridVersionesContexto = new Ext.menu.Menu({
                id:'menuContextualGridVersiones',
                items:[
                    {
                        text:'Descargar Archivo', scope: this, iconCls:'download',
                        handler: function(){this.download(g, i);}
                    }
                ]
            });
        }
        e.stopEvent();
        this.gridVersionesContexto.showAt(e.getXY());
        this.gridVersiones.getSelectionModel().selectRow(i);
        return this.gridVersionesContexto;
    },
    /**
     *funcion que permite el download de archivos
     *@param object xtype:grid Puede ser cualquiera de los grids
     *@param int i fila en la que se realizo el evento
     */
    download:function(g){
        var version_id = g.store.getAt(this.currentRow).data.version_id;
        window.location = this.downloadUrl+version_id;
    },
    /**
     *Carga en el gridVersiones las versiones de un archivo
     */
    cargarVersiones:function(){
        if(this.clicked){
            this.gridVersiones.store.baseParams.archivo_id = this.gridArchivos.store.getAt(this.currentRow).id;
            this.gridVersiones.store.reload();
        }else{
            alert(this.clicked);
        }
    },
    /**
     *Selecciona la fila y presenta las versiones de un archivo
     */
    rowClick:function(g, i, e){
        this.currentRow = i;
        this.clicked = true;
        this.cargarVersiones();
    },
    /**
     *Permite realizar la descarga del archivo seleccionado
     */
    rowDblClick:function(g, i, e){
        this.clicked = false;
        this.download(g, i, e);
    },
    /**
     *Llama a Proceso de decarga y selecciona la fila
     */
    onDblClickGrid2:function(g, i, e){
        this.currentRow = i;
        this.download(g);
    },
    /**
     *Almacena los permisos de un documento, se obtiene del store del grid los datos
     */
    guardarPermisos:function(){
        var temp = this.gridPermisos.store.getModifiedRecords();
        var tot = temp.length;
        if(temp.length<1){
            Ext.Msg.show({title:'Error', msg:'Usted no puede modificar los permisos de este archivo',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
            this.ventanaPermisos.hide();
            return false;    
        }
        var data = new Array;
        
        for(var i=0; i<temp.length; i++){
            //Almacena solo los datos Modificados
            /*if(temp[i].data.read==1 || temp[i].data.write==1){
                dat = temp[i].data;//data.push(temp[i]);
                //data.push({usuario_id: dat.usuario_id, permiso_id:dat.permiso_id, read:dat.read, write:dat.write});
            }*/
            data.push(temp[i].data);
        }
        
        var para = Ext.util.JSON.encode(data);
        var archivo_id = this.gridPermisos.store.baseParams.archivo_id;
        Ext.Ajax.request({
            url:this.guardarPermisosUrl,
            params:{"data[permisos]":para, "data[archivo_id]": archivo_id},
            success:function(resp, request) {
                var r = Ext.decode(resp.responseText);
                if (r.success){
                    Ext.Msg.alert('Permisos','Los datos fueron almacenados');
                }else{
                    request.failure();
                }
                
            },
            failure:function(){
                Ext.Msg.show({title:'Error Permisos', msg:'Existio un Error al guardar los datos de Permisos',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
            }
        });
    },
    /**
     *Da formato al nombre
    */
    formatNombre:function(val){
        return val.substr(0,40);
    }
};
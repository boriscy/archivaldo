/**
 *A.catTree
 *
 *Este es un objeto el cual presenta un arbol que permite crear, editar, borrar, reordenar y reparentar
 *nodos
 */
A.catTree = function(config){
    //this.init(config);
    Ext.apply(this, config);
    
    this.arbolToolbar = new Ext.Toolbar({
        items:[{
            text: 'Crear',
            iconCls: 'add-image',
            handler: this.crearNodo,
            scope:this
        },{
            text:'Editar',
            iconCls:'edit-image',
            handler: this.editarNodo,
            scope:this
        
        },{
            text:'Borrar',
            iconCls:'del-image',
            handler: this.borrarNodo,
            scope:this
        }]
    });
    
    //Llamada a parent
    A.catTree.superclass.constructor.call(this,{
        id:'arbol',
        width:300,
        height:300,
        tbar:this.arbolToolbar,
        enableDD:true,
        autoScroll:true,
        region:'west',
        collapsible:true,
        title:'Categorías',
        margins:'5 0 5 5',
        cmargins:'5 0 5 5',
        selModel: new Ext.tree.MultiSelectionModel(),
        loader: new Ext.tree.TreeLoader(),
        animCollapse:false,
        listeners:{
            click:{fn:this.onClick, scope:this},
            dblclick:{fn:this.onDblClick, scope:this},
            contextmenu:{fn:this.onContextMenu, scope:this},
            startdrag:{fn:this.onStartDrag, scope:this},
            movenode:{fn:this.onMoveNode, scope:this}
        },
        root:new Ext.tree.TreeNode({
            text: 'NPEH',
            draggable:false,
            expanded:true,
            id:'raiz'
        })
    });
    this.init();
};
Ext.extend(A.catTree, Ext.tree.TreePanel,{
    /**
     *@cfg string direccion de adicion de nuevos nodos
     */
    addUrl:'',
    /**
     *@cfg string direccion de editar datos de un nodo
     */
    editUrl:'',
    /**
     *@cfg string direccion para borrar un nodo
     */
    deleteUrl:'',
    /**
     *@cfg string direccion para reordenar
     */
    reorderUrl:'',
    /**
     *@cfg string direccion de reparent
     */
    reparentUrl:'',
    /**
     *@cfg string direccion de uploads de archivos nuevos
     */
    uploadUrl:'',
    /**
     *@cfg object nodos para crear el arbol a partir de un objeto JSON
     */
    jsonTree:[],
    /**
     *@cfg array con una lista de usuarios
     */
    comboData:[],
    /**
     *@cfg nodo seleccionado
     */
    currentNode:null,
    /**
     *@cfg GridPanel el cual es actualizado al hacer click en una categoría
     */
    grid:null,
    /**
     *Crea los nodos del arbol a partir de un JSON estatico
     */
    init:function(){
        //Creación de nodos del Arbol
        for(var i = 0, len = this.jsonTree.length; i < len; i++) {
            this.root.appendChild( this.getLoader().createNode( this.jsonTree[i] ) );
        }
    },
    /**
     *Crea el menu contextual del arbol
     */
    crearArbolContextMenu:function(){
        if(!this.arbolContextMenu){
            this.arbolContextMenu = new Ext.menu.Menu({
                id:'tree-ctx',
                items: [{
                    id:'crearNodo',
                    iconCls:'add-image',
                    text:'Crear Categoría',
                    handler:this.crearNodo,
                    scope:this
                },{
                    id:'editarNodo',
                    iconCls:'edit-image',
                    text:'Editar Categoría',
                    handler:this.editarNodo,
                    scope:this
                },{
                    id:'borrarNodo',
                    text:'Borrar Categoría',
                    iconCls:'del-image',
                    handler:this.borrarNodo,
                    scope:this
                },{
                    id:'subirArchivosNodo',
                    text:'Subir Archivos',
                    iconCls:'upload',
                    handler:this.crearUploadDialog,
                    scope:this
                }]
            });
        }
        this.currentNode.select();
        return this.arbolContextMenu;
    },
    /**
     *Crea la ventana y dentro la forma para poder editar y crear nuevos nodos
     *Se encuentran los siguientes valores
     *@param string url xtype:hidden Url de edición
     *@param string parent_id xtype:hidden  parentId del nodo
     *@param string id xtype:hidden ID del nodo
     *@param string nombre xtype:textfield ID del nodo
     *@param string usuarioId xtype:combo id del usuario del encargado
     *@param string descripcion xtype:textarea
     */
    crearForma:function(){
        if(!this.ventana){
            var comboStore = new Ext.data.SimpleStore({
                fields: ['usuario_id', 'nombre'],
                data :this.comboData
            });
            this.ventana = new Ext.Window({
                id:'treeVentana',
                width:450,
                height:300,
                maskDisabled:false,
                //maskMsg:'Guardando',
                margins:'5 5 5 5',
                layout:'fit',
                resizable:false,
                buttonAlign:'center',
                defaults:{bodyStyle:'padding:10px'},
                closeAction:'hide',
                items:[{
                    xtype:'form',id:'treeForma',url:this.addUrl,
                    items:[{
                        xtype:'hidden', name:'token', id:'token'
                    },{
                        xtype:'hidden',id:'url'
                    },{
                        xtype:'hidden',id:'CategoriaParentId', name:'data[Categoria][parent_id]'
                    },{
                        xtype:'hidden',id:'CategoriaId', name:'data[Categoria][id]'
                    },{
                        xtype:'textfield',id:'CategoriaNombre',name:'data[Categoria][nombre]',fieldLabel:'Nombre',width:300
                    },{
                        xtype:'combo',
                        id:'CategoriaUsuarioId',
                        hiddenName:'data[Categoria][usuario_id]',
                        name:'usuario_id',
                        fieldLabel:'Encargado',
                        triggerAction:'all',
                        mode:'local',
                        store:comboStore,
                        valueField:'usuario_id',
                        displayField:'nombre',
                        forceSelection:true,
                        width:300/*,
                        listeners:{
                            select:function(combo){ alert(combo.value);}
                        }*/
                    },{
                        xtype:'textarea',id:'CategoriaDescripcion',name:'data[Categoria][descripcion]',
                        fieldLabel:'Descripción',width:300,height:150
                    }]
                }],
                buttons:[{
                    text:'Guardar',scope:this, handler:this.guardarDatos
                },{
                    text:'Cancelar', scope:this, handler: function(){ this.ventana.hide();}
                }]
            });
            //this.ventana.getComponent('treeForma').add({xtype:'textfield', fieldLabel:'Nuevo', id:'token'});
        }
        return this.ventana;
    },
    /**
     *Almacena los datos que de la forma
     */
    guardarDatos:function(){
        var frm = this.ventana.getComponent('treeForma');
        var url = frm.getComponent('url').getValue();
        //Parent
        if(url == this.addUrl){
            var parent = this.currentNode.id;
            if(parent == 'raiz'){
                parent = '';
            }
            frm.getComponent('CategoriaParentId').setValue( parent );
        }
        
        frm.getForm().submit({
            url:url,
            scope:this,
            waitMsg:'Guardando...',
            success:function(a,b){
                
                if(url==this.addUrl){
                    
                    var node = new Ext.tree.TreeNode({
                        id: b.result.data.CategoriaId,
                        text: b.result.data.CategoriaNombre,
                        cls:'album-node',
                        allowDrag:true,
                        leaf:'[]',
                        CategoriaParentId: b.result.data.CategoriaParentId,
                        CategoriaDescripcion: b.result.data.CategoriaDescripcion,
                        CategoriaUsuarioId: b.result.data.CategoriaUsuarioId
                    });
                    this.currentNode.appendChild(node);
                    this.currentNode.expand();
                    this.currentNode.leaf = false;
                    this.currentNode = node;
                    frm.getComponent('url').setValue(this.editUrl);
                    frm.getComponent('CategoriaId').setValue(b.result.data.CategoriaId);
                    //Recargar el Combo del grid para hacer uploads
                    this.recargarComboGrid();
                }else{
                    
                    this.currentNode.setText(b.result.data.CategoriaNombre);
                    this.currentNode.attributes.CategoriaUsuarioId = b.result.data.CategoriaUsuarioId;
                    this.currentNode.attributes.CategoriaDescripcion = b.result.data.CategoriaDescripcion;
                }
                //Ext.Msg.alert('Estado', 'Datos guardados correctamente');
            },
            failure:function(a,b){
                Ext.Msg.show({title:'Error', msg:'Existio un Error al guardar los datos',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
            }
        });
        this.ventana.hide();
    },
    /**
     *crear un nuevo nodo
     *Se debe cambiar el url al de adición de nodos
     *y tambien el id dejar vacio
     */
    crearNodo:function(){
        this.crearForma();
        var forma = this.ventana.getComponent('treeForma');
        forma.getComponent('url').setValue(this.addUrl);
        forma.getComponent('CategoriaParentId').setValue(this.currentNode.id);
        forma.getComponent('CategoriaId').setValue('');        
        forma.getComponent('CategoriaNombre').setValue('');
        forma.getComponent('CategoriaUsuarioId').setValue('');
        forma.getComponent('CategoriaDescripcion').setValue('');
        this.ventana.setTitle('Crear Categoría');
        this.ventana.show();        
    },
    /**
     *edita un nodo seleccionado
     *Se debe cambiar el url al de edición de nodos
     */
    editarNodo: function(){
        if(this.currentNode==null){
            Ext.Msg.show({title:'Advertencia', msg:'Seleccione una categoría',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ALERT});
            return false;
        }
        if(this.currentNode.id=='raiz'){
            Ext.Msg.show({title:'Advertencia', msg:'Debe seleccionar otra categoría',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ALERT});
            return false
        }
        
        //Llamar a crear forma
        this.crearForma();
        
        var forma = this.ventana.getComponent('treeForma');
        forma.getComponent('url').setValue(this.editUrl);
        forma.getComponent('CategoriaId').setValue(this.currentNode.id);
        //forma.getComponent('CategoriaParentId').setValue(this.currentNode.parentNode.id);
        forma.getComponent('CategoriaNombre').setValue(this.currentNode.text);
        forma.getComponent('CategoriaUsuarioId').setValue(this.currentNode.attributes.CategoriaUsuarioId);
        forma.getComponent('CategoriaDescripcion').setValue(this.currentNode.attributes.CategoriaDescripcion);
        this.ventana.setTitle('Editar Nodo: '+this.currentNode.text);
        return this.ventana.show();        
    },
    /**
     *borra un nodo seleccionado
     */
    borrarNodo:function(){
        if(this.currentNode==null){
            alert('Selecione un nodo');
            return false;
        }
        if(this.currentNode.id=='raiz'){
            Ext.Msg.show({title:'Advertencia', msg:'No puede borrar esta categoría',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ALERT});
            return false
        }
        if(this.currentNode.childNodes.length>0){
            Ext.Msg.show({title:'Advertencia', msg:'No puede borrar esta categoría, elija una sin sub categorías',
                         buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ALERT});
            return false;
        }
        
        var url = this.deleteUrl;
        var nodo = this.currentNode;
        var del = false;
        
        Ext.Msg.confirm('Borrar', 'Esta seguro de Borrar la Categoría "'+this.currentNode.text+'"?',function(conf){                
            if(conf=='yes'){
                this.disable();
                Ext.Ajax.request({
                    url: url,
                    params: {'id':nodo.id},
                    scope: this,
                    success:function(res, request){
                        try {
                            var resp = Ext.decode(res.responseText);
                            if(resp.success==1){
                                nodo.remove();
                                del = true;
                            }else{
                                Ext.Msg.show({title:'Error', msg:'Existion un error al Borrar, intente de nuevo',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
                            }
                            this.enable();
                        } catch(e) {
                            Ext.Msg.show({title:'Error', msg:'Existio un Error En el servidor ',buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
                            this.enable();
                        }
                        return false;
                    },
                    failure:function(){
                        this.enable();
                        Ext.MessageBox.show({title:'Error',  msg:'No se borro la Categoría Seleccionada', buttons: Ext.MessageBox.OK, icon:Ext.MessageBox.ERROR});
                    }
                });
            }
        }, this);
        if(del){
            this.currentNode = this.root;
        }
        return false;
    },
    onClick:function(node, e){
        this.currentNode = node;
        //Recarga del store del grid
        this.grid.store.baseParams.categoria_id = node.id;
        this.grid.store.reload();
        //Para poder seleccionar encargado
        var nom = '';
        if(node.attributes.usuario_id!=''){
            var t = this.comboData;
            for(var i=0;i < t.length; i++){
                if(node.attributes.usuario_id==t[i][0]){
                    nom = ' - "'+t[i][1]+'"';
                    break;
                }
            }
        }
        this.grid.setTitle('Archivos - '+node.text+nom);
    },
    onDblClick:function(node, e){
        this.currentNode = node;
        this.editarNodo();
    },
    onContextMenu:function(node, e){
        this.currentNode = node;
        e.stopEvent();
        this.crearArbolContextMenu();
        this.arbolContextMenu.showAt(e.getXY());
    },
    /**
     *Almacena datos antes de realizar el drag de un nodo
     */
    onStartDrag:function(tree, node, e){
        oldPosition = node.parentNode.indexOf(node);
        oldNextSibling = node.nextSibling;
    },
    /**
     *Funcion que permite hacer el reparent o el reorder de los nodos del arbol
     */
    onMoveNode:function(tree, node, oldParent, newParent, position){
        if (oldParent == newParent){
            if((position - oldPosition)==0){
                return false;
            }
            var url = this.reorderUrl;
            var params = {'id':node.id, 'delta':(position - oldPosition)};
        }else
        {
            var url = this.reparentUrl;
            var params = {'id':node.id, 'parent_id':newParent.id, 'position':position};
        }
        this.disable();
        var arbol = this;
        
        Ext.Ajax.request({
            url:url,
            params:params,
            scope:this,
            success:function(resp, request) {
                var r = Ext.decode(resp.responseText);
                if (r.success != 1){
                    request.failure(resp, request);
                }
                //this.recargarComboGrid();
                arbol.enable();
            },
            failure:function(resp, request) {
                //Terminar eventos en caso de falla
                var r = Ext.decode(resp.responseText);
                //alert(this.id);//
                //console.log(this);
                arbol.suspendEvents();
                oldParent.appendChild(node);
                if (oldNextSibling){
                    oldParent.insertBefore(node, oldNextSibling);
                }
                arbol.resumeEvents();
                arbol.enable();
                Ext.Msg.alert('Error', r.error);
                Ext.Msg.show({title:'Error', msg: r.error, buttons: Ext.MessageBox.OK,icon:Ext.MessageBox.ERROR});
            }            
        });
    },
    /**
     *Recarga el combo de la forma
     *#Ya no es necesario por la forma en que se hacen los uploads
     *
    recargarComboGrid:function(){
        var combo = Ext.getCmp('GridCategoriaId');        
        combo.store.reload();
    },*/
    /**
     *Crea la forma par ahacer upload multiples uploads
     *Descripcion en el archivo Ext.ux.UploadDialog.js
     */
    crearUploadDialog: function(){
        //Creación del UploadDialog si es que no existe
        if(!this.uploadDialog){
            this.uploadDialog = new Ext.ux.UploadDialog.Dialog({
                url: this.uploadUrl,
                reset_on_hide: true,
                allow_close_on_upload: true,
                upload_autostart: false,
                width: 600
            });
        }
        
        this.uploadDialog.setTitle('Subir Archivos a Categoría: '+this.currentNode.text);
        this.uploadDialog.base_params.categoria_id = this.currentNode.id;
        this.uploadDialog.show();
        
    }
});

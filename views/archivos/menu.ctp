<script type="text/javascript">
Ext.namespace('A');


Ext.onReady(function()
{    
    var h = Ext.get(document.body).getSize().height;
    var ht = '';
    for(var i=1;i<=100;i++) ht += i+'.-Hola como estas<br/>';
    //var tree = new A.tree();
    
    //var win = new Nueva({title:'Ventana Oficial'});//{title:'Ventana Extend',height:200,html:'Prueba de un HTML'});
    //win.show();
    //tree.render();
    //alert(tree.root.id);
    
    
    var panel = new Ext.Panel({
        id:'panel',
        bodyBorder:true,
        layout:'border',
        items:[
            {id:'westPanel',title:'West',html:'West Panel',region:'west',width:300,layout:'fit',
            collapsible:true,split:true,margins:'5 0 5 5'
            },{
                layout:'fit',html:ht,border:false,region:'center',title:'Jejeje',
                autoScroll:true,margins:'5 5 5 0'
            },{
                region:'south',title:'Sur',html:'Prueba de HTML'
            }
        ]
    });
    
    var panel2 = new Ext.Viewport({
        id:'panPrin',
        title:'Principal Panel',
        layout:'border',
        title:'Panel Principal',
        items:[
            {region:'north',html:'<h1 class="x-panel-header">Panel del Norte</h1>',autoHeight: true},
            {region:'center',xtype:'tabpanel',margins:'10 10 10 10',activeTab:0,
            items:[
                {title:'Futuro',layout:'fit',
                items:[
                    panel
                ]},
                {title:'Tab 1',html:'<h1 class="x-panel-header">Segundo Tab</h1>'},
                {title:'Nuevo Tab Panel',html:'Buena cosa'}
                ]
            }
        ]
    });
    
});

</script>

<div id="panels"></div>
<?php Configure::write('debug',0); ?>
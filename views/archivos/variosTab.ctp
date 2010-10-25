<style>
.a{
	border:1px dashed #6F6FDF;
}
</style>
<script type="text/javascript">
/***Tab Close****/
Ext.ux.TabCloseMenu = function(){
    var tabs, menu, ctxItem;
    this.init = function(tp){
        tabs = tp;
        tabs.on('contextmenu', onContextMenu);
    }

    function onContextMenu(ts, item, e){
        if(!menu){ // create context menu on first right click
            menu = new Ext.menu.Menu([{
                id: tabs.id + '-close',
                text: 'Close Tab',
                handler : function(){
                    tabs.remove(ctxItem);
                }
            },{
                id: tabs.id + '-close-others',
                text: 'Close Other Tabs',
                handler : function(){
                    tabs.items.each(function(item){
                        if(item.closable && item != ctxItem){
                            tabs.remove(item);
                        }
                    });
                }
            }]);
        }
        ctxItem = item;
        var items = menu.items;
        items.get(tabs.id + '-close').setDisabled(!item.closable);
        var disableOthers = true;
        tabs.items.each(function(){
            if(this != item && this.closable){
                disableOthers = false;
                return false;
            }
        });
        items.get(tabs.id + '-close-others').setDisabled(disableOthers);
        menu.showAt(e.getPoint());
    }
};
///////////////////////////////////
    
Ext.onReady(function(){
    
    var tabs2 = new Ext.TabPanel({
        renderTo: document.body,
        activeTab: 0,
        width:600,
        height:450,
        plain:true,
        defaults:{autoScroll: true},
        items:[{
                title: 'Tab 1',id:'tab-1',
                html: "My content was added during construction."
            },{
                title: 'Árbol',id:'tree-tab',listeners: {activate: handleActivate}, html:'',closable:true
            },{
                title: 'Tab 2',id:'tab-3',listeners: {activate: handleActivate}, html:'Je',closable:true
            },{
                title: 'Tab 3',id:'tab-4',listeners: {activate: handleActivate}, html:'Ji',closable:true
            },{
                title: 'Tab 4',id:'tab-5',listeners: {activate: handleActivate}, html:'Jo',closable:true
            }
        ],
        plugins:new Ext.ux.TabCloseMenu()
    });
    
    function loadScript(url)
    {
        var e = document.createElement("script");
        e.src = url;
        e.type="text/javascript";
        e.id ="borrar";
        document.getElementsByTagName("head")[0].appendChild(e);
    }

    function handleActivate(tab){
        if(tab.id=='tree-tab'){
            loadScript('<?php echo $html->url('/categorias/index/'); ?>');
        }
    }
    var mos = Ext.get('mostrar');
    mos.on('click',function(){
        tabs2.items[3].show();
    });
    var ocu = Ext.get('ocultar');
    ocu.on('click',function(){
        var deb = Ext.getDom('debug');
        deb.innerHTML = '';
        var elem = tabs2.items.itemAt(0);
        //for(var k in elem)deb.innerHTML+=k+'='+elem[k]+'<br/>';
        elem.disable();
    });
});
</script>
<button id="mostrar">Mostrar</button>
<button id="ocultar">Ocultar</button>
<div id="debug"></div>




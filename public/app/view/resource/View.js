/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.view.resource.View', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.resourceview',

    layout: 'border',

    title: '资源管理',
    id: 'resourceView',

    initComponent: function() {
        var me=this;

        me.categoryTreeMenu = new Ext.menu.Menu({
            id: 'categoryTreeMenu',
            items: [
                {text:"添加", action:'categoryadd'},
                {text:"编辑", action:'categoryedit'},
                {text:"删除", action:'categorydelete'}
            ]
        });

        me.categoryTree=Ext.widget('treepanel', {
            title: '分类',
            region: 'west',
            collapsible: true,
            rootVisible: true,
            store: 'CategoryTree',
            width: 200,
            minWidth: 100,
            split: true,
            displayField: 'Name',
            tbar: [
                {text:'刷新', action:'categoryrefresh'}
            ],
            viewConfig: {
                listeners: {
                    scope: me,
                    refresh: me.onTreeRefresh,
                    cellcontextmenu: function(node, td, cellIndex, record, tr, rowIndex, e, eOpts){
                        e.preventDefault();
                        this.categoryTreeMenu.record = record;
                        this.categoryTreeMenu.showAt(e.getXY());
                    },
                    containercontextmenu: function(node, e, eOpts) {
                        e.preventDefault();
                    }
                }
            },
            listeners: {
                scope: me,
                selectionchange: me.onTreeSelect
            }
        });

        me.resourceGrid=Ext.widget('grid', {
            title: '资源',
            region: 'center',
            minHeight: 200,
            tbar: {
                xtype: 'pagingtoolbar',
                store: 'Resource',
                displayInfo:true
            },
            selModel: {mode:'MULTI'},
            selType: 'checkboxmodel',
            store: 'Resource',
            collapsible: true,
            columns: [
                {text:'资源Id', dataIndex:'Id'},
                {text:'Identifier', dataIndex:'Identifier', width:120},
                {text:'类型', dataIndex:'Type'},
                {text:'名称', dataIndex:'Name', sortable:false, flex:1},
                {text:'创建时间', dataIndex:'CreateTime', sortable:false,  width:140, xtype:'datecolumn', format:'Y-m-d H:i:s'},
                {text:'修改时间', dataIndex:'UpdateTime', sortable:false,  width:140, xtype:'datecolumn', format:'Y-m-d H:i:s'}
            ],
            viewConfig: {
                listeners: {
                    scope: me,
                    refresh: me.onResourceRefresh
                }
            },
            listeners: {
                scope: me,
                selectionchange: me.onResourceSelect
            }
        });

        this.items=[
            me.categoryTree,
            me.resourceGrid
        ];

        this.callParent(arguments);
    },

    onTreeRefresh: function() {
        //this.tree.view.select(0);
    },

    onTreeSelect: function(model, sels) {
        if(sels.length>0) {
            var rs = sels[0],
                store = this.resourceGrid.store;
            //store.clearFilter(true);
            //store.addFilter({property:"CategoryId", value:rs.data.Id}, false);
            store.proxy.extraParams.CategoryId = rs.data.Id;
            //this.detailsGrid.store.loadRecords([]);
            store.load();
        }
    },

    onResourceRefresh: function() {
        /*if(this.resourceGrid.store.getCount()>0) {
            this.resourceGrid.view.select(0);
        }*/
    },

    onResourceSelect: function(model, sels) {
        /*var me=this;
        if(sels.length>0) {
            var rs = sels[0],
                g=me.detailsGrid;
//            g.store.loadRecords(rs.ResourceDetailsStore.data.items);
        }*/
    }
});
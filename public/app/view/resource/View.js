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

    title: '资源管理',
    id: 'resourceView',

    layout: {
        type: 'border',
        regionWeights: {
            west:       20,
            north:      10,
            center:     0,
            south:      -10,
            east:       -20
        }
    },

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
            region: 'north',
            minHeight: 200,
            height: 300,
            collapsible: true,
            split: true,
            tbar: {
                xtype: 'pagingtoolbar',
                store: 'Resource',
                displayInfo: true,
                items: [
                    '|',
                    {text:'增加', action:'resourceadd', disabled:true},
                    {text:'编辑', action:'resourceedit', disabled:true},
                    {text:'删除', action:'resourcedelete', disabled:true}
                ]
            },
            selModel: {mode:'MULTI'},
            selType: 'checkboxmodel',
            store: 'Resource',
            columns: [
                {text:'资源Id', dataIndex:'Id'},
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

        me.resourceInfo=Ext.widget('panel', {
            title: '描述',
            region: 'center',
            bodyPadding: 5,
            autoScroll: true,
            minHeight: 100,
            height: 100,
            bodyStyle: {
                background: '#DFE8F6'
            },
            split: true
        })

        me.resourceAccountGrid=Ext.widget('grid', {
            minHeight: 200,
            store: 'ResourceAccount',
            selModel: {
                mode: 'MULTI',
                selType: 'cellmodel'
            },
            plugins: [new Ext.grid.plugin.CellEditing({
                clicksToEdit: 1
            })],
            region: 'south',
            split: true,
            tbar: {
                xtype: 'pagingtoolbar',
                store: 'ResourceAccount',
                displayInfo: true,
                items: [
                    '|',
                    {text:'关联', action:'resourceaccountassociate', disabled:true},
                    {text:'移除', action:'resourceaccountdelete', disabled:true}
                ]
            },
            columns: [
                {text:'账号ID', dataIndex:'AccountId', sortable:false},
                {text:'账号标识', dataIndex:'Identifier', sortable:false, flex:1},
                {text:'密码', dataIndex:'Password', sortable:false, flex:1, editor: {allowBlank: false}},
                {text:'关联时间', dataIndex:'CreateTime',  width:140, xtype:'datecolumn', format:'Y-m-d H:i:s'},
            ],
            listeners: {
                scope: me,
                selectionchange: me.onResourceAccountSelect
            }
        });

        this.items=[
            me.categoryTree,
            me.resourceGrid,
            me.resourceInfo,
            me.resourceAccountGrid
        ];

        this.callParent(arguments);
    },

    onTreeRefresh: function() { },

    onTreeSelect: function(model, sels) {
        var me = this;
        if(sels.length>0) {
            var rs = sels[0],
                store = this.resourceGrid.store;
            me.resourceGrid.down('button[action=resourceadd]').setDisabled(rs.data.Id == -1);
            me.resourceGrid.down('button[action=resourceedit]').setDisabled(true);
            me.resourceGrid.down('button[action=resourcedelete]').setDisabled(true);
            me.resourceGrid.CategoryId = rs.data.Id;
            store.proxy.extraParams.CategoryId = rs.data.Id;
            store.load();
        }
    },

    onResourceRefresh: function() { },

    onResourceSelect: function(model, sels) {
        var me = this,
            isSel = sels.length>0;
        // change CURD buttons status
        me.resourceGrid.down('button[action=resourceedit]').setDisabled(!isSel);
        me.resourceGrid.down('button[action=resourcedelete]').setDisabled(!isSel);
        me.resourceAccountGrid.down('button[action=resourceaccountassociate]').setDisabled(!isSel);
        // change Resource detail
        var description = '';
        if(isSel) {
            var rs = sels[0];
            description = rs.data.Description;
        }
        me.resourceInfo.update(description);
        // change Resource associate accounts
        var store = me.resourceAccountGrid.store;
        if(isSel) {
            me.resourceAccountGrid.ResourceId = rs.data.Id;
            store.proxy.extraParams.ResourceId = rs.data.Id;
            store.load();
        } else {
            me.resourceAccountGrid.ResourceId = null;
            store.removeAll();
        }
    },

    onResourceAccountSelect: function(model, sels) {
        var me = this,
            isSel = sels.length>0;
        me.resourceAccountGrid.down('button[action=resourceaccountdelete]').setDisabled(!isSel);
    }
});
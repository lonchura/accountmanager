/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.view.account.View', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.accountview',

    title: '账号管理',
    id: 'accountView',
    store: 'Account',
    selType: 'checkboxmodel',
    selModel: {mode: 'MULTI'},

    initComponent: function() {
        var me = this;

        me.paging = Ext.widget('pagingtoolbar', {
            id: 'accountPaging',
            store: me.store,
            displayInfo: true,
            items: [
                '|',
                {text:'增加', action:'accountadd'},
                {text:'编辑', action:'accountedit', disabled:true},
                {text:'删除', action:'accountdelete', disabled:true}
            ]
        });

        me.tbar = me.paging;

        me.columns = [
            {text:'ID', dataIndex:'Id', width:60},
            {text:'标识', dataIndex:'Identifier', width:240, sortable:false},
            {text:'创建时间', dataIndex:'CreateTime', sortable:false, flex:1, xtype:'datecolumn', format:'Y-m-d H:i:s'},
            {text:'修改时间', dataIndex:'UpdateTime', sortable:false, flex:1, xtype:'datecolumn', format:'Y-m-d H:i:s'}
        ];

        this.callParent(arguments);

        me.on('selectionchange', me.onSelectionChange);
    },

    onSelectionChange: function(seltype, rs) {
        var me = this,
            flag = !(rs.length>0);
        me.paging.down('button[action=accountedit]').setDisabled(flag);
        me.paging.down('button[action=accountdelete]').setDisabled(flag);
    }
});
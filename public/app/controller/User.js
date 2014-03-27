/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.controller.User', {
    extend: 'Ext.app.Controller',

    models: ['User'],
    stores: ['User', 'RoleCombo'],
    views: ['user.View', 'user.EditView'],

    refs: [
        {ref:'contentPage', selector:'#contentPage'}
    ],

    init: function() {
        var me = this,
            view = me.getUserViewView(),
            c = me.getContentPage();

        me.control({
            '#userView': {
                render: me.onPanelRendered
            },
            '#userView button[action=useradd]': {
                click: me.userAdd
            },
            '#userView button[action=useredit]': {
                click: me.userEdit
            },
            '#userView button[action=userdelete]': {
                click: me.userDelete
            }
        });
        c.add(view);
    },

    userAdd: function(btn) {
        var me = this,
            win = me.getEditView(),
            f = win.form,
            m = me.getUserStore().model;
        f.getForm().api.submit = AccountManager.Direct.User.add;
        f.getForm().actionMethod = 'add';
        f.loadRecord(new m());
        win.setTitle('添加用户');
        win.show();
    },

    userEdit: function(btn) {
        var me = this,
            sels = me.grid.getSelectionModel().getSelection();
        if(sels.length>0) {
            var rs = sels[0],
                win = me.getEditView(),
                f = win.form;
            f.getForm().api.submit = AccountManager.Direct.User.edit;
            f.getForm().actionMethod = 'edit';
            f.getForm().loadRecord(rs);
            win.setTitle('编辑用户');
            win.show();
        } else {
            Ext.Msg.alert('提示信息', '请选择一条记录进行编辑。');
        }
    },

    userDelete: function(btn) {
        var grid = this.grid,
            sels = grid.getSelectionModel().getSelection();
        if(sels.length>0) {
            var content = ['确定删除以下用户？'];
            for(var i=0; ln=sels.length,i<ln; i++) {
                content.push(sels[i].data.Name);
            }
            Ext.Msg.confirm('删除记录', content.join('<br />'), function(btn) {
                if(btn == 'yes') {
                    var me = this,
                        store = me.store,
                        ids = [],
                        sels = me.getSelectionModel().getSelection();
                    for(var i=0; ln=sels.length,i<ln; i++) {
                        ids.push(sels[i].data.UserId);
                    }
                    AccountManager.Direct.User.delete(ids, function(result, e) {
                        if(result.success) {
                            Ext.Msg.alert('删除成功', '已成功删除', function() {
                                me.store.load();
                            });
                        } else {
                            Ext.Msg.alert('提示信息', result.msg);
                        }
                    })
                }
            }, grid);
        }
    },

    getEditView: function() {
        var me = this,
            view = me.editview;
        if(!view) {
            view = me.editview = Ext.widget('usereditview');
        }
        return view;
    },

    onPanelRendered: function(panel) {
        var me = this,
            c = me.getContentPage();
        me.grid = panel;

        c.getLayout().setActiveItem(panel);
    }
});